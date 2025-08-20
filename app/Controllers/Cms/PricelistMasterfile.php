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

	public function pricelistDetails($id = null)
	{

		$uri = current_url(true);
		$data['uri'] =$uri;

		if ($id === null) {
            $id = $this->request->uri->getSegment(4);
        }
		$data['pricelistId'] = $id;

		$data['meta'] = array(
			"title"         =>  "Pricelist Details",
			"description"   =>  "SFA Pricelist Price Details",
			"keyword"       =>  ""
		);
		$data['title'] = "Pricelist Details";
		$data['PageName'] = 'Pricelist Details';
		$data['PageUrl'] = 'Pricelist Details';
		$data['content'] = "cms/pricelist_masterfile/pricelist_details.php";
		$data['buttons'] = ['add', 'search'];
		$data['session'] = session();
		$query = [
		    'status' => 1
		];
		$data['brands'] = $this->Global_model->get_data_list('tbl_brand', $query, 99, 0, 'id, brand_code, brand_description', 'brand_code', 'ASC', null, null);
		$data['labelCategory'] = $this->Global_model->get_data_list('tbl_label_category_list', $query, 99, 0, 'id, code, description', 'code', 'ASC', null, null);
		$data['itemClass'] = $this->Global_model->get_data_list('tbl_item_class', $query, 99, 0, 'id, item_class_code, item_class_description', 'item_class_code', 'ASC', null, null);
		
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
        		"assets/cms/css/main_style.css",
        		"assets/css/style.css"
                    );
		return view("cms/layout/template", $data);		
	}

	public function customerPricelistDetails($id = null)
	{

		$uri = current_url(true);
		$data['uri'] =$uri;

		if ($id === null) {
            $id = $this->request->uri->getSegment(4);
        }
		$data['pricelistId'] = $id;

		$data['meta'] = array(
			"title"         =>  "Customer Details Pricelist",
			"description"   =>  "SFA Pricelist Customer Details Pricelist",
			"keyword"       =>  ""
		);
		$data['title'] = "Customer Details Pricelist";
		$data['PageName'] = 'Customer Details Pricelist';
		$data['PageUrl'] = 'Customer Details Pricelist';
		$data['content'] = "cms/pricelist_masterfile/customer_details_pricelist.php";
		$data['buttons'] = ['add', 'search'];
		$data['session'] = session();
		$query = [
		    'status' => 1
		];
		$data['brands'] = $this->Global_model->get_data_list('tbl_brand', $query, 99, 0, 'id, brand_code, brand_description', 'brand_code', 'ASC', null, null);
		$data['labelCategory'] = $this->Global_model->get_data_list('tbl_label_category_list', $query, 99, 0, 'id, code, description', 'code', 'ASC', null, null);
		$data['itemClass'] = $this->Global_model->get_data_list('tbl_item_class', $query, 99, 0, 'id, item_class_code, item_class_description', 'item_class_code', 'ASC', null, null);
		

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
        		"assets/cms/css/main_style.css",
        		"assets/css/style.css"
                    );
		return view("cms/layout/template", $data);		
	}

	public function getMergedCustomers() {
		$query = 'status = 1';
		$list1 = $this->Global_model->get_data_list('tbl_customer_lmi', $query, 99, 0, 'id, customer_code, customer_description', 'id', 'ASC', null, null);
		$list2 = $this->Global_model->get_data_list('tbl_customer_rgdi', $query, 99, 0, 'id, customer_code, customer_description', 'id', 'ASC', null, null);

		// Normalize & merge by "code|description"
		$merged = [];
		foreach ([$list1, $list2] as $idx => $list) {
			$source = $idx === 0 ? 'lmi' : 'rgdi';
			foreach ((array)$list as $row) {
				// In case $row is array not object, normalize access:
				$code = is_object($row) ? $row->customer_code : $row['customer_code'];
				$desc = is_object($row) ? $row->customer_description : $row['customer_description'];
				$id   = is_object($row) ? $row->id : $row['id'];

				$key = trim((string)$code) . '|' . trim((string)$desc);
				if (!isset($merged[$key])) {
					$merged[$key] = [
						'id' => $id,
						'customer_code' => (string)$code,
						'customer_description' => (string)$desc,
						'source' => $source,
					];
				}
			}
		}

		// Reindex & sort by code then description
		$out = array_values($merged);
		usort($out, function($a, $b) {
			$c = strcasecmp($a['customer_code'], $b['customer_code']);
			return $c !== 0 ? $c : strcasecmp($a['customer_description'], $b['customer_description']);
		});

		return $this->response->setJSON($out);
	}


}
