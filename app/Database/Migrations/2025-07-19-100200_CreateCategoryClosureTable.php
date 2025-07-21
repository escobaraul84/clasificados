<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCategoryClosureTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'ancestor_id'   => ['type' => 'SMALLINT', 'unsigned' => true],
            'descendant_id' => ['type' => 'SMALLINT', 'unsigned' => true],
            'depth'         => ['type' => 'TINYINT', 'unsigned' => true],
        ]);
        $this->forge->addPrimaryKey(['ancestor_id', 'descendant_id']);
        $this->forge->addForeignKey('ancestor_id',   'categories', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('descendant_id', 'categories', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('category_closure');
    }

    public function down()
    {
        $this->forge->dropTable('category_closure');
    }
}