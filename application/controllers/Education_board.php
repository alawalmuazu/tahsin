<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @package : SmartSchool
 * @version : 7.0
 * @developed by : SmartSchool
 * @support : Jamilusalis@gmail.com
 * @author url : https://mjtech.com.ng
 * @filename : Education_board.php
 * @copyright : Reserved SmartSchool Team
 */

class Education_board extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('education_board_model');
    }

    /**
     * List all boards + create form
     */
    public function index()
    {
        if (!is_superadmin_loggedin()) {
            redirect(base_url(), 'refresh');
        }

        if ($this->input->post('submit') == 'save') {
            $this->form_validation->set_rules('name', 'Board Name', 'required|callback_unique_board_name');
            if ($this->form_validation->run() == true) {
                $this->education_board_model->save($this->input->post());
                set_alert('success', translate('information_has_been_saved_successfully'));
                redirect(base_url('education_board'));
            } else {
                $this->data['validation_error'] = true;
            }
        }

        $this->data['boards'] = $this->education_board_model->getAll();
        $this->data['title'] = 'Education Board';
        $this->data['sub_page'] = 'education_board/index';
        $this->data['main_menu'] = 'education_board';
        $this->load->view('layout/index', $this->data);
    }

    /**
     * Edit board
     */
    public function edit($id = '')
    {
        if (!is_superadmin_loggedin()) {
            redirect(base_url(), 'refresh');
        }

        if ($this->input->post('submit') == 'save') {
            $this->form_validation->set_rules('name', 'Board Name', 'required|callback_unique_board_name');
            if ($this->form_validation->run() == true) {
                $this->education_board_model->save($this->input->post(), $id);
                set_alert('success', translate('information_has_been_updated_successfully'));
                redirect(base_url('education_board'));
            }
        }

        $this->data['board'] = $this->education_board_model->getById($id);
        $this->data['title'] = 'Edit Education Board';
        $this->data['sub_page'] = 'education_board/edit';
        $this->data['main_menu'] = 'education_board';
        $this->load->view('layout/index', $this->data);
    }

    /**
     * Manage board items (classes, sections, subjects, etc.)
     */
    public function manage($id = '')
    {
        if (!is_superadmin_loggedin()) {
            redirect(base_url(), 'refresh');
        }

        $board = $this->education_board_model->getById($id);
        if (empty($board)) {
            redirect(base_url('education_board'));
        }

        $active_tab = $this->input->get('tab') ? $this->input->get('tab') : 'class';

        // Handle add item
        if ($this->input->post('submit') == 'add_item') {
            $table = $this->input->post('item_table');
            $itemData = array();

            switch ($table) {
                case 'class':
                    $this->form_validation->set_rules('name', 'Class Name', 'required');
                    $itemData = array(
                        'name' => $this->input->post('name'),
                        'name_numeric' => $this->input->post('name_numeric'),
                    );
                    break;
                case 'section':
                    $this->form_validation->set_rules('name', 'Section Name', 'required');
                    $itemData = array(
                        'name' => $this->input->post('name'),
                        'capacity' => $this->input->post('capacity'),
                    );
                    break;
                case 'subject':
                    $this->form_validation->set_rules('name', 'Subject Name', 'required');
                    $itemData = array(
                        'name' => $this->input->post('name'),
                        'subject_code' => $this->input->post('subject_code'),
                        'subject_type' => $this->input->post('subject_type'),
                        'subject_author' => $this->input->post('subject_author'),
                    );
                    break;
                case 'grade':
                    $this->form_validation->set_rules('name', 'Grade Name', 'required');
                    $itemData = array(
                        'name' => $this->input->post('name'),
                        'grade_point' => $this->input->post('grade_point'),
                        'lower_mark' => $this->input->post('lower_mark'),
                        'upper_mark' => $this->input->post('upper_mark'),
                        'remark' => $this->input->post('remark'),
                    );
                    break;
                case 'exam_term':
                    $this->form_validation->set_rules('name', 'Term Name', 'required');
                    $itemData = array('name' => $this->input->post('name'));
                    break;
                case 'fees_type':
                    $this->form_validation->set_rules('name', 'Fee Type Name', 'required');
                    $itemData = array(
                        'name' => $this->input->post('name'),
                        'fee_code' => $this->input->post('fee_code'),
                        'description' => $this->input->post('description'),
                    );
                    break;
                case 'student_category':
                    $this->form_validation->set_rules('name', 'Category Name', 'required');
                    $itemData = array('name' => $this->input->post('name'));
                    break;
                case 'staff_department':
                    $this->form_validation->set_rules('name', 'Department Name', 'required');
                    $itemData = array('name' => $this->input->post('name'));
                    break;
                case 'staff_designation':
                    $this->form_validation->set_rules('name', 'Designation Name', 'required');
                    $itemData = array('name' => $this->input->post('name'));
                    break;
                default:
                    redirect(base_url('education_board/manage/' . $id));
                    break;
            }

            if ($this->form_validation->run() == true) {
                $this->education_board_model->addBoardItem($id, $table, $itemData);
                set_alert('success', translate('information_has_been_saved_successfully'));
                redirect(base_url('education_board/manage/' . $id . '?tab=' . $table));
            }
            $active_tab = $table;
        }

        // Handle delete item
        if ($this->input->post('submit') == 'delete_item') {
            $table = $this->input->post('item_table');
            $item_id = $this->input->post('item_id');
            $this->education_board_model->deleteBoardItem($id, $table, $item_id);
            set_alert('success', translate('information_has_been_deleted_successfully'));
            redirect(base_url('education_board/manage/' . $id . '?tab=' . $table));
        }

        // Load items for each tab
        $this->data['board'] = $board;
        $this->data['active_tab'] = $active_tab;
        $this->data['classes'] = $this->education_board_model->getBoardItems($id, 'class');
        $this->data['sections'] = $this->education_board_model->getBoardItems($id, 'section');
        $this->data['subjects'] = $this->education_board_model->getBoardItems($id, 'subject');
        $this->data['grades'] = $this->education_board_model->getBoardItems($id, 'grade');
        $this->data['exam_terms'] = $this->education_board_model->getBoardItems($id, 'exam_term');
        $this->data['fees_types'] = $this->education_board_model->getBoardItems($id, 'fees_type');
        $this->data['student_categories'] = $this->education_board_model->getBoardItems($id, 'student_category');
        $this->data['staff_departments'] = $this->education_board_model->getBoardItems($id, 'staff_department');
        $this->data['staff_designations'] = $this->education_board_model->getBoardItems($id, 'staff_designation');

        $this->data['title'] = 'Manage Board: ' . $board->name;
        $this->data['sub_page'] = 'education_board/manage';
        $this->data['main_menu'] = 'education_board';
        $this->load->view('layout/index', $this->data);
    }

    /**
     * Delete board
     */
    public function delete_data($id = '')
    {
        if (!is_superadmin_loggedin()) {
            redirect(base_url(), 'refresh');
        }

        $count = $this->education_board_model->countBranches($id);
        if ($count > 0) {
            set_alert('error', 'Cannot delete: ' . $count . ' school(s) are using this board.');
        } else {
            // Delete all board items from all lookup tables
            foreach (Education_board_model::$board_tables as $table) {
                $this->db->where('board_id', $id)->delete($table);
            }
            $this->db->where('id', $id)->delete('education_board');
            set_alert('success', translate('information_has_been_deleted_successfully'));
        }
        redirect(base_url('education_board'));
    }

    /**
     * Unique board name validation
     */
    public function unique_board_name($name)
    {
        $board_id = $this->input->post('board_id');
        if (!empty($board_id)) {
            $this->db->where_not_in('id', $board_id);
        }
        $this->db->where('name', $name);
        $count = $this->db->get('education_board')->num_rows();
        if ($count == 0) {
            return true;
        } else {
            $this->form_validation->set_message("unique_board_name", translate('already_taken'));
            return false;
        }
    }
}
