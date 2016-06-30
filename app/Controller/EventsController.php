<?php

App::uses('AppController', 'Controller');

/**
 * Events Controller
 *
 * @property Event $Event
 * @property PaginatorComponent $Paginator
 * @property FlashComponent $Flash
 */
class EventsController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'Flash');

    /**
     * index method
     *
     * @return void
     */
    public function index() {
        $user_id = $this->Auth->user('id');
        $params = array('conditions' => array('Event.user_id' => $user_id));
        $params['fields'] = array();
        $events = $this->Event->find('all', $params);
        #pr($events);exit;
        $this->set('events', $events);
        parent::recently_viewed_classes();
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        if (!$this->Event->exists($id)) {
            throw new NotFoundException(__('Invalid event'));
        }
        $options = array('conditions' => array('Event.' . $this->Event->primaryKey => $id));
        $this->set('event', $this->Event->find('first', $options));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        $user_id = $this->Auth->user('id');
        if ($this->request->is('post')) {
            $data = $this->request->data;
            $data['Event']['fee'] = (trim($data['Event']['fee_type']) === "free") ? 0 : (float) $data['Event']['fee'];

            if (trim($data['Event']['schedule_type']) === "Immediate") {
                $data['Event']['start_date'] = $data['Event']['start_date'];
                $data['Event']['end_date'] = $data['Event']['end_date'];
                $data['Event']['is_start_immediately'] = 1;
            } else {
                $data['Event']['is_start_immediately'] = 0;
            }

            unset($data['Event']['custom_end_date']);
            unset($data['Event']['event_range_start']);
            unset($data['Event']['event_range_end']);
            unset($data['Event']['locality_id_tmp']);

            $data['Event']['user_id'] = $user_id;
            $this->Event->set($data);
            if ($this->Event->validates(array('fieldList' => array('banner')))) {
                $this->Event->create();
                if ($this->Event->save($data)) {
                    $this->Flash->success(__('The event has been saved.'));
                    $this->redirect(array('action' => 'index'));
                }
            } else {
                $errors = $this->Event->invalidFields();
                $this->Flash->error(__("Validation error. Please, try again."));
            }
        }
        parent::recently_viewed_classes();

        $ucities = $this->Format->cities('list', 'business');
        $this->set(compact('ucities'));
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        $user_id = $this->Auth->user('id');
        if (!$this->Event->exists($id)) {
            throw new NotFoundException(__('Invalid event'));
        }
        if ($this->request->is(array('post', 'put'))) {
            $data = $this->request->data;
            $data['Event']['fee'] = (trim($data['Event']['fee_type']) === "free") ? 0 : (float) $data['Event']['fee'];
            if (trim($data['Event']['schedule_type']) === "Immediate") {
                $data['Event']['start_date'] = $data['Event']['start_date'];
                $data['Event']['end_date'] = $data['Event']['end_date'];
                $data['Event']['is_start_immediately'] = 1;
            } else {
                $data['Event']['is_start_immediately'] = 0;
            }

            unset($data['Event']['custom_end_date']);
            unset($data['Event']['event_range_start']);
            unset($data['Event']['event_range_end']);
            unset($data['Event']['locality_id_tmp']);
            $data['Event']['user_id'] = $user_id;
            $this->Event->set($data);
            if ($this->Event->validates(array('fieldList' => array('banner')))) {
                $this->Event->create();
                if ($this->Event->saveAll($data)) {
                    $this->Flash->success(__('The event has been saved.'));
                    $this->redirect(array('action' => 'index'));
                }
            } else {
                $errors = $this->Event->invalidFields();
                $this->Flash->error(__("Validation error. Please, try again."));
            }
        } else {
            $options = array('conditions' => array('Event.' . $this->Event->primaryKey => $id));
            $this->request->data = $this->Event->find('first', $options);
        }
        parent::recently_viewed_classes();

        $user_id = $this->Auth->user('id');
        $ucities = $this->Format->cities('list', 'business');
        $this->set(compact('ucities'));
    }

    /**
     * delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function delete($id = null) {
        $this->Event->id = $id;

        if (!$this->Event->exists()) {
            throw new NotFoundException(__('Invalid event'));
        }
        $this->request->allowMethod('post', 'delete');
        if ($this->Event->delete()) {
            #return $this->flash(__('The event has been deleted.'), array('action' => 'index'));
            $this->Flash->success(__('The event has been deleted.'));
        } else {
            #return $this->flash(__('The event could not be deleted. Please, try again.'), array('action' => 'index'));
            $this->Flash->error(__('The event could not be deleted. Please try again.'));
        }
        $this->redirect(array('action' => 'index'));
    }

    /**
     * admin_index method
     *
     * @return void
     */
    public function admin_index() {
        if ($this->request->is('ajax')) {
            $columns = array(
                array('db' => '`e`.`id`', 'dt' => 0, 'field' => 'id', 'as' => 'id'),
                array('db' => '`e`.`name`', 'dt' => 1, 'field' => 'event_name', 'as' => 'event_name'),
                array('db' => '`c`.`name`', 'dt' => 2, 'field' => 'city_name', 'as' => 'city_name'),
                array('db' => 'CONCAT_WS(", ",e.address,IFNULL(e.landmark, ""),l.name,c.name,e.pincode)', 'dt' => 3, 'field' => 'event_address', 'as' => 'event_address'),
                array('db' => '`e`.`contact_person`', 'dt' => 4, 'field' => 'contact_person', 'as' => 'contact_person'),
                array('db' => '`e`.`start_date`', 'dt' => 5, 'field' => 'start_date', 'as' => 'start_date'),
                array('db' => '`e`.`end_date`', 'dt' => 6, 'field' => 'end_date', 'as' => 'end_date'),
                array('db' => '`e`.`created`', 'dt' => 7, 'field' => 'created', 'as' => 'created'),
                array('db' => '`e`.`status`', 'dt' => 8, 'field' => 'status', 'as' => 'status'),
                array('db' => '`l`.`name`', 'dt' => 9, 'field' => 'locality_name', 'as' => 'locality_name'),
            );
            $joinQuery = "FROM `events` AS `e` "
                    . "LEFT JOIN `users` AS `u` ON (`u`.`id` = `e`.`user_id`) "
                    . "LEFT JOIN `cities` AS `c` ON (`c`.`id` = `e`.`city_id`) "
                    . "LEFT JOIN `localities` AS `l` ON (`l`.`id` = `e`.`locality_id`) ";
            $extraWhere = "";

            App::uses('SSP', 'Utility');
            $response = SSP::simple($_GET, $this->db_config, 'events', 'id', $columns, $joinQuery, $extraWhere);
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
        if (!$this->Event->exists($id)) {
            throw new NotFoundException(__('Invalid event'));
        }
        $options = array('conditions' => array('Event.' . $this->Event->primaryKey => $id));
        $this->set('event', $this->Event->find('first', $options));
    }

    /**
     * admin_add method
     *
     * @return void
     */
    public function admin_add() {
        if ($this->request->is('post')) {
            $data = $this->request->data;

            $data['Event']['fee'] = (trim($data['Event']['fee_type']) === "free") ? 0 : (float) $data['Event']['fee'];

            if (trim($data['Event']['schedule_type']) === "Immediate") {
                $data['Event']['start_date'] = date("Y-m-d", strtotime(str_replace("/", "-", $data['Event']['custom_end_date'])));
                $data['Event']['end_date'] = "";
                #$data['Event']['start_date'] = $data['Event']['start_date'];
                #$data['Event']['end_date'] = $data['Event']['end_date'];
                $data['Event']['is_start_immediately'] = 1;
            } else {
                $event_range = explode("-", $data['Event']['event_range']);
                $data['Event']['start_date'] = date("Y-m-d", strtotime(str_replace("/", "-", trim($event_range[0]))));
                $data['Event']['end_date'] = date("Y-m-d", strtotime(str_replace("/", "-", trim($event_range[1]))));
                $data['Event']['is_start_immediately'] = 0;
            }

            unset($data['Event']['custom_end_date']);
            unset($data['Event']['event_range']);
            unset($data['Event']['dir_path']);
            $data['Event']['status'] = 1;
            $this->Event->set($data);
            if ($this->Event->validates(array('fieldList' => array('banner')))) {
                $this->Event->create();
                if ($this->Event->save($data)) {
                    $this->Flash->AdminSuccess(__('The event has been saved.'));
                    $this->redirect(array('action' => 'index', 'admin' => 1));
                }
            } else {
                $errors = $this->Event->invalidFields();
                $this->Flash->AdminError(__("Validation error. Please, try again."));
            }
        }
        $users = $this->Format->get_users();
        $cities = $this->Format->cities('list', 'business');
        $this->set(compact('users', 'cities'));
    }

    public function delete_banner($id = null) {
        $id = $this->data['id'];
        $this->Event->id = $id;
        $success = 0;
        $msg = '';
        if (!$this->Event->exists()) {
            throw new NotFoundException(__('Invalid event'));
        }
        $this->request->allowMethod('post', 'delete');
        if (intval($id) > 0) {
            $this->Event->recursive = false;
            $event = $this->Event->find('first', array('conditions' => array('Event.id' => $id), 'fields' => array('Event.id', 'Event.banner')));
            $eid = $event['Event']['id'];
            $filename = EVENT_BANNER_DIR . "banner" . DS . $eid . DS . $event['Event']['banner'];
            if (file_exists($filename)) {
                $this->Format->deleteDir(EVENT_BANNER_DIR . "banner" . DS . $eid . DS);
                if ($this->Event->save(array('banner' => '', 'id' => $id))) {
                    $msg = __('The event banner has been deleted.');
                    $success = 1;
                } else {
                    $msg = __('The event banner could not be deleted. Please, try again.');
                }
            } else {
                $msg = __('File not found. Please, try again.');
            }
        } else {
            $msg = __('The event banner could not be deleted. Please, try again.');
        }
        echo json_encode(array('success' => $success, 'message' => $msg));
        exit;
    }

    /**
     * admin_edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_edit($id = null) {
        if (!$this->Event->exists($id)) {
            throw new NotFoundException(__('Invalid event'));
        }
        if ($this->request->is(array('post', 'put'))) {

            $data = $this->request->data;

            $data['Event']['fee'] = (trim($data['Event']['fee_type']) === "free") ? 0 : (float) $data['Event']['fee'];

            if (trim($data['Event']['schedule_type']) === "Immediate") {
                $data['Event']['start_date'] = date("Y-m-d", strtotime(str_replace("/", "-", $data['Event']['custom_end_date'])));
                $data['Event']['end_date'] = "";
                #$data['Event']['start_date'] = $data['Event']['start_date'];
                #$data['Event']['end_date'] = $data['Event']['end_date'];
                $data['Event']['is_start_immediately'] = 1;
            } else {
                $event_range = explode("-", $data['Event']['event_range']);
                $data['Event']['start_date'] = date("Y-m-d", strtotime(str_replace("/", "-", trim($event_range[0]))));
                $data['Event']['end_date'] = date("Y-m-d", strtotime(str_replace("/", "-", trim($event_range[1]))));
                $data['Event']['is_start_immediately'] = 0;
            }

            unset($data['Event']['custom_end_date']);
            unset($data['Event']['event_range']);
            unset($data['Event']['locality_id_tmp']);
            #pr($data);exit;

            $this->Event->set($data);
            if ($this->Event->validates(array('fieldList' => array('banner')))) {
                $this->Event->create();
                if ($this->Event->saveAll($data)) {
                    $this->Flash->AdminSuccess(__('The event has been updated.'));
                    $this->redirect(array('action' => 'index', 'admin' => 1));
                }
            } else {
                $errors = $this->Event->invalidFields();
                $this->Flash->AdminError(__("Validation error. Please, try again."));
            }
        } else {
            $options = array('conditions' => array('Event.' . $this->Event->primaryKey => $id));
            $this->request->data = $this->Event->find('first', $options);
        }
        $users = $this->Format->get_users();
        $cities = $this->Format->cities('list', 'business');
        $this->set(compact('users', 'cities'));
    }

    /**
     * admin_delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_delete($id = null) {
        $this->Event->id = $id;
        if (!$this->Event->exists()) {
            throw new NotFoundException(__('Invalid event'));
        }
        #$this->request->allowMethod('post', 'delete');
        if ($this->Event->delete()) {
            #return $this->flash(__('The event has been deleted.'), array('action' => 'index'));
            $this->Flash->AdminSuccess(__('The event has been deleted.'));
        } else {
            #return $this->flash(__('The event could not be deleted. Please, try again.'), array('action' => 'index'));
            $this->Flash->AdminError(__('The event could not be deleted. Please try again.'));
        }
        $this->redirect(array('action' => 'index', 'admin' => 1));
    }

    function admin_grant($id = '') {
        $this->Event->id = $id;
        if ($this->Event->exists()) {
            $options['joins'] = array(
                array('table' => 'users', 'alias' => 'User', 'type' => 'LEFT', 'conditions' => array('User.id = Event.user_id'))
            );
            $options['fields'] = array('User.name', 'User.email', 'User.id', 'Event.id', 'Event.name', 'Event.email', 'Event.status', 'Event.created');
            $options['conditions'] = array('Event.id' => $id);
            $options['recursive'] = -1;
            $statusData = $this->Event->find('first', $options);

            $event_status_val = (intval($statusData['Event']['status']) == 0) ? 1 : 0;
            $event_status_msg = (intval($statusData['Event']['status']) == 1) ? 'Event Disabled' : 'Event Enabled';
            $event_status = (intval($statusData['Event']['status']) == 1) ? 'disabled' : 'enabled';
            if ($this->Event->saveField('status', $event_status_val)) {
                /* email to user */
                /* load email config class and keep the conenection open untill all mails are sent */
                if ($statusData['User']['email'] != '') {
                    $Email = new CakeEmail(Configure::read('EMAIL_DELIVERY_MODE'));
                    $Email->config(array('persistent' => true));

                    $Email->from(array(Configure::read('COMPANY.FROM_EMAIL') => Configure::read('COMPANY.NAME')));
                    $Email->viewVars(array('for' => 'user', 'name' => $statusData['User']['name'], 'eventname' => $statusData['Event']['name'], 'status' => $event_status));
                    $Email->to($statusData['User']['email']);
                    $Email->subject('Your Event ' . ($event_status == 'enabled' ? "Approved" : "Disapproved") . ' - ' . Configure::read('COMPANY.NAME'));
                    $Email->template('event_grant');
                    $Email->send();

                    /* Disconnect email connection */
                    if (Configure::read('EMAIL_DELIVERY_MODE') == 'smtp') {
                        $Email->disconnect();
                    }

                    $this->Flash->AdminSuccess(__($event_status_msg));
                } else {
                    $this->Flash->AdminError(__('Operation Failed.'));
                }
            } else {
                $this->Flash->AdminError(__('Invalid Event'));
            }
        }
        $this->redirect(array('action' => 'index', 'admin' => 1));
    }

    public function admin_event_inquiry() {
        if ($this->request->is('ajax')) {
            $columns = array(
                array('db' => '`e`.`id`', 'dt' => 0, 'field' => 'id', 'as' => 'id'),
                array('db' => '`ev`.`name`', 'dt' => 1, 'field' => 'event_name', 'as' => 'event_name'),
                array('db' => '`e`.`name`', 'dt' => 2, 'field' => 'user_name', 'as' => 'user_name'),
                array('db' => '`e`.`phone`', 'dt' => 3, 'field' => 'user_phone', 'as' => 'user_phone'),
                array('db' => '`e`.`email`', 'dt' => 4, 'field' => 'user_email', 'as' => 'user_email'),
                array('db' => '`e`.`act`', 'dt' => 5, 'field' => 'act', 'as' => 'act'),
                array('db' => '`e`.`ip`', 'dt' => 6, 'field' => 'ip', 'as' => 'ip'),
                array('db' => '`e`.`created`', 'dt' => 7, 'field' => 'created', 'as' => 'created'),
                array('db' => '`e`.`created`', 'dt' => 8, 'field' => 'created1', 'as' => 'created1'),
            );
            $joinQuery = "FROM `event_inquiries` AS `e` "
                    #. "LEFT JOIN `users` AS `u` ON (`u`.`id` = `e`.`user_id`) "
                    . "LEFT JOIN `events` AS `ev` ON (`ev`.`id` = `e`.`event_id`) ";
            $extraWhere = "";

            App::uses('SSP', 'Utility');
            $response = SSP::simple($_GET, $this->db_config, 'event_inquiries', 'id', $columns, $joinQuery, $extraWhere);
            print(json_encode($response));
            exit;
        }
    }

    function admin_delete_inquiry($id = '') {
        $this->loadModel('EventInquiry');
        $this->EventInquiry->id = $id;
        if (!$this->EventInquiry->exists()) {
            throw new NotFoundException(__('Invalid event'));
        }
        #$this->request->allowMethod('post', 'delete');
        if ($this->EventInquiry->delete()) {
            #return $this->flash(__('The event has been deleted.'), array('action' => 'index'));
            $this->Flash->AdminSuccess(__('The event inquiry has been deleted.'));
        } else {
            #return $this->flash(__('The event could not be deleted. Please, try again.'), array('action' => 'index'));
            $this->Flash->AdminError(__('The event inquiry could not be deleted. Please try again.'));
        }
        $this->redirect(array('action' => 'event_inquiry', 'admin' => 1));
    }

}
