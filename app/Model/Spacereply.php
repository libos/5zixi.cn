<?php
App::uses('AppModel', 'Model');
/**
 * Spacereply Model
 *
 * @property User $Owner
 */
class Spacereply extends AppModel {

/**
 * Primary key field
 *
 * @var string
 */
	public $primaryKey = 'rid';

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'body';


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Owner' => array(
			'className' => 'User',
			'foreignKey' => 'owner',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
    'User'=> array(
			'className' => 'User',
			'foreignKey' => 'uid',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
