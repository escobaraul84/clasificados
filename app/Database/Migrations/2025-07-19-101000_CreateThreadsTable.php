<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateThreadsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'         => ['type' => 'BIGINT', 'unsigned' => true, 'auto_increment' => true],
            'ad_id'      => ['type' => 'BIGINT', 'unsigned' => true],
            'buyer_id'   => ['type' => 'BIGINT', 'unsigned' => true],
            'seller_id'  => ['type' => 'BIGINT', 'unsigned' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => false, 'default' => new \CodeIgniter\Database\RawSql('CURRENT_TIMESTAMP')],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('ad_id', 'ads', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('buyer_id',  'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('seller_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('threads');
    }

    public function down()
    {
        $this->forge->dropTable('threads');
    }
}