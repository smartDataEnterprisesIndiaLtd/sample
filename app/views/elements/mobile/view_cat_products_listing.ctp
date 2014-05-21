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
 <section class="maincont">
	<!--Sub Categories Starts-->
               <nav class="subnav">
                <section class="subcategry">
                <?php echo $html->link('Home',SITE_URL,array('escape'=>false,'class'=>'first'));?><span class="bread_sep">&gt;</span>
		<?php echo $breadcrumb_string;?>
                </section>
             </nav>
	<!--Sub Categories End-->
	<div class="mid-content">
		<h4 class="gr-bg-head"><span><?php  echo $cat_name_m;?></span></h4>
			
			<p style="padding:15px 5px">We're sorry, there are currently no items available in this category</p>
	</div>
	</section>
<?php } else { ?>
<!--BreadCrumb Starts-->
             <!--Main Content Starts--->
             <section class="maincont">
          <!--Sub Categories Starts-->
               <nav class="subnav">
		<section class="subcategry">
                <?php echo $html->link('Home',SITE_URL,array('escape'=>false,'class'=>'first'));?><span class="bread_sep">&gt;</span>
		<?php echo $breadcrumb_string;?>
		</section>
             </nav>
<!--Sub Categories End-->
<!--mid Content Start-->
               <div class="mid-content">
                    <!--Sorting Start-->
                    <div class="sorting-widget">
                         <?php 	echo $this->element('mobile/product/showingwidget_products_users_fh'); ?>
                        <div class="clear"></div>
                    </div>
                    <!--Sorting Closed-->
                    <!--Product Listings Widget Start-->
                    <div class="products-listings-widget">
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
			$i = $start_records;
			foreach($cat_items  as $cat_item){
					
				$minimum_price_used = "";
				$min_used_seller  = "";
				$min_used_con  = "";
				$minimum_price_value = "";
				$min_new_seller  = "";
				$min_new_con  = "";
				
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
						
					$rating = $common->displayProductRatingMobile($pr_avg_rate,$pr_id);
						
			?>
                        
                            <div class="pro-listing-row">
                            <div class="pro-img">
                            		<?php 
					echo $html->link($html->image($image_path , array("alt" => $pr_name, "border" => "0","height"=>'69')),'/'.$this->Common->getProductUrl($pr_id).'/categories/productdetail/'.$pr_id,array('escape'=>false,'class'=>"underline-link")); ?>
					</div>
                            <div class="product-details-widget">
                              <h4 class="lstprdctname">
                              <?php echo $html->link($pr_name,'/'.$this->Common->getProductUrl($pr_id).'/categories/productdetail/'.$pr_id,array('escape'=>false,'class'=>"underline-link")); ?>
                              </h4>
                              <?php if(!empty($pr_id) && !empty($min_seller_id) && !empty($min_con_id)){
										$prodSellerInfo = $common->getProductSellerInfo($pr_id ,$min_seller_id, $min_con_id);
										$prodStock = $prodSellerInfo['ProductSeller']['quantity']; 
									}?>
										
                               <p class="font11">RRP: <span class="font11">
                               
                               <?php if(isset($prodStock) && !empty($prodStock)){
					?>
					   <s class="lgtorngcolor"><?php if(!empty($product_rrp)) {
					echo CURRENCY_SYMBOL.$format->money($product_rrp,2);
					} else {
						echo '-';
					} ?></s>
				<?php } else { ?>
							
						 <span class="lgtorngcolor"><?php if(!empty($product_rrp)) {
						echo CURRENCY_SYMBOL.$format->money($product_rrp,2);
					} else {
						echo '-';
					} ?></s>
				<?php } ?>
				<?php if(!empty($saving_perc) && !empty($prodStock)) { ?>
					| You save: 
					<span class="lgtorngcolor"><?php echo CURRENCY_SYMBOL.$format->money($saving,2);?> (<?php echo $format->money($saving_perc,2).'%'; ?>)</span>
				<?php } ?>
				</p>                             
                              <?php if(!empty($pr_id) && !empty($min_seller_id) && !empty($min_con_id)){
						$prodSellerInfo = $common->getProductSellerInfo($pr_id ,$min_seller_id, $min_con_id);
						$prodStock = $prodSellerInfo['ProductSeller']['quantity']; 
						if($prodStock > 0){
					?>
					<p><span class="lgtgreen">In stock</span> | Usually dispatched within 24 hours</p>
					<?php } else { ?>
					<p><span class="redcolor">Sorry, temporarily out of stock</span></p>
					<?php } }else { ?>
					<p><span class="redcolor">Sorry, temporarily out of stock</span></p>
					<?php } ?>
				
				<p class="used-from pad-tp">
						<?php if(!empty($minimum_price_value)) { ?>
							New from <span class="price larger-font"><strong><?php echo CURRENCY_SYMBOL.$format->money($minimum_price_value,2); ?></strong></span>
						<?php }?>
						<?php if(!empty($minimum_price_used)) { ?> 
							Used from <span class="price larger-font"><strong><?php echo CURRENCY_SYMBOL.$format->money($minimum_price_used,2);?></strong></span>
						<?php }?>
					</p>
                               <p><?php echo $rating; ?></p>
                              <!--<span class="starnb pad-rt">(<a href="#">604</a>)</span>-->
                            </div>
                            <div class="clear"></div>
                        </div>
                        <!--Row1 Closed-->
                        
                        <?php $i++; }?>
                    </div>
                        <!--Left Widget Closed-->
            	    </div>
                	<!--Product Listings Widget Closed-->
               		<!--Bottom Pagination Area Starts-->
                	<section class="pagiarea">
                	<?php echo $this->element('mobile/product/paging_products_category'); ?>
                	</section>
                	<!--Bottom Pagination Area End-->
	<?php } ?>
               		<!--For Going Back To Previous Page-->
			
			<section class="backbtnbox">
                  <input type="button" value="Back" class="greenbtn" onclick="history.go(-1)"/>
               	<!--<section class="backbtnbox">
               	 <?php echo $form->button('Back',array('value'=>'Back' , 'label'=>false,'div'=>false, 'escape'=>false,'class'=>'greenbtn' , 'ONCLICK'=>'history.go(-1)'));?>-->
               	 
             	</section>
                	<!--For Going Back To Previous End-->  
                	 
                	<!--Navigation Starts-->
                	<nav class="nav">
				<ul class="maincategory yellowlist">
					<?php echo $this->element('mobile/nav_footer');?> 
				</ul>
                	</nav>        
               		<!--Navigation End-->
             </div>
               <!--mid Content Closed-->
          </section>
          <!--Main Content End--->