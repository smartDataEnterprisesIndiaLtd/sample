<?php
			if(!empty($seller_id) && empty($order_user_seller) && $order_user_seller == 0){?>
				<div class="error_msg_box"> Not able to cancel orders: only available after placing your order</div>
				
			<?php }else{
			if(!empty($buyer_orders)){ 
			foreach($buyer_orders as $key=>$val){
			$countryId = $val['Order']['shipping_country'];
			?>
			<!--Order List details Start-->
			<div class="order-list-details overflow-h">
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
							<p><span class="gray">Order Total:</span> <span class="red-color"><strong><?php echo CURRENCY_SYMBOL.' '. $format->money($val['Order']['order_total_cost'],2); ?></strong></span></p>
							<p><?php $this->set('val',$val);
							echo $this->element('orders/print_purchaseorder_slip');?></p>
						</li>
					</ul>
				</div>
				<!--Order List details left Closed-->
				<!--Order List details Right Start-->
				<?php if(!empty($val['OrderItem'])){ ?>
				<div class="order-list-details_r">
					<?php foreach($val['OrderItem'] as $itemKey => $itemVal){ ?>
					<!--Order Products Widget Start-->
					<div style="padding-top:0px;" class="order-products-widget">
						<div class="order-product-image">
							<?php
							$prodDetails = $this->Common->getProductMainDetails($itemVal['product_id']);
							if(!empty($prodDetails['Product']['product_image'])){
								$product_image = WWW_ROOT.PATH_PRODUCT.'small/img_75_'.$prodDetails['Product']['product_image'];
								
								if(file_exists($product_image)){
									echo $html->link($html->image('/'.PATH_PRODUCT.'small/img_75_'.$prodDetails['Product']['product_image'],array('alt'=>"")),'/'.$this->Common->getProductUrl($itemVal['product_id']).'/categories/productdetail/'.$itemVal['product_id'],array('escape'=>false));
								}else{
									echo $html->image('no_image_75.jpg',array('alt'=>""));
								}
							}else{
								echo $html->image('no_image_75.jpg',array('alt'=>""));
							}
							?>
						</div>
						<!--Order Product Content Start-->
						<div class="order-product-content">
							<div class="float-right pad-tp padding_top_17">
								<?php
								if(!empty($itemVal['CancelOrder'])){
									echo $html->image("cancel-item-btn-gray.png",array('alt'=>""));
								} else{
									echo $html->link($html->image("cancel-item-btn.png",array('width'=>"105",'height'=>"16", 'alt'=>"")),'/orders/cancel/'.$itemVal['id'].'/'.$itemVal['order_id'].'/'.$itemVal['seller_id'].'/'.$itemVal['product_id'],array('escape'=>false,'class'=>'cancel_order_item'));
								}?>
							</div>
							<!--Order Product Information Start-->
							<div class="order-pro-info margin_top_13">
								<h2 class="choiceful lrgr-fnt">Awaiting Dispatch</h2>
								<p><?php if(!empty($itemVal['product_name']))
									echo $itemVal['product_name'];
									else
										echo '-';
								?></p>
								<p>
									<span class="gray">Delivery Estimate:</span>
									<strong>
										<?php if(!empty($itemVal['estimated_delivery_date']))
											echo date('d F Y', strtotime($itemVal['estimated_delivery_date']));
											else 
											echo '-';
										?>
									</strong>
										
									<!-- span class="gray">Delivery Estimate:</span--> <!--strong><?php //if(!empty($itemVal['estimated_delivery_date']))
									//echo date('d F Y', strtotime($itemVal['estimated_delivery_date']));
								//else 
								//echo '-'; ?></strong--></p>
								<p><span class="gray">Seller:</span> 
									<?php if(!empty($itemVal['seller_name']))
										$sellerName = $itemVal['seller_name'];
									else
										$sellerName = '';
									if(!empty($itemVal['seller_id']) && !empty($itemVal['product_id']) && !empty($itemVal['condition_id'])){
									$seller_name_url=str_replace(' ','-',html_entity_decode($sellerName, ENT_NOQUOTES, 'UTF-8'));
									echo $html->link($sellerName,'/sellers/'.$seller_name_url.'/summary/'.$itemVal['seller_id'].'/'.$itemVal['product_id'].'/'.$itemVal['condition_id'],array('escape'=>false,'class'=>'underline-link'));
									}else{
										echo $sellerName;
									}
							?></p>
							</div>
							<!--Order Product Information Closed-->
						</div>
						<!--Order Product Content Closed-->
						<div class="clear"></div>
					</div>
					<!--Order Products Widget Closed-->
					<?php } ?>
				</div>
				<!--Order List details Right Closed-->
				<?php } ?>
			</div>
			<!--Order List details Closed-->
			<?php } } else { ?>
				<div class="error_msg_box"> 
					There are currently no orders on file.
				</div>
			<?php } }?>
			