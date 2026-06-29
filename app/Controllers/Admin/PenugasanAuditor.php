<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\AuditorModel;
use App\Models\PenugasanAuditorModel;
use App\Models\ProdiModel;
use App\Models\PeriodeModel;
use App\Models\KriteriaModel;
use App\Models\KriteriaProdiModel;
use CodeIgniter\HTTP\ResponseInterface;
use PhpParser\Node\Stmt\Return_;


class PenugasanAuditor extends BaseController
{
    protected $auditor;
    protected $prodi;
    protected $penugasanAuditor;
    protected $periode_Model;
    private $kriteriaProdi;

    public function __construct()
    {
        $this->auditor = new AuditorModel();
        $this->prodi = new ProdiModel();
        $this->penugasanAuditor = new PenugasanAuditorModel();
        $this->periode_Model = new PeriodeModel();
        $this->kriteriaProdi = new KriteriaProdiModel();
    }
    public function index()
    {
        $penugasanAuditor = $this->penugasanAuditor
            ->select('penugasan_auditor.uuid as uuid, penugasan_auditor.ketua as ketua ,auditor.nama as nama, prodi_tujuan.nama as prodi_tujuan, prodi_asal.nama as prodi_asal, periode.tanggal_mulai, periode.tanggal_selesai')
            ->join('auditor', 'auditor.id = penugasan_auditor.id_auditor')
            ->join('prodi as prodi_tujuan', 'prodi_tujuan.id = penugasan_auditor.id_prodi')
            ->join('auditor as a2', 'a2.id = penugasan_auditor.id_auditor')
            ->join('prodi as prodi_asal', 'prodi_asal.id = a2.id_prodi')
            ->join('periode', 'periode.id = penugasan_auditor.id_periode')
            ->findAll();


        // dd($penugasanAuditor);
        $data = [
            'title' => 'Penugasan Auditor',
            'currentPage' => 'penugasanAuditor',
            'penugasanAuditor' => $penugasanAuditor
        ];
        return view('admin/penugasanAuditor/index', $data);
    }

    public function create()
    {
        $prodi = $this->prodi->findAll();
        $auditor = $this->auditor->findAll();

        $data = [
            'title' => 'Tambah Penugasan Auditor',
            'currentPage' => 'penugasanAuditor',
            'auditor' => $auditor,
            'prodi' => $prodi
        ];

        return view('admin/penugasanAuditor/create', $data);
    }

    public function getProdiNameByAuditor($auditorId)
    {
        // Panggil model untuk mendapatkan ID prodi berdasarkan ID auditor
        $prodiId = $this->auditor->getProdiIdByAuditorId($auditorId);

        // Panggil model untuk mendapatkan nama prodi berdasarkan ID prodi
        $prodiName = $this->prodi->getProdiNameById($prodiId);

        // Mengembalikan respons dalam bentuk JSON
        return $this->response->setJSON(['prodi_name' => $prodiName, 'auditor_id' => $auditorId]);
    }


    public function save()
    {

        // Validasi input auditor dan prodi
        $validationRules = [
            'id_auditor' => 'required',
            'prodi' => 'required',
            'ketua' => 'required'
        ];

        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        // Mendapatkan id_prodi dari form (prodi tujuan)
        $prodiId = $this->request->getPost('prodi');

        // Check apakah kriteria prodi telah diisi
        // $kriteriaProdiModel = new KriteriaProdiModel();
        // $isEdCompleted = $kriteriaProdiModel->checkEdCompletion($prodiId);

        // check yang kubuat
        $kriteriaProdi = $this->kriteriaProdi->select('capaian, akar_penyebab, tautan_bukti, kriteria, bobot, prodi.nama as nama, prodi.uuid as uuid_prodi, fakultas, users.name as nama_user, users.id_prodi as id_prodi')
            ->join('kriteria', 'kriteria.id = kriteria_prodi.id_kriteria')
            ->join('prodi', 'prodi.id = kriteria_prodi.id_prodi')
            ->join('users', 'users.id_prodi = prodi.id')
            ->findAll();
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


        // jika form evaluasi belum terisi 100% tidak bisa melakukan penguasan auditor
        // $capaian = [];
        // $total = [];
        // $persentase_terisi = [];

        // $i = 0;
        // progress capaian per masing-masing prodi

        // pake nama prodi
        // $capaian = count($this->kriteriaProdi->join('prodi', 'prodi.id = kriteria_prodi.id_prodi')
        //     ->join('kriteria', 'kriteria.id = kriteria_prodi.id_kriteria')
        //     ->join('kriteria_standar', 'kriteria.id_kriteria_standar = kriteria_standar.id')
        //     ->where('akar_penyebab IS NOT null')
        //     ->where('tautan_bukti IS NOT null')
        //     ->where('kriteria_standar.is_aktif', 1)
        //     ->where('prodi.id', $this->request->getVar('prodi'))->findAll());
        // $total = count($this->kriteriaProdi->join('prodi', 'prodi.id = kriteria_prodi.id_prodi')
        //     ->join('kriteria', 'kriteria.id = kriteria_prodi.id_kriteria')
        //     ->join('kriteria_standar', 'kriteria.id_kriteria_standar = kriteria_standar.id')
        //     ->where('kriteria_standar.is_aktif', 1)
        //     ->where('prodi.id', $this->request->getVar('prodi'))->findAll());

        // if ($total != 0) {
        //     $persentase_terisi = ($capaian / $total) * 100;
        // } else {

        //     $persentase_terisi = 100;
        // }
        // // Jika kriteria prodi belum diisi, tampilkan pesan peringatan
        // if ($persentase_terisi < 100) {
        //     session()->setFlashdata('warning', 'Prodi harus menyelesaikan Form Evaluasi Diri sebelum menugaskan auditor.');
        //     return redirect()->back()->withInput();
        // }
        // 

        // // Jika kriteria prodi belum diisi, tampilkan pesan peringatan
        // if ($persentase_terisi < 100) {
        //     session()->setFlashdata('warning', 'Prodi harus menyelesaikan Form Evaluasi Diri sebelum menugaskan auditor.');
        //     return redirect()->back()->withInput();
        // }
        // Check apakah prodi asal dan prodi tujuan sama
        // $auditorProdi = $this->request->getPost('id_auditor');
        // dapatin id_prodi dari auditor
        // $auditor = $this->auditor->where('id', $auditorProdi)->first();

        // dd($auditorProdi);
        // if ($prodiId == $auditor['id_prodi']) {
        //     session()->setFlashdata('warning', 'Prodi asal dan prodi tujuan tidak boleh sama.');
        //     return redirect()->back()->withInput();
        // }
        // Lanjutkan dengan penyimpanan data penugasan auditor jika kriteria prodi telah diisi
        $periode = $this->periode_Model->select('id')->first();
        // dd($this->request->getPost('id_auditor'));

        if (is_null($periode)) {
            return redirect()->to('admin/penugasan-auditor/tambah')->with('gagal', 'Gagal menambah penugasan auditor, Jadwal AMI belum dibuat');
        }

        $data = [
            "uuid" => service('uuid')->uuid4()->toString(),
            'id_auditor' => $this->request->getPost('id_auditor'),
            'id_prodi' => $prodiId,
            'ketua' => $this->request->getPost('ketua'),
            'id_periode' => $periode['id'] // Pastikan ini sudah sesuai dengan struktur tabel Anda
        ];

        // Menyimpan data penugasan auditor
        $this->penugasanAuditor->insert($data);

        return redirect()->to('admin/penugasan-auditor')->with('sukses', 'Berhasil menambah Penugasan Auditor');
    }


    public function update($uuid)
    {
        $penugasanAuditor = $this->penugasanAuditor->select('penugasan_auditor.uuid as uuid, penugasan_auditor.ketua as ketua ,auditor.id as id_auditor,prodi.id as id_prodi , auditor.nama as nama, prodi.nama as prodi, periode.tanggal_mulai, periode.tanggal_selesai')->join('auditor', 'auditor.id = penugasan_auditor.id_auditor')->join('prodi', 'prodi.id = penugasan_auditor.id_prodi')->join('periode', 'periode.id = penugasan_auditor.id_periode')->where('penugasan_auditor.uuid', $uuid)->first();
        $prodi = $this->prodi->findAll();
        $auditor = $this->auditor->findAll();
        $data = [
            'title' => "Ubah Penugasan Auditor",
            'currentPage' => 'penugasanAuditor',
            'penugasanAuditor' => $penugasanAuditor,
            'prodi' => $prodi,
            'auditor' => $auditor,
            'uuid' => $uuid
        ];


        return view('admin/penugasanAuditor/update', $data);
    }


    public function updatePost($uuid)
    {
        // Validasi input auditor dan prodi
        $validationRules = [
            'id_auditor' => 'required',
            'prodi' => 'required',
            'ketua' => 'required'
        ];

        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        // Mendapatkan id_prodi dari form
        $prodiId = $this->request->getPost('prodi');

        // check yang kubuat
        // $kriteriaProdi = $this->kriteriaProdi->select('capaian, akar_penyebab, tautan_bukti, kriteria, bobot, prodi.nama as nama, prodi.uuid as uuid_prodi, fakultas, users.name as nama_user, users.id_prodi as id_prodi')
        //     ->join('kriteria', 'kriteria.id = kriteria_prodi.id_kriteria')
        //     ->join('prodi', 'prodi.id = kriteria_prodi.id_prodi')
        //     ->join('users', 'users.id_prodi = prodi.id')
        //     ->findAll();
        // $dataProdi = [];
        // $dataAuditi = [];
        // $uuidProdi = [];

        // foreach ($kriteriaProdi as $key => $value) {
        //     array_push($dataProdi, $value['nama']);
        //     array_push($dataAuditi, $value['nama_user']);
        //     array_push($uuidProdi, $value['uuid_prodi']);
        // }
        // $dataAuditi = array_unique($dataAuditi);
        // $dataProdi = array_unique($dataProdi);
        // $uuidProdi = array_unique($uuidProdi);

        // $capaian = [];
        // $total = [];
        // $persentase_terisi = [];

        // $i = 0;
        // // progress capaian per masing-masing prodi

        // // pake nama prodi
        // $capaian = count($this->kriteriaProdi->join('prodi', 'prodi.id = kriteria_prodi.id_prodi')
        //     ->join('kriteria', 'kriteria.id = kriteria_prodi.id_kriteria')
        //     ->join('kriteria_standar', 'kriteria.id_kriteria_standar = kriteria_standar.id')
        //     ->where('akar_penyebab IS NOT null')
        //     ->where('tautan_bukti IS NOT null')
        //     ->where('kriteria_standar.is_aktif', 1)
        //     ->where('prodi.id', $this->request->getVar('prodi'))->findAll());
        // $total = count($this->kriteriaProdi->join('prodi', 'prodi.id = kriteria_prodi.id_prodi')
        //     ->join('kriteria', 'kriteria.id = kriteria_prodi.id_kriteria')
        //     ->join('kriteria_standar', 'kriteria.id_kriteria_standar = kriteria_standar.id')
        //     ->where('kriteria_standar.is_aktif', 1)
        //     ->where('prodi.id', $this->request->getVar('prodi'))->findAll());

        // if ($total != 0) {
        //     $persentase_terisi = ($capaian / $total) * 100;
        // } else {

        //     $persentase_terisi = 100;
        // }
        // Jika kriteria prodi belum diisi, tampilkan pesan peringatan
        // if ($persentase_terisi < 100) {
        //     session()->setFlashdata('warning', 'Prodi harus menyelesaikan Form Evaluasi Diri sebelum menugaskan auditor.');
        //     return redirect()->back()->withInput();
        // }
        // // Check apakah prodi asal dan prodi tujuan sama
        // $id_auditor = $this->request->getPost('id_auditor');
        // $auditorProdiBerdasakanIDAuditor = $this->penugasanAuditor
        //     ->select('auditor.id_prodi')
        //     ->join('auditor', 'auditor.id = penugasan_auditor.id_auditor')
        //     ->where('id_auditor', $id_auditor)
        //     ->first();

        // if ($auditorProdiBerdasakanIDAuditor['id_prodi'] == $prodiId) {
        //     session()->setFlashdata('warning', 'Prodi asal dan prodi tujuan tidak boleh sama.');
        //     // dd($auditorProdiBerdasakanIDAuditor['id_prodi'], $prodiId);
        //     return redirect()->back()->withInput();
        // }
        // dd($auditorProdiBerdasakanIDAuditor['id_prodi'], $prodiId);
        $data = [
            'id_auditor' => $this->request->getPost('id_auditor'),
            'id_prodi' => $prodiId,
            'ketua' => $this->request->getPost('ketua'),

        ];

        // dd($data);
        $this->penugasanAuditor->set($data)->where('uuid', $uuid)->update();
        return redirect()->to('/admin/penugasan-auditor')->with('sukses', 'Berhasil mengubah Penugasan Auditor');
    }
    public  function delete($uuid)
    {
        $this->penugasanAuditor->where('uuid', $uuid)->delete();

        return redirect()->to('/admin/penugasan-auditor')->with('sukses', 'Berhasil menghapus Penugasan auditor');
    }
}
