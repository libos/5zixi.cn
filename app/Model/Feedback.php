<?php
App::uses('AppModel', 'Model');
/**
 * Feedback Model
 *
 */
class Feedback extends AppModel {

/**
 * Primary key field
 *
 * @var string
 */
	public $primaryKey = 'fid';

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'body';

}
