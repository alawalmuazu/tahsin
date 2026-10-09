<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Scheme_model
 * Handles database operations for School Schemes of Work at Tahsin Academy.
 */
class Scheme_model extends CI_Model {

    protected $table = 'schemes_of_work';

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Retrieve all schemes with optional filters
     */
    public function get_schemes($level = null, $term = null, $subject = null, $week = null) {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('status', 'active');

        if (!empty($level) && $level !== 'ALL') {
            $this->db->where('grade_level', $level);
        }
        if (!empty($term) && $term !== 'ALL') {
            $this->db->where('academic_term', $term);
        }
        if (!empty($subject) && $subject !== 'ALL') {
            $this->db->where('subject', $subject);
        }
        if (!empty($week) && $week !== 'ALL') {
            $this->db->where('week_number', $week);
        }

        $this->db->order_by('grade_level', 'ASC');
        $this->db->order_by('academic_term', 'ASC');
        $this->db->order_by('id', 'ASC');

        $query = $this->db->get();
        return $query->result_array();
    }

    /**
     * Get a single scheme entry by ID
     */
    public function get_scheme_by_id($id) {
        return $this->db->get_where($this->table, array('id' => $id))->row_array();
    }

    /**
     * Create a new scheme entry
     */
    public function insert_scheme($data) {
        $data['created_at'] = date('Y-m-d H:i:s');
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    /**
     * Update an existing scheme entry
     */
    public function update_scheme($id, $data) {
        $data['updated_at'] = date('Y-m-d H:i:s');
        $this->db->where('id', $id);
        return $this->db->update($this->table, $data);
    }

    /**
     * Soft delete a scheme entry
     */
    public function delete_scheme($id) {
        $this->db->where('id', $id);
        return $this->db->update($this->table, array('status' => 'archived'));
    }

    /**
     * Export all active schemes for JSON API / Backup
     */
    public function export_all_active() {
        $this->db->where('status', 'active');
        return $this->db->get($this->table)->result_array();
    }
}
