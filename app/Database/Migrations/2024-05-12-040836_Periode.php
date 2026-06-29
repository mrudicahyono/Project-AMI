<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Periode extends Migration
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
            'nama_periode' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'tahun' => [
                'type' => 'VARCHAR',
                'constraint' => 4,
            ],
            'ruang_lingkup' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'tanggal_mulai' => [
                'type' => 'Date'
            ],
            'tanggal_selesai' => [
                'type' => 'Date'
            ],
            'penjaminan_mutu_audit' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
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
        $this->forge->createTable('periode');
    }

    public function down()
    {
        $this->forge->dropTable('periode');
    }
}
