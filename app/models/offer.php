<?php
/**
* Offer Model class
*/
class Offer extends AppModel {
	var $name = 'Offer';
	var $assocs = array(
		'User' => array(
			'type' => 'belongsTo',
			'className' => 'User',
		),
		'Product' => array(
			'type' => 'belongsTo',
			'className' => 'Product',
		)
	);
	var $validate = array(
		'offer_price' => array(
			'rule' => 'notEmpty',
			'message' => "Enter price"
		),
		'quantity' => array(
			'rule' => 'notEmpty',
			'message' => "Enter quantity"
		)
	);
}
?>