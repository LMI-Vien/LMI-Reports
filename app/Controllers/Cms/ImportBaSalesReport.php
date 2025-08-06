<?php

namespace App\Controllers\Cms;

use App\Controllers\BaseController;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class ImportBaSalesReport extends BaseController
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
		$data['content'] = "cms/import/ba-sales-report/ba_sales_report.php";
		$data['buttons'] = ['import', 'export', 'search'];
		$data['session'] = session(); //for frontend accessing the session data
		$data['standard'] = config('Standard');
		$data['areaMap'] = $this->Global_model->dynamic_search("'tbl_area'", "''", "'id, description'", 0, 0, "''", "''", "''");
		$data['ascMap'] = $this->Global_model->dynamic_search("'tbl_area_sales_coordinator'", "''", "'id, description'", 0, 0, "''", "''", "''");
		$data['baMap'] = $this->Global_model->dynamic_search("'tbl_brand_ambassador'", "''", "'id, name'", 0, 0, "''", "''", "''");

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

	public function view()
	{

		$uri = current_url(true);
		$data['uri'] =$uri;

		$data['meta'] = array(
			"title"         =>  "View Import BA Sales Report",
			"description"   =>  "View Import BA Sales Report",
			"keyword"       =>  ""
		);
		$data['title'] = "View Import BA Sales Report";
		$data['PageName'] = 'View Import BA Sales Report';
		$data['PageUrl'] = 'View Import BA Sales Report';
		$data['content'] = "cms/import/ba-sales-report/view_sales_report.php";
		$data['buttons'] = [];
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

	public function setHeaderCellValue(array $headers, \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet $sheet, int $row = 1): void {
		foreach ($headers as $index => $header) {
			$colLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($index + 1);
			$sheet->setCellValue($colLetter . $row, $header);
		}
	}
	public function exportSpecific() {
		$date = $this->request->getPost('date') ?? '2025-04-01';
		$select = '';
		$select .= 'basr.id, ar.description as area, s.description as store_name, b.brand_description as brand, ba.name as ba_name,';
		$select .= 'basr.date, basr.amount, basr.status, basr.created_date, basr.updated_date, basr.status';

		$join = [
			[ 'table' => 'tbl_brand b', 'query' => 'b.id = basr.brand', 'type' => 'left' ],
			[ 'table' => 'tbl_store s', 'query' => 's.id = basr.store_id', 'type' => 'left' ],
			[ 'table' => 'tbl_brand_ambassador ba', 'query' => 'ba.id = basr.ba_id', 'type' => 'left' ],
			[ 'table' => 'tbl_area ar', 'query' => 'ar.id = basr.area_id', 'type' => 'left' ]
		];

		$result = $this->Global_model->get_data_list(
			'tbl_ba_sales_report basr', 
			"basr.date = '$date'",
			999999999, 
			0, 
			$select,
			'', 
			'', 
			$join, 
			''
		);

		$spreadsheet = new Spreadsheet();
		$sheet       = $spreadsheet->getActiveSheet();

		$sheet->setCellValue('A1', 'Company Name: Lifestrong Marketing Inc.');
		$sheet->setCellValue('A2', 'BA Sales Report');
		$sheet->setCellValue('A3', 'Date Printed: ' . (new \DateTime())->format('Y-m-d h:i A'));

		$header = [ "BA Code", "Area Code", "Store Code", "Brand", "Date", "Amount", "Status" ];
		$this->setHeaderCellValue($header, $sheet, 5);

		$currentRow = 6;

		$lastrowdate = null;
		$total = 0;

		foreach ($result as $key => $value) {
			$header = [
				$value->ba_name, $value->area, $value->store_name, $value->brand, 
				(new \DateTime($value->date))->format('m-d-Y'), $value->amount,
				$value->status == 1 ? 'Active' : 'Inactive'
			];
			$this->setHeaderCellValue($header, $sheet, $currentRow);
			$lastrowdate = (new \DateTime($value->date))->format('m-d-Y');
			$total += $value->amount;
			$currentRow++;
		}
		$header = [ '', '', '','', $lastrowdate, $total, 'Total' ];
		$this->setHeaderCellValue($header, $sheet, $currentRow);

		$title = "BA Sales Report";
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header("Content-Disposition: attachment; filename=\"{$title}.xlsx\"");
		header('Cache-Control: max-age=0');

		$writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
		$writer->save('php://output');
		exit;
	}
	public function exportFilter() {
		$area = $this->request->getPost('area') ?? '';
		$store = $this->request->getPost('store') ?? '';
		$brand = $this->request->getPost('brand') ?? '';
		$ba = $this->request->getPost('ba') ?? '';
		$date_from = $this->request->getPost('date_from') ?? '';
		$date_to = $this->request->getPost('date_to') ?? '';

		$select = '';
		$select .= 'basr.id, ar.description as area, s.description as store_name, b.brand_description as brand, ba.name as ba_name,';
		$select .= 'basr.date, basr.amount, basr.status, basr.created_date, basr.updated_date, basr.status';

		$filter = [];
		if ($area != '') { $filter[] = "ar.description = '$area'"; };
		if ($store != '') { $filter[] = "s.description = '$store'"; };
		if ($brand != '') { $filter[] = "b.brand_code = '$brand'"; };
		if ($ba != '') { $filter[] = "ba.name = '$ba'"; };
		if ($date_from != '' && $date_to != '') { $filter[] = "basr.`date` BETWEEN '$date_from' AND '$date_to'"; };

		$join = [
			[ 'table' => 'tbl_brand b', 'query' => 'b.id = basr.brand', 'type' => 'left' ],
			[ 'table' => 'tbl_store s', 'query' => 's.id = basr.store_id', 'type' => 'left' ],
			[ 'table' => 'tbl_brand_ambassador ba', 'query' => 'ba.id = basr.ba_id', 'type' => 'left' ],
			[ 'table' => 'tbl_area ar', 'query' => 'ar.id = basr.area_id', 'type' => 'left' ]
		];

		$result = $this->Global_model->get_data_list(
			'tbl_ba_sales_report basr', implode(' AND ', $filter), 999999999,
			0, $select, 'date, id', 'asc, asc', $join, ''
		);

		$spreadsheet = new Spreadsheet();
		$sheet       = $spreadsheet->getActiveSheet();

		$sheet->setCellValue('A1', 'Company Name: Lifestrong Marketing Inc.');
		$sheet->setCellValue('A2', 'BA Sales Report');
		$sheet->setCellValue('A3', 'Date Printed: ' . (new \DateTime())->format('Y-m-d h:i A'));

		$header = [ "BA Code", "Area Code", "Store Code", "Brand", "Date", "Amount", "Status" ];
		$this->setHeaderCellValue($header, $sheet, 5);

		$currentRow = 6;
		$lastrowdate = null;
		$total = 0;
		foreach ($result as $value) {
			if ($lastrowdate !== null && $value->date !== $lastrowdate) {
				$header = [ '', '', '','', (new \DateTime($lastrowdate))->format('m-d-Y'), $total, 'Total' ];
				$this->setHeaderCellValue($header, $sheet, $currentRow);
				$currentRow++;

				$header = [ '', '', '','', '', '','' ];
				$this->setHeaderCellValue($header, $sheet, $currentRow);
				$currentRow++;

				$total = 0;
			}

			$header = [
				$value->ba_name, $value->area, $value->store_name, $value->brand, 
				(new \DateTime($value->date))->format('m-d-Y'), $value->amount,
				$value->status == 1 ? 'Active' : 'Inactive'
			];
			$this->setHeaderCellValue($header, $sheet, $currentRow);

			$total += $value->amount;
			$lastrowdate = $value->date;
			$currentRow++;
		}

		if ($lastrowdate !== null) {
			$header = [ '', '', '','', (new \DateTime($lastrowdate))->format('m-d-Y'), $total, 'Total' ];
			$this->setHeaderCellValue($header, $sheet, $currentRow);
		}

		$title = "BA Sales Report";
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header("Content-Disposition: attachment; filename=\"{$title}.xlsx\"");
		header('Cache-Control: max-age=0');

		$writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
		$writer->save('php://output');
		exit;
	}
	public function exportAll() {
		$select = '';
		$select .= 'basr.id, ar.description as area, s.description as store_name, b.brand_description as brand, ba.name as ba_name,';
		$select .= 'basr.date, basr.amount, basr.status, basr.created_date, basr.updated_date, basr.status';

		$join = [
			[ 'table' => 'tbl_brand b', 'query' => 'b.id = basr.brand', 'type' => 'left' ],
			[ 'table' => 'tbl_store s', 'query' => 's.id = basr.store_id', 'type' => 'left' ],
			[ 'table' => 'tbl_brand_ambassador ba', 'query' => 'ba.id = basr.ba_id', 'type' => 'left' ],
			[ 'table' => 'tbl_area ar', 'query' => 'ar.id = basr.area_id', 'type' => 'left' ]
		];

		$result = $this->Global_model->get_data_list(
			'tbl_ba_sales_report basr', '', 999999999, 0, $select,
			'date, id', 'asc, asc', $join, ''
		);

		$spreadsheet = new Spreadsheet();
		$sheet       = $spreadsheet->getActiveSheet();

		$sheet->setCellValue('A1', 'Company Name: Lifestrong Marketing Inc.');
		$sheet->setCellValue('A2', 'BA Sales Report');
		$sheet->setCellValue('A3', 'Date Printed: ' . (new \DateTime())->format('Y-m-d h:i A'));

		$header = [ "BA Code", "Area Code", "Store Code", "Brand", "Date", "Amount", "Status" ];
		$this->setHeaderCellValue($header, $sheet, 5);

		$currentRow = 6;
		$lastrowdate = null;
		$total = 0;
		foreach ($result as $value) {
			if ($lastrowdate !== null && $value->date !== $lastrowdate) {
				$header = [ '', '', '','', (new \DateTime($lastrowdate))->format('m-d-Y'), $total, 'Total' ];
				$this->setHeaderCellValue($header, $sheet, $currentRow);
				$currentRow++;

				$header = [ '', '', '','', '', '','' ];
				$this->setHeaderCellValue($header, $sheet, $currentRow);
				$currentRow++;

				$total = 0;
			}

			$header = [
				$value->ba_name, $value->area, $value->store_name, $value->brand, 
				(new \DateTime($value->date))->format('m-d-Y'), $value->amount,
				$value->status == 1 ? 'Active' : 'Inactive'
			];
			$this->setHeaderCellValue($header, $sheet, $currentRow);

			$total += $value->amount;
			$lastrowdate = $value->date;
			$currentRow++;
		}

		if ($lastrowdate !== null) {
			$header = [ '', '', '','', (new \DateTime($lastrowdate))->format('m-d-Y'), $total, 'Total' ];
			$this->setHeaderCellValue($header, $sheet, $currentRow);
		}

		$title = "BA Sales Report";
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header("Content-Disposition: attachment; filename=\"{$title}.xlsx\"");
		header('Cache-Control: max-age=0');

		$writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
		$writer->save('php://output');
		exit;
	}
}
