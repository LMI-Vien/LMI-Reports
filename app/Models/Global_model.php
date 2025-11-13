<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\Database\Exceptions\DatabaseException;
use App\Libraries\ClickhouseClient;

class Global_model extends Model
{
    function check_sess() {
        $session = session();
        if($session->sess_user !='') { 
            return true;
        } else {
            return false;
        }
    }

    function validate_log($user, $pass) { 
        // Get user record
        $builder = $this->db->table('cms_users')
                            ->select('password, salt')
                            ->where('username', $user);
        $query = $builder->get();
        $result = $query->getRow(); 

        if (!$result) {
            return null;
        }

        $salted_password = hash('sha256', $pass . $result->salt);

        if (password_verify($salted_password, $result->password)) {
            return $this->db->table('cms_users')
                            ->where('username', $user)
                            ->get()
                            ->getRow();
        } else {
            return null;
        }   
    }

    function validate_log_email($email, $pass) { 
        // Get user record
        $builder = $this->db->table('cms_users')
                            ->select('password, salt')
                            ->where('dashboard_access', 1)
                            ->where('email', $email);
        $query = $builder->get();
        $result = $query->getRow(); 

        if (!$result) {
            return null;
        }

        $salted_password = hash('sha256', $pass . $result->salt);

        if (password_verify($salted_password, $result->password)) {
            return $this->db->table('cms_users')
                            ->where('email', $email)
                            ->get()
                            ->getRow();
        } else {
            return null;
        }   
    }

    function validate_log_report_user($user, $pass) { 
        $builder = $this->db->table('tbl_report_users')
                            ->select('password')
                            ->where('email', $user);
        $query = $builder->get();
        $result = $query->getResult();
        $saltedpassword = hash('sha256', $pass.'89B6089108oI0409');
            
        if($result){
            $storedpass = $result[0]->password;
            $options = ['cost' => 12];
            $hash = password_hash($saltedpassword, PASSWORD_DEFAULT, $options);
            if (password_verify($storedpass, $hash)){
                $selectQuery = $this->db->table('tbl_report_users')
                                        ->where('email', $user)
                                        ->where('password', $storedpass); 

                $fquery = $selectQuery->get();
                return $fquery->getResult();
            }else{
                return null;
            } 
        }else{
            return null;
        }
    }

    function check_user($user){
        $builder = $this->db->table('cms_users')
                            ->select('id,username,status,user_error_logs,user_block_logs,user_lock_time,email,role')
                            ->where('username', $user)
                            ->where('status >= ', 0);
        $query = $builder->get();
        return $query->getResult();
    }

    function check_email($email)
    {
        
        $builder = $this->db->table('cms_users')
                            ->where('email', $email)
                            ->where('status', 1);   
        $query = $builder->get();
        return $query->getResult();

    }

    function check_password($password, $user_id)
    {
        $builder = $this->db->table('cms_users')
                            ->where('id', $user_id)
                            ->where('password', $password)
                            ->where('status', 1);   
        $query = $builder->get();
        return $query->getResult();

    }

    function is_activated($username, $password)
    {
        $builder = $this->db->table('cms_users')
                            ->select('password, salt')
                            ->where('username', $username);
        $query = $builder->get();
        $result = $query->getResult();

        $saltedpassword = hash('sha256', $password.$result[0]->salt);
        $storedpass = $result[0]->password;
        $options = ['cost' => 12];

        $hash = password_hash($saltedpassword, PASSWORD_DEFAULT, $options);
        if (password_verify($storedpass, $hash)) {
            
            $selectQuery = $this->db->table('cms_users')
                                    ->where('username', $username)
                                    ->where('password', $storedpass)
                                    ->where('status', 1);
            $fquery = $selectQuery->get();

            return $fquery->getResult();
        } else {
            return null;
        }   
    }
    
    function get_by_id($table, $id) {
        $builder = $this->db->table($table)
                            ->where("id", $id);
        $q = $builder->get();
        return $q->getResult();
    }

    function get_by_name($table, $selectFields, $name, $join = null) {
        $builder = $this->db->table($table)->select($selectFields);

        if (!empty($join) && is_array($join)) {
            foreach ($join as $vl) {
                $builder->join($vl['table'], $vl['query'], $vl['type'] ?? 'inner');
            }
        }

        $fieldParts = explode(',', $selectFields);
        $firstField = trim($fieldParts[0]);

        $fieldName = preg_replace('/\s+AS\s+\w+$/i', '', $firstField);

        return $builder->where($fieldName, $name)->get()->getResult();
    }



    function get_by_menu_url($url) {
        $builder = $this->db->table('site_menu')
                            ->where("menu_url", $url);
        $q = $builder->get();
        return $q->getResult();
    }

    function get_by_site_id($table, $id) {
        $builder = $this->db->table($table)
                            ->where("site_id", $id);
        $q = $builder->get();
        return $q->getResult();
    }
    function get_by_list_where_not_in($table,$ids,$where=null)
    {
        $builder = $this->db->table($table);
        if($where)
        {
            $builder->where($where);
        }
        $builder->whereNotIn('id', $ids);

        $query  = $builder->get();

        return $query->getResult();

    }

    function get_list_query_sort($table, $query,$orderBy,$sort)
    {
        
        $builder = $this->db->table($table)
                            ->where($query)
                            ->orderBy($orderBy,$sort);
        $q = $builder->get();
        return $q->getResult();
    }

    function get_list_all($table)
    {
        $builder = $this->db->table($table);
        $q = $builder->get();
        return $q->getResult();
    }

    function get_list_query($table, $query)
    {
        
        $builder = $this->db->table($table)
                            ->where($query);
        $q = $builder->get();
        return $q->getResult();
    }

    function get_list_menu($table, $query)
    {
        
        $builder = $this->db->table($table)
                            ->where($query)
                            ->orderBy("sort_order","asc");
        $q = $builder->get();
        return $q->getResult();
    }

    function get_users_model($table)
    {
        
        $builder = $this->db->table($table)
                            ->where('status >=',0);
        $q = $builder->get();
        return $q->getResult();
    }

    public function getDistinctVmiDataClickhouse($type = 'sku', $limit = 50)
    {
        $ch = new \App\Libraries\ClickhouseClient();

        $params = [
            'limit' => (int)$limit,
        ];

        switch ($type) {
            case 'sku':
                $sql = "
                    SELECT DISTINCT itmcde
                    FROM sfa_db.tbl_vmi_pre_aggregated_data
                    WHERE itmcde IS NOT NULL AND TRIM(itmcde) != ''
                    ORDER BY itmcde ASC
                    LIMIT {limit:Int32}
                    FORMAT JSON
                ";
                break;

            case 'variant':
                $sql = "
                    SELECT DISTINCT item_name
                    FROM sfa_db.tbl_vmi_pre_aggregated_data
                    WHERE item_name IS NOT NULL AND TRIM(item_name) != ''
                    ORDER BY item_name ASC
                    LIMIT {limit:Int32}
                    FORMAT JSON
                ";
                break;

            case 'store':
                $sql = "
                    SELECT DISTINCT store_code, store_name
                    FROM sfa_db.tbl_vmi_pre_aggregated_data
                    WHERE store_code IS NOT NULL AND TRIM(store_code) != ''
                    ORDER BY store_code ASC
                    LIMIT {limit:Int32}
                    FORMAT JSON
                ";
                break;

            default:
                throw new \InvalidArgumentException('Invalid type provided. Use: sku, variant, or store.');
        }

        // Execute ClickHouse query
        $rows = $ch->query($sql, $params);

        return $rows;
    }
    
    function get_data_list($table, $query = null, $limit = 99999, $start = 0, $select = "*", $order_field = null, $order_type = null, $join = null, $group = null)
    {
        $builder = $this->db->table($table);
        $builder->select($select);

        if ($query != null) {
            $builder->where($query);
        }

        if ($join != null) {
            foreach ($join as $vl) {
                $builder->join($vl['table'], $vl['query'], $vl['type']);
            }
        }

        if ($order_field != null) {
            if (is_array($order_field)) {
                foreach ($order_field as $index => $field) {
                    $direction = isset($order_type[$index]) ? $order_type[$index] : 'asc';
                    $builder->orderBy($field, $direction);
                }
            } else {
                $builder->orderBy($order_field, $order_type);
            }
        }

        if ($group != null) {
            $builder->groupBy($group);
        }

        $builder->limit($limit, $start);
        $q = $builder->get();
        return $q->getResult();
    }

    public function count_data_list($table, $where = null, $join = null, $group = null)
    {
        $builder = $this->db->table($table);

        if($join != null){
            foreach ($join as $key => $vl) {
                $builder->join($vl['table'],$vl['query'],$vl['type']);
            };
        }
        if ($where) {
            $builder->where($where);
        }
        if ($group) {
            $builder->groupBy($group);
            return count($builder->get()->getResult());
        } else {
            return $builder->countAllResults();
        }
    }

    // public function get_vmi_grouped_with_latest_updated($query = null, $limit = 100, $offset = 0)
    // {
    //     $filter_inner = $query ? "AND $query" : "";
    //     $filter_outer = $query ? "AND " . $this->prefixFilterWithAlias($query) : "";

    //     $sql = "
    //         SELECT 
    //             c.name AS company,
    //             y.year,
    //             v.week,
    //             v.created_date,
    //             v.updated_date,
    //             v.year AS filter_year,
    //             v.company AS filter_company,
    //             u.name AS imported_by
    //         FROM (
    //             SELECT *, ROW_NUMBER() OVER (PARTITION BY year, week, company ORDER BY updated_date DESC) AS rn
    //             FROM tbl_vmi
    //             WHERE 1=1 $filter_inner
    //         ) v
    //         LEFT JOIN cms_users u ON u.id = v.created_by
    //         LEFT JOIN tbl_company c ON c.id = v.company
    //         LEFT JOIN tbl_year y ON y.id = v.year
    //         WHERE v.rn = 1 $filter_outer
    //         ORDER BY v.updated_date DESC
    //         LIMIT $limit OFFSET $offset
    //             ";

    //     return $this->db->query($sql)->getResult();
    // }

    // private function prefixFilterWithAlias($query, $alias = 'v') {
    //     // Matches columns at the beginning or after AND/OR
    //     return preg_replace_callback('/(?<!\.)\b(year|week|company)\b/', function ($matches) use ($alias) {
    //         return $alias . '.' . $matches[1];
    //     }, $query);
    // }


    // public function count_vmi_grouped_with_latest_updated($query = null)
    // {
    //     $filter = $query ? "AND $query" : "";

    //     $sql = "
    //         SELECT COUNT(*) AS total
    //         FROM (
    //             SELECT 1
    //             FROM tbl_vmi
    //             WHERE 1=1 $filter
    //             GROUP BY year, week, company
    //         ) AS grouped
    //     ";

    //     $result = $this->db->query($sql)->getRow();
    //     return $result->total ?? 0;
    // }

    public function get_per_store_grouped($query = null, $limit = 99999, $offset = 0)
    {
        $sql = "
            SELECT *
            FROM (
                SELECT 
                    ps.id,
                    ps.year,
                    ps.status,
                    ps.created_date,
                    ps.updated_date,
                    b.year as filter_year,
                    u.name AS imported_by,
                    u.id AS imported_by_id,
                    ROW_NUMBER() OVER (
                        PARTITION BY ps.year, ps.status
                        ORDER BY ps.updated_date DESC
                    ) AS row_num
                FROM tbl_target_sales_per_store ps
                LEFT JOIN cms_users u ON u.id = ps.created_by
                LEFT JOIN tbl_year b ON b.id = ps.year
                " . ($query ? "WHERE $query" : "") . "
            ) t
            WHERE row_num = 1
            LIMIT $offset, $limit
        ";

        return $this->db->query($sql)->getResult();
    }

    function check_db_exist($table, $conditions = [], $limit = 1, $start = 0, $select = "*", $order_field = null, $order_type = 'asc', $join = null, $group = null, $params = [], $useOr = false, $action = null)
    {
        $builder = $this->db->table($table);
        $builder->select($select);

        if (!empty($conditions) && is_array($conditions)) {
            $totalConditions = count($conditions);

            $groupSize = max(1, $totalConditions - 1);
            if($action == "edit"){
                $groupSize = max(1, $totalConditions - 2);
            }
            
            $groupedConditions = array_slice($conditions, 0, $groupSize);
            $remainingConditions = array_slice($conditions, $groupSize);

            if (!empty($groupedConditions)) {
                $builder->groupStart();
                foreach ($groupedConditions as $index => $condition) {
                    if ($index === 0) {
                        $builder->where($condition[0], $condition[1]);
                    } else {
                        if ($useOr == 'true') {
                            $builder->orWhere($condition[0], $condition[1]);
                        } else {
                            $builder->where($condition[0], $condition[1]);
                        }
                    }
                }
                $builder->groupEnd();
            }

            foreach ($remainingConditions as $condition) {
                $builder->where($condition[0], $condition[1]);
            }
        }
        
        if ($join != null) {
            foreach ($join as $vl) {
                $builder->join($vl['table'], $vl['query'], $vl['type']);
            }
        }

        if ($order_field != null) {
            $builder->orderBy($order_field, $order_type);
        }

        if ($group != null) {
            $builder->groupBy($group);
        }

        $builder->limit($limit, $start);
        $query = $builder->getCompiledSelect();
        $q = $this->db->query($query, $params);

        return $q->getResult();
    }

    function get_data_list_count($select, $table, $query = null, $offset = 0, $join = null)
    {
        $builder = $this->db->table($table);
        $builder->select($select);
        if($query){
            $builder->where($query);
        }
        
        if($join){
            foreach ($join as $key => $vl) {
                $builder->join($vl['table'],$vl['query'],$vl['type']);
            };
        }
        $builder->limit(999999, ($offset - 1) * 999999);
        return $builder->countAllResults();
    }

    function save_data($table, $data)
    {
        $return = $this->db
                ->table($table)
                ->insert($data);
        if($return):
            return $this->db->insertID();
        else:
            return "failed";
        endif;
    }

    function update_data($table,$data,$field,$where)
    {
        $return = $this->db
                    ->table($table)
                    ->where($field, $where)
                    ->update($data);
        if($return):
            return "success";
        else:
            return "failed";
        endif;
    }

    function update_data_custom_where($table, $data, $where_clause) {
        $builder = $this->db->table($table);
        $builder->where($where_clause, null, false);
        return $builder->update($data);
    }

    function total_delete($table,$field,$where)
    {
        $return = $this->db
                ->table($table)
                ->where($field, $where)
                ->delete();
        if($return):
            return "success";
        else:
            return "failed";
        endif;
        // return "$table,$field,$where";
    }

    public function delete_where($table, $where)
    {
        try {
            return $this->db->table($table)->where($where)->delete();
        } catch (\Exception $e) {
            log_message('error', 'Delete failed: ' . $e->getMessage());
            return false;
        }
    }

    public function update_where($table, $data, array $where)
    {
        try {
            return $this->db->table($table)->where($where)->update($data);
        } catch (\Exception $e) {
            log_message('error', 'Update failed: ' . $e->getMessage());
            return false;
        }
    }

    public function batch_update($table, $data, $primaryKey, $get_code = null, $where_in = null) {
        if (empty($table) || empty($data) || empty($primaryKey) || empty($where_in)) {
            return false; // Return false instead of string for consistency
        }
        // Prepare batch update data and collect updated IDs
        $updateData = [];
        $updatedIds = []; // To store the updated primary keys 

        foreach ($data as $row) {
            if (isset($row[$primaryKey]) && in_array($row[$primaryKey], $where_in)) {
                $updateData[] = $row;

                $entry = ['id' => $row[$primaryKey]];

                // Include 'code' if required
                if ($get_code === true && isset($row['code']) || $get_code == 'true' && isset($row['code'])) {
                    $entry['code'] = $row['code'];
                }

                $updatedIds[] = $entry; // Store unique updated entries
            }
        }

        if (empty($updateData)) {
            return false;
        }

        // Perform batch update
        $result = $this->db->table($table)->updateBatch($updateData, $primaryKey);
        return $result ? $updatedIds : false;
    }

    function batch_sort_update_data($table,$data,$field,$where)
    {
        $return = $this->db
                    ->table($table)
                    ->set('sort_order', $data)
                    ->where($field, $where)
                    ->update();
        if($return):
            return "success";
        else:
            return "failed";
        endif;
    }
    
    function delete_data($table, $id)
    {
        $return = $this->db
                ->table($table)
                ->where("id", $id)
                ->delete();
        if($return):
            return "success";
        else:
            return "failed";
        endif;
    }
    
    function tagging_delete_data($table, $id)
    {
        $return = $this->db
                        ->table($table)
                        ->where("site_id", $id)
                        ->delete();
                if($return):
                    return "success";
                else:
                    return "failed";
                endif;
    }

    function tagging_delete_email_recipient($table, $id)
    {
        $return = $this->db
                        ->table($table)
                        ->where("email_id", $id)
                        ->delete();
                if($return):
                    return "success";
                else:
                    return "failed";
                endif;
    }

    function get_admin(){
        $builder = $this->db->table('cms_users')
                            ->whereIn('status', [1, 2]);
        $query = $builder->get();
        return $query->getResult();
    }


    function db_search($search_values)
    {
        $table_fields = array();
        $cumulative_results = array();

        $result = $this->db->query("
            SELECT TABLE_NAME, COLUMN_NAME, DATA_TYPE
            FROM  `INFORMATION_SCHEMA`.`COLUMNS` 
            WHERE  `TABLE_SCHEMA` =  '".$this->db->database."'
            AND `DATA_TYPE` IN ('varchar', 'char', 'text')
            ")->getResultArray();
        
        foreach ( $result  as $o ) 
        {
            $table_fields[$o['TABLE_NAME']][] = $o['COLUMN_NAME'];          
        }
        
        foreach($table_fields as $table_name => $fields)
        {
            $search_array = array();
            foreach($fields as $field)
            {
                $search_array[] = " `{$field}` LIKE '{$search_values}' ";
            }

            $search_string = implode (' OR ', $search_array);
            $query_string = "SELECT * FROM `{$table_name}` WHERE {$search_string}";
            
            $table_results = $this->db->query($query_string)->getResultArray();       
            $cumulative_results = array_merge($cumulative_results, $table_results);
        }
        
        return $cumulative_results;
    }

    function email_notif_enabled_admins($field = null)
    {
        $builder = $this->db->table('cms_users')
                           ->where('status', 1);
        if ($field == 'notif_contactus') {
            $builder->where('notif_contactus', 1);
        }
        if ($field == 'notif_signup') {
            $builder->where('notif_signup', 1);
        }
        $query = $this->db->get();
        return $query->getResult();
    }


    function get_historical_passwords($user_id, $password)
    {
        $builder = $this->db->table('cms_users')
                            ->select('salt')
                            ->where('id', $user_id);
        $query  = $builder->get();
        $result = $query->getResult();
        $saltedpassword = hash('sha256', $password.$result[0]->salt);

        $builder2 = $this->db->table('cms_historical_passwords')
                            ->where('user_id', $user_id)
                            ->where('password', $saltedpassword);
        $fquery = $builder2->get();
        return $fquery->getResult();
    }

    function update_package($table,$data,$field,$where)
    {
        $return = $this->db
                            ->table($table)
                            ->set($data)
                            ->where($field, $where)
                            ->update();
                    if($return):
                        return "success";
                    else:
                        return "failed";
                    endif;
    }
    function get_last_order($table_name)
    {
        $query = $this->db->query("SELECT MAX(`sort_order`) AS last_order FROM $table_name");
        $data = $query->getRow();
        return $data;
    }

    function get_menu($default = TRUE)
    {
        $builder = $this->db->table("site_menu");
        $builder->select("id, menu_url, menu_name, menu_parent_id, menu_type, url_behavior");
        if($default) {
            $builder->where("default_menu", 0);
        }
        $builder->where("status", 1);
        $builder->orderBy("sort_order", "ASC");

        return $builder->get()->getResultArray();
    }

    function get_site_icon($site_id)
    {
        $builder =  $this->db->table("site_information")   
                            ->select("site_logo")
                            ->where("site_id", $site_id);
        return $builder->get()->getRowArray()["site_logo"];
    }

    function get_site_id($site_name)
    {
        $builder =  $this->db->table('cms_sites')
                            ->select('id')
                            ->where('site_url', $site_name)
                            ->where('status', 1);
        $row = $builder->get()->getRow();

        if(isset($row)) {
            return $row->id;
        }else{
            return 0;
        }
        
    }

    function get_site_name($site_id)
    {
        $builder = $this->db->table('cms_sites')
                            ->select('id, site_name')
                            ->where('id', $site_id)
                            ->where('status', 1);
        $row = $builder->get()->getRow();
        if(isset($row)) {
            return $row->site_name;
        }else{
            return 0;
        }
    }

    function get_password_salt($user_id) {
        $builder = $this->db->table('cms_users')
                            ->select('salt')
                            ->where('id', $user_id);
        $query  = $builder->get();
        $result = $query->getResult();
        return $result[0]->salt;
    }


    function list_tables()
    {
        return $this->db->listTables();
    }

    function list_fields($table)
    {
        return $this->db->getFieldNames($table);
    }
    function check_field($table, $field, $path)
    {
        $builder = $this->db->table($table);
        $builder->like($field, $path);
        $query = $builder->get();
        return $query->getNumRows();
    }
    function count_list($table)
    {
        $builder = $this->db->table($table);
        $query = $builder->get();
        return $query->getNumRows();
    }

    function get_field_values($table, $field, $search_field, $ids)
    {
        if (empty($table) || empty($field) || empty($ids) || !is_array($ids)) {
            return [];
        }

        $query = $this->db->table($table)
                          ->select("id, $field") 
                          ->whereIn($search_field, $ids)
                          ->get();

        $results = [];
        foreach ($query->getResult() as $row) {
            $results[$row->id] = $row->$field;
        }

        return $results;
    }

    function list_existing($table, $selected_fields, $haystack, $needle)
    {
        if (empty($table) || empty($selected_fields)) {
            return ['status' => 'error', 'message' => 'Table or allowed fields are not set.'];
        }

        if (empty($haystack) || empty($needle)) {
            return ['status' => 'error', 'message' => 'Invalid input parameters.'];
        }

        $builder = $this->db->table($table);
        $builder->select($selected_fields);

        // Start dynamic condition building
        $builder->groupStart();
        foreach ($needle as $values) {
            $builder->orGroupStart(); // Start an OR group for each needle set
            foreach ($values as $keyIndex => $value) {
                if (isset($haystack[$keyIndex])) {
                    $builder->orWhere($haystack[$keyIndex], $value);
                    $builder->where('status >=', '0');
                }
            }
            $builder->groupEnd(); // Close OR group
        }
        $builder->groupEnd();

        $query = $builder->get();
        $existingRecords = $query->getResultArray();

        if (!empty($existingRecords)) {
            $filteredRecords = [];
            foreach ($existingRecords as $record) {
                $matchedFields = [];
                foreach ($haystack as $field) {
                    if (isset($record[$field]) && in_array($record[$field], array_column($needle, array_search($field, $haystack)))) {
                        $matchedFields[$field] = $record[$field];
                    }
                }

                if (!empty($matchedFields)) {
                    $filteredRecords[] = $matchedFields;
                }
            }

            if (!empty($filteredRecords)) {
                $errorMessage = '';
                foreach ($filteredRecords as $record) {
                    $errorMessage .= "⚠️ Existing Record Found: ";
                    foreach ($record as $field => $value) {
                        $errorMessage .= "<b>" . ucfirst($field) . ": " . esc($value) . "</b>, ";
                    }
                    $errorMessage = rtrim($errorMessage, ', ') . " ⚠️<br>";
                }

                return [
                    'status' => 'error',
                    'message' => $errorMessage,
                    'existing' => $filteredRecords
                ];
            }
        }
        return ['status' => 'success', 'message' => 'No duplicates found.'];
    }

    public function fetch_existing($table, $selected_fields, $field = null, $value = null, $status = false)
    {
        if (empty($table) || empty($selected_fields)) {
            return [];
        }

        $builder = $this->db->table($table);
        $builder->select($selected_fields);
        if($status == 'true' || $status === true){
            $builder->where('status >=', 0);            
        }

        if($field){
            $builder->where($field, $value);
        }

        return $builder->get()->getResultArray();
    }

    public function fetch_existing_new($table, $selected_fields, $filters = [], $field_filter = null, $field = null, $value = null, $status = false)
    {
        if (empty($table) || empty($selected_fields)) {
            return [];
        }

        $builder = $this->db->table($table);
        $builder->select($selected_fields);

        if ($status == 'true' || $status === true) {
            $builder->where('status >=', 0);            
        }

        if ($field) {
            $builder->where($field, $value);
        }

        if (!empty($filters)) {

            if (count($filters) === count($field_filter)) {
                $conditions = [];
                foreach ($field_filter as $index => $columnName) {
                    $conditions[$columnName] = $filters[$index]; 
                }
                $builder->groupStart()->Where($conditions)->groupEnd();
            }
        }

        $query = $builder->get();

        return $query->getResultArray();
    }


    public function fetch_existing2($table, $selected_fields, $match_fields, $valid_data, $status = false) 
    {
        if (empty($table) || empty($selected_fields) || empty($valid_data) || empty($match_fields)) {
            return [];
        }

        $builder = $this->db->table($table);
        $builder->select(array_merge(['id'], $match_fields));

        if ($status == 'true' || $status === true) {
            $builder->where('status >=', 0);            
        }

        // Use OR conditions to fetch only relevant records
        $builder->groupStart();
        foreach ($valid_data as $row) {
            $conditions = [];
            foreach ($match_fields as $field) {
                $conditions[$field] = $row[$field] ?? '';
            }
            $builder->orWhere($conditions);
        }
        $builder->groupEnd();

        return $builder->get()->getResultArray();
    }
    
    public function fetch_existing_custom($table, $select, $field = null, $value = null, $lookup_field = null)
    {
                $builder = $this->db->table($table);
                $builder->select($select);
                $builder->where($field, $value);
                $query = $builder->get();
                
                // Send back the result
                if ($query->getNumRows() > 0) {
                    $data = $query->getResultArray();
                    return json_encode(['data' => array_column($data, $lookup_field)]);
                } else {
                    return json_encode(['data' => []]);
                }
    }

    public function batch_delete($table, $field, $field_value, $where_in){
        $builder = $this->db->table($table);
        $builder->whereIn($field, $field_value);
        $result = $builder->delete();
        if ($result) {
            return json_encode(['message' => 'success']);
        } else {
            return json_encode(['message' => 'failed']);
        }
    }

    public function batch_delete_with_conditions($table, $conditions) {
        $builder = $this->db->table($table);
        foreach ($conditions as $cond) {
            if (isset($cond['field'], $cond['values']) && is_array($cond['values'])) {
                $builder->whereIn($cond['field'], $cond['values']);
            }
        }

        $result = $builder->delete();

        if ($result) {
            return json_encode(['message' => 'success']);
        } else {
            return json_encode(['message' => 'failed']);
        }
    }

    public function clickhouse_batch_delete($table, $conditions = [])
    {
        $clickhouse = new ClickhouseClient();
        $chClient = $clickhouse->client;

        if (empty($conditions)) {
            return json_encode(['message' => 'No conditions provided. Aborting delete.']);
        }

        $whereParts = [];

        foreach ($conditions as $field => $value) {
            if (is_array($value) && !empty($value)) {
                $escapedValues = array_map(function ($v) {
                    return is_numeric($v) ? $v : "'" . addslashes($v) . "'";
                }, $value);
                $whereParts[] = "{$field} IN (" . implode(',', $escapedValues) . ")";
            } elseif ($value !== null) {
                $val = is_numeric($value) ? $value : "'" . addslashes($value) . "'";
                $whereParts[] = "{$field} = {$val}";
            }
        }

        if (empty($whereParts)) {
            return json_encode(['message' => 'No valid conditions found. Aborting delete.']);
        }

        $whereSql = implode(' AND ', $whereParts);
        $sql = "ALTER TABLE {$table} DELETE WHERE {$whereSql}";

        try {
            $chClient->write($sql);
            return json_encode([
                'message' => 'success',
                'sql' => $sql,
                'conditions' => $conditions
            ]);
        } catch (\Exception $e) {
            return json_encode([
                'message' => 'failed',
                'error' => $e->getMessage()
            ]);
        }
    }

    function get_valid_records($table, $columns) {
        $columns = (array) $columns;

        array_unshift($columns, 'id');

        $results = $this->db->table($table)
            ->select($columns)
            ->where('status', 1)
            ->get()
            ->getResultArray();

        return array_map(function ($row) use ($columns) {
            foreach ($columns as $column) {
                if (isset($row[$column]) && is_string($row[$column])) {
                    $row[$column] = trim($row[$column]);
                }
            }
            return $row;
        }, $results);
    }

    function get_valid_records_as_of_today($table, $columns)
    {
        $columns = (array) $columns;
        array_unshift($columns, 'id');

        $currentDate = date('Y-m-d');

        $row = $this->db->table($table)
            ->selectMax('effectivity_date', 'latest_effectivity_date')
            ->where('effectivity_date <=', $currentDate)
            ->get()
            ->getRow();

        if (!$row || !$row->latest_effectivity_date) {
            log_message('debug', 'No applicable effectivity_date found for ' . $currentDate);
            return [];
        }

        $latest_effectivity = $row->latest_effectivity_date;

        if (!$latest_effectivity) {
            return [];
        }

        $results = $this->db->table($table)
            ->select($columns)
            ->where('effectivity_date', $latest_effectivity)
            ->get()
            ->getResultArray();

        return array_map(function ($row) use ($columns) {
            foreach ($columns as $column) {
                if (isset($row[$column]) && is_string($row[$column])) {
                    $row[$column] = trim($row[$column]);
                }
            }
            return $row;
        }, $results);
    }

    function get_valid_records_tracc_data($table, $columns, $groupBy = null) {
        if (is_string($columns)) {
            $columns = [$columns];
        }
        
        $columns = (array) $columns;

        $selectCols = array_values(array_unique(array_merge($columns, ['itmcde'])));
        $builder = $this->db->table($table)->select($selectCols);

        foreach ($selectCols as $col) {
            $builder->where("$col !=", '');
        }

        if (!empty($groupBy)) {
            $groupByCols = array_values(array_unique(array_merge((array) $groupBy, $selectCols)));
            $builder->groupBy($groupByCols);
        } else {
            $builder->select('recid');
        }

        $rows = $builder->get()->getResultArray();

        foreach ($rows as &$row) {
            foreach ($row as $k => $v) {
                if (is_string($v)) {
                    $row[$k] = trim($v);
                }
            }
        }

        return $rows;
    }

    // function get_valid_records_tracc_data($table, $column_name, $where = null) {
    //     $builder = $this->db->table($table)
    //         ->select(['recid', $column_name, 'itmcde']);
    //     if (!empty($where)) {
    //         $builder->groupBy($where);
    //     }else{
    //         $builder->where('cusitmcde !=', '');
    //     }

    //     $query = $builder->get();
    //     return $query->getResultArray();
    // }

    public function batchUpdateCustom($table, $data, $primaryKey, $get_code = false, $where_in = [])
    {
        if (empty($table) || empty($data) || empty($primaryKey) || empty($where_in)) {
            return "failed";
        }

        try {
            $this->db->transStart();

            // Loop through data and update each record
            foreach ($data as $row) {
                if (!isset($row[$primaryKey])) continue;
                $this->db->table($table)
                        ->where($primaryKey, $row[$primaryKey])
                        ->update($row);
            }

            $this->db->transComplete();

            if ($this->db->transStatus() === false) {
                return "failed";
            }

            return $where_in; // return ids that were updated
        } catch (\Exception $e) {
            return "failed";
        }
    }


    // ---------------------------------------------------- EXPORT DATA TO EXCEL ----------------------------------------------------
    // ----------------------------------------------------------- Agency -----------------------------------------------------------
    function get_agency_where_in($areaCode) {
        $query = $this->db->query("CALL get_agency_where_in($areaCode)");
        return $query->getResultArray(); // Return data as an array
    }
    function get_agency($areaOffset) {
        $query = $this->db->query("CALL get_agency($areaOffset)");
        return $query->getResultArray(); // Return data as an array
    }
    function get_agency_masterfile_count() {
        $query = $this->db->query("CALL get_agency_masterfile_count()");
        return $query->getResultArray(); // Return data as an array
    }
    // ----------------------------------------------------------- Agency -----------------------------------------------------------
    // ------------------------------------------------------------ Area ------------------------------------------------------------
    function get_area_where_in($areaCode) {
        $query = $this->db->query("CALL get_area_where_in($areaCode)");
        return $query->getResultArray(); // Return data as an array
    }
    function getArea($areaOffset) {
        $select = 'id, CONCAT(code, " - ", description) AS description';
        $query = $this->db->query("CALL SearchDynamic('tbl_area', null, '$select', 9999, 0, 'status:EQ=1', 'description', null)");
        return $query->getResultArray(); // Return data as an array
    }
    function get_area_masterfile_count() {
        $query = $this->db->query("CALL get_area_masterfile_count()");
        return $query->getResultArray(); // Return data as an array
    }
    function get_area_stores($areaOffset) {
        $query = $this->db->query("CALL get_area_stores($areaOffset)");
        return $query->getResultArray(); // Return data as an array
    }
    // ------------------------------------------------------------ Area ------------------------------------------------------------
    // --------------------------------------------------- Area Sales Coordinator ---------------------------------------------------
    function get_asc_where_in($ascCode) {
        $query = $this->db->query("CALL get_asc_where_in($ascCode)");
        return $query->getResultArray(); // Return data as an array
    }
    function getAsc($ascOffset) {
        $select = 'id, CONCAT(code, " - ", description) AS description';
        $query = $this->db->query("CALL SearchDynamic('tbl_area_sales_coordinator', null, '$select', 9999, 0, 'status:EQ=1', 'description', null)");
        return $query->getResultArray(); // Return data as an array
    }
    function get_asc_masterfile_count() {
        $query = $this->db->query("CALL get_asc_masterfile_count()");
        return $query->getResultArray(); // Return data as an array
    }
    // --------------------------------------------------- Area Sales Coordinator ---------------------------------------------------
    // ------------------------------------------------------ Brand Ambassador ------------------------------------------------------
    function get_brand_ambassador_where_in($brandAmbassadorCode) {
        $query = $this->db->query("CALL get_brand_ambassador_where_in($brandAmbassadorCode)");
        return $query->getResultArray(); // Return data as an array
    }
    function getBrandAmbassador($brandAmbassadorOffset) {
        $select = 'id, CONCAT(code, " - ", name) AS name';
        $query = $this->db->query("CALL SearchDynamic('tbl_brand_ambassador', null, '$select', 9999, 0, 'status:EQ=1', 'name', null)");

        return $query->getResultArray(); // Return data as an array
    }
    function get_brand_ambassador_masterfile_count() {
        $query = $this->db->query("CALL get_brand_ambassador_masterfile_count()");
        return $query->getResultArray(); // Return data as an array
    }
    function get_brand_ambassador_brands($brandAmbassadorOffset) {
        $query = $this->db->query("CALL get_brand_ambassador_brands($brandAmbassadorOffset)");
        return $query->getResultArray(); // Return data as an array
    }
    // ------------------------------------------------------ Brand Ambassador ------------------------------------------------------
    // ------------------------------------------------------- Store / Branch -------------------------------------------------------
    function get_store_branch_where_in($storeBranchCode) {
        $query = $this->db->query("CALL get_store_branch_where_in($storeBranchCode)");
        return $query->getResultArray(); // Return data as an array
    }

    function getStoreBranch($storeBranchOffset) {
        $select = 'code AS id, CONCAT(code, " - ", description) AS description';
        $query = $this->db->query("CALL SearchDynamic('tbl_store', null, '$select', 9999, 0, 'status:EQ=1', 'description', null)");
        return $query->getResultArray(); // Return data as an array
    }

    function getStoreBranchById($storeBranchOffset) {
        $select = 'id, CONCAT(code, " - ", description) AS description';
        $query = $this->db->query("CALL SearchDynamic('tbl_store', null, '$select', 9999, 0, 'status:EQ=1', 'description', null)");
        return $query->getResultArray(); // Return data as an array
    }

    function get_store_branch_masterfile_count() {
        $query = $this->db->query("CALL get_store_branch_masterfile_count()");
        return $query->getResultArray(); // Return data as an array
    }
    // ------------------------------------------------------- Store / Branch -------------------------------------------------------
    // ------------------------------------------------------------ Team ------------------------------------------------------------
    function get_team_where_in($teamCode) {
        $query = $this->db->query("CALL get_team_where_in($teamCode)");
        return $query->getResultArray(); // Return data as an array
    }
    function get_team($teamOffset) {
        $query = $this->db->query("CALL get_team($teamOffset)");
        return $query->getResultArray(); // Return data as an array
    }
    function get_team_masterfile_count() {
        $query = $this->db->query("CALL get_team_masterfile_count()");
        return $query->getResultArray(); // Return data as an array
    }
    // ------------------------------------------------------------ Team ------------------------------------------------------------
    // ------------------------------------------------------- My Magnum Opus -------------------------------------------------------
    // ------------------------------------------------ The one cALL be cALL solution -----------------------------------------------
    // ------------------------------------------------------- Dynamic Search -------------------------------------------------------
    function dynamic_search($tbl_name, $join, $table_fields, $limit, $offset, $conditions, $order, $group) {
        $query = $this->db->query("CALL SearchDynamic($tbl_name, $join, $table_fields, $limit, $offset, $conditions, $order, $group)");
        return $query->getResultArray(); // Return data as an array
    }
    // ------------------------------------------------------- Dynamic Search -------------------------------------------------------
    // ------------------------------------------------ The one cALL be cALL solution -----------------------------------------------
    // ------------------------------------------------------- My Magnum Opus -------------------------------------------------------
    // ---------------------------------------------------- EXPORT DATA TO EXCEL ----------------------------------------------------
    
    //additional temp
    function getBrandData($order, $limit, $offset) {
        $select = 'id, brand_code, brand_description';
        $query = $this->db->query("CALL SearchDynamic('tbl_brand', null, '$select', 9999, 0, 'status:EQ=1', 'brand_description', null)");
        return $query->getResultArray(); // Return data as an array
    }

    function get_valid_records_store_group() {
        $results = $this->db->table('tbl_store_group sg')
            ->select('sg.id, sg.area_id, sg.store_id, a.code as area_code, a.description')
            ->join('tbl_area a', 'a.id = sg.area_id', 'left')
            ->get()
            ->getResultArray();

        return $results;
    }

    function get_valid_records_store_ba_group() {
        $results = $this->db->table('tbl_brand_ambassador_group bag')
            ->select('bag.id, bag.store_id, bag.brand_ambassador_id as ba_id, ba.code as ba_code')
            ->join('tbl_brand_ambassador ba', 'ba.id = bag.brand_ambassador_id', 'left')
            ->get()
            ->getResultArray();

            return $results;
    }

    function get_valid_records_area_asc_group() {
        $results = $this->db->table('tbl_area a')
            ->select('a.id, a.code, a.description, asc.code as asc_code, asc.id as asc_id, asc.description as asc_description')
            ->join('tbl_area_sales_coordinator asc', 'a.id = asc.area_id', 'left')
            ->get()
            ->getResultArray();

            return $results;
    }

    function get_valid_records_ba_area_store_brand() {
        $builder = $this->db->table('tbl_store_group sg');
        $builder->select("
            a.id AS area_id,
            a.description AS area_name,
            a.code AS area_code,
            GROUP_CONCAT(DISTINCT CASE WHEN asc.status = 1 THEN asc.id ELSE NULL END SEPARATOR ', ') AS asc_id,
            GROUP_CONCAT(DISTINCT CASE WHEN asc.status = 1 THEN asc.code ELSE NULL END SEPARATOR ', ') AS asc_code,
            GROUP_CONCAT(DISTINCT CASE WHEN asc.status = 1 THEN asc.description ELSE NULL END SEPARATOR ', ') AS asc_name,

            GROUP_CONCAT(DISTINCT CASE WHEN s.status = 1 THEN s.id ELSE NULL END ORDER BY s.id SEPARATOR ', ') AS store_id,
            GROUP_CONCAT(DISTINCT CASE WHEN s.status = 1 THEN s.code ELSE NULL END ORDER BY s.code SEPARATOR ', ') AS store_code,
            GROUP_CONCAT(DISTINCT CASE WHEN s.status = 1 THEN s.description ELSE NULL END ORDER BY s.description SEPARATOR ', ') AS store_name,

            GROUP_CONCAT(DISTINCT b.id ORDER BY b.id SEPARATOR ', ') AS brand_id,
            GROUP_CONCAT(DISTINCT b.brand_description ORDER BY b.brand_description SEPARATOR ', ') AS brand_name,

            GROUP_CONCAT(DISTINCT
                CASE
                    WHEN bag.brand_ambassador_id = -5 THEN '-5'
                    WHEN bag.brand_ambassador_id = -6 THEN '-6'
                    WHEN ba.status = 1 THEN ba.code
                    ELSE NULL
                END
                ORDER BY ba.code SEPARATOR ', '
            ) AS brand_ambassador_code,

            GROUP_CONCAT(DISTINCT
                CASE
                    WHEN bag.brand_ambassador_id = -5 THEN 'Vacant'
                    WHEN bag.brand_ambassador_id = -6 THEN 'Non BA'
                    WHEN ba.status = 1 THEN ba.name
                    ELSE NULL
                END
                ORDER BY ba.name SEPARATOR ', '
            ) AS brand_ambassador_name,

            GROUP_CONCAT(DISTINCT
                CASE
                    WHEN bag.brand_ambassador_id = -5 THEN '-5'
                    WHEN bag.brand_ambassador_id = -6 THEN '-6'
                    WHEN ba.status = 1 THEN ba.id
                    ELSE NULL
                END
                ORDER BY ba.id SEPARATOR ', '
            ) AS brand_ambassador_id
        ");

        $builder->join('tbl_area a', 'a.id = sg.area_id', 'left');
        $builder->join('tbl_store s', 's.id = sg.store_id', 'left');
        $builder->join('tbl_brand_ambassador_group bag', 'bag.store_id = s.id', 'left');
        $builder->join('tbl_brand_ambassador ba', 'ba.id = bag.brand_ambassador_id', 'left');
        $builder->join('tbl_ba_brands bba', 'ba.id = bba.ba_id', 'left');
        $builder->join('tbl_brand b', 'bba.brand_id = b.id', 'left');
        $builder->join('tbl_area_sales_coordinator asc', 'asc.area_id = a.id', 'left');

        $builder->where('a.status', 1);

        $builder->groupBy('a.code');

        return $builder->get()->getResultArray();
    }

    function get_valid_records_store_area_asc_ba_brand() {
        $builder = $this->db->table('tbl_store s');

        $builder->select("
            sg.area_id AS sg_area_id,
            sg.store_id AS sg_store_id,

            s.id AS store_id,
            s.code AS store_code,
            s.description AS store_name,

            a.id AS area_id,
            a.code AS area_code,
            a.description AS area_name,

            ba.type AS ba_types,
            GROUP_CONCAT(DISTINCT CASE WHEN asc.status = 1 THEN asc.id ELSE NULL END SEPARATOR ', ') AS asc_id,
            GROUP_CONCAT(DISTINCT CASE WHEN asc.status = 1 THEN asc.code ELSE NULL END SEPARATOR ', ') AS asc_code,
            GROUP_CONCAT(DISTINCT CASE WHEN asc.status = 1 THEN asc.description ELSE NULL END SEPARATOR ', ') AS asc_name,

            GROUP_CONCAT(DISTINCT
                CASE
                    WHEN bag.brand_ambassador_id = -5 THEN '-5'
                    WHEN bag.brand_ambassador_id = -6 THEN '-6'
                    WHEN ba.status = 1 THEN ba.code
                    ELSE NULL
                END
                ORDER BY ba.code SEPARATOR ', '
            ) AS brand_ambassador_code,

            GROUP_CONCAT(DISTINCT
                CASE
                    WHEN bag.brand_ambassador_id = -5 THEN 'Vacant'
                    WHEN bag.brand_ambassador_id = -6 THEN 'Non BA'
                    WHEN ba.status = 1 THEN ba.name
                    ELSE NULL
                END
                ORDER BY ba.name SEPARATOR ', '
            ) AS brand_ambassador_name,

            GROUP_CONCAT(DISTINCT
                CASE
                    WHEN bag.brand_ambassador_id = -5 THEN '-5'
                    WHEN bag.brand_ambassador_id = -6 THEN '-6'
                    WHEN ba.status = 1 THEN ba.id
                    ELSE NULL
                END
                ORDER BY ba.id SEPARATOR ', '
            ) AS brand_ambassador_id,

            GROUP_CONCAT(DISTINCT b.id ORDER BY b.id SEPARATOR ', ') AS brand_id,
            GROUP_CONCAT(DISTINCT b.brand_description ORDER BY b.brand_description SEPARATOR ', ') AS brand_name
        ");

        $builder->join('tbl_store_group sg', 'sg.store_id = s.id', 'left');
        $builder->join('tbl_area a', 'a.id = sg.area_id', 'left');
        $builder->join('tbl_area_sales_coordinator asc', 'asc.area_id = a.id', 'left');
        $builder->join('tbl_brand_ambassador_group bag', 'bag.store_id = s.id', 'left');
        $builder->join('tbl_brand_ambassador ba', 'ba.id = bag.brand_ambassador_id', 'left');
        $builder->join('tbl_ba_brands bba', 'ba.id = bba.ba_id', 'left');
        $builder->join('tbl_brand b', 'bba.brand_id = b.id', 'left');

        $builder->where('s.status', 1); // include only active stores
        $builder->groupBy('s.id');

        return $builder->get()->getResultArray();
    }

    function getMonths() {
        $query = $this->db->query("CALL get_months()");
        return $query->getResultArray(); // Return data as an array
    }

    function getSysPar() {
        $query = $this->db->query("CALL SearchDynamic('tbl_system_parameter', null, 'id, sm_sku_min, sm_sku_max, overstock_sku, new_item_sku, hero_sku, sales_incentives, cus_grp_code_lmi, cus_grp_code_rgdi, brand_code_included, brand_code_excluded, brand_label_type, tba_amount_per_ba, tba_num_days, watsons_payment_group', 1, 0, 'status:EQ=1', 'id', null)");
        return $query->getResultArray(); // Return data as an array
    }

    function getYears() {
        $query = $this->db->query("CALL SearchDynamic('tbl_year', null, 'id, year', 9999, 0, 'status:EQ=1', 'year', null)");
        return $query->getResultArray(); // Return data as an array
    }

    function getCompanies() {
        $query = $this->db->query("CALL SearchDynamic('tbl_company', null, 'id, name', 9999, 0, 'status:EQ=1', 'name', null)");
        return $query->getResultArray(); // Return data as an array
    }

    function getBrandLabelData() {
        $query = $this->db->query("CALL SearchDynamic('tbl_brand_label_type', null, 'id, label', 9999, 0, null, 'label', null)");
        return $query->getResultArray(); 
    }

    function getTraccItemClassification() {
        $query = $this->db->query("CALL SearchDynamic('tbl_classification', null, 'item_class_code, item_class_description', 9999, 0, 'status:EQ=1', 'item_class_code', null)");
        return $query->getResultArray(); 
    }

    function getItemClassification() {
        $query = $this->db->query("CALL SearchDynamic('tbl_item_class', null, 'id, item_class_code, item_class_description', 9999, 0, 'status:EQ=1', 'item_class_code', null)");
        return $query->getResultArray(); 
    }

    function get_item_class_counts() {
        $query = $this->db->query("CALL Get_Item_Class_Counts()");
        return $query->getResultArray();
    }

    // public function fetch_temp_data($limit, $page, $year, $month, $week, $company, $id)
    public function fetch_temp_data($limit, $page, $year, $week, $company, $id)
    {
        if ($page == 0) {
            $offset = 0;
        } else {
            $offset = ($page - 1) * $limit;
        }

        $baseQuery = $this->db->table('tbl_temp_vmi')
                      ->where('year', $year)
                    //   ->where('month', $month)
                      ->where('week', $week)
                      ->where('company', $company)
                      ->where('created_by', $id);

        $totalRecords = $baseQuery->countAllResults(false);

        $data = $baseQuery->limit($limit, $offset)->get()->getResultArray();

        return [
            "data" => $data,
            "totalRecords" => $totalRecords
        ];
    }

    public function delete_temp_vmi($id)
    {
        $builder = $this->db->table('tbl_temp_vmi');

        $builder->where('created_by', $id);
        $deleted = $builder->delete();

        if ($deleted) {
            return 'success';
        } else {
            return 'failed';
        }
    }

    public function fetch_scan_data($limit, $page, $filename, $id)
    {
        $offset = ($page - 1) * $limit;

        $builder = $this->db->table('tbl_sell_out_temp_space')
                      ->where('file_name', $filename)
                      ->where('created_by', $id)
                      ->orderBy('id', 'ASC')
                      ->limit($limit, $offset)
                      ->get();

        $data = $builder->getResultArray();

        $totalRecords = $this->db->table('tbl_sell_out_temp_space')
                          ->where('file_name', $filename)
                          ->where('created_by', $id)
                          ->countAllResults();

        return [
            "data" => $data,
            "totalRecords" => $totalRecords
        ];
    }

    public function delete_temp_scan($id, $month, $year)
    {
        $builder = $this->db->table('tbl_sell_out_temp_space');
        $builder->where('created_by', $id);
        $builder->where('year', $year);
        $builder->where('month', $month);
        
        $deleted = $builder->delete();

        if ($deleted) {
            return 'success';
        } else {
            return 'failed';
        }
    }

    public function fetch_last_ba_code($table, $field) {
        try {
            $query = $this->db->query("SELECT $field FROM $table ORDER BY id DESC LIMIT 1");
            $result = $query->getRow();
            return $result ? $result->$field : null;
        } catch (Exception $e) {
            return "failed";
        }
    }

    // ----------==========|| week on week scan data ||==========----------
    public function fetch_wkonwk_data($limit, $page, $filename, $id, $year, $week)
    {
        $offset = ($page - 1) * $limit;

        $builder = $this->db->table('tbl_wkonwk_temp_space')
                      ->where('file_name', $filename)
                      ->where('created_by', $id)
                      ->where('year', $year)
                      ->where('week', $week)
                      ->orderBy('id', 'ASC')
                      ->limit($limit, $offset)
                      ->get();

        $data = $builder->getResultArray();

        $totalRecords = $this->db->table('tbl_wkonwk_temp_space')
                          ->where('file_name', $filename)
                          ->where('created_by', $id)
                          ->where('year', $year)
                          ->where('week', $week)
                          ->countAllResults();

        return [
            "data" => $data,
            "totalRecords" => $totalRecords
        ];
    }

    public function delete_temp_wkonwk($id, $year, $week)
    {
        $builder = $this->db->table('tbl_wkonwk_temp_space');
        $builder->where('created_by', $id);
        $builder->where('year', $year);
        $builder->where('week', $week);
        
        $deleted = $builder->delete();

        if ($deleted) {
            return 'success';
        } else {
            return 'failed';
        }
    }

    // ----------==========|| winsight scan data ||==========----------
    public function fetch_winsight_data($limit, $page, $filename, $id, $uid)
    {
        $offset = ($page - 1) * $limit;

        $builder = $this->db->table('tbl_winsight_temp_space')
        ->where('file_name', $filename)
        ->where('created_by', $id)
        ->where('uid', $uid)
        ->orderBy('id', 'ASC')
        ->limit($limit, $offset)
        ->get();

        $data = $builder->getResultArray();

        $totalRecords = $this->db->table('tbl_winsight_temp_space')
        ->where('file_name', $filename)
        ->where('created_by', $id)
        ->where('uid', $uid)
        ->countAllResults();

        return [
            "data" => $data,
            "totalRecords" => $totalRecords,
            "uid" => $uid
        ];
    }

    public function delete_temp_winsight($id, $uid, $filename)
    {
        $builder = $this->db->table('tbl_winsight_temp_space');
        $builder->where('file_name', $filename);
        $builder->where('created_by', $id);
        $builder->where('uid', $uid);
        
        $deleted = $builder->delete();

        if ($deleted) {
            return 'success';
        } else {
            return 'failed';
        }
    }

    public function data_from_merged_table(array $tables, string $field) {
        $field = $this->db->escapeString($field);
        $unionQueries = [];

        foreach ($tables as $table) {
            $table = $this->db->escapeString($table);
            $unionQueries[] = "SELECT {$field}, '{$table}' AS source_table FROM {$table}";
        }

        $sql = implode(" UNION ", $unionQueries);

        $query = $this->db->query($sql);
        $result = $query->getResultArray();

        return $result; // ✅ just return data, not a Response
    }

    function get_data(
        string $table,
        array $query = null,
        int $limit = 1,
        int $start = 0,
        string $select = '*',
        string $order_field = null,
        string $order_type = 'ASC',
        array $join = null,
        string|array $group = null
    ) {
        $builder = $this->db->table($table);
        $builder->select($select);

        if (!empty($query)) {
            $builder->where($query);
        }

        if (!empty($join)) {
            foreach ($join as $j) {
                if (isset($j['table'], $j['query'], $j['type'])) {
                    $builder->join($j['table'], $j['query'], $j['type']);
                }
            }
        }

        if (!empty($order_field)) {
            $safe_order_type = strtoupper($order_type) === 'DESC' ? 'DESC' : 'ASC';
            $builder->orderBy($order_field, $safe_order_type);
        }

        if (!empty($group)) {
            $builder->groupBy($group);
        }

        $builder->limit($limit, $start);

        $q = $builder->get();
        return $q->getResult();
    }

    function getYearCounts()
    {
        $sql = "
            SELECT 
                way.id,
                way.year,
                COALESCE(vmiy.vmiyear_count, 0) AS vmiyear_count,
                COALESCE(sopa.sellout_count_pa, 0) AS sellout_count_pa,
                COALESCE(tsps.targetsalesps_count, 0) AS targetsalesps_count,
                COALESCE(wowdets.weekonweeks_count, 0) AS weekonweeks_count,
                COALESCE(so.sellout_count, 0) AS sellout_count
            FROM  
                tbl_year AS way
            LEFT JOIN (
                SELECT year, COUNT(DISTINCT year) AS vmiyear_count
                FROM tbl_vmi
                GROUP BY year
            ) AS vmiy ON vmiy.year = way.id
            LEFT JOIN (
                SELECT year, COUNT(DISTINCT year) AS sellout_count_pa
                FROM tbl_accounts_target_sellout_pa
                GROUP BY year
            ) AS sopa ON sopa.year = way.id
            LEFT JOIN (
                SELECT year, COUNT(DISTINCT year) AS targetsalesps_count
                FROM tbl_target_sales_per_store
                GROUP BY year
            ) AS tsps ON tsps.year = way.id
            LEFT JOIN (
                SELECT year, COUNT(DISTINCT year) AS weekonweeks_count
                FROM tbl_week_on_week_details
                GROUP BY year
            ) AS wowdets ON wowdets.year = way.id
            LEFT JOIN (
                SELECT year, COUNT(DISTINCT year) AS sellout_count
                FROM tbl_sell_out_data_header
                GROUP BY year
            ) AS so ON so.year = way.year;
        ";

        $query = $this->db->query($sql);
        return $query->getResultArray(); 
    }

    function getCompanyCounts()
    {
        $sql = "
            SELECT 
                comp.id,
                comp.name,
                EXISTS (
                    SELECT 1 
                    FROM tbl_vmi AS v 
                    WHERE v.company = comp.id
                    LIMIT 1
                ) AS vmi_comp_count,
                EXISTS (
                    SELECT 1
                    FROM tbl_sell_out_data_header AS so
                    WHERE so.company = comp.id
                    LIMIT 1
                ) AS so_comp_count
            FROM 
                tbl_company AS comp;
        ";

        $query = $this->db->query($sql);
        return $query->getResultArray(); 
    }

    public function refreshFromMain($customerId, $cusPricelistId, $userId)
    {
        // If cus_pricelist_id actually stores mp.id, change JOIN to: mp.id = cp.cus_pricelist_id
        $sql = "
            UPDATE tbl_customer_pricelist cp
            JOIN   tbl_main_pricelist mp
                   ON mp.pricelist_id = cp.cus_pricelist_id
            SET
                cp.brand_id               = mp.brand_id,
                cp.brand_label_type_id    = mp.brand_label_type_id,
                cp.label_type_category_id = mp.label_type_category_id,
                cp.category_1_id          = mp.category_1_id,
                cp.category_2_id          = mp.category_2_id,
                cp.category_3_id          = mp.category_3_id,
                cp.category_4_id          = mp.category_4_id,
                cp.item_description       = mp.item_description,
                cp.cust_item_code         = mp.cust_item_code,
                cp.uom                    = mp.uom,
                cp.selling_price          = mp.selling_price,
                cp.net_price              = mp.selling_price,   -- adjust if you compute discounts
                cp.effectivity_date       = mp.effectivity_date,
                cp.updated_by             = :userId:,
                cp.updated_date           = NOW()
            WHERE cp.customer_id      = :customerId:
              AND cp.cus_pricelist_id = :cusPricelistId:
              AND cp.status >= 0
        ";

        $this->db->query($sql, [
            'customerId'     => $customerId,
            'cusPricelistId' => $cusPricelistId,
            'userId'         => $userId,
        ]);

        return $this->db->affectedRows();
    }

}


