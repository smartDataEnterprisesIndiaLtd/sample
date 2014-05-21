<?php
/**  @class : CouponsController 
 @description : discount_coupon  etc.,
 @Created by : 	
 @Modify : NULL
 @Created Date : Dec 8, 2010
*/

App::import('Sanitize');
class CouponsController extends AppController{
	var $name = 'Coupons';
	var $helpers = array('Form','Html','Javascript','Format','Session','Ajax','Fck','Validation','Common');
	var $components = array ('RequestHandler','Email');

	var $permission_id = 9;  // for promotions module
	
	/**
	* @Date: Nov 01, 2010
	* @Method : beforeFilter
	* Created By: kulvinder singh
	* @Purpose: This function is used to validate admin user permissions
	* @Param: none
	* @Return: none 
	**/
	function beforeFilter(){
		//check session other than admin_login page
		$includeBeforeFilter = array('admin_index','admin_add' , 'admin_status' , 'admin_delete', 'admin_multiplAction');
		if (in_array($this->params['action'],$includeBeforeFilter))
		{
			// validate admin users for this module
			$this->validateAdminModule($this->permission_id);
			// validate admin session
			$this->checkSessionAdmin();
		}
	}
	
	/**
	@function : admin_index
	@description : listing coupons,
	@params : NULL
	@Created by : Ramanpreet Pal
	@Modify : NULL
	@Created Date : 8 Dec, 2010
	*/

	function admin_index(){
		//check that admin is login
		$this->checkSessionAdmin();
		/** for paging and sorting we are setting values */
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
		$criteria=' 1 ';
		$value = '';	
		$show = '';
		$matchshow = '';
		$fieldname = '';
		/* SEARCHING */
		$reqData = $this->data;
		$option['All'] = "All";
		$options['Coupon.name'] = "Name";
		$options['Coupon.discount_code'] = "Code";
		$options['Coupon.used_times'] = "No of times used ";
		$showArr = $this->getStatus();
		$this->set('showArr',$showArr);
		$this->set('options',$options);
		if(!empty($this->data['Search'])) {
			if(empty($this->data['Search']['searchin'])){
				$fieldname = 'All';
			} else {
				$fieldname = $this->data['Search']['searchin'];
			}
			$value = $this->data['Search']['keyword'];
			$show = $this->data['Search']['show'];
			if($show == 'Active'){
				$matchshow = '1';
			}
			if($show == 'Deactive') {
				$matchshow = '0';
			}
			$value = trim($this->data['Search']['keyword']);
			$value1= Sanitize::escape($value);
			if($value!=="") {
				if(trim($fieldname)=='All'){
					$criteria .= " and Coupon.name LIKE '%".$value1."%' OR Coupon.discount_code LIKE '%".$value1."%' OR Coupon.used_times = '".$value1."'";
				} else {
					if(trim($fieldname)!=''){
						if(isset($value) && $value!=="") {
							$criteria .= " and ".$fieldname." LIKE '%".$value1."%'";
							
						}
					}
				}
			}
			if(isset($show) && $show!=="") {
				if($show == 'All') {
				} else {
					$criteria .= " and Coupon.status = '".$matchshow."'";
					$this->set('show',$show);
				}
			}
		}
		/** sorting and search */
 		if($this->RequestHandler->isAjax() == 0)
 			$this->layout = 'layout_admin';
 		else
			$this->layout = 'ajax';
		
		$this->set('keyword', $value);
		$this->set('show', $show);
		$this->set('fieldname',$fieldname);
		
		/* ******************* page limit sction **************** */
		$sess_limit_name = $this->params['controller']."_limit";
		$sess_limit_value = $this->Session->read($sess_limit_name);
		if( !empty( $this->data['Record']['limit'] ) ) {
		   $limit = $this->data['Record']['limit'];
		   $this->Session->write($sess_limit_name , $this->data['Record']['limit'] );
		} elseif( !empty($sess_limit_value) ) {
			$limit = $sess_limit_value;
		}else{
			$limit = 25;
		}
		$this->data['Record']['limit'] = $limit;
		/* ******************* page limit sction **************** */
		$this->paginate = array(
			'limit' => $limit,
			'order' => array(
					'Coupon.id' => 'Desc'
			),
			'fields'=>array(
				'Coupon.discount_code',
				'Coupon.name',
				'Coupon.expiry_date',
				'Coupon.used_times',
				'Coupon.created',
				'Coupon.modified',
				'Coupon.status',
				'Coupon.id'
			),
		);
		$this->set('listTitle','Manage Coupon');
		$this->set('coupons', $this->paginate('Coupon',$criteria));
	}

	/** 
	@function : admin_add 
	@description : Add/edit discount coupons,
	@params : id
	@Created by : Ramanpreet Pal Kaur
	@Modify : NULL
	@Created Date : Dec 8, 2010
	*/
	function admin_add($id=Null){
		//check that admin is login
		$this->checkSessionAdmin();
		$this->layout = 'layout_admin';
		if(empty($id))
			$this->set('listTitle','Add Coupon');
		else
			$this->set('listTitle','Update Coupon');
		$this->set("id",$id);

		App::import('Model','Department');
		$this->Department = new Department;
		$departments = $this->Department->getList_departments();
		$this->set('departments',$departments);

		if(!empty($this->data)){
// pr($this->data);
			if(!empty($this->data['Coupon']['discount_option'])){
				if($this->data['Coupon']['discount_option'] == 1 ){
					$this->data['Coupon']['percent_off'] = 0;
				} elseif ($this->data['Coupon']['discount_option'] == 2){
					$this->data['Coupon']['specific_amount_off'] = 0;
				} else {
					$this->data['Coupon']['specific_amount_off'] = 0;
					$this->data['Coupon']['percent_off'] = 0;
					$this->data['Coupon']['catalog_limit'] = 0;
					$this->data['Coupon']['product_onsale'] = '';
				}
			}
			if(!empty($this->data['Coupon']['order_limit'])){
				if($this->data['Coupon']['order_limit'] == 1 ){
					$this->data['Coupon']['orderlimit_amount'] = 0;
				}
			}
			if(!empty($this->data['Coupon']['catalog_limit'])){
				if($this->data['Coupon']['catalog_limit'] == 3 ){
					$this->data['Coupon']['product_code'] = 0;
				} elseif ($this->data['Coupon']['catalog_limit'] == 2){
					$this->data['Coupon']['department_id'] = '';
				} else {
					$this->data['Coupon']['product_code'] = 0;
					$this->data['Coupon']['department_id'] = '';
				}
			}
			$this->Coupon->set($this->data);
			if($this->Coupon->validates()){
				if(empty($this->data['Coupon']['discount_code'])) {
					$autocode = $this->generate_cpn_code();
					$returned_code = $this->checkUniquecode($autocode);
					$this->data['Coupon']['discount_code'] = $returned_code;
				}
				uses('sanitize');
				
				if(!empty($this->data['Coupon']['expiry_date'])){
					$ex_date_array = explode('/',$this->data['Coupon']['expiry_date']);
					$ex_date = $ex_date_array[2].'-'.$ex_date_array[1].'-'.$ex_date_array[0];
					$this->data['Coupon']['expiry_date'] = $ex_date;
				}
				if($this->data['Coupon']['product_onsale'] == ''){
					$this->data['Coupon']['product_onsale'] = 1;
				}
// 				pr($this->data); die;
				$this->Coupon->set($this->data);
				if ($this->Coupon->save($this->data)) {
					if(empty($id)){
						$this->Session->setFlash('Discount coupon added successfully.');
					} else{
						$this->Session->setFlash('Discount coupon updated successfully.');
					}
					$this->redirect(array('action' => 'index'));
				}else {
					if(empty($id)) {
						$this->Session->setFlash('Discount coupon has not been added.','default',array('class'=>'flashError'));
					} else {
						$this->Session->setFlash('Discount coupon has not been updated.','default',array('class'=>'flashError'));
					}
					if(!empty($this->data['Coupon']['expiry_date'])){
						$ex_date_array = explode('-',$this->data['Coupon']['expiry_date']);
						$ex_date = $ex_date_array[2].'/'.$ex_date_array[1].'/'.$ex_date_array[0];
						$this->data['Coupon']['expiry_date'] = $ex_date;
					}
				}
			} else {
				$this->set('errors',$this->Coupon->validationErrors);
			}
		} else{
			if(!empty($id)){
				$this->Coupon->id = $id;
				$coupon_detail = $this->Coupon->find('first',array('conditions'=>array('Coupon.id'=>$id)));
				$this->data = $coupon_detail;
				if(!empty($this->data['Coupon']['expiry_date'])){
					$new_expiry_date_array = explode('-',$this->data['Coupon']['expiry_date']);
					$new_ex_date = $new_expiry_date_array[2].'/'.$new_expiry_date_array[1].'/'.$new_expiry_date_array[0];
					$this->data['Coupon']['expiry_date'] = $new_ex_date;
				}
				if(empty($this->data['Coupon']['discount_code'])){
					$autocode = $this->generate_cpn_code();
					$returned_code = $this->checkUniquecode($autocode);
					$this->data['Coupon']['discount_code'] = $returned_code;
				}
				
				if(!empty($this->data['Coupon'])){
					foreach($this->data['Coupon'] as $field_index => $info){
						$this->data['Coupon'][$field_index] = html_entity_decode($info);
						$this->data['Coupon'][$field_index] = str_replace('&#039;',"'",$this->data['Coupon'][$field_index]);
						$this->data['Coupon'][$field_index] = str_replace('\n',"",$this->data['Coupon'][$field_index]);
					}
				}
			} else{
				$autocode = $this->generate_cpn_code();
				$returned_code = $this->checkUniquecode($autocode);
				$this->data['Coupon']['discount_code'] = $returned_code;
			}
		}
	}
	
	/** 
	@function : admin_status
	@description : change the status of active/deactive
	@params : $id=id of row, $status=status
	@Created by : Ramanpreet Pal Kaur
	@Modify : NULL
	@Created Date : 
	**/
	function admin_status($id,$status=null){
		//check that admin is login
		$this->checkSessionAdmin();
		$this->Coupon->id = $id;
		if($status==1){
			$this->Coupon->saveField('status','0');
			$this->Session->setFlash('Information updated  successfully.');

		} else {
			$this->Coupon->saveField('status','1');
			$this->Session->setFlash('Information updated  successfully.');
		}
		/** for search and sorting**/
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
		$this->redirect('/admin/coupons/index/keyword:'.$this->data['Search']['keyword'].'/searchin:'.$this->data['Search']['searchin'].'/showtype:'.$this->data['Search']['show']);
	}

	/**
	@function : admin_delete
	@description : Delete the review
	@params : $id=id of row
	@created : Nov 12, 2010
	@credated by : Ramanpreet Pal Kaur
	**/
	function admin_delete($id=null){
		//check that admin is login
		$this->checkSessionAdmin();
		if($this->Coupon->deleteAll("Coupon.id ='".$id."'"))
			$this->Session->setFlash('Information deleted successfully.');
		else
			$this->Session->setFlash('Information not deleted.','default',array('class'=>'flashError'));	
		$this->redirect('/admin/coupons');
	}

	/**
	@function : admin_multiplAction
	@description : Active/Deactive/Delete multiple record
	@params : NULL
	@created : Nov 12, 2010
	@credated by : Ramanpreet Pal Kaur
	**/
	function admin_multiplAction(){
		//check that admin is login
		$this->checkSessionAdmin();
		if($this->data['Coupon']['status']=='active'){
			foreach($this->data['select'] as $id){
				if(!empty($id)){
					$this->Coupon->id=$id;
					$this->Coupon->saveField('status','1');
					$this->Session->setFlash('Information updated successfully.');
				}
			}
		} elseif($this->data['Coupon']['status']=='inactive'){
			foreach($this->data['select'] as $id){
				if(!empty($id)){
					$this->Coupon->id=$id;
					$this->Coupon->saveField('status','0');
					$this->Session->setFlash('Information updated successfully.');
				}
			}
		} elseif($this->data['Coupon']['status']=='del'){
			foreach($this->data['select'] as $id){
				if(!empty($id)){
					$this->Coupon->delete($id);
					$this->Session->setFlash('Information deleted successfully.');
				}
			}
		}
		/** for searching and sorting*/
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
		/** for searching and sorting*/
		$this->redirect('/admin/coupons/index/keyword:'.$this->data['Search']['keyword'].'/searchin:'.$this->data['Search']['searchin'].'/showtype:'.$this->data['Search']['show']);
	}

	/** 
	@function : generate_cpn_code
	@description : to generate coupon code
	@params : NULL
	@created : Nov 12, 2010
	@credated by : Ramanpreet Pal Kaur
	**/
	function generate_cpn_code(){
		$date_time = 'smartdata'.time();
		$str_date_time = md5(strtotime($date_time));

		for($i=0; $i < strlen($str_date_time); $i++){
			$date_timeArr[$i] = $str_date_time[$i];
		}
		$rand_str = '';
		for($j=0; $j < 15; $j++){
			$rand_char = array_rand($date_timeArr);
			$rand_str = $rand_str.$date_timeArr[$rand_char];
			
		}
		$rand_str = strtoupper($rand_str);
		return $rand_str;
	}

	/** 
	@function : checkUniquecode
	@description : to check uniqueness coupon code
	@params : coupn code
	@created : Nov 12, 2010
	@credated by : Ramanpreet Pal Kaur
	**/
	function checkUniquecode($code = null) {
		$iscode_existed = $this->Coupon->find('all',array('conditions'=>array('Coupon.discount_code'=>$code) ) );
		if(!empty($iscode_existed) ) {
			$autocode1 = $this->generate_cpn_code();
			$return_autocode = $this->checkUniquecode($autocode1);
		}
		$returncode = $code;
		return $returncode;
	}
}
?>