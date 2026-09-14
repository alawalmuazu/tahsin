<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

// return translation
function translate($word = '')
{
    $CI = &get_instance();
    if ($CI->session->has_userdata('set_lang')) {
        $set_lang = $CI->session->userdata('set_lang');
    } else {
        $set_lang = get_global_setting('translation');
    }

    if ($set_lang == '') {
        $set_lang = 'english';
    }

    $sql = "SELECT `english`,`" . $set_lang . "` FROM `languages` WHERE `word` = '$word'";
    $query = $CI->db->query($sql);
    if ($query->num_rows() > 0) {
        if (isset($query->row()->$set_lang) && $query->row()->$set_lang != '') {
            return $query->row()->$set_lang;
        } else {
            return $query->row()->english;
        }
    } else {
        $arrayData = array(
            'word' => $word,
            'english' => ucwords(str_replace('_', ' ', $word)),
        );
        $CI->db->insert('languages', $arrayData);
        return ucwords(str_replace('_', ' ', $word));
    }
}

function moduleIsEnabled($prefix)
{
    $ci = &get_instance();
    $role_id = $ci->session->userdata('loggedin_role_id');
    $branchID = $ci->session->userdata('loggedin_branch');
    if ($role_id == 1) {
        // For superadmin: if module is disabled for ALL branches, hide it
        $sql = "SELECT pm.id FROM `permission_modules` pm WHERE pm.`prefix` = " . $ci->db->escape($prefix) . " AND pm.`in_module` = 1";
        $pm = $ci->db->query($sql)->row();
        if (!empty($pm)) {
            // Check if it's disabled for every branch
            $total_branches = $ci->db->count_all('branch');
            if ($total_branches > 0) {
                $disabled_count = $ci->db->where(array('modules_id' => $pm->id, 'isEnabled' => 0))->count_all_results('modules_manage');
                if ($disabled_count >= $total_branches) {
                    return 0;
                }
            }
        }
        return 1;
    }
    $sql = "SELECT IF(`oaf`.`isEnabled` is NULL, 1, `oaf`.`isEnabled`) as `status` FROM `permission_modules` LEFT JOIN `modules_manage` as `oaf` ON `oaf`.`modules_id` = `permission_modules`.`id` AND `oaf`.`branch_id` = " . $ci->db->escape($branchID) . " WHERE `permission_modules`.`prefix` = " . $ci->db->escape($prefix);
    $result = $ci->db->query($sql)->row();
    if (empty($result)) {
        return 1;
    } else {
        return $result->status;
    }
}

function checkSaasLimit($prefix)
{
    $ci = &get_instance();
    $role_id = $ci->session->userdata('loggedin_role_id');
    $branchID = $ci->session->userdata('loggedin_branch');
    if ($role_id == 1) {
        return 1;
    }

    $ci = &get_instance();
    $sql = "SELECT `sb`.`expire_date`, `sb`.`school_id`, `student_limit`, `staff_limit`, `teacher_limit`, `parents_limit` FROM `branch` as `b` LEFT JOIN `saas_subscriptions` AS `sb` ON `sb`.`school_id` = `b`.`id` LEFT JOIN `saas_package` as `sp` ON `sp`.`id` = `sb`.`package_id` WHERE `sb`.`school_id` = " . $ci->db->escape($branchID);
    $row = $ci->db->query($sql)->row();
    if (empty($row)) {
        return 1;
    }

    if ($prefix == 'student') {
        $ci->db->where('branch_id', $branchID);
        $ci->db->group_by('student_id');
        $total_student = $ci->db->count_all_results('enroll');
        if ($total_student > $row->student_limit) {
            return 0;
        } else {
            return 1;
        }
    }

    if ($prefix == 'staff' || $prefix == 'teacher') {
        $ci->db->select('IFNULL(COUNT(staff.id), 0) as snumber');
        $ci->db->from('staff');
        $ci->db->join('login_credential', 'login_credential.user_id = staff.id', 'inner');
        if ($prefix == 'teacher') {
            $ci->db->where('login_credential.role', 3);
        } else {
            $ci->db->where_not_in('login_credential.role', array(1, 3, 6, 7));
        }
        $ci->db->where('staff.branch_id', $branchID);
        $total_staff = $ci->db->get()->row()->snumber;

        if ($prefix == 'teacher') {
            $limit = $row->teacher_limit;
        } else {
            $limit = $row->staff_limit;
        }
        if ($total_staff > $limit) {
            return 0;
        } else {
            return 1;
        }
    }

    if ($prefix == 'parent') {
        $ci->db->where('branch_id', $branchID);
        $total_parents = $ci->db->count_all_results('parent');
        if ($total_parents > $row->parents_limit) {
            return 0;
        } else {
            return 1;
        }
    }
}

function isEnabledSubscription($schoolID = '')
{
    $ci = &get_instance();
    $row = $ci->db->select('id')->where('school_id', $schoolID)->get('saas_subscriptions')->row();
    if (empty($row)) {
        return false;
    } else {
        return true;
    }
}

function get_permission($permission, $can = '')
{
    $ci = &get_instance();
    $role_id = $ci->session->userdata('loggedin_role_id');
    if ($role_id == 1) {
        return true;
    }
    $permissions = get_staff_permissions($role_id);
    foreach ($permissions as $permObject) {
        if ($permObject->permission_prefix == $permission && $permObject->$can == '1') {
            return true;
        }
    }
    return false;
}

function get_staff_permissions($id)
{
    $ci = &get_instance();
    $sql = "SELECT `staff_privileges`.*, `permission`.`id` as `permission_id`, `permission`.`prefix` as `permission_prefix` FROM `staff_privileges` JOIN `permission` ON `permission`.`id`=`staff_privileges`.`permission_id` WHERE `staff_privileges`.`role_id` = " . $ci->db->escape($id);
    $result = $ci->db->query($sql)->result();
    return $result;
}

function get_session_id()
{
    $CI = &get_instance();
    if ($CI->session->has_userdata('set_session_id')) {
        $session_id = $CI->session->userdata('set_session_id');
    } else {
        $session_id = get_global_setting('session_id');
    }
    return $session_id;
}

function is_secure($url)
{
    if ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) {
        $val = 'https://' . $url;
    } else {
        $val = 'http://' . $url;
    }
    return $val;
}

function get_global_setting($name = '')
{
    $CI = &get_instance();
    $name = trim($name);
    $CI->db->where('id', 1);
    $CI->db->select($name);
    $query = $CI->db->get('global_settings');

    if ($query->num_rows() > 0) {
        $row = $query->row();
        return $row->$name;
    }
}

// is superadmin logged in @return boolean
function is_superadmin_loggedin()
{
    $CI = &get_instance();
    if ($CI->session->userdata('loggedin_role_id') == 1) {
        return true;
    }
    return false;
}

/*
 * This build serves Tahsin Academy only. Views used to show a school picker to
 * whoever could work across schools; that UI is gated on this and never renders.
 */
function is_multi_school()
{
    return false;
}

/*
 * Forms no longer post a school picker, but many save endpoints still require
 * branch_id when the user is superadmin. Fill it so those saves succeed.
 */
function apply_single_school_post()
{
    if (is_multi_school() || empty($_POST)) {
        return;
    }
    if (!isset($_POST['branch_id']) || $_POST['branch_id'] === '' || $_POST['branch_id'] === 'all') {
        $_POST['branch_id'] = (string) SCHOOL_ID;
    }
}

function payment_method_dropdown($name, $selected = '', $extra = '')
{
    $CI = &get_instance();
    $groups = $CI->app_lib->getEnabledPaymentTypesGrouped();
    $selected = (string) $selected;
    $html = '<select name="' . htmlspecialchars($name, ENT_QUOTES, 'UTF-8') . '" ' . $extra . '>';
    $html .= '<option value="">' . htmlspecialchars(translate('select'), ENT_QUOTES, 'UTF-8') . '</option>';
    foreach ($groups as $group => $options) {
        if (empty($options)) {
            continue;
        }
        $html .= '<optgroup label="' . htmlspecialchars($group, ENT_QUOTES, 'UTF-8') . '">';
        foreach ($options as $id => $label) {
            $sel = ((string) $id === $selected) ? ' selected="selected"' : '';
            $html .= '<option value="' . (int) $id . '"' . $sel . '>' . htmlspecialchars($label, ENT_QUOTES, 'UTF-8') . '</option>';
        }
        $html .= '</optgroup>';
    }
    $html .= '</select>';
    return $html;
}

function collection_account_hint()
{
    $CI = &get_instance();
    $label = $CI->app_lib->collectionAccountLabel();
    if ($label === '') {
        return 'Set the Office Accounting account for offline collections in School Settings → Payment Settings.';
    }
    return 'Offline collections (bank transfer, cash, POS, cheque) are posted to <strong>' . htmlspecialchars($label, ENT_QUOTES, 'UTF-8') . '</strong>.';
}

// is admin logged in @return boolean
function is_admin_loggedin()
{
    $CI = &get_instance();
    if ($CI->session->userdata('loggedin_role_id') == 2) {
        return true;
    }
    return false;
}

// is teacher logged in @return boolean
function is_teacher_loggedin()
{
    $CI = &get_instance();
    if ($CI->session->userdata('loggedin_role_id') == 3) {
        return true;
    }
    return false;
}

// is accountant logged in @return boolean
function is_accountant_loggedin()
{
    $CI = &get_instance();
    if ($CI->session->userdata('loggedin_role_id') == 4) {
        return true;
    }
    return false;
}

// is librarian logged in @return boolean
function is_librarian_loggedin()
{
    $CI = &get_instance();
    if ($CI->session->userdata('loggedin_role_id') == 5) {
        return true;
    }
    return false;
}

// is parent logged in @return boolean
function is_parent_loggedin()
{
    $CI = &get_instance();
    if ($CI->session->userdata('loggedin_role_id') == 6) {
        return true;
    }
    return false;
}

// is parent logged in @return boolean
function is_student_loggedin()
{
    $CI = &get_instance();
    if ($CI->session->userdata('loggedin_role_id') == 7) {
        return true;
    }
    return false;
}

function is_force_password_change()
{
    $CI = &get_instance();
    return (int) $CI->session->userdata('force_password_change') === 1;
}

// get logged in user id - login credential DB id
function get_loggedin_id()
{
    $ci = &get_instance();
    return $ci->session->userdata('loggedin_id');
}

// get staff db id
function get_loggedin_user_id()
{
    $ci = &get_instance();
    return $ci->session->userdata('loggedin_userid');
}

// get session loggedin
function is_loggedin()
{
    $CI = &get_instance();
    if ($CI->session->has_userdata('loggedin')) {
        return true;
    }
    return false;
}

// get loggedin role name
function loggedin_role_name()
{
    $CI = &get_instance();
    $roleID = $CI->session->userdata('loggedin_role_id');
    return $CI->db->select('name')->where('id', $roleID)->get('roles')->row()->name;
}

function loggedin_role_id()
{
    $ci = &get_instance();
    return $ci->session->userdata('loggedin_role_id');
}

// get logged in user type
function get_loggedin_user_type()
{
    $CI = &get_instance();
    return $CI->session->userdata('loggedin_type');
}

// this build serves a single school, so the branch key is always the same
function get_loggedin_branch_id()
{
    return SCHOOL_ID;
}

// the school name shown wherever a branch used to be named
function school_name()
{
    $CI = &get_instance();
    $name = $CI->db->select('school_name')->where('id', SCHOOL_ID)->get('branch')->row();
    return (!empty($name) && !empty($name->school_name)) ? $name->school_name : SCHOOL_NAME;
}

// get parent selected active children Id
function get_activeChildren_id()
{
    $CI = &get_instance();
    return $CI->session->userdata('myChildren_id');
}

// get table name by type and id
function get_type_name_by_id($table, $type_id = '', $field = 'name')
{
    $CI = &get_instance();
    $get = $CI->db->select($field)->from($table)->where('id', $type_id)->limit(1)->get()->row_array();
    return isset($get[$field]) ? $get[$field] : '';
}

// set session alert / flashdata
function set_alert($type, $message)
{
    $CI = &get_instance();
    $CI->session->set_flashdata('alert-message-' . $type, $message);
}

// generate md5 hash
function app_generate_hash()
{
    return md5(rand() . microtime() . time() . uniqid());
}

// generate encryption key
function generate_encryption_key()
{
    $CI = &get_instance();
    // In case accessed from my_functions_helper.php
    $CI->load->library('encryption');
    $key = bin2hex($CI->encryption->create_key(16));
    return $key;
}

// generate get image url
function get_image_url($role = '', $file_name = '')
{
    if ($file_name == 'defualt.png' || empty($file_name)) {
        $image_url = base_url('uploads/app_image/defualt.png');
    } else {
        if (file_exists('uploads/images/' . $role . '/' . $file_name)) {
            $image_url = base_url('uploads/images/' . $role . '/' . $file_name);
        } else {
            $image_url = base_url('uploads/app_image/defualt.png');
        }
    }
    return $image_url;
}

// get date format config
function _d($date)
{
    if ($date == '' || is_null($date) || $date == '0000-00-00') {
        return '';
    }
    $formats = 'Y-m-d';
    $get_format = get_global_setting('date_format');
    if ($get_format != '') {
        $formats = $get_format;
    }
    return date($formats, strtotime($date));
}

// delete url
function btn_delete($uri)
{
    return "<button type='button' class='btn btn-danger icon btn-circle' onclick=confirm_modal('" . base_url($uri) . "') ><i class='fas fa-trash-alt'></i></button>";
}

// delete url
function csrf_jquery_token()
{
    $csrf = [get_instance()->security->get_csrf_token_name() => get_instance()->security->get_csrf_hash()];
    return $csrf;
}

function check_hash_restrictions($table, $id, $hash)
{
    $CI = &get_instance();
    if (!$table || !$id || !$hash) {
        show_404();
    }

    $query = $CI->db->select('hash')->from($table)->where('id', $id)->get();
    if ($query->num_rows() > 0) {
        $get_hash = $query->row()->hash;
    } else {
        $get_hash = '';
    }
    if (empty($hash) || ($get_hash != $hash)) {
        show_404();
    }
}

function get_nicetime($date)
{
    $get_format = get_global_setting('date_format');
    if (empty($date)) {
        return "Unknown";
    }
    // Current time as MySQL DATETIME value
    $csqltime = date('Y-m-d H:i:s');
    // Current time as Unix timestamp
    $ptime = strtotime($date);
    $ctime = strtotime($csqltime);

    //Now calc the difference between the two
    $timeDiff = floor(abs($ctime - $ptime) / 60);

    //Now we need find out whether or not the time difference needs to be in
    //minutes, hours, or days
    if ($timeDiff < 2) {
        $timeDiff = "Just now";
    } elseif ($timeDiff > 2 && $timeDiff < 60) {
        $timeDiff = floor(abs($timeDiff)) . " minutes ago";
    } elseif ($timeDiff > 60 && $timeDiff < 120) {
        $timeDiff = floor(abs($timeDiff / 60)) . " hour ago";
    } elseif ($timeDiff < 1440) {
        $timeDiff = floor(abs($timeDiff / 60)) . " hours ago";
    } elseif ($timeDiff > 1440 && $timeDiff < 2880) {
        $timeDiff = floor(abs($timeDiff / 1440)) . " day ago";
    } elseif ($timeDiff > 2880) {
        $timeDiff = date($get_format, $ptime);
    }
    return $timeDiff;
}

function bytesToSize($path, $filesize = '')
{
    if (!is_numeric($filesize)) {
        $bytes = sprintf('%u', filesize($path));
    } else {
        $bytes = $filesize;
    }
    if ($bytes > 0) {
        $unit = intval(log($bytes, 1024));
        $units = [
            'B',
            'KB',
            'MB',
            'GB',
        ];
        if (array_key_exists($unit, $units) === true) {
            return sprintf('%d %s', $bytes / pow(1024, $unit), $units[$unit]);
        }
    }
    return $bytes;
}

function array_to_object($array)
{
    if (!is_array($array) && !is_object($array)) {
        return new stdClass();
    }
    return json_decode(json_encode((object) $array));
}

function access_denied()
{
    set_alert('error', translate('access_denied'));
    redirect(site_url('dashboard'));
}

function ajax_access_denied()
{
    set_alert('error', translate('access_denied'));
    $array = array('status' => 'access_denied');
    echo json_encode($array);
    exit();
}

function slugify($text)
{
    // replace non letter or digits by -
    $text = preg_replace('~[^\pL\d]+~u', '_', $text);

    // transliterate
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

    // remove unwanted characters
    $text = preg_replace('~[^-\w]+~', '', $text);

    // trim
    $text = trim($text, '_');

    // remove duplicated - symbols
    $text = preg_replace('~-+~', '_', $text);

    // lowercase
    $text = strtolower($text);
    return $text;
}

// website menu list
function web_menu_list($publish = '', $default = '', $branchID = '')
{
    $CI = &get_instance();
    if (empty($branchID)) {
        $branchID = $CI->home_model->getDefaultBranch();
    }
    $CI->db->select('*,if(front_cms_menu_visible.name is null, front_cms_menu.title, front_cms_menu_visible.name) as title, front_cms_menu_visible.invisible');
    $CI->db->from('front_cms_menu');
    $CI->db->join('front_cms_menu_visible', 'front_cms_menu_visible.menu_id = front_cms_menu.id and front_cms_menu_visible.branch_id = ' . $branchID, 'left');
    if ($publish != '') {
        $CI->db->where('front_cms_menu.publish', $publish);
    }
    if ($default != '') {
        $CI->db->where('front_cms_menu.system', $default);
    }
    $CI->db->order_by('front_cms_menu.ordering', 'asc');
    $CI->db->where_in('front_cms_menu.branch_id', array(0, $branchID));
    $result = $CI->db->get()->result_array();
    return $result;
}

function get_request_url()
{
    $url = $_SERVER['QUERY_STRING'];
    $url = (!empty($url) ? '?' . $url : '');
    return $url;
}

function delete_dir($dirPath)
{
    if (!is_dir($dirPath)) {
        throw new InvalidArgumentException("$dirPath must be a directory");
    }
    if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
        $dirPath .= '/';
    }
    $files = glob($dirPath . '*', GLOB_MARK);
    foreach ($files as $file) {
        if (is_dir($file)) {
            delete_dir($file);
        } else {
            unlink($file);
        }
    }
    if (rmdir($dirPath)) {
        return true;
    }
    return false;
}

function currencyFormat($amount = 0)
{
    $CI = &get_instance();
    $array              = $CI->data['global_config'];
    $currency           = $array['currency'];
    $currency_symbol    = $array['currency_symbol'];
    $currency_formats   = $array['currency_formats'];
    $symbol_position    = $array['symbol_position'];

    $amount = empty($amount) ? 0 : $amount;
    $value = $amount;
    if ($currency_formats == 1) {
        $value = number_format($amount, 2, '.', '');
    } elseif ($currency_formats == 2) {
        $value = moneyFormatIndia($amount);
    } elseif ($currency_formats == 3) {
        $value = number_format($amount, 3, '.', ',');
    } elseif ($currency_formats == 4) {
        $value = number_format($amount, 2, ',', '.');
    } elseif ($currency_formats == 5) {
        $value = number_format($amount, 2, '.', ',');
    } elseif ($currency_formats == 6) {
        $value = number_format($amount, 2, ',', ' ');
    } elseif ($currency_formats == 7) {
        $value = number_format($amount, 2, '.', ' ');
    } elseif ($currency_formats == 8) {
        $value = $amount;
    }

    if ($symbol_position == 1) {
        $value = $currency_symbol . $value; 
    } elseif ($symbol_position == 2) {
        $value = $value . $currency_symbol;
    } elseif ($symbol_position == 3) {
        $value = $currency_symbol . " " . $value;
    } elseif ($symbol_position == 4) {
        $value = $value . " " . $currency_symbol;
    } elseif ($symbol_position == 5) {
        $value = $currency . " " . $value;
    } elseif ($symbol_position == 6) {
        $value = $value . " " . $currency;
    }
    return $value;
}

function moneyFormatIndia($num)
{
    $explrestunits = "" ;
    $num = preg_replace('/,+/', '', $num);
    $words = explode(".", $num);
    $des = "00";
    if(count($words)<=2){
        $num=$words[0];
        if(count($words)>=2){$des=$words[1];}
        if(strlen($des)<2){$des="$des";}else{$des=substr($des,0,2);}
    }
    if(strlen($num)>3){
        $lastthree = substr($num, strlen($num)-3, strlen($num));
        $restunits = substr($num, 0, strlen($num)-3); // extracts the last three digits
        $restunits = (strlen($restunits)%2 == 1)?"0".$restunits:$restunits; // explodes the remaining digits in 2's formats, adds a zero in the beginning to maintain the 2's grouping.
        $expunit = str_split($restunits, 2);
        for($i=0; $i<sizeof($expunit); $i++){
            // creates each of the 2's group and adds a comma to the end
            if($i==0)
            {
                $explrestunits .= (int)$expunit[$i].","; // if is first value , convert into integer
            }else{
                $explrestunits .= $expunit[$i].",";
            }
        }
        $thecash = $explrestunits.$lastthree;
    } else {
        $thecash = $num;
    }
    return "$thecash.$des"; // writes the final format where $currency is the currency symbol.
}

function getEnrollToStudentID($enroll_id = '')
{
    $CI = &get_instance();
    $get = $CI->db->select('student_id')->from('enroll')->where('id', $enroll_id)->limit(1)->get()->row()->student_id;
    return $get;
}

function version_combine()
{
    return md5(APP_VERSION); 
}

function img_reload()
{
    return "?src=" . time();
}

function local_image_path($role = '', $file_name = '')
{
    $fallback = FCPATH . 'uploads/app_image/defualt.png';
    if ($file_name == 'defualt.png' || empty($file_name)) {
        return $fallback;
    }
    $path = FCPATH . 'uploads/images/' . $role . '/' . $file_name;
    return file_exists($path) ? $path : $fallback;
}

function html_barcode($code, $height = 42)
{
    $code = preg_replace('/[^A-Za-z0-9\-\.]/', '', (string) $code);
    if ($code === '') {
        return '';
    }
    if (!class_exists('\Mpdf\Barcode')) {
        require_once APPPATH . 'third_party/mpdf/autoload.php';
    }
    try {
        $barcode = new \Mpdf\Barcode();
        $data = $barcode->getBarcodeArray($code, 'C128B');
    } catch (Exception $e) {
        return '';
    }
    if (empty($data['bcode'])) {
        return '';
    }
    $html = '<div class="barcode-wrap" style="font-size:0;line-height:0;white-space:nowrap;text-align:center">';
    foreach ($data['bcode'] as $bar) {
        $w = max(1, (int) $bar['w']);
        $bg = !empty($bar['t']) ? '#111111' : 'transparent';
        $html .= '<span style="display:inline-block;width:' . $w . 'px;height:' . (int) $height . 'px;background:' . $bg . '"></span>';
    }
    $html .= '</div>';
    return $html;
}

function student_fullname($student)
{
    if (is_object($student)) {
        $student = (array) $student;
    }
    if (!is_array($student)) {
        return '';
    }
    $parts = array(
        trim((string) (isset($student['first_name']) ? $student['first_name'] : '')),
        trim((string) (isset($student['other_name']) ? $student['other_name'] : '')),
        trim((string) (isset($student['last_name']) ? $student['last_name'] : '')),
    );
    $parts = array_filter($parts, function ($part) {
        return $part !== '';
    });
    return trim(preg_replace('/\s+/', ' ', implode(' ', $parts)));
}

function nigeria_religions($include_blank = true)
{
    $list = array(
        'Islam' => 'Islam',
        'Christianity' => 'Christianity',
        'Traditional' => 'Traditional',
        'Other' => 'Other',
    );
    if ($include_blank) {
        return array('' => translate('select')) + $list;
    }
    return $list;
}

function nigeria_states($include_blank = true)
{
    $states = array(
        'Abia', 'Adamawa', 'Akwa Ibom', 'Anambra', 'Bauchi', 'Bayelsa', 'Benue', 'Borno',
        'Cross River', 'Delta', 'Ebonyi', 'Edo', 'Ekiti', 'Enugu', 'FCT Abuja', 'Gombe',
        'Imo', 'Jigawa', 'Kaduna', 'Kano', 'Katsina', 'Kebbi', 'Kogi', 'Kwara', 'Lagos',
        'Nasarawa', 'Niger', 'Ogun', 'Ondo', 'Osun', 'Oyo', 'Plateau', 'Rivers', 'Sokoto',
        'Taraba', 'Yobe', 'Zamfara',
    );
    $list = array();
    foreach ($states as $state) {
        $list[$state] = $state;
    }
    if ($include_blank) {
        return array('' => translate('select')) + $list;
    }
    return $list;
}

function nigeria_lgas()
{
    static $lgas = null;
    if ($lgas !== null) {
        return $lgas;
    }
    $lgas = array(
        'Abia' => array('Aba North', 'Aba South', 'Arochukwu', 'Bende', 'Ikwuano', 'Isiala Ngwa North', 'Isiala Ngwa South', 'Isuikwuato', 'Obi Ngwa', 'Ohafia', 'Osisioma Ngwa', 'Ugwunagbo', 'Ukwa East', 'Ukwa West', 'Umuahia North', 'Umuahia South', 'Umunneochi'),
        'Adamawa' => array('Demsa', 'Fufore', 'Ganye', 'Girei', 'Gombi', 'Guyuk', 'Hong', 'Jada', 'Lamurde', 'Madagali', 'Maiha', 'Mayo Belwa', 'Michika', 'Mubi North', 'Mubi South', 'Numan', 'Shelleng', 'Song', 'Toungo', 'Yola North', 'Yola South'),
        'Akwa Ibom' => array('Abak', 'Eastern Obolo', 'Eket', 'Esit Eket', 'Essien Udim', 'Etim Ekpo', 'Etinan', 'Ibeno', 'Ibesikpo Asutan', 'Ibiono-Ibom', 'Ika', 'Ikono', 'Ikot Abasi', 'Ikot Ekpene', 'Ini', 'Itu', 'Mbo', 'Mkpat-Enin', 'Nsit-Atai', 'Nsit-Ibom', 'Nsit-Ubium', 'Obot Akara', 'Okobo', 'Onna', 'Oron', 'Oruk Anam', 'Udung-Uko', 'Ukanafun', 'Uruan', 'Urue-Offong/Oruko', 'Uyo'),
        'Anambra' => array('Aguata', 'Anambra East', 'Anambra West', 'Anaocha', 'Awka North', 'Awka South', 'Ayamelum', 'Dunukofia', 'Ekwusigo', 'Idemili North', 'Idemili South', 'Ihiala', 'Njikoka', 'Nnewi North', 'Nnewi South', 'Ogbaru', 'Onitsha North', 'Onitsha South', 'Orumba North', 'Orumba South', 'Oyi'),
        'Bauchi' => array('Alkaleri', 'Bauchi', 'Bogoro', 'Damban', 'Darazo', 'Dass', 'Gamawa', 'Ganjuwa', 'Giade', 'Itas/Gadau', "Jama'are", 'Katagum', 'Kirfi', 'Misau', 'Ningi', 'Shira', 'Tafawa Balewa', 'Toro', 'Warji', 'Zaki'),
        'Bayelsa' => array('Brass', 'Ekeremor', 'Kolokuma/Opokuma', 'Nembe', 'Ogbia', 'Sagbama', 'Southern Ijaw', 'Yenagoa'),
        'Benue' => array('Ado', 'Agatu', 'Apa', 'Buruku', 'Gboko', 'Guma', 'Gwer East', 'Gwer West', 'Katsina-Ala', 'Konshisha', 'Kwande', 'Logo', 'Makurdi', 'Obi', 'Ogbadibo', 'Ohimini', 'Oju', 'Okpokwu', 'Otukpo', 'Tarka', 'Ukum', 'Ushongo', 'Vandeikya'),
        'Borno' => array('Abadam', 'Askira/Uba', 'Bama', 'Bayo', 'Biu', 'Chibok', 'Damboa', 'Dikwa', 'Gubio', 'Guzamala', 'Gwoza', 'Hawul', 'Jere', 'Kaga', 'Kala/Balge', 'Konduga', 'Kukawa', 'Kwaya Kusar', 'Mafa', 'Magumeri', 'Maiduguri', 'Marte', 'Mobbar', 'Monguno', 'Ngala', 'Nganzai', 'Shani'),
        'Cross River' => array('Abi', 'Akamkpa', 'Akpabuyo', 'Bakassi', 'Bekwarra', 'Biase', 'Boki', 'Calabar Municipal', 'Calabar South', 'Etung', 'Ikom', 'Obanliku', 'Obubra', 'Obudu', 'Odukpani', 'Ogoja', 'Yakurr', 'Yala'),
        'Delta' => array('Aniocha North', 'Aniocha South', 'Bomadi', 'Burutu', 'Ethiope East', 'Ethiope West', 'Ika North East', 'Ika South', 'Isoko North', 'Isoko South', 'Ndokwa East', 'Ndokwa West', 'Okpe', 'Oshimili North', 'Oshimili South', 'Patani', 'Sapele', 'Udu', 'Ughelli North', 'Ughelli South', 'Ukwuani', 'Uvwie', 'Warri North', 'Warri South', 'Warri South West'),
        'Ebonyi' => array('Abakaliki', 'Afikpo North', 'Afikpo South', 'Ebonyi', 'Ezza North', 'Ezza South', 'Ikwo', 'Ishielu', 'Ivo', 'Izzi', 'Ohaozara', 'Ohaukwu', 'Onicha'),
        'Edo' => array('Akoko-Edo', 'Egor', 'Esan Central', 'Esan North-East', 'Esan South-East', 'Esan West', 'Etsako Central', 'Etsako East', 'Etsako West', 'Igueben', 'Ikpoba Okha', 'Oredo', 'Orhionmwon', 'Ovia North-East', 'Ovia South-West', 'Owan East', 'Owan West', 'Uhunmwonde'),
        'Ekiti' => array('Ado Ekiti', 'Efon', 'Ekiti East', 'Ekiti South-West', 'Ekiti West', 'Emure', 'Gbonyin', 'Ido Osi', 'Ijero', 'Ikere', 'Ikole', 'Ilejemeje', 'Irepodun/Ifelodun', 'Ise/Orun', 'Moba', 'Oye'),
        'Enugu' => array('Aninri', 'Awgu', 'Enugu East', 'Enugu North', 'Enugu South', 'Ezeagu', 'Igbo Etiti', 'Igbo Eze North', 'Igbo Eze South', 'Isi Uzo', 'Nkanu East', 'Nkanu West', 'Nsukka', 'Oji River', 'Udenu', 'Udi', 'Uzo Uwani'),
        'FCT Abuja' => array('Abaji', 'Abuja Municipal', 'Bwari', 'Gwagwalada', 'Kuje', 'Kwali'),
        'Gombe' => array('Akko', 'Balanga', 'Billiri', 'Dukku', 'Funakaye', 'Gombe', 'Kaltungo', 'Kwami', 'Nafada', 'Shongom', 'Yamaltu/Deba'),
        'Imo' => array('Aboh Mbaise', 'Ahiazu Mbaise', 'Ehime Mbano', 'Ezinihitte Mbaise', 'Ideato North', 'Ideato South', 'Ihitte/Uboma', 'Ikeduru', 'Isiala Mbano', 'Isu', 'Mbaitoli', 'Ngor Okpala', 'Njaba', 'Nkwerre', 'Nwangele', 'Obowo', 'Oguta', 'Ohaji/Egbema', 'Okigwe', 'Onuimo', 'Orlu', 'Orsu', 'Oru East', 'Oru West', 'Owerri Municipal', 'Owerri North', 'Owerri West'),
        'Jigawa' => array('Auyo', 'Babura', 'Biriniwa', 'Birnin Kudu', 'Buji', 'Dutse', 'Gagarawa', 'Garki', 'Gumel', 'Guri', 'Gwaram', 'Gwiwa', 'Hadejia', 'Jahun', 'Kafin Hausa', 'Kaugama', 'Kazaure', 'Kiri Kasama', 'Kiyawa', 'Maigatari', 'Malam Madori', 'Miga', 'Ringim', 'Roni', 'Sule Tankarkar', 'Taura', 'Yankwashi'),
        'Kaduna' => array('Birnin Gwari', 'Chikun', 'Giwa', 'Igabi', 'Ikara', 'Jaba', "Jema'a", 'Kachia', 'Kaduna North', 'Kaduna South', 'Kagarko', 'Kajuru', 'Kaura', 'Kauru', 'Kubau', 'Kudan', 'Lere', 'Makarfi', 'Sabon Gari', 'Sanga', 'Soba', 'Zangon Kataf', 'Zaria'),
        'Kano' => array('Ajingi', 'Albasu', 'Bagwai', 'Bebeji', 'Bichi', 'Bunkure', 'Dala', 'Dambatta', 'Dawakin Kudu', 'Dawakin Tofa', 'Doguwa', 'Fagge', 'Gabasawa', 'Garko', 'Garun Mallam', 'Gaya', 'Gezawa', 'Gwale', 'Gwarzo', 'Kabo', 'Kano Municipal', 'Karaye', 'Kibiya', 'Kiru', 'Kumbotso', 'Kunchi', 'Kura', 'Madobi', 'Makoda', 'Minjibir', 'Nasarawa', 'Rano', 'Rimin Gado', 'Rogo', 'Shanono', 'Sumaila', 'Takai', 'Tarauni', 'Tofa', 'Tsanyawa', 'Tudun Wada', 'Ungogo', 'Warawa', 'Wudil'),
        'Katsina' => array('Bakori', 'Batagarawa', 'Batsari', 'Baure', 'Bindawa', 'Charanchi', 'Dandume', 'Danja', 'Dan Musa', 'Daura', 'Dutsi', 'Dutsin Ma', 'Faskari', 'Funtua', 'Ingawa', 'Jibia', 'Kafur', 'Kaita', 'Kankara', 'Kankia', 'Katsina', 'Kurfi', 'Kusada', "Mai'Adua", 'Malumfashi', 'Mani', 'Mashi', 'Matazu', 'Musawa', 'Rimi', 'Sabuwa', 'Safana', 'Sandamu', 'Zango'),
        'Kebbi' => array('Aleiro', 'Arewa Dandi', 'Argungu', 'Augie', 'Bagudo', 'Birnin Kebbi', 'Bunza', 'Dandi', 'Fakai', 'Gwandu', 'Jega', 'Kalgo', 'Koko/Besse', 'Maiyama', 'Ngaski', 'Sakaba', 'Shanga', 'Suru', 'Wasagu/Danko', 'Yauri', 'Zuru'),
        'Kogi' => array('Adavi', 'Ajaokuta', 'Ankpa', 'Bassa', 'Dekina', 'Ibaji', 'Idah', 'Igalamela Odolu', 'Ijumu', 'Kabba/Bunu', 'Kogi', 'Lokoja', 'Mopa Muro', 'Ofu', 'Ogori/Magongo', 'Okehi', 'Okene', 'Olamaboro', 'Omala', 'Yagba East', 'Yagba West'),
        'Kwara' => array('Asa', 'Baruten', 'Edu', 'Ekiti', 'Ifelodun', 'Ilorin East', 'Ilorin South', 'Ilorin West', 'Irepodun', 'Isin', 'Kaiama', 'Moro', 'Offa', 'Oke Ero', 'Oyun', 'Pategi'),
        'Lagos' => array('Agege', 'Ajeromi-Ifelodun', 'Alimosho', 'Amuwo-Odofin', 'Apapa', 'Badagry', 'Epe', 'Eti Osa', 'Ibeju-Lekki', 'Ifako-Ijaiye', 'Ikeja', 'Ikorodu', 'Kosofe', 'Lagos Island', 'Lagos Mainland', 'Mushin', 'Ojo', 'Oshodi-Isolo', 'Shomolu', 'Surulere'),
        'Nasarawa' => array('Akwanga', 'Awe', 'Doma', 'Karu', 'Keana', 'Keffi', 'Kokona', 'Lafia', 'Nasarawa', 'Nasarawa Eggon', 'Obi', 'Toto', 'Wamba'),
        'Niger' => array('Agaie', 'Agwara', 'Bida', 'Borgu', 'Bosso', 'Chanchaga', 'Edati', 'Gbako', 'Gurara', 'Katcha', 'Kontagora', 'Lapai', 'Lavun', 'Magama', 'Mariga', 'Mashegu', 'Mokwa', 'Munya', 'Paikoro', 'Rafi', 'Rijau', 'Shiroro', 'Suleja', 'Tafa', 'Wushishi'),
        'Ogun' => array('Abeokuta North', 'Abeokuta South', 'Ado-Odo/Ota', 'Ewekoro', 'Ifo', 'Ijebu East', 'Ijebu North', 'Ijebu North East', 'Ijebu Ode', 'Ikenne', 'Imeko Afon', 'Ipokia', 'Obafemi Owode', 'Odeda', 'Odogbolu', 'Ogun Waterside', 'Remo North', 'Shagamu', 'Yewa North', 'Yewa South'),
        'Ondo' => array('Akoko North-East', 'Akoko North-West', 'Akoko South-East', 'Akoko South-West', 'Akure North', 'Akure South', 'Ese Odo', 'Idanre', 'Ifedore', 'Ilaje', 'Ile Oluji/Okeigbo', 'Irele', 'Odigbo', 'Okitipupa', 'Ondo East', 'Ondo West', 'Ose', 'Owo'),
        'Osun' => array('Atakunmosa East', 'Atakunmosa West', 'Aiyedaade', 'Aiyedire', 'Boluwaduro', 'Boripe', 'Ede North', 'Ede South', 'Egbedore', 'Ejigbo', 'Ife Central', 'Ife East', 'Ife North', 'Ife South', 'Ifedayo', 'Ifelodun', 'Ila', 'Ilesa East', 'Ilesa West', 'Irepodun', 'Irewole', 'Isokan', 'Iwo', 'Obokun', 'Odo Otin', 'Ola Oluwa', 'Olorunda', 'Oriade', 'Orolu', 'Osogbo'),
        'Oyo' => array('Afijio', 'Akinyele', 'Atiba', 'Atisbo', 'Egbeda', 'Ibadan North', 'Ibadan North-East', 'Ibadan North-West', 'Ibadan South-East', 'Ibadan South-West', 'Ibarapa Central', 'Ibarapa East', 'Ibarapa North', 'Ido', 'Irepo', 'Iseyin', 'Itesiwaju', 'Iwajowa', 'Kajola', 'Lagelu', 'Ogbomosho North', 'Ogbomosho South', 'Ogo Oluwa', 'Olorunsogo', 'Oluyole', 'Ona Ara', 'Orelope', 'Ori Ire', 'Oyo East', 'Oyo West', 'Saki East', 'Saki West', 'Surulere'),
        'Plateau' => array('Barkin Ladi', 'Bassa', 'Bokkos', 'Jos East', 'Jos North', 'Jos South', 'Kanam', 'Kanke', 'Langtang North', 'Langtang South', 'Mangu', 'Mikang', 'Pankshin', "Qua'an Pan", 'Riyom', 'Shendam', 'Wase'),
        'Rivers' => array('Abua/Odual', 'Ahoada East', 'Ahoada West', 'Akuku-Toru', 'Andoni', 'Asari-Toru', 'Bonny', 'Degema', 'Eleme', 'Emohua', 'Etche', 'Gokana', 'Ikwerre', 'Khana', 'Obio/Akpor', 'Ogba/Egbema/Ndoni', 'Ogu/Bolo', 'Okrika', 'Omuma', 'Opobo/Nkoro', 'Oyigbo', 'Port Harcourt', 'Tai'),
        'Sokoto' => array('Binji', 'Bodinga', 'Dange Shuni', 'Gada', 'Goronyo', 'Gudu', 'Gwadabawa', 'Illela', 'Isa', 'Kebbe', 'Kware', 'Rabah', 'Sabon Birni', 'Shagari', 'Silame', 'Sokoto North', 'Sokoto South', 'Tambuwal', 'Tangaza', 'Tureta', 'Wamakko', 'Wurno', 'Yabo'),
        'Taraba' => array('Ardo Kola', 'Bali', 'Donga', 'Gashaka', 'Gassol', 'Ibi', 'Jalingo', 'Karim Lamido', 'Kurmi', 'Lau', 'Sardauna', 'Takum', 'Ussa', 'Wukari', 'Yorro', 'Zing'),
        'Yobe' => array('Bade', 'Bursari', 'Damaturu', 'Fika', 'Fune', 'Geidam', 'Gujba', 'Gulani', 'Jakusko', 'Karasuwa', 'Machina', 'Nangere', 'Nguru', 'Potiskum', 'Tarmuwa', 'Yunusari', 'Yusufari'),
        'Zamfara' => array('Anka', 'Bakura', 'Birnin Magaji/Kiyaw', 'Bukkuyum', 'Bungudu', 'Gummi', 'Gusau', 'Kaura Namoda', 'Maradun', 'Maru', 'Shinkafi', 'Talata Mafara', 'Tsafe', 'Zurmi'),
    );
    return $lgas;
}

function nigeria_lgas_for_state($state = '', $include_blank = true)
{
    $all = nigeria_lgas();
    $list = array();
    if (!empty($state) && isset($all[$state])) {
        foreach ($all[$state] as $lga) {
            $list[$lga] = $lga;
        }
        if ($include_blank) {
            return array('' => translate('select')) + $list;
        }
        return $list;
    }
    return $include_blank ? array('' => 'Select State First') : array();
}