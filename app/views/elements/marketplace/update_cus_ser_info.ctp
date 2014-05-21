<?php
if ($session->check('Message.flash')){ ?>
	<div class="messageBlock"><?php echo $session->flash();?></div>
<?php }
if(!empty($errors)){
		$error_meaasge="Please add some information in the mandatory fields highlighted red below.";
		if($errors['service_email']=='This email is already in use please try again with another email'){
				$error_meaasge=$errors['service_email'];
		}
	?>
	<div class="error_msg_box"> 
		<?php echo $error_meaasge;?>
	</div>
<?php }
echo $form->create('Seller',array('action'=>'update_customer_info','method'=>'POST','name'=>'frmSeller2','id'=>'frmSeller2'));?>
<div class="account-setting">
	<!--Gray Back heading Start-->
	<div class="gray-bg-heading">
		<ul>
			<li class="head"><strong>Customer Service Contact Information</strong></li>
			<li class="closed-link">
				<?php $options=array(
					"url"=>"/sellers/update_customer_info","before"=>"",
					"update"=>"cus-info",
					"indicator"=>"plsLoaderID",
					'loading'=>"showloading()",
					"complete"=>"hideloading()",
					"class" =>"btn_blk-bg-link",
					"style" =>"cursor: pointer",
					"type"=>"Submit",
					"id"=>"testid",
					"div"=>false
				); echo $ajax->submit('Submit',$options);?>
			</li>
		</ul>
	</div>
	<!--Gray Back heading Closed-->
	<!--Account Setting Fields Start-->
	<div class="account-setting-fields">
		<!--Account Setting Fields Rows Start-->
		<ul class="account-setting-fields-rows">
			<li>
				<div class="account-setting-fields-label"><label><span class="star">*</span>Customer Service Email:</label></div>
				<div class="account-setting-fields-field"><div>
					<?php
						if(!empty($errors['phone'])){
							$errorPhone='form-textfield error_message_box';
						}else{
							$errorPhone='form-textfield';
						}
					?>
					<?php echo $form->input('Seller.service_email',array('size'=>'30','class'=>$errorPhone,'maxlength'=>'30','label'=>false,'div'=>false,'error'=>false,'style'=>'padding-top:0px')); ?>
				</div></div>
			</li>
			<li>
				<div class="account-setting-fields-label"><label><span class="star">*</span>Contact Phone Number:</label></div>
				<div class="account-setting-fields-field">
					<?php
						if(!empty($errors['service_email'])){
							$errorEmail='form-textfield error_message_box';
						}else{
							$errorEmail='form-textfield';
						}
					?>
					<?php echo $form->input('Seller.phone',array('size'=>'30','class'=>$errorEmail,'maxlength'=>'30','label'=>false,'div'=>false,'error'=>false,'style'=>'padding-top:0px'));?>
					<?php echo $form->hidden('Seller.address_id',array('size'=>'30','class'=>'form-textfield','maxlength'=>'30','label'=>false,'div'=>false,'style'=>'padding-top:0px'));?>
					
			</div>
			</li>
		</ul>
		<!--Account Setting Fields Rows Closed-->
	</div>
	<!--Account Setting Fields Closed-->
</div>
<?php echo $form->end();?>