<?php
echo $form->create('Seller',array('action'=>'payment_settings','method'=>'POST','name'=>'frmPayment','id'=>'frmPayment'));?>
<!--Tabs Content Start-->
	<div class="tabs-content">
		<?php if ($session->check('Message.flash')){ ?>
			<div  class="messageBlock"><?php echo $session->flash();?></div>
		<?php } ?>
		<!--Your Bank Account Details Start-->
		<div class="payment-setting-fields">
			<div class="account-setting">
	
				<!--Gray Back heading Start-->
				<div class="gray-bg-heading">
					<ul>
						<li class="head"><strong>Your Bank Account Details</strong></li>
					</ul>
				</div>
				<!--Gray Back heading Closed-->
			
				<!--Account Setting Fields Start-->
				<div class="account-setting-fields">
					<!--Account Setting Fields Rows Start-->
					<ul class="account-setting-fields-rows">
						<li>
							<div class="account-setting-fields-label larger-label-width">Bank Account Holder Name:</div>
							<div class="account-setting-fields-field">
							<?php
							if(!empty($this->data['Seller']['account_holder_name']) ){
								echo ucwords($this->data['Seller']['account_holder_name']);
							}else{
								echo ucwords($userData['User']['firstname']." ".$userData['User']['lastname']) ;
							}
							?></div>
						</li>
						<li>
							<div class="account-setting-fields-label larger-label-width">Bank Account Number:</div>
							<div class="account-setting-fields-field">
								
							<?php
							if(!empty($this->data['Seller']['bank_account_number']) ){
								echo ucwords($this->data['Seller']['bank_account_number']);
							}else{
								echo ucwords($this->data['Seller']['paypal_account_mail']);
							}
							?>
							<span class="pad-right"></span> <strong>Account Details:</strong> <span class="green-color"><strong>Verified</strong></span></div>
						</li>
					
					</ul>
					<!--Account Setting Fields Rows Closed-->
				
				</div>
				<!--Account Setting Fields Closed-->
			</div>
			<p class="smalr-fnt margin-top">Please note you cannot change your account details once verified. In order to change your bank account details please contact us.</p>
			
		</div>
		<!--Your Bank Account Details Closed-->
		<?php if(is_array($seller_payment_info) && count($seller_payment_info) > 0) { ?>
		<!--Your Bank Account Details Start-->
		<div class="payment-setting-fields">
			<div class="account-setting">
	
				<!--Gray Back heading Start-->
				<div class="gray-bg-heading">
					<ul>
						<li class="head"><strong>Payment transfers</strong></li>
						<li class="head-top-row">
							<div class="account-setting-fields-head-text larger-head-label-width">Date</div>
							<div class="account-setting-fields-head-text"><strong>Account</strong></div>
							<div class="account-setting-fields-head-right-text larger-headr-label-width"><strong>Download</strong></div>
						</li>
					</ul>
				</div>
				<!--Gray Back heading Closed-->
				<?php
				foreach($seller_payment_info as $payment_info){
				?>
					<!--Account Setting Fields Start-->
					<div class="account-setting-fields">
						<!--Account Setting Fields Rows Start-->
						<ul class="account-setting-fields-rows">
							<li>
								<div class="account-setting-fields-field larger-head-label-width first"><strong><?php echo date(DATE_FORMAT, strtotime($payment_info['PaymentReport']['created']));?></strong></div>
								<div class="account-setting-fields-field"><?php echo $payment_info['PaymentReport']['account_info'];?></div>
								<div class="account-setting-fields-field-right larger-headr-label-width"><?php echo $html->link('Report','/sellers/download_paymentreport_files/'.$payment_info['PaymentReport']['report_name'],array('escape'=>false,'class'=>'underline-link'));?></div>
							</li>
						</ul>
						<!--Account Setting Fields Rows Closed-->
					
					</div>
					<!--Account Setting Fields Closed-->
				<?php }?>
			</div>
		</div>
		<!--Your Bank Account Details Closed-->
		<?php }?>
	</div>
	<!--Tabs Content Closed-->
<?php echo $form->end();?>