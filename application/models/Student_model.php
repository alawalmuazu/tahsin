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
            'pwd_category_id' => (isset($data['pwd_category_id']) ? (int) $data['pwd_category_id'] : null),
            'email' => $this->input->post('email'),
            'parent_id' => $this->input->post('parent_id'),
            'route_id' => (empty($this->input->post('route_id')) ? 0 : $this->input->post('route_id')),
            'vehicle_id' => (empty($this->input->post('vehicle_id')) ? 0 : $this->input->post('vehicle_id')),
            'stoppage_point_id' => (empty($this->input->post('stoppage_point_id')) ? null : $this->input->post('stoppage_point_id')),
            'hostel_id' => $hostelID,
            'room_id' => $roomID,
            'previous_details' => $previous_details,
            'photo' => $this->uploadImage('student'),
            'nin' => preg_replace('/[^0-9]/', '', $this->input->post('nin')),
        );


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
        $this->db->group_end();
        $this->db->order_by('s.id', 'desc');
        return $this->db->get();
    }

    public function getSingleStudent($id = '', $enroll = false)
    {
        $this->db->select('s.*,l.username,l.active,e.class_id,e.section_id,e.id as enrollid,e.roll,e.branch_id,e.session_id,c.name as class_name,se.name as section_name,sc.name as category_name');
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

        // Database query
        $this->datatables->select('enroll.*,TRIM(CONCAT_WS(" ",student.first_name, NULLIF(student.other_name,""), student.last_name)) as fullname,student.photo,student.mobileno,student.admission_date,student.gender,student.register_no,student.birthday,enroll.roll,class.name as class_name,student.parent_id,section.name as section_name,student_category.name as category,parent.name as guardian_name,parent.mobileno as guardian_mobileno' . $field_select);
        $this->datatables->from('enroll');
        $this->datatables->join('student', 'student.id = enroll.student_id', 'inner');
        $this->datatables->join('class', 'class.id = enroll.class_id', 'left');
        $this->datatables->join('section', 'section.id = enroll.section_id', 'left');
        $this->datatables->join('student_category', 'student_category.id = student.category_id', 'left');
        $this->datatables->join('parent', 'parent.id = student.parent_id', 'left');
        $this->datatables->search_value('student.register_no,student.first_name,student.last_name,student.gender,student_category.name,class.name,section.name,enroll.roll,parent.name' . $field_select);
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
            if(!empty($record->birthday)){
                $birthday = new DateTime($record->birthday);
                $today = new DateTime('today');
                $age = $birthday->diff($today)->y;
                $stu_age = html_escape($age);
            }else{
                $stu_age = "N/A";
            }
            // photo
            $photo = "<img src='" . get_image_url('student', $record->photo) . "' height='50'>";

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
            $row[] = $record->fullname;
            $row[] = $record->class_name;
            $row[] = $record->section_name;
if ($validArr['gender']) {
            $row[] = translate($record->gender);
}
if ($validArr['student_mobile_no']) {
            $row[] = $record->mobileno;
}
            $row[] = $record->register_no . "\n<small class='text-muted bs-block'>"._d($record->admission_date)."</small>";
if ($validArr['roll']) {
            $row[] = $record->roll;
}
            $row[] = $stu_age;
            if (empty($record->parent_id)) {
                $row[] = 'N/A';
            } else {
                $mobileno = empty($record->guardian_mobileno) ? '' : "\n<small class='text-muted bs-block'>" . $record->guardian_mobileno . "</small>";
                $row[] = $record->guardian_name . $mobileno;
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

    public function schoolFeeAmount($section_id = 0, $category_id = 0, $branch_id = null)
    {
        if (!isset($this->school_fee_model)) {
            $this->load->model('school_fee_model');
        }
        if ($branch_id === null || $branch_id === '') {
            $branch_id = $this->application_model->get_branch_id();
        }
        return $this->school_fee_model->resolveAmount($branch_id, $section_id, $category_id);
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
        $fee = ((float) $amount > 0) ? (float) $amount : $this->schoolFeeAmount(0, 0, $branch_id);
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

    public function recordTuitionPayment($enroll_id, $amount, $pay_via, $date, $remarks = '', $plan = 'installment')
    {
        $enroll = $this->db->get_where('enroll', array('id' => $enroll_id))->row_array();
        if (empty($enroll)) {
            return false;
        }
        $student = $this->db->select('pwd_category_id, category_id')->where('id', $enroll['student_id'])->get('student')->row();
        $feeAmt = $this->schoolFeeAmount(
            isset($enroll['section_id']) ? $enroll['section_id'] : 0,
            $student ? $student->pwd_category_id : 0,
            $enroll['branch_id']
        );
        $setup = $this->ensureTuitionSetup($enroll['branch_id'], $enroll['session_id'], $feeAmt);
        $plan = ($plan === 'full') ? 'full' : 'installment';
        $note = $this->stripTuitionPlanTag($remarks);
        if ($note === '') {
            $note = ($plan === 'full') ? 'Tuition paid in full' : 'Tuition installment';
        }

        $existing = $this->db->get_where('fee_allocation', array(
            'student_id' => $enroll_id,
            'group_id' => $setup['group_id'],
            'session_id' => $enroll['session_id'],
        ))->row();
        if (!empty($existing)) {
            $allocation_id = $existing->id;
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
        $enroll = $this->db->select('e.section_id, e.branch_id, s.pwd_category_id, s.category_id')
            ->from('enroll as e')
            ->join('student as s', 's.id = e.student_id', 'left')
            ->where('e.id', (int) $enroll_id)
            ->get()->row();
        $section_id = $enroll ? (int) $enroll->section_id : 0;
        $pwd_category_id = $enroll ? (int) $enroll->pwd_category_id : 0;
        $branch_id = $enroll ? (int) $enroll->branch_id : null;
        $fee = $this->schoolFeeAmount($section_id, $pwd_category_id, $branch_id);
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
}
