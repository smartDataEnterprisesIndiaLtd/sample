<?php echo $javascript->link(array('jquery-1.3.2.min','jquery_print'));?>
<table width="100%">
	<tr><td align="right"><?php echo $html->link($html->image('print_btn.jpeg',array('alt'=>'','style'=>'border:0px')),'javascript:void(0)',array('escape'=>false, 'onClick'=>"jQuery('#printId').jqprint()",/*'onClick'=>"printDiv();",*/'style'=>'border:0px'));?></td></tr>
</table>
<div id="printId">
<table width="800" border="0" cellspacing="0" cellpadding="0" align="center" style="font-family: Arial, Helvetica, sans-serif; font-size:12px;">
	<tr>
		<td><h3 style="padding:0px; margin:0px 0 10px; font-size:16px;">Deliver  to:</h3>
		<p style="padding:2px 0px; margin:0px;"><strong>
			<?php if((!empty($order_details['Order']['shipping_firstname'])) || (!empty($order_details['Order']['shipping_lastname']))) {
				if((!empty($order_details['Order']['shipping_user_title']))){
					echo ucwords(strtolower($order_details['Order']['shipping_user_title'])).' ';
				}
				if((!empty($order_details['Order']['shipping_firstname']))){
					echo ucwords(strtolower($order_details['Order']['shipping_firstname'])).' ';
				}
				if((!empty($order_details['Order']['shipping_lastname']))){
					echo ucwords(strtolower($order_details['Order']['shipping_lastname'])).' ';
				}
			} else echo '-'; ?>
			</strong></p>
			<p style="padding:2px 0px; margin:0px;"><strong><?php if((!empty($order_details['Order']['shipping_address1']))){
				echo ucwords(strtolower($order_details['Order']['shipping_address1']));
			};?></strong></p>
			<p style="padding:2px 0px; margin:0px;"><strong><?php if((!empty($order_details['Order']['shipping_address2']))){
				echo ucwords(strtolower($order_details['Order']['shipping_address2']));
			};?></strong></p>
			<p style="padding:2px 0px; margin:0px;"><strong><?php if((!empty($order_details['Order']['shipping_city']))){
				echo ucwords(strtolower($order_details['Order']['shipping_city']));
			};?></strong></p>
			<p style="padding:2px 0px; margin:0px;"><strong><?php if((!empty($order_details['Order']['shipping_state']))){
				echo $order_details['Order']['shipping_state'];
			};?></strong></p>
			<p style="padding:2px 0px; margin:0px;"><strong><?php if((!empty($order_details['Order']['shipping_postal_code']))){
				echo ucwords($order_details['Order']['shipping_postal_code']);
			};?></strong></p>
			<p style="padding:2px 0px; margin:0px;"><strong><?php if((!empty($order_details['Order']['shipping_country']))) {
				echo ucwords(strtolower($countries[$order_details['Order']['shipping_country']]));
			};?></strong></p>
			<p style="padding:2px 0px; margin:0px;"><strong><?php if((!empty($order_details['Order']['shipping_phone']))) {
				echo $order_details['Order']['shipping_phone'];
			};?></strong></p>
		</td>
	</tr>
	<tr style="font-family: Arial, Helvetica, sans-serif; font-size:12px;">
		<td style="padding-top:20px;">
			<table width="100%" border="1" bordercolor="#bbbbbb" rules="all" frame="box" cellspacing="0" cellpadding="5" style="border-collapse:collapse;font-family: Arial, Helvetica, sans-serif; font-size:12px;">
				<tr>
					<td width="66%"><strong>Products</strong></td>
					<td width="18%" align="center"><strong>Price</strong></td>
					<td width="16%" align="center"><strong>Total</strong></td>
				</tr>
				<?php if(!empty($order_details['Items'])) {
					$total_order_cost = 0;
					foreach($order_details['Items'] as $od_itms) {
				?>
				<tr>
					<td valign="top"><p style="margin:0px; padding:0px 0 10px;"><?php echo $od_itms['OrderItem']['quantity'];?> <?php echo $od_itms['OrderItem']['product_name'];?></p>
					<p style="margin:0px; padding:2px 0px;"><strong>QCID: </strong> <?php echo $od_itms['OrderItem']['quick_code'];?><strong></strong><br />
					<p style="margin:0px; padding:2px 0px;"><strong>Condition: </strong><?php echo $pro_conditions[$od_itms['OrderItem']['condition_id']];?><strong></strong><br />
					<p style="margin:0px; padding:2px 0px;"><strong>Comments: </strong><br />
					<?php echo $od_itms['ProductSeller']['notes'];?></p></td>
					<td align="center" valign="top"><p style="margin:0px; padding:0px 0 5px;"><?php
					if(empty($od_itms['OrderItem']['giftwrap_cost'])){
						$od_itms['OrderItem']['giftwrap_cost'] = 0;
					}
					echo CURRENCY_SYMBOL.' '.$format->money((($od_itms['OrderItem']['price']*$od_itms['OrderItem']['quantity'])+($od_itms['OrderItem']['giftwrap_cost']*$od_itms['OrderItem']['quantity'])),2)?></p>
					<p style="margin:0px; padding:0px 0 5px;"> +</p>
					<p style="margin:0px; padding:0px 0 5px;"><?php echo CURRENCY_SYMBOL.$format->money(($od_itms['OrderItem']['delivery_cost']*$od_itms['OrderItem']['quantity']),2);?></p></td>
					<td valign="top" align="center"><?php echo CURRENCY_SYMBOL.' '.$format->money((($od_itms['OrderItem']['delivery_cost']*$od_itms['OrderItem']['quantity'])+($od_itms['OrderItem']['price']*$od_itms['OrderItem']['quantity']) + ($od_itms['OrderItem']['giftwrap_cost']*$od_itms['OrderItem']['quantity'])),2);
					$total_order_cost = $total_order_cost + (($od_itms['OrderItem']['delivery_cost']*$od_itms['OrderItem']['quantity'])+($od_itms['OrderItem']['price'] * $od_itms['OrderItem']['quantity']) +  ($od_itms['OrderItem']['giftwrap_cost']*$od_itms['OrderItem']['quantity']));
					?></td>
				</tr>
				<?php } }?>
				<tr>
					<td colspan="3" valign="top" align="right"><strong>Order  Total: <?php echo CURRENCY_SYMBOL.' '.$format->money($total_order_cost,2);?></strong></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr style="font-family: Arial, Helvetica, sans-serif; font-size:12px;">
		<td style="padding-top:15px;">
			<table width="100%" border="1" bordercolor="#bbbbbb" rules="all" frame="box" cellspacing="0" cellpadding="5" style="font-family: Arial, Helvetica, sans-serif; font-size:12px;">
				<tr>
					<td><p style="padding:0 0 5px; margin:0px;"><strong>Order Date:</strong> <?php echo date(FULL_DATE_FORMAT,strtotime($order_details['Order']['created']));?></p>
					<p style="padding:0 0 5px; margin:0px;"><strong>Shipping Service:</strong>
					<?php
					$shiping_services = array();
					foreach($order_details['Items'] as $or_item){
							
						if($or_item['OrderItem']['delivery_method'] == 'E'){
								$shiping_service = 'Express';
							} else {
								$shiping_service = 'Standard';
							}
						$shiping_services[] = $shiping_service;
					}
					echo implode(' , ',array_unique($shiping_services));
					?>
					<?php //if(!empty($order_details['OrderSeller']['shipping_service'])) echo $order_details['OrderSeller']['shipping_service'];?></p>
					<p style="padding:0 0 5px; margin:0px;"><strong>Estimated Delivery:</strong> <?php $estimated_dd = $order_details['Items'][0]['OrderItem']['estimated_delivery_date'];
					$delivery_method = 'Standard';
					if(!empty($order_details['Items'])){
						foreach($order_details['Items'] as $order_item){
							if($order_item['OrderItem']['delivery_method'] == 'E'){
								$estimated_dd = $order_item['OrderItem']['estimated_delivery_date'];
								$delivery_method = 'Express';
							}
						}
					} echo date(FULL_DATE_FORMAT,strtotime($estimated_dd));?></p>
					<p style="padding:0 0 5px; margin:0px;"><strong>Delivery Instructions:</strong> <?php if(!empty($order_details['Order']['comments'])) echo $order_details['Order']['comments'];?></p>
					
					<p style="padding:15px 0 5px; margin:0px;"><strong>Contact
					<?php if(!empty($order_details['Seller']['business_display_name'])) echo $order_details['Seller']['business_display_name'];?>
					<?php //if(!empty($order_details['SellerSummary']['firstname'])) echo $order_details['SellerSummary']['firstname'];?> <?php //if(!empty($order_details['SellerSummary']['lastname'])) echo $order_details['SellerSummary']['lastname'];?></strong></p>
					<p style="padding:0 0 5px; margin:0px;">To  contact the seller visit My Account at www.choiceful.com. In Your Account, go  to the &quot;View Orders&quot; section and click on the link &quot;Contact  Seller&quot; to send a message to the seller. </p>
					<p style="padding:0 0 5px; margin:0px;">You can also leave feedback from Your Account, by selecting the link Leave Seller Feedback.</p>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td style="padding:15px 0;"><p style="margin:0; padding:0px;"><strong>Order ID: <?php if(!empty($order_details['Order']['order_number'])) echo $order_details['Order']['order_number'];?></strong></p>
		<!--<p style="margin:0; padding:0px;">Thank  you for buying from <?php //if(!empty($order_details['SellerSummary']['firstname'])) echo $order_details['SellerSummary']['firstname'];?> <?php //if(!empty($order_details['SellerSummary']['lastname'])) echo $order_details['SellerSummary']['lastname'];?></p></td>-->
		<p style="margin:0; padding:0px;">Thank  you for buying from <?php if(!empty($order_details['Items'][0]['OrderItem']['seller_name'])) echo $order_details['Items'][0]['OrderItem']['seller_name'];?></p></td>
	</tr>
</table>

</div>