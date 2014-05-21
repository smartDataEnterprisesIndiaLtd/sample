<?php
/**
* ProductQuestion Model class
*/
class ProductQuestion extends AppModel {
	var $name = 'ProductQuestion';
	var $assocs = array(
		'User' => array(
			'type' => 'belongsTo',
			'className' => 'User',
		),
		'Product' => array(
			'type' => 'belongsTo',
			'className' => 'Product',
		),
		'ProductAnswer' => array(
			'type' => 'hasMany',
			'className' => 'ProductAnswer',
			'conditions'=>array('ProductAnswer.status'=>'1'),
			'dependent'=>true
		)
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
		'question' => array(
			'rule' => 'notEmpty',
			'message' => "Enter your question"
		),
		'quick_code' => array(
			'rule' => 'notEmpty',
			'message' => "Enter product quick code"
		)
	);
	
}
?>