<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateFavoritesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'user_id' => ['type' => 'BIGINT', 'unsigned' => true],
            'ad_id'   => ['type' => 'BIGINT', 'unsigned' => true],
        ]);
        $this->forge->addPrimaryKey(['user_id', 'ad_id']);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('ad_id',   'ads',   'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('favorites');
    }

    public function down()
    {
        $this->forge->dropTable('favorites');
    }
}