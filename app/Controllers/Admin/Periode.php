<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PeriodeModel;
use CodeIgniter\HTTP\ResponseInterface;

class Periode extends BaseController
{

    protected $periode_Model;
    public function __construct()
    {
        $this->periode_Model = new PeriodeModel();
    }
    public function index()
    {


        $periode = $this->periode_Model->getPeriode();
        $data = [
            'title' => 'Jadwal AMI',
            'currentPage' => 'jadwalAMI',
            'jadwalAMI' => $periode,
            'showAddButton' => count($periode) == 0
        ];

        return view('admin/jadwalAMI/index', $data);
    }
    public function create()
    {

        $data = [
            'title' => 'Form Tambah Jadwal AMI',
            'currentPage' => 'jadwalAMI',
            'validation' => session()->getFlashdata('validation') ?? \Config\Services::validation(),

        ];
        return view("admin/jadwalAMI/create", $data);
    }

    public function save()
    {
        if (!$this->validate([
            'nama_periode' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama harus diisi !'
                ]
            ],
            'tahun' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tahun Mulai harus diisi !'
                ]
            ],
            'ruang_lingkup' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'ruang lingkup Mulai harus diisi !'
                ]
            ],
            'penjaminan_mutu_audit' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'penjaminan mutu audit harus diisi !'
                ]
            ],
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
            return redirect()->to('/admin/jadwal-ami/create')->withInput();
        }

        // membuat uuid
        $uuid = service('uuid');
        $uuid4 = $uuid->uuid4();
        $uuid4String = $uuid4->toString();
        // dd($this->request->getVar());
        $this->periode_Model->save([
            'uuid' => $uuid4String,
            'nama_periode' => $this->request->getVar('nama_periode'),
            'tahun' => $this->request->getVar('tahun'),
            'ruang_lingkup' => $this->request->getVar('ruang_lingkup'),
            'tanggal_mulai' => $this->request->getVar('tanggal_mulai'),
            'penjaminan_mutu_audit' => $this->request->getVar('penjaminan_mutu_audit'),
            'tanggal_selesai' => $this->request->getVar('tanggal_selesai'),

        ]);


        session()->setFlashdata('pesan', 'Jadwal Berhasil ditambahkan');
        return redirect()->to('/admin/jadwal-ami');
    }

    public function delete($id)
    {
        $this->periode_Model->delete($id);
        session()->setFlashdata('pesan', "Jadwal Berhasil dihapus");
        return redirect()->to('/admin/jadwal-ami');
    }

    public function edit($uuid)
    {
        $periode = $this->periode_Model->getPeriode($uuid);
        $data = [
            'title' => 'Form Edit Jadwal',
            'validation' => session()->getFlashdata('validation') ?? \Config\Services::validation(),
            'currentPage' => 'jadwalAMI',
            'jadwalAMI' => $periode
        ];

        return view('admin/jadwalAMI/edit', $data);
    }

    public function update($id)
    {
        if (!$this->validate([
            'nama_periode' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tanggal Mulai harus diisi !'
                ]
            ],
            'tahun' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tanggal Mulai harus diisi !'
                ]
            ],
            'ruang_lingkup' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tanggal Mulai harus diisi !'
                ]
            ],
            'penjaminan_mutu_audit' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'penjaminan mutu audit harus diisi !'
                ]
            ],
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
            return redirect()->to('/admin/jadwal-ami/edit/' . $this->request->getVar('uuid'))->withInput();
        }

        $this->periode_Model->save([
            'id' => $id,
            'nama_periode' => $this->request->getVar('nama_periode'),
            'tahun' => $this->request->getVar('tahun'),
            'ruang_lingkup' => $this->request->getVar('ruang_lingkup'),
            'tanggal_mulai' => $this->request->getVar('tanggal_mulai'),
            'penjaminan_mutu_audit' => $this->request->getVar('penjaminan_mutu_audit'),
            'tanggal_selesai' => $this->request->getVar('tanggal_selesai'),
        ]);


        session()->setFlashdata('pesan', 'Jadwal Berhasil diubah');
        return redirect()->to('/admin/jadwal-ami');
    }
}
