<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Academy Students hub — Barakah cards, activity ledger, voice NLP, Tarteel fields.
 */
class Academy_students extends Admin_Controller
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

        $branchID = $this->application_model->get_branch_id();

        if ($this->input->post('toggle_media_consent')) {
            $sid = (int) $this->input->post('student_id');
            $val = (int) $this->input->post('media_consent');
            if ($this->academy_model->setMediaConsent($sid, $val)) {
                set_alert('success', 'Media consent updated.');
            } else {
                set_alert('error', 'Run academy_engine_v2.sql to enable media consent.');
            }
            redirect(base_url('academy_students'));
        }

        if ($this->input->post('quick_tahfiz')) {
            if (!$this->academy_model->tahfizReady()) {
                set_alert('error', 'Run application/migrations/academy_engine.sql first.');
                redirect(base_url('academy_students'));
            }
            $this->form_validation->set_rules('student_id', 'Student', 'trim|required|integer');
            $this->form_validation->set_rules('surah_number', 'Surah', 'trim|required|integer');
            $milestoneIdEarly = (int) $this->input->post('milestone_id');
            if ($milestoneIdEarly < 1) {
                $this->form_validation->set_rules('recitation_category', 'Recitation category', 'trim|required');
            }
            if ($this->form_validation->run() == true) {
                if (is_teacher_loggedin() && !$this->academy_model->studentAssignedToTeacher((int) $this->input->post('student_id'), get_loggedin_user_id(), $branchID)) {
                    set_alert('error', 'This student is not assigned to you.');
                    redirect(base_url('academy_students'));
                }
                $audioUrl = $this->input->post('audio_url');
                $uploadError = null;
                if (!empty($_FILES['audio_file']['name'])) {
                    $uploaded = $this->_uploadRecitationAudio();
                    if ($uploaded) {
                        $audioUrl = $uploaded;
                    } else {
                        $uploadError = method_exists($this, 'upload') || isset($this->upload)
                            ? $this->upload->display_errors('', '')
                            : 'Upload failed';
                    }
                }
                // Prefer raw POST for large base64 (CI input can be awkward on big payloads)
                $b64 = isset($_POST['audio_file_b64']) ? $_POST['audio_file_b64'] : $this->input->post('audio_file_b64');
                if (!$audioUrl && !empty($b64)) {
                    $uploaded = $this->_saveRecitationAudioB64($b64);
                    if ($uploaded) {
                        $audioUrl = $uploaded;
                        $uploadError = null;
                    } elseif (!$uploadError) {
                        $uploadError = 'Could not decode attached audio.';
                    }
                }
                $accuracy = $this->input->post('accuracy_score');
                $portion = $this->input->post('portion_mode') ?: 'FULL_SURAH';
                $ayahFrom = $this->input->post('ayah_from');
                $ayahTo = $this->input->post('ayah_to');
                $surahNum = (int) $this->input->post('surah_number');
                $milestoneId = (int) $this->input->post('milestone_id');
                if ($portion === 'FULL_SURAH') {
                    $ayahFrom = 1;
                    $ayahCounts = array(
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
                    $ayahTo = isset($ayahCounts[$surahNum]) ? $ayahCounts[$surahNum] : 1;
                } elseif ($portion === 'AYAH') {
                    $ayahFrom = (int) $ayahFrom ?: 1;
                    $ayahTo = $ayahFrom;
                }

                $cats = $this->academy_model->recitationCategories();
                $catKey = strtoupper(trim((string) $this->input->post('recitation_category')));
                if ($milestoneId < 1 && ($catKey === '' || !isset($cats[$catKey]))) {
                    set_alert('error', 'Select a Recitation Category before saving (Hifz Fauq, Talqeen, Murajaa…).');
                    redirect(base_url('academy_students'));
                }

                // Re-attach audio to an existing history chip
                if ($milestoneId > 0) {
                    if (!$audioUrl) {
                        set_alert('error', 'Record audio first, then Save to attach it to this milestone.');
                        redirect(base_url('academy_students'));
                    }
                    $ok = $this->academy_model->updateTahfizMilestone(
                        $milestoneId,
                        (int) $this->input->post('student_id'),
                        $branchID,
                        array(
                            'audio_url' => $audioUrl,
                            'video_url' => $this->input->post('video_url'),
                            'akhlaq_note' => $this->input->post('akhlaq_note'),
                            'recitation_category' => $this->input->post('recitation_category'),
                            'accuracy_score' => $accuracy,
                            'mistake_word_count' => $this->input->post('mistake_word_count'),
                            'recitation_seconds' => $this->input->post('recitation_seconds'),
                            'tarteel_status' => $accuracy !== '' && $accuracy !== null ? 'VERIFIED' : 'UNVERIFIED',
                        )
                    );
                    if (!$ok) {
                        set_alert('error', 'Could not attach audio to that milestone.');
                        redirect(base_url('academy_students'));
                    }
                    set_alert('success', 'Audio attached to milestone. Click the history chip (🔊) to play it.');
                    redirect(base_url('academy_students'));
                }

                $prior = $this->academy_model->priorMilestoneMessage(array(
                    'student_id' => $this->input->post('student_id'),
                    'instructor_id' => get_loggedin_user_id(),
                    'surah_number' => $surahNum,
                    'recitation_category' => $catKey,
                    'ayah_from' => $ayahFrom,
                    'ayah_to' => $ayahTo,
                    'completed_at' => date('Y-m-d H:i:s'),
                ));
                if ($prior !== '') {
                    set_alert('error', $prior);
                    redirect(base_url('academy_students'));
                }

                $newId = $this->academy_model->saveTahfiz(array(
                    'branch_id' => $branchID,
                    'student_id' => $this->input->post('student_id'),
                    'instructor_id' => get_loggedin_user_id(),
                    'surah_number' => $surahNum,
                    'portion_mode' => $portion,
                    'recitation_category' => $catKey,
                    'ayah_from' => $ayahFrom,
                    'ayah_to' => $ayahTo,
                    'page_from' => $this->input->post('page_from') !== '' && $this->input->post('page_from') !== null
                        ? (int) $this->input->post('page_from') : null,
                    'page_to' => $this->input->post('page_to') !== '' && $this->input->post('page_to') !== null
                        ? (int) $this->input->post('page_to') : null,
                    'verified' => 1,
                    'akhlaq_note' => $this->input->post('akhlaq_note'),
                    'completed_at' => date('Y-m-d H:i:s'),
                    'accuracy_score' => $accuracy,
                    'mistake_word_count' => $this->input->post('mistake_word_count'),
                    'mistake_breakdown' => $this->input->post('mistake_breakdown'),
                    'audio_url' => $audioUrl,
                    'video_url' => $this->input->post('video_url'),
                    'tarteel_status' => $accuracy !== '' && $accuracy !== null ? 'VERIFIED' : 'UNVERIFIED',
                    'recitation_seconds' => $this->input->post('recitation_seconds'),
                ));
                if (!$newId) {
                    $dbErr = $this->db->error();
                    set_alert('error', 'Could not save milestone' . (!empty($dbErr['message']) ? ': ' . $dbErr['message'] : '.'));
                    redirect(base_url('academy_students'));
                }
                $msg = $audioUrl
                    ? 'Surah milestone saved with audio. Re-open and click the 🔊 chip to play.'
                    : 'Surah milestone saved.';
                if ($uploadError) {
                    $msg .= ' (Audio upload skipped: ' . trim(strip_tags($uploadError)) . ')';
                } elseif (!$audioUrl) {
                    $msg .= ' No audio file was attached — record first, then Save.';
                }
                $progress = $this->academy_model->touchTeacherSession($branchID, (int) $this->input->post('student_id'), null, null, $catKey, (int) $newId);
                if ($progress) {
                    $msg .= ' ' . $progress;
                }
                set_alert('success', $msg);
                redirect(base_url('academy_students'));
            } else {
                set_alert('error', 'Select a student and surah before saving. ' . validation_errors(' ', ' '));
                redirect(base_url('academy_students'));
            }
        }

        if ($this->input->post('voice_drill')) {
            $parsed = $this->academy_model->parseVoiceCommand($this->input->post('transcript'), $branchID);
            if (!$parsed['success']) {
                set_alert('error', $parsed['message']);
                redirect(base_url('academy_students'));
            }
            if (!empty($parsed['surah_number']) && $parsed['pillar'] === 'QURAN' && $this->academy_model->tahfizReady()) {
                $this->academy_model->saveTahfiz(array(
                    'branch_id' => $branchID,
                    'student_id' => $parsed['student_id'],
                    'instructor_id' => get_loggedin_user_id(),
                    'surah_number' => $parsed['surah_number'],
                    'portion_mode' => 'FULL_SURAH',
                    'ayah_from' => null,
                    'ayah_to' => null,
                    'page_from' => null,
                    'page_to' => null,
                    'verified' => 1,
                    'akhlaq_note' => 'Logged via voice NLP',
                    'completed_at' => date('Y-m-d H:i:s'),
                ));
                set_alert('success', 'Voice NLP saved Tahfiz for ' . $parsed['student_name']);
            } elseif ($this->academy_model->drillsReady()) {
                $this->academy_model->saveDrill(array(
                    'branch_id' => $branchID,
                    'student_id' => $parsed['student_id'],
                    'evaluator_id' => get_loggedin_user_id(),
                    'pillar' => $parsed['pillar'],
                    'sub_category' => 'Voice NLP',
                    'score' => $parsed['score'],
                    'total_possible' => $parsed['total_possible'],
                    'time_seconds' => $parsed['time_seconds'],
                    'notes' => 'Voice: ' . $this->input->post('transcript'),
                ));
                set_alert('success', $parsed['message']);
            } else {
                set_alert('error', 'Academy tables not ready.');
            }
            redirect(base_url('academy_students'));
        }

        $roster = $this->academy_model->getCohortRoster($branchID);
        $featured = array_slice($roster, 0, 8);
        $activity_kpis = $this->academy_model->cohortActivityKpis($roster);
        $leaderboard = $this->academy_model->cohortLeaderboard($roster, 5);

        $rosterPayload = array();
        foreach ($roster as $st) {
            $recs = array();
            if (!empty($st['tahfiz_records'])) {
                foreach ($st['tahfiz_records'] as $r) {
                    $recs[] = array(
                        'id' => (int) $r->id,
                        'surah_number' => (int) $r->surah_number,
                        'surah_name' => (string) $r->surah_name,
                        'portion_mode' => (string) $r->portion_mode,
                        'recitation_category' => isset($r->recitation_category) ? (string) $r->recitation_category : null,
                        'ayah_from' => isset($r->ayah_from) ? $r->ayah_from : null,
                        'ayah_to' => isset($r->ayah_to) ? $r->ayah_to : null,
                        'page_from' => isset($r->page_from) ? $r->page_from : null,
                        'page_to' => isset($r->page_to) ? $r->page_to : null,
                        'akhlaq_note' => isset($r->akhlaq_note) ? $r->akhlaq_note : null,
                        'completed_at' => isset($r->completed_at) ? $r->completed_at : null,
                        'accuracy_score' => isset($r->accuracy_score) ? $r->accuracy_score : null,
                        'tarteel_status' => isset($r->tarteel_status) ? $r->tarteel_status : null,
                        'audio_url' => isset($r->audio_url) ? $r->audio_url : null,
                        'video_url' => isset($r->video_url) ? $r->video_url : null,
                        'recitation_seconds' => isset($r->recitation_seconds) ? $r->recitation_seconds : null,
                        'mistake_word_count' => isset($r->mistake_word_count) ? $r->mistake_word_count : null,
                    );
                }
            }
            $rosterPayload[] = array(
                'id' => (int) $st['id'],
                'fullname' => (string) $st['fullname'],
                'register_no' => (string) $st['register_no'],
                'class_level' => (string) $st['class_level'],
                'streak' => isset($st['streak']) ? (int) $st['streak'] : 0,
                'tahfiz_records' => $recs,
                'today_goal' => isset($st['today_goal_detail']) ? $st['today_goal_detail'] : null,
            );
        }

        $this->data['branch_id'] = $branchID;
        $this->data['roster'] = $roster;
        $this->data['roster_json'] = json_encode(
            $rosterPayload,
            JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_UNESCAPED_UNICODE
        );
        $this->data['featured'] = $featured;
        $this->data['activity_kpis'] = $activity_kpis;
        $this->data['activity_kpis_json'] = json_encode(
            $activity_kpis,
            JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT
        );
        $this->data['leaderboard'] = $leaderboard;
        $this->data['leaderboard_json'] = json_encode(
            $leaderboard,
            JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_UNESCAPED_UNICODE
        );
        $this->data['surahs'] = $this->academy_model->surahList();
        $this->data['portion_modes'] = $this->academy_model->portionModes();
        $this->data['recitation_categories'] = $this->academy_model->recitationCategories();
        $this->data['ready'] = $this->academy_model->tahfizReady();
        $this->data['has_media_consent'] = $this->db->field_exists('media_consent', 'student');
        $this->data['title'] = 'Academy Students';
        $this->data['sub_page'] = 'academy/students';
        $this->data['main_menu'] = 'academy';
        $this->load->view('layout/index', $this->data);
    }

    public function parse_voice()
    {
        if (!is_loggedin()) {
            echo json_encode(array('success' => false, 'message' => 'Not logged in'));
            return;
        }
        $branchID = $this->application_model->get_branch_id();
        $parsed = $this->academy_model->parseVoiceCommand($this->input->post('transcript'), $branchID);
        header('Content-Type: application/json');
        echo json_encode($parsed);
    }

    private function _uploadRecitationAudio()
    {
        $dir = FCPATH . 'uploads/academy_tahfiz/';
        if (!is_dir($dir)) {
            @mkdir($dir, 0755, true);
        }
        if (!is_file($dir . 'index.html')) {
            @file_put_contents($dir . 'index.html', '<!DOCTYPE html><title>403</title>');
        }
        $config = array(
            'upload_path' => $dir,
            'allowed_types' => 'mp3|wav|ogg|webm|m4a|mp4|mpeg|opus',
            'max_size' => 40960,
            'encrypt_name' => true,
            'detect_mime' => true,
        );
        $this->load->library('upload');
        $file = null;
        if ($this->upload->do_upload('audio_file')) {
            $data = $this->upload->data();
            $file = $data['full_path'];
        } else {
            // Retry without strict mime sniff (Chrome audio/webm often fails CI mime map)
            $config['detect_mime'] = false;
            $this->upload->initialize($config);
            if ($this->upload->do_upload('audio_file')) {
                $data = $this->upload->data();
                $file = $data['full_path'];
            }
        }

        if ($file) {
            $finalFile = $this->academy_model->convertToMp3($file, true);
            return base_url('uploads/academy_tahfiz/' . basename($finalFile));
        }
        return null;
    }

    /**
     * Proxy full-clip FastConformer final to VPS (or local :8001 on localhost).
     * Browser posts WAV here so HTTPS pages never hit http://VPS:8001 directly.
     */
    public function tarteel_final()
    {
        if (!is_loggedin() || is_student_loggedin() || is_parent_loggedin()) {
            $this->output->set_status_header(403)->set_content_type('application/json');
            echo json_encode(array('error' => 'forbidden'));
            return;
        }
        if (!function_exists('curl_init')) {
            $this->output->set_status_header(500)->set_content_type('application/json');
            echo json_encode(array('error' => 'curl missing'));
            return;
        }

        $this->config->load('tarteel', true);
        $cfg = $this->config->item('tarteel', 'tarteel');
        if (!is_array($cfg)) {
            $cfg = array();
        }
        $host = isset($_SERVER['HTTP_HOST']) ? strtolower((string) $_SERVER['HTTP_HOST']) : '';
        $isLocal = (strpos($host, 'localhost') !== false || strpos($host, '127.0.0.1') !== false);
        $upstream = $isLocal
            ? 'http://127.0.0.1:8001/v1/recite/final'
            : (isset($cfg['local_final_upstream']) && $cfg['local_final_upstream'] !== ''
                ? $cfg['local_final_upstream']
                : 'http://72.62.232.120:8002/v1/recite/final');

        $body = file_get_contents('php://input');
        if ($body === false || strlen($body) < 44) {
            $this->output->set_status_header(400)->set_content_type('application/json');
            echo json_encode(array('error' => 'wav required'));
            return;
        }

        $ch = curl_init($upstream);
        curl_setopt_array($ch, array(
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $body,
            CURLOPT_HTTPHEADER => array('Content-Type: audio/wav'),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CONNECTTIMEOUT => 12,
            CURLOPT_TIMEOUT => 180,
        ));
        $resp = curl_exec($ch);
        $code = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $err = curl_error($ch);
        curl_close($ch);

        $this->output->set_content_type('application/json');
        if ($resp === false) {
            $this->output->set_status_header(502);
            echo json_encode(array('error' => 'upstream unreachable', 'detail' => $err));
            return;
        }
        $this->output->set_status_header($code > 0 ? $code : 200);
        echo $resp;
    }

    private function _saveRecitationAudioB64($dataUrl)
    {
        if (!is_string($dataUrl) || strpos($dataUrl, 'base64,') === false) {
            return null;
        }
        list($meta, $b64) = explode('base64,', $dataUrl, 2);
        $bin = base64_decode($b64, true);
        if ($bin === false || strlen($bin) < 32) {
            return null;
        }
        $ext = 'webm';
        if (preg_match('#data:(audio|video)/([a-z0-9.+-]+)#i', $meta, $m)) {
            $ext = strtolower($m[2]);
            if ($ext === 'mpeg' || $ext === 'mp3') {
                $ext = 'mp3';
            } elseif ($ext === 'x-wav' || $ext === 'wave') {
                $ext = 'wav';
            } elseif ($ext === 'mp4' || $ext === 'x-m4a') {
                $ext = 'm4a';
            } elseif ($ext === 'ogg' || $ext === 'opus') {
                $ext = 'ogg';
            }
        }
        $allowed = array('mp3', 'wav', 'ogg', 'webm', 'm4a', 'mp4', 'opus');
        if (!in_array($ext, $allowed, true)) {
            $ext = 'webm';
        }
        $dir = FCPATH . 'uploads/academy_tahfiz/';
        if (!is_dir($dir)) {
            @mkdir($dir, 0755, true);
        }
        $name = 'rec_' . date('YmdHis') . '_' . substr(md5(uniqid('', true)), 0, 8) . '.' . $ext;
        $rawPath = $dir . $name;
        if (@file_put_contents($rawPath, $bin) === false) {
            return null;
        }
        $finalFile = $this->academy_model->convertToMp3($rawPath, true);
        return base_url('uploads/academy_tahfiz/' . basename($finalFile));
    }
}
