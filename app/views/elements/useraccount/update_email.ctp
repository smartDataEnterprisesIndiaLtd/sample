<?php 
	if ($session->check('Message.flash')){ ?>
		<div><div class="messageBlock" style="margin:0px"><?php echo $session->flash();?></div></div>
	<?php }
?>


<?php echo $form->create('User',array('action'=>'update_email','method'=>'POST','name'=>'frmEvent','id'=>'frmEvent'));?>
<?php			 if(!empty($errors['email'])){
				//$error_meaasge="Please add some information in the mandatory fields highlighted red below.";
				$error_meaasge = $errors['email'];
			?>
			<div class="error_msg_box"> 
				<?php echo $error_meaasge;?>
			</div>
		<?php }
		 if(!empty($errors['email'])){
					$erroremail ='form-textfield error_message_box';
				}else{
					$erroremail ='form-textfield';
				}?>

<li>
	<label style="width:110px">Email Address:</label>
	<div class="form-field-widget">
		<?php echo $form->input('User.email',array('size'=>'30','class'=>$erroremail,'label'=>false,'maxlength'=>'50','div'=>false,'error'=>false));?>
	</div>
</li>
<li>
	<label style="width:110px"> </label>
	<div class="form-field-widget">
		<?php $options=array(
			"url"=>"/users/update_email","before"=>"",
			"update"=>"email",
			"indicator"=>"plsLoaderID",
			'loading'=>"showloading()",
			"complete"=>"hideloading()",
			"class" =>"gray-button",
			"type"=>"Submit",
			"id"=>"myEmail",
		);?>
		<span class="gray-btn-widget">
		<?php echo $ajax->submit('Change Email',$options);?></span>
	</div>
</li>
<?php echo $form->end();?>
