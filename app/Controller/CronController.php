<?php

class CronController extends AppController {

    public function beforeFilter() {
        $this->Auth->allow();
        #parent::beforeFilter();
        $this->layout = 'ajax';
    }

    public function subscription_expiration_five() {
        $this->loadModel('Subscription');
        $subscription_data = $this->Subscription->find('all', array('conditions' => array('Subscription.status' => 1)));
        if (!empty($subscription_data)) {
            foreach ($subscription_data as $key => $value) {
                $expire_time = strtotime($value['Subscription']['subscription_end'] . ' -5 days');
                if (time() >= $expire_time) {
                    $this->send_remainder_email($value, 5);
                }
            }
        }
        exit;
    }

    public function subscription_expiration_two() {
        $this->loadModel('Subscription');
        $subscription_data = $this->Subscription->find('all', array('conditions' => array('Subscription.status' => 1)));
        if (!empty($subscription_data)) {
            foreach ($subscription_data as $key => $value) {
                $expire_time = strtotime($value['Subscription']['subscription_end'] . ' -2 days');
                if (time() >= $expire_time) {
                    $this->send_remainder_email($value, 2);
                }
            }
        }
        exit;
    }

    public function send_remainder_email($user_data, $days_before = 5) {
        if (!empty($user_data)) {
            /* email to user */
            $Email = new CakeEmail(Configure::read('EMAIL_DELIVERY_MODE'));
            $Email->config(array('persistent' => true));
            if (trim($user_data['User']['email']) != '') {
                $Email->from(array(Configure::read('COMPANY.FROM_EMAIL') => Configure::read('COMPANY.NAME')));
                $Email->viewVars(array('for' => 'user', 'name' => $user_data['User']['name'], 'packageName' => $user_data['Subscription']['name'], 'subscriptionEnd' => $user_data['Subscription']['subscription_end'], 'daysBefore' => $days_before));
                $Email->to($user_data['User']['email']);
                $Email->subject("Subscription renewal reminder for package " . $user_data['Subscription']['name'] . "");
                $Email->template('subscription_reminder');
                $Email->send();
            }
            /* Disconnect email connection */
            if (Configure::read('EMAIL_DELIVERY_MODE') == 'smtp') {
                $Email->disconnect();
            }
        }
    }

    public function subscription_expiration_on_date() {
        $this->loadModel('Subscription');
        $subscription_data = $this->Subscription->find('all', array('conditions' => array('Subscription.status' => 1)));
        if (!empty($subscription_data)) {
            $Email = new CakeEmail(Configure::read('EMAIL_DELIVERY_MODE'));
            $Email->config(array('persistent' => true));
            foreach ($subscription_data as $key => $value) {
                $expire_time = strtotime($value['Subscription']['subscription_end']);
                if (time() <= $expire_time) {
                    if (trim($value['User']['email']) != '') {
                        $Email->from(array(Configure::read('COMPANY.FROM_EMAIL') => Configure::read('COMPANY.NAME')));
                        $Email->viewVars(array('for' => 'user', 'name' => $value['User']['name'], 'packageName' => $value['Subscription']['name']));
                        $Email->to($value['User']['email']);
                        $Email->subject("Subscription expiration for your " . $value['Subscription']['name'] . " package.");
                        $Email->template('subscription_expiration');
                        $Email->send();
                    }
                }
            }
            /* Disconnect email connection */
            if (Configure::read('EMAIL_DELIVERY_MODE') == 'smtp') {
                $Email->disconnect();
            }
        }
        exit;
    }

    public function expire_and_assign_free_package() {
        $this->loadModel('Subscription');
        $this->loadModel('Transaction');
        $this->loadModel('User');
        $this->loadModel('Package');
        $counter = 0;

        #$this->loadModel('PackageDiscount');
        $params = array(
            'conditions' => array('Subscription.status' => 1, "DATE(Subscription.subscription_end) < CURDATE()"), #, "Subscription.package_id > 1"
            'fields' => array('Subscription.*', "User.id", "User.name", "User.email"),
                #"limit" => 1
        );
        $subscription_data = $this->Subscription->find('all', $params);
        #pr($subscription_data);#exit;

        if (!empty($subscription_data)) {
            $Email = new CakeEmail(Configure::read('EMAIL_DELIVERY_MODE'));
            $Email->config(array('persistent' => true));

            foreach ($subscription_data as $key => $value) {
                /* expire old subscription */
                $id = $value['Subscription']['id'];
                $this->Subscription->save(array('id' => $id, 'status' => 3), false);

                $this->logPackage(json_encode($value));

                /* free package details */
                $params = array('conditions' => array('Package.price' => 0));
                $package = $this->Package->find('first', $params);

                $user_id = $value['User']['id'];
                $package_id = $package['Package']['id'];

                unset($package['Package']['id']);
                unset($package['Package']['status']);
                unset($package['Package']['created']);
                unset($package['Package']['modified']);

                $package_discount = $package['PackageDiscount'][0];
                unset($package['PackageDiscount']);
                unset($package_discount['id']);
                unset($package_discount['package_id']);
                unset($package_discount['created']);
                unset($package_discount['modified']);

                $free_subscription_data = $package['Package'];
                $free_subscription_data['user_id'] = $user_id;
                $free_subscription_data['package_id'] = $package_id;
                $free_subscription_data['offer'] = json_encode($package_discount);
                $free_subscription_data['status'] = '1';

                $current_price_array = $this->Format->price_calculation($package_discount, $free_subscription_data['price']);
                $period_duration = intval($package_discount['period_duration']) * (trim($package_discount['period_type']) == "Year" ? 12 : 1);
                $offer_duration = $period_duration * 30;
                $expire = time() + $offer_duration * 24 * 60 * 60;
                $start_date = date('Y-m-d H:i:s');
                $expiration_date = date("Y-m-d H:i:s", $expire);
                $free_subscription_data['subscription_start'] = $start_date;
                $free_subscription_data['subscription_end'] = $expiration_date;
                $free_subscription_data['listing_period'] = $offer_duration;

                #pr($free_subscription_data);
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


                        if (!empty($value['User']['email'])) {
                            $s_change_type = ($package_id > $id) ? "upgraded" : "downgraded";
                            $s_status_type = "inactive";
                            $Email->from(array(Configure::read('COMPANY.FROM_EMAIL') => Configure::read('COMPANY.NAME')));
                            $Email->viewVars(array('Subscription' => $free_subscription_data, 'Transaction' => $transaction,
                                'name' => $value['User']['name'], 'for' => 'User', 'month' => $period_duration,
                                'packageName' => $package['Package']['name'],
                                'days' => $offer_duration, 'status' => $s_status_type, 'type' => $s_change_type));
                            $Email->to(trim($value['User']['email']));
                            $Email->subject('Your Subscription changed - ' . Configure::read('COMPANY.NAME'));
                            $Email->template('subscription_change_notification');
                            $Email->send();
                        }
                    }
                }

                $counter++;
            }
            if (Configure::read('EMAIL_DELIVERY_MODE') == 'smtp') {
                $Email->disconnect();
            }
        }
        $this->logPackage("Success. Total {$counter} users assigned free packages.");
        echo "Success. Total {$counter} users assigned free packages";
        exit;
    }

    function logPackage($text = '') {
        $fp = fopen(LOGS . 'package.log', 'a');
        fwrite($fp, print_r("Date: " . date('Y-m-d H:i:s') . " \n" . $text . "\n\n", true));
        fclose($fp);
        return true;
    }

}
