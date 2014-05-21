<script defer="defer" type="text/javascript" src="/js/lib/prototype.js"></script>
<?php $sortByArr = array('sale'=>'Bestselling', 'date'=>'Relevence');
//echo $javascript->link(array('lib/prototype'),false);

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
<script  defer="defer" language="JavaScript">

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


<?php //echo $this->element('product/showingwidget_products_users_fh'); ?>
<!--Product Listings Widget Start-->
<div class="products-listings-widget">
<!--Left Widget Start-->
<div class="product-listings-wdgt">
		<?php
		if(!empty($results))
			$i = $results['start_index']+1;
		else
			$i =1;
		
		$jkl = 0;
		if(!empty($search_result)) {
		foreach($search_result as $search_result){
		?>
		<!--Row1 Start-->
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
				echo $html->link($html->image($image_path ,array('height'=>'69','alt'=>"")),'/'.$this->Common->getProductUrl($pr_id).'/categories/productdetail/'.$pr_id,array('escape'=>false,'class'=>"underline-link")); 
				?>
                        </div>
                        <div class="product-details-widget">
                          <h4 class="lstprdctname">
                           <?php echo $html->link('<strong>'.$search_result['product_name'].'</strong>','/'.$this->Common->getProductUrl($pr_id).'/categories/productdetail/'.$pr_id,array('escape'=>false,'class'=>"underline-link"));?></h4>
                           <p class="font11">
				<?php
					$new_value = 0;
					$product_rrp = 0;
					$minimum_price_used = 0;$minimum_price_value = 0;
						
					if(key_exists('minimum_price_value',$search_result) && $search_result['minimum_price_value'] > 0) {
						$new_value = $search_result['minimum_price_value'];
						//echo 'New from <span class="price larger-font"><strong>'.CURRENCY_SYMBOL.$format->money($search_result['minimum_price_value'],2).'</strong></span> ';
						$min_new_seller  = $search_result['minimum_price_seller'];
						$min_new_con  = $search_result['condition_new'];
						$minimum_price_value = $search_result['minimum_price_value'];
					}
						
					if(key_exists('minimum_price_used',$search_result) && $search_result['minimum_price_used'] > 0) {
						//echo ' Used from <span class="price larger-font"><strong>'.CURRENCY_SYMBOL.$format->money($search_result['minimum_price_used'],2).'</strong></span>&nbsp;';
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
							
				?>
				
				<?php //Added on April 27
				//Ends here
				$prodStock = '';
				if(!empty($pr_id) && !empty($min_seller_id) && !empty($min_con_id)){
					$prodSellerInfo = $common->getSellerProductStock($min_seller_id,$pr_id, $min_con_id);
					$prodStock = $prodSellerInfo['ProductSeller']['quantity'];
				}
				if($prodStock > 0){ ?>
				
				
				RRP: 
					<span class="lgtorngcolor">
						<s>
							<?php if(!empty($product_rrp)) {
								echo CURRENCY_SYMBOL.$format->money($product_rrp,2);
							} else {
								echo '-';
							} ?>
						</s>
					</span> 
                           	| You save: 
                           	<span class="lgtorngcolor">
                           		<?php echo CURRENCY_SYMBOL.$format->money(@$total_save,2); ?> (<?php echo $format->money(@$saving_percentage,2); ?>%)
                           	</span>
                           
                    <?php } else { ?>
				RRP:
					<span class="lgtorngcolor">
							<?php if(!empty($product_rrp)) {
								echo CURRENCY_SYMBOL.$format->money($product_rrp,2);
							} else {
								echo '-';
							} ?>
					</span> 
                           	
                 <?php } ?>
				</p>
				
				<?php 
				if(!empty($pr_id) && !empty($min_seller_id) && !empty($min_con_id)){
				
					$prodSellerInfo = $common->getSellerProductStock($min_seller_id,$pr_id, $min_con_id);
					$prodStock = $prodSellerInfo['ProductSeller']['quantity'];
					if($prodStock > 0){ ?>
						<span class="green-color">In stock</span> | Usually dispatched within 24 hours 
						<p class="used-from pad-tp">New from 
						<span class="price larger-font"><strong><?php echo CURRENCY_SYMBOL.$format->money(@$new_value,2);?></strong></span> 
                           			Used from <span class="price larger-font">
                           			<strong><?php echo CURRENCY_SYMBOL.$format->money(@$used_value,2);?></strong></span></p>
                           
					<?php } else { ?>
						<p class="redcolor">Sorry, temporarily out of stock</p>
					<?php }
				}else { ?>
					<p class="redcolor">Sorry, temporarily out of stock</p>
				<?php } ?>
					
					
			</p>
                           <p><?php 	$rating = $common->displayProductRatingMobile($search_result['avg_rating'],@$pr_id); 
					echo $rating;?></p>
                        </div>
                        <div class="clear"></div>
                    </div>
		<!--Row1 Closed-->
		
		<?php }?>
		 
	</div>
<!--Left Widget Closed-->
</div>
<!--Product Listings Widget Closed-->
	<section class="pagiarea">
		<!--Showing Products Starts-->
		<?php echo $this->element('mobile/product/paging_products_users_fh');?>
		<!--Pagination Closed-->
	</section>

<?php } else { ?>



<div class="search-result-pro-widget box-margin-right" style="min-height:1455px;">
	<div class="sortng-wdt" style ="border:none">
		<p align="center"><span class="larger-fnt"><strong>No record found.</strong></p>
		<div class="clear"></div>
	</div>
</div>
<?php }?>
<!--Search Results Closed-->
