<?php
/**
	* Communications Controller class
	* PHP versions 5.1.4
	* @date:	Dec 19, 2011
	* @Purpose:	This controller handles all the functionalities regarding seller's messages.
	* @filesource	
	* @author	Tripti Poddar
	* @revision
	* @copyright  	Copyright � 2010 smartData
	* @version 0.0.1 
**/
App::import('Sanitize');
class CommunicationsController extends AppController
{
	var $name =  "Communications";
	var $helpers =  array('Html', 'Form','Common', 'Javascript','Session','Validation','Ajax', 'Format');
	var $components =  array('RequestHandler','Email','Common','File','Session','Cookie');
		
	var $paginate =  array();
	var $uses =  array('Communication');
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
		$includeBeforeFilter = array();
		
		if (in_array($this->params['action'],$includeBeforeFilter))
		{
			
			//check that admin is login
			$this->checkSessionAdmin();
			// validate admin users for this module
			$this->validateAdminModule($this->permission_id); 
			
		}
	}
	


	/** 
	@function:	add_message
	@description	to add reply messages to users by seller
	@Created by: 	Tripti Poddar	
	@params		NULL
	@Created Date:  19 Jan 2011
	@Modified Date: 09 Feb 2011
	*/
	function add_message() {
		$this->checkSessionFrontUser();
		$seller_id = $this->Session->read('User.id');
		if(!empty($seller_id)){
			if(!empty($this->data)){
				$this->Message->set($this->data);
				if($this->Message->validates()){
					$msg_info = $this->Message->find('first',array('conditions'=>array('Message.id'=>$this->data['Message']['reply_id']),'fields'=>array('Message.subject', 'Message.id', 'Message.from_user_id', 'Message.order_item_id')));

					// add the reply
					$this->data['Message']['from_user_id'] = $seller_id;
					if(empty($this->data['Message']['reply_id'])){
						$this->data['Message']['reply_id'] = 0;
					}
					$this->data['Message']['order_item_id']= $msg_info['Message']['order_item_id'];
					$this->Message->set($this->data);
					if($this->Message->save($this->data)){ // save message
						$this->data = '';
						$this->data['Message']['id']= $msg_info['Message']['id'];
						$this->data['Message']['to_read_status'] = 1;
						$this->data['Message']['is_replied'] = 1;

						$this->Message->set($this->data);
						$this->Message->save($this->data);
	
						$this->Session->setFlash('The message has been sent successfully.');
						$this->redirect('/messages/sellers/'.$msg_info['Message']['from_user_id'].'/'.$msg_info['Message']['id']);
					} else{
						$this->Session->setFlash('An error occurred while sending the message. Please contact Customer Support at '.Configure::read('phone').'.','default',array('class'=>'flashError'));
						$this->redirect('/messages/sellers/'.$msg_info['Message']['from_user_id'].'/'.$msg_info['Message']['id']);
					}
				} else{
					$errorArray = $this->Message->validationErrors;
					$this->set('errors',$errorArray);

				}
			}
		} else{
			$this->Session->setFlash('You are not a seller, please update your account as seller.');
			$this->redirect('/homes/');
		}

	}

	
	/** 
	@function:	admin_monitor_communication
	@description	to add reply messages to users by seller
	@Created by: 	Tripti Poddar	
	@params		NULL
	@Created Date:  07 Feb 2011
	@Modified Date: 07 Feb 2011
	*/
	function admin_monitor_communication() {
		$this->checkSessionAdmin();
		$user_id = $this->Session->read('SESSION_ADMIN.id');
		$this->layout='layout_admin';
	}
}
?>