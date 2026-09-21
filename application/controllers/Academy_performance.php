<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Academy Performance Hub — Maths, English, Arabic, Quran, Skills, Core drills + TurboTimer.
 */
class Academy_performance extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('academy_model');
    }

    public function index()
    {
        if (!get_permission('academy_performance', 'is_view') && !is_superadmin_loggedin()) {
            access_denied();
        }

        $branchID = $this->application_model->get_branch_id();

        if ($this->input->post('save_drill')) {
            if (!get_permission('academy_performance', 'is_add') && !is_superadmin_loggedin()) {
                access_denied();
            }
            if (!$this->academy_model->drillsReady()) {
                set_alert('error', 'Run application/migrations/academy_engine.sql first.');
                redirect(base_url('academy_performance'));
            }

            $this->form_validation->set_rules('student_id', 'Student', 'trim|required|integer');
            $this->form_validation->set_rules('pillar', 'Subject pillar', 'trim|required');
            $this->form_validation->set_rules('score', 'Score', 'trim|required|integer');
            $this->form_validation->set_rules('time_seconds', 'Time (seconds)', 'trim|required|integer');
            $this->form_validation->set_rules('total_possible', 'Total possible', 'trim|required|integer');

            if ($this->form_validation->run() == true) {
                $pillars = $this->academy_model->pillars();
                $pillar = strtoupper(trim($this->input->post('pillar')));
                if (!isset($pillars[$pillar])) {
                    set_alert('error', 'Invalid subject pillar.');
                    redirect(base_url('academy_performance'));
                }

                $result = $this->academy_model->saveDrill(array(
                    'branch_id' => $branchID,
                    'student_id' => $this->input->post('student_id'),
                    'evaluator_id' => get_loggedin_user_id(),
                    'pillar' => $pillar,
                    'sub_category' => $this->input->post('sub_category'),
                    'score' => $this->input->post('score'),
                    'total_possible' => $this->input->post('total_possible'),
                    'time_seconds' => $this->input->post('time_seconds'),
                    'notes' => $this->input->post('notes'),
                ));
                set_alert('success', 'Drill saved. SPP = ' . number_format($result['spp'], 2) . ' sec/point');
                redirect(base_url('academy_performance'));
            }
        }

        $this->data['branch_id'] = $branchID;
        $this->data['ready'] = $this->academy_model->drillsReady();
        $this->data['pillars'] = $this->academy_model->pillars();
        $this->data['sub_categories'] = $this->academy_model->subCategories();
        $this->data['students'] = $this->academy_model->getActiveStudents($branchID);
        $this->data['todays'] = $this->data['ready'] ? $this->academy_model->getTodaysDrills($branchID) : array();
        $this->data['recent'] = $this->data['ready'] ? $this->academy_model->getRecentDrills($branchID) : array();
        $this->data['perf_kpis'] = $this->data['ready']
            ? $this->academy_model->performanceKpis($branchID)
            : array('today_drills' => 0, 'unique_students' => 0, 'avg_spp' => null, 'avg_pct' => null, 'best_pillar' => '—');
        $this->data['title'] = 'Academy Performance';
        $this->data['sub_page'] = 'academy/performance';
        $this->data['main_menu'] = 'academy';
        $this->load->view('layout/index', $this->data);
    }

    public function delete($id = 0)
    {
        if (!get_permission('academy_performance', 'is_delete') && !is_superadmin_loggedin()) {
            access_denied();
        }
        $branchID = $this->application_model->get_branch_id();
        $this->academy_model->deleteDrill($id, $branchID);
        set_alert('success', translate('information_deleted'));
        redirect(base_url('academy_performance'));
    }
}
