<?php

namespace App\Controllers\Cms;

use App\Controllers\BaseController;
use App\Models\Global_model;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

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
		$data['buttons'] = ['add', 'search', 'import', 'export', 'filter'];
		$data['content'] = "cms/pricelist_masterfile/pricelist_masterfile.php";
		$data['session'] = session(); //for frontend accessing the session data
		$query = [
		    'status' => 1
		];
		$data['cusPayGroup'] = $this->Global_model->get_data_list('tbl_cus_payment_group_lmi', $query, 99, 0, 'id, customer_group_code', 'customer_group_code', 'ASC', null, null);
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
		$data['buttons'] = ['add', 'import', 'export', 'search'];
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

	public function customerPricelistDetails($customerId = null, $cusPricelistId = null)
	{

		$uri = current_url(true);
		$data['uri'] =$uri;

		if ($customerId === null) {
            $customerId = $this->request->uri->getSegment(4);
        }
		$data['customerId'] = $customerId;
		$data['cusPricelistId'] = $cusPricelistId;

		$data['meta'] = array(
			"title"         =>  "Customer Details Pricelist",
			"description"   =>  "SFA Pricelist Customer Details Pricelist",
			"keyword"       =>  ""
		);
		$data['title'] = "Customer Details Pricelist";
		$data['PageName'] = 'Customer Details Pricelist';
		$data['PageUrl'] = 'Customer Details Pricelist';
		$data['content'] = "cms/pricelist_masterfile/customer_details_pricelist.php";
		$data['buttons'] = ['search'];
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
						'uid'    			   => $source . '|' . $id,
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

	public function pullFromMain()
	{
		$customerId     = (int) ($this->request->getPost('customerId') ?? 0);
		$cusPricelistId = (int) ($this->request->getPost('cusPricelistId') ?? $this->request->getPost('pricelistId') ?? 0);
		$userId         = (int) ($this->session->get('sess_uid') ?? 0);

		try {
			$model    = new Global_model();
			$inserted = $model->pullFromMain($customerId, $cusPricelistId, $userId);
			return $this->response->setJSON(['ok' => true, 'inserted' => $inserted]);
		} catch (\Throwable $e) {
			return $this->response->setJSON(['ok' => false, 'msg' => $e->getMessage()])->setStatusCode(500);
		}
	}

	public function refreshFromMain()
	{
		$customerId     = (int) ($this->request->getPost('customerId') ?? 0);
		$cusPricelistId = (int) ($this->request->getPost('cusPricelistId') ?? $this->request->getPost('pricelistId') ?? 0);
		$userId         = (int) ($this->session->get('sess_uid') ?? 0);

		$model   = new Global_model();
		$updated = $model->refreshFromMain($customerId, $cusPricelistId, $userId);

		return $this->response->setJSON(['ok' => true, 'updated' => $updated]);
	}

	public function exportMotherPricelist() {
		$ids = $this->request->getGet('selectedids');
		$ids = $ids === [] ? null : $ids;
		$result_data = '';

		if ($ids == 0) {
			$result_data = $this->Global_model->get_data_list(
				'tbl_pricelist_masterfile', 'status >= 0', 999999999, 0, 'description, remarks, status', '', '', '', ''
			);
		} 
		else {
			$result_data = $this->Global_model->get_data_list(
				'tbl_pricelist_masterfile', "id IN ($ids) status >= 0", 999999999, 0, 'description, remarks, status', '', '', '', ''
			);
		}
		$currentDateTime = date('Y-m-d H:i:s');

		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

		$sheet->setCellValue('A1', 'Company Name: Lifestrong Marketing Inc.');
		$sheet->setCellValue('A2', 'Masterfile: Pricelist');
		$sheet->setCellValue('A3', 'Date Printed: '.$currentDateTime);
		$sheet->mergeCells('A1:C1');
		$sheet->mergeCells('A2:C2');
		$sheet->mergeCells('A3:C3');

		$rowNum = 6;
		foreach ($result_data as $row) {
			$headers = ['Description', 'Remarks', 'Status'];
			$sheet->fromArray($headers, null, 'A5');
			$sheet->getStyle('A5:E5')->getFont()->setBold(true);

			$sheet->setCellValueExplicit('A' . $rowNum, $row->description, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
			$sheet->setCellValueExplicit('B' . $rowNum, $row->remarks, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
			$sheet->setCellValueExplicit('C' . $rowNum, $row->status == 1 ? 'Active' : 'Inactive', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
			$rowNum+=1;
			
		}

		$title = 'Pricelist Masterfile_' . date('Ymd_His');

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header("Content-Disposition: attachment; filename=\"{$title}.xlsx\"");
		header('Cache-Control: max-age=0');

		$writer = new Xlsx($spreadsheet);
		$writer->save('php://output');
		exit;
	}

	
	public function exportPricelistDetails() {
		$ids = $this->request->getGet('selectedids');
		$ids = $ids === [] ? null : $ids;
		$result_data = '';

		$select = "
			pl.id, pl.pricelist_id,
			pl.brand_id, brnd.brand_code AS brand_code,
			pl.brand_label_type_id, brlbltyp.label AS brand_label_type,
			pl.label_type_category_id, catlist.code AS catlist_code,
			pl.category_1_id, class.item_class_code AS labeltype_code,
			pl.category_2_id, sclass.item_sub_class_code AS item_subclass,
			pl.category_3_id, idept.item_department_code AS item_department,
			pl.category_4_id, mcat.item_mech_cat_code AS merchandise_cat,
			pl.item_code, pl.item_description,
			pl.cust_item_code, pl.uom,
			pl.selling_price, pl.disc_in_percent,
			pl.net_price, pl.effectivity_date,
			pl.status, pl.updated_date, pl.created_date
		";

		$joins = [
			['table' => 'tbl_brand brnd',                         'query' => 'brnd.id = pl.brand_id',                   'type' => 'left'],
			['table' => 'tbl_label_category_list catlist',        'query' => 'catlist.id = pl.label_type_category_id',  'type' => 'left'],
			['table' => 'tbl_classification class',               'query' => 'class.id = pl.category_1_id',             'type' => 'left'],
			['table' => 'tbl_brand_label_type brlbltyp',          'query' => 'brlbltyp.id = pl.brand_label_type_id',    'type' => 'left'],
			['table' => 'tbl_sub_classification sclass',          'query' => 'sclass.id = pl.category_2_id',            'type' => 'left'],
			['table' => 'tbl_item_department idept',              'query' => 'idept.id = pl.category_3_id',             'type' => 'left'],
			['table' => 'tbl_item_merchandise_category mcat',     'query' => 'mcat.id = pl.category_4_id',              'type' => 'left'],
		];


		if ($ids == 0) {
			$result_data = $this->Global_model->get_data_list(
				'tbl_main_pricelist pl', 'pl.status >= 0', 999999999, 0, $select, '', '', $joins, ''
			);
		} 
		else {
			$result_data = $this->Global_model->get_data_list(
				'tbl_main_pricelist pl', "id IN ($ids) pl.status >= 0", 999999999, 0, $select, '', '', $joins, ''
			);
		}
		$currentDateTime = date('Y-m-d H:i:s');

		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

		$sheet->setCellValue('A1', 'Company Name: Lifestrong Marketing Inc.');
		$sheet->setCellValue('A2', 'Masterfile: Pricelist Details');
		$sheet->setCellValue('A3', 'Date Printed: '.$currentDateTime);
		$sheet->mergeCells('A1:G1');
		$sheet->mergeCells('A2:G2');
		$sheet->mergeCells('A3:G3');


		$headers = [
			'Brand Code','Brand Label Type','Label Type Cat','Category 1 (Item Classification MF)','Category 2 (Sub Classification MF)','Category 3 (Department Category MF)','Category 4 (Merch. Category MF)',
			'Item Code','Item Description','Customer Item Code','UOM',
			'Selling Price','Discount %','Net Price','Effectivity Date','Status'
		];
		$sheet->fromArray($headers, null, 'A5');
		$sheet->getStyle('A5:P5')->getFont()->setBold(true);

		$rowNum = 6;
		foreach ($result_data as $row) {
			$sheet->setCellValueExplicit('A'.$rowNum, $row->brand_code, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
			$sheet->setCellValueExplicit('B'.$rowNum, $row->brand_label_type, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
			$sheet->setCellValueExplicit('C'.$rowNum, $row->catlist_code, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
			$sheet->setCellValueExplicit('D'.$rowNum, $row->labeltype_code, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
			$sheet->setCellValueExplicit('E'.$rowNum, $row->item_subclass, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
			$sheet->setCellValueExplicit('F'.$rowNum, $row->item_department, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
			$sheet->setCellValueExplicit('G'.$rowNum, $row->merchandise_cat, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);

			$sheet->setCellValueExplicit('H'.$rowNum, $row->item_code, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
			$sheet->setCellValueExplicit('I'.$rowNum, $row->item_description, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
			$sheet->setCellValueExplicit('J'.$rowNum, $row->cust_item_code, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
			$sheet->setCellValueExplicit('K'.$rowNum, $row->uom, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);

			$sheet->setCellValue('L'.$rowNum, $row->selling_price);
			$sheet->setCellValue('M'.$rowNum, $row->disc_in_percent);
			$sheet->setCellValue('N'.$rowNum, $row->net_price);
			$sheet->setCellValueExplicit('O'.$rowNum, $row->effectivity_date, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
			$sheet->setCellValueExplicit('P'.$rowNum, ((int)$row->status === 1 ? 'Active' : 'Inactive'), \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
			
			$rowNum+=1;
			
		}

		$title = 'Pricelist Masterfile_' . date('Ymd_His');

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header("Content-Disposition: attachment; filename=\"{$title}.xlsx\"");
		header('Cache-Control: max-age=0');

		$writer = new Xlsx($spreadsheet);
		$writer->save('php://output');
		exit;
	}


}
