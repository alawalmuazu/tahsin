<?php
defined('BASEPATH') or exit('No direct script access allowed');

class School_fees extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('school_fee_model');
        $this->load->model('school_model');
    }

    public function index()
    {
        if (!get_permission('school_fees', 'is_view') && !get_permission('school_settings', 'is_view') && !is_superadmin_loggedin()) {
            access_denied();
        }

        $branchID = $this->application_model->get_branch_id();
        if ($this->input->post('save')) {
            if (!get_permission('school_fees', 'is_edit') && !get_permission('school_settings', 'is_edit') && !is_superadmin_loggedin()) {
                access_denied();
            }
            $default = (float) $this->input->post('default_amount');
            $matrix = $this->input->post('fee');
            if (!$this->school_fee_model->tableReady()) {
                set_alert('error', 'Run school_fees_settings.sql migration first.');
            } else {
                $this->school_fee_model->saveMatrix($branchID, $default, $matrix);
                set_alert('success', translate('information_has_been_updated_successfully'));
            }
            redirect(base_url('school_fees'));
        }

        $this->data['branch_id'] = $branchID;
        $this->data['sections'] = $this->db->where('branch_id', $branchID)->order_by('id', 'ASC')->get('section')->result();
        $this->data['categories'] = $this->loadCategories($branchID);
        $this->data['fee_map'] = $this->school_fee_model->getMap($branchID);
        $this->data['default_amount'] = $this->school_fee_model->getDefaultAmount($branchID);
        $this->data['title'] = 'School Fees';
        $this->data['sub_page'] = 'school_fees/index';
        $this->data['main_menu'] = 'settings';
        $this->load->view('layout/index', $this->data);
    }

    public function resolve()
    {
        $branchID = (int) $this->input->post('branch_id');
        if ($branchID <= 0) {
            $branchID = (int) $this->application_model->get_branch_id();
        }
        $sectionID = (int) $this->input->post('section_id');
        $categoryID = (int) $this->input->post('category_id');
        $amount = $this->school_fee_model->resolveAmount($branchID, $sectionID, $categoryID);
        echo json_encode(array(
            'status' => 'success',
            'amount' => $amount,
            'formatted' => currencyFormat($amount),
        ));
    }

    protected function loadCategories($branchID)
    {
        $this->load->model('pwd_category_model');
        $list = $this->pwd_category_model->getList($branchID, true);
        if (!empty($list)) {
            return $list;
        }
        // Fallback if PWD migration not run yet
        $this->db->where('branch_id', $branchID);
        $this->db->where("name NOT LIKE '[archived]%'", null, false);
        return $this->db->order_by('id', 'ASC')->get('student_category')->result();
    }
}
