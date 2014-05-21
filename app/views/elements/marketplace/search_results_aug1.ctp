<?php if(!empty($display_error_msg)){
if($this->params['action'] != 'search_product') {
	if(!empty($action)){
		$this->params['action']=$action;
	}
}
$add_url_string="/keyword:".$keyword;
if(empty($sort)){
$sort = '';
}
$url = array(
	'action'=>$this->params['action'],
	'controller'=>'marketplaces',
	'keyword' =>$keyword,
	'to_price' =>$to_price,
	'from_price' =>$from_price,
	'brand' =>$brand_str,
	'rate' =>$rate,
	'sort' =>$sort,
);

$paginator->options(array('update'=>'listing','url' => $url));

?>
<!--Search Results Start-->
<div class="search-results-widget">
	<?php if(!empty($products)) {
		echo $this->element('marketplace/paging');
	} else { ?>
		<div class="search-paging  box-margin-right"> </div>
	<?php } ?>
	<!--Left Start-->
	<div class="left-content">
		<?php echo $this->element('marketplace/filter_products');?>
	</div>
	<!--Left Closed-->
	<!--Search Products Start-->
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
	?>
	<div class="search-result-pro-widget <?php echo $right_class;?>" style="min-height:730px;">
		<!--Sorting Start-->
		<div class="sortng-wdt" style ="margin-bottom:10px">
			<div style="float:left;width:83%"><p><span class="larger-fnt"><strong>Search Results</strong><?php if(!empty($keyword)) { ?> for <?php echo $html->image('gray-fade-arrow.gif' ,array('alt'=>"",'width'=>'8','height'=>'9' ));?> <strong>"<?php echo $keyword;?>"</strong><?php }?></span></p></div>
			<!--<ul class="margin-top">
				<li class="float-left">Showing 1-24 of 397 Products</li>
			</ul>-->
			<?php
				if($this->params['action'] == 'search_product') { ?>
					<div><p><span >Sort by <?php echo $form->select('Marketplace.sort',array('0'=>'Bestselling','created'=>'Relevence'),$sort,array('class'=>'form-textfield ', 'type'=>'select','onChange'=>'sort_list()'),'-- Select --'); ?></span></p></div>
				<?php }
			?>
			<div class="clear"></div>
		</div>
		<!--Sorting Closed-->
		<?php if($this->params['paging'][$modelis]['page'] == 1){
			$start_from = 1;
		} else{
			$start_from = ($this->params['paging'][$modelis]['page'] - 1) * ($this->params['paging'][$modelis]['defaults']['limit']) + 1;
		}
		$i = $start_from;
		
		foreach($products as $product){?>
		<!--Row1 Start-->
		<div class="search-pro-row-widget" style ="margin:10px 0">
			<div class="search-pro-img">
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
				echo $html->image($image_path ,array('alt'=>"" ));
				unset($image_path);
				?>
			</div>
			<div class="numric-widget mrgin-tp"><?php echo $i;?>. </div>
			<div class="product-details-widget mrgin-tp">
				<p><?php echo $html->link('<strong>'.$product['Product']['product_name'].'</strong>','/categories/productdetail/'.$product['Product']['id'],array('escape'=>false,'class'=>"underline-link"));?></p>
				<p><strong>Model # <?php echo $product['Product']['model_number'];?></strong></p>
				<p><?php if(in_array($product['Product']['id'],$product_seller_listed)) {?>
					<span style="color:#888888">Already listed</span>
				<?php } else {
					echo $html->link('<span>Sell yours here</span>','/marketplaces/create_listing/'.$product['Product']['id'],array('escape'=>false,'class'=>"ornge-btn"));
				}?></p>
			</div>
		</div>
		<!--Row1 Closed-->
		<?php $i++; }?>
        </div>
        <!--Search Products Closed-->
	
	<?php } else { ?>
	<div class="search-result-pro-widget box-margin-right" style="min-height:730px;">
		<div class="sortng-wdt" style ="border:none; margin-bottom:10px">
			<p align="center"><span class="larger-fnt"><strong>No record found.</strong></p>
			<div class="clear"></div>
		</div>
	</div>
	<?php } ?>
	<?php if(!empty($products)) { ?>
		<div class="clear"></div>
		<?php echo $this->element('marketplace/paging');
	} else { ?>
		<div class="search-paging  box-margin-right"> </div>
	<?php } ?>
</div>
<?php } ?>
<!--Search Results Closed-->
<script type="text/javascript">
function sort_list(){
	jQuery('#MarketplaceSort1').val(jQuery('#MarketplaceSort').val());
	document.frmfilter.submit();
}
</script>