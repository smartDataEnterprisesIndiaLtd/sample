<?php if(!empty($customer_buy_aft_this)){ 
?>
<!--What Do Customers Ultimately Buy After Viewing This Item? Start-->
<div class="row no-pad-btm">
	<!--FBTogether Start-->
	<div class="fbtogether">
		<h4 class="mid-gr-head blue-color"><span><?php echo $customer_buy_aft_this_slogan;?></span></h4>
		<div class="product-des no-pad-btm">
			<?php
			
			$customer_buys[0]['secondid'] = $product_details['Product']['quick_code'];
			$customer_buys[0]['product_name'] = $product_details['Product']['product_name'];
			$customer_buys[0]['product_image'] = $product_details['Product']['product_image'];
			$customer_buys[0]['avg_rating'] = $product_details['Product']['avg_rating'];
			$customer_buys[0]['product_rrp'] = $product_details['Product']['product_rrp'];
			
			$customer_buys[0]['minimum_price_used'] = $product_details['Product']['minimum_price_used'];
			$customer_buys[0]['minimum_price_value'] = $product_details['Product']['minimum_price_value'];
			$customer_buys[0]['minimum_price_seller'] = $product_details['Product']['minimum_price_seller'];
			$customer_buys[0]['minimum_price_used_seller'] = $product_details['Product']['minimum_price_used_seller'];
			
			$customer_buys[0]['condition_new'] = $product_details['Product']['new_condition_id'];
			$customer_buys[0]['condition_used'] = $product_details['Product']['used_condition_id'];
			
			
			$k = 1;
			foreach($customer_buy_aft_this as $customer_buy_aft_this) {
				if($k < 4){
				if(!empty($customer_buy_aft_this->attribute)) {
					
					foreach($customer_buy_aft_this->attribute as $attribute){
						if($attribute->name == 'secondid' && !empty($attribute->value->_)){
							$customer_buys[$k]['secondid'] = $attribute->value->_;
						}
						if($attribute->name == 'product_name' && !empty($attribute->value->_)){
						      $customer_buys[$k]['product_name'] = $attribute->value->_;
						}
						if($attribute->name == 'product_image' && !empty($attribute->value->_)){
						      $customer_buys[$k]['product_image'] = $attribute->value->_;
						}
						
						if($attribute->name == 'avg_rating' && !empty($attribute->value->_)){
						      $customer_buys[$k]['avg_rating'] = $attribute->value->_;
						}
						if($attribute->name == 'product_rrp' && !empty($attribute->value->_)){
						      $customer_buys[$k]['product_rrp'] = $attribute->value->_;
						}
						if($attribute->name == 'minimum_price_used' && !empty($attribute->value->_)){
							$customer_buys[$k]['minimum_price_used'] = $attribute->value->_;
						}
						if($attribute->name == 'minimum_price_value'  && !empty($attribute->value->_)){
							$customer_buys[$k]['minimum_price_value'] = $attribute->value->_;
						}
						if($attribute->name == 'minimum_price_seller'  && !empty($attribute->value->_)){
							$customer_buys[$k]['minimum_price_seller'] = $attribute->value->_;
						}
						if($attribute->name == 'minimum_price_used_seller'  && !empty($attribute->value->_)){
							$customer_buys[$k]['minimum_price_used_seller'] = $attribute->value->_;
						}
						if($attribute->name == 'condition_new' && !empty($attribute->value->_)){
							$customer_buys[$k]['condition_new'] = $attribute->value->_;
						}
						if($attribute->name == 'condition_used'  && !empty($attribute->value->_)){
							$customer_buys[$k]['condition_used'] = $attribute->value->_;
						}
					}
				}
				}
			$k++;	
			}
			//pr($customer_buys);
			$i_cus = 0;
			
			//$per = (($rest*60)/100);
			//$per = (($rest*30)/100);
			//$per = (($rest*10)/100);
			$per = rand(70, 98);
			$rest = (100 - $per);
			foreach($customer_buys as $customer_buy) {
						
					if(!empty($customer_buy['product_image'])) {
						$image_path = WWW_ROOT.PATH_PRODUCT."/small/img_50_".$customer_buy['product_image'];
						if(!file_exists($image_path) ){
							$image_path = '/img/no_image_50.jpg';
						}else{
							$image_path = '/'.PATH_PRODUCT.'small/img_50_'.$customer_buy['product_image'];
						}
					} else {
						$image_path = '/img/no_image_50.jpg';
					}
				
				if($i_cus == '1' && !empty($rest)){
					$per = (($rest*60)/100);
				}elseif($i_cus == '2' && !empty($rest)){
					$per = (($rest*30)/100);
				}elseif($i_cus == '3' && !empty($rest)){
					$per = (($rest*10)/100);
				}
			?>
			<div class="row overflow-h">
				<div class="prod-itm"><?php
				$pr_id = $this->Common->getProductId_Qccode($customer_buy['secondid']);
				$rating = $common->displayProductRating($customer_buy['avg_rating'],$pr_id);
				
				echo $html->link($html->image($image_path,array('width'=>"50",'height'=>"50", 'alt'=>$customer_buy['product_name'],'title'=>$customer_buy['product_name'])),'/'.$this->Common->getProductUrl($pr_id).'/categories/productdetail/'.$pr_id,array('escape'=>false));;?></div>
				<div class="prod-itm-con">
					<?php if(empty($i_cus)){
						$class_cus = 'green-color larger-fnt';
					} else {
						$class_cus = '';
					} ?>
					<p class="<?php echo $class_cus;?>"><strong><?php echo $per ?>% buy the item on this page</strong></p>
					<p>
					<?php if($i_cus != 0){?>
						<?php echo $html->link($customer_buy['product_name'],'/'.$this->Common->getProductUrl($pr_id).'/categories/productdetail/'.$pr_id,array('escape'=>false)); ?>
					<?php }else {?>
						<span class="used-from">
							<?php echo $customer_buy['product_name']; ?>
						</span>
					<?php }?>
					<?php //echo $html->link($customer_buy['product_name'],'/'.$this->Common->getProductUrl($pr_id).'/categories/productdetail/'.$pr_id,array('escape'=>false)); ?> <span class="padding-left"><?php echo $rating;?></p>
					<p class="price">
						<strong>
							
							<?php if(!empty($customer_buy['minimum_price_value'])){
									$min_price = $customer_buy['minimum_price_value'];
									if(!empty($customer_buy['minimum_price_seller'])){
										$min_seller_id = $customer_buy['minimum_price_seller'];
									}
								} else if(!empty($customer_buy['minimum_price_used'])){
									$min_price = $customer_buy['minimum_price_used'];
									
									if(!empty($customer_buy['minimum_price_used_seller'])){
										$min_seller_id = $customer_buy['minimum_price_used_seller'];
									}
								}else{
									$min_con_id = '';
									$min_seller_id = '';
									$min_price = '';
									$total_save = 0;
									$saving_percentage = 0;
								}
								// There is some change in FH We get directly conditin id from FH on 2-2-2012.
								if(!empty($customer_buy['condition_new'])){
										$min_con_id = $customer_buy['condition_new'];
									}else if(!empty($customer_buy['condition_used'])){
										$min_con_id = $customer_buy['condition_used'];
									}else{
										$min_con_id = '';
									}
									
								?>
								
								<?php if(!empty($pr_id) && !empty($min_seller_id) && !empty($min_con_id)){
									$prodSellerInfo = $common->getProductSellerInfo($pr_id ,$min_seller_id, $min_con_id);
									$prodStock = $prodSellerInfo['ProductSeller']['quantity'];
									if($prodStock > 0){
										echo CURRENCY_SYMBOL.' '.$format->money($min_price,2);
									}else{
										echo CURRENCY_SYMBOL.' '.$format->money($product_rrp,2);
									}
								}else{
									echo CURRENCY_SYMBOL.' '.$format->money($customer_buy['product_rrp'],2);
								}
								?>
							<?php
							//echo CURRENCY_SYMBOL.$format->money($customer_buy['product_rrp'],2); ?>
						</strong>
					</p>
				</div>
			</div>
			<?php
			$i_cus++;
			}?>
			<p class="smalr-fnt">Visit our <?php
			$spanClass = '';
			$dept_name = str_replace(array('&',' '), array('and','-'), html_entity_decode($dept_name, ENT_NOQUOTES, 'UTF-8'));
			echo $html->link('<span>'.$dept_name.' </span>',"/".$dept_name."/departments/index/".$dept_id,array('escape'=>false ,'class'=>$spanClass ));?></li>
			for a fantastic selection of brands and product, all at great prices.</p>
		</div>
	</div>
	<!--FBTogether Closed-->
</div>
<!--What Do Customers Ultimately Buy After Viewing This Item? Closed-->
<?php }?>