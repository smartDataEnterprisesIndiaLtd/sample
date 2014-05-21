<?php
			if(!empty($seller_id) && empty($order_dispatch_seller) && $order_dispatch_seller == 0){?>
				<div class="error_msg_box"> Not able to return items: only available after placing your order</div>
				
			<?php }else{
			
			if(!empty($buyer_orders)){ ?>
				<!--Order List details Start-->
				<div class="order-list-details overflow-h">
				<?php foreach($buyer_orders AS $key=>$val){
					if(!empty($val['Order']['shipping_country'])) $countryId = $val['Order']['shipping_country']; else $countryId =0; ?>
					<!--Order List details left Start-->
					<div class="order-list-details_l">
						<ul class="order-info">
							<li><p><span class="gray">Order Placed:</span></p>
								<h2><?php if(!empty($val['Order']['created']))
									echo date("j F Y", strtotime($val['Order']['created'])); ?></h2>
							</li>
							<li>                            
								<p><span class="gray">Order Number:</span> <?php if(!empty($val['Order']['order_number'])) echo $val['Order']['order_number']; ?></p>
								<p><span class="gray">Recipient:</span> <?php if(!empty($val['Order']['shipping_firstname']))
									echo ucwords(strtolower($val['Order']['shipping_firstname']));
								if(!empty($val['Order']['shipping_lastname']))
									echo ' '.ucwords(strtolower($val['Order']['shipping_lastname'])); ?></p>
								<p><span class="gray">Delivery Address:</span></p>
								<?php if(!empty($val['Order']['shipping_address1'])) { ?>
									<p><?php echo $val['Order']['shipping_address1']; ?></p><?php }?>
								<?php if(!empty($val['Order']['shipping_address2'])) { ?>
									<p><?php echo $val['Order']['shipping_address2']; ?></p><?php }?>
								<?php if(!empty($val['Order']['shipping_city'])) { ?>
									<p><?php echo $val['Order']['shipping_city']; ?></p><?php }?>
								<?php if(!empty($countryId)) { ?>
									<p><?php $countryArr[$countryId]; ?></p><?php }?>
								<?php if(!empty($val['Order']['shipping_postal_code'])) { ?>
									<p><?php echo $val['Order']['shipping_postal_code']; ?></p><?php }?>
							</li>
							<li>
								<p><span class="gray">Order Total:</span> <span class="red-color"><strong><?php if(!empty($val['Order']['order_total_cost']))
									$money = $val['Order']['order_total_cost'];
								else $money = 0;
								echo CURRENCY_SYMBOL.' '. $format->money($money ,2); ?></strong></span></p>
								<p><?php $this->set('val',$val);
							echo $this->element('orders/print_purchaseorder_slip');?></p>
							</li>
						</ul>
					</div>
					<!--Order List details left Closed-->
					<!--Order List details Right Start-->
					<?php if(!empty($val['Items'])){ ?>
					<div class="order-list-details_r">
						<?php foreach($val['Items'] AS $itemKey => $itemVal){ ?>
						<!--Order Products Widget Start-->
						<a href="#OI<?php echo $itemVal['OrderItem']['id'];?>" id="OI<?php echo $itemVal['OrderItem']['id'];?>" name = "OI<?php echo $itemVal['OrderItem']['id'];?>" ></a>
						<div style="padding-top:0px;" class="order-products-widget" id="updateItem<?php echo $itemVal['OrderItem']['id'];?>">
							<?php $itemVal['OrderItem']['Product'] = $itemVal['Product'];
								$this->set('itemVal',$itemVal['OrderItem']);
								if(!empty($itemVal['OrderReturn'])){
									$defaultItem = 'returned';
								} else{
									$defaultItem = 0;
								}
								$this->set('defaultItem',$defaultItem);
								echo $this->element('orders/returnitems');
							?>
						</div>
						<!--Order Products Widget Closed-->
						
						<?php } ?>
					</div>
					<!--Order List details Right Closed-->
					<?php }?>
					<div class="clear"></div>
				<?php } ?>
				</div>
				<!--Order List details Closed--><?php 
			} else{ ?>
			<!--div class="order-list-details_l">
					<ul class="order-info">
					<li><p class="no-list">There are currently no orders on file.</p></li>
					</ul>
				</div-->
				<div class="error_msg_box"> There are currently no orders on file.</div>
			<?php } }?>