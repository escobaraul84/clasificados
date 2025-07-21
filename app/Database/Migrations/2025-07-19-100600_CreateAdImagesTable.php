<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAdImagesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => ['type' => 'BIGINT', 'unsigned' => true, 'auto_increment' => true],
            'ad_id'       => ['type' => 'BIGINT', 'unsigned' => true],
            'url'         => ['type' => 'VARCHAR', 'constraint' => 500],
            'sort_order'  => ['type' => 'TINYINT', 'default' => 0],
            'is_primary'  => ['type' => 'TINYINT', 'default' => 0],
            'created_at' => ['type' => 'DATETIME', 'null' => false, 'default' => new \CodeIgniter\Database\RawSql('CURRENT_TIMESTAMP')],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('ad_id', 'ads', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('ad_images');
    }

    public function down()
    {
        $this->forge->dropTable('ad_images');
    }
}