<?php
echo $html->css('dhtmlgoodies_calendar.css');
e($html->script('dhtmlgoodies_calendar.js'));
e($html->script(array('behaviour.js','textarea_maxlen')));
?>
<!--mid Content Start-->
<!--mid Content Start-->
<div class="mid-content pad-rt-none">
	<div class="row">
		<!--Setting Tabs Widget Start-->
		<?php echo $this->element('marketplace/breadcrum'); ?>
		<!--Setting Tabs Widget Start-->
		<!--Tabs Widget Start-->
		<?php echo $this->element('navigations/seller_heading_bar'); ?>
		<!--Tabs Content Start-->
		<div class="tabs-content">
			<!--Discription Start-->
			<div class="inner-content">
				<p>Available options on an order.</p>
			</div>
			<!--Discription Closed-->
		</div>
		<!--Tabs Content Closed-->
	</div>
	<!--Setting Tabs Widget Closed-->
</div>
<!--mid Content Closed-->
<?php
	if ($session->check('Message.flash')){ ?>
		<div class="messageBlock">
			<?php echo $session->flash();?>
		</div>
	<?php } ?>
<!--Search Results Start-->
<div class="search-results-widget" style="overflow:visible;" id ="OrderInformation">
	<?php if(!empty($ship_edit)){
		if($ship_edit == 'shipment')
			echo $this->element('seller/orderdetails_edit');
	} else{
		echo $this->element('seller/orderdetails');
	}?>
</div>
<!--Search Results Closed-->
<?php echo $this->element('seller/order_item_shipmentdetails');?>
<?php echo $this->element('seller/seller_order_feedback');?>

<!--Seller Note Widget Start-->

<div class="seller-note-widget" id="seller_note">
	<?php
echo $this->element('seller/seller_note');?>
</div>
<div id="plsLoaderID" style="display:none" class="dimmer"><?php echo $html->image("loading.gif" ,array('alt'=>"Loading" ));?></div>
<!--Seller Note Widget Closed-->
<script language="JavaScript">
	var carr_value = jQuery('#OrderSellerShippingCarrier').val();
	if(carr_value == 8 || carr_value == 9){
		enter_carrier(carr_value);
	}
	function enter_carrier(carrierValue){
		if(carrierValue == 9 || carrierValue == 8){
			jQuery('#othercarrier').css('display','block');
			jQuery('#othercarrier').css('padding-top','5px');
		} else{
			jQuery('#othercarrier').css('display','none');
		}
	}
</script>