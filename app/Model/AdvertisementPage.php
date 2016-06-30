<?php

App::uses('AppModel', 'Model');

/**
 * AdvertisementPage Model
 *
 */
class AdvertisementPage extends AppModel {

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'name';
    public $validate = array(
        'name' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'Please enter ad page name',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        /* 'unique' => array(
          'rule' => array('isUniqueName'),
          'message' => 'Business with same name exists '
          //'on'=>'update'
          ) */
        ),
        'description' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'Please enter description',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        /* 'unique' => array(
          'rule' => array('isUniqueName'),
          'message' => 'Business with same name exists '
          //'on'=>'update'
          ) */
        ),
    );

}
