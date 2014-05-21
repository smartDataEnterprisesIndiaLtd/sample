<?php
/**
* Review Model class
*/
class Review extends AppModel {
	var $name = 'Review';
	var $assocs = array(
		'User' => array(
			'type' => 'belongsTo',
			'className' => 'User',
		),
		'Product' => array(
			'type' => 'belongsTo',
			'className' => 'Product',
		),
	);
	var $validate = array(
		'user_email' => array(
			'rule' => 'notEmpty',
			'message' => "Enter user email address"
		),
		'review_type' => array(
			'rule' => 'notEmpty',
			'message' => "Please select review type"
		),
		'product_code' => array(
			'rule' => 'notEmpty',
			'message' => "Enter quick code of product"
		),
		'comments' => array(
			'rule' => 'notEmpty',
			'message' => "Enter comments"
		),
		'reason' => array(
			'rule' => 'notEmpty',
			'message' => "Enter reason"
		),
	);
	
	function paginateCount($conditions = null, $recursive = 0, $extra = array()) {
		$parameters = compact('conditions', 'recursive');
		if (isset($extra['group'])) {
			$parameters['fields'] = $extra['group'];
			if (is_string($parameters['fields'])) {
				// pagination with single GROUP BY field
				if (substr($parameters['fields'], 0, 9) != 'DISTINCT ') {
					$parameters['fields'] = 'DISTINCT ' . $parameters['fields'];
				}
				unset($extra['group']);
				$count = $this->find('count', array_merge($parameters, $extra));
			} else {
				// resort to inefficient method for multiple GROUP BY fields
				$count = $this->find('count', array_merge($parameters, $extra));
				$count = $this->getAffectedRows();
			}
		} else {
			// regular pagination
			$count = $this->find('count', array_merge($parameters, $extra));
		}
		return $count;
	}

}
?>