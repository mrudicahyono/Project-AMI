<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Kriteria extends Migration
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
            // 'id_user' => [ // id user ke auditi
            //     'type' => 'INT',
            //     'constraint' => 11,
            //     'unsigned' => true,
            // ],
            'id_prodi' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'id_lembaga_akreditasi' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'uuid' => [
                'type' => 'VARCHAR',
                'constraint' => 40,
                'unique' => true,
            ],
            'kriteria' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'kode_kriteria' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'bobot' => [
                'type' => 'FLOAT',
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
        // $this->forge->addForeignKey('id_user', 'users', 'id', 'CASCADE', 'CASCADE', 'fk_kriteria_users');
        $this->forge->addForeignKey('id_prodi', 'prodi', 'id', 'CASCADE', 'CASCADE', 'fk_kriteria_prodi');
        $this->forge->addForeignKey('id_lembaga_akreditasi', 'lembaga_akreditasi', 'id', 'CASCADE', 'CASCADE', 'fk_kriteria_lembaga_akreditasi');
        $this->forge->createTable('kriteria');
    }

    public function down()
    {
        $this->forge->dropTable('kriteria');
    }
}
