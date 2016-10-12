<?php
App::uses('Feedback', 'Model');

/**
 * Feedback Test Case
 *
 */
class FeedbackTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.feedback'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Feedback = ClassRegistry::init('Feedback');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Feedback);

		parent::tearDown();
	}

}
