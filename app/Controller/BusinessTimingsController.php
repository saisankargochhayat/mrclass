<?php

App::uses('AppController', 'Controller');

/**
 * BusinessTimings Controller
 *
 * @property BusinessTiming $BusinessTiming
 * @property PaginatorComponent $Paginator
 */
class BusinessTimingsController extends AppController {

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
        $this->BusinessTiming->recursive = 0;
        $this->set('businessTimings', $this->Paginator->paginate());
    }

    /**
     * index method
     *
     * @return void
     */
    public function index() {
        $this->BusinessTiming->recursive = 0;
        $this->set('businessTimings', $this->Paginator->paginate());
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        if (!$this->BusinessTiming->exists($id)) {
            throw new NotFoundException(__('Invalid business timing'));
        }
        $options = array('conditions' => array('BusinessTiming.' . $this->BusinessTiming->primaryKey => $id));
        $this->set('businessTiming', $this->BusinessTiming->find('first', $options));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        $this->loadModel('Business');
        #$BusinessId = $this->params['pass'][0];
        $BusinessId = isset($this->params['pass'][0]) ? $this->params['pass'][0] : "";
        $user_id = $this->Session->read('Auth.User.id');
        if (!$this->Business->hasAny(array('Business.id' => $BusinessId, 'Business.user_id' => $user_id))) {
            throw new NotFoundException(__('Invalid business'));
        }
        if ($this->request->is('post')) {
            $data = $this->request->data;
            #pr($data);exit;
            $timings = array();
            foreach ($data['BusinessTiming'] as $key => $value) {
                $timings[] = array('business_id' => $value['business_id'],
                    'day' => $value['day'],
                    //'start_time' => $this->Format->format_12hr_to_24hr($value['start_time_temp']),
                    //'close_time' => $this->Format->format_12hr_to_24hr($value['close_time_temp']),
                    'start_time' => $value['start_time'],
                    'close_time' => $value['close_time'],
                    'id' => $value['id'],
                    'holiday' => $value['holiday']
                );
            }
            #pr($timings);exit;
            $this->BusinessTiming->create();
            if ($this->BusinessTiming->saveAll($timings)) {
                $this->Flash->success(__('The business timing has been saved.'));
                $this->redirect(array('action' => 'add', $BusinessId, "btimings"));
            } else {
                $this->Flash->error(__('The business timing could not be saved. Please, try again.'));
            }
        }
        $this->BusinessTiming->recursive = -1;
        $businesses = $this->BusinessTiming->find('all', array('conditions' => array('BusinessTiming.business_id' => $BusinessId)));
        $this->set(compact('businesses', 'BusinessId'));

        $this->loadModel('Business');
        $option = array('conditions' => array('Business.id' => $BusinessId), 'fields' => array('Business.name'), 'recursive' => false);
        $business = $this->Business->find('first', $option);
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        if (!$this->BusinessTiming->exists($id)) {
            throw new NotFoundException(__('Invalid business timing'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if ($this->BusinessTiming->save($this->request->data)) {
                $this->Flash->success(__('The business timing has been saved.'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->error(__('The business timing could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('BusinessTiming.' . $this->BusinessTiming->primaryKey => $id));
            $this->request->data = $this->BusinessTiming->find('first', $options);
        }
        $businesses = $this->BusinessTiming->Business->find('list');
        $this->set(compact('businesses'));
    }

    /**
     * delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function delete($id = null) {
        $this->BusinessTiming->id = $id;
        if (!$this->BusinessTiming->exists()) {
            throw new NotFoundException(__('Invalid business timing'));
        }
        $this->request->allowMethod('post', 'delete');
        if ($this->BusinessTiming->delete()) {
            $this->Flash->success(__('The business timing has been deleted.'));
        } else {
            $this->Flash->error(__('The business timing could not be deleted. Please, try again.'));
        }
        return $this->redirect(array('action' => 'index'));
    }

    /**
     * admin_view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_view($id = null) {
        if (!$this->BusinessTiming->exists($id)) {
            throw new NotFoundException(__('Invalid business timing'));
        }
        $options = array('conditions' => array('BusinessTiming.' . $this->BusinessTiming->primaryKey => $id));
        $this->set('businessTiming', $this->BusinessTiming->find('first', $options));
    }

    /**
     * admin_add method
     *
     * @return void
     */
    public function admin_add() {
        $business_id = $this->params['pass'][0];
        if ($this->request->is('post')) {
            $data = $this->request->data;
            #pr($data);exit;
            $timings = array();
            foreach ($data['BusinessTiming'] as $key => $value) {
                $timings[] = array('business_id' => $value['business_id'],
                    'day' => $value['day'],
                    //'start_time' => $this->Format->format_12hr_to_24hr($value['start_time_temp']),
                    //'close_time' => $this->Format->format_12hr_to_24hr($value['close_time_temp']),
                    'start_time' => $value['start_time'],
                    'close_time' => $value['close_time'],
                    'id' => $value['id'],
                    'holiday' => $value['holiday']
                );
            }
            $this->BusinessTiming->create();
            if ($this->BusinessTiming->saveAll($timings)) {
                $this->Flash->AdminSuccess(__('The business timing has been saved.'));
                return $this->redirect(array('action' => 'add', 'admin' => 1, $business_id, "btimings"));
            } else {
                $this->Flash->AdminError(__('The business timing could not be saved. Please, try again.'));
            }
        }
        $this->BusinessTiming->recursive = -1;
        $businesses = $this->BusinessTiming->find('all', array('conditions' => array('BusinessTiming.business_id' => $business_id)));
        $this->set(compact('businesses'));

        $this->loadModel('Business');
        $option = array('conditions' => array('Business.id' => $business_id), 'fields' => array('Business.name'), 'recursive' => false);
        $business = $this->Business->find('first', $option);
        $this->set('business', $business['Business']['name']);
    }

    /**
     * admin_delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_delete($id = null) {
        $this->BusinessTiming->id = $id;
        if (!$this->BusinessTiming->exists()) {
            throw new NotFoundException(__('Invalid business timing'));
        }
        $this->request->allowMethod('post', 'delete');
        if ($this->BusinessTiming->delete()) {
            $this->Flash->success(__('The business timing has been deleted.'));
        } else {
            $this->Flash->error(__('The business timing could not be deleted. Please, try again.'));
        }
        return $this->redirect(array('action' => 'index'));
    }

}
