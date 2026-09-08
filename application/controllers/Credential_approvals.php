<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Credential_approvals extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!is_superadmin_loggedin() && !get_permission('employee', 'is_add')) {
            access_denied();
        }
    }

    public function index()
    {
        $this->data['title'] = 'Pending Credential Approvals';
        $this->data['sub_page'] = 'credential_approvals/index';
        $this->data['main_menu'] = 'employee';
        
        $branch_id = $this->application_model->get_branch_id();
        
        // Fetch all pending login_credentials
        $this->db->select('lc.*, r.name as role_name');
        $this->db->from('login_credential lc');
        $this->db->join('roles r', 'r.id = lc.role', 'left');
        $this->db->where('lc.active', 0); // 0 = Pending Admin Approval
        $pending = $this->db->get()->result();
        
        // Enrich data with user details
        foreach ($pending as &$p) {
            $p->user_name = 'Unknown';
            $p->branch_id = 0;
            if ($p->role == 7) {
                $u = $this->db->get_where('student', array('id' => $p->user_id))->row();
                if ($u) {
                    $p->user_name = $u->first_name . ' ' . $u->last_name;
                    $p->branch_id = $u->branch_id;
                }
            } elseif ($p->role == 6) {
                $u = $this->db->get_where('parent', array('id' => $p->user_id))->row();
                if ($u) {
                    $p->user_name = $u->name;
                    $p->branch_id = $u->branch_id;
                }
            } else {
                $u = $this->db->get_where('staff', array('id' => $p->user_id))->row();
                if ($u) {
                    $p->user_name = $u->name;
                    $p->branch_id = $u->branch_id;
                }
            }
        }
        
        // Filter by branch if not superadmin
        if (!is_superadmin_loggedin()) {
            $filtered = [];
            foreach ($pending as $p) {
                if ($p->branch_id == $branch_id) {
                    $filtered[] = $p;
                }
            }
            $this->data['pending_approvals'] = $filtered;
        } else {
            $this->data['pending_approvals'] = $pending;
        }

        $this->load->view('layout/index', $this->data);
    }
    
    public function approve($id)
    {
        $this->db->where('id', $id);
        $this->db->update('login_credential', array('active' => 1));
        
        // Optional: Send activation email
        
        set_alert('success', 'Credentials have been approved successfully!');
        redirect(base_url('credential_approvals'));
    }
    
    public function reject($id)
    {
        // Delete the pending credential
        $this->db->where('id', $id);
        $this->db->where('active', 0);
        $this->db->delete('login_credential');
        
        set_alert('success', 'Application rejected and credentials removed.');
        redirect(base_url('credential_approvals'));
    }
}
