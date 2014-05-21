<?php
class BlogComment extends AppModel {
	var $name = 'BlogComment';
	var $actsAs = array('Containable');
	
	 var $belongsTo = array(
				'Blog' => array(
				   'className'    => 'Blog',
				   'foreignKey'    => 'blog_id',
				)
			);
	 
	 //server side validations
	 
	 var $validate = array(
		'name' => array(
			'notEmpty'=>array(
				'rule' => array('notEmpty'),
				'message' => 'Please enter name',
				'last' => true,
			),
		),
		'comment' => array(
			'notEmpty'=>array(
				'rule' => array('notEmpty'),
				'message' => 'Please enter comment',
				'last' => true,
			),
		)
		
	);

}
?>