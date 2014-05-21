<?php
echo $javascript->link(array('jquery-1.3.2.min','lib/prototype'),false);


if(isset($this->data['Order'])){
	if(!empty($this->data['Order']['shipping_country_id'])){
		$country_id = $this->data['Order']['shipping_country_id'];
	}elseif(!empty($this->data['Order']['billing_country_id'])){
		$country_id = $this->data['Order']['billing_country_id'];
	}else{
		$country_id = '';
	}
	
}else{
	$country_id = '';
}
echo '<input type="hidden" id="shipping_country_to_id"  value="'.$country_id.'" >';

echo '<input type="hidden" id="shipping_country_id_first_time"  value="'.$this->data['Order']['shipping_country_id'].'" >';

?>

<script type="text/javascript" >
	
//open_fancy_box_id
/*jQuery(document).ready(function()  { // to delete the offer
	
	jQuery('div.error-message').fadeOut(15000);

	//jQuery("a.underline-link").fancybox({
	jQuery("a.fancy_box_open").fancybox({
		'autoScale' : true,
		'width' : 450,
		'height' : 150,
		'padding':0,'overlayColor':'#000000',
		'overlayOpacity':0.5,
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
});*/


jQuery(document).ready(function(){
	 
	jQuery('#OrderBillingCountryId').change(function() {
		displayState('B'); // billing 
		var countryValue = jQuery("#OrderBillingCountryId").val();
		PutThisDataInShippingAsWell(countryValue,9);
	})
	jQuery('#OrderShippingCountryId').change(function() {
		displayState('S'); // shipping state  
		
	})

	displayState('B'); // billing
	if(jQuery('#OrderShippingSame').attr('checked') == true){ // if shipping and billing are same then
		// fill the shipping information
		
		var shippingcountryToId = jQuery("#shipping_country_id_first_time").val();
		//alert(shippingcountryToId);
		if(shippingcountryToId == ''){
			 SetShippingData();
		}
		
		var billingcountryId = jQuery("#OrderBillingCountryId").val();
		if(billingcountryId != ''){
			displayState('S'); // Shipping
		}
	//	SetShippingData();
	}else{
		displayState('S'); // Shipping
	}
		
});

// function to provide the state dropdown
function displayState(sType){
	if(sType == 'B'){ // shipping
		var countryId = jQuery("#OrderBillingCountryId").val();
		if(countryId == ''){
			countryId = 0;
		}
		
		var stateFieldName = jQuery("#billingStateFieldName").val();
		var selectedStateValue = jQuery("#AddressBillingSelectedState").val();
			var url =  SITE_URL+'totalajax/DisplayBillingStateBox/'+countryId+'/'+stateFieldName+'/'+selectedStateValue;
			//alert(url);
			jQuery('#preloader').show();
			jQuery.ajax({
				cache:false,
				async:false,
				type: "GET",
				url:url,
				success: function(msg){
					jQuery('#billingStateTextSelect').html(msg);
					jQuery('#preloader').hide();
				}
			});
	}else if(sType == 'S'){ // shipping
		//alert('Hel');
		var countryId = jQuery("#OrderShippingCountryId").val();
		if(countryId == ''){
			countryId = 0;
		}
			processDeliveryEstimation(countryId); // call function to process the estimation
		
		var stateFieldName = jQuery("#shippingStateFieldName").val();
		var selectedStateValue = jQuery("#AddressShippingSelectedState").val();
			var url = SITE_URL+'totalajax/DisplayShippingStateBox/'+countryId+'/'+stateFieldName+'/'+selectedStateValue;
			//alert(url);
			
			jQuery('#preloader').show();
			jQuery.ajax({
				cache:false,
				async:false,
				type: "GET",
				url:url,
				success: function(msg){
					jQuery('#shippingStateTextSelect').html(msg);
					jQuery('#preloader').hide();
				}
			});
	}
}

	function getDeliveryEstimation(toCountryId,fromCountryId , updateDivId, shipType ){
		var url = SITE_URL+'totalajax/getShippingEstimationMobile/'+toCountryId+'/'+fromCountryId+'/'+shipType;
		//alert(url);
		jQuery.ajax({
			cache:false,
			async:false,
			type:"GET",
			url:url,
			success: function(msg){
				//alert(msg);
				jQuery('#span_'+updateDivId).html(msg);
				//jQuery('#'+updateDivId).val(msg);
			}
			
		});
	}
</script>
<!--Content Start-->
<!--Main Content Starts--->
             <section class="maincont nopadd">
                 	 <!--Form Widget Start-->
			<?php // display session error message
			if ($session->check('Message.flash')){ ?>
			<div  class="messageBlock"><?php echo $session->flash();?></div>
			<?php } ?>
		 	 <?php echo $form->create("Checkout", array('action'=>'step3','default' => true,'name'=>'frmbill'));
		 	 ?>
		 	 
                <section class="prdctboxdetal">
                	<h4 class="diff-blu">Checkout Choiceful: Swift, Simple & Secure</h4>
                    <h4 class="orng-clr"><span class="gray-color">Step 3 of 5</span> Billing &amp; Shipping</h4>
                
                    <p class="lgtgray applprdct">Is the address you'd like to use dislayed below? If so, click the corresponding "continue" button to progress through.</p>
			<ul class="blngaddress">
                           <li><b>Billing Address</b></li>
			   <li><span class="font11 gray">Where are your card statements sent?</span></li>
                           <li>
				<?php echo $this->data['Order']['billing_user_title']
				.' '.$this->data['Order']['billing_firstname']
				.' '.$this->data['Order']['billing_lastname'];
				
				echo $form->hidden("Order.billing_user_title", array('value'=>$this->data['Order']['billing_user_title']) );
				
				echo $form->hidden("Order.billing_firstname", array('value'=>$this->data['Order']['billing_firstname']) );
				
				echo $form->hidden("Order.billing_lastname", array('value'=>$this->data['Order']['billing_lastname']) );
				?>
                           </li>
                           <li> <?php echo $this->data['Order']['billing_address1']
				.' '.$this->data['Order']['billing_address2'];
				echo $form->hidden("Order.billing_address1", array('value'=>$this->data['Order']['billing_address1']) );
				echo $form->hidden("Order.billing_address2", array('value'=>$this->data['Order']['billing_address2']) );
				?>
			   </li>
                           <li><?php echo $this->data['Order']['billing_city'];
                           	echo $form->hidden("Order.billing_city", array('value'=>$this->data['Order']['billing_city']) );
                          	 ?>
                           </li>
                           <li>
				<?php echo $this->data['Order']['billing_state'];
					echo $form->hidden("Order.billing_state", array('value'=>$this->data['Order']['billing_state']) );
				?>
                           </li>
                           <li>
                           <?php echo 
                          	$this->Common->getCountryName($this->data['Order']['billing_country_id']);
                          	echo $form->hidden("Order.billing_country_id", array('value'=>$this->data['Order']['billing_country_id']) );
                           ?>
                           </li>
                           <li>
				<?php echo $this->data['Order']['billing_postal_code'];
					echo $form->hidden("Order.billing_postal_code", array('value'=>$this->data['Order']['billing_postal_code']) );
				?>
                           </li>
                           <li>
				<?php echo "Tel. ".$this->data['Order']['billing_phone'];
					echo $form->hidden("Order.billing_phone", array('value'=>$this->data['Order']['billing_phone']) );
				?>
                           </li>
                        </ul> 
                        
                    	<ul class="blngaddress toppadd">
                           <li><b>Shipping Address</b></li>
			   <li><span class="font11 gray">Where would you like your items shipped?</span></li>
                           <?php if(empty($this->data['Order']['shipping_firstname'])){?>
                            <li>
                            	<input id="OrderShippingSame_" type="hidden" value="1" name="data[Order][shipping_same]"/>
				<?php echo $this->data['Order']['billing_user_title']
				.' '.$this->data['Order']['billing_firstname']
				.' '.$this->data['Order']['billing_lastname'];
				
				echo $form->hidden("Order.shipping_user_title", array('value'=>$this->data['Order']['billing_user_title']) );
				
				echo $form->hidden("Order.shipping_firstname", array('value'=>$this->data['Order']['billing_firstname']) );
				
				echo $form->hidden("Order.shipping_lastname", array('value'=>$this->data['Order']['billing_lastname']) );
				?>
                           </li>
                           <li> <?php echo $this->data['Order']['billing_address1']
				.' '.$this->data['Order']['billing_address2'];
				echo $form->hidden("Order.shipping_address1", array('value'=>$this->data['Order']['billing_address1']) );
				echo $form->hidden("Order.shipping_address2", array('value'=>$this->data['Order']['billing_address2']) );
				?>
			   </li>
                           <li><?php echo $this->data['Order']['billing_city'];
                           	echo $form->hidden("Order.shipping_city", array('value'=>$this->data['Order']['billing_city']) );
                          	 ?>
                           </li>
                           <li>
				<?php echo $this->data['Order']['billing_state'];
					echo $form->hidden("Order.shipping_state", array('value'=>$this->data['Order']['billing_state']) );
				?>
                           </li>
                           <li>
                           <?php echo $this->Common->getCountryName($this->data['Order']['billing_country_id']);
                          	echo $form->hidden("Order.shipping_country_id", array('value'=>$this->data['Order']['billing_country_id']) );
                           ?>
                           </li>
                           <li>
				<?php echo $this->data['Order']['billing_postal_code'];
					echo $form->hidden("Order.shipping_postal_code", array('value'=>$this->data['Order']['billing_postal_code']) );
				?>
                           </li>
                           <li><?php
				echo "Tel. ".$this->data['Order']['billing_phone'];
				echo $form->hidden("Order.shipping_phone", array('value'=>$this->data['Order']['billing_phone']) );
				?>
                           </li>
                           <?php }else{?>
                           <li>
                           <input id="OrderShippingSame_" type="hidden" value="0" name="data[Order][shipping_same]"/>
				<?php echo $this->data['Order']['shipping_user_title']
				.' '.$this->data['Order']['shipping_firstname']
				.' '.$this->data['Order']['shipping_lastname'];
				
				echo $form->hidden("Order.shipping_user_title", array('value'=>$this->data['Order']['shipping_user_title']) );
				
				echo $form->hidden("Order.shipping_firstname", array('value'=>$this->data['Order']['shipping_firstname']) );
				
				echo $form->hidden("Order.shipping_lastname", array('value'=>$this->data['Order']['shipping_lastname']) );
				
				?>
                           </li>
                           <li> <?php echo $this->data['Order']['shipping_address1']
				.' '.$this->data['Order']['shipping_address2'];
				
				echo $form->hidden("Order.shipping_address1", array('value'=>$this->data['Order']['shipping_address1']) );
				
				echo $form->hidden("Order.shipping_address2", array('value'=>$this->data['Order']['shipping_address2']) );
				
				?>
			   </li>
                           <li>
                           	<?php echo $this->data['Order']['shipping_city'];
                           	echo $form->hidden("Order.shipping_city", array('value'=>$this->data['Order']['shipping_city']) );
                           	?>
                           </li>
                           <li>
                           	<?php echo $this->data['Order']['shipping_state'];
                           	echo $form->hidden("Order.shipping_state", array('value'=>$this->data['Order']['shipping_state']) );
                           	?>
                           </li>
                           <li>
                           <?php echo $this->Common->getCountryName($this->data['Order']['shipping_country_id']);
                          	if(!empty($this->data['Order']['shipping_country_id'])){
                          	
                          	echo $form->hidden('Order.shipping_country_id', array('value'=>$this->data['Order']['shipping_country_id']) );
                          	
                          	}
                          	
                           ?>
                           </li>
                           <li>
				<?php echo $this->data['Order']['shipping_postal_code'];
				echo $form->hidden("Order.shipping_postal_code", array('value'=>$this->data['Order']['shipping_postal_code']) );
				?>	
                           </li>
                           <li>
                           	<?php echo "Tel. ".$this->data['Order']['shipping_phone'];
                           	      echo $form->hidden("Order.shipping_phone", array('value'=>$this->data['Order']['shipping_phone']) );
                           	?>
                           </li>
                           <?php }?>
                           <li>
                           <?php  echo $html->link($form->submit('Change',  array('type'=>'button', 'name'=>'change' , 'class'=>'signinbtnwhyt cngckhot')),'/checkouts/change_shippingadd',array('div'=>false, 'label'=>false, 'escape'=>false)); ?>
                           <!--<input type="button" value="Change" class="signinbtnwhyt cngckhot">--></li>
                        </ul>
                    <!---->
                    <ul>
                      <li>&nbsp;</li>
                      <li><h4 class="orng-clr">additional details</h4></li>
                      <li>
                      		<?php echo $form->input('Order.comments',array('type'=>'textarea', 'cols'=>'45', 'rows'=>'3','maxlength'=>'150','class'=>'addntldytal bigger-textfield','label'=>false,'div'=>false));?>
                      </li>
                      <li class="font11 gray">Please use the box above to provide any additional delivery details - e.g. Leave behind shed!</li>
                    </ul>
                    <!---->
                    <?php if(is_array($cartData) && count($cartData) >0 ) { ?>
                    <ul>
                      <li>&nbsp;</li>
                      <li><h4 class="orng-clr">Shipping Options</h4></li>
                     </ul>
                     
                    <?php  foreach($cartData as $itemCountId=>$cart){
			//pr($item);
			$prodId   = $cart['Basket']['product_id'];
			$sellerId = $cart['Basket']['seller_id'];
			$cartId   = $cart['Basket']['id'];
			$prodName  = $cart['Product']['product_name'];
			$prodQty   =  $cart['Basket']['qty'];
			$prodPrice = $cart['Basket']['price'];
			$condition = $NewUsedcondArray[$cart['Basket']['condition_id']];
			
			$totalItemPrice = $prodQty * $prodPrice;
			
			unset($prodSellerInfo);
			unset($SellerInfo);
			$prodSellerInfo = $common->getProductSellerInfo($prodId,$sellerId ,$cart['Basket']['condition_id'] );
			
			$cart_div_ids_array[$itemCountId]['s_id'] = "s_div_".$itemCountId;
			$cart_div_ids_array[$itemCountId]['e_id'] = "e_div_".$itemCountId;
			$cart_div_ids_array[$itemCountId]['country_from'] = $prodSellerInfo['ProductSeller']['dispatch_country'];
			
			// pr($prodSellerInfo);
			$totalQty = $prodSellerInfo['ProductSeller']['quantity'];
			if( empty($totalQty) ){ //skip item if seller have 0  item to sale 
				continue;
			}
			$expDeliveryPrice = $prodSellerInfo['ProductSeller']['express_delivery_price'];
			#--------------------------#
			### Seller information ########
			$sellerName     = $gift_service = $free_delivery = '';
			$SellerInfo     = $common->getsellerInfo($sellerId );
			//pr($SellerInfo);
			$sellerName     = $SellerInfo['Seller']['business_display_name'];
			$gift_service   = $SellerInfo['Seller']['gift_service'];
			$free_delivery  = $SellerInfo['Seller']['free_delivery'];
			
			if($free_delivery == '1' && ($totalItemPrice > $SellerInfo['Seller']['threshold_order_value']) ){ 
				$sdDeliveryPrice = 0;
			}else{
				$sdDeliveryPrice = $cart['Basket']['delivery_cost'];
			}
			//pr($prodSellerInfo);
			// echo $form->hidden('Basket.id', array('value'=>$cartId) );
			//$loopName = "Product$prodId";
			$loopName = "Item$cartId";
			echo $form->hidden("Basket.$loopName.product_id", array('value'=>$prodId) );
			echo $form->hidden("Basket.$loopName.seller_id", array('value'=>$sellerId) );
			echo $form->hidden("Basket.$loopName.condition_id", array('value'=>$cart['Basket']['condition_id']) );
			?>
                     
                    <ul>
                      <li class="toppadd boldr">
			<?php echo $html->image('/img/mobile/shpng_option_redarrow.png', array('alt'=>""));?>
			<?php echo $prodName;?>
		      </li>
		      <li class="font11"><b>Sold by:</b> <?php echo $sellerName;?></li>
                      <li class="font11"><b>Quantity:</b> <?php echo $prodQty;?>&nbsp;&nbsp;&nbsp;&nbsp;<b>Condition</b> - <?php echo $condition;?></li>
                    </ul>
                    <!---->
                    <section class="dlvrylstng">
                       <ul class="dlvrylstnglst">
                       <?php 
				$expDelChecked = '';
				$stdDelChecked = '';
				if(isset($this->data['Basket'][$loopName]['delivery_method']) ){
					if($this->data['Basket'][$loopName]['delivery_method'] == 'E' ){
						$expDelChecked = 'checked=checked';
						$stdDelChecked = '';
					}else{
						$stdDelChecked = 'checked=checked';
						$expDelChecked = '';
					}
				}else{ 
					if($cart['Basket']['delivery_method'] == 'E' ){
						$expDelChecked = 'checked=checked';
						$stdDelChecked = '';
					}else{
						$stdDelChecked = 'checked=checked';
						$expDelChecked = '';
					}
				}
				//exit;
				?>
                          <li class="boldr">
                              <div class="dlvrychoice">Delivery Choice</div>
                           	  <div class="dlvrychoice">Est. Delivery</div>
                              <div class="dlvryprice">Price</div>
                          </li>
                          <li>      
                              <div class="dlvrychoice">
				<input type="hidden" name="data[Basket][<?php echo $loopName ;?>][standard_delivery_price]"   value="<?php echo $sdDeliveryPrice; ?>" >
				<input type="hidden" name="data[Basket][<?php echo $loopName ;?>][express_delivery_price]"   value="<?php echo $expDeliveryPrice ;?>" >
				
				<input <?php echo $stdDelChecked;?> id="OrderDeliveryChoiceS" type="radio" name="data[Basket][<?php echo $loopName?>][delivery_method]"  class="checkbox"  value="S">
				<input type="hidden" name="data[Basket][<?php echo $loopName ; ?>][id]"   value="<?php echo $cartId; ?>">
				
				<input type="hidden" id="s_div_<?=$itemCountId ?>" name="data[Basket][<?=$loopName?>][delivery_date_s]"   value="">
				<input type="hidden" id="e_div_<?=$itemCountId ?>" name="data[Basket][<?=$loopName?>][delivery_date_e]"   value=""> 
				Standard Shipping
			 	</div>
                           	<div class="dlvrychoice">
                           	<span id="span_e_div_<?=$itemCountId ?>" >Please wait ...</span></div>    
                              	<div class="dlvryprice">
                              		<?php
						if(!empty($sdDeliveryPrice) || $sdDeliveryPrice > 0 ){
							echo CURRENCY_SYMBOL. number_format($sdDeliveryPrice, 2);
						}else{
							echo 'FREE ';
						}
					?>
				</div>
                          </li>
                          
                          
                          <?php  if( is_array($prodSellerInfo) &&  $prodSellerInfo['ProductSeller']['express_delivery'] == 1) { ?>
                          <li>             
                              <div class="dlvrychoice">
                              <input <?php echo $expDelChecked;?> id="OrderDeliveryChoiceE" type="radio" name="data[Basket][<?=$loopName?>][delivery_method]" class="checkbox"  value="E">
				 Express Shipping</div>
			       <div class="dlvrychoice">
			       	<span id="span_s_div_<?=$itemCountId ?>" >Please wait ...</span></div>
                              <div class="dlvryprice">
                              	<?php
					if(!empty($expDeliveryPrice) || $expDeliveryPrice > 0 ){
						echo CURRENCY_SYMBOL. number_format($expDeliveryPrice, 2);
					 }else{
						echo 'FREE ';
					}
				?>
				</div>
                          </li>
                          <?php }?>
                       </ul>
                    </section>
                    <?php }}?>
                    <!---End of for and if loops-->
                    

                    <p>
                    <?php echo $form->checkbox('Order.insurance', array('class'=>'checkbox marg-lt-rt', 'label'=>false, 'div'=>false ) ) ;?> 
			Add additional insurance - <?php echo CURRENCY_SYMBOL, $settings['Setting']['insurance_charges'];?> (<?php echo $html->link("what's this?", '/checkouts/insurance_popup', array('class'=>'underline-link fancy_box_open', 'escape'=>false) );?>)
                    </p>
                    <p>&nbsp;</p>
                    <p>
                    <?php  //echo $form->submit('checkout/continue-checkout.gif',  array('type'=>'image', 'name'=>'submit') ); ?>
                    <?php  echo $form->submit('Continue',  array('type'=>'submit', 'name'=>'submit' , 'class'=>'signinbtnwhyt cntnuchkot') ); ?>
                    <!--<input type="button" value="Continue" class="signinbtnwhyt cntnuchkot">--></p>
                    <p>&nbsp;</p>
                </section>
		<!--Form Widget Closed-->
		<?php echo $form->end();
		//pr($cart_div_ids_array); ?>
             </section>
          <!--Main Content End--->
          <!--Navigation Starts-->
             <nav class="nav">
                      <ul class="maincategory yellowlist">
                         <?php echo $this->element('mobile/nav_footer');?>
                      </ul>
               </nav><!--Content Closed-->



<script>

	

/**
 * function to fill the data in corresponding field 
 */
 function PutThisDataInShippingAsWell(fieldVal,fieldNo){           
	
	if(jQuery('#OrderShippingSame').attr('checked') == true){
		if(fieldNo == 1){
			jQuery('#OrderShippingUserTitle').val(fieldVal);       
		}else if(fieldNo == 2){
			jQuery('#OrderShippingFirstname').val(fieldVal);       
		}else if(fieldNo == 3){
			jQuery('#OrderShippingLastname').val(fieldVal); 
		}else if(fieldNo == 4){
			jQuery('#OrderShippingAddress1').val(fieldVal); 
		}else if(fieldNo == 5){
			jQuery('#OrderShippingAddress2').val(fieldVal); 
		}else if(fieldNo == 6){
			jQuery('#OrderShippingCity').val(fieldVal); 
		}else if(fieldNo == 7){
			jQuery('#OrderShippingState').val(fieldVal); 
		}else if(fieldNo == 8){
			jQuery('#OrderShippingPostalCode').val(fieldVal); 
		}else if(fieldNo == 9){
			jQuery('#OrderShippingCountryId').val(fieldVal); 
		}else if(fieldNo == 10){
			jQuery('#OrderShippingPhone').val(fieldVal); 
		}
	}
 }
    
    
/**
 * function to fill the shipping data with 
the billing data
 */
function SetShippingData()
{	
	jQuery('#OrderShippingUserTitle').val(jQuery('#OrderBillingUserTitle').val());
	jQuery('#OrderShippingFirstname').val(jQuery('#OrderBillingFirstname').val());
	jQuery('#OrderShippingLastname').val(jQuery('#OrderBillingLastname').val());
	jQuery('#OrderShippingAddress1').val(jQuery('#OrderBillingAddress1').val());
	jQuery('#OrderShippingAddress2').val(jQuery('#OrderBillingAddress2').val());
	jQuery('#OrderShippingCity').val(jQuery('#OrderBillingCity').val());
	jQuery('#OrderShippingPostalCode').val(jQuery('#OrderBillingPostalCode').val());
	jQuery('#OrderShippingCountryId').val(jQuery('#OrderBillingCountryId').val());
	jQuery('#OrderShippingPhone').val(jQuery('#OrderBillingPhone').val());
	jQuery('#OrderShippingState').val(jQuery('#OrderBillingState').val());
	//alert(jQuery('#OrderBillingState').val());
}

/**
 * function to clear the shipping data 
 */
function ClearShippingData(){	
	jQuery('#OrderShippingUserTitle').val('');
	jQuery('#OrderShippingFirstname').val('');
	jQuery('#OrderShippingLastname').val('');
	jQuery('#OrderShippingAddress1').val('');
	jQuery('#OrderShippingAddress2').val('');
	jQuery('#OrderShippingCity').val('');
	jQuery('#OrderShippingPostalCode').val('');
	jQuery('#OrderShippingCountryId').val('');
	jQuery('#OrderShippingPhone').val('');
	jQuery('#OrderShippingState').val('');
}


/**
 * function to fill and clear the shipping data with the billing data
 * if user choose the same shippig infor as billiing
 */
function CheckSameBillingShipping()
{	
	if(jQuery('#OrderShippingSame').attr('checked') == true)
	{
		// fill the shipping information
		SetShippingData();
		ClearShippingDataErrors();
	}else{
		// clear the shipping information
		ClearShippingData();
	}	
}
function ClearShippingDataErrors()
{	
	jQuery('#errShipFnameDivID').html('');
	jQuery('#errShipTitleDivID').html('');
	jQuery('#errShipLnameDivID').html('');
	jQuery('#errShipAddressDivID').html('');
	jQuery('#errShipCityDivID').html('');
	jQuery('#errShipStateDivID').html('');	
	jQuery('#errShipPostcodeDivID').html('');
	jQuery('#errShipPhoneDivID').html('');
	jQuery('#errShipCountryIdDivID').html('');
}

/**
 * function validate the biling /shipping  details data
 * 
 */
function validateStep3Form()
{
	  var matchtelno = /^[0-9 ]+$/;
	 
	// +++++++++++++++++++++++++++Billing  section start here  ++++++++++++++++++++++++++++++++++++++/	
	if(jQuery.trim(jQuery('#OrderBillingUserTitle').val()) == ''){ 
		jQuery('#errBilTitleDivID').html('Select title');
		//alert('hel');
		//jQuery('#errBilTitleDivID').removeClass('error-message');
		//jQuery('#errBilTitleDivID').addClass('error-message-enable');
		return false;
	}else{
		jQuery('#errBilTitleDivID').html('');	
	}
	if(jQuery.trim(jQuery('#OrderBillingFirstname').val()) == ''){ 
		jQuery('#errBilFnameDivID').html('Enter first name');
		jQuery('#OrderBillingFirstname').focus();
		return false;
	}else{
		jQuery('#errBilFnameDivID').html('');	
	}
	
	
	if(jQuery.trim(jQuery('#OrderBillingLastname').val()) == ''){ 
		jQuery('#errBilLnameDivID').html('Enter your surname');
		jQuery('#OrderBillingLastname').focus();
		return false;
	}else{
		jQuery('#errBilLnameDivID').html('');	
	}
	
	if(jQuery.trim(jQuery('#OrderBillingAddress1').val()) == ''){ 
		jQuery('#errBilAddressDivID').html('Enter address');
		jQuery('#OrderBillingAddress1').focus();
		return false;
	}else{
		jQuery('#errBilAddressDivID').html('');	
	}
	
	if(jQuery.trim(jQuery('#OrderBillingCity').val()) == ''){ 
		jQuery('#errBilCityDivID').html('Enter city');
		jQuery('#OrderBillingCity').focus();
		return false;
	}else{;
		jQuery('#errBilCityDivID').html('');	
	}
	
	if(jQuery.trim(jQuery('#OrderBillingPostalCode').val()) == ''){ 
		jQuery('#errBilPostcodeDivID').html('Enter postcode');
		jQuery('#OrderBillingPostalCode').focus();
		return false;
	}else if(jQuery.trim(jQuery('#OrderBillingPostalCode').val()).length < 3){
		jQuery('#errBilPostcodeDivID').html('The Postcode must have more than 3 characters');
		jQuery('#OrderBillingPostalCode').focus();
		return false;
	}else{
		jQuery('#errBilPostcodeDivID').html('');	
	}
	
	//if(jQuery('#OrderBillingState').val() == '' && jQuery('#OrderBillingCountryId').val() == '1'){
	
	
	
	
	if(jQuery.trim(jQuery('#OrderBillingCountryId').val()) == ''){ 
		jQuery('#errBilCountryIdDivID').html('Select country');
		jQuery('#OrderBillingCountryId').focus();
		return false;
	}else{
		jQuery('#errBilCountryIdDivID').html('');	
	}
	
	if(jQuery.trim(jQuery('#OrderBillingState').val()) == ''){
		jQuery('#errBilStateDivID').html('Enter State/county');
		jQuery('#OrderBillingState').focus();
		return false;
	}else{
		jQuery('#errBilStateDivID').html('');	
	}
	
	if(jQuery.trim(jQuery('#OrderBillingPhone').val()) == ''){ 
		jQuery('#errBilPhoneDivID').html('Enter telephone');
		jQuery('#OrderBillingPhone').focus();
		return false;
	}else if(jQuery('#OrderBillingPhone').val() != ''){ 
		var billtelno  = jQuery.trim(jQuery('#OrderBillingPhone').val());
		
		if(billtelno.length<=3) {
			jQuery('#errBilPhoneDivID').html('The telephone number must have more than 3 digits');
			jQuery('#OrderBillingPhone').focus();
			return false;
		}else if(!billtelno.match(matchtelno)) {
			jQuery('#errBilPhoneDivID').html('The telephone number must be in digits');
			jQuery('#OrderBillingPhone').focus();
			return false;
		}else {
			jQuery('#errBilPhoneDivID').html('');
		}		
	}else{
		jQuery('#errBilPhoneDivID').html('');
	}
	// +++++++++++++++++++++++++++billing  section ends  here  ++++++++++++++++++++++++++++++++++++++/	
	
	// validate shipping info if user selected different shipping info 
	
	// +++++++++++++++++++++++++++shipping section start here  ++++++++++++++++++++++++++++++++++++++/
	 // if(jQuery('#OrderShippingSame').attr('checked') == false) { // validate shipping info as well
		
		if(jQuery.trim(jQuery('#OrderShippingUserTitle').val()) == ''){ 
			jQuery('#errShipTitleDivID').html('Select title');
			return false;
		}else{
			jQuery('#errShipTitleDivID').html('');	
		}
		if(jQuery.trim(jQuery('#OrderShippingFirstname').val()) == ''){ 
			jQuery('#errShipFnameDivID').html('Enter first name');
			jQuery('#OrderShippingFirstname').focus();
			return false;
		}else{
			jQuery('#errShipFnameDivID').html('');	
		}
		
		if(jQuery.trim(jQuery('#OrderShippingLastname').val()) == ''){ 
			jQuery('#errShipLnameDivID').html('Enter your surname');
			jQuery('#OrderShippingLastname').focus();
			return false;
		}else{
			jQuery('#errShipLnameDivID').html('');	
		}
		
		if(jQuery.trim(jQuery('#OrderShippingAddress1').val()) == ''){ 
			jQuery('#errShipAddressDivID').html('Enter address');
			jQuery('#OrderShippingAddress1').focus();
			return false;
		}else{
			jQuery('#errShipAddressDivID').html('');	
		}
		
		if(jQuery.trim(jQuery('#OrderShippingCity').val()) == ''){ 
			jQuery('#errShipCityDivID').html('Enter city');
			jQuery('#OrderShippingCity').focus();
			return false;
		}else{;
			jQuery('#errShipCityDivID').html('');	
		}
		
		if(jQuery.trim(jQuery('#OrderShippingPostalCode').val()) == ''){ 
			jQuery('#errShipPostcodeDivID').html('Enter postcode');
			jQuery('#OrderShippingPostalCode').focus();
			return false;
		}else if(jQuery.trim(jQuery('#OrderShippingPostalCode').val()).length < 3){ 
			jQuery('#errShipPostcodeDivID').html('The Postcode must have more than 3 characters');
			jQuery('#OrderShippingPostalCode').focus();
			return false;
		}else{
			jQuery('#errShipPostcodeDivID').html('');	
		}
		
		
		if(jQuery.trim(jQuery('#OrderShippingCountryId').val()) == ''){ 
			jQuery('#errShipCountryIdDivID').html('Select country');
			jQuery('#OrderShippingCountryId').focus();
			return false;
		}else{
			jQuery('#errShipCountryIdDivID').html('');	
		}
		//if(jQuery('#OrderShippingState').val() == '' && jQuery('#OrderShippingCountryId').val() == '1'){ 
		if(jQuery.trim(jQuery('#OrderShippingState').val()) == ''){ 
			jQuery('#errShipStateDivID').html('Enter county/state');
			jQuery('#OrderShippingState').focus();
			return false;
		}else{
			jQuery('#errShipStateDivID').html('');	
		}
		
		
		
		
		
		if( jQuery.trim(jQuery('#OrderShippingPhone').val()) == ''){ 
			jQuery('#errShipPhoneDivID').html('Enter enter phone');
			jQuery('#OrderShippingPhone').focus();
			return false;
		}else if( jQuery.trim(jQuery('#OrderShippingPhone').val()) != ''){ 
			var billtelno  = jQuery.trim(jQuery('#OrderShippingPhone').val());
			if(billtelno.length<=3) {
				jQuery('#errShipPhoneDivID').html('The telephone number must have more than 3 digits');
				jQuery('#OrderShippingPhone').focus();
				return false;
			}else if(!billtelno.match(matchtelno)) {
				jQuery('#errShipPhoneDivID').html('The telephone number must be in digits');
				jQuery('#OrderShippingPhone').focus();
				return false;
			}else {
				jQuery('#errShipPhoneDivID').html('');
			}		
		}else{
			jQuery('#errShipPhoneDivID').html('');
		}
	// }
	// ++++++++++++++++++++++++++++ shipping section ends here ++++++++++++++++++++++++++++++++++++/
}

	

</script>

	
<script type="text/javascript" >

	// processDeliveryEstimation(""); // call function to process the estimation 

	// Function to loop through the cart items to get thier relative shipping estimations
	function processDeliveryEstimation(toCountryId){
		//toCountryId = '';
		if(toCountryId == ''){
			toCountryId  = jQuery("#shipping_country_to_id").val();
		}else{
			toCountryId = toCountryId;
		}
	//alert(toCountryId);
		<?php
		if(is_array($cart_div_ids_array) ){
			foreach($cart_div_ids_array as $idsData):
				$country_from = $idsData['country_from'];
				$sDivId = $idsData['s_id'];
				$eDivId = $idsData['e_id'];
				?>
				var fromCountryId = '<?php echo $country_from; ?>';
				var updatesDivId = '<?php echo $sDivId; ?>';
				var updateeDivId = '<?php echo $eDivId; ?>';
				//if(toCountryId != ''){ 
					getDeliveryEstimation(toCountryId,fromCountryId, updatesDivId ,'S' ); // for standard
					getDeliveryEstimation(toCountryId,fromCountryId, updateeDivId , 'E'); // for express
				//}
				<?php
				unset($country_from);
				unset($sDivId);
				unset($eDivId);
			endforeach;
		}
		?>		
	}
</script>