<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Audited MySQLi driver — logs INSERT / UPDATE / DELETE to audit_log.
 */
class MY_DB_mysqli_driver extends CI_DB_mysqli_driver
{
    /** @var bool */
    public $audit_enabled = true;

    /** @var bool */
    protected $audit_writing = false;

    /** @var int|null Preserved after audited INSERT so audit_log does not steal insert_id() */
    protected $preserved_insert_id = null;

    protected $audit_skip_tables = array(
        'audit_log',
        'ci_sessions',
        'sessions',
        'login_log',
        'languages',
        'migrations',
    );

    public function insert_id()
    {
        if ($this->preserved_insert_id !== null) {
            return (int) $this->preserved_insert_id;
        }
        return parent::insert_id();
    }

    public function insert($table = '', $set = NULL, $escape = NULL)
    {
        $this->preserved_insert_id = null;
        $payload = $this->_auditCaptureSet($set);
        $result = parent::insert($table, $set, $escape);
        if ($result) {
            $this->preserved_insert_id = (int) parent::insert_id();
        }
        if ($result && $this->_auditShouldLog($table)) {
            $recordId = $this->preserved_insert_id ? (string) $this->preserved_insert_id : null;
            $this->_auditWrite('INSERT', $table, $recordId, null, $payload);
        }
        return $result;
    }

    public function update($table = '', $set = NULL, $where = NULL, $limit = NULL)
    {
        $oldRows = $this->_auditFetchAffected($table);
        $payload = $this->_auditCaptureSet($set);
        $result = parent::update($table, $set, $where, $limit);
        if ($result && $this->_auditShouldLog($table) && $this->affected_rows() >= 0) {
            $recordId = null;
            $old = null;
            if (is_array($oldRows) && count($oldRows) === 1) {
                $old = $oldRows[0];
                if (isset($old['id'])) {
                    $recordId = (string) $old['id'];
                }
            } elseif (is_array($oldRows) && count($oldRows) > 1) {
                $old = array('_count' => count($oldRows), '_ids' => array_column($oldRows, 'id'));
            }
            $this->_auditWrite('UPDATE', $table, $recordId, $old, $payload ?: array('where' => $this->_auditWhereSummary()));
        }
        return $result;
    }

    public function delete($table = '', $where = '', $limit = NULL, $reset_data = TRUE)
    {
        $oldRows = $this->_auditFetchAffected($table);
        $result = parent::delete($table, $where, $limit, $reset_data);
        if ($result && $this->_auditShouldLog($table)) {
            $recordId = null;
            $old = $oldRows;
            if (is_array($oldRows) && count($oldRows) === 1) {
                $old = $oldRows[0];
                if (isset($old['id'])) {
                    $recordId = (string) $old['id'];
                }
            } elseif (is_array($oldRows) && count($oldRows) > 1) {
                $old = array('_count' => count($oldRows), '_ids' => array_column($oldRows, 'id'));
            }
            $this->_auditWrite('DELETE', $table, $recordId, $old, null);
        }
        return $result;
    }

    public function replace($table = '', $set = NULL)
    {
        $payload = $this->_auditCaptureSet($set);
        $result = parent::replace($table, $set);
        if ($result && $this->_auditShouldLog($table)) {
            $this->_auditWrite('REPLACE', $table, null, null, $payload);
        }
        return $result;
    }

    protected function _auditShouldLog($table)
    {
        if (!$this->audit_enabled || $this->audit_writing) {
            return false;
        }
        $table = $this->_auditNormalizeTable($table);
        if ($table === '' || in_array($table, $this->audit_skip_tables, true)) {
            return false;
        }
        return true;
    }

    protected function _auditNormalizeTable($table)
    {
        $table = trim((string) $table);
        if ($table === '' && !empty($this->qb_from[0])) {
            $table = $this->qb_from[0];
        }
        $table = str_replace(array('`', '"'), '', $table);
        if (($pos = strrpos($table, '.')) !== false) {
            $table = substr($table, $pos + 1);
        }
        if (($pos = stripos($table, ' as ')) !== false) {
            $table = trim(substr($table, 0, $pos));
        }
        return strtolower(trim($table));
    }

    protected function _auditCaptureSet($set)
    {
        if (is_array($set) && !empty($set)) {
            return $this->_auditSanitize($set);
        }
        if (!empty($this->qb_set) && is_array($this->qb_set)) {
            $out = array();
            foreach ($this->qb_set as $key => $val) {
                $cleanKey = trim(str_replace(array('`', '"'), '', $key));
                $out[$cleanKey] = is_string($val) ? trim($val, "'") : $val;
            }
            return $this->_auditSanitize($out);
        }
        return null;
    }

    protected function _auditFetchAffected($table)
    {
        $table = $this->_auditNormalizeTable($table);
        if ($table === '' || empty($this->qb_where)) {
            return null;
        }

        $where = $this->_auditCompileWhereOnly();
        if ($where === '') {
            return null;
        }

        $sql = 'SELECT * FROM `' . str_replace('`', '``', $table) . '` WHERE ' . $where . ' LIMIT 50';
        $q = @mysqli_query($this->conn_id, $sql);
        if (!$q) {
            return null;
        }

        $rows = array();
        while ($row = mysqli_fetch_assoc($q)) {
            $rows[] = $this->_auditSanitize($row);
        }
        mysqli_free_result($q);
        return $rows;
    }

    protected function _auditCompileWhereOnly()
    {
        if (empty($this->qb_where)) {
            return '';
        }
        return preg_replace('/^\s*WHERE\s*/i', '', $this->_compile_wh('qb_where'));
    }

    protected function _auditWhereSummary()
    {
        $where = $this->_auditCompileWhereOnly();
        return $where !== '' ? $where : null;
    }

    protected function _auditSanitize($data)
    {
        if (!is_array($data)) {
            return $data;
        }
        $sensitive = array('password', 'c_password', 'new_password', 'current_password', 'api_key', 'secret', 'token', 'smtp_pass', 'smtp_password');
        $out = array();
        foreach ($data as $k => $v) {
            $key = (string) $k;
            if (in_array(strtolower($key), $sensitive, true) || stripos($key, 'password') !== false) {
                $out[$key] = '[REDACTED]';
            } elseif (is_string($v) && strlen($v) > 2000) {
                $out[$key] = substr($v, 0, 2000) . '…';
            } elseif (is_array($v) || is_object($v)) {
                $out[$key] = $this->_auditSanitize((array) $v);
            } else {
                $out[$key] = $v;
            }
        }
        return $out;
    }

    protected function _auditWrite($action, $table, $recordId, $oldValues, $newValues)
    {
        if ($this->audit_writing) {
            return;
        }
        $this->audit_writing = true;
        try {
            $userId = null;
            $roleId = null;
            $branchId = null;
            $username = null;
            $url = null;
            $ip = null;
            $ua = null;

            if (class_exists('CI_Controller', false)) {
                $CI =& get_instance();
                if ($CI) {
                    if (isset($CI->session)) {
                        $userId = $CI->session->userdata('loggedin_userid');
                        $roleId = $CI->session->userdata('loggedin_role_id');
                        $branchId = $CI->session->userdata('loggedin_branch');
                        $username = $CI->session->userdata('name');
                        if (empty($username)) {
                            $username = $CI->session->userdata('logger_username');
                        }
                    }
                    if (isset($_SERVER['REQUEST_URI'])) {
                        $url = substr($_SERVER['REQUEST_URI'], 0, 500);
                    }
                    if (isset($CI->input)) {
                        $ip = $CI->input->ip_address();
                        if ($ip === '::1') {
                            $ip = '127.0.0.1';
                        }
                        $ua = substr((string) $CI->input->user_agent(), 0, 500);
                    }
                }
            }

            $row = array(
                'user_id'     => $userId ? (int) $userId : null,
                'role_id'     => $roleId ? (int) $roleId : null,
                'branch_id'   => $branchId ? (int) $branchId : (defined('SCHOOL_ID') ? (int) SCHOOL_ID : null),
                'username'    => $username ? substr((string) $username, 0, 191) : null,
                'action'      => $action,
                'module'      => $table,
                'table_name'  => $table,
                'record_id'   => $recordId !== null ? substr((string) $recordId, 0, 64) : null,
                'description' => strtoupper($action) . ' on ' . $table . ($recordId ? ' #' . $recordId : ''),
                'old_values'  => $oldValues !== null ? json_encode($oldValues, JSON_UNESCAPED_UNICODE) : null,
                'new_values'  => $newValues !== null ? json_encode($newValues, JSON_UNESCAPED_UNICODE) : null,
                'ip_address'  => $ip,
                'user_agent'  => $ua,
                'url'         => $url,
                'created_at'  => date('Y-m-d H:i:s'),
            );

            // Direct query to avoid recursion through insert()
            $escaped = array();
            foreach ($row as $k => $v) {
                if ($v === null) {
                    $escaped[] = 'NULL';
                } else {
                    $escaped[] = $this->escape($v);
                }
            }
            $sql = 'INSERT INTO `audit_log` (`' . implode('`,`', array_keys($row)) . '`) VALUES (' . implode(',', $escaped) . ')';
            @mysqli_query($this->conn_id, $sql);
        } catch (Exception $e) {
            // never break app flow for audit failures
        }
        $this->audit_writing = false;
    }
}
