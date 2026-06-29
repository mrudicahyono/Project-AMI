<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ProdiSeeder extends Seeder
{
    public function run()
    {
        $data_prodi = [
            [
                'uuid' => service('uuid')->uuid4()->toString(),
                'nama' => 'Teknik Informatika',
                'fakultas' => 'Teknik dan Teknologi Kemaritiman'
            ],
            [
                'uuid' => service('uuid')->uuid4()->toString(),
                'nama' => 'Teknik Elektro',
                'fakultas' => 'Teknik dan Teknologi Kemaritiman'
            ],
            [
                'uuid' => service('uuid')->uuid4()->toString(),
                'nama' => 'Teknik Perkapalan',
                'fakultas' => 'Teknik dan Teknologi Kemaritiman'
            ],
            [
                'uuid' => service('uuid')->uuid4()->toString(),
                'nama' => 'Pendidikan Bahasa dan Sastra Indonesia',
                'fakultas' => 'Keguruan dan Ilmu Pendidikan',
            ],
            [
                'uuid' => service('uuid')->uuid4()->toString(),
                'nama' => 'Pendidikan Matematika',
                'fakultas' => 'Keguruan dan Ilmu Pendidikan',
            ],
            [
                'uuid' => service('uuid')->uuid4()->toString(),
                'nama' => 'Pendidikan Biologi',
                'fakultas' => 'Keguruan dan Ilmu Pendidikan',
            ],
            [
                'uuid' => service('uuid')->uuid4()->toString(),
                'nama' => 'Pendidikan Kimia',
                'fakultas' => 'Keguruan dan Ilmu Pendidikan',
            ],
            [
                'uuid' => service('uuid')->uuid4()->toString(),
                'nama' => 'Pendidikan Bahasa Inggris',
                'fakultas' => 'Keguruan dan Ilmu Pendidikan',
            ],
            [
                'uuid' => service('uuid')->uuid4()->toString(),
                'nama' => 'Ilmu Pemerintahan',
                'fakultas' => 'Ilmu Sosial dan Ilmu Politik',
            ],
            [
                'uuid' => service('uuid')->uuid4()->toString(),
                'nama' => 'Ilmu Administrasi Negara',
                'fakultas' => 'Ilmu Sosial dan Ilmu Politik',
            ],
            [
                'uuid' => service('uuid')->uuid4()->toString(),
                'nama' => 'Sosiologi',
                'fakultas' => 'Ilmu Sosial dan Ilmu Politik',
            ],
            [
                'uuid' => service('uuid')->uuid4()->toString(),
                'nama' => 'Ilmu Hukum',
                'fakultas' => 'Ilmu Sosial dan Ilmu Politik',
            ],
            [
                'uuid' => service('uuid')->uuid4()->toString(),
                'nama' => 'Hubungan Internasional',
                'fakultas' => 'Ilmu Sosial dan Ilmu Politik',
            ],
            [
                'uuid' => service('uuid')->uuid4()->toString(),
                'nama' => 'Ilmu Kelautan',
                'fakultas' => 'Ilmu Kelautan dan Perikanan',
            ],
            [
                'uuid' => service('uuid')->uuid4()->toString(),
                'nama' => 'Manajemen Sumberdaya Perairan',
                'fakultas' => 'Ilmu Kelautan dan Perikanan',
            ],
            [
                'uuid' => service('uuid')->uuid4()->toString(),
                'nama' => 'Teknologi Hasil Perikanan',
                'fakultas' => 'Ilmu Kelautan dan Perikanan',
            ],
            [
                'uuid' => service('uuid')->uuid4()->toString(),
                'nama' => 'Budidaya Perairan (Akuakultur)',
                'fakultas' => 'Ilmu Kelautan dan Perikanan',
            ],
            [
                'uuid' => service('uuid')->uuid4()->toString(),
                'nama' => 'Sosial Ekonomi Perikanan',
                'fakultas' => 'Ilmu Kelautan dan Perikanan',
            ],
            [
                'uuid' => service('uuid')->uuid4()->toString(),
                'nama' => 'Akuntansi',
                'fakultas' => 'Ekonomi dan Bisnis Maritim',
            ],
            [
                'uuid' => service('uuid')->uuid4()->toString(),
                'nama' => 'Manajemen',
                'fakultas' => 'Ekonomi dan Bisnis Maritim',
            ],
        ];


        $this->db->table('prodi')->insertBatch($data_prodi);

    }
}
