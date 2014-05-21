<?php
echo $javascript->link(array('behaviour.js','textarea_maxlen'));
echo $form->create('Certificate',array('action'=>'add_answer/'.$ques_id.'/'.$id,'method'=>'POST','name'=>'frmCertificateQuestion','id'=>'frmCertificateQuestion'));
?>	
<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr class="adminBoxHeading reportListingHeading">
		<td class="adminGridHeading heading"><?php echo $listTitle; ?></td>
		<td height="25" align="right"> 
		</td>
	</tr>
	<tr><td colspan="2">&nbsp;</td></tr>
	<tr>
		<td colspan="2">
 			<table width="100%" cellspacing="0" cellpadding="0" align="center" border="0">
				<tr class="adminBoxHeading">
					<td height="25" class="reportListingHeading">Question Detail</td>
				</tr>
				<tr>
					<td>
						<table width="100%" cellspacing="1" cellpadding="2" class="adminBox" align="center" border="0">
							<tr>
								<td>
									<table width="100%" cellspacing="1" cellpadding="1" align="center" border="0">
										<tr>
											<td align="left" width="10%">Question : </td>
											<td colspan="3" >
												<?php echo $question_detail['CertificateQuestion']['question']; ?>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr><td colspan="2">&nbsp;</td></tr>
	<tr>
		<td colspan="2">
			<table width="100%" border="0" cellspacing="1" cellpadding="3" class="adminBox">
				<tr height="20px">
					<td class="error_msg" colspan="4" align="left">Fields marked with an asterisk (*) are required.</td>
				</tr>
				<tr>
					<td align="right" width="20%" valign="top"><span class="error_msg">*</span> Answer : <!--<span id="limitOne"></span>--></td>
					<td><?php echo $form->textarea("CertificateAnswer.answer",array("label"=>false,"div"=>false, 'class'=>'textbox-l','rows'=>10,'maxlength'=>500, 'cols'=>100, 'showremain'=>"limitOne")); ?><?php echo $form->error('CertificateAnswer.answer'); ?>
					<?php echo $form->hidden("CertificateAnswer.certificate_question_id",array('type'=>'text')); ?>
					<?php echo $form->hidden("CertificateAnswer.id",array('type'=>'text')); ?>
					</td>
				</tr>
				<tr><td></td><td><div style="color:#CFCFCF;font-size:10px">Limit 500 Characters. Remaining characters : <span id ="limitOne"><?php if(!empty($this->data)){
							if(!empty($this->data['CertificateAnswer']['answer'])) { 
								$remain = 500 - strlen($this->data['CertificateAnswer']['answer']);
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
						if(empty($this->data['CertificateAnswer']['id']))
							$submit_buttton="Add";
						else
							$submit_buttton="Update";
						echo $form->button($submit_buttton,array('type'=>'submit','class'=>'btn_53','div'=>false));?> 
						<?php echo $form->button('Cancel',array('type'=>'button','class'=>'btn_53','onClick'=>"goBack('/admin/certificates/answers/$ques_id');"));?>
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