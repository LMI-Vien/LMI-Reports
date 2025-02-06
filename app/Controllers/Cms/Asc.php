<?php

namespace App\Controllers\Cms;

use App\Controllers\BaseController;

class Asc extends BaseController
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
			"title"         =>  "Area Sales Coordinator Masterfile",
			"description"   =>  "Area Sales Coordinator Masterfile",
			"keyword"       =>  ""
		);
		$data['title'] = "Area Sales Coordinator";
		$data['PageName'] = 'Area Sales Coordinator';
		$data['PageUrl'] = 'Area Sales Coordinator';
		$data['content'] = "cms/asc/asc.php";
		$data['buttons'] = ['add', 'search', 'import'];
		$data['session'] = session(); //for frontend accessing the session data
		$data['js'] = array(
				"assets/js/xlsx.full.min.js",
				"assets/js/bootstrap.min.js",
				"assets/js/adminlte.min.js",
				"assets/cms/js/jquery-ui.js",
                    );
        $data['css'] = array(
        		"assets/css/bootstrap.min.css",
        		"assets/css/adminlte.min.css",
        		"assets/css/all.min.css",
        		"assets/cms/css/main_style.css",//css sa style ni master Vien
        		"assets/cms/css/jquery-ui.css",
        		"assets/css/style.css"
                    );
		return view("cms/layout/template", $data);		
	}

}
