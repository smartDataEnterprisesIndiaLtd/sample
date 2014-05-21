<?php
/**
 *
* NewRelease Model class
*/
class Brand extends AppModel {
	var $name = 'Brand';
 	var $assocs = array(
 		'Product' => array(
 			'type' => 'belongsTo',
 			'className' => 'Product',
 			'foreignKey' => 'brand_id',
 		)
 	);
	
	var $validate = array(
		'name' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => "Enter brand name",
				'last' => true
			)
		)
	);
}
?>