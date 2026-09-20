<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Explicit audit trail logger for auth and business events.
 */
class App_audit
{
    protected $CI;
    protected $writing = false;

    public function __construct()
    {
        $this->CI =& get_instance();
    }

    public function log($action, $module, $description = null, $oldValues = null, $newValues = null, $table = null, $recordId = null)
    {
        if ($this->writing) {
            return false;
        }
        $this->writing = true;
        try {
            if (!$this->CI->db->table_exists('audit_log')) {
                $this->writing = false;
                return false;
            }

            $userId = $this->CI->session->userdata('loggedin_userid');
            $roleId = $this->CI->session->userdata('loggedin_role_id');
            $branchId = $this->CI->session->userdata('loggedin_branch');
            $username = $this->CI->session->userdata('name');
            if (empty($username)) {
                $username = $this->CI->session->userdata('logger_username');
            }

            $ip = $this->CI->input->ip_address();
            if ($ip === '::1') {
                $ip = '127.0.0.1';
            }

            $row = array(
                'user_id'     => $userId ? (int) $userId : null,
                'role_id'     => $roleId ? (int) $roleId : null,
                'branch_id'   => $branchId ? (int) $branchId : (defined('SCHOOL_ID') ? (int) SCHOOL_ID : null),
                'username'    => $username ? substr((string) $username, 0, 191) : null,
                'action'      => strtoupper(substr((string) $action, 0, 32)),
                'module'      => substr((string) $module, 0, 100),
                'table_name'  => $table ? substr((string) $table, 0, 100) : null,
                'record_id'   => $recordId !== null ? substr((string) $recordId, 0, 64) : null,
                'description' => $description ? substr((string) $description, 0, 500) : null,
                'old_values'  => $oldValues !== null ? json_encode($this->sanitize($oldValues), JSON_UNESCAPED_UNICODE) : null,
                'new_values'  => $newValues !== null ? json_encode($this->sanitize($newValues), JSON_UNESCAPED_UNICODE) : null,
                'ip_address'  => $ip,
                'user_agent'  => substr((string) $this->CI->input->user_agent(), 0, 500),
                'url'         => isset($_SERVER['REQUEST_URI']) ? substr($_SERVER['REQUEST_URI'], 0, 500) : null,
                'created_at'  => date('Y-m-d H:i:s'),
            );

            if (isset($this->CI->db->audit_enabled)) {
                $prev = $this->CI->db->audit_enabled;
                $this->CI->db->audit_enabled = false;
                $this->CI->db->insert('audit_log', $row);
                $this->CI->db->audit_enabled = $prev;
            } else {
                $this->CI->db->insert('audit_log', $row);
            }
        } catch (Exception $e) {
            // swallow
        }
        $this->writing = false;
        return true;
    }

    protected function sanitize($data)
    {
        if (!is_array($data)) {
            if (is_object($data)) {
                $data = (array) $data;
            } else {
                return $data;
            }
        }
        $out = array();
        foreach ($data as $k => $v) {
            $key = (string) $k;
            if (stripos($key, 'password') !== false || in_array(strtolower($key), array('api_key', 'secret', 'token'), true)) {
                $out[$key] = '[REDACTED]';
            } elseif (is_array($v) || is_object($v)) {
                $out[$key] = $this->sanitize((array) $v);
            } elseif (is_string($v) && strlen($v) > 2000) {
                $out[$key] = substr($v, 0, 2000) . '…';
            } else {
                $out[$key] = $v;
            }
        }
        return $out;
    }
}

if (!function_exists('audit_log')) {
    function audit_log($action, $module, $description = null, $oldValues = null, $newValues = null, $table = null, $recordId = null)
    {
        $CI =& get_instance();
        if (!isset($CI->app_audit)) {
            $CI->load->library('app_audit');
        }
        return $CI->app_audit->log($action, $module, $description, $oldValues, $newValues, $table, $recordId);
    }
}
