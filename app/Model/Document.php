<?php
App::uses('AppModel', 'Model');
/**
 * Document Model
 *
 * @property User $User
 */
class Document extends AppModel {

/**
 * Primary key field
 *
 * @var string
 */
	public $primaryKey = 'did';

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'link';


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'uid',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Book' => array(
			'className' => 'Book',
			'foreignKey' => 'bid',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
	);
}
