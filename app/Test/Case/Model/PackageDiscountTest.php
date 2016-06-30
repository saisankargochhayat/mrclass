<?php
App::uses('PackageDiscount', 'Model');

/**
 * PackageDiscount Test Case
 */
class PackageDiscountTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.package_discount',
		'app.package'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->PackageDiscount = ClassRegistry::init('PackageDiscount');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->PackageDiscount);

		parent::tearDown();
	}

}
