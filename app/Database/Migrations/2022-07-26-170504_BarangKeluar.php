<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class BarangKeluar extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'faktur' => [
                'type' => 'varchar',
                'constraint' => '20',
            ],
            'tanggal' => [
                'type' => 'date',
            ],
            'total_harga' => [
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

        $this->forge->addPrimaryKey('faktur');
        $this->forge->createTable('table_barang_keluar');
    }

    public function down()
    {
        
        $this->forge->dropTable('table_barang_keluar');
    }
}
