<?php
/**
* Department Model class
*/
class Department extends AppModel {
	var $name = 'Department';
	
	var $validate = array(
		'name' => array(
			'notEmpty'=>array(
				'rule' => array('notEmpty'),
				'message' => 'Please enter department name',
			),
		),
	);
	
	// function to get name of department from department id
	function getDepartmentName($department_id =  null) {
		$result = $this->find('first', array('conditions' => array('Department.id' => $department_id , 'Department.status'=>1),'fields'=>array('Department.name')));
		return $result['Department']['name'];
	}
	
	
	function getList_departments() {
		$result = $this->find('list', array('conditions' => array('Department.status'=>1),'fields'=>array('Department.id','Department.name')));
		return $result;
	}
	//for get fh department
	function getListFh_departments() {
		$result = $this->find('all', array('conditions' => array('Department.status'=>1),'fields'=>array('Department.id','Department.name')));
		foreach($result as $result){
			$fh_departments[str_replace(array('&',' '), array('_','_'), html_entity_decode(strtolower($result['Department']['name']), ENT_NOQUOTES, 'UTF-8'))] = $result['Department']['id'];
		}
		//pr($fh_departments);
		return $fh_departments;
	}
}
?>