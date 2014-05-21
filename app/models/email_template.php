<?php
/**
 * @Name: 		EmailTemplate
 * @description		Model for Email Template Management
 * @created by		Arun kumar
 * @created date	09-11-2009
 *
 **/

class EmailTemplate extends AppModel{
	var $name = 'EmailTemplate';
	var $assocs = array(
		'User' => array(
			'type' => 'belongsTo',
			'className' => 'User',
			'foreignKey' => 'user_id',
		),
		'SiteSuggestion' => array(
			'type' => 'belongsTo',
			'className' => 'SiteSuggestion',
			'foreignKey' => 'site_suggestion_id',
		),
	);
	// server side validations
	var $validate = array(
			'title' => array(
				'NotEmpty'=>array(
					'rule' => array('notEmpty'),
					'message' => 'Enter title'),
				'UniqueField'=>array(
					'rule' => array('isUnique'),
					'message' => 'Enter unique title'
				),
			),
			'subject' => array(
				'rule' => array('notEmpty'),
				'message' => 'Please enter subject'
			),
			'from_email' => array(
				'NotEmpty' =>array(
					'rule' => array('notEmpty'),
					'message' => 'Enter from address email' ,
					'last'=> true
					),
				'ruleName2'=> array(
					'rule' => array('email'),
					'message'=> 'Enter valid email'
				)
			),
		);
}
?>