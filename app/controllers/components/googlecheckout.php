<?php


/** import all the venders  required files */
App::import('Vendor','googlecart' ,          array('file'=>'googlecheckout/googlecart.php'));
App::import('Vendor','googleitem' ,          array('file'=>'googlecheckout/googleitem.php'));
App::import('Vendor','googleshipping' ,      array('file'=>'googlecheckout/googleshipping.php'));
App::import('Vendor','googletax' ,           array('file'=>'googlecheckout/googletax.php'));
                        

class GooglecheckoutComponent extends Object{
    
     var $components =  array('Session','Email','File', 'Common','Ordercom');
    
    
    /**
     *@ function to prcess the payment
     *# created by: kulvinder
     *@ created : 15-feb 2011
     */
    function processGoogleCheckout($orderData) {
          if(empty($orderData) ){ // return false if the order data is empty
               return false;
          }
          //$server_type = 'sandbox';    // sandbox - live
          //$currency =  "USD";
          $server_type = 'live';    // sandbox - live
          $currency = "GBP";
          
          if($server_type == "live"){
               $merchant_id 	= MERCHANT_ID_GC_LIVE;
               $merchant_key 	= MERCHANT_KEY_GC_LIVE;
               
          }else{ // gyanp test account info
               $merchant_id 	= MERCHANT_ID_GC_TEST;
               $merchant_key 	= MERCHANT_KEY_GC_TEST;
          }
               
               
          $orderId       = $orderData['id'];
          $order_number  = $orderData['order_number'];
           
          if(empty($order_number) ){ // return false if the order number is empty
               return false;
          }
               
          // Add items to the cart
          $cart = new GoogleCart($merchant_id, $merchant_key, $server_type, $currency);         
          $mySessId = session_id();
          
          $orderType = 'CART';
          $SessionIDAndOrderNumber = $mySessId.'~'.$order_number.'~'.$orderType; 
          $cart->SetMerchantPrivateData($SessionIDAndOrderNumber);
          
          #########################################################################################
          $basketItemsData = $this->Common->get_basket_listing(); //get basket listing data
          $TotalDelivery  = 0;
          $delivery_price = 0;
          $giftwrap_price = 0;
          
          // add items to google  cart 
          if(is_array($basketItemsData)){ 
               foreach($basketItemsData as $key=>$item) {
                     
                    $giftwrap_price += ($item['Basket']['giftwrap_cost']*$item['Basket']['qty']);
                    
                    if($item['Basket']['delivery_method'] == 'E'){
                         $shippingAmount = $item['Basket']['exp_delivery_cost']*$item['Basket']['qty'];
                    }else{
                         $shippingAmount = $item['Basket']['delivery_cost']*$item['Basket']['qty'];
                    }
                    $delivery_price += $shippingAmount;                                  
                    $price = $item['Basket']['price'];    
                    $item_to_cart = new GoogleItem($item['Product']['product_name'],'Choiceful Products',$item['Basket']['qty'],number_format($price,2));       
                    $cart->AddItem($item_to_cart);
               }
          }
      #########################################################################################
              
          $TotalDelivery = $delivery_price;
          $GiftWrapCost  = $giftwrap_price;     
          // apply the shipping charges if any
          if($TotalDelivery > 0){
               $shipping_item = new GoogleFlatRateShipping("Shipping",number_format($TotalDelivery,2));    
               $cart->AddShipping($shipping_item);       
          }
          
     ###################################### Add Additional items to cart if any ##################################
          
          if($GiftWrapCost > 0){
                $giftwrap_item = new GoogleItem("Gift-Wrap","", 1, number_format($GiftWrapCost,2));
                $cart->AddItem($giftwrap_item);
                
          }         
                    
          $insurance_cost = $orderData['insurance_amount'];
          if($insurance_cost > 0){
                $insurance_item = new GoogleItem("Insurance Charges","", 1, number_format($insurance_cost,2));
                $cart->AddItem($insurance_item);;  
          }
               
          $dc_amount = $orderData['dc_amount']; // discount amount if any 
          $gc_amount = $orderData['gc_amount']; // gift certificate amount if any
          
         // $gc_amount = 5.00;
         // $dc_amount = 8.00;
          if($dc_amount > 0){ // if discount amount is applied
               $discount_item = new GoogleItem("Discount Coupon"," Discount Coupon Amount", 1, '-'.number_format($dc_amount,2));
               $cart->AddItem($discount_item);
          }
          if($gc_amount > 0){ // if gift certificate balance is applied
               $discount_item = new GoogleItem("Gift Balance","User's Gift Certificate Balance", 1, '-'.number_format($gc_amount,2));
               $cart->AddItem($discount_item);
          }
      
      #####################################################################################
          $cart->SetRequestBuyerPhone(true);
          
          // Specify <edit-cart-url>
          $edit_cart_url = SITE_URL."baskets/view";
          $cart->SetEditCartUrl($edit_cart_url);
          
          // Specify "Return to xyz" link
         
          $orderId_encoded = base64_encode($orderId);
	  $return_url =  SITE_URL."checkouts/order_complete/".$orderId_encoded;
          $cart->SetContinueShoppingUrl($return_url);
          $cart->CheckoutButtonCode();
          // Display Google Checkout button
          return $cart->CheckoutButtonCode();
  }                      
          
          
	 /**
	*@ function to prcess the payment
	*# created by: Ramanpreet Pal Kaur
	*@ created : 15-feb 2011
	*/
	function processGiftGoogleCheckout($orderData) {
                    
               if(empty($orderData) ){ // return false if the order data is empty
                 return false;
               }
                    
               //$server_type = 'sandbox';    // sandbox - live
              // $currency = "GBP";
               $server_type = 'live';    // sandbox - live
               $currency = "GBP";
                    
               if($server_type == "live"){
                    $merchant_id 	= MERCHANT_ID_GC_LIVE;
                    $merchant_key 	= MERCHANT_KEY_GC_LIVE;
                    
               }else{ // kulvinder test account info
                    $merchant_id 	= MERCHANT_ID_GC_TEST;
                    $merchant_key 	= MERCHANT_KEY_GC_TEST;
               }
                    
               $or_Arr = explode('-|-',$orderData['OrderCertificate']['id']);
               $orderId = $or_Arr[0];
               
               if(empty($orderId) ){ // return false if the order number is empty
                    return false;
               }
               
               // Add items to the cart
               $cart = new GoogleCart($merchant_id, $merchant_key, $server_type, $currency);         
               $mySessId = session_id();
               $orderType = 'GIFT';
               $SessionIDAndOrderNumber = $mySessId.'~'.$orderId.'~'.$orderType; 
               $cart->SetMerchantPrivateData($SessionIDAndOrderNumber);
                    
               #########################################################################################
              // $basketItemsData = $this->Common->get_basket_listing(); //get basket listing data
               $giftcertificate_data = $this->Common->get_ordercertificate($orderId);
                    
               // add items to google  cart 
               if(is_array($giftcertificate_data)){ 
                    $price = $giftcertificate_data['OrderCertificate']['total_amount'];    
                    $item_to_cart = new GoogleItem('Gift Certificates','Choiceful giftcertificates',1,number_format($price,2));       
                    $cart->AddItem($item_to_cart);
               }
                    
               #####################################################################################
               $cart->SetRequestBuyerPhone(true);
                    
               // Specify <edit-cart-url>
               $edit_cart_url = SITE_URL."certificates/purchase_gift";
               $cart->SetEditCartUrl($edit_cart_url);
                    
               // Specify "Return to xyz" link
                    
               $orderId_encoded = base64_encode($orderId);
               $return_url =  SITE_URL."checkouts/giftcertificate_step4/".$orderId_encoded;
               $cart->SetContinueShoppingUrl($return_url);
               $cart->CheckoutButtonCode();
               // Display Google Checkout button
               return $cart->CheckoutButtonCode();
          }
}