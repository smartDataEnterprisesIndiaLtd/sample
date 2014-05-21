<?php
$this->Html->addCrumb('Email Templates', ' ');
if(!empty($id)){
$this->Html->addCrumb('Update email template', 'javascript:void(0)');
}else{
$this->Html->addCrumb('Add email template', 'javascript:void(0)');	
}


echo $javascript->link(array('formvalidation'), false);
echo $javascript->link('fckeditor');
?>
<?php echo $form->create('EmailTemplate',array('action'=>'add/'.$id,'method'=>'POST','name'=>'frmEmailTemplates','id'=>'frmEmailTemplates'));
	
?>
<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0" valign="top">
<tr>
<td valign="top">		
<table align="center" width="98%" border="0" cellpadding="0" cellspacing="0" >
<tr>
<td>
	<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0">
		<tr class="adminBoxHeading reportListingHeading heading">
			<td class="adminGridHeading heading"><?php echo $listTitle; ?></td>
			<td height="25" align="right">
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<table width="100%" border="0" cellspacing="1" cellpadding="3" class="adminBox">
					<tr height="20px">
						<td class="error_msg" colspan="4" align="left">Fields marked with an asterisk (*) are required.</td>
					</tr>
					<tr>
						<td align="right" width="20%"><span class="error_msg">*</span> Title : </td>
						<td>
							<?php echo $form->input('EmailTemplate.title',array( 'class'=>'textbox-l','label'=>false));?>
						</td>
					</tr>
					<tr>
						<td align="right"><span class="error_msg">*</span> Subject : </td>
						<td>
							<?php echo $form->input('EmailTemplate.subject',array('class'=>'textbox-l','label'=>false,'div'=>false));?>
						</td>
					</tr>
					<tr>
						<td align="right"><span class="error_msg">*</span> From Address Email : </td>
						<td>
							<?php echo $form->input('EmailTemplate.from_email',array('class'=>'textbox-m','label'=>false,'div'=>false));?>
						</td>
					</tr>
					<tr>
						<td valign="top" align="right">Description : </td>
						<td align="left"> 
							<?php
							echo $form->textarea('EmailTemplate.description',array('rows'=>'25','cols'=>'54'));
							echo $fck->load('EmailTemplate/description');?>
					</tr>
					
					<tr>
						<td colspan="2" align="center" height="35">
							<?php 							
							echo $form->button($submit_buttton,array('type'=>'submit','class'=>'btn_53','div'=>false));?>
							<?php echo $form->button('Cancel',array('type'=>'button', 'class'=>'btn_53','div'=>false,'onClick'=>"return goBack('/admin/email_templates')"));?>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="2">
				<?php echo $this->element('admin/EmailTemplateCode');?>
			</td>
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
//echo $validation->rules('EmailTemplate',array('formId'=>'frmEmailTemplates'));
?>
