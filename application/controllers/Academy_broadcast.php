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
            $this->_sendCloudApi($branchID, $broadcast, null);
            redirect(base_url('academy_broadcast'));
        }

        if ($this->input->post('send_cloud_one')) {
            $sid = (int) $this->input->post('student_id');
            $this->_sendCloudApi($branchID, $broadcast, $sid);
            redirect(base_url('academy_broadcast'));
        }

        $this->data['broadcast'] = $broadcast;
        $this->data['wa_ready'] = $waReady;
        $this->data['wa_status'] = $this->whatsapp_cloud->statusLabel();
        $this->data['wa_send_media'] = $this->whatsapp_cloud->wantsMediaAfterTemplate();
        $this->data['title'] = 'Academy Broadcast';
        $this->data['sub_page'] = 'academy/broadcast';
        $this->data['main_menu'] = 'academy';
        $this->load->view('layout/index', $this->data);
    }

    /**
     * @param int|null $onlyStudentId
     */
    protected function _sendCloudApi($branchID, $broadcast, $onlyStudentId = null)
    {
        $this->load->library('whatsapp_cloud');
        if (!$this->whatsapp_cloud->isConfigured()) {
            set_alert('error', 'WhatsApp Cloud API is not configured. Set credentials in application/config/whatsapp.php and enable it.');
            return;
        }

        $sent = 0;
        $failed = 0;
        $skipped = 0;
        $mediaSent = 0;
        $mediaFailed = 0;
        $reports = isset($broadcast['reports']) ? $broadcast['reports'] : array();

        foreach ($reports as $r) {
            if ($onlyStudentId !== null && (int) $r['student_id'] !== (int) $onlyStudentId) {
                continue;
            }
            $phone = $this->whatsapp_cloud->normalizePhone(isset($r['parent_contact']) ? $r['parent_contact'] : '');
            if ($phone === '') {
                $skipped++;
                $this->academy_model->logBroadcastSend($branchID, $r, 'whatsapp_cloud', 'skipped', null, 'No parent phone');
                continue;
            }

            $params = $this->academy_model->digestTemplateParams($r);
            $result = $this->whatsapp_cloud->sendTemplate($phone, $params);
            if (!empty($result['ok'])) {
                $sent++;
                $this->academy_model->logBroadcastSend(
                    $branchID,
                    $r,
                    'whatsapp_cloud',
                    'sent',
                    isset($result['wamid']) ? $result['wamid'] : null,
                    null
                );
            } else {
                $failed++;
                $err = isset($result['error']) ? $result['error'] : 'Send failed';
                $this->academy_model->logBroadcastSend($branchID, $r, 'whatsapp_cloud', 'failed', null, $err);
                usleep(150000);
                continue;
            }

            if ($this->whatsapp_cloud->wantsMediaAfterTemplate()) {
                $mediaItems = $this->academy_model->digestMediaPayloads($r, $this->whatsapp_cloud->mediaMaxPerStudent());
                foreach ($mediaItems as $item) {
                    $mres = $this->whatsapp_cloud->sendMediaByUrl(
                        $phone,
                        $item['type'],
                        $item['url'],
                        isset($item['caption']) ? $item['caption'] : ''
                    );
                    if (!empty($mres['ok'])) {
                        $mediaSent++;
                        $this->academy_model->logBroadcastSend(
                            $branchID,
                            $r,
                            'whatsapp_cloud_media',
                            'sent',
                            isset($mres['wamid']) ? $mres['wamid'] : null,
                            null
                        );
                    } else {
                        $mediaFailed++;
                        $merr = isset($mres['error']) ? $mres['error'] : 'Media send failed';
                        $this->academy_model->logBroadcastSend(
                            $branchID,
                            $r,
                            'whatsapp_cloud_media',
                            'failed',
                            null,
                            $merr
                        );
                    }
                    usleep(200000);
                }
            }

            usleep(200000);
        }

        $parts = array();
        $parts[] = $sent . ' digest' . ($sent === 1 ? '' : 's') . ' sent';
        if ($failed) {
            $parts[] = $failed . ' failed';
        }
        if ($skipped) {
            $parts[] = $skipped . ' skipped (no phone)';
        }
        if ($mediaSent || $mediaFailed) {
            $parts[] = $mediaSent . ' media ok';
            if ($mediaFailed) {
                $parts[] = $mediaFailed . ' media failed (links still in digest; native attach needs open chat window)';
            }
        }

        if ($sent > 0 && $failed === 0) {
            set_alert('success', implode(' · ', $parts) . '.');
        } elseif ($sent > 0) {
            set_alert('warning', implode(' · ', $parts) . '.');
        } else {
            set_alert('error', implode(' · ', $parts) . '.');
        }
    }
}
