
			<?php 
			if(!empty($buyer_orders)){ 
			
			foreach($buyer_orders AS $key=>$val){
				$countryId = $val['Order']['shipping_country'];
			?>
			<!--Order List details Start-->
			<div class="order-list-details overflow-h">
				
				<!--Order List details left Start-->                   
				<div class="order-list-details_l">
					<ul class="order-info">
					<li><p><span class="gray">Order Placed:</span></p>
						<h2><?php echo date("j F Y", strtotime($val['Order']['created'])); ?></h2>
					</li>
					<li>
						<p><span class="gray">Order Number:</span> <?php echo $val['Order']['order_number']; ?></p>
						<p><span class="gray">Recipient:</span> <?php echo ucwords($val['Order']['shipping_firstname']." ".$val['Order']['shipping_lastname']); ?></p>
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
					<li><p><span class="gray">Order Total:</span> <span class="red-color"><strong>&pound;<?php echo $val['Order']['order_total_cost']; ?></strong></span></p>
						<p><?php $this->set('val',$val);
							echo $this->element('orders/print_purchaseorder_slip');?></p>
					</li>
					</ul>
				</div>
				<!--Order List details left Closed-->
					
				<!--Order List details Right Start-->
				<div class="order-list-details_r">

				<?php foreach($val['OrderItem']	AS $itemKey => $itemVal){ ?>
				<!-- inner items starts -->
				<!--Order Products Widget Start-->
					<div class="padding_top_0 order-products-widget">
					<div class="padding_top_0 order-product-image">
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
						}?>
					</div>
						
					<!--Order Product Content Start-->
					<div class="order-product-content">
							
						<!--Order Product Information Start-->
						<div class="order-pro-info">
						<h2 class="choiceful lrgr-fnt padding_top_12">Dispatched</h2>
						<p><?php echo $itemVal['product_name']; ?></p>
						<p><span class="gray">Delivery Estimate:</span> <strong><?php if(!empty($itemVal['estimated_delivery_date'])) echo date('j F Y', strtotime($itemVal['estimated_delivery_date'])); ?></strong></p>
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
							?>
							
							<!--a href="/sellers/summary/<?php //echo $itemVal['seller_id']; ?>/<?php //echo $itemVal['product_id']; ?>" class="underline-link"><?php //echo $itemVal['seller_name']; ?></a--></p>
						</div>
						<!--Order Product Information Closed-->
						
						
					</div>
					<!--Order Product Content Closed-->
						
					<div class="clear"></div>
						
					<!--Buttons Widget Start-->
					<div class="buttons-widget overflow-h">
						<ul>
						<li><?php echo $html->link('Leave Seller Feedback',"/orders/leave_seller_feedback/".base64_encode($itemVal['id'])."/#".base64_encode("item_".$itemVal['id']),array('class'=>"grn-button"));?></li>
						<?php if($itemVal['total_returned'] < $itemVal['total_dispatched']) { ?>
						<li><?php echo $html->link('Return Items',"/orders/return_items/".base64_encode($itemVal['id'])."/#OI".$itemVal['id'],array('class'=>"grn-button"));?></li>
						<?php } ?>
						<li><?php $linkmain_str = '/orders/track_your_order/'.$itemVal['seller_id'].'/'.$itemVal['id'].'/'.$itemVal['product_id'].'/'.$itemVal['product_name'].'/'.$itemVal['seller_name'];
						echo $html->link('<strong>Tracking Information</strong>',$linkmain_str,array('escape'=>false,'class'=>'bl-button track'));?></li>

						</ul>
						<div class="clear"></div>
						<ul>
						<li><?php echo $html->link('Contact Seller',"/orders/contact_sellers/#".base64_encode("item_".$itemVal['id']),array('class'=>"grn-button")); ?></li>
						<li><?php $linkmain_str = '/orders/file_a_claim/'.$itemVal['seller_id'].'/'.$itemVal['id'].'/'.$itemVal['product_id'].'/'.$itemVal['product_name'].'/'.$itemVal['seller_name'];
						echo $html->link('<strong>File a Claim</strong>',$linkmain_str,array('escape'=>false,'class'=>'grn-button fileaclaim'));?></li>
						
						<!--<li><?php //echo $html->link('File a Claim','',array('escape'=>false,'class'=>'grn-button fileclaim'));?></li>-->
						</ul>
					</div>
					<!--Buttons Widget Closed-->
						
					</div>
					<!--Order Products Widget Closed-->
<!-- inner items closed -->
				<?php } ?>	
				</div>
				<!--Order List details Right Closed-->
				
			</div>
			<!--Order List details Closed-->
<!-- order ends here -->
			
			<?php } }else{ ?>	
				<!--div class="order-list-details_l">
					<ul class="order-info">
					<li><p class="no-list">There are currently no orders on file.</p></li>
					</ul>
				</div-->
				<div class="error_msg_box"> There are currently no orders on file.</div>
			
			<?php }  ?>