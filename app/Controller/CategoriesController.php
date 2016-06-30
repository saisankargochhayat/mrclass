<?php

App::uses('AppController', 'Controller');

/**
 * Categories Controller
 *
 * @property Category $Category
 * @property PaginatorComponent $Paginator
 */
class CategoriesController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator');

    function beforeFilter() {
        parent::beforeFilter();
        $this->loadModel('Category');
        $options = array('fields' => array('id', 'name'), 'conditions' => array('status' => '1', 'parent_id' => '0'));
        $options['order'] = array('Category.name' => 'ASC');
        $categories = $this->Category->find('list', $options);
        #pr($categories);exit;
        #$pcategories = array_merge(array("Parent Category"), $categories);
        $this->set('pcategories', $categories);
        #$this->set(compact('pcategories'));
    }

    /**
     * admin_index method
     *
     * @return void
     */
    public function admin_index() {
        $this->Category->recursive = 0;
        $conditions = array('order' => array('Parent.name ASC'));
        $category = $this->Category->find('all', $conditions);
        #pr($category);exit;
        $this->set('category', $category);
    }

    /**
     * admin_view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_view($id = null) {
        if (!$this->Category->exists($id)) {
            throw new NotFoundException(__('Invalid category'));
        }
        $options = array('conditions' => array('Category.' . $this->Category->primaryKey => $id));
        $this->set('category', $this->Category->find('first', $options));
    }

    /**
     * admin_add method
     *
     * @return void
     */
    public function admin_add() {
        $this->layout = 'ajax';
        if ($this->request->is('post')) {
            #pr($this->request->data);exit;
            $parent_id = (empty($this->request->data['Category']['parent_id'])) ? 0 : $this->request->data['Category']['parent_id'];
            $conditions = array(
                'Category.name' => h($this->request->data['Category']['name']),
                'Category.parent_id' => $parent_id,
            );
            if ($this->Category->hasAny($conditions)) {
                $this->Flash->error(__('The category could not be saved. Category with same name exist.'));
                $this->redirect(array('action' => 'index'));
            } else {
                $fileUploadTrue = $this->processUpload($this->request->data);
                $parent_id = (empty($fileUploadTrue['Category']['parent_id'])) ? 0 : $fileUploadTrue['Category']['parent_id'];
                if (is_array($fileUploadTrue)) {
                    $fileUploadTrue['Category']['parent_id'] = $parent_id;
                    $fileUploadTrue['Category']['category_image'] = (is_array($fileUploadTrue['Category']['category_image'])) ? 'N/A' : $fileUploadTrue['Category']['category_image'];
                    $this->Category->create();
                    if ($this->Category->save($fileUploadTrue)) {
                        $this->Flash->adminSuccess(__('Category has been saved.'), array(
                            'params' => array(
                                'name' => $fileUploadTrue['Category']['name']
                            )
                        ));
                        $this->redirect(array('action' => 'index'));
                    } else {
                        $this->Flash->error(__('The category could not be saved. Please, try again.'));
                        $this->redirect(array('action' => 'index'));
                    }
                } else {
                    $this->Flash->error(__('The Image can\'t be uploaded. Please, try again.'));
                    $this->redirect(array('action' => 'index'));
                }
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
        if (!$this->Category->exists($id)) {
            throw new NotFoundException(__('Invalid category'));
        }
        if ($this->request->is(array('post', 'put'))) {
            $parent_id = (empty($this->request->data['Category']['parent_id'])) ? 0 : $this->request->data['Category']['parent_id'];
            $conditions = array(
                'Category.id !=' => h($this->request->data['Category']['id']),
                'Category.name' => h($this->request->data['Category']['name']),
                'Category.parent_id' => $parent_id,
            );

            if ($this->Category->hasAny($conditions)) {
                $this->Flash->AdminError(__('The category could not be saved. Category with same name exist.'));
            } else {

                $fileUploadTrue = $this->processUpload($this->request->data);

                $parent_id = (empty($fileUploadTrue['Category']['parent_id'])) ? 0 : $fileUploadTrue['Category']['parent_id'];
                if (is_array($fileUploadTrue)) {
                    $fileUploadTrue['Category']['parent_id'] = $parent_id;
                    if(is_array($fileUploadTrue['Category']['category_image'])){
                        unset($fileUploadTrue['Category']['category_image']);
                    }
                    
                    $this->Category->create();
                    /*
                     *                  */
                    if ($this->Category->save($fileUploadTrue)) {
                        $this->Flash->AdminSuccess(__('The category has been saved.'));
                    } else {
                        $this->Flash->AdminError(__('The category could not be saved. Please, try again.'));
                    }
                    return $this->redirect(array('action' => 'index'));
                }
            }
        } else {
            $this->Category->recursive = 0;
            $options = array('conditions' => array('Category.' . $this->Category->primaryKey => $id));
            $this->request->data = $this->Category->find('first', $options);
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
        $this->Category->id = $id;
        if (!$this->Category->exists()) {
            throw new NotFoundException(__('Invalid category'));
        }
        if ($this->Category->delete()) {
            $this->Flash->AdminSuccess(__('The category has been deleted.'));
        } else {
            $this->Flash->AdminError(__('The category could not be deleted. Please, try again.'));
        }
        return $this->redirect(array('action' => 'index'));
    }

    /**
     * Process the Upload
     * @param array $check
     * @return boolean
     */
    public function processUpload($check = array()) {
        if (!empty($check['Category']['category_image']['tmp_name'])) {
            if (!is_uploaded_file($check['Category']['category_image']['tmp_name'])) {
                return FALSE;
            }
            $filename = CATEGORY_IMG_DIR . DS . Inflector::slug(pathinfo($check['Category']['category_image']['name'], PATHINFO_FILENAME)) . '.' . pathinfo($check['Category']['category_image']['name'], PATHINFO_EXTENSION);
            if (!is_dir(CATEGORY_IMG_DIR)) {
                mkdir(CATEGORY_IMG_DIR, 0777, true);
            }
            if (!move_uploaded_file($check['Category']['category_image']['tmp_name'], $filename)) {
                return FALSE;
            } else {
                $check['Category']['category_image'] = str_replace(DS, "", str_replace(CATEGORY_IMG_DIR, "", $filename));
            }
        }
        return $check;
    }

    /**
     * index method
     *
     * @return void
     */
    public function index() {
        $this->Category->recursive = 0;
        $this->set('categories', $this->Paginator->paginate());
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        if (!$this->Category->exists($id)) {
            throw new NotFoundException(__('Invalid category'));
        }
        $options = array('conditions' => array('Category.' . $this->Category->primaryKey => $id));
        $this->set('category', $this->Category->find('first', $options));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        if ($this->request->is('post')) {
            $this->Category->create();
            if ($this->Category->save($this->request->data)) {
                $this->Flash->AdminSuccess(__('The category has been saved.'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->AdminError(__('The category could not be saved. Please, try again.'));
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
        if (!$this->Category->exists($id)) {
            throw new NotFoundException(__('Invalid category'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if ($this->Category->save($this->request->data)) {
                $this->Flash->AdminSuccess(__('The category has been saved.'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->AdminError(__('The category could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Category.' . $this->Category->primaryKey => $id));
            $this->request->data = $this->Category->find('first', $options);
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
        $this->Category->id = $id;
        if (!$this->Category->exists()) {
            throw new NotFoundException(__('Invalid category'));
        }
        $this->request->allowMethod('post', 'delete');
        if ($this->Category->delete()) {
            $this->Flash->AdminSuccess(__('The category has been deleted.'));
        } else {
            $this->Flash->AdminError(__('The category could not be deleted. Please, try again.'));
        }
        return $this->redirect(array('action' => 'index'));
    }

}
