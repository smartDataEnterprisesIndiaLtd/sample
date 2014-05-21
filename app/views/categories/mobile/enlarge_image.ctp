<?php 
if(empty($main_image_additional['Product']['minimum_price_value']) ){
		$main_image_additional['Product']['minimum_price_value'] = '0';
	}
	if(empty($main_image_additional['Product']['minimum_price_seller']) ){
		$main_image_additional['Product']['minimum_price_seller'] = '0';
	}
	if(empty($main_image_additional['Product']['minimum_price_used']) ){
		$main_image_additional['Product']['minimum_price_used'] = '0';
	}
	if(empty($main_image_additional['Product']['minimum_price_used_seller']) ){
		$main_image_additional['Product']['minimum_price_used_seller'] = '0';
	}
	$newLowestPriceSeller  = trim($main_image_additional['Product']['minimum_price_seller']);
	$usedLowestPriceSeller = trim($main_image_additional['Product']['minimum_price_used_seller']);
	$rrp_price 	       = trim($main_image_additional['Product']['product_rrp']);
	$product_id	       = trim($main_image_additional['Product']['id']);
	
	if(!empty($newLowestPriceSeller) ){  // IF seller exists for new condition 
			
		$lowest_price           = $main_image_additional['Product']['minimum_price_value'];
		$lowest_price_seller_id = $main_image_additional['Product']['minimum_price_seller'];
		$product_condition 	= $main_image_additional['Product']['new_condition_id'];
		$stockInfo = $this->Common->getSellerProductStock($lowest_price_seller_id, $product_id, 'new' );
		
		if( !empty($lowest_price) ){
			$prod_price = $lowest_price;
		}else{
			$prod_price = $rrp_price;
		}
	
			
	 ######################## USED PRODUCT SELLER #####################################
	}else if(!empty($usedLowestPriceSeller) ){  // IF seller exists for used condition
		$lowest_price           = $main_image_additional['Product']['minimum_price_used'];
		$lowest_price_seller_id = $main_image_additional['Product']['minimum_price_used_seller'];
		$product_condition 	= $main_image_additional['Product']['used_condition_id'];
		$stockInfo = $this->Common->getSellerProductStock($lowest_price_seller_id, $product_id, 'used' );
		
		if( !empty($lowest_price) ){
			$prod_price = $lowest_price;
		}else{
			$prod_price = $rrp_price;
		}
		
	######################## NO  SELLER #####################################
	}else{  // NO seller exists for any condition
		$lowest_price_seller_id = 0;
		$product_condition = 0;
		$stockInfo = array();
		$sellerDetails =  array();
		$prod_price = $rrp_price;
	}
	$this->set('product_id',$main_image_additional['Product']['id']);
?>

<section class="maincont nopadd">
                <!--Product Detail Box Starts-->
                 <section class="prdctboxdetal">
                 <!--Product Preview Widget Start-->
                    	<div class="product-preview-widget">
			<h2><?php echo $main_image_additional['Product']['product_name'];?></h2>
			<!--Product details Section Start-->
			<ul>
				<li>
				<?php 
				echo $html->link('Back to product information', "/".$this->Common->getProductUrl($product_id)."/categories/productdetail/".$product_id,array( 'escape'=>false,'class'=>'backtopag')); ?>
				</li>
				<li>
					<section class="prdctboxmain">
						<span id="plsLoaderID" style="display:none; text-align:center; class="dimmer"><?php echo $html->image("loading.gif" ,array('alt'=>"Loading" ,  'style'=>'position:absolute;left:50%;top:40%;z-index:999;'));?>
                    		 		</span>
						<?php
							if(!empty($main_image['image'])){
								$main_imagePath2 = WWW_ROOT.PATH_PRODUCT.'large/img_300_'.$main_image['image'];
								if(file_exists($main_imagePath2)){
									echo $html->image('/'.PATH_PRODUCT.'large/img_300_'.$main_image['image'], array('alt'=>""));
								}else{
									echo $html->image('/img/no_image_300.jpg', array('alt'=>""));
								}
						}?>
					</section>
				</li>
				
				<li>
				<p align="center" class="thumb-imgs margin-top"> 
				<?php
				if(!empty($main_image_additional['Productimage'])) {
					foreach($main_image_additional['Productimage'] as $pro_image){
						if(!empty($pro_image['image'])){
							$imagesPath = WWW_ROOT.PATH_PRODUCT.'small/img_50_'.$pro_image['image'];
							if(file_exists($imagesPath)){
								$image_url = $html->image('/'.PATH_PRODUCT.$pro_image['image']);
								$link_str = '/categories/enlarge_image/'.$pro_image['id'].'/'.$product_id;
								echo $html->link($html->image('/'.PATH_PRODUCT."small/img_50_".$pro_image['image'], array('alt'=>"",'width'=>'30','height'=>'30')),$link_str,array('escape'=>false,'class'=>'large-image','title'=>'Enlarge'),false,false);
							}
						}
					}
				}?>
				</p>
				<p align="center">
						<?php
						//$link_str = '/categories/enlarge_image/'.$pro_image['id'].'/'.$product_id;
						//echo $html->link('Touch to enlarge',$link_str,array('id'=>'top','escape'=>false,'class'=>'gray font11'));?>
						<!--a href="#" class--="gray font11">Click to enlarge</a-->
						<span class="gray font11">Touch to enlarge</span>
				</p>
				</li>
				
				<li class="margin-top" style="text-align:center"><b><?php if($stockInfo['ProductSeller']['quantity'] != 0 ||  !empty($stockInfo['ProductSeller']['quantity'])  ) {?> Quantity: <?php }?></b>
				 <?php
					if( empty($stockInfo) ) {
						echo $html->image("add-to-cart-img-disabled.png",array('alt'=>"",'style'=>'vertical-align:middle;'  ));
					} else if($stockInfo['ProductSeller']['quantity'] <= 0 ||  empty($stockInfo['ProductSeller']['quantity'])  ) {
						echo $html->image("add-to-cart-img-disabled.png",array('alt'=>"",'style'=>'vertical-align:middle;'  ));
					} else { ?>
						<input onfocus="if(this.value == '1') {this.value=''}" onblur="if(this.value == ''){this.value ='1'}" id="prod_quantity_id" type="text" name="qty" value="1" onkeyup= "javascript: if(isNaN(this.value)){ this.value = '' }" maxlength="5"  class="smalltxtbx" />
						<?php $addToBasket =  $main_image_additional['Product']['id'].",'prod_quantity_id',";
						$addToBasket .= $prod_price.",". $lowest_price_seller_id.",";
						$addToBasket .= $product_condition;
						echo '<input type="button" value="Add to Basket"  class="addtobsktbg" onclick="addToBasket('.$addToBasket.')"/>';
					}
				?>
				</li>
			</ul>
			<!--Product details Section Closed-->	
                	</div>
                 <!--Product Preview Widget Closed-->
                  </section>
                <!--Product Detail Box Starts-->
	</section>
	<!--Main Content End--->