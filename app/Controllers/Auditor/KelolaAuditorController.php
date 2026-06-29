<?php

namespace App\Controllers\Auditor;

use App\Controllers\BaseController;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;

class KelolaAuditorController extends BaseController
{
    private $user;
    public function __construct()
    {
        $this->user = new UserModel();
    }

    public function index()
    {
        
        $uuid = session()->get('uuid');
        $user = $this->user->where('uuid', $uuid)->first();

        // dd($user);
        $data = [
            'title' => 'Kelola Data Pribadi',
            'currentPage' => 'kelola-data',
            'dataUser' => $user
        ];

        return view('auditor/kelolaData/kelolaPassword', $data);

    }

    public function savePassword(){

        $uuid = session()->get('uuid');

        if(!(($this->request->getPost('password')) == ($this->request->getPost('confirmpassword')))){
            return redirect()->back()->withInput()->with('gagal', "Password dan konfirmasi password tidak sesuai");
        }

        $password = password_hash($this->request->getVar('password'), PASSWORD_BCRYPT);

        $this->user->set('password', $password)->where('uuid', $uuid)->update();
        return redirect()->back()->withInput()->with('sukses', "Berhasil mengubah password");

    }
}
