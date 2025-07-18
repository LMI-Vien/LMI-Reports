<?php

namespace App\Controllers\Cms;

use App\Controllers\BaseController;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class BrandAmbassador extends BaseController
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

	public function export_ba() 
	{
		$ids = $this->request->getGet('selectedids');
		$ids = $ids === [] ? null : $ids;
		$result_data = '';

		if ($ids == 0) {
			// $result_data = $this->Global_model->get_data_list(
			// 	$table, $query, $limit, $offset, $select, $order_field, $order_type, $join, $group
			// );
			$result_data = $this->Global_model->get_data_list(
				'`tbl_brand_ambassador` ba', 
				'ba.status >= 0', 
				999999999, 0, 
				'ba.id, ba.code, ba.name, 
				ba.deployment_date, ag.agency, 
				br.brand_code, tm.team_description as team, 
				ba.type, ba.status', 
				'', 
				'', 
				[
					// left join tbl_agency ag on ag.id = ba.agency
					[
						"table" => "tbl_agency ag",
						"query" => "ag.id = ba.agency",
						"type" => "left",
					],
					// left join tbl_ba_brands babr on babr.ba_id = ba.id
					[
						"table" => "tbl_ba_brands babr",
						"query" => "babr.ba_id = ba.id",
						"type" => "left",
					],
					// left join tbl_brand br on br.id = babr.brand_id
					[
						"table" => "tbl_brand br",
						"query" => "br.id = babr.brand_id",
						"type" => "left",
					],
					// left join tbl_team tm on tm.id = ba.team
					[
						"table" => "tbl_team tm",
						"query" => "tm.id = ba.team",
						"type" => "left",
					],
				],
				''
			);
			// echo json_encode($result_data); die();
		} 
		else {
			$result_data = $this->Global_model->get_data_list(
				'`tbl_brand_ambassador` ba', 
				"ba.id IN ($ids)", 
				999999999, 0, 
				'ba.id, ba.code, ba.name, 
				ba.deployment_date, ag.agency, 
				br.brand_code, tm.team_description as team, 
				ba.type, ba.status', 
				'', 
				'', 
				[
					// left join tbl_agency ag on ag.id = ba.agency
					[
						"table" => "tbl_agency ag",
						"query" => "ag.id = ba.agency",
						"type" => "left",
					],
					// left join tbl_ba_brands babr on babr.ba_id = ba.id
					[
						"table" => "tbl_ba_brands babr",
						"query" => "babr.ba_id = ba.id",
						"type" => "left",
					],
					// left join tbl_brand br on br.id = babr.brand_id
					[
						"table" => "tbl_brand br",
						"query" => "br.id = babr.brand_id",
						"type" => "left",
					],
					// left join tbl_team tm on tm.id = ba.team
					[
						"table" => "tbl_team tm",
						"query" => "tm.id = ba.team",
						"type" => "left",
					],
				],
				''
			);
			// echo json_encode($result_data); die();
		}
		$currentDateTime = date('Y-m-d H:i:s');

		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

		$sheet->setCellValue('A1', 'Company Name: Lifestrong Marketing Inc.');
		$sheet->setCellValue('A2', 'Masterfile: Brand Ambassador');
		$sheet->setCellValue('A3', 'Date Printed: '.$currentDateTime);
		$sheet->mergeCells('A1:H1');
		$sheet->mergeCells('A2:H2');
		$sheet->mergeCells('A3:H3');

		$rowNum = 6;
		foreach ($result_data as $row) {
			$headers = ["Code",	"Name", "Deployment Date", "Agency", "Brand", "Team", "Type", "Status"];
			$sheet->fromArray($headers, null, 'A5');
			$sheet->getStyle('A5:H5')->getFont()->setBold(true);

			$sheet->setCellValueExplicit('A' . $rowNum, $row->code, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
			$sheet->setCellValueExplicit('B' . $rowNum, $row->name, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
			$sheet->setCellValueExplicit('C' . $rowNum, date('m/d/Y', strtotime($row->deployment_date)), \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
			$sheet->setCellValueExplicit('D' . $rowNum, $row->agency, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
			$sheet->setCellValueExplicit('E' . $rowNum, $row->brand_code, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
			$sheet->setCellValueExplicit('F' . $rowNum, $row->team, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
			$sheet->setCellValueExplicit('G' . $rowNum, $row->type == 1 ? "Outright" : "Consign", \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
			$sheet->setCellValueExplicit('H' . $rowNum, $row->status == 1 ? 'Active' : 'Inactive', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
			$rowNum+=1;
			
		}

		$title = 'Brand Ambassador Masterfile' . date('Ymd_His');

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header("Content-Disposition: attachment; filename=\"{$title}.xlsx\"");
		header('Cache-Control: max-age=0');

		$writer = new Xlsx($spreadsheet);
		$writer->save('php://output');
		exit;
	}

}
