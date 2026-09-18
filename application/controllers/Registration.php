<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Registration extends Authentication_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('employee_model');
    }

    public function index($url_alias = '')
    {
        if (is_loggedin()) {
            redirect(base_url('dashboard'));
        }

        $branch_id = 1; // Default to Tahsin Academy single branch
        $this->data['branch_id'] = $branch_id;
        $this->data['registration_closed'] = false;

        $selected_role = strtolower(trim((string)$this->input->get('role')));
        $valid_roles = array('facilitator', 'accountant', 'librarian', 'receptionist');
        if (!in_array($selected_role, $valid_roles)) {
            $selected_role = '';
        }
        $this->data['selected_role'] = $selected_role;

        $schoolDeatls = $this->authentication_model->getSchoolDeatls($url_alias);
        if (!empty($schoolDeatls) && is_object($schoolDeatls)) {
            $this->data['global_config']['institute_name'] = $schoolDeatls->school_name;
            $this->data['global_config']['address'] = $schoolDeatls->address;
            $this->data['global_config']['footer_text'] = '';
        }

        if ($_POST) {
            $this->form_validation->set_rules('register_as', 'Role Applying For', 'trim|required');
            $this->form_validation->set_rules('name', translate('name'), 'trim|required');
            $this->form_validation->set_rules('email', translate('email'), 'trim|required|valid_email|is_unique[staff.email]');
            $this->form_validation->set_rules('mobile_no', translate('mobile_no'), 'trim|required');
            $this->form_validation->set_rules('username', translate('username'), 'trim|required|is_unique[login_credential.username]');
            $this->form_validation->set_rules('password', translate('password'), 'trim|required|min_length[4]');
            $this->form_validation->set_rules('c_password', translate('confirm_password'), 'trim|required|matches[password]');

            if ($this->form_validation->run() !== false) {
                $register_as = strtolower($this->input->post('register_as'));
                $name        = trim($this->input->post('name'));
                $email       = trim($this->input->post('email'));
                $mobile_no   = trim($this->input->post('mobile_no'));
                $username    = trim($this->input->post('username'));
                $password    = $this->app_lib->pass_hashed($this->input->post('password'));

                // Role mappings
                // 3: Facilitator, 4: Accountant, 5: Librarian, 8: Receptionist
                $roleID         = 3; // Default Facilitator
                $designation_id = 2; // Facilitator
                $department_id  = 8; // Facilitating Staff
                $role_title     = 'Facilitator';

                if ($register_as == 'accountant') {
                    $roleID         = 4;
                    $designation_id = 5; // Accountant
                    $department_id  = 6; // Finance
                    $role_title     = 'Accountant';
                } elseif ($register_as == 'librarian') {
                    $roleID         = 5;
                    $designation_id = 4; // Librarian
                    $department_id  = 5; // Libraries
                    $role_title     = 'Librarian';
                } elseif ($register_as == 'receptionist') {
                    $roleID         = 8;
                    $receptionist_desig = $this->db->get_where('staff_designation', array('name' => 'Receptionist'))->row();
                    $designation_id = $receptionist_desig ? $receptionist_desig->id : 11;
                    $department_id  = 9; // Administrative Staff
                    $role_title     = 'Receptionist';
                }

                $staffData = array(
                    'name'         => $name,
                    'email'        => $email,
                    'mobileno'     => $mobile_no,
                    'branch_id'    => $branch_id,
                    'designation'  => $designation_id,
                    'department'   => $department_id,
                    'staff_id'     => 'TA-' . strtoupper(substr(uniqid(), -5)),
                    'joining_date' => date('Y-m-d'),
                );
                $this->db->insert('staff', $staffData);
                $userID = $this->db->insert_id();

                $credData = array(
                    'username'             => $username,
                    'password'             => $password,
                    'role'                 => $roleID,
                    'user_id'              => $userID,
                    'active'               => 0, // 0 = Pending Director Approval
                    'must_change_password' => 0,
                );
                $this->db->insert('login_credential', $credData);

                // Send immediate notifications to the Director
                $this->load->library('mailer');
                $review_url = base_url('credential_approvals');
                $institute_name = isset($this->data['global_config']['institute_name']) ? $this->data['global_config']['institute_name'] : 'Tahsin Academy';

                // Find all directors (Role ID 9)
                $directors = $this->db->select('lc.id, lc.user_id, lc.role, s.name, s.email, s.mobileno')
                    ->from('login_credential lc')
                    ->join('staff s', 's.id = lc.user_id', 'inner')
                    ->where('lc.role', 9)
                    ->get()->result();

                if (empty($directors)) {
                    $directors = array((object)array(
                        'user_id' => 11,
                        'email'   => 'dir@gmail.com',
                        'name'    => 'Director'
                    ));
                }

                $email_subject = "New Staff Registration: {$name} ({$role_title}) — {$institute_name}";
                $email_message = "Dear Director,<br><br>";
                $email_message .= "A new candidate has completed registration for the position of <strong>{$role_title}</strong> at <strong>{$institute_name}</strong>.<br><br>";
                $email_message .= "<table style='border-collapse:collapse;width:100%;max-width:500px;'>";
                $email_message .= "<tr><td style='padding:8px;border:1px solid #ddd;font-weight:bold;background:#f9fafb;'>Applicant Name:</td><td style='padding:8px;border:1px solid #ddd;'>" . html_escape($name) . "</td></tr>";
                $email_message .= "<tr><td style='padding:8px;border:1px solid #ddd;font-weight:bold;background:#f9fafb;'>Position / Role:</td><td style='padding:8px;border:1px solid #ddd;'>" . html_escape($role_title) . "</td></tr>";
                $email_message .= "<tr><td style='padding:8px;border:1px solid #ddd;font-weight:bold;background:#f9fafb;'>Email Address:</td><td style='padding:8px;border:1px solid #ddd;'>" . html_escape($email) . "</td></tr>";
                $email_message .= "<tr><td style='padding:8px;border:1px solid #ddd;font-weight:bold;background:#f9fafb;'>Mobile Number:</td><td style='padding:8px;border:1px solid #ddd;'>" . html_escape($mobile_no) . "</td></tr>";
                $email_message .= "<tr><td style='padding:8px;border:1px solid #ddd;font-weight:bold;background:#f9fafb;'>Username:</td><td style='padding:8px;border:1px solid #ddd;'><code>" . html_escape($username) . "</code></td></tr>";
                $email_message .= "<tr><td style='padding:8px;border:1px solid #ddd;font-weight:bold;background:#f9fafb;'>Submitted At:</td><td style='padding:8px;border:1px solid #ddd;'>" . date('M d, Y · h:i A') . "</td></tr>";
                $email_message .= "</table><br>";
                $email_message .= "The candidate cannot log in until you review and approve their application in the portal.<br><br>";
                $email_message .= "<a href='{$review_url}' style='display:inline-block;padding:10px 20px;background:#1a6b3c;color:#fff;text-decoration:none;border-radius:6px;font-weight:bold;'>Review &amp; Approve Application</a><br><br>";
                $email_message .= "Tahsin Academy Management System";

                $now = date('Y-m-d H:i:s');
                foreach ($directors as $dir) {
                    // 1. Send Email Notification
                    $dir_email = !empty($dir->email) ? $dir->email : 'dir@gmail.com';
                    $emailData = array(
                        'recipient' => $dir_email,
                        'subject'   => $email_subject,
                        'message'   => $email_message,
                    );
                    @$this->mailer->send($emailData);

                    // 2. In-App Message to Director
                    $msgData = array(
                        'body'        => "New staff application received for position <strong>{$role_title}</strong> from <strong>" . html_escape($name) . "</strong> (Email: {$email}, Phone: {$mobile_no}). Desired username: <code>{$username}</code>.<br><br><a href='{$review_url}' class='btn btn-success btn-xs'>Review Application</a>",
                        'subject'     => "New Staff Registration: {$name} ({$role_title})",
                        'file_name'   => '',
                        'enc_name'    => '',
                        'trash_sent'  => 0,
                        'trash_inbox' => 0,
                        'fav_inbox'   => 0,
                        'fav_sent'    => 0,
                        'reciever'    => "9-{$dir->user_id}",
                        'sender'      => '1-1',
                        'read_status' => 0,
                        'reply_status'=> 0,
                        'created_at'  => $now,
                        'updated_at'  => $now,
                    );
                    $this->db->insert('message', $msgData);
                }

                $this->session->set_flashdata('registered_role', $role_title);
                $this->session->set_flashdata('registered_name', $name);
                redirect(base_url('registration/success'));
            }
        }

        $this->load->view('authentication/registration', $this->data);
    }

    public function success()
    {
        $this->data['branch_id'] = 1;
        $this->data['registered_role'] = $this->session->flashdata('registered_role') ?: 'Staff Member';
        $this->data['registered_name'] = $this->session->flashdata('registered_name') ?: '';
        $this->load->view('authentication/registration_success', $this->data);
    }
}
