<?php

App::uses('AppController', 'Controller');

/**
 * AdvertisementPages Controller
 *
 * @property AdvertisementPage $AdvertisementPage
 * @property PaginatorComponent $Paginator
 */
class AdvertisementPagesController extends AppController {

    /**
     * admin_index method
     *
     * @return void
     */
    public function admin_index() {
        if ($this->request->is('ajax')) {
            $table = 'advertisement_pages';
            $primaryKey = 'id';
            $columns = array(
                array('db' => 'id', 'dt' => 0, 'field' => 'id'),
                array('db' => 'name', 'dt' => 1, 'field' => 'page_name', 'as' => 'page_name'),
                array('db' => 'description', 'dt' => 2, 'field' => 'description', 'as' => 'description'),
                array('db' => 'created', 'dt' => 3, 'field' => 'created', 'as' => 'created'),
                array('db' => 'modified', 'dt' => 4, 'field' => 'modified', 'as' => 'modified')
            );
            $joinQuery = "";
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
        if (!$this->AdvertisementPage->exists($id)) {
            throw new NotFoundException(__('Invalid advertisement page'));
        }
        $options = array('conditions' => array('AdvertisementPage.' . $this->AdvertisementPage->primaryKey => $id));
        $this->set('advertisementPage', $this->AdvertisementPage->find('first', $options));
    }

    /**
     * admin_add method
     *
     * @return void
     */
    public function admin_add() {
        if ($this->request->is('post')) {
            $this->AdvertisementPage->create();
            if ($this->AdvertisementPage->save($this->request->data)) {
                $this->Flash->AdminSuccess(__('The advertisement page has been saved.'));
            } else {
                $this->Flash->AdminError(__('The advertisement page could not be saved. Please, try again.'));
            }
        }
        return $this->redirect(array('action' => 'index'));
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
        $id = $this->data['id'];
        $this->AdvertisementPage->recursive = 0;
        $options = array('conditions' => array('AdvertisementPage.' . $this->AdvertisementPage->primaryKey => $id));
        $ad_page_data = $this->AdvertisementPage->find('first', $options);
        print(json_encode($ad_page_data));
        exit;
    }

    /**
     * admin_delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_delete() {
        if ($this->request->is('ajax')) {
            $this->AdvertisementPage->id = $this->request->data['id'];
            if (!$this->AdvertisementPage->exists()) {
                throw new NotFoundException(__('Invalid package'));
            }
            if ($this->AdvertisementPage->delete()) {
                echo 1;
            } else {
                echo 0;
            }
        }
        exit;
    }

}
