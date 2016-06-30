<?php
App::uses('AppController', 'Controller');
/**
 * Careers Controller
 *
 * @property Career $Career
 * @property PaginatorComponent $Paginator
 */
class CareersController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');
        public $helpers = array('Html','Form','Session');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Career->recursive = 0;
		$this->set('careers', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Career->exists($id)) {
			throw new NotFoundException(__('Invalid career'));
		}
		$options = array('conditions' => array('Career.' . $this->Career->primaryKey => $id));
		$this->set('career', $this->Career->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Career->create();
			if ($this->Career->save($this->request->data)) {
				$this->Flash->success(__('The career has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The career could not be saved. Please, try again.'));
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
		if (!$this->Career->exists($id)) {
			throw new NotFoundException(__('Invalid career'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Career->save($this->request->data)) {
				$this->Flash->success(__('The career has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The career could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Career.' . $this->Career->primaryKey => $id));
			$this->request->data = $this->Career->find('first', $options);
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
		$this->Career->id = $id;
		if (!$this->Career->exists()) {
			throw new NotFoundException(__('Invalid career'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Career->delete()) {
			$this->Flash->success(__('The career has been deleted.'));
		} else {
			$this->Flash->error(__('The career could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Career->recursive = 0;
		$this->set('careers', $this->Career->find('all'));
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->Career->exists($id)) {
			throw new NotFoundException(__('Invalid career'));
		}
		$options = array('conditions' => array('Career.' . $this->Career->primaryKey => $id));
		$this->set('career', $this->Career->find('first', $options));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Career->create();
			if ($this->Career->save($this->request->data)) {
				$this->Flash->AdminSuccess(__('The career has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->AdminError(__('The career could not be saved. Please, try again.'));
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
		if (!$this->Career->exists($id)) {
			throw new NotFoundException(__('Invalid career'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Career->save($this->request->data)) {
				$this->Flash->AdminSuccess(__('The career has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->AdminError(__('The career could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Career.' . $this->Career->primaryKey => $id));
			$this->request->data = $this->Career->find('first', $options);
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
		$this->Career->id = $id;
		if (!$this->Career->exists()) {
			throw new NotFoundException(__('Invalid career'));
		}
		if ($this->Career->delete()) {
			$this->Flash->AdminSuccess(__('The career has been deleted.'));
		} else {
			$this->Flash->AdminError(__('The career could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
