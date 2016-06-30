<?php

App::uses('AppController', 'Controller');

/**
 * Presses Controller
 *
 * @property Press $Press
 * @property PaginatorComponent $Paginator
 */
class PressesController extends AppController {

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
        $this->Press->recursive = 0;
        $this->set('presses', $this->Paginator->paginate());
    }

    /**
     * admin_view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_view($id = null) {
        if (!$this->Press->exists($id)) {
            throw new NotFoundException(__('Invalid press'));
        }
        $options = array('conditions' => array('Press.' . $this->Press->primaryKey => $id));
        $this->set('press', $this->Press->find('first', $options));
    }

    /**
     * admin_add method
     *
     * @return void
     */
    public function admin_add() {
        if ($this->request->is('post')) {
            $data = $this->request->data;
            foreach ($data['Press'] as $key => $value) {
                $data['Press'][$key] = is_array($value) ? $value : trim($value);
            }
            $data['Press']['published_date'] = date("Y-m-d H:i:s", strtotime($data['Press']['published_date']));
            $this->Press->create();
            if ($this->Press->save($data)) {
                $this->Flash->AdminSuccess(__('The press has been saved.'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->AdminError(__('The press could not be saved. Please, try again.'));
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
        if (!$this->Press->exists($id)) {
            throw new NotFoundException(__('Invalid press'));
        }
        if ($this->request->is(array('post', 'put'))) {
            $data = $this->request->data;
            foreach ($data['Press'] as $key => $value) {
                $data['Press'][$key] = is_array($value) ? $value : trim($value);
            }
            $data['Press']['published_date'] = date("Y-m-d H:i:s", strtotime($data['Press']['published_date']));

            if ($this->Press->save($data)) {
                $this->Flash->AdminSuccess(__('The press has been saved.'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->AdminError(__('The press could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Press.' . $this->Press->primaryKey => $id));
            $this->request->data = $this->Press->find('first', $options);
            $this->request->data['Press']['published_date'] = date("M d, Y", strtotime($this->request->data['Press']['published_date']));
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
        $this->Press->id = $id;
        if (!$this->Press->exists()) {
            throw new NotFoundException(__('Invalid press'));
        }
        $this->request->allowMethod('post', 'delete');
        if ($this->Press->delete()) {
            $this->Flash->success(__('The press has been deleted.'));
        } else {
            $this->Flash->error(__('The press could not be deleted. Please, try again.'));
        }
        return $this->redirect(array('action' => 'index'));
    }

    function delete_preview() {
        $id = $this->data['id'];
        $this->Press->id = $id;

        $success = 0;
        if (!$this->Press->exists()) {
            throw new NotFoundException(__('Invalid press'));
        }
        $this->request->allowMethod('post', 'delete');
        if (intval($id) > 0) {
            $press = $this->Press->find('first', array('conditions' => array('Press.id' => $id), 'fields' => array('Press.id', 'Press.preview')));

            $bid = $press['Press']['id'];
            $filename = PRESS_IMAGE_DIR . "preview" . DS . $bid . DS . $press['Press']['preview'];
            if (file_exists($filename)) {

                $this->Format->deleteDir(PRESS_IMAGE_DIR . "preview" . DS . $bid . DS);
                if ($this->Press->save(array('preview' => '', 'id' => $id))) {
                    $msg = __('The press preview has been deleted.');
                    $success = 1;
                } else {
                    $msg = __('The press preview could not be deleted. Please, try again.');
                }
            }
        } else {
            $msg = __('The press preview could not be deleted. Please, try again.');
        }
        echo json_encode(array('success' => $success, 'message' => $msg));
        exit;
    }

    function admin_change_status($id = null) {
        $this->Press->id = $id;
        if ($this->Press->exists()) {
            $statusData = $this->Press->find('first', array('conditions' => array('Press.id' => $id)));
            $rating_status_val = (intval($statusData['Press']['status']) == 1) ? 0 : 1;
            $rating_status_msg = (intval($statusData['Press']['status']) == 1) ? 'Press disabled' : 'Press enabled';
            $redirect_array = array('action' => 'index', 'admin' => 1);
            if ($this->Press->saveField('status', $rating_status_val)) {
                $this->Flash->AdminSuccess(__($rating_status_msg." successfully"));
            } else {
                $this->Flash->AdminError(__('Operation Failed.'));
            }
        } else {
            $this->Flash->AdminError(__('Invalid Press'));
        }
        $this->redirect($redirect_array);
    }

}
