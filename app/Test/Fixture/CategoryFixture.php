<?php
/**
 * Category Fixture
 */
class CategoryFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'parent_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 155, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'status' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 2, 'unsigned' => false),
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
			'parent_id' => 1,
			'name' => 'Lorem ipsum dolor sit amet',
			'status' => 1
		),
	);

}
