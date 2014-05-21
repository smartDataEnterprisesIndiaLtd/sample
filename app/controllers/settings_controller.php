<?php
/**  @class:		SettingsController 
 @description		 etc.,
 @Created by: 		Ramanpreet Pal
 @Modify:		NULL
 @Created Date:		Jan 20, 2011
*/
class SettingsController extends AppController{
	var $name = 'Settings';
	var $helpers = array('Form','Html','Javascript','Format','Session','Ajax','Fck','Validation','Common');
	var $components = array ('RequestHandler','Email','Common');
	var $permission_id = 15; //  for website settings 
	
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
		$includeBeforeFilter = array('admin_index','admin_add_delivery_destination' , 'admin_delivery_destination','admin_changeurl','admin_addurl' );
		if (in_array($this->params['action'],$includeBeforeFilter)){
			// validate admin session
			$this->checkSessionAdmin();
			
			// validate module 
			$this->validateAdminModule($this->permission_id);
		}
	}
	
	
	/**
	@function : admin_index
	@description : to get all settings for the website
	@params : NULL
	@Created by : Ramanpreet Pal
	@Modify : NULL
	@Created Date : 20 Jan, 2011
	*/

	function admin_index(){
		if($this->RequestHandler->isAjax() == 0)
 			$this->layout = 'layout_admin';
 		else
			$this->layout = 'ajax';
		$this->set('listTitle','Website Settings');
		$all_settings = $this->Setting->getColumnTypes();
		
		
		// get a list of destination country for website location  
		$destinationCuntries = $this->Common->getDispatchCountryList();
		$this->set('destinationCuntries',$destinationCuntries);
		
		if(!empty($this->data)){
			$this->Setting->set($this->data);
			
			if($this->Setting->validates()) {
				if($this->Setting->save($this->data)) {
					$this->Session->setFlash('Information updated successfully.');
				}else{
					$this->Session->setFlash('Information not updated, please try again.','default',array('class'=>'flashError'));
				}
			} else{
				$this->set('errors',$this->Setting->validationErrors);
				//pr($this->Setting->validationErrors);
			}
		}
		$this->data = $this->Setting->find('first');
		$this->set('all_settings',$all_settings);
	}
	
	
	
	
	/**
	@function:admin_delivery_destination 
	@Created : Kulvinder Singh
	@Created Date : 22 March, 2011
	*/
	function admin_delivery_destination() {
		$this->layout = 'layout_admin';
		$this->set('listTitle','Manage Delivery Destinations');
		// get a list of all country 
		$countries = $this->Common->getDispatchCountryList();
		$this->set('countries',$countries);
		$criteria = " 1 ";
		if(!empty($this->data['Search'])){
			if(!empty($this->data['Search']['country_from'])){
				$criteria .= " AND DeliveryDestination.country_from = ".$this->data['Search']['country_from'];
			}
			if(!empty($this->data['Search']['country_to'])){
				$criteria .= " AND DeliveryDestination.country_to = ".$this->data['Search']['country_to'];
			}
		}
		//echo $criteria;
		/* ******************* page limit sction **************** */
		$sess_limit_name = $this->params['controller']."_limit";
		$sess_limit_value = $this->Session->read($sess_limit_name);
		if(!empty($this->data['Record']['limit'])){
			$limit = $this->data['Record']['limit'];
			$this->Session->write($sess_limit_name , $this->data['Record']['limit'] );
		}elseif(!empty($sess_limit_value)){
			$limit = $sess_limit_value;
		}else{
			$limit = $this->records_per_page;  // set default value
		}
		$this->data['Record']['limit'] = $limit;
		/* ******************* page limit sction **************** */
		
		App::import('Model','DeliveryDestination');
		$this->DeliveryDestination = new DeliveryDestination();
		$this->paginate = array(
			'limit' => $limit,
			'order' => array(
				'DeliveryDestination.id' => 'DESC'
			),
		);
		
		$this->set('destinationData', $this->paginate('DeliveryDestination', $criteria));	
		
		
	}
	
	/**
	@function:admin_add_delivery_destination 
	@Created : Kulvinder Singh
	@Created Date : 22 March, 2011
	*/
	function admin_add_delivery_destination($id = null) {
		
		$this->set('id',$id);
		$this->layout = 'layout_admin';
		$this->set('listTitle','Add Delivery Destination');
		
		// get a list of all country 
		$countries = $this->Common->getDispatchCountryList();
		$this->set('countries',$countries);
		
		App::import('Model','DeliveryDestination');
		$this->DeliveryDestination = new DeliveryDestination();

		if(!empty($this->data)){
			$this->DeliveryDestination->set($this->data);
			$destinationValidate = $this->DeliveryDestination->validates();
			if(!empty($destinationValidate) ){
					$this->DeliveryDestination->set($this->data);
					if($this->DeliveryDestination->save()) {
						$this->Session->setFlash('Information entered successfully.');
					}else{
						$this->Session->setFlash('Error in processing.','default',array('class'=>'flashError'));
					}
					$this->redirect('/admin/settings/delivery_destination');
			} else {
				$errorArray = $this->DeliveryDestination->validationErrors;
				$this->set('errors',$errorArray);
			}
		} else{
			if(!empty($id)) {
				$this->DeliveryDestination->id = $id;
				$this->data= $this->DeliveryDestination->read();
				
			}
		}
	}
	/** 
	@function :	admin_changeurl
	@description :	used in admin edit product page to display more barcode related to one product.
	@Created by:	Nakul Kumar
	@params
	@Modify:
	@Created Date: 23-10-2011
	*/
	function admin_changeurl(){
		$this->layout='layout_admin';
		Configure::write('debug', 2);
		$this->set('title_for_layout','Change Url');
		App::import('Model','ChangeUrl');
		$this->ChangeUrl = new ChangeUrl;
		//$this->ProductSeller->expects(array('Product'));
		$criteria='';
		
		/* ******************* page limit sction **************** */
		$sess_limit_name = $this->params['controller']."_limit";
		$sess_limit_value = $this->Session->read($sess_limit_name);
		if(!empty($this->data['Record']['limit'])){
		   $limit = $this->data['Record']['limit'];
		   $this->Session->write($sess_limit_name , $this->data['Record']['limit'] );
		} elseif( !empty($sess_limit_value) ){
			$limit = $sess_limit_value;
		} else{
			$limit = $this->records_per_page;  // set default value
		}
		$this->data['Record']['limit'] = $limit;
		/* ******************* page limit sction **************** */
		$this->paginate = array(
			'limit' => $limit,
			'order' => array(
				'ChangeUrl.id' => 'DESC'
				),
			'fields'=> array('ChangeUrl.id','ChangeUrl.current_url','ChangeUrl.change_url')
		);
		$this->set('arrChangeUrl',$this->paginate('ChangeUrl',$criteria));
		$this->set('count_products',$this->ChangeUrl->find('count',array('conditions'=>$criteria)));
	}
	
	/** ***********************************************************************
	@function	:	admin_addurl
	@description	:	to add/edit Url 
	@params		:	NULL
	@created	:	Oct 14,2011
	@credated by	:	Nakul kumar
	**/
	
	function admin_addurl($id = null) {
		Configure::write('debug',2);
		if($this->RequestHandler->isAjax() == 0)
 			$this->layout = 'layout_admin';
 		else
			$this->layout = 'ajax';
			
		if(!is_null($id) ){
			$this->set('listTitle','Update');
		}else{
			$this->set('listTitle','Add New');
		}
		App::import('Model','ChangeUrl');
		$this->ChangeUrl = new ChangeUrl();
		
		if(empty($this->data)){
			$this->ChangeUrl->id=$id;
			$this->data=$this->ChangeUrl->read();
		}elseif(!empty($this->data)){
			if($this->ChangeUrl->validates()) {
				if($this->ChangeUrl->save($this->data)) {
					if(!empty($this->data['ChangeUrl']['id']) ){
					$this->Session->setFlash('The url information update successfully.');
					}else{
					$this->Session->setFlash('The url information seved successfully.');
					}
				}else{
					$this->Session->setFlash('The url information not seved, please try again.','default',array('class'=>'flashError'));
				}
			} else{
				$this->set('errors',$this->ChangeUrl->validationErrors);
			}
		}
	}
	
	/** 
	@function	:	admin_deleteurl
	@description	:	to delete 
	@params		:	NULL
	@created	:	Oct 14,2010
	@credated by	:	Nakul kumar
	**/
	function admin_deleteurl($id = null) {
		
		App::import('Model','ChangeUrl');
		$this->ChangeUrl = new ChangeUrl;		
		$this->ChangeUrl->deleteAll("ChangeUrl.id ='".$id."'", true);
		$this->Session->setFlash("Url has been deleted successfully.");
		$this->redirect(array('controller'=>'Settings','action'=>'changeurl'));
	}
	
} // class function ends here
?>