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
               ->where('ads.deleted_at', null)
               ->orderBy('ads.created_at', 'DESC')
               ->paginate(12);

        $promoted = db_connect()
                ->table('ads')
                ->select('ads.*, 
                    (SELECT url FROM ad_images 
                    WHERE ad_images.ad_id = ads.id 
                    ORDER BY is_primary DESC, sort_order ASC 
                    LIMIT 1) AS image_url')
                ->join('ad_promotions', 'ad_promotions.ad_id = ads.id')
                ->where('ads.status', 'active')
                ->where('ads.deleted_at', null)
                ->where('ad_promotions.finished_at >', date('Y-m-d H:i:s'))
                ->where('(ads.impression_limit IS NULL OR ads.view_count < ads.impression_limit)')
                ->orderBy('ad_promotions.created_at', 'DESC')
                ->limit(6)
                ->get()
                ->getResultArray();

        return $this->loadWithNotifications('home/index', [
            'title' => 'Clasificados',
            'ads'   => $ads,
            'pager' => $adModel->pager,
            'promoted' => $promoted,
        ]);
    }
}