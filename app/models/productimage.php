<?php
/**
 *
* Productimage Model class
*/
class Productimage extends AppModel {
	var $name = 'Productimage';
	var $assocs = array(
		'Product' => array(
			'type' => 'belongsTo',
			'className' => 'Product',
			'foreignKey' => 'product_id',
		)
	);
}
?>