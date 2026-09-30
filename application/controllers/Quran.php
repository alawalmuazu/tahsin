<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Public Quran playlist linked from the WhatsApp digest.
 * The token is student id plus an HMAC, so a guessed id does not open another child.
 */
class Quran extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // PHP's session sends Cache-Control: no-store. Android will not install a page with that header.
        if (!headers_sent()) {
            header_remove('Pragma');
            header('Cache-Control: public, max-age=300');
            header('Expires: ' . gmdate('D, d M Y H:i:s', time() + 300) . ' GMT');
        }
        $this->output->set_header('Cache-Control: public, max-age=300');
        $this->output->set_header('Expires: ' . gmdate('D, d M Y H:i:s', time() + 300) . ' GMT');
    }

    public function playlist($token = '', $hear = '')
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
            'hear' => ($hear === 'hear'),
            'vapid_public' => $this->academy_model->quranPushPublicKey(),
            'manifest' => site_url('quran/' . $token . '/manifest.webmanifest'),
        ));
    }

    /**
     * The installed app posts its push subscription here, tied to this child's token.
     */
    public function notify($token = '')
    {
        $studentId = $this->academy_model_id($token);
        if ($studentId < 1) {
            show_404();
            return;
        }
        $method = strtoupper($this->input->server('REQUEST_METHOD'));
        if ($method !== 'POST' && $method !== 'DELETE') {
            $this->output->set_status_header(405)->set_content_type('application/json')->set_output('{"ok":false}');
            return;
        }
        $data = json_decode((string) $this->input->raw_input_stream, true);
        if (!is_array($data)) {
            $data = array();
        }
        $this->load->model('academy_model');
        if ($method === 'DELETE') {
            $ok = $this->academy_model->removeQuranPushSubscription(
                $studentId,
                isset($data['endpoint']) ? $data['endpoint'] : ''
            );
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(array('ok' => (bool) $ok)));
            return;
        }
        $keys = isset($data['keys']) && is_array($data['keys']) ? $data['keys'] : array();
        $ok = $this->academy_model->saveQuranPushSubscription(
            $studentId,
            isset($data['endpoint']) ? $data['endpoint'] : '',
            isset($keys['p256dh']) ? $keys['p256dh'] : '',
            isset($keys['auth']) ? $keys['auth'] : ''
        );
        $this->output
            ->set_status_header($ok ? 200 : 422)
            ->set_content_type('application/json')
            ->set_output(json_encode(array('ok' => (bool) $ok)));
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
        $icon192 = site_url('quran/' . $token . '/icon-192.png');
        $icon512 = site_url('quran/' . $token . '/icon-512.png');
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
            'prefer_related_applications' => false,
            'related_applications' => array(
                array(
                    'platform' => 'webapp',
                    'url' => site_url('quran/' . $token . '/manifest.webmanifest'),
                    'id' => $start,
                ),
            ),
            'icons' => array(
                array(
                    'src' => $icon192,
                    'sizes' => '192x192',
                    'type' => 'image/png',
                    'purpose' => 'any',
                ),
                array(
                    'src' => $icon512,
                    'sizes' => '512x512',
                    'type' => 'image/png',
                    'purpose' => 'any',
                ),
                array(
                    'src' => $icon192,
                    'sizes' => '192x192',
                    'type' => 'image/png',
                    'purpose' => 'maskable',
                ),
                array(
                    'src' => $icon512,
                    'sizes' => '512x512',
                    'type' => 'image/png',
                    'purpose' => 'maskable',
                ),
            ),
        );
        $this->output
            ->set_content_type('application/manifest+json', 'utf-8')
            ->set_header('Cache-Control: public, max-age=300')
            ->set_output(json_encode($manifest, JSON_UNESCAPED_SLASHES));
    }

    /**
     * A real 192 or 512 PNG. Chrome refuses to install when the photo is only labeled as that size.
     */
    public function icon($token = '', $size = 192)
    {
        $this->load->model('academy_model');
        $studentId = $this->academy_model->quranPlaylistStudentId($token);
        if ($studentId < 1) {
            show_404();
            return;
        }
        $size = ((int) $size === 512) ? 512 : 192;
        if (!function_exists('imagecreatetruecolor')) {
            $fallback = FCPATH . 'assets/images/pwa/icon-' . $size . '.png';
            if (!is_file($fallback)) {
                show_404();
                return;
            }
            $this->output
                ->set_content_type('image/png')
                ->set_header('Cache-Control: public, max-age=86400')
                ->set_output(file_get_contents($fallback));
            return;
        }
        $install = $this->academy_model->quranInstallName($studentId);
        $png = $this->squarePng(isset($install['photo']) ? $install['photo'] : '', $size);
        $this->output
            ->set_content_type('image/png')
            ->set_header('Cache-Control: public, max-age=86400')
            ->set_output($png);
    }

    protected function squarePng($photoUrl, $size)
    {
        $size = (int) $size;
        $canvas = imagecreatetruecolor($size, $size);
        $green = imagecolorallocate($canvas, 16, 36, 30);
        imagefilledrectangle($canvas, 0, 0, $size, $size, $green);
        $photo = $this->loadLocalImage($photoUrl);
        if ($photo) {
            $width = imagesx($photo);
            $height = imagesy($photo);
            $side = min($width, $height);
            $sx = (int) (($width - $side) / 2);
            $sy = (int) (($height - $side) / 2);
            imagecopyresampled($canvas, $photo, 0, 0, $sx, $sy, $size, $size, $side, $side);
            imagedestroy($photo);
        }
        ob_start();
        imagepng($canvas);
        $png = ob_get_clean();
        imagedestroy($canvas);
        return $png;
    }

    protected function loadLocalImage($photoUrl)
    {
        if (!function_exists('imagecreatefromstring')) {
            return null;
        }
        $path = parse_url((string) $photoUrl, PHP_URL_PATH);
        if (!$path || !preg_match('#/(uploads/.+)$#', rawurldecode($path), $match)) {
            return null;
        }
        $file = FCPATH . str_replace('/', DIRECTORY_SEPARATOR, $match[1]);
        if (!is_file($file)) {
            return null;
        }
        $data = @file_get_contents($file);
        if ($data === false || $data === '') {
            return null;
        }
        $image = @imagecreatefromstring($data);
        return $image ? $image : null;
    }

    protected function academy_model_id($token)
    {
        $this->load->model('academy_model');
        return $this->academy_model->quranPlaylistStudentId($token);
    }
}
