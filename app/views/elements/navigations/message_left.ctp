<?php
$user_in_session = $this->Session->read('User');

$market_action = $this->params['action'];
$market_controller = $this->params['controller'];
?>
<div class="left-content">
	<!--Choiceful MarketPlace Start-->
	<div class="side-content">
		<h4 class="inner-gray-bg-head"><span><?php echo $html->image("red-arrow-icon.png",array('width'=>"5",'height'=>"10",'alt'=>"")); ?> Choiceful MarketPlace</span></h4>
		<div class="gray-fade-bg-box padding white-bg-box">
		<ul class="inner-left-links">
			<!-- Below links are only for sellelr -->
			<li><?php echo $html->link("Manage Listings","/marketplaces/manage_listing",array('escape'=>false));?></li>
			<li><?php echo $html->link("View Orders","/sellers/orders",array('escape'=>false));?></li>
			<li><?php echo $html->link("Buyer Communication","/messages/sellers",array('escape'=>false));?></li>
			<li><?php echo $html->link("Sales Reports","/marketplaces/sales_report",array('escape'=>false));?></li>
			<li><?php echo $html->link("Payment Settings","/sellers/payment_settings",array('escape'=>false));?></li>
			<li><?php echo $html->link("Account Setting","/sellers/my_account",array('escape'=>false));?></li>			
			<li><?php echo $html->link("MarketPlace Help","/pages/view/what-is-choiceful-marketplace",array('escape'=>false));?></li>
			
			<!-- End of Below links are only for buyer -->
			</ul>
		</div>
	</div>
	<!--Choiceful MarketPlace Closed-->
</div>