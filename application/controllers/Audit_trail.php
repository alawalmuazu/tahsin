<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Audit_trail extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('audit_trail_model');
        $this->load->library('app_audit');
    }

    public function index()
    {
        if (!get_permission('audit_trail', 'is_view')) {
            access_denied();
        }

        $this->data['title'] = 'Audit Trail';
        $this->data['sub_page'] = 'audit_trail/index';
        $this->data['main_menu'] = 'settings';
        $this->data['filters'] = array(
            'action' => $this->input->get('action'),
            'module' => $this->input->get('module'),
            'user'   => $this->input->get('user'),
            'from'   => $this->input->get('from'),
            'to'     => $this->input->get('to'),
            'q'      => $this->input->get('q'),
        );
        $this->data['actions'] = $this->audit_trail_model->distinctActions();
        $this->data['modules'] = $this->audit_trail_model->distinctModules();
        $this->data['logs'] = $this->audit_trail_model->getLogs($this->data['filters'], 250);
        $this->load->view('layout/index', $this->data);
    }

    public function view($id = 0)
    {
        if (!get_permission('audit_trail', 'is_view')) {
            access_denied();
        }
        $id = (int) $id;
        $row = $this->audit_trail_model->getById($id);
        if (!$row) {
            set_alert('error', 'Audit record not found.');
            redirect(base_url('audit_trail'));
        }
        $this->data['title'] = 'Audit Detail #' . $id;
        $this->data['sub_page'] = 'audit_trail/view';
        $this->data['main_menu'] = 'settings';
        $this->data['row'] = $row;
        $this->load->view('layout/index', $this->data);
    }

    public function clear()
    {
        if (!get_permission('audit_trail', 'is_delete')) {
            access_denied();
        }
        if (isset($this->db->audit_enabled)) {
            $this->db->audit_enabled = false;
        }
        $this->db->truncate('audit_log');
        if (isset($this->db->audit_enabled)) {
            $this->db->audit_enabled = true;
        }
        $this->app_audit->log('CLEAR', 'audit_trail', 'Audit trail cleared by administrator');
        set_alert('success', 'Audit trail cleared.');
        redirect(base_url('audit_trail'));
    }
}
