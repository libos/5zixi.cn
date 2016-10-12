<?php
/**
 * BookmarkFixture
 *
 */
class BookmarkFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'mid' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'primary'),
		'uid' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 10),
		'bid' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 10),
		'part' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 10),
		'url' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => '创建时间'),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => '最后更新时间'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'mid', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'mid' => 1,
			'uid' => 1,
			'bid' => 1,
			'part' => 1,
			'url' => 'Lorem ipsum dolor sit amet',
			'created' => '2013-09-29 01:29:36',
			'modified' => '2013-09-29 01:29:36'
		),
	);

}
