<?php
$this->Html->addCrumb('Seller Management', ' ');
$this->Html->addCrumb('Change Seller Password ', 'javascript:void(0)');
echo $form->create('Seller',array('action'=>'seller_changepassword/'.$id,'id'=>'frmSeller'));?>
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
				<tr height="20px">
					<td class="error_msg" colspan="2" align="left">Fields marked with an asterisk (*) are required.</td>
				</tr>
				<tr>
					<td align="right" width="15%"><span class="error_msg">*</span> New Password : </td>
					<td lign="left">
						<?php echo $form->input('Seller.newpassword',array('type'=>'password','size'=>'30','class'=>'textbox-s','label'=>false,'div'=>false)); ?> </td>
					</td>
				</tr>
				<tr>
					<td align="right"><span class="error_msg">*</span> Confirm Password : </td>
					<td align="left">
						<?php echo $form->input('Seller.newconfirmpassword',array('type'=>'password','size'=>'30','class'=>'textbox-s','label'=>false,'div'=>false)); ?>
					</td>
				</tr>
				<tr>
					<td colspan="2">&nbsp;</td>
				</tr>
				<tr>
					<td   align="center">&nbsp;</td><td><?php echo $form->button('Submit',array('type'=>'submit','class'=>'btn_53','div'=>false));?>
					<?php echo $form->button('Cancel',array('type'=>'button', 'class'=>'btn_53','div'=>false,'onClick'=>"return goBack('/admin/sellers')"));?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	
	<tr>
		<td valign="top" align="left" class="actHeading">&nbsp;
		</td>
	</tr>
</table>
<?php echo $form->end();
?>