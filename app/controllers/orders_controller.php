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
class OrdersController extends AppController
{
	var $name =  "Orders";
	var $helpers =  array('Html', 'Form','Common', 'Javascript','Session','Validation','Ajax', 'Format');
	var $components =  array('RequestHandler','Email','Common','File', 'Jpgraph', 'Ordercom' );
	var $paginate =  array();
	var $permission_id = 6;  // for order module
	var  $ShippingStatusArr = array('Unshipped' => 'Unshipped', 'Part Shipped' => 'Part Shipped', 'Shipped' => 'Shipped','Cancelled' => 'Cancelled');
	
 
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
		$this->detectMobileBrowser();
		$includeBeforeFilter = array('admin_index','admin_search_order','admin_order_detail','admin_download_orders',
				'admin_cancelled_orders', 'admin_refunded_orders');
		
		if (in_array($this->params['action'],$includeBeforeFilter))
		{
			//check that admin is login
			$this->checkSessionAdmin();
			// validate admin users for this module
			$this->validateAdminModule($this->permission_id);
		}
	}
	
	
	
	
	/** 
	@function	:	admin_index
	@description	:	to view the listing of orders
	@params		:	NULL
	@created	:	21 Feb 2011
	@credated by	:	Kulvinder Singh
	**/
	function admin_index($page = null,$seller_id =null) {
		
		$this->layout='layout_admin';
		$this->set('title_for_layout','View Orders');
		App::import('Model','OrderView');
		$this->OrderView = new OrderView;
		
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
			if(isset($this->params['named']['start_date']))
				$this->data['Search']['start_date']=$this->params['named']['start_date'];
			else
				$this->data['Search']['start_date']='';
			if(isset($this->params['named']['end_date']))
				$this->data['Search']['end_date']=$this->params['named']['end_date'];
			else
				$this->data['Search']['end_date']='';
		}
		/** **************************************** **/
		
		
			
		$criteria = ' 1 ';
		$value = '';	
		$show = '';
		$matchshow = '';
		$fieldname = '';
		/** SEARCHING **/
		$reqData = $this->data;
	
		$options['order_number'] = "Order Number";
		$options['seller_name'] = "Seller Name";
		$options['seller_email'] = "Seller Email";
		$options['user_email'] = "User Email";
		$options['customer_name'] = "Customer Name";
		$options['user_email'] = "Customer Email";
		$options['quick_code'] = "Quick Code";
		$options['product_name'] = "Product Name";	
		
		$showArr = $this->ShippingStatusArr;
		

		
		$this->set('showArr',$showArr);
		$this->set('options',$options);
		if(!empty($this->data['Search'])){
			if(empty($this->data['Search']['searchin'])){
				$fieldname = 'All';
			} else {
				$fieldname = $this->data['Search']['searchin'];
			}
			$value = trim($this->data['Search']['keyword']);
			
			// sanitze the search data
			App::import('Sanitize');
			$value1 = Sanitize::escape($value);
			if(!empty($seller_id)){
				if($page == 'custom'){
					$fieldname = "user_email";
					$value1 = $seller_id;
					$value = $seller_id;
					$this->data['Search']['searchin'] = 'seller_email';
					$this->data['Search']['keyword'] = $seller_id;
					
					
				}
				if($page == 'seller'){
					$fieldname = "seller_id";
					$value1 = $seller_id;
					$value = $seller_id;
					$this->loadModel('User');
					$sellerData = $this->User->find('first',array('conditions'=>array('User.id'=>$seller_id),'fields'=>array('id','email')));
					if(!empty($sellerData['User'])){
						$this->data['Search']['searchin'] = 'seller_email';
						$this->data['Search']['keyword'] = $sellerData['User']['email'];
						$value = $sellerData['User']['email'];
					}
				}
			}
			
			if(($fieldname == "seller_email") ||(isset($this->params['named']['searchin']) && $this->params['named']['searchin'] == 'seller_id')){
				$fieldname = "user_email";
				$sellerData = array();
				$this->loadModel('User');
				$sellerData = $this->User->find('first',array('conditions'=>array('User.email'=>$value1),'fields'=>array('id','email')));
				if(!empty($sellerData['User'])){
					$seller_id = $sellerData['User']['id'];
					$value1 = $seller_id;
					$this->data['Search']['searchin'] = 'seller_email';
					$fieldname = "seller_id";
				}
			}
			if($value1 !="") {
				if(trim($fieldname)=='All'){
					$criteria .= " and (OrderView.order_number LIKE '%".$value1."%' OR OrderView.seller_name LIKE '%".$value1."%' OR OrderView.user_email LIKE '%".$value1."%' OR OrderView.customer_name LIKE '%".$value1."%' OR OrderView.quick_code LIKE '%".$value1."%' OR OrderView.product_name LIKE '%".$value1."%')";
				} else {
					if(trim($fieldname)!=''){
						if(isset($value) && $value!=="") {
							$criteria .= " and OrderView.".$fieldname." LIKE '%".$value1."%'";
							$this->set("keyword",$value);
						} else{
							$this->set("keyword",$value);
						}
						$this->set('fieldname',$fieldname);
					}
				}
			}
			
			if(!empty($this->data['Search']['start_date']) ){
				$order_sdate = trim($this->data['Search']['start_date']);
				$this->set('order_sdate',$order_sdate );
				if(!empty($order_sdate) ){
					$order_sdate = date("Y-m-d H:i:s ", mktime(00, 59, 59, date('m', strtotime($order_sdate) ), date('d', strtotime($order_sdate) ), date('Y', strtotime($order_sdate) )));
					$criteria .= " AND OrderView.order_date >= '".$order_sdate."'";
				}
				
			}
			
			if(!empty($this->data['Search']['end_date']) ){
				$order_edate = trim($this->data['Search']['end_date']);
				$this->set('order_edate',$order_edate );
				if(!empty($order_edate) ){
					$order_edate = date("Y-m-d H:i:s ", mktime(23, 59, 59, date('m', strtotime($order_edate) ), date('d', strtotime($order_edate) ), date('Y', strtotime($order_edate) )));
					$criteria .= " AND OrderView.order_date <= '".$order_edate."'";
				}
				
			}
		}
		
		$show = '';
		$this->set('keyword', $value);
		$this->set('show', $show);
		$this->set('fieldname',$fieldname);
		
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
		
		
		/* ******************* page limit sction **************** */
			
			
		
		$this->paginate = array(
				'limit' => $limit,
				'order' => array('OrderView.order_id' => 'desc'),
				'group' =>'order_id' ,
				'fields' => array(
					'OrderView.order_id',
					'OrderView.mobile_users',
					'OrderView.order_number',
					'OrderView.user_email',
					'OrderView.payment_method',
					'OrderView.payment_status',
					'OrderView.shipping_status',
					'OrderView.order_total_cost',
					'OrderView.quick_code',
					'OrderView.product_id',
					'OrderView.order_date',
					'OrderView.customer_name',
					'OrderView.seller_name',
					'OrderView.product_name',
					'OrderView.seller_id',
					'OrderView.deleted'
				)
			);	
					
		//$this->set('ordersData',$this->paginate('OrderView',$criteria));
		
		$criteria_mobile = " OrderView.payment_status = 'Y' AND OrderView.deleted <> '1' ";
		$criteria_mobile .= " and OrderView.mobile_users = '1' AND ".$criteria;
		$totalorder =$this->OrderView->find('all',array('conditions' => array(" OrderView.payment_status = 'Y' AND OrderView.deleted != '1' AND ".$criteria),'fields'=>array('OrderView.order_id'),'group' =>array('order_id')));
		$this->set('totalorder',count($totalorder));
		$mobileorder = $this->OrderView->find('count',array('conditions' => array($criteria_mobile)));
		$this->set('mobileorder',$mobileorder);
		
		$this->set('ordersData',$this->paginate('OrderView',$criteria));
		
	}
	
	
	/** 
	@function	:	admin_search_order
	@description	:	to provide the functionality of search orders
	@params		:	NULL
	@created	:	21 Feb 2011
	@credated by	:	Kulvinder Singh
	**/
	function admin_search_order() {
		$this->layout='layout_admin';
		$this->set('title_for_layout','Search Order');
		
		App::import('Model','OrderView');
		$this->OrderView = new OrderView;
		
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
		
		
			
		$criteria = ' 1 ';
		$value = '';	
		$show = '';
		$matchshow = '';
		$fieldname = '';
		/** SEARCHING **/
		$reqData = $this->data;
		$options['order_number'] = "Order Number";
		$options['seller_name'] = "Seller Name";
		$options['seller_email'] = "Seller Email";
		$options['user_email'] = "User Email";
		$options['customer_name'] = "Customer Name";
		$options['user_email'] = "Customer Email";
		$options['quick_code'] = "Quick Code";
		$options['product_name'] = "Product Name";	
		
		$showArr = $this->ShippingStatusArr;
		

		
		$this->set('showArr',$showArr);
		$this->set('options',$options);
		if(!empty($this->data['Search'])){
			if(empty($this->data['Search']['searchin'])){
				$fieldname = 'All';
			} else {
				$fieldname = $this->data['Search']['searchin'];
			}
			$value = trim($this->data['Search']['keyword']);
			
			
			// sanitze the search data
			App::import('Sanitize');
			$value1 = Sanitize::escape($value);
		
			if($fieldname == "seller_email"){
				$fieldname = "user_email";
			}
			if($value1 !="") {
				if(trim($fieldname)=='All'){
					$criteria .= " and (OrderView.order_number LIKE '%".$value1."%' OR OrderView.seller_name LIKE '%".$value1."%' OR OrderView.user_email LIKE '%".$value1."%' OR OrderView.customer_name LIKE '%".$value1."%' OR OrderView.quick_code LIKE '%".$value1."%' OR OrderView.product_name LIKE '%".$value1."%')";
				} else {
					if(trim($fieldname)!=''){
						if(isset($value) && $value!=="") {
							$criteria .= " and OrderView.".$fieldname." LIKE '%".$value1."%'";
							$this->set("keyword",$value);
						} else{
							$this->set("keyword",$value);
						}
						$this->set('fieldname',$fieldname);
					}
				}
			}
			
			if(!empty($this->data['Search']['start_date']) ){
				$order_sdate = trim($this->data['Search']['start_date']);
				$this->set('order_sdate',$order_sdate );
				if(!empty($order_sdate) ){
					$order_sdate = date("Y-m-d H:i:s ", mktime(00, 59, 59, date('m', strtotime($order_sdate) ), date('d', strtotime($order_sdate) ), date('Y', strtotime($order_sdate) )));
					$criteria .= " AND OrderView.order_date >= '".$order_sdate."'";
				}
				
			}
			
			if(!empty($this->data['Search']['end_date']) ){
				$order_edate = trim($this->data['Search']['end_date']);
				$this->set('order_edate',$order_edate );
				if(!empty($order_edate) ){
					$order_edate = date("Y-m-d H:i:s ", mktime(23, 59, 59, date('m', strtotime($order_edate) ), date('d', strtotime($order_edate) ), date('Y', strtotime($order_edate) )));
					$criteria .= " AND OrderView.order_date <= '".$order_edate."'";
				}
				
			}
		}
		
		$show = '';
		$this->set('keyword', $value);
		$this->set('show', $show);
		$this->set('fieldname',$fieldname);
		//$this->set('heading','Admin Users');
		
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
		/* ******************* page limit sction **************** */

		
		//  if data submitted 
		if( !empty($this->data['Search']['end_date']) || !empty($this->data['Search']['start_date']) || !empty($this->data['Search']['keyword'])  ){
			
		
			$this->paginate = array(
				'limit' => $limit,
				'order' => array('OrderView.user_email' => 'asc'),
				'group' =>'order_id' ,
				'fields' => array(
					'OrderView.order_id',
					'OrderView.order_number',
					'OrderView.user_email',
					'OrderView.payment_method',
					'OrderView.order_total_cost',
					'OrderView.quick_code',
					'OrderView.order_date',
					'OrderView.customer_name',
					'OrderView.seller_name',
					'OrderView.product_name',
					'OrderView.seller_id',
					'OrderView.deleted'
				)
			);
			$this->data['Search']['start_date'] = '';
			$this->data['Search']['end_date']   = '';
			$this->set('ordersData',$this->paginate('OrderView',$criteria));
		}else{
			$this->set('ordersData',array() );
		}
	}


	
	
	/** 
	@function	:	admin_order_detail
	@description	:	to view the details of order
	@params		:	NULL
	@created	:	24-02-2010
	@credated by	:	kulvinder 
	**/
	function admin_order_detail($orderId){
		$this->layout='layout_admin';
		
		$this->set('orderId',$orderId );
		$settings = $this->Common->get_site_settings();
		$this->set('settings', $settings);
		
		$countries = $this->Common->getcountries();
		$this->set('countries', $countries);
		
		$carriers = $this->Common->getcarriers();
		$this->set('carriers', $carriers);
		$cancelReasonArr = $this->Ordercom->getCancelReasons();
		$this->set('cancelReasonArr', $cancelReasonArr);
		
		$newUsedConditions = $this->Common->get_new_used_conditions();
		$this->set('newUsedConditions', $newUsedConditions);
		$orderData = $this->get_order_details($orderId);
		$this->set('orderData', $orderData);
		
		$this->set('title_for_layout','Order: '.$orderData['Order']['order_number']);
		
		
		$orderStatusArr = $this->Ordercom->getOrderShippingStatus($orderId);

		$this->set('shippingStatus', $orderStatusArr);
		
		$itemsCancelled = $this->Ordercom->canceled_orderitem_qty($orderId);
		$this->set('itemsCancelled', $itemsCancelled);
		$itemsDispatched = $this->Ordercom->dispatcheded_orderitem_qty($orderId);
		$this->set('itemsDispatched', $itemsDispatched);
		
		########################## overall order status calculation ####################
// 		if(is_array($orderStatusArr) ){
// 			if(in_array( 'Cancelled', $orderStatusArr) &&  (!in_array( 'Shipped', $orderStatusArr) &&  !in_array( 'Part Shipped', $orderStatusArr)) ){
// 				$OrderShippingStatus = 'Cancelled';
// 			}elseif(in_array( 'Shipped', $orderStatusArr) && ( !in_array( 'Unshipped', $orderStatusArr) && !in_array( 'Part Shipped', $orderStatusArr)) ){
// 				$OrderShippingStatus = 'Shipped';
// 			}elseif(in_array( 'Part Shipped', $orderStatusArr) ){
// 				$OrderShippingStatus = 'Part Shipped';
// 			}else{
// 				$OrderShippingStatus = 'Unshipped';
// 			}
// 		}else{
// 			$OrderShippingStatus = 'Not Available';
// 		}

		$ship_status = '';
		if(is_array($orderStatusArr) ){
			if(in_array( 'Unshipped', $orderStatusArr)) {
				
				$ship_status = 'Unshipped';
			}
			if(in_array( 'Part Shipped', $orderStatusArr)) {
				echo '2';
				$ship_status = 'Part Shipped';
			}
			if(in_array( 'Shipped', $orderStatusArr)) {
				if($ship_status == 'Unshipped' || $ship_status == 'Part Shipped')
					$ship_status = 'Part Shipped';
				else
					$ship_status = 'Shipped';
			}
			if(in_array( 'Cancelled', $orderStatusArr)) {
				
				if($ship_status == 'Unshipped' || $ship_status == 'Part Shipped')
					$ship_status = 'Part Shipped';
				else if($ship_status == 'Shipped')
					$ship_status = 'Shipped';
				else
					$ship_status = 'Cancelled';
			}
		}else{
			$ship_status = 'Not Available';
		}
		$OrderShippingStatus = $ship_status;
		$this->set('OrderShippingStatus', $OrderShippingStatus);
		########################## overall order status calculation ####################
		
		$expShippingDate = $this->Ordercom->getExpectedShippingDate($orderId);
		$this->set('expShippingDate', $expShippingDate);
		
		
		$orderCancelData = $this->Ordercom->getOrderCancelData($orderId);
		
		$this->set('orderCancelData', $orderCancelData);
		
		$orderRefundData = $this->Ordercom->getOrderRefundData($orderId);
		$this->set('orderRefundData', $orderRefundData);
		
		App::import('Model','OrderItem');
		$this->OrderItem = new OrderItem();
		
		 /*
		$this->OrderItem->expects(array('DispatchedItem'));
		$dispatchesItems = $this->OrderItem->find('all',
					 array( 'conditions'=>array('OrderItem.order_id'=>$orderId),
					'fields'=>array('OrderItem.order_id','OrderItem.seller_id',
					'OrderItem.product_name')));
		$this->set('dispatchesItems', $dispatchesItems);
		 */
		
		App::import('Model','DispatchedItem');
		$this->DispatchedItem = new DispatchedItem();
		
		$orderShipments = $this->DispatchedItem->find('all',
					 array( 'group'=>'DispatchedItem.created' , 'conditions'=>array('DispatchedItem.order_id'=>$orderId),
					 'fields'=> array('DispatchedItem.order_id','DispatchedItem.created') ));
		
		$dispatchesArray = array();
		if(count($orderShipments) > 0 ){
			$this->DispatchedItem->expects(array('OrderItem'));
			
			foreach($orderShipments as $shipment){
				$order_id = $shipment['DispatchedItem']['order_id'];
				$shipment_date = $shipment['DispatchedItem']['created'];
				$shipmentArr = $this->DispatchedItem->find('all',
				 array( 'conditions'=>array('DispatchedItem.order_id'=>$order_id, 'DispatchedItem.created'=> $shipment_date ),
				'fields'=>array('OrderItem.seller_id','OrderItem.product_name',
				'DispatchedItem.shipping_carrier','DispatchedItem.shipping_service','DispatchedItem.quantity',
				'DispatchedItem.tracking_id', 'DispatchedItem.shipping_date', 'DispatchedItem.other_carrier' )));
				 $dispatchesArray[] = $shipmentArr;
			}
		}
		//pr($dispatchesArray);
		 $this->set('dispatchments', $dispatchesArray);
		 
		App::import('Model','Feedback');
		$this->Feedback = new Feedback();
		$fBQuery = " select Feedback.feedback,Feedback.product_id,Feedback.seller_id,Feedback.created, Seller.business_display_name  from feedbacks Feedback left join sellers Seller ON (Feedback.seller_id = Seller.user_id ) where order_id = $orderId  "; 
		$feedBackData = $this->Feedback->query($fBQuery);
		
		$this->set('feedBackData', $feedBackData);
	}

	/** 
	@function	:	admin_cancel_order_item
	@description	:	to cancel the order items
	@params		:	NULL
	@created	:	21  MArch 2011
	@credated by	:	kulvinder 
	**/
	function admin_cancel_order_item(){
		if(!empty($this->data) ){
			App::import('Model','CanceledItem');
			$this->CanceledItem = & new CanceledItem();
			
			App::import('Model','ProductSeller');
			$this->ProductSeller = new ProductSeller;
			App::import('Model','OrderRefund');
			$this->OrderRefund = new OrderRefund;
			//exit;
			$this->data = Sanitize::clean($this->data);
				$quantityToCancel = "cancel_qty_".trim($this->data['Order']['Items']['item_id']);
				//$quantityOrdered = trim($this->data['Order']['Items']['total_ordered_qty']);
				//$quantityShipped = trim($this->data['Order']['Items']['total_shipped_qty']);
					
				$orderSellerId  =  trim($this->data['Order']['Items']['seller_id']);
				$orderProductId  =  trim($this->data['Order']['Items']['product_id']);
				$orderConditionId  =  trim($this->data['Order']['Items']['condition_id']);
				$orderId	=  trim($this->data['Order']['Items']['order_id']);
					
				$this->data['CanceledItem']['id'] = 0;
				$this->data['CanceledItem']['order_id'] 	= $orderId;
				$this->data['CanceledItem']['order_item_id'] 	= trim($this->data['Order']['Items']['item_id']);
				$this->data['CanceledItem']['quantity'] 	= trim($this->data['Order']['Items'][$quantityToCancel]);
				$this->data['CanceledItem']['item_price'] 	= trim($this->data['Order']['Items']['item_price']);
				$this->data['CanceledItem']['seller_id'] 	= $orderSellerId;
				$this->data['CanceledItem']['reason_id'] 	= trim($this->data['Order']['Items']['reason_id']);

				
				//Start Comment lines are on 1-Feb-2013
				$this->data['OrderRefund']['id'] = 0;
				$this->data['OrderRefund']['order_id'] = $orderId;
				$this->data['OrderRefund']['seller_id'] = $orderSellerId;
 				$this->data['OrderRefund']['user_id'] = trim($this->data['Order']['Items']['user_id']);
				$this->data['OrderRefund']['amount'] = (trim($this->data['Order']['Items'][$quantityToCancel]))*((trim($this->data['Order']['Items']['item_price']))+(trim($this->data['Order']['Items']['delivery_cost'])));
				$this->data['OrderRefund']['reason_id'] = trim($this->data['Order']['Items']['reason_id']);
				//$this->data['OrderRefund']['reason_id'] = 0;
				//End Comment lines are on 1-Feb-2013
				
				$this->CanceledItem->set($this->data['CanceledItem']);
				if($this->CanceledItem->save()){ // if save
					
					//Start Comment lines are on 1-Feb-2013
					$this->OrderRefund->set($this->data);
					$this->OrderRefund->save($this->data);
					//Start Comment lines are on 1-Feb-2013
					
					//Start For add cancle Qty in ProductSeller table
					$ord_sell_info = $this->ProductSeller->find('first',array('conditions'=>array('ProductSeller.seller_id'=>$orderSellerId,'ProductSeller.product_id'=>$orderProductId,'ProductSeller.condition_id'=>$orderConditionId),'fields'=>array('ProductSeller.id','ProductSeller.quantity')));
					if($this->data['Order']['Items'][$quantityToCancel] != ""){
						$new_qty = $ord_sell_info['ProductSeller']['quantity']+$this->data['Order']['Items'][$quantityToCancel];
					}
					else{
						$new_qty = $ord_sell_info['ProductSeller']['quantity'];
					}
					//Save new quantity
					$addQty = array();
					$addQty['ProductSeller']['id'] = $ord_sell_info['ProductSeller']['id'];
					$addQty['ProductSeller']['quantity'] = $new_qty;
					$this->ProductSeller->save($addQty['ProductSeller']);
					
					//End For add cancle Qty in ProductSeller table
					
					$this->Ordercom->processSellerOrderStatus($orderId, $orderSellerId);
					$this->Session->setFlash('Items have been cancelled successfully.');
				}else{
					$this->Session->setFlash('We are unable to cancel the  items.', 'default', array('class'=>'flashError') );
				}
				$this->redirect('/admin/orders/order_detail/'.$this->data['Order']['Items']['order_id']);
		} else{
			return false;
		}
		
		exit;
	}
	
	/** 
	@function	:	admin_cancel_order
	@description	:	to cancel the order 
	@params		:	NULL
	@created	:	21  MArch 2011
	@credated by	:	kulvinder 
	**/
	function admin_cancel_order($orderId){
		if(empty($orderId) ){
			return false;
		}else{
			App::import('Model','OrderSeller');
			$this->OrderSeller = new OrderSeller;
			
			$this->Ordercom->addBackQuantity($orderId);
			
			// add on the 03 Apr starts
			
			$this->Ordercom->sendEmailBuyerSeller($orderId);
			
			//exit;
			
			$this->Order->id= $orderId;
			
			// Start for cancelled orders and update on order field on 16-OCT-2012
			$this->Order->saveField('deleted','3'); 
			$this->OrderSeller->query( " update order_sellers SET shipping_status = 'Cancelled'  where order_id = $orderId " ) ;
			// End for cancelled orders and update on order field on 16-OCT-2012
			
			$this->Order->saveField('deleted','3'); // for cancelled orders
			//$this->OrderSeller->query( " update order_sellers SET shipping_status = 'Cancelled'  where order_id = $orderId " ) ;
			$os_id = $this->OrderSeller->find('first',array('conditions'=>array('OrderSeller.order_id'=>$orderId),'fields'=>array('OrderSeller.id','OrderSeller.shipping_status')));
			$this->data['OrderSeller']['cancel_type'] = $os_id['OrderSeller']['shipping_status'];
			$this->data['OrderSeller']['shipping_status'] = 'Cancelled';
			$this->data['OrderSeller']['id'] = $os_id['OrderSeller']['id'];
			$this->OrderSeller->set($this->data);
			
			$this->Ordercom->cancelOrderAllItems($orderId);
			
			$this->Session->setFlash('Order has been cancelled successfully.');
			$this->redirect('/admin/orders/order_detail/'.$orderId);
		}
		exit;
	}

	/** 
	@function	:	admin_save_order_adminnotes
	@description	:	to save the notes added by admin
	@params		:	NULL
	@created	:	21  MArch 2011
	@credated by	:	kulvinder 
	**/
	function admin_save_order_adminnotes(){
		if(!empty($this->data) ){
			$admin_notes_data = $this->data['Order']['admin_notes'];
			$order_id = $this->data['Order']['id'];
			$this->Order->id = $order_id;
			$this->Order->saveField('admin_notes', $admin_notes_data);
			$this->redirect('/admin/orders/order_detail/'.$order_id);
		} else{
			return false;
		}
		
		exit;
	}


	


	/** 
	@function	:	admin_download_orders
	@description	:	to download the orders
	@params		:	NULL
	@created	:	25-02-2010
	@credated by	:	kulvinder 
	**/
	function admin_download_orders(){
		$this->layout='layout_admin';
		$this->set('title_for_layout','Downloads');
		$orderid = "";
		
		$statusArr = $this->ShippingStatusArr;
		$this->set('statusArr', $statusArr);
		
		$countries = $this->Common->getcountries();
		$this->set('countries', $countries);
		$newUsedConditions = $this->Common->get_new_used_conditions();
		$this->set('newUsedConditions', $newUsedConditions);
		//pr($this->data);
		
		if(!empty($this->data)){
		$csv_File_Name = "all_orders_";
		
		$orderQuery =	 " SELECT
		        order_items.id,order_items.giftwrap,order_items.giftwrap_cost,orders.insurance,orders.insurance_amount,order_items.quick_code,	order_items.product_id, order_items.seller_id,order_items.condition_id, order_items.product_name,
			order_items.quantity,order_items.price,order_items.delivery_method,order_items.delivery_cost,
			order_items.estimated_delivery_date,
			orders.id,orders.order_number,orders.user_id,orders.created,orders.user_email,orders.shipping_user_title,
			orders.shipping_firstname,orders.shipping_lastname,orders.shipping_address1,
			orders.shipping_address2,orders.shipping_phone,	orders.shipping_postal_code,
			orders.shipping_city,orders.shipping_state,orders.shipping_country,
			orders.comments,order_sellers.shipping_status,orders.deleted
			from orders
			inner join order_sellers on (orders.id = order_sellers.order_id )
			inner join order_items on (orders.id = order_items.order_id )
			where orders.payment_status = 'Y' AND orders.user_id <> 0 ";
// 			where orders.payment_status = 'Y' AND orders.deleted = '0' AND orders.user_id <> 0 ";
		
			if(!empty($this->data['Search']['start_date']) ){
				$order_sdate = trim($this->data['Search']['start_date']);
				$this->set('order_sdate',$order_sdate );
				if(!empty($order_sdate) ){
					$order_sdate = date("Y-m-d H:i:s ", mktime(00, 59, 59, date('m', strtotime($order_sdate) ), date('d', strtotime($order_sdate) ), date('Y', strtotime($order_sdate) )));
					$orderQuery .= " AND orders.created >= '".$order_sdate."'";
				}
				
			}
			if(!empty($this->data['Search']['end_date']) ){
				$order_edate = trim($this->data['Search']['end_date']);
				$this->set('order_edate',$order_edate );
				if(!empty($order_edate) ){
					$order_edate = date("Y-m-d H:i:s ", mktime(23, 59, 59, date('m', strtotime($order_edate) ), date('d', strtotime($order_edate) ), date('Y', strtotime($order_edate) )));
					$orderQuery .= " AND orders.created <= '".$order_edate."'";
				}
				
			}
			if(!empty($this->data['Search']['shipping_status']) ){
				$ship_status  =  trim($this->data['Search']['shipping_status']);
				$orderQuery .= " AND order_sellers.shipping_status = '".$ship_status."'";
				$csv_File_Name = str_replace(' ', '_', $this->data['Search']['shipping_status']);
			}
				
			$orderQuery .= " group By order_items.id";
			
			
			$ordersDataArr = $this->Order->query($orderQuery);
			
			
			$csv_output =  "ORDER ID, DATE, ITEM QCID,SELLER REF, PRODUCT NAME, QUANTITY PURCHASED, PRODUCT PRICE (£), DELIVERY SERVICE, DELIVERY PRICE (£), GIFT WRAP , GIFT WRAP PRICE(£),INSURANCE,INSURANCE AMOUNT(£),BUYER NAME,BUYER EMAIL, BUYER PHONE, DELIVERY ADDRESS 1, DELIVERY ADDRESS 2, DELIVERY TOWN/CITY, DELIVERY COUNTY/STATE, DELIVERY POSTAL CODE/ZIP, DELIVERY COUNTRY, DELIVERY EXPECTED DATE, SHIPPED" ;
			$csv_output .= "\n";
			
			if(!empty($ordersDataArr) && count($ordersDataArr) > 0 ){  // if orders data found
				foreach($ordersDataArr as $value){
					if($value['orders']['deleted'] == 1){
						$ship_status_a = 'Deleted';
					} else if($value['orders']['deleted'] == 2){
						$ship_status_a = 'Fraudulent';
					} else {
						$ship_status_a = $value['order_sellers']['shipping_status'];
					}
					if($value['order_items']['delivery_method'] == 'E'){
						$delivery_service = "Express";
					} else{
						$delivery_service = "Standard";
					}
					$psellerData 	= $this->Common->getProductSellerData( $value['order_items']['product_id'] , $value['order_items']['seller_id'],  $value['order_items']['condition_id'] );
					$userData 	= $this->Common->get_user_billing_info($value['orders']['user_id']);
					if(count($psellerData) > 0 && !empty($userData) > 0 ):
					//pr($userData);
						if(!empty($value['orders']['insurance']))
							$insurance = 'Y';
						else
							$insurance = 'N';
						if(!empty($value['order_items']['giftwrap']))
							$giftwrap = 'Y';
						else
							$giftwrap = 'N';


						$country = $countries[$value['orders']['shipping_country']];
						$expected_delivery_date = $value['order_items']['estimated_delivery_date'];
						//Start Check for multiple insurance_amount for a order
						if($value['orders']['id']!=$orderid){
						$csv_output .="".str_replace(",",' || ',
						$value['orders']['order_number']).",".str_replace(",",' || ',
						$value['orders']['created']).",".str_replace(",",' || ',
						$value['order_items']['quick_code']).",".str_replace(",",' || ',
						$psellerData['ProductSeller']['reference_code']).",".str_replace(",",' || ',
						addslashes($value['order_items']['product_name'])).",".str_replace(",",' || ',
						$value['order_items']['quantity']).",".str_replace(",",' || ',
						$value['order_items']['price']).",".str_replace(",",' || ',
						$delivery_service).",".str_replace(",",' || ',
						$value['order_items']['delivery_cost']).",".str_replace(",",' || ',

						$giftwrap).",".str_replace(",",' || ',
						$value['order_items']['giftwrap_cost']).",".str_replace(",",' || ',
						$insurance).",".str_replace(",",' || ',
						$value['orders']['insurance_amount']).",".str_replace(",",' || ',

						$userData['User']['firstname'].' '.$userData['User']['lastname']).",".str_replace(",",' || ',
						$value['orders']['user_email']).",".str_replace(",",' || ',
						$userData['Address']['add_phone']).",".str_replace(",",' || ',
						$value['orders']['shipping_address1']).",".str_replace(",",' || ',
						$value['orders']['shipping_address2']).",".str_replace(",",' || ',
						$value['orders']['shipping_city']).",".str_replace(",",' || ',
						$value['orders']['shipping_state']).",".str_replace(",",' || ',
						$value['orders']['shipping_postal_code']).",".str_replace(",",' || ',
						$country).",".str_replace(",",' || ',
						$expected_delivery_date).",".str_replace(",",' || ',
						$ship_status_a).",\n";
						}else{
						$csv_output .="".str_replace(",",' || ',
						$value['orders']['order_number']).",".str_replace(",",' || ',
						$value['orders']['created']).",".str_replace(",",' || ',
						$value['order_items']['quick_code']).",".str_replace(",",' || ',
						$psellerData['ProductSeller']['reference_code']).",".str_replace(",",' || ',
						addslashes($value['order_items']['product_name'])).",".str_replace(",",' || ',
						$value['order_items']['quantity']).",".str_replace(",",' || ',
						$value['order_items']['price']).",".str_replace(",",' || ',
						$delivery_service).",".str_replace(",",' || ',
						$value['order_items']['delivery_cost']).",".str_replace(",",' || ',
						
						$giftwrap).",".str_replace(",",' || ',
						$value['order_items']['giftwrap_cost']).",".str_replace(",",' || ',
						$insurance).",".str_replace(",",' || ',
						'').",".str_replace(",",' || ',

						$userData['User']['firstname'].' '.$userData['User']['lastname']).",".str_replace(",",' || ',
						$value['orders']['user_email']).",".str_replace(",",' || ',
						$userData['Address']['add_phone']).",".str_replace(",",' || ',
						$value['orders']['shipping_address1']).",".str_replace(",",' || ',
						$value['orders']['shipping_address2']).",".str_replace(",",' || ',
						$value['orders']['shipping_city']).",".str_replace(",",' || ',
						$value['orders']['shipping_state']).",".str_replace(",",' || ',
						$value['orders']['shipping_postal_code']).",".str_replace(",",' || ',
						$country).",".str_replace(",",' || ',
						$expected_delivery_date).",".str_replace(",",' || ',
						$ship_status_a).",\n";
						}
						//End Check for multiple insurance_amount for a order
					endif;
					unset($userData);
					$orderid = $value['orders']['id'];
					
				}
			
				$csv_File_Name = strtolower($csv_File_Name);
				$filePath = $csv_File_Name.date("Ymd").".csv";
				header("Content-type: application/vnd.ms-excel; charset=utf-8");
				header("Content-Disposition: attachment; filename=".$filePath."");
				header("Pragma: no-cache");
				header("Expires: 0");
				print $csv_output;
				exit;
			} else{
				$this->Session->setFlash('No order data available.', 'default', array('class'=>'flashError'));
			}
			
			$this->data['Search']['start_date'] = '';
			$this->data['Search']['end_date']   = '';
		} else{
			
		}

	}
	
		
	/** 
	@function	:	admin_SearchDeleteAction
	@description	:	Fraud/Delete multiple record
	@params		:	NULL
	@created	:	Oct 14,2010
	@credated by	:	kulvinder 
	**/
	
	function admin_SearchDeleteAction(){
		//pr($this->data); exit;
		if(!empty($this->data) ){
			/*if($this->data['Order']['status']=='cancel'){
				App::import('Model','OrderSeller');
				$this->OrderSeller = new OrderSeller;
				foreach($this->data['select'] as $orderId){
					if(!empty($orderId)){ // if order id is not empty
						$this->Order->id= $orderId;
						$this->Order->saveField('deleted','3'); // for cancelled orders
						$this->OrderSeller->query( " update order_sellers SET shipping_status = 'Cancelled'  where order_id = $orderId " ) ;
						$this->Ordercom->cancelOrderAllItems($orderId);
						$this->Session->setFlash('Records has been cancelled successfully.');
					}
				}
			} else */
			if($this->data['Order']['status']=='fraud'){
				foreach($this->data['select'] as $orderId){
					if(!empty($orderId)){
						$this->Order->id= $orderId;
						$this->Order->saveField('deleted','2'); // for fraud orders
						$this->admin_sendFraudMail($orderId);
						$this->Session->setFlash('Order has been marked as fraudent successfully.');
					}
				}
			} else if($this->data['Order']['status']=='del'){
				foreach($this->data['select'] as $orderId){
					if(!empty($orderId)){
						$this->Order->id= $orderId;
						$this->Order->saveField('deleted','1'); // for deleted orders
						$this->Session->setFlash('Records have been deleted successfully.');
					}
				}
			}
		}
		
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
		
		if(!empty($this->data['Search']['keyword']) && !empty($this->data['Search']['searchin']) && !empty($this->data['Search']['show']))
			$this->redirect('/admin/orders/search_order/keyword:'.$this->data['Search']['keyword'].'/searchin:'.$this->data['Search']['searchin'].'/showtype:'.$this->data['Search']['show']);
		else
			$this->redirect('/admin/orders/search_order/');
	}
	
	/** 
	@function	:	admin_cancelDeleteAction
	@description	:	Fraud/Delete multiple record
	@params		:	NULL
	@created	:	Oct 14,2010
	@credated by	:	kulvinder 
	**/
	function admin_cancelDeleteAction(){
		//pr($this->data); exit;
		if(!empty($this->data) ){
			/*if($this->data['Order']['status']=='cancel'){
				App::import('Model','OrderSeller');
				$this->OrderSeller = new OrderSeller;
				foreach($this->data['select'] as $orderId){
					if(!empty($orderId)){ // if order id is not empty
						$this->Order->id= $orderId;
						$this->Order->saveField('deleted','3'); // for cancelled orders
						$this->OrderSeller->query( " update order_sellers SET shipping_status = 'Cancelled'  where order_id = $orderId " ) ;
						$this->Ordercom->cancelOrderAllItems($orderId);
						$this->Session->setFlash('Records has been cancelled successfully.');
					}
				}
			} else */
			$deletedArray = $this->data['deleted'];
			
			App::import('Model','Order');
			$this->Order = new Order();
			
			$this->Order->expects(array('OrderItem','UserSummary','OrderSeller'));
			$this->Order->OrderItem->expects(array('SellerSummary'));
			$this->Order->OrderSeller->expects(array('SellerSummary'));
			$this->Order->recursive = 2;
			
			
			
			if($this->data['Order']['status']=='fraud'){
				foreach($this->data['select'] as $orderId){
					if(!empty($orderId)){
						//Start Check order status
						echo $deleted = $deletedArray[$orderId];
						
						$orderStatusArr = $this->Ordercom->getOrderShippingStatus($orderId);
						if(is_array($orderStatusArr)){
							if(in_array( 'Unshipped', $orderStatusArr)) {
								
								$ship_status = 'Unshipped';
							}
							if(in_array( 'Part Shipped', $orderStatusArr)) {
								echo '2';
								$ship_status = 'Part Shipped';
							}
							if(in_array( 'Shipped', $orderStatusArr)) {
								if($ship_status == 'Unshipped' || $ship_status == 'Part Shipped')
									$ship_status = 'Part Shipped';
								else
									$ship_status = 'Shipped';
							}
							if(in_array( 'Cancelled', $orderStatusArr)) {
								
								if($ship_status == 'Unshipped' || $ship_status == 'Part Shipped')
									$ship_status = 'Part Shipped';
								else if($ship_status == 'Shipped')
									$ship_status = 'Shipped';
								else
									$ship_status = 'Cancelled';
							}
						}else{
							$ship_status = 'Not Available';
						}
						//End  Check order status
						if($ship_status == "Unshipped" && $deleted == 0){
						
						$this->Ordercom->addBackQuantity($orderId);
						/*Update status in order table now*/
						$this->Order->id= $orderId;
						$this->Order->saveField('deleted','2'); // for fraud orders
						$this->admin_sendFraudMail($orderId);
						$this->Session->setFlash('Order has been marked as fraudent successfully.');
						}
					}
				}
				
			} else if($this->data['Order']['status']=='del'){
				
				foreach($this->data['select'] as $orderId){
					if(!empty($orderId)){
						//Start Check order status
						$deleted = "";
						$deleted = $deletedArray[$orderId];
						$orderStatusArr = $this->Ordercom->getOrderShippingStatus($orderId);
						if(is_array($orderStatusArr) ){
							if(in_array( 'Unshipped', $orderStatusArr)) {
								
								$ship_status = 'Unshipped';
							}
							if(in_array( 'Part Shipped', $orderStatusArr)) {
								echo '2';
								$ship_status = 'Part Shipped';
							}
							if(in_array( 'Shipped', $orderStatusArr)) {
								if($ship_status == 'Unshipped' || $ship_status == 'Part Shipped')
									$ship_status = 'Part Shipped';
								else
									$ship_status = 'Shipped';
							}
							if(in_array( 'Cancelled', $orderStatusArr)) {
								
								if($ship_status == 'Unshipped' || $ship_status == 'Part Shipped')
									$ship_status = 'Part Shipped';
								else if($ship_status == 'Shipped')
									$ship_status = 'Shipped';
								else
									$ship_status = 'Cancelled';
							}
						}else{
							$ship_status = 'Not Available';
						}
						if($ship_status == "Unshipped" && $deleted == 0){
						//End  Check order status
						//echo $ship_status;
						//pr($orderStatusArr);
						//pr($this->data); exit;
							
						$this->Ordercom->addBackQuantity($orderId);
						$this->Order->id= $orderId;
						$this->Order->saveField('deleted','1'); // for deleted orders
						$this->Session->setFlash('Records has been deleted successfully.');
						}
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
			if(isset($this->params['named']['showtype']))
				$this->data['Search']['show']=$this->params['named']['showtype'];
			else
				$this->data['Search']['show']='';
		}
		/** for searching and sorting*/
		if(!empty($this->data['Search']['keyword']) && !empty($this->data['Search']['searchin']) && !empty($this->data['Search']['show']))
			$this->redirect('/admin/orders/index/keyword:'.$this->data['Search']['keyword'].'/searchin:'.$this->data['Search']['searchin'].'/showtype:'.$this->data['Search']['show']);
		else
			$this->redirect('/admin/orders/index/');
	}
	
	
	/** 
	@function:	contact_sellers
	@description	to display sellers or admin messages to buyer
	@Created by: 	Tripti Poddar
	@MOdified by: 	Ramanpreet Pal Kaur
	@params		NULL
	@Created Date:	18 Jan 2011
	@Modified Date: 19 Jan 2011
	*/
	function contact_sellers($seller_id = null) {
		if ($this->RequestHandler->isMobile()) {
 			$this->layout = 'mobile/product';
		} else{
			if($this->RequestHandler->isAjax()==0){
				$this->layout = 'front';
			}else{
				$this->layout = 'ajax';
			}
		}
		$this->set('title_for_layout','Contact Marketplace Sellers | My Account | Choiceful.com');
		$this->checkSessionFrontUser();
		App::import('Model','Message');
		$this->Message = new Message;
		$buyer_id = $this->Session->read('User.id');
			
		$all_msg = $this->Message->find('list',array('conditions'=>array('Message.to_user_id'=>$buyer_id,'Message.msg_from'=>'S','Message.to_read_status'=>0,'(Message.msg_from = "S" OR Message.msg_from = "A")'),'fields'=>array('Message.id','Message.to_read_status')));
			
		if(!empty($all_msg)){
			foreach($all_msg as $msg_id=>$msg_status){
				$this->Message->id = $msg_id;
				$this->Message->saveField('to_read_status',1);
			}
			$this->Session->write('msg_buyers_read',1);
		}
		
		$firstname = $this->Session->read('User.firstname');
		$lastname = $this->Session->read('User.lastname');
		$this->set('buyer_id', $buyer_id);
		$this->set('firstname', $firstname);
		$this->set('lastname', $lastname);
			
		// get country name
		$countryArr = $this->Common->getcountries();
		$this->set('countryArr', $countryArr);
		
		
		App::import('Model','Order');
		$this->Order = new Order;
		$this->Order->expects(array('OrderItem'));
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
		$creteria = array();
		$this->Order->recursive = 2;
		$this->paginate = array('order' => array('Order.created DESC'),'limit' => $limit,'fields'=>array('Order.created', 'Order.id','Order.order_number', 'Order.shipping_firstname', 'Order.shipping_lastname', 'Order.shipping_address1', 'Order.shipping_address2', 'Order.shipping_city', 'Order.shipping_country', 'Order.shipping_postal_code', 'Order.order_total_cost'));
				$this->loadModel('OrderSeller');
				$this->OrderSeller->bindModel(array("belongsTo" =>array('Order' => array(
											'className' => 'Order',
											'foreignKey' => 'order_id',
											'conditions' => array("Order.user_id"=>$buyer_id),
											'type'=>'inner'
										)
						
					      )
							        )
						       );
				$orderIds=$this->OrderSeller->find('all',array('conditions'=>array('OrderSeller.shipping_status != "Cancelled"'),'fields'=>array('id','order_id')));
				
				if(!empty($orderIds)){
				foreach($orderIds  as $key =>$val){
					$order_id[] = $val['OrderSeller']['order_id'];
					
				}
				
				$this->Order->bindModel(array('hasMany' =>array('OrderItem'=>array(
											'className' => 'OrderItem',
											'foreignKey' => 'order_id'
											
										))));
				$orderIds =  implode(',',$order_id);
				$creteria = array('Order.deleted'=>'0','Order.payment_status'=>'Y',"Order.id IN ($orderIds)");
				$order_user_seller = $this->OrderSeller->find('count',array('conditions'=>array('OrderSeller.order_id IN('.$orderIds.')','OrderSeller.seller_id'=>$seller_id)));
			
				$orders = $this->paginate('Order',$creteria);
				
				}
		
		
		
		//$orders = $this->Order->find('all',array('conditions'=>array('Order.user_id'=>$buyer_id,'Order.deleted'=>'0','Order.payment_status'=>'Y'),'fields'=>array('Order.created', 'Order.id', 'Order.order_number', 'Order.shipping_firstname', 'Order.shipping_lastname', 'Order.shipping_address1', 'Order.shipping_address2', 'Order.shipping_city', 'Order.shipping_country', 'Order.shipping_postal_code', 'Order.order_total_cost'), 'order'=>'Order.created DESC'));

		if(!empty($orders)){
			App::import('Model','Address');
			$this->Address = new Address;
			$j = 0;
			$l=0;
			$lm=1;
			foreach($orders as $order){
				if(!empty($order['OrderItem'])) {
					$i = 0;
					
					foreach($order['OrderItem'] as $or_item){
						/*$orderitem_unshipped = $this->OrderSeller->find('first',array('conditions'=>array('OrderSeller.order_id'=>$or_item['order_id'],'OrderSeller.seller_id'=>$or_item['seller_id'],'OR'=>array('OrderSeller.shipping_status'=>'Part Shipped','OrderSeller.shipping_status'=>'Cancelled'))));
						if(!empty($orderitem_unshipped)){echo $lm;
						$lm++;
							unset($orders[$j]['OrderItem'][$i]);
						} else{*/
							
							$item_msgs = $this->Message->find('all',array('conditions'=>array('Message.order_item_id'=>$or_item['id']),'order'=>array('Message.created Desc')));
							if(!empty($item_msgs)){
								foreach($item_msgs as $item_msg){
									$orders[$j]['OrderItem'][$i]['Message'][] = $item_msg['Message'];
								}
							}
							$seller_ph = $this->Address->find('first',array('conditions'=>array('Address.user_id'=>$or_item['seller_id'],'Address.primary_address'=>'1'),'fields'=>array('Address.add_phone')));
							if(!empty($seller_ph)){
								$orders[$j]['OrderItem'][$i]['phone_number'] = $seller_ph['Address']['add_phone'];
							}
						//}
						$i++;
					}
				}
				$j++;
			}
		}
		
	
		if(!empty($order_user_seller)){
			$this->set('order_user_seller', $order_user_seller);
		}else{
			$this->set('order_user_seller', '0');
		}

		//pr($orders);
		$this->set('seller_id', $seller_id);
		$this->set('buyer_orders', $orders);
		
		if($this->RequestHandler->isAjax()==1){
			$this->render('/elements/orders/contact_sellers');
		}
		
		/*App::import('Model','Order');
		$this->Order = new Order;
		$this->Order->expects(array('OrderItem'));
		$orders = $this->Order->find('all',array('conditions'=>array('Order.user_id'=>$buyer_id,'Order.deleted'=>'0','Order.payment_status'=>'Y'),'fields'=>array('Order.created', 'Order.id', 'Order.order_number', 'Order.shipping_firstname', 'Order.shipping_lastname', 'Order.shipping_address1', 'Order.shipping_address2', 'Order.shipping_city', 'Order.shipping_country', 'Order.shipping_postal_code', 'Order.order_total_cost'), 'order'=>'Order.created DESC'));
		App::import('Model','OrderSeller');
		$this->OrderSeller = new OrderSeller;
		if(!empty($orders)){
			App::import('Model','Address');
			$this->Address = new Address;
			$j = 0;
			foreach($orders as $order){
				if(!empty($order['OrderItem'])) {
					$i = 0;
					foreach($order['OrderItem'] as $or_item){
						$orderitem_unshipped = $this->OrderSeller->find('first',array('conditions'=>array('OrderSeller.order_id'=>$or_item['order_id'],'OrderSeller.seller_id'=>$or_item['seller_id'],'OR'=>array('OrderSeller.shipping_status'=>'Part Shipped','OrderSeller.shipping_status'=>'Cancelled'))));
						if(!empty($orderitem_unshipped)){
							unset($orders[$j]['OrderItem'][$i]);
						} else{
							$item_msgs = $this->Message->find('all',array('conditions'=>array('Message.order_item_id'=>$or_item['id']),'order'=>array('Message.created Desc')));
							if(!empty($item_msgs)){
								foreach($item_msgs as $item_msg){
									$orders[$j]['OrderItem'][$i]['Message'][] = $item_msg['Message'];
								}
							}
							$seller_ph = $this->Address->find('first',array('conditions'=>array('Address.user_id'=>$or_item['seller_id'],'Address.primary_address'=>'1'),'fields'=>array('Address.add_phone')));
							if(!empty($seller_ph)){
								$orders[$j]['OrderItem'][$i]['phone_number'] = $seller_ph['Address']['add_phone'];
							}
						}
						$i++;
					}
				}
				$j++;
			}
		}
		if(!empty($orders)){
			$k = 0;
			foreach($orders as $order){
				if(empty($order['OrderItem'])){
					unset($orders[$k]);
				}
				$k++;
				$order_ids[] = $order['Order']['id'];
			}
			$orderids = implode($order_ids,',');
			$order_user_seller = $this->OrderSeller->find('count',array('conditions'=>array('OrderSeller.order_id IN('.$orderids.')','OrderSeller.seller_id'=>$seller_id)));
			
			
		}
		if(!empty($order_user_seller)){
			$this->set('order_user_seller', $order_user_seller);
		}else{
			$this->set('order_user_seller', '0');
		}
		
		$this->set('seller_id', $seller_id);
		$this->set('buyer_orders', $orders);*/
	}



	/** 
	@function:	add_message
	@description	to add reply messages to users by seller
	@Created by: 	Tripti Poddar	
	@params		NULL
	@Created Date:  19 Jan 2011
	@Modified Date: 19 Jan 2011
	*/
	function add_message() {
		$this->checkSessionFrontUser();
		$seller_id = $this->Session->read('User.id');
		
		if(!empty($seller_id)){			
			if(!empty($this->data)){
				$this->Message->set($this->data);
				if($this->Message->validates()){
					$msg_info = $this->Message->find('first',array('conditions'=>array('Message.id'=>$this->data['Message']['reply_id']),'fields'=>array('Message.subject')));

					$this->data['Message']['subject'] = $msg_info['Message']['subject'];
					$this->data['Message']['from_read_status'] = 1;
					$this->data['Message']['from_user_id'] = $seller_id;
					$this->Message->set($this->data);

					$this->Message->save($this->data);
					/*SENT EMAIL ALERT >$this->data['Message']['reply_id']*/
					$this->Session->setFlash('The message has been sent successfully.');
					$this->redirect('/messages/sellers/'.$this->data['Message']['to_user_id'].'/'.$this->data['Message']['reply_id']);
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
	@function:	add_msg
	@description	to add buyer's comment
	@Created by: 	Tripti Poddar	
	@params		NULL
	@Created Date:	20 Jan 2011
	@Modified Date: 21 Jan 2011
	*/
	function add_msg(){
		$this->checkSessionFrontUser();
		$user_id = $this->Session->read('User.id');
		App::import('Model','Message');
		$this->Message = new Message;
		$this->data['Message']['message'] = $this->data['Order']['message'];
		$this->data['Message']['from_user_id'] = $user_id;
		$this->data['Message']['to_user_id'] = $this->data['Order']['to_user_id'];
		$this->data['Message']['from_read_status'] = 1;
		$this->data['Message']['order_item_id'] = $this->data['Item']['id']; // for which item buyer is sending msg
		
		$this->data = $this->cleardata($this->data);
		//$this->data = Sanitize::clean($this->data, array('encode' => false));
		
		$this->Message->set($this->data);
		if(!empty($this->data['Message']['message'])){
			App::import('Model','User');
			$this->User = new User;
			$user_status = $this->User->find('first',array('conditions'=>array('User.id'=>$user_id),'fields'=>array('User.msg_status')));
			if(!empty($user_status['User']['msg_status'])){
				if($this->Message->save($this->data)){
					//Only for Mobile
					//$this->Session->setFlash('Comment sent successfully.','default',array('class'=>'message'));
					/** FUNCTION CALL $this->data['Message']['to_user_id']**/
					$send_email_messages = $this->Common->sendEmailAlert($this->data['Message']['to_user_id']);
					$send_msg_success_id = $this->data['Item']['id']; //echo $send_msg_error_id; exit;
					$this->Session->write('Order.send_msg_success_id',$send_msg_success_id);
						
					$this->Email->smtpOptions = array(
						'host' => Configure::read('host'),
						'username' => Configure::read('username'),
						'password' => Configure::read('password'),
						'timeout' => Configure::read('timeout')
					);
					$this->Email->sendAs= 'html';
					App::import('Model','EmailTemplate');
					$this->EmailTemplate = new EmailTemplate;
					$template = $this->Common->getEmailTemplate(15);
					$data = $template['EmailTemplate']['description'];
					
					$user_info_sender = $this->User->find('first',array('conditions'=>array('User.id'=>$this->data['Message']['to_user_id']),'fields'=>array('User.id','User.firstname','User.lastname','User.email')));
						
					$this->Email->subject = $template['EmailTemplate']['subject'];
					$this->Email->from = $template['EmailTemplate']['from_email'];
					$this->Email->to = $user_info_sender['User']['email'];
					$this->set('data',$data);
						
					$this->Email->template = 'commanEmailTemplate';
					$this->Email->send();
						
				} else{
					$this->Session->setFlash('An error occurred while sending the comment. Please contact Customer Support at '.Configure::read('phone').'.','default',array('class'=>'flashError'));
				}
			} else{
				$this->Session->setFlash('You have been temporarily suspended from sending any messages due to violation of our conditions of use, please contact us for further information.','default',array('class'=>'flashError'));
			}
		} else{
			$send_msg_error_id = $this->data['Item']['id']; //echo $send_msg_error_id; exit;
			$this->Session->write('Order.send_msg_error_id',$send_msg_error_id);
			if ($this->RequestHandler->isMobile()) {
				$this->Session->setFlash('Enter your comments','default',array('class'=>'flashError'));
			}
		}
		
		//Redirection after save message
		//Added on Oct 16, 2012
		$this->redirect(array('controller'=>'orders','action'=>'contact_sellers'));
		
		
		// blank message after submitting
		$this->data['Order']['message'] = '';
		$this->Order->expects(array('OrderItem'));
		$this->Order->OrderItem->expects(array('Message'));
		$this->Order->recursive = 2;
		$seller_id = $user_id;
		$orders = $this->Order->find('all',array('conditions'=>array('Order.user_id'=>$seller_id),'fields'=>array('Order.created', 'Order.id', 'Order.shipping_firstname', 'Order.shipping_lastname', 'Order.shipping_address1', 'Order.shipping_address2', 'Order.shipping_city', 'Order.shipping_country', 'Order.shipping_postal_code', 'Order.order_total_cost'), 'order'=>'Order.created DESC'));
		$msg ='';
		if(!empty($orders[0]['OrderItem'])) {
			if(!empty($orders[0]['OrderItem'][0])) {
				if(!empty($orders[0]['OrderItem'][0]['Message'])) {
					$msg = $orders[0]['OrderItem'][0]['Message'];
				}
			}
		}
		// set data for ajax
		if(!empty($this->data['Item'])){
			$itemVal['id'] = $this->data['Item']['id'];
			$itemVal['seller_id'] = $this->data['Item']['seller_id1'];
		}
		App::import('Model','OrderItem');
		$this->OrderItem = new OrderItem;
		App::import('Model','Message');
		$this->Message = new Message;
		$seller_id = $user_id;
		$msgs = $this->OrderItem->find('first',array('conditions'=>array('OrderItem.id'=>$itemVal['id'])));
		
		if(!empty($msgs)){
			$item_msgs = $this->Message->find('all',array('conditions'=>array('Message.order_item_id'=>$itemVal['id']),'order'=>array('Message.created Desc')));
			if(!empty($item_msgs)){
				foreach($item_msgs as $item_msg){
					$msgs['Message'][] = $item_msg['Message'];
				}
			}
		}
		$itemVal['seller_id'] =  $msgs['OrderItem']['seller_id'];
		$itemVal['seller_name'] = $msgs['OrderItem']['seller_name'];
		$itemVal['order_id'] =  $msgs['OrderItem']['order_id'];
		$itemVal['product_name'] = $msgs['OrderItem']['product_name'];
		if(empty($msgs['Message'])){
			$msgs['Message'] = '';
		}
		$itemVal['Message'] = $msgs['Message'];
		$this->set('itemVal',$itemVal);
		$this->layout='ajax';
		if ($this->RequestHandler->isMobile()) {
			$this->viewPath = 'elements/mobile/orders' ;
		}else{
			$this->viewPath = 'elements/orders' ;
		}
		$this->render('msg');
		
	}

	/** 
	@function:	order_history
	@description	to display buyer's order history
	@Created by: 	Tripti Poddar	
	@params		NULL
	@Created Date:	21 Jan 2011
	@Modified Date: 21 Jan 2011
	*/
	function order_history($buyer_id=null, $msg_id=null) {
		if ($this->RequestHandler->isMobile()) {
 			$this->layout = 'mobile/product';
		} else{
			if($this->RequestHandler->isAjax()==0){
				$this->layout = 'front';
			}else{
				$this->layout = 'ajax';
			}
		}
		$this->set('title_for_layout','Order Histrory | My Account | Choiceful.com');
		$this->checkSessionFrontUser();
		$user_id = $this->Session->read('User.id');
		$firstname = $this->Session->read('User.firstname');
		$lastname = $this->Session->read('User.lastname');
		$this->set('seller_id', $user_id);
		$this->set('firstname', $firstname);
		$this->set('lastname', $lastname);
		$all_departments = $this->Common->getdepartments();
		//pr($all_departments);
		$or_str = '';
		App::import('Model','OrderItem');
		$this->OrderItem = new OrderItem;
		$all_orders = $this->Order->find('all',array('conditions'=>array('Order.user_id'=>$user_id,'Order.payment_status'=>'Y'),'fields'=>array('Order.id')));

		if(!empty($all_orders)){
			foreach($all_orders as $ord){
				if(empty($or_str))
					$or_str = $ord['Order']['id'];
				else
					$or_str = $or_str.','.$ord['Order']['id'];
				
			}
		}
		if(!empty($or_str)){
			$count_totalorderItems = $this->OrderItem->find('count',array('conditions'=>array('OrderItem.order_id IN('.$or_str.')')));
		}

		$query = "select count(product_id) as total_products,products.department_id from order_items inner join orders ON (orders.id = order_items.order_id) inner join products on (order_items.product_id = products.id) where orders.user_id = ".$user_id." and orders.payment_status = 'Y' group by products.department_id";
		$or_items = $this->OrderItem->query($query);
		if(!empty($all_departments)){
			foreach($all_departments as $department_id => $all_department){
				if(!empty($or_items)){
					foreach($or_items as $or_item){
						if($or_item['products']['department_id'] == $department_id){
							$total_pro_dept[$department_id] = $or_item[0]['total_products'];
							break;
						} else{
							$total_pro_dept[$department_id] = 0;
						}
					}
				}
			}
		}
		$legends = $all_departments;

			
// 			$valArr[1] = 10; 
// 			$valArr[2] = 20; 
// 			$valArr[3] = 30; 
// 			$valArr[4] = 40; 
// 			$valArr[5] = 50; 
// 			$valArr[6] = 60; 
// 			$valArr[7] = 70; 
// 			$valArr[8] = 80; 
// 			$valArr[9] = 90; 
// 
// 			$total_pro_dept = $valArr;

		if(!empty($total_pro_dept)){
			foreach($total_pro_dept as $dept_id => $total_pro_dept){
				$total_dept_pro_per[] = $total_pro_dept;
				$total_depart_pro[$dept_id] = $total_pro_dept;
			}
		}
		##########################
		if(!empty($total_dept_pro_per)){
			 $total_buyed = array_sum($total_dept_pro_per);
			foreach($total_depart_pro as $dept_index_id => $deptvalue){
				$dept_value_array[$dept_index_id]['dept_value'] = sprintf("%01.1f", (($deptvalue / $total_buyed) * 100));
				$dept_value_array[$dept_index_id]['dept_name'] = $all_departments[$dept_index_id];
			}
			$this->set('dept_value_array',$dept_value_array);
			$this->Jpgraph->displayPieGraph($total_dept_pro_per,$user_id);
			$this->set('piegraph',1);
		} else{
			$this->set('piegraph',0);
		}
		############################
		$current_month = date('m');$month = date('m');
		$current_year = date('Y');
		$satrtDate =  date("Y-m-d H:i:s ",mktime(0, 0,0, $current_month-7,1,$current_year));
		$satrtDate = date('Y-m-d',strtotime($satrtDate));
		$month = date('m',strtotime($satrtDate));
		$year = date('Y',strtotime($satrtDate));
		for($month_count = 0;$month_count < 8;$month_count++){
			$next_month = $month+1;
			if($next_month > 12){
				$next_month = '01';
				$next_year = $year+1;
			} else{
				$next_year = $year;
			}
			if(strlen($next_month) == 1)
				$next_month = '0'.$next_month;
			$order_sum[$month] = $this->Order->find('all',array('conditions'=>array('Order.user_id'=>$user_id,'Order.payment_status'=>'Y','Order.deleted'=>'0','Order.created BETWEEN "'.$year.'-'.$month.'-01" AND "'.$next_year.'-'.$next_month.'-01"'),'fields'=>array('SUM(Order.order_total_cost) as total_amount')));
			$order_sum[$month]['year'] = $year;

			$month = $month+1;
			if($month > 12){
				$month = '01';
				$year = $year+1;
			}
			if(strlen($month) == 1)
				$month = '0'.$month;
		}
		$or_mt = array();
		if(!empty($order_sum)){
			foreach($order_sum as $month_id => $month_order){
				if(!empty($month_order[0][0]['total_amount'])){
					$or_mt[$month_id.'-'.substr($month_order['year'], 2)] = $month_order[0][0]['total_amount'];
				} else{
					$or_mt[$month_id.'-'.substr($month_order['year'], 2)] = 0;
				}
			}
		}
		foreach($or_mt as $index => $or_m){
			$data[] = $or_m;
			$x_axis[] = $index;
		}

		##########################
		if(!empty($data)){
			$this->Jpgraph->displayBarGraph($data,$x_axis,$user_id);
			$this->set('bargraph',1);
		} else{
			$this->set('bargraph',0);
		}
		############################
		// get country name
		$countryArr = $this->Common->getcountries();
		$this->set('countryArr', $countryArr);

		$this->Order->expects(array('OrderItem'));

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
		$this->loadModel('OrderSeller');
		$this->OrderSeller->bindModel(array("belongsTo" =>array('Order' => array(
									'className' => 'Order',
									'foreignKey' => 'order_id',
									'conditions' => array("Order.user_id"=>$user_id),
									'type'=>'inner'
								)
				
							 )
						)
				       );
		$orderIds=$this->OrderSeller->find('all',array('conditions'=>array('(OrderSeller.shipping_status = "Part Shipped" OR OrderSeller.shipping_status = "Shipped")'),'fields'=>array('id','order_id')));
		if(!empty($orderIds)){

		foreach($orderIds  as $key =>$val){
			$order_id[] = $val['OrderSeller']['order_id'];
			
		}
		
		$this->Order->bindModel(array('hasMany' =>array('OrderItem'=>array(
									'className' => 'OrderItem',
									'foreignKey' => 'order_id',
								))));
		$orderIds =  implode(',',$order_id);
		$crateria = array('Order.deleted'=>'0','Order.payment_status'=>'Y',"Order.id IN ($orderIds)");
		
		//$OrderData=$this->Order->find('all','fields'=>array(),'order' => array('Order.created DESC')));
		$this->paginate = array('order' => array('Order.created DESC'),'limit' => $limit,'fields'=>array('Order.created', 'Order.id','Order.order_number', 'Order.shipping_firstname', 'Order.shipping_lastname', 'Order.shipping_address1', 'Order.shipping_address2', 'Order.shipping_city', 'Order.shipping_country', 'Order.shipping_postal_code', 'Order.order_total_cost'));

		$orders = $this->paginate('Order',$crateria);
		}
				
			
		App::import('Model','OrderSeller');
		$this->OrderSeller = new OrderSeller;
		App::import('Model','DispatchedItem');
		$this->DispatchedItem = new DispatchedItem;
		App::import('Model','OrderReturn');
		$this->OrderReturn = new OrderReturn;
		if(!empty($orders)){
			$j = 0;
			foreach($orders as $order_index=>$order){
				
				if(!empty($order['OrderItem'])) {
					$i = 0;
					foreach($order['OrderItem'] as $or_index=>$or_item){
						$orderitem_unshipped = $this->OrderSeller->find('first',array('conditions'=>array('OrderSeller.order_id'=>$or_item['order_id'],'OrderSeller.seller_id'=>$or_item['seller_id'],'(OrderSeller.shipping_status = "Part Shipped" OR OrderSeller.shipping_status = "Shipped")')));
						
						if(empty($orderitem_unshipped)){
							unset($orders[$j]['OrderItem'][$i]);
						} else{
							$total_dispatch_qty = $this->DispatchedItem->find('all',array('conditions'=>array('DispatchedItem.order_item_id'=>$or_item['id']),'fields'=>array('SUM(DispatchedItem.quantity) as total_dispatched')));

							$total_returned_qty = $this->OrderReturn->find('all',array('conditions'=>array('OrderReturn.order_item_id'=>$or_item['id']),'fields'=>array('SUM(OrderReturn.quantity) as total_returned')));
							$orders[$j]['OrderItem'][$i]['total_dispatched'] = $total_dispatch_qty[0][0]['total_dispatched'];
							$orders[$j]['OrderItem'][$i]['total_returned'] = $total_returned_qty[0][0]['total_returned'];
						}
						$i++;
					}
				}
				$j++;
			}
		}
		
		if(!empty($orders)){
			$k = 0;
			foreach($orders as $order){
				if(empty($order['OrderItem'])){
					unset($orders[$k]);
				}
				$k++;
			}
		}
		
		$this->set('buyer_orders', $orders);
		if($this->RequestHandler->isAjax()==1){
			$this->render('/elements/orders/order_history');
		}
		
		
		//$orders = $this->Order->find('all',array('conditions'=>array('Order.user_id'=>$user_id,'Order.deleted'=>'0','Order.payment_status'=>'Y'),'fields'=>array('Order.created', 'Order.id','Order.order_number', 'Order.shipping_firstname', 'Order.shipping_lastname', 'Order.shipping_address1', 'Order.shipping_address2', 'Order.shipping_city', 'Order.shipping_country', 'Order.shipping_postal_code', 'Order.order_total_cost'), 'order'=>'Order.created DESC'));
		
		/*App::import('Model','OrderSeller');
		$this->OrderSeller = new OrderSeller;
		App::import('Model','DispatchedItem');
		$this->DispatchedItem = new DispatchedItem;
		App::import('Model','OrderReturn');
		$this->OrderReturn = new OrderReturn;
		if(!empty($orders)){
			$j = 0;
			foreach($orders as $order_index=>$order){
				
				if(!empty($order['OrderItem'])) {
					$i = 0;
					foreach($order['OrderItem'] as $or_index=>$or_item){
						$orderitem_unshipped = $this->OrderSeller->find('first',array('conditions'=>array('OrderSeller.order_id'=>$or_item['order_id'],'OrderSeller.seller_id'=>$or_item['seller_id'],'(OrderSeller.shipping_status = "Part Shipped" OR OrderSeller.shipping_status = "Shipped")')));
						
						if(empty($orderitem_unshipped)){
							unset($orders[$j]['OrderItem'][$i]);
						} else{
							$total_dispatch_qty = $this->DispatchedItem->find('all',array('conditions'=>array('DispatchedItem.order_item_id'=>$or_item['id']),'fields'=>array('SUM(DispatchedItem.quantity) as total_dispatched')));

							$total_returned_qty = $this->OrderReturn->find('all',array('conditions'=>array('OrderReturn.order_item_id'=>$or_item['id']),'fields'=>array('SUM(OrderReturn.quantity) as total_returned')));
							$orders[$j]['OrderItem'][$i]['total_dispatched'] = $total_dispatch_qty[0][0]['total_dispatched'];
							$orders[$j]['OrderItem'][$i]['total_returned'] = $total_returned_qty[0][0]['total_returned'];
						}
						$i++;
					}
				}
				$j++;
			}
		}
		if(!empty($orders)){
			$k = 0;
			foreach($orders as $order){
				if(empty($order['OrderItem'])){
					unset($orders[$k]);
				}
				$k++;
			}
		}
		$this->set('buyer_orders', $orders);*/
	}
	
	/** 
	@function:	return_items
	@description	to display buyer's return items
	@Created by: 	Tripti Poddar	
	@Modified By: 	Ramanpreet Pal Kaur
	@params		NULL
	@Created Date:	21 Jan 2011
	@Modified Date: 11 Feb 2011
	*/
	function return_items($encoded_item_id = null) {
		if ($this->RequestHandler->isMobile()) {
 			$this->layout = 'mobile/product';
		} else{
			if($this->RequestHandler->isAjax()==0){
				$this->layout = 'front';
			}else{
				$this->layout = 'ajax';
			}
		}
		$this->set('title_for_layout','Manage Returns to Marketplace Sellers | My Account | Choiceful.com');
		$prev_item_id = base64_decode($encoded_item_id);
		$this->checkSessionFrontUser();
		$user_id = $this->Session->read('User.id');
		$firstname = $this->Session->read('User.firstname');
		$lastname = $this->Session->read('User.lastname');
		$this->set('user_id', $user_id);
		$this->set('firstname', $firstname);
		$this->set('lastname', $lastname);
		$seller_id = null;
		if(!empty($this->params['named']['seller_id'])){
			$seller_id = $this->params['named']['seller_id'];
		}
		// get country name
		$countryArr = $this->Common->getcountries();
		$this->set('countryArr', $countryArr);
		App::import('Model','DispatchedItem');
		$this->DispatchedItem = new DispatchedItem;
		App::import('Model','OrderItem');
		$this->OrderItem = new OrderItem;
		$this->OrderItem->expects(array('Product'));
		$this->Order->expects(array('OrderItem'));
		
		/* ******************* page limit sction **************** */
		$this->records_per_page =10;
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
		/* ******************* page limit sction **************** */
		$orderIdsStr = '';
		$orders= array();
		$this->loadModel('OrderItem');
		$this->OrderItem->bindModel(array("belongsTo" =>array('Product' => array(
									'className' => 'Product',
									'fields' => array('Product.id', 'Product.product_image')
									)
								)
							)
						);
		$this->loadModel('DispatchedItem');
		$this->DispatchedItem->bindModel(array("belongsTo" =>array('Order' => array(
									'className' => 'Order',
									'fields' => 'order_id',
									'conditions' => array("Order.user_id"=>$user_id),
									'type'=>'inner'
									)
								)
							)
						);
		$orderData=$this->DispatchedItem->find('all',array('fields'=>array('distinct order_item_id','order_id')));
		
		if(!empty($orderData))	{				
			foreach($orderData  as $key =>$val){
				$dispatchItemIds[] = $val['DispatchedItem']['order_item_id'];
				$orderIds[] = $val['DispatchedItem']['order_id'];
				
			}
		
			$dispatchItemIdsStr =  implode(',',$dispatchItemIds);
			$orderIdsStr =  implode(',',$orderIds);
	
			$this->Order->bindModel(array('hasMany' =>array('OrderItem'=>array(
									'className' => 'OrderItem',
									'foreignKey' => false,
									'conditions' => array("OrderItem.id"=>"IN $dispatchItemIdsStr"),
									'fields'=>array('OrderItem.id', 'OrderItem.seller_id', 'OrderItem.product_id', 'OrderItem.order_id', 'OrderItem.condition_id', 'OrderItem.quantity', 'OrderItem.price', 'OrderItem.delivery_method', 'OrderItem.delivery_cost', 'OrderItem.estimated_delivery_date', 'OrderItem.giftwrap', 'OrderItem.giftwrap_cost', 'OrderItem.gift_note', 'OrderItem.product_name', 'OrderItem.quick_code', 'OrderItem.seller_name')
									
								))));
		
			$this->Order->recursive = 2;
			$crateria = array();
			if(!empty($orderIdsStr)){
				$crateria= array("Order.id IN ($orderIdsStr)");
			}
			$this->paginate = array('limit'=>$limit,'fields'=>array('Order.created', 'Order.id', 'Order.order_number', 'Order.shipping_firstname', 'Order.shipping_lastname', 'Order.shipping_address1', 'Order.shipping_address2', 'Order.shipping_city', 'Order.shipping_country', 'Order.shipping_postal_code', 'Order.order_total_cost'), 'order'=>'Order.created DESC');
	
			$ordersData = $this->paginate('Order',$crateria);
		}
		if(!empty($ordersData)){
			foreach($ordersData as $key=>$finalArr){
				$orders[$key]['Order'] = $finalArr['Order'];
				foreach($finalArr['OrderItem'] as $subKey=>$subArr){
					$product = isset($subArr['Product'])?$subArr['Product']:'';
					unset($subArr['Product']);
					$orders[$key]['Items'][$subKey]['OrderItem'] = $subArr;
					$orders[$key]['Items'][$subKey]['Product'] = $product;
				}
			}
		}

		$order_items_dispatch = 0;
		$order_dispatch = array();
		if(!empty($orders)){
			$order_dispatch_seller = $this->OrderItem->find('count',array('conditions'=>array('OrderItem.order_id IN('.$orderIdsStr.')','OrderItem.seller_id'=>$seller_id)));
		}

		if(!empty($order_dispatch_seller)){
			$this->set('order_dispatch_seller', $order_dispatch_seller);
		}else{
			$this->set('order_dispatch_seller', '0');
		}
		$this->set('seller_id', $seller_id);
		$this->set('focusItemId', $prev_item_id);
		
		$this->set('prev_item_id',$prev_item_id);
		$this->set('buyer_orders',$orders);
		if($this->RequestHandler->isAjax()==1){
			$this->render('/elements/orders/return_items');
		}
		
		
		/*$orders = $this->Order->find('all',array('conditions'=>array('Order.user_id'=>$user_id),'fields'=>array('Order.created', 'Order.id', 'Order.order_number', 'Order.shipping_firstname', 'Order.shipping_lastname', 'Order.shipping_address1', 'Order.shipping_address2', 'Order.shipping_city', 'Order.shipping_country', 'Order.shipping_postal_code', 'Order.order_total_cost'), 'order'=>'Order.created DESC'));
			
		$order_items_dispatch = 0;
		$order_dispatch = array();
		if(!empty($orders)){
			$i = 0;
			$this->OrderItem->expects(array('Product','OrderReturn'));
				
			$this->DispatchedItem->expects(array('Order'));
			foreach($orders as $order){
				$dispatched_items = array();
					
				$dispatched_items = $this->DispatchedItem->find('all',array('conditions'=>array('DispatchedItem.order_id'=>$order['Order']['id']),'fields'=>array('distinct DispatchedItem.order_item_id')));
					
				if(!empty($dispatched_items)){
					$j = 0;
					foreach($dispatched_items as $dis_item){
						$order_item_dispatch = $this->OrderItem->find('first',array('conditions'=>array('OrderItem.id'=>$dis_item['DispatchedItem']['order_item_id']),'fields'=>array('OrderItem.id', 'OrderItem.seller_id', 'OrderItem.product_id', 'OrderItem.order_id', 'OrderItem.condition_id', 'OrderItem.quantity', 'OrderItem.price', 'OrderItem.delivery_method', 'OrderItem.delivery_cost', 'OrderItem.estimated_delivery_date', 'OrderItem.giftwrap', 'OrderItem.giftwrap_cost', 'OrderItem.gift_note', 'OrderItem.product_name', 'OrderItem.quick_code', 'OrderItem.seller_name', 'Product.id', 'Product.product_image')));
						$orders[$i]['Items'][] = $order_item_dispatch;
					}
				} else {
					unset($orders[$i]);
				}
				$i++;
				$order_ids[] = $order['Order']['id'];
				
			}
			$orderids = implode($order_ids,',');
			$order_dispatch_seller = $this->OrderItem->find('count',array('conditions'=>array('OrderItem.order_id IN('.$orderids.')','OrderItem.seller_id'=>$seller_id)));
		}
		if(!empty($order_dispatch_seller)){
			$this->set('order_dispatch_seller', $order_dispatch_seller);
		}else{
			$this->set('order_dispatch_seller', '0');
		}
		
		$this->set('seller_id', $seller_id);
		
		$this->set('prev_item_id',$prev_item_id);
		$this->set('buyer_orders',$orders);*/
	}

	/** 
	@function:	leave_seller_feedback
	@description	to leave seller a feedback by buyer on receiving item
	@Created by: 	Tripti Poddar	
	@params		NULL
	@Created Date:	21 Jan 2011
	@Modified Date: 21 Jan 2011
	*/
	function leave_seller_feedback($order_item_id = null) {
		$order_item_id = base64_decode($order_item_id);
		$this->set('active_order_item_id',$order_item_id);
		if ($this->RequestHandler->isMobile()) {
 			$this->layout = 'mobile/product';
		} else{
			if($this->RequestHandler->isAjax()==0){
				$this->layout = 'front';
			}else{
				$this->layout = 'ajax';
			}
		}
		$this->set('title_for_layout','Leave Seller Feedback | My Account | Choiceful.com');
		$this->checkSessionFrontUser();
		$user_id = $this->Session->read('User.id');
		$this->set('seller_id', $user_id);
		// get country name
		$countryArr = $this->Common->getcountries();
		$this->set('countryArr', $countryArr);
		App::import('Model','OrderItem');
		$this->OrderItem = new OrderItem;
		$this->OrderItem->expects(array('Order','Feedback'));
		
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
		$this->paginate = array('limit' => $limit,'order'=>array('Order.created DESC'));
		$this->loadModel('OrderSeller');
		$this->OrderSeller->bindModel(array("belongsTo" =>array('Order' => array(
									'className' => 'Order',
									'foreignKey' => 'order_id',
									'conditions' => array("Order.user_id"=>$user_id),
									'type'=>'inner'
								)
				
			      )
						)
				       );
		$orderIds=$this->OrderSeller->find('all',array('conditions'=>array('OrderSeller.shipping_status != "Cancelled"'),'fields'=>array('id','order_id')));
		$orderIds = array_reverse($orderIds);
		if(!empty($orderIds)){
		
		foreach($orderIds  as $key =>$val){
			$order_id[] = $val['OrderSeller']['order_id'];
			
		}
		$orderIds =  implode(',',$order_id);
		$this->OrderItem->bindModel(array('belongsTo' =>array('Order'=>array(
									'className' => 'Order',
									'foreignKey' => 'order_id',
									
									'type'=>'inner'
									
								))));
		
		
		//$this->OrderItem->recursive = 2;
		$orders = $this->paginate('OrderItem',array('Order.deleted'=>'0','Order.payment_status'=>'Y',"Order.id IN ($orderIds)"));
		}

		$this->set('buyer_orders', $orders);
		if($this->RequestHandler->isAjax()==1){
			$this->render('/elements/orders/leave_seller_feedback');
		}
		
		
		/*App::import('Model','OrderItem');
		$this->OrderItem = new OrderItem;
		$this->OrderItem->expects(array('Order','Feedback'));
		$orders = $this->OrderItem->find('all',array('conditions'=>array('Order.user_id'=>$user_id,'Order.deleted'=>'0','Order.payment_status'=>'Y'),'fields'=>array('Order.user_id', 'Order.created', 'Order.id', 'Order.order_number', 'Order.shipping_firstname', 'Order.shipping_lastname', 'Order.shipping_address1', 'Order.shipping_address2', 'Order.shipping_city', 'Order.shipping_country', 'Order.shipping_postal_code', 'Order.order_total_cost', 'OrderItem.product_name', 'OrderItem.seller_name', 'OrderItem.product_id', 'OrderItem.id','OrderItem.condition_id', 'OrderItem.seller_id', 'Feedback.id', 'Feedback.feedback', 'Feedback.product_id', 'Feedback.rating', 'Feedback.user_id', 'Feedback.order_id','Feedback.created', 'Feedback.order_item_id', 'Feedback.seller_id'), 'order'=>'Order.created DESC'));
		App::import('Model','OrderSeller');
		$this->OrderSeller = new OrderSeller;
		if(!empty($orders)){
			$j = 0;
			foreach($orders as $order){
				if(!empty($order['OrderItem'])) {
					$orderitem_unshipped = $this->OrderSeller->find('first',array('conditions'=>array('OrderSeller.order_id'=>$order['Order']['id'],'OrderSeller.seller_id'=>$order['OrderItem']['seller_id'],'OR'=>array('OrderSeller.shipping_status'=>'Part Shipped','OrderSeller.shipping_status'=>'Cancelled'))));
					
					if(!empty($orderitem_unshipped)){
						unset($orders[$j]);
					}
				}
				$j++;
			}
		}
		if(!empty($orders)){
			$k = 0;
			foreach($orders as $order){
				if(empty($order['OrderItem'])){
					unset($orders[$k]);
				}
				$k++;
			}
		}
		$this->set('buyer_orders', $orders);*/

	}


	/** 
	@function:	add_feedback
	@description	to add buyer's feedback
	@Created by: 	Tripti Poddar	
	@params		NULL
	@Created Date:	25 Jan 2011
	@Modified Date: 25 Jan 2011
	*/
	function add_feedback(){
		$this->checkSessionFrontUser();
		$user_id = $this->Session->read('User.id');
		App::import('Model','Feedback');
		$this->Feedback = new Feedback;
		App::import('Model','OrderItem');
		$this->OrderItem = new OrderItem;
		$this->data['Feedback']['feedback'] = $this->data['Order']['feedback'.$this->data['Order']['orderItemId']];
		$this->data['Feedback']['user_id'] = $this->data['Order']['user_id'];
		$this->data['Feedback']['seller_id'] = $this->data['Order']['seller_id'];
		$this->data['Feedback']['order_id'] = $this->data['Order']['order_id'];
		$this->data['Feedback']['product_id'] = $this->data['Order']['product_id'];
		$this->data['Feedback']['order_item_id'] = $this->data['Order']['orderItemId'];
		$this->data['Feedback']['rating'] = $this->params['form']['t'.$this->data['Order']['orderItemId']];
		
		$this->data = $this->cleardata($this->data);
		//$this->data = Sanitize::clean($this->data, array('encode' => false));
		
		$this->Feedback->set($this->data);
		if(!empty($this->data['Order']['feedback'.$this->data['Order']['orderItemId']]) && !empty($this->params['form']['t'.$this->data['Order']['orderItemId']])){
			if($this->Feedback->save($this->data)){
				$insertedId = $this->Feedback->getLastInsertID();
				$this->data['Order']['feedback'.$this->data['Order']['orderItemId']] = '';
				$this->params['form']['t'.$this->data['Order']['orderItemId']] = '';
				$this->OrderItem->expects(array('Feedback'));
				$orderItem_feedback_info = $this->OrderItem->find('first',array('conditions'=>array('OrderItem.id'=>$this->data['Feedback']['order_item_id'])));
				$val = $orderItem_feedback_info;
			} else{
				$this->Session->setFlash('An error occurred while saving the feedback. Please contact Customer Support at '.Configure::read('phone').'.','default',array('class'=>'flashError'));
			}
		} else{
			$this->Session->setFlash('Both rating and feedback is required.','default',array('class'=>'flashError'));
		}
		// blank message after submitting
		$this->data['Order']['feedback'] = '';
		// set data for ajax
		if(!empty($this->data['Order'])){
			$itemVal['order_id'] = $this->data['Order']['order_id'];
			$itemVal['seller_id'] = $this->data['Order']['seller_id'];
			$itemVal['order_item_id'] = $this->data['Order']['orderItemId'];
		}
		App::import('Model','OrderItem');
		$this->OrderItem = new OrderItem;
		$this->OrderItem->expects(array('Order','Feedback'));
		$seller_id = $user_id;
		$feedback = $this->OrderItem->find('all',array('conditions'=>array('OrderItem.id'=>$itemVal['order_item_id']),'fields'=>array('Order.user_id', 'Order.created', 'Order.id', 'Order.shipping_firstname', 'Order.shipping_lastname', 'Order.shipping_address1', 'Order.shipping_address2', 'Order.shipping_city', 'Order.shipping_country', 'Order.shipping_postal_code', 'Order.order_total_cost', 'OrderItem.product_name', 'OrderItem.seller_name', 'OrderItem.product_id', 'OrderItem.id', 'OrderItem.seller_id', 'OrderItem.condition_id')));
		$this->set('itemVal',$feedback[0]);
		$this->layout='ajax';
		if(!empty($val)){
			$this->set('val',$val);
			if ($this->RequestHandler->isMobile()) {
				$this->viewPath = 'elements/mobile/orders';
				$this->render('display_feedback');
			}else{
				$this->viewPath = 'elements/orders';
				$this->render('display_feedback');
			}
		} else {
			if ($this->RequestHandler->isMobile()) {
				$this->viewPath = 'elements/mobile/orders' ;
				$this->render('feedback');
			}else{
				$this->viewPath = 'elements/orders' ;
				$this->render('feedback');
			}
		}
		
	}

	/** 
	@function:	view_open_order
	@description	to display buyer's orders that are not dispatched	
	@params		NULL	
	*/
	function view_open_orders($buyer_id=null, $msg_id=null) {
		$this->set('title_for_layout','View Open Orders | My Account | Choiceful.com');
		if ($this->RequestHandler->isMobile()) {
 			$this->layout = 'mobile/product';
		} else{
			if($this->RequestHandler->isAjax()==0){
				$this->layout = 'front';
			}else{
				$this->layout = 'ajax';
			}
		}
		$this->checkSessionFrontUser();
		$user_id = $this->Session->read('User.id');
		$firstname = $this->Session->read('User.firstname');
		$lastname = $this->Session->read('User.lastname');
		$this->set('user_id', $user_id);
		$this->set('firstname', $firstname);
		$this->set('lastname', $lastname);
		$seller_id = null;
		if(!empty($this->params['named']['seller_id'])){
			$seller_id = $this->params['named']['seller_id'];
		}
		// get country name
		$countryArr = $this->Common->getcountries();
		$this->set('countryArr', $countryArr);
		$this->Order->expects(array('OrderItem'));
		
		/* ******************* page limit sction **************** */
		$this->records_per_page =10;
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
		/* ******************* page limit sction **************** */
		$orders = array();
		$this->paginate = array('extra'=>array('user_id'=>$user_id,'action'=>'order_history'),'limit'=>$limit,'fields'=>array('Order.created', 'Order.id','Order.order_number', 'Order.shipping_firstname', 'Order.shipping_lastname', 'Order.shipping_address1', 'Order.shipping_address2', 'Order.shipping_city', 'Order.shipping_country', 'Order.shipping_postal_code', 'Order.order_total_cost'),'order' => array('Order.created DESC'));
		$orderIds = array();
		$creteria = array();
		$order_user_seller = array();
		$this->loadModel('OrderSeller');
		$this->OrderSeller->bindModel(array("belongsTo" =>array('Order' => array(
									'className' => 'Order',
									'foreignKey' => 'order_id',
									'conditions' => array("Order.user_id"=>$user_id),
									'type'=>'inner'
									)
								)
							)
						);
		$orderIds=$this->OrderSeller->find('all',array('conditions'=>array('OrderSeller.shipping_status = "Unshipped"'),'fields'=>array('id','order_id')));
		if(!empty($orderIds)){
		$order_user_seller = count($orderIds);
		
		
		foreach($orderIds  as $key =>$val){
			$order_id[] = $val['OrderSeller']['order_id'];
			
		}
		
		
		$this->Order->bindModel(array('hasMany' =>array('OrderItem'=>array(
									'className' => 'OrderItem',
									'foreignKey' => 'order_id',
								))));
		
		$orderIds =  implode(',',$order_id);
		$creteria = array('Order.deleted'=>'0','Order.payment_status'=>'Y',"Order.id IN ($orderIds)");
		
		
		
		$orders = $this->paginate('Order',$creteria);
		}
		if(!empty($order_user_seller)){
			$this->set('order_user_seller', $order_user_seller);
		}else{
			$this->set('order_user_seller', '0');
		}
		
		$this->set('seller_id', $seller_id);
		$this->set('buyer_orders', $orders);
		if($this->RequestHandler->isAjax()==1){
			$this->render('/elements/orders/view_open_order');
		}
		
		
		
		
		
		
		//$this->Order->OrderItem->expects(array('CancelOrder'));
		//$this->Order->recursive = 2;
		//$orders = $this->Order->find('all',array('conditions'=>array('Order.user_id'=>$user_id,'Order.deleted'=>'0','Order.payment_status'=>'Y'),'fields'=>array('Order.created','Order.order_number', 'Order.id', 'Order.shipping_firstname', 'Order.shipping_lastname', 'Order.shipping_address1', 'Order.shipping_address2', 'Order.shipping_city', 'Order.shipping_country', 'Order.shipping_postal_code', 'Order.order_total_cost'), 'order'=>'Order.created DESC'));
		//$orders = $this->Order->find('all',array('conditions'=>array('Order.deleted'=>'0','Order.payment_status'=>'Y'),'fields'=>array('Order.created','Order.order_number', 'Order.id', 'Order.shipping_firstname', 'Order.shipping_lastname', 'Order.shipping_address1', 'Order.shipping_address2', 'Order.shipping_city', 'Order.shipping_country', 'Order.shipping_postal_code', 'Order.order_total_cost'), 'order'=>'Order.created DESC'));
		/*App::import('Model','OrderSeller');
		$this->OrderSeller = new OrderSeller();
		if(!empty($orders)){
			$j = 0;
			foreach($orders as $order){
				if(!empty($order['OrderItem'])) {
					$i = 0;
					foreach($order['OrderItem'] as $or_item){
						$orderitem_unshipped = $this->OrderSeller->find('first',array('conditions'=>array('OrderSeller.order_id'=>$or_item['order_id'],'OrderSeller.shipping_status'=>'Unshipped','OrderSeller.seller_id'=>$or_item['seller_id'])));
						if(empty($orderitem_unshipped)){
							unset($orders[$j]['OrderItem'][$i]);
						}
						$i++;
					}
				}
				$j++;
			}
		}
		if(!empty($orders)){
			$k = 0;
			foreach($orders as $order){
				if(empty($order['OrderItem'])){
					unset($orders[$k]);
				}
				$k++;
				$order_ids[] = $order['Order']['id'];
			}
			$orderids = implode($order_ids,',');
			$order_user_seller = $this->OrderSeller->find('count',array('conditions'=>array('OrderSeller.order_id IN('.$orderids.')','OrderSeller.seller_id'=>$seller_id)));
		}
		if(!empty($order_user_seller)){
			$this->set('order_user_seller', $order_user_seller);
		}else{
			$this->set('order_user_seller', '0');
		}
		$this->set('seller_id', $seller_id);
		$this->set('buyer_orders', $orders);*/
		
		
	}


	/** 
	@function: file_a_claim
	@description: to verify the seller's account by admin
	@Created by: Tripti Poddar
	@params	
	@Modify: NULL
	@Created Date: Feb 03, 2011
	
	*/
	function file_a_claim($seller_id = null, $order_item_id = null, $prod_id = null, $prod_name = null, $seller_name = null){
		//Configure::write('debug',2);
		if ($this->RequestHandler->isMobile()) {
 			$this->layout = 'mobile/product';
		} else{
			$this->layout='front_popup';
		}
		$this->checkSessionFrontUser();
		$user_id = $this->Session->read('User.id');
		$this->set('seller_id', $seller_id);
		$this->set('order_item_id', $order_item_id);
		$this->set('prod_id', $prod_id);
		App::import('Model','OrderItem');
		$this->OrderItem = new OrderItem;
		$this->OrderItem->expects(array('Order','DispatchedItem','OrderSeller','ProductSeller'));
		$fields = array('OrderItem.id','OrderItem.product_name','OrderItem.seller_id','OrderItem.estimated_delivery_date','OrderItem.order_id','OrderItem.condition_id','OrderItem.seller_name','OrderItem.delivery_method','OrderItem.product_id','Order.id','Order.created','Order.shipping_firstname','Order.shipping_lastname','Order.order_number','Order.shipping_address1','Order.shipping_address2','Order.shipping_city','Order.shipping_country','Order.shipping_postal_code','Order.order_total_cost','OrderSeller.shipping_status','ProductSeller.dispatch_country');
		$result = $this->OrderItem->find('first',array('conditions'=>array('OrderItem.id'=>$order_item_id),'fields'=>$fields));
		//pr($result);
		if(isset($result['OrderItem']['product_name']) ){
			$this->set('prod_name', $result['OrderItem']['product_name']);
		} else if(!empty($prod_name) ){
			$this->set('prod_name', $prod_name);
		} else{
			$this->set('prod_name', '');
		}
		if(isset($result['OrderItem']['seller_name']) ){
			$this->set('seller_name', $result['OrderItem']['seller_name']);
		} else if(!empty($seller_name) ){
			$this->set('seller_name', $seller_name);
		} else{
			$this->set('seller_name', '');
		}
		$this->set('orderItem',$result['OrderItem']);
		$claim_reason = $this->claim_reason();
		$this->set('claim_reason', $claim_reason);
		App::import('Model','Claim');
		$this->Claim = new Claim;
		
		App::import('Model','Message');
		$this->Message = new Message;
		$this->set('selected_reason', $this->data['Order']['reason']);
		if(!empty($this->data)){
			
			$this->data = $this->cleardata($this->data);
			//$this->data = Sanitize::clean($this->data, array('encode' => false));
			
			$this->Order->set($this->data);
			if($this->Order->validates()){
				$order_id = $this->OrderItem->find('first',array('conditions'=>array('OrderItem.id'=>$this->data['Order']['item_id']),'fields'=>array('OrderItem.order_id')));
				$this->data['Claim']['user_id'] = $user_id;
				$this->data['Claim']['reason_id'] = $this->data['Order']['reason'];
				$this->data['Claim']['order_item_id'] = $this->data['Order']['item_id'];
				$this->data['Claim']['order_id'] = $order_id['OrderItem']['order_id'];
				$this->data['Claim']['product_id'] = $this->data['Order']['prod_id'];
				$this->data['Claim']['seller_id'] = $this->data['Order']['seller_id'];
				$this->data['Claim']['comments'] = $this->data['Order']['comment'];
				$this->Claim->set($this->data);
				if($this->Claim->save($this->data)) {
					/*$this->data['Message']['from_user_id'] = $user_id;
					$this->data['Message']['to_user_id'] = $this->data['Claim']['seller_id'];
					$this->data['Message']['message'] = $this->data['Claim']['comments'];
					$this->data['Message']['order_item_id'] = $this->data['Claim']['order_item_id'];
					$this->data['Message']['from_read_status'] = 1;
					$this->Message->set($this->data);
					$this->Message->save();*/
						
					/** FUNCTION CALL $this->data['Message']['to_user_id']**/
					$send_email_messages = $this->Common->sendEmailAlert($this->data['Message']['to_user_id']);
					
					$this->sendClaimMailtoSeller();
					$this->Session->setFlash('Claim filed successfully.');
					$_SESSION['custom_msg'] = '<div id="flashMessage" class="message">Claim filed successfully.</div>';
					echo "<script type=\"text/javascript\">setTimeout('parent.jQuery.fancybox.close()',100); parent.location.reload(true);</script>";
				} else {
					$this->Session->setFlash('An error occurred while saving your claim. Please try again or contact Customer Support at '.Configure::read('phone').'.','default',array('class'=>'flashError'));
				}
			} else{
				$this->set('errors',$this->Order->validate);
			}
		}
	}


	/** 
	@function: track_your_order
	@description: to verify the seller's account by admin
	@Created by: Tripti Poddar
	@params	
	@Modify: NULL
	@Created Date: Feb 09, 2011
	*/
	function track_your_order($seller_id = null, $order_item_id = null, $prod_id = null, $prod_name = null, $seller_name = null){
		if ($this->RequestHandler->isMobile()) {
 			$this->layout = 'mobile/product';
		} else{
			$this->layout='front_popup';
		}
		$this->checkSessionFrontUser();
		$user_id = $this->Session->read('User.id');
		$this->set('seller_id', $seller_id);
		$this->set('order_item_id', $order_item_id);
		$this->set('prod_id', $prod_id);
		$this->set('prod_name', $prod_name);
		$this->set('seller_name', $seller_name);
		// get country name
		$countryArr = $this->Common->getcountries();
		$this->set('countryArr', $countryArr);
		$carrierArr = $this->Common->getcarriers();
		$this->set('carrierArr', $carrierArr);
		App::import('Model','OrderItem');
		$this->OrderItem = new OrderItem;
		$this->OrderItem->expects(array('Order','DispatchedItem','OrderSeller','ProductSeller'));
		$fields = array('OrderItem.id','OrderItem.product_name','OrderItem.seller_id','OrderItem.estimated_delivery_date','OrderItem.order_id','OrderItem.condition_id','OrderItem.seller_name','OrderItem.delivery_method','OrderItem.product_id','Order.id','Order.created','Order.shipping_firstname','Order.shipping_lastname','Order.order_number','Order.shipping_address1','Order.shipping_address2','Order.shipping_city','Order.shipping_country','Order.shipping_postal_code','Order.order_total_cost','OrderSeller.shipping_status','ProductSeller.dispatch_country');
		$result = $this->OrderItem->find('first',array('conditions'=>array('OrderItem.id'=>$order_item_id),'fields'=>$fields));
		$this->set('result', $result);
	}
	

	/** 
	@function: returnitem
	@description: to return an item from a order
	@Created by: Ramanpreet Pal
	@params	
	@Modify: NULL
	@Created Date: 
	*/
	function returnitem($itemid = null){
		$this->checkSessionFrontUser();
		$user_id = $this->Session->read('User.id');
		$firstname = $this->Session->read('User.firstname');
		$lastname = $this->Session->read('User.lastname');
		$emailuser = $this->Session->read('User.email');
		$this->set('user_id', $user_id);
		$this->set('firstname', $firstname);
		$this->set('lastname', $lastname);
		$defaultItem = 0;
		// get country name
		$countryArr = $this->Common->getcountries();
		$this->set('countryArr', $countryArr);
		$this->layout = 'ajax';
		if(!empty($this->data)) {
			
			$this->data = $this->cleardata($this->data);
			//$this->data = Sanitize::clean($this->data, array('encode' => false));
			
			if((!empty($this->data['Order']['quantity'.$itemid])) && (!empty($this->data['Order']['feedback'.$itemid]))){
				App::import('Model','User');
				$this->User = new User;
				App::import('Model','Message');
				$this->Message = new Message;
				$this->User->expects(array('Seller'));
				$seller_info = $this->User->find('first',array('conditions'=>array('User.id'=>$this->data['Order']['seller_id'.$itemid]),'fields'=>array('User.id','User.title','User.firstname','User.lastname','User.email','Seller.business_display_name')));
				if(is_numeric($this->data['Order']['quantity'.$itemid]) === TRUE)  {
					App::import('Model','DispatchedItem');
					$this->DispatchedItem = new DispatchedItem;
					App::import('Model','OrderReturn');
					$this->OrderReturn = new OrderReturn;
					$sumdispatched_item = $this->DispatchedItem->find('all',array('conditions'=>array('DispatchedItem.order_item_id'=>$this->data['Order']['item_id'.$itemid]),'fields'=>array('SUM(DispatchedItem.quantity) as total_dispatched')));
					if(!empty($sumdispatched_item[0][0]['total_dispatched'])){
						$sumdispatched_item = $sumdispatched_item[0][0]['total_dispatched'];
					} else{

					$sumdispatched_item = 0;
					}
					$sumreturned_item = $this->OrderReturn->find('all',array('conditions'=>array('OrderReturn.order_item_id'=>$this->data['Order']['item_id'.$itemid]),'fields'=>array('SUM(OrderReturn.quantity) as total_returned')));
					if(!empty($sumreturned_item[0][0]['total_returned'])){
						$sumreturned_item = $sumreturned_item[0][0]['total_returned'];
					} else{
					$sumreturned_item = 0;
					}
					$remaining_dispatched_items =0;
					$remaining_dispatched_items = $sumdispatched_item-$sumreturned_item;
					
					if($this->data['Order']['quantity'.$itemid] <= $remaining_dispatched_items) {
						$this->data['OrderReturn']['user_id'] = $user_id;
						$this->data['OrderReturn']['seller_id'] = $this->data['Order']['seller_id'.$itemid];
						$this->data['OrderReturn']['quantity'] = $this->data['Order']['quantity'.$itemid];
						$this->data['OrderReturn']['comments'] = $this->data['Order']['feedback'.$itemid];
						$this->data['OrderReturn']['order_id'] = $this->data['Order']['id'.$itemid];
						$this->data['OrderReturn']['order_item_id'] = $this->data['Order']['item_id'.$itemid];
						$this->OrderReturn->set($this->data);
						if($this->OrderReturn->save()){
							$this->data['Message']['from_user_id'] = $user_id;
							$this->data['Message']['to_user_id'] = $this->data['Order']['seller_id'.$itemid];
							$this->data['Message']['message'] = $this->data['OrderReturn']['comments'];
							$this->data['Message']['order_item_id'] = $this->data['OrderReturn']['order_item_id'];
							$this->data['Message']['from_read_status'] = 1;
							$this->Message->set($this->data);
							$this->Message->save();
							/*SENT EMAIL ALERT $this->data['Message']['to_user_id']*/
							$send_email_messages = $this->Common->sendEmailAlert($this->data['Message']['to_user_id']);
							/** Send email after return **/
							$this->Email->smtpOptions = array(
								'host' => Configure::read('host'),
								'username' =>Configure::read('username'),
								'password' => Configure::read('password'),
								'timeout' => Configure::read('timeout')
							);
							
							$this->Email->from = Configure::read('fromEmail');
							//$this->Email->replyTo=Configure::read('replytoEmail');
							$this->Email->sendAs= 'html';
							$link=Configure::read('siteUrl');
							App::import('Model','EmailTemplate');
							$this->EmailTemplate = new EmailTemplate;
							/**
							table: email_templates
							id: 22
							description: Customer registration
							*/
							$template = $this->EmailTemplate ->find('first',array('conditions'=>array("EmailTemplate .id"=>22),'fields' =>array( 'EmailTemplate.description','EmailTemplate.subject','from_email')));
							if(!empty($template['EmailTemplate']['from_email']))
								$this->Email->from = $template['EmailTemplate']['from_email'];
							$data=$template['EmailTemplate']['description'];
							$data = str_replace('[SellersDisplayName]',$seller_info['Seller']['business_display_name'],$data);
							$data = str_replace('[CustomerFirstName]',$firstname,$data);
							$data = str_replace('[CustomerLastName]',$lastname,$data);
							
							$or_number = $this->get_order_number($this->data['OrderReturn']['order_id']);
							//Following 2 lines is added to make link on order-number @Oct 17
							$orderId = base64_encode($this->data['OrderReturn']['order_id']);
							$or_number = '<a href="'.SITE_URL.'sellers/order_details/'.$orderId.'?utm_source=Returns+Marketplace+Order&amp;utm_medium=email">'.$or_number.'</a>';
														
							$data = str_replace('[OrderNumber]',$or_number,$data);
							$data = str_replace('[customeremailaddress]',$emailuser,$data);
							$data = str_replace('[Qty]',$this->data['OrderReturn']['quantity'],$data);
							$data = str_replace('[ItemName]',$this->data['Order']['item_name'.$itemid],$data);
							$data = str_replace('[Price]',$this->data['Order']['price'.$itemid],$data);
							$data = str_replace('[Reason]',nl2br($this->data['Order']['feedback'.$itemid]),$data);
							if($this->data['Order']['delivery_method'.$itemid] == 'E'){
								$delivery_method = 'Express';
							} else {
								$delivery_method = 'Standard';
							}
							$data = str_replace('[DeliveryMethodSelected]',$delivery_method,$data);
							$or_number = $this->get_order_number($this->data['OrderReturn']['order_id']);
							$template['EmailTemplate']['subject'] = str_replace('[OrderNumber]',$or_number,$template['EmailTemplate']['subject']);
							$this->Email->subject = $template['EmailTemplate']['subject'];
							$this->set('data',$data);
							$this->Email->to = $seller_info['User']['email'];
							/******import emailTemplate Model and get template****/
							$this->Email->template='commanEmailTemplate';
							if($this->Email->send()) {
								//$this->Session->setFlash('Request has been sent successfully.');
							}
						}
						$defaultItem = 'returned';
						$this->data['Order']['quantity'.$itemid] = '';
						$this->data['Order']['feedback'.$itemid] = '';
						//$this->Session->setFlash('Request sent successfully.');
					} else {
						$defaultItem = $itemid;
						$this->Session->setFlash('Quantity should be less than or equal  to (ordered quantity - already returned quantity).','default',array('class'=>'flashError'));
					}
				} else {
					$defaultItem = $itemid;
					$this->Session->setFlash('Please enter vaild quantity.','default',array('class'=>'flashError'));
				}
			} else{
				$defaultItem = $itemid;
				
				if(empty($this->data['Order']['feedback'.$itemid]))
				$this->Session->setFlash('Please enter Comment.','default',array('class'=>'flashError'));
				if(empty($this->data['Order']['quantity'.$itemid]))
				$this->Session->setFlash('Please enter select some quantity.','default',array('class'=>'flashError'));
			}
		}
		App::import('Model','OrderItem');
		$this->OrderItem = new OrderItem;

		$this->OrderItem->expects(array('Product'));

		$order_item = $this->OrderItem->find('first',array('conditions'=>array('OrderItem.id'=>$itemid)));

		$itemVal['id'] = $order_item['OrderItem']['id'];
		$itemVal['order_id'] = $order_item['OrderItem']['order_id'];
		$order_number_info = $this->Order->find('first',array('conditions'=>array('Order.id'=>$order_item['OrderItem']['order_id']),'fields'=>array('Order.order_number')));
		$itemVal['order_number'] = $order_number_info['Order']['order_number'];
		$itemVal['seller_id'] = $order_item['OrderItem']['seller_id'];
		$itemVal['product_id'] = $order_item['OrderItem']['product_id'];
		$itemVal['condition_id'] = $order_item['OrderItem']['condition_id'];
		$itemVal['quantity'] = $order_item['OrderItem']['quantity'];
		$itemVal['price'] = $order_item['OrderItem']['price'];
		$itemVal['delivery_method'] = $order_item['OrderItem']['delivery_method'];
		$itemVal['estimated_delivery_date'] = $order_item['OrderItem']['estimated_delivery_date'];
		$itemVal['giftwrap'] = $order_item['OrderItem']['giftwrap'];
		$itemVal['giftwrap_cost'] = $order_item['OrderItem']['giftwrap_cost'];
		$itemVal['gift_note'] = $order_item['OrderItem']['gift_note'];
		$itemVal['product_name'] = $order_item['OrderItem']['product_name'];
		$itemVal['seller_name'] = $order_item['OrderItem']['seller_name'];
		$itemVal['Product'] = $order_item['Product'];
			
		if(empty($itemVal['id'])){
			$itemVal['id'] = $itemid;
		}
		$this->set('defaultItem',$defaultItem);
		$this->set('itemVal', $itemVal);
		if ($this->RequestHandler->isMobile()) {
			$this->viewPath = 'elements/mobile/orders' ;
		}else{
			$this->viewPath = 'elements/orders' ;
		}
			$this->render('returnitems');
	}

	/** 
	@function: cancel
	@description: to cancel an item from a order in fancybox
	@Created by: Ramanpreet Pal
	@params	
	@Modify: NULL
	@Created Date: 
	*/
	function cancel($order_item_id= null,$order_id = null,$seller_id = null,$product_id = null){
		
		$this->checkSessionFrontUser();
		$user_id = $this->Session->read('User.id');
		if ($this->RequestHandler->isMobile()) {
 			$this->layout = 'mobile/product';
		} else{
			$this->layout = 'front_popup';
		}
		$reasons = $this->Common->getcancel_reasons_buyer();
		$this->set('reasons',$reasons);
		App::import('Model','Product');
		$this->Product = new Product;
		App::import('Model','CancelOrder');
		$this->CancelOrder = new CancelOrder;
		App::import('Model','Message');
		$this->Message = new Message;
		
		App::import('Model','OrderItem');
		$this->OrderItem = new OrderItem;
		if(!empty($this->data)){
			
			$this->data = $this->cleardata($this->data);
			//$this->data = Sanitize::clean($this->data, array('encode' => false));
			
			$this->CancelOrder->set($this->data);
			if($this->CancelOrder->validates()){
				if($this->CancelOrder->save()){
					/* TO STORE MESSAGE */
					$this->data['Message']['from_user_id'] = $user_id;
					$this->data['Message']['to_user_id'] = $this->data['CancelOrder']['seller_id'];
					$this->data['Message']['message'] = $this->data['CancelOrder']['comment'];
					$this->data['Message']['order_item_id'] = $this->data['CancelOrder']['order_item_id'];
					$this->data['Message']['from_read_status'] = 1;
					
					$this->Message->set($this->data);
					
					$this->Message->save();
					
					/*SENT EMAIL ALERT $this->data['CancelOrder']['seller_id']*/
					$send_email_messages = $this->Common->sendEmailAlert($this->data['CancelOrder']['seller_id']);
					
					/* TO STORE MESSAGE */
					
					$this->sendmailToCustomer();
					$this->sendmailToSeller();
					
					$this->Session->setFlash('Cancel order request has sent successfully.');
					if ($this->RequestHandler->isMobile()) {
						$this->redirect('view_open_orders');
					}else{
						$_SESSION['custom_msg'] = '<div id="flashMessage" class="message">Cancel order request has sent successfully.</div>';
						echo "<script type=\"text/javascript\">setTimeout('parent.jQuery.fancybox.close()',100);parent.location.reload(true);</script>";
					}
					
				} else{
					$this->Session->setFlash('Information not updated, please recheck and try again', 'default', array('class'=>'flashError'));
				}
			} else{
				$this->set('errors',$this->CancelOrder->validate);
			}
		} else{
			$this->data['CancelOrder']['order_item_id'] = $order_item_id;
			$this->data['CancelOrder']['order_id'] = $order_id;
			$this->data['CancelOrder']['seller_id'] = $seller_id;
			$this->data['CancelOrder']['product_id'] = $product_id;
		}

		$pro_name = $this->Product->find('first',array('conditions'=>array('Product.id'=>$this->data['CancelOrder']['product_id']),'fields'=>array('Product.product_name')));
		$this->set('pro_name',$pro_name['Product']['product_name']);
		$this->set('product_id',$product_id);
		
		$item_seller_info = $this->OrderItem->find('first',array('conditions'=>array('OrderItem.id'=>$order_item_id),'fields'=>array('OrderItem.condition_id','OrderItem.seller_name','OrderItem.product_id','OrderItem.seller_id')));
		$this->set('item_seller_info',$item_seller_info);
		$order_number = $this->get_order_number($order_id);
		$this->set('order_number',$order_number);
	}

	/** 
	@function: sendmailToCustomer
	@description: to send mail to customers when that customer sends a cancel item request
	@Created by: Ramanpreet Pal
	@params	
	@Modify: NULL
	@Created Date: 
	*/
	function sendmailToCustomer(){
		$this->Email->smtpOptions = array(
			'host' => Configure::read('host'),
			'username' =>Configure::read('username'),
			'password' => Configure::read('password'),
			'timeout' => Configure::read('timeout')
		);
		
		$this->Email->sendAs= 'html';
		$link=Configure::read('siteUrl');
		App::import('Model','OrderItem');
		$this->OrderItem = new OrderItem;
		App::import('Model','Order');
		$this->Order = new Order;

		$item_info = $this->OrderItem->find('first',array('conditions'=>array('OrderItem.id'=>$this->data['CancelOrder']['order_item_id'])));

		$sellerInfo = $this->Common->getSellerInfo($item_info['OrderItem']['seller_id']);
		$this->Order->expects(array('UserSummary'));
		$order_info = $this->Order->find('first',array('conditions'=>array('Order.id'=>$this->data['CancelOrder']['order_id'])));

		$link=Configure::read('siteUrl');
		App::import('Model','EmailTemplate');
		$this->EmailTemplate = new EmailTemplate;
		/**
		table: email_templates
		id: 10
		description: Customer Cancel Item
		*/
		$customer_template = $this->EmailTemplate ->find('first',array('conditions'=>array("EmailTemplate .id"=>10),'fields' =>array( 'EmailTemplate.description','EmailTemplate.subject','EmailTemplate.from_email')));

		$this->Email->from = @$customer_template['EmailTemplate']['from_email'];
		$customer_date = $customer_template['EmailTemplate']['description'];

		//$customer_date = str_replace('[SellersDisplayName]',$item_info['OrderItem']['seller_name'],$customer_date);
		/*== Updated Oct 10 :: begin==*/
		$seller_name = str_replace(array(' ','&'),array('-','and'),html_entity_decode($sellerInfo['Seller']['business_display_name'], ENT_NOQUOTES, 'UTF-8'));
		$customer_date = str_replace('[SellersDisplayName]',"<a href=\"".SITE_URL."sellers/".$seller_name."/summary/".$item_info['OrderItem']['seller_id']."/".$item_info['OrderItem']['product_id']."?utm_source=Cancel+Items+from+Orders&amp;utm_medium=email\">".$item_info['OrderItem']['seller_name']."</a>",$customer_date);
		/*== Updated Oct 10 :: end==*/
		$or_number = $this->get_order_number($this->data['CancelOrder']['order_id']);
		//$customer_date = str_replace('[OrderNumber]',$or_number,$customer_date);
		/*== Updated Oct 10 :: begin==*/
		$customer_date = str_replace('[OrderNumber]',	'<a href="'.SITE_URL.'orders/view_open_orders?utm_source=Cancel+Items+from+Orders&amp;utm_medium=email">'.$or_number.'</a>',$customer_date);
		/*== Updated Oct 10 :: end==*/
		$customer_date = str_replace('[customeremailaddress]',$order_info['UserSummary']['email'],$customer_date);
		$customer_date = str_replace('[Qty]',$item_info['OrderItem']['quantity'],$customer_date);
		$customer_date = str_replace('[Price]',CURRENCY_SYMBOL.number_format($item_info['OrderItem']['price'],2),$customer_date);
		$customer_date = str_replace('[ItemName]',$item_info['OrderItem']['product_name'],$customer_date);
		if($item_info['OrderItem']['delivery_method'] == 'E'){
			$delivery_method = 'Express';
		} else{
			$delivery_method = 'Standard';
		}
		$customer_date = str_replace('[DeliveryMethodSelected]',$delivery_method,$customer_date);

		if(!empty($item_info['OrderItem']['estimated_delivery_date']))
			$estimated_delivery_date = date('d F Y',strtotime($item_info['OrderItem']['estimated_delivery_date']));
		else
			$estimated_delivery_date = '';

		$customer_date = str_replace('[DateMonthYear]',$estimated_delivery_date,$customer_date);

		$this->Email->subject = $customer_template['EmailTemplate']['subject'];
		$this->set('data',$customer_date);
		$this->Email->to = $order_info['UserSummary']['email'];
		
		/******import emailTemplate Model and get template****/
		
		$this->Email->template='commanEmailTemplate';
		$this->Email->replyTo = @$customer_template['EmailTemplate']['from_email'];
		//echo '<pre>'; print_r($this->Email); die;
		$this->Email->send();

	}

	/** 
	@function: sendmailToSeller
	@description: to send mail to seller when a customer sends a cancel item request
	@Created by: Ramanpreet Pal
	@params	
	@Modify: NULL
	@Created Date: 
	*/
	function sendmailToSeller(){
		$this->Email->smtpOptions = array(
			'host' => Configure::read('host'),
			'username' =>Configure::read('username'),
			'password' => Configure::read('password'),
			'timeout' => Configure::read('timeout')
		);
		//$this->Email->replyTo=Configure::read('replytoEmail');
		
		$this->Email->sendAs= 'html';

		App::import('Model','OrderItem');
		$this->OrderItem = new OrderItem;
		App::import('Model','Order');
		$this->Order = new Order;
		$this->OrderItem->expects(array('SellerSummary'));
		$item_info = $this->OrderItem->find('first',array('conditions'=>array('OrderItem.id'=>$this->data['CancelOrder']['order_item_id'])));

		$this->Order->expects(array('UserSummary'));

		$order_info = $this->Order->find('first',array('conditions'=>array('Order.id'=>$this->data['CancelOrder']['order_id'])));
		$link=Configure::read('siteUrl');
		App::import('Model','EmailTemplate');
		$this->EmailTemplate = new EmailTemplate;
		/**
		table: email_templates
		id: 21
		description: Seller Cancel Item
		*/
		$template = $this->EmailTemplate ->find('first',array('conditions'=>array("EmailTemplate .id"=>21),'fields' =>array( 'EmailTemplate.description','EmailTemplate.subject','EmailTemplate.from_email')));

		$data=$template['EmailTemplate']['description'];
		$data = str_replace('[SellersDisplayName]',$item_info['OrderItem']['seller_name'],$data);
		
		//for link to seller name
		$product_id = $item_info["OrderItem"]["product_id"];
		$seller_id = $item_info["OrderItem"]["seller_id"];
		$link_to_seller = '<a href="'.SITE_URL.'sellers/summary/'.$seller_id.'/'.$product_id.'?utm_source=Cancelled+Items+from+Your+Marketplace+Order&amp;utm_medium=email">'.$item_info['OrderItem']['seller_name'].'</a>';
		$data = str_replace('[LinkToSellersDisplayName]',$link_to_seller,$data);
		
		
		$this->Email->from = $template['EmailTemplate']['from_email'];
		
		$or_number = $this->get_order_number($this->data['CancelOrder']['order_id']);
		$or_number ='<a href="'.SITE_URL.'sellers/orders?utm_source=Cancelled+Items+from+Your+Marketplace+Order&amp;utm_medium=email">'.$or_number.'</a>';
		$data = str_replace('[OrderNumber]',$or_number,$data);
		$data = str_replace('[customeremailaddress]',$order_info['UserSummary']['email'],$data);
		$data = str_replace('[Qty]',$item_info['OrderItem']['quantity'],$data);
		$data = str_replace('[Price]',CURRENCY_SYMBOL.number_format($item_info['OrderItem']['price'],2),$data);
		$data = str_replace('[ItemName]',$item_info['OrderItem']['product_name'],$data);
		if($item_info['OrderItem']['delivery_method'] == 'E'){
			$delivery_method = 'Express';
		} else{
			$delivery_method = 'Standard';
		}
		$data = str_replace('[DeliveryMethodSelected]',$delivery_method,$data);
		

		if(!empty($item_info['OrderItem']['estimated_delivery_date']))
			$estimated_delivery_date = date('d F Y',strtotime($item_info['OrderItem']['estimated_delivery_date']));
		else
			$estimated_delivery_date = '';

		$data = str_replace('[DateMonthYear]',$estimated_delivery_date,$data);
		$or_number = $this->get_order_number($this->data['CancelOrder']['order_id']);
		$template['EmailTemplate']['subject'] = str_replace('[OrderNumber]',$or_number,$template['EmailTemplate']['subject']);
		$this->Email->subject = $template['EmailTemplate']['subject'];
		
		$this->Email->to = $item_info['SellerSummary']['email'];
		//$this->Email->to = 'gyanprakaash@hotmail.com';
		/******import emailTemplate Model and get template****/
		$this->Email->template='commanEmailTemplate';

		$this->set('data',$data);
		$this->Email->send();
	}

	/** 
	@function: sendClaimMailtoSeller
	@description: to send mail to seller when a customer sends a claim against him
	@Created by: Ramanpreet Pal
	@params	
	@Modify: NULL
	@Created Date: 
	*/
	function sendClaimMailtoSeller(){
		$this->Email->smtpOptions = array(
			'host' => Configure::read('host'),
			'username' =>Configure::read('username'),
			'password' => Configure::read('password'),
			'timeout' => Configure::read('timeout')
		);
		//$this->Email->replyTo=Configure::read('replytoEmail');
		$this->Email->sendAs= 'html';
		App::import('Model','OrderItem');
		$this->OrderItem = new OrderItem;
		$this->OrderItem->expects(array('SellerSummary'));
		$item_info = $this->OrderItem->find('first',array('conditions'=>array('OrderItem.id'=>$this->data['Claim']['order_item_id'])));
		$link=Configure::read('siteUrl');
		App::import('Model','EmailTemplate');
		$this->EmailTemplate = new EmailTemplate;
		/**
		table: email_templates
		id: 24
		description: Seller Claim Item mail
		*/
		$template = $this->Common->getEmailTemplate(24);
		$this->Email->from = $template['EmailTemplate']['from_email'];

		$data=$template['EmailTemplate']['description'];
		$or_number = $this->get_order_number($item_info['OrderItem']['order_id']);
		
		//Following 2 lines is added to make link on order-number @Oct 17
		$orderId = base64_encode($item_info['OrderItem']['order_id']);
		$or_number = '<a href="'.SITE_URL.'sellers/order_details/'.$orderId.'?utm_source=Claim+Filed&amp;utm_medium=email">'.$or_number.'</a>';
		
				
		$data = str_replace('[OrderNumber]',$or_number,$data);
		$template['EmailTemplate']['subject'] = str_replace('[SellerDisplayName]',$item_info['OrderItem']['seller_name'],$template['EmailTemplate']['subject']);
		$data = str_replace('[SellersDisplayName]',$item_info['OrderItem']['seller_name'],$data);
		$this->Email->subject = $template['EmailTemplate']['subject'];
		$this->set('data',$data);
// pr($data);
// 		pr($item_info); die;
		$this->Email->to = $item_info['SellerSummary']['email'];
		/******import emailTemplate Model and get template****/
		$this->Email->template='commanEmailTemplate';
		$this->Email->send();
	}
	
	/** 
	@function: purchaseorder_slip
	@description: to print a purchase order slip
	@Created by: Ramanpreet Pal
	@Created: 
	@Modify:  
	*/
	function purchaseorder_slip($order_id = null) {
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
		$order_details = $this->get_order_details($order_id);
		$this->set('order_details',$order_details);
	}


	/** 
	@function: get_order_details
	@description: to fetch details for an given order_id
	@Created by: Ramanpreet Pal
	@Created:  7 March 2011
	@Modify:  
	*/
	function get_order_details($order_id = null){
		App::import('Model','Order');
		$this->OrderSeller = new Order();
		$this->Order->expects(array('UserSummary'));
		$order_details = $this->Order->find('first',array('conditions'=>array('Order.id'=>$order_id)/*,'fields'=>$fields*/));
		App::import('Model','OrderItem');
		$this->OrderItem = new OrderItem();
		if(!empty($order_details)){
			$i = 0;
			$this->OrderItem->expects(array('SellerSummary'));
			$items = $this->OrderItem->find('all',array('conditions'=>array('OrderItem.order_id'=>$order_details['Order']['id']),'fields'=>array('distinct(OrderItem.id)','OrderItem.order_id','OrderItem.seller_id','OrderItem.product_id','OrderItem.condition_id','OrderItem.quantity','OrderItem.price','OrderItem.delivery_method','OrderItem.delivery_cost','OrderItem.estimated_delivery_date','OrderItem.giftwrap','OrderItem.giftwrap_cost','OrderItem.gift_note','OrderItem.product_name','OrderItem.quick_code','OrderItem.seller_name','SellerSummary.id','SellerSummary.firstname','SellerSummary.lastname')));
			$i = 0;
			if(!empty($items)){
				foreach($items as $item) {
					$all_item[$i] = $item['OrderItem'];
					$all_item[$i]['SellerSummary'] = $item['SellerSummary'];
					$i++;
				}
				$order_details['Items'] = $all_item;
			}
			$order_number_info = $this->Order->find('first',array('conditions'=>array('Order.id'=>$order_details['Order']['id']),'fields'=>array('Order.order_number')));
			$order_number = $order_number_info['Order']['order_number'];
			$order_details['Order']['order_number'] = $order_number;
		}
		return $order_details;
	}


	/** 
	@function: admin_sendFraudMail
	@description: to send email to buyer and seller after declearing an ordre fraud from admin
	@Created by: Ramanpreet Pal
	@Created:  10 March 2011
	@Modify:  
	*/
	function admin_sendFraudMail($order_id = null){
			
		if(!empty($order_id)){
			
			/*App::import('Model','Order');
			$this->Order = new Order();
			
			$this->Order->expects(array('OrderItem','UserSummary','OrderSeller'));
			$this->Order->OrderItem->expects(array('SellerSummary'));
			$this->Order->OrderSeller->expects(array('SellerSummary'));
			$this->Order->recursive = 2;*/
			
			
			$order_detail = $this->Order->find('first',array('conditions'=>array('Order.id'=>$order_id),'fields'=>array('Order.id','Order.user_id','UserSummary.id','UserSummary.firstname','UserSummary.lastname','UserSummary.email')));
			
			$this->Email->smtpOptions = array(
				'host' => Configure::read('host'),
				'username' =>Configure::read('username'),
				'password' => Configure::read('password'),
				'timeout' => Configure::read('timeout')
			);
			
			//$this->Email->replyTo=Configure::read('replytoEmail');
			$this->Email->sendAs= 'html';
			$link=Configure::read('siteUrl');
			App::import('Model','EmailTemplate');
			$this->EmailTemplate = new EmailTemplate;
			/**
			table: email_templates
			id: 27
			description: Mail to customer and seller for fruad order
			*/
			$template = $this->Common->getEmailTemplate(27);
			//pr($template); exit;
			$this->Email->from = $template['EmailTemplate']['from_email'];
			
			//$data = $template['EmailTemplate']['description'];
			$or_number = $this->get_order_number($order_detail['Order']['id']);
			
			//Following 2 lines is added to make link on order-number @Oct 17
			$orderId = base64_encode($order_detail['Order']['id']);
			$or_number = '<a href="'.SITE_URL.'sellers/order_details/'.$orderId.'?utm_source=Choiceful+Order+Cancellation+Band+Fraud+Detection+Team&amp;utm_medium=email">'.$or_number.'</a>';
			
			//$data = str_replace('[OrderNumber]',$or_number,$data);
			//$data = str_replace('[customeremailaddress]',$order_detail['UserSummary']['email'],$data);
			
			if(!empty($order_detail['OrderSeller'])){
				
				foreach($order_detail['OrderSeller'] as $seller_order){
					$str = '';
					$data = '';
					$data = $template['EmailTemplate']['description'];
					$data = str_replace('[OrderNumber]',$or_number,$data);
					$data = str_replace('[customeremailaddress]',$order_detail['UserSummary']['email'],$data);
					if(!empty($order_detail['OrderItem'])){
						
						$str = '<table width="100%" cellspacing="2" cellpadding="2" border="0"  style="font-size:9.0pt;font-family:Arial,sans-serif;">';
						foreach($order_detail['OrderItem'] as $item){
							if($seller_order['seller_id'] == $item['seller_id']){
							
							if($item['delivery_method'] == 'E'){
								$delivery_method = 'Express';
							} else{
								$delivery_method = 'Standard';
							}
							if(!empty($item['estimated_delivery_date'])){
								$estimated_delivery_date = date('d F, Y');
							} else{
								$estimated_delivery_date = '-';
							}
							
							$soldBy = '<a href="'.SITE_URL.'sellers/summary/'.$item['seller_id'].'/'.$item['id'].'?utm_source=Choiceful+Order+Cancellation+Band+Fraud+Detection+Team&amp;utm_medium=email">'.$item['seller_name'].'</a>';
							
							$str = $str.'<tr><td>'.$item['quantity'].' '.$item['product_name'].' '.CURRENCY_SYMBOL.number_format($item['price'],2).'</td></tr>';
							$str = $str.'<tr><td><strong>Delivery Method: </strong>'.$delivery_method.'</td></tr>';
							$str = $str.'<tr><td><strong>Delivery Estimate: </strong>'.$estimated_delivery_date.'</td></tr>';
							$str = $str.'<tr><td>Sold by '.$soldBy.'</td></tr>';
							$str = $str.'<tr><td>&nbsp;</td></tr>';
							}
						}
						//$data = str_replace('[CANCELLED_ITEMS_DETAIL]',$str,$data);
						//$this->Email->subject = $template['EmailTemplate']['subject'];
						//$this->set('data',$data);
						$this->Email->to = $order_detail['UserSummary']['email'];
						$this->Email->template='commanEmailTemplate';
						//$this->Email->send();
					}
					$data = str_replace('[CANCELLED_ITEMS_DETAIL]',$str,$data);
					$this->Email->subject = $template['EmailTemplate']['subject'];
					$this->set('data',$data);
					$this->Email->to = $seller_order['SellerSummary']['email'];
					$this->Email->template='commanEmailTemplate';
					$this->Email->send();
						
				}
			}
			
			
			
/*(!empty($order_detail['OrderSeller'])){
				
				foreach($order_detail['OrderSeller'] as $seller_order){
					
					$this->Email->to = $seller_order['SellerSummary']['email'];
					$this->Email->template='commanEmailTemplate';
					$this->Email->send();
				}*/
// 				$str = '<table width="100%" cellspacing="2" cellpadding="2" border="0">';
// 				foreach($order_detail['OrderItem'] as $item){
// 					pr()
// 					//$this->Email->subject = 'SELLERNEWTEST'.$template['EmailTemplate']['subject'];
// 					$this->Email->to = ucfirst($item['SellerSummary']['firstname']).' '.ucfirst($item['SellerSummary']['lastname']).'<'.$item['SellerSummary']['email'].'>';
// 
// 					$this->Email->template='commanEmailTemplate';
// 					$this->Email->send();
// 				}
			//}
			
			
		}
	}


	/**
	@function:admin_cancelled_orders
	@description:listing all ordres that are cancelled by sellers
	@params:NULL
	@Created by: Ramanpreet Pal
	@Modify:NULL
	@Created Date:March 10,2011
	*/
	function admin_cancelled_orders(){
		//Configure::write('debug',2);
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
		}
		$value = '';
		$criteria ='';
		$matchshow = '';
		$fieldname = '';
		/* SEARCHING */
		$reqData = $this->data;
		$options['Order.order_number'] = "Order Number";
		$options['SellerSummary.sellerName'] = "Seller Name";
		$options['Order.id'] = "Order ID";
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
					$Name = explode(' ',$value1);
					$fName = @$Name[0];
					$lName = @$Name[1];
					$creteria_name = '1';
					if(empty($Name[1])){
						$lName = '';
						$creteria_name = "SellerSummary.firstname like '%".trim($fName)."%' OR SellerSummary.lastname like '%".trim($fName)."%'";
					} else {
						$creteria_name = "SellerSummary.firstname like '%".trim($fName)."%' AND SellerSummary.lastname like '%".trim($lName)."%'";
					}
					if(empty($criteria)){
						$criteria .= "(".$creteria_name." OR Order.order_number like '%".$value1."%')";
					} else {
						$criteria .= " and (".$creteria_name." OR Order.order_number like '%".$value1."%')";
					}
				} else {
					if(trim($fieldname)!=''){
						if(isset($value) && $value!=="") {
							if(trim($fieldname) == 'SellerSummary.sellerName'){
								$Name = explode(' ',$value1);
								$fName = @$Name[0];
								$lName = @$Name[1];
								$creteria_name = '1';
								if(empty($Name[1])){
									$lName ='';
									$creteria_name = "SellerSummary.firstname like '%".trim($fName)."%' OR SellerSummary.lastname like '%".trim($fName)."%'";
								} else {
									$creteria_name = "SellerSummary.firstname like '%".trim($fName)."%' AND SellerSummary.lastname like '%".trim($lName)."%'";
								}
								if(empty($criteria)){
									$criteria = "(".$creteria_name.")";
								} else{
									$criteria .= " and (".$creteria_name.")";
								}
							}
							else if(trim($fieldname) == 'Order.id'){
								if(empty($criteria)){
									$criteria = "(".$fieldname." = ".$value1.")";
								} else{
									$criteria .= " and (".$fieldname." = ".$value1.")";
								}
							}
							else{
								if(empty($criteria)){
									$criteria = "(".$fieldname." LIKE '%".$value1."%')";
								} else{
									$criteria .= " and (".$fieldname." LIKE '%".$value1."%')";
								}
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
		$sess_limit_name = $this->params['controller']."_cancelled_limit";
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
				'OrderSeller.created DESC'
			),
			'conditions'=>array('OrderSeller.shipping_status'=>'Cancelled'),
			'fields'=>array(
				'OrderSeller.id',
				'OrderSeller.seller_id',
				'OrderSeller.order_id',
				'OrderSeller.created',
				'Order.id',
				'Order.created',
				'Order.order_number',
				'Order.user_id',
				'Order.order_total_cost',
				'Seller.business_display_name',
				'SellerSummary.id',
				'SellerSummary.firstname',
				'SellerSummary.lastname',
				'SellerSummary.email',
			)
		);
		App::import('Model','OrderSeller');
		$this->OrderSeller = new OrderSeller;
		$this->set('listTitle','Manage Cancelled Orders');
		$this->OrderSeller->expects(array('Order','SellerSummary','Seller'));
		$this->OrderSeller->Order->expects(array('UserSummary','CanceledItem'));
		$this->OrderSeller->recursive = 2;
		$cancelled_orders = $this->paginate('OrderSeller',$criteria);
		$this->set('cancelled_orders', $cancelled_orders);
	}


	/**
	@function:admin_refunded_orders
	@description:listing all ordres that are cancelled by sellers
	@params:NULL
	@Created by: Ramanpreet Pal
	@Modify:NULL
	@Created Date:March 10,2011
	*/
	function admin_refunded_orders(){
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
		}
		$value = '';
		$criteria ='1';
		$matchshow = '';
		$fieldname = '';
		/* SEARCHING */
		$reqData = $this->data;
		$options['Order.order_number'] = "Order Number";
		$options['SellerSummary.sellerName'] = "Seller Name";
		$options['UserSummary.userName'] = "Customer Name";
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
					$Name = explode(' ',$value1);
					$fName = @$Name[0];
					$lName = @$Name[1];
					$creteria_name = '1';
					if(empty($Name[1])){
						$lName = '';
						$creteria_name = "SellerSummary.firstname like '%".$fName."%' OR UserSummary.firstname like '%".$fName."%' OR SellerSummary.lastname like '%".$fName."%' OR UserSummary.lastname like '%".$fName."%'";
					} else {
						$creteria_name = "SellerSummary.firstname like '%".$fName."%' AND SellerSummary.lastname like '%".$lName."%' OR UserSummary.firstname like '%".$fName."%' AND UserSummary.lastname like '%".$lName."%'";
					}
					
					$criteria .= " and ".$creteria_name." OR Order.order_number like '%".$value1."%'";
				} else {
					if(trim($fieldname)!=''){
						if(isset($value) && $value!=="") {
							if(trim($fieldname) == 'SellerSummary.sellerName'){
								$Name = explode(' ',$value1);
								$fName = @$Name[0];
								$lName = @$Name[1];
								$creteria_name = '1';
								if(empty($Name[1])){
									$lName ='';
									$creteria_name = "SellerSummary.firstname like '%".$fName."%' OR SellerSummary.lastname like '%".$fName."%'";
								} else {
									$creteria_name = "SellerSummary.firstname like '%".$fName."%' AND SellerSummary.lastname like '%".$lName."%'";
								}
								$criteria .= " and ".$creteria_name;
							} else if(trim($fieldname) == 'UserSummary.userName'){
								$uName = explode(' ',$value1);
								$ufName = @$uName[0];
								$ulName = @$uName[1];
								$creteria_uname = '1';
								if(empty($uName[1])){
									$ulName ='';
									$creteria_uname = "UserSummary.firstname like '%".$ufName."%' OR UserSummary.lastname like '%".$ufName."%'";
								} else {
									$creteria_uname = "UserSummary.firstname like '%".$ufName."%' AND UserSummary.lastname like '%".$ulName."%'";
								}
								$criteria .= " and ".$creteria_uname;
							} else{
								$criteria .= " and ".$fieldname." LIKE  '%".$value1."%'";
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
		$sess_limit_name = $this->params['controller']."_orderRefund_limit";
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
				'Order.created DESC'
			),
			'group' => array(
				'OrderRefund.order_id','OrderRefund.seller_id'
			),
			'fields'=>array(
				'OrderRefund.id',
				'OrderRefund.seller_id',
				'OrderRefund.order_id',
				'OrderRefund.user_id',
				'OrderRefund.reason_id',
				'OrderRefund.created',
				'SUM(OrderRefund.amount) as total_refunded_amount',
				'Order.id',
				'Order.order_number',
				'Order.created','Order.order_number',
				'Seller.business_display_name',
				'SellerSummary.id',
				'SellerSummary.firstname',
				'SellerSummary.lastname',
				'SellerSummary.email',
				'UserSummary.id',
				'UserSummary.firstname',
				'UserSummary.lastname',
				'UserSummary.email',
			)
		);
		App::import('Model','OrderRefund');
		$this->OrderRefund = new OrderRefund;
		$this->set('listTitle','Manage Refunded Orders');
		$this->OrderRefund->expects(array('Order','SellerSummary','UserSummary','Seller'));
		$refunded_orders = $this->paginate('OrderRefund',$criteria);
		
		$totalRefundedOrders = $this->OrderRefund->find('count',array('conditions'=>array($criteria)));
		$this->set('totalRefundedOrders',$totalRefundedOrders);
		
		$this->set('refunded_orders', $refunded_orders);
	}

	function get_order_number($order_id = null){
		$order_number_info = $this->Order->find('first',array('conditions'=>array('Order.id'=>$order_id),'fields'=>array('Order.order_number')));
		if(empty($order_number_info['Order']['order_number']))
			$order_number_info['Order']['order_number'] = '-';
		return $order_number_info['Order']['order_number'];
	}
	
	 /**
	@function:	admin_export_refunded_order
	@description:	Download refunded Oreder
	@params:	
	@Created by: 	Nakul Kumar
	@Modify:	
	@Created Date:	 11 Feb 2013
	*/		
	/*function admin_export_refunded_order(){
				
		$this->checkSessionAdmin();
		App::import('Model','OrderRefund');
		$this->OrderRefund = new OrderRefund;
		$criteria ='1';
				
 			$this->layout = 'layout_admin';
			$totalRefundedOrders = $this->OrderRefund->find('count',array('conditions'=>array($criteria)));
			$limit = $totalRefundedOrders;
		/* ******************* page limit sction **************** */
		/*$this->paginate = array(
			'limit' => $limit,
			'order' => array(
				'OrderRefund.created DESC'
			),
			'group' => array(
				'OrderRefund.order_id','OrderRefund.seller_id'
			),
			'fields'=>array(
				'OrderRefund.id',
				'OrderRefund.seller_id',
				'OrderRefund.order_id',
				'OrderRefund.user_id',
				'OrderRefund.reason_id',
				'OrderRefund.created',
				'SUM(OrderRefund.amount) as total_refunded_amount',
				'Order.id',
				'Order.order_number',
				'Order.created','Order.order_number',
				'Seller.business_display_name',
				'SellerSummary.id',
				'SellerSummary.firstname',
				'SellerSummary.lastname',
				'SellerSummary.email',
				'UserSummary.id',
				'UserSummary.firstname',
				'UserSummary.lastname',
				'UserSummary.email',
			)
		);
		$this->set('listTitle','Manage Refunded Orders');
		$this->OrderRefund->expects(array('Order','SellerSummary','UserSummary','Seller'));
		$refunded_orders = $this->paginate('OrderRefund',$criteria);
		//pr($refunded_orders);

		$categoryList1[0]['Refund']=array('Date/Time of Order' , 'Order ID' , 'Sellers Name', 'Customers Name', 'Refunded Amount', 'Refunded Date');
		$filePath=WWW_ROOT."files/refund_order/refund_order.csv";
		//$filePath = fopen($filePath,"w+");
				
		if(!empty($categoryList1)){
		$Content='';	
		foreach($categoryList1 as $fields1){
			for($k=0;$k<count($fields1);$k++){
				$Content .= $fields1['Refund'][0].",";
				$Content .= $fields1['Refund'][1].",";
				$Content .= $fields1['Refund'][2].",";
				$Content .= $fields1['Refund'][3].",";
				$Content .= $fields1['Refund'][4].",";
				$Content .= $fields1['Refund'][5];
				$Content .= "\n";
			}
		}	
		}
		if(!empty($refunded_orders)){
				$Content1='';	
				foreach($refunded_orders as $refunded_order){
						$Content1 .= date(DATE_TIME_FORMAT,strtotime($refunded_order['Order']['created'])).",";
						$Content1 .= $refunded_order['Order']['order_number'].",";
						$Content1 .= html_entity_decode($refunded_order['Seller']['business_display_name'], ENT_NOQUOTES, 'UTF-8').",";
						$Content1 .= $refunded_order['UserSummary']['firstname'] .' '.$refunded_order['UserSummary']['lastname'].",";
						$Content1 .= $refunded_order[0]['total_refunded_amount'].",";
						$Content1 .= date('d-m-Y H:i:s',strtotime($refunded_order['OrderRefund']['created'])).",";
						$Content1 .= "\n";
				}
			}
		$wholeContent=$Content.$Content1;
		//$fileComp=fwrite($filePath, $wholeContent);
		//fclose($filePath);
		//$filePath="users_".date("Ymd").".csv";
		$filePath="refund_order_".date("Ymd").".csv";
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=".$filePath."");
		header("Pragma: no-cache");
		header("Expires: 0");
		print $wholeContent;
		exit;
		
	}*/
		
	function admin_export_refunded_order($startDate=null, $endDate=null){
			
		$this->checkSessionAdmin();
		App::import('Model','OrderRefund');
		$this->OrderRefund = new OrderRefund;
		$criteria ='1';
				
 			$this->layout = 'layout_admin';
			$totalRefundedOrders = $this->OrderRefund->find('count',array('conditions'=>array($criteria)));
			$limit = $totalRefundedOrders;
		/* ******************* page limit sction **************** */
		
		$this->paginate = array(
			'limit' => $limit,
			'order' => array(
				'OrderRefund.created DESC'
			),
			'group' => array(
				'OrderRefund.order_id','OrderRefund.seller_id'
			),
			'conditions' => array(
			'and' => array(
					array('DATE(OrderRefund.created) <= ' => $endDate,
					      'DATE(OrderRefund.created) >= ' => $startDate
					     )
			    )),
	
			'fields'=>array(
				'OrderRefund.id',
				'OrderRefund.seller_id',
				'OrderRefund.order_id',
				'OrderRefund.user_id',
				'OrderRefund.reason_id',
				'OrderRefund.created',
				'SUM(OrderRefund.amount) as total_refunded_amount',
				'Order.id',
				'Order.order_number',
				'Order.created','Order.order_number',
				'Seller.business_display_name',
				'SellerSummary.id',
				'SellerSummary.firstname',
				'SellerSummary.lastname',
				'SellerSummary.email',
				'UserSummary.id',
				'UserSummary.firstname',
				'UserSummary.lastname',
				'UserSummary.email',
			)
		);
		$this->set('listTitle','Manage Refunded Orders');
		$this->OrderRefund->expects(array('Order','SellerSummary','UserSummary','Seller'));
		$refunded_orders = $this->paginate('OrderRefund',$criteria);
		

		$categoryList1[0]['Refund']=array('Date/Time of Order' , 'Order ID' , 'Sellers Name', 'Customers Name', 'Refunded Amount', 'Refunded Date');
		$filePath=WWW_ROOT."files/refund_order/refund_order.csv";
		//$filePath = fopen($filePath,"w+");
				
		if(!empty($categoryList1)){
		$Content='';	
		foreach($categoryList1 as $fields1){
			for($k=0;$k<count($fields1);$k++){
				$Content .= $fields1['Refund'][0].",";
				$Content .= $fields1['Refund'][1].",";
				$Content .= $fields1['Refund'][2].",";
				$Content .= $fields1['Refund'][3].",";
				$Content .= $fields1['Refund'][4].",";
				$Content .= $fields1['Refund'][5];
				$Content .= "\n";
			}
		}	
		}
		if(!empty($refunded_orders)){
				$Content1='';	
				foreach($refunded_orders as $refunded_order){
						$Content1 .= date(DATE_TIME_FORMAT,strtotime($refunded_order['Order']['created'])).",";
						$Content1 .= $refunded_order['Order']['order_number'].",";
						$Content1 .= html_entity_decode($refunded_order['Seller']['business_display_name'], ENT_NOQUOTES, 'UTF-8').",";
						$Content1 .= $refunded_order['UserSummary']['firstname'] .' '.$refunded_order['UserSummary']['lastname'].",";
						$Content1 .= $refunded_order[0]['total_refunded_amount'].",";
						$Content1 .= date('d-m-Y H:i:s',strtotime($refunded_order['OrderRefund']['created'])).",";
						$Content1 .= "\n";
				}
			}
		$wholeContent=$Content.$Content1;
		//$fileComp=fwrite($filePath, $wholeContent);
		//fclose($filePath);
		//$filePath="users_".date("Ymd").".csv";
		$filePath="refund_order_".date("Ymd").".csv";
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=".$filePath."");
		header("Pragma: no-cache");
		header("Expires: 0");
		print $wholeContent;
		exit;
		
	}
	
	
	/**
	@function:	admin_export_canceled_order
	@description:	Download canceled Oreder
	@params:	
	@Created by: 	Pradeep Kumar
	@Modify:	
	@Created Date:	 08 April 2013
	*/		
	function admin_export_canceled_order($startDate=null, $endDate=null){
		//check that admin is login
		$this->checkSessionAdmin();
		
		App::import('Model','CanceledItem');
		$this->CanceledItem = new CanceledItem;
		$criteria ='1';
				
 		$this->layout = 'layout_admin';
		$totalcanceledOrders = $this->CanceledItem->find('count',array('conditions'=>array($criteria)));
		$limit = $totalcanceledOrders;
		/* ******************* page limit sction **************** */
		
		$this->paginate = array(
			'limit' => $limit,
			'order' => array(
				'OrderSeller.created DESC'
			),
			'conditions' => array(
			'and' => array(
					array('DATE(OrderSeller.created) <= ' => $endDate,
					      'DATE(OrderSeller.created) >= ' => $startDate
					     ),
					'OrderSeller.shipping_status'=>'Cancelled'
			    )),
			'fields'=>array(
				'OrderSeller.id',
				'OrderSeller.seller_id',
				'OrderSeller.order_id',
				'OrderSeller.created',
				'Order.id',
				'Order.created',
				'Order.order_number',
				'Order.user_id',
				'Order.order_total_cost',
				'Seller.business_display_name',
				'SellerSummary.id',
				'SellerSummary.firstname',
				'SellerSummary.lastname',
				'SellerSummary.email',
			)
		);
		App::import('Model','OrderSeller');
		$this->OrderSeller = new OrderSeller;
		$this->set('listTitle','Manage Cancelled Orders');
		$this->OrderSeller->expects(array('Order','SellerSummary','Seller'));
		$this->OrderSeller->Order->expects(array('UserSummary','CanceledItem'));
		$this->OrderSeller->recursive = 3;
		$this->set('listTitle','Manage Cancelled Orders');
		$cancelled_orders = $this->paginate('OrderSeller',$criteria);
		//pr($cancelled_orders);
		//exit;

		$categoryList1[0]['Canceled']=array('Date/Time of Order' , 'Order No.' , 'Sellers Name', 'Customers Name', 'Cancelled Date/Time');
		//$filePath=WWW_ROOT."files/cancel_order.csv";
		
		if(!empty($categoryList1)){
		$Content='';	
		foreach($categoryList1 as $fields1){
			for($k=0;$k<count($fields1);$k++){
				$Content .= $fields1['Canceled'][0].",";
				$Content .= $fields1['Canceled'][1].",";
				$Content .= $fields1['Canceled'][2].",";
				$Content .= $fields1['Canceled'][3].",";
				$Content .= $fields1['Canceled'][4];
				$Content .= "\n";
			}
		}	
		}
		
		if(!empty($cancelled_orders)){
				$Content1='';	
				foreach($cancelled_orders as $cancelled_order){
						$Content1 .= date(DATE_TIME_FORMAT,strtotime($cancelled_order['Order']['created'])).",";
						$Content1 .= $cancelled_order['Order']['order_number'].",";
						$Content1 .= html_entity_decode($cancelled_order['Seller']['business_display_name'], ENT_NOQUOTES, 'UTF-8').",";
						$Content1 .= $cancelled_order['Order']['UserSummary']['firstname'] .' '.$cancelled_order['Order']['UserSummary']['lastname'].",";

				$str ='';
				$cancelled_order_items = array_unique($cancelled_order['Order']['CanceledItem']);
				foreach($cancelled_order_items as $canceleditems)
				{
				if(!empty($canceleditems['created']))
				{
				$str .= date(DATE_TIME_FORMAT,strtotime($canceleditems['created'])).': ';	
				}	
				}
				$Content1 .= rtrim($str,': ');
				$Content1 .= "\n";
				}
			}
		$wholeContent=$Content.$Content1;
		
		$filePath="cancelled_order_".date("Ymd").".csv";
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=".$filePath."");
		header("Pragma: no-cache");
		header("Expires: 0");
		print $wholeContent;
		exit;
		
	}
	
	
		
}
?>