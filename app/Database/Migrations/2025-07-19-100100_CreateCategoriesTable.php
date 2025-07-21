<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCategoriesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'         => ['type' => 'SMALLINT', 'unsigned' => true, 'auto_increment' => true],
            'parent_id'  => ['type' => 'SMALLINT', 'unsigned' => true, 'null' => true],
            'slug'       => ['type' => 'VARCHAR', 'constraint' => 100, 'unique' => true],
            'sort_order' => ['type' => 'SMALLINT', 'default' => 0],
            'icon_url'   => ['type' => 'VARCHAR', 'constraint' => 500, 'null' => true],
            'is_active'  => ['type' => 'TINYINT', 'default' => 1],
            'created_at' => ['type' => 'DATETIME', 'null' => false, 'default' => new \CodeIgniter\Database\RawSql('CURRENT_TIMESTAMP')],
            'updated_at' => ['type' => 'DATETIME', 'null' => false, 'default' => new \CodeIgniter\Database\RawSql('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP')],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('parent_id', 'categories', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('categories');

        // Datos semilla
        $seeder = \Config\Database::seeder();
        $seeder->call('CategorySeeder');
    }

    public function down()
    {
        $this->forge->dropTable('categories');
    }
}