<?php

namespace App\Controllers\Pimpinan;

use App\Controllers\BaseController;
use App\Models\ProdiModel;
use App\Models\UploadBerkasModel;
use App\Models\UserModel;

class LihatBerkas extends BaseController
{

    private $users;
    private $berkas_ttd;
    private $prodi;
    public function __construct()
    {
        $this->users = new UserModel();
        $this->berkas_ttd = new UploadBerkasModel();
        $this->prodi = new ProdiModel();
    }
    public function index()
    {
        $berkas_ttd = $this->berkas_ttd
            ->select('auditor.nama as nama_auditor,prodi.nama as nama_prodi, link_form4, link_form5')
            ->join('prodi', 'prodi.id = upload_berkas.id_prodi')
            ->join('penugasan_auditor', 'penugasan_auditor.id = upload_berkas.id_penugasan_auditor')
            ->join('auditor', 'auditor.id = penugasan_auditor.id_auditor')
            ->findAll();
        $data = [
            'title' => 'Lihat Berkas',
            'currentPage' => 'lihat-berkas',
            'berkas_ttd' => $berkas_ttd,


        ];
        return view('pimpinan/berkas/index', $data);
    }
}
