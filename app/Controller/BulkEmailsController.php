<?php

App::uses('AppController', 'Controller');

/**
 * BulkEmails Controller
 *
 * @property BulkEmail $BulkEmail
 * @property PaginatorComponent $Paginator
 */
class BulkEmailsController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator');

    public function admin_send_bulk_email() {
        if ($this->request->is('post', 'put')) {
            /* For File Uploading functionality */
            if ($this->request->is('ajax')) {
                $file_data = $this->request->data['BulkEmail']['attachments'];
                $allowed = array('bmp', 'gif', 'GIF', 'png', 'PNG', 'jpg', 'JPG', 'JPEG', 'jpeg', 'pdf', 'PDF', 'doc', 'docx', 'xls', 'xlxs', 'txt', 'rtf');

                if (!file_exists(EMAIL_ATTACHMENT_TMP_PATH)) {
                    mkdir(EMAIL_ATTACHMENT_TMP_PATH, 0777, true);
                }

                if (isset($file_data) && $file_data['error'] == 0) {

                    $extension = pathinfo($file_data['name'], PATHINFO_EXTENSION);
                    if (!in_array(strtolower($extension), $allowed)) {
                        echo '{"status":"error"}';
                        exit;
                    }
                    $file_temp_name = mt_rand(9999, 99999) . md5($file_data['name'] . CakeText::uuid()) . "." . $extension;
                    if (move_uploaded_file($file_data['tmp_name'], EMAIL_ATTACHMENT_TMP_PATH . DS . $file_temp_name)) {
                        $status_array = array('status' => 'success', 'tmp_name' => $file_temp_name, 'file_name' => $file_data['name']);
                        #echo '{"status":"success"}';
                        print(json_encode($status_array));
                        exit;
                    }
                }

                echo '{"status":"error"}';
                exit;
            }


            if (!empty($this->request->data)) {
                $this->loadModel('User');
                $users = $this->User->find('all', array('fields' => array('id', 'name', 'email'), 'conditions' => array('User.id' => $this->request->data['BulkEmail']['users_email']), 'order' => array('name' => "ASC"), 'recursive' => -1));

                $email_data = $this->request->data;
                $email_data_bulk_email['BulkEmail']['subject'] = $email_data['BulkEmail']['subject'];
                $email_data_bulk_email['BulkEmail']['content'] = $email_data['BulkEmail']['description'];
                if ($this->BulkEmail->save($email_data_bulk_email)) {
                    $bulk_email_id = $this->BulkEmail->id;

                    if (isset($email_data['BulkEmail']['files']) && !empty($email_data['BulkEmail']['files'])) {
                        $attachment_arr = array();
                        $email_attachment_arr = array();
                        $dest_path = EMAIL_ATTACHMENT_PATH . DS . 'email_attachment_id' . $bulk_email_id;

                        if (!file_exists($dest_path)) {
                            mkdir($dest_path, 0777, true);
                        }

                        foreach ($email_data['BulkEmail']['files'] as $key => $value) {
                            $file_name_arr = explode('@', $value);
                            $attachment_arr['BulkEmailAttachment'][] = array('bulk_email_id' => $bulk_email_id, 'filename' => $file_name_arr[1], 'file' => $file_name_arr[0]);

                            $src_path = EMAIL_ATTACHMENT_TMP_PATH . DS . $file_name_arr[0];
                            copy($src_path, $dest_path . DS . $file_name_arr[1]);
                            //$email_attachment_arr[] = $dest_path . DS . $file_name_arr[1];
                            $email_attachment_arr[] = Router::url(array('controller' => 'bulk_emails', 'action' => 'attachment_download', "email_attachment_id" . $bulk_email_id, $file_name_arr[1]), true);
                            $email_attachment_names[] = $file_name_arr[1];
                        }
                        $this->loadModel('BulkEmailAttachment');
                        $this->BulkEmailAttachment->saveAll($attachment_arr['BulkEmailAttachment']);
                    }
                    $recepient_arr = array();
                    foreach ($users as $k => $v) {
                        $recepient_arr['BulkEmailReceiver'][] = array('bulk_email_id' => $bulk_email_id, 'email' => $v['User']['email']);
                    }
                    $this->loadModel('BulkEmailReceiver');
                    if ($this->BulkEmailReceiver->saveAll($recepient_arr['BulkEmailReceiver'])) {

                        /* load email config class and keep the conenection open untill all mails are sent */
                        $Email = new CakeEmail(Configure::read('EMAIL_DELIVERY_MODE'));
                        $Email->config(array('persistent' => true));

                        foreach ($users as $key => $value) {
                            $view_arr = array('for' => 'user', 'name' => $value['User']['name'], 'email' => $value['User']['email'], 'desc' => $this->request->data['BulkEmail']['description']);
                            if (isset($email_attachment_arr) && !empty($email_attachment_arr)) {
                                $view_arr['downlod_urls'] = $email_attachment_arr;
                            }
                            if (isset($email_attachment_names) && !empty($email_attachment_names)) {
                                $view_arr['file_names'] = $email_attachment_names;
                            }

                            $Email->from(array(Configure::read('COMPANY.FROM_EMAIL') => Configure::read('COMPANY.NAME')));
                            $Email->viewVars($view_arr);
                            $Email->to($value['User']['email']);
                            $Email->subject($this->request->data['BulkEmail']['subject']);
                            $Email->template('bulk_email');
                            $Email->send();
                        }

                        /* Disconnect email connection */
                        if (Configure::read('EMAIL_DELIVERY_MODE') == 'smtp') {
                            $Email->disconnect();
                        }
                        $this->Flash->AdminSuccess(__('Emails sent successfully.'));
                    } else {
                        $this->Flash->AdminError(__('Error. Please try again.'));
                    }
                } else {
                    $this->Flash->AdminError(__('Error. Please try again.'));
                }
                $this->redirect(array('action' => 'admin_send_bulk_email', 'admin' => 1));
            }
        }
        $users_arr = $this->User->find('all', array('fields' => array('CONCAT(User.name," (",User.email,")") AS name_email', 'id'), 'conditions' => array('User.status' => '1'), 'order' => array('name_email' => "ASC"), 'recursive' => -1));

        $options['joins'] = array(
            array('table' => 'cities', 'alias' => 'City', 'type' => 'LEFT', 'conditions' => array('User.city=City.id'))
        );
        $options['fields'] = array('User.id', 'User.city', 'User.name', 'User.email', 'City.id', 'City.name');
        $options['order'] = array('City.name' => 'ASC');
        $options['conditions'] = array('User.status' => '1', 'User.city !=' => '', 'City.id !=' => '');
        $options['group'] = array('User.city');
        $options['recursive'] = -1;
        $user_cities_arr = $this->User->find('all', $options);
        $city_result = Hash::combine($user_cities_arr, '{n}.City.id', '{n}.City.name');
        $this->set('city_list', $city_result);
        $result = Hash::combine($users_arr, '{n}.User.id', '{n}.{n}.name_email');
        $this->set('user_list', $result);
    }

    public function admin_attachment_download($folder_name, $file_name) {
        $this->response->file(EMAIL_ATTACHMENT_PATH . DS . $folder_name . DS . $file_name, array('download' => true, 'name' => $file_name));
        return $this->response;
    }

    public function admin_manage_email() {
        $all_mails = $this->BulkEmail->find('all', array('order' => array('BulkEmail.id DESC')));
        $this->set('all_mails', $all_mails);
    }

    public function admin_email_attachment_delete($id = null) {
        $this->BulkEmail->id = $id;
        if (!$this->BulkEmail->exists()) {
            throw new NotFoundException(__('Invalid inquiry'));
        }
        if ($this->BulkEmail->delete($this->BulkEmail->id, true)) {

            $files = glob(EMAIL_ATTACHMENT_PATH . DS . 'email_attachment_id' . $id . '/*'); // get all file names
            if (is_array($files) && !empty($files)) {
                foreach ($files as $file) { // iterate files
                    if (is_file($file))
                        unlink($file); // delete file
                }
                rmdir(EMAIL_ATTACHMENT_PATH . DS . 'email_attachment_id' . $id);
            }

            $this->Flash->AdminSuccess(__('The Email attachments has been deleted.'));
        } else {
            $this->Flash->AdminError(__('Email & it\'s attachments could not be deleted. Please, try again.'));
        }
        return $this->redirect(array('action' => 'manage_email', 'admin' => 1));
    }

    public function admin_delete_attachment() {
        $this->layout = "ajax";
        if ($this->request->data['tmp_name']) {
            $files = glob(EMAIL_ATTACHMENT_TMP_PATH . DS . '*'); // get all file names
            if (in_array(EMAIL_ATTACHMENT_TMP_PATH . DS . $this->request->data['tmp_name'], $files)) {
                unlink(EMAIL_ATTACHMENT_TMP_PATH . DS . $this->request->data['tmp_name']);
                $resp = array('status' => 'success', 'reponseTest' => 'Attcahment removed');
            } else {
                $resp = array('status' => 'failed', 'reponseTest' => 'Attcahment not found');
            }
            print(json_encode($resp));
        }exit;
    }

}
