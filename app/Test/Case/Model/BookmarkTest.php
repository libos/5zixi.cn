<?php
App::uses('Bookmark', 'Model');

/**
 * Bookmark Test Case
 *
 */
class BookmarkTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.bookmark',
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
		$this->Bookmark = ClassRegistry::init('Bookmark');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Bookmark);

		parent::tearDown();
	}

}
