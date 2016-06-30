<?php

App::uses('AppController', 'Controller');

/**
 * PackageDiscounts Controller
 *
 * @property PackageDiscount $PackageDiscount
 * @property PaginatorComponent $Paginator
 * @property FlashComponent $Flash
 */
class PackageDiscountsController extends AppController {

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
        $this->PackageDiscount->recursive = 0;
        $this->set('packageDiscounts', $this->Paginator->paginate());
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        if (!$this->PackageDiscount->exists($id)) {
            throw new NotFoundException(__('Invalid package discount'));
        }
        $options = array('conditions' => array('PackageDiscount.' . $this->PackageDiscount->primaryKey => $id));
        $this->set('packageDiscount', $this->PackageDiscount->find('first', $options));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        if ($this->request->is('post')) {
            $this->PackageDiscount->create();
            if ($this->PackageDiscount->save($this->request->data)) {
                return $this->flash(__('The package discount has been saved.'), array('action' => 'index'));
            }
        }
        $packages = $this->PackageDiscount->Package->find('list');
        $this->set(compact('packages'));
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        if (!$this->PackageDiscount->exists($id)) {
            throw new NotFoundException(__('Invalid package discount'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if ($this->PackageDiscount->save($this->request->data)) {
                return $this->flash(__('The package discount has been saved.'), array('action' => 'index'));
            }
        } else {
            $options = array('conditions' => array('PackageDiscount.' . $this->PackageDiscount->primaryKey => $id));
            $this->request->data = $this->PackageDiscount->find('first', $options);
        }
        $packages = $this->PackageDiscount->Package->find('list');
        $this->set(compact('packages'));
    }

    /**
     * delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function delete($id = null) {
        $this->PackageDiscount->id = $id;
        if (!$this->PackageDiscount->exists()) {
            throw new NotFoundException(__('Invalid package discount'));
        }
        $this->request->allowMethod('post', 'delete');
        if ($this->PackageDiscount->delete()) {
            return $this->flash(__('The package discount has been deleted.'), array('action' => 'index'));
        } else {
            return $this->flash(__('The package discount could not be deleted. Please, try again.'), array('action' => 'index'));
        }
    }

    /**
     * admin_index method
     *
     * @return void
     */
    public function admin_index() {
        $this->PackageDiscount->recursive = 0;
        $this->set('packageDiscounts', $this->Paginator->paginate());
    }

    /**
     * admin_view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_view($id = null) {
        if (!$this->PackageDiscount->exists($id)) {
            throw new NotFoundException(__('Invalid package discount'));
        }
        $options = array('conditions' => array('PackageDiscount.' . $this->PackageDiscount->primaryKey => $id));
        $this->set('packageDiscount', $this->PackageDiscount->find('first', $options));
    }

    /**
     * admin_add method
     *
     * @return void
     */
    public function admin_add() {
        if ($this->request->is('post')) {
            $this->PackageDiscount->create();
            if ($this->PackageDiscount->save($this->request->data)) {
                return $this->flash(__('The package discount has been saved.'), array('action' => 'index'));
            }
        }
        $packages = $this->PackageDiscount->Package->find('list');
        $this->set(compact('packages'));
    }

    /**
     * admin_edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_edit($package_id = null) {
        $package_id = isset($this->request->params['pass']['0']) ? $this->request->params['pass']['0'] : '';
        if ($this->request->is(array('post'))) {
            $p_id = $this->request->data['PackageDiscount']['package_id'];
            $data = $this->request->data['PackageDiscount'];
            unset($data['package_id']);
            if ($this->PackageDiscount->saveAll($data)) {
                $this->Flash->AdminSuccess(__('Package discounts has been saved.'));
            } else {
                $this->Flash->AdminError(__('Package discounts could not be saved. Please, try again.'));
            }
            $this->redirect(array('action' => 'edit', 'admin' => 1, $p_id));
        }
        $this->loadModel('Package');
        $package_data = $this->Package->find('first', array('conditions' => array('Package.id' => $package_id), 'recursive' => -1));
        $option['conditions'] = array('PackageDiscount.package_id' => $package_id);
        $discounts = $this->PackageDiscount->find('all', $option);
        foreach ($discounts as $key => $val) {
            $price_array = $this->Format->price_calculation($val['PackageDiscount'], $val['Package']['price']);
            $package_price = floatval($val['Package']['price']);
            $discounts[$key]['PackageDiscount']['total_price'] = $package_price * $price_array['duration'];
            $discounts[$key]['PackageDiscount']['discounted_price'] = round($price_array['total_discountd_price'], 2);
        }
        $this->set(compact('discounts', 'package_data', 'package_id'));
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
            if ($this->PackageDiscount->delete($id)) {
                echo "Success";
            } else {
                echo "Error";
            }
        }
        exit;
    }

    public function show_user_dicsounts() {
        $this->layout = "ajax";
        $package_id = $this->request->data['package_id'];
        $this->loadModel('Package');
        $package = $this->Package->find('first', array('conditions' => array('Package.id' => $package_id), 'recursive' => -1));
        $this->set('package', $package);
        $options['conditions'] = array('PackageDiscount.package_id' => $package_id);
        $options['recursive'] = -1;
        $options['order'] = array('PackageDiscount.period_type ASC', 'PackageDiscount.period_duration ASC');
        $package_data = $this->PackageDiscount->find('all', $options);
        $package_prices = array();
        if (!empty($package_data)) {
            $view = new View($this);
            $format = $view->loadHelper('Format');
            foreach ($package_data as $key => $val) {
                $package_price = floatval($package['Package']['price']);
                $price_array = $this->Format->price_calculation($val['PackageDiscount'], $package_price);
                $total_price = $package_price * $price_array['duration'];
                $total_discounted_price = $price_array['total_discountd_price'];

                $discount_text = ($key == 0) ? "Rs " . ($package_price * $price_array['duration']) / $price_array['duration'] : $format->discount_text($val['PackageDiscount']['discount_type'], $val['PackageDiscount']['period_type'], $val['PackageDiscount']['period_duration'], floatval($val['PackageDiscount']['discount']));
                $total_discounted_price_pm = ($key == 0) ? $package_price * $price_array['duration'] : $price_array['total_discountd_price_pm'];
                $total_discounted_amount = ($key == 0) ? 0 : floor($package_price - $total_discounted_price_pm);
                $total_discounted_percent = ($key == 0) ? '0%' : (($package_price - $total_discounted_price_pm) / ($package_price)) * 100;
                $total_price = ($key == 0) ? $total_price : $total_discounted_price;
                $package_prices[] = array('discount_id' => $val['PackageDiscount']['id'], 'package_month' => $price_array['duration'], 'total_discounted_price_pm' => $total_discounted_price_pm, 'total_package_price' => $package_price, 'total_discount_text' => $discount_text, 'total_discount_percentage' => ceil($total_discounted_percent) . "%", 'total_price' => $total_price);
            }
        }
        $this->set('package_prices', $package_prices);
    }

}
