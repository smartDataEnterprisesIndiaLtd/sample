<?php echo $javascript->link(array('jquery-1.3.2.min','jquery_print'));
// pr($order_details);
?>
<table width="100%">
	<tr><td align="right"><?php echo $html->link($html->image('print_btn.jpeg',array('alt'=>'','style'=>'border:0px')),'javascript:void(0)',array('escape'=>false, 'onClick'=>"jQuery('#printId').jqprint()",/*'onClick'=>"printDiv();",*/'style'=>'border:0px'));?></td></tr>
</table>
<div id="printId">
<table width="800" border="0" cellspacing="0" cellpadding="0" align="center" style="font-family: Arial, Helvetica, sans-serif; font-size:12px;-webkit-text-size-adjust: none;">
	<tr>
		<td style="padding:15px 0; border-bottom:2px #cccccc solid;">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td width="48%"><?php echo $html->image("Choicefullogo.jpg",array('width'=>"150",'height'=>"24",'alt'=>"",'style'=>"border:0;margin-left: 20px;"))?></td>
					<td width="37%" style="font-size:12px;"><label style=" font-weight:bold; width:70px; display:inline-block;font-size:12px;margin-left:1px;">Order ID:</label>
					<?php if(!empty($order_details['Order']['order_number'])) echo '<span style="font-size:12px;">'.$order_details['Order']['order_number'].'</span>'; ?><br />
					<label style="font-weight:bold; width:70px; display:inline-block;font-size:12px; margin-left:1px;"> Order Date:</label>
					<?php if(!empty($order_details['Order']['created'])) echo '<span style="font-size:12px;">'. date('d/m/Y',strtotime($order_details['Order']['created'])).'</span>'; ?></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		 <td style="padding:15px 0; line-height:1.5;">
			<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size:12px;">
				<tr>
					<td valign="top" style="line-height:1.5;" width="45%">
						<div style="padding:0 45px 0 20px;">
						<h4 style="color:#666; border-bottom:2px solid #bbb; font-weight:normal; margin:0 0 15px -10px; padding:0 0 5px 10px;">Shipping Information</h4>
						<span style="font-weight:bold; text-decoration:underline; display:block;line-height:1.5;">Shipping Method</span>
						<?php if(!empty($order_details['Items'])){ $delivery_method = 'Standard';
							foreach($order_details['Items'] as $item){
								if($item['delivery_method'] == 'E'){
									$delivery_method = 'Express';
								}
							}
						}?>
						<?php echo $delivery_method;?> <span style="font-weight:bold; text-decoration:underline; display:block;padding-top:10px;line-height:1.5;">Dispatched to:</span>
						<ul style="display:block; margin:0; padding:0 0 20px 0; list-style:none;line-height:1.5;">
							<li style="line-height:1.5;"> <?php if(!empty($order_details['Order']['shipping_firstname'])) echo $order_details['Order']['shipping_firstname']; ?>  <?php if(!empty($order_details['Order']['shipping_lastname'])) echo $order_details['Order']['shipping_lastname']; ?></li>
							<?php if(!empty($order_details['Order']['shipping_address1'])) { ?><li><?php echo $order_details['Order']['shipping_address1']; ?></li><?php }?>
							<?php if(!empty($order_details['Order']['shipping_address2'])) { ?><li><?php echo $order_details['Order']['shipping_address2']; ?></li><?php }?>
							<?php if(!empty($order_details['Order']['shipping_city'])) { ?><li><?php echo $order_details['Order']['shipping_city']; ?></li><?php }?>
							<?php if(!empty($order_details['Order']['shipping_state'])) { ?><li><?php echo $order_details['Order']['shipping_state']; ?></li><?php }?>
							<?php if(!empty($order_details['Order']['shipping_postal_code'])) { ?><li><?php echo $order_details['Order']['shipping_postal_code']; ?></li><?php }?>
							<?php if(!empty($order_details['Order']['shipping_country'])) { ?><li><?php echo $countries[$order_details['Order']['shipping_country']]; ?></li><?php }?>
							<li>Tel: <?php if(!empty($order_details['Order']['shipping_phone'])) {  echo $order_details['Order']['shipping_phone']; }?></li>
						</ul>
						<h4 style="color:#666; border-bottom:2px solid #bbb; font-weight:normal; font-size:12px; margin:0 0 15px -10px; padding:0 0 5px 10px;line-height:1.5;">Contact Information</h4>
						<span style="font-weight:bold; text-decoration:underline; display:block; font-size:11px; padding:10px 0 2px 0;">E-mail Receipt To:</span> <?php if(!empty($order_details['UserSummary']['email'])) { echo $order_details['UserSummary']['email']; }?>
						</div>
					</td>
					<td valign="top" style="line-height:1.5;" width="37%">
						<div style="padding:0 20px 0 13px;">
						<h4 style="color:#666; border-bottom:2px solid #bbb; font-weight:normal; margin:0 0 15px -11px; padding:0 0 5px 10px">Billing Information</h4>
						<span style="font-weight:bold; text-decoration:underline; display:block;line-height:1.5;">Payment Method</span> <?php if(!empty($order_details['Order']['payment_method'])) echo ucfirst($order_details['Order']['payment_method']); ?> <span style="font-weight:bold; text-decoration:underline; display:block; padding-top:10px;">Bill to:</span>
						<ul style="display:block; margin:0; padding:0; list-style:none;line-height:1.5;">
							<li> <?php if(!empty($order_details['Order']['billing_firstname'])) echo $order_details['Order']['billing_firstname']; ?>  <?php if(!empty($order_details['Order']['billing_lastname'])) echo $order_details['Order']['billing_lastname']; ?></li>
							<?php if(!empty($order_details['Order']['billing_address1'])) { ?><li><?php echo $order_details['Order']['billing_address1']; ?></li><?php }?>
							<?php if(!empty($order_details['Order']['billing_address2'])) { ?><li><?php echo $order_details['Order']['billing_address2']; ?></li><?php }?>
							<?php if(!empty($order_details['Order']['billing_city'])) { ?><li><?php echo $order_details['Order']['billing_city']; ?></li><?php }?>
							<?php if(!empty($order_details['Order']['billing_state'])) { ?><li><?php echo $order_details['Order']['billing_state']; ?></li><?php }?>
							<?php if(!empty($order_details['Order']['billing_postal_code'])) { ?><li><?php echo $order_details['Order']['billing_postal_code']; ?></li><?php }?>
							<?php if(!empty($order_details['Order']['billing_country'])) { ?><li><?php echo $countries[$order_details['Order']['billing_country']]; ?></li><?php }?>
							<li>Tel: <?php if(!empty($order_details['Order']['billing_phone'])) {  echo $order_details['Order']['billing_phone']; } ?></li>
						</ul>
						</div>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<?php if(!empty($order_details['Items'])) { $subtotal = 0; ?>
	<tr>
		<td style="padding:10px 0;">
			<table width="100%" border="1" bordercolor="#bbbbbb" rules="all" frame="box" cellspacing="0" cellpadding="5" style="border-collapse:collapse;font-family:Arial,Helvetica,sans-serif;font-size:12px;">
				<tr>
					<td width="62%"><strong>Products</strong></td>
					<td width="19%" align="center"><strong>Quantity</strong></td>
					<td width="19%" align="center"><strong>Price</strong></td>
				</tr>
				<?php foreach($order_details['Items'] as $item){ ?>
				<tr>
					<td valign="top"><p style="margin:0px; padding:2px 0px;"><?php if(!empty($item['product_name'])) echo $item['product_name'];?></p>
					<p style="margin:0px; padding:2px 0px;"><strong>Sold by:</strong> <?php if(!empty($item['seller_name'])) echo $item['seller_name'];?> <?php //if(!empty($item['SellerSummary']['firstname'])) echo $item['SellerSummary']['firstname'];?> <?php //if(!empty($item['SellerSummary']['lastname'])) echo $item['SellerSummary']['lastname'];?></p></td>
					<td align="center" valign="top"><p style="margin:0px; padding:0px 0 5px;"><?php if(!empty($item['quantity'])) echo $item['quantity'];?></p></td>
					<td valign="top" align="center"><?php if(!empty($item['price'])) echo CURRENCY_SYMBOL.' '.$format->money($item['price'],2);?></td>
				</tr>
				<?php
				$subtotal = $subtotal + ($item['quantity']*$item['price']);
				}?>
			</table>
			<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-family:Arial,Helvetica,sans-serif;font-size:12px;">
				<tr>
					<td colspan="2" style="height:100px;">&nbsp;</td>
				</tr>
				<tr>
					<td style="border-top-color:#BBBBBB;border-top-style:solid;border-top-width:2px;padding-top:10px;width:82%;font-family:Arial,Helvetica,sans-serif;font-size:12px;">Subtotal</td>
					<td align="right" style="padding-top:10px; border-top:2px solid #bbb;font-family:Arial,Helvetica,sans-serif;font-size:12px;"><?php if(!empty($subtotal)) echo CURRENCY_SYMBOL.' '.$format->money($subtotal,2); else echo CURRENCY_SYMBOL.' 0.00';?></td>
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
				<?php  if( $order_details['Order']['dc_amount'] >0  ){
				$order_details['Order']['order_total_cost'] = $format->money(($order_details['Order']['order_total_cost'] - $order_details['Order']['dc_amount']),2);
				?>
				<tr>
					<td>Discount Coupon Amont</td>
					<td align="right" ><?php if(!empty($order_details['Order']['dc_amount'])) echo '-'.CURRENCY_SYMBOL.' '.$format->money($order_details['Order']['dc_amount'],2); else{ echo CURRENCY_SYMBOL.' 0.00'; } ?></td>
				</tr>
				<?php  } ?> 
				<?php  if( $order_details['Order']['gc_amount'] >0  ){
				$order_details['Order']['order_total_cost'] = $format->money(($order_details['Order']['order_total_cost'] - $order_details['Order']['gc_amount']),2);
				?>
				<tr>
					<td>Gift Certificate Amount</td>
					<td align="right" ><?php if(!empty($order_details['Order']['gc_amount'])) echo '-'.CURRENCY_SYMBOL.' '.$format->money($order_details['Order']['gc_amount'],2); else{ echo CURRENCY_SYMBOL.' 0.00'; }?></td>
				</tr>
				<?php  } ?> 
				<tr style="font-weight:bold;">
					<td style="padding:5px 0;">Order Total</td>
					<td align="right" style="border-top:2px solid #ccc; border-bottom:2px solid #ccc;"><?php echo CURRENCY_SYMBOL.' '.$format->money($order_details['Order']['order_total_cost'],2);?></td>
				</tr>
				<tr>
					<td colspan="2" style="padding:15px 0 20px 0;"><label style="font-weight:bold;">Payment Terms:</label>
					&nbsp;&nbsp;<?php if(!empty($order_details['Order']['payment_method'])) { if(ucfirst($order_details['Order']['payment_method'])=="Sage"){ echo "Credit/Debit card"; } else { echo ucfirst($order_details['Order']['payment_method']); } } ?></td>
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
				<tr>
					<td colspan="2" style="padding-top:20px;"><b>Please note:</b> This is not a tax invoice</td>
				</tr>
			</table>
		</td>
	</tr>
	<?php }?>
</table>
</div>