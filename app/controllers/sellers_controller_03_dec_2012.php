<?php
/**
	* Sellers Controller class
	* PHP versions 5.1.4
	* @date Nov 16, 2010
	* @Purpose:This controller handles all the functionalities regarding user management.
	* @filesource
	* @author     Ramanpreet Pal Kaur
	* @revision
	* @copyright  Copyright � 2010 smartData
	* @version 0.0.1 
**/
App::import('Sanitize');
class SellersController extends AppController
{
	var $name =  "Sellers";
	var $helpers =  array('Html', 'Form','Common', 'Javascript','Session','Validation','Ajax', 'Format');
	var $components =  array('RequestHandler','Email','Common','File', 'Thumb','Ordercom');
	var $paginate =  array();
	var $uses =  array('Seller');
	var $permission_id = 3;  // for seller module
	/**
	* @Date: Dec 21,2010
	* @Method : beforeFilter
	* Created By: kulvinder singh
	* @Purpose: This function is used to validate products access  permissions and  admin user sessions
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
			'admin_seller_changepassword',
			'admin_export',
			'admin_view_bulk_listing',
			'admin_upload_bulk_listing',
			'admin_delete_volumefile','
			admin_multiplAction_volumefile',
			'admin_download_bulk_files',
			'admin_view_seller_payment_listing',
			'admin_penalty',
			'admin_dispatch_country_list'
		);
		
		if (in_array($this->params['action'],$includeBeforeFilter)) {
			//check that admin is login
			$this->checkSessionAdmin();
			// validate admin users for this module
			$this->validateAdminModule($this->permission_id); 
		}
		// seller section validations
		$includeForSeller = array('order_details','orders','refund_order','cancel_order');
		if (in_array($this->params['action'],$includeForSeller)) {
			// seller's section validations
			$this->validateSeller();
		}
	}
	
	/** 
	@function: sign_up
	@description: to sign up for a sellers account
	@Created by: Ramanpreet Pal
	@params	
	@Modify: NULL
	@Created Date: Nov 16, 2010
	*/
	function sign_up(){
		// set page url for session so that 5 steps can be seen
			$this->Session->write('last_page_url','sign_up');
		if($this->RequestHandler->isAjax()==0)
 			$this->layout = 'marketplace';
 		else
			$this->layout = 'ajax';
		$this->set('title_for_layout','Choiceful.com Marketplace: Enter Your Business Information');
		App::import('Controller', 'Users');
		$Users = new UsersController;
		$seller_info = $this->Session->read('seller_signup');
		$signedin_user = $this->Session->read('User');
		
		$titles = $this->Common->get_titles();
		$this->set('title',$titles);
		$saved_pass = $this->Session->read('saved_password');
		$questions = $this->get_user_security_question();
		$this->set('security_questions',$questions);
		if(!empty($this->data)){
			
			$this->data = $this->cleardata($this->data);
			//$this->data = Sanitize::clean($this->data, array('encode' => false));
			
			$this->Seller->set($this->data);
			$sellerValidate = $this->Seller->validates();
			if(!empty($sellerValidate)) {
				$this->Session->write('seller_signup',$this->data);
				$this->data = '';
				$this->redirect('/sellers/sign_up_step2');
			} else {
				$errorArray = $this->Seller->validationErrors;
				$this->data['Seller']['password'] = '';
				$this->data['Seller']['confirmpassword'] = '';
				
				foreach($this->data['Seller'] as $field_index => $user_info){
					$this->data['Seller'][$field_index] = html_entity_decode($user_info);
					$this->data['Seller'][$field_index] = str_replace('&#039;',"'",$this->data['Seller'][$field_index]);
				}
				$this->set('errors',$errorArray);
			}
		} else {
			if(!empty($seller_info) ){
				$this->data = $seller_info;
			} else {
				if(!empty($signedin_user)) {
					$this->data['Seller'] = $signedin_user;
					$this->data['Seller']['user_id'] = $signedin_user['id'];
					if(!empty($signedin_user['seller_id'])) {
						$this->Session->setFlash('You have already registered as a seller.','default',array('class'=>'flashError'));
						$this->redirect('/users/login');
					}
				}
			}
			if(!empty($saved_pass)) {
				$this->data['Seller']['password'] = $saved_pass;
			}
		}
	}

	/** 
	@function: sign_up_step2
	@description: to sign up for a sellers account
	@Created by: Ramanpreet Pal
	@params	
	@Modify: NULL
	@Created Date: Nov 16, 2010
	*/
	function sign_up_step2(){
		$this->layout = 'ajax';
		$seller_info2 = $this->Session->read('seller_signup2');
		$signedin_user = $this->Session->read('User');
		App::import('Model','Address');
		$this->Address = new Address;
		$countries = $this->Common->getcountries();
		$this->set('countries',$countries);
		if(!empty($this->data)){
			
			$this->data = $this->cleardata($this->data);
			//$this->data = Sanitize::clean($this->data, array('encode' => false));
			
			$this->Seller->set($this->data);
			$sellerValidate = $this->Seller->validates();
			if(!empty($sellerValidate)){
				$this->Session->write('seller_signup2',$this->data);
				$this->data = '';
				$this->redirect('/sellers/sign_up_step3');
				
			} else {
				
				foreach($this->data['Seller'] as $field_index => $user_info){
					$this->data['Seller'][$field_index] = html_entity_decode($user_info);
					$this->data['Seller'][$field_index] = str_replace('&#039;',"'",$this->data['Seller'][$field_index]);
				}
				foreach($this->data['Address'] as $field_index => $user_info){
					$this->data['Address'][$field_index] = html_entity_decode($user_info);
					$this->data['Address'][$field_index] = str_replace('&#039;',"'",$this->data['Address'][$field_index]);
				}
				$errorArray = $this->Seller->validationErrors;
				$this->set('errors',$errorArray);
			}
		} else{
			
			if(!empty($seller_info2) ){
				$this->data = $seller_info2;

			} else{
				if(!empty($signedin_user)){
					$this->data['Seller'] = $signedin_user;
					if(!empty($signedin_user['id'])){
						$user_is = $this->Address->find('first',array('conditions'=>array('Address.user_id'=>$signedin_user['id'])));
						
						if(!empty($user_is)){
							$this->data['Seller']['address1'] = $user_is['Address']['add_address1'];
							$this->data['Seller']['address2'] = $user_is['Address']['add_address2'];
							$this->data['Seller']['city'] 	= $user_is['Address']['add_city'];
							$this->data['Seller']['postcode'] = $user_is['Address']['add_postcode'];
							$this->data['Seller']['state'] 	= $user_is['Address']['add_state'];
							$this->data['Seller']['country_id'] = $user_is['Address']['country_id'];
						}
					}
					if(!empty($signedin_user['seller_id'])){
						$seller_is = $this->Seller->find('first',array('conditions'=>array('Seller.id'=>$signedin_user['seller_id']),'fields'=>array('Seller.id','Seller.user_id','Seller.business_name',)));
						if(!empty($seller_is['Seller'])){
							$this->data['Seller'] = $seller_is['Seller'];
						}
					}
				}
			}
// 			foreach($this->data['Seller'] as $field_index => $user_info){
// 				$this->data['Seller'][$field_index] = html_entity_decode($user_info);
// 				$this->data['Seller'][$field_index] = str_replace('&#039;',"'",$this->data['Seller'][$field_index]);
// 			}
		}
	}

	/** 
	@function: sign_up_step3
	@description: to sign up for a sellers account
	@Created by: Ramanpreet Pal
	@params	
	@Modify: NULL
	@Created Date: Nov 16, 2010
	*/
	function sign_up_step3(){
		if($this->RequestHandler->isAjax()==0)
 			$this->layout = 'marketplace';
 		else
			$this->layout = 'ajax';
		$seller_info = $this->Session->read('seller_signup');
		$seller_info2 = $this->Session->read('seller_signup2');
		
		$signedin_user = $this->Session->read('User');
		App::import('Controller', 'Users');
		$Users = new UsersController;
		$countries = $this->Common->getcountries();
		$this->set('countries',$countries);
		App::import('Model','User');
		$this->User = new User;
		App::import('Model','Address');
		$this->Address = new Address;
		
		if(!empty($this->data)){
			
			$this->data = $this->cleardata($this->data);
			//$this->data = Sanitize::clean($this->data, array('encode' => false));
			
			$this->Seller->set($this->data);
			$sellerValidate = $this->Seller->validates();
			if(!empty($sellerValidate)){

				$this->data['Address']['add_phone'] = $this->data['Seller']['phone'];

				if(!empty($seller_info['Seller'])){
					if(!empty($seller_info['Seller']['title'])){
						$this->data['User']['title'] = $seller_info['Seller']['title'];
					}
					if(!empty($seller_info['Seller']['email'])){
						$this->data['User']['email'] = $seller_info['Seller']['email'];
					}
					if(!empty($seller_info['Seller']['secret_question'])){
						$this->data['Seller']['secret_question'] = $seller_info['Seller']['secret_question'];
					}
					if(!empty($seller_info['Seller']['secret_answer'])){
						$this->data['Seller']['secret_answer'] = $seller_info['Seller']['secret_answer'];
					}
					if(!empty($seller_info['Seller']['lastname'])){
						$this->data['Address']['add_lastname'] = ucwords(strtolower($seller_info['Seller']['lastname']));
						$this->data['User']['lastname'] = ucwords(strtolower($seller_info['Seller']['lastname']));
					}
					if(!empty($seller_info['Seller']['firstname'])){
						$this->data['Address']['add_firstname'] = ucwords(strtolower($seller_info['Seller']['firstname']));
						$this->data['User']['firstname'] = ucwords(strtolower($seller_info['Seller']['firstname']));
					}
					if(!empty($seller_info['Seller']['password'])){
						$this->data['User']['password'] = ucwords(strtolower($seller_info['Seller']['password']));
					}
				}
				if(!empty($seller_info2['Seller'])){
					if(!empty($seller_info2['Seller']['address1'])){
						$this->data['Address']['add_address1'] = ucwords(strtolower($seller_info2['Seller']['address1']));
					}
					if(!empty($seller_info2['Seller']['address2'])){
						$this->data['Address']['add_address2'] = ucwords(strtolower($seller_info2['Seller']['address2']));
					}
					if(!empty($seller_info2['Seller']['city'])){
						$this->data['Address']['add_city'] = ucwords(strtolower($seller_info2['Seller']['city']));
					}
					if(!empty($seller_info2['Seller']['postcode'])){
						$this->data['Address']['add_postcode'] = $seller_info2['Seller']['postcode'];
					}
					if(!empty($seller_info2['Seller']['country_id'])){
						$this->data['Address']['country_id'] = $seller_info2['Seller']['country_id'];
					}
					if(!empty($seller_info2['Seller']['state'])){
						$this->data['Address']['add_state'] = $seller_info2['Seller']['state'];
					}
					if(!empty($seller_info2['Seller']['business_name'])){
						$this->data['Seller']['business_name'] = ucwords(strtolower($seller_info2['Seller']['business_name']));
					}
				}
				if(!empty($this->data['User'])){
					if(!empty($this->data['User']['password'])){
						$original_password = $this->data['User']['password'];
						$this->data['User']['password'] = md5($this->data['User']['password']);
					}
				}
				$this->data['User']['contact_by_phone'] = 1;
				$this->data['User']['contact_by_partner'] = 1;
				$this->data['User']['tc'] = 1;
				App::import('Model','User');
				$this->User = new User;
				$this->data['User']['user_type'] = 1;
				if(!empty($signedin_user)){
					$this->data['User']['id'] = $this->Session->read('User.id');
				}
				$this->data['User'] = Sanitize::clean($this->data['User']);
				$this->User->set($this->data);
				if($this->User->save($this->data)){
					if(!empty($signedin_user)){
						$user_id = $this->Session->read('User.id');
					} else{
						$user_id = $this->User->getLastInsertId();
					}
					$this->data['Seller']['user_id'] = $user_id;
					if(!empty($this->data['Seller']['business_display_name'])){
						$this->data['Seller']['business_display_name'] = ucwords(strtolower($this->data['Seller']['business_display_name']));
					}
					$this->data['Seller'] = Sanitize::clean($this->data['Seller']);
					$this->Seller->set($this->data);
					if($this->Seller->save($this->data)){
						$seller_user_id = $this->Seller->getLastInsertId();
						if(!empty($signedin_user)){
							$this->Session->write('User',$this->data['User']);
							$this->Session->write('User.seller_id',$seller_user_id);
							$this->User->id = $user_id;
							$this->User->saveField('online_flag',1);
						}
						if(!empty($user_id)){
							$user_add_info = $this->Address->find('first',array('conditions'=>array('Address.user_id'=>$user_id),'fields'=>array('Address.id')));
							if(!empty($user_add_info)){
								$this->data['Address']['id'] = $user_add_info['Address']['id'];
							} else{
								$this->data['Address']['id'] = 0;
							}
						}
						$this->data['Address']['user_id'] = $user_id;
						$this->data['Address'] = Sanitize::clean($this->data['Address']);
						$this->Address->set($this->data);
						$this->Address->save($this->data);
						$this->Session->delete('seller_signup');
						$this->Session->delete('seller_signup2');
						/** Send email after registration **/
						$this->Email->smtpOptions = array(
							'host' => Configure::read('host'),
							'username' =>Configure::read('username'),
							'password' => Configure::read('password'),
							'timeout' => Configure::read('timeout')
						);
						$this->Email->from = Configure::read('fromEmail');
						$this->Email->replyTo=Configure::read('replytoEmail');
						$this->Email->sendAs= 'html';
						App::import('Model','EmailTemplate');
						$this->EmailTemplate = new EmailTemplate;
						$link=Configure::read('siteUrl');
						
						/******import emailTemplate Model and get template****/
						/**
						table: 		email_templates
						id:		
						description:	Customer registration
						*/
						$template = $this->Common->getEmailTemplate(5);
						
						$this->Email->from = $template['EmailTemplate']['from_email'];
						$data= $template['EmailTemplate']['description'];
						$this->Email->subject = $template['EmailTemplate']['subject'];
						$this->set('data',$data);
						
						$this->Email->to = $this->data['User']['email'];
						
						/******import emailTemplate Model and get template****/
						$this->Email->template='commanEmailTemplate';
						$inserted_user_id = $user_id;
						App::import('Model','User');
						$this->User = new User;
						$this->User->expects(array('Seller'));
						$userinfo = $this->User->find('first',array('conditions'=>array("User.id"=>$inserted_user_id),'fields'=>array("User.id","User.title","User.firstname","User.lastname","User.user_type","User.email","User.status","User.suspend_date","Seller.id")));
						$userinfo['User']['seller_id'] = $userinfo['Seller']['id'];
						$this->Session->write('User',$userinfo['User']);
						if($this->Email->send()) {
							$this->Session->setFlash('Thanks for creating an account with choiceful.com.');
						} else{
							$this->Session->setFlash('An error occurred while sending the email to the email address provided by you. Please contact Customer Support at '.Configure::read('phone').' to reset your email address and password.','default',array('class'=>'flashError'));
						}
							
						if(!empty($signedin_user)){
							$inserted_user_id = $user_id;
							App::import('Model','User');
							$this->User = new User;
							$this->User->expects(array('Seller'));
							$userinfo = $this->User->find('first',array('conditions'=>array("User.id"=>$inserted_user_id),'fields'=>array("User.id","User.title","User.firstname","User.lastname","User.user_type","User.email","User.status","User.suspend_date","Seller.id")));
							$userinfo['User']['seller_id'] = $userinfo['Seller']['id'];
							$this->Session->write('User',$userinfo['User']);
							$this->Session->setFlash('Thanks for updating your account as seller.','default');
						}
						$site_url_link = SITE_URL;
						echo "<script type='text/javascript'>window.location.href='".$site_url_link."marketplaces/search_results'</script>";
					}
				} else{
					$this->Session->setFlash('Account has not been created.','default');
				}
			} else {
				$errorArray = $this->Seller->validationErrors;
				$this->set('errors',$errorArray);
			}
		} else{
			$this->data['Seller']['free_delivery'] = 1;
			$this->data['Seller']['gift_service'] = 0;
			if(!empty($signedin_user)){
				$this->data['Seller'] = $signedin_user;
				if(!empty($signedin_user['seller_id'])){
					$seller_is = $this->Seller->find('first',array('conditions'=>array('Seller.id'=>$signedin_user['seller_id'])));
					$this->data['Seller'] = $seller_is['Seller'];
				}
				if(!empty($signedin_user['id'])){
					$user_is = $this->Address->find('first',array('conditions'=>array('Address.user_id'=>$signedin_user['id']),'fields'=>array('Address.add_phone')));
					if(!empty($user_is)){
						$this->data['Seller']['phone'] = $user_is['Address']['add_phone'];
					}
				}
			}
		}
		
		foreach($this->data['Seller'] as $field_index => $user_info){
			$this->data['Seller'][$field_index] = html_entity_decode($user_info);
			$this->data['Seller'][$field_index] = str_replace('&#039;',"'",$this->data['Seller'][$field_index]);
		}/*
		foreach($this->data['User'] as $field_index => $user_info){
			$this->data['User'][$field_index] = html_entity_decode($user_info);
			$this->data['User'][$field_index] = str_replace('&#039;',"'",$this->data['User'][$field_index]);
		}*/
	}

	/** 
	@Created by: 		get_security_question
	@Modify:		NULL
	@Created Date:		19-10-10
	*/
	function get_user_security_question(){
		$que_array = array(
			"What is the name of your best friend from childhood?" => "What is the name of your best friend from childhood?",
			"What was the name of your first teacher?"=> "What was the name of your first teacher?",
			"What is the name of your manager at your first job?"=> "What is the name of your manager?",
			"What was your first phone number?" => "What was your first phone number?",
			"What is your vehicle registration number?" => "What is your vehicle registration number?",
		);
		return $que_array;
	}

	
	/** 
	@function:	admin_index
	@description	to display sellers on admin_end
	@Created by: 	Ramanpreet Pal Kaur	
	@params		NULL
	@Created Date:	
	*/
	function admin_index() {
		$this->checkSessionAdmin();
		$user_id = $this->Session->read('SESSION_ADMIN.id');
		$this->layout='layout_admin';
		App::import('Model','User');
		$this->User = new User;
		$criteria = 1;
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
		/** **************************************** **/
		$this->set('title_for_layout','Manage Sellers');
		$value = '';	
		$show = '';
		$matchshow = '';
		$fieldname = '';
		/** SEARCHING **/
		$reqData = $this->data;
		$options['All'] = 'All';
		$options['firstname'] = "Firstname";
		$options['lastname'] = "Lastname";
		$options['email'] = "Email";
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
			if(!empty($this->data['Search']['show'])){
				$show = $this->data['Search']['show'];
			} else{
				$show = 'All';
			}
			if($show == 'Active'){
				$matchshow = '1';
			}
			if($show == 'Deactive'){
				$matchshow = '0';
			}
			App::import('Sanitize');
			$value1 = Sanitize::escape($value);
			if($value !="") {
				if(trim($fieldname)=='All'){
					$criteria .= " and (User.firstname LIKE '%".$value1."%' OR User.lastname LIKE '%".$value1."%' OR User.email LIKE '%".$value1."%')";
				} else {
					if(trim($fieldname)!=''){
						if(isset($value) && $value!=="") {
							$criteria .= " and User.".$fieldname." LIKE '%".$value1."%'";
						}
					}
				}
			}
			if(isset($show) && $show!==""){
				if($show == 'All'){
				} else {
					$criteria .= " and User.status = '".$matchshow."'";
					$this->set('show',$show);
				}
			}
			
		}
		$this->set('keyword', $value);
		$this->set('show', $show);
		$this->set('fieldname',$fieldname);
		$this->set('heading','Manage Sellers');
		/* ******************* page limit sction **************** */
		$sess_limit_name = $this->params['controller']."_limit";
		$sess_limit_value = $this->Session->read($sess_limit_name);
		if(!empty($this->data['Record']['limit'])){
		   $limit = $this->data['Record']['limit'];
		   $this->Session->write($sess_limit_name , $this->data['Record']['limit'] );
		}elseif( !empty($sess_limit_value) ){
			$limit = $sess_limit_value;
		}else{
			$limit = $this->records_per_page;  // set default value
		}
		$this->data['Record']['limit'] = $limit;
		/* ******************* page limit sction **************** */
		$this->paginate = array(
			'limit' => $limit,
			'order' => array(
				'User.id' => 'DESC'
			),
			'conditions'=>array('User.user_type'=>'1'),
			'fields' => array(
				'User.id',
				'User.title',
				'User.firstname',
				'User.lastname',
				'Seller.business_name',
				'User.email',
				'User.password',
				'User.status',
				'User.user_type',
				'User.modified',
				'User.created',
				//'count(OrderSeller.id)',
				//'OrderSeller.seller_id'
			)
		);
			
		$this->User->expects(array('Seller'));
			
		$sellers_list = $this->paginate('User',$criteria);
		$this->set('total_users',count($sellers_list));
		$ProductSeller = $this->Common->totalnoProductSeller();
		if(!empty($sellers_list)){
			App::import('Model','OrderSeller');
			$this->OrderSeller = new OrderSeller;
			$this->OrderSeller->expects(array('Order'));
			$i = 0;
			foreach($sellers_list as $seller){
				$order_info = $this->OrderSeller->find('all',array('conditions'=>array('Order.deleted'=>"0",'OrderSeller.seller_id'=>$seller['User']['id']),'fields'=>array('count(OrderSeller.id) as order_count')));
					
				if(!empty($order_info)){
					$sellers_list[$i]['Order']['order_count'] = $order_info[0][0]['order_count'];
				}
				
				if(array_key_exists($seller['User']['id'],$ProductSeller)){
					$sellers_list[$i]['Seller']['totalProducts'] = $ProductSeller[$seller['User']['id']];
				}else{
					$sellers_list[$i]['Seller']['totalProducts'] =  0;
				}
				
				$i++;
			}
			
		}
		//echo "<PRE>";
		//print_r($sellers_list);
		$this->set('usersArr',$sellers_list);
	}

	/** @Date: Nov 11, 2010
	* @Method : admin_change_password
	* Created By: Ramanpreet Pal Kaur
	* @Purpose: This function is to change users password by admin.
	* @Param: $id
	* @Return: none 
	**/
	function admin_seller_changepassword($id = null){
		$this->set('title_for_layout', 'Change Seller Password');
		$this->layout = 'layout_admin';
		App::import('Model','User');
		$this->User = new User;
		$this->set('id',$id);
		if(!empty($this->data)) {
			$errors = array();
			$this->Seller->set($this->data);
			if($this->Seller->validates()){
				$this->data['User']['password'] = $this->data['Seller']['newpassword'];
				$this->data['User']['confirmpassword'] = $this->data['Seller']['newconfirmpassword'];
				$this->data['User'] = $this->data['User'];
				$userid =  $id;
				$userDetails = $this->User->findById($userid,array('id'));
				if(!empty($userDetails)){
					$this->User->id = $id;
					$this->User->saveField('password',md5($this->data['User']['password']));
					$this->Session->setFlash('Password changed successfully');
					$this->redirect('/admin/sellers');
					$this->data['User']['newpassword'] = '';
					$this->data['User']['newconfirmpassword'] = '';
				} else{
					$this->Session->setFlash('Seller not exists.','default',array('class'=>'flashError'));
				}
			} else{
				$this->set('errors',$this->User->validationErrors);
			}
		} else{
		}
	}

	/**
	@function:admin_view 
	@description		view users details,
	@Modify:		NULL
	@Created Date:		Nov 22,2010
	*/
	function admin_view($id = null){
		$id = base64_decode($id);
		App::import('Model','User');
		$this->User = new User;
		//check that admin is login
		$this->checkSessionAdmin();
		$this->_validateId($id);
		$this->layout = 'layout_admin';
		$this->set('list_title','View Seller Details');
		$this->User->expects(array('Seller','UserDepartment'));
		$this->User->Seller->expects(array('Country'));
		$this->User->recursive =2;
		$this->User->id = $id;
		$this->data = $this->User->read();
		App::import('Model','Address');
		$this->Address = new Address;
		$this->Address->expects(array('Country'));
		$primary_add = $this->Address->getprimary_add($id);
		$this->data['User']['address1'] = $primary_add['Address']['add_address1'];
		$this->data['User']['address2'] = $primary_add['Address']['add_address2'];
		$this->data['User']['postcode'] = $primary_add['Address']['add_postcode'];
		$this->data['User']['city'] = $primary_add['Address']['add_city'];
		$this->data['User']['state'] = $primary_add['Address']['add_state'];
		$this->data['User']['phone'] = $primary_add['Address']['add_phone'];
		$this->data['Country'] = $primary_add['Country'];
		$departments = $this->Common->getdepartments();
		$this->set('departments',$departments);
	}


	/** 
	@function:		validateId 
	@description:		Validate of ID,
	@params:		id
	@Modify:		NULL
	@Created Date:		Oct 13,2010
	*/
	function _validateId($id){
		if(empty($id) || !is_numeric($id)){
			$this->Session->setFlash('Id is missing.','default',array('class'=>'flashError'));
			$this->redirect('/admin/sellers/');
		}
	}

	
	/** 
	@function	:	admin_multiplAction
	@description	:	Active/Deactive/Delete multiple sellers record
	@params		:	NULL
	**/
	function admin_multiplAction(){
		App::import('Model','User');
		$this->User = new User;
		App::import('Model','ProductSeller');
		$this->ProductSeller = new ProductSeller;
		$notsaved_users = '';
		if($this->data['User']['status']=='active'){
			foreach($this->data['select'] as $id){
				if(!empty($id)){
					$this->User->id = $id;
					if($this->User->saveField('status', 1 )){
						$seller_products = $this->ProductSeller->find('all',array('conditions'=>array('ProductSeller.seller_id'=>$id)));
						if(!empty($seller_products)){
							foreach($seller_products as $seller_product){
								$this->ProductSeller->id = $seller_product['ProductSeller']['id'];
								$this->ProductSeller->saveField('listing_status', 1 );
							}
						}
						$this->Session->setFlash('This Seller and all belonging products have been activated successfully. <br> Now, please update minimum price for choiceful.com');
					} else{
						if(empty($notsaved_users))
							$notsaved_users = $id;
						else
							$notsaved_users = $notsaved_users.','.$id;
					}
				}
			}
		} elseif($this->data['User']['status']=='inactive'){
			foreach($this->data['select'] as $id){
				if(!empty($id)){
					$this->User->id = $id;
					if($this->User->saveField('status', 0 )){
						$seller_products = $this->ProductSeller->find('all',array('conditions'=>array('ProductSeller.seller_id'=>$id)));
						if(!empty($seller_products)){
							foreach($seller_products as $seller_product){
								$this->ProductSeller->id = $seller_product['ProductSeller']['id'];
								$this->ProductSeller->saveField('listing_status', '0' );
							}
						}
						$this->Session->setFlash('This Seller and all belonging products have been inactivated successfully. <br> Now, please update minimum price for choiceful.com');
					} else{
						if(empty($notsaved_users))
							$notsaved_users = $id;
						else
							$notsaved_users = $notsaved_users.','.$id;
					}
				}
			}
		}
		$unsaved_users = '';
		if(!empty($notsaved_users)){
			$all_unsaved = $this->User->find('all',array('conditions'=>array('User.id IN ('.$notsaved_users.')'),'fields'=>array('User.firstname','User.lastname')));
			if(!empty($all_unsaved)){
				foreach($all_unsaved as $user_name){
					if(empty($unsaved_users)){
						$unsaved_users = $user_name['User']['firstname'].' '.$user_name['User']['lastname'];
					} else {
						$unsaved_users = $unsaved_users.', '.$user_name['User']['firstname'].' '.$user_name['User']['lastname'];
					}
				}
			}
		}
		if(!empty($unsaved_users)){
			$this->Session->setFlash('Error in changing status for following seller:<br>'.$unsaved_users.' <br> For others, please update minimum price for choiceful.com','default',array('class'=>'flashError'));
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
		$this->redirect('/admin/sellers/index/keyword:'.$this->data['Search']['keyword'].'/searchin:'.$this->data['Search']['searchin'].'/showtype:'.$this->data['Search']['show']);
	}

	
	/** 
	@function: admin_delete
	@description: to delete seller from admin
	@Created by: Ramanpreet Pal
	@params	
	@Modify: NULL
	@Created Date: 
	*/
	function admin_delete($id = null) {
		App::import('Model','ProductSeller');
		$this->ProductSeller = new ProductSeller;
		App::import('Model','User');
		$this->User = new User;
		$seller_products = $this->ProductSeller->find('all',array('conditions'=>array('ProductSeller.seller_id'=>$id)));
		if(empty($seller_products)){
			$seller_info = $this->Seller->find('first',array('conditions'=>array('Seller.user_id'=>$id)));

			if(!empty($seller_info)){
				$seller_id  = $seller_info['Seller']['id'];
				$this->Seller->id = $seller_id;
				if($this->Seller->delete()){
					$this->User->id = $id;
					$this->User->saveField('user_type',0);
					$this->Session->setFlash('Seller has been deleted successfully. <br> Now, please update minimum price for choiceful.com');
				} else{
					$this->Session->setFlash('Error in deleting records.','default',array('class'=>'flashError'));
				}
			}
		} else {
			$this->User->id = $id;
			if($this->User->saveField('status', 0 )){
				if(!empty($seller_products)){
					foreach($seller_products as $seller_product){
						$this->ProductSeller->id = $seller_product['ProductSeller']['id'];
						$this->ProductSeller->saveField('listing_status', 0 );
					}
					$this->Session->setFlash('This seller is having some products, so we can\'t delete it. This Seller and all belonging products have been inactivated successfully. <br> Now, please update minimum price for choiceful.com');
				}
			}else{
				$this->Session->setFlash('Error in performing action.');
			}
		}
		$this->redirect('index');
	}

	
	/** 
	@function: admin_status
	@description: to change status of seller from admin
	@Created by: Ramanpreet Pal
	@params	
	@Modify: NULL
	@Created Date: 
	*/
	function admin_status($id = null,$status= null) {
		App::import('Model','User');
		$this->User = new User;
		App::import('Model','ProductSeller');
		$this->ProductSeller = new ProductSeller;
		$this->checkSessionAdmin();
		$this->User->id = $id;
		if(!empty($id)) {
			$this->data['User']['id'] = $id;
			if($status == 0){
				if($this->User->saveField('status', 1 )){
					$seller_products = $this->ProductSeller->find('all',array('conditions'=>array('ProductSeller.seller_id'=>$id)));
					if(!empty($seller_products)){
						foreach($seller_products as $seller_product){
							$this->ProductSeller->id = $seller_product['ProductSeller']['id'];
							$this->ProductSeller->saveField('listing_status', 1 );
						}
					}
					$this->Session->setFlash('This seller and all belonging products have been activated successfully. Now, please update minimum price for choiceful.com');
				}
			} else{
				if($this->User->saveField('status', 0 )){
					$seller_products = $this->ProductSeller->find('all',array('conditions'=>array('ProductSeller.seller_id'=>$id)));
					if(!empty($seller_products)){
						foreach($seller_products as $seller_product){
							$this->ProductSeller->id = $seller_product['ProductSeller']['id'];
							$this->ProductSeller->saveField('listing_status', 0 );
						}
					}
					$this->Session->setFlash('This seller and all belonging products have been deactivated successfully. Now please update minimum price for choiceful.com');
				}
			}
		}
		$this->redirect('index');
	}

	/** 
	@function: admin_add
	@description: to add new seller or update existing seller
	@Created by: Ramanpreet Pal
	@params	
	@Modify: NULL
	@Created Date: 
	*/
	function admin_add($id = null) {
		if(!is_null($id) ){
			$id = base64_decode($id);
		}
		$this->checkSessionAdmin();
		$this->set('id',$id);
		App::import('Model','User');
		$this->User = new User;
		App::import('Model','Address');
		$this->Address = new Address;
		
		App::import('Controller', 'Users');
		$Users = new UsersController;
		$logged_in_user_id = $this->Session->read('SESSION_ADMIN.id');
		$this->layout = 'layout_admin';
		$this->set('listTitle','Add New');	
		$titles = $this->Common->get_titles();
		$this->set('title',$titles);
		$countries = $this->Common->getcountries();
		$this->set('countries',$countries);
		
		$questions = $this->get_user_security_question();
		$this->set('security_questions',$questions);

		if(!empty($this->data)) {
			$this->data['User']['tc'] = '1';
			if(!empty($this->data['Seller']['business_name'])){
				$this->data['Seller']['business_name'] = ucwords(strtolower($this->data['Seller']['business_name']));
			}
			if(!empty($this->data['Seller']['business_display_name'])){
				$this->data['Seller']['business_display_name'] = ucwords(strtolower($this->data['Seller']['business_display_name']));
			}
			if(!empty($this->data['User']['address1'])){
				$this->data['Address']['add_address1'] = ucwords(strtolower($this->data['User']['address1']));
			}
			if(!empty($this->data['User']['address2'])){
				$this->data['Address']['add_address2'] = ucwords(strtolower($this->data['User']['address2']));
			}
			if(!empty($this->data['User']['city'])){
				$this->data['Address']['add_city'] = ucwords(strtolower($this->data['User']['city']));
			}
			if(!empty($this->data['User']['state'])){
				$this->data['Address']['add_state'] = $this->data['User']['state'];
			}
			if(!empty($this->data['User']['postcode'])){
				$this->data['Address']['add_postcode'] = $this->data['User']['postcode'];
			}
			if(!empty($this->data['User']['country_id'])){
				$this->data['Address']['country_id'] = $this->data['User']['country_id'];
			}
			if(!empty($this->data['User']['phone'])){
				$this->data['Address']['add_phone'] = $this->data['User']['phone'];
			}
			if(!empty($this->data['User']['firstname'])){
				$this->data['User']['firstname'] = ucwords(strtolower($this->data['User']['firstname']));
				$this->data['Address']['add_firstname'] = ucwords(strtolower($this->data['User']['firstname']));
			}
			if(!empty($this->data['User']['lastname'])){
				$this->data['User']['lastname'] = ucwords(strtolower($this->data['User']['lastname']));
				$this->data['Address']['add_lastname'] = ucwords(strtolower($this->data['User']['lastname']));
			}
			$this->data['User']['user_type'] = 1;
			
			//fetch user data from table
			$this->User->id = $id; 
			$seller_details = $this->User->read();
			if($seller_details['User']['email'] == $this->data['User']['email'] && $seller_details['User']['email'] == $this->data['Seller']['service_email']) {
				//unset Unique validation rule for update
				unset($this->Seller->validate['email']['isUserUniqueemail']);
				unset($this->User->validate['email']['isUnique']);
			}
			
			$this->User->set($this->data);
			$this->Seller->set($this->data);
			//pr($this->data); exit;
			$userValidate = $this->User->validates();
			$sellerValidate = $this->Seller->validates();
			if($userValidate && $sellerValidate){
				if(!empty($this->data['User']['suspend_date'])){
					$sus_date_array = explode('/',$this->data['User']['suspend_date']);
					$sus_date = $sus_date_array[2].'-'.$sus_date_array[1].'-'.$sus_date_array[0];
					$this->data['User']['suspend_date'] = $sus_date;
				}
				
				if(empty($this->data['Address']['id'])) {
					$this->data['Address']['primary_address'] = 1;
				}
				if(!empty($this->data['User']['id']) ){ // in case of edit user
					
					$this->User->set($this->data);
					$this->data['Address']['user_id'] = $this->data['User']['id'];$this->data['Seller']['user_id'] = $this->data['User']['id'];
					
					$this->data['Address'] = Sanitize::clean($this->data['Address']);
					$this->Address->set($this->data);
					$this->data['Seller'] = Sanitize::clean($this->data['Seller']);
					$this->Seller->set($this->data);
					$this->data['User'] = Sanitize::clean($this->data['User']);
					$this->User->set($this->data);
					
					
					
					if(($this->User->save()) && ($this->Seller->save()) && ($this->Address->save())){
						$savedInfo = 1;
					}else{
						$savedInfo = 0;
					}
					if(!empty($savedInfo)){
						$this->Session->setFlash('Information updated successfullly.');
						$this->redirect('/admin/sellers/');
					}else{
						$this->Session->setFlash('Information  not updated.','default',array('class'=>'flashError'));
					}
				} else { // Add customer
					$this->data['User']['activation'] = 0;
					$original_password = $this->data['User']['password'];

					$this->data['User']['password'] = md5($this->data['User']['password']);
					$this->data['User']['confirmpassword'] = md5($this->data['User']['confirmpassword']);
					$this->User->set($this->data);
					$this->data['User'] = Sanitize::clean($this->data['User']);
					$this->User->set($this->data);
					if($this->User->save()){
						$this->data['Seller']['user_id'] = $this->User->getLastInsertId();
						$this->data['Address']['user_id'] = $this->data['Seller']['user_id'];
						$this->data['Seller'] = Sanitize::clean($this->data['Seller']);
						$this->data['User'] = Sanitize::clean($this->data['User']);
						$this->Seller->set($this->data);
						$this->Address->set($this->data);
						if(($this->Seller->save()) && ($this->Address->save())) {
							$this->User->getLastInsertId();
							/** Send email after registration **/
							$this->Email->smtpOptions = array(
								'host' => Configure::read('host'),
								'username' =>Configure::read('username'),
								'password' => Configure::read('password'),
								'timeout' => Configure::read('timeout')
							);
							$this->Email->from = Configure::read('fromEmail');
							$this->Email->replyTo=Configure::read('replytoEmail');
							$this->Email->sendAs= 'html';
							App::import('Model','EmailTemplate');
							$this->EmailTemplate = new EmailTemplate;
							$link=Configure::read('siteUrl');
							/******import emailTemplate Model and get template****/
							/**
							table: 		email_templates
							id:		1
							description:	Customer registration
							*/
							$template = $this->Common->getEmailTemplate(1);
							$data=$template['EmailTemplate']['description'];
							$this->Email->from = $template['EmailTemplate']['from_email'];
							
							$this->Email->subject = $template['EmailTemplate']['subject'];
							$this->set('data',$data);
							$this->Email->to = $this->data['User']['email'];
							/******import emailTemplate Model and get template****/
							$this->Email->template='commanEmailTemplate';
							if($this->Email->send()) {
								$this->Session->setFlash('New seller added successfully.');
								$this->redirect('/admin/sellers/');
							} else{
								$this->Session->setFlash('We are unable to send you an email, please change your email address.','default',array('class'=>'flashError'));
								$this->redirect('/admin/sellers/');
							}
						} else{
							if(!empty($this->data['User']['suspend_date'])){
								$new_sus_date_array = explode('-',$this->data['User']['suspend_date']);
								$new_sus_date = $new_sus_date_array[2].'/'.$new_sus_date_array[1].'/'.$new_sus_date_array[0];
								$this->data['User']['suspend_date'] = $new_sus_date;
							}
							$this->Session->setFlash('Seller not added successfully.','default',array('class'=>'flashError'));
						}
						/** Send email after registration **/
					} else {
						if(!empty($this->data['User']['suspend_date'])){
							$new_sus_date_array = explode('-',$this->data['User']['suspend_date']);
							$new_sus_date = $new_sus_date_array[2].'/'.$new_sus_date_array[1].'/'.$new_sus_date_array[0];
							$this->data['User']['suspend_date'] = $new_sus_date;
						}
						$this->Session->setFlash('Seller not added successfully.','default',array('class'=>'flashError'));
					}
				}
			} else {
				foreach($this->data['Seller'] as $field_index => $user_info){
					$this->data['Seller'][$field_index] = html_entity_decode($user_info);
					$this->data['Seller'][$field_index] = str_replace('&#039;',"'",$this->data['Seller'][$field_index]);
				}
				foreach($this->data['User'] as $field_index => $user_info){
					$this->data['User'][$field_index] = html_entity_decode($user_info);
					$this->data['User'][$field_index] = str_replace('&#039;',"'",$this->data['User'][$field_index]);
				}
				foreach($this->data['Address'] as $field_index => $user_info){
					$this->data['Address'][$field_index] = html_entity_decode($user_info);
					$this->data['Address'][$field_index] = str_replace('&#039;',"'",$this->data['Address'][$field_index]);
				}
				$errorArray = $this->User->validationErrors;
				$this->set('errors',$errorArray);
			}
		} else{
			if(!empty($id)) {
				$this->User->id = $id;
				$this->set('listTitle','Update');
				$this->User->expects(array('Seller'));
				$this->data = $this->User->read();
				$new_sus_date = array();
				if(!empty($this->data['User']['suspend_date'])){
					$new_sus_date_array = explode('-',$this->data['User']['suspend_date']);
					$new_sus_date = $new_sus_date_array[2].'/'.$new_sus_date_array[1].'/'.$new_sus_date_array[0];
					$this->data['User']['suspend_date'] = $new_sus_date;
				}
				$primary_add_info = $this->Address->getprimary_add($id);
				//pr($primary_add_info);
				if(!empty($primary_add_info)){
					$this->data['User']['address1'] = $primary_add_info['Address']['add_address1'];
					$this->data['User']['address2'] = $primary_add_info['Address']['add_address2'];
					$this->data['User']['city'] = $primary_add_info['Address']['add_city'];
					$this->data['User']['state'] = $primary_add_info['Address']['add_state'];
					$this->data['User']['phone'] = $primary_add_info['Address']['add_phone'];
					$this->data['User']['postcode'] = $primary_add_info['Address']['add_postcode'];
					$this->data['User']['country_id'] = $primary_add_info['Address']['country_id'];
					$this->data['Address']['id'] = $primary_add_info['Address']['id'];
				}else{
					$this->data['User']['state'] = '';
				}
				//pr($this->data);
				foreach($this->data['User'] as $field_index => $user_info){
					$this->data['User'][$field_index] = html_entity_decode($user_info);
					$this->data['User'][$field_index] = str_replace('&#039;',"'",$this->data['User'][$field_index]);
				}
				foreach($this->data['Seller'] as $field_index => $user_info){
					$this->data['Seller'][$field_index] = html_entity_decode($user_info);
					$this->data['Seller'][$field_index] = str_replace('&#039;',"'",$this->data['Seller'][$field_index]);
				}
				foreach($this->data['Address'] as $field_index => $user_info){
					$this->data['Address'][$field_index] = html_entity_decode($user_info);
					$this->data['Address'][$field_index] = str_replace('&#039;',"'",$this->data['Address'][$field_index]);
				}
			}
		}
	}

	/** 
	@function:		admin_export 
	@description:		export sellers data as csv
	@params:		
	@Modify:		
	@Created Date:		Oct 20,2010
	*/
	function admin_export(){
		// GET COUNTRY ARRAY 
		$countries = $this->Common->getcountries();
		
		App::import('Model','Address');
		$this->Address = new Address;

		App::import('Model','User');
		$this->User = new User;
		$this->User->expects(array('Seller'));
		$this->User->recursive = 2;
		
		$this->data = $this->User->find('all',array('conditions'=>array('User.user_type'=>'1')));
		#Creating CSV
 		$csv_output = "Title, First Name, Last Name, Email, Address1, Address2, Town/City, State/County, Postcode, Country, Phone, Contact By Phone, Contact By partner, Status, Business Name, Business Business Display Name,Secret Question, Secret Answer, Service Email, Business Bank Sort Code, Business Bank Account Number, Business Account Holder Name, Business Paypal Account Email, Free Delivery, Threshold Order Value, Gift Service, Created on Date ";

		$csv_output .= "\n";
		if(count($this->data) > 0){
			foreach($this->data as $value){
				
				foreach($value['User'] as $field_index => $user_info){
					$value['User'][$field_index] = html_entity_decode($user_info);
					$value['User'][$field_index] = str_replace('&#039;',"'",$value['User'][$field_index]);
				}
				foreach($value['Seller'] as $field_index => $user_info){
					$value['Seller'][$field_index] = html_entity_decode($user_info);
					$value['Seller'][$field_index] = str_replace('&#039;',"'",$value['Seller'][$field_index]);
				}
				$contact_by_phone = $value['User']['contact_by_phone'] == 1? 'Yes':'No';
				$contact_by_partner = ($value['User']['contact_by_partner'] == 1)?('Yes'):('No');
				$user_status = ($value['User']['status'] == 1)?('Active'):('InActive');
				$free_delivery = ($value['Seller']['free_delivery'] == 1)?('Yes'):('No');
				$gift_service = ($value['Seller']['gift_service'] == 1)?('Yes'):('No');
				$created_date   = date('m/d/Y',strtotime($value['User']['created']));
				$addressDetails = $this->Address->getprimary_add($value['User']['id']);
				foreach($addressDetails['Address'] as $field_index => $user_info){
					$addressDetails['Address'][$field_index] = html_entity_decode($user_info);
					$addressDetails['Address'][$field_index] = str_replace('&#039;',"'",$addressDetails['Address'][$field_index]);
				}
				$address1 = $addressDetails['Address']['add_address1'];
				$address2 = $addressDetails['Address']['add_address2'];
				$postcode = $addressDetails['Address']['add_postcode'];
				$city = $addressDetails['Address']['add_city'];
				$state_county = $addressDetails['Address']['add_state'];
				$phone_number = $addressDetails['Address']['add_phone'];
				$add_country_id = $addressDetails['Address']['country_id'];
				$country_name = (!empty($add_country_id) )?($countries[$add_country_id]):('');
				$csv_output .= "".str_replace(",",' || ',
				$value['User']['title']).",".str_replace(",",' || ',
				$value['User']['firstname']).",".str_replace(",",' || ',$value['User']['lastname']).",".str_replace(",",' || ',
				$value['User']['email']).",".str_replace(",",' || ',$address1).",".str_replace(",",' || ',$address2).",".str_replace(",",' || ',
				$city).",".str_replace(",",' || ',$state_county).",".str_replace(",",' || ',$postcode).",".str_replace(",",' || ',$country_name).",".str_replace(",",' || ',$phone_number).",".str_replace(",",' || ',
				$contact_by_phone).",".str_replace(",",' || ',$contact_by_partner).",".str_replace(",",' || ',
				$user_status).",".str_replace(",",' || ',
				$value['Seller']['business_name']).",".str_replace(",",' || ',$value['Seller']['business_display_name']).",".str_replace(",",' || ',$value['Seller']['secret_question']).",".str_replace(",",' || ',
				$value['Seller']['secret_answer']).",".str_replace(",",' || ',
				$value['Seller']['service_email']).",".str_replace(",",' || ',
				$value['Seller']['bank_sort_code']).",".str_replace(",",' || ',$value['Seller']['bank_account_number']).",".str_replace(",",' || ',
				$value['Seller']['account_holder_name']).",".str_replace(",",' || ',
				$value['Seller']['paypal_account_mail']).",".str_replace(",",' || ',$free_delivery).",".str_replace(",",' || ',
				$value['Seller']['threshold_order_value']).",".str_replace(",",' || ',$gift_service).",".str_replace(",",' || ',$created_date).",\n";
			}
		}else{
			$csv_output .= "No Record Found.."; 
		}
		header("Content-type: application/vnd.ms-excel");
		$filePath="sellers_".date("Ymd").".csv";
		header("Content-Disposition: attachment; filename=".$filePath."");
		header("Pragma: no-cache");
		header("Expires: 0");
		print $csv_output;
		exit;
	}

	/** 
	@function: my_account
	@description: to sign up for a sellers account
	@Created by: Ramanpreet Pal
	@params	
	@Modify: NULL
	@Created Date: Nov 16, 2010
	*/
	function my_account(){
		if($this->RequestHandler->isAjax()==0)
 			$this->layout = 'marketplace_fullscreen';
 		else
			$this->layout = 'ajax';
		$this->set('title_for_layout','Choiceful.com Marketplace: My Marketplace - Account Settings');
		$this->checkSessionFrontUser();
		$seller_id = $this->Session->read('User.seller_id');
		$userId = $this->Session->read('User.id');
		if(!empty($seller_id)){
			if(!empty($this->data)){
				$this->Seller->set($this->data);
				$sellerValidate = $this->Seller->validates();
				if(!empty($sellerValidate)){
					
				} else {
					foreach($this->data['Seller'] as $field_index => $user_info){
						$this->data['Seller'][$field_index] = html_entity_decode($user_info);
						$addressDetails['Seller'][$field_index] = str_replace('&#039;',"'",$this->data['Seller'][$field_index]);
					}
					$errorArray = $this->Seller->validationErrors;
					$this->set('errors',$errorArray);
				}
			} else{
				$seller_detail = $this->seller_account_info($seller_id,$userId);
				$this->data = $seller_detail;
				$this->set('seller_info',$this->data);
			}
		} else{
			$this->Session->setFlash('This email address is already registered, please sign in to upgrade to a seller account.');
			$this->redirect('/homes/');
		}
	}

	/** 
	@function: save_giftoptions
	@description: to update gift service for seller
	@Created by: Ramanpreet Pal
	@params	
	@Modify: NULL
	@Created Date: 
	*/
	function save_giftoptions(){
		$this->layout = 'ajax';
		$this->checkSessionFrontUser();
		$seller_id = $this->Session->read('User.seller_id');
		$this->Seller->id = $seller_id;
		if($this->Seller->saveField('gift_service',$this->data['Seller']['gift_service'])){
			$this->Session->setFlash('Gift option settings have been updated.');
		} else{
			$this->Session->setFlash('Gift options not updated successfully.','default',array('class'=>'flashError'));
		}
		$seller_detail = $this->seller_account_info($seller_id);
		$this->data = $seller_detail;
		$this->viewPath = 'elements/marketplace' ;
		$this->render('gift_options');
	}

	/** 
	@function: save_freedelivery
	@description: to update free delivery service for seller
	@Created by: Ramanpreet Pal
	@params	
	@Modify: NULL
	@Created Date: 
	*/
	function save_freedelivery(){
		$this->layout = 'ajax';
		$this->checkSessionFrontUser();
		$seller_id = $this->Session->read('User.seller_id');
		$this->data['Seller']['id'] = $seller_id;
		$current_data = array();
		$this->Seller->set($this->data);
		if(!empty($this->data)){
			$this->data = $this->cleardata($this->data);
			//$this->data = Sanitize::clean($this->data, array('encode' => false));
			$sellerValidate = $this->Seller->validates();	
			if(!empty($sellerValidate)){
				if(empty($this->data['Seller']['free_delivery'])){
					$this->data['Seller']['threshold_order_value'] = 0;
				}
				$this->data['Seller'] = Sanitize::clean($this->data['Seller']);
				$this->Seller->set($this->data);
				$this->Seller->id=$this->data['Seller']['id'];
				$this->Seller->saveField('free_delivery',$this->data['Seller']['free_delivery']);
				$this->Seller->saveField('threshold_order_value',$this->data['Seller']['threshold_order_value']);
				if(!empty($this->data['Seller']['id'])){
					$this->Session->setFlash('Free delivery settings have been updated successfully.');
				} else{
					$this->Session->setFlash('Free delivery option not updated.','default',array('class'=>'flashError'));
				}
			} else{
				foreach($this->data['Seller'] as $field_index => $user_info){
					$this->data['Seller'][$field_index] = html_entity_decode($user_info);
					$this->data['Seller'][$field_index] = str_replace('&#039;',"'",$this->data['Seller'][$field_index]);
				}
				$errorArray = $this->Seller->validationErrors;
				$current_data['Seller'] = $this->data['Seller'];
				$this->set('errors',$errorArray);
			}
		} else{
			$this->set('errors','');
		}
			
		$seller_detail = $this->seller_account_info($seller_id);
		$this->data = $seller_detail;
		if(!empty($current_data)){
			$this->data['Seller']['free_delivery'] = $current_data['Seller']['free_delivery'];
			$this->data['Seller']['threshold_order_value'] = $current_data['Seller']['threshold_order_value'];
		}
		if ($this->RequestHandler->isMobile()) {
			$this->viewPath = 'elements/mobile/marketplace' ;
		}else{
			$this->viewPath = 'elements/marketplace' ;
		}
		$this->render('free_delivery');
	}


	/** 
	@function: update_business_info
	@description: to update business information for seller
	@Created by: Ramanpreet Pal
	@params	
	@Modify: NULL
	@Created Date: 
	*/
	function update_business_info(){
		$this->layout = 'ajax';
		$this->checkSessionFrontUser();
		$countries = $this->Common->getcountries();
		$this->set('countries',$countries);
		$seller_id = $this->Session->read('User.seller_id');
		$userId = $this->Session->read('User.id');
		App::import('Model','Address');
		$this->Address = new Address;
		if(!empty($this->data)){
			
			$this->data = $this->cleardata($this->data);
			//$this->data = Sanitize::clean($this->data, array('encode' => false));
			
			$this->data['Seller']['id'] = $seller_id;
			$this->Seller->set($this->data);
			$sellerValidate = $this->Seller->validates();
			if(!empty($sellerValidate)){
				$this->data['Seller']['business_display_name'] = ucwords(strtolower($this->data['Seller']['business_display_name']));
				$this->data['Address']['add_address1'] = ucwords(strtolower($this->data['Seller']['address1']));
				$this->data['Address']['add_address2'] = ucwords(strtolower($this->data['Seller']['address2']));
				$this->data['Address']['add_city'] = ucwords(strtolower($this->data['Seller']['city']));
				$this->data['Address']['add_postcode'] = $this->data['Seller']['postcode'];
				$this->data['Address']['country_id']   = $this->data['Seller']['country_id'];
				$this->data['Address']['add_state']    = $this->data['Seller']['state'];
				if(!empty($this->data['Seller']['address_id'])){
					$this->data['Address']['id'] = $this->data['Seller']['address_id'];
				} else{
					$this->data['Address']['id'] = 0;
					$this->data['Address']['user_id'] = $userId;
				}
				$this->Address->set($this->data);
				$this->data['Address'] = Sanitize::clean($this->data['Address']);
				if($this->Address->save($this->data)){
					$saveflag = 1;
				} else{
					$saveflag = 0;
				}
				$this->data['Seller'] = Sanitize::clean($this->data['Seller']);
				$this->Seller->set($this->data);
				if($this->Seller->save($this->data)){
					$saveflag = 1;
				} else{
					$saveflag = 0;
					
				}
				if($saveflag == 1){
					$this->Session->setFlash('Business information has been saved.');
					$seller_detail = $this->seller_account_info($seller_id,$userId);
					$this->data = $seller_detail;
					$this->viewPath = 'elements/marketplace' ;
					$this->render('business_info');
					
				} else{
					$this->Session->setFlash('Business information not updated successfully.','default',array('class'=>'flashError'));
					$this->viewPath = 'elements/marketplace' ;
					$this->render('update_business_info');
				}
			} else{
				if(!empty($this->data['Seller'])){
					foreach($this->data['Seller'] as $field_index => $user_info){
						$this->data['Seller'][$field_index] = html_entity_decode($user_info);
						$this->data['Seller'][$field_index] = str_replace('&#039;',"'",$this->data['Seller'][$field_index]);
					}
				}
				if(!empty($this->data['Address'])){
					foreach($this->data['Address'] as $field_index => $user_info){
						$this->data['Address'][$field_index] = html_entity_decode($user_info);
						$this->data['Address'][$field_index] = str_replace('&#039;',"'",$this->data['Address'][$field_index]);
					}
				}
				$errorArray = $this->Seller->validationErrors;
				$this->set('errors',$errorArray);
				$this->viewPath = 'elements/marketplace' ;
				$this->render('update_business_info');
			}
		} else{
			$seller_detail = $this->seller_account_info($seller_id,$userId);
			$this->data = $seller_detail;
			if(!empty($this->data['Seller'])) {
				foreach($this->data['Seller'] as $field_index => $user_info){
					$this->data['Seller'][$field_index] = html_entity_decode($user_info);
					$this->data['Seller'][$field_index] = str_replace('&#039;',"'",$this->data['Seller'][$field_index]);
				}
			}
			
			$this->viewPath = 'elements/marketplace' ;
			$this->render('update_business_info');
		}
	}

	/** 
	@function: update_customer_info
	@description: to update customer information for seller
	@Created by: Ramanpreet Pal
	@params	
	@Modify: NULL
	@Created Date: 
	*/
	function update_customer_info(){
		$this->layout = 'ajax';
		$this->checkSessionFrontUser();
		
		$seller_id = $this->Session->read('User.seller_id');
		$userId = $this->Session->read('User.id');
		if(!empty($this->data)){
			$this->data = $this->cleardata($this->data);
			//$this->data = Sanitize::clean($this->data, array('encode' => false));
			
			$this->data['Seller']['id'] = $seller_id;
			$this->Seller->set($this->data);
			App::import('Model','Address');
			$this->Address = new Address;
			$sellerValidate1 = $this->Seller->validates();
			$flag_save = 0;
			if(!empty($sellerValidate1)){
				if(!empty($this->data['Seller']['phone'])){
					$this->data['Address']['add_phone'] = $this->data['Seller']['phone'];
					if(!empty($this->data['Seller']['address_id'])){
						$this->data['Address']['id'] = $this->data['Seller']['address_id'];
					} else{
						$this->data['Address']['id'] = 0;
						$this->data['Address']['user_id'] = $userId;
					}
					
					$this->data['Address'] = Sanitize::clean($this->data['Address']);
					$this->Address->set($this->data);
					if($this->Address->save($this->data)){
						$flag_save = 1;
					} else{
						$flag_save = 0;
					}
				}
				
				$this->data['Seller'] = Sanitize::clean($this->data['Seller']);
				$this->Seller->set($this->data);
				if($this->Seller->save($this->data)){
					$flag_save = 1;
				} else{
					$flag_save = 0;
				}
				if($flag_save == 1){
					$this->Session->setFlash('Customer contact information has been saved.');
					$seller_detail = $this->seller_account_info($seller_id,$userId);
					$this->data = $seller_detail;
					$this->set('seller_info',$this->data);
					$this->viewPath = 'elements/marketplace' ;
					$this->render('customer_service_information');
				} else{
					$this->Session->setFlash('Customer contact information not updated successfully.','default',array('class'=>'flashError'));
					$this->viewPath = 'elements/marketplace' ;
					$this->render('update_cus_ser_info');
				}
			} else{
				foreach($this->data['Seller'] as $field_index => $user_info){
					$this->data['Seller'][$field_index] = html_entity_decode($user_info);
					$this->data['Seller'][$field_index] = str_replace('&#039;',"'",$this->data['Seller'][$field_index]);
				}
				$errorArray = $this->Seller->validationErrors;
				$this->set('errors',$errorArray);
				$this->viewPath = 'elements/marketplace' ;
				$this->render('update_cus_ser_info');
			}
		} else {
			$seller_detail = $this->seller_account_info($seller_id,$userId);
			$this->data = $seller_detail;
			$this->set('seller_info',$this->data);
			$this->viewPath = 'elements/marketplace' ;
			$this->render('update_cus_ser_info');
		}
	}

	/** 
	@function: upload_seller_image
	@description: to update seller image
	@Created by: Ramanpreet Pal
	@params	
	@Modify: NULL
	@Created Date: 
	*/
	function upload_seller_image(){
		$this->checkSessionFrontUser();
		$seller_id = $this->Session->read('User.seller_id');
		if(empty($this->data['Seller']['photo']['name'])){
			$this->Session->setFlash('Please select a file to upload and note it should match the requirements provided.','default',array('class'=>'flashError'));
			$this->redirect('/sellers/my_account');
		}
		App::import('Component','File');
		$this->File=new FileComponent();
		
		if(!empty($this->data['Seller']['photo']['name'])){

			$imageType = explode('/', $this->data['Seller']['photo']['type']);
			$validationFlag = $this->File->validateGifJpgImage( $imageType[1] );
			if( $validationFlag == false){ // if validation fails 
				$this->Session->setFlash('Failed to upload your image. Please upload JPEG or GIF format files.','default',array('class'=>'flashError'));
			}else{
				$this->File->destPath =  WWW_ROOT.PATH_SELLER;
				$this->File->setFilename($seller_id.'_'.$this->data['Seller']['photo']['name']);
				
				$fileName  = $this->File->uploadFile($this->data['Seller']['photo']['name'],$this->data['Seller']['photo']['tmp_name']);
				$mime ='';
				//@copy($this->File->destPath.DS.$fileName,$this->File->destPath.DS.$fileName);
				$this->Thumb->getResized($fileName, $mime, $this->File->destPath, 100, 30, 'FFFFFF', true, true,$this->File->destPath, false);
					
				if(empty($fileName)){
					$this->Session->setFlash('Failed to upload your image.','default',array('class'=>'flashError'));
				}else{
					$this->Seller->id = $seller_id;
					$oldfile = $this->Seller->findById($seller_id);
					$this->File->deleteFile( $oldfile['Seller']['image']);
					$this->data['Seller']['image'] = $fileName;
					$this->data['Seller']['id'] = $seller_id;
					//$this->data['Seller'] = Sanitize::clean($this->data['Seller']);
					$this->Seller->set($this->data);
					$this->Seller->save($this->data);
					$this->Session->setFlash('Image uploaded successfully.');
				}
			}
			@$this->redirect('/sellers/my_account');
		} else{
		}
	}


	/** 
	@function: seller_account_info
	@description: to display sellers account information
	@Created by: Ramanpreet Pal
	@params	
	@Modify: NULL
	@Created Date: 
	*/
	function seller_account_info($seller_id = null,$userId = null){
		App::import('Model','Address');
		$this->Address = new Address;
		$seller_detail = $this->Seller->find('first',array('conditions'=>array('Seller.id'=>$seller_id),'fields'=>array('Seller.service_email','Seller.image','Seller.business_display_name','Seller.free_delivery','Seller.threshold_order_value','Seller.gift_service')));
		$this->Address->expects(array('Country'));
		$add_info = $this->Address->find('first',array('conditions'=>array('Address.user_id'=>$userId)));

		if(!empty($add_info)){
			$seller_detail['Seller']['phone'] = $add_info['Address']['add_phone'];
			$seller_detail['Seller']['address1'] = $add_info['Address']['add_address1'];
			$seller_detail['Seller']['address2'] = $add_info['Address']['add_address2'];
			$seller_detail['Seller']['postcode'] = $add_info['Address']['add_postcode'];
			$seller_detail['Seller']['city'] = $add_info['Address']['add_city'];
			$seller_detail['Seller']['state'] = $add_info['Address']['add_state'];
			$seller_detail['Seller']['country_id'] = $add_info['Address']['country_id'];
			$seller_detail['Seller']['address_id'] = $add_info['Address']['id'];
			$seller_detail['Country'] = $add_info['Country'];
		} else{
			$seller_detail['Seller']['phone'] = '';
			$seller_detail['Seller']['address1'] = '';
			$seller_detail['Seller']['address2'] = '';
			$seller_detail['Seller']['postcode'] = '';
			$seller_detail['Seller']['city'] = '';
			$seller_detail['Seller']['state'] = '';
			$seller_detail['Seller']['country_id'] = '';
			$seller_detail['Seller']['address_id'] = '';
			$seller_detail['Country']['country_name'] = '';
		}
		if(!empty($seller_detail)){
			foreach($seller_detail['Seller'] as $field_index => $user_info){
				$seller_detail['Seller'][$field_index] = html_entity_decode($user_info);
				$seller_detail['Seller'][$field_index] = str_replace('&#039;',"'",$seller_detail['Seller'][$field_index]);
			}
		}
		return $seller_detail;
	}
	
	
	/** 
	@function: view_bulk_listing
	@description: to display workbooks of every seller
	@Created by: Ramanpreet Pal
	@params: NULL
	@Modify: NULL
	@Created Date: Dec 9,2010
	*/
	function admin_view_bulk_listing() {
		$this->layout='layout_admin';
		App::import('Model','BulkUpload');
		$this->BulkUpload = new BulkUpload;
		$criteria = 1;
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
		/** **************************************** **/
		$this->set('title_for_layout',"Manage Seller's Volume Listing");
		$value = '';	
		$show = '';
		$matchshow = '';
		$fieldname = '';
		/** SEARCHING **/

		$reqData = $this->data;
		$options['All'] = 'All';
		$options['User.firstname'] = "Firstname";
		$options['User.lastname'] = "Lastname";
		$options['User.email'] = "Email";
		$this->set('options',$options);
		if(!empty($this->data['Search'])){
			if(!empty($this->data['Search']['searchin'])){
				$fieldname = $this->data['Search']['searchin'];
			} else{
				$fieldname = 'All';
			}
			$value = trim($this->data['Search']['keyword']);
			App::import('Sanitize');
			$value1 = Sanitize::escape($value);
			if($value !="") {
				if(trim($fieldname)=='All'){
					$criteria .= " and (User.firstname LIKE '%".$value1."%' OR User.lastname LIKE '%".$value1."%' OR User.email LIKE '%".$value1."%')";
				} else {
					if(trim($fieldname)!=''){
						if(isset($value) && $value!=="") {
							$criteria .= " and ".$fieldname." LIKE '%".$value1."%'";
						}
					}
				}
			}
			
		}
		$this->set('keyword', $value);
		$this->set('fieldname',$fieldname);
		$this->set('heading','Manage Volume Sellers');
		
		/* ******************* page limit sction **************** */
		$sess_limit_name = $this->params['controller']."volumesellers_limit";
		$sess_limit_value = $this->Session->read($sess_limit_name);
		if(!empty($this->data['Record']['limit'])){
		   $limit = $this->data['Record']['limit'];
		   $this->Session->write($sess_limit_name , $this->data['Record']['limit'] );
		}elseif( !empty($sess_limit_value) ){
			$limit = $sess_limit_value;
		}else{
			$limit = $this->records_per_page;  // set default value
		}
		$this->data['Record']['limit'] = $limit;
		/* ******************* page limit sction **************** */
		$this->paginate = array(
			'limit' => $limit,
			'order' => array(
				'BulkUpload.id' => 'DESC'
			),
			'fields' => array(
				'User.id',
				'User.title',
				'User.firstname',
				'User.lastname',
				'User.email',
				'BulkUpload.id',
				'BulkUpload.user_id',
				'BulkUpload.sample_file',
				'BulkUpload.modified',
				'BulkUpload.created',
			)
		);
		$this->BulkUpload->expects(array('User'));
		$this->set('volumeArr',$this->paginate('BulkUpload',$criteria));
	}
	
	
	
	/** 
	@function: admin_upload_bulk_listing_success
	@description: to show success of listing
	@Created by: Kulvinder
	@Modify:  21-Dec 2010
	*/
	function admin_upload_bulk_listing_success($errorFileName = null){
		$this->layout='layout_admin';
		$this->set('listTitle',"Volume Seller's Listing Successfull !");
		$uploadStatus = $this->Session->read('upload_status');
		$this->set('uploadStatus',$uploadStatus);
		$this->Session->write('upload_status', '' );
		if(!empty($errorFileName)){
			$errorFileName = base64_decode($errorFileName);
		} else{
			$errorFileName ='';
		}
		$this->set('errorFileName',$errorFileName);
	}
	
	/** 
	@function: upload_bulk_listing
	@description: to upload updated  volume  selles's listing
	@Created by: Kulvinder
	@Modify:  20-Dec 2010
	*/
	function admin_upload_bulk_listing($id = null){
		$this->layout='layout_admin';
		$this->set('listTitle',"Upload Volume Seller's Listing");
		$this->set('id',$id);
		if(empty($id)){
			$this->redirect('/admin/sellers/view_bulk_listing');
		}
		$sellers =  $this->Common->getsellers();
			
		$productConditions = array(
			'NEW' => '1',
			'USED-LIKE NEW' => '2',
			'USED-AVERAGE' => '3',
			'NEW-LIMITED EDITION' => '4' ,
			'USED-LIMITED EDITION' => '5',
			'USED-LIMITED EDITION-LIKE NEW' => '6',
			'USED-LIMITED EDITION-AVERAGE' => '7'
		);
		$this->set('sellers',$sellers);
		$this->set('Products_all' , '');
		$this->set('Products_uploaded' , '');
		$this->set('Products_notuploaded' , '');
		$this->set('form_posted' , false);
		// import bulk upload database
		App::import('Model','ProductSeller');
		$this->ProductSeller = new ProductSeller;
		$Products_all = '';
		$Products_uploaded = '';
		$Products_notuploaded = '';
		$skipped_header_row = '';
		if(!empty($this->data)) {
			$this->ProductSeller->set($this->data);
			$sellerValidate = $this->ProductSeller->validates();
			if($this->data['ProductSeller']['sample_bulk_data']['name'] != '') {
				// validate the csv file type
				$validationFlag = $this->File->validateCsvFile( $this->data['ProductSeller']['sample_bulk_data']['name']);
				if( $validationFlag  == true ) {  // if in accepted formats
					$this->set('form_posted' , true);
					$file = $this->data['ProductSeller']['sample_bulk_data']['tmp_name'];
					$seller_id = $this->data['ProductSeller']['seller_id'];
					$skipped_rows = '';
					$handle = fopen($file, 'r');
					$rowchek = fgetcsv($handle, 4096, ",");
					$columns_count = count($rowchek);
					if( $columns_count == 16){ // is file is ok to upload
						$skipped_header_row = implode(', ', $rowchek);
						while (($row = fgetcsv($handle, 4096, ",")) !== FALSE) {
							$first_row_test  = strtoupper(trim($row[0]));
							if( ($first_row_test == 'QUICK CODE' ) || ($first_row_test == 'QUICKCODE') || ($first_row_test == 'QCID')){
								// skip the first row
								continue;
							}
							$quick_code = trim($row[0]);
							#get product id from quick code
								$product_id = $this->Common->getProductIdfromQuickCode($quick_code);
							$Products_all++;
							// skip the process without produt is
							if(!$product_id || $product_id == false || $product_id == ''){
								$skipped_rows .= implode(', ', $row);
								$skipped_rows .= "\n";
								$Products_notuploaded++;
								continue;
							}
							$Products_uploaded++;
							$this->data['ProductSeller']['id'] = '';
							$this->data['ProductSeller']['seller_id'] = $seller_id ;
							$this->data['ProductSeller']['product_id'] = $product_id;
							$this->data['ProductSeller']['reference_code'] = trim($row[1]);
							$this->data['ProductSeller']['barcode']      = trim($row[2]);
							$this->data['ProductSeller']['dispatch_country'] = trim($row[5]);
							$this->data['ProductSeller']['quantity'] = trim($row[6]);
							$this->data['ProductSeller']['condition_id'] = $productConditions[trim($row[7])];
							$this->data['ProductSeller']['notes'] = trim($row[8]);
							$this->data['ProductSeller']['price'] = trim($row[9]);
							$this->data['ProductSeller']['minimum_price_disabled'] = (trim(strtoupper($row[10])) == 'YES')?('0'):('1');
							$this->data['ProductSeller']['minimum_price'] = trim($row[11]);
							$this->data['ProductSeller']['standard_delivery'] = (trim(strtoupper($row[12])) == 'YES')?('1'):('0');
							$this->data['ProductSeller']['standard_delivery_price'] = trim($row[13]);
							$this->data['ProductSeller']['express_delivery'] = (trim(strtoupper($row[14])) == 'YES')?('1'):('0');
							$this->data['ProductSeller']['express_delivery_price'] = trim($row[15]);
							$this->data['ProductSeller'] = Sanitize::clean($this->data['ProductSeller']);
							$this->ProductSeller->set($this->data);
							if(!$this->ProductSeller->save($this->data)){
								$skipped_rows .= implode(', ', $row);
								$skipped_rows .= "\n";
								$Products_notuploaded++;
								continue;
							} else{
								
							}
						}
						if($skipped_rows != ''){ // set the skipped rows data
							$skipped_file_contents  = $skipped_header_row;
							$skipped_file_contents  .= "\n";
							$skipped_file_contents .= $skipped_rows;	
							$errorFileName = "Failed_".str_replace(" ", "_", $this->data['ProductSeller']['sample_bulk_data']['name']);
							$filename = WWW_ROOT."files/error_files/".$errorFileName;
							$fp = fopen($filename, "w+");
							fwrite($fp, $skipped_file_contents);
						}
						$uploadStatus['all_products']     	= $Products_all;
						$uploadStatus['uploaded_products']	= $Products_uploaded;
						$uploadStatus['notuploaded_products']	= $Products_notuploaded;
						$this->Session->write('upload_status' ,$uploadStatus );
						if(!empty($errorFileName)){
							$errorFileName = base64_encode($errorFileName);
							$this->redirect('/admin/sellers/upload_bulk_listing_success/'.$errorFileName);
						} else{
							$this->redirect('/admin/sellers/upload_bulk_listing_success');
						}
					}else{
						$this->Session->setFlash('Selected file is not in proper format.please check the file columns !', 'default', array( 'class'=>'flashError') );
					}
				} else{
					$this->Session->setFlash('Select only csv file to upload !', 'default', array( 'class'=>'flashError') );
				}
			} else {
				$this->Session->setFlash('Please select a file to upload !', 'default', array( 'class'=>'flashError') );
			}
		} else{
		}
	}
	
	/**
	@function: admin_delete
	@Modify: NULL
	*/
	
	function admin_delete_volumefile($id = null) {
		$deleted = $this->deletefile($id);
		if(!empty($deleted)){
			$this->Session->setFlash('Record has been deleted successfully.');
		} else{
			$this->Session->setFlash('Error in deleting records.','default',array('class'=>'flashError'));
		}
		$this->redirect('view_bulk_listing');
	}
	
	/** 
	@function: deletefile
	@description: to delete a bulk uploaded product file
	@params	
	@Modify: NULL
	@Created Date: 
	*/
	function deletefile($id = null){
		App::import('Model','BulkUpload');
		$this->BulkUpload = new BulkUpload;
		App::import('Component','File');
		$this->File=new FileComponent();
		$this->File->destPath =  WWW_ROOT.PATH_BULKUPLOADS;
		$file=$this->BulkUpload->findById($id,'sample_file');
		if($this->BulkUpload->deleteAll("BulkUpload.id ='".$id."'")){
			if(!empty($file['BulkUpload']['sample_file'])){
				$this->File->deleteFile($file['BulkUpload']['sample_file']);
			}
			return true;
		} else{
			return false;
		}
	}

	/** 
	@function	: admin_multiplAction
	@description	: Active/Deactive/Delete multiple record
	@params		: NULL
	**/
	function admin_multiplAction_volumefile(){
		App::import('Model','BulkUpload');
		$this->BulkUpload = new BulkUpload;
		if($this->data['BulkUpload']['status']=='del'){
			foreach($this->data['select'] as $id){
				if(!empty($id)){
					$deleted = $this->deletefile($id);
					if(!empty($deleted)){
						$this->Session->setFlash('Record has been deleted successfully.');
					}else{
						$this->Session->setFlash('Error in deleting records.','default',array('class'=>'flashError'));
					}
				}
			}
		}
		/** for searching and sorting*/
		if(empty($this->data)) {
			if(isset($this->params['named']['searchin']))
				$this->data['Search']['searchin']=$this->params['named']['searchin'];
			else
				$this->data['Search']['searchin']='';
			if(isset($this->params['named']['keyword']))
				$this->data['Search']['keyword']=$this->params['named']['keyword'];
			else
				$this->data['Search']['keyword']='';
		}
		/** for searching and sorting*/
		$this->redirect('/admin/sellers/view_bulk_listing/keyword:'.$this->data['Search']['keyword'].'/searchin:'.$this->data['Search']['searchin']);
	}
	
	/** 
	@function	:	admin_download_bulk_files
	@description	:	admin_download_bulk_files
	@params		:	NULL
	**/
	function admin_download_bulk_files($file_name = null){
		$filePath = WWW_ROOT.PATH_BULKUPLOADS.$file_name;
		$file_contents = file_get_contents($filePath);
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=".$file_name."");
		header("Pragma: no-cache");
		header("Expires: 0");
		echo $file_contents;
		exit;
	}

	/** 
	@function	:	download_files
	@description	:	download_files
	@params		:	NULL
	**/
	function admin_download_error_file($file_name = null){
		$filePath = WWW_ROOT."files/error_files/".$file_name;
		$file_contents = file_get_contents($filePath) ;
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=".$file_name."");
		header("Pragma: no-cache");
		header("Expires: 0");
		echo $file_contents;
		exit;
	}

	/** 
	@function	:	download_paymentreport_files
	@description	:	download_files
	@params		:	NULL
	**/
	function download_paymentreport_files($file_name = null){
		$filePath = WWW_ROOT."files/payment_reports/".$file_name;
		$file_contents = file_get_contents($filePath) ;
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=".$file_name."");
		header("Pragma: no-cache");
		header("Expires: 0");
		echo $file_contents;
		exit;
	}


	/** 
	@function: payment_settings
	@description: to enter payment information for a sellers account
	@Created by: Ramanpreet Pal
	@params	
	@Modify: kulvinder Singh
	@Created Date: Jan 05, 2011
	*/
	function payment_settings(){
		if($this->RequestHandler->isAjax()==0)
 			$this->layout = 'marketplace_fullscreen';
 		else
			$this->layout = 'ajax';
		$this->set('title_for_layout','Choiceful.com Marketplace: My Marketplace - Payment Settings');
		$this->checkSessionFrontUser();
		$seller_id = $this->Session->read('User.seller_id');
		$user_email = $this->Session->read('User.email');
		$user_firstname = $this->Session->read('User.firstname');
		$user_lastname = $this->Session->read('User.lastname');
		//check the number of attempts for entering deposits
		$seller_info = $this->Seller->find('first',array('conditions'=>array('Seller.id'=>$seller_id),'fields'=>array('Seller.attempt_number','Seller.status')));
		if(!empty($seller_id)){
			if(($seller_info['Seller']['status'] == 1 || $seller_info['Seller']['status'] == 2) && $seller_info['Seller']['attempt_number']<3){	
				$this->redirect('/sellers/deposit/');
			}else if($seller_info['Seller']['status'] == 3){ // verified by admin
				$this->redirect('/sellers/payment_summary/');
			}
			if(!empty($this->data)){
				
				$this->data = $this->cleardata($this->data);
				//$this->data = Sanitize::clean($this->data, array('encode' => false));
				
				$this->data['Seller']['validation'] = 1;
				$this->Seller->set($this->data);
				if($this->Seller->validates()){
					$this->data['Seller']['id'] = $seller_id;
					$this->data['Seller']['bank_sort_code'] = $this->data['Seller']['sortcode1'].'-'.$this->data['Seller']['sortcode2'].'-'.$this->data['Seller']['sortcode3'];
					$this->data['Seller']['status'] = 1; // set flag when data is filled for first time time
					$email_info = $this->data;
					if($this->data['Seller']['bank_ac_number'] != ''){
						$this->data['Seller']['bank_account_number'] = '******'.substr($this->data['Seller']['bank_ac_number'],-4);
					}
					if($this->data['Seller']['paypal_account_mail'] != ''){
						$paypal_email = split("@", $this->data['Seller']['paypal_account_mail']);
						if(is_array($paypal_email) && count($paypal_email)>0){
							$length = strlen($paypal_email[0]);
							$f = substr($paypal_email[0],0,1);
							$e = substr($paypal_email[0],-1);
							$hidden_email = $f;
							for($l=0; $l<$length-2; $l++){
								$hidden_email .= 'x';
							}
							$hidden_email .= $e;
							$hidden_email .= '@'.$paypal_email[1];
						}
						$this->data['Seller']['paypal_account_mail'] = $hidden_email;
					}
					$this->data['Seller']['bank_sort_code'] = '';
					$this->data['Seller'] = Sanitize::clean($this->data['Seller']);
					$this->Seller->set($this->data);
					if($this->Seller->save($this->data)){
						
						$this->Email->smtpOptions = array(
							'host' => Configure::read('host'),
							'username' =>Configure::read('username'),
							'password' => Configure::read('password'),
							'timeout' => Configure::read('timeout')
						);
						$this->Email->from = $user_email;
						$this->Email->replyTo = $user_email;
						$this->Email->sendAs= 'html';
						
						App::import('Model','EmailTemplate');
						$this->EmailTemplate = new EmailTemplate;
						$link=Configure::read('siteUrl');
						/** 
						table: 		email_templates
						id:		26
						description:	Choiceful Marketplace - Payments
						**/
						
						if($email_info['Seller']['bank_sort_code'] != ''){
							$sortCode = $email_info['Seller']['bank_sort_code'];
						}else{
							$sortCode = 'N/A';
						}
						if($email_info['Seller']['bank_ac_number'] != ''){
							$accNumber = $email_info['Seller']['bank_ac_number'];
						}else{
							$accNumber = 'N/A';
						}
						if($email_info['Seller']['account_holder_name'] != ''){
							$name = $email_info['Seller']['account_holder_name'];
						}else{
							$name = 'N/A';
						}
						if($email_info['Seller']['paypal_account_mail'] != ''){
							$paypal = $email_info['Seller']['paypal_account_mail'];
						}else{
							$paypal = 'N/A';
						}
						
						$template =  $this->Common->getEmailTemplate('26'); // get email template for ID : 26 
						
						$this->Email->from = $template['EmailTemplate']['from_email'];
						
						$data=$template['EmailTemplate']['description'];
						if(!empty($email_info['Seller']['id']))
							$seller_user_id = $this->Seller->find('first',array('conditions'=>array('Seller.id'=>$email_info['Seller']['id']),'fields'=>array('Seller.user_id')));
						if(!empty($seller_user_id['Seller']['user_id']))
							$seller_user_id_val = $seller_user_id['Seller']['user_id'];
						else
							$seller_user_id_val = '';
						$data = str_replace('[SID]', $seller_user_id_val,$data);
						$data = str_replace('[SortCode]', $sortCode, $data);
						$data = str_replace('[BankAccountNumber]', $accNumber, $data);
						$data = str_replace('[AccountHoldersName]', $name, $data);
						$data = str_replace('[PaypalEmailAddress]', $paypal, $data);
						$subject = $template['EmailTemplate']['subject'];
						$subject = str_replace('[SellersID]', $seller_user_id_val, $subject);
						$this->Email->subject = $subject;
						$this->set('data',$data);
						/******import emailTemplate Model and get template****/
						$this->Email->template='commanEmailTemplate';
						$this->set('data',$data);
						$this->Email->to = Configure::read('fromEmail');
						if($this->Email->send()) {
							$this->Session->setFlash('Your details have been submitted please follow the instructions below to verify your payment account.');
						} else{
							$this->Session->SetFlash("We are unable to send you an email to confirm your payment settings, please change your email address in your account settings", 'default', array('class'=>'flashError') );						}
						$this->redirect('/sellers/deposit/');
					} else{
						$this->Session->setFlash('An error occurred while saving your data. Please try again or contact Customer Support at '.Configure::read('phone'),'default',array('class'=>'flashError'));
					}
				} else{
					foreach($this->data['Seller'] as $field_index => $user_info){
						$this->data['Seller'][$field_index] = html_entity_decode($user_info);
						$this->data['Seller'][$field_index] = str_replace('&#039;',"'",$this->data['Seller'][$field_index]);
					}
					$errorArray = $this->Seller->validationErrors;
					$this->set('errors',$errorArray);
				}
			} else{
			}
		} else{
			$this->Session->setFlash('You are not a seller, please update your account as seller.');
			$this->redirect('/homes/');
		}
	}


	/** 
	@function: admin_view_seller_payment_listing
	@description: to display payments of every seller
	@Created by: Tripti Poddar
	@params: NULL
	@Modify: Jan 11,2011
	@Created Date: Jan 18,2011
	*/
	function admin_view_seller_payment_listing() {
		$this->layout='layout_admin';
		$this->set('title_for_layout','Manage Sellers Payment Information');
		$criteria = 1;
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
		/** **************************************** **/
		$value = '';	
		$show = '';
		$matchshow = '';
		$fieldname = '';
		/** SEARCHING **/
		$reqData = $this->data;
		$options['All'] = 'All';
		$options['User.firstname'] = "Firstname";
		$options['User.lastname'] = "Lastname";
		$options['User.email'] = "Email";
		$options['Seller.paypal_account_mail'] = "Paypal email";
		$this->set('options',$options);
		if(!empty($this->data['Search'])){
			if(!empty($this->data['Search']['searchin'])){
				$fieldname = $this->data['Search']['searchin'];
			} else{
				$fieldname = 'All';
			}

			$value =  trim($this->data['Search']['keyword']);
			App::import('Sanitize');
			$value1 = Sanitize::escape($value);
			if($value !="") {
				if(trim($fieldname)=='All'){
					$criteria .= " and (User.firstname LIKE '%".$value1."%' OR User.lastname LIKE '%".$value1."%' OR User.email LIKE '%".$value1."%')";
				} else {
					if(trim($fieldname)!=''){
						if(isset($value) && $value!=="") {
							$criteria .= " and ".$fieldname." LIKE '%".$value1."%'";
						}
					}
				}
			}
			
		}
		$this->set('keyword', $value);
		$this->set('fieldname',$fieldname);
		$this->set('heading','Manage Payment Information of Sellers');
		/* ******************* page limit sction **************** */
		$sess_limit_name = $this->params['controller']."paymentinfos_limit";
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
			'conditions'=>array('Seller.status != "0"'),
			'order' => array(
				'User.firstname' => 'ASC'
			),
			'fields' => array(
				'User.id',
				'User.title',
				'User.firstname',
				'User.lastname',
				'User.email',
				'Seller.bank_account_number',
				'Seller.account_holder_name',
				'Seller.paypal_account_mail',
				'Seller.deposit_1',
				'Seller.deposit_2',
				'Seller.status',
				'Seller.id',
				'Seller.attempt_number',
			)
		);
		$this->Seller->expects(array('User'));
		$this->set('volumeArr',$this->paginate('Seller',$criteria));
	}

	
	/** 
	@function: deposit
	@description: to enter deposit amount by seller
	@Created by: Tripti Poddar
	@params	
	@Modify: NULL
	@Created Date: Jan 06, 2011
	*/
	function deposit(){
		if($this->RequestHandler->isAjax()==0)
 			$this->layout = 'marketplace_fullscreen';
 		else
			$this->layout = 'ajax';
		$this->set('title_for_layout','Choiceful.com Marketplace: My Marketplace - Payment Settings');
		$this->checkSessionFrontUser();
		$seller_id = $this->Session->read('User.seller_id');
		$user_email = $this->Session->read('User.email');
		$user_firstname = $this->Session->read('User.firstname');
		$user_lastname = $this->Session->read('User.lastname');
		//check the number of attempts for entering deposits
		$seller_info = $this->Seller->find('first',array('conditions'=>array('Seller.id'=>$seller_id),'fields'=>array('Seller.attempt_number','Seller.status')));
		if($seller_info['Seller']['status']==0){
			$this->redirect('/sellers/payment_settings/');
		} else if($seller_info['Seller']['status']==2){
			//
		} else if($seller_info['Seller']['status'] == 3){
			$this->redirect('/sellers/payment_summary/');
		}
		if(!empty($seller_id)){
			if(!empty($this->data)){
				
				$this->data = $this->cleardata($this->data);
				//$this->data = Sanitize::clean($this->data, array('encode' => false));
				
				$this->Seller->set($this->data);
				if($this->Seller->validates()){
					$this->data['Seller']['id'] = $seller_id;
					$this->data['Seller']['status'] = 2; // set flag=2 when adding deposit value
					$this->data['Seller'] = Sanitize::clean($this->data['Seller']);
					$this->Seller->set($this->data);
					$this->Seller->save($this->data);
				
					$this->Session->setFlash('Your details have been submitted please follow the instructions below to verify your payment account');
					$this->redirect('/sellers/deposit/');
				}else{
					
					foreach($this->data['Seller'] as $field_index => $user_info){
						$this->data['Seller'][$field_index] = html_entity_decode($user_info);
						$this->data['Seller'][$field_index] = str_replace('&#039;',"'",$this->data['Seller'][$field_index]);
					}
					$errorArray = $this->Seller->validationErrors;
					$this->set('errors',$errorArray);
				}
			} else{
			}
		} else{
			$this->Session->setFlash('You are not a seller, please update your account as seller.');
			$this->redirect('/homes/');
		}
	}

	/** 
	@function: admin_verify_seller
	@description: to verify the seller's account by admin
	@Created by: Tripti Poddar
	@params	
	@Modify: NULL
	@Created Date: Jan 10, 2011
	*/
	function admin_verify_seller($seller_id = null,$status_value = null,$verify = null){
		$this->layout='admin_popup';
		if(!empty($seller_id)){
			$this->Seller->expects(array('User'));
			$seller_info = $this->Seller->find('first',array('conditions'=>array('Seller.id'=>$seller_id),'fields'=>array('User.firstname', 'User.lastname', 'User.email', 'Seller.id','Seller.deposit_1','Seller.deposit_2','Seller.attempt_number')));
			$this->data = $seller_info;
		}
		if(!empty($this->data) && $verify=='yes'){ 
			$this->data['Seller']['id'] = $seller_id;
			$this->data['Seller']['status'] = $status_value;
			$this->data['Seller'] = Sanitize::clean($this->data['Seller']);
			$this->Seller->set($this->data);
			$this->Seller->save($this->data);
			$this->Session->setFlash('The seller has been verified successfully.');			
			echo "<script type=\"text/javascript\">setTimeout('parent.location.reload(true)',1000);</script>";
		} else if(!empty($this->data) && $verify=='no'){
			$this->data['Seller']['status'] = $status_value;
			// if verification fails, increase attempt number
			$this->data['Seller']['attempt_number'] = $this->data['Seller']['attempt_number']+1;
			// clear previous bank details
			$this->data['Seller']['bank_sort_code'] = '';
			$this->data['Seller']['bank_account_number'] = '';
			$this->data['Seller']['account_holder_name'] = '';
			$this->data['Seller']['paypal_account_mail'] = '';
			$this->data['Seller']['deposit_1'] = '0.00';
			$this->data['Seller']['deposit_2'] = '0.00';
			$this->data['Seller']['id'] = $seller_id;
			$this->data['Seller']['validation'] = 0;
			$this->data['Seller'] = Sanitize::clean($this->data['Seller']);
			$this->Seller->set($this->data);
			if($this->Seller->save($this->data)){
				/** Send email after failed verification **/
				$this->Email->smtpOptions = array(
					'host' => Configure::read('host'),
					'username' =>Configure::read('username'),
					'password' => Configure::read('password'),
					'timeout' => Configure::read('timeout')
				);
				$this->Email->from = Configure::read('fromEmail');
				$this->Email->replyTo=Configure::read('replytoEmail');
				$this->Email->sendAs= 'html';
				$link=Configure::read('siteUrl');
				/******import emailTemplate Model and get template****/
				App::import('Model','EmailTemplate');
				$this->EmailTemplate = new EmailTemplate;
				/**
				table: 		email_templates
				id:		25
				description:	Choiceful Marketplace - Payments
				*/
				$template = $this->EmailTemplate ->find('first',array('conditions'=>array("EmailTemplate.id"=>25),'fields' =>array( 'EmailTemplate.description','EmailTemplate.subject')));
				$data=$template['EmailTemplate']['description'];
				$data = str_replace('[SellersDisplayName]', ucfirst($seller_info['User']['firstname']).' '.ucfirst($seller_info['User']['lastname']) ,$data);
				$this->Email->subject = $template['EmailTemplate']['subject'];
				$this->set('data',$data);
				$this->Email->to = $this->data['User']['email'];
				/******import emailTemplate Model and get template****/
				$this->Email->template='commanEmailTemplate';

				if($this->Email->send()) {
					$this->Session->setFlash('The seller\'s verification has been failed, and mail has sent successfully to seller.');
				} else{
					$this->Session->setFlash('We are unable to send you an email, please change your email address in your account settings.','default',array('class'=>'flashError'));
				}
			}
			echo "<script type=\"text/javascript\">setTimeout('parent.jQuery.fancybox.close()',1000);</script>";
		}
		
	}

	/** 
	@function: admin_send_seller_deposit_mail
	@description: to send a mail to seller when admin has deposit amount in seller's account
	@Created by: Tripti Poddar
	@params	
	@Modify: Jan 11, 2011
	@Created Date: Jan 18, 2011
	*/
	function admin_send_seller_deposit_mail($seller_id = null){
		$this->layout='admin_popup';
		if(!empty($this->data)){ 
			// get user value for mail
			$this->Seller->expects(array('User'));
			$email_info = $this->Seller->find('first',array('conditions'=>array('Seller.id'=>$this->data['SellerPayment']['seller_id']),'fields'=>array('User.email','User.firstname', 'User.lastname','Seller.id','Seller.bank_account_number','Seller.status')));
			App::import('Model','SellerPayment');
			$this->SellerPayment = new SellerPayment;
			// save amount in database
			$this->data['SellerPayment']['amount'] = $this->data['SellerPayment']['amount'];
			$this->data['SellerPayment']['bank_account_number'] = $email_info['Seller']['bank_account_number'];
			$this->data['SellerPayment'] = Sanitize::clean($this->data['SellerPayment']);
			$this->SellerPayment->set($this->data);
			if($this->SellerPayment->save($this->data)){ // send mail only if amount is saved
				/** Send Mail **/
				$this->Email->smtpOptions = array(
					'host' => Configure::read('host'),
					'username' =>Configure::read('username'),
					'password' => Configure::read('password'),
					'timeout' => Configure::read('timeout')
				);
				$this->Email->from = Configure::read('fromEmail');
				$this->Email->replyTo=Configure::read('replytoEmail');
				$this->Email->sendAs= 'html';
				App::import('Model','EmailTemplate');
				$this->EmailTemplate = new EmailTemplate;
				$link=Configure::read('siteUrl');
				/******import emailTemplate Model and get template****/
			
				/**
				table: 		email_templates
				id:		
				description:	Customer registration
				*/
				$template = $this->EmailTemplate ->find('first',array('conditions'=>array("EmailTemplate .id"=>18),'fields' =>array( 'EmailTemplate.description','EmailTemplate.subject')));
	
				$data=$template['EmailTemplate']['description'];
				$data = str_replace('[SellersDisplayName]', ucfirst($email_info['User']['firstname']).' '.ucfirst($email_info['User']['lastname']) ,$data);
	
				$this->Email->subject = $template['EmailTemplate']['subject'];
				$this->set('data',$data);
				$this->Email->to = $email_info['User']['email'];
				/******import emailTemplate Model and get template****/
				$this->Email->template='commanEmailTemplate';
				
				if($this->Email->send()) {
					$this->data['Seller']['id'] = $this->data['SellerPayment']['seller_id'];
					if($email_info['Seller']['status'] != 3){
						$this->data['Seller']['status'] = 2;
					}
					$this->data['Seller'] = Sanitize::clean($this->data['Seller']);
					$this->Seller->set($this->data);
					$this->Seller->save($this->data);
					
					echo "<script type=\"text/javascript\">parent.$.fancybox.close();</script>";
					$this->Session->setFlash('Deposit mail has been sent to seller successfully.');
					
				} else{
					$this->Session->setFlash('We are unable to send you an email, please change your email address in your account settings.','default',array('class'=>'flashError'));
				}
			} else{
				$this->Session->setFlash('An error occurred while saving the amount.','default',array('class'=>'flashError'));
			}
		} else{
			$this->data['SellerPayment']['seller_id'] = $seller_id;
		}
	}

	/** 
	@function: payment_summary
	@description: to enter payment information for a sellers account
	@Created by: Tripti Poddar
	@params	
	@Modify: Jan 11, 2011
	@Created Date: Jan 10, 2011
	*/
	function payment_summary(){
		if($this->RequestHandler->isAjax()==0)
 			$this->layout = 'marketplace_fullscreen';
 		else
			$this->layout = 'ajax';
		
		$this->set('title_for_layout','Choiceful.com Marketplace: My Marketplace - Payment Settings');
		$this->checkSessionFrontUser();
		$seller_id = $this->Session->read('User.id');
		//check the status of seller
		$seller_info = $this->Seller->find('first',array('conditions'=>array('Seller.user_id'=>$seller_id),'fields'=>array('Seller.status', 'Seller.user_id')));
		// get user details to show first name last name
		$userData = $this->Common->getUserMailInfo($seller_id);
		$this->set('userData',$userData);
		if($seller_info['Seller']['status']==3){
			//
		}else if($seller_info['Seller']['status'] == 2){
			$this->redirect('/sellers/deposit/');
		}else if($seller_info['Seller']['status'] == 1 || $seller_info['Seller']['status'] == 0){
			$this->redirect('/sellers/payment_settings/');
		}
// 		if(!empty($seller_id)){
// 			App::import('Model','SellerPayment');
// 			$this->SellerPayment = new SellerPayment;
// 			$seller_payment_info = $this->SellerPayment->find('all',array('conditions'=>array('SellerPayment.seller_id'=>$seller_id),'fields'=>array('SellerPayment.amount', 'SellerPayment.created', 'SellerPayment.bank_account_number')));	
// 			$this->set('seller_payment_info',$seller_payment_info);
// 
// 			$seller_info = $this->Seller->find('first',array('conditions'=>array('Seller.id'=>$seller_id),'fields'=>array('Seller.id','Seller.bank_account_number','Seller.account_holder_name' ,'Seller.paypal_account_mail')));	
// 			$this->data = $seller_info;
// 		} else{
// 			$this->Session->setFlash('You are not a seller, please update your account as seller.','default',array('class'=>'flashError'));
// 			$this->redirect('/homes/');
// 		}


		if(!empty($seller_id)){
			App::import('Model','PaymentReport');
			$this->PaymentReport = new PaymentReport;
			$seller_payment_info = $this->PaymentReport->find('all',array('conditions'=>array('PaymentReport.seller_id'=>$seller_id),'fields'=>array('PaymentReport.created', 'PaymentReport.report_name', 'PaymentReport.account_info')));
			$this->set('seller_payment_info',$seller_payment_info);

			$seller_info = $this->Seller->find('first',array('conditions'=>array('Seller.user_id'=>$seller_id),'fields'=>array('Seller.id','Seller.bank_account_number','Seller.account_holder_name' ,'Seller.paypal_account_mail')));
			$this->data = $seller_info;
		} else{
			$this->Session->setFlash('You are not a seller, please update your account as seller.','default',array('class'=>'flashError'));
			$this->redirect('/homes/');
		}
	}

	/** 
	@function: summary
	@description: to view seller summary 
	@Created by: Ramanpreet Pal Kaur
	@params	
	@Created Date: Jan 24, 2011
	*/
	function summary($seller_id = null,$product_id = 0,$condition_id = null){
		$this->layout = 'seller_summary';
		if(empty($seller_id)) {
			$this->redirect('/');
		}
		//$this->set('title_for_layout','Please define this using the search term as: Choiceful.com: Marketplace Summary for "Seller Business Display Name"');
		$seller_info = $this->Seller->find('first',array('conditions'=>array('Seller.user_id'=>$seller_id),'fields'=>array('Seller.business_display_name','Seller.image')));
		$sell_biz_name = $seller_info['Seller']['business_display_name'];
		$this->set('title_for_layout','Choiceful.com: Marketplace Summary for "'.$sell_biz_name.'"');
		$this->set('seller_info',$seller_info);
		$this->set('seller_id',$seller_id);
		$this->set('product_id',$product_id);
		$this->set('condition_id',$condition_id);
		$positive_percentage  = $this->Common->positivePercentFeedback($seller_id/*,$product_id*/);
		$this->set('positive_percentage',$positive_percentage);
		App::import('Model','Feedback');
		$this->Feedback = new Feedback;
		$avg_seller_rating = $this->Common->avgSellerRating($seller_id/*,$product_id*/);
		$this->set('avg_rating',$avg_seller_rating['value']);
		$this->set('avg_half_star',$avg_seller_rating['avg_half_star']);
		$this->set('avg_full_star',$avg_seller_rating['avg_full_star']);
		$this->set('count_rating',$avg_seller_rating['count_total_rating']);
		$con_str = '';
		$con_str = 'Feedback.seller_id = '.$seller_id;
		for($i=5; $i>=1; $i--){
			$total_rating[$i] = $this->Feedback->find('count',array('conditions'=>array($con_str,'Feedback.rating'=>$i)));
		}
		$this->set('total_rating',$total_rating);
		$pro_sell = $this->product_seller_info($seller_id,$product_id,$condition_id);
		$this->set('pro_seller_info',$pro_sell['pro_seller_info']);
		$this->set('pro_info',$pro_sell['pro_info']);
		$this->Feedback->expects(array('User'));
		$creteria = array('Feedback.seller_id'=>$seller_id);
		$recent_feedbacks = $this->Feedback->find('all',array('conditions'=>$creteria,'order'=>('Feedback.created DESC'),'limit'=>6,'fields'=>array('Feedback.id','Feedback.feedback','Feedback.product_id','Feedback.rating','Feedback.user_id','Feedback.seller_id','Feedback.order_id','Feedback.order_item_id','Feedback.created','User.id','User.title','User.firstname','User.lastname')));
		App::import('Model','Page');
		$this->Page = new Page;
		$buy_gurantee = $this->Page->find('first',array('conditions'=>array('Page.pagecode'=>'buy-with-confidence-guarantee'),'fields'=>array('Page.description')));
		if(!empty($buy_gurantee)){
			$buy_gurantee_desc = $buy_gurantee['Page']['description'];
		}
		$this->set('buy_gurantee_desc',$buy_gurantee_desc);
		$refund_des = $this->Page->find('first',array('conditions'=>array('Page.pagecode'=>'returns-policy'),'fields'=>array('Page.description')));
		if(!empty($refund_des)){
			$refundreturn_des = $refund_des['Page']['description'];
		}
		$this->set('refundreturn_des',$refundreturn_des);
		$this->set('recent_feedbacks',$recent_feedbacks);
	}
	
	
	/** 
	@function: product_seller_info
	@description: to get sellers information for a particular product
	@Created by: Ramanpreet Pal Kaur
	@params	
	@Created Date: Jan 24, 2011
	*/
	function product_seller_info($seller_id = null,$product_id = null,$condition_id = 1){
		if(empty($seller_id)){
			$this->redirect('/');
		}
		App::import('Model','Product');
		$this->Product = new Product;
		$pro_info = $this->Product->find('first',array('conditions'=>array('Product.id'=>$product_id),'fields'=>array('Product.id','Product.product_image','Product.product_name')));
		App::import('Model','ProductSeller');
		$this->ProductSeller = new ProductSeller;
		$this->ProductSeller->expects(array('UserSummary'));
		$this->ProductSeller->UserSummary->expects(array('SellerSummary'));
		$condition_array = $this->Common->get_new_used_conditions();
		$this->set('condition_array',$condition_array);
		$this->ProductSeller->recursive =2;
		$conditions_array = array();
		if(!empty($product_id)){
			$conditions_array = array('ProductSeller.seller_id'=>$seller_id,'ProductSeller.product_id'=>$product_id);
		} else{
			$conditions_array = array('ProductSeller.seller_id'=>$seller_id);
		}
		$pro_seller_info = $this->ProductSeller->find('first',array('conditions'=>$conditions_array,'fields'=>array('ProductSeller.price','ProductSeller.seller_id','ProductSeller.condition_id','ProductSeller.notes','ProductSeller.quantity','ProductSeller.standard_delivery','ProductSeller.standard_delivery_price','ProductSeller.express_delivery','ProductSeller.express_delivery_price')));
		$pro_sell['pro_seller_info'] = $pro_seller_info;
		$pro_sell['pro_info'] = $pro_info;
		return $pro_sell;
	}

	/** 
	@function: feedback
	@description: to view feedback of products
	@Created by: Ramanpreet Pal Kaur
	@Modified by: Ramanpreet Pal Kaur
	@params	
	@Created Date: Jan 24, 2011
	@Modified Date: Feb 9,2011
	*/
	function feedback($seller_id = null,$product_id = 0,$condition_id=1){
		if(empty($seller_id)){
			$this->redirect('/');
		}
		//$this->set('title_for_layout','Please define this using the search term as: Choiceful.com: Marketplace Feedback for "Seller Business Display Name"');
		
		$seller_info = $this->Seller->find('first',array('conditions'=>array('Seller.user_id'=>$seller_id),'fields'=>array('Seller.business_display_name','Seller.image')));
		$sell_biz_name = $seller_info['Seller']['business_display_name'];
		$this->set('title_for_layout','Choiceful.com: Marketplace Feedback for "'.$sell_biz_name.'"');
		$this->set('seller_info',$seller_info);
		$this->set('seller_id',$seller_id);
		$this->set('product_id',$product_id);
		$this->set('condition_id',$condition_id);
		if($this->RequestHandler->isAjax()==1) {
			$this->layout = 'ajax';
		} else{
			$this->layout = 'seller_summary';
		}
		$positive_percentage  = $this->Common->positivePercentFeedback($seller_id/*,$product_id*/);
		$this->set('positive_percentage',$positive_percentage);
		$avg_seller_rating = $this->Common->avgSellerRating($seller_id/*,$product_id*/);
		$this->set('avg_rating',$avg_seller_rating['value']);
		$this->set('avg_half_star',$avg_seller_rating['avg_half_star']);
		$this->set('avg_full_star',$avg_seller_rating['avg_full_star']);
		$pro_sell = $this->product_seller_info($seller_id,$product_id,$condition_id);
		$this->set('pro_seller_info',$pro_sell['pro_seller_info']);
		$this->set('pro_info',$pro_sell['pro_info']);
		App::import('Model','Feedback');
		$this->Feedback = new Feedback;
		$this->Feedback->expects(array('User'));
		$conditions =array();
		$conditions = array('Feedback.seller_id'=>$seller_id);
		$this->paginate = array(
			'limit' => 20,
			'order' => array(
				'Feedback.created'=>' DESC'
			),
			'conditions'=>$conditions,
			'fields' => array(
				'Feedback.id',
				'Feedback.feedback',
				'Feedback.product_id',
				'Feedback.rating',
				'Feedback.user_id',
				'Feedback.seller_id',
				'Feedback.order_id',
				'Feedback.order_item_id',
				'Feedback.created',
				'User.id',
				'User.title',
				'User.firstname',
				'User.lastname'
			)
		);
		$feedbacks = $this->paginate('Feedback');
		$this->set('feedbacks',$feedbacks);
	}


	/** 
	@function: returns
	@description: to view feedback of products
	@Created by: Ramanpreet Pal Kaur
	@params	
	@Created Date: Jan 24, 2011
	*/
	function returns($seller_id = null,$product_id = 0,$condition_id=1){
		if(empty($seller_id)){
			$this->redirect('/');
		}
		//$this->set('title_for_layout','Please define this using the search term as: Choiceful.com: Marketplace Returns and Refund Policy for "Seller Business Display Name"');
		$seller_info = $this->Seller->find('first',array('conditions'=>array('Seller.user_id'=>$seller_id),'fields'=>array('Seller.business_display_name','Seller.image')));
		$sell_biz_name = $seller_info['Seller']['business_display_name'];
		$this->set('title_for_layout','Choiceful.com: Marketplace Returns and Refund Policy for "'.$sell_biz_name.'"');
		$this->set('seller_info',$seller_info);
		$this->set('seller_id',$seller_id);
		$this->set('product_id',$product_id);
		$this->set('condition_id',$condition_id);
		$this->layout = 'seller_summary';
		App::import('Model','Page');
		$this->Page = new Page;
		$refundreturn_des ='';
		$refund_des = $this->Page->find('first',array('conditions'=>array('Page.pagecode'=>'returns-policy'),'fields'=>array('Page.description')));

		if(!empty($refund_des)){
			$refundreturn_des = $refund_des['Page']['description'];
		}

		$this->set('refundreturn_des',$refundreturn_des);
		$pro_sell = $this->product_seller_info($seller_id,$product_id,$condition_id);
		$this->set('pro_seller_info',$pro_sell['pro_seller_info']);
		$this->set('pro_info',$pro_sell['pro_info']);
	}

	/** 
	@function: admin_edit_account_detail
	@description: to update seller's bank account details
	@Created by: Tripti Poddar
	@params	
	@Created Date: Feb 2, 2011
	@Modified Date: Feb 2, 2011
	*/
	function admin_edit_account_detail($id = null, $action = null) {
		if(!is_null($id) ){
			$id = base64_decode($id);
		}

		$this->checkSessionAdmin();
		$this->set('id',$id);
		$logged_in_user_id = $this->Session->read('SESSION_ADMIN.id');

		$this->layout = 'layout_admin';

		$seller_info = $this->Seller->find('first',array( 'conditions'=>array('Seller.id'=>$id), 'fields'=>array('Seller.bank_account_number','Seller.paypal_account_mail')));
		
		if(!empty($this->data)){
			$this->data['Seller']['id'] = $id;
			if($this->data['Seller']['bank_account_no'] != ''){
				$this->data['Seller']['bank_account_number'] = '******'.substr($this->data['Seller']['bank_account_no'],-4);
			}else{
				$this->data['Seller']['bank_account_number'] = '';
			}
			if($this->data['Seller']['paypal_email'] != ''){
				$paypal_email = split("@", $this->data['Seller']['paypal_email']);
				if(is_array($paypal_email) && count($paypal_email)>0){
					$length = strlen($paypal_email[0]);
					$f = substr($paypal_email[0],0,1);
					$e = substr($paypal_email[0],-1);
					$hidden_email = $f;
					for($l=0; $l<$length-2; $l++){
						$hidden_email .= 'x';
					}
					$hidden_email .= $e;
					$hidden_email .= '@'.$paypal_email[1];
				}
				$this->data['Seller']['paypal_account_mail'] = $hidden_email;
			} else{
				$this->data['Seller']['paypal_account_mail'] = '';
			}
			$this->data['Seller']['validation'] = 0;
					$this->data['Seller'] = Sanitize::clean($this->data['Seller']);
			$this->Seller->set($this->data);
			if($this->Seller->save($this->data)){
				$this->Session->setFlash('Back account updated successfully.');
			} else {
				$this->Session->setFlash('Back account could not be updated.','default',array('class'=>'flashError'));
			}
			$this->redirect('view_seller_payment_listing');
		} else {
			$this->data = $seller_info;
			$this->data['Seller']['bank_account_no'] = $this->data['Seller']['bank_account_number'];
			$this->data['Seller']['paypal_email'] = $this->data['Seller']['paypal_account_mail'];
			
			foreach($this->data['Seller'] as $field_index => $user_info){
				$this->data['Seller'][$field_index] = html_entity_decode($user_info);
				$this->data['Seller'][$field_index] = str_replace('&#039;',"'",$this->data['Seller'][$field_index]);
			}
		}
	}

	/** 
	@function: store
	@description: to display all products oam a given seller
	@Created by: Ramanpreet Pal Kaur
	@params: $seller_id
	@Modify:
	@Created Date: Feb 9, 2011
	*/
// 	function store($seller_id = null){
// 		ini_set('memory_limit', '9999M');
// 		$this->layout = 'search_product_user';
// 		$this->set('seller_id',$seller_id);
// 		$myRecentProducts = array();
// 		$seller_info = $this->Seller->find('first',array('conditions'=>array('Seller.user_id'=>$seller_id),'fields'=>array('Seller.business_display_name','Seller.image')));
// 
// 		$this->set('seller_info',$seller_info);
// 		##################  get  history products from cookies ################
// 		App::import('Model','ProductVisit');
// 		$this->ProductVisit = new ProductVisit;
// 		$myRecentProducts = $this->ProductVisit->getMyVisitedProducts();
// 
// 		$this->set('myRecentProducts',$myRecentProducts);
// 		#############################################
// 		$value = '';
// 		$sort = '';
// 		$zero_star = 0;
// 		$one_star = 0;
// 		$two_star = 0;
// 		$three_star = 0;
// 		$four_star = 0;
// 		$zero_to_five = 0;
// 		$department_id = '';
// 		$category_id = '';
// 		$five_to_ten = 0;
// 		$ten_twenty = 0;
// 		$twenty_fifty = 0;
// 		$fifty_hundred = 0;
// 		$hundred_2hundred = 0;
// 		$twohundred_5hundred = 0;
// 		$fivehundred_above = 0;
// 		$products = 0;
// 		$display_error_msg = 0;
// 		$rate = '';
// 		$from_price = '';
// 		$to_price = '';
// 		$checked_brandId = 0;
// 		$brand_str = '';
// 		$dept_count_arr = '';
// 		$cate = '';
// 		$dept_arr = '';
// 		$pro_cat_array = '';
// 		$count_dept = '';
// 		$count_cate = '';
// 		
// 		$this->data['Seller']['id'] = $seller_id;
// 		$this->data['Seller']['sort1'] = 'bestselling';
// 
// 		$conditions = $this->Common->get_new_used_conditions();
// 		$this->set('conditions',$conditions);
// 
// 		$creteria = 'ProductSeller.seller_id = '.$seller_id;
// 		if(!empty($this->data)){
// 			$seller_info = $this->Seller->find('first',array('conditions'=>array('Seller.user_id'=>$seller_id),'fields'=>array('Seller.free_delivery','Seller.threshold_order_value')));
// 			App::import('Model','ProductSeller');
// 			$this->ProductSeller = new ProductSeller();
// 			$this->ProductSeller->expects(array('Product','UserSummary'));
// 			$this->ProductSeller->UserSummary->expects(array('SellerSummary'));
// 			$str_flag = false;
// 			if(!empty($this->data['Seller']['brand'])){
// 				$this->data['selectbrand_id'] = explode(',',$this->data['Seller']['brand']);
// 			}
// 			if(!empty($this->data['Seller']['sort1'])){
// 				$sort = $this->data['Seller']['sort1'];
// 			}
// 			if(!empty($this->data['selectbrand_id'])){
// 				foreach($this->data['selectbrand_id'] as $brandId){
// 					if(!empty($brandId)){
// 						if(empty($brand_str))
// 							$brand_str = $brandId;
// 						else
// 							$brand_str .= ','.$brandId;
// 						
// 						$str_flag = true;
// 					}
// 				}
// 				if(!empty($str_flag)){
// 					$creteria .= ' AND Product.brand_id IN ('.$brand_str.')';
// 					$checked_brandId = $brand_str;
// 				}
// 			}
// 			if(!empty($this->data['Seller']['from_price']) && !empty($this->data['Seller']['to_price'])){
// 				$creteria .= ' AND ProductSeller.price Between '.$this->data['Seller']['from_price'].' and '.$this->data['Seller']['to_price'];
// 				$from_price = $this->data['Seller']['from_price'];
// 				$to_price=$this->data['Seller']['to_price'];
// 			} else if(!empty($this->data['Seller']['from_price']) && empty($this->data['Seller']['to_price'])){
// 				$creteria .= ' AND ProductSeller.price >= '.$this->data['Seller']['from_price'];
// 				$from_price = $this->data['Seller']['from_price'];
// 				$to_price=$this->data['Seller']['to_price'];
// 			} else if(empty($this->data['Seller']['from_price']) && !empty($this->data['Seller']['to_price'])){
// 				$creteria .= ' AND ProductSeller.price <= '.$this->data['Seller']['from_price'];
// 				$from_price = $this->data['Seller']['from_price'];
// 				$to_price=$this->data['Seller']['to_price'];
// 			}
// 			if(!empty($this->data['Seller']['id'])){
// 				$seller_id = $this->data['Seller']['id'];
// 			}
// 			
// 			if(!empty($this->data['Seller']['rate'])){
// 				$creteria .= ' AND Product.avg_rating >= '.$this->data['Seller']['rate'];
// 				$rate = $this->data['Seller']['rate'];
// 			}
// 
// 			if(!empty($sort)){
// 				$order = array('Product.'.$sort => 'ASC');
// 			} else{
// 				$order = array('Product.product_name' => 'ASC');
// 			}
// 			$fields = array(
// // 				'distinct(ProductCategory.product_id)',
// 				'ProductSeller.id',
// 				'ProductSeller.seller_id',
// 				'ProductSeller.product_id',
// 				'ProductSeller.price',
// 				'ProductSeller.quantity',
// 				'ProductSeller.express_delivery',
// 				'ProductSeller.condition_id',
// 				'Product.id',
// 				'Product.department_id','Product.brand_id',
// 				'Product.product_name',
// 				'Product.product_image',
// 				'Product.model_number',
// 				'Product.product_rrp',
// 				'Product.avg_rating',
// 			);
// 			$this->ProductSeller->recursive =2;
// // 			echo $creteria; die;
// 			$creteria = $creteria.' AND ProductSeller.listing_status = "1"';
// 			$all_products = $this->ProductSeller->find('all',array('conditions'=>$creteria,'fields'=>$fields));
// 			if(!empty($all_products)){
// 				$zero_to_five = $this->ProductSeller->find('count',array('conditions'=>array($creteria.' AND (ProductSeller.price >= 0 and ProductSeller.price <= 5)')));
// 				$five_to_ten = $this->ProductSeller->find('count',array('conditions'=>array($creteria.' AND (ProductSeller.price > 5 and ProductSeller.price <= 10 )')));
// 				$ten_twenty = $this->ProductSeller->find('count',array('conditions'=>array($creteria.' AND (ProductSeller.price > 10 and ProductSeller.price <= 20 )')));
// 				$twenty_fifty = $this->ProductSeller->find('count',array('conditions'=>array($creteria.' AND (ProductSeller.price > 20 and ProductSeller.price <= 50 )')));
// 				$fifty_hundred = $this->ProductSeller->find('count',array('conditions'=>array($creteria.' AND (ProductSeller.price > 50 and ProductSeller.price <= 100 )')));
// 				$hundred_2hundred = $this->ProductSeller->find('count',array('conditions'=>array($creteria.' AND (ProductSeller.price > 100 and ProductSeller.price <= 200)')));
// 				$twohundred_5hundred = $this->ProductSeller->find('count',array('conditions'=>array($creteria.' AND (ProductSeller.price > 200 and ProductSeller.price <= 500 )')));
// 				$fivehundred_above = $this->ProductSeller->find('count',array('conditions'=>array($creteria.' AND (ProductSeller.price > 500)')));
// 
// 				App::import('Model','ProductRating');
// 				$this->ProductRating = new ProductRating();
// 				App::import('Model','ProductRating');
// 				$this->ProductRating = new ProductRating();
// 				App::import('Model','Brand');
// 				$this->Brand = new Brand();
// 				$brands = $this->Brand->find('list',array('order'=>'Brand.name'));
// 				$this->set('brands',$brands);
// 				if(!empty($brands)) {
// 					foreach($brands as $brand_id=>$brand){
// 						$brand_pro[$brand_id] = $this->ProductSeller->find('count',array('conditions'=>array('Product.brand_id'=>$brand_id,$creteria)));
// 					}
// 				}
// 				$this->set('brand_pro',$brand_pro);
// 				$zero_star = $this->ProductSeller->find('count',array('conditions'=>array($creteria.' AND (Product.avg_rating = 0 )')));
// 				$one_star = $this->ProductSeller->find('count',array('conditions'=>array($creteria.' AND (Product.avg_rating >= 1 AND Product.avg_rating < 2 )')));
// 				$two_star = $this->ProductSeller->find('count',array('conditions'=>array($creteria.' AND (Product.avg_rating >= 2 AND Product.avg_rating < 3 )')));
// 				$three_star = $this->ProductSeller->find('count',array('conditions'=>array($creteria.' AND (Product.avg_rating >= 3 AND Product.avg_rating < 4 )')));
// 				$four_star = $this->ProductSeller->find('count',array('conditions'=>array($creteria.' AND (Product.avg_rating >= 4)')));
// 				$display_error_msg = 1;
// 			}
// 		}
// 		$free_delivery_over = 0;
// 		if(!empty($seller_info)){
// 			if(!empty($seller_info['Seller']['free_delivery'])){
// 				$free_delivery_over = $seller_info['Seller']['threshold_order_value'];
// 			}
// 		}
// 		$this->set('keyword',$value);
// 		$this->set('modelis','Product');
// 		$this->set('free_delivery_over',$free_delivery_over);
// 		$this->set('display_error_msg',$display_error_msg);
// 		$this->set('department_id',$department_id);
// 		$this->set('category_id',$category_id);
// 		$this->set('zero_rate',$zero_star);
// 		$this->set('one_rate',$one_star);
// 		$this->set('two_rate',$two_star);
// 		$this->set('three_rate',$three_star);
// 		$this->set('four_rate',$four_star);
// 		$this->set('zero_to_five',$zero_to_five);
// 		$this->set('five_to_ten',$five_to_ten);
// 		$this->set('ten_twenty',$ten_twenty);
// 		$this->set('twenty_fifty',$twenty_fifty);
// 		$this->set('fifty_hundred',$fifty_hundred);
// 		$this->set('hundred_2hundred',$hundred_2hundred);
// 		$this->set('twohundred_5hundred',$twohundred_5hundred);
// 		$this->set('fivehundred_above',$fivehundred_above);
// 		$this->set('products',$all_products);
// 		$this->set('sort',$sort);
// 		$this->set('from_price',$from_price);
// 		$this->set('to_price',$to_price);
// 		$this->set('brand_str',$brand_str);
// 		$this->set('checked_brandId',$checked_brandId);
// 		$this->set('rate',$rate);
// 		$this->set('dept_count_arr',$dept_count_arr);
// 		$this->set('pro_cat_array',$pro_cat_array);
// 		$this->set('count_dept',$count_dept);
// 		$this->set('cate',$cate);
// 	}


	/** 
	@function: orders
	@description: 
	@Created by: Ramanpreet Pal
	@Created:  15 Feb 2011
	@Modify:  
	*/
	function orders($filter = 'ALL'){
		$this->layout = 'marketplace_fullscreen';
		
		$this->set('title_for_layout','Choiceful.com Marketplace: My Marketplace - View Orders');
		/*
		 Commented by nakul because dropdown paging limit is not working..
		 $paging_records = $this->Session->read('ordersellerlistingLimit');
		if(!empty($paging_records) && !empty($this->data['Paging']['options'])){
			$this->data['Paging']['options'] = $paging_records;
		}*/
		if(!empty($this->data)){
			if(!empty($this->data['Paging'])){
				if(!empty($this->data['Paging']['options'])){
					$limit_is = $this->data['Paging']['options'];
					$this->Session->write('ordersellerlistingLimit',$limit_is);
				}
			}
			if(!empty($this->data['Listing1']['options']) || !empty($this->data['Listing2']['options']) || !empty($this->data['Page']['filter'])){
				if(!empty($this->data['Listing1']['options'])){
					$filter = $this->data['Listing1']['options'];
				}
				if(!empty($this->data['Listing2']['options'])){
					$filter = $this->data['Listing2']['options'];
				}
				if(!empty($this->data['Page']['filter'])){
					$filter = $this->data['Page']['filter'];
				}
			}
		}
		$this->set('modelis','OrderSeller');
		$orders = $this->get_sellerOrders($filter);
		if(!empty($filter)){
			$this->data['Listing2']['options'] = $filter;
			$this->data['Listing1']['options'] = $filter;
			$this->data['Page']['filter'] = $filter;
		}
		$this->set('filter',$filter);
		$this->set('orders',$orders);
	}


	
	/**
	@function: get_sellerOrders
	@description: returns all orders for a logged in seller
	@Created by: Ramanpreet Pal
	@Modify:  15 Feb, 2011
	*/
	function get_sellerOrders($filter = 'ALL') {
		$seller_user_id =$this->Session->read('User.id');
		$creteria = "OrderSeller.seller_id = ".$seller_user_id;
		if(!empty($this->data['Listing1']['options']) || !empty($this->data['Listing2']['options'])){
			if(!empty($this->data['Listing1']['options'])){
				$filter = $this->data['Listing1']['options'];
			}
			if(!empty($this->data['Listing2']['options'])){
				$filter = $this->data['Listing2']['options'];
			}
		} else{
			if($this->RequestHandler->isAjax()==1){
				$filter = 'ALL';
			}
		}
		if(!empty($filter)){
			$this->data['Listing2']['options'] = $filter;
			$this->data['Listing1']['options'] = $filter;
			$this->data['Page']['filter'] = $filter;
		}
		if(in_array($filter,array('1d','3d','7d','15d','30d'))){
			$filtertime = str_replace('d','',$filter);
			$current_date_time = date('Y-m-d H:i:s');
			$from_day = date('d')-$filtertime;
			$from_date_time = date('Y').'-'.date('m').'-'.$from_day.' '.date('H:i:s');
			$creteria = $creteria.' AND OrderSeller.created Between "'.$from_date_time.'" AND "'.$current_date_time.'"';
		} else if(in_array($filter,array('3m','6m','12m'))){
			$filtertime = str_replace('m','',$filter);
			$current_date_time = date('Y-m-d H:i:s');
			$from_month = date('m')-$filtertime;
			$from_date_time = date('Y').'-'.$from_month.'-'.date('d').' '.date('H:i:s');
			$creteria = $creteria.' AND OrderSeller.created Between "'.$from_date_time.'" AND "'.$current_date_time.'"';
		} else{
			
		}
		$limit_is = 0;
		$limit_is = $this->Session->read('ordersellerlistingLimit');
		$filter_time = $this->Common->get_filterTime();
		$this->set('filter_time',$filter_time);

		App::import('Model','OrderSeller');
		$this->OrderSeller = new OrderSeller();

		if(empty($sortby)){
			$sortby = 'Order.created DESC';
		}
		/*if(empty($limit_is))
			$limit_is = 250;*/
		
		/* ******************* page limit sction **************** */
		$sess_limit_name = $this->params['controller']."_limit";
		
		$sess_limit_value = $this->Session->read($sess_limit_name);
		if(!empty($this->data['Paging']['options'])){
		   $limit = $this->data['Paging']['options'];
		   $this->Session->write($sess_limit_name , $this->data['Paging']['options'] );
		   
		}elseif( !empty($sess_limit_value) ){
			$limit = $sess_limit_value;
		}else{
			$limit = $this->records_per_page;  // set default value
		}
		$this->data['Paging']['options'] = $limit;
		/* ******************* page limit sction **************** */
		
		$this->paginate = array(
			'limit' => $limit,
			'conditions'=>array('Order.deleted'=>'0','Order.payment_status'=>'Y'),
			'order' => 'Order.created DESC',
			'fields' => array(
				'OrderSeller.id',
				'OrderSeller.order_id',
				'OrderSeller.seller_id',
				'OrderSeller.dispatch_date',
				'OrderSeller.shipping_carrier',
				'OrderSeller.shipping_status',
				'OrderSeller.shipping_service',
				'OrderSeller.created',
				'OrderSeller.modified',
				'Order.created',
				'Order.user_id',
				'Order.order_number',
			)
		);
		$this->OrderSeller->expects(array('Order'));
		$this->OrderSeller->Order->expects(array('UserSummary'));
		$this->OrderSeller->recursive = 2;
		$orders = $this->paginate('OrderSeller',$creteria);
		App::import('Model','OrderItem');
		$this->OrderItem = new OrderItem();
		if(!empty($orders)){
			foreach($orders as $index=>$order){
				$items = $this->OrderItem->find('all',array('conditions'=>array('OrderItem.order_id'=>$order['OrderSeller']['order_id'],'OrderItem.seller_id'=>$seller_user_id)));
				if(!empty($items)){
					$orders[$index]['Items'] = $items;
				}
				
			}
		}
		if($this->RequestHandler->isAjax()==1){
			$this->data['Page']['filter'] = $filter;
			$this->set('filter',$filter);
			$this->set('modelis','OrderSeller');
			$this->layout = 'ajax';
			$filter_time = $this->Common->get_filterTime();
			$this->set('filter_time',$filter_time);
			$this->set('orders',$orders);
			$this->viewPath = 'elements/seller' ;
			$this->render('orders_listing');
		}
		return $orders;
	}

	/**
	@function: gotoPage
	@description: 
	@Created by: Ramanpreet Pal
	@Modify:  22 Dec 2010
	*/
	function gotoPage(){
		if($this->data['Page']['action'] != ''){
			$goaction = $this->data['Page']['action'];
		}
		$filter = 'ALL';
		if($goaction == 'orders'){
			if(!empty($this->data['Page']['filter'])){
				$filter = $this->data['Page']['filter'];
			}
			$redirect = "/sellers/".$goaction."/page:".$this->data['Page']['goto_page'];
			if(!empty($filter))
				$redirect = "/sellers/".$goaction."/".$filter."/page:".$this->data['Page']['goto_page'];
			$this->redirect($redirect);
		}
	}



	/** 
	@function : download_all_orders
	@description : export all orders of logged in sellers
	@params : 
	@Modify : 
	@Created Date : Feb 16,2011
	@Created By : Ramanpreet Pal Kaur
	*/
	function download_all_orders(){
		$seller_user_id =$this->Session->read('User.id');
		$creteria = "OrderItem.seller_id = ".$seller_user_id;
		$fields = array(
			'OrderItem.id',
			'OrderItem.order_id',
			'OrderItem.seller_id',
			'OrderItem.product_id',
			'OrderItem.condition_id',
			'OrderItem.quantity',
			'OrderItem.price',
			'OrderItem.delivery_method',
			'OrderItem.delivery_cost',
			'OrderItem.estimated_delivery_date',
			'OrderItem.giftwrap',
			'OrderItem.gift_note',
			'OrderItem.product_name',
			'OrderItem.quick_code',
			'Order.id',
			'Order.user_id',
			'Order.user_email',
			'Order.shipping_user_title',
			'Order.shipping_firstname',
			'Order.shipping_lastname',
			'Order.shipping_address1',
			'Order.shipping_address2',
			'Order.shipping_phone',
			'Order.shipping_postal_code',
			'Order.shipping_city',
			'Order.shipping_state',
			'Order.shipping_country',
			'Order.comments',
			'Order.comments',
			'Order.comments',
		);
		App::import('Model','OrderItem');
		$this->OrderItem = new OrderItem();
		$this->OrderItem->expects(array('Order'));
		$this->OrderItem->Order->expects(array('UserSummary'));
		$this->OrderItem->recursive = 2;
		$orders = $this->OrderItem->find('all',array('conditions'=>array($creteria,'Order.deleted'=>'0','Order.payment_status'=>'Y'),'fields'=>$fields,'order'=>array('Order.created' => 'DESC')));
		$countries = $this->Common->getcountries();
		$pro_conditions = $this->Common->get_new_used_conditions();
		$csv_output =  "ORDER ID, DATE, ITEM QCID,SELLER REF, PRODUCT NAME, QUANTITY PURCHASED, PRODUCT PRICE(In Pounds), DELIVERY SERVICE,DELIVERY PRICE,BUYER NAME,GIFT WRAP,GIFT MESSAGE, BUYER PHONE, DELIVERY ADDRESS 1, DELIVERY ADDRESS 2, DELIVERY TOWN/CITY, DELIVERY COUNTY/STATE, DELIVERY POSTAL CODE/ZIP, DELIVERY COUNTRY, DELIVERY EXPECTED DATE, SHIPPED" ;
		$csv_output .= "\n";
		if(count($orders) > 0){
			App::import('Model','ProductSeller');
			$this->ProductSeller = new ProductSeller();
			App::import('Model','OrderSeller');
			$this->OrderSeller = new OrderSeller();
			App::import('Model','Address');
			$this->Address = new Address();
			foreach($orders as $value){
				
				foreach($value['OrderItem'] as $field_index => $user_info){
					$value['OrderItem'][$field_index] = html_entity_decode($user_info);
					$value['OrderItem'][$field_index] = str_replace('&#039;',"'",$value['OrderItem'][$field_index]);
				}
				foreach($value['Order'] as $field_index => $user_info){
					if(!is_array($user_info)){
						$value['Order'][$field_index] = html_entity_decode($user_info);
						$value['Order'][$field_index] = str_replace('&#039;',"'",$value['Order'][$field_index]);
					}/* else{
						if(!empty($info['UserSummary'])){
							foreach($info['UserSummary'] as $info_field_index => $info_value){
								$value['Order'][$field_index]['UserSummary'][$info_field_index] = html_entity_decode($info_value);
								$value['Order'][$field_index]['UserSummary'][$info_field_index] = str_replace('&#039;',"'",$value['Order'][$field_index]['UserSummary'][$info_field_index]);
							}
						}
					}*/
				}
				$sell_reference = $this->ProductSeller->find('first',array('conditions'=>array('ProductSeller.seller_id'=>$value['OrderItem']['seller_id'],'ProductSeller.product_id'=>$value['OrderItem']['product_id'],'ProductSeller.condition_id'=>$value['OrderItem']['condition_id']),'fields'=>array('ProductSeller.reference_code')));
				if(!empty($sell_reference['ProductSeller'])){
					foreach($sell_reference['ProductSeller'] as $field_index => $info){
						$sell_reference['ProductSeller'][$field_index] = html_entity_decode($info);
						$sell_reference['ProductSeller'][$field_index] = str_replace('&#039;',"'",$sell_reference['ProductSeller'][$field_index]);
					}
				}
				$buyer_ph = $this->Address->find('first',array('conditions'=>array('Address.user_id'=>$value['Order']['user_id']),'fields'=>array('Address.add_phone')));

				foreach($buyer_ph['Address'] as $field_index => $info){
					$buyer_ph['Address'][$field_index] = html_entity_decode($info);
					$buyer_ph['Address'][$field_index] = str_replace('&#039;',"'",$buyer_ph['Address'][$field_index]);
				}

				$shippingStatus = $this->OrderSeller->find('first',array('conditions'=>array('OrderSeller.order_id'=>$value['OrderItem']['order_id']),'fields'=>array('OrderSeller.shipping_status')));

				foreach($shippingStatus['OrderSeller'] as $field_index => $info){
					$shippingStatus['OrderSeller'][$field_index] = html_entity_decode($info);
					$shippingStatus['OrderSeller'][$field_index] = str_replace('&#039;',"'",$shippingStatus['OrderSeller'][$field_index]);
				}

				if($value['OrderItem']['delivery_method'] == 'E'){
					$expected_delivery_date = $value['OrderItem']['estimated_delivery_date'];
				} else {
				}
				if(empty($expected_delivery_date)){
					$expected_delivery_date = $value['OrderItem']['estimated_delivery_date'];
				}
				$condition  = $pro_conditions[$value['OrderItem']['condition_id']];
				$country = $countries[$value['Order']['shipping_country']];
				if($value['OrderItem']['delivery_method'] == 'E'){
					$delivery_service = 'Express';
				} else {
					$delivery_service = 'Standard';
				}
				$value['OrderItem']['gift_note'] = str_replace('#--#','.',$value['OrderItem']['gift_note']);
				$csv_output .="".str_replace(",",' || ',
				$value['Order']['order_number']).",".str_replace(",",' || ',
				$value['Order']['created']).",".str_replace(",",' || ',
				$value['OrderItem']['quick_code']).",".str_replace(",",' || ',
				$sell_reference['ProductSeller']['reference_code']).",".str_replace(",",' || ',
				$value['OrderItem']['product_name']).",".str_replace(",",' || ',
				$value['OrderItem']['quantity']).",".str_replace(",",' || ',
				$value['OrderItem']['price']).",".str_replace(",",' || ',
				$delivery_service).",".str_replace(",",' || ',
				$value['OrderItem']['delivery_cost']).",".str_replace(",",' || ',
				$value['Order']['UserSummary']['firstname'].' '.$value['Order']['UserSummary']['lastname']).",".str_replace(",",' || ',
				$value['OrderItem']['giftwrap']).",".str_replace(",",' || ',
				$value['OrderItem']['gift_note']).",".str_replace(",",' || ',
				$buyer_ph['Address']['add_phone']).",".str_replace(",",' || ',
				$value['Order']['shipping_address1']).",".str_replace(",",' || ',
				$value['Order']['shipping_address2']).",".str_replace(",",' || ',
				$value['Order']['shipping_city']).",".str_replace(",",' || ',
				$value['Order']['shipping_state']).",".str_replace(",",' || ',
				$value['Order']['shipping_postal_code']).",".str_replace(",",' || ',
				$country).",".str_replace(",",' || ',
				$expected_delivery_date).",".str_replace(",",' || ',
				$shippingStatus['OrderSeller']['shipping_status']).",\n";
				$or_id = $value['OrderItem']['order_id'];
			}
		} else{
			$csv_output .= "No Record Found."; 
		}
		$filePath="all_seller_orders_listing_".date("Ymd").".csv";
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=".$filePath."");
		header("Pragma: no-cache");
		header("Expires: 0");
		print $csv_output;
		exit;
	}


	/** 
	@function : download_all_orders
	@description : export all orders of logged in sellers
	@params : 
	@Modify : 
	@Created Date : Feb 16,2011
	@Created By : Ramanpreet Pal Kaur
	*/
	function download_unshipped_orders(){
		$seller_user_id =$this->Session->read('User.id');
		$creteria = "OrderItem.seller_id = ".$seller_user_id;
		$fields = array(
			'OrderItem.id',
			'OrderItem.order_id',
			'OrderItem.seller_id',
			'OrderItem.product_id',
			'OrderItem.condition_id',
			'OrderItem.quantity',
			'OrderItem.price',
			'OrderItem.delivery_method',
			'OrderItem.delivery_cost',
			'OrderItem.estimated_delivery_date',
			'OrderItem.giftwrap',
			'OrderItem.gift_note',
			'OrderItem.product_name',
			'OrderItem.quick_code',
			'Order.id',
			'Order.user_id',
			'Order.user_email',
			'Order.shipping_user_title',
			'Order.shipping_firstname',
			'Order.shipping_lastname',
			'Order.shipping_address1',
			'Order.shipping_address2',
			'Order.shipping_phone',
			'Order.shipping_postal_code',
			'Order.shipping_city',
			'Order.shipping_state',
			'Order.shipping_country',
			'Order.comments',
		);
		App::import('Model','OrderItem');
		$this->OrderItem = new OrderItem();
		$this->OrderItem->expects(array('Order'));
		$this->OrderItem->Order->expects(array('UserSummary'));
		$this->OrderItem->recursive = 2;
		$orders = $this->OrderItem->find('all',array('conditions'=>array($creteria,'Order.deleted'=>'0'),'fields'=>$fields,'order'=>array('Order.created' => 'DESC')));
		$countries = $this->Common->getcountries();
		$pro_conditions = $this->Common->get_new_used_conditions();
		#Creating CSV
		$csv_output =  "ORDER ID, DATE, ITEM QCID,SELLER REF, PRODUCT NAME, QUANTITY PURCHASED, PRODUCT PRICE(In Pounds), DELIVERY SERVICE,DELIVERY PRICE,BUYER NAME,GIFT WRAP,GIFT MESSAGE, BUYER PHONE, DELIVERY ADDRESS 1, DELIVERY ADDRESS 2, DELIVERY TOWN/CITY, DELIVERY COUNTY/STATE, DELIVERY POSTAL CODE/ZIP, DELIVERY COUNTRY, DELIVERY EXPECTED DATE, SHIPPED" ;
		$csv_output .= "\n";
		$new_order_array = array();
		if(count($orders) > 0){
			App::import('Model','OrderSeller');
			$this->OrderSeller = new OrderSeller();
			foreach($orders as $value){
				
				foreach($value['OrderItem'] as $field_index => $info){
					$value['OrderItem'][$field_index] = html_entity_decode($info);
					$value['OrderItem'][$field_index] = str_replace('&#039;',"'",$value['OrderItem'][$field_index]);
				}
				foreach($value['Order'] as $field_index => $info){
					if(!is_array($info)){
						$value['Order'][$field_index] = html_entity_decode($info);
						$value['Order'][$field_index] = str_replace('&#039;',"'",$value['Order'][$field_index]);
					} else{
						if(!empty($info['UserSummary'])){
							foreach($info['UserSummary'] as $info_field_index => $info_value){
								$value['Order'][$field_index]['UserSummary'][$info_field_index] = html_entity_decode($info_value);
								$value['Order'][$field_index]['UserSummary'][$info_field_index] = str_replace('&#039;',"'",$value['Order'][$field_index]['UserSummary'][$info_field_index]);
							}
						}
					}
				}
				$shippingStatus = $this->OrderSeller->find('first',array('conditions'=>array('OrderSeller.order_id'=>$value['OrderItem']['order_id']),'fields'=>array('OrderSeller.shipping_status')));
				if(!empty($shippingStatus)){
					if($shippingStatus['OrderSeller']['shipping_status'] !== 'Unshipped'){
						
					}else{
						$new_order_array[] = $value;
					}
				} else{
					
				}
			}
		} else{
			$new_order_array = $orders;
		}
		if(count($new_order_array) > 0){
			App::import('Model','ProductSeller');
			$this->ProductSeller = new ProductSeller();
			App::import('Model','OrderSeller');
			$this->OrderSeller = new OrderSeller();
			App::import('Model','Address');
			$this->Address = new Address();
			foreach($new_order_array as $new_value){
				$sell_reference = $this->ProductSeller->find('first',array('conditions'=>array('ProductSeller.seller_id'=>$new_value['OrderItem']['seller_id'],'ProductSeller.product_id'=>$new_value['OrderItem']['product_id'],'ProductSeller.condition_id'=>$new_value['OrderItem']['condition_id']),'fields'=>array('ProductSeller.reference_code')));
				foreach($sell_reference['ProductSeller'] as $field_index => $info){
					$sell_reference['ProductSeller'][$field_index] = html_entity_decode($info);
					$sell_reference['ProductSeller'][$field_index] = str_replace('&#039;',"'",$sell_reference['ProductSeller'][$field_index]);
				}
				$buyer_ph = $this->Address->find('first',array('conditions'=>array('Address.user_id'=>$new_value['Order']['user_id']),'fields'=>array('Address.add_phone')));
				
				foreach($buyer_ph['Address'] as $field_index => $info){
					$buyer_ph['Address'][$field_index] = html_entity_decode($info);
					$buyer_ph['Address'][$field_index] = str_replace('&#039;',"'",$buyer_ph['Address'][$field_index]);
				}
				$shippingStatus = $this->OrderSeller->find('first',array('conditions'=>array('OrderSeller.order_id'=>$new_value['OrderItem']['order_id']),'fields'=>array('OrderSeller.shipping_status')));
				if($new_value['OrderItem']['delivery_method'] == 'E'){
					$expected_delivery_date = $new_value['OrderItem']['estimated_delivery_date'];
				} else {
				}
				if(empty($expected_delivery_date)){
					$expected_delivery_date = $new_value['OrderItem']['estimated_delivery_date'];
				}
				$condition  = $pro_conditions[$new_value['OrderItem']['condition_id']];
				$country = $countries[$new_value['Order']['shipping_country']];
				if($new_value['OrderItem']['delivery_method'] == 'E'){
					$delivery_service = 'Express';
				} else {
					$delivery_service = 'Standard';
				}
				$value['OrderItem']['gift_note'] = str_replace('#--#','.',$value['OrderItem']['gift_note']);
				$csv_output .="".str_replace(",",' || ',
				$new_value['Order']['order_number']).",".str_replace(",",' || ',
				$new_value['Order']['created']).",".str_replace(",",' || ',
				$new_value['OrderItem']['quick_code']).",".str_replace(",",' || ',
				$sell_reference['ProductSeller']['reference_code']).",".str_replace(",",' || ',
				$new_value['OrderItem']['product_name']).",".str_replace(",",' || ',
				$new_value['OrderItem']['quantity']).",".str_replace(",",' || ',
				$new_value['OrderItem']['price']).",".str_replace(",",' || ',
				$delivery_service).",".str_replace(",",' || ',
				$new_value['OrderItem']['delivery_cost']).",".str_replace(",",' || ',
				$new_value['Order']['UserSummary']['firstname'].' '.$new_value['Order']['UserSummary']['lastname']).",".str_replace(",",' || ',
				$new_value['OrderItem']['giftwrap']).",".str_replace(",",' || ',
				$new_value['OrderItem']['gift_note']).",".str_replace(",",' || ',
				$buyer_ph['Address']['add_phone']).",".str_replace(",",' || ',
				$new_value['Order']['shipping_address1']).",".str_replace(",",' || ',
				$new_value['Order']['shipping_address2']).",".str_replace(",",' || ',
				$new_value['Order']['shipping_city']).",".str_replace(",",' || ',
				$new_value['Order']['shipping_state']).",".str_replace(",",' || ',
				$new_value['Order']['shipping_postal_code']).",".str_replace(",",' || ',
				$country).",".str_replace(",",' || ',
				$expected_delivery_date).",".str_replace(",",' || ',
				$shippingStatus['OrderSeller']['shipping_status']).",\n";
				$or_id = $new_value['OrderItem']['order_id'];
			}
		} else{
			$csv_output .= "No Record Found."; 
		}
		$filePath="unshipped_sellers_orders_listing_".date("Ymd").".csv";
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=".$filePath."");
		header("Pragma: no-cache");
		header("Expires: 0");
		print $csv_output;
		exit;
	}

	/** 
	@function: order_details
	@description: to display details of order
	@Created by: Ramanpreet Pal
	@Created:  16 Feb 2011
	@Modify:  
	*/
	function order_details($order_id = null,$editorder = null){
		$reasons = $this->Common->getcancel_reasons();
		$this->set('title_for_layout','Choiceful.com Marketplace: My Marketplace - Marketplace Order Management');
		$this->set('reasons',$reasons);
		$order_id = base64_decode($order_id);
		$this->set('editorder',base64_decode($editorder));
		$carriers = $this->Common->getcarriers();
		$this->set('carriers',$carriers);
		$countries = $this->Common->getcountries();
		$pro_conditions = $this->Common->get_new_used_conditions();
		$this->set('countries',$countries);
		$this->set('pro_conditions',$pro_conditions);
		$this->layout = 'marketplace_fullscreen';
		$seller_id = $this->Session->read('User.id');
		$order_flag = 0;
		$order_flag = $this->check_sellersOrder($order_id,$seller_id);
		if(empty($order_flag)){
			$this->Session->setFlash('You are trying to access an invaild order.','default',array('class'=>'flashError'));
			$this->redirect('/sellers/orders');
		}
		$order_details = $this->get_order_details($order_id);
		$this->set('order_details',$order_details);
	}

	
	/** 
	@function: ship_order
	@description: to display details of order to ship that order
	@Created by: Ramanpreet Pal
	@Created:  23 Feb 2011
	@Modify:  
	*/
	function ship_order($order_id = null,$editorder = null){
		
		$this->set('editorder',base64_decode($editorder));
		$this->set('order_id',base64_decode($order_id));
		$order_id = base64_decode($order_id);
		$this->set('title_for_layout','Choiceful.com Marketplace: My Marketplace - Marketplace Order Management');
		$reasons = $this->Common->getcancel_reasons();
		$this->set('reasons',$reasons);
		$carriers = $this->Common->getcarriers();
		$countries = $this->Common->getcountries();
		$pro_conditions = $this->Common->get_new_used_conditions();
		$this->set('carriers',$carriers);
		$this->set('countries',$countries);
		$this->set('pro_conditions',$pro_conditions);
		$shipment_number_list_new = array();
		
		App::import('Model','OrderItem');
		$this->OrderItem = new OrderItem();
		$message_edit = '';$ship_product_str = '';
			
		$seller_id = $this->Session->read('User.id');
		$order_flag = 0;
		$order_flag = $this->check_sellersOrder($order_id,$seller_id);
			
		$cancel_item_qty_list = $this->Ordercom->canceled_orderitem_qty($order_id,$seller_id);
		$ship_item_qty_list = $this->Ordercom->dispatcheded_orderitem_qty($order_id,$seller_id);
		$this->set('cancel_item_qty_list',$cancel_item_qty_list);
		$this->set('ship_item_qty_list',$ship_item_qty_list);
		if(empty($order_flag)) {
			$this->Session->setFlash('You are trying to access an invaild order.','default',array('class'=>'flashError'));
			$this->redirect('/sellers/orders');
		}
			
		App::import('Model','OrderSeller');
		$this->OrderSeller = new OrderSeller();
		App::import('Model','DispatchedItem');
		$this->DispatchedItem = new DispatchedItem();
		
		$shipment_number_list = $this->DispatchedItem->find('list',array('conditions'=>array('DispatchedItem.seller_id'=>$seller_id,'DispatchedItem.order_id'=>$order_id),'group'=>array('DispatchedItem.shipment_number'),'fields'=>array('DispatchedItem.shipment_number','DispatchedItem.shipment_number')));
		//$shipment_number_list_new[0] = 'Add New';
		if(!empty($shipment_number_list)){
			foreach($shipment_number_list as $sh_index => $sh_number){
				$shipment_number_list_new[$sh_index] = 'Shipment '.$sh_number;
			}
		}
		$this->set('shipment_number_list',$shipment_number_list_new);
		if(!empty($this->data)){
			
			$this->data = $this->cleardata($this->data);
			
			$this->data['DispatchedItem']['seller_id'] = $seller_id;
			$this->OrderSeller->set($this->data);
			$this->data['OrderSeller']['tracking_id'] = $this->data['OrderSeller']['trackingId'];
			$this->data['DispatchedItem']['order_id'] = $order_id;
			$this->data['DispatchedItem']['seller_id'] = $seller_id;
			
			$ship_date_err = $this->data['OrderSeller']['shipping_date'] = $this->data['OrderSeller']['shipping_date'];
			$this->set(compact('ship_date_err'));
			
			if(!empty($this->data['OrderSeller']['shipping_date'])){
				$ship_date_array = explode('-',$this->data['OrderSeller']['shipping_date']);
				$ship_date = $ship_date_array[2].'-'.$ship_date_array[1].'-'.$ship_date_array[0];
				$this->data['OrderSeller']['shipping_date'] = $ship_date;
			}
				
			$this->data['OrderSeller']['dispatch_date'] = $this->data['OrderSeller']['shipping_date'];
			$this->data['DispatchedItem']['shipping_date'] = $this->data['OrderSeller']['shipping_date'];
			
			
			
			if($this->OrderSeller->validates()) {
				$os_id = $this->OrderSeller->find('first',array('conditions'=>array('OrderSeller.order_id'=>$order_id,'OrderSeller.seller_id'=>$seller_id),'fields'=>array('OrderSeller.id')));
				$this->data['OrderSeller']['id'] = $os_id['OrderSeller']['id'];
				$ex_ship_date = $this->Ordercom->getExpectedDispatchDate($order_id,$seller_id);
				$this->data['OrderSeller']['expected_dispatch_date'] = $ex_ship_date;
				$qty_flag = 0;
				if(!empty($this->data['OrderSeller']['Items'])){
					foreach($this->data['OrderSeller']['Items'] as $item_id => $item_detail){
						if(!empty($item_detail['dispatch_qty'])){
							$qty_flag = 1;
							break;
						} else{}
					}
				}
				if(!empty($qty_flag)){
					if(!empty($this->data['OrderSeller']['Items'])){
						if(!empty($this->data['OrderSeller']['shipment_number'])){
							$message_edit = 'We edited the previous shipment';
							$shipment_number = $this->data['OrderSeller']['shipment_number'];
							$ship_items_number_info = $this->DispatchedItem->find('all',array('conditions'=>array('DispatchedItem.seller_id'=>$seller_id,'DispatchedItem.order_id'=>$order_id,'DispatchedItem.shipment_number'=>$shipment_number)));
							$created = $ship_items_number_info[0]['DispatchedItem']['created'];
							$modified = $ship_items_number_info[0]['DispatchedItem']['modified'];
							if(!empty($ship_items_number_info)){
								foreach($ship_items_number_info as $ship_item_info){
									$this->DispatchedItem->delete($ship_item_info['DispatchedItem']['id']);
								}
							}
							$this->data['DispatchedItem'] = $this->data['OrderSeller'];
							$this->data['DispatchedItem']['order_id'] = $order_id;
							$this->data['DispatchedItem']['seller_id'] = $seller_id;
							$this->data['DispatchedItem']['shipping_date'] = $this->data['DispatchedItem']['shipping_date'];
							$this->data['DispatchedItem']['created'] = $created;
							$this->data['DispatchedItem']['modified'] = $modified;
							foreach($this->data['OrderSeller']['Items'] as $item_id => $item_detail){
								if(!empty($item_detail['dispatch_qty'])){
									$this->data['DispatchedItem']['id'] = 0;
									$this->data['DispatchedItem']['order_item_id'] = $item_id;
									$this->data['DispatchedItem']['quantity'] = $item_detail['dispatch_qty'];
									$this->DispatchedItem->set($this->data);
									$this->DispatchedItem->save();
									
									/* To send mail make a string of shipped items */
									$order_item_info = $this->OrderItem->find('first',array('conditions'=>array('OrderItem.id'=>$item_id),'OrderItem.product_name'));
									if(!empty($order_item_info)){
										if(empty($order_item_info['OrderItem']['product_name']))
											$order_item_info['OrderItem']['product_name'] = '';
									}
									if(empty($ship_product_str)){
										$ship_product_str = $item_detail['dispatch_qty'].' X '.$order_item_info['OrderItem']['product_name'];
									} else{
										$ship_product_str = $ship_product_str.'<br>'.$item_detail['dispatch_qty'].' X '.$order_item_info['OrderItem']['product_name'];
									}
									/* To send mail make a string of shipped items */
								}
							}
							
							$mail_data['ship_product_str'] = $ship_product_str;
							$mail_data['order_id'] = $order_id;
							$mail_data['shipping_carrier'] = $this->data['DispatchedItem']['shipping_carrier'];
							$mail_data['other_carrier'] = $this->data['DispatchedItem']['other_carrier'];
							$mail_data['shipping_service'] = $this->data['DispatchedItem']['shipping_service'];
							$mail_data['trackingId'] = $this->data['DispatchedItem']['trackingId'];
							$mail_data['dispatch_date'] = $this->data['DispatchedItem']['dispatch_date'];
							$mail_data['shipment_number'] = $shipment_number;
							$mail_data['message_edit'] = $message_edit;
							
							$total_or_items = $this->Ordercom->orderitem_qty($order_id,$seller_id);
							$cancel_item_qty = $this->Ordercom->canceled_orderitem_qty($order_id,$seller_id);
							$dispatch_item_qty = $this->Ordercom->dispatcheded_orderitem_qty($order_id,$seller_id);
								
							if(!empty($total_or_items)){
								foreach($total_or_items as $item_index=>$item_qty){
									if(!empty($cancel_item_qty[$item_index])) {
										$cancel_qty_itm = $cancel_item_qty[$item_index];
									} else{
										$cancel_qty_itm = 0;
									}
									if(!empty($dispatch_item_qty[$item_index])){
										$disp_qty_itm = $dispatch_item_qty[$item_index];
									} else{
										$disp_qty_itm = 0;
									}
									if($item_qty == $disp_qty_itm + $cancel_qty_itm){
										$shipping_status_flag[] = 'S';
									} else{
										$shipping_status_flag[] = 'PS';
									}
								}
							}
							if(in_array('PS',$shipping_status_flag)){
								$this->data['OrderSeller']['shipping_status'] = 'Part Shipped';
							} else {
								$this->data['OrderSeller']['shipping_status'] = 'Shipped';
							}
							$this->OrderSeller->set($this->data);
							$this->OrderSeller->save($this->data);
							$this->data = '';
							$this->sendShipmentMail($mail_data);
							$this->Session->setFlash('Information updated successfully');
							$this->redirect('/sellers/ship_order/'.base64_encode($order_id).'/'.base64_encode('edit'));
						} else{
						$ship_number_info = $this->DispatchedItem->find('first',array('conditions'=>array('DispatchedItem.seller_id'=>$seller_id,'DispatchedItem.order_id'=>$order_id),'order'=>array('DispatchedItem.created Desc'),'fields'=>array('DispatchedItem.shipment_number')));
							$shipment_number ='';
							if(!empty($ship_number_info)){
								$shipment_number = $ship_number_info['DispatchedItem']['shipment_number'] + 1;
							} else{
								$shipment_number = 1;
							}
							$this->data['DispatchedItem'] = $this->data['OrderSeller'];
							$this->data['DispatchedItem']['order_id'] = $order_id;
							$this->data['DispatchedItem']['seller_id'] = $seller_id;
							$this->data['DispatchedItem']['shipping_date'] = $this->data['DispatchedItem']['shipping_date'];
							if(!empty($shipment_number))
								$this->data['DispatchedItem']['shipment_number'] = $shipment_number;
							foreach($this->data['OrderSeller']['Items'] as $item_id => $item_detail){
								if(!empty($item_detail['dispatch_qty'])){
									$this->data['DispatchedItem']['id'] = 0;
									$this->data['DispatchedItem']['order_item_id'] = $item_id;
									$this->data['DispatchedItem']['quantity'] = $item_detail['dispatch_qty'];
									$this->DispatchedItem->set($this->data);
									$this->DispatchedItem->save();
									/* To send mail make a string of shipped items */
									$order_item_info = $this->OrderItem->find('first',array('conditions'=>array('OrderItem.id'=>$item_id),'fields'=>array('OrderItem.product_name',)));
									if(!empty($order_item_info)){
										if(empty($order_item_info['OrderItem']['product_name']))
											$order_item_info['OrderItem']['product_name'] = '';
									}
									if(empty($ship_product_str)){
										$ship_product_str = $item_detail['dispatch_qty'].' X '.$order_item_info['OrderItem']['product_name'];
									} else{
										$ship_product_str = $ship_product_str.'<br>'.$item_detail['dispatch_qty'].' X '.$order_item_info['OrderItem']['product_name'];
									}
									
									/* To send mail make a string of shipped items */
								}
							}
							$mail_data['ship_product_str'] = $ship_product_str;
							$mail_data['order_id'] = $order_id;
							$mail_data['shipping_carrier'] = $this->data['DispatchedItem']['shipping_carrier'];
							$mail_data['other_carrier'] = $this->data['DispatchedItem']['other_carrier'];
							$mail_data['shipping_service'] = $this->data['DispatchedItem']['shipping_service'];
							$mail_data['trackingId'] = $this->data['DispatchedItem']['trackingId'];
							$mail_data['dispatch_date'] = $this->data['DispatchedItem']['dispatch_date'];
							$mail_data['shipment_number'] = $shipment_number;
							$mail_data['message_edit'] = $message_edit;
							
							$total_or_items = $this->Ordercom->orderitem_qty($order_id,$seller_id);
							$cancel_item_qty = $this->Ordercom->canceled_orderitem_qty($order_id,$seller_id);
							$dispatch_item_qty = $this->Ordercom->dispatcheded_orderitem_qty($order_id,$seller_id);
								
							if(!empty($total_or_items)){
								foreach($total_or_items as $item_index=>$item_qty){
									if(!empty($cancel_item_qty[$item_index])) {
										$cancel_qty_itm = $cancel_item_qty[$item_index];
									} else{
										$cancel_qty_itm = 0;
									}
									if(!empty($dispatch_item_qty[$item_index])){
										$disp_qty_itm = $dispatch_item_qty[$item_index];
									} else{
										$disp_qty_itm = 0;
									}
										
									if($item_qty == $disp_qty_itm + $cancel_qty_itm){
										$shipping_status_flag[] = 'S';
									} else{
										$shipping_status_flag[] = 'PS';
									}
								}
							}
							if(in_array('PS',$shipping_status_flag)){
								$this->data['OrderSeller']['shipping_status'] = 'Part Shipped';
							} else {
								$this->data['OrderSeller']['shipping_status'] = 'Shipped';
							}
							$this->OrderSeller->set($this->data);
							$this->OrderSeller->save($this->data);
							$this->data = '';
							$this->sendShipmentMail($mail_data);
							$this->Session->setFlash('Selected items have been shipped');
							$this->redirect('/sellers/ship_order/'.base64_encode($order_id).'/'.base64_encode('edit'));
						}
					}
				} else{
// 					foreach($this->data['OrderSeller'] as $field_index => $info){
// 						$this->data['OrderSeller'][$field_index] = html_entity_decode($info);
// 						$this->data['OrderSeller'][$field_index] = str_replace('&#039;',"'",$this->data['OrderSeller'][$field_index]);
// 					}
					$this->Session->setFlash('Please select the quantity you would like to ship.','default',array('class'=>'flashError'));
					if(!empty($this->data['OrderSeller']['shipping_date'])){
						$new_ship_date_array = explode('-',$this->data['OrderSeller']['shipping_date']);
						$new_ship_date = $new_ship_date_array[2].'/'.$new_ship_date_array[1].'/'.$new_ship_date_array[0];
						$this->data['OrderSeller']['shipping_date'] = $new_ship_date;
					}
				}
			} else{
				if(!empty($this->data['OrderSeller']['shipping_date'])){
					$new_ship_date_array = explode('-',$this->data['OrderSeller']['shipping_date']);
					$new_ship_date = $new_ship_date_array[2].'/'.$new_ship_date_array[1].'/'.$new_ship_date_array[0];
					$this->data['OrderSeller']['shipping_date'] = $new_ship_date;
				}
				$errorArray = $this->OrderSeller->validationErrors;
				$this->set('errors',$errorArray);
			}
		}
		else
		{
			$ship_date_err = '';
			$this->set(compact('ship_date_err'));
		}
			
		if(base64_decode($editorder) == 'edit'){
			$orderSeller_info = $this->OrderSeller->find('first',array('conditions'=>array('OrderSeller.order_id'=>$order_id,'OrderSeller.seller_id'=>$seller_id)));
			if(!empty($orderSeller_info['OrderSeller']['dispatch_date'])){
					
				$this->data['OrderSeller']['shipping_date'] = $orderSeller_info['OrderSeller']['dispatch_date'];
				
				$ship_date_err = $this->data['OrderSeller']['shipping_date'] = $this->data['OrderSeller']['shipping_date'];
				$this->set(compact('ship_date_err'));
					
				if(!empty($this->data['OrderSeller']['shipping_date'])){
					$new_ship_date_array = explode('-',$this->data['OrderSeller']['shipping_date']);
					$new_ship_date = $new_ship_date_array[2].'/'.$new_ship_date_array[1].'/'.$new_ship_date_array[0];
					$this->data['OrderSeller']['shipping_date'] = $new_ship_date;
				}
			}
		}
		$order_details = $this->get_order_details($order_id);
		$this->set('order_details',$order_details);



		if($this->RequestHandler->isAjax()==0){
 			$this->layout = 'marketplace_fullscreen';
 		}else{
			$this->layout = 'ajax';
			
			$this->viewPath = 'elements/seller' ;
			$this->render('orderdetails');
		}


	}




	
	/** 
	@function: ship_order_edit
	@description: to display details of order to ship that order
	@Created by: Ramanpreet Pal
	@Created:  23 Feb 2011
	@Modify:  
	*/
	function ship_order_edit($order_id = null,$editorder = null,$ship_edit = null){
		
		if(empty($this->data['OrderSeller']['shipment_number'])){
			
			$this->Session->setFlash('Not a vaild method to access that page.','default',array('class'=>'flashError'));
			
			$this->redirect('/sellers/ship_order/'.$order_id.'/'.$editorder);
			
		}
		$this->set('editorder',base64_decode($editorder));
		$this->set('order_id',base64_decode($order_id));
		$this->set('ship_edit',base64_decode($ship_edit));
		$message_edit = '';$ship_product_str = '';
		$order_id = base64_decode($order_id);
		
		$reasons = $this->Common->getcancel_reasons();
		$this->set('reasons',$reasons);
		$carriers = $this->Common->getcarriers();
		$countries = $this->Common->getcountries();
		$pro_conditions = $this->Common->get_new_used_conditions();
		$this->set('carriers',$carriers);
		$this->set('countries',$countries);
		$this->set('pro_conditions',$pro_conditions);
		$this->layout = 'marketplace_fullscreen';
		$seller_id = $this->Session->read('User.id');
		$order_flag = 0;
		$order_flag = $this->check_sellersOrder($order_id,$seller_id);
		if(empty($order_flag)) {
			$this->Session->setFlash('You are trying to access an invaild order.','default',array('class'=>'flashError'));
			$this->redirect('/sellers/orders');
		}
		App::import('Model','OrderSeller');
		$this->OrderSeller = new OrderSeller();
		App::import('Model','DispatchedItem');
		$this->DispatchedItem = new DispatchedItem();
		App::import('Model','OrderItem');
		$this->OrderItem = new OrderItem();



		$shipment_number = $this->data['OrderSeller']['shipment_number'];
		
		$cancel_item_qty_list = $this->Ordercom->canceled_orderitem_qty($order_id,$seller_id);
		//$ship_item_qty_list = $this->Ordercom->dispatcheded_orderitem_qty($order_id,$seller_id);


		$creteria_dispatchitems = array('DispatchedItem.order_id'=>$order_id,'DispatchedItem.seller_id'=>$seller_id,'DispatchedItem.shipment_number != '.$shipment_number);

		$dispatched_items = $this->DispatchedItem->find('all',array('conditions'=>$creteria_dispatchitems,'fields'=>array('SUM(quantity) as total_quantity','DispatchedItem.order_item_id'),'group'=>array('DispatchedItem.order_item_id')));
		$dispatchitem_arr = array();
		if(!empty($dispatched_items)){
			foreach($dispatched_items as $dispatched_item){
				$dispatchitem_arr[$dispatched_item['DispatchedItem']['order_item_id']] = $dispatched_item[0]['total_quantity'];
			}
		}
		
		$this->set('ship_item_qty_list',$dispatchitem_arr);
		$this->set('cancel_item_qty_list',$cancel_item_qty_list);
		
		
		$shipment_number_list = $this->DispatchedItem->find('list',array('conditions'=>array('DispatchedItem.seller_id'=>$seller_id,'DispatchedItem.order_id'=>$order_id),'group'=>array('DispatchedItem.shipment_number'),'fields'=>array('DispatchedItem.shipment_number','DispatchedItem.shipment_number')));
		//$shipment_number_list_new[0] = 'Add New';
		if(!empty($shipment_number_list)){
			foreach($shipment_number_list as $sh_index => $sh_number){
				$shipment_number_list_new[$sh_index] = 'Shipment '.$sh_number;
			}
		}
		$this->set('shipment_number_list',$shipment_number_list_new);
		
		if(!empty($this->data)){
			
			$this->data['DispatchedItem']['seller_id'] = $seller_id;
			$this->OrderSeller->set($this->data);
			$this->data['OrderSeller']['tracking_id'] = $this->data['OrderSeller']['trackingId'];
			$this->data['DispatchedItem']['order_id'] = $order_id;
			$this->data['DispatchedItem']['seller_id'] = $seller_id;
			if(!empty($this->data['OrderSeller']['shipping_date'])){
				$ship_date_array = explode('/',$this->data['OrderSeller']['shipping_date']);
				
				$ship_date = $ship_date_array[2].'-'.$ship_date_array[1].'-'.$ship_date_array[0];
				$this->data['OrderSeller']['shipping_date'] = $ship_date;
			}
			$this->data['OrderSeller']['dispatch_date'] = $this->data['OrderSeller']['shipping_date'];
			$this->data['DispatchedItem']['shipping_date'] = $this->data['OrderSeller']['shipping_date'];
			
			if($this->OrderSeller->validates()) {
				$os_id = $this->OrderSeller->find('first',array('conditions'=>array('OrderSeller.order_id'=>$order_id,'OrderSeller.seller_id'=>$seller_id),'fields'=>array('OrderSeller.id')));
				$this->data['OrderSeller']['id'] = $os_id['OrderSeller']['id'];
				$ex_ship_date = $this->Ordercom->getExpectedDispatchDate($order_id,$seller_id);
				$this->data['OrderSeller']['expected_dispatch_date'] = $ex_ship_date;
				$qty_flag = 0;
				if(!empty($this->data['OrderSeller']['Items'])){
					foreach($this->data['OrderSeller']['Items'] as $item_id => $item_detail){
						if(!empty($item_detail['dispatch_qty'])){
							$qty_flag = 1;
							break;
						} else{}
					}
				}
				if(!empty($qty_flag)){
					if(!empty($this->data['OrderSeller']['Items'])){
						if(!empty($this->data['OrderSeller']['shipment_number'])){
							$message_edit = 'We edited the previous shipment';
							$shipment_number = $this->data['OrderSeller']['shipment_number'];
							$ship_items_number_info = $this->DispatchedItem->find('all',array('conditions'=>array('DispatchedItem.seller_id'=>$seller_id,'DispatchedItem.order_id'=>$order_id,'DispatchedItem.shipment_number'=>$shipment_number)));
							$created = $ship_items_number_info[0]['DispatchedItem']['created'];
							$modified = $ship_items_number_info[0]['DispatchedItem']['modified'];
							if(!empty($ship_items_number_info)){
								foreach($ship_items_number_info as $ship_item_info){
									$this->DispatchedItem->delete($ship_item_info['DispatchedItem']['id']);
								}
							}
							$this->data['DispatchedItem'] = $this->data['OrderSeller'];
							$this->data['DispatchedItem']['order_id'] = $order_id;
							$this->data['DispatchedItem']['seller_id'] = $seller_id;
							$this->data['DispatchedItem']['shipping_date'] = $this->data['DispatchedItem']['shipping_date'];
							$this->data['DispatchedItem']['created'] = $created;
							$this->data['DispatchedItem']['modified'] = $modified;
							foreach($this->data['OrderSeller']['Items'] as $item_id => $item_detail){
								if(!empty($item_detail['dispatch_qty'])){
									$this->data['DispatchedItem']['id'] = 0;
									$this->data['DispatchedItem']['order_item_id'] = $item_id;
									$this->data['DispatchedItem']['quantity'] = $item_detail['dispatch_qty'];
									$this->DispatchedItem->set($this->data);
									$this->DispatchedItem->save();
									
									/* To send mail make a string of shipped items */
									$order_item_info = $this->OrderItem->find('first',array('conditions'=>array('OrderItem.id'=>$item_id),'fields'=>array('OrderItem.product_name',)));
									if(!empty($order_item_info)){
										if(empty($order_item_info['OrderItem']['product_name']))
											$order_item_info['OrderItem']['product_name'] = '';
									}
									if(empty($ship_product_str)){
										$ship_product_str = $item_detail['dispatch_qty'].' X '.$order_item_info['OrderItem']['product_name'];
									} else{
										$ship_product_str = $ship_product_str.'<br>'.$item_detail['dispatch_qty'].' X '.$order_item_info['OrderItem']['product_name'];
									}
									
									/* To send mail make a string of shipped items */
								}
							}
							$total_or_items = $this->Ordercom->orderitem_qty($order_id,$seller_id);
							$cancel_item_qty = $this->Ordercom->canceled_orderitem_qty($order_id,$seller_id);
							$dispatch_item_qty = $this->Ordercom->dispatcheded_orderitem_qty($order_id,$seller_id);
								
							if(!empty($total_or_items)){
								foreach($total_or_items as $item_index=>$item_qty){
									if(!empty($cancel_item_qty[$item_index])) {
										$cancel_qty_itm = $cancel_item_qty[$item_index];
									} else{
										$cancel_qty_itm = 0;
									}
									if(!empty($dispatch_item_qty[$item_index])){
										$disp_qty_itm = $dispatch_item_qty[$item_index];
									} else{
										$disp_qty_itm = 0;
									}
										
									if($item_qty == $disp_qty_itm + $cancel_qty_itm){
										$shipping_status_flag[] = 'S';
									} else{
										$shipping_status_flag[] = 'PS';
									}
								}
							}
							
							$mail_data['ship_product_str'] = $ship_product_str;
							$mail_data['order_id'] = $order_id;
							$mail_data['shipping_carrier'] = $this->data['DispatchedItem']['shipping_carrier'];
							$mail_data['other_carrier'] = $this->data['DispatchedItem']['other_carrier'];
							$mail_data['shipping_service'] = $this->data['DispatchedItem']['shipping_service'];
							$mail_data['trackingId'] = $this->data['DispatchedItem']['trackingId'];
							$mail_data['dispatch_date'] = $this->data['DispatchedItem']['dispatch_date'];
							$mail_data['shipment_number'] = $shipment_number;
							$mail_data['message_edit'] = $message_edit;

							if(in_array('PS',$shipping_status_flag)){
								$this->data['OrderSeller']['shipping_status'] = 'Part Shipped';
							} else {
								$this->data['OrderSeller']['shipping_status'] = 'Shipped';
							}
					
							//$this->sendShipmentMail($mail_data);
								
							$this->OrderSeller->set($this->data);
							$this->OrderSeller->save($this->data);
							$this->data = '';
							$this->Session->setFlash('Shipment updated');
							$this->redirect('/sellers/ship_order/'.base64_encode($order_id).'/'.base64_encode('edit'));
						} else{
							$ship_number_info = $this->DispatchedItem->find('first',array('conditions'=>array('DispatchedItem.seller_id'=>$seller_id,'DispatchedItem.order_id'=>$order_id),'order'=>array('DispatchedItem.created Desc'),'fields'=>array('DispatchedItem.shipment_number')));
							$shipment_number ='';
							if(!empty($ship_number_info)){
								$shipment_number = $ship_number_info['DispatchedItem']['shipment_number'] + 1;
							}
							$this->data['DispatchedItem'] = $this->data['OrderSeller'];
							$this->data['DispatchedItem']['order_id'] = $order_id;
							$this->data['DispatchedItem']['seller_id'] = $seller_id;
							$this->data['DispatchedItem']['shipping_date'] = $this->data['DispatchedItem']['shipping_date'];
							if(!empty($shipment_number))
								$this->data['DispatchedItem']['shipment_number'] = $shipment_number;
							foreach($this->data['OrderSeller']['Items'] as $item_id => $item_detail){
								if(!empty($item_detail['dispatch_qty'])){
									$this->data['DispatchedItem']['id'] = 0;
									$this->data['DispatchedItem']['order_item_id'] = $item_id;
									$this->data['DispatchedItem']['quantity'] = $item_detail['dispatch_qty'];
									$this->DispatchedItem->set($this->data);
									$this->DispatchedItem->save();
									/* To send mail make a string of shipped items */
									$order_item_info = $this->OrderItem->find('first',array('conditions'=>array('OrderItem.id'=>$item_id),'fields'=>array('OrderItem.product_name',)));
									if(!empty($order_item_info)){
										if(empty($order_item_info['OrderItem']['product_name']))
											$order_item_info['OrderItem']['product_name'] = '';
									}
									if(empty($ship_product_str)){
										$ship_product_str = $item_detail['dispatch_qty'].' X '.$order_item_info['OrderItem']['product_name'];
									} else{
										$ship_product_str = $ship_product_str.'<br>'.$item_detail['dispatch_qty'].' X '.$order_item_info['OrderItem']['product_name'];
									}
									
									/* To send mail make a string of shipped items */
								}
							}
							$total_or_items = $this->Ordercom->orderitem_qty($order_id,$seller_id);
							$cancel_item_qty = $this->Ordercom->canceled_orderitem_qty($order_id,$seller_id);
							$dispatch_item_qty = $this->Ordercom->dispatcheded_orderitem_qty($order_id,$seller_id);
	
							if(!empty($total_or_items)){
								foreach($total_or_items as $item_index=>$item_qty){
									if(!empty($cancel_item_qty[$item_index])) {
										$cancel_qty_itm = $cancel_item_qty[$item_index];
									} else{
										$cancel_qty_itm = 0;
									}
									if(!empty($dispatch_item_qty[$item_index])){
										$disp_qty_itm = $dispatch_item_qty[$item_index];
									} else{
										$disp_qty_itm = 0;
									}
	
									if($item_qty == $disp_qty_itm + $cancel_qty_itm){
										$shipping_status_flag[] = 'S';
									} else{
										$shipping_status_flag[] = 'PS';
									}
								}
							}
							
							$mail_data['ship_product_str'] = $ship_product_str;
							$mail_data['order_id'] = $order_id;
							$mail_data['shipping_carrier'] = $this->data['DispatchedItem']['shipping_carrier'];
							$mail_data['other_carrier'] = $this->data['DispatchedItem']['other_carrier'];
							$mail_data['shipping_service'] = $this->data['DispatchedItem']['shipping_service'];
							$mail_data['trackingId'] = $this->data['DispatchedItem']['trackingId'];
							$mail_data['dispatch_date'] = $this->data['DispatchedItem']['dispatch_date'];
							$mail_data['shipment_number'] = $shipment_number;
							$mail_data['message_edit'] = $message_edit;
								
							if(in_array('PS',$shipping_status_flag)){
								$this->data['OrderSeller']['shipping_status'] = 'Part Shipped';
							} else {
								$this->data['OrderSeller']['shipping_status'] = 'Shipped';
							}
							$this->OrderSeller->set($this->data);
							$this->OrderSeller->save($this->data);
							$this->data = '';
							
							$this->sendShipmentMail($mail_data);
							$this->Session->setFlash('Selected items have been shipped');
							$this->redirect('/sellers/ship_order/'.base64_encode($order_id).'/'.base64_encode('edit'));
						}
					}
					
				} else{
					$this->Session->setFlash('Please select the quantity you would like to ship.','default',array('class'=>'flashError'));
					if(!empty($this->data['OrderSeller']['shipping_date'])){
						$new_ship_date_array = explode('-',$this->data['OrderSeller']['shipping_date']);
						$new_ship_date = $new_ship_date_array[2].'/'.$new_ship_date_array[1].'/'.$new_ship_date_array[0];
						$this->data['OrderSeller']['shipping_date'] = $new_ship_date;
					}
				}
			} else{
				if(!empty($this->data['OrderSeller']['shipping_date'])){
					$new_ship_date_array = explode('-',$this->data['OrderSeller']['shipping_date']);
					$new_ship_date = $new_ship_date_array[2].'/'.$new_ship_date_array[1].'/'.$new_ship_date_array[0];
					$this->data['OrderSeller']['shipping_date'] = $new_ship_date;
				}
				$errorArray = $this->OrderSeller->validationErrors;
				$this->set('errors',$errorArray);
			}
		}
		$order_details = $this->get_order_details_shipment($order_id,$shipment_number);

		$this->set('order_details',$order_details);
	}








	/** 
	@function: get_order_details
	@description: to fetch details for an given order_id
	@Created by: Ramanpreet Pal
	@Created:  23 Feb 2011
	@Modify:  
	*/
	function get_order_details($order_id = null){
		App::import('Model','OrderSeller');
		$this->OrderSeller = new OrderSeller();
		$fields = array(
			'OrderSeller.id','OrderSeller.seller_note',
			'OrderSeller.order_id',
			'OrderSeller.seller_id',
			'OrderSeller.dispatch_date',
			'OrderSeller.shipping_carrier',
			'OrderSeller.shipping_status',
			'OrderSeller.shipping_service',
			'OrderSeller.created',
			'OrderSeller.modified',
			'Order.shipping_user_title',
			'Order.shipping_firstname',
			'Order.shipping_lastname',
			'Order.shipping_address1',
			'Order.shipping_address2',
			'Order.shipping_phone',
			'Order.shipping_postal_code',
			'Order.shipping_city',
			'Order.shipping_state',
			'Order.shipping_country',
			'Order.order_total_cost',
			'Order.id',
			'Order.order_number',
			'Order.created',
			'Order.comments',
		);
		$this->OrderSeller->expects(array('SellerSummary','Order'));
		$this->OrderSeller->Order->expects(array('UserSummary'));
		$this->OrderSeller->recursive = 2;
		$seller_id = $this->Session->read('User.id');
		$order_details = $this->OrderSeller->find('first',array('conditions'=>array('OrderSeller.order_id'=>$order_id,'OrderSeller.seller_id'=>$seller_id),'fields'=>$fields));
		$this->data['OrderSeller']['seller_note'] = $order_details['OrderSeller']['seller_note'];
		$this->data['OrderSeller']['id'] = $order_details['OrderSeller']['id'];

		App::import('Model','OrderItem');
		$this->OrderItem = new OrderItem();
		if(!empty($order_details)){
			$this->OrderItem->expects(array('ProductSeller','DispatchedItem'));
			$items = $this->OrderItem->find('all',array('conditions'=>array('OrderItem.order_id'=>$order_details['OrderSeller']['order_id'],'OrderItem.seller_id'=>$order_details['OrderSeller']['seller_id']),'fields'=>array('distinct(OrderItem.id)','OrderItem.order_id','OrderItem.seller_id','OrderItem.product_id','OrderItem.condition_id','OrderItem.quantity','OrderItem.price','OrderItem.delivery_method','OrderItem.delivery_cost','OrderItem.estimated_delivery_date','OrderItem.giftwrap','OrderItem.giftwrap_cost','OrderItem.gift_note','OrderItem.product_name','OrderItem.quick_code','OrderItem.seller_name','OrderItem.estimated_dispatch_date','ProductSeller.reference_code','ProductSeller.notes')));
			App::import('Model','DispatchedItem');
			$this->DispatchedItem = new DispatchedItem();
			$dispatched_items = $this->DispatchedItem->find('all',array('conditions'=>array('DispatchedItem.order_id'=>$order_details['OrderSeller']['order_id'],'DispatchedItem.seller_id'=>$order_details['OrderSeller']['seller_id']),'fields'=>array('DispatchedItem.id','DispatchedItem.order_id','DispatchedItem.seller_id','DispatchedItem.order_item_id','DispatchedItem.shipping_date','DispatchedItem.shipping_carrier','DispatchedItem.other_carrier','DispatchedItem.shipping_service','DispatchedItem.tracking_id','DispatchedItem.quantity','DispatchedItem.created','DispatchedItem.shipment_number'),'group'=>array('DispatchedItem.shipment_number')));

			if(!empty($dispatched_items)){
				$this->DispatchedItem->expects(array('OrderItem'));
				foreach($dispatched_items as $disitem_index => $disItems){

					$dis_itm_name_qty = '';$cancel_itm_name_qty = '';
					$dis_items = $this->DispatchedItem->find('all',array('conditions'=>array('DispatchedItem.shipping_date'=>$disItems['DispatchedItem']['shipping_date'],'DispatchedItem.seller_id'=>$order_details['OrderSeller']['seller_id'],'DispatchedItem.order_id'=>$order_details['OrderSeller']['order_id'],'DispatchedItem.shipment_number'=>$disItems['DispatchedItem']['shipment_number']),'fields'=>array('OrderItem.product_name','DispatchedItem.quantity','DispatchedItem.order_item_id','DispatchedItem.shipping_date')));
					foreach($dis_items as $dis_item_name){
						if(empty($dis_itm_name_qty))
							$dis_itm_name_qty = $dis_item_name['OrderItem']['product_name'].' x <strong>'.$dis_item_name['DispatchedItem']['quantity'].'</strong>';
						else
							$dis_itm_name_qty = $dis_itm_name_qty.',<br /> '.$dis_item_name['OrderItem']['product_name'].' x <strong>'.$dis_item_name['DispatchedItem']['quantity'].'</strong>';
					}
					$dispatched_items[$disitem_index]['DispatchedItem']['item_name'] = $dis_itm_name_qty;
				}
			}
			$order_details['Dispatched_Items'] = $dispatched_items;
			
			App::import('Model','CanceledItem');
			$this->CanceledItem = new CanceledItem();
			$canceled_items = $this->CanceledItem->find('all',array('conditions'=>array('CanceledItem.order_id'=>$order_details['OrderSeller']['order_id'],'CanceledItem.seller_id'=>$order_details['OrderSeller']['seller_id']),'fields'=>array('CanceledItem.id','CanceledItem.created'),'group'=>'CanceledItem.created'));
			if(!empty($canceled_items)){
				$this->CanceledItem->expects(array('OrderItem'));
				foreach($canceled_items as $cancelitem_index => $cancelItems){
					$cancel_itm_name_qty = '';
					$cancel_items = $this->CanceledItem->find('all',array('conditions'=>array('CanceledItem.created'=>$cancelItems['CanceledItem']['created'],'CanceledItem.seller_id'=>$order_details['OrderSeller']['seller_id'],'CanceledItem.order_id'=>$order_details['OrderSeller']['order_id']),'fields'=>array('OrderItem.product_name','CanceledItem.quantity','CanceledItem.order_item_id','CanceledItem.reason_id','CanceledItem.created')));
					foreach($cancel_items as $cancel_item_name){
						if(empty($cancel_itm_name_qty))
							$cancel_itm_name_qty = $cancel_item_name['OrderItem']['product_name'].' x <strong>'.$cancel_item_name['CanceledItem']['quantity'].'</strong>';
						else
							$cancel_itm_name_qty = $cancel_itm_name_qty.', '.$cancel_item_name['OrderItem']['product_name'].' x <strong>'.$cancel_item_name['CanceledItem']['quantity'].'</strong>';
						$canceled_items[$cancelitem_index]['CanceledItem']['reason_id'] = $cancel_item_name['CanceledItem']['reason_id'];
					}
					$canceled_items[$cancelitem_index]['CanceledItem']['item_name'] = $cancel_itm_name_qty;
				}
			}
			$order_details['CanceledItems'] = $canceled_items;

			
			App::import('Model','Feedback');
			$this->Feedback = new Feedback();
			$items_feedback = array();
			if(!empty($items)){
				$i = 0;
				foreach($items as $item){
					$feedback = $this->Feedback->find('first',array('conditions'=>array('Feedback.order_id'=>$order_details['OrderSeller']['order_id'],'Feedback.order_item_id'=>$item['OrderItem']['id'],'Feedback.seller_id'=>$order_details['OrderSeller']['seller_id'])));
					if(!empty($feedback)) {
						$items_feedback[$i]['feedback'] = $feedback['Feedback']['feedback'];
						$items_feedback[$i]['item_name'] = $item['OrderItem']['product_name'];
					}
					$i++;
				}
				$order_details['Feedback'] = $items_feedback;
				$order_details['Items'] = $items;
			}
		}
		return $order_details;
	}

	/** 
	@function : download_all_orders
	@description : export unshipped orders of logged in sellers
	@params : 
	@Modify : 
	@Created Date : Feb 16,2011
	@Created By : Ramanpreet Pal Kaur
	*/
	function download_all_unshippedOrders(){
		$seller_user_id =$this->Session->read('User.id');
		$creteria = "OrderItem.seller_id = ".$seller_user_id." AND DispatchedItem.id != ''";
		$fields = array(
			'OrderItem.id',
			'OrderItem.order_id',
			'OrderItem.seller_id',
			'OrderItem.product_id',
			'OrderItem.condition_id',
			'OrderItem.quantity',
			'OrderItem.price',
			'OrderItem.delivery_method',
			'OrderItem.delivery_cost',
			'OrderItem.estimated_delivery_date',
			'OrderItem.product_name',
			'OrderItem.quick_code',
			'Order.id',
			'Order.user_id',
			'Order.user_email',
			'Order.shipping_user_title',
			'Order.shipping_firstname',
			'Order.shipping_lastname',
			'Order.shipping_address1',
			'Order.shipping_address2',
			'Order.shipping_phone',
			'Order.shipping_postal_code',
			'Order.shipping_city',
			'Order.shipping_state',
			'Order.shipping_country',
			'Order.comments',
			'ProductSeller.reference_code'
		);
		App::import('Model','OrderItem');
		$this->OrderItem = new OrderItem();
		$this->OrderItem->expects(array('Order','ProductSeller','DispatchedItem'));
		$this->OrderItem->Order->expects(array('OrderSeller','UserSummary'));
		$this->OrderItem->recursive = 2;
		$orders = $this->OrderItem->find('all',array('conditions'=>array($creteria),'fields'=>$fields,'order'=>array('Order.created' => 'DESC')));
		$countries = $this->Common->getcountries();
		$pro_conditions = $this->Common->get_new_used_conditions();
		#Creating CSV
		$csv_output =  "ORDER ID, DATE, ITEM QCID,SELLER REF, PRODUCT NAME, QUANTITY PURCHASED, PRODUCT PRICE,DELIVERY SERVICE,DELIVERY PRICE,BUYER NAME,BUYER EMAIL, BUYER PHONE, DELIVERY ADDRESS 1, DELIVERY ADDRESS 2, DELIVERY TOWN/CITY, DELIVERY COUNTY/STATE, DELIVERY POSTAL CODE/ZIP, DELIVERY COUNTRY, DELIVERY EXPECTED DATE, SHIPPED" ;
		$csv_output .= "\n";
		if(count($orders) > 0){
			foreach($orders as $value){
				if($value['OrderItem']['standard_delivery'] == 'E'){
					$expected_delivery_date = $value['OrderItem']['estimated_delivery_date'];
				} else {

				}
				if(empty($expected_delivery_date)){
					$expected_delivery_date = $value['OrderItem']['estimated_delivery_date'];
				}
				$condition  = $pro_conditions[$value['OrderItem']['condition_id']];
				$country = $countries[$value['Order']['shipping_country']];
				if($value['OrderItem']['standard_delivery'] == 'E'){
					$delivery_service = 'Express';
				} else {
					$delivery_service = 'Standard';
				}
				$csv_output .="".str_replace(",",' || ',
				$value['OrderItem']['order_id']).",".str_replace(",",' || ',
				$value['Order']['created']).",".str_replace(",",' || ',
				$value['OrderItem']['quick_code']).",".str_replace(",",' || ',
				$value['ProductSeller']['reference_code']).",".str_replace(",",' || ',
				$value['OrderItem']['product_name']).",".str_replace(",",' || ',
				$value['OrderItem']['quantity']).",".str_replace(",",' || ',
				$delivery_service).",".str_replace(",",' || ',
				$value['OrderItem']['delivery_cost']).",".str_replace(",",' || ',
				$value['Order']['UserSummary']['firstname'].' '.$value['Order']['UserSummary']['lastname']).",".str_replace(",",' || ',
				$value['Order']['user_email']).",".str_replace(",",' || ',
				$value['Order']['UserSummary']['phone']).",".str_replace(",",' || ',
				$value['Order']['shipping_address1']).",".str_replace(",",' || ',
				$value['Order']['shipping_address2']).",".str_replace(",",' || ',
				$value['Order']['shipping_city']).",".str_replace(",",' || ',
				$value['Order']['shipping_state']).",".str_replace(",",' || ',
				$value['Order']['shipping_postal_code']).",".str_replace(",",' || ',
				$country).",".str_replace(",",' || ',
				$expected_delivery_date).",".str_replace(",",' || ',
				$value['Order']['OrderSeller']['shipping_status']).",\n";
				$or_id = $value['OrderItem']['order_id'];
			}
		} else{
			$csv_output .= "No Record Found.."; 
		}
		$filePath="all_orders_listing_".date("Ymd").".csv";
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=".$filePath."");
		header("Pragma: no-cache");
		header("Expires: 0");
		print $csv_output;
		exit;
	}

	/** 
	@function : add_sellernote
	@description : to add note(reminder for himself) by the seller for his order
	@params : 
	@Modify : 
	@Created Date : Feb 23,2011
	@Created By : Ramanpreet Pal Kaur
	*/
	function add_sellernote(){
		$this->layout = 'ajax';
		if(!empty($this->data)){
			
			$this->data = $this->cleardata($this->data);
			//$this->data = Sanitize::clean($this->data, array('encode' => false));
			
			App::import('Model','OrderSeller');
			$this->OrderSeller = new OrderSeller();
			//$orderSellerValidate = $this->OrderSeller->validates();
			$this->OrderSeller->set($this->data);
			if($this->OrderSeller->validates()){
				$this->OrderSeller->id = $this->data['OrderSeller']['id'];
				$this->OrderSeller->saveField('seller_note',$this->data['OrderSeller']['seller_note']);
				$this->set('saved_msg','Saved');
			}else{
				$this->set('errors',$this->OrderSeller->validationErrors);
			}
		}
		$this->data = $this->OrderSeller->find('first',array('conditions'=>array('OrderSeller.id'=>$this->data['OrderSeller']['id']),'fields'=>array('OrderSeller.id','OrderSeller.seller_note')));
		$this->viewPath = 'elements/seller' ;
		$this->render('seller_note');
	}

	/** 
	@function : check_sellersOrder
	@description : to validate that a given order is belonged to that given seller or not
	@params : 
	@Modify : 
	@Created Date : Feb 23,2011
	@Created By : Ramanpreet Pal Kaur
	*/
	function check_sellersOrder($order_id = null,$seller_id = null){
		App::import('Model','OrderSeller');
		$this->OrderSeller = new OrderSeller();
		$this->OrderSeller->expects(array('Order'));
		$is_loggedin_sellersOrder = $this->OrderSeller->find('first',array('conditions'=>array('OrderSeller.order_id'=>$order_id,'OrderSeller.seller_id'=>$seller_id,'Order.deleted'=>'0','Order.payment_status'=>'Y'),'fields'=>array('OrderSeller.id')));
		if(empty($is_loggedin_sellersOrder)){
			return false;
		} else{
			return true;
		}
	}

	/** 
	@function: cancel_order
	@description: to cancel an order by seller
	@Created by: Ramanpreet Pal
	@Created:  24 Feb 2011
	@Modify:  
	*/
	function cancel_order($order_id = null){

		$order_id = base64_decode($order_id);
		$this->set('order_id',$order_id);
		$this->set('title_for_layout','Choiceful.com Marketplace: My Marketplace - Marketplace Order Management');
		$carriers = $this->Common->getcarriers();
		$this->set('carriers',$carriers);
		$countries = $this->Common->getcountries();
		$reasons = $this->Common->getcancel_reasons();
		$this->set('reasons',$reasons);
		$pro_conditions = $this->Common->get_new_used_conditions();
		$this->set('countries',$countries);
		$this->set('pro_conditions',$pro_conditions);
		$this->layout = 'marketplace_fullscreen';
		$seller_id = $this->Session->read('User.id');
		$order_flag = 0;
		$order_flag = $this->check_sellersOrder($order_id,$seller_id);
		if(empty($order_flag)){
			$this->Session->setFlash('You are trying to access an invaild order.','default',array('class'=>'flashError'));
			$this->redirect('/sellers/orders');
		}
		App::import('Model','OrderSeller');
		$this->OrderSeller = new OrderSeller();
		App::import('Model','OrderItem');
		$this->OrderItem = new OrderItem();
		
// 		App::import('Model','OrderRefund');
// 		$this->OrderRefund = new OrderRefund();
		App::import('Model','Order');
		$this->Order = new Order();
		$ordre_seller_amount = $this->Ordercom->getTotalSaleOrderSeller($order_id,$seller_id);
		if(!empty($this->data)){
			$this->OrderSeller->set($this->data);
			if($this->OrderSeller->validates()){
				$os_id = $this->OrderSeller->find('first',array('conditions'=>array('OrderSeller.order_id'=>$order_id,'OrderSeller.seller_id'=>$seller_id),'fields'=>array('OrderSeller.id','OrderSeller.shipping_status')));

				$order_info_for_refund = $this->Order->find('first',array('conditions'=>array('Order.id'=>$order_id),'fields'=>array('Order.id','Order.user_id')));
				$ordre_seller_amount = $this->Ordercom->getTotalSaleOrderSeller($order_id,$seller_id);

// 				$this->data['OrderRefund']['order_id'] = $order_id;
// 				$this->data['OrderRefund']['seller_id'] = $seller_id;
// 				$this->data['OrderRefund']['user_id'] = $order_info_for_refund['Order']['user_id'];
// 				$this->data['OrderRefund']['amount'] = $ordre_seller_amount;
// 
// 				$this->data['OrderRefund']['reason_id'] = 12;

				$this->data['OrderSeller']['cancel_type'] = $os_id['OrderSeller']['shipping_status'];

				$this->data['OrderSeller']['shipping_status'] = 'Cancelled';
				$this->data['OrderSeller']['id'] = $os_id['OrderSeller']['id'];
				$this->OrderSeller->set($this->data);
				if($this->OrderSeller->save()){
// 					$this->OrderRefund->save($this->data);
					$this->Ordercom->cancelOrderAllitems($order_id,$seller_id,$this->data['OrderSeller']['reason_id']);
					
					$this->Session->setFlash('The selected item(s) have been cancelled');
					$this->redirect('/sellers/cancel_order/'.base64_encode($order_id));
				} else{
					$this->Session->setFlash('Order has not been cancelled, please try again','default',array('class'=>'flashError'));
				}
			} else{
				$errorArray = $this->OrderSeller->validationErrors;
				$this->set('errors',$errorArray);
			}
		}
		$order_details = $this->get_order_details($order_id);
		$this->set('order_details',$order_details);
	}
	
	/** 
	@function: packing_slip
	@description: to print a packing slip
	@Created by: Ramanpreet Pal
	@Created:  24 Feb 2011
	@Modify:  
	*/
	function packing_slip($order_id = null) {
		$this->layout = 'ajax';
		$countries = $this->Common->getcountries();
		$pro_conditions = $this->Common->get_new_used_conditions();
		$this->set('countries',$countries);
		$this->set('pro_conditions',$pro_conditions);
		$seller_id = $this->Session->read('User.id');
		$order_flag = 0;
		$order_flag = $this->check_sellersOrder($order_id,$seller_id);
		if(empty($order_flag)){
			$this->Session->setFlash('You are trying to access an invaild order.','default',array('class'=>'flashError'));
			$this->redirect('/sellers/orders');
		}
		$order_details = $this->get_order_details($order_id);
		$this->set('order_details',$order_details);
	}


	/** 
	@function: refund_order
	@description: to drefund order
	@Created by: Ramanpreet Pal
	@Created:  7 March 2011
	@Modify:  
	*/
	function refund_order($order_id = null){
		$order_id = base64_decode($order_id);
		$reasons = $this->Common->getcancel_reasons();
		$this->set('title_for_layout','Choiceful.com Marketplace: My Marketplace - Marketplace Order Management');
		$this->set('reasons',$reasons);
		$refundreasons = $this->Common->getrefund_reasons_seller();
		$this->set('refundreasons',$refundreasons);
		$this->set('order_id',$order_id);
		$carriers = $this->Common->getcarriers();
		$countries = $this->Common->getcountries();
		$pro_conditions = $this->Common->get_new_used_conditions();
		$this->set('carriers',$carriers);
		$this->set('countries',$countries);
		$this->set('pro_conditions',$pro_conditions);
		$this->layout = 'marketplace_fullscreen';
		$seller_id = $this->Session->read('User.id');
		$order_flag = 0;

		$order_flag = $this->check_sellersOrder($order_id,$seller_id);
		if(empty($order_flag)) {
			$this->Session->setFlash('You are trying to access an invaild order.','default',array('class'=>'flashError'));
			$this->redirect('/sellers/orders');
		}
		App::import('Model','OrderRefund');
		$this->OrderRefund = new OrderRefund();
		if(!empty($this->data)){
			App::import('Model','Order');
			$this->Order = new Order();
			App::import('Model','Seller');
			$this->Seller = new Seller();
			$this->OrderSeller->set($this->data);

			if($this->OrderSeller->validates()) { 
				$this->Order->expects(array('User'));
				$user_info = $this->Order->find('first',array('conditions'=>array('Order.id'=>$order_id),'fields'=>array('Order.user_id','Order.order_number','User.id','User.firstname','User.lastname','User.email')));
				$seller_info = $this->Seller->find('first',array('conditions'=>array('Seller.user_id'=>$seller_id),'fields'=>array('Seller.business_display_name','Seller.image')));
				$this->data['OrderRefund']['memo'] = $this->data['OrderSeller']['memo'];
				if($this->data['OrderRefund']['memo'] == 'Enter a note that will be sent to buyer')
				$this->data['OrderRefund']['memo'] = '';
				$this->data['OrderRefund'] = $this->data['OrderSeller'];
				$this->data['OrderRefund']['order_id'] = $order_id;
				$this->data['OrderRefund']['order_number'] = $user_info['Order']['order_number'];
				$this->data['OrderRefund']['seller_id'] = $seller_id;
				$this->data['OrderRefund']['user_id'] = $user_info['User']['id'];
				$this->data['OrderRefund']['firstname'] = $user_info['User']['firstname'];
				$this->data['OrderRefund']['lastname'] = $user_info['User']['lastname'];
				$this->data['OrderRefund']['email'] = $user_info['User']['email'];
				$this->data['OrderRefund']['seller_name'] = $seller_info['Seller']['business_display_name'];
				$this->OrderRefund->set($this->data);
				if($this->OrderRefund->save()) {
					$this->sendRefundMailToCustomer();
					$message = "You have successfully authorized a refund to the customer. <a href = ".SITE_URL."pages/view/returns-and-efunds>Learn more</a>";
					$this->Session->setFlash($message);
				} else{
					$this->Session->setFlash('Information not updated');
				}
			} else{
				foreach($this->data['OrderSeller'] as $field_index => $info){
					$this->data['OrderSeller'][$field_index] = html_entity_decode($info);
					$this->data['OrderSeller'][$field_index] = str_replace('&#039;',"'",$this->data['OrderSeller'][$field_index]);
				}
				$errorArray = $this->OrderSeller->validationErrors;
				$this->set('errors',$errorArray);
			}
		}
		
		$refund_details = $this->OrderRefund->find('all',array('conditions'=>array('OrderRefund.order_id'=>$order_id)));
		$total_refundes = 0;
		if(!empty($refund_details)){
			$total_refundes = $this->OrderRefund->find('all',array('conditions'=>array('OrderRefund.order_id'=>$order_id),'fields'=>array('sum(amount) as total_amount')));
			if(!empty($total_refundes[0][0]['total_amount'])){
				$total_refundes = $total_refundes[0][0]['total_amount'];
			}
		}
		$order_details = $this->get_order_details($order_id);
		$order_details['Refunds'] = $refund_details;
		$this->set('order_details',$order_details);
		$this->set('total_refundes',$total_refundes);
	}


	/** 
	@function : sendRefundMailToCustomer
	@description : to send a mail to customer after refunding amount to the customer
	@Created by : Ramanpreet Pal Kaur
	@params : NULL
	@Modify : 7 MArch,2011
	@Created Date : 7 MArch,2011
	*/
	function sendRefundMailToCustomer(){
		$reasons = $this->Common->getrefund_reasons_seller();
		$this->Email->smtpOptions = array(
			'host' => Configure::read('host'),
			'username' =>Configure::read('username'),
			'password' => Configure::read('password'),
			'timeout' => Configure::read('timeout')
		);
		$this->Email->from = Configure::read('fromEmail');
		$this->Email->replyTo=Configure::read('replytoEmail');
		$this->Email->sendAs= 'html';
		$link=Configure::read('siteUrl');
		App::import('Model','EmailTemplate');
		$this->EmailTemplate = new EmailTemplate;
		/**
		table: email_templates
		id: 23
		description: Mail to customer
		*/
		$template = $this->Common->getEmailTemplate(23)
;
		if(!empty($template['EmailTemplate']['from_email']))
			$this->Email->from = $template['EmailTemplate']['from_email'];
		
		$data=$template['EmailTemplate']['description'];
		$this->Email->from = $template['EmailTemplate']['from_email'];
		
		//Following 2 lines is added to make link on order-number @Oct 17
		$orderId = base64_encode($this->data['OrderRefund']['order_id']);
		$or_number = '<a href="'.SITE_URL.'sellers/order_details/'.$orderId.'">'.$this->data['OrderRefund']['order_number'].'</a>';
		
		$data = str_replace('[OrderNumber]',$or_number,$data);
		$data = str_replace('[RefundAmount]',CURRENCY_SYMBOL.''.round($this->data['OrderRefund']['amount'],2),$data);
		$data = str_replace('[ReasonSelected]',$reasons[$this->data['OrderRefund']['reason_id']],$data);
		$data = str_replace('[MemotoBuyer]',$this->data['OrderRefund']['memo'],$data);
		$data = str_replace('[SellerDisplayName]',$this->data['OrderRefund']['seller_name'],$data);
		$data = str_replace('[CustomerFirstName]',$this->data['OrderRefund']['firstname'],$data);
		//following line is added on Oct 17
		$data = str_replace('[CustomerLastName]',$this->data['OrderRefund']['lastname'],$data);
		$data = str_replace('[DayDateYear]',date('m/d/Y'),$data);
		$template['EmailTemplate']['subject'] = str_replace('[OrderNumber]',$this->data['OrderRefund']['order_number'],$template['EmailTemplate']['subject']);

		$this->Email->subject = $template['EmailTemplate']['subject'];
		$this->set('data',$data);
		$this->Email->to = $this->data['OrderRefund']['email'];
		/******import emailTemplate Model and get template****/
		$this->Email->template='commanEmailTemplate';
		$this->Email->send();
		$this->data = '';
	}

	
	/** 
	@function: cancel_orderitems
	@description: to display details of order to cancel items from that order
	@Created by: Ramanpreet Pal
	@Created:  April 18, 2011
	@Modify:  
	*/
	function cancel_orderitems($order_id = null){
		$this->set('order_id',base64_decode($order_id));
		$order_id = base64_decode($order_id);
		$this->set('title_for_layout','Choiceful.com Marketplace: My Marketplace - Marketplace Order Management');
		$seller_id = $this->Session->read('User.id');
		$order_flag = 0;
		$order_flag = $this->check_sellersOrder($order_id,$seller_id);
		if(empty($order_flag)) {
			$this->Session->setFlash('You are trying to access an invaild order.','default',array('class'=>'flashError'));
			$this->redirect('/sellers/orders');
		}
		$carriers = $this->Common->getcarriers();
		$countries = $this->Common->getcountries();
		$pro_conditions = $this->Common->get_new_used_conditions();
		$reasons = $this->Common->getcancel_reasons();
		$this->set('reasons',$reasons);
		$this->set('carriers',$carriers);
		$this->set('countries',$countries);
		$this->set('pro_conditions',$pro_conditions);
		$cancel_item_qty_list = $this->Ordercom->canceled_orderitem_qty($order_id,$seller_id);
		$ship_item_qty_list = $this->Ordercom->dispatcheded_orderitem_qty($order_id,$seller_id);
		$this->set('cancel_item_qty_list',$cancel_item_qty_list);
		$this->set('ship_item_qty_list',$ship_item_qty_list);
		$this->layout = 'marketplace_fullscreen';
		if(!empty($this->data)){
			
			$this->data = $this->cleardata($this->data);
			//$this->data = Sanitize::clean($this->data, array('encode' => false));
			
			App::import('Model','OrderSeller');
			$this->OrderSeller = new OrderSeller();
			App::import('Model','CanceledItem');
			$this->CanceledItem = new CanceledItem();
			$this->data['CanceledItem']['seller_id'] = $seller_id;
			$this->OrderSeller->set($this->data);
			if($this->OrderSeller->validates()) {
				$os_id = $this->OrderSeller->find('first',array('conditions'=>array('OrderSeller.order_id'=>$order_id,'OrderSeller.seller_id'=>$seller_id),'fields'=>array('OrderSeller.id')));
				$this->data['OrderSeller']['id'] = $os_id['OrderSeller']['id'];
				$qty_flag = 0;
				if(!empty($this->data['OrderSeller']['Items'])){
					foreach($this->data['OrderSeller']['Items'] as $item_id => $item_detail){
						if(!empty($item_detail['cancel_qty'])){
							$qty_flag = 1;
							break;
						} else{}
					}
				}
				if(!empty($qty_flag)){
					if(!empty($this->data['OrderSeller']['Items'])){
						$this->data['CanceledItem']['reason_id'] = $this->data['OrderSeller']['reason_id'];
						$this->data['CanceledItem']['order_id'] = $order_id;
						$this->data['CanceledItem']['seller_id'] = $seller_id;
						foreach($this->data['OrderSeller']['Items'] as $item_id => $item_detail){
							if(!empty($item_detail['cancel_qty'])){
								$this->data['CanceledItem']['id'] = 0;
								$this->data['CanceledItem']['order_item_id'] = $item_id;
								$this->data['CanceledItem']['quantity'] = $item_detail['cancel_qty'];
								$this->data['CanceledItem']['item_price'] = $item_detail['orderitem_price'];
								$this->CanceledItem->set($this->data);
								$this->CanceledItem->save();
								$cancel_item_qty = $this->Ordercom->canceled_orderitem_qty($order_id,$seller_id,$item_id);
								$dispatch_item_qty = $this->Ordercom->dispatcheded_orderitem_qty($order_id,$seller_id,$item_id);
							}
						}
						$total_or_items = $this->Ordercom->orderitem_qty($order_id,$seller_id);
						$cancel_item_qty = $this->Ordercom->canceled_orderitem_qty($order_id,$seller_id);
						$dispatch_item_qty = $this->Ordercom->dispatcheded_orderitem_qty($order_id,$seller_id);
						if(!empty($total_or_items)){
							foreach($total_or_items as $item_index=>$item_qty){
								if(!empty($cancel_item_qty[$item_index])){
									$cancel_qty_itm = $cancel_item_qty[$item_index];
								} else{
									$cancel_qty_itm = 0;
								}
								if(!empty($dispatch_item_qty[$item_index])){
									$disp_qty_itm = $dispatch_item_qty[$item_index];
								} else{
									$disp_qty_itm = 0;
								}

								if($item_qty == $disp_qty_itm + $cancel_qty_itm){
									$shipping_status_flag[] = 'S';
								} else{
									$shipping_status_flag[] = 'PS';
								}
							}
						}

						if(in_array('PS',$shipping_status_flag)){
							$this->data['OrderSeller']['shipping_status'] = 'Part Shipped';
						} else {
							$this->data['OrderSeller']['shipping_status'] = 'Shipped';
						}
						$this->OrderSeller->set($this->data);
						$this->OrderSeller->save($this->data);
					}
					$this->data = '';
					$this->Session->setFlash('Order Items cancelled successfully');
					$this->redirect('/sellers/cancel_orderitems/'.base64_encode($order_id));
				} else{
					$this->Session->setFlash('Please select some quantity for any item to cancel.','default',array('class'=>'flashError'));
				}
			} else{
				$errorArray = $this->OrderSeller->validationErrors;
				$this->set('errors',$errorArray);
			}
		}
		$order_details = $this->get_order_details($order_id);
		$this->set('order_details',$order_details);
	}


	/** 
	@function: getShippingStatus
	@description: to get shipping status of an order for a selected seller
	@Created by: Ramanpreet Pal
	@Created:  April 22, 2011
	@Modify:  
	*/

	function getShippingStatus($order_id = null, $seller_id = null){
		App::import('Model','OrderSeller');
		$this->OrderSeller = new OrderSeller();
		$order_seller_info = $this->OrderSeller->find('first',array('conditions'=>array('OrderSeller.order_id'=>$order_id,'OrderSeller.seller_id'=>$seller_id),'fields'=>array('OrderSeller.shipping_status')));
		return $order_seller_info['OrderSeller']['shipping_status'];
	}


	function edit_shipment_info($order_id = null,$editorder= null){
		
		if(empty($this->data['OrderSeller']['shipment_number'])){
			$this->data = '';
			$this->redirect('/sellers/ship_order/'.base64_encode($order_id).'/'.base64_encode($editorder));
		}
		App::import('Model','DispatchedItem');
		$this->DispatchedItem = new DispatchedItem();
		$this->set('editorder',$editorder);
		$this->set('order_id',$order_id);
		$seller_id = $this->Session->read('User.id');

		$reasons = $this->Common->getcancel_reasons();
		$carriers = $this->Common->getcarriers();
		$countries = $this->Common->getcountries();
		$pro_conditions = $this->Common->get_new_used_conditions();
		$shipment_number_list = $this->DispatchedItem->find('list',array('conditions'=>array('DispatchedItem.seller_id'=>$seller_id,'DispatchedItem.order_id'=>$order_id),'group'=>array('DispatchedItem.shipment_number'),'fields'=>array('DispatchedItem.shipment_number','DispatchedItem.shipment_number')));

		//$shipment_number_list_new[0] = 'Add New';
		if(!empty($shipment_number_list)){
			foreach($shipment_number_list as $sh_index => $sh_number){
				$shipment_number_list_new[$sh_index] = 'Shipment '.$sh_number;
			}
		}
		$shipment_number = $this->data['OrderSeller']['shipment_number'];
		$cancel_item_qty_list = $this->Ordercom->canceled_orderitem_qty($order_id,$seller_id);
		//$ship_item_qty_list = $this->Ordercom->dispatcheded_orderitem_qty($order_id,$seller_id);

		$creteria_dispatchitems = array('DispatchedItem.order_id'=>$order_id,'DispatchedItem.seller_id'=>$seller_id,'DispatchedItem.shipment_number != '.$shipment_number);

		$dispatched_items = $this->DispatchedItem->find('all',array('conditions'=>$creteria_dispatchitems,'fields'=>array('SUM(quantity) as total_quantity','DispatchedItem.order_item_id'),'group'=>array('DispatchedItem.order_item_id')));
		$dispatchitem_arr = array();
		if(!empty($dispatched_items)){
			foreach($dispatched_items as $dispatched_item){
				$dispatchitem_arr[$dispatched_item['DispatchedItem']['order_item_id']] = $dispatched_item[0]['total_quantity'];
			}
		}

		$this->set('ship_item_qty_list',$dispatchitem_arr);
		$this->set('shipment_number_list',$shipment_number_list_new);
		$this->set('reasons',$reasons);
		$this->set('carriers',$carriers);
		$this->set('countries',$countries);
		$this->set('pro_conditions',$pro_conditions);
		$this->set('cancel_item_qty_list',$cancel_item_qty_list);

		App::import('Model','OrderSeller');
		$this->OrderSeller = new OrderSeller();
		
		$all_dispatched_shipment_number = $this->DispatchedItem->find('all',array('conditions'=>array('DispatchedItem.order_id'=>$order_id,'DispatchedItem.seller_id'=>$seller_id,'DispatchedItem.shipment_number'=>$shipment_number)));
		//pr($all_dispatched_shipment_number);
		if(!empty($all_dispatched_shipment_number)){
			$this->data['OrderSeller']['shipping_date'] = $all_dispatched_shipment_number[0]['DispatchedItem']['shipping_date'];
			$this->data['OrderSeller']['shipping_carrier'] = $all_dispatched_shipment_number[0]['DispatchedItem']['shipping_carrier'];
			$this->data['OrderSeller']['shipping_service'] = $all_dispatched_shipment_number[0]['DispatchedItem']['shipping_service'];
			$this->data['OrderSeller']['trackingId'] = $all_dispatched_shipment_number[0]['DispatchedItem']['tracking_id'];
			$this->data['OrderSeller']['other_carrier'] = $all_dispatched_shipment_number[0]['DispatchedItem']['other_carrier'];
			if(!empty($this->data['OrderSeller']['shipping_date'])){
				$this->data['OrderSeller']['shipping_date'] = date('Y-m-d',strtotime($this->data['OrderSeller']['shipping_date']));
				$new_ship_date_array = explode('-',$this->data['OrderSeller']['shipping_date']);
				$new_ship_date = $new_ship_date_array[2].'/'.$new_ship_date_array[1].'/'.$new_ship_date_array[0];
				$this->data['OrderSeller']['shipping_date'] = $new_ship_date;
			}


			//data[OrderSeller][Items][18][]

			foreach($all_dispatched_shipment_number as $shipment_index=>$shipped_item){
// pr($shipped_item);
				$this->data['OrderSeller']['Items'][$shipped_item['DispatchedItem']['order_item_id']]['dispatch_qty'] = $shipped_item['DispatchedItem']['quantity'];
			}
		}
		//pr($all_dispatched_shipment_number);

		$order_details = $this->get_order_details_shipment($order_id,$shipment_number);
		$this->set('order_details',$order_details);
		$this->layout = 'ajax';
		$this->viewPath = 'elements/seller' ;
		$this->render('orderdetails_edit');
	}



	/** 
	@function: get_order_details
	@description: to fetch details for an given order_id
	@Created by: Ramanpreet Pal
	@Created:  23 Feb 2011
	@Modify:  
	*/
	function get_order_details_shipment($order_id = null,$shipment_number = null){
		App::import('Model','OrderSeller');
		$this->OrderSeller = new OrderSeller();
		$fields = array(
			'OrderSeller.id','OrderSeller.seller_note',
			'OrderSeller.order_id',
			'OrderSeller.seller_id',
			'OrderSeller.dispatch_date',
			'OrderSeller.shipping_carrier',
			'OrderSeller.shipping_status',
			'OrderSeller.shipping_service',
			'OrderSeller.created',
			'OrderSeller.modified',
			'Order.shipping_user_title',
			'Order.shipping_firstname',
			'Order.shipping_lastname',
			'Order.shipping_address1',
			'Order.shipping_address2',
			'Order.shipping_phone',
			'Order.shipping_postal_code',
			'Order.shipping_city',
			'Order.shipping_state',
			'Order.shipping_country',
			'Order.order_total_cost',
			'Order.id',
			'Order.order_number',
			'Order.created',
			'Order.comments',
		);
		$this->OrderSeller->expects(array('SellerSummary','Order'));
		$this->OrderSeller->Order->expects(array('UserSummary'));
		$this->OrderSeller->recursive = 2;
		$seller_id = $this->Session->read('User.id');
		$order_details = $this->OrderSeller->find('first',array('conditions'=>array('OrderSeller.order_id'=>$order_id,'OrderSeller.seller_id'=>$seller_id),'fields'=>$fields));
		$this->data['OrderSeller']['seller_note'] = $order_details['OrderSeller']['seller_note'];
		$this->data['OrderSeller']['id'] = $order_details['OrderSeller']['id'];

		App::import('Model','OrderItem');
		$this->OrderItem = new OrderItem();
		if(!empty($order_details)){
			$this->OrderItem->expects(array('ProductSeller','DispatchedItem'));
			$items = $this->OrderItem->find('all',array('conditions'=>array('OrderItem.order_id'=>$order_details['OrderSeller']['order_id'],'OrderItem.seller_id'=>$order_details['OrderSeller']['seller_id']),'fields'=>array('distinct(OrderItem.id)','OrderItem.order_id','OrderItem.seller_id','OrderItem.product_id','OrderItem.condition_id','OrderItem.quantity','OrderItem.price','OrderItem.delivery_method','OrderItem.delivery_cost','OrderItem.estimated_delivery_date','OrderItem.giftwrap','OrderItem.giftwrap_cost','OrderItem.gift_note','OrderItem.product_name','OrderItem.quick_code','OrderItem.seller_name','OrderItem.estimated_dispatch_date','ProductSeller.reference_code','ProductSeller.notes')));
			App::import('Model','DispatchedItem');
			$this->DispatchedItem = new DispatchedItem();
			$dispatched_items = $this->DispatchedItem->find('all',array('conditions'=>array('DispatchedItem.order_id'=>$order_details['OrderSeller']['order_id'],'DispatchedItem.seller_id'=>$order_details['OrderSeller']['seller_id']),'fields'=>array('DispatchedItem.id','DispatchedItem.order_id','DispatchedItem.seller_id','DispatchedItem.order_item_id','DispatchedItem.shipping_date','DispatchedItem.shipping_carrier','DispatchedItem.other_carrier','DispatchedItem.shipping_service','DispatchedItem.tracking_id','DispatchedItem.quantity','DispatchedItem.created','DispatchedItem.shipment_number'),'group'=>array('DispatchedItem.shipment_number')));

			if(!empty($dispatched_items)){
				$this->DispatchedItem->expects(array('OrderItem'));
				foreach($dispatched_items as $disitem_index => $disItems){
					$dis_itm_name_qty = '';$cancel_itm_name_qty = '';
					$dis_items = $this->DispatchedItem->find('all',array('conditions'=>array('DispatchedItem.shipping_date'=>$disItems['DispatchedItem']['shipping_date'],'DispatchedItem.shipment_number'=>$disItems['DispatchedItem']['shipment_number'],'DispatchedItem.seller_id'=>$order_details['OrderSeller']['seller_id'],'DispatchedItem.order_id'=>$order_details['OrderSeller']['order_id']),'fields'=>array('OrderItem.product_name','DispatchedItem.quantity','DispatchedItem.order_item_id','DispatchedItem.shipping_date')));
					foreach($dis_items as $dis_item_name){
						if(empty($dis_itm_name_qty))
							$dis_itm_name_qty = $dis_item_name['OrderItem']['product_name'].' x <strong>'.$dis_item_name['DispatchedItem']['quantity'].'</strong>';
						else
							$dis_itm_name_qty = $dis_itm_name_qty.',<br /> '.$dis_item_name['OrderItem']['product_name'].' x <strong>'.$dis_item_name['DispatchedItem']['quantity'].'</strong>';
					}
					$dispatched_items[$disitem_index]['DispatchedItem']['item_name'] = $dis_itm_name_qty;
				}
			}
			$order_details['DispatchedItems'] = $dispatched_items;

			
			App::import('Model','CanceledItem');
			$this->CanceledItem = new CanceledItem();
			$canceled_items = $this->CanceledItem->find('all',array('conditions'=>array('CanceledItem.order_id'=>$order_details['OrderSeller']['order_id'],'CanceledItem.seller_id'=>$order_details['OrderSeller']['seller_id']),'fields'=>array('CanceledItem.id','CanceledItem.created'),'group'=>'CanceledItem.created'));
			if(!empty($canceled_items)){
				$this->CanceledItem->expects(array('OrderItem'));
				foreach($canceled_items as $cancelitem_index => $cancelItems){
					$cancel_itm_name_qty = '';
					$cancel_items = $this->CanceledItem->find('all',array('conditions'=>array('CanceledItem.created'=>$cancelItems['CanceledItem']['created'],'CanceledItem.seller_id'=>$order_details['OrderSeller']['seller_id'],'CanceledItem.order_id'=>$order_details['OrderSeller']['order_id']),'fields'=>array('OrderItem.product_name','CanceledItem.quantity','CanceledItem.order_item_id','CanceledItem.reason_id','CanceledItem.created')));
					foreach($cancel_items as $cancel_item_name){
						if(empty($cancel_itm_name_qty))
							$cancel_itm_name_qty = $cancel_item_name['OrderItem']['product_name'].' x <strong>'.$cancel_item_name['CanceledItem']['quantity'].'</strong>';
						else
							$cancel_itm_name_qty = $cancel_itm_name_qty.', '.$cancel_item_name['OrderItem']['product_name'].' x <strong>'.$cancel_item_name['CanceledItem']['quantity'].'</strong>';
						$canceled_items[$cancelitem_index]['CanceledItem']['reason_id'] = $cancel_item_name['CanceledItem']['reason_id'];
					}
					$canceled_items[$cancelitem_index]['CanceledItem']['item_name'] = $cancel_itm_name_qty;
				}
			}
			$order_details['CanceledItems'] = $canceled_items;

			
			App::import('Model','Feedback');
			$this->Feedback = new Feedback();
			$items_feedback = array();
			if(!empty($items)){
				$i = 0;
				foreach($items as $item){
					$feedback = $this->Feedback->find('first',array('conditions'=>array('Feedback.order_id'=>$order_details['OrderSeller']['order_id'],'Feedback.order_item_id'=>$item['OrderItem']['id'],'Feedback.seller_id'=>$order_details['OrderSeller']['seller_id'])));
					if(!empty($feedback)) {
						$items_feedback[$i]['feedback'] = $feedback['Feedback']['feedback'];
						$items_feedback[$i]['item_name'] = $item['OrderItem']['product_name'];
					}
					$i++;
				}
				$order_details['Feedback'] = $items_feedback;
				$order_details['Items'] = $items;
			}
		}
		return $order_details;
	}



	function sendShipmentMail($mailData = null){
		App::import('Model','Order');
		$this->Order = new Order();
		App::import('Model','OrderItem');
		$this->OrderItem = new OrderItem();

		$this->loadModel('Carrier');
		$carrerInfo = $this->Carrier->find('first',array('conditions'=>array('Carrier.id'=>$mailData['shipping_carrier'])));
		//echo '<pre>'; print_r($carrerInfo); die;

		$carriers = $this->Common->getcarriers();
		$countries = $this->Common->getcountries();

		$this->Order->expects(array('UserSummary'));
		if(!empty($mailData['order_id'])){
			if($mailData['shipping_carrier'] == 8 || $mailData['shipping_carrier'] == 9)
				$carrier = $mailData['other_carrier'];
			else
				$carrier = $mailData['shipping_carrier'];

			
			$order_info = $this->Order->find('first',array('conditions'=>array('Order.id'=>$mailData['order_id']),'fields'=>array('Order.created','Order.order_number','Order.shipping_firstname','Order.shipping_lastname','Order.shipping_address1','Order.shipping_address2','Order.shipping_city','Order.shipping_state','Order.shipping_postal_code','Order.shipping_country','UserSummary.id','UserSummary.firstname','UserSummary.lastname','UserSummary.email')));

			$order_items = $this->OrderItem->find('all',array('conditions'=>array('OrderItem.order_id'=>$mailData['order_id']),'fields'=>array('OrderItem.id','OrderItem.order_id','OrderItem.price','OrderItem.quantity','OrderItem.product_name','OrderItem.estimated_dispatch_date','OrderItem.seller_id','OrderItem.seller_name','OrderItem.estimated_delivery_date','OrderItem.delivery_method'),'order'=>array('OrderItem.estimated_delivery_date DESC')));

			$estimate_delivery_date = '';
			$ordred_items = '';

			$seller_name_str ='';
			if(!empty($order_items)){
				if(!empty($order_items[0]['OrderItem']['estimated_delivery_date'])){
					$estimate_delivery_date = $order_items[0]['OrderItem']['estimated_delivery_date'];
					foreach($order_items as $order_item){

						$dispatch_method[] = $order_item['OrderItem']['delivery_method'];
						if(empty($ordred_items)){
							$ordred_items = $order_item['OrderItem']['quantity'].' X '.$order_item['OrderItem']['product_name'].' - '.$order_item['OrderItem']['price'];
						} else {
							$ordred_items = $ordred_items.'<br>'.$order_item['OrderItem']['quantity'].' X '.$order_item['OrderItem']['product_name'].' - '.$order_item['OrderItem']['price'];
						}
						$sellersArr[$order_item['OrderItem']['seller_id']] = $order_item['OrderItem']['seller_name'];
					}

					if(!empty($sellersArr)){
						foreach($sellersArr as $seller_id=>$seller_name){
							if(empty($seller_name_str)){
								$seller_name_str = '<a href="'.SITE_URL.'sellers/summary/'.$seller_id.'">'.$seller_name.'</a>';
							} else{
								$seller_name_str = $seller_name_str.' , '.'<a href="'.SITE_URL.'sellers/summary/'.$seller_id.'">'.$seller_name.'</a>';
							}
						}
					}
				} else {
					$estimate_delivery_date = '';
					foreach($order_items as $order_item){
						if(!empty($order_item['OrderItem']['estimated_delivery_date'])){
							if(empty($estimate_delivery_date)){
								$estimate_delivery_date = $order_item['OrderItem']['estimated_delivery_date'];
							} else {
								if(strtotime($estimate_delivery_date) < strtotime($order_item['OrderItem']['estimated_delivery_date'])){
									$estimate_delivery_date = $order_item['OrderItem']['estimated_delivery_date'];
								}
							}
						} else {
							
						}
						$dispatch_method[] = $order_item['OrderItem']['delivery_method'];
						if(empty($ordred_items)){
							$ordred_items = $order_item['OrderItem']['quantity'].' X '.$order_item['OrderItem']['product_name'].' - '.$order_item['OrderItem']['price'];
						} else {
							$ordred_items = $ordred_items.'<br>'.$order_item['OrderItem']['quantity'].' X '.$order_item['OrderItem']['product_name'].' - '.$order_item['OrderItem']['price'];
						}
						$sellersArr[$order_item['OrderItem']['seller_id']] = $order_item['OrderItem']['seller_name'];
					}

					if(!empty($sellersArr)){
						foreach($sellersArr as $seller_id=>$seller_name){
							if(empty($seller_name_str)){
								$seller_name_str = '<a href="'.SITE_URL.'sellers/summary/'.$seller_id.'">'.$seller_name.'</a>';
							} else{
								$seller_name_str = $seller_name_str.' , '.'<a href="'.SITE_URL.'sellers/summary/'.$seller_id.'">'.$seller_name.'</a>';
							}
						}
					}

				}
			}
			if(in_array('E',$dispatch_method)){
				$disp_metd = 'Express';
			} else {
				$disp_metd = 'Standard';
			}
			/** Send email after ship order **/
			$this->Email->smtpOptions = array(
				'host' => Configure::read('host'),
				'username' =>Configure::read('username'),
				'password' => Configure::read('password'),
				'timeout' => Configure::read('timeout')
			);
			$this->Email->replyTo=Configure::read('replytoEmail');
			$this->Email->sendAs= 'html';
			$link=Configure::read('siteUrl');
			
			/** import emailTemplate Model and get template **/
			App::import('Model','EmailTemplate');
			$this->EmailTemplate = new EmailTemplate;
			/**
			table: email_templates
			id: 7
			description: Customer registration
			*/
			$template = $this->Common->getEmailTemplate(7);
			$this->Email->from = Configure::read('fromEmail');
			if(!empty($template['EmailTemplate']['from_email'])){
				$this->Email->from = $template['EmailTemplate']['from_email'];
			}
			$data = $template['EmailTemplate']['description'];
			$this->Email->subject = $template['EmailTemplate']['subject'];

			$data = str_replace('[CustomerFirstName]',$order_info['UserSummary']['firstname'],$data);
			$data = str_replace('[CustomerLastName]',$order_info['UserSummary']['lastname'],$data);
			$data = str_replace('[OrderDate]',date('d F, Y',strtotime($order_info['Order']['created'])),$data);
			$data = str_replace('[Qty] [ItemName]',$mailData['ship_product_str'],$data);
			$data = str_replace('[ShippingMethod]',$disp_metd,$data);
			//$data = str_replace('[CarrierName]',$carrier,$data); // Comment: Oct. 16
			$data = str_replace('CarrierName',$carrerInfo['Carrier']['title'],$data);
			$data = str_replace('[ShippingService]',$mailData['shipping_service'],$data);
			$data = str_replace('[ShipDate]',date('d F, Y',strtotime($mailData['dispatch_date'])),$data);
			$data = str_replace('[EstimateDateDayYear]',date('d F, Y',strtotime($estimate_delivery_date)),$data);
			$data = str_replace('[ordernumber]',$order_info['Order']['order_number'],$data);
			$data = str_replace('[OrderNumberLink]','<a href="'.SITE_URL.'orders/order_history">'.$order_info['Order']['order_number'].'</a>',$data);
			$data = str_replace('[DeliveryCustomerFirstName]',$order_info['Order']['shipping_firstname'],$data);
			$data = str_replace('[DeliveryCustomerLastName]',$order_info['Order']['shipping_lastname'],$data);
			/*address lines*/
			$billingAddress = ($order_info['Order']['shipping_address2']!='')? "<br/>".$order_info['Order']['shipping_address2']: "";
			$billingAddress = $order_info['Order']['shipping_address1'].$billingAddress;
			$data = str_replace('[DeliveryAddressLine1]',$billingAddress,$data);
			
			/*
			$data = str_replace('[DeliveryAddressLine1]',$order_info['Order']['shipping_address1'],$data);
			if(!empty($order_info['Order']['shipping_address2'])){
				$data = str_replace('[DeliveryAddressLine2]',$order_info['Order']['shipping_address2'],$data);
			} else{
				$data = str_replace('[DeliveryAddressLine2]','',$data);
			}
			*/
			$data = str_replace('[DeliveryTown/City]',$order_info['Order']['shipping_city'],$data);
			$data = str_replace('[DeliveryCounty]',$order_info['Order']['shipping_state'],$data);
			$data = str_replace('[DeliveryPostcode]',$order_info['Order']['shipping_postal_code'],$data);

			$country = $countries[$order_info['Order']['shipping_country']];

			$data = str_replace('[DeliveryCountry]',$country,$data);

			$data = str_replace('[QtyItemName-Price]',$ordred_items,$data);
			$data = str_replace('[DeliveryMethodSelected]',$disp_metd,$data);
			$data = str_replace('[SellersDisplayName]',$seller_name_str,$data);
			
			$this->set('data',$data);
			$this->Email->to = $order_info['UserSummary']['email'];
// 			/******import emailTemplate Model and get template****/
			$this->Email->template='commanEmailTemplate';
			$this->Email->send();
		}
	}


	function admin_feedback(){
		$this->checkSessionAdmin();
		$user_id = $this->Session->read('SESSION_ADMIN.id');
		$this->layout='layout_admin';
			
		App::import('Model','Feedback');
		$this->Feedback = new Feedback;
			
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
		/** **************************************** **/
		$this->set('title_for_layout','Manage Feedbacks for Sellers');
		$value = '';	
		$show = '';
		$matchshow = '';
		$fieldname = '';
		$criteria = '';
		/** SEARCHING **/
		$reqData = $this->data;
		$options['All'] = 'All';
		$options['customer_name'] = "Customer Name";
		$options['seller_name'] = "Seller Name";
		$options['item_name'] = "Item Name";
		$this->set('options',$options);
		if(!empty($this->data['Search'])){
			if(!empty($this->data['Search']['searchin'])){
				$fieldname = $this->data['Search']['searchin'];
			} else{
				$fieldname = 'All';
			}
			$value = $this->data['Search']['keyword'];
			if(!empty($this->data['Search']['show'])){
				$show = $this->data['Search']['show'];
			} else{
				$show = 'All';
			}
			App::import('Sanitize');
			$value1 = Sanitize::escape($value);
			if($value !="") {
				if(trim($fieldname)=='All'){
					$new_value1 = explode(' ',$value1);
					$first_name = $new_value1[0];
					if(!empty($new_value1[1])){
						$last_name = trim($new_value1[1]);
					} else{
						$last_name = $new_value1[0];
					}
					if(empty($criteria)){
						$criteria = "User.firstname LIKE '%".$first_name."%' OR User.lastname LIKE '%".$last_name."%' OR SellerSummary.firstname LIKE '%".$first_name."%' OR SellerSummary.lastname LIKE '%".$last_name."%' OR OrderItem.product_name LIKE '%".$value1."%'";
					} else {
						$criteria .= " and (User.firstname LIKE '%".$first_name."%' OR User.lastname LIKE '%".$last_name."%' OR SellerSummary.firstname LIKE '%".$first_name."%' OR SellerSummary.lastname LIKE '%".$last_name."%' OR OrderItem.product_name LIKE '%".$value1."%')";
					}
				} else {
					if(trim($fieldname)!=''){
						if($fieldname == 'customer_name'){
							$new_value1 = explode(' ',$value1);
							$first_name = $new_value1[0];
							if(!empty($new_value1[1])){
								$last_name = trim($new_value1[1]);
							} else{
								$last_name = $new_value1[0];
							}

							if(empty($criteria)){
								$criteria = "User.firstname LIKE '%".$first_name."%' OR User.lastname LIKE '%".$value1."%'";
							} else {
								$criteria .= " and (User.firstname LIKE '%".$first_name."%' OR User.lastname LIKE '%".$value1."%')";
							}
						} else if($fieldname == 'seller_name'){
							$new_value1 = explode(' ',$value1);
							$first_name = $new_value1[0];
							if(!empty($new_value1[1])){
								$last_name = trim($new_value1[1]);
							} else{
								$last_name = $new_value1[0];
							}
							if(empty($criteria)){
								$criteria = "SellerSummary.firstname LIKE '%".$first_name."%' OR SellerSummary.lastname LIKE '%".$last_name."%'";
							} else {
								$criteria .= " and (SellerSummary.firstname LIKE '%".$first_name."%' OR SellerSummary.lastname LIKE '%".$last_name."%')";
							}
						} else if($fieldname == 'item_name'){
							if(empty($criteria)){
								$criteria = "OrderItem.product_name LIKE '%".$value1."%'";
							} else {
								$criteria .= " and (OrderItem.product_name LIKE '%".$value1."%')";
							}
						} else {
						}
					}
				}
			}
		}
		$this->set('keyword', $value);
		$this->set('fieldname',$fieldname);
		$this->set('heading','Manage Feedbacks for Sellers');
		/* ******************* page limit sction **************** */
		$sess_limit_name = $this->params['controller']."_seller_feedback_limit";
		$sess_limit_value = $this->Session->read($sess_limit_name);
		if(!empty($this->data['Record']['limit'])){
		   $limit = $this->data['Record']['limit'];
		   $this->Session->write($sess_limit_name , $this->data['Record']['limit'] );
		}elseif( !empty($sess_limit_value) ){
			$limit = $sess_limit_value;
		}else{
			$limit = $this->records_per_page;  // set default value
		}
		$this->data['Record']['limit'] = $limit;
		/* ******************* page limit sction **************** */
		$this->paginate = array(
			'limit' => $limit,
			'order' => array(
				'Feedback.created' => 'DESC'
			),
			'fields' => array(
				'Feedback.id',
				'Feedback.created',
				'Feedback.rating',
				'Feedback.user_id',
				'Feedback.seller_id',
				'Feedback.order_item_id',
				'User.id',
				'User.firstname',
				'User.lastname',
				'SellerSummary.id',
				'SellerSummary.firstname',
				'SellerSummary.lastname',
// 				'SellerInfo.user_id',
// 				'SellerInfo.business_display_name',
				'OrderItem.product_name'
			)
		);
		$this->Feedback->expects(array('User','SellerSummary','OrderItem'/*,'SellerInfo'*/));
		//pr($this->paginate('Feedback',$criteria));
		$this->set('feedbacksArr',$this->paginate('Feedback',$criteria));
	}


	/** 
	@function: admin_add
	@description: to add new seller or update existing seller
	@Created by: Ramanpreet Pal
	@params	
	@Modify: NULL
	@Created Date: 
	*/
	function admin_edit_feedback($id = null) {
		if(!is_null($id) ){
			$id = base64_decode($id);
		}
		$this->checkSessionAdmin();
		$this->set('id',$id);
		App::import('Model','Feedback');
		$this->Feedback = new Feedback;
		$this->layout = 'layout_admin';
		$this->set('listTitle','Edit Feedback');
			
		if(!empty($this->data)) {
			if(!empty($this->params['form']['t'])){
				$this->data['Feedback']['rating'] = $this->params['form']['t'];
			}
			$this->data['Feedback']['id'] = $id;
			$this->Feedback->set($this->data);
			if($this->Feedback->validates()){
				if($this->Feedback->save($this->data)){
					$this->Session->setFlash('Record has updated successfully.');
					$this->redirect('/admin/sellers/feedback');
				} else {
					$this->Session->setFlash('Record has not been updated.','default',array('class'=>'flashError'));
					$this->redirect('/admin/sellers/edit_feedback/'.base64_encode($id));
				}
			} else {
				$errorArray = $this->Feedback->validationErrors;
				$this->set('errors',$errorArray);
				
			}
			//pr($this->params); die;
		} else{
			if(!empty($id)) {
				$this->Feedback->id = $id;
				$this->Feedback->expects(array('User','SellerSummary','OrderItem'));
				$this->data = $this->Feedback->find('first',array('conditions'=>array('Feedback.id'=>$id),'fields'=>array('Feedback.id','Feedback.feedback','Feedback.rating','Feedback.seller_id','Feedback.user_id','Feedback.order_item_id','User.firstname','User.lastname','SellerSummary.firstname','SellerSummary.lastname','OrderItem.product_name')));
			}
		}
	}

	/** 
	@function: store2
	@description: to display all products oam a given seller
	@Created by: Ramanpreet Pal Kaur
	@params: $seller_id
	@Modify:
	@Created Date: June 23, 2011
	*/
	function store($seller_id = null){
		if($this->RequestHandler->isAjax()==0)
 			$this->layout = 'search_product_user';
 		else
			$this->layout = 'ajax';
		if($this->is_really_int($seller_id)){
			$seller_id = mysql_real_escape_string(trim($seller_id));
		} else {
			$this->Session->setFlash('Not a vaild seller\'s store.','default',array('class'=>'flashError'));
			$this->redirect('/');
		}
		//$this->set('title_for_layout','Please define this using the seller display name as such: "Seller Business Display Name" Marketplace Store @ Choiceful.com');
		$this->set('seller_id',$seller_id);
		$myRecentProducts = array();
		
		##################  get  history products from cookies ################
		App::import('Model','ProductVisit');
		$this->ProductVisit = new ProductVisit;
		$myRecentProducts = $this->ProductVisit->getMyVisitedProducts();
		
		$this->set('myRecentProducts',$myRecentProducts);
		/*for Product condition array*/
		$conditions = $this->Common->get_new_used_conditions();
		$this->set('conditions',$conditions);
		
		
		//$this->data['Seller']['id'] = $seller_id;
		$this->data['Seller']['sort1'] = 'bestselling';
		if(!empty($this->data['Seller']['sort1'])){
			if($this->data['Seller']['sort1'] == 'bestselling')
				$sort = array();
			else
				$sort = $this->data['Seller']['sort1'];
		}
		
		$seller_info = $this->Seller->find('first',array('conditions'=>array('Seller.user_id'=>$seller_id),'fields'=>array('Seller.business_display_name','Seller.image','Seller.free_delivery','Seller.threshold_order_value')));
		$this->set('seller_info',$seller_info);
		$sell_disp_name = $seller_info['Seller']['business_display_name'];
		$this->set('title_for_layout','"'.$sell_disp_name.'" Marketplace Store @ Choiceful.com');
		
		$free_delivery_over = 0;
		if(!empty($seller_info)){
			if(!empty($seller_info['Seller']['free_delivery'])){
				$free_delivery_over = $seller_info['Seller']['threshold_order_value'];
			}
		}
		$this->set('free_delivery_over',$free_delivery_over);
		#############################################
		
		$items = array();$results =array(); $facetmap = array();
		$ws_location = WS_LOCATION;
		//Create a new soap client
		$client = new SoapClient($ws_location, array('login'=>'choiceful', 'password'=>'aiteiyienole'));
		$search_result = array();
		$continue_shopping = array();
		$continue_shopping_slogan = array();
		$view_size = VIEW_SIZE_FH;
		
		$this->set('view_size',$view_size);
		
		//Build the query string
		$fh_location = '';
			
		if(!empty($this->params['url'])){
			foreach($this->params['url'] as $url_index => $url_fh){
				if($url_index != 'url'){
					if(empty($fh_location)){
						$fh_location = $url_index."=".$url_fh;
					} else {
						$fh_location = $fh_location."&".$url_index."=".$url_fh;
					}
				}
			}
		}
		$paging_flag = 1;
		if(empty($fh_location)){
			$fh_location="special-page-id=marketplace-seller&fh_location=//catalog01/en_GB/";
			//http://bm.prepublished.live1.fas.fredhopperservices.com/preview/?special-page-id=marketplace-seller&fh_location=//catalog01/en_GB/seller_id=240384
			if(!empty($seller_id)){
				if(!empty($this->data['Marketplace']['keywords'])){
					$seller_id = $seller_id;
				}else{
					$seller_id = $seller_id;
				}
				
			}	
			$fh_location = $fh_location.'seller_id='.$seller_id;
			if(!empty($this->data['Product']['sort'])){
				$sort_by = $this->data['Product']['sort'];
			}else{
				$sort_by = "";		
			}
			
			$this->set('sort_by',$sort_by);
			
			//START on 10/02/2012 for left menu price search		
			if(!empty($this->data['Sellers']['price']) && empty($this->data['Sellers']['price1'])){
				$fh_location = $fh_location.'/minimum_price>'.$this->data['Sellers']['price'];
			}
			if(!empty($this->data['Sellers']['price1']) && empty($this->data['Sellers']['price'])){
				$fh_location = $fh_location.'/minimum_price<'.$this->data['Sellers']['price1'];
			}
			if(!empty($this->data['Sellers']['price']) && !empty($this->data['Sellers']['price1'])){
				$fh_location = $fh_location.'/'.$this->data['Sellers']['price'].'<minimum_price<'.$this->data['Sellers']['price1'];
			}
			//END on 10/02/2012 for left menu price search
				
				
			$fh_location = $fh_location."&preview_advanced=true&fh_view_size=$view_size&fh_start_index=0";
			$pass_url = $fh_location."&preview_advanced=true&fh_view_size=$view_size&fh_start_index=0";
			
			$paging_flag = 0;
		} else {
			//$fh_location = '?fh_eds=ß&'.$fh_location;
			$pass_url = $fh_location;
			$fh_location = str_replace('~','/',$fh_location);
			$fh_location = $fh_location;
			$paging_flag = 1;
		}
		//echo $fh_location;
		$result = $client->__soapCall('getAll', array('fh_params' => $fh_location));
		//echo "<PRE>";
		//print_r($result);
		
		foreach($result->universes->universe as $r) {
			if($r->{"type"} == "selected"){
				//Extract & print the breadcrumbs from the result
					
				if(!empty($r->facetmap))
					$facetmap = (array)$r->facetmap;
				if(!empty($r->breadcrumbs))
					$breadcrumbs = (array)$r->breadcrumbs;
				if(!empty($r->themes))
					$themes = (array)$r->themes;
					//pr($themes);
					//For Continue Shopping Start
					$themes_continue = $themes['theme'];
					if(!empty($themes_continue)){
						foreach($themes_continue as $themes_continue){
							if(!empty($themes_continue->{'custom-fields'}->{'custom-field'}->_)){
							if($themes_continue->{'custom-fields'}->{'custom-field'}->_ == 'Customers Also Bought'){
									if(!empty($themes_continue->items)){
										if(count($themes_continue->items->item) == 1){
											$continue_shopping[0] = $themes_continue->items->item;
											$continue_shopping_slogan = $themes_continue->slogan;
										}else{
											$continue_shopping = $themes_continue->items->item;
											$continue_shopping_slogan = $themes_continue->slogan;
										}
									}
								}
							}
							
						}
					}
					//For Continue Shopping END
					
				if($fh_location != '?fh_location=//catalog01/en_GB/') {
					//Extract & print the item information from the result
					if(!empty($r->{"items-section"})){
						if(!empty($r->{"items-section"}->items)) {
							$items = (array)$r->{"items-section"}->items;
						}
						if(!empty($r->{"items-section"}->results)) {
							$results = (array)$r->{"items-section"}->results;
						}
					}
				}
				// added on 17 May 2012
				
			}
		}	
				
			if(!empty($items['item'])){
			if(empty($items['item']->attribute)) {
				$k = 0;
				foreach($items['item'] as $item) {
					
					foreach($item->attribute as $attribute){
						if($attribute->name == 'secondid' && !empty($attribute->value->_)){
							$seller_store[$k]['secondid'] = $attribute->value->_;
						}
						if($attribute->name == 'product_name' && !empty($attribute->value->_)){
							$seller_store[$k]['product_name'] = $attribute->value->_;
						}
						if($attribute->name == 'product_image' && !empty($attribute->value->_)){
							$seller_store[$k]['product_image'] = $attribute->value->_;
						}
						if($attribute->name == 'avg_rating' && !empty($attribute->value->_)){
							$seller_store[$k]['avg_rating'] = $attribute->value->_;
						}
						if($attribute->name == 'product_rrp' && !empty($attribute->value->_)){
							$seller_store[$k]['product_rrp'] = $attribute->value->_;
						}
						if($attribute->name == 'minimum_price_used' && !empty($attribute->value->_)){
							$seller_store[$k]['minimum_price_used'] = $attribute->value->_;
						}
						if($attribute->name == 'minimum_price_value' && !empty($attribute->value->_)){
							$seller_store[$k]['minimum_price_value'] = $attribute->value->_;
						}
						if($attribute->name == 'minimum_price_seller' && !empty($attribute->value->_)){
							$seller_store[$k]['minimum_price_seller'] = $attribute->value->_;
						}
						if($attribute->name == 'minimum_price_used_seller' && !empty($attribute->value->_)){
							$seller_store[$k]['minimum_price_used_seller'] = $attribute->value->_;
						}
						if($attribute->name == 'condition_new' && !empty($attribute->value->_)){
							$seller_store[$k]['condition_new'] = $attribute->value->_;
						}
						if($attribute->name == 'condition_used' && !empty($attribute->value->_)){
							$seller_store[$k]['condition_used'] = $attribute->value->_;
						}
					}
					
				$k++;	
				}
			}else{
				$k = 0;
					foreach($items['item']->attribute as $attribute){
						if($attribute->name == 'secondid'){
							$seller_store[$k]['secondid'] = $attribute->value->_;
						}
						if($attribute->name == 'product_name'){
							$seller_store[$k]['product_name'] = $attribute->value->_;
						}
						if($attribute->name == 'product_image'){
							$seller_store[$k]['product_image'] = $attribute->value->_;
						}
						if($attribute->name == 'avg_rating'){
							$seller_store[$k]['avg_rating'] = $attribute->value->_;
						}
						if($attribute->name == 'product_rrp'){
							$seller_store[$k]['product_rrp'] = $attribute->value->_;
						}
						if($attribute->name == 'minimum_price_used'){
							$seller_store[$k]['minimum_price_used'] = $attribute->value->_;
						}
						if($attribute->name == 'minimum_price_value'){
							$seller_store[$k]['minimum_price_value'] = $attribute->value->_;
						}
						if($attribute->name == 'minimum_price_seller'){
							$seller_store[$k]['minimum_price_seller'] = $attribute->value->_;
						}
						if($attribute->name == 'minimum_price_used_seller'){
							$seller_store[$k]['minimum_price_used_seller'] = $attribute->value->_;
						}
						if($attribute->name == 'condition_new'){
							$seller_store[$k]['condition_new'] = $attribute->value->_;
						}
						if($attribute->name == 'condition_used'){
							$seller_store[$k]['condition_used'] = $attribute->value->_;
						}
					}
				$k++;
			}
			
			}
			
		if(!empty($items['item']))
			$items = $items['item'];
			
			
		/*if(!empty($items)){
			if(count($items) == 1){
				$qc_code = $items->attribute[0]->value->_;
				$pr_id_info = $this->Product->find('first',array('conditions'=>array('Product.quick_code'=>$qc_code),'fields'=>array('Product.id')));
				$pr_id = @$pr_id_info['Product']['id'];
				if(!empty($pr_id)){
					$this->redirect('/categories/productdetail/'.$pr_id);
				} else {
					$this->redirect('/');
				}
			}
		}*/
		
		/** Paging parameters **/
		if(!empty($results)) {
			$total_records = $results['total_items'];
			$no_records_page = $results['view_size'];
			
			if(empty($no_records_page)){
				$no_records_page = 1;
			}
			$no_of_pages = (int) ($total_records / $no_records_page).'<br>';
			
			$remain_items = $total_records % $no_records_page;
			if(!empty($remain_items)) {
				$no_of_pages = $no_of_pages + 1;
				$last_page_starts = $total_records - $remain_items;
			} else {
				$last_page_starts = ($no_of_pages-1)*$no_records_page;
				
			}
			
			$results['last_page_starts'] = $last_page_starts;
			$results['no_of_pages'] = $no_of_pages;
			
		}
		
		###################  Add product data to the product visit ################
		App::import('Model','ProductVisit');
		$this->ProductVisit = new ProductVisit;
		$myRecentProducts = $this->ProductVisit->getMyVisitedProducts();
		$this->set('myRecentProducts',$myRecentProducts);
		
		#############################################	
		/** Paging parameters **/
		$this->set('results',$results);
		$this->set('breadcrumbs',$breadcrumbs);
		$this->set('sort',$sort);
		$this->set('continue_shopping',$continue_shopping);
		$this->set('continue_shopping_slogan',$continue_shopping_slogan);
		//$this->set('items',$items);
		$this->set('seller_store',$seller_store);
		$this->set('facetmap',$facetmap);
		
	}
		
		
	/** 
	@function: admin_delete
	@description: to delete seller from admin
	@Created by: Ramanpreet Pal
	@params	
	@Modify: NULL
	@Created Date: 
	*/
	function admin_undofeedback($id = null) {
		$id = base64_decode($id);
		App::import('Model','Feedback');
		$this->Feedback = new Feedback;
		$this->Feedback->id = $id;
		if($this->Feedback->delete()){
			$this->Session->setFlash('Record has been updated successfully.');
		} else{
			$this->Session->setFlash('Error in updating record.','default',array('class'=>'flashError'));
		}
		$this->redirect('feedback');
	}


	/** 
	@function	:	admin_multiplAction_feedback
	@description	:	Undo multiple feedback record
	@params		:	NULL
	**/
	function admin_multiplAction_feedback(){
		App::import('Model','Feedback');
		$this->Feedback = new Feedback;
		$notsaved_users = '';
// pr($this->data); die;
		if($this->data['Feedback']['status']=='undo'){
			foreach($this->data['select'] as $id){
				if(!empty($id)){
					$this->Feedback->id = $id;
					if($this->Feedback->delete()){
						$this->Session->setFlash('Records have been updated successfully.');
					} else{
						$this->Session->setFlash('Error in updating records.','default',array('class'=>'flashError'));
					}
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
			
		}
		/** for searching and sorting*/
		$this->redirect('/admin/sellers/feedback/keyword:'.$this->data['Search']['keyword'].'/searchin:'.$this->data['Search']['searchin']);
	}


	/** 
	@function: admin_payment_summary
	@description: to display all payment reporta of sellers
	@Created by: Ramanpreet Pal Kaur
	@params	
	@Modify: Jal 1, 2011
	@Created Date: Jul 1, 2011
	*/
	function admin_payment_summary($seller_id = null){
		$this->checkSessionAdmin();
		$user_id = $this->Session->read('SESSION_ADMIN.id');
		$this->layout='layout_admin';
		$this->set('seller_id',$seller_id);
		$this->set('title_for_layout','Manage Payment Reports');
		$start_date = '';
		$end_date = '';

		if(!empty($this->data['Search'])){
			if(!empty($this->data['Search']['start_date'])){
				$start_date = date('Y-m-d',strtotime($this->data['Search']['start_date'])); echo '<br>';
			} else {
				$start_date = date('Y-m-d');
			}
			if(!empty($this->data['Search']['end_date'])){
				$end_dateArr = explode('/',$this->data['Search']['end_date']); echo '<br>';
				$end_date = $end_dateArr[2].'-'.$end_dateArr[1].'-'.$end_dateArr[0];
			} else {
				$end_date = date('Y-m-d');
			}
		}

		if(!empty($seller_id)){
			App::import('Model','PaymentReport');
			$this->PaymentReport = new PaymentReport;
			App::import('Model','User');
			$this->User = new User;

			/* ******************* page limit sction **************** */
			$sess_limit_name = $this->params['controller']."_paymentreport_limit";
			$sess_limit_value = $this->Session->read($sess_limit_name);
			if(!empty($this->data['Record']['limit'])){
			$limit = $this->data['Record']['limit'];
			$this->Session->write($sess_limit_name , $this->data['Record']['limit'] );
			}elseif( !empty($sess_limit_value) ){
				$limit = $sess_limit_value;
			}else{
				$limit = $this->records_per_page;  // set default value
			}
			$this->data['Record']['limit'] = $limit;
			/* ******************* page limit sction **************** */

			$this->paginate = array(
				'limit' => $limit,
				'order' => array(
					'PaymentReport.created' => 'DESC'
				),
				'conditions'=>array('PaymentReport.seller_id' => $seller_id),
				'fields'=>array(
					'PaymentReport.created',
					'PaymentReport.report_name', 
					'PaymentReport.account_info',
				)
			);
			$creteria = '';
			if(!empty($start_date) && !empty($end_date)){
				$creteria = '(PaymentReport.created >= "'.$start_date.'" AND PaymentReport.created <= "'.$end_date.'")';
			}
			$this->PaymentReport->expects(array('User'));

			$seller_payment_info = $this->paginate('PaymentReport',$creteria);

			$this->User->expects(array('Seller'));
			$seller_info = $this->User->find('first',array('conditions'=>array('User.id'=>$seller_id),'fields'=>array('User.id','User.title','User.firstname','User.lastname','User.email','Seller.id','Seller.bank_account_number','Seller.business_display_name' ,'Seller.paypal_account_mail')));

			$this->set('seller_payment_info',$seller_payment_info);
			$this->set('seller_info',$seller_info);

		} else{
			$this->Session->setFlash('Not a vaild seller!','default',array('class'=>'flashError'));
			$this->redirect('/admin/sellers');
		}
	}

	function admin_upload_paymentsummary(){
		
		$this->checkSessionAdmin();
		$user_id = $this->Session->read('SESSION_ADMIN.id');
		$this->layout='layout_admin';
		$this->set('listTitle',"Upload Payment Reports");
		App::import('Model','PaymentReport');
		$this->PaymentReport = new PaymentReport;
		if(!empty($this->data)){
			$this->PaymentReport->set($this->data);
			if($this->data['PaymentReport']['sample_bulk_data']['name'] != '' ){
				$report_info = $this->PaymentReport->find('first',array('conditions'=>array('PaymentReport.report_name'=>$this->data['PaymentReport']['sample_bulk_data']['name'])));
				
				$validationFlag = $this->File->validateCsvFile( $this->data['PaymentReport']['sample_bulk_data']['name'] );
				if( $validationFlag  == true ) {
					$file = $this->data['PaymentReport']['sample_bulk_data']['tmp_name'];
					$skipped_rows = '';
					//ini_set('auto_detect_line_endings', true);
					$handle = fopen($file, 'r');
					$rowchek = fgetcsv($handle, 4096, ",");
					$i = 1;
					while (($row = fgetcsv($handle, 4096, ",")) !== FALSE) {
						
						if($i == 2){
							if($report_info['PaymentReport']['opening_balance'] != trim($row[1])){
								$this->PaymentReport->id = $report_info['PaymentReport']['id'];
								$this->PaymentReport->saveField('opening_balance',trim($row[1]));
							}
						}
						if($i == 3){
							if($report_info['PaymentReport']['closing_balance'] != trim($row[1])){
								$this->PaymentReport->id = $report_info['PaymentReport']['id'];
								$this->PaymentReport->saveField('closing_balance',trim($row[1]));
							}
						}
						if($i == 4){
							if($report_info['PaymentReport']['deposited'] != trim($row[1])){
								$this->PaymentReport->id = $report_info['PaymentReport']['id'];
								$this->PaymentReport->saveField('deposited',trim($row[1]));
							}
						}
						$i++;
					}

					$this->File->destPath =  WWW_ROOT.PATH_PAYMENTREPORT;

					$newName = $this->data['PaymentReport']['sample_bulk_data']['name'];

					$this->File->setFilename($newName);

					$this->File->deleteFile($this->data['PaymentReport']['sample_bulk_data']['name']);


					$fileName  = $this->File->uploadFile($this->data['PaymentReport']['sample_bulk_data']['name'],$this->data['PaymentReport']['sample_bulk_data']['tmp_name']);

					if( !$fileName){
						$this->Session->setFlash('Error in updating the file.','default',array('class'=>'flashError'));
					}else{
						$this->Session->setFlash('Report updated successfully.');
						$this->redirect('/admin/sellers/payment_summary/'.@$report_info['PaymentReport']['seller_id']);
					}
				} else{
					$this->Session->setFlash('Select only csv file to upload !', 'default', array( 'class'=>'flashError') );
				}
			} else {
				$this->Session->setFlash('Please select a file to upload !', 'default', array( 'class'=>'flashError') );
			}
		}
	}
	
	/** 
	@function: admin_panalty
	@description: add penalty to a current seller report
	@Created by: Nakul kumar
	@params	
	@Modify: NULL
	@Created Date:14 sept 2011
	*/
	function admin_penalty($seller_id = null) {
		$this->layout = 'layout_admin';
		Configure::write('debug',2);
		$this->set('listTitle','Add Penalty');
		App:: import('Model','PaymentPenalty');
		$this->PaymentPenalty = new PaymentPenalty;
		if(!empty($seller_id)){
			$this->set('seller_id' , $seller_id);
		}		
		if(!empty($this->data)){
			//pr($this->data);
			$this->PaymentPenalty->set($this->data);
			if($this->PaymentPenalty->validates()){
			$this->data['PaymentPenalty']['seller_id']=$seller_id;
				if($this->PaymentPenalty->save($this->data)){
						$this->Session->setFlash('Record has added successfully.');
						$this->redirect(SITE_URL.'/admin/sellers/penalty/'.$seller_id);
				} else {
						$this->Session->setFlash('Record has not been added.','default',array('class'=>'flashError'));
						$this->redirect(SITE_URL.'/admin/sellers/penalty/'.$seller_id);
				}
			}			
		}
		
		/*if(!is_null($id) ){
			$id = base64_decode($id);
		}
		$this->checkSessionAdmin();
		$this->set('id',$id);
		App::import('Model','Feedback');
		$this->Feedback = new Feedback;
		$this->layout = 'layout_admin';
		$this->set('listTitle','Edit Feedback');

		if(!empty($this->data)) {
			if(!empty($this->params['form']['t'])){
				$this->data['Feedback']['rating'] = $this->params['form']['t'];
			}
			$this->data['Feedback']['id'] = $id;
			$this->Feedback->set($this->data);
			if($this->Feedback->validates()){
				if($this->Feedback->save($this->data)){
					$this->Session->setFlash('Record has updated successfully.');
					$this->redirect('/admin/sellers/feedback');
				} else {
					$this->Session->setFlash('Record has not been updated.','default',array('class'=>'flashError'));
					$this->redirect('/admin/sellers/edit_feedback/'.base64_encode($id));
				}
			} else {
				$errorArray = $this->Feedback->validationErrors;
				$this->set('errors',$errorArray);

			}
			//pr($this->params); die;
		} else{
			if(!empty($id)) {
				$this->Feedback->id = $id;
				$this->Feedback->expects(array('User','SellerSummary','OrderItem'));
				$this->data = $this->Feedback->find('first',array('conditions'=>array('Feedback.id'=>$id),'fields'=>array('Feedback.id','Feedback.feedback','Feedback.rating','Feedback.seller_id','Feedback.user_id','Feedback.order_item_id','User.firstname','User.lastname','SellerSummary.firstname','SellerSummary.lastname','OrderItem.product_name')));
			}
		}*/
	}
	// get getDispatchCountries
	function admin_dispatch_country_list() {
		// import the country DB
		$this->set('title_for_layout','Dispatch Country List');
		$this->layout = 'layout_admin';
		Configure::write('debug',2);
		$disCountries = array();
		App::import("Model","DispatchCountry");
		$this->DispatchCountry = &new DispatchCountry();
		$disCountries =  $this->DispatchCountry->find('all',array('fields'=>array('DispatchCountry.id','DispatchCountry.name')));
		$this->set('disCountries' , $disCountries);
		//return $disCountries;
	}
	
	
}
?>