<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class ErrorHandler extends Controller
{
    public function show404()
    {
        return view('site/layout/error_404');
    }
}
