<?php

namespace App\Controllers\Auditor;

use App\Controllers\BaseController;
use App\Models\AuditorModel;
use App\Models\KriteriaProdiModel;
use App\Models\PenugasanAuditorModel;
use App\Models\PeriodeModel;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;

class ViewEDAuditorController extends BaseController
{

    private $kriteriaProdi;
    private $auditor;
    private $penugasanAuditor;
    private $users;
    private $periode;

    public function __construct()
    {
        $this->kriteriaProdi = new KriteriaProdiModel();
        $this->auditor = new AuditorModel();
        $this->penugasanAuditor = new PenugasanAuditorModel();
        $this->users = new UserModel();
        $this->periode = new PeriodeModel();
    }


    // index
    public function index()
    {

        $jadwalPeriode = $this->periode->first();
        if(is_null($jadwalPeriode) || !isset($jadwalPeriode)){
            return redirect()->to('auditor/dashboard')->with('gagal', 'Jadwal AMI Belum dibuat');;
        }
        $tanggalSelesai = $jadwalPeriode['tanggal_selesai'];
        // Mengonversi tanggal selesai ke format yang dapat dibandingkan
        $tanggalSelesaiTimestamp = strtotime($tanggalSelesai);
        $tanggalSekarangTimestamp = time();
        // Jika tanggal selesai sudah lewat, kunci form
        $formTerkunci = false;
        if ($tanggalSelesaiTimestamp < $tanggalSekarangTimestamp) {
            $formTerkunci = true;
        }

        $id_user = session()->get('id');
        $user = $this->users->where('id', $id_user)->first();
        $auditor = $this->auditor->where('id_user', $id_user)->first();

        if (is_null($auditor)) {
            $data = [
                'title' => 'Dashboard',
                'currentPage' => 'dashboard',
                'error' => $user['name'] . " Belum memiliki prodi, silahkan hubungi admin",

            ];
            return view('auditor/dashboard', $data);
        }
        // dd($auditor);
        $penugasan_auditor = $this->penugasanAuditor->where('id_auditor', $auditor['id'])->findAll();
        // dd($penugasan_auditor); 

        if (is_null($penugasan_auditor) || count($penugasan_auditor) == 0) {
            return redirect()->to('auditor/dashboard')->with('gagal', $auditor['nama'] . " Belum ditugaskan");
        }


        $kriteriaProdi = [];
        $i = 0;
        foreach ($penugasan_auditor as $key => $value) {

            $kriteriaProdi[$i] = $this->kriteriaProdi->select('capaian, capaian_auditi, akar_penyebab, tautan_bukti, kriteria, bobot, prodi.nama as nama, prodi.uuid as uuid_prodi, fakultas, users.name as nama_user, users.id_prodi as id_prodi')
                ->join('kriteria', 'kriteria.id = kriteria_prodi.id_kriteria')
                ->join('prodi', 'prodi.id = kriteria_prodi.id_prodi')
                ->join('users', 'users.id_prodi = prodi.id')
                ->where('users.id_prodi', $value['id_prodi'])
                ->findAll();
            $i++;
        }

        $dataProdi = [];
        $dataAuditi = [];
        $uuidProdi = [];

        $i = 0;
        foreach ($kriteriaProdi as $key => $value) {

            array_push($dataProdi, $value[$key]['nama']);
            array_push($dataAuditi, $value[$key]['nama_user']);
            array_push($uuidProdi, $value[$key]['uuid_prodi']);
            $i++;
        }

        // dd($dataAuditi);
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
                ->where('capaian != 0')
                ->where('catatan IS NOT null')
                ->where('kriteria_standar.is_aktif', 1)
                ->where('prodi.nama', $value)->findAll());
            $total[$i] = count($this->kriteriaProdi->join('prodi', 'prodi.id = kriteria_prodi.id_prodi')
                ->join('kriteria', 'kriteria.id = kriteria_prodi.id_kriteria')
                ->join('kriteria_standar', 'kriteria.id_kriteria_standar = kriteria_standar.id')
                ->where('kriteria_standar.is_aktif', 1)
                ->where('prodi.nama', "$value")->findAll());

            // dd($capaian);
            if ($total[$i] != 0) {
                $persentase_terisi[$i] = floor(($capaian[$i] / $total[$i]) * 100);
            } else {

                $persentase_terisi[$i] = 100;
            }

            $i++;
        }

        $data = [
            "title" => "Lihat Progress Evaluasi Diri",
            "currentPage" => "lihat-form-ed",
            'nama_prodi' => $dataProdi,
            'nama_auditi' => $dataAuditi,
            'persentase_terisi' => $persentase_terisi,
            'uuid_prodi' => $uuidProdi,
            'formTerkunci' => $formTerkunci,
        ];

        return view('auditor/viewED/index', $data);
    }

    // view ed detail
    public function create($uuid2)
    {
        $uuid = session()->get('uuid');
        $user = $this->users->where('uuid', $uuid)->first();
        $auditor = $this->auditor->where('id_user', $user['id'])->first();
        $penugasan_auditor = $this->penugasanAuditor->where('id_auditor', $auditor['id'])->first();



        // dd($user);
        if (is_null($auditor['id_prodi'])) {
            return redirect()->to('auditi/dashboard')->with('gagal', 'Akun anda belum memiliki prodi, silahkan hubungi admin');
        } else {
            $form_ed = $this->kriteriaProdi->select('kriteria_prodi.uuid as uuid, standar, kode_kriteria, is_aktif, kriteria.id_kriteria_standar as id_standar, id_kriteria, prodi.id as id_prodi, capaian, capaian_auditi, akar_penyebab, tautan_bukti, nama, id_lembaga_akreditasi, kriteria, bobot, catatan')
                ->join('prodi', 'prodi.id = kriteria_prodi.id_prodi')
                ->join('kriteria', 'kriteria.id = kriteria_prodi.id_kriteria')
                ->join('kriteria_standar', 'kriteria_standar.id = kriteria.id_kriteria_standar')
                ->where('prodi.uuid', $uuid2)
                ->where('is_aktif', 1)
                ->findAll();

            if (count($form_ed) == 0) {
                return redirect()->to('auditor/dashboard')->with('gagal', 'Data form belum ada');
            }
            // buat hitung progress pengisian ed
            $capaian = count($this->kriteriaProdi->join('prodi', 'prodi.id = kriteria_prodi.id_prodi')
                ->join('kriteria', 'kriteria.id = kriteria_prodi.id_kriteria')
                ->join('kriteria_standar', 'kriteria.id_kriteria_standar = kriteria_standar.id')
                ->where('capaian != 0')
                ->where('catatan IS NOT null')
                ->where('kriteria_standar.is_aktif', 1)
                ->where('prodi.uuid', $uuid2)->findAll());
            $total = count($this->kriteriaProdi->join('prodi', 'prodi.id = kriteria_prodi.id_prodi')
                ->join('kriteria', 'kriteria.id = kriteria_prodi.id_kriteria')
                ->join('kriteria_standar', 'kriteria.id_kriteria_standar = kriteria_standar.id')
                ->where('kriteria_standar.is_aktif', 1)
                ->where('prodi.uuid', $uuid2)->findAll());

            $persentase_terisi = 0;

            if ($total != 0) {

                $persentase_terisi = floor(($capaian / $total) * 100);
            } else {
                $persentase_terisi = 100;
            }

            $jadwalPeriode = $this->periode->first();
            $tanggalSelesai = $jadwalPeriode['tanggal_selesai'];
            // Mengonversi tanggal selesai ke format yang dapat dibandingkan
            $tanggalSelesaiTimestamp = strtotime($tanggalSelesai);
            $tanggalSekarangTimestamp = time();
            // Jika tanggal selesai sudah lewat, kunci form
            $formTerkunci = false;
            if ($tanggalSelesaiTimestamp < $tanggalSekarangTimestamp) {
                $formTerkunci = true;
            }

            $data = [
                'title' => 'Isi Form ED',
                'currentPage' => 'form-ed',
                'form_ed' => $form_ed,
                'persentase' => $persentase_terisi,
                "currentPage" => "lihat-form-ed",
                'prodi' => $form_ed[0]['nama'],
                'uuid' => $uuid2,
                'formTerkunci' => $formTerkunci,
                'penugasanAuditor' => $penugasan_auditor
            ];
            return view('auditor/viewED/create', $data);
        }
    }


    // create post
    public function createPost($uuid2)
    {


        foreach ($this->request->getVar() as $key => $value) {
            if ($key == "csrf_test_name" || $key == "datatable_length") {
                continue;
            }

            // jika capaian
            if (strlen($key) == 36) {
                if ($value == "") {
                    // echo "Data capaian kosong<br>";
                } else {
                    $uuid = $key;
                    $this->kriteriaProdi->set('capaian', $value)->where('uuid', $uuid)->update();
                }
            }

            // jika catatan terisi
            if (strlen($key) == 43) {
                if ($value == "") {
                    // echo "Data catatan kosong<br>";
                } else {
                    $uuid = substr($key, 7);
                    // dd($value);
                    $this->kriteriaProdi->set('catatan', $value)->where('uuid', $uuid)->update();
                }
            }
        }

        $capaian = count($this->kriteriaProdi->join('prodi', 'prodi.id = kriteria_prodi.id_prodi')
            ->join('kriteria', 'kriteria.id = kriteria_prodi.id_kriteria')
            ->join('kriteria_standar', 'kriteria.id_kriteria_standar = kriteria_standar.id')
            ->where('capaian != 0')
            ->where('catatan IS NOT null')
            ->where('kriteria_standar.is_aktif', 1)
            ->where('prodi.uuid', $uuid2)->findAll());
        $total = count($this->kriteriaProdi->join('prodi', 'prodi.id = kriteria_prodi.id_prodi')
            ->join('kriteria', 'kriteria.id = kriteria_prodi.id_kriteria')
            ->join('kriteria_standar', 'kriteria.id_kriteria_standar = kriteria_standar.id')
            ->where('kriteria_standar.is_aktif', 1)
            ->where('prodi.uuid', $uuid2)->findAll());

        $persentase_terisi = 0;

        if ($total != 0) {

            $persentase_terisi = floor(($capaian / $total) * 100);
        } else {
            $persentase_terisi = 100;
        }

        return redirect()->back()->with('sukses', 'Berhasil mengubah ED')->with('persentase', "$persentase_terisi");
    }
}
