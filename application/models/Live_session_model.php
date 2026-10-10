<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Live_session_model
 * 
 * Handles real-time telemetry, classroom sessions, student presence tracking,
 * formative checks, and merit awards for Tahsin Academy.
 */
class Live_session_model extends CI_Model
{
    protected $tbl_sessions = 'live_class_sessions';
    protected $tbl_presence = 'live_student_presence';
    protected $tbl_checks   = 'live_formative_checks';
    protected $tbl_answers  = 'live_formative_responses';
    protected $tbl_merits   = 'live_merit_logs';

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->ensure_schema();
    }

    /**
     * Defensive schema verification ensuring tables exist on both local XAMPP and Hostinger
     */
    public function ensure_schema()
    {
        if (!$this->db->table_exists($this->tbl_sessions)) {
            $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->tbl_sessions}` (
                `id` INT AUTO_INCREMENT PRIMARY KEY,
                `branch_id` INT NOT NULL DEFAULT 1,
                `class_id` INT NOT NULL,
                `section_id` INT NOT NULL,
                `subject_id` INT NULL,
                `scheme_id` INT NULL,
                `teacher_id` INT NOT NULL,
                `session_title` VARCHAR(255) NOT NULL,
                `status` ENUM('active', 'paused', 'ended') DEFAULT 'active',
                `screen_lock` TINYINT(1) DEFAULT 0,
                `created_at` DATETIME NOT NULL,
                `ended_at` DATETIME NULL,
                INDEX (`class_id`, `section_id`, `status`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
        }

        if (!$this->db->table_exists($this->tbl_presence)) {
            $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->tbl_presence}` (
                `id` INT AUTO_INCREMENT PRIMARY KEY,
                `session_id` INT NOT NULL,
                `student_id` INT NOT NULL,
                `is_online` TINYINT(1) DEFAULT 1,
                `is_focused` TINYINT(1) DEFAULT 1,
                `hand_raised` TINYINT(1) DEFAULT 0,
                `hand_raised_note` VARCHAR(255) NULL,
                `hand_raised_at` DATETIME NULL,
                `current_task_status` VARCHAR(150) DEFAULT 'Viewing Lesson',
                `points_earned` INT DEFAULT 0,
                `last_ping` DATETIME NOT NULL,
                UNIQUE KEY `session_student` (`session_id`, `student_id`),
                INDEX (`session_id`, `last_ping`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
        }

        if (!$this->db->table_exists($this->tbl_checks)) {
            $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->tbl_checks}` (
                `id` INT AUTO_INCREMENT PRIMARY KEY,
                `session_id` INT NOT NULL,
                `prompt_text` TEXT NOT NULL,
                `question_type` ENUM('quick_poll', 'multiple_choice', 'open_ended') DEFAULT 'quick_poll',
                `options_json` TEXT NULL,
                `status` ENUM('open', 'closed') DEFAULT 'open',
                `created_at` DATETIME NOT NULL,
                INDEX (`session_id`, `status`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
        }

        if (!$this->db->table_exists($this->tbl_answers)) {
            $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->tbl_answers}` (
                `id` INT AUTO_INCREMENT PRIMARY KEY,
                `check_id` INT NOT NULL,
                `session_id` INT NOT NULL,
                `student_id` INT NOT NULL,
                `response_content` TEXT NOT NULL,
                `submitted_at` DATETIME NOT NULL,
                UNIQUE KEY `check_student` (`check_id`, `student_id`),
                INDEX (`session_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
        }

        if (!$this->db->table_exists($this->tbl_merits)) {
            $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->tbl_merits}` (
                `id` INT AUTO_INCREMENT PRIMARY KEY,
                `session_id` INT NOT NULL,
                `student_id` INT NOT NULL,
                `teacher_id` INT NOT NULL,
                `merit_badge` VARCHAR(100) NOT NULL,
                `points` INT NOT NULL DEFAULT 1,
                `created_at` DATETIME NOT NULL,
                INDEX (`session_id`),
                INDEX (`student_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
        }

        // Ensure student login is enabled for branches so students can access live classes
        if ($this->db->table_exists('branch') && $this->db->field_exists('student_login', 'branch')) {
            $this->db->query("UPDATE `branch` SET `student_login` = 1 WHERE `student_login` = 0 OR `student_login` IS NULL");
        }
    }

    /**
     * Create a new classroom session
     */
    public function create_session($data)
    {
        $data['created_at'] = date('Y-m-d H:i:s');
        $this->db->insert($this->tbl_sessions, $data);
        return $this->db->insert_id();
    }

    /**
     * Retrieve single session with related entity details
     */
    public function get_session($id)
    {
        $this->db->select("s.*, c.name as class_name, sec.name as section_name, sub.name as subject_name, st.name as teacher_name, sch.topic as scheme_topic, sch.sub_topic as scheme_sub_topic, sch.week_number as scheme_week, sch.objectives as scheme_objectives");
        $this->db->from("{$this->tbl_sessions} as s");
        $this->db->join('class as c', 'c.id = s.class_id', 'left');
        $this->db->join('section as sec', 'sec.id = s.section_id', 'left');
        $this->db->join('subject as sub', 'sub.id = s.subject_id', 'left');
        $this->db->join('staff as st', 'st.id = s.teacher_id', 'left');
        $this->db->join('schemes_of_work as sch', 'sch.id = s.scheme_id', 'left');
        $this->db->where('s.id', $id);
        return $this->db->get()->row_array();
    }

    /**
     * Get active or recent sessions with optional filtering
     */
    public function get_sessions_list($branch_id = null, $status = null, $teacher_id = null)
    {
        $this->db->select("s.*, c.name as class_name, sec.name as section_name, sub.name as subject_name, st.name as teacher_name, sch.topic as scheme_topic");
        $this->db->from("{$this->tbl_sessions} as s");
        $this->db->join('class as c', 'c.id = s.class_id', 'left');
        $this->db->join('section as sec', 'sec.id = s.section_id', 'left');
        $this->db->join('subject as sub', 'sub.id = s.subject_id', 'left');
        $this->db->join('staff as st', 'st.id = s.teacher_id', 'left');
        $this->db->join('schemes_of_work as sch', 'sch.id = s.scheme_id', 'left');

        if (!empty($branch_id)) {
            $this->db->where('s.branch_id', $branch_id);
        }
        if (!empty($status)) {
            $this->db->where('s.status', $status);
        }
        if (!empty($teacher_id)) {
            $this->db->where('s.teacher_id', $teacher_id);
        }

        $this->db->order_by('s.id', 'DESC');
        return $this->db->get()->result_array();
    }

    /**
     * Check if there is an active session for a student's class and section
     */
    public function get_active_student_session($class_id, $section_id)
    {
        $this->db->select("s.*, c.name as class_name, sec.name as section_name, sub.name as subject_name, st.name as teacher_name, sch.topic as scheme_topic, sch.sub_topic as scheme_sub_topic, sch.objectives as scheme_objectives, sch.class_work as scheme_class_work");
        $this->db->from("{$this->tbl_sessions} as s");
        $this->db->join('class as c', 'c.id = s.class_id', 'left');
        $this->db->join('section as sec', 'sec.id = s.section_id', 'left');
        $this->db->join('subject as sub', 'sub.id = s.subject_id', 'left');
        $this->db->join('staff as st', 'st.id = s.teacher_id', 'left');
        $this->db->join('schemes_of_work as sch', 'sch.id = s.scheme_id', 'left');
        $this->db->where('s.class_id', $class_id);
        $this->db->where('s.section_id', $section_id);
        $this->db->where('s.status', 'active');
        $this->db->order_by('s.id', 'DESC');
        return $this->db->get()->row_array();
    }

    /**
     * End a live session
     */
    public function end_session($id)
    {
        $this->db->where('id', $id);
        return $this->db->update($this->tbl_sessions, [
            'status'   => 'ended',
            'ended_at' => date('Y-m-d H:i:s')
        ]);
    }

    /**
     * Toggle "Eyes Up" screen freeze lock for a session
     */
    public function toggle_screen_lock($id)
    {
        $session = $this->db->get_where($this->tbl_sessions, ['id' => $id])->row_array();
        if (!$session) return false;

        $new_state = ($session['screen_lock'] == 1) ? 0 : 1;
        $this->db->where('id', $id);
        $this->db->update($this->tbl_sessions, ['screen_lock' => $new_state]);
        return $new_state;
    }

    /**
     * Record a student telemetry heartbeat ping
     */
    public function record_student_ping($session_id, $student_id, $is_focused = 1, $task_status = 'Viewing Lesson', $hand_raised = 0, $hand_note = null)
    {
        $now = date('Y-m-d H:i:s');
        $existing = $this->db->get_where($this->tbl_presence, [
            'session_id' => $session_id,
            'student_id' => $student_id
        ])->row_array();

        if ($existing) {
            $update = [
                'is_online'           => 1,
                'is_focused'          => (int)$is_focused,
                'current_task_status' => $task_status ? $task_status : $existing['current_task_status'],
                'last_ping'           => $now
            ];
            if ($hand_raised !== null) {
                $update['hand_raised'] = (int)$hand_raised;
                if ($hand_raised == 1 && $existing['hand_raised'] == 0) {
                    $update['hand_raised_at'] = $now;
                    $update['hand_raised_note'] = $hand_note;
                } elseif ($hand_raised == 0) {
                    $update['hand_raised_at'] = null;
                }
            }
            $this->db->where('id', $existing['id']);
            $this->db->update($this->tbl_presence, $update);
        } else {
            $insert = [
                'session_id'          => $session_id,
                'student_id'          => $student_id,
                'is_online'           => 1,
                'is_focused'          => (int)$is_focused,
                'hand_raised'         => (int)$hand_raised,
                'hand_raised_note'    => $hand_note,
                'hand_raised_at'      => $hand_raised ? $now : null,
                'current_task_status' => $task_status ? $task_status : 'Joined Classroom',
                'points_earned'       => 0,
                'last_ping'           => $now
            ];
            $this->db->insert($this->tbl_presence, $insert);
        }

        // Return current session status including screen_lock & active poll
        $session = $this->db->get_where($this->tbl_sessions, ['id' => $session_id])->row_array();
        $latest_merit = $this->db->order_by('id', 'DESC')->get_where($this->tbl_merits, [
            'session_id' => $session_id,
            'student_id' => $student_id
        ], 1)->row_array();

        $active_poll = $this->get_active_poll($session_id);

        return [
            'screen_locked' => ($session && $session['screen_lock'] == 1),
            'session_status'=> $session ? $session['status'] : 'ended',
            'latest_merit'  => $latest_merit,
            'active_poll'   => $active_poll
        ];
    }

    /**
     * Retrieve complete telemetry radar for all students in the class/section
     */
    public function get_telemetry_radar($session_id, $class_id, $section_id)
    {
        // 1. Get all enrolled students for this class/section
        $this->db->select("e.student_id, e.roll, s.first_name, s.last_name, s.register_no, s.photo, s.gender");
        $this->db->from('enroll as e');
        $this->db->join('student as s', 's.id = e.student_id', 'inner');
        $this->db->where('e.class_id', $class_id);
        $this->db->where('e.section_id', $section_id);
        $this->db->where('s.active', 1);
        $this->db->order_by('e.roll', 'ASC');
        $students = $this->db->get()->result_array();

        // 2. Get telemetry presence entries for this session
        $presence_rows = $this->db->get_where($this->tbl_presence, ['session_id' => $session_id])->result_array();
        $presence_map = [];
        foreach ($presence_rows as $p) {
            $presence_map[$p['student_id']] = $p;
        }

        // 3. Merge telemetry and calculate real-time connection state
        $now = time();
        $radar = [];
        $total_enrolled = count($students);
        $count_active = 0;
        $count_blur = 0;
        $count_offline = 0;
        $hand_raises = [];

        foreach ($students as $stu) {
            $sid = $stu['student_id'];
            $p = isset($presence_map[$sid]) ? $presence_map[$sid] : null;

            $status = 'offline';
            $is_online = 0;
            $is_focused = 0;
            $hand_raised = 0;
            $task = 'Not connected';
            $points = 0;
            $seconds_since_ping = 9999;

            if ($p) {
                $ping_time = strtotime($p['last_ping']);
                $seconds_since_ping = $now - $ping_time;
                $points = (int)$p['points_earned'];
                $task = $p['current_task_status'];

                if ($seconds_since_ping <= 15) {
                    $is_online = 1;
                    if ($p['is_focused'] == 1) {
                        $status = 'active';
                        $is_focused = 1;
                        $count_active++;
                    } else {
                        $status = 'blurred';
                        $is_focused = 0;
                        $count_blur++;
                    }
                } else {
                    $status = 'offline';
                    $count_offline++;
                }

                if ($p['hand_raised'] == 1 && $is_online) {
                    $hand_raised = 1;
                    $hand_raises[] = [
                        'student_id'   => $sid,
                        'name'         => $stu['first_name'] . ' ' . $stu['last_name'],
                        'note'         => $p['hand_raised_note'],
                        'raised_at'    => $p['hand_raised_at']
                    ];
                }
            } else {
                $count_offline++;
            }

            $radar[] = [
                'student_id'   => $sid,
                'roll'         => $stu['roll'],
                'name'         => trim($stu['first_name'] . ' ' . $stu['last_name']),
                'register_no'  => $stu['register_no'],
                'photo'        => $stu['photo'],
                'gender'       => $stu['gender'],
                'status'       => $status, // 'active', 'blurred', 'offline'
                'is_online'    => $is_online,
                'is_focused'   => $is_focused,
                'hand_raised'  => $hand_raised,
                'current_task' => $task,
                'points'       => $points,
                'seconds_ago'  => $seconds_since_ping
            ];
        }

        return [
            'students'       => $radar,
            'summary'        => [
                'total'      => $total_enrolled,
                'active'     => $count_active,
                'blurred'    => $count_blur,
                'offline'    => $count_offline,
                'focus_rate' => ($total_enrolled > 0 && ($count_active + $count_blur) > 0) 
                                ? round(($count_active / ($count_active + $count_blur)) * 100) 
                                : 0
            ],
            'hand_raises'    => $hand_raises
        ];
    }

    /**
     * Award positive merit points to a student
     */
    public function grant_merit($session_id, $student_id, $teacher_id, $badge, $points = 1)
    {
        // 1. Insert merit log
        $this->db->insert($this->tbl_merits, [
            'session_id'  => $session_id,
            'student_id'  => $student_id,
            'teacher_id'  => $teacher_id,
            'merit_badge' => $badge,
            'points'      => (int)$points,
            'created_at'  => date('Y-m-d H:i:s')
        ]);

        // 2. Increment presence points
        $this->db->query("UPDATE `{$this->tbl_presence}` 
            SET `points_earned` = `points_earned` + ? 
            WHERE `session_id` = ? AND `student_id` = ?", 
            [(int)$points, $session_id, $student_id]);

        return true;
    }

    /**
     * Clear hand raise for student
     */
    public function clear_hand_raise($session_id, $student_id)
    {
        $this->db->where('session_id', $session_id);
        $this->db->where('student_id', $student_id);
        return $this->db->update($this->tbl_presence, [
            'hand_raised' => 0,
            'hand_raised_note' => null,
            'hand_raised_at' => null
        ]);
    }

    /**
     * Launch a 60-second comprehension poll
     */
    public function create_poll($session_id, $prompt, $type = 'quick_poll', $options = [])
    {
        // Close prior open checks
        $this->db->where('session_id', $session_id);
        $this->db->update($this->tbl_checks, ['status' => 'closed']);

        $data = [
            'session_id'    => $session_id,
            'prompt_text'   => $prompt,
            'question_type' => $type,
            'options_json'  => json_encode($options),
            'status'        => 'open',
            'created_at'    => date('Y-m-d H:i:s')
        ];
        $this->db->insert($this->tbl_checks, $data);
        return $this->db->insert_id();
    }

    /**
     * Retrieve the currently open poll for a session
     */
    public function get_active_poll($session_id)
    {
        $this->db->where('session_id', $session_id);
        $this->db->where('status', 'open');
        $this->db->order_by('id', 'DESC');
        $poll = $this->db->get($this->tbl_checks, 1)->row_array();
        if ($poll) {
            $poll['options'] = json_decode($poll['options_json'], true);
        }
        return $poll;
    }

    /**
     * Submit an answer to a formative check
     */
    public function submit_poll_response($check_id, $session_id, $student_id, $answer)
    {
        $data = [
            'check_id'         => $check_id,
            'session_id'       => $session_id,
            'student_id'       => $student_id,
            'response_content' => trim($answer),
            'submitted_at'     => date('Y-m-d H:i:s')
        ];
        return $this->db->replace($this->tbl_answers, $data);
    }

    /**
     * Tally formative poll responses
     */
    public function get_poll_results($check_id)
    {
        $check = $this->db->get_where($this->tbl_checks, ['id' => $check_id])->row_array();
        if (!$check) return null;

        $answers = $this->db->get_where($this->tbl_answers, ['check_id' => $check_id])->result_array();
        $total = count($answers);

        $counts = [];
        $options = json_decode($check['options_json'], true);
        if ($options) {
            foreach ($options as $opt) {
                $counts[$opt] = 0;
            }
        }

        foreach ($answers as $a) {
            $ans = $a['response_content'];
            if (!isset($counts[$ans])) {
                $counts[$ans] = 0;
            }
            $counts[$ans]++;
        }

        return [
            'check'  => $check,
            'total'  => $total,
            'counts' => $counts
        ];
    }

    /**
     * Compile session summary metrics for 1-click WhatsApp Debrief
     */
    public function get_session_debrief_data($session_id)
    {
        $session = $this->get_session($session_id);
        if (!$session) return null;

        $radar = $this->get_telemetry_radar($session_id, $session['class_id'], $session['section_id']);
        
        // Total merits granted in this session
        $this->db->select("COUNT(*) as total_merits, SUM(points) as total_pts");
        $this->db->where('session_id', $session_id);
        $merit_stats = $this->db->get($this->tbl_merits)->row_array();

        // Top students awarded merits
        $this->db->select("s.first_name, s.last_name, SUM(m.points) as total_pts");
        $this->db->from("{$this->tbl_merits} as m");
        $this->db->join('student as s', 's.id = m.student_id', 'inner');
        $this->db->where('m.session_id', $session_id);
        $this->db->group_by('m.student_id');
        $this->db->order_by('total_pts', 'DESC');
        $top_honors = $this->db->get('', 3)->result_array();

        return [
            'session'     => $session,
            'radar'       => $radar['summary'],
            'merit_stats' => $merit_stats,
            'top_honors'  => $top_honors
        ];
    }
}
