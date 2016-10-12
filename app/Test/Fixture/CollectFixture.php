<?php
/**
 * CollectFixture
 *
 */
class CollectFixture extends CakeTestFixture {

/**
 * Table name
 *
 * @var string
 */
	public $table = 'collect';

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'uid' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'primary'),
		'bid' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => '创建时间'),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => '最后更新时间'),
		'indexes' => array(
			'PRIMARY' => array('column' => array('uid', 'bid'), 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_bin', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'uid' => 1,
			'bid' => 1,
			'created' => '2013-09-29 01:31:09',
			'modified' => '2013-09-29 01:31:09'
		),
	);

}
