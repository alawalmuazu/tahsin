<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pwd_category_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function tableReady()
    {
        try {
            return $this->db->table_exists('pwd_category');
        } catch (Exception $e) {
            return false;
        } catch (Throwable $e) {
            return false;
        }
    }

    public function ensureCore($branch_id)
    {
        if (!$this->tableReady()) {
            return;
        }
        try {
            $core = array(
                array('Physically Fit', 1, 1),
                array('ALL', 0, 2),
                array('Visually Impaired (Blind)', 0, 3),
                array('Hearing Impaired (Deaf)', 0, 4),
            );
            foreach ($core as $item) {
                $exists = $this->db->where(array('branch_id' => (int) $branch_id, 'name' => $item[0]))->get('pwd_category')->row();
                if (!$exists) {
                    $this->db->insert('pwd_category', array(
                        'branch_id' => (int) $branch_id,
                        'name' => $item[0],
                        'is_default' => $item[1],
                        'sort_order' => $item[2],
                        'active' => 1,
                    ));
                }
            }
        } catch (Exception $e) {
            return;
        } catch (Throwable $e) {
            return;
        }
    }

    public function getList($branch_id, $activeOnly = true)
    {
        if (!$this->tableReady()) {
            return array();
        }
        try {
            $this->ensureCore($branch_id);
            $this->db->where('branch_id', (int) $branch_id);
            if ($activeOnly) {
                $this->db->where('active', 1);
            }
            $this->db->order_by('sort_order', 'ASC');
            $this->db->order_by('id', 'ASC');
            return $this->db->get('pwd_category')->result();
        } catch (Exception $e) {
            return array();
        } catch (Throwable $e) {
            return array();
        }
    }

    public function getDropdown($branch_id)
    {
        $list = array('' => translate('select'));
        foreach ($this->getList($branch_id, true) as $row) {
            $list[$row->id] = $row->name;
        }
        return $list;
    }

    public function getDefaultId($branch_id)
    {
        if (!$this->tableReady()) {
            return '';
        }
        try {
            $this->ensureCore($branch_id);
            $row = $this->db->where(array('branch_id' => (int) $branch_id, 'is_default' => 1, 'active' => 1))
                ->order_by('id', 'ASC')->get('pwd_category')->row();
            if ($row) {
                return (int) $row->id;
            }
            $any = $this->db->where(array('branch_id' => (int) $branch_id, 'active' => 1))
                ->order_by('sort_order', 'ASC')->get('pwd_category')->row();
            return $any ? (int) $any->id : '';
        } catch (Exception $e) {
            return '';
        } catch (Throwable $e) {
            return '';
        }
    }

    public function save($data)
    {
        $row = array(
            'branch_id' => (int) $data['branch_id'],
            'name' => trim($data['name']),
            'sort_order' => (int) $data['sort_order'],
            'active' => !empty($data['active']) ? 1 : 0,
            'is_default' => !empty($data['is_default']) ? 1 : 0,
        );
        if ($row['is_default']) {
            $this->db->where('branch_id', $row['branch_id'])->update('pwd_category', array('is_default' => 0));
        }
        if (!empty($data['id'])) {
            $this->db->where('id', (int) $data['id'])->update('pwd_category', $row);
            return (int) $data['id'];
        }
        $this->db->insert('pwd_category', $row);
        return (int) $this->db->insert_id();
    }

    public function delete($id, $branch_id)
    {
        $row = $this->db->where(array('id' => (int) $id, 'branch_id' => (int) $branch_id))->get('pwd_category')->row();
        if (!$row || (int) $row->is_default === 1) {
            return false;
        }
        $this->db->where('id', (int) $id)->delete('pwd_category');
        return true;
    }
}
