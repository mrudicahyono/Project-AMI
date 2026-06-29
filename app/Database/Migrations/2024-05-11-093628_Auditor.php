<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Auditor extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'id_user' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'id_prodi' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'uuid' => [
                'type' => 'VARCHAR',
                'constraint' => 40,
                'unique' => true,
            ],
            'kode_auditor' => [
                'type' => 'VARCHAR',
                'constraint' => 30,
            ],
            'nama' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
            ],
            'akhir_sertifikat' => [
                'type' => 'Date',
                'null' => true
            ],
        ]);

        // tambah primary key
        $this->forge->addPrimaryKey('id');
        
        // tambah foreign key ke tabel users
        $this->forge->addForeignKey('id_user', 'users', 'id', 'CASCADE', 'CASCADE', 'fk_auditor_users');
        // tambah foreign key ke tabel prodi
        $this->forge->addForeignKey('id_prodi', 'prodi', 'id', 'CASCADE', 'CASCADE', 'fk_auditor_prodi');
        // bikin tabel auditor
        $this->forge->createTable('auditor');

    }

    public function down()
    {
        $this->forge->dropTable('auditor');
    }
}
