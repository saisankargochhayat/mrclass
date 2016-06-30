<?php
App::uses('BusinessFaq', 'Model');

/**
 * BusinessFaq Test Case
 */
class BusinessFaqTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.business_faq',
		'app.business',
		'app.user',
		'app.city',
		'app.state',
		'app.dist',
		'app.locality',
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
		$this->BusinessFaq = ClassRegistry::init('BusinessFaq');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->BusinessFaq);

		parent::tearDown();
	}

}
