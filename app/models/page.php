<?php
/**
 * Name:ContentPage Model
 * this model interacts with static_pages table of the database
 *
 **/

class Page extends AppModel{
	var $name = 'Page';
	var $locale = 'en_us';
	// server side validations
	var $validate = array(
			'title' => array(
				'notEmpty'=>array(
					'rule' => array('notEmpty'),
					'message' => 'Please enter page title',
					'last' => true
				)
			),
			'pagecode' => array(
				'notEmpty'=>array(
					'rule' => array('notEmpty'),
					'message' => 'Please enter page code',
					'last' => true,
				),
				'validChars'=>array(
					'rule' => array('custom','/^[a-zA-Z0-9\-]+$/'),
					'message' => 'Please enter valid page code. Characters allowed are a-z, A-Z 0-9 and hyphen',
					'last' => true
				),
				'UniqueField'=>array(
					'rule' => array('isUnique'),
					'message' => 'Please enter unique page code',
					'last' => true
				),
			),
// 			'description' => array(
// 				'rule' => array('notEmpty'),
// 				'message' => 'Please enter page description.'
// 			)
		);
}
?>