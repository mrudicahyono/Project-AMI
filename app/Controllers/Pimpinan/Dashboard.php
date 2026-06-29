<?php

namespace App\Controllers\Pimpinan;

use App\Models\PeriodeModel;
use App\Models\JadwalPeriodeEDModel;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Dashboard extends BaseController
{
    protected $jadwal_periode_ED_Model;
    protected $periode_Model;
    public function __construct()
    {
        $this->jadwal_periode_ED_Model = new JadwalPeriodeEDModel();
        $this->periode_Model = new PeriodeModel();
    }
    public function index()
    {

        $jadwalPeriodeED = $this->jadwal_periode_ED_Model->getJadwalPeriodeED();
        $periode = $this->periode_Model->getPeriode();
        $data = [
            'title' => 'Dashboard',
            'currentPage' => 'dashboard',
            'jadwalPeriodeED' => $jadwalPeriodeED,
            'jadwalAMI' => $periode
        ];
        return view('pimpinan/dashboard', $data);
    }
}
