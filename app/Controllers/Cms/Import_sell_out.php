<?php

namespace App\Controllers\Cms;

use App\Controllers\BaseController;

class Import_sell_out extends BaseController
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
			"title"         =>  "Import Sell Out",
			"description"   =>  "Import Sell Out",
			"keyword"       =>  ""
		);
		$data['title'] = "Import Sell Out";
		$data['PageName'] = 'Import Sell Out';
		$data['PageUrl'] = 'Import Sell Out';
		$data['content'] = "cms/import/sell-out/sell_out.php";
		$data['buttons'] = ['export', 'search'];
		$data['session'] = session(); //for frontend accessing the session data
		$data['standard'] = config('Standard');
		$data['js'] = array(
				"assets/js/xlsx.full.min.js",
				"assets/js/bootstrap.min.js",
				"assets/js/adminlte.min.js",
				"assets/js/moment.js",
				"assets/js/xlsx.full.min.js"
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

	public function view()
	{

		$uri = current_url(true);
		$data['uri'] =$uri;

		$data['meta'] = array(
			"title"         =>  "Import Sell Out",
			"description"   =>  "Import Sell Out",
			"keyword"       =>  ""
		);
		$data['title'] = "Import Sell Out";
		$data['PageName'] = 'Import Sell Out';
		$data['PageUrl'] = 'Import Sell Out';
		$data['content'] = "cms/import/sell-out/view_sell_out.php";
		$data['buttons'] = ['search'];
		$data['session'] = session(); //for frontend accessing the session data
		$data['standard'] = config('Standard');
		$data['js'] = array(
				"assets/js/xlsx.full.min.js",
				"assets/js/bootstrap.min.js",
				"assets/js/adminlte.min.js",
				"assets/js/moment.js",
				"assets/js/xlsx.full.min.js"
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
