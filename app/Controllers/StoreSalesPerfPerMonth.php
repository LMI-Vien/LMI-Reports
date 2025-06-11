<?php

namespace App\Controllers;

use Config\Database;
use TCPDF;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class StoreSalesPerfPerMonth extends BaseController
{
    protected $session;
    public function __construct()
	{
	    $this->session = session();
	    if (!$this->session->get('sess_site_uid')) {
	        redirect()->to(base_url('login'))->send();
	        exit;
	    }
	}

	public function perfPerMonth()
	{
		$uri = current_url(true);
		$data['uri'] = $uri;
		$data['meta'] = array(
			"title"         =>  "LMI Portal",
			"description"   =>  "LMI Portal Wep application",
			"keyword"       =>  ""
		);
		$data['title'] = "Trade Dashboard";
		$data['PageName'] = 'Trade Dashboard';
		$data['PageUrl'] = 'Trade Dashboard';
		$data["breadcrumb"] = array('Store' => base_url('store/sales-performance-per-month'),'Store Sales Performance per Month' => '');
		$data["source"] = "Actual Sales Report, Scan Data, and Target Sales";
		$data["source_date"] = 'Latest Year';	
		$data["foot_note"] = 'With BA = Actual Sales, Without BA = Scanned Data';	

		$data['content'] = "site/store/perf-per-month/sales_performance_per_month";
		$data['brand_ambassadors'] = $this->Global_model->getBrandAmbassador(0);
		$data['store_branches'] = $this->Global_model->getStoreBranchById(0);
		$data['brands'] = $this->Global_model->getBrandData("ASC", 99999, 0);
		$data['asc'] = $this->Global_model->getAsc(0);
		$data['areas'] = $this->Global_model->getArea(0);
		$data['brandLabel'] = $this->Global_model->getBrandLabelData(0);
		$data['session'] = session();
		$data['js'] = array(
			"assets/site/bundle/js/bundle.min.js",
			"assets/site/js/chart.min.js"
                    );
        $data['css'] = array(
        	"assets/site/bundle/css/bundle.min.css"
                    );
		return view("site/layout/template", $data);
	}


	public function getPerfPerMonth()
	{	
		$areaId = $this->request->getPost('area');
		$areaId = $areaId === '' ? null : $areaId;
		$ascId = $this->request->getPost('asc');
		$ascId = $ascId === '' ? null : $ascId;
		$baTypeId = $this->request->getPost('baType');
		$baTypeId = $baTypeId === '' ? null : $baTypeId;
		$baId = $this->request->getPost('ba');
		$baId = $baId === '' ? null : $baId;
		$storeId= $this->request->getPost('store');
		$storeId = $storeId === '' ? null : $storeId;
        $brandsIds = $this->request->getPost('brands');
        $brandsIds = $brandsIds === '' ? null : $brandsIds;
        $brandCategoriesIds = $this->request->getPost('brandCategories');
        $brandCategoriesIds = $brandCategoriesIds === '' ? null : $brandCategoriesIds;
        $sysPar = $this->Global_model->getSysPar();
		$years = $this->Global_model->getYears(); 

		$year_values = array_column($years, 'year'); 
		$year_id = array_column($years, 'id'); 
		$latest_year = max($year_values);
		$latest_year_id = max($year_id);
		// $storeId = null;
		// $storeCode = null;
		// $areaId = null;
		// $ascId = null;
		// $brands = null;
		//$brandsIds = [37];
		//$baId = null;
		//$baType = strval(3);
		//$brandCategoriesIds = null;
		//$baCode = null;
	    $incentiveRate = 0.015;
	    $amountPerDay = 8000;
	    $noOfDays = 0;
		if($sysPar){
			$jsonString = $sysPar[0]['brand_label_type'];
			$data = json_decode($jsonString, true);
		    $amountPerDay = $sysPar[0]['tba_amount_per_ba'];
		    $noOfDays = $sysPar[0]['tba_num_days'];
		    $target_sales = $amountPerDay * $noOfDays;
		}
		$target_sales = $amountPerDay * $noOfDays;
		// $baId = 10;
		// $storeId = 1;
		$baCode = null;

		if($baId){
			if($baId == -5 || $baId == -6){
				$baCode = null;	
			}else{
				$baCode = $this->Global_model->get_by_id('tbl_brand_ambassador', $baId);
				$baCode = $baCode[0]->code;
			}
		}
		$storeCode = null;
		if($storeId){
			$storeCode = $this->Global_model->get_by_id('tbl_store', $storeId);
			$storeCode = $storeCode[0]->code;
		}
		//print_r($baTypeId);
		//die(); 	
		// $baTypeId = '3';
		// $areaId = '5';
		// $storeId = '18';
		// $storeCode = '1878';
		// $ascId = null;
		// $brands = null;
		// $brandsIds = null;
		// $baCode = null;
		// $baId = null;
		$brandCategoriesIds = null;
		if($latest_year){

		    $filters = [
			    'year' => $latest_year, 
			    'asc_id' => $ascId,    
			    'store_id' => $storeId,
			    'store_code' => $storeCode,
			    'area_id' => $areaId,
			    'ba_id' => $baId,
			    'brand_ids' => $brandsIds,
			    'brand_type_ids' => $brandCategoriesIds,
			    'ba_code' => $baCode,
			    'year_val' => $latest_year_id,
			    'ba_type' => $baTypeId,
			    'default_target' => $amountPerDay
			];
			// echo "<pre>";
			// print_r($filters);
			// die();
		    $data = $this->Dashboard_model->tradeOverallBaDataASC($filters);

		    return $this->response->setJSON([
		        'data' => $data['data']
		    ]);
		}
	}

	public function generatePdf()
	{	
	    $sort_field = $this->request->getGet('sort_field');
	    $sort = $this->request->getGet('sort');
	    $brand = $this->request->getGet('brand');
	    $brand_ambassador = $this->request->getGet('brand_ambassador');
	    $store_name = $this->request->getGet('store_name');
	    $ba_type = $this->request->getGet('ba_type');
	    $type = $this->request->getGet('type');
	    $asc_name = $this->request->getGet('asc_name');
	    $batchSize = 10000; //  10,000 data per batch
	    $offset = 0;
	    $out_con = 'ALL';
	    $latest_vmi_data = $this->Dashboard_model->getLatestVmi();
	    
	    if ($latest_vmi_data) {
	        $latest_year = $latest_vmi_data['year_id'];
	        $latest_month = $latest_vmi_data['month_id'];
	        $latest_week = $latest_vmi_data['week_id'];

	        $brand_ambassador = $brand_ambassador ?: null;
	        $brand = $brand ?: null;
	        $store_name = $store_name ?: null;
	        $out_con = $ba_type ?: "ALL";
	        $asc_name = ($asc_name && $asc_name !== 'Please Select Brand Ambassador') ? $asc_name : "";

	        $title = 'BA_Dashboard_Report';
	        
	        $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
	        $pdf->SetCreator('LMI SFA');
	        $pdf->SetAuthor('LIFESTRONG MARKETING INC.');
	        $pdf->SetTitle('BA Dashboard Report');
	        $pdf->setPrintHeader(false);
	        $pdf->setPrintFooter(false);
	        $pdf->AddPage();
	        
	        $pdf->SetFont('helvetica', '', 12);
	        $pdf->Cell(0, 10, 'LIFESTRONG MARKETING INC.', 0, 1, 'C');
	        $pdf->SetFont('helvetica', '', 10);
	        $pdf->Cell(0, 5, 'Report: BA Dashboard', 0, 1, 'C');
	        $pdf->Ln(5);

	        $pdf->SetFont('helvetica', '', 9);
	        $pdf->Cell(63, 6, 'Brand Ambassador: ' . ($brand_ambassador ?: 'ALL'), 0, 0, 'L');
	        $pdf->Cell(63, 6, 'Brand: ' . ($brand ?: 'ALL'), 0, 0, 'L');
	        $pdf->Cell(63, 6, 'Outright/Consignment: ' . ($out_con ?: 'ALL'), 0, 1, 'L');
	        
	        $pdf->Cell(63, 6, 'Store Name: ' . ($store_name ?: 'ALL'), 0, 0, 'L');
	        $pdf->Cell(63, 6, 'Area / ASC Name: ' . ($asc_name ?: ''), 0, 0, 'L');
	        $pdf->Cell(63, 6, 'Date Generated: ' . date('M d, Y, h:i:s A'), 0, 1, 'L');
	        
	        $pdf->Ln(2);
	        $pdf->Cell(0, 0, '', 'T');
	        $pdf->Ln(4);

	        $pdf->SetFont('helvetica', 'B', 10);
	        $pdf->Cell(110, 6, 'Item Name', 1, 0, 'C');
	        $pdf->Cell(15, 6, 'Quantity', 1, 0, 'C');
	        $pdf->Cell(20, 6, 'LMI Code', 1, 0, 'C');
	        $pdf->Cell(20, 6, 'RGDI Code', 1, 0, 'C');
	        $pdf->Cell(25, 6, 'Type of SKU', 1, 1, 'C');

	        $pdf->SetFont('helvetica', '', 10);

	        do {
	            switch ($type) {
	                case 'slowMoving':
	                    $data = $this->Dashboard_model->tradeInfoBa($brand, $brand_ambassador, $store_name, $ba_type, $sort_field, $sort, $batchSize, $offset, 20, 30, $latest_week, $latest_month, $latest_year);
	                    $title = 'BA_Dashboard_Report_Slow_Moving';
	                    break;
	                case 'overStock':
	                    $data = $this->Dashboard_model->tradeInfoBa($brand, $brand_ambassador, $store_name, $ba_type, $sort_field, $sort, $batchSize, $offset, 30, null, $latest_week, $latest_month, $latest_year);
	                    $title = 'BA_Dashboard_Report_Overstock';
	                    break;
	                case 'npd':
	                    $item_class_filter = ['N-New Item'];
	                    $data = $this->Dashboard_model->getItemClassNPDHEROData($brand, $brand_ambassador, $store_name, $ba_type, $sort_field, $sort, $batchSize, $offset, $latest_week, $latest_month, $latest_year, $item_class_filter);
	                    $title = 'BA_Dashboard_Report_NPD';
	                    break;
	                case 'hero':
	                    $item_class_filter = ['A-Top 500 Pharma/Beauty', 'BU-Top 300 of 65% cum sales net of Class A Pharma/Beauty', 'B-Remaining Class B net of BU Pharma/Beauty'];
	                    $data = $this->Dashboard_model->getItemClassNPDHEROData($brand, $brand_ambassador, $store_name, $ba_type, $sort_field, $sort, $batchSize, $offset, $latest_week, $latest_month, $latest_year, $item_class_filter);
	                    $title = 'BA_Dashboard_Report_HERO';
	                    break;
	                default:
	                    $data = $this->Dashboard_model->tradeInfoBa($brand, $brand_ambassador, $store_name, $ba_type, $sort_field, $sort, $batchSize, $offset, 20, 30, $latest_week, $latest_month, $latest_year);
	                    $title = 'BA_Dashboard_Report_Slow_Moving';
	            }

	            if ($data) {
	                foreach ($data['data'] as $row) {
	                    $pdf->Cell(110, 6, $row->item_name, 1, 0, 'L');
	                    $pdf->Cell(15, 6, $row->sum_total_qty, 1, 0, 'C');
	                    $pdf->Cell(20, 6, $row->lmi_itmcde, 1, 0, 'C');
	                    $pdf->Cell(20, 6, $row->rgdi_itmcde, 1, 0, 'C');
	                    $pdf->Cell(25, 6, $type, 1, 1, 'C');
	                }
	            }

	            $offset += $batchSize;

	            // Free memory
	            unset($data);
	            gc_collect_cycles(); 
	        } while (!empty($data['data']));

	        $pdf->Output($title . '.pdf', 'D');
	        exit;
	    }
	}


	public function generateExcel()
	{
	    $sort_field = $this->request->getGet('sort_field');
	    $sort = $this->request->getGet('sort');
	    $brand = $this->request->getGet('brand') ?: null;
	    $brand_ambassador = $this->request->getGet('brand_ambassador') ?: null;
	    $store_name = $this->request->getGet('store_name') ?: null;
	    $ba_type = $this->request->getGet('ba_type') ?: null;
	    $type = $this->request->getGet('type');
	    $asc_name = $this->request->getGet('asc_name');
	    $out_con = $ba_type ? 'ALL' : 'ALL';

	    $latest_vmi_data = $this->Dashboard_model->getLatestVmi();
	    if (!$latest_vmi_data) {
	        return;
	    }

	    $latest_year = $latest_vmi_data['year_id'];
	    $latest_month = $latest_vmi_data['month_id'];
	    $latest_week = $latest_vmi_data['week_id'];

	    $asc_name = ($asc_name === 'Please Select Brand Ambassador') ? "" : $asc_name;

	    $title = 'BA_Dashboard_Report';
	    switch ($type) {
	        case 'slowMoving':
	            $title .= '_Slow_Moving';
	            break;
	        case 'overStock':
	            $title .= '_Overstock';
	            break;
	        case 'npd':
	            $title .= '_NPD';
	            break;
	        case 'hero':
	            $title .= '_HERO';
	            break;
	    }

	    $spreadsheet = new Spreadsheet();
	    $sheet = $spreadsheet->getActiveSheet();

	    $sheet->setCellValue('A1', 'LIFESTRONG MARKETING INC.');
	    $sheet->setCellValue('A2', 'Report: BA Dashboard');
	    $sheet->mergeCells('A1:E1');
	    $sheet->mergeCells('A2:E2');

	    $sheet->setCellValue('A4', 'Brand Ambassador: ' . ($brand_ambassador ?: 'ALL'));
	    $sheet->setCellValue('B4', 'Brand: ' . ($brand ?: 'ALL'));
	    $sheet->setCellValue('C4', 'Outright/Consignment: ' . ($out_con ?: 'ALL'));

	    $sheet->setCellValue('A5', 'Store Name: ' . ($store_name ?: 'ALL'));
	    $sheet->setCellValue('B5', 'Area / ASC Name: ' . ($asc_name ?: ''));
	    $sheet->setCellValue('C5', 'Date Generated: ' . date('M d, Y, h:i:s A'));

	    $headers = ['Item Name', 'Quantity', 'LMI Code', 'RGDI Code', 'Type of SKU'];
	    $sheet->fromArray($headers, null, 'A7');
	    $sheet->getStyle('A7:E7')->getFont()->setBold(true);

	    $rowNum = 8;
	    $batchSize = 5000;
	    $offset = 0;
	    do {
	        $data = $this->Dashboard_model->tradeInfoBa(
	            $brand, $brand_ambassador, $store_name, $ba_type, $sort_field, $sort,
	            $batchSize, $offset, 20, 30, $latest_week, $latest_month, $latest_year
	        );

	        if (!$data || empty($data['data'])) {
	            break;
	        }

	        foreach ($data['data'] as $row) {
	            $sheet->setCellValueExplicit('A' . $rowNum, $row->item_name, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
	            $sheet->setCellValueExplicit('B' . $rowNum, $row->sum_total_qty, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC);
	            $sheet->setCellValueExplicit('C' . $rowNum, $row->lmi_itmcde, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
	            $sheet->setCellValueExplicit('D' . $rowNum, $row->rgdi_itmcde, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
	            $sheet->setCellValueExplicit('E' . $rowNum, $type, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
	            $rowNum++;
	        }

	        $offset += $batchSize;
	    } while (count($data['data']) === $batchSize);

	    foreach (range('A', 'E') as $columnID) {
	        $sheet->getColumnDimension($columnID)->setAutoSize(true);
	    }

	    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	    header("Content-Disposition: attachment; filename=\"{$title}.xlsx\"");
	    header('Cache-Control: max-age=0');

	    $writer = new Xlsx($spreadsheet);
	    $writer->save('php://output');
	    exit;
	}
}
