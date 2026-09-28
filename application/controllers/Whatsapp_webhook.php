<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Public Meta WhatsApp webhook.
 * GET  hub.mode=subscribe verifies the callback URL.
 * POST delivery statuses update academy_broadcast_log by wamid.
 * Template review events are stored in whatsapp_webhook_event.
 */
class Whatsapp_webhook extends CI_Controller
{
    public function index()
    {
        $method = strtoupper((string) $this->input->method(true));
        if ($method === 'GET') {
            $this->verify();
            return;
        }
        if ($method === 'POST') {
            $this->receive();
            return;
        }
        $this->plain(405, 'Method not allowed');
    }

    protected function verify()
    {
        $mode = $this->hubParam('mode');
        $token = $this->hubParam('verify_token');
        $challenge = $this->hubParam('challenge');
        if ($mode === '' && $token === '' && $challenge === '') {
            $this->plain(200, 'WhatsApp webhook is ready.');
            return;
        }
        $expected = $this->verifyToken();
        if ($expected === '' || $mode !== 'subscribe' || !hash_equals($expected, $token)) {
            $this->plain(403, 'Forbidden');
            return;
        }
        header('Content-Type: text/plain; charset=utf-8');
        http_response_code(200);
        echo $challenge;
    }

    protected function receive()
    {
        $raw = $this->input->raw_input_stream;
        if (!is_string($raw) || strlen($raw) > 1000000) {
            $this->plain(413, 'Payload too large');
            return;
        }
        $body = json_decode($raw, true);
        if (!is_array($body)) {
            $this->json(200, array('ok' => true, 'ignored' => 'not json'));
            return;
        }
        $entries = isset($body['entry']) && is_array($body['entry']) ? $body['entry'] : array();
        foreach ($entries as $entry) {
            if (!is_array($entry)) {
                continue;
            }
            $changes = isset($entry['changes']) && is_array($entry['changes']) ? $entry['changes'] : array();
            foreach ($changes as $change) {
                if (!is_array($change)) {
                    continue;
                }
                $this->applyChange($change);
            }
        }
        $this->json(200, array('ok' => true));
    }

    protected function applyChange(array $change)
    {
        $field = isset($change['field']) ? substr((string) $change['field'], 0, 64) : '';
        $value = isset($change['value']) && is_array($change['value']) ? $change['value'] : array();
        if ($field === 'messages' && !empty($value['statuses']) && is_array($value['statuses'])) {
            foreach ($value['statuses'] as $statusRow) {
                if (is_array($statusRow)) {
                    $this->applyStatus($field, $statusRow);
                }
            }
            return;
        }
        $this->storeEvent(array(
            'event_field' => $field !== '' ? $field : 'unknown',
            'template_name' => $this->pick($value, array('message_template_name', 'template_name')),
            'template_event' => $this->templateEventLabel($value),
        ));
    }

    protected function applyStatus($field, array $statusRow)
    {
        $wamid = isset($statusRow['id']) ? substr((string) $statusRow['id'], 0, 120) : '';
        $status = isset($statusRow['status']) ? strtolower(substr((string) $statusRow['status'], 0, 20)) : '';
        $recipient = isset($statusRow['recipient_id']) ? substr((string) $statusRow['recipient_id'], 0, 32) : '';
        $errorCode = '';
        $errorTitle = '';
        if (!empty($statusRow['errors'][0]) && is_array($statusRow['errors'][0])) {
            $err = $statusRow['errors'][0];
            $errorCode = isset($err['code']) ? substr((string) $err['code'], 0, 16) : '';
            $errorTitle = isset($err['title']) ? substr((string) $err['title'], 0, 255) : '';
            if ($errorTitle === '' && isset($err['message'])) {
                $errorTitle = substr((string) $err['message'], 0, 255);
            }
        }
        $this->storeEvent(array(
            'event_field' => $field,
            'wamid' => $wamid !== '' ? $wamid : null,
            'delivery_status' => $status !== '' ? $status : null,
            'error_code' => $errorCode !== '' ? $errorCode : null,
            'error_title' => $errorTitle !== '' ? $errorTitle : null,
            'recipient' => $recipient !== '' ? $recipient : null,
        ));
        if ($wamid !== '' && $status !== '') {
            $note = $errorCode !== '' ? trim($errorCode . ' ' . $errorTitle) : '';
            $this->updateBroadcast($wamid, $status, $note);
        }
    }

    protected function updateBroadcast($wamid, $status, $note)
    {
        if (!$this->db->table_exists('academy_broadcast_log') || !$this->db->field_exists('meta_message_id', 'academy_broadcast_log')) {
            return;
        }
        $rows = $this->db->get_where('academy_broadcast_log', array('meta_message_id' => $wamid))->result_array();
        foreach ($rows as $row) {
            $current = isset($row['status']) ? (string) $row['status'] : '';
            if (!$this->statusReplaces($current, $status)) {
                continue;
            }
            $update = array('status' => substr($status, 0, 20));
            if ($note !== '' && $this->db->field_exists('error_message', 'academy_broadcast_log')) {
                $update['error_message'] = substr($note, 0, 2000);
            }
            $this->db->where('id', (int) $row['id']);
            $this->db->update('academy_broadcast_log', $update);
        }
    }

    protected function statusReplaces($current, $next)
    {
        $rank = array(
            'preview' => 0,
            'sent' => 1,
            'delivered' => 2,
            'read' => 3,
            'failed' => 4,
        );
        $c = isset($rank[$current]) ? $rank[$current] : 0;
        $n = isset($rank[$next]) ? $rank[$next] : 0;
        return $n >= $c;
    }

    protected function storeEvent(array $row)
    {
        if (!$this->db->table_exists('whatsapp_webhook_event')) {
            return;
        }
        $row['branch_id'] = 1;
        $this->db->insert('whatsapp_webhook_event', $row);
    }

    protected function templateEventLabel(array $value)
    {
        if (!empty($value['event'])) {
            return substr((string) $value['event'], 0, 64);
        }
        if (!empty($value['new_category'])) {
            $prev = isset($value['previous_category']) ? (string) $value['previous_category'] : '';
            $label = ($prev !== '' ? $prev . ' → ' : '') . (string) $value['new_category'];
            return substr($label, 0, 64);
        }
        return null;
    }

    protected function pick(array $value, array $keys)
    {
        foreach ($keys as $key) {
            if (!empty($value[$key])) {
                return substr((string) $value[$key], 0, 120);
            }
        }
        return null;
    }

    protected function verifyToken()
    {
        if (!$this->db->table_exists('whatsapp_cloud_config') || !$this->db->field_exists('webhook_verify_token', 'whatsapp_cloud_config')) {
            return '';
        }
        $row = $this->db->select('webhook_verify_token')->order_by('id', 'ASC')->limit(1)->get('whatsapp_cloud_config')->row_array();
        return !empty($row['webhook_verify_token']) ? (string) $row['webhook_verify_token'] : '';
    }

    /**
     * PHP turns hub.challenge into hub_challenge. Accept both spellings.
     */
    protected function hubParam($name)
    {
        $dotted = 'hub.' . $name;
        $under = 'hub_' . $name;
        $val = $this->input->get($under, true);
        if ($val === null || $val === '') {
            $val = $this->input->get($dotted, true);
        }
        if (($val === null || $val === '') && isset($_GET[$under])) {
            $val = $_GET[$under];
        }
        if (($val === null || $val === '') && isset($_GET[$dotted])) {
            $val = $_GET[$dotted];
        }
        return is_string($val) ? $val : '';
    }

    protected function plain($code, $body)
    {
        header('Content-Type: text/plain; charset=utf-8');
        http_response_code((int) $code);
        echo $body;
    }

    protected function json($code, array $body)
    {
        header('Content-Type: application/json; charset=utf-8');
        http_response_code((int) $code);
        echo json_encode($body);
    }
}
