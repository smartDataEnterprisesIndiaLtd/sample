<?php $this->Html->addCrumb('Order Management', ' ');
	$this->Html->addCrumb('View Orders', 'javascript:void(0)');?>
<script>
function validateCancelItem(ItemFieldId){
	
	var cancelQtyVal = jQuery('#'+ItemFieldId).val();
	if(cancelQtyVal == ''){
		return false;
	}
	
}

</script>
<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0" >
    <tr class="adminBoxHeading reportListingHeading">
			<td class="adminGridHeading heading"><?php echo $title_for_layout;?> &nbsp;&nbsp;&nbsp;&nbsp;
			Date: <?php  echo date('d F Y, H:i:s', strtotime($orderData['Order']['created'])); ?>
			</td>
			<td class="adminGridHeading" align="right"><?php echo $html->link('Back','javascript:void(0)', array('onclick'=> 'history.go(-1)' ) );    ?>
			</td>
       </tr>
    <?php  if(is_array($orderData) ) { ?>
    <tr>
	<td colspan="2">
	    <table class="adminBox" border="0" cellpadding="0" cellspacing="0" width="100%" >
		<tr >
		    <td  align="center" valign="top" >
			<table border="0" cellpadding="2" cellspacing="0" width="100%" >
				<tr >
					<td  align="center" valign="top" >
					<table border="0" cellpadding="2" cellspacing="0" width="100%" >
						<tr >
							<td width="33%" align="left"  valign="top">
								<strong>Billing Address:</strong> <br />
								<?php
								echo $orderData['Order']['billing_user_title']." ". $orderData['Order']['billing_firstname']." ". $orderData['Order']['billing_lastname']; echo "<br>";
								echo $orderData['Order']['billing_address1']; echo "<br>";
								echo $orderData['Order']['billing_address2']; echo "<br>";
								echo $orderData['Order']['billing_city']; echo "<br>";
								if(!empty($orderData['Order']['billing_state']) ){
									echo $orderData['Order']['billing_state']; echo "<br>";
								}
								echo $orderData['Order']['billing_postal_code']; echo "<br>";
								echo $countries[$orderData['Order']['billing_country']]; echo "<br>";
								echo $orderData['Order']['billing_postal_code']; echo "<br>";
								echo "Phone :".$orderData['Order']['billing_phone']; echo "<br>";
								?>
							</td>
							<td width="33%" align="left" valign="top" >
								<!--<strong>Expected Ship Date: </strong><?php  //echo date('d M Y' ,strtotime($expShippingDate));
								?> <br />-->
								<strong>Status: </strong>  <span class="red_text" ><?php 
								echo $OrderShippingStatus;?> </span><br />
								<strong>Buyer Name: </strong><font color="#186FDF"> <?php  echo ucwords(@$orderData['UserSummary']['title'].'. '.@$orderData['UserSummary']['firstname'].' '.@$orderData['UserSummary']['lastname']);?></font><br />
								<strong>Contact Buyer: </strong> <?php  echo $html->link(@$orderData['UserSummary']['email'],'mailto:'.@$orderData['UserSummary']['email'],array('escape'=>false));?><br />
								<br/><br/>
								<?php
								if(( $OrderShippingStatus == 'Unshipped' &&  $OrderShippingStatus != 'Cancelled' ) &&  $orderData['Order']['deleted'] != '2' ){
									echo $html->link(' Cancel Order ','/admin/orders/cancel_order/'.$orderId,array('type'=>'submit','class'=>'btn_53','div'=>false, 'label'=>false, 'onclick'=>"return confirm('Are you sure you want to cancel this order ?');"));
								}?>
							</td>
							<td align="left" valign="top">
								<strong>Shipping Address:</strong> <br />
								<?php
								echo $orderData['Order']['shipping_user_title']." ". $orderData['Order']['shipping_firstname']." ". $orderData['Order']['billing_lastname']; echo "<br>";
								echo $orderData['Order']['shipping_address1']; echo "<br>";
								echo $orderData['Order']['shipping_address2']; echo "<br>";
								echo $orderData['Order']['shipping_city']; echo "<br>";
								if(!empty($orderData['Order']['shipping_state']) ){
									echo $orderData['Order']['shipping_state']; echo "<br>";
								}
								echo $orderData['Order']['shipping_postal_code']; echo "<br>";
								echo $countries[$orderData['Order']['shipping_country']]; echo "<br>";
								echo $orderData['Order']['shipping_postal_code']; echo "<br>";
								echo "Phone :".$orderData['Order']['shipping_phone']; echo "<br>";
								?>
							</td>
						</tr>
					</table>
					</td>
				</tr>
				
				<tr>
					<td  align="center" valign="top" >
					
						<table border="0" cellpadding="2" cellspacing="0" width="100%"  >
						<tr bgcolor="#DFDFDF">
						    <td  align="left"  valign="top"><strong>Product Details:</strong></td>
						    <td width="8%" align="center" valign="top"><strong>Quantity Cancelled </strong></td>
						    <td width="8%" align="center" valign="top"><strong>Quantity Ordered</strong></td>
						    <td width="8%" align="center" valign="top"><strong>Quantity Shipped</strong></td>
						    <td width="8%" align="center" valign="top"><strong>Price(<?php echo CURRENCY_SYMBOL; ?>)</strong></td>
						    <td width="8%" align="center" valign="top"><strong>Delivery (<?=CURRENCY_SYMBOL?>)</strong></td>
						    <td width="8%" align="center" valign="top"><strong>Subtotal (<?=CURRENCY_SYMBOL?>)</strong></td>
						</tr>
						<?php
						//pr($orderData);
						if(isset($orderData['Items']) ){
						if(is_array($orderData['Items']) ){
						$item_total_price = 0;
						foreach($orderData['Items'] as $item) {  
							$prodSellerData = $this->Common->getProductSellerInfo( $item['product_id'] , $item['seller_id'], $item['condition_id']);
							?>
							
							<?php echo $form->create('Order',array('action'=>'admin_cancel_order_item','method'=>'POST','name'=>'frmItem'.$item['id']));?>
							<tr >
							    <td align="left"  valign="top">
								<div ><b>
								
								<?php echo $html->link($item['product_name'],'/'.$this->Common->getProductUrl($item['product_id']).'/categories/productdetail/'.$item['product_id'],array('escape'=>false,'target'=>'_blank'));?>
								<?php //echo $item['product_name'];?></b></div>
								<div  >Seller: <?php echo $html->link(@$item['seller_name'],'/sellers/summary/'.@$item['SellerSummary']['id'].'/'.@$item['product_id'],array('escape'=>false,'class'=>'blue-text')); ?></div>
								<div><strong>Condition: </strong><?php  echo $newUsedConditions[$item['condition_id']];?></div>
								<div><strong>Comments: </strong><?php  echo $prodSellerData['ProductSeller']['notes'];?></div>
								<div><strong>Quick Code: </strong><?php echo $item['quick_code']; ?></div>
								<div><strong>Delivery: </strong> <span class="blue-text">
								<?php
								if($item['delivery_method'] == 'E'){
									echo 'Express';
								}else{ echo 'Standard' ;}  ?> </span>
								</div>
								<div><strong>Expected Delivery: </strong> <span class="">
								<?php  if(!is_null($item['estimated_delivery_date']) ){
									echo date( 'F d, Y',  strtotime($item['estimated_delivery_date']));
								}else{ echo 'NA'; }?></span></div>
								<div><strong>Status: </strong> <span >
									<?php 
									/*if(!empty($shippingStatus) ){ 
										if(isset($shippingStatus[$item['seller_id']]) ){
											echo $shippingStatus[$item['seller_id']];
										}
										
									}else{ echo 'NA' ; } */ ?>


								<?php /*pr($itemsDispatched);  pr($itemsCancelled);
									pr($item);*/
									$item_status = 'Unshipped';
									if((array_key_exists($item['id'],$itemsDispatched)) || (array_key_exists($item['id'],$itemsCancelled))){
										$total_ship_cancel = @$itemsDispatched[$item['id']] + @$itemsCancelled[$item['id']];
											if($item['quantity'] == @$itemsCancelled[$item['id']]){
												$item_status = 'Cancelled';
											}else if($item['quantity'] == $total_ship_cancel){
												$item_status = 'Shipped';
											} else if(($total_ship_cancel > 0) && ($item['quantity'] > $total_ship_cancel)) {
												$item_status = 'Part Shipped';
											}else {}
									} else {
										$item_status = 'Unshipped';
									}
									echo $item_status;
								?>
								</span>
								</div>
								
								
							    </td>
							    <td  align="center"  valign="top">
								<?php
								$qty_ordered = $item['quantity'];
								if(isset($itemsDispatched[$item['id']])){
									$qty_shipped = $itemsDispatched[$item['id']];
								}else{
									$qty_shipped = 0;
								}
								if(isset($itemsCancelled[$item['id']])){
									$qty_cancelled = $itemsCancelled[$item['id']];
								} else{
									$qty_cancelled = 0;
								}
								if($qty_cancelled > 0){
									echo "<span class=\"red_text\">".$qty_cancelled."</span>";
								}
								$remaining_qty_tocancel = $qty_ordered-$qty_shipped-$qty_cancelled;
								if($shippingStatus[$item['seller_id']] == 'Part Shipped' || $shippingStatus[$item['seller_id']] == 'Unshipped'){
									if(!empty($remaining_qty_tocancel) && $remaining_qty_tocancel > 0){
										$fieldId = 'cancel_item_qty_'.$item['id'];
										echo $form->select('Order.Items.cancel_qty_'.$item['id'],array_combine(range(1,$remaining_qty_tocancel),range(1,$remaining_qty_tocancel)),null,array('id'=>$fieldId, 'type'=>'select','class'=>'textbox'),'--');
										echo $form->hidden('Order.Items.reason_id',array('value'=>'15' ));
										echo $form->hidden('Order.Items.order_id',array('value'=>$item['order_id']));
										echo $form->hidden('Order.Items.item_id',array('value'=>$item['id']));
										echo $form->hidden('Order.Items.item_price',array('value'=>$item['price']));
										echo $form->hidden('Order.Items.seller_id',array('value'=>$item['seller_id']));
										echo $form->hidden('Order.Items.product_id',array('value'=>$item['product_id']));
										echo $form->hidden('Order.Items.condition_id',array('value'=>$item['condition_id']));
										echo $form->hidden('Order.Items.user_id',array('value'=>$orderData['Order']['user_id']));
										echo $form->hidden('Order.Items.delivery_cost',array('value'=>$item['delivery_cost']));
										echo '<br><br>';
										echo $form->submit('Cancel',array( 'onclick'=> "return validateCancelItem('$fieldId');", 'class'=>'btn_53','div'=>false, 'label'=>false));
									}
								 } ?>
							    </td>
							    <td  align="center" valign="top">
							    <?php echo $item['quantity']; ?>
							  
								<?php if(strtoupper($item['giftwrap']) == "YES") { ?>
								  <p class="smalr-fnt gift-wrap no-pad-btm">
									  Gift-wrap
								 </p>
								  <?php  } ?>
							    </td>
							    <td  align="center" valign="top"><?php echo (int)$common->getDispatchedQuantity($item['order_id'], $item['id']); ?></td>
							    <td  align="center" valign="top"><?php echo $item['price']; ?></td>
							    <td  align="center" valign="top"><?php
								if(!empty($item['delivery_cost']) ){
									echo $item['delivery_cost'];
								} ?></td>
							    <td align="center" valign="top"><?php echo number_format(($item['price']*$item['quantity'])+$item['delivery_cost']*$item['quantity'], 2); ?></td>
							</tr>
							<?php echo $form->end();?>
							<tr > <td  align="left" colspan="7" height="20">&nbsp;</td>    </tr>
						<?php
							$item_total_price += ($item['price']*$item['quantity']);
							unset($item);
							unset($qty_ordered);unset($qty_shipped);unset($qty_cancelled);unset($remaining_qty_tocancel);
						} // foreach ends
						
						}}else{ ?>
						<tr >
						    <td  align="left" colspan="7" height="15">Products Not Found.&nbsp;</td>
						</tr>
						<?php 	} ?>
						</table>
					</td>
				</tr>
			</table>
		    </td>
		</tr>
		<!-- Order information starts here -->
		<?php  if(isset($orderData['Items'])){ ?>
		<tr>
			 <td align="left"  valign="top">
				<table border="0" cellpadding="2" cellspacing="0" width="100%" >
					<tr bgcolor="#DFDFDF" >
					<td  align="left" valign="top" width="65%" height="22"><strong>Order Information</strong></td>
					<td  align="left" valign="top" class="orange-text" ><strong>Payment Information</strong></td>
					</tr>
					<tr >
					<td  align="center" valign="top" >
						
						<table border="0" cellpadding="0" cellspacing="0" width="99%"  >
						<?php
						
						
						if($orderData['Order']['deleted'] == '2'){ // in case of fraud order
							$fraudOrderDate = date('d M Y H:i A' ,strtotime($orderData['Order']['modified']));
							echo '<tr><td  align="left" class="red_text">This order is considered as fraudulent -  '.$fraudOrderDate.'</td></tr>';
						 }
						//pr($dispatchments);
						if(count($dispatchments) > 0){
							
						foreach($dispatchments as $numbering => $ItemDispatches){
						?>
							<tr>
								<td  align="left" class="bgGreentext"><strong>Shipment Number: <?php  echo $numbering+1;?></strong> </td>
							</tr>
							
						<?php
						if(count($ItemDispatches) > 1){
							
							foreach($ItemDispatches as $dispatches){
							?>
							<tr><td  align="left" ><?php  echo $dispatches['OrderItem']['product_name'];?> X  <strong><?php  echo $dispatches['DispatchedItem']['quantity'];?></strong></td></tr>
							<?php  } ?>
						<tr><td  align="left" >Shipped on <?php echo $dispatches['DispatchedItem']['shipping_date'];?></td></tr>
						<tr><td  align="left" >Using Carrier <?php 
						if( in_array($dispatches['DispatchedItem']['shipping_carrier'], array(8,9) ) ) {
							echo $dispatches['DispatchedItem']['other_carrier'];
						}else{
							echo $carriers[$dispatches['DispatchedItem']['shipping_carrier']];
						}
						?> </td></tr>
						<tr><td  align="left" >Service <?php
						
							if( !empty( $dispatches['DispatchedItem']['shipping_service'] ) ) {
								echo $dispatches['DispatchedItem']['shipping_service'];
							}else{
								echo "<span class='err_txt'>Not Available</span>";
							}?>
						</td></tr>
						<tr><td  align="left" >Tracking ID <?php
							if( !empty( $ItemDispatches[0]['DispatchedItem']['tracking_id'] ) ) {
								echo $ItemDispatches[0]['DispatchedItem']['tracking_id'];
							}else{
								echo "<span class='err_txt'>Not Available</span>";
							}
						?> </td></tr>
						<tr><td>&nbsp;</td></tr>
						
						<?php  } else{ 
						
							//pr($ItemDispatches);?>
							
						<tr><td  align="left" ><?php  echo $ItemDispatches[0]['OrderItem']['product_name'];?> X  <strong><?php  echo $ItemDispatches[0]['DispatchedItem']['quantity'];?></strong></td></tr>
						<tr><td  align="left" >Shipped on <?php echo $ItemDispatches[0]['DispatchedItem']['shipping_date'];?></td></tr>
						<tr><td  align="left" >Using Carrier <?php 
							if( in_array($ItemDispatches[0]['DispatchedItem']['shipping_carrier'], array(8,9) ) ) {
								echo $ItemDispatches[0]['DispatchedItem']['other_carrier'];
							}else{
								echo $carriers[$ItemDispatches[0]['DispatchedItem']['shipping_carrier']];
							}
							?> </td></tr>
						<tr><td  align="left" >Service <?php
						
							if( !empty( $ItemDispatches[0]['DispatchedItem']['shipping_service'] ) ) {
								echo $ItemDispatches[0]['DispatchedItem']['shipping_service'];
							}else{
								echo "<span class='err_txt'>Not Available</span>";
							}?>
						</td></tr>
						<tr><td  align="left" >Tracking ID <?php
							if( !empty( $ItemDispatches[0]['DispatchedItem']['tracking_id'] ) ) {
								echo $ItemDispatches[0]['DispatchedItem']['tracking_id'];
							}else{
								echo "<span class='err_txt'>Not Available</span>";
							}
						?> </td></tr>
						<tr><td>&nbsp;</td></tr>
						
						 <?php  } ?>
						<?php }  } ?>
						
						</table>
						
					<?php  if(count($orderCancelData) > 0){ ?>
						<table border="0" cellpadding="0" cellspacing="0" width="99%"  >
						<?php
						
						 foreach($orderCancelData as $item => $CancelData):
						
						?>
						<tr><td  align="left" class="red_text"><strong>Cancellation</strong> </td></tr>
						<?php  if(count($CancelData) > 1){
							foreach( $CancelData as $CancelData1){
								echo "<tr><td  align=\"left\" >".$CancelData1['OrderItem']['product_name']." X  <strong>".$CancelData1['CanceledItem']['quantity']."</strong></td></tr>";	
							} ?>
							
							<tr><td  align="left" >Cancelled on <?php echo $CancelData1['CanceledItem']['created'];?></td></tr>
							<tr><td  align="left" >Reason : <?php echo $cancelReasonArr[$CancelData1['CanceledItem']['reason_id']];?> </td></tr>
							
						<?php }else{ ?>
							<tr><td  align="left" ><?php   echo $CancelData[0]['OrderItem']['product_name'];?> X  <strong><?php  echo $CancelData[0]['CanceledItem']['quantity'];?></strong></td></tr>
							<tr><td  align="left" >Cancelled on <?php echo $CancelData[0]['CanceledItem']['created'];?></td></tr>
							<tr><td  align="left" >Reason : <?php echo $cancelReasonArr[$CancelData[0]['CanceledItem']['reason_id']];?> </td></tr>
							
						<?php  } ?>
						<tr><td>&nbsp;</td></tr>
						<?php endforeach;  ?>
						</table>
					<?php   }  ?>
						
					</td>
					
					<td  align="center" valign="top" >
						
						<table border="0" cellpadding="1" cellspacing="0" width="100%" >
						<tr>
							<td  align="left" colspan="2" ><strong>Payment:</strong> <span class="blue-text"><?php  echo $orderData['Order']['payment_method']; ?></span></td>
						</tr>
						<tr>
							<td  align="left"  colspan="2"><strong>Transaction Ref:</strong> <?php  echo $orderData['Order']['tranx_id']; ?></td>
						</tr>
						<tr>
						<td  align="left" ><?php echo $html->image('checkout/d-arrow-icon.png', array('width'=>7 ,'height'=>7, 'alt'=>''));?>&nbsp;&nbsp;<strong>Items:</strong></td>
						<td align="left"> <?php  echo CURRENCY_SYMBOL.number_format($item_total_price,2); ?></td>
						</tr>
						<tr >
						<td  align="left" ><?php echo $html->image('checkout/d-arrow-icon.png', array('width'=>7 ,'height'=>7, 'alt'=>''));?>&nbsp;&nbsp;<strong>Delivery:</strong></td>
						<td align="left"> <?php  echo CURRENCY_SYMBOL.$orderData['Order']['shipping_total_cost']; ?></td>
						</tr>
						<tr >
						<td  align="left" ><?php echo $html->image('checkout/d-arrow-icon.png', array('width'=>7 ,'height'=>7, 'alt'=>''));?>&nbsp;&nbsp;<strong>Gift-Wrap:</strong></td>
						<td align="left"> <?php  echo CURRENCY_SYMBOL.$orderData['Order']['giftwrap_total_cost']; ?></td>
						</tr>
						<tr >
						<td  align="left" ><?php echo $html->image('checkout/d-arrow-icon.png', array('width'=>7 ,'height'=>7, 'alt'=>''));?>&nbsp;&nbsp;<strong>Insurance :</strong></td>
						<td align="left"> <?php  echo CURRENCY_SYMBOL.$orderData['Order']['insurance_amount']; ?></td>
						</tr>
						<tr >
							<td  align="left" class="orange-text" >&nbsp;&nbsp;&nbsp;&nbsp;<strong>Gift Certificate:</strong></td>
							<td align="left" class="orange-text"><strong> -<?php  echo CURRENCY_SYMBOL.$orderData['Order']['gc_amount']; ?></strong></td>
						</tr>
						<tr >
							<td  align="left" class="orange-text" >&nbsp;&nbsp;&nbsp;&nbsp;<strong>Discount Coupon:</strong>-</td>
							<td align="left" class="orange-text"> <strong>-<?php  echo CURRENCY_SYMBOL.$orderData['Order']['dc_amount']; ?></strong></td>
						</tr>
						<?php
							
							$total_tax = $orderData['Order']['tax_amount'];
							$cost_before_tax = $orderData['Order']['order_total_cost'] - $total_tax - @$orderData['Order']['dc_amount'];
						?>
						
						<tr><td height="8" colspan="2">&nbsp;</td></tr>
						<tr >
							<td  align="left" ><strong>Total Before Tax:</strong></td>
							<td align="left"> <?php  echo CURRENCY_SYMBOL. number_format($cost_before_tax,2);?></td>
						</tr>
						<tr >
							<td  align="left" ><strong>Tax(<?php if(!empty($orderData['Order']['tax_percentage'])) {
								echo $orderData['Order']['tax_percentage'].'%' ;} else{ echo '-';} ?>):</strong></td>
							<td align="left"> <?php  echo CURRENCY_SYMBOL. number_format($total_tax,2);
							 ?></td>
						</tr>
						<tr><td height="8" colspan="2" style="border-bottom:1px solid;"></td></tr>
						<tr >
						<td  align="left" class="red_text" ><?php echo $html->image('checkout/d-arrow-icon.png', array('width'=>7 ,'height'=>7, 'alt'=>''));?>&nbsp;	&nbsp;<strong>Total:</strong></td>
						<td align="left" class="red_text" > <strong><?php  echo CURRENCY_SYMBOL.$orderData['Order']['order_total_cost']; ?></strong></td>
						</tr>
						<tr><td height="8" colspan="2">&nbsp;</td></tr>
					<?php
					$total_refund = 0;
					if(!empty($orderRefundData) ){
						foreach($orderRefundData as $redund):
							$total_refund += $redund['OrderRefund']['amount'];
						?>
							<tr >
								<td  align="left" colspan="2" ><?php echo date('Y-m-d', strtotime($redund['OrderRefund']['created'])). " Refund - ".  CURRENCY_SYMBOL. number_format($redund['OrderRefund']['amount'],2);?> </td>
							</tr>
							<tr >
								<td  align="left" colspan="2" ><?php echo $redund['OrderRefund']['memo'] ;?> <br> <strong><?php echo @$redund['OrderRefund']['seller_display_name']; ?></strong></td>
							</tr>
							<tr><td height="5" colspan="2">&nbsp;</td></tr>
						<?php
						
						endforeach; ?>
						<tr><td height="5" colspan="2"> <strong>Balance :
							<?php
							 $balanceAmount =   round($orderData['Order']['order_total_cost'],2) - round($total_refund,2);
							 echo CURRENCY_SYMBOL.(number_format($balanceAmount,2)) ;?></strong>&nbsp;</td></tr>
					<?php
					} ?>
						
						
						</table>
						
						
					</td>
					</tr>
					
				</table>
				
			 </td>
		</tr>
		<?php  } ?>
		<?php if(!empty($feedBackData) ){ 
		#----------------- Feedback Section Start Here -------------------------------- ?>
		<tr>
		<td align="left"  valign="top">
		       <table border="0" cellpadding="2" cellspacing="0" width="100%" >
			       <tr bgcolor="#DFDFDF" >
				 <td  align="left" valign="top" width="65%" height="22"><strong>Feedback</strong></td>
			       </tr>       
			       <?php
				foreach($feedBackData as $feedback){
				//pr($feedback);
				?>
				<?php if(!empty($feedback['Feedback']['feedback']) ){ ?>
				<tr >
					<td  align="left"  >Seller : <?php echo $html->link(@$feedback['Seller']['business_display_name'],'/sellers/summary/'.@$feedback['Feedback']['seller_id'].'/'.@$feedback['Feedback']['product_id'],array('escape'=>false,'class'=>'blue-text')); ?> <br><?php echo $feedback['Feedback']['feedback'] ;?> </td>
				</tr>
				<?php  } else{ ?>
				<tr >
					<td  align="left"  >Seller : <?php echo @$feedback['Seller']['business_display_name'] ;?><br> None left </td>
				</tr>
				<tr><td height="5" >&nbsp;</td></tr>
				<?php
			       } }?>
			       </table>
		       </td>
		</tr>
		<?php }  ?>
		<tr>
		<td align="left"  valign="top">
		      <?php echo $form->create('Order',array('action'=>'admin_save_order_adminnotes','method'=>'POST','name'=>'frmOrder','id'=>'frmOrder')); ?>
		      <table border="0" cellpadding="2" cellspacing="0" width="100%" >
			<tr >
				<td  align="left" ><strong>Notes:</strong></td>
			</tr>
			<tr >
			<td  align="left" >
				<?php echo $form->input("Order.admin_notes",array('value'=> $orderData['Order']['admin_notes'], "label"=>false,"div"=>false,'rows'=>5, 'cols'=>45, 'class'=>'textbox-m')); ?>	
			</td>
			</tr>
			<tr >
				<td  align="left" >
				<?php
				echo $form->hidden('Order.id', array('value'=> $orderData['Order']['id']));
				echo $form->button('Submit',array('type'=>'submit','class'=>'btn_53','div'=>false));?></td>
			</tr>
			</table>
		      <?php echo $form->end();?>
		</td>
		</tr>
		<?php #------------------ Feedback Section End Here -------------------------------- ?>
		
	   </table>
	</td>
    </tr>
    <?php  } ?>
</table>