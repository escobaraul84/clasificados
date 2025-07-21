<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateWalletsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'            => ['type' => 'BIGINT', 'unsigned' => true, 'auto_increment' => true],
            'user_id'       => ['type' => 'BIGINT', 'unsigned' => true],
            'address'       => ['type' => 'VARCHAR', 'constraint' => 42, 'unique' => true, 'null' => true],
            'balance_clas'  => ['type' => 'DECIMAL', 'constraint' => '18,8', 'default' => 0],
            'created_at' => ['type' => 'DATETIME', 'null' => false, 'default' => new \CodeIgniter\Database\RawSql('CURRENT_TIMESTAMP')],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addUniqueKey('user_id');
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('wallets');
    }

    public function down()
    {
        $this->forge->dropTable('wallets');
    }
}