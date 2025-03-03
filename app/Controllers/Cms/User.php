<?php

namespace App\Controllers\Cms;

use App\Controllers\BaseController;

class User extends BaseController
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
			"title"         =>  "User",
			"description"   =>  "User",
			"keyword"       =>  ""
		);
		$data['title'] = "Users";
		$data['PageName'] = 'Users';
		$data['PageUrl'] = 'Users';
		$data['buttons'] = ['add', 'search'];
		$data['content'] = "cms/user/User.php";
		$data['session'] = session(); //for frontend accessing the session data
		$data['js'] = array(
				"assets/js/bootstrap.min.js",
				"assets/js/adminlte.min.js",
				"assets/js/moment.js",
                    );
        $data['css'] = array(
        		"assets/css/bootstrap.min.css",
        		"assets/css/adminlte.min.css",
        		"assets/css/all.min.css",
        		"assets/cms/css/main_style.css",//css sa style ni master Vien
        		"assets/css/style.css"
                    );
		return view("cms/layout/template", $data);	
	}

	public function save_user(){
		$salt = md5(date('Y-m-d H:i:s'));
        $data = $this->request->getPost('data');

        $password1 = $data['password1'];
        $password2 = $data['password2'];
        if($password1 != $password2){
            $message = "Password not matched!";
            $success = false;
        }else {
        	$salted_password = hash("sha256", $password1.$salt);
            $options = ['cost' => 12];
            $hash = password_hash($salted_password, PASSWORD_DEFAULT, $options);
            $user = array(	
            				'username' => $data['username'],
            				'email' => $data['email'],
            				'name' => $data['name'],
            				'password' => $hash,
                            'salt' => $salt,
                            'created_date' => date('Y-m-d H:i:s'),
                            'status' => $data['status'],
                            'role' => $data['role'],
                            'dashboard_access' => $data['dashboard_access'],
                            'created_by' => $data['created_by']

                         );
            $id =  $this->Global_model->save_data("cms_users",$user);
            $data2 = array( 'user_id' => $id, 'password' => $hash );
           
            $this->Global_model->save_data("cms_historical_passwords", $data2);
            $message = "success";
            $success = true;
		}
		echo json_encode(array("success"=>$success, "message"=>$message));
	}
	public function update_user(){
        $data = $this->request->getPost('data');
        $user_id = $this->request->getPost('user_id');

        $update_password = $data['update_password']; 
        // echo $update_password;
        // die();
        if($update_password == 'true' || $update_password === true){
            $password1 = $data['password1'];
            $password2 = $data['password2'];
            if($password1 != $password2){
                $message = "Password not matched!";
                $success = false;
            }else {
                $salt = $this->Global_model->get_password_salt($user_id);
                $salted_password = hash("sha256", $password1.$salt);
                $options = ['cost' => 12];
                $hash = password_hash($salted_password, PASSWORD_DEFAULT, $options);
                $user = array(  
                                'username' => $data['username'],
                                'email' => $data['email'],
                                'name' => $data['name'],
                                'password' => $hash,
                                'salt' => $salt,
                                'updated_date' => date('Y-m-d H:i:s'),
                                'status' => $data['status'],
                                'role' => $data['role'],
                                'dashboard_access' => $data['dashboard_access'],
                                'updated_by' => $data['updated_by']

                             );
                $result1 = $this->Global_model->update_data('cms_users',$user,'id',$user_id);
                $data2 = array( 'user_id' => $user_id, 'password' => $hash );
                $result2 = $this->Global_model->save_data('cms_historical_passwords',$data2);
                $message = "success";
                $success = true;
            }
        }else{
             $user = array(  
                        'username' => $data['username'],
                        'email' => $data['email'],
                        'name' => $data['name'],
                        'updated_date' => date('Y-m-d H:i:s'),
                        'status' => $data['status'],
                        'role' => $data['role'],
                        'dashboard_access' => $data['dashboard_access'],
                        'updated_by' => $data['updated_by']

                     );
            $result1 = $this->Global_model->update_data('cms_users',$user,'id',$user_id);
            $message = "success";
            $success = true;
        }
        echo json_encode(array("success"=>$success, "message"=>$message));
	}
}
