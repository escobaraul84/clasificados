<?php

namespace App\Controllers;

use App\Models\AdModel;
use App\Models\AdImageModel;
use CodeIgniter\Controller;
use CodeIgniter\I18n\Time;
use Ramsey\Uuid\Uuid;

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
}