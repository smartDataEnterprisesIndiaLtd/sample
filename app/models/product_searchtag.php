<?php
/**
* ProductSearchtag Model class
*/
class ProductSearchtag extends AppModel {

	var $name = 'ProductSearchtag';
	var $assocs = array(
		'Product' => array(
			'type' => 'belongsTo',
			'className' => 'Product',
		),
		'User' => array(
			'type' => 'belongsTo',
			'className' => 'User',
		),
	);
	var $validate = array(
		'quick_code' => array(
			'notEmpty'=>array(
				'rule' => array('notEmpty'),
				'message' => 'Please enter quick code',
			),
		),
		'tags' => array(
			'notEmpty'=>array(
				'rule' => array('notEmpty'),
				'message' => 'Please enter search tags',
			),
		)
	);
}
?>