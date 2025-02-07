<?php

namespace App\Controllers\Cms;

use App\Controllers\BaseController;

class Site_menu extends BaseController
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
			"title"         =>  "Site Menu",
			"description"   =>  "Site Menu",
			"keyword"       =>  ""
		);
		$data['menu_group'] = '';
		$data['menu_id'] = '';
		$uri = current_url(true);
		$totalSegments = $uri->getTotalSegments();
		$data['menu_id'] = ($totalSegments >= 4) ? $uri->getSegment(4) : '';
		$data['menu_group'] = ($totalSegments >= 5) ? $uri->getSegment(5) : '';

		$data['title'] = "Site Menu";
		$data['PageName'] = 'Site Menu';
		$data['PageUrl'] = 'Site Menu';
		$data['buttons'] = ['add', 'search'];
		$data['content'] = "cms/sitemenu/menus.php";
		$data['session'] = session(); //for frontend accessing the session data
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
        		"assets/cms/css/main_style.css",//css sa style ni master Vien
        		"assets/css/style.css"
                    );
		return view("cms/layout/template", $data);
	}

	public function menu_add()
	{
		$data['meta'] = array(
			"title"         =>  "Site Menu",
			"description"   =>  "Site Menu",
			"keyword"       =>  ""
		);
		$data['title'] = "Site Menu";
		$data['PageName'] = 'Site Menu';
		$data['PageUrl'] = 'Site Menu';
		$data['buttons'] = ['add', 'search'];
		$data['content'] = "cms/sitemenu/menus.php";
		
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
        		"assets/cms/css/main_style.css",//css sa style ni master Vien
        		"assets/css/style.css"
                    );
		return view("cms/layout/template", $data);
	}

	public function menu_update()
	{
		$data['meta'] = array(
			"title"         =>  "Site Menu",
			"description"   =>  "Site Menu",
			"keyword"       =>  ""
		);
		$data['title'] = "Site Menu";
		$data['PageName'] = 'Site Menu';
		$data['PageUrl'] = 'Site Menu';
		$data['buttons'] = ['add', 'search'];
		$data['content'] = "cms/sitemenu/menus.php";
		
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
