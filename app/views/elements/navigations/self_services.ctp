<?php ?>
<!--Self Services Start-->
<div class="side-content">
	<h4 class="gray-bg-head"><span>Self-Service</span></h4>
	<div class="gray-fade-bg-box padding">
		<ul>
		<li><?php echo $html->link('Check Order Status','/orders/view_open_orders/',array('escape'=>false));?></li>
		<li><?php echo $html->link('View Order History','/orders/order_history/',array('escape'=>false));?></li>
		<?php
			$user_id = $this->Session->read('User.id');
			if(empty($user_id)) { ?>
			<li><?php echo $html->link('Forgot Your Password?','/users/forgot-password-assistant',array('escape'=>false));?></li>
 			<?php }?>
		<li><?php echo $html->link('How do I Return Items?','/pages/view/how-to-return-products',array('escape'=>false));?></li>
		<?php
		$seller_id = $this->Session->read('User.seller_id');
		if(empty($seller_id)) { ?>
		<li>
			<?php echo $html->link('Becoming a Seller','/sellers/choiceful-marketplace-sign-up',array('escape'=>false));?></li>
		<?php }?>
		<li><?php echo $html->link('What is Make me an Offer&trade;','/pages/view/how-to-make-an-offer',array('escape'=>false));?></li>
		</ul>
	</div>
</div>
<!--Self Services Closed-->