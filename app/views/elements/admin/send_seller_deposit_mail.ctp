<?php
	echo $form->create('Seller',array('action'=>'send_seller_deposit_mail','method'=>'POST','name'=>'frmDeposit','id'=>'frmDeposit'));
?>
<!--Tabs Content Start-->
	<div class="tabs-content">
	<?php if ($session->check('Message.flash')){ ?>
		<div  class="messageBlock"><?php echo $session->flash();?></div>
	<?php } ?>
		<!--Enter your bank account settings Start-->
		<div class="account-setting">
			
				<!--Gray Back heading Start-->
				<div class="gray-bg-heading">
					<ul>
						<li class="head"><strong>Enter the bank deposit amount:</strong></li>
					</ul>
				</div>
				<!--Gray Back heading Closed-->
				<!--Account Setting Fields Start-->
				<div class="account-setting-fields">
					
					<!--Account Setting Fields Rows Start-->
					<ul class="account-setting-fields-rows">
						
						<li>
							<div class="account-setting-fields-label larger-label-width">Amount :</div>
							<div class="account-setting-fields-field"><?php echo CURRENCY_SYMBOL." ".$form->input('SellerPayment.amount',array('size'=>'20','maxlength'=>'20','class'=>'textfield-input small-width','label'=>false,'div'=>false));?></div>
						</li>
							
						
					</ul>
					<!--Account Setting Fields Rows Closed-->
				</div>
				<!--Account Setting Fields Closed-->
				
		</div>
		<!--Enter your bank account settings Closed-->
		
		<p class="margin-top">
			<?php echo $form->hidden('SellerPayment.seller_id',array('size'=>'20','maxlength'=>'20','class'=>'textfield-input small-width','label'=>false,'div'=>false));?>
			<?php echo $form->button('Submit',array('type'=>'submit','class'=>'blk-bg-input','div'=>false));?>
			<!--<input type="submit" name="button2" class="blk-bg-input" value="Submit" />-->
		</p>
	</div>
	<!--Tabs Content Closed-->
<?php echo $form->end();?>