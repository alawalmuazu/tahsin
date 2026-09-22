<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Academy_model extends MY_Model
{
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

    public function getActiveStudents($branch_id)
    {
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
        $this->db->select('d.*, TRIM(CONCAT_WS(" ", s.first_name, NULLIF(s.other_name,""), s.last_name)) AS student_name, s.register_no');
        $this->db->from('academy_daily_drill d');
        $this->db->join('student s', 's.id = d.student_id', 'left');
        $this->db->where('d.branch_id', (int) $branch_id);
        $this->db->where('DATE(d.created_at)', date('Y-m-d'));
        $this->db->order_by('d.id', 'DESC');
        $this->db->limit((int) $limit);
        return $this->db->get()->result();
    }

    public function getRecentDrills($branch_id, $limit = 100)
    {
        $this->db->select('d.*, TRIM(CONCAT_WS(" ", s.first_name, NULLIF(s.other_name,""), s.last_name)) AS student_name, s.register_no');
        $this->db->from('academy_daily_drill d');
        $this->db->join('student s', 's.id = d.student_id', 'left');
        $this->db->where('d.branch_id', (int) $branch_id);
        $this->db->order_by('d.id', 'DESC');
        $this->db->limit((int) $limit);
        return $this->db->get()->result();
    }

    public function deleteDrill($id, $branch_id)
    {
        $this->db->where(array('id' => (int) $id, 'branch_id' => (int) $branch_id));
        return $this->db->delete('academy_daily_drill');
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
        return $this->db->insert_id();
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
        $this->db->select('t.*, TRIM(CONCAT_WS(" ", s.first_name, NULLIF(s.other_name,""), s.last_name)) AS student_name, s.register_no');
        $this->db->from('academy_tahfiz_record t');
        $this->db->join('student s', 's.id = t.student_id', 'left');
        $this->db->where('t.branch_id', (int) $branch_id);
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
     * Simple Barakah snapshot for a student (0–100).
     * Academics 30% (MATH+ENGLISH), Quran 30%, Vocational 20%, Arabic 20%.
     */
    public function barakahForStudent($student_id)
    {
        if (!$this->drillsReady()) {
            return array(
                'score' => 0,
                'parts' => array('academics' => 0, 'quran' => 0, 'vocational' => 0, 'arabic' => 0),
                'total_surahs' => 0,
                'total_drills' => 0,
            );
        }
        $sid = (int) $student_id;
        $avgPct = function ($pillars) use ($sid) {
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

        $quran = 0.0;
        $surahCount = 0;
        if ($this->tahfizReady()) {
            $this->db->select('COUNT(DISTINCT surah_number) AS n');
            $this->db->from('academy_tahfiz_record');
            $this->db->where(array('student_id' => $sid, 'verified' => 1));
            $surahCount = (int) $this->db->get()->row()->n;
            $quran = min($surahCount * 3.33, 100);
        }

        $this->db->where('student_id', $sid);
        $drillCount = $this->drillsReady() ? (int) $this->db->count_all_results('academy_daily_drill') : 0;

        $score = (int) round(min(
            ($academics * 0.30) + ($quran * 0.30) + ($vocational * 0.20) + ($arabic * 0.20),
            100
        ));

        return array(
            'score' => $score,
            'parts' => array(
                'academics' => (int) round($academics),
                'quran' => (int) round($quran),
                'vocational' => (int) round($vocational),
                'arabic' => (int) round($arabic),
            ),
            'total_surahs' => $surahCount,
            'total_drills' => $drillCount,
        );
    }

    public function drillStreak($student_id)
    {
        if (!$this->drillsReady()) {
            return 0;
        }
        $this->db->select('DATE(created_at) AS d', false);
        $this->db->from('academy_daily_drill');
        $this->db->where('student_id', (int) $student_id);
        $this->db->group_by('DATE(created_at)');
        $this->db->order_by('d', 'DESC');
        $this->db->limit(60);
        $rows = $this->db->get()->result();
        if (empty($rows)) {
            return 0;
        }
        $dates = array();
        foreach ($rows as $r) {
            $dates[$r->d] = true;
        }
        $streak = 0;
        $cursor = new DateTime('today');
        for ($i = 0; $i < 60; $i++) {
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
     * Full Academy Students cohort: roster + tahfiz + drills + barakah for hub UI.
     */
    public function getCohortRoster($branch_id)
    {
        $sessionID = get_session_id();
        $select = 's.id, s.register_no, s.admission_date, s.birthday, s.gender, s.mobileno, s.parent_id,
            e.id AS enroll_id,
            TRIM(CONCAT_WS(" ", s.first_name, NULLIF(s.other_name,""), s.last_name)) AS fullname,
            e.class_id, e.section_id, c.name AS class_name, se.name AS section_name,
            p.name AS parent_name, p.mobileno AS parent_mobile';
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

            $roster[] = array(
                'id' => $sid,
                'enroll_id' => (int) $s->enroll_id,
                'fullname' => $s->fullname,
                'register_no' => $s->register_no,
                'class_level' => $classLevel,
                'class_name' => $s->class_name,
                'section_name' => $s->section_name,
                'age_group' => $ageGroup,
                'gender' => $s->gender,
                'parent_contact' => $s->parent_mobile ? $s->parent_mobile : $s->mobileno,
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

        foreach ($roster as $st) {
            $drills = array();
            if ($this->drillsReady()) {
                $this->db->from('academy_daily_drill');
                $this->db->where('student_id', $st['id']);
                $this->db->where('DATE(created_at)', $today);
                $drills = $this->db->get()->result();
            }
            $tahfizToday = array();
            if ($this->tahfizReady()) {
                $this->db->from('academy_tahfiz_record');
                $this->db->where('student_id', $st['id']);
                $this->db->where('DATE(completed_at)', $today);
                $tahfizToday = $this->db->get()->result();
            }

            if ($st['parent_contact']) {
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

            $reports[] = array(
                'student_id' => $st['id'],
                'student_name' => $st['fullname'],
                'parent_contact' => $st['parent_contact'],
                'message' => implode("\n", $lines),
                'drill_count' => count($drills),
                'tahfiz_count' => count($tahfizToday),
                'has_phone' => !empty($st['parent_contact']),
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
            'reports' => $reports,
            'cohort_message' => implode("\n", $cohortLines),
        );
    }

    /**
     * Turn relative upload paths into absolute URLs parents can open on their phones.
     * localhost URLs only work on the same machine — use the public Hostinger URL in production.
     */
    public function absoluteMediaUrl($url)
    {
        $url = trim((string) $url);
        if ($url === '') {
            return '';
        }
        if (preg_match('#^https?://#i', $url)) {
            return $url;
        }
        if ($url[0] === '/') {
            return rtrim(base_url(), '/') . $url;
        }
        return rtrim(base_url(), '/') . '/' . ltrim($url, '/');
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
     * Template body params for Meta WhatsApp utility template.
     * Order: student, date, summary, media_url.
     */
    public function digestTemplateParams($report)
    {
        $name = isset($report['student_name']) ? $report['student_name'] : 'Student';
        $date = date('j M Y');
        $bits = array();
        $drills = isset($report['drill_count']) ? (int) $report['drill_count'] : 0;
        $tahfiz = isset($report['tahfiz_count']) ? (int) $report['tahfiz_count'] : 0;
        if ($drills > 0) {
            $bits[] = $drills . ' drill' . ($drills === 1 ? '' : 's');
        }
        if ($tahfiz > 0) {
            $bits[] = $tahfiz . ' Quran milestone' . ($tahfiz === 1 ? '' : 's');
        }
        $summary = !empty($bits) ? implode(', ', $bits) : 'No drills or tahfiz logged today';

        $mediaUrl = '—';
        if (!empty($report['media']) && is_array($report['media'])) {
            foreach ($report['media'] as $m) {
                if (!empty($m['audio_url'])) {
                    $mediaUrl = $m['audio_url'];
                    break;
                }
                if (!empty($m['video_url'])) {
                    $mediaUrl = $m['video_url'];
                    break;
                }
            }
        }

        return array($name, $date, $summary, $mediaUrl);
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
}
