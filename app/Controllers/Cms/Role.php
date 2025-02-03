<?php

namespace App\Controllers\Cms;

use App\Controllers\BaseController;

class Role extends BaseController
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
			"title"         =>  "LMI CMS Portal",
			"description"   =>  "LMI CMS Portal Wep application",
			"keyword"       =>  ""
		);
		$data['title'] = "Roles";
		$data['PageName'] = 'Roles';
		$data['PageUrl'] = 'Roles';
		$data['content'] = "cms/roles/roles.php";
		$data['buttons'] = ['add', 'search', 'import'];
		$data['session'] = session(); //for frontend accessing the session data

		$data['js'] = array(
				"assets/js/bootstrap.min.js",
				"assets/js/adminlte.min.js",
                    );
        $data['css'] = array(
        		"assets/css/bootstrap.min.css",
        		"assets/css/adminlte.min.css",
        		"assets/css/all.min.css",
        		"assets/cms/css/main_style.css",//css sa style ni master Vien
        		"assets/css/style.css"
                    );
		return view("cms/layout/template", $data);		
	}

}
