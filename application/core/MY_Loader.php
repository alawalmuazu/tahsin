<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Load application/database/DB.php so MY_DB_* drivers are used.
 * system/ is gitignored, so we cannot rely on patching system/database/DB.php.
 */
class MY_Loader extends CI_Loader
{
	public function database($params = '', $return = FALSE, $query_builder = NULL)
	{
		$CI =& get_instance();

		if ($return === FALSE && $query_builder === NULL && isset($CI->db) && is_object($CI->db) && ! empty($CI->db->conn_id))
		{
			return FALSE;
		}

		require_once(APPPATH.'database/DB.php');

		if ($return === TRUE)
		{
			return DB($params, $query_builder);
		}

		$CI->db = '';
		$CI->db =& DB($params, $query_builder);
		return $this;
	}
}
