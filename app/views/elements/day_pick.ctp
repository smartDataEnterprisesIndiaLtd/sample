<?php
echo $javascript->link(array('jquery-ui.min'));
App::import('Sanitize');
if(count($dayPicksProduct) > 0){
	foreach( $dayPicksIds as $dayPicksId){
		if(isset($dayPicksProduct[$dayPicksId])){
			 $pickDayProducts[] = $dayPicksProduct[$dayPicksId];
		}		
	}
}
?>
<style>
#featured .ui-tabs-hide{ 
	display:none; 
}
.ui-tabs-nav{padding-bottom:10px; text-align:right; float:right; color:#555555;}
.ui-tabs-nav li{background:#f8f8f8; float:left; display:inline-block; border:1px #cccccc solid; padding:3px 8px; color:#555555; font-weight:bold; text-decoration:none; margin:0px;}
.ui-tabs-nav li.ui-tabs-nav-item a:hover{ 
	background:#828284; color:#555555;
}
.ui-tabs-nav li.ui-tabs-selected{ 
	background:#828284; color:#ffffff;} 
}
.ui-tabs-nav ul.ui-tabs-nav li.ui-tabs-selected a{ 
	background:#ccc;  color:#555555;
}
.gray-color-nav{  color:#555555;}
.ui-tabs-nav li.ui-tabs-selected a{ 

	color:#ffffff!important;
}
</style>

<script type="text/javascript">
	jQuery.noConflict();
	jQuery(document).ready(function(){
	jQuery("#featured > ul").tabs({fx:{opacity: "toggle"}}).tabs("rotate", 5000, true);  
	jQuery("#feadtured_slideshow_stop").click(  
		function() {
			var stopval = jQuery("#feadtured_slideshow_stop").html();
			if(stopval == '||'){
				jQuery("#featured > ul").tabs("rotate",0,true);
				jQuery("#feadtured_slideshow_stop").html('>');	
			}else{
				jQuery("#featured > ul").tabs("rotate",5000,true);
				jQuery("#feadtured_slideshow_stop").html('||');
			}
		},
		function() {
			jQuery("#featured > ul").tabs("rotate",5000,true);  
		}
	);
	});
</script>
<?php
#################################################################################
if(!empty($pickDayProducts)){
?>
<!--Pick of the Week Start-->
<div class="pick-of-week" style="height:207px">
	<h4 class="mid-gr-head"><span>Pick of the day</span></h4>
	<div id="pick-of-day">
		<div class="products-widget" id="featured">
			<?php
			$paging_count = array();
			if(!empty($pickDayProducts)){
			foreach ($pickDayProducts as $keyId=>$productArr){
				$paging_count[] = $keyId; // for navigation tabs
				$keyId++;
				if($productArr['Product']['product_image'] == 'no_image.gif' || $productArr['Product']['product_image'] == 'no_image.jpeg'){
					$image_path = '/img/no_image.jpeg';
				} else{
					$image_path = WWW_ROOT.PATH_PRODUCT.'small/img_100_'.$productArr['Product']['product_image'];
					if(!file_exists($image_path) ){
						$image_path = '/img/no_image_100.jpg';
					}else{
						$image_path = '/'.PATH_PRODUCT.'small/img_100_'.$productArr['Product']['product_image'];
					}
				}
				if($keyId == 1){
					$main_div_class = 'ui-tabs-panel';
				} else{
					$main_li_class = 'ui-tabs-panel ui-tabs-hide';
				}
				
				?>
			<div id="fragment-<?php echo $keyId;?>" class="<?php echo $main_div_class; ?>" >
				<div class="left-pro-img">
					<?php echo $html->link($html->image($image_path , array('alt'=>$productArr['Product']['product_name'], 'title'=>$productArr['Product']['product_name'])), '/'.$this->Common->getProductUrl($productArr['Product']['id']).'/categories/productdetail/'.$productArr['Product']['id'],array('escape'=>false,));?>
				</div>
				<!--Product Content Start-->
				<div class="left-pro-content">
					<ul class="pick-of-week-content">
						<li>
							<p><?php echo $html->link('<b>'.$productArr['Product']['product_name'].'</b>','/'.$this->Common->getProductUrl($productArr['Product']['id']).'/categories/productdetail/'.$productArr['Product']['id'],array('escape'=>false, 'class'=>''));?></p>
							<p id="short_desc" style="min-height:35px;"><?php echo $format->formatString(strip_tags(html_entity_decode($productArr['ProductDetail']['description'])),300);?>
							</p>
							<p id="more_link">
							<strong><?php echo $html->link('<strong>more &raquo;</strong>','/'.$this->Common->getProductUrl($productArr['Product']['id']).'/categories/productdetail/'.$productArr['Product']['id'],array('onClick'=>'','escape'=>false,));?></strong>
							</p>
						</li>
						<li>
							<?php
								if(!empty($productArr['Product']['minimum_price_value']) ){
									
									$dPrice 	= $productArr['Product']['minimum_price_value'];
									$dSeller_id 	= $productArr['Product']['minimum_price_seller'];
									$dCondition_id 	= $productArr['Product']['new_condition_id'];
									$prodCond 	= 'New';	 
									
								}else if(!empty($productArr['Product']['minimum_price_used']) ){
									$dPrice 	= $productArr['Product']['minimum_price_used'];
									$dSeller_id 	= $productArr['Product']['minimum_price_used_seller'];
									$dCondition_id 	= $productArr['Product']['used_condition_id'];
									$prodCond 	= 'Used';
								}else{
									$dPrice = $productArr['Product']['product_rrp'];
									$dSeller_id = 0;
								}
								
							if( !empty($dSeller_id) && $dSeller_id > 0){ //  seller existes for this  product
								
								$prodSellerInfo = $common->getProductSellerInfo($productArr['Product']['id'] ,$dSeller_id, $dCondition_id);
								$prodStock = $prodSellerInfo['ProductSeller']['quantity'];
								
								if($productArr['Product']['product_rrp'] > $dPrice  ){
									$saving = $productArr['Product']['product_rrp'] - $dPrice ;
								}else{
									$saving = '';
								}
								?>
								
								<p class="rates">
								<span class="rate larger-font"><strong><?php  echo CURRENCY_SYMBOL ;?><?php echo $format->money($dPrice,2);  ?></strong></span>
								| RRP: <span class="yellow"><s><?php  echo CURRENCY_SYMBOL ;?><?php echo $format->money($productArr['Product']['product_rrp'],2);?></s>
									<?php if(!empty($saving)){?>
									| You save:  <?php  echo CURRENCY_SYMBOL ;?><?php echo $format->money($saving,2);?>
									( <?php	  echo $format->money($saving/$productArr['Product']['product_rrp']*100,2);?> %)
									<?php } ?>
									</span>
								</p>
								<?php if($prodStock > 0){ 
									
									echo '<p>In stock <strong>'.$prodCond.'</strong> | Usually dispatched within 24 hours</p>';
									echo $html->link('<span class="link-btn">BUY</span>','javascript:void(0)',array('class'=>'ornge-btn display-daypick','escape'=>false,'style'=>'','onClick'=>'addToBasket('.$productArr['Product']['id'].',1,'.$dPrice.','.$dSeller_id.','.$dCondition_id.');')); 
									
								}else{
									echo '<p>Temporarily out of stock -more expected soon <strong>'.$prodCond.'</strong> | Usually dispatched within 24 hours</p>';
									echo $html->link('<span class="link-btn">BUY</span>','javascript:void(0);',array('class'=>'ornge-btn display-daypick ornge-btn_disabled','escape'=>false, 'style'=>'cursor:default;margin-left:10px;'));
									
								} ?>
								
							<?php }else{  // seller does not exists for this seller ?>
								
								<p class="rates">
								<span class="rate larger-font"><strong><?php  echo CURRENCY_SYMBOL ;?><?php echo $format->money($productArr['Product']['product_rrp'],2);  ?></strong></span>
								</p>
								<?php echo $html->link('<span class="link-btn">BUY</span>','javascript:void(0);',array('class'=>'ornge-btn display-daypick ornge-btn_disabled','escape'=>false,'style'=>'cursor:default'));?>
						
								
							<?php } ?>
							<!--Button Start-->
							<!--Button Closed-->
						</li>
					</ul>
				</div>
			</div>
			<?php  } }?>
			<?php
			if(!empty($paging_count)){  ?>
			<!--Product Content Closed-->
			<ul class="ui-tabs-nav" >
			<?php foreach ($paging_count as $key=>$val){
				$key++;
				if($key == 1){
					$main_li_class = '';
				} else{
					$main_li_class = '';
				}
				?>
				<li class="<?php echo $main_li_class;?>" id="nav-fragment-<?php echo $key;?>">
					<a href="#fragment-<?php echo $key;?>" class="gray-color-nav" ><?php  echo $key;?></a>
				</li>
				
			<?php }  ?>
				<li>
					<span  style="cursor:pointer; font-style:bold;" id="feadtured_slideshow_stop">||</span>
				</li>
			</ul>
			<?php }?>
		</div>
	</div>
</div>
<?php }?>