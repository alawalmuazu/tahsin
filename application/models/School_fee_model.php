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

    public function defaultFallback()
    {
        return defined('SCHOOL_FEE_AMOUNT') ? (float) SCHOOL_FEE_AMOUNT : 2500000.0;
    }

    /**
     * Resolve fee: exact → section+any → any+category → default (0,0) → constant.
     */
    public function resolveAmount($branch_id, $section_id = 0, $category_id = 0)
    {
        $branch_id = (int) $branch_id;
        $section_id = (int) $section_id;
        $category_id = (int) $category_id;

        if (!$this->tableReady() || $branch_id <= 0) {
            return $this->defaultFallback();
        }

        $candidates = array(
            array($section_id, $category_id),
            array($section_id, 0),
            array(0, $category_id),
            array(0, 0),
        );

        foreach ($candidates as $pair) {
            if ($pair[0] === 0 && $pair[1] === 0 && $section_id === 0 && $category_id === 0) {
                // still check default row once
            }
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

    public function getMap($branch_id)
    {
        $map = array();
        if (!$this->tableReady()) {
            return $map;
        }
        $rows = $this->db->where('branch_id', (int) $branch_id)->get('school_fee_settings')->result();
        foreach ($rows as $row) {
            $map[(int) $row->section_id][(int) $row->category_id] = (float) $row->amount;
        }
        return $map;
    }

    public function getDefaultAmount($branch_id)
    {
        return $this->resolveAmount($branch_id, 0, 0);
    }

    public function saveMatrix($branch_id, $default_amount, $matrix)
    {
        $branch_id = (int) $branch_id;
        if (!$this->tableReady() || $branch_id <= 0) {
            return false;
        }

        $this->upsert($branch_id, 0, 0, $default_amount);

        if (!is_array($matrix)) {
            return true;
        }
        foreach ($matrix as $section_id => $cats) {
            if (!is_array($cats)) {
                continue;
            }
            foreach ($cats as $category_id => $amount) {
                $section_id = (int) $section_id;
                $category_id = (int) $category_id;
                if ($section_id <= 0 || $category_id <= 0) {
                    continue;
                }
                $this->upsert($branch_id, $section_id, $category_id, $amount);
            }
        }
        return true;
    }

    protected function upsert($branch_id, $section_id, $category_id, $amount)
    {
        $amount = (float) $amount;
        if ($amount < 0) {
            $amount = 0;
        }
        $existing = $this->db->get_where('school_fee_settings', array(
            'branch_id' => (int) $branch_id,
            'section_id' => (int) $section_id,
            'category_id' => (int) $category_id,
        ))->row();
        if ($existing) {
            $this->db->where('id', $existing->id)->update('school_fee_settings', array('amount' => $amount));
        } else {
            $this->db->insert('school_fee_settings', array(
                'branch_id' => (int) $branch_id,
                'section_id' => (int) $section_id,
                'category_id' => (int) $category_id,
                'amount' => $amount,
            ));
        }
    }
}
