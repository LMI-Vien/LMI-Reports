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
    function log_activity(string $module, string $action, string $remarks = '')
    {
        $db = \Config\Database::connect();

        $session = session();

        $data = [
            'user' => $session->get('sess_site_name') ? $session->get('sess_site_name') : $session->get('sess_name'),
            'module'      => $module,
            'action'      => $action,
            'remarks'     => $remarks,
            'ip_address'  => $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0',
            'created_at'  => date('Y-m-d H:i:s'),
        ];

        $db->table('activity_logs')->insert($data);
    }
}
