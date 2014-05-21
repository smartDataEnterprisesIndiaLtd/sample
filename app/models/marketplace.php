<?php
/**
* Marketplace Model class
*/
class Marketplace extends AppModel {
	var $name = 'Marketplace';
	var $useTable = false;
	var $validate = array(
		'search_product_name' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => "Enter product name.",
				'last' => true
			),
		)
	);
}
?>