<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Academy_model extends MY_Model
{
    /** Sentences from WhatsApp sends fired by acknowledgement. */
    public $digestNotices = array();

    public function __construct()
    {
        parent::__construct();
    }

    public function drillsReady()
    {
        try {
            return $this->db->table_exists('academy_daily_drill');
        } catch (Exception $e) {
            return false;
        } catch (Throwable $e) {
            return false;
        }
    }

    public function tahfizReady()
    {
        try {
            return $this->db->table_exists('academy_tahfiz_record');
        } catch (Exception $e) {
            return false;
        } catch (Throwable $e) {
            return false;
        }
    }

    public function pillars()
    {
        return array(
            'MATH' => 'Maths',
            'ENGLISH' => 'English',
            'ARABIC' => 'Arabic',
            'QURAN' => 'Quran',
            'VOCATIONAL' => 'Skills / Vocational',
            'CORE_SKILLS' => 'Core Skills',
        );
    }

    public function subCategories()
    {
        return array(
            'MATH' => array('Mental Math', 'Arithmetic', 'Word Problems', 'Fractions'),
            'ENGLISH' => array('Phonetics', 'Speaking', 'Writing', 'Debate'),
            'ARABIC' => array('Makharij', 'Grammar', 'Vocabulary'),
            'QURAN' => array('Recitation', 'Tajweed', 'Memorization'),
            'VOCATIONAL' => array('Computer', 'Solar', 'CCTV', 'Satellite'),
            'CORE_SKILLS' => array('Cognition', 'Logic', 'Critical Thinking'),
        );
    }

    public function portionModes()
    {
        return array(
            'FULL_SURAH' => 'Full Surah',
            'AYAH' => 'Single Ayah',
            'FROM_TO_AYAH' => 'From–To Ayah',
            'SUMMUI' => "Summu'i (⅛ hizb)",
            'RUBBUI' => "Rubbu'i (¼ hizb)",
            'SAFHA' => 'Safha (Madinah page)',
        );
    }

    /**
     * Halaqah recitation categories (required before Continue Next Ayah / Save).
     */
    public function recitationCategories()
    {
        return array(
            'HIFZ_FAUQ' => 'Hifz Fauq',
            'HIFZ_TAHT' => 'Hifz Taht',
            'TALQEEN' => 'Talqeen',
            'MURAJAA_QAREEBAH' => 'Murajaa Qareebah',
            'MURAJAA_BAEEDAH' => 'Murajaa Baeedah',
            'MUSAFFA' => 'Musaffa',
            'QIYAAMULLAIL' => 'Qiyaamullail',
        );
    }

    public function surahList()
    {
        return array(
            1 => 'Al-Fatihah', 2 => 'Al-Baqarah', 3 => 'Aal-Imran', 4 => 'An-Nisa',
            5 => 'Al-Maidah', 6 => 'Al-Anam', 7 => 'Al-Araf', 8 => 'Al-Anfal',
            9 => 'At-Tawbah', 10 => 'Yunus', 11 => 'Hud', 12 => 'Yusuf',
            13 => 'Ar-Rad', 14 => 'Ibrahim', 15 => 'Al-Hijr', 16 => 'An-Nahl',
            17 => 'Al-Isra', 18 => 'Al-Kahf', 19 => 'Maryam', 20 => 'Ta-Ha',
            21 => 'Al-Anbiya', 22 => 'Al-Hajj', 23 => 'Al-Muminun', 24 => 'An-Nur',
            25 => 'Al-Furqan', 26 => 'Ash-Shuara', 27 => 'An-Naml', 28 => 'Al-Qasas',
            29 => 'Al-Ankabut', 30 => 'Ar-Rum', 31 => 'Luqman', 32 => 'As-Sajdah',
            33 => 'Al-Ahzab', 34 => 'Saba', 35 => 'Fatir', 36 => 'Ya-Sin',
            37 => 'As-Saffat', 38 => 'Sad', 39 => 'Az-Zumar', 40 => 'Ghafir',
            41 => 'Fussilat', 42 => 'Ash-Shura', 43 => 'Az-Zukhruf', 44 => 'Ad-Dukhan',
            45 => 'Al-Jathiyah', 46 => 'Al-Ahqaf', 47 => 'Muhammad', 48 => 'Al-Fath',
            49 => 'Al-Hujurat', 50 => 'Qaf', 51 => 'Adh-Dhariyat', 52 => 'At-Tur',
            53 => 'An-Najm', 54 => 'Al-Qamar', 55 => 'Ar-Rahman', 56 => 'Al-Waqiah',
            57 => 'Al-Hadid', 58 => 'Al-Mujadila', 59 => 'Al-Hashr', 60 => 'Al-Mumtahanah',
            61 => 'As-Saff', 62 => 'Al-Jumuah', 63 => 'Al-Munafiqun', 64 => 'At-Taghabun',
            65 => 'At-Talaq', 66 => 'At-Tahrim', 67 => 'Al-Mulk', 68 => 'Al-Qalam',
            69 => 'Al-Haqqah', 70 => 'Al-Maarij', 71 => 'Nuh', 72 => 'Al-Jinn',
            73 => 'Al-Muzzammil', 74 => 'Al-Muddaththir', 75 => 'Al-Qiyamah', 76 => 'Al-Insan',
            77 => 'Al-Mursalat', 78 => 'An-Naba', 79 => 'An-Naziat', 80 => 'Abasa',
            81 => 'At-Takwir', 82 => 'Al-Infitar', 83 => 'Al-Mutaffifin', 84 => 'Al-Inshiqaq',
            85 => 'Al-Buruj', 86 => 'At-Tariq', 87 => 'Al-Ala', 88 => 'Al-Ghashiyah',
            89 => 'Al-Fajr', 90 => 'Al-Balad', 91 => 'Ash-Shams', 92 => 'Al-Layl',
            93 => 'Ad-Duha', 94 => 'Ash-Sharh', 95 => 'At-Tin', 96 => 'Al-Alaq',
            97 => 'Al-Qadr', 98 => 'Al-Bayyinah', 99 => 'Az-Zalzalah', 100 => 'Al-Adiyat',
            101 => 'Al-Qariah', 102 => 'At-Takathur', 103 => 'Al-Asr', 104 => 'Al-Humazah',
            105 => 'Al-Fil', 106 => 'Quraysh', 107 => 'Al-Maun', 108 => 'Al-Kawthar',
            109 => 'Al-Kafirun', 110 => 'An-Nasr', 111 => 'Al-Masad', 112 => 'Al-Ikhlas',
            113 => 'Al-Falaq', 114 => 'An-Nas',
        );
    }

    /**
     * Student ids assigned to the logged-in facilitator for this session.
     * Null means the viewer is not a teacher, so lists stay school-wide.
     */
    public function assignedStudentIds($branch_id)
    {
        if (!$this->db->table_exists('academy_teacher_student') || !function_exists('is_teacher_loggedin') || !is_teacher_loggedin()) {
            return null;
        }
        $rows = $this->db->select('student_id')
            ->from('academy_teacher_student')
            ->where('teacher_id', (int) get_loggedin_user_id())
            ->where('branch_id', (int) $branch_id)
            ->where('session_id', (int) get_session_id())
            ->get()->result();
        $ids = array();
        foreach ($rows as $row) {
            $ids[] = (int) $row->student_id;
        }
        return $ids;
    }

    public function getActiveStudents($branch_id)
    {
        $assigned = $this->assignedStudentIds($branch_id);
        if (is_array($assigned) && empty($assigned)) {
            return array();
        }
        $sessionID = get_session_id();
        $this->db->select('s.id, s.register_no, TRIM(CONCAT_WS(" ", s.first_name, NULLIF(s.other_name,""), s.last_name)) AS fullname, e.class_id, e.section_id, c.name AS class_name, se.name AS section_name');
        $this->db->from('enroll e');
        $this->db->join('student s', 's.id = e.student_id', 'inner');
        $this->db->join('class c', 'c.id = e.class_id', 'left');
        $this->db->join('section se', 'se.id = e.section_id', 'left');
        $this->db->where('e.branch_id', (int) $branch_id);
        if ($sessionID) {
            $this->db->where('e.session_id', (int) $sessionID);
        }
        if (is_array($assigned)) {
            $this->db->where_in('s.id', $assigned);
        }
        $this->db->order_by('s.first_name', 'ASC');
        return $this->db->get()->result();
    }

    public function saveDrill($data)
    {
        $score = max(0, (int) $data['score']);
        $time = max(0, (int) $data['time_seconds']);
        $spp = ($score > 0) ? round($time / $score, 4) : 0;

        $row = array(
            'branch_id' => (int) $data['branch_id'],
            'student_id' => (int) $data['student_id'],
            'evaluator_id' => (int) $data['evaluator_id'],
            'pillar' => $data['pillar'],
            'sub_category' => $data['sub_category'],
            'score' => $score,
            'total_possible' => max(1, (int) $data['total_possible']),
            'time_seconds' => $time,
            'spp_metric' => $spp,
            'notes' => isset($data['notes']) ? $data['notes'] : null,
        );
        $this->db->insert('academy_daily_drill', $row);
        return array('id' => $this->db->insert_id(), 'spp' => $spp);
    }

    public function getTodaysDrills($branch_id, $limit = 50)
    {
        $assigned = $this->assignedStudentIds($branch_id);
        if (is_array($assigned) && empty($assigned)) {
            return array();
        }
        $this->db->select('d.*, TRIM(CONCAT_WS(" ", s.first_name, NULLIF(s.other_name,""), s.last_name)) AS student_name, s.register_no');
        $this->db->from('academy_daily_drill d');
        $this->db->join('student s', 's.id = d.student_id', 'left');
        $this->db->where('d.branch_id', (int) $branch_id);
        $this->db->where('DATE(d.created_at)', date('Y-m-d'));
        if (is_array($assigned)) {
            $this->db->where_in('d.student_id', $assigned);
        }
        $this->db->order_by('d.id', 'DESC');
        $this->db->limit((int) $limit);
        return $this->db->get()->result();
    }

    public function getRecentDrills($branch_id, $limit = 100)
    {
        $assigned = $this->assignedStudentIds($branch_id);
        if (is_array($assigned) && empty($assigned)) {
            return array();
        }
        $this->db->select('d.*, TRIM(CONCAT_WS(" ", s.first_name, NULLIF(s.other_name,""), s.last_name)) AS student_name, s.register_no');
        $this->db->from('academy_daily_drill d');
        $this->db->join('student s', 's.id = d.student_id', 'left');
        $this->db->where('d.branch_id', (int) $branch_id);
        if (is_array($assigned)) {
            $this->db->where_in('d.student_id', $assigned);
        }
        $this->db->order_by('d.id', 'DESC');
        $this->db->limit((int) $limit);
        return $this->db->get()->result();
    }

    public function deleteDrill($id, $branch_id)
    {
        $this->db->where(array('id' => (int) $id, 'branch_id' => (int) $branch_id));
        return $this->db->delete('academy_daily_drill');
    }

    /**
     * Same facilitator, student, category, and portion already saved today.
     *
     * @return string empty when this save is new
     */
    public function priorMilestoneMessage($data)
    {
        if (!$this->tahfizReady()) {
            return '';
        }
        $cats = $this->recitationCategories();
        $cat = isset($data['recitation_category']) ? strtoupper(trim((string) $data['recitation_category'])) : '';
        $cat = ($cat !== '' && isset($cats[$cat])) ? $cat : '';
        $studentId = (int) (isset($data['student_id']) ? $data['student_id'] : 0);
        $teacherId = (int) (isset($data['instructor_id']) ? $data['instructor_id'] : 0);
        $surah = (int) (isset($data['surah_number']) ? $data['surah_number'] : 0);
        $ayahFrom = isset($data['ayah_from']) && $data['ayah_from'] !== '' && $data['ayah_from'] !== null ? (int) $data['ayah_from'] : 0;
        $ayahTo = isset($data['ayah_to']) && $data['ayah_to'] !== '' && $data['ayah_to'] !== null ? (int) $data['ayah_to'] : 0;
        $when = !empty($data['completed_at']) ? date('Y-m-d', strtotime($data['completed_at'])) : date('Y-m-d');
        if ($studentId < 1 || $teacherId < 1 || $surah < 1 || $cat === '') {
            return '';
        }
        $this->db->from('academy_tahfiz_record');
        $this->db->where('student_id', $studentId);
        $this->db->where('instructor_id', $teacherId);
        $this->db->where('surah_number', $surah);
        $this->db->where('DATE(completed_at)', $when);
        if ($this->db->field_exists('recitation_category', 'academy_tahfiz_record')) {
            $this->db->where('recitation_category', $cat);
        }
        if ($ayahFrom > 0) {
            $this->db->where('ayah_from', $ayahFrom);
        }
        if ($ayahTo > 0) {
            $this->db->where('ayah_to', $ayahTo);
        }
        $row = $this->db->order_by('id', 'DESC')->limit(1)->get()->row();
        if (!$row) {
            return '';
        }
        $surahs = $this->surahList();
        $name = isset($surahs[$surah]) ? $surahs[$surah] : 'this portion';
        $ayahLabel = ($ayahFrom > 0 && $ayahTo > 0 && $ayahFrom !== $ayahTo)
            ? ' (Ayah ' . $ayahFrom . '–' . $ayahTo . ')'
            : ($ayahFrom > 0 ? ' (Ayah ' . $ayahFrom . ')' : '');
        $status = 'already recorded';
        if ($this->db->table_exists('academy_class_session') && $this->db->field_exists('milestone_id', 'academy_class_session')) {
            $session = $this->db->get_where('academy_class_session', array('milestone_id' => (int) $row->id))->row();
            if ($session) {
                $labels = array(
                    'recording' => 'still recording',
                    'pending_director' => 'already with the director',
                    'director_rejected' => 'sent back by the director',
                    'pending_admin' => 'already with the admin',
                    'admin_rejected' => 'sent back by the admin',
                    'acknowledged' => 'already acknowledged',
                );
                $status = isset($labels[$session->status]) ? $labels[$session->status] : 'already recorded';
            }
        }
        $whenLabel = !empty($row->completed_at) ? date('j M Y, g:i A', strtotime($row->completed_at)) : '';
        $recorded = 'was recorded earlier today' . ($whenLabel !== '' ? ' (' . $whenLabel . ')' : '');
        return $cats[$cat] . ' · ' . $name . $ayahLabel . ' ' . $recorded . '. It is ' . $status . '.';
    }

    public function saveTahfiz($data)
    {
        $surahs = $this->surahList();
        $num = (int) $data['surah_number'];
        if ($num < 1 || $num > 114) {
            $num = 1;
        }
        $accuracy = isset($data['accuracy_score']) && $data['accuracy_score'] !== '' && $data['accuracy_score'] !== null
            ? (float) $data['accuracy_score'] : null;
        $tarteel = !empty($data['tarteel_status']) ? $data['tarteel_status'] : ($accuracy !== null ? 'VERIFIED' : 'UNVERIFIED');

        $row = array(
            'branch_id' => (int) $data['branch_id'],
            'student_id' => (int) $data['student_id'],
            'instructor_id' => (int) $data['instructor_id'],
            'surah_number' => $num,
            'surah_name' => isset($surahs[$num]) ? $surahs[$num] : 'Unknown',
            'portion_mode' => $data['portion_mode'],
            'ayah_from' => $data['ayah_from'] !== '' && $data['ayah_from'] !== null ? (int) $data['ayah_from'] : null,
            'ayah_to' => $data['ayah_to'] !== '' && $data['ayah_to'] !== null ? (int) $data['ayah_to'] : null,
            'page_from' => $data['page_from'] !== '' && $data['page_from'] !== null ? (int) $data['page_from'] : null,
            'page_to' => $data['page_to'] !== '' && $data['page_to'] !== null ? (int) $data['page_to'] : null,
            'verified' => !empty($data['verified']) ? 1 : 0,
            'akhlaq_note' => $data['akhlaq_note'],
            'completed_at' => !empty($data['completed_at']) ? $data['completed_at'] : date('Y-m-d H:i:s'),
        );

        if ($this->db->field_exists('recitation_category', 'academy_tahfiz_record')) {
            $cats = $this->recitationCategories();
            $cat = isset($data['recitation_category']) ? strtoupper(trim((string) $data['recitation_category'])) : '';
            $row['recitation_category'] = ($cat !== '' && isset($cats[$cat])) ? $cat : null;
        }

        // Optional v2 telemetry columns
        if ($this->db->field_exists('accuracy_score', 'academy_tahfiz_record')) {
            $row['accuracy_score'] = $accuracy;
            $row['mistake_word_count'] = isset($data['mistake_word_count']) && $data['mistake_word_count'] !== ''
                ? (int) $data['mistake_word_count'] : null;
            $row['mistake_breakdown'] = isset($data['mistake_breakdown']) ? $data['mistake_breakdown'] : null;
            $row['audio_url'] = isset($data['audio_url']) ? $data['audio_url'] : null;
            $row['video_url'] = isset($data['video_url']) ? $data['video_url'] : null;
            $row['tarteel_status'] = $tarteel;
            $row['recitation_seconds'] = isset($data['recitation_seconds']) && $data['recitation_seconds'] !== ''
                ? (int) $data['recitation_seconds'] : null;
        }

        $this->db->insert('academy_tahfiz_record', $row);
        $newId = $this->db->insert_id();
        if ($newId) {
            $sync = $data;
            $sync['surah_name'] = $row['surah_name'];
            if (isset($row['recitation_category'])) {
                $sync['recitation_category'] = $row['recitation_category'];
            }
            $this->syncQuranDrillFromTahfiz($sync);
        }
        return $newId;
    }

    /**
     * Attach/replace audio (and optional metrics/note) on an existing milestone.
     */
    public function updateTahfizMilestone($id, $student_id, $branch_id, $data)
    {
        $id = (int) $id;
        $student_id = (int) $student_id;
        $branch_id = (int) $branch_id;
        if ($id < 1 || $student_id < 1) {
            return false;
        }
        if (!$this->db->field_exists('audio_url', 'academy_tahfiz_record')) {
            return false;
        }
        $this->db->where(array(
            'id' => $id,
            'student_id' => $student_id,
            'branch_id' => $branch_id,
        ));
        $row = array();
        if (!empty($data['audio_url'])) {
            $row['audio_url'] = $data['audio_url'];
        }
        if (array_key_exists('video_url', $data) && $this->db->field_exists('video_url', 'academy_tahfiz_record')) {
            $row['video_url'] = $data['video_url'];
        }
        if (array_key_exists('akhlaq_note', $data)) {
            $row['akhlaq_note'] = $data['akhlaq_note'];
        }
        if (array_key_exists('recitation_category', $data) && $this->db->field_exists('recitation_category', 'academy_tahfiz_record')) {
            $cats = $this->recitationCategories();
            $cat = strtoupper(trim((string) $data['recitation_category']));
            $row['recitation_category'] = ($cat !== '' && isset($cats[$cat])) ? $cat : null;
        }
        if ($this->db->field_exists('accuracy_score', 'academy_tahfiz_record')) {
            if (array_key_exists('accuracy_score', $data)) {
                $row['accuracy_score'] = $data['accuracy_score'] !== '' && $data['accuracy_score'] !== null
                    ? (float) $data['accuracy_score'] : null;
            }
            if (isset($data['mistake_word_count']) && $data['mistake_word_count'] !== '') {
                $row['mistake_word_count'] = (int) $data['mistake_word_count'];
            }
            if (isset($data['recitation_seconds']) && $data['recitation_seconds'] !== '') {
                $row['recitation_seconds'] = (int) $data['recitation_seconds'];
            }
            if (!empty($data['tarteel_status'])) {
                $row['tarteel_status'] = $data['tarteel_status'];
            }
        }
        if (empty($row)) {
            return false;
        }
        return $this->db->update('academy_tahfiz_record', $row);
    }

    public function getRecentTahfiz($branch_id, $limit = 100)
    {
        $assigned = $this->assignedStudentIds($branch_id);
        if (is_array($assigned) && empty($assigned)) {
            return array();
        }
        $this->db->select('t.*, TRIM(CONCAT_WS(" ", s.first_name, NULLIF(s.other_name,""), s.last_name)) AS student_name, s.register_no');
        $this->db->from('academy_tahfiz_record t');
        $this->db->join('student s', 's.id = t.student_id', 'left');
        $this->db->where('t.branch_id', (int) $branch_id);
        if (is_array($assigned)) {
            $this->db->where_in('t.student_id', $assigned);
        }
        $this->db->order_by('t.id', 'DESC');
        $this->db->limit((int) $limit);
        return $this->db->get()->result();
    }

    public function deleteTahfiz($id, $branch_id)
    {
        $this->db->where(array('id' => (int) $id, 'branch_id' => (int) $branch_id));
        return $this->db->delete('academy_tahfiz_record');
    }

    /**
     * Barakah snapshot for a student (0–100).
     * Quran-first: coverage + accuracy + QURAN drills; other pillars from daily drills when present.
     * Academics 20%, Quran 50%, Vocational 15%, Arabic 15%.
     */
    public function barakahForStudent($student_id)
    {
        $sid = (int) $student_id;
        $parts = array('academics' => 0, 'quran' => 0, 'vocational' => 0, 'arabic' => 0);
        $surahCount = 0;
        $drillCount = 0;

        $avgPct = function ($pillars) use ($sid) {
            if (!$this->drillsReady() || empty($pillars)) {
                return 0.0;
            }
            $this->db->select('AVG((score / NULLIF(total_possible,0)) * 100) AS pct', false);
            $this->db->from('academy_daily_drill');
            $this->db->where('student_id', $sid);
            $this->db->where_in('pillar', $pillars);
            $this->db->where('created_at >=', date('Y-m-d', strtotime('-30 days')));
            $row = $this->db->get()->row();
            return $row && $row->pct !== null ? (float) $row->pct : 0.0;
        };

        $academics = $avgPct(array('MATH', 'ENGLISH'));
        $arabic = $avgPct(array('ARABIC'));
        $vocational = $avgPct(array('VOCATIONAL', 'CORE_SKILLS'));
        $quranDrill = $avgPct(array('QURAN'));

        $surahCoverage = 0.0;
        $accuracyAvg = 0.0;
        $logBoost = 0.0;
        if ($this->tahfizReady()) {
            $this->db->select('COUNT(DISTINCT surah_number) AS n');
            $this->db->from('academy_tahfiz_record');
            $this->db->where('student_id', $sid);
            $this->db->group_start();
            $this->db->where('verified', 1);
            if ($this->db->field_exists('audio_url', 'academy_tahfiz_record')) {
                $this->db->or_where("audio_url IS NOT NULL AND audio_url != ''", null, false);
            }
            $this->db->group_end();
            $surahCount = (int) $this->db->get()->row()->n;
            // ~30 distinct surahs → full coverage component
            $surahCoverage = min(($surahCount / 30.0) * 100.0, 100.0);

            if ($this->db->field_exists('accuracy_score', 'academy_tahfiz_record')) {
                $this->db->select('AVG(accuracy_score) AS a, COUNT(*) AS n', false);
                $this->db->from('academy_tahfiz_record');
                $this->db->where('student_id', $sid);
                $this->db->where('accuracy_score IS NOT NULL', null, false);
                $this->db->where('completed_at >=', date('Y-m-d', strtotime('-30 days')));
                $accRow = $this->db->get()->row();
                if ($accRow && $accRow->a !== null && (int) $accRow->n > 0) {
                    $accuracyAvg = (float) $accRow->a;
                }
            }

            $this->db->where('student_id', $sid);
            $this->db->where('completed_at >=', date('Y-m-d', strtotime('-30 days')));
            $recentLogs = (int) $this->db->count_all_results('academy_tahfiz_record');
            // Up to 20 recent logs → +15 pts toward Quran component
            $logBoost = min($recentLogs, 20) * 0.75;
        }

        if ($accuracyAvg <= 0 && $surahCoverage > 0) {
            // Verified logs without Tarteel score still count as solid practice
            $accuracyAvg = min(70.0, 40.0 + ($surahCount * 2.0));
        }
        $quran = min(
            ($surahCoverage * 0.40) + ($accuracyAvg * 0.40) + ($quranDrill * 0.20) + $logBoost,
            100.0
        );

        if ($this->drillsReady()) {
            $this->db->where('student_id', $sid);
            $drillCount = (int) $this->db->count_all_results('academy_daily_drill');
        }

        $parts['academics'] = (int) round($academics);
        $parts['quran'] = (int) round($quran);
        $parts['vocational'] = (int) round($vocational);
        $parts['arabic'] = (int) round($arabic);

        $score = (int) round(min(
            ($academics * 0.20) + ($quran * 0.50) + ($vocational * 0.15) + ($arabic * 0.15),
            100
        ));

        return array(
            'score' => $score,
            'parts' => $parts,
            'total_surahs' => $surahCount,
            'total_drills' => $drillCount,
        );
    }

    /**
     * Consecutive calendar days (ending today/yesterday) with a tahfiz log and/or a daily drill.
     */
    public function drillStreak($student_id)
    {
        $sid = (int) $student_id;
        $dates = array();

        if ($this->tahfizReady()) {
            $this->db->select('DATE(completed_at) AS d', false);
            $this->db->from('academy_tahfiz_record');
            $this->db->where('student_id', $sid);
            $this->db->group_by('DATE(completed_at)');
            $this->db->order_by('d', 'DESC');
            $this->db->limit(90);
            foreach ($this->db->get()->result() as $r) {
                if (!empty($r->d)) {
                    $dates[$r->d] = true;
                }
            }
        }

        if ($this->drillsReady()) {
            $this->db->select('DATE(created_at) AS d', false);
            $this->db->from('academy_daily_drill');
            $this->db->where('student_id', $sid);
            $this->db->group_by('DATE(created_at)');
            $this->db->order_by('d', 'DESC');
            $this->db->limit(90);
            foreach ($this->db->get()->result() as $r) {
                if (!empty($r->d)) {
                    $dates[$r->d] = true;
                }
            }
        }

        if (empty($dates)) {
            return 0;
        }

        $streak = 0;
        $cursor = new DateTime('today');
        // Allow streak to start from yesterday if nothing logged yet today
        if (!isset($dates[$cursor->format('Y-m-d')])) {
            $cursor->modify('-1 day');
            if (!isset($dates[$cursor->format('Y-m-d')])) {
                return 0;
            }
        }
        for ($i = 0; $i < 90; $i++) {
            $key = $cursor->format('Y-m-d');
            if (isset($dates[$key])) {
                $streak++;
                $cursor->modify('-1 day');
            } else {
                break;
            }
        }
        return $streak;
    }

    /**
     * Mirror a tahfiz save into a QURAN daily drill so Drills / Barakah / streak stay in sync.
     */
    public function syncQuranDrillFromTahfiz($data)
    {
        if (!$this->drillsReady()) {
            return null;
        }
        $accuracy = isset($data['accuracy_score']) && $data['accuracy_score'] !== '' && $data['accuracy_score'] !== null
            ? (float) $data['accuracy_score'] : null;
        $score = $accuracy !== null ? (int) max(0, min(100, round($accuracy))) : 85;
        $seconds = isset($data['recitation_seconds']) && $data['recitation_seconds'] !== ''
            ? (int) $data['recitation_seconds'] : 0;
        $sub = 'Recitation';
        if (!empty($data['recitation_category'])) {
            $cats = $this->recitationCategories();
            $ck = strtoupper(trim((string) $data['recitation_category']));
            if (isset($cats[$ck])) {
                $sub = $cats[$ck];
            }
        } elseif (!empty($data['surah_name'])) {
            $sub = (string) $data['surah_name'];
        }
        $notes = 'Auto from tahfiz log';
        if (!empty($data['surah_number'])) {
            $notes .= ' · surah ' . (int) $data['surah_number'];
        }

        return $this->saveDrill(array(
            'branch_id' => (int) $data['branch_id'],
            'student_id' => (int) $data['student_id'],
            'evaluator_id' => isset($data['instructor_id']) ? (int) $data['instructor_id'] : 0,
            'pillar' => 'QURAN',
            'sub_category' => $sub,
            'score' => $score,
            'total_possible' => 100,
            'time_seconds' => max(0, $seconds),
            'notes' => $notes,
        ));
    }

    /**
     * One-time: create QURAN drills from existing tahfiz rows so Drills/Barakah light up for older logs.
     */
    public function backfillQuranDrillsFromTahfiz($student_id, $branch_id)
    {
        if (!$this->drillsReady() || !$this->tahfizReady()) {
            return 0;
        }
        $sid = (int) $student_id;
        $bid = (int) $branch_id;
        $this->db->from('academy_daily_drill');
        $this->db->where(array('student_id' => $sid, 'pillar' => 'QURAN'));
        $this->db->like('notes', 'Auto from tahfiz', 'after');
        if ((int) $this->db->count_all_results() > 0) {
            return 0;
        }

        $this->db->from('academy_tahfiz_record');
        $this->db->where('student_id', $sid);
        $this->db->order_by('id', 'ASC');
        $this->db->limit(40);
        $rows = $this->db->get()->result();
        $n = 0;
        foreach ($rows as $r) {
            $this->syncQuranDrillFromTahfiz(array(
                'branch_id' => $bid > 0 ? $bid : (int) $r->branch_id,
                'student_id' => $sid,
                'instructor_id' => isset($r->instructor_id) ? (int) $r->instructor_id : 0,
                'surah_number' => (int) $r->surah_number,
                'surah_name' => isset($r->surah_name) ? $r->surah_name : '',
                'recitation_category' => isset($r->recitation_category) ? $r->recitation_category : '',
                'accuracy_score' => isset($r->accuracy_score) ? $r->accuracy_score : null,
                'recitation_seconds' => isset($r->recitation_seconds) ? $r->recitation_seconds : 0,
            ));
            $n++;
        }
        return $n;
    }

    /**
     * Primary parent mobile plus every extra_phones entry, unique after E.164 normalize.
     * Falls back to the student mobile only when the parent has no number.
     *
     * @return string[]
     */
    public function parentPhoneList($primary, $extraJson = '', $studentFallback = '')
    {
        $this->load->library('whatsapp_cloud');
        $raw = array();
        $primary = trim((string) $primary);
        if ($primary !== '') {
            $raw[] = $primary;
        }
        if ($extraJson !== '' && $extraJson !== null) {
            $decoded = is_array($extraJson) ? $extraJson : json_decode((string) $extraJson, true);
            if (is_array($decoded)) {
                foreach ($decoded as $phone) {
                    $phone = trim((string) $phone);
                    if ($phone !== '') {
                        $raw[] = $phone;
                    }
                }
            }
        }
        if (empty($raw)) {
            $fallback = trim((string) $studentFallback);
            if ($fallback !== '') {
                $raw[] = $fallback;
            }
        }
        $unique = array();
        foreach ($raw as $phone) {
            $n = $this->whatsapp_cloud->normalizePhone($phone);
            if ($n !== '') {
                $unique[$n] = true;
            }
        }
        return array_keys($unique);
    }

    /**
     * Full Academy Students cohort: roster + tahfiz + drills + barakah for hub UI.
     */
    public function getCohortRoster($branch_id)
    {
        $assigned = $this->assignedStudentIds($branch_id);
        if (is_array($assigned) && empty($assigned)) {
            return array();
        }
        $sessionID = get_session_id();
        $select = 's.id, s.register_no, s.admission_date, s.birthday, s.gender, s.mobileno, s.parent_id, s.photo,
            e.id AS enroll_id,
            TRIM(CONCAT_WS(" ", s.first_name, NULLIF(s.other_name,""), s.last_name)) AS fullname,
            e.class_id, e.section_id, c.name AS class_name, se.name AS section_name,
            p.name AS parent_name, p.mobileno AS parent_mobile';
        if ($this->db->field_exists('extra_phones', 'parent')) {
            $select .= ', p.extra_phones AS parent_extra_phones';
        }
        if ($this->db->field_exists('media_consent', 'student')) {
            $select .= ', s.media_consent';
        }
        $this->db->select($select, false);
        $this->db->from('enroll e');
        $this->db->join('student s', 's.id = e.student_id', 'inner');
        $this->db->join('class c', 'c.id = e.class_id', 'left');
        $this->db->join('section se', 'se.id = e.section_id', 'left');
        $this->db->join('parent p', 'p.id = s.parent_id', 'left');
        $this->db->where('e.branch_id', (int) $branch_id);
        if ($sessionID) {
            $this->db->where('e.session_id', (int) $sessionID);
        }
        if (is_array($assigned)) {
            $this->db->where_in('s.id', $assigned);
        }
        $this->db->group_by('s.id');
        $this->db->order_by('s.first_name', 'ASC');
        $students = $this->db->get()->result();

        $roster = array();
        foreach ($students as $s) {
            $sid = (int) $s->id;
            $tahfizRows = array();
            $latestSurah = null;
            $latestMilestone = null;
            $lastTahfizTs = 0;
            if ($this->tahfizReady()) {
                $this->db->select('*');
                $this->db->from('academy_tahfiz_record');
                $this->db->where('student_id', $sid);
                $this->db->order_by('completed_at', 'DESC');
                $this->db->order_by('id', 'DESC');
                $tahfizRows = $this->db->get()->result();
                if (!empty($tahfizRows)) {
                    $latestSurah = $tahfizRows[0]->surah_name;
                    $lastTahfizTs = strtotime($tahfizRows[0]->completed_at);
                    $latestMilestone = $this->formatTahfizMilestoneLabel($tahfizRows[0]);
                }
            }

            $lastDrillTs = 0;
            if ($this->drillsReady()) {
                $this->db->select('id, created_at');
                $this->db->from('academy_daily_drill');
                $this->db->where('student_id', $sid);
                $this->db->order_by('created_at', 'DESC');
                $this->db->limit(30);
                $drills = $this->db->get()->result();
                if (!empty($drills)) {
                    $lastDrillTs = strtotime($drills[0]->created_at);
                }
            }

            $enrollTs = !empty($s->admission_date) ? strtotime($s->admission_date) : 0;
            $lastActiveAt = max($enrollTs, $lastTahfizTs, $lastDrillTs);

            if (!empty($tahfizRows) && $this->drillsReady()) {
                $this->backfillQuranDrillsFromTahfiz($sid, (int) $branch_id);
            }

            $barakah = $this->barakahForStudent($sid);
            $streak = $this->drillStreak($sid);
            $metrics = $this->studentRecitationMetrics($tahfizRows);
            $goal = $this->nextGoalFromMilestone(!empty($tahfizRows) ? $tahfizRows[0] : null);

            $ageGroup = '';
            if (!empty($s->birthday) && $s->birthday !== '0000-00-00') {
                $age = (int) floor((time() - strtotime($s->birthday)) / (365.25 * 86400));
                if ($age > 0) {
                    if ($age <= 8) {
                        $ageGroup = '6-8';
                    } elseif ($age <= 11) {
                        $ageGroup = '9-11';
                    } elseif ($age <= 14) {
                        $ageGroup = '12-14';
                    } else {
                        $ageGroup = '15+';
                    }
                }
            }

            $classLevel = trim(($s->class_name ? $s->class_name : '') . ($s->section_name ? ' / ' . $s->section_name : ''));
            if ($classLevel === '') {
                $classLevel = 'Unassigned';
            }

            $photoFile = isset($s->photo) ? trim((string) $s->photo) : '';
            $hasPhoto = ($photoFile !== '' && $photoFile !== 'defualt.png'
                && is_file(FCPATH . 'uploads/images/student/' . $photoFile));

            $parentPhones = $this->parentPhoneList(
                isset($s->parent_mobile) ? $s->parent_mobile : '',
                isset($s->parent_extra_phones) ? $s->parent_extra_phones : '',
                isset($s->mobileno) ? $s->mobileno : ''
            );
            $roster[] = array(
                'id' => $sid,
                'enroll_id' => (int) $s->enroll_id,
                'fullname' => $s->fullname,
                'photo' => $photoFile,
                'photo_url' => get_image_url('student', $photoFile),
                'has_photo' => $hasPhoto,
                'register_no' => $s->register_no,
                'class_level' => $classLevel,
                'class_name' => $s->class_name,
                'section_name' => $s->section_name,
                'age_group' => $ageGroup,
                'gender' => $s->gender,
                'parent_contact' => !empty($parentPhones) ? $parentPhones[0] : ($s->parent_mobile ? $s->parent_mobile : $s->mobileno),
                'parent_phones' => $parentPhones,
                'parent_name' => $s->parent_name,
                'coordinator' => null,
                'admission_date' => $s->admission_date,
                'enrollment_status' => 'ACTIVE',
                'media_consent' => isset($s->media_consent) ? (int) $s->media_consent : 0,
                'latest_surah' => $latestSurah,
                'latest_milestone' => $latestMilestone,
                'surahs_count' => $barakah['total_surahs'],
                'tahfiz_count' => count($tahfizRows),
                'tahfiz_records' => $tahfizRows,
                'drills_count' => $barakah['total_drills'],
                'barakah' => $barakah['score'],
                'barakah_parts' => $barakah['parts'],
                'streak' => $streak,
                'last_active_at' => $lastActiveAt,
                'last_active' => $lastActiveAt ? date('Y-m-d H:i:s', $lastActiveAt) : null,
                'avg_accuracy' => $metrics['avg_accuracy'],
                'engagement_seconds' => $metrics['engagement_seconds'],
                'verses_logged' => $metrics['verses_logged'],
                'today_goal' => $goal['label'],
                'today_goal_detail' => $goal,
                'sealed_continue' => null,
            );
        }

        usort($roster, function ($a, $b) {
            return $b['last_active_at'] - $a['last_active_at'];
        });

        return $roster;
    }

    /**
     * Ayah counts for each surah (1–114).
     */
    public function surahAyahCounts()
    {
        return array(
            1 => 7, 2 => 286, 3 => 200, 4 => 176, 5 => 120, 6 => 165, 7 => 206, 8 => 75, 9 => 129, 10 => 109,
            11 => 123, 12 => 111, 13 => 43, 14 => 52, 15 => 99, 16 => 128, 17 => 111, 18 => 110, 19 => 98, 20 => 135,
            21 => 112, 22 => 78, 23 => 118, 24 => 64, 25 => 77, 26 => 227, 27 => 93, 28 => 88, 29 => 69, 30 => 60,
            31 => 34, 32 => 30, 33 => 73, 34 => 54, 35 => 45, 36 => 83, 37 => 182, 38 => 88, 39 => 75, 40 => 85,
            41 => 54, 42 => 53, 43 => 89, 44 => 59, 45 => 37, 46 => 35, 47 => 38, 48 => 29, 49 => 18, 50 => 45,
            51 => 60, 52 => 49, 53 => 62, 54 => 55, 55 => 78, 56 => 96, 57 => 29, 58 => 22, 59 => 24, 60 => 13,
            61 => 14, 62 => 11, 63 => 11, 64 => 18, 65 => 12, 66 => 12, 67 => 30, 68 => 52, 69 => 52, 70 => 44,
            71 => 28, 72 => 28, 73 => 20, 74 => 56, 75 => 40, 76 => 31, 77 => 50, 78 => 40, 79 => 46, 80 => 42,
            81 => 29, 82 => 19, 83 => 36, 84 => 25, 85 => 22, 86 => 17, 87 => 19, 88 => 26, 89 => 30, 90 => 20,
            91 => 15, 92 => 21, 93 => 11, 94 => 8, 95 => 8, 96 => 19, 97 => 5, 98 => 8, 99 => 8, 100 => 11,
            101 => 11, 102 => 8, 103 => 3, 104 => 9, 105 => 5, 106 => 4, 107 => 7, 108 => 3, 109 => 6, 110 => 3,
            111 => 5, 112 => 4, 113 => 5, 114 => 6,
        );
    }

    /**
     * Aggregate per-student recitation telemetry from tahfiz rows.
     */
    public function studentRecitationMetrics($tahfizRows)
    {
        $seconds = 0;
        $verses = 0;
        $accSum = 0;
        $accN = 0;
        $counts = $this->surahAyahCounts();
        foreach ((array) $tahfizRows as $r) {
            if (isset($r->recitation_seconds) && $r->recitation_seconds !== null && $r->recitation_seconds !== '') {
                $seconds += (int) $r->recitation_seconds;
            }
            $verses += $this->versesFromTahfizRow($r, $counts);
            if (isset($r->accuracy_score) && $r->accuracy_score !== null && $r->accuracy_score !== '') {
                $accSum += (float) $r->accuracy_score;
                $accN++;
            }
        }
        return array(
            'engagement_seconds' => $seconds,
            'verses_logged' => $verses,
            'avg_accuracy' => $accN > 0 ? round($accSum / $accN, 1) : null,
            'sessions' => count((array) $tahfizRows),
        );
    }

    public function versesFromTahfizRow($row, $counts = null)
    {
        if (!$row) {
            return 0;
        }
        if ($counts === null) {
            $counts = $this->surahAyahCounts();
        }
        $mode = isset($row->portion_mode) ? $row->portion_mode : 'FULL_SURAH';
        $sn = isset($row->surah_number) ? (int) $row->surah_number : 0;
        $from = isset($row->ayah_from) && $row->ayah_from !== '' && $row->ayah_from !== null ? (int) $row->ayah_from : 0;
        $to = isset($row->ayah_to) && $row->ayah_to !== '' && $row->ayah_to !== null ? (int) $row->ayah_to : $from;
        if ($mode === 'FULL_SURAH') {
            return isset($counts[$sn]) ? (int) $counts[$sn] : max(1, $to);
        }
        if ($from > 0 && $to > 0) {
            return max(1, $to - $from + 1);
        }
        if ($from > 0) {
            return 1;
        }
        return 1;
    }

    /**
     * Next portion suggestion after the latest milestone (Today's goal).
     */
    public function nextGoalFromMilestone($row)
    {
        if (!$row) {
            return array(
                'label' => 'Start Al-Fatihah (Ayah 1)',
                'surah_number' => 1,
                'surah_name' => 'Al-Fatihah',
                'ayah_from' => 1,
                'ayah_to' => 1,
                'portion_mode' => 'AYAH',
            );
        }
        $names = $this->surahList();
        $counts = $this->surahAyahCounts();
        $sn = isset($row->surah_number) ? (int) $row->surah_number : 1;
        $name = isset($row->surah_name) && $row->surah_name !== ''
            ? $row->surah_name
            : (isset($names[$sn]) ? $names[$sn] : 'Surah');
        $ayahs = isset($counts[$sn]) ? (int) $counts[$sn] : 7;
        $mode = isset($row->portion_mode) ? $row->portion_mode : 'FULL_SURAH';
        $last = 0;
        if (isset($row->ayah_to) && $row->ayah_to !== '' && $row->ayah_to !== null) {
            $last = (int) $row->ayah_to;
        } elseif (isset($row->ayah_from) && $row->ayah_from !== '' && $row->ayah_from !== null) {
            $last = (int) $row->ayah_from;
        }

        if ($mode === 'FULL_SURAH' || ($last > 0 && $last >= $ayahs)) {
            if ($sn >= 114) {
                return array(
                    'label' => 'Completed An-Nas — review or restart',
                    'surah_number' => 114,
                    'surah_name' => isset($names[114]) ? $names[114] : 'An-Nas',
                    'ayah_from' => 1,
                    'ayah_to' => 1,
                    'portion_mode' => 'AYAH',
                );
            }
            $ns = $sn + 1;
            $nname = isset($names[$ns]) ? $names[$ns] : ('Surah ' . $ns);
            return array(
                'label' => $nname . ' (Ayah 1)',
                'surah_number' => $ns,
                'surah_name' => $nname,
                'ayah_from' => 1,
                'ayah_to' => 1,
                'portion_mode' => 'AYAH',
            );
        }

        if ($last < 1) {
            return array(
                'label' => $name . ' (Ayah 1)',
                'surah_number' => $sn,
                'surah_name' => $name,
                'ayah_from' => 1,
                'ayah_to' => 1,
                'portion_mode' => 'AYAH',
            );
        }

        $next = $last + 1;
        return array(
            'label' => $name . ' (Ayah ' . $next . ')',
            'surah_number' => $sn,
            'surah_name' => $name,
            'ayah_from' => $next,
            'ayah_to' => $next,
            'portion_mode' => 'AYAH',
        );
    }

    /**
     * Cohort Activity KPIs for DAY / WEEK / MONTH / ALL windows.
     */
    public function cohortActivityKpis($roster)
    {
        $now = time();
        $windows = array(
            'day' => $now - 86400,
            'week' => $now - (7 * 86400),
            'month' => $now - (30 * 86400),
            'all' => 0,
        );
        $totalStudents = max(1, count($roster));
        $out = array();
        foreach ($windows as $key => $since) {
            $sessions = 0;
            $seconds = 0;
            $verses = 0;
            $accSum = 0;
            $accN = 0;
            $activeIds = array();
            $counts = $this->surahAyahCounts();
            foreach ($roster as $st) {
                if (empty($st['tahfiz_records'])) {
                    continue;
                }
                foreach ($st['tahfiz_records'] as $r) {
                    $ts = !empty($r->completed_at) ? strtotime($r->completed_at) : 0;
                    if ($since > 0 && $ts < $since) {
                        continue;
                    }
                    $sessions++;
                    $activeIds[(int) $st['id']] = true;
                    if (isset($r->recitation_seconds) && $r->recitation_seconds !== null && $r->recitation_seconds !== '') {
                        $seconds += (int) $r->recitation_seconds;
                    }
                    $verses += $this->versesFromTahfizRow($r, $counts);
                    if (isset($r->accuracy_score) && $r->accuracy_score !== null && $r->accuracy_score !== '') {
                        $accSum += (float) $r->accuracy_score;
                        $accN++;
                    }
                }
            }
            $active = count($activeIds);
            $out[$key] = array(
                'sessions' => $sessions,
                'engagement_seconds' => $seconds,
                'engagement_label' => $this->formatDuration($seconds),
                'verses' => $verses,
                'avg_accuracy' => $accN > 0 ? round($accSum / $accN, 1) : null,
                'active_students' => $active,
                'completion_pct' => (int) round(($active / $totalStudents) * 100),
            );
        }
        return $out;
    }

    public function formatDuration($seconds)
    {
        $seconds = (int) $seconds;
        if ($seconds < 60) {
            return $seconds . 's';
        }
        $m = (int) floor($seconds / 60);
        $s = $seconds % 60;
        if ($m < 60) {
            return $s > 0 ? ($m . 'm ' . $s . 's') : ($m . 'm');
        }
        $h = (int) floor($m / 60);
        $rm = $m % 60;
        return $rm > 0 ? ($h . 'h ' . $rm . 'm') : ($h . 'h');
    }

    /**
     * Leaderboard slices: engagement (Barakah) vs completions (logs).
     */
    public function cohortLeaderboard($roster, $limit = 5)
    {
        $byBarakah = $roster;
        usort($byBarakah, function ($a, $b) {
            $d = ((int) $b['barakah']) - ((int) $a['barakah']);
            if ($d !== 0) {
                return $d;
            }
            return ((int) $b['tahfiz_count']) - ((int) $a['tahfiz_count']);
        });
        $byLogs = $roster;
        usort($byLogs, function ($a, $b) {
            $d = ((int) $b['tahfiz_count']) - ((int) $a['tahfiz_count']);
            if ($d !== 0) {
                return $d;
            }
            return ((int) $b['barakah']) - ((int) $a['barakah']);
        });

        $map = function ($rows, $limit, $mode) {
            $slice = array_slice($rows, 0, $limit);
            $out = array();
            $rank = 1;
            foreach ($slice as $st) {
                $out[] = array(
                    'rank' => $rank++,
                    'id' => (int) $st['id'],
                    'name' => $st['fullname'],
                    'class_level' => $st['class_level'],
                    'barakah' => (int) $st['barakah'],
                    'tahfiz_count' => (int) $st['tahfiz_count'],
                    'surahs_count' => (int) $st['surahs_count'],
                    'streak' => (int) $st['streak'],
                    'avg_accuracy' => isset($st['avg_accuracy']) ? $st['avg_accuracy'] : null,
                    'today_goal' => isset($st['today_goal']) ? $st['today_goal'] : null,
                    'score_label' => $mode === 'engagement'
                        ? ((int) $st['barakah'] . ' Barakah')
                        : ((int) $st['tahfiz_count'] . ' log' . ((int) $st['tahfiz_count'] === 1 ? '' : 's')),
                );
            }
            return $out;
        };

        return array(
            'engagement' => $map($byBarakah, $limit, 'engagement'),
            'completions' => $map($byLogs, $limit, 'completions'),
        );
    }

    /**
     * Human label for a tahfiz row, e.g. "Al-Fatihah (Ayah 2)" or "Al-Baqarah (Full Surah)".
     */
    public function formatTahfizMilestoneLabel($row)
    {
        if (!$row) {
            return null;
        }
        $name = isset($row->surah_name) ? $row->surah_name : 'Surah';
        $mode = isset($row->portion_mode) ? $row->portion_mode : 'FULL_SURAH';
        $from = isset($row->ayah_from) ? $row->ayah_from : null;
        $to = isset($row->ayah_to) ? $row->ayah_to : null;
        if ($mode === 'FULL_SURAH') {
            return $name . ' (Full Surah)';
        }
        if ($from !== null && $from !== '' && $to !== null && $to !== '' && (int) $from !== (int) $to) {
            return $name . ' (Ayah ' . (int) $from . '–' . (int) $to . ')';
        }
        if ($from !== null && $from !== '') {
            return $name . ' (Ayah ' . (int) $from . ')';
        }
        if ($mode === 'SAFHA' && !empty($row->page_from)) {
            $pages = (int) $row->page_from;
            if (!empty($row->page_to) && (int) $row->page_to !== $pages) {
                $pages .= '–' . (int) $row->page_to;
            }
            return $name . ' (Page ' . $pages . ')';
        }
        return $name;
    }

    public function setMediaConsent($student_id, $value)
    {
        if (!$this->db->field_exists('media_consent', 'student')) {
            return false;
        }
        $this->db->where('id', (int) $student_id);
        return $this->db->update('student', array('media_consent' => $value ? 1 : 0));
    }

    /**
     * Parse ambient voice transcript into a drill payload.
     * Example: "Ali scored 18 out of 20 in maths in 45 seconds"
     */
    public function parseVoiceCommand($transcript, $branch_id)
    {
        $text = strtolower(trim($transcript));
        $students = $this->getActiveStudents($branch_id);
        $matched = null;
        foreach ($students as $s) {
            $name = strtolower($s->fullname);
            $first = strtolower(explode(' ', trim($s->fullname))[0]);
            if ($first && (strpos($text, $first) !== false || strpos($text, $name) !== false)) {
                $matched = $s;
                break;
            }
        }
        if (!$matched) {
            return array('success' => false, 'message' => 'Could not identify a student name in the audio.');
        }

        $pillar = '';
        if (strpos($text, 'math') !== false) {
            $pillar = 'MATH';
        } elseif (preg_match('/english|speaking|phonetics/', $text)) {
            $pillar = 'ENGLISH';
        } elseif (preg_match('/arabic|makharij/', $text)) {
            $pillar = 'ARABIC';
        } elseif (preg_match('/quran|surah|verse|tahfiz/', $text)) {
            $pillar = 'QURAN';
        } elseif (preg_match('/vocational|cctv|solar|computer|skill/', $text)) {
            $pillar = 'VOCATIONAL';
        } elseif (preg_match('/critical|cognition|logic/', $text)) {
            $pillar = 'CORE_SKILLS';
        }
        if ($pillar === '') {
            return array('success' => false, 'message' => 'Could not identify a subject for ' . $matched->fullname . '.');
        }

        $timeSeconds = 10;
        if (preg_match('/(\d+)\s*(second|seconds|sec)\b/', $text, $m)) {
            $timeSeconds = (int) $m[1];
        }

        $score = 15;
        $total = 20;
        if (preg_match('/perfect|excellent|flawless/', $text)) {
            $score = 20;
        } elseif (preg_match('/failed|needs help|poor/', $text)) {
            $score = 5;
        } elseif (preg_match('/(\d+)\s*(out of|over)\s*(\d+)/', $text, $m)) {
            $score = (int) $m[1];
            $total = (int) $m[3];
        } elseif (preg_match('/score\s*(?:is)?\s*(\d+)/', $text, $m)) {
            $score = (int) $m[1];
        }

        // Surah logging shortcut
        $surahNumber = null;
        $surahs = $this->surahList();
        foreach ($surahs as $num => $name) {
            $n = strtolower(str_replace(array('-', "'"), array(' ', ''), $name));
            if (strpos($text, $n) !== false || strpos($text, strtolower($name)) !== false) {
                $surahNumber = $num;
                break;
            }
        }

        return array(
            'success' => true,
            'student_id' => (int) $matched->id,
            'student_name' => $matched->fullname,
            'pillar' => $pillar,
            'score' => $score,
            'total_possible' => $total,
            'time_seconds' => $timeSeconds,
            'surah_number' => $surahNumber,
            'message' => 'Parsed drill for ' . $matched->fullname . ' — ' . $pillar,
        );
    }

    public function getGenomeOverview($branch_id)
    {
        $roster = $this->getCohortRoster($branch_id);
        $studentsOut = array();
        $critical = array();
        $barakahSum = 0;
        $gradReady = 0;

        foreach ($roster as $st) {
            $sid = $st['id'];
            $drills = array();
            if ($this->drillsReady()) {
                $this->db->from('academy_daily_drill');
                $this->db->where('student_id', $sid);
                $this->db->order_by('created_at', 'ASC');
                $drills = $this->db->get()->result();
            }

            $byPillar = array();
            $twoWeeksAgo = strtotime('-14 days');
            $fourWeeksAgo = strtotime('-28 days');
            $recentScores = array();
            $olderScores = array();

            foreach ($drills as $d) {
                $pct = $d->total_possible > 0 ? ($d->score / $d->total_possible) * 100 : 0;
                if (!isset($byPillar[$d->pillar])) {
                    $byPillar[$d->pillar] = array();
                }
                $byPillar[$d->pillar][] = $pct;
                $ts = strtotime($d->created_at);
                if ($ts >= $twoWeeksAgo) {
                    $recentScores[] = $pct;
                } elseif ($ts >= $fourWeeksAgo) {
                    $olderScores[] = $pct;
                }
            }

            $best = '—';
            $weak = '—';
            $bestAvg = -1;
            $weakAvg = 101;
            foreach ($byPillar as $pillar => $scores) {
                $avg = array_sum($scores) / count($scores);
                if ($avg > $bestAvg) {
                    $bestAvg = $avg;
                    $best = $pillar;
                }
                if ($avg < $weakAvg) {
                    $weakAvg = $avg;
                    $weak = $pillar;
                }
            }

            $rolling = count($recentScores) ? (int) round(array_sum($recentScores) / count($recentScores)) : 0;
            $alerts = array();

            if (count($recentScores) >= 3 && count($olderScores) >= 3) {
                $olderAvg = array_sum($olderScores) / count($olderScores);
                $delta = $rolling - $olderAvg;
                if ($delta <= -15) {
                    $alerts[] = array(
                        'type' => 'DECLINING',
                        'severity' => 'critical',
                        'message' => 'Performance dropped ' . abs((int) round($delta)) . '% over 2 weeks.',
                    );
                } elseif ($delta >= 10) {
                    $alerts[] = array(
                        'type' => 'IMPROVING',
                        'severity' => 'success',
                        'message' => 'Performance improved ' . (int) round($delta) . '% over 2 weeks.',
                    );
                }
            }

            if (!empty($drills)) {
                $last = end($drills);
                $days = (int) floor((time() - strtotime($last->created_at)) / 86400);
                if ($days >= 5) {
                    $alerts[] = array(
                        'type' => 'INACTIVE',
                        'severity' => 'warning',
                        'message' => 'No drills logged in ' . $days . ' days.',
                    );
                }
            }

            if ($st['streak'] >= 7) {
                $alerts[] = array(
                    'type' => 'STREAK',
                    'severity' => 'info',
                    'message' => $st['streak'] . '-day drill streak.',
                );
            }

            $ready = $st['barakah'] >= 80 && count($drills) >= 12;
            if ($ready) {
                $gradReady++;
                $alerts[] = array(
                    'type' => 'GRADUATION_READY',
                    'severity' => 'success',
                    'message' => 'Barakah ' . $st['barakah'] . '/100 — ready for next level.',
                );
            }

            foreach ($alerts as $a) {
                if ($a['severity'] === 'critical' || $a['severity'] === 'warning') {
                    $critical[] = array(
                        'student' => $st['fullname'],
                        'student_id' => $sid,
                        'type' => $a['type'],
                        'severity' => $a['severity'],
                        'message' => $a['message'],
                    );
                }
            }

            $barakahSum += $st['barakah'];
            $studentsOut[] = array(
                'student_id' => $sid,
                'student_name' => $st['fullname'],
                'rolling_avg' => $rolling,
                'best_subject' => $best,
                'weakest_subject' => $weak,
                'streak' => $st['streak'],
                'total_drills' => count($drills),
                'barakah' => $st['barakah'],
                'alerts' => $alerts,
                'graduation_ready' => $ready,
                'today_goal' => isset($st['today_goal']) ? $st['today_goal'] : null,
            );
        }

        $n = count($roster);
        return array(
            'avg_barakah' => $n ? (int) round($barakahSum / $n) : 0,
            'graduation_candidates' => $gradReady,
            'critical_alerts' => $critical,
            'students' => $studentsOut,
        );
    }

    public function generateDailyBroadcast($branch_id)
    {
        $roster = $this->getCohortRoster($branch_id);
        $today = date('Y-m-d');
        $reports = array();
        $withPhone = 0;
        $withDrills = 0;

        $awaitingReview = 0;
        $gateReview = $this->db->table_exists('academy_class_session');

        foreach ($roster as $st) {
            $ackTeachers = $gateReview ? $this->acknowledgedTeacherIds((int) $branch_id, (int) $st['id'], $today) : array();
            if ($gateReview && empty($ackTeachers)) {
                $awaitingReview++;
                continue;
            }
            $drills = array();
            if ($this->drillsReady()) {
                $this->db->from('academy_daily_drill');
                $this->db->where('student_id', $st['id']);
                $this->db->where('DATE(created_at)', $today);
                if ($gateReview) {
                    $this->db->where_in('evaluator_id', $ackTeachers);
                }
                $drills = $this->db->get()->result();
            }
            $tahfizToday = array();
            if ($this->tahfizReady()) {
                $this->db->from('academy_tahfiz_record');
                $this->db->where('student_id', $st['id']);
                $this->db->where('DATE(completed_at)', $today);
                if ($gateReview) {
                    $this->db->where_in('instructor_id', $ackTeachers);
                }
                $tahfizToday = $this->db->get()->result();
            }

            if (!empty($st['parent_phones']) || $st['parent_contact']) {
                $withPhone++;
            }
            if (!empty($drills)) {
                $withDrills++;
            }

            $emoji = array(
                'MATH' => '🔢', 'ENGLISH' => '🗣️', 'ARABIC' => '🕌',
                'QURAN' => '📖', 'VOCATIONAL' => '🛠️', 'CORE_SKILLS' => '🧠',
            );
            $lines = array(
                '📊 *Tahsin Academy — Daily Report*',
                'Student: *' . $st['fullname'] . '*',
                'Date: ' . date('l, j F Y'),
                '',
            );
            if (empty($drills)) {
                $lines[] = 'No drills were logged today.';
            } else {
                foreach ($drills as $d) {
                    $pct = $d->total_possible > 0 ? round(($d->score / $d->total_possible) * 100) : 0;
                    $em = isset($emoji[$d->pillar]) ? $emoji[$d->pillar] : '📝';
                    $sub = $d->sub_category ? ' (' . $d->sub_category . ')' : '';
                    $rec = $pct >= 90 ? ' — New Record! 🏆' : '';
                    $lines[] = $em . ' ' . $d->pillar . $sub . ': ' . $d->score . '/' . $d->total_possible
                        . ' (SPP: ' . number_format((float) $d->spp_metric, 1) . 's)' . $rec;
                }
            }
            if (!empty($tahfizToday)) {
                $lines[] = '';
                $lines[] = '*Today\'s Quran milestones:*';
                $mediaLines = array();
                foreach ($tahfizToday as $t) {
                    $label = $this->formatTahfizMilestoneLabel($t);
                    if (!$label) {
                        $label = $t->surah_name;
                    }
                    $bits = array('📖 ' . $label);
                    if (!empty($t->recitation_category)) {
                        $cats = $this->recitationCategories();
                        $ck = strtoupper($t->recitation_category);
                        $bits[] = isset($cats[$ck]) ? $cats[$ck] : $ck;
                    }
                    if (isset($t->accuracy_score) && $t->accuracy_score !== null && $t->accuracy_score !== '') {
                        $bits[] = 'Accuracy ' . round((float) $t->accuracy_score, 1) . '%';
                    }
                    if (isset($t->mistake_word_count) && $t->mistake_word_count !== null && $t->mistake_word_count !== '') {
                        $bits[] = ((int) $t->mistake_word_count) . ' mistake' . ((int) $t->mistake_word_count === 1 ? '' : 's');
                    }
                    $lines[] = implode(' · ', $bits);

                    $audio = $this->absoluteMediaUrl(isset($t->audio_url) ? $t->audio_url : '');
                    $video = $this->absoluteMediaUrl(isset($t->video_url) ? $t->video_url : '');
                    if ($audio) {
                        $mediaLines[] = '🎙️ Audio — ' . $label . ":\n" . $audio;
                    }
                    if ($video) {
                        $mediaLines[] = '🎥 Video — ' . $label . ":\n" . $video;
                    }
                }
                if (!empty($mediaLines)) {
                    $lines[] = '';
                    $lines[] = '*Listen / watch:*';
                    foreach ($mediaLines as $ml) {
                        $lines[] = $ml;
                    }
                }
            }
            if (!empty($st['today_goal'])) {
                $lines[] = '';
                $lines[] = '🎯 *Next goal:* ' . $st['today_goal'];
            }
            if (!empty($st['streak'])) {
                $lines[] = '🔥 Drill streak: ' . (int) $st['streak'] . ' day' . ((int) $st['streak'] === 1 ? '' : 's');
            }
            $parts = $st['barakah_parts'];
            $lines[] = '';
            $lines[] = '⭐ *Barakah Score: ' . $st['barakah'] . '/100*';
            $lines[] = '   📚 Academic: ' . $parts['academics'] . '% | 📖 Quran: ' . $parts['quran'] . '%';
            $lines[] = '   🛠️ Skills: ' . $parts['vocational'] . '% | 🕌 Arabic: ' . $parts['arabic'] . '%';
            $lines[] = '';
            $lines[] = '— Sent with love from Tahsin Academy 💚';

            $media = array();
            foreach ($tahfizToday as $t) {
                $label = $this->formatTahfizMilestoneLabel($t);
                $audio = $this->absoluteMediaUrl(isset($t->audio_url) ? $t->audio_url : '');
                $video = $this->absoluteMediaUrl(isset($t->video_url) ? $t->video_url : '');
                if ($audio || $video) {
                    $media[] = array(
                        'label' => $label ? $label : $t->surah_name,
                        'audio_url' => $audio,
                        'video_url' => $video,
                        'accuracy' => isset($t->accuracy_score) ? $t->accuracy_score : null,
                    );
                }
            }

            $sealed = $this->sealedDigestLine($tahfizToday, $drills);
            $reports[] = array(
                'student_id' => $st['id'],
                'student_name' => $st['fullname'],
                'teacher_name' => $sealed['teacher'],
                'portion' => $sealed['portion'],
                'parent_contact' => $st['parent_contact'],
                'parent_phones' => !empty($st['parent_phones']) ? $st['parent_phones'] : array(),
                'message' => implode("\n", $lines),
                'drill_count' => count($drills),
                'tahfiz_count' => count($tahfizToday),
                'has_phone' => !empty($st['parent_phones']) || !empty($st['parent_contact']),
                'media' => $media,
            );
        }

        $withTahfiz = 0;
        $withMedia = 0;
        foreach ($reports as $r) {
            if (!empty($r['tahfiz_count'])) {
                $withTahfiz++;
            }
            if (!empty($r['media'])) {
                $withMedia++;
            }
        }

        // Cohort summary for WhatsApp groups (no phone = pick chat/group in WhatsApp)
        $cohortLines = array(
            '📊 *Tahsin Academy — Cohort Digest*',
            'Date: ' . date('l, j F Y'),
            '',
            'Students: ' . count($roster),
            'Drills today: ' . $withDrills,
            'Tahfiz today: ' . $withTahfiz,
            'With audio/video: ' . $withMedia,
            '',
        );
        foreach ($reports as $r) {
            if (empty($r['tahfiz_count']) && empty($r['drill_count'])) {
                continue;
            }
            $cohortLines[] = '• *' . $r['student_name'] . '* — '
                . (int) $r['drill_count'] . ' drill(s), '
                . (int) $r['tahfiz_count'] . ' milestone(s)'
                . (!empty($r['media']) ? ', media attached in individual report' : '');
        }
        $cohortLines[] = '';
        $cohortLines[] = 'Parents: open your child\'s personal WhatsApp for audio links.';
        $cohortLines[] = '— Tahsin Academy 💚';

        return array(
            'total_students' => count($roster),
            'reports_generated' => count($reports),
            'with_parent_contact' => $withPhone,
            'without_parent_contact' => max(0, count($roster) - $withPhone),
            'with_drills' => $withDrills,
            'with_tahfiz' => $withTahfiz,
            'with_media' => $withMedia,
            'awaiting_review' => $awaitingReview,
            'reports' => $reports,
            'cohort_message' => implode("\n", $cohortLines),
        );
    }

    /**
     * Turn relative upload paths into absolute URLs parents can open on their phones.
     * Rewrites stored localhost links to the current host (or PUBLIC_SITE_URL when live).
     */
    public function absoluteMediaUrl($url)
    {
        $url = trim((string) $url);
        if ($url === '') {
            return '';
        }

        $rel = '';
        if (preg_match('#/(uploads/.+)$#i', $url, $m)) {
            $rel = $m[1];
        } elseif (preg_match('#^(uploads/.+)$#i', $url, $m)) {
            $rel = $m[1];
        } elseif (preg_match('#^https?://#i', $url)) {
            // External absolute URL — leave alone unless it is localhost
            if (!preg_match('#^https?://(localhost|127\.0\.0\.1)#i', $url)) {
                return $url;
            }
            return $url;
        } else {
            $rel = ltrim($url, '/');
        }

        if ($rel === '') {
            return $url;
        }

        $base = rtrim(base_url(), '/');
        // When this request is on localhost but a public site is configured, keep local
        // play links on localhost; WhatsApp send path publicizes separately.
        return $base . '/' . ltrim($rel, '/');
    }

    /**
     * After a localhost Save, POST the clip to PUBLIC_SITE_URL so Meta/parents can fetch it.
     *
     * @return array{ok:bool,skipped?:string,error?:string,url?:string}
     */
    public function syncAudioToPublicSite($relativeOrUrl)
    {
        $relativeOrUrl = trim((string) $relativeOrUrl);
        if ($relativeOrUrl === '') {
            return array('ok' => false, 'error' => 'empty path');
        }
        if (!defined('PUBLIC_SITE_URL') || PUBLIC_SITE_URL === '') {
            return array('ok' => true, 'skipped' => 'no PUBLIC_SITE_URL');
        }
        if (!defined('ACADEMY_MEDIA_SYNC_SECRET') || ACADEMY_MEDIA_SYNC_SECRET === '') {
            return array('ok' => true, 'skipped' => 'no sync secret');
        }
        if (!function_exists('curl_init')) {
            return array('ok' => false, 'error' => 'curl missing');
        }

        $publicHost = strtolower((string) parse_url(PUBLIC_SITE_URL, PHP_URL_HOST));
        $currentHost = isset($_SERVER['HTTP_HOST']) ? strtolower((string) $_SERVER['HTTP_HOST']) : '';
        $currentHost = preg_replace('/:\d+$/', '', $currentHost);
        if ($publicHost !== '' && $currentHost !== '' && $currentHost === $publicHost) {
            return array('ok' => true, 'skipped' => 'already on public host');
        }

        $rel = '';
        if (preg_match('#/(uploads/academy_tahfiz/.+)$#i', $relativeOrUrl, $m)) {
            $rel = $m[1];
        } elseif (preg_match('#^(uploads/academy_tahfiz/.+)$#i', $relativeOrUrl, $m)) {
            $rel = $m[1];
        }
        if ($rel === '') {
            return array('ok' => false, 'error' => 'not an academy_tahfiz path');
        }

        $local = FCPATH . str_replace(array('/', '\\'), DIRECTORY_SEPARATOR, $rel);
        if (!is_file($local) || !is_readable($local)) {
            return array('ok' => false, 'error' => 'local file missing');
        }

        $endpoint = rtrim(PUBLIC_SITE_URL, '/') . '/academy_media/receive';
        $cfile = class_exists('CURLFile')
            ? new CURLFile($local, 'application/octet-stream', basename($local))
            : '@' . $local;

        $ch = curl_init($endpoint);
        curl_setopt_array($ch, array(
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CONNECTTIMEOUT => 12,
            CURLOPT_TIMEOUT => 90,
            CURLOPT_HTTPHEADER => array(
                'X-Tahsin-Media-Sync: ' . ACADEMY_MEDIA_SYNC_SECRET,
            ),
            CURLOPT_POSTFIELDS => array(
                'sync_secret' => ACADEMY_MEDIA_SYNC_SECRET,
                'filename' => basename($local),
                'audio' => $cfile,
            ),
        ));
        $body = curl_exec($ch);
        $code = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $err = curl_error($ch);
        curl_close($ch);

        if ($body === false || $err !== '') {
            return array('ok' => false, 'error' => $err !== '' ? $err : 'curl failed');
        }
        $json = json_decode((string) $body, true);
        if ($code >= 200 && $code < 300 && is_array($json) && !empty($json['ok'])) {
            return array(
                'ok' => true,
                'url' => isset($json['url']) ? $json['url'] : null,
            );
        }
        $msg = is_array($json) && !empty($json['error']) ? $json['error'] : ('HTTP ' . $code);
        return array('ok' => false, 'error' => $msg);
    }

    /**
     * Strip Audio/Tarteel telemetry tags from akhlaq_note (DB hygiene).
     * Returns number of rows updated.
     */
    public function cleanAkhlaqTelemetryTags()
    {
        if (!$this->tahfizReady()) {
            return 0;
        }
        $this->db->select('id, akhlaq_note');
        $this->db->from('academy_tahfiz_record');
        $this->db->where('akhlaq_note IS NOT NULL', null, false);
        $this->db->where("akhlaq_note REGEXP 'Audio Attached|Tarteel AI|Live ASR'", null, false);
        $rows = $this->db->get()->result();
        $updated = 0;
        foreach ($rows as $row) {
            $clean = preg_replace('/\s*\[[^\]]*Audio Attached[^\]]*\]/u', '', (string) $row->akhlaq_note);
            $clean = preg_replace('/\s*\[[^\]]*(Tarteel AI|Live ASR)[^\]]*\]/u', '', $clean);
            $clean = trim(preg_replace('/\s{2,}/', ' ', $clean));
            $newVal = ($clean === '') ? null : $clean;
            if ($newVal === $row->akhlaq_note) {
                continue;
            }
            $this->db->where('id', (int) $row->id);
            $this->db->update('academy_tahfiz_record', array('akhlaq_note' => $newVal));
            $updated++;
        }
        return $updated;
    }

    /**
     * Performance hub KPIs for today's drills.
     */
    public function performanceKpis($branch_id)
    {
        $empty = array(
            'today_drills' => 0,
            'unique_students' => 0,
            'avg_spp' => null,
            'avg_pct' => null,
            'best_pillar' => '—',
        );
        if (!$this->drillsReady()) {
            return $empty;
        }
        $today = date('Y-m-d');
        $this->db->from('academy_daily_drill');
        $this->db->where('branch_id', (int) $branch_id);
        $this->db->where('DATE(created_at)', $today);
        $rows = $this->db->get()->result();
        if (empty($rows)) {
            return $empty;
        }
        $students = array();
        $sppSum = 0;
        $sppN = 0;
        $pctSum = 0;
        $pctN = 0;
        $pillarCount = array();
        foreach ($rows as $r) {
            $students[(int) $r->student_id] = true;
            if ($r->spp_metric !== null && $r->spp_metric !== '') {
                $sppSum += (float) $r->spp_metric;
                $sppN++;
            }
            if ($r->total_possible > 0) {
                $pctSum += ($r->score / $r->total_possible) * 100;
                $pctN++;
            }
            $p = $r->pillar ? $r->pillar : 'OTHER';
            if (!isset($pillarCount[$p])) {
                $pillarCount[$p] = 0;
            }
            $pillarCount[$p]++;
        }
        arsort($pillarCount);
        $best = !empty($pillarCount) ? key($pillarCount) : '—';
        $labels = $this->pillars();
        return array(
            'today_drills' => count($rows),
            'unique_students' => count($students),
            'avg_spp' => $sppN ? round($sppSum / $sppN, 1) : null,
            'avg_pct' => $pctN ? (int) round($pctSum / $pctN) : null,
            'best_pillar' => isset($labels[$best]) ? $labels[$best] : $best,
        );
    }

    public function logBroadcastPreview($branch_id, $reports, $channel = 'preview')
    {
        if (!$this->db->table_exists('academy_broadcast_log')) {
            return;
        }
        foreach ($reports as $r) {
            $this->db->insert('academy_broadcast_log', array(
                'branch_id' => (int) $branch_id,
                'student_id' => (int) $r['student_id'],
                'parent_contact' => $r['parent_contact'],
                'channel' => $channel,
                'message' => $r['message'],
                'status' => $channel === 'whatsapp_link' ? 'ready' : 'preview',
            ));
        }
    }

    /**
     * One portion line and the teacher who sealed it, from today's acknowledged rows.
     *
     * @return array{teacher:string,portion:string}
     */
    public function sealedDigestLine($tahfizRows, $drillRows)
    {
        $teacher = 'Teacher';
        $portion = 'Session sealed';
        if (!empty($tahfizRows)) {
            $t = $tahfizRows[0];
            $label = $this->formatTahfizMilestoneLabel($t);
            if (!$label && isset($t->surah_name)) {
                $label = $t->surah_name;
            }
            $cat = '';
            if (!empty($t->recitation_category)) {
                $cats = $this->recitationCategories();
                $ck = strtoupper($t->recitation_category);
                $cat = isset($cats[$ck]) ? $cats[$ck] : $ck;
            }
            $portion = trim(($cat !== '' ? $cat . ' · ' : '') . ($label ? $label : 'Quran'));
            if (!empty($t->instructor_id) && function_exists('get_type_name_by_id')) {
                $name = get_type_name_by_id('staff', $t->instructor_id, 'name');
                if ($name) {
                    $teacher = $name;
                }
            }
        } elseif (!empty($drillRows)) {
            $d = $drillRows[0];
            $n = count($drillRows);
            $pillar = isset($d->pillar) ? $d->pillar : 'Drill';
            $portion = $pillar . ($n > 1 ? ' · ' . $n . ' drills' : '');
            if (!empty($d->evaluator_id) && function_exists('get_type_name_by_id')) {
                $name = get_type_name_by_id('staff', $d->evaluator_id, 'name');
                if ($name) {
                    $teacher = $name;
                }
            }
        }
        return array('teacher' => $teacher, 'portion' => $portion);
    }

    /**
     * Template body params for the Meta utility template.
     * Order: student, teacher, portion, seal. Audio is a later media message.
     */
    /**
     * Send today's sealed digest for one acknowledged teacher.
     * Called when an admin acknowledges, so Broadcast does not need a second click.
     */
    public function dispatchSealedDigests($branchId, $teacherId, $date, $groupId = 0)
    {
        if ($date !== date('Y-m-d')) {
            return 'WhatsApp sends today\'s sealed digest only. This session is ' . $date . '.';
        }
        $this->load->library('whatsapp_cloud');
        if (!$this->whatsapp_cloud->isConfigured()) {
            return 'WhatsApp was not sent: Cloud API is not configured.';
        }

        $wanted = array();
        $groupId = (int) $groupId;
        if ($groupId > 0 && $this->groupsReady()) {
            foreach ($this->groupMemberIds($groupId) as $sid) {
                $wanted[$sid] = true;
            }
        } elseif ($this->db->table_exists('academy_teacher_student')) {
            $rows = $this->db->select('student_id')->get_where('academy_teacher_student', array(
                'branch_id' => (int) $branchId,
                'teacher_id' => (int) $teacherId,
                'session_id' => (int) get_session_id(),
            ))->result();
            foreach ($rows as $row) {
                $wanted[(int) $row->student_id] = true;
            }
        }
        if (empty($wanted)) {
            return 'No parent digest to send for this session.';
        }
        $broadcast = $this->generateDailyBroadcast($branchId);
        $reports = array();
        foreach ((isset($broadcast['reports']) ? $broadcast['reports'] : array()) as $report) {
            $sid = (int) $report['student_id'];
            if (isset($wanted[$sid])) {
                $reports[] = $report;
            }
        }
        if (empty($reports)) {
            return 'No parent digest to send for this session.';
        }
        return $this->deliverCloudDigests($branchId, $reports);
    }

    /**
     * @param array $reports rows from generateDailyBroadcast()
     */
    public function deliverCloudDigests($branchId, $reports)
    {
        $this->load->library('whatsapp_cloud');
        if (!$this->whatsapp_cloud->isConfigured()) {
            return 'WhatsApp Cloud API is not configured.';
        }

        $sent = 0;
        $failed = 0;
        $skipped = 0;
        $mediaSent = 0;
        $mediaFailed = 0;
        $firstError = '';
        $firstMediaError = '';

        foreach ($reports as $r) {
            $phones = array();
            if (!empty($r['parent_phones']) && is_array($r['parent_phones'])) {
                foreach ($r['parent_phones'] as $candidate) {
                    $n = $this->whatsapp_cloud->normalizePhone($candidate);
                    if ($n !== '') {
                        $phones[$n] = true;
                    }
                }
            }
            if (empty($phones)) {
                $n = $this->whatsapp_cloud->normalizePhone(isset($r['parent_contact']) ? $r['parent_contact'] : '');
                if ($n !== '') {
                    $phones[$n] = true;
                }
            }
            if (empty($phones)) {
                $skipped++;
                $this->logBroadcastSend($branchId, $r, 'whatsapp_cloud', 'skipped', null, 'No parent phone');
                continue;
            }

            $params = $this->digestTemplateParams($r);
            $mediaItems = $this->digestMediaPayloads($r, $this->whatsapp_cloud->mediaMaxPerStudent());
            $listenUrl = '';
            $headerMedia = null;
            $clipLocal = null;
            if (!empty($mediaItems[0]['url'])) {
                $clipLocal = $this->whatsapp_cloud->resolveLocalMediaFile($mediaItems[0]['url']);
                $candidate = $this->whatsapp_cloud->publicizeMediaUrl($mediaItems[0]['url']);
                if (preg_match('/\.(wav|webm)$/i', $candidate)) {
                    $mp3 = preg_replace('/\.(wav|webm)$/i', '.mp3', $candidate);
                    if ($this->whatsapp_cloud->isPublicHttpsUrl($mp3) && $this->whatsapp_cloud->urlIsReachable($mp3)) {
                        $candidate = $mp3;
                    }
                }
                if ($this->whatsapp_cloud->isPublicHttpsUrl($candidate) && $this->whatsapp_cloud->urlIsReachable($candidate)) {
                    $listenUrl = $candidate;
                }
                // Native in-chat attachment: DOCUMENT header on tahsin_digest_with_audio
                if ($clipLocal && is_file($clipLocal)) {
                    $hint = preg_match('/\.(mp3|ogg|opus|m4a|aac)$/i', $clipLocal) ? 'audio' : 'document';
                    $up = $this->whatsapp_cloud->uploadMediaFile($clipLocal, $hint);
                    if (!empty($up['ok']) && !empty($up['id'])) {
                        $fname = basename($clipLocal);
                        if (!preg_match('/\.mp3$/i', $fname)) {
                            $fname = preg_replace('/\.[^.]+$/', '', $fname) . '.mp3';
                        }
                        $headerMedia = array(
                            'type' => 'document',
                            'id' => $up['id'],
                            'filename' => $fname,
                        );
                    }
                }
            }

            foreach (array_keys($phones) as $phone) {
                $r['parent_contact'] = $phone;
                $result = null;
                $usedNativeClip = false;

                if ($headerMedia) {
                    $body3 = array(
                        isset($params[0]) ? $params[0] : 'Student',
                        isset($params[1]) ? $params[1] : date('j M Y'),
                        isset($params[2]) ? $params[2] : 'Session sealed',
                    );
                    $result = $this->whatsapp_cloud->sendTemplate(
                        $phone,
                        $body3,
                        $this->whatsapp_cloud->templateWithMediaName(),
                        'en',
                        $headerMedia
                    );
                    if (!empty($result['ok'])) {
                        $usedNativeClip = true;
                    }
                }

                // Fallback: body-only template with public listen URL in {{4}}
                if ($result === null || empty($result['ok'])) {
                    $fallbackParams = $params;
                    if ($listenUrl !== '') {
                        $fallbackParams[3] = $listenUrl;
                    }
                    $result = $this->whatsapp_cloud->sendTemplate($phone, $fallbackParams);
                }

                if (!empty($result['ok'])) {
                    $sent++;
                    $this->logBroadcastSend(
                        $branchId,
                        $r,
                        'whatsapp_cloud',
                        'sent',
                        isset($result['wamid']) ? $result['wamid'] : null,
                        $usedNativeClip ? 'native document clip' : null
                    );
                    if ($usedNativeClip) {
                        $mediaSent++;
                        $this->logBroadcastSend($branchId, $r, 'whatsapp_cloud_media', 'sent', isset($result['wamid']) ? $result['wamid'] : null, 'DOCUMENT header clip');
                    } elseif ($listenUrl !== '') {
                        $mediaSent++;
                        $this->logBroadcastSend($branchId, $r, 'whatsapp_cloud_media', 'sent', null, 'Listen URL in template {{4}}: ' . $listenUrl);
                    } elseif (!empty($mediaItems)) {
                        $mediaFailed++;
                        $merr = 'Clip could not be attached (template tahsin_digest_with_audio may still be PENDING) and no public HTTPS listen URL.';
                        if ($firstMediaError === '') {
                            $firstMediaError = $merr;
                        }
                        $this->logBroadcastSend($branchId, $r, 'whatsapp_cloud_media', 'failed', null, $merr);
                    }
                } else {
                    $failed++;
                    $err = isset($result['error']) ? $result['error'] : 'Send failed';
                    if ($firstError === '') {
                        $firstError = $err;
                    }
                    $this->logBroadcastSend($branchId, $r, 'whatsapp_cloud', 'failed', null, $err);
                    usleep(150000);
                    continue;
                }
                usleep(250000);
            }
        }

        $parts = array();
        $parts[] = $sent . ' WhatsApp digest' . ($sent === 1 ? '' : 's') . ' sent';
        if ($failed) {
            $parts[] = $failed . ' failed';
        }
        if ($skipped) {
            $parts[] = $skipped . ' skipped (no phone)';
        }
        if ($mediaSent || $mediaFailed) {
            $parts[] = $mediaSent . ' clip' . ($mediaSent === 1 ? '' : 's') . ' attached/linked';
            if ($mediaFailed) {
                $parts[] = $mediaFailed . ' clip missing';
            }
        } elseif ($sent && $this->whatsapp_cloud->wantsMediaAfterTemplate()) {
            $parts[] = '0 media links (no clip URLs on reports)';
        }
        $message = implode(' · ', $parts) . '.';
        if ($firstError !== '') {
            $message .= ' ' . $firstError;
        }
        if ($firstMediaError !== '') {
            $message .= ' Media: ' . $firstMediaError;
        }
        return $message;
    }

    public function digestTemplateParams($report)
    {
        // Meta template labels (approved): Student, Date, Recitation, Media/URL
        $name = isset($report['student_name']) && $report['student_name'] !== '' ? $report['student_name'] : 'Student';
        $teacher = isset($report['teacher_name']) && $report['teacher_name'] !== '' ? $report['teacher_name'] : 'Teacher';
        $portion = isset($report['portion']) && $report['portion'] !== '' ? $report['portion'] : 'Session sealed';
        $date = date('j M Y');
        $mediaLine = 'With ' . $teacher;
        return array($name, $date, $portion, $mediaLine);
    }

    /**
     * Flatten media items into sendable list: type + url + caption.
     */
    public function digestMediaPayloads($report, $limit = 3)
    {
        $out = array();
        $limit = max(1, (int) $limit);
        if (empty($report['media']) || !is_array($report['media'])) {
            return $out;
        }
        foreach ($report['media'] as $m) {
            $label = isset($m['label']) ? $m['label'] : 'Recitation';
            if (!empty($m['audio_url'])) {
                $out[] = array(
                    'type' => 'audio',
                    'url' => $m['audio_url'],
                    'caption' => '🎙️ ' . $label,
                );
            }
            if (!empty($m['video_url'])) {
                $out[] = array(
                    'type' => 'video',
                    'url' => $m['video_url'],
                    'caption' => '🎥 ' . $label,
                );
            }
            if (count($out) >= $limit) {
                break;
            }
        }
        if (count($out) > $limit) {
            $out = array_slice($out, 0, $limit);
        }
        return $out;
    }

    public function logBroadcastSend($branch_id, $report, $channel, $status, $metaMessageId = null, $errorMessage = null)
    {
        if (!$this->db->table_exists('academy_broadcast_log')) {
            return;
        }
        $row = array(
            'branch_id' => (int) $branch_id,
            'student_id' => (int) $report['student_id'],
            'parent_contact' => isset($report['parent_contact']) ? $report['parent_contact'] : null,
            'channel' => substr((string) $channel, 0, 40),
            'message' => isset($report['message']) ? $report['message'] : '',
            'status' => substr((string) $status, 0, 20),
        );
        if ($this->db->field_exists('meta_message_id', 'academy_broadcast_log')) {
            $row['meta_message_id'] = $metaMessageId ? substr((string) $metaMessageId, 0, 120) : null;
        }
        if ($this->db->field_exists('error_message', 'academy_broadcast_log')) {
            $row['error_message'] = $errorMessage ? substr((string) $errorMessage, 0, 2000) : null;
        }
        $this->db->insert('academy_broadcast_log', $row);
    }

    /**
     * Convert any audio file (.wav, .webm, .ogg) to standard WhatsApp/browser-ready .mp3 via ffmpeg.
     *
     * @param string $filePath Absolute path to the source audio file
     * @param bool $deleteSource Whether to delete the original source file after successful conversion
     * @return string Final audio file path (.mp3 if converted, or original if failed)
     */
    public function convertToMp3($filePath, $deleteSource = false)
    {
        if (!is_file($filePath) || !is_readable($filePath)) {
            return $filePath;
        }

        $ext = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
        if ($ext === 'mp3') {
            return $filePath;
        }

        $dir = dirname($filePath);
        $filename = pathinfo($filePath, PATHINFO_FILENAME);
        $targetMp3 = $dir . DIRECTORY_SEPARATOR . $filename . '.mp3';

        // Check if ffmpeg is available
        $ffmpegCmd = 'ffmpeg';
        if (DIRECTORY_SEPARATOR === '\\' && is_file('C:\\ffmpeg\\bin\\ffmpeg.exe')) {
            $ffmpegCmd = 'C:\\ffmpeg\\bin\\ffmpeg.exe';
        }

        $cmd = escapeshellcmd($ffmpegCmd) . ' -y -i ' . escapeshellarg($filePath) . ' -vn -ar 44100 -ac 2 -b:a 128k ' . escapeshellarg($targetMp3) . ' 2>&1';
        $output = array();
        $ret = 0;
        @exec($cmd, $output, $ret);

        if ($ret === 0 && is_file($targetMp3) && filesize($targetMp3) > 100) {
            if ($deleteSource && $targetMp3 !== $filePath) {
                @unlink($filePath);
            }
            return $targetMp3;
        }

        return $filePath;
    }

    public function reviewReady()
    {
        $ready = $this->db->table_exists('academy_teacher_student')
            && $this->db->table_exists('academy_class_session')
            && $this->db->table_exists('academy_notice');
        if ($ready) {
            $this->ensureSessionCategory();
        }
        return $ready;
    }

    /**
     * Sessions are unique per teacher, day, and recitation category.
     */
    protected function ensureSessionCategory()
    {
        static $done = false;
        if ($done || !$this->db->table_exists('academy_class_session')) {
            return;
        }
        $done = true;
        if (!$this->db->field_exists('recitation_category', 'academy_class_session')) {
            $this->db->query("ALTER TABLE `academy_class_session` ADD COLUMN `recitation_category` VARCHAR(40) NOT NULL DEFAULT '' AFTER `session_date`");
        }
        if (!$this->db->field_exists('milestone_id', 'academy_class_session')) {
            $this->db->query("ALTER TABLE `academy_class_session` ADD COLUMN `milestone_id` INT(11) NOT NULL DEFAULT 0 AFTER `recitation_category`");
        }
        $schema = $this->db->database;
        $old = $this->db->query(
            "SELECT COUNT(*) AS c FROM information_schema.STATISTICS WHERE TABLE_SCHEMA = " . $this->db->escape($schema) . " AND TABLE_NAME = 'academy_class_session' AND INDEX_NAME = 'uq_acs_teacher_day'"
        )->row();
        if ($old && (int) $old->c > 0) {
            $this->db->query('ALTER TABLE `academy_class_session` DROP INDEX `uq_acs_teacher_day`');
        }
        $mid = $this->db->query(
            "SELECT COUNT(*) AS c FROM information_schema.STATISTICS WHERE TABLE_SCHEMA = " . $this->db->escape($schema) . " AND TABLE_NAME = 'academy_class_session' AND INDEX_NAME = 'uq_acs_teacher_day_cat'"
        )->row();
        if ($mid && (int) $mid->c > 0) {
            $this->db->query('ALTER TABLE `academy_class_session` DROP INDEX `uq_acs_teacher_day_cat`');
        }
        $new = $this->db->query(
            "SELECT COUNT(*) AS c FROM information_schema.STATISTICS WHERE TABLE_SCHEMA = " . $this->db->escape($schema) . " AND TABLE_NAME = 'academy_class_session' AND INDEX_NAME = 'uq_acs_milestone'"
        )->row();
        if (!$new || (int) $new->c === 0) {
            $this->db->query('ALTER TABLE `academy_class_session` ADD UNIQUE KEY `uq_acs_milestone` (`branch_id`, `teacher_id`, `session_date`, `recitation_category`, `milestone_id`)');
        }
        $this->backfillSessionCategories();
    }

    /**
     * Give an existing day-session the category it was recorded under, without colliding.
     */
    protected function backfillSessionCategories()
    {
        if (!$this->tahfizReady() || !$this->db->field_exists('recitation_category', 'academy_tahfiz_record')) {
            return;
        }
        $rows = $this->db->query(
            "SELECT cs.id, cs.branch_id, cs.teacher_id, cs.session_date,
                (SELECT t.recitation_category FROM academy_tahfiz_record t
                 WHERE t.branch_id = cs.branch_id AND t.instructor_id = cs.teacher_id
                   AND DATE(t.completed_at) = cs.session_date
                   AND t.recitation_category IS NOT NULL AND t.recitation_category <> ''
                 ORDER BY t.id ASC LIMIT 1) AS cat
             FROM academy_class_session cs
             WHERE cs.recitation_category = ''"
        )->result();
        foreach ($rows as $row) {
            $cat = strtoupper(trim((string) $row->cat));
            if ($cat === '') {
                continue;
            }
            $taken = $this->db->get_where('academy_class_session', array(
                'branch_id' => (int) $row->branch_id,
                'teacher_id' => (int) $row->teacher_id,
                'session_date' => $row->session_date,
                'recitation_category' => $cat,
            ))->row();
            if ($taken && (int) $taken->id !== (int) $row->id) {
                continue;
            }
            $firstId = (int) $this->db->query(
                "SELECT id FROM academy_tahfiz_record
                 WHERE branch_id = " . (int) $row->branch_id . " AND instructor_id = " . (int) $row->teacher_id . "
                   AND DATE(completed_at) = " . $this->db->escape($row->session_date) . "
                   AND recitation_category = " . $this->db->escape($cat) . "
                 ORDER BY id ASC LIMIT 1"
            )->row()->id;
            $this->db->where('id', (int) $row->id)->update('academy_class_session', array(
                'recitation_category' => $cat,
                'milestone_id' => $firstId,
            ));
        }
        if (!$this->db->field_exists('milestone_id', 'academy_class_session')) {
            return;
        }
        $open = $this->db->query(
            "SELECT t.id, t.branch_id, t.instructor_id, t.student_id, t.recitation_category, DATE(t.completed_at) AS session_date
             FROM academy_tahfiz_record t
             LEFT JOIN academy_class_session cs ON cs.milestone_id = t.id
             WHERE cs.id IS NULL AND t.recitation_category IS NOT NULL AND t.recitation_category <> ''
               AND DATE(t.completed_at) = CURDATE()
             ORDER BY t.id ASC"
        )->result();
        foreach ($open as $milestone) {
            $this->touchTeacherSession(
                (int) $milestone->branch_id,
                (int) $milestone->student_id,
                $milestone->session_date,
                (int) $milestone->instructor_id,
                $milestone->recitation_category,
                (int) $milestone->id
            );
        }
    }

    public function studentAssignedToTeacher($studentId, $teacherId, $branchId = null)
    {
        if (!$this->db->table_exists('academy_teacher_student')) {
            return true;
        }
        $this->db->from('academy_teacher_student');
        $this->db->where('student_id', (int) $studentId);
        $this->db->where('teacher_id', (int) $teacherId);
        $this->db->where('session_id', (int) get_session_id());
        if ($branchId) {
            $this->db->where('branch_id', (int) $branchId);
        }
        return $this->db->count_all_results() > 0;
    }

    public function listTeachers($branchId)
    {
        $this->db->select('s.id, s.name');
        $this->db->from('staff s');
        $this->db->join('login_credential lc', 'lc.user_id = s.id AND lc.role = 3 AND lc.active = 1', 'inner');
        if ($this->db->field_exists('branch_id', 'staff')) {
            $this->db->where('s.branch_id', (int) $branchId);
        }
        $this->db->order_by('s.name', 'ASC');
        return $this->db->get()->result();
    }

    public function assignmentsForTeacher($branchId, $teacherId)
    {
        if (!$this->reviewReady()) {
            return array();
        }
        $this->db->select('ats.student_id, TRIM(CONCAT_WS(" ", s.first_name, NULLIF(s.other_name,""), s.last_name)) AS fullname, s.register_no');
        $this->db->from('academy_teacher_student ats');
        $this->db->join('student s', 's.id = ats.student_id', 'left');
        $this->db->where('ats.branch_id', (int) $branchId);
        $this->db->where('ats.session_id', (int) get_session_id());
        $this->db->where('ats.teacher_id', (int) $teacherId);
        $this->db->order_by('s.first_name', 'ASC');
        return $this->db->get()->result();
    }

    public function allAssignments($branchId)
    {
        if (!$this->reviewReady()) {
            return array();
        }
        $this->db->select('ats.*, st.name AS teacher_name, TRIM(CONCAT_WS(" ", s.first_name, NULLIF(s.other_name,""), s.last_name)) AS student_name, s.register_no');
        $this->db->from('academy_teacher_student ats');
        $this->db->join('staff st', 'st.id = ats.teacher_id', 'left');
        $this->db->join('student s', 's.id = ats.student_id', 'left');
        $this->db->where('ats.branch_id', (int) $branchId);
        $this->db->where('ats.session_id', (int) get_session_id());
        $this->db->order_by('st.name', 'ASC');
        $this->db->order_by('s.first_name', 'ASC');
        return $this->db->get()->result();
    }

    public function saveTeacherAssignments($branchId, $teacherId, $studentIds, $assignedBy)
    {
        if (!$this->reviewReady()) {
            return false;
        }
        $teacherId = (int) $teacherId;
        $sessionId = (int) get_session_id();
        $branchId = (int) $branchId;
        $clean = array();
        foreach ((array) $studentIds as $sid) {
            $sid = (int) $sid;
            if ($sid > 0) {
                $clean[$sid] = $sid;
            }
        }

        $this->db->where(array(
            'branch_id' => $branchId,
            'session_id' => $sessionId,
            'teacher_id' => $teacherId,
        ))->delete('academy_teacher_student');

        if (!empty($clean)) {
            foreach ($clean as $sid) {
                $this->db->insert('academy_teacher_student', array(
                    'branch_id' => $branchId,
                    'session_id' => $sessionId,
                    'teacher_id' => $teacherId,
                    'student_id' => $sid,
                    'assigned_by' => (int) $assignedBy,
                ));
            }
        }
        return true;
    }

    public function groupsReady()
    {
        return $this->db->table_exists('academy_teacher_group')
            && $this->db->table_exists('academy_teacher_group_member');
    }

    public function teacherGroups($branchId, $teacherId)
    {
        if (!$this->groupsReady()) {
            return array();
        }
        $rows = $this->db->order_by('sort_order', 'ASC')->order_by('name', 'ASC')
            ->get_where('academy_teacher_group', array(
                'branch_id' => (int) $branchId,
                'session_id' => (int) get_session_id(),
                'teacher_id' => (int) $teacherId,
            ))->result();
        foreach ($rows as $g) {
            $g->members = array();
            $mem = $this->db->select('m.student_id, TRIM(CONCAT_WS(" ", s.first_name, NULLIF(s.other_name,""), s.last_name)) AS student_name')
                ->from('academy_teacher_group_member m')
                ->join('student s', 's.id = m.student_id', 'left')
                ->where('m.group_id', (int) $g->id)
                ->order_by('s.first_name', 'ASC')
                ->get()->result();
            foreach ($mem as $m) {
                $g->members[] = array(
                    'student_id' => (int) $m->student_id,
                    'student_name' => $m->student_name,
                );
            }
        }
        return $rows;
    }

    /**
     * First group for this student (convenience). Prefer studentGroupIds for multi-group.
     * @return int group id or 0
     */
    public function studentGroupId($teacherId, $studentId, $branchId = null)
    {
        $ids = $this->studentGroupIds($teacherId, $studentId, $branchId);
        return !empty($ids) ? (int) $ids[0] : 0;
    }

    /**
     * All facilitator groups containing this student (e.g. Morning + Night).
     * @return int[]
     */
    public function studentGroupIds($teacherId, $studentId, $branchId = null)
    {
        if (!$this->groupsReady()) {
            return array();
        }
        $branchId = (int) ($branchId ? $branchId : (function_exists('get_loggedin_branch_id') ? get_loggedin_branch_id() : 1));
        $rows = $this->db->select('g.id')
            ->from('academy_teacher_group_member m')
            ->join('academy_teacher_group g', 'g.id = m.group_id', 'inner')
            ->where('m.student_id', (int) $studentId)
            ->where('g.teacher_id', (int) $teacherId)
            ->where('g.branch_id', $branchId)
            ->where('g.session_id', (int) get_session_id())
            ->order_by('g.sort_order', 'ASC')
            ->order_by('g.name', 'ASC')
            ->get()->result();
        $ids = array();
        foreach ($rows as $row) {
            $ids[] = (int) $row->id;
        }
        return $ids;
    }

    public function groupMemberIds($groupId)
    {
        if (!$this->groupsReady() || (int) $groupId < 1) {
            return array();
        }
        $ids = array();
        foreach ($this->db->select('student_id')->get_where('academy_teacher_group_member', array('group_id' => (int) $groupId))->result() as $r) {
            $ids[] = (int) $r->student_id;
        }
        return $ids;
    }

    public function createTeacherGroup($branchId, $teacherId, $name)
    {
        if (!$this->groupsReady()) {
            return array('ok' => false, 'error' => 'Run academy_teacher_groups.sql first.');
        }
        $name = trim(mb_substr((string) $name, 0, 80));
        if ($name === '') {
            return array('ok' => false, 'error' => 'Group name required.');
        }
        $dup = $this->db->get_where('academy_teacher_group', array(
            'branch_id' => (int) $branchId,
            'session_id' => (int) get_session_id(),
            'teacher_id' => (int) $teacherId,
            'name' => $name,
        ))->row();
        if ($dup) {
            return array('ok' => false, 'error' => 'That group name already exists.');
        }
        $this->db->insert('academy_teacher_group', array(
            'branch_id' => (int) $branchId,
            'session_id' => (int) get_session_id(),
            'teacher_id' => (int) $teacherId,
            'name' => $name,
            'sort_order' => 0,
        ));
        return array('ok' => true, 'id' => (int) $this->db->insert_id());
    }

    public function deleteTeacherGroup($groupId, $teacherId)
    {
        if (!$this->groupsReady()) {
            return array('ok' => false, 'error' => 'Groups not ready.');
        }
        $g = $this->db->get_where('academy_teacher_group', array(
            'id' => (int) $groupId,
            'teacher_id' => (int) $teacherId,
        ))->row();
        if (!$g) {
            return array('ok' => false, 'error' => 'Group not found.');
        }
        $this->db->where('group_id', (int) $groupId)->delete('academy_teacher_group_member');
        $this->db->where('id', (int) $groupId)->delete('academy_teacher_group');
        return array('ok' => true);
    }

    public function saveTeacherGroupMembers($groupId, $teacherId, $branchId, $studentIds)
    {
        if (!$this->groupsReady()) {
            return array('ok' => false, 'error' => 'Run academy_teacher_groups.sql first.');
        }
        $g = $this->db->get_where('academy_teacher_group', array(
            'id' => (int) $groupId,
            'teacher_id' => (int) $teacherId,
            'branch_id' => (int) $branchId,
            'session_id' => (int) get_session_id(),
        ))->row();
        if (!$g) {
            return array('ok' => false, 'error' => 'Group not found.');
        }
        $assigned = array();
        foreach ($this->db->select('student_id')->get_where('academy_teacher_student', array(
            'branch_id' => (int) $branchId,
            'session_id' => (int) get_session_id(),
            'teacher_id' => (int) $teacherId,
        ))->result() as $r) {
            $assigned[(int) $r->student_id] = true;
        }
        $clean = array();
        foreach ((array) $studentIds as $sid) {
            $sid = (int) $sid;
            if ($sid > 0 && isset($assigned[$sid])) {
                $clean[$sid] = $sid;
            }
        }

        // Multi-group allowed: only rewrite this group's roster; leave other groups alone.
        $this->db->where('group_id', (int) $groupId)->delete('academy_teacher_group_member');
        foreach ($clean as $sid) {
            $this->db->insert('academy_teacher_group_member', array(
                'group_id' => (int) $groupId,
                'student_id' => $sid,
            ));
        }
        $this->refreshOpenGroupSessions((int) $branchId, (int) $teacherId, (int) $groupId);
        return array('ok' => true, 'count' => count($clean));
    }

    /**
     * Recalculate recorded/total on open sessions after group membership changes.
     * May auto-submit to director if the group is now complete.
     */
    public function refreshOpenGroupSessions($branchId, $teacherId, $groupId, $date = null)
    {
        if (!$this->reviewReady() || !$this->db->field_exists('group_id', 'academy_class_session')) {
            return;
        }
        $date = $date ? $date : date('Y-m-d');
        $ids = $this->groupMemberIds($groupId);
        $open = array('recording', 'director_rejected', 'admin_rejected');
        $rows = $this->db->get_where('academy_class_session', array(
            'branch_id' => (int) $branchId,
            'teacher_id' => (int) $teacherId,
            'group_id' => (int) $groupId,
            'session_date' => $date,
        ))->result();
        foreach ($rows as $row) {
            if (!in_array($row->status, $open, true)) {
                continue;
            }
            $cat = isset($row->recitation_category) ? $row->recitation_category : '';
            $recordedIds = $this->recordedStudentIds($branchId, $ids, $date, $teacherId, $cat);
            $recorded = count($recordedIds);
            $total = count($ids);
            $status = $row->status;
            $submit = ($total > 0 && $recorded >= $total);
            if ($submit) {
                $status = 'pending_director';
            }
            $payload = array(
                'student_total' => $total,
                'recorded_count' => $recorded,
                'status' => $status,
            );
            if ($submit) {
                $payload['submitted_at'] = date('Y-m-d H:i:s');
            }
            $this->db->where('id', (int) $row->id)->update('academy_class_session', $payload);
            if ($submit && $row->status !== 'pending_director') {
                $gRow = $this->db->get_where('academy_teacher_group', array('id' => (int) $groupId))->row();
                $gName = $gRow ? $gRow->name : 'group';
                $teacherName = get_type_name_by_id('staff', $teacherId, 'name');
                $body = $teacherName . ' finished ' . $gName . ' on ' . $date . ' (' . $recorded . '/' . $total . ' students).';
                $this->notifyRoles(array(1, 9), $branchId, 'Academy session ready for review', $body, 'academy_review');
                $this->pushNotice($teacherId, $branchId, 'Session sent to the director', $body, 'academy_review');
            }
        }
    }

    /**
     * After a teacher logs a drill or tahfiz row, advance that category's class session
     * for every facilitator group the student belongs to (Morning / Afternoon / Night, etc.).
     *
     * @return string|null status sentence for the flash message
     */
    public function touchTeacherSession($branchId, $studentId, $date = null, $teacherId = null, $category = null, $milestoneId = 0)
    {
        if (!$this->reviewReady()) {
            return null;
        }
        $branchId = (int) $branchId;
        $studentId = (int) $studentId;
        $date = $date ? $date : date('Y-m-d');
        $sessionId = (int) get_session_id();
        $teacherId = (int) ($teacherId ? $teacherId : (function_exists('get_loggedin_user_id') ? get_loggedin_user_id() : 0));
        if ($teacherId < 1 || !$this->studentAssignedToTeacher($studentId, $teacherId, $branchId)) {
            return null;
        }

        $groupIds = $this->studentGroupIds($teacherId, $studentId, $branchId);
        $hasGroups = $this->groupsReady()
            && $this->db->where(array(
                'branch_id' => $branchId,
                'session_id' => $sessionId,
                'teacher_id' => $teacherId,
            ))->count_all_results('academy_teacher_group') > 0;

        if ($hasGroups && empty($groupIds)) {
            return 'Put this student in a facilitator group first (Academy → My Groups), then record again.';
        }
        if (empty($groupIds)) {
            $groupIds = array(0); // legacy whole-roster session
        }

        $notes = array();
        foreach ($groupIds as $groupId) {
            $msg = $this->touchTeacherSessionForGroup($branchId, $studentId, $date, $teacherId, $category, $milestoneId, (int) $groupId);
            if ($msg !== null && $msg !== '') {
                $notes[$msg] = true;
            }
        }
        return !empty($notes) ? implode(' ', array_keys($notes)) : null;
    }

    /**
     * Advance one group (or group_id=0 whole roster) session for this save.
     */
    protected function touchTeacherSessionForGroup($branchId, $studentId, $date, $teacherId, $category, $milestoneId, $groupId)
    {
        $sessionId = (int) get_session_id();
        $ids = array();
        $groupLabel = '';
        if ($groupId > 0) {
            $ids = $this->groupMemberIds($groupId);
            $gRow = $this->db->get_where('academy_teacher_group', array('id' => $groupId))->row();
            $groupLabel = $gRow ? $gRow->name : ('Group #' . $groupId);
        } else {
            foreach ($this->db->select('student_id')->get_where('academy_teacher_student', array(
                'branch_id' => $branchId,
                'session_id' => $sessionId,
                'teacher_id' => $teacherId,
            ))->result() as $a) {
                $ids[] = (int) $a->student_id;
            }
        }

        $cats = $this->recitationCategories();
        $category = strtoupper(trim((string) $category));
        if ($category !== '' && !isset($cats[$category])) {
            $category = '';
        }
        $categoryLabel = isset($cats[$category]) ? $cats[$category] : 'This session';
        if ($groupLabel !== '') {
            $categoryLabel .= ' · ' . $groupLabel;
        }

        $total = count($ids);
        $recordedIds = $this->recordedStudentIds($branchId, $ids, $date, $teacherId, $category);
        $recorded = count($recordedIds);

        $milestoneId = (int) $milestoneId;
        $where = array(
            'branch_id' => $branchId,
            'teacher_id' => $teacherId,
            'session_date' => $date,
        );
        if ($this->db->field_exists('group_id', 'academy_class_session')) {
            $where['group_id'] = $groupId;
        }
        if ($this->db->field_exists('recitation_category', 'academy_class_session')) {
            $where['recitation_category'] = $category;
        }
        if ($this->db->field_exists('milestone_id', 'academy_class_session')) {
            $where['milestone_id'] = $milestoneId;
        }
        $row = $this->db->get_where('academy_class_session', $where)->row();

        if ($row && !in_array($row->status, array('recording', 'director_rejected', 'admin_rejected'), true)) {
            $closed = str_replace('_', ' ', $row->status);
            return $categoryLabel . ' is already ' . $closed . '.';
        }

        $status = $row ? $row->status : 'recording';
        $open = array('recording', 'director_rejected', 'admin_rejected');
        $submit = ($total > 0 && $recorded >= $total && in_array($status, $open, true));
        if ($submit) {
            $status = 'pending_director';
        } elseif (!$row) {
            $status = 'recording';
        }

        $payload = array(
            'student_total' => $total,
            'recorded_count' => $recorded,
            'status' => $status,
            'academic_session_id' => $sessionId,
        );
        if ($this->db->field_exists('group_id', 'academy_class_session')) {
            $payload['group_id'] = $groupId;
        }
        if ($this->db->field_exists('recitation_category', 'academy_class_session')) {
            $payload['recitation_category'] = $category;
        }
        if ($this->db->field_exists('milestone_id', 'academy_class_session')) {
            $payload['milestone_id'] = $milestoneId;
        }
        if ($submit) {
            $payload['submitted_at'] = date('Y-m-d H:i:s');
            $payload['director_user_id'] = null;
            $payload['director_note'] = null;
            $payload['director_at'] = null;
            $payload['admin_user_id'] = null;
            $payload['admin_note'] = null;
            $payload['admin_at'] = null;
        }

        if ($row) {
            $this->db->where('id', (int) $row->id)->update('academy_class_session', $payload);
        } else {
            $payload['branch_id'] = $branchId;
            $payload['teacher_id'] = $teacherId;
            $payload['session_date'] = $date;
            $this->db->insert('academy_class_session', $payload);
        }

        $priorNote = '';
        if ($row && in_array($row->status, array('director_rejected', 'admin_rejected'), true)) {
            $who = $row->status === 'director_rejected' ? 'Director' : 'Admin';
            $note = $row->status === 'director_rejected' ? $row->director_note : $row->admin_note;
            if ($note) {
                $priorNote = ' ' . $who . ': ' . $note;
            }
        }

        if ($submit) {
            $teacherName = get_type_name_by_id('staff', $teacherId, 'name');
            $title = 'Academy session ready for review';
            $body = $teacherName . ' finished ' . $categoryLabel . ' on ' . $date . ' (' . $recorded . '/' . $total . ' students).';
            $this->notifyRoles(array(1, 9), $branchId, $title, $body, 'academy_review');
            $this->pushNotice($teacherId, $branchId, 'Session sent to the director', $body, 'academy_review');
            return $categoryLabel . ' sent to the director.' . $priorNote;
        }

        $missing = array();
        foreach ($ids as $sid) {
            if (!isset($recordedIds[(int) $sid])) {
                $missing[] = (int) $sid;
            }
        }
        $missingLabel = $this->missingStudentLabel($missing);
        return 'Recorded ' . $recorded . ' of ' . $total . ' in ' . $categoryLabel . '.' . $missingLabel . $priorNote;
    }

    public function decideSession($id, $branchId, $actorId, $step, $approve, $note)
    {
        if (!$this->reviewReady()) {
            return 'Run academy_session_review.sql first.';
        }
        $row = $this->db->get_where('academy_class_session', array(
            'id' => (int) $id,
            'branch_id' => (int) $branchId,
        ))->row();
        if (!$row) {
            return 'Session not found.';
        }
        $note = mb_substr(trim((string) $note), 0, 500);
        $teacherName = get_type_name_by_id('staff', $row->teacher_id, 'name');
        $when = $row->session_date;

        if ($step === 'director') {
            if ($row->status !== 'pending_director') {
                return 'This session is not waiting for the director.';
            }
            if ($approve) {
                $this->db->where('id', (int) $row->id)->update('academy_class_session', array(
                    'status' => 'pending_admin',
                    'director_user_id' => (int) $actorId,
                    'director_note' => $note !== '' ? $note : null,
                    'director_at' => date('Y-m-d H:i:s'),
                ));
                $this->pushNotice((int) $row->teacher_id, $branchId, 'Director approved your session', $teacherName . ' · ' . $when . ' moved to admin.', 'academy_review');
                $this->notifyRoles(array(1, 2), $branchId, 'Academy session needs acknowledgement', $teacherName . ' · ' . $when . ' was approved by the director.', 'academy_review');
                return null;
            }
            $this->db->where('id', (int) $row->id)->update('academy_class_session', array(
                'status' => 'director_rejected',
                'director_user_id' => (int) $actorId,
                'director_note' => $note !== '' ? $note : null,
                'director_at' => date('Y-m-d H:i:s'),
            ));
            $this->pushNotice((int) $row->teacher_id, $branchId, 'Director rejected your session', ($note !== '' ? $note : 'Please correct and record again.') . ' · ' . $when, 'academy_review');
            return null;
        }

        if ($step === 'admin') {
            if ($row->status !== 'pending_admin') {
                return 'This session is not waiting for the admin.';
            }
            if ($approve) {
                $this->db->where('id', (int) $row->id)->update('academy_class_session', array(
                    'status' => 'acknowledged',
                    'admin_user_id' => (int) $actorId,
                    'admin_note' => $note !== '' ? $note : null,
                    'admin_at' => date('Y-m-d H:i:s'),
                ));
                $this->notifyRoles(array(1, 9), $branchId, 'Admin acknowledged an academy session', $teacherName . ' · ' . $when . ' is live for parents. The WhatsApp digest is sending.', 'academy_review');
                $this->pushNotice((int) $row->teacher_id, $branchId, 'Admin acknowledged your session', $when . ' is live for parents. The WhatsApp digest is sending.', 'academy_review');
                $this->digestNotices[] = $this->dispatchSealedDigests(
                    $branchId,
                    (int) $row->teacher_id,
                    $when,
                    $this->db->field_exists('group_id', 'academy_class_session') ? (int) $row->group_id : 0
                );
                return null;
            }
            $this->db->where('id', (int) $row->id)->update('academy_class_session', array(
                'status' => 'admin_rejected',
                'admin_user_id' => (int) $actorId,
                'admin_note' => $note !== '' ? $note : null,
                'admin_at' => date('Y-m-d H:i:s'),
            ));
            $msg = ($note !== '' ? $note : 'Sent back for correction.') . ' · ' . $when;
            $this->notifyRoles(array(1, 9), $branchId, 'Admin rejected an academy session', $teacherName . ' · ' . $msg, 'academy_review');
            $this->pushNotice((int) $row->teacher_id, $branchId, 'Admin rejected your session', $msg, 'academy_review');
            return null;
        }

        return 'Unknown review step.';
    }

    public function sessionsForViewer($branchId, $viewerId)
    {
        if (!$this->reviewReady()) {
            return array();
        }
        $this->db->select('cs.*, st.name AS teacher_name' . ($this->groupsReady() ? ', tg.name AS group_name' : ', NULL AS group_name'));
        $this->db->from('academy_class_session cs');
        $this->db->join('staff st', 'st.id = cs.teacher_id', 'left');
        if ($this->groupsReady() && $this->db->field_exists('group_id', 'academy_class_session')) {
            $this->db->join('academy_teacher_group tg', 'tg.id = cs.group_id', 'left');
        }
        $this->db->where('cs.branch_id', (int) $branchId);
        if (function_exists('is_teacher_loggedin') && is_teacher_loggedin()) {
            $this->db->where('cs.teacher_id', (int) $viewerId);
        }
        $this->db->order_by('cs.session_date', 'DESC');
        $this->db->order_by('cs.id', 'DESC');
        $this->db->limit(40);
        return $this->db->get()->result();
    }

    /**
     * Teacher ids whose session for this date is acknowledged and who teach this student.
     */
    public function acknowledgedTeacherIds($branchId, $studentId, $date)
    {
        if (!$this->db->table_exists('academy_class_session') || !$this->db->table_exists('academy_teacher_student')) {
            return array();
        }
        $rows = $this->db->select('ats.teacher_id')
            ->from('academy_teacher_student ats')
            ->join('academy_class_session cs', 'cs.teacher_id = ats.teacher_id AND cs.branch_id = ats.branch_id AND cs.session_date = ' . $this->db->escape($date) . ' AND cs.status = "acknowledged"', 'inner')
            ->where('ats.branch_id', (int) $branchId)
            ->where('ats.session_id', (int) get_session_id())
            ->where('ats.student_id', (int) $studentId)
            ->get()->result();
        $ids = array();
        foreach ($rows as $r) {
            $ids[] = (int) $r->teacher_id;
        }
        return $ids;
    }

    public function studentDayAcknowledged($branchId, $studentId, $date)
    {
        if (!$this->db->table_exists('academy_class_session')) {
            return true;
        }
        return count($this->acknowledgedTeacherIds($branchId, $studentId, $date)) > 0;
    }

    /**
     * Parent/student dashboard: latest session status, detail only after acknowledgement.
     */
    public function portalProgress($studentId)
    {
        $empty = array(
            'ready' => false,
            'teacher' => '',
            'date' => '',
            'status' => '',
            'label' => 'No academy session yet',
            'teachers' => array(),
            'drills' => array(),
            'tahfiz' => array(),
        );
        if (!$this->reviewReady() || (int) $studentId < 1) {
            return $empty;
        }
        $assigns = $this->db->select('ats.teacher_id, st.name AS teacher_name')
            ->from('academy_teacher_student ats')
            ->join('staff st', 'st.id = ats.teacher_id', 'left')
            ->where('ats.student_id', (int) $studentId)
            ->where('ats.session_id', (int) get_session_id())
            ->order_by('st.name', 'ASC')
            ->get()->result();
        if (empty($assigns)) {
            $empty['label'] = 'Not assigned to a teacher yet';
            return $empty;
        }
        $labels = array(
            'recording' => 'Still recording',
            'pending_director' => 'With director',
            'director_rejected' => 'Director sent it back',
            'pending_admin' => 'With admin',
            'admin_rejected' => 'Admin sent it back',
            'acknowledged' => 'Acknowledged',
        );
        $out = $empty;
        $out['ready'] = true;
        $out['teachers'] = array();
        $names = array();
        $ackIds = array();
        $ackDate = null;
        foreach ($assigns as $assign) {
            $names[] = $assign->teacher_name;
            $session = $this->db->where('teacher_id', (int) $assign->teacher_id)
                ->order_by('session_date', 'DESC')
                ->limit(1)
                ->get('academy_class_session')->row();
            $status = $session ? $session->status : '';
            $out['teachers'][] = array(
                'id' => (int) $assign->teacher_id,
                'name' => $assign->teacher_name,
                'date' => $session ? $session->session_date : '',
                'status' => $status,
                'label' => $session ? (isset($labels[$status]) ? $labels[$status] : $status) : 'No session yet',
                'portion' => '',
                'category' => '',
                'audio_url' => '',
            );
            if ($session && $status === 'acknowledged') {
                $ackIds[] = (int) $assign->teacher_id;
                $ackDate = $session->session_date;
                $out['status'] = 'acknowledged';
                $out['date'] = $session->session_date;
            } elseif ($out['status'] === '' && $session) {
                $out['status'] = $status;
                $out['date'] = $session->session_date;
            }
        }
        $out['teacher'] = implode(', ', $names);
        $bits = array();
        foreach ($out['teachers'] as $t) {
            $bits[] = $t['name'] . ' (' . $t['label'] . ')';
        }
        $out['label'] = implode(' · ', $bits);
        if (empty($ackIds)) {
            return $out;
        }
        foreach ($out['teachers'] as $idx => $t) {
            if ($t['status'] !== 'acknowledged' || $t['date'] === '') {
                continue;
            }
            $teacherId = (int) $t['id'];
            if ($teacherId < 1) {
                continue;
            }
            if ($this->drillsReady()) {
                $rows = $this->db->where('student_id', (int) $studentId)
                    ->where('evaluator_id', $teacherId)
                    ->where('DATE(created_at)', $t['date'])
                    ->order_by('id', 'DESC')->limit(8)->get('academy_daily_drill')->result();
                foreach ($rows as $row) {
                    $out['drills'][] = $row;
                }
                if (!empty($rows) && $out['teachers'][$idx]['portion'] === '') {
                    $d = $rows[0];
                    $out['teachers'][$idx]['portion'] = (isset($d->pillar) ? $d->pillar : 'Drill')
                        . ' ' . (int) $d->score . '/' . (int) $d->total_possible;
                }
            }
            if ($this->tahfizReady()) {
                $rows = $this->db->where('student_id', (int) $studentId)
                    ->where('instructor_id', $teacherId)
                    ->where('DATE(completed_at)', $t['date'])
                    ->order_by('id', 'DESC')->limit(8)->get('academy_tahfiz_record')->result();
                foreach ($rows as $row) {
                    $out['tahfiz'][] = $row;
                }
                if (!empty($rows)) {
                    $top = $rows[0];
                    $out['teachers'][$idx]['portion'] = (string) $this->formatTahfizMilestoneLabel($top);
                    if (!empty($top->recitation_category)) {
                        $cats = $this->recitationCategories();
                        $ck = strtoupper($top->recitation_category);
                        $out['teachers'][$idx]['category'] = isset($cats[$ck]) ? $cats[$ck] : $ck;
                    }
                    $out['teachers'][$idx]['audio_url'] = $this->absoluteMediaUrl(isset($top->audio_url) ? $top->audio_url : '');
                }
            }
        }
        return $out;
    }

    /**
     * Shakiest tahfiz clip for a teacher's day: lowest accuracy, then most mistakes.
     *
     * @return array|null
     */
    public function weakClipForSession($branchId, $teacherId, $date, $category = '', $milestoneId = 0)
    {
        if (!$this->tahfizReady() || (int) $teacherId < 1 || !$date) {
            return null;
        }
        $milestoneId = (int) $milestoneId;
        $rows = $this->db->select('t.*, s.first_name, s.last_name')
            ->from('academy_tahfiz_record t')
            ->join('student s', 's.id = t.student_id', 'left')
            ->where('t.branch_id', (int) $branchId)
            ->where('t.instructor_id', (int) $teacherId)
            ->where('DATE(t.completed_at)', $date);
        $category = strtoupper(trim((string) $category));
        if ($milestoneId > 0) {
            $this->db->where('t.id', $milestoneId);
        } elseif ($category !== '' && $this->db->field_exists('recitation_category', 'academy_tahfiz_record')) {
            $this->db->where('t.recitation_category', $category);
        }
        $rows = $this->db->get()->result();
        if (empty($rows)) {
            return null;
        }
        $best = null;
        $bestRank = null;
        foreach ($rows as $r) {
            $acc = (isset($r->accuracy_score) && $r->accuracy_score !== null && $r->accuracy_score !== '')
                ? (float) $r->accuracy_score : null;
            $mistakes = (isset($r->mistake_word_count) && $r->mistake_word_count !== null && $r->mistake_word_count !== '')
                ? (int) $r->mistake_word_count : 0;
            $rank = array(
                $acc === null ? 1 : 0,
                $acc === null ? 0 : $acc,
                -$mistakes,
                empty($r->audio_url) ? 1 : 0,
            );
            if ($best === null || $rank < $bestRank) {
                $best = $r;
                $bestRank = $rank;
            }
        }
        $cats = $this->recitationCategories();
        $ck = isset($best->recitation_category) ? strtoupper((string) $best->recitation_category) : '';
        return array(
            'student' => trim((isset($best->first_name) ? $best->first_name : '') . ' ' . (isset($best->last_name) ? $best->last_name : '')),
            'portion' => (string) $this->formatTahfizMilestoneLabel($best),
            'category' => isset($cats[$ck]) ? $cats[$ck] : '',
            'accuracy' => isset($best->accuracy_score) ? $best->accuracy_score : null,
            'mistakes' => isset($best->mistake_word_count) ? $best->mistake_word_count : null,
            'seconds' => isset($best->recitation_seconds) ? $best->recitation_seconds : null,
            'audio_url' => $this->absoluteMediaUrl(isset($best->audio_url) ? $best->audio_url : ''),
            'surah_number' => isset($best->surah_number) ? (int) $best->surah_number : 0,
            'ayah_from' => isset($best->ayah_from) ? (int) $best->ayah_from : 0,
            'ayah_to' => isset($best->ayah_to) ? (int) $best->ayah_to : 0,
            'tarteel' => $this->tarteelReport(isset($best->mistake_breakdown) ? $best->mistake_breakdown : ''),
        );
    }

    /**
     * Full Tarteel report: engine, correct words, Tajweed mistakes, aligned states.
     *
     * @return array{engine:string,transcript:string,correct:array,mistakes:array,states:array}
     */
    public function tarteelReport($json)
    {
        $empty = array(
            'engine' => '',
            'transcript' => '',
            'correct' => array(),
            'mistakes' => array(),
            'states' => array(),
        );
        $raw = json_decode((string) $json, true);
        if (!is_array($raw)) {
            return $empty;
        }
        $labels = array(
            'INCORRECT_TASHKEEL' => 'Incorrect tashkeel',
            'MISSED_WORD' => 'Missed word',
            'MISSED_WORDS' => 'Missed words',
            'EXTRA_WORD' => 'Extra word',
            'EXTRA_WORDS' => 'Extra words',
            'INCORRECT_WORD' => 'Incorrect word',
            'INCORRECT_WORDS' => 'Incorrect words',
        );
        $mistakeRows = isset($raw['mistakes']) && is_array($raw['mistakes']) ? $raw['mistakes'] : $raw;
        $mistakes = array();
        if (isset($raw['mistakes']) || (isset($mistakeRows[0]) && is_array($mistakeRows[0]))) {
            foreach ($mistakeRows as $m) {
                if (!is_array($m)) {
                    continue;
                }
                $type = isset($m['type']) ? strtoupper(trim((string) $m['type'])) : 'TAJWEED';
                $mistakes[] = array(
                    'label' => isset($labels[$type]) ? $labels[$type] : ucwords(strtolower(str_replace('_', ' ', $type))),
                    'ayah' => isset($m['ayah']) ? (int) $m['ayah'] : 0,
                    'word' => isset($m['word']) ? (int) $m['word'] : 0,
                    'text' => isset($m['text']) ? (string) $m['text'] : '',
                    'expected' => isset($m['expected']) ? (string) $m['expected'] : '',
                    'received' => isset($m['received']) ? (string) $m['received'] : '',
                );
            }
        }
        $correct = array();
        if (!empty($raw['correct']) && is_array($raw['correct'])) {
            foreach ($raw['correct'] as $c) {
                if (!is_array($c)) {
                    continue;
                }
                $correct[] = array(
                    'ayah' => isset($c['ayah']) ? (int) $c['ayah'] : 0,
                    'word' => isset($c['word']) ? (int) $c['word'] : 0,
                    'text' => isset($c['text']) ? (string) $c['text'] : '',
                );
            }
        }
        $engine = isset($raw['engine']) ? (string) $raw['engine'] : '';
        $engineLabel = array('cloud' => 'Tarteel cloud', 'local' => 'Local engine', 'auto' => 'Auto');
        return array(
            'engine' => isset($engineLabel[$engine]) ? $engineLabel[$engine] : $engine,
            'transcript' => isset($raw['transcript']) ? (string) $raw['transcript'] : '',
            'correct' => $correct,
            'mistakes' => $mistakes,
            'states' => $this->tarteelStates(isset($raw['states']) ? $raw['states'] : array()),
        );
    }

    /**
     * Word timings saved by the engine, kept small enough for the review player.
     */
    protected function tarteelStates($states)
    {
        if (!is_array($states)) {
            return array();
        }
        $out = array();
        foreach ($states as $st) {
            if (!is_array($st)) {
                continue;
            }
            $pos = isset($st['position']) && is_array($st['position']) ? $st['position'] : array();
            $out[] = array(
                'ayah' => isset($pos['ayahNumber']) ? (int) $pos['ayahNumber'] : 0,
                'word' => isset($pos['wordNumber']) ? (int) $pos['wordNumber'] : 0,
                'start' => isset($st['startTime']) ? (float) $st['startTime'] : null,
                'end' => isset($st['endTime']) ? (float) $st['endTime'] : null,
            );
            if (count($out) >= 800) {
                break;
            }
        }
        return $out;
    }

    /**
     * Recordings with their Tarteel report for director and admin analysis.
     */
    /**
     * Editable analysis bands. Parents never see these; they only receive a sealed clip.
     */
    public function ensureTarteelBands($branchId)
    {
        if (!$this->db->table_exists('academy_tarteel_band')) {
            $this->db->query("CREATE TABLE `academy_tarteel_band` (
                `id` INT(11) NOT NULL AUTO_INCREMENT,
                `branch_id` INT(11) NOT NULL,
                `name` VARCHAR(40) NOT NULL,
                `sort_order` INT(11) NOT NULL DEFAULT 0,
                `strength_min_accuracy` DECIMAL(5,1) NOT NULL DEFAULT 75,
                `strength_max_mistakes` INT(11) NOT NULL DEFAULT 1,
                `weak_max_accuracy` DECIMAL(5,1) NOT NULL DEFAULT 60,
                `weak_min_mistakes` INT(11) NOT NULL DEFAULT 4,
                PRIMARY KEY (`id`),
                KEY `idx_atb_branch` (`branch_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8");
        }
        if (!$this->db->table_exists('academy_tarteel_student')) {
            $this->db->query("CREATE TABLE `academy_tarteel_student` (
                `branch_id` INT(11) NOT NULL,
                `student_id` INT(11) NOT NULL,
                `band_id` INT(11) NOT NULL,
                PRIMARY KEY (`branch_id`, `student_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8");
        }
        $n = (int) $this->db->where('branch_id', (int) $branchId)->count_all_results('academy_tarteel_band');
        if ($n > 0) {
            return;
        }
        $defaults = array(
            array('Beginner', 1, 60, 3, 40, 6),
            array('Medium', 2, 75, 1, 60, 4),
            array('Advanced', 3, 90, 0, 75, 2),
        );
        foreach ($defaults as $d) {
            $this->db->insert('academy_tarteel_band', array(
                'branch_id' => (int) $branchId,
                'name' => $d[0],
                'sort_order' => $d[1],
                'strength_min_accuracy' => $d[2],
                'strength_max_mistakes' => $d[3],
                'weak_max_accuracy' => $d[4],
                'weak_min_mistakes' => $d[5],
            ));
        }
    }

    public function tarteelBands($branchId)
    {
        $this->ensureTarteelBands($branchId);
        return $this->db->order_by('sort_order', 'ASC')->get_where('academy_tarteel_band', array(
            'branch_id' => (int) $branchId,
        ))->result();
    }

    public function tarteelStudentBands($branchId)
    {
        $this->ensureTarteelBands($branchId);
        $map = array();
        $rows = $this->db->get_where('academy_tarteel_student', array('branch_id' => (int) $branchId))->result();
        foreach ($rows as $row) {
            $map[(int) $row->student_id] = (int) $row->band_id;
        }
        return $map;
    }

    public function saveTarteelBands($branchId, $bands, $assignments)
    {
        $this->ensureTarteelBands($branchId);
        $branchId = (int) $branchId;
        $kept = array();
        foreach ($bands as $band) {
            $name = trim((string) $band['name']);
            if ($name === '') {
                continue;
            }
            $row = array(
                'name' => substr($name, 0, 40),
                'sort_order' => (int) $band['sort_order'],
                'strength_min_accuracy' => max(0, min(100, (float) $band['strength_min_accuracy'])),
                'strength_max_mistakes' => max(0, (int) $band['strength_max_mistakes']),
                'weak_max_accuracy' => max(0, min(100, (float) $band['weak_max_accuracy'])),
                'weak_min_mistakes' => max(1, (int) $band['weak_min_mistakes']),
            );
            $id = (int) $band['id'];
            if ($id > 0) {
                $this->db->where('id', $id)->where('branch_id', $branchId)->update('academy_tarteel_band', $row);
                $kept[] = $id;
            } else {
                $row['branch_id'] = $branchId;
                $this->db->insert('academy_tarteel_band', $row);
                $kept[] = (int) $this->db->insert_id();
            }
        }
        if (!empty($kept)) {
            $this->db->where('branch_id', $branchId)->where_not_in('id', $kept)->delete('academy_tarteel_band');
            $this->db->where('branch_id', $branchId)->where_not_in('band_id', $kept)->delete('academy_tarteel_student');
        }
        $valid = array();
        foreach ($this->tarteelBands($branchId) as $band) {
            $valid[(int) $band->id] = true;
        }
        foreach ($assignments as $studentId => $bandId) {
            $studentId = (int) $studentId;
            $bandId = (int) $bandId;
            if ($studentId < 1 || empty($valid[$bandId])) {
                continue;
            }
            $exists = $this->db->get_where('academy_tarteel_student', array(
                'branch_id' => $branchId,
                'student_id' => $studentId,
            ))->row();
            if ($exists) {
                $this->db->where('branch_id', $branchId)->where('student_id', $studentId)->update('academy_tarteel_student', array(
                    'band_id' => $bandId,
                ));
            } else {
                $this->db->insert('academy_tarteel_student', array(
                    'branch_id' => $branchId,
                    'student_id' => $studentId,
                    'band_id' => $bandId,
                ));
            }
        }
    }

    public function tarteelVerdict($accuracy, $mistakes, $band)
    {
        $strengthAcc = $band ? (float) $band->strength_min_accuracy : 75;
        $strengthMistakes = $band ? (int) $band->strength_max_mistakes : 1;
        $weakAcc = $band ? (float) $band->weak_max_accuracy : 60;
        $weakMistakes = $band ? (int) $band->weak_min_mistakes : 4;
        $name = $band ? $band->name : 'Medium';
        if ($accuracy !== null && $accuracy >= $strengthAcc && $mistakes <= $strengthMistakes) {
            return array(
                'verdict' => 'Strength',
                'verdict_note' => $name . ': ' . $strengthAcc . '% or better, at most ' . $strengthMistakes . ' mistake' . ($strengthMistakes === 1 ? '' : 's') . '.',
            );
        }
        if (($accuracy !== null && $accuracy < $weakAcc) || $mistakes >= $weakMistakes) {
            return array(
                'verdict' => 'Needs improving',
                'verdict_note' => $name . ': below ' . $weakAcc . '% or ' . $weakMistakes . ' or more mistakes.',
            );
        }
        return array(
            'verdict' => 'Holding',
            'verdict_note' => $name . ': between the strength line and the improve line.',
        );
    }

    public function tarteelAnalyses($branchId, $studentId = 0, $limit = 60)
    {
        if (!$this->tahfizReady()) {
            return array();
        }
        $cats = $this->recitationCategories();
        $this->db->select('t.*, st.name AS teacher_name, TRIM(CONCAT_WS(" ", s.first_name, NULLIF(s.other_name,""), s.last_name)) AS student_name');
        $this->db->from('academy_tahfiz_record t');
        $this->db->join('student s', 's.id = t.student_id', 'left');
        $this->db->join('staff st', 'st.id = t.instructor_id', 'left');
        $this->db->where('t.branch_id', (int) $branchId);
        if ((int) $studentId > 0) {
            $this->db->where('t.student_id', (int) $studentId);
        }
        $this->db->order_by('t.completed_at', 'DESC');
        $this->db->limit((int) $limit);
        $rows = $this->db->get()->result();
        $bands = array();
        foreach ($this->tarteelBands($branchId) as $band) {
            $bands[(int) $band->id] = $band;
        }
        $assigned = $this->tarteelStudentBands($branchId);
        $medium = null;
        foreach ($bands as $band) {
            if (strcasecmp($band->name, 'Medium') === 0) {
                $medium = $band;
                break;
            }
        }
        if ($medium === null && !empty($bands)) {
            $medium = reset($bands);
        }
        foreach ($rows as $row) {
            $ck = isset($row->recitation_category) ? strtoupper((string) $row->recitation_category) : '';
            $row->category_label = isset($cats[$ck]) ? $cats[$ck] : '';
            $row->portion_label = (string) $this->formatTahfizMilestoneLabel($row);
            $row->play_url = $this->absoluteMediaUrl(isset($row->audio_url) ? $row->audio_url : '');
            $row->tarteel = $this->tarteelReport(isset($row->mistake_breakdown) ? $row->mistake_breakdown : '');
            $bandId = isset($assigned[(int) $row->student_id]) ? $assigned[(int) $row->student_id] : 0;
            $band = ($bandId && isset($bands[$bandId])) ? $bands[$bandId] : $medium;
            $row->band_name = $band ? $band->name : 'Medium';
            $acc = ($row->accuracy_score !== null && $row->accuracy_score !== '') ? (float) $row->accuracy_score : null;
            $mistakes = ($row->mistake_word_count !== null && $row->mistake_word_count !== '') ? (int) $row->mistake_word_count : 0;
            $judged = $this->tarteelVerdict($acc, $mistakes, $band);
            $row->verdict = $judged['verdict'];
            $row->verdict_note = $judged['verdict_note'];
        }
        return $rows;
    }

    /**
     * Strength, weakness, and what to improve across the recordings on screen.
     */
    public function tarteelInsight($rows)
    {
        $students = array();
        $categories = array();
        $types = array();
        foreach ($rows as $row) {
            $sid = (int) $row->student_id;
            if (!isset($students[$sid])) {
                $students[$sid] = array(
                    'name' => $row->student_name,
                    'n' => 0,
                    'acc' => 0,
                    'acc_n' => 0,
                    'mistakes' => 0,
                    'band' => isset($row->band_name) ? $row->band_name : 'Medium',
                    'strengths' => array(),
                    'weak' => array(),
                );
            }
            $students[$sid]['n']++;
            $students[$sid]['mistakes'] += (int) $row->mistake_word_count;
            if ($row->accuracy_score !== null && $row->accuracy_score !== '') {
                $students[$sid]['acc'] += (float) $row->accuracy_score;
                $students[$sid]['acc_n']++;
            }
            $cat = $row->category_label !== '' ? $row->category_label : 'Uncategorised';
            if (!isset($categories[$cat])) {
                $categories[$cat] = array('n' => 0, 'acc' => 0, 'acc_n' => 0, 'mistakes' => 0, 'strength' => 0, 'weak' => 0);
            }
            $categories[$cat]['n']++;
            $categories[$cat]['mistakes'] += (int) $row->mistake_word_count;
            if ($row->accuracy_score !== null && $row->accuracy_score !== '') {
                $categories[$cat]['acc'] += (float) $row->accuracy_score;
                $categories[$cat]['acc_n']++;
            }
            if ($row->verdict === 'Strength') {
                $categories[$cat]['strength']++;
                $students[$sid]['strengths'][$row->portion_label . ($row->category_label !== '' ? ' · ' . $row->category_label : '')] = true;
            }
            if ($row->verdict === 'Needs improving') {
                $categories[$cat]['weak']++;
                $students[$sid]['weak'][] = $row->portion_label
                    . ($row->category_label !== '' ? ' · ' . $row->category_label : '')
                    . ' · ' . ($row->accuracy_score !== null && $row->accuracy_score !== '' ? $row->accuracy_score . '%' : 'no score')
                    . ' · ' . (int) $row->mistake_word_count . ' mistakes';
            }
            if (!empty($row->tarteel['mistakes'])) {
                foreach ($row->tarteel['mistakes'] as $m) {
                    $label = $m['label'];
                    if (!isset($types[$label])) {
                        $types[$label] = 0;
                    }
                    $types[$label]++;
                }
            }
        }
        $people = array();
        foreach ($students as $s) {
            $s['avg'] = $s['acc_n'] > 0 ? round($s['acc'] / $s['acc_n'], 1) : null;
            $s['strengths'] = array_keys($s['strengths']);
            $people[] = $s;
        }
        $catRows = array();
        foreach ($categories as $name => $c) {
            $avg = $c['acc_n'] > 0 ? round($c['acc'] / $c['acc_n'], 1) : null;
            $note = 'Holding';
            if ($c['n'] > 0 && $c['strength'] >= $c['weak'] && $c['strength'] * 2 >= $c['n']) {
                $note = 'Strength';
            } elseif ($c['n'] > 0 && $c['weak'] > $c['strength']) {
                $note = 'Needs improving';
            }
            $catRows[] = array(
                'name' => $name,
                'n' => $c['n'],
                'avg' => $avg,
                'mistakes' => $c['mistakes'],
                'note' => $note,
            );
        }
        arsort($types);
        return array('students' => $people, 'categories' => $catRows, 'types' => $types);
    }

    /**
     * Acknowledge every session the director already approved for this date.
     *
     * @return int
     */
    public function releaseToday($branchId, $actorId, $date = null)
    {
        if (!$this->reviewReady()) {
            return 0;
        }
        $date = $date ? $date : date('Y-m-d');
        $rows = $this->db->get_where('academy_class_session', array(
            'branch_id' => (int) $branchId,
            'session_date' => $date,
            'status' => 'pending_admin',
        ))->result();
        $n = 0;
        foreach ($rows as $row) {
            $err = $this->decideSession((int) $row->id, $branchId, $actorId, 'admin', true, '');
            if ($err === null) {
                $n++;
            }
        }
        return $n;
    }

    /**
     * Acknowledged tahfiz rows for one student, optionally one surah.
     */
    public function sealedPins($branchId, $studentId, $surah = null)
    {
        if (!$this->tahfizReady() || !$this->db->table_exists('academy_class_session') || (int) $studentId < 1) {
            return array();
        }
        $this->db->select('t.*, st.name AS teacher_name, cs.session_date');
        $this->db->from('academy_tahfiz_record t');
        $this->db->join(
            'academy_class_session cs',
            'cs.teacher_id = t.instructor_id AND cs.branch_id = t.branch_id AND cs.session_date = DATE(t.completed_at) AND cs.status = "acknowledged" AND (cs.milestone_id = t.id OR (cs.milestone_id = 0 AND (cs.recitation_category = \'\' OR cs.recitation_category = t.recitation_category)))',
            'inner'
        );
        $this->db->join('staff st', 'st.id = t.instructor_id', 'left');
        $this->db->where('t.branch_id', (int) $branchId);
        $this->db->where('t.student_id', (int) $studentId);
        if ($surah !== null && $surah !== '') {
            $this->db->where('t.surah_name', $surah);
        }
        $this->db->order_by('t.surah_name', 'ASC');
        $this->db->order_by('t.ayah_from', 'ASC');
        $this->db->order_by('cs.session_date', 'ASC');
        $rows = $this->db->get()->result();
        $cats = $this->recitationCategories();
        foreach ($rows as $row) {
            $row->portion_label = $this->formatTahfizMilestoneLabel($row);
            $ck = isset($row->recitation_category) ? strtoupper((string) $row->recitation_category) : '';
            $row->category_label = isset($cats[$ck]) ? $cats[$ck] : '';
            $row->play_url = $this->absoluteMediaUrl(isset($row->audio_url) ? $row->audio_url : '');
        }
        return $rows;
    }

    /**
     * Surahs that have at least one sealed pin, with fill progress for Living Mushaf.
     *
     * @return array<int,array{name:string,count:int,surah_number:int,ayah_count:int,filled:int,percent:int}>
     */
    public function sealedSurahs($branchId, $studentId)
    {
        $pins = $this->sealedPins($branchId, $studentId, null);
        $byName = array();
        foreach ($pins as $pin) {
            $name = isset($pin->surah_name) && $pin->surah_name !== '' ? $pin->surah_name : 'Surah';
            if (!isset($byName[$name])) {
                $byName[$name] = array();
            }
            $byName[$name][] = $pin;
        }
        $counts = $this->surahAyahCounts();
        $out = array();
        foreach ($byName as $name => $group) {
            $sn = $this->resolveSurahNumber($name, $group);
            $ayahCount = isset($counts[$sn]) ? (int) $counts[$sn] : 0;
            $filledMap = array();
            foreach ($group as $pin) {
                foreach ($this->ayahsCoveredByPin($pin, $ayahCount) as $a) {
                    $filledMap[$a] = true;
                }
            }
            $filled = count($filledMap);
            $out[] = array(
                'name' => $name,
                'count' => count($group),
                'surah_number' => $sn,
                'ayah_count' => $ayahCount,
                'filled' => $filled,
                'percent' => $ayahCount > 0 ? (int) round(100 * $filled / $ayahCount) : 0,
            );
        }
        usort($out, function ($a, $b) {
            return $a['surah_number'] - $b['surah_number'];
        });
        return $out;
    }

    /**
     * Living Mushaf page for one surah: every ayah cell, sealed or empty.
     *
     * @return array{surah_number:int,surah_name:string,ayah_count:int,filled:int,percent:int,ayahs:array,continue:array}
     */
    public function livingMushafSurah($branchId, $studentId, $surahName)
    {
        $pins = $this->sealedPins($branchId, $studentId, $surahName);
        $sn = $this->resolveSurahNumber($surahName, $pins);
        $counts = $this->surahAyahCounts();
        $names = $this->surahList();
        $total = isset($counts[$sn]) ? (int) $counts[$sn] : 0;
        $name = $surahName !== '' ? $surahName : (isset($names[$sn]) ? $names[$sn] : 'Surah');

        $byAyah = array();
        foreach ($pins as $pin) {
            foreach ($this->ayahsCoveredByPin($pin, $total) as $a) {
                if (!isset($byAyah[$a]) || $this->livingPinPreferred($pin, $byAyah[$a])) {
                    $byAyah[$a] = $pin;
                }
            }
        }

        $ayahs = array();
        for ($i = 1; $i <= $total; $i++) {
            $pin = isset($byAyah[$i]) ? $byAyah[$i] : null;
            $ayahs[] = array(
                'n' => $i,
                'sealed' => $pin !== null,
                'play_url' => ($pin && !empty($pin->play_url)) ? $pin->play_url : '',
                'label' => $pin ? (string) $pin->portion_label : '',
                'date' => $pin ? (string) $pin->session_date : '',
                'teacher' => ($pin && !empty($pin->teacher_name)) ? (string) $pin->teacher_name : '',
                'category' => ($pin && !empty($pin->category_label)) ? (string) $pin->category_label : '',
            );
        }

        $frontier = $this->sealedFrontierPin($branchId, $studentId);
        return array(
            'surah_number' => $sn,
            'surah_name' => $name,
            'ayah_count' => $total,
            'filled' => count($byAyah),
            'percent' => $total > 0 ? (int) round(100 * count($byAyah) / $total) : 0,
            'ayahs' => $ayahs,
            'continue' => $this->nextGoalFromMilestone($frontier),
            'seal_label' => 'Sealed by Tahsin',
        );
    }

    /**
     * Next ayah after the furthest sealed portion (curriculum frontier).
     */
    public function sealedContinueGoal($branchId, $studentId)
    {
        return $this->nextGoalFromMilestone($this->sealedFrontierPin($branchId, $studentId));
    }

    /**
     * Furthest sealed pin by surah number then ayah (not merely latest date).
     */
    public function sealedFrontierPin($branchId, $studentId)
    {
        $pins = $this->sealedPins($branchId, $studentId, null);
        if (empty($pins)) {
            return null;
        }
        $counts = $this->surahAyahCounts();
        $best = null;
        $bestScore = -1;
        foreach ($pins as $pin) {
            $sn = isset($pin->surah_number) ? (int) $pin->surah_number : 0;
            if ($sn < 1) {
                $sn = $this->resolveSurahNumber(isset($pin->surah_name) ? $pin->surah_name : '', array($pin));
            }
            $to = 0;
            if (!empty($pin->portion_mode) && $pin->portion_mode === 'FULL_SURAH') {
                $to = isset($counts[$sn]) ? (int) $counts[$sn] : 0;
            } elseif (isset($pin->ayah_to) && $pin->ayah_to !== '' && $pin->ayah_to !== null) {
                $to = (int) $pin->ayah_to;
            } elseif (isset($pin->ayah_from) && $pin->ayah_from !== '' && $pin->ayah_from !== null) {
                $to = (int) $pin->ayah_from;
            }
            $score = ($sn * 1000) + $to;
            if ($score > $bestScore) {
                $bestScore = $score;
                $best = $pin;
                $best->surah_number = $sn;
                if ($to > 0) {
                    $best->ayah_to = $to;
                }
            }
        }
        return $best;
    }

    /**
     * @param object[] $pins
     * @return int
     */
    protected function resolveSurahNumber($surahName, $pins = array())
    {
        foreach ((array) $pins as $pin) {
            if (isset($pin->surah_number) && (int) $pin->surah_number > 0) {
                return (int) $pin->surah_number;
            }
        }
        $names = $this->surahList();
        $want = strtolower(trim((string) $surahName));
        if ($want === '') {
            return 1;
        }
        foreach ($names as $num => $label) {
            if (strtolower($label) === $want) {
                return (int) $num;
            }
        }
        return 1;
    }

    /**
     * @return int[]
     */
    protected function ayahsCoveredByPin($pin, $surahAyahs)
    {
        $mode = isset($pin->portion_mode) ? (string) $pin->portion_mode : '';
        $from = isset($pin->ayah_from) && $pin->ayah_from !== '' && $pin->ayah_from !== null ? (int) $pin->ayah_from : 0;
        $to = isset($pin->ayah_to) && $pin->ayah_to !== '' && $pin->ayah_to !== null ? (int) $pin->ayah_to : $from;
        $out = array();
        if ($mode === 'FULL_SURAH' && $surahAyahs > 0) {
            for ($i = 1; $i <= $surahAyahs; $i++) {
                $out[] = $i;
            }
            return $out;
        }
        if ($from < 1) {
            return $out;
        }
        if ($to < $from) {
            $to = $from;
        }
        if ($surahAyahs > 0 && $to > $surahAyahs) {
            $to = $surahAyahs;
        }
        for ($i = $from; $i <= $to; $i++) {
            $out[] = $i;
        }
        return $out;
    }

    /**
     * Prefer a pin with audio, then a later seal date.
     */
    protected function livingPinPreferred($candidate, $current)
    {
        $cAudio = !empty($candidate->play_url);
        $curAudio = !empty($current->play_url);
        if ($cAudio !== $curAudio) {
            return $cAudio;
        }
        $cDate = isset($candidate->session_date) ? (string) $candidate->session_date : '';
        $curDate = isset($current->session_date) ? (string) $current->session_date : '';
        return strcmp($cDate, $curDate) >= 0;
    }

    public function unreadNotices($userId, $limit = 6)
    {
        if (!$this->db->table_exists('academy_notice')) {
            return array();
        }
        return $this->db->where('user_id', (int) $userId)
            ->where('is_read', 0)
            ->order_by('id', 'DESC')
            ->limit((int) $limit)
            ->get('academy_notice')->result();
    }

    public function markNoticesRead($userId)
    {
        if (!$this->db->table_exists('academy_notice')) {
            return;
        }
        $this->db->where('user_id', (int) $userId)->update('academy_notice', array('is_read' => 1));
    }

    protected function countRecordedStudents($branchId, $studentIds, $date, $teacherId = 0)
    {
        return count($this->recordedStudentIds($branchId, $studentIds, $date, $teacherId));
    }

    /**
     * @return array<int,true>
     */
    protected function recordedStudentIds($branchId, $studentIds, $date, $teacherId = 0, $category = '')
    {
        $seen = array();
        if (empty($studentIds)) {
            return $seen;
        }
        $teacherId = (int) $teacherId;
        $category = strtoupper(trim((string) $category));
        if ($category === '' && $this->drillsReady()) {
            $this->db->select('student_id')->from('academy_daily_drill')
                ->where('branch_id', (int) $branchId)
                ->where('DATE(created_at)', $date)
                ->where_in('student_id', $studentIds);
            if ($teacherId > 0) {
                $this->db->where('evaluator_id', $teacherId);
            }
            $rows = $this->db->group_by('student_id')->get()->result();
            foreach ($rows as $r) {
                $seen[(int) $r->student_id] = true;
            }
        }
        if ($this->tahfizReady()) {
            $this->db->select('student_id')->from('academy_tahfiz_record')
                ->where('branch_id', (int) $branchId)
                ->where('DATE(completed_at)', $date)
                ->where_in('student_id', $studentIds);
            if ($teacherId > 0) {
                $this->db->where('instructor_id', $teacherId);
            }
            if ($category !== '' && $this->db->field_exists('recitation_category', 'academy_tahfiz_record')) {
                $this->db->where('recitation_category', $category);
            }
            $rows = $this->db->group_by('student_id')->get()->result();
            foreach ($rows as $r) {
                $seen[(int) $r->student_id] = true;
            }
        }
        return $seen;
    }

    protected function missingStudentLabel($studentIds)
    {
        if (empty($studentIds)) {
            return '';
        }
        $rows = $this->db->select('id, first_name')->where_in('id', $studentIds)->get('student')->result();
        $map = array();
        foreach ($rows as $r) {
            $map[(int) $r->id] = $r->first_name;
        }
        $names = array();
        foreach ($studentIds as $id) {
            if (!empty($map[(int) $id])) {
                $names[] = $map[(int) $id];
            }
        }
        if (empty($names)) {
            return '';
        }
        $show = array_slice($names, 0, 8);
        $label = ' Still to record: ' . implode(', ', $show);
        if (count($names) > 8) {
            $label .= ' and ' . (count($names) - 8) . ' more';
        }
        return $label . '.';
    }

    protected function notifyRoles($roleIds, $branchId, $title, $body, $link)
    {
        if (!$this->db->table_exists('login_credential')) {
            return;
        }
        $rows = $this->db->select('user_id')->from('login_credential')
            ->where_in('role', array_map('intval', (array) $roleIds))
            ->where('active', 1)
            ->get()->result();
        $sent = array();
        foreach ($rows as $r) {
            $uid = (int) $r->user_id;
            if ($uid < 1 || isset($sent[$uid])) {
                continue;
            }
            $sent[$uid] = true;
            $this->pushNotice($uid, $branchId, $title, $body, $link);
        }
    }

    protected function pushNotice($userId, $branchId, $title, $body, $link)
    {
        if (!$this->db->table_exists('academy_notice') || (int) $userId < 1) {
            return;
        }
        $this->db->insert('academy_notice', array(
            'branch_id' => (int) $branchId,
            'user_id' => (int) $userId,
            'title' => mb_substr($title, 0, 160),
            'body' => mb_substr((string) $body, 0, 500),
            'link' => $link,
            'is_read' => 0,
        ));
    }
}
