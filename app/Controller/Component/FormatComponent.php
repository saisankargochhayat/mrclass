<?php

class FormatComponent extends Component {

    public $components = array('Session', 'Email', 'Cookie', 'Date');

    function parent_categories($mode = 'all', $id = '') {
        $Category = ClassRegistry::init('Category');
        $Category->recursive = -1;
        $params = array('conditions' => array('Category.status' => 1, 'Category.parent_id' => '0'), 'order' => array('Category.name' => "ASC"));
        #'Category.sequence' => "ASC",
        if ($id > 0) {
            $params['conditions']['id'] = $id;
        }
        $CategoryDtls = $Category->find($mode, $params);
        return $CategoryDtls;
    }

    function child_categories($id, $mode = 'all', $cid = '') {
        if ($id > 0) {
            $Category = ClassRegistry::init('Category');
            $Category->recursive = -1;
            $params = array('conditions' => array('Category.status' => 1, 'Category.parent_id' => $id), 'order' => array('Category.name' => "ASC"));
            #'Category.sequence' => "ASC",
            if ($cid > 0) {
                $params['conditions']['id'] = $cid;
            }
            $CategoryDtls = $Category->find($mode, $params);
            return $CategoryDtls;
        }
    }

    function getCityList() {
        $this->City = ClassRegistry::init('City');
        $params = array('conditions' => array('City.status' => '1'), 'fields' => array('City.id', 'City.name'), 'order' => array('City.name' => "ASC"));
        $cityList = $this->City->find('list', $params);
        return $cityList;
    }

    function states($mode = 'all') {
        $State = ClassRegistry::init('State');
        $State->recursive = -1;
        $condition = array('State.status' => 1);
        $StateDtls = $State->find($mode, array('conditions' => $condition, 'order' => array('State.name' => "ASC")));
        return $StateDtls;
    }

    function cities($mode = 'all', $for = '') {
        $City = ClassRegistry::init('City');
        $City->recursive = -1;
        $condition = ($for == 'business') ? array('City.business_status' => 1) : array('City.status' => 1);
        $CityDtls = $City->find($mode, array('conditions' => $condition, 'order' => array('City.name' => "ASC")));
        return $CityDtls;
    }

    function localities($CityId, $mode = 'list') {
        if ($CityId > 0) {
            $Locality = ClassRegistry::init('Locality');
            $Locality->recursive = -1;
            $LocalityDtls = $Locality->find($mode, array('conditions' => array('Locality.status' => 1), 'fields' => array('Locality.id', 'Locality.name'), 'order' => array('Locality.name' => "ASC")));
        } else {
            $LocalityDtls = array();
        }
        return $LocalityDtls;
    }

    function make_salty_password($string) {
        return Security::hash($string, 'md5', true);
    }

    function format_12hr_to_24hr($time) {
        // 2:05pm or 2:05 pm
        $time = strtolower(trim($time));
        $time_offset = trim(substr($time, strlen($time) - 2));
        $time_val = trim(substr($time, 0, strlen($time) - 2));
        $time_arr = explode(":", $time_val);
        $out_mode = $time_offset == 'am' ? 0 : 12;
        $out_hr = (intval($time_arr[0]) < 12 ? intval($time_arr[0]) : 0) + $out_mode;
        $out_min = intval(@$time_arr[1]);
        return str_pad($out_hr, 2, '0', STR_PAD_LEFT) . ':' . str_pad($out_min, 2, '0', STR_PAD_LEFT) . ':00';
    }

    function youtube_id_from_url($url) {
        $pattern = '%^(?:https?://)?(?:www\.)?(?:youtu\.be/| youtube\.com(?:/embed/| /v/| /watch\?v=))([\w-]{10,12})$%x';
        $result = preg_match($pattern, $url, $matches);
        if (false !== $result) {
            return $matches[1];
        }
        return false;
    }

    /**
     * Returns an array of business id's
     * based on a business user's id.
     * @param type $user_id 
     * @return type array.
     */
    function get_business_list($user_id, $options = array(), $find_type = 'list') {
        $this->Business = ClassRegistry::init('Business');
        $options['conditions']['Business.user_id'] = $user_id;
        $user_business = $this->Business->find($find_type, $options);
        #$user_business = $this->Business->find($find_type, array('conditions' => array('Business.user_id'=>$user_id),'recursive'=>-1,'fields'=>array('Business.id')));
        return $user_business;
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

    function get_gallery_image_path($name, $business_id) {
        $file = $name;
        if (empty($file)) {
            $file_path = "images/noimage.png";
        } else {
            $file_path = BUSINESS_GALLERY_PATH . DS . $business_id . DS . $file;
        }
        return $file_path;
    }

    function get_user_ids() {
        $this->User = ClassRegistry::init('User');
        $this->User->recursive = 0;
        $users = $this->User->find('list', array(
            'fields' => array('User.id', 'User.name'),
            'conditions' => array('User.type' => 2, 'User.status' => 1),
            'order' => "User.name ASC",
                )
        );
        return $users;
    }

    function get_users() {
        $this->User = ClassRegistry::init('User');
        $this->User->recursive = false;
        $users = $this->User->find('all', array(
            'fields' => array('User.id', "CONCAT(User.name,' (',User.email,')') AS name"),
            'conditions' => array('User.type' => 2, 'User.status' => 1),
            'order' => "User.name ASC",
                )
        );
        $users = Hash::combine($users, "{n}.User.id", "{n}.0.name");
        return $users;
    }

    function get_unsubscribed_users($subscribed_users_arr) {
        $this->User = ClassRegistry::init('User');
        $this->User->recursive = false;
        $users = $this->User->find('all', array('fields' => array('User.id', "CONCAT(User.name,' (',User.email,')') AS name"), 'conditions' => array('User.type' => 2, 'User.status' => 1, 'NOT' => array('User.id' => $subscribed_users_arr)), 'order' => "User.name ASC"));
        $users = Hash::combine($users, "{n}.User.id", "{n}.0.name");
        return $users;
    }

    /**
     * Return the business count based on users id.
     * @param type $user_id 
     * @return type integer.
     */
    public function get_business_count($user_id) {
        $this->Business = ClassRegistry::init('Business');
        $count = $this->Business->find('count', array('conditions' => array('Business.user_id' => $user_id)));
        return intval($count);
    }

    /**
     * Return true if subscription expired otherwise false.
     * @param type $subscription_date e.g-the date on subscribed.
     * @param type $subscription_period e.g-the Listing period based on subscribed package.
     * @return type boolean
     */
    public function is_subscription_expired($subscription_date, $subscription_period) {
        $expire = strtotime($subscription_date) + intval($subscription_period) * 24 * 60 * 60;
        return (time() > $expire) ? true : false;
    }

    public function is_subscription_active($subscription_end_date) {
        $expire = strtotime($subscription_end_date);
        return (time() < $expire) ? true : false;
    }

    /** by CP
     * To recursively add permissions to file and folders.
     */
    function recursiveChmod($path, $filePerm = 0644, $dirPerm = 0755) {
        // Check if the path exists
        if (!file_exists($path)) {
            return(false);
        }

        // See whether this is a file
        if (is_file($path)) {
            // Chmod the file with our given filepermissions
            chmod($path, $filePerm);

            // If this is a directory...
        } elseif (is_dir($path)) {
            // Then get an array of the contents
            $foldersAndFiles = scandir($path);

            // Remove "." and ".." from the list
            $entries = array_slice($foldersAndFiles, 2);

            // Parse every result...
            foreach ($entries as $entry) {
                // And call this function again recursively, with the same permissions
                recursiveChmod($path . "/" . $entry, $filePerm, $dirPerm);
            }

            // When we are done with the contents of the directory, we chmod the directory itself
            chmod($path, $dirPerm);
        }

        // Everything seemed to work out well, return true
        return(true);
    }

    public function price_calculation($sub_offer, $price) {
        $offer = $sub_offer;
        $package_price = floatval($price);
        $period_duration = (trim($offer['period_type']) == 'Year') ? floatval($offer['period_duration']) * 12 : floatval($offer['period_duration']);
        $total_price = $package_price * $period_duration;
        $discount_price = floatval($offer['discount']);
        $discount_type = trim($offer['discount_type']);
        if ($discount_type == "Flat") {
            $total_discounted_price = $total_price - $discount_price;
        } else if ($discount_type == "Percentage") {
            $total_discounted_price = $total_price - (($discount_price / 100) * $total_price);
        } else {
            $total_discounted_price = $total_price - ($package_price * $discount_price);
        }
        $total_discounted_price_pm = ceil($total_discounted_price / $period_duration);

        return array('total_discountd_price' => $total_discounted_price, 'total_discountd_price_pm' => $total_discounted_price_pm, 'duration' => $period_duration);
    }

    public function get_deducted_balance($sub_start_date, $price_array, $current_price_array) {
        $now = time();
        $subscription_start_stamp = strtotime($sub_start_date);
        $datediff = $now - $subscription_start_stamp;
        $active_days = floor($datediff / (60 * 60 * 24));
        $no_of_active_months = ($active_days == 0) ? ceil(1 / 30) : ceil($active_days / 30);
        $total_deduction_amount = $no_of_active_months * $price_array['total_discountd_price_pm'];
        $total_balance_remained = $price_array['total_discountd_price'] - $total_deduction_amount;
        $total_price = $current_price_array['total_discountd_price'] - $total_balance_remained;
        $res_amount_array = array('no_of_active_months' => $no_of_active_months, 'total_deduction_amount' => $total_deduction_amount, 'total_balance_remained' => $total_balance_remained, 'total_price' => $total_price);
        return $res_amount_array;
    }

    public function get_category_business_ids($category_id) {
        $this->BusinessCategory = ClassRegistry::init('BusinessCategory');
        $business_ids_data = $this->BusinessCategory->find('all', array('conditions' => array('BusinessCategory.category_id' => $category_id), 'fields' => array('BusinessCategory.business_id', 'BusinessCategory.category_id')));
        $result_ids = Hash::extract($business_ids_data, '{n}.BusinessCategory.business_id');
        return $result_ids;
    }

    public function file_newname($path, $filename) {
        if ($pos = strrpos($filename, '.')) {
            $name = substr($filename, 0, $pos);
            $ext = substr($filename, $pos);
        } else {
            $name = $filename;
        }

        $newpath = $path . DS . $filename;
        $newname = $filename;
        $counter = 0;
        while (file_exists($newpath)) {
            $newname = $name . '_' . $counter . $ext;
            $newpath = $path . '/' . $newname;
            $counter++;
        }

        return $newname;
    }

    public function get_question_bank_flder($q_cat_id) {
        $this->QuestionCategory = ClassRegistry::init('QuestionCategory');
        $ques_cat_data = $this->QuestionCategory->find('first', array('conditions' => array('QuestionCategory.id' => $q_cat_id), 'fields' => array('QuestionCategory.id', 'QuestionCategory.name')));
        $inflected_category_name = $this->sanitizeFilename($ques_cat_data['QuestionCategory']['name']);
        $path = QUESTION_BANK_DIR . $inflected_category_name . "_" . $ques_cat_data['QuestionCategory']['id'];
        return $path;
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

    ################### Start of Excel export Functionality    ########################

    public function export_excel($filename, $data) {
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header("Content-Disposition: attachment; filename=\".$filename." . date("Y-m-d") . ".xls\"");
        header("Content-Transfer-Encoding: binary");
        header("Pragma: no-cache");
        header("Expires: 0");

        $header_arr = $data['header_arr'];
        $sheet_data = $data['data'];
        $this->xlsBOF();
        for ($i = 0; $i < count($header_arr); $i++) {
            $this->xlsWriteLabel(0, $i, $header_arr[$i]);
        }
        $cnt = 0;
        foreach ($sheet_data as $key => $value) {
            $col = 0;
            $cnt++;
            foreach ($value as $k => $v) {
                if (is_numeric($v)) {
                    $this->xlsWriteNumber($cnt, $col++, $v);
                } else {
                    $this->xlsWriteLabel($cnt, $col++, $v);
                }
            }
        }
        $this->xlsEOF();
    }

    function xlsBOF() {
        echo pack("ssssss", 0x809, 0x8, 0x0, 0x10, 0x0, 0x0);
    }

    function xlsEOF() {
        echo pack("ss", 0x0A, 0x00);
    }

    function xlsWriteNumber($Row, $Col, $Value) {
        echo pack("sssss", 0x203, 14, $Row, $Col, 0x0);
        echo pack("d", $Value);
    }

    function xlsWriteLabel($Row, $Col, $Value) {
        $L = strlen($Value);
        echo pack("ssssss", 0x204, 8 + $L, $Row, $Col, 0x0, $L);
        echo $Value;
    }

    ################### End of Excel export Functionality    ########################
    #################################################################################
    #################################################################################

    function generateUniqNumber() {
        $uniq = uniqid(rand());
        return md5($uniq . time());
    }

    function genRandomString($length = 7, $flag = '') {
        $length = intval($length) > 0 ? $length : 8;
        $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
        $string = '';
        for ($p = 0; $p < $length; $p++) {
            $string .= $characters[mt_rand(0, strlen($characters) - 1)];
        }
        if ($flag == 'uppercase') {
            $string = strtoupper($string);
        }
        return $string;
    }

    function showlink($value) {
        $value = str_replace("a href=", "a style='text-decoration:underline;color:#066D99' target='_blank' href=", $value);
        $value = preg_replace("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", '<a href="http://\\0"target="_blank">\\0</a>', $value);
        if (stristr($value, "http://http://")) {
            $value = str_replace("http://http://", "http://", $value);
        }
        if (stristr($value, "http://http//")) {
            $value = str_replace("http://http//", "http://", $value);
        }
        if (stristr($value, "https://https://")) {
            $value = str_replace("https://https://", "https://", $value);
        }
        if (stristr($value, "https://https//")) {
            $value = str_replace("https://https//", "https://", $value);
        }
        if (stristr($value, "http://https://")) {
            $value = str_replace("http://https://", "https://", $value);
        }
        return stripslashes($value);
    }

    function longstringwrap($string = "") {
        return $string;
        //return preg_replace_callback( '/\w{10,}/ ', create_function( '$matches', 'return chunk_split( $matches[0], 5, "&#8203;" );' ), $string );
    }

    function getUserShortName($uid) {
        $User = ClassRegistry::init('User');
        $User->recursive = -1;
        $usrDtls = $User->find('first', array('conditions' => array('User.id' => $uid), 'fields' => array('User.name', 'User.short_name')));
        return $usrDtls;
    }

    function getUserNameForEmail($uid) {
        $User = ClassRegistry::init('User');
        $User->recursive = -1;
        $usrDtls = $User->find('first', array('conditions' => array('User.id' => $uid, 'User.isactive' => 1), 'fields' => array('User.name', 'User.email', 'User.id')));
        return $usrDtls;
    }

    function dateConvertion($date) {
        //print_r($date);exit;
        $seconds = strtotime($date);
        return ($seconds + 86400);
    }

    function uploadPhoto($tmp_name, $name, $size, $path, $count, $type) {
        if ($name) {
            $inkb = $size / 1024;
            $oldname = strtolower($name);
            $ext = substr(strrchr($oldname, "."), 1);
            if (($ext != 'gif') && ($ext != 'jpg') && ($ext != 'jpeg') && ($ext != 'png')) {
                return "ext";
            }
            /* elseif($inkb > 1024) {
              return "size";
              } */ else {
                list($width, $height) = getimagesize($tmp_name);

                if ($width > 800) {
                    try {
                        if ($extname == "png") {
                            $src = imagecreatefrompng($tmp_name);
                        } elseif ($extname == "gif") {
                            $src = imagecreatefromgif($tmp_name);
                        } elseif ($extname == "bmp") {
                            $src = imagecreatefromwbmp($tmp_name);
                        } else {
                            $src = imagecreatefromjpeg($tmp_name);
                        }

                        $newwidth = 800;
                        $newheight = ($height / $width) * $newwidth;
                        $tmp = imagecreatetruecolor($newwidth, $newheight);

                        imagecopyresampled($tmp, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

                        $newname = md5(time() . $count) . "." . $ext;
                        $targetpath = $path . $newname;

                        imagejpeg($tmp, $targetpath, 100);
                        imagedestroy($src);
                        imagedestroy($tmp);
                        // s3 bucket  start                                 						 
                        $s3 = new S3(awsAccessKey, awsSecretKey);
                        //$s3->putBucket(BUCKET_NAME, S3::ACL_PUBLIC_READ_WRITE);
                        $s3->putBucket(BUCKET_NAME, S3::ACL_PRIVATE);
                        if ($type == "profile_img") {
                            $folder_orig_Name = 'files/photos/' . trim($newname);
                        } else {
                            $folder_orig_Name = 'files/company/' . trim($newname);
                        }
                        //$s3->putObjectFile($tmp_name,BUCKET_NAME ,$folder_orig_Name ,S3::ACL_PUBLIC_READ_WRITE);
                        $s3->putObjectFile($targetpath, BUCKET_NAME, $folder_orig_Name, S3::ACL_PRIVATE);
                        //s3 bucket end
                        unlink($targetpath);
                    } catch (Exception $e) {
                        return false;
                    }
                } else {
                    $newname = md5(time() . $count) . "." . $ext;
                    $targetpath = $path . $newname;
                    move_uploaded_file($tmp_name, $targetpath);
                    // s3 bucket  start                                 						 
                    $s3 = new S3(awsAccessKey, awsSecretKey);
                    $s3->putBucket(BUCKET_NAME, S3::ACL_PRIVATE);
                    if ($type == "profile_img") {
                        $folder_orig_Name = 'files/photos/' . trim($newname);
                    } else {
                        $folder_orig_Name = 'files/company/' . trim($newname);
                    }
                    //$folder_orig_Name = 'files/photos/'.trim($newname);
                    //$s3->putObjectFile($tmp_name,BUCKET_NAME ,$folder_orig_Name ,S3::ACL_PUBLIC_READ_WRITE);
                    $s3->putObjectFile($targetpath, BUCKET_NAME, $folder_orig_Name, S3::ACL_PRIVATE);
                    //s3 bucket end
                    unlink($targetpath);
                }

                if ($width < 200 || $height < 200) {
                    $im_P = 'convert ' . $targetpath . '  -background white -gravity center -extent 200x200 ' . $targetpath;
                    exec($im_P);
                }

                return $newname;
            }
        } else {
            return false;
        }
    }

    function uploadProfilePhoto($name, $path) {
        if ($name) {
            $oldname = strtolower($name);
            $ext = substr(strrchr($oldname, "."), 1);
            if (($ext != 'gif') && ($ext != 'jpg') && ($ext != 'jpeg') && ($ext != 'png') && ($ext != 'bmp')) {
                return "ext";
            } else {
                $targetpath = $path . $name;
                $newname = $name; //md5(time().$count).".".$ext;			
                if (defined('USE_S3') && USE_S3) {
                    // s3 bucket  start                                 						 
                    $s3 = new S3(awsAccessKey, awsSecretKey);
                    $s3->putBucket(BUCKET_NAME, S3::ACL_PRIVATE);
                    $folder_orig_Name = 'files/photos/' . trim($newname);
                    //$s3->putObjectFile($targetpath,BUCKET_NAME ,$folder_orig_Name ,S3::ACL_PRIVATE);
                    $s3->copyObject(BUCKET_NAME, DIR_USER_PHOTOS_THUMB . trim($newname), BUCKET_NAME, $folder_orig_Name, S3::ACL_PRIVATE);
                    //s3 bucket end
                    //unlink($targetpath);	
                }

                return $newname;
            }
        } else {
            return false;
        }
    }

    function showuploadImage($tmp_name, $name, $size, $path, $count) {
        if ($name) {
            $image = strtolower($name);
            $extname = substr(strrchr($image, "."), 1);
            if (($extname != 'gif') && ($extname != 'jpg') && ($extname != 'jpeg') && ($extname != 'png') && ($extname != 'bmp')) {
                return false;
            } else {
                list($width, $height) = getimagesize($tmp_name);
                //$checkSize = round($size/1024);
                if (($width < 100 && $height < 100) || ($width < 100) || ($height < 100)) {
                    return 'small size image';
                } else {
                    if ($width > 200) {
                        try {
                            $type = exif_imagetype($tmp_name);
                            switch ($type) {
                                case 1 :
                                    $src = imagecreatefromgif($tmp_name);
                                    break;
                                case 2 :
                                    $src = imagecreatefromjpeg($tmp_name);
                                    break;
                                case 3 :
                                    $src = imagecreatefrompng($tmp_name);
                                    break;
                                case 6 :
                                    $src = imagecreatefromwbmp($tmp_name);
                                    break;
                                default:
                                    $src = imagecreatefromjpeg($tmp_name);
                                    break;
                            }

                            /* if($extname == "png") {
                              $src = imagecreatefrompng($tmp_name);
                              }
                              elseif($extname == "gif") {
                              $src = imagecreatefromgif($tmp_name);
                              }
                              elseif($extname == "bmp") {
                              $src = imagecreatefromwbmp($tmp_name);
                              }
                              else {
                              $src = imagecreatefromjpeg($tmp_name);
                              } */

                            $newwidth = 200;
                            $newheight = ($height / $width) * $newwidth;
                            //$newheight = 600;

                            $tmp = imagecreatetruecolor($newwidth, $newheight);

                            imagecopyresampled($tmp, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
                            $time = time() . $count;
                            $filepath = md5($time) . "." . $extname;
                            $targetpath = $path . $filepath;
                            imagejpeg($tmp, $targetpath, 100);
                            imagedestroy($src);
                            imagedestroy($tmp);
                        } catch (Exception $e) {
                            return false;
                        }
                    } else {
                        $time = time() . $count;
                        $filepath = md5($time) . "." . $extname;
                        $targetpath = $path . $filepath;
                        if (!is_dir($path)) {
                            mkdir($path);
                        }
                        move_uploaded_file($tmp_name, $targetpath);
                    }
                    if (file_exists($targetpath)) {
                        return $filepath;
                    } else {
                        return false;
                    }
                }
            }
        }
    }

    function caseKeywordSearch($caseSrch, $type) {
        $searchcase = "";
        if (trim(urldecode($caseSrch))) {
            $srchstr1 = addslashes(trim(urldecode($caseSrch)));
            if (substr($srchstr1, 0, 1) == "#") {
                $srchstr1 = substr($srchstr1, 1, strlen($srchstr1));
            } else {
                $srchstr1 = $srchstr1;
            }
            if (!ereg('[^0-9]', $srchstr1)) {
                $searchcase = "AND (Easycase.title LIKE '%$srchstr1%' OR Easycase.case_no LIKE '$srchstr1%')";
            } else {
                if (ereg('[^A-Za-z -()@$&,]', $srchstr1) && !strstr($srchstr1, " ") && !strstr($srchstr1, "-") && !strstr($srchstr1, ",") && !strstr($srchstr1, "/") && !strstr($srchstr1, "_") && !strstr($srchstr1, "_") && !strstr($srchstr1, ":") && !strstr($srchstr1, ".") && !strstr($srchstr1, "&")) {
                    $projshortname = ereg_replace("[^A-Za-z]", "", $srchstr1);
                    $caseno = ereg_replace("[^0-9]", "", $srchstr1);
                    $searchcase = "AND (Easycase.case_no LIKE '$caseno%' OR Easycase.title LIKE '%$srchstr1%')";
                } else {
                    if (strstr($srchstr1, " ") && $type == "full") {
                        /* $expsrch = explode(" ",$srchstr1);
                          foreach($expsrch as $newsrchstr) {
                          $searchcase.= "Easycase.title LIKE '%$newsrchstr%' OR Easycase.message LIKE '%$newsrchstr%' OR ";
                          }
                          $searchcase = substr($searchcase,0,-3);
                          $searchcase = "AND (".$searchcase.")"; */
                        $searchcase = "AND (Easycase.title LIKE '%$srchstr1%' OR Easycase.message LIKE '%$srchstr1%')";
                    } elseif ($type == "half") {
                        $searchcase = "AND (Easycase.title LIKE '%$srchstr1%' OR Easycase.message LIKE '%$srchstr1%')";
                    } elseif ($type == "title") {
                        $searchcase = "AND Easycase.title LIKE '%$srchstr1%'";
                    } else {
                        $searchcase.= "AND (Easycase.title LIKE '%$srchstr1%' OR Easycase.message LIKE '%$srchstr1%')";
                    }
                }
            }
        }
        return $searchcase;
    }

    function arcDateFiltxt($duedate) {
        if (!empty($duedate)) {
            if ($duedate == 'today') {
                $txt = 'Today';
            } else if ($duedate == 'yesterday') {
                $txt = 'Yesterday';
            } else if ($duedate == 'thisweek') {
                $txt = 'This Week';
            } else if ($duedate == 'thismonth') {
                $txt = 'This Month';
            } else if ($duedate == 'thisquarter') {
                $txt = 'This Quarter';
            } else if ($duedate == 'thisyear') {
                $txt = 'This Year';
            } else if ($duedate == 'lastyear') {
                $txt = 'Last Year';
            } else if ($duedate == 'lastweek') {
                $txt = 'Last Week';
            } else if ($duedate == 'lastmonth') {
                $txt = 'Last Month';
            } else if ($duedate == 'lastquarter') {
                $txt = 'Last Quarter';
            } else if ($duedate == 'last365days') {
                $txt = 'Last 365 Days';
            } else {
                $txt = '';
            }
        }
        return $txt;
    }

    function find_file($dirname, $fname, &$file_path) {
        if (file_exists($dirname . $fname)) {
            return $dirname . $fname;
        } else {
            return false;
        }
    }

    function emailBodyFilter($value) {
        $pattern = array("/\n/", "/\r/", "/content-type:/i", "/to:/i", "/from:/i", "/cc:/i");
        $value = preg_replace($pattern, "", $value);
        return $value;
    }

    function validateEmail($email) {
        $at = strrpos($email, "@");
        if ($at && ($at < 1 || ($at + 1) == strlen($email)))
            return false;
        if (preg_match("/(\.{2,})/", $email))
            return false;
        $local = substr($email, 0, $at);
        $domain = substr($email, $at + 1);
        $locLen = strlen($local);
        $domLen = strlen($domain);
        if ($locLen < 1 || $locLen > 64 || $domLen < 4 || $domLen > 255)
            return false;
        if (preg_match("/(^\.|\.$)/", $local) || preg_match("/(^\.|\.$)/", $domain))
            return false;
        if (!preg_match('/^"(.+)"$/', $local)) {
            if (!preg_match('/^[-a-zA-Z0-9!#$%*\/?|^{}`~&\'+=_\.]*$/', $local))
                return false;
        }
        if (!preg_match("/^[-a-zA-Z0-9\.]*$/", $domain) || !strpos($domain, "."))
            return false;
        return true;
    }

    function generatePassword($length) {
        $vowels = 'aeuy';
        $consonants = '3@Z6!29G7#$QW4';
        $password = '';
        $alt = time() % 2;
        for ($i = 0; $i < $length; $i++) {
            if ($alt == 1) {
                $password .= $consonants[(rand() % strlen($consonants))];
                $alt = 0;
            } else {
                $password .= $vowels[(rand() % strlen($vowels))];
                $alt = 1;
            }
        }
        return $password;
    }

    function generateTemporaryURL($resource) {
        $bucketname = BUCKET_NAME;
        $awsAccessKey = awsAccessKey;
        $awsSecretKey = awsSecretKey;
        $expires = strtotime('+1 day'); //1.day.from_now.to_i; 
        $s3_key = explode(BUCKET_NAME, $resource);
        $x = $s3_key[1];
        $s3_key[1] = substr($x, 1);
        $string = "GET\n\n\n{$expires}\n/{$bucketname}/{$s3_key[1]}";
        $signature = urlencode(base64_encode((hash_hmac("sha1", utf8_encode($string), $awsSecretKey, TRUE))));
        //$signature = urlencode(base64_encode((hash_hmac("sha1", $string, $awsSecretKey, TRUE))));
        //echo $expires."=====";echo $signature;
        return "{$resource}?AWSAccessKeyId={$awsAccessKey}&Signature={$signature}&Expires={$expires}";
        //https://s3.amazonaws.com/orangescrum-dev/files/case_files/1.jpg?AWSAccessKeyId=AKIAJAVFGWOGKGBOWPWQ&Signature=gZ90JslqYADtRK6haMVR9e2guko%3D&Expires=1360239119
    }

    function downloadFile($filename, $chk = null) {
        set_time_limit(0);
        if (!isset($filename) || empty($filename)) {
            $var = "<table align='center' width='100%'><tr><td style='font:bold 14px verdana;color:#FF0000;' align='center'>Please specify a file name for download.</td></tr></table>";
            die($var);
        }
        //if (strpos($filename, "\0") !== FALSE) die('');
        //$fname = basename($filename);
        $s3 = new S3(awsAccessKey, awsSecretKey);
        $info = $s3->getObjectInfo(BUCKET_NAME, DIR_CASE_FILES_S3_FOLDER . $filename);
        //echo "<pre>";
        //print_r($info);exit;
        if ($info) {
            $fileurl = $this->generateTemporaryURL(DIR_CASE_FILES_S3 . $filename);
            //$file_path = DIR_CASE_FILES_S3.$filename;
            //print $fileurl;exit;
            $file_path = $fileurl;
        } else {
            $var = "<table align='center' width='100%'><tr><td style='font:bold 12px verdana;color:#FF0000;' align='center'>Oops! File not found.<br/> File may be deleted or make sure you specified correct file name.</td></tr></table>";
            die($var);
        }
        /* Figure out the MIME type | Check in array */
        $known_mime_types = array(
            "pdf" => "application/pdf",
            "txt" => "text/plain",
            "html" => "text/html",
            "htm" => "text/html",
            "exe" => "application/octet-stream",
            "zip" => "application/zip",
            "doc" => "application/msword",
            "xls" => "application/vnd.ms-excel",
            "ppt" => "application/vnd.ms-powerpoint",
            "gif" => "image/gif",
            "png" => "image/png",
            "jpeg" => "image/jpg",
            "jpg" => "image/jpg",
            "php" => "text/plain"
        );
        $file_extension = strtolower(substr(strrchr($filename, "."), 1));
        if (array_key_exists($file_extension, $known_mime_types)) {
            $mime_type = $known_mime_types[$file_extension];
        } else {
            $mime_type = "application/force-download";
        };
        //$mime_type = "application/force-download";
        // Send file headers 
        header("Content-type: $mime_type");
        //header('Content-Length: '.$info['size']);
        //header("Content-Disposition: attachment;filename=$filename");
        header("Content-Disposition: attachment;filename=$chk");
        header('Pragma: no-cache');
        header('Expires: 0');
        //$file_path = DIR_CASE_FILES_S3.$filename;
        // Send the file contents.
        readfile($file_path);
    }

    function downloadFile1($filename) {
        set_time_limit(0);
        if (!isset($filename) || empty($filename)) {
            $var = "<table align='center' width='100%'><tr><td style='font:bold 14px verdana;color:#FF0000;' align='center'>Please specify a file name for download.</td></tr></table>";
            die($var);
        }

        if (strpos($filename, "\0") !== FALSE)
            die('');
        $fname = basename($filename);

        if (file_exists(DIR_CASE_FILES . $fname)) {
            $file_path = DIR_CASE_FILES . $fname;
        } else {
            $var = "<table align='center' width='100%'><tr><td style='font:bold 12px verdana;color:#FF0000;' align='center'>Oops! File not found.<br/> File may be deleted or make sure you specified correct file name.</td></tr></table>";
            die($var);
        }
        $fsize = filesize($file_path);

        $fext = strtolower(substr(strrchr($fname, "."), 1));

        if (!isset($_GET['fc']) || empty($_GET['fc'])) {
            $asfname = $fname;
        } else {
            $asfname = str_replace(array('"', "'", '\\', '/'), '', $_GET['fc']);
            if ($asfname === '')
                $asfname = 'NoName';
        }

        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: public");
        header("Content-Description: File Transfer");
        header("Content-Type: ");
        header("Content-Disposition: attachment; filename=\"$asfname\"");
        header("Content-Transfer-Encoding: binary");
        header("Content-Length: " . $fsize);

        $file = @fopen($file_path, "rb");
        if ($file) {
            while (!feof($file)) {
                print(fread($file, 1024 * 8));
                flush();
                if (connection_status() != 0) {
                    @fclose($file);
                    die();
                }
            }
            @fclose($file);
        }
    }

    function chnageUploadedFileName($filename) {
        //commented because: creating problem for korean languange	
        //$output = preg_replace('/[^(\x20-\x7F)]*/','', $filename); 
        $output = $filename;
        $rep1 = str_replace("~", "_", $output);
        $rep2 = str_replace("!", "_", $rep1);
        $rep3 = str_replace("@", "_", $rep2);
        $rep4 = str_replace("#", "_", $rep3);
        $rep5 = str_replace("%", "_", $rep4);
        $rep6 = str_replace("^", "_", $rep5);
        $rep7 = str_replace("&", "_", $rep6);
        $rep11 = str_replace("+", "_", $rep7);
        $rep13 = str_replace("=", "_", $rep11);
        $rep14 = str_replace(":", "_", $rep13);
        $rep15 = str_replace("|", "_", $rep14);
        $rep16 = str_replace("\"", "_", $rep15);
        $rep17 = str_replace("?", "_", $rep16);
        $rep18 = str_replace(",", "_", $rep17);
        $rep19 = str_replace("'", "_", $rep18);
        $rep20 = str_replace("$", "_", $rep19);
        $rep21 = str_replace(";", "_", $rep20);
        $rep22 = str_replace("`", "_", $rep21);
        $rep23 = str_replace(" ", "_", $rep22);
        $rep28 = str_replace("/", "_", $rep23);
        $rep29 = str_replace("�", "_", $rep28);
        $rep30 = str_replace("�", "_", $rep29);
        return $rep30;
    }

    function validateFileExt($ext) {
        //$extList = array("bat","com","cpl","dll","exe","msi","msp","pif","shs","sys","cgi","reg","bin","torrent","yps","mp4","mpeg","mpg","3gp","dat","mod","avi","flv","xvid","scr","com","pif","chm","cmd","cpl","crt","hlp","hta","inf","ins","isp","jse?","lnk","mdb","ms","pcd","pif","scr","sct","shs","vb","ws","vbs","mp3","wav");
        $extList = array("bat", "com", "cpl", "dll", "exe", "msi", "msp", "pif", "shs", "sys", "cgi", "reg", "bin", "torrent", "yps", "mpg", "dat", "xvid", "scr", "com", "pif", "chm", "cmd", "cpl", "crt", "hlp", "hta", "inf", "ins", "isp", "jse?", "lnk", "mdb", "ms", "pcd", "pif", "scr", "sct", "shs", "vb", "ws", "vbs");

        $ext = strtolower($ext);
        if (!in_array($ext, $extList)) {
            return "success";
        } else {
            //alert("Invalid input file format! Should be txt, doc, docx, xls, xlsx, pdf, odt, ppt, jpeg, tif, gif, psd, jpg or png");
            return "." . $ext;
        }
    }

    function formatText($value) {
        $value = str_replace("�", "\"", $value);
        $value = str_replace("�", "\"", $value);
        $value = preg_replace('/[^(\x20-\x7F)\x0A]*/', '', $value);
        $value = stripslashes($value);
        $value = html_entity_decode($value, ENT_QUOTES);
        $trans = get_html_translation_table(HTML_ENTITIES, ENT_QUOTES);
        $value = strtr($value, $trans);
        $value = stripslashes(trim($value));
        return $value;
    }

    function chgdate($val) {
        $dt = explode("/", $val);
        $dateformat = $dt['2'] . "-" . $dt['0'] . "-" . $dt['1'];
        return $dateformat;
    }

    function dateFormatReverse($output_date) {
        if ($output_date != "") {
            if (strstr($output_date, " ")) {
                $exp = explode(" ", $output_date);
                $od = $exp[0];
                $date_ex2 = explode("-", $od);
                $dateformated_input = $date_ex2[1] . "/" . $date_ex2[2] . "/" . $date_ex2[0] . " " . $exp[1];
            } else {
                $exp = explode("-", $output_date);
                $dateformated_input = $exp[1] . "/" . $exp[2] . "/" . $exp[0];
            }
            return $dateformated_input;
        }
    }

    function makeSeoUrl($url) {
        if ($url) {
            $url = trim(strtolower($url));
            $url = str_replace(' ', '', $url); // Replaces all spaces .
            $value = preg_replace('/[^A-Za-z0-9\-]/', '', $url); // Removes special chars.
            //$value = preg_replace("![^a-z0-9]+!i", "", $url);
            $url = trim($value);
        }
        return $url;
    }

    function makeShortName($first, $last) {
        if (stristr($first, " ")) {
            $firstexp = explode(" ", $first);
            $let1 = substr($firstexp[0], 0, 1);
            $let2 = substr($firstexp[1], 0, 1);
        } else {
            $let1 = substr($first, 0, 2);
        }
        $let3 = substr($last, 0, 1);

        return strtoupper($let1 . $let2 . $let3);
    }

    function fullSpace($used, $totalsize = 1024) {
        $full = $used * 100 / $totalsize;
        $used = round($full, 1);
        return $used;
    }

    function usedSpace($curProjId = NULL, $company_id = SES_COMP) {
        $CaseFiles = ClassRegistry::init('CaseFiles');
        $this->recursive = -1;
        $cond = " 1 ";
        if ($company_id) {
            $cond .=" AND company_id=" . $company_id;
        }
        if ($curProjId) {
            $cond .=" AND project_id=" . $curProjId;
        }
        $sql = "SELECT SUM(file_size) AS file_size  FROM case_files   WHERE " . $cond;
        $res1 = $CaseFiles->query($sql);
        $filesize = $res1['0']['0']['file_size'] / 1024;
        return number_format($filesize, 2);
    }

    function shortLength($value, $len, $wrap = true) {
        $value_format = $this->formatText($value);
        $value_raw = html_entity_decode($value_format, ENT_QUOTES);
        if (strlen($value_raw) > $len) {
            $value_strip = substr($value_raw, 0, $len);
            $value_strip = $this->formatText($value_strip);
            if ($wrap) {
                $lengthvalue = "<span title='" . $value_format . "' >" . $value_strip . "...</span>";
            } else {
                $lengthvalue = $value_strip . "...";
            }
        } else {
            $lengthvalue = $value_format;
        }
        return $lengthvalue;
    }

    function dateFormatOutputdateTime_day($date_time, $curdate = NULL, $type = NULL) {
        if ($date_time != "") {
            $date_time = date("Y-m-d H;i:s", strtotime($date_time));
            $output = explode(" ", $date_time);
            $date_ex2 = explode("-", $output[0]);

            $dateformated = $date_ex2[1] . "/" . $date_ex2[2] . "/" . $date_ex2[0];
            if ($date_ex2[2] != "00") {
                $displayWeek = 0;
                $timeformat = date('g:i a', strtotime($date_time));

                $week1 = date("l", mktime(0, 0, 0, $date_ex2[1], $date_ex2[2], $date_ex2[0]));
                $week_sub1 = substr($week1, "0", "3");

                $yesterday = date("Y-m-d", strtotime($curdate . "-1 days"));

                if ($dateformated == $this->dateFormatReverse($curdate)) {
                    $dateTime_Format = "Today";
                } elseif ($dateformated == $this->dateFormatReverse($yesterday)) {
                    $dateTime_Format = "Y'day";
                } else {
                    $CurYr = date("Y", strtotime($curdate));
                    $DateYr = date("Y", strtotime($dateformated));
                    if ($CurYr == $DateYr) {
                        $dateformated = date("M d", strtotime($dateformated));
                        $dtformated = date("M d", strtotime($dateformated)) . ", " . date("D", strtotime($dateformated));
                        $displayWeek = 1;
                    } else {
                        $dateformated = date("M d, Y", strtotime($dateformated));
                        $dtformated = date("M d, Y", strtotime($dateformated));
                    }
                    $dateTime_Format = $dateformated;
                }

                if ($type == 'date') {
                    return $dateTime_Format;
                } elseif ($type == 'time') {
                    return $dateTime_Format . " " . $timeformat;
                } elseif ($type == 'week') {
                    if ($dateTime_Format == "Today" || $dateTime_Format == "Y'day" || !$displayWeek) {
                        //return $dateTime_Format;
                        return $dtformated;
                    } else {
                        return $dateTime_Format . ", " . date("D", strtotime($dateformated));
                    }
                } else {
                    if ($dateTime_Format == "Today" || $dateTime_Format == "Y'day") {
                        return $dateTime_Format . " " . $timeformat;
                    } else {
                        //return $dateTime_Format.", ".date("D",strtotime($dateformated))." ".$timeformat;
                        //return $dateTime_Format.", ".date("Y",strtotime($dateformated))." ".$timeformat;
                        return $dtformated . " " . $timeformat;
                    }
                }
            }
        }
    }

    function GetDateTime($timezoneid, $gmt_offset, $dst_offset, $timezone_code, $db_date, $type) {
        $dst = 1;
        if (!$timezoneid) {
            return date('Y-m-d H:i');
        }
        if ($type == "revdate") {
            $exp = explode(" ", $db_date);
            $exp_d = explode("-", $exp[0]);
            $exp_t = explode(":", $exp[1]);

            if ($gmt_offset != 0) {
                $sign1 = substr($gmt_offset, 0, 1);
                $value = substr($gmt_offset, 1, -4);

                if ($this->isDaylightSaving($timezoneid, $gmt_offset)) {
                    $value = $value - $dst_offset;
                } else {
                    $value = $value + $dst_offset;
                }
                if ($sign1 == "+") {

                    return date("Y-m-d", mktime($exp_t[0] - $value, $exp_t[1], $exp_t[2], $exp_d[1], $exp_d[2], $exp_d[0]));
                } elseif ($sign1 == "-") {
                    return date("Y-m-d", mktime($exp_t[0] - $value, $exp_t[1], $exp_t[2], $exp_d[1], $exp_d[2], $exp_d[0]));
                } else {
                    return date("Y-m-d", mktime($exp_t[0] - $value, $exp_t[1], $exp_t[2], $exp_d[1], $exp_d[2], $exp_d[0]));
                }
            } else {
                return date("Y-m-d", mktime($exp_t[0], $exp_t[1], $exp_t[2], $exp_d[1], $exp_d[2], $exp_d[0]));
            }
        } else {
            if ($dst_offset > 0) {
                if (!($dst)) {
                    $dst_offset = 0;
                } else if (!$this->isDaylightSaving($timezoneid, $gmt_offset)) {
                    $dst_offset = 0;
                }
            }
            $dst_offset *= 60;
            $gmt_offset *= 60;

            $exp = explode(" ", $db_date);
            $exp_d = explode("-", $exp[0]);
            $exp_t = explode(":", $exp[1]);

            $gmt_hour = $exp_t[0];
            $gmt_minute = $exp_t[1];
            $gmt_secs = $exp_t[2];



            $time = $gmt_hour * 60 + $gmt_minute + $gmt_offset + $dst_offset;
            if ($type == "datetime") {
                return date('Y-m-d H:i:s', mktime($time / 60, $time % 60, $gmt_secs, $exp_d[1], $exp_d[2], $exp_d[0]));
            } elseif ($type == "date") {

                return date('Y-m-d', mktime($time / 60, $time % 60, $gmt_secs, $exp_d[1], $exp_d[2], $exp_d[0]));
            } elseif ($type == "time") {
                return date('H-i-s', mktime($time / 60, $time % 60, $gmt_secs, $exp_d[1], $exp_d[2], $exp_d[0]));
            } elseif ($type == "dateFormat") {
                return date('m/d/Y', mktime($time / 60, $time % 60, $gmt_secs, $exp_d[1], $exp_d[2], $exp_d[0]));
            } elseif ($type == "header") {
                return date('l, F j Y h:i A', mktime($time / 60, $time % 60, $gmt_secs, $exp_d[1], $exp_d[2], $exp_d[0]));
            } elseif ($type == "td") {
                return date('"G.i"', mktime($time / 60, $time % 60, $gmt_secs, $exp_d[1], $exp_d[2], $exp_d[0]));
            }
        }
    }

    function dateFormatOutputdateTime_day_EXPORT($date_time, $curdate = NULL, $type = NULL) {
        if ($date_time != "") {
            $date_time = date("Y-m-d H:i:s", strtotime($date_time));
            $output = explode(" ", $date_time);
            $date_ex2 = explode("-", $output[0]);

            $dateformated = $date_ex2[1] . "/" . $date_ex2[2] . "/" . $date_ex2[0];
            if ($date_ex2[2] != "00") {
                $displayWeek = 0;
                $timeformat = date('g:i a', strtotime($date_time));

                $week1 = date("l", mktime(0, 0, 0, $date_ex2[1], $date_ex2[2], $date_ex2[0]));
                $week_sub1 = substr($week1, "0", "3");

                $yesterday = date("Y-m-d", strtotime($curdate . "-1 days"));

                if ($dateformated == $this->dateFormatReverse($curdate)) {
                    $dateTime_Format = "Today";
                } elseif ($dateformated == $this->dateFormatReverse($yesterday)) {
                    $dateTime_Format = "Y'day";
                } else {
                    $CurYr = date("Y", strtotime($curdate));
                    $DateYr = date("Y", strtotime($dateformated));
                    if ($CurYr == $DateYr) {
                        $dateformated = date("m/d", strtotime($dateformated));
                        $displayWeek = 1;
                    } else {
                        $dateformated = date("M d Y", strtotime($dateformated));
                    }
                    $dateTime_Format = $dateformated;
                }

                if ($type == 'date') {
                    return $dateTime_Format;
                } elseif ($type == 'time') {
                    return $dateTime_Format . " " . $timeformat;
                } elseif ($type == 'week') {
                    if ($dateTime_Format == "Today" || $dateTime_Format == "Y'day" || !$displayWeek) {
                        return $dateTime_Format;
                    } else {
                        return $dateTime_Format . ", " . date("D", strtotime($dateformated));
                    }
                } else {
                    if ($dateTime_Format == "Today" || $dateTime_Format == "Y'day") {
                        return $dateTime_Format . " " . $timeformat;
                    } else {
                        return $dateTime_Format . ", " . date("D", strtotime($dateformated)) . " " . $timeformat;
                    }
                }
            }
        }
    }

    function mdyFormat($date_time, $type = NULL) {
        if ($date_time != "") {
            $date_time = date("Y-m-d H:i:s", strtotime($date_time));
            $output = explode(" ", $date_time);
            $date_ex2 = explode("-", $output[0]);

            $dateformated = $date_ex2[1] . "/" . $date_ex2[2] . "/" . $date_ex2[0];
            if ($date_ex2[2] != "00") {

                $timeformat = date('g:i a', strtotime($date_time));
                $dateformated = date("m/d/Y", strtotime($dateformated));
                $dateTime_Format = $dateformated;

                if ($type == 'time') {
                    return $dateTime_Format . " " . $timeformat;
                } else {
                    return $dateTime_Format;
                }
            }
        }
    }

    function checkEmailExists($betaEmail) {
        $BetaUser = ClassRegistry::init('BetaUser');
        $BetaUser->recursive = -1;

        $findUserEmail = $BetaUser->find('first', array('conditions' => array('BetaUser.email' => $betaEmail), 'fields' => array('BetaUser.id', 'BetaUser.is_approve')));

        $id = $findUserEmail['BetaUser']['id'];
        $is_approve = $findUserEmail['BetaUser']['is_approve'];

        if ($id) {
            $User = ClassRegistry::init('User');
            $User->recursive = -1;
            $findUser = $User->find('count', array('conditions' => array('User.email' => $betaEmail), 'fields' => array('User.id')));

            if ($findUser) {
                return 1; //Present in both user table and betauser table  //User Already Exists
            } else {
                if ($is_approve == 1) {
                    return 2; //Present in beta table but not in user table and is_approve in 1  //Your beta user has been approved
                } else {
                    return 3; //Present in beta table but not in user table and is_approve in 0  //Your beta user has been disapproved
                }
            }
        } else {
            $User = ClassRegistry::init('User');
            $User->recursive = -1;
            $findUser = $User->find('count', array('conditions' => array('User.email' => $betaEmail), 'fields' => array('User.id')));

            if ($findUser) {
                return 4; //Present in user table and not present in betauser table  //User Already Exists
            } else {
                return 5; //Not present in both user and beta user table
            }
        }
    }

    function isValidDateTime($dateTime) {
        if (preg_match("/^(\d{1,2})\/(\d{1,2})\/(\d{2,4})$/", $dateTime, $matches)) {
            if (checkdate($matches[1], $matches[2], $matches[3])) {
                return true;
            }
        }
        return false;
    }

    function convert_ascii($string) {
        // Replace Single Curly Quotes
        $search[] = chr(226) . chr(128) . chr(152);
        $replace[] = "'";
        $search[] = chr(226) . chr(128) . chr(153);
        $replace[] = "'";

        // Replace Smart Double Curly Quotes
        $search[] = chr(226) . chr(128) . chr(156);
        $replace[] = '\"';
        $search[] = chr(226) . chr(128) . chr(157);
        $replace[] = '\"';

        // Replace En Dash
        $search[] = chr(226) . chr(128) . chr(147);
        $replace[] = '--';

        // Replace Em Dash
        $search[] = chr(226) . chr(128) . chr(148);
        $replace[] = '---';

        // Replace Bullet
        $search[] = chr(226) . chr(128) . chr(162);
        $replace[] = '*';

        // Replace Middle Dot
        $search[] = chr(194) . chr(183);
        $replace[] = '*';

        // Replace Ellipsis with three consecutive dots
        $search[] = chr(226) . chr(128) . chr(166);
        $replace[] = '...';

        $search[] = chr(150);
        $replace[] = "-";

        // Apply Replacements
        $string = str_replace($search, $replace, $string);

        // Remove any non-ASCII Characters
        //$string = preg_replace("/[^\x01-\x7F]/","", $string);
        return $string;
    }

    /**
     * @method public iptolocation(string $ip) Detect the location from IP
     * @author GDR<support@ornagescrum.com>
     * @return string  Location fromt the ip
     */
    function validate_ip($ip) {
        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) === false) {
            return false;
        }
        return true;
    }

    function getRealIpAddr() {
        /* try {
          $ipaddress = file_get_contents("http://www.telize.com/jsonip");
          $ipaddress = json_decode($ipaddress,true);
          if(isset($ipaddress['ip']) && ip2long($ipaddress['ip'])) {
          $ip = $ipaddress['ip'];
          }
          }catch(Exception $e){
          return $ip;
          } */

        $ip_keys = array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR');
        foreach ($ip_keys as $key) {
            if (array_key_exists($key, $_SERVER) === true) {
                foreach (explode(',', $_SERVER[$key]) as $ip) {
                    // trim for safety measures
                    $ip = trim($ip);
                    // attempt to validate IP
                    if ($this->validate_ip($ip)) {
                        return $ip;
                    }
                }
            }
        }
        return isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : false;
    }

    function is_private_ip($ip) {
        if (empty($ip) or !ip2long($ip)) {
            return false;
        }
        $private_ips = array(
            array('10.0.0.0', '10.255.255.255'),
            array('172.16.0.0', '172.31.255.255'),
            array('192.168.0.0', '192.168.255.255')
        );
        $ip = ip2long($ip);
        foreach ($private_ips as $ipr) {
            $min = ip2long($ipr[0]);
            $max = ip2long($ipr[1]);
            if (($ip >= $min) && ($ip <= $max))
                return true;
        }
        return false;
    }

    function iptoloccation($ip) {
        if ($this->is_private_ip($ip)) {
            return $ip . " - PRIVATE NETWORK";
        }

        $data = file_get_contents('http://api.ipinfodb.com/v3/ip-city/?key=' . IP2LOC_API_KEY . '&ip=' . $ip . '&format=json');
        $data = json_decode($data, true);

        if (isset($data['cityName']) && trim(trim($data['cityName']), '-')) {
            $location = $data['cityName'] . ", " . $data['regionName'] . ", " . $data['countryName'] . ", Lat/Lon: " . $data['latitude'] . "," . $data['longitude'] . ", IP: " . $ip;
        } else {
            $data = file_get_contents('http://ip-api.com/json');
            $data = json_decode($data, true);
            $location = $data['city'] . ", " . $data['regionName'] . ", " . $data['country'] . ", Lat/Lon: " . $data['lat'] . "," . $data['lon'] . ", IP: " . $data['query'];
        }
        return $location;
    }

    /**
     * @method: PUBLIC generate_invoiceid() 
     */
    function generate_invoiceid() {
        $trnsclas = ClassRegistry::init('Transaction');
        $trnsclas->recursive = -1;
        $trans = $trnsclas->find('first', array('conditions' => ('invoice_id IS NOT NULL'), 'order' => 'id DESC', 'fields' => array('invoice_id')));

        if ($trans) {
            $prv_invoice_id = (int) $trans['Transaction']['invoice_id'];
            if ($prv_invoice_id == 1) {
                $prv_invoice_id = 153702;
            }
            $prv_invoice_id = (int) $trans['Transaction']['invoice_id'] + 1;
        } else {
            $prv_invoice_id = 153700;
        }
        $current_invoice_id = str_pad($prv_invoice_id, 6, 0, STR_PAD_LEFT);
        return $current_invoice_id;
    }

    function getRemoteIP() {
        $ipaddress = '';
        if ($_SERVER['HTTP_CLIENT_IP'])
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if ($_SERVER['HTTP_X_FORWARDED_FOR'])
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if ($_SERVER['HTTP_X_FORWARDED'])
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if ($_SERVER['HTTP_FORWARDED_FOR'])
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if ($_SERVER['HTTP_FORWARDED'])
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if ($_SERVER['REMOTE_ADDR'])
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';

        return $ipaddress;
    }

    /**
     * 
     * @param type $source
     * @param type $destination
     * @param string $flag
     * @return boolean
     */
    function zipFile($source, $destination, $flag = '') {
        if (!extension_loaded('zip') || !file_exists($source)) {
            return false;
        }
        $zip = new ZipArchive();
        if (!$zip->open($destination, ZIPARCHIVE::CREATE)) {
            return false;
        }
        $source = str_replace('\\', '/', realpath($source));
        if ($flag) {
            $flag = basename($source) . '/';
            //$zip->addEmptyDir(basename($source) . '/');
        }

        if (is_dir($source) === true) {
            $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($source), RecursiveIteratorIterator::SELF_FIRST);
            foreach ($files as $file) {
                $arr[] = $file->getFileName();
                if ($file->getFileName() == '.' || $file->getFileName() == '..')
                    continue;
                $file = str_replace('\\', '/', realpath($file));
                if (is_dir($file) === true) {
                    $zip->addEmptyDir(str_replace($source . '/', '', $flag . $file . '/'));
                } else if (is_file($file) === true) {
                    $zip->addFromString(str_replace($source . '/', '', $flag . $file), file_get_contents($file));
                }
            }
        } else if (is_file($source) === true) {
            $zip->addFromString($flag . basename($source), file_get_contents($source));
        }
        return $zip->close();
    }

    function get_formated_date($value = '') {
        if ((!empty($value['start_date']) && !is_null($value['start_date']) && $value['start_date'] != '0000-00-00') && ($value['end_date'] != '' && !is_null($value['end_date']) && $value['end_date'] != '0000-00-00')) {

            $start = $value['start_date'];
            $end = $value['end_date'];
            $color = $colors[$key];
        } else if ((empty($value['start_date']) || is_null($value['start_date']) || $value['start_date'] == '0000-00-00') && ($value['end_date'] != '' && !is_null($value['end_date']) && $value['end_date'] != '0000-00-00')) {

            $start = $value['created'];
            $end = $value['end_date'];
            $color = $colors[$key];
        } else if ((!empty($value['start_date']) && !is_null($value['start_date']) && $value['start_date'] != '0000-00-00') && ($value['end_date'] == '' || is_null($value['end_date']) || $value['end_date'] == '0000-00-00')) {

            $start = $value['start_date'];
            $end = date('Y-m-d', $this->dateConvertion($value['start_date']));
            $color = $colors[$key];
        } else {

            $start = explode(' ', $value['created']);
            $start = $start[0];
            $end = date('Y-m-d', $this->dateConvertion($value['created']));
            $color = $colors[$key];
        }
        /* convert to user timezone */
        $start = $this->convert_date_timezone($start);
        $end = $this->convert_date_timezone($end);

        $json_arr['duration'] = $this->days_diff($start, $end) + 1;
        $json_arr['o_start'] = $start;
        $json_arr['o_end'] = $end;

        $json_arr['color'] = $color;
        // convert to millisec
        $json_arr['start'] = strtotime($start) * 1000;
        $json_arr['end'] = strtotime($end) * 1000;
        return $json_arr;
    }

    function days_diff($from = '', $to = '') {
        $from_date = strtotime($from); // or your date as well
        $to_date = strtotime($to);
        $datediff = $to_date - $from_date;
        return floor($datediff / (60 * 60 * 24)) > 1 ? floor($datediff / (60 * 60 * 24)) : 1;
    }

    function convert_date_timezone($date = '') {
        if (trim($date == '')) {
            $date = date('Y-m-d H:i:s');
        }
        return $date;
        #return $this->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $date, "date");
    }

    function format_date($date = '', $format = 'date') {
        if ($format == 'date') {
            return date('Y-m-d', strtotime($date));
        } else {
            return date('Y-m-d H:i:s', strtotime($date));
        }
    }

    /* Author: GKM
     * to format sec to hr min
     */

    function format_time_hr_min($totalsecs = '', $typ = null) {
        if ($typ) {
            $hours = floor($totalsecs / 3600) > 0 ? floor($totalsecs / 3600) : '00';
            $hours_txt = floor($totalsecs / 3600) > 1 ? 's' : '';
            $mins = round(($totalsecs % 3600) / 60) > 0 ? round(($totalsecs % 3600) / 60) : '00';
            $mins_txt = round(($totalsecs % 3600) / 60) > 1 ? 's' : '';
            $str = '<div style="text-align: center;color:#666;margin-top:-20px"><span style="font-size:40px;margin-right:7px;color:#3986BA">' . $hours . '<span style="font-size:20px;"> hr' . $hours_txt . ' </span></span><span style="font-size:40px;color:#3986BA">' . $mins . '<span style="font-size:20px;"> min' . $mins_txt . '</span></span></div>';
            return $str;
        } else {
            $hours = floor($totalsecs / 3600) > 0 ? floor($totalsecs / 3600) . " hr" . (floor($totalsecs / 3600) > 1 ? 's' : '') . " " : '';
            $mins = round(($totalsecs % 3600) / 60) > 0 ? "" . round(($totalsecs % 3600) / 60) . " min" . (round(($totalsecs % 3600) / 60) > 1 ? 's' : '') : '';
            return $hours . "" . $mins;
        }
    }

    /* By GKM
     * used to generate invoice number
     */

    function invoice_number($invoice, $prefix = 'MCIN') {
        $invoice_code = $prefix . str_pad($invoice, 6, "0", STR_PAD_LEFT);
        /* $invoice_code = 'MCIN';
          if ($invoice < 10) {
          $invoice_code .= '000';
          } elseif ($invoice < 100) {
          $invoice_code .= '00';
          } elseif ($invoice < 1000) {
          $invoice_code .= '0';
          } else {
          $invoice_code .= '';
          }
          $invoice_code .= $invoice; */
        #$invoice_code .= mt_rand(0, 999999);
        return $invoice_code;
    }

    /* By GKM
     * used to format price value
     */

    function format_price($price) {
        return number_format($price, 2, '.', '');
    }

    /* author: GKM
     * it is used to format 24 hr to 12 hr with am / pm format
     */

    function format_24hr_to_12hr($time) {
        $out_time_arr = explode(":", $time);
        $out_mode = intval($out_time_arr[0]) < 12 ? 'am' : 'pm';
        $out_hr = intval($out_time_arr[0]) > 12 ? intval($out_time_arr[0]) - 12 : intval($out_time_arr[0]);
        $out_min = intval($out_time_arr[1]);
        return ($out_hr > 0 ? $out_hr : 12) . ':' . ($out_min < 10 ? '0' : '') . $out_min . '' . $out_mode;
    }

    /* by GKM
     * for removing special characters
     */

    function seo_url($string = '', $flag = '-') {
        if (trim($string) != '') {
            if ($flag == " ") {
                $output = trim(preg_replace('/[^A-Za-z0-9.]+/i', $flag, $string), $flag);
                $output = preg_replace('/\s+/', ' ', $output);
                $output = str_replace(" ", "_", $output);
            } else {
                $output = trim(preg_replace('/[^A-Za-z0-9]+/i', $flag, $string), $flag);
            }
            return strtolower($output);
        } else {
            return '';
        }
    }

    static function is_image($mime) {
        /* $image_type_to_mime_type = array(
          1 => 'image/gif', // IMAGETYPE_GIF
          2 => 'image/jpeg', // IMAGETYPE_JPEG
          3 => 'image/png', // IMAGETYPE_PNG
          4 => 'application/x-shockwave-flash', // IMAGETYPE_SWF
          5 => 'image/psd', // IMAGETYPE_PSD
          6 => 'image/bmp', // IMAGETYPE_BMP
          7 => 'image/tiff', // IMAGETYPE_TIFF_II (intel byte order)
          8 => 'image/tiff', // IMAGETYPE_TIFF_MM (motorola byte order)
          9 => 'application/octet-stream', // IMAGETYPE_JPC
          10 => 'image/jp2', // IMAGETYPE_JP2
          11 => 'application/octet-stream', // IMAGETYPE_JPX
          12 => 'application/octet-stream', // IMAGETYPE_JB2
          13 => 'application/x-shockwave-flash', // IMAGETYPE_SWC
          14 => 'image/iff', // IMAGETYPE_IFF
          15 => 'image/vnd.wap.wbmp', // IMAGETYPE_WBMP
          16 => 'image/xbm', // IMAGETYPE_XBM
          'gif' => 'image/gif', // IMAGETYPE_GIF
          'jpg' => 'image/jpeg', // IMAGETYPE_JPEG
          'jpeg' => 'image/jpeg', // IMAGETYPE_JPEG
          'png' => 'image/png', // IMAGETYPE_PNG
          'bmp' => 'image/bmp', // IMAGETYPE_BMP
          'ico' => 'image/x-icon',
          ); */
        $image_type_to_mime_type = array(
            'gif' => 'image/gif', // IMAGETYPE_GIF
            'jpg' => 'image/jpeg', // IMAGETYPE_JPEG
            'jpeg' => 'image/jpeg', // IMAGETYPE_JPEG
            'png' => 'image/png', // IMAGETYPE_PNG
            'bmp' => 'image/bmp', // IMAGETYPE_BMP
        );

        return (in_array($mime, $image_type_to_mime_type) ? true : false);
    }

    function date_filter($filter = '', $curDateTime = '') {
        $curDateTime = $curDateTime != "" ? $curDateTime : date('Y-m-d H:i:s');
        $data = array();
        $month = date("m", strtotime($curDateTime . ($filter == 'lastquarter' ? " -3 months" : "")));
        if ($month < 4) {
            $start = 'first day of january';
            $end = 'last day of march';
        } elseif ($month > 3 && $month < 7) {
            $start = 'first day of april';
            $end = 'last day of june';
        } elseif ($month > 6 && $month < 10) {
            $start = 'first day of july';
            $end = 'last day of september';
        } elseif ($month > 9) {
            $start = 'first day of october';
            $end = 'last day of december';
        }
        switch ($filter) {
            case 'today':
                $data['strddt'] = date('Y-m-d', strtotime($curDateTime));
                break;
            case 'yesterday':
                $data['strddt'] = date('Y-m-d', strtotime($curDateTime . ' -1 day'));
                break;
            case 'thisweek':
                $data['strddt'] = date('Y-m-d', strtotime('last monday', strtotime($curDateTime)));
                $data['enddt'] = date('Y-m-d', strtotime($curDateTime));
                break;
            case 'thismonth':
                $data['strddt'] = date('Y-m-d', strtotime('first day of this month', strtotime($curDateTime)));
                $data['enddt'] = date('Y-m-d', strtotime($curDateTime));
                break;
            case 'thisquarter':
                $data['strddt'] = date('Y-m-d', strtotime($start, strtotime($curDateTime)));
                $data['enddt'] = date('Y-m-d', strtotime($curDateTime));
                break;
            case 'thisyear':
                $data['strddt'] = date('Y-m-d', strtotime('first day of January', strtotime($curDateTime)));
                $data['enddt'] = date('Y-m-d', strtotime($curDateTime));
                break;
            case 'lastweek':
                $data['strddt'] = date('Y-m-d', strtotime('last monday', strtotime($curDateTime . " -7 days")));
                $data['enddt'] = date('Y-m-d', strtotime('next sunday', strtotime($curDateTime . " -7 days")));
                break;
            case 'lastmonth':
                $data['strddt'] = date('Y-m-d', strtotime('first day of this month', strtotime($curDateTime . " -1 month")));
                $data['enddt'] = date('Y-m-d', strtotime('last day of this month', strtotime($curDateTime . " -1 month")));
                break;
            case 'lastquarter':
                $data['strddt'] = date('Y-m-d', strtotime($start, strtotime($curDateTime)));
                $data['enddt'] = date('Y-m-d', strtotime($end, strtotime($curDateTime)));
                break;
            case 'lastyear':
                $data['strddt'] = date('Y-m-d', strtotime('first day of January', strtotime($curDateTime . ' -1 year')));
                $data['enddt'] = date('Y-m-d', strtotime('last day of December', strtotime($curDateTime . ' -1 year')));
                break;
            case 'last365days':
                $data['strddt'] = date('Y-m-d', strtotime($curDateTime . " -364 days"));
                $data['enddt'] = date('Y-m-d', strtotime($curDateTime));
                break;
            case 'alldates':
                /* unset($data['strddt']);unset($data['enddt']);$timelog_filter_msg = ''; */
                break;
            case 'custom':break;
            default:break;
        }
        return $data;
    }

    function getCurlData($url) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_TIMEOUT, 10);
        #curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.2.16) Gecko/20110319 Firefox/3.6.16");
        $curlData = curl_exec($curl);
        curl_close($curl);
        pr($curlData);
        exit;
        return $curlData;
    }

    function getUniqBookingReferenceCode() {
        $code = $this->genRandomString(10, 'uppercase');
        $BusinessBooking = ClassRegistry::init('BusinessBooking');
        $BusinessBooking->recursive = -1;
        if ($BusinessBooking->hasAny(array('BusinessBooking.reference_code' => $code))) {
            $this->getUniqBookingReferenceCode();
        }
        return $code;
    }

    public static function deleteDir($dirPath) {
        if (!is_dir($dirPath)) {
            throw new InvalidArgumentException("$dirPath must be a directory");
        }
        if (substr($dirPath, strlen($dirPath) - 1, 1) != DS) {
            $dirPath .= DS;
        }
        $files = glob($dirPath . '*', GLOB_MARK);
        foreach ($files as $file) {
            if (is_dir($file)) {
                self::deleteDir($file);
            } else {
                unlink($file);
            }
        }
        return rmdir($dirPath);
    }

    function subscription_status($status, $data = array(), $html = false) {
        $str = '';
        switch ($status) {
            case 0 :$str = $html == true ? "<span class='label label-warning'>Pending</span>" : "Pending";
                break;
            case 2 :$str = $html == true ? "<span class='label label-danger'>Cancelled</span>" : "Cancelled";
                break;
            case $this->is_subscription_expired($data['subscription_start'], $data['listing_period']):
                $str = $html == true ? "<span class='label label-warning'>Expired</span>" : "Expired";
                break;
            default :$str = $html == true ? "<span class='label label-success'>Active</span>" : "Active";
                break;
        }
        return $str;
    }

    function dateFormat($date = '') {
        return strtotime($date) > 0 ? date('M d, Y g:i a', strtotime($date)) : '';
    }

}
