<?php

namespace App\Controllers;

use Config\Database;

class Dashboard extends BaseController
{
    protected $session;
    private $auth_token;
    protected $db;
    public function __construct()
	{
	    $this->session = session();
	    $this->auth_token = getenv('API_AUTH_TOKEN');
        helper('url');
	    if (!$this->session->get('sess_site_uid')) {
	        redirect()->to(base_url('login'))->send();
	        exit;
	    }
	}

    private function check_token()
    {
        $request_token = $this->request->getHeaderLine('Authorization');

        if ($request_token !== $this->auth_token) {
            return $this->failUnauthorized('Invalid or missing token.');
        }

        return true;
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
		$data['PageUrl'] = 'Dashboard';
		$data["breadcrumb"] = array('Announcements' => '');
		$query = [
		    'status' => 1,
		    'start_date >=' => date('Y-m-d') . ' 00:00:00',
		    'end_date <='  => date('Y-m-d') . ' 23:59:59',
		];
		$data['announcements'] = $this->Global_model->get_data('tbl_announcements', $query, 999, 0, 'title, description_1, description_2, description_3, start_date, end_date', 'title', 'ASC', null, null);

		$data['content'] = "site/dashboard/dashboard";
		$data['js'] = array(
                    );
        $data['css'] = array(
                    );
        return view("site/layout/template_no_sidebar", $data);
	}

    public function getCounts()
    {
        $counts = $this->Dashboard_model->getCounts();
        return $this->response->setJSON($counts);
    }
}
