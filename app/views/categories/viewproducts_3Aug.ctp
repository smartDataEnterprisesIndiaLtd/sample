<?php echo $html->script('lib/prototype');?>
<!--- mid-content starts here  Content for layout -->

<?php
$url = array(
	$selected_category,
	'brands' 	=> $brands,	
	'reviews' 	=> $reviews,
	'pricerange'	=> $pricerange,
	'seller' 	=> $seller,
	'sortby' 	=> $sortby
	);
$paginator->options(array('url' => $url));
$add_url_string = "/brands:".$brands."/reviews:".$reviews."/pricerange:".$pricerange."/seller:".$seller."/sortby:".$sortby;

?>
<?php
echo $form->hidden('Search.product_customer_review',array('value'=>'','div'=>false ,'id'=>'product_customer_review'));
echo $form->hidden('Search.product_price_range',array('value'=>'','div'=>false ,'id'=>'product_price_range'));
echo $form->hidden('Search.see_allbrands',array('value'=>'','div'=>false, 'id'=>'see_all_brands'));
echo $form->hidden('Search.see_allsellers',array('value'=>'','div'=>false, 'id'=>'see_all_sellers'));
?>
<div id="product_listing_div" >
<?php  echo $this->element('view_cat_products_listing');?>
</div>
<!-- mid-content ends here  Content for layout -->