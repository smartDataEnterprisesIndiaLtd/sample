<?php
echo $javascript->link(array('jquery-1.3.2.min'), false);
echo $javascript->link(array('behaviour.js','textarea_maxlen'));
echo $javascript->link('functions');
echo $form->create('Certificate',array('action'=>'add/'.$id,'method'=>'POST','name'=>'frmCertificate','id'=>'frmCertificate'));
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
					<td align="right" width="20%"><span class="error_msg">*</span> Amount</td><td style="width:5px" valign="top"> : </td>
					<td>
						<?php echo $form->input('Certificate.amount',array('class'=>'textbox-m','label'=>false,'div'=>false,'onChange'=>'fixPriceDecimals(this.id,this.value)'));?>
					</td>
				</tr>
				<tr>
					<td align="right" width="20%"><span class="error_msg">*</span> Quantity</td><td style="width:5px" valign="top"> : </td>
					<td>
						<?php echo $form->input('Certificate.quantity',array('class'=>'textbox-m','label'=>false,'div'=>false,'onChange'=>'fixQuantityDecimals(this.id,this.value)'));?>
					</td>
				</tr>
				<tr>
					<td valign="top" align="right" width="20%" ><span class="error_msg">*</span> Recipient E-mail</td><td style="width:5px" valign="top"> : </td>
					<td>
						<?php echo $form->input('Certificate.recipient',array('class'=>'textbox-m','label'=>false,'div'=>false));?>
					</td>
				</tr>
				<tr align="right" width="20%">
					<td ><strong>To</strong></td>
					<td style="width:5px" valign="top"> : </td>
					<td ><?php echo $form->input('Certificate.to',array('class'=>'textbox-m','label'=>false,'div'=>false));?></td>
				</tr>
				<tr align="right" width="20%" >
					<td ><strong>From</strong></td>
					<td style="width:5px" valign="top"> : </td>
					<td ><?php echo $form->input('Certificate.from',array('class'=>'textbox-m','label'=>false,'div'=>false));?></td>
				</tr>
				<tr align="right" width="20%" >
					<td valign="top"><strong>Message</strong></td>
					<td style="width:5px" valign="top"> : </td>
					<td ><?php echo $form->input('Certificate.message',array('type'=>'textarea','class'=>'textbox-m','label'=>false,'div'=>false,'cols'=>'45','rows'=>'7','showremain'=>'limitOne','maxLength'=>300,'style'=>'width:90%'));?></td>
				</tr>
				<tr>
					<td valign="top"> </td>
					<td style="width:5px" valign="top">  </td>
					<td valign="top">Remaining characters : 
						<span id ="limitOne"><?php if(!empty($this->data)){
							if(!empty($this->data['Certificate']['message'])) {
								$remain = 300 - strlen($this->data['Certificate']['message']);
								echo $remain;
							} else {
								echo '300';
							} 
						} else { 
							echo '300'; } ?></span></td>
				</tr>
				<tr>
					<td colspan="3">&nbsp;</td>
				</tr>
				<tr>
					<td align="center"></td><td style="width:5px"></td>
					<td align="left">
						<?php
						if(empty($id))
							$submit_buttton="Add";
						else
							$submit_buttton="Update";
						echo $form->button($submit_buttton,array('type'=>'submit','class'=>'btn_53','div'=>false));
						echo $form->button('Cancel',array('type'=>'button','class'=>'btn_53','onClick'=>"goBack('/admin/certificates')"));?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td colspan="2">&nbsp;</td>
	</tr>
</table>
<?php echo $form->end(); ?>