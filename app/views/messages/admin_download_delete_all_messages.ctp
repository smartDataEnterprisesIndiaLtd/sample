<?php
$this->Html->addCrumb('Order Management', '/admin/orders');
	$this->Html->addCrumb('Download / Delete Messages', 'javascript:void(0)');
echo $form->create('Message',array('action'=>'admin_download_delete_all_messages','method'=>'POST','name'=>'frmMessage','id'=>'frmMessage'));?>
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
								<td align="right"><span class="error_msg">*</span> Select Action :</td>
								<td>
									<?php echo $form->select('Message.action',array('1'=>'Download & Delete','2'=>'Download Only','3'=>'Delete Only'),null,array('class'=>'textbox', 'type'=>'select'),'-- Select --'); ?>
								</td>
								
							</tr>
							<tr><td>&nbsp;</td></tr>
							<tr>
								<td >&nbsp;</td>
								<td >
								<?php echo $form->button('Submit',array('type'=>'submit','class'=>'btn_53','div'=>false));
								?>
								</td>
							</tr>
							<tr><td>&nbsp;</td></tr>
							<tr><td colspan="2">Download / Delete Messages which have been sent before <?php echo date('d/m/Y',strtotime(date('Y-m-d')) - 180*24*60*60); ?></td></tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<?php echo $form->end(); ?>