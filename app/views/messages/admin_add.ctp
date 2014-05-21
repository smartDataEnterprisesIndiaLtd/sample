<?php echo $form->create('Message',array('action'=>'admin_add','method'=>'POST','name'=>'frmMessage','id'=>'frmMessage'));?>
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
								<td align="right">Order Item :</td>
								<td>
									<?php echo $this->data['OrderItem']['product_name'];?>
								</td>
								
							</tr>
							<tr>
								<td align="right"><span class="error_msg">*</span> Message :</td>
								<td>
									<?php echo $form->input('Message.message',array('size'=>'30','class'=>'textbox-m','label'=>false,'div'=>false));?>
								</td>
							</tr>
							<tr><td>&nbsp;</td></tr>
							<tr>
								<td >&nbsp;</td>
								<td >
								<?php if(!empty($this->data['Message']['id'])) {
									echo $form->button('Update',array('type'=>'submit','class'=>'btn_53','div'=>false));
								} else {
									echo $form->button('Save',array('type'=>'submit','class'=>'btn_53','div'=>false));
								}?>
								<?php echo $form->button('Cancel',array('type'=>'button','class'=>'btn_53','onClick'=>"goBack('/admin/messages/item_msgs/".$this->data['Message']['order_item_id']."')"));?>
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
echo $form->hidden('Message.id',array('type'=>'text'));
echo $form->hidden('Message.to_user_id',array('type'=>'text'));
echo $form->hidden('Message.from_to_user_id',array('type'=>'text'));
echo $form->hidden('Message.order_item_id',array('type'=>'text'));
echo $form->end();
//echo $validation->rules(array('Adminuser'),array('formId'=>'frmAdminuser'));
?>