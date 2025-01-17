<?php

namespace App\Models;

use CodeIgniter\Model;

class Custom_model extends Model
{
    protected $sql;
    protected $WhereClause;
    function get_data_excel($table, $select,$counter,$query = null,$order_column = null, $order_by = null){
        $builder = $this->db->table($table);
        $builder->select($select);
        if($query != null) {
            $builder->where($query);
        }
        if($order_column && $order_by) {
            $builder->orderBy($order_column,$order_by);
        }
        $q = $builder->get();
        return $q->getResult();
    }

    function menu_main_with_pkg($package_name){
        $builder = $this->db->table('cms_menu');
        $builder->where('menu_package_used', $package_name);
        $builder->whereIn('status', array(1, 0));
        $query = $builder->get();
        return $query->countAllResults();
    }

    function menu_sub_with_pkg($package_name){
        $builder = $this->db->table('cms_menu_sub');
        $builder->where('package', $package_name);
        $query = $builder->get();
        return $query->countAllResults();
    }

    function check_pkg($package_name){
        $count = $this->menu_main_with_pkg($package_name);
        return $count;
    }
    function get_menu_list($table,$select, $query){
        $builder = $this->db->table($table);
        $builder->select($select);
        $builder->where($query);
        $builder->join('cms_menu_roles','cms_menu_roles.menu_id = cms_menu.id','left');
        $builder->orderBy('sort_order','acs');
        $result = $builder->get();
        return $result->getResult();

    }

    function update_menu_data($table,$data,$role_id){
        $session = session();
        $insert_rights = array();
        $user_id = $session->sess_uid;
        $db      = \Config\Database::connect();
        $builder = $db->table($table);
        foreach($data as $data_role) {
            array_push($insert_rights, array(
                'role_id' => $role_id,
                'menu_id' => $data_role['menu_id'],
                'menu_role_read' => $data_role['menu_role_read'],
                'menu_role_write' => $data_role['menu_role_write'],
                'menu_role_delete' => $data_role['menu_role_delete'],
                'menu_role_updated_date' => $data_role['menu_role_updated_date'],
                'menu_role_created_date' => $data_role['menu_role_created_date'],
                'created_by' => $user_id,
                'updated_by' => $user_id
            ));
        }

        $status = $builder->insertBatch($insert_rights);
        return $status;
    }

    function delete_user_role($table, $id) {
        $builder = $this->db->table($table);
        $builder->where('id', $id);
        $query = $builder->get();
        $role_name = "";
        foreach ($query->getResult() as $row) {
            $role_id = $row->id;
            $role_name = $row->name;
        }

        
        $selectQuery = $this->db->table("cms_users");
        $selectQuery->where('role', $role_id);
        $query = $selectQuery->get();
        $result = [];

        if($query->countAllResults() > 0) {
            $result = ['message' => $role_name." is currently in use by user.", 'in_use' => 1];
        } else {
            $return = $this->db
                    ->table($table)
                    ->where("id", $id)
                    ->update(['status' => '-2']);
            if($return):
                $result = ['message' => 'Deleted successfully'];
            else:
                $result = ['message' => 'Delete failed'];
            endif;
        }

        return $result;
    }

    function select($table){
        $sql = "Select * From ".$table."";
        $this->sql = $sql;
        return $this;
    }

    function result(){
        $execute = $this->db->query($this->sql);
        return $execute->getResult(); 
    }

    function add_save($table, $ArrySet){
        $SqlResult = $this->db->insert($table, $ArrySet);
        return $SqlResult;
    }
    public function edit_save($table, $ArrySet, $ArryWhere){
        $SqlResult = $this->db->update($table, $ArrySet, $ArryWhere);
        return $SqlResult;
    }

    public function where($clause = '' , $operation = ' and '){
        if ( $clause == '' ) {
            return $this; //error('undefined where clause');
        }
        if( is_array($clause) || is_object($clause) )
        {
            $columns = ''; 
            foreach( $clause as $key => $value )
            {
                $columns .= "  ". $operation ."  " . $key . " = '" . $value . "'";	
            }
            $clause = substr($columns,6);
        }
        
        $this->sql = $this->sql.' where ' .  $clause; 

        $this->WhereClause = $clause;
        return $this;
    }

    public function batch_insert_product_category_tagging($table, $insert_batch_data){
        $this->db->insertBatch($table, $insert_batch_data);
        $updated_status = $this->db->affectedRows();
        if($updated_status):
            return "success";
        else:
            return "failed";
        endif;
    }

    public function batch_insert_article_category($table, $insert_batch_data){
        $this->db->insertBatch($table, $insert_batch_data);
        $updated_status = $this->db->affectedRows();
        if($updated_status):
            return "success";
        else:
            return "failed";
        endif;
    }

    public function batch_insert_cause($table, $insert_batch_data){
        $this->db->insertBatch($table, $insert_batch_data);
        $updated_status = $this->db->affectedRows();
        if($updated_status):
            return true;
        else:
            return false;
        endif;
    }

    public function batch_insert_prevention($table, $insert_batch_data){
        $this->db->insertBatch($table, $insert_batch_data);
        $updated_status = $this->db->affectedRows();
        if($updated_status):
            return true;
        else:
            return false;
        endif;
    }

    public function delete_field_tagging($site_id){
        $this->db->query('DELETE `cms_site_package_field_tagging` FROM `cms_site_package_field_tagging` 
        LEFT JOIN `cms_site_package_tagging` ON `cms_site_package_field_tagging`.`site_package_id` = `cms_site_package_tagging`.`id`
        AND `cms_site_package_tagging`.`site_id` = '.$site_id.'
        WHERE `cms_site_package_tagging`.`site_id` IS NOT NULL');
        
        $updated_status = $this->db->affectedRows();
        if($updated_status > 0):
            return "success";
        else:
            return "failed";
        endif;
    }

    public function delete_role_tagging($role_id){
        $this->db->query('DELETE FROM `cms_menu_roles` WHERE `role_id` = '.$role_id.'');
        
        $updated_status = $this->db->affectedRows();
        if($updated_status > 0):
            return "success";
        else:
            return "failed";
        endif;
    }

    public function users_insert($site_id, $userlist) {
        $insert_user = array();
        $db      = \Config\Database::connect();
        $builder = $db->table('cms_site_user_tagging');
        foreach($userlist as $user) {
            array_push($insert_user, array(
                'site_id' => $site_id,
                'user_id' => $user
            ));
        }

        $builder->insertBatch($insert_user);
        if($builder):
            return true;
        else:
            return false;
        endif;
    }

    public function packages_insert($site_package_id, $packagelist) {
        $insert_package = array();
        $db      = \Config\Database::connect();
        $builder = $db->table('cms_site_package_field_tagging');
        foreach($packagelist as $package) {
            array_push($insert_package, array(
                'site_package_id' => $site_package_id,
                'package_field_id' => $package
            ));
        }
        $status = $builder->insertBatch($insert_package);
        return $status;
    }

    public function menu_role_insert($user_role_id, $role_access) {
        $user_id = session()->sess_uid;
        $insert_rights = array();
        $db      = \Config\Database::connect();
        $builder = $db->table('cms_menu_roles');
        foreach($role_access as $role_access_rights) {
            array_push($insert_rights, array(
                'role_id' => $user_role_id,
                'menu_id' => $role_access_rights['menu_id'],
                'menu_role_read' => $role_access_rights['menu_role_read'],
                'menu_role_write' => $role_access_rights['menu_role_write'],
                'menu_role_delete' => $role_access_rights['menu_role_delete'],
                'menu_role_updated_date' => $role_access_rights['menu_role_updated_date'],
                'menu_role_created_date' => $role_access_rights['menu_role_created_date'],
            ));
        }

        $status = $builder->insertBatch($insert_rights);
        return $status;
    }

    public function seo_status_update($status_update, $ids, $user) {
        $this->db->whereIn("id", $ids);
        $status = $this->db->update('cms_metatags',
        array("meta_status" => $status_update, 'updated_date' => date("Y-m-d H:i:s"), 'updated_by' =>  $user));
        return $status;
    }

    public function get_values($inputs, $package, $table_name, $id, $column) {
        $builder = $this->db->table($table_name)
                            ->select($inputs)
                            ->where($column, $id);
        $query = $builder->get();
        $result = $query->getResultArray();

        $values = array();
        foreach($result as $row) {
            $values = array_values($row);
        }

        return $values;
    }

    public function get_fields($site_id, $package_id, $table_name = NULL, $id = NULL, $is_list = true){
        $builder = $this->db->table('cms_package_field_tagging pf')
                            ->select('field_name, field_column')
                            ->join('cms_site_package_field_tagging spf', 'pf.id = spf.package_field_id', 'LEFT')
                            ->join('cms_site_package_tagging sp', 'sp.id = spf.site_package_id', 'LEFT')
                            ->where('sp.site_id', $site_id)
                            ->where('sp.package_id', $package_id)
                            ->orderBy('pf.sort_order', 'ASC')
                            ->orderBy('pf.id', 'ASC');
        $query = $builder->get();
        $result = $query->getResult();
       
        $inputs = array();
        $columns = array();
        foreach($result as $row) {
            array_push($inputs, $row->field_name);
            array_push($columns, $row->field_column);
        }
       
        if($is_list){
            array_push($inputs, "status");
        }
     
        if($table_name !== NULL) {
            if($is_list)
            {
                array_push($columns, "status");
                $values = $this->get_values($columns, $package_id, $table_name, $id, 'id');
            }
            else
            { 
                
                $values = $this->get_values($columns, $package_id, $table_name, $id, 'site_id');
               
            }
            
            $input_values = array("inputs" => $inputs, "values" => $values);
        
            return $input_values;
        }

        return $inputs;
    }
    

    public function get_package_id($package) {
        $builder = $this->db->table('cms_packages');
        $builder->select('id');
        $builder->where('package_name', $package);
        return $builder->get()->getRow('id');
    }

    public function get_list_columns($package_id, $site_id) {
        $builder = $this->db->table('cms_package_field_tagging pf');
        $builder->select('field_label');
        $builder->join('cms_site_package_field_tagging spf', 'pf.id = spf.package_field_id', 'LEFT');
        $builder->join('cms_site_package_tagging sp', 'sp.id = spf.site_package_id', 'LEFT');
        $builder->where('sp.site_id', $site_id);
        $builder->where('sp.package_id', $package_id);
        $builder->where('pf.is_listed', 1);
        $result = $builder->get();
        $columns = array();
        foreach($result->getResult() as $row) {
            array_push($columns, $row->field_label);
        }
        return $columns;
    }
    public function get_store_type_value($id, $table = "site_partner_stores"){
     
        $builder = $this->db->table($table)
                            ->select('store_query_words,store_link')
                            ->where('id',$id);
                $result = $builder->get();
        return $result->getRow();
    }
    
    public function batch_insert_product_images($table, $insert_batch_data) {
        $builder = $this->db->insertBatch($table, $insert_batch_data);
        $updated_status = $builder->affectedRows();
        if($updated_status):
            return true;
        else:
            return false;
        endif;
    }

    public function batch_delete_media($table, $identifier,  $event_id) {
        $builder =  $this->db->where($identifier, $event_id);
        $builder->delete($table);
        $updated_status = $builder->affectedRows();
        if($updated_status):
            return true;
        else:
            return false;
        endif;
    }
    
    public function batch_insert_ingredient_details($table, $insert_batch_data) {
        $builder = $this->db->insertBatch($table, $insert_batch_data);
        $updated_status = $builder->affectedRows();
        if($updated_status):
            return true;
        else:
            return false;
        endif;
    }

    public function batch_insert_advocacy_slideshow($table, $insert_batch_data) {
        $builder = $this->db->insertBatch($table, $insert_batch_data);
        $updated_status = $builder->affectedRows();
        if($updated_status):
            return true;
        else:
            return false;
        endif;
    }

    public function batch_insert_covid_slideshow($table, $insert_batch_data) {
        $builder = $this->db->insertBatch($table, $insert_batch_data);
        $updated_status = $builder->affectedRows();
        if($updated_status):
            return true;
        else:
            return false;
        endif;
    }

    public function batch_insert_email_recipients($table, $insert_batch_data) {
        $builder = $this->db->insertBatch($table, $insert_batch_data);
        $updated_status = $builder->affectedRows();
        if($updated_status):
            return true;
        else:
            return false;
        endif;
    }

    public function batch_insert_product_subnav($table, $insert_batch_data) {
        $builder = $this->db->insertBatch($table, $insert_batch_data);
        $updated_status = $builder->affectedRows();
        if($updated_status):
            return true;
        else:
            return false;
        endif;
    }

    public function get_center_aligned_columns($package_id, $site_id) {
        $builder = $this->db->table('cms_package_field_tagging pf');
        $builder->select('field_label');
        $builder->join('cms_site_package_field_tagging spf', 'pf.id = spf.package_field_id', 'LEFT');
        $builder->join('cms_site_package_tagging sp', 'sp.id = spf.site_package_id', 'LEFT');
        $builder->where('sp.site_id', $site_id);
        $builder->where('pf.is_center', 1);
        $builder->where('sp.package_id', $package_id);
        $result = $builder->get();
		$inputs = array("date_modified" => 1, "status" => 1);
        foreach($result->getResult() as $row) {
            $field = strtolower(preg_replace('/\s+/', '_', $row->field_label));
            $inputs[$field] = 1;
        }
    
        return json_encode($inputs);
    }	
    public function category_status_update($status_update, $ids, $user) {
        $builder = $this->db->whereIn("id", $ids);
        $status = $builder->update('site_product_categories',
        array("status" => $status_update, 'updated_date' => date("Y-m-d H:i:s"), 'updated_by' =>  $user));
        return $status;
    }

    public function get_user_access($combine_url, $user_role) {
        $builder = $this->db->table('cms_menu');
        $builder->select('cms_menu.id, menu_url,menu_parent_id,menu_level ,status, role_id,cms_menu_roles.menu_id,menu_role_read,menu_role_write,menu_role_delete');
        $builder->join('cms_menu_roles', 'cms_menu_roles.menu_id = cms_menu.id', 'LEFT');
        $builder->where('menu_url', $combine_url);
        $builder->where('status', 1);
        $builder->where('role_id', $user_role);
        $result = $builder->get();

        return $result->getResult();
    }

    public function get_controller_url() {
        $url =  "http://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
        $splice_index = 3;
        if(strpos($url,"webqa.unilab.com.ph") !== false || strpos($url,"lactezin.com") !== false){
            $splice_index = 3;
        }
        $escaped_url = htmlspecialchars( $url, ENT_QUOTES, 'UTF-8' );
        $urls = explode('/', $escaped_url);
        $remove_base_url = array_splice($urls,$splice_index);
        $limit_url = count($remove_base_url);
        $combine_url = "";
        if($limit_url >= 3 ){
            if($remove_base_url[1] == 'Cms_menu' || $remove_base_url[1] == 'Site_menu' || $remove_base_url[1] == 'Preference' || $remove_base_url[1] == 'Documentation'){
                $combine_url = $remove_base_url[0].'/'.$remove_base_url[1].'/'.$remove_base_url[2];
                if($remove_base_url[2] == 'menu_add' || $remove_base_url[2] == 'menu_update'){
                    $set_last_index = 'menu';
                    $combine_url = $remove_base_url[0].'/'.$remove_base_url[1].'/'.$set_last_index;
                }
            }else {
                $combine_url = $remove_base_url[0].'/'.$remove_base_url[1];
            }
        }else {
            $combine_url = implode("/",$remove_base_url);
        }
        $new_location = str_replace("dynamic","content_management",$combine_url);
        return $new_location;
    }
    public function get_package_sortable($package) {
        $builder = $this->db->table('cms_packages');
        $builder->select('sortable');
        $builder->where('package_name', $package);
        return $builder->get()->getRow('sortable');
    }

    public function insert_section($table, $site_id, $user_id) {
        if($table == "site_template") {
            $type = 1;
            $home_about_display_name = "About Product";
            if($site_id == 1) {
                $type = 0;
                $home_about_display_name = "Home";
            }
            $SqlResult = $this->db->table($table)->insert(array(
                'site_id' => $site_id, 
                'type' => $type,
                'home_about_display_name' => $home_about_display_name,
                'created_date' => date("Y-m-d H:i:s"), 
                'created_by' => $user_id
            ));
        } else {
            $SqlResult = $this->db
			 	->table($table)
			 	->insert(array('site_id' => $site_id, 'created_date' => date("Y-m-d H:i:s"), 'created_by' => $user_id));
        }			
        return $SqlResult;
    }
    
    public function batch_insert_media($table, $insert_batch_data) {
       $builder = $this->db->insertBatch($table, $insert_batch_data);
        $updated_status = $builder->affectedRows();
        if($updated_status):
            return true;
        else:
            return false;
        endif;
    }
    
    public function batch_insert_related_products($table, $insert_batch_data) {
        $builder = $this->db->insertBatch($table, $insert_batch_data);
        $updated_status = $builder->affectedRows();
        if($updated_status):
            return true;
        else:
            return false;
        endif;
    }

    public function batch_insert_related_programs($table, $insert_batch_data) {
        $builder = $this->db->insertBatch($table, $insert_batch_data);
        $updated_status = $builder->affectedRows();
        if($updated_status):
            return true;
        else:
            return false;
        endif; 
    }

    public function get_email_recipients($id) {
        $builder = $this->db->table('site_email_recipients');
        $builder->select('id, type, email_address');
        $builder->where('email_id', $id);
        $result = $builder->get();

        return $result->getResult();
    }

    public function manual_query($query = null) {
        $google_analytics = \Config\Database::connect('analytics');
        $result = $google_analytics->query($query);
        $google_analytics->close();
        return $result->getResult();
    }


    public function get_list_fields($table){
        $db_fields = $this->db->getFieldNames($table);
        return $db_fields;
    }

    public function get_row_data($table, $select, $route_id, $query = null)
    {
        $builder = $this->db->table($table);

        $builder->select($select);

        $builder->where($this->primaryKey, $route_id);
        if ($query) {
            foreach ($query as $key => $value) {
                $builder->where($key, $value);
            }
        }
        $queryResult = $builder->get();
        return $queryResult->getRow();
    }
}
