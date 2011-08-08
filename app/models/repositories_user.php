<?php
class RepositoriesUser extends AppModel {
	var $name = 'RepositoriesUser';
	var $validate = array(
		'points' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Points must be a number',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'positive' => array(
				'rule' => array('positive'),
				'message' => 'Points cannot be negative',
			)
		),
	);
	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
		'Repository' => array(
			'className' => 'Repository',
			'foreignKey' => 'repository_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	
	function positive($value) {
		return $value['points'] >= 0;
	}
	
	/**
	 * 
	 * Add $points to $user_id in $repository_id
	 * returns true if successful
	 * @param int $user_id
	 * @param int $repository_id
	 * @param int $points
	 * @return boolean
	 */
	function addPoints($user_id = null, $repository_id = null, $points = 10) {
		if(!is_null($user_id) && !is_null($repository_id)) {
			$ru = $this->find('first', array('conditions' => compact('user_id', 'repository_id'), 'recursive' => -1));
			$new_value = $points + $ru['RepositoriesUser']['points'];
			
			$this->id = $ru['RepositoriesUser']['id'];
			if($this->saveField('points', $new_value))
				return true;
		}
		return false;	
	}
	
	/**
	 * 
	 * Discount $points to $user_id in $repository_id
	 * returns true if successful
	 * false otherwise or points result to be negative
	 * @param int $user_id
	 * @param int $repository_id
	 * @param int $points
	 */
	function discountPoints($user_id, $repository_id, $points = 10) {
		if(!is_null($user_id) && !is_null($repository_id)) {
			$ru = $this->find('first', array('conditions' => compact('user_id', 'repository_id'), 'recursive' => -1));
			$new_value = $ru['RepositoriesUser']['points'] - $points;
			
// 				validation should do the trick
//  			if($new_value < 0) 
//  				return false;
			
			$this->id = $ru['RepositoriesUser']['id'];
			if($this->saveField('points', $new_value, true))
				return true;
		}
		return false;
	}
}
?>