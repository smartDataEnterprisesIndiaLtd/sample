<?php
echo $form->create('Seller',array('action'=>'admin_upload_paymentsummary', 'method'=>'POST','name'=>'frmPaymentReport','id'=>'frmPaymentReport', 'enctype'=>'multipart/form-data' ));?>
<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr class="adminBoxHeading reportListingHeading">
		<td class="adminGridHeading heading"><?php echo $listTitle; ?></td>
		<td class="adminGridHeading heading"  height="25px" align="right"></td>
	</tr>
	<tr>
		<td colspan="2">
			<table class="adminBox" border="0" cellpadding="2" cellspacing="2" width="100%">
				<tr height="20px">
					<td class="error_msg" colspan="2" align="left">Fields marked with an asterisk (*) are required.</td>
				</tr>
				<tr>
					<td align="right" valign="top"><span class="error_msg">*</span> Upload Payment Report :</td>
					<td>
						<?php echo $form->input('PaymentReport.sample_bulk_data',array('class'=>'textbox','label'=>false,'div'=>false,'error'=>false,'type' => 'file'));?>
					</td>
				</tr>
				<tr>
					<td colspan="2">&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td align="left">
					<?php 
					echo $form->button('Upload Payment Report',array('type'=>'submit','class'=>'btn_53','div'=>false));
					?>
					</td>
				</tr>
				<tr>
					<td colspan="2">&nbsp;</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<?php echo $form->end(); ?>