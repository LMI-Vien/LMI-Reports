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

	// public function validate_log() {
	//     $session = session();
	//     $email = $this->request->getPost('emailadd');

	//     $current_datetime = date("Y-m-d H:i:s");
	//     $table = 'cms_users';

	//     // Determine if login is via email or email
	//     $account = $this->Global_model->check_email($email);
	//     // print_r($email);
	//     // die();
	//     if (!$account) {
	//         echo json_encode(['count' => 1, 'result' => null, 'message' => 'Invalid credentials']);
	//         return;
	//     }

	//     $user = $account[0];
	//     $email = $user->email;
	//     $login_attempts = 0;

	//     // Authenticate user
	//     $password = $this->request->getPost('password');
	//     $data = $this->Global_model->validate_log_email($email, $password);


	//     if(empty($data)){
	// 	    echo json_encode(['count' => 1, 'result' => null, 'message' => 'Invalid credentials']);
	// 	    return;
	//     }        
	//     if ($data->status > 0) {

	//         $this->set_session($data);
	//         echo json_encode(['count' => 3, 'result' => $data, 'message' => 'Login successful']);
	//         return;
	//     }else{
	//     	$this->get_error_logs($email);
	//     	echo json_encode(['count' => 2, 'result' => null, 'message' => 'Inactive Account']);
	//     	return;
	//     }
	//     // Failed login attempt handling
	//     $this->get_error_logs($email);
	//     echo json_encode(['count' => 1, 'result' => null, 'message' => 'Invalid credentials']);
	//     return;
	// }

	
	// public function get_error_logs($email) {
	// 	$current_datetime = date("Y-m-d H:i:s");
	// 	$table = 'cms_users';
	
	// 	$user_checker = $this->Global_model->check_email($email);
	
	// 	if (!$user_checker) return;
	
	// 	$user = $user_checker[0];
	// 	$data = [];
	
	// 	if ($user->user_error_logs == 2) { 
	// 		$expire_lock_time = date('Y-m-d H:i:s', strtotime("+5 minutes"));
	// 		if (!$user->user_lock_time || $current_datetime > $user->user_lock_time) {
	// 			$data['user_lock_time'] = $expire_lock_time;
	// 		}
	// 		$data['user_error_logs'] = 0;
	// 		$data['user_block_logs'] = $user->user_block_logs + 1;
	// 	} else {
	// 		$data['user_error_logs'] = $user->user_error_logs + 1;
	// 	}
	
	// 	$this->Global_model->update_data($table, $data, 'email', $email);
	// }

	public function validate_log() {
		$session = session();
		$email = $this->request->getPost('emailadd');
		$current_datetime = date("Y-m-d H:i:s");
		$table = 'cms_users';
	
		// Check if the email exists
		$account = $this->Global_model->check_email($email);
		if (!$account) {
			echo json_encode(['count' => 1, 'result' => null, 'message' => 'It seems that you\'re not in my database.', 'attempts' => '']);
			return;
		}
	
		$user = $account[0];
	
		// **Check for blocked accounts**
		if ($user->user_block_logs >= 3) {
			echo json_encode(['count' => 4,
				'result' => null,
				'message' => 'Account is blocked',
				// 'attempts' => 'Your account is permanently blocked. Contact admin.'
			]);
			return;
		}
	
		// **Check for locked accounts**
		if ($user->user_lock_time && $current_datetime < $user->user_lock_time) {
			echo json_encode([
				'count' => 4,
				'result' => null,
				'message' => 'Account is temporarily locked',
				// 'attempts' => "Locked until {$user->user_lock_time}"
			]);
			return;
		}
	
		// **Authenticate user**
		$password = $this->request->getPost('password');
		$data = $this->Global_model->validate_log_email($email, $password);
	
		if (empty($data)) {
			// **Increment login attempts**
			$this->get_error_logs($email);
	
			// **Fetch updated attempt count**
			$updated_user = $this->Global_model->check_email($email)[0];
			$attempts_left = 3 - $updated_user->user_error_logs;
			$attempts_message = $attempts_left > 1 ? "$attempts_left attempts remaining"
							  : ($attempts_left == 1 ? "1 attempt remaining" : "Last attempt remaining");
	
			// If the account is now blocked
			if ($updated_user->user_block_logs >= 3) {
				echo json_encode([
					'count' => 4,
					'result' => null,
					'message' => 'Account is blocked',
					'attempts' => 'Your account is permanently blocked. Contact admin.'
				]);
			} else {
				echo json_encode([
					'count' => 1,
					'result' => null,
					'message' => 'Invalid credentials',
					'attempts' => $attempts_message
				]);
			}
			return;
		}
	
		// **Reset login attempts on successful login**
		$this->Global_model->update_data($table, [
			'user_error_logs' => 0,
			'user_block_logs' => 0,
			'user_lock_time' => null
		], 'email', $email);
	
		$this->set_session($data);
		echo json_encode([
			'count' => 3,
			'result' => $data,
			'message' => 'Login successful',
			'attempts' => 'No restrictions'
		]);
	}
	
	public function get_error_logs($email) {
		$current_datetime = date("Y-m-d H:i:s");
		$table = 'cms_users';
	
		$user_checker = $this->Global_model->check_email($email);
		if (!$user_checker) return;
	
		$user = $user_checker[0];
		$data = [];
	
		if ($user->user_error_logs == 2) { 
			$expire_lock_time = date('Y-m-d H:i:s', strtotime("+5 minutes"));
			if (!$user->user_lock_time || $current_datetime > $user->user_lock_time) {
				$data['user_lock_time'] = $expire_lock_time;
			}
			$data['user_error_logs'] = 0;
			$data['user_block_logs'] = $user->user_block_logs + 1;
		} else {
			$data['user_error_logs'] = $user->user_error_logs + 1;
		}
	
		$this->Global_model->update_data($table, $data, 'email', $email);
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
	        $data2 = [
	            'user' => $value->name,
	            'module' => "Dashboard",
	            'action' => strip_tags(ucwords("Login")),
	            'ip_address'  => $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0',
	            'created_at' => date('Y-m-d H:i:s')
	        ];
	        $this->Global_model->save_data('activity_logs', $data2);
	    }
	    $session->set($newdata);
	}

	public function logout() {
	    $session = session();

        $data2 = [
            'user' => $session->get('sess_site_name'),
            'module' => "Dashboard",
            'action' => strip_tags(ucwords("Logout")),
            'ip_address'  => $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0',
            'created_at' => date('Y-m-d H:i:s')
        ];
        $this->Global_model->save_data('activity_logs', $data2);

	    $sessionKeys = ['sess_site_uid', 'sess_site_user', 'sess_site_email', 'sess_site_name', 'sess_site_role'];
	    $session->remove($sessionKeys);
		return redirect()->to(base_url("/login")); 
	}
}
