<?php 
/**
* Users Controller class
* PHP versions 5.1.4
* @date Oct 14, 2010
* @Purpose:This controller handles all the functionalities regarding user management.
* @filesource
* @author     Ramanpreet Pal Kaur
* @revision
* @copyright  Copyright � 2010 smartData
* @version 0.0.1
* Permission  Id for admin module : 1
**/

App::import('Sanitize');
class AdminusersController extends AppController {
	var $name = 'Adminusers';
	var $helpers =  array('Html', 'Form', 'Javascript','Format','Session','Validation');
	var $components =  array('RequestHandler','Email','Common');
	var $paginate =  array();
	var $uses =  array('Adminuser');
	var $permission_id = 1;  // for admin module

	/**
	* @Date: Oct 29, 2010
	* @Method : beforeFilter
	* Created By: kulvinder singh
	* @Purpose: This function is used to check admin user session
	* @Param: none
	* @Return: none 
	**/
	function beforeFilter(){
		//check session other than admin_login page
		if($this->params['action'] != 'admin_login')
		{
			$this->checkSessionAdmin();
			$this->validateAdminModule($this->permission_id);
		} else {
			
		}
	}
	
	/**
	* @Date: Oct 13, 2010
	* @Method : admin_login
	* Created By: Ramanpreet Pal Kaur
	* @Purpose: This function is used for admin login into the system
	* @Param: none
	* @Return: none 
	**/
	function admin_login($referred_url = null) {
		$this->layout = 'layout_admin';
		$user_id = $this->Session->read('SESSION_ADMIN.id');
		if(!empty($user_id))
		$this->redirect('/admin/homes/dashboard');
		$this->set('referred_url' , $referred_url);
		if(!empty($this->data)){
			
			$this->data = $this->cleardata($this->data);
			$this->data = Sanitize::clean($this->data, array('encode' => false));
				
			$user_name = mysql_real_escape_string($this->data['Adminuser']['username']);
			$user_password  = md5(mysql_real_escape_string($this->data['Adminuser']['password']));
			$userinfo = $this->Adminuser->find('first',array('conditions'=>array("Adminuser.username"=>$user_name,"Adminuser.password"=>$user_password)));
			//pr($userinfo); die;
			if(!empty($userinfo['Adminuser']['password']) && ($userinfo['Adminuser']['password'] == $user_password) && ($userinfo['Adminuser']['status'] == '1')) {
				$this->Session->write('SESSION_ADMIN', $userinfo['Adminuser']);
				$this->Session->write('admin_username',$userinfo['Adminuser']['username']);
				if(!empty($referred_url) && !is_null($referred_url) ){
					$referred_url = base64_decode(trim($referred_url));
					$this->redirect('/'.$referred_url);
				}else{
					$this->redirect('/admin/homes/dashboard');
				}
			} else {
				$this->set('errorMsg', 'Username/Password is not correct');
				$this->render();
			}
		} else  {
			$this->set('error', true);
		}
	}

	/**
	* @Date: Oct 13, 2010
	* @Method : admin_logout
	* Created By: Ramanpreet Pal Kaur
	* @Purpose: This function is used to destroy admin session.
	* @Param: none
	* @Return: none 
	**/
	function admin_logout(){
		$this->Session->destroy();
		$this->redirect(array('controller'=>'adminusers','action' => 'dashboard'));
	}
	
	/**
	* @Date: Oct 13, 2010
	* @Method : admin_change_password
	* Created By: Ramanpreet Pal Kaur
	* @Purpose: This function is to change admin password.
	* @Param: none
	* @Return: none 
	**/
	function admin_change_password(){
		$this->set('title_for_layout', 'Change Password');
		$this->layout = 'layout_admin';
		if(!empty($this->data)) {
			$this->Adminuser->set($this->data);
			$errors = array();
			if($this->Adminuser->validates()){
				$this->data['Adminuser'] = $this->data['Adminuser'];
				$userid =  $this->Session->read('SESSION_ADMIN.id');
				$userDetails = $this->Adminuser->findById($userid,array('password','id'));
				if($userDetails['Adminuser']['password'] == md5(mysql_real_escape_string($this->data['Adminuser']['oldPassword']) )){
					$this->Adminuser->id = $userid;
					$this->Adminuser->saveField('password',md5(mysql_real_escape_string($this->data['Adminuser']['newpassword']) ));
					$this->Session->setFlash('Password changed successfully');
					$this->data['Adminuser']['oldPassword'] = '';
					$this->data['Adminuser']['newpassword'] = '';
					$this->data['Adminuser']['confirmpassword'] = '';
				}else{
					$errors[''] = 'Old password does not match our records. Please try again.';
					$this->set('errors',$errors);
				}
			} else{
// echo 'Hi';
				$errors = $this->Adminuser->validationErrors;
				$this->set('errors',$errors);
			}
		}
	}

	/**
	* @Date: Oct 14,2010
	* @Method : admin_forgotpassword
	* Created By: Ramanpreet Pal Kaur
	* @Purpose: This function is to reset admin's password.
	* @Param: none
	* @Return: none 
	**/
	function admin_forgotpassword(){
		$this->pageTitle = "Forgot password";
		$this->layout = 'layout_admin';
		if(!empty($this->data)) {
			if($this->Adminuser->validates()){
				$this->Adminuser->set($this->data);
				$email = $this->data['Adminuser']['email'];
				$userDetails = $this->Adminuser->find('first',array('conditions'=>array("Adminuser.email"=>$email)));
				$newPassword =  $this->get_random_string();
				if($this->verifyEmail('Adminuser',$email)){
					$this->Email->smtpOptions = array(
						'host' => Configure::read('host'),
						'username' =>Configure::read('username'),
						'password' => Configure::read('password'),
						'timeout' => Configure::read('timeout')
					);
					$this->Email->to = $userDetails['Adminuser']['email'];
					
					$this->Email->replyTo=Configure::read('replytoEmail');
					$this->Email->sendAs= 'html';
					App::import('Model','EmailTemplate');
					$this->EmailTemplate = new EmailTemplate;
					/**
					table: 		email_templates
					id:		2
					description:	Admin forget password
					*/
					$template = $this->Common->getEmailTemplate(2);
				
					$data=$template['EmailTemplate']['description'];
					$data=str_replace('[USERNAME]',$userDetails['Adminuser']['username'],$data);
					$data=str_replace('[PASSWORD]',$newPassword,$data);
					$data=str_replace('[FIRST_NAME]',$userDetails['Adminuser']['firstname'],$data);
					$data=str_replace('[LAST_NAME]',$userDetails['Adminuser']['lastname'],$data);
					$link=Configure::read('siteUrl');
					$login_link=$link.'/admin/adminusers/login';
					$data=str_replace('[LOGIN_LINK]',$login_link,$data);
					$data=str_replace('[DATE]',date('m-d-Y',time()),$data);
					$this->Email->subject = $template['EmailTemplate']['subject'];
					$this->Email->from = trim($template['EmailTemplate']['from_email']);
					$this->set('data',$data);
					$this->Email->template='commanEmailTemplate';
					if($this->Email->send()){
						$this->Adminuser->id = $userDetails['Adminuser']['id'];
						$this->Adminuser->saveField('password',md5($newPassword));
						$this->Session->setFlash('An email has been sent to you which contains your new password. Please check your inbox.');
						$this->redirect('/admin/adminusers/login');
					} else {
						$this->Session->setFlash('An error occurred while sending the email to the email address provided by you. Please contact Customer Support at '.@Configure::read('phone').' to reset your email address and password.','default',array('class'=>'flashError'));
						$this->redirect('/admin/adminusers/forgotpassword');
					}
				} else{
					$errors = array();
					$errors[] = 'The email address you entered does not match our records. Please try again.';
					$this->set('errors',$errors);
				}
			} else {
				$errors = array();
				$this->set('errors',$this->Adminuser->validationErrors);
			}
		}
	}

	/** 
	@function	:	admin_multiplAction
	@description	:	Active/Deactive/Delete multiple record
	@params		:	NULL
	@created	:	Oct 14,2010
	@credated by	:	Ramanpreet Pal Kaur
	**/
	function admin_multiplAction(){
		// validate admin users for admin module # 1
		$this->validateAdminModule($this->permission_id);
		if($this->data['Adminuser']['status']=='active'){
			foreach($this->data['select'] as $id){
				if(!empty($id)){
					$this->Adminuser->id=$id;
					$this->Adminuser->saveField('status','1');
					$this->Session->setFlash('Information updated successfully.');
				}
			}
		} elseif($this->data['Adminuser']['status']=='inactive'){
			foreach($this->data['select'] as $id){
				if(!empty($id)){
					$this->Adminuser->id=$id;
					$this->Adminuser->saveField('status','0');
					$this->Session->setFlash('Information updated successfully.');	
				}
			}
		} elseif($this->data['Adminuser']['status']=='del'){
			foreach($this->data['select'] as $id){
				if(!empty($id)){
					$this->Adminuser->delete($id);
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
		if(!empty($this->data['Search']['keyword']) && !empty($this->data['Search']['searchin']) && !empty($this->data['Search']['show']))
			$this->redirect('/admin/adminusers/index/keyword:'.$this->data['Search']['keyword'].'/searchin:'.$this->data['Search']['searchin'].'/showtype:'.$this->data['Search']['show']);
		else
			$this->redirect('/admin/adminusers/index/');
	}

	/**
	*
	* Generate random string of given length
	* @param $length
	* @return $string: Random string
	*
	*/
	/*static */function get_random_string($length = 8) {
		$string = '';
			$string.=time();
		   for ($x = 1; $x <= $length; $x++) {
			  switch ( rand(1, 3) ) {
				//  Add a random digit, 0-9
				case 1:
				$string .= rand(0, 9);
				break;
				//  Add a random upper-case letter
				case 2:
				$string .= chr( rand(65, 90) );
				break;
				//  Add a random lower-case letter
				case 3:
				$string  .= chr( rand(97, 122) );
				break;
			  }
		}
		return $string;
	}

	/**
	*This function checks whether given Email address exists or not
	*@param: void
	**/  
	function verifyEmail($model = null,$email = null){
		App::import('Model',$model);
		$this->$model = new $model;
		$user = $this->$model->find('first', array('conditions' => array($model.'.email LIKE "'.$email.'"')));
		if(!empty($user)){
			return 1;
		} else{
			return 0;
		}
	}

	/** 
	@function	:	admin_profile
	@description	:	to display profile information of logged in admin user
	@params		:	NULL
	@created	:	Oct 14,2010
	@credated by	:	kulvinder
	**/
	function admin_profile() {
		$this->set('title_for_layout', 'Profile Information');
		$this->layout = 'layout_admin';
		$this->Adminuser->id = $this->Session->read('SESSION_ADMIN.id');
		$this->data = $this->Adminuser->read();
	}

	/** 
	@function	:	admin_index
	@description	:	to display list of admin users
	@params		:	NULL
	@created	:	Oct 14,2010
	@credated by	:	Ramanpreet Pal Kaur
	**/
	function admin_index() {
		// validate admin users for admin module # 1
		$this->validateAdminModule($this->permission_id);
		$user_id = $this->Session->read('SESSION_ADMIN.id');
		$this->layout='layout_admin';
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
		$this->set('title_for_layout','Admin Users');
		$value = '';	
		$show = '';
		$matchshow = '';
		$fieldname = '';
		/** SEARCHING **/
		$reqData = $this->data;
		$options['username'] = "Username";
		$options['firstname'] = "Firstname";
		$options['email'] = "Email";
		$showArr = $this->getStatus();
		$this->set('showArr',$showArr);
		$this->set('options',$options);
		if(!empty($this->data['Search'])){
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
			if($show == 'Deactive'){
				$matchshow = '0';
			}
			// sanitze the search data
			App::import('Sanitize');
			$value1 = Sanitize::escape($value);
			
			if($value1 !="") {
				if(trim($fieldname)=='All'){
					$criteria .= " and (Adminuser.firstname LIKE '%".$value1."%' OR Adminuser.username LIKE '%".$value1."%' OR Adminuser.email LIKE '%".$value1."%')";
				} else {
					if(trim($fieldname)!=''){
						if(isset($value) && $value!=="") {
							$criteria .= " and Adminuser.".$fieldname." LIKE '%".$value1."%'";
						}
					}
				}
			}
			if(isset($show) && $show!==""){
				if($show == 'All'){
				} else {
					$criteria .= " and Adminuser.status = '".$matchshow."'";
					$this->set('show',$show);
				}
			}
		}
		$this->set('keyword', $value);
		$this->set('show', $show);
		$this->set('fieldname',$fieldname);
		$this->set('heading','Admin Users');
		
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
			'conditions' => array('Adminuser.id !="'.$user_id.'"'),
			'order' => array(
				'Adminuser.id' => 'DESC'
			),
			'fields' => array(
				'Adminuser.id',
				'Adminuser.firstname',
				'Adminuser.lastname',
				'Adminuser.username',
				'Adminuser.password',
				'Adminuser.type',
				'Adminuser.status',
				'Adminuser.modified',
				'Adminuser.email',
				'Adminuser.created',
			)
		);
		$this->set('users',$this->paginate('Adminuser',$criteria));
		$total_users = $this->Adminuser->find('all',array('conditions'=>array($criteria),'fields'=>array('count(Distinct id) AS totalusers')));
		$this->set('totalusers',$total_users[0][0]['totalusers']);
	}

	/** 
	@function	:	admin_add
	@description	:	to add/edit admin users
	@params		:	NULL
	@created	:	Oct 14,2010
	@credated by	:	Ramanpreet Pal Kaur
	**/
	function admin_add($id = null) {
		// validate admin users for admin module # 1
		$this->validateAdminModule($this->permission_id);
		$this->set('id',$id);
		$logged_in_user_id = $this->Session->read('SESSION_ADMIN.id');
		$this->layout = 'layout_admin';
		if(!empty($id)){
			$this->set('listTitle','Update Admin User');
		} else{
			$this->set('listTitle','Add Admin User');
		}
		$security_que = $this->get_security_question();
		$this->set('security_que',$security_que);
		if(!empty($this->data)){
			$this->Adminuser->set($this->data);
			$userValidate = $this->Adminuser->validates();
			if($userValidate == true){
				uses('sanitize');
				$this->Sanitize = new Sanitize;
				$this->data = $this->Sanitize->clean($this->data);
				if(!empty($this->data['Adminuser']['password1'])){
					$this->data['Adminuser']['password'] = md5($this->data['Adminuser']['password1']);
				} elseif(!empty($this->data['Adminuser']['password_original'])){
					$this->data['Adminuser']['password'] = $this->data['Adminuser']['password_original'];
				} else{
				}
				if(!empty($this->data['Adminuser']['password'])){
					$password_save = md5($this->data['Adminuser']['password']);
				}
				$this->data['Adminuser']['firstname'] = ucwords(strtolower($this->data['Adminuser']['firstname']));
				$this->data['Adminuser']['lastname'] = ucwords(strtolower($this->data['Adminuser']['lastname']));
				$this->Adminuser->set($this->data );
				$this->data['Adminuser'] = Sanitize::clean($this->data['Adminuser']);
				$this->Adminuser->set($this->data);
				if($this->Adminuser->save()) {
					if(empty($this->data['Adminuser']['id'])) {
						$userId = $this->Adminuser->getLastInsertId();
						$this->Adminuser->id = $userId;
						$this->Adminuser->saveField('password',$password_save);
						$this->Session->setFlash("Administrator has been created successfully.");
						$this->redirect('/admin/adminusers/access/'.$userId);
					} else{
						$this->Session->setFlash("Information has been updated successfully.");
						$this->redirect('index');
					}
				}
			} else{
				$this->data['Adminuser']['password'] = '';
				$errorArray = $this->Adminuser->validationErrors;
				$this->set('errors',$errorArray);
			}
		} elseif(!empty($id)) {
			$this->Adminuser->id = $id;
			$conditions = array('Adminuser.id = '.$id,'Adminuser.id !='.$logged_in_user_id);
			$this->data = $this->Adminuser->find('first',array('conditions'=>$conditions));
			$this->data['Adminuser']['password_original'] = $this->data['Adminuser']['password'];
			
			
			if(!empty($this->data['Adminuser'])){
				foreach($this->data['Adminuser'] as $field_index => $info){
					$this->data['Adminuser'][$field_index] = html_entity_decode($info);
					$this->data['Adminuser'][$field_index] = str_replace('&#039;',"'",$this->data['Adminuser'][$field_index]);
					$this->data['Adminuser'][$field_index] = str_replace('\n',"",$this->data['Adminuser'][$field_index]);
				}
			}
			if(empty($this->data)){
				$this->redirect('index');
			}
		}
	}

	/** 
	@function	:	admin_status
	@description	:	to update status of selected admin users
	@params		:	NULL
	@created	:	Oct 14,2010
	@credated by	:	Ramanpreet Pal Kaur
	**/
	function admin_status($id = null,$status= null) {
		// validate admin users for admin module # 1
		 $this->validateAdminModule($this->permission_id);

		if(!empty($id)) {
			$this->data['Adminuser']['id'] = $id;
			if($status == 0){
				$this->data['Adminuser']['status'] = 1;
			} else{
				$this->data['Adminuser']['status'] = 0;
			}
			$this->Adminuser->save($this->data);
		}
		$this->redirect('index');
	}

	/** 
	@function	:	admin_delete
	@description	:	to delete selected admin users
	@params		:	NULL
	@created	:	Oct 14,2010
	@credated by	:	Ramanpreet Pal Kaur
	**/
	function admin_delete($id = null) {
		// validate admin users for admin module # 1
		$this->validateAdminModule($this->permission_id);
		$this->Adminuser->expects(array('AdminuserPermission'));
		$this->Adminuser->deleteAll("Adminuser.id ='".$id."'");
		$this->Session->setFlash("Admin user has been deleted successfully.");
		$this->redirect(array('controller'=>'adminusers','action'=>'index'));
	}

	/** 
	@function	:	admin_access
	@description	:	to assign permissions to admin users
	@params		:	NULL
	@created	:	Oct 14,2010
	@credated by	:	Ramanpreet Pal Kaur
	**/
	function admin_access($id = null) {
		// validate admin users for admin module # 1
		$this->validateAdminModule($this->permission_id);
		$this->layout='layout_admin';
		$this->set('title_for_layout', 'Manage Permissions');
		$this->set('common',$this->Common);
		App::import("Model","Permission");
		$this->Permission=new Permission();
		App::import("Model","AdminuserPermission");
		$this->AdminuserPermission=new AdminuserPermission();
		$permissions = $this->Permission->find('list',array('fields'=>array('id','permission')));
		$this->set('permissions',$permissions);
		if($this->data){
			if(!empty($this->data['Adminuser']['adminuser_id'])){
				$this->set('user_id',$this->data['Adminuser']['adminuser_id']);
				$adminuser = $this->Adminuser->find('first',array('conditions'=>array('Adminuser.id'=>$this->data['Adminuser']['adminuser_id']),'fields'=>array('Adminuser.firstname','Adminuser.lastname')));
				$this->set('adminuser',$adminuser);
				$this->data['AdminuserPermission']['adminuser_id'] = $this->data['Adminuser']['adminuser_id'];
				$this->AdminuserPermission->deleteAll('AdminuserPermission.adminuser_id  = '.$this->data['AdminuserPermission']['adminuser_id']);
				if(!empty($this->data['AdminuserPermissions'])){
					foreach($this->data['AdminuserPermissions'] as $p_id){
						if(!empty($p_id)){
							$this->data['AdminuserPermission']['permission_id'] = $p_id;
							$this->data['AdminuserPermission']['id'] = 0;
							$this->AdminuserPermission->set($this->data);
							$this->AdminuserPermission->save();
						}
					}
					$this->Session->setFlash("Permissions has been updated successfully.");
					$allpermissions = $this->AdminuserPermission->find('all',array('conditions'=>array('AdminuserPermission.adminuser_id'=>$this->data['AdminuserPermission']['adminuser_id'])));
					$this->set('alluserpermissions',$allpermissions);
					$this->redirect('index');
				}
			}
		} else if(!empty($id)){
			$this->set('user_id',$id);
			$adminuser = $this->Adminuser->find('first',array('conditions'=>array('Adminuser.id'=>$id),'fields'=>array('Adminuser.firstname','Adminuser.lastname')));
			$this->set('adminuser',$adminuser);
			$allpermissions = $this->AdminuserPermission->find('all',array('conditions'=>array('AdminuserPermission.adminuser_id'=>$id)));
			$this->set('alluserpermissions',$allpermissions);
		}
	}

	/**
	@function:admin_view 
	@description		view adminuser,
	@Created by: 		Ramanpreet Pal Kaur
	@Modify:		NULL
	@Created Date:		Oct 13,2010
	*/
	function admin_view($id){
		//check that admin is login
		$this->checkSessionAdmin();
		// validate admin users for admin module # 1
		$this->validateAdminModule($this->permission_id);
		$this->_validateId($id);
		$this->layout = 'layout_admin';
		$this->set('list_title','View Admin User');
		$this->Adminuser->id = $id;
		$this->data = $this->Adminuser->read();
	}

	/** 
	@function:		validateId 
	@description:		Validate of ID,
	@params:		id
	@Created by: 		Ramanpreet Pal Kaur
	@Modify:		NULL
	@Created Date:		Oct 13,2010
	*/
	function _validateId($id){
		if(empty($id) || !is_numeric($id)){
			$this->Session->setFlash('Id is missing.','default',array('class'=>'flashError'));
			$this->redirect('/admin/adminusers/index/');
		}
	}

	/** 
	@Created by: 		Ramanpreet Pal Kaur
	@Modify:		NULL
	@Created Date:		Oct 13,2010
	*/
	function get_security_question(){
		$que_array = array(
			"What street did you grow up on?"=>"What street did you grow up on?",
			"What's your mothers maiden name?"=>"What's your mothers maiden name?",
			"What's your pet's name"=>"What's your pet's name",
			"What do you enjoy doing in your spare time?"=>"What do you enjoy doing in your spare time?",
			"What's your father's name?"=>"What's your father's name?",
			"The name of your primary school?"=>"The name of your primary school?",
		);
		return $que_array;
	}

	/** 
	@function	:	admin_updateprofile
	@description	:	to update profile information of logged in user
	@params		:	NULL
	@created	:	Oct 14,2010
	@credated by	:	Ramanpreet Pal Kaur
	**/
	function admin_updateprofile() {
		$logged_in_user_id = $this->Session->read('SESSION_ADMIN.id');
		$this->layout = 'layout_admin';
		$this->set('listTitle','Update Profile');
		$security_que = $this->get_security_question();
		$this->set('security_que',$security_que);
		if(!empty($this->data)){
			$this->Adminuser->set($this->data);
			$userValidate = $this->Adminuser->validates();
			if($userValidate == true){
				// clean data before save
				uses('sanitize');
				$this->Sanitize = new Sanitize;
				$this->data = $this->Sanitize->clean($this->data);
				$this->data['Adminuser'] = Sanitize::clean($this->data['Adminuser']);
				$this->Adminuser->set( $this->data );
				$this->Adminuser->id = $logged_in_user_id;
				if($this->Adminuser->save()){
					$this->Session->setFlash("Information has updated successfully.");
				}
			} else{
				$errorArray = $this->Adminuser->validationErrors;
				$this->set('errors',$errorArray);
			}
		} else {
			$this->Adminuser->id = $logged_in_user_id;
			$conditions = array('Adminuser.id = '.$logged_in_user_id);
			$this->data = $this->Adminuser->find('first',array('conditions'=>$conditions,'fields'=>array('Adminuser.id','Adminuser.firstname','Adminuser.lastname','Adminuser.username','Adminuser.security_que','Adminuser.answer','Adminuser.email')));
		}
	}

	/**
	* @Date: Oct 13, 2010
	* @Method : admin_change_password
	* Created By: Ramanpreet Pal Kaur
	* @Purpose: This function is to change admin password.
	* @Param: none
	* @Return: none 
	**/
	function admin_user_changepassword($id = null){
		$this->set('title_for_layout', 'Change Adminuser Password');
		$this->layout = 'layout_admin';
		$this->set('id',$id);
		if(!empty($this->data)) {
			$errors = array();
			$this->data['Adminuser']['password'] = $this->data['Adminuser']['newpassword'];
			$this->Adminuser->set($this->data);
			if($this->Adminuser->validates()){
				$this->data['Adminuser'] = $this->data['Adminuser'];
				$userid =  $id;
				$userDetails = $this->Adminuser->findById($userid,array('password','id'));
				if(!empty($userDetails)){
					$this->Adminuser->id = $id;
					$this->Adminuser->saveField('password',md5($this->data['Adminuser']['password']));
					$this->Session->setFlash('Password changed successfully');
					$this->redirect('/admin/adminusers/index/');
					$this->data['Adminuser']['newpassword'] = '';
					$this->data['Adminuser']['confirmpassword'] = '';
				} else{
					$this->Session->setFlash('User not exists.','default',array('class'=>'flashError'));
				}
			} else{
				$this->set('errors',$this->Adminuser->validationErrors);
			}
		} else{
		}
	}

/*************** */
}
?>