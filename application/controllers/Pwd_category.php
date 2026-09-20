<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pwd_category extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('pwd_category_model');
    }

    public function index()
    {
        if (!get_permission('pwd_category', 'is_view') && !get_permission('school_settings', 'is_view') && !is_superadmin_loggedin()) {
            access_denied();
        }
        $branchID = $this->application_model->get_branch_id();

        if ($this->input->post('save')) {
            if (!get_permission('pwd_category', 'is_add') && !get_permission('pwd_category', 'is_edit') && !is_superadmin_loggedin()) {
                access_denied();
            }
            $this->form_validation->set_rules('name', 'Category name', 'trim|required');
            if ($this->form_validation->run() == true) {
                if (!$this->pwd_category_model->tableReady()) {
                    set_alert('error', 'Run pwd_student_categories.sql on the database first.');
                } else {
                    $this->pwd_category_model->save(array(
                        'id' => $this->input->post('id'),
                        'branch_id' => $branchID,
                        'name' => $this->input->post('name'),
                        'sort_order' => $this->input->post('sort_order'),
                        'active' => $this->input->post('active') ? 1 : 0,
                        'is_default' => $this->input->post('is_default') ? 1 : 0,
                    ));
                    set_alert('success', translate('information_has_been_saved_successfully'));
                }
                redirect(base_url('pwd_category'));
            }
        }

        $this->data['branch_id'] = $branchID;
        $this->data['list'] = $this->pwd_category_model->getList($branchID, false);
        $this->data['title'] = 'Student Categories (PWD)';
        $this->data['sub_page'] = 'pwd_category/index';
        $this->data['main_menu'] = 'settings';
        $this->load->view('layout/index', $this->data);
    }

    public function delete($id = 0)
    {
        if (!get_permission('pwd_category', 'is_delete') && !is_superadmin_loggedin()) {
            access_denied();
        }
        $branchID = $this->application_model->get_branch_id();
        if (!$this->pwd_category_model->delete($id, $branchID)) {
            set_alert('error', 'Cannot delete the default category.');
        } else {
            set_alert('success', translate('information_deleted'));
        }
        redirect(base_url('pwd_category'));
    }
}
