<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Meta WhatsApp Business Cloud API client (Graph messages + media).
 */
class Whatsapp_cloud
{
    /** @var CI_Controller */
    protected $CI;
    /** @var array */
    protected $cfg = array();

    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->config->load('whatsapp', true);
        $file = $this->CI->config->item('whatsapp', 'whatsapp');
        $this->cfg = is_array($file) ? $file : array();
        $this->mergeDbConfig();
    }

    /**
     * Prefer School Settings DB row over file placeholders when a row exists.
     */
    protected function mergeDbConfig()
    {
        if (!$this->CI->db->table_exists('whatsapp_cloud_config')) {
            return;
        }
        $branchID = function_exists('get_loggedin_branch_id')
            ? get_loggedin_branch_id()
            : (defined('SCHOOL_ID') ? SCHOOL_ID : 1);
        $row = $this->CI->db->get_where('whatsapp_cloud_config', array('branch_id' => (int) $branchID))->row_array();
        if (empty($row)) {
            return;
        }
        $this->cfg['enabled'] = !empty($row['enabled']);
        $this->cfg['access_token'] = isset($row['access_token']) ? (string) $row['access_token'] : '';
        $this->cfg['phone_number_id'] = isset($row['phone_number_id']) ? (string) $row['phone_number_id'] : '';
        $this->cfg['waba_id'] = isset($row['waba_id']) ? (string) $row['waba_id'] : '';
        $this->cfg['api_version'] = !empty($row['api_version']) ? $row['api_version'] : 'v21.0';
        $this->cfg['template_name'] = !empty($row['template_name']) ? $row['template_name'] : 'tahsin_sealed_digest';
        $this->cfg['template_lang'] = !empty($row['template_lang']) ? $row['template_lang'] : 'en';
        $this->cfg['send_media_after_template'] = !empty($row['send_media_after_template']);
        $this->cfg['media_max_per_student'] = isset($row['media_max_per_student']) ? (int) $row['media_max_per_student'] : 3;
        if (!empty($row['media_convert_url'])) {
            $this->cfg['media_convert_url'] = (string) $row['media_convert_url'];
        }
        // Optional DOCUMENT-header template (in-chat playable clip on cold sends)
        if (!empty($row['template_with_media'])) {
            $this->cfg['template_with_media'] = (string) $row['template_with_media'];
        }
    }

    public function isEnabled()
    {
        return !empty($this->cfg['enabled']);
    }

    public function isConfigured()
    {
        return $this->isEnabled()
            && trim((string) $this->cfgValue('access_token')) !== ''
            && trim((string) $this->cfgValue('phone_number_id')) !== ''
            && trim((string) $this->cfgValue('template_name')) !== '';
    }

    public function statusLabel()
    {
        if (!$this->isEnabled()) {
            return 'Disabled';
        }
        if (!$this->isConfigured()) {
            return 'Not configured';
        }
        return 'Ready';
    }

    public function wantsMediaAfterTemplate()
    {
        return !empty($this->cfg['send_media_after_template']);
    }

    /** Template name that includes a DOCUMENT header for the recitation clip. */
    public function templateWithMediaName()
    {
        $n = trim((string) $this->cfgValue('template_with_media', 'tahsin_digest_with_audio'));
        return $n !== '' ? $n : 'tahsin_digest_with_audio';
    }

    /**
     * Resolve a local uploads file for Meta upload (prefer .mp3 sibling).
     */
    public function resolveLocalMediaFile($url)
    {
        $url = trim((string) $url);
        if ($url === '') {
            return null;
        }
        $local = $this->localPathFromUrl($url);
        if ($local && is_file($local) && preg_match('/\.(wav|webm)$/i', $local)) {
            $converted = $this->ensureMp3PublicUrl($url);
            if (!empty($converted['local']) && is_file($converted['local'])) {
                return $converted['local'];
            }
            $mp3 = preg_replace('/\.(wav|webm)$/i', '.mp3', $local);
            if ($mp3 && is_file($mp3)) {
                return $mp3;
            }
        }
        if ($local && is_file($local)) {
            return $local;
        }
        $public = $this->publicizeMediaUrl($url);
        if (preg_match('/\.(wav|webm)$/i', $public)) {
            $mp3Public = preg_replace('/\.(wav|webm)$/i', '.mp3', $public);
            $mp3Local = $this->localPathFromUrl($mp3Public);
            if ($mp3Local && is_file($mp3Local)) {
                return $mp3Local;
            }
        }
        return $this->localPathFromUrl($public);
    }

    public function mediaMaxPerStudent()
    {
        $n = (int) $this->cfgValue('media_max_per_student', 3);
        return $n > 0 ? $n : 3;
    }

    /**
     * Nigeria-friendly E.164 digits (no +).
     */
    public function normalizePhone($raw)
    {
        $phone = preg_replace('/\D+/', '', (string) $raw);
        if ($phone === '') {
            return '';
        }
        if (strlen($phone) === 11 && $phone[0] === '0') {
            $phone = '234' . substr($phone, 1);
        } elseif (strlen($phone) === 10 && $phone[0] === '7') {
            $phone = '234' . $phone;
        }
        return $phone;
    }

    public function isPublicHttpsUrl($url)
    {
        $url = trim((string) $url);
        if (!preg_match('#^https://#i', $url)) {
            return false;
        }
        $host = parse_url($url, PHP_URL_HOST);
        if (!$host) {
            return false;
        }
        $host = strtolower($host);
        if ($host === 'localhost' || $host === '127.0.0.1' || strpos($host, '192.168.') === 0) {
            return false;
        }
        return true;
    }

    /**
     * HEAD/GET check so we do not put a 404 listen link into the parent template.
     */
    public function urlIsReachable($url, $timeoutSec = 8)
    {
        $url = trim((string) $url);
        if ($url === '' || !function_exists('curl_init')) {
            return false;
        }
        $ch = curl_init($url);
        curl_setopt_array($ch, array(
            CURLOPT_NOBODY => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_CONNECTTIMEOUT => (int) $timeoutSec,
            CURLOPT_TIMEOUT => (int) $timeoutSec,
            CURLOPT_USERAGENT => 'TahsinAcademy-WhatsApp/1.0',
        ));
        curl_exec($ch);
        $code = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $err = curl_errno($ch);
        curl_close($ch);
        if (!$err && $code >= 200 && $code < 400) {
            return true;
        }
        // Some hosts reject HEAD — try a tiny GET range
        $ch = curl_init($url);
        curl_setopt_array($ch, array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_CONNECTTIMEOUT => (int) $timeoutSec,
            CURLOPT_TIMEOUT => (int) $timeoutSec,
            CURLOPT_HTTPHEADER => array('Range: bytes=0-1'),
            CURLOPT_USERAGENT => 'TahsinAcademy-WhatsApp/1.0',
        ));
        curl_exec($ch);
        $code = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $err = curl_errno($ch);
        curl_close($ch);
        return !$err && $code >= 200 && $code < 400;
    }

    /**
     * Rewrite localhost / relative upload URLs to a public HTTPS URL Meta can fetch.
     */
    public function publicizeMediaUrl($url)
    {
        $url = trim((string) $url);
        if ($url === '') {
            return '';
        }
        if (!preg_match('#/(uploads/.+)$#i', $url, $m) && !preg_match('#^(uploads/.+)$#i', $url, $m)) {
            return $url;
        }
        $rel = ltrim($m[1], '/');
        $public = '';
        if (defined('PUBLIC_SITE_URL') && PUBLIC_SITE_URL !== '') {
            $public = rtrim((string) PUBLIC_SITE_URL, '/');
        }
        if ($public === '' || !preg_match('#^https://#i', $public)) {
            $public = rtrim((string) base_url(), '/');
        }
        if (!$this->isPublicHttpsUrl($public . '/' . $rel)) {
            // Last resort: known live host
            $public = 'https://tahsinacademy.ng';
        }
        return $public . '/' . $rel;
    }

    public function reloadConfig()
    {
        $this->mergeDbConfig();
    }

    /**
     * @param string $toE164 digits
     * @param string[] $bodyParams ordered template variables
     * @param string|null $templateName override template name if provided
     * @param string|null $templateLang override template language code if provided
     * @param array|null $headerMedia optional {type:document|image|video, id?:string, link?:string, filename?:string}
     * @return array{ok:bool,wamid:?string,error:?string,raw?:mixed}
     */
    public function sendTemplate($toE164, $bodyParams, $templateName = null, $templateLang = null, $headerMedia = null)
    {
        $to = $this->normalizePhone($toE164);
        if ($to === '') {
            return $this->fail('Missing phone number');
        }
        if (!$this->isConfigured()) {
            return $this->fail('WhatsApp Cloud API is not configured');
        }

        $tpl = !empty($templateName) ? (string) $templateName : (string) $this->cfgValue('template_name');
        $lng = !empty($templateLang) ? (string) $templateLang : (string) $this->cfgValue('template_lang', 'en');

        $components = array();
        if (is_array($headerMedia) && !empty($headerMedia['type'])) {
            $hType = strtolower((string) $headerMedia['type']);
            if (in_array($hType, array('document', 'image', 'video'), true)) {
                $mediaParam = array('type' => $hType);
                $mediaObj = array();
                if (!empty($headerMedia['id'])) {
                    $mediaObj['id'] = (string) $headerMedia['id'];
                } elseif (!empty($headerMedia['link']) && $this->isPublicHttpsUrl($headerMedia['link'])) {
                    $mediaObj['link'] = (string) $headerMedia['link'];
                }
                if ($hType === 'document' && !empty($headerMedia['filename'])) {
                    $mediaObj['filename'] = (string) $headerMedia['filename'];
                }
                if (!empty($mediaObj)) {
                    $mediaParam[$hType] = $mediaObj;
                    $components[] = array(
                        'type' => 'header',
                        'parameters' => array($mediaParam),
                    );
                }
            }
        }

        $params = array();
        foreach ((array) $bodyParams as $p) {
            $text = $this->sanitizeTemplateText($p);
            if ($text === '') {
                $text = '—';
            }
            $params[] = array('type' => 'text', 'text' => $text);
        }
        if (!empty($params)) {
            $components[] = array(
                'type' => 'body',
                'parameters' => $params,
            );
        }

        $payload = array(
            'messaging_product' => 'whatsapp',
            'recipient_type' => 'individual',
            'to' => $to,
            'type' => 'template',
            'template' => array(
                'name' => $tpl,
                'language' => array('code' => $lng),
                'components' => $components,
            ),
        );

        return $this->postMessages($payload);
    }

    /**
     * Session free-form text (24h window only).
     */
    public function sendText($toE164, $body)
    {
        $to = $this->normalizePhone($toE164);
        if ($to === '') {
            return $this->fail('Missing phone number');
        }
        if (!$this->isConfigured()) {
            return $this->fail('WhatsApp Cloud API is not configured');
        }
        $body = trim((string) $body);
        if ($body === '') {
            return $this->fail('Empty message body');
        }
        if (strlen($body) > 4096) {
            $body = substr($body, 0, 4090) . '…';
        }

        $payload = array(
            'messaging_product' => 'whatsapp',
            'recipient_type' => 'individual',
            'to' => $to,
            'type' => 'text',
            'text' => array(
                'preview_url' => true,
                'body' => $body,
            ),
        );
        return $this->postMessages($payload);
    }

    /**
     * Send audio / video / document by public HTTPS link (or upload local file first).
     *
     * @param string $toE164
     * @param string $type audio|video|document|image
     * @param string $url public HTTPS URL
     * @param string $caption optional (video/document/image)
     * @return array{ok:bool,wamid:?string,error:?string,raw?:mixed}
     */
    public function sendMediaByUrl($toE164, $type, $url, $caption = '')
    {
        $to = $this->normalizePhone($toE164);
        $type = strtolower(trim((string) $type));
        $allowed = array('audio', 'video', 'document', 'image');
        if (!in_array($type, $allowed, true)) {
            return $this->fail('Unsupported media type');
        }
        if ($to === '') {
            return $this->fail('Missing phone number');
        }
        if (!$this->isConfigured()) {
            return $this->fail('WhatsApp Cloud API is not configured');
        }

        $url = trim((string) $url);
        if ($url === '') {
            return $this->fail('Missing media URL');
        }

        // Resolve disk path first — localhost URLs are fine if the file is on this server.
        $local = $this->localPathFromUrl($url);
        $publicUrl = $this->isPublicHttpsUrl($url) ? $url : $this->publicizeMediaUrl($url);

        // WhatsApp audio bubbles need mp3/ogg/aac — not wav. Convert when possible.
        $forcedLocal = null;
        if ($type === 'audio' && preg_match('/\.(wav|webm)$/i', $url)) {
            $converted = $this->ensureMp3PublicUrl($local && is_file($local) ? $url : $publicUrl);
            if (!empty($converted['ok'])) {
                if (!empty($converted['url'])) {
                    $publicUrl = $this->isPublicHttpsUrl($converted['url'])
                        ? $converted['url']
                        : $this->publicizeMediaUrl($converted['url']);
                }
                if (!empty($converted['local'])) {
                    $forcedLocal = $converted['local'];
                }
            }
            // Still wav/webm → send as document so the parent at least gets a downloadable clip
            if (preg_match('/\.(wav|webm)$/i', $url) && !$forcedLocal) {
                $type = 'document';
                $caption = $caption !== '' ? $caption : 'Recitation audio (tap to download)';
            } elseif ($forcedLocal && preg_match('/\.mp3$/i', $forcedLocal)) {
                $publicUrl = preg_replace('/\.(wav|webm)$/i', '.mp3', $publicUrl);
            }
        }

        $local = $forcedLocal ? $forcedLocal : ($local && is_file($local) ? $local : $this->localPathFromUrl($publicUrl));
        $mediaObj = null;
        $uploadError = '';

        // Prefer Meta media-id upload (works even when DB still has localhost links)
        if ($local && is_file($local)) {
            $up = $this->uploadMediaFile($local, $type === 'document' ? 'document' : $type);
            if (!empty($up['ok']) && !empty($up['id'])) {
                $mediaObj = array('id' => $up['id']);
            } else {
                $uploadError = isset($up['error']) ? $up['error'] : 'Upload failed';
                if ($type === 'audio' && preg_match('/\.(wav|webm)$/i', (string) $url)) {
                    return $this->fail('Audio is WAV/WebM and could not convert to MP3. ' . $uploadError);
                }
            }
        }

        // Fallback: public HTTPS link Meta can fetch
        if ($mediaObj === null) {
            if (!$this->isPublicHttpsUrl($publicUrl)) {
                $why = $uploadError !== '' ? $uploadError : 'file not on this server';
                return $this->fail('Media needs a public HTTPS URL or a local uploads file (' . $why . ')');
            }
            $mediaObj = array('link' => $publicUrl);
        }

        if ($type === 'document') {
            $filename = basename(parse_url($publicUrl !== '' ? $publicUrl : $url, PHP_URL_PATH) ?: 'recitation.mp3');
            $mediaObj['filename'] = $filename;
        }

        if ($caption !== '' && in_array($type, array('video', 'document', 'image'), true)) {
            $mediaObj['caption'] = mb_substr(trim($caption), 0, 1024);
        }

        $payload = array(
            'messaging_product' => 'whatsapp',
            'recipient_type' => 'individual',
            'to' => $to,
            'type' => $type,
            $type => $mediaObj,
        );
        return $this->postMessages($payload);
    }

    /**
     * Prefer sibling .mp3, local ffmpeg, then VPS convert endpoint.
     * Returns public URL when saved under uploads/, and always a local path for Meta upload when possible.
     *
     * @return array{ok:bool,url:?string,local:?string,error:?string}
     */
    public function ensureMp3PublicUrl($url)
    {
        $url = trim((string) $url);
        if ($url === '' || !preg_match('/\.(wav|webm)$/i', $url)) {
            return array('ok' => true, 'url' => $url, 'local' => null, 'error' => null);
        }
        $mp3Url = preg_replace('/\.(wav|webm)$/i', '.mp3', $url);
        $local = $this->localPathFromUrl($url);
        $mp3Local = $local ? preg_replace('/\.(wav|webm)$/i', '.mp3', $local) : '';

        if ($mp3Local && is_file($mp3Local) && filesize($mp3Local) > 100) {
            return array('ok' => true, 'url' => $mp3Url, 'local' => $mp3Local, 'error' => null);
        }

        if ($local && is_file($local)) {
            $this->CI->load->model('academy_model');
            if (method_exists($this->CI->academy_model, 'convertToMp3')) {
                $converted = $this->CI->academy_model->convertToMp3($local);
                if (is_file($converted) && preg_match('/\.mp3$/i', $converted) && filesize($converted) > 100) {
                    return array('ok' => true, 'url' => $mp3Url, 'local' => $converted, 'error' => null);
                }
            }
        }

        // Hostinger Cloud PHP often has no ffmpeg — convert on the VPS engine
        $convertUrl = trim((string) $this->cfgValue('media_convert_url', 'http://72.62.232.120:8002/v1/media/to-mp3'));
        if ($convertUrl === '' || !function_exists('curl_init')) {
            return array('ok' => false, 'url' => null, 'local' => null, 'error' => 'No convert URL');
        }
        $ch = curl_init($convertUrl);
        curl_setopt_array($ch, array(
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode(array('url' => $url)),
            CURLOPT_HTTPHEADER => array('Content-Type: application/json'),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CONNECTTIMEOUT => 12,
            CURLOPT_TIMEOUT => 120,
        ));
        $body = curl_exec($ch);
        $code = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $err = curl_error($ch);
        curl_close($ch);
        if ($body === false || $code < 200 || $code >= 300 || strlen($body) < 100) {
            $j = json_decode((string) $body, true);
            $msg = is_array($j) && !empty($j['error']) ? $j['error'] : ($err !== '' ? $err : 'VPS convert failed');
            return array('ok' => false, 'url' => null, 'local' => null, 'error' => $msg);
        }

        $saved = null;
        if ($mp3Local) {
            $dir = dirname($mp3Local);
            if (is_dir($dir) && is_writable($dir) && @file_put_contents($mp3Local, $body) !== false) {
                if (is_file($mp3Local) && filesize($mp3Local) > 100) {
                    $saved = $mp3Local;
                }
            }
        }
        if (!$saved) {
            $tmpDir = rtrim(sys_get_temp_dir(), '/\\') . DIRECTORY_SEPARATOR . 'tahsin_wa';
            if (!is_dir($tmpDir)) {
                @mkdir($tmpDir, 0755, true);
            }
            $tmp = $tmpDir . DIRECTORY_SEPARATOR . basename(parse_url($mp3Url, PHP_URL_PATH) ?: ('rec_' . md5($url) . '.mp3'));
            if (@file_put_contents($tmp, $body) !== false && is_file($tmp) && filesize($tmp) > 100) {
                $saved = $tmp;
            }
        }
        if ($saved) {
            // Public URL only if sibling file under uploads exists
            $publicOk = ($mp3Local && $saved === $mp3Local);
            return array(
                'ok' => true,
                'url' => $publicOk ? $mp3Url : $url,
                'local' => $saved,
                'error' => null,
            );
        }
        return array('ok' => false, 'url' => null, 'local' => null, 'error' => 'Could not save converted MP3');
    }

    /**
     * Upload a local file to Meta media endpoint.
     *
     * @return array{ok:bool,id:?string,error:?string}
     */
    public function uploadMediaFile($absolutePath, $typeHint = 'audio')
    {
        if (!$this->isConfigured()) {
            return array('ok' => false, 'id' => null, 'error' => 'Not configured');
        }
        if (!is_file($absolutePath) || !is_readable($absolutePath)) {
            return array('ok' => false, 'id' => null, 'error' => 'File not readable');
        }

        $mime = $this->guessMime($absolutePath, $typeHint);
        $url = $this->graphUrl($this->cfgValue('phone_number_id') . '/media');

        if (!function_exists('curl_init')) {
            return array('ok' => false, 'id' => null, 'error' => 'cURL not available');
        }

        $cfile = class_exists('CURLFile')
            ? new CURLFile($absolutePath, $mime, basename($absolutePath))
            : '@' . $absolutePath;

        $ch = curl_init($url);
        curl_setopt_array($ch, array(
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => (int) $this->cfgValue('request_timeout', 45),
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer ' . $this->cfgValue('access_token'),
            ),
            CURLOPT_POSTFIELDS => array(
                'messaging_product' => 'whatsapp',
                'type' => $mime,
                'file' => $cfile,
            ),
        ));
        $body = curl_exec($ch);
        $errno = curl_errno($ch);
        $err = curl_error($ch);
        $code = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($errno) {
            return array('ok' => false, 'id' => null, 'error' => 'Upload cURL: ' . $err);
        }
        $json = json_decode((string) $body, true);
        if ($code >= 200 && $code < 300 && !empty($json['id'])) {
            return array('ok' => true, 'id' => (string) $json['id'], 'error' => null);
        }
        $msg = $this->extractError($json, $body, $code);
        return array('ok' => false, 'id' => null, 'error' => $msg);
    }

    protected function postMessages(array $payload)
    {
        $url = $this->graphUrl($this->cfgValue('phone_number_id') . '/messages');
        if (!function_exists('curl_init')) {
            return $this->fail('cURL not available');
        }

        $ch = curl_init($url);
        curl_setopt_array($ch, array(
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => (int) $this->cfgValue('request_timeout', 45),
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer ' . $this->cfgValue('access_token'),
                'Content-Type: application/json',
            ),
            CURLOPT_POSTFIELDS => json_encode($payload),
        ));
        $body = curl_exec($ch);
        $errno = curl_errno($ch);
        $err = curl_error($ch);
        $code = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($errno) {
            return $this->fail('cURL: ' . $err);
        }
        $json = json_decode((string) $body, true);
        if ($code >= 200 && $code < 300 && !empty($json['messages'][0]['id'])) {
            return array(
                'ok' => true,
                'wamid' => (string) $json['messages'][0]['id'],
                'error' => null,
                'raw' => $json,
            );
        }
        return $this->fail($this->extractError($json, $body, $code), $json);
    }

    protected function graphUrl($path)
    {
        $base = rtrim((string) $this->cfgValue('graph_base', 'https://graph.facebook.com'), '/');
        $ver = trim((string) $this->cfgValue('api_version', 'v21.0'), '/');
        return $base . '/' . $ver . '/' . ltrim($path, '/');
    }

    protected function cfgValue($key, $default = '')
    {
        return isset($this->cfg[$key]) ? $this->cfg[$key] : $default;
    }

    protected function sanitizeTemplateText($text)
    {
        $text = trim(preg_replace('/\s+/u', ' ', (string) $text));
        // Meta rejects newlines / tabs in template params
        $text = str_replace(array("\r", "\n", "\t"), ' ', $text);
        if (mb_strlen($text) > 1024) {
            $text = mb_substr($text, 0, 1020) . '…';
        }
        return $text;
    }

    protected function fail($message, $raw = null)
    {
        $out = array('ok' => false, 'wamid' => null, 'error' => (string) $message);
        if ($raw !== null) {
            $out['raw'] = $raw;
        }
        return $out;
    }

    protected function extractError($json, $body, $httpCode)
    {
        if (is_array($json) && !empty($json['error']['message'])) {
            $msg = $json['error']['message'];
            if (!empty($json['error']['error_user_msg'])) {
                $msg .= ' — ' . $json['error']['error_user_msg'];
            }
            return $msg;
        }
        $snippet = is_string($body) ? substr($body, 0, 180) : '';
        return 'HTTP ' . (int) $httpCode . ($snippet !== '' ? ': ' . $snippet : '');
    }

    protected function localPathFromUrl($url)
    {
        $url = trim((string) $url);
        if ($url === '') {
            return null;
        }
        // Already a relative uploads path
        if (preg_match('#^(uploads[\\\\/].+)$#i', str_replace('\\', '/', $url), $m)) {
            $full = FCPATH . str_replace(array('/', '\\'), DIRECTORY_SEPARATOR, $m[1]);
            return is_file($full) ? $full : null;
        }
        $path = parse_url($url, PHP_URL_PATH);
        if (!$path) {
            $path = $url;
        }
        // Expect /tahsin/uploads/... or /uploads/...
        if (preg_match('#/(uploads/.+)$#i', $path, $m)) {
            $rel = str_replace(array('/', '\\'), DIRECTORY_SEPARATOR, $m[1]);
            $full = FCPATH . $rel;
            if (is_file($full)) {
                return $full;
            }
        }
        return null;
    }

    protected function guessMime($path, $typeHint)
    {
        $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        $map = array(
            'ogg' => 'audio/ogg',
            'opus' => 'audio/ogg',
            'mp3' => 'audio/mpeg',
            'aac' => 'audio/aac',
            'm4a' => 'audio/mp4',
            'wav' => 'audio/wav',
            'webm' => $typeHint === 'video' ? 'video/webm' : 'audio/webm',
            'mp4' => 'video/mp4',
            '3gp' => 'video/3gpp',
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'pdf' => 'application/pdf',
        );
        if (isset($map[$ext])) {
            return $map[$ext];
        }
        if (function_exists('mime_content_type')) {
            $m = @mime_content_type($path);
            if ($m) {
                return $m;
            }
        }
        if ($typeHint === 'document') {
            return isset($map[$ext]) ? $map[$ext] : 'application/octet-stream';
        }
        if ($typeHint === 'video') {
            return 'video/mp4';
        }
        if ($typeHint === 'image') {
            return 'image/jpeg';
        }
        return 'audio/mpeg';
    }
}
