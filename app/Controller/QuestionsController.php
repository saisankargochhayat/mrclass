<?php

App::uses('AppController', 'Controller');

/**
 * Questions Controller
 *
 * @property Question $Question
 * @property PaginatorComponent $Paginator
 */
class QuestionsController extends AppController {

    public $helpers = array('Text');

    function beforeFilter() {
        $this->Auth->allow('index');
        parent::beforeFilter();
    }

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
        if (!isset($this->params->pass[0])) {
            throw new NotFoundException(__('Invalid Request. Page not found.'));
        }
        $this->loadModel('QuestionCategory');
        if (!$this->QuestionCategory->exists($this->params->pass[0])) {
            throw new NotFoundException(__('Question category not found.'));
        }
        $question_category_id = $this->params->pass[0];
        $questions = $this->Question->find('all', array('conditions' => array('Question.question_category_id' => $question_category_id), 'order' => array('Question.sequence Asc')));
        foreach ($questions as $key => $value) {
            $file_path = QUESTION_BANK_DIR . $this->Format->sanitizeFilename($value['QuestionCategory']['name']) . "_" . $value['QuestionCategory']['id'] . DS . $value['Question']['filename'];
            #$questions[$key]['Question']['file_url'] = Router::url(array('controller' => 'questions', 'action' => 'question_bank_download','cid'=>$value['QuestionCategory']['id'],'id'=>$value['Question']['id'],'slug'=> $this->Format->sanitizeFilename($value['QuestionCategory']['name'])."/". $value['Question']['filename']), true);
            $questions[$key]['Question']['extension'] = pathinfo($file_path, PATHINFO_EXTENSION);
            $questions[$key]['Question']['file_url_absolute'] = $file_path;
        }
        #pr($questions);exit;
        $questionCategories = $this->QuestionCategory->find('first', array('conditions' => array('QuestionCategory.id' => $question_category_id)));
        $this->set('questions', $questions);
        $this->set('category_name', $questionCategories['QuestionCategory']['name']);
        $this->set('category_id', $question_category_id);
    }

    public function question_bank_download() {
        $this->loadModel('QuestionDownload');
        $download_history['QuestionDownload'] = array('user_id' => $this->Auth->User('id'), 'question_id' => $this->request->params['id']);
        $this->QuestionDownload->save($download_history);
        $this->response->file(QUESTION_BANK_DIR . $this->request->params['cat'] . "_" . $this->request->params['cid'] . DS . $this->request->params['file'], array('download' => false, 'name' => $this->request->params['file']));
        return $this->response;
    }

    /**
     * admin_index method
     *
     * @return void
     */
    public function admin_index() {
        if ($this->request->is('ajax')) {
            $table = 'questions';
            $primaryKey = 'id';
            $columns = array(
                array('db' => 'q.id', 'dt' => 0, 'field' => 'q_id', 'as' => 'q_id'),
                array('db' => 'q.sequence', 'dt' => 1, 'field' => 'q_seq', 'as' => 'q_seq'),
                array('db' => 'q.title', 'dt' => 2, 'field' => 'q_title', 'as' => 'q_title'),
                array('db' => 'q.filename', 'dt' => 3, 'field' => 'filename', 'as' => 'filename'),
                array('db' => 'q.description', 'dt' => 4, 'field' => 'description', 'as' => 'description'),
                array('db' => 'count(qd.question_id)', 'dt' => 5, 'field' => 'dowloadcount', 'as' => 'dowloadcount'),
                array('db' => 'q.created', 'dt' => 6, 'field' => 'created', 'as' => 'created'),
                array('db' => 'q.status', 'dt' => 7, 'field' => 'status', 'as' => 'status'),
                array('db' => 'qc.id', 'dt' => 8, 'field' => 'qc_id', 'as' => 'qc_id')
            );
            $joinQuery = "FROM `questions` AS `q` "
                    . "LEFT JOIN `question_categories` AS `qc` ON (`q`.`question_category_id` = `qc`.`id`) "
                    . "LEFT JOIN `question_downloads` AS `qd` ON (`q`.`id` = `qd`.`question_id`)";
            if (isset($this->request->query['fetch']) && trim($this->request->query['fetch']) == "all") {
                $extraWhere = "`q`.`status` = '1'";
            } else {
                $extraWhere = "`q`.`status` = '1' AND `q`.`question_category_id` = '" . trim($this->request->query['fetch']) . "'";
            }
            $groupBy = '`q`.`id`';
            $having = "Yes";
            App::uses('SSP', 'Utility');
            $response = SSP::simple($_GET, $this->db_config, $table, $primaryKey, $columns, $joinQuery, $extraWhere, $groupBy, '', $having);
            print(json_encode($response));
            exit;
        }
        if (!isset($this->params->pass[0])) {
            throw new NotFoundException(__('Invalid Request.'));
        }
        $this->loadModel('QuestionCategory');
        if ($this->request->params['pass'][0] != "all") {
            if (!$this->QuestionCategory->exists($this->params->pass[0])) {
                throw new NotFoundException(__('Question category not found.'));
            }
        }
        $extra = (isset($this->request->params['pass'][0])) ? $this->request->params['pass'][0] : "";
        $this->set(compact('extra'));
        if ($extra != "all") {
            $this->loadModel('QuestionCategory');
            $qbc_data = $this->QuestionCategory->find('first', array('conditions' => array('QuestionCategory.id' => $extra)));
            $this->set(compact('qbc_data'));
        }
    }

    public function admin_question_bank_upload($qbc_id = null) {
        $this->loadModel('QuestionCategory');
        if (!isset($this->params->pass[0])) {
            throw new NotFoundException(__('Invalid Request.'));
        }
        $this->loadModel('QuestionCategory');
        if (!$this->QuestionCategory->exists($this->params->pass[0])) {
            throw new NotFoundException(__('Question category not found.'));
        }
        $QuestionCategory = $this->QuestionCategory->find('first', array('conditions' => array('QuestionCategory.id' => $this->params->pass[0])));
        $this->set(compact('QuestionCategory'));
    }

    public function admin_question_bank_upload_files() {
        if ($this->request->is('post', 'put')) {
            /* For File Uploading functionality */
            if ($this->request->is('ajax')) {
                $file_data = $this->request->data['Question']['attachemnts'];
                $allowed = array('pdf');

                if (!file_exists(QUESTION_BANK_TMP_PATH)) {
                    mkdir(QUESTION_BANK_TMP_PATH, 0777, true);
                }

                if (isset($file_data) && $file_data['error'] == 0) {

                    $extension = pathinfo($file_data['name'], PATHINFO_EXTENSION);
                    if (!in_array(strtolower($extension), $allowed)) {
                        echo '{"status":"error"}';
                        exit;
                    }
                    $file_temp_name = mt_rand(9999, 99999) . md5($file_data['name'] . CakeText::uuid()) . "." . $extension;
                    if (move_uploaded_file($file_data['tmp_name'], QUESTION_BANK_TMP_PATH . $file_temp_name)) {
                        $status_array = array('status' => 'success', 'tmp_name' => $file_temp_name, 'file_name' => $file_data['name']);
                        print(json_encode($status_array));
                        exit;
                    }
                }

                echo '{"status":"error"}';
                exit;
            }


            if (!empty($this->request->data)) {
                $file_up_data = $this->request->data;
                $this->loadModel('QuestionCategory');
                $QuestionCategory = $this->QuestionCategory->find('first', array('conditions' => array('QuestionCategory.id' => $this->request->data['Question']['question_category_id'])));
                if (!empty($QuestionCategory)) {

                    if (isset($file_up_data['Question']['files']) && !empty($file_up_data['Question']['files'])) {
                        $ques_files_array = array();
                        $inflected_category_name = $this->Format->sanitizeFilename($QuestionCategory['QuestionCategory']['name']);
                        $dest_path = QUESTION_BANK_DIR . $inflected_category_name . "_" . $QuestionCategory['QuestionCategory']['id'];

                        if (!file_exists($dest_path)) {
                            mkdir($dest_path, 0777, true);
                        }

                        $questionCount = count($QuestionCategory['Question']);
                        if ($questionCount == 0) {
                            $seq = 0;
                        } else {
                            $seq_query = $this->Question->find('all', array(
                                'conditions' => array('Question.question_category_id' => $this->request->data['Question']['question_category_id']),
                                'fields' => array('MAX(Question.sequence) AS max_sequence'),
                                'group by' => 'Question.question_category_id'
                                    )
                            );
                            $seq = $seq_query[0][0]['max_sequence'];
                        }
                        foreach ($file_up_data['Question']['files'] as $key => $value) {
                            $seq++;
                            $file_name_arr = explode('@', $value);
                            $src_path = QUESTION_BANK_TMP_PATH . $file_name_arr[0];
                            $file_new_name = $this->Format->file_newname($dest_path, $this->Format->sanitizeFilename($file_name_arr[1]));
                            $ques_files_array['Question'][] = array('question_category_id' => $QuestionCategory['QuestionCategory']['id'], 'filename' => $file_new_name, 'title' => $file_new_name, 'sequence' => $seq, 'description' => '', 'status' => '1');
                            if (copy($src_path, $dest_path . DS . $file_new_name)) {
                                unlink($src_path);
                            }
                        }
                        $this->Question->saveAll($ques_files_array['Question']);
                        $this->Flash->AdminSuccess(__('Files successfully uploaded.'));
                    }
                } else {
                    $this->Flash->AdminError(__('Error. Please try again.'));
                }
                $this->redirect(array('action' => 'index', $this->request->data['Question']['question_category_id'], 'admin' => 1));
            }
        }
    }

    public function admin_delete_attachment() {
        $this->layout = "ajax";
        if ($this->request->data['tmp_name']) {
            $files = glob(QUESTION_BANK_TMP_PATH . '*');
            if (in_array(QUESTION_BANK_TMP_PATH . $this->request->data['tmp_name'], $files)) {
                unlink(QUESTION_BANK_TMP_PATH . $this->request->data['tmp_name']);
                $resp = array('status' => 'success', 'reponseTest' => 'File removed.');
            } else {
                $resp = array('status' => 'failed', 'reponseTest' => 'File not found');
            }
            print(json_encode($resp));
        }exit;
    }

    /**
     * admin_add method
     *
     * @return void
     */
    public function admin_add() {
        if ($this->request->is('ajax')) {
            $data = $this->request->data;
            if (isset($data['Question']['id']) && !empty($data['Question']['id'])) {
                $data['Question']['id'] = $data['Question']['id'];
            }
            $data['Question']['status'] = '1';
            if ($this->Question->saveAll($data)) {
                $last_id = $this->Question->id;
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
            $this->Question->recursive = -1;
            $options = array('conditions' => array('Question.' . $this->Question->primaryKey => $id));
            $ad_cat_data = $this->Question->find('first', $options);
            echo json_encode($ad_cat_data['Question']);
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
            $this->Question->id = $this->request->data['id'];
            $this->loadModel('QuestionCategory');
            $QuestionCategory = $this->QuestionCategory->find('first', array('conditions' => array('QuestionCategory.id' => $this->request->data['cat_id']), 'recursive' => -1));
            $dest_path = $path = $this->Format->get_question_bank_flder($QuestionCategory['QuestionCategory']['id']);
            $dest_file = $dest_path . DS . trim($this->request->data['file_name']);
            $files = glob($dest_path . DS . '*'); // get all file names
            if ($this->Question->delete($this->Question->id)) {
                $this->loadModel('QuestionDownload');
                $conditions = array(
                    "QuestionDownload.question_id" => $this->request->data['id']
                );
                $this->QuestionDownload->deleteAll($conditions);
                if (in_array($dest_file, $files)) {
                    unlink($dest_file);
                    $resp = array('status' => true, 'reponseTest' => 'Question bank deleted.');
                } else {
                    $resp = array('status' => false, 'reponseTest' => 'File not found');
                }
            } else {
                $resp = array('status' => false, 'reponseTest' => 'Question bank could not deleted.');
            }
            echo json_encode($resp);
            exit;
        } else {
            throw new NotFoundException(__('Invalid Request.'));
        }
    }

    public function admin_save_sequence() {
        if ($this->request->data) {
            $data = $this->request->data;
            $this->Question->id = $data['pk'];
            if (!empty($data['value'])) {
                if ((int) $data['value'] == $data['value'] && (int) $data['value'] > 0) {
                    if ($this->Question->saveField($data['name'], trim($data['value']))) {
                        $resp = array('success' => true, 'responseText' => 'Sequence updated.');
                    } else {
                        $resp = array('success' => false, 'responseText' => 'Sequence couldn\'t be updated.');
                    }
                } else {
                    $resp = array('success' => false, 'responseText' => 'Only positive numbers are allowed.');
                }
            } else {
                $resp = array('success' => false, 'responseText' => 'Please enter numbers greater than zero.');
            }
        } else {
            $resp = array('success' => false, 'responseText' => 'Invalid request.');
        }
        print(json_encode($resp));
        exit;
    }

    public function admin_reset_sequence() {
        $this->Question->query("SET @a:=0;UPDATE questions SET sequence=@a:=@a+1 WHERE question_category_id ='3';");
        exit(1);
    }

    /**
     * Question bank download method
     * This function supports downloading files
     * via download managers and avoiding multiple
     * downloading requests.
     * @throws NotFoundException
     * @param string $folder_name
     * @param string $file_name
     * @param string $file_name
     * @return $file_id;
     */
//    public function question_bank_download($folder_name, $file_name, $file_id) {
//        @apache_setenv('no-gzip', 1);
//        @ini_set('zlib.output_compression', 'Off');
//
//        // sanitize the file request, keep just the name and extension
//        // also, replaces the file location with a preset one ('./myfiles/' in this example)
//        $file_path = QUESTION_BANK_DIR . $folder_name . DS . $file_name;
//        $path_parts = pathinfo($file_path);
//        $file_name = $path_parts['basename'];
//        $file_ext = trim(strtolower($path_parts['extension']));
//
//        // allow a file to be streamed instead of sent as an attachment
//        $is_attachment = isset($_REQUEST['stream']) ? false : true;
//
//        // make sure the file exists
//        if (is_file($file_path)) {
//            $file_size = filesize($file_path);
//            $file = @fopen($file_path, "rb");
//            if ($file) {
//                //Save File Download History
//                $download_history['QuestionDownload'] = array('user_id' => $this->Auth->User('id'), 'question_id' => $file_id);
//                $this->loadModel('QuestionDownload');
//                $this->QuestionDownload->save($download_history);
//                
//                // set the headers, prevent caching
//                header("Pragma: public");
//                header("Expires: -1");
//                header("Cache-Control: public, must-revalidate, post-check=0, pre-check=0");
//                header("Content-Disposition: attachment; filename=\"$file_name\"");
//
//                // set appropriate headers for attachment or streamed file
//                if ($is_attachment)
//                    header("Content-Disposition: attachment; filename=\"$file_name\"");
//                else
//                    header('Content-Disposition: inline;');
//
//                // set the mime type based on extension, add yours if needed.
//                $ctype_default = "application/octet-stream";
//                $content_types = array(
//                    'txt' => 'text/plain',
//                    'pdf' => 'application/pdf',
//                    'doc' => 'application/msword',
//                    'rtf' => 'application/rtf',
//                    'xls' => 'application/vnd.ms-excel',
//                    'ppt' => 'application/vnd.ms-powerpoint',
//                    'odt' => 'application/vnd.oasis.opendocument.text',
//                    'ods' => 'application/vnd.oasis.opendocument.spreadsheet'
//                );
//                $ctype = isset($content_types[$file_ext]) ? $content_types[$file_ext] : $ctype_default;
//                header("Content-Type: " . $ctype);
//                //check if http_range is sent by browser (or download manager)
//                if (isset($_SERVER['HTTP_RANGE'])) {
//                    list($size_unit, $range_orig) = explode('=', $_SERVER['HTTP_RANGE'], 2);
//                    if ($size_unit == 'bytes') {
//                        //multiple ranges could be specified at the same time, but for simplicity only serve the first range
//                        list($range, $extra_ranges) = explode(',', $range_orig, 2);
//                    } else {
//                        $range = '';
//                        header('HTTP/1.1 416 Requested Range Not Satisfiable');
//                        exit;
//                    }
//                } else {
//                    $range = '';
//                }
//
//                //figure out download piece from range (if set)
//                list($seek_start, $seek_end) = explode('-', $range, 2);
//
//                //set start and end based on range (if set), else set defaults
//                //also check for invalid ranges.
//                $seek_end = (empty($seek_end)) ? ($file_size - 1) : min(abs(intval($seek_end)), ($file_size - 1));
//                $seek_start = (empty($seek_start) || $seek_end < abs(intval($seek_start))) ? 0 : max(abs(intval($seek_start)), 0);
//
//                //Only send partial content header if downloading a piece of the file (IE workaround)
//                if ($seek_start > 0 || $seek_end < ($file_size - 1)) {
//                    header('HTTP/1.1 206 Partial Content');
//                    header('Content-Range: bytes ' . $seek_start . '-' . $seek_end . '/' . $file_size);
//                    header('Content-Length: ' . ($seek_end - $seek_start + 1));
//                } else
//                    header("Content-Length: $file_size");
//
//                header('Accept-Ranges: bytes');
//
//                set_time_limit(0);
//                fseek($file, $seek_start);
//
//                while (!feof($file)) {
//                    print(@fread($file, 1024 * 8));
//                    ob_flush();
//                    flush();
//                    if (connection_status() != 0) {
//                        @fclose($file);
//                        exit;
//                    }
//                }
//
//                // file save was a success
//                @fclose($file);
//                
//                exit;
//            } else {
//                // file couldn't be opened
//                header("HTTP/1.0 500 Internal Server Error");
//                exit;
//            }
//        } else {
//            // file does not exist
//            header("HTTP/1.0 404 Not Found");
//            exit;
//        }
//    }
}
