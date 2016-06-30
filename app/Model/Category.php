<?php
App::uses('AppModel', 'Model');
/**
 * Category Model
 *
 */
class Category extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';
         var $name = 'Category';
         var $hasMany = array(
               'Sub-category' => array(
                       'className'  => 'Category',
                       'foreignKey' => 'parent_id'
               )
       );
       var $belongsTo = array(
               'Parent' => array(
                       'className'  => 'Category',
                       'foreignKey' => 'parent_id'
               )
       );

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
//		'parent_id' => array(
//			'numeric' => array(
//				'rule' => array('numeric'),
//				//'message' => 'Your custom message here',
//				//'allowEmpty' => false,
//				//'required' => false,
//				//'last' => false, // Stop validation after this rule
//				//'on' => 'create', // Limit validation to 'create' or 'update' operations
//			),
//		),
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
