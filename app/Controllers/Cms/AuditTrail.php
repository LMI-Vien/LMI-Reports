<?php

namespace App\Controllers\Cms;

use App\Controllers\BaseController;

class AuditTrail extends BaseController
{
    public function index() {

		$data['meta'] = array(
			"title"         =>  "Audit Trail",
			"description"   =>  "Audit Trail",
			"keyword"       =>  ""
		);
		$data['title'] = "CMS";
		$data['PageName'] = "Audit Trail";
		$data['content'] = "cms/audit_trail/list";
		$data['breadcrumb'] = array('Audit Trail' => '');
        $data['buttons'] = ['search','date_range']; 
        $data['standard'] = config('Standard');
        $data['session'] = session();
		$data['js'] = array(
				"assets/js/bootstrap.min.js",
				"assets/js/adminlte.min.js",
				"assets/js/moment.js",
				"assets/cms/js/login/login_js.js"
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
