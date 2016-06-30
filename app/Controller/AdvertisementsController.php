<?php

App::uses('AppController', 'Controller');

/**
 * Advertisements Controller
 *
 * @property Advertisement $Advertisement
 * @property PaginatorComponent $Paginator
 */
class AdvertisementsController extends AppController {

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
        $this->Advertisement->recursive = 0;
        $this->set('advertisements', $this->Paginator->paginate());
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        if (!$this->Advertisement->exists($id)) {
            throw new NotFoundException(__('Invalid advertisement'));
        }
        $options = array('conditions' => array('Advertisement.' . $this->Advertisement->primaryKey => $id));
        $this->set('advertisement', $this->Advertisement->find('first', $options));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        if ($this->request->is('post')) {
            $this->Advertisement->create();
            if ($this->Advertisement->save($this->request->data)) {
                $this->Flash->success(__('The advertisement has been saved.'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->error(__('The advertisement could not be saved. Please, try again.'));
            }
        }
        $cities = $this->Advertisement->City->find('list');
        $pages = $this->Advertisement->Page->find('list');
        $this->set(compact('cities', 'pages'));
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        if (!$this->Advertisement->exists($id)) {
            throw new NotFoundException(__('Invalid advertisement'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if ($this->Advertisement->save($this->request->data)) {
                $this->Flash->success(__('The advertisement has been saved.'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->error(__('The advertisement could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Advertisement.' . $this->Advertisement->primaryKey => $id));
            $this->request->data = $this->Advertisement->find('first', $options);
        }
        $cities = $this->Advertisement->City->find('list');
        $pages = $this->Advertisement->Page->find('list');
        $this->set(compact('cities', 'pages'));
    }

    /**
     * delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function delete($id = null) {
        $this->Advertisement->id = $id;
        if (!$this->Advertisement->exists()) {
            throw new NotFoundException(__('Invalid advertisement'));
        }
        $this->request->allowMethod('post', 'delete');
        if ($this->Advertisement->delete()) {
            $this->Flash->success(__('The advertisement has been deleted.'));
        } else {
            $this->Flash->error(__('The advertisement could not be deleted. Please, try again.'));
        }
        return $this->redirect(array('action' => 'index'));
    }

    /**
     * admin_index method
     *
     * @return void
     */
    public function admin_index() {
        if ($this->request->is('ajax')) {
            $table = 'advertisements';
            $primaryKey = 'id';
            $columns = array(
                array('db' => '`ad`.`id`', 'dt' => 0, 'field' => 'id'),
                array('db' => '`ad`.`contact_name`', 'dt' => 1, 'field' => 'contact_name', 'as' => 'contact_name'),
                array('db' => '`ad`.`name`', 'dt' => 2, 'field' => 'name', 'as' => 'name'),
                array('db' => '`ad`.`description`', 'dt' => 3, 'field' => 'description', 'as' => 'description'),
                array('db' => '`City`.`name`', 'dt' => 4, 'field' => 'city_name', 'as' => 'city_name'),
                array('db' => '`Page`.`name`', 'dt' => 5, 'field' => 'page_name', 'as' => 'page_name'),
                array('db' => '`ad`.`created`', 'dt' => 6, 'field' => 'created', 'as' => 'created'),
                array('db' => '`ad`.`status`', 'dt' => 7, 'field' => 'status', 'as' => 'status'),
                array('db' => '`ad`.`url`', 'dt' => 8, 'field' => 'url', 'as' => 'url')
            );
            $joinQuery = "FROM `advertisements` AS `ad` LEFT JOIN `cities` AS `City` ON (`City`.`id` = `ad`.`city_id`) LEFT JOIN `advertisement_pages` AS `Page` ON (`Page`.`id` = `ad`.`page_id`)";
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
        if (!$this->Advertisement->exists($id)) {
            throw new NotFoundException(__('Invalid advertisement'));
        }
        $options = array('conditions' => array('Advertisement.' . $this->Advertisement->primaryKey => $id));
        $this->set('advertisement', $this->Advertisement->find('first', $options));
    }

    /**
     * admin_add method
     *
     * @return void
     */
    public function admin_add() {
        if ($this->request->is('post', 'put')) {

            /* For File Uploading functionality */
            if ($this->request->is('ajax')) {
                $file_data = $this->request->data['Advertisement']['attachments'];
                $allowed_file_width = intval($this->request->data['width']);
                $allowed_file_height = intval($this->request->data['height']);
                $allowed = array('bmp', 'gif', 'GIF', 'png', 'PNG', 'jpg', 'JPG', 'JPEG', 'jpeg');


                $extension = pathinfo($file_data['name'], PATHINFO_EXTENSION);
                if (!in_array(strtolower($extension), $allowed)) {
                    $file_data['error'] == 1;
                    $status_array = array('status' => 'error', 'textStatus' => 'Please upload a valid image.');
                    echo json_encode($status_array);
                    exit;
                }
                list($width, $height, $type, $attr) = getimagesize($file_data['tmp_name']);
                if (intval($width) > $allowed_file_width && intval($height) > $allowed_file_height) {
                    $status_array = array('status' => 'error', 'textStatus' => 'Please upload images of width ' . $allowed_file_width . 'px and height ' . $allowed_file_height . "px");
                    echo json_encode($status_array);
                    exit;
                }
                if (isset($file_data) && $file_data['error'] === 0) {
                    if (!file_exists(BANNER_ATTACHMENT_TMP_PATH)) {
                        mkdir(BANNER_ATTACHMENT_TMP_PATH, 0777, true);
                    }
                    $file_temp_name = mt_rand(9999, 99999) . md5($file_data['name'] . CakeText::uuid()) . "." . $extension;
                    if (move_uploaded_file($file_data['tmp_name'], BANNER_ATTACHMENT_TMP_PATH . DS . $file_temp_name)) {
                        $status_array = array('status' => 'success',
                            'tmp_name' => $file_temp_name,
                            'file_name' => $file_data['name'],
                            'file_url' => BANNER_ATTACHMENT_URL . "tmp/" . $file_temp_name,
                            'file_size' => number_format($file_data['size'] / 1024, 2) . ' KB');
                        echo json_encode($status_array);
                        exit;
                    }
                }

                echo json_encode(array('status' => 'error'));
                exit;
            }
            #pr($this->request->data);exit;
            if (!empty($this->request->data)) {
                $form_data = $this->request->data;
                unset($form_data['Advertisement']['attachments']);
                $image_name_array = explode('@', $form_data['Advertisement']['image']);
                $form_data['Advertisement']['image'] = $image_name_array[1];
                $form_data['Advertisement']['status'] = '1';
                if ($form_data['Advertisement']['schedule_type'] == 'Immediate') {
                    $form_data['Advertisement']['campaign_start'] = date('Y-m-d');
                } else {
                    $form_data['Advertisement']['campaign_start'] = $form_data['Advertisement']['campaign_range'];
                }

                unset($form_data['Advertisement']['campaign_range']);

                #pr($form_data);exit;
                $this->Advertisement->create();
                if ($this->Advertisement->save($form_data)) {
                    $last_id = $this->Advertisement->id;
                    $dest_path = BANNER_ATTACHMENT_PATH . DS . $last_id;
                    if (!file_exists($dest_path)) {
                        mkdir($dest_path, 0777, true);
                    }
                    $src_path = BANNER_ATTACHMENT_TMP_PATH . DS . $image_name_array[0];
                    if (copy($src_path, $dest_path . DS . $image_name_array[1])) {
                        unlink($src_path);
                    }
                    $this->Flash->success(__('The advertisement has been saved.'));
                } else {
                    $this->Flash->error(__('The advertisement could not be saved. Please, try again.'));
                }
                $this->redirect(array('action' => 'index'));
            }
        }
        $cities = $this->Advertisement->City->find('list', array('conditions' => array('City.business_status' => '1')));
        $pages = $this->Advertisement->AdvertisementPage->find('all');
        $pages_list = Hash::combine($pages, '{n}.AdvertisementPage.id', '{n}.AdvertisementPage.name');
        $pages_dimensions = json_encode(Hash::combine($pages, '{n}.AdvertisementPage.id', '{n}.AdvertisementPage.description'));
        $this->set(compact('cities', 'pages_list', 'pages_dimensions'));
    }

    public function admin_delete_banner($id = null) {
        $banner_tmp_name = trim($this->request->data['banner_tmp']);
        if (isset($this->request->data['ad_id']) && !empty($this->request->data['ad_id'])) {
            #echo BANNER_ATTACHMENT_PATH . $this->request->data['ad_id'] . DS . '*';
            $files = glob(BANNER_ATTACHMENT_PATH . $this->request->data['ad_id'] . DS . '*');
            $this->Advertisement->id = $this->request->data['ad_id'];
        } else {
            $files = glob(BANNER_ATTACHMENT_TMP_PATH . DS . '*');
        }
        #pr($files);exit;
        if (is_array($files) && !empty($files)) {
            foreach ($files as $file) {
                if (is_file($file)) {
                    if (unlink($file)) {
                        if (isset($this->request->data['ad_id']) && !empty($this->request->data['ad_id'])) {
                            $this->Advertisement->saveField('image', '');
                        }
                    }
                    $res = 'success';
                } else {
                    $res = 'error';
                }
            }
        } else {
            $res = 'error';
        }
        echo $res;
        exit;
    }

    /**
     * admin_edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_edit($id = null) {
        if ($this->request->is(array('post', 'put'))) {
            /* For File Uploading functionality */
            if ($this->request->is('ajax')) {
                $file_data = $this->request->data['Advertisement']['attachments'];
                $allowed_file_width = intval($this->request->data['width']);
                $allowed_file_height = intval($this->request->data['height']);
                $allowed = array('bmp', 'gif', 'GIF', 'png', 'PNG', 'jpg', 'JPG', 'JPEG', 'jpeg');


                $extension = pathinfo($file_data['name'], PATHINFO_EXTENSION);
                if (!in_array(strtolower($extension), $allowed)) {
                    $file_data['error'] == 1;
                    $status_array = array('status' => 'error', 'textStatus' => 'Please upload a valid image.');
                    echo json_encode($status_array);
                    exit;
                }
                list($width, $height, $type, $attr) = getimagesize($file_data['tmp_name']);
                if (intval($width) > $allowed_file_width && intval($height) > $allowed_file_height) {
                    $status_array = array('status' => 'error', 'textStatus' => 'Please upload images of width ' . $allowed_file_width . 'px and height ' . $allowed_file_height . "px");
                    echo json_encode($status_array);
                    exit;
                }
                if (isset($file_data) && $file_data['error'] === 0) {
                    if (!file_exists(BANNER_ATTACHMENT_TMP_PATH)) {
                        mkdir(BANNER_ATTACHMENT_TMP_PATH, 0777, true);
                    }
                    $file_temp_name = mt_rand(9999, 99999) . md5($file_data['name'] . CakeText::uuid()) . "." . $extension;
                    if (move_uploaded_file($file_data['tmp_name'], BANNER_ATTACHMENT_TMP_PATH . DS . $file_temp_name)) {
                        $status_array = array('status' => 'success',
                            'tmp_name' => $file_temp_name,
                            'file_name' => $file_data['name'],
                            'file_url' => BANNER_ATTACHMENT_URL . "tmp/" . $file_temp_name,
                            'file_size' => number_format($file_data['size'] / 1024, 2) . ' KB');
                        echo json_encode($status_array);
                        exit;
                    }
                }

                echo json_encode(array('status' => 'error'));
                exit;
            }
            if (!empty($this->request->data)) {
                $form_data = $this->request->data;
                unset($form_data['Advertisement']['attachments']);
                if (strpos($form_data['Advertisement']['image'], '###@###') === false) {
                    $old = true;
                    $form_data['Advertisement']['image'] = $form_data['Advertisement']['image'];
                } else {
                    $old = false;
                    $image_name_array = explode('###@###', $form_data['Advertisement']['image']);
                    $form_data['Advertisement']['image'] = $image_name_array[1];
                }
                $form_data['Advertisement']['status'] = '1';
                $this->Advertisement->create();
                if ($this->Advertisement->save($form_data)) {
                    if (!$old) {
                        $dest_path = BANNER_ATTACHMENT_PATH . DS . $form_data['Advertisement']['id'];
                        if (!file_exists($dest_path)) {
                            mkdir($dest_path, 0777, true);
                        }
                        $src_path = BANNER_ATTACHMENT_TMP_PATH . DS . $image_name_array[0];
                        if (copy($src_path, $dest_path . DS . $image_name_array[1])) {
                            unlink($src_path);
                        }
                    }
                    $this->Flash->success(__('The advertisement has been saved.'));
                } else {
                    $this->Flash->error(__('The advertisement could not be saved. Please, try again.'));
                }
                $this->redirect(array('action' => 'index'));
            }
        } else {
            $options = array('conditions' => array('Advertisement.' . $this->Advertisement->primaryKey => $id));
            $this->request->data = $this->Advertisement->find('first', $options);
            $this->request->data['Advertisement']['cpc_left'] = floor(intval($this->request->data['Advertisement']['budget_price']) / intval($this->request->data['Advertisement']['cost_per_view']));
            if (!empty($this->request->data['Advertisement']['image'])) {
                #$this->request->data['Advertisement']['image_url'] = HTTP_ROOT . "ad_banners/"  . $id . "/" . $this->request->data['Advertisement']['image'];
            }
        }
        $cities = $this->Advertisement->City->find('list', array('conditions' => array('City.business_status' => '1')));
        $pages = $this->Advertisement->AdvertisementPage->find('all');
        $pages_list = Hash::combine($pages, '{n}.AdvertisementPage.id', '{n}.AdvertisementPage.name');
        $pages_dimensions = json_encode(Hash::combine($pages, '{n}.AdvertisementPage.id', '{n}.AdvertisementPage.description'));
        $this->set(compact('cities', 'pages_list', 'pages_dimensions'));
    }

    /**
     * admin_delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_delete($id = null) {
        $this->Advertisement->id = $id;
        if (!$this->Advertisement->exists()) {
            throw new NotFoundException(__('Invalid advertisement'));
        }
        $this->request->allowMethod('post', 'delete');
        if ($this->Advertisement->delete()) {
            $this->Flash->success(__('The advertisement has been deleted.'));
        } else {
            $this->Flash->error(__('The advertisement could not be deleted. Please, try again.'));
        }
        return $this->redirect(array('action' => 'index'));
    }

    public function admin_tracking() {
        if ($this->request->is('ajax')) {
            $table = 'advertisement_trackings';
            $primaryKey = 'id';
            $columns = array(
                array('db' => '`ads`.`id`', 'dt' => 0, 'field' => 'id'),
                array('db' => '`ad`.`name`', 'dt' => 1, 'field' => 'ad_name', 'as' => 'ad_name'),
                array('db' => '`us`.`name`', 'dt' => 2, 'field' => 'user_name', 'as' => 'user_name'),
                array('db' => '`ads`.`server_agent`', 'dt' => 3, 'field' => 'agent', 'as' => 'agent'),
                array('db' => '`ads`.`ip`', 'dt' => 4, 'field' => 'ip_address', 'as' => 'ip_address'),
                array('db' => '`ads`.`visited_url`', 'dt' => 5, 'field' => 'url_address', 'as' => 'url_address'),
                array('db' => '`ads`.`created`', 'dt' => 6, 'field' => 'created', 'as' => 'created'),
                array('db' => '`ads`.`visited_url`', 'dt' => 7, 'field' => 'url', 'as' => 'url')
            );
            $joinQuery = "FROM `advertisement_trackings` AS `ads` LEFT JOIN `advertisements` AS `ad` ON (`ad`.`id` = `ads`.`advertisement_id`) LEFT JOIN `users` AS `us` ON (`us`.`id` = `ads`.`user_id`)";
            $extraWhere = "";

            App::uses('SSP', 'Utility');
            $response = SSP::simple($_GET, $this->db_config, $table, $primaryKey, $columns, $joinQuery, $extraWhere);
            print(json_encode($response));
            exit;
        }
    }

}
