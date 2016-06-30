<?php

App::uses('AppController', 'Controller');

/**
 * StaticPages Controller
 *
 * @property StaticPage $StaticPage
 * @property PaginatorComponent $Paginator
 */
class StaticPagesController extends AppController {

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
        $this->StaticPage->recursive = 0;
        $this->set('staticPages', $this->Paginator->paginate());
    }

    /**
     * admin_view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_view($id = null) {
        if (!$this->StaticPage->exists($id)) {
            throw new NotFoundException(__('Invalid static page'));
        }
        $options = array('conditions' => array('StaticPage.' . $this->StaticPage->primaryKey => $id));
        $this->set('staticPage', $this->StaticPage->find('first', $options));
    }

    /**
     * admin_add method
     *
     * @return void
     */
    public function admin_add() {
        if ($this->request->is('post')) {
            $data = $this->request->data;
            $data['StaticPage']['title'] = trim($data['StaticPage']['title']);
            $data['StaticPage']['content'] = trim($data['StaticPage']['content']);
            $data['StaticPage']['code'] = isset($data['StaticPage']['code']) ? trim($data['StaticPage']['code']) : "";

            $tmp_url = Inflector::slug(strtolower($data['StaticPage']['title']), '-');
            $tmp_code = Inflector::slug(strtolower($data['StaticPage']['title']));
            $data['StaticPage']['url'] = isset($data['StaticPage']['url']) && !empty($data['StaticPage']['url']) ? trim($data['StaticPage']['url']) : $tmp_url;
            $data['StaticPage']['code'] = isset($data['StaticPage']['code']) && !empty($data['StaticPage']['code']) ? $data['StaticPage']['code'] : $tmp_code;

            $conditions = array('StaticPage.code' => $data['StaticPage']['code']);
            if (!$this->StaticPage->hasAny($conditions)) {
                $this->generate_view($data);
                $this->StaticPage->create();
                unset($data['StaticPage']['content']);
                #pr($data);exit;
                if ($this->StaticPage->save($data)) {
                    $this->Flash->AdminSuccess(__('The static page has been saved.'));
                    return $this->redirect(array('action' => 'index'));
                } else {
                    $this->Flash->AdminError(__('The static page could not be saved. Please, try again.'));
                }
            } else {
                $this->Flash->AdminError(__('The static page already exist. Please, try again.'));
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
        if (!$this->StaticPage->exists($id)) {
            throw new NotFoundException(__('Invalid static page'));
        }
        if ($this->request->is(array('post', 'put'))) {
            $data = $this->request->data;
            $data['StaticPage']['title'] = trim($data['StaticPage']['title']);
            $data['StaticPage']['content'] = trim($data['StaticPage']['content']);
            $data['StaticPage']['code'] = isset($data['StaticPage']['code']) ? trim($data['StaticPage']['code']) : "";

            $tmp_code = Inflector::slug(strtolower($data['StaticPage']['title']));
            $data['StaticPage']['code'] = isset($data['StaticPage']['code']) && !empty($data['StaticPage']['code']) ? $data['StaticPage']['code'] : $tmp_code;
            $conditions = array('StaticPage.id !=' => $id, 'StaticPage.code' => $data['StaticPage']['code']);
            #pr($this->request->data);exit;
            #pr($data);exit;
            if (!$this->StaticPage->hasAny($conditions)) {
                $this->generate_view($data);
                unset($data['StaticPage']['content']);
                unset($data['StaticPage']['code']);
                unset($data['StaticPage']['url']);
                #pr($data);exit;
                if ($this->StaticPage->save($data)) {
                    $this->Flash->AdminSuccess(__('The static page has been saved.'));
                    return $this->redirect(array('action' => 'index'));
                } else {
                    $this->Flash->AdminError(__('The static page could not be saved. Please, try again.'));
                }
            } else {
                $this->Flash->AdminError(__('The static page already exist. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('StaticPage.' . $this->StaticPage->primaryKey => $id));
            $data = $this->StaticPage->find('first', $options);
            $code = $data['StaticPage']['code'];
            $path = "../View/Elements/StaticPage/" . $code . ".ctp";

            $file = new File($path, true);
            $file->open('r', true);
            $data['StaticPage']['content'] = $file->read();
            $this->request->data = $data;
        }
    }

    function generate_view($data) {
        $content = trim($data['StaticPage']['content']);
        $code = $data['StaticPage']['code'];
        $path = "../View/Elements/StaticPage/" . $code . ".ctp";

        $file = new File($path, true);
        $file->open('w', true);
        $file->write($content, 'w', true);
        return true;
    }

    /**
     * admin_delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_delete($id = null) {
        $this->StaticPage->id = $id;
        if (!$this->StaticPage->exists()) {
            throw new NotFoundException(__('Invalid static page'));
        }
        $this->request->allowMethod('post', 'delete');
        if ($this->StaticPage->delete()) {
            $this->Flash->success(__('The static page has been deleted.'));
        } else {
            $this->Flash->error(__('The static page could not be deleted. Please, try again.'));
        }
        return $this->redirect(array('action' => 'index'));
    }

}
