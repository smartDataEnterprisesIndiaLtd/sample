<?php ?>
<div id="resolutionDivId" class="mid-content">
	<div class="breadcrumb-widget">
		<?php //echo $breadcrumb_string;?>
	</div>
	<?php
	if(isset($cat_ids)  &&  is_array($cat_ids)){
		App::import('Model','Category');
		$this->Category = &new Category;
		$i=0;
		foreach($cat_ids as $cat_id){
			if($i<11){
			$childCatCount = $this->Category->getChildCount($cat_id); ?>
			<!--Artists, Architects &amp; Photographers Start-->
			<h4 class="gr-bg-head"><span>
				<?php $catname_arr = $this->Common->getCategoryName($cat_id);?>
				<?php echo $catname = $catname_arr[0]['Category']['cat_name'];?>
			</span>
				<?php
				//echo $department_name;
					$cat_url_name = str_replace(array('&',' '), array('and','-'), html_entity_decode($catname, ENT_NOQUOTES, 'UTF-8'));
					$dept_url_name = str_replace(array('&',' '), array('and','-'), html_entity_decode($department_name, ENT_NOQUOTES, 'UTF-8'));
					$dept_url = $dept_url_name.'/'.$cat_url_name;
				if($childCatCount > 0){
					$cat_page_url = "/".$dept_url."/categories/index/".$cat_id;
					echo $html->link('View All Category',$cat_page_url,array('escape'=>false,'class'=>'view-all-catagory'));
				}else{
					$cat_product_list = "/".$dept_url."/categories/viewproducts/".$cat_id."/".$selected_department;;
					echo $html->link('View All Category',$cat_product_list,array('escape'=>false,'class'=>'view-all-catagory'));
				}
				
				?>
			</h4>
			<div  class="row">
			<!--Products Widget Start-->
				<div class="top-products-widget outerdiv_resolution">
					<ul class="products">
				<?php
				if(!empty($products_info)){
					$k = 1;
					foreach($products_info[$i] as $product_info){
						if(!empty($product_info['product_image'])){
							$image_path = WWW_ROOT.PATH_PRODUCT."/small/img_100_".$product_info['product_image'];
							if(!file_exists($image_path) ){
									$image_path = '/img/no_image_100.jpg';
								}else{
									$image_path = '/'.PATH_PRODUCT.'small/img_100_'.$product_info['product_image'];
								}
						} else {
							$image_path = '/img/no_image_100.jpg';
						}
						
					
						
					if(!empty($product_info['product_name'])){
						$pr_name = $product_info['product_name'];
					}else{
						$pr_name = '';
					}
					
					if(!empty($product_info['secondid'])){
						$pr_qc = $product_info['secondid'];
					}else{
						$pr_qc = '';
					}
					
					if(!empty($pr_qc)){
						
						$pr_id = $this->Common->getProductId_Qccode($pr_qc);
					}
					
					
					if(!empty($product_info['avg_rating'])){
						$pr_avg_rate = $product_info['avg_rating'];
					}else{
						$pr_avg_rate = '';
					}
					
					if(!empty($pr_qc)){
						
						$rating = $common->displayProductRating($pr_avg_rate,$pr_id);
					}
					
					if(!empty($product_info['product_rrp'])){
						$product_rrp = $product_info['product_rrp'];
					}else{
						$product_rrp = '';
					}
					
					if(!empty($product_info['minimum_price_used'])){
						$pr_price_used = $product_info['minimum_price_used'];
					}else{
						$pr_price_used = '';
					}
					
					if(!empty($product_info['minimum_price_value'])){
						$minimum_price_value = $product_info['minimum_price_value'];
					}else{
						$minimum_price_value = '';
					}
					//echo $pr_name;
				?>
						
						
						<li class="inner_div_resolution res<?php echo $k;?>" style="width:25%;">
							<div style ="padding:0 5px;">
							<p class="image-sec">
								<?php //echo $html->image($image_path,array('alt'=>$pr_name));?>
								<?php echo $html->link($html->image($image_path,array('alt'=>$pr_name,'title'=>$pr_name)),'/'.$this->Common->getProductUrl($pr_id).'/categories/productdetail/'.$pr_id,array('escape'=>false));?>
							</p>
							
							<p>
								<?php 
								echo $html->link($format->formatString($pr_name,500),'/'.$this->Common->getProductUrl($pr_id).'/categories/productdetail/'.$pr_id,array('escape'=>false));?>
							</p>
							<p class="star-rating">
								<span class="pad-rt pad-tp">
								<?php echo $rating;?>
							</p>
							<p>
								<?php if(!empty($minimum_price_value) && $minimum_price_value > 0){?>
									<span class="gray-color"><s><?php echo CURRENCY_SYMBOL.' '. $product_rrp?></s></span>
									
									From <span class="price larger-font">
											<strong>
												<?php echo CURRENCY_SYMBOL;?><?php echo $minimum_price_value;?>
											</strong>
										</span><br />
									
								<?php }else{?>
									<span class="price larger-font">
										<strong>
											<?php echo CURRENCY_SYMBOL;?><?php echo $product_rrp;?>
										</strong>
									</span><br />
									
								<?php }?>
								 <?php if(!empty($pr_price_used) && $pr_price_used > 0){?>
								 	<p class="used-from">Used from <span class="price"><strong class="price-blue"><?php echo CURRENCY_SYMBOL;?><?php echo $pr_price_used;?></strong></span></p>
								 <?php }?>
							</p>
							</div>
						</li>
						
					<?php
					$k ++;
					}
					
					}else{
						
						echo '<li style="width:100%;">We\'re sorry, there are currently no items available in this category</li>';
						
					}
					?>
					
						
						
						
						
					</ul>
				</div>
				<!--Products Widget Closed-->
			</div>
			<!--Artists, Architects &amp; Photographers Closed-->
		<?php $i++; } //End  foreach		
		
		} //End  foreach for sabcategory
	}else{ // main if
		echo '<ul>';
		echo '<li style="width:100%;">We\'re sorry, there are currently no items available in this category</li>';
		echo '</ul>';
	}// main if ?>
</div>
<?php echo $javascript->link(array('change_resolution'));?>