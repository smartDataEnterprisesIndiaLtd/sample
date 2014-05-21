<?php if(!empty($display_error_msg)){
$add_url_string="/keyword:".$keyword;
if(empty($keyword)){
	$keyword = 'null';
}
$url = array(
	'action'=>$this->params['action'],
	'controller'=>'products',
	'keyword' =>$keyword,
	'to_price' =>$to_price,
	'from_price' =>$from_price,
	'brand' =>$brand_str,
	'rate' =>$rate,
	'sort' =>$sort,
	'department' =>$department_id,
	'category' => $category_id,
);

//$paginator->options(array('update'=>'listing','url' => $url));
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
.nav{
	text-align:right; padding:10px 0px;border-top:1px #dadada solid;
}
.nav a{display:inline-block; margin:0px 2px;}
.nav a:hover{text-decoration:underline;}

.nav a.highlight{color:#000000; font-weight:bold; text-decoration:none;}
</style>
<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery('div.product123').pager('div.div_paging', {
	  navId: 'nav2',
	  height: '15em'
	});
	
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
})
	
	
		

</script>
<?php if(!empty($products)) {
	if($this->params['action'] == 'store'){
		$right_class = ''; ?>
		<style type="text/css">
		.form-textfield {
			width:90px;
		}
		</style>
	<?php } else{
		$right_class = 'box-margin-right';
	}
	$paging_limit = 10;
?>
<span id="recordsperpage" style="display:none"><?php echo $paging_limit;?></span>
<!--Sorting Start-->
<div class="sorting-widget">
	<div class="showing-widget">
		Showing <span id="from_id"> </span> - <span id="to_id"> </span> of <span id="total_records"><?php echo count($products);?></span> <?php if(!empty($free_delivery_over)) {?>
		<span class="eligiblity">
			Products Eligible for <span class="red-color">Free Standard Delivery</span> when you spend over <?php echo CURRENCY_SYMBOL.$format->money($free_delivery_over,2);?></span>
		</span>
		<?php }?>
	</div>
	<div class="sort-by">Sort by:
		<?php echo $form->select('Seller.sort',array('bestselling'=>'Bestselling','created'=>'Relevence'),$sort,array('class'=>'select ', 'type'=>'select','onChange'=>'sort_list()'),'-- Select --'); ?>
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
		/*$i = $from;*/
			$i = 1;$jkl = 0;
		
		foreach($products as $product){
		//echo $jkl % $paging_limit.'<br>';
		if($jkl == 0){
			e('<div class="div_paging">');
		}elseif($jkl % $paging_limit == 0){
			e('</div><div class="div_paging">');
		} $jkl++;
		
		
		
		 //pr($product);
		?>
		<!--Row1 Start-->
		
			
		<!--Row1 Closed-->
		<div class="pro-listing-row">
			<div class="pro-img">
				<?php
				if($product['Product']['product_image'] == 'no_image.gif' || $product['Product']['product_image'] == 'no_image.jpeg'){
					$image_path = '/img/no_image.jpeg';
				} else{
					$image_path = WWW_ROOT.PATH_PRODUCT.'small/img_100_'.$product['Product']['product_image'];
					
					if(!file_exists($image_path) ){
						$image_path = '/img/no_image_100.jpg';
					}else{
						$image_path = '/'.PATH_PRODUCT.'small/img_100_'.$product['Product']['product_image'];
					}
				}
				echo $html->image($image_path ,array('alt'=>"" )); ?>
			</div>
			<div class="numric-widget"><?php echo $i;?>. </div>
			<div class="product-details-widget">
				<h4><?php echo $html->link('<strong>'.$product['Product']['product_name'].'</strong>','/categories/productdetail/'.$product['Product']['id'],array('escape'=>false,'class'=>"underline-link"));?></h4>
				<p class="used-from pad-tp"><?php echo $conditions[$product['ProductSeller']['condition_id']];?>&nbsp; <span class="price larger-font"><strong><?php echo '&pound;'.$format->money($product['ProductSeller']['price'],2);?></strong></span></p>
				<p>RRP: <span class="gray-color"><s><?php if(!empty($product['Product']['product_rrp'])) echo CURRENCY_SYMBOL.$format->money($product['Product']['product_rrp'],2);?></s></span><?php
				if($product['ProductSeller']['price'] < $product['Product']['product_rrp']){
				$you_save = $product['Product']['product_rrp']-$product['ProductSeller']['price'];
				if(empty($product['Product']['product_rrp']))
					$product['Product']['product_rrp'] = 1;
				$you_save_percentage = ($you_save/$product['Product']['product_rrp']) * 100;
				?> | You save: <span class="yellow"><strong><?php echo CURRENCY_SYMBOL.$format->money($you_save,2);?> (<?php echo $format->money($you_save_percentage,2);?>%)</strong></span><?php }?></p>
				<p><?php if(!empty($product['ProductSeller']['quantity'])) { ?><strong>In stock</strong> | <?php }?>Usually dispatched within 24 hours 
					<?php $rating = $common->displayProductRating($product['Product']['avg_rating'],$product['Product']['id']);
						echo $rating;
					?>
				<!--<span class="pad-rt">(<a href="#">604</a>)</span>--></p>
				<p>Get it by <strong><?php echo $format->estimatedDeliveryDayDate($product['Product']['id'],$product['ProductSeller']['seller_id'],$product['ProductSeller']['condition_id']);?></strong> if you order in the next <span class="green-color"><strong><?php echo $format->remainingTime();?></strong></span> and choose express delivery.</p>
				<p class="rates"><?php if(!empty($product['UserSummary']['SellerSummary']['free_delivery'])){ ?>
				Eligible for <strong>FREE</strong> Money Saver Delivery &amp; <?php }?>
				<span class="rate">
				<?php
				$offerSerialize = array();
				
				$offerSerialize['p_id']  = $product['ProductSeller']['product_id'];
				$offerSerialize['s_id']  = $product['ProductSeller']['seller_id'];
				$offerSerialize['c_id']  = $product['ProductSeller']['condition_id'];
				$offerSerialize['type']  = 'S';
				$encodeOfferData = base64_encode(serialize($offerSerialize));
				
				 echo $html->link('<strong>Make me an offer&trade;</strong>',"/offers/add/".$encodeOfferData, array('title'=>'make me offers','escape'=>false,'class'=>'make-me-offer-link'));?>
				</span></p>
				
			</div>
			<div class="clear"></div>
		</div>
		<?php 
			//$remain = ($jkl-1) % $paging_limit;
			//echo $remain.'<hr>';
		/*if(($jkl-1) % $paging_limit!=0){
			e('</span>');
		}*/ ?>
		<!--Row1 Closed-->
		<?php $i++; }?>
        </div>
</div>
<!--Search Products Closed-->
<?php } else { ?>
	<div class="search-result-pro-widget box-margin-right" style="min-height:730px;">
		<div class="sortng-wdt" style ="border:none">
			<p align="center"><span class="larger-fnt"><strong>No record found.</strong></p>
			<div class="clear"></div>
		</div>
	</div>
<?php }
if(!empty($products)) {
	//echo $this->element('product/paging_users');
} else { ?>
	<div class="search-paging  box-margin-right"> </div>
<?php } ?>

<?php }?>
<!--Search Results Closed-->
<script type="text/javascript">/*
jQuery('#SellerSort').val(0);*/
// jQuery('#SellerSort1').val(jQuery('#SellerSort').val());


function sort_list(){
	jQuery('#SellerSort1').val(jQuery('#SellerSort').val());
	document.frmfilter.submit();
}
</script>