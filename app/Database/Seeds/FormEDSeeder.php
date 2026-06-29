<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class FormEDSeeder extends Seeder
{

    public function run()
    {


        $standar = [
            'Kondisi Eksternal',
            'Profil Unit Pengelola Program Studi',
            'C.1.4. Indikator Kinerja Utama',
            'C.2.4. Indikator Kinerja Utama',
            'C.2.4.a) Sistem Tata Pamong',
            'C.2.4.b) Kepemimpinan dan Kemampuan Manajerial',
            'C.2.4.c)  Kerjasama ',

        ];

        $kriteria = [
            "Konsistensi dengan hasil analisis SWOT dan/atau analisis lain serta rencana pengembangan ke depan.",
            "Keserbacakupan informasi dalam profil dan konsistensi antara profil dengan data dan informasi yang disampaikan pada masing-masing kriteria, serta menunjukkan iklim yang kondusif untuk pengembangan dan reputasi sebagai rujukan di bidang keilmuannya",
            "Kesesuaian Visi, Misi, Tujuan dan Strategi (VMTS) Unit Pengelola Program Studi (UPPS) terhadap VMTS Perguruan Tinggi (PT) dan visi keilmuan Program Studi (PS) yang dikelolanya.",
            "Mekanisme dan keterlibatan pemangku kepentingan dalam penyusunan VMTS UPPS. ",
            "Strategi pencapaian tujuan disusun berdasarkan analisis yang sistematis, serta pada pelaksanaannya dilakukan pemantauan dan evaluasi yang ditindaklanjuti. ",
            "A. Kelengkapan struktur organisasi dan keefektifan penyelenggaraan organisasi. ",
            "B. Perwujudan good governance dan pemenuhan lima pilar sistem tata pamong, yang mencakup: 
                1) Kredibel,
                2) Transparan,
                3) Akuntabel,
                4) Bertanggung jawab, 
                5) Adil.
                Skor = (A + (2 x B)) / 3",
            // "A. Komitmen pimpinan UPPS.",
            // "B. Kapabilitas pimpinan UPPS, mencakup aspek:
            //     1) perencanaan,
            //     2) pengorganisasian, 
            //     3) penempatan personel,
            //     4) pelaksanaan,
            //     5) pengendalian dan pengawasan, dan
            //     6) pelaporan yang menjadi dasar tindak lanjut.

            //     Skor = (A + (2 x B)) / 3",
            // "Mutu, manfaat, kepuasan dan keberlanjutan kerjasama pendidikan, penelitian dan PkM yang relevan dengan program studi. UPPS memiliki bukti yang sahih terkait kerjasama yang ada telah memenuhi 3 aspek berikut:
            //     1) memberikan manfaat bagi program studi dalam pemenuhan proses pembelajaran, penelitian, PkM.
            //     2) memberikan peningkatan kinerja tridharma dan fasilitas pendukung program studi.
            //     3) memberikan kepuasan kepada mitra industri dan mitra kerjasama lainnya, serta menjamin keberlanjutan kerjasama dan hasilnya.",
            // "A. Kerjasama pendidikan, penelitian, dan PkM yang relevan dengan program studi dan dikelola oleh UPPS dalam 3 tahun terakhir. Tabel 1 LKPS",
            // "B. Kerjasama tingkat internasional, nasional, wilayah/lokal yang relevan dengan program studi dan dikelola oleh UPPS dalam 3 tahun terakhir. Tabel 1 LKPS Skor = ((2 x A) + B) / 3",

        ];

        $id_prodi = [
            '1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20'
        ];

        $id_lembaga_akreditasi = [
            '1', '2', '3'
        ];

        $id_kriteria_standar = [
            "1", "2", "3", "4", "5", "6", "7"
        ];
        $kode = "PKA 1";


        $i = 1;
        foreach ($kriteria as $key => $value_kriteria) {

            foreach ($id_prodi as $key => $prodi_id) {

                $random_keys = array_rand($id_kriteria_standar, 1);
                $random_keys2 = array_rand($id_lembaga_akreditasi);

                $this->db->table('kriteria')->insert([
                    'id_prodi' => $prodi_id,
                    'uuid' => service('uuid')->uuid4()->toString(),
                    'kriteria' => $value_kriteria,
                    'id_kriteria_standar' => $id_kriteria_standar[$random_keys],
                    'id_lembaga_akreditasi' => $id_lembaga_akreditasi[$random_keys2],
                    'kode_kriteria' => $kode,
                    'bobot' => 1,
                ]);

                $this->db->table('kriteria_prodi')->insert([
                    'uuid' => service('uuid')->uuid4()->toString(),
                    'id_kriteria' => $i,
                    'id_prodi' => $prodi_id,
                ]);

                $i++;
                $kode = preg_replace_callback('/(\d+)$/', function ($matches) {
                    return $matches[1] + 1;
                }, $kode);
            }
        }



        foreach ($standar as $key => $value) {

            $this->db->table('kriteria_standar')->insert([
                'uuid' => service('uuid')->uuid4()->toString(),
                'standar' => $value,
                'is_aktif' => 1,
            ]);
        }


        // $this->db->table('indikator_ed')->insertBatch($data_indikator);
        // $this->db->table('form_ed')->insertBatch($data_form);
    }
}
