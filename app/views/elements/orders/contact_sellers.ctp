<!--Order List details Start-->
			<div class="order-list-details overflow-h">
			<?php
			if(!empty($seller_id) && empty($order_user_seller) && $order_user_seller == 0){?>
				<div class="error_msg_box"> Not able to contact seller: only available after placing your order</div>
				
			<?php }else{
				
			if(!empty($buyer_orders)){                                    
				foreach($buyer_orders AS $key=>$val){ //pr($val);
					$countryId= $val['Order']['shipping_country']; ?>
					<!--Order List details left Start-->
					<div class="order-list-details_l">
						<ul class="order-info">
							<li><p><span class="gray">Order Placed:</span></p>
								<h2><?php echo date("j F Y", strtotime($val['Order']['created'])); ?></h2>
							</li>
							<li>
								<p><span class="gray">Order Number:</span> <?php echo $val['Order']['order_number']; ?></p>
							</li>
						</ul>
					</div>
					<!--Order List details left Closed-->
					<!--Order List details Right Start-->
					<div class="order-list-details_r">
						<?php foreach($val['OrderItem']	AS $itemKey => $itemVal){ 
							echo $html->link('','#',array('escape'=>false,'name'=>base64_encode('item_'.$itemVal['id']))); ?>
						<!--Order Products Widget Start-->
						<div  style="padding-top:0px;" class="order-products-widget">
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
							}?>
							</div>
							<!--Order Product Content Start-->
							<div class="order-product-content">
								<!--Order Product Information Start-->
								<div class="order-pro-info">
									<p><?php echo $itemVal['product_name']; ?></p>
									<p><span class="gray">Seller:</span>
									<?php /*if(!empty($itemVal['seller_name']))
											$sellerName = $itemVal['seller_name'];
										else
											$sellerName = '';*/
									if(!empty($itemVal['seller_id']) && !empty($itemVal['product_id']) && !empty($itemVal['condition_id'])){
										$sellerName = $this->Common->businessDisplayName($itemVal['seller_id']);
										$seller_name_url=str_replace(' ','-',html_entity_decode($sellerName, ENT_NOQUOTES, 'UTF-8'));
										echo $html->link($sellerName,'/sellers/'.$seller_name_url.'/summary/'.$itemVal['seller_id'].'/'.$itemVal['product_id'].'/'.$itemVal['condition_id'],array('escape'=>false,'class'=>'underline-link'));
									}else{
										echo $sellerName;
									}
							?>
										<!-- a href="/sellers/summary/<?php //echo $itemVal['seller_id']."/".$itemVal['product_id']."/".$itemVal['condition_id']; ?>" class="underline-link"><?php //echo $itemVal['seller_name']; ?></a--></p>
									<p class="margin-top20">Telephone Customer Service: <strong><?php if(!empty($itemVal['phone_number'])) echo $itemVal['phone_number'];?></strong>. Lines are open during normal business hours.</p>
								</div>
								<!--Order Product Information Closed-->
							</div> 
							<!--Order Product Content Closed-->
							<div class="clear"></div>
							<!--Comment Widget Start-->
							<div class="comment-widget overflow-h">
								<!--Row Start-->
								<div class="row-wid overflow-h">
									<!--Comment Widget Left Start-->
									<div class="comment-widget-text">
										<ul>
											<li>Type your message in the box below. We will forward it to the seller.</li>
										</ul>
									</div>
									<!--Comment Widget Right Closed-->
								</div>
								<!--Row Closed-->
								<!-- ajax block starts-->
								<div id="msg_<?php echo $itemVal['id'];?>">
									<?php $this->set('itemVal',$itemVal);
									$show_hide_error = "none";
									$show_hide_success = "none";
									$send_msg_error_id = $this->Session->read('Order.send_msg_error_id');
									$send_msg_success_id = $this->Session->read('Order.send_msg_success_id');
									 $form_id = '';
									if(isset($send_msg_error_id) && $itemVal['id'] == $send_msg_error_id) {
										$show_hide_error = "block";
										$form_id= $send_msg_error_id;
										
									} else{
										$form_id = NULL;
										$show_hide_error = "none";
									}
									if(isset($send_msg_success_id) && $itemVal['id'] == $send_msg_success_id) {
										$show_hide_success = "block";
									} else{
										$show_hide_success = "none";
									}
									//$this->Session->delete('Order.send_msg_error_id'); ?>
									<div class="message" id="flashMessage" style="display:<?php echo $show_hide_success; ?>">Comment sent successfully.</div>
									<div class="flashError" id="flashMessage" style="display:<?php echo $show_hide_error; ?>">Enter your comments</div>
									<?php echo $this->element('orders/msg',  array('form_id'=>$form_id)); ?>
								</div>
								<!-- ajax block closed-->
							</div>
							<!--Comment Widget Closed-->
							<div class="clear"></div>
						</div>
						<!--Order Products Widget Closed-->
						<?php } ?>
					</div>
					<!--Order List details Right Closed-->
				<?php }
			}else{ ?>
				<!--div class="order-list-details_l">
					<ul class="order-info">
					<li><p class="no-list">There are currently no orders on file.</p></li>
					</ul>
				</div-->
				<!--REF # K2950-->
					<div class="error_msg_box"> There are currently no orders on file.</div>
				<!--div class="error_msg_box"> Not able to contact seller: only available after placing your order</div-->
			<?php } } ?>
			</div>
			<!--Order List details Closed-->