<?php
/**
* Setting Model class
*/
class Setting extends AppModel {
	var $name = 'Setting';
	var $validate = array(
		'tax' =>array(
			'rule' => 'notEmpty',
			'message' => 'Enter tax'
			),
		'gift_wrap_charges' =>array(
			'rule' => 'notEmpty',
			'message' => 'Enter gift wrap charges'
			),
		'insurance_charges' =>array(
			'rule' => 'notEmpty',
			'message' => 'Enter insurance charges'
			),
		'website_home_location' =>array(
			'rule' => 'notEmpty',
			'message' => 'Select home location'
			),
		
		
		
		
		
	);
	
}
?>