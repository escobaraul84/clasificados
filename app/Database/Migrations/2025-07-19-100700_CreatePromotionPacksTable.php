<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePromotionPacksTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => ['type' => 'SMALLINT', 'unsigned' => true, 'auto_increment' => true],
            'name'        => ['type' => 'VARCHAR', 'constraint' => 100],
            'days'        => ['type' => 'SMALLINT'],
            'price_usd'   => ['type' => 'DECIMAL', 'constraint' => '8,2'],
            'badge_color' => ['type' => 'VARCHAR', 'constraint' => 7, 'null' => true],
            'is_active'   => ['type' => 'TINYINT', 'default' => 1],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('promotion_packs');
    }

    public function down()
    {
        $this->forge->dropTable('promotion_packs');
    }
}