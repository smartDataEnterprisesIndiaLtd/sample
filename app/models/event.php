<?php
/**
 *
* Country Model class
*/
class Event extends AppModel {
	var $name = 'Event';
	var $assocs = array(
		'User' => array(
			'type' => 'belongsTo',
			'className' => 'User',
			'foreignKey' => 'user_id',
		)
	);
	var $validate = array(
		'message' => array(
			'rule' => array('notEmpty'),
			'message' => 'Please enter event'
		),
	);
}
?>