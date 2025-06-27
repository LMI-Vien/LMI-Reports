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
		$today = date('Y-m-d H:i:s');

		$query = [
		    'status' => 1,
		    'start_date <=' => $today,
		    'end_date >='   => $today,
		];
		$data['announcements'] = $this->Global_model->get_data('tbl_announcements', $query, 999, 0, 'id, title, description_1, description_2, description_3, start_date, end_date', 'title', 'ASC', null, null);
		$data['announcementTypes'] = [
			'System Update'     => '#007BFF',
			'Event Notification'=> '#28A745',
			'Policy Update'     => '#FD7E14',
			'Downtime Alert'    => '#DC3545',
			'Holiday Advisory'  => '#FFC107',
			'Security Notice'   => '#343A40',
			'Promotion or Offer'=> '#6F42C1',
			'Personnel Update'  => '#795548',
			'User Reminder'     => '#6C757D',
		];
		
		$data['content'] = "site/dashboard/dashboard";
		$data['session'] = session();
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

	public function get_ba_asc_name() {
	    $name = $this->request->getPost('name');
	    $role = $this->session->get('sess_site_role');
	    $response = ['status' => 'error', 'message' => 'No result found'];
	    //$role = 8;
	    if (empty($name)) {
	        return $this->response->setJSON($response);
	    }

	    $table = 'tbl_area_sales_coordinator asc';
	    $field = 'asc.description AS asc_name, asc.id AS asc_id, a.id AS area_id, a.description AS area';
	    $join = [
	        ['table' => 'tbl_area a', 'query' => 'asc.area_id = a.id', 'type' => 'left'],
	        ['table' => 'tbl_store_group sg', 'query' => 'a.id = sg.area_id', 'type' => 'left'],
	        ['table' => 'tbl_store s', 'query' => 'sg.store_id = s.id', 'type' => 'left']
	    ];

	    if ($role == 7) { // Brand Ambassador
	        $table = 'tbl_brand_ambassador ba';
	        $field = 'ba.name AS brand_ambassador, ba.id AS brand_ambassador_id, a.id AS area_id, a.description AS area';
	        $join = [
	            ['table' => 'tbl_brand_ambassador_group bag', 'query' => 'ba.id = bag.brand_ambassador_id', 'type' => 'left'],
	            ['table' => 'tbl_store s', 'query' => 'bag.store_id = s.id', 'type' => 'left'],
	            ['table' => 'tbl_store_group sg', 'query' => 's.id = sg.store_id', 'type' => 'left'],
	            ['table' => 'tbl_area a', 'query' => 'sg.area_id = a.id', 'type' => 'left']
	        ];
	    }

	    $result = $this->Global_model->get_by_name($table, $field, $name, $join);

	    if (!empty($result)) {
	        $row = $result[0];
	        $data = [];

	        if ($role == 7) {
	            $data = [
	                'brandAmbassador'   => $row->brand_ambassador ?? '',
	                'brandAmbassadorId' => $row->brand_ambassador_id ?? '',
	                'area'              => (!empty($row->area_id) && !empty($row->area))
	                    ? "AREA-" . str_pad($row->area_id, 4, '0', STR_PAD_LEFT) . " - " . $row->area
	                    : '',
	                'areaId'            => $row->area_id ?? ''
	            ];
	        } else {
	            $data = [
	                'ascName'   => $row->asc_name ?? '',
	                'ascNameId' => $row->asc_id ?? '',
	                'area'      => (!empty($row->area_id) && !empty($row->area))
	                    ? "AREA-" . str_pad($row->area_id, 4, '0', STR_PAD_LEFT) . " - " . $row->area
	                    : '',
	                'areaId'    => $row->area_id ?? ''
	            ];
	        }

	        return $this->response->setJSON([
	            'status' => 'success',
	            'data'   => $data
	        ]);
	    }

	    return $this->response->setJSON($response);
	}


}
