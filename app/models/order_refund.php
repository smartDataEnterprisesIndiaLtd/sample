<?php
/**
 *
* OrderRefund Model class
*/
class OrderRefund extends AppModel {
	var $name = 'OrderRefund';
	var $assocs = array(
		'SellerSummary' => array(
			'type' => 'belongsTo',
			'className' => 'User',
			'foreignKey' => 'seller_id',
		),
		'UserSummary' => array(
			'type' => 'belongsTo',
			'className' => 'User',
			'foreignKey' => 'user_id',
		),
		'Order' => array(
			'type' => 'belongsTo',
			'className' => 'Order',
			'foreignKey' => 'order_id',
		),
		//Add for business_display_name on 08-feb-2013
		'Seller' => array(
			'type' => 'belongsTo',
			'className' => 'Seller',
			'conditions' => array('Seller.user_id = OrderRefund.seller_id'),
			'foreignKey' => false
		),
	);
	var $validate = array();
}
?>