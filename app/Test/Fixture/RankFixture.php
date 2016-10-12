<?php
/**
 * RankFixture
 *
 */
class RankFixture extends CakeTestFixture {

/**
 * Table name
 *
 * @var string
 */
	public $table = 'rank';

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'cid' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'primary'),
		'cname' => array('type' => 'string', 'null' => false, 'default' => null, 'key' => 'unique', 'collate' => 'utf8_bin', 'charset' => 'utf8'),
		'max' => array('type' => 'integer', 'null' => false, 'default' => null),
		'min' => array('type' => 'integer', 'null' => false, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => '创建时间'),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => '最后更新时间'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'cid', 'unique' => 1),
			'cname' => array('column' => 'cname', 'unique' => 1)
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
			'cid' => 1,
			'cname' => 'Lorem ipsum dolor sit amet',
			'max' => 1,
			'min' => 1,
			'created' => '2013-09-29 09:57:39',
			'modified' => '2013-09-29 09:57:39'
		),
	);

}
