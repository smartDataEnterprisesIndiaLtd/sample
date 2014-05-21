<?php if(!empty($buyer_orders)){
				foreach($buyer_orders AS $key=>$val){
					echo $html->link('','#',array('escape'=>false,'name'=>base64_encode('item_'.$val['OrderItem']['id'])));
					$countryId= $val['Order']['shipping_country']; ?>
					
					<a href="#<?php echo $val['OrderItem']['id'];?>" id="<?php echo $val['OrderItem']['id'];?>" name = "<?php echo $val['OrderItem']['id'];?>" ></a>
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
								</li>
							</ul>
						</div>
						<!--Order List details left Closed-->
						<!--Order List details Right Start-->
						<div class="order-list-details_r margin_left">
							<!--Seller Feedback Widget Start-->
							<div class="seller-feedback-widget">
								<div class="seller-feedback-address">        
									<ul class="order-info">
										<li>
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
									</ul>
								</div>
								<!--Seller Feedback Content Start-->
								<div class="seller-feedback-content seller-feedback-content_new">
									<!-- ajax block starts-->
									<?php if(!empty($val['Feedback']['id'])){
										$this->set('val',$val); ?>
										<div id="feedback_<?php echo $val['OrderItem']['id'];?>">
										<?php echo $this->element('orders/display_feedback');?>
										</div>
									<?php } else { ?>
										<div id="feedback_<?php echo $val['OrderItem']['id'];?>">
											<?php $this->set('itemVal',$val);
											echo $this->element('orders/feedback'); ?></div>
									<?php } ?>
									<!-- ajax block closed-->
								</div>
								<!--Seller Feedback Content Closed-->
								<div class="clear"></div>
							</div>
							<!--Seller Feedback Widget Closed-->
						</div>
						<!--Order List details Right Closed-->
					</div>
					<!--Order List details Closed-->
				<?php }
			} else{ ?>
			<!--div class="order-list-details_l">
					<ul class="order-info">
					<li><p class="no-list">There are currently no orders on file.</p></li>
					</ul>
				</div-->
				<div class="error_msg_box"> There are currently no orders on file.</div>
			<?php } ?>