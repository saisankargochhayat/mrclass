<?php

App::uses('AppModel', 'Model');

/**
 * User Model
 *
 */
class User extends AppModel {

    public $name = 'User';
    public $actsAs = array(
        'Containable', 'Captcha' => array(
            'field' => array('security_code'),
            'error' => 'Incorrect captcha code value'
        ),
        'Upload.Upload' => array(
            'photo' => array(
                'fields' => array(
                    'dir' => 'logo_dir'
                )
            )
    ));
    public $belongsTo = array(
        'City' => array(
            'className' => 'City',
            'foreignKey' => 'city',
            'fields' => array('id', 'name')
        )
    );
    public $hasMany = array(
        'Business' => array(
            'className' => 'Business',
            'foreignKey' => 'user_id'
        ),
        'BusinessFavorite' => array(
            'className' => 'BusinessFavorite',
            'foreignKey' => 'user_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        )
    );

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'name';

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
        'photo' => array(
            #'rule' => array('isValidMimeType', array('application/pdf', 'image/png')),
            'rule' => array('isValidExtension', array('jpg', 'png', 'jpeg', 'gif', 'bmp'), array(), false),
            'message' => 'Please upload proper image.',
            'allowEmpty' => true,
            'required' => false
        ),
        'name' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'Name Required !',
            //'allowEmpty' => false,
            //'required' => true,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
            'alphaOnly' => array(
                'rule' => '/^[a-z][a-z ]*$/i',
                'message' => 'Only Letters and Spaces are allowed !'
            ),
        ),
        'phone' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'Please enter your phone number.',
            //'allowEmpty' => false,
            //'required' => true,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create' // Limit validation to 'create' or 'update' operations
            ),
            'validMobile' => array(
                //'rule' => '/^([0|\+[0-9]{1,5})?([7-9][0-9]{9})$/',
                'rule' => '/^[0-9\-\+\(\)]+$/',
                'message' => 'Please enter valid phone number.'
            ),
            'unique' => array(
                'rule' => array('isUniquePhone'),
                'message' => 'This phone number is already in use'
            //'on'=>'update'
            )
        /* 'validPhone' => array(
          'rule' => '/^([0|\+[0-9]{1,5})?([7-9][0-9]{9})$/',
          'message' => 'Please Enter Phone Number In Valid Format !'
          ), */
        ),
        'username' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'Usernsame is Required !',
                //'allowEmpty' => false,
                //'required' => true
                //'last' => false, // Stop validation after this rule
                'on' => 'create' // Limit validation to 'create' or 'update' operations
            ),
            'unique' => array(
                'rule' => array('isUniqueUsername'),
                'message' => 'This username is already in use',
            //'on' => 'create'
            )
//            'alphaNumeric' => array(
//                'rule' => array('alphaNumeric'),
//                'message' => 'Only Alphabets and Numbers are allowed !'
//            'allowEmpty' => false,
//            'required' => false,
//            'last' => false, // Stop validation after this rule
//            'on' => 'create', // Limit validation to 'create' or 'update' operations
//            ),
        ),
        'email' => array(
            'email' => array(
                'rule' => array('email'),
                'message' => 'Enter Valid Email'
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create' // Limit validation to 'create' or 'update' operations
            ),
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'E-mail is Required !'
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
            'unique' => array(
                'rule' => array('isUniqueEmail'),
                'message' => 'This email is already in use'
            //'on'=>'update'
            )
        ),
        'city' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'City is Required !'
            )
        ),
        'password' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
            'required' => array(
                'rule' => array('minLength', '6'),
                'message' => 'A password with a minimum length of 6 characters is required',
                'on' => 'create'
            )
        ),
        'password_confirm' => array(
            'required' => array(
                'rule' => array('equalToField', 'password'),
                'message' => 'Both password fields must be filled out'
            )
        ),
        'pincode' => array(
            'postal' => array(
                'rule' => array('postal'),
                'message' => 'Please enter proper postal code',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        )
    );

    function equalToField($array, $field) {
        return strcmp($this->data[$this->alias][key($array)], $this->data[$this->alias][$field]) == 0;
    }

    /**
     * Before isUniqueUsername
     * @param array $options
     * @return boolean
     */
    function isUniqueUsername($check) {
        $username = $this->find('first', array('fields' => array('User.id', 'User.username'), 'conditions' => array('User.username' => $check['username'])));
        if (!empty($username)) {
            if (!empty($this->data[$this->alias]['id']) && $this->data[$this->alias]['id'] == $username['User']['id']) {
                return true;
            } else {
                return false;
            }
        } else {
            return true;
        }
    }

    /**
     * Before isUniqueEmail
     * @param array $options
     * @return boolean
     */
    function isUniqueEmail($check) {
        $email = $this->find('first', array('fields' => array('User.id'), 'conditions' => array('User.email' => $check['email'])));
        if (!empty($email)) {
            if (!empty($this->data[$this->alias]['id']) && $this->data[$this->alias]['id'] == $email['User']['id']) {
                return true;
            } else {
                return false;
            }
        } else {
            return true;
        }
    }

    /**
     * Before isUniquePhone
     * @param array $options
     * @return boolean
     */
    function isUniquePhone($check) {
        $phone = $this->find('first', array('fields' => array('User.id'), 'conditions' => array('User.phone' => $check['phone'])));
        if (!empty($phone)) {
            if (!empty($this->data[$this->alias]['id']) && $this->data[$this->alias]['id'] == $phone['User']['id']) {
                return true;
            } else {
                return false;
            }
        } else {
            return true;
        }
    }

    function afterDelete() {
        $user_id = $this->id;
        $BusinessFavorite = ClassRegistry::init('BusinessFavorite');
        $data = $BusinessFavorite->find('all', array('conditions' => array('BusinessFavorite.user_id' => $user_id)));
        if (!empty($data)) {
            foreach ($data as $k => $v) {
                $BusinessFavorite->delete($v['BusinessFavorite']['id']);
            }
        }
        $QuestionDownload = ClassRegistry::init('QuestionDownload');
        $data1 = $QuestionDownload->find('all', array('conditions' => array('QuestionDownload.user_id' => $user_id)));
        if (!empty($data1)) {
            foreach ($data1 as $k => $v) {
                $BusinessFavorite->delete($v['BusinessFavorite']['id']);
            }
        }
    }

    function user_details($id) {
        $params = array('conditions' => array('User.id' => $id));
        $params['fields'] = array('User.id', 'User.name', 'User.email', 'User.phone', 'User.city', 'User.pincode');
        $this->recursive = false;
        $user = $this->find('first', $params);

        $this->Business = ClassRegistry::init('Business');
        $option = array();
        $option['conditions'] = array('Business.user_id' => $id);
        $option['order'] = array('Business.id' => 'desc');
        $option['recursive'] = false;
        $option['fields'] = array('Business.name', 'Business.address', 'Business.landmark', 'Business.pincode', 'Business.email', 'Business.phone', 'City.name', 'Locality.name');
        $business = $this->Business->find('first', $option);
        $ret_arr = array('user' => $user['User'], 'business' => $business);
        return json_encode($ret_arr);
    }

}
