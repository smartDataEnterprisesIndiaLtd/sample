<?php
echo $javascript->link(array('jquery-1.3.2.min','lib/prototype'),'');
$sessOrderData = $this->Session->read('sessOrderData');
if(empty($sessOrderData) ){
$this->data['Order']['shipping_user_title']=$this->data['Order']['billing_user_title'];
$this->data['Order']['shipping_firstname']=$this->data['Order']['billing_firstname'];
$this->data['Order']['shipping_lastname']=$this->data['Order']['billing_lastname'];
$this->data['Order']['shipping_address1']=$this->data['Order']['billing_address1'];
$this->data['Order']['shipping_address2']=$this->data['Order']['billing_address2'];
$this->data['Order']['shipping_city']=$this->data['Order']['billing_city'];
$this->data['Order']['shipping_postal_code']=$this->data['Order']['billing_postal_code'];
$this->data['Order']['shipping_country_id']=$this->data['Order']['billing_country_id'];
$this->data['Order']['shipping_phone']=$this->data['Order']['billing_phone'];
}

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
<style>
.select{
    border: 1px solid #CECECE;
    padding: 5px;
    width: 99%;
   }
   
    .slct {
    padding: 1px;

}

</style>
<script type="text/javascript" >
jQuery(document).ready(function(){
	jQuery('#OrderBillingCountryId').change(function() {
		displayState('B'); // billing 
		var countryValue = jQuery("#OrderBillingCountryId").val();
		PutThisDataInShippingAsWell(countryValue,9);
	})
	jQuery('#OrderShippingCountryId').change(function() {
		displayState('S'); // shipping state  
		
	})

	displayState('s'); // billing
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
			//processDeliveryEstimation(countryId); // call function to process the estimation
		
		var stateFieldName = jQuery("#shippingStateFieldName").val();
		var selectedStateValue = jQuery("#AddressShippingSelectedState").val();
			var url = SITE_URL+'totalajax/DisplayShippingStateBox/'+countryId+'/'+stateFieldName+'/'+selectedStateValue;

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
	function showbillingadd(){
		if(jQuery('#changeBilling').attr('checked') == true){ // if shipping and billing are same then
			jQuery('#billingadd').show();
		}else{
			jQuery('#billingadd').hide();
		}
		
	
	}
</script>		
<!--Content Start-->
<!--Main Content Starts--->
             <section class="maincont nopadd">
                <section class="prdctboxdetal margin-top">
                <span id="preloader" style="display:none; text-align:center; margin-left:50%" class="dimmer"><?php echo $html->image("loading.gif" ,array('alt'=>"Loading" ,  'style'=>'position:fixed;top:30%;z-index:999;'));?>
                </span>
                <?php // display session error message
			if ($session->check('Message.flash')){ ?>
			<div  class="messageBlock"><?php echo $session->flash();?></div>
		<?php } ?>
		<div class="error_msg_box" style="display: none"; ></div>
		<?php echo $form->create("Checkout", array('action'=>'change_shippingadd','default' => true,'name'=>'frmbill', 'onsubmit'=>'return validateStep3Form();'));?>
			
                    <h4 class="diff-blu">Checkout Choiceful: Swift, Simple & Secure</h4>
                    <h4 class="orng-clr"><span class="gray-color">Step 3 of 5</span> Add a New Shipping Address</h4>
                    <p class="lgtgray applprdct">Edit your shipping address below, if you want to add a different billing address select the option below.</p>

                    <ul class="signinlist xprsrgstrson xprsfrm2">
                       <li>
                           <label>Title:</label>
                           <div class="field">
                           <p class="pad-rt12">
                           	<?php echo $form->select('Order.shipping_user_title',$title,$this->data['Order']['shipping_user_title'],array('type'=>'select','style'=>'width:50px;','class'=>'slct small-width','label'=>false,'div'=>false,'size'=>1),'Select..'); 
				echo $form->error('Order.shipping_user_title');?>
				<div class="error-message" id="errShipTitleDivID">
				
			   </p>
			   </div>
                       </li>
                       <li>
                       	   <label>First name:</label>
                           <div class="field">
				<p class="pad-rt12">
					<?php echo $form->input('Order.shipping_firstname',array('maxlength'=>'100','class'=>'form-textfield','label'=>false, 'value'=>$this->data['Order']['shipping_firstname'] , 'div'=>false));?>
					<div class="error-message" id="errShipFnameDivID">
				</p>
                           </div>
                        </li>
                       <li>
                       		<label>Last name:</label>
                            <div class="field"><p class="pad-rt12">
                            	<?php echo $form->input('Order.shipping_lastname',array('maxlength'=>'100', 'value'=>$this->data['Order']['shipping_lastname'],'class'=>'form-textfield','label'=>false, 'div'=>false));?>
				<div class="error-message" id="errShipLnameDivID"></div>
			    </p></div>
                        </li>
                       <li>
                       	<label>Address Line 1:</label>
                        <div class="field"><p class="pad-rt12">
                            <?php echo $form->input('Order.shipping_address1',array('maxlength'=>'100','value'=>$this->data['Order']['shipping_address1'],'class'=>'form-textfield','label'=>false, 'div'=>false));?>
				<div class="error-message" id="errShipAddressDivID"></div>
			</p></div>
			</li>
			
                       <li><label style="color:#000;">Address Line 2:</label>
                       <div class="field">
			<p class="pad-rt12">
				<?php echo $form->input('Order.shipping_address2',array('maxlength'=>'100', 'value'=>$this->data['Order']['shipping_address2'],'class'=>'form-textfield','label'=>false, 'div'=>false));?>
				<div class="error-message" id="errShipAddressDivID"></div>
			</p>
                       <span class="opsonal">Optional</span></div>
                       
                       </li>
                       <li><label>Town/City:</label>
			<div class="field">
				<p class="pad-rt12">
					<?php echo $form->input('Order.shipping_city',array('maxlength'=>'100','value'=>$this->data['Order']['shipping_city'],'class'=>'form-textfield','label'=>false,'div'=>false));?>
					<div class="error-message" id="errShipCityDivID"></div>
				</p>
			</div>
                       </li>
                       <li><label>Postcode:</label>
			<div class="field">
			<p class="pad-rt12">
				<?php echo $form->input('Order.shipping_postal_code',array('onkeyup'=>'PutThisDataInShippingAsWell(this.value,8)', 'maxlength'=>'100','value'=>$this->data['Order']['shipping_postal_code'],'class'=>'form-textfield','label'=>false,'div'=>false));?>
				<div class="error-message" id="errBilPostcodeDivID"></div>
			</p>
			</div>
                       </li>
                       <li><label>Country:</label>
                       <div class="field">
			<p class="pad-rt12">
					<?php echo $form->select('Order.shipping_country_id',$shippingCountries,$this->data['Order']['shipping_country_id'],array('type'=>'select', 'class'=>'slct','label'=>false,'div'=>false,'size'=>1),'Select...');
					echo $form->error('Order.shipping_country_id'); ?>
					<div class="error-message" id="errShipCountryIdDivID"></div>
					
				</p>
			</div>
			</li>
			
			<li><label>State/County:</label>
                       <div class="field">
				<p class="pad-rt12">
					<input type="hidden" name="shippingStateFieldName" id="shippingStateFieldName" value="Order.shipping_state">
					<?php echo $form->hidden('Address.shipping_selected_state', array('value'=>$this->data['Order']['shipping_state']));?>
					<span id="shippingStateTextSelect">
					<?php echo $form->input('Order.shipping_state',array('maxlength'=>'100','class'=>'form-textfield','style'=>'width:97%','label'=>false,'div'=>false));?>
					</span>
					<div class="error-message" id="errShipStateDivID">
					<?php echo $form->error('Order.shipping_state');?></div>
					
				</p>
			</div>
                       </li>
			
			<li><label>Phone Number:</label>
			<div class="field">
				<p class="pad-rt12">
					<?php echo $form->input('Order.shipping_phone',array('maxlength'=>'100','value'=>$this->data['Order']['shipping_phone'],'class'=>'form-textfield','label'=>false,'div'=>false));?>
					<div class="error-message" id="errShipPhoneDivID">
				</p>
			</div>
			</li>
			
                       <li><label>&nbsp;</label><div class="field"><div class="check">
                       <input id="changeBilling" type="checkbox" onchange="showbillingadd()" /></div>
                       <div class="agree">Select this option if you would like to add a different billing address.</div></div></li>
                       
                       <!-- Start Billing Changed Address-->
                       <div id="billingadd" style="display:none;">
                        <li>
                           <label>Title:</label>
                           <div class="field">
                           <p class="pad-rt12">
                           	<?php echo $form->select('Order.billing_user_title',$title,$this->data['Order']['shipping_user_title'],array('type'=>'select','style'=>'width:50px;','class'=>'slct small-width','label'=>false,'div'=>false,'size'=>1),'Select..'); 
				echo $form->error('Order.shipping_user_title');?>
				<div class="error-message" id="errShipTitleDivID">
				
			   </p>
			   </div>
                       </li>
                       <li>
                       	   <label>First name:</label>
                           <div class="field">
				<p class="pad-rt12">
					<?php echo $form->input('Order.billing_firstname',array('maxlength'=>'100','class'=>'form-textfield','label'=>false, 'div'=>false));?>
					<div class="error-message" id="errShipFnameDivID">
				</p>
                           </div>
                        </li>
                       <li>
                       		<label>Last name:</label>
                            <div class="field"><p class="pad-rt12">
                            	<?php echo $form->input('Order.billing_lastname',array('maxlength'=>'100', 'class'=>'form-textfield','label'=>false, 'div'=>false));?>
				<div class="error-message" id="errShipLnameDivID"></div>
			    </p></div>
                        </li>
                       <li>
                       	<label>Address Line 1:</label>
                        <div class="field"><p class="pad-rt12">
                            <?php echo $form->input('Order.billing_address1',array('maxlength'=>'100','class'=>'form-textfield','label'=>false, 'div'=>false));?>
				<div class="error-message" id="errShipAddressDivID"></div>
			</p></div>
			</li>
			
                       <li><label style="color:#000;">Address Line 2:</label>
                       <div class="field">
			<p class="pad-rt12">
				<?php echo $form->input('Order.billing_address2',array('maxlength'=>'100','class'=>'form-textfield','label'=>false, 'div'=>false));?>
				<div class="error-message" id="errShipAddressDivID"></div>
			</p>
                       <span class="opsonal">Optional</span></div>
                       
                       </li>
                       <li><label>Town/City:</label>
			<div class="field">
				<p class="pad-rt12">
					<?php echo $form->input('Order.billing_city',array('maxlength'=>'100','class'=>'form-textfield','label'=>false,'div'=>false));?>
					<div class="error-message" id="errShipCityDivID"></div>
				</p>
			</div>
                       </li>
                       <li><label>Postcode:</label>
				<div class="field">
					<p class="pad-rt12">
						<?php echo $form->input('Order.billing_postal_code',array('onkeyup'=>'PutThisDataInShippingAsWell(this.value,8)', 'maxlength'=>'100','class'=>'form-textfield','label'=>false,'div'=>false));?>
					<div class="error-message" id="errBilPostcodeDivID"></div>
					</p>
				</div>
                       </li>
                       <li><label>Country:</label>
                       <div class="field">
			<p class="pad-rt12">
					<?php echo $form->select('Order.billing_country_id',$shippingCountries,$this->data['Order']['shipping_country_id'],array('type'=>'select','class'=>'slct','label'=>false,'div'=>false,'size'=>1),'Select...');
					echo $form->error('Order.shipping_country_id'); ?>
					<div class="error-message" id="errShipCountryIdDivID"></div>
					
				</p>
			</div>
			</li>
			
			<li><label>State/County:</label>
                       <div class="field">
				<p class="pad-rt12">
					<input type="hidden" name="billingStateFieldName" id="billingStateFieldName" value="Order.billing_state">
					<?php echo $form->hidden('Address.billing_selected_state', array('value'=>$this->data['Order']['billing_state']));?>
					<span id="billingStateTextSelect">
						<?php echo $form->input('Order.billing_state',array('onkeyup'=>'PutThisDataInShippingAsWell(this.value,7)', 'maxlength'=>'100','class'=>'form-textfield','label'=>false,'div'=>false));?>
					</span>
					<div class="error-message" id="errBilStateDivID">
						<?php //echo $form->error('Order.billing_state');?>	
					</div>

				</p>
			</div>
                       </li>
			
			<li><label>Phone Number:</label>
			<div class="field">
				<p class="pad-rt12">
					<?php echo $form->input('Order.billing_phone',array('maxlength'=>'100','class'=>'form-textfield','label'=>false,'div'=>false));?>
					<div class="error-message" id="errShipPhoneDivID">
				</p>
			</div>
			</li>
			</div>
			<!-- End Billing Changed Address-->
			
                       <div>
                       <li class="continext"><label>&nbsp;</label><div class="field">
                       <input type="submit" class="signinbtnwhyt cntnuchkot" value="Continue"></div></li>
                    </ul>
                <?php echo $form->end();?>
                </section>
             </section>
          <!--Main Content End--->
          <!--Navigation Starts-->
             <nav class="nav">
                 <ul class="maincategory yellowlist">
                         <?php echo $this->element('mobile/nav_footer');?>
                      </ul>
             </nav>
<script type="text/javascript" >    
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
