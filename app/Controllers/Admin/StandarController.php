<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\KriteriaStandarModel;
use CodeIgniter\HTTP\ResponseInterface;

class StandarController extends BaseController
{

    private $kriteriaStandar;
    public function __construct()
    {
        $this->kriteriaStandar = new KriteriaStandarModel();
    }

    public function index()
    {

        $standar = $this->kriteriaStandar->findAll();

        $data = [
            'title' => 'Kelola Standar',
            'currentPage' => "kelola-standar-ed",
            'standar' => $standar,
        ];

        return view('admin/kriteriaED/standar/index', $data);
    }

    public function create()
    {

        $data = [
            'title' => 'Tambah Standar',
            'currentPage' => 'kelola-standar-ed',
        ];

        return view('admin/kriteriaED/standar/create', $data);
    }

    public function createPost()
    {

        // dd($this->request->getVar());

        if (!$this->validate([
            'standar' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Harus diisi'
                ]
            ],
            'isactive' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Aktif Harus diisi'
                ]
            ],

        ])) {
            $validation = \Config\Services::validation();
            return redirect()->back()->withInput()->with('validation', $validation);
        }


        $data = [
            "uuid" => service('uuid')->uuid4()->toString(),
            'standar' => $this->request->getPost('standar'),
            'is_aktif' => $this->request->getPost('isactive'),
        ];
        // dd($data);

        $this->kriteriaStandar->insert($data);

        return redirect()->to('/admin/kriteria-ed/tambah/standar/')->with('sukses', 'Data standar berhasil ditambah');
    }


    public function edit($uuid){
        
        $standar = $this->kriteriaStandar->where('uuid', $uuid)->first();
        // dd($standar);


        $data = [
            "title" => "Edit Standar",
            "currentPage" => 'kelola-standar-ed',
            'standar' => $standar,
            'uuid' => $uuid
        ];

        return view('admin/kriteriaED/standar/edit', $data);

    }


    public function editPost($uuid){
        // dd($this->request->getVar());
    
        if (!$this->validate([
            'standar' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Harus diisi'
                ]
            ],
            'isactive' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Aktif Harus diisi'
                ]
            ],

        ])) {
            $validation = \Config\Services::validation();
            return redirect()->back()->withInput()->with('validation', $validation);
        }


        $data = [
            'standar' => $this->request->getPost('standar'),
            'is_aktif' => $this->request->getPost('isactive'),
        ];

        $this->kriteriaStandar->set($data)->where('uuid', $uuid)->update();
        return redirect()->to('/admin/kriteria-ed/tambah/standar')->withInput()->with('sukses', "Berhasil mengubah data standar");
    }

    public function hapusPost($uuid){

        $this->kriteriaStandar->where('uuid', $uuid)->delete();

        return redirect()->to('/admin/kriteria-ed/tambah/standar')->withInput()->with('sukses', 'Berhasil menghapus data standar');

    }

}
