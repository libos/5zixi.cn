<?php
/**
 * SearchFixture
 *
 */
class SearchFixture extends CakeTestFixture {

/**
 * Table name
 *
 * @var string
 */
	public $table = 'search';

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'sid' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'primary'),
		'keywords' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'ip' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => '创建时间'),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => '最后更新时间'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'sid', 'unique' => 1)
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
			'sid' => 1,
			'keywords' => 'Lorem ipsum dolor sit amet',
			'ip' => 'Lorem ipsum dolor sit amet',
			'created' => '2013-09-30 15:52:10',
			'modified' => '2013-09-30 15:52:10'
		),
	);

}
