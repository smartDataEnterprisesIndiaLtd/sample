<?php echo $javascript->link(array('formvalidation'), false);
echo $form->create('Adminuser',array('action'=>'forgotpassword','method'=>'POST','name'=>'frmuser','id'=>'frmuser'));
?>
<table align="center" width="70%" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td valign="top">
			<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0" class="adminBox">
				<tr>
					<td class="adminGridHeading heading" colspan="" align="left">Password Reminder</td>
				</tr>
				<tr>
					<td colspan="2">
					<div class="errorlogin_msg">
					<?php echo $this->element('errors');?>
					</div>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<table width="100%" border="0" cellspacing="1" cellpadding="3">
							<tr>
								<td colspan="4" align="left">Forgot your password? No problem! <br>
								Just enter your email address in the space below. We will immediately send you a password reminder. <br><span class="error_msg">Fields marked with an asterisk (*) are required.</span>
								<div id="jsErrors"></div>
								</td>
							</tr>
							<tr>
								<td width="10%" align="right"><span class="error_msg">*</span></td>
								<td width="25%" align="left">Email  </td>
								
								<td width="2%" align="center">:</td>
								<td align="left"> <?php echo $form->input('Adminuser.email',array('label'=>false,'div'=>false,'class'=>'input')); ?></td>
							</tr>
							<tr>
								<td colspan="4"> </td>
							</tr>
							<tr>
								<td colspan="3" align="center"> </td>
								<td align="left">
									<?php echo $form->button('Remind Me!',array('type'=>'submit','class'=>'btn_53','div'=>false));?>
									<?php echo $form->button('Cancel',array('class'=>'btn_53','type'=>'button','div'=>false,'onClick'=>"goBack('/admin/adminusers/login')"));?>
								</td>
							</tr>
							<tr>
								<td colspan="4">
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td colspan="2">&nbsp;</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<?php
echo $form->end();
echo $validation->rules(array('Adminuser'),array('formId'=>'frmuser'));
?>
