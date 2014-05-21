<?php
/**
* CancelOrder Model class
*/
class CancelOrder extends AppModel {
	var $name = 'CancelOrder';
	var $validate = array(
		'reason' => array(
			'rule' => 'notEmpty',
			'message' => "Enter reason",
		),
// 		'comment' => array(
// 			'rule' => 'notEmpty',
// 			'message' => "Enter comments",
// 		)
	);
}
?>