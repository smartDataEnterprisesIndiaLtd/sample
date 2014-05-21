<?php ?>
<!--Orders Start-->
<div class="side-content">
	<h4 class="inner-gray-bg-head"><span><?php echo $html->image("red-arrow-icon.png",array('width'=>"5",'height'=>"10",'alt'=>"")); ?> Orders</span></h4>
	<div class="gray-fade-bg-box padding white-bg-box">
		<ul class="inner-left-links">
			<li><?php echo $html->link("View Open Orders","/orders/view_open_orders/",array('escape'=>false));?></li>
			<li><?php echo $html->link("Order History","/orders/order_history/",array('escape'=>false));?></li>
			<li><?php echo $html->link("Return Items","/orders/return_items/",array('escape'=>false));?></li>
			<li><?php echo $html->link("Contact Sellers","/orders/contact_sellers/",array('escape'=>false));?></li>
			<li><?php echo $html->link("Leave Seller Feedback","/orders/leave_seller_feedback/",array('escape'=>false));?></li>
		</ul>
	</div>
</div>
<!--Orders Closed-->