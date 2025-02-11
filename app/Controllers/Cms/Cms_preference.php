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
		$select = 'cms_menu.id,menu_url,menu_name,menu_icon,menu_type,menu_parent_id,menu_level,sort_order,status,role_id,menu_id,menu_role_read,menu_role_write,menu_role_delete';
		$query = 'status = 1 AND role_id = '.$session->sess_role.' AND menu_level = 1 AND menu_role_read = 1';
		$result = $this->Custom_model->get_menu_list('cms_menu',$select,$query);
		$html = '';
		foreach ($result as $key => $value) 
		{
			$new_location = str_replace("content_management","dynamic",$value->menu_url);
			$html .= '<li class="treeview menu_checker_'.$value->id.'">';
          	$html .= '<a class="side_drop " href="'.base_url().$new_location.'">';
          	$html .= '  <i class="'.$value->menu_icon.'"></i> <span>'.strtoupper($value->menu_name).'</span>';
			if($value->menu_type == 1){
			    $html .= '  <span class="pull-right-container">';
			    $html .= '    <i class="fa fa-angle-left pull-right"></i>';
			    $html .= '  </span>';
			}
          	$html .= '</a>';
          	if($value->menu_type == 1)
          	{
          		$this->get_sub_menu($value->id);
            	$html .= $this->submenu;
			}
			$html .= '</li>';


		}
		echo json_encode($html);
	}
    public function get_sub_menu($id)
	{
        $session = session();
		$select = 'cms_menu.id,menu_url,menu_name,menu_icon,menu_type,menu_parent_id,menu_level,sort_order,status,role_id,menu_id,menu_role_read,menu_role_write,menu_role_delete';
		$query = 'status = 1 AND role_id = '.$session->sess_role.' AND menu_role_read = 1 AND menu_parent_id ='.$id.'';
		$result = $this->Custom_model->get_menu_list('cms_menu',$select,$query);
		$html = '';

		$html .= '<ul class="treeview-menu sub_menu">';
        foreach ($result as $key => $value) 
		{
			$new_location = str_replace("content_management","dynamic",$value->menu_url);
            $html .= '     <li class="treeview menu_checker_'.$value->id.'"><a class="side_drop " href="'.base_url().$new_location.'"> ';
            $html .= '   <span>'.strtoupper($value->menu_name).'</span>';
            if($value->menu_type == 1){
				$html .= '  <span class="pull-right-container">';
				$html .= '    <i class="fa fa-angle-left pull-right"></i>';
				$html .= '  </span>';
            }
            $html .= '       </a>';
            if($value->menu_type == 1)
            {
            	$this->get_sub_menu($value->id);
                $html .= $this->submenu;
            }
            $html .= '     </li>';
        }
        $html .= '</ul>';

        $this->submenu = $html;
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
		$select = 'id, menu_url, menu_name, menu_type, menu_parent_id';
		$query = 'status = 1';
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
	
		$html = '<ul class="navbar-nav">' . $this->generateMenuHtml($menuTree) . '</ul>';
		return $this->response->setBody($html); 
	}
	
	private function generateMenuHtml($menuTree) {
		$html = '';
	
		foreach ($menuTree as $menu) {
			$new_location = str_replace("content_management", "dynamic", $menu->menu_url);
			if (!empty($menu->children)) {
				$html .= '
				<li class="nav-item dropdown">
					<a href="#" class="nav-link dropdown-toggle" id="menu-'.$menu->id.'" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						'.($menu->menu_name).'
					</a>
					<ul class="dropdown-menu" aria-labelledby="menu-'.$menu->id.'">
						'.$this->generateMenuHtml($menu->children).'
					</ul>
				</li>';
			} else {
				$html .= '<li class="nav-item"><a class="nav-link" href="'.base_url().$new_location.'">'.($menu->menu_name).'</a></li>';
			}
		}
	
		return $html;
	}
}
