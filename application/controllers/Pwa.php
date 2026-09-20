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

        $base = rtrim(base_url(), '/') . '/';
        $short = (mb_strlen($name) > 12) ? 'Tahsin' : $name;

        $manifest = [
            'id'               => $base,
            'name'             => $name,
            'short_name'       => $short,
            'description'      => $name . ' — portal for facilitators, parents, and students.',
            'start_url'        => $base . 'authentication',
            'scope'            => $base,
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
            'shortcuts' => [
                [
                    'name'        => 'Sign in',
                    'short_name'  => 'Login',
                    'description' => 'Open the login page',
                    'url'         => $base . 'authentication',
                    'icons'       => [
                        [
                            'src'   => $base . 'assets/images/pwa/icon-192.png',
                            'sizes' => '192x192',
                        ],
                    ],
                ],
                [
                    'name'        => 'Dashboard',
                    'short_name'  => 'Home',
                    'description' => 'Open your dashboard',
                    'url'         => $base . 'dashboard',
                    'icons'       => [
                        [
                            'src'   => $base . 'assets/images/pwa/icon-192.png',
                            'sizes' => '192x192',
                        ],
                    ],
                ],
            ],
        ];

        $this->output
            ->set_content_type('application/manifest+json', 'utf-8')
            ->set_header('Cache-Control: public, max-age=86400')
            ->set_output(json_encode($manifest, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
    }
}
