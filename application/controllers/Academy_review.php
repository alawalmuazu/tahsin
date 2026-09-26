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

        if ($this->input->post('release_today')) {
            if (!is_superadmin_loggedin() && !is_admin_loggedin()) {
                access_denied();
            }
            $n = $this->academy_model->releaseToday($branchID, get_loggedin_user_id());
            $sent = trim(implode(' ', $this->academy_model->digestNotices));
            set_alert('success', $n > 0
                ? ('Released ' . (int) $n . ' sealed session' . ($n === 1 ? '' : 's') . '. Parent and student dashboards are updated.' . ($sent !== '' ? ' ' . $sent : ''))
                : 'No sessions are waiting for release today.');
            redirect(base_url('academy_review'));
        }

        if ($this->input->post('decide')) {
            $this->handleDecision($branchID);
        }

        $this->data['ready'] = $this->academy_model->reviewReady();
        $sessions = $this->data['ready']
            ? $this->academy_model->sessionsForViewer($branchID, get_loggedin_user_id())
            : array();
        $today = date('Y-m-d');
        $pendingAdminToday = 0;
        foreach ($sessions as $session) {
            $session->weak_clip = null;
            if (in_array($session->status, array('pending_director', 'pending_admin', 'acknowledged'), true)) {
                $session->weak_clip = $this->academy_model->weakClipForSession(
                    $branchID,
                    $session->teacher_id,
                    $session->session_date,
                    isset($session->recitation_category) ? $session->recitation_category : '',
                    isset($session->milestone_id) ? $session->milestone_id : 0
                );
            }
            if ($session->status === 'pending_admin' && $session->session_date === $today) {
                $pendingAdminToday++;
            }
        }
        usort($sessions, function ($a, $b) {
            $rank = function ($s) {
                if ($s->status === 'pending_director' && !empty($s->weak_clip)) {
                    return 0;
                }
                if ($s->status === 'pending_director') {
                    return 1;
                }
                if ($s->status === 'pending_admin') {
                    return 2;
                }
                return 3;
            };
            $ra = $rank($a);
            $rb = $rank($b);
            if ($ra !== $rb) {
                return $ra - $rb;
            }
            if ($ra === 0) {
                $aa = isset($a->weak_clip['accuracy']) && $a->weak_clip['accuracy'] !== null && $a->weak_clip['accuracy'] !== ''
                    ? (float) $a->weak_clip['accuracy'] : 101;
                $bb = isset($b->weak_clip['accuracy']) && $b->weak_clip['accuracy'] !== null && $b->weak_clip['accuracy'] !== ''
                    ? (float) $b->weak_clip['accuracy'] : 101;
                if ($aa != $bb) {
                    return $aa < $bb ? -1 : 1;
                }
            }
            return strcmp($b->session_date, $a->session_date);
        });
        $this->data['sessions'] = $sessions;
        $this->data['pending_admin_today'] = $pendingAdminToday;
        $this->data['can_director'] = is_superadmin_loggedin() || is_director_loggedin();
        $this->data['can_admin'] = is_superadmin_loggedin() || is_admin_loggedin();
        $this->data['is_teacher'] = is_teacher_loggedin();
        $this->data['title'] = 'Academy Session Review';
        $this->data['sub_page'] = 'academy/review';
        $this->data['main_menu'] = 'academy';
        $this->load->view('layout/index', $this->data);
    }

    /**
     * Director and admin analysis of stored Tarteel results.
     */
    public function tarteel()
    {
        $this->guardStaff();
        if (!is_superadmin_loggedin() && !is_admin_loggedin() && !is_director_loggedin()) {
            access_denied();
        }
        $branchID = $this->application_model->get_branch_id();
        $studentId = (int) $this->input->get('student_id');
        if ($studentId > 0 && !$this->studentInBranch($branchID, $studentId)) {
            $studentId = 0;
        }
        $rows = $this->academy_model->tarteelAnalyses($branchID, $studentId);
        $withReport = 0;
        $mistakeTotal = 0;
        $correctTotal = 0;
        $accSum = 0;
        $accN = 0;
        foreach ($rows as $row) {
            $report = $row->tarteel;
            if (!empty($report['mistakes']) || !empty($report['correct']) || $report['engine'] !== '') {
                $withReport++;
            }
            $mistakeTotal += count($report['mistakes']);
            $correctTotal += count($report['correct']);
            if ($row->accuracy_score !== null && $row->accuracy_score !== '') {
                $accSum += (float) $row->accuracy_score;
                $accN++;
            }
        }
        $this->data['rows'] = $rows;
        $this->data['insight'] = $this->academy_model->tarteelInsight($rows);
        $this->data['students'] = $this->studentsForAssign($branchID);
        $this->data['student_id'] = $studentId;
        $this->data['summary'] = array(
            'recordings' => count($rows),
            'with_report' => $withReport,
            'mistakes' => $mistakeTotal,
            'correct' => $correctTotal,
            'avg_accuracy' => $accN > 0 ? round($accSum / $accN, 1) : null,
        );
        $this->data['title'] = 'Tarteel analysis';
        $this->data['sub_page'] = 'academy/tarteel';
        $this->data['main_menu'] = 'academy';
        $this->load->view('layout/index', $this->data);
    }

    /**
     * Internal bands. A parent never sees this page.
     */
    public function tarteel_settings()
    {
        $this->guardStaff();
        if (!is_superadmin_loggedin() && !is_admin_loggedin() && !is_director_loggedin()) {
            access_denied();
        }
        $branchID = $this->application_model->get_branch_id();
        if ($this->input->post('save_tarteel_bands')) {
            $posted = $this->input->post('bands');
            $bands = array();
            if (is_array($posted)) {
                $sort = 1;
                foreach ($posted as $band) {
                    if (!is_array($band)) {
                        continue;
                    }
                    $bands[] = array(
                        'id' => isset($band['id']) ? (int) $band['id'] : 0,
                        'name' => isset($band['name']) ? $band['name'] : '',
                        'sort_order' => $sort++,
                        'strength_min_accuracy' => isset($band['strength_min_accuracy']) ? $band['strength_min_accuracy'] : 75,
                        'strength_max_mistakes' => isset($band['strength_max_mistakes']) ? $band['strength_max_mistakes'] : 1,
                        'weak_max_accuracy' => isset($band['weak_max_accuracy']) ? $band['weak_max_accuracy'] : 60,
                        'weak_min_mistakes' => isset($band['weak_min_mistakes']) ? $band['weak_min_mistakes'] : 4,
                    );
                }
            }
            $extra = trim((string) $this->input->post('new_band_name'));
            if ($extra !== '') {
                $bands[] = array(
                    'id' => 0,
                    'name' => $extra,
                    'sort_order' => count($bands) + 1,
                    'strength_min_accuracy' => $this->input->post('new_strength_min_accuracy'),
                    'strength_max_mistakes' => $this->input->post('new_strength_max_mistakes'),
                    'weak_max_accuracy' => $this->input->post('new_weak_max_accuracy'),
                    'weak_min_mistakes' => $this->input->post('new_weak_min_mistakes'),
                );
            }
            $assignments = $this->input->post('student_band');
            if (!is_array($assignments)) {
                $assignments = array();
            }
            $this->academy_model->saveTarteelBands($branchID, $bands, $assignments);
            set_alert('success', 'Tarteel levels saved. Analysis now uses each student’s level.');
            redirect(base_url('academy_review/tarteel_settings'));
        }
        $this->data['bands'] = $this->academy_model->tarteelBands($branchID);
        $this->data['assigned'] = $this->academy_model->tarteelStudentBands($branchID);
        $this->data['students'] = $this->studentsForAssign($branchID);
        $this->data['title'] = 'Tarteel settings';
        $this->data['sub_page'] = 'academy/tarteel_settings';
        $this->data['main_menu'] = 'academy';
        $this->load->view('layout/index', $this->data);
    }

    /**
     * Staff view of a student's Living Mushaf (sealed ayah grid).
     */
    public function mushaf()
    {
        $this->guardStaff();
        $branchID = $this->application_model->get_branch_id();
        $studentId = (int) $this->input->get('student_id');
        if ($studentId > 0 && !$this->studentInBranch($branchID, $studentId)) {
            $studentId = 0;
        }
        $surah = trim((string) $this->input->get('surah'));
        $this->data['students'] = $this->studentsForAssign($branchID);
        $this->data['student_id'] = $studentId;
        $this->data['surah'] = $surah;
        $this->data['surahs'] = $studentId > 0 ? $this->academy_model->sealedSurahs($branchID, $studentId) : array();
        $this->data['living'] = ($studentId > 0 && $surah !== '')
            ? $this->academy_model->livingMushafSurah($branchID, $studentId, $surah)
            : null;
        $this->data['continue_goal'] = $studentId > 0
            ? $this->academy_model->sealedContinueGoal($branchID, $studentId)
            : null;
        $this->data['pins'] = array(); // legacy unused; living grid replaces list
        $studentName = '';
        if ($studentId > 0) {
            $stu = $this->db->select('first_name, last_name')->where('id', $studentId)->get('student')->row();
            if ($stu) {
                $studentName = trim($stu->first_name . ' ' . $stu->last_name);
            }
        }
        $this->data['student_name'] = $studentName;
        $this->data['mushaf_base'] = 'academy_review/mushaf';
        $this->data['log_surah_base'] = 'academy_students';
        $this->data['is_staff_mushaf'] = true;
        $this->data['title'] = 'Living Mushaf';
        $this->data['sub_page'] = 'academy/mushaf';
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
            $sent = trim(implode(' ', $this->academy_model->digestNotices));
            set_alert('success', $approve
                ? ($step === 'admin'
                    ? ('Acknowledged. Parent and student dashboards are updated.' . ($sent !== '' ? ' ' . $sent : ''))
                    : 'Approved and sent to the admin.')
                : 'Rejected. The other party has been notified.');
        }
        redirect(base_url('academy_review'));
    }

    protected function studentInBranch($branchID, $studentId)
    {
        $sessionID = get_session_id();
        $this->db->where('student_id', (int) $studentId);
        $this->db->where('branch_id', (int) $branchID);
        if ($sessionID) {
            $this->db->where('session_id', (int) $sessionID);
        }
        return $this->db->count_all_results('enroll') > 0;
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
