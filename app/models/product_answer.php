<?php
/**
* ProductAnswer Model class
*/
class ProductAnswer extends AppModel {
	var $name = 'ProductAnswer';
	var $assocs = array(
		'User' => array(
			'type' => 'belongsTo',
			'className' => 'User',
		),
		'Product' => array(
			'type' => 'belongsTo',
			'className' => 'Product',
 			'foreignKey' => 'product_id',
		),
		'ProductQuestion' => array(
			'type' => 'belongsTo',
			'className' => 'ProductQuestion',
 			'foreignKey' => 'product_question_id',
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
		'answer' => array(
			'rule' => 'notEmpty',
			'message' => "Enter your answer"
		)
	);

}
?>