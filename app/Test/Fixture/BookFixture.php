<?php
/**
 * BookFixture
 *
 */
class BookFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'bid' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'primary'),
		'burl' => array('type' => 'string', 'null' => false, 'default' => null, 'key' => 'unique', 'collate' => 'utf8_bin', 'charset' => 'utf8'),
		'uid' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'index'),
		'pass' => array('type' => 'integer', 'null' => false, 'default' => '0', 'comment' => '审核状态，0为未通过，1通过，2推荐到首页，3特别推荐'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_bin', 'charset' => 'utf8'),
		'author' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_bin', 'charset' => 'utf8'),
		'type' => array('type' => 'integer', 'null' => false, 'default' => null),
		'lastid' => array('type' => 'integer', 'null' => true, 'default' => '0', 'length' => 10),
		'decs' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_bin', 'charset' => 'utf8'),
		'location' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_bin', 'charset' => 'utf8'),
		'filesize' => array('type' => 'integer', 'null' => false, 'default' => null),
		'fengmian' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_bin', 'charset' => 'utf8'),
		'collect' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'click' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'clickweekly' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'downloads' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'downloadsweekly' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => '创建时间'),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => '最后更新时间'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'bid', 'unique' => 1),
			'burl' => array('column' => 'burl', 'unique' => 1),
			'uid' => array('column' => 'uid', 'unique' => 0)
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
			'bid' => 1,
			'burl' => 'Lorem ipsum dolor sit amet',
			'uid' => 1,
			'pass' => 1,
			'name' => 'Lorem ipsum dolor sit amet',
			'author' => 'Lorem ipsum dolor sit amet',
			'type' => 1,
			'lastid' => 1,
			'decs' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'location' => 'Lorem ipsum dolor sit amet',
			'filesize' => 1,
			'fengmian' => 'Lorem ipsum dolor sit amet',
			'collect' => 1,
			'click' => 1,
			'clickweekly' => 1,
			'downloads' => 1,
			'downloadsweekly' => 1,
			'created' => '2013-09-29 01:25:15',
			'modified' => '2013-09-29 01:25:15'
		),
	);

}
