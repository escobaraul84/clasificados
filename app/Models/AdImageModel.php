<?php

namespace App\Models;

use CodeIgniter\Model;

class AdImageModel extends Model
{
    protected $table            = 'ad_images';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $allowedFields    = ['ad_id','url','sort_order','is_primary'];
    protected $useTimestamps = true;

    public function ad()
    {
        return $this->belongsTo(AdModel::class, 'ad_id');
    }
}