<?php echo $javascript->link(array('jquery')); ?>
<script>
jQuery(document).ready(function()  {
	//disable submit button after one click
	jQuery('#clickOnce').click(function(){
		if(jQuery("#CancelOrderReason").val() != "")
		{
			jQuery('#frmOrderSellerShipping').submit();
			jQuery("#clickOnce").attr("disabled", "true");
			
		}
	});
});
</script>
<style>
#calendarDiv{
	margin-left:-192px;
}
</style>
<!--Paging Widget Start-->
<div class="search-paging border-botom-none">
	<ul style="width:100%">
		<li><h2>Order: <?php echo $order_details['Order']['order_number'];?></h2></li>
	</ul>
</div>
<!--Paging Widget Closed-->
<!--Search Products Start-->
<?php echo $form->create('Seller',array('action'=>'ship_order_edit/'.base64_encode($order_id).'/'.base64_encode($editorder).'/'.base64_encode('shipment'),'method'=>'POST','name'=>'frmOrderSellerShipping','id'=>'frmOrderSellerShipping'));?>
<div class="scroll-div" style="border:none;">
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="seller-listings ordered-listing border-bottom">
		<tr>
			<td width="12%" rowspan="<?php echo (count($order_details['Items'])+2);?>" align="left" valign="top" class="border-botom-none">
				<p><?php echo date(ORDER_DATE_FORMAT,strtotime($order_details['Order']['created']));?></p>
			</td>
			<td colspan="7" align="left" style="padding:0px; border:none;">
				<table width="100%" cellspacing="0" cellpadding="0">
					<tr>
						<td width="36%" valign="top">
							<?php echo $this->element('seller/order_shippingaddress'); ?>
						</td>
						<td valign="top" width="26%" >
							<?php echo $this->element('seller/order_shipdetails'); ?>
						</td>
						<td width="42%" valign="top" class="last">
							<?php echo $this->element('seller/print_payment_slip');?> 
							<?php  if($order_details['OrderSeller']['shipping_status'] == 'Unshipped') {
								echo $html->link($html->image('cancel-order-btn.png',array('alt'=>"", 'class'=>"v-align-middle")),'/sellers/cancel_order/'.base64_encode($order_details['OrderSeller']['order_id'].'/'.base64_encode('shipment')),array('escape'=>false));
							}
							if($editorder == 'edit'){ 
								echo $html->link($html->image('refund-customer.png',array('alt'=>"", 'class'=>"v-align-middle")),'/sellers/refund_order/'.base64_encode($order_details['OrderSeller']['order_id']),array('escape'=>false));
							}?>
							<table cellspacing="0" cellpadding="0" border="0" width="100%" class="ship-order-widget">
								<tbody>
									<?php //pr($shipment_number_list);
									if($editorder == 'edit'){
									?>
									<tr>
										<td align="right" valign="top"></td>
										<td>
											<?php echo $form->select('OrderSeller.shipment_number',$shipment_number_list,null,array('type'=>'select','class'=>'form-select smallr-width','maxlength'=>63,'error'=>true),'Add New Shipment');
											//$options = array('url' => '/sellers/edit_shipment_info/'.$order_id.'/'.$editorder,'update' => 'OrderInformation',"indicator"=>"plsLoaderID",'loading'=>"Element.show('plsLoaderID')","complete"=>"Element.hide('plsLoaderID')");
											$options = array('url' => '/sellers/edit_shipment_info/'.$order_id.'/'.$editorder,'update' => 'OrderInformation',"indicator"=>"plsLoaderID",'loading'=>"showloading()","complete"=>"hideloading()");
											echo $ajax->observeField('OrderSellerShipmentNumber', $options);?>
										</td>
									</tr>
									<?php }?>
									<tr>
										<td align="right" valign="top" class="red-color"><div style="padding-top: 3px;"><strong>Ship Date:</strong></div></td>
										<td>
											<?php if(!empty($errors['shipping_date'])){
												$errorShippingDate='form-textfield smallr-width error_message_box';
											}else{
												$errorShippingDate='form-textfield smallr-width';
											} ?>
											<?php
											//echo $form->input('OrderSeller.shipping_date',array('class'=>'form-textfield smallr-width','type'=>'text','readonly'=>'readonly','size'=>'15','label'=>false,'onFocus'=>"displayCalendar(document.frmOrderSellerShipping.OrderSellerShippingDate,'dd-mm-yyyy',this)",'div'=>false,'error'=>true));
											//echo $form->input('OrderSeller.id',array('value'=>$order_details['OrderSeller']['id']));
											//if(!empty($errors['shipping_date'])) echo '<div class="error-message">'.$errors['shipping_date'].'</div>';
											echo $form->input('OrderSeller.shipping_date',array('class'=>$errorShippingDate,'type'=>'text','value'=>@$ship_date_err,'readonly'=>'readonly','size'=>'15','label'=>false,'div'=>false,'error'=>true,'style'=>'width:129px;'));
											echo $html->image('cal.gif',array('alt'=>"", 'class'=>"v-align-middle calender",'onClick'=>"displayCalendar(document.frmOrderSellerShipping.OrderSellerShippingDate,'dd-mm-yyyy',this)"));
											echo $form->input('OrderSeller.id',array('value'=>$order_details['OrderSeller']['id']));
											
											?>
											
										</td>
									</tr>
									<tr>
										<td align="right" valign="top" class="red-color"><div style="padding-top: 3px;"><strong>Carrier:</strong></div></td>
										<td valign="top" class="red-color">
											<?php echo $form->select('OrderSeller.shipping_carrier',$carriers,null,array('type'=>'select','onChange'=>'enter_carrier(this.value);','class'=>'form-select','maxlength'=>63,'error'=>true),'Select a carrier');?>
											<?php if($this->data['OrderSeller']['shipping_carrier'] == 8 || $this->data['OrderSeller']['shipping_carrier'] == 9){
												$display = 'block';
											} else { $display = 'none';} ?>
											<div id="othercarrier" style="display:<?php echo $display; ?>;padding-top:3px;">
											<?php echo $form->input('OrderSeller.other_carrier',array('class'=>'form-textfield smallr-width','label'=>false,'div'=>false)); ?>
											</div><?php
												if(!empty($errors['shipping_carrier'])) echo '<div class="error-message">'.$errors['shipping_carrier'].'</div>'; ?>
											</td>
									</tr>
									<tr>
										<td align="right" valign="top" class="red-color"><div style="padding-top: 3px;"><strong>Shipping Service:</strong></div></td>
										<td>
											<?php echo $form->input('OrderSeller.shipping_service',array('class'=>'form-textfield smallr-width','label'=>false,'div'=>false,'maxlength'=>63));
											if(!empty($errors['shipping_service'])) echo '<div class="error-message">'.$errors['shipping_service'].'</div>'; ?>
												
										</td>
									</tr>
									<tr>
										<td align="right" valign="top"><div style="padding-top: 3px;"><strong>Tracking ID:</strong></div></td>
										<td>
										<?php echo $form->input('OrderSeller.trackingId',array('class'=>'form-textfield smallr-width','label'=>false,'div'=>false,'maxlength'=>63)); ?>
										</td>
									</tr>
									<tr>
										<td align="right" colspan="2" class="red-color">
											<?php
											if($editorder == 'edit'){
												echo $form->submit('save-btn_yellow.png',array('type'=>'image','class'=>'v-align-middle','div'=>false));
											} else {
												echo $form->submit('ship-order-btn.png',array('type'=>'image','class'=>'v-align-middle','div'=>false));
											}?>
										</td>
									</tr>
								</tbody>
							</table>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr class="gray-bg">
			<td align="left" class="border-top-botom-none"><strong>Product Details</strong></td>
			<td width="115" class="border-top-botom-none"><strong>Quantity Ordered</strong></td>
			<td width="115" class="border-top-botom-none"><strong>Quantity Shipped</strong></td>
			<td width="58" class="border-top-botom-none"><strong>Price</strong></td>
			<td width="58" class="border-top-botom-none"><strong>Delivery</strong></td>
				<td width="58" class="border-top-botom-none"><strong>Giftwrap</strong></td>
			<td width="58" class="border-top-botom-none last"><strong>Subtotal</strong></td>
		</tr>
			<?php if(!empty($order_details['Items'])) {
		$total_order_cost = 0;
		foreach($order_details['Items'] as $od_itms) {
		?>
		<tr>
			<td align="left" class="border-top-botom-none padd-bottom">
				<p><?php echo $od_itms['OrderItem']['product_name'];?></p>
				<p class="gray"><strong>Condition:</strong> <?php echo $pro_conditions[$od_itms['OrderItem']['condition_id']];?></p>
				<p class="gray"><strong>Comments:</strong> <?php echo $od_itms['ProductSeller']['notes'];?></p>
				<p><strong>Your Code:</strong> <?php echo $od_itms['ProductSeller']['reference_code'];?></p>
				<p><strong>QuickCode:</strong> <span class="gray"><?php echo $od_itms['OrderItem']['quick_code'];?></span></p>
			</td>
			<td valign="top" class="border-top-botom-none padd-bottom"><?php echo $od_itms['OrderItem']['quantity'];?></td>
			<td valign="top" class="border-top-botom-none padd-bottom"><?php
				if(!empty($ship_item_qty_list[$od_itms['OrderItem']['id']]))
					$dis_quantity = $ship_item_qty_list[$od_itms['OrderItem']['id']];
				else
					$dis_quantity = 0;
					
				if(!empty($cancel_item_qty_list[$od_itms['OrderItem']['id']]))
					$canceled_quantity = $cancel_item_qty_list[$od_itms['OrderItem']['id']];
				else
					$canceled_quantity = 0;
			$remaining_qty_toship = $od_itms['OrderItem']['quantity'] - $dis_quantity - $canceled_quantity;
			if($remaining_qty_toship > 0){
			?>
			<?php
				echo $form->select('OrderSeller.Items.'.$od_itms['OrderItem']['id'].'.dispatch_qty',array_combine(range(1,$remaining_qty_toship),range(1,$remaining_qty_toship)),null,array('type'=>'select','class'=>'form-select width-auto'),'0');

				echo $form->hidden('OrderSeller.Items.'.$od_itms['OrderItem']['id'].'.total_ordered_qty',array('value'=>$od_itms['OrderItem']['quantity']));
				echo '<br>';
			}
			echo 'Total shipped: '.$dis_quantity.'<br>Total cancelled: '.$canceled_quantity;
			?></td>
			<td valign="top" class="border-top-botom-none padd-bottom"><?php echo CURRENCY_SYMBOL.' '.$format->money($od_itms['OrderItem']['price'],2);?></td>
			<td valign="top" class="border-top-botom-none padd-bottom"><?php echo CURRENCY_SYMBOL.' '.$format->money($od_itms['OrderItem']['delivery_cost'],2);?></td>
			<td valign="top" class="border-top-botom-none padd-bottom"><?php echo CURRENCY_SYMBOL.' '.$format->money($od_itms['OrderItem']['giftwrap_cost'],2);?></td>
			<td valign="top" class="last border-top-botom-none padd-bottom"><?php echo CURRENCY_SYMBOL.' '.$format->money((($od_itms['OrderItem']['delivery_cost']*$od_itms['OrderItem']['quantity'])+($od_itms['OrderItem']['price']*$od_itms['OrderItem']['quantity'])+($od_itms['OrderItem']['giftwrap_cost']*$od_itms['OrderItem']['quantity'])),2);
				
			$total_order_cost = $total_order_cost + ($od_itms['OrderItem']['delivery_cost']*$od_itms['OrderItem']['quantity'])+($od_itms['OrderItem']['price'] * $od_itms['OrderItem']['quantity'])+($od_itms['OrderItem']['giftwrap_cost']*$od_itms['OrderItem']['quantity']);
			?></td>
		</tr>
		<?php }}?>
	</table>
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="total-widget">
		<tr>
			<td align="right" class="border-none"><strong>Total Charged to Customer</strong></td>
			<td valign="top" class="last" width="58" align="center"><?php echo CURRENCY_SYMBOL.' '.$format->money($total_order_cost,2);?></td>
		</tr>
	</table>
</div>
<!--Search Products Closed-->
<?php echo $form->end(); ?>