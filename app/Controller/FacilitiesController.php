<?php

App::uses('AppController', 'Controller');

/**
 * Categories Controller
 *
 * @property Category $Category
 * @property PaginatorComponent $Paginator
 */
class FacilitiesController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    var $name = 'Facilities';
    public $components = array('Paginator', 'Format');
    public $helpers = array('Html', 'Form', 'Session', 'Format');

    public function beforeFilter() {
        parent::beforeFilter();
    }

    public function admin_facility_manage() {
        $this->Facility->recursive = 0;
        $conditions = array('order' => array('Facility.name ASC'));
        $facilities = $this->Facility->find('all', $conditions);
        $this->set('facilities', $facilities);
    }

    public function admin_add_facility() {
       #pr($this->request->data);exit;
        #$this->layout = 'ajax';
        if ($this->request->data) {
            $this->request->data['Facility']['image'] = $this->request->data['user_icon_class_val'];
            if ($this->Facility->save($this->request->data)) {
                $this->Flash->AdminSuccess(__('Facility saved successfully.'));
            } else {
                $errors = $this->Facility->invalidFields();
                if (is_array($errors) && count($errors) > 0) {
                    $this->Flash->AdminError($errors['name']['0']);
                } else {
                    $this->Flash->AdminError(__("Facility couldn't be saved!"));
                }
            }
        }
        return $this->redirect(array('action' => 'facility_manage', 'admin' => 1));
    }

    public function admin_edit_facility($id = null) {
        $this->layout = 'ajax';
        $id = $this->data['id'];
        $this->Facility->recursive = 0;
        $options = array('conditions' => array('Facility.' . $this->Facility->primaryKey => $id));
        $facility_data = $this->Facility->find('first', $options);
        print(json_encode($facility_data));
        exit;
    }

    public function admin_edit_facility_form() {
        $data  = $this->request->data;
        $this->Facility->id = $data['facility_id'];
        $data['Facility']['image'] = $data['edit_user_icon_class_val'];
        $data['Facility']['id'] = $data['facility_id'];
        unset($data['facility_id']);
        unset($data['edit_user_icon_class_val']);
        #pr($this->request->data);exit;
        if($data['Facility']['id'] == 93){
            unset($data['Facility']['image']);
        }
        #pr($data);exit;
        
        if ($this->Facility->save($data)) {
            $this->Flash->AdminSuccess(__('Facility saved successfully.'));
        } else {
            $errors = $this->Facility->invalidFields();
            if (is_array($errors) && count($errors) > 0) {
                $this->Flash->AdminError($errors['name']['0']);
            } else {
                $this->Flash->AdminError(__("Facility couldn't be saved!"));
            }
        }
        return $this->redirect(array('action' => 'facility_manage', 'admin' => 1));
    }

    /**
     * admin_delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_facility_delete($id = null) {
        $this->Facility->id = $id;
        if (!$this->Facility->exists()) {
            throw new NotFoundException(__('Invalid Facility'));
        }
        if ($this->Facility->delete()) {
            $this->Flash->AdminSuccess(__('The facility has been deleted.'));
        } else {
            $this->Flash->AdminError(__('The facility could not be deleted. Please, try again.'));
        }
        return $this->redirect(array('action' => 'facility_manage', 'admin' => 1));
    }

    public function admin_get_facility_icons() {
        $this->layout = 'ajax';
        $this->loadModel('Icon');
        $this->Icon->recursive = 0;
        $options = array('fields' => array('Icon.id', 'Icon.name'));
        $facility_icons = $this->Icon->find('all', $options);
        print(json_encode($facility_icons));
        exit;
    }

}
