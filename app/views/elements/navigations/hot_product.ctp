<?php
$fh_ok = FH_OK;
if($fh_ok == 'OK'){
$action_params = $this->params['action'];
$controller_params = $this->params['controller'];
if($controller_params == 'departments' && $action_params == 'index'){
	$hot_products = $this->Common->fh_call_hotproduct($selected_department);
} else {
	$hot_products = $this->Common->fh_call_hotproduct();
}
if(!empty($hot_products)){
?>
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
				<h5>
					<?php
						if(!empty($hot_products['slogan']) && isset($hot_products['slogan'])){
							echo $hot_products['slogan'];
						}
					?>
				</h5>
			</li>
		<?php
		foreach($hot_products['items'] as $hot_product){
				$pr_qc = "";
				$pr_avg_rate = "";
				$pr_name = "";
				$image_name = "";
				$product_rrp = "";
				$minimum_price_value = "";
				$minimum_price_used = "";
				
				$new_con_id = "";
				$used_con_id = "";
				$min_new_seller = "";
				$min_used_seller = "";
				
				if($hot_product['secondid']){
					$pr_qc = $hot_product['secondid'];
				}
				if($hot_product['avg_rating']){
					$pr_avg_rate = $hot_product['avg_rating'];
				}
				if($hot_product['product_name']){
					$pr_name = $hot_product['product_name'];
				}
				if($hot_product['product_image']){
					$image_name = $hot_product['product_image'];
				}
				if($hot_product['product_rrp']){
					$product_rrp = $hot_product['product_rrp'];
				}
				if(@$hot_product['minimum_price_value']){
					$minimum_price_value = $hot_product['minimum_price_value'];
				}
				if(@$hot_product['minimum_price_used']){
					$minimum_price_used = $hot_product['minimum_price_used'];
				}
				
				if(!empty($hot_product['condition_new'])){
					$new_con_id = $hot_product['condition_new'];
				}
				if(!empty($hot_product['condition_used'])){
					$used_con_id = $hot_product['condition_used'];
				}
				if(!empty($hot_product['minimum_price_seller'])){
					$min_new_seller = $hot_product['minimum_price_seller'];
				}
				if(!empty($hot_product['minimum_price_used_seller'])){
					$min_used_seller = $hot_product['minimum_price_used_seller'];
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
				
			if(empty($image_name)){
				$image_path = '/img/no_image_100.jpeg';
			} else {
				$image_path_exists = WWW_ROOT.PATH_PRODUCT."/small/img_100_".$image_name;
				if(!file_exists($image_path_exists) ){
				$image_path = '/img/no_image_100.jpg';
				}else{
				$image_path = '/'.PATH_PRODUCT.'small/img_100_'.$image_name;
				}
			}
		?>
			<li>
				<p><?php 
				echo $html->link($html->image($image_path,array('alt'=>"")), "/".$this->Common->getProductUrl($pr_id)."/categories/productdetail/".$pr_id, array('escape'=>false) ) ;?></p>
				<p><?php 
				echo $html->link($pr_name, "/".$this->Common->getProductUrl($pr_id)."/categories/productdetail/".$pr_id,null);?></a></p>
				<?php  if(!empty($minimum_price_value) && $minimum_price_value > 0 && $prodStock > 0){ ?>
					<p><strong>New Only</strong> <span class="hot-pro-price larger-fnt">
					<strong><?php echo CURRENCY_SYMBOL,$format->money($minimum_price_value,2);?></strong></span>
					</p>
				<?php  } else if(!empty($minimum_price_used) &&  $minimum_price_used > 0 && $prodStock > 0){?>
					<p><strong>Used Only</strong> <span class="hot-pro-price larger-fnt">
					<strong><?php echo CURRENCY_SYMBOL,$format->money($minimum_price_used,2);?></strong></span>
					</p>
				<?php  } else{ ?>
					<p><strong>RRP</strong> <span class="hot-pro-price larger-fnt">
					<strong><?php echo CURRENCY_SYMBOL,$format->money($product_rrp,2);?></strong></span>
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
<!--Hot Product Closed-->
<?php }}?>