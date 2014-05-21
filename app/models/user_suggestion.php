<?php
/**
 *
* Basket Model class
*/

class UserSuggestion extends AppModel {
	var $name = 'UserSuggestion';
	var $validate = array(
		'suggestion' => array(
			'rule' => 'notEmpty',
			'message' => "Enter Your Suggestion",
		)
	);
}
?>