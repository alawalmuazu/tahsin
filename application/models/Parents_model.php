<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Parents_model extends MY_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    // moderator parents all information
    public function save($data, $getBranch = array())
    {
        $inser_data1 = array(
            'branch_id' => $this->application_model->get_branch_id(),
            'name' => $data['name'],
            'relation' => $data['relation'],
            'age' => $data['age'],
            'father_name' => $data['father_name'],
            'mother_name' => $data['mother_name'],
            'occupation' => $data['occupation'],
            'income' => $data['income'],
            'education' => $data['education'],
            'email' => $data['email'],
            'mobileno' => $data['mobileno'],
            'address' => $data['address'],
            'city' => $data['city'],
            'state' => $data['state'],
            'photo' => $this->uploadImage('parent'),
            'facebook_url' => $data['facebook'],
            'linkedin_url' => $data['linkedin'],
            'twitter_url' => $data['twitter'],
        );
        if ($this->db->field_exists('extra_phones', 'parent')) {
            $phones = isset($data['extra_phones']) && is_array($data['extra_phones']) ? $data['extra_phones'] : array();
            $clean = array();
            foreach ($phones as $phone) {
                $phone = trim((string) $phone);
                if ($phone !== '') {
                    $clean[] = $phone;
                }
            }
            $inser_data1['extra_phones'] = json_encode(array_values($clean));
        }
        
        if (!isset($data['parent_id']) && empty($data['parent_id'])) {
            // save employee information in the database
            $this->db->insert('parent', $inser_data1);
            $parent_id = $this->db->insert_id();
            $email = trim((string) $data['email']);
            $username = $email !== '' ? $email : ('parent' . $parent_id);
            $inser_data2 = $this->app_lib->buildPortalCredential(6, $parent_id, $username, false);
            $this->db->insert('login_credential', $inser_data2);
            return $parent_id;
        } else {
            $this->db->where('id', $data['parent_id']);
            $this->db->update('parent', $inser_data1);
            $parent_id = (int) $data['parent_id'];
            $username = isset($data['username']) ? trim((string) $data['username']) : '';
            if ($username === '') {
                $username = 'parent' . $parent_id;
            }
            $login = $this->db->get_where('login_credential', array('role' => 6, 'user_id' => $parent_id))->row();
            if ($login) {
                $this->db->where('id', (int) $login->id);
                $this->db->update('login_credential', array('username' => $username));
            } else {
                $this->db->insert('login_credential', $this->app_lib->buildPortalCredential(6, $parent_id, $username, false));
            }
        }

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function getSingleParent($id)
    {
        $this->db->select('parent.*,login_credential.role as role_id,login_credential.active,login_credential.username,login_credential.id as login_id, roles.name as role');
        $this->db->from('parent');
        $this->db->join('login_credential', 'login_credential.user_id = parent.id and login_credential.role = "6"', 'left');
        $this->db->join('roles', 'roles.id = login_credential.role', 'left');
        $this->db->where('parent.id', $id);
        if (!is_superadmin_loggedin()) {
            $this->db->where('parent.branch_id', get_loggedin_branch_id());
        }
        $query = $this->db->get();
        if ($query->num_rows() == 0) {
            show_404();
        }
        return $query->row_array();
    }

    public function childsResult($parent_id)
    {
        $this->db->select('s.id,s.photo, CONCAT_WS(" ",s.first_name, s.last_name) as fullname,c.name as class_name,se.name as section_name');
        $this->db->from('enroll as e');
        $this->db->join('student as s', 'e.student_id = s.id', 'inner');
        $this->db->join('login_credential as l', 'l.user_id = s.id and l.role = 7', 'inner');
        $this->db->join('class as c', 'e.class_id = c.id', 'left');
        $this->db->join('section as se', 'e.section_id=se.id', 'left');
        $this->db->where('s.parent_id', $parent_id);
        $this->db->where('l.active', 1);
        $this->db->where('e.session_id', get_session_id());
        return $this->db->get()->result_array();
    }

    // get parent all details
    // $active: null = all parents; 1 = portal login enabled; 0 = disabled / no credential
    public function getParentList($branchID = null, $active = null)
    {
        $this->db->select('parent.*,login_credential.active as active,login_credential.id as login_id,login_credential.username as login_username,login_credential.created_at as login_created');
        $this->db->select('(SELECT GROUP_CONCAT(first_name SEPARATOR ", ") FROM student WHERE student.parent_id = parent.id) as children_names');
        $this->db->select('(SELECT COUNT(id) FROM student WHERE student.parent_id = parent.id) as children_count');
        $this->db->from('parent');
        $this->db->join('login_credential', 'login_credential.user_id = parent.id AND login_credential.role = 6', 'left');
        if ($active !== null && $active !== '') {
            if ((int) $active === 0) {
                $this->db->group_start();
                $this->db->where('login_credential.active', 0);
                $this->db->or_where('login_credential.id IS NULL', null, false);
                $this->db->group_end();
            } else {
                $this->db->where('login_credential.active', (int) $active);
            }
        }
        if (!empty($branchID)) {
           $this->db->where('parent.branch_id', $branchID);
        }
        $this->db->order_by('parent.id', 'ASC');
        return $this->db->get()->result();
    }

    /**
     * Director or admin approves a parent. Login stays off until this runs.
     * The temporary password is 123456 and must be changed on first sign-in.
     */
    public function approvePortal($parentId)
    {
        $parentId = (int) $parentId;
        $parent = $this->db->where('id', $parentId)->get('parent')->row();
        if (!$parent) {
            return false;
        }
        $email = trim((string) $parent->email);
        $username = $email !== '' ? $email : ('parent' . $parentId);
        $password = $this->app_lib->pass_hashed($this->app_lib->defaultPasswordForRole(6));
        $login = $this->db->get_where('login_credential', array('role' => 6, 'user_id' => $parentId))->row();
        $fields = array(
            'active' => 1,
            'password' => $password,
            'must_change_password' => 1,
        );
        if ($this->db->field_exists('pwa_required', 'login_credential')) {
            $fields['pwa_required'] = 0;
        }
        if ($login) {
            if ($email !== '' && (empty($login->username) || $login->username === ('parent' . $parentId))) {
                $fields['username'] = $this->app_lib->uniqueLoginUsername($username, (int) $login->id);
            }
            $this->db->where('id', (int) $login->id)->update('login_credential', $fields);
        } else {
            $cred = $this->app_lib->buildPortalCredential(6, $parentId, $username, true);
            $cred['password'] = $password;
            $cred['must_change_password'] = 1;
            if ($this->db->field_exists('pwa_required', 'login_credential')) {
                $cred['pwa_required'] = 0;
            }
            $this->db->insert('login_credential', $cred);
        }
        return true;
    }

    // CSV import single parent row
    public function csvImport($row, $branchID)
    {
        $arrayParent = array(
            'name' => $row['Name'],
            'relation' => $row['Relation'],
            'age' => isset($row['Age']) ? $row['Age'] : null,
            'father_name' => $row['FatherName'],
            'mother_name' => $row['MotherName'],
            'occupation' => $row['Occupation'],
            'income' => $row['Income'],
            'education' => $row['Education'],
            'mobileno' => $row['MobileNo'],
            'address' => $row['Address'],
            'city' => $row['City'],
            'state' => $row['State'],
            'email' => $row['Email'],
            'branch_id' => $branchID,
            'photo' => 'defualt.png',
        );
        $this->db->insert('parent', $arrayParent);
        $parentID = $this->db->insert_id();

        $email = trim((string) $row['Email']);
        $parent_credential = $this->app_lib->buildPortalCredential(6, $parentID, $email !== '' ? $email : ('parent' . $parentID), false);
        $this->db->insert('login_credential', $parent_credential);
        return $parentID;
    }

    // get parent list for CSV export
    public function getExportList($branchID = '')
    {
        $this->db->select('parent.*');
        $this->db->from('parent');
        $this->db->join('login_credential', 'login_credential.user_id = parent.id AND login_credential.role = 6', 'left');
        if (!empty($branchID)) {
            $this->db->where('parent.branch_id', $branchID);
        }
        $this->db->order_by('parent.id', 'ASC');
        return $this->db->get()->result();
    }
}
