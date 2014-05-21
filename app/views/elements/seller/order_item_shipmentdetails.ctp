<?php
?><!-- Shipment details -->
<div class="border feedback-recieved">
	<h5 class="gray-heading">Order Information</h5>
	<div class="pdng"><?php if(!empty($order_details['Dispatched_Items'])) { ?>
		<table width = "100%" cellspacing="2" cellpadding="2" border="0">
			<?php $ship_number = 1;
			foreach($order_details['Dispatched_Items'] as $ship_item){ ?>
				<tr><td>
					<p class="shippingnumber">Shipment Number 
						<?php 
							echo $ship_number;
						?>
					</p>
					<p>
						<?php if(!empty($ship_item['DispatchedItem']['item_name'])) {
						echo $ship_item['DispatchedItem']['item_name'];
						}
						else { 
						echo '-';
						} ?>
					</p>
					<p>Shipped on 
						<?php if(!empty($ship_item['DispatchedItem']['shipping_date'])) {
							echo date(FULL_DATE_FORMAT,strtotime($ship_item['DispatchedItem']['shipping_date']));
						} else {
							echo '<span class="red-color">Not available</span>';
						} ?>
					</p>
					<p>Using carrier: <strong>
						<?php if(!empty($ship_item['DispatchedItem']['shipping_carrier'])) { 
							echo $carriers[$ship_item['DispatchedItem']['shipping_carrier']];
							if($ship_item['DispatchedItem']['shipping_carrier'] == 8 || $ship_item['DispatchedItem']['shipping_carrier'] == 9){
								echo ' ('.$ship_item['DispatchedItem']['other_carrier'].')';
							}
						} else {
							echo '<span class="red-color">Not available</span>';
						} ?></strong>
					</p>
					<p>Service: 
						<?php if(!empty($ship_item['DispatchedItem']['shipping_service'])) {
							echo $ship_item['DispatchedItem']['shipping_service'];
						} else {
							echo '<span class="red-color">Not available</span>';
						} ?>
					</p>
					<p>Tracking ID: 
						<?php if(!empty($ship_item['DispatchedItem']['tracking_id'])) { 
							echo $ship_item['DispatchedItem']['tracking_id']; 
						} else { 
							echo '<span class="red-color">Not available</span>';
						} ?>
					</p>
					<p>&nbsp;</p>
				
				</td></tr>
			<?php  $ship_number++; } ?>
		</table>
	<?php } ?>
	<?php if(!empty($order_details['CanceledItems'])) { ?>
		<table width = "100%" cellspacing="2" cellpadding="2" border="0">
			<tr><td>
				<p class="red-color"><strong>Cancellation</strong></p>
			</td></tr>
			<?php
			foreach($order_details['CanceledItems'] as $cancel_item){ ?>
				<tr><td>
					<!--<p class="red-color"><strong>Cancellation</strong></p>-->
					<p>
						<?php if(!empty($cancel_item['CanceledItem']['item_name'])) {
						echo $cancel_item['CanceledItem']['item_name'];
						}
						else { 
						echo '-';
						} ?>
					</p>
					<p>Cancelled on 
						<?php if(!empty($cancel_item['CanceledItem']['created'])) {
							echo date(FULL_DATE_TIME_FORMAT,strtotime($cancel_item['CanceledItem']['created']));
						} else {
							echo '<span class="red-color">Not available</span>';
						} ?>
					</p>
					<p><strong>Reason:</strong> 
						<?php if(!empty($cancel_item['CanceledItem']['reason_id'])) {
							if($cancel_item['CanceledItem']['reason_id'] == 15){
								echo 'Choiceful.com canceled';
							} else {
								echo $reasons[$cancel_item['CanceledItem']['reason_id']];
							}
						} else {
							echo '<span class="red-color">Not available</span>';
						} ?>
					</p>
				</td></tr>
			<?php } ?>
		</table>
	<?php } ?>
	</div>
</div>
<!-- End Shipment details -->