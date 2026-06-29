<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ProdiModel;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;

class KelolaAuditi extends BaseController
{
    protected $prodi;
    protected $users;

    public function __construct()
    {
        $this->prodi = new ProdiModel();
        $this->users = new UserModel();
    }

    public function index()
    {

        $users = $this->users
            ->select('users.uuid as uuid, users.id as id, prodi.nama as prodi, users.email as email, users.name as nama')
            ->join('prodi', 'prodi.id = users.id_prodi', 'left') // Gunakan left join untuk menangani kasus ketika id_prodi adalah NULL
            ->where('users.role', 'auditi')
            ->findAll();

        // dd($users);

        $data = [
            'title' => 'Kelola Auditi',
            'currentPage' => 'kelolaAuditi',
            'users' => $users

        ];
        return view('admin/kelolaAuditi/index', $data);
    }

    public function kelola($uuid)
    {

        $prodi = $this->prodi->findAll();
        $users = $this->users
            ->select('users.id_prodi as id, prodi.nama as nama')
            ->join('prodi', 'prodi.id = users.id_prodi', 'left')
            ->where('users.uuid', $uuid)
            ->first();
        // dd($prodi);
        $data = [
            'title' => "Ubah Kelola Auditi",
            'currentPage' => 'kelolaAuditi',
            'users' => $users,
            'prodi' => $prodi,
            'uuid' => $uuid
        ];

        return view('admin/kelolaAuditi/kelola', $data);
    }

    public function kelolaPost($uuid)
    {
        $data = [
            'id_prodi' => $this->request->getPost('prodi'),
        ];

        $this->users->set($data)->where('uuid', $uuid)->update();
        return redirect()->to('/admin/kelola-auditi')->with('sukses', 'Berhasil mengubah Auditi');
    }

    public  function delete($uuid)
    {
        $this->users->where('uuid', $uuid)->delete();

        return redirect()->to('/admin/kelola-auditi')->with('sukses', 'Berhasil menghapus Auditi');
    }
}
