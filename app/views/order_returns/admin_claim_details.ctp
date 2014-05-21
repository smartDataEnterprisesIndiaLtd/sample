<?php echo $javascript->link(array('lib/prototype'),false);?>
<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0" valign="top">
	<tr>
		<td class="adminGridHeading heading"><?php echo $listTitle;?></td>
		<td class="adminGridHeading heading" align="right"><?php echo $html->link('Back','claims',array('escape'=>false));?></td>
	</tr>
	<tr><td colspan="2">&nbsp;</td></tr>
	<tr>
		<td colspan="2">
 			<table width="100%" cellspacing="0" cellpadding="0" align="center" border="0">
				<tr class="adminBoxHeading">
					<td height="25" class="reportListingHeading">Order Detail</td>
				</tr>
				<tr>
					<td>
						<table width="100%" cellspacing="1" cellpadding="2" class="adminBox" align="center" border="0">
							<tr>
								<td>
									<table width="100%" cellspacing="1" cellpadding="1" align="center" border="0">
										<tr>
											<td align="left" width="11%"><b>Order Id :</b> </td>
											<td  width="21%">
												<?php echo $claimDetail['Order']['id']; ?>
											</td>
											<td width="17%"><b>Date/Time of Order : </b></td>
											<td >
												<?php echo date(DATE_TIME_FORMAT,strtotime($claimDetail['Order']['created'])); ?>
											</td>
										</tr>
										<tr>
											<td align="left"><b>Customer :</b> </td>
											<td>
												<?php echo $claimDetail['User']['firstname'].' '.$claimDetail['User']['lastname']; ?>
											</td>
											<td align="left"><b>Order Value : </b></td>
											<td><?php echo CURRENCY_SYMBOL.$format->money($claimDetail['Order']['order_total_cost'],2); ?></td>
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
		<td colspan="2" valign="top" id="pagging">
			<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td>
						<table align="center" width="100%" border="0" cellpadding="0" cellspacing="1">
							<?php $class = 'rowClassEven';

							foreach($claimDetail['Sellers'] as $claimseller) {
							
							?>
							<tr class="rowClassOdd">
								<td>
								<table width="100%" cellspacing="1" cellpadding ="2" border = "0" class="adminBox" style="padding-bottom:0px;"><tr>
								<td width="10%"><b>Seller name:</b></td>
								<td>
									<?php /*if(!empty($claimseller['SellerSummary']['firstname']) || !empty($claimseller['SellerSummary']['lastname'])){
										if(!empty($claimseller['SellerSummary']['firstname']))
										echo $claimseller['SellerSummary']['firstname'];
										if(!empty($claimseller['SellerSummary']['lastname']))
										echo ' '.$claimseller['SellerSummary']['lastname'];
									}
									else echo '-';*/
									if(!empty($claimseller['seller_items'][0]['OrderItem']['seller_name']))
										echo @$claimseller['seller_items'][0]['OrderItem']['seller_name'];
									else
										echo '-';
									?>
								</td></table></td>
							</tr>
							<tr><td><table align="center" width="100%" border="0" cellpadding="2" cellspacing="1" class='borderTable'>
							<tr>
								<td class="adminGridHeading" width="17%" align ="center" style="padding-right:0px">Claim Submitted Date/Time</td>
								<td class="adminGridHeading" width="21%" >Claim Item Names</td>
								<td class="adminGridHeading" width="8%" >Quick Code</td>
								<td class="adminGridHeading" width="29%" >Reason</td>
								<td class="adminGridHeading" width="15%" >Buyer Coments</td>
								<td class="adminGridHeading" width="8%"  align ="center" style="padding-right:0px">Action</td>
							</tr>
							<?php 
							if(!empty($claimseller['seller_items'])){
							$i=0;
							foreach($claimseller['seller_items'] as $claimitem){
								
								if(($claimitem['Claim']['is_replied_seller'] == 1) && ($claimitem['Claim']['is_replied_buyer'] == 1)){
									$class1 = 'bggreen';
								} else if(($claimitem['Claim']['is_replied_seller'] == 1) && ($claimitem['Claim']['is_replied_buyer'] == 0)) {
									$class1 = 'bgsky';
								} else if (($claimitem['Claim']['is_replied_seller'] == 0) && ($claimitem['Claim']['is_replied_buyer'] == 1)) {
									$class1 = 'bgred';
								} else {
									$class1 = '';
								}
							if($i%2 == 0)
								$class = 'rowClassEven';
							else
								$class = 'rowClassOdd';?>
							<tr class = "<?php echo $class.' '.$class1;?>">
								<td style="height:20px" align="center">
									<?php if(!empty($claimitem['Claim']['created']))
										echo date(DATE_TIME_FORMAT,strtotime($claimitem['Claim']['created']));
									else echo '-'; ?>
								</td>
								<td>
									<?php if(!empty($claimitem['OrderItem']['product_name']))
										echo $claimitem['OrderItem']['product_name'];
									else echo '-'; ?>
								</td>
								<td>
									<?php if(!empty($claimitem['Product']['quick_code'])) echo $claimitem['Product']['quick_code']; else echo '-'; ?>
								</td>
								<td>
									<?php if(!empty($claimitem['Claim']['reason_id']))
										echo $claim_reason[$claimitem['Claim']['reason_id']];
									else echo '-'; ?>
								</td>
								<td>
								<?php if(!empty($claimitem['Claim']['comments'])) echo $this->Common->currencyEnter($format->formatString($claimitem['Claim']['comments'],100,'...')); else echo '-'; ?></td>
								<td width="8%" align="center"><?php echo $html->link('Reply','/admin/order_returns/reply_claim/'.$claimitem['Claim']['order_item_id'].'/'.$claimDetail['User']['id'].'/'.$claimitem['Claim']['id'],array('class'=>'reply','escape'=>false));?></td>
							</tr>
							<?php } ?> 
							</td></tr></table><?php }?> <tr><td>&nbsp;</td></tr> <?php }?>
							<!-- Legends -->
							
							<tr><td height="10"></td></tr>
							<tr>
								<td class="legends">
									<b>Legends:</b>
									
								</td>
							</tr>
							<tr><td height="10"></td></tr>
							<tr><td>
								<table border="0" cellspacing ="2" cellpadding="2" width="100%">
									<tr>
										<td width="10%">&nbsp;</td>
										<td width="17%"><b>Replied(Buyer and Seller):</b></td>
										<td align="left"><div class="bggreen" style="width:50px">&nbsp;</div></td>
									</tr>
									<tr>
										<td width="10%">&nbsp;</td>
										<td width="17%"><b>Replied(Seller):</b></td>
										<td align="left"><div class="bgsky" style="width:50px">&nbsp;</div></td>
									</tr>
									<tr>
										<td width="10%">&nbsp;</td>
										<td width="17%"><b>Replied(Buyer):</b></td>
										<td align="left"><div class="bgred"  style="width:50px">&nbsp;</div></td>
									</tr>
								</table>
							</td></tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>