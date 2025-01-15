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
				"assets/cms/js/login/login_js.js"
                    );
        $data['css'] = array(
        		"assets/css/bootstrap.min.css",
        		"assets/css/adminlte.min.css",
        		"assets/site/css/login/login_style.css",
        		"assets/css/style.css"
                    );
		return view("cms/layout/template_login", $data);
		
	}

	public function validate_log() {
		
		$session = session();
		$details_cms = details("cms_preference",1);
		$ad_authentication = $details_cms[0]->ad_authentication;
		$ad_status = $this->request->getPost('ad_status');
		$username = '';

		$table = 'cms_users'; 
		$field = '';
		$where = '';
		$login_attempts = '';
		$current_datetime = date("Y-m-d H:i:s");
		$account = '';
		if(valid_email($this->request->getPost('username'))){
			$account = $this->Global_model->check_email($this->request->getPost('username'));
		}else{
			$account = $this->Global_model->check_user($this->request->getPost('username'));
		}

		if($account != null &&  $account[0]->role == 1){ //Checks if user is Super Admin
			$check_user = $account;
			$username = $check_user[0]->username;
		}else{
			$username = $this->request->getPost('username');
			$check_user = $this->Global_model->check_user($username);
		}

		$field = 'username';
		$where = $username;
		$count = count($check_user);

		//Login attemps Counter
		$res = 0;
		if($check_user != null && $check_user[0]->status == 1){
			if($check_user[0]->user_error_logs == 0){
				$login_attempts = '2 attempts remaining';
			}elseif ($check_user[0]->user_error_logs == 1) {
				$login_attempts = '1 attempt remaining';
			}
		}
		
		if($count == 1){
			
			if($check_user[0]->user_block_logs != 3){
				//check if username is disabled or less than 3 attempts
				
				if($check_user[0]->user_lock_time == null || $current_datetime >=  $check_user[0]->user_lock_time){
					//set user error logs to 0
					if($check_user[0]->user_error_logs >= 3){
					  	$data['user_error_logs'] = 0;
					  	$data['user_lock_time'] = null;
					  	$this->Global_model->update_data($table,$data,$field,$where);
					  	$login_attempts = '2 attempts remaining';
					}
					
					$password = hash('sha256', $_POST['password']);
					
					if ($check_user[0]->role == 1) {// If user role is Super Admin
						if (valid_email($this->request->getPost('username')) ){
							$data = ($ad_status == 'success') ? $check_user : null;
						} else {
							
							$data = $this->Global_model->validate_log($username, $password);
							$res = ($data);
						}
					} else {
						$data = $this->Global_model->validate_log($username, $password);
						$res = ($data);
					}
					
					if($data != null)
					{
							
						$result_data = count($data);
						$user_count = 0;
						$user_session = 0;
						if($result_data > 0 )
						{
							foreach($data as $login_data)
							{
								if($login_data->status > 0 )
								{
									
									//if count = 3 account is active 
									$table = 'cms_users';
									$field = 'username';
									$where = $username;
									$user_data['user_error_logs'] = 0;
									$user_data['user_lock_time'] = null;

									$this->Global_model->update_data($table,$user_data,$field,$where);
									//Check expiration of password
									$expiration_days = $this->check_expiration_of_password($check_user[0]->id);
									if($expiration_days > 90){
										$count += 4; //expired password
										$this->send_email($check_user[0]->email); //send email reset password
									}else if($expiration_days > 83){
										$count += 2;
										$days_left = 90 - $expiration_days;
										$user_session++;
										$this->set_session($data);
										$session->setFlashdata('toast_message', 'You only have '.$days_left.' day(s) left before your password expires. Please change immediately.');
									}else{
										$count += 2;
										$user_session++;
										$this->set_session($data);
									}
								}
								else
								{
									$user_count++;
								}
							}
							if($user_count && ($user_session == 0))
							{
								$this->get_error_logs($username);
								$count += 1;
							}				
						}
						else 
						{
							$this->get_error_logs($username);
						}
					}
					else
					{
						$this->get_error_logs($username);
					}
				}else{
					$count += 3;
				}
			}else{
				$count += 5;
			}
		}	

		$resul_array = array(
			'count' => $count,
			'result'=>$res,
			'message' => $login_attempts
		);
		echo json_encode($resul_array);
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

	public function set_session($data) 
	{

		foreach ($data as $key => $value) {
			$newdata = array(
				'sess_uid'  => $value->id,
		        'sess_user' => $value->username,
		        'sess_email' => $value->email,
		        'sess_name' => $value->name,
		        'sess_role' => $value->role
			);
			
			//add to audit trail
		    $data2['user_id'] = $value->id;
		  	$data2['url'] = "";
		  	$data2['action'] = strip_tags(ucwords("Login"));
		  	$data2['created_date'] = date('Y-m-d H:i:s'); 
		  	$table = 'cms_audit_trail';
			  
		  	$this->Global_model->save_data($table,$data2);
		}
		$session = session();
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
	  	$session->destroy();
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
}
