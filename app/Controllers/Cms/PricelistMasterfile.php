<?php

namespace App\Controllers\Cms;

use App\Controllers\BaseController;

class PricelistMasterfile extends BaseController
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
			"title"         =>  "Pricelist Masterfile",
			"description"   =>  "Pricelist Masterfile",
			"keyword"       =>  ""
		);
		$data['title'] = "Pricelist Masterfile";
		$data['PageName'] = 'Pricelist Masterfile';
		$data['PageUrl'] = 'Pricelist Masterfile';
		$data['buttons'] = ['add', 'search', 'filter'];
		$data['content'] = "cms/pricelist_masterfile/pricelist_masterfile.php";
		$data['session'] = session(); //for frontend accessing the session data
		$data['js'] = array(
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
