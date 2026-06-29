<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;

class UserController extends BaseController
{

    private $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }


    // menampilkan view register
    public function register()
    {
        // Logic pengecekan jika user sudah login berdasarkan role, maka user tidak bisa mengakses halaman login
        if (session()->get('logged_in')) {
            $role = session()->get('role_id');
            if (in_array($role, ['admin', 'pimpinan', 'auditor', 'audit'])) {
                return redirect()->to("/{$role}/dashboard");
            }
        }
        return view('register');
    }


    // register controller
    public function saveRegister()
    {

        // membuat uuid
        $uuid = service('uuid');
        $uuid4 = $uuid->uuid4();
        $uuid4String = $uuid4->toString();

        if(!(($this->request->getPost('password')) == ($this->request->getPost('confirmpassword')))){
            $validation = \Config\Services::validation();
            return redirect()->back()->withInput()->with('gagal', "Password dan konfirmasi password tidak sesuai");
        }

        // validasi register
        if (!$this->validate([
            'name' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Harus diisi'
                ]
            ],
            'email' => [
                'rules' => 'required|valid_email|is_unique[users.email]',
                'errors' => [
                    'required' => '{field} harus diisi',
                    'valid_email' => 'format email salah!',
                    'is_unique' => '{field} sudah terdaftar'
                ]
            ],
            'password' => [
                'rules' => 'required|matches[password]',
                'errors' => [
                    'required' => '{field} harus diisi'
                ]
            ],
            'confirmpassword' => [
                'rules' => 'required|matches[password]',
                'errors' => [
                    'required' => '{field} harus diisi'
                ]
            ]
        ])) {
            $validation = \Config\Services::validation();
            return redirect()->back()->withInput()->with('validation', $validation->getErrors());
        }

        // hash password menggunakan bcrypt
        $password = password_hash(htmlspecialchars($this->request->getVar('password')), PASSWORD_BCRYPT);

        // save password
        $isSave = $this->userModel->save([
            'uuid' => $uuid4String,
            'name' => htmlspecialchars($this->request->getVar('name')),
            'email' => htmlspecialchars($this->request->getVar('email')),
            'password' => $password,
        ]);

        // cek berhasil register
        if ($isSave) {
            session()->setFlashdata('pesan', 'Berhasil membuat akun, silahkan login !');
            session()->setFlashdata('alert_type', 'success');
            return redirect()->to('/');
        } else {
            session()->setFlashdata('email', 'Gagal membuat akun!');
            session()->setFlashdata('alert_type', 'danger');
            return redirect()->to('/');
        }
    }
}
