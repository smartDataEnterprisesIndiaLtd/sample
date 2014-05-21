<?php echo $javascript->link('fckeditor');?>
<?php echo $form->create('OrderReturn',array('action'=>'reply_claim/'.$order_item_id.'/'.$user_id.'/'.$claim_id,'method'=>'POST','name'=>'frmOrderReturn','id'=>'frmOrderReturn'));

?>
<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0" valign="top">
	<tr>
		<td class="adminGridHeading heading"><?php echo $listTitle;?></td>
		<td class="adminGridHeading heading" align="right"></td>
	</tr>
	<tr>
		<td colspan="2">
			<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0" valign="top" class="adminBox" >
				<tr>
					<td valign="top" id="pagging">
			
						<table align="center" width="100%" border="0" cellpadding="3" cellspacing="3">
							<tr>
								<td width="15%"><strong>Item :</strong></td>
								<td><?php if(!empty($order_item_details['OrderItem']['product_name'])) echo $order_item_details['OrderItem']['product_name']; else echo '-';?></td>
							</tr>
							<?php if(!empty($claim_info)) { ?>
							<tr>
								<td valign="top"><strong>Claim Reason :</strong></td>
								<td><?php if(!empty($claim_info['Claim']['reason_id'])) echo $claim_reason[$claim_info['Claim']['reason_id']]; else echo '-';?></td>
							</tr>
							<tr>
								<td><strong>Claim Comments :</strong></td>
								<td><?php if(!empty($claim_info['Claim']['comments'])) echo $claim_info['Claim']['comments']; else echo '-';?></td>
							</tr>
							<?php } ?>
							<tr>
								<td><strong>To :</strong></td>
								<td><?php echo $form->select('Claim.to',$to_array,null,array('class'=>'textbox', 'type'=>'select'),'-- Select --'); ?>
								<?php echo $form->error('Claim.to'); ?></td>
							</tr>
							<tr>
								<td><strong>Subject :</strong></td>
								<td><?php echo $form->input('Claim.subject',array('size'=>'30','class'=>'textbox','label'=>false,'div'=>false));?></td>
							</tr>
							<tr>
								<td><strong>Message :</strong></td>
								<td><?php //echo $form->input('Claim.message',array('size'=>'30','class'=>'textbox','label'=>false,'div'=>false,'rows'=>5,'cols'=>45));
									echo $form->textarea('Claim.message',array('rows'=>'2','cols'=>'30')); 
									echo $fck->load('Claim/message'); 
									echo $form->error('Claim.message',array('class'=>'error_msg'));
								?></td>
							</tr>
							<tr><td>&nbsp;</td><td><?php echo $form->button('Send',array('type'=>'submit','class'=>'btn_53','div'=>false));?></td></tr>
							
						</table>
						
						
<!--- Start list table-->

	<?php if(isset($allClaimReply) && is_array($allClaimReply) && count($allClaimReply) > 0){?>
		<table width="100%" cellpadding="2" cellspacing="1"  border="0"  class="borderTable">
			<tr>
				<td align="left" class="adminGridHeading" width="25%" >Message To</td>
				<td class="adminGridHeading" align="center" width="25%" >Subject</td>
				<td class="adminGridHeading" align="center" width="40%" >Message</td>
				<td class="adminGridHeading" align="center" width="10%" >Message send on</td>
			</tr>
			<?php
				$class= 'rowClassEven';
			foreach ($allClaimReply as $allClaimReply) {
				$class = ($class == 'rowClassEven')?'rowClassOdd':'rowClassEven';
			?>
			<tr class="<?php echo $class?>">
				<td align="left">
					<?php
					if($allClaimReply['ClaimReply']['is_replied_seller']=='1' && $allClaimReply['ClaimReply']['is_replied_buyer']=='1')
						{
							echo 'Both(Seller & Buyer)';
							
						}elseif($allClaimReply['ClaimReply']['is_replied_seller']=='1'){
							$sellerInfo=$this->Common->getsellerInfo($allClaimReply['ClaimReply']['user_id']);
							echo $sellerInfo['Seller']['business_display_name'].'(Seller)';
							
						}elseif($allClaimReply['ClaimReply']['is_replied_buyer']=='1'){
							echo $allClaimReply['User']['firstname'].' '.$allClaimReply['User']['firstname'].'(User)';
						}else{
							echo '----';
						}
							
					/*if($allClaimReply['ClaimReply']['is_replied_seller']=='1')
						{
							
							$sellerInfo=$this->Common->getsellerInfo($allClaimReply['ClaimReply']['user_id']);
							echo $sellerInfo['Seller']['business_display_name'].'(Seller)';
						}else{
								
							echo $allClaimReply['User']['firstname'].' '.$allClaimReply['User']['firstname'].'(User)';
						}*/
					
					?>
				</td>
				<td align="center"><?php echo $allClaimReply['ClaimReply']['subject'];?></td>
				<td align="center"><?php echo $html->link(substr($allClaimReply['ClaimReply']['message'],0,120),'/admin/order_returns/reply_claim_detail/'.$order_item_id.'/'.$user_id.'/'.$claim_id.'/'.$allClaimReply['ClaimReply']['id'],array('escape'=>false));?></td>
				<td align="center"><?php echo date(DATE_FORMAT,strtotime($allClaimReply['ClaimReply']['created']));?></td>
			</tr>
			<?php }?>
		</table>
	<?php }else{ ?>
		<table width="100%" cellpadding="2" cellspacing="0" border="0" class="borderTable">
			<tbody>
				<tr> 
					<td align="center">No record found</td>
				</tr>
			</tbody>
		</table>
	<?php } ?>
	</td></tr>
</table>
<!-- End List Table-->
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<?php echo $form->hidden('Claim.order_item_id');?>
<?php echo $form->hidden('Claim.user_id');?>
<?php echo $form->end();?>