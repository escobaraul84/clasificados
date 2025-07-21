<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $allowedFields    = [
        'uuid','email','password_hash','full_name','phone',
        'email_verified','avatar_url','language','timezone',
        'lat','lng','address','avg_rating','total_reviews',
        'is_banned','last_login_at'
    ];
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules = [
        'email' => 'required|valid_email|is_unique[users.email]',
        'full_name' => 'required|min_length[3]|max_length[120]',
        'password_hash' => 'required',
    ];
}