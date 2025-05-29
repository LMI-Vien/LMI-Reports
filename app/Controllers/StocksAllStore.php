<?php

namespace App\Controllers;

use Config\Database;
use TCPDF;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class StocksAllStore extends BaseController
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

	public function dataAllStore()
	{	
		$data['meta'] = array(
			"title"         =>  "LMI Portal",
			"description"   =>  "LMI Portal Wep application",
			"keyword"       =>  ""
		);
	    $latestVmiData = $this->Dashboard_model->getLatestVmi();
	    $latestWeek = '';
	    $latestYear = '';
	    $sourceDate = 'N / A';
	    if($latestVmiData){
	    	$latestYear = $latestVmiData['year'];
	    	$latestWeek = $latestVmiData['week_id'];
	    	$sourceDate = $latestVmiData['year'] . ' Calendar Week '. $latestWeek;
		}
		$data['month'] = $this->Global_model->getMonths();
		$data['week'] = $this->Global_model->getWeeks();
		$data['itemClassi'] = $this->Global_model->getItemClassification();
		$data['title'] = "Trade Dashboard";
		$data['PageUrl'] = 'Trade Dashboard';
		$siteMenuData = $this->Global_model->get_by_menu_url('stocks/data-all-store');
		if($siteMenuData){
			$data["breadcrumb"] = array('Stocks' => base_url('stocks/data-all-store'), $siteMenuData[0]->menu_name => '');
			$data["source"] = "VMI (LMI/RGDI)";
			$data["source_date"] = '<span id="sourceDate">N / A</span>';
			$data["date"] = $sourceDate;	
			$data["pageName"] = $siteMenuData[0]->menu_name;			
		}else{
			$data["breadcrumb"] = array('Stocks' => base_url('stocks/data-all-store'),'Overall Stock Data of all Stores' => '');
			$data["source"] = "VMI (LMI/RGDI)";
			$data["source_date"] = '<span id="sourceDate">N / A</span>';
			$data["date"] = $sourceDate;	
			$data["pageName"] = '';			
		}

		$data['content'] = "site/stocks/all-store/data_all_store";
		$data['asc'] = $this->Global_model->getAsc(0);
		$data['area'] = $this->Global_model->getArea(0);
		$data['brand'] = $this->Global_model->getBrandData("ASC", 99999, 0);
		$data['store_branch'] = $this->Global_model->getStoreBranch(0);
		$data['brandAmbassador'] = $this->Global_model->getBrandAmbassador(0);
		$data['company'] = $this->Global_model->getCompanies(0);
		$data['brandLabel'] = $this->Global_model->getBrandLabelData(0);
		$data['session'] = session();
		$data['js'] = array(
			"assets/site/bundle/js/bundle.min.js"
                    );
        $data['css'] = array(
        	"assets/site/bundle/css/bundle.min.css"
                    );
		return view("site/layout/template", $data);
	}

	public function getDataAllStore()
	{	
		$areaId = null;
		$ascId = null;
		$baTypeId = null;
		$baId = null;
		$storeId = null;
		$brandIds = null;

		$ItemClassIds = $this->request->getPost('itemClass');
		$ItemClassIds = $ItemClassIds === '' ? null : $ItemClassIds;

		$itemCatId = trim($this->request->getPost('itemCategory') ?? '');
		$itemCatId = $itemCatId === '' ? null : $itemCatId;

		$companyId = trim($this->request->getPost('company') ?? '');
		$companyId = $companyId === '' ? null : $companyId;

		$type = $this->request->getPost('type');
		$type = $type === '' ? null : $type;

		$limit = $this->request->getVar('limit');
		$offset = $this->request->getVar('offset');
		$limit = is_numeric($limit) ? (int)$limit : 10;
		$offset = is_numeric($offset) ? (int)$offset : 0;

		$latestVmiData = $this->Dashboard_model->getLatestVmi();
		$sysPar = $this->Global_model->getSysPar();
		$npdSku = [];
		$heroSku = [];
		$skuMin = 20;
		$skuMin = 30;
		if($sysPar){
			$jsonStringHero = $sysPar[0]['hero_sku'];
			$dataHero = json_decode($jsonStringHero, true);
			$heroSku = array_map(fn($item) => $item['item_class_description'], $dataHero);
			$jsonStringNpd = $sysPar[0]['new_item_sku'];
			$dataNpd = json_decode($jsonStringNpd, true);
			$npdSku = array_map(fn($item) => $item['item_class_description'], $dataNpd);
		    $skuMin = $sysPar[0]['sm_sku_min'];
		    $skuMax = $sysPar[0]['sm_sku_max'];
		}

	    if($latestVmiData){
	    	$latestYear = $latestVmiData['year_id'];
	    	$latestWeek = $latestVmiData['week_id'];
	    	//temp
		    //$type = 'npd';
		    // $areaId = null;
		    // $ascId = null;
		    // $baTypeId = 3;
		    // $baId = null;
		    // $storeId = '1001';
		    // $brandIds = null;
		    // $limit = 10;
		    // $offset = 0;
		    //$companyId = 3;
		    //$ItemClassIds = ['C-Class C - Others', 'N-New Item'];
		    //$itemCatId = 9;
		    switch ($type) {
		        case 'slowMoving':
		            $data = $this->Dashboard_model->dataPerStore($limit, $offset, $skuMin, $skuMax, $latestWeek, $latestYear, $brandIds, $baId, $baTypeId, $areaId, $ascId, $storeId, $companyId, $ItemClassIds, $itemCatId);
		            break;
		        case 'overStock':
		            $data = $this->Dashboard_model->dataPerStore($limit, $offset, $skuMax, null, $latestWeek, $latestYear, $brandIds, $baId, $baTypeId, $areaId, $ascId, $storeId, $companyId, $ItemClassIds, $itemCatId);
		            break;
		        case 'npd':
					$itemClassFilter = $npdSku;
		           $data = $this->Dashboard_model->getItemClassNPDHEROData($limit, $offset, $latestWeek, $latestYear, $brandIds, $baId, $baTypeId, $areaId, $ascId, $storeId, $itemClassFilter, $companyId, $ItemClassIds, $itemCatId);
		            break;
		        case 'hero':
        			$itemClassFilter = $heroSku;
		            $data = $this->Dashboard_model->getItemClassNPDHEROData($limit, $offset, $latestWeek, $latestYear, $brandIds, $baId, $baTypeId, $areaId, $ascId, $storeId, $itemClassFilter, $companyId, $ItemClassIds, $itemCatId);
		            break;
		        default:
		        	$data = $this->Dashboard_model->dataPerStore($limit, $offset, $skuMin, $skuMax, $latestWeek, $latestYear, $brandIds, $baId, $baTypeId, $areaId, $ascId, $storeId, $companyId, $ItemClassIds, $itemCatId);
		    }

		    return $this->response->setJSON([
		        'draw' => intval($this->request->getVar('draw')),
		        'recordsTotal' => $data['total_records'],
		        'recordsFiltered' => $data['total_records'],
		        'data' => $data['data'],
		    ]);	
			
	    }else{
			return $this->response->setJSON([
		        'draw' => intval($this->request->getVar('draw')),
		        'recordsTotal' => 0,
		        'recordsFiltered' => 0,
		        'data' => [],
		    ]);	
	    }
	}

}
