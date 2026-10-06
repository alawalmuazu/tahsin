<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Student_model extends MY_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    // moderator student all information
    public function save($data = array(), $getBranch = array())
    {
        $hostelID = empty($data['hostel_id']) ? 0 : $data['hostel_id'];
        $roomID = empty($data['room_id']) ? 0 : $data['room_id'];

        $previous_details = array(
            'school_name' => $this->input->post('school_name'),
            'qualification' => $this->input->post('qualification'),
            'remarks' => $this->input->post('previous_remarks'),
        );
        if (empty($previous_details)) {
            $previous_details = "";
        } else {
            $previous_details = json_encode($previous_details);
        }

        $register_no = isset($data['register_no']) ? trim((string) $data['register_no']) : trim((string) $this->input->post('register_no'));
        $inser_data1 = array(
            'register_no' => $register_no,
            'admission_date' => (!empty($data['admission_date']) ? date("Y-m-d", strtotime($data['admission_date'])) : ""),
            'first_name' => $this->input->post('first_name'),
            'other_name' => trim((string) $this->input->post('other_name')),
            'last_name' => $this->input->post('last_name'),
            'gender' => $this->input->post('gender'),
            'birthday' => (!empty($data['birthday']) ? date("Y-m-d", strtotime($data['birthday'])) : ""),
            'religion' => $this->input->post('religion'),
            'caste' => $this->input->post('caste'),
            'blood_group' => $this->input->post('blood_group'),
            'mother_tongue' => $this->input->post('mother_tongue'),
            'current_address' => $this->input->post('current_address'),
            'permanent_address' => $this->input->post('permanent_address'),
            'city' => $this->input->post('lga') !== null && $this->input->post('lga') !== '' ? $this->input->post('lga') : $this->input->post('city'),
            'state' => $this->input->post('state'),
            'mobileno' => $this->input->post('mobileno'),
            'category_id' => (isset($data['category_id']) ? $data['category_id'] : 0),
            'email' => $this->input->post('email'),
            'parent_id' => $this->input->post('parent_id'),
            'route_id' => (empty($this->input->post('route_id')) ? 0 : $this->input->post('route_id')),
            'vehicle_id' => (empty($this->input->post('vehicle_id')) ? 0 : $this->input->post('vehicle_id')),
            'stoppage_point_id' => (empty($this->input->post('stoppage_point_id')) ? null : $this->input->post('stoppage_point_id')),
            'hostel_id' => $hostelID,
            'room_id' => $roomID,
            'previous_details' => $previous_details,
            'photo' => $this->storeStudentPhoto('user_photo'),
            'nin' => preg_replace('/[^0-9]/', '', $this->input->post('nin')),
        );

        if ($this->db->field_exists('pwd_category_id', 'student')) {
            $inser_data1['pwd_category_id'] = isset($data['pwd_category_id']) && $data['pwd_category_id'] !== ''
                ? (int) $data['pwd_category_id']
                : null;
        }
        if ($this->db->field_exists('country', 'student')) {
            $inser_data1['country'] = mb_substr(trim((string) $this->input->post('country')), 0, 80);
        }
        if ($this->db->field_exists('timezone', 'student')) {
            $tz = trim((string) $this->input->post('timezone'));
            $inser_data1['timezone'] = $tz !== '' ? mb_substr($tz, 0, 64) : 'Africa/Lagos';
        }

        // moderator guardian all information
        if (!isset($data['student_id']) && empty($data['student_id'])) {
            $grd_username = '';
            $grd_password = '';
            if (!isset($data['guardian_chk'])) {
                // add new guardian all information in db
                if (!empty($data['grd_name']) || !empty($data['father_name'])) {
                    $arrayParent = array(
                        'name' => $this->input->post('grd_name'),
                        'relation' => $this->input->post('grd_relation'),
                        'father_name' => $this->input->post('father_name'),
                        'mother_name' => $this->input->post('mother_name'),
                        'occupation' => $this->input->post('grd_occupation'),
                        'income' => $this->input->post('grd_income'),
                        'education' => $this->input->post('grd_education'),
                        'email' => $this->input->post('grd_email'),
                        'mobileno' => $this->input->post('grd_mobileno'),
                        'address' => $this->input->post('grd_address'),
                        'city' => $this->input->post('grd_lga') !== null && $this->input->post('grd_lga') !== '' ? $this->input->post('grd_lga') : $this->input->post('grd_city'),
                        'state' => $this->input->post('grd_state'),
                        'branch_id' => $this->application_model->get_branch_id(),
                        'photo' => $this->uploadImage('parent', 'guardian_photo'),
                    );
                    if ($this->db->field_exists('extra_phones', 'parent')) {
                        $phones = $this->input->post('extra_phones');
                        $clean = array();
                        if (is_array($phones)) {
                            foreach ($phones as $phone) {
                                $phone = trim((string) $phone);
                                if ($phone !== '') {
                                    $clean[] = $phone;
                                }
                            }
                        }
                        $arrayParent['extra_phones'] = json_encode(array_values($clean));
                    }
                    $this->db->insert('parent', $arrayParent);
                    $parentID = $this->db->insert_id();

                    if (!empty($getBranch['grd_generate'])) {
                        $grd_username = $this->app_lib->uniqueLoginUsername(($getBranch['grd_username_prefix'] ?: 'parent_') . $parentID);
                        $grd_password = !empty($getBranch['grd_default_password']) ? $getBranch['grd_default_password'] : $this->app_lib->defaultPasswordForRole(6);
                        $parent_credential = array(
                            'user_id' => $parentID,
                            'role' => 6,
                            'username' => $grd_username,
                            'password' => $this->app_lib->pass_hashed($grd_password),
                            'active' => 1,
                            'must_change_password' => 1,
                        );
                        $this->db->insert('login_credential', $parent_credential);
                    }
                } else {
                    $parentID = 0;
                }
            } else {
                $parentID = $data['parent_id'];
            }

            $inser_data1['parent_id'] = $parentID;
            // insert student all information in the database
            $this->db->insert('student', $inser_data1);
            $student_id = $this->db->insert_id();
            if (empty($student_id) || !$this->db->get_where('student', array('id' => $student_id))->row()) {
                show_error('Student record was not created. Please try again or contact support.', 500, 'Admission Error');
            }

            // Auto-generate the academy student ID: TA-{YEAR}-{ZERO_PADDED_ID}
            $academy_student_id = 'TA-' . date('Y') . '-' . str_pad($student_id, 5, '0', STR_PAD_LEFT);
            $this->db->where('id', $student_id)->update('student', ['state_student_id' => $academy_student_id]);

            if (!empty($getBranch['stu_generate'])) {
                $stu_username = $this->app_lib->uniqueLoginUsername(($getBranch['stu_username_prefix'] ?: 'student_') . $student_id);
                $stu_password = !empty($getBranch['stu_default_password']) ? $getBranch['stu_default_password'] : $this->app_lib->defaultPasswordForRole(7);
            } else {
                $stu_username = $this->app_lib->uniqueLoginUsername(trim((string) $this->input->post('username')));
                $stu_password = (string) $this->input->post('password');
            }
            $inser_data2 = array(
                'user_id' => $student_id,
                'role' => 7,
                'username' => $stu_username,
                'password' => $this->app_lib->pass_hashed($stu_password),
                'active' => 1,
                'must_change_password' => 1,
            );
            $this->db->insert('login_credential', $inser_data2);

            // return student information
            $studentData = array(
                'student_id' => $student_id,
                'email' => $this->input->post('email'),
                'username' => $stu_username,
                'password' => $stu_password,
            );

            if (!empty($grd_username) && !empty($grd_password) && !empty($this->input->post('grd_email'))) {
                $emailData = array(
                    'name' => $this->input->post('grd_name'),
                    'username' => $grd_username,
                    'password' => $grd_password,
                    'user_role' => 6,
                    'email' => $this->input->post('grd_email'),
                );
                $this->email_model->sentStaffRegisteredAccount($emailData);
            }
            return $studentData;
        } else {
            // update student all information in the database
            $inser_data1['parent_id'] = $data['parent_id'];
            $existing = $this->db->select('register_no')->where('id', $data['student_id'])->get('student')->row();
            if ($existing && !empty($existing->register_no)) {
                $inser_data1['register_no'] = $existing->register_no;
            }
            // preserve state_student_id and update nin only
            $nin_val = preg_replace('/[^0-9]/', '', $this->input->post('nin'));
            if ($nin_val !== false && strlen($nin_val) <= 11) {
                $inser_data1['nin'] = $nin_val;
            }
            $this->db->where('id', $data['student_id']);
            $this->db->update('student', $inser_data1);


            // update login credential information in the database
            $this->db->where('user_id', $data['student_id']);
            $this->db->where('role', 7);
            $this->db->update('login_credential', array('username' => $data['username']));
        }
    }

    public function csvImport($row = array(), $classID = '', $sectionID = '', $branchID = '')
    {
        // getting existing father data
        if (!empty($row['GuardianEmail'])) {
            $getParent = $this->db->select('id')
                ->from('parent')
                ->where(array('branch_id' => $branchID, 'email' => $row['GuardianEmail']))
                ->get()->row_array();
        }

        // getting branch settings
        $getSettings = $this->db->select('*')
            ->where('id', $branchID)
            ->from('branch')
            ->get()->row_array();

        if (isset($getParent) && count($getParent)) {
            $parentID = $getParent['id'];
        } else {
            // add new guardian all information in db
            $arrayParent = array(
                'name' => $row['GuardianName'],
                'relation' => $row['GuardianRelation'],
                'age' => isset($row['GuardianAge']) ? $row['GuardianAge'] : null,
                'father_name' => $row['FatherName'],
                'mother_name' => $row['MotherName'],
                'occupation' => $row['GuardianOccupation'],
                'mobileno' => $row['GuardianMobileNo'],
                'address' => $row['GuardianAddress'],
                'email' => $row['GuardianEmail'],
                'branch_id' => $branchID,
                'photo' => 'defualt.png',
            );
            $this->db->insert('parent', $arrayParent);
            $parentID = $this->db->insert_id();

            $grd_email = trim((string) $row['GuardianEmail']);
            $parent_credential = $this->app_lib->buildPortalCredential(6, $parentID, $grd_email !== '' ? $grd_email : ('parent' . $parentID), false);
            $this->db->insert('login_credential', $parent_credential);
        }

        $inser_data1 = array(
            'first_name' => $row['FirstName'],
            'last_name' => $row['LastName'],
            'blood_group' => $row['BloodGroup'],
            'gender' => $row['Gender'],
            'birthday' => date("Y-m-d", strtotime($row['Birthday'])),
            'mother_tongue' => $row['MotherTongue'],
            'religion' => $row['Religion'],
            'parent_id' => $parentID,
            'caste' => $row['Caste'],
            'mobileno' => $row['Phone'],
            'city' => $row['City'],
            'state' => $row['State'],
            'current_address' => $row['PresentAddress'],
            'permanent_address' => $row['PermanentAddress'],
            'category_id' => $row['CategoryID'],
            'admission_date' => date("Y-m-d", strtotime($row['AdmissionDate'])),
            'register_no' => $row['RegisterNo'],
            'photo' => 'defualt.png',
            'email' => $row['StudentEmail'],
        );

        //save all student information in the database file
        $this->db->insert('student', $inser_data1);
        $studentID = $this->db->insert_id();

        $stu_username = $this->app_lib->studentPortalUsername($row['RegisterNo'], $studentID);
        $inser_data2 = $this->app_lib->buildPortalCredential(7, $studentID, $stu_username, false);
        $this->db->insert('login_credential', $inser_data2);

        //save student enroll information in the database file
        $arrayEnroll = array(
            'student_id' => $studentID,
            'class_id' => $classID,
            'section_id' => $sectionID,
            'branch_id' => $branchID,
            'roll' => $row['Roll'],
            'session_id' => get_session_id(),
        );
        $this->db->insert('enroll', $arrayEnroll);
    }

    public function getFeeProgress($id)
    {
        $this->db->select('IFNULL(SUM(gd.amount), 0) as totalfees,IFNULL(SUM(p.amount), 0) as totalpay,IFNULL(SUM(p.discount),0) as totaldiscount');
        $this->db->from('fee_allocation as a');
        $this->db->join('fee_groups_details as gd', 'gd.fee_groups_id = a.group_id', 'inner');
        $this->db->join('fee_payment_history as p', 'p.allocation_id = a.id and p.type_id = gd.fee_type_id', 'left');
        $this->db->where('a.student_id', $id);
        $this->db->where('a.session_id', get_session_id());
        $r = $this->db->get()->row_array();
        $total_amount = floatval($r['totalfees']);
        $total_paid = floatval($r['totalpay'] + $r['totaldiscount']);
        if ($total_paid != 0) {
            $percentage = ($total_paid / $total_amount) * 100;
            return number_format($percentage);
        } else {
            return 0;
        }
    }

    public function getStudentList($classID = '', $sectionID = '', $branchID = '', $deactivate = false, $start = '', $end = '')
    {
        $this->db->select('e.*,s.photo, TRIM(CONCAT_WS(" ", s.first_name, NULLIF(s.other_name,""), s.last_name)) as fullname,s.register_no,s.gender,s.admission_date,s.parent_id,s.email,s.blood_group,s.birthday,l.active,c.name as class_name,se.name as section_name');
        $this->db->from('enroll as e');
        $this->db->join('student as s', 'e.student_id = s.id', 'inner');
        $this->db->join('login_credential as l', 'l.user_id = s.id and l.role = 7', 'inner');
        $this->db->join('class as c', 'e.class_id = c.id', 'left');
        $this->db->join('section as se', 'e.section_id=se.id', 'left');
        if (!empty($classID)) {
            $this->db->where('e.class_id', $classID);
        }
        if (!empty($start) && !empty($end)) {
            $this->db->where('s.admission_date >=', $start);
            $this->db->where('s.admission_date <=', $end);
        }
        $this->db->where('e.branch_id', $branchID);
        $this->db->where('e.session_id', get_session_id());
        $this->db->order_by('s.id', 'ASC');
        if ($sectionID != 'all' && !empty($sectionID)) {
            $this->db->where('e.section_id', $sectionID);
        }
        if ($deactivate == true) {
            $this->db->where('l.active', 0);
        }
        return $this->db->get();
    }

    protected function phoneSearchDigits($search_text)
    {
        $raw = trim((string) $search_text);
        if ($raw === '' || !preg_match('/^[\d\s+\-().]+$/', $raw)) {
            return '';
        }
        $digits = preg_replace('/\D+/', '', $raw);
        return strlen($digits) >= 4 ? $digits : '';
    }

    protected function orWherePhoneDigits($column, $digits)
    {
        $safe = $this->db->escape_like_str($digits);
        $this->db->or_where(
            "REPLACE(REPLACE(REPLACE(REPLACE(IFNULL({$column},''), ' ', ''), '-', ''), '+', ''), '.', '') LIKE '%{$safe}%' ESCAPE '!'",
            null,
            false
        );
    }

    public function getSearchStudentList($search_text)
    {
        $this->db->select('e.*,s.photo,s.first_name,s.last_name,s.register_no,s.parent_id,s.email,s.blood_group,s.birthday,c.name as class_name,se.name as section_name,sp.name as parent_name');
        $this->db->from('enroll as e');
        $this->db->join('student as s', 'e.student_id = s.id', 'left');
        $this->db->join('class as c', 'e.class_id = c.id', 'left');
        $this->db->join('section as se', 'e.section_id=se.id', 'left');
        $this->db->join('parent as sp', 'sp.id = s.parent_id', 'left');
        $this->db->where('e.session_id', get_session_id());
        if (!is_superadmin_loggedin()) {
            $this->db->where('e.branch_id', get_loggedin_branch_id());
        }
        $this->db->group_start();
        $this->db->like('s.first_name', $search_text);
        $this->db->or_like('s.last_name', $search_text);
        $this->db->or_like('s.register_no', $search_text);
        $this->db->or_like('s.email', $search_text);
        $this->db->or_like('e.roll', $search_text);
        $this->db->or_like('s.blood_group', $search_text);
        $this->db->or_like('sp.name', $search_text);
        $this->db->or_like('s.mobileno', $search_text);
        $this->db->or_like('sp.mobileno', $search_text);
        if ($this->db->field_exists('extra_phones', 'parent')) {
            $this->db->or_like('sp.extra_phones', $search_text);
        }
        $phoneDigits = $this->phoneSearchDigits($search_text);
        if ($phoneDigits !== '') {
            $this->orWherePhoneDigits('s.mobileno', $phoneDigits);
            $this->orWherePhoneDigits('sp.mobileno', $phoneDigits);
            if ($this->db->field_exists('extra_phones', 'parent')) {
                $this->orWherePhoneDigits('sp.extra_phones', $phoneDigits);
            }
        }
        $this->db->group_end();
        $this->db->order_by('s.id', 'desc');
        return $this->db->get();
    }

    public function getSingleStudent($id = '', $enroll = false)
    {
        $this->db->select('s.*,l.username,l.active,e.class_id,e.section_id,e.id as enrollid,e.roll,e.branch_id,e.session_id,c.name as class_name,se.name as section_name,sc.name as category_name'
            . ($this->db->field_exists('instruction_mode', 'enroll') ? ',e.instruction_mode' : ''));
        $this->db->from('enroll as e');
        $this->db->join('student as s', 'e.student_id = s.id', 'left');
        $this->db->join('login_credential as l', 'l.user_id = s.id and l.role = 7', 'inner');
        $this->db->join('class as c', 'e.class_id = c.id', 'left');
        $this->db->join('section as se', 'e.section_id = se.id', 'left');
        $this->db->join('student_category as sc', 's.category_id=sc.id', 'left');
        if ($enroll == true) {
            $this->db->where('e.id', $id);
        } else {
            $this->db->where('s.id', $id);
        }
        $this->db->where('e.session_id', get_session_id());
        if (!is_superadmin_loggedin()) {
            $this->db->where('e.branch_id', get_loggedin_branch_id());
        }
        $query = $this->db->get();
        if ($query->num_rows() == 0) {
            show_404();
        }
        return $query->row_array();
    }

    public function regSerNumber($school_id = '')
    {
        $registerNoPrefix = '';
        if (!empty($school_id)) {
            $schoolconfig = $this->db->select('reg_prefix_enable,reg_start_from,institution_code,reg_prefix_digit')->where(array('id' => $school_id))->get('branch')->row();
            if ($schoolconfig->reg_prefix_enable == 1) {
                $registerNoPrefix = $schoolconfig->institution_code . $schoolconfig->reg_start_from;
                $last_registerNo = $this->app_lib->studentLastRegID($school_id);
                if (!empty($last_registerNo)) {
                    $last_registerNo_digit = str_replace($schoolconfig->institution_code, "", $last_registerNo->register_no);
                    if (!is_numeric($last_registerNo_digit)) {
                        $last_registerNo_digit = $schoolconfig->reg_start_from;
                    } else {
                        $last_registerNo_digit = $last_registerNo_digit + 1;
                    }
                    $registerNoPrefix = $schoolconfig->institution_code . sprintf("%0" . $schoolconfig->reg_prefix_digit . "d", $last_registerNo_digit);
                } else {
                    $registerNoPrefix = $schoolconfig->institution_code . sprintf("%0" . $schoolconfig->reg_prefix_digit . "d", $schoolconfig->reg_start_from);
                }
            }
            return $registerNoPrefix;
        } else {
            $config = $this->db->select('institution_code,reg_prefix')->where(array('id' => 1))->get('global_settings')->row();
            if ($config->reg_prefix == 'on') {
                $prefix = $config->institution_code;
            }
            $result = $this->db->select("max(id) as id")->get('student')->row_array();
            $id = $result["id"];
            if (!empty($id)) {
                $maxNum = str_pad($id + 1, 5, '0', STR_PAD_LEFT);
            } else {
                $maxNum = '00001';
            }
            return ($prefix . $maxNum);
        }
    }

    public function allocateRegisterNo($school_id = '')
    {
        $candidate = trim((string) $this->regSerNumber($school_id));
        if ($candidate === '') {
            $next = (int) $this->db->select('MAX(id) as id')->get('student')->row()->id + 1;
            $candidate = 'TA-' . date('Y') . '-' . str_pad($next, 5, '0', STR_PAD_LEFT);
        }
        $i = 0;
        $original = $candidate;
        while ($this->db->where('register_no', $candidate)->count_all_results('student') > 0) {
            $i++;
            if (preg_match('/^(.*?)(\d+)$/', $original, $m)) {
                $candidate = $m[1] . str_pad((int) $m[2] + $i, strlen($m[2]), '0', STR_PAD_LEFT);
            } else {
                $candidate = $original . '-' . $i;
            }
            if ($i > 9999) {
                $candidate = 'TA-' . date('Y') . '-' . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
            }
        }
        return $candidate;
    }

    public function allocateRoll($class_id, $section_id, $branch_id, $session_id)
    {
        $unique_roll = 1;
        $settings = $this->db->select('unique_roll')->where('id', (int) $branch_id)->get('branch')->row();
        if ($settings) {
            $unique_roll = (int) $settings->unique_roll;
        }
        $this->db->select('MAX(CAST(roll AS UNSIGNED)) AS max_roll', false);
        $this->db->from('enroll');
        $this->db->where('class_id', (int) $class_id);
        $this->db->where('branch_id', (int) $branch_id);
        $this->db->where('session_id', (int) $session_id);
        if ($unique_roll === 2) {
            $this->db->where('section_id', (int) $section_id);
        }
        $row = $this->db->get()->row();
        return ((int) ($row ? $row->max_roll : 0)) + 1;
    }

    public function getDisableReason($student_id = '')
    {
        $this->db->select("rd.*,disable_reason.name as reason");
        $this->db->from('disable_reason_details as rd');
        $this->db->join('disable_reason', 'disable_reason.id = rd.reason_id', 'left');
        $this->db->where('student_id', $student_id);
        $this->db->order_by('rd.id', 'DESC');
        $this->db->limit(1);
        $row = $this->db->get()->row();
        return $row;
    }

    public function getSiblingList($parent_id = '', $student_id = '')
    {
        $this->db->select('s.photo, s.register_no, TRIM(CONCAT_WS(" ",s.first_name, NULLIF(s.other_name,""), s.last_name)) as fullname,s.gender,s.mobileno,e.roll,e.branch_id,c.name as class_name,se.name as section_name');
        $this->db->from('enroll as e');
        $this->db->join('student as s', 'e.student_id = s.id', 'inner');
        $this->db->join('class as c', 'e.class_id = c.id', 'left');
        $this->db->join('section as se', 'e.section_id = se.id', 'left');
        $this->db->where_not_in('s.id', $student_id);
        $this->db->where('s.parent_id', $parent_id);
        $this->db->order_by('s.id', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    public function getParentList($class_id = '', $section_id = '', $branch_id = '')
    {
        $this->db->select('p.name as g_name,p.father_name,p.mother_name,p.occupation,count(s.parent_id) as child,p.mobileno,s.parent_id');
        $this->db->from('student as s');
        $this->db->join('enroll as e', 'e.student_id = s.id', 'inner');
        $this->db->join('parent as p', 'p.id = s.parent_id', 'inner');
        $this->db->where('e.class_id', $class_id);
        if ($section_id != 'all') {
            $this->db->where('e.section_id', $section_id);
        }
        $this->db->where('e.branch_id', $branch_id);
        $this->db->where('e.session_id', get_session_id());
        $this->db->order_by('s.id', 'ASC');
        $this->db->group_by('p.id');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getSiblingListByClass($parent_id = '', $class_id = '', $section_id = '')
    {
        $this->db->select('s.register_no,e.id as enroll_id,TRIM(CONCAT_WS(" ",s.first_name, NULLIF(s.other_name,""), s.last_name)) as fullname,s.gender,c.name as class_name,se.name as section_name');
        $this->db->from('enroll as e');
        $this->db->join('student as s', 'e.student_id = s.id', 'inner');
        $this->db->join('class as c', 'e.class_id = c.id', 'left');
        $this->db->join('section as se', 'e.section_id = se.id', 'left');
        $this->db->where('e.class_id', $class_id);
        if ($section_id != 'all') {
            $this->db->where('e.section_id', $section_id);
        }
        $this->db->where('e.session_id', get_session_id());
        $this->db->where('s.parent_id', $parent_id);
        $this->db->order_by('s.id', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    public function studentListDT()
    {
        $branchID = $this->application_model->get_branch_id();
        $sectionID = $this->input->post('section_id');
        $categoryID = $this->input->post('category_id');
        $sessionID = get_session_id();

        // system fields validation rules
        $validArr = array();
        $validationArr = $this->student_fields_model->getStatusArr($branchID);
        foreach ($validationArr as $key => $value) {
            $validArr[$value->prefix] = (empty($value->status) ? 0 : 1);
        }

        // getting a list of classes assigned to a teacher
        $assigned_cs_list = $this->app_lib->get_ownClassSection();

        // custom fields data
        $i = 1;
        $field_sel_array = array();
        $field_val_array = array();
        $show_custom_fields = custom_form_table('student', $branchID);
        if (!empty($show_custom_fields)) {
            foreach ($show_custom_fields as $key => $fields) {
                $ctb_counter = "table_custom_" . $i;
                $field_sel_array[] = $ctb_counter . '.value as cfid_' . $fields['id'];
                $field_val_array[] = $ctb_counter . '.value';
                $this->datatables->join('custom_fields_values as ' . $ctb_counter, 'enroll.student_id = ' . $ctb_counter . '.relid AND ' . $ctb_counter . '.field_id = ' . $fields['id'], 'left');
                $i++;
            }
        }
        $field_select = (empty($field_sel_array)) ? "" : "," . implode(',', $field_sel_array);
        $custom_fields_column_order = (empty($field_val_array)) ? "" : "," . implode(',', $field_val_array);

        $guardianExtraSelect = $this->db->field_exists('extra_phones', 'parent') ? ',parent.extra_phones as guardian_extra_phones' : '';
        // Database query
        $this->datatables->select('enroll.*,TRIM(CONCAT_WS(" ",student.first_name, NULLIF(student.other_name,""), student.last_name)) as fullname,student.photo,student.mobileno,student.admission_date,student.gender,student.register_no,student.birthday,enroll.roll,class.name as class_name,student.parent_id,section.name as section_name,student_category.name as category,parent.name as guardian_name,parent.mobileno as guardian_mobileno' . $guardianExtraSelect . $field_select);
        $this->datatables->from('enroll');
        $this->datatables->join('student', 'student.id = enroll.student_id', 'inner');
        $this->datatables->join('class', 'class.id = enroll.class_id', 'left');
        $this->datatables->join('section', 'section.id = enroll.section_id', 'left');
        $this->datatables->join('student_category', 'student_category.id = student.category_id', 'left');
        $this->datatables->join('parent', 'parent.id = student.parent_id', 'left');
        $phoneSearch = 'student.mobileno,parent.mobileno';
        $phoneColumns = array('student.mobileno', 'parent.mobileno');
        if ($this->db->field_exists('extra_phones', 'parent')) {
            $phoneSearch .= ',parent.extra_phones';
            $phoneColumns[] = 'parent.extra_phones';
        }
        $this->datatables->search_value('student.register_no,student.first_name,student.last_name,student.gender,student_category.name,class.name,section.name,enroll.roll,parent.name,' . $phoneSearch . $field_select);
        $this->datatables->search_phone_columns($phoneColumns);
        $this->datatables->column_order('enroll.id,enroll.id,student.first_name,class.name,section.name,student.gender,student.mobileno,student.register_no,enroll.roll,student.birthday,parent.name' . $custom_fields_column_order);
        $this->datatables->order_by('enroll.id', 'desc');
        $this->datatables->where('student.active', 1);
        $this->datatables->where('enroll.session_id', $sessionID);
        $this->datatables->where('enroll.branch_id', $branchID);
        if (!empty($sectionID)) {
            $this->datatables->where('enroll.section_id', $sectionID);
        }
        if (!empty($categoryID)) {
            $this->datatables->where('student.category_id', $categoryID);
        }

        // filter classes by teacher assigned classes
        if ($assigned_cs_list != false && !empty($assigned_cs_list)) {
            $this->datatables->group_start();
            foreach ($assigned_cs_list as $class_key => $class_value) {
                foreach ($class_value as $section_key => $section_value) {
                    $this->datatables->or_group_start();
                    $this->datatables->where('enroll.class_id', $class_key);
                    $this->datatables->where('enroll.section_id', $section_value);
                    $this->datatables->group_end();

                }
            }
            $this->datatables->group_end();
        }
        $results = $this->datatables->generate();

        // data processing for DataTable
        $records = array();
        $records = json_decode($results);
        $data = array();
        foreach ($records->data as $key => $record) {
            $fee_progress = $this->getFeeProgress($record->id);

            // age calculation
            $dobIso = '';
            $dobLabel = 'Set date of birth';
            if (!empty($record->birthday) && $record->birthday !== '0000-00-00') {
                $birthday = new DateTime($record->birthday);
                $today = new DateTime('today');
                $age = $birthday->diff($today)->y;
                $stu_age = html_escape($age);
                $dobIso = $birthday->format('Y-m-d');
                $dobLabel = _d($record->birthday);
            } else {
                $stu_age = 'N/A';
            }
            if (get_permission('student', 'is_edit')) {
                $stu_age = '<button type="button" class="btn btn-link btn-xs js-dob-edit" data-student="' . (int) $record->student_id . '" data-name="' . html_escape($record->fullname) . '" data-dob="' . html_escape($dobIso) . '">'
                    . '<span class="js-dob-age">' . $stu_age . '</span>'
                    . '<span class="js-dob-label text-muted">' . html_escape($dobLabel) . '</span>'
                    . '</button>';
            }
            // photo and name open the same Quick View as the QR button
            $quickOpen = "studentQuickView('" . (int) $record->id . "', this)";
            $quickAttrs = ' type="button" data-loading-text="<i class=\'fas fa-spinner fa-spin\'></i>" onclick="' . $quickOpen . '" title="' . html_escape(translate('quick_view')) . '"';
            $photo = '<button class="js-quick-open js-quick-photo"' . $quickAttrs . '><img src="' . html_escape(get_image_url('student', $record->photo)) . '" height="50" alt=""></button>';
            $nameCell = '<button class="js-quick-open js-quick-name"' . $quickAttrs . '>' . html_escape($record->fullname) . '</button>';

            // actions btn
            $actions = '<button class="btn btn-circle icon btn-default" data-toggle="tooltip" data-original-title="' . translate('quick_view') . '" data-loading-text="<i class=\'fas fa-spinner fa-spin\'></i>" onclick="studentQuickView(' . "'" . $record->id . "'" . ', this)"><i class="fas fa-qrcode"></i></button>';
            if (get_permission('student', 'is_view') || get_permission('student', 'is_edit')) {
                $actions .= '<a href="' . base_url('student/admission_slip/') . $record->id . '" class="btn btn-circle btn-default icon" data-toggle="tooltip" data-original-title="' . translate('admission_slip') . '" target="_blank"><i class="fas fa-print"></i></a>';
            }
            if (get_permission('student', 'is_edit')) {
                $actions .= '<a href="' . base_url('student/profile/') . $record->id . '" class="btn btn-circle btn-default icon" data-toggle="tooltip" data-original-title="' . translate('details') . '"> <i class="far fa-arrow-alt-circle-right"></i></a>';
            }
            if (get_permission('student', 'is_delete')) {
                $actions .= btn_delete('student/delete_data/' . $record->id . '/' . $record->student_id);
            }
            $actions .= $this->quranShareAction($record);
            // dt-data array 
            $row   = array();
            $row[] = "<div class='checked-area'><div class='checkbox-replace'>
                            <label class='i-checks'>
                                <input type='checkbox' class='cb_bulkdelete' id='" . $record->student_id . "'><i></i>
                            </label>
                        </div></div>";
if ($validArr['student_photo']) {
            $row[] = $photo;
}
            $row[] = $nameCell;
            $row[] = $record->class_name;
            $row[] = $record->section_name;
if ($validArr['gender']) {
            $row[] = translate($record->gender);
}
            $guardianPhones = array();
            if (!empty($record->guardian_mobileno)) {
                $guardianPhones[] = trim((string) $record->guardian_mobileno);
            }
            if (!empty($record->guardian_extra_phones)) {
                $extraPhones = json_decode($record->guardian_extra_phones, true);
                if (is_array($extraPhones)) {
                    foreach ($extraPhones as $extraPhone) {
                        $extraPhone = trim((string) $extraPhone);
                        if ($extraPhone !== '' && !in_array($extraPhone, $guardianPhones, true)) {
                            $guardianPhones[] = $extraPhone;
                        }
                    }
                }
            }
            $guardianPhoneHtml = '';
            foreach ($guardianPhones as $guardianPhone) {
                $guardianPhoneHtml .= "\n<small class='text-muted bs-block'>" . html_escape($guardianPhone) . "</small>";
            }
if ($validArr['student_mobile_no']) {
            $ownMobile = trim((string) $record->mobileno);
            if ($ownMobile !== '') {
                $row[] = html_escape($ownMobile);
            } elseif ($guardianPhoneHtml !== '') {
                $row[] = $guardianPhoneHtml . "\n<small class='text-muted bs-block'>Guardian</small>";
            } else {
                $row[] = '';
            }
}
            $row[] = $record->register_no . "\n<small class='text-muted bs-block'>"._d($record->admission_date)."</small>";
if ($validArr['roll']) {
            $row[] = $record->roll;
}
            $row[] = $stu_age;
            if (empty($record->parent_id)) {
                $row[] = 'N/A';
            } else {
                $row[] = html_escape($record->guardian_name) . $guardianPhoneHtml;
            }
            if (count($show_custom_fields)) {
                foreach ($show_custom_fields as $fields) {
                    $field_label   = 'cfid_' . $fields['id'];
                    $row[] = $record->$field_label;
                }
            }
            $row[] = '<div class="progress progress-xl m-none prb-mw">
                        <div class="progress-bar text-dark" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: ' . $fee_progress . '%;">' . $fee_progress.'%</div>
                    </div>';
            $row[] = $actions;
            $data[] = $row;
        }
        $json_data = array(
            "draw"                => intval($records->draw),
            "recordsTotal"        => intval($records->recordsTotal),
            "recordsFiltered"     => intval($records->recordsFiltered),
            "data"                => $data,
        );
        return json_encode($json_data);
    }

    /**
     * Opens WhatsApp with this child's Quran install link, to the parent number when one is saved.
     */
    protected function quranShareAction($record)
    {
        $studentId = isset($record->student_id) ? (int) $record->student_id : 0;
        if ($studentId < 1) {
            return '';
        }
        $this->load->model('academy_model');
        $base = defined('PUBLIC_SITE_URL') && PUBLIC_SITE_URL !== '' ? rtrim(PUBLIC_SITE_URL, '/') : rtrim(base_url(), '/');
        $url = $base . '/quran/' . $this->academy_model->quranPlaylistToken($studentId);
        $name = trim((string) $record->fullname);
        if ($name === '') {
            $name = 'your child';
        }
        $text = "Assalamu alaikum. Install " . $name . "'s Quran app from Tahsin Academy. Open this link, then tap Install Quran:\n" . $url;
        $phones = $this->academy_model->parentPhoneList(
            isset($record->guardian_mobileno) ? $record->guardian_mobileno : '',
            isset($record->guardian_extra_phones) ? $record->guardian_extra_phones : '',
            isset($record->mobileno) ? $record->mobileno : ''
        );
        $share = 'https://api.whatsapp.com/send?text=' . rawurlencode($text);
        if (!empty($phones)) {
            $share = 'https://api.whatsapp.com/send?phone=' . rawurlencode($phones[0]) . '&text=' . rawurlencode($text);
        }
        return '<a href="' . htmlspecialchars($share, ENT_QUOTES, 'UTF-8') . '" class="btn btn-circle icon btn-default" style="color:#128C7E" data-toggle="tooltip" data-original-title="Share Quran app" target="_blank" rel="noopener"><i class="fab fa-whatsapp"></i></a>';
    }

    public function schoolFeeAmount($section_id = 0, $programme_category_id = 0, $pwd_category_id = 0, $branch_id = null, $mode = 'campus')
    {
        if (!isset($this->school_fee_model)) {
            $this->load->model('school_fee_model');
        }
        if ($branch_id === null || $branch_id === '') {
            $branch_id = $this->application_model->get_branch_id();
        }
        return $this->school_fee_model->resolveAmount($branch_id, $section_id, $programme_category_id, $pwd_category_id, $mode);
    }

    public function tuitionPlanLabel($plan)
    {
        if ($plan === 'full') {
            return 'Pay in full';
        }
        if ($plan === 'installment') {
            return 'Pay in installments';
        }
        return '';
    }

    public function stripTuitionPlanTag($remarks)
    {
        return trim(preg_replace('/^\[plan:(full|installment)\]\s*/i', '', (string) $remarks));
    }

    public function ensureTuitionSetup($branch_id, $session_id, $amount = 0)
    {
        $fee = ((float) $amount > 0) ? (float) $amount : $this->schoolFeeAmount(0, 0, 0, $branch_id);
        $type = $this->db->get_where('fees_type', array('branch_id' => $branch_id, 'name' => 'Tuition'))->row();
        if (empty($type)) {
            $this->db->insert('fees_type', array(
                'name' => 'Tuition',
                'fee_code' => 'tuition',
                'description' => 'Termly tuition fee',
                'branch_id' => $branch_id,
                'system' => 0,
            ));
            $type_id = $this->db->insert_id();
        } else {
            $type_id = $type->id;
        }

        $group = $this->db->get_where('fee_groups', array(
            'branch_id' => $branch_id,
            'session_id' => $session_id,
            'name' => 'Tuition',
        ))->row();
        if (empty($group)) {
            $this->db->insert('fee_groups', array(
                'name' => 'Tuition',
                'description' => 'Tuition fee for the academic session',
                'session_id' => $session_id,
                'system' => 0,
                'branch_id' => $branch_id,
            ));
            $group_id = $this->db->insert_id();
        } else {
            $group_id = $group->id;
        }

        $detail = $this->db->get_where('fee_groups_details', array(
            'fee_groups_id' => $group_id,
            'fee_type_id' => $type_id,
        ))->row();
        if (empty($detail)) {
            $this->db->insert('fee_groups_details', array(
                'fee_groups_id' => $group_id,
                'fee_type_id' => $type_id,
                'amount' => $fee,
                'due_date' => date('Y-m-d', strtotime('+30 days')),
            ));
        } elseif ((float) $detail->amount != $fee) {
            $this->db->where('id', $detail->id)->update('fee_groups_details', array('amount' => $fee));
        }

        return array('type_id' => $type_id, 'group_id' => $group_id);
    }

    /**
     * Separate group so the online price does not overwrite the campus tuition amount.
     */
    public function ensureOnlineTuitionSetup($branch_id, $session_id, $amount = 0)
    {
        $fee = (float) $amount;
        if ($fee < 0) {
            $fee = 0;
        }
        $type = $this->db->get_where('fees_type', array('branch_id' => $branch_id, 'name' => 'Tuition'))->row();
        if (empty($type)) {
            $this->db->insert('fees_type', array(
                'name' => 'Tuition',
                'fee_code' => 'tuition',
                'description' => 'Termly tuition fee',
                'branch_id' => $branch_id,
                'system' => 0,
            ));
            $type_id = $this->db->insert_id();
        } else {
            $type_id = $type->id;
        }

        $group = $this->db->get_where('fee_groups', array(
            'branch_id' => $branch_id,
            'session_id' => $session_id,
            'name' => 'Online tuition',
        ))->row();
        if (empty($group)) {
            $this->db->insert('fee_groups', array(
                'name' => 'Online tuition',
                'description' => 'Tuition for students who attend online',
                'session_id' => $session_id,
                'system' => 0,
                'branch_id' => $branch_id,
            ));
            $group_id = $this->db->insert_id();
        } else {
            $group_id = $group->id;
        }

        $detail = $this->db->get_where('fee_groups_details', array(
            'fee_groups_id' => $group_id,
            'fee_type_id' => $type_id,
        ))->row();
        if (empty($detail)) {
            $this->db->insert('fee_groups_details', array(
                'fee_groups_id' => $group_id,
                'fee_type_id' => $type_id,
                'amount' => $fee,
                'due_date' => date('Y-m-d', strtotime('+30 days')),
            ));
        } elseif ((float) $detail->amount != $fee) {
            $this->db->where('id', $detail->id)->update('fee_groups_details', array('amount' => $fee));
        }

        return array('type_id' => $type_id, 'group_id' => $group_id);
    }

    public function recordTuitionPayment($enroll_id, $amount, $pay_via, $date, $remarks = '', $plan = 'installment')
    {
        $enroll = $this->db->get_where('enroll', array('id' => $enroll_id))->row_array();
        if (empty($enroll)) {
            return false;
        }
        $student = $this->db->select('pwd_category_id, category_id')->where('id', $enroll['student_id'])->get('student')->row();
        $mode = (!empty($enroll['instruction_mode']) && $enroll['instruction_mode'] === 'online') ? 'online' : 'campus';
        $sectionId = isset($enroll['section_id']) ? $enroll['section_id'] : 0;
        $programmeId = $student ? $student->category_id : 0;
        $pwdId = $student ? $student->pwd_category_id : 0;
        if ($mode === 'online') {
            $setup = $this->ensureOnlineTuitionSetup($enroll['branch_id'], $enroll['session_id'], 0);
        } else {
            $feeAmt = $this->schoolFeeAmount($sectionId, $programmeId, $pwdId, $enroll['branch_id']);
            $setup = $this->ensureTuitionSetup($enroll['branch_id'], $enroll['session_id'], $feeAmt);
        }
        $plan = ($plan === 'full') ? 'full' : 'installment';
        $note = $this->stripTuitionPlanTag($remarks);
        if ($note === '') {
            $note = ($plan === 'full') ? 'Tuition paid in full' : 'Tuition installment';
        }

        $existing = $this->db->select('a.id, a.group_id')
            ->from('fee_allocation a')
            ->join('fee_groups g', 'g.id = a.group_id', 'inner')
            ->where('a.student_id', $enroll_id)
            ->where('a.session_id', $enroll['session_id'])
            ->where_in('g.name', array('Tuition', 'Online tuition'))
            ->order_by('a.id', 'ASC')
            ->get()->row();
        if (!empty($existing)) {
            $allocation_id = $existing->id;
            if ((int) $existing->group_id !== (int) $setup['group_id']) {
                $this->db->where('id', $existing->id)->update('fee_allocation', array('group_id' => $setup['group_id']));
            }
        } else {
            $this->db->insert('fee_allocation', array(
                'student_id' => $enroll_id,
                'group_id' => $setup['group_id'],
                'session_id' => $enroll['session_id'],
                'branch_id' => $enroll['branch_id'],
            ));
            $allocation_id = $this->db->insert_id();
        }

        $this->db->insert('fee_payment_history', array(
            'allocation_id' => $allocation_id,
            'type_id' => $setup['type_id'],
            'collect_by' => get_loggedin_user_id(),
            'amount' => $amount,
            'discount' => 0,
            'fine' => 0,
            'pay_via' => $pay_via,
            'remarks' => '[plan:' . $plan . '] ' . $note,
            'date' => $date,
        ));
        $history_id = $this->db->insert_id();
        $account_id = $this->app_lib->getCollectionDepositAccountId();
        if ($account_id && $amount > 0) {
            $this->load->model('fees_model');
            $this->fees_model->saveTransaction(array(
                'account_id' => $account_id,
                'amount' => $amount,
                'date' => $date,
            ), $history_id);
        }
        return $history_id;
    }

    public function getTuitionPayments($enroll_id)
    {
        $this->db->select('h.id, h.amount, h.discount, h.fine, h.date, h.remarks, h.pay_via, t.name as fee_name, pt.name as pay_via_name');
        $this->db->from('fee_allocation as a');
        $this->db->join('fee_payment_history as h', 'h.allocation_id = a.id', 'inner');
        $this->db->join('fees_type as t', 't.id = h.type_id', 'left');
        $this->db->join('payment_types as pt', 'pt.id = h.pay_via', 'left');
        $this->db->where('a.student_id', $enroll_id);
        $this->db->group_start();
        $this->db->where('t.fee_code', 'tuition');
        $this->db->or_where('t.name', 'Tuition');
        $this->db->group_end();
        $this->db->order_by('h.id', 'asc');
        return $this->db->get()->result_array();
    }

    public function getTuitionSummary($enroll_id)
    {
        $cols = 'e.section_id, e.branch_id, s.pwd_category_id, s.category_id';
        if ($this->db->field_exists('country', 'student')) {
            $cols .= ', s.country, s.timezone';
        }
        if ($this->db->field_exists('instruction_mode', 'enroll')) {
            $cols .= ', e.instruction_mode';
        }
        if ($this->db->field_exists('fee_naira', 'enroll')) {
            $cols .= ', e.fee_currency, e.fee_foreign, e.fee_rate, e.fee_naira';
        }
        $enroll = $this->db->select($cols)
            ->from('enroll as e')
            ->join('student as s', 's.id = e.student_id', 'left')
            ->where('e.id', (int) $enroll_id)
            ->get()->row();
        $section_id = $enroll ? (int) $enroll->section_id : 0;
        $programme_category_id = $enroll ? (int) $enroll->category_id : 0;
        $pwd_category_id = $enroll ? (int) $enroll->pwd_category_id : 0;
        $branch_id = $enroll ? (int) $enroll->branch_id : null;
        $mode = ($enroll && isset($enroll->instruction_mode) && $enroll->instruction_mode === 'online') ? 'online' : 'campus';
        $quoteText = '';
        if ($mode === 'online' && $enroll && isset($enroll->fee_naira) && (float) $enroll->fee_naira > 0) {
            $fee = (float) $enroll->fee_naira;
            $quoteText = $enroll->fee_currency . ' ' . number_format((float) $enroll->fee_foreign, 2, '.', ',')
                . ' × ' . number_format((float) $enroll->fee_rate, 2, '.', ',')
                . ' locked in naira';
        } elseif ($mode === 'online') {
            $this->load->model('school_fee_model');
            $quote = $this->school_fee_model->quoteOnline(
                $branch_id,
                $enroll && isset($enroll->country) ? $enroll->country : '',
                $enroll && isset($enroll->timezone) ? $enroll->timezone : ''
            );
            $fee = $quote['naira'];
            $quoteText = $quote['error'] !== '' ? $quote['error'] : $quote['text'];
        } else {
            $fee = $this->schoolFeeAmount($section_id, $programme_category_id, $pwd_category_id, $branch_id);
        }
        $payments = $this->getTuitionPayments($enroll_id);
        $paid = 0;
        $plan = '';
        foreach ($payments as $i => $row) {
            $paid += (float) $row['amount'];
            if (preg_match('/^\[plan:(full|installment)\]/i', (string) $row['remarks'], $m)) {
                if ($plan === '') {
                    $plan = strtolower($m[1]);
                }
            }
            $payments[$i]['remarks'] = $this->stripTuitionPlanTag($row['remarks']);
        }
        if ($plan === '' && !empty($payments)) {
            $plan = ((float) $payments[0]['amount'] >= $fee) ? 'full' : 'installment';
        }
        $balance = round($fee - $paid, 2);
        if ($balance < 0.01) {
            $balance = 0;
        }
        $last = empty($payments) ? null : $payments[count($payments) - 1];
        return array(
            'fee' => $fee,
            'paid' => $paid,
            'balance' => $balance,
            'plan' => $plan,
            'plan_label' => $this->tuitionPlanLabel($plan),
            'payments' => $payments,
            'last' => $last,
            'complete' => ($paid > 0 && $balance <= 0),
            'quote' => $quoteText,
        );
    }

    public function getTuitionPayment($enroll_id)
    {
        $summary = $this->getTuitionSummary($enroll_id);
        return empty($summary['last']) ? null : $summary['last'];
    }

    public function getAdmissionSlip($enroll_id)
    {
        $this->db->select('s.*, e.id as enrollid, e.roll, e.class_id, e.section_id, e.session_id, e.branch_id,
            c.name as class_name, se.name as section_name, sc.name as category_name,
            p.name as guardian_name, p.relation as guardian_relation, p.mobileno as guardian_mobile,
            p.father_name, p.mother_name, p.email as guardian_email,
            b.school_name, b.email as school_email, b.mobileno as school_mobile, b.address as school_address,
            sy.school_year');
        $this->db->from('enroll as e');
        $this->db->join('student as s', 'e.student_id = s.id', 'inner');
        $this->db->join('class as c', 'e.class_id = c.id', 'left');
        $this->db->join('section as se', 'e.section_id = se.id', 'left');
        $this->db->join('student_category as sc', 's.category_id = sc.id', 'left');
        $this->db->join('parent as p', 'p.id = s.parent_id', 'left');
        $this->db->join('branch as b', 'b.id = e.branch_id', 'left');
        $this->db->join('schoolyear as sy', 'sy.id = e.session_id', 'left');
        $this->db->where('e.id', $enroll_id);
        if (!is_superadmin_loggedin()) {
            $this->db->where('e.branch_id', get_loggedin_branch_id());
        }
        $row = $this->db->get()->row_array();
        if (empty($row)) {
            show_404();
        }
        $row['fullname'] = student_fullname($row);
        $row['gender'] = !empty($row['gender']) ? ucfirst($row['gender']) : $row['gender'];
        if (empty($row['state_student_id'])) {
            $row['state_student_id'] = 'TA-' . date('Y') . '-' . str_pad($row['id'], 5, '0', STR_PAD_LEFT);
        }
        $row['barcode_value'] = $row['state_student_id'];
        return $row;
    }

    public function getStudentQrFile($student)
    {
        $dir = FCPATH . 'uploads/temp/qr_code/';
        if (!is_dir($dir)) {
            @mkdir($dir, 0777, true);
        }
        @chmod($dir, 0777);
        $relative = 'uploads/temp/qr_code/stu_' . $student['id'] . '.png';
        $full = FCPATH . $relative;
        $this->load->library('ciqrcode', array(
            'cacheable' => false,
            'cachedir' => $dir,
            'errorlog' => sys_get_temp_dir() . '/',
        ));
        $this->ciqrcode->generate(array(
            'savename' => $full,
            'level' => 'M',
            'size' => 4,
            'data' => $student['barcode_value'],
        ));
        @chmod($full, 0666);
        return $relative;
    }

    public $photo_failed = false;

    public function storeStudentPhoto($field = 'user_photo')
    {
        $this->photo_failed = false;
        $old = basename((string) $this->input->post('old_user_photo'));
        if ($old === '.' || $old === '..') {
            $old = '';
        }
        $fallback = $old !== '' ? $old : 'defualt.png';
        if (!isset($_FILES[$field]) || $_FILES[$field]['error'] === UPLOAD_ERR_NO_FILE || empty($_FILES[$field]['name'])) {
            return $fallback;
        }
        $file = $_FILES[$field];
        if ((int) $file['error'] !== UPLOAD_ERR_OK || !is_uploaded_file($file['tmp_name'])) {
            $this->photo_failed = true;
            return $fallback;
        }
        if ((int) $file['size'] > 12 * 1024 * 1024) {
            $this->photo_failed = true;
            return $fallback;
        }
        $info = @getimagesize($file['tmp_name']);
        if (!$info) {
            $this->photo_failed = true;
            return $fallback;
        }
        $width = (int) $info[0];
        $height = (int) $info[1];
        $type = (int) $info[2];
        if ($width < 32 || $height < 32 || $width > 8000 || $height > 8000 || ($width * $height) > 24000000) {
            $this->photo_failed = true;
            return $fallback;
        }
        if (!in_array($type, array(IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_WEBP), true)) {
            $this->photo_failed = true;
            return $fallback;
        }
        $mime = '';
        if (function_exists('finfo_open')) {
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            if ($finfo) {
                $mime = (string) finfo_file($finfo, $file['tmp_name']);
                finfo_close($finfo);
            }
        }
        $allowedMime = array(IMAGETYPE_JPEG => 'image/jpeg', IMAGETYPE_PNG => 'image/png', IMAGETYPE_WEBP => 'image/webp');
        if ($mime !== '' && $mime !== $allowedMime[$type]) {
            $this->photo_failed = true;
            return $fallback;
        }
        if ($type === IMAGETYPE_JPEG) {
            $src = @imagecreatefromjpeg($file['tmp_name']);
        } elseif ($type === IMAGETYPE_PNG) {
            $src = @imagecreatefrompng($file['tmp_name']);
        } else {
            $src = function_exists('imagecreatefromwebp') ? @imagecreatefromwebp($file['tmp_name']) : false;
        }
        if (!$src) {
            $this->photo_failed = true;
            return $fallback;
        }
        if ($type === IMAGETYPE_JPEG && function_exists('exif_read_data')) {
            $exif = @exif_read_data($file['tmp_name']);
            if (!empty($exif['Orientation'])) {
                $src = $this->orientStudentPhoto($src, (int) $exif['Orientation']);
            }
        }
        $width = imagesx($src);
        $height = imagesy($src);
        $scale = min(1, 1600 / max($width, $height));
        $nw = max(1, (int) round($width * $scale));
        $nh = max(1, (int) round($height * $scale));
        $dst = imagecreatetruecolor($nw, $nh);
        $white = imagecolorallocate($dst, 255, 255, 255);
        imagefilledrectangle($dst, 0, 0, $nw, $nh, $white);
        imagecopyresampled($dst, $src, 0, 0, 0, 0, $nw, $nh, $width, $height);
        imagedestroy($src);
        $dir = FCPATH . 'uploads/images/student/';
        if (!is_dir($dir)) {
            @mkdir($dir, 0755, true);
        }
        try {
            $name = 'stu_' . bin2hex(random_bytes(16)) . '.jpg';
        } catch (Exception $e) {
            $name = 'stu_' . bin2hex(openssl_random_pseudo_bytes(16)) . '.jpg';
        }
        $path = $dir . $name;
        $saved = imagejpeg($dst, $path, 86);
        imagedestroy($dst);
        if (!$saved || !is_file($path) || filesize($path) < 80) {
            if (is_file($path)) {
                @unlink($path);
            }
            $this->photo_failed = true;
            return $fallback;
        }
        @chmod($path, 0644);
        if ($old !== '' && $old !== 'defualt.png' && $old !== $name) {
            $oldPath = $dir . $old;
            if (is_file($oldPath)) {
                @unlink($oldPath);
            }
        }
        return $name;
    }

    protected function orientStudentPhoto($src, $orientation)
    {
        $angle = 0;
        if ($orientation === 3) {
            $angle = 180;
        } elseif ($orientation === 6) {
            $angle = -90;
        } elseif ($orientation === 8) {
            $angle = 90;
        } elseif ($orientation === 2 && function_exists('imageflip')) {
            imageflip($src, IMG_FLIP_HORIZONTAL);
        }
        if ($angle !== 0) {
            $turned = imagerotate($src, $angle, 0);
            if ($turned) {
                imagedestroy($src);
                return $turned;
            }
        }
        return $src;
    }

    public function ensurePartialReminderTable()
    {
        if ($this->db->table_exists('partial_fee_reminder')) {
            return true;
        }
        $this->db->query("CREATE TABLE IF NOT EXISTS `partial_fee_reminder` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `branch_id` int(11) NOT NULL,
            `remind_on` date DEFAULT NULL,
            `updated_at` datetime DEFAULT NULL,
            PRIMARY KEY (`id`),
            UNIQUE KEY `branch_id` (`branch_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8");
        return $this->db->table_exists('partial_fee_reminder');
    }

    public function getPartialReminderDate($branchId)
    {
        if (!$this->ensurePartialReminderTable()) {
            return '';
        }
        $row = $this->db->get_where('partial_fee_reminder', array('branch_id' => (int) $branchId))->row();
        if (!$row || empty($row->remind_on) || $row->remind_on === '0000-00-00') {
            return '';
        }
        return $row->remind_on;
    }

    public function savePartialReminderDate($branchId, $date)
    {
        if (!$this->ensurePartialReminderTable()) {
            return false;
        }
        $branchId = (int) $branchId;
        $existing = $this->db->get_where('partial_fee_reminder', array('branch_id' => $branchId))->row();
        $this->db->set('remind_on', $date === '' ? null : $date);
        $this->db->set('updated_at', date('Y-m-d H:i:s'));
        if ($existing) {
            $this->db->where('id', (int) $existing->id);
            return $this->db->update('partial_fee_reminder');
        }
        $this->db->set('branch_id', $branchId);
        return $this->db->insert('partial_fee_reminder');
    }

    /**
     * Students who have paid some school fees and still owe a balance, grouped by parent.
     * Siblings share one WhatsApp message. The message lists each child separately.
     */
    public function partialPaymentGroups($branchId)
    {
        $branchId = (int) $branchId;
        $paidIds = $this->partialTuitionEnrollIds();
        if (empty($paidIds)) {
            return array();
        }
        $nameExpr = $this->db->field_exists('other_name', 'student')
            ? 'TRIM(CONCAT_WS(" ", s.first_name, NULLIF(s.other_name, ""), s.last_name))'
            : 'TRIM(CONCAT_WS(" ", s.first_name, s.last_name))';
        $extra = $this->db->field_exists('extra_phones', 'parent') ? ', p.extra_phones AS guardian_extra_phones' : '';
        $this->db->select('e.id AS enroll_id, s.id AS student_id, s.register_no, s.mobileno, s.parent_id, '
            . $nameExpr . ' AS student_name, c.name AS class_name, se.name AS section_name, '
            . 'p.name AS guardian_name, p.mobileno AS guardian_mobileno' . $extra, false);
        $this->db->from('enroll e');
        $this->db->join('student s', 's.id = e.student_id', 'inner');
        $this->db->join('class c', 'c.id = e.class_id', 'left');
        $this->db->join('section se', 'se.id = e.section_id', 'left');
        $this->db->join('parent p', 'p.id = s.parent_id', 'left');
        $this->db->where('e.session_id', get_session_id());
        $this->db->where('e.branch_id', $branchId);
        $this->db->where_in('e.id', $paidIds);
        $this->db->order_by('p.name', 'asc');
        $this->db->order_by('s.first_name', 'asc');
        $rows = $this->db->get()->result();

        $this->load->model('academy_model');
        $groups = array();
        foreach ($rows as $row) {
            $summary = $this->getTuitionSummary((int) $row->enroll_id);
            $paid = (float) $summary['paid'];
            $balance = (float) $summary['balance'];
            if ($paid <= 0 || $balance <= 0) {
                continue;
            }
            $parentId = (int) $row->parent_id;
            $key = $parentId > 0 ? 'p' . $parentId : 's' . (int) $row->student_id;
            if (!isset($groups[$key])) {
                $guardian = trim((string) $row->guardian_name);
                $primaryPhone = trim((string) $row->guardian_mobileno);
                $studentPhone = trim((string) $row->mobileno);
                $extraRaw = isset($row->guardian_extra_phones) ? trim((string) $row->guardian_extra_phones) : '';
                $hasExtra = $extraRaw !== '' && $extraRaw !== '[]' && $extraRaw !== 'null';
                $phones = $this->academy_model->parentPhoneList(
                    $primaryPhone,
                    $extraRaw,
                    $studentPhone
                );
                $phoneFromStudent = $primaryPhone === '' && !$hasExtra && $studentPhone !== '' && !empty($phones);
                if ($primaryPhone !== '') {
                    $display = $primaryPhone;
                } elseif ($phoneFromStudent) {
                    $display = $studentPhone;
                } elseif (!empty($phones)) {
                    $display = $phones[0];
                } else {
                    $display = '';
                }
                $groups[$key] = array(
                    'guardian' => $guardian,
                    'phone_display' => $display,
                    'phone_from_student' => $phoneFromStudent,
                    'phone' => !empty($phones) ? $phones[0] : '',
                    'children' => array(),
                );
            }
            if ($groups[$key]['phone'] === '' && trim((string) $row->mobileno) !== '') {
                $fallbackPhones = $this->academy_model->parentPhoneList('', '', $row->mobileno);
                if (!empty($fallbackPhones)) {
                    $groups[$key]['phone'] = $fallbackPhones[0];
                    $groups[$key]['phone_display'] = trim((string) $row->mobileno);
                    $groups[$key]['phone_from_student'] = true;
                }
            }
            $name = trim((string) $row->student_name);
            $classLabel = trim((string) $row->class_name);
            $sectionLabel = trim((string) $row->section_name);
            if ($classLabel !== '' && $sectionLabel !== '') {
                $classLabel .= ' / ' . $sectionLabel;
            } elseif ($sectionLabel !== '') {
                $classLabel = $sectionLabel;
            }
            $paidOn = array();
            foreach ($summary['payments'] as $payment) {
                $paidDate = _d(isset($payment['date']) ? $payment['date'] : '');
                if ($paidDate !== '' && !in_array($paidDate, $paidOn, true)) {
                    $paidOn[] = $paidDate;
                }
            }
            $groups[$key]['children'][] = array(
                'name' => $name !== '' ? $name : 'Student',
                'register_no' => (string) $row->register_no,
                'class_name' => $classLabel,
                'fee' => (float) $summary['fee'],
                'paid' => $paid,
                'balance' => $balance,
                'fee_text' => $this->partialReminderMoney($summary['fee']),
                'paid_text' => $this->partialReminderMoney($paid),
                'paid_on' => implode(', ', $paidOn),
                'balance_text' => $this->partialReminderMoney($balance),
                'plan_label' => (string) $summary['plan_label'],
            );
        }

        $out = array();
        foreach ($groups as $group) {
            $group['message'] = $this->partialReminderMessage($group['children']);
            $group['whatsapp'] = $group['phone'] === '' ? '' : $this->partialReminderWhatsapp($group['phone'], $group['message']);
            $out[] = $group;
        }
        return $out;
    }

    protected function partialTuitionEnrollIds()
    {
        $this->db->distinct();
        $this->db->select('a.student_id');
        $this->db->from('fee_allocation a');
        $this->db->join('fee_payment_history h', 'h.allocation_id = a.id', 'inner');
        $this->db->join('fees_type t', 't.id = h.type_id', 'left');
        $this->db->group_start();
        $this->db->where('t.fee_code', 'tuition');
        $this->db->or_where('t.name', 'Tuition');
        $this->db->group_end();
        $this->db->where('h.amount >', 0);
        $ids = array();
        foreach ($this->db->get()->result() as $row) {
            $ids[] = (int) $row->student_id;
        }
        return $ids;
    }

    protected function partialReminderMoney($amount)
    {
        $text = trim(html_entity_decode(strip_tags(currencyFormat($amount)), ENT_QUOTES, 'UTF-8'));
        return $text !== '' ? $text : number_format((float) $amount, 2, '.', ',');
    }

    protected function partialReminderPlain($text)
    {
        return str_replace(array('*', '_', '~', '`'), '', (string) $text);
    }

    protected function waBold($text)
    {
        $text = trim($this->partialReminderPlain($text));
        return $text === '' ? '' : '*' . $text . '*';
    }

    protected function waItalic($text)
    {
        $text = trim($this->partialReminderPlain($text));
        return $text === '' ? '' : '_' . $text . '_';
    }

    protected function waMono($text)
    {
        $text = trim($this->partialReminderPlain($text));
        return $text === '' ? '' : '```' . $text . '```';
    }

    protected function partialReminderLine($label, $value)
    {
        return $label . "\t : " . $value;
    }

    protected function partialReminderMessage($children)
    {
        $school = 'Tahsin Academy';
        $ci = get_instance();
        if (!empty($ci->data['global_config']['institute_name'])) {
            $school = $ci->data['global_config']['institute_name'];
        }
        $rule = '---------------------------------------';
        $totalRule = '- - - - - - - - - - - - - - - - - - - -';
        $lines = array();
        $lines[] = $this->waItalic('Assalamu alaikum.');
        $lines[] = '';
        $lines[] = $this->waBold($school);
        $lines[] = $this->waItalic('School fee reminder');
        $lines[] = '';
        $fee = 0;
        $paid = 0;
        $balance = 0;
        foreach ($children as $i => $child) {
            $name = ($i + 1) . '. ' . $this->waBold($child['name']);
            if ($child['register_no'] !== '') {
                $name .= ' ' . $this->waMono($child['register_no']);
            }
            $paidValue = $child['paid_text'];
            if ($child['paid_on'] !== '') {
                $paidValue .= ' ' . $this->waItalic($child['paid_on']);
            }
            $lines[] = $rule;
            $lines[] = $name;
            $lines[] = $this->partialReminderLine('School fees', $child['fee_text']);
            $lines[] = $this->partialReminderLine('Paid', $paidValue);
            $lines[] = $this->partialReminderLine('Remaining', $this->waBold($child['balance_text']));
            $fee += (float) $child['fee'];
            $paid += (float) $child['paid'];
            $balance += (float) $child['balance'];
        }
        $lines[] = $rule;
        $lines[] = '';
        if (count($children) > 1) {
            $lines[] = $this->waBold('Subtotal');
            $lines[] = $this->partialReminderLine('School fees', $this->partialReminderMoney($fee));
            $lines[] = $this->partialReminderLine('Paid', $this->partialReminderMoney($paid));
            $lines[] = '';
        }
        $lines[] = $totalRule;
        $lines[] = '*_' . trim($this->partialReminderPlain('Remaining : ' . $this->partialReminderMoney($balance))) . '_*';
        $lines[] = $totalRule;
        $lines[] = '';
        if (count($children) > 1) {
            $lines[] = '> Kindly complete the remaining payment for each child.';
        } else {
            $lines[] = '> Kindly complete the remaining payment.';
        }
        $lines[] = $this->waItalic('Jazakumullahu khairan.');
        return implode("\n", $lines);
    }

    protected function partialReminderWhatsapp($phone, $message)
    {
        return 'https://api.whatsapp.com/send?phone=' . rawurlencode($phone) . '&text=' . rawurlencode($message);
    }
}
