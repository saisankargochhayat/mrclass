<?php

App::uses('AppController', 'Controller');
App::uses('SSP', 'Utility');

/**
 * BusinessGalleries Controller
 *
 * @property BusinessGallery $BusinessGallery
 * @property PaginatorComponent $Paginator
 */
class BusinessGalleriesController extends AppController {

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
        $this->BusinessGallery->recursive = 0;
        $this->set('businessGalleries', $this->Paginator->paginate());
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        if (!$this->BusinessGallery->exists($id)) {
            throw new NotFoundException(__('Invalid business gallery'));
        }
        $options = array('conditions' => array('BusinessGallery.' . $this->BusinessGallery->primaryKey => $id));
        $this->set('businessGallery', $this->BusinessGallery->find('first', $options));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        $this->loadModel('Business');
        $business_id = $this->request->params['pass'][0];
        $user_id = $this->Session->read('Auth.User.id');
        if (!$this->Business->hasAny(array('Business.id' => $business_id, 'Business.user_id' => $user_id))) {
            throw new NotFoundException(__('Invalid business'));
        }
        if ($this->request->is('post')) {
            $data = $this->request->data;
            $html = '';
            $save_data = array();
            if (is_array($data) && count($data) > 0) {
                $business_id = $data['BusinessGallery']['business_id'];
                $files = $data['BusinessGallery']['media'];
                if (is_array($files) && count($files) > 0 && $business_id > 0) {
                    $path = BUSINESS_GALLERY_DIR . $business_id . DS;
                    $url = BUSINESS_GALLERY_URL . $business_id . '/';
                    if (!is_dir($path)) {
                        mkdir($path, 0777, true);
                    }
                    $images = array();
                    foreach ($files as $key => $val) {

                        $filename = time() . "_" . mt_rand() . "_" . $this->Format->seo_url($val['name'], ' ');

                        move_uploaded_file($val['tmp_name'], $path . $filename);
                        $save_data[] = array(
                            'business_id' => $business_id,
                            'media' => $filename
                        );

                        $images[] = $filename;
                    }
                    $this->BusinessGallery->saveAll($save_data);
                    $post_ids = $this->BusinessGallery->inserted_ids;
                    $view = new View($this);
                    $format = $view->loadHelper('Format');
                    if (!empty($images)) {
                        foreach ($images as $image) {
                            $key = 0;
                            $image_src = $url . $image;
                            $html .= '<li id="image_li_' . mt_rand() . '" class="ui-sortable-handle relative effects">'
                                    . '<a class="image_delete anchor" data-id="' . $post_ids[$key] . '"></a>'
                                    . '<a class="image_link anchor"><img src="' . $format->gallery_image(array('media'=>$image),$business_id,200,200) . '" class="colorbox" rel="gal" data-href="'.$format->gallery_image(array('media'=>$image),$business_id,500,500).'" alt=""></a>'
                                    . '</li>';
                            $key++;
                        }
                    }
                }
            }
            echo $html;
            exit;
        }

        $options['conditions'] = array('Business.id' => $business_id);
        $business_list = $this->Format->get_business_list_business($business_id, $options);
        $option = array('conditions' => array('BusinessGallery.business_id' => $business_id, 'type' => 'image'));
        $gallery = $this->BusinessGallery->find('all', $option);
        $this->set('image_count', count($gallery));
        $this->set(compact('business_list', 'gallery'));
        $this->set(compact('business_id'));
        $this->set('subscription', SSP::get_subscription($this->Session->read('Auth.User.id')));
        $this->set('server_file_size', ini_get('max_file_uploads'));
    }

    /**
     * admin_add method
     *
     * @return void
     */
    public function admin_add() {
        if ($this->request->is('post')) {
            $data = $this->request->data;
            $html = '';
            $save_data = array();
            if (is_array($data) && count($data) > 0) {
                $business_id = $data['BusinessGallery']['business_id'];
                $files = $data['BusinessGallery']['media'];
                if (is_array($files) && count($files) > 0 && $business_id > 0) {
                    $path = BUSINESS_GALLERY_DIR . $business_id . DS;
                    $url = BUSINESS_GALLERY_URL . $business_id . '/';
                    if (!is_dir($path)) {
                        mkdir($path, 0777, true);
                    }
                    $images = array();
                    #pr($files)
                    foreach ($files as $key => $val) {

                        $filename = time() . "_" . mt_rand() . "_" . $this->Format->seo_url($val['name'], ' ');

                        move_uploaded_file($val['tmp_name'], $path . $filename);
                        $save_data[] = array(
                            'business_id' => $business_id,
                            'media' => $filename
                        );

                        $images[] = $filename;
                    }
                    $this->BusinessGallery->saveAll($save_data);
                    $post_ids = $this->BusinessGallery->inserted_ids;
                    $view = new View($this);
                    $format = $view->loadHelper('Format');
                    if (!empty($images)) {
                        foreach ($images as $key => $image) {
                            $image_src = $url . $image;
                            $shrt = $format->shortLength($image, 17, null, "bottom");
                            $size = $format->FileSizeConvert($image, $business_id);
                            $thumb = $format->path_gallery_image($image, $business_id, 191, 191);
                            $html .= '<li id="image_li_' . $post_ids[$key] . '" class="ui-sortable-handle">'
                                    . '<span class="mailbox-attachment-icon has-img"><a class="image_link anchor">'
                                    . '<img src="' . $thumb . '" alt="Attachment" style="height:191px;width:191px;"></a></span>'
                                    . '<div class="mailbox-attachment-info">'
                                    . '<a href="javascript:void(0)" class="mailbox-attachment-name"><i class="fa fa-file-image-o"></i>'
                                    . $shrt
                                    . '</a>'
                                    . '<span class="mailbox-attachment-size">'
                                    . $size
                                    . '<a href="javascript:void(0)" data-id="' . $post_ids[$key] . '" rel="tooltip" title="Click to delete" class="btn btn-default btn-xs pull-right image_delete"><i class="fa  fa-trash"></i></a></span>'
                                    . '</div>'
                                    . '</li>';
                        }
                    }
                }
            }

            echo $html;
            exit;
        }
        $business_id = $this->request->params['pass'][0];
        $this->set(compact('business_id'));
        $options['conditions'] = array('Business.id' => $business_id);
        $business_list = $this->Format->get_business_list_business($business_id, $options, 'list');
        $option = array('conditions' => array('BusinessGallery.business_id' => $business_id, 'BusinessGallery.type' => 'image'));
        $gallery = $this->BusinessGallery->find('all', $option);
        $this->set(compact('business_list', 'gallery'));

        $this->loadModel('Business');
        $business_data = $this->Business->findById($business_id);
        $this->set('subscription', SSP::get_subscription($business_data['Business']['user_id']));
        $this->set('server_file_size', ini_get('max_file_uploads'));
    }

    public function add_video_link() {
        $this->loadModel('Business');
        $business_id = isset($this->params['pass'][0]) ? $this->params['pass'][0] : "";
        $user_id = $this->Session->read('Auth.User.id');
        if (!$this->Business->hasAny(array('Business.id' => $business_id, 'Business.user_id' => $user_id))) {
            throw new NotFoundException(__('Invalid business'));
        }
        if ($this->request->is('post')) {
            $data = $this->request->data['BusinessGallery'];
            $ids = array();

            foreach ($data as $key => $value) {
                $save_data[] = array('business_id' => $value['business_id'],
                    'media' => $value['media'],
                    'type' => 'video',
                    'id' => isset($value['id']) && intval($value['id']) > 0 ? $value['id'] : '',
                    'video_id' => trim($this->Format->youtube_id_from_url($value['media']))
                );
                isset($value['id']) && intval($value['id']) > 0 ? array_push($ids, $value['id']) : "";
            }
            if ($business_id > 0) {
                $del_condition = array('BusinessGallery.type' => 'video', 'BusinessGallery.business_id' => $business_id, 'NOT' => array('BusinessGallery.id' => $ids));
                $this->BusinessGallery->deleteAll($del_condition);
            }
            if ($this->BusinessGallery->saveAll($save_data)) {
                $this->Flash->success(__('The business gallery data has been saved.'));
            } else {
                $this->Flash->error(__('The business gallery data could not be saved. Please, try again.'));
            }
            $this->redirect("/business-videos-" . $business_id . "-change");
        }
        $option['conditions'] = array('Business.id' => $business_id);
        $option['fields'] = array('Business.name');
        $option['recursive'] = 0;
        $business = $this->Format->get_business_list_business($business_id, $option, 'first');
        $option = array('conditions' => array('BusinessGallery.business_id' => $business_id, 'BusinessGallery.type' => 'video'));
        $galleries = $this->BusinessGallery->find('all', $option);
        $this->set(compact('galleries', 'business', 'business_id'));
        $this->set('subscription', SSP::get_subscription($this->Session->read('Auth.User.id')));
    }

    public function admin_add_video_link() {
        $business_id = isset($this->params['pass'][0]) ? $this->params['pass'][0] : "";
        if ($this->request->is('post')) {
            $data = $this->request->data['BusinessGallery'];
            $ids = array();
            foreach ($data as $key => $value) {
                $data[$key]['video_id'] = trim($this->Format->youtube_id_from_url($value['media']));
                isset($value['id']) && intval($value['id']) > 0 ? array_push($ids, $value['id']) : "";
            }
            if ($business_id > 0) {
                $del_condition = array('BusinessGallery.type' => 'video', 'BusinessGallery.business_id' => $business_id, 'NOT' => array('BusinessGallery.id' => $ids));
                $this->BusinessGallery->deleteAll($del_condition);
            }
            if ($this->BusinessGallery->saveAll($data)) {
                $this->Flash->AdminSuccess(__('The business gallery data has been saved.'));
            } else {
                $this->Flash->AdminError(__('The business gallery data could not be saved. Please, try again.'));
            }
            $this->redirect(array('action' => 'add_video_link', 'admin' => 1, $business_id, "vids"));
        }
        $option['conditions'] = array('Business.id' => $business_id);
        $option['fields'] = array('Business.name');
        $option['recursive'] = 0;
        $business = $this->Format->get_business_list_business($business_id, $option, 'first');
        $option = array('conditions' => array('BusinessGallery.business_id' => $business_id, 'BusinessGallery.type' => 'video'));
        $galleries = $this->BusinessGallery->find('all', $option);
        $this->set(compact('galleries', 'business', 'business_id'));

        $this->loadModel('Business');
        $business_data = $this->Business->findById($business_id);
        $this->set('subscription', SSP::get_subscription($business_data['Business']['user_id']));
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        if (!$this->BusinessGallery->exists($id)) {
            throw new NotFoundException(__('Invalid business gallery'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if ($this->BusinessGallery->save($this->request->data)) {
                $this->Flash->success(__('The business gallery has been saved.'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->error(__('The business gallery could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('BusinessGallery.' . $this->BusinessGallery->primaryKey => $id));
            $this->request->data = $this->BusinessGallery->find('first', $options);
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
        $this->layout = "ajax";
        $id = $this->request->data['id'];
        if ($id) {
            if ($this->BusinessGallery->delete($id)) {
                echo "Success";
            } else {
                echo "Error";
            }
        }
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
        $this->layout = "ajax";
        $id = $this->request->data['id'];
        if ($id) {
            if ($this->BusinessGallery->delete($id)) {
                echo "Success";
            } else {
                echo "Error";
            }
        }
        exit;
    }

}
