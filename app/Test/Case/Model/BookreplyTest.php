<?php
App::uses('Bookreply', 'Model');

/**
 * Bookreply Test Case
 *
 */
class BookreplyTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.bookreply',
		'app.book'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Bookreply = ClassRegistry::init('Bookreply');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Bookreply);

		parent::tearDown();
	}

}
