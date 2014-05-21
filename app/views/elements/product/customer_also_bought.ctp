<?php if(!empty($customer_also_bought)){ ?>
<!--Customers Who Bought This Item Also Bought Start-->
<div class="row no-pad-btm">
	<h4 class="mid-gr-head blue-color"><span><?php echo $customer_also_bought_slogan;?></span></h4>
	<!--Products Widget Start-->
	<div class="top-products-widget outerdiv_resolution">
		<ul class="products no-pad-btm" id="outer_div">
			<?php
			//pr($customer_also_bought);
			$k = 0;
			foreach($customer_also_bought as $customer_also_bought_item){
				//pr($customer_also_bought_item);
				
				foreach($customer_also_bought_item->attribute as $attribute){
					if($attribute->name == 'secondid' && !empty($attribute->value->_)){
						$customer_also[$k]['secondid'] = $attribute->value->_;
					}
					if($attribute->name == 'product_name' && !empty($attribute->value->_)){
					      $customer_also[$k]['product_name'] = $attribute->value->_;
					}
					if($attribute->name == 'product_image' && !empty($attribute->value->_)){
					      $customer_also[$k]['product_image'] = $attribute->value->_;
					}
						
					if($attribute->name == 'avg_rating' && !empty($attribute->value->_)){
					      $customer_also[$k]['avg_rating'] = $attribute->value->_;
					}
					if($attribute->name == 'product_rrp' && !empty($attribute->value->_)){
					      $customer_also[$k]['product_rrp'] = $attribute->value->_;
					}
					if($attribute->name == 'minimum_price_used' && !empty($attribute->value->_)){
						$customer_also[$k]['minimum_price_used'] = $attribute->value->_;
					}
					if($attribute->name == 'minimum_price_value'  && !empty($attribute->value->_)){
						$customer_also[$k]['minimum_price_value'] = $attribute->value->_;
					}
					if($attribute->name == 'minimum_price_seller'  && !empty($attribute->value->_)){
						$customer_also[$k]['minimum_price_seller'] = $attribute->value->_;
					}
					if($attribute->name == 'minimum_price_used_seller'  && !empty($attribute->value->_)){
						$customer_also[$k]['minimum_price_used_seller'] = $attribute->value->_;
					}
					if($attribute->name == 'condition_new' && !empty($attribute->value->_)){
						$customer_also[$k]['condition_new'] = $attribute->value->_;
					}
					if($attribute->name == 'condition_used'  && !empty($attribute->value->_)){
						$customer_also[$k]['condition_used'] = $attribute->value->_;
					}
				}
				$k++;
			}?>		
					
				<?php	
				if(!empty($customer_also)){
					$i = 1;
					foreach($customer_also as $customer_also){
						if(!empty($customer_also['product_image'])) {
							$image_path = WWW_ROOT.PATH_PRODUCT."/small/img_100_".$customer_also['product_image'];
							if(!file_exists($image_path) ){
								$image_path = '/img/no_image_100.jpg';
							}else{
								$image_path = '/'.PATH_PRODUCT.'small/img_100_'.$customer_also['product_image'];
							}
						} else {
							$image_path = '/img/no_image_100.jpg';
						}
						$product_rrp = $customer_also['product_rrp'];
						$pr_name = $customer_also['product_name'];
						$pr_id = $this->Common->getProductId_Qccode($customer_also['secondid']);
				?>
					<li class="inner_div_resolution res<?php echo $i?>">
					<div class="conti_shp">
						<p class="image-sec"><?php 
						echo $html->link($html->image($image_path,array('alt'=>$pr_name ,'title'=>$pr_name )),'/'.$this->Common->getProductUrl($pr_id).'/categories/productdetail/'.$pr_id,array('escape'=>false));?></p>
						<p  class="conti_shp_width"><?php echo $html->link($format->formatString($pr_name,500,'...'),'/'.$this->Common->getProductUrl($pr_id).'/categories/productdetail/'.$pr_id,array('escape'=>false,'class'=>''));?></p>
						<p class="price larger-font">
							<strong>
								<?php if(!empty($customer_also['minimum_price_value'])){
									$min_price = $customer_also['minimum_price_value'];
									if(!empty($customer_also['minimum_price_seller'])){
										$min_seller_id = $customer_also['minimum_price_seller'];
									}
								} else if(!empty($customer_also['minimum_price_used'])){
									$min_price = $customer_also['minimum_price_used'];
									
									if(!empty($customer_also['minimum_price_used_seller'])){
										$min_seller_id = $customer_also['minimum_price_used_seller'];
									}
								}else{
									$min_con_id = '';
									$min_seller_id = '';
									$min_price = '';
									$total_save = 0;
									$saving_percentage = 0;
								}
								// There is some change in FH We get directly conditin id from FH on 2-2-2012.
								if(!empty($customer_also['condition_new'])){
										$min_con_id = $customer_also['condition_new'];
									}else if(!empty($customer_also['condition_used'])){
										$min_con_id = $customer_also['condition_used'];
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
								<?php //echo CURRENCY_SYMBOL.' '.$format->money($product_rrp,2); ?>
							</strong>
						</p>
						</div>
					</li>
					<?php $i++?>
					<?php }
				}?>
		</ul>
	</div>
	<!--Products Widget Closed-->
</div>
<!--Customers Who Bought This Item Also Bought Closed-->
<?php } ?>
<script>
var width_pre_div = 968;

</script>
<?php //echo $javascript->link(array('change_resolution'));?>