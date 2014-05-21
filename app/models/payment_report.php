<?php
/**
 *
*  Model class
*/
class PaymentReport extends AppModel {
	var $name = 'PaymentReport';
 	var $assocs = array(
		'User' => array(
			'type' => 'belongsTo',
			'className' => 'User',
			'foreignKey' => 'seller_id',
			'dependent' => true
		),
	);
}
?>