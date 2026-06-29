<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\LembagaAkreditasiModel;
use CodeIgniter\HTTP\ResponseInterface;

class KelolaLembagaAkreditasi extends BaseController
{
    private $lembagaAkreditasi;
    public function __construct(){
        $this->lembagaAkreditasi = new LembagaAkreditasiModel();
    }

    public function index()
    {
        
        $lembagaAkreditasi = $this->lembagaAkreditasi->findAll();
        // dd($lembagaAkreditasi);

        $data = [
            'title' => 'Kelola Data Lembaga Akreditasi',
            'currentPage' => 'kelola-lembaga-akreditasi',
            'lembagaAkreditasi' => $lembagaAkreditasi
        ];

        return view('admin/kelolaAkreditasi/index', $data);

    }

    public function tambah(){

        $data = [
            'title' => 'Tambah Data Lembaga Akreditasi',
            'currentPage' => 'kelola-lembaga-akreditasi',
        ];

        return view('admin/kelolaAkreditasi/create', $data);

    }

    public function tambahPost(){


        $dataLembagaAkreditasi = [
            'uuid' => service('uuid')->uuid4()->toString(),
            'nama' => $this->request->getVar('lembagaAkreditasi'),
        ];

        $success = $this->lembagaAkreditasi->insert($dataLembagaAkreditasi);

        if(!$success){
            return redirect()->back()->withInput()->with('gagal', "Gagal menambah prodi");
        }else{
            return redirect()->to('/admin/kelola-lembaga-akreditasi')->with('sukses', 'Berhasil menambah Lembaga Akreditasi');
        }

    }


    public function edit($uuid){

        $lembagaAkreditasi = $this->lembagaAkreditasi->where('uuid', $uuid)->first();
        // dd($prodi);
        $data = [
            'title' => 'Edit Data Lembaga Akreditasi',
            'currentPage' => 'kelola-lembaga-akreditasi',
            'lembagaAkreditasi' =>$lembagaAkreditasi,
            'uuid' => $uuid
        ];

        return view('admin/kelolaAkreditasi/edit', $data);        

    }

    public function editPost($uuid){

        $data = [
            'nama' => $this->request->getVar('jurusan'),
            'fakultas' => $this->request->getVar('fakultas'),
        ];

        $this->lembagaAkreditasi->set($data)->where('uuid', $uuid)->update();

        return redirect()->to('/admin/kelola-lembaga-akreditasi')->with('sukses', 'Berhasil mengubah data lembaga akreditasi');
    }



    public function hapus($uuid){

        $this->lembagaAkreditasi->where('uuid', $uuid)->delete();

        return redirect()->to('/admin/kelola-lembaga-akreditasi')->with('sukses', 'Berhasil menghapus data lembaga akreditasi');

    }
}
