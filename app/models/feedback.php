<?php
/**
* Feedback Model class
*/
class Feedback extends AppModel {
	var $name = 'Feedback';
	var $assocs = array(
		'User' => array(
			'type' => 'belongsTo',
			'className' => 'User',
		),
		'Product' => array(
			'type' => 'belongsTo',
			'className' => 'Product',
		),
		'OrderItem' => array(
			'type' => 'belongsTo',
			'className' => 'OrderItem',
		),
		'Order' => array(
			'type' => 'belongsTo',
			'className' => 'Order',
		),
		'SellerSummary' => array(
			'type' => 'belongsTo',
			'className' => 'User',
			'foreignKey' => 'seller_id',
		),
		// Fro Display Business display name
		'SellerInfo' => array(
			'type' => 'belongsTo',
			'className' => 'Seller',
			'foreignKey' => false,
			'conditions'=>array('Feedback.seller_id = SellerInfo.user_id'),
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
	
	
	var $validate = array(
		'rating' => array('rule' => 'notEmpty',
			'message' => "Enter your rating",
			),
		'feedback' => array('rule' => 'notEmpty',
			'message' => "Enter your feedback comments",
			),
	);
}
?>