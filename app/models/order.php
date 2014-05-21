<?php
/**
* Order Model class
*/
class Order extends AppModel {
	var $name = 'Order';
	var $assocs = array(
		'User' => array(
			'type' => 'belongsTo',
			'className' => 'User',
		),
		'Product' => array(
			'type' => 'belongsTo',
			'className' => 'Product',
		),
		'OrderItem' => array(
			'type' => 'hasMany',
			'className' => 'OrderItem',
			'foreignKey' => 'order_id',
			'dependent' => true,
		),
		'OrderSeller' => array(
			'type' => 'hasMany',
			'className' => 'OrderSeller',
			'foreignKey' => 'order_id',
			'dependent' => true,
		),
		'OrderStatus' => array(
			'type' => 'hasMany',
			'className' => 'OrderSeller',
			'foreignKey' => 'order_id',
			'fields' => array('shipping_status'),
		),
		'UserSummary' => array(
			'type' => 'belongsTo',
			'className' => 'User',
			'fields'=>array('id','title','firstname','lastname','email'/*,'phone'*/),
			'foreignKey' => 'user_id',
		),
		'CanceledItem' => array(
			'type' => 'hasMany',
			'className' => 'CanceledItem',
			'foreignKey' => 'order_id',
			'dependent' => true,
			'fields' => array('DISTINCT created'),
		),
	);
	var $validate = array(
		
		'billing_user_title' => array(
			'rule' => 'notEmpty',
			'message' => "Select title",
			),
		'billing_firstname' => array(
			'rule' => 'notEmpty',
			'message' => "Enter first name",
			),
		'billing_lastname' => array(
			'rule' => 'notEmpty',
			'message' => "Enter last name",
		),
		'billing_address1' => array(
			'rule' => 'notEmpty',
			'message' => "Enter address",
		),
		'billing_city' => array(
			'rule' => 'notEmpty',
			'message' => "Enter city",
		),
		'billing_country_id' => array(
			'rule' => 'notEmpty',
			'message' => "Enter country name",
		),
		'billing_state' => array(
			'rule' => 'notEmpty',
			'message' => "Enter state",
		),
		'billing_postal_code' => array(
			'rule' => 'notEmpty',
			'message' => "Enter postcode",
		),
		'billing_phone' => array(
			'rule' => 'notEmpty',
			'message' => "Enter phone",
		),
		'reason' => array(
			'rule' => 'notEmpty',
			'message' => "Enter reason",
		),
		'comment' => array(
			'rule' => 'notEmpty',
			'message' => "Enter comments",
		),
		'shipping_user_title' => array(
			'rule' => 'notEmpty',
			'message' => "Select title",
			),
		'shipping_firstname' => array(
			'rule' => 'notEmpty',
			'message' => "Enter first name",
			),
		'shipping_lastname' => array(
			'rule' => 'notEmpty',
			'message' => "Enter last name",
		),
		'shipping_address1' => array(
			'rule' => 'notEmpty',
			'message' => "Enter address",
		),
		'shipping_city' => array(
			'rule' => 'notEmpty',
			'message' => "Enter city",
		),
		'shipping_country_id' => array(
			'rule' => 'notEmpty',
			'message' => "Enter shipping country",
		),
		'shipping_state' => array(
			'rule' => 'notEmpty',
			'message' => "Enter state",
		),
		'shipping_postal_code' => array(
			'rule' => 'notEmpty',
			'message' => "Enter postcode",
		),
		'shipping_phone' => array(
			'rule' => 'notEmpty',
			'message' => "Enter phone",
		),
	);
}
?>