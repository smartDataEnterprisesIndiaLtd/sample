<?php $sortByArr = array('sale'=>'Bestselling', 'date'=>'Relevence');
echo $javascript->link(array('lib/prototype'),false);
e($html->script('fancybox/jquery.fancybox-1.3.4.pack'));
e($html->script('fancybox/jquery.easing-1.3.pack'));
e($html->script('fancybox/jquery.mousewheel-3.0.4.pack',false));
echo $html->css('jquery.fancybox-1.3.4');

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
<?php if(empty($cat_items)){ ?>
	<div class="right-widget">
	<?php  //echo $this->element('navigations/right_navigation_category');?></div>
	<div class="mid-content">
		<!--Breadcrumb Closed-->
		<div class="breadcrumb-widget">
			<?php //echo $breadcrumb_string; ?>
		</div>
		<!--Breadcrumb Closed-->
		<h4 class="gr-bg-head"><span><?php  echo $cat_name_m;?></span></h4>
		<div class="row">
		<!--Products Widget Start-->
			<div class="products-widget" style="border-bottom:0px">
				<p style="padding:15px 5px">We're sorry, there are currently no items available in this category</p>
			</div>
			<!--Products Widget Closed-->
		</div>
	</div>
<?php } else { ?>
<div class="mid-content">
	<!--Breadcrumb Closed-->
	<div class="breadcrumb-widget">
		<?php //echo $breadcrumb_string; ?>
	</div>
	<!--Breadcrumb Closed-->
	
<div class="sorting-widget">
	<?php echo $this->element('product/showingwidget_products_users_fh'); ?>
	<?php
	$catname_arr = $this->Common->getCategoryName($selected_category);
	$catname = $catname_arr[0]['Category']['cat_name'];
	$cat_url_name = str_replace(array('&',' '), array('and','-'), html_entity_decode($catname, ENT_NOQUOTES, 'UTF-8'));
	$dept_url_name = str_replace(array('&',' '), array('and','-'), html_entity_decode($department_name, ENT_NOQUOTES, 'UTF-8'));
	$dept_url = $dept_url_name.'/'.$cat_url_name;
	$form->create('Category',array('action'=>'viewproducts','method'=>'get','name'=>'frmProductsort','id'=>'frmProductsort'));?>
	<?php if($crawl1){ ?>
	<div class="sort-by">
		Sort by: 
		<?php
			echo $form->select('Product.sort',$this->Common->fhsortlist(),@$sort_by,array('class'=>'textfield', 'type'=>'select','onChange'=>'sort_list(this.value)','default'=>'product_page_views_lifetime','empty'=>'Select'));
		?>
	</div>
<?php } ?>
	<?php echo $form->end();?>
	<div class="clear"></div>
</div>
	
	<!--Sorting Closed-->
	<!--Product Listings Widget Start-->
	<div class="products-listings-widget">

		<?php echo $this->element('navigations/viewproducts_right'); ?>
		<!--Left Widget Start-->
		<div class="product-listings-wdgt">
		<!--Row1 Start-->
		<?php if(!empty($results)){ 
			$start_records = '';
				if(!empty($results)){
					if(!empty($results['current_set'])) {
						$start_records = ($results['current_set'] - 1) * $view_size + 1;
					}
				}
			}
		?>		
				
		<?php
			//pr($cat_items);
			$i = $start_records;
			foreach($cat_items  as $cat_item){
					
				$minimum_price_used = "";
				$min_used_seller  = "";
				$min_used_con  = "";
				$minimum_price_value = "";
				$min_new_seller  = "";
				$min_new_con  = "";
				$prodStock = "";
				if(!empty($cat_item['product_image'])) {
					$image_path = WWW_ROOT.PATH_PRODUCT."/small/img_100_".$cat_item['product_image'];
						
					if(!file_exists($image_path) ){
						$image_path = '/img/no_image_100.jpg';
					}else{
						$image_path = '/'.PATH_PRODUCT.'small/img_100_'.$cat_item['product_image'];
					}
				} else {
					$image_path = '/img/no_image_100.jpg';
				}
				$pr_name = $cat_item['product_name'];
				$pr_id = $this->Common->getProductId_Qccode($cat_item['secondid']);
				$product_rrp = $cat_item['product_rrp'];
				$pr_avg_rate = $cat_item['avg_rating'];
				
				if(key_exists('minimum_price_used',$cat_item)){
					$minimum_price_used = $cat_item['minimum_price_used'];
				}
				if(key_exists('minimum_price_used_seller',$cat_item)){
					$min_used_seller  = $cat_item['minimum_price_used_seller'];
				}
				if(key_exists('condition_used',$cat_item)){
					$min_used_con  = $cat_item['condition_used'];
				}
					
				if(key_exists('minimum_price_value',$cat_item)){
					$minimum_price_value = $cat_item['minimum_price_value'];
				}
				if(key_exists('minimum_price_seller',$cat_item)){
					$min_new_seller  = $cat_item['minimum_price_seller'];
				}
				if(key_exists('condition_new',$cat_item)){
					$min_new_con  = $cat_item['condition_new'];
				}
					
					if(!empty($minimum_price_value)){
						$min_price = $minimum_price_value;
						if(!empty($product_rrp)){
							if($product_rrp > $minimum_price_value){
								$saving = $product_rrp - $minimum_price_value;
								$saving_perc = ($saving / $product_rrp) * 100;
							}
						}
						if(!empty($min_new_seller)){
							$min_seller_id = $min_new_seller;
						}
						if(!empty($min_new_con)){
							//$min_con_id = $this->Common->getProductConIdByConName($min_new_con);
							$min_con_id = $min_new_con;
						}
					} else if(!empty($minimum_price_used)){
						$min_price = $minimum_price_used;
						if(!empty($product_rrp)){
							if($product_rrp > $minimum_price_used){
								$saving = $product_rrp - $minimum_price_used;
								$saving_perc = ($saving / $product_rrp) * 100;
							}
						}
						if(!empty($min_used_seller)){
							$min_seller_id = $min_used_seller;
						}
						if(!empty($min_used_con)){
							//$min_con_id = $this->Common->getProductConIdByConName($min_used_con);
							$min_con_id = $min_used_con;
						}
					} else {
						$min_con_id = '';
						$min_seller_id = '';
						$min_price = '';
					}
					
					$rating = $common->displayProductRating($pr_avg_rate,$pr_id);
					if(!empty($pr_id) && !empty($min_seller_id) && !empty($min_con_id)){
						$prodSellerInfo = $common->getProductSellerInfo($pr_id ,$min_seller_id, $min_con_id);
						$prodStock = $prodSellerInfo['ProductSeller']['quantity'];
					}
			?>
			<div class="pro-listing-row">
				<div class="pro-img">
					<?php 
					echo $html->link($html->image($image_path , array("alt" => $pr_name, "title" => $pr_name, "border" => "0"  )),'/'.$this->Common->getProductUrl($pr_id).'/categories/productdetail/'.$pr_id,array('escape'=>false,'class'=>"underline-link")); ?>
				</div>
				<div class="numric-widget"><?php echo $i;?></div>
				<div class="product-details-widget">
					<h4>
						<?php echo $html->link('<strong>'.$pr_name.'</strong>','/'.$this->Common->getProductUrl($pr_id).'/categories/productdetail/'.$pr_id,array('escape'=>false,'class'=>"underline-link")); ?>
					</h4>
					
					
					<p class="used-from pad-tp">
						<?php if(!empty($minimum_price_value) && $minimum_price_value > 0 && $prodStock > 0) { ?>
							New from <span class="price larger-font"><strong><?php echo CURRENCY_SYMBOL.$format->money($minimum_price_value,2); ?></strong></span>
						<?php }?>
						<?php if(!empty($minimum_price_used) && $minimum_price_used > 0 && $prodStock > 0) { ?> 
							Used from <span class="price larger-font"><strong><?php echo CURRENCY_SYMBOL.$format->money($minimum_price_used,2);?></strong></span>
						<?php }?>
					</p>
					<p>
						RRP: <span class="gray-color">
								<?php if((!empty($minimum_price_value) && $minimum_price_value > 0 && $prodStock > 0)  || (!empty($minimum_price_used) && $minimum_price_used > 0 && $prodStock > 0)) { ?>
									<s>
									<?php if(!empty($product_rrp)) {
										echo CURRENCY_SYMBOL.$format->money($product_rrp,2);
									} else {
										echo '-';
									} ?>
									</s>
								<?php }else{?>
									<span class="price larger-font"><strong>
									<?php if(!empty($product_rrp)) {
										echo CURRENCY_SYMBOL.$format->money($product_rrp,2);
									} else {
										echo '-';
									} ?>
									</strong>
									</span>
								<?php }?>
						</span>
						<?php if(!empty($saving_perc) && (($minimum_price_value > 0) || (!empty($minimum_price_used) && $minimum_price_used > 0))) { ?> 
							| You save: 
							<span class="yellow"><strong><?php echo $format->money($saving,2);?> (<?php echo $format->money($saving_perc,2).'%'; ?>)</strong></span>
						<?php } ?>
					</p>
						<?php 
						if($prodStock > 0){
						?>
							<p><strong>In stock</strong> | Usually dispatched within 24 hours <?php echo $rating; ?></p>
							<p>Get it by <strong><?php echo $format->estimatedDeliveryDayDate($pr_id);?></strong> if you order in the next <span class="green-color"><strong><?php echo $format->remainingTime();?></strong></span> and choose express delivery.</p>
							<?php } else { ?>
							<p><strong>Temporarily out of stock -more expected soon</strong> | Usually dispatched within 24 hours <?php echo $rating; ?></p>
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
					<p class="rates">Eligible for <?php if(!empty($free_delivery)) { ?><strong>FREE</strong> Standard Shipping &amp;<?php }?> <?php echo $html->link('<span class="rate"><strong>Make me an Offer&trade;</strong></span>',"/offers/add/".$encodeOfferData,array('escape'=>false,'class'=>'rate mmao')); ?></p>
					<?php } ?>
				</div>
				<div class="clear"></div>
			</div>
			<?php $i++; } // foreach ens
		?>
		<!--Row1 Closed-->
		</div>
	</div>
	<!--Product Listings Widget Closed-->
	<!--Sorting Start-->
	<?php echo $this->element('product/paging_products_category'); ?>
</div>
<?php } ?>
<script type="text/javascript">
	function sort_list(sort_val){
		var product_sort = sort_val;
		var dept_id = '<?php echo $department_id;?>';
		var car_id = '<?php echo $selected_category;?>';
		var dept_url = '<?php echo $dept_url;?>';
		var urls= "<?php echo SITE_URL;?><?php echo $dept_url;?>/categories/viewproducts";
			if(car_id != ""){
				urls = urls+'/'+car_id;
			}
			if(dept_id != ""){
				urls = urls+'/'+dept_id;
			}
			if(product_sort != ""){
				urls = urls+'/'+product_sort;
			}
			//alert(urls);
		window.location.href = urls;
		return false;
	}
</script>