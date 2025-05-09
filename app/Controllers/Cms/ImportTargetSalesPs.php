<?php

namespace App\Controllers\Cms;

use App\Controllers\BaseController;

class ImportTargetSalesPs extends BaseController
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
			"title"         =>  "Import Target Sales Per Store",
			"description"   =>  "Import Target Sales Per Store",
			"keyword"       =>  ""
		);
		$data['title'] = "Import Target Sales Per Store";
		$data['PageName'] = 'Import Target Sales Per Store';
		$data['PageUrl'] = 'Import Target Sales Per Store';
		$data['content'] = "cms/import/ta-so-ps/target_sales_ps.php";
		$data['buttons'] = ['search', 'import', 'export'];
		$data['session'] = session(); //for frontend accessing the session data
		$data['standard'] = config('Standard');
		$data['yearMap'] = $this->Global_model->dynamic_search("'tbl_year'", "''", "'id, year'", 0, 0, "''", "''", "''");

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
			"title"         =>  "Import Target Sales Per Store",
			"description"   =>  "Import Target Sales Per Store",
			"keyword"       =>  ""
		);


		$year = $uri->getSegment(4);
		if(intval($year)){
			$query = "h.id >= 1 and reference_year = ".$year;
		}else{
			$query = "h.id >= 1";
		}

		$select = "h.id, h.remarks, h.action, h.action_date, h.approver_id, u.name";
		$join = [
		    [
		        'table' => 'cms_users u',
		        'query' => 'u.id = h.approver_id',
		        'type' => 'left'
		    ]
		];
		$approval_history = $this->Global_model->get_data_list("tbl_target_sales_per_store_approval_history h", $query, 999,0, $select, "action_date", "desc", $join, null);
		$data['approval_history'] = $approval_history;
		$data['title'] = "Import Target Sales Per Store";
		$data['PageName'] = 'Import Target Sales Per Store';
		$data['PageUrl'] = 'Import Target Sales Per Store';
		$data['content'] = "cms/import/ta-so-ps/view_target_sales_ps.php";
		$data['yearMap'] = $this->Global_model->dynamic_search("'tbl_year'", "''", "'id, year'", 0, 0, "''", "''", "''");


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

}
