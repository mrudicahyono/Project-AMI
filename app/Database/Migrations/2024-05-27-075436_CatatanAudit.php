<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CatatanAudit extends Migration
{
    public function up()
    {
        // Definisi struktur tabel catatan_audit
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
            ],
            'uuid' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'unique' => true,
            ],
            'catatan_audit' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'label' => [
                'type' => "ENUM('+', '-')",
                'null' => false,
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
        $this->forge->addForeignKey('id_penugasan_auditor', 'penugasan_auditor', 'id', 'CASCADE', 'CASCADE', 'fk_catatan_audit_berdasarkan_penugasanAuditor');
        $this->forge->createTable('catatan_audit');
    }

    public function down()
    {

        $this->forge->dropTable('catatan_audit');
    }
}
