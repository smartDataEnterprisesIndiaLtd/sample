<?php
/**  @class:		MarketplacesController 
 @description		 etc.,
 @Created by: 		kulvinder Singh
 @Modify:		NULL
 @Created Date:		11 JAn 2011
*/

App::import('Sanitize');
class BasketsController extends AppController{
	var $name = 'Basket';
	var $helpers =  array('Html', 'Form','Common', 'Javascript','Session','Validation','Ajax', 'Format');
	var $components =  array('RequestHandler','Email','Common','File','Thumb','Session', 'Cookie','Ordercom');
	var $paginate =  array();
	//var $permission_id = '' ;  // for product module
	
	/**
	* @Date: jan 11, 2011
	* @Method : beforeFilter
	* Created By: kulvinder singh
	* @Purpose: This function is used to validate admin user permissions
	* @Param: none
	* @Return: none 
	**/
	function beforeFilter(){
		$this->detectMobileBrowser();
	}
	
	/**
	* @Date: jan 12, 2011
	* @Method : cleanBasket
	* Created By: kulvinder singh
	* @Purpose: This function is used to remove the all records since last night  
	* @Return: none 
	**/
	function cleanBasket(){
		$sqlStr = "DELETE FROM baskets WHERE created < DATE_SUB( NOW( ) , INTERVAL 2 DAY )";
		$this->Basket->query($sqlStr);
	}
	
	
	/** 
	@function: updateBasket
	@Created by: Kulvinder
	@Modify:  12 JAn 2010 
	*/
	function updateBasket(){
		$this->layout = 'ajax';
		
		$qtyFieldName = "qty".$this->data['Basket']['id'];
		$this->data['Basket']['qty'] = $this->data['Basket'][$qtyFieldName];
		
		if(!empty($this->data) ){ // update the data
			if( !empty($this->data['Basket']['id']) &&  !empty($this->data['Basket']['qty']) ){
				if( $this->data['Basket']['qty'] > 0  &&  !empty($this->data['Basket']['qty']) ){

					if( intval($this->data['Basket']['qty']) >  intval($this->data['Basket']['available_stock']) ){
						$this->data['Basket']['qty'] = $this->data['Basket']['available_stock'];
					}else{
						$this->data['Basket']['qty'] = intval($this->data['Basket']['qty']);
					}
					//pr($this->data);
					
					$this->data = $this->cleardata($this->data);
					//$this->data = Sanitize::clean($this->data, array('encode' => false));
					
					$this->Basket->id = $this->data['Basket']['id'];
					$this->Basket->saveField('qty', $this->data['Basket']['qty']);
					$this->Session->setFlash('Shopping basket has been updated','default',array('class'=>'message'));
				}
			}elseif($this->data['Basket']['qty'] == '0'){ // delete product if quantity is zero
				$basket_id = $this->data['Basket']['id'];
				if( !empty($basket_id) ){ // delete the basket item
					$this->Basket->delete($basket_id);
				}
			}else{ // do nothing
				echo '';
			}
		}
		//fetch the basket listing
		$cartData = $this->getBasketListing();
		//pr($cartData);
		$this->set('cartData',$cartData);
		// set the view path for this action	
		if ($this->RequestHandler->isMobile()) {
			$this->viewPath = "elements/basket/mobile";
		}else{
			$this->viewPath = "elements/basket";
		}
		$this->render('basket_listing');
	}
	
	
	/** 
	@function: deleteBasketItem
	@description: deleteBasketItem
	@Created by: Kulvinder
	@Modify:  12 JAn 2010 
	*/
	function deleteBasketItem(){
		$this->layout = 'ajax';
		if(!empty($this->data) ){ // delete the cart data
			$basket_id = $this->data['Basket']['id'];
			if( !empty($basket_id) ){ // delete the basket item
				$this->Basket->delete($basket_id);
			}
		}
		//fetch the basket listing
		$cartData = $this->getBasketListing();
		$this->set('cartData',$cartData);
		// set the view path for this action	
		if ($this->RequestHandler->isMobile()) {
			$this->viewPath = "elements/basket/mobile";
		}else{	
			$this->viewPath = "elements/basket";
		}
		$this->render('basket_listing');
	}
	
	
	/** 
	@function: view
	@description: view
	@Created by: Kulvinder
	@Modify:  11 JAn 2010 
	*/function view(){
		
		if ($this->RequestHandler->isMobile()) {
            	// if device is mobile, change layout to mobile
           			$this->layout = 'mobile/product';
           		}else if($this->RequestHandler->isAjax()==0){
 				$this->layout = 'product';
			}else{
				$this->layout = 'ajax';
		}
		$this->set('title_for_layout','Choiceful.com Shopping Basket');
		
		###################  Add product data to the product visit ################
		App::import('Model','ProductVisit');
		$this->ProductVisit = new ProductVisit;
		$myRecentProducts = $this->ProductVisit->getMyVisitedProducts();
		$this->set('myRecentProducts',$myRecentProducts);
		
		#############################################	
		if(!empty($this->data)){
			// set the basket data as per the quantitiy of in stock
			$this->Ordercom->setBasketDataAsPerStock();
			
			if(strtolower($this->data['Basket']['pay_now']) == 'yes'){
				$this->redirect('/checkouts/step1');
			}else{
				
			}
		}else{
			// get basket data and set 		
			$cartData = $this->getBasketListing();
			$this->set('cartData',$cartData);
			
		}
		#############################################	
		
		
	}
	
	
	/** 
	@function: getBasketListing
	@description: getBasketListing
	@Created by: Kulvinder
	@Modify:  12 JAn 2010 
	*/
	function getBasketListing(){
		#### clean basket  ####
		$this->cleanBasket();
		$logg_user_id = $this->Session->read('User.id');
		$session_id = session_id();
		$cartData = $this->Common->get_basket_listing();
		//pr($cartData);
		return $cartData;
	}
	
	/** 
	@function: ProductExists
	@Created by: Kulvinder
	@Modify:  11 JAn 2010 
	*/
	function productExists($TestData){
		$product_id = $TestData['Basket']['product_id'];
		$condition_id = $TestData['Basket']['condition_id'];
		$seller_id = $TestData['Basket']['seller_id'];
		
		$session_id = session_id();
		$cartDetails = $this->Basket->find('all',array(
			'conditions'=>array('Basket.product_id'=>$product_id, 'Basket.condition_id'=>$condition_id,
					    'Basket.seller_id'=>$seller_id, 'Basket.session_id'=>$session_id),
			'fields'=>array('Basket.id')
			));
		
		if( is_array($cartDetails) && count($cartDetails) > 0) {
			return $cartDetails[0]['Basket']['id'];
		}else{
			return '';
		}
	}
	
	
	/** 
	@function: minibasket
	@description: minibasket
	@Created by: Kulvinder
	@Modify:  11 JAn 2010 
	*/
	function minibasket($id){
		$this->layout = 'ajax';
		if($id==2){
			$this->viewPath = "elements/mobile/basket";
			$this->render('header_minibasket');
		}else if($id==1){
			$this->viewPath = "elements/basket";
			$this->render('header_minibasket');
		}
 		/*$this->layout = 'ajax';
		if ($this->RequestHandler->isMobile()) {
			$this->viewPath = "elements/mobile/basket";
			$this->render('header_minibasket');
		}
		*/
	}
	
	/** 
	@function: add
	@description: add  value to shopping cart
	@Created by: Kulvinder
	@Modify:  11 JAn 2010 
	*/
	function add_to_basket($product_id = null, $qty=null,$price=null,$seller_id=null,$condition=null,$offer=null){
		if($this->RequestHandler->isAjax()==0){
 			$this->layout = 'ajax';
		}else{
			$this->layout = 'ajax';
		}
		# add product in the basket
		$this->add_products($product_id,$qty,$price,$seller_id,$condition,$offer);
		$this->set('offer_product',$offer);
		
		// set the view path for this action	
		if ($this->RequestHandler->isMobile()) {
			$this->viewPath = "elements/mobile/basket";
			$this->render('header_minibasket');
		}else{
			$this->viewPath = "elements/basket";
			$this->render('header_minibasket');
		}
	}

	/** 
	@function: getAddedItemsCount
	@Created by: Kulvinder
	@Modify:  14 Jan 2011
	*/
	function getAddedItemsCount($pID, $cID){
		$totalItems = 0;
		$session_id = session_id();
		
		$totalItems = $this->Basket->find('first',array(
			'conditions'=>array('session_id'=>$session_id, 'product_id'=>$pID, 'condition_id'=>$cID),
			'fields'=> array('SUM(qty) as total_items')
			));
		//pr($totalItems);
		return $totalItems[0]['total_items'];
	}
	
	
	/** 
	@function: to add products in the basket
	@Created by: Kulvinder
	@Modify:  14 Jan 2011 
	*/
	function add_products($product_id = null, $qty=null,$price=null,$seller_id=null,$condition=null,$offer=null){
		$logg_user_id = $this->Session->read('User.id');
		
		if( !empty($logg_user_id) ){
			$this->data['Basket']['user_id'] = $logg_user_id;
		}
		$product_id = (int)$product_id;
		$seller_id = (int)$seller_id;
		if(empty($seller_id) ){ // return back if seller do not exists
			return false;
		}
		//$delivery_cost  = $this->Common->getDeliveryCharges($product_id, $seller_id, $condition);
		$prodSellerData = $this->Common->getProductSellerData($product_id, $seller_id, $condition);
		// pr($prodSellerData); exit();
		$delivery_cost 	 = $prodSellerData['ProductSeller']['standard_delivery_price'];
		$stock_available = $prodSellerData['ProductSeller']['quantity'];
		/*
		if( $qty > $stock_available ){ // if ordered quantity ismore than in stock
			return false;
		}
		*/
		$item_in_basket = $this->getAddedItemsCount($product_id, $condition);
		
		if( $item_in_basket >= $stock_available ){ // if items added in basket is more than in stock
			return false;
		}
		
		 $items_can_be_added = $stock_available-$item_in_basket;
		
		if( $qty > $items_can_be_added ){ // if items added in basket is more than in stock
			//return false;
			$qty = $items_can_be_added;
		}
		
		//pr($prodSellerData); die;
		$SellerInfo    = $this->Common->getsellerInfo($seller_id);
		$totalItemPrice = $price*$qty;
		if($SellerInfo['Seller']['free_delivery'] == '1'){
			if($totalItemPrice >= $SellerInfo['Seller']['threshold_order_value'] ){
				$delivery_cost = 0;	
			}
		  }
		$session_id = session_id();
		$this->data['Basket']['id'] = '';
		$this->data['Basket']['product_id'] = trim($product_id);
		$this->data['Basket']['qty'] = (!empty($qty)?($qty):(1));
		$this->data['Basket']['price'] = trim($price);
		$this->data['Basket']['delivery_cost'] = trim($delivery_cost);
		$this->data['Basket']['seller_id'] = trim($seller_id);
		$this->data['Basket']['condition_id'] = trim($condition);
		$this->data['Basket']['session_id'] = $session_id;
		$this->data['Basket']['offer_id'] = trim($offer);
		
		
		$this->data = $this->cleardata($this->data);
		//$this->data = Sanitize::clean($this->data, array('encode' => false));
			
		//if( !empty($this->data['Basket']['product_id'])  && !empty($this->data['Basket']['seller_id'])   ){
		if(  $product_id > 0  &&  $seller_id > 0   ){
			// check the product is allready addded in basket
			$existBasketId = $this->productExists($this->data);
			
			if( !empty($existBasketId) ) { // edit the quantity for that particular product
				$sqlStr = "update baskets set qty = qty+$qty where id = $existBasketId";
				$this->Basket->query($sqlStr);
			}else{ // add the product
				$this->Basket->save($this->data);
			}
		}
	}


	/** 
	@function: quick_order
	@description: quick_order
	@Created by: Kulvinder
	@Modify:  14 JAn 2010 
	*/
	function quick_order(){
		if($this->RequestHandler->isAjax()==0){
 			$this->layout = 'product';
		}else{
			$this->layout = 'ajax';
		}
		$this->set('title_for_layout','Choiceful.com Quick Order');
		$no_added_product = 0;
		$not_vaild_quick_code ='';
		$final_ses_msg ='';
		$ses_msg_invaildqc ='';
		$not_in_stock_products ='';
		$not_avalable_productseller = '';
		$not_in_stock_products = '';
		$not_avalable_productseller = '';
		if(!empty($this->data)){
			if(!empty($this->data['Basket'])){
				if(!empty($this->data['Basket']['quick_code'])) {
					App::import('Model','Product');
					$this->Product = new Product();
					App::import('Model','ProductSeller');
					$this->ProductSeller = new ProductSeller();
					foreach($this->data['Basket']['quick_code'] as $index=>$qucik_code){
						if(!empty($qucik_code)){
							if(empty($this->data['Basket']['quantity'][$index])){
								$this->data['Basket']['quantity'][$index] = 1;
							}
							$pro_info[$qucik_code] = $this->Product->find('first',array('conditions'=>array('Product.quick_code'=>$qucik_code),'fields'=>array('Product.id','Product.minimum_price_value','Product.minimum_price_seller','Product.minimum_price_used','Product.minimum_price_used_seller','Product.new_condition_id','Product.used_condition_id')));
							if(empty($pro_info[$qucik_code])){
								if(!empty($not_vaild_quick_code))
									$not_vaild_quick_code = $not_vaild_quick_code.','.$qucik_code;
								else
									$not_vaild_quick_code = $qucik_code;
							} else{
								if(!empty($pro_info[$qucik_code]['Product']['minimum_price_value']) && !empty($pro_info[$qucik_code]['Product']['minimum_price_seller'])) {
$instock_qty = $this->ProductSeller->find('first',array('conditions'=>array('ProductSeller.seller_id'=>$pro_info[$qucik_code]['Product']['minimum_price_seller'],'ProductSeller.product_id'=>$pro_info[$qucik_code]['Product']['id'],'(ProductSeller.condition_id = "1" OR ProductSeller.condition_id = "4")'),'fields'=>array('ProductSeller.quantity')));
									if($instock_qty['ProductSeller']['quantity'] >= $this->data['Basket']['quantity'][$index]) {
										$pro = $pro_info[$qucik_code];
$this->add_products($pro['Product']['id'],$this->data['Basket']['quantity'][$index],$pro['Product']['minimum_price_value'],$pro['Product']['minimum_price_seller'],$pro['Product']['new_condition_id']);
									} else {
										if(empty($not_in_stock_products)){
											$not_in_stock_products = $qucik_code;
										} else{
											$not_in_stock_products = $not_in_stock_products.', '.$qucik_code;
										}
									}
								} else if(!empty($pro_info[$qucik_code]['Product']['minimum_price_used']) && !empty($pro_info[$qucik_code]['Product']['minimum_price_used_seller'])) {
$instock_qty = $this->ProductSeller->find('first',array('conditions'=>array('ProductSeller.seller_id'=>$pro_info[$qucik_code]['Product']['minimum_price_used_seller'],'ProductSeller.product_id'=>$pro_info[$qucik_code]['Product']['id'],'ProductSeller.condition_id IN (2,3,5,6,7)'),'fields'=>array('ProductSeller.quantity')));
									if($instock_qty['ProductSeller']['quantity'] >= $this->data['Basket']['quantity'][$index]) {
										$pro = $pro_info[$qucik_code];
										$this->add_products($pro['Product']['id'],$this->data['Basket']['quantity'][$index],$pro['Product']['minimum_price_used'],$pro['Product']['minimum_price_used_seller'],$pro['Product']['used_condition_id']);
									} else {
										if(empty($not_in_stock_products)){
											$not_in_stock_products = $qucik_code;
										} else{
											$not_in_stock_products = $not_in_stock_products.', '.$qucik_code;
										}
									}
								} else{
									$next_new_instock_qty = $this->ProductSeller->find('first',array('conditions'=>array('ProductSeller.product_id'=>$pro_info[$qucik_code]['Product']['id'],'ProductSeller.quantity > 0','ProductSeller.condition_id IN (1,4)'),'fields'=>array('ProductSeller.seller_id','ProductSeller.quantity','ProductSeller.price'),'order'=>array('ProductSeller.price ASC')));
								
									$next_used_instock_qty = $this->ProductSeller->find('first',array('conditions'=>array('ProductSeller.product_id'=>$pro_info[$qucik_code]['Product']['id'],'ProductSeller.quantity > 0','ProductSeller.condition_id IN (2,3,5,6,7)'),'fields'=>array('ProductSeller.seller_id','ProductSeller.quantity','ProductSeller.price'),'order'=>array('ProductSeller.price ASC')));

									if(!empty($next_new_instock_qty)){
										if($next_new_instock_qty['ProductSeller']['quantity'] >= $this->data['Basket']['quantity'][$index]) {
											$pro = $pro_info[$qucik_code];
											$this->add_products($pro_info[$qucik_code]['Product']['id'],$this->data['Basket']['quantity'][$index],$next_new_instock_qty['ProductSeller']['price'],$next_new_instock_qty['ProductSeller']['seller_id'],$next_new_instock_qty['ProductSeller']['condition_id']);
										} else {
											if(empty($not_in_stock_products)){
												$not_in_stock_products = $qucik_code;
											} else{
												$not_in_stock_products = $not_in_stock_products.', '.$qucik_code;
											}
										}
									} else if(!empty($next_used_instock_qty)){
										if($next_used_instock_qty['ProductSeller']['quantity'] >= $this->data['Basket']['quantity'][$index]) {
											$pro = $pro_info[$qucik_code];
											$this->add_products($pro_info[$qucik_code]['Product']['id'],$this->data['Basket']['quantity'][$index],$next_used_instock_qty['ProductSeller']['price'],$next_used_instock_qty['ProductSeller']['seller_id'],$next_used_instock_qty['ProductSeller']['condition_id']);
										} else {
											if(empty($not_in_stock_products)){
												$not_in_stock_products = $qucik_code;
											} else{
												$not_in_stock_products = $not_in_stock_products.', '.$qucik_code;
											}
										}
									} else {
										if(empty($not_in_stock_products)){
											$not_in_stock_products = $qucik_code;
										} else{
											$not_in_stock_products = $not_in_stock_products.', '.$qucik_code;
										}
									}
								}
							}
							if(!empty($not_avalable_productseller)){
								$ses_msg = 'Seller for following products, is not available yet : <br>'.$not_avalable_productseller;
							}
							if(!empty($not_in_stock_products)){
								$ses_msg_not_stock = 'The following Quick Codes have not been added to your shopping basket as they are currently not in stock. '.$not_in_stock_products;
							}
							if(!empty($not_vaild_quick_code)){
								$ses_msg_invaildqc = 'The following Quick Codes have not been added to your shopping basket, as they do not exist on Choiceful.com, please recheck and type again.<br>'.$not_vaild_quick_code;
							}
						} else {
							$no_added_product = $no_added_product+1;
						}
					}

					if($no_added_product == 14){
						$this->Session->setFlash('Please enter the QuickCodes of the items you would like to add to your shopping basket.','default',array('class'=>'flashError'));
					} else{
						if(!empty($ses_msg) || !empty($ses_msg_not_stock) || !empty($ses_msg_invaildqc)){
							if(!empty($ses_msg)){
								$final_ses_msg = $ses_msg;
							}
							if(!empty($ses_msg_not_stock)){
								if(empty($final_ses_msg)){
									$final_ses_msg = $ses_msg_not_stock;
								} else{
									$final_ses_msg = $final_ses_msg.'<br>'.$ses_msg_not_stock;
								}
							}
							if(!empty($ses_msg_invaildqc)){
								if(empty($final_ses_msg)){
									$final_ses_msg = $ses_msg_invaildqc;
								} else{
									$final_ses_msg = $final_ses_msg.'<br>'.$ses_msg_invaildqc;
								}
							}
							if(!empty($final_ses_msg)){
								$this->Session->setFlash($final_ses_msg,'default',array('class'=>'flashError'));
							}
						} else{
							$this->Session->setFlash('Order added succesfully.');
						}
					}
				}
			}
		}
		$this->data['Basket'] = '';

		
		
		###################  Add product data to the product visit ################
		App::import('Model','ProductVisit');
		$this->ProductVisit = new ProductVisit;
		$myRecentProducts = $this->ProductVisit->getMyVisitedProducts();
		$this->set('myRecentProducts',$myRecentProducts);
			
		#############################################	
		
	}
}
?>