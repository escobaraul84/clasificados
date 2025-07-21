<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTransactionsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'           => ['type' => 'BIGINT', 'unsigned' => true, 'auto_increment' => true],
            'wallet_id'    => ['type' => 'BIGINT', 'unsigned' => true],
            'type'         => ['type' => 'ENUM', 'constraint' => ['in','out']],
            'amount_clas'  => ['type' => 'DECIMAL', 'constraint' => '18,8'],
            'reason'       => ['type' => 'ENUM', 'constraint' => ['promotion','referral','refund','withdraw']],
            'metadata'     => ['type' => 'JSON', 'null' => true],
            'tx_hash'      => ['type' => 'VARCHAR', 'constraint' => 66, 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => false, 'default' => new \CodeIgniter\Database\RawSql('CURRENT_TIMESTAMP')],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('wallet_id', 'wallets', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('transactions');
    }

    public function down()
    {
        $this->forge->dropTable('transactions');
    }
}