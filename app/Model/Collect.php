<?php
App::uses('AppModel', 'Model');
/**
 * Collect Model
 *
 * @property Book $Book
 * @property user $User
 */
class Collect extends AppModel {

/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'collect';

/**
 * Primary key field
 *
 * @var string
 */
	public $primaryKey = 'uid';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'uid' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'bid' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

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
			'className' => 'user',
			'foreignKey' => 'uid',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
