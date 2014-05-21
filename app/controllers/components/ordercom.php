<?php 
class OrdercomComponent extends Object
{
	
	
	var $components =  array('Session','Email','File', 'Common');


	/** 
	@function: getOrderDetail
	@Created by: Kulvinder
	@Modify:  09 Feb 2011 
	*/
	function getOrderItems($orderId) {
		# import order item code data Db
		App::import('Model', 'OrderItem');
		$this->OrderItem = &new OrderItem();
		
		if(empty($orderId) && is_null($orderId)  ){
			return false;
		}
		$orderItems =  $this->OrderItem->find('all', array('conditions'=>array('OrderItem.order_id'=>$orderId )
				));
		return $orderItems;
	}
	
	/** 
	@function: getSellerOrderItems
	@Created by: Kulvinder
	@Modify:  10 Feb 2011 
	*/
	function getSellerOrderItems($orderId, $seller_id) {
		# import order item code data Db
		App::import('Model', 'OrderItem');
		$this->OrderItem = &new OrderItem();
		
		if(empty($orderId) || empty($seller_id) ){
			return false;
		}
		$orderItems =  $this->OrderItem->find('all', array('conditions'=>array('OrderItem.order_id'=>$orderId, 'OrderItem.seller_id'=>$seller_id )
				));
		return $orderItems;
	}
	
	
	/** 
	@function: setBasketDataAsPerStock
	@Created by: Kulvinder
	@Modify: 28 april  2011 
	*/
	function setBasketDataAsPerStock() {
		
		App::import('Model', 'Basket');
		$this->Basket = &new Basket();
		
		$session_id = session_id();
		$basketItemsData = $this->Basket->find('all', array(
					'conditions'=>array('Basket.session_id' =>$session_id ),
					'fields'=>array('Basket.id', 'Basket.qty','Basket.seller_id','Basket.product_id', 'Basket.condition_id')
					));
		if(count($basketItemsData) > 0){
			foreach($basketItemsData as $basketItems):
				$prodSellerData = $this->Common->getProductSellerData($basketItems['Basket']['product_id'], $basketItems['Basket']['seller_id'], $basketItems['Basket']['condition_id']);
					if($basketItems['Basket']['qty'] >  $prodSellerData['ProductSeller']['quantity'] ){
						$this->Basket->id = $basketItems['Basket']['id'];
						$this->Basket->saveField('qty', $prodSellerData['ProductSeller']['quantity']);
					}
				unset($prodSellerData);
			endforeach;
		}
	}
	
	/** 
	@function: getExpectedShippingDate
	@Created by: Kulvinder
	@Modify:  06 Apri  2011 
	*/
	function getExpectedShippingDate($orderId) {
		# import order item code data Db
		App::import('Model', 'OrderItem');
		$this->OrderItem = &new OrderItem();
		
		if(empty($orderId) ){
			return false;
		}
		$orderItemData =  $this->OrderItem->find('first',  array('order'=>'estimated_delivery_date desc', 'conditions'=>array('OrderItem.order_id'=>$orderId ), 'fields' =>array('estimated_delivery_date')  	));
		return $orderItemData['OrderItem']['estimated_delivery_date'];
	}
	
	/** 
	@function: getExpectedDispatchDate
	@Created by: Kulvinder
	@Modify:  09 Apri  2011 
	*/
	function getExpectedDispatchDate($orderId = null, $seller_id =  null) {
		# import order item code data Db

		App::import('Model', 'OrderItem');
		$this->OrderItem = &new OrderItem();
		
		if(empty($orderId) ){
			return false;
		}
		$orderItemData =  $this->OrderItem->find('first',  array('order'=>'estimated_delivery_date desc', 'conditions'=>array('OrderItem.order_id'=>$orderId , 'OrderItem.seller_id'=>$seller_id), 'fields' =>array('estimated_dispatch_date')));

		return $orderItemData['OrderItem']['estimated_dispatch_date'];
	}
	
	/** 
	@function: getOrderShippingStatus
	@Created by: Kulvinder
	@Modify:  21 March 2011
	*/
	function getOrderShippingStatus($orderId) {
		# import OrderSeller code data Db
		App::import('Model', 'OrderSeller');
		$this->OrderSeller = &new OrderSeller();
		if(empty($orderId) && is_null($orderId)  ){
			return false;
		}
		$orderStatusArr =  $this->OrderSeller->find('list', array('conditions'=>array('OrderSeller.order_id'=>$orderId ),
				'fields' => array('OrderSeller.seller_id','OrderSeller.shipping_status') ));
	
		return $orderStatusArr;
	}
	
	/** 
	@function: getOrderCancelData
	@Created by: Kulvinder
	@Modify:  21 March 2011
	*/
	function getOrderCancelData($orderId) {
		# import OrderSeller code data Db
		App::import('Model', 'CanceledItem');
		$this->CanceledItem = &new CanceledItem();
		if(empty($orderId) && is_null($orderId)  ){
			return false;
		}
		//$cancelQuery = " select shipping_status,modified, title  from order_sellers OrderSeller left join reasons Reason ON (OrderSeller.reason_id = Reason.id ) where order_id = $orderId AND shipping_status = 'Cancelled' ";
		//$cancelData = $this->OrderSeller->query($cancelQuery);
		
		$cancelDataArr = $this->CanceledItem->find('all',
					array( 'order' =>'CanceledItem.created desc', 'group'=>'CanceledItem.created' , 'conditions'=>array('CanceledItem.order_id'=>$orderId),
					'fields'=> array('CanceledItem.order_id','CanceledItem.created') ));
		
		$cancellesArray = array();
		if(count($cancelDataArr) > 0 ){
			$this->CanceledItem->expects(array('OrderItem') );
			
			foreach($cancelDataArr as $cancelData){
				$order_id 		= $cancelData['CanceledItem']['order_id'];
				$shipment_date     	= $cancelData['CanceledItem']['created'];
				$cancelArr = $this->CanceledItem->find('all',
				 array( 'conditions'=>array('CanceledItem.order_id'=>$order_id, 'CanceledItem.created'=> $shipment_date ),
				'fields'=>array('CanceledItem.order_id','CanceledItem.created', 'CanceledItem.quantity','CanceledItem.reason_id','OrderItem.product_name')));
				 $cancellesArray[] = $cancelArr;
			}
		}
		return $cancellesArray;
	}
	
	
	/** 
	@function: getOrderRefundData
	@Created by: Kulvinder
	@Modify:  21 March 2011
	*/
	function getOrderRefundData($orderId) {
		# import OrderSeller code data Db
		App::import('Model', 'OrderRefund');
		$this->OrderRefund = &new OrderRefund();
		if(empty($orderId) && is_null($orderId)  ){
			return false;
		}
		
		$refundData =  $this->OrderRefund->find('all', array('conditions'=>array('OrderRefund.order_id'=>$orderId ),
						'fields' => array('OrderRefund.amount','OrderRefund.created', 'OrderRefund.memo','OrderRefund.seller_id') ));
		
		if(!Empty($refundData)){
			App::import('Model', 'Seller');
			$this->Seller = &new Seller();
			$i = 0;
			foreach($refundData as $refund_data){
				$refund_seller = $this->Seller->find('first',array('conditions'=>array('Seller.user_id'=>@$refund_data['OrderRefund']['seller_id']),'fields'=>array('Seller.business_display_name')));
				
				$refundData[$i]['OrderRefund']['seller_display_name'] = $refund_seller['Seller']['business_display_name'];
				$i++;

			}
		}
		return $refundData;
	}
	
	
	
	
	
	/** 
	@function: getOrderSellers
	@Created by: Kulvinder
	@Modify:  11 Feb 2011 
	*/
	function getOrderSellers($orderId) {
		# import order item code data Db
		App::import('Model', 'OrderSeller');
		$this->OrderSeller = &new OrderSeller();
		
		if(empty($orderId) && is_null($orderId)  ){
			return false;
		}
		
		$orderSellers =  $this->OrderSeller->find('list', array('conditions'=>array('OrderSeller.order_id'=>$orderId ),
									'fields' => array('OrderSeller.seller_id','OrderSeller.seller_id') ));
		return $orderSellers;
	}
	
	
	/** 
	@function: getProductSellerInfo
	@Created by: Kulvinder
	@Modify:  04 Feb 2011 
	*/
	function getProductSellerInfo($product_id = null, $seller_id = null, $condition_id = null) {
		$prodSellerInfo = array();
		if(empty($product_id) && is_null($seller_id)  ){
			return $prodSellerInfo;
		}
		App::import('Model','ProductSeller');
		$this->ProductSeller = & new ProductSeller();
		$prodSellerInfo =  $this->ProductSeller->find('first', array(
				'conditions'=>array('ProductSeller.product_id'=>$product_id , 'ProductSeller.seller_id'=>$seller_id ,'ProductSeller.condition_id'=>$condition_id  ),
				'fields'=>array('ProductSeller.quantity','ProductSeller.standard_delivery_price',
						'ProductSeller.express_delivery','ProductSeller.express_delivery_price')
				));
		return $prodSellerInfo;
	}
	
	
	/** 
	@function: getsellerInfo
	@Created by: Kulvinder
	@Modify:  04 Feb 2011 
	*/ 
	function getsellerInfo($seller_id = null ) {
		App::import("Model","User");
		$this->User=& new User();
		$sellersDataArr = array();
		$this->User->expects( array('Seller') );
		$sellersDataArr =  $this->User->find('first', array('conditions'=>array('Seller.user_id'=>$seller_id),
			'fields'=>array('User.id','User.firstname', 'User.lastname','Seller.business_display_name','Seller.service_email',
			 'Seller.free_delivery','Seller.threshold_order_value','Seller.gift_service')
			));
	    return $sellersDataArr;
	}
	
// get the gifts services count for the sellers
	function check_sellers_giftwrapservice($sellersArr) {
	    if(!empty($sellersArr) && is_array($sellersArr)  ){
		
		$sellersStr = implode(',', $sellersArr) ;
		App::import("Model","Seller");
		$this->Seller=& new Seller();
		$giftsArr = array();
		$giftsArr =  $this->Seller->find('list', array(
			'conditions' => array( 'Seller.user_id IN ('.$sellersStr.') '),
			'fields'=>array('Seller.id','Seller.gift_service'),
			 )
		);
		$giftsItems = array();
		
		if(is_array($giftsArr)  && count($giftsArr) > 0){
			foreach($giftsArr as $gifts){
				if(!empty($gifts) ){
					$giftsItems[] = $gifts;
				}
			}
		}
		return count($giftsItems);
	    }else{
		return '';
	    }
	}
	
		
	
	/** 
	@function : get_user_giftbalance
	@description : to get the gift balance
	@params : NULL
	@created : Jan 31, 2011
	@credated by :kulvinder Singh
	**/
	function getUserGiftbalance($user_id) {
		# import database
		App::import("Model","Giftbalance");
		$this->Giftbalance=& new Giftbalance();
		
		$gcScored = $this->getScoredGiftCertificates($user_id);
		$gcUsed   = $this->getUsedGiftCertificates($user_id);
    	        $gc_balance =  $gcScored - $gcUsed; 
		return $gc_balance;
	}
	
	/** 
	@function : getScoredGiftCertificates
	@description : to get the gift balance
	@params : NULL
	@created : Jan 31, 2011
	@credated by :kulvinder Singh
	**/
	function getScoredGiftCertificates($user_id) {
		# import database
		App::import("Model","Giftbalance");
		$this->Giftbalance = & new Giftbalance();
		
		$gcbData = $this->Giftbalance->query(" SELECT SUM(Giftbalance.amount) AS amount from giftbalances Giftbalance where Giftbalance.user_id = '".$user_id."'  group by Giftbalance.user_id" );
		if(is_array($gcbData) && !empty($gcbData)){
		    return $gcbData[0][0]['amount'];
		}else{
		    return 0;
		};
	}
	
	/** 
	@function : getUsedGiftCertificates
	@description : to get the gift balance
	@params : NULL
	@created : Jan 31, 2011
	@credated by :kulvinder Singh
	**/
	function getUsedGiftCertificates($user_id) {
		# import database
		App::import("Model","Order");
		$this->Order = & new Order();
		
		$gcbData = $this->Order->query(" SELECT SUM(gc_amount) AS gc_amount from orders where user_id = '".$user_id."' AND payment_status = 'Y' group by user_id" );
		if(is_array($gcbData) && count($gcbData) > 0){
		    $data = $gcbData[0][0]['gc_amount'];
		    if($data > 0 ){
			return $data;
		    }else{
			 return 0;
		    }
		}else{
		    return 0;
		};
	}
	
	/** 
	@function : getDiscountCouponData
	@description : to get value of discount coupon
	@params : NULL
	@created : 01 Feb, 2011
	@credated by :kulvinder Singh
	**/
	function getDiscountCouponData($dcCode) {
		# import database
		App::import("Model","Coupon");
		$this->Coupon = & new Coupon();
		$dcCode = trim($dcCode);
		$dcData = $this->Coupon->find('first', array('conditions'=>array('Coupon.discount_code'=> $dcCode, 'Coupon.status'=> 1, 'Coupon.product_onsale'=> 1  )) );
		if(is_array($dcData) && count($dcData) > 0){
			return $dcData;
		}else{
		    return 0;
		}
	}
	
/** 
	@function : countHowManyTimesUsed
	@description : to get hiw much times the coupon has been used
	@params : NULL
	@created : 01 Feb, 2011
	@credated by :kulvinder Singh
	**/
	function countHowManyTimesUsed($dcCode, $user_id = '') {
		# import database
		App::import("Model","Order");
		$this->Order = & new Order();
		$dcCode = trim($dcCode);
		if(!empty($user_id) ){
			$queryStr = " SELECT count(dc_code) AS total_num_used from orders where dc_code = '".$dcCode."' AND user_id = '".$user_id."' AND payment_status = 'Y' group by user_id ";	
		}else{
			$queryStr = " SELECT count(dc_code) AS total_num_used from orders where dc_code = '".$dcCode."' AND payment_status = 'Y' group by dc_code ";
		}
		
		$gcbData = $this->Order->query($queryStr);
		
		if(is_array($gcbData) && count($dcCode) > 0){
		    $data = @$gcbData[0][0]['total_num_used'];
		    if($data > 0 ){
			return $data;
		    }else{
			 return 0;
		    }
		}else{
		    return 0;
		}
	}


	
	 /** 
	@function : getBasketPriceInfo
	@description : to calculate the basket item price info
	@params : NULL
	@created : 04 Feb, 2011
	@credated by :kulvinder Singh
	**/
	function getBasketPriceInfo() {
	    
	   
	    $settings = $this->Common->get_site_settings();
	    $cartData = $this->Common->get_basket_listing();
	
	    $item_total_cost = 0;
	    $gift_wrap_total_cost =0;
	    $delivery_total_cost = 0;
	    $delevery_price = 0;
	    
	    $productInfoArr = array();
	    $basketPriceData = array();
	    
	    if(is_array($cartData) && count($cartData) >0 ) {
		
		foreach($cartData as $cart){
			$delevery_price = 0;		    
			$prodQty =  $cart['Basket']['qty'];
			$prodPrice = $cart['Basket']['price'];
			
			if($cart['Basket']['delivery_method'] == 'E'){ // in case of express delivery
				$delevery_price = $cart['Basket']['exp_delivery_cost'];
			}else{
				$delevery_price = $cart['Basket']['delivery_cost'];
			}
			
			###  product seller info ###
			$prodId 	= $cart['Basket']['product_id'];
			$sellerId 	= $cart['Basket']['seller_id'];
			
			$productInfoArr['product_id'][] = $prodId;
			$productInfoArr['seller_id'][]  = $sellerId;
			
			$prodSellerInfo = $this->getProductSellerInfo($prodId,$sellerId, $cart['Basket']['condition_id'] );
			//$SellerInfo     = $this->getsellerInfo($sellerId );
			
			$totalQty 	= $prodSellerInfo['ProductSeller']['quantity'];
			#--------------------------#
			if( empty($totalQty) ){ 	//skip item if seller have 0  item to sale 
			      continue;
			}
			#--------------------------#
			
			$Item_price 		= ($prodQty * $prodPrice);
			
			
			if(strtolower($cart['Basket']['giftwrap'])  == 'yes'){
			    $gift_wrap_total_cost += ($prodQty * $settings['Setting']['gift_wrap_charges']);
			}
			
			$Items_delivery_price 	= ($prodQty * $delevery_price);
			
			$delivery_total_cost  += $Items_delivery_price;
			$item_total_cost      += $Item_price;
			
			unset($prodQty);unset($Items_delivery_price);unset($Item_price);unset($delevery_price);
		}
		
		$basketPriceData['item_total_cost']    		= floatval($item_total_cost);
		$basketPriceData['shipping_total_cost'] 	= floatval($delivery_total_cost);
		$basketPriceData['giftwrap_total_cost'] 	= floatval($gift_wrap_total_cost);
		$basketPriceData['product_ids'] 		=  array_unique($productInfoArr['product_id']);
		$basketPriceData['seller_ids'] 			=  array_unique($productInfoArr['seller_id']);
	    }
	    return $basketPriceData;
	}


	##
	#@function: to clear the  order session 
	#
	function clearOrderSessionData(){
		$sess_date = $_SESSION;
		
		$orderData = $this->Session->read('sessOrderData');
		if(is_array($orderData)){ // if session  data present 
			foreach($orderData as $id=>$dataValue){
				$nameVal = 'sessOrderData.'.$id;
				$this->Session->write($nameVal, '');
			}
			
		}
		$this->Session->write('sessOrderData', '');
		$this->Session->write('dcSessData', '');
		return true;
	}
	
	/** 
	@function: deductInventory to subtract the wuantity of product from the porduct seller's inventory
	@Created by: Kulvinder
	@Modify:  03 March  2011 
	*/
	function deductInventory($product_id , $seller_id , $qty_purchased) {
		// import the DB
		App::import('Model','ProductSeller');
		$this->ProductSeller = & new ProductSeller();
		$strQuery = " UPDATE product_sellers set quantity = quantity-$qty_purchased where product_sellers.product_id = '".$product_id."' AND  product_sellers.seller_id = '".$seller_id."'   ";
		$prodSellerInfo =  $this->ProductSeller->query($strQuery);
		return true;
	}
	
	/** 
	@function: get_basket_listing
	@description: get_basket_listing
	@Created by: Kulvinder
	@Modify:  12 JAn 2010 
	*/
	function clearBasketOrderData($order_id){
		# import basket Db
		App::import('Model','Basket');
		$this->Basket = & new Basket();
		$sqlStr = "DELETE FROM baskets  WHERE order_id = '".$order_id."' ";
		$this->Basket->query($sqlStr);
		return true;
	}
	
	/** 
	@function: setOrderNumberInBasker
	@description: set order number in basket table
	@Created by: Kulvinder
	@Modify:  28 april 2011
	*/
	function setOrderNumberInBasker($order_id){
		# import basket Db
		App::import('Model','Basket');
		$this->Basket = & new Basket();
		$session_id = session_id();
		$logg_user_id = $this->Session->read('User.id');
		$strQuery = " UPDATE baskets set order_id = $order_id, user_id = '".$logg_user_id."' where baskets.session_id = '".$session_id."'   ";
		if($this->ProductSeller->query($strQuery)){
			return true;
		}else{
			return false;
		}
	}
	
	/** 
	@function: getOrderBasketData
	@description: getOrderBasketData
	@Created by: Kulvinder
	@Modify:  12 JAn 2010 
	*/
	function getOrderBasketData($order_id){
		# import basket Db
		App::import('Model','Basket');
		$this->Basket = & new Basket();
		//$logg_user_id = $this->Session->read('User.id');
		$query  = " select Basket.id,Basket.product_id, Basket.qty,Basket.price,Basket.seller_id,Basket.condition_id,Basket.giftwrap,Basket.giftwrap_cost,Basket.giftwrap_message,
		Basket.delivery_method, Basket.delivery_cost,Basket.exp_delivery_cost, Basket.standard_delivery_date,Basket.express_delivery_date, Basket.estimated_dispatch_date, Product.product_name,Product.quick_code from baskets Basket inner join products Product ON (Product.id= Basket.product_id)";
		$query .= " where Basket.order_id = '".$order_id."'  AND Basket.seller_id != 0    order by Basket.id asc";
		$cartData = $this->Basket->query($query);
		
		return $cartData;
	}
	
	
	/** 
	@function: get_order_details
	@description: to fetch details for an given order_id
	@Created by: Ramanpreet Pal
	@Created:  modified by kulvinder
	@Modify:  
	*/
	function get_order_details($order_id = null){
		
		App::import('Model','Order');
		$this->Order = & new Order();
		
		$this->Order->expects(array('UserSummary'));
		$order_details = $this->Order->find('first',array('conditions'=>array('Order.id'=>$order_id) ));
		App::import('Model','OrderItem');
		$this->OrderItem = & new OrderItem();

		if(!empty($order_details)){
			$i = 0;
			$this->OrderItem->expects(array('SellerSummary'));
			
			$items = $this->OrderItem->find('all',array('conditions'=>array('OrderItem.order_id'=>$order_details['Order']['id']),
				'fields'=>array('distinct(OrderItem.id)','OrderItem.order_id','OrderItem.seller_id','OrderItem.product_id',
						'OrderItem.condition_id','OrderItem.quantity','OrderItem.price','OrderItem.delivery_method',
						'OrderItem.delivery_cost','OrderItem.estimated_delivery_date','OrderItem.giftwrap','OrderItem.giftwrap_cost',
						'OrderItem.gift_note','OrderItem.product_name','OrderItem.quick_code','OrderItem.seller_name','SellerSummary.id',
						'SellerSummary.firstname','SellerSummary.lastname')));
			$i = 0;
			if(!empty($items)){
				foreach($items as $item) {
					$all_item[$i] = $item['OrderItem'];
					$all_item[$i]['SellerSummary'] = $item['SellerSummary'];
					$i++;
				}
				$order_details['Items'] = $all_item;
			}
		}
		return $order_details;
	}

	
	# @ function to get shipping estimations
	function getRequiredShippingDays($fromCountryId, $toCountryId  ){
		
		if( empty($fromCountryId) || empty($fromCountryId)  ){
			return '';
		}
		App::import('Model', 'DeliveryDestination');
		$this->DeliveryDestination = new DeliveryDestination();
		
		$dataArr = $this->DeliveryDestination->find('first',array(
				'conditions' => array('DeliveryDestination.country_from' => $fromCountryId,
						     'DeliveryDestination.country_to' => $toCountryId ),
				));
		return 	$dataArr;	
	}
	
	
	###
	function getFinalDeliveryDate($delivery_days){
		if(empty($delivery_days) ){
			return '';
		}
		$current_date = strtotime(date('Y-m-d') );
		$orderDay = date('l', strtotime($current_date));
		
		switch(strtolower($orderDay)):
			case'sunday':
				$days_interval = $delivery_days+1;
				break;
			case'saturday':
				$days_interval = $delivery_days+2;
				break;
			default:
				$days_interval = $delivery_days;
			break;
		endswitch;
		
		$estimated_del_date = date('Y-m-d', mktime(0,0,0,date('m',$current_date),date('d',$current_date)+$days_interval,date('Y',$current_date)));
		$deliveryDay = date('l', strtotime($estimated_del_date));
		
		#  get additional days required to deliver the product
			switch(strtolower($deliveryDay)):
				case'sunday':
					$additional_day = 1;
					break;
				case'saturday':
					$additional_day = 2;
					break;
				default:
					$additional_day = 0;
				break;
			endswitch;
		
		# if sat sunday  comes on delivery date	
		if(!empty($additional_day) ){ 
			$estimated_del_date = strtotime($estimated_del_date) ;
			$final_delivery_date = date('Y-m-d', mktime(0,0,0,date('m',$estimated_del_date),date('d',$estimated_del_date)+$additional_day,date('Y',$estimated_del_date)));
		}else{
			$final_delivery_date = $estimated_del_date;
		}
		return $final_delivery_date;
		
	}
	


	
	/** 
	@function : canceled_orderitem_qty
	@description : to get total canceled quantity of items in an order / an order of a seller
	@params : 
	@Modify : 
	@Created Date : April 18,2011
	@Created By : Ramanpreet Pal Kaur
	*/
	function canceled_orderitem_qty($order_id = null,$seller_id = null,$order_item_id = null){
		App::import('Model','CanceledItem');
		$this->CanceledItem = & new CanceledItem();
		if(!empty($order_item_id)){
			$creteria_cancelitems = array('CanceledItem.order_item_id'=>$order_item_id);
			$canceled_items = $this->CanceledItem->find('all',array('conditions'=>$creteria_cancelitems,'fields'=>array('SUM(quantity) as total_quantity','CanceledItem.order_item_id')));
			if(empty($canceled_items[0][0]['total_quantity']))
				$canceled_items[0][0]['total_quantity'] = 0;
			return $canceled_items[0][0]['total_quantity'];
		} else {
			if(!empty($seller_id)){
				$creteria_cancelitems = array('CanceledItem.order_id'=>$order_id,'CanceledItem.seller_id'=>$seller_id);
			} else {
				$creteria_cancelitems = array('CanceledItem.order_id'=>$order_id);
			}
			$canceled_items = $this->CanceledItem->find('all',array('conditions'=>$creteria_cancelitems,'fields'=>array('SUM(quantity) as total_quantity','CanceledItem.order_item_id'),'group'=>array('CanceledItem.order_item_id')));
			$cancelitem_arr = array();
			if(!empty($canceled_items)){
				foreach($canceled_items as $canceled_item){
					$cancelitem_arr[$canceled_item['CanceledItem']['order_item_id']] = $canceled_item[0]['total_quantity'];
				}
				
				
			}
			return $cancelitem_arr;
		}
	}


	/** 
	@function : dispatcheded_orderitem_qty
	@description : to get total dispatched quantity of items in an order / an order of a seller
	@params : 
	@Modify : 
	@Created Date : April 18,2011
	@Created By : Ramanpreet Pal Kaur
	*/
	function dispatcheded_orderitem_qty($order_id = null,$seller_id = null,$order_item_id = null){
		App::import('Model','DispatchedItem');
		$this->DispatchedItem = & new DispatchedItem();
		if(!empty($order_item_id)){
			$creteria_dispatchitems = array('DispatchedItem.order_item_id'=>$order_item_id);
			$dispatched_items = $this->DispatchedItem->find('all',array('conditions'=>$creteria_dispatchitems,'fields'=>array('SUM(quantity) as total_quantity')));
			if(empty($dispatched_items[0][0]['total_quantity']))
				$dispatched_items[0][0]['total_quantity'] = 0;
			return $dispatched_items[0][0]['total_quantity'];
		} else {
			if(!empty($seller_id)){
				$creteria_dispatchitems = array('DispatchedItem.order_id'=>$order_id,'DispatchedItem.seller_id'=>$seller_id);
			} else {
				$creteria_dispatchitems = array('DispatchedItem.order_id'=>$order_id);
			}
			$dispatched_items = $this->DispatchedItem->find('all',array('conditions'=>$creteria_dispatchitems,'fields'=>array('SUM(quantity) as total_quantity','DispatchedItem.order_item_id'),'group'=>array('DispatchedItem.order_item_id')));
			$dispatchitem_arr = array();
			if(!empty($dispatched_items)){
				foreach($dispatched_items as $dispatched_item){
					$dispatchitem_arr[$dispatched_item['DispatchedItem']['order_item_id']] = $dispatched_item[0]['total_quantity'];
				}
			}
			return $dispatchitem_arr;
		}
	}

	/** 
	@function :orderitem_qty
	@description : to get total ordered quantity for each item for an order / or also for a seller
	@params : 
	@Modify : 
	@Created Date : April 18,2011
	@Created By : Ramanpreet Pal Kaur
	*/
	function orderitem_qty($order_id = null,$seller_id = null){
		App::import('Model','OrderItem');
		$this->OrderItem = & new OrderItem();
		
		if(!empty($seller_id)){
			$creteria_items = array('OrderItem.order_id'=>$order_id,'OrderItem.seller_id'=>$seller_id);
		} else {
			$creteria_items = array('OrderItem.order_id'=>$order_id);
		}
		$items = $this->OrderItem->find('list',array('conditions'=>$creteria_items,'fields'=>array('OrderItem.id','OrderItem.quantity')));
		return $items;
	}

	/** 
	@function :getOrderIdFromNumber
	@description : 
	@params :  order number
	@Modify : 
	@Created Date : April 18,2011
	@Created By : kulvinder
	*/
	function getOrderIdFromNumber($order_number = null){
		App::import('Model','Order');
		$this->Order = & new Order();
		$order_info = $this->Order->find('first',array(
					'conditions'=>array('order_number'=>$order_number),
					'fields'=>array('id','order_number','user_id','created')));
		return $order_info;
		
	}
/** 
	@function :getOrderNumber
	@description : 
	@params :  order id
	@Modify : 
	@Created Date : April 18,2011
	@Created By : kulvinder
	*/
	function getOrderNumber($orderId = null){
		App::import('Model','Order');
		$this->Order = & new Order();
		$order_info = $this->Order->find('first',array(
					'conditions'=>array('order_number'=>$orderId),
					'fields'=>array('id','order_number')));
		return $order_info;
		
	}
	
	/** 
	@function :generatOrderNumber
	@description : 
	@params : 
	@Modify : 
	@Created Date : April 18,2011
	@Created By : Ramanpreet Pal Kaur
	*/
	function generatOrderNumber($order_id = null){
		App::import('Model','Order');
		$this->Order = & new Order();
		$creteria_order_num = array('Order.id'=>$order_id);
		$order_info = $this->Order->find('first',array('conditions'=>$creteria_order_num,'fields'=>array('Order.id','Order.user_id','Order.created')));

		if(!empty($order_info))
			$order_number = $order_info['Order']['id'].'-'.date(ORDERNUMBER_DATE_FORMAT,strtotime($order_info['Order']['created'])).'-'.$order_info['Order']['user_id'];
		else
			$order_number = '-';
		return $order_number;
	}


	//Used in cancel_order in seller controller  and some where else
	function cancelOrderAllitems($order_id = null, $seller_id = null, $reason_id = null,$user_id = null){
		App::import('Model','CanceledItem');
		$this->CanceledItem = new CanceledItem();
		App::import('Model','OrderItem');
		$this->OrderItem = new OrderItem();
		App::import('Model','OrderRefund');
		$this->OrderRefund = new OrderRefund();
		
		App::import('Model','Order');
		$this->Order = new Order();
		
		if(!empty($seller_id))
			$seller_order_items = $this->OrderItem->find('all',array('conditions'=>array('OrderItem.seller_id'=>$seller_id,'OrderItem.order_id'=>$order_id)));
		else
			$seller_order_items = $this->OrderItem->find('all',array('conditions'=>array('OrderItem.order_id'=>$order_id)));
			
		$this->data['CanceledItem']['order_id'] = $order_id;
		/*$seller_id*/
		if(!empty($reason_id)){
			$this->data['CanceledItem']['reason_id'] = $reason_id;
		}else{
			$this->data['CanceledItem']['reason_id'] = 15;
		}
		$order_user_id = $this->Order->find('first',array('fields'=>array('Order.user_id'),'conditions'=>array('Order.id'=>$order_id)));
		
		$this->data['CanceledItem']['preshipped_canceled'] = 2;
		//pr($seller_order_items);
		//exit;
		if(!empty($seller_order_items)){
			foreach($seller_order_items as $seller_order_item){
				$this->data['CanceledItem']['id'] = 0;
				$this->data['CanceledItem']['seller_id'] = $seller_order_item['OrderItem']['seller_id'];
				$this->data['CanceledItem']['order_item_id'] = $seller_order_item['OrderItem']['id'];
				$this->data['CanceledItem']['quantity'] = $seller_order_item['OrderItem']['quantity'];
				$this->data['CanceledItem']['item_price'] = $seller_order_item['OrderItem']['price'];
				$this->CanceledItem->set($this->data);
				$this->CanceledItem->save($this->data);
				
				//Start Comment lines are on 11-Feb-2013
				$this->data['OrderRefund']['order_id'] = $order_id;
				$this->data['OrderRefund']['seller_id'] = $seller_order_item['OrderItem']['seller_id'];
				$this->data['OrderRefund']['amount'] = ($seller_order_item['OrderItem']['quantity'])*(($seller_order_item['OrderItem']['price'])+$seller_order_item['OrderItem']['delivery_cost']);
				
				if(!empty($user_id)){
					$this->data['OrderRefund']['user_id'] = $user_id;
				}else{
					$this->data['OrderRefund']['user_id'] = $order_user_id['Order']['user_id'];
				}
				$this->data['OrderRefund']['id'] = '';
				if(!empty($reason_id)){
					$this->data['OrderRefund']['reason_id'] = $reason_id;
				}else{
					$this->data['OrderRefund']['reason_id'] = 15;
				}
				$this->OrderRefund->set($this->data);
				$this->OrderRefund->save($this->data);
				//Start Comment lines are on 11-Feb-2013
				
			}
		}
	}
	
	
	
	/** 
	@function :processSellerOrderStatus
	@description : update order status as per the calculation for a seller
	@Modify : 
	@Created Date : April 18,2011
	@Created By : Kulvinder Singh
	*/
	function processSellerOrderStatus($orderId , $orderSellerId){
		App::import('Model','OrderSeller');
		$this->OrderSeller = new OrderSeller;
		$itemsCancelled  = $this->canceled_orderitem_qty($orderId, $orderSellerId);
		$itemsDispatched = $this->dispatcheded_orderitem_qty($orderId, $orderSellerId);
		
		$itemsOrderedArr  = $this->orderitem_qty($orderId, $orderSellerId);
		$itemsOrdered = array_sum($itemsOrderedArr);
		$total_cancelled = 0;
		if(count($itemsCancelled) > 0){
			
			foreach($itemsCancelled as $canValue):
				$total_cancelled +=$canValue;
			endforeach;
		}
		$total_dispatched = 0;
		if(count($itemsDispatched) > 0){
			
			foreach($itemsDispatched as $dispValue):
				$total_dispatched +=$dispValue;
			endforeach;
		}
		$totalProcessed = $total_dispatched+$total_cancelled;
		if($itemsOrdered == $total_cancelled){
			$Orderstatus = 'Cancelled';
		}else if($itemsOrdered == $totalProcessed){
			$Orderstatus = 'Shipped';
		}else{
			$Orderstatus = 'Part Shipped';
		}
		$this->OrderSeller->query( " update order_sellers SET shipping_status = '".$Orderstatus."'  where order_id = $orderId AND seller_id = $orderSellerId " ) ;
	}
	
	/** 
	@function: getCancelReasons
	@Created by: Kulvinder
	@Modify:  21 March 2011
	*/
	function getCancelReasons() {
		# import OrderSeller code data Db
		App::import('Model', 'Reason');
		$this->Reason = &new Reason();
		$cancelReasonArr =  $this->Reason->find('list');
	
		return $cancelReasonArr;
	}
	
	
	/** 

e9155c95b3c77f77e61a1fd09c2f5160 (240385)
e9155c95b3c77f77e61a1fd09c2f5160 (240383);


	@function: getCancelledItemsCost
	@Created by: Kulvinder
	@Modify:  21 March 2011
	*/
	function getCancelledItemsCost($seller_id = null, $from_date= null, $end_date= null, $cType = null) {
		App::import('Model', 'CanceledItem');
		$this->CanceledItem = new CanceledItem();
		$strCancelQuery = " select  SUM((CanceledItem.item_price*CanceledItem.quantity)+(ITEM.delivery_cost*CanceledItem.quantity)+(CanceledItem.quantity*ITEM.giftwrap_cost)) as cancelled_amount , CanceledItem.seller_id from  canceled_items CanceledItem inner join order_items ITEM ON (CanceledItem.order_item_id = ITEM.id)";
		$strCancelQuery .= "inner join orders on (orders.id = CanceledItem.order_id ) ";
		$strCancelQuery .= " where orders.payment_status = 'Y' AND orders.deleted = '0' ";
		if(!empty($cType) ){
			$strCancelQuery .= " AND CanceledItem.preshipped_canceled  = '".$cType."' ";
		}
		if(!empty($from_date) ){
			$strCancelQuery .= "AND date(CanceledItem.created) BETWEEN '".$from_date."' AND '".$end_date."'";
		}
		/*if(!empty($from_date) ){
			$strCancelQuery .= " AND date(CanceledItem.created) >= '".$from_date."' ";
		}
		if(!empty($end_date) ){
			$strCancelQuery .= " AND date(CanceledItem.created) <= '".$end_date."' ";
		}*/
		if(!empty($seller_id) ){
			$strCancelQuery .= " AND CanceledItem.seller_id = $seller_id  ";
			$strCancelQuery .= " group by CanceledItem.seller_id ";
		}
		$strCancelQuery .= " order by cancelled_amount desc ";
		$cancelSellersData = $this->CanceledItem->query($strCancelQuery);
		
		return $cancelSellersData;
	}
	
	
	/** 
	@function: getCancelledItemsCost
	@Created by: Kulvinder
	@Modify:  21 March 2011
	*/
	function getCancelledItemsCount($from_date= null, $end_date= null,$seller_id = null) {
		App::import('Model', 'CanceledItem');
		$this->CanceledItem = new CanceledItem();
		
		$strCancelQuery = " select  SUM(CanceledItem.quantity) as cancelled_items_count from  canceled_items CanceledItem inner join order_items ITEM ON (CanceledItem.order_item_id = ITEM.id)  ";
		$strCancelQuery .= " INNER JOIN orders on (orders.id = CanceledItem.order_id ) ";
		$strCancelQuery .= " where orders.payment_status = 'Y' AND orders.deleted = '0' ";
		if(!empty($from_date) ){
			$strCancelQuery .= " AND CanceledItem.created >= '".$from_date."' ";
		}
		if(!empty($end_date) ){
			$strCancelQuery .= " AND CanceledItem.created <= '".$end_date."' ";
		}
		if(!empty($seller_id) ){
			$strCancelQuery .= " AND CanceledItem.seller_id = $seller_id  ";
		}
		$cancelItemsData = $this->CanceledItem->query($strCancelQuery);
		
		return $cancelItemsData;
	}
	
	/** 
	@function: getTotalSale
	@Created by: Kulvinder
	@Modify:  26 April 2011
	*/
	function getTotalSale($seller_id = null, $sDateTime= null, $eDateTime= null) {
		App::import('Model', 'OrderItem');
		$this->OrderItem = new OrderItem();
		
		$sqlItems  = " select SUM(order_items.quantity) as total_items_count, SUM((price*quantity)+(quantity*delivery_cost)+(quantity*giftwrap_cost)) as total_sale  from order_items left join orders ON (orders.id = order_items.order_id)   ";
		$sqlItems .= " where orders.payment_status = 'Y' AND orders.deleted = '0'  ";
		if(!empty($sDateTime) ){
			$sqlItems .= " AND date(orders.created) >= '".$sDateTime."' ";
		}
		if(!empty($eDateTime) ){
			$sqlItems .= " AND date(orders.created) <= '".$eDateTime."' ";
		}
		if(!empty($seller_id) && $seller_id > 0 ){
			$sqlItems .= " AND seller_id  = $seller_id ";
		}
		$itemSalesArray = $this->OrderItem->query($sqlItems);
		return $itemSalesArray;
		
		
	}
	
	/** 
	@function: getSoldItemCount
	@Created by: Kulvinder
	@Modify:  11 MAy 2011
	*/
	function getSoldItemsCount( $sDateTime= null, $eDateTime= null, $seller_id = null ) {
		App::import('Model', 'OrderItem');
		$this->OrderItem = new OrderItem();
		
		$sqlItems  = " select SUM(order_items.quantity) as total_items_count from order_items left join orders ON (orders.id = order_items.order_id)   ";
		$sqlItems .= " where orders.payment_status = 'Y' AND orders.deleted = '0'  ";
		if(!empty($sDateTime) ){
			$sqlItems .= " AND orders.created >= '".$sDateTime."' ";
		}
		if(!empty($eDateTime) ){
			$sqlItems .= " AND orders.created <= '".$eDateTime."' ";
		}
		if(!empty($seller_id) && $seller_id > 0 ){
			$sqlItems .= " AND seller_id  = $seller_id ";
		}
		$itemSalesArray = $this->OrderItem->query($sqlItems);
		return $itemSalesArray;
		
	}
	
	
	
	
	/** 
	@function: getTotalSaleOrderSeller
	@Created by: Kulvinder
	@Modify:  26 April 2011
	*/
	function getTotalSaleOrderSeller($order_id = null,$seller_id = null) {
		App::import('Model','OrderItem');
		$this->OrderItem = new OrderItem();
		
		$sqlItems  = " select SUM((price*quantity)+(quantity*delivery_cost)+(quantity*giftwrap_cost)) as total_sale  from order_items";

		if(!empty($seller_id) && $seller_id > 0 ){
			$sqlItems .= " where seller_id  = $seller_id AND order_id = $order_id";
		}
		$itemSalesArray = $this->OrderItem->query($sqlItems);
		if(!empty($itemSalesArray)){} else {
			$itemSalesArray[0][0]['total_sale'] = 0;
		}
		return $itemSalesArray[0][0]['total_sale'];
	}
	
	
	/*
	@function: addBackQuantity
	@description: Add quantity back to product_seller
	@Created by: Vikas Uniyal
	@Created On:  25 Oct., 2012 
	*/
	function addBackQuantity($orderId = NULL, $qty = NULL){
		
		App::import('Model','OrderItem');
		$this->OrderItem = new OrderItem;
		
		App::import('Model','ProductSeller');
		$this->ProductSeller = new ProductSeller;
		
		/*Find all products and their sellers of this order*/
		$all_orders = $this->OrderItem->find('all',array('conditions'=>array('OrderItem.order_id'=>$orderId),'fields'=>array('OrderItem.id','OrderItem.order_id','OrderItem.seller_id','OrderItem.product_id','OrderItem.quantity','OrderItem.condition_id')));
		
		/*add back the quantity with original quantity to product_sellers table*/
		foreach($all_orders as $order_list){
			$ord_sell_info = $this->ProductSeller->find('first',array('conditions'=>array('ProductSeller.seller_id'=>$order_list['OrderItem']['seller_id'],'ProductSeller.product_id'=>$order_list['OrderItem']['product_id'],'ProductSeller.condition_id'=>$order_list['OrderItem']['condition_id']),'fields'=>array('ProductSeller.id','ProductSeller.quantity')));
			
			if($qty != ""){
				$new_qty = $ord_sell_info['ProductSeller']['quantity']+$qty;
			}
			else{
				$new_qty = $ord_sell_info['ProductSeller']['quantity']+$order_list['OrderItem']['quantity'];
			}
			//Save new quantity
			$addQty = array();
			$addQty['ProductSeller']['id'] = $ord_sell_info['ProductSeller']['id'];
			$addQty['ProductSeller']['quantity'] = $new_qty;
			$this->ProductSeller->save($addQty['ProductSeller']);
		}
	}
	
	/**
	@function : sendEmailBuyerSeller 
	@description : Send emails to buyers and sellers 
	@Created by : Pradeep kumar
	@Modify : NULL
	@Created Date : 26 April 2011
	*/

function sendEmailBuyerSeller($order_id = null) {
		App::import('Model','OrderSeller');
		$this->OrderSeller = new OrderSeller();
		
		App::import('Model','OrderItem');
		$this->OrderItem = new OrderItem;
		App::import('Model','Order');
		$this->Order = new Order;
		$this->OrderItem->expects(array('SellerSummary'));
		$item_info = $this->OrderItem->find('all',array('conditions'=>array('OrderItem.order_id'=>$order_id)));
		$this->Order->expects(array('UserSummary'));
			
		$order_info = $this->Order->find('first',array('conditions'=>array('Order.id'=>$order_id)));
		
		
		
		$link=Configure::read('siteUrl');
		App::import('Model','EmailTemplate');
		$this->EmailTemplate = new EmailTemplate;
		
		/**send email to buyer starts here
		
		table: email_templates
		id: 35
		
		**/
		
		$template = $this->EmailTemplate ->find('first',array('conditions'=>array("EmailTemplate .id"=>35),'fields' =>array( 'EmailTemplate.description','EmailTemplate.subject','EmailTemplate.from_email')));

		$data = $template['EmailTemplate']['description'];
		$data = str_replace('[BuyerDisplayName]',$order_info['UserSummary']['firstname'].' '.$order_info['UserSummary']['lastname'],$data);
		
		$this->Email->from = $template['EmailTemplate']['from_email'];
		$this->Email->smtpOptions = array(
						'host' => Configure::read('host'),
						'username' =>Configure::read('username'),
						'password' => Configure::read('password'),
						'timeout' => Configure::read('timeout')
					);
		
		$or_number = $order_info['Order']['order_number'];
		$or_number ='<a href="'.SITE_URL.'orders/view_open_order?utm_source=Cancelled+Items+from+Your+Marketplace+Orderur&amp;utm_medium=email">'.$or_number.'</a>';
		
		$data = str_replace('[OrderNumber]',$or_number,$data);
		$data = str_replace('[customeremailaddress]',$order_info['UserSummary']['email'],$data);
		
		
		foreach ($item_info as $items){
		$data = str_replace('[Qty]',$items['OrderItem']['quantity'],$data);
		$data = str_replace('[Price]',CURRENCY_SYMBOL.number_format($items['OrderItem']['price'],2),$data);
		$data = str_replace('[ItemName]',$items['OrderItem']['product_name'],$data);
		
		if($items['OrderItem']['delivery_method'] == 'E'){
			$delivery_method = 'Express';
		} else{
			$delivery_method = 'Standard';
		}
		$data = str_replace('[DeliveryMethodSelected]',$delivery_method,$data);
		
		if(!empty($items['OrderItem']['estimated_delivery_date']))
			$estimated_delivery_date = date('d F Y',strtotime($items['OrderItem']['estimated_delivery_date']));
		else
			$estimated_delivery_date = '';
			$data = str_replace('[DateMonthYear]',$estimated_delivery_date,$data);
		}
		
		$or_number = $order_info['Order']['order_number'];
		$template['EmailTemplate']['subject'] = str_replace('[OrderNumber]',$or_number,$template['EmailTemplate']['subject']);
		
		$this->Email->subject = $template['EmailTemplate']['subject'];
		$this->Email->to = $order_info['UserSummary']['email'] ;
		$this->Email->sendAs  =   'html';
		
		$this->Email->send($data);
		
		
		/***ends**/
		
		
		/**
		table: email_templates
		id: 21
		description: Seller Cancel Item
		*/
		$template = $this->EmailTemplate ->find('first',array('conditions'=>array("EmailTemplate .id"=>21),'fields' =>array( 'EmailTemplate.description','EmailTemplate.subject','EmailTemplate.from_email')));

		$data=$template['EmailTemplate']['description'];
		foreach ($item_info as $items) {
		$data = str_replace('[SellersDisplayName]',$items['OrderItem']['seller_name'],$data);
		
		$product_id = $items["OrderItem"]["product_id"];
		$seller_id = $items["OrderItem"]["seller_id"];
		$link_to_seller = '<a href="'.SITE_URL.'sellers/summary/'.$seller_id.'/'.$product_id.'?utm_source=Cancelled+Items+from+Your+Marketplace+Orderur&amp;utm_medium=email">'.$items['OrderItem']['seller_name'].'</a>';
		$data = str_replace('[LinkToSellersDisplayName]',$link_to_seller,$data);
		
		$this->Email->from = $template['EmailTemplate']['from_email'];
		
		$or_number = $order_info['Order']['order_number'];
		$or_number ='<a href="'.SITE_URL.'sellers/orders?utm_source=Cancelled+Items+from+Your+Marketplace+Orderur&amp;utm_medium=email">'.$or_number.'</a>';
		$data = str_replace('[OrderNumber]',$or_number,$data);
		$data = str_replace('[customeremailaddress]',$order_info['UserSummary']['email'],$data);
		$data = str_replace('[Qty]',$items['OrderItem']['quantity'],$data);
		$data = str_replace('[Price]',CURRENCY_SYMBOL.number_format($items['OrderItem']['price'],2),$data);
		$data = str_replace('[ItemName]',$items['OrderItem']['product_name'],$data);
		if($items['OrderItem']['delivery_method'] == 'E'){
			$delivery_method = 'Express';
		} else{
			$delivery_method = 'Standard';
		}
		$data = str_replace('[DeliveryMethodSelected]',$delivery_method,$data);
		
		if(!empty($items['OrderItem']['estimated_delivery_date']))
			$estimated_delivery_date = date('d F Y',strtotime($items['OrderItem']['estimated_delivery_date']));
		else
			$estimated_delivery_date = '';
			
		$data = str_replace('[DateMonthYear]',$estimated_delivery_date,$data);
		$or_number = $order_info['Order']['order_number'];
		$template['EmailTemplate']['subject'] = str_replace('[OrderNumber]',$or_number,$template['EmailTemplate']['subject']);
		$this->Email->subject = $template['EmailTemplate']['subject'];
		
		$this->Email->to = $items['SellerSummary']['email'];
		//$this->Email->to = "simar.smartdata@gmail.com" ;
		
		/******import emailTemplate Model and get template****/
		$this->Email->sendAs  =   'html';
		$this->Email->send($data);
		}
		
	}	

} /**************************/
?>