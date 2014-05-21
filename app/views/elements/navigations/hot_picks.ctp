<?php

//pr($hm_products);
if(!empty($hm_products['HomepageProduct']['hot_pick'])){
	
	//$hotPicProduct = $hotPicProduct;
	if(!empty($hotPicProduct)){
		if($hotPicProduct['Product']['product_image'] == 'no_image.gif' || $hotPicProduct['Product']['product_image'] == 'no_image.jpeg'){
			$image_path = '/img/no_image.jpeg';
		} else{
			$image_path = WWW_ROOT.PATH_PRODUCT.'small/img_50_'.$hotPicProduct['Product']['product_image'];
				if(!file_exists($image_path) ){
					$image_path = '/img/no_image_50.jpg';
				}else{
					$image_path = '/'.PATH_PRODUCT.'small/img_50_'.$hotPicProduct['Product']['product_image'];
				}
		}
	$rrp_price = $hotPicProduct['Product']['product_rrp'];
	
	if($hotPicProduct['Product']['minimum_price_value'] > 0){
		$offerPrice = $hotPicProduct['Product']['minimum_price_value'];
		$deliveryCharges = $common->getDeliveryCharges($hotPicProduct['Product']['id'],$hotPicProduct['Product']['minimum_price_seller'], $hotPicProduct['Product']['new_condition_id'] );
	}elseif($hotPicProduct['Product']['minimum_price_used'] > 0){
		$offerPrice = $hotPicProduct['Product']['minimum_price_used'];
		$deliveryCharges = $common->getDeliveryCharges($hotPicProduct['Product']['id'],$hotPicProduct['Product']['minimum_price_used_seller'], $hotPicProduct['Product']['used_condition_id']);
	}else{
		$offerPrice = $hotPicProduct['Product']['product_rrp'];
		$deliveryCharges = '0.00';
	}
	
	
	
	
	if($deliveryCharges != ''){
		if($deliveryCharges != '0.00'){
			$delivery = "+&nbsp;".CURRENCY_SYMBOL.$deliveryCharges;
		}else{
			$delivery = ' + Free ';
		}
	}else{
		$delivery = '';
		
	}
	
	if($rrp_price > $offerPrice ){
			$saving = $format->money(($rrp_price - $offerPrice),2) ;
		}else{
			$saving = '';
	}
	
?>
	<!--Hot Pick Start-->
	<div class="side-content">
		<h4 class="gray-bg-head"><span>Hot Pick</span></h4>
		<div class="gray-fade-bg-box padding">
			<p><?php 
			$product_url_hot_pick=str_replace(array(' '), array('-'), html_entity_decode($hotPicProduct['Product']['product_name'], ENT_NOQUOTES, 'UTF-8'));
			echo $html->link("<strong>".$hotPicProduct['Product']['product_name']."</strong>","/".$product_url_hot_pick."/categories/productdetail/".$hotPicProduct['Product']['id'],array('escape'=>false));?></p>
			<ul class="hot-pick">
				<li class="hot-pick-image"><?php 
				echo $html->link($html->image($image_path,array('alt'=>$hotPicProduct['Product']['product_name'],'title'=>$hotPicProduct['Product']['product_name'])), "/".$product_url_hot_pick."/categories/productdetail/".$hotPicProduct['Product']['id'],array('escape'=>false) );?></li>
				<li class="hot-pick-content"><p class="rate"><strong>
					<?php echo CURRENCY_SYMBOL,number_format($offerPrice,2); ?></strong>
					<strong><?php echo $delivery ;?></strong> <strong>delivery</strong></p>
				 <p>RRP<br/>
			<span class="yellow"><s><strong><?php echo CURRENCY_SYMBOL; echo $rrp_price;?></strong></s></span></p>
		       <?php if(!empty($saving) ){ ?> <p>You save:<br/>
			<span class="yellow"><strong><?php echo CURRENCY_SYMBOL; echo $saving;?></strong></span></p>
				<?php } ?>
				</li>
			</ul>
			<div class="clear"></div>
			<!--<p align="right"><?php //echo $html->link("<strong>View all</strong>","#",array('escape'=>false,'class'=>"view-all"));?></p>-->
		</div>
	</div>
	<!--Hot Pick Closed-->
	<?php }

}

?>



