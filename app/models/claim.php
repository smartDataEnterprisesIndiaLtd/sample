<?php
class Claim extends AppModel{
	var $name = 'Claim';
	var $assocs = array(
		'OrderItem' => array(
			'type' => 'belongsTo',
			'className' => 'OrderItem',
			'foreignKey' => 'order_item_id',
		),
		'Order' => array(
			'type' => 'belongsTo',
			'className' => 'Order',
			'foreignKey' => 'order_id',
		),
		'Product' => array(
			'type' => 'belongsTo',
			'className' => 'Product',
			'foreignKey' => 'product_id',
		),
		'UserSummary' => array(
			'type' => 'belongsTo',
			'className' => 'User',
			'foreignKey' => 'user_id',
		),
		'SellerSummary' => array(
			'type' => 'belongsTo',
			'className' => 'User',
			'foreignKey' => 'seller_id',
		),
	);
	var $validate = array(
		
	);
}
?>