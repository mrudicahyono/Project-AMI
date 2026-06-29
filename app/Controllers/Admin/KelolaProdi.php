<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ProdiModel;
use CodeIgniter\HTTP\ResponseInterface;

class KelolaProdi extends BaseController
{

    private $prodi;
    public function __construct(){
        $this->prodi = new ProdiModel();
    }

    public function index()
    {
        
        $prodi = $this->prodi->findAll();
        // dd($prodi);

        $data = [
            'title' => 'Kelola Data Prodi',
            'currentPage' => 'kelola-prodi',
            'prodi' => $prodi
        ];

        return view('admin/kelolaProdi/index', $data);

    }

    public function tambah(){

        $data = [
            'title' => 'Tambah Data Prodi',
            'currentPage' => 'kelola-prodi',
        ];

        return view('admin/kelolaProdi/create', $data);

    }

    public function tambahPost(){

        // dd($this->request->getVar());

        $dataProdi = [
            'uuid' => service('uuid')->uuid4()->toString(),
            'nama' => $this->request->getVar('jurusan'),
            'fakultas' => $this->request->getVar('fakultas'),
        ];

        $success = $this->prodi->insert($dataProdi);

        if(!$success){
            return redirect()->back()->withInput()->with('gagal', "Gagal menambah prodi");
        }else{
            return redirect()->to('/admin/kelola-prodi')->with('sukses', 'Berhasil menambah Prodi');
        }

    }


    public function edit($uuid){

        $prodi = $this->prodi->where('uuid', $uuid)->first();
        // dd($prodi);
        $data = [
            'title' => 'Edit Data Prodi',
            'currentPage' => 'kelola-prodi',
            'prodi' => $prodi,
            'uuid' => $uuid
        ];

        return view('admin/kelolaProdi/edit', $data);        

    }

    public function editPost($uuid){

        $data = [
            'nama' => $this->request->getVar('jurusan'),
            'fakultas' => $this->request->getVar('fakultas'),
        ];

        $this->prodi->set($data)->where('uuid', $uuid)->update();

        return redirect()->to('/admin/kelola-prodi')->with('sukses', 'Berhasil mengubah prodi');
    }



    public function hapus($uuid){

        $this->prodi->where('uuid', $uuid)->delete();

        return redirect()->to('/admin/kelola-prodi')->with('sukses', 'Berhasil menghapus prodi');

    }

}
