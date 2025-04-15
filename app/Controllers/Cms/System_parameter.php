<?php

namespace App\Controllers\Cms;

use App\Controllers\BaseController;

class System_parameter extends BaseController
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
			"title"         =>  "System Parameter",
			"description"   =>  "System Parameter",
			"keyword"       =>  ""
		);
		$data['title'] = "System Parameter";
		$data['PageName'] = 'System Parameter';
		$data['PageUrl'] = 'System Parameter';
		$data['buttons'] = [];
		$data['content'] = "cms/maintenance/system_parameter/system_parameter.php";
		$data['session'] = session();
		$data['hero'] = $this->Global_model->dynamic_search("'tbl_item_class'", "''", "'*'", 0, 0, "''", "''", "''");
		$data['newItem'] = $this->Global_model->dynamic_search("'tbl_item_class'", "''", "'*'", 0, 0, "''", "''", "''");
		$data['brandExcluded'] = $this->Global_model->dynamic_search("'tbl_brand'", "''", "'*'", 0, 0, "''", "''", "''");
		$data['brandIncluded'] = $this->Global_model->dynamic_search("'tbl_brand'", "''", "'*'", 0, 0, "''", "''", "''");

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

}
