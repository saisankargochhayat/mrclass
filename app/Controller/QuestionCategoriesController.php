<?php

App::uses('AppController', 'Controller');

/**
 * QuestionCategories Controller
 *
 * @property QuestionCategory $QuestionCategory
 * @property PaginatorComponent $Paginator
 */
class QuestionCategoriesController extends AppController {

    function beforeFilter() {
        $this->Auth->allow('index');
        parent::beforeFilter();
    }

    /**
     * index method
     *
     * @return void
     */
    public function index() {
        $questionCategories = $this->QuestionCategory->find('all', array('order' => array('QuestionCategory.name Asc')));
        $this->set('questionCategories', $questionCategories);
    }

    /**
     * admin_index method
     *
     * @return void
     */
    public function admin_index() {
        if ($this->request->is('ajax')) {
            $table = 'question_categories';
            $primaryKey = 'id';
            $columns = array(
                array('db' => 'qc.id', 'dt' => 0, 'field' => 'id', 'as' => 'id'),
                array('db' => 'qc.name', 'dt' => 1, 'field' => 'name', 'as' => 'name'),
                array('db' => 'qc.description', 'dt' => 2, 'field' => 'description', 'as' => 'description'),
                array('db' => 'count(q.question_category_id)', 'dt' => 3, 'field' => 'filecount', 'as' => 'filecount'),
                array('db' => 'qc.created', 'dt' => 4, 'field' => 'created', 'as' => 'created'),
                array('db' => 'qc.status', 'dt' => 5, 'field' => 'status', 'as' => 'status')
            );
            $joinQuery = "FROM `question_categories` AS `qc` "
                    . "LEFT JOIN `questions` AS `q` ON (`qc`.`id` = `q`.`question_category_id`) ";
            $extraWhere = "`qc`.`status` = '1'";
            $groupBy = '`qc`.`id`';
            $having = "Yes";
            App::uses('SSP', 'Utility');
            $response = SSP::simple($_GET, $this->db_config, $table, $primaryKey, $columns, $joinQuery, $extraWhere, $groupBy, '', $having);
            print(json_encode($response));
            exit;
        }
    }

    /**
     * admin_add method
     *
     * @return void
     */
    public function admin_add() {
        if ($this->request->is('ajax')) {
            $data = $this->request->data;
            if (isset($data['QuestionCategory']['id']) && !empty($data['QuestionCategory']['id'])) {
                $record = $this->QuestionCategory->findById($data['QuestionCategory']['id']);
                $data['QuestionCategory']['id'] = $data['QuestionCategory']['id'];
                if(trim($record['QuestionCategory']['name']) != trim($data['QuestionCategory']['name'])){
                    $oldname = QUESTION_BANK_DIR . $this->Format->sanitizeFilename($record['QuestionCategory']['name']) . "_" . $record['QuestionCategory']['id'];
                    $newname = QUESTION_BANK_DIR . $this->Format->sanitizeFilename(trim($data['QuestionCategory']['name'])) . "_" . $record['QuestionCategory']['id'];
                    if (is_dir($oldname)) {
                        rename($oldname,$newname);
                    }
                }
            }
            $data['QuestionCategory']['status'] = '1';
            if ($this->QuestionCategory->saveAll($data)) {
                $last_id = $this->QuestionCategory->id;
                $res = array('status' => true, 'id' => $last_id);
            } else {
                $res = array('status' => false);
            }
            echo json_encode($res);
            exit;
        } else {
            throw new NotFoundException(__('Page Not Found.'));
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
        if ($this->request->is('ajax')) {
            $this->layout = 'ajax';
            $id = $this->request->data['id'];
            $this->QuestionCategory->recursive = 0;
            $options = array('conditions' => array('QuestionCategory.' . $this->QuestionCategory->primaryKey => $id));
            $ad_cat_data = $this->QuestionCategory->find('first', $options);
            echo json_encode($ad_cat_data['QuestionCategory']);
            exit;
        } else {
            throw new NotFoundException(__('Page Not Found.'));
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
        if ($this->request->is('ajax')) {
            $this->QuestionCategory->id = $this->request->data['id'];
            if (!$this->QuestionCategory->exists()) {
                throw new NotFoundException(__('Invalid package'));
            }
            $path = $this->Format->get_question_bank_flder($this->request->data['id']);
            if ($this->QuestionCategory->delete()) {
                //Delete associated question banks
                $this->loadModel('Question');
                $q_bank_results = Hash::extract($this->Question->find('all', array('conditions' => array('Question.question_category_id' => $this->request->data['id']))), '{n}.Question.id');
                if (is_array($q_bank_results) && !empty($q_bank_results)) {
                    foreach ($q_bank_results as $key => $value) {
                        $this->Question->delete($value);
                    }
                    //Delete File download history
                    $this->loadModel('QuestionDownload');
                    $delete_condition = array('QuestionDownload.question_id' => $q_bank_results);
                    $this->QuestionDownload->deleteAll($delete_condition);
                    
                    $this->Format->deleteDir($path);
                }
                echo 1;
            } else {
                echo 0;
            }
            exit;
        } else {
            throw new NotFoundException(__('Page Not Found.'));
        }
    }

}
