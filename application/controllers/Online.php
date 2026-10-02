<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Online extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('online_model');
        $this->load->model('school_fee_model');
    }

    public function index()
    {
        $this->guard();
        $branchID = $this->application_model->get_branch_id();
        $this->data['students'] = $this->online_model->roster($branchID);
        $this->data['ready'] = $this->online_model->ready();
        $this->data['title'] = 'Online students';
        $this->data['sub_page'] = 'online/students';
        $this->data['main_menu'] = 'online';
        $this->load->view('layout/index', $this->data);
    }

    public function fees()
    {
        $this->guard(true);
        $branchID = $this->application_model->get_branch_id();
        if ($this->input->post('save')) {
            if (!$this->canEditFees()) {
                access_denied();
            }
            if (!$this->school_fee_model->pricesReady()) {
                set_alert('error', 'Run application/migrations/online_fee_currency.sql first.');
            } else {
                $posted = $this->input->post('online_price');
                $prices = array();
                foreach ($this->school_fee_model->currencies() as $code => $label) {
                    $prices[$code] = parse_money_input(is_array($posted) && isset($posted[$code]) ? $posted[$code] : 0);
                }
                $this->school_fee_model->savePrices($branchID, $prices);
                set_alert('success', translate('information_has_been_updated_successfully'));
            }
            redirect(base_url('online/fees'));
        }
        $this->data['prices_ready'] = $this->school_fee_model->pricesReady();
        $this->data['online_prices'] = $this->school_fee_model->getPrices($branchID);
        $this->data['online_currencies'] = $this->school_fee_model->currencies();
        $rateBoard = $this->school_fee_model->rateBoard();
        $this->data['online_rates'] = $rateBoard['rates'];
        $this->data['online_rate_at'] = $rateBoard['fetched_at'];
        $this->data['online_rate_ok'] = $rateBoard['ok'];
        $this->data['can_edit'] = $this->canEditFees();
        $this->data['title'] = 'Online fees';
        $this->data['sub_page'] = 'online/fees';
        $this->data['main_menu'] = 'online';
        $this->load->view('layout/index', $this->data);
    }

    public function classes()
    {
        $this->guard();
        $branchID = $this->application_model->get_branch_id();
        $this->data['board'] = $this->online_model->classes($branchID);
        $this->data['ready'] = $this->online_model->ready();
        $this->data['title'] = 'Online classes';
        $this->data['sub_page'] = 'online/classes';
        $this->data['main_menu'] = 'online';
        $this->load->view('layout/index', $this->data);
    }

    public function income()
    {
        $this->guard(true);
        $branchID = $this->application_model->get_branch_id();
        $this->data['income'] = $this->online_model->income($branchID);
        $this->data['ready'] = $this->online_model->ready();
        $this->data['title'] = 'Online income';
        $this->data['sub_page'] = 'online/income';
        $this->data['main_menu'] = 'online';
        $this->load->view('layout/index', $this->data);
    }

    protected function guard($money = false)
    {
        if (!is_loggedin() || is_student_loggedin() || is_parent_loggedin()) {
            access_denied();
        }
        if ($money) {
            if (!$this->canSeeMoney()) {
                access_denied();
            }
            return;
        }
        if (!$this->canOpen()) {
            access_denied();
        }
    }

    protected function canOpen()
    {
        return is_superadmin_loggedin() || is_admin_loggedin() || is_director_loggedin()
            || is_accountant_loggedin() || is_receptionist_loggedin()
            || is_teacher_loggedin() || is_facilitator_loggedin();
    }

    protected function canSeeMoney()
    {
        return is_superadmin_loggedin() || is_admin_loggedin() || is_director_loggedin()
            || is_accountant_loggedin() || is_receptionist_loggedin()
            || get_permission('school_fees', 'is_view');
    }

    protected function canEditFees()
    {
        return is_superadmin_loggedin() || is_admin_loggedin() || is_director_loggedin()
            || get_permission('school_fees', 'is_edit');
    }
}
