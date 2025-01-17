<?php

namespace App\Controllers;

use App\Libraries\Recaptha;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\Files\Exceptions\FileNotFoundException;

class Login extends BaseController
{
    protected $session;

    public function __construct()
    {
        $this->session = session();

    }

	public function index()
	{
		$this->request = \Config\Services::request();
        if (!isset($this->session->sess_uid)) {
            return redirect()->to(base_url("login")); 
            exit;
        }
	}

	public function login()
	{
		if (isset($this->session->sess_uid)) {
            return redirect()->to(base_url('dashboard'))->send();
        }
		$data['meta'] = array(
			"title"         =>  "LMI Portal",
			"description"   =>  "LMI Portal Wep application",
			"keyword"       =>  ""
		);
		$data['title'] = "Login";
		$data['PageName'] = 'Login';
		$data['content'] = "site/login/login.php";

		$data['js'] = array(
				"assets/js/bootstrap.min.js",
				"assets/js/adminlte.min.js",
				"assets/site/js/login/login_js.js"
                    );
        $data['css'] = array(
        		"assets/css/bootstrap.min.css",
        		"assets/css/adminlte.min.css",
        		"assets/site/css/login/codemirror.min.css",
        		"assets/site/css/login/summernote.min.css",
        		// "assets/site/css/login/login_style.css",
        		"assets/css/style.css",
				"assets/site/css/login/login.css",
                    );
		return view("site/layout/template_login", $data);
		
	}

	public function auth() {
	    $data = $this->request->getPost('data');
		// print_r($data); die();
	    $email = $data['email'];
	    $password = hash('sha256', $data['password']);
	    $result = $this->Global_model->validate_log_report_user($email, $password);
	    $final_result = "invalid";

	    if (!empty($result) && isset($result[0])) {
	        $data_object = $result[0];
	        $final_result = "valid";

	        $usersData = [
	            'id' => $data_object->id,
	            'username' => $data_object->username,
	            'email' => $data_object->email,
	            'name' => $data_object->name,
	        ];

	        $audit_data = [
	            'user_id' => $data_object->id,
	            'url' => "", 
	            'action' => strip_tags(ucwords("Login")),
	            'created_date' => date('Y-m-d H:i:s'),
	        ];
	        $table = 'cms_audit_trail';

	        $this->Global_model->save_data($table, $audit_data);

	        //$session = session();
	        $this->set_session($usersData);
	    }
	    echo $final_result;
	}

	public function set_session($data) 
	{
		$newdata = array(
			'sess_site_uid'  => $data['id'],
	        'sess_site_user' => $data['username'],
	        'sess_site_email' => $data['email'],
	        'sess_site_name' => $data['name']
	       // 'sess_site_role' => $data['role']
		);
		
	    $data2['user_id'] = $data['id'];
	  	$data2['url'] = "";
	  	$data2['action'] = strip_tags(ucwords("Login"));
	  	$data2['created_date'] = date('Y-m-d H:i:s'); 
	  	$table = 'cms_audit_trail';
		  
	  	$this->Global_model->save_data($table,$data2);

		$session = session();
		$session->set($newdata);
		//print_r($session->get());
		//die();
	}

	public function logout() {
		$session = session();

	    $audit_data['user_id'] = $session->get('sess_uid');
	  	$audit_data['url'] ="";
	  	$audit_data['action'] = strip_tags(ucwords("Logout"));
	  	$audit_data['created_date'] = date('Y-m-d H:i:s'); 
	  	$table = 'cms_audit_trail';

	  	$session->destroy();
	  	if($audit_data['user_id'] != null){
	  		$this->Global_model->save_data($table,$audit_data);
	  	}
		return redirect()->to(base_url("/login")); 
	}

	public function sign_out()
	{
		$session = session();
		$session->setTempdata('logout_data', 'You are successfully logged out.', 5);
		redirect(base_url('login'));
	}

}
