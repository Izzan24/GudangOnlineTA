<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TrackingBarang extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'int',
                'unsigned' => TRUE,
                'auto_increment' => TRUE,
            ],
            'rfid_tag' => [
                'type' => 'varchar',
                'constraint' => '20',
            ],
            'description' => [
                'type' => 'text',
                'null' => true
            ],
            'type' => [
                'type' => 'ENUM("registration", "inbound", "outbound", "relocation", "inbound_deleted", "outbound_deleted")',
                'null' => FALSE,
            ],
            'lokasi' => [
                'type' => 'int',
                'unsigned' => true,
                'null' => true
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
        $this->forge->createTable('table_tracking');
    }

    public function down()
    {
        $this->forge->dropTable('table_tracking');
    }
}
