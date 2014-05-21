<?php
echo $html->css('dhtmlgoodies_calendar.css');
e($html->script('dhtmlgoodies_calendar.js'));
e($html->script(array('behaviour.js','textarea_maxlen')));
?>
<!--mid Content Start-->
<!--mid Content Start-->
<div class="mid-content pad-rt-none">
	<div class="row">
		<!--Setting Tabs Widget Start-->
	<!---<?php //echo $this->element('marketplace/breadcrum'); ?> --->
		<!--Setting Tabs Widget Start-->
		<!--Tabs Widget Start-->
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
		<div class="messageBlock">
			<?php echo $session->flash();?>
		</div>
	<?php } ?>
		
<?php   //For Auto Redirection
	$successUpdate = $this->Session->read('successUpdate');
	if(isset($successUpdate)){
		$this->Session->delete('successUpdate');
		?>
	<script>
		var count = 5;
		var counter = document.getElementById('counter');
		
		setInterval(function(){
			count--;
			if(count > 0){
				counter.innerHTML = count;
			}
			if (count == 0) {
				window.location = '/sellers/orders';
			}
		}, 1000);
	</script>	
<?php } //End auto redirection ?>
		
	<?php
		if(!empty($errors)){	
		    $error_meaasge="Please add some information in the mandatory fields highlighted red below.";
        	?>
        		<div class="error_msg_box"> 
        			<?php echo $error_meaasge;?>
			</div>
            <?php }?>
<!--Search Results Start-->
<div class="search-results-widget" style="overflow:visible;">
	<!--Paging Widget Start-->
	<div class="search-paging border-botom-none" style="position: relative;">
		<ul style="width:100%">
			<li><h2>Order: <?php echo $order_details['Order']['order_number'];?></h2></li>
		</ul>
	</div>
	<!--Paging Widget Closed-->
	<!--Search Products Start-->
	<?php echo $form->create('Seller',array('action'=>'cancel_orderitems/'.base64_encode($order_id),'method'=>'POST','name'=>'frmOrderSellerShipping','id'=>'frmOrderSellerShipping'));?>
	<div class="scroll-div" style="border:none;">
		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="seller-listings ordered-listing border-bottom">
			<tr>
				<td width="12%" rowspan="11" align="left" valign="top" class="border-botom-none">
					<p><?php echo date(ORDER_DATE_FORMAT,strtotime($order_details['Order']['created']));?></p>
				</td>
				<td colspan="7" align="left" style="padding:0px; border:none;">
					<table width="100%" cellspacing="0" cellpadding="0">
						<tr>
							<td width="32%" valign="top">
								<?php echo $this->element('seller/order_shippingaddress'); ?>
							</td>
							<td valign="top" width="26%" >
								<?php echo $this->element('seller/order_shipdetails'); ?>
							</td>
							<td width="42%" valign="top" class="last">
								<?php echo $this->element('seller/print_payment_slip');?> 
								<?php  if($order_details['OrderSeller']['shipping_status'] != 'Unshipped') {
									//REF TO E1525
									echo $html->link($html->image('edit-shipping.png',array('alt'=>"", 'class'=>"v-align-middle")),'/sellers/ship_order/'.base64_encode($order_details['OrderSeller']['order_id']).'/'.base64_encode('edit'),array('escape'=>false,'style'=>"margin-right: 5px;"));
									echo $html->link($html->image('refund-customer.png',array('alt'=>"", 'class'=>"v-align-middle")),'/sellers/refund_order/'.base64_encode($order_details['OrderSeller']['order_id']),array('escape'=>false));
								} else{
									//echo $html->image('cancel-order-bt_disabledn.png',array('alt'=>"", 'class'=>"v-align-middle"));
								}
								
								if(($order_details['OrderSeller']['shipping_status'] != 'Cancelled')) { ?>
								<table cellspacing="0" cellpadding="0" border="0" width="100%" class="ship-order-widget">
									<tbody>
									<tr>
										<td colspan="2" style="padding:0px!important;">Removing items will allow this order to move from unshipped status to shipped</td>
									</tr>
									<tr>
										<td align="right"><strong>Reason:</strong></td>
										<td><?php if(!empty($errors['reason_id'])){
												$errorReasonId='form-select smallr-width error_message_box';
											}else{
												$errorReasonId='form-select smallr-width';
											}
											?>
											<?php echo $form->select('OrderSeller.reason_id',$reasons,null,array('type'=>'select','class'=> $errorReasonId),'Select');?><?php
/*
pr($errors);

$form->error('OrderSeller.reason_id');*/?>
										</td>
										
									</tr>
									<tr>
										<td align="right">&nbsp;</td>
										<td>&nbsp;</td>
										
									</tr>
									<tr>
										<td align="right">&nbsp;</td>
										<td>&nbsp;</td>
										
									</tr>
									<tr>
										<td align="right">&nbsp;</td>
										<td>&nbsp;</td>
									</tr>
									<tr>
										<td colspan="2" align="right"><?php echo $form->submit('',array('type'=>'image','class'=>'','div'=>false,'src'=>'/img/cancel-item-btn1.png')); ?></td>
									</tr>
									</tbody>
								</table>
								<?php }?>
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
					<?php if(empty($product_url)){
						$product_url = "";
					 }?>
					<p><?php echo $html->link($format->formatString($od_itms['OrderItem']['product_name'],500),'/'.$product_url.'/'.$this->Common->getProductUrl($od_itms['OrderItem']['product_id']).'/categories/productdetail/'.$od_itms['OrderItem']['product_id'],array('escape'=>false));?></p>
					
					<!--<p><?php echo $od_itms['OrderItem']['product_name'];?></p> --->
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

				$remaining_qty_tocancel = $od_itms['OrderItem']['quantity'] - $canceled_quantity - $dis_quantity;

				if(!empty($remaining_qty_tocancel)){
					echo $form->select('OrderSeller.Items.'.$od_itms['OrderItem']['id'].'.cancel_qty',array_combine(range(1,$remaining_qty_tocancel),range(1,$remaining_qty_tocancel)),null,array('type'=>'select','class'=>'form-select width-auto'),'0');

					echo $form->hidden('OrderSeller.Items.'.$od_itms['OrderItem']['id'].'.total_ordered_qty',array('value'=>$od_itms['OrderItem']['quantity']));
					echo '<br>';
				}
// 				echo 'Total shipped: '.$dis_quantity;
				echo 'Total shipped: '.$dis_quantity.'<br>Total cancelled: '.$canceled_quantity;
				echo $form->hidden('OrderSeller.Items.'.$od_itms['OrderItem']['id'].'.dispatch_qty',array('value'=>$dis_quantity));
				if(empty($od_itms['OrderItem']['price']))
					$od_itms['OrderItem']['price'] = 0;
				echo $form->hidden('OrderSeller.Items.'.$od_itms['OrderItem']['id'].'.orderitem_price',array('value'=>$od_itms['OrderItem']['price']));
				?></td>
				<td valign="top" class="border-top-botom-none padd-bottom"><?php echo CURRENCY_SYMBOL.' '.$format->money($od_itms['OrderItem']['price'],2);?></td>
				<td valign="top" class="border-top-botom-none padd-bottom"><?php echo CURRENCY_SYMBOL.' '.$format->money($od_itms['OrderItem']['delivery_cost'],2);?></td>
				<td valign="top" class="border-top-botom-none padd-bottom"><?php echo CURRENCY_SYMBOL.' '.$format->money($od_itms['OrderItem']['giftwrap_cost'],2);?></td>
				<td valign="top" class="last border-top-botom-none padd-bottom"><?php echo CURRENCY_SYMBOL.' '.$format->money((($od_itms['OrderItem']['delivery_cost']*$od_itms['OrderItem']['quantity'])+($od_itms['OrderItem']['price']*$od_itms['OrderItem']['quantity'])+($od_itms['OrderItem']['giftwrap_cost']*$od_itms['OrderItem']['quantity'])),2);

				$total_order_cost = round(($total_order_cost + ($od_itms['OrderItem']['delivery_cost']*$od_itms['OrderItem']['quantity'])+($od_itms['OrderItem']['price'] * $od_itms['OrderItem']['quantity'])+($od_itms['OrderItem']['giftwrap_cost']*$od_itms['OrderItem']['quantity'])),2);
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
</div>
<!--Search Results Closed-->
<?php echo $this->element('seller/order_item_shipmentdetails');?>
<?php echo $this->element('seller/seller_order_feedback');?>

<!--Seller Note Widget Start-->

<div class="seller-note-widget" id="seller_note">
	<?php
echo $this->element('seller/seller_note');?>
</div>
<div id="plsLoaderID" style="display:none" class="dimmer"><?php echo $html->image("loading.gif" ,array('alt'=>"Loading" ));?></div>
<!--Seller Note Widget Closed-->
<script language="JavaScript">
	var carr_value = jQuery('#OrderSellerShippingCarrier').val();
	if(carr_value == 8 || carr_value == 9){
		enter_carrier(carr_value);
	}
	function enter_carrier(carrierValue){
		if(carrierValue == 9 || carrierValue == 8){
			jQuery('#othercarrier').css('display','block');
			jQuery('#othercarrier').css('padding-top','5px');
		} else{
			jQuery('#othercarrier').css('display','none');
		}
	}
</script>