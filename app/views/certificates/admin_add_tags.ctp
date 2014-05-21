<?php
echo $form->create('Certificate',array('action'=>'add_tags','method'=>'POST','name'=>'frmCertificateSearchtag','id'=>'frmCertificateSearchtag'));?>
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
							<?php if(!empty($this->data['CertificateSearchtag']['id'])) {?>
							<tr>
								<td align="right" width="15%"><span class="error_msg">*</span> User :</td>
								<td>
									<?php echo $this->data['User']['email'];?>
								</td>
							</tr>
							<?php }?>
							<tr>
								<td align="right"><span class="error_msg">*</span> Search Tags :</td>
								<td>
									<?php echo $form->input('CertificateSearchtag.tags',array('class'=>'textbox-m','label'=>false,'div'=>false));
echo $form->hidden('CertificateSearchtag.id',array('class'=>'textbox-m','label'=>false,'div'=>false));?>
								</td>
							</tr>
							<tr><td>&nbsp;</td></tr>
							<tr>
								<td >&nbsp;</td>
								<td >
								<?php if(!empty($this->data['CertificateSearchtag']['id'])) {
									echo $form->button('Update',array('type'=>'submit','class'=>'btn_53','div'=>false));
								} else {
									echo $form->button('Save',array('type'=>'submit','class'=>'btn_53','div'=>false));
								}?>
								<?php echo $form->button('Cancel',array('type'=>'button','class'=>'btn_53','onClick'=>"goBack('/admin/certificates/searchtags')"));?>
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
echo $form->end();
?>