<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Web Push (VAPID + aes128gcm) for the parent Quran app.
 * One phone can subscribe to more than one child; the caller picks the audience.
 */
class Web_push
{
    protected $publicKey = '';
    protected $privatePem = '';
    protected $subject = 'mailto:info@tahsinacademy.ng';

    public function __construct($params = array())
    {
        if (!empty($params['public'])) {
            $this->publicKey = (string) $params['public'];
            $this->privatePem = (string) $params['private'];
            if (!empty($params['subject'])) {
                $this->subject = (string) $params['subject'];
            }
        }
    }

    public function configured()
    {
        return $this->publicKey !== '' && $this->privatePem !== '';
    }

    /**
     * @param array{endpoint:string,p256dh:string,auth:string} $subscription
     * @return array{ok:bool,status:int,gone:bool,error:string}
     */
    public function send($subscription, $payload)
    {
        $fail = array('ok' => false, 'status' => 0, 'gone' => false, 'error' => '');
        if (!$this->configured() || !function_exists('curl_init')) {
            $fail['error'] = 'Push is not available on this server.';
            return $fail;
        }
        $endpoint = isset($subscription['endpoint']) ? (string) $subscription['endpoint'] : '';
        $uaPublic = self::b64urlDecode(isset($subscription['p256dh']) ? $subscription['p256dh'] : '');
        $auth = self::b64urlDecode(isset($subscription['auth']) ? $subscription['auth'] : '');
        if ($endpoint === '' || strlen($uaPublic) !== 65 || strlen($auth) !== 16) {
            $fail['error'] = 'This phone subscription is incomplete.';
            return $fail;
        }
        $body = $this->encrypt($payload, $uaPublic, $auth);
        if ($body === '') {
            $fail['error'] = 'Could not seal the notification.';
            return $fail;
        }
        $jwt = $this->vapidJwt($endpoint);
        if ($jwt === '') {
            $fail['error'] = 'Could not sign the notification.';
            return $fail;
        }
        $ch = curl_init($endpoint);
        curl_setopt_array($ch, array(
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $body,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/octet-stream',
                'Content-Encoding: aes128gcm',
                'TTL: 86400',
                'Authorization: vapid t=' . $jwt . ', k=' . $this->publicKey,
            ),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 20,
        ));
        curl_exec($ch);
        $status = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $err = curl_error($ch);
        curl_close($ch);
        if ($status >= 200 && $status < 300) {
            return array('ok' => true, 'status' => $status, 'gone' => false, 'error' => '');
        }
        return array(
            'ok' => false,
            'status' => $status,
            'gone' => ($status === 404 || $status === 410),
            'error' => $err !== '' ? $err : ('Push service returned ' . $status),
        );
    }

    /**
     * Local check that encryption can be opened with the phone's private key.
     */
    public function roundTripOk()
    {
        $ua = self::ecKey();
        if (!$ua) {
            return false;
        }
        $details = openssl_pkey_get_details($ua);
        $uaPublic = "\x04" . str_pad($details['ec']['x'], 32, "\x00", STR_PAD_LEFT) . str_pad($details['ec']['y'], 32, "\x00", STR_PAD_LEFT);
        $auth = random_bytes(16);
        $plain = '{"title":"Tahsin Academy","body":"round trip"}';
        $packed = $this->encrypt($plain, $uaPublic, $auth);
        if (strlen($packed) < 86) {
            return false;
        }
        $salt = substr($packed, 0, 16);
        $idLen = ord($packed[20]);
        $asPublic = substr($packed, 21, $idLen);
        $cipher = substr($packed, 21 + $idLen);
        $shared = openssl_pkey_derive(self::p256Pem($asPublic), $ua, 32);
        if ($shared === false || strlen($shared) !== 32) {
            return false;
        }
        $ikm = hash_hkdf('sha256', $shared, 32, "WebPush: info\0" . $uaPublic . $asPublic, $auth);
        $cek = hash_hkdf('sha256', $ikm, 16, "Content-Encoding: aes128gcm\0", $salt);
        $nonce = hash_hkdf('sha256', $ikm, 12, "Content-Encoding: nonce\0", $salt);
        $tag = substr($cipher, -16);
        $opened = openssl_decrypt(substr($cipher, 0, -16), 'aes-128-gcm', $cek, OPENSSL_RAW_DATA, $nonce, $tag);
        if ($opened === false) {
            return false;
        }
        $cut = strpos($opened, "\x02");
        if ($cut === false) {
            return false;
        }
        return substr($opened, 0, $cut) === $plain;
    }

    public static function b64urlEncode($bin)
    {
        return rtrim(strtr(base64_encode($bin), '+/', '-_'), '=');
    }

    public static function b64urlDecode($text)
    {
        $text = strtr((string) $text, '-_', '+/');
        $pad = strlen($text) % 4;
        if ($pad) {
            $text .= str_repeat('=', 4 - $pad);
        }
        $out = base64_decode($text, true);
        return $out === false ? '' : $out;
    }

    public static function generateVapid()
    {
        $key = self::ecKey();
        if (!$key) {
            return null;
        }
        $pem = '';
        $export = array();
        $cnf = self::opensslCnf();
        if ($cnf !== '') {
            $export['config'] = $cnf;
        }
        if (!openssl_pkey_export($key, $pem, null, $export)) {
            return null;
        }
        $details = openssl_pkey_get_details($key);
        if (empty($details['ec']['x']) || empty($details['ec']['y'])) {
            return null;
        }
        $raw = "\x04" . str_pad($details['ec']['x'], 32, "\x00", STR_PAD_LEFT) . str_pad($details['ec']['y'], 32, "\x00", STR_PAD_LEFT);
        return array(
            'public' => self::b64urlEncode($raw),
            'private' => $pem,
        );
    }

    protected function encrypt($payload, $uaPublic, $auth)
    {
        $local = self::ecKey();
        if (!$local) {
            return '';
        }
        $details = openssl_pkey_get_details($local);
        $asPublic = "\x04" . str_pad($details['ec']['x'], 32, "\x00", STR_PAD_LEFT) . str_pad($details['ec']['y'], 32, "\x00", STR_PAD_LEFT);
        $shared = openssl_pkey_derive(self::p256Pem($uaPublic), $local, 32);
        if ($shared === false || strlen($shared) !== 32) {
            return '';
        }
        $salt = random_bytes(16);
        $ikm = hash_hkdf('sha256', $shared, 32, "WebPush: info\0" . $uaPublic . $asPublic, $auth);
        $cek = hash_hkdf('sha256', $ikm, 16, "Content-Encoding: aes128gcm\0", $salt);
        $nonce = hash_hkdf('sha256', $ikm, 12, "Content-Encoding: nonce\0", $salt);
        $tag = '';
        $cipher = openssl_encrypt($payload . "\x02", 'aes-128-gcm', $cek, OPENSSL_RAW_DATA, $nonce, $tag, '', 16);
        if ($cipher === false || strlen($tag) !== 16) {
            return '';
        }
        return $salt . pack('N', 4096) . chr(65) . $asPublic . $cipher . $tag;
    }

    protected function vapidJwt($endpoint)
    {
        $parts = parse_url($endpoint);
        if (empty($parts['scheme']) || empty($parts['host'])) {
            return '';
        }
        $header = self::b64urlEncode('{"typ":"JWT","alg":"ES256"}');
        $claim = self::b64urlEncode(json_encode(array(
            'aud' => $parts['scheme'] . '://' . $parts['host'],
            'exp' => time() + (12 * 3600),
            'sub' => $this->subject,
        )));
        $data = $header . '.' . $claim;
        $der = '';
        if (!openssl_sign($data, $der, $this->privatePem, OPENSSL_ALGO_SHA256)) {
            return '';
        }
        $raw = self::derToRaw($der);
        if (strlen($raw) !== 64) {
            return '';
        }
        return $data . '.' . self::b64urlEncode($raw);
    }

    protected static function p256Pem($raw65)
    {
        $der = hex2bin('3059301306072a8648ce3d020106082a8648ce3d030107034200') . $raw65;
        return "-----BEGIN PUBLIC KEY-----\n" . chunk_split(base64_encode($der), 64, "\n") . "-----END PUBLIC KEY-----\n";
    }

    protected static function derToRaw($der)
    {
        $pos = 0;
        if (strlen($der) < 8 || ord($der[$pos++]) !== 0x30) {
            return '';
        }
        self::derLen($der, $pos);
        if (ord($der[$pos++]) !== 0x02) {
            return '';
        }
        $rLen = self::derLen($der, $pos);
        $r = substr($der, $pos, $rLen);
        $pos += $rLen;
        if (ord($der[$pos++]) !== 0x02) {
            return '';
        }
        $sLen = self::derLen($der, $pos);
        $s = substr($der, $pos, $sLen);
        $r = ltrim($r, "\x00");
        $s = ltrim($s, "\x00");
        if (strlen($r) > 32 || strlen($s) > 32) {
            return '';
        }
        return str_pad($r, 32, "\x00", STR_PAD_LEFT) . str_pad($s, 32, "\x00", STR_PAD_LEFT);
    }

    protected static function opensslCnf()
    {
        static $path = null;
        if ($path !== null) {
            return $path;
        }
        $php = defined('PHP_BINARY') ? PHP_BINARY : '';
        $candidates = array(
            getenv('OPENSSL_CONF') ? getenv('OPENSSL_CONF') : '',
            $php !== '' ? dirname($php) . '/extras/ssl/openssl.cnf' : '',
            'C:/xampp/php/extras/ssl/openssl.cnf',
            'C:/xampp/apache/conf/openssl.cnf',
            '/etc/ssl/openssl.cnf',
            '/usr/lib/ssl/openssl.cnf',
        );
        foreach ($candidates as $candidate) {
            $candidate = str_replace('\\', '/', (string) $candidate);
            if ($candidate !== '' && is_file($candidate)) {
                $path = $candidate;
                return $path;
            }
        }
        $path = '';
        return $path;
    }

    protected static function ecKey()
    {
        $opts = array('private_key_type' => OPENSSL_KEYTYPE_EC, 'curve_name' => 'prime256v1');
        $cnf = self::opensslCnf();
        if ($cnf !== '') {
            $opts['config'] = $cnf;
        }
        $key = openssl_pkey_new($opts);
        return $key ? $key : null;
    }

    protected static function derLen($der, &$pos)
    {
        $len = ord($der[$pos++]);
        if (($len & 0x80) === 0) {
            return $len;
        }
        $n = $len & 0x7f;
        $len = 0;
        while ($n-- > 0) {
            $len = ($len << 8) | ord($der[$pos++]);
        }
        return $len;
    }
}
