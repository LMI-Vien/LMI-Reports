<?php

namespace App\Controllers\Cms;

use App\Controllers\BaseController;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class CustomerSellOutIndicator extends BaseController
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
			"title"         =>  "Customer Sell Out Indicator Masterfile",
			"description"   =>  "Customer Sell Out Indicator Masterfile",
			"keyword"       =>  ""
		);
		$data['title'] = "Customer Sell Out Indicator";
		$data['PageName'] = 'Customer Sell Out Indicator';
		$data['PageUrl'] = 'Customer Sell Out Indicator';
		$data['buttons'] = ['add', 'search', 'import', 'filter'];
		$data['content'] = "cms/customer_sellout_indicator/customer_sellout_indicator.php";
		$data['session'] = session(); //for frontend accessing the session data
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

    public function getMergedCustomers() {
		$query = 'status = 1';
		$limit = 0;

		$listLmi  = $this->Global_model->get_data_list('tbl_customer_lmi',  $query, $limit, 0, 'id, customer_code, customer_description', 'id', 'ASC', null, null);
		$listRgdi = $this->Global_model->get_data_list('tbl_customer_rgdi', $query, $limit, 0, 'id, customer_code, customer_description', 'id', 'ASC', null, null);

		$norm = function ($v) { $v = preg_replace('/\s+/', ' ', (string)$v); return strtolower(trim($v)); };

		$mergedByCodeDesc = [];   // key: norm(code)|norm(desc) → representative row (first-seen)
		$sourcesByDesc    = [];   // key: norm(desc) → set of sources (to decide "both")

		foreach ([['lmi',$listLmi], ['rgdi',$listRgdi]] as [$source, $list]) {
			foreach ((array)$list as $row) {
				$id   = (string)(is_object($row) ? $row->id : $row['id']);
				$code = trim(is_object($row) ? $row->customer_code : $row['customer_code']);
				$desc = trim(is_object($row) ? $row->customer_description : $row['customer_description']);

				$keyCodeDesc = $norm($code) . '|' . $norm($desc);
				$keyDesc     = $norm($desc);

				if (!isset($mergedByCodeDesc[$keyCodeDesc])) {
					$mergedByCodeDesc[$keyCodeDesc] = [
						'uid'                  => $source . '|' . $id, // first-seen wins for the rep row only
						'id'                   => $id,
						'customer_code'        => $code,
						'customer_description' => $desc,
						'source'               => $source,
					];
				}

				if (!isset($sourcesByDesc[$keyDesc])) $sourcesByDesc[$keyDesc] = [];
				$sourcesByDesc[$keyDesc][$source] = true;  // record that this desc appears in this source
			}
		}

		// Build output and derive source_label / is_merged from description presence across sources
		$out = [];
		foreach ($mergedByCodeDesc as $rep) {
			$descKey  = $norm($rep['customer_description']);
			$srcs     = array_keys($sourcesByDesc[$descKey] ?? []);
			$both     = count($srcs) > 1;

			$rep['source_label'] = $both ? 'both' : ($rep['source'] ?? '');
			$rep['is_merged']    = $both; // "merged across sources by description"

			$out[] = $rep;
		}

		usort($out, function($a, $b){
			$c = strcmp(strtolower($a['customer_code']), strtolower($b['customer_code']));
			return $c !== 0 ? $c : strcmp(strtolower($a['customer_description']), strtolower($b['customer_description']));
		});

		return $this->response->setJSON($out);
	}

}
