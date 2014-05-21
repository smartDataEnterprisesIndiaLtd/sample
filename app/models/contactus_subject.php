<?php
/**
* Address Model class
*/
class ContactusSubject extends AppModel {

	var $name = 'ContactusSubject';
	
	var $validate = array(
		'email_to' => array(
			'rule' => 'notEmpty',
			'message' => "Please select message send to"
		),
		'subject' => array(
			'rule' => 'notEmpty',
			'message' => "Please select related subject"
		),
		'email' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => "Enter your email",
				'last' => true
			),
			'ruleName2' => array(
				'rule' => array('email'),
				'message' => "Enter valid email address"
			),
		),
		'comments'=>array(
			'rule' => 'notEmpty',
			'message' => "Please enter comments"
		)
	);
	
}
?>