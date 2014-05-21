<?php 
	if ($session->check('Message.flash')){ ?>
		<div><div class="messageBlock" style="margin:0px"><?php echo $session->flash();?></div></div>
	<?php }
?>
<?php echo $form->create('User',array('action'=>'update_password','method'=>'POST','name'=>'frmUser','id'=>'frmUser'));?>
<?php			 if(!empty($errors)){
				$error_meaasge="Please add some information in the mandatory fields highlighted red below.";
			?>
			<div class="error_msg_box"> 
				<?php echo $error_meaasge;?>
			</div>
		<?php }
		if(!empty($errors['oldpassword'])){
					$erroroldpassword ='form-textfield error_message_box';
				}else{
					$erroroldpassword = 'form-textfield';
				}
				if(!empty($errors['newpassword'])){
					$errornewpassword ='form-textfield error_message_box';
				}else{
					$errornewpassword = 'form-textfield';
				}
				if(!empty($errors['newchangeconfpassword'])){
					$errornewchangeconfpassword ='form-textfield error_message_box';
				}else{
					$errornewchangeconfpassword ='form-textfield';
				}?>
<li>
	<label style="width:110px">Old Password:</label>
	<div class="form-field-widget">
		<?php echo $form->input('User.oldpassword',array('type'=>'password','class'=>$erroroldpassword,'label'=>false,'div'=>false,'error'=>false));?>
	</div>
</li>
<li>
	<label style="width:110px">New Password:</label>
	<div class="form-field-widget">
		<?php echo $form->input('User.newpassword',array('type'=>'password','class'=>$errornewpassword,'label'=>false,'div'=>false,'error'=>false));?>
	</div>
</li>
<li>
	<label style="width:110px">Confirm Password:</label>
	<div class="form-field-widget">
		<?php echo $form->input('User.newchangeconfpassword',array('type'=>'password','class'=>$errornewchangeconfpassword,'label'=>false,'div'=>false,'error'=>false));?>
	</div>
</li>
<li>
	<label style="width:110px"> </label>
	<div class="form-field-widget">
		<?php $options=array(
			"url"=>"/users/update_password","before"=>"",
			"update"=>"changepassword",
			"indicator"=>"plsLoaderID",
			'loading'=>"showloading()",
			"complete"=>"hideloading()",
			"class" =>"gray-button",
			"type"=>"Submit",
			"id"=>"myPassword",
		);?>
		<span class="gray-btn-widget">
		<?php echo $ajax->submit('Change Password',$options);?></span>
	</div>
</li>
<?php echo $form->end();?>
<script>
	jQuery(document).ready(function(){
		jQuery("#UserOldpassword").focus();
		});
</script>