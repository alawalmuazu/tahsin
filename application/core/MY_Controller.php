<?php defined('BASEPATH') or exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        if ($this->config->item('installed') == false) {
            redirect(site_url('install'));
        }
        $get_config = $this->db->get_where('global_settings', array('id' => 1))->row_array();
        
        // cache control
        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        if ($get_config['cache_store'] == 0) {
            $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        } else {
            $this->output->set_header('Cache-Control: no-cache, must-revalidate, post-check=0, pre-check=0');
        }
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

        // checkout branch information
        $branchID = $this->application_model->get_branch_id();
        if (!empty($branchID)) {
            $branch = $this->db->select('currency_formats,symbol_position,symbol,currency,timezone')->where('id', $branchID)->get('branch')->row();
            $get_config['currency'] = $branch->currency;
            $get_config['currency_symbol'] = $branch->symbol;
            $get_config['currency_formats'] = $branch->currency_formats;
            $get_config['symbol_position'] = $branch->symbol_position;
            if (!empty($branch->timezone)) {
                $get_config['timezone'] = $branch->timezone;
            }
        }
        $get_config['institute_name'] = $this->brandName($get_config['institute_name'] ?? '');
        if (!empty($get_config['footer_text'])) {
            $get_config['footer_text'] = $this->rebrandText($get_config['footer_text']);
        }
        $this->data['global_config'] = $get_config;
        $this->data['theme_config'] = $this->db->get_where('theme_settings', array('id' => 1))->row_array();
        date_default_timezone_set($get_config['timezone']);
    }

    public function get_payment_config()
    {
        $branchID = $this->application_model->get_branch_id();
        $this->db->where('branch_id', $branchID);
        $this->db->select('*')->from('payment_config');
        return $this->db->get()->row_array();
    }

    public function getBranchDetails()
    {
        $branchID = $this->application_model->get_branch_id();
        $this->db->select('*');
        $this->db->where('id', $branchID);
        $this->db->from('branch');
        $r = $this->db->get()->row_array();
        if (empty($r)) {
            return ['stu_generate' => "", 'grd_generate' => ""];
        } else {
            return $r;
        }
    }

    public function photoHandleUpload($str, $fields)
    {
        $allowedExts = array_map('trim', array_map('strtolower', explode(',', $this->data['global_config']['image_extension'])));
        $allowedSizeKB = $this->data['global_config']['image_size'];
        $allowedSize = floatval(1024 * $allowedSizeKB);
        if (isset($_FILES["$fields"]) && !empty($_FILES["$fields"]['name'])) {
            $file_size = $_FILES["$fields"]["size"];
            $file_name = $_FILES["$fields"]["name"];
            $extension = pathinfo($file_name, PATHINFO_EXTENSION);
            if ($files = filesize($_FILES["$fields"]['tmp_name'])) {
                if (!in_array(strtolower($extension), $allowedExts)) {
                    $this->form_validation->set_message('photoHandleUpload', translate('this_file_type_is_not_allowed'));
                    return false;
                }
                if ($file_size > $allowedSize) {
                    $this->form_validation->set_message('photoHandleUpload', translate('file_size_shoud_be_less_than') . " $allowedSizeKB KB.");
                    return false;
                }
            } else {
                $this->form_validation->set_message('photoHandleUpload', translate('error_reading_the_file'));
                return false;
            }
            return true;
        }
        return true;
    }

    public function fileHandleUpload($str, $fields)
    {
        $allowedExts = array_map('trim', array_map('strtolower', explode(',', $this->data['global_config']['file_extension'])));
        $allowedSizeKB = $this->data['global_config']['file_size'];
        $allowedSize = floatval(1024 * $allowedSizeKB);
        if (isset($_FILES["$fields"]) && !empty($_FILES["$fields"]['name'])) {
            $file_size = $_FILES["$fields"]["size"];
            $file_name = $_FILES["$fields"]["name"];
            $extension = pathinfo($file_name, PATHINFO_EXTENSION);
            if ($files = filesize($_FILES["$fields"]['tmp_name'])) {
                if (!in_array(strtolower($extension), $allowedExts)) {
                    $this->form_validation->set_message('fileHandleUpload', translate('this_file_type_is_not_allowed'));
                    return false;
                }
                if ($file_size > $allowedSize) {
                    $this->form_validation->set_message('fileHandleUpload', translate('file_size_shoud_be_less_than') . " $allowedSizeKB KB.");
                    return false;
                }
            } else {
                $this->form_validation->set_message('fileHandleUpload', translate('error_reading_the_file'));
                return false;
            }
            return true;
        }
        return true;
    }

    protected function brandName($name = '')
    {
        $name = trim((string) $name);
        if ($name === '' || stripos($name, 'smartschool') !== false || stripos($name, 'smart school') !== false) {
            return 'Tahsin Academy';
        }
        return $this->rebrandText($name);
    }

    protected function rebrandText($text = '')
    {
        return str_ireplace(array('Smart School', 'SmartSchool'), 'Tahsin Academy', (string) $text);
    }
}

class Admin_Controller extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!is_loggedin()) {
            $this->session->set_userdata('redirect_url', current_url());
            redirect(base_url('authentication'), 'refresh');
        }
    }
}

class User_Controller extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!is_student_loggedin() && !is_parent_loggedin()) {
            $this->session->set_userdata('redirect_url', current_url());
            redirect(base_url('authentication'), 'refresh');
        }
    }
}

class Authentication_Controller extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('authentication_model');
    }
}

class Frontend_Controller extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('home_model');
        $branchID = $this->home_model->getDefaultBranch();
        $cms_setting = $this->db->get_where('front_cms_setting', array('branch_id' => $branchID))->row_array();

        // Default values for ALL front_cms_setting columns used by views
        $defaults = array(
            'id'                      => 0,
            'cms_active'              => 1,
            'branch_id'               => $branchID,
            'url_alias'               => '',
            'application_title'       => 'Tahsin Academy',
            'theme'                   => 'green',
            'fav_icon'                => '',
            'logo'                    => '',
            'google_analytics'        => '',
            'working_hours'           => '',
            'email'                   => '',
            'receive_contact_email'   => '',
            'mobile_no'               => '',
            'fax'                     => '',
            'address'                 => '',
            'menu_color'              => '#333',
            'online_admission'        => 0,
            'captcha_status'          => 'disable',
            'recaptcha_site_key'      => '',
            'recaptcha_secret_key'    => '',
            'footer_background_color' => '#383838',
            'footer_about_text'       => '',
            'footer_text_color'       => '#8d8d8d',
            'copyright_text'          => '© ' . date('Y') . ' Tahsin Academy',
            'copyright_bg_color'      => '#262626',
            'copyright_text_color'    => '#8d8d8d',
            'facebook_url'            => '',
            'twitter_url'             => '',
            'linkedin_url'            => '',
            'youtube_url'             => '',
            'google_plus'             => '',
            'instagram_url'           => '',
            'pinterest_url'           => '',
            'primary_color'           => '#1a6b3c',
            'hover_color'             => '#145a30',
            'text_color'              => '#232323',
            'text_secondary_color'    => '#8d8d8d',
            'border_radius'           => '5px',
        );

        // Ensure CMS is always treated as active for the state-level landing page
        // Merge defaults with DB data — DB values win only when non-null
        if (is_array($cms_setting)) {
            // Remove null values from DB row so defaults fill in
            $cms_setting = array_merge($defaults, array_filter($cms_setting, function($v) { return $v !== null; }));
        } else {
            $cms_setting = $defaults;
        }
        $cms_setting['cms_active'] = 1;
        $cms_setting['application_title'] = $this->brandName($cms_setting['application_title'] ?? '');
        if (!empty($cms_setting['copyright_text'])) {
            $cms_setting['copyright_text'] = $this->rebrandText($cms_setting['copyright_text']);
        }
        if (!empty($cms_setting['footer_about_text'])) {
            $cms_setting['footer_about_text'] = $this->rebrandText($cms_setting['footer_about_text']);
        }
        if (empty($cms_setting['logo']) || !file_exists(FCPATH . 'uploads/frontend/images/' . $cms_setting['logo'])) {
            $cms_setting['logo'] = 'tahsin-logo.png';
        }
        if (empty($cms_setting['fav_icon']) || !file_exists(FCPATH . 'uploads/frontend/images/' . $cms_setting['fav_icon'])) {
            $cms_setting['fav_icon'] = 'tahsin-logo.png';
        }

        $this->data['cms_setting'] = $cms_setting;
    }
}
