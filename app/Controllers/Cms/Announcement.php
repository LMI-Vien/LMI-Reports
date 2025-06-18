<?php

namespace App\Controllers\Cms;

use App\Controllers\BaseController;

class Announcement extends BaseController
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
			"title"         =>  "Announcements",
			"description"   =>  "Announcements",
			"keyword"       =>  ""
		);
		$data['title'] = "Announcements";
		$data['PageName'] = 'Announcements';
		$data['PageUrl'] = 'Announcements';
		$data['buttons'] = ['add', 'search', 'filter'];
		$data['content'] = "cms/maintenance/announcement/announcement.php";
		$data['session'] = session();

		$data['js'] = array(
				"assets/js/bootstrap.min.js",
				"assets/js/adminlte.min.js",
				"assets/js/moment.js",
				"assets/js/xlsx.full.min.js",
				"assets/site/js/timepicker.js"
                    );
        $data['css'] = array(
        		"assets/css/bootstrap.min.css",
        		"assets/css/adminlte.min.css",
        		"assets/css/all.min.css",
        		"assets/cms/css/main_style.css",
        		"assets/css/style.css",
				"assets/site/js/timepicker.css"
                    );
		return view("cms/layout/template", $data);	
	}

}
