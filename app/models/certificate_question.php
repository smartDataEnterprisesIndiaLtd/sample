<?php
/**
* CertificateQuestion Model class
*/
class CertificateQuestion extends AppModel {
	var $name = 'CertificateQuestion';
	var $assocs = array(
		'User' => array(
			'type' => 'belongsTo',
			'className' => 'User',
		),
		'CertificateAnswer' => array(
			'type' => 'hasMany',
			'className' => 'CertificateAnswer',
			'conditions'=>array('CertificateAnswer.status'=>'1'),
			'dependent'=>true
		)
	);
	var $validate = array(
		'question' => array(
			'rule' => 'notEmpty',
			'message' => "Enter your question"
		),
	);



}
?>