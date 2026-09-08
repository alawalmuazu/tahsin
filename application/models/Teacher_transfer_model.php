<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Teacher_transfer_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getPendingTransfers($staff_id = null)
    {
        $this->db->select('tt.*, s.name as staff_name, s.designation, sd.name as designation_name, b1.name as from_branch, b2.name as to_branch');
        $this->db->from('teacher_transfers tt');
        $this->db->join('staff s', 'tt.staff_id = s.id', 'left');
        $this->db->join('staff_designation sd', 's.designation = sd.id', 'left');
        $this->db->join('branch b1', 'tt.from_branch_id = b1.id', 'left');
        $this->db->join('branch b2', 'tt.to_branch_id = b2.id', 'left');
        $this->db->where('tt.status', 'pending');
        if ($staff_id) {
            $this->db->where('tt.staff_id', $staff_id);
        }
        $this->db->order_by('tt.id', 'DESC');
        return $this->db->get()->result_array();
    }

    public function getAllTransfers($staff_id = null)
    {
        $this->db->select('tt.*, s.name as staff_name, s.designation, sd.name as designation_name, b1.name as from_branch, b2.name as to_branch');
        $this->db->from('teacher_transfers tt');
        $this->db->join('staff s', 'tt.staff_id = s.id', 'left');
        $this->db->join('staff_designation sd', 's.designation = sd.id', 'left');
        $this->db->join('branch b1', 'tt.from_branch_id = b1.id', 'left');
        $this->db->join('branch b2', 'tt.to_branch_id = b2.id', 'left');
        if ($staff_id) {
            $this->db->where('tt.staff_id', $staff_id);
        }
        $this->db->order_by('tt.id', 'DESC');
        return $this->db->get()->result_array();
    }

    public function getTransferById($id)
    {
        $this->db->select('tt.*, s.name as staff_name, s.designation, sd.name as designation_name, b1.name as from_branch, b2.name as to_branch');
        $this->db->from('teacher_transfers tt');
        $this->db->join('staff s', 'tt.staff_id = s.id', 'left');
        $this->db->join('staff_designation sd', 's.designation = sd.id', 'left');
        $this->db->join('branch b1', 'tt.from_branch_id = b1.id', 'left');
        $this->db->join('branch b2', 'tt.to_branch_id = b2.id', 'left');
        $this->db->where('tt.id', $id);
        return $this->db->get()->row_array();
    }

    public function createTransfer($data)
    {
        return $this->db->insert('teacher_transfers', $data);
    }

    public function hasPendingRequest($staff_id)
    {
        return $this->db->get_where('teacher_transfers', [
            'staff_id' => $staff_id,
            'status'   => 'pending'
        ])->num_rows() > 0;
    }

    public function approveTransfer($id, $reviewer_id, $override_branch_id = null)
    {
        $transfer = $this->db->get_where('teacher_transfers', ['id' => $id])->row_array();
        if (!$transfer || $transfer['status'] !== 'pending') {
            return false;
        }

        // Admin may override the target school
        $final_branch_id = $override_branch_id ? $override_branch_id : $transfer['to_branch_id'];

        $this->db->trans_start();

        // 1. Update staff branch
        $this->db->where('id', $transfer['staff_id']);
        $this->db->update('staff', ['branch_id' => $final_branch_id]);

        // 2. Mark previous posting history as left if any exists and is open
        $this->db->where('staff_id', $transfer['staff_id']);
        $this->db->where('date_left IS NULL');
        $this->db->update('staff_posting_history', ['date_left' => date('Y-m-d')]);

        // 3. Create new posting history
        $history_data = [
            'staff_id'   => $transfer['staff_id'],
            'branch_id'  => $final_branch_id,
            'posted_by'  => $reviewer_id,
            'date_posted'=> $transfer['effective_date'],
            'reason'     => 'Transfer Approval'
        ];
        $this->db->insert('staff_posting_history', $history_data);

        // 4. Update transfer record: set final branch, status, reviewer
        $this->db->where('id', $id);
        $this->db->update('teacher_transfers', [
            'status'      => 'approved',
            'to_branch_id'=> $final_branch_id,
            'reviewed_by' => $reviewer_id
        ]);

        $this->db->trans_complete();

        return $this->db->trans_status();
    }

    public function rejectTransfer($id, $note, $reviewer_id)
    {
        $this->db->where('id', $id);
        return $this->db->update('teacher_transfers', [
            'status' => 'rejected',
            'reviewed_by' => $reviewer_id,
            'rejection_note' => $note
        ]);
    }

    public function getPostingHistory($staff_id)
    {
        $this->db->select('sph.*, b.name as branch_name, lc.username as posted_by_name');
        $this->db->from('staff_posting_history sph');
        $this->db->join('branch b', 'sph.branch_id = b.id', 'left');
        $this->db->join('login_credential lc', 'sph.posted_by = lc.id', 'left');
        $this->db->where('sph.staff_id', $staff_id);
        $this->db->order_by('sph.date_posted', 'DESC');
        return $this->db->get()->result_array();
    }
}
