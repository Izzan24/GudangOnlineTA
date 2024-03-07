<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class SubLokasi extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'int',
                'unsigned' => TRUE,
                'auto_increment' => TRUE,
            ],
            'name' => [
                'type' => 'varchar',
                'constraint' => '255',
            ],
            'parent' => [
                'type' => 'int',
                'unsigned' => true
            ],
            'is_deleted' => [
                'type' => 'tinyint',
                'constraint' => '1',
                'default' => '0',
            ],
            'created_at' => [
                'type'    => 'TIMESTAMP',
                'default' => new \CodeIgniter\Database\RawSql('CURRENT_TIMESTAMP'),
            ],
            'updated_at' => [
                'type'    => 'TIMESTAMP',
                'null' => true,
            ],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('parent', 'table_lokasi', 'id');
        $this->forge->createTable('table_sub_lokasi');
    }

    public function down()
    {
        $this->forge->dropTable('table_sub_lokasi');
    }
}
