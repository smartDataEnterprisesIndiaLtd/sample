<?php
/**
* OrderReturn Model class
*/
class OrderReturn extends AppModel {
	var $name = 'OrderReturn';
	var $assocs = array(
		'OrderItem' => array(
			'type' => 'hasMany',
			'className' => 'OrderItem',
			'foreignKey' => 'order_id',
		),
		'SellerSummary' => array(
			'type' => 'belongsTo',
			'className' => 'User',
			'foreignKey' => 'seller_id',
		),
		'Order' => array(
			'type' => 'belongsTo',
			'className' => 'Order',
			'foreignKey' => 'order_id',
		),
		'OrderItem' => array(
			'type' => 'belongsTo',
			'className' => 'OrderItem',
			'foreignKey' => 'order_item_id',
		),
		'UserSummary' => array(
			'type' => 'belongsTo',
			'className' => 'User',
			'foreignKey' => 'user_id',
		),
	);
}
?>