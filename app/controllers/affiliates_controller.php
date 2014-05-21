<?php
/**  @class:		AffiliatesController 
 @description		emial Templates  etc.,
 @Created by: 		
 @Modify:		NULL
 @Created Date:		03-04-2010
*/
class AffiliatesController extends AppController{
	var $name = 'Affiliates';
	var $helpers = array('Form','Html','Javascript','Session','Ajax','Fck','Format','Validation','Common'); 
	var $components = array ('RequestHandler','Common');
	var $uses 	= array('Affiliate');

	var $permission_id = 10;  // for affiliate
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
		$includeBeforeFilter = array('admin_index','admin_add', 'admin_edit', 'admin_view');
		if (in_array($this->params['action'],$includeBeforeFilter))
		{
			// validate admin users for this module
			$this->validateAdminModule($this->permission_id);
			
			// validate admin session
			$this->checkSessionAdmin();
			
		}
	}
	
	/** 
	@function:		admin_index 
	@description:		listing page of email templates,
	@params:		NULL
	@Created by: 		Ramanpreet
	@Modify:		NULL
	@Created Date:		Oct 13,2010
	*/

	function admin_index(){
		$this->checkSessionAdmin();
		$this->layout = 'layout_admin';
		$this->set('listTitle','Manage Affiliates Pages');
		$this->paginate = array(
			'limit' => '10',
			'order' => array(
				'Affiliate.modified' => 'DESC'
			),
			'fields' => array(
				'Affiliate.id',
				'Affiliate.title',
				'Affiliate.content',
				'Affiliate.modified'
			)
		);		
		$this->set('listTitle','Manage Affiliates Pages');
		$this->set('affiliatesPages', $this->paginate('Affiliate'));
	}
	
	/** 
	@function:		admin_edit 
	@description:		Add/edit email template pages pages,
	@params:		id
	@Created by: 		
	@Modify:		NULL
	@Created Date:		Oct 13, 2010
	*/
	
	function admin_edit($id=Null){
		//check that admin is login
		$this->checkSessionAdmin();
		$this->layout = 'layout_admin';
		$this->_validateId($id);
		$this->set('listTitle','Edit Page Details');
		$this->set('id',$id);
		$this->set('submit_buttton','Update');
		if(!empty($this->data)){
			$this->Affiliate->set($this->data);
			if($this->Affiliate->validates()){
				
				//$this->data['Affiliate'] = Sanitize::clean($this->data['Affiliate']);
				if ($this->Affiliate->save($this->data)) {
					$this->Session->setFlash('Information updated successfully.');
					$this->redirect(array('action' => 'index'));
				} else {
					$this->Session->setFlash('Information not updated.','default',array('class'=>'flashError'));
				}
			} else {
				$this->set('errors',$this->Affiliate->validationErrors);
			}
		}
		else{
			$this->Affiliate->id = $id;
			$this->data = $this->Affiliate->read();
		}
	}
	
	/** 
	@function:		admin_view 
	@description		view template pages,
	@Created by: 		
	@params		id
	@Modify:		NULL
	@Created Date:		03-04-2010
	*/
	function admin_view($id){
		//check that admin is login
		$this->checkSessionAdmin();
		$this->_validateId($id);
		$this->layout = 'layout_admin';
		$this->set('listTitle','View Page Details');
		$this->Affiliate->id = $id;
		$this->data = $this->Affiliate->read();
		
			
			if(!empty($this->data['Affiliate'])){
				foreach($this->data['Affiliate'] as $field_index => $info){
					$this->data['Affiliate'][$field_index] = html_entity_decode($info);
					$this->data['Affiliate'][$field_index] = str_replace('&#039;',"'",$this->data['Affiliate'][$field_index]);
				}
			}
	}
	
	/** 
	@function:		validateId 
	@description:		Validate of ID,
	@Created Date:		03-04-2010
	*/
	function _validateId($id){
		if(empty($id) || !is_numeric($id)){
			$this->Session->setFlash('Sorry, affiliate page id is missing.','default',array('class'=>'flashError'));
			$this->redirect('/admin/affiliates/index/');
		}
	}

	/**
	@function:	view
	@description:	
	@Created by:	Ramanpreet Pal Kaur
	@params:	$id string page-code for the page to be shown
	@Modify:	NULL
	@access: public
	@Created Date:	
	*/
	function view($id = null){
		$this->layout = '';
		if(empty($id)){
			$this->redirect('/');
		} else{
			$this->set('id', $id);
			$this->layout = 'affiliate';
			if($id == 'faq'){
				App::import('Model', 'Faq');
				$this->Faq = new Faq; 
				$this->data = $this->Faq->find('all', array('conditions'=>array('Faq.faq_category_id'=> 8,'Faq.status'=> 1 ))); // 8 for affiliate faq category
			}else{
				$this->data = $this->Affiliate->find('first',array('recursive'=>1,'conditions'=>array('Affiliate.id'=> $id)));
			}
			
			
			if(!empty($this->data['Affiliate'])){
				foreach($this->data['Affiliate'] as $field_index => $info){
					$this->data['Affiliate'][$field_index] = html_entity_decode($info);
					$this->data['Affiliate'][$field_index] = str_replace('&#039;',"'",$this->data['Affiliate'][$field_index]);
				}
			}
			/** Manage Title, meta description and meta keywords ***/
			$this->pageTitle  = 'Affiliate';
			$this->set('title_for_layout','Affiliate');
			$this->set('description_for_layout','Affiliate');
			$this->set('keywords_for_layout','Affiliate');
			/** Manage Title, meta description and meta keywords ***/
		}
	}
}
?>