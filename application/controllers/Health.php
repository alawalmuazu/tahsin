<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Health extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        // Accessible to superadmin or state executives; regular branch admins get access too
        if (!is_loggedin()) {
            redirect(base_url('authentication'), 'refresh');
        }
    }

    public function index()
    {
        $this->data['title']     = 'System Health';
        $this->data['sub_page']  = 'health/index';
        $this->data['main_menu'] = 'health';
        $this->data['checks']    = $this->_run_checks();
        $this->load->view('layout/index', $this->data);
    }

    private function _run_checks()
    {
        $checks = [];

        // 1. HTTPS
        $is_https = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
                    || (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443);
        $checks[] = [
            'label'   => 'HTTPS / SSL',
            'desc'    => 'Required for Service Worker & Background Sync in production',
            'status'  => $is_https ? 'ok' : 'warn',
            'value'   => $is_https ? 'Enabled' : 'Not detected (OK on localhost)',
        ];

        // 2. Service Worker Eligibility
        $checks[] = [
            'label'   => 'Service Worker Eligible',
            'desc'    => 'Offline-first features require HTTPS in production',
            'status'  => $is_https ? 'ok' : 'warn',
            'value'   => $is_https ? 'Yes' : 'No (enable HTTPS on production server)',
        ];

        // 3. Database connectivity
        try {
            $this->db->query('SELECT 1');
            $db_ok = true;
        } catch (Exception $e) {
            $db_ok = false;
        }
        $checks[] = [
            'label'  => 'Database Connection',
            'desc'   => 'MySQL connection status',
            'status' => $db_ok ? 'ok' : 'error',
            'value'  => $db_ok ? 'Connected' : 'Failed',
        ];

        // 4. PHP Version
        $php_ver   = PHP_VERSION;
        $php_ok    = version_compare($php_ver, '7.4.0', '>=');
        $checks[] = [
            'label'  => 'PHP Version',
            'desc'   => 'Minimum required: PHP 7.4',
            'status' => $php_ok ? 'ok' : 'error',
            'value'  => $php_ver,
        ];

        // 5. Required PHP Extensions
        $required_ext = ['pdo', 'mbstring', 'gd', 'zip', 'curl'];
        foreach ($required_ext as $ext) {
            $loaded = extension_loaded($ext);
            $checks[] = [
                'label'  => 'PHP Extension: ' . strtoupper($ext),
                'desc'   => 'Required PHP extension',
                'status' => $loaded ? 'ok' : 'error',
                'value'  => $loaded ? 'Loaded' : 'Missing',
            ];
        }

        // 6. Upload directory writeable
        $upload_dirs = [
            'uploads/'                        => 'Main uploads folder',
            'uploads/transfer_attachments/'   => 'Transfer attachments',
            'uploads/attachments/'            => 'General attachments',
            'uploads/images/'                 => 'Images',
        ];
        foreach ($upload_dirs as $dir => $label) {
            $path       = FCPATH . $dir;
            $exists     = is_dir($path);
            $writable   = $exists && is_writable($path);
            $checks[]   = [
                'label'  => 'Writable: ' . $dir,
                'desc'   => $label,
                'status' => $writable ? 'ok' : ($exists ? 'error' : 'warn'),
                'value'  => !$exists ? 'Directory missing' : ($writable ? 'Writable' : 'Not writable'),
            ];
        }

        // 7. Disk space
        $free_bytes  = disk_free_space(FCPATH);
        $total_bytes = disk_total_space(FCPATH);
        $free_gb     = round($free_bytes / 1073741824, 2);
        $pct_free    = round(($free_bytes / $total_bytes) * 100);
        $checks[] = [
            'label'  => 'Disk Space',
            'desc'   => 'Free disk space on server partition',
            'status' => $pct_free > 20 ? 'ok' : ($pct_free > 10 ? 'warn' : 'error'),
            'value'  => $pct_free . '% available',
        ];

        // 8. PHP Session
        $session_ok = (session_status() === PHP_SESSION_ACTIVE || $this->session->userdata('user_id'));
        $checks[] = [
            'label'  => 'PHP Sessions',
            'desc'   => 'Session handling status',
            'status' => $session_ok ? 'ok' : 'error',
            'value'  => $session_ok ? 'Active' : 'Not working',
        ];

        return $checks;
    }
}
