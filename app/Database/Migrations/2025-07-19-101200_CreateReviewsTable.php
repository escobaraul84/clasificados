<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateReviewsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'           => ['type' => 'BIGINT', 'unsigned' => true, 'auto_increment' => true],
            'ad_id'        => ['type' => 'BIGINT', 'unsigned' => true],
            'reviewer_id'  => ['type' => 'BIGINT', 'unsigned' => true],
            'reviewee_id'  => ['type' => 'BIGINT', 'unsigned' => true],
            'rating'       => ['type' => 'TINYINT', 'constraint' => 1],
            'comment'      => ['type' => 'VARCHAR', 'constraint' => 500, 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => false, 'default' => new \CodeIgniter\Database\RawSql('CURRENT_TIMESTAMP')],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('ad_id',        'ads',   'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('reviewer_id',  'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('reviewee_id',  'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('reviews');
    }

    public function down()
    {
        $this->forge->dropTable('reviews');
    }
}