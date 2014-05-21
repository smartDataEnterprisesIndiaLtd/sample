<?php 
echo $javascript->link(array('behaviour','textarea_maxlen'));
echo $form->create('Certificate',array('action'=>'add_question/'.$id,'method'=>'POST','name'=>'frmCertificateQuestion','id'=>'frmCertificateQuestion'));
?>	
<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr class="adminBoxHeading reportListingHeading">
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
					<td align="right" width="20%" valign="top"><span class="error_msg">*</span> Question :   </td>
					<td><?php echo $form->textarea("CertificateQuestion.question",array("label"=>false,"div"=>false, 'class'=>'textbox-l','rows'=>10,'maxlength'=>500, 'cols'=>100,'showremain'=>'limitOne')); ?>
					<?php echo $form->error('CertificateQuestion.question'); ?>
					<?php echo $form->hidden("CertificateQuestion.id",array("label"=>false,"div"=>false, 'class'=>'textbox-l',)); ?>
					
					</td>
				</tr>
				<tr><td></td><td><div style="color:#CFCFCF;font-size:10px">Limit 500 Characters. Remaining characters : <span id ="limitOne"><?php if(!empty($this->data)){
							if(!empty($this->data['CertificateQuestion']['question'])) { 
								
								$remain = 500 - strlen($this->data['CertificateQuestion']['question']);
								echo $remain;
							} else {
								echo '500'; 
							} 
						} else { 
							echo '500'; } ?></span></div></td></tr>
				<tr>
					<td colspan="2">&nbsp;</td>
				</tr>
				<tr>
					<td align="center"></td>
					<td align="left">
						<?php 
						if(empty($this->data['CertificateQuestion']['id']))
							$submit_buttton="Add";
						else
							$submit_buttton="Update";
						echo $form->button($submit_buttton,array('type'=>'submit','class'=>'btn_53','div'=>false));?>
						<?php echo $form->button('Cancel',array('type'=>'button','class'=>'btn_53','onClick'=>"goBack('/admin/certificates/questions')"));?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td colspan="2">&nbsp;</td>
	</tr>
</table>
<?php
echo $form->end();
?>