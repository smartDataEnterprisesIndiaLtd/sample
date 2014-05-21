
<?php
/**  @class:		EmailTemplatesController 
 @description		emial Templates  etc.,
 @Created by: 		
 @Modify:		NULL
 @Created Date:		11-09-2009
*/
class PagesController extends AppController{
	var $name = 'Pages';
	var $helpers = array('Form','Html','Javascript','Format','Session','Ajax','Fck','Validation','Common');
	var $components = array ('RequestHandler','Common','Email','File','Thumb');
	
	var $permission_id = 7 ;  // for website pages  module
	
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
		$this->detectMobileBrowser();
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
	@function:admin_index
	@description:listing page of content pages,
	@params:NULL
	@Created by: Ramanpreet Pal
	@Modify:NULL
	@Created Date:03-05-2010
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
				$this->data['Search']['limit']= 20;
		}
		$value = '';
		$criteria=' 1 ';
		$matchshow = '';
		$fieldname = '';
		/* SEARCHING */
		$reqData = $this->data;
		$options['title'] = "Title";
		$options['pagecode'] = "Page code";
		$options['description'] = "Description";
		$this->set('options',$options);
		if(!empty($this->data['Search']))
		{
			if(!empty($this->data['Search']['searchin'])){
				$fieldname = $this->data['Search']['searchin'];
			} else{
				$fieldname = 'All';
			}
			$value = trim($this->data['Search']['keyword']);
			App::import('Sanitize');
			$value1= Sanitize::escape($value);
			if($value!=="") {
				if(trim($fieldname)=='All'){
					$criteria .= " and (Page.title LIKE '%".$value1."%' OR Page.description LIKE '%".$value1."%' )";
				} else {
					if(trim($fieldname)!=''){
						if(isset($value) && $value!=="") {
							$criteria .= " and Page.".$fieldname." LIKE '%".$value1."%'";
							$this->set("keyword",$value);
						} else{
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
		} else if( !empty($sess_limit_value) ){
			$limit = $sess_limit_value;
		} else{
			$limit = $this->records_per_page;  // set default value
		}
		$this->data['Record']['limit'] = $limit;
		/* ******************* page limit sction **************** */
		
		$this->paginate = array(
			'limit' => $limit,
			'order' => array(
					'Page.pagegroup' => 'Asc','Page.id' => 'Asc'
					),
			
		);
		$this->set('listTitle','Manage pages');
		$this->set('staticPages', $this->paginate('Page',$criteria));
	}

	/** 
	@function:		admin_add 
	@description:		Add/edit content pages,
	@params:		id
	@Created by: 		Ramanpreet Pal Kaur
	@Modify:		NULL
	@Created Date:		03-05-2010
	*/
	function admin_add($id=Null){
		
		$this->layout = 'layout_admin';
		if(empty($id))
			$this->set('listTitle','Add content page');
		else
			$this->set('listTitle','Update content page');
		$this->set("id",$id);
		if(!empty($this->data)){
			$this->Page->set($this->data);
			if($this->Page->validates()){
				$pagecode = $this->data['Page']['pagecode'];
				$pagecode = preg_replace('/[~\!@#\$\%\]^\*\&\?\<\>\;\:\,\.\-\%\"\(\)_\+= \"\{\}\[\]]/','-',$pagecode);
// 				if(!empty($this->data['Page'])){
// 					foreach($this->data['Page'] as $field_index => $page_info){
// 						$this->data['Page'][$field_index] = html_entity_decode($page_info);
// 					}
// 				}
				$this->Page->set($this->data);
				if ($this->Page->save($this->data)) {
					$this->Session->setFlash('Information updated successfully.');
					$this->redirect(array('action' => 'index'));
				} else {
					
				}
			} else {
				$this->set('errors',$this->Page->validationErrors);
			}
		} else{
			$this->Page->id = $id;
			$this->data = $this->Page->findById($id);
			
			
// 			if(!empty($this->data['Page'])){
// 				foreach($this->data['Page'] as $field_index => $user_info){
// 					$this->data['Page'][$field_index] = html_entity_decode($user_info);
// 					$this->data['Page'][$field_index] = str_replace('&#039;',"'",$this->data['Page'][$field_index]);
// 				}
// 			}
			
		}
	}

	/**
	@function:admin_view 
	@description		view content pages,
	@Created by: 		Ramanpreet Pal Kaur
	@Modify:		NULL
	@Created Date:		03-05-2010
	*/
	function admin_view($id){
	
		$this->_validateId($id);
		$this->layout = 'layout_admin';
		$this->set('list_title','View static page');
		$this->Page->id = $id;
		$this->data = $this->Page->read();
		if(!empty($this->data['Page'])){
			foreach($this->data['Page'] as $field_index => $info){
				$this->data['Page'][$field_index] = html_entity_decode($info);
				$this->data['Page'][$field_index] = str_replace('&#039;',"'",$this->data['Page'][$field_index]);
				$this->data['Page'][$field_index] = str_replace('\n',"",$this->data['Page'][$field_index]);
			}
		}
	}


	
	
	/** 
	@function:		validateId 
	@description:		Validate of ID,
	@params:		id
	@Created by: 		Ramanpreet Pal Kaur
	@Modify:		NULL
	@Created Date:		03-05-2010
	*/
	function _validateId($id){
		if(empty($id) || !is_numeric($id)){
			$this->Session->setFlash('Id is missing.','default',array('class'=>'flashError'));
			$this->redirect('/admin/content_pages/index/');
		}
	}

	/** 
	@function	:	admin_status
	@description	:	change the status of active/deactive
	@params		:	$id=id of row, $status=status
	@Created by: 		Ramanpreet Pal Kaur
	@Modify:		NULL
	@Created Date:		03-05-2010
	**/
	
	function admin_status($id,$status=0){	
		
		$this->Page->id = $id;
		if($status==1){
			$this->Page->saveField('status','0');
			$this->set('img','red3.jpg');
			$this->set('alt','Inactive');
			$this->set('status','0');
			$this->Session->setFlash('Information updated  successfully.');
			$this->set('url','/admin/pages/status/'.$id.'/0');

		} else {
			$this->Page->saveField('status','1');
			$this->set('img','green2.jpg');
			$this->set('alt','Active');
			$this->set('status','1');
			$this->set('url','/admin/pages/status/'.$id.'/1');			$this->Session->setFlash('Information updated  successfully.');				
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
		$this->redirect('/admin/pages/index/keyword:'.$this->data['Search']['keyword'].'/searchin:'.$this->data['Search']['searchin'].'/showtype:'.$this->data['Search']['show']);
	}
	/** 
	@function	:	admin_delete
	@description	:	Delete the content page
	@params		:	$id=id of row
	@created	:	03-05-2010
	@credated by	:	Ramanpreet Pal Kaur
	**/
	function admin_delete($id=null){

		if($this->Page->deleteAll("Page.id ='".$id."'"))
			$this->Session->setFlash('Information deleted successfully.');	
		else
			$this->Session->setFlash('Information not deleted.','default',array('class'=>'flashError'));	
		$this->redirect('/admin/pages');
	}
	/** 
	@function	:	admin_multiplAction
	@description	:	Active/Deactive/Delete multiple record
	@params		:	NULL
	@created	:	03-05-2010
	@credated by	:	Ramanpreet Pal Kaur
	**/
	function admin_multiplAction(){
		
		if($this->data['Pages']['submit']=='active'){
			foreach($this->data['select'] as $id){
				if(!empty($id)){
				$this->Page->id=$id;
				$this->Page->saveField('status','1');
				$this->Session->setFlash('Information updated successfully.');
				}	
			}
		} else if($this->data['Pages']['submit']=='inactive'){
			foreach($this->data['select'] as $id){
				if(!empty($id)){
	
					$this->Page->id=$id;
					
					$this->Page->saveField('status','0');
					$this->Session->setFlash('Information updated successfully.');	
				}
			}
		} else if($this->data['Pages']['submit']=='del'){
			foreach($this->data['select'] as $id){
				if(!empty($id)){
					$this->Page->delete($id);
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
		$this->redirect('/admin/pages/index/keyword:'.$this->data['Search']['keyword'].'/searchin:'.$this->data['Search']['searchin'].'/showtype:'.$this->data['Search']['show']);
	}
	
	/** 
	@function:	view 
	@description:	method to fetch the content for static pages of the site at front end section
	@Created by:	Ramanpreet Pal Kaur
	@params:	$id string page-code for the page to be shown
	@Modify:	NULL
	@access: public
	@Created Date:	
	*/
	function view($pagecode = null){
		//echo 1;die;
		App::import('Model','FaqCategory');
		$this->FaqCategory = new FaqCategory();
		App::import('Model','ContactusSubject');
		$this->ContactusSubject = new ContactusSubject();
		//Configure::write('debug',2);
		/*start added by nakul for Metrics service on 15 Feb 2013*/
		App::import('Model','MetricsService');
		$this->MetricsService = new MetricsService();
		$metrics_service = $this->MetricsService->find('first',array(
						'fields'=>array('MetricsService.id',
								'MetricsService.service_agent',
								'MetricsService.emails_per_hour',
								'MetricsService.email_response_time',
								'MetricsService.help_desk',
								),
							'order' => array('MetricsService.id DESC'),
						));
		$this->set('metrics_service',$metrics_service);
		/*End  added by nakul for Metrics service on 15 Feb 2013*/
		
		/*start added by nakul for contact us form on 19 sept 2011*/
		if($pagecode == 'contact-us'){
			if(empty($_SESSION['User']['id'])){
				$this->Session->setFlash('Please sign in to your account before contacting us','default', array('class' => 'flashError'));
				$this->checkSessionFrontUser();
				//$this->redirect('/users/login/');
			}
			
		$emil_send_to = $this->ContactusSubject->find('list',array('conditions'=>array('ContactusSubject.status '=>1 ,'ContactusSubject.parent_id'=>0),'fields'=>array('ContactusSubject.id','ContactusSubject.subject_to'),'order'=>array('ContactusSubject.id')));
		$subject = $this->ContactusSubject->find('list',array('conditions'=>array('ContactusSubject.status '=>1 ,'ContactusSubject.parent_id'=>1),'fields'=>array('ContactusSubject.id','ContactusSubject.subject_to'),'order'=>array('ContactusSubject.id')));
		
		$this->set('emil_send_to' , $emil_send_to);
		$this->set('subject' , $subject);
		$this->set('user_name' , $_SESSION['User']['firstname'].' '.$_SESSION['User']['lastname']);
		$this->set('user_email' , $_SESSION['User']['email']);
		$this->set('user_id' , $_SESSION['User']['id']);
		
		if(!Empty($this->data)){
			
			$this->data = $this->cleardata($this->data);
			$this->ContactusSubject->set($this->data);
			if($this->ContactusSubject->validates()){
			
			/*find email id form contact us subject table for sending email*/
			$email_id = $this->ContactusSubject->find('first',array('conditions'=>array('ContactusSubject.status '=>1 ,'ContactusSubject.id'=>$this->data['ContactusSubject']['email_to']),'fields'=>array('ContactusSubject.id','ContactusSubject.send_to_email'),'order'=>array('ContactusSubject.id')));
			
			/*find email id form contact us subject table for sending email*/
			$email_subject = $this->ContactusSubject->find('first',array('conditions'=>array('ContactusSubject.status '=>1 ,'ContactusSubject.id'=>$this->data['ContactusSubject']['subject']),'fields'=>array('ContactusSubject.id','ContactusSubject.subject_to'),'order'=>array('ContactusSubject.id')));
			
			/** Send contact us email **/
			$this->Email->smtpOptions = array(
				'host' => Configure::read('host'),
				'username' =>Configure::read('username'),
				'password' => Configure::read('password'),
				'timeout' => Configure::read('timeout')
			);
			
			$this->Email->sendAs= 'html';
			$link=Configure::read('siteUrl');
			
			/******import emailTemplate Model and get template****/
			App::import('Model','EmailTemplate');
			$this->EmailTemplate = new EmailTemplate;
			/**
			table: email_templates
			id: 1
			description: Contact Us detail
			*/
			
					$template = $this->Common->getEmailTemplate(31);
					$this->Email->from =  $this->data['User']['email'];
					$this->Email->subject = $email_subject['ContactusSubject']['subject_to'];
					$data='Comment: </br>'.nl2br($this->data['ContactusSubject']['comments']);
					//$data=str_replace('[MESSAGE_BODY]',$this->data['UserSuggestion']['suggestion'],$data);
					$this->set('data',$data);
					$this->Email->to =$email_id['ContactusSubject']['send_to_email'];
					/******import emailTemplate Model and get template****/
					$this->Email->template='commanEmailTemplate';
					if($this->Email->send()) {
					$this->Session->setFlash('Thank you for contacting us, our dedicated customer service representatives will be in touch soon','default', array('class' => 'message'));
					$this->redirect('/pages/view/contact-us');
				}else{
					$this->Session->setFlash('Email has been not sent','default', array('class' => 'flashError'));
					$this->redirect('/pages/view/contact-us');
				}
					
			}
			$errorArray = $this->ContactusSubject->validationErrors;
			$this->set('errors',$errorArray);
			//print_r($this->ContactusSubject->validationErrors);
			
		}
		
		}
		/*end by nakul for contact us form on 19 sept 2011*/
		
		$this->set('faqCategoryArr' , $this->FaqCategory->find('all'));
		//$this->layout = 'front';
		if(empty($pagecode)){
			$this->redirect('/');
		} else {
			
						
			if ($this->RequestHandler->isMobile()) {
 			$this->layout = 'mobile/staticpages';
			} else{
			$this->layout = 'staticpages';
			}
			
			$this->data = $this->Page->find('first',array('conditions'=>array('Page.pagecode'=> $pagecode)));
			
			
			$list_all_links = array();
			
			if(!empty($this->data['Page']['pagegroup'])){
				$list_all_links = $this->Page->find('list',array('conditions'=>array('Page.pagegroup'=>$this->data['Page']['pagegroup']),'fields'=>array('Page.pagecode','Page.title'),'order'=>array('Page.sequence')));
			}
				
// 			if(!empty($this->data['Page'])){
// 				foreach($this->data['Page'] as $field_index => $info){
// 					$this->data['Page'][$field_index] = html_entity_decode($info);
// 					$this->data['Page'][$field_index] = str_replace('&#039;',"'",$this->data['Page'][$field_index]);
// 					$this->data['Page'][$field_index] = str_replace('\n',"",$this->data['Page'][$field_index]);
// 				}
// 			}

			$this->set('list_all_links',$list_all_links);
			/** Manage Title, meta description and meta keywords ***/
			$this->pageTitle  = $this->data['Page']['meta_title'];
			$this->set('title_for_layout',$this->data['Page']['meta_title']);
			$this->set('meta_description',$this->data['Page']['meta_description']);
			$this->set('meta_keywords',$this->data['Page']['meta_keyword']);
			$this->set('pagecode',$pagecode);
			/** Manage Title, meta description and meta keywords ***/
		}
	}
	/** 
	@function:	contactform 
	@description:	method to fetch the content us form subject according to email sent to.
	@Created by:	Nakul
	@params:	parent_id subject_id relaged to 'contactus_subjects' table
	@Modify:	NULL
	@access: public
	@Created Date: 20 sept 2011
	*/
	function contactform($parent_id = null){
		$this->layout = 'ajax';		
		App::import('Model','ContactusSubject');
		$this->ContactusSubject = new ContactusSubject();
		if($parent_id != ''){ 
			$subject = $this->ContactusSubject->find('list',array('conditions'=>array('ContactusSubject.status '=>1 ,'ContactusSubject.parent_id'=>$parent_id),'fields'=>array('ContactusSubject.id','ContactusSubject.subject_to'),'order'=>array('ContactusSubject.id')));
			$this->set('subject' , $subject);
			
		}
	}
	
	/** 
	@function:	change_email 
	@description:	Change email address of user in contact us form.
	@Created by:	Nakul
	@params:	user_id and email address 
	@Modify:	NULL
	@access: public
	@Created Date: 20 sept 2011
	*/
	function change_email($user_id = null,$user_email = null){
		$this->layout = 'ajax';	
		App::import('Model','User');
		$this->User = new User();
		if($user_id != ''){
			/* we uncommented the bleow code due to update email is in contact us form in customer service page  - 02 May 2013*/
			$this->User->id=$user_id;
			echo $user_email;
			//$this->User->saveField('email', $user_email);
		}
		exit(); // Their is no view file present so, we are made exit here - 02 May 2013
		
		
	}
	
	function admin_footerdes($parent_id = null){
		
		$this->checkSessionAdmin();
		/** for paging and sorting we are setting values */
		$this->loadModel('FooterDescription');
		$footerRecord = $this->FooterDescription->find('count',array('conditions'=>array('FooterDescription.status'=>1,'FooterDescription.is_deleted'=>1)));
		$this->set('footerRecord',$footerRecord);
		
		if(empty($this->data)){
			if(isset($this->params['named']['searchin']))
				$this->data['Search']['searchin']=$this->params['named']['searchin'];
			else
				$this->data['Search']['searchin']='';
	
			if(isset($this->params['named']['keyword']))
				$this->data['Search']['keyword']=$this->params['named']['keyword'];
			else
				$this->data['Search']['keyword']='';
				$this->data['Search']['limit']= 20;
		}
		$value = '';
		$criteria=' 1 ';
		$matchshow = '';
		$fieldname = '';
		/* SEARCHING */
		$reqData = $this->data;
		$options['name'] = "Title";
		$options['desc'] = "Footer Description";
		$this->set('options',$options);
		if(!empty($this->data['Search']))
		{
			if(!empty($this->data['Search']['searchin'])){
				$fieldname = $this->data['Search']['searchin'];
			} else{
				$fieldname = 'All';
			}
			$value = trim($this->data['Search']['keyword']);
			App::import('Sanitize');
			$value1= Sanitize::escape($value);
			if($value!=="") {
				if(trim($fieldname)=='All'){
					$criteria .= " and (FooterDescription.name LIKE '%".$value1."%' OR FooterDescription.desc LIKE '%".$value1."%' )";
				} else {
					if(trim($fieldname)!=''){
						if(isset($value) && $value!=="") {
							$criteria .= " and FooterDescription.".$fieldname." LIKE '%".$value1."%'";
							$this->set("keyword",$value);
						} else{
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
		} else if( !empty($sess_limit_value) ){
			$limit = $sess_limit_value;
		} else{
			$limit = $this->records_per_page;  // set default value
		}
		$this->data['Record']['limit'] = $limit;
		/* ******************* page limit sction **************** */
		
		$this->paginate = array(
			'limit' => $limit,
			'conditions'=>array('FooterDescription.status'=>1,'FooterDescription.is_deleted'=>1),
			'order' => array(
					'FooterDescription.name' => 'Asc','FooterDescription.id' => 'Asc'
					),
			
		);
		$this->set('listTitle','Manage Footer Banner');
		$this->set('staticPages', $this->paginate('FooterDescription',$criteria));
	}
	
	
	function admin_adddesc($id = null) {
		$this->checkSessionAdmin();
		$this->loadModel('FooterDescription');
		$page_name = $this->get_page_url();
		//pr($page_name);
		$this->set('page_name', $page_name);
		$page_id = "";
		$this->layout = 'layout_admin';
		if(!empty($this->data)) {
			$selected_page_id = isset($this->data['FooterDescription']['page_id'])?$this->data['FooterDescription']['page_id']:'';
			$this->data['FooterDescription']['name'] = isset($page_name[$selected_page_id])?$page_name[$selected_page_id]:'';
			$this->data['FooterDescription']['desc'] = trim($this->data['FooterDescription']['desc']);
				
			$this->FooterDescription->set($this->data['FooterDescription']);
			$validate = $this->FooterDescription->validates();
			$page_id = $this->data['FooterDescription']['id'];
			
			if($validate){
				$mrClean = new Sanitize();
				
				$data['FooterDescription']['name'] = $page_name[$this->data['FooterDescription']['page_id']];
				$data['FooterDescription']['desc'] = $mrClean->clean($this->data['FooterDescription']['desc']);
				$data['FooterDescription']['page_id'] = $mrClean->clean($this->data['FooterDescription']['page_id']);
				
				
				if(!empty($this->data['FooterDescription']['id'])){
					if($this->FooterDescription->save($this->data['FooterDescription'],array('validate'=>false))){
						$this->Session->setFlash("Record has been updated successfully.");
					} else{
						$this->Session->setFlash("Record has not been updated.");
					}
				}else{
					if($this->FooterDescription->save($this->data['FooterDescription'],array('validate'=>false))){
						$this->Session->setFlash("Record has been created successfully.");
					} else{
						$this->Session->setFlash("Record has not been created.");
					}
				}
				$this->redirect('/admin/pages/footerdes');
			} else{
				$errorArray = $this->FooterDescription->validationErrors;
				$this->set('errors',$errorArray);
			}
		} elseif(isset($id) && is_numeric($id)){
			$this->data = $this->FooterDescription->findById($id);
			
		
			if(!empty($this->data['FooterBanner'])){
				foreach($this->data['FooterDescription'] as $field_index => $info){
					$this->data['FooterDescription'][$field_index] = html_entity_decode($info);
					$this->data['FooterDescription'][$field_index] = str_replace('&#039;',"'",$this->data['FooterDescription'][$field_index]);
					$this->data['FooterDescription'][$field_index] = str_replace('\n',"",$this->data['FooterDescription'][$field_index]);
				}
			}
			if(is_array($this->data)){
				$id = $this->data['FooterDescription']['id'];
			}else{
				$this->redirect('FooterDescription');
			}
		}
		$this->set('id',$id);
		$this->set('listTitle','Add Footer Description');
		if(!empty($id)){
			$this->set('listTitle','Edit Footer Description');
		}
		
	}
	function admin_deletedesc($id=null) {
		$this->checkSessionAdmin();
		$id = base64_decode($id);
		$this->loadModel('FooterDescription');
		if($this->FooterDescription->delete($id)) {
			$this->Session->setFlash('Record deleted successfully');
		} else {
			$this->Session->setFlash('Record can not be deleted');
		}		
		$this->redirect('footerdes');
	}
	function admin_footerbanner($parent_id = null){
		$this->checkSessionAdmin();
		/** for paging and sorting we are setting values */
		$this->loadModel('FooterBanner');
		$bannerCount = $this->FooterBanner->find('count');
		$this->set('bannerCount',$bannerCount);
		
		if(empty($this->data)){
			if(isset($this->params['named']['searchin']))
				$this->data['Search']['searchin']=$this->params['named']['searchin'];
			else
				$this->data['Search']['searchin']='';
	
			if(isset($this->params['named']['keyword']))
				$this->data['Search']['keyword']=$this->params['named']['keyword'];
			else
				$this->data['Search']['keyword']='';
				$this->data['Search']['limit']= 20;
		}
		$value = '';
		$criteria=' 1 ';
		$matchshow = '';
		$fieldname = '';
		/* SEARCHING */
		$reqData = $this->data;
		$options['name'] = "Name";
		$options['alt_text'] = "ALT-Text";
		$this->set('options',$options);
		if(!empty($this->data['Search']))
		{
			if(!empty($this->data['Search']['searchin'])){
				$fieldname = $this->data['Search']['searchin'];
			} else{
				$fieldname = 'All';
			}
			$value = trim($this->data['Search']['keyword']);
			App::import('Sanitize');
			$value1= Sanitize::escape($value);
			if($value!=="") {
				if(trim($fieldname)=='All'){
					$criteria .= " and (FooterBanner.name LIKE '%".$value1."%' OR FooterBanner.alt_text LIKE '%".$value1."%' )";
				} else {
					if(trim($fieldname)!=''){
						if(isset($value) && $value!=="") {
							$criteria .= " and FooterBanner.".$fieldname." LIKE '%".$value1."%'";
							$this->set("keyword",$value);
						} else{
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
		} else if( !empty($sess_limit_value) ){
			$limit = $sess_limit_value;
		} else{
			$limit = $this->records_per_page;  // set default value
		}
		$this->data['Record']['limit'] = $limit;
		/* ******************* page limit sction **************** */
		
		$this->paginate = array(
			'limit' => $limit,
			'order' => array(
					'FooterBanner.position' => 'Asc','FooterBanner.id' => 'Asc'
					),
			
		);
		$this->set('listTitle','Manage Footer Banner');
		$this->set('staticPages', $this->paginate('FooterBanner',$criteria));
	}
	
	
	/**
	* @Date : Oct 14,2010
	* @Method : admin_add
	* @Purpose : Function to add faqs.
	* @Param : $id
	* @Return : none
	**/

	function admin_addbanner($id = null) {
		$this->checkSessionAdmin();
		$banner_position = $this->get_banner_position();
		$banner_position = array('1'=>1,'2'=>2,'3'=>3,'4'=>4,'5'=>5,'6'=>6,'7'=>7,'8'=>8);
		$this->set('baner_position', $banner_position);
		$banner_id = "";
		$this->layout = 'layout_admin';
		if(!empty($this->data)) {
			
			$flag = $this->data['FooterBanner']['flag'];
			if($flag){
				unset($this->data['FooterBanner']['file']);
			}
			
			if(isset($this->data['FooterBanner']['previousImage']) &&!empty($this->data['FooterBanner']['previousImage'])){
				if(isset($this->data['FooterBanner']['file']) && !empty($this->data['FooterBanner']['file']) && ($this->data['FooterBanner']['file']['error'] ==0)){
					
				}else{
					unset($this->data['FooterBanner']['file']);
				}
			}
			
			$this->FooterBanner->set($this->data['FooterBanner']);
			/*
			if($this->data['FooterBanner']['file']['error'] != 4){
				$this->Session->write('file',$this->data['FooterBanner']['file']);
			}
			
			$file = $this->Session->read('file');
			
			$this->data['FooterBanner']['file'] = $file;*/
			$validate = $this->FooterBanner->validates();
			$banner_id = $this->data['FooterBanner']['id'];
			
			if($validate){
				
				$mrClean = new Sanitize();
				$this->data['FooterBanner']['name']=$mrClean->clean($this->data['FooterBanner']['name']);
				/*** Upload Image if provided */
				
					if(!empty($this->data['FooterBanner']['file']['name'])){
						
						$this->File->destPath =  WWW_ROOT.PATH_BANNER;
						
						$imageType = $this->data['FooterBanner']['file']['type'];
						$imageTypeArr = explode('/',$imageType);
						$validImage = $this->File->validateImage($imageTypeArr[1]);
						
						if($validImage == true){
							$this->File->destPath =  WWW_ROOT.PATH_BANNER;
							$this->File->setFilename(time()."_".$this->data['FooterBanner']['file']['name']);
							$fileName  = $this->File->uploadFile($this->data['FooterBanner']['file']['name'],$this->data['FooterBanner']['file']['tmp_name']);
							$mime ='';
							$file = $fileName;
							@copy($this->File->destPath.DS.$file,$this->File->destPath.'large/img_400_'.$file);
							@copy($this->File->destPath.DS.$file,$this->File->destPath.'large/img_300_'.$file);
							$this->Thumb->getResized('img_400_'.$file, $mime, $this->File->destPath.'large/', 400, 400, 'FFFFFF', true, true,$this->File->destPath.'large/', false);
							$this->Thumb->getResized('img_300_'.$file, $mime, $this->File->destPath.'large/', 300, 300, 'FFFFFF', true, true,$this->File->destPath.'large/', false);
							@copy($this->File->destPath.DS.$file,$this->File->destPath.'medium/img_200_'.$file);
							@copy($this->File->destPath.DS.$file,$this->File->destPath.'medium/img_150_'.$file);
							@copy($this->File->destPath.DS.$file,$this->File->destPath.'medium/img_135_'.$file);
							@copy($this->File->destPath.DS.$file,$this->File->destPath.'medium/img_125_'.$file);
							$this->Thumb->getResized('img_200_'.$file, $mime, $this->File->destPath.'medium/', 200, 200, 'FFFFFF', true, true,$this->File->destPath.'medium/', false);
							$this->Thumb->getResized('img_150_'.$file, $mime, $this->File->destPath.'medium/', 150, 150, 'FFFFFF', true, true,$this->File->destPath.'medium/', false);
							$this->Thumb->getResized('img_135_'.$file, $mime, $this->File->destPath.'medium/', 139, 52, 'FFFFFF', true, true,$this->File->destPath.'medium/', false);
							$this->Thumb->getResized('img_125_'.$file, $mime, $this->File->destPath.'medium/', 125, 125, 'FFFFFF', true, true,$this->File->destPath.'medium/', false);
							@copy($this->File->destPath.DS.$file,$this->File->destPath.'small/img_100_'.$file);
							@copy($this->File->destPath.DS.$file,$this->File->destPath.'small/img_75_'.$file);
							@copy($this->File->destPath.DS.$file,$this->File->destPath.'small/img_50_'.$file);
							$this->Thumb->getResized('img_100_'.$file, $mime, $this->File->destPath.'small/', 100, 100, 'FFFFFF', true, true,$this->File->destPath.'small/', false);
							$this->Thumb->getResized('img_75_'.$file, $mime, $this->File->destPath.'small/', 75, 75, 'FFFFFF', true, true,$this->File->destPath.'small/', false);
							$this->Thumb->getResized('img_50_'.$file, $mime, $this->File->destPath.'small/', 50, 50, 'FFFFFF', true, true,$this->File->destPath.'small/', false);
							## delete the main directory substitue file
							$this->File->deleteFile($fileName);
						}
						if( !$fileName  ){ // Error in uploading
							$this->Session->setFlash('Error in uploading the image.','default',array('class'=>'flashError')); 
							//$this->redirect($back_page_url);
						} else{ // uploaded successful and delete the old file
							$this->FooterBanner->id = $id;
							$oldfile = $this->FooterBanner->findById($id);
							# delete product all old images
							$this->deleteFooterBannerAllOldImages($oldfile['FooterBanner']['file']);
							// delete old file
							$this->File->deleteFile( $oldfile['FooterBanner']['file']);
							$this->data['FooterBanner']['file']= $fileName;
						}
					}
					if(isset($this->data['FooterBanner']['previousImage']) &&!empty($this->data['FooterBanner']['previousImage'])){
						if(!isset($this->data['FooterBanner']['file'])){
							$this->data['FooterBanner']['file'] =$this->data['FooterBanner']['previousImage'];
						}
					}
					
				$data['FooterBanner']['position'] = $mrClean->clean($this->data['FooterBanner']['position']);
				$data['FooterBanner']['name'] = $mrClean->clean($this->data['FooterBanner']['name']);
				$data['FooterBanner']['flag'] = $mrClean->clean($this->data['FooterBanner']['flag']);
				$data['FooterBanner']['script'] = $mrClean->clean($this->data['FooterBanner']['script']);
				$data['FooterBanner']['alt_text'] = $mrClean->clean($this->data['FooterBanner']['alt_text']);
				$data['FooterBanner']['file'] = $mrClean->clean($this->data['FooterBanner']['file']);
				
				if(!empty($this->data['FooterBanner']['id'])){
					if($this->FooterBanner->save($this->data['FooterBanner'],array('validate'=>false))){
						$this->Session->setFlash("Record has been updated successfully.");
					} else{
						$this->Session->setFlash("Record has not been updated.");
					}
				}else{
					if($this->FooterBanner->save($this->data['FooterBanner'],array('validate'=>false))){
						$this->Session->setFlash("Record has been created successfully.");
					} else{
						$this->Session->setFlash("Record has not been created.");
					}
				}
				/*$this->Session->destroy('file');*/
				$this->redirect('/admin/pages/footerbanner');
			} else{
				$errorArray = $this->FooterBanner->validationErrors;
				$this->set('errors',$errorArray);
			}
		} elseif(isset($id) && is_numeric($id)){
			$this->data = $this->FooterBanner->findById($id);
			
		
			if(!empty($this->data['FooterBanner'])){
				foreach($this->data['FooterBanner'] as $field_index => $info){
					$this->data['FooterBanner'][$field_index] = html_entity_decode($info);
					$this->data['FooterBanner'][$field_index] = str_replace('&#039;',"'",$this->data['FooterBanner'][$field_index]);
					$this->data['FooterBanner'][$field_index] = str_replace('\n',"",$this->data['FooterBanner'][$field_index]);
				}
			}
			if(is_array($this->data)){
				$id = $this->data['FooterBanner']['id'];
			}else{
				$this->redirect('footerbanner');
			}
		}
		$this->set('id',$id);
		$this->set('listTitle','Add Banner');
		if(!empty($id)){
			$this->set('listTitle','Edit Banner');
		}
		
	}

	function get_banner_position()
	{
		$this->loadModel('FooterBanner');
		$banner_position = $this->FooterBanner->find('list',array('conditions'=>array(),'fields'=>array('position','position')));
		return $banner_position;
	}
	
	function admin_deletebanner($id=null) {
		$this->checkSessionAdmin();
		$id = base64_decode($id);
		$this->loadModel('FooterBanner');
		if($this->FooterBanner->delete($id)) {
			$this->Session->setFlash('Record deleted successfully');
		} else {
			$this->Session->setFlash('Record can not be deleted');
		}		
		$this->redirect('footerbanner');
	}
		/** ***********************************************************************
	@function	:	deleteProductAllOldImages
	@description	:	to delete the old  product images
	@params		:	NULL
	@created	:	17 Feb,2011
	@credated by	:	kulvinder
	**/
	function deleteFooterBannerAllOldImages($oldFileName){
		$destBaseFilePath =  WWW_ROOT.PATH_PRODUCT;
		@unlink($destBaseFilePath.'large/img_400_'.$oldFileName);
		@unlink($destBaseFilePath.'large/img_300_'.$oldFileName);
		@unlink($destBaseFilePath.'medium/img_200_'.$oldFileName);
		@unlink($destBaseFilePath.'medium/img_150_'.$oldFileName);
		@unlink($destBaseFilePath.'medium/img_135_'.$oldFileName);
		@unlink($destBaseFilePath.'medium/img_125_'.$oldFileName);
		@unlink($destBaseFilePath.'small/img_100_'.$oldFileName);
		@unlink($destBaseFilePath.'small/img_75_'.$oldFileName);
		@unlink($destBaseFilePath.'small/img_50_'.$oldFileName);
	}
	function get_page_url(){
		$this->loadModel('PageUrl');
		$page_name = $this->PageUrl->find('list',array('conditions'=>array('PageUrl.status'=>1,'PageUrl.is_deleted'=>1),'fields'=>array('id','name')));
		return $page_name;
		
	}
	
}
?>