<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RingkasanTemuan extends Migration
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
            'deskripsi' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'kategori' => [
                'type' => 'ENUM',
                'constraint' => ['KTS', 'OB'],
                'default' => 'KTS',
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
        $this->forge->addForeignKey('id_penugasan_auditor', 'penugasan_auditor', 'id', 'CASCADE', 'CASCADE', 'fk_ringkasan_temuan_berdasarkan_penugasanAuditor');
        $this->forge->addForeignKey('id_kriteria', 'kriteria', 'id', 'CASCADE', 'CASCADE', 'fk_ringkasan_temuan_berdasarkanKriteria');


        $this->forge->createTable('ringkasan_temuan');
    }

    public function down()
    {
        $this->forge->dropTable('ringkasan_temuan');
    }
}
