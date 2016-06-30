<?php
App::uses('AppController', 'Controller');
/**
 * Packages Controller
 *
 * @property Package $Package
 * @property PaginatorComponent $Paginator
 * @property FlashComponent $Flash
 * @property SecurityComponent $Security
 */
class PackagesController extends AppController {

/**
 * Helpers
 *
 * @var array
 */
	public $helpers = array('Text');

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Package->recursive = 0;
		$this->set('packages', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Package->exists($id)) {
			throw new NotFoundException(__('Invalid package'));
		}
		$options = array('conditions' => array('Package.' . $this->Package->primaryKey => $id));
		$this->set('package', $this->Package->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Package->create();
			if ($this->Package->save($this->request->data)) {
				return $this->flash(__('The package has been saved.'), array('action' => 'index'));
			}
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
		$this->Package->id = $id;
		if (!$this->Package->exists()) {
			throw new NotFoundException(__('Invalid package'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Package->delete()) {
			return $this->flash(__('The package has been deleted.'), array('action' => 'index'));
		} else {
			return $this->flash(__('The package could not be deleted. Please, try again.'), array('action' => 'index'));
		}
	}

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
	}
    
    public function packages_ajax(){
        if ($this->request->is('ajax')) {
            $table = 'packages';
            $primaryKey = 'id';
            $columns = array(
                array('db' => 'id', 'dt' => 0, 'field' => 'id'),
                array('db' => 'name', 'dt' => 1, 'field' => 'name'),
                array('db' => 'price', 'dt' => 2, 'field' => 'price'),
                array('db' => 'subscription', 'dt' => 3, 'field' => 'subscription'),
                array('db' => 'listing_period', 'dt' => 4, 'field' => 'listing_period'),
                array('db' => 'payment_method', 'dt' => 5, 'field' => 'payment_method'),
                array('db' => 'DATE_FORMAT(`created`,"%b %d,%Y")', 'dt' => 6, 'field' => 'created'),
                array('db' => 'status', 'dt' => 7, 'field' => 'status')
            );
            $joinQuery = "";
            $extraWhere = "`status` = '1'";
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
		if (!$this->Package->exists($id)) {
			throw new NotFoundException(__('Invalid package'));
		}
		$options = array('conditions' => array('Package.' . $this->Package->primaryKey => $id));
		$this->set('package', $this->Package->find('first', $options));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
            $data = $this->request->data;
            $data['Package']['name'] = trim($data['Package']['name']);
            $data['Package']['status'] = '1';
            $option['conditions'] = array('LOWER(Package.name)' => strtolower($data['Package']['name']));
            if (!$this->Package->find('count', $option)) {
                $this->Package->create();
                if ($this->Package->save($data)) {
                    $this->Flash->AdminSuccess(__('The Package has been saved.'));
                    return $this->redirect(array('action' => 'index'));
                } else {
                    $this->Flash->AdminError(__('The Package could not be saved. Please, try again.'));
                }
            } else {
                $this->Flash->AdminError(__('Package exists'));
            }
            return $this->redirect(array('action' => 'add'));
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
		if (!$this->Package->exists($id)) {
			throw new NotFoundException(__('Invalid package'));
		}
		if ($this->request->is(array('post', 'put'))) {
			$data = $this->request->data;
            if ($this->Package->save($data)) {
                $this->Flash->AdminSuccess(__('The package has been saved.'));
            } else {
                $this->Flash->AdminError(__('The package could not be saved. Please, try again.'));
            }
            $this->redirect(array('action' => 'edit',$this->Package->id));
		} else {
			$options = array('conditions' => array('Package.' . $this->Package->primaryKey => $id));
			$this->request->data = $this->Package->find('first', $options);
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
        if($this->request->is('ajax')){
            $this->Package->id = $this->request->data['id'];
            if (!$this->Package->exists()) {
                throw new NotFoundException(__('Invalid package'));
            }
            if ($this->Package->delete()) {
                echo 1;
            } else {
                echo 0;
            }
            exit;
        }
	}
}