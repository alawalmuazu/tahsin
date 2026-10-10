<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Live_session Controller
 * 
 * Tahsin Academy Live Classroom Telemetry, Facilitator Radar Cockpit,
 * Formative Checks, and Student Focus Monitoring.
 */
class Live_session extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Live_session_model', 'live_model');
        $this->load->model('Scheme_model');
        $this->load->helper(['url', 'form', 'text']);
        $this->load->library(['session', 'form_validation']);
    }

    /**
     * Session Management Hub & Classroom Launcher
     */
    public function index()
    {
        if (is_student_loggedin() || is_parent_loggedin()) {
            redirect(base_url('live_session/student_room'));
            return;
        }

        $branchID = $this->application_model->get_branch_id();

        $this->data['sessions']    = $this->live_model->get_sessions_list($branchID, null, null);
        $this->data['classes']     = $this->app_lib->getTable('class');
        $this->data['branch_id']   = $branchID;
        $this->data['schemes']     = $this->Scheme_model->get_schemes();
        $this->data['title']       = 'Live Classroom Cockpit & Telemetry';
        $this->data['sub_page']    = 'live_session/index';
        $this->data['main_menu']   = 'live_class';

        $this->load->view('layout/index', $this->data);
    }

    /**
     * AJAX endpoint to get sections by class (unrestricted for live classroom)
     */
    public function get_sections_by_class()
    {
        $classId = $this->input->post('class_id');
        $html = '<option value="">Select Section</option>';
        if (!empty($classId)) {
            $sections = $this->db->select('sa.section_id, s.name as section_name')
                ->from('sections_allocation as sa')
                ->join('section as s', 's.id = sa.section_id', 'left')
                ->where('sa.class_id', $classId)
                ->get()->result_array();

            if (empty($sections)) {
                $sections = $this->db->select('id as section_id, name as section_name')->get('section')->result_array();
            }

            foreach ($sections as $sec) {
                $html .= '<option value="' . $sec['section_id'] . '">' . html_escape($sec['section_name']) . '</option>';
            }
        }
        echo $html;
    }

    /**
     * Launch a new live session
     */
    public function start()
    {
        if (is_student_loggedin() || is_parent_loggedin()) {
            access_denied();
        }

        $this->form_validation->set_rules('class_id', translate('class'), 'trim|required');
        $this->form_validation->set_rules('section_id', translate('section'), 'trim|required');
        $this->form_validation->set_rules('session_title', 'Session Title', 'trim|required');

        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('live_session');
        } else {
            $branchID = $this->application_model->get_branch_id();
            $data = [
                'branch_id'     => $branchID ? $branchID : 1,
                'class_id'      => $this->input->post('class_id', true),
                'section_id'    => $this->input->post('section_id', true),
                'subject_id'    => $this->input->post('subject_id', true) ? $this->input->post('subject_id', true) : null,
                'scheme_id'     => $this->input->post('scheme_id', true) ? $this->input->post('scheme_id', true) : null,
                'teacher_id'    => get_loggedin_user_id(),
                'session_title' => $this->input->post('session_title', true),
                'status'        => 'active',
                'screen_lock'   => 0
            ];

            $sessionId = $this->live_model->create_session($data);
            $this->session->set_flashdata('success', 'Live Classroom Session initialized!');
            redirect('live_session/cockpit/' . $sessionId);
        }
    }

    /**
     * Live Facilitator Command Cockpit View
     */
    public function cockpit($sessionId = null)
    {
        if (is_student_loggedin() || is_parent_loggedin()) {
            access_denied();
        }

        if (empty($sessionId)) {
            redirect('live_session');
        }

        $session = $this->live_model->get_session($sessionId);
        if (!$session) {
            $this->session->set_flashdata('error', 'Classroom session not found.');
            redirect('live_session');
        }

        $radar = $this->live_model->get_telemetry_radar($sessionId, $session['class_id'], $session['section_id']);
        $activePoll = $this->live_model->get_active_poll($sessionId);

        $this->data['session']     = $session;
        $this->data['radar']       = $radar;
        $this->data['active_poll'] = $activePoll;
        $this->data['title']       = 'Facilitator Cockpit — ' . $session['session_title'];
        $this->data['sub_page']    = 'live_session/cockpit';
        $this->data['main_menu']   = 'live_class';

        $this->load->view('layout/index', $this->data);
    }

    /**
     * Live Radar Polling AJAX endpoint (called by Cockpit every 3-5 seconds)
     */
    public function radar_feed($sessionId = null)
    {
        $session = $this->live_model->get_session($sessionId);
        if (!$session) {
            echo json_encode(['status' => 'error', 'message' => 'Session not found']);
            return;
        }

        $radar = $this->live_model->get_telemetry_radar($sessionId, $session['class_id'], $session['section_id']);
        $activePoll = $this->live_model->get_active_poll($sessionId);

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status'        => 'success',
                'session_state' => $session['status'],
                'screen_locked' => (int)$session['screen_lock'],
                'summary'       => $radar['summary'],
                'students'      => $radar['students'],
                'hand_raises'   => $radar['hand_raises'],
                'active_poll'   => $activePoll
            ]));
    }

    /**
     * 1-Click Screen Freeze ("Eyes Up") Toggle
     */
    public function toggle_screen_lock($sessionId = null)
    {
        $newState = $this->live_model->toggle_screen_lock($sessionId);
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status'        => 'success',
                'screen_locked' => $newState
            ]));
    }

    /**
     * 1-Click Award Tahsin Merit Badge to Student
     */
    public function award_merit()
    {
        $sessionId = $this->input->post('session_id', true);
        $studentId = $this->input->post('student_id', true);
        $badge     = $this->input->post('badge_name', true);
        $points    = (int)$this->input->post('points', true);
        $teacherId = get_loggedin_user_id();

        if (empty($sessionId) || empty($studentId) || empty($badge)) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid parameters']);
            return;
        }

        $this->live_model->grant_merit($sessionId, $studentId, $teacherId, $badge, $points ? $points : 1);
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status'  => 'success',
                'message' => "Awarded {$points} merit(s) ({$badge})!"
            ]));
    }

    /**
     * Clear / Dismiss Student Hand Raise
     */
    public function clear_hand()
    {
        $sessionId = $this->input->post('session_id', true);
        $studentId = $this->input->post('student_id', true);

        $this->live_model->clear_hand_raise($sessionId, $studentId);
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(['status' => 'success']));
    }

    /**
     * Launch 60-Second Formative Comprehension Poll
     */
    public function create_poll()
    {
        $sessionId = $this->input->post('session_id', true);
        $prompt    = $this->input->post('prompt_text', true);
        $options   = $this->input->post('options'); // array of options

        if (empty($sessionId) || empty($prompt)) {
            echo json_encode(['status' => 'error', 'message' => 'Prompt required']);
            return;
        }

        if (empty($options)) {
            $options = ['A: Perfectly Clear 👍', 'B: Need Further Explanation 🤔'];
        }

        $pollId = $this->live_model->create_poll($sessionId, $prompt, 'quick_poll', $options);
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status'  => 'success',
                'poll_id' => $pollId,
                'message' => 'Poll launched to student screens!'
            ]));
    }

    /**
     * Fetch Live Formative Poll Results
     */
    public function poll_results($checkId = null)
    {
        $results = $this->live_model->get_poll_results($checkId);
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status'  => 'success',
                'results' => $results
            ]));
    }

    /**
     * End Live Session
     */
    public function end_session($sessionId = null)
    {
        $this->live_model->end_session($sessionId);
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status'  => 'success',
                'message' => 'Classroom session ended successfully.'
            ]));
    }

    /**
     * Generate 1-Click WhatsApp Class Debrief Broadcast for Parents
     */
    public function whatsapp_debrief($sessionId = null)
    {
        $data = $this->live_model->get_session_debrief_data($sessionId);
        if (!$data || !$data['session']) {
            echo json_encode(['status' => 'error', 'message' => 'Session not found']);
            return;
        }

        $s = $data['session'];
        $radar = $data['radar'];
        $merits = $data['merit_stats'];
        $honors = $data['top_honors'];

        $msg = "🌟 *TAHSIN ACADEMY — LIVE CLASSROOM SESSION DEBRIEF* 🌟\n";
        $msg .= "🏫 *Class:* " . $s['class_name'] . " (" . $s['section_name'] . ")\n";
        $msg .= "📚 *Subject / Session:* " . ($s['subject_name'] ? $s['subject_name'] : $s['session_title']) . "\n";
        $msg .= "👨‍🏫 *Facilitator:* " . $s['teacher_name'] . " | *Date:* " . date('d M Y') . "\n";
        $msg .= "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";

        if (!empty($s['scheme_topic'])) {
            $msg .= "🎯 *Curriculum Topic Covered:* " . $s['scheme_topic'] . "\n";
            if (!empty($s['scheme_sub_topic'])) {
                $msg .= "📖 *Sub-Topic:* " . $s['scheme_sub_topic'] . "\n";
            }
        }

        $msg .= "\n📊 *Live Engagement Radar:*\n";
        $msg .= "• Total Class Size: " . $radar['total'] . " students\n";
        $msg .= "• Active & Focused: " . $radar['active'] . " students\n";
        $msg .= "• Classroom Focus Index: " . $radar['focus_rate'] . "%\n";

        if (!empty($merits['total_pts']) && $merits['total_pts'] > 0) {
            $msg .= "\n🏆 *Merits & Commendations Awarded:*\n";
            $msg .= "• Total Positive Merits Granted: " . $merits['total_pts'] . " pts\n";
            if (!empty($honors)) {
                $msg .= "• Top Star Performers:\n";
                foreach ($honors as $h) {
                    $msg .= "   ⭐ " . $h['first_name'] . " " . $h['last_name'] . " (" . $h['total_pts'] . " pts)\n";
                }
            }
        }

        $msg .= "\n💡 *Parent Follow-Up:* Please review today's class notes and ensure workbook exercises are completed before tomorrow.\n";
        $msg .= "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
        $msg .= "_Tahsin Academy — Nurturing Faith & Academic Excellence_";

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status'  => 'success',
                'message' => $msg,
                'encoded' => rawurlencode($msg)
            ]));
    }

    /**
     * -------------------------------------------------------------
     * STUDENT PORTAL EXPERIENCE
     * -------------------------------------------------------------
     */

    /**
     * Student Live Classroom View
     */
    public function student_room($sessionId = null)
    {
        if (!is_student_loggedin()) {
            if (is_loggedin() && !empty($sessionId)) {
                // Allow facilitator/staff preview for testing and verification
                $studentId = $this->input->get('student_id') ? (int)$this->input->get('student_id') : 1;
                $session = $this->live_model->get_session($sessionId);
            } else {
                $this->session->set_flashdata('error', 'Please log into your student account.');
                redirect('authentication');
                return;
            }
        } else {
            $studentId = get_loggedin_user_id();
            $studentDetails = $this->application_model->getStudentDetails($studentId);
            $classId   = !empty($studentDetails['class_id']) ? $studentDetails['class_id'] : $this->session->userdata('class_id');
            $sectionId = !empty($studentDetails['section_id']) ? $studentDetails['section_id'] : $this->session->userdata('section_id');

            if (empty($classId)) {
                $enroll = $this->db->where('student_id', $studentId)->order_by('id', 'DESC')->get('enroll')->row_array();
                if (!empty($enroll)) {
                    $classId   = $enroll['class_id'];
                    $sectionId = $enroll['section_id'];
                }
            }

            if (empty($sessionId)) {
                $session = $this->live_model->get_active_student_session($classId, $sectionId);
                if (empty($session) && !empty($classId)) {
                    $session = $this->live_model->get_active_student_session($classId, null);
                }
                if (empty($session)) {
                    $session = $this->live_model->get_active_student_session(null, null);
                }
            } else {
                $session = $this->live_model->get_session($sessionId);
            }
        }

        $this->data['session']    = $session;
        $this->data['student_id'] = $studentId;
        $this->data['title']      = 'Student Live Classroom';
        $this->data['sub_page']   = 'live_session/student_room';
        $this->data['main_menu']  = 'live_class';

        $this->load->view('layout/index', $this->data);
    }

    /**
     * Student Telemetry Heartbeat Ping (called via fetch every 5 seconds)
     */
    public function student_ping()
    {
        $raw = file_get_contents('php://input');
        $json = json_decode($raw, true);

        if (!$json) {
            $json = $this->input->post();
        }

        $sessionId  = isset($json['session_id']) ? (int)$json['session_id'] : 0;
        $studentId  = is_student_loggedin() ? get_loggedin_user_id() : (isset($json['student_id']) ? (int)$json['student_id'] : 0);
        $isFocused  = isset($json['is_focused']) ? (int)$json['is_focused'] : 1;
        $taskStatus = isset($json['current_task']) ? $json['current_task'] : 'Viewing Lesson';
        $handRaised = isset($json['hand_raised']) ? (int)$json['hand_raised'] : 0;
        $handNote   = isset($json['hand_note']) ? $json['hand_note'] : null;

        if (!$sessionId || !$studentId) {
            echo json_encode(['status' => 'error', 'message' => 'Missing identifiers']);
            return;
        }

        $resp = $this->live_model->record_student_ping($sessionId, $studentId, $isFocused, $taskStatus, $handRaised, $handNote);

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(array_merge(['status' => 'success'], $resp)));
    }

    /**
     * Student Submit Poll Answer
     */
    public function submit_poll()
    {
        $raw = file_get_contents('php://input');
        $json = json_decode($raw, true);
        if (!$json) $json = $this->input->post();

        $checkId   = isset($json['check_id']) ? (int)$json['check_id'] : 0;
        $sessionId = isset($json['session_id']) ? (int)$json['session_id'] : 0;
        $studentId = is_student_loggedin() ? get_loggedin_user_id() : (isset($json['student_id']) ? (int)$json['student_id'] : 0);
        $answer    = isset($json['answer']) ? $json['answer'] : '';

        if (!$checkId || !$studentId || empty($answer)) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid submission']);
            return;
        }

        $this->live_model->submit_poll_response($checkId, $sessionId, $studentId, $answer);
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(['status' => 'success', 'message' => 'Response recorded!']));
    }
}
