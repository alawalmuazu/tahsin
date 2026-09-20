<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Audit_trail_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getLogs($filters = array(), $limit = 200)
    {
        if (!$this->db->table_exists('audit_log')) {
            return array();
        }

        $this->db->from('audit_log');
        $this->applyFilters($filters);
        $this->db->order_by('id', 'DESC');
        $this->db->limit((int) $limit);
        return $this->db->get()->result();
    }

    public function getById($id)
    {
        return $this->db->where('id', (int) $id)->get('audit_log')->row();
    }

    public function distinctActions()
    {
        if (!$this->db->table_exists('audit_log')) {
            return array();
        }
        $this->db->distinct();
        $this->db->select('action');
        $rows = $this->db->order_by('action', 'ASC')->get('audit_log')->result();
        $out = array();
        foreach ($rows as $r) {
            $out[] = $r->action;
        }
        return $out;
    }

    public function distinctModules()
    {
        if (!$this->db->table_exists('audit_log')) {
            return array();
        }
        $this->db->distinct();
        $this->db->select('module');
        $rows = $this->db->order_by('module', 'ASC')->get('audit_log')->result();
        $out = array();
        foreach ($rows as $r) {
            if ($r->module !== '') {
                $out[] = $r->module;
            }
        }
        return $out;
    }

    protected function applyFilters($filters)
    {
        if (!empty($filters['action'])) {
            $this->db->where('action', $filters['action']);
        }
        if (!empty($filters['module'])) {
            $this->db->where('module', $filters['module']);
        }
        if (!empty($filters['user'])) {
            $this->db->group_start()
                ->like('username', $filters['user'])
                ->or_where('user_id', (int) $filters['user'])
                ->group_end();
        }
        if (!empty($filters['from'])) {
            $this->db->where('created_at >=', date('Y-m-d 00:00:00', strtotime($filters['from'])));
        }
        if (!empty($filters['to'])) {
            $this->db->where('created_at <=', date('Y-m-d 23:59:59', strtotime($filters['to'])));
        }
        if (!empty($filters['q'])) {
            $q = $filters['q'];
            $this->db->group_start()
                ->like('description', $q)
                ->or_like('table_name', $q)
                ->or_like('record_id', $q)
                ->or_like('ip_address', $q)
                ->or_like('url', $q)
                ->group_end();
        }
        if (!is_superadmin_loggedin() && !is_director_loggedin()) {
            $this->db->where('branch_id', get_loggedin_branch_id());
        }
    }
}
