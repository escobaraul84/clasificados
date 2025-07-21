<?php

namespace App\Models;

use CodeIgniter\Model;

class AdModel extends Model
{
    protected $table            = 'ads';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $allowedFields    = [
        'uuid',
        'user_id','category_id','title','slug','description_md',
        'condition_type','price','currency','negotiable',
        'lat','lng','location_text','specs','contact_phone',
        'contact_email','status','expires_at'
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Relaciones
    public function user()
    {
        return $this->belongsTo(UserModel::class, 'user_id');
    }
    public function category()
    {
        return $this->belongsTo(CategoryModel::class, 'category_id');
    }
    public function images()
    {
        return $this->hasMany(AdImageModel::class, 'ad_id');
    }
}