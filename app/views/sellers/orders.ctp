<?php
echo $javascript->link(array('jquery-1.3.2.min','lib/prototype','selectAllCheckbox_front'),false);

?><style type="text/css">
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
</style>
<!--mid Content Start-->
<div class="mid-content pad-rt-none">
		<!--Setting Tabs Widget Start-->
		<!--- <?php //echo $this->element('marketplace/breadcrum'); ?> --->
		<!--Setting Tabs Widget Start-->
		<!--Tabs Widget Start-->
	<div class="row-widget">
		<?php echo $this->element('navigations/seller_heading_bar'); ?>
		<!--Tabs Content Start-->
		<div class="tabs-content">
			<!--Discription Start-->
			<div class="inner-content">
				<p>Manage your sales, download orders, confirm shipments and cancel orders. To view more information about the order, such as the buyer name or shipping address click on the order number.</p>
				<ul><li style="float:left;padding:0 20px 0 0"><?php echo $html->link('Download All Orders' ,"/sellers/download_all_orders" ,array('escape'=>false,'class'=>"underline-link"));?> &nbsp;| &nbsp;<?php echo $html->link('Download Unshipped Orders' ,"/sellers/download_unshipped_orders" ,array('escape'=>false,'class'=>"underline-link"));?></li>
				<li style="text-align:right;"></li></ul>
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
<div class="search-results-widget" style="overflow:visible;">
	<div id="listing">
		<?php echo $this->element('seller/orders_listing');?>
	</div>
	
</div>
<!--Search Results Closed-->

<script language="JavaScript">
	function updateFiltertext(fromid,toid){
		var valuefilter = jQuery('#Listing'+fromid+'Options').val();
		jQuery('#Listing'+toid+'Options').val(valuefilter);
		jQuery('#PageFilter').val(valuefilter);
	}
</script>