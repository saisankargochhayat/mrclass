<?php
/**
 * PackageDiscount Fixture
 */
class PackageDiscountFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'package_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'period_duration' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'period_type' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 20, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'discount' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'discount_type' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 20, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'package_id' => 1,
			'period_duration' => 1,
			'period_type' => 'Lorem ipsum dolor ',
			'discount' => 1,
			'discount_type' => 'Lorem ipsum dolor ',
			'created' => '2016-01-13 19:37:57',
			'modified' => '2016-01-13 19:37:57'
		),
	);

}
