<?php

App::uses('AppController', 'Controller');

/**
 * Localities Controller
 *
 * @property Locality $Locality
 * @property PaginatorComponent $Paginator
 */
class LocalitiesController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator');

    function beforeFilter() {
        parent::beforeFilter();
        #$this->loadModel('City');
        #$options = array('fields' => array('id', 'name'));
        #$cities = $this->City->find('list', $options);
        $cities = $this->Format->cities('list');//, 'business'
        #pr($cities);exit;
        $this->set(compact('cities'));
    }

    /**
     * index method
     *
     * @return void
     */
    public function index() {
        $this->Locality->recursive = 0;
        $this->set('localities', $this->Paginator->paginate());
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        if (!$this->Locality->exists($id)) {
            throw new NotFoundException(__('Invalid locality'));
        }
        $options = array('conditions' => array('Locality.' . $this->Locality->primaryKey => $id));
        $this->set('locality', $this->Locality->find('first', $options));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        if ($this->request->is('post')) {
            $this->Locality->create();
            if ($this->Locality->save($this->request->data)) {
                $this->Flash->success(__('The locality has been saved.'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->error(__('The locality could not be saved. Please, try again.'));
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
        if (!$this->Locality->exists($id)) {
            throw new NotFoundException(__('Invalid locality'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if ($this->Locality->save($this->request->data)) {
                $this->Flash->success(__('The locality has been saved.'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->error(__('The locality could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Locality.' . $this->Locality->primaryKey => $id));
            $this->request->data = $this->Locality->find('first', $options);
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
        $this->Locality->id = $id;
        if (!$this->Locality->exists()) {
            throw new NotFoundException(__('Invalid locality'));
        }
        $this->request->allowMethod('post', 'delete');
        if ($this->Locality->delete()) {
            $this->Flash->success(__('The locality has been deleted.'));
        } else {
            $this->Flash->error(__('The locality could not be deleted. Please, try again.'));
        }
        return $this->redirect(array('action' => 'index'));
    }

    /**
     * admin_index method
     *
     * @return void
     */
    public function admin_index() {
        $this->Locality->recursive = 0;
        $this->set('localities', $this->Locality->find('all'));
    }

    /**
     * admin_view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_view($id = null) {
        if (!$this->Locality->exists($id)) {
            throw new NotFoundException(__('Invalid locality'));
        }
        $options = array('conditions' => array('Locality.' . $this->Locality->primaryKey => $id));
        $this->set('locality', $this->Locality->find('first', $options));
    }

    /**
     * admin_add method
     *
     * @return void
     */
    public function admin_add() {
        $this->layout = 'ajax';
        if ($this->request->is('post')) {
            $data = $this->request->data;
            $data['Locality']['name'] = trim($data['Locality']['name']);
            $option['conditions'] = array('LOWER(Locality.name)' => strtolower($data['Locality']['name']),
                'Locality.city_id' => $data['Locality']['city_id']);
            if (!$this->Locality->find('count', $option)) {
                $this->Locality->create();
                if ($this->Locality->save($data)) {
                    $this->Flash->AdminSuccess(__('The locality has been saved.'));
                    return $this->redirect(array('action' => 'index'));
                } else {
                    $this->Flash->AdminError(__('The locality could not be saved. Please, try again.'));
                }
            } else {
                $this->Flash->AdminError(__('Locality exists'));
            }
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
        $this->layout = 'ajax';
        if (!$this->Locality->exists($id)) {
            throw new NotFoundException(__('Invalid locality'));
        }
        if ($this->request->is(array('post', 'put'))) {
            $data = $this->request->data;
            $data['Locality']['name'] = trim($data['Locality']['name']);
            $option['conditions'] = array('LOWER(Locality.name)' => strtolower($data['Locality']['name']),
                'Locality.city_id' => $data['Locality']['city_id'],
                'Locality.id !=' => $data['Locality']['id']
            );
            #pr($data);exit;
            if (!$this->Locality->find('count', $option)) {

                if ($this->Locality->save($data)) {
                    $this->Flash->AdminSuccess(__('The locality has been saved.'));
                    return $this->redirect(array('action' => 'index'));
                } else {
                    $this->Flash->AdminError(__('The locality could not be saved. Please, try again.'));
                }
            } else {
                $this->Flash->AdminError(__('Locality exists'));
            }
        } else {
            $options = array('conditions' => array('Locality.' . $this->Locality->primaryKey => $id));
            $this->request->data = $this->Locality->find('first', $options);
            #pr($this->request->data);exit;
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
        $this->Locality->id = $id;
        if (!$this->Locality->exists()) {
            throw new NotFoundException(__('Invalid locality'));
        }
        if ($this->Locality->delete()) {
            $this->Flash->AdminSuccess(__('The locality has been deleted.'));
        } else {
            $this->Flash->AdminError(__('The locality could not be deleted. Please, try again.'));
        }
        return $this->redirect(array('action' => 'index', 'admin' => 1));
    }

    /**
     * Ajax unique locality name check
     * while validating add and edit locality 
     * form in admin section.
     * @return type boolean in JSON
     */
    function locality_unique_edit() {
        $localityname = h(trim(strtolower($this->request->data['name'])));
        $cityid = (isset($this->request->data['cityId']) && intval($this->request->data['cityId']) > 0) ? $this->request->data['cityId'] : "";

        $option['conditions'] = array('LOWER(Locality.name)' => $localityname, 'Locality.city_id' => $cityid);
        if (isset($this->request->data['id']) && !empty($this->request->data['id'])) {
            $option['conditions']['Locality.id !='] = $this->request->data['id'];
        }
        $count = $this->Locality->find('count', $option);
        echo $count ? 'false' : 'true';
        exit;
    }

}
