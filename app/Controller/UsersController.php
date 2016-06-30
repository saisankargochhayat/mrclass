<?php

App::uses('AppController', 'Controller');

/**
 * Users Controller
 *
 * @property User $User
 * @property PaginatorComponent $Paginator
 */
class UsersController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    var $name = 'Users';
    var $uses = array('User');
    public $helpers = array('Html', 'Form', 'Session', 'Time');
    public $components = array('Paginator');

    public function beforeFilter() {
        $this->Auth->allow(array('activate_account', 'registration_activation', 'forgot_password', 'admin_forgot_password',
            'admin_reset', 'logout', 'facebook_login_new', 'google_login_new', 'phone_unique_edit', 'email_unique_edit', 'username_unique_edit'));
        parent::beforeFilter();
    }

    public function login() {
        $title_for_layout = 'Login';
        $this->set(compact('title_for_layout'));
        if ($this->Auth->user()) {
            ($this->Auth->user('type') == '1') ? $this->redirect(array('action' => 'dashboard', 'admin' => 1)) : $this->redirect(array('action' => 'dashboard'));
        }
        if ($this->request->is('post')) {
            $this->User->recursive = false;
            $user = $this->User->findByPhone($this->request->data['User']['username']);
            if (is_array($user) && count($user) > 0) {
                $this->request->data['User']['username'] = $user['User']['username'];
            } else {
                $user = $this->User->findByUsername($this->request->data['User']['username']);
            }
            #pr($this->request->data);exit;
            if (isset($user['User']['status']) && $user['User']['status'] == '0') {
                $this->Flash->error(__('Your account is not activated.'));
                $this->redirect(array('action' => 'login'));
            } else {
                if ($this->Auth->login()) {
                    if ($this->Auth->user()) {
                        $this->User->id = $this->Session->read('Auth.User.id');
                        $this->User->saveField('last_login', date("Y-m-d H:i:s", time()));
                        $this->Flash->success(__('Welcome, ' . $this->Auth->user('name')));
                        if ($this->Auth->user('latitude') == '' || $this->Auth->user('longitude') == '') {
                            $this->User->id = $this->Session->read('Auth.User.id');
                            $this->User->save(array('latitude' => $this->Session->read('user_location.lat'), 'longitude' => $this->Session->read('user_location.lon')));
                        }
                        /* insert to log history */
                        /* $this->loadModel('LoginHistory');
                          $log_data = array('ip' => $this->request->clientIp(),
                          'latitude' => $this->Session->read('user_location.lat'),
                          'longitude' => $this->Session->read('user_location.lon'),
                          'system' => $_SERVER['HTTP_USER_AGENT'],
                          'user_id' => $this->Session->read('Auth.User.id')
                          );
                          $this->LoginHistory->save($log_data); */
                        if (!empty($this->params->query['from'])) {
                            $this->redirect(trim('/' . $this->params->query['from']));
                        } else {
                            if ($this->Auth->user('type') !== '1') {
                                $options['conditions'] = array('Business.user_id' => $this->Auth->user('id'));
                                $is_exist_business = $this->Format->get_business_list($this->Auth->user('id'), $options, 'all');
                                $path_arr = (is_array($is_exist_business) && count($is_exist_business) > 0) ? array('controller' => 'businesses', 'action' => 'index') : array('action' => 'dashboard');
                                #$path_arr = array('action' => 'dashboard');
                            }
                            if ($this->Auth->user('type') == '1') {
                                $this->Session->destroy();
                                $this->Flash->error(__('Invalid username or password.'));
                                $this->redirect($this->Auth->logout());
                                #$this->redirect(array('action' => 'dashboard', 'admin' => 1));
                            } else {
                                $this->redirect($path_arr);
                            }
                        }
                    }
                } else {
                    $this->Flash->error(__('Invalid username or password.'));
                }
            }
        }
    }

    /* public function facebook_login() {
      $this->layout = "ajax";
      $data = $this->request->data;
      //check email set in response
      if (isset($data['user_data']['email']) && !empty($data['user_data']['email'])) {
      $is_user_exist = $this->User->find('first', array('conditions' => array('User.email' => $data['user_data']['email'], 'User.status' => '1', 'User.type' => '2'), 'recursive' => -1));
      if (!empty($is_user_exist)) {
      $this->User->id = $is_user_exist['User']['id'];
      $exist_facebook_id = trim($this->User->field('facebook_id'));
      if (!empty($exist_facebook_id)) {
      if ($exist_facebook_id != trim($data['user_data']['id'])) {
      $this->User->saveField('facebook_id', $data['user_data']['id']);
      }
      } else {
      $this->User->saveField('facebook_id', $data['user_data']['id']);
      }
      $this->Auth->login($is_user_exist['User']);
      $this->User->id = $is_user_exist['User']['id'];
      $this->User->saveField('last_login', date("Y-m-d H:i:s", time()));
      $this->Flash->success(__('Welcome, ' . $this->Auth->user('name')));
      $responseText = (!empty($is_user_exist['User']['email']) && !empty($is_user_exist['User']['phone']) && !empty($is_user_exist['User']['city'])) ? array('status' => 1, 'Message' => 'User Exist & Profile Updated', 'is_profile_updated' => 1) : array('status' => 1, 'Message' => 'User Exist & Profile Not Updated', 'is_profile_updated' => 0);
      #$responseText = array('status' => 1, 'Message' => 'User Exist');
      } else {
      $data['user_data']['is_email'] = true;
      $responseText = $this->save_new_fb_user($data);
      }
      } else {
      $responseText = $this->save_new_fb_user($data, 'fac');
      }
      print(json_encode($responseText));
      exit;
      } */

    public function facebook_login_new() {
        $this->layout = "ajax";
        $data = $this->request->data;
        $is_user_exist = $this->User->find('first', array('conditions' => array('User.email' => $data['UserEmail'], 'User.status' => '1', 'User.type' => '2'), 'recursive' => -1));
        if (!empty($is_user_exist)) {
            if (!empty($is_user_exist['User']['phone']) && !empty($is_user_exist['User']['city'])) {
                $this->User->id = $is_user_exist['User']['id'];
                $exist_facebook_id = $is_user_exist['User']['facebook_id'];
                if (!empty($exist_facebook_id)) {
                    if ($exist_facebook_id != trim($data['social_id'])) {
                        $this->User->saveField('facebook_id', $data['social_id']);
                    }
                } else {
                    $this->User->saveField('facebook_id', $data['social_id']);
                }
                $this->Auth->login($is_user_exist['User']);
                $this->User->id = $is_user_exist['User']['id'];
                $this->User->saveField('last_login', date("Y-m-d H:i:s", time()));
                $this->Flash->success(__('Welcome, ' . $this->Auth->user('name')));
                $responseText = array('exist' => true, 'login' => true);
            } else {
                $responseText = array('exist' => true, 'login' => false);
            }
        } else {
            $responseText = array('exist' => false, 'login' => false);
        }
        print(json_encode($responseText));
        exit;
    }

    public function google_login_new() {
        $this->layout = "ajax";
        $data = $this->request->data;
        $is_user_exist = $this->User->find('first', array('conditions' => array('User.email' => $data['UserEmail'], 'User.status' => '1', 'User.type' => '2'), 'recursive' => -1));
        if (!empty($is_user_exist)) {
            if (!empty($is_user_exist['User']['phone']) && !empty($is_user_exist['User']['city'])) {
                $this->User->id = $is_user_exist['User']['id'];
                $exist_google_id = $is_user_exist['User']['google_id'];
                if (!empty($exist_google_id)) {
                    if ($exist_google_id != trim($data['social_id'])) {
                        $this->User->saveField('google_id', $data['social_id']);
                    }
                } else {
                    $this->User->saveField('google_id', $data['social_id']);
                }
                $this->Auth->login($is_user_exist['User']);
                $this->User->id = $is_user_exist['User']['id'];
                $this->User->saveField('last_login', date("Y-m-d H:i:s", time()));
                $this->Flash->success(__('Welcome, ' . $this->Auth->user('name')));
                $responseText = array('exist' => true, 'login' => true);
            } else {
                $responseText = array('exist' => true, 'login' => false);
            }
        } else {
            $responseText = array('exist' => false, 'login' => false);
        }
        print(json_encode($responseText));
        exit;
    }

    /* public function save_new_fb_user($data) {
      if (isset($data['user_data']['id']) && !empty($data['user_data']['id'])) {
      $is_user_exist = $this->User->find('first', array('conditions' => array('User.facebook_id' => $data['user_data']['id'], 'User.status' => '1', 'User.type' => '2'), 'recursive' => -1));
      if (!empty($is_user_exist)) {
      $this->Auth->login($is_user_exist['User']);
      $this->User->id = $is_user_exist['User']['id'];
      $this->User->saveField('last_login', date("Y-m-d H:i:s", time()));
      $this->Flash->success(__('Welcome, ' . $this->Auth->user('name')));
      $resp = (!empty($is_user_exist['User']['email']) && !empty($is_user_exist['User']['phone']) && !empty($is_user_exist['User']['city'])) ? array('status' => 2, 'Message' => 'User Exist & Profile Updated', 'is_profile_updated' => 1) : array('status' => 2, 'Message' => 'User Exist & Profile Not Updated', 'is_profile_updated' => 0);
      #$resp = ($this->User->field('profile_complete') == '0') ? array('status' => 2, 'Message' => 'User Exist.Profile Not Updated') : array('status' => 1, 'Message' => 'User Exist.Profile Updated');
      } else {
      $this->User->validator()->remove('username');
      $this->User->validator()->remove('password');
      $this->User->validator()->remove('password_confirm');
      $this->User->validator()->remove('city');
      $this->User->validator()->remove('email');
      $this->User->validator()->remove('phone');
      $this->User->validator()->remove('name');
      $this->User->validator()->remove('photo');
      $data['user_data']['facebook_id'] = $data['user_data']['id'];
      $data['user_data']['name'] = $data['user_data']['name'];
      $data['user_data']['type'] = 2;
      $data['user_data']['last_login'] = date("Y-m-d H:i:s");
      $data['user_data']['profile_complete'] = '0';
      if (isset($data['user_data']['is_email'])) {
      $data['user_data']['email'] = $data['user_data']['email'];
      unset($data['user_data']['is_email']);
      }
      unset($data['user_data']['id']);
      $this->User->create();
      if ($this->User->save($data['user_data'])) {
      $data['user_data']['id'] = $this->User->id;
      $this->Auth->login($data['user_data']);
      $this->Flash->success(__('Welcome, ' . $this->Auth->user('name')));
      $resp = array('status' => 3, 'Message' => 'User does not exist & created.');
      } else {
      $resp = array('status' => 0, 'Message' => 'Login failed.');
      }
      }
      } else {
      $resp = array('status' => 0, 'Message' => 'Login failed.');
      }
      return $resp;
      } */

    /**
     * This function will handle Oauth Api response
     */
    /* public function google_login() {
      $this->layout = "ajax";
      $user = $this->request->data;
      if (!empty($user)) {
      $is_user_exist = $this->User->find('first', array('conditions' => array('User.email' => $user['User']['email'], 'User.type' => '2'), 'recursive' => -1));
      if (!empty($is_user_exist)) {
      if ($is_user_exist['User']['type'] == '1') {
      $this->Auth->login($is_user_exist['User']);
      $this->Flash->AdminSuccess(__('Welcome, ' . $this->Auth->user('name')));
      $resp = array('status' => 3, 'Message' => 'Admin exist.');
      } else {
      $this->User->id = $is_user_exist['User']['id'];
      if ($this->Auth->login($is_user_exist['User'])) {
      if (empty($this->User->field('google_id'))) {
      $this->User->saveField('google_id', $user['User']['id']);
      }
      $this->User->saveField('last_login', date("Y-m-d H:i:s", time()));
      $this->Flash->success(__('Welcome, ' . $this->Auth->user('name')));
      $resp = array('status' => 1, 'Message' => 'User exist.');
      } else {
      $resp = array('status' => 0, 'Message' => 'Login failed.');
      }
      }
      } else {
      $resp = $this->save_new_gplus_user($user);
      }
      } else {
      $resp = array('status' => 0, 'Message' => 'Google authentication failed.');
      }
      print(json_encode($resp));
      exit;
      } */

    /* public function save_new_gplus_user($google_data) {
      $this->User->validator()->remove('username');
      $this->User->validator()->remove('password');
      $this->User->validator()->remove('password_confirm');
      $this->User->validator()->remove('city');
      $this->User->validator()->remove('email');
      $this->User->validator()->remove('phone');
      $this->User->validator()->remove('name');
      $this->User->validator()->remove('photo');
      $data['User']['google_id'] = $google_data['User']['id'];
      $data['User']['name'] = (!empty($google_data['User']['name'])) ? $google_data['User']['name'] : "";
      $data['User']['email'] = (!empty($google_data['User']['email'])) ? $google_data['User']['email'] : "";
      $data['User']['photo'] = (!empty($google_data['User']['picture'])) ? $google_data['User']['picture'] : "";
      $data['User']['profile_complete'] = "0";
      $data['User']['type'] = 2;

      $this->User->create();
      if ($this->User->save($data['User'])) {
      $data['User']['id'] = $this->User->id;
      if ($this->Auth->login($data['User'])) {
      $this->User->id = $data['User']['id'];
      $this->User->saveField('last_login', date("Y-m-d H:i:s", time()));
      $this->Flash->success(__('Welcome, ' . $this->Auth->user('name') . '. Please update your profile details.'));
      $resp = array('status' => 2, 'Message' => 'User Created.');
      } else {
      $resp = array('status' => 0, 'Message' => 'Login Failed.');
      }
      } else {
      $resp = array('status' => 0, 'Message' => 'Login Failed.');
      }
      return $resp;
      } */

    public function logout() {
        $this->Session->destroy();
        $this->Flash->success(__('You have signed out successfully.'));
        $this->redirect($this->Auth->logout());
    }

    public function forgot_password() {
        if ($this->request->is('post')) {
            $email = h(trim($this->request->data['User']['email']));

            if ($user = $this->User->findByEmail($email)) {
                $verify_code = md5(uniqid(mt_rand()));
                $reset_url = trim(HTTP_ROOT, '/') . '/reset-password?vc=' . $verify_code;

                $Email = new CakeEmail(Configure::read('EMAIL_DELIVERY_MODE'));
                $Email->from(array(Configure::read('COMPANY.FROM_EMAIL') => Configure::read('COMPANY.NAME')));
                $Email->viewVars(array('name' => $user['User']['name'], 'urlValue' => $reset_url));
                $Email->to($user['User']['email']);
                $Email->subject('Reset Password Request - ' . Configure::read('COMPANY.NAME'));
                $Email->template('forgot_password');
                $Email->send();

                $this->User->id = $user['User']['id'];
                $this->User->saveField('verification_code', $verify_code);
                $this->Flash->success(__('Password reset link sent your email id. If not received please check in spam once.'));
                $this->redirect(array('controller' => 'users', 'action' => 'forgot_password'));
            } else {
                $this->Flash->error(__('User details not found.'));
            }
        }
        $title_for_layout = 'Forgot Password';
        $this->set(compact('title_for_layout'));
    }

    public function dashboard() {
        $title_for_layout = 'Dashboard';
        $this->set(compact('title_for_layout'));

        $user = $this->Session->read('Auth.User');
        /* $options['fields'] = array('Business.id');
          $options['conditions'] = array('Business.user_id' => $user['id']);
          $options['recursive'] = -1;
          $user_business = $this->Format->get_business_list($user['id'], $options, 'list'); */

        $this->loadModel('BusinessBooking');
        $this->BusinessBooking->unbindModel(array('belongsTo' => array('User')));
        $params = array('conditions' => array('Business.status' => '1',
                'BusinessBooking.user_id' => $user['id'],
                "DATE(BusinessBooking.from_date)>=CURDATE()"
        ));
        $params['fields'] = array('BusinessBooking.*', 'Business.name');
        $params['order'] = array(
            'IF(DATE(BusinessBooking.from_date)<CURDATE(),3,2)' => 'ASC',
            'IF(DATE(`BusinessBooking`.`from_date`)<CURDATE(),BusinessBooking.from_date,0)' => 'DESC',
            'BusinessBooking.from_date' => 'ASC');
        $booking_data = $this->BusinessBooking->find('all', $params);
        #pr($booking_data);exit;
        #$booking_data = array();
        $this->set('bookings', $booking_data);
        $this->recently_viewed_classes();
    }

    public function admin_login() {
        $title_for_layout = 'Login';
        $this->set(compact('title_for_layout'));
        if ($this->Auth->user()) {
            $this->Flash->AdminInfo(__('You are already logged in !'));
            $this->redirect(array('action' => 'dashboard', 'admin' => 1));
        }
        if ($this->request->is('post')) {
            if ($this->Auth->login()) {
                if ($this->Auth->user()) {
                    if ($this->Auth->user('type') == '1') {
                        /* deletes all cookies set in index page for limit and page */
                        $this->unset_cookie_records();
                        $this->User->id = $this->Auth->user('id');
                        $this->User->saveField('last_login', date("Y-m-d H:i:s")); // save login time
                        $this->Flash->AdminSuccess(__('Welcome, ' . $this->Auth->user('name')));
                        $this->redirect(array('action' => 'dashboard', 'admin' => 1));
                    } else {
                        $this->Flash->AdminError(__('Invalid username or password'));
                        $this->Cookie->destroy('Auth.User');
                        $this->redirect($this->Auth->logout());
                        #$this->redirect(array('action' => 'dashboard'));
                    }
                }
            } else {
                $this->Flash->AdminError(__('Invalid username or password'));
            }
        }
    }

    public function admin_logout() {
        $this->Cookie->destroy('Auth.User');
        $this->redirect($this->Auth->logout());
    }

    public function admin_dashboard() {
        $title_for_layout = 'Dashboard';
        $this->set(compact('title_for_layout'));
        $this->User->id = $this->Auth->user('id');
        $last_date = $this->User->field('last_login');
    }

    public function dashboard_counts() {
        if ($this->request->is('ajax')) {
            $this->loadModel('Business');
            $this->loadModel('Contact');
            $this->loadModel('BusinessBooking');
            $this->loadModel('Feedback');
            $this->loadModel('BusinessRating');
            $this->loadModel('Inquiry');
            $this->loadModel('ContactNumberRequest');
            $this->loadModel('Subscription');
            $this->loadModel('GroupBookingRequest');
            $this->loadModel('BusinessFavorite');
            $this->loadModel('Event');

            $pending_businesses = $this->Business->find('count', array('conditions' => array('Business.status' => 2), 'recursive' => -1));
            $pending_users = $this->User->find('count', array('conditions' => array('User.status' => '0'), 'recursive' => -1));
            $allcall = $this->Contact->find('count', array('conditions' => array('Contact.mode' => 'call', 'Contact.is_complete' => '0'), 'recursive' => -1));
            $allbookings = $this->BusinessBooking->find('count', array('conditions' => array('BusinessBooking.is_complete' => '0'), 'recursive' => -1));
            $allfeeds = $this->Feedback->find('count', array('conditions' => array('Feedback.type' => 'feedback', 'Feedback.is_complete' => '0'), 'recursive' => -1));
            $pending_reviews = $this->BusinessRating->find('count', array('conditions' => array('BusinessRating.status' => '0'), 'recursive' => -1));
            $askusanything = $this->Feedback->find('count', array('conditions' => array('Feedback.type' => 'ask', 'Feedback.is_complete' => '0')));
            $writetous = $this->Feedback->find('count', array('conditions' => array('Feedback.type' => 'writetous', 'Feedback.is_complete' => '0')));
            $allcontact = $this->Feedback->find('count', array('conditions' => array('Feedback.type' => 'contactus', 'Feedback.is_complete' => '0'), 'recursive' => -1));
            $enquiries = $this->Inquiry->find('count', array('conditions' => array('Inquiry.is_complete' => '0')));
            $events = $this->Event->find('count', array('conditions' => array('Event.status' => '0'), 'recursive' => -1));

            $options['joins'] = array(
                array('table' => 'businesses', 'alias' => 'Business', 'type' => 'LEFT', 'conditions' => array('Business.id=ContactNumberRequest.business_id')),
            );
            $options['fields'] = array('ContactNumberRequest.*', 'Business.*');
            $options['conditions'] = array('ContactNumberRequest.is_complete' => '0', 'ContactNumberRequest.business_id >' => 0, 'ContactNumberRequest.user_id >' => 0, 'Business.id !=' => '');
            $contact_number_requests = $this->ContactNumberRequest->find('count', $options);

            $pending_subscriptions = $this->Subscription->find('count', array('conditions' => array('Subscription.status' => '0')));
            $pending_group_bookings = $this->GroupBookingRequest->find('count', array('conditions' => array('GroupBookingRequest.is_complete' => '0')));
            $pending_business_favorites = $this->BusinessFavorite->find('count', array('conditions' => array('BusinessFavorite.is_complete' => '0')));

            $count_array['pend_users'] = $pending_users;
            $count_array['pend_business'] = $pending_businesses;
            $count_array['pend_askus'] = $askusanything;
            $count_array['pend_contactus'] = $allcontact;
            $count_array['pend_writeus'] = $writetous;
            $count_array['pend_bookings'] = $allbookings;
            $count_array['pend_reviews'] = $pending_reviews;
            $count_array['pend_tutors'] = $enquiries;
            $count_array['pend_feedbacks'] = $allfeeds;
            $count_array['pend_calls'] = $allcall;
            $count_array['pend_contact_info_requets'] = $contact_number_requests;
            $count_array['pend_subscriptions'] = $pending_subscriptions;
            $count_array['pend_groupbookings'] = $pending_group_bookings;
            $count_array['pend_bus_favorites'] = $pending_business_favorites;
            $count_array['pend_event_activation'] = $events;
            print(json_encode($count_array));
            exit;
        }
    }

    public function business_dashboard() {
        $title_for_layout = 'Dashboard';
        $this->set(compact('title_for_layout'));
    }

    public function sign_up() {
        if ($this->request->is('post')) {
            #echo $this->Captcha->getCode('User.security_code');exit;
            $this->loadModel('User');
            $data = $this->request->data;
            $security_code = $this->Captcha->getCode('User.refer_security_code');
            $this->User->setCaptcha('security_code', $security_code);
            $this->User->set($data);
            if ($this->User->validates(array('fieldList' => array('name', 'phone', 'email', 'city', 'password', 'password_confirm', 'security_code')))) {
                $tmp_password = $data['User']['password'];
                $data['User']['password'] = $data['User']['password_confirm'] = $this->Format->make_salty_password($data['User']['password']);
                $data['User']['username'] = $data['User']['email'];
                if (isset($data['User']['platform_type'])) {
                    unset($data['User']['platform_type']);
                }
                $data['User']['facebook_id'] = (isset($data['User']['facebook_id']) && !empty($data['User']['facebook_id'])) ? $data['User']['facebook_id'] : "";
                $data['User']['google_id'] = (isset($data['User']['google_id']) && !empty($data['User']['google_id'])) ? $data['User']['google_id'] : "";
                $data['User']['type'] = '2';
                $data['User']['status'] = (!empty($data['User']['facebook_id']) || !empty($data['User']['google_id'])) ? '1' : '0';
                foreach ($data['User'] as $key => $val) {
                    $data['User'][$key] = is_array($val) ? $val : trim($val);
                }
                $this->User->create();
                unset($data['accept_terms']);
                unset($data['User']['security_code']);
                unset($data['User']['password_confirm']);
                #pr($data);exit;
                if ($this->User->save($data)) {
                    if (empty($data['User']['facebook_id']) && empty($data['User']['google_id'])) {
                        $this->registration_activation($this->User->id, $tmp_password);
                        $this->Flash->success(__('Thank you ' . $data["User"]["name"] . ' for registering with us. Please check your email to verify you account.'));
                    } else {
                        $this->Flash->success(__('Thank you ' . $data["User"]["name"] . ' for registering with us. Use your username & password to log into your account.'));
                    }
                    $this->redirect(array('action' => 'login'));
                } else {
                    $this->Flash->error(__('There was a problem processing your request. Please try again.'));
                }
            } else {
                #$error = $this->User->invalidFields();pr($error);exit;
                $this->Flash->error(__('Validation Error. Try again !'));
            }
        }

        $ucities = $this->Format->cities('list');
        $ucities[0] = 'Other';
        #pr($ucities);exit;
        #$this->loadModel('City');
        #$options = array('fields' => array('id', 'name'), 'conditions' => array('status' => '1'), 'order' => 'name');
        #$ucities = $this->City->find('list', $options);
        $this->set(compact('ucities'));
    }

    /**
     * Sending activation link
     * in email after a user sign up.
     * @param type $id 
     * @param type $pwd 
     * @return type null
     * @author chinmaya
     */
    public function registration_activation($id, $pwd) {
        if ($id > 0) {
            $user = $this->User->find('first', array('conditions' => array('User.id' => $id)));
            $verify_code = md5(uniqid(mt_rand()));
            $activation_url = trim(HTTP_ROOT, '/') . '/activate?vc=' . $verify_code;

            /* load email config class and keep the conenection open untill all mails are sent */
            $Email = new CakeEmail(Configure::read('EMAIL_DELIVERY_MODE'));
            $Email->config(array('persistent' => true));

            /* email to user */
            $Email->from(array(Configure::read('COMPANY.FROM_EMAIL') => Configure::read('COMPANY.NAME')));
            $Email->viewVars(array('from' => '', 'name' => $user['User']['name'], 'userName' => $user['User']['username'], 'password' => $pwd, 'urlValue' => $activation_url));
            $Email->to($user['User']['email']);
            $Email->subject('Your Account Activation Details - ' . Configure::read('COMPANY.NAME'));
            $Email->template('new_user_email');
            $Email->send();

            /* email to admin */
            $Email->from(array(Configure::read('COMPANY.FROM_EMAIL') => Configure::read('COMPANY.NAME')));
            $Email->viewVars(array('from' => '', 'id' => $id, 'name' => $user['User']['name'], 'userName' => $user['User']['username'], 'password' => $pwd, 'urlValue' => ''));
            $Email->to(Configure::read('COMPANY.ADMIN_EMAIL'));
            $Email->subject('New User Registered - ' . Configure::read('COMPANY.NAME'));
            $Email->template('signup_ack_admin');
            $Email->send();

            /* Disconnect email connection */
            if (Configure::read('EMAIL_DELIVERY_MODE') == 'smtp') {
                $Email->disconnect();
            }

            $this->User->id = $id;
            $this->User->saveField('verification_code', $verify_code);
        } else {
            $this->redirect('/');
        }
    }

    public function activate_account() {
        $verification_code = $this->request->query['vc'];
        $user = $this->User->find('first', array('conditions' => array('User.verification_code' => $verification_code)));
        #pr($user);exit;
        if (is_array($user) && count($user) > 0) {
            $this->User->id = $user['User']['id'];
            if ($this->User->saveField('status', '1')) {
                /* removing code */
                $this->User->id = $user['User']['id'];
                $this->User->saveField('verification_code', '');

                /* send email to user */
                $Email = new CakeEmail(Configure::read('EMAIL_DELIVERY_MODE'));
                $Email->from(array(Configure::read('COMPANY.FROM_EMAIL') => Configure::read('COMPANY.NAME')));
                $Email->viewVars(array('name' => $user['User']['name']));
                $Email->to($user['User']['email']);
                $Email->subject('Welcome to ' . Configure::read('COMPANY.NAME'));
                $Email->template('new_user_register');
                $Email->send();

                $this->Flash->success(__('Account activated successfully.')); # Log in to your account.

                $this->request->data['User']['username'] = $user['User']['username'];
                $user['User']['City'] = $user['City'];
                if ($this->Auth->login($user['User'])) {
                    if ($this->Auth->user()) {
                        $this->redirect(array('action' => 'dashboard'));
                    }
                }
                $this->redirect(array('action' => 'login'));
            } else {
                $this->Flash->success(__('Sorry. Account not activated. Please contact admin.'));
            }
            $status = 'account_active';
        } else {
            $status = 'not_found';
        }
        $this->set(compact('status'));
    }

    /**
     * index method
     *
     * @return void
     */
    public function index() {
        $this->User->recursive = 0;
        $this->set('users', $this->Paginator->paginate());
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        if (!$this->User->exists($id)) {
            throw new NotFoundException(__('Invalid user'));
        }
        $options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
        $this->set('user', $this->User->find('first', $options));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        if ($this->request->is('post')) {
            #pr($this->request->data);exit;
            $this->User->create();
            if ($this->User->save($this->request->data)) {
                $this->Flash->success(__('The user has been saved.'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->error(__('The user could not be saved. Please, try again.'));
            }
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
        $title_for_layout = 'Edit Profile';
        $this->set(compact('title_for_layout'));
        $id = $this->Auth->user('id');
        if (!$this->User->exists($id)) {
            throw new NotFoundException(__('Invalid user'));
        }
        if ($this->request->is(array('post', 'put'))) {
            $data = $this->request->data;
            foreach ($data['User'] as $key => $val) {
                $data['User'][$key] = is_array($val) ? $val : trim($val);
            }
            $data['User']['username'] = $data['User']['email'];
            $data['User']['profile_complete'] = '1';

            if ($this->User->save($data)) {
                $this->Session->write('Auth.User.photo', $this->User->field('photo'));
                $this->Session->write('Auth.User.name', $this->User->field('name'));
                $this->Session->write('Auth.User.phone', $this->User->field('phone'));
                $this->Session->write('Auth.User.city', $this->User->field('city'));
                if ($this->Session->read('Auth.User.email') != $data['User']['email']) {
                    $this->Session->write('Auth.User.email', $this->User->field('email'));
                    /* load email config class and keep the conenection open untill all mails are sent */
                    $Email = new CakeEmail(Configure::read('EMAIL_DELIVERY_MODE'));

                    /* email to user */
                    $Email->from(array(Configure::read('COMPANY.FROM_EMAIL') => Configure::read('COMPANY.NAME')));
                    $Email->viewVars(array('user' => $data['User']));
                    $Email->to($data['User']['email']);
                    $Email->subject('You email address has been updated - ' . Configure::read('COMPANY.NAME'));
                    $Email->template('user_update_email');
                    $Email->send();
                }
                $this->Flash->success(__('Profile details updated successfully.'));
                return $this->redirect(array('action' => 'dashboard'));
            } else {
                $this->Flash->error(__('The user could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
            $this->request->data = $this->User->find('first', $options);
        }
        $cities = $this->Format->cities('list');
        $this->set('cities', $cities);
        $this->recently_viewed_classes();
    }

    /**
     * delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function delete($id = null) {
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        $this->request->allowMethod('post', 'delete');
        if ($this->User->delete()) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }
        return $this->redirect(array('action' => 'index'));
    }

    /**
     * admin_index method
     *
     * @return void
     */
    public function admin_index() {
        #pr($this->request->referer());exit;
        if (isset($this->params['type']) && $this->params['type'] == 'admin') {
            $condition = array('User.type' => '1');
            $path = "Add_Admin";
        } else {
            $condition = array('User.type !=' => '1');
            $path = "Add_User";
        }
        $condition['User.id !='] = $this->Auth->user('id');
        $options = array('conditions' => $condition);
        $options['fields'] = array('User.*', 'City.name');
        $options['order'] = array('User.status ASC', 'User.id DESC');
        $this->User->recursive = false;
        $users = $this->User->find('all', $options);
        #pr($users);exit;
        $this->set('users', $users);
        $this->set('path', $path);
    }

    /**
     * admin_view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_view($id = null) {
        if (!$this->User->exists($id)) {
            throw new NotFoundException(__('Invalid user'));
        }
        $options = array('conditions' => array('User.' . $this->User->primaryKey => $id));

        $users = $this->User->find('first', $options);
        #pr($user);exit;
        $this->set(compact('users'));
    }

    /**
     * admin_add method
     *
     * @return void
     */
    public function admin_add() {
        if ($this->request->is('post')) {
            $this->User->set($this->request->data);
            if ($this->User->validates()) {
                $this->request->data['User']['password'] = $this->request->data['User']['password_confirm'] = rtrim($this->request->data['User']['password'], ' ');
                $user_email = $this->request->data['User']['email'];
                $tmp_password = $this->request->data['User']['password'];
                $this->request->data['User']['password'] = $this->request->data['User']['password_confirm'] = $this->Format->make_salty_password($this->request->data['User']['password']);
                $this->request->data['User']['username'] = $this->request->data['User']['email'];
                if ($this->Auth->user('type') == '1') {
                    $this->request->data['User']['type'] = '2';
                }
                //$this->request->data['User']['type'] = (isset($this->request->data['User']['actions']) && trim($this->request->data['User']['actions']) == 'Add User') ? '2' : '1';
                $this->User->create();
                if ($this->User->save($this->request->data)) {

                    /* load email config class and keep the conenection open untill all mails are sent */
                    $Email = new CakeEmail(Configure::read('EMAIL_DELIVERY_MODE'));

                    /* email to user */
                    $Email->from(array(Configure::read('COMPANY.FROM_EMAIL') => Configure::read('COMPANY.NAME')));
                    $Email->viewVars(array('from' => 'admin', 'name' => $this->request->data['User']['name'], 'userName' => $this->request->data['User']['username'], 'password' => $tmp_password, 'urlValue' => ''));
                    $Email->to($user_email);
                    $Email->subject('You have been added to ' . Configure::read('COMPANY.NAME'));
                    $Email->template('new_user_email');
                    $Email->send();

                    $this->Flash->AdminSuccess(__('The user has been saved.'));
                    $this->redirect(array('action' => 'index', 'admin' => 1));
                } else {
                    $this->Flash->AdminError(__('The user could not be saved. Please, try again.'));
                }
            } else {
                $this->User->validationErrors;
                $this->Flash->AdminError(__('Validation Error. Try again !'));
            }
        }
        $this->set('actions', str_replace('_', ' ', @$this->params['pass'][0]));
        $cities = $this->Format->cities('list');
        $this->set('cities', $cities);
    }

    /**
     * admin_edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_edit($id = null) {
        if (!$this->User->exists($id)) {
            throw new NotFoundException(__('Invalid user'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if ($this->User->validates()) {
                if (isset($this->request->data['User']['password']) && !empty($this->request->data['User']['password']) && trim($this->request->data['User']['password']) != '**********') {
                    $this->request->data['User']['password'] = $this->request->data['User']['password_confirm'] = $this->Format->make_salty_password($this->request->data['User']['password']);
                } else {
                    unset($this->request->data['User']['password']);
                    unset($this->request->data['User']['password_confirm']);
                }
                $this->User->set($this->request->data);
                #pr($this->request->data);exit;
                if ($this->User->save($this->request->data)) {
                    $this->Flash->adminSuccess(__('The user has been saved.'), array(
                        'params' => array(
                            'name' => $this->request->data['User']['name']
                        )
                    ));
                    return $this->redirect(array('action' => 'index', 'admin' => 1));
                } else {
                    $this->Flash->AdminError(__('The user could not be saved. Please, try again.'));
                }
            } else {
                $this->Flash->AdminError(__('Validation Error. Try again !'));
            }
        } else {
            $options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
            $this->request->data = $this->User->find('first', $options);
        }
        $cities = $this->Format->cities('list');
        $this->set('cities', $cities);
        #$this->set('list', $this->Format->getCityList());
    }

    /**
     * admin_delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_delete($id = null) {
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        if ($this->User->delete()) {
            $this->Flash->AdminSuccess(__('The user has been deleted.'));
        } else {
            $this->Flash->AdminError(__('The user could not be deleted. Please, try again.'));
        }
        return $this->redirect(array('action' => 'index', 'admin' => 1));
    }

    /**
     * admin_grant_user method
     *
     * @Used for enable/disable Users/Buisness Users
     * @param string $id
     * @return void
     */
    public function admin_grant_user($id = null) {
        $this->User->id = $id;
        if ($this->User->exists()) {
            $this->User->recursive = -1;
            $statusData = $this->User->find('first', array('conditions' => array('User.id' => $id)));
            $user_status_val = ($statusData['User']['status']) ? '0' : '1';
            $user_status_msg = ($statusData['User']['status']) ? 'User Disabled' : 'User Enabled';
            if ($this->User->saveField('status', $user_status_val, false)) {
                $this->Flash->AdminSuccess(__($user_status_msg));
            } else {
                $this->Flash->AdminError(__($user_status_msg));
            }
        } else {
            $this->Flash->AdminError(__('Invalid User'));
        }
        return $this->redirect(array('action' => 'index'));
    }

    public function admin_profile() {
        $id = $this->Auth->user('id');
        $this->User->recursive = false;
        $profile_details = $this->User->findById($id);
        $this->set('details', $profile_details);

        $cities = $this->Format->cities('list');
        $this->set('cities', $cities);
    }

    public function admin_change_password() {
        if ($this->Auth->user('id')) {
            $this->User->id = $this->Auth->user('id');
            if (!$this->User->exists()) {
                throw new NotFoundException(__('Invalid user'));
            }
            $id = $this->User->id;
            $old_password = $this->User->findByPassword(Security::hash($this->request->data['User']['current_password'], 'md5', true));
            if (!empty($old_password)) {
                if (strcmp(trim($this->data['User']['password1']), trim($this->data['User']['password2'])) == 0) {
                    $this->User->id = $id;
                    if ($this->User->saveField('password', Security::hash($this->request->data['User']['password1'], 'md5', true))) {
                        $this->Flash->AdminSuccess(__('Password changed successfully'));
                        $this->redirect(array('action' => 'profile', 'admin' => 1));
                    }
                } else {
                    $this->Flash->AdminWarn(__('Password does not match.'));
                    $this->redirect(array('action' => 'profile', 'admin' => 1));
                }
            } else {
                $this->Flash->AdminError(__("This password doesn' assigned to you. Enter the correct password ! "));
                $this->redirect(array('action' => 'profile', 'admin' => 1));
            }
        }
    }

    function change_password_user() {
        if ($this->request->is('post')) {
            if ($this->Auth->user('id')) {
                $this->User->id = $this->Auth->user('id');
                if (!$this->User->exists()) {
                    throw new NotFoundException(__('Invalid user'));
                }
                $this->User->recursive = -1;
                $id = $this->User->id;
                $old_password = $this->User->findByPassword(Security::hash($this->request->data['User']['current_password'], 'md5', true));
                if (!empty($old_password) && is_array($old_password)) {
                    if (strcmp(trim($this->data['User']['password1']), trim($this->data['User']['password2'])) == 0) {
                        $this->User->id = $id;
                        if ($this->User->saveField('password', Security::hash($this->request->data['User']['password1'], 'md5', true))) {
                            $this->Flash->success(__('Password changed successfully'));
                            $this->redirect(array('action' => 'edit'));
                        }
                    } else {
                        $this->Flash->error(__('Password does not match.'));
                        $this->redirect(array('action' => 'edit_user_password'));
                    }
                } else {
                    $this->Flash->error(__("Your old password is not correct. Enter the correct password ! "));
                    $this->redirect(array('action' => 'edit_user_password'));
                }
            }
        }
        $this->recently_viewed_classes();
    }

    function email_unique_edit() {
        $email = $this->request->data['User']['email'];
        if (isset($this->request->data['id']) && !empty($this->request->data['id'])) {
            $cond = array("User.email" => $email, "User.id !=" => $this->request->data['id']);
        } else {
            $cond = array("User.email" => $email);
        }
        $count = $this->User->find('count', array('conditions' => $cond));
        echo ($count >= 1) ? 'false' : 'true';
        exit;
    }

    function phone_unique_edit() {
        $phone = $this->request->data['User']['phone'];
        if (isset($this->request->data['id']) && !empty($this->request->data['id'])) {
            $cond = array("User.phone" => $phone, "User.id !=" => $this->request->data['id']);
        } else {
            $cond = array("User.phone" => $phone);
        }
        $count = $this->User->find('count', array('conditions' => $cond));
        echo ($count >= 1) ? 'false' : 'true';
        exit;
    }

    function username_unique_edit() {
        $username = $this->request->data['User']['username'];
        if (isset($this->request->data['id']) && !empty($this->request->data['id'])) {
            $cond = array("User.username" => $username, "User.id !=" => $this->request->data['id']);
        } else {
            $cond = array("User.username" => $username);
        }
        $count = $this->User->find('count', array('conditions' => $cond));
        echo ($count >= 1) ? 'false' : 'true';
        exit;
    }

    public function admin_save_profile() {
        if ($this->request->is('post')) {
            $data = $this->request->data;
            foreach ($data['User'] as $key => $val) {
                $data['User'][$key] = is_array($val) ? $val : trim($val);
            }
            $this->User->set($data);
            if ($this->User->validates()) {
                $this->User->id = $data['User']['id'];
                if ($this->User->save($data)) {
                    $this->Session->write('Auth.User.photo', $this->User->field('photo'));
                    $this->Session->write('Auth.User.name', $this->User->field('name'));

                    $this->Flash->AdminSuccess(__('Profile details updated successfully.'));
                } else {

                    $this->Flash->AdminError(__("Error. Profile details not updated. Try again."));
                }
            } else {
                $error = $this->User->invalidFields();
            }
        } else {
            $this->Flash->AdminError(__("Profile updation failed! try again."));
        }
        return $this->redirect(array('action' => 'admin_profile', 'admin' => 1));
    }

    public function admin_forgot_password() {
        $this->layout = "admin_login";
        $this->User->recursive = -1;
        if (!empty($this->request->data)) {
            if (empty($this->request->data['User']['email'])) {
                $this->Flash->AdminError('Please Provide Your Email Adress that You used to Register with Us');
            } else {
                $email = $this->request->data['User']['email'];
                $fu = $this->User->find('first', array('conditions' => array('User.email' => $email)));
                if ($fu) {
                    if (intval($fu['User']['status'])) {
                        $key = Security::hash(md5(CakeText::uuid()), 'md5', true);
                        $hash = sha1($fu['User']['username'] . mt_rand(0, 100));
                        $url = Router::url(array('action' => 'reset', 'admin' => 1), true) . '/' . $key . '#' . $hash;
                        $ms = $url;
                        $ms = wordwrap($ms, 1000);
                        $fu['User']['verification_code'] = $key;
                        $this->User->id = $fu['User']['id'];
                        if ($this->User->saveField('verification_code', $fu['User']['verification_code'])) {
                            $this->Flash->AdminSuccess(__('Check Your Email To Reset your password', true));
                            $Email = new CakeEmail(Configure::read('EMAIL_DELIVERY_MODE'));
                            $Email->from(array(Configure::read('COMPANY.FROM_EMAIL') => Configure::read('COMPANY.NAME')));
                            $Email->viewVars(array('name' => $fu['User']['name'], 'urlValue' => $ms));
                            $Email->to($fu['User']['email']);
                            $Email->subject('Reset Your ' . Configure::read('COMPANY.NAME') . ' Admin Panel Password!');
                            $Email->template('admin_forgot_password');
                            $Email->send();
                        } else {
                            $this->Flash->AdminSuccess("Error Generating Reset link");
                        }
                    } else {
                        $this->Flash->AdminError('This Account is not Active yet.Check Your mail to activate it');
                    }
                } else {
                    $this->Flash->AdminError('Email does Not Exist');
                }
            }
            $this->redirect(array('action' => 'admin_forgot_password', 'admin' => 1));
        }
    }

    function admin_reset($token = null) {
        $this->layout = "admin_login";
        $this->User->recursive = -1;
        if (!empty($token)) {
            $u = $this->User->findByVerificationCode($token);
            if (!empty($u)) {
                $this->User->id = $u['User']['id'];
                if (!empty($this->data)) {
                    $this->User->data = $this->data;
                    $new_hash = md5($u['User']['username'] . mt_rand(0, 100)); //created token
                    $this->User->data['User']['verification_code'] = $new_hash;
                    if ($this->User->validates(array('fieldList' => array('User.password', 'User.password_confirm')))) {
                        $this->User->data['User']['password'] = $this->User->data['User']['password_confirm'] = $this->Format->make_salty_password($this->User->data['User']['password']);
                        if ($this->User->save($this->User->data)) {
                            $this->Flash->AdminSuccess('Password Has been Updated');
                            $this->redirect(array('action' => 'login', 'admin' => 1));
                        }
                    } else {
                        $this->set('errors', $this->User->invalidFields());
                    }
                }
            } else {
                $this->Flash->AdminError('Token Corrupted,Please Retry.The reset link work only for once.');
                $this->redirect(array('action' => 'login', 'admin' => 1));
            }
        } else {
            $this->Flash->AdminError('Token Corrupted,Please Retry.The reset link work only for once.');
            $this->redirect(array('action' => 'login', 'admin' => 1));
        }
    }

    function queries() {
        
    }

    function change_password() {

        $id = $this->Auth->user();
        $user_id = $id['User']['id'];

        if (!empty($this->data)) {

            $old = $this->data['User']['password_old'];
            $old_password = $this->Auth->password($old);
            $check_password = $this->User->find('first', array('conditions' => array('User.id' => $user_id, 'User.password' => $old_password), 'fields' => array('User.password')));
            $new_pass_gen = $this->data['User']['password_new'];
            $new_pass = $this->Auth->password($new_pass_gen);

            if (!empty($check_password)) {
                $new = $this->data['User']['password_new'];

                $re_type_new = $this->data['User']['password_confirm'];

                if (!empty($new) && !empty($re_type_new)) {
                    if ($new == $re_type_new) {

                        $this->data['User']['password'] = $new_pass;

                        $this->User->id = $user_id;

                        if ($this->User->save($this->data)) {

                            $password_change_successfully = __('password_change_successfully', true);
                            $this->Session->setFlash(__($password_change_successfully, true));
                            $this->redirect($this->referer());
                        }
                    }
                }
            } else {
                $sorry_your_old_password_is_incorrect = __('sorry_your_old_password_is_incorrect', true);
                $this->Session->setFlash(__($sorry_your_old_password_is_incorrect, true));
            }
        }
    }

    function recently_viewed_classes_old() {
        $user_id = $this->Session->read('Auth.User.id');
        $this->loadModel('BusinessView');
        $this->BusinessView->bindModel(array('belongsTo' => array(
                'User' => array('className' => 'User', 'foreignKey' => 'user_id'),
                'Business' => array('className' => 'Business', 'foreignKey' => 'business_id')
        )));
        $params = array('conditions' => array('Business.status' => '1', 'BusinessView.user_id' => $user_id,));
        $params['fields'] = array('BusinessView.*', 'Business.name', 'Business.id', 'User.name', 'User.id');
        $params['order'] = array('BusinessView.viewed_on' => 'DESC');
        $view_data = $this->BusinessView->find('all', $params);
        #pr($view_data);exit;
        $this->set('view_data', $view_data);
    }

    /* method to remove cookies after admin login for index page lilmit and page number
     * it has controller name and action name with variable
     */

    function unset_cookie_records() {
        setcookie("businessesadmin_indexpage_no", "", time() - 3600, '/');
        setcookie("businessesadmin_indexpage_limit", "", time() - 3600, '/');
        setcookie("businessesadmin_indexpage_sort", "", time() - 3600, '/');
        setcookie("usersadmin_indexpage_no", "", time() - 3600, '/');
        setcookie("usersadmin_indexpage_limit", "", time() - 3600, '/');
        setcookie("usersadmin_indexpage_sort", "", time() - 3600, '/');
    }

    public function admin_users_export_modal() {
        $this->layout = "ajax";
        $cities = $this->Format->cities('list', '');
        $this->set('cities', $cities);
    }

    public function admin_user_reports_sheets() {
        $params = $this->request->query;
        if (!empty($params['city_id'])) {
            $options['conditions'] = array('User.city' => $params['city_id']);
        }
        $options['conditions']['User.type'] = '2';
        $options['order'] = array('User.name' => "ASC");
        $data = $this->User->find('all', $options);

        $final_arr['header_arr'] = array('Name', 'Username', 'Phone', 'City', 'Created', 'Status');
        $final_data = array();
        foreach ($data as $key => $value) {
            $final_data[] = array($value['User']['name'], $value['User']['username'], $value['User']['phone'], $value['City']['name'], (strtotime($value['User']['created']) > 0) ? date('M d, Y g:i a', strtotime($value['User']['created'])) : '', ($value['User']['status'] == '0') ? 'Inactive' : 'Active');
        }
        $final_arr['data'] = $final_data;
        $file_name = "Users_info_";
        $this->Format->export_excel($file_name, $final_arr);
        #}
        exit;
    }

    public function admin_get_active_cities() {
        $users_arr = $this->User->find('all', array('fields' => array('CONCAT(User.name," (",User.email,")") AS name_email', 'id'), 'conditions' => array('User.status' => '1', 'User.city' => $this->request->data['city_id']), 'order' => array('name_email' => "ASC"), 'recursive' => -1));
        $result = Hash::extract($users_arr, '{n}.User.id');
        print(json_encode($result));
        exit;
    }

}
