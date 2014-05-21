<?php if(!empty($pro_info) ) {
echo $this->element('seller/product_left');//echo $this->element('search');
} else{
//echo $this->element('search_fullpage');
} ?>
<!--mid Content Start-->
<div class="mid-content pad-rt-none" style="position:relative;">
	
	
	<?php echo $this->element('seller/profile_image'); ?>
	<h2 class="choiceful margin-tp-btm mrgin-heading"><span class="sml-fnt black-color">Seller</span> <?php echo $seller_info['Seller']['business_display_name'];?></h2>
		<p class="margin-bottom margin-summary"><?php echo $html->link('Browse all '.$seller_info['Seller']['business_display_name'].'\'s  store','/sellers/store/'.$seller_id,array('escape'=>false,'class'=>'underline-link'));?></p>
		<?php echo $this->element('seller/tabs');?>
		
		<!--Tabs Widget Start-->
		<div class="tbs-content-widget overflow-h">
			
			<!--Tabs Content Section Start-->
			<div class="tabs-content-sec">
			
			<!--Inner Content Start-->
			<div class="inner-content">
			
			<h4 class="choiceful pad-btm font-size13">Returns Instructions</h4>
			<p>Locate your order ID in <?php echo $html->link('your account','/orders/order_history',array('escape'=>false,'class'=>'underline-link'));?> in view orders, then return items from the selected order.</p>
			<p><?php echo $html->link('Contact this seller','/orders/contact_sellers/'.$seller_id,array('escape'=>false,'class'=>'underline-link'));?> <span class="line-break smalr-fnt">(Must have a Choiceful.com account and have placed an order)</span></p>
			<p  class="pad-none"><span class="smalr-fnt line-break">Want to cancel an order, or return an item?</span>
			<?php echo $html->link('Cancelling orders','/orders/view_open_orders/seller_id:'.$seller_id,array('escape'=>false,'class'=>'underline-link'));?></p>
			<p class="smalr-fnt">&nbsp;</p>                         
			<h4 class="choiceful margin-tp-btm font-size13">Returns  Policy</h4>
				<p class="smalr-fnt" style="text-align:justify"><?php echo strip_tags($format->formatString($refundreturn_des,3100,'...')); echo $html->link('Read more','/pages/view/returns-policy',array('escape'=>false,'class'=>'underline-link'));?></p>
			</div>
			<!--Inner Content Closed-->
			
			</div>
			<!--Tabs Content Section Closed-->
		
		</div>
		<!--Tabs Widget Closed-->
</div>
<!--mid Content Closed-->