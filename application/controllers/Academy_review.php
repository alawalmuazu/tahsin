<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Assign students to a teacher and review the day's academy session:
 * teacher completes everyone → director → admin acknowledge → broadcast + dashboards.
 */
class Academy_review extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('academy_model');
    }

    public function index()
    {
        $this->guardStaff();
        $branchID = $this->application_model->get_branch_id();
        $this->academy_model->markNoticesRead(get_loggedin_user_id());

        if ($this->input->post('decide')) {
            $this->handleDecision($branchID);
        }

        $this->data['ready'] = $this->academy_model->reviewReady();
        $this->data['sessions'] = $this->data['ready']
            ? $this->academy_model->sessionsForViewer($branchID, get_loggedin_user_id())
            : array();
        $this->data['can_director'] = is_superadmin_loggedin() || is_director_loggedin();
        $this->data['can_admin'] = is_superadmin_loggedin() || is_admin_loggedin();
        $this->data['is_teacher'] = is_teacher_loggedin();
        $this->data['title'] = 'Academy Session Review';
        $this->data['sub_page'] = 'academy/review';
        $this->data['main_menu'] = 'academy';
        $this->load->view('layout/index', $this->data);
    }

    public function assign()
    {
        if (!is_superadmin_loggedin() && !is_admin_loggedin() && !is_director_loggedin()) {
            access_denied();
        }
        $branchID = $this->application_model->get_branch_id();

        if ($this->input->post('save_assign')) {
            if (!$this->academy_model->reviewReady()) {
                set_alert('error', 'Run application/migrations/academy_session_review.sql first.');
                redirect(base_url('academy_review/assign'));
            }
            $teacherId = (int) $this->input->post('teacher_id');
            if ($teacherId < 1) {
                set_alert('error', 'Select a teacher.');
                redirect(base_url('academy_review/assign'));
            }
            $ids = $this->input->post('student_ids');
            $this->academy_model->saveTeacherAssignments($branchID, $teacherId, $ids ? $ids : array(), get_loggedin_user_id());
            $n = is_array($ids) ? count($ids) : 0;
            set_alert('success', 'Assigned ' . (int) $n . ' student' . ($n === 1 ? '' : 's') . ' to this teacher.');
            redirect(base_url('academy_review/assign?teacher_id=' . $teacherId));
        }

        $teacherId = (int) $this->input->get('teacher_id');
        $this->data['ready'] = $this->academy_model->reviewReady();
        $this->data['teachers'] = $this->academy_model->listTeachers($branchID);
        $this->data['students'] = $this->studentsForAssign($branchID);
        $this->data['teacher_id'] = $teacherId;
        $picked = array();
        if ($teacherId && $this->data['ready']) {
            foreach ($this->academy_model->assignmentsForTeacher($branchID, $teacherId) as $row) {
                $picked[(int) $row->student_id] = true;
            }
        }
        $this->data['picked'] = $picked;
        $this->data['roster'] = $this->data['ready'] ? $this->academy_model->allAssignments($branchID) : array();
        $this->data['title'] = 'Assign Academy Students';
        $this->data['sub_page'] = 'academy/assign';
        $this->data['main_menu'] = 'academy';
        $this->load->view('layout/index', $this->data);
    }

    protected function handleDecision($branchID)
    {
        $step = $this->input->post('step');
        $approve = $this->input->post('decision') === 'approve';
        if ($step === 'director' && !is_superadmin_loggedin() && !is_director_loggedin()) {
            access_denied();
        }
        if ($step === 'admin' && !is_superadmin_loggedin() && !is_admin_loggedin()) {
            access_denied();
        }
        $err = $this->academy_model->decideSession(
            (int) $this->input->post('session_id'),
            $branchID,
            get_loggedin_user_id(),
            $step,
            $approve,
            $this->input->post('note')
        );
        if ($err) {
            set_alert('error', $err);
        } else {
            set_alert('success', $approve
                ? ($step === 'admin' ? 'Acknowledged. WhatsApp broadcast and parent/student dashboards can use this session.' : 'Approved and sent to the admin.')
                : 'Rejected. The other party has been notified.');
        }
        redirect(base_url('academy_review'));
    }

    protected function guardStaff()
    {
        if (!is_loggedin() || is_student_loggedin() || is_parent_loggedin()) {
            access_denied();
        }
    }

    /**
     * Full roster for assignment (not filtered to the logged-in teacher).
     */
    protected function studentsForAssign($branchID)
    {
        $sessionID = get_session_id();
        $this->db->select('s.id, s.register_no, TRIM(CONCAT_WS(" ", s.first_name, NULLIF(s.other_name,""), s.last_name)) AS fullname, c.name AS class_name, se.name AS section_name, pc.name AS student_category, sc.name AS programme_category');
        $this->db->from('enroll e');
        $this->db->join('student s', 's.id = e.student_id', 'inner');
        $this->db->join('class c', 'c.id = e.class_id', 'left');
        $this->db->join('section se', 'se.id = e.section_id', 'left');
        $this->db->join('pwd_category pc', 'pc.id = s.pwd_category_id', 'left');
        $this->db->join('student_category sc', 'sc.id = s.category_id', 'left');
        $this->db->where('e.branch_id', (int) $branchID);
        if ($sessionID) {
            $this->db->where('e.session_id', (int) $sessionID);
        }
        $this->db->order_by('s.first_name', 'ASC');
        return $this->db->get()->result();
    }
}
