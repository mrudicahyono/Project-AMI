<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class LembagaAkreditasi extends Migration
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
            'uuid' =>[
                'type' => 'VARCHAR',
                'constraint' => 40,
                'unique' => true,
            ],
            'nama' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
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

        // primary key
        $this->forge->addPrimaryKey('id');
        // nama tabel
        $this->forge->createTable('lembaga_akreditasi');

    }

    public function down()
    {
        $this->forge->dropTable('lembaga_akreditasi');
    }
}
