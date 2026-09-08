<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @package : SmartSchool
 * @version : 5.0
 * @developed by : SmartSchool
 * @support : Jamilusalis@gmail.com
 * @author url : https://mjtech.com.ng
 * @filename : Errors.php
 * @copyright : Reserved SmartSchool Team
 */

class Errors extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->load->view('errors/error_404_message.php');
    }
}
