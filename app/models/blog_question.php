<?php
class BlogQuestion extends AppModel {
	var $name = 'BlogQuestion';
	var $actsAs = array('Containable');
	var $hasMany = array(
			'BlogQuestionAnswer' => array(
			'className' => 'BlogQuestionAnswer',
			'foreignKey'    => 'question_id',
			'dependent' => true
				),
			);
	
	
	 
	 //server side validations
	 
	 var $validate = array(
		'question' => array(
			'notEmpty'=>array(
				'rule' => array('notEmpty'),
				'message' => 'Please enter the question',
			),
		),
		
		'correct_answer'=>array(
			'rule' => 'notEmpty',
			'message' => "Please select the correct answer"
		)
		
		
	);

}
?>