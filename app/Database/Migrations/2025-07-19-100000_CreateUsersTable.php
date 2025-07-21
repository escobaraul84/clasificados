<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsersTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'            => ['type' => 'BIGINT', 'unsigned' => true, 'auto_increment' => true],
            'uuid'          => ['type' => 'BINARY', 'constraint' => 16, 'unique' => true],
            'email'         => ['type' => 'VARCHAR', 'constraint' => 255, 'unique' => true],
            'password_hash' => ['type' => 'VARCHAR', 'constraint' => 255],
            'full_name'     => ['type' => 'VARCHAR', 'constraint' => 120],
            'phone'         => ['type' => 'VARCHAR', 'constraint' => 30, 'null' => true],
            'email_verified'=> ['type' => 'TINYINT', 'default' => 0],
            'avatar_url'    => ['type' => 'VARCHAR', 'constraint' => 500, 'null' => true],
            'language'      => ['type' => 'CHAR', 'constraint' => 5, 'default' => 'es'],
            'timezone'      => ['type' => 'VARCHAR', 'constraint' => 50, 'default' => 'UTC'],
            'lat'           => ['type' => 'DECIMAL', 'constraint' => '10,8', 'null' => true],
            'lng'           => ['type' => 'DECIMAL', 'constraint' => '11,8', 'null' => true],
            'address'       => ['type' => 'JSON', 'null' => true],
            'avg_rating'    => ['type' => 'DECIMAL', 'constraint' => '2,1', 'default' => 0],
            'total_reviews' => ['type' => 'INT', 'default' => 0],
            'is_banned'     => ['type' => 'TINYINT', 'default' => 0],
            'last_login_at' => ['type' => 'DATETIME', 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => false, 'default' => new \CodeIgniter\Database\RawSql('CURRENT_TIMESTAMP')],
            'updated_at' => ['type' => 'DATETIME', 'null' => false, 'default' => new \CodeIgniter\Database\RawSql('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP')],
            'deleted_at'    => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('users');
    }

    public function down()
    {
        $this->forge->dropTable('users');
    }
}