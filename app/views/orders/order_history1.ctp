<?php
e($html->script('fancybox/jquery.fancybox-1.3.1.pack'));
e($html->script('fancybox/jquery.easing-1.3.pack'));
e($html->script('fancybox/jquery.mousewheel-3.0.2.pack'));
echo $html->css('jquery.fancybox-1.3.1');
?>

<script language="text/javascript">
jQuery(document).ready(function()  { // for writing a review
	jQuery("a.large-image").fancybox({
			'autoScale' : true,
			'width' : 600,
			'height' : 670,
			'padding':0,
			'overlayColor':'#fff',
			'overlayOpacity':0.7,
			'opacity':	true,
			'transitionIn' : 'fade',
			'transitionOut' : 'fade',
			'type' : 'iframe',
			'autoDimensions': false,
		});
});

</script>
 <!--mid Content Start-->
	<div class="mid-content">
		<div class="breadcrumb-widget"><a href="#">Home</a> &gt; <a href="#">My Account</a> &gt; <span class="choiceful"><strong>Orders</strong></span></div>
		
		<!--Setting Tabs Widget Start-->
		<div class="row">
			<?php echo $this->element('orders/tab');?>
		</div>
		<!--Tabs Widget Closed-->
			
		<!--Tabs Content Start-->
		<div class="tabs-content">
				
			<div class="order-history-top"><img src="/img/order-history-image.jpg"  alt="" /></div>
			
			<?php 
			if(!empty($buyer_orders)){ 
			foreach($buyer_orders AS $key=>$val){
			//$val = $buyer_orders[0];
				$countryId = $val['Order']['shipping_country'];
			?>
<!-- order starts here -->
			<!--Order List details Start-->
			<div class="order-list-details overflow-h">
				
				<!--Order List details left Start-->
				<div class="order-list-details_l">
					<ul class="order-info">
					<li><p><span class="gray">Order Placed:</span></p>
						<h2><?php echo date("d F Y", strtotime($val['Order']['created'])); ?></h2>
					</li>
					<li>
						<p><span class="gray">Order Number:</span> <?php echo $val['Order']['id']; ?></p>
						<p><span class="gray">Recipient:</span> <?php echo ucwords($val['Order']['shipping_firstname']." ".$val['Order']['shipping_lastname']); ?></p>
						<p><span class="gray">Delivery Address:</span></p>
						<p><?php echo $val['Order']['shipping_address1']." ".$val['Order']['shipping_address2']; ?></p>
						<p><?php echo $val['Order']['shipping_city']; ?></p>
						<p><?php echo $countryArr[$countryId];?></p>
						<p><?php echo $val['Order']['shipping_postal_code']; ?></p>
					</li>
					<li><p><span class="gray">Order Total:</span> <span class="red-color"><strong>&pound;<?php echo $val['Order']['order_total_cost']; ?></strong></span></p>
						<p><a href="#" class="underline-none-link">Print Order Summary</a></p>
					</li>
					</ul>
				</div>
				<!--Order List details left Closed-->
					
				<!--Order List details Right Start-->
				<div class="order-list-details_r">

				<?php foreach($val['OrderItem']	AS $itemKey => $itemVal){ //pr($itemVal); ?>
<!-- inner items starts -->
				<!--Order Products Widget Start-->
					<div class="order-products-widget">
					<div class="order-product-image">
						<?php
						if(!empty($itemVal['product_image'])){
							$product_image = WWW_ROOT.PATH_PRODUCT.'small/img_75_'.$itemVal['product_image'];
							if(file_exists($product_image)){
								echo $html->image('/'.PATH_PRODUCT.'small/img_75_'.$itemVal['product_image'],array('alt'=>""));
							}else{
								echo $html->image('no_image.jpeg',array('alt'=>""));
							}
						}else{
							echo $html->image('no_image.jpeg',array('alt'=>"", 'height'=>'75', 'width'=>'75'));
						}?>
					</div>
						
					<!--Order Product Content Start-->
					<div class="order-product-content">
							
						<!--Order Product Information Start-->
						<div class="order-pro-info">
						<h2 class="choiceful lrgr-fnt">Awaiting Dispatch</h2>
						<p><?php echo $itemVal['product_name']; ?></p>
						<p><span class="gray">Delivery Estimate:</span> <strong><?php echo date('d F Y', strtotime($itemVal['estimated_delivery_date'])); ?></strong></p>
						<p><span class="gray">Seller:</span> <a href="/sellers/summary/<?php echo $itemVal['product_id']; ?>" class="underline-link"><?php echo $itemVal['seller_name']; ?></a></p>
						</div>
						<!--Order Product Information Closed-->
						
						
					</div>
					<!--Order Product Content Closed-->
						
					<div class="clear"></div>
						
					<!--Buttons Widget Start-->
					<div class="buttons-widget overflow-h">
						<ul>
						<li><a href="/orders/leave_seller_feedback/" class="grn-button">Leave Seller Feedback</a></li>
						<li><a href="/orders/return_items/" class="grn-button">Return Items</a></li>
						<li><a href="#" class="bl-button">Tracking Information</a></li>
						</ul>
						<div class="clear"></div>
						<ul>
						<li><a href="/orders/contact_seller/" class="grn-button">Contact Seller</a></li>

						<p><?php $linkmain_str = '/orders/file_a_claim/'.$itemVal['seller_id'].'/'.$itemVal['id'].'/'.$itemVal['product_id'].'/'.$itemVal['product_name'].'/'.$itemVal['seller_name'];
						echo $html->link('<strong>File a Claim</strong>',$linkmain_str,array('escape'=>false,'class'=>'large-image'));?></p>

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
				<div class="order-list-details_l">
					<ul class="order-info">
					<li><p class="no-list">There are currently no orders on file.</p></li>
					</ul>
				</div>
			
			<?php } ?>
			
		</div>
		<!--Tabs Content Closed-->
			
		</div>
		<!--Setting Tabs Widget Closed-->
		
	</div>
        <!--mid Content Closed-->