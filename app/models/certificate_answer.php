<?php
/**
* CertificateAnswer Model class
*/
class CertificateAnswer extends AppModel {
	var $name = 'CertificateAnswer';
	var $assocs = array(
		'User' => array(
			'type' => 'belongsTo',
			'className' => 'User',
		),
		'Certificate' => array(
			'type' => 'belongsTo',
			'className' => 'Certificate',
		),
		'CertificateQuestion' => array(
			'type' => 'belongsTo',
			'className' => 'CertificateQuestion',
 			'foreignKey' => 'certificate_question_id',
		)
	);
	var $validate = array(
		'answer' => array(
			'rule' => 'notEmpty',
			'message' => "Enter your answer"
		)
	);
}
?>