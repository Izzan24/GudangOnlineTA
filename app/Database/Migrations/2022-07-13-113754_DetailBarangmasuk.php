<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DetailBarangmasuk extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'bigint',
                'constraint' => '20',
                'auto_increment' => TRUE,
            ],
            'barang_masuk' => [
                'type' => 'varchar',
                'constraint' => '20',
            ],
            'barang' => [
                'type' => 'varchar',
                'constraint' => '10',
            ],
            'harga_beli' => [
                'type' => 'double',
                'default' => 0,
            ],
            'qty' => [
                'type' => 'int',
                'constraint' => '20',
                'default' => 0,
            ],
            'subtotal' => [
                'type' => 'double',
                'default' => 0,
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

        $this->forge->addForeignKey('barang_masuk', 'table_barang_masuk', 'faktur');
        $this->forge->addForeignKey('barang', 'table_barang', 'code');

        $this->forge->createTable('table_detail_barang_masuk');
    }

    public function down()
    {
        $this->forge->dropTable('table_detail_barang_masuk');
    }
}
