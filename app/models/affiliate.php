<?php
/**
* Affiliate Model class
*/
class Affiliate extends AppModel {
    var $name = 'Affiliate';
    
   // server side validations
	var $validate = array(
			'title' => array(
				'NotEmpty'=>array(
					'rule' => array('notEmpty'),
					'message' => 'Please enter title'),
				'UniqueField'=>array(
					'rule' => array('isUnique'),
					'message' => 'Please enter unique title'
				),

			),
			'content' => array(
				'rule' => array('notEmpty'),
				'message' => 'Please enter page description'
			)
		);
}
?>