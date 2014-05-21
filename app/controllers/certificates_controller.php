<?php
/**  @class:		CertificatesController 
 @description		 etc.,
 @Created by: 		
 @Modify:		NULL
 @Created Date:		Dec 7, 2010
*/
App::import('Sanitize');
class CertificatesController extends AppController{
	var $name = 'Certificates';
	var $helpers = array('Form','Html','Javascript','Format','Session','Ajax','Fck','Validation','Common');
	var $components = array ('RequestHandler','Email','Common');

	var $permission_id = 9;  // for promotions module
	/**
	* @Date: Nov 12, 2010
	* @Method : beforeFilter
	* Created By: kulvinder singh
	* @Purpose: This function is used to validate admin user permissions
	* @Param: none
	* @Return: none 
	**/
	function beforeFilter(){
		$this->detectMobileBrowser();
		//check session other than admin_login page
		$includeBeforeFilter = array('admin_index','admin_add','admin_status','admin_multiplAction',
					     'admin_delete', 'admin_questions' , 'admin_multiplAction_question',
					     'admin_total_outstandings','admin_add_tags','admin_delete_tags','admin_tagstatus','admin_searchtag_multiplAction','admin_searchtags');
		if (in_array($this->params['action'],$includeBeforeFilter))
		{
			// validate admin users for this module
			$this->validateAdminModule($this->permission_id);
			
			// validate admin session
			$this->checkSessionAdmin();
			
		}
	}
	
	
	function admin_index(){
		//check that admin is login
		$this->checkSessionAdmin();
		/** for paging and sorting we are setting values */
		if(empty($this->data)){
			if(isset($this->params['named']['searchin']))
				$this->data['Search']['searchin'] = $this->params['named']['searchin'];
			else
				$this->data['Search']['searchin'] = '';
				
			if(isset($this->params['named']['keyword']))
				$this->data['Search']['keyword'] = $this->params['named']['keyword'];
			else
				$this->data['Search']['keyword'] = '';
			if(isset($this->params['named']['showtype']))
				$this->data['Search']['show'] = $this->params['named']['showtype'];
			else
				$this->data['Search']['show'] = '';
		}
		$criteria='';
		$value = '';	
		$show = '';
		$matchshow = '';
		$fieldname = '';
		/* SEARCHING */
		$reqData = $this->data;
		$option['All'] = "All";
		$options['Certificate.amount'] = "Amount";
		$options['Certificate.code'] = "Code";
		$options['Certificate.receiver'] = "Recipients";
		$this->set('options',$options);
		if(!empty($this->data['Search'])) {
			if(empty($this->data['Search']['searchin'])){
				$fieldname = 'All';
			} else {
				$fieldname = $this->data['Search']['searchin'];
			}
			//pr($this->data['Search']);
			$value = $this->data['Search']['keyword'];
			/*
			 $show  = $this->data['Search']['show'];
			if($show == 'Active'){
				$matchshow = '1';
			}
			if($show == 'Deactive') {
				$matchshow = '0';
			}*/
			$value = trim($this->data['Search']['keyword']);
			$value1= Sanitize::escape($value);
			if($value!=="") {
				if(trim($fieldname)=='All'){
					if(!empty($criteria))
						$criteria .= " AND (Certificate.amount = '".$value1."' OR Certificate.code LIKE '%".$value1."%' OR Certificate.receiver LIKE '%".$value1."%')";
					else
						$criteria = "(Certificate.amount = '".$value1."' OR Certificate.code LIKE '%".$value1."%' OR Certificate.receiver LIKE '%".$value1."%')";
				} else {
					if(trim($fieldname)!=''){
						if(isset($value) && $value!=="") {
							if(!empty($criteria))
								$criteria .= " AND ".$fieldname." LIKE '%".$value1."%'";
							else
								$criteria = $fieldname." LIKE '%".$value1."%'";
						}
					}
				}
			}
		}
		/** sorting and search */
		
 		if($this->RequestHandler->isAjax() == 0)
 			$this->layout = 'layout_admin';
 		else
			$this->layout = 'ajax';
			
		$this->set('keyword', $value);
		$this->set('fieldname',$fieldname);
			
		/******************** page limit sction **************** */
			
		$sess_limit_name = $this->params['controller']."_limit";
		$sess_limit_value = $this->Session->read($sess_limit_name);
		if( !empty( $this->data['Record']['limit'] ) ) {
			$limit = $this->data['Record']['limit'];
			$this->Session->write($sess_limit_name , $this->data['Record']['limit'] );
		} elseif( !empty($sess_limit_value) ) {
			$limit = $sess_limit_value;
		} else{
			$limit = 25;
		}
		$this->data['Record']['limit'] = $limit;
		/* ******************* page limit sction **************** */
		$this->Certificate->expects(array('Giftbalance','User'));
		
		$this->paginate = array(
			'limit' => $limit,
			'order' => array(
				'Certificate.id' => 'Desc'
			),
			'conditions'=>array('Certificate.payment_flag'=>'1'),
			'fields'=>array(
				'Certificate.code',
				'Certificate.amount',
				'Certificate.quantity',
				'Certificate.receiver',
				'Certificate.modified',
				'Certificate.created',
				'Certificate.status',
				'Certificate.id',
				'Giftbalance.id',
				'Giftbalance.user_id',
				'Giftbalance.created',
				'User.email',
			),
		);
		$this->set('listTitle','Manage Gift Certificate');
		
		$this->set('gift_certificates', $this->paginate('Certificate',$criteria));
	}

	/** 
	@function : admin_add 
	@description : Add/edit certificate,
	@params : id
	@Created by : Ramanpreet Pal Kaur
	@Modify : NULL
	@Created Date : Dec 8, 2010
	*/
	function admin_add($id=Null){
		//check that admin is login
		$this->checkSessionAdmin();
		$admin_id = $this->Session->read('SESSION_ADMIN.id');
		$this->layout = 'layout_admin';
		if(empty($id))
			$this->set('listTitle','Add Gift Certificate');
		else
			$this->set('listTitle','Update Gift Certificate');
		$this->set("id",$id);
		if(!empty($this->data)){
			$this->Certificate->set($this->data);
			
			if($this->Certificate->validates()) {
				App::import('Model','OrderCertificate');
				$this->OrderCertificate = new OrderCertificate;
				
				
				$this->data['OrderCertificate']['user_id'] = - 1;
				$this->data['OrderCertificate']['adminuser_id'] = $admin_id;
				
				$this->data['Certificate']['amount'] = str_replace('£','',$this->data['Certificate']['amount']);
				$this->data['Certificate']['amount'] = trim($this->data['Certificate']['amount']);
				
				if (!empty($this->data['Certificate']['quantity'])) {
					if(!empty($this->data['Certificate']['recipient'])){
						$recipients = explode(',',$this->data['Certificate']['recipient']);
						$total_receivers = count($recipients);
							
						$total_paid_amount = $this->data['Certificate']['quantity'] * $total_receivers * $this->data['Certificate']['amount'];
						$this->data['OrderCertificate']['total_amount'] = $total_paid_amount;
						$this->data['OrderCertificate']['payment_method'] = '';
						$this->data['OrderCertificate']['quantity'] = $this->data['Certificate']['quantity'] * $total_receivers;
						$this->data['OrderCertificate']['payment_status'] = 'Y';
								
						$this->OrderCertificate->set($this->data);
						if($this->OrderCertificate->save()){
							$ordercertificate_id = $this->OrderCertificate->getLastInsertId();
							$this->data['Certificate']['order_certificate_id'] = $ordercertificate_id;
							/** Send email after registration **/
							$this->Email->smtpOptions = array(
								'host' => Configure::read('host'),
								'username' => Configure::read('username'),
								'password' => Configure::read('password'),
								'timeout' => Configure::read('timeout')
							);
							
							$this->Email->replyTo = Configure::read('replytoEmail');
							$this->Email->sendAs= 'html';
							App::import('Model','EmailTemplate');
							$this->EmailTemplate = new EmailTemplate;
							$link=Configure::read('siteUrl');
							$mailsend = '';
							$mail_notsend = '';
							$quan = $this->data['Certificate']['quantity'];
							for($i = 0; $i < $quan; $i++) {
								foreach($recipients as $receiver){
									$autocode = $this->Common->generate_code();
									$returned_code = $this->checkUniquecode($autocode);
									$this->data['Certificate']['code'] = $returned_code;
									$this->data['Certificate']['receiver'] = $receiver;
									$this->data['Certificate']['quantity']  = 1;
									$this->data['Certificate']['id']  = 0;
									$this->data['Certificate']['user_id']  = -1;
									$this->data['Certificate']['adminuser_id']  = $admin_id;
									$this->data['Certificate']['payment_flag'] = 1;
									$this->Certificate->set($this->data);
									if ($this->Certificate->save($this->data)) {
										$saved[] = 1;
										/**
										table: email_templates
										id: 8
										description: Gift Certificate
										*/
										$template = $this->Common->getEmailTemplate(8);
										$this->Email->from = $template['EmailTemplate']['from_email'];
										$data = $template['EmailTemplate']['description'];
										$data = str_replace('[RecepientName]',$receiver,$data);
										$data = str_replace('[Code]',$this->data['Certificate']['code'],$data);
										$data = str_replace('[Value]',$this->data['Certificate']['amount'],$data);
										if(!empty($this->data['Certificate']['to'])){
											$data = str_replace('[ToUserEnteredContent]',$this->data['Certificate']['to'],$data);
										} else{
											$data = str_replace('To: [ToUserEnteredContent]','',$data);
										}
										if( !empty( $this->data['Certificate']['from'] ) ){
											$data = str_replace('[FromUserEnteredContent]',$this->data['Certificate']['from'],$data);
										} else{
											$data = str_replace('From: [FromUserEnteredContent]','',$data);
										}
										if(!empty($this->data['Certificate']['message'])){
											$data = str_replace('[MessageUserEnteredContent]',$this->data['Certificate']['message'],$data);
										} else{
											$data = str_replace('Message: [MessageUserEnteredContent]','',$data);
										}
										if(empty($this->data['Certificate']['message']) && empty($this->data['Certificate']['from']) && empty($this->data['Certificate']['to'])) {
											$data = str_replace('Senders Details:','',$data);
										}
		
										$template['EmailTemplate']['subject'] = str_replace('[RecepientName]',$receiver,$template['EmailTemplate']['subject']);
								
										$this->Email->subject = $template['EmailTemplate']['subject'];
		
										$this->set('data',$data);
		
										$receiver_name_arr = explode('@',$receiver);
										$receiver_name = $receiver_name_arr[0];
		
										$this->Email->to = $receiver;
										
										/******import emailTemplate Model and get template****/
										$this->Email->template = 'commanEmailTemplate';
										if($this->Email->send()) {
											if(empty($mailsend))
												$mailsend = $receiver;
											else
												$mailsend = $mailsend.', '.$receiver;
										} else{
											if(empty ( $mailsend ) )
												$mail_notsend = $receiver;
											else
												$mail_notsend = $mail_notsend.', '.$receiver;
										}
									} else {
										$this->Session->setFlash('Gift certificate has not been added.','default',array('class'=>'flashError') );
									}
								}
							}
							$session_msg = '';
							if (!empty ( $mailsend ) ) {
								$session_msg = '<div>Certificate successfully has successfully sent to: '.$mailsend.'</div>';
							}
							if ( !empty( $mail_notsend ) ) {
								$session_msg = $session_msg.'<div class="flashError">Certificate has not successfully sent to: '.$mail_notsend.'.</div>Please check all fields and try again to send this gift certificate.';
							}
							$this->Session->setFlash($session_msg);
							$this->redirect('/admin/certificates/index');
						} else{
							$this->Session->setFlash('Unable to save details, please try again','default',array('class'=>'flashError'));
						}
					}
				}
			} else {
				$this->set('errors',$this->Certificate->validationErrors);
			}
		}
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
	@function	:	get_giftcode
	@description	:	to generate gift certificate code
	@params		:	id of gift certificate
	@created	:	Jan 25,2011
	@credated by	:	Ramanpreet Pal Kaur
	**/
	function get_giftcode($id = null){
		$code ='';
		$code_info = $this->Certificate->find('first',array('conditions'=>array('Certificate.id'=>$id),'fields'=>'Certificate.code'));
		if(!empty($code_info)){
			$code = $code_info['Certificate']['code'];
		}
		return $code;
	}

	/** 
	@function	:	get_giftcode
	@description	:	to varify gift certificate is already used by user or not
	@params		:	id of gift certificate
	@created	:	Jan 25,2011
	@credated by	:	Ramanpreet Pal Kaur
	**/
	function used_giftcode($g_code = null){
		App::import('Model','Giftbalance');
		$this->Giftbalance = new Giftbalance;
		$used = 0;
		$certificate_info = $this->Giftbalance->find('first',array('conditions'=>array('Giftbalance.gift_code'=>$g_code)));

		if(!empty($certificate_info)){
			$used = 1;
		}
		return $used;
		
	}
	/** 
	@function	:	admin_status
	@description	:	to update status of selected certificate
	@params		:	gift certificate id, gift certificate status
	@created	:	Jan 25,2011
	@credated by	:	Ramanpreet Pal Kaur
	**/
	function admin_status($id = null,$status= null) {
		if(!empty($id)) {
			$gift_code = $this->get_giftcode($id);
			$used_giftcode = $this->used_giftcode($gift_code);
			if(empty($used_giftcode)){
				$this->data['Certificate']['id'] = $id;
				if($status == 0){
					$this->data['Certificate']['status'] = 1;
				} else{
					$this->data['Certificate']['status'] = 0;
				}
				if($this->Certificate->save($this->data)){
					$this->Session->setFlash('Information updated successfully.');
				} else{
					$this->Session->setFlash('Unable to change status of certificate with '.$gift_code.' code, please try again','default',array('class'=>'flashError'));
				}
			} else {
				$this->Session->setFlash('Unable to change status of certificate with '.$gift_code.' code, it is already used by user','default',array('class'=>'flashError'));
			}
		}
		$this->redirect('index');
	}
	/**
	@function : admin_multiplAction
	@description : Active/Deactive/Delete multiple record
	@params : NULL
	@created : Nov 12, 2010
	@credated by : Ramanpreet Pal Kaur
	**/
	function admin_multiplAction () {
		//check that admin is login
		$this->checkSessionAdmin();
		if($this->data['Certificate']['status']=='active'){
			$usedcodes = '';
			foreach($this->data['select'] as $id){
				if(!empty($id)){
					$gift_code = $this->get_giftcode($id);
					$used_giftcode = $this->used_giftcode($gift_code);
					if(empty($used_giftcode)){
						$this->Certificate->id=$id;
						$this->Certificate->saveField('status','1');
					} else{
						if(empty($usedcodes))
							$usedcodes = $gift_code;
						else
							$usedcodes = $usedcodes.', '.$gift_code;
					}
				}
			}
			if(!empty($usedcodes)){
				$this->Session->setFlash('Unable to change status of certificates having following codes, these are already used:<br>'.$usedcodes,'default',array('class'=>'flashError'));
			} else{
				$this->Session->setFlash('Information updated successfully.');
			}
		} elseif($this->data['Certificate']['status']=='inactive'){
			$usedcodes = '';
			foreach($this->data['select'] as $id){
				if(!empty($id)){
					$gift_code = $this->get_giftcode($id);
					$used_giftcode = $this->used_giftcode($gift_code);
					if(empty($used_giftcode)){
						$this->Certificate->id=$id;
						$this->Certificate->saveField('status','0');
					} else{
						if(empty($usedcodes))
							$usedcodes = $gift_code;
						else
							$usedcodes = $usedcodes.', '.$gift_code;
					}
				}
			}
			if(!empty($usedcodes)){
				$this->Session->setFlash('Unable to change status of certificates having following codes, these are already used:<br>'.$usedcodes,'default',array('class'=>'flashError'));
			} else{
				$this->Session->setFlash('Information updated successfully.');
			}
		} elseif($this->data['Certificate']['status']=='del'){
			
			$usedcodes = '';
			foreach($this->data['select'] as $id){
				if(!empty($id)){
					$gift_code = $this->get_giftcode($id);
					$used_giftcode = $this->used_giftcode($gift_code);
					if(empty($used_giftcode)){
						$this->Certificate->delete($id);
						//$this->Session->setFlash('Information deleted successfully.');
					} else{
						if(empty($usedcodes))
							$usedcodes = $gift_code;
						else
							$usedcodes = $usedcodes.', '.$gift_code;
					}
				}
			}
			if(!empty($usedcodes)){
				$this->Session->setFlash('Unable to delete certificates having following codes, these are already used:<br>'.$usedcodes,'default',array('class'=>'flashError'));
			} else{
				$this->Session->setFlash('Information deleted successfully.');
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
		$this->redirect('/admin/certificates/index/keyword:'.$this->data['Search']['keyword'].'/searchin:'.$this->data['Search']['searchin']);
	}

	/** 
	@function : checkUniquecode
	@description : to check uniqueness certificate code
	@params : genereted gift certificate code
	@created : Nov 12, 2010
	@credated by : Ramanpreet Pal Kaur
	**/
	function checkUniquecode($code = null) {
		$iscode_existed = $this->Certificate->find('all',array('conditions'=>array('Certificate.code'=>$code) ) );
		if(!empty($iscode_existed) ) {
			$autocode1 = $this->Common->generate_code();
			$return_autocode = $this->checkUniquecode($autocode1);
		}
		$returncode = $code;
		return $returncode;
	}

	/** 
	@function	:	purchase_gift
	@description	:	To purchase gift certificate for friends
	@params		:	NULL
	@created	:	Jan 10, 2010
	@credated by	:	Ramanpreet Pal Kaur
	**/
	function purchase_gift(){
		//$this->checkSessionFrontUser();
		if ($this->RequestHandler->isMobile()) {
        	// if device is mobile, change layout to mobile
        		 $this->layout = 'mobile/product';
        			}else{
			$this->layout = 'gift';
		}
		$session_biling_add = $this->Session->read('billing_add');
		if(!empty($session_biling_add))
			$this->Session->delete('billing_add');
		
		###################  get history items from cookies ################
		App::import('Model','ProductVisit');
		$this->ProductVisit = new ProductVisit;
		$myRecentProducts = $this->ProductVisit->getMyVisitedProducts();
		$this->set('myRecentProducts',$myRecentProducts);
			
		#############################################
		if(!empty($this->data)){
			$this->Certificate->set($this->data);
			if($this->Certificate->validates()) {
					
				$this->data = $this->cleardata($this->data);
				//$this->data = Sanitize::clean($this->data, array('encode' => false));
					
				if(!empty($this->data['Certificate']['recipient'])){
					$all_recipient = explode(',',$this->data['Certificate']['recipient']);
					$i = 0;
					foreach($all_recipient as $receiver){
						$session_arr[$i]['touser'] = $receiver;
						$session_arr[$i]['amount'] = $this->data['Certificate']['amount'];
						$session_arr[$i]['quantity'] = $this->data['Certificate']['quantity'];
						$session_arr[$i]['to'] = $this->data['Certificate']['to'];
						$session_arr[$i]['from'] = $this->data['Certificate']['from'];
						$session_arr[$i]['message'] = $this->data['Certificate']['message'];
						$i++;
					}
					$this->Session->write('Giftcheckout',$session_arr);
					$this->redirect('/checkouts/step1/1');
				}
			} else{
				$this->set('errors',$this->Certificate->validationErrors);
			}
		}
			$this->set('errors',$this->Certificate->validationErrors);
			
		App::import('Model','CertificateQuestion');
		$this->CertificateQuestion = new CertificateQuestion;
		$this->CertificateQuestion->expects(array('CertificateAnswer'));
		$questions = $this->CertificateQuestion->find('all',array('conditions'=>array('CertificateQuestion.status'=>1)));
			
		App::import('Model', 'CertificateRating');
		$this->CertificateRating = new CertificateRating();
		$avgRating = $this->CertificateRating->get_avg_rating();
			
		$this->set('full_stars',$avgRating['full_stars']);
		$this->set('half_star',$avgRating['half_star']);
		$this->set('total_rating_reviewers',$avgRating['total_rating_reviewers']);
		$this->set('questions',$questions);
		App::import('Model','Page');
		$this->Page = new Page;
		$details= $this->Page->find('first',array('recursive'=>1,'conditions'=>array('Page.pagecode'=> 'purchase-gift-certificate-terms-and-conditions')));
			
		/** Manage Title, meta description and meta keywords ***/
		$this->pageTitle  = $details['Page']['meta_title'];
		$this->set('title_for_layout',$details['Page']['meta_title']);
		$this->set('meta_description',$details['Page']['meta_description']);
		App::import('Model','CertificateSearchtag');
		$this->CertificateSearchtag = &new CertificateSearchtag;
		$searchtags = $this->CertificateSearchtag->find('list',array('conditions'=>array('CertificateSearchtag.status'=>'1'),'fields'=>array('CertificateSearchtag.tags')));
		$searchtag_str = '';
		if(!empty($searchtags)){
			foreach($searchtags as $searchtag){
				if(empty($searchtag_str)){
					$searchtag_str = $searchtag;
				} else{
					$searchtag_str = $searchtag_str.','.$searchtag;
				}
			}
		}
			
		$this->set('meta_keywords',$details['Page']['meta_keyword'].','.$searchtag_str);
			
		if(!empty($details['Page']['description'])){
			$this->set('detail_info',$details['Page']['description']);
		} else{
			$this->set('detail_info','');
		}
		/** Manage Title, meta description and meta keywords ***/
	}

	
	/** 
	@function	:	apply_gift
	@description	:	To apply gift certificate
	@params		:	NULL
	@created	:	Jan 19, 2010
	@credated by	:	Ramanpreet Pal Kaur
	**/
	function apply_gift(){
		$this->checkSessionFrontUser();
		$user_id = $this->Session->read('User.id');
		$this->layout='front';
		
		$this->set('title_for_layout','Choiceful.com: My Account - Apply Gift Certificate');
		if(!empty($this->data)){
			
			$this->data = $this->cleardata($this->data);
			//$this->data = Sanitize::clean($this->data, array('encode' => false));
			
			$this->Certificate->set($this->data);
			if($this->Certificate->validates()) {
				$gift_existed = array();
				$this->data['Certificate']['gift_code'] = trim($this->data['Certificate']['gift_code']);
				$gift_existed = $this->checkVaildGift($this->data['Certificate']['gift_code']);

				if(empty($gift_existed['value'])){
					$this->Session->setFlash('Please enter vaild gift certificate code.','default',array('class'=>'flashError'));
				} else if($gift_existed['value'] == 1){
					$this->Session->setFlash('There appears to be a problem, please check your gift certificate code and try again.','default',array('class'=>'flashError'));
				} else{
					App::import('Model','Giftbalance');
					$this->Giftbalance = new Giftbalance;

					$user_giftInfo = $this->Giftbalance->find('all',array('conditions'=>array('Giftbalance.gift_code'=>$this->data['Certificate']['gift_code'])));

					if(empty($user_giftInfo)){
						$this->data['Giftbalance'] = $this->data['Certificate'];
						$this->data['Giftbalance']['user_id'] = $user_id;
						$this->data['Giftbalance']['amount'] = $gift_existed['amount'];
						$this->data = Sanitize::clean($this->data);
						$this->Giftbalance->set($this->data);
						if($this->Giftbalance->save($this->data)){
							$this->Session->setFlash('You have successfully applied your gift certificate.');
							$this->redirect('/certificates/gift_balance');
						} else{
							$this->Session->setFlash('Unable to apply you certificate, please try again.','default',array('class'=>'flashError'));
						}
					} else{
						$this->Session->setFlash('The code entered has been applied to another user\'s Choiceful.com gift balance. Please check and type the code you wish to apply again.','default',array('class'=>'flashError'));
					}
				}
			} else{
				$errors = $this->Certificate->validationErrors;
				$this->set('errors',$errors);
			}
		}
	}


	/** 
	@function	:	checkVaildGift
	@description	:	To apply gift certificate
	@params		:	to check applied certificate code is vaild or not
	@created	:	Jan 19, 2010
	@credated by	:	Ramanpreet Pal Kaur
	**/
	function checkVaildGift($giftcode = null){
		if(!empty($giftcode)){
			$gift_info = $this->Certificate->find('first',array('conditions'=>array('BINARY Certificate.code ='."'".$giftcode."'",'Certificate.status'=>'1')));
			if(!empty($gift_info)){
				$return['value'] = 2;
				$return['amount'] = $gift_info['Certificate']['amount'];
				return $return;
			} else{
				$return['value'] = 1;

				return $return;
			}
		} else{
			$return['value'] = 0;
			return $return;
		}
	}


	/** 
	@function	:	gift_balance
	@description	:	To view gift balance
	@params		:	NULL
	@created	:	Jan 19, 2010
	@credated by	:	Ramanpreet Pal Kaur
	**/
	function gift_balance(){
		$this->checkSessionFrontUser();
		if ($this->RequestHandler->isMobile()) {
 			$this->layout = 'mobile/product';
		} else{
			$this->layout = 'front';
		}
		$this->set('title_for_layout','Choiceful.com: My Account - Gift Certificate Balance');
		
		
		
		//Start For Mobile Site apply gift certificate
		
		if(!empty($this->data)){
			$this->Certificate->set($this->data);
			if($this->Certificate->validates()) {
				$gift_existed = array();
				$this->data['Certificate']['gift_code'] = trim($this->data['Certificate']['gift_code']);
				$gift_existed = $this->checkVaildGift($this->data['Certificate']['gift_code']);
				
				if(empty($gift_existed['value'])){
					$this->Session->setFlash('Please enter vaild gift certificate code.','default',array('class'=>'flashError'));
				} else if($gift_existed['value'] == 1){
					$this->Session->setFlash('There appears to be a problem, please check your gift certificate code and try again.','default',array('class'=>'flashError'));
				} else{
					App::import('Model','Giftbalance');
					$this->Giftbalance = new Giftbalance;
					
					$user_giftInfo = $this->Giftbalance->find('all',array('conditions'=>array('Giftbalance.gift_code'=>$this->data['Certificate']['gift_code'])));
						
						
						
					if(empty($user_giftInfo)){
						$user_id = $this->Session->read('User.id');
						$this->data['Giftbalance'] = $this->data['Certificate'];
						$this->data['Giftbalance']['user_id'] = $user_id;
						$this->data['Giftbalance']['amount'] = $gift_existed['amount'];
						$this->data = Sanitize::clean($this->data);
						$this->Giftbalance->set($this->data);
						if($this->Giftbalance->save($this->data)){
							$this->Session->setFlash('You have successfully applied your gift certificate.');
							$this->redirect('/certificates/gift_balance');
						} else{
							$this->Session->setFlash('Unable to apply you certificate, please try again.','default',array('class'=>'flashError'));
						}
					} else{
						$this->Session->setFlash("The code entered has been applied to another user's Choiceful.com gift balance. Please check and type the code you wish to apply again.",'default',array('class'=>'flashError'));
					}
				}
			} else{
				$errors = $this->Certificate->validationErrors;
				$this->set('errors',$errors);
			}
		}
		
		//End For Mobile Site apply gift certificate
		$user_id = $this->Session->read('User.id');
		App::import('Model','Giftbalance');
		$this->Giftbalance = new Giftbalance;
		$gift_total = 0;$remaining_gift_balance = 0;

		$gift_total = $this->Giftbalance->find('all',array('conditions'=>array('Giftbalance.user_id'=>$user_id),'fields'=>array('SUM(Giftbalance.amount) as total_amount')));

		$used_gift_balance = 0;

		if(!empty($gift_total[0][0]['total_amount'])){
			App::import('Model','Order');
			$this->Order = new Order;
			$used_gift_balance = $this->Order->find('all',array('conditions'=>array('Order.user_id'=>$user_id,'Order.payment_status'=>'Y'),'fields'=>array('SUM(Order.gc_amount) as used_gift_amount')));
		}

		$remaining_gift_balance = $gift_total[0][0]['total_amount'] - $used_gift_balance[0][0]['used_gift_amount'];
		$this->set('gift_balance',$remaining_gift_balance);
	}

	/** 
	@function	:	add_review
	@description	:	To add new review from front end for a product
	@params		:	NULL
	@created	:	Jan 10, 2010
	@credated by	:	Ramanpreet Pal Kaur
	**/
	function add_review() {
		if ($this->RequestHandler->isMobile()) {
			$this->layout = 'ajax';
		}else{
			$this->layout = 'front_popup';
		}
		$user = $this->Session->read('User');
		$overall_reviews = '';
		App::import('Model','CertificateReview');
		$this->CertificateReview = new CertificateReview;
		if(!empty($user)){
			if(!empty($this->data)){
				$this->data['Certificate']['user_id'] = $user['id'];
				if($user['user_type'] == 1)
					$this->data['Certificate']['user_type'] = 'Seller';
				else
					$this->data['Certificate']['user_type'] = 'Buyer';
				if($this->data['Certificate']['review_type'] == '2'){
					$this->data['Certificate']['review_value'] = '+1';
				} else if($this->data['Certificate']['review_type'] == '1'){
					$this->data['Certificate']['review_value'] = '0';
				} else if($this->data['Certificate']['review_type'] == '0'){
					$this->data['Certificate']['review_value'] = '-1';
				}
				$this->Certificate->set($this->data);
				if($this->Certificate->validates()){
					$this->data['CertificateReview'] = $this->data['Certificate'];
					$this->CertificateReview->set($this->data);
					if($this->CertificateReview->save($this->data)){
						$this->Session->setFlash('Review added successfully.');
						if (!$this->RequestHandler->isMobile()) {
						echo "<script type=\"text/javascript\">parent.jQuery.fancybox.close();
						parent.location.reload(true);
						</script>";
						}
					} else{
						$this->Session->setFlash('Review has not been added successfully.');
						//echo "<script type=\"text/javascript\">parent.$.fancybox.close();
							//window.location.href='/users/login/';
						//</script>";
					}
				} else {
					$errors = $this->Certificate->validationErrors;
					if(!empty($errors['review_type'])){
						$this->data['Certificate']['review_type'] = null;
					}
					$this->set('errors',$errors);
				}
			}
			$all_reviews = $this->CertificateReview->find('list',array('conditions'=>array('CertificateReview.status = "1"'),'fields'=>array('CertificateReview.id','CertificateReview.review_value')));
			$total_reviews = count($all_reviews);
			$over_all_review_value= 0;
			if(!empty($all_reviews)){
				foreach($all_reviews as $review_value){
					$over_all_review_value = $over_all_review_value + $review_value;
				}
			}
			if($over_all_review_value > 0){
				$over_all = 'Positive';
			} else if($over_all_review_value < 0){
				$over_all = 'Negative';
			} else if($over_all_review_value == 0){
				$over_all = 'Neutral';
			}
			$total_count_selected = count($all_reviews);
			$this->set('total_count_selected',$total_count_selected);
			$this->set('overall_reviews',$over_all);
		} else{
			//echo "<script type=\"text/javascript\">parent.$.fancybox.close();
				//parent.redirect();
			//</script>";
			$from_url = '/certificate/add_review/'.$product_id;
			$this->Session->write('back_url',$from_url);
			$this->redirect('/users/sign_in');
		}
	}

	/**
	@function	:	save_reviewvote
	@description	:	To add vote on a review from front end
	@params		:	review id, vote either 0 or 1, type of review(positive,negative,neutral)
	@created	:	10 January, 2011
	@credated by	:	Ramanpreet Pal Kaur
	**/
	function save_reviewvote($review_id = null , $vote = null, $review_type = null){
		App::import('Model','CertificateReviewVote');
		$this->CertificateReviewVote = new CertificateReviewVote;
		if ($this->RequestHandler->isMobile()) {
        	// if device is mobile, change layout to mobile
        		 $this->viewPath = 'elements/mobile/gift_certificate' ;
        			}else{
			$this->viewPath = 'elements/gift_certificate' ;
		}
		if(!empty($review_id)) {
			$this->data['CertificateReviewVote']['review_id'] = $review_id;
			$this->data['CertificateReviewVote']['user_vote'] = $vote;
			$this->data = Sanitize::clean($this->data);
			$this->set($this->data);
			if($this->CertificateReviewVote->save($this->data)){
				if($review_type == 0){
					$this->Session->write('giftVotesaved_neg'.$review_id,1);
					$this->set('rev_gift_neg_id',$review_id);
					$this->render('vote_neg');
				} else if($review_type == 1){
					$this->Session->write('giftVotesaved_neu'.$review_id,1);
					$this->set('rev_gift_neu_id',$review_id);
					$this->render('vote_neu');
				} else if($review_type == 2){
					$this->Session->write('giftVotesaved_pos'.$review_id,1);
					$this->set('rev_gift_pos_id',$review_id);
					$this->render('vote_pos');
				}
			} else{
				if($review_type == 0){
					$this->Session->write('giftVotesaved_neg'.$review_id,0);
					$this->set('rev_gift_neg_id',$review_id);
					$this->render('vote_neg');
				} else if($review_type == 1){
					$this->Session->write('giftVotesaved_neu'.$review_id,0);
					$this->set('rev_gift_neu_id',$review_id);
					$this->render('vote_neu');
				} else if($review_type == 2){
					$this->Session->write('giftVotesaved_pos'.$review_id,0);
					$this->set('rev_gift_pos_id',$review_id);
					$this->render('vote_pos');
				}
			}
		} else{
			if($review_type == 0){
				$this->Session->write('giftVotesaved_neg'.$review_id,0);
				$this->set('rev_gift_neg_id',$review_id);
				$this->render('vote_neg');
			} else if($review_type == 1){
				$this->Session->write('giftVotesaved_neu'.$review_id,0);
				$this->set('rev_gift_neu_id',$review_id);
				$this->render('vote_neu');
			} else if($review_type == 2){
				$this->Session->write('giftVotesaved_pos'.$review_id,0);
				$this->set('rev_gift_pos_id',$review_id);
				$this->render('vote_pos');
			}
		}
	}

	/**
	@function	:	add_question
	@description	:	To add question for gift certificate
	@params		:	Null
	@created	:	10 January, 2011
	@credated by	:	Ramanpreet Pal Kaur
	**/
	function add_question(){
		if ($this->RequestHandler->isMobile()) {
			$this->layout = 'ajax';
		}else{
			$this->layout = 'front_popup';
		}
		$user = $this->Session->read('User');
		if(!empty($user)){
			if(!empty($this->data)) {
				$this->data = $this->cleardata($this->data);
				App::import('Model', 'CertificateQuestion');
				$this->CertificateQuestion = new CertificateQuestion();
				$this->CertificateQuestion->set($this->data);
				if($this->CertificateQuestion->validates()){
					if($this->CertificateQuestion->save($this->data)){
						$this->Session->setFlash('Your question added successfully.');
						if (!$this->RequestHandler->isMobile()) {
						echo "<script type=\"text/javascript\">parent.jQuery.fancybox.close();
							</script>";
						}
					} else{
						$this->Session->setFlash('Your question has not been added successfully.');
					}
				} else{
					$this->set('errors',$this->CertificateQuestion->validationErrors);
				}
			}
		}else{
			$this->Session->setFlash('Please login before add a question');
			$this->redirect('/homes/index');
		}
	}

	/**
	@function	:	answer_question
	@description	:	To add answer to selected question for gift certificate
	@params		:	question id
	@created	:	10 January, 2011
	@credated by	:	Ramanpreet Pal Kaur
	**/
	function answer_question($question_id=null){
		if ($this->RequestHandler->isMobile()) {
			$this->layout = 'ajax';
			$this->set('question_id',$question_id);
		}else{
			$this->layout = 'front_popup';
		}
		App::import('Model', 'CertificateAnswer');
		$this->CertificateAnswer = new CertificateAnswer();
		App::import('Model', 'CertificateQuestion');
		$this->CertificateQuestion = new CertificateQuestion();
		$user = $this->Session->read('User');
		if(!empty($user)){
			if(!empty($this->data)){
				$this->CertificateAnswer->set($this->data);
				if($this->CertificateAnswer->validates()){
					if($this->CertificateAnswer->save($this->data)){
						$this->Session->setFlash('Your answer added successfully.');
						if (!$this->RequestHandler->isMobile()) {
						echo "<script type=\"text/javascript\">parent.jQuery.fancybox.close();
							</script>";
						}
					} else{
						$this->Session->setFlash('Your answer has not been added successfully.');
					}
				} else{
					$this->set('errors',$this->CertificateAnswer->validationErrors);
				}
			} else{
				$ques = $this->CertificateQuestion->find('first',array('conditions'=>array('CertificateQuestion.id'=>$question_id),'fields'=>array('CertificateQuestion.id','CertificateQuestion.question')));
				$this->data['CertificateAnswer']['question'] = $ques['CertificateQuestion']['question'];
				$this->data['CertificateAnswer']['certificate_question_id'] = $ques['CertificateQuestion']['id'];
			}
		}else{
			$this->Session->setFlash('Please login before add a question');
			$this->redirect('/homes/index');
		}
		
	}

	/** 
	@function : save_ansvote
	@description : to save votes for answers
	@Created by : Ramanpreet Pal Kaur
	@params :  answer id, vote either 0 or 1
	@Modify : 
	@Created Date : 
	*/
	function save_ansvote($answer_id = null , $vote = null){
		App::import('Model','CertificateanswerVote');
		$this->CertificateanswerVote = new CertificateanswerVote;
		$this->layout = 'ajax';
		if(!empty($answer_id)) {
			$this->data['CertificateanswerVote']['answer_id'] = $answer_id;
			$this->data['CertificateanswerVote']['user_vote'] = $vote;
			$this->set($this->data);
			if($this->CertificateanswerVote->save($this->data)){
				$this->Session->write('sessionGiftAnsId'.$answer_id,1);
			} else{
				$this->Session->write('sessionGiftAnsId'.$answer_id,0);
			}
			$this->set('ans_id',$answer_id);
		} else{
			$this->Session->write('sessionGiftAnsId'.$answer_id,0);
		}
		$this->set('ans_id',$answer_id);
	}

	/** 
	@function : report_answer
	@description : to send report for answers
	@Created by : Ramanpreet Pal Kaur
	@params : answer id
	@Modify : 
	@Created Date : 
	*/
	function report_answer($ans_id = null){
		$this->layout = 'front_popup';
		$user = $this->Session->read('User');
		App::import('Model', 'CertificateAnswer');
		$this->CertificateAnswer = new CertificateAnswer();
		if(!empty($this->data)){
			$this->Certificate->set($this->data);
			if($this->Certificate->validates()){
				$this->Email->smtpOptions = array(
					'host' => Configure::read('host'),
					'username' =>Configure::read('username'),
					'password' => Configure::read('password'),
					'timeout' => Configure::read('timeout')
				);
				$this->Email->from = ucwords(strtolower($user['firstname'].' '.$user['lastname'])).'<'.$user['email'].'>';
				$this->Email->from = ucwords(strtolower($user['firstname'].' '.$user['lastname'])).'<'.$user['email'].'>';
				$this->Email->sendAs= 'html';
				$data = '<table width="100%" cellspacing="3" cellpadding ="3" border="0">';
				$data = $data.'<tr><td>You have received following report on  "('.$this->data['Certificate']['name'].') '.$this->data['Certificate']['question'].'" question for  "'.$this->data['Certificate']['answer'].' answer":</td></tr>';
				$data = $data.'<tr><td><br/>'.$this->data['Certificate']['reason'].'</td></tr>';
				$data = $data.'</table>';
				$this->Email->subject = 'Answer report for '.$this->data['Certificate']['name'];
				$this->set('data',$data);
				$this->Email->to = Configure::read('fromEmail');
				/******import emailTemplate Model and get template****/
				$this->Email->template='commanEmailTemplate';
				if($this->Email->send()) {
					$this->Session->setFlash('Report has been sent successfully.');
					echo "<script type=\"text/javascript\">parent.jQuery.fancybox.close();
						</script>";
				} else{
					$this->Session->setFlash('An error occurred while sending the email. Please try later.','default',array('class'=>'flashError'));
				}
			} else {
				$this->set('errors',$this->Certificate->validationErrors);
			}
		} else{
			$this->CertificateAnswer->expects(array('CertificateQuestion'));
			$certificate_detail = $this->CertificateAnswer->find('first',array('conditions'=>array('CertificateAnswer.id'=>$ans_id),'fields'=>array('CertificateAnswer.id','CertificateAnswer.certificate_question_id','CertificateAnswer.answer','CertificateQuestion.question')));
			$this->data['Certificate']['question'] = $certificate_detail['CertificateQuestion']['question'];
			$this->data['Certificate']['answer'] = $certificate_detail['CertificateAnswer']['answer'];
			
			if(!empty($this->data['Certificate'])){
				foreach($this->data['Certificate'] as $field_index => $info){
					$this->data['Certificate'][$field_index] = html_entity_decode($info);
					$this->data['Certificate'][$field_index] = str_replace('&#039;',"'",$this->data['Certificate'][$field_index]);
				}
			}
		}
	}


	/** 
	@function	:	report_review
	@description	:	To send report on a review from front end
	@params		:	review id
	@created	:	
	@credated by	:	Ramanpreet Pal Kaur
	**/
	function report_review($review_id = null){
		$this->layout = 'front_popup';
		$user = $this->Session->read('User');
		App::import('Model', 'CertificateReview');
		$this->CertificateReview = new CertificateReview();
		if(!empty($this->data)){
			$this->Certificate->set($this->data);
			if($this->Certificate->validates()){
				$this->Email->smtpOptions = array(
					'host' => Configure::read('host'),
					'username' =>Configure::read('username'),
					'password' => Configure::read('password'),
					'timeout' => Configure::read('timeout')
				);

				$this->Email->from = ucwords(strtolower($user['firstname'].' '.$user['lastname'])).'<'.$user['email'].'>';
				$this->Email->from = ucwords(strtolower($user['firstname'].' '.$user['lastname'])).'<'.$user['email'].'>';

				$this->Email->sendAs= 'html';
				$data = '<table width="100%" cellspacing="3" cellpadding ="3" border="0">';
				if($this->data['Certificate']['review_type'] == 2){
					$display_type = 'Positive';
				} else if($this->data['Certificate']['review_type'] == 1){
					$display_type = 'Neutral';
				} else {
					$display_type = 'Negative';
				}
				$data = $data.'<tr><td>You have received following report on  "('.$display_type.') '.$this->data['Certificate']['review'].'" review for Gift Certificate:</td></tr>';
				$data = $data.'<tr><td><br/>'.$this->data['Certificate']['reason'].'</td></tr>';
				$data = $data.'</table>';
				$this->Email->subject = 'Review report for a Gift Certificate';
				$this->set('data',$data);
				$this->Email->to = Configure::read('fromEmail');
				/******import emailTemplate Model and get template****/
				$this->Email->template='commanEmailTemplate';
				if($this->Email->send()) {
					$this->Session->setFlash('Report has been sent successfully.');
					echo "<script type=\"text/javascript\">parent.jQuery.fancybox.close();
						</script>";
				} else{
					$this->Session->setFlash('An error occurred while sending the email. Please try later.','default',array('class'=>'flashError'));
				}
			} else {
				$this->set('errors',$this->Certificate->validationErrors);
			}
		} else{
			$this->CertificateReview->expects(array('User'));
			$review_detail = $this->CertificateReview->find('first',array('conditions'=>array('CertificateReview.id'=>$review_id),'fields'=>array('CertificateReview.id','CertificateReview.review_type','CertificateReview.comments','CertificateReview.user_id','User.email')));
			$this->data['Certificate']['user'] = $review_detail['User']['email'];
			$this->data['Certificate']['review_id'] = $review_detail['CertificateReview']['id'];
			$this->data['Certificate']['review_type'] = $review_detail['CertificateReview']['review_type'];
			$this->data['Certificate']['review'] = $review_detail['CertificateReview']['comments'];
			if(!empty($this->data['CertificateReview'])){
				foreach($this->data['CertificateReview'] as $field_index => $info){
					$this->data['CertificateReview'][$field_index] = html_entity_decode($info);
					$this->data['CertificateReview'][$field_index] = str_replace('&#039;',"'",$this->data['CertificateReview'][$field_index]);
				}
			}
		}
	}

	/**
	@function:admin_questions
	@description:listing of gift certificate questions,
	@params:NULL
	@Created by: Ramanpreet Pal
	@Modify:NULL
	@Created Date: Jan 12, 2010
	*/

	function admin_questions(){
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
		$options['ProductQuestion.question'] = "Question";
		$showArr = $this->getStatus();
		$this->set('showArr',$showArr);
		$this->set('options',$options);
		if(!empty($this->data['Search']))
		{
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
			$value = trim($this->data['Search']['keyword']);
			App::import('Sanitize');
			$value1= Sanitize::escape($value);
			if($value!=="") {
				if(trim($fieldname)=='All'){
					$criteria .= " and (CertificateQuestion.question LIKE '%".$value1."%')";
				} else {
					if(trim($fieldname)!=''){
						if(isset($value) && $value!=="") {
							$criteria .= " and ".$fieldname." LIKE '%".$value1."%'";
						}
					}
				}
			}
			if(isset($show) && $show!==""){
				if($show == 'All'){
				} else {
					$criteria .= " and CertificateQuestion.status = '".$matchshow."'";
					$this->set('show',$show);
				}
			}
		}
		/** sorting and search */
 		if($this->RequestHandler->isAjax()==0)
 			$this->layout = 'layout_admin';
 		else
			$this->layout = 'ajax';
		
		$this->set('keyword', $value);
		$this->set('show', $show);
		$this->set('fieldname',$fieldname);
		
		/* ******************* page limit sction **************** */
		$sess_limit_name = $this->params['controller']."_quelimit";

		$sess_limit_value = $this->Session->read($sess_limit_name);

		if(!empty($this->data['Record']['limit'])){
		   $limit = $this->data['Record']['limit'];
		   $this->Session->write($sess_limit_name , $this->data['Record']['limit'] );
		}elseif( !empty($sess_limit_value) ){
			$limit = $sess_limit_value;
		}else{
			$limit = 25;
		}
		$this->data['Record']['limit'] = $limit;
		/* ******************* page limit sction **************** */
		App::import('Model','CertificateQuestion');
		$this->CertificateQuestion = new CertificateQuestion;
		$this->paginate = array(
			'limit' => $limit,
			'order' => array(
					'CertificateQuestion.id' => 'Desc'
			),
			'fields'=>array(
				'CertificateQuestion.question',
				'CertificateQuestion.id',
				'CertificateQuestion.status',
				'CertificateQuestion.created'
			),
		);
		//pr($this->paginate('ProductQuestion',$criteria));
		$this->set('listTitle','Manage Gift Certificate Questions');
		$this->set('questions', $this->paginate('CertificateQuestion',$criteria));
	}

	/**
	@function	:	admin_multiplAction_question
	@description	:	To perform active deactive and delete actions on multiple gift certificate
	@params		:	question id
	@created	:	10 January, 2011
	@credated by	:	Ramanpreet Pal Kaur
	**/
	function admin_multiplAction_question() {
		//check that admin is login
		$this->checkSessionAdmin();
		App::import('Model','CertificateQuestion');
		$this->CertificateQuestion = new CertificateQuestion;
		App::import('Model','CertificateAnswer');
		$this->CertificateAnswer = new CertificateAnswer;
		if($this->data['CertificateQuestion']['status']=='active'){
			foreach($this->data['select'] as $id){
				if(!empty($id)){
					$this->CertificateQuestion->id=$id;
					if($this->CertificateQuestion->saveField('status','1')){
						$all_ans = $this->CertificateAnswer->find('all',array('conditions'=>array('CertificateAnswer.certificate_question_id'=>$id)));
						if(!empty($all_ans)){
							foreach($all_ans as $ans){
								$this->CertificateAnswer->id = $ans['CertificateAnswer']['id'];
								$this->CertificateAnswer->saveField('status','1');
							}
						}
					}
					$this->Session->setFlash('Information updated successfully.');
				}
			}
		} elseif($this->data['CertificateQuestion']['status']=='inactive'){
			foreach($this->data['select'] as $id){
				if(!empty($id)){
					$this->CertificateQuestion->id=$id;
					if($this->CertificateQuestion->saveField('status','0')){
						$all_ans = $this->CertificateAnswer->find('all',array('conditions'=>array('CertificateAnswer.certificate_question_id'=>$id)));
						if(!empty($all_ans)){
							foreach($all_ans as $ans){
								$this->CertificateAnswer->id = $ans['CertificateAnswer']['id'];
								$this->CertificateAnswer->saveField('status','0');
							}
						}
					}
					$this->Session->setFlash('Information updated successfully.');
				}
			}
		} elseif($this->data['CertificateQuestion']['status']=='del'){
			foreach($this->data['select'] as $id){
				if(!empty($id)){
					if($this->CertificateQuestion->delete($id)){
						$all_ans = $this->CertificateAnswer->find('all',array('conditions'=>array('CertificateAnswer.certificate_question_id'=>$id)));
						if(!empty($all_ans)){
							foreach($all_ans as $ans){
								$this->CertificateQuestion->delete($ans['CertificateAnswer']['id']);
							}
						}
					}
					$this->CertificateQuestion->setFlash('Information deleted successfully.');
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
		$this->redirect('/admin/certificates/questions/keyword:'.$this->data['Search']['keyword'].'/searchin:'.$this->data['Search']['searchin'].'/showtype:'.$this->data['Search']['show']);
	}


	/** 
	@function	:	admin_delete_question
	@description	:	Delete the certificate review
	@params		:	$id=id of row
	@created	:	Nov 12, 2010
	@credated by	:	Ramanpreet Pal Kaur
	**/
	function admin_delete_question($id = null) {
		//check that admin is login
		App::import('Model','CertificateQuestion');
		$this->CertificateQuestion = new CertificateQuestion;
		$this->checkSessionAdmin();
		
		if($this->CertificateQuestion->deleteAll("CertificateQuestion.id ='".$id."'"))
			$this->Session->setFlash('Information deleted successfully.');
		else
			$this->Session->setFlash('Information not deleted.','default',array('class'=>'flashError'));	
		$this->redirect('/admin/certificates/questions');
	}

	/** 
	@function:		admin_add_question 
	@description:		Add/edit certificate questions,
	@params:		id
	@Created by: 		Ramanpreet Pal Kaur
	@Modify:		NULL
	@Created Date:		12 Jan, 2010
	*/
	function admin_add_question($id=Null){
		//check that admin is login
		$this->checkSessionAdmin();
		$this->layout = 'layout_admin';
		App::import('Model','CertificateQuestion');
		$this->CertificateQuestion = new CertificateQuestion;
		if(empty($id))
			$this->set('listTitle','Add Gift Certificate Question');
		else
			$this->set('listTitle','UpdateGift Certificate Question');
		$this->set("id",$id);
		if(!empty($this->data)){
			$this->CertificateQuestion->set($this->data);
			if($this->CertificateQuestion->validates()){
				if ($this->CertificateQuestion->save($this->data)) {
					if(empty($id)){
						$this->Session->setFlash('Question added successfully.');
					} else{
						$this->Session->setFlash('Question updated successfully.');
					}
					$this->redirect(array('action' => 'questions'));
				}else {
					if(empty($id)){
						$this->Session->setFlash('Question has not been added.','default',array('class'=>'flashError'));
					} else{
						$this->Session->setFlash('Question has not been updated.','default',array('class'=>'flashError'));
					}
				}
			} else {
				$this->set('errors',$this->CertificateQuestion->validationErrors);
			}
		} else{
			if(!empty($id)){
				$this->CertificateQuestion->id = $id;
				$question_detail = $this->CertificateQuestion->find('first',array('conditions'=>array('CertificateQuestion.id'=>$id),'fields'=>array('CertificateQuestion.id','CertificateQuestion.question')));
				$this->data = $question_detail;
				
				if(!empty($this->data['CertificateQuestion'])){
					foreach($this->data['CertificateQuestion'] as $field_index => $info){
						$this->data['CertificateQuestion'][$field_index] = html_entity_decode($info);
						$this->data['CertificateQuestion'][$field_index] = str_replace('&#039;',"'",$this->data['CertificateQuestion'][$field_index]);
					}
				}
			}
		}
	}

	/**
	@function:admin_answers
	@description:listing certificates answers with related question,
	@params:NULL
	@Created by: Ramanpreet Pal
	@Modify:NULL
	@Created Date:Jan 12, 2011
	*/
	function admin_answers($que_id = null){
		//check that admin is login
		if(empty($que_id)){
			$this->Session->setFlash('Please click on some question, to see related answers.','default',array('class'=>'flashError'));
			$this->redirect('questions');
		}
		App::import('Model','CertificateAnswer');
		$this->CertificateAnswer = new CertificateAnswer;
		App::import('Model','CertificateQuestion');
		$this->CertificateQuestion = new CertificateQuestion;
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
		$criteria=' CertificateAnswer.certificate_question_id = '.$que_id;
		$value = '';	
		$show = '';
		$matchshow = '';
		$fieldname = '';
		/* SEARCHING */
		$reqData = $this->data;
		$option['All'] = "All";
		$options['CertificateAnswer.answer'] = "Answer";
		$showArr = $this->getStatus();
		$this->set('showArr',$showArr);
		$this->set('options',$options);
		if(!empty($this->data['Search']))
		{
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
			$value = trim($this->data['Search']['keyword']);
			App::import('Sanitize');
			$value1= Sanitize::escape($value);
			if($value!=="") {
				if(trim($fieldname)=='All'){
					$criteria .= " and (CertificateAnswer.answer LIKE '%".$value1."%')";
				} else {
					if(trim($fieldname)!=''){
						if(isset($value) && $value!=="") {
							$criteria .= " and ".$fieldname." LIKE '%".$value1."%'";
						}
					}
				}
			}
			if(isset($show) && $show!==""){
				if($show == 'All'){
				} else {
					$criteria .= " and ProductAnswer.status = '".$matchshow."'";
					$this->set('show',$show);
				}
			}
		}
		/** sorting and search */
 		if($this->RequestHandler->isAjax()==0)
 			$this->layout = 'layout_admin';
 		else
			$this->layout = 'ajax';
		$this->set('keyword', $value);
		$this->set('show', $show);
		$this->set('fieldname',$fieldname);
		/* ******************* page limit sction **************** */
		$sess_limit_name = $this->params['controller']."_anslimit";
		$sess_limit_value = $this->Session->read($sess_limit_name);
		if(!empty($this->data['Record']['limit'])){
		   $limit = $this->data['Record']['limit'];
		   $this->Session->write($sess_limit_name , $this->data['Record']['limit'] );
		}elseif( !empty($sess_limit_value) ){
			$limit = $sess_limit_value;
		}else{
			$limit = 25;
		}
		$this->data['Record']['limit'] = $limit;
		/* ******************* page limit sction **************** */
		$this->paginate = array(
			'limit' => $limit,
			'order' => array(
				'CertificateAnswer.id' => 'Desc'
			),
			'fields'=>array(
				'CertificateAnswer.answer',
				'CertificateAnswer.id',
				'CertificateAnswer.status',
				'CertificateAnswer.created'
			),
		);
		$question_info = $this->CertificateQuestion->find('first',array('conditions'=>array('CertificateQuestion.id'=>$que_id),'fields'=>array('CertificateQuestion.id','CertificateQuestion.question')));
		$this->set('listTitle','Manage Gift Certificate Answers');
		$this->set('answers', $this->paginate('CertificateAnswer',$criteria));
		$this->set('question_detail', $question_info);
	}

	/** 
	@function:		admin_add_answer 
	@description:		Add/edit product answers,
	@params:		id
	@Created by: 		Ramanpreet Pal Kaur
	@Modify:		NULL
	@Created Date:		3 Dec, 2010
	*/
	function admin_add_answer($ques_id=Null,$id = null){
		//check that admin is login
		$this->checkSessionAdmin();
		$this->layout = 'layout_admin';
		if(empty($id))
			$this->set('listTitle','Add Answer');
		else
			$this->set('listTitle','Update Answer');
		$this->set("id",$id);
		App::import('Model','CertificateAnswer');
		$this->CertificateAnswer = new CertificateAnswer;
		App::import('Model','CertificateQuestion');
		$this->CertificateQuestion = new CertificateQuestion;
		if(!empty($this->data)){
			$this->CertificateAnswer->set($this->data);
			if($this->CertificateAnswer->validates()){
				if ($this->CertificateAnswer->save($this->data)) {
					if(empty($id)){
						$this->Session->setFlash('Answer added successfully.');
					} else{
						$this->Session->setFlash('Answer updated successfully.');
					}
					$this->redirect('answers/'.$this->data['CertificateAnswer']['certificate_question_id']);
				}else {
					if(empty($id)){
						$this->Session->setFlash('Answer has not been added.','default',array('class'=>'flashError'));
					} else{
						$this->Session->setFlash('Answer has not been updated.','default',array('class'=>'flashError'));
					}
				}
			} else {
				$this->set('errors',$this->CertificateAnswer->validationErrors);
			}
		} else{
			$this->CertificateAnswer->id = $id;
			$this->data = $this->CertificateAnswer->find('first',array('conditions'=>array('CertificateAnswer.id'=>$id),'fields'=>array('CertificateAnswer.id','CertificateAnswer.answer')));
			
				
			if(!empty($this->data['CertificateAnswer'])){
				foreach($this->data['CertificateAnswer'] as $field_index => $info){
					$this->data['CertificateAnswer'][$field_index] = html_entity_decode($info);
					$this->data['CertificateAnswer'][$field_index] = str_replace('&#039;',"'",$this->data['CertificateAnswer'][$field_index]);
				}
			}
		}
		$this->CertificateQuestion->id = $ques_id;
		$question_detail = $this->CertificateQuestion->find('first',array('conditions'=>array('CertificateQuestion.id'=>$ques_id),'fields'=>array('CertificateQuestion.id','CertificateQuestion.question')));
		$this->data['CertificateAnswer']['certificate_question_id'] = $ques_id;
		$this->set('ques_id',$ques_id);
		$this->set('question_detail',$question_detail);
	}


	/** 
	@function	:	admin_answer_multiplAction
	@description	:	Active/Deactive/Delete multiple record
	@params		:	question id
	@created	:	Jan 12, 2011
	@credated by	:	Ramanpreet Pal Kaur
	**/
	function admin_answer_multiplAction($que_id = null){
		App::import('Model','CertificateAnswer');
		$this->CertificateAnswer = new CertificateAnswer;
		//check that admin is login
		$this->checkSessionAdmin();
		if($this->data['CertificateAnswer']['status']=='active'){
			foreach($this->data['select'] as $id){
				if(!empty($id)){
					$this->CertificateAnswer->id=$id;
					$this->CertificateAnswer->saveField('status','1');
					$this->Session->setFlash('Information updated successfully.');
				}
			}
		} elseif($this->data['CertificateAnswer']['status']=='inactive'){
			foreach($this->data['select'] as $id){
				if(!empty($id)){
					$this->CertificateAnswer->id=$id;
					$this->CertificateAnswer->saveField('status','0');
					$this->Session->setFlash('Information updated successfully.');
				}
			}
		} elseif($this->data['CertificateAnswer']['status']=='del'){
			foreach($this->data['select'] as $id){
				if(!empty($id)){
					$this->CertificateAnswer->delete($id);
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
		$this->redirect('/admin/certificates/answers/'.$que_id.'/keyword:'.$this->data['Search']['keyword'].'/searchin:'.$this->data['Search']['searchin'].'/showtype:'.$this->data['Search']['show']);
	}

	/** 
	@function	:	admin_status
	@description	:	change the status of active/deactive
	@params		:	$id=id of row, $status=status
	@Created by: 		Ramanpreet Pal Kaur
	@Modify:		NULL
	@Created Date:		03-05-2010
	**/
	
	function admin_answer_status($id=null,$status=null,$que_id = null){
		//check that admin is login
		App::import('Model','CertificateAnswer');
		$this->CertificateAnswer = new CertificateAnswer;
		$this->checkSessionAdmin();
		$this->CertificateAnswer->id = $id;
		if($status==1){
			$this->CertificateAnswer->saveField('status','0');
			$this->Session->setFlash('Information updated  successfully.');
		} else {
			$this->CertificateAnswer->saveField('status','1');
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
		$this->redirect('/admin/certificates/answers/'.$que_id.'/keyword:'.$this->data['Search']['keyword'].'/searchin:'.$this->data['Search']['searchin'].'/showtype:'.$this->data['Search']['show']);
	}

	/** 
	@function	:	admin_delete_answer
	@description	:	Delete the answer
	@params		:	$id=id of row
	@created	:	Jan 12, 2011
	@credated by	:	Ramanpreet Pal Kaur
	**/
	function admin_delete_answer($id=null,$que_id = null){
		//check that admin is login
		App::import('Model','CertificateAnswer');
		$this->CertificateAnswer = new CertificateAnswer;
		$this->checkSessionAdmin();
		if($this->CertificateAnswer->deleteAll("CertificateAnswer.id ='".$id."'"))
			$this->Session->setFlash('Information deleted successfully.');
		else
			$this->Session->setFlash('Information not deleted.','default',array('class'=>'flashError'));	
		$this->redirect('/admin/certificates/answers/'.$que_id);
	}


	
	/** 
	@function	:	admin_status
	@description	:	change the status of question active/deactive
	@params		:	$id=id of row, $status=status
	@Created by: 		Ramanpreet Pal Kaur
	@Modify:		NULL
	@Created Date:		03-05-2010
	**/
	
	function admin_question_status($id=null,$status=null){
		//check that admin is login
		$this->checkSessionAdmin();
		App::import('Model','CertificateQuestion');
		$this->CertificateQuestion = new CertificateQuestion;
		App::import('Model','CertificateAnswer');
		$this->CertificateAnswer = new CertificateAnswer;
		$this->CertificateQuestion->id = $id;
		if($status == 1){
			if($this->CertificateQuestion->saveField('status','0')){
				$all_ans = $this->CertificateAnswer->find('all',array('conditions'=>array('CertificateAnswer.certificate_question_id'=>$id)));
				if(!empty($all_ans)){
					foreach($all_ans as $ans){
						$this->CertificateAnswer->id = $ans['CertificateAnswer']['id'];
						$this->CertificateAnswer->saveField('status','0');
					}
				}
			}
			$this->Session->setFlash('Information updated  successfully.');
		} else {
			
			if($this->CertificateQuestion->saveField('status','1')){
				$all_ans = $this->CertificateAnswer->find('all',array('conditions'=>array('CertificateAnswer.certificate_question_id'=>$id)));
				if(!empty($all_ans)){
					foreach($all_ans as $ans){
						$this->CertificateAnswer->id = $ans['CertificateAnswer']['id'];
						$this->CertificateAnswer->saveField('status','1');
					}
				}
			}
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
		$this->redirect('/admin/certificates/questions/keyword:'.$this->data['Search']['keyword'].'/searchin:'.$this->data['Search']['searchin'].'/showtype:'.$this->data['Search']['show']);
	}

	/**
	@function	:	admin_total_outstandings
	@description	:	To display total outstandings for gift certificates to admin
	@params		:	NULL
	@created	:	
	@credated by	:	Ramanpreet Pal Kaur
	**/
	function admin_total_outstandings(){
		$this->set('listTitle','Total Outstanding');
 		if($this->RequestHandler->isAjax() == 0)
 			$this->layout = 'layout_admin';
 		else
			$this->layout = 'ajax';
		$total_sales_amount = 0;
		$total_credited_amount = 0;
		$total_used_amount = 0;
		
		App::import('Model', 'OrderCertificate');
		$this->OrderCertificate = new OrderCertificate();
		
		$total_sales = $this->OrderCertificate->find('all',array('conditions'=>array('OrderCertificate.payment_status'=>'Y'),'fields'=>array('SUM(OrderCertificate.total_amount) as total_amount')));
		$total_sales_amount = $total_sales[0][0]['total_amount'];
		App::import('Model','Giftbalance');
		$this->Giftbalance = new Giftbalance;
		$total_credited = $this->Giftbalance->find('all',array('fields'=>array('SUM(Giftbalance.amount) as total_balance')));
		$total_credited_amount = $total_credited[0][0]['total_balance'];
		App::import('Model','Order');
		$this->Order = new Order;
		$total_used = $this->Order->find('all',array('fields'=>array('SUM(Order.gc_amount) as total_used')));
		$total_used_amount = $total_used[0][0]['total_used'];
		$this->set('total_sales_amount',$total_sales_amount);
		$this->set('total_credited_amount',$total_credited_amount);
		$this->set('total_used_amount',$total_used_amount);
	}


	
	/**
	@function	:	admin_total_sales
	@description	:	To display total sales of gift certificates to admin
	@params		:	NULL
	@created	:	
	@credated by	:	Ramanpreet Pal Kaur
	**/
	function admin_total_sales(){
		
		$this->checkSessionAdmin();
		$this->set('listTitle','Total Sales');
 		if($this->RequestHandler->isAjax() == 0)
 			$this->layout = 'layout_admin';
 		else
			$this->layout = 'ajax';

		$total_sales_amount = array();

		$month_arr = $this->get_months();
		$this->set('month_arr',$month_arr);
		$year_arr = $this->get_years();
		$this->set('year_arr',$year_arr);
		
		if(!isset($this->data) ){ // if no year selectedshow by default the current year sale
			$this->data['Certificate']['year'] = date('Y');
		}
		if(!empty($this->data)){
			
			App::import('Model', 'OrderCertificate');
			$this->OrderCertificate = new OrderCertificate();

			$this->Certificate->set($this->data);

			if(empty($this->data['Certificate']['year'])){
				$this->data['Certificate']['year'] = date("Y");
			}
			if(!empty($this->data['Certificate']['month'])){
				if($this->data['Certificate']['month'] < 10)
					$this->data['Certificate']['month'] = '0'.$this->data['Certificate']['month'];
				$from_date = $this->data['Certificate']['year'].'-'.$this->data['Certificate']['month'].'-01';
				$to_date = $this->data['Certificate']['year'].'-'.$this->data['Certificate']['month'].'-31';

				$total_sales = $this->OrderCertificate->find('all',array('conditions'=>array('OrderCertificate.created >= "'.$from_date.'" AND OrderCertificate.created <= "'.$to_date.'" AND OrderCertificate.payment_status = "Y"'),'fields'=>array('SUM(total_amount) as total_amount')));
				$month = $this->Common->getCharmonth($this->data['Certificate']['month']);
				$total_sales_amount[$month.', '.$this->data['Certificate']['year']] = $total_sales[0][0]['total_amount'];

			} else{
				for($i=1;$i<=12;$i++) {
					
					if($i < 10)
						$i = '0'.$i;

					$from_date = $this->data['Certificate']['year'].'-'.$i.'-01';
					$to_date = $this->data['Certificate']['year'].'-'.$i.'-31';

					$month = $this->Common->getCharmonth($i);

					$total_sales = $this->OrderCertificate->find('all',array('conditions'=>array('OrderCertificate.created >= "'.$from_date.'" AND OrderCertificate.created <= "'.$to_date.'" AND OrderCertificate.payment_status = "Y"'),'fields'=>array('SUM(total_amount) as total_amount')));

					$total_sales_amount[$month.', '.$this->data['Certificate']['year']] = $total_sales[0][0]['total_amount'];

				}
			}
		}
		$this->set('total_sales',$total_sales_amount);
	}


	/** 
	@function : save_rating
	@description : to store rating of a gift certificate in certificate_ratings
	@Created by : Ramanpreet Pal Kaur
	@params : rating value
	@Modify : 
	@Created Date : 21 Jan,2010
	*/
	function save_rating($rate=null){
		$this->layout = 'ajax';
		App::import('Model', 'CertificateRating');
		$this->CertificateRating = new CertificateRating();
		$this->data['CertificateRating']['rating'] = $rate;
		$this->CertificateRating->set($this->data);

		$saveRatingId = 'saveRating_giftcertificate';

		if($this->CertificateRating->save($this->data)) {
			$this->Session->write($saveRatingId,1);
		} else {
			$this->Session->write($saveRatingId,0);
		}

		$avgRating = $this->CertificateRating->get_avg_rating();

		$rating_value = 'giftRating_value';

		$this->Session->write($rating_value,$rate);
		$this->set('full_stars',$avgRating['full_stars']);
		$this->set('half_star',$avgRating['half_star']);
		$this->set('total_rating_reviewers',$avgRating['total_rating_reviewers']);
		$this->viewPath = 'elements/gift_certificate' ;
		$this->render('save_rating');
	}


	/** 
	@function : save_giftpageVote
	@description : to store vote for product
	@Created by : Ramanpreet Pal Kaur
	@params : vote either 0 or 1
	@Modify : 
	@Created Date : 
	*/
	function save_giftpageVote($vote = null){
		App::import('Model','CertificateVote');
		$this->CertificateVote = new CertificateVote;
		$giftpageVote = 'giftpageVote';
		$this->layout = 'ajax';
		$this->data['ProductVote']['user_vote'] = $vote;
		$this->set($this->data);
		if($this->CertificateVote->save($this->data)){
			$this->Session->write($giftpageVote,1);
		} else{
			$this->Session->write($giftpageVote,0);
		}
		$this->viewPath = 'elements/gift_certificate' ;
		$this->render('certificate_vote');
	}



	/** 
	@function : email_friend
	@description : to send this page link to your friend
	@Created by : Ramanpeet Pal Kaur
	@params : NULL
	@Modify : 
	@Created Date : 21 Jan, 2010
	*/
	function email_friend(){
		$this->layout = 'front_popup'; 
		if(!empty($this->data)) {
			$this->Certificate->set($this->data);
			if($this->Certificate->validates()){
					
					/** Send email after registration **/
					$this->Email->smtpOptions = array(
						'host' => Configure::read('host'),
						'username' =>Configure::read('username'),
						'password' => Configure::read('password'),
						'timeout' => Configure::read('timeout')
					);


					
					$this->Email->from = ucwords(strtolower($this->data['Certificate']['your_name'])).'<'.$this->data['Certificate']['your_email'].'>';
					$this->Email->replyTo = ucwords(strtolower($this->data['Certificate']['your_name'])).'<'.$this->data['Certificate']['your_email'].'>';
					$this->Email->sendAs= 'html';
					
					$this->Email->subject = 'Gift certificate on choiceful.com';
					$data = '<table width="100%" cellspacing="2" cellpadding="2" border="0">';
					$data .= '<tr><td>Hello '.ucfirst($this->data['Certificate']['recipient_name']).'</td></tr>';
					$data .= '<tr><td>Visit the link given below:<br><br><a href="'.SITE_URL.'certificates/purchase_gift'.'">'.SITE_URL.'certificates/purchase_gift'.'</a></td></tr>';
					if(!empty($this->data['Certificate']['message'])){
						$data .= '<tr><td>&nbsp;</td></tr>';
						$data .= '<tr><td>'.$this->data['Certificate']['message'].'</td></tr>';
					}
					$this->set('data',$data);

					$this->Email->to = $this->data['Certificate']['recipient_email'];
					/******import emailTemplate Model and get template****/
					$this->Email->template='commanEmailTemplate';
					if($this->Email->send()) {
						$this->Session->setFlash('Mail has been sent successfully.');
						$this->data['Certificate']='';
					} else{
						$this->Session->setFlash('An error occurred while sending the email,please try again.','default',array('class'=>'flashError'));
					}
				
			} else{
				$this->set('errors',$this->Certificate->validationErrors);
			}
		}
	}


	/** 
	@function : tell_admin
	@description : if mistake tell admin
	@Created by : Ramanpreet Pal Kaur
	@params : NULL
	@Modify : 
	@Created Date : Jan 21,2011
	*/
	function tell_admin(){
		$this->layout = 'front_popup';
		$user = $this->Session->read('User');
		if(!empty($this->data)){
			$this->Certificate->set($this->data);
			if($this->Certificate->validates()){
				$this->Email->smtpOptions = array(
					'host' => Configure::read('host'),
					'username' =>Configure::read('username'),
					'password' => Configure::read('password'),
					'timeout' => Configure::read('timeout')
				);
				$this->Email->from = ucwords(strtolower($user['firstname'].' '.$user['lastname'])).'<'.$user['email'].'>';
				$this->Email->from = ucwords(strtolower($user['firstname'].' '.$user['lastname'])).'<'.$user['email'].'>';

				$this->Email->sendAs= 'html';
				$data = '<table width="100%" cellspacing="3" cellpadding ="3" border="0">';
				$data = $data.'<tr><td>You have received a suggession for purchase gift certificate page.</td></tr>';
				$data = $data.'<tr><td><br/>'.$this->data['Certificate']['reason'].'</td></tr>';
				$data = $data.'</table>';
				$this->Email->subject = 'Suggession for purchase gift certificate page.';
				$this->set('data',$data);
				$this->Email->to = Configure::read('fromEmail');
				/******import emailTemplate Model and get template****/
				$this->Email->template='commanEmailTemplate';
				if($this->Email->send()) {
					$this->Session->setFlash('Report has been sent successfully.');
					echo "<script type=\"text/javascript\">parent.jQuery.fancybox.close();
						</script>";
				} else{
					$this->Session->setFlash('We are unable tn error occurred while sending the email. Please try later.','default',array('class'=>'flashError'));
				}
			} else {
				$this->set('errors',$this->Certificate->validationErrors);
			}
		}
	}



	/** 
	@function:		admin_searchtags
	@description		to display search tags with products
	@Created by: 		Ramanpreet Pal
	@params		
	@Modify:		NULL
	@Created Date:		Feb 1, 2011
	*/
	function admin_searchtags(){
		App::import('Model','CertificateSearchtag');
		$this->CertificateSearchtag = new CertificateSearchtag;
		$this->layout='layout_admin';
		$criteria = 1;
		/** for paging and sorting we are setting values */
		
		if(empty($this->data)){
			if(isset($this->params['named']['searchin']))
				$this->data['Search']['searchin'] = $this->params['named']['searchin'];
			else
				$this->data['Search']['searchin'] = '';
	
			if(isset($this->params['named']['keyword']))
				$this->data['Search']['keyword'] = $this->params['named']['keyword'];
			else
				$this->data['Search']['keyword'] = '';
			if(isset($this->params['named']['showtype']))
				$this->data['Search']['show']=$this->params['named']['showtype'];
			else
				$this->data['Search']['show']='';
		}
		/** **************************************** **/
		$this->set('title_for_layout','Gift Certificate Search Tags');
		$value = '';
		$show = '';
		$matchshow = '';
		$fieldname = '';
		
		/** SEARCHING **/
		$reqData = $this->data;
		//$options['Product.product_name'] = "Product Name";
		$options['CertificateSearchtag.tags'] = "Tag";
		$options['User.firstname'] = "First Name";
		$options['User.lastname'] = "Last Name";
		$options['User.email'] = "Email";
		$showArr = $this->getStatus();
		$this->set('showArr',$showArr);
		$this->set('options',$options);
		if(!empty($this->data['Search'])){
			if(empty($this->data['Search']['searchin'])){
				$fieldname = 'All';
			} else {
				$fieldname = $this->data['Search']['searchin'];
			}
			
			$show = $this->data['Search']['show'];
			if($show == 'Active'){
				$matchshow = '1';
			}
			if($show == 'Deactive'){
				$matchshow = '0';
			}
			
			$value = trim($this->data['Search']['keyword']);
			// sanitze the search data
			App::import('Sanitize');
			$value1 = Sanitize::escape($value);
			if($value1 !="") {
				if(trim($fieldname)=='All'){
					$criteria .= " and (CertificateSearchtag.tags = '".$value1."' OR User.firstname LIKE '%".$value1."%' OR User.lastname LIKE '%".$value1."%' OR User.email LIKE '%".$value1."%')";
				} else {
					if(trim($fieldname)!=''){
						if(isset($value) && $value != "") {
							$criteria .= " and ".$fieldname." LIKE '%".$value1."%'";
						}
					}
				}
			}
			if(isset($show) && $show!==""){
				if($show == 'All'){
				} else {
					$criteria .= " and CertificateSearchtag.status = '".$matchshow."'";
					$this->set('show',$show);
				}
			}
		}
		$this->set('keyword', $value);
		$this->set('show', $show);
		$this->set('fieldname',$fieldname);
		$this->set('heading','Search Tags');
		
		/* ******************* page limit sction **************** */
		$sess_limit_name = $this->params['controller']."searchtags_limit";
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
			'order' => array('CertificateSearchtag.created' => 'DESC'),
			'fields'=> array(
				'User.id',
				'User.firstname',
				'User.lastname',
				'User.email',
				'CertificateSearchtag.id',
				'CertificateSearchtag.user_id',
				'CertificateSearchtag.tags',
				'CertificateSearchtag.status',
				'CertificateSearchtag.created'
			)
		);
		$this->CertificateSearchtag->expects(array('User'));
		$this->set('certificate_tags',$this->paginate('CertificateSearchtag',$criteria));
	}


	
	/** 
	@function	:	admin_searchtag_multiplAction
	@description	:	Active/Deactive/Delete multiple record
	@params		:	NULL
	@created	:	Feb 1,2011
	@credated by	:	Ramanpreet Pal Kaur
	**/
	function admin_searchtag_multiplAction(){
		App::import('Model','CertificateSearchtag');
		$this->CertificateSearchtag = new CertificateSearchtag;
		if($this->data['CertificateSearchtag']['status']=='active'){
			foreach($this->data['select'] as $id){
				if(!empty($id)){
					$this->CertificateSearchtag->id=$id;
					$this->CertificateSearchtag->saveField('status','1');
					$this->Session->setFlash('Information updated successfully.');
				}
			}
		} elseif($this->data['CertificateSearchtag']['status']=='inactive'){
			foreach($this->data['select'] as $id){
				if(!empty($id)){
					$this->CertificateSearchtag->id=$id;
					$this->CertificateSearchtag->saveField('status','0');
					$this->Session->setFlash('Information updated successfully.');	
				}
			}
		} elseif($this->data['CertificateSearchtag']['status']=='del'){
			foreach($this->data['select'] as $id){
				if(!empty($id)){
					$this->CertificateSearchtag->delete($id);
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
			$this->redirect('/admin/certificates/searchtags/keyword:'.$this->data['Search']['keyword'].'/searchin:'.$this->data['Search']['searchin'].'/showtype:'.$this->data['Search']['show']);
		else
			$this->redirect('/admin/certificates/searchtags/');
	}


	/** 
	@function	:	admin_tagstatus
	@description	:	to update status of selected search users
	@params		:	NULL
	@created	:	February 1,2011
	@credated by	:	Ramanpreet Pal Kaur
	**/
	function admin_tagstatus($id = null,$status= null) {
		App::import('Model','CertificateSearchtag');
		$this->CertificateSearchtag = new CertificateSearchtag;
		if(!empty($id)) {
			$this->data['CertificateSearchtag']['id'] = $id;
			if($status == 0){
				$this->data['CertificateSearchtag']['status'] = 1;
			} else{
				$this->data['CertificateSearchtag']['status'] = 0;
			}
			$this->CertificateSearchtag->save($this->data);
		}
		$this->redirect('/admin/certificates/searchtags');
	}

	/** 
	@function	:	admin_delete_tags
	@description	:	to delete selected search tags
	@params		:	NULL
	@created	:	February 1,2011
	@credated by	:	Ramanpreet Pal Kaur
	**/
	function admin_delete_tags($id = null) {
		App::import('Model','CertificateSearchtag');
		$this->CertificateSearchtag = new CertificateSearchtag;
		$this->CertificateSearchtag->deleteAll("CertificateSearchtag.id ='".$id."'");
		$this->Session->setFlash("Record has been deleted successfully.");
		$this->redirect(array('controller'=>'certificates','action'=>'admin_searchtags'));
	}

	/** 
	@function	:	admin_add_tags
	@description	:	to add/edit search tags
	@params		:	NULL
	@created	:	February 1,2011
	@credated by	:	Ramanpreet Pal Kaur
	**/
	function admin_add_tags($id = null) {
		$this->set('id',$id);
		$flag =1;
		App::import('Model','CertificateSearchtag');
		$this->CertificateSearchtag = new CertificateSearchtag;
		$this->layout = 'layout_admin';
		if(!empty($id)){
			$this->set('listTitle','Update Search Tag');
		} else{
			$this->set('listTitle','Add Search Tag');
		}
		if(!empty($this->data)){
			$this->CertificateSearchtag->set($this->data);
			if($this->CertificateSearchtag->validates()){
				if(empty($this->data['CertificateSearchtag']['id'])) {
					
					$this->data['CertificateSearchtag']['status'] = 1;
				}
				$this->CertificateSearchtag->set($this->data);
				
				if($this->CertificateSearchtag->save()) {
					if(empty($this->data['CertificateSearchtag']['id'])) {
						$this->Session->setFlash("Search tag has been added successfully.");
					} else{
						$this->Session->setFlash("Search tag has been updated successfully.");
					}
					$this->redirect('/admin/certificates/searchtags');
				} else{
					if(empty($this->data['CertificateSearchtag']['id'])) {
						$this->Session->setFlash("Information has not been added successfully.",'default',array('class'=>'flashError'));
					} else{
						$this->Session->setFlash("Information has not been updated successfully.",'default',array('class'=>'flashError'));
					}
				}
				
			} else{
				$errorArray = $this->CertificateSearchtag->validationErrors;
				$this->set('errors',$errorArray);
			}
		} elseif(!empty($id)) {
			$this->CertificateSearchtag->id = $id;
			$conditions = array('CertificateSearchtag.id = '.$id);
			$this->CertificateSearchtag->expects(array('User'));
			$this->data = $this->CertificateSearchtag->find('first',array('conditions'=>$conditions,'fields'=>array('CertificateSearchtag.id','CertificateSearchtag.user_id','CertificateSearchtag.tags','User.id','User.firstname','User.lastname','User.email')));
			
			if(!empty($this->data['CertificateSearchtag'])){
				foreach($this->data['CertificateSearchtag'] as $field_index => $info){
					$this->data['CertificateSearchtag'][$field_index] = html_entity_decode($info);
					$this->data['CertificateSearchtag'][$field_index] = str_replace('&#039;',"'",$this->data['CertificateSearchtag'][$field_index]);
				}
			}
			if(empty($this->data)){
				$this->redirect('/admin/certificates/searchtags');
			}
		}
	}

}
?>