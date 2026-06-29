<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\AuditorModel;
use App\Models\ProdiModel;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;

class KelolaAuditor extends BaseController
{
    protected $auditor;
    protected $prodi;
    protected $users;
    public function __construct()
    {
        $this->auditor = new AuditorModel();
        $this->prodi = new ProdiModel();
        $this->users = new UserModel();
    }

    public function index()
    {

        $auditor = $this->auditor->select('auditor.uuid as uuid, prodi.nama as prodi, auditor.nama, auditor.kode_auditor, auditor.akhir_sertifikat')->join('prodi', 'prodi.id = auditor.id_prodi')->join('users', 'users.id = auditor.id_user')->findAll();
        $data = [
            'title' => 'Kelola Auditor',
            'currentPage' => 'kelolaAuditor',
            'auditor' => $auditor

        ];
        return view('admin/kelolaAuditor/index', $data);
    }

    public function create()
    {

        $users = $this->users->select('id, email, name')->where('role', 'auditor')->findAll();
        $prodi = $this->prodi->findAll();



        $data = [
            'title' => 'Tambah Auditor',
            'currentPage' => 'kelolaAuditor',
            'users' => $users,
            'prodi' => $prodi

        ];
        return view('admin/kelolaAuditor/create', $data);
    }

    public function save()
    {

        if (!$this->validate([
            'users' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Harus diisi'
                ]
            ],
            'prodi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Harus diisi'
                ]
            ],
            'nama' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Harus diisi'
                ]
            ],
            'kode_auditor' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Harus diisi'
                ]
            ],
            'akhir_sertifikat' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Harus diisi'
                ]
            ]
        ])) {
            $validation = \Config\Services::validation();
            return redirect()->back()->withInput()->with('validation', $validation);
        }


        $data = [
            "uuid" => service('uuid')->uuid4()->toString(),
            'id_user' => $this->request->getPost('users'),
            'id_prodi' => $this->request->getPost('prodi'),
            'nama' => $this->request->getPost('nama'),
            'kode_auditor' => $this->request->getPost('kode_auditor'),
            'akhir_sertifikat' => $this->request->getPost('akhir_sertifikat')
        ];

        $this->auditor->insert($data);

        return redirect()->to('admin/kelola-auditor')->with('sukses', 'Berhasil menambah Auditor');
    }

    public function update($uuid)
    {
        $auditor = $this->auditor->select('auditor.uuid as uuid, prodi.nama as prodi, prodi.id as id_prodi, auditor.nama, users.name ,users.id as id_user, auditor.kode_auditor, auditor.akhir_sertifikat')->join('prodi', 'prodi.id = auditor.id_prodi')->join('users', 'users.id = auditor.id_user')->where('auditor.uuid', $uuid)->first();
        $users = $this->users->select('id, email, name')->where('role', 'auditor')->findAll();
        $prodi = $this->prodi->findAll();

        $data = [
            'title' => "Ubah Kelola Auditor",
            'currentPage' => 'kelolaAuditor',
            'auditor' => $auditor,
            'users' => $users,
            'prodi' => $prodi,
            'uuid' => $uuid
        ];

        return view('admin/kelolaAuditor/update', $data);
    }

    public function updatePost($uuid)
    {
        if (!$this->validate([
            'users' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Harus diisi'
                ]
            ],
            'prodi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Harus diisi'
                ]
            ],
            'nama' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Harus diisi'
                ]
            ],
            'kode_auditor' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Harus diisi'
                ]
            ],
            'akhir_sertifikat' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Harus diisi'
                ]
            ]
        ])) {
            $validation = \Config\Services::validation();
            return redirect()->back()->withInput()->with('validation', $validation);
        }

        $data = [
            'id_user' => $this->request->getPost('users'),
            'id_prodi' => $this->request->getPost('prodi'),
            'nama' => $this->request->getPost('nama'),
            'kode_auditor' => $this->request->getPost('kode_auditor'),
            'akhir_sertifikat' => $this->request->getPost('akhir_sertifikat')
        ];

        $this->auditor->set($data)->where('uuid', $uuid)->update();
        return redirect()->to('/admin/kelola-auditor')->with('sukses', 'Berhasil mengubah Auditor');
    }

    public  function delete($uuid)
    {
        $this->auditor->where('uuid', $uuid)->delete();

        return redirect()->to('/admin/kelola-auditor')->with('sukses', 'Berhasil menghapus auditor');
    }
}
