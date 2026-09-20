<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Credential_approvals extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!is_superadmin_loggedin() && !is_director_loggedin() && !get_permission('employee', 'is_add')) {
            access_denied();
        }
        $this->load->library('mailer');
    }

    public function index()
    {
        $this->data['title'] = 'Registration Approvals';
        $this->data['sub_page'] = 'credential_approvals/index';
        $this->data['main_menu'] = 'employee';
        $branch_id = $this->application_model->get_branch_id();
        
        // Fetch registration settings
        $this->data['reg_settings'] = $this->db->select('staff_registration_enabled, staff_registration_deadline')->where('id', 1)->get('global_settings')->row();
        
        // Fetch all pending login_credentials
        $this->db->select('lc.*, r.name as role_name');
        $this->db->from('login_credential lc');
        $this->db->join('roles r', 'r.id = lc.role', 'left');
        $this->db->where('lc.active', 0); // 0 = Pending Approval
        $this->db->order_by('lc.id', 'DESC');
        $pending = $this->db->get()->result();
        
        // Enrich data with user details
        $filtered = [];
        foreach ($pending as $p) {
            $p->user_name = 'Unknown';
            $p->user_email = '';
            $p->user_mobile = '';
            $p->reg_date = $p->created_at;
            $p->branch_id = 1;

            if ($p->role == 7) {
                $u = $this->db->get_where('student', array('id' => $p->user_id))->row();
                if ($u) {
                    $p->user_name = trim($u->first_name . ' ' . $u->last_name);
                    $p->user_email = $u->email;
                    $p->user_mobile = $u->mobileno;
                    $p->branch_id = $u->branch_id;
                }
            } elseif ($p->role == 6) {
                $u = $this->db->get_where('parent', array('id' => $p->user_id))->row();
                if ($u) {
                    $p->user_name = $u->name;
                    $p->user_email = $u->email;
                    $p->user_mobile = $u->mobileno;
                    $p->branch_id = $u->branch_id;
                }
            } else {
                $u = $this->db->select('staff.*, staff_designation.name as designation_name, staff_department.name as department_name')
                    ->from('staff')
                    ->join('staff_designation', 'staff_designation.id = staff.designation', 'left')
                    ->join('staff_department', 'staff_department.id = staff.department', 'left')
                    ->where('staff.id', $p->user_id)
                    ->get()->row();
                if ($u) {
                    $p->user_name = $u->name;
                    $p->user_email = $u->email;
                    $p->user_mobile = $u->mobileno;
                    $p->branch_id = $u->branch_id;
                    $p->staff_id_no = $u->staff_id;
                    $p->photo = $u->photo;
                    $p->qualification = $u->qualification;
                    $p->designation_name = $u->designation_name;
                    $p->department_name = $u->department_name;
                    $p->joining_date = $u->joining_date;
                    $p->sex = $u->sex;
                    $p->present_address = $u->present_address;
                }
            }

            if (is_superadmin_loggedin() || is_director_loggedin() || $p->branch_id == $branch_id) {
                $filtered[] = $p;
            }
        }
        
        $this->data['pending_approvals'] = $filtered;
        $this->load->view('layout/index', $this->data);
    }

    public function invite()
    {
        $this->data['title'] = 'Send Staff Registration Links';
        $this->data['sub_page'] = 'credential_approvals/invite';
        $this->data['main_menu'] = 'employee';
        
        // Instant-invite roles only (matches Instant Role Registration Links)
        $this->data['available_roles'] = array(
            array('slug' => 'facilitator', 'name' => 'Facilitator'),
            array('slug' => 'accountant', 'name' => 'Accountant'),
            array('slug' => 'librarian', 'name' => 'Librarian'),
            array('slug' => 'receptionist', 'name' => 'Receptionist'),
        );

        // Keep production role label as Facilitator (not Teacher/Teachers)
        $this->app_lib->ensureRoleAlignedOrgUnits();

        // Check if director submitted direct invitation
        if ($this->input->post('send_invite')) {
            $candidate_name  = trim((string)$this->input->post('candidate_name'));
            $candidate_email = trim((string)$this->input->post('candidate_email'));
            $candidate_role  = strtolower(trim((string)$this->input->post('candidate_role')));
            $personal_note   = trim((string)$this->input->post('personal_note'));

            $valid_roles = array('facilitator', 'accountant', 'librarian', 'receptionist');
            $role_labels = array(
                'facilitator'   => 'Facilitator',
                'accountant'    => 'Accountant',
                'librarian'     => 'Librarian',
                'receptionist'  => 'Receptionist',
            );

            if (in_array($candidate_role, $valid_roles, true) && filter_var($candidate_email, FILTER_VALIDATE_EMAIL)) {
                $role_label = $role_labels[$candidate_role];
                // Generate a hashed invite link to prevent role tampering
                $hash_token = urlencode(base64_encode(openssl_encrypt($candidate_role, 'AES-128-ECB', 'TAHSIN_SECRET')));
                $reg_link = base_url('registration?token=' . $hash_token);
                
                // Attempt to send email via application mailer
                $institute_name = $this->data['global_config']['institute_name'] ?: 'Tahsin Academy';
                $email_subject = "Staff Registration Invitation — {$role_label} at {$institute_name}";
                $email_message = "Dear {$candidate_name},<br><br>";
                $email_message .= "You have been invited by the Director of <strong>{$institute_name}</strong> to register for the position of <strong>{$role_label}</strong>.<br><br>";
                if (!empty($personal_note)) {
                    $email_message .= "<em>\"" . html_escape($personal_note) . "\"</em><br><br>";
                }
                $email_message .= "Please complete your registration details using the link below:<br>";
                $email_message .= "<a href='{$reg_link}' style='display:inline-block;padding:10px 18px;background:#1a6b3c;color:#fff;text-decoration:none;border-radius:6px;margin:12px 0;'>Complete Registration</a><br>";
                $email_message .= "Direct URL: <a href='{$reg_link}'>{$reg_link}</a><br><br>";
                $email_message .= "After you submit the form, your registration will be reviewed and activated by the Director.<br><br>Best regards,<br>Office of the Director<br>{$institute_name}";

                $emailData = array(
                    'branch_id' => $this->application_model->get_branch_id(),
                    'recipient' => $candidate_email,
                    'subject'   => $email_subject,
                    'message'   => $email_message,
                );

                if (@$this->mailer->send($emailData)) {
                    set_alert('success', "Invitation emailed to {$candidate_name} ({$role_label})! Registration link: {$reg_link}");
                } else {
                    set_alert('error', "Invitation link generated, but the email failed to send. Please check your SMTP settings. You can still manually send the link below.");
                }
                
                $this->session->set_flashdata('generated_invite_link', $reg_link);
                $this->session->set_flashdata('generated_invite_name', $candidate_name);
                $this->session->set_flashdata('generated_invite_role', $role_label);
                redirect(base_url('credential_approvals/invite'));
            } else {
                set_alert('error', 'Please provide a valid candidate email and select an allowed role.');
            }
        }

        $this->load->view('layout/index', $this->data);
    }
    
    public function approve($id)
    {
        $id = (int)$id;
        $cred = $this->db->get_where('login_credential', array('id' => $id, 'active' => 0))->row();
        
        if ($cred) {
            // Activate credential
            $this->db->where('id', $id);
            $this->db->update('login_credential', array('active' => 1));

            // Activate staff or user record
            $user_name = 'User';
            $user_email = '';
            if ($cred->role != 6 && $cred->role != 7) {
                $staff = $this->db->get_where('staff', array('id' => $cred->user_id))->row();
                if ($staff) {
                    $user_name = $staff->name;
                    $user_email = $staff->email;
                }
            }

            // Get role name
            $role_row = $this->db->get_where('roles', array('id' => $cred->role))->row();
            $role_name = $role_row ? $role_row->name : 'Staff';

            // Send approval email if email is present
            if (!empty($user_email) && filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
                $institute_name = $this->data['global_config']['institute_name'] ?: 'Tahsin Academy';
                $login_url = base_url('authentication');
                $emailData = array(
                    'branch_id' => $this->application_model->get_branch_id(),
                    'recipient' => $user_email,
                    'subject'   => "Account Approved — Welcome to {$institute_name}",
                    'message'   => "Dear {$user_name},<br><br>Your registration as <strong>{$role_name}</strong> has been reviewed and <strong>APPROVED</strong> by the Director.<br><br>You can now log in to the portal with your credentials:<br><a href='{$login_url}' style='display:inline-block;padding:10px 18px;background:#1a6b3c;color:#fff;text-decoration:none;border-radius:6px;margin:12px 0;'>Log In to Portal</a><br>Username: <strong>{$cred->username}</strong><br><br>Welcome to Tahsin Academy!<br>Office of the Director",
                );
                @$this->mailer->send($emailData);
            }
            
            set_alert('success', "Registration for {$user_name} ({$role_name}) approved successfully! Account is now active.");
        } else {
            set_alert('error', 'Unable to find matching pending application.');
        }

        redirect(base_url('credential_approvals'));
    }
    
    public function reject($id)
    {
        $id = (int)$id;
        $cred = $this->db->get_where('login_credential', array('id' => $id, 'active' => 0))->row();

        if ($cred) {
            $user_id = $cred->user_id;
            $role_id = $cred->role;

            // Delete credential
            $this->db->where('id', $id);
            $this->db->delete('login_credential');

            // Delete associated pending staff record
            if ($role_id != 6 && $role_id != 7) {
                $this->db->where('id', $user_id);
                $this->db->delete('staff');
            }

            set_alert('success', 'Application rejected and credentials removed.');
        } else {
            set_alert('error', 'Record not found.');
        }

        redirect(base_url('credential_approvals'));
    }

    public function save_settings()
    {
        if (!is_superadmin_loggedin() && !is_director_loggedin() && !get_permission('employee', 'is_add')) {
            access_denied();
        }

        $enabled = $this->input->post('staff_registration_enabled') ? 1 : 0;
        $deadline = $this->input->post('staff_registration_deadline');

        $update_data = array(
            'staff_registration_enabled' => $enabled,
            'staff_registration_deadline' => empty($deadline) ? NULL : date('Y-m-d', strtotime($deadline))
        );

        $this->db->where('id', 1);
        $this->db->update('global_settings', $update_data);

        set_alert('success', 'Registration settings updated successfully.');
        redirect(base_url('credential_approvals'));
    }

    public function check_pending_ajax()
    {
        $this->output->set_content_type('application/json');
        if (!is_loggedin()) {
            echo json_encode(array('count' => 0, 'pending' => array()));
            return;
        }

        $pending = $this->db->select('lc.id, lc.user_id, lc.role, lc.created_at, r.name as role_name, s.name as user_name')
            ->from('login_credential lc')
            ->join('roles r', 'r.id = lc.role', 'left')
            ->join('staff s', 's.id = lc.user_id', 'left')
            ->where('lc.active', 0)
            ->where_in('lc.role', array(3, 4, 5, 8))
            ->order_by('lc.id', 'DESC')
            ->get()->result();

        echo json_encode(array(
            'count' => count($pending),
            'pending' => $pending
        ));
    }
}
