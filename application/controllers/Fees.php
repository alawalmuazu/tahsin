<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @package : SmartSchool
 * @version : 7.0
 * @developed by : SmartSchool
 * @support : Jamilusalis@gmail.com
 * @author url : https://mjtech.com.ng
 * @filename : Fees.php
 * @copyright : Reserved SmartSchool Team
 */

class Fees extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('fees_model');
        $this->load->model('email_model');
        $this->load->library('datatables');
        if (!moduleIsEnabled('student_accounting')) {
            access_denied();
        }
    }

    public function index()
    {
        redirect(base_url('fees/type'));
    }

    /* fees type form validation rules */
    protected function type_validation()
    {
        if (is_superadmin_loggedin()) {
            $this->form_validation->set_rules('branch_id', translate('branch'), 'required');
        }
        $this->form_validation->set_rules('type_name', translate('name'), 'trim|required|callback_unique_type');
    }

    /* fees type control */
    public function type()
    {
        if (!get_permission('fees_type', 'is_view')) {
            access_denied();
        }
        if ($_POST) {
            if (!get_permission('fees_type', 'is_add')) {
                ajax_access_denied();
            }
            $this->type_validation();
            if ($this->form_validation->run() !== false) {
                $post = $this->input->post();
                $this->fees_model->typeSave($post);
                set_alert('success', translate('information_has_been_saved_successfully'));
                $array = array('status' => 'success');
            } else {
                $error = $this->form_validation->error_array();
                $array = array('status' => 'fail', 'error' => $error);
            }
            echo json_encode($array);
            exit();
        }
        $this->data['categorylist'] = $this->app_lib->getTable('fees_type', array('system' => 0));
        $this->data['title'] = translate('fees_type');
        $this->data['sub_page'] = 'fees/type';
        $this->data['main_menu'] = 'fees';
        $this->load->view('layout/index', $this->data);
    }

    public function type_edit($id = '')
    {
        if (!get_permission('fees_type', 'is_edit')) {
            access_denied();
        }

        if ($_POST) {
            $this->type_validation();
            if ($this->form_validation->run() !== false) {
                $post = $this->input->post();
                $this->fees_model->typeSave($post);
                set_alert('success', translate('information_has_been_updated_successfully'));
                $url = base_url('fees/type');
                $array = array('status' => 'success', 'url' => $url);
            } else {
                $error = $this->form_validation->error_array();
                $array = array('status' => 'fail', 'error' => $error);
            }
            echo json_encode($array);
            exit();
        }
        $this->data['category'] = $this->app_lib->getTable('fees_type', array('t.id' => $id), true);
        $this->data['title'] = translate('fees_type');
        $this->data['sub_page'] = 'fees/type_edit';
        $this->data['main_menu'] = 'fees';
        $this->load->view('layout/index', $this->data);
    }

    public function type_delete($id = '')
    {
        if (get_permission('fees_type', 'is_delete')) {
            if (!is_superadmin_loggedin()) {
                $this->db->where('branch_id', get_loggedin_branch_id());
            }
            $this->db->where('id', $id);
            $this->db->delete('fees_type');
        }
    }

    public function unique_type($name)
    {
        $branchID = $this->application_model->get_branch_id();
        $typeID = $this->input->post('type_id');
        if (!empty($typeID)) {
            $this->db->where_not_in('id', $typeID);
        }
        $this->db->where(array('name' => $name, 'branch_id' => $branchID));
        $uniform_row = $this->db->get('fees_type')->num_rows();
        if ($uniform_row == 0) {
            return true;
        } else {
            $this->form_validation->set_message("unique_type", translate('already_taken'));
            return false;
        }
    }

    public function group($branch_id = '')
    {
        if (!get_permission('fees_group', 'is_view')) {
            access_denied();
        }
        if ($_POST) {
            if (!get_permission('fees_group', 'is_add')) {
                ajax_access_denied();
            }
            if (is_superadmin_loggedin()) {
                $this->form_validation->set_rules('branch_id', translate('branch'), 'required');
            }
            $this->form_validation->set_rules('name', translate('group_name'), 'trim|required');
            $elems = $this->input->post('elem');
            $sel = 0;
            if (count($elems)) {
                foreach ($elems as $key => $value) {
                    if (isset($value['fees_type_id'])) {
                        $sel++;
                        $this->form_validation->set_rules('elem[' . $key . '][due_date]', translate('due_date'), 'trim|required');
                        $this->form_validation->set_rules('elem[' . $key . '][amount]', translate('amount'), 'trim|required|greater_than[0]');
                    }
                }
            }
            if ($this->form_validation->run() !== false) {
                if ($sel != 0) {
                    $arrayGroup = array(
                        'name' => $this->input->post('name'),
                        'description' => $this->input->post('description'),
                        'session_id' => get_session_id(),
                        'branch_id' => $this->application_model->get_branch_id(),
                    );
                    $this->db->insert('fee_groups', $arrayGroup);
                    $groupID = $this->db->insert_id();
                    foreach ($elems as $key => $row) {
                        if (isset($row['fees_type_id'])) {
                            $arrayData = array(
                                'fee_groups_id' => $groupID,
                                'fee_type_id' => $row['fees_type_id'],
                                'due_date' => date("Y-m-d", strtotime($row['due_date'])),
                                'amount' => $row['amount'],
                            );
                            $this->db->where(array('fee_groups_id' => $groupID, 'fee_type_id' => $row['fees_type_id']));
                            $query = $this->db->get("fee_groups_details");
                            if ($query->num_rows() == 0) {
                                $this->db->insert('fee_groups_details', $arrayData);
                            }
                        }
                    }
                    set_alert('success', translate('information_has_been_saved_successfully'));
                } else {
                    set_alert('error', 'At least one type has to be selected.');
                }
                $url = base_url('fees/group');
                $array = array('status' => 'success', 'url' => $url);
            } else {
                $error = $this->form_validation->error_array();
                $array = array('status' => 'fail', 'error' => $error);
            }
            echo json_encode($array);
            exit();
        }
        $this->data['branch_id'] = $branch_id;
        $this->data['categorylist'] = $this->app_lib->getTable('fee_groups', array('t.session_id' => get_session_id(), 't.system' => 0));
        $this->data['title'] = translate('fees_group');
        $this->data['sub_page'] = 'fees/group';
        $this->data['main_menu'] = 'fees';
        $this->load->view('layout/index', $this->data);
    }

    public function group_edit($id = '')
    {
        if (!get_permission('fees_group', 'is_edit')) {
            access_denied();
        }
        if ($_POST) {
            $this->form_validation->set_rules('name', translate('group_name'), 'trim|required');
            $elems = $this->input->post('elem');
            $sel = array();
            if (count($elems)) {
                foreach ($elems as $key => $value) {
                    if (isset($value['fees_type_id'])) {
                        $sel[] = $value['fees_type_id'];
                        $this->form_validation->set_rules('elem[' . $key . '][due_date]', translate('due_date'), 'trim|required');
                        $this->form_validation->set_rules('elem[' . $key . '][amount]', translate('amount'), 'trim|required|greater_than[0]');
                    }
                }
            }
            if ($this->form_validation->run() !== false) {
                if (count($sel)) {
                    $groupID = $this->input->post('group_id');
                    $arrayGroup = array(
                        'name' => $this->input->post('name'),
                        'description' => $this->input->post('description'),
                    );
                    $this->db->where('id', $groupID);
                    $this->db->update('fee_groups', $arrayGroup);
                    foreach ($elems as $key => $row) {
                        if (isset($row['fees_type_id'])) {
                            $arrayData = array(
                                'fee_groups_id' => $groupID,
                                'fee_type_id' => $row['fees_type_id'],
                                'due_date' => date("Y-m-d", strtotime($row['due_date'])),
                                'amount' => $row['amount'],
                            );
                            $this->db->where(array('fee_groups_id' => $groupID, 'fee_type_id' => $row['fees_type_id']));
                            $query = $this->db->get("fee_groups_details");
                            if ($query->num_rows() == 0) {
                                $this->db->insert('fee_groups_details', $arrayData);
                            } else {
                                $this->db->where('id', $query->row()->id);
                                $this->db->update('fee_groups_details', $arrayData);
                            }
                        }
                    }
                    $this->db->where_not_in('fee_type_id', $sel);
                    $this->db->where('fee_groups_id', $groupID);
                    $this->db->delete('fee_groups_details');
                    set_alert('success', translate('information_has_been_updated_successfully'));
                } else {
                    set_alert('error', 'At least one type has to be selected.');
                }
                $url = base_url('fees/group');
                $array = array('status' => 'success', 'url' => $url);
            } else {
                $error = $this->form_validation->error_array();
                $array = array('status' => 'fail', 'error' => $error);
            }
            echo json_encode($array);
            exit();
        }
        $this->data['group'] = $this->app_lib->getTable('fee_groups', array('t.id' => $id), true);
        $this->data['title'] = translate('fees_group');
        $this->data['sub_page'] = 'fees/group_edit';
        $this->data['main_menu'] = 'fees';
        $this->load->view('layout/index', $this->data);
    }

    public function group_delete($id)
    {
        if (get_permission('fees_group', 'is_delete')) {
            if (!is_superadmin_loggedin()) {
                $this->db->where('branch_id', get_loggedin_branch_id());
            }
            $this->db->where('id', $id);
            $this->db->delete('fee_groups');
            if ($this->db->affected_rows() > 0) {
                $this->db->where('fee_groups_id', $id);
                $this->db->delete('fee_groups_details');
            }
        }
    }

    /* fees type form validation rules */
    protected function fine_validation()
    {
        if (is_superadmin_loggedin()) {
            $this->form_validation->set_rules('branch_id', translate('branch'), 'required');
        }
        $this->form_validation->set_rules('group_id', translate('group_name'), 'trim|required');
        $this->form_validation->set_rules('fine_type_id', translate('fees_type'), 'trim|required|callback_check_feetype');
        $this->form_validation->set_rules('fine_type', translate('fine_type'), 'trim|required');
        $this->form_validation->set_rules('fine_value', translate('fine') . " " . translate('value'), 'trim|required|numeric|greater_than[0]');
        $this->form_validation->set_rules('fee_frequency', translate('late_fee_frequency'), 'trim|required');
    }

    public function fine_setup()
    {
        if (!get_permission('fees_fine_setup', 'is_view')) {
            access_denied();
        }
        $branchID = $this->application_model->get_branch_id();
        if ($_POST) {
            if (!get_permission('fees_fine_setup', 'is_add')) {
                ajax_access_denied();
            }
            $this->fine_validation();
            if ($this->form_validation->run() !== false) {
                $insertData = array(
                    'group_id' => $this->input->post('group_id'),
                    'type_id' => $this->input->post('fine_type_id'),
                    'fine_value' => $this->input->post('fine_value'),
                    'fine_type' => $this->input->post('fine_type'),
                    'fee_frequency' => $this->input->post('fee_frequency'),
                    'branch_id' => $branchID,
                    'session_id' => get_session_id(),
                );
                $this->db->insert('fee_fine', $insertData);
                set_alert('success', translate('information_has_been_saved_successfully'));
                $array = array('status' => 'success');
            } else {
                $error = $this->form_validation->error_array();
                $array = array('status' => 'fail', 'error' => $error);
            }
            echo json_encode($array);
            exit();
        }
        $this->data['finelist'] = $this->app_lib->getTable('fee_fine');
        $this->data['branch_id'] = $branchID;
        $this->data['title'] = translate('fine_setup');
        $this->data['main_menu'] = 'fees';
        $this->data['sub_page'] = 'fees/fine_setup';
        $this->load->view('layout/index', $this->data);
    }

    public function fine_setup_edit($id = '')
    {
        if (!get_permission('fees_fine_setup', 'is_edit')) {
            access_denied();
        }

        if ($_POST) {
            $branchID = $this->application_model->get_branch_id();
            $this->fine_validation();
            if ($this->form_validation->run() !== false) {
                $insertData = array(
                    'group_id' => $this->input->post('group_id'),
                    'type_id' => $this->input->post('fine_type_id'),
                    'fine_value' => $this->input->post('fine_value'),
                    'fine_type' => $this->input->post('fine_type'),
                    'fee_frequency' => $this->input->post('fee_frequency'),
                    'branch_id' => $branchID,
                    'session_id' => get_session_id(),
                );
                $this->db->where('id', $id);
                $this->db->update('fee_fine', $insertData);
                set_alert('success', translate('information_has_been_updated_successfully'));
                $url = base_url('fees/fine_setup');
                $array = array('status' => 'success', 'url' => $url);
            } else {
                $error = $this->form_validation->error_array();
                $array = array('status' => 'fail', 'error' => $error);
            }
            echo json_encode($array);
            exit();
        }
        $this->data['fine'] = $this->app_lib->getTable('fee_fine', array('t.id' => $id), true);
        $this->data['title'] = translate('fine_setup');
        $this->data['sub_page'] = 'fees/fine_setup_edit';
        $this->data['main_menu'] = 'fees';
        $this->load->view('layout/index', $this->data);
    }

    public function check_feetype($id)
    {
        $groupID = $this->input->post('group_id');
        $fineID = $this->input->post('fine_id');
        if (!empty($fineID)) {
            $this->db->where_not_in('id', $fineID);
        }
        $this->db->where('group_id', $groupID);
        $this->db->where('type_id', $id);
        $query = $this->db->get('fee_fine');
        if ($query->num_rows() > 0) {
            $this->form_validation->set_message("check_feetype", translate('already_taken'));
            return false;
        } else {
            return true;
        }
    }

    public function fine_delete($id)
    {
        if (get_permission('fees_fine_setup', 'is_delete')) {
            if (!is_superadmin_loggedin()) {
                $this->db->where('branch_id', get_loggedin_branch_id());
            }
            $this->db->where('id', $id);
            $this->db->delete('fee_fine');
        }
    }

    public function allocation()
    {
        if (!get_permission('fees_allocation', 'is_add')) {
            access_denied();
        }
        $branchID = $this->application_model->get_branch_id();
        if (isset($_POST['search'])) {
            $this->data['class_id'] = $this->input->post('class_id');
            $this->data['section_id'] = $this->input->post('section_id');
            $this->data['fee_group_id'] = $this->input->post('fee_group_id');
            $this->data['branch_id'] = $branchID;
            $this->data['studentlist'] = $this->fees_model->getStudentAllocationList($this->data['class_id'], $this->data['section_id'], $this->data['fee_group_id'], $branchID);
        }
        if (isset($_POST['save'])) {
            $student_array = $this->input->post('stu_operations');
            $student_ids = $this->input->post('student_ids');
            $student_sel_array = isset($student_array) ? $student_array : array();
            $delStudent = array_diff($student_ids, $student_sel_array);
            $fee_groupID = $this->input->post('fee_group_id');
            foreach ($student_array as $key => $value) {
                $arrayData = array(
                    'student_id' => $value,
                    'group_id' => $fee_groupID,
                    'session_id' => get_session_id(),
                    'branch_id' => $branchID,
                );
                $this->db->where($arrayData);
                $q = $this->db->get('fee_allocation');
                if ($q->num_rows() == 0) {
                    $this->db->insert('fee_allocation', $arrayData);
                }
            }
            if (!empty($delStudent)) {
                $this->db->where_in('student_id', $delStudent);
                $this->db->where('group_id', $fee_groupID);
                $this->db->where('session_id', get_session_id());
                $this->db->delete('fee_allocation');
            }
            set_alert('success', translate('information_has_been_saved_successfully'));
            redirect(base_url('fees/allocation'));
        }
        $this->data['branch_id'] = $branchID;
        $this->data['title'] = translate('fees_allocation');
        $this->data['sub_page'] = 'fees/allocation';
        $this->data['main_menu'] = 'fees';
        $this->load->view('layout/index', $this->data);
    }

    public function allocation_save()
    {
        if (!get_permission('fees_allocation', 'is_add')) {
            access_denied();
        }
        if ($_POST) {
            $branchID = $this->application_model->get_branch_id();
            $student_array = $this->input->post('stu_operations');
            $student_ids = $this->input->post('student_ids');
            $student_sel_array = isset($student_array) ? $student_array : array();
            $delStudent = array_diff($student_ids, $student_sel_array);
            $fee_groupID = $this->input->post('fee_group_id');
            if (!empty($student_sel_array)) {
                foreach ($student_array as $key => $value) {
                    $arrayData = array(
                        'student_id' => $value,
                        'group_id' => $fee_groupID,
                        'session_id' => get_session_id(),
                        'branch_id' => $branchID,
                    );
                    $this->db->where($arrayData);
                    $q = $this->db->get('fee_allocation');
                    if ($q->num_rows() == 0) {
                        $this->db->insert('fee_allocation', $arrayData);
                    }
                }
            }
            if (!empty($delStudent)) {
                $this->db->where_in('student_id', $delStudent);
                $this->db->where('group_id', $fee_groupID);
                $this->db->where('session_id', get_session_id());
                $this->db->delete('fee_allocation');
            }

            $message = translate('information_has_been_saved_successfully');
            $array = array('status' => 'success', 'message' => $message);
            echo json_encode($array);
        }
    }

    /* student fees invoice search user interface */
    public function invoice_list()
    {
        if (!get_permission('invoice', 'is_view')) {
            access_denied();
        }
        $branchID = $this->application_model->get_branch_id();
        if ($_POST) {
            if (is_superadmin_loggedin()) {
                $this->form_validation->set_rules('branch_id', translate('branch'), 'trim|required');
            }
            $this->form_validation->set_rules('class_id', translate('class'), 'trim');
            $this->form_validation->set_rules('section_id', translate('section'), 'trim');
            if ($this->form_validation->run() == true) {
                $export_title = get_type_name_by_id('branch', $branchID) . ' - ' . translate('invoice_list');
                $array = array('status' => 'success', 'export_title' => $export_title,'error' => '');
            } else {
                $error = $this->form_validation->error_array();
                $array = array('status' => 'fail','error' => $error);
                
            }
            echo json_encode($array);
            exit();
        }
        $this->data['branch_id'] = $branchID;
        $this->data['title'] = translate('payments_history');
        $this->data['sub_page'] = 'fees/invoice_list';
        $this->data['main_menu'] = 'fees';
        $this->load->view('layout/index', $this->data);
    }

    public function getInvoiceListDT()
    {
        if ($_POST) {
            if (get_permission('invoice', 'is_view')) {
                $submit_btn = $this->input->post('submit_btn');
                if (empty($submit_btn)) {
                    $json_data = array(
                        "draw"                => intval(0),
                        "recordsTotal"        => intval(0),
                        "recordsFiltered"     => intval(0),
                        "data"                => [],
                    );
                    echo json_encode($json_data);
                } else {
                    echo $this->fees_model->getInvoiceList();
                }
            }
        }
    }

    public function invoice_delete($enrollID = '')
    {
        if (!get_permission('invoice', 'is_delete')) {
            access_denied();
        }

        if (!is_superadmin_loggedin()) {
            $this->db->where('branch_id', get_loggedin_branch_id());
        }
        $this->db->where('student_id', $enrollID);
        $result = $this->db->get('fee_allocation')->result_array();
        foreach ($result as $key => $value) {
            $this->db->where('allocation_id', $value['id']);
            $this->db->delete('fee_payment_history');
        }

        if (!is_superadmin_loggedin()) {
            $this->db->where('branch_id', get_loggedin_branch_id());
        }
        $this->db->where('student_id', $enrollID);
        $this->db->delete('fee_allocation');
    }

    /* invoice user interface with information are controlled here */
    public function invoice($enrollID = '')
    {
        if (!get_permission('invoice', 'is_view')) {
            access_denied();
        }
        $basic = $this->fees_model->getInvoiceBasic($enrollID);
        if (empty($basic))
            redirect(base_url('dashboard'));

        if (moduleIsEnabled('transport')) {
            $this->data['transport_fees'] = $this->fees_model->getStudentTransportFees($enrollID, $basic['stoppage_point_id']);
        }
        $extra = '';
        if ($this->db->field_exists('extra_phones', 'parent')) {
            $parent = $this->db->select('p.extra_phones')
                ->from('enroll e')
                ->join('student s', 's.id = e.student_id', 'inner')
                ->join('parent p', 'p.id = s.parent_id', 'left')
                ->where('e.id', (int) $enrollID)
                ->get()->row();
            if ($parent && !empty($parent->extra_phones)) {
                $extra = $parent->extra_phones;
            }
        }
        $this->load->model('academy_model');
        $this->data['parent_phones'] = $this->academy_model->parentPhoneList(
            isset($basic['guardian_mobile']) ? $basic['guardian_mobile'] : '',
            $extra,
            isset($basic['mobileno']) ? $basic['mobileno'] : ''
        );
        $this->data['invoice'] = $this->fees_model->getInvoiceStatus($enrollID);
        $this->data['basic'] = $basic;
        $this->data['title'] = translate('invoice_history');
        $this->data['main_menu'] = 'fees';
        $this->data['sub_page'] = 'fees/collect';
        $this->load->view('layout/index', $this->data);
    }

    public function invoicePrint()
    {
        if (!get_permission('invoice', 'is_view')) {
            access_denied();
        }
        if ($_POST) {
            $this->data['student_array'] = $this->input->post('student_id');
            echo $this->load->view('fees/invoicePrint', $this->data, true);
        }
    }

    public function invoicePDFdownload()
    {
        if (!get_permission('invoice', 'is_view')) {
            access_denied();
        }
        if ($_POST) {
            $this->data['student_array'] = $this->input->post('student_id');
            $html = $this->load->view('fees/invoicePDFdownload', $this->data, true);

            $this->load->library('html2pdf');
            $this->html2pdf->mpdf->WriteHTML(file_get_contents(base_url('assets/vendor/bootstrap/css/bootstrap.min.css')), 1);
            $this->html2pdf->mpdf->WriteHTML(file_get_contents(base_url('assets/css/custom-style.css')), 1);
            $this->html2pdf->mpdf->WriteHTML(file_get_contents(base_url('assets/css/ramom.css')), 1);
            $this->html2pdf->mpdf->WriteHTML($html);
            $this->html2pdf->mpdf->SetDisplayMode('fullpage');
            $this->html2pdf->mpdf->baseScript        = 1;
            $this->html2pdf->mpdf->autoScriptToLang  = true;
            $this->html2pdf->mpdf->autoLangToFont    = true;
            header("Content-Type: application/pdf");
            echo $this->html2pdf->mpdf->Output('', "S");
        }
    }

    public function pdf_sendByemail()
    {
        if (!get_permission('invoice', 'is_view')) {
            access_denied();
        }
        if ($_POST) {
            $this->data['student_array'] = [$this->input->post('enrollID')];
            $html = $this->load->view('fees/invoicePDFdownload', $this->data, true);
            $this->load->library('html2pdf');
            $this->html2pdf->mpdf->WriteHTML(file_get_contents(base_url('assets/vendor/bootstrap/css/bootstrap.min.css')), 1);
            $this->html2pdf->mpdf->WriteHTML(file_get_contents(base_url('assets/css/custom-style.css')), 1);
            $this->html2pdf->mpdf->WriteHTML(file_get_contents(base_url('assets/css/ramom.css')), 1);
            $this->html2pdf->mpdf->WriteHTML($html);
            $this->html2pdf->mpdf->SetDisplayMode('fullpage');
            $this->html2pdf->mpdf->autoScriptToLang  = true;
            $this->html2pdf->mpdf->baseScript        = 1;
            $this->html2pdf->mpdf->autoLangToFont    = true;

            $file = $this->html2pdf->mpdf->Output(time() . '.pdf', "S");
            $data['file'] = $file;
            $data['enroll_id'] = $this->input->post('enrollID');
            $response = $this->email_model->emailPDF_Fee_invoice($data);
            if ($response == true) {
                $array = array('status' => 'success', 'message' => translate('mail_sent_successfully'));
            } else {
                $array = array('status' => 'error', 'message' => translate('something_went_wrong'));

            }
            echo json_encode($array);
        }
    }

    public function due_invoice()
    {
        if (!get_permission('due_invoice', 'is_view')) {
            access_denied();
        }
        $branchID = $this->application_model->get_branch_id();
        if ($_POST) {
                if (is_superadmin_loggedin()) {
                    $this->form_validation->set_rules('branch_id', translate('branch'), 'trim|required');
                }
                $this->form_validation->set_rules('class_id', translate('class'), 'trim|required');
                $this->form_validation->set_rules('section_id', translate('section'), 'trim|required');
                $this->form_validation->set_rules('fees_type', translate('fees_type'), 'trim|required');
                if ($this->form_validation->run() == true) {
                    $export_title = get_type_name_by_id('branch', $branchID) . ' - ' . translate('due_invoice') . " " . translate('list');
                    $array = array('status' => 'success', 'export_title' => $export_title,'error' => '');
                } else {
                    $error = $this->form_validation->error_array();
                    $array = array('status' => 'fail','error' => $error);
                }
                echo json_encode($array);
                exit();
        }
        $this->data['branch_id'] = $branchID;
        $this->data['title'] = translate('payments_history');
        $this->data['sub_page'] = 'fees/due_invoice';
        $this->data['main_menu'] = 'fees';
        $this->load->view('layout/index', $this->data);
    }

    public function getDueInvoiceListDT()
    {
        if ($_POST) {
            if (get_permission('due_invoice', 'is_view')) {
                $branchID = $this->application_model->get_branch_id();
                $class_id = $this->input->post('class_id');
                $section_id = $this->input->post('section_id');
                $submit_btn = $this->input->post('submit_btn');

                if (empty($submit_btn)) {
                    $json_data = array(
                        "draw"                => intval(0),
                        "recordsTotal"        => intval(0),
                        "recordsFiltered"     => intval(0),
                        "data"                => [],
                    );
                    echo json_encode($json_data);
                } else {
                    $feegroup = explode("|", $this->input->post('fees_type'));
                    $feegroup_id = $feegroup[0];
                    $fee_feetype_id = $feegroup[1];

                    $results = $this->fees_model->getDueInvoiceDT_list($class_id, $section_id, $feegroup_id, $fee_feetype_id);
                    $records = array();
                    $records = json_decode($results);
                    $dt_data = array();
                    foreach ($records->data as $key => $record) {

                        $paid = $record->total_amount + $record->total_discount;
                        $prev_due = empty($record->prev_due) ? 0 : $record->prev_due;
                        if ((float)($record->full_amount + $prev_due) <= (float)$paid) {

                        } else {
                            // actions btn
                            $actions = "";
                            if (get_permission('collect_fees', 'is_add')) {
                                $actions .= '<a href="' . base_url('fees/invoice/' . $record->enroll_id) . '" class="btn btn-default btn-circle"><i class="far fa-arrow-alt-circle-right"></i> ' . translate('collect') . '</a>';
                            }
                            if (get_permission('invoice', 'is_delete')) {
                                $actions .=  btn_delete('fees/invoice_delete/' . $record->enroll_id);
                            }

                            // getting fees group list
                            $feegroup = $this->fees_model->getfeeGroup($record->enroll_id);
                            $groupList = '';
                            foreach ($feegroup as $key => $value) {
                                $groupList .= "- " . $value['name'] . "<br>";
                            }

                            // dt-data array 
                            $row   = array();
                            $row[] = '<div class="checked-area"><div class="checkbox-replace"><label class="i-checks"><input type="checkbox" name="student_id[]" value="' . $record->enroll_id  . '"><i></i></label></div></div>';
                            $row[] = $record->first_name . ' ' . $record->last_name;
                            $row[] = $record->register_no;
                            $row[] = $record->roll;
                            $row[] = $record->mobileno;
                            $row[] = $groupList;
                            $row[] = _d($record->due_date);
                            $row[] = currencyFormat($record->full_amount);
                            $row[] = currencyFormat($record->total_amount);
                            $row[] = currencyFormat($record->total_discount);
                            $row[] = currencyFormat($record->full_amount - $paid);
                            $row[] = $actions;
                            $dt_data[] = $row;
                        }
                    }
                    $json_data = array(
                        "draw"                => intval($records->draw),
                        "recordsTotal"        => intval($records->recordsTotal),
                        "recordsFiltered"     => intval($records->recordsFiltered),
                        "data"                => $dt_data,
                    );
                    echo json_encode($json_data);
                }
            }
        }
    }

    public function fee_add()
    {
        if (!get_permission('collect_fees', 'is_add')) {
            ajax_access_denied();
        }
        $this->form_validation->set_rules('fees_type', translate('fees_type'), 'trim|required');
        $this->form_validation->set_rules('date', translate('date'), 'trim|required');
        $this->form_validation->set_rules('amount', translate('amount'), array('trim', 'required', 'numeric', 'greater_than[0]', array('deposit_verify', array($this->fees_model, 'depositAmountVerify'))));
        $this->form_validation->set_rules('discount_amount', translate('discount'), array('trim', 'numeric', array('deposit_verify', array($this->fees_model, 'depositAmountVerify'))));
        $this->form_validation->set_rules('pay_via', translate('payment_method'), 'trim|required');
        if ($this->form_validation->run() !== false) {
            $feesType = explode("|", $this->input->post('fees_type'));
            $amount = $this->input->post('amount');
            $fineAmount = $this->input->post('fine_amount');
            $discountAmount = $this->input->post('discount_amount');
            $date = $this->input->post('date');
            $payVia = $this->input->post('pay_via');
            $arrayFees = array(
                'allocation_id' => $feesType[0],
                'type_id' => $feesType[1],
                'collect_by' => get_loggedin_user_id(),
                'amount' => ($amount - $discountAmount),
                'discount' => $discountAmount,
                'fine' => $fineAmount,
                'pay_via' => $payVia,
                'remarks' => $this->input->post('remarks'),
                'date' => $date,
            );
            // transport fees data processing
            if ($feesType[0] == 'transport') {
                $arrayFees['allocation_id'] = NULL;
                $arrayFees['type_id'] = NULL;
                $arrayFees['transport_fee_details_id'] = $feesType[1];
            }
            $this->db->insert('fee_payment_history', $arrayFees);
            $payment_historyID = $this->db->insert_id();
            $enrollId = (int) $this->input->post('enroll_id');
            if ($enrollId > 0 && $payment_historyID) {
                $this->session->set_flashdata('fee_wa_ids', (string) $payment_historyID);
            }

            $accountID = $this->input->post('account_id');
            if (empty($accountID)) {
                $accountID = $this->app_lib->getCollectionDepositAccountId();
            }
            if (!empty($accountID)) {
                $arrayTransaction = array(
                    'account_id' => $accountID,
                    'amount' => ($amount + $fineAmount) - $discountAmount,
                    'date' => $date,
                );
                $this->fees_model->saveTransaction($arrayTransaction, $payment_historyID);
            }

            // send payment confirmation sms
            if (isset($_POST['guardian_sms'])) {
                $arrayData = array(
                    'student_id' => $this->input->post('student_id'),
                    'amount' => ($amount + $fineAmount) - $discountAmount,
                    'paid_date' => _d($date),
                );
                $this->sms_model->send_sms($arrayData, 2);
            }
            set_alert('success', translate('information_has_been_saved_successfully'));
            $array = array('status' => 'success');
            $enrollId = (int) $this->input->post('enroll_id');
            if ($enrollId > 0) {
                $array['url'] = base_url('fees/invoice/' . $enrollId);
            }
        } else {
            $error = $this->form_validation->error_array();
            $array = array('status' => 'fail', 'url' => '', 'error' => $error);
        }
        echo json_encode($array);
    }

    public function getBalanceByType()
    {
        $input = $this->input->post('typeID');
        if (empty($input)) {
            $balance = 0;
            $fine = 0;
        } else {
            $feesType = explode("|", $input);
            if ($feesType[0] == 'transport') {
                $fine = $this->fees_model->transportFeeFineCalculation($feesType[1], $feesType[2]);
                $b = $this->fees_model->getTransportBalance($feesType[1]);
                $balance = $b['balance'];
                $fine = abs($fine - $b['fine']);
            } else {
                $fine = $this->fees_model->feeFineCalculation($feesType[0], $feesType[1]);
                $b = $this->fees_model->getBalance($feesType[0], $feesType[1]);
                $balance = $b['balance'];
                $fine = abs($fine - $b['fine']);
            }
        }
        echo json_encode(array('balance' => $balance, 'fine' => $fine));
    }

    public function getTypeByBranch()
    {
        $html = "";
        $branchID = $this->application_model->get_branch_id();
        $typeID = (isset($_POST['type_id']) ? $_POST['type_id'] : 0);
        if (!empty($branchID)) {
            $this->db->where('session_id', get_session_id());
            $this->db->where('branch_id', $branchID);
            $result = $this->db->get('fee_groups')->result_array();

            if (moduleIsEnabled('transport')) {
                $this->db->where('branch_id', $branchID);
                $this->db->where('session_id', get_session_id());
                $this->db->order_by('month', 'asc');
                $transport_results = $this->db->get('transport_fee_fine')->result();
            }
            if (count($result)) {
                $html .= "<option value=''>" . translate('select') . "</option>";
                foreach ($result as $row) {
                    $html .= '<optgroup label="' . $row['name'] . '">';
                    $this->db->where('fee_groups_id', $row['id']);
                    $resultdetails = $this->db->get('fee_groups_details')->result_array();
                    foreach ($resultdetails as $t) {
                        $sel = ($t['fee_groups_id'] . "|" . $t['fee_type_id'] == $typeID ? ' selected ' : '');
                        $html .= '<option value="' . $t['fee_groups_id'] . "|" . $t['fee_type_id'] . '"' . $sel . '>' . get_type_name_by_id('fees_type', $t['fee_type_id']) . '</option>';
                    }
                    $html .= '</optgroup>';
                }
                if (!empty($transport_results)) {
                    $getMonths = $this->app_lib->getMonthslist();
                    $html .= '<optgroup label="' . translate('transport_fees') . '">';
                    foreach ($transport_results as $t_key => $t_value) {
                        $sel = ("transport|" . $t_value->id == $typeID ? ' selected ' : '');
                        $html .= '<option value="' . "transport|" . $t_value->id . '"' . $sel . '>' . translate('transport_fees') ." - ". $getMonths[$t_value->month] . '</option>';
                    }
                }
            } else {
                $html .= '<option value="">' . translate('no_information_available') . '</option>';
            }
        } else {
            $html .= '<option value="">' . translate('select_branch_first') . '</option>';
        }
        echo $html;
    }

    public function getGroupByBranch()
    {
        $html = "";
        $branch_id = $this->application_model->get_branch_id();
        if (!empty($branch_id)) {
            $result = $this->db->select('id,name')
                ->where(array('branch_id' => $branch_id, 'session_id' => get_session_id(), 'system' => 0))
                ->get('fee_groups')->result_array();
            if (count($result)) {
                $html .= "<option value=''>" . translate('select') . "</option>";
                foreach ($result as $row) {
                    $html .= '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
                }
            } else {
                $html .= '<option value="">' . translate('no_information_available') . '</option>';
            }
        } else {
            $html .= '<option value="">' . translate('select_branch_first') . '</option>';
        }
        echo $html;
    }

    public function getTypeByGroup()
    {
        $html = "";
        $groupID = $this->input->post('group_id');
        $typeID = (isset($_POST['type_id']) ? $_POST['type_id'] : 0);
        if (!empty($groupID)) {
            $this->db->select('t.id,t.name');
            $this->db->from('fee_groups_details as gd');
            $this->db->join('fees_type as t', 't.id = gd.fee_type_id', 'left');
            $this->db->where('gd.fee_groups_id', $groupID);
            $result = $this->db->get()->result_array();
            if (count($result)) {
                $html .= "<option value=''>" . translate('select') . "</option>";
                foreach ($result as $row) {
                    $sel = ($row['id'] == $typeID ? 'selected' : '');
                    $html .= '<option value="' . $row['id'] . '" ' . $sel . '>' . $row['name'] . '</option>';
                }
            } else {
                $html .= '<option value="">' . translate('no_information_available') . '</option>';
            }
        } else {
            $html .= '<option value="">' . translate('first_select_the_group') . '</option>';
        }
        echo $html;
    }

    protected function reminder_validation()
    {
        if (is_superadmin_loggedin()) {
            $this->form_validation->set_rules('branch_id', translate('branch'), 'required');
        }
        $this->form_validation->set_rules('frequency', translate('frequency'), 'trim|required');
        $this->form_validation->set_rules('days', translate('days'), 'trim|required|numeric');
        $this->form_validation->set_rules('message', translate('message'), 'trim|required');
    }

    public function reminder()
    {
        if (!get_permission('fees_reminder', 'is_view')) {
            access_denied();
        }
        $branchID = $this->application_model->get_branch_id();
        if ($_POST) {
            if (!get_permission('fees_reminder', 'is_add')) {
                ajax_access_denied();
            }
            $this->reminder_validation();
            if ($this->form_validation->run() !== false) {
                $post = $this->input->post();
                $post['branch_id'] = $branchID;
                $this->fees_model->reminderSave($post);
                set_alert('success', translate('information_has_been_saved_successfully'));
                $array = array('status' => 'success');
            } else {
                $error = $this->form_validation->error_array();
                $array = array('status' => 'fail', 'error' => $error);
            }
            echo json_encode($array);
            exit();
        }
        $this->data['branch_id'] = $branchID;
        $this->data['reminderlist'] = $this->app_lib->getTable('fees_reminder');
        $this->data['title'] = translate('fees_reminder');
        $this->data['main_menu'] = 'fees';
        $this->data['sub_page'] = 'fees/reminder';
        $this->load->view('layout/index', $this->data);
    }

    public function edit_reminder($id = '')
    {
        if (!get_permission('fees_reminder', 'is_edit')) {
            ajax_access_denied();
        }
        $branchID = $this->application_model->get_branch_id();
        if ($_POST) {
            $this->reminder_validation();
            if ($this->form_validation->run() !== false) {
                $post = $this->input->post();
                $post['branch_id'] = $branchID;
                $this->fees_model->reminderSave($post);
                $url = base_url('fees/reminder');
                set_alert('success', translate('information_has_been_updated_successfully'));
                $array = array('status' => 'success', 'url' => $url);
            } else {
                $error = $this->form_validation->error_array();
                $array = array('status' => 'fail', 'error' => $error);
            }
            echo json_encode($array);
            exit();
        }
        $this->data['reminder'] = $this->app_lib->getTable('fees_reminder', array('t.id' => $id), true);
        $this->data['title'] = translate('fees_reminder');
        $this->data['main_menu'] = 'fees';
        $this->data['sub_page'] = 'fees/edit_reminder';
        $this->load->view('layout/index', $this->data);
    }

    public function reminder_delete($id = '')
    {
        if (get_permission('fees_reminder', 'is_delete')) {
            if (!is_superadmin_loggedin()) {
                $this->db->where('branch_id', get_loggedin_branch_id());
            }
            $this->db->where('id', $id);
            $this->db->delete('fees_reminder');
        }
    }

    public function due_report()
    {
        if (!get_permission('fees_reports', 'is_view')) {
            access_denied();
        }
        $branchID = $this->application_model->get_branch_id();
        if ($this->input->post('search')) {
            $this->data['class_id'] = $this->input->post('class_id');
            $this->data['section_id'] = $this->input->post('section_id');
            $this->data['invoicelist'] = $this->fees_model->getDueReport($this->data['class_id'], $this->data['section_id']);
        }
        $this->data['branch_id'] = $branchID;
        $this->data['title'] = translate('due_fees_report');
        $this->data['sub_page'] = 'fees/due_report';
        $this->data['main_menu'] = 'fees_repots';
        $this->load->view('layout/index', $this->data);
    }

    public function payment_history()
    {
        if (!get_permission('fees_reports', 'is_view')) {
            access_denied();
        }
        $branchID = $this->application_model->get_branch_id();
        if ($this->input->post('search')) {
            $classID = $this->input->post('class_id');
            $paymentVia = $this->input->post('payment_via');
            $daterange = explode(' - ', $this->input->post('daterange'));
            $start = date("Y-m-d", strtotime($daterange[0]));
            $end = date("Y-m-d", strtotime($daterange[1]));
            $this->data['invoicelist'] = $this->fees_model->getStuPaymentHistory($classID, "", $paymentVia, $start, $end, $branchID);
        }
        $this->data['branch_id'] = $branchID;
        $this->data['title'] = translate('fees_payment_history');
        $this->data['sub_page'] = 'fees/payment_history';
        $this->data['main_menu'] = 'fees_repots';
        $this->data['headerelements'] = array(
            'css' => array(
                'vendor/daterangepicker/daterangepicker.css',
            ),
            'js' => array(
                'vendor/moment/moment.js',
                'vendor/daterangepicker/daterangepicker.js',
            ),
        );
        $this->load->view('layout/index', $this->data);
    }

    public function student_fees_report()
    {
        if (!get_permission('fees_reports', 'is_view')) {
            access_denied();
        }
        $branchID = $this->application_model->get_branch_id();
        if ($this->input->post('search')) {
            $classID = $this->input->post('class_id');
            $sectionID = $this->input->post('section_id');
            $enroll_id = $this->input->post('enroll_id');
            $typeID = $this->input->post('fees_type');
            $daterange = explode(' - ', $this->input->post('daterange'));
            $start = date("Y-m-d", strtotime($daterange[0]));
            $end = date("Y-m-d", strtotime($daterange[1]));
            $this->data['invoicelist'] = $this->fees_model->getStuPaymentReport($classID, $sectionID, $enroll_id, $typeID, $start, $end, $branchID);
        }
        $this->data['branch_id'] = $branchID;
        $this->data['title'] = translate('student_fees_report');
        $this->data['sub_page'] = 'fees/student_fees_report';
        $this->data['main_menu'] = 'fees_repots';
        $this->data['headerelements'] = array(
            'css' => array(
                'vendor/daterangepicker/daterangepicker.css',
            ),
            'js' => array(
                'vendor/moment/moment.js',
                'vendor/daterangepicker/daterangepicker.js',
            ),
        );
        $this->load->view('layout/index', $this->data);
    }

    public function fine_report()
    {
        if (!get_permission('fees_reports', 'is_view')) {
            access_denied();
        }
        $branchID = $this->application_model->get_branch_id();
        if ($this->input->post('search')) {
            $classID = $this->input->post('class_id');
            $sectionID = $this->input->post('section_id');
            $paymentVia = $this->input->post('payment_via');
            $daterange = explode(' - ', $this->input->post('daterange'));
            $start = date("Y-m-d", strtotime($daterange[0]));
            $end = date("Y-m-d", strtotime($daterange[1]));
            $this->data['invoicelist'] = $this->fees_model->getStuPaymentHistory($classID, $sectionID, $paymentVia, $start, $end, $branchID, true);
        }
        $this->data['branch_id'] = $branchID;
        $this->data['title'] = translate('fees_fine_reports');
        $this->data['sub_page'] = 'fees/fine_report';
        $this->data['main_menu'] = 'fees_repots';
        $this->data['headerelements'] = array(
            'css' => array(
                'vendor/daterangepicker/daterangepicker.css',
            ),
            'js' => array(
                'vendor/moment/moment.js',
                'vendor/daterangepicker/daterangepicker.js',
            ),
        );
        $this->load->view('layout/index', $this->data);
    }

    public function paymentRevert()
    {
        if (!get_permission('fees_revert', 'is_delete')) {
            $array = array('status' => 'error', 'message' => translate('access_denied'));
            echo json_encode($array);
            exit();
        }
        $array = array('status' => 'success', 'message' => translate('information_deleted'));
        $ids = $this->input->post('id');
        foreach ($ids as $key => $value) {

            $feeDetails = $this->db->select('id,amount,fine')->where('id', $value)->get('fee_payment_history')->row();
            if (!empty($feeDetails)) {

                $amount = ($feeDetails->amount + $feeDetails->fine);

                $sql = "SELECT `transactions`.`account_id`, `transactions_links_details`.`transactions_id` FROM `transactions_links_details` INNER JOIN `transactions` ON `transactions`.`id` = `transactions_links_details`.`transactions_id` WHERE `transactions_links_details`.`payment_id` = " . $this->db->escape($value);
                $transactionsDetails = $this->db->query($sql)->row();
                if (!empty($transactionsDetails)) {

                    $sql = "UPDATE `transactions` SET `amount` = `amount` - $amount, `cr` = `cr` - $amount, `bal` = `bal` - $amount WHERE `id` = " . $this->db->escape($transactionsDetails->transactions_id);
                    $this->db->query($sql);

                    $sql = "UPDATE `accounts` SET `balance` = `balance` - $amount WHERE `id` = " . $this->db->escape($transactionsDetails->account_id);
                    $this->db->query($sql);

                    /*$this->db->set('amount', 'amount+' . $amount, false);
                    $this->db->set('cr', 'cr-' . $amount, false);
                    $this->db->set('bal', 'bal-' . $amount, false);
                    $this->db->where('id', $transactionsDetails->transactions_id);
                    $this->db->update('transactions');

                    $this->db->set('balance', 'balance-' . $amount, false);
                    $this->db->where('id', $transactionsDetails->account_id);
                    $this->db->update('accounts');*/
                }
                $this->db->where('id', $value);
                $this->db->delete('fee_payment_history');
            }
        }
        echo json_encode($array);
    }

    public function fee_fully_paid()
    {
        if (!get_permission('collect_fees', 'is_add')) {
            ajax_access_denied();
        }
        $this->form_validation->set_rules('date', translate('date'), 'trim|required');
        $this->form_validation->set_rules('pay_via', translate('payment_method'), 'trim|required');
        if ($this->form_validation->run() !== false) {
            $date = $this->input->post('date');
            $payVia = $this->input->post('pay_via');
            $accountID = $this->input->post('account_id');
            $invoiceID = $this->input->post('invoice_id');
            $basic = $this->fees_model->getInvoiceBasic($invoiceID);
            if (empty($basic))
                ajax_access_denied();

            $allocations = $this->fees_model->getInvoiceDetails($invoiceID);
            $totalBalance = 0;
            $totalFine = 0;
            $paidIds = array();

            foreach ($allocations as $row) {
                $fine = $this->fees_model->feeFineCalculation($row['allocation_id'], $row['fee_type_id']);
                $b = $this->fees_model->getBalance($row['allocation_id'], $row['fee_type_id']);
                $fine = abs($fine - $b['fine']);
                if ($b['balance'] != 0) {
                    $totalBalance += $b['balance'];
                    $totalFine += $fine;
                    $arrayFees = array(
                        'allocation_id' => $row['allocation_id'],
                        'type_id' => $row['fee_type_id'],
                        'collect_by' => get_loggedin_user_id(),
                        'amount' => $b['balance'],
                        'discount' => 0,
                        'fine' => $fine,
                        'pay_via' => $payVia,
                        'remarks' => $this->input->post('remarks'),
                        'date' => $date,
                    );
                    $this->db->insert('fee_payment_history', $arrayFees);
                    $paidIds[] = (int) $this->db->insert_id();
                }
            }

            if (moduleIsEnabled('transport')) {
                $transport_fees = $this->fees_model->getStudentTransportFees($invoiceID, $basic['stoppage_point_id']);
                foreach ($transport_fees as $key => $value) {
                    $fine = $this->fees_model->transportFeeFineCalculation($value->id);
                    $b = $this->fees_model->getTransportBalance($value->id);
                    $balance = $b['balance'];
                    $fine = abs($fine - $b['fine']);
                
                    if ($b['balance'] != 0) {
                        $totalBalance += $b['balance'];
                        $totalFine += $fine;
                        $arrayFees = array(
                            'allocation_id' => NULL,
                            'type_id' => NULL,
                            'transport_fee_details_id' => $value->id,
                            'collect_by' => get_loggedin_user_id(),
                            'amount' => $b['balance'],
                            'discount' => 0,
                            'fine' => $fine,
                            'pay_via' => $payVia,
                            'remarks' => $this->input->post('remarks'),
                            'date' => $date,
                        );
                        $this->db->insert('fee_payment_history', $arrayFees);
                        $paidIds[] = (int) $this->db->insert_id();
                    }
                }
            }

            // transaction voucher save function
            if (empty($accountID)) {
                $accountID = $this->app_lib->getCollectionDepositAccountId();
            }
            if (!empty($accountID)) {
                $arrayTransaction = array(
                    'account_id' => $accountID,
                    'amount' => ($totalBalance + $totalFine),
                    'date' => $date,
                );
                $this->fees_model->saveTransaction($arrayTransaction);
            }

            // send payment confirmation sms
            if (isset($_POST['guardian_sms'])) {
                $arrayData = array(
                    'student_id' => $this->input->post('student_id'),
                    'amount' => ($totalBalance + $totalFine),
                    'paid_date' => $date,
                );
                $this->sms_model->send_sms($arrayData, 2);
            }
            if (!empty($paidIds)) {
                $this->session->set_flashdata('fee_wa_ids', implode(',', $paidIds));
            }
            set_alert('success', translate('information_has_been_saved_successfully'));
            $array = array('status' => 'success', 'url' => base_url('fees/invoice/' . $invoiceID));
        } else {
            $error = $this->form_validation->error_array();
            $array = array('status' => 'fail', 'url' => '', 'error' => $error);
        }
        echo json_encode($array);
    }

    public function printFeesPaymentHistory()
    {
        if ($_POST) {
            $record = $this->input->post('data');
            $record_array = json_decode($record, true);
            $this->db->where_in('id', array_column($record_array, 'payment_id'));
            $paymentHistory = $this->db->select("sum(amount) as total_amount,sum(discount) as total_discount,sum(fine) as total_fine")->get('fee_payment_history')->row_array();
            $this->data['total_paid'] = $paymentHistory['total_amount'];
            $this->data['total_discount'] = $paymentHistory['total_discount'];
            $this->data['total_fine'] = $paymentHistory['total_fine'];
            $this->load->view('fees/printFeesPaymentHistory', $this->data);
        }
    }

    public function printFeesInvoice()
    {
        if ($_POST) {
            $record = $this->input->post('data');
            $record_array = json_decode($record);
            $total_fine = 0;
            $total_discount = 0;
            $total_paid = 0;
            $total_balance = 0;
            $total_amount = 0;
            foreach ($record_array as $key => $value) {
                if ($value->feeType == 'general') {
                    $deposit = $this->fees_model->getStudentFeeDeposit($value->allocationID, $value->feeTypeID);
                } elseif ($value->feeType == 'transport') {
                    $deposit = $this->fees_model->getStudentTransportFeeDeposit($value->trans_fd_id);
                }
                $full_amount = $value->feeAmount;
                $type_discount = $deposit['total_discount'];
                $type_fine = $deposit['total_fine'];
                $type_amount = $deposit['total_amount'];
                $balance = $full_amount - ($type_amount + $type_discount);
                $total_discount += $type_discount;
                $total_fine += $type_fine;
                $total_paid += $type_amount;
                $total_balance += $balance;
                $total_amount += $full_amount;
            }
            $this->data['total_amount'] = $total_amount;
            $this->data['total_paid'] = $total_paid;
            $this->data['total_discount'] = $total_discount;
            $this->data['total_fine'] = $total_fine;
            $this->data['total_balance'] = $total_balance;
            $this->load->view('fees/printFeesInvoice', $this->data);
        }
    }

    public function payReceiptPrint()
    {
        if ($_POST) {
            if (!get_permission('collect_fees', 'is_add')) {
                ajax_access_denied();
            }
            $studentID = $this->input->post('student_id');
            $record = $this->input->post('data');
            $this->data['studentID'] = $studentID;
            $this->data['record'] = $record;
            $this->load->view('fees/paySlipPrint', $this->data);
        }
    }

    public function selectedFeesPay()
    {
        if (!get_permission('collect_fees', 'is_add')) {
            ajax_access_denied();
        }

        $items = $this->input->post('collect_fees');
        foreach ($items as $key => $value) {
            $this->form_validation->set_rules('collect_fees[' . $key . '][date]', translate('date'), 'trim|required');
            $this->form_validation->set_rules('collect_fees[' . $key . '][pay_via]', translate('payment_method'), 'trim|required');
            $this->form_validation->set_rules('collect_fees[' . $key . '][amount]', translate('amount'), 'trim|required|numeric|greater_than[0]');
            $this->form_validation->set_rules('collect_fees[' . $key . '][discount_amount]', translate('discount'), 'trim|numeric');
            $this->form_validation->set_rules('collect_fees[' . $key . '][fine_amount]', translate('fine'), 'trim|numeric');
            if (isset($value['account_id'])) {
                $this->form_validation->set_rules('collect_fees[' . $key . '][account_id]', translate('account'), 'trim|required');
            }

            if ($value['fee_type'] == 'general') {
                $remainAmount = $this->fees_model->getBalance($value['allocation_id'], $value['type_id']);
                if ($remainAmount['balance'] < $value['amount']) {
                    $error = array('collect_fees[' . $key . '][amount]' => 'Amount cannot be greater than the remaining.');
                    $array = array('status' => 'fail', 'error' => $error);
                    echo json_encode($array);
                    exit;
                }

                $remainAmount = $this->fees_model->getBalance($value['allocation_id'], $value['type_id']);
                if ($remainAmount['balance'] < $value['discount_amount']) {
                    $error = array('collect_fees[' . $key . '][discount_amount]' => 'Amount cannot be greater than the remaining.');
                    $array = array('status' => 'fail', 'error' => $error);
                    echo json_encode($array);
                    exit;
                }
            } elseif($value['fee_type'] == 'transport') {
                // transport fees data processing
                $remainAmount = $this->fees_model->getTransportBalance($value['trans_fd_id']);
                if ($remainAmount['balance'] < $value['amount']) {
                    $error = array('collect_fees[' . $key . '][amount]' => 'Amount cannot be greater than the remaining.');
                    $array = array('status' => 'fail', 'error' => $error);
                    echo json_encode($array);
                    exit;
                }

                $remainAmount = $this->fees_model->getTransportBalance($value['trans_fd_id']);
                if ($remainAmount['balance'] < $value['discount_amount']) {
                    $error = array('collect_fees[' . $key . '][discount_amount]' => 'Amount cannot be greater than the remaining.');
                    $array = array('status' => 'fail', 'error' => $error);
                    echo json_encode($array);
                    exit;
                }  
            }
        }

        if ($this->form_validation->run() !== false) {
            $studentID = $this->input->post('student_id');
            $paidIds = array();
            foreach ($items as $key => $value) {
                $amount = $value['amount'];
                $fineAmount = $value['fine_amount'];
                $discountAmount = $value['discount_amount'];
                $date = $value['date'];
                $payVia = $value['pay_via'];
                $arrayFees = array(
                    'allocation_id' => $value['allocation_id'],
                    'type_id' => $value['type_id'],
                    'collect_by' => get_loggedin_user_id(),
                    'amount' => ($amount - $discountAmount),
                    'discount' => $discountAmount,
                    'fine' => $fineAmount,
                    'pay_via' => $payVia,
                    'remarks' => $value['remarks'],
                    'date' => $date,
                );
                // transport fees data processing
                if ($value['fee_type'] == 'transport') {
                    $arrayFees['allocation_id'] = NULL;
                    $arrayFees['type_id'] = NULL;
                    $arrayFees['transport_fee_details_id'] = $value['trans_fd_id'];
                }
                $this->db->insert('fee_payment_history', $arrayFees);
                $paidIds[] = (int) $this->db->insert_id();

                $accountID = !empty($value['account_id']) ? $value['account_id'] : $this->app_lib->getCollectionDepositAccountId();
                if (!empty($accountID)) {
                    $arrayTransaction = array(
                        'account_id' => $accountID,
                        'amount' => ($amount + $fineAmount) - $discountAmount,
                        'date' => $date,
                    );
                    $this->fees_model->saveTransaction($arrayTransaction);
                }
                // send payment confirmation sms
                $arrayData = array(
                    'student_id' => $studentID,
                    'amount' => ($amount + $fineAmount) - $discountAmount,
                    'paid_date' => _d($date),
                );
                $this->sms_model->send_sms($arrayData, 2);
            }
            if (!empty($paidIds)) {
                $this->session->set_flashdata('fee_wa_ids', implode(',', $paidIds));
            }
            set_alert('success', translate('information_has_been_saved_successfully'));
            $array = array('status' => 'success', 'url' => base_url('fees/invoice/' . $studentID));
        } else {
            $error = $this->form_validation->error_array();
            $array = array('status' => 'fail', 'error' => $error);
        }
        echo json_encode($array);
    }

    public function partial_reminder()
    {
        if (!can_manage_partial_fee_reminder()) {
            access_denied();
        }
        $branchID = $this->application_model->get_branch_id();
        $this->load->model('student_model');
        if ($this->input->post('save_reminder') || $this->input->post('clear_reminder')) {
            $date = $this->input->post('clear_reminder') ? '' : trim((string) $this->input->post('remind_on'));
            if ($date !== '' && !preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
                set_alert('error', 'Choose a valid reminder date.');
            } elseif (!$this->student_model->savePartialReminderDate($branchID, $date)) {
                set_alert('error', 'The reminder date could not be saved. Run application/migrations/partial_fee_reminder.sql on the database.');
            } else {
                set_alert('success', $date === '' ? 'The reminder date has been cleared.' : 'The receptionist will see the partial payment reminder on ' . _d($date) . '.');
            }
            redirect(base_url('fees/partial_reminder'));
        }
        $this->data['branch_id'] = $branchID;
        $this->data['remind_on'] = $this->student_model->getPartialReminderDate($branchID);
        $this->data['table_ready'] = $this->student_model->ensurePartialReminderTable();
        $this->data['groups'] = $this->data['table_ready'] ? $this->student_model->partialPaymentGroups($branchID) : array();
        $this->data['title'] = 'Partial payment reminder';
        $this->data['main_menu'] = 'fees';
        $this->data['sub_page'] = 'fees/partial_reminder';
        $this->load->view('layout/index', $this->data);
    }

    public function partial_reminder_due()
    {
        if (!is_receptionist_loggedin()) {
            $this->output->set_content_type('application/json')->set_output(json_encode(array('show' => false)));
            return;
        }
        $branchID = $this->application_model->get_branch_id();
        $this->load->model('student_model');
        $date = $this->student_model->getPartialReminderDate($branchID);
        if ($date === '' || $date !== date('Y-m-d')) {
            $this->output->set_content_type('application/json')->set_output(json_encode(array('show' => false)));
            return;
        }
        $groups = $this->student_model->partialPaymentGroups($branchID);
        $students = 0;
        foreach ($groups as $group) {
            $students += count($group['children']);
        }
        $html = $this->load->view('fees/_partial_reminder_groups', array('groups' => $groups), true);
        $this->output->set_content_type('application/json')->set_output(json_encode(array(
            'show' => $students > 0,
            'date' => $date,
            'students' => $students,
            'families' => count($groups),
            'html' => $html,
        )));
    }

    public function selectedFeesCollect()
    {
        if ($_POST) {
            $record = $this->input->post('data');
            $record_array = json_decode($record);
            $this->data['student_id'] = $this->input->post('student_id');
            $this->data['branch_id'] = $this->application_model->get_branch_id();
            $this->data['record_array'] = $record_array;
            $this->load->view('fees/selectedFeesCollect', $this->data);
        }
    }

    /**
     * Build a fee receipt as PDF or image and return it for WhatsApp.
     * deliver=whatsapp sends the file from the school number with the receipt caption.
     */
    public function receipt_share()
    {
        if (!get_permission('invoice', 'is_view')) {
            ajax_access_denied();
        }
        $enrollId = (int) $this->input->post('enroll_id');
        $format = (string) $this->input->post('format');
        if (!in_array($format, array('image', 'pdf', 'summary'), true)) {
            $format = 'pdf';
        }
        $deliver = $this->input->post('deliver') === 'whatsapp';
        $onlyIds = $this->receiptIdList($this->input->post('payment_ids'));
        $basic = $this->fees_model->getInvoiceBasic($enrollId);
        if (empty($basic)) {
            $this->receiptJson(array('ok' => false, 'error' => 'This invoice could not be opened.'));
            return;
        }
        $rows = $this->receiptPaymentRows($enrollId, $onlyIds);
        if (empty($rows)) {
            $this->receiptJson(array('ok' => false, 'error' => 'This invoice has no payment to send.'));
            return;
        }
        $pack = $this->receiptPack($basic, $rows);

        $selectedPhone = trim((string) $this->input->post('phone'));
        $targetPhone = $pack['phone'];
        if ($selectedPhone !== '') {
            $this->load->model('academy_model');
            $norm = $this->academy_model->parentPhoneList($selectedPhone);
            if (!empty($norm)) {
                $targetPhone = $norm[0];
            }
        }

        $link = '';
        if ($targetPhone !== '') {
            $link = 'https://api.whatsapp.com/send?phone=' . rawurlencode($targetPhone) . '&text=' . rawurlencode($pack['message']);
        }

        if ($format === 'summary') {
            $this->receiptJson(array(
                'ok' => true,
                'phone' => $targetPhone,
                'phones' => isset($pack['phones']) ? $pack['phones'] : (!empty($pack['phone']) ? array($pack['phone']) : array()),
                'guardian' => isset($pack['guardian']) ? $pack['guardian'] : '',
                'student' => isset($pack['student']) ? $pack['student'] : '',
                'message' => $pack['message'],
                'whatsapp' => $link,
                'filename' => '',
                'mime' => '',
                'file' => '',
            ));
            return;
        }

        try {
            if ($format === 'image') {
                $binary = $this->receiptImage($pack);
                $mime = 'image/png';
                $ext = 'png';
            } else {
                $binary = $this->receiptPdf($pack);
                $mime = 'application/pdf';
                $ext = 'pdf';
            }
        } catch (Throwable $e) {
            $this->receiptJson(array('ok' => false, 'error' => 'The receipt could not be prepared.'));
            return;
        }
        if ($binary === '' || $binary === null) {
            $this->receiptJson(array('ok' => false, 'error' => $format === 'image' ? 'Image receipts need the GD extension.' : 'The receipt could not be prepared.'));
            return;
        }
        $reg = preg_replace('/[^A-Za-z0-9\-]/', '', $pack['register']);
        if ($reg === '') {
            $reg = 'student';
        }
        $filename = 'fee-receipt-' . $reg . '.' . $ext;
        $sent = false;
        $sendError = '';
        if ($deliver) {
            if ($targetPhone === '') {
                $sendError = 'Add a parent phone number before sending from the school WhatsApp.';
            } else {
                $sentResult = $this->receiptSendCloud($targetPhone, $format, $filename, $binary, $pack['message']);
                $sent = !empty($sentResult['ok']);
                $sendError = $sent ? '' : (isset($sentResult['error']) ? $sentResult['error'] : 'WhatsApp could not send the receipt.');
            }
        }
        $this->receiptJson(array(
            'ok' => true,
            'sent' => $sent,
            'error' => $sendError,
            'phone' => $targetPhone,
            'phones' => isset($pack['phones']) ? $pack['phones'] : (!empty($pack['phone']) ? array($pack['phone']) : array()),
            'guardian' => isset($pack['guardian']) ? $pack['guardian'] : '',
            'student' => isset($pack['student']) ? $pack['student'] : '',
            'message' => $pack['message'],
            'whatsapp' => $link,
            'filename' => $filename,
            'mime' => $mime,
            'file' => base64_encode($binary),
        ));
    }

    private function receiptJson($payload)
    {
        $this->output->set_content_type('application/json')->set_output(json_encode($payload));
    }

    private function receiptIdList($raw)
    {
        if (is_array($raw)) {
            $parts = $raw;
        } elseif (is_string($raw) && trim($raw) !== '') {
            $parts = explode(',', $raw);
        } else {
            $parts = array();
        }
        $ids = array();
        foreach ($parts as $part) {
            $id = (int) $part;
            if ($id > 0) {
                $ids[$id] = $id;
            }
        }
        return array_values($ids);
    }

    private function receiptPaymentRows($enrollId, $onlyIds)
    {
        $enrollId = (int) $enrollId;
        $rows = array();
        $this->db->select('h.id, h.amount, h.discount, h.fine, h.date, t.name as fee_name, pt.name as payvia');
        $this->db->from('fee_payment_history h');
        $this->db->join('fee_allocation a', 'a.id = h.allocation_id', 'inner');
        $this->db->join('fees_type t', 't.id = h.type_id', 'left');
        $this->db->join('payment_types pt', 'pt.id = h.pay_via', 'left');
        $this->db->where('a.student_id', $enrollId);
        $this->db->where('a.session_id', get_session_id());
        if (!empty($onlyIds)) {
            $this->db->where_in('h.id', $onlyIds);
        }
        $this->db->order_by('h.date', 'asc');
        $this->db->order_by('h.id', 'asc');
        foreach ($this->db->get()->result_array() as $row) {
            if ($row['fee_name'] === '' || $row['fee_name'] === null) {
                $row['fee_name'] = 'Fee';
            }
            $rows[(int) $row['id']] = $row;
        }
        if (moduleIsEnabled('transport')) {
            $this->db->select('h.id, h.amount, h.discount, h.fine, h.date, pt.name as payvia, ff.month');
            $this->db->from('fee_payment_history h');
            $this->db->join('transport_fee_details td', 'td.id = h.transport_fee_details_id', 'inner');
            $this->db->join('transport_fee_fine ff', 'ff.id = td.transport_fee_fine_id', 'left');
            $this->db->join('payment_types pt', 'pt.id = h.pay_via', 'left');
            $this->db->where('td.enroll_id', $enrollId);
            if (!empty($onlyIds)) {
                $this->db->where_in('h.id', $onlyIds);
            }
            $this->db->order_by('h.date', 'asc');
            $this->db->order_by('h.id', 'asc');
            foreach ($this->db->get()->result_array() as $row) {
                $id = (int) $row['id'];
                if (isset($rows[$id])) {
                    continue;
                }
                $month = '';
                if (!empty($row['month'])) {
                    $month = $this->app_lib->getMonthslist($row['month']);
                }
                $row['fee_name'] = trim(translate('transport_fees') . ($month !== '' ? ' ' . $month : ''));
                $rows[$id] = $row;
            }
        }
        return array_values($rows);
    }

    private function receiptMoney($amount)
    {
        $text = trim(html_entity_decode(strip_tags(currencyFormat($amount)), ENT_QUOTES, 'UTF-8'));
        return $text !== '' ? $text : number_format((float) $amount, 2, '.', ',');
    }

    private function receiptPack($basic, $rows)
    {
        $nameBits = array(isset($basic['first_name']) ? $basic['first_name'] : '');
        if (!empty($basic['other_name'])) {
            $nameBits[] = $basic['other_name'];
        }
        $nameBits[] = isset($basic['last_name']) ? $basic['last_name'] : '';
        $student = trim(preg_replace('/\s+/', ' ', implode(' ', $nameBits)));
        if (!empty($basic['class_name']) && !empty($basic['section_name'])) {
            $classLine = $basic['class_name'] . ' (' . $basic['section_name'] . ')';
        } elseif (!empty($basic['class_name'])) {
            $classLine = $basic['class_name'];
        } else {
            $classLine = isset($basic['section_name']) ? $basic['section_name'] : '';
        }
        $guardian = isset($basic['guardian_name']) ? trim($basic['guardian_name']) : '';
        if (!empty($basic['guardian_mobile'])) {
            $guardian = trim($guardian . ($guardian !== '' ? ' · ' : '') . $basic['guardian_mobile']);
        }
        $school = !empty($basic['school_name']) ? $basic['school_name'] : 'Tahsin Academy';
        if (!empty($this->data['global_config']['institute_name'])) {
            $school = $this->data['global_config']['institute_name'];
        }
        $contactBits = array();
        foreach (array('school_address', 'school_mobileno', 'school_email') as $key) {
            if (!empty($basic[$key])) {
                $contactBits[] = $basic[$key];
            }
        }
        $enrollId = (int) $basic['enroll_id'];
        $feeTotal = 0;
        $balance = 0;
        foreach ($this->fees_model->getInvoiceDetails($enrollId) as $row) {
            $deposit = $this->fees_model->getStudentFeeDeposit($row['allocation_id'], $row['fee_type_id']);
            $feeTotal += (float) $row['amount'];
            $balance += (float) $row['amount'] - ((float) $deposit['total_amount'] + (float) $deposit['total_discount']);
        }
        if (moduleIsEnabled('transport') && !empty($basic['stoppage_point_id'])) {
            $transport = $this->fees_model->getStudentTransportFees($enrollId, $basic['stoppage_point_id']);
            foreach ($transport as $value) {
                $feeTotal += (float) $value->route_fare;
                $owed = $this->fees_model->getTransportBalance($value->id);
                $balance += (float) $owed['balance'];
            }
        }
        $paid = 0;
        $dates = array();
        $lines = array();
        $displayRows = array();
        foreach ($rows as $row) {
            $amount = (float) $row['amount'];
            $paid += $amount;
            $dateText = !empty($row['date']) ? _d($row['date']) : '';
            if ($dateText !== '') {
                $dates[$dateText] = $dateText;
            }
            $paidText = $this->receiptMoney($amount);
            $displayRows[] = array(
                'name' => $row['fee_name'],
                'date' => $dateText,
                'method' => isset($row['payvia']) ? $row['payvia'] : '',
                'paid_text' => $paidText,
            );
            $lines[] = array('label' => $row['fee_name'], 'amount' => $paidText);
        }
        $paidText = $this->receiptMoney($paid);
        $balanceText = $this->receiptMoney($balance);
        $feeText = $this->receiptMoney($feeTotal);
        $paidOn = implode(', ', $dates);
        $this->load->model('student_model');
        $message = $this->student_model->feeReceiptMessage(
            $student,
            isset($basic['register_no']) ? $basic['register_no'] : '',
            $feeText,
            $paidText,
            $paidOn,
            $balanceText,
            count($lines) > 1 ? $lines : array()
        );
        if (function_exists('mb_strlen') && mb_strlen($message) > 1024) {
            $message = rtrim(mb_substr($message, 0, 1020)) . '...';
        }
        $extra = '';
        if ($this->db->field_exists('extra_phones', 'parent')) {
            $parent = $this->db->select('p.extra_phones')
                ->from('enroll e')
                ->join('student s', 's.id = e.student_id', 'inner')
                ->join('parent p', 'p.id = s.parent_id', 'left')
                ->where('e.id', $enrollId)
                ->get()->row();
            if ($parent && !empty($parent->extra_phones)) {
                $extra = $parent->extra_phones;
            }
        }
        $this->load->model('academy_model');
        $phones = $this->academy_model->parentPhoneList(
            isset($basic['guardian_mobile']) ? $basic['guardian_mobile'] : '',
            $extra,
            isset($basic['mobileno']) ? $basic['mobileno'] : ''
        );
        $status = $this->fees_model->getInvoiceStatus($enrollId);
        return array(
            'school' => $school,
            'motto' => defined('SCHOOL_MOTTO') ? SCHOOL_MOTTO : '',
            'contact' => implode(' · ', $contactBits),
            'student' => $student,
            'register' => isset($basic['register_no']) ? $basic['register_no'] : '',
            'class_line' => $classLine,
            'guardian' => $guardian,
            'invoice_no' => isset($status['invoice_no']) ? $status['invoice_no'] : '',
            'issued' => _d(date('Y-m-d')),
            'rows' => $displayRows,
            'fee_text' => $feeText,
            'paid_text' => $paidText,
            'balance' => $balance,
            'balance_text' => $balanceText,
            'message' => $message,
            'phones' => $phones,
            'phone' => !empty($phones) ? (string) $phones[0] : '',
        );
    }

    private function receiptPdf($pack)
    {
        $html = $this->load->view('fees/_fee_receipt_doc', array('pack' => $pack), true);
        $this->load->library('html2pdf');
        $this->html2pdf->mpdf->SetTitle('Fee receipt');
        $this->html2pdf->mpdf->WriteHTML($html);
        return $this->html2pdf->mpdf->Output('', 'S');
    }

    private function receiptSendCloud($phone, $format, $filename, $binary, $message)
    {
        $dir = FCPATH . 'uploads/temp/fee_receipts';
        if (!is_dir($dir)) {
            @mkdir($dir, 0777, true);
        }
        if (is_dir($dir)) {
            $oldFiles = glob($dir . DIRECTORY_SEPARATOR . '*');
            if (is_array($oldFiles)) {
                foreach ($oldFiles as $old) {
                    if (is_file($old) && filemtime($old) < time() - 86400) {
                        @unlink($old);
                    }
                }
            }
        }
        $path = $dir . DIRECTORY_SEPARATOR . $filename;
        if (is_file($path)) {
            $path = $dir . DIRECTORY_SEPARATOR . pathinfo($filename, PATHINFO_FILENAME) . '-' . bin2hex(random_bytes(3)) . '.' . pathinfo($filename, PATHINFO_EXTENSION);
        }
        file_put_contents($path, $binary);
        $this->load->library('whatsapp_cloud');
        $type = $format === 'image' ? 'image' : 'document';
        $url = base_url('uploads/temp/fee_receipts/' . basename($path));
        $result = $this->whatsapp_cloud->sendMediaByUrl($phone, $type, $url, $message);
        @unlink($path);
        return $result;
    }

    private function receiptAscii($text)
    {
        $text = html_entity_decode(strip_tags((string) $text), ENT_QUOTES, 'UTF-8');
        $text = str_replace(array('₦', '—', '–', '·'), array('NGN ', '-', '-', ' - '), $text);
        $text = preg_replace('/[^\x20-\x7E]/', '', $text);
        return trim($text);
    }

    private function receiptImage($pack)
    {
        if (!function_exists('imagecreatetruecolor') || !function_exists('imagepng')) {
            return null;
        }
        $rows = $pack['rows'];
        $w = 760;
        $h = 620 + (count($rows) * 28);
        $im = imagecreatetruecolor($w, $h);
        $white = imagecolorallocate($im, 255, 255, 255);
        $green = imagecolorallocate($im, 15, 92, 76);
        $gold = imagecolorallocate($im, 201, 162, 39);
        $cream = imagecolorallocate($im, 248, 241, 216);
        $ink = imagecolorallocate($im, 26, 26, 26);
        $muted = imagecolorallocate($im, 90, 90, 90);
        $line = imagecolorallocate($im, 213, 221, 217);
        $due = imagecolorallocate($im, 169, 68, 66);
        imagefilledrectangle($im, 0, 0, $w, $h, $white);
        imagefilledrectangle($im, 0, 0, $w, 10, $green);
        $logo = FCPATH . 'uploads/app_image/printing-logo.png';
        if (is_file($logo)) {
            $src = @imagecreatefrompng($logo);
            if ($src) {
                imagecopyresampled($im, $src, 28, 24, 0, 0, 64, 64, imagesx($src), imagesy($src));
                imagedestroy($src);
            }
        }
        imagestring($im, 5, 108, 28, $this->receiptAscii($pack['school']), $green);
        imagestring($im, 3, 108, 52, $this->receiptAscii($pack['motto']), $gold);
        imagestring($im, 2, 108, 74, substr($this->receiptAscii($pack['contact']), 0, 78), $muted);
        imagefilledrectangle($im, 28, 104, $w - 28, 108, $green);
        imagestring($im, 5, 28, 122, 'FEE RECEIPT', $green);
        imagestring($im, 3, 28, 146, $this->receiptAscii('Invoice No #' . $pack['invoice_no'] . '   Issued ' . $pack['issued']), $muted);
        $y = 176;
        imagefilledrectangle($im, 28, $y, $w - 28, $y + 22, $green);
        imagestring($im, 3, 36, $y + 4, 'STUDENT PARTICULARS', $white);
        $y += 30;
        $facts = array(
            'Full Name' => $pack['student'],
            'Register No' => $pack['register'],
            'Class / Section' => $pack['class_line'],
            'Guardian' => $pack['guardian'],
        );
        foreach ($facts as $label => $value) {
            imagestring($im, 3, 36, $y, $label, $green);
            imagestring($im, 3, 190, $y, substr($this->receiptAscii($value), 0, 62), $ink);
            $y += 20;
        }
        $y += 8;
        imagefilledrectangle($im, 28, $y, $w - 28, $y + 22, $green);
        imagestring($im, 3, 36, $y + 4, 'PAYMENT', $white);
        $y += 22;
        imagefilledrectangle($im, 28, $y, $w - 28, $y + 22, $cream);
        imagestring($im, 3, 36, $y + 4, 'Fee', $ink);
        imagestring($im, 3, 280, $y + 4, 'Date', $ink);
        imagestring($im, 3, 430, $y + 4, 'Method', $ink);
        imagestring($im, 3, 580, $y + 4, 'Paid', $ink);
        $y += 22;
        foreach ($rows as $row) {
            imagerectangle($im, 28, $y, $w - 28, $y + 26, $line);
            imagestring($im, 3, 36, $y + 6, substr($this->receiptAscii($row['name']), 0, 28), $ink);
            imagestring($im, 3, 280, $y + 6, substr($this->receiptAscii($row['date']), 0, 16), $ink);
            imagestring($im, 3, 430, $y + 6, substr($this->receiptAscii($row['method']), 0, 16), $ink);
            imagestring($im, 3, 580, $y + 6, substr($this->receiptAscii($row['paid_text']), 0, 18), $green);
            $y += 26;
        }
        $y += 10;
        $totals = array(
            array('School fees', $pack['fee_text'], $ink),
            array('Paid on this receipt', $pack['paid_text'], $green),
            array('Remaining', $pack['balance_text'], $pack['balance'] > 0 ? $due : $green),
        );
        foreach ($totals as $total) {
            imagestring($im, 4, 36, $y, $total[0], $ink);
            imagestring($im, 4, 280, $y, $this->receiptAscii($total[1]), $total[2]);
            $y += 22;
        }
        $y += 16;
        imagefilledrectangle($im, 28, $y, $w - 28, $y + 36, $cream);
        imagestring($im, 5, 36, $y + 10, substr('PAID  ' . $this->receiptAscii($pack['paid_text']), 0, 42), $green);
        $y += 52;
        imagestring($im, 2, 28, $y, substr($this->receiptAscii('Issued by ' . $pack['school'] . '. Keep this receipt.'), 0, 90), $muted);
        ob_start();
        imagepng($im);
        $binary = ob_get_clean();
        imagedestroy($im);
        return $binary;
    }
}
