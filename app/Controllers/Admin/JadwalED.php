<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\JadwalPeriodeED;
use App\Models\JadwalPeriodeEDModel;
use CodeIgniter\HTTP\ResponseInterface;

class JadwalED extends BaseController
{
    protected $jadwal_periode_ED_Model;
    public function __construct()
    {
        $this->jadwal_periode_ED_Model = new JadwalPeriodeEDModel();
    }

    public function index()
    {

        $jadwalPeriodeED = $this->jadwal_periode_ED_Model->getJadwalPeriodeED();
        $data = [
            'title' => 'Jadwal Periode',
            'currentPage' => 'jadwalPeriode',
            'jadwalPeriodeED' => $jadwalPeriodeED, // getJadwalPeriodeED udah di buat function nya didalam model
            'showAddButton' => count($jadwalPeriodeED) == 0
        ];

        return view('admin/jadwalED/index', $data);
    }

    // public function detail($uuid)
    // {
    //     $data = [
    //         'title' => 'Detail Jadwal Periode ED',
    //         'jadwalED' => $this->jadwal_periode_ED_Model->getJadwalPeriodeED($uuid)
    //     ];

    // }



    public function create()
    {

        $data = [
            'title' => 'Form Tambah Jadwal Periode ED',
            'currentPage' => 'jadwalPeriode',
            'validation' => session()->getFlashdata('validation') ?? \Config\Services::validation(),

        ];
        return view("admin/jadwalED/create", $data);
    }

    public function save()
    {
        if (!$this->validate([
            'tanggal_mulai' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tanggal Mulai harus diisi !'
                ]
            ],
            'tanggal_selesai' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tanggal Selesai harus diisi !'
                ]
            ]
        ])) {

            session()->setFlashdata('validation', \Config\Services::validation());
            return redirect()->to('/admin/jadwal-periode/create')->withInput();
        }

        // membuat uuid
        $uuid = service('uuid');
        $uuid4 = $uuid->uuid4();
        $uuid4String = $uuid4->toString();
        // dd($this->request->getVar());
        $this->jadwal_periode_ED_Model->save([
            'uuid' => $uuid4String,
            'tanggal_mulai' => $this->request->getVar('tanggal_mulai'),
            'tanggal_selesai' => $this->request->getVar('tanggal_selesai'),
            'deskripsi' => $this->request->getVar('deskripsi')
        ]);


        session()->setFlashdata('pesan', 'Jadwal Berhasil ditambahkan');
        return redirect()->to('/admin/jadwal-periode');
    }

    public function delete($id)
    {
        $this->jadwal_periode_ED_Model->delete($id);
        session()->setFlashdata('pesan', "Jadwal Berhasil dihapus");
        return redirect()->to('/admin/jadwal-periode');
    }

    public function edit($uuid)
    {
        $jadwalPeriodeED = $this->jadwal_periode_ED_Model->getJadwalPeriodeED($uuid);
        $data = [
            'title' => 'Form Edit Jadwal',
            'validation' => session()->getFlashdata('validation') ?? \Config\Services::validation(),
            'currentPage' => 'jadwalPeriode',
            'jadwalPeriodeED' => $jadwalPeriodeED
        ];

        return view('admin/jadwalED/edit', $data);
    }

    public function update($id)
    {
        if (!$this->validate([
            'tanggal_mulai' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tanggal Mulai harus diisi !'
                ]
            ],
            'tanggal_selesai' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tanggal Selesai harus diisi !'
                ]
            ]
        ])) {

            session()->setFlashdata('validation', \Config\Services::validation());
            return redirect()->to('/admin/jadwal-periode/edit/' . $this->request->getVar('uuid'))->withInput();
        }

        $this->jadwal_periode_ED_Model->save([
            'id' => $id,
            'tanggal_mulai' => $this->request->getVar('tanggal_mulai'),
            'tanggal_selesai' => $this->request->getVar('tanggal_selesai'),
            'deskripsi' => $this->request->getVar('deskripsi')
        ]);


        session()->setFlashdata('pesan', 'Jadwal Berhasil diubah');
        return redirect()->to('/admin/jadwal-periode');
    }
}
