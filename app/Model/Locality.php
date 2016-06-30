<?php
App::uses('AppModel', 'Model');
/**
 * Locality Model
 *
 */
class Locality extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';
        public $belongsTo = array(
        'City' => array(
            'className' => 'City',
            'foreignKey' => 'city_id'
        )
    );

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'city_id' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'name' => array(
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
