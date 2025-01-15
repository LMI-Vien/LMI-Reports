<?php

namespace App\Controllers;

use App\Libraries\Recaptha;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\Files\Exceptions\FileNotFoundException;

class Dashboard extends BaseController
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

	public function index()
	{
		$data['meta'] = array(
			"title"         =>  "LMI Portal",
			"description"   =>  "LMI Portal Wep application",
			"keyword"       =>  ""
		);
		$data['title'] = "Dashboard";
		$data['PageName'] = 'Dashboard';
		$data['content'] = "site/dashboard/dashboard.php";
		$data['js'] = array(
			"assets/js/jquery-3.7.1.min.js",
			"assets/js/moment.min.js",
			"assets/js/jquery.tablesorter.min.js",
			"assets/js/daterangepicker.min.js",
			"assets/js/bootstrap.min.js",
			"assets/site/js/custom.js"
                    );
        $data['css'] = array(
        	"assets/css/bootstrap.min.css",
			"assets/site/css/dashboard/style-common.css",
			"assets/site/css/dashboard/style-header.css",
			"assets/site/css/dashboard/style-footer.css"
			//"assets//css/daterangepicker.css"
                    );
		return view("site/layout/template", $data);
	}
}
