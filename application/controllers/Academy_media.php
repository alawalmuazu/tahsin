<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Server-to-server sync so localhost milestone saves land on the public Hostinger disk.
 * Auth: header X-Tahsin-Media-Sync or POST field sync_secret (ACADEMY_MEDIA_SYNC_SECRET).
 */
class Academy_media extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function receive()
    {
        header('Content-Type: application/json; charset=utf-8');
        if (strtoupper((string) $this->input->method(true)) !== 'POST') {
            http_response_code(405);
            echo json_encode(array('ok' => false, 'error' => 'POST required'));
            return;
        }

        $expected = defined('ACADEMY_MEDIA_SYNC_SECRET') ? (string) ACADEMY_MEDIA_SYNC_SECRET : '';
        if ($expected === '') {
            http_response_code(503);
            echo json_encode(array('ok' => false, 'error' => 'Sync not configured'));
            return;
        }

        $got = (string) $this->input->get_request_header('X-Tahsin-Media-Sync', true);
        if ($got === '') {
            $got = (string) $this->input->post('sync_secret');
        }
        if ($got === '' || !hash_equals($expected, $got)) {
            http_response_code(403);
            echo json_encode(array('ok' => false, 'error' => 'Forbidden'));
            return;
        }

        if (empty($_FILES['audio']) || !is_uploaded_file($_FILES['audio']['tmp_name'])) {
            http_response_code(400);
            echo json_encode(array('ok' => false, 'error' => 'audio file required'));
            return;
        }

        $name = basename((string) $this->input->post('filename'));
        if ($name === '' || $name === '.' || $name === '..') {
            $name = basename((string) $_FILES['audio']['name']);
        }
        $name = preg_replace('/[^a-zA-Z0-9._-]/', '_', $name);
        $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
        $allowed = array('mp3', 'wav', 'ogg', 'webm', 'm4a', 'mp4', 'opus', 'mpeg');
        if (!in_array($ext, $allowed, true)) {
            http_response_code(400);
            echo json_encode(array('ok' => false, 'error' => 'unsupported type'));
            return;
        }
        if ((int) $_FILES['audio']['size'] > 40 * 1024 * 1024) {
            http_response_code(400);
            echo json_encode(array('ok' => false, 'error' => 'file too large'));
            return;
        }

        $dir = FCPATH . 'uploads/academy_tahfiz/';
        if (!is_dir($dir)) {
            @mkdir($dir, 0755, true);
        }
        if (!is_file($dir . 'index.html')) {
            @file_put_contents($dir . 'index.html', '<!DOCTYPE html><title>403</title>');
        }

        $dest = $dir . $name;
        if (!@move_uploaded_file($_FILES['audio']['tmp_name'], $dest)) {
            http_response_code(500);
            echo json_encode(array('ok' => false, 'error' => 'could not save'));
            return;
        }
        @chmod($dest, 0644);

        $public = (defined('PUBLIC_SITE_URL') ? rtrim(PUBLIC_SITE_URL, '/') : rtrim(base_url(), '/'))
            . '/uploads/academy_tahfiz/' . rawurlencode($name);

        echo json_encode(array(
            'ok' => true,
            'path' => 'uploads/academy_tahfiz/' . $name,
            'url' => $public,
            'bytes' => (int) filesize($dest),
        ));
    }
}
