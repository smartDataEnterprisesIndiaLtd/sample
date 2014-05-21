<?php echo $javascript->link(array('behaviour.js','textarea_maxlen'));
?>
<!--mid Content Start-->
<div class="mid-content pad-rt-none">
	<!--Setting Tabs Widget Start-->
	<div class="row">
	<!--- <?php //echo $this->element('marketplace/breadcrum'); ?> --->
		<?php echo $this->element('navigations/seller_heading_bar'); ?>
		<!--Tabs Content Start-->
		<div class="tabs-content">
			<!--Discription Start-->
			<div class="inner-content">
				<p>Available options on an order.</p>
			</div>
			<!--Discription Closed-->
		</div>
		<!--Tabs Content Closed-->
	</div>
	<!--Setting Tabs Widget Closed-->
</div>
<!--mid Content Closed-->

<?php
if ($session->check('Message.flash')){ ?>
	<div class="messageBlock" style="width:97%;">
		<?php echo $session->flash();?>
	</div>
<?php } ?>
<!--Search Results Start-->
<div class="search-results-widget" style="overflow:visible;">
	<!--Paging Widget Start-->
	<div class="search-paging border-botom-none">
		<ul style="width: 100%;">
			<li><h2>Order: <?php echo $order_details['Order']['order_number'];?></h2></li>
		</ul>
	</div>
	<!--Paging Widget Closed-->
	<!--Search Products Start-->
	<div class="scroll-div" style="border:none;">
		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="seller-listings ordered-listing border-bottom">
			<tr>
				<td width="12%" rowspan="<?php echo (count($order_details['Items'])+2);?>" align="left" valign="top" class="border-botom-none">
					<p><?php echo date(ORDER_DATE_FORMAT,strtotime($order_details['Order']['created']));?></p>
				</td>
				<td colspan="7" align="left" style="padding:0px; border:none;">
					<table width="100%" cellspacing="0" cellpadding="0">
						<tr>
							<td width="32%" valign="top">
								<?php echo $this->element('seller/order_shippingaddress'); ?>
							</td>
							<td width="26%" valign="top" >
								<?php echo $this->element('seller/order_shipdetails'); ?>
							</td>
							<td width="42%" valign="top" class="last">
								<?php echo $this->element('seller/print_payment_slip');?> 
								<?php
								if($editorder == 'edit'){
									if($order_details['OrderSeller']['shipping_status'] == 'Cancelled' || $order_details['OrderSeller']['shipping_status'] == 'Shipped' ) {
										//echo $html->image('ship-order-btn_disabled.png',array('alt'=>"", 'class'=>"v-align-middle"));
									} else{
										echo  $html->link($html->image('edit-shipping.png',array('alt'=>"", 'class'=>"v-align-middle")),'/sellers/ship_order/'.base64_encode($order_details['OrderSeller']['order_id']),array('escape'=>false));
									}
									?> 
									<?php
									if($order_details['OrderSeller']['shipping_status'] == 'Shipped' || $order_details['OrderSeller']['shipping_status'] == 'Part Shipped') {
										echo $html->link($html->image('refund-customer.png',array('alt'=>"", 'class'=>"v-align-middle")),'/sellers/refund_order/'.base64_encode($order_details['OrderSeller']['order_id']),array('escape'=>false));
									} else {
										
									}
								} else{
									if($order_details['OrderSeller']['shipping_status'] == 'Cancelled' || $order_details['OrderSeller']['shipping_status'] == 'Shipped' ) {
										
									} else if($order_details['OrderSeller']['shipping_status'] == 'Part Shipped') {
										echo $html->link($html->image('edit-shipping.png',array('alt'=>"", 'class'=>"v-align-middle")),'/sellers/ship_order/'.base64_encode($order_details['OrderSeller']['order_id']).'/'.base64_encode('edit'),array('escape'=>false));
										//With the REF #E1402
										echo'&nbsp;&nbsp;';
										echo $html->link($html->image('refund-customer.png',array('alt'=>"", 'class'=>"v-align-middle")),'/sellers/refund_order/'.base64_encode($order_details['OrderSeller']['order_id']),array('escape'=>false));
									} else{
										echo $html->link($html->image('ship-order-btn.png',array('width'=>"75", 'height'=>"17", 'alt'=>"", 'class'=>"v-align-middle")),'/sellers/ship_order/'.base64_encode($order_details['OrderSeller']['order_id']),array('escape'=>false));
										
										//With the REF #E1324
										echo'&nbsp;&nbsp;';
										echo $html->link($html->image('cancel-order-btn.png',array('alt'=>"", 'class'=>"v-align-middle")),'/sellers/cancel_order/'.base64_encode($order_details['OrderSeller']['order_id']),array('escape'=>false));
									}
								}?>
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
			<?php
			if(!empty($order_details['Items'])) {
			$total_order_cost = 0;
			foreach($order_details['Items'] as $od_itms) {
			?>
			<tr>
				<td align="left" class="border-top-botom-none padd-bottom">
					<p><?php echo $html->link($od_itms['OrderItem']['product_name'],"/".$this->Common->getProductUrl($od_itms['OrderItem']['product_id'])."/categories/productdetail/".$od_itms['OrderItem']['product_id'],array('escape'=>false,'class'=>''));?></p>
					<p class="gray"><strong>Condition:</strong> <?php echo $pro_conditions[$od_itms['OrderItem']['condition_id']];?></p>
					<p class="gray"><strong>Comments:</strong> <?php echo $od_itms['ProductSeller']['notes'];?></p>
					<p><strong>Your Code:</strong> <?php echo $od_itms['ProductSeller']['reference_code'];?></p>
					<p><strong>QuickCode:</strong> <span class="gray"><?php echo $od_itms['OrderItem']['quick_code'];?></span></p>
				</td>
				<td valign="top" class="border-top-botom-none padd-bottom"><?php echo $od_itms['OrderItem']['quantity'];?></td>
				<td valign="top" class="border-top-botom-none padd-bottom"><?php $dis_quantity = 0;
				/* commented by nakul on 22-06-2012 dispatched items is not display correct.*/
				/*if(!empty($order_details['Dispatched_Items'])){
					foreach($order_details['Dispatched_Items'] as $dispatched_items){
						if(!empty($dispatched_items['DispatchedItem']['quantity'])){
							$dis_quantity = $dis_quantity + $dispatched_items['DispatchedItem']['quantity'];
						}
					}
				}*/
				//pr($od_itms['DispatchedItem']);
				if(!empty($od_itms['DispatchedItem'])){
					foreach($od_itms['DispatchedItem'] as $dispatched_items){
						if(!empty($dispatched_items['quantity'])){
							$dis_quantity = $dis_quantity + $dispatched_items['quantity'];
						}
					}
				}
				echo $dis_quantity;
				?>
				</td>
				<td valign="top" class="border-top-botom-none padd-bottom"><?php echo CURRENCY_SYMBOL.' '.$format->money($od_itms['OrderItem']['price'],2);?></td>
				<td valign="top" class="border-top-botom-none padd-bottom"><?php echo CURRENCY_SYMBOL.' '.$format->money($od_itms['OrderItem']['delivery_cost'],2);?></td>
				<td valign="top" class="border-top-botom-none padd-bottom"><?php echo CURRENCY_SYMBOL.' '.$format->money($od_itms['OrderItem']['giftwrap_cost'],2);?></td>
				<td valign="top" class="last border-top-botom-none padd-bottom"><?php echo CURRENCY_SYMBOL.' '.$format->money((($od_itms['OrderItem']['delivery_cost']*$od_itms['OrderItem']['quantity'])+($od_itms['OrderItem']['price']*$od_itms['OrderItem']['quantity'])+($od_itms['OrderItem']['giftwrap_cost']*$od_itms['OrderItem']['quantity'])),2);
				$total_order_cost = round(($total_order_cost + ($od_itms['OrderItem']['delivery_cost']*$od_itms['OrderItem']['quantity'])+($od_itms['OrderItem']['price'] * $od_itms['OrderItem']['quantity'])+($od_itms['OrderItem']['giftwrap_cost']*$od_itms['OrderItem']['quantity'])),2);
				?></td>
			</tr>
			<?php }
			}?>
		</table>
		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="total-widget">
			<tr>
				<td align="right" class="border-none"><strong>Total Charged to Customer</strong></td>
				<td valign="top" class="last" width="58" align="center"><?php echo CURRENCY_SYMBOL.' '.$format->money($total_order_cost,2);?></td>
			</tr>
		</table>
	</div>
	<!--Search Products Closed-->
</div>
<!--Search Results Closed-->

<?php echo $this->element('seller/order_item_shipmentdetails');?>
<?php echo $this->element('seller/seller_order_feedback');?>

<!--Seller Note Widget Start-->

<div class="seller-note-widget" id="seller_note">
	<?php echo $this->element('seller/seller_note');?>
	<!--REF #I1474-->
	<?php if(!empty($order_details['Refunds'])){ ?>
	<div class="border previous-refunds">
		<h5 class="gray-heading">Previous Refunds</h5>
		<div class="pdng">
			<?php foreach($order_details['Refunds'] as $refund){ ?>
			<p><?php if(!empty($refund['OrderRefund']['created'])) echo date('d-m-Y',strtotime($refund['OrderRefund']['created'])); else echo '-';?> <span class="pad-left">Refund - <?php if(!empty($refund['OrderRefund']['amount'])) echo CURRENCY_SYMBOL.$format->money($refund['OrderRefund']['amount'],2); else echo '-';?></span></p>
			<?php }?>
		</div>
	</div>
	<?php }?>
	<!--END REF #I1474-->
</div>
<div id="plsLoaderID" style="display:none" class="dimmer"><?php echo $html->image("loading.gif",array('alt'=>"Loading" ));?></div>
<!--Seller Note Widget Closed-->