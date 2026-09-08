<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Employee_model extends MY_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    // moderator employee all information
    public function save($data, $role = null, $id = null)
    {
        // Dynamically resolve statewide role IDs from DB — no branch for these roles
        $stateExecutiveRoles = $this->db->select('id')->where('is_statewide', 1)->get('roles')->result_array();
        $stateExecutiveRoles = array_column($stateExecutiveRoles, 'id');
        $userRole = isset($data['user_role']) ? (int) $data['user_role'] : 0;
        $branchID = in_array($userRole, $stateExecutiveRoles) ? null : $this->application_model->get_branch_id();

        $inser_data1 = array(
            'branch_id' => $branchID,
            'name' => $data['name'],
            'sex' => $data['sex'],
            'religion' => $data['religion'],
            'blood_group' => $data['blood_group'],
            'birthday' => $data["birthday"],
            'mobileno' => $data['mobile_no'],
            'present_address' => $data['present_address'],
            'permanent_address' => $data['permanent_address'],
            'photo' => $this->uploadImage('staff'),
            'designation' => isset($data['designation_id']) ? $data['designation_id'] : '',
            'department' => isset($data['department_id']) ? $data['department_id'] : '',
            'joining_date' => date("Y-m-d", strtotime($data['joining_date'])),
            'qualification' => $data['qualification'],
            'experience_details' => $data['experience_details'],
            'total_experience' => $data['total_experience'],
            'email' => $data['email'],
            'facebook_url' => $data['facebook'],
            'linkedin_url' => $data['linkedin'],
            'twitter_url' => $data['twitter'],
            'next_of_kin_name' => isset($data['next_of_kin_name']) ? $data['next_of_kin_name'] : null,
            'next_of_kin_phone' => isset($data['next_of_kin_phone']) ? $data['next_of_kin_phone'] : null,
            'next_of_kin_relation' => isset($data['next_of_kin_relation']) ? $data['next_of_kin_relation'] : null,
        );

        $inser_data2 = array(
            'role' => $data["user_role"],
        );
        $send_setup_invitation = isset($data['send_setup_invitation']) ? 1 : 0;

        if (!isset($data['staff_id']) && empty($data['staff_id'])) {
            // RANDOM STAFF ID GENERATE
            $inser_data1['staff_id'] = substr(app_generate_hash(), 3, 7);
            // SAVE EMPLOYEE INFORMATION IN THE DATABASE
            $this->db->insert('staff', $inser_data1);
            $employeeID = $this->db->insert_id();

            // SAVE EMPLOYEE LOGIN CREDENTIAL INFORMATION IN THE DATABASE
            $inser_data2['user_id'] = $employeeID;
            if ($send_setup_invitation) {
                $inser_data2['active'] = 2; // Pending Setup
                $inser_data2['setup_token'] = bin2hex(random_bytes(32));
                $inser_data2['username'] = NULL;
                $inser_data2['password'] = NULL;
            } else {
                $inser_data2['active'] = 1;
                $inser_data2['username'] = $data["username"];
                $inser_data2['password'] = $this->app_lib->pass_hashed($data["password"]);
            }
            $this->db->insert('login_credential', $inser_data2);

            // SAVE USER BANK INFORMATION IN THE DATABASE
            if (!isset($data['chkskipped'])) {
                $data['staff_id'] = $employeeID;
                $this->bankSave($data);
            }
            
            if ($send_setup_invitation) {
                return array('id' => $employeeID, 'setup_token' => $inser_data2['setup_token']);
            }
            return $employeeID;
        } else {
            $inser_data1['staff_id'] = $data['staff_id_no'];
            // UPDATE ALL INFORMATION IN THE DATABASE
            if (!is_superadmin_loggedin()) {
                $this->db->where('branch_id', get_loggedin_branch_id());
            }
            $this->db->where('id', $data['staff_id']);
            $this->db->update('staff', $inser_data1);
            // UPDATE LOGIN CREDENTIAL INFORMATION IN THE DATABASE
            if (!$send_setup_invitation) {
                if (!empty($data['username'])) {
                    $inser_data2['username'] = $data["username"];
                }
            }
            $this->db->where('user_id', $data['staff_id']);
            $this->db->where_not_in('role', array(6,7));
            $this->db->update('login_credential', $inser_data2);
        }
    }


    // GET SINGLE EMPLOYEE DETAILS
    public function getSingleStaff($id = '')
    {
        $this->db->select('staff.*,staff_designation.name as designation_name,staff_department.name as department_name,login_credential.role as role_id,login_credential.active,login_credential.username, roles.name as role');
        $this->db->from('staff');
        $this->db->join('login_credential', 'login_credential.user_id = staff.id and login_credential.role != "6" and login_credential.role != "7"', 'inner');
        $this->db->join('roles', 'roles.id = login_credential.role', 'left');
        $this->db->join('staff_designation', 'staff_designation.id = staff.designation', 'left');
        $this->db->join('staff_department', 'staff_department.id = staff.department', 'left');
        $this->db->where('staff.id', $id);
        if (!is_superadmin_loggedin()) {
            $this->db->where('staff.branch_id', get_loggedin_branch_id());
        }
        $query = $this->db->get();
        if ($query->num_rows() == 0) {
            show_404();
        }
        return $query->row_array();
    }

    // get staff all list
    public function getStaffList($branchID = '', $role_id = '', $active = 1)
    {
        $this->db->select('staff.*,staff_designation.name as designation_name,staff_department.name as department_name,login_credential.role as role_id, roles.name as role');
        $this->db->from('staff');
        $this->db->join('login_credential', 'login_credential.user_id = staff.id and login_credential.role != "6" and login_credential.role != "7"', 'inner');
        $this->db->join('roles', 'roles.id = login_credential.role', 'left');
        $this->db->join('staff_designation', 'staff_designation.id = staff.designation', 'left');
        $this->db->join('staff_department', 'staff_department.id = staff.department', 'left');
        if ($branchID != "") {
            $this->db->where('staff.branch_id', $branchID);
        }
        $this->db->where('login_credential.role', $role_id);
        $this->db->where('login_credential.active', $active);
        $this->db->order_by('staff.id', 'ASC');
        return $this->db->get()->result();
    }

    public function get_schedule_by_id($id)
    {
        $this->db->select('timetable_class.*,subject.name as subject_name,class.name as class_name,section.name as section_name');
        $this->db->from('timetable_class');
        $this->db->join('subject', 'subject.id = timetable_class.subject_id', 'inner');
        $this->db->join('class', 'class.id = timetable_class.class_id', 'inner');
        $this->db->join('section', 'section.id = timetable_class.section_id', 'inner');
        $this->db->where('timetable_class.teacher_id', $id);
        $this->db->where('timetable_class.session_id', get_session_id());
        return $this->db->get();
    }

    public function bankSave($data)
    {
        $inser_data = array(
            'staff_id' => $data['staff_id'],
            'bank_name' => $data['bank_name'],
            'holder_name' => $data['holder_name'],
            'bank_branch' => $data['bank_branch'],
            'bank_address' => $data['bank_address'],
            'ifsc_code' => $data['ifsc_code'],
            'account_no' => $data['account_no'],
        );
        if (isset($data['bank_id'])) {
            $this->db->where('id', $data['bank_id']);
            $this->db->update('staff_bank_account', $inser_data);
        } else {
            $this->db->insert('staff_bank_account', $inser_data);
        }  
    }

    public function csvImport($row, $branchID, $userRole, $designationID, $departmentID)
    {
        $inser_data1 = array(
            'name' => $row['Name'],
            'sex' => $row['Gender'],
            'religion' => $row['Religion'],
            'blood_group' => $row['BloodGroup'],
            'birthday' => date("Y-m-d", strtotime($row['DateOfBirth'])),
            'joining_date' => date("Y-m-d", strtotime($row['JoiningDate'])),
            'qualification' => $row['Qualification'],
            'mobileno' => $row['MobileNo'],
            'present_address' => $row['PresentAddress'],
            'permanent_address' => $row['PermanentAddress'],
            'email' => $row['Email'],
            'designation' => $designationID,
            'department' => $departmentID,
            'branch_id' => $branchID,
            'photo' => 'defualt.png',
            'next_of_kin_name' => isset($row['NextOfKinName']) ? $row['NextOfKinName'] : null,
            'next_of_kin_phone' => isset($row['NextOfKinPhone']) ? $row['NextOfKinPhone'] : null,
            'next_of_kin_relation' => isset($row['NextOfKinRelation']) ? $row['NextOfKinRelation'] : null,
        );

        $inser_data2 = array(
            'role' => $userRole,
            'active' => 2,
            'setup_token' => bin2hex(random_bytes(32)),
            'username' => NULL,
            'password' => NULL,
        );

        // RANDOM STAFF ID GENERATE
        $inser_data1['staff_id'] = substr(app_generate_hash(), 3, 7);
        // SAVE EMPLOYEE INFORMATION IN THE DATABASE
        $this->db->insert('staff', $inser_data1);
        $employeeID = $this->db->insert_id();

        // SAVE EMPLOYEE LOGIN CREDENTIAL INFORMATION IN THE DATABASE
        $inser_data2['user_id'] = $employeeID;
        $this->db->insert('login_credential', $inser_data2);
        return true;
    }

    // get staff list for CSV export
    public function getExportList($branchID = '', $role_id = '')
    {
        $this->db->select('staff.*, roles.name as role_name, staff_designation.name as designation_name, staff_department.name as department_name');
        $this->db->from('staff');
        $this->db->join('login_credential', 'login_credential.user_id = staff.id and login_credential.role != "6" and login_credential.role != "7"', 'inner');
        $this->db->join('roles', 'roles.id = login_credential.role', 'left');
        $this->db->join('staff_designation', 'staff_designation.id = staff.designation', 'left');
        $this->db->join('staff_department', 'staff_department.id = staff.department', 'left');
        if (!empty($branchID)) {
            $this->db->where('staff.branch_id', $branchID);
        }
        if (!empty($role_id)) {
            $this->db->where('login_credential.role', $role_id);
        }
        $this->db->where('login_credential.active', 1);
        $this->db->order_by('staff.id', 'ASC');
        return $this->db->get()->result();
    }
}
