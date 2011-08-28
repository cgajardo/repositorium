<?php
class Repository extends AppModel {
	var $name = 'Repository';
	var $displayField = 'name';
	var $validate = array(
		'name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Repository name cannot be empty',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'url' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Repository url cannot be empty',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'alphanumeric' => array(
				'rule' => array('alphaNumeric'),
				'message' => 'Repository url can contain only letters or numbers',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Repository url cannot be empty',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'unique' => array(
				'rule' => array('isUnique'),
				'message' => 'Repository url is already taken',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'length' => array(
				'rule' => array('minLength', 4),
				'message' => 'Repository url must be at least 4 characters',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'spaces' => array(
				'rule' => 'nospaces',
				'message' => 'Repository url cannot contain spaces',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			
		),
// 		'min_points' => array(
// 			'positive' => array(
// 				'rule' => array('positive', 'min_points'),
// 				'message' => 'Points must be greater or equal than 0'
// 			),
// 			'notempty' => array(
// 				'rule' => array('notempty'),
// 				'message' => 'Points cannot be empty',
// 			),
// 		),
		'download_cost' => array(
			'positive' => array(
				'rule' => array('positive', 'download_cost'),
				'message' => 'Download cost must be greater or equal than 0',
			),
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Download cost cannot be empty',
			),
		),
		'upload_cost' => array(
			'positive' => array(
				'rule' => array('positive', 'upload_cost'),
				'message' => 'Upload cost must be greater or equal than 0'
			),
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Upload cost cannot be empty',
			),
		),
		'documentpack_size' => array(
			'positive' => array(
				'rule' => array('positive', 'documentpack_size'),
				'message' => 'Document pack size must be greater or equal than 0'
			),
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Document pack size cannot be empty',
			),
		),		
	);
	
	/**
	 * also a check for alphanumeric
	 */
	function nospaces($check) {
		$value = array_shift($check);            
		return preg_match('|^[0-9a-zA-Z]*$|', $value);
	}
	
	function positive($value, $key) {
		return !is_null($value[$key]) && $value[$key] >= 0;
	}
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	var $hasMany = array(
		'Criteria' => array(
			'className' => 'Criteria',
			'foreignKey' => 'repository_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Document' => array(
			'className' => 'Document',
			'foreignKey' => 'repository_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Expert' => array(
			'className' => 'Expert',
			'foreignKey' => 'repository_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'RepositoriesUser' => array(
			'className' => 'RepositoriesUser',
			'foreignKey' => 'repository_id'
		)
	);

	/*******************************************************/
	
	function createNewRepository($data) {		
		if($this->save($data))
			return $this->find('first', array('conditions' => array('id' => $this->getLastInsertID()), 'recursive' => -1));
		return null;
	}
	
	function afterSave($created) {
		if($created)
			$this->RepositoriesUser->massCreateAfterRepository($repository_id = $this->id);
	}

}
?>