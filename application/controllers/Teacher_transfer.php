<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Teacher_transfer extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('teacher_transfer_model');
        $this->load->library('upload');
        // Check permission from RBAC
        if (!get_permission('teacher_transfer', 'is_view')) {
            // Bypass view restriction exclusively for standard staff (not students or parents)
            if (loggedin_role_id() == 6 || loggedin_role_id() == 7) {
                access_denied();
            }
        }
    }

    public function index()
    {
        $this->data['title'] = 'Teacher Transfers';
        $this->data['sub_page'] = 'transfer/index';
        $this->data['main_menu'] = 'teacher_transfer';
        
        if (!get_permission('teacher_transfer', 'is_view')) {
            $staff_id = get_loggedin_user_id();
            $this->data['pending_transfers'] = $this->teacher_transfer_model->getPendingTransfers($staff_id);
            $this->data['all_transfers'] = $this->teacher_transfer_model->getAllTransfers($staff_id);
        } else {
            $this->data['pending_transfers'] = $this->teacher_transfer_model->getPendingTransfers();
            $this->data['all_transfers'] = $this->teacher_transfer_model->getAllTransfers();
        }

        $this->db->select('id, name');
        $this->data['branch_list'] = $this->db->get('branch')->result_array();
        
        $this->load->view('layout/index', $this->data);
    }

    public function create()
    {
        if (!get_permission('teacher_transfer', 'is_add')) {
            if (loggedin_role_id() == 6 || loggedin_role_id() == 7) {
                access_denied();
            }
        }

        $staff_id = get_permission('teacher_transfer', 'is_add') ? null : get_loggedin_user_id();

        // Block if a pending request already exists for this staff
        if ($staff_id && $this->teacher_transfer_model->hasPendingRequest($staff_id)) {
            $this->data['title'] = 'Initiate Transfer';
            $this->data['sub_page'] = 'transfer/create';
            $this->data['main_menu'] = 'teacher_transfer';
            $this->data['has_pending'] = true;
            $this->data['staff_list'] = [];
            $this->data['branch_list'] = [];
            $this->load->view('layout/index', $this->data);
            return;
        }

        if ($_POST) {
            $this->form_validation->set_rules('staff_id', 'Teacher', 'trim|required');
            $this->form_validation->set_rules('to_branch_id', 'Target School', 'trim|required');
            $this->form_validation->set_rules('effective_date', 'Effective Date', 'trim|required');
            $this->form_validation->set_rules('reason', 'Reason', 'trim|required');

            if ($this->form_validation->run() !== false) {
                $resolved_staff_id = get_permission('teacher_transfer', 'is_add') ? $this->input->post('staff_id') : get_loggedin_user_id();
                $staff = $this->db->get_where('staff', ['id' => $resolved_staff_id])->row_array();

                // Double check pending for non-admin submitting via POST
                if (!get_permission('teacher_transfer', 'is_add') && $this->teacher_transfer_model->hasPendingRequest($resolved_staff_id)) {
                    set_alert('error', 'You already have an active pending transfer request.');
                    redirect(base_url('teacher_transfer'));
                }

                // Handle file upload
                $attachment = null;
                if (!empty($_FILES['attachment_file']['name'])) {
                    $upload_config = [
                        'upload_path'   => './uploads/transfer_attachments/',
                        'allowed_types' => 'pdf|jpg|jpeg|png',
                        'max_size'      => 5120,
                        'encrypt_name'  => true
                    ];
                    $this->upload->initialize($upload_config);
                    if ($this->upload->do_upload('attachment_file')) {
                        $attachment = $this->upload->data('file_name');
                    } else {
                        set_alert('error', $this->upload->display_errors('', ''));
                        redirect(base_url('teacher_transfer/create'));
                    }
                }
                
                $data = [
                    'staff_id'       => $resolved_staff_id,
                    'from_branch_id' => $staff['branch_id'] ? $staff['branch_id'] : 0,
                    'to_branch_id'   => $this->input->post('to_branch_id'),
                    'effective_date' => $this->input->post('effective_date'),
                    'reason'         => $this->input->post('reason'),
                    'attachment'     => $attachment,
                    'status'         => 'pending'
                ];
                
                $this->teacher_transfer_model->createTransfer($data);
                set_alert('success', 'Transfer request submitted successfully.');
                redirect(base_url('teacher_transfer'));
            }
        }
        
        $this->data['title'] = 'Initiate Transfer';
        $this->data['sub_page'] = 'transfer/create';
        $this->data['main_menu'] = 'teacher_transfer';
        $this->data['has_pending'] = false;
        
        $this->db->select('id, name, branch_id');
        $this->data['staff_list'] = $this->db->get('staff')->result_array();
        
        $this->db->select('id, name');
        $this->data['branch_list'] = $this->db->get('branch')->result_array();
        
        $this->load->view('layout/index', $this->data);
    }

    public function approve($id)
    {
        if (!get_permission('teacher_transfer', 'is_edit')) {
            access_denied();
        }

        if ($_POST) {
            $reviewer_id = get_loggedin_user_id();
            $override_branch = $this->input->post('override_branch_id') ?: null;
            if ($this->teacher_transfer_model->approveTransfer($id, $reviewer_id, $override_branch)) {
                set_alert('success', 'Transfer approved successfully.');
            } else {
                set_alert('error', 'Failed to approve transfer.');
            }
            redirect(base_url('teacher_transfer'));
        }
    }

    public function reject($id)
    {
        if (!get_permission('teacher_transfer', 'is_edit')) {
            access_denied();
        }

        if ($_POST) {
            $note = $this->input->post('rejection_note');
            $reviewer_id = get_loggedin_user_id();
            
            if ($this->teacher_transfer_model->rejectTransfer($id, $note, $reviewer_id)) {
                set_alert('success', 'Transfer rejected');
            } else {
                set_alert('error', 'Failed to reject transfer');
            }
            redirect(base_url('teacher_transfer'));
        }
    }

    public function history($staff_id = '')
    {
        if (empty($staff_id)) {
            redirect(base_url('teacher_transfer'));
        }
        
        $this->data['title'] = 'Posting History';
        $this->data['sub_page'] = 'transfer/history';
        $this->data['main_menu'] = 'teacher_transfer';
        
        $this->data['staff'] = $this->db->get_where('staff', ['id' => $staff_id])->row_array();
        $this->data['history'] = $this->teacher_transfer_model->getPostingHistory($staff_id);
        
        $this->load->view('layout/index', $this->data);
    }
}
