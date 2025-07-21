<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run()
    {
        // $data = [
        //    ['id' => 1, 'parent_id' => null, 'slug' => 'venta',      'sort_order' => 1, 'is_active' => 1],
        //    ['id' => 2, 'parent_id' => null, 'slug' => 'compra',     'sort_order' => 2, 'is_active' => 1],
        //    ['id' => 3, 'parent_id' => null, 'slug' => 'servicios',  'sort_order' => 3, 'is_active' => 1],
        //    ['id' => 4, 'parent_id' => null, 'slug' => 'requerimientos', 'sort_order' => 4, 'is_active' => 1],
        //];

        $data = [
            ['id' => 1, 'parent_id' => null, 'slug' => 'venta',      'name' => 'Venta',      'sort_order' => 1, 'is_active' => 1],
            ['id' => 2, 'parent_id' => null, 'slug' => 'compra',     'name' => 'Compra',     'sort_order' => 2, 'is_active' => 1],
            ['id' => 3, 'parent_id' => null, 'slug' => 'servicios',  'name' => 'Servicios',  'sort_order' => 3, 'is_active' => 1],
            ['id' => 4, 'parent_id' => null, 'slug' => 'requerimientos','name' => 'Requerimientos','sort_order' => 4, 'is_active' => 1],
        ];

        $this->db->table('categories')->insertBatch($data);
    }
}