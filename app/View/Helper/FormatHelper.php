<?php

class FormatHelper extends AppHelper {

    public $helpers = array('PhpThumb');
    public $far = 1;

    function age($date = '') {
        if ($date == '') {
            return "";
        }
        #$date = "2013-05-05";
        //explode the date to get month, day and year
        $birthDate = explode("-", date("Y-m-d", strtotime($date)));
        //get age from date 
        $age = (date("md", date("U", mktime(0, 0, 0, $birthDate[2], $birthDate[1], $birthDate[0]))) > date("md") ? ((date("Y") - $birthDate[0]) - 1) : (date("Y") - $birthDate[0]));
        return $age . " yr" . ($age > 1 ? "s" : "");
    }

    function price($amount = '', $prefix = 'Rs.') {
        if (floatval($amount) > 0) {
            return "{$prefix} " . number_format($amount, 2, '.', ',');
        } else {
            return "{$prefix} 0.00";
        }
    }

    function validate_url($url = '') {
        if ($url == '')
            return 'javascript://';

        if (preg_match('#((https?|ftp)://(\S*?\.\S*?))([\s)\[\]{},;"\':<]|\.\s|$)#i', $url, $matches)) {
            return $url;
        } else {
            return "http://" . $url;
        }
        #pr($matches);
    }

    function format_24hr_to_12hr($time = '') {
        if ($time == '') {
            return '';
            $time = '09:00:00';
        }
        $out_time_arr = explode(":", $time);
        $out_mode = intval($out_time_arr[0]) < 12 ? 'AM' : 'PM';
        $out_hr = intval($out_time_arr[0]) > 12 ? intval($out_time_arr[0]) - 12 : intval($out_time_arr[0]);
        $out_min = intval($out_time_arr[1]);
        return ($out_hr > 0 ? ($out_min < 10 ? '0' : '') . $out_hr : 12) . ':' . ($out_min < 10 ? '0' : '') . $out_min . ' ' . $out_mode;
    }

    function formatText($value) {
        $value = str_replace("â", "\"", $value);
        $value = str_replace("â", "\"", $value);
        $value = str_replace("", "\"", $value);
        $value = str_replace("", "\"", $value);
        $value = preg_replace('/[^(\x20-\x7F)\x0A]*/', '', $value);
        $value = stripslashes($value);
        $value = html_entity_decode($value, ENT_QUOTES);
        $trans = get_html_translation_table(HTML_ENTITIES, ENT_QUOTES);
        $value = strtr($value, $trans);
        $value = stripslashes(trim($value));
        return $value;
    }

    function shortLength($value, $len, $user_info = null, $tip_align = 'top', $flag = false) {
        if ($flag && trim($value) == '') {
            return '---';
        }
        $value_format = $this->formatText($value);
        $value_raw = h($value_format);
        if (!$user_info) {
            $user_info = $value;
        }
        if (strlen($value_raw) > $len) {
            $value_strip = html_entity_decode($value_raw);
            $value_strip = substr($value_strip, 0, $len);
            $value_strip = $this->formatText($value_strip);
            $lengthvalue = "<span title='" . trim($user_info) . "' rel='tooltip' data-placement='" . $tip_align . "'>" . $value_strip . "...</span>";
        } else {
            $lengthvalue = $value_format;
        }
        return $lengthvalue;
    }

    function dateFormat($dt, $format = 'M d, Y') {
        $newdt = (strtotime($dt) > 0) ? date($format, strtotime($dt)) : '';
        return $newdt;
    }

    function dateTimeFormat($dt, $format = 'M d, Y g:i a') {
        $newdt = (strtotime($dt) > 0) ? date($format, strtotime($dt)) : '';
        return $newdt;
    }

    function comma_separator($user_data) {
        $prefix = '';
        $string = '';
        foreach ($user_data as $k => $v) {
            if ($user_data[$k] != "") {
                $string .= $prefix . $v;
                $prefix = ', ';
            }
        }
        return $string;
    }

    function formatPhoneNumber($phoneNumber) {
        //return '+91-' . $phoneNumber;
        $phoneNumber = preg_replace('/[^0-9]/', '', $phoneNumber);
        if (strlen($phoneNumber) > 10) {
            $countryCode = substr($phoneNumber, 0, strlen($phoneNumber) - 10);
            $areaCode = substr($phoneNumber, -10, 3);
            $nextThree = substr($phoneNumber, -7, 3);
            $lastFour = substr($phoneNumber, -4, 4);
            $phoneNumber = '+91' . ' ' . $areaCode . ' ' . $nextThree . '' . $lastFour;
        } else if (strlen($phoneNumber) == 10) {
            $areaCode = substr($phoneNumber, 0, 3);
            $nextThree = substr($phoneNumber, 3, 3);
            $lastFour = substr($phoneNumber, 6, 4);
            $phoneNumber = '+91- ' . $areaCode . ' ' . $nextThree . ' ' . $lastFour;
        } else if (strlen($phoneNumber) == 7) {
            $nextThree = substr($phoneNumber, 0, 3);
            $lastFour = substr($phoneNumber, 3, 4);
            $phoneNumber = $nextThree . '-' . $lastFour;
        }
        return $phoneNumber;
    }

    function multi_phone($phone) {
        if (strpos($phone, ',') !== false) {
            $phone_arr = explode(',', $phone);
            return $phone_arr;
        }
        return $phone;
    }

    function lastLoginTimeText($timeString) {
        if (trim($timeString) == '') {
            return "Never Logged in !";
        } else {
            return "Last login on " . $timeString;
        }
    }

    function userType($type) {
        $type = intval($type);
        if ($type == 2) {
            $user_type = 'User';
        } else if ($type == 3) {
            $user_type = 'Business user';
        } else if ($type == 1) {
            $user_type = 'Admin';
        } else {
            $user_type = 'N/A';
        }
        return $user_type;
    }

    function category_image($data, $width = "228", $height = "228") {
        $file = $data['Category']['category_image'];
        if (file_exists(WWW_ROOT . "upload/category/" . $file)) {
            #return HTTP_ROOT . "upload/category/" . $file;
            $file = "upload/category/" . $file;
            return $this->PhpThumb->url($file, array('w' => $width, 'h' => $height, 'zc' => 1, 'far' => $this->far));
        } else {
            return $this->PhpThumb->url('empty.jpg', array('w' => $width, 'h' => $height, 'zc' => 1, 'far' => $this->far));
        }
    }

    /* by GKM
     * for removing special characters
     */

    function seo_url($string = '', $flag = '-') {
        $string = substr($string, 0, 50);
        if (trim($string) != '') {
            if ($flag == " ") {
                $output = trim(preg_replace('/[^A-Za-z0-9.]+/i', $flag, $string), $flag);
                $output = preg_replace('/\s+/', ' ', $output);
                $output = str_replace(" ", "_", $output);
            } else {
                $string = strtolower($string);
                $output = trim(preg_replace('/[^A-Za-z0-9]+/i', $flag, $string), $flag);
            }
            return $output;
        } else {
            return '';
        }
    }

    /* by CP
     * for getting business status
     */

    function getStatus($status) {
        $status = intval($status);
        if ($status == 1) {
            $stat_type = 'Active';
        } else if ($status == 2) {
            $stat_type = 'Inactive';
        } else {
            $stat_type = 'N/A';
        }
        return $stat_type;
    }

    /* by CP
     * for getting complete address in a single string
     */

    function addressComplete($city, $locality, $address, $landmark, $zip) {
        return $address . "," . "\n" . (trim($landmark) != '' ? $landmark . "," : "") . "\n" . $locality . "," . "\n" . $city . "," . "\n" . $zip;
    }

    function show_business_logo($business, $width = "75", $height = "75", $zc = 1) {
        if (empty($business['Business']['logo'])) {
            $file_path = "images" . DS . "noimage.png";
        } else {
            $logo = trim($business['Business']['logo']);
            $file_path = BUSINESS_LOGO_PATH . "logo" . DS . $business['Business']['id'] . DS . $logo;
        }
        return $this->PhpThumb->url($file_path, array('w' => $width, 'h' => $height, 'zc' => $zc, 'far' => $this->far));
    }

    function show_business_gallery_logo($business_gall, $business_id) {
        return BUSINESS_GALLERY_URL . $business_id . "/" . h($business_gall['media']);
    }

    function user_photo($data = array(), $width = "75", $height = "75", $zc = '0') {
        if (empty($data['photo'])) {
            $file_path = "images" . DS . "default-user.png";
        } else {
            $file_path = USER_IMAGE_PATH . "photo" . DS . $data['id'] . DS . $data['photo'];
        }
        return $this->PhpThumb->url($file_path, array('w' => $width, 'h' => $height, 'zc' => $zc, 'far' => $this->far));
    }

    function gallery_image($data, $business_id, $width = "75", $height = "75", $zc = 1) {
        if (isset($data['BusinessGallery'][0]) && is_array($data['BusinessGallery'][0])) {
            $data = $data['BusinessGallery'][0];
        } elseif (isset($data['BusinessGallery']) && is_array($data['BusinessGallery'])) {
            $data = $data['BusinessGallery'];
        }
        $file = isset($data['media']) ? h($data['media']) : '';
        if (empty($file)) {
            $file_path = "images/noimage.png";
        } else {
            $file_path = BUSINESS_GALLERY_PATH . $business_id . DS . $file;
        }
        return $this->PhpThumb->url($file_path, array('w' => $width, 'h' => $height, 'zc' => $zc, 'far' => $this->far));
    }

    function get_video_url($video, $type = 'video') {
        if ($type == 'image') {
            $url = PROTOCOL . "img.youtube.com/vi/" . $video['video_id'] . "/0.jpg";
        } else {
            $url = PROTOCOL . "www.youtube.com/embed/" . $video['video_id'];
        }
        return $url;
    }

    function business_detail_url($business = array(), $full = true, $allowed = '') {
        if (!empty($business['seo_url']) && $allowed != 'No') {
            return ($full ? HTTP_ROOT : "") . $this->seo_url($business['seo_url']);
        } else {
            return ($full ? HTTP_ROOT : "") . 'b-' . $business['id'] . '-' . $this->seo_url($business['name']);
        }
    }

    function business_gallery_img_path($data, $business_id) {
        if (isset($data['BusinessGallery'][0]) && is_array($data['BusinessGallery'][0])) {
            $data = $data['BusinessGallery'][0];
        } elseif (isset($data['BusinessGallery']) && is_array($data['BusinessGallery'])) {
            $data = $data['BusinessGallery'];
        }
        $file = isset($data['media']) ? h($data['media']) : '';
        if (empty($file)) {
            $file_path = "images/noimage.png";
        } else {
            $file_path = BUSINESS_GALLERY_PATH . DS . $business_id . DS . $file;
        }
        return $file_path;
    }

    /**
     * Converts bytes into human readable file size. 
     * 
     * @param string $bytes 
     * @return string human readable file size (2,87 Мб)
     * @author CP
     */
    function FileSizeConvert($data, $business_id) {
        if (is_array($data)) {
            $filepath = $this->business_gallery_img_path($data, $business_id);
        } else {
            $filepath = BUSINESS_GALLERY_PATH . DS . $business_id . DS . $data;
        }
        $bytes = file_exists($filepath) ? filesize($filepath) : 0;
        $bytes = floatval($bytes);
        if ($bytes >= 1073741824) {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        } elseif ($bytes > 1) {
            $bytes = $bytes . ' bytes';
        } elseif ($bytes == 1) {
            $bytes = $bytes . ' byte';
        } else {
            $bytes = '0 bytes';
        }
        return $bytes;
    }

    function path_gallery_image($data, $business_id, $width = "75", $height = "75", $zc = 1) {
        if (empty($data)) {
            $file_path = "images/noimage.png";
        } else {
            $file_path = BUSINESS_GALLERY_PATH . DS . $business_id . DS . $data;
        }
        #return BUSINESS_GALLERY_URL . $business_id . "/" . $file;
        return $this->PhpThumb->url($file_path, array('w' => $width, 'h' => $height, 'zc' => $zc, 'far' => $this->far));
    }

    /**
     * Returns a key value pair of
     * business id's and business name
     * @param type $business_id(string) , type $options (array)
     * @return type array.
     */
    function get_business_list_business($business_id, $options = array(), $find_type = 'list') {
        $this->Business = ClassRegistry::init('Business');
        $this->Business->recursive = 0;
        $businesses = $this->Business->find($find_type, $options);
        return $businesses;
    }

    function format_facility_icon($icon, $extra_class = '', $facility = '') {
        $style = isset($facility['color']) && trim($facility['color']) != '' ? "style='color:" . $facility['color'] . ";'" : "";
        $html = "";
        $icon = trim($icon);
        if ($icon != '') {
            if (strpos($icon, '||||')) {
                $iconArr = explode('||||', $icon);
                foreach ($iconArr as $key => $val) {
                    $rightbrdr = count($iconArr) - 1 > $key ? "rightbrdr" : "";
                    $html .= "<i class='" . trim($val) . " " . $rightbrdr . " " . $extra_class . "' " . $style . "></i>";
                }
            } else {
                $html .= "<i class='" . trim($icon) . " " . $extra_class . "' " . $style . "></i>";
            }
        } else {
            $html = "N/A";
        }
        return $html;
    }

    function showUsername($name = '', $length = '0') {
        return trim($name) != '' ? ($length > 0 ? $this->shortLength($name, $length, $name) : h($name)) : '---';
    }

    function show_press_image($data, $width = "75", $height = "75", $zc = 1) {
        if (empty($data['preview'])) {
            $file_path = "images" . DS . "noimage.png";
        } else {
            $file_path = PRESS_IMAGE_PATH . "preview" . DS . $data['id'] . DS . trim($data['preview']);
        }
        return $this->PhpThumb->url($file_path, array('w' => $width, 'h' => $height, 'zc' => $zc, 'far' => $this->far));
    }

    function maskMobile($number, $maskingCharacter = 'X') {
        if (trim($number) == '')
            return '';
        $masklength = (strlen($number) == 15) ? strlen($number) - 7 : strlen($number) - 9;
        return substr($number, 0, 4) . @str_repeat($maskingCharacter, $masklength) . substr($number, -2);
    }

    function formatPackage($field, $type = "boolean") {
        if ($field == "Unlimited") {
            return $field;
        } else {
            $formatted_text = "";
            if (intval($field) < 1 && $type == "boolean") {
                $formatted_text = "No";
            } else if (intval($field) < 1 && $type == "string") {
                $formatted_text = $field;
            } else if (intval($field) == 1 && $type == "boolean") {
                $formatted_text = "Yes";
            } else if (intval($field) == 1 && $type == "string") {
                $formatted_text = $field;
            } else if (intval($field) > 1) {
                $formatted_text = "Up to " . $field;
            } else {
                $formatted_text = "Unlimited";
            }
            return $formatted_text;
        }
    }

    function mask_email($email, $mask_char, $percent = 50) {
        if (trim($email) == '')
            return '';
        list( $user, $domain ) = preg_split("/@/", $email);
        $len = strlen($user);
        $mask_count = floor($len * $percent / 100);
        $offset = floor(( $len - $mask_count ) / 2);
        $masked = substr($user, 0, $offset) . @str_repeat($mask_char, $mask_count) . substr($user, $mask_count + $offset);
        return ($masked . '@' . $domain);
    }

    public function is_subscription_expired($subscription_date, $subscription_period) {
        $expire = strtotime($subscription_date) + intval($subscription_period) * 24 * 60 * 60;
        return strtotime($subscription_date) > 0 && (time() > $expire) ? true : false;
    }

    public function is_allowed($subscription_data, $user_type = null, $keyword) {
        $is_allowed = "";
        switch (trim($keyword)) {
            case 'Map':
                $field = 'map_integration';
                break;
            case 'Social Media':
                $field = 'social_media_widget';
                break;
            case 'Call Request':
                $field = 'call_request';
                break;
            case 'Address':
                $field = 'address_detail';
                break;
            case 'Faq':
                $field = 'faq';
                break;
            case 'Video':
                $field = 'video_limit';
                break;
        }
        if (isset($user_type) && !empty($user_type) && ($user_type == '1')) {
            $is_allowed = true;
        } else if (isset($subscription_data['Subscription'][$field]) && !empty($subscription_data['Subscription'][$field])) {
            $is_allowed = true;
        } else if (empty($subscription_data)) {
            $is_allowed = true;
        } else {
            $is_allowed = false;
        }
        return $is_allowed;
    }

    function calc_percentage($price, $percentage, $precision) {
        $res = round(($percentage / 100) * $price, $precision);
        return $res;
    }

    public function image_add_block_text($subscription, $server_limit, $existing_count) {
        $text = '';
        if (!empty($subscription)) {
            if ($subscription['Subscription']['photo_limit'] == "Unlimited") {
                $text = "Plaese upload " . $server_limit . " images at a time.";
            } else if ($existing_count < intval($subscription['Subscription']['photo_limit'])) {
                $text = "You can upload " . (intval($subscription['Subscription']['photo_limit']) - $existing_count) . " more images only.";
            } else {
                $text = "Your maximum image upload limit reached.";
            }
        } else {
            $text = "Plaese upload " . $server_limit . " images at a time.";
        }
        return $text;
    }

    #-#############################################
    # desc: creates an <select> box
    # param: name, array['val']="display" of data, default selected, extra parameters
    # returns: html of box and options

    public function create_selectbox($name, $data, $default = '', $param = '', $def_option = '', $disable = '') {
        $out = '<select name="' . $name . '"' . (!empty($param) ? ' ' . $param : '') . ">\n";
        if (!empty($def_option)) {
            $out .= "<option value=''>" . $def_option . "</option>\n";
        }
        foreach ($data as $key => $val) {
            $out.='<option value="' . $key . '"' . ($default == $key ? ' selected="selected"' : '') . ' ' . ($disable == $key ? 'disabled="disabled"' : '') . '>';
            $out.=$val;
            $out.="</option>\n";
        }
        $out.="</select>\n";
        return $out;
    }

    public function discount_text($discount_type, $period_type, $period_duration, $discount_amount) {
        $months = ($period_type == 'Month') ? $period_duration . " months" : (intval($period_duration) * 12) . " months";
        if ($discount_type == "Month") {
            $months = ($period_type == 'Month') ? $period_duration : (intval($period_duration) * 12);
            //$text = "Get ".$discount_amount." months free on ".$months;
            $text = "Pay for " . ($months - $discount_amount) . " months get " . $discount_amount . " months free.";
        } else if ($discount_type == "Flat") {
            $text = "Get " . $discount_amount . " flat off on " . $months;
        } else {
            $text = "Get " . $discount_amount . " % off on " . $months;
        }
        return $text;
    }

    public function get_font_ext_class($ext) {
        switch (trim(strtolower($ext))) {
            case 'pdf':
                $class = "fa fa-file-pdf-o";
                break;
            case 'doc':
            case 'docx':
                $class = "fa fa-file-word-o";
                break;
            case 'xls':
            case 'xlsx':
            case 'csv':
                $class = "fa fa-file-excel-o";
                break;
            case 'txt':
            case 'rtf':
                $class = "fa fa-file-text-o";
                break;
            case 'ppt':
            case 'pptx':
                $class = "fa fa-file-powerpoint-o";
                break;
            default:
                $class = "fa fa-file-o";
                break;
        }
        return $class;
    }

    function sanitizeFilename($f) {
        // a combination of various methods
        // we don't want to convert html entities, or do any url encoding
        // we want to retain the "essence" of the original file name, if possible
        // char replace table found at:
        // http://www.php.net/manual/en/function.strtr.php#98669
        $replace_chars = array(
            'Š' => 'S', 'š' => 's', 'Ð' => 'Dj', 'Ž' => 'Z', 'ž' => 'z', 'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A',
            'Å' => 'A', 'Æ' => 'A', 'Ç' => 'C', 'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I',
            'Ï' => 'I', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ø' => 'O', 'Ù' => 'U', 'Ú' => 'U',
            'Û' => 'U', 'Ü' => 'U', 'Ý' => 'Y', 'Þ' => 'B', 'ß' => 'Ss', 'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a',
            'å' => 'a', 'æ' => 'a', 'ç' => 'c', 'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i',
            'ï' => 'i', 'ð' => 'o', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ø' => 'o', 'ù' => 'u',
            'ú' => 'u', 'û' => 'u', 'ý' => 'y', 'ý' => 'y', 'þ' => 'b', 'ÿ' => 'y', 'ƒ' => 'f'
        );
        $f = strtr($f, $replace_chars);
        // convert & to "and", @ to "at", and # to "number"
        $f = preg_replace(array('/[\&]/', '/[\@]/', '/[\#]/'), array('-and-', '-at-', '-number-'), $f);
        $f = preg_replace('/[^(\x20-\x7F)]*/', '', $f); // removes any special chars we missed
        $f = str_replace(' ', '-', $f); // convert space to hyphen 
        $f = str_replace('\'', '', $f); // removes apostrophes
        $f = preg_replace('/[^\w\-\.]+/', '', $f); // remove non-word chars (leaving hyphens and periods)
        $f = preg_replace('/[\-]+/', '-', $f); // converts groups of hyphens into one
        return strtolower($f);
    }

    function show_event_banner($event, $width = "75", $height = "75", $zc = 1) {
        if (empty($event['Event']['banner'])) {
            $file_path = "images" . DS . "noimage.png";
        } else {
            $banner = trim($event['Event']['banner']);
            $file_path = EVENT_BANNER_PATH . "banner" . DS . $event['Event']['id'] . DS . $banner;
        }
        return $this->PhpThumb->url($file_path, array('w' => $width, 'h' => $height, 'zc' => $zc, 'far' => $this->far));
    }

    function ad_image($data, $width = "75", $height = "75", $zc = 1) {

        $file = isset($data['image']) ? h($data['image']) : '';
        $id = isset($data['id']) ? h($data['id']) : '';
        if (empty($file)) {
            $file_path = "images/noimage.png";
        } else {
            $file_path = BANNER_PATH . $id . DS . $file;
        }
        #return $file_path;
        return $this->PhpThumb->url($file_path, array('w' => $width, 'h' => $height, 'zc' => $zc, 'far' => $this->far));
    }

    function get_subscription_plans() {
        $this->Package = ClassRegistry::init('Package');
        return $this->Package->find('all', array('order' => array('Package.id ASC'), 'recursive' => -1));
    }

    function showSubscriptionDetails($offer = '') {
        $txt = '';
        $discount_type = $prefix = '';
        if (!empty($offer)) {
            $deoffer = json_decode($offer, true);
            $txt .="{$deoffer['period_duration']} {$deoffer['period_type']}(s)";
            #$txt .= $this->checkDiscount($offer);
        }
        return $txt;
    }

    function checkDiscount($offer = '', $prefix = '') {
        $txt = '';
        $offer = json_decode($offer, true);
        if (!empty($offer['discount']) && floatval($offer['discount']) > 0) {
            if ($offer['discount_type'] == 'Month') {
                $discount_type = " Month(s) Free";
            } elseif ($offer['discount_type'] == 'Flat') {
                $discount_type = " Off";
                $prefix = '';
            } elseif ($offer['discount_type'] == 'Percentage') {
                $discount_type = "% Off";
            }
            $txt .= "(<em>{$prefix} {$offer['discount']}{$discount_type} </em>)";
        }
        return $txt;
    }

    function checkSubscription($data = array(), $lable = true) {
        if ($data['status'] == '0') {
            $status = $lable == true ? '<span class="label label-warning">Pending</span>' : "Pending";
        } elseif ($data['status'] == '2') {
            $status = $lable == true ? '<span class="label label-danger">Cancelled</span>' : "Cancelled";
        } elseif ($data['status'] == '3' || $this->is_subscription_expired($data['subscription_start'], $data['listing_period'])) {
            $status = $lable == true ? '<span class="label label-warning">Expired</span>' : "Expired";
        } else {
            $status = $lable == true ? '<span class="label label-success">Active</span>' : "Active";
        }
        return $status;
    }

    function event_detail_url($data = array(), $full = true) {
        return ($full ? HTTP_ROOT : "") . 'e-' . $data['id'] . '-' . $this->seo_url($data['name']);
    }

}
