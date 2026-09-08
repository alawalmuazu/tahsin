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

        // Get branch from URL alias
        $branch_id = $this->authentication_model->urlaliasToBranch($url_alias);
        if (empty($branch_id)) {
            // default to first branch or master branch
            $branch = $this->db->select('id')->limit(1)->get('branch')->row();
            $branch_id = $branch ? $branch->id : 1;
        }
        
        $this->data['branch_id'] = $branch_id;
        
        // Check if public registration is enabled globally/branch
        $branchDetails = $this->db->get_where('branch', array('id' => $branch_id))->row();
        if (!$branchDetails || $branchDetails->public_registration != 1) {
            $this->data['registration_closed'] = true;
        } else {
            $this->data['registration_closed'] = false;
        }

        $schoolDeatls = $this->authentication_model->getSchoolDeatls($url_alias);
        if (!empty($schoolDeatls) && is_object($schoolDeatls)) {
            $this->data['global_config']['institute_name'] = $schoolDeatls->school_name;
            $this->data['global_config']['address'] = $schoolDeatls->address;
            $this->data['global_config']['footer_text'] = '';
        }

        if ($_POST && !$this->data['registration_closed']) {
            $this->form_validation->set_rules('register_as', translate('register_as'), 'trim|required');
            $this->form_validation->set_rules('name', translate('name'), 'trim|required');
            $this->form_validation->set_rules('email', translate('email'), 'trim|required|valid_email');
            $this->form_validation->set_rules('mobile_no', translate('mobile_no'), 'trim|required');
            $this->form_validation->set_rules('username', translate('username'), 'trim|required|is_unique[login_credential.username]');
            $this->form_validation->set_rules('password', translate('password'), 'trim|required|min_length[4]');
            $this->form_validation->set_rules('c_password', translate('confirm_password'), 'trim|required|matches[password]');

            if ($this->form_validation->run() !== false) {
                $register_as = $this->input->post('register_as');
                $name = $this->input->post('name');
                $email = $this->input->post('email');
                $mobile_no = $this->input->post('mobile_no');
                $username = $this->input->post('username');
                $password = $this->app_lib->pass_hashed($this->input->post('password'));

                if ($register_as == 'parent') {
                    $parentData = array(
                        'name' => $name,
                        'email' => $email,
                        'mobileno' => $mobile_no,
                        'branch_id' => $branch_id
                    );
                    $this->db->insert('parent', $parentData);
                    $userID = $this->db->insert_id();
                    $roleID = 6;
                } else {
                    $staffData = array(
                        'name' => $name,
                        'email' => $email,
                        'mobileno' => $mobile_no,
                        'branch_id' => $branch_id,
                        'staff_id' => substr(app_generate_hash(), 3, 7)
                    );
                    $this->db->insert('staff', $staffData);
                    $userID = $this->db->insert_id();
                    // By default, assign to Teacher (3) or Employee (2). Let's use 3.
                    $roleID = ($register_as == 'teacher') ? 3 : 2; 
                }

                $credData = array(
                    'username' => $username,
                    'password' => $password,
                    'role' => $roleID,
                    'user_id' => $userID,
                    'active' => 0 // Pending Admin Approval
                );
                $this->db->insert('login_credential', $credData);

                $this->session->set_flashdata('alert-message-success', 'Your application has been received successfully! You will be notified once the Administrator approves your account.');
                redirect(base_url('registration/success'));
            }
        }

        $this->load->view('authentication/registration', $this->data);
    }
    
    public function success() {
        $this->data['branch_id'] = 1;
        $this->load->view('authentication/registration_success', $this->data);
    }
}
