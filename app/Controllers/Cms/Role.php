<?php

namespace App\Controllers\Cms;

use App\Controllers\BaseController;

class Role extends BaseController
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
			"title"         =>  "LMI CMS Portal",
			"description"   =>  "LMI CMS Portal Wep application",
			"keyword"       =>  ""
		);
		$data['title'] = "Roles";
		$data['PageName'] = 'Roles';
		$data['PageUrl'] = 'Roles';
		$data['content'] = "cms/roles/roles.php";
		$data['buttons'] = ['add', 'search'];
		$data['session'] = session(); //for frontend accessing the session data

		$data['js'] = array(
				"assets/js/bootstrap.min.js",
				"assets/js/adminlte.min.js",
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

	public function menu_update() {
		$table = 'cms_user_roles';
		$role_access_cms = $_POST['cms_menu_role_data'];
		$role_access_site = $_POST['site_menu_role_data'];
		$role_id = $_POST['user_role_data'];
		$this->Custom_model->menu_role_insert($role_id, $role_access_cms);
		$this->Custom_model->menu_role_insert_site($role_id, $role_access_site);
	}

	public function menu_insert() {
		$table = 'cms_user_roles';
		$user_role = $_POST['user_role_data'];
		$role_access_cms = $_POST['cms_menu_role_data'];
		$role_access_site = $_POST['site_menu_role_data'];
		$user_role_id = $this->Global_model->save_data($table,$user_role);
		$this->Custom_model->menu_role_insert($user_role_id, $role_access_cms);
		$this->Custom_model->menu_role_insert_site($user_role_id, $role_access_site);
		$this->audit_trail();
	}

	public function delete_role_tagging(){
		$role_id = $_POST['role_id'];
		$table = "cms_menu_roles";

		$status = $this->Custom_model->delete_role_tagging($role_id);

		echo $status;
	}

	public function audit_trail()
	{
		$auditData['user'] = session()->sess_name;
		$auditData['module'] =str_replace(base_url("dynamic") . '/', "", $_SERVER['HTTP_REFERER']); ;
	  	$auditData['action'] = strip_tags(ucwords("Create"));
	  	$auditData['created_at'] = date('Y-m-d H:i:s');
	  	$auditData['ip_address'] = $this->request->getIPAddress(); 
		$table = 'activity_logs';

		if($auditData['user'] != null){
			$this->Global_model->save_data($table,$auditData);
		}
	}


}
