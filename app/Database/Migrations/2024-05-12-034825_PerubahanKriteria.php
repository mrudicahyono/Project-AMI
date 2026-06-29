<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PerubahanKriteria extends Migration
{
    public function up()
    {
        
        $this->forge->addField([
            'id_kriteria_prodi' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'uuid' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'unique' => true,
            ],
            'capaian_sebelum' => [
                'type' => 'FLOAT',
                'null' => true,
            ],
            'capaian_setelah' => [
                'type' => 'FLOAT',
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

        $this->forge->addPrimaryKey('id_kriteria');
        $this->forge->addForeignKey('id_kriteria_prodi', 'kriteria_prodi', 'id', 'CASCADE', 'CASCADE', 'fk_perubahanKriteria_kriteriaProdi');
        $this->forge->createTable('perubahan_kriteria');

    }

    public function down()
    {
        $this->forge->dropTable('perubahan_kriteria');
    }
}
