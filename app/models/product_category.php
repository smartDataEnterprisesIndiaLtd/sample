<?php
/**
 *
* ProductCategory Model class
*/
class ProductCategory extends AppModel {
	var $name = 'ProductCategory';
 	var $assocs = array(
 		'Product' => array(
 			'type' => 'belongsTo',
 			'className' => 'Product',
 			'foreignKey' => 'product_id',
 		),
 		'Category' => array(
 			'type' => 'belongsTo',
 			'className' => 'Category',
 			'foreignKey' => 'category_id',
 		),
 	);
	
	/****
	 function to get  category froma  product id
	**/
	function getProductCategory($product_id = null){
		//die($product_id);
		$ProdCategory  = $this->find('first' , array(
			'conditions' => array('ProductCategory.product_id' => $product_id),
			'fields' => array('ProductCategory.category_id' )
			));
		//pr($ProdCategory); die();
		return $ProdCategory['ProductCategory']['category_id']; 
	}
	
	
	/****
	 function to get  category froma  product id
	**/
	function getAllProductCategory($product_id = null){
		$ProdCategories  = $this->find('list' , array(
			'conditions' => array('ProductCategory.product_id' => $product_id),
			'fields' => array('ProductCategory.category_id' )
			));
		return $ProdCategories; 
	}
	
}
?>