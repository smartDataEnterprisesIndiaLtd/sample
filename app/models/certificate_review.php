<?php
/**
* Review Model class
*/
class CertificateReview extends AppModel {
	var $name = 'CertificateReview';
	var $assocs = array(
		'User' => array(
			'type' => 'belongsTo',
			'className' => 'User',
		),
	);
	var $validate = array(
		'user_email' => array(
			'rule' => 'notEmpty',
			'message' => "Enter user email address"
		),
		'review_type' => array(
			'rule' => 'notEmpty',
			'message' => "Enter review type"
		),
		'comments' => array(
			'rule' => 'notEmpty',
			'message' => "Enter comments"
		),
		'reason' => array(
			'rule' => 'notEmpty',
			'message' => "Enter reason"
		),
	);
}
?>