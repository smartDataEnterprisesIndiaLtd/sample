<style>
	.price-blue_new {
    color: #003399;
    text-decoration: underline;
}
</style>
<?php
$selectedDeptId='';
if(isset($deptId) && $deptId!=null){
$selectedDeptId =$deptId;	
}
//IMPORT HOME PAGE PRODUCT DB
App::import('Model','ProductVisit');
$this->ProductVisit = & new ProductVisit();
$visitedProducts = $this->ProductVisit->getVisitedProducts($selectedDeptId);
//pr($visitedProducts);
# check the products in the list
if( count($visitedProducts) > 0 ){  ?>
	<h4 class="gr-bg-head">
		<span>What Other Customers Are Looking At Right Now</span>
	</h4>
	<!--div class="top-products-widget outerdiv_resolution outerdiv_resolution-customerlooking"-->
	<div class="top-products-widget outerdiv_resolution">
		<ul class="products">
			<?php
				$countitem = 0;
				$j = 1;
			foreach ($visitedProducts as $keyId=>$productArr){
				if($productArr['product_image'] == 'no_image.gif' || $productArr['product_image'] == 'no_image.jpeg'){
					$image_path = '/img/no_image_100.jpg';
				} else{
					$image_path = WWW_ROOT.PATH_PRODUCT.'small/img_100_'.$productArr['product_image'];
					if(!file_exists($image_path) ){
						$image_path = '/img/no_image_100.jpg';
					}else{
						$image_path = '/'.PATH_PRODUCT.'small/img_100_'.$productArr['product_image'];
					}
				}
				$minPriceUsed = $productArr['minimum_price_used'];
			?>
			<li class="inner_div_resolution res<?php echo $j;?>">
				<div style ="padding:5px 5px 0px 5px;">
				<p class="image-sec">
					<?php echo $html->link($html->image($image_path, array('title'=>$productArr['product_name'],'alt'=>$productArr['product_name'])),'/'.$this->Common->getProductUrl($productArr['id']).'/categories/productdetail/'.$productArr['id'],array('escape'=>false));?>
				</p>
				<p  class="conti_shp_width">
					 <?php
					 if(empty($product_url)){
						$product_url = "";
					 }
					 echo $html->link($format->formatString($productArr['product_name'],500),'/'.$product_url.'/'.$this->Common->getProductUrl($productArr['id']).'/categories/productdetail/'.$productArr['id'],array('escape'=>false));?>
				</p>
				<?php
				
				$rating = $common->displayProductRating($productArr['avg_rating'],$productArr['id']);
//print_r($visitedProducts);
//echo "</pre>";
?>
				<p class="star-rating">
					<span class="pad-rt pad-tp"><?php  echo $rating; ?></span>
					</p>	
				<p>
					<span>
						
						<?php if((!empty($productArr['minimum_price_value']) && $productArr['minimum_price_value'] > 0) || (!empty($productArr['minimum_price_used']) && ($productArr['minimum_price_used'] > 0)) ) {?>
							<strong>RRP: </strong><s><?php echo CURRENCY_SYMBOL.$format->money($productArr['product_rrp'],2); ?> </s>
						<?php }else{
							echo "<strong>RRP: </strong>". CURRENCY_SYMBOL.$format->money($productArr['product_rrp'],2);
						}?>
						
					</span>
					<?php
					if(!empty($productArr['minimum_price_value']) ){
						if($productArr['minimum_price_value'] > 0){
							echo '<p><span class="price-blue_new">Buy new:</span> <span class="price">';
							echo CURRENCY_SYMBOL.$format->money($productArr['minimum_price_value'],2);
							echo '</span></p>';
						}
					}
					if(!empty($productArr['minimum_price_used']) ){
						if($productArr['minimum_price_used'] > 0){
							echo '<p><span class="price-blue_new">Buy used:</span> <span class="price">';
							echo CURRENCY_SYMBOL.$format->money($productArr['minimum_price_used'],2);
							echo '</span></p>';
						}
					} ?>
				</p>
				</div>
			</li>
			<?php
			$j ++;
			$countitem++; }  ?>
			
		</ul>
	</div>
<?php
}
?>
<script>
	var width_pre_div = 632;
	//var width_div = jQuery('.outerdiv_resolution').width();
	var width_div=window.innerWidth;
	if(width_div == width_pre_div){
		jQuery('.inner_div_resolution').css('width','25%');
		jQuery('.inner_2div_resolution').css('width','50%');
			
			jQuery(".products").removeClass('proshow33');
			jQuery(".products").removeClass('proshow20');
			jQuery(".products").removeClass('proshow16');
			jQuery(".products").removeClass('proshow14');
			jQuery(".products").removeClass('proshow12');
			jQuery(".products").addClass('proshow25');
			
	}else if(width_div < width_pre_div){
		
		jQuery('.inner_div_resolution').css('width','33.3%');
		jQuery('.inner_2div_resolution').css('width','50%');
		
			jQuery(".products").removeClass('proshow20');
			jQuery(".products").removeClass('proshow25');
			jQuery(".products").removeClass('proshow16');
			jQuery(".products").removeClass('proshow14');
			jQuery(".products").removeClass('proshow12');
			jQuery(".products").addClass('proshow33');
			
	}else if(width_div > width_pre_div){
		//alert(width_div-width_pre_div);
		if(width_div-width_pre_div < 50){
			jQuery('.inner_div_resolution').css('width','25%');
			jQuery('.inner_2div_resolution').css('width','50%');
			
			jQuery(".products").removeClass('proshow33');
			jQuery(".products").removeClass('proshow20');
			jQuery(".products").removeClass('proshow16');
			jQuery(".products").removeClass('proshow14');
			jQuery(".products").removeClass('proshow12');
			jQuery(".products").addClass('proshow25');
			
		}
		if(width_div-width_pre_div >= 50 && width_div-width_pre_div < 200){
			jQuery('.inner_div_resolution').css('width','25%');
			jQuery('.inner_2div_resolution').css('width','50%');
			
			jQuery(".products").removeClass('proshow33');
			jQuery(".products").removeClass('proshow20');
			jQuery(".products").removeClass('proshow16');
			jQuery(".products").removeClass('proshow14');
			jQuery(".products").removeClass('proshow12');
			jQuery(".products").addClass('proshow25');
		}
		if(width_div-width_pre_div >= 200 && width_div-width_pre_div < 300){
			jQuery('.inner_div_resolution').css('width','25%');
			jQuery('.inner_2div_resolution').css('width','50%');
			
			jQuery(".products").removeClass('proshow33');
			jQuery(".products").removeClass('proshow20');
			jQuery(".products").removeClass('proshow16');
			jQuery(".products").removeClass('proshow14');
			jQuery(".products").removeClass('proshow12');
			jQuery(".products").addClass('proshow25');
			
		}
		if(width_div-width_pre_div >= 300 && width_div-width_pre_div < 500){
			jQuery('.inner_div_resolution').css('width','25%');
			jQuery('.inner_2div_resolution').css('width','50%');
			
			jQuery(".products").removeClass('proshow33');
			jQuery(".products").removeClass('proshow20');
			jQuery(".products").removeClass('proshow16');
			jQuery(".products").removeClass('proshow14');
			jQuery(".products").removeClass('proshow12');
			jQuery(".products").addClass('proshow25');
			
		}
		if(width_div-width_pre_div >= 488 && width_div-width_pre_div < 600){
			jQuery('.inner_div_resolution').css('width','25%');
			jQuery('.inner_2div_resolution').css('width','50%');
			
			jQuery(".products").removeClass('proshow33');
			jQuery(".products").removeClass('proshow20');
			jQuery(".products").removeClass('proshow16');
			jQuery(".products").removeClass('proshow14');
			jQuery(".products").removeClass('proshow12');
			jQuery(".products").addClass('proshow25');
		}
		if(width_div-width_pre_div >= 600 && width_div-width_pre_div < 1000){
			jQuery('.inner_div_resolution').css('width','20%');
			jQuery('.inner_2div_resolution').css('width','33.3%');
			
			jQuery(".products").removeClass('proshow33');
			jQuery(".products").removeClass('proshow25');
			jQuery(".products").removeClass('proshow16');
			jQuery(".products").removeClass('proshow14');
			jQuery(".products").removeClass('proshow12');
			jQuery(".products").addClass('proshow20');
		}
		if(width_div-width_pre_div >= 1000 && width_div-width_pre_div < 1400){
			jQuery('.inner_div_resolution').css('width','16.6%');
			jQuery('.inner_2div_resolution').css('width','33.3%');
			
			jQuery(".products").removeClass('proshow33');
			jQuery(".products").removeClass('proshow20');
			jQuery(".products").removeClass('proshow25');
			jQuery(".products").removeClass('proshow14');
			jQuery(".products").removeClass('proshow12');
			jQuery(".products").addClass('proshow16');
		}
		if(width_div-width_pre_div >= 1400 && width_div-width_pre_div < 1800){
			jQuery('.inner_div_resolution').css('width','14.28%');
			jQuery('.inner_2div_resolution').css('width','25%');
			
			jQuery(".products").removeClass('proshow33');
			jQuery(".products").removeClass('proshow20');
			jQuery(".products").removeClass('proshow16');
			jQuery(".products").removeClass('proshow25');
			jQuery(".products").removeClass('proshow12');
			jQuery(".products").addClass('proshow14');
		}
		if(width_div-width_pre_div >= 1800){
			jQuery('.inner_div_resolution').css('width','12.5%');
			jQuery('.inner_2div_resolution').css('width','25%');
			
			jQuery(".products").removeClass('proshow33');
			jQuery(".products").removeClass('proshow20');
			jQuery(".products").removeClass('proshow16');
			jQuery(".products").removeClass('proshow14');
			jQuery(".products").removeClass('proshow25');
			jQuery(".products").addClass('proshow12');
		}
	} else{}

		</script>		