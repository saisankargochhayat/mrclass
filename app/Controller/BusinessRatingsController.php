<?php

App::uses('AppController', 'Controller');

/**
 * BusinessRatings Controller
 *
 * @property BusinessRating $BusinessRating
 * @property PaginatorComponent $Paginator
 */
class BusinessRatingsController extends AppController {

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
        $business_id = (isset($this->params['pass'][0])) ? $this->params['pass'][0] : "";
        $this->set('business_id', $business_id);
        #$this->BusinessRating->recursive = 0;
        $this->set('businessRatings', $this->BusinessRating->find('all', array('conditions' => array('BusinessRating.business_id' => $business_id))));

        $this->loadModel('Business');
        $option = array('conditions' => array('Business.id' => $business_id), 'fields' => array('Business.name'), 'recursive' => false);
        $business = $this->Business->find('first', $option);
        $this->set('business', $business['Business']['name']);
    }

    public function reviews() {
        $user_id = $this->Session->read('Auth.User.id');
        /* $options['fields'] = array('Business.id');
          $options['recursive'] = -1;
          $options['conditions'] = array('Business.status' => 1, 'Business.user_id' => $id);
          $business_list = $this->Format->get_business_list($id, $options, 'list'); */

        #$this->BusinessRating->recursive = 0;
        $params = array('conditions' => array('Business.status' => 1, 'Business.user_id' => $user_id));
        #'BusinessRating.business_id' => $business_list,'BusinessRating.user_id !=' => $id
        $params['fields'] = array('BusinessRating.*', 'Business.name', 'Business.id', 'User.name', 'User.id');
        $params['order'] = array('BusinessRating.id' => "DESC");
        $ratings = $this->BusinessRating->find('all', $params);
        #pr($ratings);exit;
        $this->set('ratings', $ratings);
    }

    public function my_reviews() {
        $user_id = $this->Session->read('Auth.User.id');

        /* $options['fields'] = array('Business.id');
          $options['recursive'] = -1;
          $business_list = $this->Format->get_business_list($id, $options, 'list'); */


        #$this->BusinessRating->unbindModel(array('belongsTo' => array('User')));
        #$params = array('conditions' => array('BusinessRating.business_id' => $business_list, 'BusinessRating.user_id' => $id));
        $params = array('conditions' => array('Business.status' => 1, 'BusinessRating.user_id' => $user_id));
        $params['fields'] = array('BusinessRating.*', 'Business.name', 'Business.id', 'User.name', 'User.id');
        $params['order'] = array('BusinessRating.id' => 'DESC');
        $ratings = $this->BusinessRating->find('all', $params);
        $this->set('ratings', $ratings);
        $this->recently_viewed_classes();
    }

    public function admin_all() {
        #$this->BusinessRating->recursive = 0;
        $params = array('order' => array('BusinessRating.status' => 'ASC', 'BusinessRating.id' => 'DESC'));
        $all_ratings = $this->BusinessRating->find('all', $params);
        $this->set('businessRatings', $all_ratings);
    }
    
    /**
     * index method
     *
     * @return void
     */
    public function index() {
        $this->BusinessRating->recursive = 0;
        $this->set('businessRatings', $this->BusinessRating->find('all'));
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        $this->layout = 'ajax';
        if (!$this->BusinessRating->exists($id)) {
            throw new NotFoundException(__('Invalid business rating'));
        }
        $options = array('conditions' => array('BusinessRating.' . $this->BusinessRating->primaryKey => $id));
        $this->set('review', $this->BusinessRating->find('first', $options));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        $this->loadModel('Business');
        if ($this->request->is('post')) {
            $id = '';
            $user_id = $this->Session->read('Auth.User.id');
            if ($user_id > 0) {
                $ajax = $this->request->data['ajax'];
                $data['BusinessRating'] = array(
                    'user_id' => $user_id,
                    'business_id' => $this->request->data['id'],
                    'rating' => $this->request->data['rate'],
                    'comment' => trim(urldecode($this->request->data['review'])),
                    'status' => 0,
                );
                $BusinessId = $data['BusinessRating']['business_id'];
                $business = $this->Business->find('first', array('conditions' => array('Business.id' => $BusinessId)));
                if (empty($business)) {
                    $success = 0;
                } elseif ($this->BusinessRating->hasAny(array('user_id' => $user_id, 'business_id' => $BusinessId))) {
                    $success = 0;
                    $message = __('You have already posted your review.');
                } else {
                    $this->BusinessRating->create();
                    if ($this->BusinessRating->save($data)) {
                        $id = $this->BusinessRating->id;
                        $message = __('Thank you for your review. It will be published after admin approval.');


                        $Email = new CakeEmail(Configure::read('EMAIL_DELIVERY_MODE'));
                        $Email->config(array('persistent' => true));

                        /* new review given to business email sent to business owner contact */
                        $Email->from(array(Configure::read('COMPANY.FROM_EMAIL') => Configure::read('COMPANY.NAME')));
                        $Email->viewVars(array('business' => $business, 'review' => $data['BusinessRating'], 'reviewed_by' => $this->Session->read('Auth.User.name')));
                        $Email->to($business['Business']['email']);
                        $Email->subject('New review for ' . $business['Business']['name'] . " - " . Configure::read('COMPANY.NAME'));
                        $Email->template('review_post');
                        $Email->send();


                        if (Configure::read('EMAIL_DELIVERY_MODE') == 'smtp') {
                            $Email->disconnect();
                        }

                        if ($ajax == '1') {
                            $success = 1;
                        } else {
                            $this->Flash->success($message);
                            return $this->redirect(array('action' => 'index'));
                        }
                    } else {
                        $message = __('The business rating could not be saved. Please, try again.');
                        if ($ajax == '1') {
                            $success = 0;
                        } else {
                            $this->Flash->error($message);
                        }
                    }
                }
            } else {
                if ($ajax == '1') {
                    $success = 0;
                    $message = __('Please login to post your review.');
                }
            }
            if ($ajax == '1') {
                echo json_encode(array('success' => $success, 'message' => $message, 'id' => $id));
                exit;
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
        $this->layout = 'ajax';
        if (!$this->BusinessRating->exists($id)) {
            throw new NotFoundException(__('Invalid business rating'));
        }
        if ($this->request->is(array('post', 'put'))) {
            $data = $this->request->data;
            $user_id = $this->Session->read('Auth.User.id');
            $id = $data['BusinessRating']['id'];

            $rating = $this->BusinessRating->find('first', array('conditions' => array('BusinessRating.id' => $id), 'fields' => array('BusinessRating.*'), 'recursive' => false));

            if (!$this->BusinessRating->hasAny(array('BusinessRating.id' => $id, 'BusinessRating.user_id' => $user_id))) {
                throw new NotFoundException(__('Invalid business rating'));
            }

            $data['BusinessRating']['comment'] = trim($data['BusinessRating']['comment']);
            $data['BusinessRating']['status'] = '0';

            if ($this->BusinessRating->save($data)) {
                $this->loadModel('Business');
                $BusinessId = $rating['BusinessRating']['business_id'];
                $business = $this->Business->find('first', array('conditions' => array('Business.id' => $BusinessId), 'fields' => array('Business.*'), 'recursive' => false));

                $Email = new CakeEmail(Configure::read('EMAIL_DELIVERY_MODE'));
                $Email->config(array('persistent' => true));

                /* new review given to business email sent to business owner contact */
                $Email->from(array(Configure::read('COMPANY.FROM_EMAIL') => Configure::read('COMPANY.NAME')));
                $Email->viewVars(array('business' => $business, 'review' => $data['BusinessRating'], 'reviewed_by' => $this->Session->read('Auth.User.name'), 'mode' => 'update'));
                $Email->to($business['Business']['email']);
                $Email->subject('Review modified for ' . $business['Business']['name'] . " - " . Configure::read('COMPANY.NAME'));
                $Email->template('review_post');
                $Email->send();


                if (Configure::read('EMAIL_DELIVERY_MODE') == 'smtp') {
                    $Email->disconnect();
                }

                $this->Flash->success(__('The business rating saved successfully. It will be published after admin approval.'));
                #return $this->redirect(array('action' => 'index'));
                return $this->redirect(array('action' => 'my_reviews'));
            } else {
                $this->Flash->error(__('The business rating could not be saved. Please try again.'));
            }
        } else {
            $options = array('conditions' => array('BusinessRating.' . $this->BusinessRating->primaryKey => $id));
            $this->request->data = $this->BusinessRating->find('first', $options);
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
        $this->BusinessRating->id = $id;
        if (!$this->BusinessRating->exists()) {
            throw new NotFoundException(__('Invalid business rating'));
        }
        $this->request->allowMethod('post', 'delete');
        if ($this->BusinessRating->delete()) {
            #$this->Flash->success(__('The business rating has been deleted.'));
            $message = __('The business rating has been deleted.');
            $success = 1;
        } else {
            #$this->Flash->error(__('The business rating could not be deleted. Please, try again.'));
            $message = __('The business rating could not be deleted. Please, try again.');
            $success = 0;
        }
        echo json_encode(array('message' => $message, 'success' => $success));
        exit;
        return $this->redirect(array('action' => 'index'));
    }

    /**
     * admin_view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_view($id = null) {
        if (!$this->BusinessRating->exists($id)) {
            throw new NotFoundException(__('Invalid business rating'));
        }
        $options = array('conditions' => array('BusinessRating.' . $this->BusinessRating->primaryKey => $id));
        $this->set('businessRating', $this->BusinessRating->find('first', $options));
    }

    /**
     * admin_add method
     *
     * @return void
     */
    public function admin_add() {
        if ($this->request->is('post')) {
            $this->BusinessRating->create();
            if ($this->BusinessRating->save($this->request->data)) {
                $this->Flash->success(__('The business rating has been saved.'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->error(__('The business rating could not be saved. Please, try again.'));
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
        $id = $this->request->data['id'];
        if (!$this->BusinessRating->exists($id)) {
            echo __('Invalid business rating');
            exit;
        }
        $options = array('conditions' => array('BusinessRating.' . $this->BusinessRating->primaryKey => $id));
        $data = $this->BusinessRating->find('first', $options);
        print (json_encode($data));
        exit;
    }

    /**
     * admin_delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_delete($id = null, $business_id = null, $extra_param = null) {
        #pr($this->request);exit;
        $this->BusinessRating->id = $id;
        if (!$this->BusinessRating->exists()) {
            throw new NotFoundException(__('Invalid business rating'));
        }
        if ($this->BusinessRating->delete()) {
            $this->Flash->AdminSuccess(__('The business rating has been deleted.'));
        } else {
            $this->Flash->AdminError(__('The business rating could not be deleted. Please, try again.'));
        }
        if (!empty($extra_param)) {
            return $this->redirect(array('action' => 'index', 'admin' => 1, $business_id, $extra_param));
        } else {
            return $this->redirect(array('action' => 'all', 'admin' => 1));
        }
    }

    public function admin_grant_rating($id = null, $business_id = null, $extra_param = null) {
        $this->BusinessRating->id = $id;
        if ($this->BusinessRating->exists()) {
            $statusData = $this->BusinessRating->find('first', array('conditions' => array('BusinessRating.id' => $id)));
            $rating_status_val = (intval($statusData['BusinessRating']['status']) == 1) ? 0 : 1;
            $rating_status_msg = (intval($statusData['BusinessRating']['status']) == 1) ? 'Rating Disabled' : 'Rating Enabled';
            $redirect_array = ($extra_param == 'all') ? array('action' => 'all', 'admin' => 1) : array('action' => 'index', 'admin' => 1, $business_id, $extra_param);
            if ($this->BusinessRating->saveField('status', $rating_status_val)) {
                
                if ($rating_status_val) {
                    /* load email config class and keep the conenection open untill all mails are sent */
                    $Email = new CakeEmail(Configure::read('EMAIL_DELIVERY_MODE'));
                    $Email->config(array('persistent' => true));

                    /* email to user */
                    $Email->from(array(Configure::read('COMPANY.FROM_EMAIL') => Configure::read('COMPANY.NAME')));
                    $Email->viewVars(array('for' => 'user', 'name' => $statusData['User']['name'], 'businessName' => $statusData['Business']['name'], 'created' => $statusData['BusinessRating']['created']));
                    $Email->to($statusData['User']['email']);
                    $Email->subject('Review for ' . $statusData['Business']['name'] . ' is approved - ' . Configure::read('COMPANY.NAME'));
                    $Email->template('review_approval');
                    $Email->send();


                    /* Disconnect email connection */
                    if (Configure::read('EMAIL_DELIVERY_MODE') == 'smtp') {
                        $Email->disconnect();
                    }
                }
                $this->Flash->AdminSuccess(__($rating_status_msg));
            } else {
                $this->Flash->AdminError(__('Operation Failed.'));
            }
        } else {
            $this->Flash->AdminError(__('Invalid Rating'));
        }
        $this->redirect($redirect_array);
    }

    /**
     * Used for approving the reviews from users
     * in users section on business dashboard and
     * sending mail to admin and Reviewed user on 
     * approval
     * @param type review $id 
     * @return type null
     */
    public function grant_reviews($id = null) {
        $this->layout = 'ajax';
        $this->BusinessRating->id = $id;
        if ($this->BusinessRating->exists()) {
            $statusData = $this->BusinessRating->find('first', array('conditions' => array('BusinessRating.id' => $id)));
            $rating_status_val = (intval($statusData['BusinessRating']['status']) == 1) ? 0 : 1;
            $rating_status_msg = (intval($statusData['BusinessRating']['status']) == 1) ? 'Review disapproved.' : 'Review approved.';
            if ($this->BusinessRating->saveField('status', $rating_status_val)) {
                if ($rating_status_val) {
                    /* load email config class and keep the conenection open untill all mails are sent */
                    $Email = new CakeEmail(Configure::read('EMAIL_DELIVERY_MODE'));
                    $Email->config(array('persistent' => true));

                    /* email to user */
                    $Email->from(array(Configure::read('COMPANY.FROM_EMAIL') => Configure::read('COMPANY.NAME')));
                    $Email->viewVars(array('for' => 'user', 'name' => $statusData['User']['name'], 'businessName' => $statusData['Business']['name'], 'created' => $statusData['BusinessRating']['created']));
                    $Email->to($statusData['User']['email']);
                    $Email->subject('Review for ' . $statusData['Business']['name'] . ' is approved - ' . Configure::read('COMPANY.NAME'));
                    $Email->template('review_approval');
                    $Email->send();

                    /* email to admin */
                    $Email->from(array(Configure::read('COMPANY.FROM_EMAIL') => Configure::read('COMPANY.NAME')));
                    $Email->viewVars(array('for' => 'admin', 'name' => $statusData['User']['name'], 'businessName' => $statusData['Business']['name'], 'created' => $statusData['BusinessRating']['created']));
                    $Email->to(Configure::read('COMPANY.ADMIN_EMAIL'));
                    $Email->subject('Review for ' . $statusData['Business']['name'] . ' is approved by business owner - ' . Configure::read('COMPANY.NAME'));
                    $Email->template('review_approval');
                    $Email->send();

                    /* Disconnect email connection */
                    if (Configure::read('EMAIL_DELIVERY_MODE') == 'smtp') {
                        $Email->disconnect();
                    }
                }
                $this->Flash->Success(__($rating_status_msg));
                #echo "<script>$.colorbox.close();window.location.reload()</script>";exit;
                $this->redirect(array('action' => 'reviews'));
            } else {
                $this->Flash->Error(__('Operation Failed.'));
            }
        } else {
            $this->Flash->Error(__('Invalid Review'));
        }
        $this->redirect(array('action' => 'reviews'));
    }

    public function admin_save_rating_content() {
        if ($this->request->is('post')) {
            $business_id = $this->request->data['BusinessRating']['business_id'];
            $param_text = (isset($this->request->data['BusinessRating']['param_text']) && !empty($this->request->data['BusinessRating']['param_text'])) ? $this->request->data['BusinessRating']['param_text'] : "";
            unset($this->request->data['BusinessRating']['param_text']);
            $redirect_array = ($param_text == 'from_all') ? array('action' => 'all', 'admin' => 1) : array('action' => 'index', 'admin' => 1, $business_id, $param_text);

            unset($this->request->data['BusinessRating']['business_id']);
            $this->request->data['BusinessRating']['comment'] = trim($this->request->data['BusinessRating']['comment']);
            $this->BusinessRating->create();
            if ($this->BusinessRating->saveAll($this->request->data)) {
                $this->Flash->AdminSuccess(__('The business rating has been saved.'));
            } else {
                $this->Flash->AdminError(__('The business rating could not be saved. Please, try again.'));
            }
            $this->redirect($redirect_array);
        }
    }

    function reviews_info($id = '') {
        $this->layout = 'ajax';
        $params['conditions'] = array('BusinessRating.id' => $id);
        $params['fields'] = array('BusinessRating.*', 'Business.name', 'Business.id', 'User.name', 'User.id');
        $review = $this->BusinessRating->find('first', $params);
        #pr($review);exit;
        $this->set(compact('review'));
    }

    function reply($rating_id) {
        $this->layout = 'ajax';
        $this->loadModel('BusinessRatingReply');
        if ($this->request->is(array('post', 'put'))) {
            $data = $this->request->data;
            $id = intval($data['BusinessRatingReply']['id']);
            $user_id = $this->Session->read('Auth.User.id');

            if (!$this->BusinessRatingReply->exists($id)) {
                $data['BusinessRatingReply']['user_id'] = $user_id;
                $data['BusinessRatingReply']['rating_id'] = $rating_id;
            }
            #$res = $this->BusinessRatingReply->find("all", array("conditions" => array('BusinessRatingReply.id' => $id, 'BusinessRatingReply.user_id' => $user_id)));
            if ($id > 0 && !$this->BusinessRatingReply->hasAny(array('BusinessRatingReply.id' => $id, 'BusinessRatingReply.user_id' => $user_id))) {
                throw new NotFoundException(__('Invalid business review'));
            }

            $data['BusinessRatingReply']['comment'] = trim($data['BusinessRatingReply']['comment']);
            if ($this->BusinessRatingReply->save($data)) {
                $rating = $this->BusinessRating->find('first', array('conditions' => array('BusinessRating.id' => $id), 'fields' => array('BusinessRating.*', 'User.*')));

                $this->loadModel('Business');
                $BusinessId = $rating['BusinessRating']['business_id'];
                $business = $this->Business->find('first', array('conditions' => array('Business.id' => $BusinessId), 'fields' => array('Business.*'), 'recursive' => false));

                $Email = new CakeEmail(Configure::read('EMAIL_DELIVERY_MODE'));
                $Email->config(array('persistent' => true));

                /* new review given to business email sent to review posted user */
                $Email->from(array(Configure::read('COMPANY.FROM_EMAIL') => Configure::read('COMPANY.NAME')));
                $Email->viewVars(array('business' => $business, 'reviewed_by' => $this->Session->read('Auth.User.name'),
                    'username' => $rating['User']['name'], 'comment' => $data['BusinessRatingReply']['comment']));
                $Email->to($rating['User']['email']);
                $Email->subject('Reply given on your review for ' . $business['Business']['name'] . " - " . Configure::read('COMPANY.NAME'));
                $Email->template('review_reply');
                $Email->send();


                if (Configure::read('EMAIL_DELIVERY_MODE') == 'smtp') {
                    $Email->disconnect();
                }

                $this->Flash->success(__('Reply to review saved successfully.'));
                return $this->redirect(array('action' => 'reviews'));
            } else {
                $this->Flash->error(__('The business rating could not be saved. Please try again.'));
            }
        } else {
            $options = array('conditions' => array('BusinessRating.id' => $rating_id));
            $review = $this->BusinessRating->find('first', $options);
            $this->set(compact('review'));
            $options = array('conditions' => array('BusinessRatingReply.rating_id' => $rating_id));
            $this->request->data = $this->BusinessRatingReply->find('first', $options);
        }
    }

}
