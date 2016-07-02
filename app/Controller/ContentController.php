<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

App::uses('AppController', 'Controller');

/**
 * CakePHP ContentController
 * @author Star 1
 */
class ContentController extends AppController {

    public $helpers = array('Html', 'Form', 'Session', 'Format', 'Time');
    public $components = array('Format');

    function beforeFilter() {
        $this->Auth->allow();
        $this->Auth->deny(array('refer_friend'));
        parent::beforeFilter();
    }

    public function home() {
        #$this->Flash->success(__("Password changed successfully."));
        #$this->Flash->error(__("Password changed successfully."));
        $categories = $this->Format->parent_categories();
        $category_list = Hash::combine($categories, "{n}.Category.id", "{n}.Category.name");
        $cities = $this->Format->cities('list', 'business');
        $location = $this->Session->read('user_location');
        $this->set(compact('categories', 'cities', 'category_list', 'location'));

        /* ad list */
        $this->loadModel('Advertisement');
        $userinfo = $this->Session->read('Auth.User');
        #$user_location = $this->Session->read('user_location');
        $page_view = 5;
        $middleads = $this->Advertisement->getHomeBannerImages($page_view, 3, $userinfo, '', 'home middle');
        $page_view = 4;
        $ads = $this->Advertisement->getHomeBannerImages($page_view, '1', $userinfo, '', 'home');
        $this->set(compact('ads', 'middleads'));
        /* ad list end */
    }

    public function static_page() {
        $this->loadModel('StaticPage');
        $page = $this->params['pass'][0];
        $options = array('conditions' => array('StaticPage.' . 'code' => $page));
        $pagedata = $this->StaticPage->find('first', $options);
        $this->set('pagedata', $pagedata);
    }

    public function categories() {
        #pr($this->params);exit;
    }

    public function blog() {

    }

    function subcats() {
        $this->loadModel('Category');
        $catid = intval($this->data['catid']);
        $data = array();
        if ($catid > 0) {
            $options = array('fields' => array('id', 'name'),
                'conditions' => array('status' => '1', 'parent_id' => $catid),
                'order' => array('name' => 'ASC'));
            $data = $this->Category->find('list', $options);
            $success = '1';
        } else {
            $success = '0';
        }
        $html = "";
        if (is_array($data) && count($data) > 0) {
            foreach ($data as $key => $val) {
                $html .= "<option value='" . $key . "'>" . h($val) . "</option>";
            }
        }
        echo $html;
        exit;
        $ret_arr = array('success' => $success, 'cats' => $data);
        echo json_encode($ret_arr);
        exit;
    }

    function localities() {
        $ctid = intval($this->data['ctid']);
        $data = array();
        if ($ctid > 0) {
            $this->loadModel('Locality');
            $options = array('fields' => array('Locality.id', 'Locality.name'),
                'conditions' => array('Locality.status' => '1', 'Locality.city_id' => $ctid),
                'order' => array('Locality.name' => "ASC"));
            $data = $this->Locality->find('list', $options);
            $success = '1';
        } else {
            $success = '0';
        }
        $html = "";
        if (is_array($data) && count($data) > 0) {
            foreach ($data as $key => $val) {
                $html .= "<option value='" . $key . "'>" . h($val) . "</option>";
            }
        }
        echo $html;
        exit;
        $ret_arr = array('success' => $success, 'lct' => $data);
        echo json_encode($ret_arr);
        exit;
    }

    function reset_password() {
        $this->loadModel('User');
        $mode = isset($this->request->pass[0]) ? $this->request->pass[0] : "reset";
        $verification_code = isset($this->request->query['vc']) ? $this->request->query['vc'] : "";
        if ($verification_code == '') {
            $this->redirect('/');
        }
        $userdetails = $this->User->find('first', array('conditions' => array('User.verification_code' => $verification_code)));

        if (is_array($userdetails) && count($userdetails) > 0) {
            if ($this->request->is('post')) {
                try {
                    $new_password = $this->request->data['User']['new_password'];
                    $re_password = $this->request->data['User']['re_enter_password'];
                    if ($new_password == '') {
                        throw new Exception(__('Please enter new password'));
                    }
                    if ($re_password == '') {
                        throw new Exception(__('Please re-enter new password'));
                    }
                    if ($new_password != $re_password) {
                        throw new Exception(__('Please re-enter password same as new password'));
                    }

                    #pr($this->request);exit;
                    $user_id = $userdetails['User']['id'];

                    /* save password */
                    $password = Security::hash($new_password, 'md5', true);
                    $save_arr = array('id' => $user_id, 'password' => $password, 'verification_code' => '');
                    $this->User->save($save_arr);

                    /* send email to user */
                    $url = trim(HTTP_ROOT, '/') . '/login';
                    $Email = new CakeEmail(Configure::read('EMAIL_DELIVERY_MODE'));
                    $Email->from(array(Configure::read('COMPANY.FROM_EMAIL') => Configure::read('COMPANY.NAME')));
                    $Email->viewVars(array('name' => $userdetails['User']['name'], 'url' => $url));
                    $Email->to($userdetails['User']['email']);
                    $Email->subject('Your Password Updated Successfully - ' . Configure::read('COMPANY.NAME'));
                    $Email->template('confirm_change_password');
                    $Email->send();
                    #$this->Flash->success(__("Password changed successfully."));
                    $this->redirect(array('action' => 'reset_password', 'success'));
                } catch (Exception $exc) {
                    #echo $exc->getTraceAsString();
                    $msg = $exc->getMessage();
                    $this->Flash->error($msg);
                    #$this->redirect(array('action' => 'reset_password', 'error'));
                }
            }
        } else {
            $mode = 'empty';
        }
        #echo $mode;exit;
        $this->set(compact('userdetails', 'mode', 'verification_code'));
    }

    function careers() {

    }

    function press() {
        $this->loadModel('Press');
        $options = array('conditions' => array('Press.status' => '1'), 'order' => array('Press.published_date DESC'));
        $press = $this->Press->find('all', $options);
        $this->set(compact('press'));
    }

    /**
     * Used for saving feedback from users and sending mail to admin.
     * @return type
     */
    function feedback() {
        $title_for_layout = 'Feedback';
        $this->set(compact('title_for_layout'));
        if ($this->request->is('post')) {
            if ($this->Session->check('Auth.User')) {
                $this->request->data['Feedback']['user_id'] = $this->Session->read('Auth.User.id');
            }
            $captcha = trim($this->Captcha->getCode('User.refer_security_code'));
            $this->loadModel('Feedback');
            $this->Feedback->set($this->request->data);
            if (strcmp(trim($this->request->data['User']['refer_security_code']), $captcha) == 0) {
                unset($this->request->data['User']);
                $data = $this->request->data;
                if (is_array($data['Feedback'])) {
                    foreach ($data['Feedback'] as $key => $val) {
                        $data['Feedback'][$key] = trim($val);
                    }
                }
                if ($this->Feedback->save($data)) {

                    $Email = new CakeEmail(Configure::read('EMAIL_DELIVERY_MODE'));
                    $Email->config(array('persistent' => true));

                    $Email->from(array(Configure::read('COMPANY.FROM_EMAIL') => Configure::read('COMPANY.NAME')));
                    $var_array = array('message' => $data['Feedback']['comment'],
                        'number' => $data['Feedback']['phone'],
                        'name' => $data['Feedback']['name'], 'email' => $data['Feedback']['email'],
                        'feedback_type' => $data['Feedback']['feedback_type']);
                    if ($this->Session->check('Auth.User')) {
                        $var_array['user_id'] = $this->Session->read('Auth.User.id');
                    }
                    $Email->viewVars($var_array);
                    $Email->to(Configure::read('COMPANY.ADMIN_EMAIL'));
                    $Email->subject("Feedback Received - " . Configure::read('COMPANY.NAME'));
                    $Email->template('feedback');
                    $Email->send();

                    //Email to user
                    if (trim($data['Feedback']['email']) != '') {
                        $Email->from(array(Configure::read('COMPANY.FROM_EMAIL') => Configure::read('COMPANY.NAME')));
                        $var_array = array('name' => $data['Feedback']['name']);
                        $Email->viewVars($var_array);
                        $Email->to($data['Feedback']['email']);
                        $Email->subject('Thank you for your feedback - ' . Configure::read('COMPANY.NAME'));
                        $Email->template('feedback_ack');
                        $Email->send();
                    }

                    /* smtp disconnect */
                    if (Configure::read('EMAIL_DELIVERY_MODE') == 'smtp') {
                        $Email->disconnect();
                    }

                    $this->Flash->success("We appreciate that you've taken the time to write us. We'll get back to you very soon.");
                    $this->redirect(array('controller' => 'content', 'action' => 'feedback'));
                } else {
                    $this->Flash->error('There was a problem processing your request. Please try again.');
                }
            } else {
                $this->Flash->error(__('Incorrect captcha code! Try again.'));
            }
        }
    }

    /**
     * Used for saving contact us requests to database and sending mail to admin.
     * @return null
     */
    function contact_us() {
        $title_for_layout = 'Contact Us';
        $this->set(compact('title_for_layout'));
        if ($this->request->is('post')) {
            $data = $this->request->data;
            if ($this->Session->check('Auth.User')) {
                $this->request->data['Feedback']['user_id'] = $this->Session->read('Auth.User.id');
            }
            $data['Feedback']['type'] = "contactus";
            if (is_array($data['Feedback'])) {
                foreach ($data['Feedback'] as $key => $val) {
                    $data['Feedback'][$key] = trim($val);
                }
            }
            $this->loadModel('Feedback');
            if ($this->Feedback->save($data)) {
                $Email = new CakeEmail(Configure::read('EMAIL_DELIVERY_MODE'));
                $Email->config(array('persistent' => true));

                $Email->from(array(Configure::read('COMPANY.FROM_EMAIL') => Configure::read('COMPANY.NAME')));
                $var_array = array('message' => $data['Feedback']['comment'],
                    'name' => $data['Feedback']['name'],
                    'subject' => $data['Feedback']['subject'],
                    'email' => $data['Feedback']['email']);
                if ($this->Session->check('Auth.User')) {
                    $var_array['user_id'] = $this->Session->read('Auth.User.id');
                }
                $Email->viewVars($var_array);
                $Email->to(Configure::read('COMPANY.ADMIN_EMAIL'));
                #$Email->subject($data['Feedback']['subject']);
                $Email->subject("Contact Request - " . Configure::read('COMPANY.NAME'));
                $Email->template('contact_us');
                $Email->send();

                //To User
                if ($this->Format->validateEmail($data['Feedback']['email'])) {
                    $Email->from(array(Configure::read('COMPANY.FROM_EMAIL') => Configure::read('COMPANY.NAME')));
                    $var_array = array('name' => $data['Feedback']['name']);
                    if ($this->Session->check('Auth.User')) {
                        $var_array['user_id'] = $this->Session->read('Auth.User.id');
                    }
                    $Email->viewVars($var_array);
                    $Email->to($data['Feedback']['email']);
                    $Email->subject('Thank you for contacting us - ' . Configure::read('COMPANY.NAME'));
                    $Email->template('contact_us_ack');
                    $Email->send();
                }
                if (Configure::read('EMAIL_DELIVERY_MODE') == 'smtp') {
                    $Email->disconnect();
                }
                $this->Flash->success('Thank you ' . $data["Feedback"]["name"] . ' for contacting us. We will get in touch within 1 business day.');
                $this->redirect(array('controller' => 'content', 'action' => 'contact_us'));
            } else {
                $this->Flash->error('There was a problem processing your request. Please try again.');
            }
        }
    }

    function search() {
        #pr($this->Session->read());exit;
    }

    function ajax_search() {
        $this->layout = 'ajax';
        $limit = BUSINESS_SEARCH_PAGE_LIMIT;
        $data = $this->request->data;
        $view = $data['view'];
        $cid = isset($data['page']) ? intval($data['cid']) : '';
        $sid = isset($data['page']) ? intval($data['sid']) : '';
        $page = isset($data['page']) && intval($data['page']) > 0 ? intval($data['page']) : '1';
        $reset = isset($data['reload']) ? trim($data['reload']) : 'No';
        $openon = isset($data['openon']) ? ($data['openon']) : '';
        $time = isset($data['time']) ? ($data['time']) : '';
        $age_gr = isset($data['age_gr']) ? ($data['age_gr']) : '';
        $gender = isset($data['gender']) ? ($data['gender']) : '';
        $price = isset($data['gender']) ? ($data['price']) : '';
        $facilities = isset($data['facilities']) ? ($data['facilities']) : '';
        $distance = isset($data['distance']) ? ($data['distance']) : '';
        $sort = isset($data['sort']) ? trim($data['sort']) : '';
        $city = isset($data['city']) ? trim($data['city']) : '';
        $ctype = isset($data['ctype']) ? ($data['ctype']) : '';
        $place = isset($data['place']) ? ($data['place']) : '';
        $keyword = isset($data['keyword']) ? str_replace("+", " ", trim($data['keyword'])) : '';

        $lc = isset($data['lc']) ? trim($data['lc']) : '';
        #$lat = $this->Session->read('Auth.User.latitude') != '' ? $this->Session->read('Auth.User.latitude') : ($this->Session->read('user_location.latitude') != '' ? $this->Session->read('user_location.latitude') : "20.2960587");
        #$lng = $this->Session->read('Auth.User.longitude') != '' ? $this->Session->read('Auth.User.longitude') : ($this->Session->read('user_location.longitude') != '' ? $this->Session->read('user_location.longitude') : "85.82453980000003");
        $lat = $this->Session->read('user_location.lat') != '' ? $this->Session->read('user_location.lat') : Configure::read('DEFAULT.LATITUDE');
        $lng = $this->Session->read('user_location.lon') != '' ? $this->Session->read('user_location.lon') : Configure::read('DEFAULT.LONGITUDE');
        #pr($this->Session->read('user_location'));exit;
        #echo $lat." ".$lng;exit;

        /* ad list */
        $this->loadModel('Advertisement');
        $userinfo = $this->Session->read('Auth.User');
        #$user_location = $this->Session->read('user_location');
        $page_view = $view == 'list' ? 3 : 1;
        $ads = $this->Advertisement->getHomeBannerImages($page_view, '1', $userinfo, $page, 'search');
        $this->set(compact('ads'));
        if (is_array($ads) && count($ads) > 0) {
            $limit = $limit - 1;
        }
        /* ad list end */

        $this->loadModel('Business');
        $this->Business->hasMany['BusinessRating']['fields'] = array('AVG(BusinessRating.rating) AS rating', 'COUNT(BusinessRating.rating) AS reviews_count');
        $this->Business->hasMany['BusinessRating']['conditions'] = array('BusinessRating.status' => 1);
        $this->Business->hasMany['BusinessGallery']['conditions'] = array('BusinessGallery.type' => 'image');
        $this->Business->belongsTo['User']['conditions'] = array();
        $options = array();
        $conditions = array('Business.status' => '1');
        $cntr = 0;
        /* filter conditions */
        if ($cid > 0) {
            //$conditions['Business.category_id'] = $cid;
            $conditions['Business.id'] = $this->Format->get_category_business_ids($cid);
        }
        if ($sid > 0) {
            #$conditions['BusinessSubcategory.subcategory_id'] = $sid;
        }
        if ($gender != '') {
            $conditions['Business.gender'] = $gender;
        }

        if (!empty($facilities)) {
            $conditions['BusinessFacility.facility_id'] = $facilities;
        }
        if (!empty($city)) {
            $conditions['Business.city_id'] = $city;
        }
        if (!empty($lc)) {
            $conditions['Business.locality_id'] = $lc;
        }
        if (!empty($keyword)) {
            ++$cntr;
            $keyword = urldecode($keyword);
            #$conditions[] = "Business.name LIKE '%" . $keyword . "%'";
            $conditions[$cntr]['OR'][] = "Business.name LIKE '%" . $keyword . "%'";
            $conditions[$cntr]['OR'][] = "BusinessKeyword.keyword LIKE '" . $keyword . "'";
        }

        if (!empty($openon)) {
            $days = array('mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun');
            $openon_arr = array();
            foreach ($days as $key => $val) {
                if (in_array($val, $openon)) {
                    $openon_arr[] = $key;
                }
            }
            $conditions['BusinessTiming.day'] = $openon_arr;
        }
        if ($price != '') {
            ++$cntr;
            $priceArr = explode('-', $price);
            $conditions[$cntr]['OR'][] = "Business.price BETWEEN '" . $priceArr[0] . "' AND '" . $priceArr[1] . "'";
            $conditions[$cntr]['OR'][] = "Business.max_price BETWEEN '" . $priceArr[0] . "' AND '" . $priceArr[1] . "'";
        }
        if (!empty($time)) {
            ++$cntr;
            if ($time[0] > 0) {
                $conditions[$cntr]['OR'][] = "'" . $this->Format->format_12hr_to_24hr($time[0]) . "' BETWEEN BusinessTiming.start_time AND BusinessTiming.close_time";
            }
            if (!empty($time[1]) && $time[1] > 0) {
                $conditions[$cntr]['OR'][] = "'" . $this->Format->format_12hr_to_24hr($time[1]) . "' BETWEEN BusinessTiming.start_time AND BusinessTiming.close_time";
            }
        }
        if (!empty($age_gr)) {
            ++$cntr;
            if ($age_gr[0] > 0) {
                $conditions[$cntr]['OR'][] = "'" . $age_gr[0] . "' BETWEEN Business.min_age_group AND Business.max_age_group";
            }
            if (!empty($age_gr[1]) && $age_gr[1] > 0) {
                $conditions[$cntr]['OR'][] = "'" . $age_gr[1] . "' BETWEEN Business.min_age_group AND Business.max_age_group";
            }
        }
        /* distance */
        if (!empty($distance)) {
            $conditions[] = " geo_distance('" . $lat . "','" . $lng . "',Business.latitude,Business.longitude) < " . $distance;
        }
        /* business type */
        if (!empty($ctype) && is_array($ctype)) {
            if (count($ctype) > 1) {
                $conditions['Business.type'] = array("private", "group");
            } else {
                foreach ($ctype as $type) {
                    if ($type == 'private') {
                        $conditions['Business.type'] = "private";
                    } elseif ($type == 'group') {
                        $conditions['Business.type'] = "group";
                    }
                }
            }
        }
        /* business preferred_location */
        if (!empty($place) && is_array($place)) {
            $conditions['Business.type'] = "private";
            if (count($place) > 1) {
                $conditions['Business.preferred_location IN '] = array('customer', 'own');
                #$conditions['Business.preferred_location'] = array("customer", "own");
            } else {
                foreach ($place as $preferred_location) {
                    if ($preferred_location == 'home') {
                        $conditions['Business.preferred_location'] = 'customer';
                        #$conditions[] = "IF(Business.type='private',Business.preferred_location='customer',1=1)";
                    } elseif ($preferred_location == 'trainer') {
                        $conditions['Business.preferred_location'] = "own";
                        #$conditions[] = "IF(Business.type='private',Business.preferred_location='own',1=1)";
                    }
                }
            }
        }

        #pr($conditions);exit;
        $options['conditions'] = $conditions;
        $business_ids = '';
        if ($page == 1) {
            $extra_condition = array("Business.status" => '1');
            if ($cid > 0) {
                $extra_condition['Business.category_id'] = $cid;
            }
            $business_ids = $this->Business->find('list', array('fields' => array('Business.id'),
                'conditions' => $extra_condition));
            $max_distance = $this->Business->find('first', array(
                'fields' => array("MAX(geo_distance('" . $lat . "','" . $lng . "',Business.latitude,Business.longitude)) AS distance",
                    "MIN(Business.price) AS min_price", "MAX(Business.price) AS max_price",
                ),
                'recursive' => false,
                'conditions' => $extra_condition));
            #pr($business_ids);exit;
        }

        $options['joins'] = array(
            array('table' => 'business_ratings', 'alias' => 'BusinessRating', 'type' => 'LEFT', 'conditions' => array('BusinessRating.business_id = Business.id', 'BusinessRating.status' => 1)),
            array('table' => 'business_bookings', 'alias' => 'BusinessBooking', 'type' => 'LEFT', 'conditions' => array('BusinessBooking.business_id = Business.id')),
            array('table' => 'subscriptions', 'alias' => 'Subscription', 'type' => 'LEFT', 'conditions' => array('Subscription.user_id = Business.user_id' , 'Subscription.status' => 1)),
        );
        #array('table' => 'business_categories', 'alias' => 'BusinessCategory', 'type' => 'LEFT', 'conditions' => array('BusinessCategory.business_id = Business.id'))
        #array('table' => 'business_subcategories', 'alias' => 'BusinessSubcategory', 'type' => 'LEFT', 'conditions' => array('BusinessSubcategory.business_id = Business.id')),
        if (!empty($keyword)) {
            $options['joins'][] = array('table' => 'business_keywords', 'alias' => 'BusinessKeyword', 'type' => 'LEFT', 'conditions' => array('BusinessKeyword.business_id = Business.id'));
        }
        if (!empty($time)) {
            $options['joins'][] = array('table' => 'business_timings', 'alias' => 'BusinessTiming', 'type' => 'LEFT', 'conditions' => array('BusinessTiming.business_id = Business.id', 'BusinessTiming.holiday' => '0'));
        }
        if (!empty($facilities)) {
            $options['joins'][] = array('table' => 'business_facilities', 'alias' => 'BusinessFacility', 'type' => 'LEFT', 'conditions' => array('BusinessFacility.business_id = Business.id'));
        }
        $options['group'] = array('Business.id');
        /* get page count */
        $options['fields'] = array('DISTINCT Business.id AS total');
        $count_data = $this->Business->find('count', $options);
        //if ($reset == 'Yes') {
        if ($page == 1) {
            $location_option = $options;
            $location_option['fields'] = array('Business.latitude', 'Business.longitude', 'Business.name', 'Business.logo', 'Business.id',
                'CONCAT_WS(", ",Business.address, Business.landmark,Locality.name, City.name) AS fulladdress');
            $location_data = $this->Business->find('all', $location_option);
            $this->set(compact('location_data'));
        }
        /* sorting */
        /*$options['order'] = array("CASE Subscription.name WHEN 'Premium' THEN Subscription.listing_period END DESC",
            "distance ASC",
            "COUNT(BusinessBooking.id) DESC");*/
        if ($sort != '') {
            switch ($sort) {
                case 'price-high-to-low':$options['order'] = array('Business.price' => 'DESC');
                    break;
                case 'price-low-to-high':$options['order'] = array('Business.price' => 'ASC');
                    break;
                case 'rate-high-to-low':$options['order'] = array('AVG(BusinessRating.rating)' => 'DESC');
                    break;
                case 'rate-low-to-high':$options['order'] = array('AVG(BusinessRating.rating)' => 'ASC');
                    break;
                case 'latest':$options['order'] = array('Business.id' => 'DESC');
                    break;
                case 'popularity':
                default:
                    $options['order'] = array("CASE Subscription.name WHEN 'Premium' THEN Subscription.listing_period END DESC", "geo_distance('" . $lat . "','" . $lng . "',Business.latitude,Business.longitude) ASC", "COUNT(BusinessBooking.id) DESC");
                    break;
            }
        }
        else{
          $options['order'] = array('Subscription.package_id' => 'DESC');
        }


        $options['group'] = array('Business.id');

        $options['fields'] = array("Business.id", "Business.user_id", "Business.name", "Business.email", "Business.phone", "Business.category_id",
            "Business.min_age_group", "Business.seo_url", "Business.max_age_group", "Business.logo", "Business.city_id", "Business.created",
            "Business.latitude", "Business.longitude", "Business.status", "Business.rating", "Business.type", "Business.tagline",
            "CONCAT_WS(', ',Business.address, IF(Business.landmark!='',Business.landmark,NULL), Locality.name, City.name) AS fulladdress",
            "geo_distance('" . $lat . "','" . $lng . "',Business.latitude,Business.longitude) AS distance",
            'AVG(BusinessRating.rating) AS rating',
            'User.id', 'User.name', 'User.photo',
            'COUNT(DISTINCT BusinessRating.id) AS reviews_count',
            "Subscription.personal_subdomain", "Subscription.priority_search", "Subscription.name", "Subscription.listing_period", "Subscription.status");

        $options['limit'] = $limit;
        $options['page'] = $page;

        $this->Business->unBindModel(array('hasAndBelongsToMany' => array('SubCategory')));
        $this->Business->unBindModel(array('hasMany' => array('BusinessFaq')));
        $this->Business->unBindModel(array('hasMany' => array('BusinessTiming')));
        $this->Business->unBindModel(array('hasMany' => array('BusinessLanguage')));
        $this->Business->unBindModel(array('hasMany' => array('BusinessKeyword')));
        $search_data = $this->Business->find('all', $options);

        /* show load more */
        $view_loadmore = $count_data > $page * $limit ? "Yes" : "No";
        #echo "$view_loadmore = $count_data > $page * $limit";

        /* get fascilities */
        if (is_array($business_ids) && count($business_ids) > 0) {
            $this->loadModel("BusinessFacility");
            $params = array('fields' => array('Facility.id', 'Facility.name'),
                'order' => array('Facility.name' => 'ASC'),
                'conditions' => array("BusinessFacility.business_id" => $business_ids, 'Facility.id > ' => '0'));
            $params['joins'] = array(array('table' => 'facilities', 'alias' => 'Facility', 'type' => 'LEFT', 'conditions' => array('BusinessFacility.facility_id = Facility.id')));
            $facilities = $this->BusinessFacility->find('list', $params);

            $this->set('facilities', $facilities);
        }
        $this->set('searchData', $search_data);
        $this->set(compact('view', 'count_data', 'page', 'limit', 'view_loadmore', 'max_distance'));
    }

    function faq() {
        $this->loadModel('Faq');
        $option = array('conditions' => array('Faq.status' => 1), 'order' => array('Faq.sequence' => 'ASC', 'Faq.id' => 'ASC'));
        $faqlist = $this->Faq->find('all', $option);
        $this->set(compact('faqlist'));
        $this->set('title_for_layout', Configure::read('COMPANY.META_TITLE') . " | FAQs");
    }

    public function refer_friend() {
        if ($this->request->is('post')) {
            $data = $this->request->data;
            $captcha = trim($this->Captcha->getCode('User.refer_security_code'));
            if (strcmp(trim($data['User']['refer_security_code']), $captcha) == 0) {
                $email_arr = explode(',', trim($this->request->data['email'], ','));
                if (is_array($email_arr)) {
                    foreach ($email_arr as $key => $val) {
                        $email_arr[$key] = trim($val);
                    }
                }
                $Email = new CakeEmail(Configure::read('EMAIL_DELIVERY_MODE'));
                $Email->from(array(Configure::read('COMPANY.FROM_EMAIL') => Configure::read('COMPANY.NAME')));
                $url = trim(HTTP_ROOT, '/') . '/signup';
                $Email->viewVars(array('name' => $this->request->data['name'], 'refer_url' => $url));
                $Email->to($email_arr);
                $Email->subject('Welcome to ' . Configure::read('COMPANY.NAME'));
                $Email->template('refer_a_friend');
                $res = $Email->send();

                $this->Flash->success('Your email sent successfully');
                $this->redirect(array('action' => 'refer_friend'));
            } else {
                $this->Flash->error('Invalid captcha code. Please try again.');
            }
        }
        $this->recently_viewed_classes();
    }

    public function write_to_admin() {
        if ($this->request->is('post')) {
            $data = $this->request->data;
            $this->loadModel('Feedback');
            #$this->Feedback->set($data);

            $ins_data = array(
                'name' => $this->Session->read('Auth.User.name'),
                'comment' => trim($data['message']),
                'email' => $this->Session->read('Auth.User.email'),
                'phone' => $this->Session->read('Auth.User.phone'),
                'type' => 'writetous',
            );
            if ($this->Session->check('Auth.User')) {
                $ins_data['user_id'] = $this->Session->read('Auth.User.id');
            }

            if ($this->Feedback->save($ins_data)) {
                $Email = new CakeEmail(Configure::read('EMAIL_DELIVERY_MODE'));
                $Email->from(array(Configure::read('COMPANY.FROM_EMAIL') => Configure::read('COMPANY.NAME')));
                $Email->viewVars(array('message' => $ins_data['comment'],
                    'name' => $ins_data['name'],
                    'latitude' => $data['lat'],
                    'longitude' => $data['long'],
                    'client_ip' => $this->request->clientIp()));
                $Email->to(Configure::read('COMPANY.ADMIN_EMAIL'));
                $Email->subject('New Request on ' . Configure::read('COMPANY.NAME'));
                $Email->template('write_to_us');
                $Email->send();
                echo 'success';
                exit;
            }
        }
    }

    function update_location() {
        if ($this->request->is('post')) {
            $data = $this->request->data;
            $this->Session->write('user_location', $data);
        }
        echo "success";
        exit;
    }

    function update_category_business() {
        $this->loadModel('Category');
        $ctid = isset($this->request->data['ctid']) ? intval($this->request->data['ctid']) : '';
        $lcid = isset($this->request->data['lcid']) ? intval($this->request->data['lcid']) : '';
        $join_condition = array('Business.category_id = Category.id', "Business.status = 1");
        if ($ctid != '') {
            $join_condition[] = "Business.city_id='" . $ctid . "'";
        }
        if ($lcid != '') {
            $join_condition[] = "Business.locality_id='" . $lcid . "'";
        }

        $options = array('conditions' => array('Category.status' => 1, 'Category.parent_id' => '0'),
            'order' => array('Category.name' => "ASC"),
            'group' => array("Category.id"),
            'fields' => array("Category.id", "Category.name", "COUNT(Business.id) AS tot"),
            'recursive' => false);
        $options['joins'] = array(
            array('table' => 'businesses', 'alias' => 'Business', 'type' => 'LEFT', 'conditions' => $join_condition),
        );

        $CategoryDtls = $this->Category->find('all', $options);
        $html = "";
        if (is_array($CategoryDtls) && count($CategoryDtls) > 0) {
            foreach ($CategoryDtls as $val) {
                $html .= "<option value='" . $val['Category']['id'] . "'>" . $val['Category']['name'];
                #$html .= intval($val[0]['tot']) > 0 ? " (" . $val[0]['tot'] . ")" : "";
                $html .= "</option>";
            }
        }
        echo $html;
        exit;
    }

    function looking_for_tutor() {
        if ($this->request->is('post')) {
            $data = $this->request->data;
            $captcha = trim($this->Captcha->getCode('User.refer_security_code'));
            #$this->loadModel('Feedback');
            #$this->Feedback->set($data);
            if (strcmp(trim($data['User']['refer_security_code']), $captcha) == 0) {
                unset($data['User']);
                unset($data['accept_terms']);
                if ($data['Inquiry']['category_id'] > 0) {
                    $main_cat = $this->Format->parent_categories('list', $data['Inquiry']['category_id']);
                }
                if ($data['Inquiry']['sub_category_id'] > 0) {
                    $sub_cat = $this->Format->child_categories($data['Inquiry']['category_id'], 'list', $data['Inquiry']['sub_category_id']);
                }

                #pr($data);exit;
                $data['Inquiry']['ip'] = $this->request->clientIp();
                $this->loadModel('Inquiry');
                if ($this->Inquiry->save($data)) {
                    #exit('success');
                    if ($data['Inquiry']['category_id'] > 0) {
                        $data['Inquiry']['category'] = $main_cat[$data['Inquiry']['category_id']];
                    }
                    if ($data['Inquiry']['sub_category_id'] > 0) {
                        $data['Inquiry']['sub_category'] = $sub_cat[$data['Inquiry']['sub_category_id']];
                    }
                    $Email = new CakeEmail(Configure::read('EMAIL_DELIVERY_MODE'));
                    $Email->config(array('persistent' => true));

                    $Email->from(array(Configure::read('COMPANY.FROM_EMAIL') => Configure::read('COMPANY.NAME')));
                    $var_array = array('message' => $data['Inquiry']['comment'],
                        'name' => $data['Inquiry']['name'],
                        'email' => $data['Inquiry']['email'],
                        'extra' => $data['Inquiry']);
                    $Email->viewVars($var_array);
                    $Email->to(Configure::read('COMPANY.ADMIN_EMAIL'));
                    $Email->subject("New Inquiry for a Tutor - " . Configure::read('COMPANY.NAME'));
                    $Email->template('new_inquiry_admin');
                    $Email->send();

                    //To User
                    if (trim($data['Inquiry']['email']) != '') {
                        $Email->from(array(Configure::read('COMPANY.FROM_EMAIL') => Configure::read('COMPANY.NAME')));
                        $var_array = array('name' => $data['Inquiry']['name']);
                        $Email->viewVars($var_array);
                        $Email->to($data['Inquiry']['email']);
                        $Email->subject('Looking for a Tutor - ' . Configure::read('COMPANY.NAME'));
                        $Email->template('new_inquiry_ack');
                        $Email->send();
                    }
                    if (Configure::read('EMAIL_DELIVERY_MODE') == 'smtp') {
                        $Email->disconnect();
                    }
                    $this->Flash->success('Thank you ' . h($data['Inquiry']["name"]) . ' for your inquiry. Our representative get back you soon.');
                    $this->redirect(array('controller' => 'content', 'action' => 'looking_for_tutor'));
                } else {
                    $this->Flash->error('There was a problem processing your request. Please try again.');
                }
            } else {
                $this->Flash->error('Invalid captcha code. Please try again.');
            }
        }
        $categories = $this->Format->parent_categories();
        $category_list = Hash::combine($categories, "{n}.Category.id", "{n}.Category.name");
        $cities = $this->Format->cities('list');
        $location = $this->Session->read('user_location');
        $this->set(compact('categories', 'cities', 'category_list', 'location'));
    }

    function ask_us() {
        $this->layout = 'ajax';
        $captcha = trim($this->Captcha->getCode('ask.refer_security_code'));
        $data = $this->data;
        $this->loadModel('Feedback');
        $this->Feedback->set($data);
        #echo $data['captcha']." >> ".$captcha;exit;
        if (strcmp(trim($data['captcha']), $captcha) == 0) {
            $ins_data = array(
                'name' => trim($data['name']),
                'comment' => trim($data['message']),
                'email' => trim($data['contact']),
                'phone' => trim($data['contact']),
                'type' => 'ask',
            );
            if ($this->Session->check('Auth.User')) {
                $ins_data['user_id'] = $this->Session->read('Auth.User.id');
            }
            #['Feedback']
            if ($this->Feedback->save($ins_data)) {

                $Email = new CakeEmail(Configure::read('EMAIL_DELIVERY_MODE'));
                $Email->config(array('persistent' => true));

                /* send email to admin */
                $Email->from(array(Configure::read('COMPANY.FROM_EMAIL') => Configure::read('COMPANY.NAME')));
                $var_array = array('message' => $ins_data['comment'], 'name' => $ins_data['name'], 'number_email' => trim($data['contact']),);
                $Email->viewVars($var_array);
                $Email->to(Configure::read('COMPANY.ADMIN_EMAIL'));
                #$Email->subject($ins_data['comment']);
                $Email->subject("New Request Received - " . Configure::read('COMPANY.NAME'));
                $Email->template('feedback');
                $Email->send();

                if ($this->Format->validateEmail($ins_data['email'])) {
                    //Email to user
                    $Email->from(array(Configure::read('COMPANY.FROM_EMAIL') => Configure::read('COMPANY.NAME')));
                    $var_array = array('name' => $ins_data['name'], 'extra' => "inquiry");
                    $Email->viewVars($var_array);
                    $Email->to($ins_data['email']);
                    $Email->subject("Thank you for writing to us - " . Configure::read('COMPANY.NAME'));
                    $Email->template('feedback_ack');
                    $Email->send();
                }
                /* smtp disconnect */
                if (Configure::read('EMAIL_DELIVERY_MODE') == 'smtp') {
                    $Email->disconnect();
                }

                #$this->Flash->success("We appreciate that you've taken the time to write us. We'll get back to you very soon.");
                #$this->redirect(array('controller' => 'content', 'action' => 'feedback'));
                $return_arr = array('success' => true, 'message' => __("We appreciate that you've taken the time to write us. We'll get back to you very soon."));
            } else {
                $return_arr = array('success' => false, 'message' => __('There was a problem processing your request. Please try again.'));
                #$this->Flash->error('There was a problem processing your request. Please try again.');
            }
        } else {
            $return_arr = array('success' => false, 'message' => __('Error. Invalid Captcha. Please try again.'));
        }
        echo json_encode($return_arr);
        exit;
    }

    function auto_complete_keyword() {
        $this->loadModel('BusinessKeyword');
        $query = h($this->request->query['query']);
        $cid = isset($this->request->query['cid']) ? intval($this->request->query['cid']) : "";
        #$query = h($this->request->query['term']);
        #$query = h($this->request->query['q']);
        #$callback = h($this->request->query['callback']);
        $options = array(
            'conditions' => array("BusinessKeyword.keyword LIKE '" . $query . "%'"),
            "fields" => array("BusinessKeyword.keyword"),
            "group" => array("BusinessKeyword.keyword")
        );
        if ($cid > 0) {
            $options['conditions']['Business.category_id'] = $cid;
        }
        $options['joins'] = array(
            array('table' => 'businesses', 'alias' => 'Business', 'type' => 'LEFT', 'conditions' => array('BusinessKeyword.business_id = Business.id'))
        );

        $keywords = $this->BusinessKeyword->find('list', $options);
        #echo $callback . "(" . json_encode(array_values($keywords)) . ")";

        $final_array = array();
        if (is_array($keywords) && count($keywords) > 0) {
            foreach ($keywords as $val) {
                $final_array[] = array('data' => $val, 'value' => $val);
            }
        } else {
            #$final_array[] = array('data' => '', 'value' => '');
        }
        #pr($final_array);exit;
        echo json_encode(array('suggestions' => $final_array));
        #echo json_encode(array_values($keywords));
        exit;
    }

    function event_list() {

    }

    function ajax_event_list() {
        $this->loadModel('Event');
        $this->layout = 'ajax';
        $data = $this->request->data;
        $limit = BUSINESS_SEARCH_PAGE_LIMIT;
        $page = isset($data['page']) && intval($data['page']) > 0 ? intval($data['page']) : '1';


        $options = array('conditions' => array('Event.status' => 1, "OR" => array("DATE(Event.start_date) >= CURDATE()", "CURDATE() BETWEEN DATE(Event.start_date) AND DATE(Event.end_date)")));
        $options['fields'] = array(
            'Event.id', 'Event.name', 'Event.banner', 'Event.fee_type', 'Event.schedule_type', 'Event.start_date', 'Event.end_date',
            'Event.address', 'Event.landmark', 'Event.pincode', 'Event.latitude', 'Event.longitude',
            'Event.contact_person', 'Event.phone', 'Event.email', 'Event.status',
            'City.id', 'City.name', 'Locality.id', 'Locality.name',
            "CONCAT_WS(', ',Event.address, Event.landmark,City.name,Locality.name, Event.pincode)  AS fulladdress",
        );
        $options['order'] = array("Event.start_date ASC");
        $options['limit'] = $limit;
        $options['page'] = $page;

        #pr($options);exit;
        $events = $this->Event->find('all', $options);
        #pr($events);exit;
        #$log = $this->Event->getDataSource()->showLog( false );
        #debug( $log );
        $this->set('events', $events);
        unset($options['page']);
        $event_count = $this->Event->find('count', $options);
        $this->set('event_count', $event_count);

        /* show load more */
        $view_loadmore = $event_count > $page * $limit ? "Yes" : "No";
        $this->set(compact('page', 'view_loadmore'));
    }

    function event_view($id = '') {
        $this->loadModel('Event');
        $options = array('conditions' => array('Event.id' => $id));
        $options['fields'] = array(
            'Event.*',
            'City.id', 'City.name', 'Locality.id', 'Locality.name',
            "CONCAT_WS(', ',Event.address, Event.landmark,City.name,Locality.name, Event.pincode)  AS fulladdress",
        );


        $event = $this->Event->find('first', $options);
        #pr($events);exit;
        $this->set(compact('event'));
    }

    function event_inquiry($id = '', $stat = '') {
        $this->layout = 'ajax';
        $this->loadModel('Event');
        $EventId = $id;
        $options = array('conditions' => array('Event.id' => $id));
        $options['fields'] = array(
            'Event.*',
            'City.id', 'City.name', 'Locality.id', 'Locality.name',
            "CONCAT_WS(', ',Event.address, Event.landmark,City.name,Locality.name, Event.pincode)  AS fulladdress",
        );


        $event = $this->Event->find('first', $options);
        #pr($events);exit;
        $this->set(compact('event', 'EventId', 'stat'));
    }

    function ajax_save_event_inquiry($id = '', $stat = '') {
        $this->loadModel('Event');
        $this->loadModel('EventInquiry');

        if (!$this->Event->exists($id)) {
            throw new NotFoundException(__('Invalid event'));
        }
        #echo $id . "" . $stat;
        #pr($this->request);
        $user_id = $this->Session->read('Auth.User.id') > 0 ? $this->Session->read('Auth.User.id') : 0;

        #pr($inquiry);
        #exit;
        $data = array(
            "event_id" => $id,
            "user_id" => $user_id,
            "name" => $this->data['name'],
            "phone" => $this->data['phone'],
            "email" => $this->data['email'],
            "act" => $stat,
            "ip" => $this->Format->getRealIpAddr(),
            "user_agent" => $_SERVER['HTTP_USER_AGENT'],
        );
        $this->EventInquiry->create();
        if ($user_id > 0) {
            $inquiry = $this->EventInquiry->find('first', array('conditions' => array('EventInquiry.event_id' => $id, 'EventInquiry.user_id' => $user_id), 'recursive' => false));
            if (is_array($inquiry) && !empty($inquiry)) {
                $this->EventInquiry->id = $inquiry['EventInquiry']['id'];
            }
        }
        $this->EventInquiry->save($data);
        echo "success";
        exit;
    }

}
