<?php

namespace App\Controllers\Cms;

use App\Controllers\BaseController;
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
            return redirect()->to(base_url("cms/login")); 
            exit;
        }
	}

	public function registration ()	{
		if (isset($this->session->sess_uid)) {
            return redirect()->to(base_url('cms/home'))->send();
        }
		$data['meta'] = array(
			"title"         =>  "LMI CMS Portal",
			"description"   =>  "LMI CMS Portal Wep application",
			"keyword"       =>  ""
		);
		$data['title'] = "Register";
		$data['logout_data'] = '';
		$data['PageName'] = 'Register';
		$data['content'] = "cms/register.php";
		$data['js'] = array(
				"assets/js/bootstrap.min.js",
				"assets/cms/js/login/login_js.js"
                    );
        $data['css'] = array(
        		"assets/css/bootstrap.min.css",
        		"assets/css/adminlte.min.css",
        		// "assets/site/css/login/login_style.css",
        		"assets/css/style.css",
				"assets/css/login/login.css"
                    );
		return view("cms/layout/template_login", $data);
	}

	public function login()
	{
		if (isset($this->session->sess_uid)) {
            return redirect()->to(base_url('cms/home'))->send();
        }
		$data['meta'] = array(
			"title"         =>  "LMI CMS Portal",
			"description"   =>  "LMI CMS Portal Wep application",
			"keyword"       =>  ""
		);
		$data['title'] = "Login";
		$data['logout_data'] = '';
		$data['PageName'] = 'Login';
		$data['content'] = "cms/login.php";
		$data['js'] = array(
				"assets/js/bootstrap.min.js",
				"assets/js/sweetalert2@11.js",
				"assets/cms/js/login/login_js.js"
                    );
        $data['css'] = array(
        		"assets/css/bootstrap.min.css",
        		"assets/css/adminlte.min.css",
        		// "assets/site/css/login/login_style.css",
        		"assets/css/style.css",
				"assets/css/login/login.css"
                    );
		return view("cms/layout/template_login", $data);
		
	}

	public function validate_log() {
	    $session = session();
	    $details_cms = details("cms_preference", 1);
	    $ad_authentication = $details_cms[0]->ad_authentication;
	    $ad_status = $this->request->getPost('ad_status');
	    $username = $this->request->getPost('username');

	    $current_datetime = date("Y-m-d H:i:s");
	    $table = 'cms_users';
	    $field = 'username';

	    // Determine if login is via email or username
	    $account = valid_email($username) ? $this->Global_model->check_email($username) : $this->Global_model->check_user($username);
	    
	    if (!$account) {
	        echo json_encode(['count' => 1, 'result' => null, 'message' => 'Invalid credentials']);
	        return;
	    }

	    $user = $account[0];
	    $username = $user->username;
	    $login_attempts = '';

	    // Handle login attempts message
	    if ($user->status == 1) {
	        switch ($user->user_error_logs) {
	            case 0: $login_attempts = '2 attempts remaining'; break;
	            case 1: $login_attempts = '1 attempt remaining'; break;
	        }
	    }

	    // Check if account is blocked or locked
	    if ($user->user_block_logs == 3) {
	        echo json_encode(['count' => 5, 'result' => null, 'message' => 'Account is blocked', 'message' => $login_attempts]);
	        return;
	    }
	    
	    if ($user->user_lock_time && $current_datetime < $user->user_lock_time) {
	        echo json_encode(['count' => 4, 'result' => null, 'message' => 'Account is temporarily locked', 'message' => $login_attempts]);
	        return;
	    }

	    // Reset login attempts if needed
	    if ($user->user_error_logs >= 3) {
	        $this->Global_model->update_data($table, ['user_error_logs' => 0, 'user_lock_time' => null], $field, $username);
	        $login_attempts = '2 attempts remaining';
	    }

	    // Authenticate user
	    $password = $this->request->getPost('password');
	    $data = ($user->role == 1 && valid_email($username) && $ad_status == 'success') 
	            ? $account 
	            : $this->Global_model->validate_log($username, $password);
	    if(empty($data)){
			$this->get_error_logs($username);
		    echo json_encode(['count' => 1, 'result' => null, 'message' => 'Invalid credentials', 'message' => $login_attempts]);
		    return;
	    }        
	    if ($data->status > 0 ) {

			$table = 'cms_users';
			$field = 'username';
			$where = $username;
			$user_data['user_error_logs'] = 0;
			$user_data['user_block_logs'] = 0;
			$user_data['user_lock_time'] = null;

			$this->Global_model->update_data($table,$user_data,$field,$where);

	        // Handle session and password expiration
	        $expiration_days = $this->check_expiration_of_password($user->id);
	        if ($expiration_days > 90) {
	            //$this->send_email($user->email);
	            echo json_encode(['count' => 6, 'result' => null, 'message' => 'Password expired', 'attempts' => $login_attempts]);
	            return;
	        }

	        $days_left = 90 - $expiration_days;
	        if ($expiration_days > 83) {
	            $session->setFlashdata('toast_message', "You have $days_left day(s) left before your password expires. Please change immediately.");
	        }

	        $this->set_session($data);
	        echo json_encode(['count' => 3, 'result' => $data, 'message' => 'Login successful', 'attempts' => $login_attempts]);
	        return;
	    }else{
	    	$this->get_error_logs($username);
	    	echo json_encode(['count' => 2, 'result' => null, 'message' => 'Inactive Account', 'attempts' => $login_attempts]);
	    	return;
	    }
	    // Failed login attempt handling
	    $this->get_error_logs($username);
	    echo json_encode(['count' => 1, 'result' => null, 'message' => 'Invalid credentials', 'attempts' => $login_attempts]);
	    return;
	}

	public function get_error_logs($username){
		$current_datetime =  date("Y-m-d H:i:s"); 
		$table = 'cms_users';
		$field = 'username';
		$where = $username;
		$user_checker = $this->Global_model->check_user($username);
		$get_admin_email = $this->Global_model->get_list_query($table, 'role = 2');
		//get brand name
		$title = $this->Global_model->get_list_all('cms_preference');

		$emails = config('Emails');
        $default_email = $emails->default_email;

		if($user_checker != null){
			if( $user_checker[0]->user_error_logs == 2){
				$expire_lock_time = date('Y-m-d H:i:s', strtotime("+5 min"));
				if($user_checker[0]->user_lock_time == null || $current_datetime > $user_checker[0]->user_lock_time){
					$data['user_lock_time'] = $expire_lock_time;
				}
				$data['user_error_logs'] = 0;
				$data['user_block_logs'] = $user_checker[0]->user_block_logs + 1;
				//send mail
			}else{
				$data['user_error_logs'] = $user_checker[0]->user_error_logs + 1;
			}
		}
		$this->Global_model->update_data($table,$data,$field,$where);
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
	            'sess_uid'  => $value->id,
	            'sess_user' => $value->username,
	            'sess_email' => $value->email,
	            'sess_name' => $value->name,
	            'sess_role' => $value->role
	        ];

	        // Add to audit trail
	        $data2 = [
	            'user_id' => $value->id,
	            'url' => "",
	            'action' => strip_tags(ucwords("Login")),
	            'created_date' => date('Y-m-d H:i:s')
	        ];
	        $this->Global_model->save_data('cms_audit_trail', $data2);
	    }
	    $session->set($newdata);
	}

	public function sign_out() {

		$session = session();
	    $data2['user_id'] = $session->get('sess_uid');
	  	$data2['url'] ="";
	  	$data2['action'] = strip_tags(ucwords("Logout"));
	  	$data2['created_date'] = date('Y-m-d H:i:s'); 
	  	$table = 'cms_audit_trail';

	  	if($data2['user_id'] != null){
	  		$this->Global_model->save_data($table,$data2);
	  	}
	  	$session = session();
	  	//$session->destroy();
		$sessionKeys = ['sess_uid', 'sess_user', 'sess_email', 'sess_name', 'sess_role'];
	    $session->remove($sessionKeys);
		$session->setTempdata('logout_data', 'You are successfully logged out.', 5);
		return redirect()->to(base_url("cms/login")); 
	}

	public function reset_password()
	{
		$uri = current_url(true);
		$data['title'] = "Reset Password";
		$data['PageName'] = "Reset Password";
		$data['uri'] = $uri;
		$token = $uri->getSegment(5);
		$query = "token = '$token' AND status = 0";
		$select = "id, token, redirect, user_id, create_date, expire_date, status";
		$result_data = $this->Global_model->get_data_list("cms_site_token", $query, 1,0, $select, "create_date", "desc", null, null);
	
        if(count($result_data) > 0 ){

            if($result_data[0]->expire_date >= date('Y-m-d H:i:s')){

                $token = array(
                    "status" => 1
                );

                $this->Global_model->update_data("cms_site_token",$token,"user_id",$result_data[0]->user_id);
                $data['user_id'] = $result_data[0]->user_id;
                $data['success'] = true;
                $data['title'] = "RESET PASSWORD";

            } else {

                $data['user_id'] = 0;
                $data['success'] = false;
                $data['title'] = "EXPIRED TOKEN";

            }
        } else {
            $data['user_id'] = 0;
            $data['success'] = false;
            $data['title'] = "INCORRECT/USED TOKEN";
        }

		echo view('cms/reset_password', $data);
	}

	public function check_expiration_of_password($user_id)
	{
		$details = $this->Global_model->get_list_query_sort('cms_historical_passwords', 'user_id='.$user_id, 'create_date', 'DESC');
		$date1 = date_create($details[0]->create_date); //create date
		$date2 = date_create(date('Y-m-d')); //current date
		$date_diff = date_diff($date1,$date2)->format("%a"); //date difference

		return $date_diff;
	}

	public function token($user_id, $user_email)
    {
        $salt = md5('Unilab CMS' . date('Y-m-d H:i:s'));
        $token = md5($user_email . $salt);
        $data = array(
            "token"=>$token,
            "redirect"=>"cms/login/reset_password",
            "user_id"=>$user_id,
            "status"=>0,
            "create_date"=>date('Y-m-d H:i:s'),
            "expire_date"=>date('Y-m-d H:i:s', strtotime("+24 hours"))
        );
        $this->Global_model->save_data("cms_site_token",$data);
        return $token;
    }
    public function testing(){
		//$salt = md5(1);
		$salt = "b91614712c2120a58ef2c011130552c6";
		$password1 = "Testing@1234";

		// Hash the password with the salt
		$salted_password = hash("sha256", $password1 . $salt);

		// Hash the salted password with password_hash
		$options = ['cost' => 12];
		$hash = password_hash($salted_password, PASSWORD_DEFAULT, $options);

		// Simulating stored hashed password (normally retrieved from the database)
		$stored_hashed_password = '$2y$12$REv9ggUzP7lcGQuOscD/sOZ3vKYpU2mAURiBkZURQ88wwp1MRf3by'; 

		// Verify if the entered password matches the stored hashed password
		$input_password = "Testing@1234"; // User input during login
		$input_salted_password = hash("sha256", $input_password . $salt);

		if (password_verify($input_salted_password, $stored_hashed_password)) {
		    echo "true"; // Password is correct
		} else {
		    echo "false"; // Password is incorrect
		}

		echo "\nStored Hash: " . $hash;
        // $user = array(
        //         'password' => $salted_password,
        //         'update_date' => date('Y-m-d H:i:s')
        //      );
        // $data2 = array( 'user_id' => 28, 'password' => $salted_password ); //historical

        // $this->Global_model->update_data("cms_users",$user,"id",$user_id);
        echo "success";
    }
}
