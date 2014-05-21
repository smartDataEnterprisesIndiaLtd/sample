<?php
/**
 *
* DeliveryDestination Model class
*/
class DeliveryDestination extends AppModel {
	var $name = 'DeliveryDestination';
	
	var $validate = array(
		'country_from' => array(
			'rule' => 'notEmpty',
			'message' => "Select dispatch country ",
		),
		'country_to' => array(
			'rule' => 'notEmpty',
			'message' => "Select  destination country",
		),
		'sd_dispatch' => array(
			'rule' => 'notEmpty',
			'message' => "Enter standard dispatch time ",
		),
		'ex_dispatch' => array(
			'rule' => 'notEmpty',
			'message' => "Enter expedited dispatch time ",
		),
		'sd_delivery' => array(
			'rule' => 'notEmpty',
			'message' => "Enter standard delivery time ",
		),
		'ex_delivery' => array(
			'rule' => 'notEmpty',
			'message' => "Enter expedited delivery time ",
		)
	);
}
?>