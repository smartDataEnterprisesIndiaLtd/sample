<?php
e($html->script('fancybox/jquery.fancybox-1.3.4.pack'));
e($html->script('fancybox/jquery.easing-1.3.pack'));
e($html->script('fancybox/jquery.mousewheel-3.0.4.pack',false));
echo $html->css('jquery.fancybox-1.3.4');
?>
<style type="text/css">
.select {
float:none;
margin-right:0px;
}
</style>
<div class="mid-content">
	<?php if(!empty($seller_info['Seller']['business_display_name'])) { ?>
	<h2 class="choice_headding choiceful"><span class="black-color">Browse</span> <?php echo $seller_info['Seller']['business_display_name']."'s Store";?></h2>
	<?php }?>
	<div id="abc">
		<?php echo $this->element('seller/seller_products_store');?>
	</div>
	
	<!--Recent History Widget Start-->
	<div class="">
		<!--Recent History Start-->
		<div class="recent-history">
			<h4><strong>Your Recent History</strong></h4>
			<ul>
				<?php
				if(!empty($myRecentProducts)){
					$i=0;
				foreach ($myRecentProducts as $product){
					if($product['product_image'] == 'no_image.gif' || $product['product_image'] == 'no_image.jpeg'){
						$image_path = '/img/no_image.jpeg';
					} else{
						$image_path = WWW_ROOT.PATH_PRODUCT.'small/img_50_'.$product['product_image'];
						if(!file_exists($image_path) ){
							$image_path = '/img/no_image_50.jpg';
						}else{
							$image_path = '/'.PATH_PRODUCT.'small/img_50_'.$product['product_image'];
						}
						
					}
					$i++;
					if($i > 5){ // ahow only 5 items
						continue;
					}
				?>
				<li>
				<?php  echo $html->image($image_path,array('width'=>"20",'height'=>"20", 'alt'=>""));?> <?php echo $html->link($format->formatString($product['product_name'],25, '..'),"/categories/productdetail/".$product['id'],array('escape'=>false,'class'=>''));?></li>
				<?php  }
				}  ?>
			</ul>
		</div>
		<!--Recent History Closed-->
		<!--Recent History Product List Start-->
		
		
		
<?php if(!empty($continue_shopping)){
?>
<!--Recent History Product List Start-->
<div class="recent-history-pro-list" style="margin-top:45px;">
	<h4 style="font-weight: normal;"><strong>Continue Shopping:</strong> <?php echo $continue_shopping_slogan;?></h4>
		<ul class="products outerdiv_resolution">
		<?php
		$k = 0;
		foreach($continue_shopping as $continue_shopping_items) {
			foreach($continue_shopping_items->attribute as $attribute){
					if($attribute->name == 'secondid' && !empty($attribute->value->_)){
						$continue_shoppings[$k]['secondid'] = $attribute->value->_;
					}
					if($attribute->name == 'product_name' && !empty($attribute->value->_)){
					      $continue_shoppings[$k]['product_name'] = $attribute->value->_;
					}
					if($attribute->name == 'product_image' && !empty($attribute->value->_)){
					      $continue_shoppings[$k]['product_image'] = $attribute->value->_;
					}
					
					if($attribute->name == 'avg_rating' && !empty($attribute->value->_)){
					      $continue_shoppings[$k]['avg_rating'] = $attribute->value->_;
					}
					if($attribute->name == 'product_rrp' && !empty($attribute->value->_)){
					      $continue_shoppings[$k]['product_rrp'] = $attribute->value->_;
					}
					if($attribute->name == 'minimum_price_used' && !empty($attribute->value->_)){
						$continue_shoppings[$k]['minimum_price_used'] = $attribute->value->_;
					}
					if($attribute->name == 'minimum_price_value'  && !empty($attribute->value->_)){
						$continue_shoppings[$k]['minimum_price_value'] = $attribute->value->_;
					}
					if($attribute->name == 'minimum_price_seller'  && !empty($attribute->value->_)){
						$continue_shoppings[$k]['minimum_price_seller'] = $attribute->value->_;
					}
					if($attribute->name == 'minimum_price_used_seller'  && !empty($attribute->value->_)){
						$continue_shoppings[$k]['minimum_price_used_seller'] = $attribute->value->_;
					}
					if($attribute->name == 'condition_new' && !empty($attribute->value->_)){
						$continue_shoppings[$k]['condition_new'] = $attribute->value->_;
					}
					if($attribute->name == 'condition_used'  && !empty($attribute->value->_)){
						$continue_shoppings[$k]['condition_used'] = $attribute->value->_;
					}
				}
				$k++;
			}?>
			<?php
			if(!empty($continue_shoppings)){
				$j = 1;
				foreach($continue_shoppings as $continue_shoppings){
					if(!empty($continue_shoppings['product_image'])) {
						$image_path = WWW_ROOT.PATH_PRODUCT."/small/img_100_".$continue_shoppings['product_image'];
						if(!file_exists($image_path) ){
							$image_path = '/img/no_image_100.jpg';
						}else{
							$image_path = '/'.PATH_PRODUCT.'small/img_100_'.$continue_shoppings['product_image'];
						}
					} else {
						$image_path = '/img/no_image_100.jpg';
					}
					$product_rrp = $continue_shoppings['product_rrp'];
					$pr_name = $continue_shoppings['product_name'];
					$pr_id = $this->Common->getProductId_Qccode($continue_shoppings['secondid']);
			?>
				<li class="inner_div_resolution res<?php echo $j?>">
					<p class="image-sec"><?php 
					echo $html->link($html->image($image_path,array('alt'=>$pr_name,'title'=>$pr_name )), "/".$this->Common->getProductUrl($pr_id)."/categories/productdetail/".$pr_id,array( 'escape'=>false)); ?></p>
					<p><?php echo $html->link($this->Format->formatString($pr_name,75,'...'),"/".$this->Common->getProductUrl($pr_id)."/categories/productdetail/".$pr_id,null);?></p>
					<p class="price larger-font">
						<strong>
							<?php if(!empty($continue_shoppings['minimum_price_value'])){
									$min_price = $continue_shoppings['minimum_price_value'];
									if(!empty($continue_shoppings['minimum_price_seller'])){
										$min_seller_id = $continue_shoppings['minimum_price_seller'];
									}
								} else if(!empty($continue_shoppings['minimum_price_used'])){
									$min_price = $continue_shoppings['minimum_price_used'];
									
									if(!empty($continue_shoppings['minimum_price_used_seller'])){
										$min_seller_id = $continue_shoppings['minimum_price_used_seller'];
									}
								}else{
									$min_con_id = '';
									$min_seller_id = '';
									$min_price = '';
									$total_save = 0;
									$saving_percentage = 0;
								}
								// There is some change in FH We get directly conditin id from FH on 2-2-2012.
								if(!empty($continue_shoppings['condition_new'])){
										$min_con_id = $continue_shoppings['condition_new'];
									}else if(!empty($continue_shoppings['condition_used'])){
										$min_con_id = $continue_shoppings['condition_used'];
									}else{
										$min_con_id = '';
									}
									
								?>
								
								<?php if(!empty($pr_id) && !empty($min_seller_id) && !empty($min_con_id)){
									$prodSellerInfo = $common->getProductSellerInfo($pr_id ,$min_seller_id, $min_con_id);
									$prodStock = $prodSellerInfo['ProductSeller']['quantity'];
									if($prodStock > 0){
										echo CURRENCY_SYMBOL.' '.$format->money($min_price,2);
									}else{
										echo CURRENCY_SYMBOL.' '.$format->money($product_rrp,2);
									}
								}else{
									echo CURRENCY_SYMBOL.' '.$format->money($product_rrp,2);
								}
							?>
								
							<?php //echo CURRENCY_SYMBOL.$product_rrp; ?>
						</strong>
					</p>
				</li>
			<?php 	$j ++; }
			}?>
	</ul>
</div>
<!--Recent History Product List Closed-->
<?php } ?>
<?php echo $javascript->link(array('change_resolution'));?>
</div>
	<!--Recent History Widget Closed-->
</div>

<script type="text/javascript">


</script>