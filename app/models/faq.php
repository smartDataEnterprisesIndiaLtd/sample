<?php
/**
* Faq Model class
*/
class Faq extends AppModel {
	var $name = 'Faq';
	var $assocs = array(
		'FaqCategory' => array(
			'type' => 'belongsTo',
			'className' => 'FaqCategory',
		)
	);
	var $validate = array(
		'question' => array(
			'notEmpty'=>array(
				'rule' => array('notEmpty'),
				'message' => 'Please enter question',
			),
		),
		'faq_category_id' => array(
			'notEmpty'=>array(
				'rule' => array('notEmpty'),
				'message' => 'Please select type for this question',
			),
		),
	);
}
?>