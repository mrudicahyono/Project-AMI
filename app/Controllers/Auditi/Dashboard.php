<?php

namespace App\Controllers\Auditi;

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

        // error buat nangani jadwal periode ed belum dibuat
        
        if(count($jadwalPeriodeED) == 0){
            $data = [
                'title' => 'Dashoard',
                'currentPage' => 'dashboard',
                'jadwalPeriodeED' => null,
                'jadwalAMI' => null,
                'waktu' => null,
                'belumDibuat' => "Jadwal Pengisian Form Evaluasi Diri Belum dibuat"
            ];

            return view('auditi/dashboard', $data);
        }

        // buat warning jika dekat masa waktu
        $sekarang = time();
        $tanggal_selesai = strtotime($jadwalPeriodeED[0]['tanggal_selesai']);

        $selisih_detik = $tanggal_selesai - $sekarang;
        $selisih_hari = floor($selisih_detik / (60 * 60 * 24)) + 1;

        $data = [
            'title' => 'Dashboard',
            'currentPage' => 'dashboard',
            'jadwalPeriodeED' => $jadwalPeriodeED,
            'jadwalAMI' => $periode,
            'waktu' => $selisih_hari,

        ];
        return view('auditi/dashboard', $data);
    }
}
