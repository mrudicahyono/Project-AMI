<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddForeignKriteriaStandarToKriteria extends Migration
{
    
    public function up()
    {
        // tambah field baru ke tabel kriteria

        $this->forge->addColumn('kriteria', [
            'id_kriteria_standar' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true
            ]
        ]);

        // tambah foreign key
        
        $this->forge->addForeignKey('id_kriteria_standar', 'kriteria_standar', 'id', 'CASCADE', 'CASCADE', 'fk_kriteria_kriteriaStandar');

    }

    public function down()
    {
        //
    }
}
