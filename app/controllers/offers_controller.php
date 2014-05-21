<?php
/**  @class:		OffersController 
 @description		OffersController
 @Created by: 		kulvinder 
 @Modify:		NULL
 @Created Date:		27-Dec 2010
*/

class OffersController extends AppController{
	var $name = 'Offers';
	var $helpers = array('Form','Html','Javascript','Format','Session','Ajax','Fck','Validation','Common');
	var $components = array ('RequestHandler','Email', 'Common');

	/**
	* @Date: Dec 23 2010
	* @Method : beforeFilter
	* Created By: kulvinder singh
	* @Purpose: This function is used to validate admin user permissions
	* @Param: none
	* @Return: none 
	**/
	function beforeFilter(){
		$this->detectMobileBrowser();
		$excludeBeforeFilter = array('add');
		if (!in_array($this->params['action'],$excludeBeforeFilter)){
			// validate user session
			$this->checkSessionFrontUser();
			
		}
	}
	
	/**
	* @Date: jan 25 2011
	* @Method : thanks
	* Created By: kulvinder singh
	**/
	
	function thanks() {
		$this->layout = 'front_popup';
	}
		
	/**
	* @Date: Dec 27 2010
	* @Method : add
	* Created By: kulvinder singh
	* Modified By : RAMANPREET PAL KAUR
	* @Purpose: This function is used to create an offers for a user
	* @Param: none
	* @Return: none 
	**/
	function add( $encodedData = null) {
		
		if ($this->RequestHandler->isMobile()) {
           			$this->layout = 'ajax';
           		}else{
				$this->layout = 'front_popup';
		}
		$user = $this->Session->read('User');
		
		$offerUnserializeData  =  unserialize(base64_decode($encodedData));
		$product_id = $offerUnserializeData['p_id'];
		$seller_id  = $offerUnserializeData['s_id'];
		$this->set('product_id', $product_id);
		$this->set('offer_type', $offerUnserializeData['type']);
		$this->set('seller_id',  $offerUnserializeData['s_id']);
		$this->set('condition_id', $offerUnserializeData['c_id']);
		
		
		/******************** get product detrails info ********************************/
		App::import('Model','Product');
			$this->Product = new Product;
			$query_fields = "Product.id,Product.quick_code,Product.product_name,Product.product_rrp,
					Product.minimum_price_value,Product.minimum_price_used, Product.product_name,
					Seller.business_display_name,Seller.user_id,ProductSeller.price";
						
			$offers_detail_query  = " select $query_fields from products Product ";
			$offers_detail_query .= " left join sellers Seller ON (Product.minimum_price_seller = Seller.user_id) ";
			$offers_detail_query .= " left join product_sellers ProductSeller ON (ProductSeller.product_id = Product.id)";
			$offers_detail_query .= " where 1 AND  Product.id = '".$product_id."'  ";
			if($seller_id){
				$offers_detail_query .= " AND  ProductSeller.seller_id = $seller_id";
			}
			$offers_detailsArr = $this->Offer->query($offers_detail_query);
			if(count($offers_detailsArr) > 0){
				$product_detail = $offers_detailsArr[0];
			}else{
				$product_detail = array();
			}
			$this->set('product_detail',$product_detail);
			
		/**************************************************************/
			
		if(strtoupper($offerUnserializeData['type']) == 'M'){
			$sellerIds = $this->Common->getProductSellerIds($product_id);
			$this->set('sellerIds',$sellerIds);
		}
		$overall_Offers = '';
		if(!empty($user)){ // user logedin 
			if(!empty($this->data)){
				
				$this->data = $this->cleardata($this->data);
				$this->data = Sanitize::clean($this->data, array('encode' => false));
				
				if(empty($product_id)){
					if(!empty($this->data['Offer']['product_id']))
						$product_id = $this->data['Offer']['product_id'];
				}
				
				$this->data['Offer']['sender_id'] = $user['id'];
				
				$this->Offer->set($this->data);
				if($this->Offer->validates()){ // validate the data
					$min_price = $this->data['Offer']['minimum_price_value'];
					// validate offer price
					if($this->data['Offer']['offer_price'] > $min_price ){
						$this->Session->setFlash("Please ensure your price is below $min_price", 'default', array('class'=>'flashError') );
						
					}else{
						$this->data['Offer']['created']  = date('Y-m-d H:i:s');
						$this->data['Offer']['modified'] = date('Y-m-d H:i:s');
						//pr($this->data['Offer']); exit;
						
						if($this->data['Offer']['offer_type'] == 'M'){ // MS Offer
							#import DB
							$prodSellers = $this->Common->getProductSellerIds($product_id);
							
							if(is_array($prodSellers) ){
								foreach($prodSellers as $seller) {
									$this->data['Offer']['recipient_id'] = $seller;
									$this->data['Offer']['id'] = '';
									if($this->Offer->save($this->data)){


									}
									//pr($this->data['Offer']);
								}
								$this->sendEmailToCustomer($this->data,$prodSellers);
							}
							
							$this->redirect('/offers/thanks');
							exit;
						}else{ // single seller offer
							
							
							if(!empty($this->data['Offer']['recipient_id'])) {
								$this->data['Offer']['id'] = '';
								$this->Offer->set($this->data);
								$prodSellers = array();
								if($this->Offer->save($this->data)){
									$this->sendEmailToCustomer($this->data,$prodSellers);
									$this->redirect('/offers/thanks');
									exit;
								} else{
									$this->Session->setFlash('Offer has not been added successfully !', 'default', array('class'=>'flashError'));
								}
							} else{
								$this->Session->setFlash('Offer has not been added successfully !', 'default', array('class'=>'flashError') );
							
							}
						}
					
					}
				} else {
					$this->set('errors',$this->Offer->validationErrors);
				}
			}
		} else{
			$from_url = '/offers/add/'.$encodedData ;
			$this->Session->write('back_url',$from_url);
			if ($this->RequestHandler->isMobile()) {
				$this->redirect('/users/sign_in');
			}else{
				$this->redirect('/users/sign_in');
			}
		}
	}
	
	/**
	* @Date: July 18, 2010
	* @Method : sendEmailToCustomer
	* Created By: RAMANPREET PAL KAUR
	* Modified By : 
	* @Purpose: This function is used to send mail to customer after sending his/her offered price to seller
	* @Param: none
	* @Return: none 
	**/
	function sendEmailToCustomer($data,$prodSellers){
		if(!empty($data)){
			App::import('Model','Product');
			$this->Product = new Product;
			App::import('Model','User');
			$this->User = new User;
			App::import('Model','Seller');
			$this->Seller = new Seller;
			if(!empty($data['Offer']['product_id']))
				$pr_name = $this->Product->find('first',array('conditions'=>array('Product.id'=>$data['Offer']['product_id']),'fields'=>array('Product.product_name','Product.id')));

			if(!empty($data['Offer']['sender_id']))
				$custmr_info = $this->User->find('first',array('conditions'=>array('User.id'=>$data['Offer']['sender_id']),'fields'=>array('User.firstname','User.lastname','User.email')));


			if(!empty($prodSellers)){
				foreach($prodSellers as $pr_seller){
					$SellerInfoArr[] = $this->Seller->find('first',array('conditions'=>array('Seller.user_id'=>$pr_seller),'fields'=>array('Seller.*')));
				}
				//pr($SellerInfoArr);
				$seller_str = '';
				if(!empty($SellerInfoArr)){
					foreach($SellerInfoArr as $sellers_info){
						if(empty($seller_str))
							$seller_str = "<a href=\"".SITE_URL."sellers/".str_replace(array(' ','&amp;'),array('-','and'),$sellers_info['Seller']['business_display_name'])."/summary/".$sellers_info['Seller']['user_id']."/".$pr_name['Product']['id']."?utm_source=We've+sent+your+offer&amp;utm_medium=email\">".$sellers_info['Seller']['business_display_name']."</a>";
						else
							$seller_str = $seller_str."<br/><a href=\"".SITE_URL."sellers/".str_replace(array(' ','&amp;'),array('-','and'),$sellers_info['Seller']['business_display_name'])."/summary/".$sellers_info['Seller']['user_id']."/".$pr_name['Product']['id']."?utm_source=We've+sent+your+offer&amp;utm_medium=email\">".$sellers_info['Seller']['business_display_name']."</a>";
					}
				}
			} else {
				if(!empty($data['Offer']['recipient_id'])){
					$SellerInfo = $this->Seller->find('first',array('conditions'=>array('Seller.user_id'=>$data['Offer']['recipient_id']),'fields'=>array('Seller.*')));
					$prodSellers[] = $data['Offer']['recipient_id'];
				}
				//$seller_str = @$SellerInfo['Seller']['business_display_name'];
				$seller_str = "<a href=\"".SITE_URL."sellers/".str_replace(array(' ','&amp;'),array('-','and'),$SellerInfo['Seller']['business_display_name'])."/summary/".$SellerInfo['Seller']['user_id']."/".$pr_name['Product']['id']."?utm_source=We've+sent+your+offer&amp;utm_medium=email\">".@$SellerInfo['Seller']['business_display_name']."</a>";
			}
			
			//product name with link
			$productName = "<a href=\"".SITE_URL.str_replace(' ','-',$pr_name['Product']['product_name'])."/categories/productdetail/".$pr_name['Product']['id']."?utm_source=We've+sent+your+offer&amp;utm_medium=email\">".$pr_name['Product']['product_name']."</a>";
			
			$this->Email->smtpOptions = array(
			'host' => Configure::read('host'),
			'username' =>Configure::read('username'),
			'password' => Configure::read('password'),
			'timeout' => Configure::read('timeout')
			);
			
			
			
			$this->Email->sendAs= 'html';
			$link=Configure::read('siteUrl');
			$template = $this->Common->getEmailTemplate('11'); // 11 to mail for offer sewnt successfully
			$this->Email->from =$template['EmailTemplate']['from_email'];
			$email_data = $template['EmailTemplate']['description'];
			
			################### Email Send  Scripts #####################
			$email_data = str_replace('[CustomerFirstName]', @$custmr_info['User']['firstname'],$email_data);
				
			$email_data = str_replace('[CustomerLastName]', @$custmr_info['User']['lastname'],$email_data);
			$email_data = str_replace('[Qty]', @$data['Offer']['quantity'],$email_data);
			$email_data = str_replace('[OfferPrice]',@$data['Offer']['offer_price'],$email_data);
			//$email_data = str_replace('[ItemName]', @$pr_name['Product']['product_name'],$email_data);
			$email_data = str_replace('[ItemName]', @$productName,$email_data);
			$email_data = str_replace('[SellersDisplayName]',$seller_str,$email_data);
				
				
			$subject = $template['EmailTemplate']['subject'];
			$this->Email->subject = $subject;
			$this->Email->from = $template['EmailTemplate']['from_email'];
			$this->set('data',$email_data);
			$this->Email->to = @$custmr_info['User']['email'];
			//$this->Email->to = 'gyanprakaash@rocketmail.com';
			/******import emailTemplate Model and get template****/
			$this->Email->template='commanEmailTemplate';
			
			if($this->Email->send()){
				$prInfo['name'] = @$pr_name['Product']['product_name'];
				$prInfo['id'] = @$pr_name['Product']['id'];
				$prInfo['qty'] = @$data['Offer']['quantity'];
				$prInfo['OfferPrice'] = @$data['Offer']['offer_price'];
				$this->sendEmailToSeller($prInfo,$prodSellers);
			}
			################### Send Order Email Ends Here ###########################
		}
	}
	/**
	* @Date: July 18, 2010
	* @Method : sendEmailToSeller
	* Created By: RAMANPREET PAL KAUR ( 19 July, 2011)
	* Modified By : 
	* @Purpose: This function is used to send mail to all sellers after receiving an offer request By Seller
	* @Param: none
	* @Return: none 
	**/
	function sendEmailToSeller($prInfo,$prodSellers){
		
			App::import('Model','User');
			$this->User = new User;
			$this->User->expects(array('Seller'));
			if(!empty($prodSellers)){
				foreach($prodSellers as $prodSellers_email){
					$SellerInfoEmail = $this->User->find('first',array('conditions'=>array('Seller.user_id'=>$prodSellers_email),'fields'=>array('User.firstname','User.lastname','User.email','Seller.business_display_name')));
			
					$this->Email->sendAs= 'html';
					$link=Configure::read('siteUrl');
					$template_seller = $this->Common->getEmailTemplate('12'); // 12 to mail for offer received to sellers

					$this->Email->from =$template_seller['EmailTemplate']['from_email'];
					$emailSeller_data = $template_seller['EmailTemplate']['description'];
					
					################### Email Send  Scripts #####################
					
					
					$productName = "<a href='".SITE_URL.$this->Common->getProductUrl($prInfo['id'])."/categories/productdetail/".$prInfo['id']."?utm_source=Received+BOffer&amp;utm_medium=email'>".$prInfo['name']."</a>";
					
					$emailSeller_data = str_replace('[Qty]', $prInfo['qty'],$emailSeller_data);
					$emailSeller_data = str_replace('[OfferPrice]', CURRENCY_SYMBOL.$prInfo['OfferPrice'],$emailSeller_data);
					$emailSeller_data = str_replace('[ItemName]', $productName,$emailSeller_data);
					$emailSeller_data = str_replace('[SellersDisplayName]',@$SellerInfoEmail['Seller']['business_display_name'],$emailSeller_data);
	
			
			
					$subject_seller_email = $template_seller['EmailTemplate']['subject'];
					$this->Email->subject = $subject_seller_email;
					$this->Email->from = $template_seller['EmailTemplate']['from_email'];
					
					$this->set('data',$emailSeller_data);
					$this->Email->to = @$SellerInfoEmail['User']['email'];
					/******import emailTemplate Model and get template****/
					$this->Email->template='commanEmailTemplate';
					$this->Email->send();	
					################### Send Order Email Ends Here ###########################
				}
			}
			
		
	}
	
	/**
	* @Date: Dec 29 2010
	* @Method : edit
	* Created By: kulvinder singh
	* @Purpose: This function is used to edut an offer details 
	* @Param: none
	* @Return: none 
	**/
	function edit($offer_id = null) {
		if ($this->RequestHandler->isMobile()) {
			$this->layout = 'mobile/product';
		}else{
			$this->layout = 'front_popup';
		}
		$user = $this->Session->read('User');
		$this->set('offer_id',$offer_id);
		if(!empty($user)){ // user logedin 
			if(!empty($this->data)){
				
				$this->data = $this->cleardata($this->data);
					
				$this->Offer->set($this->data);
				if($this->Offer->validates()){ // validate the data
					$min_price = $this->data['Offer']['minimum_price_value'];
					// validate offer price
					if($this->data['Offer']['offer_price'] > $min_price ){
						$this->Session->setFlash("Please ensure your price is below $min_price ", 'default', array('class'=>'flashError') );
						
					}else{
					
					if($this->Offer->save($this->data)){ // success
						$this->Session->setFlash('Offer edited successfully !');
					} else{ // display error
						echo "<div class='flashError'>Error : Records not submitted!</div>";
					}
						if (!$this->RequestHandler->isMobile()) {
							echo "<script type=\"text/javascript\">
							parent.location.reload();
							parent.jQuery.fancybox.close();
							</script>";
						}
					}	
				} else {
					$this->set('errors',$this->Offer->validationErrors);
				}
			}else{
				$this->set('errors','');
			}
			$query_fields = "Offer.id,Offer.recipient_id,Offer.sender_id,Offer.quantity,
					Offer.offer_price,Offer.product_id,Offer.condition_id,Offer.created,
					Product.product_name,Seller.business_display_name,
					Product.product_image,Product.product_rrp,Product.minimum_price_value";
			$offers_detail_query  = " select $query_fields from offers Offer left join products Product ON (Offer.product_id = Product.id) ";
			$offers_detail_query .= " left join sellers Seller ON (Offer.recipient_id = Seller.user_id) ";
			$offers_detail_query .= " where 1 AND  Offer.id = '".$offer_id."'  ";
			$offers_detailsArr = $this->Offer->query($offers_detail_query);
			if( count($offers_detailsArr) > 0){
				$offers_details = $offers_detailsArr[0];
			}else{
				$offers_details = array();
			}
			$this->data['Offer']['quantity']    = $offers_details['Offer']['quantity'];
			$this->data['Offer']['offer_price'] = $offers_details['Offer']['offer_price'];
				
			if(!empty($this->data['Offer'])){
				foreach($this->data['Offer'] as $field_index => $info){
					$this->data['Offer'][$field_index] = html_entity_decode($info);
					$this->data['Offer'][$field_index] = str_replace('&#039;',"'",$this->data['Offer'][$field_index]);
					$this->data['Offer'][$field_index] = str_replace('\n',"",$this->data['Offer'][$field_index]);
				}
			}
			$this->set('data',$offers_details );
			$this->set('offers_details',$offers_details);
		} else{
			$from_url = '/offers/edit/'.$offer_id;
			$this->Session->write('back_url',$from_url);
			$this->redirect('/users/sign_in');
		}
	}
	
	
	/** 
	@function:		get_multiple_offers
	@Created by: 		kulvinder Singh
	@Created Date:		27-dec 2010
	*/
	function get_multiple_offers_made($user_id, $offer_status = ''){
		if ($this->RequestHandler->isMobile()) {
 			$this->layout = 'mobile/product';
		} else{
			$this->layout = 'front';
		}
		$user_id = $this->Session->read('User.id');
		
		$query_fields = "Offer.id,Offer.recipient_id,Offer.sender_id,Offer.quantity,
				Offer.offer_price,Offer.product_id,Offer.condition_id,Offer.created,
				Product.product_name,Seller.business_display_name,
				Product.product_image,Product.product_rrp ";
		
		$m_off_made_query  = " select $query_fields from offers Offer left join products Product ON (Offer.product_id = Product.id) ";
		$m_off_made_query .= " left join sellers Seller ON (Offer.recipient_id = Seller.user_id) ";
		$m_off_made_query .= " where  Offer.sender_id = $user_id ";
		if($offer_status != ''){
			$m_off_made_query .= " AND Offer.offer_status ='".$offer_status."'  ";
		}
		//$m_off_made_query .= " AND (Offer.recipient_id = Product.minimum_price_seller OR Offer.recipient_id = Product.minimum_price_used_seller)";
		$m_off_made_query .= " AND Offer.offer_type = 'M' GROUP BY Offer.product_id ";
		
		$multiple_offers_made = $this->Offer->query($m_off_made_query);
		return $multiple_offers_made;
	}
	/** 
	@function:		manage_offers
	@description		to display offers
	@Created by: 		kulvinder Singh
	@Modify:		NULL
	@Created Date:		27-dec 2010
	*/
	function updateOffer(){
		$user_id = $this->Session->read('User.id');
		$data = array();
		
		$enabledList = $this->Offer->find('list',array('conditions'=>array("Offer.sender_id = $user_id AND Offer.offer_status = '1' AND Offer.created  < DATE_SUB(DATE(NOW()), INTERVAL 2 DAY)"),'fields'=>array('id','created')));
		if(!empty($enabledList)){
			$i=0;
			foreach($enabledList as $id =>$date){
			$data['Offer'][$i]['sender_id'] =$user_id;
			$data['Offer'][$i]['id'] =$id;
			$data['Offer'][$i]['offer_status'] =2;
			$i++;
			}
			if($this->Offer->saveAll($data['Offer'])){
				
			}
		}
		return;
		
	}
	/*function manage_offers(){
		if ($this->RequestHandler->isMobile()) {
 			$this->layout = 'mobile/product';
		} else{
			$this->layout = 'front';
		}
		$user_id = $this->Session->read('User.id');
		$multiple_offers_made = $this->get_multiple_offers_made($user_id, '0');
		$this->set('multiple_offers_made',$multiple_offers_made);
		$this->set('title_for_layout','Choiceful.com: My Account - Manage Offers');
		$query_fields_made = "Offer.id,Offer.recipient_id,Offer.sender_id,Offer.quantity,Offer.offer_type,
				Offer.offer_price,Offer.product_id,Offer.condition_id,Offer.created,
				Product.product_name,Seller.business_display_name,
				Product.product_image,Product.product_rrp ";
							
		$offers_made_query  = " select $query_fields_made from offers Offer left join products Product ON (Offer.product_id = Product.id) ";
		$offers_made_query .= " left join sellers Seller ON (Offer.recipient_id = Seller.user_id) ";
		$offers_made_query .= " where Offer.sender_id = $user_id ";
		$offers_made_query .= " AND Offer.offer_type = 'S'  AND Offer.offer_status = '0' ORDER BY Offer.id DESC";
		$offers_made = $this->Offer->query($offers_made_query);
		$query_fields_recieved = "Offer.id,Offer.recipient_id,Offer.sender_id,Offer.quantity,Offer.offer_type,
				Offer.offer_price,Offer.product_id,Offer.condition_id,Offer.created,
				Product.product_name,User.firstname,
				Product.product_image,Product.product_rrp ";
				
		$offers_recieved_query = " select $query_fields_recieved from offers Offer left join products Product ON (Offer.product_id = Product.id) ";
		$offers_recieved_query .= " left join users User ON (Offer.sender_id = User.id) ";
		$offers_recieved_query .= " where 1 AND  Offer.recipient_id = $user_id  AND Offer.offer_status = '0' ORDER BY Offer.id DESC";
		$offers_recieved = $this->Offer->query($offers_recieved_query);
		$this->set('offers_made',$offers_made);
		$this->set('offers_recieved',$offers_recieved);
		if ($this->RequestHandler->isMobile()) {
			$accepted_array = $this->accepted_offers();
			$this->set('accepted_array',$accepted_array);
			$rejected_array = $this->rejected_offers();
			$this->set('rejected_array',$rejected_array);
		}
	}*/
	function manage_offers(){
		if ($this->RequestHandler->isMobile()) {
 			$this->layout = 'mobile/product';
		} else{
			if($this->RequestHandler->isAjax()==0){
				$this->layout = 'front';
			}else{
				$this->layout = 'ajax';
			}
		}
		
		//pr($this->params);
		
		$this->set('title_for_layout','Manage Offers | My Account | Choiceful.com');
		$user_id = $this->Session->read('User.id');
		$multiple_offers_made = $this->get_multiple_offers_made($user_id, '0');
		$this->set('multiple_offers_made',$multiple_offers_made);
		
		$madeOffer = isset($this->params['named']['madeOffer'])?$this->params['named']['madeOffer']:'';
		$RecievedOffer = isset($this->params['named']['recievedOffer'])?$this->params['named']['recievedOffer']:'';
		if($this->RequestHandler->isAjax()==1){
			if($madeOffer ==1 && !empty($madeOffer)){
				$offers_made = $this->manage_offers_made();
			}else if($RecievedOffer ==1 && !empty($RecievedOffer)){
				$offers_recieved = $this->manage_offers_recieved();
			}
		}else{
			$offers_made = $this->manage_offers_made();
			$offers_recieved = $this->manage_offers_recieved();
		}
						
		$this->set('offers_made',@$offers_made);
		$this->set('offers_recieved',@$offers_recieved);
		
		if ($this->RequestHandler->isMobile()) {
			$accepted_array = $this->accepted_offers();
			$this->set('accepted_array',$accepted_array);
			$rejected_array = $this->rejected_offers();
			$this->set('rejected_array',$rejected_array);
		}
		if($this->RequestHandler->isAjax()==1){
			$this->layout = 'ajax';
			if($madeOffer ==1 && !empty($madeOffer)){
				$this->render('/elements/offers/manage_offers_made');
			}else if($RecievedOffer ==1 && !empty($RecievedOffer)){
				$this->render('/elements/offers/manage_offers_recieved');
			}
		}
	}
	function manage_offers_made(){
		$user_id = $this->Session->read('User.id');
	
		$this->records_per_page =10;
		/* ******************* page limit sction **************** */
		$sess_limit_name = $this->params['controller']."_limitMAF";
		$sess_limit_value = $this->Session->read($sess_limit_name);
		
		if(!empty($this->data['RecordMAF']['limit'])){
		   $limit = $this->data['RecordMAF']['limit'];
		   $this->Session->write($sess_limit_name , $this->data['RecordMAF']['limit'] );
		} elseif( !empty($sess_limit_value) ){
			$limit = $sess_limit_value;
		} else{
			$limit = $this->records_per_page;  // set default value
		}
		$this->data['RecordMAF']['limit'] = $limit;
		
		$orderIds = '';
		$orders = array();
		
		$this->paginate = array('limit' => $limit,'order'=>array('Offer.id DESC'),'fields'=>array('Offer.id,Offer.recipient_id,Offer.sender_id,Offer.quantity,Offer.offer_type,
						Offer.offer_price,Offer.product_id,Offer.condition_id,Offer.created,
						Product.product_name,Seller.business_display_name,
						Product.product_image,Product.product_rrp'));
		
		$this->Offer->bindModel(array("belongsTo" =>array('Product' => array(
									'className' => 'Product',
									'foreignKey' => 'product_id'
									
								)
							)
						,
						"hasOne" =>array('Seller' => array(
								'className' => 'Seller',
								'foreignKey' =>false,
								'conditions'=>array('Offer.recipient_id = Seller.user_id')
								)
							)
						),false
					);
		
		
		$offers_made= $this->paginate('Offer',array("Offer.sender_id = $user_id AND Offer.offer_type = 'S'  AND Offer.offer_status = '0'"));
		$this->params['paging']['MadeOffer'] =  $this->params['paging']['Offer'];
		return $offers_made;
	}
	function manage_offers_recieved(){
		$user_id = $this->Session->read('User.id');
		$this->Offer->unbindModel(array('hasOne' => array('Seller')),false);
		$this->records_per_page =10;
		/* ******************* page limit sction **************** */
		$sess_limit_name = $this->params['controller']."_limitnewM";
		$sess_limit_value = $this->Session->read($sess_limit_name);
		
		if(!empty($this->data['RecordNewM']['limit'])){
		   $limit = $this->data['RecordNewM']['limit'];
		   $this->Session->write($sess_limit_name , $this->data['RecordNewM']['limit'] );
		} elseif( !empty($sess_limit_value) ){
			$limit = $sess_limit_value;
		} else{
			$limit = $this->records_per_page;  // set default value
		}
		$this->data['RecordNewM']['limit'] = $limit;

		$orderIds = '';
		$this->paginate = array('limit' => $limit,'order'=>array('Offer.id DESC'),'fields'=>array('Offer.id,Offer.recipient_id,Offer.sender_id,Offer.quantity,Offer.offer_type,
				Offer.offer_price,Offer.product_id,Offer.condition_id,Offer.created,
				Product.product_name,User.firstname,
				Product.product_image,Product.product_rrp'));
		
		$this->Offer->bindModel(array("belongsTo" =>array('Product' => array(
									'className' => 'Product',
									'foreignKey' => 'product_id',
									
								)
							)
						,
						"hasOne" =>array('User' => array(
								'className' => 'User',
								'foreignKey' =>false,
								'conditions'=>array('Offer.sender_id = User.id')
							)
						)
				       ),false
				);
		$offers_recieved= $this->paginate('Offer',array(" Offer.recipient_id = $user_id  AND Offer.offer_status = '0'"));
		$this->params['paging']['recievedOffer'] =  $this->params['paging']['Offer'];
		return $offers_recieved;
	}

	/** 
	@function:		accepted_offers	
	@description		to display accepted offers
	@Created by: 		kulvinder Singh
	@Modify:		NULL
	@Created Date:		29-dec 2010
	*/
	public function accepted_offers(){
		if ($this->RequestHandler->isMobile()) {
 			$this->layout = 'mobile/product';
		} else{
			if($this->RequestHandler->isAjax()==0){
				$this->layout = 'front';
			}else{
				$this->layout = 'ajax';
			}
		}
		$this->set('title_for_layout','Accepted Offers | My Account | Choiceful.com');
		$user_id = $this->Session->read('User.id');
		
		//$this->updateOffer();
		
		$madeOffer = isset($this->params['named']['madeOffer'])?$this->params['named']['madeOffer']:'';
		$RecievedOffer = isset($this->params['named']['recievedOffer'])?$this->params['named']['recievedOffer']:'';
		if($this->RequestHandler->isAjax()==1){
			if($madeOffer ==1 && !empty($madeOffer)){
				$offers_made = $this->madeOffer();
			}else if($RecievedOffer ==1 && !empty($RecievedOffer)){
				$offers_recieved = $this->recievedOffer();
			}
		}else{
			$offers_made = $this->madeOffer();
			$offers_recieved = $this->recievedOffer();
		}
		
		if ($this->RequestHandler->isMobile()) {
			$accepted_array = array('accepted_offers_made'=>$offers_made,'accepted_offers_recieved'=>$offers_recieved);
			return array_merge($accepted_array);
		}else{
			$this->set('offers_made',@$offers_made);
			$this->set('offers_recieved',@$offers_recieved);
		}
		if($this->RequestHandler->isAjax()==1){
			if($madeOffer ==1 && !empty($madeOffer)){
				$this->render('/elements/offers/accepted_offers');
			}else if($RecievedOffer ==1 && !empty($RecievedOffer)){
				$this->render('/elements/offers/recieved_offer');
			}
		}
	}
	function madeOffer(){
		$user_id = $this->Session->read('User.id');
			$orders = array();
		$this->records_per_page =10;
		/* ******************* page limit sction **************** */
		$sess_limit_name = $this->params['controller']."_limit";
		
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
		
		$orderIds = '';
		$orders = array();
		$this->paginate = array('limit' => $limit,'order'=>array('Offer.offer_status_time DESC'),'fields'=>array('Offer.id,Offer.recipient_id,Offer.sender_id,Offer.quantity,
								Offer.offer_price,Offer.product_id,Offer.condition_id,Offer.offer_status_time,Offer.created,
								Product.product_name,Seller.business_display_name,
								Product.product_image,Product.product_rrp '));
		
		$this->Offer->bindModel(array("belongsTo" =>array('Product' => array(
									'className' => 'Product',
									'foreignKey' => 'product_id'
									
								)
							)
						,
						"hasOne" =>array('Seller' => array(
								'className' => 'Seller',
								'foreignKey' =>false,
								'conditions'=>array('Offer.recipient_id = Seller.user_id')
								)
							)
						),false
					);
		
		
		$offers_made= $this->paginate('Offer',array("Offer.sender_id = $user_id AND Offer.offer_status = '1'"));
		$this->params['paging']['MadeOffer'] =  $this->params['paging']['Offer'];
		return $offers_made;
	}
	
	function recievedOffer(){
		
		$user_id = $this->Session->read('User.id');
		$this->Offer->unbindModel(array('hasOne' => array('Seller')),false);
		$this->records_per_page =10;
		/* ******************* page limit sction **************** */
		$sess_limit_name = $this->params['controller']."_limitnew";
		$sess_limit_value = $this->Session->read($sess_limit_name);
		
		if(!empty($this->data['RecordNew']['limit'])){
		   $limit = $this->data['RecordNew']['limit'];
		   $this->Session->write($sess_limit_name , $this->data['RecordNew']['limit'] );
		} elseif( !empty($sess_limit_value) ){
			$limit = $sess_limit_value;
		} else{
			$limit = $this->records_per_page;  // set default value
		}
		$this->data['RecordNew']['limit'] = $limit;

		$this->paginate = array('limit' => $limit,'order'=>array('Offer.id DESC'),'fields'=>array('Offer.id,Offer.recipient_id,Offer.sender_id,Offer.quantity,
			Offer.offer_price,Offer.product_id,Offer.condition_id,Offer.offer_status_time,Offer.created,
			Product.product_name,User.firstname,
			Product.product_image,Product.product_rrp'));
		
		$this->Offer->bindModel(array("belongsTo" =>array('Product' => array(
									'className' => 'Product',
									'foreignKey' => 'product_id',
									
								)
							)
						,
						"hasOne" =>array('User' => array(
								'className' => 'User',
								'foreignKey' =>false,
								'conditions'=>array('Offer.sender_id = User.id')
							)
						)
				       ),false
				);
		$offers_recieved= $this->paginate('Offer',array("Offer.recipient_id = $user_id AND  Offer.offer_status ='1'"));
		$this->params['paging']['recievedOffer'] =  $this->params['paging']['Offer'];
		return $offers_recieved;
	}
	
	/** 
	@function:		rejected_offers
	@description		to display rejected offers
	@Created by: 		kulvinder Singh
	@Modify:		NULL
	@Created Date:		29-dec 2010
	*/
	/*public function rejected_offers(){
		if ($this->RequestHandler->isMobile()) {
 			$this->layout = 'mobile/product';
		} else{
			$this->layout = 'front';
		}
		$user_id = $this->Session->read('User.id');
		$this->set('title_for_layout','Choiceful.com: My Account - Rejected Offers');
		$query_mad_fields = "Offer.id,Offer.recipient_id,Offer.sender_id,Offer.quantity,
				Offer.offer_price,Offer.product_id, Offer.condition_id,Offer.offer_status_time,Offer.created,
				Product.product_name,Seller.business_display_name,
				Product.product_image,Product.product_rrp ";
		$offers_made_query = " select $query_mad_fields from offers Offer left join products Product ON (Offer.product_id = Product.id) ";
		$offers_made_query .= " left join sellers Seller ON (Offer.recipient_id = Seller.user_id) ";
		$offers_made_query .= " where 1 AND  Offer.sender_id = '".$user_id."' AND Offer.offer_status ='2' ORDER BY Offer.offer_status_time DESC";
		$offers_made = $this->Offer->query($offers_made_query);
		$query_rec_fields = "Offer.id,Offer.recipient_id,Offer.sender_id,Offer.quantity,
				Offer.offer_price,Offer.product_id, Offer.condition_id,Offer.offer_status_time,Offer.created,
				Product.product_name,User.firstname,
				Product.product_image,Product.product_rrp ";
		$offers_recieved_query = " select $query_rec_fields from offers Offer left join products Product ON (Offer.product_id = Product.id) ";
		$offers_recieved_query .= " left join users User ON (Offer.sender_id = User.id) ";
		$offers_recieved_query .= " where 1 AND  Offer.recipient_id = '".$user_id."' AND  Offer.offer_status ='2'  ORDER BY Offer.id DESC ";
		$offers_recieved = $this->Offer->query($offers_recieved_query);
		if ($this->RequestHandler->isMobile()) {
			$rejected_array = array('rejected_offers_made'=>$offers_made,'rejected_offers_recieved'=>$offers_recieved);
			return array_merge($rejected_array);
		}else{
			$this->set('offers_made',$offers_made);
			$this->set('offers_recieved',$offers_recieved);
		}
	}*/
	public function rejected_offers(){
		if ($this->RequestHandler->isMobile()) {
 			$this->layout = 'mobile/product';
		} else{
			if($this->RequestHandler->isAjax()==0){
				$this->layout = 'front';
			}else{
				$this->layout = 'ajax';
			}
		}
		$this->set('title_for_layout','Rejected Offers | My Account |  Choiceful.com');
		$user_id = $this->Session->read('User.id');
		$madeOffer = isset($this->params['named']['madeOffer'])?$this->params['named']['madeOffer']:'';
		$RecievedOffer = isset($this->params['named']['recievedOffer'])?$this->params['named']['recievedOffer']:'';
		if($this->RequestHandler->isAjax()==1){
			if($madeOffer ==1 && !empty($madeOffer)){
				
		
				$offers_made = $this->rejected_offers_made();
			}else if($RecievedOffer ==1 && !empty($RecievedOffer)){
				$offers_recieved = $this->rejected_offers_recieved();;
			}
		}else{
			$offers_made = $this->rejected_offers_made();
			$offers_recieved = $this->rejected_offers_recieved();;
		}
		
		if ($this->RequestHandler->isMobile()) {
			$rejected_array = array('rejected_offers_made'=>$offers_made,'rejected_offers_recieved'=>$offers_recieved);
			return array_merge($rejected_array);
		}else{
			$this->set('offers_made',@$offers_made);
			$this->set('offers_recieved',@$offers_recieved);
		}
		if($this->RequestHandler->isAjax()==1){
			$this->layout = 'ajax';
			if($madeOffer ==1 && !empty($madeOffer)){
				$this->render('/elements/offers/rejected_offer_made');
			}else if($RecievedOffer ==1 && !empty($RecievedOffer)){
				$this->render('/elements/offers/rejected_offer_recieved');
			}
		}
	}
	function rejected_offers_made(){
		$user_id = $this->Session->read('User.id');
	
		$this->records_per_page =10;
		/* ******************* page limit sction **************** */
		$sess_limit_name = $this->params['controller']."_limitMAF";
		$sess_limit_value = $this->Session->read($sess_limit_name);
		
		if(!empty($this->data['RecordMAF']['limit'])){
		   $limit = $this->data['RecordMAF']['limit'];
		   $this->Session->write($sess_limit_name , $this->data['RecordMAF']['limit'] );
		} elseif( !empty($sess_limit_value) ){
			$limit = $sess_limit_value;
		} else{
			$limit = $this->records_per_page;  // set default value
		}
		$this->data['RecordMAF']['limit'] = $limit;
		
		$orderIds = '';
		$orders = array();
		
		$this->paginate = array('limit' => $limit,'order'=>array('Offer.offer_status_time DESC'),'fields'=>array('Offer.id,Offer.recipient_id,Offer.sender_id,Offer.quantity,
				Offer.offer_price,Offer.product_id, Offer.condition_id,Offer.offer_status_time,Offer.created,
				Product.product_name,Seller.business_display_name,
				Product.product_image,Product.product_rrp'));
		
		$this->Offer->bindModel(array("belongsTo" =>array('Product' => array(
									'className' => 'Product',
									'foreignKey' => 'product_id'
									
								)
							)
						,
						"hasOne" =>array('Seller' => array(
								'className' => 'Seller',
								'foreignKey' =>false,
								'conditions'=>array('Offer.recipient_id = Seller.user_id')
								)
							)
						),false
					);
		
		
		$offers_made= $this->paginate('Offer',array("Offer.sender_id = '".$user_id."' AND Offer.offer_status ='2'"));
		$this->params['paging']['MadeOffer'] =  $this->params['paging']['Offer'];
		return $offers_made;
	}
	function rejected_offers_recieved(){
		$user_id = $this->Session->read('User.id');
		$this->Offer->unbindModel(array('hasOne' => array('Seller')),false);
		$this->records_per_page =10;
		/* ******************* page limit sction **************** */
		$sess_limit_name = $this->params['controller']."_limitnewM";
		$sess_limit_value = $this->Session->read($sess_limit_name);
		
		if(!empty($this->data['RecordNewM']['limit'])){
		   $limit = $this->data['RecordNewM']['limit'];
		   $this->Session->write($sess_limit_name , $this->data['RecordNewM']['limit'] );
		} elseif( !empty($sess_limit_value) ){
			$limit = $sess_limit_value;
		} else{
			$limit = $this->records_per_page;  // set default value
		}
		$this->data['RecordNewM']['limit'] = $limit;

		$orderIds = '';
		$this->Offer->unbindModel(array('hasOne' => array('Seller')),false);
		$this->paginate = array('limit' => $limit,'order'=>array('Offer.id DESC'),'fields'=>array('Offer.id,Offer.recipient_id,Offer.sender_id,Offer.quantity,
				Offer.offer_price,Offer.product_id, Offer.condition_id,Offer.offer_status_time,Offer.created,
				Product.product_name,User.firstname,
				Product.product_image,Product.product_rrp'));
		
		$this->Offer->bindModel(array("belongsTo" =>array('Product' => array(
									'className' => 'Product',
									'foreignKey' => 'product_id',
									
								)
							)
						,
						"hasOne" =>array('User' => array(
								'className' => 'User',
								'foreignKey' =>false,
								'conditions'=>array('Offer.sender_id = User.id')
							)
						)
				       ),false
				);
		$offers_recieved= $this->paginate('Offer',array("Offer.recipient_id = '".$user_id."' AND  Offer.offer_status ='2'"));
		$this->params['paging']['recievedOffer'] =  $this->params['paging']['Offer'];
		return $offers_recieved;
	}



	/**
	* @Date: Dec 28 2010
	* @Method : delete_offer
	* Created By: kulvinder singh
	* @Purpose: This function is used to create an offers for a user
	* @Param: none
	* @Return: none 
	**/
	function delete_offer($offer_id = null) {
		if($this->RequestHandler->isMobile()){
			$this->layout = 'mobile/product';
		}else{
			$this->layout = 'front_popup';
		}
		$this->set('offer_id',$offer_id);
		if(!empty($this->data)){ // delete the data
			$id = $this->data['Offer']['id'];
			if(!empty($id) ){ //  delete the offer
				$this->Offer->delete($id);
				$this->Session->setFlash('Offer has been deleted successfully!');
			}else{
				$this->Session->setFlash('Offer could not be deleted.','default',array('class'=>'flashError'));
			}
			
			if(!$this->RequestHandler->isMobile()){
				echo "<script type=\"text/javascript\">
				parent.location.reload();
				parent.jQuery.fancybox.close();</script>";
			}
		}
		$query_fields = "Offer.id,Offer.quantity,Offer.condition_id,Offer.offer_price,Offer.offer_status_time,Offer.created,Product.product_name,Product.id,Seller.business_display_name";
		$offers_detail_query  = " select $query_fields from offers Offer left join products Product ON (Offer.product_id = Product.id) ";
		$offers_detail_query .= " left join sellers Seller ON (Offer.recipient_id = Seller.user_id) ";
		$offers_detail_query .= " where 1 AND  Offer.id = '".$offer_id."'  ";
		$offers_details = $this->Offer->query($offers_detail_query);
		if( count($offers_details) > 0){
			$offers_detailsArr = $offers_details[0];
		}else{
			$offers_detailsArr = array();
		}
		$this->set('offers_details',$offers_detailsArr);
	}
	
	/**
	* @Date: Dec 29 2010
	* @Method : accept_offer
	* Created By: kulvinder singh
	* Mofied By: Ramanpreet Pal Kaur(July 19, 2011)
	* @Purpose: This function is used to accept the offer
	* @Param: none
	* @Return: none 
	**/
	function update_offer_status($offer_id = null, $offer_status = null ) {
		if ($this->RequestHandler->isMobile()) {
 			$this->layout = 'mobile/product';
		} else{
			$this->layout = 'front_popup';
		}
		$this->set('offer_id',$offer_id);
		$this->set('offer_status',$offer_status);
		if(empty($offer_status) || empty($offer_id) ){
			$this->Session->setFlash('Offer  id or status is missing .','default',array('class'=>'flashError'));
		}else{
			if(!empty($this->data)){ // delete the data
				if(!empty($this->data['Offer']['id']) ){ //  accept the offer
					$this->data['Offer']['offer_status_time'] = date('Y-m-d H:i:s');
					if($this->Offer->save($this->data)){ // success
						$this->sendEmailUpdateOffer($this->data['Offer']['id']);
						if (!$this->RequestHandler->isMobile()) {
							echo "<script type=\"text/javascript\">
							parent.location.reload();
							parent.jQuery.fancybox.close();</script>";
						}else{
							$this->redirect('/offers/manage_offers');
						}
					}else{
						$this->Session->setFlash('Error in saving the records !','default',array('class'=>'flashError'));
					}
				}else{
					$this->Session->setFlash('Offer  id is missing !','default',array('class'=>'flashError'));
				}
			} 
			$query_fields = "Offer.id,Offer.quantity, Offer.condition_id, Offer.offer_price,Offer.offer_status_time,Offer.created, Product.product_name,Product.id,Seller.business_display_name";
			$offers_detail_query  = " select $query_fields from offers Offer left join products Product ON (Offer.product_id = Product.id) ";
			$offers_detail_query .= " left join sellers Seller ON (Offer.recipient_id = Seller.user_id) ";
			$offers_detail_query .= " where 1 AND  Offer.id = '".$offer_id."'  ";
			$offers_details = $this->Offer->query($offers_detail_query);
			if( count($offers_details) > 0){
				$offers_detailsArr = $offers_details[0];
			}else{
				$offers_detailsArr = array();
			}
			$this->set('offers_details',$offers_detailsArr);
		}
	}

	/**
	* @Date: July 19, 2010
	* @Method : sendEmailUpdateOffer
	* Created By: RAMANPREET PAL KAUR
	* Modified By : 
	* @Purpose: This function is used to send mail to customer after updateing the status of his offer by Seller
	* @Param: none
	* @Return: none 
	**/
	function sendEmailUpdateOffer($offer_id = null){

		App::import('Model','User');
		$this->User = new User;
		App::import('Model','Seller');
		$this->Seller = new Seller;

		$this->Offer->expects(array('Product'));
		if(!empty($offer_id))
			$data = $this->Offer->find('first',array('conditions'=>array('Offer.id'=>$offer_id),'fields'=>array('Offer.id','Offer.sender_id','Offer.quantity','Offer.offer_price','Offer.recipient_id','Offer.product_id','Product.product_name','Product.id')));
		
		if(!empty($data['Offer']['sender_id']))
			$custmr_info = $this->User->find('first',array('conditions'=>array('User.id'=>$data['Offer']['sender_id']),'fields'=>array('User.firstname','User.lastname','User.email')));
		if(!empty($data['Offer']['recipient_id']))
			$sell_info = $this->Seller->find('first',array('conditions'=>array('Seller.user_id'=>$data['Offer']['recipient_id']),'fields'=>array('Seller.business_display_name','Seller.user_id')));

		
		
		$this->Email->smtpOptions = array(
		'host' => Configure::read('host'),
		'username' =>Configure::read('username'),
		'password' => Configure::read('password'),
		'timeout' => Configure::read('timeout')
		);
		$this->Email->sendAs= 'html';
		$link=Configure::read('siteUrl');
		$template = $this->Common->getEmailTemplate('13'); // 13 to mail for update offer status
		$this->Email->from =$template['EmailTemplate']['from_email'];
		$email_data = $template['EmailTemplate']['description'];
		
		/*== Link on itemname and seller name @ oct 11 :: Begin ==*/
		$productName = "<a href='".SITE_URL.str_replace(array(' ','/','&quot;','&','andamp','and;'), array('-','','"','and','and','and'),$data['Product']['product_name'])."/categories/productdetail/".$data['Product']['id']."?utm_source=Make+Me+an+Offer+Updateed&amp;utm_medium=email'>".$data['Product']['product_name']."</a>";
		$sellerName = "<a href=\"".SITE_URL."sellers/".str_replace(array(' ','/','&quot;','&','andamp','and;'), array('-','','"','and','and','and'),$sell_info['Seller']['business_display_name'])."/summary/".$sell_info['Seller']['user_id']."/".$data['Product']['id']."?utm_source=Make+Me+an+Offer+Updateed&amp;utm_medium=email\">".$sell_info['Seller']['business_display_name']."</a>";
		/*== Link on itemname and seller name @ oct 11 :: End ==*/
		
		################### Email Send  Scripts #####################
		$email_data = str_replace('[CustomerFirstName]', @$custmr_info['User']['firstname'],$email_data);
		$email_data = str_replace('[CustomerLastName]', @$custmr_info['User']['lastname'],$email_data);
		$email_data = str_replace('[SellersDisplayName]', $sellerName,$email_data);
		$email_data = str_replace('[Qty]', @$data['Offer']['quantity'],$email_data);
		$email_data = str_replace('[OfferPrice]',CURRENCY_SYMBOL.@$data['Offer']['offer_price'] * @$data['Offer']['quantity'],$email_data);
		$email_data = str_replace('[ItemName]', $productName,$email_data);

		$subject = $template['EmailTemplate']['subject'];
		$this->Email->subject = $subject;
		$this->Email->from = $template['EmailTemplate']['from_email'];
		$this->set('data',$email_data);
		$this->Email->to = @$custmr_info['User']['email'];
		//$this->Email->to = 'gyanprakaash@hotmail.com';
		/******import emailTemplate Model and get template****/
		$this->Email->template='commanEmailTemplate';
		
		
		
		$this->Email->send();
		################### Send Order Email Ends Here ###########################
		
	}
}
?>