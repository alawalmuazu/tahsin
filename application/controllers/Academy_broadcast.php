<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Academy_broadcast extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('academy_model');
    }

    public function index()
    {
        if (!is_loggedin() || is_student_loggedin() || is_parent_loggedin()) {
            access_denied();
        }
        $branchID = $this->application_model->get_branch_id();
        $broadcast = $this->academy_model->generateDailyBroadcast($branchID);

        $this->load->library('whatsapp_cloud');
        $waReady = $this->whatsapp_cloud->isConfigured();

        if ($this->input->post('save_preview')) {
            $this->academy_model->logBroadcastPreview($branchID, $broadcast['reports'], 'preview');
            set_alert('success', 'Broadcast preview saved to log.');
            redirect(base_url('academy_broadcast'));
        }

        if ($this->input->post('clean_akhlaq')) {
            $n = $this->academy_model->cleanAkhlaqTelemetryTags();
            set_alert('success', 'Cleaned telemetry tags from ' . (int) $n . ' tahfiz note' . ($n === 1 ? '' : 's') . '.');
            redirect(base_url('academy_broadcast'));
        }

        if ($this->input->post('send_cloud_api')) {
            $result = $this->_sendCloudApi($branchID, $broadcast, null);
            if ($this->_wantsJson()) {
                $this->_jsonSendResult($result);
                return;
            }
            // Avoid Location redirect — browser Redirect Blocker extensions swallow it and look like "nothing happened".
            $this->data['send_result'] = $result;
        }

        if ($this->input->post('send_cloud_one')) {
            $sid = (int) $this->input->post('student_id');
            $result = $this->_sendCloudApi($branchID, $broadcast, $sid);
            if ($this->_wantsJson()) {
                $this->_jsonSendResult($result);
                return;
            }
            $this->data['send_result'] = $result;
        }

        $this->data['broadcast'] = $broadcast;
        $this->data['wa_ready'] = $waReady;
        $this->data['wa_status'] = $this->whatsapp_cloud->statusLabel();
        $this->data['wa_send_media'] = $this->whatsapp_cloud->wantsMediaAfterTemplate();
        if (!isset($this->data['send_result'])) {
            $this->data['send_result'] = null;
        }
        $this->data['title'] = 'Academy Broadcast';
        $this->data['sub_page'] = 'academy/broadcast';
        $this->data['main_menu'] = 'academy';
        $this->load->view('layout/index', $this->data);
    }

    /**
     * @param int|null $onlyStudentId
     * @return array{ok:bool,type:string,message:string}
     */
    protected function _sendCloudApi($branchID, $broadcast, $onlyStudentId = null)
    {
        $this->load->library('whatsapp_cloud');
        if (!$this->whatsapp_cloud->isConfigured()) {
            return array(
                'ok' => false,
                'type' => 'error',
                'message' => 'WhatsApp Cloud API is not configured. Set credentials in application/config/whatsapp.php and enable it.',
            );
        }

        $reports = isset($broadcast['reports']) ? $broadcast['reports'] : array();
        if ($onlyStudentId !== null) {
            $reports = array_values(array_filter($reports, function ($r) use ($onlyStudentId) {
                return (int) $r['student_id'] === (int) $onlyStudentId;
            }));
        }
        $message = $this->academy_model->deliverCloudDigests($branchID, $reports);
        if (strpos($message, 'failed') !== false || strpos($message, 'not configured') !== false) {
            return array('ok' => false, 'type' => 'error', 'message' => $message);
        }
        if (strpos($message, '0 WhatsApp') === 0) {
            return array('ok' => false, 'type' => 'error', 'message' => $message);
        }
        return array('ok' => true, 'type' => 'success', 'message' => $message);
    }

    protected function _wantsJson()
    {
        if ($this->input->post('ajax')) {
            return true;
        }
        return $this->input->is_ajax_request();
    }

    /**
     * @param array{ok:bool,type:string,message:string} $result
     */
    protected function _jsonSendResult($result)
    {
        $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($result));
    }
}
