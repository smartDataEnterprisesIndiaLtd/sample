<?php
/**
* CertificateSearchtag Model class
*/
class CertificateSearchtag extends AppModel {

	var $name = 'CertificateSearchtag';
	var $assocs = array(
		'User' => array(
			'type' => 'belongsTo',
			'className' => 'User',
		),
	);
	var $validate = array(
		'tags' => array(
			'notEmpty'=>array(
				'rule' => array('notEmpty'),
				'message' => 'Please enter search tags',
			),
		)
	);
}
?>