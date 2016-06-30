<?php
/**
 * BusinessGallery Fixture
 */
class BusinessGalleryFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'business_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'media' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'sequence' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 3, 'unsigned' => false),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
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
			'media' => 'Lorem ipsum dolor sit amet',
			'sequence' => 1,
			'created' => '2015-09-04 11:47:39'
		),
	);

}
