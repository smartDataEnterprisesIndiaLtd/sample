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
})

</script>
<?php if(!empty($products)) {
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
	$paging_limit = 10;
?>

<!--Sorting Start-->
<div class="sorting-widget">
	<div class="showing-widget">
	<?php /*if($this->params['paging'][$modelis]['page'] == 1){
		$from = 1;
		if($this->params['paging'][$modelis]['count'] == $this->params['paging'][$modelis]['current'])
			$to = $this->params['paging'][$modelis]['count'];
		else
			$to = $this->params['paging'][$modelis]['defaults']['limit'];
	} else{
		$from = ($this->params['paging'][$modelis]['page'] - 1) * ($this->params['paging'][$modelis]['defaults']['limit']) + 1;
		if($this->params['paging'][$modelis]['page'] == $this->params['paging'][$modelis]['pageCount']) {
			$to = $this->params['paging'][$modelis]['count'];
		} else {
			$to = ($this->params['paging'][$modelis]['page']) * ($this->params['paging'][$modelis]['defaults']['limit']);
		}
	}*/
	?> Showing <span id="from_id"></span> - <span id="to_id"></span> of <?php echo count($products);?> Products</div>
	<div class="sort-by">Sort by:
		<?php echo $form->select('Marketplace.sort',array('0'=>'Bestselling','created'=>'Relevence'),$sort,array('class'=>'select ', 'type'=>'select','onChange'=>'sort_list()'),'-- Select --'); ?>
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
		} $jkl++; ?>
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
				<p class="used-from pad-tp">New from <span class="price larger-font"><strong>&pound;12.99</strong></span> Used from <span class="price larger-font"><strong>&pound;2.99</strong></span></p>
				<p>RRP: <span class="gray-color"><s>£7.99</s></span> | You save: <span class="yellow"><strong>£7.04 (44%)</strong></span></p>
				<p><strong>In stock</strong> | Usually dispatched within 24 hours 
					<?php $rating = $common->displayProductRating($product['Product']['avg_rating'],$product['Product']['id']);
						echo $rating;
					?>
				<!--<span class="pad-rt">(<a href="#">604</a>)</span>--></p>
				<p>Get it by <strong><?php echo $format->estimatedDeliveryDayDate($product['Product']['id']);?></strong> if you order in the next <span class="green-color"><strong><?php echo $format->remainingTime();?></strong></span> and choose express delivery.</p>
				<p class="rates">Eligible for <strong>FREE</strong> Money Saver Delivery &amp; <span class="rate"><strong>Make me an offer&trade;</strong></span></p>
			</div>
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
<script type="text/javascript">
function sort_list(){
	jQuery('#MarketplaceSort1').val(jQuery('#MarketplaceSort').val());
	document.frmfilter.submit();
}
</script>