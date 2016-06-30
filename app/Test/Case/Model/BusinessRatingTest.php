<?php
App::uses('BusinessRating', 'Model');

/**
 * BusinessRating Test Case
 */
class BusinessRatingTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.business_rating'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->BusinessRating = ClassRegistry::init('BusinessRating');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->BusinessRating);

		parent::tearDown();
	}

}
