<?php

App::uses('AppController', 'Controller');

/**
 * QuestionDownloads Controller
 *
 * @property QuestionDownload $QuestionDownload
 * @property PaginatorComponent $Paginator
 * @property FlashComponent $Flash
 */
class QuestionDownloadsController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'Flash');

    /**
     * index method
     *
     * @return void
     */
    public function index() {
        $this->QuestionDownload->recursive = 0;
        $this->set('questionDownloads', $this->Paginator->paginate());
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        if (!$this->QuestionDownload->exists($id)) {
            throw new NotFoundException(__('Invalid question download'));
        }
        $options = array('conditions' => array('QuestionDownload.' . $this->QuestionDownload->primaryKey => $id));
        $this->set('questionDownload', $this->QuestionDownload->find('first', $options));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        if ($this->request->is('post')) {
            $this->QuestionDownload->create();
            if ($this->QuestionDownload->save($this->request->data)) {
                return $this->flash(__('The question download has been saved.'), array('action' => 'index'));
            }
        }
        $questions = $this->QuestionDownload->Question->find('list');
        $users = $this->QuestionDownload->User->find('list');
        $this->set(compact('questions', 'users'));
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        if (!$this->QuestionDownload->exists($id)) {
            throw new NotFoundException(__('Invalid question download'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if ($this->QuestionDownload->save($this->request->data)) {
                return $this->flash(__('The question download has been saved.'), array('action' => 'index'));
            }
        } else {
            $options = array('conditions' => array('QuestionDownload.' . $this->QuestionDownload->primaryKey => $id));
            $this->request->data = $this->QuestionDownload->find('first', $options);
        }
        $questions = $this->QuestionDownload->Question->find('list');
        $users = $this->QuestionDownload->User->find('list');
        $this->set(compact('questions', 'users'));
    }

    /**
     * delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function delete($id = null) {
        $this->QuestionDownload->id = $id;
        if (!$this->QuestionDownload->exists()) {
            throw new NotFoundException(__('Invalid question download'));
        }
        $this->request->allowMethod('post', 'delete');
        if ($this->QuestionDownload->delete()) {
            return $this->flash(__('The question download has been deleted.'), array('action' => 'index'));
        } else {
            return $this->flash(__('The question download could not be deleted. Please, try again.'), array('action' => 'index'));
        }
    }

    /**
     * admin_index method
     *
     * @return void
     */
    public function admin_index() {
        if ($this->request->is('ajax')) {
            $table = 'question_downloads';
            $primaryKey = 'id';
            $columns = array(
                array('db' => 'qd.id', 'dt' => 0, 'field' => 'q_id', 'as' => 'q_id'),
                array('db' => 'q.title', 'dt' => 1, 'field' => 'q_title', 'as' => 'q_title'),
                array('db' => 'u.name', 'dt' => 2, 'field' => 'u_name', 'as' => 'u_name'),
                array('db' => 'qd.created', 'dt' => 3, 'field' => 'created', 'as' => 'created')
            );
            $joinQuery = "FROM `question_downloads` AS `qd` "
                    . "LEFT JOIN `questions` AS `q` ON (`q`.`id` = `qd`.`question_id`) "
                    . "LEFT JOIN `users` AS `u` ON (`u`.`id` = `qd`.`user_id`)";
            if (isset($this->request->query['fetch']) && trim($this->request->query['fetch']) == "all") {
                $extraWhere = "";
            } else {
                $extraWhere = "`qd`.`question_id` = '" . trim($this->request->query['fetch']) . "'";
            }
            App::uses('SSP', 'Utility');
            $response = SSP::simple($_GET, $this->db_config, $table, $primaryKey, $columns, $joinQuery, $extraWhere);
            print(json_encode($response));
            exit;
        }
        if (!isset($this->params->pass[0])) {
            throw new NotFoundException(__('Invalid Request.'));
        }
        $this->loadModel('Question');
        if ($this->request->params['pass'][0] != "all") {
            if (!$this->Question->exists($this->params->pass[0])) {
                throw new NotFoundException(__('Invalid Request.'));
            }
        }
        $extra = (isset($this->request->params['pass'][0])) ? $this->request->params['pass'][0] : "";
        $this->set(compact('extra'));
        if ($extra != "all") {
            $qdc_data = $this->Question->find('first', array('conditions' => array('Question.id' => $extra)));
            $this->set(compact('qdc_data'));
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
        if (!$this->QuestionDownload->exists($id)) {
            throw new NotFoundException(__('Invalid question download'));
        }
        $options = array('conditions' => array('QuestionDownload.' . $this->QuestionDownload->primaryKey => $id));
        $this->set('questionDownload', $this->QuestionDownload->find('first', $options));
    }

    /**
     * admin_add method
     *
     * @return void
     */
    public function admin_add() {
        if ($this->request->is('post')) {
            $this->QuestionDownload->create();
            if ($this->QuestionDownload->save($this->request->data)) {
                return $this->flash(__('The question download has been saved.'), array('action' => 'index'));
            }
        }
        $questions = $this->QuestionDownload->Question->find('list');
        $users = $this->QuestionDownload->User->find('list');
        $this->set(compact('questions', 'users'));
    }

    /**
     * admin_edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_edit($id = null) {
        if (!$this->QuestionDownload->exists($id)) {
            throw new NotFoundException(__('Invalid question download'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if ($this->QuestionDownload->save($this->request->data)) {
                return $this->flash(__('The question download has been saved.'), array('action' => 'index'));
            }
        } else {
            $options = array('conditions' => array('QuestionDownload.' . $this->QuestionDownload->primaryKey => $id));
            $this->request->data = $this->QuestionDownload->find('first', $options);
        }
        $questions = $this->QuestionDownload->Question->find('list');
        $users = $this->QuestionDownload->User->find('list');
        $this->set(compact('questions', 'users'));
    }

    /**
     * admin_delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_delete($id = null) {
        $this->QuestionDownload->id = $id;
        if (!$this->QuestionDownload->exists()) {
            throw new NotFoundException(__('Invalid question download'));
        }
        $this->request->allowMethod('post', 'delete');
        if ($this->QuestionDownload->delete()) {
            return $this->flash(__('The question download has been deleted.'), array('action' => 'index'));
        } else {
            return $this->flash(__('The question download could not be deleted. Please, try again.'), array('action' => 'index'));
        }
    }

}
