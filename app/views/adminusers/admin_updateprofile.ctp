<?php
 $this->Html->addCrumb('Account Settings', 'javascript:void(0)');
     $this->Html->addCrumb('Update Profile', 'javascript:void(0)');
echo $javascript->link(array('formvalidation'), false); ?>

<?php echo $form->create('Adminuser',array('action'=>'updateprofile','method'=>'POST','name'=>'frmAdminuser','id'=>'frmAdminuser'));?>
<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0" valign="top">
	<tr>
		<td valign="top">
			<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0">
				 <tr class="adminBoxHeading reportListingHeading">
						<td class="adminGridHeading heading"><?php echo $listTitle;?></td>
						<td class="adminGridHeading" align="right">
						</td>
			       </tr>
				<tr>
					<td colspan="2">
						<table class="adminBox" border="0" cellpadding="2" cellspacing="2" width="100%">
							<!--<tr><td colspan="4">
								<div class="errorlogin_msg">
								<?php //echo $this->element('errors'); ?>
								</div>
								</td>
							</tr>-->
							<tr height="20px">
									<td class="error_msg" colspan="2" align="left">Fields marked with an asterisk (*) are required.</td>
							</tr>
							<tr>
								<td colspan="2">
									<div id="jsErrors"></div>
								</td>
							</tr>
							<tr>
								<td valign="top" align="right" width="20%"><span class="error_msg">* </span>Username : </td>
								<td>
									<?php  echo $form->input('Adminuser.username',array('size'=>'30','class'=>'textbox-m','label'=>false,'div'=>false, 'readonly'=>true));?>
								</td>
							</tr>
							<tr>
								<td valign="top" align="right"><span class="error_msg">* </span>First name : </td>
								<td>
									<?php echo $form->input('Adminuser.firstname',array('size'=>'30','class'=>'textbox-m','label'=>false,'div'=>false));?>
								</td>
								
							</tr>
							<tr>
								<td valign="top" align="right"><span class="error_msg">* </span>Last name : </td>
								<td>
									<?php echo $form->input('Adminuser.lastname',array('size'=>'30','class'=>'textbox-m','label'=>false,'div'=>false));?>
								</td>
							</tr>
							<tr>
								<td valign="top" align="right"><span class="error_msg">* </span>Email address : </td>
								<td>
									<?php echo $form->input('Adminuser.email',array('size'=>'30','class'=>'textbox-m','label'=>false,'div'=>false));?>
								</td>
								
							</tr>
							<tr>
								<td valign="top" align="right"><span class="error_msg">* </span>Security question :</td>
								<td>
<?php echo $form->select('Adminuser.security_que',$security_que,$this->data['Adminuser']['security_que'],array('type'=>'select','class'=>'textbox-m','div'=>false,'size'=>1),'Select security question'); ?>
								<?php echo $form->error('Adminuser.security_que'); ?></td>
								
							</tr>
							<tr>
								<td valign="top" align="right"><span class="error_msg">* </span>Answer :</td>
								<td>
<?php echo $form->input('Adminuser.answer',array('size'=>'30','class'=>'textbox-m','label'=>false,'div'=>false));?>
								</td>
								
							</tr>
							<tr>
								<td align="center">&nbsp;</td>
								<td align="left">
								<?php if(!empty($this->data['Adminuser']['id'])) {
									echo $form->button('Update',array('type'=>'submit','class'=>'btn_53','div'=>false));
								} else {
									echo $form->button('Add',array('type'=>'submit','class'=>'btn_53','div'=>false));
								}?>
								</td><td>&nbsp;</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<?php 
echo $form->input('Adminuser.id');
echo $form->end();
//echo $validation->rules(array('Adminuser'),array('formId'=>'frmAdminuser'));
?>