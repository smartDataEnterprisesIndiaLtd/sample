<?php //pr($result);?>
<!--Tabs Start-->
<!--section class="tabs-widget">
<ul>
	<li><a href="#">Open <span class="ln-brk">Orders</span></a></li>
	<li><a href="#" class="active">Order <span class="ln-brk">History</span></a></li>
	<li class="single"><a href="#">My Offers</a></li>
	<li class="wider"><a href="#">Gift <span class="ln-brk">Certificates</span></a></li>
	<li class="wider single orng-link"><a href="#" class="border-none">Marketplace</a></li>
</ul>
</section-->
<?php echo $this->element('mobile/orders/tab');?>
<!--Tbs Closed-->

<!--Tbs Cnt start-->
<section class="tab-content">
<!--Row1 Start-->
<div class="row">

	<h4 class="blu-clr font14">Track your Stuff</h4>
	<?php if(is_array($result)){
		if($result['OrderItem']['delivery_method'] == 'S'){ 
			$method = 'Standard Shipping';
		}else if($result['OrderItem']['delivery_method'] == 'E'){ 
			$method = 'Express Shipping';
		}
		$total_qty =0;
		if(!empty($result['DispatchedItem'])){
			foreach($result['DispatchedItem'] as $dispatchitems){
				$dispatch_date = $dispatchitems['shipping_date'];
				$tracking_id = $dispatchitems['tracking_id'];
				if($dispatchitems['shipping_carrier'] == 8 || $dispatchitems['shipping_carrier'] == 9) {
					$shipped_via = $dispatchitems['other_carrier'];
				}else {
					$shipped_via = $carrierArr[$dispatchitems['shipping_carrier']];
				}
				
				$shipped_service = $dispatchitems['shipping_service'];
				$total_qty = $total_qty + $dispatchitems['quantity'];
			}
		} else{
			$dispatch_date = '';
			$tracking_id = 'Not Available';
			$shipped_via = '';
			$shipped_service = '';
		}
		//pr($result);
		//if(!empty($result['ProductSeller']['dispatch_country']))
			//echo $dispatch_country_id = $result['ProductSeller']['dispatch_country'];
			
		if(!empty($result['Order']['shipping_country']))
			$dispatch_country_id = $result['Order']['shipping_country'];
	?>
	<!--Products Start-->
		<div class="prod">
			<!--Order Products Widget Start-->
			<div class="order-products-widget">
			<div class="order-product-image">
				<?php
				$prodDetails = $this->Common->getProductMainDetails($result['OrderItem']['product_id']);
				if(!empty($prodDetails['Product']['product_image'])){
					$product_image = WWW_ROOT.PATH_PRODUCT.'small/img_75_'.$prodDetails['Product']['product_image'];
					if(file_exists($product_image)){
						echo $html->link($html->image('/'.PATH_PRODUCT.'small/img_75_'.$prodDetails['Product']['product_image'],array('alt'=>"",'align'=>"left","class"=>"margin-right margin-bottom")), "/".$this->Common->getProductUrl($prodDetails['Product']['id'])."/categories/productdetail/".$prodDetails['Product']['id'],array( 'escape'=>false));
					}else{
						echo $html->link($html->image('no_image_75.jpg',array('alt'=>"",'align'=>"left","class"=>"margin-right margin-bottom")), "/".$this->Common->getProductUrl($prodDetails['Product']['id'])."/categories/productdetail/".$prodDetails['Product']['id'],array( 'escape'=>false));
					}
				}else{
					echo $html->link($html->image('no_image_75.jpg',array('alt'=>"",'align'=>"left","class"=>"margin-right margin-bottom")), "/".$this->Common->getProductUrl($prodDetails['Product']['id'])."/categories/productdetail/".$prodDetails['Product']['id'],array( 'escape'=>false));
				}?>
			</div>
			<!--Order Product Content Start-->
			<div class="order-product-content">
			<!--Order Product Information Start-->
			<div class="order-pro-info">
				<p><?php echo $html->link($result['OrderItem']['product_name'], "/".$this->Common->getProductUrl($prodDetails['Product']['id'])."/categories/productdetail/".$prodDetails['Product']['id'],array( 'escape'=>false)); ?></p>
				<p><span class="gray">Delivery Estimate:</span> </p>
				<h2 class="diff-blu font14">
					<?php echo date('jS F Y', strtotime($result['OrderItem']['estimated_delivery_date'])); ?>
				</h2>
			</div>
			<!--Order Product Information Closed-->
			</div>
			<!--Order Product Content Closed-->                        
			<div class="clear"></div>
			
		</div>
		<!--Order Products Widget Closed-->
		
		</div>
	<!--Products Closed-->
		<ul class="order-info tracking-info">
		<li class="line-height18">
			<p>
				<span class="gray">Order Number:</span>
				<?php  echo $result['Order']['order_number'];?>
			</p>
			<p>
				<span class="orng-clr">
					<strong>Dispatched on:</strong>
				</span>
				<strong>
					<?php
						if(!empty($dispatch_date)){
							echo date('jS F Y', strtotime($dispatch_date));
						}else{
							echo '';
						}
					?>
				</strong>
			</p>
			<p>
				<span class="orng-clr">
				<strong>Delivery method:</strong>
				</span> 
				<?php echo $method; ?> 
			</p>
			<p>
				<span class="orng-clr">
				<strong>Shipped via:</strong>
				</span><?php echo $shipped_service; ?>
			</p>
			<p>
				<span class="orng-clr">
				<strong>Carrier:</strong>
				</span> 
				<?php echo $shipped_via; ?>
				<!--span class="choiceful"-->
				<span class="orng-clr">
				<strong>Tracking ID:</strong>
				</span> 
				<?php echo (!empty($tracking_id))?($tracking_id):('Not available'); ?>
			</p>
			<p>
				<span class="orng-clr">
				<strong>Dispatched by:</strong>
				</span> 
				<?php echo $html->link($result['OrderItem']['seller_name'],'javascript:void(0)',array('escape'=>false,'onClick'=>'golink(\'/sellers/summary/'.$result['OrderItem']['seller_id'].'/'.$result['OrderItem']['product_id'].'\');'));?>
			</p>
			<p>
				<span class="orng-clr">
				<strong>Dispatched from:</strong>
				</span>
				<?php if(!empty($dispatch_country_id)) echo '<strong>'.$countryArr[$dispatch_country_id].'</strong>'; else echo '--'; ?>
			</p>
		</li>
		<li>
			<p>
				<span class="gray">Recipient:</span>
				<?php echo ucwords($result['Order']['shipping_firstname']." ".$result['Order']['shipping_lastname']); ?>
			</p>
			<p>
				<span class="gray">Delivery Address:</span>
			</p>
			<p>
				<?php echo $result['Order']['shipping_address1']." ".$result['Order']['shipping_address2']; ?></p>
			<p>	
				<?php echo $result['Order']['shipping_city']; ?>
			</p>
			<p>	
				<?php echo $result['Order']['shipping_postal_code']; ?>
			</p>
			<!--p class="margin-top">
				<span class="gr-colr">Order Placed:</span>
			</p-->
			<!--h2--><?php //echo date("d F Y", strtotime($result['Order']['created'])); ?><!--/h2-->
			
		</li>
	<?php }else{ ?>	
		<li>
			<div class="order-list-details_l">
				<ul class="order-info">
				<li><p class="no-list">There are currently no orders on file.</p></li>
				</ul>
			</div>
		</li>
	<?php } ?>
	</ul>
	
</div>
<!--Row1 Closed-->

</section>
<!--Tbs Cnt closed-->
<script language="JavaScript">
	function golink(link_url){
		//parent.jQuery.fancybox.close();
		parent.location.href = link_url;
	}
</script>