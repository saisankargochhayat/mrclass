<?php
App::uses('Career', 'Model');

/**
 * Career Test Case
 */
class CareerTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.career'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Career = ClassRegistry::init('Career');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Career);

		parent::tearDown();
	}

}
