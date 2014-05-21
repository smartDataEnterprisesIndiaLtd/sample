<?php
echo $javascript->link(array('jquery-1.3.2.min','lib/prototype','selectAllCheckbox_front'),false);?>
 <!--Right Section Start-->
<?php echo $this->element('/recommended_product_fh');?>
<!--Right Section Closed-->
<!--mid Content Start-->
<div class="mid-content pro-mid-content">
	
	
	<!--Shopping Basket Start-->
	<div class="shopping-basket-widget" id="basket_listing">
		<?php echo $this->element('/basket/basket_listing');?>
	</div>
	<!--Shopping Basket Closed-->
	<!--Recent History Widget Start-->
	<?php echo $this->element('/countinue_shopping_fh');?>
	<!--Recent History Widget Closed-->
	<!--Customers Who Bought This Item Also Bought Start-->
	<div class="row no-pad-btm">
		<h4 class="mid-gr-head blue-color"><span>Recently Viewed Items</span></h4>
		<!--Products Widget Start-->
		<div class="top-products-widget outerdiv_resolution outerdiv_resolution-customerlooking" style="height:185px">
<!-- 		<div class="top-products-widget"> -->
			<ul class="products no-pad-btm">
				<?php  if( !empty($myRecentProducts) ){
				$i = 0;
				foreach ($myRecentProducts as $keyId=>$productArr){
				$i++;
				if($productArr['product_image'] == 'no_image.gif' || $productArr['product_image'] == 'no_image.jpeg'){
					$image_path = '/img/no_image.jpeg';
				} else{
					$image_path = WWW_ROOT.PATH_PRODUCT.'small/img_100_'.$productArr['product_image'];
					if(!file_exists($image_path) ){
						$image_path = '/img/no_image_100.jpg';
					}else{
						$image_path = '/'.PATH_PRODUCT.'small/img_100_'.$productArr['product_image'];
					}
					
					
				}
				$prodName = $productArr['product_name']; 
				?>
				<li class="inner_div_resolution" style="margin-bottom:15px">
				<div style ="padding:0 5px">
					<p class="image-sec">
						<?php echo $html->link($html->image($image_path,array('alt'=>$prodName,'title'=>$prodName)),'/'.$this->Common->getProductUrl($productArr['id']).'/categories/productdetail/'.$productArr['id'],array('escape'=>false,));?>
					</p>
					<p class="prod_name_sec">
						 <?php
						  $prodName = $format->formatString($productArr['product_name'], 50 ); 
						 echo $html->link($prodName,'/'.$this->Common->getProductUrl($productArr['id']).'/categories/productdetail/'.$productArr['id'],array('escape'=>false,));?>
					</p>
					<p>
						<?php
						if(!empty($productArr['minimum_price_value']) && $productArr['minimum_price_value'] > 0){
							echo '<span class="smalr-fnt">New from &nbsp;</span> <span class="price larger-font"> <strong>';
							echo CURRENCY_SYMBOL.$format->money($productArr['minimum_price_value'],2).'</span></strong>';
						}else{
							echo '<span class="smalr-fnt">RRP &nbsp;</span> <span class="price larger-font"> <strong>';
							echo CURRENCY_SYMBOL.$format->money($productArr['product_rrp'],2).'</span></strong>';
						}
						?>
					</p>
					<?php if(!empty($productArr['minimum_price_used']) && $productArr['minimum_price_value'] > 0 ){ ?>
					<p ><span class="used-from">Used from &nbsp;</span><span class="price"> 
						<?php	echo CURRENCY_SYMBOL.$format->money($productArr['minimum_price_used'],2); ?>
						</span>
					</p>
					<?php } ?>
				</div></li>
				<?php  } 
				} else { ?>
				<p>No products viewed</p>
				<?php } ?>
			</ul>
		</div>
		<!--Products Widget Closed-->
	</div>
	<!--Customers Who Bought This Item Also Bought Closed-->
</div>
<script>
var width_pre_div = 799;
</script>
<?php echo $javascript->link(array('change_resolution_basket'));?>
<!--mid Content Closed-->