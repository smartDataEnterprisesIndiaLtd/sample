<?php
/**
* Address Model class
*/
class ClaimReply extends AppModel {

	var $name = 'ClaimReply';
	var $assocs = array(
		'User' => array(
			'type' => 'belongsTo',
			'className' => 'User',
			'foreignKey' => 'user_id',
			'fields'=>array('User.id', 'User.firstname', 'User.lastname'),
		)
	);
	
}
?>