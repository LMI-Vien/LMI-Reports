<?php

namespace App\Controllers\Cms;

use App\Controllers\BaseController;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Area extends BaseController
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
			"title"         =>  "Area Masterfile",
			"description"   =>  "Area Masterfile",
			"keyword"       =>  ""
		);
		$data['title'] = "Area";
		$data['PageName'] = 'Area';
		$data['PageUrl'] = 'Area';
		$data['content'] = "cms/area/area.php";
		$data['buttons'] = ['add', 'search', 'import', 'export', 'filter'];
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
		$stores = $this->Global_model->get_valid_records("tbl_store", 'description');
		return $this->response->setJSON(["stores" => $stores]);
	}

	public function get_latest_area_code() {
	    $year  = date('Y');
	    $month = date('m');
	    $prefix = "AREA-{$year}-{$month}-";

	    $row = $this->db->table('tbl_area')
	        ->select('code')
	        ->like('code', $prefix, 'after')
	        ->orderBy('code', 'DESC')
	        ->limit(1)
	        ->get()
	        ->getRow();

	    $latestCode = $row->code ?? "{$prefix}000";

	    return $this->response->setJSON([
	        'code' => $latestCode
	    ]);
	}

	public function get_existing_area_data() {
	    $result = $this->db->table('tbl_area')
	        ->select('code, description')
	        ->where('status', 1)
	        ->get()
	        ->getResultArray();

	    return $this->response->setJSON($result);
	}

	public function export_area() {
		$ids = $this->request->getGet('selectedids');
		$ids = $ids === [] ? null : $ids;
		$result_data = '';

		if ($ids == 0) {
			// $result_data = $this->Global_model->get_data_list(
			// 	$table, $query, $limit, $offset, $select, $order_field, $order_type, $join, $group
			// );
			$result_data = $this->Global_model->get_data_list(
				'tbl_area', 'status >= 0', 999999999, 0, 'id, code, description, status', '', '', '', ''
			);

			$sgIds = [];
			foreach ($result_data as $area_ids) {
				$sgIds[] = $area_ids->id;
			}
			$sgIds = implode(",", $sgIds);

			$store_data = $this->Global_model->get_data_list(
				'tbl_store_group sg', 
				"sg.area_id IN ($sgIds)", 
				999999999, 
				0, 
				'sg.area_id,GROUP_CONCAT(s.code, s.description ORDER BY s.description) AS stores', 
				'', 
				'', 
				// 'LEFT JOIN tbl_store s ON s.id = sg.store_id', 
				[
					[
						"table"=> "tbl_store s",
						"query"=> "s.id = sg.store_id",
						"type"=> "left"
					]
				],
				'sg.area_id'
			);
		} 
		else {
			$result_data = $this->Global_model->get_data_list(
				'tbl_area', "id IN ($ids)", 999999999, 0, 'code, description, status', '', '', '', ''
			);
			$store_data = $this->Global_model->get_data_list(
				'tbl_store_group sg', 
				"sg.area_id IN ($ids)", 
				999999999, 
				0, 
				'sg.area_id,GROUP_CONCAT(s.code, s.description ORDER BY s.description) AS stores', 
				'', 
				'', 
				// 'tbl_store s ON s.id = sg.store_id', 
				[
					[
						"table"=> "tbl_store s",
						"query"=> "s.id = sg.store_id",
						"type"=> "left"
					]
				],
				'sg.area_id'
			);
		}
		$currentDateTime = date('Y-m-d H:i:s');

		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

		$sheet->setCellValue('A1', 'Company Name: Lifestrong Marketing Inc.');
		$sheet->setCellValue('A2', 'Masterfile: Area');
		$sheet->setCellValue('A3', 'Date Printed: '.$currentDateTime);
		$sheet->mergeCells('A1:D1');
		$sheet->mergeCells('A2:D2');
		$sheet->mergeCells('A3:D3');

		$rowNum = 6;
		foreach ($result_data as $key => $row) {
			$headers = ['Area Code', 'Area Description', 'Status', 'Stores'];
			$sheet->fromArray($headers, null, 'A5');
			$sheet->getStyle('A5:D5')->getFont()->setBold(true);

			$sheet->setCellValueExplicit('A' . $rowNum, $row->code, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
			$sheet->setCellValueExplicit('B' . $rowNum, $row->description, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
			$sheet->setCellValueExplicit('C' . $rowNum, $row->status == 1 ? 'Active' : 'Inactive', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
			$sheet->setCellValueExplicit('D' . $rowNum, $store_data[$key]->stores, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
			$rowNum+=1;
			
		}

		$title = 'Area Masterfile' . date('Ymd_His');

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header("Content-Disposition: attachment; filename=\"{$title}.xlsx\"");
		header('Cache-Control: max-age=0');

		$writer = new Xlsx($spreadsheet);
		$writer->save('php://output');
		exit;
	}

}
