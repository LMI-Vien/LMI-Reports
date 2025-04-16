<?php

namespace App\Controllers\Cms;

use App\Controllers\BaseController;

class Item_class extends BaseController
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
			"title"         =>  "Item Class Masterfile",
			"description"   =>  "Item Class",
			"keyword"       =>  ""
		);
		$data['title'] = "Item Class";
		$data['PageName'] = 'Item Class';
		$data['PageUrl'] = 'Item Class';
		$data['buttons'] = ['add', 'search', 'filter'];
		$data['content'] = "cms/item_class/item_class.php";
		$data['session'] = session(); 
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
        		"assets/cms/css/main_style.css",
        		"assets/css/style.css"
                    );
		return view("cms/layout/template", $data);	
	}

}
