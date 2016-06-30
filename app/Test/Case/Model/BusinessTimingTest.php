<?php
App::uses('BusinessTiming', 'Model');

/**
 * BusinessTiming Test Case
 */
class BusinessTimingTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.business_timing',
		'app.business',
		'app.business_gallery',
		'app.business_rating'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->BusinessTiming = ClassRegistry::init('BusinessTiming');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->BusinessTiming);

		parent::tearDown();
	}

}
