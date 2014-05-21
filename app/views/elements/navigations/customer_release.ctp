<?php
$fh_ok = FH_OK;
if($fh_ok == 'OK'){
$action_params = $this->params['action'];
$controller_params = $this->params['controller'];
if($controller_params == 'departments' && $action_params == 'index'){
	$recomanded_products = $this->Common->fh_call_recomandedproducts($selected_department);
} else {
	$recomanded_products = $this->Common->fh_call_recomandedproducts();
}
if(!empty($recomanded_products)){?>
	<!--Customers who viewed this item also viewed Start-->
	<div class="side-content">
		<!--White Box Widget Start-->
		<div class="wt-box-widget">
			<!--Top Start-->
			<div class="wt-box-top">
				<div class="wt-box-top-left"></div>
			</div>
			<!--Top Closed-->
			<!--Middle Start-->
			<div class="wt-box-mid">
				<ul class="right-pro">
					<li>
						<h5 class="gray"><?php echo $recomanded_products['slogan']['slogan'];?></h5>
					</li>
					<?php
						
						//pr($recomanded_products);
						
						foreach($recomanded_products['items'] as $recomanded_product){
								$pr_qc = "";
								$cus_pr_name = "";
								$cus_image_path = "";
								$pr_avg_rate = "";
								$cus_minimum_price_value = "";
								$cus_minimum_price_used = "";
								$cus_product_rrp = "";
								
								$new_con_id = "";
								$used_con_id = "";
								$min_new_seller = "";
								$min_used_seller = "";
								if(!empty($recomanded_product['secondid'])){
									$pr_qc = $recomanded_product['secondid'];
								}
								if(!empty($recomanded_product['product_name'])){
									$cus_pr_name = $recomanded_product['product_name'];
								}
								if(!empty($recomanded_product['product_image'])){
									$cus_image_path = $recomanded_product['product_image'];
								}
								if(!empty($recomanded_product['avg_rating'])){
									$pr_avg_rate = $recomanded_product['avg_rating'];
								}
								if(!empty($recomanded_product['minimum_price_value'])){
									$cus_minimum_price_value = $recomanded_product['minimum_price_value'];
								}
								if(!empty($recomanded_product['minimum_price_used'])){
									$cus_minimum_price_used = @$recomanded_product['minimum_price_used'];
								}
								if(!empty($recomanded_product['product_rrp'])){
									$cus_product_rrp = $recomanded_product['product_rrp'];
								}
								
								if(!empty($recomanded_product['condition_new'])){
									$new_con_id = $recomanded_product['condition_new'];
								}
								if(!empty($recomanded_product['condition_used'])){
									$used_con_id = $recomanded_product['condition_used'];
								}
								if(!empty($recomanded_product['minimum_price_seller'])){
									$min_new_seller = $recomanded_product['minimum_price_seller'];
								}
								if(!empty($recomanded_product['minimum_price_used_seller'])){
									$min_used_seller = $recomanded_product['minimum_price_used_seller'];
								}
								
								
							if(!empty($pr_qc)){
								
								$pr_id = $this->Common->getProductId_Qccode($pr_qc);
								$rating = $common->displayProductRatingYellow($pr_avg_rate,$pr_id);
							}
								
							if(!empty($pr_id) && !empty($min_new_seller) && !empty($new_con_id)){
								$prodSellerInfo = $common->getProductSellerInfo($pr_id ,$min_new_seller, $new_con_id);
								if(!empty($prodSellerInfo))
									$prodStock = $prodSellerInfo['ProductSeller']['quantity'];
								else
									$prodStock = "";
							}			
									
							if(!empty($pr_id) && !empty($min_used_seller) && !empty($used_con_id)){
								$prodSellerInfo = $common->getProductSellerInfo($pr_id ,$min_used_seller, $used_con_id);
								if(!empty($prodSellerInfo))
									$prodStock = $prodSellerInfo['ProductSeller']['quantity'];
								else
									$prodStock = "";
							}
							
							?>
							<li>
							<p><?php 
							if(empty($cus_image_path)){
								$cus_image_path = '/img/no_image_100.jpeg';
							} else {
								$image_path = WWW_ROOT.PATH_PRODUCT."/small/img_100_".$cus_image_path;
								if(!file_exists($image_path) ){
								$cus_image_path = '/img/no_image_100.jpg';
								}else{
								$cus_image_path = '/'.PATH_PRODUCT.'small/img_100_'.$cus_image_path;
								}
							}
									
								echo $html->link($html->image($cus_image_path,array('alt'=>'')), "/".$this->Common->getProductUrl($pr_id)."/categories/productdetail/".$pr_id,array( 'escape'=>false));?>
								</p>
								
								<?php 	
								if(!empty($cus_pr_name)) {?>
									<p><?php echo $html->link($format->formatString(htmlspecialchars_decode($cus_pr_name,ENT_QUOTES),50,'...'),"/".$this->Common->getProductUrl($pr_id)."/categories/productdetail/".$pr_id,null);?></p>
								<?php }?>
								<p class="rating"><?php echo $rating;?> </p>
								
								<?php
								if(!empty($cus_minimum_price_value) && $cus_minimum_price_value > 0 && $prodStock > 0){ ?>
									<p><strong>New Only</strong> <span class="hot-pro-price larger-fnt">
									<strong><?php echo CURRENCY_SYMBOL,$format->money($cus_minimum_price_value,2);?></strong></span>
									</p>
								<?php  } else if(!empty($cus_minimum_price_used) && $cus_minimum_price_used > 0 && $prodStock > 0){?>
									<p><strong>Used Only</strong> <span class="hot-pro-price larger-fnt">
									<strong><?php echo CURRENCY_SYMBOL,$format->money($cus_minimum_price_used,2);?></strong></span>
									</p>
								<?php  } else{ ?>
									<p><strong>RRP</strong> <span class="hot-pro-price larger-fnt">
									<strong><?php echo CURRENCY_SYMBOL,$format->money($cus_product_rrp,2);?></strong></span>
									</p>
								<?php  }  ?>
								
							</li>
						<?php }?>
						
				</ul>
			</div>
			<!--Middle Closed-->
			<!--Bottom Start-->
			<div class="wt-box-bottom">
				<div class="wt-box-bottom-left"></div>
			</div>
			<!--Bottom Closed-->
		</div>
		<!--White Box Widget Closed-->
	</div>
	<!--Customers who viewed this item also viewed Closed-->
<?php } }?>