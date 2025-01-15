<?php

namespace App\Models;

use CodeIgniter\Model;

class User_model extends Model
{
    function check_email($email)
    {
        
        $builder = $this->db->table('tbl_report_users')
                            ->where('email', $email)
                            ->where('status', 1);   
        $query = $builder->get();
        return $query->getResult();

    }
}
