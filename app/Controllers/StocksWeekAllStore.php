<?php

namespace App\Controllers;

use Config\Database;
use TCPDF;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class StocksWeekAllStore extends BaseController
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

	public function dataWeekAllStore()
	{
		$data['meta'] = array(
			"title"         =>  "LMI Portal",
			"description"   =>  "LMI Portal Wep application",
			"keyword"       =>  ""
		);

		$data['title'] = "Trade Dashboard";
		$data['PageName'] = 'Trade Dashboard';
		$data['PageUrl'] = 'Trade Dashboard';
		$data["breadcrumb"] = array('Stocks' => base_url('stocks/data-week-all-store'),'Week by Week Stock Data of all Stores' => '');
		$data["source"] = '<span id="sourceDate">VMI/WEEK on Week Sales N / A</span>';
		$data['content'] = "site/stocks/week-all-store/data_week_all_store";
		$data['brandLabel'] = $this->Global_model->getBrandLabelData(0);
		$data['itemClassi'] = $this->Global_model->getItemClassification();
		$data['year'] = $this->Global_model->getYears();
		$data['session'] = session();
		$data['js'] = array(
			"assets/site/bundle/js/bundle.min.js"
                    );
        $data['css'] = array(
        	"assets/site/bundle/css/bundle.min.css"
                    );
		return view("site/layout/template", $data);
	}

	public function getDataWeekAllStore()
	{	
		$ItemClasses = $this->request->getPost('itemClass');
		$ItemClasses = $ItemClasses === '' ? null : $ItemClasses;

		$itemCatId = trim($this->request->getPost('itemCategory') ?? '');
		$itemCatId = $itemCatId === '' ? null : $itemCatId;

		$weekStart = trim($this->request->getPost('weekFrom') ?? '');
		$weekStart = $weekStart === '' ? null : $weekStart;

		$weekEnd = trim($this->request->getPost('weekTo') ?? '');
		$weekEnd = $weekEnd === '' ? null : $weekEnd;

		$latestYear = trim($this->request->getPost('year') ?? '');
		$latestYear = $latestYear === '' ? null : $latestYear;

		$source = trim($this->request->getPost('source') ?? '');
		$source = $source === '' ? null : $source;

		$type = $this->request->getPost('type');
		$type = $type === '' ? null : $type;

		$limit = $this->request->getVar('limit');
		$offset = $this->request->getVar('offset');
		$limit = is_numeric($limit) ? (int)$limit : 10;
		$offset = is_numeric($offset) ? (int)$offset : 0;

		$orderColumnIndex = $this->request->getVar('order')[0]['column'] ?? 0;
	    $orderDirection = $this->request->getVar('order')[0]['dir'] ?? 'desc';
	    $columns = $this->request->getVar('columns');
	    $orderByColumn = $columns[$orderColumnIndex]['data'] ?? 'item_name';

		$sysPar = $this->Global_model->getSysPar();
		$npdSku = [];
		$heroSku = [];
		$skuMin = 20;
		$skuMin = 30;
	    $ItemClasses = null;
	    $itemCatId = null;

		if($sysPar){
			$jsonStringHero = $sysPar[0]['hero_sku'];
			$dataHero = json_decode($jsonStringHero, true);
			$heroSku = array_map(fn($item) => $item['item_class_description'], $dataHero);
			$jsonStringNpd = $sysPar[0]['new_item_sku'];
			$dataNpd = json_decode($jsonStringNpd, true);
			$npdSku = array_map(fn($item) => $item['item_class_description'], $dataNpd);
		    $skuMin = $sysPar[0]['sm_sku_min'];
		    $skuMax = $sysPar[0]['sm_sku_max'];
		    $skuMin = 1;
		}
			$orderDirection = strtoupper($orderDirection);
			if(intval($source) === 3){
			    switch ($type) {
			        case 'slowMoving':
			            $data = $this->Dashboard_model->getDataWeekAllStore($limit, $offset, $orderByColumn, $orderDirection, $skuMin, $skuMax, $weekStart, $weekEnd, $latestYear, $ItemClasses, $itemCatId);
			            break;
			        case 'overStock':
			            $data = $this->Dashboard_model->getDataWeekAllStore($limit, $offset, $orderByColumn, $orderDirection, $skuMax, null, $weekStart, $weekEnd, $latestYear, $ItemClasses, $itemCatId);
			            break;
			        case 'npd':
						$itemClassFilter = $npdSku;
			           $data = $this->Dashboard_model->getDataWeekAllNPDHERO($limit, $offset, $orderByColumn, $orderDirection, $weekStart, $weekEnd, $latestYear, $itemClassFilter, $ItemClasses, $itemCatId);
			            break;
			        case 'hero':
	        			$itemClassFilter = $heroSku;
			            $data = $this->Dashboard_model->getDataWeekAllNPDHERO($limit, $offset, $orderByColumn, $orderDirection, $weekStart, $weekEnd, $latestYear, $itemClassFilter, $ItemClasses, $itemCatId);
			            break;
			        default:
			        	$data = $this->Dashboard_model->getDataWeekAllStore($limit, $offset, $orderByColumn, $orderDirection, $skuMin, $skuMax, $weekStart, $weekEnd, $latestYear, $ItemClasses, $itemCatId);
			    }
			}else{
			    switch ($type) {
			        case 'slowMoving':
			            $data = $this->Dashboard_model->getDataVmiAllStore($limit, $offset, $orderByColumn, $orderDirection, $skuMin, $skuMax, $weekStart, $weekEnd, $latestYear, $ItemClasses, $itemCatId);
			            break;
			        case 'overStock':
			            $data = $this->Dashboard_model->getDataVmiAllStore($limit, $offset, $orderByColumn, $orderDirection, $skuMax, null, $weekStart, $weekEnd, $latestYear, $ItemClasses, $itemCatId);
			            break;
			        case 'npd':
						$itemClassFilter = $npdSku;
			           $data = $this->Dashboard_model->getDataVmiNPDHERO($limit, $offset, $orderByColumn, $orderDirection, $weekStart, $weekEnd, $latestYear, $itemClassFilter, $ItemClasses, $itemCatId);
			            break;
			        case 'hero':
	        			$itemClassFilter = $heroSku;
			            $data = $this->Dashboard_model->getDataVmiNPDHERO($limit, $offset, $orderByColumn, $orderDirection, $weekStart, $weekEnd, $latestYear, $itemClassFilter, $ItemClasses, $itemCatId);
			            break;
			        default:
			        	$data = $this->Dashboard_model->getDataVmiAllStore($limit, $offset, $orderByColumn, $orderDirection, $skuMin, $skuMax, $weekStart, $weekEnd, $latestYear, $ItemClasses, $itemCatId);
			    }
			}


		    return $this->response->setJSON([
		        'draw' => intval($this->request->getVar('draw')),
		        'recordsTotal' => $data['total_records'],
		        'recordsFiltered' => $data['total_records'],
		        'data' => $data['data'],
		    ]);	
	}

}
