<style>
	.price-blue_new {
    color: #003399;
    text-decoration: underline;
}
</style>
<?php
$controller_name = $this->params['controller'];
if($controller_name == 'homes')
	$link_home = '/departments/index/';
else
	$link_home  = '/categories/index/';
// this all data coming from index.ctp of homes 
if(count($release1_field_ids) > 0){
	if(count($release1_Products) > 0){
		foreach($release1_field_ids as $ProdId):
			if(isset($release1_Products[$ProdId])){
				$pos1_newreleases[] = $release1_Products[$ProdId];
			}
		endforeach;
	}
}

if(count($release2_field_ids) > 0){
	if(count($release2_Products) > 0){
		foreach($release2_field_ids as $ProdId):
			if(isset($release2_Products[$ProdId])){
				$pos2_newreleases[] = $release2_Products[$ProdId];
			}
		endforeach;
	}
}
//pr($release3_field_ids);
if(count($release3_field_ids) > 0){
	if(count($release3_Products) > 0){
		foreach($release3_field_ids as $ProdId):
			if(isset($release3_Products[$ProdId])){
				$pos3_newreleases[] = $release3_Products[$ProdId];
			}
		endforeach;
	}
}

########################################## Heading Departments #############################
if(count($department1_field_ids) > 0){
	if(count($department1_Products) > 0){
		foreach($department1_field_ids as $ProdId):
			if(isset($department1_Products[$ProdId])){
				$pos1_dept_products[] = $department1_Products[$ProdId];
			}
		endforeach;
	}
}
if(count($department2_field_ids) > 0){
	if(count($department2_Products) > 0){
		foreach($department2_field_ids as $ProdId):
			if(isset($department2_Products[$ProdId])){
				$pos2_dept_products[] = $department2_Products[$ProdId];
			}
		endforeach;
	}
}
if(count($department3_field_ids) > 0){
	if(count($department3_Products) > 0){
		foreach($department3_field_ids as $ProdId):
			if(isset($department3_Products[$ProdId])){
				$pos3_dept_products[] = $department3_Products[$ProdId];
			}
		endforeach;
	}
}
if(count($department4_field_ids) > 0){
	if(count($department4_Products) > 0){
		foreach($department4_field_ids as $ProdId):
			if(isset($department4_Products[$ProdId])){
				$pos4_dept_products[] = $department4_Products[$ProdId];
			}
		endforeach;
	}
}
//pr($pos1_newreleases);
?>
<?php   /** ****************** RELEASE 1 PRODUCTS  STARTS **************************************/
if(!empty($pos1_newreleases)){ ?>
<div class="row">
	<!--New Releases Start-->
	<h4 class="mid-gr-head">
		<span>New Releases</span>
	</h4>
	<!--Products Widget Start-->
	<div class="products-widget outerdiv_resolution">
		<ul class="products">
			<?php //foreach($pos1_newreleases as $pos1_newreleases[$i]) {
			$max_count_pos1 = count($pos1_newreleases);
			$i1=1;
			for($i=0;$i< $max_count_pos1;$i++){
				if(!empty($pos1_newreleases[$i])){
					
				if($pos1_newreleases[$i]['Product']['product_image'] == 'no_image.gif' || $pos1_newreleases[$i]['Product']['product_image'] == 'no_image.jpeg'){
					$image_path = '/img/no_image.jpeg';
				} else{
					$image_path = WWW_ROOT.PATH_PRODUCT.'small/img_100_'.$pos1_newreleases[$i]['Product']['product_image'];
					if(!file_exists($image_path) ){
						$image_path = '/img/no_image_100.jpg';
					}else{
						$image_path = '/'.PATH_PRODUCT.'small/img_100_'.$pos1_newreleases[$i]['Product']['product_image'];
					}
					
				}
				$rating = $common->displayProductRating($pos1_newreleases[$i]['Product']['avg_rating'],$pos1_newreleases[$i]['Product']['id']);
			?>
			<li class="inner_div_resolution res<?php echo $i1;?>""><div style ="padding:5px 5px 0px 5px; min-height: 210px;">
				<p class="image-sec" style="min-height:87px;">
					<?php echo $html->link($html->image($image_path,array('alt'=>$pos1_newreleases[$i]['Product']['product_name'], 'title'=>$pos1_newreleases[$i]['Product']['product_name'])), '/'.$this->Common->getProductUrl($pos1_newreleases[$i]['Product']['id']).'/categories/productdetail/'.$pos1_newreleases[$i]['Product']['id'],array('escape'=>false,));?>
				</p>
				<p  class="conti_shp_width">
					<?php echo $html->link($format->formatString($pos1_newreleases[$i]['Product']['product_name'],500),'/'.$this->Common->getProductUrl($pos1_newreleases[$i]['Product']['id']).'/categories/productdetail/'.$pos1_newreleases[$i]['Product']['id'],array('escape'=>false,));?>
				</p>
				<p class="star-rating">
					<span class="pad-rt pad-tp"><?php  echo $rating; ?></span>
				</p><p>
						
						<?php if(!empty($pos1_newreleases[$i]['Product']['minimum_price_value'])  && $pos1_newreleases[$i]['Product']['minimum_price_value'] > 0){ ?>
						<strong>RRP: </strong><s><?php echo CURRENCY_SYMBOL.$format->money($pos1_newreleases[$i]['Product']['product_rrp'],2);?> </s>
						<?php }else{
							echo "<strong>RRP: </strong>". CURRENCY_SYMBOL.$format->money($pos1_newreleases[$i]['Product']['product_rrp'],2);
						} ?>
						
						
					</p>
			
				<?php
				if(!empty($pos1_newreleases[$i]['Product']['minimum_price_value'])  && $pos1_newreleases[$i]['Product']['minimum_price_value'] > 0){ 
					echo '<p><span class="price-blue_new">Buy new:</span> <span class="price">';
					echo CURRENCY_SYMBOL.$format->money($pos1_newreleases[$i]['Product']['minimum_price_value'],2);
					echo '</span></p>';
				}
				if(!empty($pos1_newreleases[$i]['Product']['minimum_price_used']) && $pos1_newreleases[$i]['Product']['minimum_price_used'] > 0 ){
					echo '<p><span class="price-blue_new">Buy used:</span> <span class="price">';
					echo CURRENCY_SYMBOL.$format->money($pos1_newreleases[$i]['Product']['minimum_price_used'],2);
					echo '</span></p>';
				} ?>
			</div></li>
			<?php }
			$i1++;
			}?>
		</ul>
	</div>
	<!--Products Widget Closed-->
	<!--New Releases Closed-->
</div>
<?php } /** ********************** RELEASE 1 PRODUCTS  STARTS ********************************/
/** ********************** DEPARTMENT 1 PRODUCTS  STARTS  ********************************/
if(!empty($pos1_dept_products)) {?>
<div class="row">
	<div class="pick-of-week">
		<h2 class="heading" style="position:relative;">
		<?php
		if(!empty($hm_products['HomepageProduct']['heading1']) ){
			if($hm_products['HomepageProduct']['department_id'] == 0){
				 echo $departments[$hm_products['HomepageProduct']['heading1']];
			}else{
				if(isset($topCategoryArr) ) {
					echo $topCategoryArr[$hm_products['HomepageProduct']['heading1']];
				}
			}
		}
		if($controller_name == 'homes'){
			$dept_url_name = str_replace(array('&',' '), array('and','-'), html_entity_decode($departments[$hm_products['HomepageProduct']['heading1']], ENT_NOQUOTES, 'UTF-8'));
		}else{
			$cat_url_name = str_replace(array('&',' '), array('and','-'), html_entity_decode($topCategoryArr[$hm_products['HomepageProduct']['heading1']], ENT_NOQUOTES, 'UTF-8'));
			
			$dept_url_name = str_replace(array('&',' '), array('and','-'), html_entity_decode($department_name, ENT_NOQUOTES, 'UTF-8'));
			
			$dept_url_name = $dept_url_name.'/'.$cat_url_name;
		}

		?><?php echo $html->link('home &raquo;','/'.$dept_url_name.'/'.$link_home.$hm_products['HomepageProduct']['heading1'],array('escape'=>false,'class'=>'h2link'))?>
		
		</h2>
		<div class="products-widget outerdiv_resolution inner_2div_resolution-height">
			<!--Column One Start-->
			<?php
			$count_dept_pos1 = count($pos1_dept_products);
			for($w = 0;$w<$count_dept_pos1; $w++) {
			if(!empty($pos1_dept_products[$w])) { ?>
 			<div class="inner_2div_resolution"> 
				<div class="colum-one" style="width:98%">
					<div class="left-product-img">
					<?php 
					if($pos1_dept_products[$w]['Product']['product_image'] == 'no_image.gif' || $pos1_dept_products[$w]['Product']['product_image'] == 'no_image.jpeg'){
						$pos1_image_path1 = '/img/no_image.jpeg';
					} else{
						$pos1_image_path1 = WWW_ROOT.PATH_PRODUCT.'small/img_100_'.$pos1_dept_products[$w]['Product']['product_image'];
						
						if(!file_exists($pos1_image_path1) ){
							$pos1_image_path1 = '/img/no_image_100.jpg';
						}else{
							$pos1_image_path1 = '/'.PATH_PRODUCT.'small/img_100_'.$pos1_dept_products[$w]['Product']['product_image'];
						}
					}
					echo $html->link($html->image($pos1_image_path1,array('alt'=>$pos1_dept_products[$w]['Product']['product_name'],'title'=>$pos1_dept_products[$w]['Product']['product_name'])), '/'.$this->Common->getProductUrl($pos1_dept_products[$w]['Product']['id']).'/categories/productdetail/'.$pos1_dept_products[$w]['Product']['id'],array('escape'=>false));
					unset($pos1_image_path1);?>
					</div>
					<!--Right COntent Start-->
					<div class="left-product-content">
						<ul class="pick-of-week-content">
							<li>
								<p><?php echo $html->link('<strong>'.$format->formatString($pos1_dept_products[$w]['Product']['product_name'],500).'</strong>','/'.$this->Common->getProductUrl($pos1_dept_products[$w]['Product']['id']).'/categories/productdetail/'.$pos1_dept_products[$w]['Product']['id'],array('escape'=>false));?></p>	
								<?php
								if(!empty($pos1_dept_products[$w]['Product']['minimum_price_value']) && $pos1_dept_products[$w]['Product']['minimum_price_value'] > 0){
									if($pos1_dept_products[$w]['Product']['product_rrp'] > $pos1_dept_products[$w]['Product']['minimum_price_value']){ //saving 
										$saving = ($pos1_dept_products[$w]['Product']['product_rrp'] - $pos1_dept_products[$w]['Product']['minimum_price_value']);
									}else{
										$saving = '';
									}
									//pr($pos1_dept_products[$w]);
									//exit;
									$delivery_charges = $common->getDeliveryCharges($pos1_dept_products[$w]['Product']['id'],$pos1_dept_products[$w]['Product']['minimum_price_seller'], $pos1_dept_products[$w]['Product']['new_condition_id']);
									if($delivery_charges != ''){
										if($delivery_charges == '0.00'){
											$delivery = 'Free Delivery';
										}else{
											$delivery = "+&nbsp;".CURRENCY_SYMBOL.$delivery_charges."&nbsp;delivery";
										}
									}
									//Check in stock
									$prodSellerInfo = $common->getProductSellerInfo($pos1_dept_products[$w]['Product']['id'] ,$pos1_dept_products[$w]['Product']['minimum_price_seller'], $pos1_dept_products[$w]['Product']['new_condition_id']);
									$prodStock = $prodSellerInfo['ProductSeller']['quantity'];
								?>
								<p class="rates" >
								<span class="rate larger-font"><strong><?php  echo CURRENCY_SYMBOL ;?><?php echo $format->money($pos1_dept_products[$w]['Product']['minimum_price_value'],2);  ?></strong></span>
								<span class="rate"><?php echo $delivery; ?></span>
								| RRP: <span class="yellow"><s><?php  echo CURRENCY_SYMBOL ;?><?php echo $format->money(@$pos1_dept_products[$w]['Product']['product_rrp'],2);?></s>
									<?php if(!empty($saving)){?>
									( <?php	  echo $format->money($saving/$pos1_dept_products[$w]['Product']['product_rrp']*100,2);?> %)
									<?php } ?>
									</span>
								</p>
								<?php
									if($prodStock > 0){?>
										<p>In stock <!--strong>New</strong--> | Usually dispatched within 24 hours</p>
										<div class="button-widget">
											<?php  echo $form->button('BUY',array('type'=>'button','class'=>'orange-btn','div'=>false,'escape'=>false,'onClick'=>'addToBasket('.$pos1_dept_products[$w]['Product']['id'].',1,'.$pos1_dept_products[$w]['Product']['minimum_price_value'].','.$pos1_dept_products[$w]['Product']['minimum_price_seller'].','.$pos1_dept_products[$w]['Product']['new_condition_id'].');'));?>
										</div>
										<?php }else{?>
											<p>Temporarily out of stock - more expected soon</p>
										<?php echo $html->link('<span class="link-btn">BUY</span>','javascript:void(0);',array('class'=>'ornge-btn display-daypick ornge-btn_disabled','escape'=>false));
										}
									?>
										
								
							<?php  } else if(!empty($pos1_dept_products[$w]['Product']['minimum_price_used']) && $pos1_dept_products[$w]['Product']['minimum_price_used'] > 0 ){
								
								if($pos1_dept_products[$w]['Product']['product_rrp'] > $pos1_dept_products[$w]['Product']['minimum_price_used']){ //saving 
									$saving = ($pos1_dept_products[$w]['Product']['product_rrp'] - $pos1_dept_products[$w]['Product']['minimum_price_used']);
								}else{
									$saving = '';
								}
								$delivery_charges = $common->getDeliveryCharges($pos1_dept_products[$w]['Product']['id'],$pos1_dept_products[$w]['Product']['minimum_price_used_seller'], $pos1_dept_products[$w]['Product']['used_condition_id']);
								if($delivery_charges != ''){
									if($delivery_charges == '0.00'){
										$delivery = 'Free Delivery';
									}else{
										$delivery = "+&nbsp;".CURRENCY_SYMBOL.$delivery_charges."&nbsp;delivery";
									}
								}
								//Check in stock
									$prodSellerInfo = $common->getProductSellerInfo($pos1_dept_products[$w]['Product']['id'],$pos1_dept_products[$w]['Product']['minimum_price_used_seller'], $pos1_dept_products[$w]['Product']['used_condition_id']);
									$prodStock = $prodSellerInfo['ProductSeller']['quantity'];
								?>
								<p class="rates">
								<span class="rate larger-font"><strong><?php  echo CURRENCY_SYMBOL ;?><?php echo $format->money($pos1_dept_products[$w]['Product']['minimum_price_used'],2);  ?></strong></span>
								<span class="rate"><?php echo $delivery; ?></span>
								| RRP: <span class="yellow"><s><?php  echo CURRENCY_SYMBOL ;?><?php echo $format->money($pos1_dept_products[$w]['Product']['product_rrp'],2);?></s>
									<?php if(!empty($saving)){?>
									(<?php	echo $format->money($saving/$pos1_dept_products[$w]['Product']['product_rrp']*100,2);?> %)
									<?php } ?>
									</span>
								</p>
								
							<?php
								if($prodStock > 0){?>
								<p>In stock <!--strong>Used</strong--> | Usually dispatched within 24 hours</p>
									<div class="button-widget float-left">
										<?php echo $form->button('BUY',array('type'=>'button','class'=>'orange-btn','div'=>false,'escape'=>false,'onClick'=>'addToBasket('.$pos1_dept_products[$w]['Product']['id'].',1,'.$pos1_dept_products[$w]['Product']['minimum_price_used'].','.$pos1_dept_products[$w]['Product']['minimum_price_used_seller'].','.$pos1_dept_products[$w]['Product']['used_condition_id'].');'));?>
									</div>
								<?php
								}else{
									echo $html->link('<span class="link-btn">BUY</span>','javascript:void(0);',array('class'=>'ornge-btn display-daypick ornge-btn_disabled','escape'=>false));
								}
							?>
							<?php  } else{ ?>
								<p class="rates">
								<span class="rate larger-font"><strong><?php  echo CURRENCY_SYMBOL ;?><?php echo $format->money($pos1_dept_products[$w]['Product']['product_rrp'],2);  ?></strong></span>
								</p>
								<p>Temporarily out of stock - more expected soon</p>
								<!--Button Start-->
								
								<?php echo $html->link('<span class="link-btn">BUY</span>','javascript:void(0);',array('class'=>'ornge-btn display-daypick ornge-btn_disabled','escape'=>false));?>
								
							<?php  }  ?>
							<!--Button Closed-->
							</li>
						</ul>
					</div>
					<!--Right COntent Start-->
					<div class="clear"></div>
					<p class="bottom-con">
					<?php echo $format->formatString(strip_tags(html_entity_decode($pos1_dept_products[$w]['ProductDetail']['description'])),120);?>
					<?php echo $html->link('<strong>more &raquo;</strong>','/'.$this->Common->getProductUrl($pos1_dept_products[$w]['Product']['id']).'/categories/productdetail/'.$pos1_dept_products[$w]['Product']['id'],array('escape'=>false,));?></p>
				</div>
			</div>
			<!--Column One Closed-->
			<?php }?>
			<?php }?>
		</div>
	</div>
</div>
<?php } /** ********************** DEPARTMENT 1 PRODUCTS  ENDS  ********************************/
/** ********************** NEWRELASE 2 PRODUCTS  STARTS  ********************************/ 
if(!empty($pos2_newreleases)){ ?>
<div class="row">
	<!--New Releases Start-->
	<h4 class="mid-gr-head">
		<span>New Releases</span>
	</h4>
	<!--Products Widget Start-->
	<div class="products-widget outerdiv_resolution ">
		<ul class="products">
			<?php //foreach($pos2_newreleases as $pos2_newreleases[$j]) {
				$max_count_pos2 = count($pos2_newreleases);
				$j1=1;
				for($j=0;$j<$max_count_pos2;$j++){
	
				if(!empty($pos2_newreleases[$j])){
					$image_path = WWW_ROOT.PATH_PRODUCT.'small/img_100_'.$pos2_newreleases[$j]['Product']['product_image'];
				if($pos2_newreleases[$j]['Product']['product_image'] != 'no_image.gif' && file_exists($image_path)  ){
					$image_path = '/'.PATH_PRODUCT.'small/img_100_'.$pos2_newreleases[$j]['Product']['product_image'];
				} else{
					$image_path = '/img/no_image_100.jpg';
				}
				
				$rating = $common->displayProductRating($pos2_newreleases[$j]['Product']['avg_rating'],$pos2_newreleases[$j]['Product']['id']);
			?>
			<li class="inner_div_resolution res<?php echo $j1;?>"><div style ="padding:10px 5px 0px 5px; min-height:190px;">
				<p class="image-sec" style="min-height:109px;">
					<?php echo $html->link($html->image($image_path,array('alt'=>$pos2_newreleases[$j]['Product']['product_name'], 'title'=>$pos2_newreleases[$j]['Product']['product_name'])), '/'.$this->Common->getProductUrl($pos2_newreleases[$j]['Product']['id']).'/categories/productdetail/'.$pos2_newreleases[$j]['Product']['id'],array('escape'=>false,));?>
				</p>
				<p  class="conti_shp_width">
					<?php echo $html->link($format->formatString($pos2_newreleases[$j]['Product']['product_name'],500),'/'.$this->Common->getProductUrl($pos2_newreleases[$j]['Product']['id']).'/categories/productdetail/'.$pos2_newreleases[$j]['Product']['id'],array('escape'=>false,));?>
				</p>
				<p class="star-rating">
					<span class="pad-rt pad-tp"><?php  echo $rating; ?></span>
					</p><p>
						
							<?php if(!empty($pos2_newreleases[$j]['Product']['minimum_price_value']) && $pos2_newreleases[$j]['Product']['minimum_price_value'] > 0){?>
							<strong>RRP: </strong><s><?php echo CURRENCY_SYMBOL.$format->money($pos2_newreleases[$j]['Product']['product_rrp'],2);?> </s>
							<?php }else{
								echo "<strong>RRP: </strong>".CURRENCY_SYMBOL.$format->money($pos2_newreleases[$j]['Product']['product_rrp'],2);
							} ?>
						
					
				</p>
				<?php
				if(!empty($pos2_newreleases[$j]['Product']['minimum_price_value']) && $pos2_newreleases[$j]['Product']['minimum_price_value'] > 0){ 
					echo '<p><span class="price-blue_new">Buy new:</span> <span class="price">';
					echo CURRENCY_SYMBOL.$format->money($pos2_newreleases[$j]['Product']['minimum_price_value'],2);
					echo '</span></p>';
				}
				if(!empty($pos2_newreleases[$j]['Product']['minimum_price_used']) && $pos2_newreleases[$j]['Product']['minimum_price_used'] > 0 ){
					echo '<p><span class="price-blue_new">Buy used:</span> <span class="price">';
					echo CURRENCY_SYMBOL.$format->money($pos2_newreleases[$j]['Product']['minimum_price_used'],2);
					echo '</span></p>';
				} ?>
			</div></li>
			<?php }
			$j1++;
			}?>
		</ul>
	</div>
	<!--Products Widget Closed-->
	<!--New Releases Closed-->
</div>
<?php } /** ********************** NEWRELASE 2 PRODUCTS  ENDS HERER********************************/
 /** ********************** DEPARTMENT 2 PRODUCTS  STARTS  ********************************/ 
if(!empty($pos2_dept_products)) {?>
<div class="row">
	<div class="pick-of-week">
		<h2 class="heading" style="position:relative;">
		<?php
		if(!empty($hm_products['HomepageProduct']['heading2']) ){
			if($hm_products['HomepageProduct']['department_id'] == 0){
				 echo $departments[$hm_products['HomepageProduct']['heading2']];
			}else{
				if(isset($topCategoryArr) ) {
					echo $topCategoryArr[$hm_products['HomepageProduct']['heading2']];
				}
			}
		}
		
		if($controller_name == 'homes'){
			$dept_url_name = str_replace(array('&',' '), array('and','-'), html_entity_decode($departments[$hm_products['HomepageProduct']['heading2']], ENT_NOQUOTES, 'UTF-8'));
		}else{
			$cat_url_name = str_replace(array('&',' '), array('and','-'), html_entity_decode($topCategoryArr[$hm_products['HomepageProduct']['heading2']], ENT_NOQUOTES, 'UTF-8'));
			
			$dept_url_name = str_replace(array('&',' '), array('and','-'), html_entity_decode($department_name, ENT_NOQUOTES, 'UTF-8'));
			
			$dept_url_name = $dept_url_name.'/'.$cat_url_name;
		}
		
		?>
		
				
		<?php echo $html->link('home  &raquo;','/'.$dept_url_name.'/'.$link_home.$hm_products['HomepageProduct']['heading2'],array('escape'=>false,'class'=>'h2link'))?></h2>
		<div class="products-widget outerdiv_resolution inner_2div_resolution-height">
			<!--Column One Start-->
			<?php 
			$count_dept_pos2 = count($pos2_dept_products);
			for($w = 0;$w<$count_dept_pos2; $w++) {
			if(!empty($pos2_dept_products[$w])) { ?>
			
 			<div class="inner_2div_resolution">
				<div class="colum-one" style="width:98%">
					<div class="left-product-img">
						<?php 
						if($pos2_dept_products[$w]['Product']['product_image'] == 'no_image.gif' || $pos2_dept_products[$w]['Product']['product_image'] == 'no_image.jpeg'){
							$pos2_image_path1 = '/img/no_image.jpeg';
						} else{
							$pos2_image_path1 = WWW_ROOT.PATH_PRODUCT.'/small/img_100_'.$pos2_dept_products[$w]['Product']['product_image'];
							
							if(!file_exists($pos2_image_path1) ){
								$pos2_image_path1 = '/img/no_image_100.jpg';
							}else{
								$pos2_image_path1 = '/'.PATH_PRODUCT.'/small/img_100_'.$pos2_dept_products[$w]['Product']['product_image'];
							}
							
						}
						echo $html->link($html->image($pos2_image_path1,array('alt'=>$pos2_dept_products[$w]['Product']['product_name'],'title'=>$pos2_dept_products[$w]['Product']['product_name'])), '/'.$this->Common->getProductUrl($pos2_dept_products[$w]['Product']['id']).'/categories/productdetail/'.$pos2_dept_products[$w]['Product']['id'],array('escape'=>false,));?>
					</div>
					<!--Right COntent Start-->
					<div class="left-product-content">
						<ul class="pick-of-week-content">
							<li>
								<p><?php echo $html->link('<strong>'.$format->formatString($pos2_dept_products[$w]['Product']['product_name'],500).'</strong>','/'.$this->Common->getProductUrl($pos2_dept_products[$w]['Product']['id']).'/categories/productdetail/'.$pos2_dept_products[$w]['Product']['id'],array('escape'=>false,));?></p>	
								<?php  if(!empty($pos2_dept_products[$w]['Product']['minimum_price_value']) ){
									if($pos2_dept_products[$w]['Product']['product_rrp'] > $pos2_dept_products[$w]['Product']['minimum_price_value']){ //saving 
										$saving = ($pos2_dept_products[$w]['Product']['product_rrp'] - $pos2_dept_products[$w]['Product']['minimum_price_value']);
									}else{
										$saving = '';
									}
									$delivery_charges = $common->getDeliveryCharges($pos2_dept_products[$w]['Product']['id'],$pos2_dept_products[$w]['Product']['minimum_price_seller'], $pos2_dept_products[$w]['Product']['new_condition_id']);
									if($delivery_charges != ''){
										if($delivery_charges == '0.00'){
											$delivery = 'Free Delivery';
										}else{
											$delivery = "+&nbsp;".CURRENCY_SYMBOL.$delivery_charges."&nbsp;delivery";
										}
									}
									//Check in stock
									$prodSellerInfo = $common->getProductSellerInfo($pos2_dept_products[$w]['Product']['id'],$pos2_dept_products[$w]['Product']['minimum_price_seller'], $pos2_dept_products[$w]['Product']['new_condition_id']);
									$prodStock = $prodSellerInfo['ProductSeller']['quantity'];
								?>
								<p class="rates" >
								<span class="rate larger-font"><strong><?php  echo CURRENCY_SYMBOL ;?><?php echo $format->money($pos2_dept_products[$w]['Product']['minimum_price_value'],2);  ?></strong></span>
								<span class="rate"><?php echo $delivery; ?></span>
								| RRP: <span class="yellow"><s><?php  echo CURRENCY_SYMBOL ;?><?php echo $format->money($pos2_dept_products[$w]['Product']['product_rrp'],2);?></s>
									<?php if(!empty($saving)){?>
									( <?php	  echo $format->money($saving/$pos2_dept_products[$w]['Product']['product_rrp']*100,2);?> %)
									<?php } ?>
									</span>
								</p>
								<?php if($prodStock > 0){?>
								<p>In stock | Usually dispatched within 24 hours</p>
								<?php } else{?>
								<p>Temporarily out of stock - more expected soon</p>
								<?php } ?>
								<?php if($prodStock > 0){?>
										<div class="button-widget float-left" >
										<?php echo $form->button('BUY',array('type'=>'button','class'=>'orange-btn','div'=>false,'escape'=>false,'onClick'=>'addToBasket('.$pos2_dept_products[$w]['Product']['id'].',1,'.$pos2_dept_products[$w]['Product']['minimum_price_value'].','.$pos2_dept_products[$w]['Product']['minimum_price_seller'].','.$pos2_dept_products[$w]['Product']['new_condition_id'].');'));?>
										</div>
								<?php
									}else{
										echo $html->link('<span class="link-btn">BUY</span>','javascript:void(0);',array('class'=>'ornge-btn display-daypick ornge-btn_disabled','escape'=>false));
									}
								?>
								
								
								<?php  } else if(!empty($pos2_dept_products[$w]['Product']['minimum_price_used']) ){
									
									if($pos2_dept_products[$w]['Product']['product_rrp'] > $pos2_dept_products[$w]['Product']['minimum_price_used']){ //saving 
										$saving = ($pos2_dept_products[$w]['Product']['product_rrp'] - $pos2_dept_products[$w]['Product']['minimum_price_used']);
									}else{
										$saving = '';
									}
									$delivery_charges = $common->getDeliveryCharges($pos2_dept_products[$w]['Product']['id'],$pos2_dept_products[$w]['Product']['minimum_price_used_seller'], $pos2_dept_products[$w]['Product']['used_condition_id']);
									if($delivery_charges != ''){
										if($delivery_charges == '0.00'){
											$delivery = 'Free Delivery';
										}else{
											$delivery = "+&nbsp;".CURRENCY_SYMBOL.$delivery_charges."&nbsp;delivery";
										}
									}
									//Check in stock
									$prodSellerInfo = $common->getProductSellerInfo($pos2_dept_products[$w]['Product']['id'],$pos2_dept_products[$w]['Product']['minimum_price_used_seller'], $pos2_dept_products[$w]['Product']['used_condition_id']);
									$prodStock = $prodSellerInfo['ProductSeller']['quantity'];
									?>
									<p class="rates">
									<span class="rate larger-font"><strong><?php  echo CURRENCY_SYMBOL ;?><?php echo $format->money($pos2_dept_products[$w]['Product']['minimum_price_used'],2);  ?></strong></span>
									<span class="rate"><?php echo $delivery; ?></span>
									| RRP: <span class="yellow"><s><?php  echo CURRENCY_SYMBOL ;?><?php echo $format->money($pos2_dept_products[$w]['Product']['product_rrp'],2);?></s>
										<?php if(!empty($saving)){?>
										( <?php	  echo $format->money($saving/$pos2_dept_products[$w]['Product']['product_rrp']*100,2);?> %)
										<?php } ?>
										</span>
									</p>
									<p>In stock | Usually dispatched within 24 hours</p>
									
									<?php
										if($prodStock > 0){?>
											<div class="button-widget float-left">
											<?php echo $form->button('BUY',array('type'=>'button','class'=>'orange-btn','div'=>false,'escape'=>false,'onClick'=>'addToBasket('.$pos2_dept_products[$w]['Product']['id'].',1,'.$pos2_dept_products[$w]['Product']['minimum_price_used'].','.$pos2_dept_products[$w]['Product']['minimum_price_used_seller'].','.$pos2_dept_products[$w]['Product']['used_condition_id'].');'));?>
											</div>
										<?php }else{
											echo $html->link('<span class="link-btn">BUY</span>','javascript:void(0);',array('class'=>'ornge-btn display-daypick ornge-btn_disabled','escape'=>false));
										}
									?>
									
								<?php  } else{ ?>
									<p class="rates">
									<span class="rate larger-font"><strong><?php  echo CURRENCY_SYMBOL ;?><?php echo $format->money($pos2_dept_products[$w]['Product']['product_rrp'],2);  ?></strong></span>
									</p>
									<p>Temporarily out of stock - more expected soon</p>
									<!--Button Start-->
									<?php echo $html->link('<span class="link-btn">BUY</span>','javascript:void(0);',array('class'=>'ornge-btn display-daypick ornge-btn_disabled','escape'=>false));?>
								<?php  }  ?>
								<!--Button Closed-->
							</li>
						</ul>
					</div>
					<!--Right COntent Start-->
					<div class="clear"></div>
					<p class="bottom-con">
					<?php echo $format->formatString(strip_tags(html_entity_decode($pos2_dept_products[$w]['ProductDetail']['description'])),120);?>
					<?php echo $html->link('<strong>more &raquo;</strong>','/'.$this->Common->getProductUrl($pos2_dept_products[$w]['Product']['id']).'/categories/productdetail/'.$pos2_dept_products[$w]['Product']['id'],array('escape'=>false,));?></p>
				</div>
			</div>
			<!--Column One Closed-->
			<?php }?>
			<?php }?>
		</div>
	</div>
</div>
<?php } /** ********************** DEPARTMENT 2 PRODUCTS  ENDS  ********************************/
/** ********************** NEWRELASE 3 PRODUCTS  STARTS********************************/ 
if(!empty($pos3_newreleases)){
?>
<div class="row">
	<!--New Releases Start-->
	<h4 class="mid-gr-head">
		<span>New Releases</span>
	</h4>
	<!--Products Widget Start-->
	<div class="products-widget outerdiv_resolution">
		<ul class="products">
			<?php //foreach($pos3_newreleases as $pos3_newreleases[$k]) {
			$max_count_pos3 = count($pos3_newreleases);
			$k1=1;
			for($k=0; $k<$max_count_pos3; $k++){
				if(!empty($pos3_newreleases[$k])){
				if($pos3_newreleases[$k]['Product']['product_image'] == 'no_image.gif' || $pos3_newreleases[$k]['Product']['product_image'] == 'no_image.jpeg'){
					$image_path = '/img/no_image.jpeg';
				} else{
					$image_path = WWW_ROOT.PATH_PRODUCT.'small/img_100_'.$pos3_newreleases[$k]['Product']['product_image'];
				
					if(!file_exists($image_path) ){
						$image_path = '/img/no_image_100.jpg';
					}else{
						$image_path = '/'.PATH_PRODUCT.'small/img_100_'.$pos3_newreleases[$k]['Product']['product_image'];
					}
				}
				$rating = $common->displayProductRating($pos3_newreleases[$k]['Product']['avg_rating'],$pos3_newreleases[$k]['Product']['id']);
			?>
			<li class="inner_div_resolution res<?php echo $k1;?>"><div style ="padding:10px 5px 0px 5px; min-height:190px;">
				<p class="image-sec" style="min-height:103px;">
					<?php echo $html->link($html->image($image_path,array('alt'=>$pos3_newreleases[$k]['Product']['product_name'],'title'=>$pos3_newreleases[$k]['Product']['product_name'])), '/'.$this->Common->getProductUrl($pos3_newreleases[$k]['Product']['id']).'/categories/productdetail/'.$pos3_newreleases[$k]['Product']['id'],array('escape'=>false,));?>
				</p>
				<p  class="conti_shp_width">
				<?php echo $html->link($format->formatString($pos3_newreleases[$k]['Product']['product_name'],500),'/'.$this->Common->getProductUrl($pos3_newreleases[$k]['Product']['id']).'/categories/productdetail/'.$pos3_newreleases[$k]['Product']['id'],array('escape'=>false,));?>
				</p>
				<p class="star-rating">
					<span class="pad-rt pad-tp"><?php  echo $rating; ?></span>
					</p><p>
						
							<?php if(!empty($pos3_newreleases[$k]['Product']['minimum_price_value']) && $pos3_newreleases[$k]['Product']['minimum_price_value'] > 0){ ?>
							<strong>RRP: </strong><s><?php echo CURRENCY_SYMBOL.$format->money($pos3_newreleases[$k]['Product']['product_rrp'],2);?> </s>
							<?php }else{
								echo "<strong>RRP: </strong>". CURRENCY_SYMBOL.$format->money($pos3_newreleases[$k]['Product']['product_rrp'],2);
							}?>
						
					
				</p>
				<?php
				if(!empty($pos3_newreleases[$k]['Product']['minimum_price_value']) && $pos3_newreleases[$k]['Product']['minimum_price_value'] > 0){ 
					echo '<p><span class="price-blue_new">Buy new:</span> <span class="price">';
					echo CURRENCY_SYMBOL.$format->money($pos3_newreleases[$k]['Product']['minimum_price_value'],2);
					echo '</span></p>';
				}
				if(!empty($pos3_newreleases[$k]['Product']['minimum_price_used']) && $pos3_newreleases[$k]['Product']['minimum_price_used'] > 0 ){
					echo '<p><span class="price-blue_new">Buy used:</span> <span class="price">';
					echo CURRENCY_SYMBOL.$format->money($pos3_newreleases[$k]['Product']['minimum_price_used'],2);
					echo '</span></p>';
				} ?>
				
			</div></li>
			<?php }
			$k1++;
			}?>
		</ul>
	</div>
	<!--Products Widget Closed-->
	<!--New Releases Closed-->
</div>
<?php } /** ********************** NEWRELASE 3 PRODUCTS  ENDS HERER********************************/
/** ********************** DEPARTMENT 3 PRODUCTS  STARTS ********************************/ ?>
<?php
if(!empty($pos3_dept_products)) {?>
<!--Home & Garden Start-->
<div class="row">
	
	<h2 class="heading" style="position:relative;">
		<?php
		if(!empty($hm_products['HomepageProduct']['heading3']) ){
			if($hm_products['HomepageProduct']['department_id'] == 0){
				 echo $departments[$hm_products['HomepageProduct']['heading3']];
			}else{
				if(isset($topCategoryArr) ) {
					echo $topCategoryArr[$hm_products['HomepageProduct']['heading3']];
				}
			}
		}
		
		if($controller_name == 'homes'){
			$dept_url_name = str_replace(array('&',' '), array('and','-'), html_entity_decode($departments[$hm_products['HomepageProduct']['heading3']], ENT_NOQUOTES, 'UTF-8'));
		}else{
			$cat_url_name = str_replace(array('&',' '), array('and','-'), html_entity_decode($topCategoryArr[$hm_products['HomepageProduct']['heading3']], ENT_NOQUOTES, 'UTF-8'));
			
			$dept_url_name = str_replace(array('&',' '), array('and','-'), html_entity_decode($department_name, ENT_NOQUOTES, 'UTF-8'));
			
			$dept_url_name = $dept_url_name.'/'.$cat_url_name;
		}
		
		
		?>
		<?php echo $html->link('home &raquo;','/'.$dept_url_name.'/'.$link_home.$hm_products['HomepageProduct']['heading3'],array('escape'=>false,'class'=>'h2link'))?>
	</h2>
	<!--Products Widget Start-->
	<div class="products-widget outerdiv_resolution">
		<ul class="products">
			<?php //foreach($pos3_dept_products[$x]s as $pos3_dept_products[$x]){ 
			$count_dept_pos3 = count($pos3_dept_products);
			$x1=1;
				for($x=0; $x<$count_dept_pos3; $x++){
				if(!empty($pos3_dept_products[$x])){
			?>
			
			<li class="inner_div_resolution res<?php echo $x1;?>"><div style ="padding:10px 5px 0px 5px; min-height:190px;">
				<p class="image-sec" style="height:109px;"><?php 
					if($pos3_dept_products[$x]['Product']['product_image'] == 'no_image.gif' || $pos3_dept_products[$x]['Product']['product_image'] == 'no_image.jpeg'){
						$pos3_image_path = '/img/no_image.jpeg';
					} else{
						$pos3_image_path = WWW_ROOT.PATH_PRODUCT.'small/img_100_'.$pos3_dept_products[$x]['Product']['product_image'];
						
						if(!file_exists($pos3_image_path) ){
							$pos3_image_path = '/img/no_image_100.jpg';
						}else{
							$pos3_image_path = '/'.PATH_PRODUCT.'small/img_100_'.$pos3_dept_products[$x]['Product']['product_image'];
						}
					}
					$pos3_imagePath = WWW_ROOT.$pos3_image_path;
				$rating = $common->displayProductRating($pos3_dept_products[$x]['Product']['avg_rating'],$pos3_dept_products[$x]['Product']['id']);				
				echo $html->link($html->image($pos3_image_path,array('alt'=>$pos3_dept_products[$x]['Product']['product_name'],'title'=>$pos3_dept_products[$x]['Product']['product_name'])), '/'.$this->Common->getProductUrl($pos3_dept_products[$x]['Product']['id']).'/categories/productdetail/'.$pos3_dept_products[$x]['Product']['id'],array('escape'=>false,));?></p>
				<p  class="conti_shp_width">
				<?php echo $html->link($format->formatString($pos3_dept_products[$x]['Product']['product_name'],500),'/'.$this->Common->getProductUrl($pos3_dept_products[$x]['Product']['id']).'/categories/productdetail/'.$pos3_dept_products[$x]['Product']['id'],array('escape'=>false,));?></p>
				
				
				<p class="star-rating">
					<span class="pad-rt pad-tp"><?php  echo $rating; ?></span>
					</p><p>
						
						<?php if(!empty($pos3_dept_products[$x]['Product']['minimum_price_value']) && $pos3_dept_products[$x]['Product']['minimum_price_value'] > 0){ ?>
							<strong>RRP: </strong> <s><?php echo CURRENCY_SYMBOL.$format->money($pos3_dept_products[$x]['Product']['product_rrp'],2);?> </s>
						<?php }else{
							"<strong>RRP: </strong>".CURRENCY_SYMBOL.$format->money($pos3_dept_products[$x]['Product']['product_rrp'],2);
						}
						?>
						
					
				</p>
				<?php
				if(!empty($pos3_dept_products[$x]['Product']['minimum_price_value']) && $pos3_dept_products[$x]['Product']['minimum_price_value'] > 0){ 
					echo '<p><span class="price-blue_new">Buy new:</span> <span class="price">';
					echo CURRENCY_SYMBOL.$format->money($pos3_dept_products[$x]['Product']['minimum_price_value'],2);
					echo '</span></p>';
				}
				if(!empty($pos3_dept_products[$x]['Product']['minimum_price_used']) && $pos3_dept_products[$x]['Product']['minimum_price_used'] > 0){
					echo '<p><span class="price-blue_new">Buy used:</span> <span class="price">';
					echo CURRENCY_SYMBOL.$format->money($pos3_dept_products[$x]['Product']['minimum_price_used'],2);
					echo '</span></p>';
				} ?>
				
			</div>
			</li>
			<?php }
			$x1++;
			}?>
		</ul>
		
	</div>
	<!--Products Widget Closed-->
</div>
<!--Home & Garden Closed-->
<?php } ?>
<?php /** ********************** DEPARTMENT 3 PRODUCTS  ENDS **********************************/ ?>


<?php /** ********************** DEPARTMENT 4 PRODUCTS  STARTS ********************************/ ?>
<?php
if(!empty($pos4_dept_products)) {?>
<!--Home & Garden Start-->
<div class="row">

	<h2 class="heading" style="position:relative;">
		<?php
		if(!empty($hm_products['HomepageProduct']['heading4']) ){
			if($hm_products['HomepageProduct']['department_id'] == 0){
				 echo $departments[$hm_products['HomepageProduct']['heading4']];
			}else{
				if(isset($topCategoryArr) ) {
					echo $topCategoryArr[$hm_products['HomepageProduct']['heading4']];
				}
			}
		}
		
		if($controller_name == 'homes'){
			$dept_url_name = str_replace(array('&',' '), array('and','-'), html_entity_decode($departments[$hm_products['HomepageProduct']['heading4']], ENT_NOQUOTES, 'UTF-8'));
		}else{
			$cat_url_name = str_replace(array('&',' '), array('and','-'), html_entity_decode($topCategoryArr[$hm_products['HomepageProduct']['heading4']], ENT_NOQUOTES, 'UTF-8'));
			
			$dept_url_name = str_replace(array('&',' '), array('and','-'), html_entity_decode($department_name, ENT_NOQUOTES, 'UTF-8'));
			
			$dept_url_name = $dept_url_name.'/'.$cat_url_name;
		}
		
		?><?php echo $html->link('home &raquo;','/'.$dept_url_name.'/'.$link_home.$hm_products['HomepageProduct']['heading4'],array('escape'=>false,'class'=>'h2link'))?>
	</h2>
	<!--Products Widget Start-->
	<div class="products-widget outerdiv_resolution">
		
		<ul class="products">
			<?php //foreach($pos4_dept_products[$y]s as $pos4_dept_products[$y]){
			$count_dept_pos4 = count($pos4_dept_products);
			$y1=1;
			for($y=0; $y<$count_dept_pos4; $y++){
				if(!empty($pos4_dept_products[$y])){
			?>
			<li class="inner_div_resolution res<?php echo $y1;?>"><div style ="padding:10px 5px 0px 5px; min-height:190px;">
				<p class="image-sec" style="height:109px;"><?php 
					if($pos4_dept_products[$y]['Product']['product_image'] == 'no_image.gif' || $pos4_dept_products[$y]['Product']['product_image'] == 'no_image.jpeg'){
						$pos3_image_path = '/img/no_image.jpeg';
					} else{
						$pos3_image_path = WWW_ROOT.PATH_PRODUCT.'small/img_100_'.$pos4_dept_products[$y]['Product']['product_image'];
						
						if(!file_exists($pos3_image_path) ){
							$pos3_image_path = '/img/no_image_100.jpg';
						}else{
							$pos3_image_path = '/'.PATH_PRODUCT.'small/img_100_'.$pos4_dept_products[$y]['Product']['product_image'];
						}
					}
					$pos3_imagePath = WWW_ROOT.$pos3_image_path;
					$rating = $common->displayProductRating($pos4_dept_products[$y]['Product']['avg_rating'],$pos4_dept_products[$y]['Product']['id']);
					echo $html->link($html->image($pos3_image_path,array('alt'=>$pos4_dept_products[$y]['Product']['product_name'], 'title'=>$pos4_dept_products[$y]['Product']['product_name'])), '/'.$this->Common->getProductUrl($pos4_dept_products[$y]['Product']['id']).'/categories/productdetail/'.$pos4_dept_products[$y]['Product']['id'],array('escape'=>false,));?></p>
				<p  class="conti_shp_width"><?php echo $html->link($format->formatString($pos4_dept_products[$y]['Product']['product_name'],500),'/'.$this->Common->getProductUrl($pos4_dept_products[$y]['Product']['id']).'/categories/productdetail/'.$pos4_dept_products[$y]['Product']['id'],array('escape'=>false,));?></p>
				<p class="star-rating">
					<span class="pad-rt pad-tp"><?php  echo $rating; ?></span>
					</p><p>
						
							<?php if((!empty($pos4_dept_products[$y]['Product']['minimum_price_value']) && ($pos4_dept_products[$y]['Product']['minimum_price_value'] > 0)) || (!empty($pos4_dept_products[$y]['Product']['minimum_price_used']) && ($pos4_dept_products[$y]['Product']['minimum_price_used'] > 0))){ ?>
								<strong>RRP: </strong> <s><?php echo CURRENCY_SYMBOL.$format->money($pos4_dept_products[$y]['Product']['product_rrp'],2);?> </s>
							<?php }else{
								echo "<strong>RRP: </strong>".CURRENCY_SYMBOL.$format->money($pos4_dept_products[$y]['Product']['product_rrp'],2);
							}?>
						
					
				</p>
					<?php
					if(!empty($pos4_dept_products[$y]['Product']['minimum_price_value']) && $pos4_dept_products[$y]['Product']['minimum_price_value'] > 0 ){ 
						echo '<p><span class="price-blue_new">Buy new:</span> <span class="price">';
						echo CURRENCY_SYMBOL.$format->money($pos4_dept_products[$y]['Product']['minimum_price_value'],2);
						echo '</span></p>';
					}
					if(!empty($pos4_dept_products[$y]['Product']['minimum_price_used']) && $pos4_dept_products[$y]['Product']['minimum_price_used'] > 0 ){
						echo '<p><span class="price-blue_new">Buy used:</span> <span class="price">';
						echo CURRENCY_SYMBOL.$format->money($pos4_dept_products[$y]['Product']['minimum_price_used'],2);
						echo '</span></p>';
					} ?>
				
			</div></li>
			<?php }
			$y1++;
			}?>
		</ul>
		
	</div>
	<!--Products Widget Closed-->
</div>
<!--Home & Garden Closed-->
<?php }
/** ********************* DEPARTMENT 4 PRODUCTS  ENDS **********************************/ ?>