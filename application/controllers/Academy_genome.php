<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Academy_genome extends Admin_Controller
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
        $this->data['genome'] = $this->academy_model->getGenomeOverview($branchID);
        $this->data['title'] = 'Genome Intelligence';
        $this->data['sub_page'] = 'academy/genome';
        $this->data['main_menu'] = 'academy';
        $this->load->view('layout/index', $this->data);
    }
}
