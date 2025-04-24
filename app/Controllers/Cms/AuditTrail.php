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
		return view("cms/layout/template", $data);	 
	}
}
