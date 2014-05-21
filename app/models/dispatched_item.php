<?php
/**
* DispatchedItem Model class
*/
class DispatchedItem extends AppModel {
	var $name = 'DispatchedItem';
	var $assocs = array(
		'OrderItem' => array(
			'type' => 'belongsTo',
			'className' => 'OrderItem',
		),
		'Order' => array(
			'type' => 'belongsTo',
			'className' => 'Order',
		),
	);
}
?>