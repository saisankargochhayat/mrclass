<?php
App::uses('Transaction', 'Model');

/**
 * Transaction Test Case
 */
class TransactionTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.transaction',
		'app.user',
		'app.city',
		'app.state',
		'app.dist',
		'app.locality',
		'app.business',
		'app.category',
		'app.business_language',
		'app.business_gallery',
		'app.business_rating',
		'app.business_rating_reply',
		'app.business_timing',
		'app.business_keyword',
		'app.facility',
		'app.business_facility',
		'app.business_subcategory'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Transaction = ClassRegistry::init('Transaction');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Transaction);

		parent::tearDown();
	}

}
