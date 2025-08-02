<?php
namespace App\Controllers;

use App\Models\AdModel;

class SearchController extends BaseController
{
    public function index()
    {
        $q        = $this->request->getGet('q')       ?? '';
        $minPrice = floatval($this->request->getGet('min'));
        $maxPrice = floatval($this->request->getGet('max'));
        $sort     = $this->request->getGet('sort')    ?? 'newest';
        $page     = intval($this->request->getGet('page')) ?: 1;

        $builder = (new AdModel())
            ->select('ads.*, 
                (SELECT url FROM ad_images 
                 WHERE ad_images.ad_id = ads.id 
                 ORDER BY is_primary DESC, sort_order ASC 
                 LIMIT 1) AS image_url')
            ->where('ads.status', 'active')
            ->where('ads.deleted_at', null);

        // texto
        if ($q !== '') {
            $builder->groupStart()
                    ->like('ads.title', $q)
                    ->orLike('ads.description_md', $q)
                    ->groupEnd();
        }

        // precio
        if ($minPrice) $builder->where('ads.price >=', $minPrice);
        if ($maxPrice) $builder->where('ads.price <=', $maxPrice);

        // orden
        switch ($sort) {
            case 'price_asc':  $builder->orderBy('ads.price',  'ASC');  break;
            case 'price_desc': $builder->orderBy('ads.price',  'DESC'); break;
            default:           $builder->orderBy('ads.created_at', 'DESC');
        }

        $ads  = $builder->paginate(12, 'default', $page);
        $pager = $builder->pager;

        return $this->loadWithNotifications('search/index', [
            'ads'      => $ads,
            'pager'    => $pager,
            'filters'  => compact('q', 'minPrice', 'maxPrice', 'sort'),
        ]);
    }
}
