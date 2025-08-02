<?php
namespace App\Controllers;

use App\Models\AdModel;
use App\Models\CategoryModel;

class PromotionController extends BaseController
{
    public function selectPack(int $adId)
    {
        $packs = db_connect()->table('promotion_packs')->get()->getResultArray();
        return $this->loadWithNotifications('promotions/select', ['adId' => $adId, 'packs' => $packs]);
    }
}