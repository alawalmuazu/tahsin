<?php
defined('BASEPATH') or exit('No direct script access allowed');

class School_inspection_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getReports($branch_id = null)
    {
        $this->db->select('si.*, b.name as branch_name, lc.username as inspector_name');
        $this->db->from('school_inspections si');
        $this->db->join('branch b', 'si.branch_id = b.id', 'left');
        $this->db->join('login_credential lc', 'si.inspector_id = lc.id', 'left');
        
        if (!empty($branch_id)) {
            $this->db->where('si.branch_id', $branch_id);
        }
        
        $this->db->order_by('si.inspection_date', 'DESC');
        return $this->db->get()->result_array();
    }

    public function getReportById($id)
    {
        $this->db->select('si.*, b.name as branch_name, lc.username as inspector_name');
        $this->db->from('school_inspections si');
        $this->db->join('branch b', 'si.branch_id = b.id', 'left');
        $this->db->join('login_credential lc', 'si.inspector_id = lc.id', 'left');
        $this->db->where('si.id', $id);
        
        return $this->db->get()->row_array();
    }

    public function saveReport($data, $deficiencies = [])
    {
        $this->db->trans_start();

        // Calculate score
        $total_score = round(($data['infrastructure_score'] + $data['teaching_quality_score'] + $data['compliance_score']) / 3);
        $data['total_score'] = $total_score;
        
        // Compute letter grade
        if ($total_score >= 80) {
            $data['overall_grade'] = 'Excellent';
        } elseif ($total_score >= 60) {
            $data['overall_grade'] = 'Good';
        } elseif ($total_score >= 40) {
            $data['overall_grade'] = 'Fair';
        } else {
            $data['overall_grade'] = 'Poor';
        }

        $this->db->insert('school_inspections', $data);
        $inspection_id = $this->db->insert_id();

        if (!empty($deficiencies)) {
            foreach ($deficiencies as &$def) {
                $def['inspection_id'] = $inspection_id;
            }
            $this->db->insert_batch('inspection_deficiencies', $deficiencies);
        }

        $this->db->trans_complete();

        return $this->db->trans_status();
    }

    public function updateReport($id, $data, $deficiencies = [])
    {
        $this->db->trans_start();
        
        // Calculate score
        $total_score = round(($data['infrastructure_score'] + $data['teaching_quality_score'] + $data['compliance_score']) / 3);
        $data['total_score'] = $total_score;
        
        // Compute letter grade
        if ($total_score >= 80) {
            $data['overall_grade'] = 'Excellent';
        } elseif ($total_score >= 60) {
            $data['overall_grade'] = 'Good';
        } elseif ($total_score >= 40) {
            $data['overall_grade'] = 'Fair';
        } else {
            $data['overall_grade'] = 'Poor';
        }

        $this->db->where('id', $id);
        $this->db->update('school_inspections', $data);

        // Sync deficiencies
        $ids_to_keep = [];
        if (!empty($deficiencies)) {
            foreach ($deficiencies as $def) {
                if (!empty($def['id'])) {
                    // Update existing
                    $def_id = $def['id'];
                    unset($def['id']);
                    $this->db->where('id', $def_id);
                    $this->db->update('inspection_deficiencies', $def);
                    $ids_to_keep[] = $def_id;
                } else {
                    // Insert new
                    unset($def['id']);
                    $def['inspection_id'] = $id;
                    $this->db->insert('inspection_deficiencies', $def);
                    $ids_to_keep[] = $this->db->insert_id();
                }
            }
        }

        // Delete removed deficiencies
        $this->db->where('inspection_id', $id);
        if (!empty($ids_to_keep)) {
            $this->db->where_not_in('id', $ids_to_keep);
        }
        $this->db->delete('inspection_deficiencies');

        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    public function getDeficiencies($inspection_id)
    {
        $this->db->where('inspection_id', $inspection_id);
        return $this->db->get('inspection_deficiencies')->result_array();
    }

    public function updateDeficiencyStatus($id, $status)
    {
        $data = ['remediation_status' => $status];
        if ($status == 'Resolved') {
            $data['resolved_at'] = date('Y-m-d');
        } else {
            $data['resolved_at'] = null;
        }
        
        $this->db->where('id', $id);
        return $this->db->update('inspection_deficiencies', $data);
    }
}
