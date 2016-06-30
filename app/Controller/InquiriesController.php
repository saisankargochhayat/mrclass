<?php

App::uses('AppController', 'Controller');

/**
 * Inquiries Controller
 *
 * @property Inquiry $Inquiry
 * @property PaginatorComponent $Paginator
 */
class InquiriesController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator');

    /**
     * admin_index method
     *
     * @return void
     */
    public function admin_index() {
        
    }

    public function enquiries_ajax() {
        if ($this->request->is('ajax')) {
            $table = 'inquiries';
            $primaryKey = 'id';
            $columns = array(
                array('db' => '`e`.`id`', 'dt' => 0, 'field' => 'id'),
                array('db' => 'e.name', 'dt' => 1, 'field' => 'inquiry_name', 'as' => 'inquiry_name'),
                array('db' => '`e`.`phone`', 'dt' => 2, 'field' => 'phone'),
                array('db' => '`e`.`email`', 'dt' => 3, 'field' => 'email'),
                array('db' => '`c`.`name`', 'dt' => 4, 'field' => 'category_name', 'as' => 'category_name'),
                array('db' => '`e`.`comment`', 'dt' => 5, 'field' => 'comment'),
                array('db' => '`e`.`created`', 'dt' => 6, 'field' => 'created', 'as' => 'created'),
                array('db' => '`e`.`is_complete`', 'dt' => 7, 'field' => 'is_complete')
            );
            $joinQuery = "FROM `inquiries` AS `e` JOIN `categories` AS `c` ON (`c`.`id` = `e`.`category_id`)";
            $extraWhere = "";

            App::uses('SSP', 'Utility');
            $response = SSP::simple($_GET, $this->db_config, $table, $primaryKey, $columns, $joinQuery, $extraWhere);
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
        if (!$this->Inquiry->exists($id)) {
            throw new NotFoundException(__('Invalid inquiry'));
        }
        $options = array('conditions' => array('Inquiry.' . $this->Inquiry->primaryKey => $id));
        $this->set('inquiry', $this->Inquiry->find('first', $options));
    }

    /**
     * admin_add method
     *
     * @return void
     */
    public function admin_add() {
        if ($this->request->is('post')) {
            $this->Inquiry->create();
            if ($this->Inquiry->save($this->request->data)) {
                $this->Flash->success(__('The inquiry has been saved.'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->error(__('The inquiry could not be saved. Please, try again.'));
            }
        }
        $categories = $this->Inquiry->Category->find('list');
        $subCategories = $this->Inquiry->SubCategory->find('list');
        $this->set(compact('categories', 'subCategories'));
    }

    /**
     * admin_edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_edit($id = null) {
        if (!$this->Inquiry->exists($id)) {
            throw new NotFoundException(__('Invalid inquiry'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if ($this->Inquiry->save($this->request->data)) {
                $this->Flash->success(__('The inquiry has been saved.'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->error(__('The inquiry could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Inquiry.' . $this->Inquiry->primaryKey => $id));
            $this->request->data = $this->Inquiry->find('first', $options);
        }
        $categories = $this->Inquiry->Category->find('list');
        $subCategories = $this->Inquiry->SubCategory->find('list');
        $this->set(compact('categories', 'subCategories'));
    }

    /**
     * admin_delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_delete($id = null) {
        $this->Inquiry->id = $id;
        if (!$this->Inquiry->exists()) {
            throw new NotFoundException(__('Invalid inquiry'));
        }
        if ($this->Inquiry->delete()) {
            $this->Flash->success(__('The inquiry has been deleted.'));
        } else {
            $this->Flash->error(__('The inquiry could not be deleted. Please, try again.'));
        }
        return $this->redirect(array('action' => 'index'));
    }

    public function admin_contact_requests_info() {
        $this->loadModel('ContactNumberRequest');
        $options['joins'] = array(
            array('table' => 'businesses', 'alias' => 'Business', 'type' => 'LEFT', 'conditions' => array('Business.id=ContactNumberRequest.business_id')),
            array('table' => 'cities', 'alias' => 'City', 'type' => 'LEFT', 'conditions' => array('Business.city_id=City.id')),
            array('table' => 'localities', 'alias' => 'Locality', 'type' => 'LEFT', 'conditions' => array('Business.locality_id=Locality.id')),
            array('table' => 'categories', 'alias' => 'Category', 'type' => 'LEFT', 'conditions' => array('Category.id=Business.category_id'))
        );
        $options['fields'] = array('ContactNumberRequest.*', 'Business.*', 'Category.name',
            'City.name', 'Locality.name',
            'SUM(ContactNumberRequest.is_complete) AS is_complete',
            'COUNT(ContactNumberRequest.business_id) AS number_of_request');
        $options['group'] = '`ContactNumberRequest`.`business_id`';
        $options['order'] = array('ContactNumberRequest.created' => 'DESC');
        $options['conditions'] = array('ContactNumberRequest.business_id >' => 0, 'ContactNumberRequest.user_id >' => 0, 'Business.id !=' => '');
        $data = $this->ContactNumberRequest->find('all', $options);

        $business_ids = Hash::extract($data, '{n}.Business.id');
        $this->loadModel('Business');
        $this->Business->unBindModel(array('hasAndBelongsToMany' => array('Facility', 'SubCategory')));
        $this->Business->unBindModel(array('belongsTo' => array('User', 'City', 'Locality')));
        $this->Business->unBindModel(array('hasMany' => array('BusinessLanguage', 'BusinessGallery', 'BusinessRating', 'BusinessTiming', 'BusinessKeyword', 'BusinessFaq')));
        $option['conditions'] = array('Business.id' => $business_ids);
        $option['fields'] = array('Business.id');
        $datas = $this->Business->find('all', $option);
        $categories_str = '';
        foreach ($datas as $dat) {
            $categories_arr = array();
            foreach ($dat['Category'] as $category) {
                $categories_arr[] = $category['name'];
            }
            $final_arr[$dat['Business']['id']] = implode(', ', $categories_arr);
        }
        if (!empty($final_arr)) {
            foreach ($data as $key => $value) {
                if (!empty($value['Business']['id'])) {
                    $data[$key]['Business']['categories'] = $final_arr[$value['Business']['id']];
                }
            }
        }
        $this->set('requester_data', $data);
    }

    public function admin_contact_number_requests($user_id, $business_id) {
        $this->loadModel('ContactNumberRequest');
        $options['joins'] = array(
            array('table' => 'users', 'alias' => 'User', 'type' => 'LEFT', 'conditions' => array('User.id=ContactNumberRequest.user_id')),
            array('table' => 'businesses', 'alias' => 'Business', 'type' => 'LEFT', 'conditions' => array('Business.id=ContactNumberRequest.business_id')),
            array('table' => 'cities', 'alias' => 'City', 'type' => 'LEFT', 'conditions' => array('Business.city_id=City.id')),
            array('table' => 'localities', 'alias' => 'Locality', 'type' => 'LEFT', 'conditions' => array('Business.locality_id=Locality.id'))
        );
        $options['fields'] = array('ContactNumberRequest.*', 'User.name', 'User.email', 'User.phone', 'Business.id', 'Business.name', 'Business.address', 'Business.landmark', 'Business.pincode', 'City.name', 'Locality.name');
        $options['order'] = array('ContactNumberRequest.id DESC');
        $options['conditions'] = array('ContactNumberRequest.business_id' => $business_id);
        $data = $this->ContactNumberRequest->find('all', $options);
        $this->set('requester_data', $data);
    }

    public function admin_contact_request_delete($id, $user_id, $business_id) {
        if ($id) {
            $this->loadModel('ContactNumberRequest');
            if ($this->ContactNumberRequest->delete($id)) {
                $options['conditions'] = array('ContactNumberRequest.user_id' => $user_id, 'ContactNumberRequest.business_id' => $business_id);
                $options['order'] = array('ContactNumberRequest.id' => 'DESC');
                $data = $this->ContactNumberRequest->find('all', $options);
                if (count($data) > 0) {
                    $path_arr = array('action' => 'contact_number_requests', 'admin' => 1, $data[0]['ContactNumberRequest']['user_id'], $data[0]['ContactNumberRequest']['business_id']);
                } else {
                    $path_arr = array('action' => 'contact_requests_info', 'admin' => 1, "");
                }
                $this->Flash->AdminSuccess(__('Contact Request deleted successfully.'));
            } else {
                $this->Flash->AdminError(__('Error. Contact Request not deleted. Please try again.'));
                $path_arr = array('action' => 'contact_requests_info', 'admin' => 1, "");
            }
        }
        $this->redirect($path_arr);
    }

    public function admin_group_request_delete($user_id, $business_id) {
        if ($user_id && $business_id) {
            $this->loadModel('ContactNumberRequest');
            $options['conditions'] = array('ContactNumberRequest.user_id' => $user_id, 'ContactNumberRequest.business_id' => $business_id);
            $data = $this->ContactNumberRequest->find('all', $options);
            foreach ($data as $key => $value) {
                $this->ContactNumberRequest->delete($value['ContactNumberRequest']['id']);
            }
            $this->Flash->AdminSuccess(__('Contact Request deleted successfully.'));
        }
        $this->redirect(array('action' => 'contact_requests_info', 'admin' => 1, ""));
    }

    public function save_requester_data() {
        $this->layout = 'ajax';
        if (!empty($this->request->data)) {
            $data = $this->request->data;
            $this->loadModel('ContactNumberRequest');
            $data_arr['ContactNumberRequest']['user_id'] = $data['user_data']['user_id'];
            $data_arr['ContactNumberRequest']['business_id'] = $data['user_data']['business_id'];
            if (!empty($data_arr['ContactNumberRequest']['business_id']) && !empty($data_arr['ContactNumberRequest']['user_id'])) {
                if ($this->ContactNumberRequest->save($data_arr)) {
                    $this->loadModel('Business');
                    $this->loadModel('User');
                    $business_datas = $this->Business->find('first', array('conditions' => array('Business.id' => $data['user_data']['business_id']), 'fields' => array('Business.*'),'recursive'=>-1));
                    $user_data = $this->User->findById($data_arr['ContactNumberRequest']['user_id']);
                    /* Sending notification emails to Business owner and admin */

                    /* load email config class and keep the conenection open untill all mails are sent */
                    $Email = new CakeEmail(Configure::read('EMAIL_DELIVERY_MODE'));
                    $Email->config(array('persistent' => true));

                    /* email to Business Ownwer */
                    if (trim($business_datas['Business']['email']) != '') {
                        $Email->from(array(Configure::read('COMPANY.FROM_EMAIL') => Configure::read('COMPANY.NAME')));
                        $Email->viewVars(array('for' => 'business_owner', 'contact_person_name' => $business_datas['Business']['contact_person'], 'user_name' => $user_data['User']['name'],
                            'user_email' => $user_data['User']['email'], 'user_phone' => $user_data['User']['phone']));
                        $Email->to($business_datas['Business']['email']);
                        $Email->subject("Contact Information request for " . $business_datas['Business']['name'] . ".");
                        $Email->template('contact_information_request');
                        $Email->send();
                    }

                    /* email to admin */
                    $Email->from(array(Configure::read('COMPANY.FROM_EMAIL') => Configure::read('COMPANY.NAME')));
                    $Email->viewVars(array('for' => 'admin', 'user_name' => $user_data['User']['name'],
                        'businessName' => $business_datas['Business']['name'], 'user_email' => $user_data['User']['email'], 'user_phone' => $user_data['User']['phone']));
                    $Email->to(Configure::read('COMPANY.ADMIN_EMAIL'));
                    $Email->subject("Contact Information request for " . $business_datas['Business']['name'] . " by user " . $user_data['User']['name'] . ".");
                    $Email->template('contact_information_request');
                    $Email->send();

                    /* Disconnect email connection */
                    if (Configure::read('EMAIL_DELIVERY_MODE') == 'smtp') {
                        $Email->disconnect();
                    }

                    /* Sending actual phone numbers to view side for displaying */
                    $business_numbers_arr = explode(',', $business_datas['Business']['phone']);
                    $data_Arr = array();
                    $view = new View($this);
                    $format = $view->loadHelper('Format');
                    foreach ($business_numbers_arr as $key => $value) {
                        array_push($data_Arr, $format->formatPhoneNumber($value));
                    }
                    $data_Arr['masked_email'] = $business_datas['Business']['email'];
                    print(json_encode($data_Arr));
                    exit;
                } else {
                    echo 'false';
                }
            } else {
                echo 'false';
            }
        }exit;
    }

}
