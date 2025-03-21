<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class Middleware_dynamic implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
		if(session()->get('sess_email') == ''){
			return redirect()->to(base_url('cms'));
		}
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}
