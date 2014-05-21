<?php
echo $javascript->link(array('behaviour.js','textarea_maxlen'));
echo $form->create('Review',array('action'=>'add_gift_certificate/'.$id,'method'=>'POST','name'=>'frmReview','id'=>'frmReview'));
?>
<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr class="adminBoxHeading reportListingHeading">
		<td class="adminGridHeading heading"><?php echo $listTitle; ?></td>
		<td height="25" align="right"> </td>
	</tr>
	<tr>
		<td colspan="2">
			<table width="100%" border="0" cellspacing="1" cellpadding="3" class="adminBox">
				<tr height="20px">
					<td class="error_msg" colspan="4" align="left">Fields marked with an asterisk (*) are required.</td>
				</tr>
				<tr>
					<td align="right" width="20%"><span class="error_msg">*</span> User Email: </td>
					<td>
						<?php echo $form->input('CertificateReview.user_email',array('size'=>'30','class'=>'textbox-m','label'=>false,'div'=>false));?>
						<?php echo $form->error('CertificateReview.user_email'); ?>
					</td>
				</tr>
				<tr>
					<td align="right" width="20%"><span class="error_msg">*</span> Review Type : </td>
					<td>   <?php
						 $options=array('0'=>' Negative&nbsp;&nbsp;&nbsp;&nbsp;','1'=>' Neutral&nbsp;&nbsp;&nbsp;&nbsp;','2'=>' Positive');
						 $attributes=array('legend'=>false);
						 echo $form->radio('CertificateReview.review_type',$options,$attributes);
						 ?>
						<?php echo $form->error('CertificateReview.review_type'); ?><?php echo $form->hidden('CertificateReview.id',array('size'=>'30','class'=>'textbox-m','label'=>false,'div'=>false));?>
					</td>
				</tr>
				<tr>
					<td align="right" width="20%" valign="top"><span class="error_msg">*</span>Write Comments :  <br><br>
					<p>Limit 3000 Characters:
					</p></td>
					<td><?php echo $form->textarea("CertificateReview.comments",array("label"=>false,"div"=>false, 'class'=>'textbox-l','rows'=>10,'maxlength'=>'3000','cols'=>100,'showremain'=>"limitOne")); ?>
					<?php echo $form->error('CertificateReview.comments'); ?>
					</td>
				</tr>
				<tr><td></td><td><div style="color:#CFCFCF;font-size:10px">Limit 3000 Characters. Remaining characters : <span id ="limitOne"><?php if(!empty($this->data)){
							if(!empty($this->data['CertificateReview']['comments'])) { 
								$remain = 3000 - strlen($this->data['CertificateReview']['comments']);
								echo $remain;
							} else {
								echo '3000'; 
							} 
						} else { 
							echo '3000'; } ?></span></div></td></tr>
				<tr>
					<td colspan="2">&nbsp;</td>
				</tr>
				<tr>
					<td align="center"></td>
					<td align="left">
						<?php 
						if(empty($this->data['CertificateReview']['id']))
							$submit_buttton="Add";
						else
							$submit_buttton="Update";
						echo $form->button($submit_buttton,array('type'=>'submit','class'=>'btn_53','div'=>false));?>
						<?php echo $form->button('Cancel',array('type'=>'button','class'=>'btn_53','onClick'=>"goBack('/admin/reviews/gift_certificate')"));?>
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