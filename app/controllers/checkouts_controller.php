<?php
/**
* Checkouts Controller class
* PHP versions 5.1.4
* @date 
* @Purpose: 
* @filesource
* @author     Ramanpreet Pal Kaur
* @revision
* @copyright  Copyright � 2011 smartData
* @version 0.0.1 
**/
App::import('Sanitize');

class CheckoutsController extends AppController
{
	var $name =  "Checkouts";
	var $helpers =  array('Html', 'Form', 'Javascript','Session','Validation','Format','Ajax','Common');
	var $components =  array('RequestHandler','Email','File', 'Common', 'Ordercom','Paypal','Sage', 'Googlecheckout', 'Googleresponcehandler');
	var $paginate =  array();
	//var $uses =  array('Checkout');

	/**
	* @Date: jan 19 2011
	* @Method : beforeFilter
	* Created By: kulvinder singh
	* @Purpose: This function is used to validate admin user permissions
	* @Param: none
	* @Return: none 
	**/
	function beforeFilter(){
		//check session other than admin_login page
		$this->detectMobileBrowser();
		$includeBeforeFilter = array('step2','step3', 'admin_add','step4','basket_order_summary', 'submit_order','order_complete', 'processOrderConfirmation', 'sendOrderConfirmationEmail','sendOrderDispatchNowEmail');
			
		if (in_array($this->params['action'],$includeBeforeFilter)){
			 $logged_in_user = $this->Session->read('User.id');
			if(empty($logged_in_user)){
				$this->redirect('/checkouts/step1');
			}
			
		}
	}
	
	/**
	* @Date: Jan 14, 2011
	* @Method : ramanpreet pal(Jan 12, 2011)
	* @created:  kulvinder
	* @Param: 
	* @Return: 
	**/
	function step1($from_giftcertificate = null){
		
		$this->set('from_giftcertificate',$from_giftcertificate);
		$this->set('title_for_layout','Choiceful.com Checkout - Signin');
		
		if ($this->RequestHandler->isMobile()) {
 			$this->layout = 'mobile/home';
		} else if($this->RequestHandler->isAjax()==0){
 			$this->layout = 'checkout';
		} else{
			$this->layout = 'ajax';
		}
		
		
		$cData = $this->Common->get_basket_listing();
		$this->set('cData', $cData);
		
		
		$user_id = $this->Session->read('User.id');
		
		if(!empty($user_id)){
			if(!empty($from_giftcertificate))
				$this->redirect('/checkouts/giftcertificate_step2/1');
			else
				$this->redirect('/checkouts/step2');
		}
		App::import('Model', 'User');
		$this->User = new User();
		$errors='';
		if(!empty($this->data)) {
			
			$this->data = $this->cleardata($this->data);
			//$this->data = Sanitize::clean($this->data, array('encode' => false));
			
			$this->User->set($this->data);
			$userValidate = $this->User->validates();
			if(!empty($userValidate)){
				if(htmlentities($this->data['User']['customer']) != 1) { // existing customer authontication
					$email = $this->data['User']['emailaddress'];
					$saved_password = $this->data['User']['password1'];
					$user_password = md5($this->data['User']['password1']);
					$this->User->expects(array('Seller'));
					$userinfo_user = $this->User->find('first',array('conditions'=>array("User.email"=>$email,"User.password"=>$user_password),'fields'=>array("User.id","User.title","User.user_type","User.email","User.status","User.suspend_date","User.suspend","Seller.id","User.firstname","User.lastname","Seller.status")));
					$userinfo = $userinfo_user;
					if(!empty($userinfo['User']['suspend'])) {
						if(!empty($userinfo['User']['suspend_date'])) {
							if(strtotime($userinfo['User']['suspend_date'])>strtotime(date('Y-m-d'))) {
								$suspended = true;
							} else{
								$suspended = false;
							}
						} else{
							$suspended = false;
						}
					} else{
						$suspended = false;
					}
					
					if($userinfo['User']['status'] == '0'){
						$this->Session->setFlash('Your account has been deactivated. Please contact us to find out more.','default',array('class'=>'flashError'));
					} elseif(!empty($suspended)) {
						$this->Session->setFlash('Your account has been temporarily suspended. Please contact us to find out more.','default',array('class'=>'flashError'));
					} elseif(($userinfo['User']['status'] == '1') ) {
						$userinfo['User']['seller_id'] = $userinfo['Seller']['id'];
						$userinfo['User']['seller_status'] = $userinfo['Seller']['status'];
						$this->Session->delete('User');
						$this->Session->delete('saved_password' );
						$this->Session->write('User',$userinfo['User']);
						$this->Session->write('saved_password',$saved_password);
						if(!empty($from_giftcertificate))
							$this->redirect('/checkouts/giftcertificate_step2/1');
						else
							$this->redirect("/checkouts/step2/");
					} else {
						$this->Session->setFlash('Username or password is not correct.','default',array('class'=>'flashError'));
					}
					$this->set("errors",$errors);
					
				} else {  // new customer registration
					
					$is_already_user = $this->User->find('first',array('conditions'=>array('User.email'=>$this->data['User']['emailaddress'])));
					if(empty($is_already_user)){
						$newcustomer['email'] = $this->data['User']['emailaddress'];
						$newcustomer['password'] = $this->data['User']['password1'];
						$this->Session->write('newcustomer',$newcustomer);
						if ($this->RequestHandler->isMobile()) {
							if(!empty($from_giftcertificate))
								$this->redirect('/users/registration/1/2');
							else
								$this->redirect("/users/registration/1");
						}else{
							if(!empty($from_giftcertificate))
								$this->redirect('/checkouts/registration/1');
							else
								$this->redirect("/checkouts/registration/");
						}
					} else{
						$this->Session->setFlash('Your email address already exists in our system. Click on forgot your password if you would like us to send you a reminder','default',array('class'=>'flashError'));
					}
				}
			} else{
				$errorArray = $this->User->validationErrors;
			//	pr($errorArray);
				$this->set('errors',$errorArray);
			}
		} else{
			$this->data['User']['customer'] = 1;
		}
	}
	
	
	/** 
	@function:		registration
	@description		to registration a new customer and sending an email to the registered customer
	@Created by: 		Ramanpreet Pal
	@params		
	@Modify:		kulvinder,ramanpreet pal(Jan 12, 2011)
	@Created Date:		19 jan 2010
	*/
	function registration($from_giftcertificate = null){
		$this->set('from_giftcertificate',$from_giftcertificate);
		$this->set('title_for_layout','Choiceful.com Checkout - Express Registration');
		$logged_in_user = $this->Session->read('User');
		if(!empty($logged_in_user)) {
			$this->Session->setFlash('You are already a registered member.');
			if(!empty($from_giftcertificate))
				$this->redirect('/checkouts/giftcertificate_step2/1');
			else
				$this->redirect('/checkouts/step2/');
		}
		//$this->Session->delete('newcustomer');
		$new_customer = $this->Session->read('newcustomer');
		$this->layout = 'checkout';
		$titles = $this->Common->get_titles();
		$this->set('title',$titles);
		$countries = $this->Common->getcountries();
		$this->set('countries',$countries);
		App::import('Model','Address');
		$this->Address = new Address;
		App::import('Model', 'User');
		$this->User = new User();
		if(!empty($this->data)){
			
			$this->data = $this->cleardata($this->data);
			//$this->data = Sanitize::clean($this->data, array('encode' => false));
			
			//$this->data['User']['contact_by_phone'] = $this->data['User']['contact_phone'];
			//$this->data['User']['contact_by_partner'] = $this->data['User']['contact_partner'];
			$this->data['User']['tc'] = $this->data['User']['terms_conditions'];
			$this->User->set($this->data);
			$userValidate = $this->User->validates();
			if(!empty($userValidate)){
				$original_password =$this->data['User']['newpassword'];
				$this->data['User']['password'] = md5($this->data['User']['newpassword']);
				$this->data['User']['firstname'] = ucwords(strtolower($this->data['User']['firstname']));
				$this->data['User']['lastname'] =ucwords(strtolower($this->data['User']['lastname']));
				$this->data['Address']['add_firstname'] = ucwords(strtolower($this->data['User']['firstname']));
				$this->data['Address']['add_lastname'] =ucwords(strtolower($this->data['User']['lastname']));
				$this->data['Address']['add_address1'] = ucwords(strtolower($this->data['User']['address1']));
				$this->data['Address']['add_address2'] = ucwords(strtolower($this->data['User']['address2']));
				$this->data['Address']['add_city']     = ucwords(strtolower($this->data['User']['city']));
				$this->data['Address']['country_id'] = $this->data['User']['country_id'];
				$this->data['Address']['add_state']  = $this->data['User']['state'];
				$this->data['Address']['add_phone'] = $this->data['User']['phone'];
				$this->data['Address']['add_postcode'] = $this->data['User']['postcode'];
				$this->data['Address']['primary_address'] = 1;
				$this->User->set($this->data);
				if($this->User->save()){
					$last_inserted_user = $this->User->getLastInsertId();
					$this->data['Address']['user_id'] = $last_inserted_user;
					$this->Address->set($this->data);
					$this->Address->save($this->data);
					$this->Session->delete('newcustomer');
					/** Send email after registration **/
					$this->Email->smtpOptions = array(
						'host' => Configure::read('host'),
						'username' =>Configure::read('username'),
						'password' => Configure::read('password'),
						'timeout' => Configure::read('timeout')
					);
					
					$this->Email->replyTo=Configure::read('replytoEmail');
					$this->Email->sendAs= 'html';
					$link=Configure::read('siteUrl');
					/******import emailTemplate Model and get template****/
					App::import('Model','EmailTemplate');
					$this->EmailTemplate = new EmailTemplate;
					/**
					table: email_templates
					id: 1
					description: Customer registration
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
					} else{
						$this->Session->setFlash('An error occurred while sending the email to the email address provided by you. Please contact Customer Support at '.Configure::read('phone').' to reset your email address and password.','default',array('class'=>'flashError'));
					}
					$inserted_user_id = $this->User->getLastInsertId();
					$this->User->expects(array('Seller'));
					$userinfo = $this->User->find('first',array('conditions'=>array("User.id"=>$inserted_user_id),'fields'=>array("User.id","User.title","User.user_type","User.email","User.status","User.suspend_date","Seller.id")));
					$user_addinfo = $this->Address->find('first',array('conditions'=>array('Address.user_id'=>$inserted_user_id,'Address.primary_address'=>'1'),'fields'=>array('Address.add_firstname','Address.add_lastname')));
					$userinfo['User']['firstname'] = $user_addinfo['Address']['add_firstname'];
					$userinfo['User']['lastname'] = $user_addinfo['Address']['add_lastname'];

					$this->Session->write('User',$userinfo['User']);
					if(!empty($from_giftcertificate))
						$this->redirect('/checkouts/giftcertificate_step2/1');
					else
						$this->redirect('/checkouts/step2/step2-choiceful-checkout-gift-options');
					/** Send email after registration **/
				} else {
					$this->data['User']['newpassword'] = '';
					$this->data['User']['newconfirmpassword'] = '';
					$errorArray = $this->User->validationErrors;
					$this->Session->setFlash('There was problem in saving data. Please try again later.','default',array('class'=>'flashError'));
				}
			} else {
				$this->data['User']['newpassword'] = '';
				$this->data['User']['newconfirmpassword'] = '';
				$errorArray = $this->User->validationErrors;
				$this->set('errors',$errorArray);
			}
		} else{
			//print_r($new_customer);
			if(!empty($new_customer)){
				$this->data['User']['email']       = $new_customer['email'];
// 				$this->data['User']['newpassword'] = $new_customer['password'];
			}else{
			
						$this->redirect("/checkouts/step1");
					
			}
		}
	}





	/**
	* @Date: Jan 19, 2011
	* @Method : 
	* @created:  kulvinder
	* @Param: 
	* @Return: 
	**/
	function step2(){
		
		$user_id = $this->Session->read('User.id');
		$this->set('title_for_layout','Choiceful.com Checkout - Gift Wrap');
		if ($this->RequestHandler->isMobile()) {
 			$this->layout = 'mobile/home';
		} else{
			$this->layout = 'checkout';
		}
		$cData = $this->Common->get_basket_listing();
		$this->set('cData', $cData);
		$settings = $this->Common->get_site_settings();
		$this->set('settings', $settings);
		// check the gift service for all the basket data
		$prodSellers = array();
		if(is_array($cData)  && count($cData) > 0){
			foreach($cData as $cart){
				if(!empty($cart['Basket']['seller_id']) ){
					$prodSellers[] = $cart['Basket']['seller_id'];
				}
			}
		}
		$noGiftsWrapService  = $this->Ordercom->check_sellers_giftwrapservice($prodSellers);
		// if no gift service provided for these basket listing then skip this page
		if(  empty($noGiftsWrapService)) {
			$this->redirect('/checkouts/step3') ;
			exit;
		}
		# import the Basket DB to upate the fist option and gift messages
		App::import('Model', 'Basket');
		$this->Basket = new Basket();
		
		if(!empty($this->data)){
		//	pr($this->data);
			
		$this->data = $this->cleardata($this->data);
		//$this->data = Sanitize::clean($this->data, array('encode' => false));	
			
			if(is_array($this->data)  && count($this->data) > 0){
				foreach($this->data as $giftwrapData){
					if(!empty($giftwrapData['cartid']) ){
						$giftMsgStr = "";
						if(!empty($giftwrapData['message1']) ){
							$giftMsgStr .= $giftwrapData['message1'];
							$giftMsgStr .=  "#--#";
						}
						if(!empty($giftwrapData['message2']) ){
							$giftMsgStr .= $giftwrapData['message2'];
							$giftMsgStr .=  "#--#";
						}
						if(!empty($giftwrapData['message3']) ){
							$giftMsgStr .= $giftwrapData['message3'];
							$giftMsgStr .=  "#--#";
						}
						if(!empty($giftwrapData['message4']) ){
							$giftMsgStr .= $giftwrapData['message4'];
							//$giftMsgStr .=  "#-#";
						}
						# check the giftwrap option if yes then set the data
						if(strtolower($giftwrapData['giftwrap']) == 'yes'){
							$giftServeceYesNo = "Yes";
							$giftwrap_cost    = $settings['Setting']['gift_wrap_charges'];
							$giftMsgStr       = $giftMsgStr;
						} else{
							$giftServeceYesNo = "No";
							$giftwrap_cost 	  = 0.00;
							$giftMsgStr	  = '';
						}
						
						$this->data['Basket']['id'] 		= $giftwrapData['cartid'];
						$this->data['Basket']['giftwrap']  	= $giftServeceYesNo;
						$this->data['Basket']['giftwrap_cost']  = $giftwrap_cost;
						$this->data['Basket']['giftwrap_message'] = $giftMsgStr;
						# save the data for gift wrap services
						if(!empty($user_id)){
							$this->data['Basket']['user_id'] = $user_id;
						}
						# save the data in basket table
						$this->data = Sanitize::clean($this->data);
						if($this->Basket->save($this->data['Basket'])){
							
						} else{
							
						}
					}
					unset($giftServeceYesNo);unset($giftMsgStr);
					unset($giftwrap_cost);
				}
				
				$this->redirect('/checkouts/step3') ;
				exit;	
			}
		} else{
			
		}
	}
	
	
	/**
	* @Date: Jan 20, 2011
	* @Method : 
	* @created:  kulvinder
	* @Param: 
	* @Return: 
	**/
	function step3(){
		$this->set('title_for_layout','Choiceful.com Checkout - Enter Billing & Shipping Information');
		if ($this->RequestHandler->isMobile()) {
 			$this->layout = 'mobile/home';
		} else if($this->RequestHandler->isAjax()==0){
 			$this->layout = 'checkout';
			} else{
				$this->layout = 'ajax';
		}
		
		###################### clear coupon session data() ##################
		$this->Session->write('dcSessData', '');
		########################################
		// logedin user id
		$user_id  = $this->Session->read('User.id');
		$userdata = $this->Common->get_user_billing_info($user_id);		
		$NewUsedcondArray = $this->Common->get_new_used_conditions();
		$settings = $this->Common->get_site_settings();
		$this->set('settings', $settings);
		
		//pr($settings);
		$this->set('NewUsedcondArray', $NewUsedcondArray);
		
		// set the basket data as per the quantitiy of in stock
		//$this->Ordercom->setBasketDataAsPerStock();
		
		
		// get cart listing data
		$cartData = $this->Common->get_basket_listing();
		$this->set('cartData', $cartData);		
		//pr($cartData);
		if(count($cartData)  <= 0 ){ // if basket is empty then redirect it to 
			$this->redirect('/baskets/view');
		}
		 
			
		$titles = $this->Common->get_titles();
		$this->set('title',$titles);
		
		$countries = $this->Common->getcountries();
		$this->set('countries',$countries);
		
		$shippingCountries = $this->Common->getDispatchCountryList();
		$this->set('shippingCountries' , $shippingCountries);

		# import the Basket DB to upate the fist option and gift messages
		App::import('Model', 'Basket');
		$this->Basket = new Basket();
		App::import('Model', 'Order');
		$this->Order = new Order();
		
		if(!empty($this->data)){ // if data submitted
			//pr($this->data); exit;
			
			$this->data = $this->cleardata($this->data);
			//$this->data = Sanitize::clean($this->data, array('encode' => false));
			
			$this->Order->set($this->data);
			$orderInfoValidate = $this->Order->validates();
			if(!empty($orderInfoValidate)){
				$this->data = Sanitize::clean($this->data);
				$home_location_country = $settings['Setting']['website_home_location'];
				$home_location_country_name = $shippingCountries[$home_location_country];
				
				if( $this->data['Order']['shipping_country_id'] != $home_location_country){
					
					$this->Session->setFlash('Delivery must be to a '.$home_location_country_name.' address, <a href="'.SITE_URL.'pages/view/international-delivery" target="_blank">click here </a> for more information.','default',array('class'=>'flashError'));	
				}else{ 
					// save the shhipping/delivery  data in basket
					if(isset($this->data['Basket']) ){ 
						if(is_array($this->data['Basket'])  && count($this->data['Basket']) > 0){
							foreach($this->data['Basket'] as $shipData):
								$deliveryInfo = $this->Common->getProductSellerData($shipData['product_id'],$shipData['seller_id'],$shipData['condition_id']);
								$deliverydays = $this->Ordercom->getRequiredShippingDays($deliveryInfo['ProductSeller']['dispatch_country'] ,$this->data['Order']['shipping_country_id'] );
								if(!empty($deliverydays) ){
									$s_del_Date 	=  $this->Ordercom->getFinalDeliveryDate($deliverydays['DeliveryDestination']['sd_delivery']);
									$e_del_Date 	=  $this->Ordercom->getFinalDeliveryDate($deliverydays['DeliveryDestination']['ex_delivery']);
									
									$s_dis_Date 	=  $this->Ordercom->getFinalDeliveryDate($deliverydays['DeliveryDestination']['sd_dispatch']);
									$e_dis_Date 	=  $this->Ordercom->getFinalDeliveryDate($deliverydays['DeliveryDestination']['ex_dispatch']);
								
								} else{ // no record found 
									$s_del_Date = null;
									$e_del_Date = null;
									$s_dis_Date = null;
									$e_dis_Date = null;
								}
								####################### Delivery Date EStimation 
								if(!empty($s_del_Date) ){
									$std_delivery_date = date('Y-m-d',  strtotime($s_del_Date)) ;
								} else{ $std_delivery_date = null; }
								
								if(!empty($e_del_Date) ){
									$exp_delivery_date = date('Y-m-d',  strtotime($e_del_Date)) ;
								} else{ $exp_delivery_date = null; }
								####################### Dispatch Date EStimation
								if(!empty($s_dis_Date) ){
									$sd_dispatch_Date = date('Y-m-d',  strtotime($s_dis_Date)) ;
								} else{ $sd_dispatch_Date = null; }
								if(!empty($e_dis_Date) ){
									$ex_dispatch_Date = date('Y-m-d',  strtotime($e_dis_Date)) ;
								} else{  $ex_dispatch_Date = null;}
								
								
								##########################################################
								if($shipData['delivery_method'] == 'E'){ // if choose express delivery
									$exp_dispatch_date      = $ex_dispatch_Date;
									$exp_delivery_price	= $shipData['express_delivery_price'];
								} else{
									$exp_dispatch_date      = $sd_dispatch_Date;
									$exp_delivery_price 	= 0.00; 
								}
								if(!empty($shipData['id']) ){
									$this->data['Basket']['id']      	          = $shipData['id'];
									$this->data['Basket']['delivery_method']          = $shipData['delivery_method'];
									$this->data['Basket']['delivery_cost'] 		  = $shipData['standard_delivery_price'];
									$this->data['Basket']['exp_delivery_cost'] 	  = $exp_delivery_price;
									$this->data['Basket']['standard_delivery_date']   = $std_delivery_date;
									$this->data['Basket']['express_delivery_date']    = $exp_delivery_date;
									$this->data['Basket']['estimated_dispatch_date']  = $exp_dispatch_date;
									 $this->Basket->save($this->data['Basket']); // save data to basket
								}
								unset($std_delivery_date);
								unset($exp_delivery_date);
								unset($exp_dispatch_date);
								unset($e_del_Date);
								unset($s_del_Date);
								unset($deliveryInfo);
								unset($deliverydays);
							endforeach;
						}
						$this->Session->write('sessOrderData',$this->data['Order']);
						$this->data = '';
						$this->redirect('/checkouts/step4');
					} else{
						$this->Session->setFlash('Please add products in basket !','default',array('class'=>'flashError'));
					}
				}
			} else{
				$errorArray = $this->Order->validationErrors;
				$this->set('errors',$errorArray);
			}
		
		} else{
			$sessOrderData = $this->Session->read('sessOrderData');
			
			// check the sessions's data if present
			if(!empty($sessOrderData) ){ // show session data
				$this->data['Order']['billing_user_title'] = $sessOrderData['billing_user_title'];
				$this->data['Order']['billing_firstname'] = $sessOrderData['billing_firstname'];
				$this->data['Order']['billing_lastname'] = $sessOrderData['billing_lastname'];
				$this->data['Order']['billing_address1'] = $sessOrderData['billing_address1'];
				$this->data['Order']['billing_address2'] = $sessOrderData['billing_address2'];
				$this->data['Order']['billing_city'] = $sessOrderData['billing_city'];
				$this->data['Order']['billing_state'] = $sessOrderData['billing_state'];
				$this->data['Order']['billing_postal_code'] = $sessOrderData['billing_postal_code'];
				$this->data['Order']['billing_country_id'] = $sessOrderData['billing_country_id'];
				$this->data['Order']['billing_phone'] = $sessOrderData['billing_phone'];
				$this->data['Order']['shipping_same'] = $sessOrderData['shipping_same'];
				$this->data['Order']['shipping_user_title'] = $sessOrderData['shipping_user_title'];
				$this->data['Order']['shipping_firstname'] = $sessOrderData['shipping_firstname'];
				$this->data['Order']['shipping_lastname'] = $sessOrderData['shipping_lastname'];
				$this->data['Order']['shipping_address1'] = $sessOrderData['shipping_address1'];
				$this->data['Order']['shipping_address2'] = $sessOrderData['shipping_address2'];
				$this->data['Order']['shipping_city'] = $sessOrderData['shipping_city'];
				$this->data['Order']['shipping_state'] = $sessOrderData['shipping_state'];
				$this->data['Order']['shipping_postal_code'] = $sessOrderData['shipping_postal_code'];
				$this->data['Order']['shipping_country_id'] = $sessOrderData['shipping_country_id'];
				$this->data['Order']['shipping_phone'] = $sessOrderData['shipping_phone'];
				$this->data['Order']['comments'] = $sessOrderData['comments'];
				$this->data['Order']['insurance'] = $sessOrderData['insurance'];
			} else{ //show users'table data
				$userdata = $this->Common->get_user_billing_info($user_id);
				
				if(is_array($userdata) ){
					$this->data['Order']['billing_user_title'] = $userdata['User']['title'];
					$this->data['Order']['billing_firstname'] = $userdata['User']['firstname'];
					$this->data['Order']['billing_lastname'] = $userdata['User']['lastname'];
					$this->data['Order']['billing_address1'] = $userdata['Address']['add_address1'];
					$this->data['Order']['billing_address2'] = $userdata['Address']['add_address2'];
					$this->data['Order']['billing_city'] = $userdata['Address']['add_city'];
					$this->data['Order']['billing_state'] = $userdata['Address']['add_state'];
					$this->data['Order']['billing_postal_code'] = $userdata['Address']['add_postcode'];
					$this->data['Order']['billing_country_id'] = $userdata['Address']['country_id'];
					$this->data['Order']['billing_phone'] = $userdata['Address']['add_phone'];
					$this->data['Order']['shipping_user_title'] = '';
					$this->data['Order']['shipping_state'] = '';
					$this->data['Order']['shipping_country_id'] = '';
				} else{
					$this->Session->delete('User.id');
					$this->redirect('/checkouts/step1');
				}
			}
				
				
			if(!empty($this->data['Order'])){
				foreach($this->data['Order'] as $field_index => $info){
					$this->data['Order'][$field_index] = html_entity_decode($info);
					$this->data['Order'][$field_index] = str_replace('&#039;',"'",$this->data['Order'][$field_index]);
					$this->data['Order'][$field_index] = str_replace('\n',"",$this->data['Order'][$field_index]);
				}
			}
		}
		
	}
	
	
	
	/** 
	@function: applyDiscountCoupon
	@Created by: Kulvinder
	@Modify:  28 jan 2010 
	*/
	function applyDiscountCoupon(){
		
		//pr($this->data); die();
		$dcCode = trim($this->data['Checkout']['dc_code']);
		if(empty($dcCode) ){
			$this->Session->setFlash("Enter your discount code and then click Update !",'default',array("class"=>"error_msg_box"));
			$this->redirect('/checkouts/step4');
		}
		$this->layout = 'ajax';
		$user_id = $this->Session->read('User.id');
		##################################################################################
		$settings = $this->Common->get_site_settings(); // get site settings data
		$this->set('settings', $settings);
		$gcBalanceData  = $this->Ordercom->getUserGiftbalance($user_id); // get gift balance data for user
		$this->set('gc_amount', $gcBalanceData);
		$sessOrderData = $this->Session->read('sessOrderData');
		$this->set('sessOrderData', $sessOrderData);
		if($sessOrderData['insurance']){
			$insurance_cost = $settings['Setting']['insurance_charges'];
		} else{
			$insurance_cost = 0;
		}
		$basketPriceData = $this->Ordercom->getBasketPriceInfo(); // get baslet price info data
		$this->set('basketPriceData', $basketPriceData);

		$order_amount = $basketPriceData['item_total_cost']+$basketPriceData['shipping_total_cost']+$basketPriceData['giftwrap_total_cost'];
		$productIds =  implode(',' , $basketPriceData['product_ids']);
		$order_product_codes  = $this->Common->getProductQuickCode($productIds);
		$order_department_ids = $this->Common->getProductDepartments($productIds);
		// apply discount coupon code 
		if(!empty($dcCode) ){
			$dc_errmsg = '';
			$dcSessData = $this->Session->read('dcSessData');
			if(!empty($dcSessData) ){
				if($dcCode == $dcSessData['discount_code']){
					$validDcCode = 'No';
				} else{
					$validDcCode = 'Yes';
				}
			} else{
				$validDcCode = 'Yes';
			}
// 			pr($dcCode);
			$dcData = $this->Ordercom->getDiscountCouponData($dcCode);
// pr($dcData); die;
			$discount_coupon_cost = 0;
			$current_date = date('Y-m-d');
			if(!is_array($dcData) ){
				$dc_errmsg = "We're sorry, this discount coupon is invalid!"; 
			} elseif($validDcCode == 'No'){
				$dc_errmsg = "No more coupons can be applied in one order!";
			} elseif(count($dcData) == 0){
				$dc_errmsg = "We're sorry, this discount coupon is invalid!"; 
			} elseif(strtotime($dcData['Coupon']['expiry_date']) < strtotime($current_date)){
				$dc_errmsg = "We're sorry, this coupon expired on ".date(DATE_FORMAT,strtotime($dcData['Coupon']['expiry_date'])).".";
			} else{
				
				$dc_code   = $dcData['Coupon']['discount_code'];
				$dc_option = $dcData['Coupon']['discount_option'];
				$dc_num_times_canbe_used  = $dcData['Coupon']['used_times'];

// 				pr($dcData);
				if(!empty($dcData['Coupon']['cust_use_limit'])) {
					
					$total_coupon_used = $this->Ordercom->countHowManyTimesUsed($dc_code, $user_id);
				} else {
					$total_coupon_used = $this->Ordercom->countHowManyTimesUsed($dc_code);
				}
// 				pr('total_coupon_used : '.$total_coupon_used);
// 				pr('dc_num_times_canbe_used : '.$dc_num_times_canbe_used); 
				// if limited times offer and  allowed used limit is less than used by user
				//if(($dc_num_times_canbe_used != '0') &&  ($total_coupon_used <= $dcData['Coupon']['cust_use_limit'])){ // limited times offer
				if(($dc_num_times_canbe_used != '0') &&  ($total_coupon_used > $dcData['Coupon']['used_times'])){ // limited times offer
					$dc_errmsg = "Coupon used limit has been reached !";
					$discount_coupon_cost = '0';
				} else if($dc_num_times_canbe_used != '0' && ($dc_num_times_canbe_used <= $total_coupon_used) ){ // limited times offer
// echo 'elseif'; die;
					$dc_errmsg = "Coupon used limit has been reached !";
					$discount_coupon_cost = '0';
				} else{ // unlimited times offer
					
					switch($dc_option):
					case '1': // Specific Amount Off
					case '2': // Percent Off 
						$dc_cust_use_limit      = $dcData['Coupon']['cust_use_limit'];
						
						if($dc_cust_use_limit == '1'){ // one per user
							if($total_coupon_used > 1){
								$dc_errmsg = "Coupon has been used !";
								$discount_coupon_cost = '';
								break;
							}
						}
						$dc_order_limit           = $dcData['Coupon']['order_limit'];
						$dc_orderlimit_amount     = $dcData['Coupon']['orderlimit_amount'];


// 						if($dcData['Coupon']['specific_amount_off'] > $order_amount){
// 							$dc_errmsg = "Coupon can be used for order more than ".@$dcData['Coupon']['specific_amount_off']." !";
// 							$discount_coupon_cost = '';
// 							break;
// 						}
						if($dc_order_limit == '1'){ // on defined amount
							if($dc_orderlimit_amount > $order_amount){
								$dc_errmsg = "Coupon can be used for order more than ".$dc_orderlimit_amount." !";
								$discount_coupon_cost = '';
								break;
							}
						}
												
						$dc_catalog_limit =  $dcData['Coupon']['catalog_limit'];
						$dc_product_code  =  $dcData['Coupon']['product_code'];
						// 1 for any 2 for selected product , 2 for category selected
						
						if($dc_catalog_limit == '2'){ // for selected product
							
							if(!in_array($dc_product_code, $order_product_codes) ){
								//$dc_errmsg = "This coupon can not be used for this order as it is applicable for another products !";
								$dc_errmsg = 'We\'re sorry, this discount coupon is only applicable when purchasing item number QCID '.$dcData['Coupon']['product_code'].', please add this to your basket to validate this coupon.';
								$discount_coupon_cost = '';
								break;
							}
							
						} elseif($dc_catalog_limit == '3'){ // for selected department/category 
							$dc_department_id =  $dcData['Coupon']['department_id'];
							if(!in_array($dc_department_id, $order_department_ids) ){
								$dc_errmsg  = "This coupon can not be used for this order as it is for another department products !";
								$discount_coupon_cost = '';
								break;
							}
							
						}
							
						if($dc_option == '1'){ // specfi amount off
							if($dcData['Coupon']['specific_amount_off'] > $order_amount){
								//$dc_errmsg = "Coupon can be used for order more than ".@$dcData['Coupon']['specific_amount_off']." !";
								$dc_errmsg = "We're sorry, you must spend over ".CURRENCY_SYMBOL." ".@$dcData['Coupon']['specific_amount_off']." in order to qualify for this discount!";
								$discount_coupon_cost = '';
								break;
							}
							$discount_coupon_cost = $dcData['Coupon']['specific_amount_off'];
							
						} elseif($dc_option == '2'){ // percentage off
							
							$dc_percentage        = $dcData['Coupon']['percent_off'];
							$discount_coupon_cost = ($order_amount * $dc_percentage)/100;
						} else{
							$discount_coupon_cost = 0;
						}

						break;
					case '3': //Free Shipping ( Shipping not charged if checked. )
						
						$dc_cust_use_limit      = $dcData['Coupon']['cust_use_limit'];
						
						if($dc_cust_use_limit == '1'){ // one per user
							if($total_coupon_used_byuser > 1){
								$dc_errmsg = "Coupon has been used !";
								$discount_coupon_cost = '';
								break;
							}
						}
						
						$dc_order_limit           = $dcData['Coupon']['order_limit'];
						$dc_orderlimit_amount     = $dcData['Coupon']['orderlimit_amount'];
						if($dc_order_limit == '1'){ // on defined amount
							if($dc_orderlimit_amount > $order_amount){
								$dc_errmsg = "Coupon can be used for order more than ".$dc_orderlimit_amount." !";
								$discount_coupon_cost = '';
								break;
							}
						}
						$discount_coupon_cost = $basketPriceData['shipping_total_cost'];
						break;
					default:
						$discount_coupon_cost = 0;
						break;
					endswitch;
				
				}
				
			}
			// Set error message rH2175120h
			// echo "<script type=\"text/javascript\"> jQuery('#coupon_code_error').html('".$dc_errmsg."');</script>";
			//$this->Session->setFlash($dc_errmsg,'default',array('class'=>'flashError'));
			//For Mobile message sucess message..
			if(!empty($dc_errmsg)){
				$this->Session->setFlash($dc_errmsg,'default',array('class'=>'flashError'));
			}else{
				$this->Session->setFlash('Discount coupon has been used successfully','default',array('class'=>'message'));
			}
			##### Apply coupon cost if applied by user
			if(!empty($discount_coupon_cost) ){
				$dcCodeSessData['discount_code']   = $dcCode;
				$dcCodeSessData['amount'] 	   = $discount_coupon_cost;
				$this->Session->write('dcSessData', $dcCodeSessData);
			}
		}
		############################################################################################
		$this->redirect('/checkouts/step4'); exit;
		//$this->viewPath = "elements/checkout";
		//$this->render('basket_order_summary_box');
	}
	
	/** 
	@function: getBasketOrderSummaryBox
	@Created by: Kulvinder
	@Modify:  28 jan 2010 
	*/
	function basket_order_summary(){
		/*
		$this->layout = 'ajax';
		$user_id = $this->Session->read('User.id');
		
		$settings = $this->Common->get_site_settings(); // get site settings data
		$this->set('settings', $settings);
		
		$gcBalanceData  = $this->Ordercom->getUserGiftbalance($user_id); // get gift balance data for user
		$this->set('gc_amount', $gcBalanceData);
		
		$sessOrderData = $this->Session->read('sessOrderData');
		$this->set('sessOrderData', $sessOrderData);
		
		$basketPriceData = $this->Ordercom->getBasketPriceInfo(); // get baslet price info data
		$this->set('basketPriceData', $basketPriceData);
		
		$this->viewPath = "elements/checkout";
		$this->render('basket_order_summary_box');
		
		*/
	}
	
	/**
	* @Date: Jan 20, 2011
	* @Method : 
	* @created:  kulvinder
	* @Param: 
	* @Return: 
	**/
	function step4(){
		$this->set('title_for_layout','Choiceful.com Checkout - Review Order');
		if ($this->RequestHandler->isMobile()) {
 			$this->layout = 'mobile/home';
		} else if($this->RequestHandler->isAjax()==0){
 			$this->layout = 'checkout';
			} else{
				$this->layout = 'ajax';
		}
		
		// set the basket data as per the quantitiy of in stock
		$this->Ordercom->setBasketDataAsPerStock();
		
		
		// logedin user id
		$user_id 		= $this->Session->read('User.id');
		$userdata 		= $this->Common->get_user_billing_info($user_id);
		$NewUsedcondArray 	= $this->Common->get_new_used_conditions();
		$settings 		= $this->Common->get_site_settings();
		$this->set('settings', $settings);
		$this->set('NewUsedcondArray', $NewUsedcondArray);
		### get cart listing data
		$cartData = $this->Common->get_basket_listing();
		$this->set('cartData', $cartData);
		
		
		
		if(empty($cartData) ){ // send to index page if the basket is empty
			$this->redirect('/');
		}
		$titles = $this->Common->get_titles();
		$this->set('title',$titles);
		$countries = $this->Common->getcountries();
		$this->set('countries',$countries);
		
		# import the Basket DB to upate the fist option and gift messages
		App::import('Model', 'Order');
		$this->Order = new Order();
		
		
		##########################
		$gcBalanceData  = $this->Ordercom->getUserGiftbalance($user_id); // get gift balance data for user
		$this->set('gc_amount', $gcBalanceData);
		
		$basketPriceData = $this->Ordercom->getBasketPriceInfo(); // get baslet price info data
		$this->set('basketPriceData', $basketPriceData);
		############################################
		
		
		
		if(!empty($this->data)){
			
			$this->data = $this->cleardata($this->data);
			//$this->data = Sanitize::clean($this->data, array('encode' => false));
			
			$this->Order->set($this->data);
			$orderInfoValidate = $this->Order->validates();
			if(!empty($orderInfoValidate)){
			} else{
				$errorArray = $this->Order->validationErrors;
				$this->set('errors',$errorArray);
			}
		} else{
			# read the session data and set for the view
			$sessOrderData = $this->Session->read('sessOrderData');
			//pr($sessOrderData);
			/*if($sessOrderData['shipping_same'] == 1){ // if shipping and billing are same
				$sessOrderData['billing_user_title'] 	= $sessOrderData['billing_user_title'];
				$sessOrderData['billing_firstname'] 	= $sessOrderData['billing_firstname'];
				$sessOrderData['billing_lastname'] 	= $sessOrderData['billing_lastname'];
				$sessOrderData['billing_address1'] 	= $sessOrderData['billing_address1'];
				$sessOrderData['billing_address2']	= $sessOrderData['billing_address2'];
				$sessOrderData['billing_city'] 		= $sessOrderData['billing_city'];
				$sessOrderData['shipping_country_id'] 	= $sessOrderData['billing_country_id'];
				$sessOrderData['billing_state'] 	= $sessOrderData['billing_state'];
				$sessOrderData['billing_postal_code']	= $sessOrderData['billing_postal_code'];
			}*/
			$this->set('sessOrderData', $sessOrderData);
			if(empty($sessOrderData) ){ // if session data is empty then send to step 3 page
				$this->redirect('/checkouts/step3');
			}
		}
	}
	
	/**
	* @Date: Jan 31, 2011
	* @Method : submit_order
	* @created:  kulvinder
	* @Param: 
	* @Return: 
	**/
	function submit_order(){
		
		$this->layout = 'ajax';
		$user_id = $this->Session->read('User.id');
		$this->Session->write('order_complete', 'no');
		
		$settings = $this->Common->get_site_settings(); // get site settings data
		$this->set('settings', $settings);
		
		$countries    = $this->Common->getcountries(); 		// get countries array
		$countrycodes = $this->Common->getCountryCodes(); 	// get country coders array
		$userMailInfo = $this->Common->getUserMailInfo($user_id);
		$paymentMethodsArray[1] = 'Sage';
		$paymentMethodsArray[2] = 'PayPal';
		$paymentMethodsArray[3] = 'Google Checkout';
		$paymentMethodsArray[4] = 'Internal';
		$paymentMethodsArray[5] = 'Credit/Debit Card';
		
		# import order data DB
		App::import('Model', 'Order');
		$this->Order = new Order();
		# import order data DB
		
		if(!empty($this->data)){
			$sessOrderData = $this->Session->read('sessOrderData');
			if(empty($sessOrderData) || count($sessOrderData) <= 0){
				$this->Session->setFlash('Please add product to your basket.','default',array('class'=>'flashError'));
				$this->redirect('/baskets/view');
			} elseif($this->data['Order']['payment_method'] == '' ){
				
			} else{ // process further
				##################### Save the data in temporary order table ##################
				$paymentMethod    = $this->data['Order']['payment_method'];
				$basketPriceData  = $this->Ordercom->getBasketPriceInfo(); // get baslet price info data
				$gcBalanceAmount  = $this->Ordercom->getUserGiftbalance($user_id); // get gift balance data for user
				$this->set('gcBalanceAmount', $gcBalanceAmount);
				$this->data['Order']['id'] = '';
				$this->data['Order']['session_id'] = session_id();
				$this->data['Order']['user_id'] = $user_id;
				$this->data['Order']['user_email'] = $userMailInfo['User']['email'];
				$this->data['Order']['billing_user_title'] = $sessOrderData['billing_user_title'];
				$this->data['Order']['billing_firstname'] = $sessOrderData['billing_firstname'];
				$this->data['Order']['billing_lastname'] = $sessOrderData['billing_lastname'];
				$this->data['Order']['billing_address1'] = $sessOrderData['billing_address1'];
				$this->data['Order']['billing_address2'] = $sessOrderData['billing_address2'];
				$this->data['Order']['billing_city'] 	= $sessOrderData['billing_city'];
				$this->data['Order']['billing_state'] 	= $sessOrderData['billing_state'];
				$this->data['Order']['billing_postal_code'] = $sessOrderData['billing_postal_code'];
				$this->data['Order']['billing_country'] 	= $sessOrderData['billing_country_id'];
				$this->data['Order']['billing_phone'] 	= $sessOrderData['billing_phone'];
				$this->data['Order']['shipping_same'] 	= $sessOrderData['shipping_same'];
				$this->data['Order']['shipping_user_title'] = $sessOrderData['shipping_user_title'];
				$this->data['Order']['shipping_firstname'] = $sessOrderData['shipping_firstname'];
				$this->data['Order']['shipping_lastname'] = $sessOrderData['shipping_lastname'];
				$this->data['Order']['shipping_address1'] = $sessOrderData['shipping_address1'];
				$this->data['Order']['shipping_address2'] = $sessOrderData['shipping_address2'];
				$this->data['Order']['shipping_city'] 	= $sessOrderData['shipping_city'];
				$this->data['Order']['shipping_state'] 	= $sessOrderData['shipping_state'];
				$this->data['Order']['shipping_postal_code'] = $sessOrderData['shipping_postal_code'];
				$this->data['Order']['shipping_country'] = $sessOrderData['shipping_country_id'];
				$this->data['Order']['shipping_phone'] = $sessOrderData['shipping_phone'];
				$this->data['Order']['comments'] = $sessOrderData['comments'];
				$this->data['Order']['insurance'] = $sessOrderData['insurance'];
				$this->data['Order']['payment_status'] = 'N';
				$this->data['Order']['payment_method'] = $paymentMethodsArray[$this->data['Order']['payment_method']];
				
				if($sessOrderData['insurance'] == '1'){
					$insurance_amount  = $settings['Setting']['insurance_charges'];
				} else{
					$insurance_amount  = '0.00';
				}
				$this->data['Order']['insurance_amount'] = $insurance_amount;
				
				############# Coupon data Starts here 
				$dcSessData = $this->Session->read('dcSessData');
				if(!empty($dcSessData) ){
					$discount_coupon_amount = $dcSessData['amount'];
					$discount_code = $dcSessData['discount_code'];
				} else{
					$discount_coupon_amount = 0;
					$discount_code = '';
				}
				$this->data['Order']['dc_amount'] = $discount_coupon_amount;
				$this->data['Order']['dc_code']   = $discount_code;
				############# Coupon data Starts here
				$item_cost = $basketPriceData['item_total_cost'];
				$shipping_total_cost = $basketPriceData['shipping_total_cost'];
				$giftwrap_total_cost = $basketPriceData['giftwrap_total_cost'];
				$this->data['Order']['shipping_total_cost']  = $shipping_total_cost;
				$this->data['Order']['giftwrap_total_cost']  = $giftwrap_total_cost;
				$order_total_cost_before = $item_cost+$shipping_total_cost+$giftwrap_total_cost+$insurance_amount;
				
				if(!empty($gcBalanceAmount) ){
					if($gcBalanceAmount > $order_total_cost_before){
						$gcBalanceAmount = $order_total_cost_before;
					} else{
						$gcBalanceAmount = $gcBalanceAmount;
					}
					
				} else{
					$gcBalanceAmount = 0;
				}
					
				$this->data['Order']['gc_amount']  = $gcBalanceAmount;
				$userAppliedBalanceCost = $gcBalanceAmount+$discount_coupon_amount;
				$order_total_cost = $order_total_cost_before-($userAppliedBalanceCost);
					
				$tax  = $settings['Setting']['tax'];
					
				$order_total_cost_before_tax = round(($order_total_cost/(1+($tax/100))),2);
				$tax_total_cost = round(($order_total_cost - $order_total_cost_before_tax),2);
					
				//$tax_total_cost = ($order_total_cost*$tax)/100;
					
				$this->data['Order']['tax_amount']  = $tax_total_cost;
				$this->data['Order']['tax_percentage'] = $tax;
				if($order_total_cost <= 0){ // cost balanced by gift certificates and discount coupon amount
					$this->data['Order']['payment_method'] = "Internal";
					//$this->data['Order']['order_total_cost']  = $order_total_cost_before;
				} 
					$this->data['Order']['order_total_cost']  = $order_total_cost_before;
					
					
				//pr($this->data); exit;
				
				if ($this->RequestHandler->isMobile()) {
					$this->data['Order']['mobile_users'] =1;
				}else{
					$this->data['Order']['mobile_users'] =0;
				}
				$this->Order->set($this->data);
				
				$this->Order->save($this->data); // save Order data in order table 
				$order_id 	=  $this->Order->getLastInsertId(); // get last inserted order id
				$order_number   =  $this->Ordercom->generatOrderNumber($order_id); // get number in a proper format
				
				
				
				$this->Order->id = $order_id;
				$this->Order->saveField('order_number',$order_number);
				$this->Ordercom->setOrderNumberInBasker($order_id); // set order number in a baskets
				
				################## payment processing section starts here ######################
				// Fetch the Latest order data
				$orderData = $this->Order->findById($order_id);
				$orderData = $orderData['Order'];				
				##############
				$orderData['billing_country']  = $countrycodes[$orderData['billing_country']];
				$orderData['shipping_country'] = $countrycodes[$orderData['shipping_country']];
				################
				$site_url 	= SITE_URL;
				$paymentMethod 	= trim($orderData['payment_method']);
				
				switch($paymentMethod):
				case 'Internal': // if order payment is zero then process order locallly 
				case 'local':
					$orderId = $order_id;
					$orderSuccessData['order_id'] = $orderId;
					//$orderSuccessData['tranx_id'] = strtoupper($this->Common->randomNumber(15));
					$orderSuccessData['tranx_id'] = "X00000000YYX5699410";  // hard coded transaction code provided by choiceful
					
					$this->processOrderConfirmation($orderSuccessData); 	// update payemt status yes with transaction id
					$this->sendOrderConfirmationEmail($orderId); 		// send order confirmation email to customer
					$this->sendOrderDispatchNowEmail($orderId); 			// send order confirmation email to customer
					$orderId_encoded = base64_encode($orderId);
					$this->redirect('/checkouts/order_complete/'.$orderId_encoded);
						
					break;
					
				case 'Sage': // pay flow "Sage payment " 
					
					
					//$strConnectTo = "Test";
					$strConnectTo = "LIVE";
					####### gateway url #########################
					if ($strConnectTo == "LIVE"){
						$strPurchaseURL = "https://live.sagepay.com/gateway/service/vspform-register.vsp";
					} else{
						$strPurchaseURL = "https://test.sagepay.com/gateway/service/vspform-register.vsp";
						//$strPurchaseURL = "https://test.sagepay.com/gateway/service/vspserver-register.vsp";
					}
					$strPost = $this->Sage->getstrPost($orderData);
					//$this->Sage->getstrBasket($this->data);
					$strBasket = '';
					//$strPost = $strPost . "&Basket=" . $strBasket; 		
					
					// Encrypt the plaintext string for inclusion in the hidden field
					$strCrypt   = $this->Sage->base64Encode($this->Sage->SimpleXor($strPost,$this->Sage->strEncryptionPassword));
					$strdeCrypt = $this->Sage->SimpleXor($this->Sage->base64Decode($strCrypt),$this->Sage->strEncryptionPassword) ;
					//die(__FUNCTION__);
					$this->Sage->gateway_url = $strPurchaseURL;   // payment gateway url
					$this->Sage->add_field('TxType', $this->Sage->strTransactionType);
					$this->Sage->add_field('Vendor', $this->Sage->strVSPVendorName);
					$this->Sage->add_field('Currency', 'GBP');
					$this->Sage->add_field('Crypt', $strCrypt);
					$this->Sage->submit_post();
					break;
					
				case 'PayPal': // Paypal
					//$strConnectTo = "Test";
					$strConnectTo = "LIVE";
					if ($strConnectTo == "LIVE"){
						$this->Paypal->paypal_url = 'https://www.paypal.com/cgi-bin/webscr';   // live paypal url
						$this->Paypal->add_field('business', 'milestones247@gmail.com');
					} else{
						$this->Paypal->paypal_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';   // paypal sndbox testing url
					}
					
					//$this->Paypal->add_field('return', $site_url.'checkouts/paypal_return');
					$this->Paypal->add_field('return', $site_url.'checkouts/order_complete/'.base64_encode($order_id));
					$this->Paypal->add_field('cancel_return', $site_url.'checkouts/step4');
					$this->Paypal->add_field('notify_url', $site_url.'checkouts/paypal_return');
					$this->Paypal->add_field('cmd', '_cart');
					$this->Paypal->add_field('rm', '2');
					$this->Paypal->add_field('upload', '1');
					$this->Paypal->add_field('currency', 'GBP');
					$this->Paypal->add_field('currency_code', 'GBP');
					$this->Paypal->add_field('item_name', 'Choiceful Products Payment');
					$this->Paypal->add_field('invoice', $orderData['order_number']);
					$this->Paypal->add_field('amount',  $orderData['order_total_cost']);
					$this->Paypal->add_field('no_shipping', '1');
					$this->Paypal->add_field('image_url', $site_url.'/img/checkout/choiceful-logo.png');
					
					$basketItemsData = $this->Common->get_basket_listing(); //get basket listing data
					//pr($basketItemsData); exit;
					if(is_array($basketItemsData) ){
						$i = 0;
						$totalItems = count($basketItemsData);
						foreach($basketItemsData as $item){
							$i++;
							$this->Paypal->add_field('item_name_'.$i,$item['Product']['product_name']);
							$this->Paypal->add_field('item_number_'.$i, $i);
							$this->Paypal->add_field('quantity_'.$i, $item['Basket']['qty']);
							$this->Paypal->add_field('amount_'.$i, $item['Basket']['price']);
							
							if($item['Basket']['delivery_method'] == 'E'){
								$shippingAmount = $item['Basket']['exp_delivery_cost']*$item['Basket']['qty'];
							}else{
								$shippingAmount = $item['Basket']['delivery_cost']*$item['Basket']['qty'];
							}
							$this->Paypal->add_field('handling_'.$i, $shippingAmount);
							unset($shippingAmount);
						}
					}
					
					$insurance_cost = $this->data['Order']['insurance_amount'];
					if($insurance_cost > 0){
						// $this->Paypal->add_field('handling_cart', number_format($insurance_cost,2) );
					}
					
					
					$gw = $totalItems+1;
					
					$gw_cost = $orderData['giftwrap_total_cost'];
					//$gw_cost = 10;
					if($gw_cost > 0){ $ic = $totalItems+2;
						$this->Paypal->add_field("item_name_".$gw, 'Gift Wrapup charges');
						$this->Paypal->add_field("quantity_".$gw,'1');
						$this->Paypal->add_field("amount_".$gw, number_format($gw_cost,2));
					}else{
						$ic = $totalItems+1;
					}
					
					
					$shipping_handling_cost = $this->data['Order']['shipping_total_cost'];
					if($insurance_cost > 0){
						$this->Paypal->add_field('item_name_'.$ic, 'Insurance charges');
						//$this->Paypal->add_field('quantity_'.$ic, '1');
						$this->Paypal->add_field('amount_'.$ic, number_format($insurance_cost,2));
					}
					
					if($shipping_handling_cost > 0){
						//	 $this->Paypal->add_field('handling_cart', number_format($shipping_handling_cost,2) );
					}
					
				//*/		
					$discount_coupon_amount = $this->data['Order']['dc_amount']+$this->data['Order']['gc_amount'] ;
					if($discount_coupon_amount > 0){
						$this->Paypal->add_field('discount_amount_cart', number_format($discount_coupon_amount,2) );
					}
					$this->setexpresscheckout($orderData['order_total_cost'],$orderData['order_number'],$shipping_handling_cost,$insurance_cost,$gw_cost,'paypal');
					//$this->Paypal->submit_paypal_post();					
					break;
						
				case 'Credit/Debit Card': // Paypal
					$shipping_handling_cost = $this->data['Order']['shipping_total_cost'];
					$insurance_cost = $this->data['Order']['insurance_amount'];
					$gw_cost = $orderData['giftwrap_total_cost'];
					$this->setexpresscheckout($orderData['order_total_cost'],$orderData['order_number'],$shipping_handling_cost,$insurance_cost,$gw_cost);
					
					break;
				
				case 'Google Checkout': // payment processing through google checkout 
					 // call google check out function to process the google payment
				        $GoogleCheckOutButton = $this->Googlecheckout->processGoogleCheckout($orderData);   // sandbox - live
					echo  '<div style="display:none">'.$GoogleCheckOutButton.'</div>';
					echo '<div><center><h3>Please wait, your order is being processed...</h3></center></div>';
					echo '<script language="javascript">document.GoogleCheckout.submit();</script>';
					break;
				endswitch;
				######################################## 
				
			} // processing block
		}
		
		exit;
	}

	/**
	* @Date: Feb 09-2011
	* @Method : protx_return
	* @created:  kulvinder
	* @Param: 
	**/
	function protx_return(){
		$this->layout = 'ajax';
		$user_id = $this->Session->read('User.id');
		$url = SITE_URL."checkouts/step4";
			
		$strCrypt = $_REQUEST["crypt"];
			
		$strVendorEMail = $this->Sage->strVendorEMail;
			
		// Now decode the Crypt field and extract the results
		$strDecoded 	= $this->Sage->simpleXor($this->Sage->Base64Decode($strCrypt),$this->Sage->strEncryptionPassword);
		$values  	= $this->Sage->getToken($strDecoded);
		$_status 	= strtoupper($values['Status']);
			
		// Split out the useful information into variables we can use
		$_status = strtoupper($values['Status']);
			
		if($_status == 'REGISTERED' ||  $_status == 'OK'){ // if payment successfull
		//if($_status == 'OK' ){ // if payment successfull
			
			$tranx_id    = str_replace("{", "", $values['VPSTxId']);
			$tranx_id    = str_replace("}", "", $tranx_id) ;
			$order_number = $values['VendorTxCode'];
			$orderIdData = $this->Ordercom->getOrderIdFromNumber($order_number);
			$orderId = $orderIdData['Order']['id'];
						
			$orderSuccessData['order_id'] = $orderId;
			$orderSuccessData['tranx_id'] = $tranx_id;
			$this->processOrderConfirmation($orderSuccessData); 	// update payemt status yes with transaction id
			$this->sendOrderConfirmationEmail($orderId); 		// send order confirmation email to customer
			$this->sendOrderDispatchNowEmail($orderId); 			// send order confirmation email to customer
			$orderId_encoded = base64_encode($orderId);
			$this->redirect('/checkouts/order_complete/'.$orderId_encoded.'?&utm_nooverride=1');
		} else{ // is payment gateway send error 
			
			if ($_status=="NOTAUTHED"){
				$strReason="You payment was declined by the bank.  This could be due to insufficient funds, or incorrect card details.";
			} else if ($_status=="ABORT"){
				$strReason="You chose to Cancel your order on the payment pages.  If you wish to change your order and resubmit it you can do so here. If you have questions or concerns about ordering online, .";
			} else if ($_status=="REJECTED"){
				$strReason="Your order did not meet our minimum fraud screening requirements. If you have questions about our fraud screening rules, or wish to contact us to discuss this,.";
			} else if ($_status=="INVALID" or $_status=="MALFORMED"){
				$strReason="We could not process your order because we have been unable to register your transaction with our Payment Gateway.";
			} else{
				$strReason="We could not process your order because our Payment Gateway service was experiencing difficulties.";
			}
			$strReason .= "or <a href=\"$url\">Click here</a> to return to the order review page to try other payment methods";
			$message =   "The transaction process failed. Please contact us with the date and time of your order and we will investigate by clicking <a href='mailto:$strVendorEMail'>here</a><br /><br />$strReason";
		}
		exit;
	}
	
	/**
	* @Date: Feb 09-2011
	* @Method : protx_error
	* @created:  kulvinder
	* @Param:  error handling function for sage payment processing
	**/
	function protx_error(){
		$this->layout = 'ajax';
		
		$strVendorEMail = $this->Sage->strVendorEMail;
		$url = SITE_URL."checkouts/step4";
		
		$strCrypt = $_REQUEST["crypt"];
		// Now decode the Crypt field and extract the results
		$strDecoded 	= $this->Sage->simpleXor($this->Sage->Base64Decode($strCrypt),$this->Sage->strEncryptionPassword);
		
		//pr($strDecoded);
		$values = $this->Sage->getToken($strDecoded);
		$_status = strtoupper($values['Status']);
		
		if ($_status=="NOTAUTHED"){
			$strReason="You payment was declined by the bank.  This could be due to insufficient funds, or incorrect card details.";
		} else if ($_status=="ABORT"){
			$strReason="You chose to Cancel your order on the payment pages.  If you wish to change your order and resubmit it you can do so here. If you have questions or concerns about ordering online, or <a href=\"$url\">Click here</a> to return to the cart page to try other payment methods.";
		} else if ($_status=="REJECTED"){
			$strReason="Your order did not meet our minimum fraud screening requirements. If you have questions about our fraud screening rules, or wish to contact us to discuss this. or <a href=\"$url\">Click here</a> to return to the cart page to try other payment methods.";
		} else if ($_status=="INVALID" or $_status=="MALFORMED"){
			$strReason="We could not process your order because we have been unable to register your transaction with our Payment Gateway.  or <a href=\"$url\">Click here</a> to return to the cart page to try other payment methods.";
		} else if ($_status=="ERROR"){
			$strReason="We could not process your order because our Payment Gateway service was experiencing difficulties.  or <a href=\"$url\">Click here</a> to return to the order review page to try other payment methods..";
		}
		
		echo $message =   "The transaction process failed. Please contact us with the date and time of your order and we will investigate by clicking <a href='mailto:$strVendorEMail'>here</a><br /><br />$strReason";
		
		exit;	
	}
		
	/**
	* @Date: Feb 15-2011
	* @Method : paypal_error
	* @created:  kulvinder
	* @Param:  error handling function for paypla payment processing
	**/
	function paypal_error(){
		$this->layout = 'ajax';		
		$url = SITE_URL."checkouts/step4";
		echo $strReason="We could not process your order because our Payment Gateway service was experiencing difficulties.  or <a href=\"$url\">Click here</a> to return to the cart page to try other payment methods..";
		exit;	
	}
	
	/**
	* @Date: Feb 15-2011
	* @Method : paypal_return
	* @created:  kulvinder
	* @Param: 
	**/
	function paypal_return($certificate = null){
		$this->layout = 'ajax';		
		$user_id = $this->Session->read('User.id');
		$url = SITE_URL."checkouts/step4";
		$req = 'cmd=_notify-validate';
		// pr($_POST);exit;
		if(isset($_POST) && count($_POST) > 0) {
			foreach ($_POST as $key => $value) {
				$value = urlencode(stripslashes($value));
				$req .= "&$key=$value";
			}
				
			// post back to PayPal system to validate
			$header = "POST /cgi-bin/webscr HTTP/1.0\r\n";
			$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
			$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
			$fp = fsockopen ('ssl://www.paypal.com', 443, $errno, $errstr, 30);
			
			if (!$fp) {
				// HTTP ERROR
				die('Coluld not validate the paypal request');
			} else {
				
				$data['payment_status'] = "Completed";
				if($data['payment_status'] == 'Completed'){
					if($certificate != 'giftcertificate') {
						$order_number = $_POST['invoice'];
						$orderIdData = $this->Ordercom->getOrderIdFromNumber($order_number);
						$orderId = $orderIdData['Order']['id'];
						$orderSuccessData['order_id'] = $orderId;
						$orderSuccessData['tranx_id'] = $_POST['txn_id'];
						
						$this->processOrderConfirmation($orderSuccessData); // update payemt status yes with transaction id
						$this->sendOrderConfirmationEmail($orderId); // send order confirmation email to customer
						$this->sendOrderDispatchNowEmail($orderId); // send order confirmation email to customer
						$orderId_encoded = base64_encode($orderId);
						//$this->redirect('/checkouts/order_complete/'.$orderId_encoded);
					} else {
						$this->data = '';
						$this->data['Certificate']['order_certificate_id'] = $_POST['invoice'];
						$this->data['OrderCertificate']['id'] = $_POST['invoice'];
						$this->data['OrderCertificate']['payment_status'] = "Y";
						$this->data['OrderCertificate']['tranx_id'] = $_POST['txn_id'];
						
						$this->update_ordercertificate($this->data);
						$this->Session->write('giftcertificate_orderId',$_POST['invoice']);
						$this->Session->write('giftcertificate_tranx_id',$_POST['txn_id']);
						$this->save_certificate_payment($this->data['Certificate']['order_certificate_id']);
						$this->send_certificate_email($this->data['Certificate']['order_certificate_id']);
						exit;
						//$this->redirect('/checkouts/giftcertificate_step4/1');
					}
				}
			}
		}
		exit;
	}



	/**
	* @Date: Feb 15-2011
	* @Method : google_return
	* @created:  kulvinder
	* @Param:  function to handle the google checkout responce
	**/
	function google_return(){
		//mail('gyanp.sdei@gmail.com', 'Google gift  Fail', 'yes');
		
		$this->layout = 'ajax';		
		//$user_id = $this->Session->read('User.id');
		$url = SITE_URL."checkouts/step4";
		
		$Gresponse = $this->Googleresponcehandler->processGoogleResponce();
		
		$orderType = $Gresponse['order_type'];
		if($orderType == 'GIFT'){ // notification for the gift certificates
			$this->google_gift_return($Gresponse);
			
		}else if($orderType == 'CART'){// notification for the shopping cart order
			
			$_status = $Gresponse['status'];
			if($_status == 'OK' ){ // if payment successfull
				$order_number 	= $Gresponse['order_number'];
				$orderIdData = $this->Ordercom->getOrderIdFromNumber($order_number);
				
				$orderId    		      = $orderIdData['Order']['id'];
				$orderSuccessData['order_id'] = $orderId ;
				$orderSuccessData['tranx_id'] = $Gresponse['tranx_id']; 
				$getOrderList = $this->getOrderList();
				if(!array_key_exists($orderId,$getOrderList)){
					$this->processOrderConfirmation($orderSuccessData); 	// update payemt status yes with transaction id
					$this->sendOrderConfirmationEmail($orderId); 		// send order confirmation email to customer
					$this->sendOrderDispatchNowEmail($orderId);		// send order confirmation email to customer
				}
				//$orderId_encoded = base64_encode($orderId);
				//$this->redirect('/checkouts/order_complete/'.$orderId_encoded);
			} else{ // is payment gateway send error 
				echo $strReason="We could not process your order because our Payment Gateway service was experiencing difficulties.  or <a href=\"$url\">Click here</a> to return to the order review page to try other payment methods..";
				//mail('guanp.sdei@gmail.com', 'Google checkout Fail', $strReason);
			}
		}
	}
		
	/**
	* @Date: Feb 10-2011
	* @Method : processOrderConfirmation
	* @created:  kulvinder
	* @Param:  to comate the order process by updating the payment status and sending the mail
	**/
	function processOrderConfirmation($orderSuccessData){
		$this->layout = 'ajax';
		if(empty($orderSuccessData) ){
			return false;
		}
		
		########### check the processing of order 
		$orderProcessedFlag = $this->Session->read('order_complete');
		if($orderProcessedFlag == 'yes'){ // if order processed then skip the order items  entry
			 $this->redirect('/orders/view_open_orders');
		}
		
		# import order data DB
		App::import('Model', 'Order');
		$this->Order = new Order();
		
		# import order item code data Db
		App::import('Model', 'OrderItem');
		$this->OrderItem = new OrderItem();
		
		App::import('Model', 'OrderSeller');
		$this->OrderSeller = new OrderSeller();
		
		$orderId	= $orderSuccessData['order_id'];
		$tranx_id	= $orderSuccessData['tranx_id'];
		############################### confirm payment 
		$this->data['Order']['id'] 		= $orderId;
		$this->data['Order']['tranx_id'] 	= $tranx_id;
		$this->data['Order']['payment_status'] 	= 'Y';
		$this->Order->save($this->data['Order']);
		
		############### Save the order item data #####################################
		//  get the basket listing data
		$cartData = $this->Ordercom->getOrderBasketData($orderId);
		//pr($cartData); die();
		$sellerIds = array();
		if(is_array($cartData) && count($cartData) >0 ) {
			$i=0; $Item_price = 0;
			foreach($cartData as $cart){
				//pr($cart);
				$prodId   	= $cart['Basket']['product_id'];
				$sellerId 	= $cart['Basket']['seller_id'];
				$prodQty 	= $cart['Basket']['qty'];
				$prodPrice 	= $cart['Basket']['price'];
				$sellerIds[$i] 	= $sellerId;
				$sellerData = $this->Ordercom->getSellerInfo($sellerId);
				if(!empty($sellerData) ){
					$seller_name	= $sellerData['Seller']['business_display_name'];
				} else{
					$seller_name = '';
				}
				
				$this->data['OrderItem']['id']   	= '';
				$this->data['OrderItem']['order_id']    = $orderId;
				$this->data['OrderItem']['seller_id']   = $sellerId;
				$this->data['OrderItem']['product_id']  = $prodId;
				$this->data['OrderItem']['quantity']    = $prodQty;
				$this->data['OrderItem']['price']       = $prodPrice;
				$this->data['OrderItem']['condition_id'] 	= $cart['Basket']['condition_id'];
				$this->data['OrderItem']['delivery_method'] 	= $cart['Basket']['delivery_method'];
				if($cart['Basket']['delivery_method'] == 'E'){ //  set express delivery cost
					$this->data['OrderItem']['delivery_cost'] 	= $cart['Basket']['exp_delivery_cost'];
					$this->data['OrderItem']['estimated_delivery_date'] = $cart['Basket']['express_delivery_date'];
					
				} else{
					$this->data['OrderItem']['delivery_cost'] 	= $cart['Basket']['delivery_cost'];
					$this->data['OrderItem']['estimated_delivery_date'] = $cart['Basket']['standard_delivery_date'];
				}
				$this->data['OrderItem']['estimated_dispatch_date'] = $cart['Basket']['estimated_dispatch_date'] ;
				$this->data['OrderItem']['giftwrap'] 		= $cart['Basket']['giftwrap'];
				$this->data['OrderItem']['giftwrap_cost'] 	= $cart['Basket']['giftwrap_cost'];
				$this->data['OrderItem']['gift_note'] 		= $cart['Basket']['giftwrap_message'];
				$this->data['OrderItem']['product_name'] 	= $cart['Product']['product_name'];
				$this->data['OrderItem']['quick_code'] 		= $cart['Product']['quick_code'];
				$this->data['OrderItem']['seller_name'] 	= $seller_name;	
				$this->OrderItem->set($this->data['OrderItem']);
				$this->OrderItem->save($this->data['OrderItem']); // save the order items data
				$this->Ordercom->deductInventory($prodId, $sellerId, $prodQty ); // subtract the quantity from inventory of the seller
				$i++;
				unset($seller_name);unset($sellerData);unset($prodId);
			}
		}
			
		############### Save the order Sellers  data ####################################
		$orderSeller = array_unique($sellerIds);
		if(is_array($orderSeller) && count($orderSeller) >0 ) {
			foreach($orderSeller as $seller){
				$this->data['OrderSeller']['id'] = '';
				$this->data['OrderSeller']['order_id']  = $orderId;
				$this->data['OrderSeller']['seller_id'] = $seller;
				$this->data['OrderSeller']['shipping_status'] = 'Unshipped';
				$this->OrderSeller->set($this->data['OrderSeller']);
				$this->OrderSeller->save($this->data['OrderSeller']); // save the order status data
			}
		}
		############### Save the order Sellers  data Ends Here ###########################
		
		##################
		$cartData = $this->Ordercom->clearBasketOrderData($orderId); // clear the ordered basket data
		##################
	}


	/**
	* @Date: Feb 10-2011
	* @Method : sendOrderConfirmationEmail
	* @created:  kulvinder
	* @Param:  to sending the mail
	**/
	function sendOrderConfirmationEmail($orderId){
		$this->layout = 'ajax';
		if(empty($orderId) ){
			return false;
		}
		App::import('Model', 'Order');
		$this->Order = new Order();
		# get order data 
		$ordData = $this->Order->findById($orderId);
		
		if(empty($ordData)){
			return false;
		} else{
			$ordData = $ordData['Order'];
		}
		
		################### Email Send  Scripts #####################
		$this->Email->smtpOptions = array(
			'host' => Configure::read('host'),
			'username' =>Configure::read('username'),
			'password' => Configure::read('password'),
			'timeout' => Configure::read('timeout')
		);
		
		$this->Email->from = Configure::read('fromEmail');
		
		
		$this->Email->sendAs= 'html';
		$link=Configure::read('siteUrl');
		$countries      = $this->Common->getcountries(); // get countries array
		$template 	= $this->Common->getEmailTemplate(6);	// 6 for order email
		
		$this->Email->from = $template['EmailTemplate']['from_email'];
		
		$data = $template['EmailTemplate']['description'];
		$data = str_replace('[OrderNumber]',	'<a href="'.SITE_URL.'orders/view_open_orders?utm_source=Your+Order+with+Choiceful&amp;utm_medium=email">'.$ordData['order_number'].'</a>',$data);
		//$data = str_replace('[OrderNumber]',	$ordData['order_number'],$data);
		$data = str_replace('[CustomerName]',	$ordData['billing_firstname'],$data);
		$data = str_replace('[CustomerEmail]',	$ordData['user_email'],$data);
		$data = str_replace('[OrderTotal]',	CURRENCY_SYMBOL.$ordData['order_total_cost'],$data);
		
		//$data = str_replace('[BilAddressLine1]',$ordData['billing_address1'],$data);
		//$data = str_replace('[BilAddressLine2]',$ordData['billing_address2'],$data);
		$billingAddress = ($ordData['billing_address2']!='')? "<br/>".$ordData['billing_address2']: "";
		$billingAddress = $ordData['billing_address1'].$billingAddress;
		$data = str_replace('[BilAddressLine1]',$billingAddress,$data);
		$data = str_replace('[BilTown/City]',	$ordData['billing_city'],$data);
		$data = str_replace('[BilCounty]',	$ordData['billing_state'],$data);
		$data = str_replace('[BilPostcode]',	$ordData['billing_postal_code'],$data);
		$data = str_replace('[BilCountry]',	$countries[$ordData['billing_country']],$data);
		
		//$data = str_replace('[ShipAddressLine1]',$ordData['shipping_address1'],$data);
		//$data = str_replace('[ShipAddressLine2]',$ordData['shipping_address2'],$data);
		$shipAddress = ($ordData['shipping_address2']!='')? "<br/>".$ordData['shipping_address2']: "";
		$shipAddress = $ordData['shipping_address1'].$shipAddress;
		$data = str_replace('[ShipAddressLine1]',$shipAddress,$data);
		$data = str_replace('[ShipTown/City]',	 $ordData['shipping_city'],$data);
		$data = str_replace('[ShipCounty]',	 $ordData['shipping_state'],$data);
		$data = str_replace('[ShipPostcode]',	 $ordData['shipping_postal_code'],$data);
		$data = str_replace('[ShipCountry]',	 $countries[$ordData['shipping_country']],$data);
		
		
		// get the list of order items
		$OrderItems = $this->Ordercom->getOrderItems($ordData['id']);
		if(is_array($OrderItems) ){
			$orderDetailStr = '<table align="center" width="100%">';
			foreach($OrderItems as $key=>$item){
				$delMethod = ($item['OrderItem']['delivery_method']=='E')?('Express Delivery'):('Standard Delivery');
				$delDate = date('d-m-Y',strtotime($item['OrderItem']['estimated_delivery_date']));
				$orderDetailStr .= "<tr><td align=\"left\">".$item['OrderItem']['quantity']."</td><td align=\"left\">".$item['OrderItem']['product_name']."</td><td align=\"left\">".CURRENCY_SYMBOL.$item['OrderItem']['price']."</td></tr>";
				$orderDetailStr .= "<tr><td align=\"left\" colspan=\"3\"><b>Delivery Method: </b>".$delMethod."</td></tr>";
				$orderDetailStr .= "<tr><td align=\"left\" colspan=\"3\"><b>Delivery Estimate: </b>".$delDate."</td></tr>";
				$orderDetailStr .= "<tr><td align=\"left\" colspan=\"3\">Sold by: ";
				$orderDetailStr .= "<a href=\"".SITE_URL."sellers/".$item['OrderItem']['seller_name']."/summary/".$item['OrderItem']['seller_id']."/".$item['OrderItem']['product_id']."?utm_source=Your+Order+with+Choiceful&amp;utm_medium=email\">".$item['OrderItem']['seller_name']."</a>";
				$orderDetailStr .= "</td></tr>";
				$orderDetailStr .= "<tr>&nbsp;</tr>";
				unset($delMethod);
				unset($delDate);
			}
			$orderDetailStr .= '</table>';
		} else{
			$orderDetailStr = '';
		}
		$data = str_replace('[OrderDetail]',	 $orderDetailStr,$data);
		$this->Email->subject = $template['EmailTemplate']['subject'];
		$this->set('data',$data);
		$this->Email->to = $ordData['user_email'];
		
		/******import emailTemplate Model and get template****/
		$this->Email->template='commanEmailTemplate';
		$this->Email->send();
		return true;
		################### Send Order Email Ends Here ###########################
	}

	
	/**
	* @Date: Feb 11-2011
	* @Method : sendOrderDispatchNowEmail
	* @created:  kulvinder
	* @Param:  to sending the mail to the all sellers
	**/
	function sendOrderDispatchNowEmail($orderId){
	
		if(empty($orderId) ){
			return false;
		}
		
		//$OrderBasicData   = $this->Ordercom->getOrderNumber($orderId);
		$tmpOrderData = $this->Order->find('first',array('conditions'=>array('Order.id'=>$orderId),'fields'=>array('Order.order_number','Order.comments')));
		$order_number 	  = $tmpOrderData['Order']['order_number'];
		$comments 	  = $tmpOrderData['Order']['comments'];
		
		$countries      = $this->Common->getcountries(); // get countries array
		$conditions      = $this->Common->getconditions(); // get countries array
		$OrderSellers   = $this->Ordercom->getOrderSellers($orderId);
			
		if(!empty($OrderSellers) ){ // iff sellers exists
			$this->Email->smtpOptions = array(
				'host' => Configure::read('host'),
				'username' =>Configure::read('username'),
				'password' => Configure::read('password'),
				'timeout' => Configure::read('timeout')
			);
			
			$this->Email->sendAs= 'html';
			$link=Configure::read('siteUrl');
			$template  = $this->Common->getEmailTemplate('16'); // 16 for dispatch now order email
			$this->Email->from =$template['EmailTemplate']['from_email'];
			$data1 = $template['EmailTemplate']['description'];
			App::import('Model', 'User');
			$this->User = new User();
				//pr($OrderSellers);
			foreach($OrderSellers as $seller_id){ //
				$SellerInfo = $this->Common->getSellerInfo($seller_id);
					
				$seller_user_info = $this->User->find('first',array('conditions'=>array('User.id'=>$seller_id),'fields'=>array('User.firstname','User.lastname','User.email')));
					
				################### Email Send  Scripts #####################
				$data1 = str_replace('[OrderNumber]', $order_number,$data1);
				$data1 = str_replace('[SellerDisplayName]',$SellerInfo['Seller']['business_display_name'],$data1);
		
				// get the list of order items
				$OrderItems = $this->Ordercom->getSellerOrderItems($orderId ,$seller_id );
				if(is_array($OrderItems) ){
					$orderDetailStr = '<table align="center" width="100%" style="font-size:9.0pt;font-family:Arial,sans-serif;">';
					foreach($OrderItems as $key=>$item){
						#pr($item);
						$delMethod = ($item['OrderItem']['delivery_method']=='E')?('Express Delivery'):('Standard Delivery');
						$delDate = $item['OrderItem']['estimated_delivery_date'];
						$condition = $conditions[$item['OrderItem']['condition_id']];
						$orderDetailStr .= "<tr><td align=\"left\">".$item['OrderItem']['product_name']."</td></tr>";
						$orderDetailStr .= "<tr><td align=\"left\"><b>Quantity: </b>".$item['OrderItem']['quantity']."</td></tr>";
						$orderDetailStr .= "<tr><td align=\"left\"><b>Condition: </b>".$condition."</td></tr>";
						$orderDetailStr .= "<tr><td align=\"left\"><b>Comments: </b>".$comments."</td></tr>";
						$orderDetailStr .= "<tr><td align=\"left\"><b>QuickCode: </b>".$item['OrderItem']['quick_code']."</td></tr>";
						$orderDetailStr .= "<tr><td align=\"left\"><b>Sellers ID: </b>".$item['OrderItem']['seller_id']."</td></tr>";
						$orderDetailStr .= "<tr><td align=\"left\"><b>Shipping Selected: </b>".$delMethod."</td></tr>";
						$orderDetailStr .= "<tr><td align=\"left\"><b>Delivery Estimate: </b>".date('m-d-Y',strtotime($delDate))."</td></tr>";
						$orderDetailStr .= "<tr><td align=\"left\"><b>Price: </b>".CURRENCY_SYMBOL.$item['OrderItem']['price']."</td></tr>";
						$orderDetailStr .= "<tr><td align=\"left\"><b>Delivery Charge: </b>".CURRENCY_SYMBOL.$item['OrderItem']['delivery_cost']."</td></tr>";
						$orderDetailStr .= "<tr><td>&nbsp;</td></tr>";
						unset($delMethod);
						unset($delDate);
						unset($condition);
						}
					$orderDetailStr .= '</table>';
				} else{
					$orderDetailStr = '';
				}
				$data1 = str_replace('[OrderDetail]',$orderDetailStr,$data1);
				
				$subject = "Marketplace Order ".$order_number." -- Dispatch Now";
				$this->Email->subject = $subject;
				$this->set('data',$data1);
				
				//$this->Email->to = ucfirst($SellerInfo['Seller']['business_display_name']).' <'.$SellerInfo['Seller']['service_email'].'>';
				$this->Email->to = $seller_user_info['User']['email'];
				//$this->Email->to = 'testing.sdei@gmail.com';
				/******import emailTemplate Model and get template****/
				$this->Email->template = 'commanEmailTemplate';
				
				$this->Email->send();
				################### Send Order Email Ends Here ###########################
			}
		}
		return true;
	}
	

	/**
	* @Date: Feb 10-2011
	* @Method : order_complete
	* @created:  kulvinder
	* @Param:  to comate the order process by updating the payment status and sending the mail
	**/
	function order_complete($orderId){
		// set session value as order processes
		$this->set('title_for_layout','Choiceful.com Checkout - Order Confirmation');
		$this->Session->write('order_complete', 'yes');
		if($this->RequestHandler->isMobile()) {
				$this->layout = 'mobile/home';
			}else{
				$this->layout = 'checkout';
			}
		if(empty($orderId) ){
			die('No Order Details Found');
		}
		$orderId 	= base64_decode($orderId) ;
		$countries      = $this->Common->getcountries(); // get countries array
		$this->set('countries',$countries);
		
		# import order data DB
		App::import('Model', 'Order');
		$this->Order = new Order();
		$this->Order->expects(array('OrderItem'));
		$ordData = $this->Order->findById($orderId);
		$this->set('ordData', $ordData);
		$this->Ordercom->clearOrderSessionData();
		
	}

	
	/** 
	@function: order_invoice
	@description: to view/print a business vat invoice
	@Created by: Ramanpreet Pal
	@Created: 
	@Modify:  
	*/
	function order_invoice($order_id = null) {
		$this->layout = 'ajax';
		$countries = $this->Common->getcountries();
		$pro_conditions = $this->Common->get_new_used_conditions();
		$this->set('countries',$countries);
		$this->set('pro_conditions',$pro_conditions);
		$user_id = $this->Session->read('User.id');
		$order_flag = 0;
		$order_flag = $this->Common->check_userOrder($order_id,$user_id);
		if(empty($order_flag)){
			$this->Session->setFlash('You are trying to access an invaild order.','default',array('class'=>'flashError'));
			echo "<script type=\"text/javascript\">setTimeout('parent.jQuery.fancybox.close()',1000);</script>";
		}
		$order_details = $this->Ordercom->get_order_details($order_id);
		$this->set('order_details',$order_details);
	}
	
	
	
	

	/**
	* @Date: Feb 22-2011
	* @Method : giftcertificate_step2
		  : to select payment method for sending payment for gift certificate
	* @created: ramanpreet
	* @Param: 
	**/
	function giftcertificate_step2(){
		$this->set('title_for_layout','Choiceful.com Gift Certificate Checkout - Review Order');
		$this->set('from_giftcertificate',1);
		$this->set('change_address',0);
		if ($this->RequestHandler->isMobile()) {
 			$this->layout = 'mobile/home';
		} else{
			$this->layout = 'checkout';
		}
		$errorsValidate = $this->Session->read('validationErrors');
		
		$this->set('errors',$errorsValidate);
		$total_order = $this->Session->read('Giftcheckout');
		if(empty($total_order)){
			$this->Session->delete('billing_add');
			
			$this->redirect('/certificates/purchase_gift');
		}
		$total_amount = 0;
		if(!empty($total_order)) {
			foreach($total_order as $order){
				$total_amount = $total_amount + ($order['amount'] * $order['quantity']);
			}
		}
		$user_id = $this->Session->read('User.id');
		
		App::import('Model', 'User');
		$this->User = new User();
		$billing_address_session = $this->Session->read('billing_add');
		if(empty($billing_address_session)){
			$billinguserInfo = $this->User->find('first',array('conditions'=>array('User.id'=>$user_id),'fields'=>array('User.id','User.title')));
			App::import('Model', 'Address');
			$this->Address = new Address();
			$this->Address->expects(array('Country'));
			$billingaddressInfo = $this->Address->find('first',array('conditions'=>array('Address.user_id'=>$user_id,'Address.primary_address'=>'1'),'fields'=>array('Address.id','Address.add_firstname','Address.add_lastname','Address.add_address1','Address.add_address2','Address.add_postcode','Address.add_city','Address.country_id','Address.add_state','Address.user_id','Country.country_name')));
			$billing_address = $billingaddressInfo;
			$billing_address['Address']['title'] = $billinguserInfo['User']['title'];
			$billing_address['Address']['country'] = $billingaddressInfo['Country']['country_name'];
			$this->Session->write('billing_add',$billing_address);
		}
		$settings = $this->Common->get_site_settings();
		$total_tax = 0;
		$total_amount_b4tax = $total_amount - $total_tax;
		$this->data['Checkout']['paymenthod_method'] = 'Credit/Debit Card';
		$this->set('total_order',$total_order);
		$this->set('total_tax',$total_tax);
		$this->set('total_amount_b4tax',$total_amount_b4tax);
		$this->set('total_amount',$total_amount);
	}

	/**
	* @Date: Feb 22-2011
	* @Method : giftcertificate_step3
	* @Description : to send payment for gift certificate
	* @created: ramanpreet
	* @Param: 
	**/
	function giftcertificate_step3(){
		if ($this->RequestHandler->isMobile()) {
 			$this->layout = 'mobile/home';
		} else{
			$this->layout = 'checkout';
		}
		$paid = 0;
		$this->set('from_giftcertificate',1);
		$countries = $this->Common->getcountries();
		$this->set('countries',$countries);
		$errorsValidate = $this->Session->read('validationErrors');
		if(!empty($errorsValidate)){
			$this->redirect('/checkouts/giftcertificate_step2/1');
		}
		if(!empty($this->data)){
			if(!empty($this->data['Checkout']['paymenthod_method'])){
				$billing_add = $this->Session->read('billing_add');
				$total_order = $this->Session->read('Giftcheckout');
				if(!empty($billing_add)) {
					$this->data['OrderCertificate']['billing_user_title'] = $billing_add['Address']['title'];
					$this->data['OrderCertificate']['billing_firstname'] = $billing_add['Address']['add_firstname'];
					$this->data['OrderCertificate']['billing_lastname'] = $billing_add['Address']['add_lastname'];
					$this->data['OrderCertificate']['billing_address1'] = $billing_add['Address']['add_address1'];
					$this->data['OrderCertificate']['billing_address2'] = $billing_add['Address']['add_address2'];
					$this->data['OrderCertificate']['billing_postecode'] = $billing_add['Address']['add_postcode'];
					$this->data['OrderCertificate']['billing_city'] = $billing_add['Address']['add_city'];
					$this->data['OrderCertificate']['billing_country_id'] = $billing_add['Address']['country_id'];
					$this->data['OrderCertificate']['payment_method'] = $this->data['Checkout']['paymenthod_method'];
					$this->data['OrderCertificate']['user_id'] = $this->Session->read('User.id');
					$total_amount = 0;$total_quantity = 0;
					if(!empty($total_order)){
						foreach($total_order as $order){
							$amount = 0;
							$amount = $order['amount'] * $order['quantity'];
							$total_amount = $total_amount + $amount;
							$total_quantity = $total_quantity + $order['quantity'];
						}
					}
					$paymentMethod = $this->data['OrderCertificate']['payment_method'];
					$this->data['OrderCertificate']['id'] = '';
					$this->data['OrderCertificate']['session_id'] = session_id();
					$order_id = $this->save_giftcertificate($this->data,$total_order);
					
					$site_url = SITE_URL;
					switch($paymentMethod):
					case 'Sage': // pay flow "Sage payment"
						$strConnectTo = "LIVE";
						//$strConnectTo = "Test";
						####### gateway url #########################
						if ($strConnectTo == "LIVE"){
							$strPurchaseURL = "https://live.sagepay.com/gateway/service/vspform-register.vsp";
						} else{
							$strPurchaseURL = "https://test.sagepay.com/gateway/service/vspform-register.vsp";
						}
						$orderData = $this->OrderCertificate->find('first',array('conditions'=>array('OrderCertificate.id'=>$order_id)));
						
						$orderData['OrderCertificate']['id'] = $orderData['OrderCertificate']['id'];
						$this->Session->write('giftcertificate_orderId',$order_id);
						
						//$orderData['OrderCertificate']['id'] = $orderData['OrderCertificate']['id'].'~'.strtotime(date('d-m-Y H:i:s'));
						$strPost = $this->Sage->getgift_strPost($orderData);
						$strBasket = '';
						// Encrypt the plaintext string for inclusion in the hidden field
						$strCrypt = $this->Sage->base64Encode($this->Sage->SimpleXor($strPost,$this->Sage->strEncryptionPassword));
							
						$strdeCrypt = $this->Sage->SimpleXor($this->Sage->base64Decode($strCrypt),$this->Sage->strEncryptionPassword) ;
						
						$this->Sage->gateway_url = $strPurchaseURL; // payment gateway url
						$this->Sage->add_field('TxType', $this->Sage->strTransactionType);
						$this->Sage->add_field('Vendor', $this->Sage->strVSPVendorName);
						$this->Sage->add_field('Crypt', $strCrypt);
						$this->Sage->submit_post();
						break;
					case 'paypal_checkout': // Paypal
						$strConnectTo = "LIVE";
						if($strConnectTo == "LIVE"){
							$this->Paypal->paypal_url = 'https://www.paypal.com/cgi-bin/webscr';   // live paypal url
							$this->Paypal->add_field('business', 'milestones247@gmail.com');
						} else{
							$this->Paypal->paypal_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';// paypal sndbox testing url
							$this->Paypal->add_field('business', 'kulvin_1297749982_biz@gmail.com');	
						}
						$this->Paypal->add_field('return', $site_url.'checkouts/giftcertificate_step4/'.base64_encode($order_id));
						$this->Paypal->add_field('cancel_return', $site_url.'checkouts/giftcertificate_step2/');
						$this->Paypal->add_field('notify_url', $site_url.'checkouts/paypal_return/giftcertificate');
						$this->Paypal->add_field('cmd', '_xclick');
						$this->Paypal->add_field('rm', '2');
						$this->Paypal->add_field('upload', '1');
						$this->Paypal->add_field('currency', 'GBP');
						$this->Paypal->add_field('currency_code', 'GBP');
						$this->Paypal->add_field('item_name', 'Choiceful Gift Certificates Payment');
						$this->Paypal->add_field('invoice', $order_id.'~'.strtotime(date('d-m-Y H:i:s')));
						$this->Paypal->add_field('amount', $total_amount);
						//$this->Paypal->add_field('no_shipping', '1');
						$this->Paypal->add_field('image_url', $site_url.'/img/checkout/choiceful-logo.png');

						$item['Item']['name'] = 'Gift Certificate';
						$item['Item']['price'] = $total_amount;
						//pr($item); die;
						$this->Paypal->add_field('item_name',$item['Item']['name']);
						$this->Paypal->add_field('amount', $item['Item']['price']);
						//exit;
						//pr();
						$this->giftexpresscheckout($total_amount,$order_id,'paypal');
						//$this->Paypal->submit_paypal_post();
						break;
					case 'Credit/Debit Card': // Paypal
						$this->giftexpresscheckout($total_amount,$order_id);						
						break;
					
					case 'google_checkout': // payment processing through google checkout 
						// call google check out function to process the google payment
						$orderData = $this->OrderCertificate->find('first',array('conditions'=>array('OrderCertificate.id'=>$order_id)));
						$orderData['OrderCertificate']['id'] = $orderData['OrderCertificate']['id'].'-|-'.strtotime(date('d-m-Y H:i:s'));
						$GoogleCheckOutButton = $this->Googlecheckout->processGiftGoogleCheckout($orderData);   // sandbox - live
						
						echo  '<div style="display:none">'.$GoogleCheckOutButton.'</div>';
						echo '<div><center><h3>Please wait, your order is being processed...</h3></center></div>';
						echo '<script language="javascript">document.GoogleCheckout.submit();</script>';
						break;
						endswitch;
				} else{
					$this->redirect('/certificates/buy-choiceful-gift-certificates-the-gift-of-choice');
				}
			} else{
				$this->Session->setFlash('Unable to make a payment, please try again.','default',array('class'=>'flashError'));
				$this->redirect('giftcertificate_step2/');
			}
		} else{
			$this->Session->setFlash('Unable to make a payment, please try again.','default',array('class'=>'flashError'));
			$this->redirect('giftcertificate_step2/');
		}
	}

	/**
	* @Date: Feb 22-2011
	* @Method : giftcertificate_step4
		  : display to whom gift certificates have been sent after payment
	* @created: ramanpreet
	* @Param: 
	**/
	function giftcertificate_step4($order_id = null){
		if ($this->RequestHandler->isMobile()) {
 			$this->layout = 'mobile/home';
		} else{
			$this->layout = 'checkout';
		}
		$this->set('title_for_layout','Choiceful.com Gift Certificate Checkout - Order Confirmation');
		if(!empty($order_id)){
			$order_id = base64_decode($order_id);
		}
		$total_order = $this->Session->read('Giftcheckout');
		//pr($total_order);

		if(empty($total_order)){
			$this->redirect('/certificates/buy-choiceful-gift-certificates-the-gift-of-choice');
		} else {
			foreach($total_order as $order){
				$users[]=$order['touser'];
			}
		}
		//pr($users);
		$this->set('users',$users);

		$this->Session->delete('billing_add');
		App::import('Model', 'OrderCertificate');
		$this->OrderCertificate = new OrderCertificate();
		$orderinfo = $this->OrderCertificate->find('first',array('conditions'=>array('OrderCertificate.id'=>$order_id)));
		$this->Session->write('giftcertificate_orderId',$order_id);
		$trans_is = $orderinfo['OrderCertificate']['tranx_id'];
		$this->set('trans_is',$trans_is);
// 		if(empty($trans_is)){
// 			$this->redirect('/');
// 		}
		$this->set('from_giftcertificate',1);
	}
	
	/**
	* @Date: Feb 22-2011
	* @Method : change_add
		  : to update billing address at time of payment
	* @created: ramanpreet
	* @Param: 
	**/
	function change_add(){
		$this->layout = 'ajax';
		$this->set('change_address',1);
		$titles = $this->Common->get_titles();
		$this->set('titles',$titles);
		$countries = $this->Common->getcountries();
		$this->set('countries',$countries);
		$errorsValidate = $this->Session->read('validationErrors');
		if(!empty($errorsValidate)){
			$this->set('errors',$errorsValidate);
		}
		if(!empty($this->data)){
			
			$this->data = $this->cleardata($this->data);
			//$this->data = Sanitize::clean($this->data, array('encode' => false));
			
			App::import('Model', 'Address');
			$this->Address = new Address();
			$this->Address->set($this->data);
			App::import('Model', 'Country');
			$this->Country = new Country();
			if(!empty($this->data['Address']['country_id'])){
				$country = $this->Country->find('first',array('conditions'=>array('Country.id'=>$this->data['Address']['country_id']),'fields'=>array('Country.country_name')));
				$this->data['Address']['country'] = $country['Country']['country_name'];
				$this->data['Address']['country_id'] = $this->data['Address']['country_id'];
			}
			$billing_add = $this->data;
			$this->Session->write('billing_add',$billing_add);
			if($this->Address->validates()){
				$this->Session->write('validationErrors',0);
				$this->set('change_address',0);
				
				$this->redirect('/checkouts/giftcertificate_step2/1');
				//$this->viewPath = 'elements/checkout' ;
				//$this->render('billing_address');
			} else{
				$errors = $this->Address->validationErrors;
				$this->Session->write('validationErrors',$errors);
				$this->redirect('/checkouts/giftcertificate_step2/1');
			}
		} else{
			$this->data = $this->Session->read('billing_add');
			if ($this->RequestHandler->isMobile()) {
				$this->viewPath = 'elements/mobile/checkout' ;
				$this->render('change_address');
			}else{
				$this->viewPath = 'elements/checkout' ;
				$this->render('change_address');
			}
		}
	}
	
	
	
	# to show the pop up of additional insurance   cost
	# @created by: kulvinder
	function insurance_popup(){
		if ($this->RequestHandler->isMobile()) {
 			$this->layout = 'mobile/staticpages';
		} else{
			$this->layout = 'front_popup';
		}
		
	}
	
	# to show the pop up of click of need Help link on header of checkout 
	# @created by: kulvinder
	function chechout_helpbox(){
		$this->layout = 'front_popup';
	}



	/**
	* @Date: Feb 22-2011
	* @Method : save_giftcertificate
		  : to save individual gift certificates
	* @created: ramanpreet
	* @Param: 
	**/
	function save_giftcertificate($data = null,$total_order = null){
		$saved = 0;

		$total_amount = 0;$total_quantity = 0;
		if(!empty($total_order)){
			foreach($total_order as $order){
				$amount = 0;
				$amount = $order['amount'] * $order['quantity'];
				$total_amount = $total_amount + $amount;
				$total_quantity = $total_quantity + $order['quantity'];
			}
		}
		
		if(!empty($data)){
			$this->data = $data;
			$this->data['OrderCertificate']['total_amount'] = $total_amount;
			$this->data['OrderCertificate']['quantity'] = $total_quantity;
			App::import('Model', 'OrderCertificate');
			$this->OrderCertificate = new OrderCertificate();
			App::import('Model', 'Certificate');
			$this->Certificate = new Certificate();

			$this->OrderCertificate->set($this->data);
			if($this->OrderCertificate->save()){
				
				$last_inserted_id = $this->OrderCertificate->getLastInsertId();
						
				$creteria_order_num = array('OrderCertificate.id'=>$last_inserted_id);
				$order_info = $this->OrderCertificate->find('first',array('conditions'=>$creteria_order_num,'fields'=>array('OrderCertificate.id','OrderCertificate.user_id','OrderCertificate.created')));
	
				if(!empty($order_info))
				     $order_number = $order_info['OrderCertificate']['id'].'-'.date(ORDERNUMBER_DATE_FORMAT,strtotime($order_info['OrderCertificate']['created'])).'-'.$order_info['OrderCertificate']['user_id'];
				else
				     $order_number = '-';
				
				$this->OrderCertificate->id = $last_inserted_id;
				$this->OrderCertificate->saveField('order_number',$order_number);
			
				$this->data['Certificate']['order_certificate_id'] = $last_inserted_id;

				foreach($total_order as $order){
					for($i = 0 ; $i < $order['quantity']; $i++){
						$this->data['Certificate']['id'] = 0;
						$this->data['Certificate']['user_id'] = $this->data['OrderCertificate']['user_id'];
						$this->data['Certificate']['sender_from'] = $order['from'];
						$this->data['Certificate']['sender_to'] = $order['to'];
						$this->data['Certificate']['receiver'] = $order['touser'];
						$this->data['Certificate']['sender_message'] = $order['message'];
						$this->data['Certificate']['email_flag'] = 0;
						$this->data['Certificate']['amount'] = $order['amount'];
						$autocode = $this->Common->generate_code();
						$returned_code = $this->Common->checkUniquecode($autocode,'Certificate');
						$this->data['Certificate']['code'] = $returned_code;
						$this->data['Certificate']['quantity'] = 1;
						$this->Certificate->set($this->data);
						if($this->Certificate->save($this->data)){
							$certificate_id = $this->Certificate->getLastInsertId();

						} else{
							$unsaved_user[] = $order['touser'];
						}
					}
				}
				$saved = 1;
			} else{
				
			}

		}
		//return $this->data['Certificate']['order_certificate_id'];
		return $order_number; 
	}


	/**
	* @Date: Feb 22-2011
	* @Method : send_certificate_email
		  : to send email for every gift certificate
	* @created: ramanpreet
	* @Param: 
	**/
	function send_certificate_email($order_certificate_id = null){
		App::import('Model', 'Certificate');
		$this->Certificate = new Certificate();

		$certificates = $this->Certificate->find('all',array('conditions'=>array('Certificate.order_certificate_id'=>$order_certificate_id)));

		$this->Email->smtpOptions = array(
			'host' => Configure::read('host'),
			'username' => Configure::read('username'),
			'password' => Configure::read('password'),
			'timeout' => Configure::read('timeout')
		);

// 		$this->Email->replyTo = Configure::read('replytoEmail');
	
		$this->Email->sendAs= 'html';

		App::import('Model','EmailTemplate');
		$this->EmailTemplate = new EmailTemplate;
		App::import('Model','User');
		$this->User = new User;
		$link=Configure::read('siteUrl');
		$mailsend = '';
		$mail_notsend = '';$session_msg = ''; $email_to_str ='';
		if($certificates){


			foreach($certificates as $certificate) {
				/* find all receivers :: Begin*/
				$allreceivers = $allreceivers.$certificate['Certificate']['receiver'].', ';
				$allreceivers = substr($allreceivers, 0, strlen($allreceivers)-1);
				/*find all receivers :: End*/
				$user_send_id = $certificate['Certificate']['user_id'];
				/**
				table: email_templates
				id: 8
				description: Gift Certificate
				*/
				$template = $this->Common->getEmailTemplate(8);
				$data = $template['EmailTemplate']['description'];
	
				$receiver_name_arr = explode('@',$certificate['Certificate']['receiver']);
				$receiver_name = $receiver_name_arr[0];
				$data = str_replace('[RecepientName]',$receiver_name,$data);
	
				$data = str_replace('[Code]',$certificate['Certificate']['code'],$data);
	
				$data = str_replace('[Value]',$certificate['Certificate']['amount'],$data);
	
				if(!empty($certificate['Certificate']['sender_to'])){
					$data = str_replace('[ToUserEnteredContent]',$certificate['Certificate']['sender_to'],$data);
				} else{
					$data = str_replace('To: [ToUserEnteredContent]','',$data);
				}
				if( !empty($certificate['Certificate']['sender_from'] ) ){
					$data = str_replace('[FromUserEnteredContent]',$certificate['Certificate']['sender_from'],$data);
				} else{
					$data = str_replace('From: [FromUserEnteredContent]','',$data);
				}
				if(!empty($certificate['Certificate']['sender_message'])){
					$data = str_replace('[MessageUserEnteredContent]',$this->Common->currencyEnter($certificate['Certificate']['sender_message']),$data);
				} else{
					$data = str_replace('Message: [MessageUserEnteredContent]','',$data);
				}
	
				if(empty($certificate['Certificate']['sender_message']) && empty($certificate['Certificate']['sender_from']) && empty($certificate['Certificate']['sender_to'])) {
					$data = str_replace('Senders Details:','',$data);
				}
	
				$template['EmailTemplate']['subject'] = str_replace('[RecepientName]',$receiver_name,$template['EmailTemplate']['subject']);
				$this->Email->subject = $template['EmailTemplate']['subject'];
				$this->Email->from = $template['EmailTemplate']['from_email'];
	
				$this->set('data',$data);
	
				$this->Email->to = $certificate['Certificate']['receiver'];
				
				/******import emailTemplate Model and get template****/
				$this->Email->template = 'commanEmailTemplate';
				if($this->Email->send()) {
					$this->data['Certificate']['id'] = $certificate['Certificate']['id'];
					$this->data['Certificate']['email_flag'] = 1;
					$this->Certificate->set($this->data);
					$this->Certificate->save();
					if(empty($mailsend)){
						$mailsend = $certificate['Certificate']['receiver'];
						if(empty($email_to_str)){
							$email_to_str = $certificate['Certificate']['receiver'];
						} else{
							$email_to_str = $email_to_str.', '.$certificate['Certificate']['receiver'];
						}
					} else {
						$mailsend = $mailsend.', '.$certificate['Certificate']['receiver'];
					}
				} else{
					if(empty ( $mailsend ) )
						$mail_notsend = $this->data['Certificate']['receiver'];
					else
						$mail_notsend = $mail_notsend.', '.$certificate['Certificate']['receiver'];
				}
			}
			$template_sender = $this->Common->getEmailTemplate(9);
			$data_sender = $template_sender['EmailTemplate']['description'];
			$user_info_sender = $this->User->find('first',array('conditions'=>array('User.id'=>$user_send_id),'fields'=>array('User.id','User.firstname','User.lastname','User.email')));
			//$data_sender = str_replace('[RecepientName]',$email_to_str,$data_sender);
			$data_sender = str_replace('[RecepientName]',$allreceivers,$data_sender);
			$data_sender = str_replace('[CustomerFirstName]',$user_info_sender['User']['firstname'],$data_sender);
			$this->Email->subject = $template_sender['EmailTemplate']['subject'];
			$this->Email->from = $template_sender['EmailTemplate']['from_email'];
			$this->Email->to = $user_info_sender['User']['email'];
			$this->set('data',$data_sender);
			$this->Email->template = 'commanEmailTemplate';
			$this->Email->send();
		}
		return $session_msg;
	}

	/**
	* @Date: Feb 22-2011
	* @Method : save_certificate_payment
		  : to update payment status for every gift certificate
	* @created: ramanpreet
	* @Param: 
	**/
	function save_certificate_payment($order_id = null){
		App::import('Model', 'Certificate');
		$this->Certificate = new Certificate();

		$certificates = $this->Certificate->find('all',array('conditions'=>array('Certificate.order_certificate_id'=>$order_id)));

		if(!empty($certificates)) {
			foreach($certificates as $certificate) {
				$this->data['Certificate']['id'] = $certificate['Certificate']['id'];
				$this->data['Certificate']['payment_flag'] = 1;
				$this->Certificate->set($this->data);
				$this->Certificate->save($this->data);
			}
		}

	}

	/**
	* @Date: Feb 22-2011
	* @Method : protx_gift_return
	* @created:  ramanpreet
	* @Param: 
	**/
	function protx_gift_return($gift = null){
		$this->layout = 'ajax';
		$user_id = $this->Session->read('User.id');
			
		$url = SITE_URL."checkouts/giftcertificate_step2/";
			
		$strCrypt = $_REQUEST["crypt"];
			
		App::import('Model', 'OrderCertificate');
		$this->OrderCertificate = new OrderCertificate();
			
		$strVendorEMail = $this->Sage->strVendorEMail;
		//Configure::write('debug',2);
		// Now decode the Crypt field and extract the results
		$strDecoded = $this->Sage->simpleXor($this->Sage->Base64Decode($strCrypt),$this->Sage->strEncryptionPassword);
		$values = $this->Sage->getToken($strDecoded);
		$_status = strtoupper($values['Status']);
			
		// Split out the useful information into variables we can use
		$_status = strtoupper($values['Status']);
			
		if($_status == 'REGISTERED' ||  $_status == 'OK'){ // if payment successfull
			$tranx_id    = str_replace("{", "", $values['VPSTxId']);
			$tranx_id    = str_replace("}", "", $tranx_id) ;
			$orderId = $values['VendorTxCode'];
// 			$orderId = str_replace('GC-','',$orderId);
			//Commented by nakul on 6-02-22012
			//$orderIdArr = explode('~','',$orderId);
			//$orderId = $orderIdArr[0];
			$orderSuccessData['order_id'] = $orderId;
			$orderSuccessData['tranx_id'] = $tranx_id;
					
			$get_order_id = array('OrderCertificate.id'=>$orderId);
					
			$order_gift_info = $this->OrderCertificate->find('first',array('conditions'=>$get_order_id,'fields'=>array('OrderCertificate.id','OrderCertificate.user_id','OrderCertificate.order_number')));
					
			$orderNum = $order_gift_info['OrderCertificate']['order_number'];
					
			$this->Session->write('giftcertificate_orderId',$orderNum);
			$this->Session->write('giftcertificate_tranx_id',$tranx_id);
			$this->data['OrderCertificate']['id'] = $orderId;
			$this->data['OrderCertificate']['tranx_id'] = $tranx_id;
			$this->data['OrderCertificate']['payment_status'] = "Y";
					
			$this->update_ordercertificate($this->data); // update payemt status yes with transaction id
			$this->save_certificate_payment($orderId); // update certificates table
			$this->send_certificate_email($orderId); // send certificate code email to customer
					
			$orderId_encoded = base64_encode($orderNum);
					
			$this->redirect('/checkouts/giftcertificate_step4/'.$orderId_encoded);
			# http://172.24.0.9:9441/checkouts/protx_return?crypt=BxxZUAogDE82PSJQC0dbf3cvZ2cxKhFTSCl2AnBCLnVmQRpwIWVtGkRqcwIbQil1FVQPdVVibgc2YHQMdDcQawINVkAQIWVlMBUPZmIzPwgVX2RABCYtRDE3MlRfGlB/YUgGFF9yDF8QchJHVxgeLDINXlsLcjBWBnIkUFMYTR80Hl5HETcqUhF8YHJfEBkMOB0KBENhHGQQMTNHUyUZLCUMRAkrHQx0PRcFfnMySw4wC1NgHCI9CjQfA20QOgw+JU1zXQI7LERIYnYFA1AsID4MWUBYY2oFW2Zz
		} else{ // is payment gateway send error
			if ($_status=="NOTAUTHED"){
				$strReason="You payment was declined by the bank. This could be due to insufficient funds, or incorrect card details.";
			} else if ($_status=="ABORT"){
				$strReason="You chose to Cancel your order on the payment pages.  If you wish to change your order and resubmit it you can do so here. If you have questions or concerns about ordering online, .";
			} else if ($_status=="REJECTED"){
				$strReason="Your order did not meet our minimum fraud screening requirements. If you have questions about our fraud screening rules, or wish to contact us to discuss this,.";
			} else if ($_status=="INVALID" or $_status=="MALFORMED"){
				$strReason="We could not process your order because we have been unable to register your transaction with our Payment Gateway.";
			} else{
				$strReason="We could not process your order because our Payment Gateway service was experiencing difficulties.";
			}
			$strReason .= "or <a href=\"$url\">Click here</a> to return to the order review page to try other payment methods";
			$message =   "The transaction process failed. Please contact us with the date and time of your order and we will investigate by clicking <a href='mailto:$strVendorEMail'>here</a><br /><br />".$strReason;
		}
		exit;
	}

	function update_ordercertificate($data = null){
		App::import('Model', 'OrderCertificate');
		$this->OrderCertificate = new OrderCertificate();
		$this->data = $data;
		$this->OrderCertificate->set($this->data);
		$this->OrderCertificate->save($this->data);
	}


	/**
	* @Date: Feb 22-2011
	* @Method : protx_gift_error
	* @created:  ramanpreet
	* @Param:  error handling function for sage payment processing
	**/
	function protx_gift_error(){
		$this->layout = 'ajax';
		$strVendorEMail = $this->Sage->strVendorEMail;
		$url = SITE_URL."checkouts/giftcertificate_step2/";
		
		$strCrypt = $_REQUEST["crypt"];
		// Now decode the Crypt field and extract the results
		$strDecoded 	= $this->Sage->simpleXor($this->Sage->Base64Decode($strCrypt),$this->Sage->strEncryptionPassword);

		$values  	= $this->Sage->getToken($strDecoded);
		$_status 	= strtoupper($values['Status']);
		if ($_status=="NOTAUTHED"){
			$strReason="You payment was declined by the bank.  This could be due to insufficient funds, or incorrect card details.";
		} else if ($_status=="ABORT"){
			$strReason="You chose to Cancel your order on the payment pages.  If you wish to change your order and resubmit it you can do so here. If you have questions or concerns about ordering online, or <a href=\"$url\">Click here</a> to return to the cart page to try other payment methods.";
		} else if ($_status=="REJECTED"){
			$strReason="Your order did not meet our minimum fraud screening requirements. If you have questions about our fraud screening rules, or wish to contact us to discuss this. or <a href=\"$url\">Click here</a> to return to the cart page to try other payment methods.";
		} else if ($_status=="INVALID" or $_status=="MALFORMED"){
			$strReason="We could not process your order because we have been unable to register your transaction with our Payment Gateway.  or <a href=\"$url\">Click here</a> to return to the cart page to try other payment methods.";
		} else if ($_status=="ERROR"){
			$strReason="We could not process your order because our Payment Gateway service was experiencing difficulties.  or <a href=\"$url\">Click here</a> to return to the order review page to try other payment methods..";
		}
		
		echo $message =   "The transaction process failed. Please contact us with the date and time of your order and we will investigate by clicking <a href='mailto:$strVendorEMail'>here</a><br /><br />$strReason";
		exit;
	}

	
	/**
	* @Date: Feb 15-2011
	* @Method : google_return
	* @created:  kulvinder
	* @Param:  function to handle the google checkout responce
	**/
	function google_gift_return($Gresponse){
		$this->layout = 'ajax';
		
		$_status = $Gresponse['status'];
		if($_status == 'OK' ){ // if payment successfull
			$orderId = $Gresponse['order_number'];
			$orderSuccessData['order_id'] = $orderId;
			$orderSuccessData['tranx_id'] = $Gresponse['tranx_id'];
			$this->Session->write('giftcertificate_orderId',$orderId);
			$this->Session->write('giftcertificate_tranx_id',$Gresponse['tranx_id']);
			$this->data['OrderCertificate']['id'] = $orderId;
			$this->data['OrderCertificate']['tranx_id'] = $Gresponse['tranx_id'];
			$this->data['OrderCertificate']['payment_status'] = "Y";

			$this->update_ordercertificate($this->data); // update payemt status yes with transaction id
			$this->save_certificate_payment($orderId); // update certificates table
			$this->send_certificate_email($orderId); // send certificate code email to customer

			//$this->redirect('/checkouts/giftcertificate_step4/');
		} else{ // is payment gateway send error 
			echo $strReason="We could not process your order because our Payment Gateway service was experiencing difficulties.  or <a href=\"$url\">Click here</a> to return to the order review page to try other payment methods..";
			
		}
		exit;
	
	}


/**
	* @Date:  DEC 2, 2011
	* @Method : 
	* @created:  Nakul kumar
	* @Param: 
	* @Return: 
	**/
	function change_shippingadd(){
		
		if ($this->RequestHandler->isMobile()) {
 			$this->layout = 'mobile/home';
		} else if($this->RequestHandler->isAjax()==0){
 			$this->layout = 'checkout';
			} else{
				$this->layout = 'ajax';
		}
		
		###################### clear coupon session data() ##################
		$this->Session->write('dcSessData', '');
		########################################
		// logedin user id
		$user_id  = $this->Session->read('User.id');
		$userdata = $this->Common->get_user_billing_info($user_id);
		$NewUsedcondArray = $this->Common->get_new_used_conditions();
		$settings = $this->Common->get_site_settings();
		$this->set('settings', $settings);
		
		//pr($settings);
		$this->set('NewUsedcondArray', $NewUsedcondArray);
		
		// set the basket data as per the quantitiy of in stock
		//$this->Ordercom->setBasketDataAsPerStock();
		
		
		// get cart listing data
		$cartData = $this->Common->get_basket_listing();
		$this->set('cartData', $cartData);		
		//pr($cartData);
		if(count($cartData)  <= 0 ){ // if basket is empty then redirect it to 
			$this->redirect('/baskets/view');
		}
		 
			
		$titles = $this->Common->get_titles();
		$this->set('title',$titles);
		
		$countries = $this->Common->getcountries();
		$this->set('countries',$countries);
		
		$shippingCountries = $this->Common->getDispatchCountryList();
		$this->set('shippingCountries' , $shippingCountries);

		# import the Basket DB to upate the fist option and gift messages
		App::import('Model', 'Basket');
		$this->Basket = new Basket();
		App::import('Model', 'Order');
		$this->Order = new Order();
		
		if(empty($this->data)){ // if data submitted.

			$sessOrderData = $this->Session->read('sessOrderData');
			if(!empty($sessOrderData) ){ // show session data
				$this->data['Order']['billing_user_title'] = $sessOrderData['billing_user_title'];
				$this->data['Order']['billing_firstname'] = $sessOrderData['billing_firstname'];
				$this->data['Order']['billing_lastname'] = $sessOrderData['billing_lastname'];
				$this->data['Order']['billing_address1'] = $sessOrderData['billing_address1'];
				$this->data['Order']['billing_address2'] = $sessOrderData['billing_address2'];
				$this->data['Order']['billing_city'] = $sessOrderData['billing_city'];
				$this->data['Order']['billing_state'] = $sessOrderData['billing_state'];
				$this->data['Order']['billing_postal_code'] = $sessOrderData['billing_postal_code'];
				$this->data['Order']['billing_country_id'] = $sessOrderData['billing_country_id'];
				$this->data['Order']['billing_phone'] = $sessOrderData['billing_phone'];
				
				$this->data['Order']['shipping_user_title'] = $sessOrderData['shipping_user_title'];
				$this->data['Order']['shipping_firstname'] = $sessOrderData['shipping_firstname'];
				$this->data['Order']['shipping_lastname'] = $sessOrderData['shipping_lastname'];
				$this->data['Order']['shipping_address1'] = $sessOrderData['shipping_address1'];
				$this->data['Order']['shipping_address2'] = $sessOrderData['shipping_address2'];
				$this->data['Order']['shipping_city'] = $sessOrderData['shipping_city'];
				$this->data['Order']['shipping_state'] = $sessOrderData['shipping_state'];
				$this->data['Order']['shipping_postal_code'] = $sessOrderData['shipping_postal_code'];
				$this->data['Order']['shipping_country_id'] = $sessOrderData['shipping_country_id'];
				$this->data['Order']['shipping_phone'] = $sessOrderData['shipping_phone'];
			}else{
			$userdata = $this->Common->get_user_billing_info($user_id);
				if(is_array($userdata) ){
					$this->data['Order']['billing_user_title'] = $userdata['User']['title'];
					$this->data['Order']['billing_firstname'] = $userdata['User']['firstname'];
					$this->data['Order']['billing_lastname'] = $userdata['User']['lastname'];
					$this->data['Order']['billing_address1'] = $userdata['Address']['add_address1'];
					$this->data['Order']['billing_address2'] = $userdata['Address']['add_address2'];
					$this->data['Order']['billing_city'] = $userdata['Address']['add_city'];
					$this->data['Order']['billing_state'] = $userdata['Address']['add_state'];
					$this->data['Order']['billing_postal_code'] = $userdata['Address']['add_postcode'];
					$this->data['Order']['billing_country_id'] = $userdata['Address']['country_id'];
					$this->data['Order']['billing_phone'] = $userdata['Address']['add_phone'];
					$this->data['Order']['shipping_user_title'] = '';
					$this->data['Order']['shipping_state'] = '';
					$this->data['Order']['shipping_country_id'] = '';
				} else{
				$this->Session->delete('User.id');
				$this->redirect('/checkouts/step1');
				}
			}
		}else{
			$this->Order->set($this->data);
			//$orderInfoValidate = $this->Order->validates();
			if($this->Order->validates()){
				$sessOrderData = $this->Session->read('sessOrderData');
				// check the sessions's data if present
				$sessOrderData['billing_user_title'] = $this->data['Order']['billing_user_title'];
				$sessOrderData['billing_firstname'] = $this->data['Order']['billing_firstname'];
				$sessOrderData['billing_lastname'] = $this->data['Order']['billing_lastname'];
				$sessOrderData['billing_address1'] = $this->data['Order']['billing_address1'];
				$sessOrderData['billing_address2'] = $this->data['Order']['billing_address2'];
				$sessOrderData['billing_city'] = $this->data['Order']['billing_city'];
				$sessOrderData['billing_state'] = $this->data['Order']['billing_state'];
				$sessOrderData['billing_postal_code'] = $this->data['Order']['billing_postal_code'];
				$sessOrderData['billing_country_id'] = $this->data['Order']['billing_country_id'];
				$sessOrderData['billing_phone'] = $this->data['Order']['billing_phone'];
				
				$sessOrderData['shipping_user_title'] = $this->data['Order']['shipping_user_title'];
				$sessOrderData['shipping_firstname'] = $this->data['Order']['shipping_firstname'];
				$sessOrderData['shipping_lastname'] = $this->data['Order']['shipping_lastname'];
				$sessOrderData['shipping_address1'] = $this->data['Order']['shipping_address1'];
				$sessOrderData['shipping_address2'] = $this->data['Order']['shipping_address2'];
				$sessOrderData['shipping_city'] = $this->data['Order']['shipping_city'];
				$sessOrderData['shipping_state'] = $this->data['Order']['shipping_state'];
				$sessOrderData['shipping_postal_code']=$this->data['Order']['shipping_postal_code'];
				$sessOrderData['shipping_country_id'] = $this->data['Order']['shipping_country_id'];
				$sessOrderData['shipping_phone'] = $this->data['Order']['shipping_phone'];
				$this->Session->write('sessOrderData',$this->data['Order']);
				
				$this->data = Sanitize::clean($this->data);
				$home_location_country = $settings['Setting']['website_home_location'];
				$home_location_country_name = $shippingCountries[$home_location_country];
				if($this->data['Order']['shipping_country_id'] != $home_location_country){
					$this->Session->setFlash('Delivery must be to a '.$home_location_country_name.' address, <a href="/pages/view/international-delivery" target="_blank">click here </a> for more information.','default',array('class'=>'flashError'));
				}else{
				$this->redirect('/checkouts/step3');
				}
			}else{
				$errorArray = $this->Order->validationErrors;
				$this->set('errors',$errorArray);
			}

		}
	}


// test for paypal express checkout
function setexpresscheckout($totalCost = null,$order_number = null,$shappingcost = null,$insurance_cost = null,$gift_cost = null, $paypal = null){
	$this->layout = false;
	App::import('Vendor', 'paypalexp', array('file' => 'paypal'.DS.'PaypalExpress.php'));
	
	$PayPalMode 			= 'live'; // sandbox or live
	$PayPalApiUsername 		= 'milestones247_api1.gmail.com'; //PayPal API Username
	$PayPalApiPassword 		= 'SL6LWUCGMG4BM9VD'; //Paypal API password
	$PayPalApiSignature 	        = 'AFcWxV21C7fd0v3bYYYRCpSSRl31ApH0ThgpCzxR4uD8f5xfyocDw9XP'; //Paypal API Signature
	$PayPalCurrencyCode 	        = 'GBP'; //Paypal Currency Code
	$PayPalReturnURL 		= 'http://www.choiceful.com/checkouts/setexpresscheckout'; //Point to process.php page
	$PayPalCancelURL 		= 'http://www.choiceful.com/checkouts/step4'; //Cancel URL if user clicks cancel
	
	if($totalCost) //Post Data received from product list page.
	{
		$basketItemsData = $this->Common->get_basket_listing(); //get basket listing data
			
		if(is_array($basketItemsData) ){
				$i = -1;
				$shippingItems = '';
				$itemPrice = '0.00';
				$totalItems = count($basketItemsData);
				foreach($basketItemsData as $item){
					$i++;
					$shippingItems .= '&L_PAYMENTREQUEST_0_QTY'.$i.'='. urlencode($item['Basket']['qty']).
					'&L_PAYMENTREQUEST_0_AMT'.$i.'='.urlencode($item['Basket']['price']).
					'&L_PAYMENTREQUEST_0_NAME'.$i.'='.urlencode($item['Product']['product_name']).
					'&L_PAYMENTREQUEST_0_NUMBER'.$i.'='.urlencode($i);
					$itemPrice = ($itemPrice+($item['Basket']['price']*$item['Basket']['qty']));
					
				}
			}
		
		//$shippingAmount;
		//$ItemTotalPrice = $totalCost;
		$sessOrderData = $this->Session->read('sessOrderData');
		$user_id = $this->Session->read('User.id');
		$userMailInfo = $this->Common->getUserMailInfo($user_id);
		$email = $userMailInfo['User']['email'];
		
		
		//Repalce by clien on 17-SEPT-2013
		$billing_user_title = $sessOrderData['billing_user_title'];
		$billing_firstname = $sessOrderData['billing_firstname'];
		$billing_lastname = $sessOrderData['billing_lastname'];
		$billing_address1 = $sessOrderData['billing_address1'];
		$billing_address2 = $sessOrderData['billing_address2'];
		$billing_city 	= $sessOrderData['billing_city'];
		$billing_state 	= $sessOrderData['billing_state'];
		$billing_postal_code = $sessOrderData['billing_postal_code'];
		$billing_country = $sessOrderData['billing_country_id'];
		$billing_phone 	= $sessOrderData['billing_phone'];
		$this->data['Order']['insurance'] = $sessOrderData['insurance'];
			
		// Working for single item
		//if($gift_cost){
			//$totalCost = ($totalCost-$gift_cost);
		//}
		if($paypal != 'paypal'){
			$billing = '&LANDINGPAGE=Billing';
		}else{
			$billing = '';
		}
		
		$padata = 	'&CURRENCYCODE='.urlencode($PayPalCurrencyCode).
					'&PAYMENTREQUEST_0_PAYMENTACTION=Sale'.
					'&ALLOWNOTE=1'.
					'&LOGOIMG=http://www.choiceful.com/img/checkout/choiceful-logo.png'.$billing.
					'&SOLUTIONTYPE=Sole'.
					'&SHIPTOCOUNTRYCODE=GB'.
					'&SHIPTONAME='.$billing_user_title.$billing_firstname.' '.$billing_lastname.
					'&SHIPTOSTREET='.$billing_address1.' '.$billing_address2.
					'&SHIPTOCITY='.$billing_city.
					'&SHIPTOSTATE='.$billing_state.
					'&SHIPTOZIP='.$billing_postal_code.
					'&EMAIL='.$email.
					'&SHIPTOPHONENUM='.$billing_phone.
					'&PAYMENTREQUEST_0_INVNUM='.urlencode($order_number).
					'&PAYMENTREQUEST_0_CURRENCYCODE='.urlencode($PayPalCurrencyCode).
					'&PAYMENTREQUEST_0_AMT='.urlencode($totalCost).
					'&PAYMENTREQUEST_0_ITEMAMT='.urlencode($itemPrice).$shippingItems.
					'&PAYMENTREQUEST_0_SHIPPINGAMT='.urlencode($shappingcost).
					'&GIFTWRAPAMOUNT='.urlencode($gift_cost).
					'&PAYMENTREQUEST_0_INSURANCEAMT='.urlencode($insurance_cost).
					'&RETURNURL='.urlencode($PayPalReturnURL).
					'&CANCELURL='.urlencode($PayPalCancelURL);
		//echo $padata;
		//exit;
		
			//We need to execute the "SetExpressCheckOut" method to obtain paypal token
			$paypal= new MyPayPal();
			$httpParsedResponseAr = $paypal->PPHttpPost('SetExpressCheckout', $padata, $PayPalApiUsername, $PayPalApiPassword, $PayPalApiSignature, $PayPalMode);
			
			//Respond according to message we receive from Paypal
			if("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"]))
			{
						
					// If successful set some session variable we need later when user is redirected back to page from paypal. 
					$_SESSION['totalCost'] = $totalCost;
					if($PayPalMode=='sandbox')
					{
						$paypalmode 	=	'.sandbox';
					}
					else
					{
						$paypalmode 	=	'';
					}
					//Redirect user to PayPal store with Token received.
					$paypalurl ='https://www'.$paypalmode.'.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token='.$httpParsedResponseAr["TOKEN"].'';
					header('Location: '.$paypalurl);
				 
			}else{
				//Show error message
				echo '<div style="color:red"><b>Error : </b>'.urldecode($httpParsedResponseAr["L_LONGMESSAGE0"]).'</div>';
				echo '<pre>';
				print_r($httpParsedResponseAr);
				echo '</pre>';
			}
	
	}
	
	//Paypal redirects back to this page using ReturnURL, We should receive TOKEN and Payer ID
	if(isset($_GET["token"]) && isset($_GET["PayerID"]))
	{
		//we will be using these two variables to execute the "DoExpressCheckoutPayment"
		//Note: we haven't received any payment yet.
		
		$token = $_GET["token"];
		$playerid = $_GET["PayerID"];
		
		$ItemTotalPrice = $_SESSION['totalCost'];
		
		$padata = 	'&TOKEN='.urlencode($token).
							'&PAYERID='.urlencode($playerid).
							'&PAYMENTACTION='.urlencode("SALE").
							'&AMT='.urlencode($ItemTotalPrice).
							'&CURRENCYCODE='.urlencode($PayPalCurrencyCode);
		//echo $padata;
		//exit;
		//We need to execute the "DoExpressCheckoutPayment" at this point to Receive payment from user.
		$paypal= new MyPayPal();
		$httpParsedResponseAr = $paypal->PPHttpPost('DoExpressCheckoutPayment', $padata, $PayPalApiUsername, $PayPalApiPassword, $PayPalApiSignature, $PayPalMode);
			
		//Check if everything went ok..
		if("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"])) 
		{		
				echo '<h2>Success</h2>';
				echo 'Your Transaction ID :'.urldecode($httpParsedResponseAr["TRANSACTIONID"]);
						
					/*
					//Sometimes Payment are kept pending even when transaction is complete. 
					//May be because of Currency change, or user choose to review each payment etc.
					//hence we need to notify user about it and ask him manually approve the transiction
					*/
					
					if('Completed' == $httpParsedResponseAr["PAYMENTSTATUS"])
					{
						echo '<div style="color:green">Payment Received! Your product will be sent to you very soon!</div>';
					}
					elseif('Pending' == $httpParsedResponseAr["PAYMENTSTATUS"])
					{
						echo '<div style="color:red">Transaction Complete, but payment is still pending! You need to manually authorize this payment in your <a target="_new" href="http://www.paypal.com">Paypal Account</a></div>';
					}
						
						
					echo '<br /><b>Stuff to store in database :</b><br /><pre>';
						
					$transactionID = urlencode($httpParsedResponseAr["TRANSACTIONID"]);
					$nvpStr = "&TRANSACTIONID=".$transactionID;
					$paypal= new MyPayPal();
					$httpParsedResponseAr = $paypal->PPHttpPost('GetTransactionDetails', $nvpStr, $PayPalApiUsername, $PayPalApiPassword, $PayPalApiSignature, $PayPalMode);
						
					if("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"])) {
							
						//echo '<pre>';
						//print_r($httpParsedResponseAr);
						//echo '</pre>';
						$order_number = str_replace('%2d','-',$httpParsedResponseAr['INVNUM']);
						$orderIdData = $this->Ordercom->getOrderIdFromNumber($order_number);
						$orderId = $orderIdData['Order']['id'];
						$orderSuccessData['order_id'] = $orderId;
						$orderSuccessData['tranx_id'] = $httpParsedResponseAr["TRANSACTIONID"];
						$this->processOrderConfirmation($orderSuccessData); // update payemt status yes with transaction id
						$this->sendOrderConfirmationEmail($orderId); // send order confirmation email to customer
						$this->sendOrderDispatchNowEmail($orderId); // send order confirmation email to customer
						$orderId_encoded = base64_encode($orderId);
						$this->redirect('/checkouts/order_complete/'.$orderId_encoded);
						exit;
					} else  {
						echo '<div style="color:red"><b>GetTransactionDetails failed:</b>'.urldecode($httpParsedResponseAr["L_LONGMESSAGE0"]).'</div>';
						echo '<pre>';
						print_r($httpParsedResponseAr);
						echo '</pre>';
						
					}
						
		}else{
				echo '<div style="color:red"><b>Error : </b>'.urldecode($httpParsedResponseAr["L_LONGMESSAGE0"]).'</div>';
				echo '<pre>';
				print_r($httpParsedResponseAr);
				echo '</pre>';
				$this->redirect('/checkouts/step4/');
		}
	}


}

function giftexpresscheckout($totalCost = null,$order_number = null,$paypal= null){
	$this->layout = false;
	App::import('Vendor', 'paypalexp', array('file' => 'paypal'.DS.'PaypalExpress.php'));
	
	$PayPalMode 			= 'live'; // sandbox or live
	$PayPalApiUsername 		= 'milestones247_api1.gmail.com'; //PayPal API Username
	$PayPalApiPassword 		= 'SL6LWUCGMG4BM9VD'; //Paypal API password
	$PayPalApiSignature 	        = 'AFcWxV21C7fd0v3bYYYRCpSSRl31ApH0ThgpCzxR4uD8f5xfyocDw9XP'; //Paypal API Signature
	$PayPalCurrencyCode 	        = 'GBP'; //Paypal Currency Code
	$PayPalReturnURL 		= 'http://www.choiceful.com/checkouts/giftexpresscheckout'; //Point to process.php page
	$PayPalCancelURL 		= 'http://www.choiceful.com/checkouts/giftcertificate_step2'; //Cancel URL if user clicks cancel

if($totalCost) //Post Data received from product list page.
{
	$billing_add = $this->Session->read('billing_add');
	$total_order = $this->Session->read('Giftcheckout');
	$user_id = $this->Session->read('User.id');
	$userMailInfo = $this->Common->getUserMailInfo($user_id);
	$email = $userMailInfo['User']['email'];

	//Mainly we need 4 variables from an item, Item Name, Item Price, Item Number and Item Quantity.
	$ItemName = 'Gift Certificate'; //Item Name
	$ItemPrice = $totalCost; //Item Price
	$ItemNumber = 0; //Item Number
	$ItemQty = 1; // Item Quantity
	$ItemTotalPrice = $totalCost; //(Item Price x Quantity = Total) Get total amount of product; 
	
	$billing_user_title = $billing_add['Address']['title'];
	$billing_firstname = $billing_add['Address']['add_firstname'];
	$billing_lastname = $billing_add['Address']['add_lastname'];
	$billing_address1 = $billing_add['Address']['add_address1'];
	$billing_address2 = $billing_add['Address']['add_address2'];
	$billing_postecode = $billing_add['Address']['add_postcode'];
	$billing_city = $billing_add['Address']['add_city'];
	$add_state = $billing_add['Address']['add_state'];
	$add_phone = $billing_add['Address']['add_phone'];
	$billing_country_id = $billing_add['Address']['country_id'];
	
	if($paypal != 'paypal'){
		$billing = '&LANDINGPAGE=Billing';
	}else{
		$billing = '';
	}
	//Data to be sent to paypal
	$padata = 	'&CURRENCYCODE='.urlencode($PayPalCurrencyCode).
				'&PAYMENTACTION=Sale'.
				'&ALLOWNOTE=1'.
				'&PAYMENTREQUEST_0_CURRENCYCODE='.urlencode($PayPalCurrencyCode).
				'&ALLOWNOTE=1&LOGOIMG=http://www.choiceful.com/img/checkout/choiceful-logo.png'.$billing.
				'&SOLUTIONTYPE=Sole'.
				'&SHIPTOCOUNTRYCODE=GB'.
				'&SHIPTONAME='.$billing_user_title.$billing_firstname.' '.$billing_lastname.
				'&SHIPTOSTREET='.$billing_address1.' '.$billing_address2.
				'&SHIPTOCITY='.$billing_city.
				'&SHIPTOSTATE='.$add_state.
				'&SHIPTOZIP='.$billing_postecode.
				'&EMAIL='.$email.
				'&SHIPTOPHONENUM='.$add_phone.
				'&PAYMENTREQUEST_0_INVNUM='.urlencode($order_number).
				'&PAYMENTREQUEST_0_AMT='. urlencode($ItemTotalPrice).
				'&PAYMENTREQUEST_0_ITEMAMT='. urlencode($ItemTotalPrice).
				'&L_PAYMENTREQUEST_0_QTY0='. urlencode($ItemQty).
				'&L_PAYMENTREQUEST_0_AMT0='.urlencode($ItemPrice).
				'&L_PAYMENTREQUEST_0_NAME0='.urlencode($ItemName).
				//'&L_PAYMENTREQUEST_0_NUMBER0='.urlencode($ItemNumber).
				//'&AMT='.urlencode($ItemTotalPrice).				
				'&RETURNURL='.urlencode($PayPalReturnURL).
				'&CANCELURL='.urlencode($PayPalCancelURL);	
		//We need to execute the "SetExpressCheckOut" method to obtain paypal token
		$paypal= new MyPayPal();
		$httpParsedResponseAr = $paypal->PPHttpPost('SetExpressCheckout', $padata, $PayPalApiUsername, $PayPalApiPassword, $PayPalApiSignature, $PayPalMode);
		
		//Respond according to message we receive from Paypal
		if("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"]))
		{
					
				// If successful set some session variable we need later when user is redirected back to page from paypal. 
				$_SESSION['itemprice'] =  $ItemPrice;
				$_SESSION['totalamount'] = $ItemTotalPrice;
				$_SESSION['itemName'] =  $ItemName;
				$_SESSION['itemNo'] =  $ItemNumber;
				$_SESSION['itemQTY'] =  $ItemQty;
				
				if($PayPalMode=='sandbox')
				{
					$paypalmode 	=	'.sandbox';
				}
				else
				{
					$paypalmode 	=	'';
				}
				//Redirect user to PayPal store with Token received.
			 	$paypalurl ='https://www'.$paypalmode.'.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token='.$httpParsedResponseAr["TOKEN"].'';
				header('Location: '.$paypalurl);
			 
		}else{
			//Show error message
			echo '<div style="color:red"><b>Error : </b>'.urldecode($httpParsedResponseAr["L_LONGMESSAGE0"]).'</div>';
			echo '<pre>';
			print_r($httpParsedResponseAr);
			echo '</pre>';
		}

}

//Paypal redirects back to this page using ReturnURL, We should receive TOKEN and Payer ID
if(isset($_GET["token"]) && isset($_GET["PayerID"]))
{
	//we will be using these two variables to execute the "DoExpressCheckoutPayment"
	//Note: we haven't received any payment yet.
	
	$token = $_GET["token"];
	$playerid = $_GET["PayerID"];
	
	//get session variables
	$ItemPrice 		= $_SESSION['itemprice'];
	$ItemTotalPrice = $_SESSION['totalamount'];
	$ItemName 		= $_SESSION['itemName'];
	$ItemNumber 	= $_SESSION['itemNo'];
	$ItemQTY 		=$_SESSION['itemQTY'];
	
	$padata = 	'&TOKEN='.urlencode($token).
			'&PAYERID='.urlencode($playerid).
			'&PAYMENTACTION='.urlencode("SALE").
			'&AMT='.urlencode($ItemTotalPrice).
			'&CURRENCYCODE='.urlencode($PayPalCurrencyCode);
	//echo $padata;
	//exit;
	//We need to execute the "DoExpressCheckoutPayment" at this point to Receive payment from user.
	$paypal= new MyPayPal();
	$httpParsedResponseAr = $paypal->PPHttpPost('DoExpressCheckoutPayment', $padata, $PayPalApiUsername, $PayPalApiPassword, $PayPalApiSignature, $PayPalMode);
	
	//Check if everything went ok..
	if("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"])) 
	{
			echo '<h2>Success</h2>';
			echo 'Your Transaction ID :'.urldecode($httpParsedResponseAr["TRANSACTIONID"]);
			
				/*
				//Sometimes Payment are kept pending even when transaction is complete. 
				//May be because of Currency change, or user choose to review each payment etc.
				//hence we need to notify user about it and ask him manually approve the transiction
				*/
				
				if('Completed' == $httpParsedResponseAr["PAYMENTSTATUS"])
				{
					echo '<div style="color:green">Payment Received! Your product will be sent to you very soon!</div>';
				}
				elseif('Pending' == $httpParsedResponseAr["PAYMENTSTATUS"])
				{
					echo '<div style="color:red">Transaction Complete, but payment is still pending! You need to manually authorize this payment in your <a target="_new" href="http://www.paypal.com">Paypal Account</a></div>';
				}
			

			echo '<br /><b>Stuff to store in database :</b><br /><pre>';

				$transactionID = urlencode($httpParsedResponseAr["TRANSACTIONID"]);
				$nvpStr = "&TRANSACTIONID=".$transactionID;
				$paypal= new MyPayPal();
				$httpParsedResponseAr = $paypal->PPHttpPost('GetTransactionDetails', $nvpStr, $PayPalApiUsername, $PayPalApiPassword, $PayPalApiSignature, $PayPalMode);

				if("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"])) {
					
					/* 
					#### SAVE BUYER INFORMATION IN DATABASE ###
					$buyerName = $httpParsedResponseAr["FIRSTNAME"].' '.$httpParsedResponseAr["LASTNAME"];
					$buyerEmail = $httpParsedResponseAr["EMAIL"];
					
					$conn = mysql_connect("localhost","MySQLUsername","MySQLPassword");
					if (!$conn)
					{
					 die('Could not connect: ' . mysql_error());
					}
					
					mysql_select_db("Database_Name", $conn);
					
					mysql_query("INSERT INTO BuyerTable 
					(BuyerName,BuyerEmail,TransactionID,ItemName,ItemNumber, ItemAmount,ItemQTY)
					VALUES 
					('$buyerName','$buyerEmail','$transactionID','$ItemName',$ItemNumber, $ItemTotalPrice,$ItemQTY)");
					
					mysql_close($con);
					*/
					
					//echo '<pre>';
					//print_r($httpParsedResponseAr);
					//echo '</pre>';
					//exit;
						
						$this->data = '';
						$order_number = str_replace('%2d','-',$httpParsedResponseAr['INVNUM']);
						$this->data['Certificate']['order_certificate_id'] = $order_number;
						$this->data['OrderCertificate']['id'] = $order_number;
						$this->data['OrderCertificate']['payment_status'] = "Y";
						$this->data['OrderCertificate']['tranx_id'] = $httpParsedResponseAr["TRANSACTIONID"];
						$this->update_ordercertificate($this->data);
						$this->Session->write('giftcertificate_orderId',$order_number);
						$this->Session->write('giftcertificate_tranx_id',$httpParsedResponseAr["TRANSACTIONID"]);
						$this->save_certificate_payment($this->data['Certificate']['order_certificate_id']);
						$this->send_certificate_email($this->data['Certificate']['order_certificate_id']);
						$orderIdData = $this->Ordercom->getCertiOrderIdFromNumber($order_number);
						$orderId = $orderIdData['OrderCertificate']['id'];						
						$this->redirect('/checkouts/giftcertificate_step4/'.base64_encode($orderId));
						exit;
						
				} else  {
					echo '<div style="color:red"><b>GetTransactionDetails failed:</b>'.urldecode($httpParsedResponseAr["L_LONGMESSAGE0"]).'</div>';
					echo '<pre>';
					print_r($httpParsedResponseAr);
					echo '</pre>';
					
				}
					
		}else{
				echo '<div style="color:red"><b>Error : </b>'.urldecode($httpParsedResponseAr["L_LONGMESSAGE0"]).'</div>';
				echo '<pre>';
				print_r($httpParsedResponseAr);
				echo '</pre>';
		}
	}	
}
	/*function test(){
		$orderId = "100250";
		$getOrderList = $this->getOrderList();
		pr($getOrderList);
			if(!array_key_exists($orderId,$getOrderList)){
				echo "yes";	
			}else{
				echo "no";
			}
	}*/



}
?>