<?php

App::uses('AppController', 'Controller');

/**
 * Cities Controller
 *
 * @property City $City
 * @property PaginatorComponent $Paginator
 */
class CitiesController extends AppController {

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
        /* $this->City->recursive = 0;
          $options = array();
          $options['fields'] = array('City.*', 'State.name', 'Dist.name');
          $options['order'] = array('City.name' => 'ASC');
          $cities = $this->City->find('all', $options);
          #pr($cities);exit;
          $this->set('cities', $cities); */
    }

    public function admin_ajax_index() {
        $this->City->recursive = 0;
        $options = array();
        $options['fields'] = array('City.*', 'State.name', 'Dist.name');
        $options['order'] = array('City.name' => 'ASC');
        #$options['limit'] = 10;
        #$options['page'] = 1;
        $cities = $this->City->find('all', $options);
        #pr($cities);exit;
        foreach ($cities as $key => $val) {
            $rep_cities[] = array(
                $val['City']['id'],
                $val['City']['name'],
                $val['State']['name'],
                $val['City']['status'],
                $val['City']['business_status'],
                '',
            );
        }
        echo json_encode(array("data" => $rep_cities));
        exit;
        $this->set('cities', $cities);
    }

    /**
     * city_listings method
     * Ajax server side processing of
     * city listings based on SSP class and datatables.
     * @return JSON
     * @author CHINMAYA
     */
    public function city_listings() {
        if ($this->request->is('ajax')) {
            $table = 'cities';
            $primaryKey = 'id';
            $columns = array(
                array('db' => '`c`.`id`', 'dt' => 0, 'field' => 'id'),
                array('db' => '`c`.`name`', 'dt' => 1, 'field' => 'city_name', 'as' => 'city_name'),
                array('db' => '`s`.`name`', 'dt' => 2, 'field' => 'state_name', 'as' => 'state_name'),
                array('db' => '`c`.`status`', 'dt' => 3, 'field' => 'status'),
                array('db' => '`c`.`business_status`', 'dt' => 4, 'field' => 'business_status')
            );
            $joinQuery = "FROM `cities` AS `c` JOIN `states` AS `s` ON (`s`.`id` = `c`.`state`)";
            #$extraWhere = "`u`.`salary` >= 90000";
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
        if (!$this->City->exists($id)) {
            throw new NotFoundException(__('Invalid city'));
        }
        $options = array('conditions' => array('City.' . $this->City->primaryKey => $id));
        $this->set('city', $this->City->find('first', $options));
    }

    /**
     * admin_add method
     *
     * @return void
     */
    public function admin_add() {
        $this->layout = 'ajax';
        if ($this->request->is('post')) {
            $this->City->create();
            if ($this->City->save($this->request->data)) {
                $this->Flash->AdminSuccess(__('The city has been saved.'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->AdminError(__('The city could not be saved. Please, try again.'));
            }
        }
        $states = $this->Format->states('list');
        $this->set('states', $states);
    }

    /**
     * admin_edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_edit($id = null) {
        CakeLog::write('debug', 'A special message for activity logging');
        $this->layout = 'ajax';
        if (!$this->City->exists($id)) {
            throw new NotFoundException(__('Invalid city'));
        }
        if ($this->data) {
            if ($this->City->save($this->request->data)) {
                $this->Flash->AdminSuccess(__('City details updated successfully.'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->AdminError(__('City details not updated. Please, try again.'));
            }
        } else {
            $this->City->recursive = -1;
            $options = array('conditions' => array('City.' . $this->City->primaryKey => $id));
            $city = $this->City->find('first', $options);
            #pr($city);exit;
            $this->set('city', $city);
        }
        $states = $this->Format->states('list');
        $this->set('states', $states);
    }

    /**
     * admin_delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_delete($id = null) {
        $this->City->id = $id;
        if (!$this->City->exists()) {
            throw new NotFoundException(__('Invalid city'));
        }
        if ($this->City->delete()) {
            $this->Flash->AdminSuccess(__('The city has been deleted.'));
        } else {
            $this->Flash->AdminError(__('The city could not be deleted. Please, try again.'));
        }
        return $this->redirect(array('action' => 'index', 'admin' => 1));
    }

    /**
     * Ajax unique city name check
     * while validating add and edit city
     * form in admin section.
     * @return type boolean in JSON
     */
    function cityname_unique_edit() {
        $cityname = trim(strtolower($this->request->data['City']['name']));
        if (isset($this->request->data['id']) && !empty($this->request->data['id'])) {
            $option['conditions'] = array('LOWER(City.name)' => $cityname, "City.id !=" => $this->request->data['id']);
        } else {
            $option['conditions'] = array('LOWER(City.name)' => $cityname);
        }
        $count = $this->City->find('count', $option);
        echo ($count >= 1) ? 'false' : 'true';
        exit;
    }

    /**
     * index method
     *
     * @return void
     */
    public function index() {
        $this->City->recursive = 0;
        $this->set('cities', $this->Paginator->paginate());
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        if (!$this->City->exists($id)) {
            throw new NotFoundException(__('Invalid city'));
        }
        $options = array('conditions' => array('City.' . $this->City->primaryKey => $id));
        $this->set('city', $this->City->find('first', $options));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        if ($this->request->is('post')) {
            $this->City->create();
            if ($this->City->save($this->request->data)) {
                $this->Flash->success(__('The city has been saved.'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->error(__('The city could not be saved. Please, try again.'));
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
        if (!$this->City->exists($id)) {
            throw new NotFoundException(__('Invalid city'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if ($this->City->save($this->request->data)) {
                $this->Flash->success(__('The city has been saved.'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->error(__('The city could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('City.' . $this->City->primaryKey => $id));
            $this->request->data = $this->City->find('first', $options);
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
        $this->City->id = $id;
        if (!$this->City->exists()) {
            throw new NotFoundException(__('Invalid city'));
        }
        $this->request->allowMethod('post', 'delete');
        if ($this->City->delete()) {
            $this->Flash->success(__('The city has been deleted.'));
        } else {
            $this->Flash->error(__('The city could not be deleted. Please, try again.'));
        }
        return $this->redirect(array('action' => 'index'));
    }

}
