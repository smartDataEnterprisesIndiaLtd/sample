<?php
/**
* Seller Model class
*/
class SellerPayment extends AppModel {
	var $name = 'SellerPayment';
	var $assocs = array(
		
		/*'User' => array(
			'type' => 'belongsTo',
			'className' => 'User',
			'foreignKey' => 'user_id',
		)*/
	);
	var $validate = array(
		'amount' => array(
			'rule' => 'notEmpty',
			'message' => "Enter amount value"
		),
		
	);
}
?>