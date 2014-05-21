<?php
/**  @class:		EmailTemplatesController 
 @description		emial Templates  etc.,
 @Created by: 		Ramanpreet Pal Kaur
 @Modify:		NULL
 @Created Date:		03-04-2010
*/
			App::import('Sanitize');
class EmailTemplatesController extends AppController{
	var $name = 'EmailTemplates';
	var $helpers = array('Form','Html','Javascript','Session','Ajax','Fck','Format','validation'); 
	var $components = array ('RequestHandler');
	
	var $permission_id = 8 ;  // for email template  module
	
	/**
	* @Date: Dec 08, 2010
	* @Method : beforeFilter
	* Created By: kulvinder singh
	* @Purpose: This function is used to validate admin user permissions
	* @Param: none
	* @Return: none 
	**/
	function beforeFilter(){
		
		//check session other than admin_login page
		$includeBeforeFilter = array('admin_index',
			'admin_add',
			'admin_view',
			'admin_delete',
			'admin_status',
			'admin_multiplAction',
		);
		
		if (in_array($this->params['action'],$includeBeforeFilter)) {
			//check that admin is login
			$this->checkSessionAdmin();
			// validate admin users for this module
			$this->validateAdminModule($this->permission_id); 
		}		
		
	}
	
	/** 
	@function : admin_index 
	@description : listing page of email templates,
	@params : NULL
	@Created by : Ramanpreet Pal Kaur
	@Modify : NULL
	@Created Date : Oct 13,2010
	*/

	function admin_index(){
		
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
		}
		$value = '';
		$criteria=' 1 ';
		$matchshow = '';
		$fieldname = '';
		/* SEARCHING */
		$reqData = $this->data;
		$options['title'] = "Title";
		$options['subject'] = "Subject";
		$options['description'] = "Description";
		$showArr = $this->getStatus();
		$this->set('showArr',$showArr);
		$this->set('options',$options);
		if(!empty($this->data['Search'])){
			if(!empty($this->data['Search']['searchin'])){
				$fieldname = $this->data['Search']['searchin'];
			} else{
				$fieldname = 'All';
			}
			$value = $this->data['Search']['keyword'];
			$value1= Sanitize::escape($value);
			if($value!=="") {
				if(trim($fieldname)=='All'){
					$criteria .= " and (EmailTemplate.title LIKE '%".$value1."%' OR EmailTemplate.description LIKE '%".$value1."%' )";
				} else {
					if(trim($fieldname)!=''){
						if(isset($value1) && $value1!=="") {
							$criteria .= " and EmailTemplate.".$fieldname." LIKE '%".$value1."%'";
							$this->set("keyword",$value);
						}else{
							$this->set("keyword",$value);
						}
						$this->set('fieldname',$fieldname);
					}
				}
			}
		}
		 
		/** sorting and search */
		if($this->RequestHandler->isAjax()==0)
			$this->layout = 'layout_admin';
		else
			$this->layout = 'ajax';
		
		$this->set('keyword', $value);
		$this->set('fieldname',$fieldname);
		
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
		/* ******************* page limit sction ********$this->set("keyword",$value);
			******** */
		$this->paginate = array(
			'limit' => $limit,
			'order' => array(
				'EmailTemplate.id' => 'DESC'
			),
			'fields' => array(
				'EmailTemplate.id',
				'EmailTemplate.title',
				'EmailTemplate.subject',
				'EmailTemplate.description',
				'EmailTemplate.status',
				'EmailTemplate.modified'
			)
		);
		$this->set('listTitle','Manage Email Templates');
		$this->set('emailTemplates', $this->paginate('EmailTemplate',$criteria));
	}
	/** 
	@function : admin_add 
	@description : Add/edit email template pages pages,
	@params : id
	@Created by : Ramanpreet Pal Kaur
	@Modify : NULL
	@Created Date : Oct 13, 2010
	*/
	
	function admin_add($id=Null){
		

		$this->layout = 'layout_admin';
		if(empty($id))
			$this->set('listTitle','Add email template');
		else
			$this->set('listTitle','Update email template');
		
		$this->set('id',$id);
		if(empty($id))		
			$this->set('submit_buttton','Add');
		else
			$this->set('submit_buttton','Update');

		if(!empty($this->data)){
			$this->EmailTemplate->set($this->data);
			if($this->EmailTemplate->validates()){
				//$this->data = Sanitize::clean($this->data);
				$this->EmailTemplate->set($this->data);
				if ($this->EmailTemplate->save($this->data)) {
					$this->Session->setFlash('Information updated successfully.');
					$this->redirect(array('action' => 'index'));
				}else {
					$this->Session->setFlash('Information not updated.','default',array('class'=>'flashError'));
				}
			} else {
				$this->set('errors',$this->EmailTemplate->validationErrors);
				//pr($this->EmailTemplate->validationErrors);
			}
		}
		else{
			
			$this->EmailTemplate->id = $id;	
			$this->data = $this->EmailTemplate->read();
			
			
		}
	}
	
 
	
	/** 
	@function:		admin_view 
	@description		view template pages,
	@Created by: 		Ramanpreet Pal Kaur
	@params		id
	@Modify:		NULL
	@Created Date:		03-04-2010
	*/
	function admin_view($id){
		$this->_validateId($id);
		$this->layout = 'layout_admin';
		$this->set('listTitle','View Email Template');
		$this->EmailTemplate->id = $id;
		$this->data = $this->EmailTemplate->read();
		if(!empty($this->data['EmailTemplate'])){
			foreach($this->data['EmailTemplate'] as $field_index => $info){
				$this->data['EmailTemplate'][$field_index] = html_entity_decode($info);
				$this->data['EmailTemplate'][$field_index] = str_replace('&#039;',"'",$this->data['EmailTemplate'][$field_index]);
				$this->data['EmailTemplate'][$field_index] = str_replace('\n',"",$this->data['EmailTemplate'][$field_index]);
			}
		}
	}
	
	
	/** 
	@function:		validateId 
	@description:		Validate of ID,
	@params:		id
	@Created by: 		Ramanpreet Pal Kaur
	@Modify:		NULL
	@Created Date:		03-04-2010
	*/
	function _validateId($id){
		if(empty($id) || !is_numeric($id)){
				$this->Session->setFlash('Id is missing.','default',array('class'=>'flashError'));
				$this->redirect('/admin/email_templates/index/');
			}
	}

	/** 
	@function	:	admin_status
	@description	:	change the status of active/deactive
	@params		:	$id=id of row, $status=status
	@created	:	2010
	@credated by	:	Ramanpreet Pal Kaur
	**/
	
	function admin_status($id,$status=0){	
		$this->EmailTemplate->id = $id;
		if($status==1){
			$this->EmailTemplate->saveField('status','0');
			$this->set('img','deactivate_icon.gif');
			$this->set('alt','Inactive');
			$this->set('status','0');
			$this->set('url','/admin/email_templates/status/'.$id.'/0');
		} else{
			$this->EmailTemplate->saveField('status','1');
			$this->set('img','activate_icon.gif');
			$this->set('alt','Active');
			$this->set('status','1');
			$this->set('url','/admin/email_templates/status/'.$id.'/1');
			
		}
		$this->Session->setFlash('Information updated successfully.');	
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
		$this->redirect('/admin/email_templates/index/keyword:'.$this->data['Search']['keyword'].'/searchin:'.$this->data['Search']['searchin'].'/showtype:'.$this->data['Search']['show']);

		
		
	}
	/** 
	@function	:	admin_delete
	@description	:	Delete the content page
	@params		:	$id=id of row
	@created	:	Oct 13,2010
	@credated by	:	Ramanpreet Pal Kaur
	**/
	
	function admin_delete($id=null){
		
		if($this->EmailTemplate->delete($id))
			$this->Session->setFlash('Information is deleted successfully.');	
		else
			$this->Session->setFlash('Information is not deleted.','default',array('class'=>'flashError'));	
		$this->redirect('/admin/email_templates');
	}

	/** 
	@function	:	admin_multiplAction
	@description	:	Active/Deactive/Delete multiple record
	@params		:	NULL
	@created	:	Oct 13,2010
	@credated by	:	Ramanpreet Pal Kaur
	**/
	function admin_multiplAction(){
		
		if($this->data['EmailTemplate']['submit']=='active'){
			foreach($this->data['select'] as $id){
				if(!empty($id)){
				$this->EmailTemplate->id=$id;
				$this->EmailTemplate->saveField('status','1');
				$this->Session->setFlash('Information updated successfully.');
				}
			}
		} elseif($this->data['EmailTemplate']['submit']=='inactive'){
			foreach($this->data['select'] as $id){
				if(!empty($id)){
					$this->EmailTemplate->id=$id;
					$this->EmailTemplate->saveField('status','0');
					$this->Session->setFlash('Information updated successfully.');	
				}
			}
		} elseif($this->data['EmailTemplate']['submit']=='del'){
			foreach($this->data['select'] as $id){
				if(!empty($id)){
					
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
		
		$this->redirect('/admin/email_templates/index/keyword:'.$this->data['Search']['keyword'].'/searchin:'.$this->data['Search']['searchin'].'/showtype:'.$this->data['Search']['show']);
	}
}
?>