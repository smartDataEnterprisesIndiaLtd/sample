<?php
echo $javascript->link(array('jquery-1.3.2.min','lib/prototype'),false);
echo($html->script('fancybox/jquery.fancybox-1.3.4.pack'));
echo($html->script('fancybox/jquery.easing-1.3.pack'));
echo($html->script('fancybox/jquery.mousewheel-3.0.4.pack',false));
echo $html->css('jquery.fancybox-1.3.4');

/*
echo $javascript->link(array('jquery-1.3.2.min','lib/prototype'), false);
echo $javascript->link('fancybox/jquery.fancybox-1.3.1.pack.js');
echo $javascript->link('fancybox/jquery.easing-1.3.pack.js');
echo $javascript->link('fancybox/jquery.mousewheel-3.0.2.pack.js');
echo $html->css('jquery.fancybox-1.3.1.css')*/;

//pr($this->data['Order']);


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
jQuery(document).ready(function()  { // to delete the offer
	
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
});
var i = 0;
var j = 0;

jQuery(document).ready(function(){
	 
	jQuery('#OrderBillingCountryId').change(function() {
		displayState('B'); // billing 
		var countryValue = jQuery("#OrderBillingCountryId").val();
		if(jQuery('#OrderShippingSame').attr('checked') == true){
			SetShippingData();
			displayState('S'); // Shipping	
		}
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
			jQuery('#plsLoaderID').show();
			jQuery('#fancybox-overlay-header').show();
			jQuery.ajax({
				cache:false,
				async:false,
				type: "GET",
				url:url,
				success: function(msg){
					jQuery('#billingStateTextSelect').html(msg);
					if(i != 0){
						jQuery('#OrderBillingState').val('');
					}
					i++;
					//alert(jQuery('#OrderBillingState').val());
					jQuery('#plsLoaderID').hide();
					jQuery('#fancybox-overlay-header').hide();
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
			jQuery('#plsLoaderID').show();
			jQuery('#fancybox-overlay-header').show();
			jQuery.ajax({
				cache:false,
				async:false,
				type: "GET",
				url:url,
				success: function(msg){
					jQuery('#shippingStateTextSelect').html(msg);
					if(j != 0){
						jQuery('#OrderShippingState').val('');
					}	
					j++;
					jQuery('#plsLoaderID').hide();
					jQuery('#fancybox-overlay-header').hide();
				}
			});
	}
}

	function getDeliveryEstimation(toCountryId,fromCountryId , updateDivId, shipType ){
		var url = SITE_URL+'totalajax/getShippingEstimation/'+toCountryId+'/'+fromCountryId+'/'+shipType;
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
<style>
	.padright{padding-right: 8px;}
	.fullwidth{width: 100%;}
</style>

<!--Content Start-->
<div id="checkout-content">
	<!--Left Content Start-->
	<?php echo $this->element('checkout/left'); // include left side bar ?>
	<!--Left Content Closed-->
	<div class="right-con">&nbsp;</div>
	<!--Right Content Start-->
	<div class="checkout-right-content1">
		<!--Form Left Widget Start-->
		 <div class="error_msg_box" style="display: none"; ></div>
		<div class="form-checkout-widget1 wider-width-auto" style="width:99%">
                	<p class="smalr-fnt">Is the address you'd like to use displayed below? If so, click the corresponding &quot;continue&quot; button to progress through. If however, it is not you can enter a new shipping address below.</p>
                 	 <!--Form Widget Start-->
			<?php // display session error message
			if ($session->check('Message.flash')){ ?>
			<div  class="messageBlock"><?php echo $session->flash();?></div>
			<?php } ?>
		 	 <?php echo $form->create("Checkout", array('action'=>'step3','default' => true,'name'=>'frmbill', 'onsubmit'=>'return validateStep3Form();'));?>
			
			<div class="form-widget">
				<ul>
					<li>
           	  				<div class="checkout-pro-widget" style="border:none;">
							<!--Billing Info Left Start-->
							<div class="billing-info-left">
								<h2 class="gray margin-bottom">Billing Information</h2>
								<p align="center" class="font-size10 pad-btm"><strong>Where are your credit-card statements sent?</strong></p>
								<div class="form-widget">
								<ul>
									<li>
										<label><span class="star">*</span> Title :</label>
										<div class="form-field-widget">
										<?php echo $form->select('Order.billing_user_title',$title,$this->data['Order']['billing_user_title'],array('onchange'=>'PutThisDataInShippingAsWell(this.value,1)','type'=>'select','class'=>'select small-width','label'=>false,'div'=>false,'size'=>1),'Select...'); 
										echo $form->error('Order.billing_user_title');?><!--<div class="error-message" id="errBilTitleDivID"></div>-->
										</div>
									</li>
									<li>
										<label><span class="star">*</span> First Name:</label>
										<div class="form-field-widget">
										<p class="padright"><?php echo $form->input('Order.billing_firstname',array('onkeyup'=>'PutThisDataInShippingAsWell(this.value,2)','maxlength'=>'100','class'=>'form-textfield fullwidth','label'=>false, 'div'=>false));?></p>
										<!--<div class="error-message" id="errBilFnameDivID"></div>-->
										</div>
									</li>
									<li>
										<label><span class="star">*</span> Surname:</label>
										<div class="form-field-widget">
										<p class="padright"><?php echo $form->input('Order.billing_lastname',array('onkeyup'=>'PutThisDataInShippingAsWell(this.value,3)','maxlength'=>'100','class'=>'form-textfield  fullwidth','label'=>false, 'div'=>false));?></p>
										<!--<div class="error-message" id="errBilLnameDivID"></div>-->
										</div>
									</li>
									<li>
										<label><span class="star">*</span> Address:</label>
										<div class="form-field-widget">
											<p class="padright"><?php echo $form->input('Order.billing_address1',array('onkeyup'=>'PutThisDataInShippingAsWell(this.value,4)', 'maxlength'=>'100','class'=>'form-textfield fullwidth','label'=>false, 'div'=>false));?></p>
											<!--<div class="error-message" id="errBilAddressDivID"></div> -->
										</div>
									</li>
									<li>
										<label>&nbsp;</label>
										<div class="form-field-widget">
											<p class="padright"><?php echo $form->input('Order.billing_address2',array('onkeyup'=>'PutThisDataInShippingAsWell(this.value,5)', 'maxlength'=>'100','class'=>'form-textfield fullwidth','label'=>false, 'div'=>false));?></p>
										</div>
									</li>
									<li>
										<label><span class="star">*</span> Town/city:</label>
										<div class="form-field-widget">
											<p class="padright"><?php echo $form->input('Order.billing_city',array('onkeyup'=>'PutThisDataInShippingAsWell(this.value,6)', 'maxlength'=>'100','class'=>'form-textfield fullwidth','label'=>false,'div'=>false));?></p>
											<!--<div class="error-message" id="errBilCityDivID"></div> -->
										</div>
									</li>
									<li>
										<label><span class="star">*</span> Post Code:</label>
										<div class="form-field-widget">
											<p class="padright"><?php echo $form->input('Order.billing_postal_code',array('onkeyup'=>'PutThisDataInShippingAsWell(this.value,8)', 'maxlength'=>'100','class'=>'form-textfield fullwidth','label'=>false,'div'=>false, 'style'=>'width:30%;'));?></p>
											<!--<div class="error-message" id="errBilPostcodeDivID"></div>-->
										</div>
									</li>
									<li>
										<label><span class="star">*</span> Country:</label>
										<div class="form-field-widget">
											<?php //$disabledc=(!empty($this->data['Order']['billing_country_id']) ? true : false);  ?>
										<?php echo $form->select('Order.billing_country_id',$countries,$this->data['Order']['billing_country_id'],array('type'=>'select','class'=>'select fullwidth','label'=>false,'div'=>false,'size'=>1),'Select');
											echo $form->error('Order.billing_country_id'); ?>
											<!--<div class="error-message" id="errBilCountryIdDivID"></div>-->
										</div>
									</li>
									<li>
										<label><span class="star">*</span> County/state:</label>
										<input type="hidden" name="billingStateFieldName" id="billingStateFieldName" value="Order.billing_state">
										<?php echo $form->hidden('Address.billing_selected_state', array('value'=>$this->data['Order']['billing_state']));?>
										
										<div class="form-field-widget" >
											<span id="billingStateTextSelect">
										<?php echo $form->input('Order.billing_state',array('onkeyup'=>'PutThisDataInShippingAsWell(this.value,7)', 'maxlength'=>'100','class'=>'form-textfield fullwidth','label'=>false,'div'=>false));?>
										</span>
										<div class="error-message" id="errBilStateDivID"></div>
											<?php echo $form->error('Order.billing_state');?>	
										</div>
											
									</li>
									<li>
										<label><span class="star">*</span> Telephone No:</label>
										<div class="form-field-widget">
										<p class="padright"><?php echo $form->input('Order.billing_phone',array('onkeyup'=>'PutThisDataInShippingAsWell(this.value,10)', 'maxlength'=>'100','class'=>'form-textfield fullwidth','label'=>false,'div'=>false));?></p>
										<!--<div class="error-message" id="errBilPhoneDivID"></div>-->
										</div>
									</li>
								</ul>
							</div>
							<p style="font-size:14px; font-weight:bold">* Required Field</p>
						</div>
						<!--Billing Info Left Closed-->
						<!--Billing Info Right Start-->
						<div class="billing-info-right">
							<h2 class="gray margin-bottom">Shipping Information</h2>
							<p align="center" class="font-size10 pad-btm"><strong>Where you would like your item shipped?</strong></p>
							<div class="form-widget">
								<ul>
									<li>
										<?php
										
										if(!isset($this->data['Order']['shipping_same']) ){
											$chkChecked = 'checked=checked';
										}else{
											if($this->data['Order']['shipping_same'] == 1 ){
											$chkChecked = 'checked=checked';
											}else{
											$chkChecked = '';
											}
										}
										?>
										<input id="OrderShippingSame_" type="hidden" value="0" name="data[Order][shipping_same]"/>
										<input <?php echo $chkChecked;?> id="OrderShippingSame" type="checkbox" name="data[Order][shipping_same]" class="checkbox" onclick="javascript:CheckSameBillingShipping()" value="1">
										<strong>My billing and shipping information are the same.</strong>
									</li>
									<li>
										<label><span class="star">*</span> Title :</label>
										<div class="form-field-widget">
										<?php echo $form->select('Order.shipping_user_title',$title,$this->data['Order']['shipping_user_title'],array('type'=>'select','class'=>'select small-width','label'=>false,'div'=>false,'size'=>1),'Select...'); 
										echo $form->error('Order.shipping_user_title');?><div class="error-message" id="errShipTitleDivID"></div>
										</div>
									</li>
									<li>
										<label><span class="star">*</span> First Name:</label>
										<div class="form-field-widget">
										<p class="padright"><?php echo $form->input('Order.shipping_firstname',array('maxlength'=>'100','id'=>'OrderShippingFirstname','class'=>'form-textfield fullwidth','label'=>false, 'div'=>false));?></p>
										<!--<div class="error-message" id="errShipFnameDivID"></div>-->
										</div>
									</li>
									<li>
										<label><span class="star">*</span> Surname:</label>
										<div class="form-field-widget">
											<p class="padright"><?php echo $form->input('Order.shipping_lastname',array('maxlength'=>'100','class'=>'form-textfield fullwidth','label'=>false, 'div'=>false));?></p>
											<!--<div class="error-message" id="errShipLnameDivID"></div>-->
										</div>
									</li>
									<li>
										<label><span class="star">*</span> Address:</label>
										<div class="form-field-widget">
										<p class="padright"><?php echo $form->input('Order.shipping_address1',array('maxlength'=>'100','class'=>'form-textfield fullwidth','label'=>false, 'div'=>false));?></p>
										<!--<div class="error-message" id="errShipAddressDivID"></div>-->
										</div>
									</li>
									<li>
										<label>&nbsp;</label>
										<div class="form-field-widget">
											<p class="padright"><?php echo $form->input('Order.shipping_address2',array('maxlength'=>'100','class'=>'form-textfield fullwidth','label'=>false, 'div'=>false));?></p>
											
										</div>
									</li>
									<li>
										<label><span class="star">*</span> Town/city:</label>
										<div class="form-field-widget">
										<p class="padright"><?php echo $form->input('Order.shipping_city',array('maxlength'=>'100','class'=>'form-textfield fullwidth','label'=>false,'div'=>false));?></p>
										<!--<div class="error-message" id="errShipCityDivID"></div>-->
										</div>
									</li>
									<li>
										<label><span class="star">*</span> Post Code:</label>
										<div class="form-field-widget">
											<p class="padright"><?php echo $form->input('Order.shipping_postal_code',array('maxlength'=>'100','class'=>'form-textfield','label'=>false,'div'=>false, 'style'=>'width:35%;'));?></p>
											<!--<div class="error-message" id="errShipPostcodeDivID"></div>-->
										</div>
									</li>
									<li>
										<label><span class="star">*</span> Country:</label>
										<div class="form-field-widget">
											<?php //$disabledsh=(!empty($this->data['Order']['shipping_country_id']) &&  $this->data['Order']['shipping_country_id'] == 2 ? true : false);  ?>
											<?php //echo $form->select('Order.shipping_country_id',$shippingCountries,$this->data['Order']['shipping_country_id'],array('type'=>'select','class'=>'select fullwidth',"disabled"=>$disabledsh,'label'=>false,'div'=>false,'size'=>1),'Select');
											echo $form->select('Order.shipping_country_id',$shippingCountries,$this->data['Order']['shipping_country_id'],array('type'=>'select','class'=>'select fullwidth','label'=>false,'div'=>false,'size'=>1),'Select');
											echo $form->error('Order.shipping_country_id'); ?>
											<!--<div class="error-message" id="errShipCountryIdDivID"></div>-->
										</div>
									</li>
									<li>
										<label><span class="star">*</span> County/state:</label>
										<input type="hidden" name="shippingStateFieldName" id="shippingStateFieldName" value="Order.shipping_state">
										<?php echo $form->hidden('Address.shipping_selected_state', array('value'=>$this->data['Order']['shipping_state']));?>
										<div class="form-field-widget" >
											<div id="shippingStateTextSelect">
											<?php echo $form->input('Order.shipping_state',array('maxlength'=>'100','class'=>'form-textfield fullwidth','label'=>false,'div'=>false));?>
											</div>
											<div class="error-message" id="errShipStateDivID"></div>
											<?php echo $form->error('Order.shipping_state');?>
										</div>
									</li>
									<li>
										<label><span class="star">*</span> Telephone No:</label>
										<div class="form-field-widget">
										<p class="padright"><?php echo $form->input('Order.shipping_phone',array('maxlength'=>'100','class'=>'form-textfield fullwidth','label'=>false,'div'=>false));?></p>
										<!--<div class="error-message" id="errShipPhoneDivID"></div> -->
										</div>
									</li>
								</ul>
							</div>
						</div>
						<!--Billing Info Right Closed-->
						</div> 
					</li>
					
					<li>
						<div class="checkout-pro-widget">
							<h3 class="gray">additional details</h3>
						<p>
						<?php echo $form->input('Order.comments',array('type'=>'textarea', 'cols'=>'45', 'rows'=>'3', 'maxlength' => '150' ,'class'=>'form-textfield bigger-textfield','label'=>false,'div'=>false));?>
						<!--<textarea name="textarea" class="form-textfield bigger-textfield" cols="45" rows="3"></textarea>-->
						</p>
						<p class="font-size10 gray">Please use the box above to provide any additional delivery details - e.g Leave behind shed!</p>
						</div>
					</li>
					<?php 
					//pr($cartData) ;
					if(is_array($cartData) && count($cartData) >0 ) { ?>
					<li>
						<div class="checkout-pro-widget">
							<h2 class="gray margin-bottom">Shipping Options</h2>
						<?php
						// /*
						foreach($cartData as $itemCountId=>$cart){
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
											<li class="delivery-choice-col12"><strong><!--Standard Shipping and Express Shipping-->Shipping Methods</strong></li>
											<li class="delivery-choice-col12"><strong>Restrictions</strong>&nbsp; <?php echo $html->link('Learn More', SITE_URL.'pages/view/estimated-delivery-dates'); ?></li>
											<li class="estimated-delivery-col12"><strong>Estimated Delivery</strong></li>
											<li class="price-column"><strong>Price</strong></li>
										</ul>
									</div>
									<!--Shipping Option Grid Head Closed-->
									<!--Shipping Option Grid Row Start-->
									<div class="ship-option-grid-row overflow-h gray-bg-row">
										<ul>
											<li class="check-col">
											<?php
											//pr($cart);
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
											<input type="hidden" name="data[Basket][<?php echo $loopName ;?>][standard_delivery_price]"   value="<?php echo $sdDeliveryPrice; ?>" >
											<input type="hidden" name="data[Basket][<?php echo $loopName ;?>][express_delivery_price]"   value="<?php echo $expDeliveryPrice ;?>" >
										
											<input <?php echo $stdDelChecked;?> id="OrderDeliveryChoiceS" type="radio" name="data[Basket][<?php echo $loopName?>][delivery_method]"  class="checkbox"  value="S">
											<input type="hidden" name="data[Basket][<?php echo $loopName ; ?>][id]"   value="<?php echo $cartId; ?>">
											
											
											<input type="hidden" id="s_div_<?=$itemCountId ?>" name="data[Basket][<?=$loopName?>][delivery_date_s]"   value="">
											<input type="hidden" id="e_div_<?=$itemCountId ?>" name="data[Basket][<?=$loopName?>][delivery_date_e]"   value="">
											
											
											</li>
											<li class="delivery-choice-col12"><!--MoneySaver Shipping = Standard Shipping-->Standard Shipping</li>
											<li class="delivery-choice-col12"><!--Monday to Friday Only-->Up to 9 Business Days </li>
											<li class="estimated-delivery-col12"><span id="span_s_div_<?=$itemCountId ?>" >Please wait ...</span></li>
											<li class="price-column">
											<?php
												if(!empty($sdDeliveryPrice) || $sdDeliveryPrice > 0 ){
													echo CURRENCY_SYMBOL. number_format($sdDeliveryPrice, 2);
												  }else{
													echo 'FREE ';
											       }
										       ?>
											</li>
										</ul>
									</div>
									
									<!--Shipping Option Grid Row Closed-->
									<?php  if( is_array($prodSellerInfo) &&  $prodSellerInfo['ProductSeller']['express_delivery'] == 1) { ?>
									<!--Shipping Option Grid Row Start-->
									<div class="ship-option-grid-row overflow-h">
										<ul>
											<li class="check-col">
											<input <?php echo $expDelChecked;?> id="OrderDeliveryChoiceE" type="radio" name="data[Basket][<?=$loopName?>][delivery_method]" class="checkbox"  value="E">
											</li>
											<li class="delivery-choice-col12"><!--Next Day Express Shipping = Express Shipping-->Express Shipping</li>
											<li class="delivery-choice-col12"><!--Monday to Friday Only 8am - 5pm-->Up to 2 Business Days</li>
											<li class="estimated-delivery-col12"><span id="span_e_div_<?=$itemCountId ?>" >Please wait ...</span></li>
											<li class="price-column">
											<?php
												if(!empty($expDeliveryPrice) || $expDeliveryPrice > 0 ){
													echo CURRENCY_SYMBOL. number_format($expDeliveryPrice, 2);
												  }else{
													echo 'FREE ';
											       }
										       ?>
										       </li>
										</ul>
									</div>
									<!--Shipping Option Grid Row Closed-->
									<?php }  ?>
								</div>
								<!--Shipping Option Grid Closed-->
							</div>
							<!--Shipping Option Widget closed-->
							<?php
							unset($loopName);
							unset($totalItemPrice);
							unset($expDeliveryPrice);
							unset($sdDeliveryPrice);
						} 
						//foreach ends
						?>
						</div>
					</li>
					<?php  }  // array check ends here ?>
					 
					<li>
						<p><strong>Note: Please note that Choiceful.com will not be responsible for any customs charges payable at Non European Countries. The same, if applicable has to be borne by the receiver.</strong></p>
						<p class="margin-bottom">
						<?php echo $form->checkbox('Order.insurance', array('class'=>'checkbox marg-lt-rt', 'label'=>false, 'div'=>false ) ) ;?> 
						Add Additional Insurance - <?php echo CURRENCY_SYMBOL, $settings['Setting']['insurance_charges'];?> (<?php echo $html->link("what's  this?", '/checkouts/insurance_popup', array('class'=>'underline-link fancy_box_open', 'escape'=>false) );?>)</p>
					</li>

					<li>
						<div class="checkout-pro-widget">
						<div class="float-left">
							<?php echo $html->link( $html->image('checkout/back-btn.gif', array('alt'=>'', 'border'=>'') ) , '/checkouts/step2' , array('div'=>false, 'label'=>false, 'escape'=>false)  );?>
							</div>
						<div class="float-right pad-none">
							<!--<input type="image" src="/img/checkout/continue-checkout.gif" name="submit" value="submit" />-->
							<?php  echo $form->submit('checkout/continue-checkout.gif',  array('type'=>'image', 'name'=>'submit') ); ?>
						
						</div>
						</div>
					</li>
					
				</ul>
			</div>
			<!--Form Widget Closed-->
			<?php echo $form->end();
			//pr($cart_div_ids_array); ?>
		</div>
		<!--Form Left Widget Start-->
	</div>
	<!--Right Content Closed-->
</div>
<!--Content Closed-->



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
	// add by nakul on 7dec2011
	jQuery('#AddressShippingSelectedState').val(jQuery('#OrderBillingState').val());
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
		//displayState('B');
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
		jQuery('#OrderBillingUserTitle').addClass('error_message_box');
		jQuery('.error_msg_box').show();
		jQuery('.error_msg_box').html('Select title');
		jQuery('#OrderBillingUserTitle').focus();
		//alert('hel');
		//jQuery('#errBilTitleDivID').removeClass('error-message');
		//jQuery('#errBilTitleDivID').addClass('error-message-enable');
		return false;
	}else{
		jQuery('#OrderBillingUserTitle').removeClass('error_message_box');
		jQuery('.error_msg_box').html('');
		jQuery('.error_msg_box').hide();
	}
	if(jQuery.trim(jQuery('#OrderBillingFirstname').val()) == ''){
		//jQuery('#errBilFnameDivID').html('Enter first name');
		jQuery('#OrderBillingFirstname').focus();
		jQuery('.error_msg_box').show();
		jQuery('#OrderBillingFirstname').addClass('error_message_box');		
		jQuery('.error_msg_box').html('Enter first name');		
		return false;
	}else{
		jQuery('#OrderBillingFirstname').removeClass('error_message_box');
		jQuery('.error_msg_box').html('');
		jQuery('.error_msg_box').hide();
	}
	
	
	if(jQuery.trim(jQuery('#OrderBillingLastname').val()) == ''){
		jQuery('#OrderBillingLastname').addClass('error_message_box');
		jQuery('.error_msg_box').show();
		jQuery('.error_msg_box').html('Enter your surname');
		jQuery('#OrderBillingLastname').focus();
		return false;
	}else{
		jQuery('#OrderBillingLastname').removeClass('error_message_box');
		jQuery('.error_msg_box').html('');
		jQuery('.error_msg_box').hide();
	}
	
	if(jQuery.trim(jQuery('#OrderBillingAddress1').val()) == ''){		
		jQuery('#OrderBillingAddress1').addClass('error_message_box');
		jQuery('.error_msg_box').show();
		jQuery('.error_msg_box').html('Enter address');
		jQuery('#OrderBillingAddress1').focus();
		return false;
	}else{
		jQuery('#OrderBillingAddress1').removeClass('error_message_box');
		jQuery('.error_msg_box').html('');
		jQuery('.error_msg_box').hide();
	}
	
	if(jQuery.trim(jQuery('#OrderBillingCity').val()) == ''){ 
		jQuery('#OrderBillingCity').addClass('error_message_box');
		jQuery('.error_msg_box').show();
		jQuery('.error_msg_box').html('Enter city');
		jQuery('#OrderBillingCity').focus();
		return false;
	}else{;
		jQuery('#OrderBillingCity').removeClass('error_message_box');
		jQuery('.error_msg_box').html('');
		jQuery('.error_msg_box').hide();
	}
	
	if(jQuery.trim(jQuery('#OrderBillingPostalCode').val()) == ''){ 
		jQuery('#OrderBillingPostalCode').addClass('error_message_box');
		jQuery('.error_msg_box').show();
		jQuery('.error_msg_box').html('Enter postcode');
		jQuery('#OrderBillingPostalCode').focus();
		return false;
	}else if(jQuery.trim(jQuery('#OrderBillingPostalCode').val()).length < 3){
		jQuery('#OrderBillingPostalCode').addClass('error_message_box');
		jQuery('.error_msg_box').show();
		jQuery('.error_msg_box').html('The Postcode must have more than 3 characters');
		jQuery('#OrderBillingPostalCode').focus();
		return false;
	}else{
		jQuery('#OrderBillingPostalCode').removeClass('error_message_box');
		jQuery('.error_msg_box').html('');
		jQuery('.error_msg_box').hide();	
	}
	
	//if(jQuery('#OrderBillingState').val() == '' && jQuery('#OrderBillingCountryId').val() == '1'){
	
	
	
	
	if(jQuery.trim(jQuery('#OrderBillingCountryId').val()) == ''){ 
		jQuery('#OrderBillingCountryId').addClass('error_message_box');
		jQuery('.error_msg_box').show();
		jQuery('.error_msg_box').html('Select country');
		jQuery('#OrderBillingCountryId').focus();
		return false;
	}else{
		jQuery('#OrderBillingCountryId').removeClass('error_message_box');
		jQuery('.error_msg_box').html('');
		jQuery('.error_msg_box').hide();	
	}
	
	if(jQuery.trim(jQuery('#OrderBillingState').val()) == ''){
		jQuery('#OrderBillingState').addClass('error_message_box');
		jQuery('.error_msg_box').show();
		jQuery('.error_msg_box').html('Enter State/county');
		jQuery('#OrderBillingState').focus();
		return false;
	}else{
		jQuery('#OrderBillingState').removeClass('error_message_box');
		jQuery('.error_msg_box').html('');
		jQuery('.error_msg_box').hide();
	}
	
	if(jQuery.trim(jQuery('#OrderBillingPhone').val()) == ''){ 
		jQuery('#OrderBillingPhone').addClass('error_message_box');
		jQuery('.error_msg_box').show();
		jQuery('.error_msg_box').html('Enter telephone');
		jQuery('#OrderBillingPhone').focus();
		return false;
	}else if(jQuery('#OrderBillingPhone').val() != ''){ 
		var billtelno  = jQuery.trim(jQuery('#OrderBillingPhone').val());
		
		if(billtelno.length<=3) {
			jQuery('#OrderBillingPhone').addClass('error_message_box');
			jQuery('.error_msg_box').show();
			jQuery('.error_msg_box').html('The telephone number must have more than 3 digits');
			jQuery('#OrderBillingPhone').focus();
			return false;
		}else if(!billtelno.match(matchtelno)) {
			jQuery('#OrderBillingPhone').addClass('error_message_box');
			jQuery('.error_msg_box').show();
			jQuery('.error_msg_box').html('The telephone number must be in digits');
			jQuery('#OrderBillingPhone').focus();
			return false;
		}else {
			jQuery('#OrderBillingPhone').removeClass('error_message_box');
		jQuery('.error_msg_box').html('');
		jQuery('.error_msg_box').hide();
		}		
	}else{
		jQuery('#OrderBillingPhone').removeClass('error_message_box');
		jQuery('.error_msg_box').html('');
		jQuery('.error_msg_box').hide();
	}
	// +++++++++++++++++++++++++++billing  section ends  here  ++++++++++++++++++++++++++++++++++++++/	
	
	// validate shipping info if user selected different shipping info 
	
	// +++++++++++++++++++++++++++shipping section start here  ++++++++++++++++++++++++++++++++++++++/
	 // if(jQuery('#OrderShippingSame').attr('checked') == false) { // validate shipping info as well
		
		if(jQuery.trim(jQuery('#OrderShippingUserTitle').val()) == ''){ 
			jQuery('#OrderShippingUserTitle').addClass('error_message_box');
			jQuery('.error_msg_box').show();
			jQuery('.error_msg_box').html('Select title');
			return false;
		}else{
			jQuery('#OrderShippingUserTitle').removeClass('error_message_box');
			jQuery('.error_msg_box').html('');
			jQuery('.error_msg_box').hide();
		}
		if(jQuery.trim(jQuery('#OrderShippingFirstname').val()) == ''){ 
			jQuery('#OrderShippingFirstname').addClass('error_message_box');
			jQuery('.error_msg_box').show();
			jQuery('.error_msg_box').html('Enter first name');
			jQuery('#OrderShippingFirstname').focus();
			return false;
		}else{
			jQuery('#OrderShippingFirstname').removeClass('error_message_box');
			jQuery('.error_msg_box').html('');
			jQuery('.error_msg_box').hide();
		}
		
		if(jQuery.trim(jQuery('#OrderShippingLastname').val()) == ''){ 
			jQuery('#OrderShippingLastname').addClass('error_message_box');
			jQuery('.error_msg_box').show();
			jQuery('.error_msg_box').html('Enter your surname');
			jQuery('#OrderShippingLastname').focus();
			return false;
		}else{
			jQuery('#OrderShippingLastname').removeClass('error_message_box');
			jQuery('.error_msg_box').html('');
			jQuery('.error_msg_box').hide();
		}
		
		if(jQuery.trim(jQuery('#OrderShippingAddress1').val()) == ''){ 
			jQuery('#OrderShippingAddress1').addClass('error_message_box');
			jQuery('.error_msg_box').show();
			jQuery('.error_msg_box').html('Enter address');
			jQuery('#OrderShippingAddress1').focus();
			return false;
		}else{
			jQuery('#OrderShippingAddress1').removeClass('error_message_box');
			jQuery('.error_msg_box').html('');
			jQuery('.error_msg_box').hide();	
		}
		
		if(jQuery.trim(jQuery('#OrderShippingCity').val()) == ''){ 
			jQuery('#OrderShippingCity').addClass('error_message_box');
			jQuery('.error_msg_box').show();
			jQuery('.error_msg_box').html('Enter city');
			jQuery('#OrderShippingCity').focus();
			return false;
		}else{;
			jQuery('#OrderShippingCity').removeClass('error_message_box');
			jQuery('.error_msg_box').html('');
			jQuery('.error_msg_box').hide();
		}
		
		if(jQuery.trim(jQuery('#OrderShippingPostalCode').val()) == ''){ 
			jQuery('#OrderShippingPostalCode').addClass('error_message_box');
			jQuery('.error_msg_box').show();
			jQuery('.error_msg_box').html('Enter postcode');
			jQuery('#OrderShippingPostalCode').focus();
			return false;
		}else if(jQuery.trim(jQuery('#OrderShippingPostalCode').val()).length < 3){ 
			jQuery('#OrderShippingPostalCode').html('The Postcode must have more than 3 characters');
			jQuery('#OrderShippingPostalCode').focus();
			return false;
		}else{
			jQuery('#OrderShippingPostalCode').removeClass('error_message_box');
			jQuery('.error_msg_box').html('');
			jQuery('.error_msg_box').hide();
		}
		
		
		if(jQuery.trim(jQuery('#OrderShippingCountryId').val()) == ''){ 
			jQuery('#OrderShippingCountryId').addClass('error_message_box');
			jQuery('.error_msg_box').show();
			jQuery('.error_msg_box').html('Select country');
			jQuery('#OrderShippingCountryId').focus();
			return false;
		}else{
			jQuery('#OrderShippingCountryId').removeClass('error_message_box');
			jQuery('.error_msg_box').html('');
			jQuery('.error_msg_box').hide();	
		}
		//if(jQuery('#OrderShippingState').val() == '' && jQuery('#OrderShippingCountryId').val() == '1'){ 
		if(jQuery.trim(jQuery('#OrderShippingState').val()) == ''){ 
			jQuery('#OrderShippingState').addClass('error_message_box');
			jQuery('.error_msg_box').show();
			jQuery('.error_msg_box').html('Enter county/state');
			jQuery('#OrderShippingState').focus();
			return false;
		}else{
			jQuery('#OrderShippingState').removeClass('error_message_box');
			jQuery('.error_msg_box').html('');
			jQuery('.error_msg_box').hide();
		}
		
		
		
		
		
		if( jQuery.trim(jQuery('#OrderShippingPhone').val()) == ''){ 
			jQuery('#OrderShippingPhone').addClass('error_message_box');
			jQuery('.error_msg_box').show();
			jQuery('.error_msg_box').html('Enter enter phone');
			jQuery('#OrderShippingPhone').focus();
			return false;
		}else if( jQuery.trim(jQuery('#OrderShippingPhone').val()) != ''){ 
			var billtelno  = jQuery.trim(jQuery('#OrderShippingPhone').val());
			if(billtelno.length<=3) {
				jQuery('#OrderShippingPhone').addClass('error_message_box');
				jQuery('.error_msg_box').show();
				jQuery('.error_msg_box').html('The telephone number must have more than 3 digits');
				jQuery('#OrderShippingPhone').focus();
				return false;
			}else if(!billtelno.match(matchtelno)) {
				jQuery('#OrderShippingPhone').addClass('error_message_box');
				jQuery('.error_msg_box').show();
				jQuery('.error_msg_box').html('The telephone number must be in digits');
				jQuery('#OrderShippingPhone').focus();
				return false;
			}else {
				jQuery('#OrderShippingPhone').removeClass('error_message_box');
				jQuery('.error_msg_box').html('');
				jQuery('.error_msg_box').hide();
			}		
		}else{
			jQuery('#OrderShippingPhone').removeClass('error_message_box');
			jQuery('.error_msg_box').html('');
			jQuery('.error_msg_box').hide();
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