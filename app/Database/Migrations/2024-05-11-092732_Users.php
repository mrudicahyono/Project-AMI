<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Users extends Migration
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
            'id_prodi' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'nidn' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
            ],
            'password' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'role' => [
                'type' => 'ENUM',
                'constraint' => ['auditor', 'auditi', 'pimpinan', 'admin'],
                'null' => true,
            ],
            'akses' => [
                'type' => 'BOOLEAN',
                'default' => 0,
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

        // Primary Key nya adalah Id
        $this->forge->addPrimaryKey('id');
        // Nama tabelnya adalah users
        $this->forge->createTable('users');
    }

    public function down()
    {
        $this->forge->dropTable('users');
    }
}
