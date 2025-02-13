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
        if (!$this->session->get('sess_site_uid')) {
            return redirect()->to(base_url("login")); 
           exit;
        //	echo "test";
        }
	}

	public function login()
	{
		if ($this->session->get('sess_site_uid')) {
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
				"assets/js/sweetalert2@11.js",
				"assets/site/js/login/login_js.js",
				"assets/js/cms_custom.js"
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

	public function validate_log() {
	    $session = session();
	    $email = $this->request->getPost('emailadd');

	    $current_datetime = date("Y-m-d H:i:s");
	    $table = 'cms_users';

	    // Determine if login is via email or email
	    $account = $this->Global_model->check_email($email);
	    // print_r($email);
	    // die();
	    if (!$account) {
	        echo json_encode(['count' => 1, 'result' => null, 'message' => 'Invalid credentials']);
	        return;
	    }

	    $user = $account[0];
	    $email = $user->email;
	    $login_attempts = 0;

	    // Authenticate user
	    $password = $this->request->getPost('password');
	    $data = $this->Global_model->validate_log_email($email, $password);


	    if(empty($data)){
		    echo json_encode(['count' => 1, 'result' => null, 'message' => 'Invalid credentials']);
		    return;
	    }        
	    if ($data->status > 0) {

	        $this->set_session($data);
	        echo json_encode(['count' => 3, 'result' => $data, 'message' => 'Login successful']);
	        return;
	    }else{
	    	$this->get_error_logs($email);
	    	echo json_encode(['count' => 2, 'result' => null, 'message' => 'Inactive Account']);
	    	return;
	    }
	    // Failed login attempt handling
	    $this->get_error_logs($email);
	    echo json_encode(['count' => 1, 'result' => null, 'message' => 'Invalid credentials']);
	    return;
	}

	public function set_session($data) {
	    if (is_object($data)) {
	        $data = [$data];
	    } elseif (!is_array($data) || empty($data)) {
	        return;
	    }

	    $session = session();

	    foreach ($data as $value) {
	        if (!is_object($value)) {
	            continue; // Skip invalid data
	        }
		
	        $newdata = [
	            'sess_site_uid'  => $value->id,
	            'sess_site_user' => $value->username,
	            'sess_site_email' => $value->email,
	            'sess_site_name' => $value->name,
	            'sess_site_role' => $value->role
	        ];

	        // Add to audit trail
	        // $data2 = [
	        //     'user_id' => $value->id,
	        //     'url' => "",
	        //     'action' => strip_tags(ucwords("Login")),
	        //     'created_date' => date('Y-m-d H:i:s')
	        // ];
	        // $this->Global_model->save_data('cms_audit_trail', $data2);
	    }
	    $session->set($newdata);
	}

	public function logout() {
	    $session = session();

	    $sessionKeys = ['sess_site_uid', 'sess_site_user', 'sess_site_email', 'sess_site_name', 'sess_site_role'];
	    $session->remove($sessionKeys);
		return redirect()->to(base_url("/login")); 
	}

	    // $audit_data['user_id'] = $session->get('sess_uid');
	  	// $audit_data['url'] ="";
	  	// $audit_data['action'] = strip_tags(ucwords("Logout"));
	  	// $audit_data['created_date'] = date('Y-m-d H:i:s'); 
	  	// $table = 'cms_audit_trail';

	  	// if($audit_data['user_id'] != null){
	  	// 	$this->Global_model->save_data($table,$audit_data);
	  	// }

	// public function sign_out()
	// {
	// 	$session = session();
	// 	$session->setTempdata('logout_data', 'You are successfully logged out.', 5);
	// 	redirect(base_url('login'));
	// }

}
