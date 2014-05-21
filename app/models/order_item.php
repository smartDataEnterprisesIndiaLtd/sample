<?php
/**
* OrderItem Model class
*/
class OrderItem extends AppModel {
	var $name = 'OrderItem';
	var $assocs = array(
		'User' => array(
			'type' => 'belongsTo',
			'className' => 'User',
		),
		'Product' => array(
			'type' => 'belongsTo',
			'className' => 'Product',
		),
		'ProductCategory' => array(
			'type' => 'belongsTo',
			'className' => 'ProductCategory',
			'foreignKey' => 'product_id'
		),
		'Order' => array(
			'type' => 'belongsTo',
			'className' => 'Order',
		),
		'OrderCre' => array(
			'type' => 'belongsTo',
			'className' => 'Order',
			'fields' => array('OrderCre.created','OrderCre.order_number'),
			'foreignKey' => 'order_id',
		),
		'SellerSummary' => array(
			'type' => 'belongsTo',
			'className' => 'User',
			'fields'=>array('id','firstname','lastname','email'/*,'phone'*/),
			'foreignKey' => 'seller_id',
		),
		'OrderSeller' => array(
			'type' => 'belongsTo',
			'className' => 'OrderSeller',
			'foreignKey' => false,
			'conditions'=>'OrderItem.order_id = OrderSeller.order_id'
		),
		'CancelOrder' => array(
			'type' => 'hasOne',
			'className' => 'CancelOrder',
			'fields' => 'id'
		),
		'ProductSeller' => array(
			'type' => 'belongsTo',
			'className' => 'ProductSeller',
			'fields'=>array('reference_code','notes'),
			'conditions'=> 'OrderItem.seller_id = ProductSeller.seller_id AND OrderItem.product_id = ProductSeller.product_id AND OrderItem.condition_id = ProductSeller.condition_id',
			'foreignKey' => false,
		),
		'SellerUser' => array(
			'type' => 'belongsTo',
			'className' => 'User',
			'foreignKey' => 'seller_id',
			'fields'=>array('id','title', 'firstname', 'lastname'),
		),
		'Message' => array(
			'type' => 'hasMany',
			'className' => 'Message',
			'forgien'=>'order_item_id',
			'fields'=>array('id','from_user_id', 'to_user_id', 'message', 'created'),
		),
		'OrderReturn' => array(
			'type' => 'hasOne',
			'className' => 'OrderReturn',
			'forgien'=>'order_item_id',
		),
		'DispatchedItem' => array(
			'type' => 'hasMany',
			'className' => 'DispatchedItem',
			'forgien'=>'order_item_id',
		),
		'Feedback' => array(
			'type' => 'hasOne',
			'className' => 'Feedback',
			'forgien'=>'order_item_id',
		),
		'ProductItem' => array(
			'type' => 'belongsTo',
			'className' => 'Product',
			'forgien'=>'product_id',
			'type' => 'INNER',
			'fields'=>array('id','quick_code'),
		),
		'Seller' => array(
			'type' => 'belongsTo',
			'className' => 'Seller',
			'foreignKey' => false,
			'conditions' => array('OrderItem.seller_id  = Seller.user_id')
		)
	);
	
	function paginateCount($conditions = null, $recursive = 0, $extra = array()) {
		$parameters = compact('conditions', 'recursive');
		if (isset($extra['group'])) {
			$parameters['fields'] = $extra['group'];
			if (is_string($parameters['fields'])) {
				// pagination with single GROUP BY field
				if (substr($parameters['fields'], 0, 9) != 'DISTINCT ') {
					$parameters['fields'] = 'DISTINCT ' . $parameters['fields'];
				}
				unset($extra['group']);
				$count = $this->find('count', array_merge($parameters, $extra));
			} else {
				// resort to inefficient method for multiple GROUP BY fields
				$count = $this->find('count', array_merge($parameters, $extra));
				$count = $this->getAffectedRows();
			}
		} else {
			// regular pagination
			$count = $this->find('count', array_merge($parameters, $extra));
		}
		return $count;
	}
	
	
	var $validate = array();
}
?>