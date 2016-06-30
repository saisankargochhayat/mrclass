<?php

App::uses('AppController', 'Controller');
App::uses('SSP', 'Utility');

/**
 * Businesses Controller
 *
 * @property Business $Business
 * @property PaginatorComponent $Paginator
 */
class BusinessesController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'Format');

    function beforeFilter() {
        $this->Auth->allow('view', 'book_now', 'request_call', 'group_booking', 'group_booking_save', 'verify_group_booking_captcha');
        parent::beforeFilter();
        $this->loadModel('Category');
        $options = array('fields' => array('id', 'name'), 'conditions' => array('status' => '1', 'parent_id' => '0'), 'order' => array('name' => 'ASC'));
        $pcategories = $this->Category->find('list', $options);
        $this->set(compact('pcategories'));
    }

    /**
     * index method
     *
     * @return void
     */
    public function index() {
        $this->Business->recursive = 0;
        $user = $this->Session->read('Auth.User');
        $options['conditions'] = array('Business.user_id' => $user['id']);
        $data = $this->Format->get_business_list($user['id'], $options, 'all');
        $this->set('businesses', $data);

        $this->loadModel('Subscription');
        $is_subscribed = $this->Subscription->find('first', array('conditions' => array('Subscription.user_id' => $this->Session->read('Auth.User.id')), 'order' => array('Subscription.created' => 'DESC'), 'fields' => array('Subscription.*', 'DATE_FORMAT(Subscription.subscription_start,"%Y-%m-%d") as subscription_start', 'DATE_FORMAT(Subscription.subscription_end,"%Y-%m-%d") as subscription_end', 'User.*')));
        $this->set('is_subscribed', $is_subscribed);
        if (!empty($is_subscribed)) {
            if (!empty($is_subscribed['Subscription']['subscription_start'])) {
                if ($this->Format->is_subscription_expired($is_subscribed['Subscription']['subscription_start'], $is_subscribed['Subscription']['listing_period'])) {
                    $this->Flash->error(__('Your subscription to MrClass has been expired. Please contact admin.'));
                }
            }
        }
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        #pr($this->params);exit;

        $id = $this->params['id'];
        $user_id = $this->Session->read('Auth.User.id');

        if (!$this->Business->exists($id)) {
            throw new NotFoundException(__('Invalid business'));
        }
        $this->Business->hasMany['BusinessRating']['fields'] = array('AVG(BusinessRating.rating) AS rating', 'COUNT(BusinessRating.rating) AS reviews_count');
        $this->Business->hasMany['BusinessRating']['conditions'] = array('BusinessRating.status' => 1);
        $options = array('conditions' => array('Business.' . $this->Business->primaryKey => $id),
            'fields' => array('*', 'CONCAT_WS(", ",Business.address, Business.landmark) AS fulladdress'));
        if ($this->Session->read('Auth.User.type') != 1) {
            $options['conditions'][] = "IF('" . $user_id . "'!=Business.user_id, Business.status=1,1=1)";
        }
        $data = $this->Business->find('first', $options);
        $image_array = array();
        $video_array = array();
        $BusinessGallery = array();
        if (!empty($data['BusinessGallery'])) {
            $BusinessGallery = $data['BusinessGallery'];
            foreach ($data['BusinessGallery'] as $key => $val) {
                if ($val['type'] == 'image') {
                    $image_array[] = $val;
                } else {
                    $video_array[] = $val;
                }
            }
        }

        $this->set(compact('video_array', 'image_array', 'BusinessGallery'));
        if (!empty($data['BusinessLanguage'])) {
            $data['Business']['languages'] = Hash::combine($data['BusinessLanguage'], "{n}.id", "{n}.lang_id");
        }
        $this->set('business', $data);
        if (is_array($data) && count($data) > 0) {
            // no action
        } else {
            $this->redirect("/");
        }
        $this->params['title'] = h($data['Business']['name']);
        /* reviews */
        $options = array('conditions' => array('Business.' . $this->Business->primaryKey => $id, "IF('" . $user_id . "'!=BusinessRating.user_id, BusinessRating.status=1,1=1)"),
            'fields' => array('BusinessRating.*', 'User.photo', 'User.id', 'User.name'));
        $reviews = $this->Business->BusinessRating->find('all', $options);
        /* if ($this->Auth->user()) {
          $this->loadModel('ContactNumberRequest');
          $is_contact_number_requested = $this->ContactNumberRequest->find('first', array('conditions' => array('ContactNumberRequest.user_id' => $user_id, 'ContactNumberRequest.business_id' => $id)));
          if (!empty($is_contact_number_requested) && is_array($is_contact_number_requested)) {
          $this->set('contact_number_erquested', $is_contact_number_requested);
          }
          } */
        if ($this->Auth->user()) {
            $this->loadModel('BusinessFavorite');
            $is_marked_favorite = $this->BusinessFavorite->find('count', array('conditions' => array('BusinessFavorite.business_id' => $id, 'BusinessFavorite.user_id' => $this->Auth->user('id'))));
            $this->set('is_marked_favorite', $is_marked_favorite);
        }
        $this->set(compact('reviews'));

        /* business courses */
        $this->loadModel('BusinessCourse');
        $params = array('conditions' => array("business_id" => $id));
        $courses = $this->BusinessCourse->find('all', $params);
        $this->set(compact('courses'));

        $this->update_business_views($id);
        $this->set('subscription', SSP::get_subscription($data['Business']['user_id']));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        $this->loadModel('Subscription');
        $this->loadModel('User');
        if (isset($this->request->query['data']['package_id']) && !empty($this->request->query['data']['package_id'])) {
            $this->Flash->success(__('Please add a business to complete your subscription process.'));
            $this->set('package_id', $this->request->query['data']['package_id']);
            $this->set('discount_id', $this->request->query['discount']);
            $from = (isset($this->request->query['referer']) && !empty($this->request->query['referer'])) ? $this->request->query['referer'] : "index";
            $this->set('referer', $from);
        }
        if (isset($this->request->named) && empty($this->request->named)) {
            $user_id = $this->Auth->user('id');
            //Check Subscriptions exist for users.
            $is_package_exist = $this->Subscription->find('first', array('conditions' => array('Subscription.user_id' => $user_id), 'fields' => array('Subscription.*', 'DATE_FORMAT(Subscription.subscription_start,"%Y-%m-%d") as subscription_start', 'DATE_FORMAT(Subscription.subscription_end,"%Y-%m-%d") as subscription_end', 'User.*'), 'order' => array('Subscription.created' => 'DESC')));
            $this->set('is_package_exist', $is_package_exist);
            $business_count = intval($this->Format->get_business_count($user_id));
            if (!empty($is_package_exist)) {
                $subscription_limit = intval($is_package_exist['Subscription']['subscription']);
                $subscription_status = $is_package_exist['Subscription']['status'];
                if ($subscription_status == "0") {
                    if ($business_count > 0) {
                        $this->Flash->error(__('Your subscription activation is pending. You can add businesses after your subscription will be active.'));
                        $this->redirect(array('controller' => 'businesses', 'action' => 'index'));
                    }
                } else if ($subscription_status == "2") {
                    $this->Flash->error(__('Your subscription is cancelled. For more details, please contact admin.'));
                    $this->redirect(array('controller' => 'businesses', 'action' => 'index'));
                } else {
                    $check_subscription_is_active = $this->Format->is_subscription_active($is_package_exist[0]['subscription_end']);
                    if ($check_subscription_is_active) {
                        if ($business_count >= $subscription_limit) {
                            $this->Flash->error(__('You business limit according to your subscription is reached. Please contact admin.'));
                            $this->redirect(array('controller' => 'businesses', 'action' => 'index'));
                        }
                    } else {
                        $this->Flash->error(__('Your subscription to ' . $is_package_exist['Subscription']['name'] . ' package has been expired. For more details, please contact admin.'));
                        $this->redirect(array('controller' => 'businesses', 'action' => 'index'));
                    }
                }
            } else {
                if (empty($this->request->query)) {
                    $this->Flash->error(__('You have not subscribed to any packages. Please choose a cubscription package to add businesses.'));
                    $this->redirect(array('controller' => 'subscriptions', 'action' => 'choose_subscription', "?" => array("from" => "add")));
                    #$this->redirect(array('controller' => 'subscriptions', 'action' => 'choose_subscription'));
                }
            }
        }
        if ($this->request->is('post')) {
            $data = $this->request->data;
            $BusinessType = $data['BusinessType'];
            if ($BusinessType == 'private') {
                $data['Business']['preferred_location'] = $data['PreferredLocation'];
                $data['Business']['free_demo_class'] = $data['FreeDemoClass'];
                $data['Business']['type'] = $data['BusinessType'];
                $data['Business']['education'] = trim($data['Business']['education']);
                $data['Business']['experience'] = trim($data['Business']['experience']);
                $data['Business']['dob'] = date('Y-m-d H:i:s', strtotime($data['Business']['dob']));
                if (isset($data['Business']['tagline'])) {
                    $data['Business']['tagline'] = trim($data['Business']['tagline']);
                }
                if (isset($data['Business']['established'])) {
                    $data['Business']['established'] = date('Y-m-d H:i:s', strtotime($data['Business']['established']));
                }
                $languages = $data['Business']['languages'];
            } else {
                $data['Business']['education'] = '';
                $data['Business']['experience'] = '';
                $data['Business']['dob'] = '';
                $data['Business']['tagline'] = '';
                $data['Business']['established'] = '';
            }

            unset($data['Business']['languages']);
            unset($data['BusinessType']);
            unset($data['PreferredLocation']);
            unset($data['FreeDemoClass']);
            unset($data['accept_terms']);

            if (!empty($data['Business']['student_ratio']) && !empty($data['Business']['teacher_ratio'])) {
                $data['Business']['ratio'] = trim($data['Business']['student_ratio']) . ":" . trim($data['Business']['teacher_ratio']);
            }
            unset($data['Business']['student_ratio']);
            unset($data['Business']['teacher_ratio']);

            $subcategory_id = !empty($data['Business']['subcategory_id']) ? $data['Business']['subcategory_id'] : array();
            unset($data['Business']['subcategory_id']);

            $package_id = !empty($data['Business']['package_id']) ? $data['Business']['package_id'] : "";
            unset($data['Business']['package_id']);

            $discount_id = !empty($data['Business']['discount_id']) ? $data['Business']['discount_id'] : "";
            unset($data['Business']['discount_id']);

            $referer = !empty($data['referer']) ? $data['referer'] : "";
            unset($data['referer']);

            $facilities = !empty($data['Business']['facilities']) ? $data['Business']['facilities'] : array();
            unset($data['Business']['facilities']);

            $categories = !empty($data['Business']['category_id']) ? $data['Business']['category_id'] : array();
            unset($data['Business']['category_id']);

            $keyword = !empty($data['Business']['keyword']) ? explode(",", $data['Business']['keyword']) : array();
            unset($data['Business']['keyword']);

            unset($data['Business']['subcategory_id_tmp']);
            unset($data['Business']['locality_id_tmp']);
            if (is_array($data['Business'])) {
                foreach ($data['Business'] as $key => $val) {
                    $data['Business'][$key] = is_array($val) ? $val : trim($val);
                }
            }
            $this->Business->set($data);
            unset($this->Business->validate['phone']);

            if ($this->Business->validates(array('fieldList' => array('name', 'category_id', 'min_age_group',
                            'max_age_group', 'city_id', 'locality_id', 'address', 'pincode', 'contact_person', 'phone', 'email',
                            'gender', 'price')))) {

                $data['Business']['user_id'] = $user_id = $this->Session->read('Auth.User.id');
                $this->Business->create();
                if ($this->Business->save($data)) {
                    $lst_bsns_id = $this->Business->id;

                    /* save business facilities */
                    $this->loadModel('BusinessFacility');
                    if (is_array($facilities) && count($facilities) > 0) {
                        $facility_data = array();
                        foreach ($facilities as $k => $v) {
                            $facility_condition = array('business_id' => $lst_bsns_id, 'facility_id' => $v);
                            if (!$this->BusinessFacility->hasAny($facility_condition)) {
                                $facility_data[] = array('business_id' => $lst_bsns_id, 'facility_id' => $v);
                            }
                        }
                        if (is_array($facility_data) && count($facility_data) > 0) {
                            $this->BusinessFacility->saveAll($facility_data);
                        }
                    }

                    /* save business categories */
                    $this->loadModel('BusinessCategory');
                    if (is_array($categories) && count($categories) > 0) {
                        $category_data = array();
                        foreach ($categories as $k => $v) {
                            $category_condition = array('business_id' => $lst_bsns_id, 'category_id' => $v);
                            if (!$this->BusinessCategory->hasAny($category_condition)) {
                                $category_data[] = array('business_id' => $lst_bsns_id, 'category_id' => $v);
                            }
                        }
                        if (is_array($category_data) && count($category_data) > 0) {
                            $this->BusinessCategory->saveAll($category_data);
                        }
                    }

                    /* saving keywords */
                    $this->loadModel('BusinessKeyword');
                    if (is_array($keyword) && count($keyword) > 0) {
                        $keyword_data = array();
                        foreach ($keyword as $v) {
                            if (trim(h($v)) != '') {
                                $keyword_condition = array('business_id' => $lst_bsns_id, 'keyword' => h($v));
                                if (!$this->BusinessKeyword->hasAny($keyword_condition)) {
                                    $keyword_data[] = array('business_id' => $lst_bsns_id, 'keyword' => trim($v));
                                }
                            }
                        }
                        if (is_array($keyword_data) && count($keyword_data) > 0) {
                            $this->BusinessKeyword->saveAll($keyword_data);
                        }
                    }

                    /* saving business languages */
                    if ($BusinessType == 'private') {
                        if (isset($languages) && !empty($languages) && is_array($languages) && count($languages) > 0) {
                            $this->loadModel('BusinessLanguage');
                            $language_data = array();
                            foreach ($languages as $k => $v) {
                                $language_condition = array('business_id' => $lst_bsns_id, 'lang_id' => $v);
                                if (!$this->BusinessLanguage->hasAny($language_condition)) {
                                    $language_data[] = array('business_id' => $lst_bsns_id, 'lang_id' => $v);
                                }
                            }
                            if (is_array($language_data) && count($language_data) > 0) {
                                $this->BusinessLanguage->saveAll($language_data);
                            }
                            $del_opt = array('BusinessLanguage.business_id' => $lst_bsns_id, 'NOT' => array('BusinessLanguage.lang_id' => $languages));
                            $this->BusinessLanguage->deleteAll($del_opt);
                        }
                    }

                    /* saving subscription package */
                    if ($package_id) {
                        $redirect_url = ($referer == "add") ? "/business-pics-" . $lst_bsns_id . "-change" : array('controller' => 'subscriptions', 'action' => 'index');
                        $options_active_business = array('conditions' => array('Business.user_id' => $user_id, 'Business.status' => '1'));
                        $user_active_businesses = intval($this->Business->find('count', $options_active_business));

                        $this->loadModel('PackageDiscount');
                        $package_discount = $this->PackageDiscount->find('first', array('conditions' => array('PackageDiscount.id' => $discount_id), 'fields' => array('PackageDiscount.period_duration', 'PackageDiscount.period_type', 'PackageDiscount.discount', 'PackageDiscount.discount_type', 'PackageDiscount.created', 'PackageDiscount.modified', 'Package.*')));

                        $offer = $package_discount['PackageDiscount'];
                        $period_duration = (trim($offer['period_type']) == "Year") ? intval($offer['period_duration']) * 12 : intval($offer['period_duration']);
                        $offer_duration = $period_duration * 30;
                        $expire = time() + $offer_duration * 24 * 60 * 60;

                        //Build subscription array
                        $subscription_data['Subscription'] = $package_discount['Package'];
                        unset($subscription_data['Subscription']['id']);
                        unset($subscription_data['Subscription']['status']);
                        unset($subscription_data['Subscription']['created']);
                        unset($subscription_data['Subscription']['modified']);
                        $subscription_data['Subscription']['offer'] = json_encode($package_discount['PackageDiscount']);
                        $subscription_data['Subscription']['listing_period'] = $offer_duration;

                        //Common variables that can be used in subscription ,transaction and ledger table.
                        $subscription_data['Subscription']['user_id'] = $transaction['Transaction']['user_id'] = $ledger['Ledger']['user_id'] = $user_id;
                        $subscription_data['Subscription']['package_id'] = $transaction['Transaction']['package_id'] = $package_id;

                        //Build transaction array
                        $transaction['Transaction']['mode'] = 'Cash';
                        $transaction['Transaction']['status'] = 'Initiated';
                        $transaction['Transaction']['issued_date'] = date('Y-m-d');
                        $subscription_data['Subscription']['status'] = '0';
                        $s_status = false;
                        $s_flash = 'Thank you for subscribing to ' . $subscription_data['Subscription']['name'] . ' package. You subscription will be active upon admin\'s approval of your business.';

                        if ($this->Subscription->save($subscription_data)) {
                            $subscription_id = $this->Subscription->id;
                            $price_array = $this->Format->price_calculation($package_discount ['PackageDiscount'], $subscription_data['Subscription']['price']);
                            $transaction['Transaction']['subscription_id'] = $subscription_id;
                            $transaction['Transaction']['sub_total'] = $price_array['total_discountd_price'];
                            $transaction['Transaction']['discount'] = 0;
                            $transaction['Transaction']['final_price'] = $price_array['total_discountd_price'];
                            #$transaction['Transaction']['reference_number'] = $this->Format->invoice_number($subscription_id);
                            $transaction['Transaction']['user_detail'] = $this->User->user_details($user_id);
                            $this->loadModel('Transaction');
                            if ($this->Transaction->save($transaction)) {
                                $TransactionId = $this->Transaction->id;
                                if ($TransactionId > 0) {
                                    $this->Transaction->id = $TransactionId;
                                    $this->Transaction->saveField('reference_number', $this->Format->invoice_number($TransactionId), false);
                                }
                            }

                            $subscription = $subscription_data['Subscription'];
                            $Email = new CakeEmail(Configure::read('EMAIL_DELIVERY_MODE'));
                            $Email->config(array('persistent' => true));
                            if (!empty($this->Session->read('Auth.User.email'))) {
                                /* new subscription email sent to business owner */
                                $Email->from(array(Configure::read('COMPANY.FROM_EMAIL') => Configure::read('COMPANY.NAME')));
                                $Email->viewVars(array('For' => 'User', 'Subscription' => $subscription, 'Transaction' => $transaction['Transaction'], 'name' => $this->Session->read('Auth.User.name'), 'month' => $period_duration, 'days' => $offer_duration, 'status' => $s_status));
                                $Email->to($this->Session->read('Auth.User.email'));
                                $Email->subject('Your Subscription Created - ' . Configure::read('COMPANY.NAME'));
                                $Email->template('subscription_notification_new');
                                $Email->send();
                            }

                            /* email to admin */
                            $Email->from(array(Configure::read('COMPANY.FROM_EMAIL') => Configure::read('COMPANY.NAME')));
                            $Email->viewVars(array('For' => 'Admin', 'Subscription' => $subscription, 'Transaction' => $transaction['Transaction'], 'name' => $this->Session->read('Auth.User.name'), 'month' => $period_duration, 'days' => $offer_duration, 'status' => $s_status));
                            $Email->to(Configure::read('COMPANY.ADMIN_EMAIL'));
                            $Email->subject('New Subscription Added - ' . Configure::read('COMPANY.NAME'));
                            $Email->template('subscription_notification_new');
                            $Email->send();
                            /* send email to user and admin end */
                            $this->Flash->Success(__($s_flash));
                        }
                    } else {
                        $redirect_url = "/business-pics-" . $lst_bsns_id . "-change";
                        $s_flash = 'Business created successfully. Your business details will be reviewed shortly and will intimate you once it is done.';
                    }

                    /* send email to user and admin */
                    $business = $data;
                    if ($package_id == "") {
                        $Email = new CakeEmail(Configure::read('EMAIL_DELIVERY_MODE'));
                        $Email->config(array('persistent' => true));
                    }

                    /* new business email sent to business owner */
                    $Email->from(array(Configure::read('COMPANY.FROM_EMAIL') => Configure::read('COMPANY.NAME')));
                    $Email->viewVars(array('business' => $business, 'name' => trim($business['Business']['contact_person']) != "" ? $business['Business']['contact_person'] : $this->Session->read('Auth.User.name')));
                    $Email->to($business['Business']['email']);
                    #$Email->to($this->Session->read('Auth.User.email'));
                    $Email->subject('Your Business Created - ' . Configure::read('COMPANY.NAME'));
                    $Email->template('new_business_user');
                    $Email->send();

                    /* email to admin */
                    $Email->from(array(Configure::read('COMPANY.FROM_EMAIL') => Configure::read('COMPANY.NAME')));
                    $Email->viewVars(array('business' => $business, 'name' => 'Admin'));
                    $Email->to(Configure::read('COMPANY.ADMIN_EMAIL'));
                    $Email->subject('New Business Created - ' . Configure::read('COMPANY.NAME'));
                    $Email->template('new_business_admin');
                    $Email->send();
                    /* send email to user and admin end */

                    /* Disconnect email connection */
                    if (Configure::read('EMAIL_DELIVERY_MODE') == 'smtp') {
                        $Email->disconnect();
                    }

                    $this->Flash->success(__($s_flash));
                    $this->redirect($redirect_url);
                } else {
                    $this->Flash->error(__('There was a problem processing your request. Please try again.'));
                }
            } else {
                $this->Flash->error(__('Validation Error. Try again!'));
            }
        }
        $ucities = $this->Format->cities('list', 'business');
        $this->set(compact('ucities'));
        $this->loadModel("Facility");
        $facilities = $this->Facility->find('list', array('fields' => array('id', 'name'), 'order' => array('name' => 'ASC')));
        $this->set('facilities', $facilities);
        if (!empty($this->request->named)) {
            $this->set('package_id', $this->request->named['package_id']);
        }
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        $id = $this->params['id'];
        $user_id = $this->Session->read('Auth.User.id');
        if (!$this->Business->exists($id)) {
            throw new NotFoundException(__('Invalid business'));
        }
        if (!$this->Business->hasAny(array('Business.id' => $id, 'Business.user_id' => $user_id))) {
            throw new NotFoundException(__('Invalid business'));
        }

        $slug = isset($this->params['slug']) && !empty($this->params['slug']) ? $this->params['slug'] : 'details';
        if ($this->request->is(array('post', 'put'))) {
            $data = $this->request->data;
            if ($slug == 'details') {

                $subcategory_id = !empty($data['Business']['subcategory_id']) ? $data['Business']['subcategory_id'] : array();
                unset($data['Business']['subcategory_id']);

                $facilities = !empty($data['Business']['facilities']) ? $data['Business']['facilities'] : array();
                unset($data['Business']['facilities']);

                $categories = !empty($data['Business']['category_id']) ? $data['Business']['category_id'] : array();
                unset($data['Business']['category_id']);

                $keyword = !empty($data['Business']['keyword']) ? explode(",", $data['Business']['keyword']) : array();
                unset($data['Business']['keyword']);

                /* checking business type */
                $BusinessType = $data['BusinessType'];
                $data['Business']['type'] = $data['BusinessType'];
                if ($BusinessType == 'private') {
                    $data['Business']['preferred_location'] = $data['PreferredLocation'];
                    $data['Business']['free_demo_class'] = $data['FreeDemoClass'];
                    $data['Business']['education'] = trim($data['Business']['education']);
                    $data['Business']['experience'] = trim($data['Business']['experience']);
                    $data['Business']['dob'] = date('Y-m-d H:i:s', strtotime($data['Business']['dob']));
                    if (isset($data['Business']['tagline'])) {
                        $data['Business']['tagline'] = trim($data['Business']['tagline']);
                    }
                    if (isset($data['Business']['established'])) {
                        $data['Business']['established'] = date('Y-m-d H:i:s', strtotime($data['Business']['established']));
                    }
                    $languages = $data['Business']['languages'];
                } else {
                    $data['Business']['preferred_location'] = '';
                    $data['Business']['free_demo_class'] = '';
                    $data['Business']['education'] = '';
                    $data['Business']['experience'] = '';
                    $data['Business']['dob'] = '';
                    $data['Business']['tagline'] = '';
                    $data['Business']['established'] = '';
                }

                unset($data['Business']['languages']);
                unset($data['BusinessType']);
                unset($data['PreferredLocation']);
                unset($data['FreeDemoClass']);
                unset($data['accept_terms']);
            }

            if (!empty($data['Business']['student_ratio']) && !empty($data['Business']['teacher_ratio'])) {
                $data['Business']['ratio'] = trim($data['Business']['student_ratio']) . ":" . trim($data['Business']['teacher_ratio']);
            } else {
                $data['Business']['ratio'] = '';
            }

            unset($data['Business']['student_ratio']);
            unset($data['Business']['teacher_ratio']);

            $this->Business->id = $id;
            $data['Business']['remove'] = true;
            unset($this->Business->validate['phone']);
            if (is_array($data['Business'])) {
                foreach ($data['Business'] as $key => $val) {
                    $data['Business'][$key] = is_array($val) ? $val : trim($val);
                }
            }
            $this->Business->set($data);
            if ($this->Business->save($data)) {
                if ($slug == 'details') {
                    /* updating categories */
                    $this->loadModel('BusinessCategory');
                    if (is_array($categories) && count($categories) > 0) {
                        $category_data = array();
                        foreach ($categories as $k => $v) {
                            $category_condition = array('business_id' => $id, 'category_id' => $v);
                            if (!$this->BusinessCategory->hasAny($category_condition)) {
                                $category_data[] = array('business_id' => $id, 'category_id' => $v);
                            }
                        }
                        if (!empty($category_data)) {
                            $this->BusinessCategory->saveAll($category_data);
                        }
                        $del_opti = array('BusinessCategory.business_id' => $id, 'NOT' => array('BusinessCategory.category_id' => $categories));
                        $this->BusinessCategory->deleteAll($del_opti);
                    }

                    /* updating facilities */
                    $this->loadModel('BusinessFacility');
                    if (is_array($facilities) && count($facilities) > 0) {
                        $facility_data = array();
                        foreach ($facilities as $k => $v) {
                            $facility_condition = array('business_id' => $id, 'facility_id' => $v);
                            if (!$this->BusinessFacility->hasAny($facility_condition)) {
                                $facility_data[] = array('business_id' => $id, 'facility_id' => $v);
                            }
                        }
                        if (is_array($facility_data) && count($facility_data) > 0) {
                            $this->BusinessFacility->saveAll($facility_data);
                        }
                        $del_opt = array('BusinessFacility.business_id' => $id, 'NOT' => array('BusinessFacility.facility_id' => $facilities));
                        $this->BusinessFacility->deleteAll($del_opt);
                    }

                    /* saving keywords */
                    $this->loadModel('BusinessKeyword');
                    if (is_array($keyword) && count($keyword) > 0) {
                        $keyword_data = array();
                        foreach ($keyword as $v) {
                            if (trim(h($v)) != '') {
                                $keyword_condition = array('business_id' => $id, 'keyword' => h($v));
                                if (!$this->BusinessKeyword->hasAny($keyword_condition)) {
                                    $keyword_data[] = array('business_id' => $id, 'keyword' => trim($v));
                                }
                            }
                        }
                        if (is_array($keyword_data) && count($keyword_data) > 0) {
                            $this->BusinessKeyword->saveAll($keyword_data);
                        }
                        $del_opt = array('BusinessKeyword.business_id' => $id, 'NOT' => array('BusinessKeyword.keyword' => $keyword));
                        $this->BusinessKeyword->deleteAll($del_opt);
                    }

                    /* saving business languages */
                    $this->loadModel('BusinessLanguage');
                    if ($BusinessType == 'private') {
                        if (isset($languages) && !empty($languages) && is_array($languages) && count($languages) > 0) {
                            $language_data = array();
                            foreach ($languages as $k => $v) {
                                $language_condition = array('business_id' => $id, 'lang_id' => $v);
                                if (!$this->BusinessLanguage->hasAny($language_condition)) {
                                    $language_data[] = array('business_id' => $id, 'lang_id' => $v);
                                }
                            }
                            if (is_array($language_data) && count($language_data) > 0) {
                                $this->BusinessLanguage->saveAll($language_data);
                            }
                            $del_opt = array('BusinessLanguage.business_id' => $id, 'NOT' => array('BusinessLanguage.lang_id' => $languages));
                            $this->BusinessLanguage->deleteAll($del_opt);
                        }
                    } else {
                        $del_opt = array('BusinessLanguage.business_id' => $id);
                        $this->BusinessLanguage->deleteAll($del_opt);
                    }
                }

                $this->Flash->success(__('Business updated successfully.'));
                $this->redirect("/" . $this->params->url);
            } else {
                #$errors = $this->Business->invalidFields();pr($errors);exit;
                $this->Flash->error(__('There was a problem processing your request. Please try again.'));
            }
        } else {
            $options = array('conditions' => array('Business.' . $this->Business->primaryKey => $id));
            $this->request->data = $this->Business->find('first', $options);

            if (!empty($this->request->data['Business']['ratio'])) {
                $ratio_arr = explode(":", $this->request->data['Business']['ratio']);
                $this->request->data['Business']['student_ratio'] = $ratio_arr[0];
                $this->request->data['Business']['teacher_ratio'] = $ratio_arr[1];
            }
            $categories = Hash::combine($this->request->data['Category'], "{n}.id", "{n}.id");
            $facilities = Hash::combine($this->request->data['Facility'], "{n}.id", "{n}.id");
            $subcategories = Hash::combine($this->request->data['SubCategory'], "{n}.id", "{n}.id");
            $BusinessLanguage = Hash::combine($this->request->data['BusinessLanguage'], "{n}.id", "{n}.lang_id");
            $this->request->data['Business']['subcategory_id'] = $subcategories;
            $this->request->data['Business']['facilities'] = $facilities;
            $this->request->data['Business']['category_id'] = $categories;
            $this->request->data['Business']['languages'] = $BusinessLanguage;

            $BusinessKeyword = !empty($this->request->data['BusinessKeyword']) ? implode(",", Hash::extract($this->request->data['BusinessKeyword'], "{n}.keyword")) : "";
            $this->request->data['Business']['keyword'] = $BusinessKeyword;
        }

        $ucities = $this->Format->cities('list', 'business');
        $this->set(compact('ucities'));

        $this->loadModel("Facility");
        $facilities = $this->Facility->find('list', array('fields' => array('id', 'name'), 'order' => array('name' => 'ASC')));
        $this->set('facilities', $facilities);
        $this->set('is_package_exist', SSP::get_subscription($user_id));
    }

    /**
     * delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function delete($id = null) {
        $this->Business->id = $id;
        if (!$this->Business->exists()) {
            throw new NotFoundException(__('Invalid business'));
        }
        $this->request->allowMethod('post', 'delete');
        if ($this->Business->delete()) {
            $this->Flash->success(__('The business has been deleted.'));
        } else {
            $this->Flash->error(__('The business could not be deleted. Please, try again.'));
        }
        return $this->redirect(array('action' => 'index'));
    }

    public function delete_logo($id = null) {
        $id = $this->data['id'];
        $this->Business->id = $id;
        $success = 0;
        $msg = '';
        if (!$this->Business->exists()) {
            throw new NotFoundException(__('Invalid business'));
        }
        $this->request->allowMethod('post', 'delete');
        if (intval($id) > 0) {
            $this->Business->recursive = false;
            $business = $this->Business->find('first', array('conditions' => array('Business.id' => $id), 'fields' => array('Business.id', 'Business.logo')));

            $bid = $business['Business']['id'];
            $filename = BUSINESS_LOGO_DIR . "logo" . DS . $bid . DS . $business['Business']['logo'];
            if (file_exists($filename)) {
                $this->Format->deleteDir(BUSINESS_LOGO_DIR . "logo" . DS . $bid . DS);
                if ($this->Business->save(array('logo' => '', 'id' => $id))) {
                    $msg = __('The business logo has been deleted.');
                    $success = 1;
                } else {
                    $msg = __('The business logo could not be deleted. Please, try again.');
                }
            } else {
                $msg = __('File not found. Please, try again.');
            }
        } else {
            $msg = __('The business logo could not be deleted. Please, try again.');
        }
        echo json_encode(array('success' => $success, 'message' => $msg));
        exit;
    }

    /**
     * admin_index method
     *
     * @return void
     */
    public function admin_index() {
        //$this->Business->unBindModel(array('hasAndBelongsToMany' => array('Facility','SubCategory')));
        //$this->Business->unBindModel(array('hasMany' => array('BusinessLanguage','BusinessGallery','BusinessRating','BusinessTiming','BusinessKeyword','BusinessFaq')));
        //$params = array('order' => array('Business.status' => 'DESC', 'Business.id' => 'DESC'));
        //$business_data = $this->Business->find('all', $params);
        //$this->set('businesses', $business_data);
    }

    public function index_ajax() {
        if ($this->request->is('ajax')) {
            $table = 'businesses';
            $primaryKey = 'id';
            $columns = array(
                array('db' => '`b`.`id`', 'dt' => 0, 'field' => 'id', 'as' => 'id'),
                array('db' => '`b`.`name`', 'dt' => 1, 'field' => 'business_name', 'as' => 'business_name'),
                array('db' => 'GROUP_CONCAT(DISTINCT cat.name ORDER BY cat.name ASC SEPARATOR ", ")', 'dt' => 2, 'field' => 'categories', 'as' => 'categories'),
                array('db' => '`c`.`name`', 'dt' => 3, 'field' => 'city_name', 'as' => 'city_name'),
                array('db' => 'CONCAT_WS(", ",b.address,IFNULL(b.landmark, ""),l.name,c.name,b.pincode)', 'dt' => 4, 'field' => 'business_address', 'as' => 'business_address'),
                array('db' => '`b`.`contact_person`', 'dt' => 5, 'field' => 'contact_person', 'as' => 'contact_person'),
                array('db' => '`b`.`created`', 'dt' => 6, 'field' => 'created', 'as' => 'created'),
                array('db' => '`b`.`status`', 'dt' => 7, 'field' => 'status', 'as' => 'status'),
                array('db' => '`l`.`name`', 'dt' => 8, 'field' => 'locality_name', 'as' => 'locality_name'),
                array('db' => '`b`.`address`', 'dt' => 9, 'field' => 'address', 'as' => 'address'),
                array('db' => '`b`.`landmark`', 'dt' => 10, 'field' => 'landmark', 'as' => 'landmark'),
                array('db' => '`b`.`pincode`', 'dt' => 11, 'field' => 'pincode', 'as' => 'pincode'),
                array('db' => '`s`.`name`', 'dt' => 12, 'field' => 'subscription_name', 'as' => 'subscription_name'),
                array('db' => '`s`.`personal_subdomain`', 'dt' => 13, 'field' => 'personal_subdomain', 'as' => 'personal_subdomain'),
                array('db' => '`b`.`seo_url`', 'dt' => 14, 'field' => 'seo_url', 'as' => 'seo_url'),
                array('db' => '`b`.`user_id`', 'dt' => 15, 'field' => 'user_id', 'as' => 'user_id')
            );
            $joinQuery = "FROM `businesses` AS `b` "
                    . "LEFT JOIN `users` AS `u` ON (`u`.`id` = `b`.`user_id`) "
                    . "LEFT JOIN `cities` AS `c` ON (`c`.`id` = `b`.`city_id`) "
                    . "LEFT JOIN `localities` AS `l` ON (`l`.`id` = `b`.`locality_id`) "
                    . "LEFT JOIN `subscriptions` AS `s` ON (`s`.`user_id` = `b`.`user_id`) AND `s`.`id` = (SELECT MAX(`z`.`id`) FROM subscriptions z WHERE `z`.`user_id` = `s`.`user_id`) "
                    . "INNER JOIN `business_categories` AS `bcat` ON (`bcat`.`business_id` = `b`.`id`) "
                    . "INNER JOIN `categories` AS `cat` ON (`cat`.`id` = `bcat`.`category_id`)";
            $extraWhere = "";
            $groupBy = '`bcat`.`business_id`';
            $customOrder = '`b`.`id` DESC';

            App::uses('SSP', 'Utility');
            $having = "Yes";
            $response = SSP::simple($_GET, $this->db_config, $table, $primaryKey, $columns, $joinQuery, $extraWhere, $groupBy, $customOrder, $having);
            print(json_encode($response));
            exit;
        }
    }

    /**
     * admin_view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_view($id = null) {
        if (!$this->Business->exists($id)) {
            throw new NotFoundException(__('Invalid business'));
        }
        $options = array('conditions' => array('Business.' . $this->Business->primaryKey => $id));
        $this->set('business', $this->Business->find('first', $options));
    }

    /**
     * admin_add business method
     *
     * @return void
     */
    public function admin_add() {
        if ($this->request->is('post')) {
            $data = $this->request->data;
            $type = trim($data['Business']['type']);

            $categories = !empty($data['Business']['category_id']) ? $data['Business']['category_id'] : array();
            unset($data['Business']['category_id']);

            $subcategory_id = !empty($data['Business']['subcategory_id']) ? $data['Business']['subcategory_id'] : array();
            unset($data['Business']['subcategory_id']);

            $facilities = !empty($data['Business']['facilities']) ? $data['Business']['facilities'] : array();
            unset($data['Business']['facilities']);

            $keyword = !empty($data['Business']['keyword']) ? explode(",", $data['Business']['keyword']) : array();
            unset($data['Business']['keyword']);

            if (!empty($data['Business']['student_ratio']) && !empty($data['Business']['teacher_ratio'])) {
                $data['Business']['ratio'] = trim($data['Business']['student_ratio']) . ":" . trim($data['Business']['teacher_ratio']);
            }
            unset($data['Business']['student_ratio']);
            unset($data['Business']['teacher_ratio']);


            $languages = array();
            if ($type == 'private') {
                if (isset($data['Business']['dob']) && !empty($data['Business']['dob'])) {
                    $data['Business']['dob'] = date('Y-m-d', strtotime($data['Business']['dob']));
                }
                if (isset($data['Business']['established'])) {
                    $data['Business']['established'] = date('Y-m-d', strtotime($data['Business']['established']));
                }
                if (isset($data['Business']['languages']) && !empty($data['Business']['languages'])) {
                    $languages = $data['Business']['languages'];
                    unset($data['Business']['languages']);
                }
            } else {
                $data['Business']['preferred_location'] = '';
                $data['Business']['free_demo_class'] = '';
                $data['Business']['education'] = '';
                $data['Business']['experience'] = '';
                $data['Business']['dob'] = '';
                $data['Business']['tagline'] = '';
                $data['Business']['established'] = '';
            }

            $dir_path = $data['Business']['dir_path'];
            unset($data['Business']['dir_path']);
            if (is_array($data['Business'])) {
                foreach ($data['Business'] as $key => $val) {
                    $data['Business'][$key] = is_array($val) ? $val : trim($val);
                }
            }
            $this->Business->set($data);
            unset($this->Business->validate['phone']);
            if ($this->Business->validates(array('fieldList' => array('name', 'category_id', 'min_age_group',
                            'max_age_group', 'city_id', 'locality_id', 'address', 'pincode', 'contact_person', 'phone', 'email',
                            'gender', 'price')))) {
                $data['Business']['phone'] = trim($data['Business']['phone']);
                $data['Business']['status'] = '1';
                #$data['Business']['user_id'] = $this->Session->read('Auth.User.id');
                $this->Business->create();
                if ($this->Business->save($data)) {
                    $lst_bsns_id = $this->Business->id;

                    $this->loadModel('BusinessFacility');
                    if (is_array($facilities) && count($facilities) > 0) {
                        $facility_data = array();
                        foreach ($facilities as $k => $v) {
                            $facility_condition = array('business_id' => $lst_bsns_id, 'facility_id' => $v);
                            if (!$this->BusinessFacility->hasAny($facility_condition)) {
                                $facility_data[] = array('business_id' => $lst_bsns_id, 'facility_id' => $v);
                            }
                        }
                        if (is_array($facility_data) && count($facility_data) > 0) {
                            $this->BusinessFacility->saveAll($facility_data);
                        }
                    }

                    $this->loadModel('BusinessCategory');
                    if (is_array($categories) && count($categories) > 0) {
                        $category_data = array();
                        foreach ($categories as $k => $v) {
                            $category_condition = array('business_id' => $lst_bsns_id, 'category_id' => $v);
                            if (!$this->BusinessCategory->hasAny($category_condition)) {
                                $category_data[] = array('business_id' => $lst_bsns_id, 'category_id' => $v);
                            }
                        }
                        if (is_array($category_data) && count($category_data) > 0) {
                            $this->BusinessCategory->saveAll($category_data);
                        }
                    }

                    if (!empty($languages) && is_array($languages) && count($languages) > 0) {
                        $this->loadModel('BusinessLanguage');
                        $language_data = array();
                        foreach ($languages as $k => $v) {
                            $language_data[] = array('business_id' => $lst_bsns_id, 'lang_id' => $v);
                        }
                        if (is_array($language_data) && count($language_data) > 0) {
                            $this->BusinessLanguage->saveAll($language_data);
                        }
                    }

                    /* saving keywords */
                    $this->loadModel('BusinessKeyword');
                    if (is_array($keyword) && count($keyword) > 0) {
                        $keyword_data = array();
                        foreach ($keyword as $v) {
                            if (trim(h($v)) != '') {
                                $keyword_condition = array('business_id' => $lst_bsns_id, 'keyword' => h($v));
                                if (!$this->BusinessKeyword->hasAny($keyword_condition)) {
                                    $keyword_data[] = array('business_id' => $lst_bsns_id, 'keyword' => trim($v));
                                }
                            }
                        }
                        if (is_array($keyword_data) && count($keyword_data) > 0) {
                            $this->BusinessKeyword->saveAll($keyword_data);
                        }
                    }

                    $this->Flash->AdminSuccess(__('The business has been saved.'));
                    $this->redirect(array('controller' => 'business_galleries', 'action' => 'add', 'admin' => 1, $lst_bsns_id, "pics"));
                } else {
                    $this->Flash->AdminError(__('The business could not be saved. Please, try again.'));
                    #$errors = $this->Business->invalidFields();pr($errors);exit;
                }
            } else {
                #$errors = $this->Business->invalidFields();pr($errors);exit;
                $this->Flash->AdminError(__("Validation error. Please, try again."));
            }
        }
        $cities = $this->Format->cities('list', 'business');
        $this->set('cities', $cities);

        $this->loadModel("Package");
        $packages = $this->Package->find('list', array('fields' => array('Package.id', 'Package.name')));
        $this->set('packages', $packages);

        $this->loadModel("Facility");
        $facilities = $this->Facility->find('list', array('fields' => array('id', 'name'), 'order' => array('name' => 'ASC')));
        $this->set('facilities', $facilities);
        $this->set('users', $this->Format->get_users());
    }

    /**
     * admin_edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_edit($id = null, $action = null) {
        if (!$this->Business->exists($id)) {
            throw new NotFoundException(__('Invalid business'));
        }
        if ($this->request->is(array('post', 'put'))) {
            $BusinessId = $this->request->data['Business']['id'];
            $id = isset($this->request->params['pass'][0]) ? trim($this->request->params['pass'][0]) : $BusinessId;
            $mode = isset($this->request->params['pass'][1]) ? trim($this->request->params['pass'][1]) : "info";
            $data = $this->request->data;
            $languages = array();
            $type = (isset($data['Business']['type'])) ? $data['Business']['type'] : 'group';
            if ($mode == 'info') {
                $subcategory_id = !empty($data['Business']['subcategory_id']) ? $data['Business']['subcategory_id'] : array();
                unset($data['Business']['subcategory_id']);

                $facilities = !empty($data['Business']['facilities']) ? $data['Business']['facilities'] : array();
                unset($data['Business']['facilities']);

                $categories = !empty($data['Business']['category_id']) ? $data['Business']['category_id'] : array();
                unset($data['Business']['category_id']);

                $keyword = !empty($data['Business']['keyword']) ? explode(",", $data['Business']['keyword']) : array();
                unset($data['Business']['keyword']);

                if (!empty($data['Business']['student_ratio']) && !empty($data['Business']['teacher_ratio'])) {
                    $data['Business']['ratio'] = trim($data['Business']['student_ratio']) . ":" . trim($data['Business']['teacher_ratio']);
                } else {
                    $data['Business']['ratio'] = '';
                }
                unset($data['Business']['student_ratio']);
                unset($data['Business']['teacher_ratio']);


                if ($type == 'private') {
                    if (isset($data['Business']['dob'])) {
                        $data['Business']['dob'] = date('Y-m-d', strtotime($data['Business']['dob']));
                    }
                    if (isset($data['Business']['established'])) {
                        $data['Business']['established'] = date('Y-m-d', strtotime($data['Business']['established']));
                    }
                    if (isset($data['Business']['languages'])) {
                        $languages = $data['Business']['languages'];
                    }
                } else {
                    $data['Business']['preferred_location'] = '';
                    $data['Business']['free_demo_class'] = '';
                    $data['Business']['tagline'] = '';
                    $data['Business']['education'] = '';
                    $data['Business']['experience'] = '';
                    $data['Business']['dob'] = '';
                    $data['Business']['established'] = '';
                }
                $data['Business']['type'] = $type;
                unset($data['Business']['languages']);
                if (empty($data['Business']['discount_allowed'])) {
                    $data['Business']['discount_allowed'] = 'no';
                    $data['Business']['discount_amount'] = 0;
                    $data['Business']['discount_type'] = NULL;
                } else {
                    $data['Business']['discount_type'] = empty($data['Business']['discount_type']) ? "percentage" : $data['Business']['discount_type'];
                }
            }
            if (is_array($data['Business'])) {
                foreach ($data['Business'] as $key => $val) {
                    $data['Business'][$key] = is_array($val) ? $val : trim($val);
                }
            }
            #pr($data);exit;
            $this->Business->id = $id;
            $this->Business->set($data);
            unset($this->Business->validate['phone']);
            if ($this->Business->validates()) {
                if ($this->Business->save($data)) {
                    $last_bsns_id = $this->Business->id;

                    $this->Business->id = $last_bsns_id;

                    if ($mode == 'info') {
                        $this->loadModel('BusinessCategory');
                        if (is_array($categories) && count($categories) > 0) {
                            $category_data = array();
                            foreach ($categories as $k => $v) {
                                $category_condition = array('business_id' => $id, 'category_id' => $v);
                                if (!$this->BusinessCategory->hasAny($category_condition)) {
                                    $category_data[] = array('business_id' => $id, 'category_id' => $v);
                                }
                            }
                            if (!empty($category_data)) {
                                $this->BusinessCategory->saveAll($category_data);
                            }
                            $del_opti = array('BusinessCategory.business_id' => $id, 'NOT' => array('BusinessCategory.category_id' => $categories));
                            $this->BusinessCategory->deleteAll($del_opti);
                        }

                        $this->loadModel('BusinessFacility');
                        if (is_array($facilities) && count($facilities) > 0) {
                            $facility_data = array();
                            foreach ($facilities as $k => $v) {
                                $facility_condition = array('business_id' => $id, 'facility_id' => $v);
                                if (!$this->BusinessFacility->hasAny($facility_condition)) {
                                    $facility_data[] = array('business_id' => $id, 'facility_id' => $v);
                                }
                            }
                            if (is_array($facility_data) && count($facility_data) > 0) {
                                $this->BusinessFacility->saveAll($facility_data);
                            }
                            $del_opt = array('BusinessFacility.business_id' => $id, 'NOT' => array('BusinessFacility.facility_id' => $facilities));
                            $this->BusinessFacility->deleteAll($del_opt);
                        }

                        /* saving keywords */
                        $this->loadModel('BusinessKeyword');
                        if (is_array($keyword) && count($keyword) > 0) {
                            $keyword_data = array();
                            foreach ($keyword as $v) {
                                if (trim(h($v)) != '') {
                                    $keyword_condition = array('business_id' => $id, 'keyword' => h($v));
                                    if (!$this->BusinessKeyword->hasAny($keyword_condition)) {
                                        $keyword_data[] = array('business_id' => $id, 'keyword' => trim($v));
                                    }
                                }
                            }
                            #pr($keyword_data);exit;
                            if (is_array($keyword_data) && count($keyword_data) > 0) {
                                $this->BusinessKeyword->saveAll($keyword_data);
                            }
                            $del_opt = array('BusinessKeyword.business_id' => $id, 'NOT' => array('BusinessKeyword.keyword' => $keyword));
                            $this->BusinessKeyword->deleteAll($del_opt);
                        }

                        $this->loadModel('BusinessLanguage');
                        if ($type == 'private') {
                            if (isset($languages) && !empty($languages) && is_array($languages) && count($languages) > 0) {
                                $language_data = array();
                                foreach ($languages as $k => $v) {
                                    $language_condition = array('business_id' => $id, 'lang_id' => $v);
                                    if (!$this->BusinessLanguage->hasAny($language_condition)) {
                                        $language_data[] = array('business_id' => $id, 'lang_id' => $v);
                                    }
                                }
                                if (is_array($language_data) && count($language_data) > 0) {
                                    $this->BusinessLanguage->saveAll($language_data);
                                }
                                $del_opt = array('BusinessLanguage.business_id' => $id, 'NOT' => array('BusinessLanguage.lang_id' => $languages));
                                $this->BusinessLanguage->deleteAll($del_opt);
                            }
                        } else {
                            $del_opt = array('BusinessLanguage.business_id' => $id);
                            $this->BusinessLanguage->deleteAll($del_opt);
                        }
                    }
                    $this->Flash->AdminSuccess(__('The business has been saved.'));
                    switch ($action) {
                        case 'info':
                            $path = 'info';
                            break;
                        case 'additional_info':
                            $path = 'additional_info';
                            break;
                        case 'venue':
                            $path = 'venue';
                            break;
                        case 'contact':
                            $path = 'contact';
                            break;
                        default:
                            break;
                    }
                    if ($mode == 'additional_info' && $type == 'group') {
                        $path = 'info';
                    }
                    $this->redirect(array('action' => 'edit', 'admin' => 1, $last_bsns_id, $path));
                } else {
                    $this->Flash->AdminError(__('The business could not be saved. Please, try again.'));
                }
            } else {
                $this->Flash->AdminError(__('The business could not be saved due to invlid inputs. try again.'));
            }
        } else {
            $options = array('conditions' => array('Business.' . $this->Business->primaryKey => $id));
            $this->request->data = $this->Business->find('first', $options);
            if (!empty($this->request->data['Business']['ratio'])) {
                $ratio_arr = explode(":", $this->request->data['Business']['ratio']);
                $this->request->data['Business']['student_ratio'] = $ratio_arr[0];
                $this->request->data['Business']['teacher_ratio'] = $ratio_arr[1];
                unset($this->request->data['Business']['ratio']);
            }
            $categories = Hash::combine($this->request->data['Category'], "{n}.id", "{n}.id");
            $facilities = Hash::combine($this->request->data['Facility'], "{n}.id", "{n}.id");
            $subcategories = Hash::combine($this->request->data['SubCategory'], "{n}.id", "{n}.id");
            $BusinessLanguage = Hash::combine($this->request->data['BusinessLanguage'], "{n}.id", "{n}.lang_id");
            $BusinessKeyword = is_array($this->request->data['BusinessKeyword']) && count($this->request->data['BusinessKeyword']) > 0 ? implode(",", Hash::extract($this->request->data['BusinessKeyword'], "{n}.keyword")) : "";

            $this->request->data['BusinessKeyword'] = $BusinessKeyword;
            $this->request->data['Business']['subcategory_id'] = $subcategories;
            $this->request->data['Business']['category_id'] = $categories;
            $this->request->data['Business']['facilities'] = $facilities;
            $this->request->data['Business']['languages'] = $BusinessLanguage;

            $cities = $this->Format->cities('list', 'business');
            #$cities = $this->Format->getCityList();
            $this->set('cities', $cities);


            $this->loadModel("Facility");
            $facilities = $this->Facility->find('list', array('fields' => array('id', 'name'), 'order' => array('name' => 'ASC')));
            $this->set('facilities', $facilities);
            $this->set('users', $this->Format->get_users());
            $this->set('subscription', SSP::get_subscription($this->request->data['Business']['user_id']));
        }
    }

    /**
     * admin_delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_delete($id = null) {
        $this->Business->id = $id;
        if (!$this->Business->exists()) {
            throw new NotFoundException(__('Invalid business'));
        }
        if ($this->Business->delete()) {
            $this->Flash->AdminSuccess(__('The business has been deleted.'));
        } else {
            $this->Flash->AdminError(__('The business could not be deleted. Please, try again.'));
        }
        return $this->redirect(array('action' => 'index'));
    }

    public function admin_grant_business($id = null) {
        $this->Business->id = $id;
        if ($this->Business->exists()) {
            $options['joins'] = array(
                array('table' => 'users', 'alias' => 'User', 'type' => 'LEFT', 'conditions' => array('User.id = Business.user_id'))
            );
            $options['fields'] = array('User.name', 'User.email', 'User.id', 'Business.id', 'Business.name', 'Business.email', 'Business.status', 'Business.created');
            $options['conditions'] = array('Business.id' => $id);
            $options['recursive'] = -1;
            $statusData = $this->Business->find('first', $options);
            $business_status_val = (intval($statusData['Business']['status']) == 2) ? 1 : 2;
            $business_status_msg = (intval($statusData['Business']['status']) == 1) ? 'Business Disabled' : 'Business Enabled';
            $business_status = (intval($statusData['Business']['status']) == 1) ? 'disabled' : 'enabled';
            if ($this->Business->saveField('status', $business_status_val)) {
                /* email to user */
                /* load email config class and keep the conenection open untill all mails are sent */
                if ($statusData['User']['email'] != '') {
                    $Email = new CakeEmail(Configure::read('EMAIL_DELIVERY_MODE'));
                    $Email->config(array('persistent' => true));

                    $Email->from(array(Configure::read('COMPANY.FROM_EMAIL') => Configure::read('COMPANY.NAME')));
                    $Email->viewVars(array('for' => 'user', 'name' => $statusData['User']['name'],
                        'businessName' => $statusData['Business']['name'], 'created' => $statusData['Business']['created'],
                        'business_status' => $business_status
                            )
                    );
                    $Email->to($statusData['User']['email']);
                    $Email->subject('Your Business ' . ($business_status == 'enabled' ? "Approved" : "Disapproved") . ' - ' . Configure::read('COMPANY.NAME'));
                    $Email->template('business_approval');
                    $Email->send();

                    $is_subscribed = SSP::get_subscription($statusData['User']['id']);
                    if (!empty($is_subscribed)) {
                        if ($is_subscribed['Subscription']['status'] == '0') {
                            $date = date("Y-m-d H:i:s");
                            $offer = json_decode($is_subscribed['Subscription']['offer'], true);
                            $period_duration = (trim($offer['period_type']) == "Year") ? intval($offer['period_duration']) * 12 : intval($offer['period_duration']);
                            $offer_duration = $period_duration * 30;
                            $expire = time() + $offer_duration * 24 * 60 * 60;
                            $expiration_date = date("Y-m-d H:i:s", strtotime(date("Y-m-d", $expire)));
                            $update_sub['Subscription'][] = array(
                                'id' => $is_subscribed['Subscription']['id'],
                                'subscription_start' => date('Y-m-d H:i:s', strtotime(date("Y-m-d"))),
                                'subscription_end' => $expiration_date,
                                'status' => '1'
                            );
                            if ($this->Subscription->saveAll($update_sub['Subscription'])) {
                                $Email->from(array(Configure::read('COMPANY.FROM_EMAIL') => Configure::read('COMPANY.NAME')));
                                $Email->viewVars(array('for' => 'user', 'name' => $statusData['User']['name'], 'packageName' => $is_subscribed['Subscription']['name']));
                                $Email->to($statusData['Business']['email']);
                                $Email->subject('Your subscription is active - ' . Configure::read('COMPANY.NAME'));
                                $Email->template('subscription_active');
                                $Email->send();
                            }
                        }
                    }
                    /* Disconnect email connection */
                    if (Configure::read('EMAIL_DELIVERY_MODE') == 'smtp') {
                        $Email->disconnect();
                    }

                    $this->Flash->AdminSuccess(__($business_status_msg));
                    $this->redirect(array('action' => 'index', 'admin' => 1));
                } else {
                    $this->Flash->AdminError(__('Operation Failed.'));
                }
            } else {
                $this->Flash->AdminError(__('Invalid Business'));
            }
        }
    }

    public function admin_get_facilities() {
        $this->layout = 'ajax';
        $this->loadModel('BusinessFacility');
        $options_bsfacility = array('fields' => array('BusinessFacility.id', 'BusinessFacility.facility_id'), 'conditions' => array('BusinessFacility.business_id' => $this->request->data['id']));
        $facilities_id = $this->BusinessFacility->find('list', $options_bsfacility);
        $this->loadModel('Facility');
        $options_facility = array('fields' => array('Facility.id', 'Facility.name'), 'conditions' => array('Facility.id' => $facilities_id));
        $facilities = $this->Facility->find('all', $options_facility);
        print(json_encode($facilities));
        exit;
    }

    function ajax_post_review() {
        $this->layout = 'ajax';
        pr($this->request->data);
        echo urldecode($this->request->data['review']);
        exit;
    }

    function manage() {
        
    }

    function queries() {
        
    }

    function book_now($BusinessId) {
        $this->layout = 'ajax';
        //echo $BusinessId = $this->request->query('id');exit;
        $this->Business->recursive = false;
        $business = $this->Business->find('first', array('conditions' => array('Business.id' => $BusinessId)));
        $this->set('BusinessId', $BusinessId);
        $this->set('business', $business);
    }

    function ajax_save_bookings($BusinessId) {
        $this->layout = 'ajax';
        $this->loadModel('Business');
        $this->loadModel('BusinessBooking');
        $this->loadModel('BusinessBookingDetail');
        $data = $this->request->data;
        #$reference_code = $this->Format->genRandomString(10, 'uppercase');
        $reference_code = $this->Format->getUniqBookingReferenceCode();
        $bookings['BusinessBooking'] = array(
            'business_id' => $BusinessId,
            'user_id' => $this->Session->read('Auth.User.id'),
            'from_date' => date("Y-m-d H:i:s", strtotime($data['from_date'])),
            'to_date' => trim($data['to_date']) != '' ? date("Y-m-d H:i:s", strtotime($data['to_date'])) : '',
            'seats' => intval($data['seats']),
            'approved' => '0',
            'reference_code' => $reference_code,
        );
        #pr($data);exit;
        #pr($bookings);exit;
        $this->BusinessBooking->save($bookings);
        $id = $this->BusinessBooking->id;

        $details = array();
        if (!empty($data['BookNow']) && $id > 0) {
            foreach ($data['BookNow'] as $val) {
                if (trim($val['name']) != '' && trim($val['age']) != '') {
                    $details[] = array('booking_id' => $id, 'name' => trim($val['name']), 'age' => trim($val['age']));
                }
            }
        }

        $cnt = count($details);
        $this->BusinessBookingDetail->saveAll($details);
        $this->BusinessBooking->save(array('id' => $id, 'seats' => $cnt));

        $business = $this->Business->find('first', array('conditions' => array('Business.id' => $BusinessId)));
        $Email = new CakeEmail(Configure::read('EMAIL_DELIVERY_MODE'));
        $Email->config(array('persistent' => true));

        /* new booking request email sent to business owner contact person */
        $Email->from(array(Configure::read('COMPANY.FROM_EMAIL') => Configure::read('COMPANY.NAME')));
        $Email->viewVars(array('business' => $business, 'bookings' => $bookings, 'details' => $details,
            'name' => trim($business['Business']['contact_person']) != "" ? $business['Business']['contact_person'] : "User",
            'to' => 'owner'));
        $Email->to($business['Business']['email']);
        $Email->subject('Booking request for ' . $business['Business']['name'] . " - " . Configure::read('COMPANY.NAME'));
        $Email->template('booking_request');
        $Email->send();

        /* email to admin */
        $Email->from(array(Configure::read('COMPANY.FROM_EMAIL') => Configure::read('COMPANY.NAME')));
        $Email->viewVars(array('business' => $business, 'bookings' => $bookings, 'details' => $details, 'name' => 'Admin'));
        $Email->to(Configure::read('COMPANY.ADMIN_EMAIL'));
        $Email->subject('Booking request for ' . $business['Business']['name'] . " - " . Configure::read('COMPANY.NAME'));
        $Email->template('booking_request');
        $Email->send();

        /* email to booking user */
        $Email->from(array(Configure::read('COMPANY.FROM_EMAIL') => Configure::read('COMPANY.NAME')));
        $Email->viewVars(array('business' => $business, 'bookings' => $bookings, 'details' => $details, 'name' => $this->Session->read('Auth.User.name'),
            'to' => 'booker'));
        $Email->to($this->Session->read('Auth.User.email'));
        $Email->subject('Booking request for ' . $business['Business']['name'] . " - " . Configure::read('COMPANY.NAME'));
        $Email->template('booking_request');
        $Email->send();

        if (Configure::read('EMAIL_DELIVERY_MODE') == 'smtp') {
            $Email->disconnect();
        }
        echo $id > 0 ? "success" : "error";
        exit;
    }

    function request_call() {
        $this->layout = 'ajax';
        $BusinessId = $this->request->pass[0];
        $business = $this->Business->find('first', array('conditions' => array('Business.id' => $BusinessId)));
        if ($this->request->is('post')) {
            $this->loadModel('Contact');
            $data = $this->request->data['CallRequest'];
            $call = array(
                'business_id' => $BusinessId,
                'name' => h($data['name']),
                'email' => h($data['email']),
                'phone' => h($data['phone']),
            );
            $this->Contact->save($call);


            $Email = new CakeEmail(Configure::read('EMAIL_DELIVERY_MODE'));
            $Email->config(array('persistent' => true));

            /* new request for call email sent to business owner */
            $Email->from(array(Configure::read('COMPANY.FROM_EMAIL') => Configure::read('COMPANY.NAME')));
            $Email->viewVars(array('business' => $business, 'call' => $call,
                'name' => trim($business['Business']['contact_person']) != "" ? $business['Business']['contact_person'] : "User",
                'extra' => 'owner'));
            $Email->to($business['Business']['email']);
            $Email->subject('Call request for ' . $business['Business']['name'] . " - " . Configure::read('COMPANY.NAME'));
            $Email->template('call_request');
            $Email->send();

            /* email to admin */
            $Email->from(array(Configure::read('COMPANY.FROM_EMAIL') => Configure::read('COMPANY.NAME')));
            $Email->viewVars(array('business' => $business, 'call' => $call, 'name' => 'Admin'));
            $Email->to(Configure::read('COMPANY.ADMIN_EMAIL'));
            $Email->subject('Call request for ' . $business['Business']['name'] . " - " . Configure::read('COMPANY.NAME'));
            $Email->template('call_request');
            $Email->send();

            /* email to user */
            if (trim($call['email']) != '') {
                $Email->from(array(Configure::read('COMPANY.FROM_EMAIL') => Configure::read('COMPANY.NAME')));
                $Email->viewVars(array('business' => $business, 'call' => $call, 'name' => $call['name'], 'extra' => 'user'));
                $Email->to($call['email']);
                $Email->subject('Call request for ' . $business['Business']['name'] . " - " . Configure::read('COMPANY.NAME'));
                $Email->template('call_request');
                $Email->send();
            }

            if (Configure::read('EMAIL_DELIVERY_MODE') == 'smtp') {
                $Email->disconnect();
            }
            echo "success";
            exit;
            $this->Flash->success(__('Call request send successfully.'));
            $this->redirect('/b-' . $BusinessId . "-" . $this->Format->seo_url($business['Business']['name']));
        }
        $this->set('BusinessId', $BusinessId);
        $this->set('business', $business);
    }

    /**
     * Used to get multiple phone number string 
     * requested with an ajax call in edit business
     * page.
     * @param business id
     * @return type json
     */
    function get_phone() {
        $this->layout = 'ajax';
        $BusinessId = $this->request->data['id'];
        $business = $this->Business->find('first', array('conditions' => array('Business.id' => $BusinessId), 'fields' => array('Business.phone'), 'recursive' => -1));
        print(json_encode($business));
        exit;
    }

    function update_business_views($id = '') {
        $user_id = $this->Session->read('Auth.User.id');
        if ($id > 0) {
            if ($id > 0 && $user_id > 0) {
                $this->loadModel('BusinessView');
                $view = $this->BusinessView->find("first", array("conditions" => array('BusinessView.business_id' => $id, 'BusinessView.user_id' => $user_id)));
                if (is_array($view) && count($view) > 0) {
                    $log['BusinessView'] = array('id' => $view['BusinessView']['id'], 'viewed_on' => date('Y-m-d H:i:s'), 'ip' => $this->request->clientIp());
                    $this->BusinessView->save($log);
                } else {
                    $log['BusinessView'] = array('business_id' => $id, 'user_id' => $user_id, 'viewed_on' => date('Y-m-d H:i:s'), 'ip' => $this->request->clientIp());
                    $this->BusinessView->save($log);
                }
            }
            $this->Business->updateAll(array('Business.views' => 'Business.views+1'), array('Business.id' => $id));
        }
        return;
    }

    public function admin_export_modal() {
        $this->layout = "ajax";
        $this->City = ClassRegistry::init('City');
        $params = array('conditions' => array('City.status' => '1', 'City.business_status' => '1'), 'fields' => array('City.id', 'City.name'), 'order' => array('City.name' => "ASC"));
        $cityList = $this->City->find('list', $params);
        $this->set('cities', $cityList);
        $categorie_ids = $this->Format->parent_categories('list', '');
        $this->set('categorie_ids', $categorie_ids);

        $this->loadModel('Package');
        $packages = $this->Package->find('list', array('fields' => array('Package.id', 'Package.name'), 'order' => array('Package.id ASC'), 'recursive' => -1));
        $this->set('packages', $packages);
    }

    public function admin_business_reports_sheets() {
        if (!empty($this->request->query)) {
            $params = $this->request->query;
            $options['conditions'] = array();
            if (!empty($params['category_id'])) {
                $options['conditions'][] = array('Business.id' => $this->Format->get_category_business_ids($params['category_id']));
            }
            if (!empty($params['city_id'])) {
                $options['conditions'][] = array('Business.city_id' => $params['city_id']);
            }
            if (!empty($params['plan_id'])) {
                if (intval($params['plan_id']) > 1) {
                    $options['conditions'][] = array('Subscription.package_id' => $params['plan_id']);
                } else {
                    $options['conditions'][] = array('OR' => array('Subscription.package_id' => $params['plan_id'], "Subscription.package_id IS NULL"));
                }
            }
            $options['conditions']['Business.status'] = '1';
            $options['contain'] = array('City', 'Locality');
            $options['fields'] = array('Business.*', 'GROUP_CONCAT(Category.name SEPARATOR ", ") AS category_name');
            $options['joins'] = array(
                array('table' => 'business_categories', 'alias' => 'BusinessCategory', 'type' => 'INNER', 'conditions' => array('BusinessCategory.business_id = Business.id')),
                array('table' => 'categories', 'alias' => 'Category', 'type' => 'INNER', 'conditions' => array('BusinessCategory.category_id = Category.id')),
                array('table' => 'subscriptions', 'alias' => 'Subscription', 'type' => 'LEFT', 'conditions' => array("Subscription.user_id = Business.user_id", "Subscription.status=1")),
            );


            $options['order'] = array('Business.name' => "ASC");
            $options['group'] = array('Business.id');
            $data = $this->Business->find('all', $options);

            $final_arr['header_arr'] = array('Name', 'Category', 'City', 'Locality', 'Address', 'Landmark', 'Pincode', 'Contact person', 'Phone', 'Email', 'Created On');
            $cnt = 0;
            $final_data = array();
            foreach ($data as $key => $value) {
                $final_data[] = array($value['Business']['name'], $value[0]['category_name'], $value['City']['name'], $value['Locality']['name'], $value['Business']['address'], $value['Business']['landmark'], $value['Business']['pincode'], $value['Business']['contact_person'], $value['Business']['phone'], $value['Business']['email'], (strtotime($value['Business']['created']) > 0) ? date('M d, Y g:i a', strtotime($value['Business']['created'])) : '');
            }
            $final_arr['data'] = $final_data;
            $file_name = "Business_info" . time() . ".xls";
            $this->Format->export_excel($file_name, $final_arr);
        }
        exit;
    }

    public function seo_url_unique() {
        $seo_url = trim(strtolower($this->request->data['Business']['seo_url']));
        $option['conditions'] = array('LOWER(Business.seo_url)' => $seo_url);
        $count = $this->Business->find('count', $option);
        echo ($count >= 1) ? 'false' : 'true';
        exit;
    }

    public function group_booking() {
        $this->layout = 'ajax';
        $ucities = $this->Format->cities('list', 'business');
        $this->set(compact('ucities'));
    }

    public function group_booking_save() {
        if ($this->request->is('ajax')) {
            $form_data = $this->request->data;
            $form_data['GroupBookingRequest']['created'] = date("Y-m-d H:i:s");
            $captcha = trim($this->Captcha->getCode('ask.refer_security_code'));
            if (strcmp(trim($form_data['ask']['refer_security_code']), $captcha) == 0) {
                unset($form_data['User']);
                $this->loadModel('GroupBookingRequest');
                if ($this->GroupBookingRequest->save($form_data)) {

                    $this->loadModel('Locality');
                    $addr_data = $this->Locality->find('first', array('conditions' => array('Locality.id' => $form_data['GroupBookingRequest']['locality_id'])));

                    /* load email config class and keep the conenection open untill all mails are sent */
                    $Email = new CakeEmail(Configure::read('EMAIL_DELIVERY_MODE'));
                    /* email to admin */
                    $Email->from(array(Configure::read('COMPANY.FROM_EMAIL') => Configure::read('COMPANY.NAME')));
                    $Email->viewVars(array('for' => 'admin', 'bookingData' => $form_data, 'cityLocality' => $addr_data));
                    $Email->to(Configure::read('COMPANY.ADMIN_EMAIL'));
                    $Email->subject("Group Booking Request");
                    $Email->template('group_booking_request');
                    $Email->send();

                    $res = array('status' => true);
                } else {
                    $res = array('status' => false);
                }
            } else {
                $res = array('status' => false, 'statusText' => 'Wrong answer. Please try again.');
            }
            echo json_encode($res);
        }exit;
    }

    public function verify_group_booking_captcha() {
        $form_data = $this->request->data;
        $captcha = trim($this->Captcha->getCode('ask.refer_security_code'));
        #echo $captcha;exit;
        if (strcmp(trim($form_data['ask']['refer_security_code']), $captcha) == 0) {
            echo 'true';
        } else {
            echo 'false';
        }
        exit;
    }

    public function admin_business_favorite() {
        if ($this->request->is('ajax')) {
            $table = 'business_favorites';
            $primaryKey = 'id';
            $columns = array(
                array('db' => '`bf`.`id`', 'dt' => 0, 'field' => 'id', 'as' => 'id'),
                array('db' => '`b`.`name`', 'dt' => 1, 'field' => 'business_name', 'as' => 'business_name'),
                array('db' => '`u`.`name`', 'dt' => 2, 'field' => 'user_name', 'as' => 'user_name'),
                array('db' => '`u`.`email`', 'dt' => 3, 'field' => 'email', 'as' => 'email'),
                array('db' => '`u`.`phone`', 'dt' => 4, 'field' => 'phone', 'as' => 'phone'),
                array('db' => '`bf`.`created`', 'dt' => 5, 'field' => 'created', 'as' => 'created'),
                array('db' => '`bf`.`is_complete`', 'dt' => 6, 'field' => 'is_complete', 'as' => 'is_complete')
            );
            $joinQuery = "FROM `business_favorites` AS `bf` "
                    . "LEFT JOIN `businesses` AS `b` ON (`b`.`id` = `bf`.`business_id`) "
                    . "LEFT JOIN `users` AS `u` ON (`u`.`id` = `bf`.`user_id`) ";
            $extraWhere = "";

            App::uses('SSP', 'Utility');
            $having = "Yes";
            $response = SSP::simple($_GET, $this->db_config, $table, $primaryKey, $columns, $joinQuery, $extraWhere);
            print(json_encode($response));
            exit;
        }
    }

    public function favorites() {
        $user_id = $this->Auth->user('id');
        $this->loadModel('BusinessFavorite');
        $this->loadModel('BusinessView');
        $all_favorites = $this->BusinessFavorite->find('all', array('conditions' => array('BusinessFavorite.user_id' => $user_id)));
        $results_business_ids = Hash::extract($all_favorites, '{n}.Business.id');
        $businesses = $this->Business->find('all', array('conditions' => array('Business.id' => $results_business_ids)));
        $this->set('businesses', $businesses);

        $this->BusinessView->bindModel(array('belongsTo' => array('User' => array('className' => 'User', 'foreignKey' => 'user_id'), 'Business' => array('className' => 'Business', 'foreignKey' => 'business_id'))));
        $params = array('conditions' => array('Business.status' => '1', 'BusinessView.user_id' => $user_id,));
        $params['fields'] = array('BusinessView.*', 'Business.name', 'Business.id', 'User.name', 'User.id');
        $params['order'] = array('BusinessView.viewed_on' => 'DESC');
        $view_data = $this->BusinessView->find('all', $params);
        $this->set('view_data', $view_data);
    }

    public function save_favorite_data() {
        $this->layout = 'ajax';
        if (!empty($this->request->data)) {
            $data = $this->request->data;
            $this->loadModel('BusinessFavorite');
            if (trim($data['user_data']['mark_status']) === "unmark") {
                $marked_data = $this->BusinessFavorite->find('first', array('conditions' => array('BusinessFavorite.user_id' => $data['user_data']['user_id'], 'BusinessFavorite.business_id' => $data['user_data']['business_id'])));
                if (!empty($marked_data)) {
                    $this->BusinessFavorite->delete($marked_data['BusinessFavorite']['id']);
                    $res = array('status' => true, 'statusText' => 'Business ' . $marked_data['Business']['name'] . ' successfully removed from your favorites.');
                } else {
                    $res = array('status' => false, 'statusText' => 'Sorry, this operation can not be completed right now. Please try again later.');
                }
            } else {
                $data_arr['BusinessFavorite']['user_id'] = $data['user_data']['user_id'];
                $data_arr['BusinessFavorite']['business_id'] = $data['user_data']['business_id'];
                if (!empty($data_arr['BusinessFavorite']['business_id']) && !empty($data_arr['BusinessFavorite']['user_id'])) {
                    if ($this->BusinessFavorite->save($data_arr)) {
                        $business_name = $this->Business->find('first', array('conditions' => array('Business.id' => $data['user_data']['business_id']), 'recursive' => -1, 'fields' => array('Business.name')));
                        $res = array('status' => true, 'statusText' => 'Business ' . $business_name['Business']['name'] . ' marked as your favorite successfully.');
                    } else {
                        $res = array('status' => false, 'statusText' => 'Sorry, this operation can not be completed right now. Please try again later.');
                    }
                } else {
                    $res = array('status' => false, 'statusText' => 'Invalid request.');
                }
            }
            echo json_encode($res);
            exit;
        }exit;
    }

    function admin_courses() {
        $this->loadModel('BusinessCourse');
        if (!empty($this->request->data)) {
            #pr($this->request->data);exit;
            $postArr = $this->request->data;
            $business_id = $postArr['Business']['id'];
            $page = $postArr['Business']['page'];
            $courses = $postArr['Business']['course'];
            if (is_array($courses)) {
                foreach ($courses as $key => $course) {
                    if (trim($course['name']) != '') {
                        # && $course['price'] != ''
                        $id = $course['id'];
                        $data = array(
                            'id' => $course['id'],
                            'name' => trim($course['name']),
                            'price' => $course['price'],
                            'business_id' => $business_id
                        );
                        $this->BusinessCourse->save($data);
                    }
                }
            }
            $this->Flash->AdminSuccess(__('Business courses saved successfully.'));
            $this->redirect(array('controller' => 'businesses', 'action' => 'courses', $business_id, $page));
            exit;
        }
        $business_id = $this->params['pass'][0];
        $params = array('conditions' => array("business_id" => $business_id));
        $courses = $this->BusinessCourse->find('all', $params);
        #pr($courses);exit;
        $this->set(compact('courses'));
    }

    function courses() {
        $this->loadModel('BusinessCourse');
        if (!empty($this->request->data)) {
            #pr($this->params->url);
            #pr($this->request->data);
            #exit;
            $postArr = $this->request->data;
            if (isset($postArr['mode']) && $postArr['mode'] == 'delete') {
                $this->BusinessCourse->delete($postArr['id']);
                echo json_encode(array('success' => 1));
                exit;
            }
            $business_id = $this->params['pass'][0];

            $courses = $postArr['Business']['course'];
            if (is_array($courses)) {
                foreach ($courses as $key => $course) {
                    if (trim($course['name']) != '') {
                        # && $course['price'] != ''
                        $id = $course['id'];
                        $data = array(
                            'id' => $course['id'],
                            'name' => trim($course['name']),
                            'price' => $course['price'],
                            'business_id' => $business_id
                        );
                        #if ($id > 0) {}
                        $this->BusinessCourse->save($data);
                    }
                }
            }
            $this->Flash->success(__('Business courses saved successfully.'));
            $this->redirect("/" . $this->params->url);
            exit;
        }
        $business_id = $this->params['pass'][0];
        $params = array('conditions' => array("business_id" => $business_id));
        $courses = $this->BusinessCourse->find('all', $params);
        #pr($courses);exit;
        $this->set(compact('courses', 'business_id'));
    }

}
