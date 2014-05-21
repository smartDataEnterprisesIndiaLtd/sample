<?php
/**
 *
* NewRelease Model class
*/
class Color extends AppModel {
	var $name = 'Color';
 	var $assocs = array(
 		'Product' => array(
 			'type' => 'belongsTo',
 			'className' => 'Product',
 			'foreignKey' => 'color_id',
 		)
 	);
	
	var $validate = array(
		'color_name' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => "Enter Color Name",
				'last' => true
			)
		)
	);
}
?>