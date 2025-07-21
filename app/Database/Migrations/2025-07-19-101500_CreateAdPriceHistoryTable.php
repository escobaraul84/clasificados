<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAdPriceHistoryTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => ['type' => 'BIGINT', 'unsigned' => true, 'auto_increment' => true],
            'ad_id'       => ['type' => 'BIGINT', 'unsigned' => true],
            'old_price'   => ['type' => 'DECIMAL', 'constraint' => '14,2', 'null' => true],
            'new_price'   => ['type' => 'DECIMAL', 'constraint' => '14,2', 'null' => true],
            'changed_at'  => ['type' => 'DATETIME', 'null' => false, 'default' => new \CodeIgniter\Database\RawSql('CURRENT_TIMESTAMP')],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('ad_id', 'ads', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('ad_price_history');
    }

    public function down()
    {
        $this->forge->dropTable('ad_price_history');
    }
}