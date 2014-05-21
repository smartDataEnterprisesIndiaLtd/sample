<?php $sortByArr = array('sale'=>'Bestselling', 'date'=>'Relevence');
echo $javascript->link(array('lib/prototype'),false);
e($html->script('fancybox/jquery.fancybox-1.3.4.pack'));
e($html->script('fancybox/jquery.easing-1.3.pack'));
e($html->script('fancybox/jquery.mousewheel-3.0.4.pack',false));
echo $html->css('jquery.fancybox-1.3.4');

if(!isset($fhloc)){
	$fhloc = "";
}
if(!isset($ftitle)){
	$ftitle = "";
	$fvalue = "";	
}

	$logg_user_id_bc =0;
	$logg_user_id_bc = $this->Session->read('User.id');
	$this->set('logg_user_id_bc',$logg_user_id_bc);

	if(!empty($logg_user_id_bc)) {
		$offer_widthbc  = 362;
		$offer_heightbc = 230;
	} else{
		$offer_widthbc = 560;
		$offer_heightbc = 160;
	}
?>
<script language="JavaScript">

	jQuery(document).ready(function()  { // for writing a review	
		jQuery("a.mmao").fancybox({
			'autoScale' : true,
			'titlePosition': 'inside',
			'transitionIn' : 'none',
			'transitionOut' : 'none',
			'width' : <?php echo $offer_widthbc; ?>,
			'height' : <?php echo $offer_heightbc; ?>,
			'padding':0,'overlayColor':'#000000',
			'overlayOpacity':0.5,
			'opacity':	true,
			'transitionIn' : 'fade',
			'transitionOut' : 'fade',
			'hideOnOverlayClick':false,
			'type' : 'iframe',
			'autoDimensions': false,
			'onClosed': function() {
				//parent.location.reload(true);;
			}
		});
	});
</script>

<style>
.nav{
	text-align:right; padding:10px 0px;border-top:1px #dadada solid;
}
.nav a{display:inline-block; margin:0px 2px;}
.nav a:hover{text-decoration:underline;}
.nav a.highlight{color:#000000; font-weight:bold; text-decoration:none;}
</style>
<?php if(!empty($search_result)) {


	if($this->params['action'] == 'search_product'){
		$right_class = ''; ?>
		<style type="text/css">
		.form-textfield {
			width:90px;
		}
		</style>
	<?php } else{
		$right_class = 'box-margin-right';
	}
?>
<!--Sorting Start-->
<div class="sorting-widget">
	<?php 	echo $this->element('product/showingwidget_products_users_fh'); ?>
	<div class="sort-by">
		<?php echo $form->create('Product',array('action'=>'searchresult','method'=>'get','name'=>'frmProductsort','id'=>'frmProductsort'));?>
		Sort by: 
		<?php
			echo $form->select('Product.sort',$this->Common->fhsortlist(),@$sort,array('class'=>'select ', 'type'=>'select','onChange'=>'sort_list(this.value)'),'Relevance');
			echo $form->hidden('Marketplace.keywords',array('id'=>'search_keywords', 'class'=>'textfield', 'style'=>'width:77%', 'label'=>false,'div'=>false, 'escape'=>false, 'value'=>$searchWord));
			echo $form->hidden('Marketplace.department',array('class'=>'textfield', 'style'=>'width:77%', 'label'=>false,'div'=>false, 'escape'=>false, 'value'=>$department_id));
		?>
		<?php echo $form->hidden('Product.fhloc',array('class'=>'textfield', 'style'=>'width:77%', 'label'=>false,'div'=>false, 'escape'=>false, 'value'=>$fhloc));?>
		<?php echo $form->hidden('Product.ftitle',array('class'=>'textfield', 'style'=>'width:77%', 'label'=>false,'div'=>false, 'escape'=>false, 'value'=>$ftitle));?>
		<?php echo $form->hidden('Product.fvalue',array('class'=>'textfield', 'style'=>'width:77%', 'label'=>false,'div'=>false, 'escape'=>false, 'value'=>$fvalue));?>
	</div>
	<?php echo $form->end();?>
	<div class="clear"></div>
</div>
<!--Sorting Closed-->

<!--Product Listings Widget Start-->
<div class="products-listings-widget product123" style="min-height:1455px;">
	<!--Left Widget Start-->
	<div class="product-listings-wdgt">
	<!--Search Products Start-->
	<!--Sorting Closed-->
		<?php //pr($search_result); die; ?>
		<?php

		if(!empty($results))
			$i = $results['start_index']+1;
		else
			$i =1;
		
		$jkl = 0;
		
		if(!empty($search_result)) {
		foreach($search_result as $search_result){
		?>
		<div class="pro-listing-row">
			<div class="pro-img">
				<?php
				$pr_id = $common->getProductId_Qccode($search_result['secondid']);
				if(!empty($search_result['product_image'])){
					$image_path = WWW_ROOT.PATH_PRODUCT.'small/img_100_'.$search_result['product_image'];
					if(!file_exists($image_path) ){
						$image_path = '/img/no_image_100.jpg';
					}else{
						$image_path = '/'.PATH_PRODUCT.'small/img_100_'.$search_result['product_image'];
					}
				} else{
					$image_path = '/img/no_image_100.jpg.jpeg';
				}
				echo $html->link($html->image($image_path ,array('alt'=>$search_result['product_name'], 'title'=>$search_result['product_name']  )),'/'.$this->Common->getProductUrl($pr_id).'/categories/productdetail/'.$pr_id,array('escape'=>false,'class'=>"underline-link")); 
			?>
			</div>
			<div class="numric-widget" style="width:70px"><?php echo $i;?>. </div>
			<div class="product-details-widget">
				<?php echo $html->link('<strong>'.$search_result['product_name'].'</strong>','/'.$this->Common->getProductUrl($pr_id).'/categories/productdetail/'.$pr_id,array('escape'=>false,'class'=>"underline-link"));?>
				<p class="used-from pad-tp">
					
					<?php
					$new_value = 0;
					$product_rrp = 0;
					$minimum_price_used = 0;$minimum_price_value = 0;
					$prodStock = '';
					if(key_exists('minimum_price_value',$search_result) && $search_result['minimum_price_value'] > 0) {
						$new_value = $search_result['minimum_price_value'];
						echo 'New from <span class="price larger-font"><strong>'.CURRENCY_SYMBOL.$format->money($search_result['minimum_price_value'],2).'</strong></span> ';
						$min_new_seller  = $search_result['minimum_price_seller'];
						$min_new_con  = $search_result['condition_new'];
						$minimum_price_value = $search_result['minimum_price_value'];
					}
						
					if(key_exists('minimum_price_used',$search_result) && $search_result['minimum_price_used'] > 0) {
						echo ' Used from <span class="price larger-font"><strong>'.CURRENCY_SYMBOL.$format->money($search_result['minimum_price_used'],2).'</strong></span>&nbsp;';
						$min_used_seller = $search_result['minimum_price_used_seller'];
						$min_used_con = $search_result['condition_used'];
						$minimum_price_used = $search_result['minimum_price_used'];
					}
						
					if(!empty($search_result['product_rrp'])){
						$product_rrp = $search_result['product_rrp'];
					}
						
						/**********************************/
						
					if(!empty($minimum_price_value)){
						$min_price = $minimum_price_value;
						if(!empty($product_rrp)){
							if($product_rrp > $minimum_price_value){
								
								$total_save = $product_rrp - $minimum_price_value;
								$saving_percentage = ($total_save / $product_rrp) * 100;
							}
						}
						if(!empty($min_new_seller)){
							$min_seller_id = $min_new_seller;
						}
						/*if(!empty($min_new_con)){
							$min_con_id = $this->Common->getProductConIdByConName($min_new_con);
						}*/
					} else if(!empty($minimum_price_used)){
						$min_price = $minimum_price_used;
						if(!empty($product_rrp)){
							if($product_rrp > $minimum_price_used){
								$total_save = $product_rrp - $minimum_price_used;
								$saving_percentage = ($total_save / $product_rrp) * 100;
							}
						}
						if(!empty($min_used_seller)){
							$min_seller_id = $min_used_seller;
						}
						/*if(!empty($min_used_con)){
							$min_con_id = $this->Common->getProductConIdByConName($min_used_con);
						}*/
					} else {
						$min_con_id = '';
						$min_seller_id = '';
						$min_price = '';
						$total_save = 0;
						$saving_percentage = 0;
					}
					// There is some change in FH We get directly conditin id from FH on 2-2-2012.
					if(!empty($min_new_con)){
							$min_con_id = $min_new_con;
						}else if(!empty($min_used_con)){
							$min_con_id = $min_used_con;
						}else{
							$min_con_id = '';
						}
						
						if(!empty($pr_id) && !empty($min_seller_id) && !empty($min_con_id)){
							$prodSellerInfo = $common->getProductSellerInfo($pr_id ,$min_seller_id, $min_con_id);
							$prodStock = $prodSellerInfo['ProductSeller']['quantity'];
						}
				?>
				</p>
				<p>RRP: <span class="gray-color">
				
					<?php if(!empty($minimum_price_used) || !empty($minimum_price_value)){?>
						<s><?php echo CURRENCY_SYMBOL.$format->money($product_rrp,2); ?></s>
					<?php }else{?>
						<?php echo CURRENCY_SYMBOL.$format->money($product_rrp,2); ?>
					<?php }?>
					
					</span>
					<?php if(!empty($minimum_price_used) || !empty($minimum_price_value)){?>
						| You save:
						<span class="yellow">
							<strong>
								<?php echo CURRENCY_SYMBOL.$format->money(@$total_save,2); ?> (<?php echo $format->money(@$saving_percentage,2); ?>%)
							</strong>
						</span>
					<?php }?>
				</p>
				<p>
					<?php 
						if($prodStock > 0){ ?>
							<strong class="green-color">In stock</strong> | Usually dispatched within 24 hours
						<?php } else { ?>
							<strong class="price">Out of stock</strong>| Temporarily out of stock -more expected soon 
						<?php }?>
						
					<?php 
					$rating = $common->displayProductRating($search_result['avg_rating'],@$pr_id); 
					echo $rating;
					?>
				</p>
				<?php if($prodStock > 0){ ?>
				<p>Get it by <strong><?php echo $format->estimatedDeliveryDayDate($pr_id);?></strong> if you order in the next <span class="green-color"><strong><?php echo $format->remainingTime();?></strong></span> and choose express delivery.</p>
				<?php } ?>
				<?php
				if(!empty($pr_id) && !empty($min_seller_id) && !empty($min_con_id)){
				$offerSerialize['p_id']  = $pr_id;
				if(!Empty($min_seller_id))
					$offerSerialize['s_id'] = $min_seller_id;
				if(!empty($min_con_id))
					$offerSerialize['c_id']  = $min_con_id;
				$offerSerialize['type']  = 'S';
				$encodeOfferData = base64_encode(serialize($offerSerialize));
				
				$free_delivery = $this->Common->getProductFreeDelivery($min_seller_id,$min_price);
				?>
				<p class="rates"> Eligible for <?php if(!empty($free_delivery)) { ?> <strong>FREE</strong> Standard Shipping &amp;<?php }?> <?php echo $html->link('<span class="rate"><strong>Make me an Offer&trade;</strong></span>',"/offers/add/".$encodeOfferData,array('escape'=>false,'class'=>'rate mmao')); ?></p>
				<?php } ?>
			</div>
		</div>
		<!--Row1 Closed-->
		<div class="clear"></div>
		<?php
		$i++;
		}?>
		<?php } ?>
	</div>
</div>
<!--Search Products Closed-->
<?php
	echo $this->element('product/paging_products_users_fh');
} else { ?>
<div class="search-result-pro-widget box-margin-right" style="min-height:1455px;">
	<div class="sortng-wdt" style ="border:none">
		<p align="center"><span class="larger-fnt"><strong>No record found.</strong></p>
		<div class="clear"></div>
	</div>
</div>
<?php }?>
<script type="text/javascript">
		
	/*jQuery(document).ready(function() {
		var heights =  jQuery('.left-content').height();
		jQuery('.search-result-pro-widget').css('min-height',parseInt(heights-10));
		jQuery('.products-listings-widget').css('min-height',parseInt(heights-80));
	});*/	
		
	function sort_list(sort_val){
		var search_keywords = jQuery('#search_keywords').val();
		var department_id = jQuery('#MarketplaceDepartment').val();
		var product_sort = sort_val;
		var url_fh = jQuery('#ProductFhloc').val();
		var ftitle = jQuery('#ProductFtitle').val();
		var fvalue = jQuery('#ProductFvalue').val();
		var urls= "<?php echo SITE_URL;?>products/searchresult/";
			if((search_keywords != "")){
				urls= urls = urls+'keywords:'+search_keywords;
			if((department_id != "")){
				urls = urls+"/dept_id:"+department_id;
			}
			if((product_sort != "")){
				urls = urls+"/sort_by:"+product_sort;
			}
			if((url_fh != "")){
				urls = urls+"/fh_loc:"+url_fh;
			}
			if((ftitle != "")){
				urls = urls+"/ftitle:"+ftitle;
			}
			if((fvalue != "")){
				urls = urls+"/fvalue:"+fvalue.replace("<","%3C");
			}
			}
		window.location.href = urls;
		return false;
	}
</script>

<!--Search Results Closed-->