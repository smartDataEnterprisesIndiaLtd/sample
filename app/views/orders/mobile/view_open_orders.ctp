<?php ?>
<!--mid Content Start-->
 <!--Tabs Start-->
<?php echo $this->element("mobile/orders/tab"); ?>
<!--Tbs Closed-->

<!--Tbs Cnt start-->
<section class="tab-content">

<?php if ($session->check('Message.flash')) { ?>
	<div  class="messageBlock"><?php echo $session->flash();?></div>
<?php } ?>

<?php if(!empty($buyer_orders)){
	$i = 0;
	foreach($buyer_orders as $key=>$val){
	$countryId = $val['Order']['shipping_country'];
?>
	<!--Row1 Start-->
	<?php if($i == 0){
		$cla = 'row';
	}else{
		$cla = 'row border-top-dashed';
	}
	?>
	<div class="<?php echo $cla;?>">
			<ul class="order-info">
			<li>
				<p><span class="gray">Order Placed:</span></p>
				<h2 class="font20">
					<?php if(!empty($val['Order']['created']))
						echo date("j F Y", strtotime($val['Order']['created'])); 
					?>
				</h2>	
			</li>
			<li>
				<p>
					<span class="gray">Order Number:</span> 
					<?php if(!empty($val['Order']['order_number'])) echo $val['Order']['order_number']; ?>
				</p>
				
				<p>
					<span class="gray">Recipient:</span>
					<?php 
					if(!empty($val['Order']['shipping_firstname']))
						echo ucwords(strtolower($val['Order']['shipping_firstname']));
						
						if(!empty($val['Order']['shipping_lastname']))
						echo ' '.ucwords(strtolower($val['Order']['shipping_lastname']));
					?>
				</p>
				
				<p><span class="gray">Delivery Address:</span></p>
				<?php if(!empty($val['Order']['shipping_address1'])) { ?>
					<p>
						<?php echo $val['Order']['shipping_address1']; ?>
					</p>
				<?php }?>
				
				<?php if(!empty($val['Order']['shipping_address2'])) { ?>
					<p>
						<?php echo $val['Order']['shipping_address2']; ?>
					</p>
				<?php }?>
				
				<?php if(!empty($val['Order']['shipping_city'])) { ?>
					<p>
						<?php echo $val['Order']['shipping_city']; ?>
					</p>
				<?php }?>
				
				<?php if(!empty($countryId)) { ?>
					<p>
						<?php $countryArr[$countryId]; ?>
					</p>
				<?php }?>
				
				<?php if(!empty($val['Order']['shipping_postal_code'])) { ?>
					<p>
						<?php echo $val['Order']['shipping_postal_code']; ?>
					</p>
				<?php }?>
			</li>
			<li class="bottom-line">
				<p>
				<span class="gray">Order Total:</span> 
					<span class="rd_clr">
						<strong>
							<?php echo CURRENCY_SYMBOL.''.$format->money($val['Order']['order_total_cost'],2);?>
						</strong>
					</span>
				</p>
				
				<p class="print-sec">
					<?php $this->set('val',$val);
						echo $this->element('mobile/orders/print_purchaseorder_slip');
					?>
				</p>
				<div class="clear"></div>
			</li>
			</ul>
			
			<!--Products Start-->
			<?php if(!empty($val['OrderItem'])){ ?>
			<div class="prod">
				<?php foreach($val['OrderItem'] as $itemKey => $itemVal){ ?>
				<!--Order Products Widget Start-->
				<div class="order-products-widget">
				<div class="order-product-image">
					<?php
						$prodDetails = $this->Common->getProductMainDetails($itemVal['product_id']);
						if(!empty($prodDetails['Product']['product_image'])){
							$product_image = WWW_ROOT.PATH_PRODUCT.'small/img_75_'.$prodDetails['Product']['product_image'];
							
							if(file_exists($product_image)){
								echo $html->link($html->image('/'.PATH_PRODUCT.'small/img_75_'.$prodDetails['Product']['product_image'],array('alt'=>"")),'/'.$this->Common->getProductUrl($itemVal['product_id']).'/categories/productdetail/'.$itemVal['product_id'],array('escape'=>false));
							}else{
								echo $html->link($html->image('no_image_75.jpg',array('alt'=>"")),'/'.$this->Common->getProductUrl($itemVal['product_id']).'/categories/productdetail/'.$itemVal['product_id'],array('escape'=>false));
							}
						}else{
							echo $html->link($html->image('no_image_75.jpg',array('alt'=>"")),'/'.$this->Common->getProductUrl($itemVal['product_id']).'/categories/productdetail/'.$itemVal['product_id'],array('escape'=>false));
						}
					?>
				</div>
				
				<!--Order Product Content Start-->
				<div class="order-product-content">                           
				<!--Order Product Information Start-->
				<div class="order-pro-info">
					<h2 class="choiceful font20">Awaiting Dispatch</h2>
						<p>
							<?php if(!empty($itemVal['product_name']))
								echo $itemVal['product_name'];
									else
								echo '-';
							?>
						</p>
					<p>	
						<span class="gray">Delivery Estimate:</span> 
						<strong>
							<?php if(!empty($itemVal['estimated_delivery_date']))
									echo date('d F Y', strtotime($itemVal['estimated_delivery_date']));
								else 
									echo 'Not Available'; 
							?>
						</strong>
					</p>
					
					<p><span class="gray">Seller:</span>
						<?php 
						if(!empty($itemVal['seller_name']))
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
					</p>
				</div>
				<!--Order Product Information Closed-->
					<div class="pad-tp">
						<?php
							if(!empty($itemVal['CancelOrder'])){
								echo $html->image("cancel-item-btn-gray.png",array('alt'=>""));
							} else{
								echo $html->link($html->image("cancel-item-btn.png",array('width'=>"105",'height'=>"16", 'alt'=>"")),'/orders/cancel/'.$itemVal['id'].'/'.$itemVal['order_id'].'/'.$itemVal['seller_id'].'/'.$itemVal['product_id'],array('escape'=>false,'class'=>'cancel_order_item'));
							}
						?>
					</div>
				</div>
				<!--Order Product Content Closed-->                        
				<div class="clear"></div>                        
			</div>
			<!--Order Products Widget Closed-->
			<?php } ?>
				</div>
				<!--Products Closed-->
			<?php } ?>
			
			</div>
			<!--Row1 Closed-->
			<?php $i++;?>
	<?php } } else { ?>
		<p class="no-list">There are currently no orders on file.</p>
	<?php } ?>




	
	<!--Row2 Start-->
<!--<div class="row border-top-dashed pd-btm-none">
	<ul class="order-info">
	<li>
		<p><span class="gray">Order Placed:</span></p>
		<h2 class="font20">17 July 2010</h2>
	</li>
	<li>
		<p><span class="gray">Order Number:</span> 2559-711110215-000153</p>
		<p><span class="gray">Recipient:</span> David Smith</p>
		<p><span class="gray">Delivery Address:</span></p>
		<p>162 Windmill Road West</p>
		<p>Sunbury Upon Thames</p>
		<p>Surrey</p>
		<p>TW167HB</p>
	</li>
	<li class="bottom-line">
		<p><span class="gray">Order Total:</span> <span class="rd_clr"><strong>&pound;298.52</strong></span></p>
		<p class="print-sec"><img src="images/print_icon.png" width="24" height="24" alt="" /> <a href="#" class="underline-none-link">Print Order Summary</a></p>
		<div class="clear"></div>
	</li>
	</ul>-->
	
	<!--Products Start-->
	<!--<div class="prod">-->
		<!--Order Products Widget Start-->
	<!--<div class="order-products-widget">
		<div class="order-product-image"><img src="images/order-img3.jpg" width="81" height="97" alt="" /></div>-->                            
		<!--Order Product Content Start-->
		<!--<div class="order-product-content">-->
			
		<!--Order Product Information Start-->
		<!--<div class="order-pro-info">
			<h2 class="choiceful font20">Awaiting Dispatch</h2>
			<p>Hammerite Black hammered Finish Metal paint 500ml</p>
			<p><span class="gray">Delivery Estimate:</span> <strong>14 September 2010</strong></p>
			<p><span class="gray">Seller:</span> <a href="#" class="underline-link">Choiceful warehouse</a></p>
		</div>-->
		<!--Order Product Information Closed--> 
		<!--<div class="pad-tp"><a href="#"><img src="images/cancel-item-btn.png" width="105" height="16" alt="" /></a></div>                              
		</div>-->
		<!--Order Product Content Closed-->
		<!--<div class="clear"></div>-->
	<!--</div>-->
	<!--Order Products Widget Closed-->
	
	<!--</div>-->
	<!--Products Closed-->
	
	<!--</div>-->
	<!--Row2 Closed-->
	
	
	
	
	
	
</section>
<!--Tbs Cnt closed-->
<!--mid Content Closed-->