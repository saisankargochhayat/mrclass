<?php

App::uses('AppModel', 'Model');

/**
 * BusinessGallery Model
 *
 */
class BusinessGallery extends AppModel {

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'media';

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
        'business_id' => array(
            'numeric' => array(
                'rule' => array('numeric'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'media' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
    );

}
