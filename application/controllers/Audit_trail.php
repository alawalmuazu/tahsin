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

    public function index($scope = 'all')
    {
        if (!get_permission('audit_trail', 'is_view')) {
            access_denied();
        }

        $allowed = array('all', 'security', 'changes');
        if (!in_array($scope, $allowed, true)) {
            $scope = 'all';
        }

        $this->data['scope'] = $scope;
        $this->data['title'] = 'Audit Trail';
        $this->data['sub_page'] = 'audit_trail/index';
        $this->data['main_menu'] = 'settings';
        $this->load->view('layout/index', $this->data);
    }

    public function getLogListDT($scope = 'all')
    {
        if (!get_permission('audit_trail', 'is_view')) {
            access_denied();
        }
        if ($_POST) {
            $allowed = array('all', 'security', 'changes');
            if (!in_array($scope, $allowed, true)) {
                $scope = 'all';
            }
            echo $this->audit_trail_model->getLogListDT($this->input->post(), $scope);
        }
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
        if (is_superadmin_loggedin()) {
            $this->db->truncate('audit_log');
        } else {
            $this->db->where('branch_id', get_loggedin_branch_id());
            $this->db->delete('audit_log');
        }
        if (isset($this->db->audit_enabled)) {
            $this->db->audit_enabled = true;
        }
        $this->app_audit->log('CLEAR', 'audit_trail', 'Audit trail cleared by administrator');
        set_alert('success', 'Audit trail cleared.');
        redirect(base_url('audit_trail'));
    }
}
