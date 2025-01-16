<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;
use Config\Database;

class Dashboard extends BaseController
{
    protected $session;
    use ResponseTrait;
    private $auth_token;
    protected $db;
    public function __construct()
	{
	    $this->session = session();
	    $this->auth_token = getenv('API_AUTH_TOKEN');
        helper('url');
        $this->db = Database::connect('application1');
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

    public function send_system_info()
    {
        // if ($this->check_token() !== true) {
        //     return;
        // }

        $php_version = phpversion();

        $mysql_version = null;
        $db = Database::connect('application1');
        if ($db->connect_errno) {
            $mysql_version = 'Unable to connect to MySQL: ' . $db->connect_error;
        } else {
            $mysql_version = $db->getVersion();
        }

        $data = [
            'php_version' => $php_version,
            'mysql_version' => $mysql_version
        ];

        return $this->respond($data);
    }

	public function get_users()
	{
	    $builder = $this->db->table('cms_users');
	    $users = $builder->get()->getResult();

	    return $this->respond($users);
	}
}
