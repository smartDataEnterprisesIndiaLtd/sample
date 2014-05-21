<?php

class BrandsController extends AppController{
	var $name = 'Brands';
	var $helpers = array('Form','Html','Javascript','Session','Format','Validation');
	var $components = array ('RequestHandler', 'File');

	var $permission_id = 5 ;  // for product module
	
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
			// validate admin users for this module
			$this->validateAdminModule($this->permission_id);
			
			// validate admin session
			$this->checkSessionAdmin();
			
		}
	}
	/**
	@function:	admin_index
	@description:	listing of hot products,
	@params:	NULL
	@Created by: 	kulvinder singh
	@Modify:	NULL
	@Created Date:	12-Nov 2010
	*/		

	function admin_index(){
		$this->layout = 'layout_admin';
		
		if(empty($this->data)){
			if(isset($this->params['named']['searchin']))
				$this->data['Search']['searchin']=$this->params['named']['searchin'];
			else
				$this->data['Search']['searchin']='';
	
			if(isset($this->params['named']['keyword']))
				$this->data['Search']['keyword']=$this->params['named']['keyword'];
			else
				$this->data['Search']['keyword']='';
			if(isset($this->params['named']['showtype']))
				$this->data['Search']['show']=$this->params['named']['showtype'];
			else
				$this->data['Search']['show']='';
		}
		$value = '';	
		$fieldname = '';
		$criteria = '1';
		/** SEARCHING **/
		$reqData = $this->data;
		
		if(!empty($this->data['Search'])){
			
			if(empty($this->data['Search']['searchin'])){
				$fieldname = '';
			} else {
				$fieldname = $this->data['Search']['searchin'];
			}
			$value = $this->data['Search']['keyword'];
		//$show  = $this->data['Search']['show'];
			// sanitze the search data
			App::import('Sanitize');
			$value1 = Sanitize::escape($value);
			
			$fieldname = 'name';
			if($value1 !="") {
				
				if(trim($fieldname)!=''){ 
					if(isset($value) && $value !="") {
						$criteria .= " and Brand.".$fieldname." LIKE '%".$value1."%'";
					}
				}
			}
		}
		$this->set('keyword', $value);
		$this->set('fieldname',$fieldname);
		$this->set('heading','Brands');
		
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
		$this->paginate = array(
			'limit' => $limit,
			'order' => array(
					'Brand.name' => 'ASC'
				)
		);
		$this->set('listTitle','Manage Brands');
		$arrBrands = $this->paginate('Brand',$criteria);
		$this->set('count_brand',$this->Brand->find('count',array('conditions'=>$criteria)));
		$this->set('arrBrands',$arrBrands);
	}

	/**
	@function:admin_add 
	@description:Add/edit Brands,
	@params:id
	@Created by: kulvinder singh
	@Modify:NULL
	@Created Date: 20 Nov  2010
	*/
	function admin_add($id=Null){
		$this->layout = 'layout_admin';
		if( !empty($id) ){ // edit
			$this->set('listTitle','Edit');
		}else{
			$this->set('listTitle','Add');	
		}
		$this->set("id",$id);
		if(!empty($this->data)){
			$this->Brand->set($this->data);
			if($this->Brand->validates()){
				# clean the data before save
				uses('Sanitize');
				$this->Sanitize = new Sanitize;
				$this->data =Sanitize::clean($this->data);
				
				
				if ($this->Brand->save($this->data)) {
					$this->Session->setFlash('Records has been submitted successfully.');
					$this->redirect('/admin/brands/');
				}else {
					$this->set('errors',$this->Brand->validationErrors);
				}
			} else {
				$this->set('errors',$this->Brand->validationErrors);
			}
		} else{
			
			$this->Brand->id = $id;
			$this->data   = $this->Brand->findById($id);
			if(!empty($this->data['Brand'])){
				foreach($this->data['Brand'] as $field_index => $info){
					$this->data['Brand'][$field_index] = html_entity_decode($info);
					$this->data['Brand'][$field_index] = str_replace('&#039;',"'",$this->data['Brand'][$field_index]);
					$this->data['Brand'][$field_index] = str_replace('\n',"",$this->data['Brand'][$field_index]);
				}
			}
		}
	}
	
	/** 
	@function	:	admin_multiplAction
	@description	:	Active/Deactive/Delete multiple record
	@params		:	NULL
	@created	:	
	@credated by	:	
	**/
	function admin_multiplAction(){
		//check that admin is login
		$this->checkSessionAdmin();
		if($this->data['Brand']['status']=='active'){
			foreach($this->data['select'] as $id){
				if(!empty($id)){
				$this->Brand->id=$id;
				$this->Brand->saveField('status','1');
				$this->Session->setFlash('Records has been updated  successfully.');
				}	
			}
		} elseif($this->data['Brand']['status']=='inactive'){
			foreach($this->data['select'] as $id){
				if(!empty($id)){
					$this->Brand->id=$id;
					$this->Brand->saveField('status','0');
					$this->Session->setFlash('Records has been updated  successfully.');	
				}
			}
		} elseif($this->data['Brand']['status']=='del'){
			foreach($this->data['select'] as $id){
				if(!empty($id)){
					$this->Brand->delete($id);
					$this->Session->setFlash('Records has been deleted successfully.');	
				}
			}
		}
		/** for searching and sorting*/
		$this->redirect('/admin/brands');
	}

	/** 
	@function	:	admin_delete
	@description	:	Delete the brand
	@params		:	$id=id of row
	@created	:	12 Nov 2010
	@credated by	:	Kulvinder Singh
	**/
	function admin_delete($id=null){
		if(!empty($id)){
			$arrProducts = $this->getProductByBrand($id);
			//pr($arrProducts); die();
			if(is_array($arrProducts) && count($arrProducts) > 0 ){
				$this->Session->setFlash('Brand can not be deleted. As some products have associated with this brand.');
				
			}else{
				$this->Brand->delete($id);
				$this->Session->setFlash('Records has been deleted successfully.');
			}
		} else{
			$this->Session->setFlash('Records has not been deleted.');	
		}
		$this->redirect('/admin/brands');
	}
	
	/*
	 function to get list of product
	 
	*/
	function getProductByBrand($brand_id = null){
		App::import('Model','Product');
		$this->Product = new Product;
		$prodDetails = $this->Product->find('list',array(
			'conditions'=>array('Product.brand_id'=>$brand_id),
			'fields'=> array( 'Product.id', 'Product.brand_id' )
			));
		return $prodDetails;

	}
/***********       ********* */


/** 
	@function:		admin_export 
	@description:		export barnds and its data as csv
	@params:		
	@Modify:		
	@Created Date:		15-March-2013
	*/
	
	function admin_export(){
		
	$this->data = $this->Brand->find('all',array('fields'=>array('Brand.id','Brand.name','Brand.created'),'order'=>array('TRIM(Brand.name) ASC')));
	
		#Creating CSV
 		$csv_output = "BrandId,Name,Created";
		$csv_output .= "\n";
		if(count($this->data) > 0){
			foreach($this->data as $value){
				
				foreach($value['Brand'] as $field_index => $user_info){
					$value['Brand'][$field_index] = html_entity_decode($user_info);
					$value['Brand'][$field_index] = str_replace('&#039;',"'",$value['Brand'][$field_index]);
				}
				

		$csv_output .= trim($value['Brand']['id']).",".trim($value['Brand']['name']).",".trim($value['Brand']['created'])."\n";
			}
		}else{
			$csv_output .= "No Record Found.."; 
		}
		
		
		header("Content-type: application/vnd.ms-excel");
		$filePath="brands_".date("Ymd").".csv";
		header("Content-Disposition: attachment; filename=".$filePath."");
		header("Pragma: no-cache");
		header("Expires: 0");
		print $csv_output;
		exit;
	}	
	
	

}
?>