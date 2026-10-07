<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Serves the Web App Manifest for installable shortcuts
 * (facilitator, parent, student — and other roles).
 */
class Pwa extends CI_Controller
{
    public function manifest()
    {
        $this->load->database();

        $name = defined('SCHOOL_NAME') ? SCHOOL_NAME : 'Tahsin Academy';
        $row = $this->db->select('institute_name')->where('id', 1)->get('global_settings')->row();
        if (!empty($row->institute_name)) {
            $name = trim($row->institute_name);
        }

        if (defined('TAHSIN_DESK') && TAHSIN_DESK !== '') {
            $this->studentManifest();
            return;
        }

        $base = rtrim(base_url(), '/') . '/';
        $portal = $base . 'portal/';
        $short = (mb_strlen($name) > 12) ? 'Tahsin' : $name;

        $manifest = [
            'id'               => $portal,
            'name'             => $name,
            'short_name'       => $short,
            'description'      => $name . ' — portal for facilitators, parents, and students.',
            'start_url'        => $portal,
            'scope'            => $portal,
            'display'          => 'standalone',
            'orientation'      => 'any',
            'background_color' => '#10241e',
            'theme_color'      => '#10241e',
            'lang'             => 'en',
            'dir'              => 'ltr',
            'categories'       => ['education', 'productivity'],
            'icons'            => [
                [
                    'src'     => $base . 'assets/images/pwa/icon-192.png',
                    'sizes'   => '192x192',
                    'type'    => 'image/png',
                    'purpose' => 'any',
                ],
                [
                    'src'     => $base . 'assets/images/pwa/icon-512.png',
                    'sizes'   => '512x512',
                    'type'    => 'image/png',
                    'purpose' => 'any',
                ],
                [
                    'src'     => $base . 'assets/images/pwa/icon-192.png',
                    'sizes'   => '192x192',
                    'type'    => 'image/png',
                    'purpose' => 'maskable',
                ],
                [
                    'src'     => $base . 'assets/images/pwa/icon-512.png',
                    'sizes'   => '512x512',
                    'type'    => 'image/png',
                    'purpose' => 'maskable',
                ],
            ],
        ];

        $this->output
            ->set_content_type('application/manifest+json', 'utf-8')
            ->set_header('Cache-Control: public, max-age=300')
            ->set_output(json_encode($manifest, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
    }

    /**
     * One installed icon per child. Its scope does not cover a sibling's icon.
     */
    protected function studentManifest()
    {
        $studentId = student_app_student_id(TAHSIN_DESK);
        $studentRow = $studentId > 0 ? $this->db->select('id')->where('id', $studentId)->get('student')->row() : null;
        if (!$studentRow) {
            show_404();
            return;
        }
        $label = student_app_label(TAHSIN_DESK);
        $who = $label !== '' ? $label : 'Student';
        $first = $who;
        if (strpos($who, ' ') !== false) {
            $first = trim(substr($who, 0, strpos($who, ' ')));
        }
        $short = $first !== '' ? $first : 'Tahsin';
        if (function_exists('mb_strlen') && mb_strlen($short) > 12) {
            $short = mb_substr($short, 0, 12);
        }
        $home = rtrim(base_url(), '/') . '/';
        $root = rtrim(student_app_root(), '/') . '/';
        $icon = $root . 'assets/images/pwa/icon-192.png';
        $iconLarge = $root . 'assets/images/pwa/icon-512.png';
        $manifest = array(
            'id' => $home,
            'name' => 'Tahsin · ' . $who,
            'short_name' => $short,
            'description' => 'Tahsin for ' . $who,
            'start_url' => $home . 'authentication',
            'scope' => $home,
            'display' => 'standalone',
            'orientation' => 'any',
            'background_color' => '#10241e',
            'theme_color' => '#10241e',
            'icons' => array(
                array('src' => $icon, 'sizes' => '192x192', 'type' => 'image/png', 'purpose' => 'any'),
                array('src' => $iconLarge, 'sizes' => '512x512', 'type' => 'image/png', 'purpose' => 'any'),
                array('src' => $icon, 'sizes' => '192x192', 'type' => 'image/png', 'purpose' => 'maskable'),
                array('src' => $iconLarge, 'sizes' => '512x512', 'type' => 'image/png', 'purpose' => 'maskable'),
            ),
        );
        $this->output
            ->set_content_type('application/manifest+json', 'utf-8')
            ->set_header('Cache-Control: public, max-age=300')
            ->set_output(json_encode($manifest, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
    }

    public function portal()
    {
        $this->load->view('pwa/portal');
    }

    public function student_install()
    {
        $studentId = defined('TAHSIN_DESK') ? student_app_student_id(TAHSIN_DESK) : 0;
        $studentRow = $studentId > 0 ? $this->db->select('id')->where('id', $studentId)->get('student')->row() : null;
        if (!$studentRow) {
            show_404();
            return;
        }
        if (!headers_sent()) {
            header_remove('Pragma');
            header('Cache-Control: public, max-age=300');
            header('Expires: ' . gmdate('D, d M Y H:i:s', time() + 300) . ' GMT');
        }
        $this->output->set_header('Cache-Control: public, max-age=300');
        $this->load->view('pwa/student_install', array(
            'student_name' => student_app_label(TAHSIN_DESK),
            'manifest' => base_url('manifest.webmanifest'),
            'login_url' => base_url('authentication'),
            'sw_url' => base_url('sw.js'),
            'scope' => rtrim(base_url(), '/') . '/',
            'icon' => rtrim(student_app_root(), '/') . '/assets/images/pwa/icon-192.png',
        ));
    }

    public function worker()
    {
        if (!defined('TAHSIN_DESK') || TAHSIN_DESK === '') {
            show_404();
            return;
        }
        $js = "self.addEventListener('install',function(e){self.skipWaiting();});"
            . "self.addEventListener('activate',function(e){e.waitUntil(self.clients.claim());});"
            . "self.addEventListener('fetch',function(){});";
        $this->output
            ->set_content_type('application/javascript', 'utf-8')
            ->set_header('Cache-Control: public, max-age=300')
            ->set_output($js);
    }
}
