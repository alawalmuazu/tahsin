<?php
defined('BASEPATH') or exit('No direct script access allowed');

class State_analytics extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('dashboard_model');
        // Restrict to superadmin or state executives
        if (!(is_superadmin_loggedin() || is_state_executive_loggedin())) {
            access_denied();
        }
    }

    public function index()
    {
        $this->data['title'] = "Executive State Dashboard";
        
        // Overview Widgets
        $this->data['total_schools'] = $this->db->get('branch')->num_rows();
        
        $this->db->select('COUNT(id) as total');
        $this->data['total_students'] = $this->db->get('student')->row()->total;
        
        $this->db->select('COUNT(id) as total');
        $this->db->where('role', 3);
        $this->data['total_teachers'] = $this->db->get('login_credential')->row()->total;
        
        $this->data['total_parents'] = $this->db->get('parent')->num_rows();
        
        // Advanced Analytics (Charts Data)
        // 1. Enrollment by gender
        $this->db->select('gender, COUNT(id) as count');
        $this->db->group_by('gender');
        $this->data['gender_stats'] = $this->db->get('student')->result();

        // 2. Schools by board (Basic vs Secondary)
        $this->db->select('board.name as board_name, COUNT(branch.id) as branch_count');
        $this->db->from('branch');
        $this->db->join('education_board as board', 'branch.board_id = board.id', 'left');
        $this->db->group_by('branch.board_id');
        $this->data['board_stats'] = $this->db->get()->result();

        // 3. Staff Gaps (Schools with < 3 teachers)
        $this->db->select('b.name as school_name, b.lga as lga, 
                           (SELECT COUNT(*) FROM student s INNER JOIN enroll e ON s.id = e.student_id WHERE e.branch_id = b.id) as enrolled_students,
                           (SELECT COUNT(*) FROM staff st WHERE st.branch_id = b.id AND st.designation != 1) as total_staff');
        $this->db->from('branch b');
        $this->data['staff_gaps'] = $this->db->get()->result();

        // Pass UI configuration
        $this->data['sub_page'] = 'dashboard/state_dashboard';
        $this->data['main_menu'] = 'state_analytics';
        
        $jsArray = array(
            'vendor/chartjs/chart.min.js',
            'vendor/echarts/echarts.common.min.js'
        ); 
        $this->data['headerelements'] = array(
            'css' => array(),
            'js' => $jsArray
        );
        $this->load->view('layout/index', $this->data);
    }

    public function lga_report()
    {
        $this->data['title']     = 'LGA School Summary Report';
        $this->data['sub_page']  = 'state_analytics/lga_report';
        $this->data['main_menu'] = 'state_analytics';

        // Aggregate per LGA
        $this->db->select("
            b.lga,
            COUNT(DISTINCT b.id) as total_schools,
            (SELECT COUNT(*) FROM student s INNER JOIN enroll e ON s.id = e.student_id WHERE e.branch_id IN (SELECT id FROM branch WHERE lga = b.lga)) as total_students,
            (SELECT COUNT(*) FROM staff st INNER JOIN branch br2 ON st.branch_id = br2.id WHERE br2.lga = b.lga AND st.designation != 1) as total_teachers
        ", false);
        $this->db->from('branch b');
        $this->db->where('b.lga IS NOT NULL');
        $this->db->where('b.lga !=', '');
        $this->db->group_by('b.lga');
        $this->db->order_by('b.lga', 'ASC');
        $this->data['lga_stats'] = $this->db->get()->result();

        $this->load->view('layout/index', $this->data);
    }
}
