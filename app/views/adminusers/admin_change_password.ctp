<?php 
     $this->Html->addCrumb('Account Settings', 'javascript:void(0)');
     $this->Html->addCrumb('Change Password', 'javascript:void(0)');
      
?>
<?php echo $form->create('Adminuser',array('action'=>'change_password','id'=>'frmAdminuser'));?>
<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0">
<tr class="adminGridHeading">
<td height="25" align="left" class="heading"><?php echo $title_for_layout;?>
</td>
<td height="25" align="right">
</td>
</tr>
<tr>
<td colspan="2">
	<table width="100%" cellspacing="1" cellpadding="3" class="adminBox">
		<tr><td colspan="4">
		<div class="errorlogin_msg">
		<?php 	 // echo $this->element('errors'); 		 ?>
		</div>
		</td></tr>
		<tr height="20px">
			<td class="error_msg" colspan="4" align="left">Fields marked with an asterisk (*) are required.</td>
		</tr>
		<tr>
		<td colspan="2">
			<div id="jsErrors"></div>
		</td>
		</tr>
		<tr>
			<td width="25%" align="right"><span class="error_msg">*</span> Old Password : </td>
			<td lign="left">
				<?php echo $form->input('Adminuser.oldPassword',array('type'=>'password','size'=>'30','class'=>'textbox-m','label'=>false,'div'=>false)); ?>
			</td>
		</tr>
		<tr>
			<td align="right"><span class="error_msg">*</span> New Password : </td>
			<td lign="left">
				<?php echo $form->input('Adminuser.newpassword',array('type'=>'password','size'=>'30','class'=>'textbox-m','label'=>false,'div'=>false)); ?> </td>
			</td>
		</tr>
		<tr>
			<td align="right"><span class="error_msg">*</span> Confirm Password : </td>
			<td align="left">
				<?php echo $form->input('Adminuser.confirmpassword',array('type'=>'password','size'=>'30','class'=>'textbox-m','label'=>false,'div'=>false)); ?>
			</td>
		</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
		<tr>
			<td   align="center">&nbsp;</td><td><?php echo $form->button('Submit',array('type'=>'submit','class'=>'btn_53','div'=>false));?>
			<?php echo $form->button('Cancel',array('type'=>'button', 'class'=>'btn_53','div'=>false,'onClick'=>"return goBack('/admin/homes/dashboard')"));?>
			</td>
		</tr>
	</table>
</td>
</tr>
</table>

<?php echo $form->end();
//echo $validation->rules(array('Adminuser'),array('formId'=>'frmAdminuser'));
?>