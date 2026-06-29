<?php

namespace App\Controllers\Auditor;

use App\Controllers\BaseController;
use App\Models\AuditorModel;
use App\Models\PenugasanAuditorModel;
use App\Models\PeriodeModel;
use App\Models\ProdiModel;
use App\Models\UploadBerkasModel;
use App\Models\UserModel;
use Config\Database;

class UploadBerkas extends BaseController
{

    private $users;
    private $periodeModel;
    private $auditor;
    private $penugasanAuditor;
    private $prodi;
    private $uploadBerkas;


    public function __construct()
    {
        $this->users = new UserModel();
        $this->periodeModel = new PeriodeModel();
        $this->auditor = new AuditorModel();
        $this->penugasanAuditor = new PenugasanAuditorModel();
        $this->prodi = new ProdiModel();
        $this->uploadBerkas = new UploadBerkasModel();
    }

    public function beranda()
    {
        $jadwalPeriode = $this->periodeModel->first();
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
        $penugasan_auditor = $this->penugasanAuditor->select('penugasan_auditor.id,penugasan_auditor.uuid, prodi.uuid as uuid_prodi, ketua, auditor.nama as nama_auditor, fakultas, kode_auditor, prodi.nama as nama_prodi')
            ->join('prodi', 'prodi.id = penugasan_auditor.id_prodi')
            ->join('auditor', 'auditor.id = penugasan_auditor.id_auditor')
            ->where('id_auditor', $auditor['id'])->findAll();
        // dd($penugasan_auditor); 

        if (is_null($penugasan_auditor) || count($penugasan_auditor) == 0) {
            return redirect()->to('auditor/dashboard')->with('gagal', $auditor['nama'] . " Belum ditugaskan");
        }

        $data = [
            "title" => "Upload Berkas",
            "currentPage" => "upload-berkas",
            'penugasan_auditor' => $penugasan_auditor,
            'formTerkunci' => $formTerkunci,
        ];

        return view('auditor/uploadberkas/beranda', $data);
    }

    public function index($uuid2)
    {
        $id_user = session()->get('id');
        $auditor = $this->auditor->where('id_user', $id_user)->first();
        if (!$auditor) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Auditor not found");
        }
        $prodiIds = $this->penugasanAuditor->select('id_prodi')
            ->where('id_auditor', $auditor['id'])
            ->findColumn('id_prodi');

        if (empty($prodiIds)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("No prodi found for the auditor");
        }
        $prodi = $this->prodi->where('uuid', $uuid2)->first();

        $uploadBerkas = $this->uploadBerkas
            ->select('upload_berkas.*')
            ->join('prodi', 'prodi.id = upload_berkas.id_prodi')
            ->where('prodi.uuid', $uuid2)
            ->first();

        $data = [
            'title' => 'Upload Berkas',
            'currentPage' => 'upload-berkas',
            'uuid2' => $uuid2,
            'prodi' => $prodi,
            'uploadBerkas' => $uploadBerkas,
        ];

        return view('auditor/uploadberkas/index', $data);
    }
    public function formUpload($uuid2)
    {
        $uuid = session()->get('uuid');
        $user = $this->users->where('uuid', $uuid)->first();
        $auditor = $this->auditor->where('id_user', $user['id'])->first();
        $prodi = $this->prodi->where('uuid', $uuid2)->first();
        $penugasan_auditor = $this->penugasanAuditor->select('penugasan_auditor.id as id')
            ->join('prodi', 'prodi.id = id_prodi')->where('id_auditor', $auditor['id'])->where('prodi.uuid', $uuid2)->first();


        $data = [
            'title' => 'Upload Berkas',
            'currentPage' => 'upload-berkas',
            'id_penugasanAuditor' => $penugasan_auditor,
            'uuid2' => $uuid2,
            'prodi' => $prodi
        ];
        return view("auditor/uploadberkas/createUploadBerkas", $data);
    }
    public function formUploadPost($uuid2)
    {

        $data = [
            "uuid" => service('uuid')->uuid4()->toString(),
            'id_penugasan_auditor' => $this->request->getPost('id_penugasanAuditor'),
            'id_prodi' => $this->request->getPost('id_prodi'),
            'link_form4' => $this->request->getPost('link_form4'),
            'link_form5' => $this->request->getPost('link_form5'),

        ];

        $this->uploadBerkas->insert($data);
        return redirect()->to("/auditor/upload-berkas/$uuid2")->with('sukses', 'Berhasil upload berkas');
    }

    public function formUploadUpdate($uuid, $uuid2)
    {
        $uploadBerkas = $this->uploadBerkas
            ->where('uuid', $uuid2)
            ->first();
        if (!$uploadBerkas) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("uploadBerkas not found");
        }
        $prodi = $this->prodi->where('uuid', $uuid)->first();
        $data = [
            'title' => 'Ubah Upload Berkas',
            'currentPage' => 'upload-berkas',
            'uploadBerkas' => $uploadBerkas,
            'uuid_prodi' => $uuid,
            'uuid_uploadBerkas' => $uuid2,
            'prodi' => $prodi
        ];

        return view("auditor/uploadberkas/updateUploadBerkas", $data);
    }


    function formUploadUpdatePost($uuid_prodi, $uuid_uploadBerkas)
    {
        $data = [
            'link_form4' => $this->request->getPost('link_form4'),
            'link_form5' => $this->request->getPost('link_form5'),
        ];

        $this->uploadBerkas->set($data)->where('uuid', $uuid_uploadBerkas)->update();
        return redirect()->to("/auditor/upload-berkas/$uuid_prodi")->with('sukses', 'Berhasil mengubah data upload berkas');
    }

    function formUploadDelete($uuid_prodi, $uuid_uploadBerkas)
    {
        $this->uploadBerkas->where('uuid', $uuid_uploadBerkas)->delete();
        return redirect()->to("/auditor/upload-berkas/$uuid_prodi")->with('sukses', 'Berhasil menghapus data upload berkas');
    }
}
