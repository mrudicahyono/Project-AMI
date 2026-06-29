<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class PimpinanFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // sudah dijelaskan di AdminFilter
        if (!session()->get('logged_in')) {
            session()->setFlashdata('pesan', 'Anda belum Login !');
            session()->setFlashdata('alert_type', 'danger');
            return redirect()->to('/');
        }


        if (session()->get('role_id') != 'pimpinan') {
            $role = session()->get('role_id');
            return redirect()->to("$role/dashboard");
        }
    }
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}
