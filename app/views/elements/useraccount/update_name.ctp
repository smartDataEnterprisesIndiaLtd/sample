<?php echo $form->create('User',array('action'=>'update_name','method'=>'POST','name'=>'frmEvent','id'=>'frmEvent'));?>
<?php			 if(!empty($errors)){
				$error_meaasge="Please add some information in the mandatory fields highlighted red below.";
			?>
			<div class="error_msg_box"> 
				<?php echo $error_meaasge;?>
			</div>
		<?php }
		 if(!empty($errors['firstname'])){
					$errorname ='form-textfield error_message_box';
				}else{
					$errorname ='form-textfield';
				}?>
<li>
	<label style="width:110px">Name:</label>
	<div class="form-field-widget">
		<?php echo $form->input('User.firstname',array('size'=>'30','class'=>$errorname,'maxlength'=>'30','label'=>false,'div'=>false,'error'=>false));?>
	</div>
</li>
<li>
	<label style="width:110px"> </label>
	<div class="form-field-widget">
		<?php $options=array(
			"url"=>"/users/update_name","before"=>"",
			"update"=>"name",
			"indicator"=>"plsLoaderID",
			'loading'=>"showloading()",
			"complete"=>"hideloading()",
			"class" =>"gray-button",
			"type"=>"Submit",
			"id"=>"myName",
		);?>
		<span class="gray-btn-widget">
		<?php echo $ajax->submit('Change Name',$options);?></span>
	</div>
</li>
<?php echo $form->end();?>
