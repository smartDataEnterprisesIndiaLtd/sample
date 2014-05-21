<?php 
/*$add_url_string="/keyword:".$keyword;
if(empty($keyword)){
	$keyword = 'null';
}
$url = array(
	$seller_id,
	'keyword' =>$keyword,
	'to_price' =>$to_price,
	'from_price' =>$from_price,
	'brand' =>$brand_str,
	'rate' =>$rate,
	'sort' =>$sort,
	'department' =>$department_id,
	'category' => $category_id,
);

$paginator->options(array('update'=>'#abc',
	'evalScripts' => true,'url' => $url));*/
$logg_user_id =0;
$logg_user_id = $this->Session->read('User.id');
$this->set('logg_user_id',$logg_user_id);
if(!empty($logg_user_id)) {
	$fancy_width = 362;
	$fancy_height = 225;
} else{
	$fancy_width = 560;
	$fancy_height = 175;
}
?>
<style>
.nav{text-align:right; padding:10px 0px;border-top:1px #dadada solid; }
.nav a{display:inline-block; margin:0px 2px;}
.nav a:hover{text-decoration:underline;}
.nav a.highlight{color:#000000; font-weight:bold; text-decoration:none;}
</style>
<script type="text/javascript">
jQuery(document).ready(function(){
	
	
	jQuery("a.make-me-offer-link").fancybox({
		'autoScale' : true,
		'titlePosition': 'inside',
		'transitionIn' : 'none',
		'transitionOut' : 'none',
		'width' : <?php echo $fancy_width; ?>,
		'height' : <?php echo $fancy_height; ?>,
		'padding':0,'overlayColor':'#000000',
		'overlayOpacity':0.5,
		'opacity':	true,
		'transitionIn' : 'fade',
		'transitionOut' : 'fade',
		'type' : 'iframe',
		'hideOnOverlayClick': false,
		'autoDimensions': false,
		'onClosed': function() {
			//parent.location.reload(true);;
		}
	});
});
</script>
<?php if(!empty($seller_store)) {
	if($this->params['action'] == 'store2'){
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
	<div class="showing-widget">
		<?php if(!empty($results)){ ?>
			<?php
				$end_records = '';
				$start_records = '';
				if(!empty($results)){
					if(!empty($results['current_set'])) {
						$start_records = ($results['current_set'] - 1) * $view_size + 1;
						$end_records = $results['current_set'] * $view_size;
						if($results['current_set'] == $results['no_of_pages'])
							$end_records = $results['total_items'];
					}
				}
				?>
			
		<?php }?>
		
		Showing <span id="from_id"><?php echo $start_records;?> </span> - <span id="to_id"><?php echo $end_records;?></span> of <span id="total_records"><?php echo $results['total_items'];?> Products</span>
		<?php if(!empty($free_delivery_over)) {?>
			<span class="eligiblity">
				Eligible for <span class="red-color">Free Standard Delivery</span> when you spend over <?php echo CURRENCY_SYMBOL.$format->money($free_delivery_over,2);?></span>
			</span>
		<?php }?>
	</div>
	<div class="sort-by">
		<?php echo $form->create('Seller',array('action'=>'store/'.$seller_id,'method'=>'GET','name'=>'frmfilter','id'=>'frmfilter'));?>
		Sort by:
		<?php //echo $form->select('Seller.sort',array('bestselling'=>'Bestselling','created'=>'Relevence'),$sort,array('class'=>'select ', 'type'=>'select','onChange'=>'sort_list()'),'-- Select --'); ?>
		<?php   
			//echo $form->select('Product.sort',$this->Common->fhsortlist(),@$sort,array('class'=>'select ', 'type'=>'select','onChange'=>'sort_list()'),'Relevance');
			echo $form->select('Product.sort',$this->Common->fhsortlist(),@$sort_by,array('class'=>'textfield', 'type'=>'select','onChange'=>'sort_list(this.value)','empty'=>'Relevance'));
			echo $form->end() ;
		?>

	</div>
	<div class="clear"></div>
</div>
<!--Sorting Closed-->

<!--Product Listings Widget Start-->
<div class="products-listings-widget product123">
	<!--Left Widget Start-->
	<div class="product-listings-wdgt">
	<!--Search Products Start-->
		<!--Sorting Closed-->
		<?php
		if(!empty($from)){
			$i = $from;
		} else {
			$i = $start_records;
		}
			
		//gg/homepages/24/d161574838/htdocs/Beta/app/webroot/img/products/small/img_100_1307023519_100000007.jpg
		foreach($seller_store as $seller_store){
		?>
		<div class="pro-listing-row">
			<div class="pro-img">
				<?php
				$pr_id = $common->getProductId_Qccode($seller_store['secondid']);
				$pr_name = $seller_store['product_name'];
				if(!empty($seller_store['product_image'])){
					$image_path = WWW_ROOT.PATH_PRODUCT.'small/img_100_'.$seller_store['product_image'];
					if(!file_exists($image_path) ){
						$image_path = '/img/no_image_100.jpg';
					}else{
						$image_path = '/'.PATH_PRODUCT.'small/img_100_'.$seller_store['product_image'];
					}
				} else{
					$image_path = '/img/no_image_100.jpg.jpeg';
				}
				
				$new_value = 0;
				$product_rrp = 0;
				$free_delivery = "";
				$rating = "";
				
				$min_used_seller = "";
				$min_used_con = "";
				$minimum_price_used = "";
				
				$min_new_seller = "";
				$min_new_con = "";
				$minimum_price_value = "";
				
				if(key_exists('minimum_price_used',$seller_store)) {
					$min_used_seller = $seller_store['minimum_price_used_seller'];
					$min_used_con = $seller_store['condition_used'];
					$minimum_price_used = $seller_store['minimum_price_used'];
				}
					
				if(key_exists('minimum_price_value',$seller_store)) {
					$min_new_seller  = $seller_store['minimum_price_seller'];
					$min_new_con  = $seller_store['condition_new'];
					$minimum_price_value = $seller_store['minimum_price_value'];
				}
					echo $html->link($html->image($image_path ,array('alt'=>$pr_name,'title'=>$pr_name )),'/'.$this->Common->getProductUrl($pr_id).'/categories/productdetail/'.$pr_id,array('escape'=>false,'class'=>"underline-link"));
					
					
				?>
			</div>
			<div class="numric-widget" style="width:50px;!important"><?php echo $i;?>. </div>
			<div class="product-details-widget">
				<h4><?php echo $html->link('<strong>'.$pr_name.'</strong>','/'.$this->Common->getProductUrl($pr_id).'/categories/productdetail/'.$pr_id,array('escape'=>false,'class'=>"underline-link"));?></h4>
				<p class="used-from pad-tp">
					<?php
					if(!empty($minimum_price_value) || !empty($minimum_price_used)){
						if(!empty($min_new_con)){
							echo $conditions[$min_new_con];
						}elseif(!empty($min_used_con)){
							echo $conditions[$min_used_con];
						}
					}?>
					&nbsp; 
					<span class="price larger-font">
						<strong>
							<?php
								if(!empty($minimum_price_value)){
									echo CURRENCY_SYMBOL.$format->money($minimum_price_value,2);
								}elseif(!empty($minimum_price_used)){
									echo CURRENCY_SYMBOL.$format->money($minimum_price_used,2);
								}
							?>
						</strong>
					</span>
				</p>
				
				<?php
				
				$product_price = "";
					if(!empty($minimum_price_value)){
						$product_price = $minimum_price_value;
						$min_seller_id = $min_new_seller;
						$min_con_id = $min_new_con;
					}else{
						$product_price = $minimum_price_used;
						$min_seller_id = $min_used_seller;
						$min_con_id = $min_used_con;
					}
					
					$prodSellerInfo = $common->getProductSellerInfo($pr_id ,$min_seller_id, $min_con_id);
					$prodStock = $prodSellerInfo['ProductSeller']['quantity'];
					
					if($product_price < $seller_store['product_rrp']){
					$you_save = ($seller_store['product_rrp']-$product_price);
					if(empty($seller_store['product_rrp']))
						$seller_store['product_rrp'] = 1;
					$you_save_percentage = ($you_save/$seller_store['product_rrp']) * 100;
				?>
				<p>RRP:
				<span class="gray-color">
					<?php if($prodStock > 0 && !empty($seller_store['product_rrp'])){?>
						<s>
							<?php echo CURRENCY_SYMBOL.$format->money($seller_store['product_rrp'],2);?>
						</s>
					<?php }else{?>
							<?php echo CURRENCY_SYMBOL.$format->money($seller_store['product_rrp'],2);?>
					<?php }?>
				</span>
				<?php if($prodStock > 0 && !empty($you_save)){?>
				| You save: <span class="yellow"><strong><?php echo CURRENCY_SYMBOL.$format->money($you_save,2);?> (<?php echo $format->money($you_save_percentage,2);?>%)</strong></span><?php }?></p>
				<?php }?>
				<p>
				<?php if(!empty($prodStock)) { ?><strong>In stock</strong> | <?php }else{ ?><strong>Out of Stock</strong> | <?php }?>Usually dispatched within 24 hours 
					<span style="color:#003399;">
					<?php $rating = $common->displayProductRating($seller_store['avg_rating'],$pr_id);
						echo $rating;
					?>
					</span>
				</p>
				<p>Get it by <strong><?php echo $format->estimatedDeliveryDayDate($pr_id,$min_seller_id,$min_con_id);?></strong>
					<?php if(!empty($prodStock)) { ?>
						if you order in the next <span class="green-color"><strong><?php echo $format->remainingTime();?></strong></span> and choose express delivery.</p>
					<?php }?>
				<p class="rates"><?php $free_delivery = $this->Common->getProductFreeDelivery($min_seller_id,$product_price);
				
				$offerSerialize = array();
				
				$offerSerialize['p_id']  = $pr_id;
				$offerSerialize['s_id']  = $min_seller_id;
				$offerSerialize['c_id']  = $min_con_id;
				$offerSerialize['type']  = 'S';
				$encodeOfferData = base64_encode(serialize($offerSerialize));
				
				if(!empty($prodStock) && !empty($free_delivery)) { ?>
				
					Eligible for <strong>FREE</strong> Standard Shipping &
					<span class="rate">
					<?php
					echo $html->link('<strong style="color: #FF660B;">Make me an offer&trade;</strong>',"/offers/add/".$encodeOfferData, array('title'=>'make me offers','escape'=>false,'class'=>'make-me-offer-link'));?>
					<!--strong> Make me an offer&trade;</strong-->
					</span>
					
				<?php }elseif(!empty($prodStock)){?>
				
					Eligible for
					<span class="rate">
					<?php
					echo $html->link('<strong style="color: #FF660B;">Make me an offer&trade;</strong>',"/offers/add/".$encodeOfferData, array('title'=>'make me offers','escape'=>false,'class'=>'make-me-offer-link'));?>
					<!--strong> Make me an offer&trade;</strong-->
					</span>
					
				<?php }?>
				
				</p>
				
			</div>
			<div class="clear"></div>
		</div>
		<?php $i++;}?>
        </div>
</div>
<!--Search Products Closed-->
<?php echo $this->element('seller/paging_products_users_fh');?>
<!--<div class="search-paging  box-margin-right" id="pagingli"><?php //echo $paginator->numbers(); ?></div>-->
<?php } else { ?>
	<div class="search-result-pro-widget box-margin-right" style="min-height:730px;">
		<div class="sortng-wdt" style ="border:none">
			<p align="center"><span class="larger-fnt"><strong>No record found.</strong></p>
			<div class="clear"></div>
		</div>
	</div>
<?php } ?>

<!--Search Results Closed-->
<script type="text/javascript">
function sort_list(){
	jQuery('#SellerSort1').val(jQuery('#SellerSort').val());
	document.frmfilter.submit();
}
jQuery(document).ready(function(){

jQuery('#pagingli span a').click(function(){
	var ajax_url= jQuery(this).attr('href');
	jQuery.ajax({
		url: ajax_url,
		success: function(msg){
		jQuery('div#abc').html(msg);
  	}
	});
	return false;
	
	});
});
</script>