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
.form-widget label {
    display: inline;
    float: none;
    padding: 0 0 0 0;
}
</style>
<div id="checkout-content">
	<!--Left Content Start-->
	<?php echo $this->element('checkout/left');?>
	<!--Left Content Closed-->
	 <div class="right-con">&nbsp;</div>
         <!--Right Content Start-->
         <div class="checkout-right-content1">
         
         	<!--Form Left Widget Start-->
           <div class="form-checkout-widget1">
			<!--Form Widget Start-->
			<div class="form-widget">
				<ul>
					<li>
						<?php
						if ($session->check('Message.flash')){ ?>
							<div  class="messageBlock">
								<?php echo $session->flash();?>
							</div>
						<?php } ?>
					</li>
					<?php
					if(!empty($errors)){
						$error_meaasge="Please add some information in the mandatory fields highlighted red below.";
					?>
						<div class="error_msg_box"> 
							<?php echo $error_meaasge;?>
						</div>
					<?php }?>
					<li>
           	  				<div style="border: medium none ;" class="checkout-pro-widget">
							<!--Left Start-->
							<div class="edit-info-left">
								<p class="smalr-fnt margin-bottom">Please review your order and make any changes before processing through for payment. <strong>Please review all options below:</strong></p>
								<!--Options Start-->
								<ul class="options">
									<li>
										<p class="smalr-fnt"><strong>Your order is being dispatched to:</strong></p>
									</li>
									<?php if(!empty($total_order)){
										foreach($total_order as $order){ ?>
									<li>
										<div class="arrow-sec"><?php echo $html->image("checkout/lt-blue-arrow.png" ,array('alt'=>"Loading",'height'=>9,'width'=>5));?></div>
										<div class="billing-add line-hight18">
											<p><strong><?php echo $order['touser'];?></strong></p>
											<p><strong>Amount:</strong> <span class="choiceful"><strong><?php echo CURRENCY_SYMBOL.$order['amount'];?></strong></span> <strong>Quantity:</strong> <span class="red-color"><strong><?php echo $order['quantity'];?></strong></span></p>
											<?php if(!empty($order['from']) || !empty($order['to'])) { ?>
											<p><?php if(!empty($order['to'])) { ?><strong>To:</strong> <span class="gray"><?php  if(!empty($order['to'])) echo $order['to'];?></span><?php }?> <?php if(!empty($order['from'])) { ?><strong>From:</strong> <span class="gray"><?php if(!empty($order['from'])) echo $order['from'];?></span><?php }?></p>
											<?php }?>
											<p class="smalr-fnt gray line-hight-normal"><?php  if(!empty($order['message'])) echo $this->Common->currencyEnter($order['message']);?></p>
										</div>
									</li>
									<?php } } ?>
								</ul>
								<div id="updateaddchange"><?php echo $this->element('checkout/change_address');?></div>
								<!--Options Closed-->
							</div>
							<!--Left Closed-->
							<!--Right Start-->
							<div class="edit-info-right">
								<!--Total Widget Start-->
								<div id="plsLoaderID" style="display:none" class="dimmer">
									<?php echo $html->image("loading.gif" ,array('alt'=>"Loading" ));?>
								</div>
								<div class="side-content">
									<div class="border">
										<h5 class="gr-fade-head text-align-center smalr-fnt">Choiceful.com Order Summary</h5>
										<!--Calculation Start-->
										<ul class="calculate margin-top">
											<li>
												<div class="d-arrow"><?php echo $html->image("checkout/d-arrow-icon.png" ,array('alt'=>"Loading",'height'=>7,'width'=>7));?></div>
												<div class="summary-text"><strong>Gift certificates:</strong></div>
												<div class="summary-value">£<?php echo $format->money($total_amount_b4tax,2);?></div>
											</li>
											<li>
												<div class="d-arrow"><?php echo $html->image("checkout/d-arrow-icon.png" ,array('alt'=>"Loading",'height'=>7,'width'=>7));?></div>
												<div class="summary-text"><strong>Delivery:</strong></div>
												<div class="summary-value">£0.00</div>
											</li>
											<li class="margin-top">
												<div class="d-arrow"></div>
												<div class="summary-text"><strong>Total before VAT:</strong></div>
												<div class="summary-value">£<?php echo $format->money($total_amount_b4tax,2);?></div>
											</li>
											<li>
												<div class="d-arrow"></div>
												<div class="summary-text"><strong>Tax:</strong></div>
												<div class="summary-value">£<?php echo $format->money($total_tax,2);?></div>
											</li>
											<li class="total-widget">
												<div class="d-arrow"><?php echo $html->image("checkout/d-arrow-icon-red.png" ,array('alt'=>"Loading",'height'=>7,'width'=>7));?></div>
												<div class="summary-text"><strong>TOTAL:</strong></div>
												<div class="summary-value"><strong>£<?php echo $format->money($total_amount,2);?></strong></div>
											</li>
											<li class="padding-row" id="billing_address">
												<?php echo $this->element('checkout/billing_address')?>
											</p>
											</li>
										</ul>
										<!--Calculation Closed-->
									</div>
								</div>
								<!--Total Widget Closed-->
							</div>
							<!--Right Closed-->
						</div>
					</li>
					<?php echo $form->create('Checkout',array('action'=>'giftcertificate_step3','method'=>'POST','name'=>'frmCheckout','id'=>'frmCheckout'));?>
					<li>
						<div class="checkout-pro-widget">
							<h2 class="gray lrgr-fnt">Select a payment Method</h2>
							<p class="margin-top"><strong>How would you like to pay for yoour order?</strong></p>
							<!--Payment Options Start-->
							<div class="payment-options">
								<ul>
									<li>
									<?php
										/*$options=array(
										'Sage'=>'&nbsp;'.$html->image("checkout/visa-logo.png" ,array('alt'=>"Loading",'height'=>23,'width'=>33)).' '.$html->image("checkout/mastercard-logo.png" ,array('alt'=>"Loading",'height'=>23,'width'=>33)).' '.$html->image("checkout/switch-card.png" ,array('alt'=>"Loading",'height'=>23,'width'=>33)).' '.$html->image("checkout/delta-card.png" ,array('alt'=>"Loading",'height'=>23,'width'=>33)).' '.$html->image("checkout/visa-electron-logo.png" ,array('alt'=>"Loading",'height'=>23,'width'=>33)).' '.$html->image("checkout/master-card-logo.png" ,array('alt'=>"Loading",'height'=>23,'width'=>33)).' </li> <li>',
										'paypal_checkout'=>'&nbsp;'.$html->image("checkout/checkout-with-paypal.png" ,array('alt'=>"Loading")).'</li> <li>',
										'google_checkout'=>'&nbsp;'.$html->image("checkout/google-checkout-method.png",array('alt'=>'')));
										$attributes=array('legend'=>false,'label'=>true);
										echo $form->radio('Checkout.paymenthod_method',$options,$attributes);*/
										
										$options=array(
										'Credit/Debit Card'=>'&nbsp;'.$html->image("checkout/visa-logo.png" ,array('alt'=>"Loading",'height'=>23,'width'=>33)).' '.$html->image("checkout/mastercard-logo.png" ,array('alt'=>"Loading",'height'=>23,'width'=>33)).' '.$html->image("checkout/switch-card.png" ,array('alt'=>"Loading",'height'=>23,'width'=>33)).' '.$html->image("checkout/delta-card.png" ,array('alt'=>"Loading",'height'=>23,'width'=>33)).' '.$html->image("checkout/visa-electron-logo.png" ,array('alt'=>"Loading",'height'=>23,'width'=>33)).' '.$html->image("checkout/master-card-logo.png" ,array('alt'=>"Loading",'height'=>23,'width'=>33)).' </li> <li>',
										'paypal_checkout'=>'&nbsp;'.$html->image("checkout/checkout-with-paypal.png" ,array('alt'=>"Loading")));
										//'google_checkout'=>'&nbsp;'.$html->image("checkout/google-checkout-method.png",array('alt'=>'')));
										$attributes=array('legend'=>false,'label'=>true);
										echo $form->radio('Checkout.paymenthod_method',$options,$attributes); 
										
									?>
									</li>
								</ul>
								<div class="clear"></div>
							</div>
							<!--Payment Options Closed-->
						</div>
					</li>
					<li>
						<div class="checkout-pro-widget">
							<div class="float-left">
								<?php echo $html->link($html->image("checkout/back-btn.gif" ,array('alt'=>"",'div'=>false )),'/certificates/purchase_gift',array('escape'=>false,'alt'=>''));?>
							</div>
							<div class="float-right pad-none">
								<?php echo $form->submit('',array('src'=>SITE_URL.'/img/checkout/continue-checkout-btn.png','type'=>'image','class'=>'','div'=>false));?>
							</div>
						</div>
					</li>
					<?php echo $form->end();?>
				</ul>
			</div>
			<!--Form Widget Closed-->
		</div>
		<!--Form Left Widget Closed-->
		</div>
	</div>
	<!--Right Content Closed-->
</div>
<!--Content Closed-->
<?php
if(!empty($errors)){ ?>
<script type="text/javascript">
	jQuery('#linkId').click();
</script>
<?php 
}
?>