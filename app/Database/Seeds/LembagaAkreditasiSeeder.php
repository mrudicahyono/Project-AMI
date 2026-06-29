<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class LembagaAkreditasiSeeder extends Seeder
{
    public function run()
    {

        $data = [
            [
                'uuid' => service('uuid')->uuid4()->toString(),
                'nama' => 'Badan Akreditasi Nasional Perguruan Tinggi (BAN-PT)'
            ],
            [
                'uuid' => service('uuid')->uuid4()->toString(),
                'nama' => 'Lembaga Akreditasi Mandiri Sains Alam dan Ilmu Formal (LAM-SAMA)'
            ],
            [
                'uuid' => service('uuid')->uuid4()->toString(),
                'nama' => 'Lembaga Akreditasi Mandiri Pendidikan Tinggi Kesehatan (LAMPT-Kes)'
            ]
        ];

        $this->db->table('lembaga_akreditasi')->insertBatch($data);
        
    }
}
