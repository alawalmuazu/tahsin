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

        $this->data['broadcast'] = $broadcast;
        $this->data['title'] = 'Academy Broadcast';
        $this->data['sub_page'] = 'academy/broadcast';
        $this->data['main_menu'] = 'academy';
        $this->load->view('layout/index', $this->data);
    }
}
