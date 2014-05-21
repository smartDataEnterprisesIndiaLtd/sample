<?php
echo $javascript->link('functions');
if(!empty($errors)){
	$error_meaasge="Please add some information in the mandatory fields highlighted red below.";
?>
<div class="error_msg_box"> 
	<?php echo $error_meaasge;?>
</div>
<?php }
echo $form->create('Seller',array('action'=>'deposit','method'=>'POST','name'=>'frmDeposit','id'=>'frmDeposit'));?>
 <!--Tabs Content Start-->
<div class="tabs-content">
	<?php if ($session->check('Message.flash')){ ?>
		<div  class="messageBlock"><?php echo $session->flash();?></div>
	<?php } ?>
	<!--Customer Service Contact Information Start-->
	<div class="payment-setting-fields">
	<p class="pad-btm">Thank you for submitting your bank account information. In order to verify your account we have sent you to 2 deposit payments. Once these have arrived into your account you will need to enter them below. Please note it may take up to 5-7 business days for the funds to arrive into your account. Please enter the 3-digit amount including the decimal point below, e.g.0.05.</p>
	<div class="account-setting">
		<!--Gray Back heading Start-->
		<div class="gray-bg-heading">
			<ul>
				<li class="head"><strong>Enter the deposit amounts below in order to verify your account</strong></li>
			</ul>
		</div>
		<!--Gray Back heading Closed-->
		
		<!--Account Setting Fields Start-->
		<div class="account-setting-fields">
		
			<!--Account Setting Fields Rows Start-->
			<ul class="account-setting-fields-rows">
				<li>
					<div class="account-setting-fields-label larger-label-width">Deposit 1</div>
					<div class="account-setting-fields-field">
					<?php
					if(!empty($errors['deposit_1'])){
						$errorDeposit1='textfield-input v-smal-width error_message_box';
					}else{
						$errorDeposit1='textfield-input v-smal-width';
					}
					?>
						<?php echo $form->input('Seller.deposit_1',array('size'=>'3','maxlength'=>'11','class'=>$errorDeposit1, 'error'=>false,'label'=>false,'div'=>false,'onChange'=>'fixPriceDecimals(this.id,this.value)'));?>
					</div>
				</li>
				<li>
					<div class="account-setting-fields-label larger-label-width">Deposit 2</div>
					<div class="account-setting-fields-field">
						<?php
					if(!empty($errors['deposit_2'])){
						$errorDeposit2='textfield-input v-smal-width error_message_box';
					}else{
						$errorDeposit2='textfield-input v-smal-width';
					}
					?>
					<?php echo $form->input('Seller.deposit_2',array('size'=>'3','maxlength'=>'11','class'=>$errorDeposit2,'label'=>false,'error'=>false,'div'=>false,'onChange'=>'fixPriceDecimals(this.id,this.value)'));?> 
					</div>
				</li>
			
			</ul>
			<!--Account Setting Fields Rows Closed-->
		
		</div>
		<!--Account Setting Fields Closed-->
		</div>
		
	</div>
	<!--Customer Service Contact Information Closed-->
	
	<p class="margin-top">
		<input type="submit" name="button2" class="blk-bg-input" value="Save" />
	</p>
	
</div>
<!--Tabs Content Closed-->
<?php echo $form->end();?>