<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * @package : SmartSchool
 * @version : 7.0
 * @developed by : SmartSchool
 * @support : Jamilusalis@gmail.com
 * @author url : https://mjtech.com.ng
 * @filename : Education_board_model.php
 * @copyright : Reserved SmartSchool Team
 */

class Education_board_model extends MY_Model
{
    // Tables that support board-level shared items
    public static $board_tables = array(
        'class', 'section', 'subject', 'grade', 'exam_term',
        'fees_type', 'student_category', 'staff_department',
        'staff_designation', 'event_types', 'leave_category',
        'hostel_category', 'book_category', 'complaint_type'
    );

    public function __construct()
    {
        parent::__construct();
    }

    public function save($data, $id = null)
    {
        $array = array(
            'name' => $data['name'],
            'description' => isset($data['description']) ? $data['description'] : '',
        );

        if (empty($id)) {
            $array['created_at'] = date('Y-m-d H:i:s');
            $this->db->insert('education_board', $array);
            return $this->db->insert_id();
        } else {
            $array['updated_at'] = date('Y-m-d H:i:s');
            $this->db->where('id', $id);
            $this->db->update('education_board', $array);
            return $id;
        }
    }

    public function getAll()
    {
        $this->db->order_by('id', 'ASC');
        return $this->db->get('education_board')->result();
    }

    public function getById($id)
    {
        return $this->db->where('id', $id)->get('education_board')->row();
    }

    public function getBoardDropdown()
    {
        $result = $this->getAll();
        $array = array('' => translate('select'));
        foreach ($result as $row) {
            $array[$row->id] = $row->name;
        }
        return $array;
    }

    /**
     * Get items for a specific board from a lookup table
     */
    public function getBoardItems($board_id, $table)
    {
        $this->db->where('board_id', $board_id);
        $this->db->order_by('id', 'ASC');
        return $this->db->get($table)->result();
    }

    /**
     * Get hybrid items: board shared + branch custom
     */
    public function getHybridItems($table, $branch_id)
    {
        $board_id = $this->getBoardIdForBranch($branch_id);
        if (!empty($board_id)) {
            $this->db->group_start();
            $this->db->where('board_id', $board_id);
            $this->db->or_group_start();
            $this->db->where('branch_id', $branch_id);
            $this->db->where('board_id IS NULL', null, false);
            $this->db->group_end();
            $this->db->group_end();
        } else {
            $this->db->where('branch_id', $branch_id);
        }
        $this->db->order_by('id', 'ASC');
        return $this->db->get($table)->result();
    }

    /**
     * Get the board_id assigned to a branch
     */
    public function getBoardIdForBranch($branch_id)
    {
        $row = $this->db->select('board_id')->where('id', $branch_id)->get('branch')->row();
        return !empty($row) ? $row->board_id : null;
    }

    /**
     * Check if a table is board-enabled
     */
    public static function isBoardTable($table)
    {
        return in_array($table, self::$board_tables);
    }

    /**
     * Add an item to a board's lookup table
     */
    public function addBoardItem($board_id, $table, $data)
    {
        $data['board_id'] = $board_id;
        $data['branch_id'] = 0; // board items don't belong to a branch
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }

    /**
     * Delete a board item (only if it's a board item)
     */
    public function deleteBoardItem($board_id, $table, $item_id)
    {
        $this->db->where('id', $item_id);
        $this->db->where('board_id', $board_id);
        return $this->db->delete($table);
    }

    /**
     * Count branches using this board
     */
    public function countBranches($board_id)
    {
        return $this->db->where('board_id', $board_id)->count_all_results('branch');
    }
}
