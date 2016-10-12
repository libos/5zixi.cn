<?php
App::uses('AppModel', 'Model');
/**
 * Search Model
 *
 */
class Search extends AppModel {

/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'search';

/**
 * Primary key field
 *
 * @var string
 */
	public $primaryKey = 'sid';

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'keywords';

}
