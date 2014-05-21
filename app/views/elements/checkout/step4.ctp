<?php echo $javascript->link(array('jquery-1.3.2.min','lib/prototype'), false); ?>
<?php 
echo $javascript->link('fancybox/jquery.fancybox-1.3.1.pack.js');
echo $javascript->link('fancybox/jquery.easing-1.3.pack.js');
echo $javascript->link('fancybox/jquery.mousewheel-3.0.2.pack.js');
echo $html->css('jquery.fancybox-1.3.1.css');

?>


<script type="text/javascript" >

	//open_fancy_box_id
	jQuery(document).ready(function()  { // to delete the offer
		//jQuery("a.underline-link").fancybox({
		jQuery("a.fancy_box_open").fancybox({
			'autoScale' : true,
			'width' : 450,
			'height' : 150,
			'padding':0,
			'overlayColor':'#DFDFDF',
			'overlayOpacity':0.7,
			'opacity':	true,
			'transitionIn' : 'fade',
			'transitionOut' : 'fade',
			'hideOnOverlayClick':false,
			'type' : 'iframe',
			'autoDimensions': false,
			'onClosed': function() {
				//parent.location.reload(true);;
			}
		});
	});
/*
	jQuery(document).ready(function(){
		showOrderSummaryBox();
	});

// function to show updated mini shopping cart on the page
function showOrderSummaryBox(){
	var postUrl =  SITE_URL+'checkouts/basket_order_summary'
	//alert(postUrl);
	jQuery.ajax({
		cache: false,
		async: false,
		type: "GET",
		url: postUrl,
		success: function(msg){
		//  Update the div 
		jQuery('#order_summary_box_id').html(msg);
		
	}
	});		  
}

// function to apply the discount coupon code
 
function applyDiscountCoupon(){
	var dcCode = jQuery("#dc_code_textbox_id").val();
	    dcCode = jQuery.trim(dcCode);
	    
	if(dcCode == ''){ // if blank then return false
		return false;
	}else{ // proceed further 
		var postUrl = SITE_URL+'checkouts/applyDiscountCoupon/'+dcCode
		jQuery('#plsLoaderID').show();
		jQuery.ajax({
			cache: false,
			async: false,
			type: "GET",
			url: postUrl,
			success: function(msg){
			// Update the div  
			jQuery('#order_summary_box_id').html(msg);
			jQuery('#plsLoaderID').hide();
			location.reload();
			
		}
		});	
	}
}
*/

</script>

	<!--Content Start-->
	<div id="checkout-content">
		<!--Left Content Start-->
		<?php echo $this->element('checkout/left'); // include left side bar ?>
		<!--Left Content Closed-->
        <!--Left Content Closed-->
        <div class="right-con">&nbsp;</div>
         <!--Right Content Start-->
         <div class="checkout-right-content1">
         
         	<!--Form Left Widget Start-->
           <div class="form-checkout-widget1">
                  
		
                  <!--Form Widget Start-->
		
                  <div class="form-widget">
                    <ul>
                        <li>
           	  		<div class="checkout-pro-widget" style="border:none;">
					
					<?php // display session error message
					if ($session->check('Message.flash')){ ?>
					<div  class="messageBlock"><?php echo $session->flash();?></div>
					<?php } ?>
					
                                <!--Left Start-->
                            	<div class="edit-info-left">
					
                                	<p class="smalr-fnt margin-bottom">Please review your order and make any changes before processing through for payment. <strong>Please review all options below:</strong></p>
                                    
                                    <!--Options Start-->
                                    <ul class="options">
                                        <li>
                                        	<p class="smalr-fnt"><strong>Your order is being dispatched to:</strong></p>
                                        	<div class="arrow"></div>
                                            <div class="billing-add">
						
						
						<?php
						if(!empty($sessOrderData['shipping_country_id']) ){
							$billing_country_name = $countries[$sessOrderData['shipping_country_id']];
						}
						?>
                                            	<p><strong><?php echo $sessOrderData['shipping_user_title']." ".$sessOrderData['shipping_firstname']; ?></strong></p>
                                                <p><strong><?php echo $sessOrderData['shipping_address1']; ?></strong></p>
						<p><strong><?php echo $sessOrderData['shipping_address2']; ?></strong></p>
                                                <p><strong><?php echo $sessOrderData['shipping_city'];?></strong></p>
						<p><strong><?php echo $sessOrderData['shipping_state'];?></strong></p>
						<p><strong><?php echo $sessOrderData['shipping_postal_code'];?></strong></p>
                                                <p><strong><?php echo $billing_country_name;?></strong>
							<?php echo $html->link( $html->image('checkout/change-btn.gif', array('width'=>"46" ,'height'=>"14", 'alt'=>"", 'class'=>"v-align-middle margn-lt", 'border'=>'') ) , '/checkouts/step3' , array('div'=>false, 'label'=>false, 'escape'=>false)  );?>
						</p>
                                            </div>
                                        </li>
                                        <li><h3 class="bl-dif">Order Items</h3></li>
					<?php
					//pr($cartData);
					if(is_array($cartData)  && count($cartData) > 0){
					foreach($cartData as $cart){
						$prodId = $cart['Basket']['product_id'];
						$cartId = $cart['Basket']['id'];
						$sellerId = $cart['Basket']['seller_id'];
						###  product seller info ###
						$prodSellerInfo = $common->getProductSellerInfo($prodId,$sellerId, $cart['Basket']['condition_id'] );
						$totalQty = $prodSellerInfo['ProductSeller']['quantity'];
						if( $totalQty >= $cart['Basket']['qty']  ){ //skip item if seller have 0  item to sale 
						 	$availability = "In Stock";
						}else{
							$availability = "Out of Stock";
						}
						
						
						#--------------------------#
						// pr($prodSellerInfo);
						$sellerInfo = $this->Common->getsellerInfo($cart['Basket']['seller_id']);
						
						$loopName = "Product$prodId";
						
						
						if($this->data[$loopName][$prodId] == 'yes'){
							$gschecked_y = "checked=checked";
							$gschecked_n = "";
						}else{
							$gschecked_y = '';
							$gschecked_n = "checked=checked";
						}
						
						
					?>
                                        <li>
						<div class="arrow"><?php echo $html->image("checkout/lt-blue-arrow.png" ,array('width'=>"5",'height'=>"9", 'alt'=>"", 'escape'=>false )); ?></div>
						<div class="billing-add">
						<p class="smalr-fnt"><strong><?php echo $cart['Product']['product_name'] ;?> -</strong> <span class="red-color"><strong><?php echo CURRENCY_SYMBOL,$cart['Basket']['price'] ;?></strong></span></p>
						<p><strong>Quantity: <?php echo $cart['Basket']['qty'] ;?></strong></p>
						<p><strong>Availability: <?php echo $availability;?></strong></p>
						
						<p><?php echo $html->image("gift-icon.gif" ,array('width'=>"13",'height'=>"13", 'alt'=>"", 'escape'=>false ,'class'=>"v-align-middle")); ?>
						<strong>Giftwrap Option: <?php echo $cart['Basket']['giftwrap'];?></strong>
						<?php echo $html->link( $html->image('checkout/change-btn.gif', array( 'alt'=>"", 'class'=>"v-align-middle margn-lt", 'border'=>'') ) , '/checkouts/step2' , array('div'=>false, 'label'=>false, 'escape'=>false)  );?>
						</p>
						
						</div>
                                      </li>
                                     <?php  } // foreach ends
				     } ?>
                                    </ul>
                                    <!--Options Closed-->
                                    
                              </div>
                                <!--Left Closed-->
                                
                                <!--Right Start-->
                            	<div class="edit-info-right">
                                	
                                    <!--Total Widget Start-->
                                	<div class="side-content">
                                    	
                                        <div class="border">
                                            <h5 class="gr-fade-head text-align-center smalr-fnt">Choiceful.com Order Summary</h5>
					    
                                            <!--Calculation Start-->
					    
                                            <ul class="calculate" id="order_summary_box_id">
						
					<?php
					
					############ DISCOUNT COUPON SECTION  START HERE ######
					//echo session_id();
					$user_id = $this->Session->read('User.id');
					$dcSessData = $this->Session->read('dcSessData');
					
					
					//$dcData  = $this->Common->getAppliedCouponData($user_id);
					if(!empty($dcSessData) ){
						$discount_coupon_amount = $dcSessData['amount'];
						$discount_code		= $dcSessData['discount_code'];
					}else{
						$discount_coupon_amount = 0;
						$discount_code = ''; 
					}
					############ DISCOUNT COUPON SECTION  END HERE ######
					
					
					
					############ INSURANCE START HERE ######
					if($sessOrderData['insurance'] == '1'){		
						$insurance_cost  = $settings['Setting']['insurance_charges'];
					}else{
						$insurance_cost  = 0;
					}
					############ INSURANCE END HERE ######
					
					$order_cost_before 	= $basketPriceData['item_total_cost']+$basketPriceData['shipping_total_cost']+$basketPriceData['giftwrap_total_cost']+$insurance_cost;;
					
					############ GIFT CERTIFICATE SECTION START HERE ######
					if(!empty($gc_amount) ){
					if($gc_amount > $order_cost_before ){
						$gift_balance_cost = $order_cost_before;
					}else{
						$gift_balance_cost = $gc_amount;
					}
					}else{
						$gift_balance_cost  = 0;
					}
					############ GIFT CERTIFICATE SECTION  END HERE ######
					$total_order_cost = $order_cost_before - ($discount_coupon_amount + $gift_balance_cost);
					
					$this->set('total_order_cost', $total_order_cost);
					$this->set('discount_coupon_amount', $discount_coupon_amount);
					$this->set('gift_balance_cost', $gift_balance_cost);
					$this->set('insurance_cost', $insurance_cost);
					
					
					$tax  = $settings['Setting']['tax'];

					//$tax_total_cost = ($total_order_cost*$tax)/100;
					//$total_order_before_tax  = ($total_order_cost - $tax_total_cost);
					$total_order_cost = round($total_order_cost,2);
					$total_order_before_tax = round($total_order_cost/(1+$tax/100),2);
					$tax_total_cost = round($total_order_cost - $total_order_before_tax ,2);

					$this->set('total_order_before_tax', $total_order_before_tax);
					$this->set('tax_total_cost', $tax_total_cost);

					$userBalanceCost = $discount_coupon_amount+$gift_balance_cost ;
					
					?>

					<?php
					echo $this->element('checkout/basket_order_summary_box'); // include left side bar
					
					?>
						
                                            </ul>
					    
					    <ul class="calculate">
                                               <li class="padding-row">
						<p><span class="gray smalr-fnt"><strong>Your Billing address is:</strong></span></p>
						<?php
						if(!empty($sessOrderData['billing_country_id']) ){
							$billing_country_name = $countries[$sessOrderData['billing_country_id']];
						}
						?>
                                            	<p><?php echo $sessOrderData['billing_user_title']." ".$sessOrderData['billing_firstname']; ?></p>
                                                <p><?php echo $sessOrderData['billing_address1']; ?></p>
						<p><?php echo $sessOrderData['billing_address2']; ?></p>
                                                <p><?php echo $sessOrderData['billing_city'];?></p>
						<p><?php echo $sessOrderData['billing_state'];?></p>
						<p><?php echo $sessOrderData['billing_postal_code'];?>
                                                <p><?php echo $billing_country_name;?>
						<?php echo $html->link( $html->image('checkout/change-btn.gif', array('width'=>"46" ,'height'=>"14", 'alt'=>"", 'class'=>"v-align-middle margn-lt", 'border'=>'') ) , '/checkouts/step3' , array('div'=>false, 'label'=>false, 'escape'=>false)  );?>
						</p>
                                              </li>
					       
                                            </ul>
                                            <!--Calculation Closed-->
                                         </div>
                                    
                                    </div>
                                    <!--Total Widget Closed-->
                                    
                                     <!--Total Widget Start-->
					<div class="side-content border gray">
						

                                    	<?php echo $form->create("Checkout", array('action'=>'applyDiscountCoupon','name'=>'frmCoupon', 'onsubmit'=>'return validateCouponCode();'));?>  
                                        <h5 class="gr-background-head">Enter discount code <span class="font-weight-normal">(if applicable)</span></h5>
                                       
					<div class="padding-row">
                                       	  <p>Enter your discount code and then click Update:</p>
					
					
					
					  <div id="coupon_code_error" class="error-message-simple"></div> 
                                            <p>
                                              <input type="text" id="dc_code_textbox_id" name="data[Checkout][dc_code]" class="form-textfield" style="width:120px; margin-right:0px;" />
                                              <!--<input type="image" src="/img/checkout/update-btn.png" onclick="applyDiscountCoupon()" class="v-align-middle" style="cursor:pointer;"/>-->
					       <input type="image" src="/img/checkout/update-btn.png" class="v-align-middle" style="cursor:pointer;"/>
                                            </p>
                                        </div>
                                    <?php echo $form->end(); ?>
				    
                                    </div>
                                    <!--Total Widget Closed-->
                                
                                </div>
                                <!--Right Closed-->
                            
                            </div>
                        </li>
                 
                         <li>
                       	  <div class="checkout-pro-widget">
                          	<h3 class="bl-dif padding-row">Delivery Options</h3>
                            <?php
			foreach($cartData as $cart){
				//pr($cart);		    
			  $prodId   = $cart['Basket']['product_id'];
			  $sellerId = $cart['Basket']['seller_id'];
			  $cartId   = $cart['Basket']['id'];
						    
			  $prodName  = $cart['Product']['product_name'];
			  $prodQty   = $cart['Basket']['qty'];
			  $prodPrice = $cart['Basket']['price'];
			 
			  $condition = $NewUsedcondArray[$cart['Basket']['condition_id']];
			  $totalItemPrice = $prodQty * $prodPrice;
			  
			  unset($prodSellerInfo);
			  unset($SellerInfo);
			  
			  $prodSellerInfo = $common->getProductSellerInfo($prodId,$sellerId ,$cart['Basket']['condition_id'] );
			//	 pr($prodSellerInfo);
			  $totalQty = $prodSellerInfo['ProductSeller']['quantity'];
			 
			    if( empty($totalQty) ){ //skip item if seller have 0  item to sale 
			          continue;
			    }
			  #--------------------------#
			  
			  ### Seller information ########
			  $sellerName = $gift_service = $free_delivery = '';
			  $SellerInfo     = $common->getsellerInfo($sellerId );
			  $sellerName     = $SellerInfo['Seller']['business_display_name'];
			  $gift_service   = $SellerInfo['Seller']['gift_service'];
			  $free_delivery  = $SellerInfo['Seller']['free_delivery'];
			  
			 
			  ###  product seller info ###
			?>
			 <!--Shipping Option Widget Start-->
                            <div class="shipping-option-widget">
                              <p class="pro-name"><strong><?php echo $prodName;?></strong></p>
                              <p class="smalr-fnt"><strong>Sold by:</strong> <?php echo $sellerName;?></p>
                              <p class="smalr-fnt"><strong>Quantity:</strong> <?php echo $prodQty;?> <span class="padding-left"><strong>Condition</strong> - <?php echo $condition;?></span></p>
                              
                              <!--Shipping Option Grid Start-->
			    <div class="ship-option-grid margin-tp-btm">
                              
                              	  <!--Shipping Option Grid Head Start-->
                                 <div class="ship-option-grid-head overflow-h">
                                    	<ul>
                                              <li class="check-col">&nbsp;</li>
                                          <li class="delivery-choice-col12"><strong>Delivery Choice</strong></li>
                                              <li class="delivery-choice-col12"><strong>Restrictions</strong></li>
                                          <li class="estimated-delivery-col12"><strong>Estimated Delivery</strong></li>
                                              <li class="price-column"><strong>Price</strong></li>
                                        </ul>
				</div>
                                  <!--Shipping Option Grid Head Closed-->
                                  
                                  <!--Shipping Option Grid Row Start-->
                                <div class="ship-option-grid-row overflow-h gray-bg-row"1>
                                    	<ul>
                                        	<li class="check-col">
                                        	
						<?php
						 $expDelChecked = '';
						 $stdDelChecked = '';
						if($cart['Basket']['delivery_method'] == 'E' ){
						       $expDelChecked = 'checked=checked';
						       $expClass = 'green-color';
						       $stdDelChecked = '';
						       $stdClass = '';
						       $expDeliveryPrice = $cart['Basket']['exp_delivery_cost'];
						}else{
						       $stdDelChecked = 'checked=checked';
						       $stdClass = 'green-color';
						       $expDelChecked = '';
						       $expClass = '';
						       $expDeliveryPrice = $prodSellerInfo['ProductSeller']['express_delivery_price'];
						}
						 ?>
						
						<input disabled="disabled" <?php echo $stdDelChecked;?> id="OrderDeliveryChoiceS" type="radio"  class="checkbox"  value="S">
						<!--<input type="radio" name="radio" class="checkbox" value="radio" />-->
                                        	</li>
                                            <li class="delivery-choice-col12"><span class="<?=$stdClass?>"> MoneySaver Shipping = Standard Shipping</span></li>
                                            <li class="delivery-choice-col12">Monday to Friday Only</li>
                                            <li class="estimated-delivery-col12"><span class="<?=$stdClass?>">
							<?php
							if(!empty($cart['Basket']['standard_delivery_date'])){			
								echo date('l dS F Y', strtotime($cart['Basket']['standard_delivery_date']));
							}else{
								echo "Not Deliverable";
							}?>
								
								</span></li>
                                            <li class="price-column"><span class="<?=$stdClass?>">
					    <?php
						if(!empty($cart['Basket']['delivery_cost']) || $cart['Basket']['delivery_cost'] > 0 ){
								echo CURRENCY_SYMBOL. number_format($cart['Basket']['delivery_cost'], 2);
							  }else{
								echo 'FREE ';
						       }
					       ?>
							</span></li>
                                        </ul>
   		  		</div>
				<!--Shipping Option Grid Row Closed-->
				
                                <?php  if( is_array($prodSellerInfo) &&  $prodSellerInfo['ProductSeller']['express_delivery'] == 1) { ?>
				<!--Shipping Option Grid Row Start-->
                                 <div class="ship-option-grid-row overflow-h">
                                    	<ul>
                                        	<li class="check-col">
                                        	  <input disabled="disabled" <?php echo $expDelChecked;?> id="OrderDeliveryChoiceE" type="radio"  class="checkbox"  value="E">
                                        	</li>
                                            <li class="delivery-choice-col12"><span class="<?=$expClass?>">Next Day Express Shipping = Express Shipping</span></li>
                                            <li class="delivery-choice-col12">Monday to Friday Only 8am - 5pm</li>
                                            <li class="estimated-delivery-col12"><span class="<?=$expClass?>">
					    
						<?php
						
							if(!empty($cart['Basket']['standard_delivery_date'])){		
								echo date('l dS F Y', strtotime($cart['Basket']['express_delivery_date']));
							}else{
								echo "Not Deliverable";
							}
									
									
									?></span></li>
                                            <li class="price-column"><span class="<?=$expClass?>">
						 <?php if(!empty($expDeliveryPrice) || $expDeliveryPrice > 0){
							echo CURRENCY_SYMBOL, $expDeliveryPrice;
						}else{
							echo "Free";
						}?>
					    </span></li>
                                        </ul>
           		  	 </div>
				  <!--Shipping Option Grid Row Closed-->
                              	<?php }  ?>
				
                              </div>
                              <!--Shipping Option Grid Closed-->
			      
                        </div>
			    <!--Shipping Option Widget closed-->
			    
                          <?php
			  unset($SellerInfo);
			  unset($expDeliveryPrice);
			  unset($expDeliveryPrice);
			  
			  } //foreach ends
			  
			 ?> 
                              <ul class="calculate">
				 <?php  if($sessOrderData['insurance'] == '1') { 	?>
                                                <li>
                                                    <div class="d-arrow"><?php echo $html->image("checkout/d-arrow-icon.png" ,array('width'=>"7",'height'=>"7", 'alt'=>"", 'escape'=>false )); ?></div>
                                                    <div class="summary-text1"> <span class="green-color">Add Additional Insurance - <?php echo CURRENCY_SYMBOL, $settings['Setting']['insurance_charges'];?></span> (<?php echo $html->link("what's  this?", '/checkouts/insurance_popup', array('class'=>'underline-link fancy_box_open', 'escape'=>false) ); ?>)</div>
                                                </li>
					<?php  } ?>
                              </ul>
                              
                            </div>
                            <!--Shipping Option Widget Closed-->
       
                          </div>
                        </li>
                        <li>
			
			 <?php  echo $form->create("Checkout", array('action'=>'submit_order','default' => true,'name'=>'frmbill', 'onsubmit'=>'return validateStep4();'));?>      
                       	  
			<?php
				// if user uses the gift balance then skip the payment gateway options and make payment internally 
				if($userBalanceCost >= $total_order_cost){ // if payemnt is done by gift balance and discount coupn amount
					echo '<div style="display:none;"><input id="payment_option_id" type="radio" name="data[Order][payment_method]"  class="checkbox" value="4"  checked="checked"/> </div>';
				}else{ 
			?>
			  <div class="checkout-pro-widget">
                          	<h3 class="gray">Select a payment Method</h3>
				 <p><strong>How would you like to pay for yoour order?</strong></p>
				<?php
					  // make the first checkbox selected
					if(!isset($this->date['Order']['payment_method'])){
						$sageChecked = "checked=checked";
					}
				?>
				<!--Payment Options Start-->
				<div class="payment-options">
                            	<ul>
                                	<li>
						<input  <?=$sageChecked?> id="payment_option_id" type="radio" name="data[Order][payment_method]" class="checkbox" value="1" />
						<?php
						echo $html->image("checkout/visa-logo.png" ,array('width'=>"33",'height'=>"23", 'alt'=>"", 'escape'=>false ));
						echo $html->image("checkout/mastercard-logo.png" ,array('width'=>"33",'height'=>"23", 'alt'=>"", 'escape'=>false ));
						echo $html->image("checkout/switch-card.png" ,array('width'=>"33",'height'=>"23", 'alt'=>"", 'escape'=>false ));
						echo $html->image("checkout/delta-card.png" ,array('width'=>"33",'height'=>"23", 'alt'=>"", 'escape'=>false ));
						echo $html->image("checkout/visa-electron-logo.png" ,array('width'=>"33",'height'=>"23", 'alt'=>"", 'escape'=>false ));
						echo $html->image("checkout/master-card-logo.png" ,array('width'=>"33",'height'=>"23", 'alt'=>"", 'escape'=>false ));
						?>	
					</li>
                                    
                                    <li class="checkout-with-paypal">
						<input id="payment_option_id" type="radio" name="data[Order][payment_method]" class="checkbox" value="2" /> 
						<?php echo $html->image("checkout/checkout-with-paypal.png" ,array('escape'=>false ));?>
				    </li>
                                     <li class="float-right">
						<input id="payment_option_id" type="radio" name="data[Order][payment_method]" class="checkbox" value="3" /> 
						<?php echo $html->image("checkout/google-checkout-method.png" ,array('escape'=>false ));?>
				     </li>
                                    
                                </ul>
                                <div class="clear"></div>
                            
                            </div>
                            <!--Payment Options Closed-->
                             
                          </div>
			<?php  } ?>
			  
                        </li>
                       
		       <li>
                      	  <div class="checkout-pro-widget">
                              <div class="float-left">
				<?php echo $html->link( $html->image('checkout/back-btn.gif', array('alt'=>'', 'border'=>'') ) , '/checkouts/step3' , array('div'=>false, 'label'=>false, 'escape'=>false)  );?>
				</div>
                              <div class="float-right pad-none">
				<!--<input type="image" src="/img/checkout/continue-checkout.gif" name="submit" value="submit" />-->
			       <?php echo $form->submit("checkout/continue-checkout.gif" ,array('type'='image', 'escape'=>false ));?>
			      </div>
                          </div>
                      </li>
		  <?php echo $form->end(); ?>   	
                  </ul>
      </div>
              <!--Form Widget Closed-->
         
              </div>
             <!--Form Left Widget Start-->
         
         </div>
         <!--Right Content Closed-->
		
		
	</div>
	<!--Content Closed-->
	
	
<script>	


//  function validate the payment options 
function validateStep4()
{
	var checkedcount = jQuery(":radio[name='data[Order][payment_method]']:checked").length;
	//alert(checkedcount);
	// return false if not any option selected
	if(checkedcount > 0){
		return true;	
	}else{
		return false;
	}
}


// function to validate the discount coupon 
function validateCouponCode()
{
	var coupnCodeValue = jQuery("#dc_code_textbox_id").val();
	coupnCodeValue =  jQuery.trim(coupnCodeValue);
	if(coupnCodeValue != ''){
		return true;	
	}else{
		alert('Enter your discount code and then click Update !');
		jQuery("#dc_code_textbox_id").val('');
		jQuery("#dc_code_textbox_id").focus();
		return false;
	}
}




</script>
	
	
	
	