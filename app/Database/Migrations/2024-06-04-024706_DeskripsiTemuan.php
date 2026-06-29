<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DeskripsiTemuan extends Migration
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
            'id_ringkasan_temuan' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true
            ],
            'uuid' => [
                'type' => 'VARCHAR',
                'constraint' => 40,
                'unique' => true,
            ],
            'deskripsi_temuan' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'kriteria' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'akibat' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'akar_penyebab' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'rekomendasi' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'tanggapan_auditi' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => true,
            ],
            'rencana_perbaikan' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'jadwal_perbaikan' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'penanggung_jawab_perbaikan' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'rencana_pencegahan' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'jadwal_pencegahan' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'penanggung_jawab_pencegahan' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'pimpinan_auditi' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'reviewer' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => 'true',
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => 'true'
            ],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('id_ringkasan_temuan', 'ringkasan_temuan', 'id', 'CASCADE', 'CASCADE', 'fk_deskripsiTemuan_ringkasanTemuan');
        
        $this->forge->createTable('deskripsi_temuan');


    }

    public function down()
    {
        $this->forge->dropTable('deskripsi_temuan');
    }
}
