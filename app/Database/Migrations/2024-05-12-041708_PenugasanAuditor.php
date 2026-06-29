<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PenugasanAuditor extends Migration
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
            'id_auditor' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'id_prodi' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'id_periode' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'uuid' => [
                'type' => 'VARCHAR',
                'constraint' => 40,
                'unique' => true,
            ],
            'ketua' => [
                'type' => 'ENUM',
                'constraint' => ['0', '1'],
                'default' => '0',
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
        $this->forge->addForeignKey('id_auditor', 'auditor', 'id', 'CASCADE', 'CASCADE', 'fk_penugasanAuditor_auditor');
        $this->forge->addForeignKey('id_prodi', 'prodi', 'id', 'CASCADE', 'CASCADE', 'fk_penugasanAuditor_prodi');
        $this->forge->addForeignKey('id_periode', 'periode', 'id', 'CASCADE', 'CASCADE', 'fk_penugasanAuditor_periode');
        $this->forge->createTable('penugasan_auditor');
    }

    public function down()
    {
        $this->forge->dropTable('penugasan_auditor');
    }
}
