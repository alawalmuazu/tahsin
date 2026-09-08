<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @package : SmartSchool
 * @version : 7.0
 * @developed by : SmartSchool
 * @support : Jamilusalis@gmail.com
 * @author url : https://mjtech.com.ng
 * @filename : Authentication.php
 * @copyright : Reserved SmartSchool Team
 */

class Authentication extends Authentication_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    /* email is okey lets check the password now */
    public function index($url_alias = '')
    {
        if (is_loggedin()) {
            redirect(base_url('dashboard'));
        }

        if ($_POST) {
            $rules = array(
                array(
                    'field' => 'email',
                    'label' => "Email",
                    'rules' => 'trim|required',
                ),
                array(
                    'field' => 'password',
                    'label' => "Password",
                    'rules' => 'trim|required',
                ),
            );
            $this->form_validation->set_rules($rules);
            if ($this->form_validation->run() !== false) {
                $email = $this->input->post('email');
                $password = $this->input->post('password');
                // username is okey lets check the password now
                $login_credential = $this->authentication_model->login_credential($email, $password);
                if ($login_credential) {
                    if ($login_credential->active) {
                        $getUser = $this->authentication_model->getUserNameByRoleID($login_credential->role, $login_credential->user_id);
                        $getConfig = $this->db->select('translation,session_id')->get_where('global_settings', array('id' => 1))->row();
                        $language = $getConfig->translation;
                        $sessionID = $getConfig->session_id;
                        if($this->app_lib->isExistingAddon('saas')) {
                            if ($login_credential->role != 1) {
                                $schoolSettings = $this->db->select('id,translation')->where(array('id' => $getUser['branch_id'], 'status' => 1))->get('branch')->row();
                                if (empty($schoolSettings)) {
                                    set_alert('error', translate('inactive_school'));
                                    redirect(base_url('authentication'));
                                    exit();
                                }
                            }
                            if ($login_credential->role != 1) {
                                $language = $schoolSettings->translation;
                            }
                        }
                        // login user type
                        if ($login_credential->role == 6) {
                            $userType = 'parent';
                            // check parent login status
                            $getParentLoginStatus = $this->authentication_model->getParentLoginStatus($getUser['branch_id']);
                            if ($getParentLoginStatus == 0) {
                                set_alert('error', translate('parent_login_has_been_disabled'));
                                redirect(base_url('authentication'));
                                exit();
                            }
                        } elseif($login_credential->role == 7) {
                            $studentID = $getUser['id'];
                            $this->session->set_userdata('student_id', $studentID);
                            // check student login status
                            $getStudentLoginStatus = $this->authentication_model->getStudentLoginStatus($getUser['branch_id']);
                            if ($getStudentLoginStatus == 0) {
                                set_alert('error', translate('student_login_has_been_disabled'));
                                redirect(base_url('authentication'));
                                exit();
                            }
                            $studentSession = $this->application_model->getEnrollID($studentID, $sessionID);
                            if (is_array($studentSession)) {
                                $this->session->set_userdata('enrollID', $studentSession['id']);
                                $sessionID = $studentSession['session_id'];
                            } else {
                                $this->session->set_userdata('enrollID', $studentSession);
                            }
                            $userType = 'student';
                        } else {
                            $userType = 'staff';
                        }
                        $isRTL = $this->app_lib->getRTLStatus($language);
                        // get logger name
                        $sessionData = array(
                            'name' => $getUser['name'],
                            'logger_photo' => $getUser['photo'],
                            'loggedin_branch' => $getUser['branch_id'],
                            'loggedin_email' => $getUser['email'],
                            'loggedin_id' => $login_credential->id,
                            'loggedin_userid' => $login_credential->user_id,
                            'loggedin_role_id' => $login_credential->role,
                            'loggedin_type' => $userType,
                            'set_lang' =>  $language,
                            'is_rtl' => $isRTL,
                            'set_session_id' => $sessionID,
                            'loggedin' => true,
                        );

                        // two factor authentication
                        if($this->app_lib->isExistingAddon('two_fa') && moduleIsEnabled('two_fa')) {
                            $this->load->model('two_fa_model');
                            $manage_2FA = $this->two_fa_model->manage_2fa($sessionData, $login_credential, $getUser['email']);
                            if ($manage_2FA) {
                                $this->session->set_userdata('2FA', $sessionData);
                                redirect(base_url($this->authentication_model->getSegment(1) . 'two_fa_verification'));
                            } else {
                                $this->authentication_model->sessionSet($sessionData);
                            }
                        } else {
                            $this->authentication_model->sessionSet($sessionData);
                        }
                        
                        // is logged in
                        if ($this->session->has_userdata('redirect_url')) {
                            redirect($this->session->userdata('redirect_url'));
                        } else {
                            redirect(base_url('dashboard'));
                        }
                    } else {
                        set_alert('error', translate('inactive_account'));
                        redirect(base_url('authentication'));
                    }
                } else {
                    set_alert('error', translate('username_password_incorrect'));
                    redirect(base_url('authentication'));
                }
            }
        }
        $this->data['branch_id'] = $this->authentication_model->urlaliasToBranch($url_alias);
        $schoolDeatls = $this->authentication_model->getSchoolDeatls($url_alias);
        if (!empty($schoolDeatls) && is_object($schoolDeatls)) {
            $this->data['global_config']['institute_name'] = $schoolDeatls->school_name;
            $this->data['global_config']['address'] = $schoolDeatls->address;
            $this->data['global_config']['facebook_url'] = $schoolDeatls->facebook_url;
            $this->data['global_config']['twitter_url'] = $schoolDeatls->twitter_url;
            $this->data['global_config']['linkedin_url'] = $schoolDeatls->linkedin_url;
            $this->data['global_config']['youtube_url'] = $schoolDeatls->youtube_url;
        }
        $this->load->view('authentication/login', $this->data);
    }

    /**
     * AJAX: Login Branch Identity Cascade
     * Returns branch context for the brand panel animation.
     * Security: always returns a valid response (default for unknown users).
     */
    public function branch_context()
    {
        $this->output->set_content_type('application/json');
        $this->db->db_debug = false; // Prevent CI from crashing on DB errors
        
        $default = json_encode(array(
            'found'       => false,
            'branch_name' => '',
            'logo_url'    => base_url('uploads/app_image/logo.png') . '?src=' . time(),
        ));

        try {
            $username = $this->input->post('username');
            if (empty($username)) {
                $this->output->set_output($default);
                return;
            }
            $username = trim($username);

            // Look up the user's branch
            $cred = $this->db->select('role, user_id')
                             ->where('username', $username)
                             ->limit(1)
                             ->get('login_credential')
                             ->row();

            if (!$cred) {
                $this->output->set_output($default);
                return;
            }

            // Super admin — show default ministry branding
            if ($cred->role == 1) {
                $this->output->set_output($default);
                return;
            }

            // Get branch_id from the appropriate table
            $branch_id = 0;
            if ($cred->role == 6) {
                $u = $this->db->select('branch_id')->where('id', $cred->user_id)->get('parent')->row();
                if ($u) $branch_id = $u->branch_id;
            } elseif ($cred->role == 7) {
                $u = $this->db->select('branch_id')->where('student_id', $cred->user_id)->limit(1)->get('enroll')->row();
                if ($u) $branch_id = $u->branch_id;
            } else {
                $u = $this->db->select('branch_id')->where('id', $cred->user_id)->get('staff')->row();
                if ($u) $branch_id = $u->branch_id;
            }

            if (empty($branch_id)) {
                $this->output->set_output($default);
                return;
            }

            // Get branch name
            $branch = $this->db->select('name, school_name')
                               ->where('id', $branch_id)
                               ->get('branch')
                               ->row();

            if (!$branch) {
                $this->output->set_output($default);
                return;
            }

            $logo_url = $this->application_model->getBranchImage($branch_id, 'logo');
            $branch_name = !empty($branch->school_name) ? $branch->school_name : $branch->name;

            $this->output->set_output(json_encode(array(
                'found'       => true,
                'branch_name' => $branch_name,
                'logo_url'    => $logo_url,
            )));
        } catch (Exception $e) {
            $this->output->set_output($default);
        }
    }

    // hybrid IAM deferred setup
    public function setup_account($token = '')
    {
        if (is_loggedin()) {
            redirect(base_url('dashboard'), 'refresh');
        }

        if (empty($token)) {
            set_alert('error', 'Invalid setup link.');
            redirect(base_url('authentication'));
        }

        // Verify token
        $credential = $this->db->get_where('login_credential', array('setup_token' => $token, 'active' => 2))->row();
        if (!$credential) {
            set_alert('error', 'The setup link is invalid or has expired.');
            redirect(base_url('authentication'));
        }

        if ($_POST) {
            $this->form_validation->set_rules('username', 'Username', 'trim|required|is_unique[login_credential.username]');
            $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[4]');
            $this->form_validation->set_rules('c_password', 'Confirm Password', 'trim|required|matches[password]');

            if ($this->form_validation->run() !== false) {
                $updateData = array(
                    'username' => $this->input->post('username'),
                    'password' => $this->app_lib->pass_hashed($this->input->post('password')),
                    'active' => 1,
                    'setup_token' => NULL
                );
                
                $this->db->where('id', $credential->id);
                $this->db->update('login_credential', $updateData);

                set_alert('success', 'Your account has been set up successfully. You can now log in.');
                redirect(base_url('authentication'));
            }
        }
        
        $this->data['token'] = $token;
        $this->load->view('authentication/setup_account', $this->data);
    }

    // hybrid IAM deferred setup bulk dispatch
    public function dispatch_pending_invites()
    {
        if (!is_superadmin_loggedin() && !get_permission('employee_disable_authentication', 'is_add')) {
             access_denied();
        }
        $branchID = $this->application_model->get_branch_id();
        
        $this->db->where('active', 2);
        if (!is_superadmin_loggedin()) {
            $this->db->group_start();
            $this->db->where("user_id IN (SELECT id FROM staff WHERE branch_id = $branchID) AND role NOT IN (6,7)");
            $this->db->or_where("user_id IN (SELECT id FROM student WHERE parent_id IN (SELECT id FROM parent WHERE branch_id = $branchID)) AND role = 7");
            $this->db->or_where("user_id IN (SELECT id FROM parent WHERE branch_id = $branchID) AND role = 6");
            $this->db->group_end();
        }
        $pending = $this->db->get('login_credential')->result();
        
        $count = 0;
        $this->load->model('email_model');

        foreach ($pending as $cred) {
            $email = '';
            $name = '';
            if ($cred->role == 7) {
                $user = $this->db->get_where('student', array('id' => $cred->user_id))->row();
                $email = $user ? $user->email : '';
                $name = $user ? $user->first_name . ' ' . $user->last_name : '';
            } elseif ($cred->role == 6) {
                $user = $this->db->get_where('parent', array('id' => $cred->user_id))->row();
                $email = $user ? $user->email : '';
                $name = $user ? $user->name : '';
            } else {
                $user = $this->db->get_where('staff', array('id' => $cred->user_id))->row();
                $email = $user ? $user->email : '';
                $name = $user ? $user->name : '';
            }

            if (!empty($email) && !empty($cred->setup_token)) {
                $this->email_model->sendAccountSetupInvite(array(
                    'email' => $email,
                    'name' => $name,
                    'setup_token' => $cred->setup_token,
                    'branch_id' => $branchID
                ));
                $count++;
            }
        }
        set_alert('success', $count . ' setup invitations have been dispatched to pending users.');
        redirect(isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : base_url('dashboard'));
    }

    // forgot password
    public function forgot($url_alias = '')
    {
        if (is_loggedin()) {
            redirect(base_url('dashboard'), 'refresh');
        }

        if ($_POST) {
            $config = array(
                array(
                    'field' => 'username',
                    'label' => 'Email',
                    'rules' => 'trim|required',
                ),
            );
            $this->form_validation->set_rules($config);
            if ($this->form_validation->run() !== false) {
                $username = $this->input->post('username');
                $res = $this->authentication_model->lose_password($username);
                if ($res == true) {
                    $this->session->set_flashdata('reset_res', 'true');
                    redirect(base_url('authentication/forgot'));
                } else {
                    $this->session->set_flashdata('reset_res', 'false');
                    redirect(base_url('authentication/forgot'));
                }
            }
        }
        $this->data['branch_id'] = $this->authentication_model->urlaliasToBranch($url_alias);
        $schoolDeatls = $this->authentication_model->getSchoolDeatls($url_alias);
        if (!empty($schoolDeatls) && is_object($schoolDeatls)) {
            $this->data['global_config']['institute_name'] = $schoolDeatls->school_name;
            $this->data['global_config']['address'] = $schoolDeatls->address;
            $this->data['global_config']['facebook_url'] = $schoolDeatls->facebook_url;
            $this->data['global_config']['twitter_url'] = $schoolDeatls->twitter_url;
            $this->data['global_config']['linkedin_url'] = $schoolDeatls->linkedin_url;
            $this->data['global_config']['youtube_url'] = $schoolDeatls->youtube_url;
        }
        $this->load->view('authentication/forgot', $this->data);
    }

    /* password reset */
    public function pwreset()
    {
        if (is_loggedin()) {
            redirect(base_url('dashboard'), 'refresh');
        }

        $key = $this->input->get('key');
        if (!empty($key)) {
            $query = $this->db->get_where('reset_password', array('key' => $key));
            if ($query->num_rows() > 0) {
                $login_credential_id = $query->row()->login_credential_id;
                $user = $this->db->get_where('login_credential', array('id' => $login_credential_id))->row();
                if ($user) {
                    $getUser = $this->authentication_model->getUserNameByRoleID($user->role, $user->user_id);
                    $this->data['branch_id'] = $getUser['branch_id'];
                } else {
                    $this->data['branch_id'] = '';
                }

                if ($this->input->post()) {
                    $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[4]|matches[c_password]');
                    $this->form_validation->set_rules('c_password', 'Confirm Password', 'trim|required|min_length[4]');
                    if ($this->form_validation->run() !== false) {
                        $password = $this->app_lib->pass_hashed($this->input->post('password'));
                        $this->db->where('id', $query->row()->login_credential_id);
                        $this->db->update('login_credential', array('password' => $password));
                        $this->db->where('login_credential_id', $query->row()->login_credential_id);
                        $this->db->delete('reset_password');
                        set_alert('success', 'Password Reset Successfully');
                        redirect(base_url('authentication'));
                    }
                }
                $this->load->view('authentication/pwreset', $this->data);
            } else {
                set_alert('error', 'Token Has Expired');
                redirect(base_url('authentication'));
            }
        } else {
            set_alert('error', 'Token Has Expired');
            redirect(base_url('authentication'));
        }
    }

    /* session logout */
    public function logout()
    {
        $webURL = base_url();
        if (!is_superadmin_loggedin()) {
            $cmsRow = $this->db->select('cms_active,url_alias')
            ->where('branch_id', get_loggedin_branch_id())
            ->get('front_cms_setting')->row_array();
            if (isset($cmsRow['cms_active']) && $cmsRow['cms_active'] == 1) {
                $webURL = base_url((isset($cmsRow['url_alias']) ? $cmsRow['url_alias'] : '') );
            }
        }

        $this->session->unset_userdata('name');
        $this->session->unset_userdata('logger_photo');
        $this->session->unset_userdata('loggedin_id');
        $this->session->unset_userdata('loggedin_userid');
        $this->session->unset_userdata('loggedin_type');
        $this->session->unset_userdata('set_lang');
        $this->session->unset_userdata('set_session_id');
        $this->session->unset_userdata('loggedin_branch');
        $this->session->unset_userdata('loggedin');
        $this->session->sess_destroy();
        redirect($webURL, 'refresh');
    }

    /* Setup Credentials from Invitation */
    public function setup_credentials($token = '')
    {
        if (empty($token)) {
            show_404();
        }

        $query = $this->db->get_where('login_credential', array('setup_token' => $token, 'active' => 2));
        if ($query->num_rows() == 0) {
            set_alert('error', 'Invalid or expired setup token.');
            redirect(base_url('authentication'));
        }

        $user = $query->row();
        $getUser = $this->authentication_model->getUserNameByRoleID($user->role, $user->user_id);
        $this->data['branch_id'] = isset($getUser['branch_id']) ? $getUser['branch_id'] : '';
        
        if ($_POST) {
            $this->form_validation->set_rules('username', translate('username'), 'trim|required|is_unique[login_credential.username]');
            $this->form_validation->set_rules('password', translate('password'), 'trim|required|min_length[4]');
            $this->form_validation->set_rules('retype_password', translate('retype_password'), 'trim|required|matches[password]');
            
            if ($this->form_validation->run() !== false) {
                $update_data = array(
                    'username' => $this->input->post('username'),
                    'password' => $this->app_lib->pass_hashed($this->input->post('password')),
                    'setup_token' => NULL,
                    'active' => 0 // 0 means pending admin approval
                );
                
                $this->db->where('id', $user->id);
                $this->db->update('login_credential', $update_data);
                
                set_alert('success', 'Your credentials have been securely saved and are awaiting Admin approval. You will be notified once activated.');
                redirect(base_url('authentication'));
            }
        }
        
        $this->data['token'] = $token;
        $this->load->view('authentication/setup_credentials', $this->data);
    }

}
