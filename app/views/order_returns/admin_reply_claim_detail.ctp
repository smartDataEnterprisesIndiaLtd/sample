<?php ?>
<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0" valign="top">
	<tr>
		<td class="adminGridHeading heading"><?php echo $listTitle;?></td>
		<td class="adminGridHeading heading" align="right"><?php echo $html->link('Back','reply_claim/'.$order_item_id.'/'.$user_id.'/'.$claim_id);?></td>
	</tr>
	
	<tr>
		<td colspan="2">
<?php if(isset($ClaimReply) && is_array($ClaimReply) && count($ClaimReply) > 0){?>
		<table width="100%" cellpadding="2" cellspacing="1"  border="0">
			<tr>
				<td align="left" width="15%" >Message To:</td>
				<td align="left">
				
				<?php if($ClaimReply['ClaimReply']['is_replied_seller']=='1')
						{
							
							$sellerInfo=$this->Common->getsellerInfo($ClaimReply['ClaimReply']['user_id']);
							echo $sellerInfo['Seller']['business_display_name'].'(Seller)';
						}else{
								
							echo $ClaimReply['User']['firstname'].' '.$ClaimReply['User']['firstname'].'(User)';
						}
				?>
				
				</td>
			</tr>
			<tr>
				<td align="left" width="15%" >Subject:</td>
				<td align="left"><Strong><?php echo $ClaimReply['ClaimReply']['subject'];?></Strong></td>
			</tr>
			<tr>
				<td align="left" width="15%" >Message:</td>
				<td align="left"><?php echo $ClaimReply['ClaimReply']['message'];?></td>
			</tr>
			<tr>
				<td align="left" width="15%" >Message send on:</td>
				<td align="left"><?php echo  date(DATE_FORMAT,strtotime($ClaimReply['ClaimReply']['created']));?></td>
			</tr>
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
			
			
		</td>
	</tr>
</table>