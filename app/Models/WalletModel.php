<?php

namespace App\Models;

use CodeIgniter\Model;

class WalletModel extends Model
{
    protected $table            = 'wallets';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $allowedFields    = ['user_id','address','balance_clas'];
    protected $useTimestamps = true;

    public function user()
    {
        return $this->belongsTo(UserModel::class, 'user_id');
    }
}