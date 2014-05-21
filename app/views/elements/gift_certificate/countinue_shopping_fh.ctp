<?php
$fh_ok = FH_OK;
if($fh_ok == 'OK'){
//Start Fredhopper for Recomented Products 16 NOv 2011
		$ws_location = WS_LOCATION;
		//Create a new soap client
		//$client = new SoapClient($ws_location, array('login'=>'username', 'passowrd'=>'password'));
		$client = new SoapClient($ws_location, array('login'=>'choiceful', 'password'=>'aiteiyienole'));
		//Configure::write('debug',2);
		//pr($client);

// 		$this->Common->fh_call();
		$continue_shoppings = array();
		$continue_shopping_slogan = array();
		
		$view_size = VIEW_SIZE_FH;

		$this->set('view_size',$view_size);

		//Build the query string
		$fh_location='fh_location=//catalog01/en_GB&special-page-id=gift-certificate';
		//Send the query string to the Fredhopper Query Server & obtain the result
		$result = $client->__soapCall('getAll', array('fh_params' => $fh_location));
		//Find the universe marked as 'selected' in the result
		foreach($result->universes->universe as $r) {
			if($r->{"type"} == "selected"){
				//Extract & print the breadcrumbs from the result
				if(!empty($r->facetmap))
					$facetmap = (array)$r->facetmap;
			if(!empty($r->breadcrumbs))
					$breadcrumbs = (array)$r->breadcrumbs;
				if(!empty($r->themes))
					$themes = (array)$r->themes;
			}
		}
		if(!empty($themes)){
		$themes = $themes['theme'];
			if(!empty($themes)){
				foreach($themes as $theme){
					if($theme->{'custom-fields'}->{'custom-field'}->_ == 'Customers Also Bought'){
						if(!empty($theme->items)){
							if(!empty($theme->items->item)) {
								if(count($theme->items->item) == 1){
									$continue_shopping[0] = $theme->items->item;
									$continue_shopping_slogan = $theme->slogan;
								}else{
									$continue_shopping = $theme->items->item;
									$continue_shopping_slogan = $theme->slogan;
								}
							}
						}
					}
				}
			}
		}
		if(!empty($continue_shopping)){
		$k = 0;
		foreach($continue_shopping as $continue_shopping_items) {
			foreach($continue_shopping_items->attribute as $attribute){
					if($attribute->name == 'secondid' && !empty($attribute->value->_)){
						$continue_shoppings[$k]['secondid'] = $attribute->value->_;
					}
					if($attribute->name == 'product_name' && !empty($attribute->value->_)){
					      $continue_shoppings[$k]['product_name'] = $attribute->value->_;
					}
					if($attribute->name == 'product_image' && !empty($attribute->value->_)){
					      $continue_shoppings[$k]['product_image'] = $attribute->value->_;
					}
					
					if($attribute->name == 'avg_rating' && !empty($attribute->value->_)){
					      $continue_shoppings[$k]['avg_rating'] = $attribute->value->_;
					}
					if($attribute->name == 'product_rrp' && !empty($attribute->value->_)){
					      $continue_shoppings[$k]['product_rrp'] = $attribute->value->_;
					}
					if($attribute->name == 'minimum_price_used' && !empty($attribute->value->_)){
						$continue_shoppings[$k]['minimum_price_used'] = $attribute->value->_;
					}
					if($attribute->name == 'minimum_price_value'  && !empty($attribute->value->_)){
						$continue_shoppings[$k]['minimum_price_value'] = $attribute->value->_;
					}
					if($attribute->name == 'minimum_price_seller'  && !empty($attribute->value->_)){
						$continue_shoppings[$k]['minimum_price_seller'] = $attribute->value->_;
					}
					if($attribute->name == 'minimum_price_used_seller'  && !empty($attribute->value->_)){
						$continue_shoppings[$k]['minimum_price_used_seller'] = $attribute->value->_;
					}
					if($attribute->name == 'condition_new' && !empty($attribute->value->_)){
						$continue_shoppings[$k]['condition_new'] = $attribute->value->_;
					}
					if($attribute->name == 'condition_used'  && !empty($attribute->value->_)){
						$continue_shoppings[$k]['condition_used'] = $attribute->value->_;
					}
				}
				$k++;
			}
		}
	//End Fredhopper for Recomented Products 16 NOv 2011***** Updated on 18 May 2012******
 ?>
<!--Recent History Widget Start-->
<?php if(!empty($continue_shoppings)){?>
<div class="recent-history-widget background-none">
		<!--Recent History Product List Start-->
		<div class="recent-history-pro-list">
			<h4><strong>Countinue Shopping:</strong> <span class="font-weight-normal"><?php echo $continue_shopping_slogan;?></span></h4>
			<ul class="products outerdiv_resolution">
			<?php
				$j = 1;
				foreach($continue_shoppings as $continue_shoppings){
					if(!empty($continue_shoppings['product_image'])) {
						$image_path = WWW_ROOT.PATH_PRODUCT."/small/img_100_".$continue_shoppings['product_image'];
						if(!file_exists($image_path) ){
							$image_path = '/img/no_image_100.jpg';
						}else{
							$image_path = '/'.PATH_PRODUCT.'small/img_100_'.$continue_shoppings['product_image'];
						}
					} else {
						$image_path = '/img/no_image_100.jpg';
					}
					$product_rrp = $continue_shoppings['product_rrp'];
					$pr_name = $continue_shoppings['product_name'];
					$pr_id = $this->Common->getProductId_Qccode($continue_shoppings['secondid']);
			?>
				<li class="inner_div_resolution res<?php echo $j;?>" style="width:20%;margin-bottom:15px">
					<p class="image-sec"><?php 
					echo $html->link($html->image($image_path,array('alt'=>$pr_name, 'title'=>$pr_name)), "/".$this->Common->getProductUrl($pr_id)."/categories/productdetail/".$pr_id,array( 'escape'=>false)); ?></p>
					<p class="conti_shp_width"><?php echo $html->link($pr_name,"/".$this->Common->getProductUrl($pr_id)."/categories/productdetail/".$pr_id,null);?></p>
					<p class="price larger-font">
						<strong><?php
								if(!empty($continue_shoppings['minimum_price_value'])){
									$min_price = $continue_shoppings['minimum_price_value'];
									if(!empty($continue_shoppings['minimum_price_seller'])){
										$min_seller_id = $continue_shoppings['minimum_price_seller'];
									}
								} else if(!empty($continue_shoppings['minimum_price_used'])){
									$min_price = $continue_shoppings['minimum_price_used'];
									
									if(!empty($continue_shoppings['minimum_price_used_seller'])){
										$min_seller_id = $continue_shoppings['minimum_price_used_seller'];
									}
								}else{
									$min_con_id = '';
									$min_seller_id = '';
									$min_price = '';
									$total_save = 0;
									$saving_percentage = 0;
								}
								// There is some change in FH We get directly conditin id from FH on 2-2-2012.
								if(!empty($continue_shoppings['condition_new'])){
										$min_con_id = $continue_shoppings['condition_new'];
									}else if(!empty($continue_shoppings['condition_used'])){
										$min_con_id = $continue_shoppings['condition_used'];
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
										echo CURRENCY_SYMBOL.' '.$format->money($product_rrp,2);
								}
							//echo CURRENCY_SYMBOL.$product_rrp; ?>
						</strong>
					</p>
				</li>
				
			<?php $j++;	}?>
			
			</ul>
		</div>
		<!--Recent History Product List Closed-->
	</div>
<?php } }?>
<!--Recent History Widget Closed-->
<script>
	var width_pre_div = 799;
	
</script>
<?php echo $javascript->link(array('change_resolution_basket'));?>