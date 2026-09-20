<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Audit_trail_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getById($id)
    {
        if (!$this->db->table_exists('audit_log')) {
            return null;
        }
        $this->db->where('id', (int) $id);
        if (!is_superadmin_loggedin() && !is_director_loggedin()) {
            $this->db->where('branch_id', get_loggedin_branch_id());
        }
        return $this->db->get('audit_log')->row();
    }

    public function getLogListDT($postData, $scope = 'all')
    {
        $response = array(
            'draw' => isset($postData['draw']) ? (int) $postData['draw'] : 0,
            'recordsTotal' => 0,
            'recordsFiltered' => 0,
            'data' => array(),
        );

        if (!$this->db->table_exists('audit_log')) {
            return json_encode($response);
        }

        $draw = isset($postData['draw']) ? (int) $postData['draw'] : 0;
        $start = isset($postData['start']) ? (int) $postData['start'] : 0;
        $rowperpage = isset($postData['length']) ? (int) $postData['length'] : 25;
        if ($rowperpage < 0) {
            $rowperpage = 10000;
        }
        $searchValue = isset($postData['search']['value']) ? trim($postData['search']['value']) : '';
        $columnIndex = isset($postData['order'][0]['column']) ? (int) $postData['order'][0]['column'] : 0;
        $columnSortOrder = isset($postData['order'][0]['dir']) && strtolower($postData['order'][0]['dir']) === 'asc' ? 'ASC' : 'DESC';

        $scopeWhere = $this->scopeWhereSql($scope);
        $branchWhere = '';
        if (!is_superadmin_loggedin() && !is_director_loggedin()) {
            $branchWhere = ' AND `audit_log`.`branch_id` = ' . $this->db->escape(get_loggedin_branch_id());
        }

        $column_order = array('`audit_log`.`id`');
        if (is_multi_school()) {
            $column_order[] = '`audit_log`.`branch_id`';
        }
        $column_order[] = '`audit_log`.`username`';
        $column_order[] = '`audit_log`.`role_id`';
        $column_order[] = '`audit_log`.`action`';
        $column_order[] = '`audit_log`.`module`';
        $column_order[] = '`audit_log`.`description`';
        $column_order[] = '`audit_log`.`ip_address`';
        $column_order[] = '`audit_log`.`created_at`';
        $column_order[] = '`audit_log`.`id`';

        if (!isset($column_order[$columnIndex])) {
            $columnIndex = 0;
            $columnSortOrder = 'DESC';
        }

        $searchQuery = '';
        if ($searchValue !== '') {
            $esc = $this->db->escape_like_str($searchValue);
            $searchQuery = " AND (
                `audit_log`.`username` LIKE '%{$esc}%' ESCAPE '!'
                OR `audit_log`.`action` LIKE '%{$esc}%' ESCAPE '!'
                OR `audit_log`.`module` LIKE '%{$esc}%' ESCAPE '!'
                OR `audit_log`.`table_name` LIKE '%{$esc}%' ESCAPE '!'
                OR `audit_log`.`description` LIKE '%{$esc}%' ESCAPE '!'
                OR `audit_log`.`ip_address` LIKE '%{$esc}%' ESCAPE '!'
                OR `audit_log`.`record_id` LIKE '%{$esc}%' ESCAPE '!'
                OR `audit_log`.`url` LIKE '%{$esc}%' ESCAPE '!'
                OR CAST(`audit_log`.`user_id` AS CHAR) LIKE '%{$esc}%' ESCAPE '!'
            )";
        }

        $baseFrom = " FROM `audit_log`
            LEFT JOIN `branch` ON `branch`.`id` = `audit_log`.`branch_id`
            WHERE 1=1 {$scopeWhere}{$branchWhere}";

        $totalRecords = (int) $this->db->query("SELECT COUNT(*) AS c {$baseFrom}")->row()->c;
        $totalFiltered = (int) $this->db->query("SELECT COUNT(*) AS c {$baseFrom}{$searchQuery}")->row()->c;

        $sql = "SELECT `audit_log`.*, IFNULL(`branch`.`name`, '-') AS `branch_name`
            {$baseFrom}{$searchQuery}
            ORDER BY {$column_order[$columnIndex]} {$columnSortOrder}
            LIMIT " . (int) $start . ', ' . (int) $rowperpage;

        $records = $this->db->query($sql)->result();
        $data = array();
        $count = $start + 1;
        foreach ($records as $record) {
            $row = array();
            $row[] = $count++;
            if (is_multi_school()) {
                $row[] = html_escape($record->branch_name);
            }
            $userLabel = $record->username ? $record->username : ($record->user_id ? ('User #' . $record->user_id) : '—');
            $row[] = html_escape($userLabel);
            $row[] = $record->role_id ? html_escape(get_type_name_by_id('roles', $record->role_id)) : '—';
            $row[] = '<span class="label label-primary">' . html_escape($record->action) . '</span>';
            $module = $record->module ?: $record->table_name;
            if ($record->record_id) {
                $module .= ' #' . $record->record_id;
            }
            $row[] = html_escape($module ?: '—');
            $row[] = html_escape($record->description ?: '—');
            $row[] = html_escape($record->ip_address ?: '—');
            $row[] = html_escape($record->created_at);
            $row[] = '<a href="' . base_url('audit_trail/view/' . (int) $record->id) . '" class="btn btn-default btn-circle btn-xs" title="View"><i class="fas fa-eye"></i></a>';
            $data[] = $row;
        }

        $response = array(
            'draw' => $draw,
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalFiltered,
            'data' => $data,
        );
        return json_encode($response);
    }

    protected function scopeWhereSql($scope)
    {
        $scope = strtolower((string) $scope);
        if ($scope === 'security') {
            return " AND `audit_log`.`action` IN ('LOGIN','LOGOUT','LOGIN_FAILED','LOGIN_DENIED','APPROVE','REJECT','CLEAR')";
        }
        if ($scope === 'changes') {
            return " AND `audit_log`.`action` IN ('INSERT','UPDATE','DELETE','REPLACE')";
        }
        return '';
    }
}
