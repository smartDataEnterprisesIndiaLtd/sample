<style type="text/css">
.dimmer{
position:absolute;
left:45%;
top:55%;
}
.account-setting {
margin:0px;
}
.messageBlock{
margin:5px 0px;
}
.error-message {
    width: 508px;
}
</style>

<!--mid Content Start--><!--mid Content Start-->
<div class="mid-content pad-rt-none">
	<?php //echo $this->element('marketplace/breadcrum');?>
	<!--Setting Tabs Widget Start-->
	<div class="row-widget">
		<!--Tabs Widget Start-->
		<?php echo $this->element('navigations/seller_heading_bar'); ?>
		<!--Tabs Widget Closed-->
		<!--Tabs Content Start-->
		<div class="tabs-content">
		<!--Customer Service Contact Information Start-->
			<?php
			if ($session->check('Message.flash')){ ?>
				<div class="messageBlock"><?php echo $session->flash();?></div>
			<?php }
			?>
			<div id ="cus-info" style="margin-top:10px">
				<?php echo $this->element('marketplace/customer_service_information');?>
			</div>
			<div id="plsLoaderID" style="display:none" class="dimmer"><?php echo $html->image("loading.gif" ,array('alt'=>"Loading" ));?></div>
			<!--Customer Service Contact Information Closed-->
			<!--Business Information Start-->
			<div id = "business-info" style="margin-top:10px">
				<?php echo $this->element('marketplace/business_info');?>
			</div>
			<!--Business Information Closed-->
			<div id = "free-delivery" style="margin-top:10px">
				<?php echo $this->element('/marketplace/free_delivery');?>
			</div>
			<div id ="gift-options" style="margin-top:10px">
				<?php echo $this->element('/marketplace/gift_options');?>
			</div>
		</div>
		<!--Tabs Content Closed-->
	</div>
	<!--Setting Tabs Widget Closed-->
</div>
<!--mid Content Closed-->