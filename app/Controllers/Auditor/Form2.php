<?php

namespace App\Controllers\Auditor;

use App\Controllers\BaseController;

class Form2 extends BaseController
{




    public function index()
    {
        $data = [
            'title' => 'Form 2',
            'currentPage' => 'form-2'
        ];

        return view('auditor/form2/index', $data);
    }
}
