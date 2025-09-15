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
		$data['buttons'] = ['add', 'search', 'import', 'filter'];
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
		$data['buttons'] = ['add', 'import', 'search'];
		$data['session'] = session();
		$query = [
		    'status' => 1
		];
		$data['brands'] = $this->Global_model->get_data_list('tbl_brand', $query, 99, 0, 'id, brand_code, brand_description', 'brand_code', 'ASC', null, null);
		$data['brandLabelType'] = $this->Global_model->get_data_list('tbl_brand_label_type', null, 99, 0, 'id, label', 'label', 'ASC', null, null);
		$data['labelCategory'] = $this->Global_model->get_data_list('tbl_label_category_list', $query, 99, 0, 'id, code, description', 'code', 'ASC', null, null);
		$data['itemClass'] = $this->Global_model->get_data_list('tbl_classification', $query, 99, 0, 'id, item_class_code, item_class_description', 'item_class_code', 'ASC', null, null);
		$data['subClass'] = $this->Global_model->get_data_list('tbl_sub_classification', $query, 99, 0, 'id, item_sub_class_code', 'item_sub_class_code', 'ASC', null, null);
		$data['itemDepartment'] = $this->Global_model->get_data_list('tbl_item_department', $query, 99, 0, 'id, item_department_code', 'item_department_code', 'ASC', null, null);
		$data['merchCategory'] = $this->Global_model->get_data_list('tbl_item_merchandise_category', $query, 99, 0, 'id, item_mech_cat_code', 'item_mech_cat_code', 'ASC', null, null);
		
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
		$data['customerId'] = $id;

		$data['meta'] = array(
			"title"         =>  "Customer Details Pricelist",
			"description"   =>  "SFA Pricelist Customer Details Pricelist",
			"keyword"       =>  ""
		);
		$data['title'] = "Customer Details Pricelist";
		$data['PageName'] = 'Customer Details Pricelist';
		$data['PageUrl'] = 'Customer Details Pricelist';
		$data['content'] = "cms/pricelist_masterfile/customer_details_pricelist.php";
		$data['buttons'] = ['add', 'import', 'search'];
		$data['session'] = session();
		$query = [
		    'status' => 1
		];
		$data['brands'] = $this->Global_model->get_data_list('tbl_brand', $query, 99, 0, 'id, brand_code, brand_description', 'brand_code', 'ASC', null, null);
		$data['brandLabelType'] = $this->Global_model->get_data_list('tbl_brand_label_type', null, 99, 0, 'id, label', 'label', 'ASC', null, null);
		$data['labelCategory'] = $this->Global_model->get_data_list('tbl_label_category_list', $query, 99, 0, 'id, code, description', 'code', 'ASC', null, null);
		$data['itemClass'] = $this->Global_model->get_data_list('tbl_item_class', $query, 99, 0, 'id, item_class_code, item_class_description', 'item_class_code', 'ASC', null, null);
		$data['subClass'] = $this->Global_model->get_data_list('tbl_sub_classification', $query, 99, 0, 'id, item_sub_class_code', 'item_sub_class_code', 'ASC', null, null);
		$data['itemDepartment'] = $this->Global_model->get_data_list('tbl_item_department', $query, 99, 0, 'id, item_department_code', 'item_department_code', 'ASC', null, null);
		$data['merchCategory'] = $this->Global_model->get_data_list('tbl_item_merchandise_category', $query, 99, 0, 'id, item_mech_cat_code', 'item_mech_cat_code', 'ASC', null, null);
		

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

	public function getMergedItemFile() {
		$query = 'inactive = 0';
		$limit = 0;

		$fields = 'recid, itmcde, itmdsc';
		$list1 = $this->Global_model->get_data_list('tbl_itemfile_lmi',  $query, $limit, 0, $fields, 'recid', 'ASC', null, null);
		$list2 = $this->Global_model->get_data_list('tbl_itemfile_rgdi', $query, $limit, 0, $fields, 'recid', 'ASC', null, null);

		// normalizer: trim, collapse spaces, lowercase
		$norm = function ($v) {
			$v = preg_replace('/\s+/', ' ', (string)$v);
			return strtolower(trim($v));
		};

		$merged = [];
		foreach ([['lmi',$list1], ['rgdi',$list2]] as [$source, $list]) {
			foreach ((array)$list as $row) {
				$origCode = is_object($row) ? $row->itmcde : $row['itmcde'];
				$origDesc = is_object($row) ? $row->itmdsc : $row['itmdsc'];
				$id       = (string)(is_object($row) ? $row->recid : $row['recid']);

				// normalized only for dedupe key
				$key = $norm($origCode) . '|' . $norm($origDesc);

				if (!isset($merged[$key])) {
					$merged[$key] = [
						'uid'    => $source . '|' . $id,
						'id'     => $id,
						'itmcde' => trim($origCode),
						'itmdsc' => trim($origDesc),
						'source' => $source,
					];
				}
			}
		}

		// Reindex & sort using lowercase compare
		$out = array_values($merged);
		usort($out, function($a, $b) {
			$c = strcmp(strtolower($a['itmcde']), strtolower($b['itmcde']));
			return $c !== 0 ? $c : strcmp(strtolower($a['itmdsc']), strtolower($b['itmdsc']));
		});

		return $this->response->setJSON($out);
	}

	public function getMergedCustomers() {
		$query = 'status = 1';
		$limit = 0;

		$list1 = $this->Global_model->get_data_list('tbl_customer_lmi', $query, $limit, 0, 'id, customer_code, customer_description', 'id', 'ASC', null, null);
		$list2 = $this->Global_model->get_data_list('tbl_customer_rgdi', $query, $limit, 0, 'id, customer_code, customer_description', 'id', 'ASC', null, null);

		$norm = function ($v) {
			$v = preg_replace('/\s+/', ' ', (string)$v);
			return strtolower(trim($v));
		};

		// Normalize & merge by "code|description"
		$merged = [];
		foreach ([['lmi',$list1], ['rgdi',$list2]] as [$source, $list]) {
			foreach ((array)$list as $row) {
				$id   = (string)(is_object($row) ? $row->id : $row['id']);
				$code = is_object($row) ? $row->customer_code : $row['customer_code'];
				$desc = is_object($row) ? $row->customer_description : $row['customer_description'];

				// use normalized values for the de-dupe key
				$key = $norm($code) . '|' . $norm($desc);

				if (!isset($merged[$key])) {
					// keep trimmed originals in the output (same as getMergedItemFile)
					$merged[$key] = [
						'id'                   => $id,
						'customer_code'        => trim($code),
						'customer_description' => trim($desc),
						'source'               => $source,
					];
				}
			}
		}

		// Reindex & sort by code then description
		$out = array_values($merged);
		usort($out, function($a, $b) {
			$c = strcmp(strtolower($a['customer_code']), strtolower($b['customer_code']));
			return $c !== 0 ? $c : strcmp(strtolower($a['customer_description']), strtolower($b['customer_description']));
		});

		return $this->response->setJSON($out);
	}


}
