<?php

namespace App\Controllers;

use App\Database\Migrations\User;
use App\Helpers\LoginHelpers;
use App\Models\UserModel;

class Login extends BaseController
{
    public function index()
    {
        if (session()->get('logged_in')) {
            $role = session()->get('role_id');
            return redirect()->to("$role/dashboard");
        }
        // menjalankan validation 
        $data = [
            'validation' => \Config\Services::validation()
        ];

        return view('login', $data);
    }

    public function login_action()
    {
        // membuat rules untuk validation
        $rules = [
            'email' => 'required|valid_email',
            'password' => 'required'
        ];

        // Memngecek rules apakah sudah mengikuti aturan
        if (!$this->validate($rules)) {
            $email = $this->request->getVar('email');
            $password = $this->request->getVar('password');


            // cek email atau password jika string kosong atau null
            if ($email == "" || $email == null || $password == "" || $password == null) {
                session()->setFlashdata('pesan', 'Email atau Password masih kosong');
                session()->setFlashdata('alert_type', 'danger');
                return redirect()->to('/')->withInput();
            }

            // ambil dari variable data diatas ambil keynya itu validator
            $data['validation'] = $this->validator;

            return view('login', $data);
        } else {
            // menginisialisasi session
            $session = session();
            // menginisalisasi model
            $userModel = new UserModel();

            // mengambil data email  dan password dari inputan user
            $email = $this->request->getVar('email');
            $password = $this->request->getVar('password');
            // mengambil data email dari database 
            $cekEmail = $userModel->where('email', $email)->first();

            // Kemudian di cek, Ketika email nya tidak ada maka akan menampikan session berupa flashData
            // yang bernama pesan yang isi messagenya: Email atau password anda salah dan arahkan 
            // balik ke halaman login
            if ($cekEmail) {

                if ($cekEmail['akses'] == 0) {
                    session()->setFlashdata('pesan', 'Akun anda belum memiliki akses ke aplikasi, silahkan hubungi admin');
                    session()->setFlashdata('alert_type', 'danger');
                    return redirect()->to('/')->withInput();
                }
                // jika email benar maka akan cek passwordnya
                // ambil password dari database yang kita paramter nya itu kita ambil dari email yang
                // sudah kita cek, dan kita ambil data passwordnya
                $password_db = $cekEmail['password'];
                // $hash = password_hash($password, PASSWORD_BCRYPT);
                // if (password_verify($password, $password_db)) {
                //     echo 'Password is valid!';
                // } else {
                //     echo 'Invalid password.';
                //     echo 'Hashed password: ' . $hash;
                //     echo 'Password from DB: ' . $password_db;
                // }
                // dd($password_db, $password);
                // kita cek menggunakan function password_verify yang parameter 1 itu adalah
                // password yang user inputkan dan parameter kedua itu password dari db
                $cekPassword = password_verify($password, $password_db);

                // dd($cekPassword);
                if ($cekPassword) {

                    //  variabel  $session_data, digunakan untuk menampung semua data yang ingin
                    // disimpan.
                    // pengecekan role, jika sesuai dengan ketentuan akan di arahakan/didrect kedalam 
                    // routing tertentu 
                    switch ($cekEmail['role']) {
                        case 'admin':
                            $session_data = [
                                'logged_in' => TRUE,
                                'id' => $cekEmail['id'],
                                'role_id' => $cekEmail['role'],
                                'name' => $cekEmail['name'],
                                'uuid' => $cekEmail['uuid'],
                            ];

                            $session->set($session_data);
                            return redirect()->to('admin/dashboard');
                        case 'auditor':
                            $session_data = [
                                'logged_in' => TRUE,
                                'id' => $cekEmail['id'],
                                'role_id' => $cekEmail['role'],
                                'name' => $cekEmail['name'],
                                'uuid' => $cekEmail['uuid'],
                            ];

                            $session->set($session_data);
                            return redirect()->to('auditor/dashboard');
                        case 'auditi':
                            $session_data = [
                                'logged_in' => TRUE,
                                'id' => $cekEmail['id'],
                                'role_id' => $cekEmail['role'],
                                'name' => $cekEmail['name'],
                                'uuid' => $cekEmail['uuid'],
                            ];
                            $session->set($session_data);
                            return redirect()->to('auditi/dashboard');
                        case 'pimpinan':
                            $session_data = [
                                'logged_in' => TRUE,
                                'id' => $cekEmail['id'],
                                'role_id' => $cekEmail['role'],
                                'name' => $cekEmail['name'],
                                'uuid' => $cekEmail['uuid'],
                            ];
                            $session->set($session_data);
                            return redirect()->to('pimpinan/dashboard');
                        default:
                            // menambahkan session dengan mengguakan function setFlashdata
                            // yang namanya itu adalah pesan dan isi pesanya itu adalah anda belum terdafatr
                            $session->setFlashdata('pesan', 'Anda belum memiliki role, silahkan hubungi admin');
                            // menambahkan session juga, dengan nama alert type dan isi nya itu danger
                            session()->setFlashdata('alert_type', 'danger');
                            return redirect()->to('/');
                    }
                } else {
                    $session->setFlashdata('pesan', 'Email atau password anda salah');
                    session()->setFlashdata('alert_type', 'danger');
                    return redirect()->to('/')->withInput();
                }
            } else {
                $session->setFlashdata('pesan', 'Email atau password anda salah');
                session()->setFlashdata('alert_type', 'danger');
                return redirect()->to('/')->withInput();
            }
        }
    }

    public function logout()
    {
        $session = session();
        // menghapus semua session yang telah di simpan 
        $session->destroy();
        return redirect()->to('/');
    }
}
