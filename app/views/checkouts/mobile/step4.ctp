<?php ?>
<style>
.arrow_div {
    padding: 7px 0 0 0;
}
</style>
 <!--Main Content Starts--->
             <section class="maincont nopadd">
                <section class="prdctboxdetal margin-top">
		<?php // display session error message
		if ($session->check('Message.flash')){ ?>
		<div  class="messageBlock"><?php echo $session->flash();?></div>
		<?php } ?>
                    <h4 class="diff-blu">Checkout Choiceful: Swift, Simple & Secure</h4>
                    <h4 class="orng-clr"><span class="gray-color">Step 4 of 5</span> Review Order</h4>
                    <p class="lgtgray applprdct">Please review your order below.</p>
		    <h4 class="orng-clr">Your Choiceful.com Order Summary</h4>
                    <ul class="revwitms">                     
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

// 					$tax_total_cost = ($total_order_cost*$tax)/100;
// 					$total_order_before_tax  = ($total_order_cost - $tax_total_cost);

					$total_order_cost = round($total_order_cost,2);
					$total_order_before_tax = round($total_order_cost/(1+$tax/100),2);
					$tax_total_cost = round(($total_order_cost - $total_order_before_tax) ,2);

					$this->set('total_order_before_tax', $total_order_before_tax);
					$this->set('tax_total_cost', $tax_total_cost);

					$userBalanceCost = $discount_coupon_amount+$gift_balance_cost ;
					
					?>

					<?php
					echo $this->element('mobile/checkout/basket_order_summary_box'); // include left side bar
					
					?>
                      
                    </ul>
                    <!---->
                    
                    <!--Checkout info Start-->
                    <ul class="checkout_info">
                      <li>
                      	<h4 class="orng-clr">Your Products</h4>
                      	<!--Product Widzard Start-->
                      <?php	//pr($cartData);
			if(is_array($cartData)  && count($cartData) > 0){
			foreach($cartData as $cart){
				$prodId = $cart['Basket']['product_id'];
				$cartId = $cart['Basket']['id'];
				$sellerId = $cart['Basket']['seller_id'];
				###  product seller info ###
				$prodSellerInfo = $common->getProductSellerInfo($prodId,$sellerId, $cart['Basket']['condition_id'] );
				$totalQty = $prodSellerInfo['ProductSeller']['quantity'];
				if($totalQty <= 0){
					continue;
				}
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
                        <div class="row padding0">
                           <div class="arrow_div">
				 <?php echo $html->image('mobile/yr_prdcts_grayarrow.png',  array( 'alt'=>'', 'class'=>'myprdctgft') );?>
			   </div>
                            <div class="chk_info">
                             <p class="font11"><strong><?php echo $cart['Product']['product_name'] ;?> -</strong>  <span class="rd_clr"><strong>
                             	<?php echo CURRENCY_SYMBOL,$cart['Basket']['price'] ;?></strong></span></p>
                             <p><strong>Quantity: <?php echo $cart['Basket']['qty'] ;?></strong></p>
                             <p><strong>Availability: <?php echo $availability;?></strong></p>
                             <p><?php  echo $html->image('mobile/gift-icon.gif',  array( 'alt'=>'', 'class'=>'myprdctgft') ); ?><strong>Giftwrap Option:<?php echo $cart['Basket']['giftwrap'];?></strong>
			     <?php //echo $html->link( $html->image('checkout/change-btn.gif', array( 'alt'=>"", 'class'=>"v-align-middle margn-lt", 'border'=>'') ) , '/checkouts/step2' , array('div'=>false, 'label'=>false, 'escape'=>false)  );?>
                             <p class="green-color font11 margin-top">Standard Shipping -  Estimated Delivery
				    <?php
					  if(!empty($cart['Basket']['standard_delivery_date'])){		
						  echo date('dS M Y', strtotime($cart['Basket']['express_delivery_date']));
					  }else{
						  echo "Not available";
					  }
				    ?>
			     
			     <!--Estimated Delivery 15th Aug 2013--></p>
			    </div>
                         </div>
                        <?php  } // foreach ends
				     } ?>
                        </li>
                        <li><h4 class="orng-clr">Your Shipping Address</h4>
                        <div class="row padding0">
                           <div class="arrow_div">
			      <?php echo $html->image('mobile/yr_prdcts_grayarrow.png',  array( 'alt'=>'', 'class'=>'myprdctgft') );?>
			   </div>
                            <div class="chk_info">
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
                             <p><strong><?php echo $billing_country_name;?>
                             		<?php //echo $html->link( $html->image('checkout/change-btn.gif', array('width'=>"46" ,'height'=>"14", 'alt'=>"", 'class'=>"v-align-middle margn-lt", 'border'=>'') ) , '/checkouts/change_shippingadd' , array('div'=>false, 'label'=>false, 'escape'=>false)  );?>
					</strong>
			    </p>
                             </div>
                         </div>
                        </li>
                        
                        <li><h4 class="orng-clr">Your Billing Address</h4>
                        <div class="row padding0">
                           <div class="arrow_div">
			      <?php echo $html->image('mobile/yr_prdcts_grayarrow.png',  array( 'alt'=>'', 'class'=>'myprdctgft') );?>
			   </div>
                            <div class="chk_info">
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
				<?php //echo $html->link( $html->image('checkout/change-btn.gif', array('width'=>"46" ,'height'=>"14", 'alt'=>"", 'class'=>"v-align-middle margn-lt", 'border'=>'') ) , '/checkouts/change_shippingadd' , array('div'=>false, 'label'=>false, 'escape'=>false)  );?>
				</p>
                             </div>
                         </div>
                        </li>
                        
                        <li><h4 class="orng-clr">Redeem Discount Coupon</h4>
                        <div class="row padding0">
                        <?php echo $form->create("Checkout", array('action'=>'applyDiscountCoupon','name'=>'frmCoupon', 'onsubmit'=>'return validateCouponCode();'));?>
                        
                        <p class="gray">If you have a discount coupon redeem it below:</p>
                        <p class="margin-tp-btm">
                        	<input type="text" id="dc_code_textbox_id" name="data[Checkout][dc_code]" class="form-textfield"/>
                        	
                        	<?php  echo $form->submit('Update',  array('type'=>'submit', 'div'=>false, 'label'=>false, 'class'=>'button', 'style'=>"cursor:pointer;") ); ?>
                        	
                        	<!--<input name=" " value="Update" type="button" class="button" />--></p>
                        
                         <?php echo $form->end(); ?>
                        </div>
                        </li>
                        <?php  echo $form->create("Checkout", array('action'=>'submit_order','default' => true,'name'=>'frmbill', 'onsubmit'=>'return validateStep4();'));?>
                        
                        <?php
				// if user uses the gift balance then skip the payment gateway options and make payment internally 
				if($userBalanceCost >= $order_cost_before){ // if payemnt is done by gift balance and discount coupn amount
					echo '<div style="display:none;"><input id="payment_option_id" type="radio" name="data[Order][payment_method]"  class="checkbox" value="4"  checked="checked"/> </div>';
				}else{ 
			?>
			<li class="brdr-none"><h4 class="orng-clr">Choose your payment method</h4>
                            <div class="row padding5 pmnt_method">
                            	<?php
					  // make the first checkbox selected
					if(!isset($this->date['Order']['payment_method'])){
						$sageChecked = "checked=checked";
					}
				?>
                            	<p>
				<label>
                            	<input <?php echo $sageChecked;?> id="payment_option_id5" type="radio" name="data[Order][payment_method]" class="checkbox rd2" value="5" /> 
				<?php
					echo $html->image('checkout/visa-logo.png',  array('width'=>33, 'height'=>23, 'alt'=>'' ) );
					echo $html->image('checkout/mastercard-logo.png',  array('width'=>33, 'height'=>23, 'alt'=>'' ) );
					echo $html->image('checkout/switch-card.png',  array('width'=>33, 'height'=>23, 'alt'=>'' ) );
					echo $html->image('checkout/delta-card.png',  array('width'=>33, 'height'=>23, 'alt'=>'' ) );
					echo $html->image('checkout/visa-electron-logo.png',  array('width'=>33, 'height'=>23, 'alt'=>'' ) );
					echo $html->image('checkout/master-card-logo.png',  array('width'=>33, 'height'=>23, 'alt'=>'' ) );
				?>
				 </label>
				</p>
                              <p>
			      <label>
                                 <input id="payment_option_id" type="radio" name="data[Order][payment_method]" class="radio" value="2" /> 
				<?php  echo $html->image('checkout/checkout-with-paypal.png',  array('alt'=>'paypal','width'=>'144', 'height'=>'38' , 'title'=>'paypal') ); ?>
			      </label>
                              </p>
                              
                              <!--p>
			      <label>
                              <input id="payment_option_id" type="radio" name="data[Order][payment_method]" class="radio" value="3" /> 
			       <?php  //echo $html->image('checkout/google-checkout-method.png',  array('alt'=>'google checkout',  'width'=>'170' , 'height'=>'26' , 'alt'=>'google checkout') ); ?>
			      </label>
                              </p-->
                            </div>
                        </li>
                        
                        <?php }?>
                        <li class="brdr-none">
                            <div class="row padding5 pmnt_method">
				<!--p class="btn_sec"-->
				<p><strong>Please note</strong> we are now transferring you to our secure payment server.<br/>Do not click back on your browser, in the rare event that you experience any problems with payment please close your browser and try again.</p>
				<p>
				<?php  echo $form->submit('Continue',  array('type'=>'submit', 'div'=>false, 'name'=>'submit','class'=>'signinbtnwhyt cntnuchkot') ); ?>
				</p>
                           </div>
                        </li>
                         <?php echo $form->end(); ?>
                    </ul>
                    <!--Checkout info Closed-->
                    
                </section>
             </section>
          <!--Main Content End--->
          <!--Navigation Starts-->
             <nav class="nav">
                 <ul class="maincategory yellowlist">
                        <?php echo $this->element('mobile/nav_footer');?>
                      </ul>
             </nav>              
          <!--Navigation End-->
	
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