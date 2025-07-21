<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateInvoicesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'           => ['type' => 'BIGINT', 'unsigned' => true, 'auto_increment' => true],
            'user_id'      => ['type' => 'BIGINT', 'unsigned' => true],
            'amount_usd'   => ['type' => 'DECIMAL', 'constraint' => '10,2'],
            'amount_clas'  => ['type' => 'DECIMAL', 'constraint' => '10,2', 'default' => 0],
            'stripe_id'    => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'pdf_url'      => ['type' => 'VARCHAR', 'constraint' => 500, 'null' => true],
            'status'       => ['type' => 'ENUM', 'constraint' => ['pending','paid','refunded'], 'default' => 'pending'],
            'created_at' => ['type' => 'DATETIME', 'null' => false, 'default' => new \CodeIgniter\Database\RawSql('CURRENT_TIMESTAMP')],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('invoices');
    }

    public function down()
    {
        $this->forge->dropTable('invoices');
    }
}