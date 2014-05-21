<?php
/**
	* Messages Controller class
	* PHP versions 5.1.4
	* @date:	Dec 19, 2011
	* @Purpose:	This controller handles all the functionalities regarding seller's messages.
	* @filesource	
	* @author	Tripti Poddar
	* @revision
	* @copyright  	Copyright � 2011 smartData
	* @version 0.0.1 
**/
App::import('Sanitize');
class MessagesController extends AppController {
	var $name =  "Messages";
	var $helpers =  array('Html', 'Form','Common', 'Javascript','Session','Validation','Ajax', 'Format','Js' => array('Mootools'));
	var $components =  array('RequestHandler','Email','Common','File','Session','Cookie');
	var $paginate =  array();
	var $uses =  array('Message');
	var $permission_id = 14;  // for seller module
	
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
			'admin_index','admin_communicated_items','admin_item_msgs','admin_multiplAction','admin_add','admin_delete_allMessages');
		
		if (in_array($this->params['action'],$includeBeforeFilter))
		{
			//check that admin is login
			$this->checkSessionAdmin();
			// validate admin users for this module
			$this->validateAdminModule($this->permission_id);
		}
		// seller section validations
		$includeForSeller = array('sellers','msg_inbox','order_inbox');
		if (in_array($this->params['action'],$includeForSeller))
		{
			// seller's section validations
			$this->validateSeller();
		}
	}

	/** 
	@function:	admin_index
	@description	to display sellers on admin_end
	@Created by: 	Tripti Poddar	
	@params		NULL
	@Created Date:	18 Jan 2011
	@Modified Date: 19 Jan 2011
	*/
	function sellers($order_item_id = null) {
		$this->set('order_item_id',@$order_item_id);
		$this->layout = 'message';
		$this->set('title_for_layout','Choiceful.com Marketplace: My Marketplace - Buyer & Seller Messaging Center');
		$this->checkSessionFrontUser();
		$seller_id = $this->Session->read('User.id');
		$all_seller_msg = $this->Message->find('list',array('conditions'=>array('Message.to_user_id'=>$seller_id,'Message.to_read_status'=>0,'(Message.msg_from = "B" OR Message.msg_from = "A")'),'fields'=>array('Message.id','Message.to_read_status')));
		if(!empty($all_seller_msg)){
			foreach($all_seller_msg as $msg_id=>$msg_status){
				$this->Message->id = $msg_id;
				$this->Message->saveField('to_read_status',1);
			}
			$this->Session->write('msg_sellers_read',1);
		}
		
		if(!empty($this->params['named']['user_id'])){
			$buyer_id = $this->params['named']['user_id'];
			$last_msg_id = $this->Common->lastMsgBuyer($buyer_id);
			$this->set('last_msg_id',$last_msg_id);
		}
		//$this->msg_inbox(); // for inbox element
		$this->order_inbox(); // for order inbox element
	}

	
	/** 
	@function : item_msgs
	@description : to get all messages belonging to a given order item
	@Created by : Ramanpreet Pal Kaur
	@params : order item id and message id
	@Modify : 21 March, 2011
	@Created Date : 21 March, 2011
	*/
	function item_msgs($item_id = null,$msg_id = null){
		$seller_id = $this->Session->read('User.seller_id');
		if(empty($seller_id)){
			$this->Session->setFlash('Your session has expired, please login again.','default',array('class'=>'flashError'));
		} else{
			App::import('Model','OrderItem');
			$this->OrderItem = new OrderItem;
			$this->set('msg_id',$msg_id);
			if(empty($item_id) && !empty($msg_id)){
				$msg_item = $this->Message->find('first',array('conditions'=>array('Message.id'=>$msg_id),'fields'=>array('Message.id','Message.order_item_id','Message.msg_from')));
				$item_id = $msg_item['Message']['order_item_id'];
			}
				
			$this->OrderItem->expects(array('Order'));
			$ordetails = $this->OrderItem->find('first',array('conditions'=>array('OrderItem.id'=>$item_id),'fields'=>array('Order.user_id','Order.order_number','OrderItem.id','OrderItem.order_id','OrderItem.product_name','OrderItem.product_id')));
			$logged_in_userId = $this->Session->read('User.id');
				
			$this->Message->expects(array('FromUserSummary','UserSummary'));
			$prev_msgs = $this->Message->find('all',array('conditions'=>array('Message.order_item_id' => $item_id),'fields'=>array('Message.message', 'Message.created', 'Message.from_user_id','Message.msg_from', 'Message.msg_from', 'Message.to_user_id','FromUserSummary.id', 'FromUserSummary.firstname', 'FromUserSummary.lastname','UserSummary.id', 'UserSummary.firstname', 'UserSummary.lastname'), 'order'=>array('Message.id DESC')));
				
			$this->set('ordetails',$ordetails);
			$this->set('prev_msgs',$prev_msgs);
			$this->data['Message']['to_user_id'] = $ordetails['Order']['user_id'];
			$this->data['Message']['from_user_id'] = $logged_in_userId;
			$this->data['Message']['order_item_id'] = $item_id;
		}
		$this->layout='ajax';
		$this->viewPath = 'elements/message' ;
		$this->render('message_textarea');
	}


	/** 
	@function:	msg_inbox
	@description	to add reply messages to users by seller
	@Created by: 	Tripti Poddar	
	@params		NULL
	@Created Date:  31 Jan 2011
	@Modified Date: 31 Jan 2011
	*/
	function msg_inbox($abc = null) {
		$this->checkSessionFrontUser();
		$user_id = $this->Session->read('User.id');
		//$user_id = false;
		if($user_id){
			$this->Message->expects(array('User'));
			$this->paginate = array(
				'limit' => 10,
				'conditions'=>array('Message.to_user_id'=>$user_id,'Message.msg_from'=>'B', 'Message.reply_id'=>NULL),
				'order' => array('Message.id' => 'DESC'),
				'fields' => array('User.id', 'User.firstname', 'User.lastname', 'Message.id', 'Message.subject', 'Message.message', 'Message.to_user_id', 'Message.from_user_id', 'Message.created', 'Message.reply_id', 'Message.msg_from', 'Message.is_replied')
			);
			$seller_msgs = $this->paginate('Message');
			$this->set('seller_msgs',$seller_msgs);
			if($this->RequestHandler->isAjax()){
				$this->layout='ajax';
				$this->viewPath = 'elements/message' ;
				$this->render('inbox');
			}
		}else{
			echo "SessionExpired";
			die;
		}
	}


	/** 
	@function:	order_inbox
	@description	to reply messages to users by seller on basis of their order
	@Created by: 	Tripti Poddar	
	@params		NULL
	@Created Date:  31 Jan 2011
	@Modified Date: 31 Jan 2011
	*/
	/*function order_inbox($filter = 'ALL') {
		unset($this->params['paging']);
		$this->checkSessionFrontUser();
		$seller_id = $this->Session->read('User.id');
		//$seller_id = false;
		if($seller_id){
		$filter_time = $this->Common->get_filterTime();
		$this->set('filter_time',$filter_time);
		if(!empty($this->params['url']['filter'])){
			$filter = $this->params['url']['filter'];
		}
		if(!empty($this->data['Page']['filter'])){
			$filter = $this->data['Page']['filter'];
		}
		$this->set('filter',$filter);
		$creteria = 1;
		if(in_array($filter,array('1d','3d','7d','15d','30d'))){
			//comment for I'1542
			//$filtertime = str_replace('d','',$filter);
			//$current_date_time = date('Y-m-d H:i:s');
			//$from_day = date('d') - $filtertime;
			//$from_date_time = date('Y').'-'.date('m').'-'.$from_day.' '.date('H:i:s');
			//$creteria = $creteria.' AND Order.created Between "'.$from_date_time.'" AND "'.$current_date_time.'"';
			$filtertime = str_replace('d','',$filter);
			$creteria = $creteria.' AND DATE(Order.created) Between DATE_SUB(CURDATE( ) , INTERVAL '.$filtertime.' DAY) AND CURDATE()';
		} else if(in_array($filter,array('3m','6m','12m'))){
			$filtertime = str_replace('m','',$filter);
			//$current_date_time = date('Y-m-d H:i:s');
			//$from_month = date('m')-$filtertime;
			//$from_date_time = date('Y').'-'.$from_month.'-'.date('d').' '.date('H:i:s');
			//$creteria = $creteria.' AND Order.created Between "'.$from_date_time.'" AND "'.$current_date_time.'"';
			$creteria = $creteria.' AND DATE(Order.created) Between DATE_SUB(CURDATE( ) , INTERVAL '.$filtertime.' MONTH) AND CURDATE()';
		} else{
		}
		App::import('Model','OrderItem');
		$this->OrderItem = new OrderItem;
		$this->OrderItem->expects(array('Order'));
		$this->OrderItem->Order->expects(array('UserSummary'));
		/* ******************* page limit sction **************** */
		/*$this->paginate = array(
			//'limit' => 10,
			'order' => 'Order.created DESC',
			'conditions'=>array('Order.deleted'=>0,'OrderItem.seller_id'=>$seller_id,$creteria),
		'limit'=>'10');
		$this->OrderItem->recursive = 2;
		//pr($this->paginate($this->OrderItem)); exit;
		$this->set('seller_orders',$this->paginate($this->OrderItem));
		if($this->RequestHandler->isAjax()){
			$this->set('ajaxflag',1);
			$this->layout='ajax';
			$this->viewPath = 'elements/message' ;
			$this->render('order_inbox');
		}
		}else{
			if($this->RequestHandler->isAjax()){
				echo "SessionExpired";
				exit;
			}else{
				$this->redirect("/homes/index/");
			}
		}
	}*/
		
	function order_inbox($filter = 'ALL') {
		unset($this->params['paging']);
		$this->checkSessionFrontUser();
		$seller_id = $this->Session->read('User.id');
		//$seller_id = false;
		if($seller_id){
		$filter_time = $this->Common->get_filterTime();
		$this->set('filter_time',$filter_time);
		if(!empty($this->params['url']['filter'])){
			$filter = $this->params['url']['filter'];
		}
		if(!empty($this->data['Page']['filter'])){
			$filter = $this->data['Page']['filter'];
		}
		$this->set('filter',$filter);
		$creteria = 1;
		if(in_array($filter,array('1d','3d','7d','15d','30d'))){
			$filtertime = str_replace('d','',$filter);
			$creteria = $creteria.' AND DATE(Order.created) Between DATE_SUB(CURDATE( ) , INTERVAL '.$filtertime.' DAY) AND CURDATE()';
		} else if(in_array($filter,array('3m','6m','12m'))){
			$filtertime = str_replace('m','',$filter);
			$creteria = $creteria.' AND DATE(Order.created) Between DATE_SUB(CURDATE( ) , INTERVAL '.$filtertime.' MONTH) AND CURDATE()';
		} else{
		}
		App::import('Model','OrderItem');
		$this->OrderItem = new OrderItem;
			
		App::import('Model','OrderSeller');
		$this->OrderSeller = new OrderSeller;
		
		App::import('Model','User');
		$this->User = new User();
		
		//For remove Cancle items form order list
		App::import('Model','CanceledItem');
		$this->CanceledItem = new CanceledItem();
		$cancel_item_id = $this->CanceledItem->find('all',array('conditions'=>array('CanceledItem.preshipped_canceled'=>'2'),'fields'=>array('GROUP_CONCAT(CanceledItem.order_item_id SEPARATOR ",") AS ides')));
		$cancel_item_ides = $cancel_item_id[0][0]['ides'];
		//End for remove chancle items form order list
			
		$this->OrderItem->expects(array('Order','OrderSeller'));
			
		/* ******************* page limit sction **************** */
		$this->paginate = array(
			//'limit' => 10,
			'fields' => array(
			'Order.id',
			'Order.created',
			'Order.order_number',
			'OrderItem.id',
			'OrderItem.product_name',
			'OrderItem.seller_id',
			'OrderSeller.shipping_status',
			'(SELECT GROUP_CONCAT(u.firstname," ",u.lastname) FROM users as u WHERE u.id = Order.user_id) as username',
			'Order.user_id'
			),
			'order' => 'Order.created DESC',
			'conditions'=>array('Order.deleted'=>0,'OrderSeller.shipping_status != "Cancelled"','OrderItem.seller_id'=>$seller_id,'OrderItem.id not in('.$cancel_item_ides.')',$creteria),
		'limit'=>'10');
		$this->set('seller_orders',$this->paginate($this->OrderItem));
		if($this->RequestHandler->isAjax()){
			$this->set('ajaxflag',1);
			$this->layout='ajax';
			$this->viewPath = 'elements/message' ;
			$this->render('order_inbox');
		}
		}else{
			if($this->RequestHandler->isAjax()){
				echo "SessionExpired";
				exit;
			}else{
				$this->redirect("/homes/index/");
			}
		}
	}


	/**
	@function: gotoPage
	@description: 
	@Created by: Ramanpreet Pal
	@Modify:  21 March 2011
	*/

	function gotoPage(){
		$filter = '';
		
		$this->data = $this->cleardata($this->data);
		//$this->data = Sanitize::clean($this->data, array('encode' => false));
		
		if(!empty($this->data['Page']['filter_val'])){
			$filter = $this->data['Page']['filter_val'];
		}
		if(!empty($this->data['Page']['goto_page'])){
			if(!empty($filter)){
				$this->redirect("/messages/order_inbox/".$filter."/page:".$this->data['Page']['goto_page']);
			} else{
				$this->redirect("/messages/order_inbox/page:".$this->data['Page']['goto_page']);
			}
		} else{
			$this->redirect("/messages/order_inbox/");
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
		//$reply_msg_id = $this->data['Message']['id'];
		$this->data['Message']['reply_id'] = $this->data['Message']['msg_id'];
		$this->data['Message']['from_read_status'] = 1;
		$this->data['Message']['msg_from'] = 'S';
		$this->data['Message']['id'] = 0;
		
		if(!empty($this->data)){
			
			$this->data = $this->cleardata($this->data);
			//$this->data = Sanitize::clean($this->data, array('encode' => false));
			
		$this->Message->set($this->data);
		if(!empty($this->data['Message']['message'])) {
			App::import('Model','User');
			$this->User = new User;
			$user_status = $this->User->find('first',array('conditions'=>array('User.id'=>$this->data['Message']['from_user_id']),'fields'=>array('User.msg_status')));
			
			if(!empty($user_status['User']['msg_status'])) {
				if($this->Message->save()){
				/** FUNCTION CALL $this->data['Message']['to_user_id']**/
				$send_email_messages = $this->Common->sendEmailAlert($this->data['Message']['to_user_id']);
					if(!empty($this->data['Message']['msg_id'])) {
						$this->Message->id = $this->data['Message']['msg_id'];
						$this->Message->saveField('is_replied','1');
					}
					$this->sendMessageEmail($this->data['Message']['to_user_id']);
					$this->Session->setFlash('Message has been sent.');
					$this->data['Message']['message'] = '';
					$this->data['Message']['from_user_id'] = '';
					$this->data['Message']['to_user_id'] = '';
					$this->redirect('/messages/sellers');
				} else {
					$this->Session->setFlash('Message has not sent successfully.','default',array('class'=>'flashError'));
				}
			} else{
				$this->Session->setFlash('You have been temporarily suspended from sending any messages due to violation of our conditions of use, please contact us for further information.','default',array('class'=>'flashError'));
			}
		} else {
			$this->Session->setFlash('No message was submitted - Please enter a message.','default',array('class'=>'flashError'));
		}
		}
		$this->redirect('/messages/sellers/');
	}

	/**
	* @Date: July 19, 2010
	* @Method : sendMessageEmail
	* Created By: RAMANPREET PAL KAUR
	* Modified By : 
	* @Purpose: This function is used to send mail when any message sent to him from choiceful
	* @Param: none
	* @Return: none 
	**/
	function sendMessageEmail($user_id = null){

		App::import('Model','User');
		$this->User = new User;

		if(!empty($user_id))
			$user_info = $this->User->find('first',array('conditions'=>array('User.id'=>$user_id),'fields'=>array('User.firstname','User.lastname','User.email')));
		
		$this->Email->smtpOptions = array(
		'host' => Configure::read('host'),
		'username' =>Configure::read('username'),
		'password' => Configure::read('password'),
		'timeout' => Configure::read('timeout')
		);
		$this->Email->sendAs= 'html';
		$link=Configure::read('siteUrl');
		$template = $this->Common->getEmailTemplate('15'); // 13 to mail for update offer status
		$this->Email->from =$template['EmailTemplate']['from_email'];
		$email_data = $template['EmailTemplate']['description'];
		
		################### Email Send  Scripts #####################
		$this->Email->subject = $template['EmailTemplate']['subject'];
		$this->Email->from = $template['EmailTemplate']['from_email'];
		$this->set('data',$email_data);
		$this->Email->to = @$user_info['User']['email'];
		/******import emailTemplate Model and get template****/
		$this->Email->template='commanEmailTemplate';
		
		
		
		$this->Email->send();
		################### Send Order Email Ends Here ###########################
		
	}

	
	/** 
	@function:	admin_index
	@description	to view all users for which communication have been taken place
	@Created by: 	Ramanpreet Pal Kaur
	@params		NULL
	@Created Date: 
	@Modified Date: 
	*/
	
	function admin_index() {
		$this->checkSessionAdmin();
		$pass_url = '';
		$passed_url = '';
		/** for paging and sorting we are setting values */
		$msg_type = '';
		
		if(!empty($this->data)){
			if(!empty($this->data['User']['user_list']) && !empty($this->data['User']['toUser'])){
				$this->redirect('/admin/messages/communicated_items/'.$this->data['User']['toUser'].'/'.$this->data['User']['user_list']);
			}
		}		
				
				
		if(!empty($this->params)){
			if(!empty($this->params['pass'])){
				if(!empty($this->params['pass'][0])) {
					$passed_url = base64_decode($this->params['pass'][0]);
				}
			}
		}
		if(!empty($this->data)) {
			
			if(!empty($this->data['Record'])){
				if(!empty($this->data['Record']['pass_url_value'])){
					$passed_url = base64_decode($this->data['Record']['pass_url_value']);
				}
			}
		}
		
		if(!empty($passed_url)){
			$passeed_url_array = explode('~',$passed_url);
			$search_user = @$passeed_url_array[0];
			$search_user_type = @$passeed_url_array[1];
		}

		if(empty($this->data)){
			if(isset($this->params['named']['keyword']))
				$this->data['Search']['keyword']=$this->params['named']['keyword'];
			else
				$this->data['Search']['keyword']='';
		}
		$value = '';
		$users_list = array();
		
		/* SEARCHING */
		$reqData = $this->data;
		if(!empty($this->data['Search'])) {
			$value = trim($this->data['Search']['keyword']);
			App::import('Sanitize');
			$value1= Sanitize::escape($value);
			if($value!=="") {
				$email = $value1;
				$this->set("keyword",$value);
			}
		}

		App::import('Model','User');
		$this->User = new User;
		if($this->data['Search']['user_type']!='ON') { 
		if(!empty($value1)){
			$user = $this->User->find('first',array('conditions'=>array('User.email'=>$email),'fields'=>array('User.id')));
		} else if(!empty($search_user_type) && !empty($search_user)) {
			$user_data = $this->User->find('first',array('conditions'=>array('User.id'=>$search_user),'fields'=>array('User.email')));
			$value = $this->data['Search']['keyword'] = $user_data['User']['email'];
			$this->data['Search']['user_type'] = $search_user_type;
			$user['User']['id'] = $search_user;
			$this->data['Search']['user_type'] = $search_user_type;
		} else {
			
		}
		}
		else  // added by pradi on 23 April 2013
		{
		//$value = $this->data['Search']['keyword'] ;
		$this->data['Search']['user_type'] = 'ON';
			
		}
		/** sorting and search */
 		if($this->RequestHandler->isAjax()==0)
 			$this->layout = 'layout_admin';
 		else
			$this->layout = 'ajax';
		$this->set('keyword', $value);
		$user_id = $this->Session->read('SESSION_ADMIN.id');
		$this->layout='layout_admin';
		if(!empty($user['User']['id']) || $this->data['Search']['user_type']=='ON'){ 
			App::import('Model','Order');
			$this->Order = new Order;
			/* ******************* page limit sction **************** */
			$sess_limit_name = $this->params['controller']."_email_limit";
			$sess_limit_value = $this->Session->read($sess_limit_name);
			if(!empty($this->data['Record']['limit'])) {
				$limit = $this->data['Record']['limit'];
				$this->Session->write($sess_limit_name , $this->data['Record']['limit'] );
			} elseif( !empty($sess_limit_value) ){
				$limit = $sess_limit_value;
			} else{
				$limit = 25;
			}
			$this->data['Record']['limit'] = $limit;
			/* ******************* page limit sction **************** */
			
		if($this->data['Search']['user_type'] == 'ON'){
		$condition = 'Message.from_user_id != -1 ';
		}
		else
		{
		$condition = 'Message.to_user_id = '.$user['User']['id'].' AND Message.from_user_id != -1 ';	
		}
		
			if($this->data['Search']['user_type'] == 'B'){
			$all_orders = $this->Order->find('list',array('conditions'=>array('Order.user_id'=>$user['User']['id']),'fields'=>array('Order.id','Order.user_id')));
				if(!empty($all_orders)){
					foreach($all_orders as $order_id => $user_order){
						if(empty($orders_str))
							$orders_str = $order_id;
						else
							$orders_str = $orders_str.','.$order_id;
					}
				}
				if(!empty($condition)){
					$msg_type = 'S';
					if(!empty($orders_str))
						$condition = $condition.' AND OrderItem.order_id IN ('.$orders_str.')';
					else
						$condition = $condition.' AND Message.msg_from = "'.$msg_type.'"';
				} else {
					if(!empty($orders_str))
						$condition = 'OrderItem.order_id IN ('.$orders_str.')';
					else
						$condition = 'Message.msg_from = "'.$msg_type.'"';
				}
			}
			
			else if($this->data['Search']['user_type'] == 'ON'){
			$inputlength = strlen(trim($this->data['Search']['keyword']));	
			
			if($inputlength > 6){
			$order_id = $this->Order->find('first',array('conditions'=>array('Order.order_number'=>trim($this->data['Search']['keyword'])),'fields'=>array('Order.id','Order.user_id')));
			$order_id = $order_id['Order']['id'];
			}
			else
			{
			$order_id = trim($this->data['Search']['keyword']);	
			}
			
			$condition = $condition.' AND OrderItem.order_id ='.$order_id;
				
			}
			else {
				$msg_type = 'B';
				if(!empty($condition)){
					$condition = $condition.' AND OrderItem.seller_id = '.$user['User']['id'];
				}else {
					$condition = 'OrderItem.seller_id = '.$user['User']['id'];
				}
			}

			
			$this->paginate = array(
				'limit' => $limit,
				'conditions'=>$condition,
				'group'=>array('Message.from_user_id'),
				'order'=>array('Message.created Desc'),
				'fields'=>array(
					'Message.from_user_id',
					'Message.to_user_id',
					'Message.created',
					'Message.msg_from',
					'Message.order_item_id',
					'FromUserSummary.id',
					'FromUserSummary.firstname',
					'FromUserSummary.lastname',
					'FromUserSummary.email',
					'ToUserSummary.id',
				)
			);
			$this->Message->expects(array('FromUserSummary','ToUserSummary','OrderItem'));
			$all_users_list = $this->Message->find('all',array('conditions'=>$condition,'fields'=>array('Message.from_user_id','FromUserSummary.email')));

			if(!empty($user['User']['id']))
				$pass_url = $user['User']['id'];
			if(!empty($this->data['Search']['user_type']))
				$pass_url = $pass_url.'~'.$this->data['Search']['user_type'];

			$user_list = array();
			if(!empty($all_users_list)){
				foreach($all_users_list as $userl){
					$users_list[$userl['Message']['from_user_id']] = $userl['FromUserSummary']['email'];
				}
			}
			$this->data['User']['toUser'] = $user['User']['id'];
			$msgs = $this->paginate('Message');

		} else{
			
			$msgs = array();
		}
		
		
		if(!empty($msgs) && count($msgs) > 0 &&  $this->data['Search']['user_type'] == 'ON')
		{
		$this->redirect('/admin/messages/item_msgs/'.$msgs[0]['Message']['order_item_id']);
		exit;
		}

		$this->set('msg_type',$msg_type);
		$this->set('pass_url',$pass_url);
		$this->set('users_list',$users_list);
		$this->set('title_for_layout','Messages Management');
		$this->set('msgs',$msgs);
		
	}
	
	
	/*function admin_index() {
		$this->checkSessionAdmin();
		$pass_url = '';
		$passed_url = '';
		//for paging and sorting we are setting values 
		$msg_type = '';
		if(!empty($this->data)){
			if(!empty($this->data['User']['user_list']) && !empty($this->data['User']['toUser'])){
				$this->redirect('/admin/messages/communicated_items/'.$this->data['User']['toUser'].'/'.$this->data['User']['user_list']);
			}
		}

		
		if(!empty($this->params)){
			if(!empty($this->params['pass'])){
				if(!empty($this->params['pass'][0])) {
					$passed_url = base64_decode($this->params['pass'][0]);
				}
			}
		}
		if(!empty($this->data)) {
			if(!empty($this->data['Record'])){
				if(!empty($this->data['Record']['pass_url_value'])){
					$passed_url = base64_decode($this->data['Record']['pass_url_value']);
				}
			}
		}
		if(!empty($passed_url)){
			$passeed_url_array = explode('~',$passed_url);
			$search_user = @$passeed_url_array[0];
			$search_user_type = @$passeed_url_array[1];
		}

		if(empty($this->data)){
			if(isset($this->params['named']['keyword']))
				$this->data['Search']['keyword']=$this->params['named']['keyword'];
			else
				$this->data['Search']['keyword']='';
		}
		$value = '';
		$users_list = array();
		
		//SEARCHING
		$reqData = $this->data;
		if(!empty($this->data['Search'])) {
			$value = trim($this->data['Search']['keyword']);
			App::import('Sanitize');
			$value1= Sanitize::escape($value);
			if($value!=="") {
				$email = $value1;
				$this->set("keyword",$value);
			}
		}

		App::import('Model','User');
		$this->User = new User;

		if(!empty($value1)){
			$user = $this->User->find('first',array('conditions'=>array('User.email'=>$email),'fields'=>array('User.id')));
		} else if(!empty($search_user_type) && !empty($search_user)) {
			$user_data = $this->User->find('first',array('conditions'=>array('User.id'=>$search_user),'fields'=>array('User.email')));
			$value = $this->data['Search']['keyword'] = $user_data['User']['email'];
			$this->data['Search']['user_type'] = $search_user_type;
			$user['User']['id'] = $search_user;
			$this->data['Search']['user_type'] = $search_user_type;
		} else {

		}

		//sorting and search 
 		if($this->RequestHandler->isAjax()==0)
 			$this->layout = 'layout_admin';
 		else
			$this->layout = 'ajax';
		$this->set('keyword', $value);
		$user_id = $this->Session->read('SESSION_ADMIN.id');
		$this->layout='layout_admin';

		if(!empty($user['User']['id'])){
			App::import('Model','Order');
			$this->Order = new Order;
			// page limit sction **************** 
			$sess_limit_name = $this->params['controller']."_email_limit";
			$sess_limit_value = $this->Session->read($sess_limit_name);
			if(!empty($this->data['Record']['limit'])) {
				$limit = $this->data['Record']['limit'];
				$this->Session->write($sess_limit_name , $this->data['Record']['limit'] );
			} elseif( !empty($sess_limit_value) ){
				$limit = $sess_limit_value;
			} else{
				$limit = 25;
			}
			$this->data['Record']['limit'] = $limit;
			
// 			$condition = array('OR'=>array('Message.to_user_id'=>$user['User']['id'],'Message.from_user_id'=>$user['User']['id']),'Message.from_user_id != -1');
			$condition = 'Message.to_user_id = '.$user['User']['id'].' AND Message.from_user_id != -1 ';

			if($this->data['Search']['user_type'] == 'B'){
				$all_orders = $this->Order->find('list',array('conditions'=>array('Order.user_id'=>$user['User']['id']),'fields'=>array('Order.id','Order.user_id')));
				if(!empty($all_orders)){
					foreach($all_orders as $order_id => $user_order){
						if(empty($orders_str))
							$orders_str = $order_id;
						else
							$orders_str = $orders_str.','.$order_id;
					}
				}
				if(!empty($condition)){
					$msg_type = 'S';
// 					$condition = $condition.' AND OrderItem.seller_id != '.$user['User']['id'].' AND Message.msg_from = "'.$msg_type.'"';
					if(!empty($orders_str))
						$condition = $condition.' AND OrderItem.order_id IN ('.$orders_str.')';
					else
						$condition = $condition.' AND Message.msg_from = "'.$msg_type.'"';
				} else {
					if(!empty($orders_str))
						$condition = 'OrderItem.order_id IN ('.$orders_str.')';
					else
						$condition = 'Message.msg_from = "'.$msg_type.'"';
				}
			} else {
				$msg_type = 'B';
				if(!empty($condition)){
					$condition = $condition.' AND OrderItem.seller_id = '.$user['User']['id'];
				}else {
					$condition = 'OrderItem.seller_id = '.$user['User']['id'];
				}
			}

			
			$this->paginate = array(
				'limit' => $limit,
				'conditions'=>$condition,
				'group'=>array('Message.from_user_id'),
				'order'=>array('Message.created Desc'),
// 				'group'=>array('Message.to_user_id','Message.from_user_id'),
				'fields'=>array(
					'Message.from_user_id',
					'Message.to_user_id',
					'Message.created',
// 					'DISTINCT Message.to_user_id',
					'Message.msg_from',
					'FromUserSummary.id',
					'FromUserSummary.firstname',
					'FromUserSummary.lastname',
					'FromUserSummary.email',
					'ToUserSummary.id',
// 					'ToUserSummary.firstname',
// 					'ToUserSummary.lastname',
// 					'ToUserSummary.email',
				)
			);
			$this->Message->expects(array('FromUserSummary','ToUserSummary','OrderItem'));
			$all_users_list = $this->Message->find('all',array('conditions'=>$condition,'fields'=>array('Message.from_user_id','FromUserSummary.email')));
// pr($all_users_list);

			if(!empty($user['User']['id']))
				$pass_url = $user['User']['id'];
			if(!empty($this->data['Search']['user_type']))
				$pass_url = $pass_url.'~'.$this->data['Search']['user_type'];

			$user_list = array();
			if(!empty($all_users_list)){
				foreach($all_users_list as $userl){
					$users_list[$userl['Message']['from_user_id']] = $userl['FromUserSummary']['email'];
				}
			}
			$this->data['User']['toUser'] = $user['User']['id'];
			$msgs = $this->paginate('Message');

		} else{
			$msgs = array();
		}
		
// 		if(!empty($msgs)){
// 			$i = 0;
// 			//pr($msgs);
// 			foreach($msgs as $msg){
// 				if($user['User']['id'] == $msg['FromUserSummary']['id']){
// 					$msgs[$i]['OtherUser'] = $msg['FromUserSummary'];
// 				} else{
// 					$msgs[$i]['OtherUser'] = $msg['FromUserSummary'];
// 				}
// 				if($user['User']['id'] == $msg['ToUserSummary']['id']){
// 					$msgs[$i]['OtherUser'] = $msg['ToUserSummary'];
// 				} else{
// 					$msgs[$i]['OtherUser'] = $msg['ToUserSummary'];
// 				}
// 				$i++;
// 			}
// 		}

		$this->set('msg_type',$msg_type);
		$this->set('pass_url',$pass_url);
		$this->set('users_list',$users_list);
		$this->set('title_for_layout','Messages Management');
		$this->set('msgs',$msgs);
	}*/

	/** 
	@function:	admin_communicated_items
	@description	to view all items between a buyer and a seller on which they have communicated
	@Created by: 	Ramanpreet Pal Kaur
	@params		NULL
	@Created Date: 
	@Modified Date: 
	*/
	function admin_communicated_items($url_to_from_type = null){
		$url_msg = urldecode($url_to_from_type);
		$url_msgArr = explode('~',$url_msg);
		//pr($url_msgArr);
		$user_type = $url_msgArr[0];
		if(!empty($url_msgArr[1]))
			$to_id = $url_msgArr[1];
		if(!empty($url_msgArr[2]))
			$from_id = $url_msgArr[2];

		if($user_type == 'S')
			$pass_url_type = 'B';
		else
			$pass_url_type = 'S';

		if(!empty($to_id))
			$pass_url = $to_id;

		if(!empty($user_type))
			$pass_url = $pass_url.'~'.$pass_url_type;

		//echo base64_encode($pass_url);

		$this->set('pass_url',$pass_url);

		if(empty($to_id) || empty($from_id)){
			//$this->Session->setFlash('Not vaild users.','default',array('class'=>'flashError'));
			$this->redirect('/admin/messages/');
		}

		App::import('Model','User');
		$this->User = new User;
		$first_user = $this->User->find('first',array('conditions'=>array('User.id'=>$to_id),'fields'=>array('User.id','User.firstname','User.lastname','User.email','User.msg_status')));
		$second_user = $this->User->find('first',array('conditions'=>array('User.id'=>$from_id),'fields'=>array('User.id','User.firstname','User.lastname','User.email','User.msg_status')));
		$users['first_user'] = $first_user;
		$users['second_user'] = $second_user;
		$this->set('user',$users);
		$user_id = $this->Session->read('SESSION_ADMIN.id');
		$this->layout='layout_admin';
		/* ******************* page limit sction **************** */
		$sess_limit_name = $this->params['controller']."_emailItem_limit";
		$sess_limit_value = $this->Session->read($sess_limit_name);
		if(!empty($this->data['Record']['limit'])) {
		$limit = $this->data['Record']['limit'];
		$this->Session->write($sess_limit_name , $this->data['Record']['limit'] );
		} elseif( !empty($sess_limit_value) ){
			$limit = $sess_limit_value;
		} else{
			$limit = 25;
		}
		$this->data['Record']['limit'] = $limit;
			/* ******************* page limit sction **************** */
// 		$condition = array('OrderItem.seller_id'=>$to_id,'OR'=>array('Message.to_user_id = '.$to_id.' AND Message.from_user_id = '.$from_id,'Message.from_user_id = '.$to_id.' AND Message.to_user_id = '.$from_id));
		$condition = '(Message.to_user_id = '.$to_id.' AND Message.from_user_id = '.$from_id.') OR (Message.from_user_id = '.$to_id.' AND Message.to_user_id = '.$from_id.')';
		if($user_type == 'S'){
			if(!empty($condition)){
				$condition = $condition.' AND OrderItem.seller_id = '.$from_id;
			}
		} else {
			if(!empty($condition)){
				$condition = $condition.' AND OrderItem.seller_id = '.$to_id;
			}
		}

		$this->paginate = array(
			'limit' => $limit,
			'conditions'=>$condition,
			'order'=>array('Message.created Desc'),
			'group'=>array('Message.order_item_id'),
			'fields'=>array(
				'Message.id',
				'Message.order_item_id',
				'Message.created',
				'OrderItem.id',
				'OrderItem.order_id',
				'OrderItem.product_name',
			)
		);
		$this->Message->expects(array('OrderItem'));
		$this->Message->OrderItem->expects(array('OrderCre'));
		$this->Message->recursive = 2;
		$msgs_items = $this->paginate('Message');
		$this->set('title_for_layout','Messages Item Management');
		$this->set('msgs_items',$msgs_items);
	}

	/** 
	@function:	admin_item_msgs
	@description	to view all mesages between buyer and seller for a particular item
	@Created by: 	Ramanpreet Pal Kaur
	@params		NULL
	@Created Date: 
	@Modified Date: 
	*/
	function admin_item_msgs($order_item_id = null){
		if(empty($order_item_id)){
			$this->Session->setFlash('Order item is not vaild.','default',array('class'=>'flashError'));
			$this->redirect('/admin/messages/');
		}
		$this->set('order_item_id',$order_item_id);
		$this->layout='layout_admin';
		App::import('Model','OrderItem');
		$this->OrderItem = new OrderItem;
		
		/* ******************* page limit sction **************** */
		$sess_limit_name = $this->params['controller']."_adminitem_msgs_limit";
		$sess_limit_value = $this->Session->read($sess_limit_name);

		if(!empty($this->data['Record']['limit'])) {
		$limit = $this->data['Record']['limit'];
		$this->Session->write($sess_limit_name , $this->data['Record']['limit'] );
		} elseif( !empty($sess_limit_value) ){
			$limit = $sess_limit_value;
		} else{
			$limit = 25;
		}
		$this->data['Record']['limit'] = $limit;
		/* ******************* page limit sction **************** */
		$this->paginate = array(
			'limit' => $limit,
			'conditions'=>array('Message.order_item_id'=>$order_item_id),
			'order'=>array('Message.created Desc'),
			'fields'=>array('Message.id',
				'Message.from_user_id',
				'Message.to_user_id',
				'Message.reply_id',
				'Message.subject',
				'Message.message',
				'Message.msg_from',
				'Message.to_read_status',
				'Message.from_read_status',
				'Message.created',
				'Message.modified',
				'Message.is_replied',
				'Message.order_item_id',
				'ToUserSummary.id',
				'ToUserSummary.firstname',
				'ToUserSummary.lastname',
				'ToUserSummary.email',
				'FromUserSummary.id',
				'FromUserSummary.firstname',
				'FromUserSummary.lastname',
				'FromUserSummary.email',
			),
			
		);
		$this->data['Message']['order_item_id'] = $order_item_id;
		$this->Message->expects(array('FromUserSummary','ToUserSummary'));
		$msgs = $this->paginate('Message');
// 		pr($msgs);
		$this->set('allmsgs',$msgs);
		$this->OrderItem->expects(array('Order'));
		$order_info = $this->OrderItem->find('first',array('conditions'=>array('OrderItem.id'=>$order_item_id),'fields'=>array('Order.id','Order.order_number','Order.created','OrderItem.product_name')));
		$this->set('order_info',$order_info);
		$buyer_seller = $this->Message->find('first',array('conditions'=>array('Message.from_user_id !=  -1','Message.order_item_id'=>$order_item_id)));
		$this->set('buyer_seller',$buyer_seller);
		$this->set('listTitle','Messages for '.$order_info['OrderItem']['product_name']);
	}

	/** 
	@function:	admin_add
	@description	to delete single message for a particular user
	@Created by: 	Ramanpreet Pal Kaur
	@params		NULL
	@Created Date: 
	@Modified Date: 
	*/
	function delete($mes_id = null,$order_item_id = null){
		$this->Message->id =  $mes_id;
		if($this->Message->delete($mes_id)){
			$this->Session->setFlash('Record has been deleted successfully.');
		}else{
			$this->Session->setFlash('Error in deleting record.','default',array('class'=>'flashError'));
		}	
		$this->redirect('/admin/messages/item_msgs/'.$order_item_id);
	}

	/** 
	@function:	admin_add
	@description	to delete multiple messages for a particular user
	@Created by: 	Ramanpreet Pal Kaur
	@params		NULL
	@Created Date: 
	@Modified Date: 
	*/
	function admin_multiplAction(){
		if(empty($this->data)){
			$this->Session->setFlash('Data is not vaild.','default',array('class'=>'flashError'));
			$this->redirect('/admin/messages/');
		}
		if($this->data['Message']['status']=='del'){
			foreach($this->data['select'] as $id){
				if(!empty($id)){
					$this->Message->delete($id);
					$this->Session->setFlash('Information deleted successfully.');
				}
			}
		}
		/** for searching and sorting*/
		$this->redirect('/admin/messages/item_msgs/'.$this->data['Message']['order_item_id']);
	}

	/** 
	@function:	admin_add
	@description	to send messages from admin
	@Created by: 	Ramanpreet Pal Kaur
	@params		NULL
	@Created Date: 
	@Modified Date: 
	*/
	function admin_add($order_item_id = null,$id=null){
		if(!is_null($id) ){
			$this->set('listTitle','Update');
		}else{
			$this->set('listTitle','Add New');
		}
		if(empty($this->data)){
			if(empty($order_item_id)){
				$this->Session->setFlash('Not a vaild item.','default',array('class'=>'flashError'));
				$this->redirect('/admin/messages/');
			}
		}
		$this->set('id',$id);
		$logged_in_user_id = $this->Session->read('SESSION_ADMIN.id');
		$this->layout = 'layout_admin';

		if(!empty($this->data)){
			if(empty($this->data['Message']['id'])) {
				$this->data['Message']['from_user_id'] = -1;
			} else {
				$from = $this->Message->find('first',array('conditions'=>array('Message.id' => $this->data['Message']['id']),'fields'=>array('Message.from_user_id')));
				$this->data['Message']['from_user_id'] = $from['Message']['from_user_id'];
			}
			$this->Message->set($this->data);
			if($this->Message->validates()){
				$this->data['Message']['message'] = htmlentities($this->data['Message']['message']);
				if(empty($this->data['Message']['id'])){
					$this->data['Message']['msg_from'] = 'A';
					for($msg_i = 0; $msg_i<2; $msg_i++){
						if($msg_i == 1){
							$this->data['Message']['to_user_id'] = $this->data['Message']['from_to_user_id'];
							$this->Message->set($this->data);
							if($this->Message->save()){
								/** function call **/
								$send_email_messages = $this->Common->sendEmailAlert($this->data['Message']['to_user_id']);
								$sent['buyer'] = 1;
							} else
								$sent['buyer'] = 0;
						} else{
							$this->data['Message']['id'] = 0;
							$this->Message->set($this->data);
							if($this->Message->save()){
								/** function call **/
								$send_email_messages = $this->Common->sendEmailAlert($this->data['Message']['to_user_id']);
								$sent['seller'] = 1;
							} else
								$sent['seller'] = 0;
						}
					}
					if(empty($sent['seller'])){
						$this->Session->setFlash('Message has not sent successfullly to seller.','default',array('class'=>'flashError'));
					} else if(empty($sent['buyer'])){
						$this->Session->setFlash('Message has not sent successfullly to buyer.','default',array('class'=>'flashError'));
					} else{
						$this->Session->setFlash('Message has sent successfullly.');
					}
					$this->redirect('/admin/messages/item_msgs/'.$this->data['Message']['order_item_id']);
				} else{
					$this->Message->set($this->data);
				
					if($this->Message->save()){
						$this->Session->setFlash('Message updated successfullly.');
					} else{
						$this->Session->setFlash('Message not updated successfullly.','default',array('class'=>'flashError'));
					}
					$this->redirect('/admin/messages/item_msgs/'.$this->data['Message']['order_item_id']);
				}
			} else {
				$errorArray = $this->Message->validationErrors;
				$this->set('errors',$errorArray);
			}
		} else{
			
			App::import('Model','OrderItem');
			$this->OrderItem = new OrderItem;
			$this->OrderItem->expects(array('Order'));
			if(!empty($id)) {
				$this->Message->id = $id;
				$this->Message->expects(array('OrderItem'));
				$this->data = $this->Message->find('first',array('conditions'=>array('Message.id'=>$id),'fields'=>array('Message.id','Message.order_item_id','Message.message','OrderItem.id','OrderItem.seller_id','OrderItem.product_name')));
				$this->data['Message']['to_user_id'] = $this->data['OrderItem']['seller_id'];
			} else{
				$this->data = $this->OrderItem->find('first',array('conditions'=>array('OrderItem.id'=>$order_item_id),'fields'=>array('OrderItem.id','Order.user_id','OrderItem.seller_id','OrderItem.product_name')));
				$this->data['Message']['to_user_id'] = $this->data['OrderItem']['seller_id'];
				$this->data['Message']['order_item_id'] = $this->data['OrderItem']['id'];
				$this->data['Message']['from_to_user_id'] = $this->data['Order']['user_id'];
			}
			
		}
	}

	/** 
	@function:	admin_user_message_status
	@description	to cahnge status of a user to send messages
	@Created by: 	Ramanpreet Pal Kaur
	@params		NULL
	@Created Date: 
	@Modified Date: 
	*/
	function admin_user_message_status(){
		if(!empty($this->data)){
			App::import('Model','User');
			$this->User = new User;
			if($this->data['Message']['msg_status'] == 0){
				$save_status = 1;
			} else{
				$save_status = 0;
			}
			$this->User->id = $this->data['Message']['main_user_id'];
			if($this->User->saveField('msg_status',$save_status)){
				$this->Session->setFlash('Message status has updated successfully.');
			} else{
				$this->Session->setFlash('Message status has not updated.','default',array('class'=>'flashError'));
			}
			$this->redirect('/admin/messages/communicated_items/B~'.$this->data['Message']['main_user_id'].'~'.$this->data['Message']['second_user_id']);
		}
	}


	/** 
	@function:	admin_download_allMessages
	@description	
	@Created by: 	Ramanpreet Pal Kaur
	@params		NULL
	@Created Date:  23 March 2011
	@Modified Date: 23 March 2011
	*/
	function admin_download_allMessages($all_messages = null){
		if(empty($all_messages)){
			$this->Message->expects(array('FromUserSummary','ToUserSummary','OrderItem'));
			$msgs_b4_20days = $this->Message->find('all',array('conditions'=>array('Message.created <= DATE_SUB( NOW( ) , INTERVAL 181 DAY)'),'fields'=>array('Message.from_user_id','Message.to_user_id','Message.message','Message.order_item_id','Message.created','FromUserSummary.firstname','FromUserSummary.lastname','FromUserSummary.email','ToUserSummary.firstname','ToUserSummary.lastname','ToUserSummary.email','OrderItem.product_name')));
		} else{
			$msgs_b4_20days = $all_messages;
		}
		Configure::write('debug',0);
		if(!empty($msgs_b4_20days)){
			#Creating CSV
			$csv_output =  "FROM USER,TO USER,ITEM NAME,MESSAGE,SENT ON\n" ;
			foreach($msgs_b4_20days as $value){
				if($value['Message']['from_user_id'] == -1){
					$from_user = 'Admin';
				} else{
					$from_user = $value['FromUserSummary']['firstname'].' '.$value['FromUserSummary']['lastname'].'('.$value['FromUserSummary']['email'].')';
				}
				if(empty($value['Message']['to_user_id'])){
					$to_user = '-';
				} else{
					$to_user = $value['ToUserSummary']['firstname'].' '.$value['ToUserSummary']['lastname'].'('.$value['ToUserSummary']['email'].')';
				}
				
				if(!empty($value['Message'])){
					foreach($value['Message'] as $field_index => $info){
						$value['Message'][$field_index] = html_entity_decode($info);
						$value['Message'][$field_index] = str_replace('&#039;',"'",$value['Message'][$field_index]);
						$value['Message'][$field_index] = str_replace('\n',"",$value['Message'][$field_index]);
					}
				}
				$csv_output .="".str_replace(",",' || ',$from_user).",".str_replace(",",' || ',$to_user).",".str_replace(",",' || ',$value['OrderItem']['product_name']).",".str_replace(",",' || ',$value['Message']['message']).",".str_replace(",",' || ',$value['Message']['created']).",\n";
			}
		} else{
			$csv_output .= "No Record Found.."; 
		}
		$filePath="messages_listing_".date("Ymd").".csv";
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=".$filePath."");
		header("Pragma: no-cache");
		header("Expires: 0");
		print $csv_output;
		exit();
	}

	/** 
	@function:	admin_delete_allMessages
	@description	
	@Created by: 	Ramanpreet Pal Kaur
	@params		NULL
	@Created Date:  23 March 2011
	@Modified Date: 23 March 2011
	*/
	function admin_delete_allMessages($all_messages = null,$download = null){
		if(empty($all_messages)){
			$this->Message->expects(array('FromUserSummary','ToUserSummary','OrderItem'));
			$msgs_b4_20days = $this->Message->find('all',array('conditions'=>array('Message.created <= DATE_SUB( NOW( ) , INTERVAL 181 DAY)'),'fields'=>array('Message.from_user_id','Message.to_user_id','Message.message','Message.order_item_id','Message.created','FromUserSummary.firstname','FromUserSummary.lastname','FromUserSummary.email','ToUserSummary.firstname','ToUserSummary.lastname','ToUserSummary.email','OrderItem.product_name')));
		} else{
			$msgs_b4_20days = $all_messages;
		}
		if(!empty($msgs_b4_20days)){
			foreach($msgs_b4_20days as $value){
				$mes_id = $value['Message']['id'];
				$this->Message->id =  $value['Message']['id'];
				$this->Message->delete($mes_id);
			}
			if(!empty($download)){
				$this->admin_download_allMessages($msgs_b4_20days);
			}
		}
	}


	/** 
	@function:	admin_download_delete_all_messages
	@description	
	@Created by: 	Ramanpreet Pal Kaur
	@params		NULL
	@Created Date:  23 March 2011
	@Modified Date: 23 March 2011
	*/
	function admin_download_delete_all_messages(){
		if(!empty($this->data)){
			if($this->Message->validates()){
				$this->Message->expects(array('FromUserSummary','ToUserSummary','OrderItem'));
				$msgs_b4_20days = $this->Message->find('all',array('conditions'=>array('Message.created <= DATE_SUB( NOW( ) , INTERVAL 180 DAY)'),'fields'=>array('Message.id','Message.from_user_id','Message.to_user_id','Message.message','Message.order_item_id','Message.created','FromUserSummary.firstname','FromUserSummary.lastname','FromUserSummary.email','ToUserSummary.firstname','ToUserSummary.lastname','ToUserSummary.email','OrderItem.product_name')));
				if($this->data['Message']['action'] == 2){
					$download = 1;$delete = 0;
				} else if($this->data['Message']['action'] == 3){
					$delete = 1; $download = 0;
				} else if($this->data['Message']['action'] == 1){
					$download = 1; $delete = 1;
				} else {
					$download = 0; $delete = 0;
				}
				if(!empty($download) || !empty($delete)){
					if(!empty($msgs_b4_20days)){
						if(!empty($download) && !empty($delete)){
							$this->admin_delete_allMessages($msgs_b4_20days,1);
						} else if(!empty($delete)){
							$this->admin_delete_allMessages($msgs_b4_20days);
						} else if(!empty($download)){
							$this->admin_download_allMessages($msgs_b4_20days);
						}
					} else{
						$this->Session->setFlash('No message available','default',array('class'=>'flashError'));
					}
				} else{
					$this->Session->setFlash('Select an action','default',array('class'=>'flashError'));
				}
			} else {
				$errorArray = $this->Message->validationErrors;
				$this->set('errors',$errorArray);
			}
		}
		$this->layout = 'layout_admin';
		$this->set('listTitle','Download / Delete Messages');
	}
}
?>