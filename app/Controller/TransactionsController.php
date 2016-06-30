<?php

App::uses('AppController', 'Controller');

/**
 * Transactions Controller
 *
 * @property Transaction $Transaction
 * @property PaginatorComponent $Paginator
 * @property FlashComponent $Flash
 */
class TransactionsController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public function beforeFilter() {
        $this->Auth->allow(array('admin_print_invoice'));
        parent::beforeFilter();
    }

    public function index($sub_id = null) {
        $options['joins'] = array(
            array('table' => 'users', 'alias' => 'User', 'type' => 'LEFT', 'conditions' => array('User.id=Transaction.user_id')),
            array('table' => 'subscriptions', 'alias' => 'Subscription', 'type' => 'LEFT', 'conditions' => array('Subscription.id=Transaction.subscription_id'))
        );
        $options['fields'] = array('Transaction.*', 'Subscription.*', 'User.*');
        $options['order'] = array('Transaction.id Desc');
        $options['conditions'] = array('Transaction.subscription_id' => $sub_id);
        $transaction_data = $this->Transaction->find('all', $options);
        $this->set('transactions', $transaction_data);
    }

    /**
     * admin_index method
     *
     * @return void
     */
    public function admin_index($id = null, $sub_id = null) {
        $this->loadModel('User');
        if (!$this->User->exists($id)) {
            throw new NotFoundException(__('Invalid user'));
        }
        $options['joins'] = array(
            array('table' => 'subscriptions', 'alias' => 'Subscription', 'type' => 'LEFT', 'conditions' => array('Subscription.id=Transaction.subscription_id')),
            array('table' => 'users', 'alias' => 'User', 'type' => 'LEFT', 'conditions' => array('User.id=Transaction.user_id')),
        );
        $options['fields'] = array('Transaction.*', 'Subscription.id', 'Subscription.name', 'Subscription.status', 'User.id');
        $options['conditions'] = array('Transaction.user_id' => $id);
        $options['order'] = array('Transaction.id Desc');
        $options['recursive'] = 1;
        $transaction_data = $this->Transaction->find('all', $options);
        #pr($transaction_data);exit;
        $this->set('transaction_data', $transaction_data);
        $this->set('subscription_id', $sub_id);
        $this->set('user_data', $this->User->findById($id));
    }

    public function admin_all_transactions() {
        $options['joins'] = array(
            array('table' => 'subscriptions', 'alias' => 'Subscription', 'type' => 'LEFT', 'conditions' => array('Subscription.id=Transaction.subscription_id')),
            array('table' => 'users', 'alias' => 'User', 'type' => 'LEFT', 'conditions' => array('User.id=Transaction.user_id')),
        );
        $options['fields'] = array('Transaction.*', 'Subscription.*', 'User.*');
        $options['order'] = array('Transaction.id Desc');
        $options['recursive'] = 1;
        $transaction_data = $this->Transaction->find('all', $options);
        $this->set('transaction_data', $transaction_data);
    }

    /**
     * admin_view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_view($id = null, $user_id = null, $sub_id = null) {
        $userid = $user_id;
        $subid = $sub_id;
        if (!$this->Transaction->exists($id)) {
            throw new NotFoundException(__('Invalid transaction'));
        }
        $options = array('conditions' => array('Transaction.' . $this->Transaction->primaryKey => $id));
        $options['joins'] = array(
            array('table' => 'subscriptions', 'alias' => 'Subscription', 'type' => 'LEFT', 'conditions' => array('Subscription.id=Transaction.subscription_id')),
            array('table' => 'users', 'alias' => 'User', 'type' => 'LEFT', 'conditions' => array('User.id=Transaction.user_id'))
        );
        $options['fields'] = array('Transaction.*', 'Subscription.*', 'User.*');
        $this->set('transaction', $this->Transaction->find('first', $options));
        $this->set(compact('userid', 'subid'));
    }

    public function view($trans_id = null) {
        if (!$this->Transaction->exists($trans_id)) {
            throw new NotFoundException(__('Invalid transaction'));
        }
        $options['joins'] = array(
            array('table' => 'subscriptions', 'alias' => 'Subscription', 'type' => 'LEFT', 'conditions' => array('Subscription.id=Transaction.subscription_id')),
        );
        $options['fields'] = array('Transaction.*', 'Subscription.*');
        $options['conditions'] = array('Transaction.' . $this->Transaction->primaryKey => $trans_id);
        $this->set('transaction_data', $this->Transaction->find('first', $options));
    }

    /**
     * admin_add method
     *
     * @return void
     */
    public function admin_add($id = null, $sub_id = null) {
        if ($this->request->is('post')) {
            $form_data = $this->request->data;
            $this->request->data['Transaction']['issued_date'] = date('Y-m-d', strtotime(str_replace('/', '-', $this->request->data['Transaction']['issued_date'])));
            $this->request->data['Transaction']['user_id'] = $this->request->data['Transaction']['user'];
            $user_id = $this->request->data['Transaction']['user_id'];
            $this->request->data['Transaction']['user_detail'] = $this->User->user_details($user_id);

            unset($this->request->data['Transaction']['user']);
            pr($this->request->data);
            exit;
            $this->Transaction->create();
            if ($this->Transaction->save($this->request->data)) {
                $this->Flash->AdminSuccess(__('The transaction has been saved.'));
            } else {
                $this->Flash->AdminError(__('The transaction could not be saved. Please try again..'));
            }
            $this->redirect(array("controller" => "transactions", "action" => "index", "admin" => 1, $form_data['Transaction']['user'], $sub_id));
        }
        $this->set('users', $this->Format->get_users());
        $this->set('modes', array("Cheque" => "Cheque", "Cash" => "Cash", "E-transfer" => "E-transfer"));
        $type = $this->Transaction->getColumnType('status');
        preg_match_all("/'(.*?)'/", $type, $enums);
        foreach ($enums[1] as $key => $val) {
            $status_arr[$val] = $val;
        }
        $this->set('status', $status_arr);
        $this->set('user_id', $id);
        $this->set('subscription_id', $sub_id);
    }

    /**
     * admin_edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_edit($id = null) {
        if (!$this->Transaction->exists($id)) {
            throw new NotFoundException(__('Invalid transaction'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if ($this->Transaction->save($this->request->data)) {
                return $this->flash(__('The transaction has been saved.'), array('action' => 'index'));
            }
        } else {
            $options = array('conditions' => array('Transaction.' . $this->Transaction->primaryKey => $id));
            $this->request->data = $this->Transaction->find('first', $options);
        }
        $users = $this->Transaction->User->find('list');
        $this->set(compact('users'));
    }

    /**
     * admin_delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_delete($id = null, $user_id = null, $sub_id = null) {
        $this->Transaction->id = $id;
        if (!$this->Transaction->exists()) {
            throw new NotFoundException(__('Invalid transaction'));
        }
        if ($this->Transaction->delete()) {
            $this->Flash->AdminSuccess(__('The transaction has been deleted.'));
        } else {
            $this->Flash->AdminError(__('The transaction could not be deleted. Please, try again.'));
        }
        if ($user_id && $sub_id) {
            $this->redirect(array('action' => 'admin_index', 'admin' => 1, $user_id, $sub_id));
        } else {
            $this->redirect(array('action' => 'admin_all_transactions', 'admin' => 1));
        }
    }

    public function admin_get_transaction_status() {
        $type = $this->Transaction->getColumnType('status');
        preg_match_all("/'(.*?)'/", $type, $enums);
        print(json_encode($enums[0]));
        exit;
    }

    public function admin_change_status() {
        if ($this->request->data) {
            $data = $this->request->data;
            $this->Transaction->id = $data['pk'];
            if ($this->Transaction->saveField($data['name'], trim($data['value']))) {
                $resp = array('success' => 1, 'responseText' => 'Status changed.');
            } else {
                $resp = array('success' => 0, 'responseText' => 'Status couldn\'t be changed.');
            }
        } else {
            $resp = array('success' => 0, 'responseText' => 'Invalid request.');
        }
        print(json_encode($resp));
        exit;
    }

    public function admin_invoice($id = null) {
        $this->Transaction->id = $id;
        if (!$this->Transaction->exists()) {
            throw new NotFoundException(__('Invalid transaction'));
        }
        $this->loadModel('Business');


        $options['joins'] = array(
            array('table' => 'packages', 'alias' => 'Package', 'type' => 'LEFT', 'conditions' => array('Package.id=Transaction.package_id')),
            array('table' => 'users', 'alias' => 'User', 'type' => 'LEFT', 'conditions' => array('User.id=Transaction.user_id')),
            array('table' => 'cities', 'alias' => 'City', 'type' => 'LEFT', 'conditions' => array('City.id=User.city')),
            array('table' => 'subscriptions', 'alias' => 'Subscription', 'type' => 'LEFT', 'conditions' => array('Subscription.id=Transaction.subscription_id'))
        );
        $options['fields'] = array('Transaction.*', 'Package.*', 'User.id', 'User.name', 'User.email', 'User.phone', 'User.status', 'City.name', 'Subscription.*');
        $options['order'] = array('Transaction.id' => 'desc');
        $options['conditions'] = array('Transaction.id' => $id);
        $transaction_data = $this->Transaction->find('first', $options);
        $transaction_data['price_array'] = $this->Format->price_calculation(json_decode($transaction_data['Subscription']['offer'], true), $transaction_data['Subscription']['price']);

        $option['conditions'] = array('Business.user_id' => $transaction_data['Transaction']['user_id']);
        $option['recursive'] = false;
        $option['fields'] = array('Business.name', 'Business.address', 'Business.landmark', 'Business.pincode', 'Business.email', 'Business.phone', 'Locality.name', 'City.name');
        $business_data = $this->Business->find('first', $option);

        if (empty($transaction_data['Transaction']['invoice_number'])) {
            $invoice_number = $this->Format->invoice_number($transaction_data['Transaction']['id'], date("Ym"));
            $this->Transaction->id = $transaction_data['Transaction']['id'];
            $this->Transaction->saveField('invoice_number', $invoice_number, false);
            $transaction_data['Transaction']['invoice_number'] = $invoice_number;
        }
        if (empty($transaction_data['Transaction']['user_detail'])) {
            $user_detail = array();
            #$this->Transaction->id = $transaction_data['Transaction']['id'];
            #$this->Transaction->saveField('user_detail', $user_detail, false);
            $transaction_data['Transaction']['user_detail'] = $user_detail;
        }
        if (empty($transaction_data['Transaction']['admin_detail'])) {
            $admin_detail = array();
            #$this->Transaction->id = $transaction_data['Transaction']['id'];
            #$this->Transaction->saveField('admin_detail', $admin_detail, false);
            $transaction_data['Transaction']['admin_detail'] = $admin_detail;
        }

        $this->set('businesses', $business_data);
        $this->set('transactions', $transaction_data);
        #pr($transaction_data);exit;
    }

    public function admin_print_invoice($id = null, $mode = '') {
        $this->Transaction->id = $id;
        if (!$this->Transaction->exists()) {
            throw new NotFoundException(__('Invalid transaction'));
        }
        $options['joins'] = array(
            array('table' => 'packages', 'alias' => 'Package', 'type' => 'LEFT', 'conditions' => array('Package.id=Transaction.package_id')),
            array('table' => 'users', 'alias' => 'User', 'type' => 'LEFT', 'conditions' => array('User.id=Transaction.user_id')),
            array('table' => 'cities', 'alias' => 'City', 'type' => 'LEFT', 'conditions' => array('City.id=User.city')),
            array('table' => 'subscriptions', 'alias' => 'Subscription', 'type' => 'LEFT', 'conditions' => array('Subscription.id=Transaction.subscription_id'))
        );
        $options['fields'] = array('Transaction.*', 'Package.*', 'User.id', 'User.name', 'User.email', 'User.phone', 'User.status', 'City.name', 'Subscription.*');
        $options['order'] = array('Transaction.id' => 'desc');
        $options['conditions'] = array('Transaction.id' => $id);
        $transaction_data = $this->Transaction->find('first', $options);
        $transaction_data['price_array'] = $this->Format->price_calculation(json_decode($transaction_data['Subscription']['offer'], true), $transaction_data['Subscription']['price']);

        $this->loadModel('Business');
        $option['conditions'] = array('Business.user_id' => $transaction_data['Transaction']['user_id']);
        $option['recursive'] = false;
        $option['fields'] = array('Business.name', 'Business.address', 'Business.landmark', 'Business.pincode', 'Business.email', 'Business.phone', 'Locality.name', 'City.name');
        $business_data = $this->Business->find('first', $option);
        $this->set('businesses', $business_data);

        $this->set('transactions', $transaction_data);
        $this->set('mode', $mode);
    }

    public function admin_generate_pdf($id = null, $invoice_no = null) {
        $this->Transaction->id = $id;
        if (!$this->Transaction->exists()) {
            throw new NotFoundException(__('Invalid transaction'));
        }
        $options['joins'] = array(
            array('table' => 'users', 'alias' => 'User', 'type' => 'LEFT', 'conditions' => array('User.id=Transaction.user_id')),
        );
        $options['fields'] = array('Transaction.*', 'User.id', 'User.name');
        $options['conditions'] = array('Transaction.id' => $id);
        $transaction_data = $this->Transaction->find('first', $options);

        $user_id = $transaction_data['User']['id'];
        $user_name = $this->Format->seo_url($transaction_data['User']['name']);

        #$filename = 'invoice_' . $user_name . '-' . $id . '.pdf';
        $filename = 'invoice_' . $user_name . '_' . date("Ymd") . '.pdf';
        $invoice_dir = HTTP_INVOICE_PATH;
        $invoice_dir_user = $invoice_dir . $user_id . DS;
        $filepath = $invoice_dir_user . $filename;

        if (!is_dir($invoice_dir_user)) {
            @mkdir($invoice_dir_user);
        }
        if (file_exists($filepath)) {
            @unlink($filepath);
        }

        $url = Router::url(array('action' => 'print_invoice', 'admin' => 1, $id), true);
        #echo shell_exec(PDF_LIB_PATH . ' ' . $url . ' ' . $filepath);
        #echo PDF_LIB_PATH . ' ' . $url . ' ' . $filepath;
        exec(PDF_LIB_PATH . ' ' . $url . ' ' . $filepath, $output, $return_var);
        #pr($output);pr($return_var);exit;

        header("Content-Type: application/octet-stream");
        header("Content-Disposition: attachment; filename=" . $filename);
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header("Content-Description: File Transfer");
        header("Content-Length: " . filesize($filepath));
        flush();
        $fp = fopen($filepath, "r");
        while (!feof($fp)) {
            echo fread($fp, 65536);
            flush();
        }
        fclose($fp);
    }

    public function generate_pdf($id = null, $invoice_no = null) {
        $this->Transaction->id = $id;
        if (!$this->Transaction->exists()) {
            throw new NotFoundException(__('Invalid transaction'));
        }
        $options['joins'] = array(
            array('table' => 'users', 'alias' => 'User', 'type' => 'LEFT', 'conditions' => array('User.id=Transaction.user_id')),
        );
        $options['fields'] = array('Transaction.*', 'User.id', 'User.name');
        $options['conditions'] = array('Transaction.id' => $id);
        $transaction_data = $this->Transaction->find('first', $options);
        $user_id = $transaction_data['User']['id'];
        $user_name = $this->Format->seo_url($transaction_data['User']['name']);

        $filename = 'invoice_' . $user_name . '-' . $id . '.pdf';
        $invoice_dir = HTTP_INVOICE_PATH;
        $invoice_dir_user = $invoice_dir . DS . "" . $user_id;
        $filepath = HTTP_INVOICE_PATH . '' . $user_id . DS . $filename;

        if (!is_dir($invoice_dir_user)) {
            mkdir($invoice_dir_user);
        }


        if (!file_exists($filepath)) {
            $url = Router::url(array('action' => 'print_invoice', 'admin' => 1, $id), true);
            #echo shell_exec(PDF_LIB_PATH . ' ' . $url . ' ' . $filepath);
            exec(PDF_LIB_PATH . ' ' . $url . ' ' . $filepath);
        }
        header("Content-Type: application/octet-stream");
        header("Content-Disposition: attachment; filename=" . $filename);
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header("Content-Description: File Transfer");
        header("Content-Length: " . filesize($filepath));
        flush();
        $fp = fopen($filepath, "r");
        while (!feof($fp)) {
            echo fread($fp, 65536);
            flush();
        }
        fclose($fp);
    }

}
