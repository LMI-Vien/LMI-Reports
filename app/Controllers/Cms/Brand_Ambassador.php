<?php

namespace App\Controllers\Cms;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Brand_Ambassador extends BaseController
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
			"title"         =>  "Brand Ambassador",
			"description"   =>  "Brand Ambassador",
			"keyword"       =>  ""
		);
		$data['title'] = "Brand Ambassador";
		$data['PageName'] = 'Brand Ambassador';
		$data['PageUrl'] = 'Brand Ambassador';
		$data['buttons'] = ['add', 'import', 'search', 'export', 'filter'];
		$data['content'] = "cms/brand_ambassador/brand_ambassador.php";
		$data['session'] = session(); //for frontend accessing the session data
		$data['js'] = array(
				"assets/js/xlsx.full.min.js",
				"assets/js/bootstrap.min.js",
				"assets/js/adminlte.min.js",
				"assets/js/moment.js"
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
		$agencies = $this->Global_model->get_valid_records("tbl_agency", 'code');
		$brands = $this->Global_model->get_valid_records("tbl_brand", 'brand_description');
		$store_area = $this->Global_model->get_valid_records_store_group();
		$stores = $this->Global_model->get_valid_records("tbl_store", 'code');
		$teams = $this->Global_model->get_valid_records("tbl_team", 'code');
		$areas = $this->Global_model->get_valid_records("tbl_area", 'code');
		return $this->response->setJSON(["agencies" => $agencies, "brands" => $brands, "stores" => $stores, "store_area" => $store_area, "teams" => $teams, "areas" => $areas]);
	}

}
