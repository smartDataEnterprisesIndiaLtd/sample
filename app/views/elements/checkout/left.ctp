<?php
//$controller_name = $this->params['controller'];
$action_name 	 = $this->params['action'];

?>
<div class="checkout-left-content" id="AddClassAdditional">
	<!--Checkout left ins Start-->
	<div class="side-content">
		<ul class="checkout-secure">
			<li class="secure-left"><?php echo $html->image("checkout/lock-icon.gif" ,array('width'=>"11",'height'=>"12", 'alt'=>"" )); ?></li>
			<li class="secure-right"><strong>Shopping with us is safe</strong>.<br />
			<span class="smalr-fnt">You can feel confident placing an order with Choiceful. We take every possible precaution to keep your data secure.<br />
			<a href="<?php echo SITE_URL;?>pages/view/our-safe-shopping-promise" target="_blank">Find out about privacy &amp; security</a>.</span></li>
		</ul>
	</div>
	<!--Checkout left ins Closed
	<p align="center">
	<?php echo $html->image("checkout/safe-blue-logo.png" ,array('width'=>"56",'height'=>"29", 'alt'=>"" )); ?>
	<?php echo $html->image("checkout/safe-green-logo.png" ,array('width'=>"55",'height'=>"29", 'alt'=>"" )); ?>
	</p>-->
</div>