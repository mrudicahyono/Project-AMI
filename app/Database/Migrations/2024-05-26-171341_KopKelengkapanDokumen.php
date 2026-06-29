<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class KopKelengkapanDokumen extends Migration
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
            'uuid' => [
                'type' => 'VARCHAR',
                'constraint' => 40,
                'unique' => true,
            ],
            'lokasi' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'ruang_lingkup' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'tanggal_audit' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'wakil_auditi' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'auditor_ketua' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'auditor_anggota' => [
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
        $this->forge->addForeignKey('id_penugasan_auditor', 'penugasan_auditor', 'id', 'CASCADE', 'CASCADE', 'fk_kop_kelengkapan_dokumen_berdasarkan_penugasanAuditor');
        $this->forge->createTable('kop_kelengkapan_dokumen');
    }
    public function down()
    {
        $this->forge->dropTable('kop_kelengkapan_dokumen');
    }
}
