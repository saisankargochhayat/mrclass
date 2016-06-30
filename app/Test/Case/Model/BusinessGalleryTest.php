<?php
App::uses('BusinessGallery', 'Model');

/**
 * BusinessGallery Test Case
 */
class BusinessGalleryTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.business_gallery'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->BusinessGallery = ClassRegistry::init('BusinessGallery');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->BusinessGallery);

		parent::tearDown();
	}

}
