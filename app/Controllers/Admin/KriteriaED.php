<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\KriteriaModel;
use App\Models\KriteriaProdiModel;
use App\Models\KriteriaStandarModel;
use App\Models\LembagaAkreditasiModel;
use App\Models\PerubahanKriteriaModel;
use App\Models\ProdiModel;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;

class KriteriaED extends BaseController
{

    private $users;
    private $kriteria;
    private $kriteriaProdi;
    private $lembaga_akreditasi;
    private $perubahanKriteria;
    private $kriteriaStandar;
    private $prodi;

    public function __construct()
    {

        $this->users = new UserModel();
        $this->kriteria = new KriteriaModel();
        $this->kriteriaProdi = new KriteriaProdiModel();
        $this->lembaga_akreditasi = new LembagaAkreditasiModel();
        $this->perubahanKriteria = new PerubahanKriteriaModel();
        $this->kriteriaStandar = new KriteriaStandarModel();
        $this->prodi = new ProdiModel();
    }

    // kriteria
    // method crud (create (get & post), read, update(get & post), delete)

    // read criteria
    public function index()
    {

        $kriteria = $this->kriteria->select('kriteria.uuid as uuid ,kriteria.kode_kriteria ,lembaga_akreditasi.nama as lembaga_akreditasi, kriteria, bobot, prodi.nama as nama_prodi, standar')->join('lembaga_akreditasi', 'lembaga_akreditasi.id = kriteria.id_lembaga_akreditasi')->join('prodi', 'prodi.id = kriteria.id_prodi')->join('kriteria_standar', 'kriteria.id_kriteria_standar = kriteria_standar.id')->findAll();
        // dd($kriteria);

        $data = [
            'title' => 'Kelola kriteria ED',
            'currentPage' => 'kriteria-ed',
            'kriteria' => $kriteria
        ];

        return view('admin/kriteriaED/kriteria', $data);
    }


    // create kriteria
    public function create()
    {

        $prodi = $this->prodi->findAll();
        $lembaga_akreditasi = $this->lembaga_akreditasi->findAll();
        $kriteriaStandar = $this->kriteriaStandar->findAll();

        $data = [
            'title' => 'Tambah Kriteria ED',
            'currentPage' => 'kriteria-ed',
            'lembaga_akreditasi' => $lembaga_akreditasi,
            'prodi' => $prodi,
            'kriteria_standar' => $kriteriaStandar,
        ];

        return view('admin/kriteriaED/create', $data);
    }

    public function createUniv()
    {

        $prodi = $this->prodi->findAll();
        $lembaga_akreditasi = $this->lembaga_akreditasi->findAll();
        $kriteriaStandar = $this->kriteriaStandar->findAll();

        $data = [
            'title' => 'Tambah Kriteria ED',
            'currentPage' => 'kriteria-ed',
            'lembaga_akreditasi' => $lembaga_akreditasi,
            'prodi' => $prodi,
            'kriteria_standar' => $kriteriaStandar,
        ];

        return view('admin/kriteriaED/universitas/createUniv', $data);
    }

    // create kriteria post
    public function save()
    {


        if (!$this->validate([
            'standar' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Harus diisi'
                ]
            ],
            'lembaga_akreditasi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Harus diisi'
                ]
            ],
            'id_prodi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Harus diisi'
                ]
            ],
            'kriteria' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Harus diisi'
                ],
            ],
            'kode_kriteria' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Harus diisi'
                ],
            ],

        ])) {
            $validation = \Config\Services::validation();
            return redirect()->back()->withInput()->with('validation', $validation);
        }

        $data = [
            "uuid" => service('uuid')->uuid4()->toString(),
            'id_prodi' => $this->request->getPost('id_prodi'),
            'id_lembaga_akreditasi' => $this->request->getPost('lembaga_akreditasi'),
            "kriteria" => $this->request->getPost('kriteria'),
            "kode_kriteria" => $this->request->getPost('kode_kriteria'),
            'id_kriteria_standar' => $this->request->getPost('standar'),
        ];


        $this->kriteria->insert($data);

        $dat = $this->kriteria->where("uuid", $data['uuid'])->first();

        // input ke kriteria prodi
        $data_kriteriaProdi = [
            'uuid' => service('uuid')->uuid4()->toString(),
            'id_kriteria' => $dat['id'],
            'id_prodi' => $data['id_prodi'],
        ];

        $this->kriteriaProdi->insert($data_kriteriaProdi);

        $kriteriaProdi = $this->kriteriaProdi->where('uuid', $data_kriteriaProdi['uuid'])->first();

        // input ke perubahan kriteria
        $data_perubahanKriteria = [
            'id_kriteria_prodi' => $kriteriaProdi['id'],
            'uuid' => service('uuid')->uuid4()->toString(),
        ];

        $this->perubahanKriteria->insert($data_perubahanKriteria);

        return redirect()->to('/admin/kriteria-ed')->with('sukses', 'Berhasil menambah ED');
    }

    public function saveUniv()
    {


        if (!$this->validate([
            'standar' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Harus diisi'
                ]
            ],
            'lembaga_akreditasi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Harus diisi'
                ]
            ],
            'kriteria' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Harus diisi'
                ],
            ],
            'kode_kriteria' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Harus diisi'
                ],
            ],

        ])) {
            $validation = \Config\Services::validation();
            return redirect()->back()->withInput()->with('validation', $validation);
        }

        $prodi = $this->prodi->findAll();
        foreach ($prodi as $key => $value) {

            $data = [

                "uuid" => service('uuid')->uuid4()->toString(),
                'id_prodi' => $value['id'],
                'id_lembaga_akreditasi' => $this->request->getPost('lembaga_akreditasi'),
                "kriteria" => $this->request->getPost('kriteria'),
                "kode_kriteria" => $this->request->getPost('kode_kriteria'),
                'id_kriteria_standar' => $this->request->getPost('standar'),

            ];

            $this->kriteria->insert($data);

            $dat = $this->kriteria->where("uuid", $data['uuid'])->first();

            // input ke kriteria prodi
            $data_kriteriaProdi = [
                'uuid' => service('uuid')->uuid4()->toString(),
                'id_kriteria' => $dat['id'],
                'id_prodi' => $data['id_prodi'],
            ];

            $this->kriteriaProdi->insert($data_kriteriaProdi);


            $kriteriaProdi = $this->kriteriaProdi->where('uuid', $data_kriteriaProdi['uuid'])->first();

            // input ke perubahan kriteria
            $data_perubahanKriteria = [
                'id_kriteria_prodi' => $kriteriaProdi['id'],
                'uuid' => service('uuid')->uuid4()->toString(),
            ];

            $this->perubahanKriteria->insert($data_perubahanKriteria);
        }




        return redirect()->to('/admin/kriteria-ed')->with('sukses', 'Berhasil menambah ED');
    }

    // update kriteria
    public function update($uuid)
    {

        $kriteria = $this->kriteria->select('kriteria.uuid as uuid , kriteria.kode_kriteria ,lembaga_akreditasi.nama as lembaga_akreditasi, lembaga_akreditasi.id as id_lembaga_akreditasi ,prodi.nama as nama_prodi, prodi.id as id_prodi, bobot, kriteria, standar, kriteria_standar.id as id_standar')->join('lembaga_akreditasi', 'lembaga_akreditasi.id = kriteria.id_lembaga_akreditasi')->join('prodi', 'prodi.id = kriteria.id_prodi')->join('kriteria_prodi', 'kriteria_prodi.id_kriteria = kriteria.id')->join('kriteria_standar', 'kriteria_standar.id = kriteria.id_kriteria_standar')->where('kriteria.uuid', $uuid)->first();
        $prodi = $this->prodi->findAll();
        $lembaga_akreditasi = $this->lembaga_akreditasi->findAll();
        $kriteriaStandar = $this->kriteriaStandar->findAll();


        $data = [
            'title' => 'Tambah Indikator ED',
            'currentPage' => 'kriteria-ed',
            'kriteria' => $kriteria,
            'prodi' => $prodi,
            'kriteria_standar' => $kriteriaStandar,
            'lembaga_akreditasi' => $lembaga_akreditasi,
            'uuid' => $uuid,
        ];

        return view('admin/kriteriaED/update', $data);
    }

    // update kriteria post
    public function updatePost($uuid)
    {

        if (!$this->validate([
            'standar' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Harus diisi'
                ]
            ],
            'lembaga_akreditasi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Harus diisi'
                ]
            ],
            'id_prodi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Harus diisi'
                ]
            ],
            'kriteria' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Harus diisi'
                ],
            ],
            'kode_kriteria' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Harus diisi'
                ],
            ],

        ])) {
            $validation = \Config\Services::validation();
            return redirect()->back()->withInput()->with('validation', $validation);
        }


        $data = [
            'id_prodi' => $this->request->getPost('id_prodi'),
            'id_lembaga_akreditasi' => $this->request->getPost('lembaga_akreditasi'),
            "kriteria" => $this->request->getPost('kriteria'),
            "kode_kriteria" => $this->request->getPost('kode_kriteria'),
            'id_kriteria_standar' => $this->request->getPost('standar'),
        ];



        $this->kriteria->set($data)->where('uuid', $uuid)->update();

        $ambilKriteria = $this->kriteria->where('uuid', $uuid)->first();

        // update juga data prodi di kriteria prodi semisalnya data di kriteria keubah prodinya
        $dataKriteriaProdi = [
            'id_prodi' => $data['id_prodi'],
        ];

        $this->kriteriaProdi->set($dataKriteriaProdi)->where('id_kriteria', $ambilKriteria['id'])->update();

        return redirect()->to('/admin/kriteria-ed')->with('sukses', 'Berhasil mengubah ED');
    }

    // Delete kriteria
    public function delete($uuid)
    {

        $ambilKriteria = $this->kriteria->where('uuid', $uuid)->first();

        // hapus di kriteria dan kriteria prodi
        $this->kriteriaProdi->where('id_kriteria', $ambilKriteria['id'])->delete();
        $isDelete = $this->kriteria->where('uuid', $uuid)->delete();

        if ($isDelete) {
            return redirect()->to('/admin/kriteria-ed')->with('sukses', 'Berhasil menghapus ED');
        } else {
            return redirect()->back()->with('gagal', 'Gagal menambah indikator ED');
        }
    }

    public function deleteMultiple(){

        if(is_null($this->request->getVar('selectedItems'))){
            return redirect()->back()->with('gagal', 'Gagal menghapus kriteria, tidak ada kriteria yang terpilih');
        }
        
        foreach ($this->request->getVar('selectedItems') as $key => $value) {
            $this->kriteria->where('uuid', $value)->delete();  
        }
        
        return redirect()->back()->with('sukses', 'Berhasil menghapus kriteria yang dipilih');

    }

}
