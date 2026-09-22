<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Tahfiz Tracker — Quran portion ledger (halaqah).
 */
class Tahfiz extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('academy_model');
    }

    public function index()
    {
        if (!get_permission('tahfiz', 'is_view') && !is_superadmin_loggedin()) {
            access_denied();
        }

        $branchID = $this->application_model->get_branch_id();

        if ($this->input->post('save_tahfiz')) {
            if (!get_permission('tahfiz', 'is_add') && !is_superadmin_loggedin()) {
                access_denied();
            }
            if (!$this->academy_model->tahfizReady()) {
                set_alert('error', 'Run application/migrations/academy_engine.sql first.');
                redirect(base_url('tahfiz'));
            }

            $this->form_validation->set_rules('student_id', 'Student', 'trim|required|integer');
            $this->form_validation->set_rules('surah_number', 'Surah', 'trim|required|integer');
            $this->form_validation->set_rules('portion_mode', 'Portion mode', 'trim|required');
            $this->form_validation->set_rules('recitation_category', 'Recitation category', 'trim|required');

            if ($this->form_validation->run() == true) {
                $modes = $this->academy_model->portionModes();
                $mode = $this->input->post('portion_mode');
                if (!isset($modes[$mode])) {
                    set_alert('error', 'Invalid portion mode.');
                    redirect(base_url('tahfiz'));
                }
                $cats = $this->academy_model->recitationCategories();
                $cat = strtoupper(trim((string) $this->input->post('recitation_category')));
                if ($cat === '' || !isset($cats[$cat])) {
                    set_alert('error', 'Select a valid Recitation Category.');
                    redirect(base_url('tahfiz'));
                }

                if (is_teacher_loggedin() && !$this->academy_model->studentAssignedToTeacher((int) $this->input->post('student_id'), get_loggedin_user_id(), $branchID)) {
                    set_alert('error', 'This student is not assigned to you.');
                    redirect(base_url('tahfiz'));
                }

                $this->academy_model->saveTahfiz(array(
                    'branch_id' => $branchID,
                    'student_id' => $this->input->post('student_id'),
                    'instructor_id' => get_loggedin_user_id(),
                    'surah_number' => $this->input->post('surah_number'),
                    'portion_mode' => $mode,
                    'recitation_category' => $cat,
                    'ayah_from' => $this->input->post('ayah_from'),
                    'ayah_to' => $this->input->post('ayah_to'),
                    'page_from' => $this->input->post('page_from'),
                    'page_to' => $this->input->post('page_to'),
                    'verified' => $this->input->post('verified') ? 1 : 0,
                    'akhlaq_note' => $this->input->post('akhlaq_note'),
                    'completed_at' => $this->input->post('completed_at')
                        ? date('Y-m-d H:i:s', strtotime($this->input->post('completed_at')))
                        : date('Y-m-d H:i:s'),
                    'accuracy_score' => $this->input->post('accuracy_score'),
                    'mistake_word_count' => $this->input->post('mistake_word_count'),
                    'audio_url' => $this->input->post('audio_url'),
                    'video_url' => $this->input->post('video_url'),
                    'recitation_seconds' => $this->input->post('recitation_seconds'),
                    'tarteel_status' => $this->input->post('accuracy_score') !== '' && $this->input->post('accuracy_score') !== null
                        ? 'VERIFIED' : 'UNVERIFIED',
                ));
                $progress = $this->academy_model->touchTeacherSession($branchID, (int) $this->input->post('student_id'));
                set_alert('success', 'Tahfiz record saved.' . ($progress ? ' ' . $progress : ''));
                redirect(base_url('tahfiz'));
            }
        }

        $this->data['branch_id'] = $branchID;
        $this->data['ready'] = $this->academy_model->tahfizReady();
        $this->data['students'] = $this->academy_model->getActiveStudents($branchID);
        $this->data['surahs'] = $this->academy_model->surahList();
        $this->data['portion_modes'] = $this->academy_model->portionModes();
        $this->data['recitation_categories'] = $this->academy_model->recitationCategories();
        $this->data['recent'] = $this->data['ready'] ? $this->academy_model->getRecentTahfiz($branchID) : array();
        $this->data['title'] = 'Tahfiz Tracker';
        $this->data['sub_page'] = 'academy/tahfiz';
        $this->data['main_menu'] = 'academy';
        $this->load->view('layout/index', $this->data);
    }

    public function delete($id = 0)
    {
        if (!get_permission('tahfiz', 'is_delete') && !is_superadmin_loggedin()) {
            access_denied();
        }
        $branchID = $this->application_model->get_branch_id();
        $this->academy_model->deleteTahfiz($id, $branchID);
        set_alert('success', translate('information_deleted'));
        redirect(base_url('tahfiz'));
    }
}
