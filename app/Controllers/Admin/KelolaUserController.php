<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;

class KelolaUserController extends BaseController
{
    private $user;
    public function __construct()
    {
        $this->user = new UserModel();
    }

    public function index()
    {
        
        // $uuid = session()->get('uuid');
        $user = $this->user->findAll();

        // dd($user);
        $data = [
            'title' => 'Kelola Data Pribadi',
            'currentPage' => 'kelola-data',
            'dataUsers' => $user
        ];

        return view('admin/kelolaData/index', $data);

    }

    public function detail($uuid){

        $user = $this->user->where('uuid', $uuid)->first();
        
        $data = [
            'title' => 'Kelola Data Pribadi',
            'currentPage' => 'kelola-data',
            'dataUser' => $user
        ];

        return view('admin/kelolaData/kelolaPassword', $data);

    }

    public function savePassword($uuid){

        if(!(($this->request->getPost('password')) == ($this->request->getPost('confirmpassword')))){
            return redirect()->back()->withInput()->with('gagal', "Password dan konfirmasi password tidak sesuai");
        }

        $password = password_hash($this->request->getVar('password'), PASSWORD_BCRYPT);

        $this->user->set('password', $password)->where('uuid', $uuid)->update();
        return redirect()->back()->withInput()->with('sukses', "Berhasil mengubah password");

    }
}
