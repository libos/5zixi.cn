<?php
App::uses('Tmp', 'Model');

/**
 * Tmp Test Case
 *
 */
class TmpTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.tmp'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Tmp = ClassRegistry::init('Tmp');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Tmp);

		parent::tearDown();
	}

}
