<?php

App::import('Sanitize');
class HomepageProductsController extends AppController{
	var $name = 'HomepageProducts';
	var $helpers = array('Form','Html','Javascript','Session','Format','Common','Validation');
	var $components = array ('RequestHandler', 'File', 'Common');

	var $permission_id = 5 ;  // for product module
	
	var $notRequiredFields = array('id','department_id','heading1','heading2','heading3','heading4', 'modified');
		
	/**
	* @Date: Nov 12, 2010
	* @Method : beforeFilter
	* Created By: kulvinder singh
	* @Purpose: This function is used to validate admin user permissions
	* @Param: none
	* @Return: none 
	**/
	function beforeFilter(){
		
		//check session other than admin_login page
		$excludeBeforeFilter = array('view','');
		if (!in_array($this->params['action'],$excludeBeforeFilter))
		{
			// validate admin session
			$this->checkSessionAdmin();
			// validate admin users for this module
			$this->validateAdminModule($this->permission_id);
			
			
			
		}
	}
	
	/**
	@function:	admin_index
	@description:	listing of home and other departments
	@params:	NULL
	@Created by: 	kulvinder singh
	@Modify:	NULL
	@Created Date:	19-Nov 2010
	*/		

	function admin_index(){
		$this->layout = 'layout_admin';
		$criteria = '';
	/* ******************* page limit sction **************** */
		$sess_limit_name = $this->params['controller']."_limit";
		$sess_limit_value = $this->Session->read($sess_limit_name);
		if(!empty($this->data['Record']['limit'])){
		   $limit = $this->data['Record']['limit'];
		   $this->Session->write($sess_limit_name , $this->data['Record']['limit'] );
		}elseif( !empty($sess_limit_value) ){
			$limit = $sess_limit_value;
		}else{
			$limit = 25;
		}
		$this->data['Record']['limit'] = $limit;
		/* ******************* page limit sction **************** */
		$this->HomepageProduct->expects( array('Department') );
		$this->paginate = array(
			'limit' => $limit,
			'order' => array(
					'HomepageProduct.id' => 'ASC'
				),
			'fields' => array(
					'HomepageProduct.id','HomepageProduct.modified',
					'Department.name',
				),
			
		);
		$this->set('listTitle','Manage Home/Department Page Display Products');
		$arrHomepageDepartments = $this->paginate('HomepageProduct',$criteria);
		$this->set('arrHomepageDepartments',$arrHomepageDepartments);
	}

	/**
	@function:admin_add 
	@description:Add/edit Home/department page Products,
	@params:id
	@Created by: kulvinder singh
	@Modify:NULL
	@Created Date: 19 Nov  2010
	*/
	function admin_editproducts($id=Null ,$pageName){
		$this->layout = 'layout_admin';
		$this->set("id",$id);
		$pageName = urldecode($pageName);
		$this->set("pageName",$pageName);
		
		$this->set('listTitle','Edit Products for '.$pageName);
		
			$this->HomepageProduct->id = $id;
			$homePageData   = $this->HomepageProduct->findById($id);
			$department_id = $homePageData['HomepageProduct']['department_id'];
			
			#################################
			$departments = $this->Common->getdepartments();
			$this->set('departments',$departments);
			
			if($id >1){ // only for department case
				$topcategories = $this->Common->getTopCategories($department_id);
				$this->set('topcategories',$topcategories);
			}
			#################################
			
			
		
		// array of filelds which need to be excluded for set the code
		$notRequiredFields = $this->notRequiredFields;
			
		if(!empty($this->data)){ 
			$this->HomepageProduct->set($this->data);
			if($this->HomepageProduct->validates()){
				
				$wrongCodes = $this->ValidateProductCodes($this->data['HomepageProduct']);
				
				if( $wrongCodes == '' || empty($wrongCodes)  ){ // if product for this code is existing
					
					// iterate the array and set product quick code for each product id
					foreach($this->data['HomepageProduct'] as $key=>$value){
						if( !in_array($key, $notRequiredFields) ){
							$this->data['HomepageProduct'][$key] = $this->getProductIdfromQuickCode($value);
						}
					}
					
					$this->data = Sanitize::clean($this->data);
					$this->HomepageProduct->set($this->data);
					if ($this->HomepageProduct->save($this->data)) {
						$this->Session->setFlash('Records has been submitted successfully.');
						$this->redirect('/admin/homepage_products/');
					}else {
						$this->set('errors',$this->HomepageProduct->validationErrors);
					}
					
				}else{
					$this->Session->setFlash('Following quick codes does not belongs to any product <br>'. $wrongCodes);
				}
			} else {
			}
		} else{
			
			$this->data = $homePageData;
			
			// iterate the array and set product quick code for each product id
			foreach($this->data['HomepageProduct'] as $key=>$value){
				if( !in_array($key, $notRequiredFields) ){
					$this->data['HomepageProduct'][$key] = $this->admin_getProductCodeById($value);
				}
			}
		}
	}
	
	
	
	/**************************
	function to get product id from product quick code
	**/
	function getProductIdfromQuickCode($quickCode){
		
		if(!empty($quickCode)){ 
			App::import('Model', 'Product');
			$this->Product = new Product;
			$prodArr   = $this->Product->find('first' , array(
			'conditions' => array('Product.quick_code' => trim($quickCode) ),
			'fields' => array('Product.id')
			));
			
			if(!empty($prodArr)  &&  count($prodArr) > 0  ){
				if($prodArr['Product']['id'] == ''){
					return false;
				}else{
					return $prodArr['Product']['id'];
				}
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
	
	
	/***************************
	function to get product code from product id
	
	*/
	function admin_getProductCodeById($id=Null){
		
		App::import('Model', 'Product');
		$this->Product = new Product;
		$prodArr   = $this->Product->find('first' , array(
		'conditions' => array('Product.id' => $id ),
		'fields' => array('Product.quick_code')
		));
		return $prodArr['Product']['quick_code'];
	}
	
	// function  to validate all the product codes entered
	function ValidateProductCodes($dataArr){
		$wrongCodes = array();
		$notRequiredFields = $this->notRequiredFields;
		// iterate the array and set product quick code for each product id
		foreach($dataArr as $key=>$value){
			
			if( !in_array($key, $notRequiredFields) ){
				
				if(!empty($value)){ 
					$product_id = $this->getProductIdfromQuickCode($value);
					if($product_id == false)
					{
						$wrongCodes[] = $value;	
					}
				}
			}
		}
		if(is_array($wrongCodes)){
			$wrongCodes = array_unique($wrongCodes);
			return $codes = implode(',',$wrongCodes);
		}else{
			return false;
		}
	}
}
?>