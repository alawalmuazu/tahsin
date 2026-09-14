<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class App_lib
{
    protected $CI;

    public function __construct()
    {
        $this->CI = &get_instance();
    }

    public function get_credential_id($user_id, $staff = 'staff')
    {
        $this->CI->db->select('id');
        if ($staff == 'staff') {
            $this->CI->db->where_not_in('role', array(6, 7));
        } elseif ($staff == 'parent') {
            $this->CI->db->where('role', 6);
        } elseif ($staff == 'student') {
            $this->CI->db->where('role', 7);
        }
        $this->CI->db->where('user_id', $user_id);
        $result = $this->CI->db->get('login_credential')->row_array();
        return $result['id'];
    }

    function isExistingAddon($prefix ='')
    {
        if ($prefix != "") {
            $row = $this->CI->db->select('id')->where('prefix', $prefix)->get('addon')->row();
            if (empty($row)) {
                return false;
            } else {
                return true;
            }
        }
        return false;
    }

    public function getHybridItems($table, $branch_id)
    {
        $this->CI->db->where('branch_id', SCHOOL_ID);
        if ($table == 'subject' || $table == 'section' || $table == 'staff_department' || $table == 'staff_designation') {
            $this->CI->db->order_by('name', 'ASC');
        } elseif ($table == 'class') {
            $this->CI->db->order_by('CAST(name_numeric AS UNSIGNED)', 'ASC');
            $this->CI->db->order_by('name', 'ASC');
        } else {
            $this->CI->db->order_by('id', 'ASC');
        }
        return $this->CI->db->get($table)->result();
    }

    function studentLastRegID($branch_id ='')
    {
        $this->CI->db->select('register_no');
        $this->CI->db->from('student');
        $this->CI->db->join('enroll', 'enroll.student_id = student.id', 'inner');
        $this->CI->db->where('branch_id', $branch_id);
        $this->CI->db->order_by('student.id', 'desc');
        $this->CI->db->limit(1);
        $r = $this->CI->db->get()->row();
        return $r;
    }

    function get_bill_no($table)
    {
        $this->CI->db->where("branch_id", SCHOOL_ID);
        $result = $this->CI->db->select("max(bill_no) as id")->get($table)->row_array();
        $id = $result["id"];
        if (!empty($id)) {
            $bill = $id + 1;
        } else {
            $bill = 1;
        }
        return str_pad($bill, 4, '0', STR_PAD_LEFT);
    }

    function get_table($table, $id = NULL, $single = FALSE)
    {
        if ($single == TRUE) {
            $method = 'row_array';
        } else {
            $this->CI->db->order_by('id', 'ASC');
            $method = 'result_array';
        }
        if ($id != NULL) {
            $this->CI->db->where('id', $id);
        }
        $query = $this->CI->db->get($table);
        return $query->$method();
    }

    function getTable($table, $where = "", $single = FALSE)
    {
        if ($where != NULL) {
            $this->CI->db->where($where);
        }
        $this->CI->db->where("t.branch_id", SCHOOL_ID);

        if ($single == TRUE) {
            $method = "row_array";
        } else {
            if ($table == 'subject' || $table == 'section' || $table == 'staff_department' || $table == 'staff_designation') {
                $this->CI->db->order_by("name", "asc");
            } elseif ($table == 'class') {
                // Sort by numeric value first (Basic 1→9 before SS1→SS3), then alphabetically for ties
                $this->CI->db->order_by("CAST(t.name_numeric AS UNSIGNED)", "asc");
                $this->CI->db->order_by("t.name", "asc");
            } else {
                $this->CI->db->order_by("id", "asc");
            }
            $method = "result_array";
        }
        $this->CI->db->select("t.*, b.school_name as branch_name");
        $this->CI->db->from("$table as t");
        $this->CI->db->join("branch as b", "b.id = t.branch_id", "left");
        return $this->CI->db->get()->$method();
    }

    public function check_branch_restrictions($table, $id = '') {
        if (empty($id)) {
             access_denied();
        }
        $query = $this->CI->db->select('id,branch_id')->from($table)->where('id', $id)->limit(1)->get();
        if ($query->num_rows() != 0 && $query->row()->branch_id != SCHOOL_ID) {
            access_denied();
        }
    }

    public function pass_hashed($password)
    {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        return $hashed;
    }

    public function isRTLenabled()
    {
        $rtl = $this->CI->session->userdata('is_rtl');
        if (!empty($rtl) && $rtl == true) {
            return true;
        } else {
            return false;
        }
    }

    public function getRTLStatus($lang)
    {
        $row = $this->CI->db->select('rtl')->where('lang_field', $lang)->get('language_list')->row()->rtl;
        if ($row == 0) {
            return false;
        } else {
            return true;
        }
    }

    public function verify_password($password, $encrypt_password)
    {
        $hashed = password_verify($password, $encrypt_password);
        return $hashed;
    }

    public function getStaffList($branch_id = '', $role='')
    {
        if (empty($branch_id)) {
            $array = array('' => translate('select_branch_first'));
        } else {
            $this->CI->db->select('s.id,s.name,s.staff_id');
            $this->CI->db->from('staff as s');
            $this->CI->db->join('login_credential as l', 'l.user_id = s.id and l.role != 6 and l.role != 7', 'inner');
            if (!empty($branch_id)) {
                $this->CI->db->where('s.branch_id', $branch_id);
            }
            if (!empty($role)) {
                $this->CI->db->where_in('l.role', array($role));
            }
            $result = $this->CI->db->get()->result();
            $array = array('' => translate('select'));
            foreach ($result as $row) {
                $array[$row->id] = $row->name . ' (' . $row->staff_id . ')';
            }
        }
        return $array;
    }

    public function getClass($branch_id = '', $sel = true)
    {
        if (empty($branch_id)) {
            $array = array('' => translate('select_branch_first'));
        } else {
            $getClassTeacher = $this->getClassTeacher();
            if (is_array($getClassTeacher)) {
                $this->CI->db->select('class.id,class.name');
                $this->CI->db->from('timetable_class');
                $this->CI->db->join('class', 'class.id = timetable_class.class_id', 'left');
                $this->CI->db->where('timetable_class.teacher_id', get_loggedin_user_id());
                $this->CI->db->where('timetable_class.session_id', get_session_id());
                $this->CI->db->group_by('timetable_class.class_id'); 
                $result = $this->CI->db->get()->result_array();
                if (count($getClassTeacher) > 0) {
                    $result = array_merge($result, $getClassTeacher);
                }
            } else {
                // Hybrid: board items + branch custom items
                $hybridItems = $this->getHybridItems('class', $branch_id);
                $result = array();
                foreach ($hybridItems as $item) {
                    $result[] = array('id' => $item->id, 'name' => $item->name);
                }
            }
            if ($sel) {
                $array = array('' => translate('select'));
            } else {
                $array = [];
            }
            foreach ($result as $row) {
                $array[$row['id']] = $row['name'];
            }
        }
        return $array;
    }
    
    public function getStudentCategory($branch_id = '')
    {
        if (empty($branch_id)) {
            return array('' => translate('select_branch_first'));
        }
        $this->CI->load->model('home_model');
        $official = $this->CI->home_model->getAdmissionTypes($branch_id);
        if (!empty($official)) {
            return array('' => translate('select')) + $official;
        }
        $result = $this->getHybridItems('student_category', $branch_id);
        $array = array('' => translate('select'));
        foreach ($result as $row) {
            $array[$row->id] = $row->name;
        }
        return $array;
    }

    public function getSections($class_id = '', $all = false, $multi = false)
    {
        if (empty($class_id)) {
            $array = array('' => translate('select_class_first'));
        } else {
            $getClassTeacher = $this->getClassTeacher($class_id);
            if (is_array($getClassTeacher)) {
                $result = $getClassTeacher;
                if (count($result) == 0) {
                    $this->CI->db->select('timetable_class.section_id,section.name');
                    $this->CI->db->from('timetable_class');
                    $this->CI->db->join('section', 'section.id = timetable_class.section_id', 'left');
                    $this->CI->db->where(array('timetable_class.teacher_id' => get_loggedin_user_id(), 'timetable_class.session_id' => get_session_id(), 'timetable_class.class_id' => $class_id));
                    $this->CI->db->group_by('timetable_class.section_id'); 
                    $result = $this->CI->db->get()->result_array();
                }
            } else {
                $this->CI->db->where('class_id', $class_id);
                $result = $this->CI->db->get('sections_allocation')->result_array(); 
            }
            if ($multi == false) {
                $array = array('' => translate('select'));
            }
            if ($all == true && loggedin_role_id() != 3) {
                $array['all'] = translate('all_sections');
            }
            foreach ($result as $row) {
                $array[$row['section_id']] = get_type_name_by_id('section', $row['section_id']);
            }
        }
        return $array;
    }

    public function getDepartment($branch_id = '')
    {
        if (empty($branch_id)) {
            $array = array('' => translate('select_branch_first'));
        } else {
            $result = $this->getHybridItems('staff_department', $branch_id);
            $array = array('' => translate('select'));
            foreach ($result as $row) {
                $array[$row->id] = $row->name;
            }
        }
        return $array;
    }

    public function getDesignation($branch_id = '')
    {
        if ($branch_id == '') {
            $array = array('' => translate('select_branch_first'));
        } else {
            $result = $this->getHybridItems('staff_designation', $branch_id);
            $array = array('' => translate('select'));
            foreach ($result as $row) {
                $array[$row->id] = $row->name;
            }
        }
        return $array;
    }

    public function getVehicleByRoute($route_id = '')
    {
        if ($route_id == '') {
            $array = array('' => translate('first_select_the_route'));
        } else {
            $this->CI->db->where('route_id', $route_id);
            $result = $this->CI->db->get('transport_assign')->result();
            $array = array('' => translate('select'));
            foreach ($result as $row) {
                $array[$row->vehicle_id] = get_type_name_by_id('transport_vehicle', $row->vehicle_id, 'vehicle_no');
            }
        }
        return $array;
    }

    public function getStoppagePoinByRoute($route_id = '')
    {
        if ($route_id == '') {
            $array = array('' => translate('first_select_the_route'));
        } else {
            $this->CI->db->select('transport_stoppage_point.id,transport_stoppage.stop_position');
            $this->CI->db->from('transport_stoppage_point');
            $this->CI->db->join('transport_stoppage', 'transport_stoppage.id = transport_stoppage_point.stoppage_id', 'inner');
            $this->CI->db->order_by('transport_stoppage_point.order_no', 'asc');
            $this->CI->db->where('transport_stoppage_point.route_id', $route_id);
            $result = $this->CI->db->get()->result();
            $array = array('' => translate('select'));
            foreach ($result as $row) {
                $array[$row->id] = $row->stop_position;
            }
        }
        return $array;
    }

    public function getRoomByHostel($hostel_id = '')
    {
        if ($hostel_id == '') {
            $array = array('' => translate('first_select_the_hostel'));
        } else {
            $this->CI->db->where('hostel_id', $hostel_id);
            $result = $this->CI->db->get('hostel_room')->result();
            $array = array('' => translate('select'));
            foreach ($result as $row) {
                $array[$row->id] = $row->name . ' ('. get_type_name_by_id('hostel_category', $row->category_id).')';
            }
        }
        return $array;
    }

    public function getSelectByBranch($table, $branch_id = '', $all = false, $where = '')
    {
        if (is_array($where)) {
            $this->CI->db->where($where);
        }
        $this->CI->db->where('branch_id', SCHOOL_ID);
        $result = $this->CI->db->get($table)->result();

        $array = array('' => translate('select'));
        if ($all == true) {
            $array['all'] = translate('all_select');
        }
        foreach ($result as $row) {
            $array[$row->id] = $row->name;
        }
        return $array;
    }

    public function getSelectList($table, $all = '')
    {
        $arrayData = array("" => translate('select'));
        if ($all == 'all') {
            $arrayData['all'] = translate('all_select');
        }
        if ($table == 'branch') {
            $this->CI->db->where('id', SCHOOL_ID);
        }
        if ($table == 'payment_types') {
            $this->CI->db->where_in('id', array(1, 2, 3, 4, 5));
        }
        $result = $this->CI->db->get($table)->result();
        if ($table == 'payment_types') {
            $byId = array();
            foreach ($result as $row) {
                $byId[(int) $row->id] = $row;
            }
            $ordered = array();
            foreach (array(4, 1, 2, 3, 5) as $id) {
                if (isset($byId[$id])) {
                    $ordered[] = $byId[$id];
                }
            }
            $result = $ordered;
            $labels = array(
                4 => 'Commercial Bank Account',
                1 => 'Cash',
                2 => 'POS',
                3 => 'Cheque',
                5 => 'Other',
            );
            foreach ($result as $row) {
                $arrayData[$row->id] = isset($labels[$row->id]) ? $labels[$row->id] : $row->name;
            }
            return $arrayData;
        }
        foreach ($result as $row) {
            $arrayData[$row->id] = $row->name;
        }
        return $arrayData;
    }

    public function getNigeriaOnlineGateways($config)
    {
        $list = array('' => translate('select_payment_method'));
        if (!empty($config['paystack_status'])) {
            $list['paystack'] = 'Paystack';
        }
        if (!empty($config['flutterwave_status'])) {
            $list['flutterwave'] = 'Flutter Wave';
        }
        return $list;
    }

    public function defaultPasswordForRole($role)
    {
        $role = (int) $role;
        if ($role === 7) {
            return DEFAULT_PASSWORD_STUDENT;
        }
        if ($role === 6) {
            return DEFAULT_PASSWORD_PARENT;
        }
        return DEFAULT_PASSWORD_STAFF;
    }

    public function uniqueLoginUsername($username, $ignore_id = 0)
    {
        $username = trim((string) $username);
        if ($username === '') {
            return '';
        }
        $base = $username;
        $n = 0;
        while (true) {
            $this->CI->db->from('login_credential');
            $this->CI->db->where('username', $username);
            if ($ignore_id) {
                $this->CI->db->where('id !=', (int) $ignore_id);
            }
            if ($this->CI->db->count_all_results() === 0) {
                return $username;
            }
            $n++;
            $username = $base . $n;
        }
    }

    public function studentPortalUsername($register_no, $student_id = 0)
    {
        $register_no = trim((string) $register_no);
        if ($register_no !== '') {
            return $this->uniqueLoginUsername($register_no);
        }
        $fallback = 'TA-' . date('Y') . '-' . str_pad((int) $student_id, 5, '0', STR_PAD_LEFT);
        return $this->uniqueLoginUsername($fallback);
    }

    public function buildPortalCredential($role, $user_id, $username, $enabled)
    {
        $username = $this->uniqueLoginUsername($username);
        if ($username === '') {
            $username = $this->uniqueLoginUsername('user' . (int) $user_id);
        }
        return array(
            'user_id' => $user_id,
            'role' => $role,
            'username' => $username,
            'password' => $this->pass_hashed($this->defaultPasswordForRole($role)),
            'active' => $enabled ? 1 : 0,
            'must_change_password' => 1,
        );
    }

    public function activatePortalLogin($role, $user_id)
    {
        $row = $this->CI->db->get_where('login_credential', array('role' => $role, 'user_id' => $user_id))->row();
        $update = array(
            'active' => 1,
            'must_change_password' => 1,
        );
        if (empty($row) || empty($row->username) || empty($row->password)) {
            $username = $this->resolvePortalUsername($role, $user_id, $row ? $row->username : '');
            $update['username'] = $username;
            $update['password'] = $this->pass_hashed($this->defaultPasswordForRole($role));
        }
        $this->CI->db->where(array('role' => $role, 'user_id' => $user_id));
        $this->CI->db->update('login_credential', $update);
    }

    public function resolvePortalUsername($role, $user_id, $existing = '')
    {
        $existing = trim((string) $existing);
        if ($existing !== '') {
            return $this->uniqueLoginUsername($existing);
        }
        if ((int) $role === 7) {
            $stu = $this->CI->db->select('register_no,state_student_id')->where('id', $user_id)->get('student')->row();
            $candidate = '';
            if ($stu) {
                $candidate = trim((string) $stu->register_no);
                if ($candidate === '') {
                    $candidate = trim((string) $stu->state_student_id);
                }
            }
            return $this->studentPortalUsername($candidate, $user_id);
        }
        if ((int) $role === 6) {
            $parent = $this->CI->db->select('email')->where('id', $user_id)->get('parent')->row();
            $email = $parent ? trim((string) $parent->email) : '';
            return $this->uniqueLoginUsername($email !== '' ? $email : ('parent' . $user_id));
        }
        $staff = $this->CI->db->select('email')->where('id', $user_id)->get('staff')->row();
        $email = $staff ? trim((string) $staff->email) : '';
        return $this->uniqueLoginUsername($email !== '' ? $email : ('staff' . $user_id));
    }

    public function getRoles($arra_id = [1, 6, 7])
    {
        if ($arra_id !='all') {
            $this->CI->db->where_not_in('id', $arra_id);
        }
        $rolelist = $this->CI->db->get('roles')->result();
        $role_array = array('' => translate('select'));
        foreach ($rolelist as $role) {
            $role_array[$role->id] = $role->name;
        }
        return $role_array;
    }

    public function generateCSRF()
    {
        return '<input type="hidden" name="' . $this->CI->security->get_csrf_token_name() . '" value="' . $this->CI->security->get_csrf_hash() . '" />';
    }

    public function get_document_category()
    {
        $category = array(
            '' => translate('select'),
            '1' => "Resume File",
            '2' => "Offer Letter",
            '3' => "Joining Letter",
            '4' => "Experience Certificate",
            '5' => "Resignation Letter",
            '6' => "Other Documents",
        );
        return $category;
    }

    public function getDocumentCategory()
    {
        $category = array(
            '' => translate('select'),
            'Resume File' => "Resume File",
            'Offer Letter' => "Offer Letter",
            'Joining Letter' => "Joining Letter",
            'Experience Certificate' => "Experience Certificate",
            'Resignation Letter' => "Resignation Letter",
            'Other Documents' => "Other Documents",
        );
        return $category;
    }

    public function getAnimationslist()
    {
        $animations = array(
            'fadeIn' => "fadeIn",
            'fadeInUp' => "fadeInUp",
            'fadeInDown' => "fadeInDown",
            'fadeInLeft' => "fadeInLeft",
            'fadeInRight' => "fadeInRight",
            'bounceIn' => "bounceIn",
            'rotateInUpLeft' => "rotateInUpLeft",
            'rotateInDownLeft' => "rotateInDownLeft",
            'rotateInUpRight' => "rotateInUpRight",
            'rotateInDownRight' => "rotateInDownRight",
        );
        return $animations;
    }

    public function getMonthslist($m='')
    {
        $months = array(
            '01' => 'January',
            '02' => 'February',
            '03' => 'March',
            '04' => 'April',
            '05' => 'May',
            '06' => 'June',
            '07' => 'July ',
            '08' => 'August',
            '09' => 'September',
            '10' => 'October',
            '11' => 'November',
            '12' => 'December',
        );
        if (empty($m)) {
            return $months;
        } else {
            return $months[$m];
        }
        
    }

    public function getMonthsDropdown($startMonth = '')
    {
        $array = array('' => translate('select'));
        $startMonth = (empty($startMonth)) ? 01 : $startMonth;
        for ($i = $startMonth; $i < $startMonth + 12; $i++) {
            $month = date('m', mktime(0, 0, 0, $i, 10));
            $array[$month] = translate(strtolower(date('F', mktime(0, 0, 0, $i, 10))));
        }
        return $array;
    }

    public function getDateformat()
    {
        $date = array(
            "Y-m-d" => "yyyy-mm-dd",
            "Y/m/d" => "yyyy/mm/dd",
            "Y.m.d" => "yyyy.mm.dd",
            "d-M-Y" => "dd-mmm-yyyy",
            "d/M/Y" => "dd/mmm/yyyy",
            "d.M.Y" => "dd.mmm.yyyy",
            "d-m-Y" => "dd-mm-yyyy",
            "d/m/Y" => "dd/mm/yyyy",
            "d.m.Y" => "dd.mm.yyyy",
            "m-d-Y" => "mm-dd-yyyy",
            "m/d/Y" => "mm/dd/yyyy",
            "m.d.Y" => "mm.dd.yyyy",
        );
        return $date;
    }

    public function getBloodgroup()
    {
        $blood_group = array(
            '' => translate('select'),
            'A+' => 'A+',
            'A-' => 'A-',
            'B+' => 'B+',
            'B-' => 'B-',
            'O+' => 'O+',
            'O-' => 'O-',
            'AB+' => 'AB+',
            'AB-' => 'AB-',
        );
        return $blood_group;
    }

    function timezone_list()
    {
        static $timezones = null;
        if ($timezones === null) {
            $timezones = [];
            $offsets = [];
            $now = new DateTime('now', new DateTimeZone('UTC'));
                foreach (DateTimeZone::listIdentifiers() as $timezone) {
                $now->setTimezone(new DateTimeZone($timezone));
                $offsets[] = $offset = $now->getOffset();
                $timezones[$timezone] = '(' . $this->format_GMT_offset($offset) . ') ' . $this->format_timezone_name($timezone);
            }
            array_multisort($offsets, $timezones);
        }
        return $timezones;
    }

    function format_GMT_offset($offset)
    {
        $hours = intval($offset / 3600);
        $minutes = abs(intval($offset % 3600 / 60));
        return 'GMT' . ($offset ? sprintf('%+03d:%02d', $hours, $minutes) : '');
    }

    function format_timezone_name($name)
    {
        $name = str_replace('/', ', ', $name);
        $name = str_replace('_', ' ', $name);
        $name = str_replace('St ', 'St. ', $name);
        return $name;
    }

    function getClassTeacher($classID = '')
    {
        if (loggedin_role_id() == 3) {
            $getMode = $this->CI->db
            ->select('teacher_restricted')
            ->where('id', get_loggedin_branch_id())
            ->get('branch')
            ->row()->teacher_restricted;
            if ($getMode == 0) {
                return false;
            } else {
                $this->CI->db->select('class.id,class.name,teacher_allocation.section_id,section.name as section_name');
                $this->CI->db->from('teacher_allocation');
                $this->CI->db->join('class', 'class.id = teacher_allocation.class_id', 'left');
                $this->CI->db->join('section', 'section.id = teacher_allocation.section_id', 'left');
                $this->CI->db->where('teacher_allocation.teacher_id', get_loggedin_user_id());
                $this->CI->db->where('teacher_allocation.session_id', get_session_id());
                if (!empty($classID)) {
                    $this->CI->db->where('teacher_allocation.class_id', $classID);
                }
                $result = $this->CI->db->get()->result_array();
                return $result;
            }
        } else {
            return false;
        }
    }

    function licenceVerify()
    {
        $file = APPPATH.'config/purchase_key.php';
        @chmod($file, FILE_WRITE_MODE);
        $purchase = file_get_contents($file);
        if (empty($purchase)) {
            return false;
        }
        $purchase = json_decode($purchase); 
        $array = array();
        if(!is_array($purchase)) {
            return false;
        } else {
            if (empty($purchase[0]) || empty($purchase[1])) {
                return false;
            } else {
                return true;
            }
        }
    }

    function getAttendanceType()
    {
        $ci = &get_instance();
        $role_id = $ci->session->userdata('loggedin_role_id');
        $branchID = $ci->session->userdata('loggedin_branch');
        if ($role_id == 1) {
            return 2;
        }
        $sql = "SELECT `attendance_type` FROM `branch` WHERE `id` = " . $ci->db->escape($branchID);
        $result = $ci->db->query($sql)->row();
        return $result->attendance_type;
    }

    function getSchoolConfig($branchID = '', $select = '*')
    {
        $ci = &get_instance();
        $branch_id = empty($branchID) ? $ci->session->userdata('loggedin_branch') : $branchID;
        $sql = "SELECT $select FROM branch WHERE id = " . $ci->db->escape($branch_id);
        $result = $ci->db->query($sql)->row();
        return $result;
    }


    function get_ownClassSection()
    {
        if (!is_superadmin_loggedin() && loggedin_role_id() == 3) {
            $getMode = $this->CI->db->select('teacher_restricted')->where('id', get_loggedin_branch_id())->get('branch')->row()->teacher_restricted;
            if ($getMode == 0) {
                return false;
            } else {
                $arrayData = array();
                $class_list = $this->getClass(get_loggedin_branch_id(), false);
                foreach ($class_list as $c_key => $c_value) {
                    $section_list = $this->getSections($c_key, false, true);
                    foreach ($section_list as $s_key => $s_value) {
                        $arrayData[$c_key][] = $s_key;
                    }
                }
                return $arrayData;
            }
        } else {
            return false;
        }
    }
}
