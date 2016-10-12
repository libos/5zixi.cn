<?php
App::uses('Spacereply', 'Model');

/**
 * Spacereply Test Case
 *
 */
class SpacereplyTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.spacereply',
		'app.user',
		'app.group',
		'app.book'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Spacereply = ClassRegistry::init('Spacereply');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Spacereply);

		parent::tearDown();
	}

}
