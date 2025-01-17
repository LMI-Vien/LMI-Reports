<?php

namespace App\Controllers\Cms;

use App\Controllers\BaseController;

class User extends BaseController
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
			"title"         =>  "LMI CMS Portal test",
			"description"   =>  "LMI CMS Portal Wep application",
			"keyword"       =>  ""
		);
		$data['title'] = "Users";
		$data['PageName'] = 'Users';
		$data['PageUrl'] = 'Users';
		$data['buttons'] = ['add', 'search'];
		$data['content'] = "cms/User/User.php";

		$data['js'] = array(
				"assets/js/bootstrap.min.js",
				"assets/js/adminlte.min.js",
				"assets/js/moment.js",
				"assets/cms/js/login/login_js.js"
                    );
        $data['css'] = array(
        		"assets/css/bootstrap.min.css",
        		"assets/css/adminlte.min.css",
        		"assets/css/all.min.css",
        		"assets/site/css/login/login_style.css",
        		"assets/css/style.css"
                    );
		return view("cms/layout/template", $data);	
	}

}
