<?php
App::uses('AppModel', 'Model');
/**
 * PackageDiscount Model
 *
 * @property Package $Package
 */
class PackageDiscount extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Package' => array(
			'className' => 'Package',
			'foreignKey' => 'package_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
