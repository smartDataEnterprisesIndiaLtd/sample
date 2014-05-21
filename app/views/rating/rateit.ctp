<?php 
echo $javascript->link('fancybox/jquery.fancybox-1.3.1.pack.js');
echo $javascript->link('fancybox/jquery.easing-1.3.pack.js');
echo $javascript->link('fancybox/jquery.mousewheel-3.0.2.pack.js');
echo $html->css('jquery.fancybox-1.3.1.css');
$this->set('product_id',$product_details['Product']['id']);

if(!empty($product_details['Product']['minimum_price_seller'])) {
	$minimum_price_seller_info = $common->getProductSellerInfo($product_details['Product']['id'],$product_details['Product']['minimum_price_seller']);
	$seller_details = $minimum_price_seller_info['ProductSeller'];
} else{
	$seller_details = '';
}
$product_details['ProductSeller'] = $seller_details;
// pr($product_details);
$logg_user_id =0;
$logg_user_id = $this->Session->read('User.id');
$this->set('logg_user_id',$logg_user_id);
if(!empty($logg_user_id)) {
	$fancy_width = 362;
	$fancy_height = 330;
} else{
	$fancy_width = 530;
	$fancy_height = 145;
}
if(!empty($logg_user_id)) {
	$fancy_report_width = 362;
	$fancy_report_height = 200;
} else{
	$fancy_report_width = 530;
	$fancy_report_height = 145;
}
?>
<script language="JavaScript">
	jQuery(document).ready(function()  { // for writing a review
		jQuery("#write_review").fancybox({
			'autoScale' : true,
			'width' : <?php echo $fancy_width; ?>,
			'height' : <?php echo $fancy_height; ?>,
			'padding':0,'overlayColor':'#fff',
			'overlayOpacity':0.7,
			'opacity':	true,
			'transitionIn' : 'fade',
			'transitionOut' : 'fade',
			'type' : 'iframe',
			'autoDimensions': false,
			'onClosed': function() {
				parent.location.reload(true);;
			}
		});
	});
	jQuery(document).ready(function()  { // for writing a review
		jQuery("#email_friend").fancybox({
			'autoScale' : true,
			'width' : 410,
			'height' : 300,
			'padding':0,'overlayColor':'#fff',
			'overlayOpacity':0.7,
			'opacity':	true,
			'transitionIn' : 'fade',
			'transitionOut' : 'fade',
			'type' : 'iframe',
			'autoDimensions': false,
			'onClosed': function() {
				//parent.location.reload(true);;
			}
		});
	});
	jQuery(document).ready(function()  {  // for make me an offer
		jQuery("#make_me_an_offer").fancybox({
			'autoScale' : true,
			'width' : <?php echo $fancy_width; ?>,
			'height' : <?php echo $fancy_height; ?>,
			'padding':0,'overlayColor':'#fff',
			'overlayOpacity':0.7,
			'opacity':	true,
			'transitionIn' : 'fade',
			'transitionOut' : 'fade',
			'type' : 'iframe',
			'autoDimensions': false,
			'onClosed': function() {
				//parent.location.reload(true);;
			}
		});
	});
	jQuery(document).ready(function()  {
		jQuery("a.thisreport").fancybox({
			'autoScale' : true,
			'width' : <?php echo $fancy_report_width;?>,
			'height' : <?php echo $fancy_report_height;?>,
			'padding':0,'overlayColor':'#fff',
			'overlayOpacity':0.7,
			'opacity':	true,
			'transitionIn' : 'fade',
			'transitionOut' : 'fade',
			'type' : 'iframe',
			'autoDimensions': false,
		});
	});
	jQuery(document).ready(function()  {
		jQuery("a.ansque").fancybox({
			'autoScale' : true,
			'width' : 362,
			'height' : 270,
			'padding':0,'overlayColor':'#fff',
			'overlayOpacity':0.7,
			'opacity':	true,
			'transitionIn' : 'fade',
			'transitionOut' : 'fade',
			'type' : 'iframe',
			'autoDimensions': false,
			'onClosed': function() {
				parent.location.reload(true);;
			}
		});
	});
	jQuery(document).ready(function()  {
		jQuery("a.large-image").fancybox({
			'autoScale' : true,
			'width' : 600,
			'height' : 650,
			'padding':0,
			'overlayColor':'#fff',
			'overlayOpacity':0.7,
			'opacity':	true,
			'transitionIn' : 'fade',
			'transitionOut' : 'fade',
			'type' : 'iframe',
			'autoDimensions': false,
		});
	});
</script>
<?php


?>
<!--Right Section Start-->
<div class="right-sec">
	<!--Right Top Buttons Start-->
	<div class="side-content right-top-btns">
		<?php echo $html->link('<span>Add Lowest Price to Basket</span>',"#",array('escape'=>false,'class'=>'grn-btn display-bl'));?>
		<?php echo $html->link(' <span>Make an Offer to all Sellers</span>',"#",array('escape'=>false,'class'=>'ornge-btn display-bl'));?>
	</div>
	<!--Right Top Buttons Closed-->
	<!--Top iPod Sellers Start-->
	<div class="side-content">
		<h4 class="gray-bg-head black-color center"><span>Buying Choices</span></h4>
		<div class="gray-fade-bg-box">
			<p class="blue-links">
				<?php echo $html->link('New Only',"#",array('escape'=>false,'class'=>'underline-link'));?>   <?php echo $html->link('Used Only',"#",array('escape'=>false,'class'=>'underline-link'));?>  <?php echo $html->link('Lowest Price',"#",array('escape'=>false,'class'=>'underline-link'));?>
			</p>
			<ul class="buying-choices">
				<li>
					<p><span class="price lrgr-fnt">&pound;141.85</span> <span class="gray">+ 0.00 delivery</span></p>
					<p><span><strong>Seller</strong></span> <span class="bigger-font rate"><strong>eoutlet-uk</strong></span></p>
					<p>Eligible for <span class="price">Free Delivery</span> with this seller <?php echo $html->image("free-del.png",array('width'=>"26",'height'=>"12", 'alt'=>"" )); ?></p>
					<?php if(!empty($product_details['Product']['minimum_price_seller'])) {
						 if(!empty($product_details['ProductSeller']['quantity'])) {
						 	if($product_details['ProductSeller']['quantity'] > 0) {
					?>
					<p class="green-color larger-font margin-tp"><strong>In Stock</strong></p>
					<?php }}} ?>
					<p class="margin-tp"><strong>Condition: NEW</strong></p>
					<p class="margin-tp"><strong>Comments:</strong></p>
					<p>Brand new. Dispatch Sameday!</p>
					<p>Shipping from: United Kingdom (<?php echo $html->link('What\'s this?',"#",array('escape'=>false,'class'=>'underline-link'));?>)</p>
					<p><span class="gray">Rating:</span> <?php echo $html->image("ylw-star.png",array('width'=>"11",'height'=>"11", 'alt'=>"" )); ?><?php echo $html->image("ylw-star.png",array('width'=>"11",'height'=>"11", 'alt'=>"" )); ?><?php echo $html->image("ylw-star.png",array('width'=>"11",'height'=>"11", 'alt'=>"" )); ?><?php echo $html->image("ylw-star.png",array('width'=>"11",'height'=>"11", 'alt'=>"" )); ?><?php echo $html->image("ylw-star.png",array('width'=>"11",'height'=>"11", 'alt'=>"" )); ?> (<?php echo $html->link('4432 ratings',"#",array('escape'=>false,'class'=>'underline-link'));?>)</p>
					<p class="bigger-font"><strong>99% positive</strong> over 12 months</p>
					<p class="margin-top"><?php echo $html->link('<span>Add to Basket</span>',"#",array('escape'=>false,'class'=>'grn-btn'));?> <?php 
					if(!empty($product_details['Product']['minimum_price_seller'])) {
						echo $html->link('<span>Make me an Offer</span>',"#",array('escape'=>false,'class'=>'ornge-btn'));
					} ?></p>
				</li>
				<li>
					<p><span class="price"><strong>&pound;34.99</strong></span> <span class="gray">+ 0.00 delivery</span></p>
					<p><span><strong>Seller</strong></span> <span class="bigger-font rate"><strong>eoutlet-uk</strong></span></p>
					<p class="green-color larger-font margin-tp"><strong>In Stock</strong></p>
					<p class="margin-tp"><strong>Condition: NEW</strong></p>
					<p>Shipping from: United Kingdom (<?php echo $html->link('What\'s this?',"#",array('escape'=>false,'class'=>'underline-link'));?>)</p>
					<p><span class="gray">Rating:</span> <?php echo $html->image("ylw-star.png",array('width'=>"11",'height'=>"11", 'alt'=>"" )); ?><?php echo $html->image("ylw-star.png",array('width'=>"11",'height'=>"11", 'alt'=>"" )); ?><?php echo $html->image("ylw-star.png",array('width'=>"11",'height'=>"11", 'alt'=>"" )); ?><?php echo $html->image("ylw-star.png",array('width'=>"11",'height'=>"11", 'alt'=>"" )); ?><?php echo $html->image("ylw-star.png",array('width'=>"11",'height'=>"11", 'alt'=>"" )); ?> (<?php echo $html->link('4432 ratings',"#",array('escape'=>false,'class'=>'underline-link'));?>)</p>
					<p class="bigger-font"><strong>99% positive</strong> over 12 months</p>
					<p class="margin-top"><?php echo $html->link('<span>Add to Basket</span>',"#",array('escape'=>false,'class'=>'grn-btn'));?> <?php echo $html->link('><span>Make me an Offer</span>',"#",array('escape'=>false,'class'=>'ornge-btn'));?></p>
				</li>
				<li>
					<p><span class="price"><strong>&pound;34.99</strong></span> <span class="gray">+ 0.00 delivery</span></p>
					<p><span><strong>Seller</strong></span> <span class="bigger-font rate"><strong>eoutlet-uk</strong></span></p>
					<p class="green-color larger-font margin-tp"><strong>In Stock</strong></p>
					<p class="margin-tp"><strong>Condition: NEW</strong></p>
					<p>Shipping from: United Kingdom (<?php echo $html->link('What\'s this?',"#",array('escape'=>false,'class'=>'underline-link'));?>)</p>
					<p><span class="gray">Rating:</span> <?php echo $html->image("ylw-star.png",array('width'=>"11",'height'=>"11", 'alt'=>"" )); ?><?php echo $html->image("ylw-star.png",array('width'=>"11",'height'=>"11", 'alt'=>"" )); ?><?php echo $html->image("ylw-star.png",array('width'=>"11",'height'=>"11", 'alt'=>"" )); ?><?php echo $html->image("ylw-star.png",array('width'=>"11",'height'=>"11", 'alt'=>"" )); ?><?php echo $html->image("ylw-star.png",array('width'=>"11",'height'=>"11", 'alt'=>"" )); ?> (<?php echo $html->link('4432 ratings',"#",array('escape'=>false,'class'=>'underline-link'));?>)</p>
					<p class="bigger-font"><strong>99% positive</strong> over 12 months</p>
					<p class="margin-top"><?php echo $html->link('<span>Add to Basket</span>',"#",array('escape'=>false,'class'=>'grn-btn'));?> <?php echo $html->link('<span>Make me an Offer</span>',"#",array('escape'=>false,'class'=>'ornge-btn'));?></p>
				</li>
			</ul>
		</div>
	</div>
	<!--Top iPod Sellers Closed-->
</div>
<!--Right Section Closed-->

<!--Right Widget Start-->
<div class="right-widget margn-left">
	<div class="side-content"><?php echo $html->link($html->image("subscribe-save-banner.png",array('width'=>"168",'height'=>"123", 'alt'=>"" )),"#",array('escape'=>false,'class'=>''));?></div>
	<!--Top iPod Sellers Start-->
		<div class="side-content">
			<h4 class="gray-bg-head black-color center"><span>Top iPod Sellers</span></h4>
			<div class="gray-fade-bg-box">
				<ul class="best-sellers">
				<li>Updated hourly</li>
				<li>
					<div class="seller-left-numbering"><span class="numbering"><strong>1.</strong></span> </div>
					<div class="seller-right-ctnt"><?php echo $html->link('SanDisk 16GB SD / SDHC Memory Card',"#",array('escape'=>false,'class'=>''));?></div>
				</li>
				<li>
					<div class="seller-left-numbering"><span class="numbering"><strong>2.</strong></span> </div>
					<div class="seller-right-ctnt"><?php echo $html->link('SanDisk 4GB SD / SDHC Memory Card',"#",array('escape'=>false,'class'=>''));?></div>
				</li>
				<li>
					<div class="seller-left-numbering"><span class="numbering"><strong>3.</strong></span> </div>
					<div class="seller-right-ctnt"><?php echo $html->link('SanDisk 8GB SD / SDHC Memory Card',"#",array('escape'=>false,'class'=>''));?></div>
				</li>
				<li>
					<div class="seller-left-numbering"><span class="numbering"><strong>4.</strong></span> </div>
					<div class="seller-right-ctnt"><?php echo $html->link('SanDisk 2GB SD / SDHC Memory Card',"#",array('escape'=>false,'class'=>''));?></div>
				</li>
				<li>
					<div class="seller-left-numbering"><span class="numbering"><strong>5.</strong></span> </div>
					<div class="seller-right-ctnt"><?php echo $html->link('SanDisk 4GB SD / SDHC Memory Card',"#",array('escape'=>false,'class'=>''));?></div>
				</li>
			</ul>
		</div>
	</div>
	<!--Top iPod Sellers Closed-->
	<!--Top Electronics Sellers Start-->
	<div class="side-content">
		<h4 class="gray-bg-head black-color center"><span>Top Electronics Sellers</span></h4>
		<div class="gray-fade-bg-box">
			<ul class="best-sellers">
				<li>Updated hourly</li>
				<li>
					<div class="seller-left-numbering"><span class="numbering"><strong>1.</strong></span> </div>
					<div class="seller-right-ctnt"><?php echo $html->link('SanDisk 16GB SD / SDHC Memory Card',"#",array('escape'=>false,'class'=>''));?></div>
				</li>
				<li>
					<div class="seller-left-numbering"><span class="numbering"><strong>2.</strong></span> </div>
					<div class="seller-right-ctnt"><?php echo $html->link('SanDisk 4GB SD / SDHC Memory Card',"#",array('escape'=>false,'class'=>''));?></div>
				</li>
				<li>
					<div class="seller-left-numbering"><span class="numbering"><strong>3.</strong></span> </div>
					<div class="seller-right-ctnt"><?php echo $html->link('SanDisk 8GB SD / SDHC Memory Card',"#",array('escape'=>false,'class'=>''));?></div>
				</li>
				<li>
					<div class="seller-left-numbering"><span class="numbering"><strong>4.</strong></span> </div>
					<div class="seller-right-ctnt"><?php echo $html->link('SanDisk 2GB SD / SDHC Memory Card',"#",array('escape'=>false,'class'=>''));?></div>
				</li>
				<li>
					<div class="seller-left-numbering"><span class="numbering"><strong>5.</strong></span> </div>
					<div class="seller-right-ctnt"><?php echo $html->link('SanDisk 4GB SD / SDHC Memory Card',"#",array('escape'=>false,'class'=>''));?></div>
				</li>
				<li>
					<div class="seller-left-numbering"><span class="numbering"><strong>6.</strong></span> </div>
					<div class="seller-right-ctnt"><?php echo $html->link('SanDisk 16GB SD / SDHC Memory Card',"#",array('escape'=>false,'class'=>''));?></div>
				</li>
				<li>
					<div class="seller-left-numbering"><span class="numbering"><strong>7.</strong></span> </div>
					<div class="seller-right-ctnt"><?php echo $html->link('SanDisk 4GB SD / SDHC Memory Card',"#",array('escape'=>false,'class'=>''));?></div>
				</li>
				<li>
					<div class="seller-left-numbering"><span class="numbering"><strong>8.</strong></span> </div>
					<div class="seller-right-ctnt"><?php echo $html->link('SanDisk 8GB SD / SDHC Memory Card',"#",array('escape'=>false,'class'=>''));?></div>
				</li>
				<li>
					<div class="seller-left-numbering"><span class="numbering"><strong>9.</strong></span> </div>
					<div class="seller-right-ctnt"><?php echo $html->link('SanDisk 2GB SD / SDHC Memory Card',"#",array('escape'=>false,'class'=>''));?></div>
				</li>
				<li>
					<div class="seller-left-numbering"><span class="numbering"><strong>10.</strong></span> </div>
					<div class="seller-right-ctnt"><?php echo $html->link('SanDisk 4GB SD / SDHC Memory Card',"#",array('escape'=>false,'class'=>''));?></div>
				</li>
			</ul>
		</div>
	</div>
	<!--Top Electronics Sellers Closed-->
</div>
<!--Right Widget Closed-->

 <!--mid Content Start-->
<div class="mid-content pro-mid-content">
	<?php echo $html->link('',"#",array('id'=>'top','name'=>'top','escape'=>false,'class'=>''));?>
	<!--Product Preview Widget Start-->
	<div class="product-preview-widget">
		<?php 
		if ($session->check('Message.flash')){ ?>
		<div >
			<div class="messageBlock"><?php echo $session->flash();?></div>
		</div>
		<?php }
		?>
		<!--Product Image Statt-->
		<div class="product-image">
			<div style="height:200px; width:200px;text-align:center;">
			<?php 
			if(!empty($product_details['Product']['product_image'])){
				$main_imagePath = WWW_ROOT.PATH_PRODUCT.$product_details['Product']['product_image'];
				if(file_exists($main_imagePath)){
					$arrImageDim1 = $format->custom_image_dimentions($main_imagePath,200,200);
					echo $html->image('/'.PATH_PRODUCT."medium/img_200_".$product_details['Product']['product_image'], array('alt'=>""));
				}
			}?></div>
			<p align="center"><?php 
				$linkmain_str = '/categories/enlarge_mainimage/'.$product_details['Product']['id'];
				echo $html->link('<strong>View Larger Image</strong>',$linkmain_str,array('escape'=>false,'class'=>'view-larger large-image'));?></p>
			<p align="center" class="thumb-imgs">
			<?php if(!empty($product_details['Productimage'])) {
				foreach($product_details['Productimage'] as $pro_image){
					if(!empty($pro_image['image'])){
						$thumb_imagePath = WWW_ROOT.PATH_PRODUCT.$pro_image['image'];
						if(file_exists($thumb_imagePath)){
							$arrImageDim2 = $format->custom_image_dimentions($thumb_imagePath,30,30);
							$siteUrl = Configure::read('siteUrl');
							$image_url = $html->image('/'.PATH_PRODUCT.$pro_image['image'], array('width'=>$arrImageDim2['width'], 'alt'=>""));
							$link_str = '/categories/enlarge_image/'.$pro_image['id'];
							echo $html->link($image_url,$link_str,array('escape'=>false,'class'=>'large-image','title'=>'Enlarge'),false,false);
						}
					}
				}
			}?>
			</p>
                </div>
		<!--Product Image Closed-->
		<!--Product details Section Start-->
		<div class="product-details-sec">
			<h2><?php if(!empty($product_details['Product']['product_name'])) echo $product_details['Product']['product_name'];?></h2>
			<ul class="pro-details">
				
				<?php
				$rrp_price = $product_details['Product']['product_rrp'];
				$lowest_price = $product_details['Product']['minimum_price_value'];
				$lowest_price_seller_id = $product_details['Product']['minimum_price_seller']; 
				if($rrp_price > $lowest_price && !empty($lowest_price) ){
					$prod_price = $lowest_price;
					$saving = $rrp_price - $lowest_price;
					$saving_percentage = number_format(($saving/$rrp_price)* 100, 2);
				}else{
					$prod_price = $rrp_price;
					$saving = 0;
					$saving_percentage = 0;
				}
				
				//echo $lowest_price;
				?>
				
				
				<li><p><span class="price lrgr-fnt"><?php echo CURRENCY_SYMBOL,$prod_price;?></span> <span class="gray">+ 0.00 delivery</span></p>
					
					<?php if(!empty($saving) ){ ?>
					<p>RRP: <span class="rate"><strong><?php echo CURRENCY_SYMBOL,$rrp_price;?></strong></span> | You save: <span class="rate"><strong><?php echo CURRENCY_SYMBOL,$saving."($saving_percentage)%";?></strong></span></p>
					<?php  } ?>
					<p class="rating-sec"><?php echo $common->displayProductRatingYellow_detail($product_details['Product']['avg_rating'],$product_details['Product']['id']); ?></p>
				</li>
				<li><p><strong>Price choice</strong></p>
					<p>New from <span class="price padding-right"><strong><?php echo CURRENCY_SYMBOL,$prod_price;?></strong></span>  Used from <span class="price"><strong>&pound;99.99</strong></span></p></li>
					<li><strong>Qty</strong>
						<input onkeyup= "javascript: if(isNaN(this.value)){ this.clear(); }" id="prod_quantity_id", type="text" name="qty" class="textfield" value="1" style="width:44px; vertical-align:middle;" />
					<?php
					if( !empty($lowest_price_seller_id) ){ 
					//product_id, qty,price,seller_id,conditiono
					if(empty($product_details['Product']['minimum_price_value']) ){
						$product_details['Product']['minimum_price_value'] = '0';
					}
					if(empty($product_details['Product']['minimum_price_seller']) ){
						$product_details['Product']['minimum_price_seller'] = '0';
					}
					//$qty = echo "<script> jQuery('#prod_quantity').val()</script>";
					$addToBasket =  $product_details['Product']['id'].",'prod_quantity_id',";
					$addToBasket .= $product_details['Product']['minimum_price_value'].",". $product_details['Product']['minimum_price_seller'].",";
					$addToBasket .= 1;
						echo $html->image("add-to-cart-img.png",array('alt'=>"",'style'=>'vertical-align:middle;','onclick'=>'addToBasket('.$addToBasket.');'  ));
					}else{ // 
						echo $html->image("add-to-cart-img-disabled.png",array('alt'=>"",'style'=>'vertical-align:middle;'  ));	
					}
					
					?><!--<input type="image" src="images/add-to-cart-img.png" name="button2" value="Submit" style="vertical-align:middle;" />-->
				</li>
				<li><p class="green-color larger-fnt margin-top"><strong>In Stock</strong></p>
				<p><strong>Seller</strong> ABC Home &amp; Garden</p>
				<p><span class="gray">Rating:</span> <?php echo $html->image("ylw-star.png",array('width'=>"11",'height'=>"11", 'alt'=>"" )); ?><?php echo $html->image("ylw-star.png",array('width'=>"11",'height'=>"11", 'alt'=>"" )); ?><?php echo $html->image("ylw-star.png",array('width'=>"11",'height'=>"11", 'alt'=>"" )); ?><?php echo $html->image("ylw-star.png",array('width'=>"11",'height'=>"11", 'alt'=>"" )); ?><?php echo $html->image("ylw-star.png",array('width'=>"11",'height'=>"11", 'alt'=>"" )); ?> (<?php echo $html->link('1 rating',"#",array('escape'=>false,'class'=>'underline-link'));?>) <strong>99% positive</strong> over 12 months </p></li>
				<p class="margin-top">
				<?php echo $html->link('<span>Make me an Offer</span>',"/offers/add/".$product_details['Product']['id'],array('id'=>'make_me_an_offer', 'escape'=>false,'class'=>'ornge-btn'));?>
				<?php echo $html->link('<span>Sell yours here</span>',"#",array('escape'=>false,'class'=>'blu-btn'));?> </p>
			</ul>
		</div>
		<!--Product details Section Closed-->	
	</div>
	<!--Product Preview Widget Closed-->
	<!--Frequently Bought Together Start-->
	<div class="row no-pad-btm">
		<!--FBTogether Start-->
		<div class="fbtogether">
			<h4 class="mid-gr-head blue-color"><span>Frequently Bought Together</span></h4>
			<!--fbtogetther-items Start-->
			<div class="fbtogetther-items">
				<div class="items-widget">
					<?php echo $html->image("fbt-img1.jpg",array('width'=>"54",'height'=>"75", 'alt'=>"" )); ?> <span class="plus-span">+</span>
					<?php echo $html->image("fbt-img2.jpg",array('width'=>"54",'height'=>"75", 'alt'=>"" )); ?> <span class="plus-span">+</span>
					<?php echo $html->image("fbt-img3.jpg",array('width'=>"54",'height'=>"75", 'alt'=>"" )); ?>
				</div>
				<div class="item-content">
					<p><strong>Price for all</strong> <span class="price"><strong>&pound;59.87</strong></span></p>
					<p><?php echo $html->link('<span>Add all to Basket</span>',"#",array('escape'=>false,'class'=>'grn-btn'));?></p>
					<p class="gray">Some of these items are dispatched sooner than the others.</p>
				</div>
			</div>
			<!--fbtogetther-items Closed-->
			<!--FBTogether items option Start-->
			<div class="optn">
				<p><input type="checkbox" name="checkbox" class="checkbox" /> 
				<strong>This item:</strong> Avatar [DVD] [2009] <strong>DVD</strong></p>
				<p><input type="checkbox" name="checkbox" class="checkbox" /> 
				<?php echo $html->link('Sherlock Holmes [DVD] [2009]',"#",array('escape'=>false,'class'=>'underline-link'));?> <strong>DVD</strong></p>
				<p><input type="checkbox" name="checkbox" class="checkbox" /> 
				<?php echo $html->link('Alice in Wonderland [DVD] [2009]',"#",array('escape'=>false,'class'=>'underline-link'));?> <strong>DVD</strong></p>
			</div>
			<!--FBTogether items option Closed-->
		</div>
		<!--FBTogether Closed-->
	</div>
	<!--Frequently Bought Together Closed-->
	<!--Product Description Start-->
	<div class="row no-pad-btm">
		<!--FBTogether Start-->
		<div class="fbtogether">
			<h4 class="mid-gr-head blue-color"><span>Product Description</span></h4>
			<!--Product Description Start-->
			<div class="product-des">
				<?php  if(!empty($product_details['ProductDetail']['description'])){ ?>
				<p><?php echo $product_details['ProductDetail']['description'] ;?></p>
				<?php }
				if(!empty($product_details['ProductDetail']['product_features'])){ ?>
				<p><strong>Key benefit</strong></p>
				<?php echo $product_details['ProductDetail']['product_features']; }?>
			</div>
			<!--Product Description Closed-->
		</div>
		<!--FBTogether Closed-->
	</div>
	<!--Product Description Closed-->
	<!--What Do Customers Ultimately Buy After Viewing This Item? Start-->
	<div class="row no-pad-btm">
		<!--FBTogether Start-->
		<div class="fbtogether">
			<h4 class="mid-gr-head blue-color"><span>What Do Customers Ultimately Buy After Viewing This Item?</span></h4>
			<div class="product-des no-pad-btm">
				<div class="row overflow-h">
					<div class="prod-itm"><?php echo $html->image("fbt-img1.jpg",array('width'=>"50",'height'=>"50", 'alt'=>"" ));?></div>
					<div class="prod-itm-con">
						<p class="green-color larger-fnt"><strong>93% buy the item on this page</strong></p>
						<p>Avatar [DVD] [2009] <span class="padding-left"><?php echo $html->image("red-star-rating.png",array('width'=>"12",'height'=>"12", 'alt'=>"" ));?><?php echo $html->image("red-star-rating.png",array('width'=>"12",'height'=>"12", 'alt'=>"" ));?><?php echo $html->image("red-star-rating.png",array('width'=>"12",'height'=>"12", 'alt'=>"" ));?><?php echo $html->image("red-star-rating.png",array('width'=>"12",'height'=>"12", 'alt'=>"" ));?><?php echo $html->image("red-star-rating.png",array('width'=>"12",'height'=>"12", 'alt'=>"" ));?></span>  (<?php echo $html->link('604',"#",array('escape'=>false,'class'=>'underline-link'));?>)</p>
						<p class="price"><strong>&pound;12.97</strong></p>
					</div>
				</div>
				<div class="row overflow-h">
					<div class="prod-itm"><?php echo $html->image("fbt-img2.jpg" ,array('width'=>"50",'height'=>"50", 'alt'=>""));?></div>
					<div class="prod-itm-con">
						<p><strong>3%</strong> buy</p>
						<p><?php echo $html->link('Sherlock Holmes [DVD] [2009]',"#",array('escape'=>false,'class'=>'underline-link'));?> <span class="padding-left"><?php echo $html->image("red-star-rating.png",array('width'=>"12",'height'=>"12", 'alt'=>"" ));?><?php echo $html->image("red-star-rating.png",array('width'=>"12",'height'=>"12", 'alt'=>"" ));?><?php echo $html->image("red-star-rating.png",array('width'=>"12",'height'=>"12", 'alt'=>"" ));?><?php echo $html->image("half-red-star-rating.png",array('width'=>"12",'height'=>"12", 'alt'=>"" ));?><?php echo $html->image("gray-star-rating.png",array('width'=>"12",'height'=>"12", 'alt'=>"" ));?></span>  (<?php echo $html->link('604',"#",array('escape'=>false,'class'=>'underline-link'));?>)</p>
						<p class="price"><strong>&pound;12.97</strong></p>
					</div>
				</div>
				<div class="row overflow-h">
					<div class="prod-itm"><?php echo $html->image("fbt-img3.jpg",array('width'=>"50",'height'=>"50", 'alt'=>""));?></div>
					<div class="prod-itm-con">
						<p><strong>2%</strong> buy</p>
						<p><?php echo $html->link('Alice in Wonderland [DVD] [2009]',"#",array('escape'=>false,'class'=>'underline-link'));?> <span class="padding-left"><?php echo $html->image("red-star-rating.png",array('width'=>"12",'height'=>"12", 'alt'=>"" ));?><?php echo $html->image("red-star-rating.png",array('width'=>"12",'height'=>"12", 'alt'=>"" ));?><?php echo $html->image("red-star-rating.png",array('width'=>"12",'height'=>"12", 'alt'=>"" ));?><?php echo $html->image("half-red-star-rating.png",array('width'=>"12",'height'=>"12", 'alt'=>"" ));?><?php echo $html->image("gray-star-rating.png",array('width'=>"12",'height'=>"12", 'alt'=>"" ));?></span>  (<?php echo $html->link('604',"#",array('escape'=>false,'class'=>'underline-link'));?>)</p>
						<p class="price"><strong>&pound;12.97</strong></p>
					</div>
				</div>
				<div class="row overflow-h">
					<div class="prod-itm"><?php echo $html->image("fbt-img3.jpg",array('width'=>"50",'height'=>"50", 'alt'=>"" ));?></div>
					<div class="prod-itm-con">
						<p><strong>1%</strong> buy</p>
						<p>Avatar [DVD] [2009] <span class="padding-left"><?php echo $html->image("red-star-rating.png",array('width'=>"12",'height'=>"12", 'alt'=>"" ));?><?php echo $html->image("red-star-rating.png",array('width'=>"12",'height'=>"12", 'alt'=>"" ));?><?php echo $html->image("red-star-rating.png",array('width'=>"12",'height'=>"12", 'alt'=>"" ));?><?php echo $html->image("red-star-rating.png",array('width'=>"12",'height'=>"12", 'alt'=>"" ));?><?php echo $html->image("red-star-rating.png",array('width'=>"12",'height'=>"12", 'alt'=>"" ));?></span>  (<?php echo $html->link('604',"#",array('escape'=>false,'class'=>'underline-link'));?>)</p>
						<p class="price"><strong>&pound;12.97</strong></p>
					</div>
				</div>
				<p class="smalr-fnt">Visit our <?php echo $html->link('Christmas',"#",array('escape'=>false,'class'=>'underline-link'));?> for a fantastic selection of brands and product, all at great prices.</p>
			</div>
		</div>
		<!--FBTogether Closed-->
	</div>
	<!--What Do Customers Ultimately Buy After Viewing This Item? Closed-->
	<!--Delivery Information Start-->
	<div class="row no-pad-btm">
		<!--FBTogether Start-->
		<div class="fbtogether">
			<h4 class="mid-gr-head blue-color"><span>Delivery Information</span></h4>
			<!--Deliver Info Widget Start-->
			<div class="deliver-info">
				<div class="deliver-info-left">
					<p><?php echo $html->image("free-delivery-img.png",array('width'=>"140",'height'=>"54", 'alt'=>"" ));?></p>
					<p>Delivery in 3-5 working days</p>
					<p><?php echo $html->link('Click here for more details',"#",array('escape'=>false,'class'=>'red-link'));?></p>
				</div>
				<!--Deliver Info Right Start-->
				<div class="deliver-info-right">
					<p><strong>Want guarateed delevery by Tuesday, June 22?</strong> Order it in the next <span class="purple-color"><strong>23 hours</strong></span> and <span class="purple-color"><strong>20 minutes</strong></span>, and choose Express delivery at checkout.</p>
					<p class="no-pad-btm"><strong>Ships in original Packing:</strong> This item ships in its original manufacturers packaging. There will be shipping labels attached to the  outside of the package. Please mark this item as a in your cart if you do not wish to reveal the contents.</p>
				</div>
				<!--Deliver Info Right Closed-->
			</div>
			<!--Deliver Info Widget Closed-->
		</div>
		<!--FBTogether Closed-->
	</div>
	<!--Delivery Information Closed-->
	<!--Customers Who Bought This Item Also Bought Start-->
	<div class="row no-pad-btm">
		<h4 class="mid-gr-head blue-color"><span>Customers Who Bought This Item Also Bought</span></h4>
		<!--Products Widget Start-->
		<div class="top-products-widget">
			<ul class="products no-pad-btm">
				<li>
					<p class="image-sec"><?php echo $html->image("cat-img1.jpg",array('width'=>"",'height'=>"", 'alt'=>"" ));?></p>
					<p><?php echo $html->link('Alice in Wonderland [DVD] [2010]',"#",array('escape'=>false,'class'=>''));?></p>
					<p class="price larger-font"><strong>&pound;5.99</strong></p>
				</li>
				<li>
					<p class="image-sec"><?php echo $html->image("cat-img2.jpg",array('width'=>"",'height'=>"", 'alt'=>"" ));?></p>
					<p><?php echo $html->link('Alice in Wonderland [DVD] [2010]',"#",array('escape'=>false,'class'=>''));?></p>
					<p class="price larger-font"><strong>&pound;5.99</strong></p>
				</li>
				<li>
					<p class="image-sec"><?php echo $html->image("cat-img3.jpg",array('width'=>"",'height'=>"", 'alt'=>"" ));?></p>
					<p><?php echo $html->link('Alice in Wonderland [DVD] [2010]',"#",array('escape'=>false,'class'=>''));?></p>
					<p class="price larger-font"><strong>&pound;5.99</strong></p>
				</li>
				<li>
					<p class="image-sec"><?php echo $html->image("cat-img4.jpg",array('width'=>"",'height'=>"", 'alt'=>"" ));?></p>
					<p><?php echo $html->link('Alice in Wonderland [DVD] [2010]',"#",array('escape'=>false,'class'=>''));?></p>
					<p class="price larger-font"><strong>&pound;5.99</strong></p>
				</li>
			</ul>
		</div>
		<!--Products Widget Closed-->
	</div>
	<!--Customers Who Bought This Item Also Bought Closed-->
	<!--Technical Details Start-->
	<div class="row no-pad-btm">
		<!--FBTogether Start-->
		<div class="fbtogether">
			<h4 class="mid-gr-head blue-color"><span>Technical Details</span></h4>
			<div class="tec-details"><?php $dem = '';?>
				<p><strong>Product Dimensions:</strong> <?php if(!empty($product_details['ProductDetail']['product_height'])) $dem = $product_details['ProductDetail']['product_height'];  if(!empty($product_details['ProductDetail']['product_width'])){
					if(!empty($dem))
						$dem .= ' * '.$product_details['ProductDetail']['product_width'];
					else
						$dem = $product_details['ProductDetail']['product_width']; 
				}
				if(!empty($product_details['ProductDetail']['product_length'])){
					if(!empty($dem))
						$dem .= ' * '.$product_details['ProductDetail']['product_length'];
					else
						$dem = $product_details['ProductDetail']['product_length'];}
				echo $dem;?>cm</p>
				<p><strong>Quick Code:</strong> <?php if(!empty($product_details['Product']['quick_code'])) echo $product_details['Product']['quick_code']; ?></p>
				<p><strong>Boxed-Product Weight:</strong> <?php if(!empty($product_details['ProductDetail']['product_weight'])) echo $product_details['ProductDetail']['product_weight'];?>g</p>
				<p><strong>Delivery Destinations:</strong> Visit the <?php echo $html->link('Delivery Destinations',"#",array('escape'=>false,'class'=>'smalr-fnt underline-link'));?> Help page to see where this item can be delivered.
				<span class="line-break-span">Find out more about our <?php echo $html->link('Delivery Rates and Returns Policy',"#",array('escape'=>false,'class'=>'smalr-fnt underline-link'));?></span></p>
				<p><strong>Item model number:</strong> <?php if(!empty($product_details['Product']['model_number'])) echo $product_details['Product']['model_number'];?></p>
			</div>
		</div>
		<!--FBTogether Closed-->
	</div>
	<!--Technical Details Closed-->
	<!--Search Tags Associated With This Product Start-->
	<div class="row no-pad-btm">
		<!--FBTogether Start-->
		<div class="fbtogether">
		<h4 class="mid-gr-head blue-color"><span>Search Tags Associated With This Product</span></h4>
			<div class="search-tags">
				<ul>
					<li><?php echo $html->link('Home &amp; Garden',"#",array('escape'=>false,'class'=>''));?></li>
					<li><?php echo $html->link('DeWalt 24V Cordless Drill',"#",array('escape'=>false,'class'=>''));?></li>
					<li><?php echo $html->link('Construction',"#",array('escape'=>false,'class'=>''));?></li>
				</ul>
			</div>
			<div class="search-tags">
				<ul>
					<li><?php echo $html->link('Choiceful',"#",array('escape'=>false,'class'=>''));?></li>
					<li><?php echo $html->link('DeWalt Deal',"#",array('escape'=>false,'class'=>''));?></li>
					<li><?php echo $html->link('Power Tools',"#",array('escape'=>false,'class'=>''));?></li>
				</ul>
			</div>
			<div class="share-tags pad-top">Share this Product 
				<?php echo $html->image("facebook-sml-icon.png",array('width'=>"14",'height'=>"14", 'alt'=>"" ));?>
				<?php echo $html->image("myspace-icon.png",array('width'=>"16",'height'=>"14", 'alt'=>"" ));?>
				<?php echo $html->image("delicious-icon.png",array('width'=>"16",'height'=>"16", 'alt'=>"" ));?>
				<?php echo $html->image("twitter-logo.gif",array('width'=>"16",'height'=>"16", 'alt'=>"" ));?>
			</div>
			<div class="clear"></div>
		</div>
		<!--FBTogether Closed-->
	</div>
	<!--Search Tags Associated With This Product Closed-->
	<!--Rate This Item Start-->
	<div class="row no-pad-btm">
		<!--FBTogether Start-->
		<div class="fbtogether">
			<h4 class="mid-gr-head blue-color"><span>Rate This Item</span></h4>
			<div class="rate-this-item" id="avg_rate">
				<?php echo $this->element('product/save_rating'); ?>
			</div>
		</div>
		<!--FBTogether Closed-->
	</div>
	<!--Rate This Item Closed-->
	
	<?php $this->set('product_details',$product_details);
	echo $this->element('product/reviews');
	echo $this->element('product/question_answers');?>
	<!--More to Explore Start-->
	<div class="row no-pad-btm">
		<!--FBTogether Start-->
		<div class="fbtogether">
			<h4 class="mid-gr-head blue-color"><span>More to Explore</span></h4>
			<div class="tec-details">
				<ul class="more-links">
					<li><?php echo $html->link('Hand',"#",array('escape'=>false,'class'=>''));?> &gt; <?php echo $html->link('Magnifiers',"#",array('escape'=>false,'class'=>''));?></li>
					<li><?php echo $html->link('>Building Supplies',"#",array('escape'=>false,'class'=>''));?> &gt; <?php echo $html->link('Expanding Foams',"#",array('escape'=>false,'class'=>''));?></li>
					<li><?php echo $html->link('>Decorating &amp; Painting',"#",array('escape'=>false,'class'=>''));?> &gt; <?php echo $html->link('Strippers, Removers &amp; Thinners',"#",array('escape'=>false,'class'=>''));?></li>
					<li><?php echo $html->link('Access Equipment',"#",array('escape'=>false,'class'=>''));?> &gt; <?php echo $html->link('Step Ladders',"#",array('escape'=>false,'class'=>''));?></li>
				</ul>
			</div>
		</div>
		<!--FBTogether Closed-->
	</div>
	<!--More to Explore Closed-->
	<!--Customers Viewing This Page May Be Interested in These Sponsored Links Start-->
	<div class="row no-pad-btm">
		<!--FBTogether Start-->
		<div class="fbtogether">
			<h4 class="mid-gr-head blue-color"><span>Customers Viewing This Page May Be Interested in These Sponsored Links</span></h4>
			<div class="tec-details">
				<div class="ad300x250">
					<p><?php echo $html->image("sponsore-img.jpg",array('width'=>"298",'height'=>"248", 'alt'=>"" ));?></p>
					<p align="center">Advertisement | <?php echo $html->link('Ad feedback',"#",array('escape'=>false,'class'=>'gray underline-link'));?></p>
				</div>
				<div class="smalr-fnt margin-top">
					<p><?php echo $html->link('<strong>Email a friend about this product!</strong>','/products/email_friend/'.$product_details['Product']['id'].'/'.$product_details['Product']['product_name'],array('id'=>'email_friend','escape'=>false,'class'=>'diff-blue-color'));?></p>
					<p>Seen a mistake on this page? 
					
					<?php 
					if(!empty($logg_user_id))
						$link_tell_admin = '/products/tell_admin/'.$product_details['Product']['id'].'/'.$product_details['Product']['product_name'];
					else
						$link_tell_admin = '/users/sign_in/';

					echo $html->link('<strong>Tell us about it!</strong>',$link_tell_admin,array('id'=>'email_friend','escape'=>false,'class'=>'diff-blue-color thisreport'));?></p>
					<p><?php echo $html->link('<strong>back to top</strong>',"#top",array('escape'=>false,'class'=>'diff-blue-color'));?></p>
				</div>
			</div>
		</div>
		<!--FBTogether Closed-->
	</div>
	<!--Customers Viewing This Page May Be Interested in These Sponsored Links Closed-->
	<!--Recent History Widget Start-->
	<div class="recent-history-widget">
		<!--Recent History Start-->
		<div class="recent-history">
			<h4><strong>Your Recent History</strong></h4>
			<ul>
				<li><?php echo $html->image("recent-his-img1.gif",array('width'=>"20",'height'=>"20", 'alt'=>""));?> <?php echo $html->link('Sherlock Holmes [DVD] [2009]',"#",array('escape'=>false,'class'=>''));?></li>
				<li><?php echo $html->image("recent-his-img2.gif",array('width'=>"20",'height'=>"20", 'alt'=>""));?> <?php echo $html->link('The Hurt Locker [DVD] [2008]',"#",array('escape'=>false,'class'=>''));?></li>
				<li><?php echo $html->image("recent-his-img3.gif",array('width'=>"20",'height'=>"20", 'alt'=>""));?> <?php echo $html->link('Sherlock Holmes [DVD] [2009]',"#",array('escape'=>false,'class'=>''));?></li>
				<li><?php echo $html->image("recent-his-img4.gif",array('width'=>"20",'height'=>"20", 'alt'=>""));?> <?php echo $html->link('The Hurt Locker [DVD] [2008]',"#",array('escape'=>false,'class'=>''));?></li>
				<li><?php echo $html->image("recent-his-img5.gif",array('width'=>"20",'height'=>"20", 'alt'=>""));?> <?php echo $html->link('Alice in Wonderland [DVD] [2008]',"#",array('escape'=>false,'class'=>''));?></li>
			</ul>
		</div>
		<!--Recent History Closed-->
		<!--Recent History Product List Start-->
		<div class="recent-history-pro-list">
			<h4><strong>Countinue Shopping:</strong> Customers who bought items in your recent history also bought</h4>
			<ul class="products">
				<li>
					<p class="image-sec"><?php echo $html->image("cat-img2.jpg",array('width'=>"",'height'=>"", 'alt'=>""));?></p>
					<p><?php echo $html->link('Alice in Wonderland [DVD] [2010]',"#",array('escape'=>false,'class'=>''));?></p>
					<p class="price larger-font"><strong>&pound;5.99</strong></p>
				</li>
				<li>
					<p class="image-sec"><?php echo $html->image("cat-img3.jpg",array('width'=>"",'height'=>"", 'alt'=>""));?></p>
					<p><?php echo $html->link('Alice in Wonderland [DVD] [2010]',"#",array('escape'=>false,'class'=>''));?></p>
					<p class="price larger-font"><strong>&pound;5.99</strong></p>
				</li>
				<li>
					<p class="image-sec"><?php echo $html->image("cat-img4.jpg",array('width'=>"",'height'=>"", 'alt'=>""));?></p>
					<p><?php echo $html->link('Alice in Wonderland [DVD] [2010]',"#",array('escape'=>false,'class'=>''));?></p>
					<p class="price larger-font"><strong>&pound;5.99</strong></p>
				</li>
				<li>
					<p class="image-sec"><?php echo $html->image("cat-img5.jpg",array('width'=>"",'height'=>"", 'alt'=>""));?></p>
					<p><?php echo $html->link('Alice in Wonderland [DVD] [2010]',"#",array('escape'=>false,'class'=>''));?></p>
					<p class="price larger-font"><strong>&pound;5.99</strong></p>
				</li>
				<li>
					<p class="image-sec"><?php echo $html->image("cat-img6.jpg",array('width'=>"",'height'=>"", 'alt'=>""));?></p>
					<p><?php echo $html->link('Alice in Wonderland [DVD] [2010]',"#",array('escape'=>false,'class'=>''));?></p>
					<p class="price larger-font"><strong>&pound;5.99</strong></p>
				</li>
			</ul>
		</div>
		<!--Recent History Product List Closed-->
	</div>
	<!--Recent History Widget Closed-->
</div>
<!--mid Content Closed-->
<script type="text/javascript">

function openwindow(linkurl) {
	window.open(linkurl,"mywindow","menubar=0,scrollbar=1,resizable=1,width=600,height=600");
}


function change_star(starid){
	var id = starid;
	for(var i=1; i <= id; i++){
		jQuery('#s_'+i).attr('src', '/img/ylw-star.png');
	}
}

function change_toblstar(starid){
	var id = starid;
	for(var i=1; i <= id; i++){
		jQuery('#s_'+i).attr('src', '/img/bl-start.png');
	}
}

function save_rating(stars){
	var p_id = <?php echo $product_details['Product']['id'];?>;
	var postUrl = SITE_URL+'products/save_rating/'+p_id+'/'+stars;
	jQuery.ajax({
		cache:false,
		async: false,
		type: "GET",
		url: postUrl,
		success: function(msg){
		/** Update the div**/
		jQuery('#avg_rate').html(msg);
	}
	});
}

</script>
