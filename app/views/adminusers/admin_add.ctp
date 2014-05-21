<?php echo $form->create('Adminuser',array('action'=>'add','method'=>'POST','name'=>'frmAdminuser','id'=>'frmAdminuser'));?>
<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0" valign="top">
				<tr>
					<td valign="top">
				<table align="center" width="98%" border="0" cellpadding="0" cellspacing="0">
				<tr class="adminBoxHeading reportListingHeading">
						<td class="adminGridHeading heading"><?php echo $listTitle;?></td>
						<td class="adminGridHeading"></td>
			       </tr>
				
				<tr>
					<td colspan="2">
						<table class="adminBox" border="0" cellpadding="2" cellspacing="2" width="100%">
							<tr height="20px">
								<td class="error_msg" colspan="4" align="left">Fields marked with an asterisk (*) are required.</td>
							</tr>
							<tr>
								<?php if(empty($this->data['Adminuser']['id'])) { ?>
								<td align="right" width="25%"><span class="error_msg">*</span> Username :</td>
								<td>
									<?php echo $form->input('Adminuser.username',array('size'=>'30','class'=>'textbox-m','label'=>false,'div'=>false));?>
								</td>
								<?php } else{?>
								<td align="right" width="25%"><span class="error_msg">*</span> Username : </td>
								<td>
									<?php if(!empty($this->data['Adminuser']['username'])){
										echo  $this->data['Adminuser']['username'];
									}
									?>
								</td>
								<?php }?>
							</tr>
							<?php if(empty($this->data['Adminuser']['id'])) { ?>
							<tr>
								<td align="right"><span class="error_msg">*</span> Password :</td>
								<td>
									<?php if(empty($this->data['Adminuser']['id'])){
										echo $form->input('Adminuser.password',array('size'=>'30','maxlength'=>'40','class'=>'textbox-m','type'=>'password','label'=>false,'value'=>'','div'=>false));
									} else {
										echo $form->input('Adminuser.password1',array('size'=>'30','maxlength'=>'255','class'=>'textbox-m','type'=>'password','label'=>false,'value'=>'','div'=>false));?><br>
										<?php echo $form->hidden('Adminuser.password_original',array('size'=>'255','maxlength'=>'255','class'=>'textbox-m','type'=>'password','label'=>false,'div'=>false));?>
									<?php }?>
									<?php echo $form->hidden('Adminuser.id',array('size'=>'30','maxlength'=>'30','class'=>'textbox-m','label'=>false,'div'=>false));?>
								</td>
							</tr>
							<tr>
								<td align="right"><span class="error_msg">*</span> Confirm password :</td>
								<td>
									<?php if(empty($this->data['Adminuser']['id'])){
										echo $form->input('Adminuser.confirmpassword',array('size'=>'30','maxlength'=>'40','class'=>'textbox-m','type'=>'password','label'=>false,'value'=>'','div'=>false));
									} else {
										echo $form->input('Adminuser.confirmpassword1',array('size'=>'30','maxlength'=>'255','class'=>'textbox-m','type'=>'password','label'=>false,'value'=>'','div'=>false));
									}?>
									<?php echo $form->hidden('Adminuser.id',array('size'=>'30','maxlength'=>'30','class'=>'textbox-m','label'=>false,'div'=>false));?>
								</td>
							</tr>
							<?php }?>
							<tr>
								<td align="right"><span class="error_msg">*</span> First name :</td>
								<td>
									<?php echo $form->input('Adminuser.firstname',array('size'=>'30','class'=>'textbox-m','label'=>false,'div'=>false));?>
								</td>
								
							</tr>
							<tr>
								<td align="right"><span class="error_msg">*</span> Last name :</td>
								<td>
									<?php echo $form->input('Adminuser.lastname',array('size'=>'30','class'=>'textbox-m','label'=>false,'div'=>false));?>
								</td>
							</tr>
							<tr>
								<td align="right"><span class="error_msg">*</span> Email address :</td>
								<td>
									<?php echo $form->input('Adminuser.email',array('size'=>'30','class'=>'textbox-m','label'=>false,'div'=>false));?>
								</td>
								
							</tr>
							<tr>
								<td align="right"><span class="error_msg">*</span> Status :</td>
								<td>
									<?php echo $form->select('Adminuser.status',array('0'=>'Inactive','1'=>'Active'),null,array('class'=>'textbox-s', 'type'=>'select'),'-- Select --'); ?>
									<?php echo $form->error('Adminuser.status'); ?>
								</td>
								
							</tr>
							<tr><td>&nbsp;</td></tr>
							<tr>
								<td >&nbsp;</td>
								<td >
								<?php if(!empty($this->data['Adminuser']['id'])) {
									echo $form->button('Update',array('type'=>'submit','class'=>'btn_53','div'=>false));
								} else {
									echo $form->button('Save',array('type'=>'submit','class'=>'btn_53','div'=>false));
								}?>
								<?php echo $form->button('Cancel',array('type'=>'button','class'=>'btn_53','onClick'=>"goBack('/admin/adminusers/index')"));?>
								</td><td>&nbsp;</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<?php echo $form->input('Adminuser.id');
echo $form->end();
?>