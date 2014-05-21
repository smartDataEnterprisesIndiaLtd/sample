<?php
/**
 *
* DepartmentVisit Model class
*/

class DepartmentVisit extends AppModel {
	var $name = 'DepartmentVisit';
	var $assocs = array(
		'Department' => array(
			'type' => 'belongsTo',
			'className' => 'Department',
			'foreignKey' => 'department_id',
		),
 	);
	/** 
	@function: addVisitedDepartment
	@Created by: Ramanpreet Pal Kaur
	@Modify: 8 August 2011
	*/
	function addVisitedDepartment($deptId = null){

		$session_id = session_id();
		$this->data['DepartmentVisit']['department_id'] = $deptId;
		$this->data['DepartmentVisit']['session_id'] = $session_id;
		$this->data['DepartmentVisit']['visits'] = 1;
		
		$visited = $this->find('first',array(
			'conditions'=>array("department_id = $deptId AND  created >= DATE_SUB( NOW( ) , INTERVAL 1 DAY)" ),
			'fields'=> array('DepartmentVisit.id')
			));

		if(is_array($visited) ){
			$id = $visited['DepartmentVisit']['id'];
			$this->query(" update department_visits set visits=visits+1, created = CURRENT_TIMESTAMP where id = $id");
		} else{ // add the product 
			$this->save($this->data['DepartmentVisit']);
		}
	}
	
}
?>