<?php

class SpecialProductsController extends AppController{
	var $name = 'SpecialProducts';
	var $helpers = array('Form','Html','Javascript','Session','Format','Validation');
	var $components = array ('RequestHandler', 'File');

	var $permission_id = 5 ;  // for product module
	
	/**
	* @Date: Nov 15, 2010
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
			// validate admin users for this module
			$this->validateAdminModule($this->permission_id);
			
			// validate admin session
			$this->checkSessionAdmin();
		}
	}
	
	/**
	@function:	admin_viewdepartment
	@description:	listing of special departments
	@Created by: 	kulvinder singh
	@Modify:	NULL
	@Created Date:	15-Nov 2010
	*/	
	function admin_viewdepartment(){
		$this->layout = 'layout_admin';
		// import department model
		App::import('Model', 'Department');
		$this->Department = new Department;
		// import  special department model
		App::import('Model', 'SpecialDepartment');
		$this->SpecialDepartment = new SpecialDepartment;
	
		$this->SpecialDepartment->expects( array('Department') );
		$ArrSpecialDepartments  = $this->SpecialDepartment->find('all' , array(
						'fields' => array('Department.name' ,'SpecialDepartment.id',
								  'SpecialDepartment.department_id')
						));
		
		$this->set('listTitle','Manage Special Departments');
		$this->set('ArrSpecialDepartments',$ArrSpecialDepartments);
	}
	
	/**
	@function:	admin_viewdepartment
	@description:	listing of special departments
	@Created by: 	kulvinder singh
	@Modify:	NULL
	@Created Date:	15-Nov 2010
	*/	
	function admin_editdepartment($id = null){
		$this->layout = 'layout_admin';
		$this->set('listTitle','Edit Departments');
		$this->set('id', $id );
		
		# import department model 
		App::import('Model', 'Department');
		$this->Department = new Department;
		
		$ArrAllDepartments   = $this->Department->find('list' , array(
						'fields' => array('Department.id','Department.name')
					));
		$this->set('ArrAllDepartments',$ArrAllDepartments);
		
		// import special department model for fetching the departmemt list		
		App::import('Model', 'SpecialDepartment');
		$this->SpecialDepartment = new SpecialDepartment;
		
		if(!empty($this->data) ){ // data submitted
			$this->SpecialDepartment->set($this->data);
			if($this->SpecialDepartment->validates() ){ //data validated
				$this->SpecialDepartment->save($this->data);
				$this->Session->setFlash('Records has been submitted successfully.');
				$this->redirect('/admin/special_products/viewdepartment');
							
			}else{ //validation error 
				$this->set('errors',$this->SpecialProduct->validationErrors);
			}
			
		}else{ // 
			$this->SpecialDepartment->id = $id;
			$this->data   = $this->SpecialDepartment->find('first' , array(
				'conditions' => array('SpecialDepartment.id' => $id ),
				'fields' => array('SpecialDepartment.id','SpecialDepartment.department_id')
				));
		}
		//pr($this->data);
	}
	
	/**
	@function:	admin_viewproducts
	@description:	listing of special  products,
	@params:	NULL
	@Created by: 	kulvinder singh
	@Modify:	NULL
	@Created Date:	15-Nov 2010
	*/		
	function admin_viewproducts($special_department_id=Null){
		$this->layout = 'layout_admin';
	// validate special department id		
		if( empty($special_department_id) ){ // department position id  missing
			$this->Session->setFlash('Error: request can not be completed. department position id missing');
			$this->redirect('/admin/special_products/viewdepartment/');
		}
		$this->set("special_department_id",$special_department_id);
				
		# import department model 
		App::import('Model', 'Department');
		$this->Department = new Department;
		$ArrDepartment   = $this->Department->find('first' , array(
						'conditions'=>array('Department.id='.$special_department_id),
						'fields' => array('Department.id','Department.name')
					));
		
		$this->set('listTitle','View Special Products for '.$ArrDepartment['Department']['name'] );
		
		$criteria = '1';
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
		$this->SpecialProduct->expects( array('Product') );
		$this->paginate = array(
			'limit' => $limit,
			'order' => array(
					'SpecialProduct.id' => 'ASC'
				),
			'conditions'=>array( 'SpecialProduct.special_department_id ='.$special_department_id ),
			'fields' => array(
					'SpecialProduct.id','SpecialProduct.special_department_id',
					'Product.quick_code','Product.product_name',
				),
			
		);
		$arrSpecialProducts = $this->paginate('SpecialProduct');
		$this->set('arrSpecialProducts',$arrSpecialProducts);
	}

	/**
	@function:admin_addproduct 
	@description: add  special product for a special department
	@params:id
	@Created by: kulvinder singh
	@Modify:NULL
	@Created Date: 15 Nov  2010
	*/
	function admin_addproduct($special_department_id=Null){
		$this->layout = 'layout_admin';
		$this->set('listTitle','Add Special Product');
		if( empty($special_department_id) ){ // department position id  missing
			$this->Session->setFlash('Error: request can not be completed. department position id missing');
			$this->redirect('/admin/special_products/viewdepartment/');
		}
		$this->set("special_department_id",$special_department_id);
		
		if(!empty($this->data)){
			$this->SpecialProduct->set($this->data);
			if($this->SpecialProduct->validates()){
				// get product ids and product code
				App::import('Model', 'Product');
				$this->Product = new Product;
				$prodArr   = $this->Product->find('first' , array(
				'conditions' => array('Product.quick_code' => $this->data['SpecialProduct']['quick_code'] ),
				'fields' => array('Product.id', 'Product.quick_code')
				));

				if( !empty($prodArr) && is_array($prodArr)  ){ // if product for this code is existing
					
					$conditions = array('SpecialProduct.product_id ='.$prodArr['Product']['id'],
					    'SpecialProduct.special_department_id ='.$this->data['SpecialProduct']['special_department_id']
					    );
				
					$ArrCheck   = $this->SpecialProduct->find('first' , array(
					'conditions' => $conditions ,
					'fields' => array('SpecialProduct.id')
					));

					if( empty($ArrCheck) && !is_array($ArrCheck)  ){
						$this->data['SpecialProduct']['id'] = 0 ; 
						$this->data['SpecialProduct']['product_id'] = $prodArr['Product']['id'];
					//	pr($this->data); //die();
						if ($this->SpecialProduct->save($this->data)) {
							//die();
							$this->Session->setFlash('Records has been submitted successfully.');
							$this->redirect('/admin/special_products/viewdepartment/');
						}else {
							$this->set('errors',$this->SpecialProduct->validationErrors);
						}
					}else{
							$this->Session->setFlash('Product for this position has added allready in the list.');
					}
				}else{
					$this->Session->setFlash('This product  does not exists.');
					//$this->redirect('/admin/SpecialProducts/add');
				}
			} else {
				$this->set('errors',$this->SpecialProduct->validationErrors);
			}
		} else{
			
		}
	}
	
	/** 
	@function	:	admin_multiplAction
	@description	:	Active/Deactive/Delete multiple record
	@params		:	NULL
	@created	:	
	@modified by	:	Kulvinder Singh
	**/
	function admin_multiplAction(){

		if($this->data['SpecialProduct']['status']=='active'){
			foreach($this->data['select'] as $id){
				if(!empty($id)){
				$this->SpecialProduct->id=$id;
				$this->SpecialProduct->saveField('status','1');
				$this->Session->setFlash('Records has been updated  successfully.');
				}	
			}
		} elseif($this->data['SpecialProduct']['status']=='inactive'){
			foreach($this->data['select'] as $id){
				if(!empty($id)){
					$this->SpecialProduct->id=$id;
					$this->SpecialProduct->saveField('status','0');
					$this->Session->setFlash('Records has been updated  successfully.');	
				}
			}
		} elseif($this->data['SpecialProduct']['status']=='del'){
			foreach($this->data['select'] as $id){
				if(!empty($id)){
					$this->SpecialProduct->delete($id);
					$this->Session->setFlash('Records has been deleted successfully.');	
				}
			}
		}
		/** for searching and sorting*/
		$this->redirect('/admin/special_products/viewproducts/'.$this->data['SpecialProduct']['special_department_id']);
	}

	/** 
	@function	:	admin_delete
	@description	:	Delete the content page
	@params		:	$id=id of row
	@created	:	
	@credated by	:	
	@modified by	:	Kulvinder Singh
	**/
	function admin_delete($id=null, $department_id= null){
		if(!empty($id)){
			$this->SpecialProduct->delete($id);
			$this->Session->setFlash('Records has been deleted successfully.');	
		} else{
			$this->Session->setFlash('Records has not deleted.');	
		}
		$this->redirect('/admin/special_products/viewproducts/'.$department_id);
	}
}
?>