<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAdsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'             => ['type' => 'BIGINT', 'unsigned' => true, 'auto_increment' => true],
            'uuid'           => ['type' => 'BINARY', 'constraint' => 16, 'unique' => true],
            'user_id'        => ['type' => 'BIGINT', 'unsigned' => true],
            'category_id'    => ['type' => 'SMALLINT', 'unsigned' => true],
            'title'          => ['type' => 'VARCHAR', 'constraint' => 150],
            'slug'           => ['type' => 'VARCHAR', 'constraint' => 170, 'unique' => true],
            'description_md' => ['type' => 'MEDIUMTEXT', 'null' => true],
            'condition_type' => ['type' => 'ENUM', 'constraint' => ['new','used','refurbished'], 'default' => 'used'],
            'price'          => ['type' => 'DECIMAL', 'constraint' => '14,2', 'null' => true],
            'currency'       => ['type' => 'CHAR', 'constraint' => 3, 'default' => 'USD'],
            'negotiable'     => ['type' => 'TINYINT', 'default' => 0],
            'lat'            => ['type' => 'DECIMAL', 'constraint' => '10,8', 'null' => true],
            'lng'            => ['type' => 'DECIMAL', 'constraint' => '11,8', 'null' => true],
            'location_text'  => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'specs'          => ['type' => 'JSON', 'null' => true],
            'contact_phone'  => ['type' => 'VARCHAR', 'constraint' => 30, 'null' => true],
            'contact_email'  => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'status'         => ['type' => 'ENUM', 'constraint' => ['draft','active','paused','sold','deleted'], 'default' => 'draft'],
            'expires_at'     => ['type' => 'DATETIME', 'null' => true],
            'view_count'     => ['type' => 'BIGINT', 'default' => 0],
            'created_at' => ['type' => 'DATETIME', 'null' => false, 'default' => new \CodeIgniter\Database\RawSql('CURRENT_TIMESTAMP')],
            'updated_at' => ['type' => 'DATETIME', 'null' => false, 'default' => new \CodeIgniter\Database\RawSql('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP')],
            'deleted_at'     => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('user_id',     'users',      'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('category_id', 'categories', 'id', 'RESTRICT', 'CASCADE');
        $this->forge->createTable('ads');
    }

    public function down()
    {
        $this->forge->dropTable('ads');
    }
}