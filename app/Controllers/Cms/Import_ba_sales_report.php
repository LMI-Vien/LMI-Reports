<?php

namespace App\Controllers\Cms;

use App\Controllers\BaseController;

class Import_ba_sales_report extends BaseController
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
			"title"         =>  "Import BA Sales Report",
			"description"   =>  "Import BA Sales Report",
			"keyword"       =>  ""
		);
		$data['title'] = "Import BA Sales Report";
		$data['PageName'] = 'Import BA Sales Report';
		$data['PageUrl'] = 'Import BA Sales Report';
		$data['content'] = "cms/import/ba_sales_report.php";
		$data['buttons'] = ['search', 'import', 'export'];
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

	public function get_valid_ba_data(){
		$ba = $this->Global_model->get_valid_records("tbl_brand_ambassador", 'name');
		$brands = $this->Global_model->get_valid_records("tbl_brand", 'brand_description');
		$stores = $this->Global_model->get_valid_records("tbl_store", 'description');
		$areas = $this->Global_model->get_valid_records("tbl_area", 'description');
		return $this->response->setJSON(["ba" => $ba, "brands" => $brands, "stores" => $stores, "areas" => $areas]);
	}

}
