<?php

namespace App\Controllers;

use App\Models\AdModel;
use App\Models\CategoryModel;

class HomeController extends BaseController
{
    public function index()
    {
        $adModel = new AdModel();
        $ads = $adModel->select('ads.*, users.full_name as user_name, 
                (SELECT url FROM ad_images 
                 WHERE ad_images.ad_id = ads.id 
                 ORDER BY is_primary DESC, sort_order ASC 
                 LIMIT 1) AS image_url')
               ->join('users', 'users.id = ads.user_id')
               ->where('ads.status', 'active')
               ->orderBy('ads.created_at', 'DESC')
               ->paginate(12);
        
        // dentro de index()
        $notifs = db_connect()
           ->table('notifications')
           ->where('user_id', session()->get('user_id') ?? 0)
           ->where('is_read', 0)
           ->orderBy('created_at', 'DESC')
           ->get()->getResultArray();

        $data = [
            'title'   => 'Clasificados',
            'ads'     => $ads,
            'pager'   => $adModel->pager,
            'notifs'  => $notifs,   // ← nueva línea
        ];

        return view('home/index', $data); 
    }
}