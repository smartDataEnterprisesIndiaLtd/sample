<script>
function fancyboxclose(rurl){
	var site_url = '<?php echo SITE_URL;?>';
	parent.jQuery.fancybox.close();
	window.parent.location.href=site_url+rurl;
}
</script>
<?php //pr($result);?>
<ul class="pop-con-list">
	<li><h4 class="bl-color">Track your Stuff</h4></li>
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
    
    if(!empty($result['Order']['order_number'])){
    $order_no= $result['Order']['order_number'];
    } 
    
		if(!empty($result['ProductSeller']['dispatch_country']))
			$dispatch_country_id = $result['ProductSeller']['dispatch_country'];
	?>
	<li class="margin-tp">
		<div class="lft-con-widget">
			<div class="left-top-sec">
				<p>
				<?php
				$prodDetails = $this->Common->getProductMainDetails($result['OrderItem']['product_id']);
					if(!empty($prodDetails['Product']['product_image'])){
						$product_image = WWW_ROOT.PATH_PRODUCT.'small/img_75_'.$prodDetails['Product']['product_image'];
						if(file_exists($product_image)){
							echo $html->image('/'.PATH_PRODUCT.'small/img_75_'.$prodDetails['Product']['product_image'],array('alt'=>"",'align'=>"left","class"=>"margin-right margin-bottom"));
						}else{
							echo $html->image('no_image_75.jpg',array('alt'=>"",'align'=>"left","class"=>"margin-right margin-bottom"));
						}
					}else{
						echo $html->image('no_image_75.jpg',array('alt'=>"",'align'=>"left","class"=>"margin-right margin-bottom"));
					}?>
				</p>
				<p><?php echo $result['OrderItem']['product_name']; ?></p>
				<p><span class="gr-colr">Delivery Estimate:</span></p>
				<p class="larger-font dif-blue-color"><strong>
				<?php
				if($result['OrderItem']['estimated_delivery_date'] != "" OR $result['OrderItem']['estimated_delivery_date'] != NULL)
				{
					echo date('jS F Y', strtotime($result['OrderItem']['estimated_delivery_date']));
				}
				
				?>
				</strong></p>
			</div>
			<div class="stuff-details">
				<p><span class="gr-colr">Quantity Shipped:</span> <?php echo $total_qty; ?></p>
        <p><span class="orange-color-text"><strong>Order Number:</strong></span> <strong>
					<?php
						if(!empty($order_no)){
							echo $order_no;
						}else{
							echo '';
						}
					?>
					</strong></p>
				<p><span class="orange-color-text"><strong>Dispatched on:</strong></span> <strong>
					<?php
						if(!empty($dispatch_date)){
							echo date('jS F Y', strtotime($dispatch_date));
						}else{
							echo '';
						}
					?>
					</strong></p>
				<p><span class="orange-color-text"><strong>Delivery method:</strong></span> <?php echo $method; ?>
					<a href="javascritp:void(0);" class="smlr-fnt" onclick ="fancyboxclose('pages/view/standard-delivery')">Find out more</a>
				</p>
				<p><span class="orange-color-text"><strong>Shipping Service:</strong></span> <?php echo $shipped_service; ?></p>
				<p><span class="orange-color-text"><strong>Carrier:</strong></span> <?php echo $shipped_via; ?></p>
				<p><span class="orange-color-text"><strong>Tracking ID:</strong></span> <?php echo (!empty($tracking_id))?($tracking_id):('Not available'); ?></p>
				<p><span class="orange-color-text"><strong>Dispatched by:</strong></span> <?php echo $html->link($result['OrderItem']['seller_name'],'javascript:void(0)',array('escape'=>false,'onClick'=>'golink(\'/sellers/summary/'.$result['OrderItem']['seller_id'].'/'.$result['OrderItem']['product_id'].'\');'));?>
				</p>
				<p><span class="orange-color-text"><strong>Dispatched from:</strong></span> <strong><?php if(!empty($dispatch_country_id)) echo $countryArr[$dispatch_country_id]; else echo '-'; ?></strong></p>
			</div>
		</div>
		<!--Left Widget Closed-->
		                                                
		<!--Right Content Widget Start-->
		<div class="rght-con-widget rght-con-widget-newwidth">
			<p><span class="gr-colr">Recipient:</span> <?php echo ucwords($result['Order']['shipping_firstname']." ".$result['Order']['shipping_lastname']); ?></p>
			<p><span class="gr-colr">Delivery Address:</span></p>
			<p><?php echo $result['Order']['shipping_address1']; ?></p>
			<p><?php echo $result['Order']['shipping_address2']; ?></p>
			<p><?php echo $result['Order']['shipping_city']; ?></p>
			<p><?php echo $result['Order']['shipping_postal_code']; ?></p>
			<p class="margin-top"><span class="gr-colr">Order Placed:</span></p>
			<h2><?php echo date("j F Y", strtotime($result['Order']['created'])); ?></h2>
		</div>
		<!--Right Content Widget Closed-->
		
		<div class="clear"></div>
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
<script language="JavaScript">
	function golink(link_url){
		//parent.jQuery.fancybox.close();
		parent.location.href = link_url;
	}
</script>