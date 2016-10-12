<?php
App::uses('Collect', 'Model');

/**
 * Collect Test Case
 *
 */
class CollectTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.collect',
		'app.book',
		'app.user',
		'app.group'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Collect = ClassRegistry::init('Collect');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Collect);

		parent::tearDown();
	}

}
