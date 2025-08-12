<?php

namespace App\Controllers\Cms;

use App\Controllers\BaseController;

class CustomerPricelistDetails extends BaseController
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
			"title"         =>  "Customer Pricelist Details",
			"description"   =>  "Customer Pricelist Details",
			"keyword"       =>  ""
		);
		$data['title'] = "Customer Pricelist Details";
		$data['PageName'] = 'Customer Pricelist Details';
		$data['PageUrl'] = 'Customer Pricelist Details';
		$data['buttons'] = ['add', 'search', 'filter'];
		$data['content'] = "cms/customer_pricelist_details/customer_pricelist_details.php";
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
