<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class KelengkapanDokumen extends Migration
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
            'id_penugasan_auditor' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ],
            'id_kriteria' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ],
            'uuid' => [
                'type' => 'VARCHAR',
                'constraint' => 40,
                'unique' => true,
            ],
            'status_dokumen' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'nama_dokumen' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'keterangan' => [
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
            ],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('id_penugasan_auditor', 'penugasan_auditor', 'id', 'CASCADE', 'CASCADE', 'fk_kelengkapan_dokumen_berdasarkan_penugasanAuditor');
        $this->forge->addForeignKey('id_kriteria', 'kriteria', 'id', 'CASCADE', 'CASCADE', 'fk_kelengkapan_dokumen_berdasarkanKriteria');


        $this->forge->createTable('kelengkapan_dokumen');
    }

    public function down()
    {
        $this->forge->dropTable('kelengkapan_dokumen');
    }
}
