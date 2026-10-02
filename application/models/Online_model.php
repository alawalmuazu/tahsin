<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Online_model extends MY_Model
{
    public function ready()
    {
        return $this->db->field_exists('instruction_mode', 'enroll');
    }

    public function timezoneLabels()
    {
        return array(
            'Africa/Lagos' => 'Nigeria (Lagos / Abuja)',
            'Europe/London' => 'United Kingdom',
            'Europe/Paris' => 'Central Europe',
            'Europe/Berlin' => 'Germany',
            'America/New_York' => 'US Eastern',
            'America/Chicago' => 'US Central',
            'America/Denver' => 'US Mountain',
            'America/Los_Angeles' => 'US Pacific',
            'Asia/Dubai' => 'Gulf',
        );
    }

    public function roster($branchId)
    {
        if (!$this->ready()) {
            return array();
        }
        $sessionId = (int) get_session_id();
        $cols = 'e.id AS enroll_id, e.student_id, s.first_name, s.last_name, s.register_no, p.name AS parent_name';
        if ($this->db->field_exists('country', 'student')) {
            $cols .= ', s.country, s.timezone';
        }
        if ($this->db->field_exists('fee_naira', 'enroll')) {
            $cols .= ', e.fee_currency, e.fee_foreign, e.fee_rate, e.fee_naira';
        }
        $this->db->select($cols);
        $this->db->from('enroll e');
        $this->db->join('student s', 's.id = e.student_id', 'inner');
        $this->db->join('parent p', 'p.id = s.parent_id', 'left');
        $this->db->where('e.instruction_mode', 'online');
        $this->db->where('e.session_id', $sessionId);
        $this->db->where('e.branch_id', (int) $branchId);
        $this->db->order_by('s.first_name', 'ASC');
        $this->db->order_by('s.last_name', 'ASC');
        $rows = $this->db->get()->result();
        if (empty($rows)) {
            return array();
        }
        $paid = $this->tuitionPaid(array_map(function ($row) {
            return (int) $row->enroll_id;
        }, $rows));
        $this->load->model('school_fee_model');
        $labels = $this->timezoneLabels();
        $out = array();
        foreach ($rows as $row) {
            $fee = 0.0;
            $currency = isset($row->fee_currency) ? (string) $row->fee_currency : '';
            $foreign = isset($row->fee_foreign) ? (float) $row->fee_foreign : 0.0;
            $rate = isset($row->fee_rate) ? (float) $row->fee_rate : 0.0;
            $quote = '';
            $locked = isset($row->fee_naira) && (float) $row->fee_naira > 0;
            if ($locked) {
                $fee = (float) $row->fee_naira;
                $quote = $currency . ' ' . number_format($foreign, 2, '.', ',')
                    . ' × ' . number_format($rate, 2, '.', ',')
                    . ' locked in naira';
            } else {
                $quoteRow = $this->school_fee_model->quoteOnline(
                    $branchId,
                    isset($row->country) ? $row->country : '',
                    isset($row->timezone) ? $row->timezone : ''
                );
                $fee = (float) $quoteRow['naira'];
                $currency = $quoteRow['currency'];
                $foreign = (float) $quoteRow['foreign'];
                $rate = (float) $quoteRow['rate'];
                $quote = $quoteRow['error'] !== '' ? $quoteRow['error'] : $quoteRow['text'];
            }
            $paidNaira = isset($paid[(int) $row->enroll_id]) ? $paid[(int) $row->enroll_id] : 0.0;
            $balance = round($fee - $paidNaira, 2);
            if ($balance < 0.01) {
                $balance = 0.0;
            }
            $tz = isset($row->timezone) ? (string) $row->timezone : '';
            $out[] = array(
                'enroll_id' => (int) $row->enroll_id,
                'student_id' => (int) $row->student_id,
                'name' => trim($row->first_name . ' ' . $row->last_name),
                'register_no' => (string) $row->register_no,
                'parent' => (string) $row->parent_name,
                'country' => isset($row->country) ? (string) $row->country : '',
                'timezone' => $tz,
                'timezone_label' => isset($labels[$tz]) ? $labels[$tz] : $tz,
                'currency' => $currency,
                'foreign' => $foreign,
                'rate' => $rate,
                'fee' => $fee,
                'paid' => $paidNaira,
                'balance' => $balance,
                'quote' => $quote,
                'locked' => $locked,
            );
        }
        return $out;
    }

    public function income($branchId)
    {
        $students = $this->roster($branchId);
        $byCurrency = array();
        $billed = 0.0;
        $collected = 0.0;
        $outstanding = 0.0;
        foreach ($students as $row) {
            $code = $row['currency'] !== '' ? $row['currency'] : '—';
            if (!isset($byCurrency[$code])) {
                $byCurrency[$code] = array(
                    'currency' => $code,
                    'students' => 0,
                    'foreign' => 0.0,
                    'billed' => 0.0,
                    'collected' => 0.0,
                    'outstanding' => 0.0,
                );
            }
            $byCurrency[$code]['students']++;
            $byCurrency[$code]['foreign'] += (float) $row['foreign'];
            $byCurrency[$code]['billed'] += (float) $row['fee'];
            $byCurrency[$code]['collected'] += (float) $row['paid'];
            $byCurrency[$code]['outstanding'] += (float) $row['balance'];
            $billed += (float) $row['fee'];
            $collected += (float) $row['paid'];
            $outstanding += (float) $row['balance'];
        }
        ksort($byCurrency);
        return array(
            'students' => $students,
            'by_currency' => array_values($byCurrency),
            'billed' => $billed,
            'collected' => $collected,
            'outstanding' => $outstanding,
        );
    }

    public function classes($branchId)
    {
        $board = array(
            'ready' => false,
            'groups' => array(),
            'unassigned' => array(),
        );
        if (!$this->ready()) {
            return $board;
        }
        $this->load->model('academy_model');
        if (!$this->academy_model->groupsReady()) {
            return $board;
        }
        $board['ready'] = true;
        $sessionId = (int) get_session_id();
        $hasSchedule = $this->db->field_exists('meeting_url', 'academy_teacher_group');
        $cols = 'g.id, g.name, g.teacher_id, st.name AS teacher_name';
        if ($hasSchedule) {
            $cols .= ', g.starts_at_lagos, g.duration_minutes, g.meeting_url';
        }
        $groups = $this->db->select($cols)
            ->from('academy_teacher_group g')
            ->join('staff st', 'st.id = g.teacher_id', 'left')
            ->where('g.branch_id', (int) $branchId)
            ->where('g.session_id', $sessionId)
            ->order_by('g.name', 'ASC')
            ->get()->result();
        $members = $this->db->select('m.group_id, m.student_id, s.first_name, s.last_name, e.id AS enroll_id, e.instruction_mode')
            ->from('academy_teacher_group_member m')
            ->join('academy_teacher_group g', 'g.id = m.group_id', 'inner')
            ->join('student s', 's.id = m.student_id', 'inner')
            ->join('enroll e', 'e.student_id = s.id AND e.session_id = g.session_id AND e.branch_id = g.branch_id', 'left', false)
            ->where('g.branch_id', (int) $branchId)
            ->where('g.session_id', $sessionId)
            ->order_by('s.first_name', 'ASC')
            ->get()->result();
        $enrollIds = array();
        $byGroup = array();
        foreach ($members as $member) {
            $byGroup[(int) $member->group_id][] = $member;
            if ((int) $member->enroll_id > 0) {
                $enrollIds[(int) $member->enroll_id] = (int) $member->enroll_id;
            }
        }
        $today = $this->todayPresence($enrollIds);
        $placed = array();
        foreach ($groups as $group) {
            $list = isset($byGroup[(int) $group->id]) ? $byGroup[(int) $group->id] : array();
            $onlineMembers = array();
            foreach ($list as $member) {
                if ($member->instruction_mode !== 'online') {
                    continue;
                }
                $placed[(int) $member->student_id] = true;
                $presence = isset($today[(int) $member->enroll_id]) ? $today[(int) $member->enroll_id] : '';
                $onlineMembers[] = array(
                    'name' => trim($member->first_name . ' ' . $member->last_name),
                    'enroll_id' => (int) $member->enroll_id,
                    'presence' => $this->presenceLabel($presence),
                );
            }
            $url = $hasSchedule ? (string) $group->meeting_url : '';
            if ($url === '' && empty($onlineMembers)) {
                continue;
            }
            $mins = $hasSchedule ? (int) $group->duration_minutes : 0;
            if ($mins < 1) {
                $mins = 45;
            }
            $lagos = '';
            if ($hasSchedule && !empty($group->starts_at_lagos)) {
                $start = DateTime::createFromFormat('H:i:s', (string) $group->starts_at_lagos);
                if (!$start) {
                    $start = DateTime::createFromFormat('H:i', substr((string) $group->starts_at_lagos, 0, 5));
                }
                if ($start) {
                    $end = clone $start;
                    $end->modify('+' . $mins . ' minutes');
                    $lagos = $start->format('g:i A') . '–' . $end->format('g:i A') . ' Lagos';
                }
            }
            $board['groups'][] = array(
                'id' => (int) $group->id,
                'name' => (string) $group->name,
                'teacher' => (string) $group->teacher_name,
                'lagos' => $lagos !== '' ? $lagos : 'Lagos time not set',
                'url' => $url,
                'members' => $onlineMembers,
            );
        }
        foreach ($this->roster($branchId) as $student) {
            if (!isset($placed[$student['student_id']])) {
                $board['unassigned'][] = $student;
            }
        }
        return $board;
    }

    public function homeForStudent($studentId)
    {
        $studentId = (int) $studentId;
        if ($studentId < 1 || !$this->ready()) {
            return null;
        }
        $cols = 'e.id AS enroll_id';
        if ($this->db->field_exists('country', 'student')) {
            $cols .= ', s.country, s.timezone';
        }
        $enroll = $this->db->select($cols)
            ->from('enroll e')
            ->join('student s', 's.id = e.student_id', 'inner')
            ->where('e.student_id', $studentId)
            ->where('e.session_id', (int) get_session_id())
            ->where('e.instruction_mode', 'online')
            ->order_by('e.id', 'DESC')
            ->limit(1)
            ->get()->row();
        if (!$enroll) {
            return null;
        }
        $this->load->model('student_model');
        $this->load->model('academy_model');
        $summary = $this->student_model->getTuitionSummary((int) $enroll->enroll_id);
        $tz = isset($enroll->timezone) ? (string) $enroll->timezone : '';
        $labels = $this->timezoneLabels();
        return array(
            'country' => isset($enroll->country) ? (string) $enroll->country : '',
            'timezone' => $tz,
            'timezone_label' => isset($labels[$tz]) ? $labels[$tz] : $tz,
            'meetings' => $this->academy_model->onlineMeetingsForStudent($studentId),
            'fee' => (float) $summary['fee'],
            'paid' => (float) $summary['paid'],
            'balance' => (float) $summary['balance'],
            'quote' => (string) $summary['quote'],
        );
    }

    protected function tuitionPaid($enrollIds)
    {
        $enrollIds = array_values(array_filter(array_map('intval', (array) $enrollIds)));
        if (empty($enrollIds)) {
            return array();
        }
        $rows = $this->db->select('a.student_id AS enroll_id, SUM(h.amount) AS paid', false)
            ->from('fee_allocation a')
            ->join('fee_payment_history h', 'h.allocation_id = a.id', 'inner')
            ->join('fees_type t', 't.id = h.type_id', 'left')
            ->where_in('a.student_id', $enrollIds)
            ->group_start()
            ->where('t.fee_code', 'tuition')
            ->or_where('t.name', 'Tuition')
            ->group_end()
            ->group_by('a.student_id')
            ->get()->result();
        $out = array();
        foreach ($rows as $row) {
            $out[(int) $row->enroll_id] = (float) $row->paid;
        }
        return $out;
    }

    protected function todayPresence($enrollIds)
    {
        $enrollIds = array_values(array_filter(array_map('intval', (array) $enrollIds)));
        if (empty($enrollIds) || !$this->db->table_exists('student_attendance')) {
            return array();
        }
        $rows = $this->db->select('enroll_id, remark, status')
            ->where('date', date('Y-m-d'))
            ->where_in('enroll_id', $enrollIds)
            ->get('student_attendance')->result();
        $out = array();
        foreach ($rows as $row) {
            $out[(int) $row->enroll_id] = (string) $row->remark;
        }
        return $out;
    }

    protected function presenceLabel($remark)
    {
        if ($remark === 'Joined online class') {
            return 'Joined';
        }
        if ($remark === 'Recitation saved') {
            return 'Recitation saved';
        }
        if ($remark !== '') {
            return $remark;
        }
        return 'Not yet today';
    }
}
