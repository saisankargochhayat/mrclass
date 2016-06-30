<?php

App::uses('AppController', 'Controller');

/**
 * Subscriptions Controller
 *
 * @property Subscription $Subscription
 * @property PaginatorComponent $Paginator
 * @property FlashComponent $Flash
 * @author Chinmaya Panigrahi
 */
class SubscriptionsController extends AppController {

    function beforeFilter() {
        parent::beforeFilter();
    }

    public function index($user_id = null) {
        $user_id = $this->Auth->user('id');
        $this->loadModel('User');
        if (!$this->User->exists($user_id)) {
            throw new NotFoundException(__(''));
        }
        $options['joins'] = array(
            array('table' => 'users', 'alias' => 'User', 'type' => 'LEFT', 'conditions' => array('User.id=Subscription.user_id')),
            array('table' => 'packages', 'alias' => 'Package', 'type' => 'LEFT', 'conditions' => array('Package.id=Subscription.package_id')),
        );
        $options['fields'] = array('Subscription.*', 'Package.*', 'User.*');
        $options['order'] = array('Subscription.id Desc');
        $options['conditions'] = array('Subscription.user_id' => $user_id);
        $options['recursive'] = -1;
        $subscription_data = $this->Subscription->find('all', $options);
        $this->set('subscriptions_data', $subscription_data);

        $business_count = intval($this->Format->get_business_count($user_id));
        $this->set(compact('business_count'));
    }

    /**
     * admin_index method
     *
     * @return void
     */
    public function admin_index() {
        $options['joins'] = array(
            array('table' => 'packages', 'alias' => 'Package', 'type' => 'LEFT', 'conditions' => array('Package.id=Subscription.package_id')),
            array('table' => 'users', 'alias' => 'User', 'type' => 'LEFT', 'conditions' => array('User.id=Subscription.user_id'))
        );
        $options['fields'] = array('Subscription.*', 'Package.name', 'User.name', 'User.id');
        $options['order'] = array('Subscription.id Desc');
        $options['recursive'] = -1;
        $subscription_data = $this->Subscription->find('all', $options);
        $this->set('subscriptions', $subscription_data);
    }

    /**
     * admin_view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_view($id = null) {
        if (!$this->Subscription->exists($id)) {
            throw new NotFoundException(__('Invalid subscription'));
        }
        $options = array('conditions' => array('Subscription.' . $this->Subscription->primaryKey => $id));
        $this->set('subscription', $this->Subscription->find('first', $options));
    }

    public function view($id = null) {
        if (!$this->Subscription->exists($id)) {
            throw new NotFoundException(__('Invalid subscription'));
        }
        $options = array('conditions' => array('Subscription.' . $this->Subscription->primaryKey => $id));
        $this->set('subscription_data', $this->Subscription->find('first', $options));
    }

    /**
     * admin_add method
     *
     * @return void
     */
    public function admin_add() {
        $this->loadModel('Package');
        $this->loadModel('User');
        $this->loadModel('Business');
        $this->loadModel('Transaction');

        if ($this->request->is('post')) {
            $form_data = $this->request->data;
            $package_id = $form_data['Subscription']['package_id'];
            $discount_id = $form_data['discount'];
            $user_id = $form_data['Subscription']['user_id'];
            $user_data = $this->User->findById($user_id);

            $options_active = array('conditions' => array('Business.user_id' => $user_id, 'Business.status' => '1'));
            $user_active_businesses = intval($this->Business->find('count', $options_active));


            $this->loadModel('PackageDiscount');
            $package_discount = $this->PackageDiscount->find('first', array('conditions' => array('PackageDiscount.id' => $discount_id), 'fields' => array('PackageDiscount.period_duration', 'PackageDiscount.period_type', 'PackageDiscount.discount', 'PackageDiscount.discount_type', 'PackageDiscount.created', 'PackageDiscount.modified', 'Package.*')));
            $offer = $package_discount['PackageDiscount'];
            $period_duration = (trim($offer['period_type']) == "Year") ? intval($offer['period_duration']) * 12 : intval($offer['period_duration']);
            $offer_duration = $period_duration * 30;

            //Build subscription array
            $subscription_data['Subscription'] = $package_discount['Package'];
            unset($subscription_data['Subscription']['id']);
            unset($subscription_data['Subscription']['status']);
            unset($subscription_data['Subscription']['created']);
            unset($subscription_data['Subscription']['modified']);
            $subscription_data['Subscription']['package_id'] = $transaction['Transaction']['package_id'] = $package_id;
            $subscription_data['Subscription']['offer'] = json_encode($package_discount['PackageDiscount']);
            $subscription_data['Subscription']['listing_period'] = $offer_duration;
            $subscription_data['Subscription']['user_id'] = $transaction['Transaction']['user_id'] = $ledger['Ledger']['user_id'] = $user_id;
            if (isset($form_data['Subscription']['subscription_start']) && !empty($form_data['Subscription']['subscription_start']) && isset($form_data['Subscription']['subscription_end']) && !empty($form_data['Subscription']['subscription_end'])) {
                $subscription_data['Subscription']['status'] = '1';
                $subscription_data['Subscription']['subscription_start'] = date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $form_data['Subscription']['subscription_start'])));
                $subscription_data['Subscription']['subscription_end'] = date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $form_data['Subscription']['subscription_end'])));
                $s_status_type = "active";
            } else {
                $subscription_data['Subscription']['status'] = '0';
                $s_status_type = "inactive";
            }
            $s_status = ($subscription_data['Subscription']['status'] == '0') ? false : true;

            //Build transaction array
            $transaction['Transaction']['mode'] = 'Cash';
            $transaction['Transaction']['status'] = 'Initiated';
            $transaction['Transaction']['issued_date'] = date('Y-m-d');
            $current_price_array = $this->Format->price_calculation($offer, $subscription_data['Subscription']['price']);

            $is_subscribed = $this->Subscription->find('first', array('conditions' => array('Subscription.user_id' => $user_id), 'fields' => array('Subscription.*', 'DATE_FORMAT(Subscription.subscription_start,"%Y-%m-%d") as subscription_start', 'DATE_FORMAT(Subscription.subscription_end,"%Y-%m-%d") as subscription_end'), 'order' => array('Subscription.created' => 'DESC'), 'recursive' => -1));
            if (!empty($is_subscribed)) {
                $s_change_type = ($package_id > $is_subscribed['Subscription']['package_id']) ? "upgraded" : "downgraded";
                $last_transaction = $this->Transaction->find('first', array('conditions' => array('Transaction.subscription_id' => $is_subscribed['Subscription']['id']), 'order' => array('Transaction.created' => 'DESC'), 'recursive' => -1));
                $subscription_status = $is_subscribed['Subscription']['status'];
                if (($subscription_status == "0") || ($subscription_status == "2")) {
                    //If last subscription is not active
                    //Cancel the last subscription
                    $this->Subscription->id = $is_subscribed['Subscription']['id'];
                    $this->Subscription->saveField('status', '2', false);
                    $this->Subscription->create();
                    if ($this->Subscription->save($subscription_data)) {
                        $subscription_id = $this->Subscription->id;
                        //Cancel the last transaction
                        if (!empty($last_transaction['Transaction']['id'])) {
                            $this->Transaction->id = $last_transaction['Transaction']['id'];
                            $this->Transaction->saveField('status', 'Cancelled', false);
                        }
                        //save the new transaction
                        $transaction['Transaction']['subscription_id'] = $ledger['Ledger']['subscription_id'] = $subscription_id;
                        $transaction['Transaction']['sub_total'] = $current_price_array['total_discountd_price'];
                        $transaction['Transaction']['discount'] = 0;
                        $transaction['Transaction']['final_price'] = $current_price_array['total_discountd_price'];
                        #$transaction['Transaction']['reference_number'] = $this->Format->invoice_number($subscription_id);
                        $transaction['Transaction']['user_detail'] = $this->User->user_details($user_id);
                        $this->Transaction->create();
                        if ($this->Transaction->save($transaction)) {
                            $TransactionId = $this->Transaction->id;
                            if ($TransactionId > 0) {
                                $this->Transaction->id = $TransactionId;
                                $this->Transaction->saveField('reference_number', $this->Format->invoice_number($TransactionId), false);
                            }
                        }
                        //$ledger['Ledger']['credit'] = $total_balance_remained;
                        //$ledger['Ledger']['debit'] = $total_deduction_amount;
                        //$this->loadModel('Ledger');
                        //$this->Ledger->save($ledger);
                        /* new subscription email sent to business owner */
                        $subscription = $subscription_data['Subscription'];
                        if (!empty($user_data['User']['email'])) {
                            $Email = new CakeEmail(Configure::read('EMAIL_DELIVERY_MODE'));
                            $Email->from(array(Configure::read('COMPANY.FROM_EMAIL') => Configure::read('COMPANY.NAME')));
                            $Email->viewVars(array('Subscription' => $subscription, 'Transaction' => $transaction['Transaction'], 'name' => $user_data['User']['name'], 'month' => $period_duration, 'days' => $offer_duration, 'status' => $s_status));
                            $Email->to($user_data['User']['email']);
                            $Email->subject('Your Subscription Created - ' . Configure::read('COMPANY.NAME'));
                            $Email->template('admin_pending_subscription_notification');
                            $Email->send();
                        }
                        $this->Flash->AdminSuccess(__('Subscription has ben changed to ' . $subscription_data['Subscription']['name'] . ' successfully.'));
                    }
                } else {
                    //If last subscription is active
                    $subscription_start_date = $is_subscribed[0]['subscription_start'];
                    //Last subscription price array
                    $price_array = $this->Format->price_calculation(json_decode($is_subscribed['Subscription']['offer'], true), $is_subscribed['Subscription']['price']);
                    $rest_amount = $this->Format->get_deducted_balance($subscription_start_date, $price_array, $current_price_array);
                    //Cancel the last subscription
                    $this->Subscription->id = $is_subscribed['Subscription']['id'];
                    $this->Subscription->saveField('status', '2', false);

                    //save the new subscription
                    $this->Subscription->create();
                    if ($this->Subscription->save($subscription_data)) {
                        $subscription_id = $this->Subscription->id;
                        //Cancel the last transaction
                        if (!empty($last_transaction['Transaction']['id'])) {
                            $this->Transaction->id = $last_transaction['Transaction']['id'];
                            $this->Transaction->saveField('status', 'Cancelled', false);
                        }
                        //save the new transaction
                        $transaction['Transaction']['subscription_id'] = $ledger['Ledger']['subscription_id'] = $subscription_id;
                        $transaction['Transaction']['sub_total'] = $current_price_array['total_discountd_price'];
                        $transaction['Transaction']['discount'] = $rest_amount['total_balance_remained'];
                        $transaction['Transaction']['final_price'] = $rest_amount['total_price'];
                        #$transaction['Transaction']['reference_number'] = $this->Format->invoice_number($subscription_id);
                        $transaction['Transaction']['user_detail'] = $this->User->user_details($user_id);
                        $this->Transaction->create();
                        if ($this->Transaction->save($transaction)) {
                            $TransactionId = $this->Transaction->id;
                            if ($TransactionId > 0) {
                                $this->Transaction->id = $TransactionId;
                                $this->Transaction->saveField('reference_number', $this->Format->invoice_number($TransactionId), false);
                            }
                        }

                        //$ledger['Ledger']['credit'] = $total_balance_remained;
                        //$ledger['Ledger']['debit'] = $total_deduction_amount;
                        //$this->loadModel('Ledger');
                        //$this->Ledger->save($ledger);
                        $Email = new CakeEmail(Configure::read('EMAIL_DELIVERY_MODE'));
                        $Email->config(array('persistent' => true));

                        /* subscription change email sent to user */
                        if (!empty($user_data['User']['email'])) {
                            $Email->from(array(Configure::read('COMPANY.FROM_EMAIL') => Configure::read('COMPANY.NAME')));
                            $Email->viewVars(array('Subscription' => $subscription_data['Subscription'], 'Transaction' => $transaction['Transaction'], 'name' => $user_data['User']['name'], 'for' => 'User', 'packageName' => $is_subscribed['Subscription']['name'], 'type' => $s_change_type, 'status' => $s_status_type, 'month' => $period_duration, 'days' => $offer_duration));
                            $Email->to($user_data['User']['email']);
                            $Email->subject('Your Subscription changed - ' . Configure::read('COMPANY.NAME'));
                            $Email->template('subscription_notification');
                            $Email->send();
                        }
                        /* Disconnect email connection */
                        if (Configure::read('EMAIL_DELIVERY_MODE') == 'smtp') {
                            $Email->disconnect();
                        }
                        $this->Flash->AdminSuccess(__('Subscription has ben changed to ' . $subscription_data['Subscription']['name'] . ' successfully.'));
                    }
                }
            } else {
                if ($this->Subscription->save($subscription_data)) {
                    $subscription_id = $this->Subscription->id;
                    $price_array = $this->Format->price_calculation($offer, $subscription_data['Subscription']['price']);
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

                    if (!empty($user_data['User']['email'])) {
                        $Email = new CakeEmail(Configure::read('EMAIL_DELIVERY_MODE'));
                        /* new subscription email sent to business owner */
                        $Email->from(array(Configure::read('COMPANY.FROM_EMAIL') => Configure::read('COMPANY.NAME')));
                        $Email->viewVars(array('For' => 'User', 'Subscription' => $subscription_data['Subscription'], 'Transaction' => $transaction['Transaction'], 'name' => $user_data['User']['name'], 'month' => $period_duration, 'days' => $offer_duration, 'status' => $s_status));
                        $Email->to($user_data['User']['email']);
                        $Email->subject('Your Subscription Created - ' . Configure::read('COMPANY.NAME'));
                        $Email->template('admin_add_new_subscription_notification');
                        $Email->send();
                    }
                    $this->Flash->AdminSuccess(__('Subscription assigned to user successfully.'));
                }
            }
            $this->redirect(array('controller' => 'subscriptions', 'action' => 'index', 'admin' => 1));
        }
        if ($this->request->is('ajax')) {
            $row = array();
            $return_arr = array();
            $row_array = array();
            if ((isset($this->request->query['term']['term']) && strlen($this->request->query['term']['term']) > 0) || (isset($this->request->query['id']) && is_numeric($this->request->query['id']))) {
                if (isset($this->request->query['term']['term'])) {
                    $getVar = mysql_real_escape_string($this->request->query['term']['term']);
                    $whereClause = " name LIKE '%" . $getVar . "%' AND type = 2 AND status = '1'";
                } elseif (isset($this->request->query['id'])) {
                    $whereClause = " id = $getVar ";
                }
                /* limit with page_limit get */
                $sql = "SELECT id, CONCAT(name,' (',email,')') AS name FROM users WHERE $whereClause ORDER BY name";
                $sql .= isset($this->request->query['page_limit']) ? " LIMIT" . intval($this->request->query['page_limit']) : "";
                $result = $this->User->query($sql);

                if (!empty($result)) {
                    foreach ($result as $k => $v) {
                        $row_array['id'] = $v['users']['id'];
                        $row_array['text'] = utf8_encode($v[0]['name']);
                        array_push($return_arr, $row_array);
                    }
                }
            } else {
                $sql = "SELECT id, CONCAT(name,' (',email,')') AS name FROM users WHERE type = 2 AND status = '1' ORDER BY name";
                $result = $this->User->query($sql);
                if (!empty($result)) {
                    foreach ($result as $k => $v) {
                        $row_array['id'] = $v['users']['id'];
                        $row_array['text'] = utf8_encode($v[0]['name']);
                        array_push($return_arr, $row_array);
                    }
                }
            }
            $ret = array();
            $ret['results'] = $return_arr;
            echo json_encode($ret);
            exit;
        }
        //$this->set('users', $this->Format->get_users());
        $package_data = $this->Package->find('all', array('order' => array('Package.id Asc')));
        $this->set('package_data', $package_data);
    }

    public function admin_cancel_subscription($user_id = null, $subscription_id = null) {
        if (!$this->Subscription->exists($subscription_id)) {
            throw new NotFoundException(__('Invalid subscription'));
        }
        $this->loadModel('Transaction');
        $last_transaction = $this->Transaction->find('first', array('conditions' => array('Transaction.subscription_id' => $subscription_id), 'order' => array('Transaction.created' => 'DESC'), 'recursive' => -1));
        $this->loadModel("User");
        $user_data = $this->User->findById($user_id);
        $subscription_data = $this->Subscription->findById($subscription_id);

        //Cancel the last subscription
        $this->Subscription->id = $subscription_id;
        if ($this->Subscription->saveField('status', '2', false)) {
            //Cancel the last transaction
            if (!empty($last_transaction['Transaction']['id'])) {
                $this->Transaction->id = $last_transaction['Transaction']['id'];
                $this->Transaction->saveField('status', 'Cancelled', false);
            }
            if (!empty($user_data['User']['email'])) {
                $Email = new CakeEmail(Configure::read('EMAIL_DELIVERY_MODE'));
                /* new subscription email sent to business owner */
                $Email->from(array(Configure::read('COMPANY.FROM_EMAIL') => Configure::read('COMPANY.NAME')));
                $Email->viewVars(array('Subscription' => $subscription_data['Subscription'], 'name' => $user_data['User']['name']));
                $Email->to($user_data['User']['email']);
                $Email->subject('Your Subscription Cancelled - ' . Configure::read('COMPANY.NAME'));
                $Email->template('subscription_cancellation');
                $Email->send();
            }
            $this->Flash->AdminSuccess(__('Subscription cancelled successfully.'));
        }
        $this->redirect(array('controller' => 'subscriptions', 'action' => 'index', 'admin' => 1));
    }

    /**
     * admin_edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_edit($id = null) {
        if (!$this->Subscription->exists($id)) {
            throw new NotFoundException(__('Invalid subscription'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if ($this->Subscription->save($this->request->data)) {
                return $this->flash(__('The subscription has been saved.'), array('action' => 'index'));
            }
        } else {
            $options = array('conditions' => array('Subscription.' . $this->Subscription->primaryKey => $id));
            $this->request->data = $this->Subscription->find('first', $options);
        }
        $users = $this->Subscription->User->find('list');
        $this->set(compact('users'));
    }

    public function admin_check_subscription_status() {
        $id = $this->request->data['user_id'];
        $this->loadModel('Package');
        $this->loadModel('Business');
        $option['fields'] = array('Package.id', 'Package.name');
        $option['order'] = array('Package.id Asc');
        $packages = $this->Package->find('list', $option);
        $select_arr[] = array('id' => '', 'text' => 'Select Package');
        foreach ($packages as $key => $val) {
            $select_arr[] = array('id' => $key, 'text' => $val);
        }

        $options['fields'] = array('Package.id', 'Package.subscription');
        $options['order'] = array('Package.id Asc');
        $package_limits = $this->Package->find('list', $options);

        $resp = $this->common_user_subscription_details($id);
        if (!empty($resp['subscription_details'])) {
            if (intval($resp['status']) === 4 || intval($resp['status']) === 2) {
                if ((intval($resp['subscription_details']['price']) === 0)) {
                    $select_arr[1]['disabled'] = true;
                }
            }
        }
        $resp['active_business'] = $this->Business->find('count', array('conditions' => array('Business.user_id' => $id, 'Business.status' => '1')));
        $resp['package_list'] = $select_arr;
        $resp['package_limits'] = $package_limits;
        print(json_encode($resp));
        exit;
    }

    public function choose_subscription() {
        $from = (isset($this->request->query['from']) && !empty($this->request->query['from'])) ? $this->request->query['from'] : "index";
        $this->set('referer', $from);
        $this->loadModel('Package');
        $package_data = $this->Package->find('all', array('order' => array('Package.id Asc'), 'recursive' => -1));
        $user_id = $this->Auth->user('id');
        $is_subscription_exist = $this->Subscription->find('first', array('conditions' => array('Subscription.user_id' => $user_id), 'order' => array('Subscription.created' => 'DESC'), 'recursive' => -1));
        $option['fields'] = array('Package.id', 'Package.name');
        $option['order'] = array('Package.id Asc');
        $packages = $this->Package->find('list', $option);
        if (!empty($is_subscription_exist)) {
            $subscription_status = $is_subscription_exist['Subscription']['status'];
            $this->set('current_package_id', $is_subscription_exist['Subscription']['package_id']);
            $this->set('type', 'change');
        } else {
            $this->set('type', 'new');
        }
        $this->loadModel('Business');
        $this->set('active_business_count', $this->Business->find('count', array('conditions' => array('Business.user_id' => $user_id, 'Business.status' => '1'))));
        $this->set('packages', $packages);
        $this->set('package_data', $package_data);
    }

    public function change_subscription() {
        if ($this->request->is('post')) {
            $form_data = $this->request->data;
            $package_id = $form_data['package_id'];
            $discount_id = $form_data['discount'];
            $user_id = $this->Auth->user('id');
            $referer = trim($form_data['referer']);
            $redirect_url = ($referer == "add") ? array('controller' => 'businesses', 'action' => 'add') : array('controller' => 'subscriptions', 'action' => 'index');
            #$redirect_url = array('controller' => 'subscriptions', 'action' => 'index');

            $this->loadModel('Business');
            $this->loadModel('Transaction');
            $this->loadModel('Package');
            $this->loadModel('PackageDiscount');

            $options_active = array('conditions' => array('Business.user_id' => $user_id, 'Business.status' => '1'));
            $user_active_businesses = intval($this->Business->find('count', $options_active));

            $package_discount = $this->PackageDiscount->find('first', array('conditions' => array('PackageDiscount.id' => $discount_id), 'fields' => array('PackageDiscount.period_duration', 'PackageDiscount.period_type', 'PackageDiscount.discount', 'PackageDiscount.discount_type', 'PackageDiscount.created', 'PackageDiscount.modified', 'Package.*')));
            $offer = $package_discount['PackageDiscount'];
            $period_duration = (trim($offer['period_type']) == "Year") ? intval($offer['period_duration']) * 12 : intval($offer['period_duration']);
            $offer_duration = $period_duration * 30;
            $expire = time() + $offer_duration * 24 * 60 * 60;
            $start_date = date('Y-m-d H:i:s');
            $expiration_date = date("Y-m-d H:i:s", $expire);

            //Build subscription array
            $subscription_data['Subscription'] = $package_discount['Package'];
            unset($subscription_data['Subscription']['id']);
            unset($subscription_data['Subscription']['status']);
            unset($subscription_data['Subscription']['created']);
            unset($subscription_data['Subscription']['modified']);
            $subscription_data['Subscription']['offer'] = json_encode($package_discount['PackageDiscount']);
            $subscription_data['Subscription']['listing_period'] = $offer_duration;

            //Common variables
            $subscription_data['Subscription']['user_id'] = $transaction['Transaction']['user_id'] = $ledger['Ledger']['user_id'] = $user_id;
            $subscription_data['Subscription']['package_id'] = $transaction['Transaction']['package_id'] = $package_id;

            //Build transaction array
            $transaction['Transaction']['mode'] = 'Cash';
            $transaction['Transaction']['status'] = 'Initiated';
            $transaction['Transaction']['issued_date'] = date('Y-m-d');
            //New Subscription price array
            $current_price_array = $this->Format->price_calculation($offer, $subscription_data['Subscription']['price']);

            $is_subscription_exist = $this->Subscription->find('first', array('conditions' => array('Subscription.user_id' => $user_id), 'fields' => array('Subscription.*', 'DATE(Subscription.subscription_start) AS subscription_start', 'DATE(Subscription.subscription_end) AS subscription_end'), 'order' => array('Subscription.created' => 'DESC'), 'recursive' => -1));
            if (!empty($is_subscription_exist)) {

                $s_change_type = ($package_id > $is_subscription_exist['Subscription']['package_id']) ? "upgraded" : "downgraded";
                $last_transaction = $this->Transaction->find('first', array('conditions' => array('Transaction.subscription_id' => $is_subscription_exist['Subscription']['id']), 'order' => array('Transaction.created' => 'DESC'), 'recursive' => -1));
                $subscription_status = $is_subscription_exist['Subscription']['status'];

                if (($subscription_status == "0") || ($subscription_status == "2")) {
                    $s_status_type = "inactive";
                    //If last subscription is not active
                    $subscription_data['Subscription']['status'] = '0';
                    //Cancel the last subscription
                    $this->Subscription->id = $is_subscription_exist['Subscription']['id'];
                    $this->Subscription->saveField('status', '2', false);

                    $this->Subscription->create();
                    if ($this->Subscription->save($subscription_data)) {
                        $subscription_id = $this->Subscription->id;
                        //Cancel the last transaction
                        if (!empty($last_transaction['Transaction']['id'])) {
                            $this->Transaction->id = $last_transaction['Transaction']['id'];
                            $this->Transaction->saveField('status', 'Cancelled', false);
                        }
                        //save the new transaction
                        $transaction['Transaction']['subscription_id'] = $ledger['Ledger']['subscription_id'] = $subscription_id;
                        $transaction['Transaction']['sub_total'] = $current_price_array['total_discountd_price'];
                        $transaction['Transaction']['discount'] = 0;
                        $transaction['Transaction']['final_price'] = $current_price_array['total_discountd_price'];
                        #$transaction['Transaction']['reference_number'] = $this->Format->invoice_number($subscription_id);
                        $transaction['Transaction']['user_detail'] = $this->User->user_details($user_id);
                        $this->Transaction->create();
                        if ($this->Transaction->save($transaction)) {
                            $TransactionId = $this->Transaction->id;
                            if ($TransactionId > 0) {
                                $this->Transaction->id = $TransactionId;
                                $this->Transaction->saveField('reference_number', $this->Format->invoice_number($TransactionId), false);
                            }
                        }
                        //$ledger['Ledger']['credit'] = $total_balance_remained;
                        //$ledger['Ledger']['debit'] = $total_deduction_amount;
                        //$this->loadModel('Ledger');
                        //$this->Ledger->save($ledger);

                        $Email = new CakeEmail(Configure::read('EMAIL_DELIVERY_MODE'));
                        $Email->config(array('persistent' => true));

                        if (!empty($this->Session->read('Auth.User.email'))) {
                            /* subscription change email sent to user */
                            $Email->from(array(Configure::read('COMPANY.FROM_EMAIL') => Configure::read('COMPANY.NAME')));
                            $Email->viewVars(array('Subscription' => $subscription_data['Subscription'], 'Transaction' => $transaction['Transaction'], 'name' => $this->Session->read('Auth.User.name'), 'for' => 'User', 'month' => $period_duration, 'packageName' => $is_subscription_exist['Subscription']['name'], 'days' => $offer_duration, 'status' => $s_status_type, 'type' => $s_change_type));
                            $Email->to($this->Session->read('Auth.User.email'));
                            $Email->subject('Your Subscription changed - ' . Configure::read('COMPANY.NAME'));
                            $Email->template('subscription_change_notification');
                            $Email->send();
                        }

                        /* email to admin */
                        $Email->from(array(Configure::read('COMPANY.FROM_EMAIL') => Configure::read('COMPANY.NAME')));
                        $Email->viewVars(array('Subscription' => $subscription_data['Subscription'], 'Transaction' => $transaction['Transaction'], 'name' => $this->Session->read('Auth.User.name'), 'for' => 'Admin', 'packageName' => $is_subscription_exist['Subscription']['name'], 'type' => $s_change_type, 'status' => $s_status_type, 'month' => $period_duration, 'days' => $offer_duration));
                        $Email->to(Configure::read('COMPANY.ADMIN_EMAIL'));
                        $Email->subject('Subscription changed - ' . Configure::read('COMPANY.NAME'));
                        $Email->template('subscription_change_notification');
                        $Email->send();
                        /* send email to user and admin end */

                        /* Disconnect email connection */
                        if (Configure::read('EMAIL_DELIVERY_MODE') == 'smtp') {
                            $Email->disconnect();
                        }

                        $this->Flash->Success(__('Your subscription has ben changed to ' . $subscription_data['Subscription']['name'] . ' successfully.'));
                    }
                } else {
                    //If last subscription is active
                    $s_status_type = "active";
                    $subscription_start_date = $is_subscription_exist[0]['subscription_start'];
                    //Last subscription price array
                    $price_array = $this->Format->price_calculation(json_decode($is_subscription_exist['Subscription']['offer'], true), $is_subscription_exist['Subscription']['price']);
                    $rest_amount = $this->Format->get_deducted_balance($subscription_start_date, $price_array, $current_price_array);

                    $subscription_data['Subscription']['status'] = ($user_active_businesses > 0) ? '1' : '0';
                    if ($subscription_data['Subscription']['status'] == '1') {
                        $subscription_data['Subscription']['subscription_start'] = $start_date;
                        $subscription_data['Subscription']['subscription_end'] = $expiration_date;
                    }
                    //Cancel the last subscription
                    $this->Subscription->id = $is_subscription_exist['Subscription']['id'];
                    $this->Subscription->saveField('status', '2', false);

                    //save the new subscription
                    $this->Subscription->create();
                    if ($this->Subscription->save($subscription_data)) {
                        $subscription_id = $this->Subscription->id;
                        //Cancel the last transaction
                        if (!empty($last_transaction['Transaction']['id'])) {
                            $this->Transaction->id = $last_transaction['Transaction']['id'];
                            $this->Transaction->saveField('status', 'Cancelled', false);
                        }
                        //save the new transaction
                        $transaction['Transaction']['subscription_id'] = $ledger['Ledger']['subscription_id'] = $subscription_id;
                        $transaction['Transaction']['sub_total'] = $current_price_array['total_discountd_price'];
                        $transaction['Transaction']['discount'] = $rest_amount['total_balance_remained'];
                        $transaction['Transaction']['final_price'] = $rest_amount['total_price'];
                        #$transaction['Transaction']['reference_number'] = $this->Format->invoice_number($subscription_id);
                        $transaction['Transaction']['user_detail'] = $this->User->user_details($user_id);
                        $this->Transaction->create();
                        if ($this->Transaction->save($transaction)) {
                            $TransactionId = $this->Transaction->id;
                            if ($TransactionId > 0) {
                                $this->Transaction->id = $TransactionId;
                                $this->Transaction->saveField('reference_number', $this->Format->invoice_number($TransactionId), false);
                            }
                        }

                        //$ledger['Ledger']['credit'] = $total_balance_remained;
                        //$ledger['Ledger']['debit'] = $total_deduction_amount;
                        //$this->loadModel('Ledger');
                        //$this->Ledger->save($ledger);

                        $Email = new CakeEmail(Configure::read('EMAIL_DELIVERY_MODE'));
                        $Email->config(array('persistent' => true));
                        if (!empty($this->Session->read('Auth.User.email'))) {
                            /* subscription change email sent to user */
                            $Email->from(array(Configure::read('COMPANY.FROM_EMAIL') => Configure::read('COMPANY.NAME')));
                            $Email->viewVars(array('Subscription' => $subscription_data['Subscription'], 'Transaction' => $transaction['Transaction'], 'name' => $this->Session->read('Auth.User.name'), 'for' => 'User', 'month' => $period_duration, 'packageName' => $is_subscription_exist['Subscription']['name'], 'days' => $offer_duration, 'status' => $s_status_type, 'type' => $s_change_type));
                            $Email->to($this->Session->read('Auth.User.email'));
                            $Email->subject('Your Subscription changed - ' . Configure::read('COMPANY.NAME'));
                            $Email->template('subscription_change_notification');
                            $Email->send();
                        }

                        /* email to admin */
                        $Email->from(array(Configure::read('COMPANY.FROM_EMAIL') => Configure::read('COMPANY.NAME')));
                        $Email->viewVars(array('Subscription' => $subscription_data['Subscription'], 'Transaction' => $transaction['Transaction'], 'name' => $this->Session->read('Auth.User.name'), 'for' => 'Admin', 'packageName' => $is_subscription_exist['Subscription']['name'], 'type' => $s_change_type, 'status' => $s_status_type, 'month' => $period_duration, 'days' => $offer_duration));
                        $Email->to(Configure::read('COMPANY.ADMIN_EMAIL'));
                        $Email->subject('Subscription changed - ' . Configure::read('COMPANY.NAME'));
                        $Email->template('subscription_change_notification');
                        $Email->send();
                        /* send email to user and admin end */

                        /* Disconnect email connection */
                        if (Configure::read('EMAIL_DELIVERY_MODE') == 'smtp') {
                            $Email->disconnect();
                        }

                        $this->Flash->Success(__('Your subscription has ben changed to ' . $subscription_data['Subscription']['name'] . ' successfully.'));
                    }
                }
                $this->redirect($redirect_url);
            } else {
                if ($user_active_businesses > 0) {
                    $subscription_data['Subscription']['status'] = '1';
                    $subscription_data['Subscription']['subscription_start'] = $start_date;
                    $subscription_data['Subscription']['subscription_end'] = $expiration_date;
                    $s_status = true;
                    $s_flash = 'Thank you for subscribing to ' . $subscription_data['Subscription']['name'] . ' package.';
                } else {
                    $subscription_data['Subscription']['status'] = '0';
                    $s_status = false;
                    $s_flash = 'Thank you for subscribing to ' . $subscription_data['Subscription']['name'] . ' package. You subscription will be active upon admin\'s approval.';
                }
                if ($this->Subscription->save($subscription_data)) {
                    $subscription_id = $this->Subscription->id;
                    $price_array = $this->Format->price_calculation($package_discount ['PackageDiscount'], $subscription_data['Subscription']['price']);
                    $transaction['Transaction']['subscription_id'] = $subscription_id;
                    $transaction['Transaction']['sub_total'] = $price_array['total_discountd_price'];
                    $transaction['Transaction']['discount'] = 0;
                    $transaction['Transaction']['final_price'] = $price_array['total_discountd_price'];
                    #$transaction['Transaction']['reference_number'] = $this->Format->invoice_number($subscription_id);
                    $transaction['Transaction']['user_detail'] = $this->User->user_details($user_id);
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

                    /* Disconnect email connection */
                    if (Configure::read('EMAIL_DELIVERY_MODE') == 'smtp') {
                        $Email->disconnect();
                    }

                    $this->Flash->Success(__($s_flash));
                }
                $this->redirect($redirect_url);
            }
        }
    }

    public function check_package_constraints() {
        $package_id = $this->request->data['package_id'];
        $user_id = $this->Auth->user('id');
        $business_count = intval($this->Format->get_business_count($user_id));
        $this->loadModel('Package');
        $package_data = $this->Package->find('first', array('conditions' => array('Package.id' => $package_id)));
        $subscription_limit = intval($package_data['Package']['subscription']);
        if ($business_count > $subscription_limit) {
            $status = array('status' => false, 'message' => 'Your business limit exceeds the limit of the selected package. Please select a higher package.');
        } else {
            $status = array('status' => true, 'message' => 'Success');
        }
        $status['selected_package_details'] = $package_data['Package'];
        print(json_encode($status));
        exit;
    }

    public function check_user_subscription_details() {
        $id = $this->Auth->user('id');
        $this->loadModel('Business');
        $resp = $this->common_user_subscription_details($id);
        $resp['active_business'] = $this->Business->find('count', array('conditions' => array('Business.user_id' => $id, 'Business.status' => '1')));
        $resp['total_business'] = intval($this->Format->get_business_count($id));
        print(json_encode($resp));
        exit;
    }

    public function common_user_subscription_details($user_id) {
        $is_package_exist = $this->Subscription->find('first', array('conditions' => array('Subscription.user_id' => $user_id), 'fields' => array('Subscription.*', 'DATE_FORMAT(Subscription.subscription_start,"%Y-%m-%d") as subscription_start', 'DATE_FORMAT(Subscription.subscription_end,"%Y-%m-%d") as subscription_end', 'User.*'), 'order' => array('Subscription.created' => 'DESC')));
        if (!empty($is_package_exist)) {
            $business_count = intval($this->Format->get_business_count($user_id));
            $subscription_status = $is_package_exist['Subscription']['status'];
            if ($subscription_status == "0") {
                $resp = array('status' => 1, 'Message' => 'Subscription exist and approval pending by admin.', 'package_id' => $is_package_exist['Subscription']['package_id'], 'package_id' => $is_package_exist['Subscription']['package_id'], 'allow' => false);
            } elseif ($subscription_status == "2") {
                $resp = array('status' => 2, 'Message' => 'Subscription cancelled.', 'package_id' => $is_package_exist['Subscription']['package_id'], 'allow' => true);
            } else {
                $check_subscription_is_active = $this->Format->is_subscription_active($is_package_exist[0]['subscription_end']);
                $view = new View($this);
                $format = $view->loadHelper('Format');
                if ($check_subscription_is_active) {
                    $resp = array('status' => 3, 'Message' => 'Subscription is active and valid from ' . $format->dateFormat($is_package_exist[0]['subscription_start']) . ' to ' . $format->dateFormat($is_package_exist[0]['subscription_end']) . '.', 'package_id' => $is_package_exist['Subscription']['package_id'], 'allow' => false);
                } else {
                    $resp = array('status' => 4, 'Message' => 'Subscription ended on ' . $format->dateFormat($is_package_exist[0]['subscription_end']) . '.', 'package_id' => $is_package_exist['Subscription']['package_id'], 'allow' => true);
                }
                $resp['subscription_details'] = $is_package_exist['Subscription'];
            }
        } else {
            $resp = array('status' => 5, 'Message' => 'User not subscribed.', 'package_id' => '', 'allow' => true, 'subscription_details' => '');
        }
        return $resp;
    }

    public function admin_export_modal() {
        $this->layout = "ajax";
        $this->loadModel('Package');
        $packages = $this->Package->find('list', array('fields' => array('Package.id', 'Package.name'), 'order' => array('Package.id ASC'), 'recursive' => -1));
        $this->set('packages', $packages);
    }

    function admin_export_reports_sheets() {
        if (!empty($this->request->query)) {
            $params = $this->request->query;
            #pr($params);exit;
            $options['conditions'] = array();
            if (!empty($params['plan_id'])) {
                $options['conditions'][] = array('Subscription.package_id' => $params['plan_id']);
            }

            $options['joins'] = array(
                array('table' => 'packages', 'alias' => 'Package', 'type' => 'LEFT', 'conditions' => array('Package.id=Subscription.package_id')),
                array('table' => 'users', 'alias' => 'User', 'type' => 'LEFT', 'conditions' => array('User.id=Subscription.user_id'))
            );
            $options['fields'] = array('Subscription.*', 'Package.name', 'User.name', 'User.id');
            $options['order'] = array('Subscription.id Desc');
            $options['recursive'] = -1;
            $data = $this->Subscription->find('all', $options);
            #pr($data);#exit;

            $final_arr['header_arr'] = array('User', 'Package', 'Listing Period', 'Subscription Start', 'Subscription End', 'Status', 'Created');
            $cnt = 0;
            $final_data = array();
            foreach ($data as $key => $value) {
                $final_data[] = array($value['User']['name'], $value['Subscription']['name'], $value['Subscription']['listing_period'] . " days",
                    $this->Format->dateFormat($value['Subscription']['subscription_start']),
                    $this->Format->dateFormat($value['Subscription']['subscription_end']),
                    $this->Format->subscription_status($value['Subscription']['status'], $value['Subscription']),
                    $this->Format->dateFormat($value['Subscription']['created']),
                );
            }
            $final_arr['data'] = $final_data;
            #pr($final_arr);exit;
            $file_name = "subscriptions_" . date('YmdHis') . ".xls";
            $this->Format->export_excel($file_name, $final_arr);
        }
        exit;
    }

    function admin_renew_subscription($user_id = '', $subscription_id = '') {
        $this->loadModel('Subscription');
        $this->loadModel('Transaction');
        $this->loadModel('User');

        $params = array(
            'conditions' => array('Subscription.id' => $subscription_id),
            'fields' => array('Subscription.*', "User.id", "User.name", "User.email"),
        );
        $subscription_data = $this->Subscription->find('first', $params);
        $package_id = $subscription_data['Subscription']['package_id'];

        $params = array(
            'conditions' => array('Subscription.user_id' => $user_id, "Subscription.status" => 1),
            'fields' => array('Subscription.*', "User.id", "User.name", "User.email"),
            "order" => array('Subscription.subscription_end DESC', 'Subscription.id DESC')
        );
        #, "Subscription.package_id" => $package_id
        $last_subscription_data = $this->Subscription->find('first', $params);
        #pr($last_subscription_data);
        #exit;
        unset($subscription_data['Subscription']['id']);
        unset($subscription_data['Subscription']['created']);
        unset($subscription_data['Subscription']['modified']);

        $free_subscription_data = $subscription_data['Subscription'];
        $package_discount = json_decode($subscription_data['Subscription']['offer'], true);
        $current_price_array = $this->Format->price_calculation($package_discount, $free_subscription_data['price']);
        $period_duration = intval($package_discount['period_duration']) * (trim($package_discount['period_type']) == "Year" ? 12 : 1);
        $offer_duration = $period_duration * 30;
        /* if existing package is not expired, end date will be end date of current package */
        if (time() < strtotime($last_subscription_data['Subscription']['subscription_end'])) {
            $start_date = date('Y-m-d H:i:s', strtotime($last_subscription_data['Subscription']['subscription_end'] . " +1 day"));
        } else {
            $start_date = date('Y-m-d H:i:s');
        }
        $expire = strtotime($start_date) + $offer_duration * 24 * 60 * 60;
        $expiration_date = date("Y-m-d H:i:s", $expire);

        $free_subscription_data['subscription_start'] = $start_date;
        $free_subscription_data['subscription_end'] = $expiration_date;
        $free_subscription_data['status'] = 1;

        #pr($subscription_data);
        #pr($free_subscription_data);exit;
        $this->Subscription->create();
        if ($this->Subscription->save($free_subscription_data)) {
            $subscription_id = $this->Subscription->id;
            $transaction = array();
            $transaction['user_id'] = $user_id;
            $transaction['package_id'] = $package_id;
            $transaction['subscription_id'] = $subscription_id;
            $transaction['mode'] = 'Cash';
            $transaction['status'] = 'Initiated';
            $transaction['issued_date'] = date('Y-m-d');
            $transaction['subscription_id'] = $subscription_id;
            $transaction['sub_total'] = $current_price_array['total_discountd_price'];
            $transaction['discount'] = 0;
            $transaction['final_price'] = $current_price_array['total_discountd_price'];
            $transaction['user_detail'] = $this->User->user_details($user_id);

            #pr($transaction);
            $this->Transaction->create();
            if ($this->Transaction->save($transaction)) {
                $TransactionId = $this->Transaction->id;
                if ($TransactionId > 0) {
                    $this->Transaction->id = $TransactionId;
                    $this->Transaction->saveField('reference_number', $this->Format->invoice_number($TransactionId), false);
                }

                if (!empty($subscription_data['User']['email'])) {
                    $s_change_type = "renewed";
                    $s_status_type = "inactive";

                    $Email = new CakeEmail(Configure::read('EMAIL_DELIVERY_MODE'));
                    $Email->config(array('persistent' => true));
                    $Email->from(array(Configure::read('COMPANY.FROM_EMAIL') => Configure::read('COMPANY.NAME')));
                    $Email->viewVars(array('Subscription' => $free_subscription_data, 'Transaction' => $transaction,
                        'name' => $subscription_data['User']['name'], 'for' => 'User', 'month' => $period_duration,
                        'packageName' => $free_subscription_data['name'],
                        'days' => $offer_duration, 'status' => $s_status_type, 'type' => $s_change_type));
                    $Email->to(trim($subscription_data['User']['email']));
                    $Email->subject('Your Subscription renewed - ' . Configure::read('COMPANY.NAME'));
                    $Email->template('subscription_change_notification');
                    $Email->send();
                    if (Configure::read('EMAIL_DELIVERY_MODE') == 'smtp') {
                        $Email->disconnect();
                    }
                }
            }
        }
        $this->Flash->AdminSuccess(__('Subscription has been renewed successfully.'));
        $this->redirect(array('controller' => 'subscriptions', 'action' => 'index', 'admin' => 1));
    }

}
