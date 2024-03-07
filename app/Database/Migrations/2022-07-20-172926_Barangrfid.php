<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Barangrfid extends Migration
{
    public function up()
    {
       $this->forge->addField([
            'id' => [
                'type' => 'bigint',
                'constraint' => '20',
                'auto_increment' => TRUE,
            ],
            'rfid_tag' => [
                'type' => 'varchar',
                'constraint' => '20',
            ],
            'barang' => [
                'type' => 'varchar',
                'constraint' => '10',
            ],
            'identifier_barang' => [
                'type' => 'varchar',
                'constraint' => '10',
                'null' => true,
            ],
            'barang_masuk_detail' => [
                'type' => 'bigint',
                'constraint' => '20',
                'null' => true,
            ],
            'barang_keluar_detail' => [
                'type' => 'bigint',
                'constraint' => '20',
                'null' => true,
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
        $this->forge->addForeignKey('barang', 'table_barang', 'code');

        $this->forge->createTable('table_barang_rfid');
    }

    public function down()
    {
        $this->forge->dropTable('table_barang_rfid');
    }
}
