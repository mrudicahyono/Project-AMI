<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UploadBerkas extends Migration
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
            'id_prodi' => [
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
            'link_form4' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'link_form5' => [
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
        $this->forge->addForeignKey('id_penugasan_auditor', 'penugasan_auditor', 'id', 'CASCADE', 'CASCADE', 'fk_upload_berkas_berdasarkan_penugasanAuditor');
        $this->forge->addForeignKey('id_prodi', 'prodi', 'id', 'CASCADE', 'CASCADE', 'fk_upload_berkas_berdasarkan_prodi');


        $this->forge->createTable('upload_berkas');
    }

    public function down()
    {
        $this->forge->dropTable('upload_berkas');
    }
}
