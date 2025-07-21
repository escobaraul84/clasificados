<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateReportsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'           => ['type' => 'BIGINT', 'unsigned' => true, 'auto_increment' => true],
            'ad_id'        => ['type' => 'BIGINT', 'unsigned' => true],
            'reporter_id'  => ['type' => 'BIGINT', 'unsigned' => true],
            'reason'       => ['type' => 'ENUM', 'constraint' => ['scam','duplicate','prohibited','offensive']],
            'comment'      => ['type' => 'VARCHAR', 'constraint' => 500, 'null' => true],
            'status'       => ['type' => 'ENUM', 'constraint' => ['open','resolved','dismissed'], 'default' => 'open'],
            'created_at' => ['type' => 'DATETIME', 'null' => false, 'default' => new \CodeIgniter\Database\RawSql('CURRENT_TIMESTAMP')],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('ad_id',       'ads',   'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('reporter_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('reports');
    }

    public function down()
    {
        $this->forge->dropTable('reports');
    }
}