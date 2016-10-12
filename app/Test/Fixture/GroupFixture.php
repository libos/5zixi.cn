<?php
/**
 * GroupFixture
 *
 */
class GroupFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'gid' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'primary'),
		'gname' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_bin', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => '创建时间'),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => '最后更新时间'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'gid', 'unique' => 1)
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
			'gid' => 1,
			'gname' => 'Lorem ipsum dolor sit amet',
			'created' => '2013-09-29 01:22:45',
			'modified' => '2013-09-29 01:22:45'
		),
	);

}
