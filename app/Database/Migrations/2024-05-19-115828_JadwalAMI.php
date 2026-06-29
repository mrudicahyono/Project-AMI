<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class JadwalAMI extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'uuid' => [
                'type' => 'VARCHAR',
                'constraint' => 40,
                'unique' => true,
            ],
            'tanggal_mulai' => [
                'type' => 'Date'
            ],
            'tanggal_selesai' => [
                'type' => 'Date'
            ],
            'deskripsi' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ]
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('jadwal_ami');
    }

    public function down()
    {
        $this->forge->dropTable('jadwal_ami');
    }
}
