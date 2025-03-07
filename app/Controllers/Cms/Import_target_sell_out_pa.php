<?php

namespace App\Controllers\Cms;

use App\Controllers\BaseController;

class Import_target_sell_out_pa extends BaseController
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
			"title"         =>  "Import Target sell Out Per Account",
			"description"   =>  "Import Target sell Out Per Account",
			"keyword"       =>  ""
		);
		$data['title'] = "Import Target sell Out Per Account";
		$data['PageName'] = 'Import Target sell Out Per Account';
		$data['PageUrl'] = 'Import Target sell Out Per Account';
		$data['content'] = "cms/import/target_sell_out_pa.php";
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
		$payment_group = $this->Global_model->get_valid_records("tbl_payment_group", 'customer_group_code');
		$customer_sku_code_lmi = $this->Global_model->get_valid_records_tracc_data("pricecodefile2", 'cusitmcde');
		$customer_sku_code_rgdi = $this->Global_model->get_valid_records_tracc_data("pricecodefile2rgdi", 'cusitmcde');
		$brands = $this->Global_model->get_valid_records("tbl_brand", 'brand_code');
		return $this->response->setJSON([
		    "payment_group" => $payment_group,
		    "brands" => $brands,
		    "customer_sku_code_lmi" => $customer_sku_code_lmi,
		    "customer_sku_code_rgdi" => $customer_sku_code_rgdi
		]);

	}

}
