<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAdPromotionsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'           => ['type' => 'BIGINT', 'unsigned' => true, 'auto_increment' => true],
            'ad_id'        => ['type' => 'BIGINT', 'unsigned' => true],
            'pack_id'      => ['type' => 'SMALLINT', 'unsigned' => true],
            'started_at'   => ['type' => 'DATETIME'],
            'finished_at'  => ['type' => 'DATETIME'],
            'created_at' => ['type' => 'DATETIME', 'null' => false, 'default' => new \CodeIgniter\Database\RawSql('CURRENT_TIMESTAMP')],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('ad_id',   'ads',            'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('pack_id', 'promotion_packs','id', 'RESTRICT', 'CASCADE');
        $this->forge->createTable('ad_promotions');
    }

    public function down()
    {
        $this->forge->dropTable('ad_promotions');
    }
}