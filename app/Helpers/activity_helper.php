<?php

use CodeIgniter\Database\BaseConnection;

if (!function_exists('log_activity')) {
    /**
     * Logs user activity into the activity_logs table.
     *
     * @param string $module
     * @param string $action
     * @param string $remarks
     * @return void
     */
    function log_activity(string $module, string $action, string $remarks = '', string $link = '', string $new_data = '', string $old_data = '')
    {
        $db = \Config\Database::connect();

        $session = session();

        $data = [
            'user' => $session->get('sess_site_name') ? $session->get('sess_site_name') : $session->get('sess_name'),
            'module'      => $module,
            'action'      => $action,
            'remarks'     => $remarks,
            'link'        => $link,
            'new_data'     => $new_data,
            'old_data'     => $old_data,
            'ip_address'  => $this->request->getIPAddress(),
            'created_at'  => date('Y-m-d H:i:s'),
        ];

        $db->table('activity_logs')->insert($data);
    }
}
