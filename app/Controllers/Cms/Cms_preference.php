<?php

namespace App\Controllers\Cms;

use App\Controllers\BaseController;

class Cms_preference extends BaseController
{

    public function get_title()
	{
		$result = $this->Global_model->get_by_id("cms_preference",1);
		echo $result[0]->cms_title;
	}

	public function get_logo()
	{
		$result = $this->Global_model->get_by_id("cms_preference",1);
		echo $result[0]->cms_logo;
	}

	public function get_skin()
	{
		$result = $this->Global_model->get_by_id("cms_preference",1);
		echo $result[0]->cms_skin;
	}

	public function get_menu()
	{ 

	    $session = session();
	    $currentUrl = base_url(uri_string()); 
	    //temp
	    $select = 'cms_menu.id, menu_url, menu_name, menu_icon, menu_type, menu_parent_id, menu_level, sort_order, status, role_id, menu_id, menu_role_read, menu_role_write, menu_role_delete';
	    $query = 'status = 1 AND role_id = ' . $session->sess_role . ' AND menu_level = 1 AND menu_role_read = 1';
	    $result = $this->Custom_model->get_menu_list('cms_menu', $select, $query);
	    $html = '';
	    
	    foreach ($result as $value) {
	        $new_location = base_url($value->menu_url);
	        $hasSubmenu = $value->menu_type == 1;
	        
	        $html .= '<li class="nav-item ' . ($hasSubmenu ? 'has-treeview' : '') . '" data-id="' . $value->id . '">';
	        $html .= '  <a href="' . ($hasSubmenu ? '#' : $new_location) . '" class="' . ($hasSubmenu ? 'nav-link' : 'nav-link nav-link-main') . '">';
	        $html .= '    <i class="nav-icon ' . $value->menu_icon . '"></i>';
	        $html .= '    <p>' . strtoupper($value->menu_name);
	        if ($hasSubmenu) {
	            $html .= '      <i class="right fas fa-angle-left"></i>';
	        }
	        $html .= '    </p>';
	        $html .= '  </a>';
	        
	        if ($hasSubmenu) {
	            $html .= $this->get_sub_menu($value->id);
	        }
	        
	        $html .= '</li>';
	    }
	    echo json_encode($html);
	}

	public function get_sub_menu($id)
	{
	    $session = session();
	    $select = 'cms_menu.id, menu_url, menu_name, menu_icon, menu_type, menu_parent_id, menu_level, sort_order, status, role_id, menu_id, menu_role_read, menu_role_write, menu_role_delete';
	    $query = 'status = 1 AND role_id = ' . $session->sess_role . ' AND menu_role_read = 1 AND menu_parent_id = ' . $id;
	    $result = $this->Custom_model->get_menu_list('cms_menu', $select, $query);
	    $html = '';
	    
	    $html .= '<ul class="nav nav-treeview">';
	    foreach ($result as $value) {
	        $new_location = base_url($value->menu_url);
	        $hasSubmenu = $value->menu_type == 1;
	        
	        $html .= '<li class="nav-item" data-id="' . $value->id . '">';
	        $html .= '  <a href="' . ($hasSubmenu ? '#' : $new_location) . '" class="nav-link" >';
	        $html .= '    <i class="far fa-circle nav-icon"></i>';
	        $html .= '    <p>' . strtoupper($value->menu_name);
	        if ($hasSubmenu) {
	            $html .= '      <i class="right fas fa-angle-left"></i>';
	        }
	        $html .= '    </p>';
	        $html .= '  </a>';
	        
	        if ($hasSubmenu) {
	            $html .= $this->get_sub_menu($value->id);
	        }
	        
	        $html .= '</li>';
	    }
	    $html .= '</ul>';
	    
	    return $html;
	}

    public function backup()
    {
        // $result = $this->Global_model->get_by_id("site_information",1);
        // dbutil();
        // $prefs = array(     
        //         'format'      => 'zip',             
        //         'filename'    => 'database.sql'
        //       );
        // $backup =& $this->dbutil->backup($prefs); 
        // $db_name = $result[0]->title . " " . date("Y-m-d H:i:s") .'.zip';
        // helper('download');
        // force_download($db_name, $backup); 
    }

	public function get_site_menu() {
	    $session = session();
	    $select = 'site_menu.id, menu_url, menu_name, menu_type, menu_parent_id';
	    $query = 'status = 1 AND role_id = ' . $session->sess_site_role . ' AND menu_role_view = 1';
	    $result = $this->Custom_model->get_site_menu_list('site_menu', $select, $query);
	    $menuTree = [];
	    $menuLookup = [];

	    foreach ($result as $menu) {
	        $menu->children = [];
	        $menuLookup[$menu->id] = $menu;
	    }

	    foreach ($result as $menu) {
	        if ($menu->menu_parent_id == 0) {
	            $menuTree[$menu->id] = $menu;
	        } else {
	            if (isset($menuLookup[$menu->menu_parent_id])) {
	                $menuLookup[$menu->menu_parent_id]->children[] = $menu;
	            }
	        }
	    }

	    $html = '<ul class="navbar-nav mr-auto">' . $this->generateMenuHtml($menuTree) . '</ul>';
	    return $this->response->setBody($html);
	}

	private function generateMenuHtml($menuTree) {
	    $html = '';

	    foreach ($menuTree as $menu) {
	        $new_location = base_url() . $menu->menu_url;
	        $icon = isset($menu->icon_class) ? '<i class="' . $menu->icon_class . '"></i> ' : '';

	        if (!empty($menu->children)) {
	            $html .= '<li class="nav-item dropdown">';
	            $html .= '<a class="nav-link dropdown-toggle" href="#" id="menu-' . $menu->id . '" role="button" data-toggle="dropdown">';
	            $html .= $icon . $menu->menu_name;
	            $html .= '</a>';
	            $html .= '<div class="dropdown-menu" aria-labelledby="menu-' . $menu->id . '">';
	            foreach ($menu->children as $child) {
	                $child_location = base_url() . $child->menu_url;
	                $child_icon = isset($child->icon_class) ? '<i class="' . $menu->id . '"></i> ' : '';
	                $html .= '<a class="dropdown-item" href="' . $child_location . '">' . $child_icon . $child->menu_name . '</a>';
	            }
	            $html .= '</div>';
	            $html .= '</li>';
	        } else {
	            $html .= '<li class="nav-item">';
	            $html .= '<a class="nav-link" href="' . $new_location . '">' . $icon . $menu->menu_name . '</a>';
	            $html .= '</li>';
	        }
	    }

	    return $html;
	}
}
