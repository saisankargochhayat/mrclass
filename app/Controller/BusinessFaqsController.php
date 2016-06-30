<?php

App::uses('AppController', 'Controller');
App::uses('SSP', 'Utility');

/**
 * BusinessFaqs Controller
 *
 * @property BusinessFaq $BusinessFaq
 * @property PaginatorComponent $Paginator
 * @property FlashComponent $Flash
 */
class BusinessFaqsController extends AppController {

    /**
     * index method
     *
     * @return void
     */
    public function index() {
        $this->loadModel('Business');
        $business_id = (isset($this->params['pass'][0])) ? $this->params['pass'][0] : "";
        $this->set('BusinessId', $business_id);
        if ($this->Business->exists($business_id)) {
            $this->set('businessFaqs', $this->BusinessFaq->find('all', array('conditions' => array('BusinessFaq.business_id' => $business_id))));

            $option = array('conditions' => array('Business.id' => $business_id), 'fields' => array('Business.name', 'Business.user_id'), 'recursive' => false);
            $business = $this->Business->find('first', $option);
            $this->set('business', $business['Business']['name']);
            $this->set('subscription', SSP::get_subscription($business['Business']['user_id']));
        } else {
            $this->Flash->AdminError(__('The business could not be found. Please, try again.'));
            $this->redirect(array("controller" => "Businesses", "action" => "index", "admin" => 1));
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
        if (!$this->BusinessFaq->exists($id)) {
            throw new NotFoundException(__('Invalid business faq'));
        }
        $options = array('conditions' => array('BusinessFaq.' . $this->BusinessFaq->primaryKey => $id));
        $this->set('businessFaq', $this->BusinessFaq->find('first', $options));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        $BusinessId = (isset($this->params['pass'][0])) ? $this->params['pass'][0] : "";
        $this->set('BusinessId', $BusinessId);
        $this->loadModel('Business');
        if ($this->Business->exists($BusinessId)) {
            if ($this->request->is('post')) {
                $all_faqs = $this->BusinessFaq->find('all', array('conditions' => array('BusinessFaq.business_id' => $BusinessId), 'order' => array('BusinessFaq.created DESC'), 'recursive' => -1));
                $this->request->data['BusinessFaq']['business_id'] = $BusinessId;
                $this->request->data['BusinessFaq']['sequence'] = (!empty($all_faqs)) ? intval($all_faqs[0]['BusinessFaq']['sequence']) + 1 : 1;
                $this->BusinessFaq->create();
                if ($this->BusinessFaq->save($this->request->data)) {
                    $this->Flash->Success(__('The business faq has been saved.'));
                    $this->redirect(array('action' => 'index', $BusinessId, "bfaqs"));
                }
            }
        } else {
            $this->Flash->Error(__('The business could not be found. Please, try again.'));
            $this->redirect(array("controller" => "Businesses", "action" => "index"));
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
        $BusinessId = (isset($this->params['pass'][1])) ? $this->params['pass'][1] : "";
        $this->set('BusinessId', $BusinessId);
        $this->loadModel('Business');
        if ($this->Business->exists($BusinessId)) {
            if (!$this->BusinessFaq->exists($id)) {
                throw new NotFoundException(__('Invalid business faq'));
            }
            if ($this->request->is(array('post', 'put'))) {
                if ($this->BusinessFaq->saveAll($this->request->data)) {
                    $this->Flash->Success(__('The business faq has been saved.'));
                    $this->redirect(array('action' => 'index', $BusinessId, "bfaqs"));
                }
            } else {
                $options = array('conditions' => array('BusinessFaq.' . $this->BusinessFaq->primaryKey => $id));
                $this->request->data = $this->BusinessFaq->find('first', $options);
            }
        } else {
            $this->Flash->Error(__('The business could not be found. Please, try again.'));
            $this->redirect(array("controller" => "Businesses", "action" => "index"));
        }
    }

    /**
     * delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function delete($id = null) {
        $this->BusinessFaq->id = $id;
        $BusinessId = (isset($this->params['pass'][1])) ? $this->params['pass'][1] : "";
        if (!$this->BusinessFaq->exists()) {
            throw new NotFoundException(__('Invalid business faq'));
        }
        if ($this->BusinessFaq->delete()) {
            $this->Flash->Success(__('The business faq has been deleted.'));
        } else {
            $this->Flash->Error(__('The business faq could not be deleted. Please, try again.'));
        }
        $this->redirect(array('action' => 'index', $BusinessId, "bfaqs"));
    }

    /**
     * admin_index method
     *
     * @return void
     */
    public function admin_index() {
        $this->loadModel('Business');
        $business_id = (isset($this->params['pass'][0])) ? $this->params['pass'][0] : "";
        if ($this->Business->exists($business_id)) {
            $this->set('business_id', $business_id);
            $this->set('businessFaqs', $this->BusinessFaq->find('all', array('conditions' => array('BusinessFaq.business_id' => $business_id))));

            $option = array('conditions' => array('Business.id' => $business_id), 'fields' => array('Business.name', 'Business.user_id'), 'recursive' => false);
            $business = $this->Business->find('first', $option);
            $this->set('business', $business['Business']['name']);
            $this->set('subscription', SSP::get_subscription($business['Business']['user_id']));
        } else {
            $this->Flash->AdminError(__('The business could not be found. Please, try again.'));
            $this->redirect(array("controller" => "Businesses", "action" => "index", "admin" => 1));
        }
    }

    /**
     * admin_add method
     *
     * @return void
     */
    public function admin_add() {
        $BusinessId = (isset($this->params['pass'][0])) ? $this->params['pass'][0] : "";
        $this->set('BusinessId', $BusinessId);
        $this->loadModel('Business');
        if ($this->Business->exists($BusinessId)) {
            if ($this->request->is('post')) {
                $all_faqs = $this->BusinessFaq->find('all', array('conditions' => array('BusinessFaq.business_id' => $BusinessId), 'order' => array('BusinessFaq.created DESC'), 'recursive' => -1));
                $this->request->data['BusinessFaq']['business_id'] = $BusinessId;
                $this->request->data['BusinessFaq']['sequence'] = (!empty($all_faqs)) ? intval($all_faqs[0]['BusinessFaq']['sequence']) + 1 : 1;
                $this->BusinessFaq->create();
                if ($this->BusinessFaq->save($this->request->data)) {
                    $this->Flash->AdminSuccess(__('The business faq has been saved.'));
                    $this->redirect(array("controller" => "BusinessFaqs", "action" => "index", "admin" => 1, $BusinessId, "bfaqs"));
                }
            }
        } else {
            $this->Flash->AdminError(__('The business could not be found. Please, try again.'));
            $this->redirect(array("controller" => "Businesses", "action" => "index", "admin" => 1));
        }
    }

    /**
     * admin_edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_edit($id = null) {
        $BusinessId = (isset($this->params['pass'][1])) ? $this->params['pass'][1] : "";
        $this->set('BusinessId', $BusinessId);
        $this->loadModel('Business');
        if ($this->Business->exists($BusinessId)) {
            if (!$this->BusinessFaq->exists($id)) {
                throw new NotFoundException(__('Invalid business faq'));
            }
            if ($this->request->is(array('post', 'put'))) {
                if ($this->BusinessFaq->save($this->request->data)) {
                    $this->Flash->AdminSuccess(__('The business faq has been saved.'));
                    $this->redirect(array("controller" => "BusinessFaqs", "action" => "index", "admin" => 1, $BusinessId, "bfaqs"));
                }
            } else {
                $options = array('conditions' => array('BusinessFaq.' . $this->BusinessFaq->primaryKey => $id));
                $this->request->data = $this->BusinessFaq->find('first', $options);
            }
        } else {
            $this->Flash->AdminError(__('The business could not be found. Please, try again.'));
            $this->redirect(array("controller" => "Businesses", "action" => "index", "admin" => 1));
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
        $this->BusinessFaq->id = $id;
        $BusinessId = (isset($this->params['pass'][1])) ? $this->params['pass'][1] : "";
        if (!$this->BusinessFaq->exists()) {
            throw new NotFoundException(__('Invalid business faq'));
        }
        if ($this->BusinessFaq->delete()) {
            $this->Flash->AdminSuccess(__('The business faq has been deleted.'));
        } else {
            $this->Flash->AdminError(__('The business faq could not be deleted. Please, try again.'));
        }
        $this->redirect(array("controller" => "BusinessFaqs", "action" => "index", "admin" => 1, $BusinessId, "bfaqs"));
    }

}
