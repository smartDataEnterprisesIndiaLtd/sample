<?php
$fh_ok = FH_OK;
if($fh_ok == 'OK'){
//Start Fredhopper for Recomented Products 16 NOv 2011 its for shopping Basket and quick order
		$ws_location = WS_LOCATION;
		//Create a new soap client
		$client = new SoapClient($ws_location, array('login'=>'choiceful', 'password'=>'aiteiyienole'));
// 		$this->Common->fh_call();
		$recomanded_item = array();
		$recomanded_items_slogan = array();
		$view_size = VIEW_SIZE_FH;

		$this->set('view_size',$view_size);

		//Build the query string
	
		//$fh_location='fh_location=//catalog01/en_GB/$s=basket/';
		if($this->params['controller'] == 'baskets' && $this->params['action'] == 'quick_order'){
			$fh_location='fh_location=//catalog01/en_GB&special-page-id=quick-order';
		}elseif($this->params['controller'] == 'baskets' && $this->params['action'] == 'view'){
			$fh_location='fh_location=//catalog01/en_GB&special-page-id=shopping-basket';
		}else{
			$fh_location='fh_location=//catalog01/en_GB';
		}
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
					if($theme->{'custom-fields'}->{'custom-field'}->_ == 'Recommended Products - Footer'){
						if(!empty($theme->items)){
							if(!empty($theme->items->item)) {
								if(count($theme->items->item) == 1){
									$recomanded_items[0] = $theme->items->item;
									$recomanded_items_slogan = $theme->slogan;
								}else{
									$recomanded_items = $theme->items->item;
									$recomanded_items_slogan = $theme->slogan;
								}
							}
						}
					}
				}
			}
		}
		if(!empty($recomanded_items)){
		$k = 0;
		foreach($recomanded_items as $recomanded_items) {
			foreach($recomanded_items->attribute as $attribute){
				//$recomanded_item[$k][$attribute->name] = $attribute->value->_;
					if($attribute->name == 'secondid' && !empty($attribute->value->_)){
						$recomanded_item[$k]['secondid'] = $attribute->value->_;
					}
					if($attribute->name == 'product_name' && !empty($attribute->value->_)){
					      $recomanded_item[$k]['product_name'] = $attribute->value->_;
					}
					if($attribute->name == 'product_image' && !empty($attribute->value->_)){
					      $recomanded_item[$k]['product_image'] = $attribute->value->_;
					}
					if($attribute->name == 'avg_rating' && !empty($attribute->value->_)){
					      $recomanded_item[$k]['avg_rating'] = $attribute->value->_;
					}
					if($attribute->name == 'product_rrp' && !empty($attribute->value->_)){
					      $recomanded_item[$k]['product_rrp'] = $attribute->value->_;
					}
					if($attribute->name == 'minimum_price_value' && !empty($attribute->value->_)){
					      $recomanded_item[$k]['minimum_price_value'] = $attribute->value->_;					      
					}
					if($attribute->name == 'minimum_price_used' && !empty($attribute->value->_)){
					      $recomanded_item[$k]['minimum_price_used'] = $attribute->value->_;
					}
					
					if($attribute->name == 'condition_new' && !empty($attribute->value->_)){
					      $recomanded_item[$k]['condition_new'] = $attribute->value->_;
					}
					if($attribute->name == 'condition_used' && !empty($attribute->value->_)){
					      $recomanded_item[$k]['condition_used'] = $attribute->value->_;
					}
					if($attribute->name == 'minimum_price_seller' && !empty($attribute->value->_)){
					      $recomanded_item[$k]['minimum_price_seller'] = $attribute->value->_;
					}
					if($attribute->name == 'minimum_price_used_seller' && !empty($attribute->value->_)){
					      $recomanded_item[$k]['minimum_price_used_seller'] = $attribute->value->_;
					}
				}
			$k++;
			}
		}
	$this->set('recomanded_item',$recomanded_item);
	//End Fredhopper for Recome'ted Products 16 NOv 2011
 ?>
 <!--Right Section Start-->
<?php if(is_array($recomanded_item) && !empty($recomanded_item)){?>
<div class="right-section">
	<!--Top iPod Sellers Start-->
	<div class="side-content">
		<h4 class="blue-color gray-bg-head"><span class="larger-fnt"><?php echo $recomanded_items_slogan;?></span></h4>
		<div class="gray-fade-bg-box">
			<div class="product-des no-pad-btm">
				<?php
				//pr($recomanded_item);
				//Start Recommended product on 16 nov 2011
				foreach($recomanded_item as $recomanded_item){
					$prodStock = "";
					if(!empty($recomanded_item['product_image'])) {
						$image_path = WWW_ROOT.PATH_PRODUCT."/small/img_50_".$recomanded_item['product_image'];
						if(!file_exists($image_path) ){
							$image_path = '/img/no_image_50.jpg';
						}else{
							$image_path = '/'.PATH_PRODUCT.'small/img_50_'.$recomanded_item['product_image'];
						}
					} else {
						$image_path = '/img/no_image_50.jpg';
					}
					$pr_name = $recomanded_item['product_name'];
					$pr_id = $this->Common->getProductId_Qccode($recomanded_item['secondid']);
					$product_rrp = $recomanded_item['product_rrp'];
					$pr_avg_rate = $recomanded_item['avg_rating'];
					
					if(key_exists('minimum_price_value',$recomanded_item)){
						$pr_price_new = $recomanded_item['minimum_price_value'];
					}else{
						$pr_price_new = "";
					}
					
					if(key_exists('minimum_price_used',$recomanded_item)){
						$pr_price_used = $recomanded_item['minimum_price_used'];
					}else{
						$pr_price_used = "";
					}
					
					
					
					if(key_exists('condition_new',$recomanded_item)){
						$new_con_id = $recomanded_item['condition_new'];
					}else{
						$new_con_id = "";
					}
					if(key_exists('condition_used',$recomanded_item)){
						$used_con_id = $recomanded_item['condition_used'];
					}else{
						$used_con_id = "";
					}
					if(key_exists('minimum_price_seller',$recomanded_item)){
						$min_new_seller = $recomanded_item['minimum_price_seller'];
					}else{
						$min_new_seller = "";
					}
					if(key_exists('minimum_price_used_seller',$recomanded_item)){
						$min_used_seller = $recomanded_item['minimum_price_used_seller'];
					}else{
						$min_used_seller = "";
					}
					
					$rating = $common->displayProductRating($pr_avg_rate,$pr_id);
					
					if(!empty($pr_id) && !empty($min_new_seller) && !empty($new_con_id)){
						$prodSellerInfo = $common->getProductSellerInfo($pr_id ,$min_new_seller, $new_con_id);
						if(!empty($prodSellerInfo))
							$prodStock = $prodSellerInfo['ProductSeller']['quantity'];
						else
							$prodStock = "";
					}			
							
					if(!empty($pr_id) && !empty($min_used_seller) && !empty($used_con_id)){
						$prodSellerInfo = $common->getProductSellerInfo($pr_id ,$min_used_seller, $used_con_id);
						if(!empty($prodSellerInfo))
							$prodStock = $prodSellerInfo['ProductSeller']['quantity'];
						else
							$prodStock = "";
					}
					
				?>
					
					
				<div class="row overflow-h">
					<div class="prod-itm">
					<?php echo $html->link($html->image($image_path ,array('alt'=>$pr_name,'title'=>$pr_name)),'/'.$this->Common->getProductUrl($pr_id).'/categories/productdetail/'.$pr_id,array('escape'=>false,'class'=>'underline-link'));
					//$html->image($image_path ,array('alt'=>$pr_name));
						
						
					?></div>
					<div class="prod-item-con smalr-fnt">
						<p>
							<?php if(!empty($pr_name))
								echo $html->link($format->formatString($pr_name,60,'..'),'/'.$this->Common->getProductUrl($pr_id).'/categories/productdetail/'.$pr_id,array('escape'=>false,'class'=>'underline-link')); else echo '-';
							?>
						</p>
						<p class="price">
						<?php if(!empty($pr_price_new) && $pr_price_new > 0 && $prodStock > 0) { ?>
							<strong>
								<?php echo CURRENCY_SYMBOL.$format->money($pr_price_new,2); ?>
							</strong>
						<?php }elseif(!empty($pr_price_used) && $pr_price_used > 0 && $prodStock > 0){?>
							<strong>
								<?php echo CURRENCY_SYMBOL.$format->money($pr_price_used,2); ?>
							</strong>
							
						<?php }else{?>
							<strong>
								<?php echo CURRENCY_SYMBOL.$format->money($product_rrp,2); ?>
							</strong>
							
						<?php }?>
						 	<span class="padding-left" style="color:#003399">
								<?php echo $rating; ?>
							</span>
					
						 </p>
					</div>
				</div>
				<?php 
				}
				//Start Recommended product on 16 nov 2011 ?>
			</div>
		</div>
	</div>
	<!--Top iPod Sellers Closed-->
</div>
<!--Right Section Closed-->
<?php } }?>