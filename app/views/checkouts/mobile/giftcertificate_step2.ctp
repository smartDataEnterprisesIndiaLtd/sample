<?php echo $javascript->link(array('jquery-1.3.2.min','lib/prototype'),false);?>
<!--Content Start-->
<style type="text/css">
.dimmer{
	position:absolute;
	left:45%;
	top:55%;
}
.payment-options li {
	padding-right:6px;
}
</style>
<!--Main Content Starts--->
<section class="maincont nopadd">
<section class="prdctboxdetal margin-top">
	<h4 class="diff-blu">Checkout Choiceful: Swift, Simple & Secure</h4>
	<h4 class="orng-clr"><span class="gray-color">Step 2 of 3</span> Review Order</h4>
	<?php
	if ($session->check('Message.flash')){ ?>
		<div  class="messageBlock">
			<?php echo $session->flash();?>
		</div>
	<?php } ?>
	<p class="lgtgray applprdct">Please review your order below.</p>
	<ul class="revwitms">
		<li>
			<h4 class="orng-clr">Your Choiceful.com Order Summary</h4>
		</li>
		<li class="toppadd">
			<?php echo $html->image('mobile/review_item_arrow_down.png',  array( 'alt'=>'', 'class'=>'rvwarrow') );?>
			<label>Gift certificates:</label>
				<span>
					<?php echo CURRENCY_SYMBOL.$format->money($total_amount_b4tax,2);?>
				</span>
		</li>
		<li>
			<?php echo $html->image('mobile/review_item_arrow_down.png',  array( 'alt'=>'', 'class'=>'rvwarrow') );?>
			<label>Delivery:</label>
			<span><?php echo CURRENCY_SYMBOL.'0.00';?></span>
		</li>
		<li class="undrlnfrttl">
			<span></span>
		</li>
		<li>
			
			<?php echo $html->image('mobile/review_item_arrow_down.png',  array( 'alt'=>'', 'class'=>'rvwarrow') );?>
			<label>Total before tax:</label>
			<span><?php echo CURRENCY_SYMBOL.$format->money($total_amount_b4tax,2);?></span>
		</li>
		<li>
			<?php echo $html->image('mobile/review_item_arrow_down.png',  array( 'alt'=>'', 'class'=>'rvwarrow') );?>
			<label>Tax:</label>
			<span><?php echo CURRENCY_SYMBOL.$format->money($total_tax,2);?></span>
		</li>
		<li class="totalreviwttl">
			<?php echo $html->image('mobile/review_item_arrow_down.png',  array( 'alt'=>'', 'class'=>'rvwarrow') );?>
			<label>Total:</label>
			<span><?php echo CURRENCY_SYMBOL.$format->money($total_amount,2);?></span>
		</li>
	</ul>
	<!---->
	
	<!--Checkout info Start-->
	<ul class="checkout_info">
	<li>
	<h4 class="orng-clr">Your Gift Certificates</h4>
	<p>Your order will be dispatched to:</p>
	<div class="row padding0">
		<div class="arrow_div"><?php echo $html->image('mobile/yr_prdcts_grayarrow.png',  array( 'alt'=>'', 'class'=>'myprdctgft') );?></div>
		<?php if(!empty($total_order)){
			foreach($total_order as $order){ ?>
			
			<div class="chk_info">
			<p><strong><?php echo $order['touser'];?></strong></p>
			<p>	<strong>Amount:</strong> 
				<span class="orange-col"> 
					<strong>
						<?php echo CURRENCY_SYMBOL.$order['amount'];?>
					</strong>
				</span> 
				<strong>Quantity:</strong>
				<span class="rd_clr"> 
					<strong><?php echo $order['quantity'];?></strong>
				</span>
			</p>
			<?php if(!empty($order['from']) || !empty($order['to'])) { ?>
				<?php if(!empty($order['to'])) { ?>
					<strong>To:</strong> 
						<span class="gray-color">
							<?php  if(!empty($order['to'])) echo $order['to'];?>
						</span>
				<?php }?>
				<?php if(!empty($order['from'])) { ?>
					<strong>From:</strong> 
					<span class="gray-color">
						<?php if(!empty($order['from'])) echo $order['from'];?>
					</span>
				<?php }?>
			</p>
			<?php }?>
			
			<p class="font11 gray-color"><?php if(!empty($order['message'])) echo $order['message'];?><!--Thanks for the great time we had, this is from all the family! once...See you next year! Lucy--></p>
			<p class="green-color font11 margin-top">Your gift certificates will be sent by email to the recipient.</p>
			</div>
			
		<?php } } ?>
		</div>
	</li>
	
	<div id="plsLoaderID" style="display:none" class="dimmer">
		<?php //echo $html->image("loading.gif" ,array('alt'=>"Loading" ));?>
	</div>
	
	<li id="updateaddchange">
		<?php echo $this->element('mobile/checkout/billing_address');?>
	</li>
	
	<!-- Start Form-->
	<?php echo $form->create('Checkout',array('action'=>'giftcertificate_step3','method'=>'POST','name'=>'frmCheckout','id'=>'frmCheckout'));?>
	<li class="brdr-none"><h4 class="orng-clr">Choose your payment method</h4>
		<div class="row padding5 pmnt_method">
		
			<?php $options=array(
				'Credit/Debit Card'=>'&nbsp;'.$html->image("checkout/visa-logo.png" ,array('alt'=>"Loading",'height'=>22,'width'=>33,"onclick"=>"document.getElementById('CheckoutPaymenthodMethodCredit/debitCard').checked=true")).' '.$html->image("checkout/mastercard-logo.png" ,array('alt'=>"Loading",'height'=>22,'width'=>33,"onclick"=>"document.getElementById('CheckoutPaymenthodMethodCredit/debitCard').checked=true")).' '.$html->image("checkout/switch-card.png" ,array('alt'=>"Loading",'height'=>22,'width'=>33,"onclick"=>"document.getElementById('CheckoutPaymenthodMethodCredit/debitCard').checked=true")).' '.$html->image("checkout/delta-card.png" ,array('alt'=>"Loading",'height'=>22,'width'=>33,"onclick"=>"document.getElementById('CheckoutPaymenthodMethodCredit/debitCard').checked=true")).' '.$html->image("checkout/visa-electron-logo.png" ,array('alt'=>"Loading",'height'=>22,'width'=>33,"onclick"=>"document.getElementById('CheckoutPaymenthodMethodCredit/debitCard').checked=true")).' '.$html->image("checkout/master-card-logo.png" ,array('alt'=>"Loading",'height'=>22,'width'=>33,"onclick"=>"document.getElementById('CheckoutPaymenthodMethodCredit/debitCard').checked=true")).' </p> <p>',
				
				'paypal_checkout'=>'&nbsp;'.$html->image("checkout/checkout-with-paypal.png" ,array('alt'=>"Loading","onclick"=>"document.getElementById('CheckoutPaymenthodMethodPaypalCheckout').checked=true")).'</p> <p>',
				
				/*'google_checkout'=>'&nbsp;'.$html->image("checkout/google-checkout-method.png",array('alt'=>''))*/);
				
				$attributes=array('legend'=>false,'label'=>false, 'class'=>'radio',);?>
				
				<p> 
					<?php echo $form->radio('Checkout.paymenthod_method',$options,$attributes);?> 
				</p>
				<p class="btn_sec">
					<?php echo $form->button('Continue',array('type'=>'sumbit','class'=>'signinbtnwhyt cntnuchkot','div'=>false));?>
				</p>
			<!--<p>
				
				<input name="" type="radio" value="" class="radio" /> 
				<img src="images/visa-logo.png" width="33" height="22" alt="" /> <img src="images/master-card-logo.png" width="33" height="22" alt="" /><img src="images/switch-logo.png" width="33" height="22" alt="" /><img src="images/delta-logo.png" width="33" height="22" alt="" /><img src="images/visa-electron-logo.png" width="33" height="22" alt="" /><img src="images/mastro-logo.png" width="33" height="22" alt="" />
			</p>
			
			<p><input name="" type="radio" value="" class="radio" /> <img src="images/paypal-checkout.png" width="144" height="38" alt="" /></p>
			<p><input name="" type="radio" value="" class="radio" /> <img src="images/google-checkout.png" width="170" height="26" alt="" /></p>
			<p class="btn_sec"><input type="button" value="Continue" class="signinbtnwhyt cntnuchkot"></p>-->
		
		</div>
	</li>
	<?php echo $form->end();?>
	<!-- End form-->
	
	</ul>
	<!--Checkout info Closed-->
	
</section>
</section>
<!--Main Content End--->
<!--Navigation Starts-->
<nav class="nav">
	<ul class="maincategory yellowlist">
		<?php echo $this->element('mobile/nav_footer');?>
	</ul>
</nav>              
<!--Navigation End-->
 <!--Content Closed-->
<?php
if(!empty($errors)){ ?>
<script type="text/javascript">
	jQuery('#linkId').click();
</script>
<?php 
}
?>