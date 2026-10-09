<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Scheme Controller
 * 
 * Tahsin Academy School Management System (tahsinacademy.ng)
 * Handles Curriculum Schemes of Work management, filtering, creation, 
 * editing, export (CSV/JSON), and print-ready syllabus generation.
 */
class Scheme extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Scheme_model');
        $this->load->helper(array('url', 'form', 'text'));
        $this->load->library(array('session', 'form_validation'));
    }

    /**
     * Display all schemes with optional filtering
     */
    public function index() {
        $level   = $this->input->get('grade_level') ? $this->input->get('grade_level') : 'ALL';
        $term    = $this->input->get('academic_term') ? $this->input->get('academic_term') : 'ALL';
        $subject = $this->input->get('subject') ? $this->input->get('subject') : 'ALL';
        $week    = $this->input->get('week_number') ? $this->input->get('week_number') : 'ALL';

        $this->data['schemes'] = $this->Scheme_model->get_schemes($level, $term, $subject, $week);
        $this->data['filters'] = array(
            'grade_level'   => $level,
            'academic_term' => $term,
            'subject'       => $subject,
            'week_number'   => $week
        );

        $this->data['title'] = 'Curriculum Schemes of Work';
        $this->data['main_menu'] = 'academic';

        // If user is authenticated in Tahsin portal and didn't request standalone mode
        if (function_exists('is_loggedin') && is_loggedin() && !$this->input->get('standalone')) {
            $this->data['sub_page'] = 'scheme/portal_view';
            $this->load->view('layout/index', $this->data);
        } else {
            // Render beautiful standalone UI
            $this->load->view('scheme/standalone_view', $this->data);
        }
    }

    /**
     * Add or save a scheme entry
     */
    public function save() {
        $this->form_validation->set_rules('grade_level', 'Class Level', 'required|trim');
        $this->form_validation->set_rules('academic_term', 'Academic Term', 'required|trim');
        $this->form_validation->set_rules('week_number', 'Week', 'required|trim');
        $this->form_validation->set_rules('subject', 'Subject', 'required|trim');
        $this->form_validation->set_rules('topic', 'Topic', 'required|trim');
        $this->form_validation->set_rules('objectives', 'Learning Objectives', 'required|trim');
        $this->form_validation->set_rules('class_work', 'Classroom Work', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('scheme');
        } else {
            $scheme_data = array(
                'grade_level'         => $this->input->post('grade_level', TRUE),
                'academic_term'       => $this->input->post('academic_term', TRUE),
                'week_number'         => $this->input->post('week_number', TRUE),
                'period_day'          => $this->input->post('period_day', TRUE) ? $this->input->post('period_day', TRUE) : 'All Week',
                'subject'             => $this->input->post('subject', TRUE),
                'topic'               => $this->input->post('topic', TRUE),
                'sub_topic'           => $this->input->post('sub_topic', TRUE),
                'objectives'          => $this->input->post('objectives', TRUE),
                'teacher_activities'  => $this->input->post('teacher_activities', TRUE),
                'pupil_activities'    => $this->input->post('pupil_activities', TRUE),
                'class_work'          => $this->input->post('class_work', TRUE),
                'home_work'           => $this->input->post('home_work', TRUE),
                'teaching_aids'       => $this->input->post('teaching_aids', TRUE),
                'evaluation_strategy' => $this->input->post('evaluation_strategy', TRUE),
                'reference_book'      => $this->input->post('reference_book', TRUE),
                'status'              => 'active'
            );

            $id = $this->input->post('id', TRUE);
            if (!empty($id)) {
                $this->Scheme_model->update_scheme($id, $scheme_data);
                $this->session->set_flashdata('success', 'Scheme entry #' . $id . ' updated successfully!');
            } else {
                $new_id = $this->Scheme_model->insert_scheme($scheme_data);
                $this->session->set_flashdata('success', 'New scheme entry created successfully with ID #' . $new_id . '!');
            }

            redirect('scheme');
        }
    }

    /**
     * Clone an existing scheme entry
     */
    public function duplicate($id) {
        $scheme = $this->Scheme_model->get_scheme_by_id($id);
        if (!$scheme) {
            $this->session->set_flashdata('error', 'Scheme not found.');
            redirect('scheme');
        }

        unset($scheme['id']);
        unset($scheme['created_at']);
        unset($scheme['updated_at']);
        $scheme['topic'] = $scheme['topic'] . ' (Copy)';
        
        $new_id = $this->Scheme_model->insert_scheme($scheme);
        $this->session->set_flashdata('success', 'Scheme duplicated successfully as ID #' . $new_id . '!');
        redirect('scheme');
    }

    /**
     * Soft delete / archive a scheme entry
     */
    public function delete($id) {
        $this->Scheme_model->delete_scheme($id);
        $this->session->set_flashdata('success', 'Scheme entry #' . $id . ' deleted successfully.');
        redirect('scheme');
    }

    /**
     * Return JSON for modal edit or REST API
     */
    public function get_json($id) {
        $scheme = $this->Scheme_model->get_scheme_by_id($id);
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($scheme));
    }

    /**
     * Export all active schemes to CSV
     */
    public function export_csv() {
        $schemes = $this->Scheme_model->export_all_active();

        $filename = 'tahsin_schemes_of_work_' . date('Y-m-d_His') . '.csv';
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=' . $filename);

        $output = fopen('php://output', 'w');
        fputcsv($output, array(
            'ID', 'Grade Level', 'Academic Term', 'Week', 'Period',
            'Subject', 'Topic', 'Sub-Topic', 'Learning Objectives',
            'Teacher Activities', 'Pupil Activities', 'Class Work',
            'Home Work', 'Teaching Aids', 'Evaluation Strategy', 'Reference Book'
        ));

        foreach ($schemes as $row) {
            fputcsv($output, array(
                $row['id'],
                $row['grade_level'],
                $row['academic_term'],
                $row['week_number'],
                $row['period_day'],
                $row['subject'],
                $row['topic'],
                $row['sub_topic'],
                $row['objectives'],
                $row['teacher_activities'],
                $row['pupil_activities'],
                $row['class_work'],
                $row['home_work'],
                $row['teaching_aids'],
                $row['evaluation_strategy'],
                $row['reference_book']
            ));
        }
        fclose($output);
        exit;
    }

    /**
     * Export all active schemes to JSON
     */
    public function export_json() {
        $schemes = $this->Scheme_model->export_all_active();
        $filename = 'tahsin_schemes_of_work_' . date('Y-m-d_His') . '.json';

        $this->output
            ->set_content_type('application/json')
            ->set_header('Content-Disposition: attachment; filename=' . $filename)
            ->set_output(json_encode($schemes, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }

    /**
     * Print View for a single or filtered scheme of work
     */
    public function print_view($id = null) {
        if ($id) {
            $this->data['schemes'] = array($this->Scheme_model->get_scheme_by_id($id));
            $this->data['single_title'] = 'Scheme of Work — Detail Card';
        } else {
            $level   = $this->input->get('grade_level') ? $this->input->get('grade_level') : 'ALL';
            $term    = $this->input->get('academic_term') ? $this->input->get('academic_term') : 'ALL';
            $subject = $this->input->get('subject') ? $this->input->get('subject') : 'ALL';
            $this->data['schemes'] = $this->Scheme_model->get_schemes($level, $term, $subject);
            $this->data['single_title'] = 'Comprehensive Termly Scheme of Work';
        }

        $this->load->view('scheme/print_view', $this->data);
    }
}
