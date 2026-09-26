<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Facilitator student groups — partition assigned roster; each group session
 * submits to director independently when all members are recorded.
 */
class Academy_groups extends Admin_Controller
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
        if (!is_teacher_loggedin() && !is_superadmin_loggedin() && !is_admin_loggedin() && !is_director_loggedin()) {
            access_denied();
        }

        $branchID = $this->application_model->get_branch_id();
        $teacherId = is_teacher_loggedin()
            ? (int) get_loggedin_user_id()
            : (int) $this->input->get_post('teacher_id');

        if ($this->input->post('create_group') && $teacherId > 0) {
            $res = $this->academy_model->createTeacherGroup($branchID, $teacherId, $this->input->post('group_name'));
            set_alert(!empty($res['ok']) ? 'success' : 'error', !empty($res['ok']) ? 'Group created.' : (isset($res['error']) ? $res['error'] : 'Could not create group.'));
            redirect(base_url('academy_groups' . (!is_teacher_loggedin() ? ('?teacher_id=' . $teacherId) : '')));
        }

        if ($this->input->post('delete_group') && $teacherId > 0) {
            $res = $this->academy_model->deleteTeacherGroup((int) $this->input->post('group_id'), $teacherId);
            set_alert(!empty($res['ok']) ? 'success' : 'error', !empty($res['ok']) ? 'Group deleted.' : (isset($res['error']) ? $res['error'] : 'Could not delete.'));
            redirect(base_url('academy_groups' . (!is_teacher_loggedin() ? ('?teacher_id=' . $teacherId) : '')));
        }

        if ($this->input->post('save_members') && $teacherId > 0) {
            $ids = $this->input->post('student_ids');
            $res = $this->academy_model->saveTeacherGroupMembers(
                (int) $this->input->post('group_id'),
                $teacherId,
                $branchID,
                is_array($ids) ? $ids : array()
            );
            set_alert(!empty($res['ok']) ? 'success' : 'error', !empty($res['ok'])
                ? ('Group updated — ' . (int) $res['count'] . ' student' . ($res['count'] === 1 ? '' : 's') . ' now in this group. You can add or remove again anytime.')
                : (isset($res['error']) ? $res['error'] : 'Could not save members.'));
            redirect(base_url('academy_groups' . (!is_teacher_loggedin() ? ('?teacher_id=' . $teacherId) : '')));
        }

        $teachers = array();
        if (!is_teacher_loggedin()) {
            $teachers = $this->academy_model->listTeachers($branchID);
            if ($teacherId < 1 && !empty($teachers)) {
                $teacherId = (int) $teachers[0]->id;
            }
        }

        $assigned = array();
        if ($teacherId > 0 && $this->db->table_exists('academy_teacher_student')) {
            $assigned = $this->db->select('ats.student_id, TRIM(CONCAT_WS(" ", s.first_name, NULLIF(s.other_name,""), s.last_name)) AS student_name')
                ->from('academy_teacher_student ats')
                ->join('student s', 's.id = ats.student_id', 'left')
                ->where('ats.branch_id', (int) $branchID)
                ->where('ats.session_id', (int) get_session_id())
                ->where('ats.teacher_id', $teacherId)
                ->order_by('s.first_name', 'ASC')
                ->get()->result();
        }

        $this->data['title'] = 'My Groups';
        $this->data['sub_page'] = 'academy/groups';
        $this->data['main_menu'] = 'academy';
        $this->data['ready'] = $this->academy_model->groupsReady();
        $this->data['teacher_id'] = $teacherId;
        $this->data['teachers'] = $teachers;
        $this->data['assigned'] = $assigned;
        $this->data['groups'] = $teacherId > 0 ? $this->academy_model->teacherGroups($branchID, $teacherId) : array();
        $this->load->view('layout/index', $this->data);
    }
}
