<?php

/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
App::uses('Controller', 'Controller');
App::uses('CakeEmail', 'Network/Email');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

    public $languages = array(1 => 'Bengali', 2 => 'Bihari', 3 => 'English', 4 => 'Hindi', 5 => 'Odiya', 6 => 'Sanskrit', 7 => 'Telugu', 8 => 'Tamil');
    public $helpers = array('Format', 'PhpThumb', 'Captcha');
    public $components = array(
        'Session', 'Cookie', 'Flash', 'Format',
        'Captcha' => array('field' => 'refer_security_code'),
        'Auth' => array(
            'authError' => 'You must be logged in to view this page.',
            'loginError' => 'Invalid Username or Password entered, please try again.',
            'authenticate' => array(
                'Form' => array(
                    'fields' => array('username' => 'username')
                )
            )
    ));
    public $meta_titles = array(
        'home' => 'The ultimate place to discover activities & academics of your choice in the neighborhood',
        'create-business' => 'Create Business',
        'business-dashboard' => 'Business Dashboard',
        'call-requests' => 'Call Request',
        'my-bookings' => 'My Bookings',
        'booking-requests' => 'Booking Requests',
        'my-reviews' => 'My Reviews',
        'business-reviews' => 'Class Reviews',
        'faq' => 'FAQs',
        'careers' => 'Career',
        'search' => 'Search Classes',
        'refer-a-friend' => 'Refer Friends',
        'looking-for-a-tutor' => 'Looking For a Tutor',
        'contact-us' => 'Contact Us',
        'feedback' => 'Feedback',
        'press' => 'Press',
        'blog' => 'Blog',
        'login' => 'Login',
        'dashboard' => 'Dashboard',
        'signup' => 'Sign Up',
        'edit-profile' => 'Edit Profile',
        'activate' => 'Activate Account',
        'forgot-password' => 'Forgot Password',
        'recently-viewed-classes' => 'Recently Viewed Classes',
        'about-us' => 'About Us',
        'terms-and-conditions' => 'Terms & Conditions',
        'privacy-policy' => 'Privacy Policy',
        'the-team' => 'The Team',
        'the-platform' => 'The Platform',
        'change-password' => 'Change Password',
    );
    protected $db_config;
    public $social_login_access = array('users', 'businesses', 'content', 'reports', 'content', 'business_ratings');

    function isAuthorized() {
        return true;
    }

    function captcha() {
        $this->autoRender = false;
        $this->layout = 'ajax';
        if (!isset($this->Captcha)) { //if you didn't load in the header
            $this->Captcha = $this->Components->load('Captcha'); //load it
        }
        $this->Captcha->create();
    }

    function beforeRender() {
        $this->set('user', $this->Auth->user());
        if (isset($this->request->prefix)) {
            $this->set('prefix', trim($this->request->prefix));
        }
        $this->set('parms', array('controller' => $this->request->params['controller'],
            'action' => $this->request->params['action'],
            'extra' => isset($this->request->params['pass'][0]) ? $this->request->params['pass'][0] : '',
            'slug' => isset($this->request->params['slug']) ? $this->request->params['slug'] : ''
        ));

        /* temporary */
        $exclude_arr = array('home', 'sign_up');
        $this->set('exclude_arr', $exclude_arr);
        if (!isset($this->params->admin)) {
            $this->loadModel('Category');
            $options = array('fields' => array('id', 'name'),
                'conditions' => array('status' => '1', 'parent_id' => '0'),
                'order' => array('Category.name' => "ASC"));
            ##'Category.sequence' => "ASC",
            $topcategories = $this->Category->find('list', $options);
            #pr($topcategories);exit;
            $this->set(compact('topcategories'));
        }
        $this->set('languages', $this->languages);

        /* pages using data table in front */
        $action_tree = array('bookings', 'reviews', 'call_requests', 'my_bookings', 'my_reviews', 'dashboard', 'recently_viewed_classes', 'index');
        $this->set('action_tree', $action_tree);

        /* pages using data table in admin */
        $admin_action_tree = array('admin_index', 'admin_facility_manage', 'admin_all', 'admin_contact_request', 'admin_call_request',
            'admin_bookings', 'admin_feedbacks', 'admin_write_to_us', 'admin_ask_us_anything', 'admin_contact_number_requests', 'admin_manage_email',
            'admin_contact_requests_info', 'admin_all_transactions', 'admin_group_booking_requests', 'admin_business_favorite', 'admin_tracking',
            'admin_event_inquiry');
        $admin_page_array = array('admin_add', 'admin_edit', 'admin_index', 'admin_facility_manage', 'admin_all', 'admin_contact_request',
            'admin_call_request', 'admin_bookings', 'admin_feedbacks', 'admin_write_to_us', 'admin_ask_us_anything', 'admin_contact_number_requests',
            'admin_manage_email', 'admin_contact_requests_info', 'admin_all_transactions', 'admin_group_booking_requests', 'admin_business_favorite',
            'admin_tracking', 'admin_event_inquiry');
        $this->set('admin_action_tree', $admin_action_tree);
        $this->set('admin_page_array', $admin_page_array);
        #pr($this->params->url);exit;
        if (!empty($this->meta_titles[$this->params->url])) {
            $this->set('title_for_layout', $this->meta_titles[$this->params->url]);
        } elseif (empty($this->params->url)) {
            $this->set('title_for_layout', $this->meta_titles['home']);
        } elseif (!empty($this->params['title'])) {
            $this->set('title_for_layout', $this->params['title']);
        }
        $this->set('adminpanel_dashboard_link', array('controller' => 'users', 'action' => 'dashboard', 'prefix' => 'admin', 'admin' => 1));
    }

    public function beforeFilter() {
        $this->loadModel('User');
        $this->User->recusrsive = false;
        $this->User->unbindModel(array('hasMany' => array('Business')));
        $admin = $this->User->find('first', array('conditions' => array('User.id' => 1), 'fields' => array('User.email', 'User.id')));
        if (is_array($admin) && count($admin) > 0 && trim($admin['User']['email']) != '') {
            Configure::write('COMPANY.ADMIN_EMAIL', $admin['User']['email']);
        }

        if (isset($this->params['admin']) && $this->Auth->user('id') > 0 && $this->Auth->user('type') != '1') {
            $this->redirect('/');
        }

        Security::setHash("md5");
        $auth_arr = array('login', 'sign_up', 'captcha');
        $this->Auth->allow($auth_arr);

        $this->Auth->authError = __('You must be logged in to view this page.');
        $this->Auth->loginError = __('Invalid Username or Password entered, please try again.');
        if ((isset($this->request->prefix) && ($this->request->prefix == 'admin'))) {
            $this->Auth->loginRedirect = array('controller' => 'users', 'action' => 'dashboard', "admin" => 1);
            if ($this->request->params['action'] == 'admin_login') {
                $this->layout = 'admin_login';
            } else {
                $this->layout = 'admin';
            }
        } elseif ((isset($this->request->prefix) && ($this->request->prefix == 'business'))) {
            $this->Auth->loginRedirect = array('controller' => 'users', 'action' => 'dashboard', "business" => 1);
            $this->layout = 'business';
        } else {
            $this->Auth->loginRedirect = array('controller' => 'users', 'action' => 'dashboard');
            $this->layout = 'default';
        }
        if (!isset($this->params['admin'])) {
            $this->set('title_for_layout', '');
        }

        App::import('Core', 'ConnectionManager');
        $dataSource = ConnectionManager::getDataSource('default');
        $this->db_config = array('user' => $dataSource->config['login'], 'pass' => $dataSource->config['password'], 'db' => $dataSource->config['database'], 'host' => $dataSource->config['host']);

        if ($this->Auth->user()) {
            if (in_array($this->params['controller'], $this->social_login_access)) {
                if ($this->Auth->user('email') == '' || $this->Auth->user('phone') == '' || $this->Auth->user('city') == '') {
                    if (in_array($this->params['action'], array('index', 'dashboard', 'my_bookings', 'my_reviews',
                                'refer_friend', 'add', 'bookings', 'view', 'call_requests', 'change_password_user', 'reviews'))) {
                        $this->redirect(array('controller' => 'users', 'action' => 'edit'));
                    }
                }
            }
        }

        $this->loadModel('Subscription');
        $subscriptions = $this->Subscription->find('first', array('conditions' => array('Subscription.user_id' => $this->Auth->user('id')), 'order' => array('Subscription.created' => 'DESC')));
        $this->set('subscriptions', $subscriptions);
    }

    function recently_viewed_classes() {
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
        $this->set('view_data', $view_data);
    }

}
