<?php
echo $html->css('dhtmlgoodies_calendar.css');
e($html->script('dhtmlgoodies_calendar.js'));
e($html->script(array('behaviour.js','textarea_maxlen')));
?>
<!--mid Content Start-->
<div class="mid-content pad-rt-none">
	<!--Setting Tabs Widget Start-->
	<!--<div class="row-widget">-->
	<div class="row row-widget">
	  <!--- <?php //echo $this->element('marketplace/breadcrum');?> --->
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
			
			if($errors['amount']=='Invalid refund value')
			{
		$error_meaasge="Refund value should be less than or equal to the maximum amount";	
			}
			else if($errors['amount']=='negative value')
			{
		$error_meaasge="Invalid refund amount";	
			}
		else {
			$error_meaasge="Please add some information in the mandatory fields highlighted red below.";
		
		}
			?>
		<div class="error_msg_box"> 
			<?php echo $error_meaasge;?>
		</div>
		<?php }?>
<!--Search Results Start-->
<div class="search-results-widget" style="overflow:visible;">
	<!--Paging Widget Start-->
	<div class="search-paging border-botom-none" style="position: relative;">
		<ul style="width: 100%;">
			<li><h2>Order: <?php echo $order_details['Order']['order_number'];?></h2></li>
		</ul>
	</div>
	<!--Paging Widget Closed-->
	<!--Search Products Start-->
	<?php echo $form->create('Seller',array('action'=>'refund_order/'.base64_encode($order_id),'method'=>'POST','name'=>'frmOrderSellerShipping','id'=>'frmOrderSellerShipping'));?>
	<div class="scroll-div" style="border:none;">
		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="seller-listings ordered-listing border-bottom">
			<tr>
				<td width="12%" rowspan="11" align="left" valign="top" class="border-botom-none">
					<p><?php echo date(ORDER_DATE_FORMAT,strtotime($order_details['Order']['created']));?></p>
				</td>
				<td colspan="7" align="left" style="padding:0px; border:none;">
					<table width="100%" cellspacing="0" cellpadding="0">
						<tr>
							<td width="36%" valign="top">
								<?php echo $this->element('seller/order_shippingaddress'); ?>
							</td>
							<td valign="top">
								<?php echo $this->element('seller/order_shipdetails'); ?>
							</td>
							<td width="34%" valign="top" class="last">
								
								<?php echo $this->element('seller/print_payment_slip');?> 
								<?php if($order_details['OrderSeller']['shipping_status'] == 'Unshipped' || $order_details['OrderSeller']['shipping_status'] == 'Cancelled' ) {
								} else{
								//REF #E1469
								if($order_details['OrderSeller']['shipping_status'] == 'Part Shipped' || $order_details['OrderSeller']['shipping_status'] == 'Shipped') {
									echo $html->link($html->image('edit-shipping.png',array('alt'=>"", 'class'=>"v-align-middle")),'/sellers/ship_order/'.base64_encode($order_details['OrderSeller']['order_id']).'/'.base64_encode('edit'),array('escape'=>false));
								}
								
								?>
										
								 <p class="margin-top">Select the reason for the refund and enter the amounts to be refunded.</p>
								<table cellspacing="0" cellpadding="0" border="0" width="100%" class="ship-order-widget">
									<tbody>
										<tr>
											<td align="right" ><strong>Reason for refund:</strong></td>
											<td>
												<?php if(!empty($errors['reason_id'])){
														$errorReasonId ='form-select smallr-width error_message_box';
													}else{
														$errorReasonId ='form-select smallr-width';
													}
												echo $form->select('OrderSeller.reason_id',$refundreasons,null,array('type'=>'select','class'=>$errorReasonId),'Select');?><?php //echo $form->error('OrderSeller.reason_id');
												?>
											</td>
										</tr>
										<?php $can_refund = 0;
										if(!empty($order_details['Items'])) {
											$total_order_cost = 0;
											foreach($order_details['Items'] as $od_itms) {
												$total_order_cost = $total_order_cost + (($od_itms['OrderItem']['delivery_cost']*$od_itms['OrderItem']['quantity'])+($od_itms['OrderItem']['price'] * $od_itms['OrderItem']['quantity'])+($od_itms['OrderItem']['giftwrap_cost']*$od_itms['OrderItem']['quantity']));
											}
											$can_refund = $total_order_cost - $total_refundes;
											if($can_refund < 0){
												$can_refund = 0;
											}
										} ?>
										<tr>
											<td align="right" style="width:35%"><span class="red-color"><strong>Refund:</strong></span></td>
											<td>
												<?php if(!empty($errors['amount'])){
														$errorAmount ='form-textfield v-smal-width error_message_box';
													}else{
														$errorAmount ='form-textfield v-smal-width';
													}
												echo CURRENCY_SYMBOL.' '.$form->input('OrderSeller.amount',array('class'=>$errorAmount,'label'=>false,'div'=>false,'error'=>false, 'maxlength'=>'8','style'=>'width:30px')); ?> <?php echo $form->hidden('OrderSeller.up_to_refund',array('type'=>'text','value'=>@$can_refund)); ?>  <span class="padding-left"><strong>Maximum Amount:</strong> <?php echo CURRENCY_SYMBOL.$format->money($can_refund,2);?></span><br /><?php //	echo $form->error('OrderSeller.amount'); ?>
												
											</td>
                      
										</tr>
										<tr>
											<td align="right"><strong>Memo to buyer:</strong> <span class="gray line-break smalr-fnt" style="padding-right:42px;">(Optional)</span></td>
											<td><?php
											//#F 1479
											//echo $form->input('OrderSeller.memo',array('class'=>'form-textfield smalr-fnt','cols'=>50,'rows'=>2,'style'=>'width:210px;color:gray; font-size:9px','label'=>false, 'maxlength'=>'1000','div'=>false,'onBlur'=>'changeValue();','onClick'=>'changeValue();','onFocus'=>'changeValue();'));
											echo $form->input('OrderSeller.memo',array('class'=>'form-textfield','cols'=>50,'rows'=>2,'style'=>'width:210px;','label'=>false, 'maxlength'=>'1000','div'=>false,'onBlur'=>'changeValue();','onClick'=>'changeValue();','onFocus'=>'changeValue();'));
											 ?></td>
										<td align="right" colspan="2">
												<?php
												echo $form->submit('submit-refund.gif',array('type'=>'image','class'=>'v-align-middle','div'=>false,'id'=>'clickOnce'));
												?>
											</td>
										</tr>				
											
										<tr>
											
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
				
				$totalDispatchedItems = 0;
				foreach($od_itms['DispatchedItem'] as $orderKey => $orderValue){
					if($orderValue['quantity'] > 0){
						$totalDispatchedItems = $totalDispatchedItems+$orderValue['quantity'];	
					}
				}
			?>
			<tr>
				<td align="left" class="border-top-botom-none padd-bottom">
					<?php if(empty($product_url)){
						$product_url = "";
					 }?>
					<p><?php echo $html->link($format->formatString($od_itms['OrderItem']['product_name'],500),'/'.$product_url.'/'.$this->Common->getProductUrl($od_itms['OrderItem']['product_id']).'/categories/productdetail/'.$od_itms['OrderItem']['product_id'],array('escape'=>false));?></p>
					<p class="gray"><strong>Condition:</strong> <?php echo $pro_conditions[$od_itms['OrderItem']['condition_id']];?></p>
					<p class="gray"><strong>Comments:</strong> <?php echo $od_itms['ProductSeller']['notes'];?></p>
					<p><strong>Your Code:</strong> <?php echo $od_itms['ProductSeller']['reference_code'];?></p>
					<p><strong>QuickCode:</strong> <span class="gray"><?php echo $od_itms['OrderItem']['quick_code'];?></span></p>
				</td>
				<td valign="top" class="border-top-botom-none padd-bottom"><?php echo $od_itms['OrderItem']['quantity'];?></td>
				<td valign="top" class="border-top-botom-none padd-bottom">
				
				<?php /*$dis_quantity = 0; if(!empty($order_details['Dispatched_Items'])){
					foreach($order_details['Dispatched_Items'] as $dispatched_items){
						if(!empty($dispatched_items['DispatchedItem']['quantity'])){
							$dis_quantity = $dis_quantity + $dispatched_items['DispatchedItem']['quantity'];
						}
					}
				}*/
				//echo $dis_quantity;
				//$remaining_qty_toship = $od_itms['OrderItem']['quantity'] - $dis_quantity;
				$remaining_qty_toship = $od_itms['OrderItem']['quantity'] - $totalDispatchedItems;
				
				echo $totalDispatchedItems;
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
	<?php //echo $form->hidden('OrderSeller.total_order_amount',array('type'=>'text','value'=>@$total_order_cost)); ?>
	<?php echo $form->end(); ?>
</div>
<!--Search Results Closed-->
<?php echo $this->element('seller/order_item_shipmentdetails');?>
<?php echo $this->element('seller/seller_order_feedback');?>

<!--Seller Note Widget Start-->

<div class="seller-note-widget" id="seller_note">
	<?php echo $this->element('seller/seller_note');?>
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
</div>
<div id="plsLoaderID" style="display:none" class="dimmer"><?php echo $html->image("loading.gif" ,array('alt'=>"Loading" ));?></div>
<!--Seller Note Widget Closed-->
<script type="text/javascript">

function changeValue(){
	var memo = jQuery('#OrderSellerMemo').val();
	if(memo == ' '){
		jQuery('#OrderSellerMemo').val('Enter a note that will be sent to buyer.');
	} else if(memo == 'Enter a note that will be sent to buyer.'){
		jQuery('#OrderSellerMemo').val('');
	} else{

	}
}
if(jQuery('#OrderSellerMemo').val() == ''){
	jQuery('#OrderSellerMemo').val('Enter a note that will be sent to buyer.');
}
jQuery(document).ready(function()  {
	//disable submit button after one click
	jQuery('#clickOnce').click(function(){
		if((jQuery("#OrderSellerReasonId").val() != "")&&(jQuery("#OrderSellerAmount").val() != ""))
		{
			jQuery('#frmOrderSellerShipping').submit();
			jQuery("#clickOnce").attr("disabled", "true");
			
		}
	});
});
</script>