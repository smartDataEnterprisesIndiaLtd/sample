<?php if(!empty($pro_info) ) { ?><div class="left-content">
<!--Browse Start-->
<div class="side-content">
<h4 class="gray-head-top"><?php echo $html->link('Back to Product Page','/categories/productdetail/'.$pro_info['Product']['id'],array('escape'=>false,'class'=>'underline-link arrw-lft'));?></h4>
<div class="gray-fade-bg-box sml-pad background-none">
	<ul class="buying-choices">
		<li style="border: medium none ;">
			<p class="margin-bottom">
				<?php
				if($pro_info['Product']['product_image'] == 'no_image.gif' || $pro_info['Product']['product_image'] == 'no_image.jpeg'){
					$image_path = '/img/no_image.jpeg';
				} else{
					$image_path = WWW_ROOT.PATH_PRODUCT.'small/img_100_'.$pro_info['Product']['product_image'];
					if(!file_exists($image_path) ){
						$image_path = '/img/no_image_100.jpg';
					}else{
						$image_path = '/'.PATH_PRODUCT.'small/img_100_'.$pro_info['Product']['product_image'];
					}
				}
				echo $html->link($html->image($image_path,array('alt'=>$pro_info['Product']['product_name'], 'title'=>$pro_info['Product']['product_name'])),'/'.$this->Common->getProductUrl($pro_info['Product']['id']).'/categories/productdetail/'.$pro_info['Product']['id']/*array('controller'=>'categories','action'=>'productdetail',$pro_info['Product']['id'])*/,array('escape'=>false));
				
				//echo $html->image($image_path,array('alt'=>""));?>
			</p>
			<?php
				$delivery_amount = 0;
				if($pro_seller_info['UserSummary']['SellerSummary']['free_delivery'] == '1'){	
					if($pro_seller_info['UserSummary']['SellerSummary']['threshold_order_value'] <= $pro_seller_info['ProductSeller']['price']){
						$delivery_amount = 0;
					}else{
						$delivery_amount = $pro_seller_info['ProductSeller']['standard_delivery_price'];
					}
				}else{
					$delivery_amount = $pro_seller_info['ProductSeller']['standard_delivery_price'];
				}
				
				/*else{
					if(!empty($pro_seller_info['ProductSeller']['express_delivery'])){
						$delivery_amount = $pro_seller_info['ProductSeller']['express_delivery_price'];
					} else{
						//$delivery_amount = $pro_seller_info['ProductSeller']['standard_delivery_price'];
						$delivery_amount = 0;
					}
				}*/
			//print_r($pro_seller_info);
			
			?>
			<?php if(!empty($pro_seller_info)){?>
			<p><span class="price lrgr-fnt"><strong><?php if(!empty($pro_seller_info['ProductSeller']['price'])) echo CURRENCY_SYMBOL.$format->money($pro_seller_info['ProductSeller']['price'],2);?></strong></span> <span class="gray">
			+
			<?php if($delivery_amount !=0) { ?>
			<?php echo $format->money($delivery_amount,2);?> shipping
			<?php }else{ ?>
			FREE SHIPPING
			<?php } ?></span></p>
			<p><strong>Condition:</strong><?php if(!empty($pro_seller_info['ProductSeller']['condition_id'])) echo strtoupper($condition_array[$pro_seller_info['ProductSeller']['condition_id']]);?></strong></p>
			<?php if(!empty($pro_seller_info['ProductSeller']['notes'])) { ?>
			<p style="width:153px;"><strong>Comments:</strong>
			<?php echo ucfirst($pro_seller_info['ProductSeller']['notes']);?></p>
			<?php }?>
			<?php if($pro_seller_info['ProductSeller']['quantity'] > 0){ ?>
			<p class="green-color larger-font"><strong>In Stock</strong></p>
			<p class="margin-top"><?php echo $html->link('<span>Add to Basket</span>',"javascript:void(0)",array('escape'=>false,'class'=>'ornge-btn','onClick'=>'addToBasket('.$pro_info['Product']['id'].',1,'.$pro_seller_info['ProductSeller']['price'].','.$pro_seller_info['ProductSeller']['seller_id'].','.$pro_seller_info['ProductSeller']['condition_id'].')'));?></p>
			<?php }?>
			<?php }?>
		</li>
	</ul>
</div>

<!-- 	<div class="gray-fade-bg-box sml-pad background-none" style="border:0px;"> -->

</div>
</div>
<!--Browse Closed-->
</div>
<!--Left Content Closed-->
<?php }?>