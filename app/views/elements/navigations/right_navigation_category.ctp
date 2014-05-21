<style>
	.txt-rt { text-align:right;}
	
</style>

<?php if(!empty($best_cat_item) || !empty($best_dept_item)) {
?>
<div class="right-widget">
	<!--Best Sellers (Books: Biography) Start-->
	<?php if(!empty($best_cat_item)) {?>
	<div class="side-content">
		<h4 class="gray-bg-head"><span>Bestsellers</span></h4>
		<div class="gray-fade-bg-box">
			<ul class="best-sellers">
				<li>
					<?php echo $department_name.':&nbsp;'.$category_name_fh; //echo $bestseller_cat_slogan; ?><?php //if($i == 0) { echo ': '.$category_name_fh; }?> </h4>
					Updated hourly
				</li>
				<?php 			
			$j = 1;
			foreach($best_cat_item as $bestseller_items){
				$minimum_price_value = "";
				$minimum_price_used = "";
				$product_rrp = "";
				
				$new_con_id = "";
				$used_con_id = "";
				$min_new_seller = "";
				$min_used_seller = "";
				if(!empty($bestseller_items['product_image'])) {
						$image_path = WWW_ROOT.PATH_PRODUCT."/small/img_50_".$bestseller_items['product_image'];
							
						if(!file_exists($image_path) ){
							$image_path = 'no_image_50.jpg';
						}else{
							$image_path = '/'.PATH_PRODUCT.'small/img_50_'.$bestseller_items['product_image'];
						}
				} else {
					$image_path = 'no_image_50.jpg';
				}
					$pr_name = $bestseller_items['product_name'];
					$pr_id = $this->Common->getProductId_Qccode($bestseller_items['secondid']);
					if(key_exists('minimum_price_value',$bestseller_items)){
						$minimum_price_value = $bestseller_items['minimum_price_value'];
					}
					if(key_exists('minimum_price_used', $bestseller_items)){
						$minimum_price_used = $bestseller_items['minimum_price_used'];
					}
					if(key_exists('product_rrp' , $bestseller_items)){
						$product_rrp = $bestseller_items['product_rrp'];
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
					<div class="seller-left-img"><?php 
					echo $html->link($html->image($image_path,array('alt'=>"$pr_name",'title'=>"$pr_name" )),'/'.$this->Common->getProductUrl($pr_id).'/categories/productdetail/'.$pr_id,array('escape'=>false));?></div>
					<div class="seller-right-content"><span class="numbering"><strong><?php echo $j; ?>.</strong></span> <?php echo $html->link($this->Format->formatString($pr_name,50,'...'),'/'.$this->Common->getProductUrl($pr_id).'/categories/productdetail/'.$pr_id,array('escape'=>false));?>
						<p>
							<?php if(!empty($minimum_price_value) && ($minimum_price_value > 0) && $prodStock > 0) { ?>
							<span class="gray-color">
								<s><?php echo CURRENCY_SYMBOL.''.$format->moneyFormat($product_rrp);?></s>
							</span>
								<span class="price larger-font">
									<strong>
										<?php echo CURRENCY_SYMBOL.''.$format->moneyFormat($minimum_price_value);?>
									</strong>
								</span>
							<?php }elseif(!empty($minimum_price_used) && ($minimum_price_used > 0) && $prodStock > 0){ ?>
								<span class="gray-color">
									<s><?php echo CURRENCY_SYMBOL.''.$format->moneyFormat($product_rrp);?></s>
								</span>
								<span class="price larger-font">
									<strong>
										<?php echo CURRENCY_SYMBOL.''.$format->moneyFormat($minimum_price_used)?>
									</strong>
								</span>
							<?php }else{?>
								<span class="price larger-font">
									<strong>
										<?php echo CURRENCY_SYMBOL.''.$format->moneyFormat($product_rrp);?>
									</strong>
								</span>
							<?php }?>
						</p>
					</div>
				</li>
			<?php
			$j++;
			} ?>
			</ul>
		</div>
	</div>
	<!--Best Sellers (Books: Biography) Closed-->
	<?php }?>
	
	<?php if(!empty($best_dept_item)) {
		?>
	<div class="side-content">
		<h4 class="gray-bg-head"><span>Bestsellers</span></h4>
		<div class="gray-fade-bg-box gray-fade-bg-box-botton">
			<ul class="best-sellers">
				<li>
					<h4><?php echo $department_name; //echo $bestseller_dept_slogan; ?></h4>
					Updated hourly
				</li>
				<?php 			
			$k = 1;
			foreach($best_dept_item as $best_dept_items){
				$minimum_price_value = "";
				$minimum_price_used = "";
				$product_rrp = "";
				if(!empty($best_dept_items['product_image'])) {
						$image_path = WWW_ROOT.PATH_PRODUCT."/small/img_50_".$best_dept_items['product_image'];
							
						if(!file_exists($image_path) ){
							$image_path = 'no_image_50.jpg';
						}else{
							$image_path = '/'.PATH_PRODUCT.'small/img_50_'.$best_dept_items['product_image'];
						}
				} else {
					$image_path = 'no_image_50.jpg';
				}
					if(key_exists('product_name' , $best_dept_items)){
						$pr_name = $best_dept_items['product_name'];
					}
					$pr_id = $this->Common->getProductId_Qccode($best_dept_items['secondid']);
					
					if(key_exists('minimum_price_value' , $best_dept_items)){
						$minimum_price_value = $best_dept_items['minimum_price_value'];
					}
					if(key_exists('minimum_price_used' , $best_dept_items)){
						$minimum_price_used = $best_dept_items['minimum_price_used'];
					}
					if(key_exists('product_rrp' , $best_dept_items)){
						$product_rrp = $best_dept_items['product_rrp'];
					}
					
					
					
					if(!empty($best_dept_items['condition_new'])){
						$new_con_id = $best_dept_items['condition_new'];
					}
					if(!empty($best_dept_items['condition_used'])){
						$used_con_id = $best_dept_items['condition_used'];
					}
					if(!empty($best_dept_items['minimum_price_seller'])){
						$min_new_seller = $best_dept_items['minimum_price_seller'];
					}
					if(!empty($best_dept_items['minimum_price_used_seller'])){
						$min_used_seller = $best_dept_items['minimum_price_used_seller'];
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
					
					
					/*$minimum_price_value = $best_dept_items['minimum_price'];
					$minimum_price_used = $best_dept_items['minimum_price_used'];
					$product_rrp = $best_dept_items['product_rrp'];*/
					
				?>
				<li>
					<div class="seller-left-img"><?php 
					echo $html->link($html->image($image_path,array('alt'=>"$pr_name" ,'title'=>"$pr_name" )),'/'.$this->Common->getProductUrl($pr_id).'/categories/productdetail/'.$pr_id,array('escape'=>false));?></div>
					<div class="seller-right-content">
						<span class="numbering"><strong><?php echo $k; ?>.</strong></span> <?php echo $html->link($this->Format->formatString($pr_name,50,'...'),'/'.$this->Common->getProductUrl($pr_id).'/categories/productdetail/'.$pr_id,array('escape'=>false));?>
						<p><?php if(!empty($minimum_price_value) && $minimum_price_value > 0 && $prodStock > 0) { ?>
								<span class="gray-color">
									<s>
										<?php echo CURRENCY_SYMBOL.''.$format->moneyFormat($product_rrp);?>
									</s>
								</span>
								
								<span class="price larger-font">
									<strong>
										<?php echo CURRENCY_SYMBOL.''.$format->moneyFormat($minimum_price_value);?>
									</strong>
								</span>
							<?php }elseif(!empty($minimum_price_used) && $minimum_price_used > 0 && $prodStock > 0){ ?>
								<span class="gray-color">
									<s>
										<?php echo CURRENCY_SYMBOL.''.$format->moneyFormat($product_rrp);?>
									</s>
								</span>
								
								<span class="price larger-font">
									<strong>
										<?php echo CURRENCY_SYMBOL.''.$format->moneyFormat($minimum_price_used);?>
									</strong>
								</span>
							<?php }else{?>
								<span class="price larger-font">
									<strong>
										<?php echo CURRENCY_SYMBOL.''.$format->moneyFormat($product_rrp);?>
									</strong>
								</span>
							<?php }?>
						</p>
					</div>
				</li>
			<?php
			$k++;
			} ?>
			</ul>
			<?php $dept_url_name = str_replace(array('&',' '), array('and','-'), html_entity_decode($department_name, ENT_NOQUOTES, 'UTF-8'));
				if(!empty($dept_id)){?>
					<li>
						<p align="right">
							<?php echo $html->link('<strong>See all beatsellers <span class="rate">&raquo;</span></strong>','/'.$dept_url_name.'-topsellers-top-100/products/bestseller_products/'.base64_encode($dept_id),array('escape'=>false));?>
						</p>
					</li>
				<?php }	?>
			
		</div>
		
	</div>
	<!--Best Sellers (Books: Biography) Closed-->
	<?php }?>
	
	
	
</div>
<?php } ?>