<?php 
/*echo  $javascript->link(array('mobile/slider/jquery-1.4.2.min','mobile/slider/jquery.jcarousel.min'));
echo $html->css('slider/style');
echo $html->css('slider/skin');
if(!empty($selected_department)){
    $department_id = $selected_department;
}else{
    $department_id = "";
}
$most_viewed_products=$this->requestAction("/homes/mostViewedProducts/".$department_id);*/

?>
<style>
.jcarousel-skin-tango .jcarousel-container-horizontal {
    width: 72%;
}

.jcarousel-skin-tango .jcarousel-clip-horizontal {
    width: 100%;
    margin:0px auto;
    min-height:144px;
    height:auto;	
    /*min-height:185px;*/
}

</style>


<!--Seller Banner Starts-->
<!--section class="bannerseller" style="padding-top:0px;">
<h4>Best Sellers</h4>
<div id="wrap">
<ul id="mycarousel" class="jcarousel-skin-tango"-->
    <?php
   /* if(!empty($most_viewed_products)){
	foreach($most_viewed_products as $m_v_product){?>
		<li style="height:auto;display: none;">
				<span class="prdctimg">
				    <?php
				    $product_image = '';
				    $pr_id = '';
				    $product_name = '';
				    $product_rrp = '';
				    $product_new_price = '';
				    $product_used_price = '';
				    
				    $product_image = $m_v_product['Product']['product_image'];
				    $pr_id = $m_v_product['Product']['id'];
				    $product_name = $m_v_product['Product']['product_name'];
				    $product_rrp = $m_v_product['Product']['product_rrp'];
				    $product_new_price = $m_v_product['Product']['minimum_price_value'];
				    $product_used_price = $m_v_product['Product']['minimum_price_used'];
				    
				    $image_path = WWW_ROOT.PATH_PRODUCT."/small/img_50_".$product_image;
						if(!file_exists($image_path) ){
							$image_path = '/img/no_image_50.jpg';
						}else{
							$image_path = '/'.PATH_PRODUCT.'small/img_50_'.$product_image;
						}
				    echo $html->link($html->image($image_path ,array('alt'=>$product_name,'title'=>$product_name, 'height'=>'40')),'/'.$this->Common->getProductUrl($pr_id).'/categories/productdetail/'.$pr_id,array('escape'=>false,'class'=>'underline-link'));?>
				</span>
				<span class="prdctname">
				    <?php
					echo $html->link($product_name,'/'.$this->Common->getProductUrl($pr_id).'/categories/productdetail/'.$pr_id,array('escape'=>false,'class'=>'underline-link'));
				    ?>
				</span>
				<?php if((!empty($product_new_price) && $product_new_price > 0) || (!empty($product_used_price) && $product_used_price > 0)){?>
					<span class="priceold">RRP: <?php echo CURRENCY_SYMBOL.$format->money($product_rrp,2); ?></span>
				<?php }else{?>
					<span class="pricenow">NOW: <?php echo CURRENCY_SYMBOL.$format->money($product_rrp,2); ?></span>
				<?php }?>
				<?php if((!empty($product_new_price) && $product_new_price > 0) || (!empty($product_used_price) && $product_used_price > 0)){
					if(!empty($product_new_price) && $product_new_price > 0){
					    $price = $product_new_price;
					}else{
					    $price = $product_used_price;
					}?>
					<span class="pricenow">NOW: <?php echo CURRENCY_SYMBOL.$format->money($price,2); ?></span>
				<?php }?>
				
		</li>
<?php }}*/?>
<!--/ul>
</div>
 </section>
<script type="text/javascript">
jQuery(document).ready(function() {
    $("#mycarousel li").show();
    jQuery('#mycarousel').jcarousel({
        visible: 3
    });
});
</script-->
          <!--Seller Banner End-->
