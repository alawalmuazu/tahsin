<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Keeps each child's installed app on its own address and session cookie.
 * config.php is not deployed, so this has to live here.
 */
class MY_Config extends CI_Config
{
	public function __construct()
	{
		parent::__construct();

		$root = $this->item('root_url');
		if (!$root) {
			$root = $this->item('base_url');
		}
		$root = rtrim((string) $root, '/') . '/';
		$this->set_item('root_url', $root);

		if (!defined('TAHSIN_DESK') || TAHSIN_DESK === '') {
			return;
		}

		$desk = $root . 's/' . TAHSIN_DESK . '/';
		$this->set_item('base_url', $desk);
		$path = parse_url($desk, PHP_URL_PATH);
		if ($path === null || $path === '') {
			$path = '/';
		}
		$this->set_item('cookie_path', $path);
		$this->set_item('sess_cookie_name', 'ci_s_' . substr(hash('sha256', TAHSIN_DESK), 0, 16));
	}
}
