<?php
/**
* CanceledItem Model class
*/
class CanceledItem extends AppModel {
	var $name = 'CanceledItem';
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