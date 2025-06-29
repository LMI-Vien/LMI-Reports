<?php

namespace App\Controllers\Cms;

use App\Controllers\BaseController;

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

}
