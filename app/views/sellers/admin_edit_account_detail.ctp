<?php 
$this->Html->addCrumb('Seller Management', ' ');
$this->Html->addCrumb('Edit Account Details', 'javascript:void(0)');
echo $html->css('dhtmlgoodies_calendar.css');
echo $javascript->link('dhtmlgoodies_calendar.js');
?>
<?php echo $form->create('Seller',array('action'=>'edit_account_detail/'.base64_encode($id),'method'=>'POST','name'=>'frmUser','id'=>'frmUser'));?>

<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td colspan="2">
			<table class="adminBox" border="0" cellpadding="0" cellspacing="0" width="100%">
				<tr class="adminGridHeading heading">
					<td><strong>Edit Account Details</strong></td>
				</tr>
				<tr><td>
					<table border="=" cellpadding="2" cellspacing="2" width="100%">
						<tr><td colspan="2">&nbsp;</td></tr>
						<tr>
							<td align="right" valign="top" width="30%"><!--<span class="error_msg">*</span>--> Bank Account Number :</td>
							<td>
								<?php echo $form->input('Seller.bank_account_no',array('maxlength'=>'20','class'=>'textbox-m','label'=>false,'div'=>false));?>
							</td>
						</tr>
						<tr>
							<td align="right" valign="top"><!--<span class="error_msg">*</span>--> Paypal Email :</td>
							<td>
								<?php echo $form->input('Seller.paypal_email',array('maxlength'=>'255','class'=>'textbox-m','label'=>false,'div'=>false));?>
							</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td align="left">
							<?php
							echo $form->button('Update',array('type'=>'submit','class'=>'btn_53','div'=>false));
							
							echo $form->button('Cancel',array('type'=>'button','class'=>'btn_53','onClick'=>"goBack('/admin/sellers/view_seller_payment_listing')"));?>
							</td>
						</tr>
					</table>
				</td></tr>
			</table>
		</td>
	</tr>
</table>
<?php echo $form->end(); ?>