<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Public Quran playlist linked from the WhatsApp digest.
 * The token is student id plus an HMAC, so a guessed id does not open another child.
 */
class Quran extends CI_Controller
{
    public function playlist($token = '')
    {
        $studentId = $this->academy_model_id($token);
        if ($studentId < 1) {
            show_404();
            return;
        }
        $this->load->model('academy_model');
        $install = $this->academy_model->quranInstallName($studentId);
        $clips = $this->academy_model->quranPlaylistClips($studentId);
        $this->load->view('quran/playlist', array(
            'token' => $token,
            'install' => $install,
            'clips' => $clips,
            'manifest' => site_url('quran/' . $token . '/manifest.webmanifest'),
        ));
    }

    public function manifest($token = '')
    {
        $this->load->model('academy_model');
        $studentId = $this->academy_model->quranPlaylistStudentId($token);
        if ($studentId < 1) {
            show_404();
            return;
        }
        $install = $this->academy_model->quranInstallName($studentId);
        $start = site_url('quran/' . $token);
        $scope = rtrim(site_url('quran'), '/') . '/';
        $icon = $install['photo'];
        $manifest = array(
            'id' => $start,
            'name' => $install['name'],
            'short_name' => $install['short_name'],
            'description' => 'Sealed recitations for ' . $install['student_name'],
            'start_url' => $start,
            'scope' => $scope,
            'display' => 'standalone',
            'background_color' => '#10241e',
            'theme_color' => '#10241e',
            'icons' => array(
                array(
                    'src' => $icon,
                    'sizes' => '192x192',
                    'type' => 'image/png',
                    'purpose' => 'any',
                ),
                array(
                    'src' => $icon,
                    'sizes' => '512x512',
                    'type' => 'image/png',
                    'purpose' => 'any',
                ),
            ),
        );
        $this->output
            ->set_content_type('application/manifest+json', 'utf-8')
            ->set_header('Cache-Control: no-store')
            ->set_output(json_encode($manifest, JSON_UNESCAPED_SLASHES));
    }

    protected function academy_model_id($token)
    {
        $this->load->model('academy_model');
        return $this->academy_model->quranPlaylistStudentId($token);
    }
}
