<?php
$fh_ok = FH_OK;
if($fh_ok == 'OK'){
//Only for Shopping Basket
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
					if($theme->{'custom-fields'}->{'custom-field'}->_ == 'Customers Also Bought'){
						if(!empty($theme->items)){
							if(!empty($theme->items->item)) {
								if(count($theme->items->item) == 1){
									$countinue_shopping_items[0] = $theme->items->item;
									$countinue_shopping_slogan = $theme->slogan;
								}else{
									$countinue_shopping_items = $theme->items->item;
									$countinue_shopping_slogan = $theme->slogan;
								}
							}
						}
					}
				}
			}
		}
		if(!empty($countinue_shopping_items)){
		$k = 0;
		foreach($countinue_shopping_items as $countinue_shopping_items) {
			foreach($countinue_shopping_items->attribute as $attribute){
				//$recomanded_item[$k][$attribute->name] = $attribute->value->_;
					if($attribute->name == 'secondid' && !empty($attribute->value->_)){
						$countinue_shopping_item[$k]['secondid'] = $attribute->value->_;
					}
					if($attribute->name == 'product_name' && !empty($attribute->value->_)){
					      $countinue_shopping_item[$k]['product_name'] = $attribute->value->_;
					}
					if($attribute->name == 'product_image' && !empty($attribute->value->_)){
					      $countinue_shopping_item[$k]['product_image'] = $attribute->value->_;
					}
					if($attribute->name == 'avg_rating' && !empty($attribute->value->_)){
					      $countinue_shopping_item[$k]['avg_rating'] = $attribute->value->_;
					}
					if($attribute->name == 'product_rrp' && !empty($attribute->value->_)){
					      $countinue_shopping_item[$k]['product_rrp'] = $attribute->value->_;
					}
					if($attribute->name == 'minimum_price_value' && !empty($attribute->value->_)){
					      $countinue_shopping_item[$k]['minimum_price_value'] = $attribute->value->_;					      
					}
					if($attribute->name == 'minimum_price_used' && !empty($attribute->value->_)){
					      $countinue_shopping_item[$k]['minimum_price_used'] = $attribute->value->_;
					}
				}
			$k++;
			}
		}
		//End Fredhopper for Recome'ted Products 16 NOv 2011
	
if(isset($countinue_shopping_item) && is_array($countinue_shopping_item)){
		
		
?>
<!--Only for Shopping Basket-->
<!--Recent History Widget Start  background-none class="recent-history-widget" -->
<div>
		<!--Recent History Product List Start-->
		<div class="recent-history-pro-list">
			<h4><?php echo $countinue_shopping_slogan;?></h4>
			<ul class="outerdiv_resolution products">
			<?php
				$j = 1;
				foreach($countinue_shopping_item as $countinue_shopping_item){
						
					if(!empty($countinue_shopping_item['product_image'])) {
						$image_path = WWW_ROOT.PATH_PRODUCT."/small/img_100_".$countinue_shopping_item['product_image'];
						if(!file_exists($image_path) ){
							$image_path = '/img/no_image_100.jpg';
						}else{
							$image_path = '/'.PATH_PRODUCT.'small/img_100_'.$countinue_shopping_item['product_image'];
						}
					} else {
						$image_path = '/img/no_image_100.jpg';
					}
					$pr_name = $countinue_shopping_item['product_name'];
					$pr_id = $this->Common->getProductId_Qccode($countinue_shopping_item['secondid']);
					$product_rrp = $countinue_shopping_item['product_rrp'];
					$pr_avg_rate = $countinue_shopping_item['avg_rating'];
					$rating = $common->displayProductRating($pr_avg_rate,$pr_id);
				?>		
						
				<li class="inner_div_resolution res<?php echo $j;?>" style="margin-bottom:15px">
					<div style ="padding:5px 5px 0px 5px;">
					<p class="image-sec">
						<?php echo $html->link($html->image($image_path ,array('alt'=>$pr_name,'title'=>$pr_name)),'/'.$this->Common->getProductUrl($pr_id).'/categories/productdetail/'.$pr_id,array('escape'=>false,'class'=>'underline-link'));?>
					</p>
					<p class="prod_name_sec">
						<?php 
							if(!empty($pr_name))
								echo $html->link($format->formatString($pr_name,30,'..'),'/'.$this->Common->getProductUrl($pr_id).'/categories/productdetail/'.$pr_id,array('escape'=>false,'class'=>'underline-link')); else echo '-';
						?>
					</p>

				<p class="star-rating">
					<span class="pad-rt pad-tp"><?php  echo $rating; ?></span>
					</p>
				
				<!--- Need to change the script as per new client requirement--->
					<!---   <p class="price">
						<?php if(!empty($pr_price_new)) { ?>
							<p><span class="price-blue_new">Buy new:</span> <span class="price">
								<?php echo CURRENCY_SYMBOL.$format->money($pr_price_new,2); ?>
							</span></p>
						<?php }elseif(!empty($pr_price_used)){?>
							<p><span class="price-blue_new">Buy used:</span> <span class="price">
								<?php echo CURRENCY_SYMBOL.$format->money($pr_price_used,2); ?>
							</span></p>
							</p>
						<?php }else{?>
						<p>
							<strong>RRP: </strong>
								<?php echo CURRENCY_SYMBOL.$format->money($product_rrp,2); ?>
							</strong>
							</p>
						<?php }?>
				</p> --->
				<p>
					<?php if(!empty($pr_price_new) || !empty($pr_price_used) ) { ?>
			
						<span><strong>RRP: </strong><s>
							<?php echo CURRENCY_SYMBOL.$format->money($product_rrp,2); ?>
						</s></span>
								
					<?php } else{
						?>
						<span>
							<strong>RRP: </strong>
								<?php echo CURRENCY_SYMBOL.$format->money($product_rrp,2); ?>
						</span>
						<?php } ?>
				</p>
				
			 
				<?php if(!empty($pr_price_new)) { ?>
					<p><span class="price-blue_new">Buy new:</span> <span class="price">
						<?php echo CURRENCY_SYMBOL.$format->money($pr_price_new,2); ?>
					</span></p>
				<?php }
				if(!empty($pr_price_used)){?>
					<p><span class="price-blue_new">Buy used:</span> <span class="price">
						<?php echo CURRENCY_SYMBOL.$format->money($pr_price_used,2); ?>
					</span></p>
					</p>
				<?php }?>
			</div>
				</li>
			<?php
				$j++;
				}
			?>

			</ul>
		</div>
		<!--Recent History Product List Closed-->
	</div>
<?php }}?>
<!--Recent History Widget Closed-->
<?php echo $javascript->link(array('change_resolution_basket'));?>