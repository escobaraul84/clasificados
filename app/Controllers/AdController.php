<?php

namespace App\Controllers;

use App\Models\AdModel;
use App\Models\AdImageModel;
use CodeIgniter\Controller;
use CodeIgniter\I18n\Time;
use Ramsey\Uuid\Uuid;
use App\Models\UserModel; 
//use App\Controllers\UserModel;

use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class AdController extends Controller
{
    protected $helpers = ['form', 'url', 'text'];

    // Listado de anuncios (público)
    public function index()
    {
        $adModel = new AdModel();
        $ads = $adModel->select('ads.*, users.full_name as user_name')
                       ->join('users', 'users.id = ads.user_id')
                       ->where('ads.status', 'active')
                       ->orderBy('ads.created_at', 'DESC')
                       ->paginate(12);

        return view('ad/index', [
            'ads'  => $ads,
            'pager'=> $adModel->pager,
        ]);
    }

    // Ver un anuncio
    public function show($slugId)
    {
        [$id, $slug] = explode('-', $slugId, 2);

        $adModel = new AdModel();
        $ad = $adModel->select('ads.*, users.full_name as user_name')
                      ->join('users', 'users.id = ads.user_id')
                      ->where('ads.id', $id)
                      ->where('ads.status', 'active')
                      ->first();

        if (!$ad) {
            return redirect()->to('/')->with('error', 'Anuncio no encontrado.');
        }

        $images = (new AdImageModel())
                  ->where('ad_id', $ad['id'])
                  ->orderBy('sort_order', 'asc')
                  ->findAll();

        return view('ad/show', ['ad' => $ad, 'images' => $images]);
    }

    // Formulario para crear
    public function create()
    {
        $categories = (new \App\Models\CategoryModel())->where('is_active', 1)->findAll();
        return view('ad/create', ['categories' => $categories]);
    }

    // Guardar nuevo anuncio
    public function store()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        $rules = [
            'title'       => 'required|min_length[5]|max_length[150]',
            'category_id' => 'required|is_natural_no_zero',
            'price'       => 'required|decimal',
            'description' => 'required|min_length[10]',
            'images'      => 'uploaded[images]|max_size[images,2048]|is_image[images]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $adModel = new AdModel();
        $adId = $adModel->insert([
            'uuid'          => Uuid::uuid4()->getBytes(),
            'user_id'       => session()->get('user_id'),
            'category_id'   => $this->request->getPost('category_id'),
            'title'         => $this->request->getPost('title'),
            'slug'          => url_title($this->request->getPost('title'), '-', true),
            'description_md'=> $this->request->getPost('description'),
            'price'         => $this->request->getPost('price'),
            'status'        => 'active',
            'created_at'    => Time::now()->toDateTimeString(),
            'updated_at'    => Time::now()->toDateTimeString(),
        ]);

        // Subir imágenes
        $files = $this->request->getFiles('images');
        $imageModel = new AdImageModel();

        // Carpeta pública
        $publicPath = ROOTPATH . 'public/uploads';
        if (!is_dir($publicPath)) {
            mkdir($publicPath, 0755, true);
        }

        foreach ($files['images'] as $k => $file) {
            if ($file->isValid() && !$file->hasMoved()) {
                $newName = $file->getRandomName();
                $file->move($publicPath, $newName);

                $imageModel->insert([
                    'ad_id'      => $adId,
                    'url'        => '/uploads/' . $newName,
                    'sort_order' => $k,
                    'is_primary' => $k === 0 ? 1 : 0,
                ]);
            }
        }
        return redirect()->to("/ad/$adId-" . url_title($this->request->getPost('title'), '-', true))
                         ->with('success', '¡Anuncio publicado!');
    }
    //CAMBIADO DE NOMBRE contact a contactPush para usarlo cuando se implemente push
    public function contactPush($adId)
    {
        $adModel = new AdModel();
        $ad = $adModel->find($adId);

        if (!$ad) {
            return redirect()->to('/')->with('error', 'Anuncio no encontrado.');
        }

        $vendedorId = $ad['user_id'];
        $vendedor = (new UserModel())->find($vendedorId);

        if (!$vendedor) {
            return redirect()->to('/')->with('error', 'Vendedor no encontrado.');
        }

        // Enviar notificación push
        $this->sendPushNotification($vendedor['email'], 'Contacto nuevo', 'Alguien quiere contactarte por tu anuncio ' . $ad['title']);

        return redirect()->to("/ad/$adId-" . url_title($ad['title'], '-', true))
                         ->with('success', '¡Mensaje enviado!');
    }

    private function sendPushNotification($email, $title, $message)
    {
        $apiKey = 'jkai4tn22exmvscomqud77eix';
        $appId = '"14de340e-e828-435e-b006-0fe78f275fea"';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json; charset=utf-8',
            'Authorization: Basic ' . $apiKey
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array(
            'app_id' => $appId,
            'contents' => array('en' => $message),
            'headings' => array('en' => $title),
            'include_external_user_ids' => array($email)
        )));

        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }
    public function contact($adId)
    {
        $adModel = new AdModel();
        $ad = $adModel->find($adId);

        if (!$ad) {
            return redirect()->to('/')->with('error', 'Anuncio no encontrado');
        }

        // Guardar notificación
        $db = \Config\Database::connect();
        $db->table('notifications')->insert([
            'user_id'    => $ad['user_id'],
            'buyer_id'   => session()->get('user_id'),
            'ad_id'      => $adId,
            'message'    => 'Alguien quiere contactarte por tu anuncio: ' . $ad['title'],
            'created_at' => Time::now()->toDateTimeString()
        ]);

        // Redirigir al perfil
        return redirect()->to("/profile/{$ad['user_id']}")
                     ->with('success', 'Ahora puedes contactar al vendedor');
    }
    public function markRead()
    {
        if (!session()->get('logged_in')) return $this->response->setJSON(['ok' => false]);

        db_connect()->table('notifications')
            ->where('user_id', session('user_id'))
            ->where('is_read', 0)
            ->update(['is_read' => 1]);
        return $this->response->setJSON(['ok' => true]);
    }
}