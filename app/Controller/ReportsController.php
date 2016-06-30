<?php

App::uses('AppController', 'Controller');

/**
 * CakePHP ContentController
 * @author Chinmaya
 */
class ReportsController extends AppController {

    public $helpers = array('Html', 'Form', 'Session', 'MyCookie');
    public $components = array('Cookie');

    function beforeFilter() {
        parent::beforeFilter();
    }

    public function call_requests() {
        $title_for_layout = 'Request a Call';
        $this->set(compact('title_for_layout'));
        $user = $this->Session->read('Auth.User');
        $options['fields'] = array('Business.id');
        $options['recursive'] = -1;
        $user_business = $this->Format->get_business_list($user['id'], $options, 'list');

        $this->loadModel('Contact');
        $option = array('conditions' => array('Contact.business_id' => $user_business), 'order' => 'created DESC');
        $contact_data = $this->Contact->find('all', $option); //'Contact.user_id !=' =>$user['id']
        $this->set('contacts', $contact_data);
    }

    public function delete_call_request($id) {
        if ($id > 0) {
            $this->loadModel('Contact');
            if ($this->Contact->delete($id)) {
                $this->Flash->Success(__('Call Request deleted successfully.'));
            } else {
                $this->Flash->Error(__('Error. Call Request not deleted. Please try again.'));
            }
        }
        $this->redirect(array('action' => 'call_requests'));
    }

    public function admin_call_request() {
        $title_for_layout = 'Request a Call';
        $this->set(compact('title_for_layout'));
        if (isset($this->request->params['pass'][0]) && $this->request->params['pass'][0] == "ajax_contact_delete") {
            $this->layout = "ajax";
        }
    }

    public function call_req_listings_ajax() {
        if ($this->request->is('ajax')) {
            $table = 'contacts';
            $primaryKey = 'id';
            $columns = array(
                array('db' => '`c`.`id`', 'dt' => 0, 'field' => 'c_id', 'as' => 'c_id'),
                array('db' => '`b`.`name`', 'dt' => 1, 'field' => 'business_name', 'as' => 'business_name'),
                array('db' => 'GROUP_CONCAT(DISTINCT cat.name ORDER BY cat.name ASC SEPARATOR ", ")', 'dt' => 2, 'field' => 'categories', 'as' => 'categories'),
                array('db' => 'CONCAT_WS(", ",b.address,IFNULL(b.landmark, ""),loc.name,cit.name,b.pincode)', 'dt' => 3, 'field' => 'business_address', 'as' => 'business_address'),
                array('db' => '`c`.`name`', 'dt' => 4, 'field' => 'conctact_name', 'as' => 'conctact_name'),
                array('db' => '`c`.`phone`', 'dt' => 5, 'field' => 'phone', 'as' => 'phone'),
                array('db' => '`c`.`email`', 'dt' => 6, 'field' => 'email', 'as' => 'email'),
                array('db' => '`c`.`created`', 'dt' => 7, 'field' => 'created', 'as' => 'created'),
                array('db' => '`c`.`is_complete`', 'dt' => 8, 'field' => 'is_complete', 'as' => 'is_complete')
            );
            $joinQuery = "FROM `contacts` AS `c` JOIN `businesses` AS `b` ON (`c`.`business_id` = `b`.`id`) LEFT JOIN `categories` AS `cc` ON (`cc`.`id` = `b`.`category_id`) LEFT JOIN `cities` AS `cit` ON (`cit`.`id` = `b`.`city_id`) LEFT JOIN `localities` AS `loc` ON (`loc`.`id` = `b`.`locality_id`) INNER JOIN `business_categories` AS `bcat` ON (`bcat`.`business_id` = `c`.`business_id`) INNER JOIN `categories` AS `cat` ON (`cat`.`id` = `bcat`.`category_id`)";
            $extraWhere = "mode = 'call'";
            $groupBy = '`bcat`.`business_id`,`c`.`id`';
            $having = "Yes";

            App::uses('SSP', 'Utility');
            $response = SSP::simple($_GET, $this->db_config, $table, $primaryKey, $columns, $joinQuery, $extraWhere, $groupBy, '', $having);
            print(json_encode($response));
            exit;
        }
    }

    public function admin_contact_request() {
        $title_for_layout = 'Contact Us Requests';
        $this->set(compact('title_for_layout'));
        if (isset($this->request->params['pass'][0]) && $this->request->params['pass'][0] == "ajax_contact_delete") {
            $this->layout = "ajax";
        }
    }

    public function contact_req_listings_ajax() {
        if ($this->request->is('ajax')) {
            $table = 'feedback';
            $primaryKey = 'id';
            $columns = array(
                array('db' => 'id', 'dt' => 0, 'field' => 'id'),
                array('db' => 'name', 'dt' => 1, 'field' => 'name'),
                array('db' => 'email', 'dt' => 2, 'field' => 'email'),
                array('db' => 'comment', 'dt' => 3, 'field' => 'comment'),
                array('db' => 'created', 'dt' => 4, 'field' => 'created'),
                array('db' => 'is_complete', 'dt' => 5, 'field' => 'is_complete')
            );
            $joinQuery = "";
            $extraWhere = "`type` = 'contactus'";

            App::uses('SSP', 'Utility');
            $response = SSP::simple($_GET, $this->db_config, $table, $primaryKey, $columns, $joinQuery, $extraWhere);
            print(json_encode($response));
            exit;
        }
    }

    public function admin_delete_contact() {
        $this->layout = "ajax";
        $id = $this->request->data['id'];
        if ($id) {
            $this->loadModel('Feedback');
            if ($this->Feedback->delete($id)) {
                $this->redirect(array('action' => 'contact_request', 'admin' => 1, "ajax_contact_delete"));
            }
        }
    }

    public function admin_delete_call_request($id) {
        if ($id) {
            $this->loadModel('Contact');
            if ($this->Contact->delete($id)) {
                $this->Flash->AdminSuccess(__('Call Request deleted successfully.'));
            } else {
                $this->Flash->AdminError(__('Error. Call Request not deleted. Please try again.'));
            }
        }
        $this->redirect(array('action' => 'call_request', 'admin' => 1, ""));
    }

    /**
     * Used for displaying all 
     * business bookings in admin panel
     * @return type null
     */
    public function admin_bookings() {
        $title_for_layout = 'Bookings';
        $this->set(compact('title_for_layout'));
    }

    public function bookings_ajax() {
        if ($this->request->is('ajax')) {
            $table = 'business_bookings';
            $primaryKey = 'id';
            $columns = array(
                array('db' => '`bb`.`id`', 'dt' => 0, 'field' => 'id'),
                array('db' => '`bb`.`created`', 'dt' => 1, 'field' => 'created', 'as' => 'created'),
                array('db' => '`u`.`name`', 'dt' => 2, 'field' => 'user_name', 'as' => 'user_name'),
                array('db' => '`b`.`name`', 'dt' => 3, 'field' => 'business_name', 'as' => 'business_name'),
                array('db' => 'GROUP_CONCAT(DISTINCT cat.name ORDER BY cat.name ASC SEPARATOR ", ")', 'dt' => 4, 'field' => 'categories', 'as' => 'categories'),
                array('db' => 'CONCAT_WS(", ",b.address,IFNULL(b.landmark, ""),loc.name,cit.name,b.pincode)', 'dt' => 5, 'field' => 'business_address', 'as' => 'business_address'),
                array('db' => '`bb`.`from_date`', 'dt' => 6, 'field' => 'from_date', 'as' => 'from_date'),
                array('db' => '`bb`.`to_date`', 'dt' => 7, 'field' => 'to_date', 'as' => 'to_date'),
                array('db' => '`bb`.`seats`', 'dt' => 8, 'field' => 'seats', 'as' => 'seats'),
                array('db' => '`bb`.`reference_code`', 'dt' => 9, 'field' => 'reference_code', 'as' => 'reference_code'),
                array('db' => '`bb`.`is_complete`', 'dt' => 10, 'field' => 'is_complete', 'as' => 'is_complete')
            );
            $joinQuery = "FROM `business_bookings` AS `bb` JOIN `businesses` AS `b` ON (`b`.`id` = `bb`.`business_id`) LEFT JOIN `users` AS `u` ON (`u`.`id` = `bb`.`user_id`) LEFT JOIN `cities` AS `cit` ON (`cit`.`id` = `b`.`city_id`) LEFT JOIN `localities` AS `loc` ON (`loc`.`id` = `b`.`locality_id`) INNER JOIN `business_categories` AS `bcat` ON (`bcat`.`business_id` = `bb`.`business_id`) INNER JOIN `categories` AS `cat` ON (`cat`.`id` = `bcat`.`category_id`)";
            $extraWhere = "";
            $groupBy = '`bcat`.`business_id`,`bb`.`id`';
            $having = "Yes";

            App::uses('SSP', 'Utility');
            $response = SSP::simple($_GET, $this->db_config, $table, $primaryKey, $columns, $joinQuery, $extraWhere, $groupBy, '', $having);
            print(json_encode($response));
            exit;
        }
    }

    /**
     * Used for displaying all business bookings
     * in business dashboard of a business
     * user.
     * @return type null.
     */
    public function bookings() {
        $title_for_layout = 'Booking Requests';
        $this->set(compact('title_for_layout'));
        $user = $this->Session->read('Auth.User');

        $options['fields'] = array('Business.id');
        $options['conditions'] = array('Business.status' => '1');
        $options['recursive'] = -1;
        $user_business = $this->Format->get_business_list($user['id'], $options, 'list');

        $booking_data = array();
        if (!empty($user_business)) {
            $this->loadModel('BusinessBooking');
            $params = array('conditions' => array('Business.status' => '1', 'BusinessBooking.business_id' => $user_business));
            $params['fields'] = array('BusinessBooking.*', 'Business.name', 'User.name', 'User.id',
                "IF(DATE(`BusinessBooking`.`from_date`)<CURDATE(),'Expired','Upcoming') AS stats");
            $params['order'] = array(
                'IF(DATE(BusinessBooking.from_date)<CURDATE(),3,2)' => 'ASC',
                'IF(DATE(`BusinessBooking`.`from_date`)<CURDATE(),BusinessBooking.from_date,0)' => 'DESC',
                'BusinessBooking.from_date' => 'ASC');
            $booking_data = $this->BusinessBooking->find('all', $params);
        }
        $this->set('bookings', $booking_data);
    }

    /**
     * Used for listing user's bookings
     * in user dashboard
     * @return type null
     */
    public function my_bookings() {
        $title_for_layout = 'My Bookings';
        $this->set(compact('title_for_layout'));
        $user = $this->Session->read('Auth.User');
        $this->loadModel('BusinessBooking');
        $this->BusinessBooking->unbindModel(array('belongsTo' => array('User')));
        $params = array('conditions' => array('Business.status' => '1', 'BusinessBooking.user_id' => $user['id']));
        $params['fields'] = array('BusinessBooking.*', 'Business.name',
            "IF(DATE(`BusinessBooking`.`from_date`)<CURDATE(),'Expired','Upcoming') AS stats");
        $params['order'] = array(
            'IF(DATE(BusinessBooking.from_date)<CURDATE(),3,2)' => 'ASC',
            'IF(DATE(`BusinessBooking`.`from_date`)<CURDATE(),BusinessBooking.from_date,0)' => 'DESC',
            'BusinessBooking.from_date' => 'ASC');
        $booking_data = $this->BusinessBooking->find('all', $params);
        $this->set('bookings', $booking_data);
        $this->recently_viewed_classes();
    }

    public function view_booking($id = null, $business = null) {
        $this->set('bname', (isset($this->params['pass'][1])) ? $this->params['pass'][1] : '');
    }

    /**
     * Used for approving and disapproving bookings 
     * by business user.
     * @return type null
     */
    public function grant_bookings($id = null) {
        $id = $this->request->params['pass'][0];
        $this->loadModel('BusinessBooking');
        if ($this->BusinessBooking->exists($id)) {
            $statusData = $this->BusinessBooking->findById($id);
            $booking_status_val = (intval($statusData['BusinessBooking']['approved']) == 0) ? 1 : 0;
            $booking_status_msg = (intval($statusData['BusinessBooking']['approved']) == 1) ? 'Booking Disapproved' : 'Booking Approved';
            $status = (intval($statusData['BusinessBooking']['approved']) == 1) ? 'Disapproved' : 'Approved';
            $this->BusinessBooking->id = $id;
            if ($this->BusinessBooking->saveField('approved', $booking_status_val)) {
                //if ($booking_status_val) { //$booking_status_val is integer here,not string.

                /* load email config class and keep the conenection open untill all mails are sent */
                $Email = new CakeEmail(Configure::read('EMAIL_DELIVERY_MODE'));
                $Email->config(array('persistent' => true));

                /* email to user */
                if (trim($statusData['User']['email']) != '') {
                    $Email->from(array(Configure::read('COMPANY.FROM_EMAIL') => Configure::read('COMPANY.NAME')));
                    $Email->viewVars(array('for' => 'user', 'name' => $statusData['User']['name'],
                        'businessName' => $statusData['Business']['name'],
                        'start' => $statusData['BusinessBooking']['from_date'], 'end' => $statusData['BusinessBooking']['to_date'],
                        'seats' => $statusData['BusinessBooking']['seats'], 'status' => $status, 'to' => 'user'));
                    $Email->to($statusData['User']['email']);
                    $Email->subject("Booking request for " . $statusData['Business']['name'] . " is $status.");
                    $Email->template('booking_approval');
                    $Email->send();
                }

                /* email to admin */
                $Email->from(array(Configure::read('COMPANY.FROM_EMAIL') => Configure::read('COMPANY.NAME')));
                $Email->viewVars(array('for' => 'admin', 'name' => $statusData['User']['name'],
                    'businessName' => $statusData['Business']['name'],
                    'start' => $statusData['BusinessBooking']['from_date'], 'end' => $statusData['BusinessBooking']['to_date'],
                    'seats' => $statusData['BusinessBooking']['seats'], 'status' => $status, 'to' => 'user'));
                $Email->to(Configure::read('COMPANY.ADMIN_EMAIL'));
                $Email->subject("Booking request for " . $statusData['Business']['name'] . " is $status by business owner.");
                $Email->template('booking_approval');
                $Email->send();

                /* Disconnect email connection */
                if (Configure::read('EMAIL_DELIVERY_MODE') == 'smtp') {
                    $Email->disconnect();
                }
                $this->Flash->Success(__($booking_status_msg));
                $this->redirect(array('controller' => 'reports', 'action' => 'bookings'));
            } else {
                $this->Flash->Error(__('Operation Failed.'));
            }
        } else {
            $this->Flash->Error(__('Invalid Booking'));
        }
        $this->redirect(array('controller' => 'reports', 'action' => 'bookings'));
    }

    public function admin_view_booking($id = '') {
        $this->loadModel('BusinessBooking');
        $this->BusinessBooking->unbindModel(array('belongsTo' => array('User')));
        $params = array('conditions' => array('BusinessBooking.id' => $id));
        $params['fields'] = array('BusinessBooking.*', 'Business.name');
        $booking_data = $this->BusinessBooking->find('first', $params);
        $this->set('booking', $booking_data);
    }

    public function admin_feedbacks() {
        $this->layout = (isset($this->params['pass'][0]) && $this->params['pass'][0] == "ajax_feedback_delete") ? 'ajax' : 'admin';
    }

    public function feedbacks_ajax() {
        if ($this->request->is('ajax')) {
            $table = 'feedback';
            $primaryKey = 'id';
            $columns = array(
                array('db' => 'id', 'dt' => 0, 'field' => 'id'),
                array('db' => 'created', 'dt' => 1, 'field' => 'created', 'as' => 'created'),
                array('db' => 'name', 'dt' => 2, 'field' => 'name'),
                array('db' => 'email', 'dt' => 3, 'field' => 'email'),
                array('db' => 'feedback_type', 'dt' => 4, 'field' => 'feedback_type'),
                array('db' => 'comment', 'dt' => 5, 'field' => 'comment'),
                array('db' => 'is_complete', 'dt' => 6, 'field' => 'is_complete')
            );
            $joinQuery = "";
            $extraWhere = "`type` = 'feedback'";

            App::uses('SSP', 'Utility');
            $response = SSP::simple($_GET, $this->db_config, $table, $primaryKey, $columns, $joinQuery, $extraWhere);
            print(json_encode($response));
            exit;
        }
    }

    public function admin_delete_feedbacks($id) {
        $this->layout = "ajax";
        if ($id > 0) {
            $this->loadModel('Feedback');
            if ($this->Feedback->delete($id)) {
                $this->Flash->AdminSuccess(__('Feedback deleted successfully.'));
            } else {
                $this->Flash->AdminError(__('Error. Feedback not deleted. Please try again.'));
            }
        }
        $this->redirect(array('action' => 'feedbacks', 'admin' => 1)); //, "ajax_feedback_delete"
    }

    function booking_detail($id = '') {
        $this->layout = "ajax";
        $this->loadModel('BusinessBooking');

        $this->BusinessBooking->unbindModel(array('belongsTo' => array('User')));
        $params = array('conditions' => array('BusinessBooking.id' => $id));
        $params['fields'] = array('BusinessBooking.*', 'Business.name',
            "IF(DATE(`BusinessBooking`.`from_date`)<CURDATE(),'Expired','Upcoming') AS stats");
        $booking_data = $this->BusinessBooking->find('first', $params);
        $this->set('booking', $booking_data);
    }

    function admin_users() {
        $this->loadModel('User');
        if (isset($this->params['type']) && $this->params['type'] == 'admin') {
            $condition = array('User.type' => '1');
            $path = "Add_Admin";
        } else {
            $condition = array('User.type !=' => '1');
            $path = "Add_User";
        }
        $condition['User.id !='] = $this->Auth->user('id');
        $users = $this->User->find('all', array('conditions' => $condition));
        $this->set('users', $users);
        $this->set('path', $path);
    }

    function admin_write_to_us($id = '') {
        $this->loadModel('Feedback');
        if (intval($id) > 0) {
            if ($this->Feedback->delete($id)) {
                $this->Flash->AdminSuccess(__('Request deleted successfully.'));
            } else {
                $this->Flash->AdminError(__('Error. Request not deleted. Please try again.'));
            }
            $this->redirect(array('action' => 'write_to_us'));
        }
    }

    public function write_to_us_ajax() {
        if ($this->request->is('ajax')) {
            $table = 'feedback';
            $primaryKey = 'id';
            $columns = array(
                array('db' => 'name', 'dt' => 0, 'field' => 'name'),
                array('db' => 'comment', 'dt' => 1, 'field' => 'comment'),
                array('db' => 'created', 'dt' => 2, 'field' => 'created', 'as' => 'created'),
                array('db' => 'id', 'dt' => 3, 'field' => 'id'),
                array('db' => 'is_complete', 'dt' => 4, 'field' => 'is_complete')
            );
            $joinQuery = "";
            $extraWhere = "`type` = 'writetous'";

            App::uses('SSP', 'Utility');
            $response = SSP::simple($_GET, $this->db_config, $table, $primaryKey, $columns, $joinQuery, $extraWhere);
            print(json_encode($response));
            exit;
        }
    }

    function admin_ask_us_anything($id = '') {
        $this->loadModel('Feedback');
        if (intval($id) > 0) {
            if ($this->Feedback->delete($id)) {
                $this->Flash->AdminSuccess(__('Request deleted successfully.'));
            } else {
                $this->Flash->AdminError(__('Error. Request not deleted. Please try again.'));
            }
            $this->redirect(array('action' => 'write_to_us'));
        }
    }

    public function ask_us_anything_ajax() {
        if ($this->request->is('ajax')) {
            $table = 'feedback';
            $primaryKey = 'id';
            $columns = array(
                array('db' => 'name', 'dt' => 0, 'field' => 'name'),
                array('db' => 'email', 'dt' => 1, 'field' => 'email'),
                array('db' => 'comment', 'dt' => 2, 'field' => 'comment'),
                array('db' => 'created', 'dt' => 3, 'field' => 'created', 'as' => 'created'),
                array('db' => 'id', 'dt' => 4, 'field' => 'id'),
                array('db' => 'is_complete', 'dt' => 5, 'field' => 'is_complete')
            );
            $joinQuery = "";
            $extraWhere = "`type` = 'ask'";

            App::uses('SSP', 'Utility');
            $response = SSP::simple($_GET, $this->db_config, $table, $primaryKey, $columns, $joinQuery, $extraWhere);
            print(json_encode($response));
            exit;
        }
    }

    public function admin_group_booking_requests(){
        if ($this->request->is('ajax')) {
            $table = 'group_booking_requests';
            $primaryKey = 'id';
            $columns = array(
                array('db' => '`gbr`.`id`', 'dt' => 0, 'field' => 'grb_id', 'as' => 'grb_id'),
                array('db' => '`gbr`.`name`', 'dt' => 1, 'field' => 'person_name', 'as' => 'person_name'),
                array('db' => '`gbr`.`email`', 'dt' => 2, 'field' => 'email', 'as' => 'email'),
                array('db' => '`gbr`.`phone`', 'dt' => 3, 'field' => 'phone', 'as' => 'phone'),
                array('db' => '`gbr`.`group_size`', 'dt' => 4, 'field' => 'group_size', 'as' => 'group_size'),
                array('db' => '`gbr`.`looking_for`', 'dt' => 5, 'field' => 'looking_for', 'as' => 'looking_for'),
                array('db' => 'CONCAT_WS(", ",gbr.address,loc.name,cit.name,gbr.pincode)', 'dt' => 6, 'field' => 'address', 'as' => 'address'),
                array('db' => '`gbr`.`created`', 'dt' => 7, 'field' => 'created', 'as' => 'created'),
                array('db' => '`gbr`.`is_complete`', 'dt' => 8, 'field' => 'is_complete', 'as' => 'is_complete')
            );
            $joinQuery = "FROM `group_booking_requests` AS `gbr` LEFT JOIN `cities` AS `cit` ON (`cit`.`id` = `gbr`.`city_id`) LEFT JOIN `localities` AS `loc` ON (`loc`.`id` = `gbr`.`locality_id`)";

            App::uses('SSP', 'Utility');
            $response = SSP::simple($_GET, $this->db_config, $table, $primaryKey, $columns, $joinQuery);
            print(json_encode($response));
            exit;
        }

    }

    function admin_mark_complete() {
        $id = $this->request->data['id'];
        $state = $this->request->data['state'];
        $mode = $this->request->data['mode'];
        $this->loadModel('Feedback');
        $this->loadModel('Contact');
        $this->loadModel('Inquiry');
        $this->loadModel('Transaction');
        $this->loadModel('BusinessBooking');
        $this->loadModel('ContactNumberRequest');
        $this->loadModel('GroupBookingRequest');
        $this->loadModel('BusinessFavorite');
        if (intval($id) > 0) {
            if ($mode == 'call_request') {
                $this->Contact->updateAll(array('Contact.is_complete' => ($state == 'restore' ? '0' : '1')), array('Contact.id' => $id));
            } elseif ($mode == 'inquiry') {
                $this->Inquiry->updateAll(array('Inquiry.is_complete' => ($state == 'restore' ? '0' : '1')), array('Inquiry.id' => $id));
            } elseif ($mode == 'business_bookings') {
                $this->BusinessBooking->updateAll(array('BusinessBooking.is_complete' => ($state == 'restore' ? '0' : '1')), array('BusinessBooking.id' => $id));
            } elseif ($mode == 'contact_information_request') {
                $this->ContactNumberRequest->updateAll(array('ContactNumberRequest.is_complete' => ($state == 'restore' ? '0' : '1')), array('ContactNumberRequest.id' => $id));
            } elseif ($mode == 'transactions') {
                $this->Transaction->updateAll(array('Transaction.is_complete' => ($state == 'restore' ? '0' : '1')), array('Transaction.id' => $id));
            } elseif ($mode == 'group_bookings') {
                $this->GroupBookingRequest->updateAll(array('GroupBookingRequest.is_complete' => ($state == 'restore' ? '0' : '1')), array('GroupBookingRequest.id' => $id));
            } elseif ($mode == 'business_favorites') {
                $this->BusinessFavorite->updateAll(array('BusinessFavorite.is_complete' => ($state == 'restore' ? '0' : '1')), array('BusinessFavorite.id' => $id));
            } else {
                $this->Feedback->updateAll(array('Feedback.is_complete' => ($state == 'restore' ? '0' : '1')), array('Feedback.id' => $id));
            }
            $success = 1;
            $message = ($state == 'restore' ? 'Restored' : 'Marked completed') . ' successfully.';
        } else {
            $success = 0;
            $message = '';
        }

        echo json_encode(array('success' => $success, 'message' => $message));
        exit;
    }

    public function admin_mark_complete_all() {
        $b_id = $this->request->data['business_id'];
        $mode = $this->request->data['mode'];
        $condition_mode = ($mode == 'restore') ? '0' : '1';

        $this->loadModel('ContactNumberRequest');
        $condition = ($mode == 'restore') ? '1' : '0';
        $data = $this->ContactNumberRequest->find('all', array('conditions' => array('ContactNumberRequest.business_id' => $b_id, 'ContactNumberRequest.is_complete' => $condition)));
        $action_array = array();
        foreach ($data as $key => $value) {
            $action_array[] = array('id' => $value['ContactNumberRequest']['id'], 'is_complete' => $condition_mode);
        }
        $this->ContactNumberRequest->saveAll($action_array);
        $success = 1;
        $message = ($mode == 'restore' ? 'Restored' : 'Marked completed') . ' successfully.';
        echo json_encode(array('success' => $success, 'message' => $message));
        exit;
    }

}
