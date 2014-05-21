<?php
echo $form->create('Seller',array('action'=>'payment_settings','method'=>'POST','name'=>'frmPayment','id'=>'frmPayment'));?>
<!--Tabs Content Start-->
<style>
.form-error {
    margin-right: 5px;
    float: none;
}
</style>
<script>
 jQuery(document).ready(function () {
    jQuery('input[type=text]').bind('copy paste', function (e) { 
	e.preventDefault();
    });
 });
</script>
	<div class="tabs-content">
	<?php if ($session->check('Message.flash')){ ?>
		<div  class="messageBlock"><?php echo $session->flash();?></div>
	<?php } ?>
		<!--Enter your bank account settings Start-->
		<div class="payment-setting-fields">
			<p class="pad-btm">This is the bank accounts to which your funds earned selling on Choiceful.com will be disbursed. Your bank account may be a business or a personal account.</p>
			<?php
		if(!empty($errors)){	
				$error_meaasge="Please add some information in the mandatory fields highlighted red below.";
				if($errors['paypal_account_mail']=='Please enter either bank account details or Paypal account details'){
				    $error_meaasge = $errors['paypal_account_mail'];
				}
			?>
			<div class="error_msg_box" style="overflow: hidden;"> 
				<?php echo $error_meaasge;?>
			</div>
		<?php }?>
			<div class="account-setting">
			
				<!--Gray Back heading Start-->
				<div class="gray-bg-heading">
					<ul>
						<li class="head"><strong>Enter your bank account settings</strong></li>
					</ul>
				</div>
				<!--Gray Back heading Closed-->
				<!--Account Setting Fields Start-->
				<div class="account-setting-fields">
					
					<!--Account Setting Fields Rows Start-->
					<ul class="account-setting-fields-rows">
					    <?php
					    if(!empty($errors['sortcode1']) || !empty($errors['sortcode2']) || !empty($errors['sortcode3'])){
						$errorsSortCode ='textfield-input v-smal-width error_message_box';
				            }else{
						$errorsSortCode ='textfield-input v-smal-width';
					    } ?>
					<li>
						<div class="account-setting-fields-label larger-label-width">Bank Sort Code:</div>
							<div class="account-setting-fields-field">
								<?php echo $form->input('Seller.sortcode1',array('size'=>'3','maxlength'=>'4','class'=>$errorsSortCode,'label'=>false,'div'=>false, 'error'=>false));?> - <?php echo $form->input('Seller.sortcode2',array('size'=>'3','maxlength'=>'4','class'=>$errorsSortCode,'label'=>false,'div'=>false, 'error'=>false));?> - <?php echo $form->input('Seller.sortcode3',array('size'=>'3','maxlength'=>'4','class'=>$errorsSortCode,'label'=>false,'div'=>false, 'error'=>false));?>
						</div>
					</li>
					<?php
					if(!empty($errors['bank_ac_number'])){
					    $errorsBankAcNumber ='textfield-input small-width error_message_box';
					}else{
					    $errorsBankAcNumber ='textfield-input small-width';
					} ?>
					<li>
						<div class="account-setting-fields-label larger-label-width">Bank Account Number:</div>
						<div class="account-setting-fields-field"><?php echo $form->input('Seller.bank_ac_number',array('maxlength'=>'20','class'=>$errorsBankAcNumber,'label'=>false,'div'=>false, 'error'=>false));?></div>
					</li>
					<?php
					if(!empty($errors['retype_bank_account_number'])){
					    $errorsRetypeBankAcNumber ='textfield-input small-width error_message_box';
					}else{
					    $errorsRetypeBankAcNumber ='textfield-input small-width';
					} ?>
					<li>
						<div class="account-setting-fields-label larger-label-width">Re-Type your Bank Account Number:</div>
							<div class="account-setting-fields-field"><?php echo $form->input('Seller.retype_bank_account_number',array('maxlength'=>'20','class'=>$errorsRetypeBankAcNumber,'label'=>false,'div'=>false,'error'=>false));?></div>
						</li>
					<?php
					if(!empty($errors['account_holder_name'])){
					    $errorsAccountHolderName ='textfield-input error_message_box';
					}else{
					    $errorsAccountHolderName ='textfield-input';
					} ?>
						<li>
						<div class="account-setting-fields-label larger-label-width"> Bank Account Holder Name:</div>
							<div class="account-setting-fields-field"><?php echo $form->input('Seller.account_holder_name',array('maxlength'=>'30','class'=>$errorsAccountHolderName,'label'=>false,'div'=>false, 'error'=>false));?></div>
						</li>
					</ul>
					<!--Account Setting Fields Rows Closed-->
				</div>
				<!--Account Setting Fields Closed-->
				
			</div>
			
		</div>
		<!--Enter your bank account settings Closed-->

		<!--Paypal Registered Account Start-->
		<div class="payment-setting-fields">
			<p class="pad-btm margin-tp">Or, alternatively receive funds into your PayPal account:</p>
			<div class="account-setting">
	
				<!--Gray Back heading Start-->
				<div class="gray-bg-heading">
					<ul>
						<li class="head"><strong>Paypal Registered Account</strong></li>
					</ul>
				</div>
				<!--Gray Back heading Closed-->
		
			<!--Account Setting Fields Start-->
				<div class="account-setting-fields">			
					<!--Account Setting Fields Rows Start-->
					<ul class="account-setting-fields-rows">
					    <?php
					if(!empty($errors['paypal_account_mail'])){
					    $errorsPaypalAccountMail ='textfield-input error_message_box';
					}else{
					    $errorsPaypalAccountMail ='textfield-input';
					} ?>
						<li>
						<div class="account-setting-fields-label larger-label-width">Email:</div>
						<div class="account-setting-fields-field"><?php echo $form->input('Seller.paypal_account_mail',array('maxlength'=>'30','class'=>$errorsPaypalAccountMail,'label'=>false,'div'=>false, 'error'=>false));?></div>
						</li>
						
					</ul>
					<!--Account Setting Fields Rows Closed-->
				
				</div>
			</div>
		<!--Account Setting Fields Closed-->
		
		</div>
		<!--Paypal Registered Account Closed-->
		
		<p class="margin-top">
			<?php echo $form->button('Submit',array('type'=>'submit','class'=>'blk-bg-input','div'=>false));?>
			<!--<input type="submit" name="button2" class="blk-bg-input" value="Submit" />-->
		</p>
	</div>
	<!--Tabs Content Closed-->
<?php echo $form->end();?>