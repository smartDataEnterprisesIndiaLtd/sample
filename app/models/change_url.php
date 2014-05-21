<?php
/**
 *
* State Model class
*/
class ChangeUrl extends AppModel {
	var $name = 'ChangeUrl';
	
	var $validate = array(		
		'current_url' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => "Enter Current url",
				'last' => true
			),			
			'isUnique' => array(
				'rule' => 'isUnique',
				'message' => "Current url already exists"
			)
		),
		'change_url' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => "Enter Changed url",
				'last' => true
			),			
			'isUnique' => array(
				'rule' => 'isUnique',
				'message' => "Changed url already exists"
			)
		),
	);

}
?>