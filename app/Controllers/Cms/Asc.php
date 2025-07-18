<?php

namespace App\Controllers\Cms;

use App\Controllers\BaseController;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Asc extends BaseController
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
			"title"         =>  "Area Sales Coordinator Masterfile",
			"description"   =>  "Area Sales Coordinator Masterfile",
			"keyword"       =>  ""
		);
		$data['title'] = "Area Sales Coordinator";
		$data['PageName'] = 'Area Sales Coordinator';
		$data['PageUrl'] = 'Area Sales Coordinator';
		$data['content'] = "cms/asc/asc.php";
		$data['buttons'] = ['add', 'search', 'import', 'export', 'filter'];
		$data['session'] = session(); //for frontend accessing the session data
		$data['js'] = array(
				"assets/js/xlsx.full.min.js",
				"assets/js/bootstrap.min.js",
				"assets/js/adminlte.min.js"
				//"assets/cms/js/jquery-ui.js",
                    );
        $data['css'] = array(
        		"assets/css/bootstrap.min.css",
        		"assets/css/adminlte.min.css",
        		"assets/css/all.min.css",
        		"assets/cms/css/main_style.css",//css sa style ni master Vien
        		//"assets/cms/css/jquery-ui.css",
        		"assets/css/style.css"
                    );
		return view("cms/layout/template", $data);		
	}

	public function get_valid_ba_data(){
		$areas = $this->Global_model->get_valid_records("tbl_area", 'description');
		return $this->response->setJSON(["areas" => $areas]);
	}

	public function export_asc() 
	{
		$ids = $this->request->getGet('selectedids');
		$ids = $ids === [] ? null : $ids;
		$result_data = '';

		if ($ids == 0) {
			// $result_data = $this->Global_model->get_data_list(
			// 	$table, $query, $limit, $offset, $select, $order_field, $order_type, $join, $group
			// );
			$result_data = $this->Global_model->get_data_list(
				'tbl_area_sales_coordinator a', 
				'a.status >= 0', 
				999999999, 0, 
				'a.code as asc_code, a.description as asc_description, 
				a.deployment_date as deployment_date, a.status as status, 
				b.code as area_code, b.description as area_description', 
				'', 
				'', 
				[
					[
						"table" => "tbl_area b",
						"query" => "a.area_id = b.id",
						"type" => "left",
					]
				],
				''
			);
			// echo json_encode($result_data); die();
		} 
		else {
			$result_data = $this->Global_model->get_data_list(
				'tbl_area_sales_coordinator a', 
				"a.id IN ($ids)", 
				999999999, 0, 
				'a.code as asc_code, a.description as asc_description, 
				a.deployment_date as deployment_date, a.status as status, 
				b.code as area_code, b.description as area_description', 
				'', 
				'', 
				[
					[
						"table" => "tbl_area b",
						"query" => "a.area_id = b.id",
						"type" => "left",
					]
				],
				''
			);
			// echo json_encode($result_data); die();
		}
		$currentDateTime = date('Y-m-d H:i:s');

		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

		$sheet->setCellValue('A1', 'Company Name: Lifestrong Marketing Inc.');
		$sheet->setCellValue('A2', 'Masterfile: Area Sales Coordinator');
		$sheet->setCellValue('A3', 'Date Printed: '.$currentDateTime);
		$sheet->mergeCells('A1:C1');
		$sheet->mergeCells('A2:C2');
		$sheet->mergeCells('A3:C3');

		$rowNum = 6;
		foreach ($result_data as $row) {
			$headers = ["Code",	"Description", "Status", "Deployment Date", "Area Code", "Area Description"];
			$sheet->fromArray($headers, null, 'A5');
			$sheet->getStyle('A5:F5')->getFont()->setBold(true);

			$sheet->setCellValueExplicit('A' . $rowNum, $row->asc_code, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
			$sheet->setCellValueExplicit('B' . $rowNum, $row->asc_description, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
			$sheet->setCellValueExplicit('C' . $rowNum, $row->status == 1 ? 'Active' : 'Inactive', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
			$sheet->setCellValueExplicit('D' . $rowNum, date('m/d/Y', strtotime($row->deployment_date)), \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
			$sheet->setCellValueExplicit('E' . $rowNum, $row->area_code, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
			$sheet->setCellValueExplicit('F' . $rowNum, $row->area_description, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
			$rowNum+=1;
			
		}

		$title = 'Area Sales Coordinator Masterfile' . date('Ymd_His');

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header("Content-Disposition: attachment; filename=\"{$title}.xlsx\"");
		header('Cache-Control: max-age=0');

		$writer = new Xlsx($spreadsheet);
		$writer->save('php://output');
		exit;
	}

}
