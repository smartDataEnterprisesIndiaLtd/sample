<?php ?>
<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0" valign="top">
	<tr>
		<td class="adminGridHeading heading"><?php echo $listTitle;?></td>
		<td class="adminGridHeading heading" align="right"><?php echo $html->link('Back','index',array('escape'=>false));?></td>
	</tr>
	<tr><td colspan="2">&nbsp;</td></tr>
	<tr>
		<td colspan="2">
 			<table width="100%" cellspacing="0" cellpadding="0" align="center" border="0">
				<tr class="adminBoxHeading">
					<td height="25" class="reportListingHeading">Order Detail</td>
				</tr>
				<tr>
					<td >
						<table width="100%" cellspacing="1" cellpadding="2" class="adminBox" align="center" border="0">
							<tr>
								<td>
									<table width="100%" cellspacing="1" cellpadding="1" align="center" border="0">
										<tr>
											<td align="left" width="15%"><b>Order Number :</b> </td>
											<td  width="21%">
												<?php echo $returneditems['Order']['order_number']; ?>
											</td>
											<td width="17%"><b>Date/Time of Order : </b></td>
											<td >
												<?php echo date(DATE_TIME_FORMAT,strtotime($returneditems['Order']['created'])); ?>
											</td>
										</tr>
										<tr>
											<td align="left"><b>Customer :</b> </td>
											<td>
												<?php echo $returneditems['User']['firstname'].' '.$returneditems['User']['lastname']; ?>
											</td>
											<td align="left"><b>Total Refunded Amount : </b></td>
											<td><?php if(!empty($returneditems['Order']['total_refundedAmount'])) echo CURRENCY_SYMBOL.$format->money($returneditems['Order']['total_refundedAmount'],2);?></td>
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

							foreach( $returneditems['Sellers'] as $returnedseller ) { 
							if($class == 'rowClassEven')
								$class = 'rowClassOdd';
							else
								$class = 'rowClassEven';
							//echo $class;
							?>
							<tr class=<?php echo $class;?>>
								<td>
								<table width="100%" cellspacing="1" cellpadding ="2" border = "0" class="adminBox" style="padding-bottom:0px"><tr>
								<td><b>Seller name:</b></td>
								<td>
									<?php if(!empty($returnedseller['SellerSummary']['firstname']) || !empty($returnedseller['SellerSummary']['lastname'])){
										if(!empty($returnedseller['SellerSummary']['firstname']))
										echo $returnedseller['SellerSummary']['firstname'];
										if(!empty($returnedseller['SellerSummary']['lastname']))
										echo ' '.$returnedseller['SellerSummary']['lastname'];
									}
									else echo '-'; ?>
								</td>
								<td><b>Amount returned by seller:</b></td>
								<td>
									<?php if(!empty($returnedseller['refunded_amount'])) echo CURRENCY_SYMBOL.$format->money($returnedseller['refunded_amount'],2);?>
								</td></tr></table></td>
							</tr>
							<tr><td><table align="center" width="100%" border="0" cellpadding="2" cellspacing="1" class='borderTable'>
							<tr>
								<td class="adminGridHeading" width="15%" >Return Submitted Date/Time</td>
								<td class="adminGridHeading" width="25%" >Return Item Names</td>
								<td class="adminGridHeading" width="12%" >Quick code</td>
								<td class="adminGridHeading" align="center" width="8%" style="padding:0px">Quantity</td>
								<td class="adminGridHeading" width="27%" >Reason</td>
								<td class="adminGridHeading" width="13%" >Returns Value</td>
							</tr>
							<?php 
							if(!empty($returnedseller['seller_items'])){
							$i=0;
							foreach($returnedseller['seller_items'] as $returneditem){
							if($i%2 == 0)
								$class = 'rowClassEven';
							else
								$class = 'rowClassOdd';?>
							<tr class = "<?php echo $class;?>">
								<td style="height:20px">
									<?php if(!empty($returneditem['OrderReturn']['created']))
										echo date(DATE_TIME_FORMAT,strtotime($returneditem['OrderReturn']['created']));
									else echo '-'; ?>
								</td>
								<td>
									<?php if(!empty($returneditem['OrderItem']['product_name']))
										echo $returneditem['OrderItem']['product_name'];
									else echo '-'; ?>
								</td>
								<td>
									<?php if(!empty($returneditem['OrderItem']['quick_code']))
										echo $returneditem['OrderItem']['quick_code'];
									else echo '-'; ?>
								</td>
								<td align="center">
									<?php if(!empty($returneditem['OrderReturn']['quantity']))
										echo $returneditem['OrderReturn']['quantity'];
									else echo '-'; ?>
								</td>
								<td>
									<?php if(!empty($returneditem['OrderReturn']['comments']))
										echo $returneditem['OrderReturn']['comments'];
									else echo '-'; ?>
								</td>
								<td><?php if(!empty($returneditem['OrderReturn']['quantity']) && !empty($returneditem['OrderItem']['price'])) echo CURRENCY_SYMBOL.$format->money((($returneditem['OrderReturn']['quantity']*$returneditem['OrderItem']['price'])+($returneditem['OrderReturn']['quantity']*$returneditem['OrderItem']['delivery_cost'])),2);?></td>
							</tr>
							<?php } ?> 
							</td></tr></table><?php }?> <tr><td>&nbsp;</td></tr> <?php }?>
							<!-- Legends -->
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>