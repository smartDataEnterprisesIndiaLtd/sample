<?php 
echo $html->script('jquery-1.4.3.min',true);
echo $javascript->link('lib/prototype',true);?>
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
	//var selectclassName = 'slct';
	//var textclassName = 'txtfld';
	var selectclassName = jQuery("#textclassSelectId").val();
	var textclassName = jQuery("#textclassNameId").val();
	
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
 <!--Tabs Start-->
<?php echo $this->element('mobile/orders/tab');?>
<!--Tbs Closed-->
<span id="plsLoaderID" style="display:none; text-align:center; margin-left:50%" class="dimmer"><img src="/img/loading.gif" alt="Loading" style="position:fixed;left:30%;top:40%;z-index:999;" />                     </span>

<!--Tbs Cnt start-->
<section class="tab-content padding0">
<!--Manage Listings Start-->
<section class="offers">
	<?php echo $html->link(
	'<section class="gr_grd brd-tp0">
		<h4 class="orng-clr">
			<font color=#ED6C0B>Manage Listings</font>
		</h4>
	<div class="loader-img">
		'.$html->image('mobile/down_arrow_blue.png',array('alt'=>'')).'
	</div>
	</section>','/marketplaces/manage_listing',array('escape'=>false));?>
	
</section>
<!--Manage Listings Closed-->
<?php /****************************Manage Listings Closed*************************/?>

<!--View Orders Start-->
<section class="offers">
	<?php echo $html->link(
	'<section class="gr_grd" style="margin-top:11px;">
		<h4 class="orng-clr">
			<font color=#ED6C0B>View Orders</font>
		</h4>
		<div class="loader-img">
			'.$html->image('mobile/down_arrow_blue.png',array('alt'=>'')).'
		</div>
	</section>','/sellers/orders/',array('escape'=>false));?>
</section>
<!--View Orders Closed-->
<?php /****************************View Orders Closed*************************/?>

<!--************************Sales Reports Start*************************-->
<section class="offers" >
	<?php echo $html->link(
	'<section class="gr_grd" style="margin-top:11px;">
		<h4 class="orng-clr">
			<font color=#ED6C0B>Sales Reports</font>
		</h4>
		<div class="loader-img">
			'.$html->image('mobile/down_arrow_blue.png',array('alt'=>'')).'
		</div>
	</section>','/marketplaces/sales_report/',array('escape'=>false));?>
</section>
<!--Sales Reports Closed-->
<?php /****************************Sales Reports Closed*************************/?>
<!--Account Settings Start-->
<section class="offers">                	
		<section class="gr_grd" style="margin-top:11px;">
		<h4 class="orng-clr">
			<?php echo $html->link('<font color=#ED6C0B>Account Settings</font>','/sellers/my_account/',array('escape'=>false));?>
		</h4>
			<div class="loader-img">
				<?php echo $html->image('mobile/down_arrow_blue.png',array('alt'=>''));?>
			</div>
		</section>
				<!--Row1 Start for account settion contaion comes on this div-->
				<div class="row-full" id="my-account">
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
	</div>
	<!--Row1 Closed-->
	
</section>
<!--Account Settings Closed-->
<?php /****************************Account Settings Closed*************************/?>
</section>
<!--Tbs Cnt closed-->
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
