<?php
/**
* Orders Controller class
* PHP versions 5.1.4
* @date:	Dec 20, 2011
* @Purpose:	This controller handles all the functionalities regarding buyer's orders.
* @filesource	
* @author	Tripti Poddar
* @revision
* @copyright  	Copyright � 2011 smartData
* @version 0.0.1 
**/
App::import('Sanitize');
class OrderReturnsController extends AppController
{
	var $name =  "OrderReturns";
	var $helpers =  array('Html', 'Form','Common', 'Javascript','Session','Fck','Validation','Ajax', 'Format');
	var $components =  array('RequestHandler','Email','Common','File', 'Jpgraph');
	var $paginate =  array();
	var $permission_id = 13;  // for order module
	
 
	/**
	* @Date: March 10,2010
	* @Method : beforeFilter
	* Created By: Ramanpreet Pal Kaur
	* @Purpose: 
	* @Param: none
	* @Return: none 
	**/
	function beforeFilter(){
		//check session other than admin_login page
		$includeBeforeFilter = array('admin_index','admin_view','admin_claims','admin_reply_claim','admin_claim_details','admin_reply_claim_detail');
		if (in_array($this->params['action'],$includeBeforeFilter))
		{
			//check that admin is login
			$this->checkSessionAdmin();
			// validate admin users for this module
			$this->validateAdminModule($this->permission_id);
		}
	}
	
	
	/**
	@function:admin_index
	@description:listing page of return orders,
	@params:NULL
	@Created by: Ramanpreet Pal
	@Modify:NULL
	@Created Date:March 09,2011
	*/
	function admin_index(){
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

			$this->data['Search']['limit']= 20;
		}
		$value = '';
		$criteria ='1';
		$matchshow = '';
		$fieldname = '';
		/* SEARCHING */
		$reqData = $this->data;
		$options['UserSummary.email'] = "Buyer Email";
		$options['UserSummary.firstname'] = "Buyer Name";
		$this->set('options',$options);
		if(!empty($this->data['Search'])) {
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
					$val_arr = explode(' ',$value1);
					if(empty($val_arr[0]) || empty($val_arr[1])){
						
						if(!empty($val_arr[0]))
							$criteria .= " and (UserSummary.email LIKE '%".$value1."%' OR UserSummary.firstname LIKE '%".$val_arr[0]."%' OR UserSummary.lastname LIKE '%".$val_arr[0]."%')";
						if(!empty($val_arr[1]))
							$criteria .= " and (UserSummary.email LIKE '%".$value1."%' OR UserSummary.firstname LIKE '%".$val_arr[1]."%' OR UserSummary.lastname LIKE '%".$val_arr[1]."%')";
					} else {
						$criteria .= " and (UserSummary.email LIKE '%".$value1."%' OR UserSummary.firstname LIKE '%".$val_arr[0]."%' OR UserSummary.lastname LIKE '%".$val_arr[1]."%')";
					}
				} else {
					if(trim($fieldname)!=''){
						if(isset($value) && $value!=="") {
							if($fieldname == 'SellerSummary.firstname'){
								$val_arr = explode(' ',$value1);
								if(!empty($val_arr[0]))
									$criteria .= " and SellerSummary.firstname LIKE '%".$val_arr[0]."%'";
								if(!empty($val_arr[1]))
									$criteria .= " and SellerSummary.lastname LIKE '%".$val_arr[1]."%'";
							} else if($fieldname == 'UserSummary.firstname'){
								$val_arr = explode(' ',$value1);
								if(!empty($val_arr[0]))
									$criteria .= " and UserSummary.firstname LIKE '%".$val_arr[0]."%'";
								if(!empty($val_arr[1]))
									$criteria .= " and UserSummary.lastname LIKE '%".$val_arr[1]."%'";
							} else {

								$criteria .= " and ".$fieldname." LIKE '%".$value1."%'";
							}
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
			'order' => array(
					'OrderReturn.created' => 'DESC'
					),
			'group' => array(
				'OrderReturn.order_id'
			),
			'fields'=>array(
				'OrderReturn.id',
				'OrderReturn.user_id',
				'OrderReturn.seller_id',
				'OrderReturn.order_id',
				'OrderReturn.created',
				'OrderReturn.id',
				'Order.id',
				'Order.order_number',
				'Order.created',
				'UserSummary.id',
				'UserSummary.firstname',
				'UserSummary.lastname',
				'UserSummary.email',
				'SellerSummary.id',
				'SellerSummary.firstname',
				'SellerSummary.lastname',
				'SellerSummary.email',
			)
		);
		$this->set('listTitle','Manage Order Returns');
		$this->OrderReturn->expects(array('Order','UserSummary','SellerSummary',));
		$returns = $this->paginate('OrderReturn',$criteria);
		if(!empty($returns)){
			App::import('Model','OrderSeller');
			$this->OrderSeller = new OrderSeller();
			App::import('Model','Seller');
			$this->Seller = new Seller();
			//$this->OrderSeller->expects(array('SellerSummary'));
			$i = 0;
			foreach($returns as $return){
// 				$all_sellers = array();
// 				$sellers = $this->OrderSeller->find('all',array('conditions'=>array('OrderSeller.order_id'=>$return['OrderReturn']['order_id']),'fields'=>array('OrderSeller.id','OrderSeller.order_id','OrderSeller.seller_id','SellerSummary.id','SellerSummary.firstname','SellerSummary.lastname')));
// 				if(!empty($sellers)){
// 					foreach($sellers as $seller){
// 						$all_sellers[$seller['SellerSummary']['id']] = $seller['SellerSummary']['firstname'].' '.$seller['SellerSummary']['lastname'];
// 					}
// 				}
// 				$sellers_str = '';
// 				if(!empty($all_sellers)){
// 					foreach($all_sellers as $or_seller){
// 						if(empty($sellers_str)){
// 							$sellers_str = $or_seller;
// 						} else{
// 							$sellers_str = $sellers_str.', '.$or_seller;
// 						}
// 					}
// 				}
// 				$returns[$i]['OrderReturn']['sellers'] = $sellers_str;
// 				$i++;

				
				$all_sellers = array();
				$sellers = $this->OrderSeller->find('all',array('conditions'=>array('OrderSeller.order_id'=>$return['OrderReturn']['order_id']),'fields'=>array('OrderSeller.id','OrderSeller.order_id','OrderSeller.seller_id')));
// 				
				if(!empty($sellers)){
					foreach($sellers as $seller){
						$seller_names = $this->Seller->find('first',array('conditions'=>array('Seller.user_id'=>$seller['OrderSeller']['seller_id']),'fields'=>array('Seller.business_display_name')));
						$all_sellers[$seller['OrderSeller']['seller_id']] = $seller_names['Seller']['business_display_name'];
					}
				}
				$sellers_str = '';
				if(!empty($all_sellers)){
					foreach($all_sellers as $or_seller){
						if(empty($sellers_str)){
							$sellers_str = $or_seller;
						} else{
							$sellers_str = $sellers_str.', '.$or_seller;
						}
					}
				}
				$returns[$i]['OrderReturn']['sellers'] = $sellers_str;
				$i++;
			}
		}
		$this->set('returns', $returns);
	}


	/**
	@function:admin_view
	@description:detail of returned order
	@params:$id(returned order_id)
	@Created by: Ramanpreet Pal
	@Modify:NULL
	@Created Date:March 09,2011
	*/
	function admin_view($order_id = null){
		//check that admin is login
		$this->checkSessionAdmin();
		$this->layout = 'layout_admin';
		$fields = array(
				'OrderReturn.id',
				'OrderReturn.user_id',
				'OrderReturn.seller_id',
				'OrderReturn.order_id',
				'OrderReturn.seller_id',
				'OrderReturn.quantity',
				'OrderReturn.created',
				'OrderReturn.comments',
				'OrderReturn.id',
				'SellerSummary.id',
				'SellerSummary.firstname',
				'SellerSummary.lastname',
				'SellerSummary.email',
				'OrderItem.product_name',
				'OrderItem.quick_code',
				'OrderItem.price',
				'OrderItem.delivery_cost',
			);

		$this->set('listTitle','View details of returned order');
		App::import('Model','Order');
		$this->Order = new Order();
		App::import('Model','OrderRefund');
		$this->OrderRefund = new OrderRefund();
		$this->Order->expects(array('UserSummary'));

		$order_detail = $this->Order->find('first',array('conditions'=>array('Order.id'=>$order_id),'fields'=>array('Order.id','Order.created','Order.order_number','UserSummary.id','UserSummary.firstname','UserSummary.lastname','UserSummary.email',)));

		$this->OrderReturn->expects(array('SellerSummary','OrderItem'));
		$returns = $this->OrderReturn->find('all',array('conditions'=>array('OrderReturn.order_id'=>$order_id),'fields'=>$fields));

		$returned_orderDetails['Order'] = $order_detail['Order'];
		$returned_orderDetails['User'] = $order_detail['UserSummary'];
		$returned_orderDetails['Items'] = $returns;

		if(!empty($returned_orderDetails['Items'])){
			foreach($returned_orderDetails['Items'] as $return_seller){
				$refundseller_value = $this->OrderRefund->find('all',array('conditions'=>array('OrderRefund.order_id'=>$order_id,'OrderRefund.seller_id'=>$return_seller['OrderReturn']['seller_id']),'fields'=>array('sum(amount) as refunded_amount')));
				$refund_seller_value['Sellers'][$return_seller['OrderReturn']['seller_id']]['SellerSummary'] = $return_seller['SellerSummary'];
				unset($return_seller['SellerSummary']);
				$refund_seller_value['Sellers'][$return_seller['OrderReturn']['seller_id']]['refunded_amount'] = $refundseller_value[0][0]['refunded_amount'];
				$refund_seller_value['Sellers'][$return_seller['OrderReturn']['seller_id']]['seller_items'][] = $return_seller;
			}
		}
		$refund_value = $this->OrderRefund->find('all',array('conditions'=>array('OrderRefund.order_id'=>$order_id),'fields'=>array('sum(amount) as refunded_amount')));		
		$returned_orderDetails['Order']['total_refundedAmount'] = $refund_value[0][0]['refunded_amount'];
		$refund_seller_value['Order'] = $returned_orderDetails['Order'];
		$refund_seller_value['User'] = $returned_orderDetails['User'];
		$this->set('returneditems', $refund_seller_value);
	}

	/**
	@function:admin_claims
	@description:
	@params:
	@Created by: Ramanpreet Pal
	@Modify:NULL
	@Created Date:March 09,2011
	*/
	function admin_claims() {
		App::import('Model','Claim');
		$this->Claim = new Claim();
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
			$this->data['Search']['limit']= 20;
		}
		$value = '';
		$criteria ='1';
		$matchshow = '';
		$fieldname = '';
		/* SEARCHING */
		$reqData = $this->data;
		$options['UserSummary.firstname'] = "Customer Name";
		$options['OrderItem.seller_name'] = "Seller Display Name";
		$options['OrderItem.product_name'] = "Product Name";
		$options['Claim.order_id'] = "Order ID";
		$options['Product.qcid'] = "QCID";
		$this->set('options',$options);
		if(!empty($this->data['Search'])) {
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
					App::import('Model','Product');
					$this->Product = new Product();
					$product = $this->Product->find('first',array('conditions'=>array('Product.quick_code LIKE \'%'.$value1.'%\''),'fields'=>array('Product.id')));
					$product_id = '';
					if(!empty($product)){
						$product_id = $product['Product']['id'];
					}
					$Name = explode(' ',$value1);
					
					$fName = @$Name[0];
					$lName = @$Name[1];
					$creteria_name = '1';
					if(empty($Name[1])){
						$lName ='';
						$creteria_name = "UserSummary.firstname like '%".$fName."%'";
					} else {
						$creteria_name = "UserSummary.firstname like '%".$fName."%' AND UserSummary.lastname like '%".$lName."%'";
					}
					if(empty($product_id)){
						$criteria .= " and (".$creteria_name." OR OrderItem.seller_name LIKE '%".$value1."%'  OR OrderItem.product_name LIKE '%".$value1."%' OR Claim.order_id LIKE '%".$value1."%')";

					} else{

						$criteria .= " and ($creteria_name OR OrderItem.seller_name LIKE '%".$value1."%' OR OrderItem.product_name LIKE '%".$value1."%' OR Claim.order_id LIKE '%".$value1."%' OR OrderItem.product_id =".$product_id.")";
					}
				} else {
					if(trim($fieldname)!=''){
						$Name = explode(' ',$value1);
						$fName = @$Name[0];
						$lName = @$Name[1];
						$creteria_name = '1';
						if($fieldname == 'Product.qcid'){
							App::import('Model','Product');
							$this->Product = new Product();
							$product = $this->Product->find('first',array('conditions'=>array('Product.quick_code LIKE \'%'.$value1.'%\''),'fields'=>array('Product.id')));
							$product_id = '';
							if(!empty($product)){
								$product_id = $product['Product']['id'];
							}
							$criteria .= " and OrderItem.product_id = ".$product_id;
							$this->set("keyword",$value);
						} else if($fieldname=="UserSummary.firstname") {
							if(empty($Name[1])){
								$lName ='';
								$creteria_name = "UserSummary.firstname like '%".$fName."%'";
							} else {
								$creteria_name = "UserSummary.firstname like '%".$fName."%' AND UserSummary.lastname like '%".$lName."%'";
							}
							$criteria .= " and ".$creteria_name;
							$this->set("keyword",$value);
						} else if($fieldname=="SellerSummary.firstname") {
							if(empty($Name[1])){
								$lName ='';
								$creteria_name = "SellerSummary.firstname like '%".$fName."%'";
							} else {
								$creteria_name = "SellerSummary.firstname like '%".$fName."%' AND SellerSummary.lastname like '%".$lName."%'";
							}
							$criteria .= " and ".$creteria_name;
							$this->set("keyword",$value);
						} else if(isset($value) && $value!=="") {
							$criteria .= " and ".$fieldname." LIKE '%".$value1."%'";
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

		if(!empty($this->data['Record']['limit'])) {
		   $limit = $this->data['Record']['limit'];
		   $this->Session->write($sess_limit_name , $this->data['Record']['limit'] );
		} elseif( !empty($sess_limit_value) ){
			$limit = $sess_limit_value;
		} else{
			$limit = $this->records_per_page;
		}
		$this->data['Record']['limit'] = $limit;
		/* ******************* page limit sction **************** */
		
		$this->paginate = array(
			'limit' => $limit,
			'order' => array(
				'Claim.created DESC'
			),
			'group' => array(
				'Claim.order_id'
			),
			'fields'=>array(
				'Claim.id',
				'Claim.user_id',
				'Claim.seller_id',
				'Claim.order_id',
				'Claim.order_item_id',
				'GROUP_CONCAT(Claim.id) as totalclaimid',
				'GROUP_CONCAT(Claim.is_replied_seller) as all_is_replied_seller',
				'GROUP_CONCAT(Claim.is_replied_buyer) as all_is_replied_buyer',
				'Claim.created',
				'Order.id',
				'Order.order_number',
				'Order.created',
				'UserSummary.id',
				'UserSummary.firstname',
				'UserSummary.lastname',
				'UserSummary.email',
				'SellerSummary.id',
				'SellerSummary.firstname',
				'SellerSummary.lastname',
				'SellerSummary.email',
				'OrderItem.id',
				'OrderItem.seller_name',
				'OrderItem.product_name',
			)
		);
		$this->set('listTitle','Manage Order Claims');
		$this->Claim->expects(array('UserSummary','SellerSummary','OrderItem','Order'));
			
		$claims = $this->paginate('Claim',$criteria);
		if(!empty($claims)){
			App::import('Model','OrderSeller');
			$this->OrderSeller = new OrderSeller();
			App::import('Model','Seller');
			$this->Seller = new Seller();
			$i = 0;
			$this->OrderSeller->expects(array('SellerSummary'));
// 			foreach($claims as $claim){
// 				$all_sellers = array();
// 				$sellers = $this->OrderSeller->find('all',array('conditions'=>array('OrderSeller.order_id'=>$claim['Claim']['order_id']),'fields'=>array('OrderSeller.id','OrderSeller.order_id','OrderSeller.seller_id','SellerSummary.id','SellerSummary.firstname','SellerSummary.lastname')));
// 				
// 				if(!empty($sellers)){
// 					foreach($sellers as $seller){
// 						$all_sellers[$seller['SellerSummary']['id']] = $seller['SellerSummary']['firstname'].' '.$seller['SellerSummary']['lastname'];
// 					}
// 				}
// 				$sellers_str = '';
// 				if(!empty($all_sellers)){
// 					foreach($all_sellers as $or_seller){
// 						if(empty($sellers_str)){
// 							$sellers_str = $or_seller;
// 						} else{
// 							$sellers_str = $sellers_str.', '.$or_seller;
// 						}
// 					}
// 				}
// 				$claims[$i]['Claim']['sellers'] = $sellers_str;
// 				$i++;
// 			}
			foreach($claims as $claim){
// 				$sellers_str = 0;
// 				if(!empty($claim['OrderItem']['seller_name'])){
// 					$sellers_str = '';
// 					if(empty($sellers_str)){
// 						$sellers_str = $claim['OrderItem']['seller_name'];
// 					} else{
// 						$sellers_str = $sellers_str.', '.$claim['OrderItem']['seller_name'];
// 					}
// 				}
// 				$claims[$i]['Claim']['sellers'] = $sellers_str;
// 				$i++;
					
					
				$all_sellers = array();
				$sellers = $this->OrderSeller->find('all',array('conditions'=>array('OrderSeller.order_id'=>$claim['Claim']['order_id']),'fields'=>array('OrderSeller.id','OrderSeller.order_id','OrderSeller.seller_id','SellerSummary.id')));
// 				
				if(!empty($sellers)){
					foreach($sellers as $seller){
						$seller_names = $this->Seller->find('first',array('conditions'=>array('Seller.user_id'=>$seller['SellerSummary']['id']),'fields'=>array('Seller.business_display_name')));
						$all_sellers[$seller['SellerSummary']['id']] = $seller_names['Seller']['business_display_name'];
					}
				}
				$sellers_str = '';
				if(!empty($all_sellers)){
					foreach($all_sellers as $or_seller){
						if(empty($sellers_str)){
							$sellers_str = $or_seller;
						} else{
							$sellers_str = $sellers_str.', '.$or_seller;
						}
					}
				}
				$claims[$i]['Claim']['sellers'] = $sellers_str;
				$i++;
			}
		}
	
		$this->set('claims', $claims);
	}

	/**
	@function:admin_view
	@description:detail of returned order
	@params:$id(returned order_id)
	@Created by: Ramanpreet Pal
	@Modify:NULL
	@Created Date:March 09,2011
	*/
	function admin_claim_details($order_id = null){
		//check that admin is login
		App::import('Model','Claim');
		$this->Claim = new Claim();
		$this->checkSessionAdmin();
		$this->layout = 'layout_admin';
		$claim_reason = $this->claim_reason();
		$this->set('claim_reason', $claim_reason);
		$fields = array(
				'Claim.id',
				'Claim.user_id',
				'Claim.seller_id',
				'Claim.order_id',
				'Claim.seller_id',
				'Claim.product_id',
				'Claim.reason_id',
				'Claim.is_replied_seller',
				'Claim.is_replied_buyer',
				'Claim.order_item_id',
				'Claim.created',
				'Claim.comments',
				'SellerSummary.id',
				'SellerSummary.firstname',
				'SellerSummary.lastname',
				'SellerSummary.email',
				'OrderItem.seller_name',
				'OrderItem.product_name',
				'OrderItem.price',
				'Product.quick_code',
			);

		$this->set('listTitle','View details of claim');
		App::import('Model','Order');
		$this->Order = new Order();
		$this->Order->expects(array('UserSummary'));
		$order_detail = $this->Order->find('first',array('conditions'=>array('Order.id'=>$order_id),'fields'=>array('Order.id','Order.created','Order.order_total_cost','UserSummary.id','UserSummary.firstname','UserSummary.lastname','UserSummary.email',)));
		$this->Claim->expects(array('SellerSummary','OrderItem','Product'));

		$claims = $this->Claim->find('all',array('conditions'=>array('Claim.order_id'=>$order_id),'fields'=>$fields));
		$claim_orderDetails['Order'] = $order_detail['Order'];
		$claim_orderDetails['User'] = $order_detail['UserSummary'];
		$claim_orderDetails['Items'] = $claims;
		if(!empty($claim_orderDetails['Items'])){
			foreach($claim_orderDetails['Items'] as $claim_seller){
				$claimDetail['Sellers'][$claim_seller['Claim']['seller_id']]['SellerSummary'] = $claim_seller['SellerSummary'];

				unset($claim_seller['SellerSummary']);

				$claimDetail['Sellers'][$claim_seller['Claim']['seller_id']]['seller_items'][] = $claim_seller;
			}
		}
		$claimDetail['Order'] = $claim_orderDetails['Order'];
		$claimDetail['User'] = $claim_orderDetails['User'];
		$this->set('claimDetail', $claimDetail);
	}
	
	/** 
	@function : admin_reply_claim
	@description : to five replay for a filed claim
	@Created by : Ramanpreet Pal Kaur
	@params : order item id and users id
	@Modify : 21 March, 2011
	@Created Date : 21 March, 2011
	*/
	function admin_reply_claim($order_item_id = null,$user_id = null,$claim_id = null ){
		$this->layout='layout_admin';
		App::import('Model','ClaimReply');
		$this->ClaimReply = new ClaimReply();
			
		$claim_reason = $this->claim_reason();
		$this->set('claim_reason', $claim_reason);
		$this->set('listTitle','Reply Claim');
		if(!empty($this->data['Claim']['order_item_id'])){
			$order_item_id = $this->data['Claim']['order_item_id'];
		}
		if(!empty($this->data['Claim']['user_id'])){
			$user_id = $this->data['Claim']['user_id'];
		}
		if(!empty($claim_id) && $claim_id>0){
		$this->ClaimReply->expects(array('User'));
		$allClaimReply = $this->ClaimReply->find('all',
				array(
				'conditions'=>array(
				'ClaimReply.claims_id = "'.$claim_id.'"'),
				'fields'=>array('ClaimReply.id','ClaimReply.claims_id ','ClaimReply.user_id' , 'ClaimReply.is_replied_seller' , 'ClaimReply.is_replied_buyer' , 'ClaimReply.subject' , 'ClaimReply.message' , 'ClaimReply.message' , 'ClaimReply. created' , 'User.firstname' , 'User.lastname'),
				'order'=> array( 'ClaimReply.id DESC' ),
				));
		$this->set('allClaimReply' , $allClaimReply);
		}
		if(!empty($order_item_id) && !empty($user_id)){
			$this->set('claim_id',$claim_id);
			$this->set('order_item_id',$order_item_id);
			$this->set('user_id',$user_id);
			App::import('Model','OrderItem');
			$this->OrderItem = new OrderItem();
			App::import('Model','User');
			$this->User = new User();
			
			
			App::import('Model','Claim');
			$this->Claim = new Claim();
			$claim_info = $this->Claim->find('first',array('conditions'=>array('Claim.id'=>$claim_id),'fields'=>array('Claim.id','Claim.comments','Claim.reason_id')));
			$this->set('claim_info',$claim_info);
			$this->OrderItem->expects(array('Order','SellerSummary'));
			$order_item_details = $this->OrderItem->find('first',array('conditions'=>array('OrderItem.id'=>$order_item_id),'fields'=>array('OrderItem.id','OrderItem.order_id','OrderItem.product_name','OrderItem.seller_id','SellerSummary.id','SellerSummary.firstname','SellerSummary.lastname','SellerSummary.email')));
			$user_details = $this->User->find('first',array('conditions'=>array('User.id'=>$user_id),'fields'=>array('User.id','User.firstname','User.lastname','User.email')));
			$to_array = array('B'=>'Buyer', 'S'=>'Seller', 'BS'=>'Both');
			$this->set('to_array',$to_array);
			$this->set('order_item_details',$order_item_details);
			if(!empty($this->data)){
				$this->Claim->set($this->data);
				if($this->Claim->validates()){
					
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
					table: email_templates
					id: 29
					description: 
					*/
					$template = $this->Common->getEmailTemplate(29);
					$this->Email->from = $template['EmailTemplate']['from_email'];
					$data=$template['EmailTemplate']['description'];
					
					$data = str_replace('[ITEM_NAME]',$order_item_details['OrderItem']['product_name'],$data);
					$data = str_replace('[MESSAGE_BODY]',$this->data['Claim']['message'],$data);

					$this->Email->subject = str_replace('[CLAIM_SUBJECT]',$this->data['Claim']['subject'],$template['EmailTemplate']['subject']);
					$this->set('data',$data);
					if($this->data['Claim']['to'] == 'S' || $this->data['Claim']['to'] == 'B'){
						if($this->data['Claim']['to'] == 'S'){
							
							$this->data['Claim']['is_replied_seller'] = 1;
							$this->Email->to = $order_item_details['SellerSummary']['email'];
						} else if($this->data['Claim']['to'] == 'B'){
							$this->data['Claim']['is_replied_buyer'] = 1;
							$this->data['Claim']['is_replied_seller'] = 0;
							$this->Email->to = $user_details['User']['email'];
						}
						/******import emailTemplate Model and get template****/
						$this->Email->replyTo = 'claims@choiceful.com';
						$this->Email->template='commanEmailTemplate';
							
						if($this->Email->send()){
							$this->data['Claim']['id'] = $claim_id;
							$this->Claim->set($this->data);
							$this->Claim->save($this->data);
							$this->data['ClaimReply']['claims_id']=$claim_id;
							$this->data['ClaimReply']['subject']=$this->data['Claim']['subject'];
							$this->data['ClaimReply']['message']=$this->data['Claim']['message'];
							$this->data['ClaimReply']['user_id']=$this->data['Claim']['user_id'];
							if($this->data['Claim']['is_replied_seller']=='1'){
								$this->data['ClaimReply']['is_replied_seller']=$this->data['Claim']['is_replied_seller'];
							}else{
								$this->data['ClaimReply']['is_replied_buyer']=$this->data['Claim']['is_replied_buyer'];
							}
							$this->ClaimReply->save($this->data['ClaimReply']);
							$this->Session->setFlash('Mail has been sent successfully.');
							$this->redirect('/admin/order_returns/claim_details/'.$order_item_details['OrderItem']['order_id']);
						} else{
							$this->Session->setFlash('Mail has not sent, please try again.','default',array('class'=>'flashError'));
						}
					} else {
						$sendto  = ''; $not_sendto = '';
						for($i = 0; $i<2; $i++){
							if($i == 0){
								$to = ucfirst($order_item_details['SellerSummary']['firstname']).' '.ucfirst($order_item_details['SellerSummary']['lastname']).'<'.$order_item_details['SellerSummary']['email'].'>';
									
								$this->Email->to = $order_item_details['SellerSummary']['email'];
							} else{
								$to = ucfirst($user_details['User']['firstname']).' '.ucfirst($user_details['User']['lastname']).'<'.$user_details['User']['email'].'>';
								$this->Email->to = $user_details['User']['email'];
							}
							$this->Email->replyTo = 'claims@choiceful.com';
							$this->Email->template='commanEmailTemplate';
							if($this->Email->send()){
								$this->data['Claim']['is_replied_seller'] = 1;
								$this->data['Claim']['is_replied_buyer'] = 1;
								$this->data['Claim']['id'] = $claim_id;
								$this->Claim->set($this->data);
								$this->Claim->save();
								
								
								$this->data['ClaimReply']['claims_id']=$claim_id;
								$this->data['ClaimReply']['subject']=$this->data['Claim']['subject'];
								$this->data['ClaimReply']['message']=$this->data['Claim']['message'];
								$this->data['ClaimReply']['user_id']=$this->data['Claim']['user_id'];
								if(empty($sendto)){
									$sendto = $to;
								} else {
									$sendto = $sendto.','.$to;
								}
									
								$this->data['ClaimReply']['is_replied_seller'] = 1;
								$this->data['ClaimReply']['is_replied_buyer'] = 1;
								
								$this->ClaimReply->save($this->data['ClaimReply']);
								
								
								
								$this->Session->setFlash('Mail has been sent successfully.');
							} else{
								if(empty($not_sendto)){
									$not_sendto = $to;
								} else {
									$not_sendto = $not_sendto.','.$to;
								}
								$this->Session->setFlash('Mail has not sent, please try again.','default',array('class'=>'flashError'));
							}
						}
						if(!empty($sendto)){
							$session_msg = 'Mail has been successfully sent to : '.$sendto;
							$this->Claim->id = $claim_id;
							$this->Claim->saveField('is_replied','1');
						}
						if(!empty($not_sendto)){
							if(!empty($session_msg)){
								$session_msg = $session_msg.'<br/>';
							}
							$session_msg = $session_msg.'<div class="flashError">Mail has not been sent to :  '.$not_sendto.'<div>';
						}
						$this->Session->setFlash($session_msg);
						//echo "<script type=\"text/javascript\">setTimeout('parent.jQuery.fancybox.close()',2000);</script>";
						$this->redirect('/admin/order_returns/claim_details/'.$order_item_details['OrderItem']['order_id']);
					}
				} else{
					$this->set('errors',$this->Claim->validationErrors);
				}
			} else{
				if(!empty($order_item_id)){
					$this->data['Claim']['order_item_id'] = $order_item_id;
				}
				if(!empty($user_id)){
					$this->data['Claim']['user_id'] = $user_id;
				}
			}
		} else{

		}
	}
	
	
	/** 
	@function : admin_reply_claim_detail
	@description : to five replay for a filed claim
	@Created by : Nakul kumar
	@params : Claim detail pages
	@Modify : 12  Sept, 2011
	@Created Date : 12  Sept, 2011
	*/
	function admin_reply_claim_detail($order_item_id = null,$user_id = null,$claim_id = null,$claim_detail_id = null ){
		$this->layout='layout_admin';
		$this->set('listTitle','Reply Claim Detail');
				
		App::import('Model','ClaimReply');
		$this->ClaimReply = new ClaimReply();
		
		if(!empty($claim_id) && $claim_id>0){
		$this->ClaimReply->expects(array('User'));
		$ClaimReply = $this->ClaimReply->find('first',
				array(
				'conditions'=>array(
				'ClaimReply.id = "'.$claim_detail_id.'"'),
				'fields'=>array('ClaimReply.id','ClaimReply.claims_id ','ClaimReply.user_id' , 'ClaimReply.is_replied_seller' , 'ClaimReply.is_replied_buyer' , 'ClaimReply.subject' , 'ClaimReply.message' , 'ClaimReply.message' , 'ClaimReply. created' , 'User.firstname' , 'User.lastname'),
				'order'=> array( 'ClaimReply.id DESC' ),
				));
		$this->set('order_item_id',$order_item_id);
		$this->set('user_id',$user_id);
		$this->set('claim_id',$claim_id);
		$this->set('ClaimReply' , $ClaimReply);
		}
				
	}
	
}
?>