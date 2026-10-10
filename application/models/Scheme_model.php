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
        $this->ensure_schema();
    }

    /**
     * Ensure required columns exist across environments
     */
    protected function ensure_schema() {
        if (!$this->db->field_exists('delivery_status', $this->table)) {
            $this->db->query("ALTER TABLE `{$this->table}` ADD COLUMN `delivery_status` ENUM('not_started', 'in_progress', 'completed', 'delayed') NOT NULL DEFAULT 'not_started' AFTER `reference_book`");
        }
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
     * Update delivery pacing status
     */
    public function update_delivery_status($id, $status) {
        $allowed = array('not_started', 'in_progress', 'completed', 'delayed');
        if (!in_array($status, $allowed)) {
            $status = 'not_started';
        }
        $this->db->where('id', $id);
        return $this->db->update($this->table, array(
            'delivery_status' => $status,
            'updated_at'      => date('Y-m-d H:i:s')
        ));
    }

    /**
     * Calculate curriculum pacing / completion velocity
     */
    public function get_pacing_stats($level = null, $term = null, $subject = null, $week = null) {
        $schemes = $this->get_schemes($level, $term, $subject, $week);
        $total = count($schemes);
        $counts = array(
            'total'       => $total,
            'completed'   => 0,
            'in_progress' => 0,
            'not_started' => 0,
            'delayed'     => 0,
            'percentage'  => 0
        );

        foreach ($schemes as $s) {
            $st = !empty($s['delivery_status']) ? $s['delivery_status'] : 'not_started';
            if (isset($counts[$st])) {
                $counts[$st]++;
            } else {
                $counts['not_started']++;
            }
        }

        if ($total > 0) {
            $counts['percentage'] = round(($counts['completed'] / $total) * 100);
        }

        return $counts;
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

    /**
     * Retrieve distinct grade levels present in active schemes
     */
    public function get_distinct_grade_levels() {
        $this->db->distinct();
        $this->db->select('grade_level');
        $this->db->where('status', 'active');
        $this->db->order_by('grade_level', 'ASC');
        $rows = $this->db->get($this->table)->result_array();
        $levels = array_filter(array_column($rows, 'grade_level'));
        $defaults = array('Pre-Nursery', 'Nursery 1', 'Nursery 2');
        return array_values(array_unique(array_merge($defaults, $levels)));
    }

    /**
     * Retrieve distinct subjects present in active schemes
     */
    public function get_distinct_subjects() {
        $this->db->distinct();
        $this->db->select('subject');
        $this->db->where('status', 'active');
        $this->db->order_by('subject', 'ASC');
        $rows = $this->db->get($this->table)->result_array();
        $subjects = array_filter(array_column($rows, 'subject'));
        $defaults = array('English Language / Literacy', 'Mathematics / Numeracy', 'Social & Civic Habits');
        return array_values(array_unique(array_merge($defaults, $subjects)));
    }
}
