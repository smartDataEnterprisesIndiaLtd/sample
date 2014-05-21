<?php ?>
<script language="JavaScript">	
// function to provide the state dropdown

function displayState(){
	//alert('Hello');
	var countryId = jQuery("#SellerCountryId").val();
	var stateFieldName = jQuery("#userStateFieldName").val();
	var selectedStateValue = jQuery("#AddressSelectedState").val();
	if(countryId == ''){
		countryId = '0';
	}
        if(selectedStateValue == ''){
		selectedStateValue = '1';
	}
	var selectclassName = 'select';
	var textclassName = 'form-textfield';
	
            var url = SITE_URL+'totalajax/DisplayStateBox/'+countryId+'/'+stateFieldName+'/'+selectedStateValue+'/'+selectclassName+'/'+textclassName;
            //alert(url);
            jQuery('#preloader').show();
            jQuery.ajax({
                    cache:false,
                    async:false,
                    type: "GET",
                    url:url,
                    success: function(msg){
                            jQuery('#userStateTextSelect_div').html(msg);
                            jQuery('#preloader').hide();
                    }
            });
	
}
</script>
<!--<div id="my-account"><?php //echo $this->element('marketplace/updateseller');?></div>-->

	<?php
		if ($session->check('Message.flash')){ ?>
			<div class="messageBlock"><?php echo $session->flash();?></div>
		<?php }
	?>
	<!--Start div for customer information-->	
	<div id ="cus-info" class="settings">
	</div>
	<!--END div for customer information-->
	
	<!--Start div for Business information-->
	<div id="business-info" class="settings">
	</div>
	<!--End div for Business information-->
	
	<!--Start div for Free Delivery-->
	<div id="free-delivery" class="settings">
		<?php echo $this->element('mobile/marketplace/free_delivery');?>
	</div>
	<!--Start div for Free Delivery-->
	
	<div id="gift-options" class="settings">
		<?php echo $this->element('mobile/marketplace/gift_options');?>
	</div>
	
<script type="text/javascript">
function customerInfo(){
	var postUrl = SITE_URL+'sellers/update_customer_info';
	jQuery('#plsLoaderID');
	jQuery.ajax({
		cache:false,
		async:false,
		type:"GET",
		url:postUrl,
		success:function(msg){
		jQuery('#cus-info').html(msg);
		jQuery('#plsLoaderID').hide();
	}
	});
}
window.onload = customerInfo();

function businessInfo(){
	var postUrl = SITE_URL+'sellers/update_business_info';
	jQuery('#plsLoaderID');
	jQuery.ajax({
		cache:false,
		async:false,
		type:"GET",
		url:postUrl,
		success:function(msg){
		jQuery('#business-info').html(msg);
		jQuery('#plsLoaderID').hide();
	}
	});
}
window.onload = businessInfo();
</script>
