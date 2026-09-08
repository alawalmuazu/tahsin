<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Infrastructure_model extends CI_Model
{
    public function getAll($branchID = null)
    {
        $this->db->select('i.*, b.name as school_name, b.lga');
        $this->db->from('infrastructure as i');
        $this->db->join('branch as b', 'b.id = i.branch_id', 'left');
        if (!empty($branchID)) {
            $this->db->where('i.branch_id', $branchID);
        }
        $this->db->order_by('b.lga, b.name, i.type, i.name');
        return $this->db->get()->result_array();
    }
}
