<?php

namespace App\Controllers\Cms;

use App\Controllers\BaseController;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class ImportTargetSellOutPa extends BaseController
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
		$data['content'] = "cms/import/ta-so-pa/target_sell_out_pa.php";
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

	public function view()
	{

		$uri = current_url(true);
		$data['uri'] =$uri;

		$data['meta'] = array(
			"title"         =>  "Import Target sell Out Per Account",
			"description"   =>  "Import Target sell Out Per Account",
			"keyword"       =>  ""
		);
		$data['title'] = "Import Target sell Out Per Account";
		$data['PageName'] = 'Import Target sell Out Per Account';
		$data['PageUrl'] = 'Import Target sell Out Per Account';
		$data['content'] = "cms/import/ta-so-pa/view_target_sell_out_pa.php";
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
		$year = $this->request->getPost('year') ?? '2024';
		$select = '';
		$select .= "a.payment_group, a.vendor, a.overall, a.kam_kas_kaa, a.sales_group, ";					// Group 1
		$select .= "a.terms, a.channel, a.brand, a.exclusivity, ";											// Group 2
		$select .= "a.category, a.lmi_code, a.rgdi_code, ";													// Group 3
		$select .= "a.customer_sku_code, a.item_description, a.item_status, a.srp, a.trade_discount,";		// Group 4
		$select .= "a.customer_cost, a.customer_cost_net_of_vat, ";											// Group 5
		$select .= "a.january_tq, a.february_tq, a.march_tq, a.april_tq, a.may_tq, a.june_tq, ";			// Group 6
		$select .= "a.july_tq, a.august_tq, a.september_tq, a.october_tq, a.november_tq, a.december_tq,";	// Group 6
		$select .= "a.january_ta, a.february_ta, a.march_ta, a.april_ta, a.may_ta, a.june_ta, ";			// Group 7
		$select .= "a.july_ta, a.august_ta, a.september_ta, a.october_ta, a.november_ta, a.december_ta";	// Group 7
		$result = $this->Global_model->get_data_list(
			'tbl_accounts_target_sellout_pa a', 
			"y.year = '$year'",
			999999999, 
			0, 
			$select,
			'', 
			'', 
			[
				[
					'table' => 'tbl_year y',
					'query' => 'y.id = a.year',
					'type' => 'left'
				]
			], 
			''
		);

		$spreadsheet = new Spreadsheet();
		$sheet       = $spreadsheet->getActiveSheet();

		$sheet->setCellValue('A1', 'Company Name: Lifestrong Marketing Inc.');
		$sheet->setCellValue('A2', 'Target Sell Out per Account');
		$sheet->setCellValue('A3', 'Date Printed: ' . (new \DateTime())->format('Y-m-d h:i A'));

		$header = [
			'Payment Group','Vendor','Overall','KAM/KAS/KAA','Sales Group',
			'Terms','Channel','Brand','Exclusivity',
			'Category','LMI Code','RGDI Code',
			'Customer SKU Code','Item Description','Item status','SRP','Trade Discount',
			'Customer Cost','Customer Cost (Net of Vat)',
			'January','February','March','April','May','June',
			'July','August','September','October','November','December',
			'JanuaryTA','FebruaryTA','MarchTA','AprilTA','MayTA','JuneTA',
			'JulyTA','AugustTA','SeptemberTA','OctoberTA','NovemberTA','DecemberTA'
		];
		$this->setHeaderCellValue($header, $sheet, 5);

		$currentRow = 6;

		foreach ($result as $value) {
			$header = [
				$value->payment_group, $value->vendor, $value->overall, $value->kam_kas_kaa, $value->sales_group,
				$value->terms, $value->channel, $value->brand, $value->exclusivity,
				$value->category,$value->lmi_code,$value->rgdi_code,
				$value->customer_sku_code,$value->item_description,$value->item_status,$value->srp,$value->trade_discount,
				$value->customer_cost,$value->customer_cost_net_of_vat,
				$value->january_tq,$value->february_tq,$value->march_tq,$value->april_tq,$value->may_tq,$value->june_tq,
				$value->july_tq,$value->august_tq,$value->september_tq,$value->october_tq,$value->november_tq,$value->december_tq,
				$value->january_ta,$value->february_ta,$value->march_ta,$value->april_ta,$value->may_ta,$value->june_ta,
				$value->july_ta,$value->august_ta,$value->september_ta,$value->october_ta,$value->november_ta,$value->december_ta
			];
			$this->setHeaderCellValue($header, $sheet, $currentRow);
			$currentRow++;
		}

		$title = "Target Sell Out per Account";
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header("Content-Disposition: attachment; filename=\"{$title}.xlsx\"");
		header('Cache-Control: max-age=0');

		$writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
		$writer->save('php://output');
		exit;
	}
	public function exportBatch() {
		$year = $this->request->getPost('year') ?? '2024';
		$select = '';
		$select .= "a.payment_group, a.vendor, a.overall, a.kam_kas_kaa, a.sales_group, ";					// Group 1
		$select .= "a.terms, a.channel, a.brand, a.exclusivity, ";											// Group 2
		$select .= "a.category, a.lmi_code, a.rgdi_code, ";													// Group 3
		$select .= "a.customer_sku_code, a.item_description, a.item_status, a.srp, a.trade_discount,";		// Group 4
		$select .= "a.customer_cost, a.customer_cost_net_of_vat, ";											// Group 5
		$select .= "a.january_tq, a.february_tq, a.march_tq, a.april_tq, a.may_tq, a.june_tq, ";			// Group 6
		$select .= "a.july_tq, a.august_tq, a.september_tq, a.october_tq, a.november_tq, a.december_tq,";	// Group 6
		$select .= "a.january_ta, a.february_ta, a.march_ta, a.april_ta, a.may_ta, a.june_ta, ";			// Group 7
		$select .= "a.july_ta, a.august_ta, a.september_ta, a.october_ta, a.november_ta, a.december_ta";	// Group 7
		$result = $this->Global_model->get_data_list(
			'tbl_accounts_target_sellout_pa a',
			"y.year = '$year'",
			999999999, 
			0, 
			$select,
			'', 
			'', 
			[
				[
					'table' => 'tbl_year y',
					'query' => 'y.id = a.year',
					'type' => 'left'
				]
			], 
			''
		);

		$spreadsheet = new Spreadsheet();
		$sheet       = $spreadsheet->getActiveSheet();

		$sheet->setCellValue('A1', 'Company Name: Lifestrong Marketing Inc.');
		$sheet->setCellValue('A2', 'Target Sell Out per Account');
		$sheet->setCellValue('A3', 'Date Printed: ' . (new \DateTime())->format('Y-m-d h:i A'));

		$header = [
			'Payment Group','Vendor','Overall','KAM/KAS/KAA','Sales Group',
			'Terms','Channel','Brand','Exclusivity',
			'Category','LMI Code','RGDI Code',
			'Customer SKU Code','Item Description','Item status','SRP','Trade Discount',
			'Customer Cost','Customer Cost (Net of Vat)',
			'January','February','March','April','May','June',
			'July','August','September','October','November','December',
			'JanuaryTA','FebruaryTA','MarchTA','AprilTA','MayTA','JuneTA',
			'JulyTA','AugustTA','SeptemberTA','OctoberTA','NovemberTA','DecemberTA'
		];
		$this->setHeaderCellValue($header, $sheet, 5);

		$currentRow = 6;

		foreach ($result as $value) {
			$header = [
				$value->payment_group, $value->vendor, $value->overall, $value->kam_kas_kaa, $value->sales_group,
				$value->terms, $value->channel, $value->brand, $value->exclusivity,
				$value->category,$value->lmi_code,$value->rgdi_code,
				$value->customer_sku_code,$value->item_description,$value->item_status,$value->srp,$value->trade_discount,
				$value->customer_cost,$value->customer_cost_net_of_vat,
				$value->january_tq,$value->february_tq,$value->march_tq,$value->april_tq,$value->may_tq,$value->june_tq,
				$value->july_tq,$value->august_tq,$value->september_tq,$value->october_tq,$value->november_tq,$value->december_tq,
				$value->january_ta,$value->february_ta,$value->march_ta,$value->april_ta,$value->may_ta,$value->june_ta,
				$value->july_ta,$value->august_ta,$value->september_ta,$value->october_ta,$value->november_ta,$value->december_ta
			];
			$this->setHeaderCellValue($header, $sheet, $currentRow);
			$currentRow++;
		}

		$title = "Target Sell Out per Account";
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header("Content-Disposition: attachment; filename=\"{$title}.xlsx\"");
		header('Cache-Control: max-age=0');

		$writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
		$writer->save('php://output');
		exit;
	}

	public function exportAll() {
		$select = '';
		$select .= "a.payment_group, a.vendor, a.overall, a.kam_kas_kaa, a.sales_group, ";					// Group 1
		$select .= "a.terms, a.channel, a.brand, a.exclusivity, ";											// Group 2
		$select .= "a.category, a.lmi_code, a.rgdi_code, ";													// Group 3
		$select .= "a.customer_sku_code, a.item_description, a.item_status, a.srp, a.trade_discount,";		// Group 4
		$select .= "a.customer_cost, a.customer_cost_net_of_vat, ";											// Group 5
		$select .= "a.january_tq, a.february_tq, a.march_tq, a.april_tq, a.may_tq, a.june_tq, ";			// Group 6
		$select .= "a.july_tq, a.august_tq, a.september_tq, a.october_tq, a.november_tq, a.december_tq,";	// Group 6
		$select .= "a.january_ta, a.february_ta, a.march_ta, a.april_ta, a.may_ta, a.june_ta, ";			// Group 7
		$select .= "a.july_ta, a.august_ta, a.september_ta, a.october_ta, a.november_ta, a.december_ta";	// Group 7
		$result = $this->Global_model->get_data_list(
			'tbl_accounts_target_sellout_pa a',
			"",
			999999999, 
			0, 
			$select,
			'', 
			'', 
			[
				[ 'table' => 'tbl_year y', 'query' => 'y.id = a.year', 'type' => 'left' ]
			], 
			''
		);

		$spreadsheet = new Spreadsheet();
		$sheet       = $spreadsheet->getActiveSheet();

		$sheet->setCellValue('A1', 'Company Name: Lifestrong Marketing Inc.');
		$sheet->setCellValue('A2', 'Target Sell Out per Account');
		$sheet->setCellValue('A3', 'Date Printed: ' . (new \DateTime())->format('Y-m-d h:i A'));

		$header = [
			'Payment Group','Vendor','Overall','KAM/KAS/KAA','Sales Group',
			'Terms','Channel','Brand','Exclusivity',
			'Category','LMI Code','RGDI Code',
			'Customer SKU Code','Item Description','Item status','SRP','Trade Discount',
			'Customer Cost','Customer Cost (Net of Vat)',
			'January','February','March','April','May','June',
			'July','August','September','October','November','December',
			'JanuaryTA','FebruaryTA','MarchTA','AprilTA','MayTA','JuneTA',
			'JulyTA','AugustTA','SeptemberTA','OctoberTA','NovemberTA','DecemberTA'
		];
		$this->setHeaderCellValue($header, $sheet, 5);

		$currentRow = 6;

		foreach ($result as $value) {
			$header = [
				$value->payment_group, $value->vendor, $value->overall, $value->kam_kas_kaa, $value->sales_group,
				$value->terms, $value->channel, $value->brand, $value->exclusivity,
				$value->category,$value->lmi_code,$value->rgdi_code,
				$value->customer_sku_code,$value->item_description,$value->item_status,$value->srp,$value->trade_discount,
				$value->customer_cost,$value->customer_cost_net_of_vat,
				$value->january_tq,$value->february_tq,$value->march_tq,$value->april_tq,$value->may_tq,$value->june_tq,
				$value->july_tq,$value->august_tq,$value->september_tq,$value->october_tq,$value->november_tq,$value->december_tq,
				$value->january_ta,$value->february_ta,$value->march_ta,$value->april_ta,$value->may_ta,$value->june_ta,
				$value->july_ta,$value->august_ta,$value->september_ta,$value->october_ta,$value->november_ta,$value->december_ta
			];
			$this->setHeaderCellValue($header, $sheet, $currentRow);
			$currentRow++;
		}

		$title = "Target Sell Out per Account";
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header("Content-Disposition: attachment; filename=\"{$title}.xlsx\"");
		header('Cache-Control: max-age=0');

		$writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
		$writer->save('php://output');
		exit;
	}
}
