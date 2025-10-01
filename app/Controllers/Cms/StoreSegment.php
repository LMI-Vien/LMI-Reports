<?php

namespace App\Controllers\Cms;

use App\Controllers\BaseController;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class StoreSegment extends BaseController
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
			"title"         =>  "Store Segment",
			"description"   =>  "Store Segment",
			"keyword"       =>  ""
		);
		$data['title'] = "Store Segment";
		$data['PageName'] = 'Store Segment';
		$data['PageUrl'] = 'Store Segment';
		$data['buttons'] = ['add', 'search', 'import', 'export', 'filter'];
		$data['content'] = "cms/store_segment/store-segment.php";
		$data['session'] = session();
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

	public function exportStoreSegment() {
		$ids = $this->request->getGet('selectedids');
		$ids = $ids === [] ? null : $ids;
		$result_data = '';

		if ($ids == 0) {
			$result_data = $this->Global_model->get_data_list(
				'tbl_store_segment_list', 'status >= 0', 999999999, 0, 'code, description, status', '', '', '', ''
			);
		} 
		else {
			$result_data = $this->Global_model->get_data_list(
				'tbl_store_segment_list', "id IN ($ids)", 999999999, 0, 'code, description, status', '', '', '', ''
			);
		}
		$currentDateTime = date('Y-m-d H:i:s');

		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

		$sheet->setCellValue('A1', 'Company Name: Lifestrong Marketing Inc.');
		$sheet->setCellValue('A2', 'Masterfile: Store Segment');
		$sheet->setCellValue('A3', 'Date Printed: '.$currentDateTime);
		$sheet->mergeCells('A1:C1');
		$sheet->mergeCells('A2:C2');
		$sheet->mergeCells('A3:C3');

		$rowNum = 6;
		foreach ($result_data as $row) {
			$headers = ['Segment Code', 'Segment Description', 'Status'];
			$sheet->fromArray($headers, null, 'A5');
			$sheet->getStyle('A5:E5')->getFont()->setBold(true);

			$sheet->setCellValueExplicit('A' . $rowNum, $row->code, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
			$sheet->setCellValueExplicit('B' . $rowNum, $row->description, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
			$sheet->setCellValueExplicit('C' . $rowNum, $row->status == 1 ? 'Active' : 'Inactive', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
			$rowNum+=1;
			
		}

		$title = 'Store Segment Masterfile_' . date('Ymd_His');

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header("Content-Disposition: attachment; filename=\"{$title}.xlsx\"");
		header('Cache-Control: max-age=0');

		$writer = new Xlsx($spreadsheet);
		$writer->save('php://output');
		exit;
	}

}
