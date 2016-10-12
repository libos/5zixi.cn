<?php
App::uses('AppModel', 'Model');
/**
 * Bookmark Model
 *
 * @property Book $Book
 * @property User $User
 * @property User $User
 */
class Bookmark extends AppModel {

/**
 * Primary key field
 *
 * @var string
 */
	public $primaryKey = 'mid';

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'bid';


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Book' => array(
			'className' => 'Book',
			'foreignKey' => 'bid',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'uid',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
  
}
