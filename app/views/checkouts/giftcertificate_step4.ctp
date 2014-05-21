<?php echo $javascript->link(array('jquery-1.3.2.min','lib/prototype'),false);


?>
<!--Content Start-->
<div id="checkout-content">
	<!--Left Content Start-->
	<?php echo $this->element('checkout/left');?>
	<!--Left Content Closed-->
	<!--Right Content Start-->
	<div class="right-con">&nbsp;</div>
         <!--Right Content Start-->
         <div class="checkout-right-content1">
         
         	<!--Form Left Widget Start-->
          		 <div class="form-checkout-widget1">
			<!--Top Content Start-->
			<div class="inner-content">
				<?php
				if ($session->check('Message.flash')){ ?>
					<div  class="messageBlock">
						<?php echo $session->flash();?>
					</div>
				<?php } ?>
				<h2 class="bl-diffrnt pad-top-bottom25 border-btm-blue">Your order has been submitted successfully!</h2>
				<div class="order-number-widget">Your order number is: 
					<?php $order_is = $this->Session->read('giftcertificate_orderId'); if(!empty($order_is)) echo $order_is?>
					<span class="line-break">Your Transaction ID is: <?php  if(!empty($trans_is)) echo $trans_is; ?></span>
				</div>
				<p class="margin-top"><strong>Thank you for your order.</strong><br/>
					We will send you an e-mail confirmation shortly.</p>
				<p>Subject to final authorization for your credit your gift certificate will be delivered to email address below.</p>
				<p class="smalr-fnt"><strong>Please note:</strong> If you wish to edit your order please contact us. You will find our contact details in open orders section of your account.</p>
			</div>
			<!--Top Content Closed-->
			<!--Dispatched Order Start-->
			<div class="dispatched-order border">
				<h5 class="bl-background-head smalr-fnt">Your order will be dispatched to the following address:</h5>
				<!--Row Start-->
				<div class="padding-row overflow-h">
					<!--Left Start-->
					<div class="left-address-widget">
						<?php //$total_order = $this->Session->read('Giftcheckout');
							
						foreach($users as $user){
						
						?>
						<ul>
							<li class="left-icon"><?php echo $html->image("checkout/d-arrow-icon-red.png" ,array('width'=>"7",'height'=>"7", 'alt'=>"" )); ?></li>
							<li style="float:none">
								<p><?php echo $user;?></p>
							</li>
						</ul>
						<?php }?>
					</div>
					<!--Left Closed-->
					<!--Right Start-->
					<div class="right-links-widget">
						<ul class="lt-arrow-links">
							<li><?php //echo $html->link("Track the status of this order",'#',array('escape'=>false));?></li>
							<li><?php echo $html->link("Click here to return to homepage",'/',array('escape'=>false));?></li>
							<li><?php //echo $html->link("Print business VAT invoice",'#',array('escape'=>false));?></li>
						</ul>
					</div>
					<!--Right Closed-->
				</div>
				<!--Row Closed-->
			</div>
			<!--Dispatched Order Closed-->
		</div>
	</div>
	<!--Right Content Closed-->
</div>
<!--Content Closed-->
<?php $this->Session->delete('giftcertificate_orderId'); $this->Session->delete('giftcertificate_tranx_id'); ?>