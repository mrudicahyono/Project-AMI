<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;

class KelolaAkunController extends BaseController
{

    private $user;
    public function __construct(){
        $this->user = new UserModel();
    }

    public function index()
    {
        $user = $this->user->findAll();

        $data = [
            'title' => 'Kelola Data Pribadi',
            'currentPage' => 'kelola-akses',
            'dataUsers' => $user
        ];

        return view('admin/kelolaAkun/index', $data);

    }

    public function terima($uuid){
        $this->user->set('akses', 1)->where('uuid', $uuid)->update();
        return redirect()->back()->withInput()->with('sukses', "Data berhasil diubah");        
    }

    public function tolak($uuid){
        $this->user->set('akses', 0)->where('uuid', $uuid)->update();
        return redirect()->back()->withInput()->with('sukses', "Data berhasil diubah");
    }
}
