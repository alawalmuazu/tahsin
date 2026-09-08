<?php
defined('BASEPATH') or exit('No direct script access allowed');

class School_inspection extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('school_inspection_model');
        if (!get_permission('school_inspection', 'is_view')) {
            access_denied();
        }
    }

    public function index()
    {
        $this->data['title'] = 'School Inspections';
        $this->data['sub_page'] = 'inspection/index';
        $this->data['main_menu'] = 'school_inspection';
        
        $this->data['reports'] = $this->school_inspection_model->getReports();
        
        $this->load->view('layout/index', $this->data);
    }

    public function add()
    {
        if (!get_permission('school_inspection', 'is_add')) {
            access_denied();
        }

        if ($_POST) {
            $workflow_state = $this->input->post('workflow_state');
            $this->form_validation->set_rules('branch_id', 'School', 'trim|required');
            $this->form_validation->set_rules('inspection_date', 'Inspection Date', 'trim|required');
            $this->form_validation->set_rules('inspector_id', 'Inspector', 'trim|required');
            
            if ($workflow_state == 'completed') {
                $this->form_validation->set_rules('infrastructure_score', 'Infrastructure Score', 'trim|required|numeric|less_than_equal_to[100]');
                $this->form_validation->set_rules('teaching_quality_score', 'Teaching Quality Score', 'trim|required|numeric|less_than_equal_to[100]');
                $this->form_validation->set_rules('compliance_score', 'Compliance Score', 'trim|required|numeric|less_than_equal_to[100]');
            }

            if ($this->form_validation->run() !== false) {
                $data = [
                    'branch_id' => $this->input->post('branch_id'),
                    'inspector_id' => $this->input->post('inspector_id') ? $this->input->post('inspector_id') : get_loggedin_user_id(),
                    'inspection_date' => $this->input->post('inspection_date'),
                    'infrastructure_score' => $workflow_state == 'completed' ? $this->input->post('infrastructure_score') : 0,
                    'teaching_quality_score' => $workflow_state == 'completed' ? $this->input->post('teaching_quality_score') : 0,
                    'compliance_score' => $workflow_state == 'completed' ? $this->input->post('compliance_score') : 0,
                    'recommendations' => $this->input->post('recommendations'),
                    'next_inspection_date' => $this->input->post('next_inspection_date'),
                    'status' => $workflow_state == 'completed' ? 'Completed' : 'Pending'
                ];

                $def_categories = $this->input->post('def_category');
                $def_descriptions = $this->input->post('def_description');
                $def_severities = $this->input->post('def_severity');

                $deficiencies = [];
                if (!empty($def_categories)) {
                    for ($i = 0; $i < count($def_categories); $i++) {
                        if (!empty($def_categories[$i]) && !empty($def_descriptions[$i])) {
                            $deficiencies[] = [
                                'category' => $def_categories[$i],
                                'description' => $def_descriptions[$i],
                                'severity' => $def_severities[$i]
                            ];
                        }
                    }
                }

                if ($this->school_inspection_model->saveReport($data, $deficiencies)) {
                    if ($workflow_state == 'pending') {
                        $this->load->library('mailer');
                        $lc = $this->db->select('user_id')->where('id', $data['inspector_id'])->get('login_credential')->row_array();
                        if (!empty($lc)) {
                            $inspector = $this->db->select('email, name')->where('id', $lc['user_id'])->get('staff')->row_array();
                            if (!empty($inspector['email'])) {
                                $school_name = get_type_name_by_id('branch', $data['branch_id']);
                                $msgData = [
                                    'recipient' => $inspector['email'],
                                    'subject' => 'School Inspection Assignment',
                                    'message' => 'Hello ' . $inspector['name'] . ',<br><br>You have been assigned to conduct an inspection for <strong>' . $school_name . '</strong> scheduled on <strong>' . _d($data['inspection_date']) . '</strong>.<br><br>Please log into your portal to securely file your findings.',
                                    'branch_id' => $data['branch_id']
                                ];
                                $this->mailer->send($msgData);
                            }
                        }
                    }
                    
                    set_alert('success', 'Inspection task ' . ($workflow_state == 'completed' ? 'submitted' : 'assigned') . ' successfully');
                    redirect(base_url('school_inspection'));
                } else {
                    set_alert('error', 'Failed to process request');
                }
            }
        }
        
        $this->data['title'] = 'Log Inspection Report';
        $this->data['sub_page'] = 'inspection/add_report';
        $this->data['main_menu'] = 'school_inspection';
        
        $this->db->select('id, name');
        $this->data['branch_list'] = $this->db->get('branch')->result_array();
        
        // Fetch all system users (staff, admins, etc.) for inspector drop-down
        $this->db->select('lc.id, s.name, r.name as role_name');
        $this->db->from('login_credential lc');
        $this->db->join('staff s', 'lc.user_id = s.id', 'left');
        $this->db->join('roles r', 'lc.role = r.id', 'left');
        $this->db->where('lc.active', 1);
        $this->db->where_in('lc.role', [1, 2, 8]); // E.g., Superadmin, Admin, etc (add relevant roles)
        $this->data['inspectors'] = $this->db->get()->result_array();
        
        $this->load->view('layout/index', $this->data);
    }

    public function edit($id)
    {
        if (!get_permission('school_inspection', 'is_edit')) {
            access_denied();
        }

        $this->data['report'] = $this->school_inspection_model->getReportById($id);
        $this->data['deficiencies'] = $this->school_inspection_model->getDeficiencies($id);
        if (empty($this->data['report'])) {
            set_alert('error', 'Report not found');
            redirect(base_url('school_inspection'));
        }

        if ($this->data['report']['status'] == 'Completed') {
            set_alert('error', 'Completed reports are locked and cannot be modified.');
            redirect(base_url('school_inspection/view/' . $id));
        }

        if ($_POST) {
            $workflow_state = $this->input->post('workflow_state');
            $this->form_validation->set_rules('branch_id', 'School', 'trim|required');
            $this->form_validation->set_rules('inspection_date', 'Inspection Date', 'trim|required');
            $this->form_validation->set_rules('inspector_id', 'Inspector', 'trim|required');
            
            if ($workflow_state == 'completed') {
                $this->form_validation->set_rules('infrastructure_score', 'Infrastructure Score', 'trim|required|numeric|less_than_equal_to[100]');
                $this->form_validation->set_rules('teaching_quality_score', 'Teaching Quality Score', 'trim|required|numeric|less_than_equal_to[100]');
                $this->form_validation->set_rules('compliance_score', 'Compliance Score', 'trim|required|numeric|less_than_equal_to[100]');
            }

            if ($this->form_validation->run() !== false) {
                $data = [
                    'branch_id' => $this->input->post('branch_id'),
                    'inspector_id' => $this->input->post('inspector_id'),
                    'inspection_date' => $this->input->post('inspection_date'),
                    'infrastructure_score' => $this->input->post('infrastructure_score') ? $this->input->post('infrastructure_score') : 0,
                    'teaching_quality_score' => $this->input->post('teaching_quality_score') ? $this->input->post('teaching_quality_score') : 0,
                    'compliance_score' => $this->input->post('compliance_score') ? $this->input->post('compliance_score') : 0,
                    'recommendations' => $this->input->post('recommendations'),
                    'next_inspection_date' => $this->input->post('next_inspection_date'),
                    'status' => $workflow_state == 'completed' ? 'Completed' : 'In Progress'
                ];

                $def_ids = $this->input->post('def_id');
                $def_categories = $this->input->post('def_category');
                $def_descriptions = $this->input->post('def_description');
                $def_severities = $this->input->post('def_severity');

                $deficiencies = [];
                if (!empty($def_categories)) {
                    for ($i = 0; $i < count($def_categories); $i++) {
                        if (!empty($def_categories[$i]) && !empty($def_descriptions[$i])) {
                            $deficiencies[] = [
                                'id' => !empty($def_ids[$i]) ? $def_ids[$i] : null,
                                'category' => $def_categories[$i],
                                'description' => $def_descriptions[$i],
                                'severity' => $def_severities[$i]
                            ];
                        }
                    }
                }

                $this->school_inspection_model->updateReport($id, $data, $deficiencies);
                set_alert('success', 'Inspection report updated successfully');
                redirect(base_url('school_inspection'));
            }
        }
        
        $this->data['title'] = 'Edit Inspection Report';
        $this->data['sub_page'] = 'inspection/edit_report';
        $this->data['main_menu'] = 'school_inspection';
        
        $this->db->select('id, name');
        $this->data['branch_list'] = $this->db->get('branch')->result_array();
        
        $this->db->select('lc.id, s.name, r.name as role_name');
        $this->db->from('login_credential lc');
        $this->db->join('staff s', 'lc.user_id = s.id', 'left');
        $this->db->join('roles r', 'lc.role = r.id', 'left');
        $this->db->where('lc.active', 1);
        $this->db->where_not_in('lc.role', [6, 7]); // Exclude parent/student
        $this->data['inspectors'] = $this->db->get()->result_array();
        
        $this->load->view('layout/index', $this->data);
    }

    public function delete($id)
    {
        if (!get_permission('school_inspection', 'is_delete')) {
            access_denied();
        }
        $this->db->where('id', $id);
        $this->db->delete('school_inspections');
        set_alert('success', 'Inspection deleted');
        redirect(base_url('school_inspection'));
    }

    public function view($id)
    {
        $this->data['title'] = 'Inspection Report Preview';
        $this->data['sub_page'] = 'inspection/view_report';
        $this->data['main_menu'] = 'school_inspection';
        
        $this->data['report'] = $this->school_inspection_model->getReportById($id);
        $this->data['deficiencies'] = $this->school_inspection_model->getDeficiencies($id);
        
        if (empty($this->data['report'])) {
            set_alert('error', 'Report not found');
            redirect(base_url('school_inspection'));
        }

        $this->load->view('layout/index', $this->data);
    }

    public function update_deficiency($id)
    {
        if (!get_permission('school_inspection', 'is_edit')) {
            ajax_access_denied();
        }
        
        $status = $this->input->post('status');
        if ($this->school_inspection_model->updateDeficiencyStatus($id, $status)) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error']);
        }
    }
}
