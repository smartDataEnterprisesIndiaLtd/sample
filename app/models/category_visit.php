<?php
/**
 *
* CategoryVisit Model class
*/

class CategoryVisit extends AppModel {
	var $name = 'CategoryVisit';
	var $assocs = array(
		'Category' => array(
			'type' => 'belongsTo',
			'className' => 'Category',
			'foreignKey' => 'category_id',
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
	
	
	/** 
	@function: addVisitedDepartment
	@Created by: Ramanpreet Pal Kaur
	@Modify: 8 August 2011
	*/
	function addVisitedCategory($categoryId = null,$parent_catId = null,$dept_id = null){

		$session_id = session_id();
		$this->data['CategoryVisit']['category_id'] = $categoryId;
		$this->data['CategoryVisit']['parent_id'] = $parent_catId;
		$this->data['CategoryVisit']['department_id'] = $dept_id;
		$this->data['CategoryVisit']['session_id'] = $session_id;
		$this->data['CategoryVisit']['visits'] = 1;
		
		$visited = $this->find('first',array(
			'conditions'=>array("category_id = $categoryId AND  created >= DATE_SUB( NOW( ) , INTERVAL 1 DAY)" ),
			'fields'=> array('CategoryVisit.id')
			));

		if(is_array($visited) ){
			$id = $visited['CategoryVisit']['id'];
			$this->query(" update category_visits set visits=visits+1, created = CURRENT_TIMESTAMP where id = $id");
		} else{ // add the product 
			$this->save($this->data['CategoryVisit']);
		}
	}
	
}
?>