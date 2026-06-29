<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AuditorSeeder extends Seeder
{
    public function run()
    {
        
        // untuk tabel users yang rolenya auditor
        $this->db->table('auditor')->insert([
            'id_user' => 7,
            'id_prodi' => 1,
            'uuid' => service('uuid')->uuid4()->toString(),
            'kode_auditor' => uniqid(),
            'nama' => 'NOLA RITHA, S.T., M.CS',
        ]);

        $this->db->table('auditor')->insert([
            'id_user' => 8,
            'id_prodi' => 2,
            'uuid' => service('uuid')->uuid4()->toString(),
            'kode_auditor' => uniqid(),
            'nama' => 'Teddy Haryadi, SE., M.Ak',
        ]);

        $this->db->table('auditor')->insert([
            'id_user' => 9,
            'id_prodi' => 8,
            'uuid' => service('uuid')->uuid4()->toString(),
            'kode_auditor' => uniqid(),
            'nama' => 'Yudi Umara, M.Pd',
        ]);

        

    }
}
