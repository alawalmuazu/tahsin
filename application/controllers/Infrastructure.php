<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Infrastructure Register Controller
 * Tracks school buildings, facilities, and physical assets per branch
 * Tahsin Academy — facilities and assets per branch
 */
class Infrastructure extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('infrastructure_model');
        // Restrict to admin and above
        if (!(is_superadmin_loggedin() || is_state_executive_loggedin() || is_admin_loggedin())) {
            access_denied();
        }
    }

    // ── List ─────────────────────────────────────────────────────────────────
    public function index()
    {
        if (!get_permission('infrastructure', 'is_view')) {
            access_denied();
        }
        $branchID = $this->application_model->get_branch_id();
        $this->data['branch_id']  = $branchID;
        $this->data['records']    = $this->infrastructure_model->getAll($branchID);
        $this->data['title']      = 'Infrastructure Register';
        $this->data['sub_page']   = 'infrastructure/index';
        $this->data['main_menu']  = 'infrastructure';
        $this->load->view('layout/index', $this->data);
    }

    // ── Save (Add / Edit) ────────────────────────────────────────────────────
    public function save()
    {
        if (!$_POST) return;

        $isEdit = !empty($this->input->post('id'));
        $perm   = $isEdit ? 'is_edit' : 'is_add';
        if (!get_permission('infrastructure', $perm)) {
            ajax_access_denied();
        }

        if (is_superadmin_loggedin()) {
            $this->form_validation->set_rules('branch_id', 'Branch', 'required');
        }
        $this->form_validation->set_rules('name',      'Name',      'trim|required');
        $this->form_validation->set_rules('type',      'Type',      'trim|required');
        $this->form_validation->set_rules('condition', 'Condition', 'trim|required');

        if ($this->form_validation->run() !== false) {
            $branchID = $this->application_model->get_branch_id();
            $data = [
                'branch_id'    => $branchID,
                'name'         => $this->input->post('name'),
                'type'         => $this->input->post('type'),
                'quantity'     => (int) $this->input->post('quantity') ?: 1,
                'capacity'     => (int) $this->input->post('capacity') ?: 0,
                'condition'    => $this->input->post('condition'),
                'year_built'   => $this->input->post('year_built') ?: null,
                'notes'        => $this->input->post('notes'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ];
            if ($isEdit) {
                $id = (int) $this->input->post('id');
                $this->db->where('id', $id);
                if (!is_superadmin_loggedin()) {
                    $this->db->where('branch_id', get_loggedin_branch_id());
                }
                $this->db->update('infrastructure', $data);
                $msg = 'Record updated successfully.';
            } else {
                $data['created_at'] = date('Y-m-d H:i:s');
                $this->db->insert('infrastructure', $data);
                $msg = 'Record added successfully.';
            }
            $array = ['status' => 'success', 'message' => $msg];
        } else {
            $array = ['status' => 'fail', 'error' => $this->form_validation->error_array()];
        }
        echo json_encode($array);
    }

    // ── Details (AJAX for edit modal) ─────────────────────────────────────────
    public function details()
    {
        if (!get_permission('infrastructure', 'is_edit')) {
            ajax_access_denied();
        }
        $id  = (int) $this->input->post('id');
        $row = $this->db->where('id', $id)->get('infrastructure')->row_array();
        echo json_encode($row);
    }

    // ── Delete ────────────────────────────────────────────────────────────────
    public function delete($id)
    {
        if (!get_permission('infrastructure', 'is_delete')) {
            access_denied();
        }
        if (!is_superadmin_loggedin()) {
            $this->db->where('branch_id', get_loggedin_branch_id());
        }
        $this->db->where('id', (int) $id)->delete('infrastructure');
    }

    // ── CSV Export ────────────────────────────────────────────────────────────
    public function export_csv()
    {
        if (!get_permission('infrastructure', 'is_view')) {
            access_denied();
        }
        $branchID = $this->application_model->get_branch_id();
        $rows = $this->infrastructure_model->getAll($branchID);

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="Infrastructure_Register_' . date('Y-m-d') . '.csv"');
        $out = fopen('php://output', 'w');
        fputcsv($out, ['School', 'LGA', 'Type', 'Name', 'Quantity', 'Capacity', 'Condition', 'Year Built', 'Notes']);
        foreach ($rows as $row) {
            fputcsv($out, [
                $row['school_name'], $row['lga'], $row['type'], $row['name'],
                $row['quantity'], $row['capacity'], $row['condition'],
                $row['year_built'], $row['notes'],
            ]);
        }
        fclose($out);
        exit;
    }
}
