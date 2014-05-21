<?php
class BlogQuestionAnswer extends AppModel {
	var $name = 'BlogQuestionAnswer';
	var $actsAs = array('Containable');
	 var $belongsTo = array(
				'BlogQuestion' => array(
				   'className'    => 'BlogQuestion',
				   'foreignKey'    => 'question_id',
				)
			);
	 
	
	var $validate = array(
		'answer' => array(
			'notEmpty'=>array(
				'rule' => array('notEmpty'),
				'message' => 'Please enter the answer',
				'last' => true,
			),
		),
		'Test' => array(
			'notEmpty'=>array(
				'rule' => array('notEmpty'),
				'message' => 'Please enter the answer',
				'last' => true,
			),
		)
		
		
	);

}
?>