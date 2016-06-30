<?php
App::uses('QuestionDownload', 'Model');

/**
 * QuestionDownload Test Case
 */
class QuestionDownloadTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.question_download',
		'app.question',
		'app.question_category',
		'app.user',
		'app.city',
		'app.state',
		'app.dist',
		'app.locality',
		'app.business',
		'app.business_language',
		'app.business_gallery',
		'app.business_rating',
		'app.business_rating_reply',
		'app.business_timing',
		'app.business_keyword',
		'app.business_faq',
		'app.business_favorite',
		'app.facility',
		'app.business_facility',
		'app.category',
		'app.business_category',
		'app.business_subcategory'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->QuestionDownload = ClassRegistry::init('QuestionDownload');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->QuestionDownload);

		parent::tearDown();
	}

}
