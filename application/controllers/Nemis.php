<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * NEMIS Reporting Controller
 * National Education Management Information System
 * Generates government-required data exports for Kaduna State Schools
 */
class Nemis extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        // Admin_Controller handles login check; superadmin always passes get_permission()
    }

    /**
     * AJAX: return classes for a given branch (used by the WAEC school→class cascade)
     * ?branch_id=  — empty = all schools (returns all classes, not disabled)
     * ?exam_type=  — passed for context (currently informational, all classes always shown for override)
     */
    public function get_classes_by_branch()
    {
        $branch_id = $this->input->get('branch_id');

        if (empty($branch_id)) {
            // All Schools selected — return ALL classes so override still works
            $this->db->select('id, name');
            $this->db->from('class');
            $this->db->order_by('CAST(name_numeric AS UNSIGNED)', 'ASC');
            $this->db->order_by('name', 'ASC');
            $rows = $this->db->get()->result_array();
        } else {
            // Specific school — board items for this branch + branch-specific classes
            $board_row = $this->db->select('board_id')->where('id', $branch_id)->get('branch')->row();
            $board_id  = $board_row ? $board_row->board_id : null;

            $this->db->select('id, name');
            $this->db->from('class');
            if (!empty($board_id)) {
                $this->db->group_start();
                $this->db->where('board_id', $board_id);
                $this->db->or_group_start();
                $this->db->where('branch_id', $branch_id);
                $this->db->where('board_id IS NULL', null, false);
                $this->db->group_end();
                $this->db->group_end();
            } else {
                $this->db->where('branch_id', $branch_id);
            }
            $this->db->order_by('CAST(name_numeric AS UNSIGNED)', 'ASC');
            $this->db->order_by('name', 'ASC');
            $rows = $this->db->get()->result_array();
        }

        header('Content-Type: application/json');
        echo json_encode($rows);
        exit;
    }

    public function index()
    {
        $this->data['title'] = 'NEMIS Reports';
        $this->data['sub_page'] = 'nemis/index';
        $this->data['main_menu'] = 'nemis';
        $this->load->view('layout/index', $this->data);
    }

    /**
     * Annual School Census (ASC) — UBEC format
     * Total students by school, LGA, gender, class level
     */
    public function asc_report()
    {
        // Enrollment by school & gender
        $this->db->select('b.name as school_name, b.lga, COUNT(s.id) as total_students,
            SUM(s.gender = "Male") as male_count,
            SUM(s.gender = "Female") as female_count,
            eb.name as board_name');
        $this->db->from('student as s');
        $this->db->join('enroll as e', 'e.student_id = s.id', 'inner');
        $this->db->join('branch as b', 'b.id = e.branch_id', 'left');
        $this->db->join('education_board as eb', 'eb.id = b.board_id', 'left');
        $this->db->where('e.session_id', get_session_id());
        $this->db->where('s.active', 1);
        $this->db->group_by('e.branch_id');
        $this->db->order_by('b.lga, b.name', 'ASC');
        $this->data['asc_data'] = $this->db->get()->result_array();

        // Summary totals
        $this->data['total_students'] = array_sum(array_column($this->data['asc_data'], 'total_students'));
        $this->data['total_male']     = array_sum(array_column($this->data['asc_data'], 'male_count'));
        $this->data['total_female']   = array_sum(array_column($this->data['asc_data'], 'female_count'));
        $this->data['session_name']   = get_type_name_by_id('schoolyear', get_session_id(), 'school_year');

        $this->data['title']    = 'Annual School Census (ASC)';
        $this->data['sub_page'] = 'nemis/asc_report';
        $this->data['main_menu'] = 'nemis';
        $this->load->view('layout/index', $this->data);
    }

    /**
     * Teacher-to-Student Ratio Report — UBEC Compliance
     */
    public function ubec_report()
    {
        $this->db->select('b.name as school_name, b.lga,
            COUNT(DISTINCT s.id) as total_students,
            COUNT(DISTINCT st.id) as total_teachers,
            ROUND(COUNT(DISTINCT s.id) / NULLIF(COUNT(DISTINCT st.id),0), 1) as ratio');
        $this->db->from('branch as b');
        $this->db->join('enroll as e', 'e.branch_id = b.id AND e.session_id = ' . $this->db->escape(get_session_id()), 'left');
        $this->db->join('student as s', 's.id = e.student_id AND s.active = 1', 'left');
        $this->db->join('staff as st', 'st.branch_id = b.id', 'left');
        $this->db->group_by('b.id');
        $this->db->order_by('b.lga, b.name');
        $this->data['ubec_data'] = $this->db->get()->result_array();

        $this->data['title']    = 'UBEC Compliance Report';
        $this->data['sub_page'] = 'nemis/ubec_report';
        $this->data['main_menu'] = 'nemis';
        $this->load->view('layout/index', $this->data);
    }

    /**
     * WAEC / NECO Candidate Registration Export
     * Lists SS3 / JS3 students with name, DOB, gender, state_student_id
     */
    public function waec_candidates()
    {
        $exam_type    = $this->input->get('exam_type') ?: 'ssce'; // ssce | bece
        $class_filter = $this->input->get('class_id');            // manual class override
        $branch_filter = $this->input->get('branch_id');

        $this->db->select('s.state_student_id, s.nin, CONCAT_WS(" ", s.first_name, s.last_name) as fullname,
            s.gender, s.birthday, s.register_no, b.name as school_name, b.lga,
            c.name as class_name, sc.name as category');
        $this->db->from('student as s');
        $this->db->join('enroll as e', 'e.student_id = s.id', 'inner');
        $this->db->join('branch as b', 'b.id = e.branch_id', 'left');
        $this->db->join('class as c', 'c.id = e.class_id', 'left');
        $this->db->join('student_category as sc', 'sc.id = s.category_id', 'left');
        $this->db->where('e.session_id', get_session_id());
        $this->db->where('s.active', 1);

        if (!empty($class_filter)) {
            // Manual override — user picked a specific class
            $this->db->where('e.class_id', $class_filter);
        } else {
            // Auto-filter by exam type
            if ($exam_type === 'bece') {
                // NECO BECE — Basic 9 (JSS3) candidates only
                // Kaduna State uses "Basic 9" as the modern name for JSS 3
                $this->db->group_start();
                $this->db->like('c.name', 'Basic 9', 'both');       // Kaduna modern name
                $this->db->or_like('c.name', 'JSS 3', 'both');      // legacy
                $this->db->or_like('c.name', 'JSS3', 'both');       // legacy compact
                $this->db->or_like('c.name', 'Junior Secondary 3', 'both'); // verbose
                $this->db->group_end();
            } else {
                // WAEC/NECO SSCE (default) — SS3 candidates only
                $this->db->group_start();
                $this->db->like('c.name', 'SS3', 'both');
                $this->db->or_like('c.name', 'SS 3', 'both');
                $this->db->or_like('c.name', 'SSS3', 'both');
                $this->db->or_like('c.name', 'Senior Secondary 3', 'both');
                $this->db->group_end();
            }
        }

        if (!empty($branch_filter)) {
            $this->db->where('e.branch_id', $branch_filter);
        }
        // Sort: class numeric → class name → school → student surname → first name
        $this->db->order_by('CAST(c.name_numeric AS UNSIGNED)', 'ASC');
        $this->db->order_by('c.name', 'ASC');
        $this->db->order_by('b.name', 'ASC');
        $this->db->order_by('s.last_name', 'ASC');
        $this->db->order_by('s.first_name', 'ASC');
        $this->data['candidates'] = $this->db->get()->result_array();

        // Class list: all classes sorted numerically for the Override Class dropdown
        $this->data['class_list'] = $this->db
            ->order_by('CAST(name_numeric AS UNSIGNED)', 'ASC')
            ->order_by('name', 'ASC')
            ->get('class')->result_array();

        // Branch list: only schools that have enrolled students in the relevant
        // final-year class for the current exam type (board-aware filtering)
        if ($exam_type === 'bece') {
            // BECE schools: those with Basic 9 / JSS3 students enrolled this session
            $this->db->distinct();
            $this->db->select('e.branch_id', FALSE);
            $this->db->from('enroll as e');
            $this->db->join('class as c', 'c.id = e.class_id', 'inner');
            $this->db->where('e.session_id', get_session_id());
            $this->db->group_start();
            $this->db->like('c.name', 'Basic 9', 'both');
            $this->db->or_like('c.name', 'JSS 3', 'both');
            $this->db->or_like('c.name', 'JSS3', 'both');
            $this->db->or_like('c.name', 'Junior Secondary 3', 'both');
            $this->db->group_end();
        } else {
            // SSCE schools: those with SS3 students enrolled this session
            $this->db->distinct();
            $this->db->select('e.branch_id', FALSE);
            $this->db->from('enroll as e');
            $this->db->join('class as c', 'c.id = e.class_id', 'inner');
            $this->db->where('e.session_id', get_session_id());
            $this->db->group_start();
            $this->db->like('c.name', 'SS3', 'both');
            $this->db->or_like('c.name', 'SS 3', 'both');
            $this->db->or_like('c.name', 'SSS3', 'both');
            $this->db->or_like('c.name', 'Senior Secondary 3', 'both');
            $this->db->group_end();
        }
        $relevant_ids = array_column($this->db->get()->result_array(), 'branch_id');

        if (!empty($relevant_ids)) {
            $this->db->where_in('id', $relevant_ids);
        }
        $this->data['branch_list'] = $this->db->order_by('name', 'ASC')->get('branch')->result_array();

        $this->data['exam_type']    = $exam_type;
        $this->data['class_filter'] = $class_filter;
        $this->data['branch_filter'] = $branch_filter;
        $this->data['title']        = 'WAEC / NECO Candidate List';
        $this->data['sub_page']     = 'nemis/waec_candidates';
        $this->data['main_menu']    = 'nemis';
        $this->load->view('layout/index', $this->data);
    }


    /**
     * Export ASC data as CSV
     */
    public function export_asc_csv()
    {
        $this->db->select('b.name as school_name, b.lga,
            COUNT(s.id) as total_students,
            SUM(s.gender = "Male") as male,
            SUM(s.gender = "Female") as female,
            eb.name as education_board');
        $this->db->from('student as s');
        $this->db->join('enroll as e', 'e.student_id = s.id', 'inner');
        $this->db->join('branch as b', 'b.id = e.branch_id', 'left');
        $this->db->join('education_board as eb', 'eb.id = b.board_id', 'left');
        $this->db->where('e.session_id', get_session_id());
        $this->db->where('s.active', 1);
        $this->db->group_by('e.branch_id');
        $this->db->order_by('b.lga, b.name');
        $rows = $this->db->get()->result_array();

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="ASC_Kaduna_' . date('Y') . '.csv"');
        $out = fopen('php://output', 'w');
        fputcsv($out, ['School Name', 'LGA', 'Education Board', 'Total Students', 'Male', 'Female']);
        foreach ($rows as $row) {
            fputcsv($out, [$row['school_name'], $row['lga'], $row['education_board'], $row['total_students'], $row['male'], $row['female']]);
        }
        fclose($out);
        exit;
    }

    /**
     * Export WAEC candidates as CSV
     */
    public function export_waec_csv()
    {
        $exam_type     = $this->input->get('exam_type') ?: 'ssce';
        $class_filter  = $this->input->get('class_id');
        $branch_filter = $this->input->get('branch_id');

        $this->db->select('s.state_student_id, s.nin, s.last_name, s.first_name,
            s.gender, s.birthday, s.register_no, b.name as school_name, b.lga, c.name as class_name');
        $this->db->from('student as s');
        $this->db->join('enroll as e', 'e.student_id = s.id', 'inner');
        $this->db->join('branch as b', 'b.id = e.branch_id', 'left');
        $this->db->join('class as c', 'c.id = e.class_id', 'left');
        $this->db->where('e.session_id', get_session_id());
        $this->db->where('s.active', 1);

        if (!empty($class_filter)) {
            $this->db->where('e.class_id', $class_filter);
        } else {
            if ($exam_type === 'bece') {
                $this->db->group_start();
                $this->db->like('c.name', 'Basic 9', 'both');       // Kaduna modern name
                $this->db->or_like('c.name', 'JSS 3', 'both');      // legacy
                $this->db->or_like('c.name', 'JSS3', 'both');       // legacy compact
                $this->db->or_like('c.name', 'Junior Secondary 3', 'both'); // verbose
                $this->db->group_end();
            } else {
                $this->db->group_start();
                $this->db->like('c.name', 'SS3', 'both');
                $this->db->or_like('c.name', 'SS 3', 'both');
                $this->db->or_like('c.name', 'SSS3', 'both');
                $this->db->or_like('c.name', 'Senior Secondary 3', 'both');
                $this->db->group_end();
            }
        }

        if (!empty($branch_filter)) $this->db->where('e.branch_id', $branch_filter);
        $this->db->order_by('b.lga, b.name, s.last_name');
        $rows = $this->db->get()->result_array();

        $exam_label = $exam_type === 'bece' ? 'NECO_BECE' : 'WAEC_SSCE';
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $exam_label . '_Candidates_Kaduna_' . date('Y') . '.csv"');
        $out = fopen('php://output', 'w');
        fputcsv($out, ['State Student ID', 'NIN', 'Surname', 'First Name', 'Gender', 'Date of Birth', 'Reg No', 'School', 'LGA', 'Class', 'Exam Type']);
        foreach ($rows as $row) {
            fputcsv($out, [
                $row['state_student_id'], $row['nin'], $row['last_name'], $row['first_name'],
                $row['gender'], $row['birthday'], $row['register_no'],
                $row['school_name'], $row['lga'], $row['class_name'],
                strtoupper($exam_type)
            ]);
        }
        fclose($out);
        exit;
    }

    /**
     * Export UBEC compliance data as CSV
     */
    public function export_ubec_csv()
    {
        $this->db->select('b.name as school_name, b.lga,
            COUNT(DISTINCT s.id) as total_students,
            COUNT(DISTINCT st.id) as total_teachers,
            ROUND(COUNT(DISTINCT s.id) / NULLIF(COUNT(DISTINCT st.id),0), 1) as ratio');
        $this->db->from('branch as b');
        $this->db->join('enroll as e', 'e.branch_id = b.id AND e.session_id = ' . $this->db->escape(get_session_id()), 'left');
        $this->db->join('student as s', 's.id = e.student_id AND s.active = 1', 'left');
        $this->db->join('staff as st', 'st.branch_id = b.id', 'left');
        $this->db->group_by('b.id');
        $this->db->order_by('b.lga, b.name');
        $rows = $this->db->get()->result_array();

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="UBEC_Compliance_Kaduna_' . date('Y') . '.csv"');
        $out = fopen('php://output', 'w');
        fputcsv($out, ['School Name', 'LGA', 'Total Students', 'Total Teachers', 'Ratio (S:T)', 'Status']);
        foreach ($rows as $row) {
            $ratio = floatval($row['ratio']);
            $status = $ratio <= 35 ? 'Adequate' : ($ratio <= 45 ? 'Moderate' : 'Critical');
            fputcsv($out, [
                $row['school_name'], $row['lga'],
                $row['total_students'], $row['total_teachers'],
                $ratio > 0 ? $ratio . ':1' : 'N/A', $status
            ]);
        }
        fclose($out);
        exit;
    }
}
