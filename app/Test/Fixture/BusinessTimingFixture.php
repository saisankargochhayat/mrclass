<?php
/**
 * BusinessTiming Fixture
 */
class BusinessTimingFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'business_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 12, 'unsigned' => false),
		'day' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 2, 'unsigned' => false),
		'start_time' => array('type' => 'time', 'null' => false, 'default' => null),
		'close_time' => array('type' => 'time', 'null' => false, 'default' => null),
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
			'business_id' => 1,
			'day' => 1,
			'start_time' => '15:06:34',
			'close_time' => '15:06:34'
		),
	);

}
