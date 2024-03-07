<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Barang extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'code' => [
                'type' => 'varchar',
                'constraint' => '10',
            ],
            'name' => [
                'type' => 'varchar',
                'constraint' => '255',
            ],
            'kategori' => [
                'type' => 'int',
                'unsigned' => true
            ],
            'satuan' => [
                'type' => 'int',
                'unsigned' => true
            ],
            'harga_jual' => [
                'type' => 'double',
                'default' => 0,
            ],
            'harga_beli' => [
                'type' => 'double',
                'default' => 0,
            ],
            'image' => [
                'type' => 'text',
                'null' => true,
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

        $this->forge->addPrimaryKey('code');

        $this->forge->addForeignKey('kategori', 'table_kategori', 'id');
        $this->forge->addForeignKey('satuan', 'table_satuan', 'id');

        $this->forge->createTable('table_barang');
    }

    public function down()
    {
        $this->forge->dropTable('table_barang');
    }
}
