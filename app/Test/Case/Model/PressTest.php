<?php
App::uses('Press', 'Model');

/**
 * Press Test Case
 */
class PressTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.press'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Press = ClassRegistry::init('Press');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Press);

		parent::tearDown();
	}

}
