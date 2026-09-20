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
            } elseif (!$this->school_fee_model->hasPwdDimension()) {
                set_alert('error', 'Run school_fees_section_programme_pwd.sql migration first.');
            } else {
                $this->school_fee_model->saveMatrix($branchID, $default, $matrix);
                set_alert('success', translate('information_has_been_updated_successfully'));
            }
            redirect(base_url('school_fees'));
        }

        $this->data['branch_id'] = $branchID;
        $this->data['sections'] = $this->db->where('branch_id', $branchID)->order_by('id', 'ASC')->get('section')->result();
        $this->data['programme_categories'] = $this->loadProgrammeCategories($branchID);
        $this->data['pwd_fit'] = null;
        $this->data['pwd_list'] = array();
        $this->load->model('pwd_category_model');
        foreach ($this->pwd_category_model->getList($branchID, true) as $row) {
            if ((int) $row->is_default === 1) {
                $this->data['pwd_fit'] = $row;
            } else {
                $this->data['pwd_list'][] = $row;
            }
        }
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
        $pwdID = (int) $this->input->post('pwd_category_id');
        $amount = $this->school_fee_model->resolveAmount($branchID, $sectionID, $categoryID, $pwdID);
        echo json_encode(array(
            'status' => 'success',
            'amount' => $amount,
            'formatted' => currencyFormat($amount),
        ));
    }

    protected function loadProgrammeCategories($branchID)
    {
        $this->load->model('home_model');
        $official = $this->home_model->getAdmissionTypes($branchID);
        $out = array();
        if (!empty($official)) {
            foreach ($official as $id => $name) {
                $out[] = (object) array('id' => $id, 'name' => $name);
            }
            return $out;
        }
        $this->db->where('branch_id', $branchID);
        $this->db->where("name NOT LIKE '[archived]%'", null, false);
        return $this->db->order_by('id', 'ASC')->get('student_category')->result();
    }
}
