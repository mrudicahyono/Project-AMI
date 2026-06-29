<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AdminFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        //Pengecekan, jika tidak ada session yang kita ambil yang bernama logged_in, maka 
        // tambakan session setFlastdata dan direct ke halaman / atau login
        if (!session()->get('logged_in')) {
            session()->setFlashdata('pesan', 'Anda belum Login !');
            session()->setFlashdata('alert_type', 'danger');
            return redirect()->to('/');
        }
        // Pengecekan jika ada session bernama logged_in, maka ada di cek lagi
        // jika session yang di ambil itu, namanya adalah role_id, yang role_id itu tidak
        // sama dengan admin maka tampilkan setFlasdata dan akan diarahakan ke halaman / atau login
        if (session()->get('role_id') != 'admin') {
            $role = session()->get('role_id');
            return redirect()->to("$role/dashboard");
        }
    }
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}
