<?php
$user_in_session = $this->Session->read('User');
$market_action = $this->params['action'];
$market_controller = $this->params['controller'];
?>
<!--Choiceful MarketPlace Start-->
<div class="side-content">
	<h4 class="inner-gray-bg-head"><span><?php echo $html->image("red-arrow-icon.png",array('width'=>"5",'height'=>"10",'alt'=>"")); ?> Choiceful MarketPlace</span></h4>
	<div class="gray-fade-bg-box padding white-bg-box">
		<ul class="inner-left-links">
			<?php //if(!empty($user_in_session)){
			if(empty($user_in_session['seller_id'])){
				 ?>
			<?php if($market_controller != 'seller' && $market_action != 'sign_up') {?>
			<li><?php echo $html->link('What is Choiceful MarketPlace?',array('controller'=>'pages','action'=>'view','what-is-choiceful'),array('escape'=>false));?></li>
			<li><?php echo $html->link("Join Choiceful MarketPlace","/sellers/choiceful-marketplace-sign-up",array('escape'=>false));?></li>
			<?php }?>
			<?php } //}?>
			<!-- Below links are only for sellelr -->
			<li><?php echo $html->link("Manage Listings","/marketplaces/manage_listing",array('escape'=>false));?></li>
			<li><?php echo $html->link("View Orders","/sellers/orders",array('escape'=>false));?></li>
			<li><?php echo $html->link("Buyer Communication","/messages/sellers",array('escape'=>false));?></li>
			<li><?php echo $html->link("Sales Reports","/marketplaces/sales_report",array('escape'=>false));?></li>
			<li><?php echo $html->link("Payment Settings","/sellers/payment_settings",array('escape'=>false));?></li>
			<li><?php echo $html->link("Account Setting","/sellers/my_account",array('escape'=>false));?></li>
			
			<li><?php echo $html->link("MarketPlace Help","/pages/view/marketplace-buyer-guide",array('escape'=>false));?></li>
			
			<!-- End of Below links are only for buyer -->
				
		</ul>
	</div>
</div>
<!--Choiceful MarketPlace Closed-->