<?php
App::uses('AppModel', 'Model');
/**
 * Package Model
 *
 */
class Package extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';

	/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'PackageDiscount' => array(
			'className' => 'PackageDiscount',
			'foreignKey' => 'package_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

}
