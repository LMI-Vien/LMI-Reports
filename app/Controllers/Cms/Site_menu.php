<?php

namespace App\Controllers\Cms;

use App\Controllers\BaseController;

class Site_menu extends BaseController
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
			"title"         =>  "Site Menu",
			"description"   =>  "Site Menu",
			"keyword"       =>  ""
		);
		$data['menu_group'] = '';
		$data['menu_id'] = '';
		$uri = current_url(true);
		$totalSegments = $uri->getTotalSegments();
		$data['menu_id'] = ($totalSegments >= 4) ? $uri->getSegment(4) : '';
		$data['menu_group'] = ($totalSegments >= 5) ? $uri->getSegment(5) : '';

		$data['title'] = "Site Menu";
		$data['PageName'] = 'Site Menu';
		$data['PageUrl'] = 'Site Menu';
		$data['buttons'] = ['add', 'search'];
		$data['content'] = "cms/sitemenu/menus.php";
		$data['session'] = session(); //for frontend accessing the session data
		$data['js'] = array(
				"assets/js/bootstrap.min.js",
				"assets/js/adminlte.min.js",
				"assets/js/moment.js",
				"assets/cms/js/login/login_js.js"
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

	public function menu_add()
	{
		$data['meta'] = array(
			"title"         =>  "Site Menu",
			"description"   =>  "Site Menu",
			"keyword"       =>  ""
		);
		$data['title'] = "Site Menu";
		$data['PageName'] = 'Site Menu';
		$data['PageUrl'] = 'Site Menu';
		$data['buttons'] = ['add', 'search'];
		$data['content'] = "cms/sitemenu/menus.php";
		
		$data['js'] = array(
				"assets/js/bootstrap.min.js",
				"assets/js/adminlte.min.js",
				"assets/js/moment.js",
				"assets/cms/js/login/login_js.js"
                    );
        $data['css'] = array(
        		"assets/css/bootstrap.min.css",
        		"assets/css/adminlte.min.css",
        		"assets/css/all.min.css",
        		"assets/site/css/login/login_style.css",
        		"assets/cms/css/main_style.css",//css sa style ni master Vien
        		"assets/css/style.css"
                    );
		return view("cms/layout/template", $data);
	}

	public function menu_update()
	{
		$data['meta'] = array(
			"title"         =>  "Site Menu",
			"description"   =>  "Site Menu",
			"keyword"       =>  ""
		);
		$data['title'] = "Site Menu";
		$data['PageName'] = 'Site Menu';
		$data['PageUrl'] = 'Site Menu';
		$data['buttons'] = ['add', 'search'];
		$data['content'] = "cms/sitemenu/menus.php";
		
		$data['js'] = array(
				"assets/js/bootstrap.min.js",
				"assets/js/adminlte.min.js",
				"assets/js/moment.js",
				"assets/cms/js/login/login_js.js"
                    );
        $data['css'] = array(
        		"assets/css/bootstrap.min.css",
        		"assets/css/adminlte.min.css",
        		"assets/css/all.min.css",
        		"assets/site/css/login/login_style.css",
        		"assets/css/style.css"
                    );
		return view("cms/layout/template", $data);
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

	public function audit_trail()
	{
		$auditData['user_id'] = session()->sess_uid;
		$auditData['url'] =str_replace(base_url("dynamic") . '/', "", $_SERVER['HTTP_REFERER']); ;
	  	$auditData['action'] = strip_tags(ucwords("Create"));
	  	$auditData['created_date'] = date('Y-m-d H:i:s'); 
		$table = 'cms_audit_trail';

		if($auditData['user_id'] != null){
			$this->Global_model->save_data($table,$auditData);
		}
	}

}
