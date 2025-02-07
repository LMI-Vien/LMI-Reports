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

    public function batch_insert($table, $insert_batch_data){
        if (!is_array($insert_batch_data) || empty($insert_batch_data)) {
            return "Invalid or empty data";
        }
        //$builder = $this->db->table($table);
        try {
            $builder = $this->db->table($table);
            $builder->insertBatch($insert_batch_data);
            $updatedStatus = $this->db->affectedRows();

            return $updatedStatus > 0 ? "success" : "failed";
        } catch (\Exception $e) {
            return "Error: " . $e->getMessage();
        }
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

    public function delete_role_tagging($role_id) {
        $this->db->query('DELETE FROM `cms_menu_roles` WHERE `role_id` = ?', [$role_id]);
        $affected1 = $this->db->affectedRows();

        $this->db->query('DELETE FROM `cms_site_menu_roles` WHERE `role_id` = ?', [$role_id]);
        $affected2 = $this->db->affectedRows();

        if ($affected1 > 0 || $affected2 > 0) {
            return "success";
        } else {
            return "failed";
        }
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

    public function menu_role_insert_site($user_role_id, $role_access) {
        $user_id = session()->sess_uid;
        $insert_rights = array();
        $db      = \Config\Database::connect();
        $builder = $db->table('cms_site_menu_roles');
        foreach($role_access as $role_access_rights) {
            array_push($insert_rights, array(
                'role_id' => $user_role_id,
                'menu_id' => $role_access_rights['menu_id'],
                'menu_role_view' => $role_access_rights['menu_role_view'],
                'menu_role_generate' => $role_access_rights['menu_role_generate'],
                'menu_role_export' => $role_access_rights['menu_role_export'],
                'menu_role_updated_date' => $role_access_rights['menu_role_updated_date'],
                'menu_role_created_date' => $role_access_rights['menu_role_created_date'],
            ));
        }

        $status = $builder->insertBatch($insert_rights);
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
