<?php
/**
* Seller Model class
*/
class PaymentPenalty extends AppModel {
	var $name = 'PaymentPenalty';
	var $assocs = array(
		
		/*'User' => array(
			'type' => 'belongsTo',
			'className' => 'User',
			'foreignKey' => 'user_id',
		)*/
	);
	var $validate = array(
		'reason' => array(
			'rule' => 'notEmpty',
			'message' => "Enter reason value"
		),
		'from_date' => array(
			'rule' => 'notEmpty',
			'message' => "Enter date value"
		),
		'fees' => array(
			'rule' => 'notEmpty',
			'rule' => 'Numeric',
			'message' => "Enter fees value"
		),
		
	);
}
?>