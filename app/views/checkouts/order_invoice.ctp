<?php //pr($order_details);?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr><td align="right"><a href="#" onClick="printDiv();">Print</a></td></tr>
</table>
<div id="printId">
<table width="800" border="0" cellspacing="0" cellpadding="0" align="center" style="font-family: Arial, Helvetica, sans-serif; font-size:12px;">
	<tr>
		<td style="padding:15px 0; border-bottom:2px #cccccc solid;">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td width="60%" valign="top"><?php echo $html->image("Choicefullogo.jpg",array('width'=>"150",'height'=>"24",'alt'=>"",'style'=>"border:0;"))?></td>
					<td width="40%" valign="top"><label style=" font-weight:bold; width:200px; display:inline-block;">Choiceful.com Order ID:</label>
					<?php if(!empty($order_details['Order']['order_number'])) echo $order_details['Order']['order_number']; ?><br />
					<label style="font-weight:bold; width:170px; display:inline-block;"> Order Date:</label>
					<?php if(!empty($order_details['Order']['created'])) echo date('m/d/Y',strtotime($order_details['Order']['created'])); ?></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td style="padding:15px 20px; line-height:1.5;">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td valign="top" style="padding-right:45px;">
						<h4 style="color:#666; border-bottom:2px solid #bbb; font-weight:normal; margin:0 0 15px -10px; padding:0 0 5px 10px;">Shipping Information</h4>
						<span style="font-weight:bold; text-decoration:underline; display:block;">Shipping Method</span>
						<?php if(!empty($order_details['Items'])){ $delivery_method = 'Standard';
							foreach($order_details['Items'] as $item){
								if($item['delivery_method'] == 'E'){
									$delivery_method = 'Express';
								}
							}
						}?>


						 <?php echo $delivery_method;?> <span style="font-weight:bold; text-decoration:underline; display:block;padding-top:10px;">Dispatched to:</span>
						<ul style="display:block; margin:0; padding:0 0 20px 0; list-style:none;">
							<li>Dear <?php if(!empty($order_details['Order']['shipping_firstname'])) echo $order_details['Order']['shipping_firstname']; ?>  <?php if(!empty($order_details['Order']['shipping_lastname'])) echo $order_details['Order']['shipping_lastname']; ?></li>
							<?php if(!empty($order_details['Order']['shipping_address1'])) { ?><li><?php echo $order_details['Order']['shipping_address1']; ?></li><?php }?>
							<?php if(!empty($order_details['Order']['shipping_address2'])) { ?><li><?php echo $order_details['Order']['shipping_address2']; ?></li><?php }?>
							<?php if(!empty($order_details['Order']['shipping_city'])) { ?><li><?php echo $order_details['Order']['shipping_city']; ?></li><?php }?>
							<?php if(!empty($order_details['Order']['shipping_state'])) { ?><li><?php echo $order_details['Order']['shipping_state']; ?></li><?php }?>
							<?php if(!empty($order_details['Order']['shipping_postal_code'])) { ?><li><?php echo $order_details['Order']['shipping_postal_code']; ?></li><?php }?>
							<?php if(!empty($order_details['Order']['shipping_country'])) { ?><li><?php echo $countries[$order_details['Order']['shipping_country']]; ?></li><?php }?>
							<li>Tel: <?php if(!empty($order_details['Order']['shipping_phone'])) {  echo $order_details['Order']['shipping_phone']; }?></li>
						</ul>
						<h4 style="color:#666; border-bottom:2px solid #bbb; font-weight:normal; font-size:12px; margin:0 0 15px -10px; padding:0 0 5px 10px">Contact Information</h4>
						<span style="font-weight:bold; text-decoration:underline; display:block; font-size:11px; padding:10px 0 2px 0;">E-mail Receipt To:</span> <?php if(!empty($order_details['UserSummary']['email'])) { echo $order_details['UserSummary']['email']; }?>
					</td>
					<td valign="top" style="padding-left:45px;">
						<h4 style="color:#666; border-bottom:2px solid #bbb; font-weight:normal; margin:0 0 15px -10px; padding:0 0 5px 10px">Billing Information</h4>
						<span style="font-weight:bold; text-decoration:underline; display:block;">Payment Method</span> <?php if(!empty($order_details['Order']['payment_method'])) echo ucfirst($order_details['Order']['payment_method']); ?> <span style="font-weight:bold; text-decoration:underline; display:block; padding-top:10px;">Bill to:</span>
						<ul style="display:block; margin:0; padding:0; list-style:none;">
							<li>Dear <?php if(!empty($order_details['Order']['billing_firstname'])) echo $order_details['Order']['billing_firstname']; ?>  <?php if(!empty($order_details['Order']['billing_lastname'])) echo $order_details['Order']['billing_lastname']; ?></li>
							<?php if(!empty($order_details['Order']['billing_address1'])) { ?><li><?php echo $order_details['Order']['billing_address1']; ?></li><?php }?>
							<?php if(!empty($order_details['Order']['billing_address2'])) { ?><li><?php echo $order_details['Order']['billing_address2']; ?></li><?php }?>
							<?php if(!empty($order_details['Order']['billing_city'])) { ?><li><?php echo $order_details['Order']['billing_city']; ?></li><?php }?>
							<?php if(!empty($order_details['Order']['billing_state'])) { ?><li><?php echo $order_details['Order']['billing_state']; ?></li><?php }?>
							<?php if(!empty($order_details['Order']['billing_postal_code'])) { ?><li><?php echo $order_details['Order']['billing_postal_code']; ?></li><?php }?>
							<?php if(!empty($order_details['Order']['billing_country'])) { ?><li><?php echo $countries[$order_details['Order']['billing_country']]; ?></li><?php }?>
							<li>Tel: <?php if(!empty($order_details['Order']['billing_phone'])) {  echo $order_details['Order']['billing_phone']; } ?></li>
						</ul>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<?php if(!empty($order_details['Items'])) { $subtotal = 0; ?>
	<tr>
		<td style="padding:10px 0;">
			<table width="100%" border="1" bordercolor="#bbbbbb" rules="all" frame="box" cellspacing="0" cellpadding="5" style="border-collapse:collapse;">
				<tr>
					<td width="62%"><strong>Products</strong></td>
					<td width="19%" align="center"><strong>Quantity</strong></td>
					<td width="19%" align="center"><strong>Price</strong></td>
				</tr>
				<?php foreach($order_details['Items'] as $item){ //pr($item);?>
				<tr>
					<td valign="top"><p style="margin:0px; padding:2px 0px;"><?php if(!empty($item['product_name'])) echo $item['product_name'];?></p>
					<p style="margin:0px; padding:2px 0px;"><strong>Sold by:</strong> <?php if(!empty($item['SellerSummary']['firstname'])) echo $item['SellerSummary']['firstname'];?> <?php if(!empty($item['SellerSummary']['lastname'])) echo $item['SellerSummary']['lastname'];?></p></td>
					<td align="center" valign="top"><p style="margin:0px; padding:0px 0 5px;"><?php if(!empty($item['quantity'])) echo $item['quantity'];?></p></td>
					<td valign="top" align="center"><?php if(!empty($item['price'])) echo CURRENCY_SYMBOL.' '.$format->money($item['price'],2);?></td>
				</tr>
				<?php
				$subtotal = $subtotal + ($item['quantity']*$item['price']);
				}?>
			</table>
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td colspan="2" style="height:100px;">&nbsp;</td>
				</tr>
				<tr>
					<td style="padding-top:10px; border-top:2px solid #bbb; width:82%;">Subtotal</td>
					<td align="right" style="padding-top:10px; border-top:2px solid #bbb;"><?php if(!empty($subtotal)) echo CURRENCY_SYMBOL.' '.$format->money($subtotal,2); else echo CURRENCY_SYMBOL.' 0.00';?></td>
				</tr>
				<tr>
					<td >Delivery</td>
					<td align="right"  ><?php if(!empty($order_details['Order']['shipping_total_cost'])) echo CURRENCY_SYMBOL.' '.$format->money($order_details['Order']['shipping_total_cost'],2); else{ echo CURRENCY_SYMBOL.' 0.00';}?></td>
				</tr>
				<?php  if( $order_details['Order']['giftwrap_total_cost'] > 0 ){ ?>
				<tr>
					<td >Giftwrap Charges</td>
					<td align="right"><?php if(!empty($order_details['Order']['giftwrap_total_cost'])) echo CURRENCY_SYMBOL.' '.$format->money($order_details['Order']['giftwrap_total_cost'],2); else{ echo CURRENCY_SYMBOL.' 0.00'; }?></td>
				</tr>
				<?php  } ?>
				<?php  if( $order_details['Order']['insurance_amount'] >0  ){ ?>
				<tr>
					<td >Insurance</td>
					<td align="right" ><?php if(!empty($order_details['Order']['insurance_amount'])) echo CURRENCY_SYMBOL.' '.$format->money($order_details['Order']['insurance_amount'],2); else{ echo CURRENCY_SYMBOL.' 0.00'; }?></td>
				</tr>
				<?php  } ?>
				
				<?php  if( $order_details['Order']['gc_amount'] >0  ){ ?>
				<tr>
					<td >Gift Balance</td>
					<td align="right" >-<?php echo CURRENCY_SYMBOL.' '.$format->money($order_details['Order']['gc_amount'],2); ?></td>
				</tr>
				<?php  } ?>
				<?php  if( $order_details['Order']['dc_amount'] >0  ){ ?>
				<tr>
					<td >Discount Coupon</td>
					<td align="right" >-<?php echo CURRENCY_SYMBOL.' '.$format->money($order_details['Order']['dc_amount'],2); ?></td>
				</tr>
				<?php  } ?>
				<tr>
					<td >Vat</td>
					<td align="right" ><?php echo CURRENCY_SYMBOL.' '.$format->money($order_details['Order']['tax_amount'],2); ?></td>
				</tr>
				<tr style="font-weight:bold;">
					<td style="padding:5px 0;">Order Total</td>
					<td align="right" style="border-top:2px solid #ccc; border-bottom:2px solid #ccc;"><?php echo CURRENCY_SYMBOL.' '.$format->money($order_details['Order']['order_total_cost'],2);?></td>
				</tr>
				<tr>
					<td colspan="2" style="padding:15px 0 20px 0;"><label style="font-weight:bold;">Payment Terms:</label>
					&nbsp;&nbsp;<?php if(!empty($order_details['Order']['payment_method'])) echo ucfirst($order_details['Order']['payment_method']); ?></td>
				</tr>
				<tr style="font-weight:bold;">
					<td colspan="2" style="padding-top:10px; border-top:2px solid #bbb;">Remarks</td>
				</tr>
				<tr style="font-weight:bold;">
					<td colspan="2" style="padding:20px 0;">Thank you for shopping at Choiceful.com<br />
					Please print this page for your records </td>
				</tr>
				<tr style="font-weight:bold;">
					<td colspan="2"><a href="online@choiceful.com">online@choiceful.com</a></td>
				</tr>
				
			</table>
		</td>
	</tr>
	<?php }?>
</table>

</div>
<script language="JavaScript">
function printDiv(){
	var divToPrint=document.getElementById('printId');
	var newWin=window.open('printwindow','Print-Window','width=100,height=100');
	newWin.document.open();
	newWin.document.write('<html><body onload="window.print()">'+divToPrint.innerHTML+'</body></html>');
	newWin.document.close();
	setTimeout(function(){newWin.close();},10);
}
</script>