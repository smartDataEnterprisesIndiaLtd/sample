<?php
/**
* Category Model class
*/
class Category extends AppModel {
	var $name = 'Category';
	var $assocs = array(
		'Department' => array(
			'type' => 'belongsTo',
			'className' => 'Department',
			'foreignKey' => 'department_id',
		),
 		'CategoryDepartment' => array(
 			'type' => 'belongsTo',
 			'className' => 'Department',
 			'foreignKey' => 'department_id',
			'fields' => array('name'),
 		),
 		'ProductCategory' => array(
 			'type' => 'hasMany',
 			'className' => 'ProductCategory',
			'fields'=>array('ProductCategory.product_id')
 		)
 	);
	var $validate = array(
		'cat_name' => array(
			'notEmpty'=>array(
				'rule' => array('notEmpty'),
				'message' => 'Please enter category name',
			),
		)	      
		);
	
	
	/****
	 function to get child category count
	**/
	function getChildCount($category_id = null){
		$childCatCount  = $this->find('count' , array(
			'conditions' => array('Category.parent_id' => $category_id, 'Category.status' =>1),
			//'fields' => array('Category.id','Category.cat_name' )
			));
		
		return $childCatCount; 
	}
	
	/****
	 function to Cagegory Name
	**/
	function getCategoryname($category_id = null){
		$CategoryName  = $this->find('first' , array(
			'fields' => array('Category.cat_name'),
			'conditions' => array('Category.id' => $category_id, 'Category.status' =>1),
			//'fields' => array('Category.id','Category.cat_name' )
			));
		return $CategoryName['Category']['cat_name']; 
	}
	
	/****
	 function to get child category  array
	**/
	function getTopCategory($department_id = null){
		if(!empty($department_id)){
			$topCategory  = $this->find('list' , array(
				'conditions' => array('Category.department_id' => $department_id,
				'Category.parent_id' => 0, 'Category.status' =>1),
				'fields' => array('Category.id','Category.cat_name' ),'order'=>array('Category.cat_name')
				));
		} else{
			$topCategory  = $this->find('list' , array(
				'conditions' => array('Category.parent_id' => 0, 'Category.status' =>1),
				'fields' => array('Category.id','Category.cat_name' ),'order'=>array('Category.cat_name')
				));
		}
		return $topCategory; 
	}
	
	function getAllCategory($department_id = null){
		if(!empty($department_id)){
			$topCategory  = $this->find('list' , array(
				'conditions' => array('Category.department_id' => $department_id,'Category.status' =>1),
				'fields' => array('Category.id','Category.cat_name' ),'order'=>array('Category.cat_name')
				));
		} else{
			$topCategory  = $this->find('list' , array(
				'conditions' => array('Category.status' =>1),
				'fields' => array('Category.id','Category.cat_name' ),'order'=>array('Category.cat_name')
				));
		}
		return $topCategory; 
	}
	
	
	function getChildCats($catId=null)
	{
	  $sql = "select id from categories where parent_id =".$catId;
	  $res = mysql_query($sql);
	  $raws =array();  
	  while($raw = mysql_fetch_assoc($res))
	  {
	   $raw['sub'] =  $this->getChildCats($raw['id']);
	   $raws[$raw['id']] = $raw;
	  }
	 return $raws;
	}
}
?>