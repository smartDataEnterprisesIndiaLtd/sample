<?php
/**
* BulkUpload Model class
*/
class BulkUpload extends AppModel {
	var $name = 'BulkUpload';
	var $assocs = array(
		'User' => array(
			'type' => 'belongsTo',
			'className' => 'User',
			'foreignKey' => 'user_id',
		),
	);
}
?>