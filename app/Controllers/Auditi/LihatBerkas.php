<?php

namespace App\Controllers\Auditi;

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
        $id_user = session()->get('id');
        $users = $this->users
            ->where('id', $id_user)
            ->first();


        $berkas_ttd = $this->berkas_ttd
            ->select('upload_berkas.*')
            ->where('id_prodi', $users['id_prodi'])
            ->first();

        $prodi = $this->prodi
            ->where('id', $users['id_prodi'])
            ->first();

        $data = [
            'title' => 'Lihat Berkas',
            'currentPage' => 'lihat-berkas',
            'berkas_ttd' => $berkas_ttd,
            'prodi' => $prodi

        ];
        return view('auditi/berkas/index', $data);
    }
}
