<?php
defined('BASEPATH') or exit('No direct script access allowed');

class School_fee_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function tableReady()
    {
        return $this->db->table_exists('school_fee_settings');
    }

    public function hasPwdDimension()
    {
        return $this->tableReady() && $this->db->field_exists('pwd_category_id', 'school_fee_settings');
    }

    public function defaultFallback()
    {
        return defined('SCHOOL_FEE_AMOUNT') ? (float) SCHOOL_FEE_AMOUNT : 2500000.0;
    }

    /**
     * Resolve fee by Section × Programme Category × Student Category (PWD).
     * category_id = programme (With/Without Technical Skills).
     * pwd_category_id = Physically Fit / ALL / impairments.
     */
    public function resolveAmount($branch_id, $section_id = 0, $category_id = 0, $pwd_category_id = 0)
    {
        $branch_id = (int) $branch_id;
        $section_id = (int) $section_id;
        $category_id = (int) $category_id;
        $pwd_category_id = (int) $pwd_category_id;

        if (!$this->tableReady() || $branch_id <= 0) {
            return $this->defaultFallback();
        }

        if ($this->hasPwdDimension()) {
            $candidates = array(
                array($section_id, $category_id, $pwd_category_id),
                array($section_id, $category_id, 0),
                array($section_id, 0, $pwd_category_id),
                array($section_id, 0, 0),
                array(0, 0, 0),
            );
            foreach ($candidates as $pair) {
                $row = $this->db->get_where('school_fee_settings', array(
                    'branch_id' => $branch_id,
                    'section_id' => $pair[0],
                    'category_id' => $pair[1],
                    'pwd_category_id' => $pair[2],
                ))->row();
                if ($row && (float) $row->amount > 0) {
                    return (float) $row->amount;
                }
            }
            return $this->defaultFallback();
        }

        // Legacy 2D (section × category only)
        $candidates = array(
            array($section_id, $category_id),
            array($section_id, 0),
            array(0, $category_id),
            array(0, 0),
        );
        foreach ($candidates as $pair) {
            $row = $this->db->get_where('school_fee_settings', array(
                'branch_id' => $branch_id,
                'section_id' => $pair[0],
                'category_id' => $pair[1],
            ))->row();
            if ($row && (float) $row->amount > 0) {
                return (float) $row->amount;
            }
        }
        return $this->defaultFallback();
    }

    /**
     * Map: [pwd_category_id][section_id][programme_category_id] => amount
     */
    public function getMap($branch_id)
    {
        $map = array();
        if (!$this->tableReady()) {
            return $map;
        }
        $rows = $this->db->where('branch_id', (int) $branch_id)->get('school_fee_settings')->result();
        foreach ($rows as $row) {
            $pwd = $this->hasPwdDimension() ? (int) $row->pwd_category_id : 0;
            $map[$pwd][(int) $row->section_id][(int) $row->category_id] = (float) $row->amount;
        }
        return $map;
    }

    public function getDefaultAmount($branch_id)
    {
        return $this->resolveAmount($branch_id, 0, 0, 0);
    }

    /**
     * $matrix[pwd_category_id][section_id][programme_category_id] = amount
     */
    public function saveMatrix($branch_id, $default_amount, $matrix)
    {
        $branch_id = (int) $branch_id;
        if (!$this->tableReady() || $branch_id <= 0) {
            return false;
        }

        $this->upsert($branch_id, 0, 0, 0, $default_amount);

        if (!is_array($matrix)) {
            return true;
        }
        foreach ($matrix as $pwd_id => $sections) {
            if (!is_array($sections)) {
                continue;
            }
            foreach ($sections as $section_id => $cats) {
                if (!is_array($cats)) {
                    continue;
                }
                foreach ($cats as $category_id => $amount) {
                    $section_id = (int) $section_id;
                    $category_id = (int) $category_id;
                    $pwd_id = (int) $pwd_id;
                    if ($section_id <= 0 || $category_id <= 0 || $pwd_id <= 0) {
                        continue;
                    }
                    $this->upsert($branch_id, $section_id, $category_id, $pwd_id, $amount);
                }
            }
        }
        return true;
    }

    protected function upsert($branch_id, $section_id, $category_id, $pwd_category_id, $amount)
    {
        $amount = (float) $amount;
        if ($amount < 0) {
            $amount = 0;
        }
        $where = array(
            'branch_id' => (int) $branch_id,
            'section_id' => (int) $section_id,
            'category_id' => (int) $category_id,
        );
        if ($this->hasPwdDimension()) {
            $where['pwd_category_id'] = (int) $pwd_category_id;
        }
        $existing = $this->db->get_where('school_fee_settings', $where)->row();
        if ($existing) {
            $this->db->where('id', $existing->id)->update('school_fee_settings', array('amount' => $amount));
            return;
        }
        $insert = $where;
        $insert['amount'] = $amount;
        if (!$this->hasPwdDimension()) {
            unset($insert['pwd_category_id']);
        }
        $this->db->insert('school_fee_settings', $insert);
    }
}
