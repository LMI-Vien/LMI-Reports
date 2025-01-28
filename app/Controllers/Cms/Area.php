<?php

namespace App\Controllers\Cms;

use App\Controllers\BaseController;

class Area extends BaseController
{
    protected $session;

    public function __construct()
	{
	    $this->session = session();
	    if (!$this->session->get('sess_uid')) {
	        redirect()->to(base_url('cms/login'))->send();
	        exit;
	    }
	}

	public function index()
	{

		$data['meta'] = array(
			"title"         =>  "Area Masterfile",
			"description"   =>  "Area Masterfile",
			"keyword"       =>  ""
		);
		$data['title'] = "Area";
		$data['PageName'] = 'Area';
		$data['PageUrl'] = 'Area';
		$data['content'] = "cms/area/area.php";
		$data['buttons'] = ['add', 'search', 'import'];
		$data['session'] = session(); //for frontend accessing the session data
		$data['js'] = array(
				"assets/js/bootstrap.min.js",
				"assets/js/adminlte.min.js",
				"assets/js/moment.js"
                    );
        $data['css'] = array(
        		"assets/css/bootstrap.min.css",
        		"assets/css/adminlte.min.css",
        		"assets/css/all.min.css",
        		"assets/css/style.css"
                    );
		return view("cms/layout/template", $data);		
	}

}
