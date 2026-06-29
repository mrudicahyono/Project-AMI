<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\KriteriaModel;
use App\Models\KriteriaProdiModel;
use CodeIgniter\HTTP\ResponseInterface;

class ViewEDController extends BaseController
{

    private $kriteria;
    private $kriteriaProdi;

    public function __construct()
    {
        $this->kriteria = new KriteriaModel();
        $this->kriteriaProdi = new KriteriaProdiModel();
    }

    public function index()
    {

        $kriteriaProdi = $this->kriteriaProdi->select('capaian, capaian_auditi, akar_penyebab, tautan_bukti, kriteria, bobot, prodi.nama as nama, prodi.uuid as uuid_prodi, fakultas, users.name as nama_user, users.id_prodi as id_prodi')
                                            ->join('kriteria', 'kriteria.id = kriteria_prodi.id_kriteria')
                                            ->join('prodi', 'prodi.id = kriteria_prodi.id_prodi')
                                            ->join('users', 'users.id_prodi = prodi.id')->findAll();
        // dd($kriteriaProdi);

        $dataProdi = [];
        $dataAuditi = [];
        $uuidProdi = [];

        foreach ($kriteriaProdi as $key => $value) {
            array_push($dataProdi, $value['nama']);
            array_push($dataAuditi, $value['nama_user']);
            array_push($uuidProdi, $value['uuid_prodi']);
        }
        $dataAuditi = array_unique($dataAuditi);
        $dataProdi = array_unique($dataProdi);
        $uuidProdi = array_unique($uuidProdi);

        $capaian = [];
        $total = [];
        $persentase_terisi = [];

        $i = 0;
        // progress capaian per masing-masing prodi
        foreach ($dataProdi as $key => $value) {

            // pake nama prodi
            $capaian[$i] = count($this->kriteriaProdi->join('prodi', 'prodi.id = kriteria_prodi.id_prodi')
                ->join('kriteria', 'kriteria.id = kriteria_prodi.id_kriteria')
                ->join('kriteria_standar', 'kriteria.id_kriteria_standar = kriteria_standar.id')
                ->where('akar_penyebab IS NOT null')
                ->where('tautan_bukti IS NOT null')
                ->where('capaian_auditi != 0')
                ->where('kriteria_standar.is_aktif', 1)
                ->where('prodi.nama', $value)->findAll());
            $total[$i] = count($this->kriteriaProdi->join('prodi', 'prodi.id = kriteria_prodi.id_prodi')
                ->join('kriteria', 'kriteria.id = kriteria_prodi.id_kriteria')
                ->join('kriteria_standar', 'kriteria.id_kriteria_standar = kriteria_standar.id')
                ->where('kriteria_standar.is_aktif', 1)
                ->where('prodi.nama', "$value")->findAll());

            if ($total[$i] != 0) {
                $persentase_terisi[$i] = floor(($capaian[$i] / $total[$i]) * 100);
            } else {

                $persentase_terisi[$i] = 100;
            }

            $i++;
        }

        $data = [
            "title" => "Lihat Progress Evaluasi Diri",
            "currentPage" => "lihat-kriteria-ed",
            'nama_prodi' => $dataProdi,
            'nama_auditi' => $dataAuditi,
            'persentase_terisi' => $persentase_terisi,
            'uuid_prodi' => $uuidProdi,
        ];

        return view('admin/viewED/index', $data);
    }


    public function view($uuid)
    {

        $form_ed = $this->kriteriaProdi->select('standar, is_aktif, kriteria_prodi.uuid as uuid, id_kriteria, catatan ,kriteria_prodi.id_prodi, capaian, capaian_auditi, akar_penyebab, tautan_bukti, nama, id_lembaga_akreditasi, kriteria, kode_kriteria, bobot')->join('prodi', 'prodi.id = kriteria_prodi.id_prodi')->join('kriteria', 'kriteria.id = kriteria_prodi.id_kriteria')->join('kriteria_standar', 'kriteria_standar.id = kriteria.id_kriteria_standar')->where('prodi.uuid', $uuid)->findAll();

        if (count($form_ed) == 0) {
            return redirect()->to('admin/kriteria-ed/view')->with('gagal', 'Data form kriteria prodi belum ada');
        }
        // buat hitung progress pengisian ed
        $capaian = count($this->kriteriaProdi->join('prodi', 'prodi.id = kriteria_prodi.id_prodi')
            ->join('kriteria', 'kriteria.id = kriteria_prodi.id_kriteria')
            ->join('kriteria_standar', 'kriteria.id_kriteria_standar = kriteria_standar.id')
            ->where('akar_penyebab IS NOT null')
            ->where('tautan_bukti IS NOT null')
            ->where('capaian_auditi != 0')
            ->where('kriteria_standar.is_aktif', 1)
            ->where('prodi.uuid', "$uuid")->findAll());
        $total = count($this->kriteriaProdi->join('prodi', 'prodi.id = kriteria_prodi.id_prodi')
            ->join('kriteria', 'kriteria.id = kriteria_prodi.id_kriteria')
            ->join('kriteria_standar', 'kriteria.id_kriteria_standar = kriteria_standar.id')
            ->where('kriteria_standar.is_aktif', 1)
            ->where('prodi.uuid', "$uuid")->findAll());

        // dd($total);

        $persentase_terisi = 0;

        if ($total != 0) {

            $persentase_terisi = floor(($capaian / $total) * 100);
        }else {
            $persentase_terisi = 100;
        }


        $data = [
            'title' => 'Isi Form ED',
            'currentPage' => 'lihat-kriteria-ed',
            'form_ed' => $form_ed,
            'persentase' => $persentase_terisi,
            'prodi' => $form_ed[0]['nama']

        ];
        return view('admin/viewED/viewdetail', $data);
    }

    public function delete(){
        $data = $this->request->getVar('selectedItems');
        if(is_null($data)){
            return redirect()->back()->with('gagal', "Gagal menghapus ED, tidak ada data yang terpilih");
        }

        $updated = [
            "capaian_auditi" => 0,
            "capaian" => 0,
            "akar_penyebab" => null,
            "tautan_bukti" => null,
            "catatan" => null,
        ];

        foreach ($data as $key => $value) {
            // d($value);
            $this->kriteriaProdi->set($updated)->where('uuid', $value)->update();
        }
        return redirect()->back()->with('sukses', "Sukses menghapus ED");
        
    }

}
