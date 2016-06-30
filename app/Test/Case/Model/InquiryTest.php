<?php
App::uses('Inquiry', 'Model');

/**
 * Inquiry Test Case
 */
class InquiryTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.inquiry'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Inquiry = ClassRegistry::init('Inquiry');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Inquiry);

		parent::tearDown();
	}

}
