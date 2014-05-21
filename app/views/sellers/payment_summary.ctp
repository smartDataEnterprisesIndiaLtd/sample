<?php
	echo $javascript->link(array('jquery-1.3.2.min','lib/prototype'),false);
?>
<style type="text/css">
	.messageBlock {
		border:0px;
		margin:0px
	}
</style>
<!--mid Content Start--><!--mid Content Start-->
<div class="mid-content pad-rt-none">
<!---<?php //echo $this->element('marketplace/breadcrum'); ?> --->
	<!--Setting Tabs Widget Start-->
	<div class="row-widget">
		<!--Tabs Widget Start-->
		<?php echo $this->element('navigations/seller_heading_bar'); ?>
		<?php echo $this->element('marketplace/payment_summary');?>
	</div>
	<!--Setting Tabs Widget Closed-->
</div>
<!--mid Content Closed-->
<!--<div id="my-account"></div>-->
