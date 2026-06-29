<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class KriteriaStandar extends Migration
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
            'standar' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'is_aktif' => [
                'type' => 'BOOLEAN',
                'default' => -1,
            ]
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('kriteria_standar');

    }

    public function down()
    {
        $this->forge->dropTable('kriteria_standar');
    }
}
