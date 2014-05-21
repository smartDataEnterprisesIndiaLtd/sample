<style>
a.ornge-btn_disabled span { cursor: default!important; }
</style>
<?php
/*==== Oct.29 ====*/
$reviewInSession = @$_SESSION["FromEmailLink"];

if(!empty($_SESSION['User']['id']))
	$link_popup = '/reviews/add/'.$this->params['pass'][0];
else
	$link_popup = '/users/sign_in/';
/*=================*/

echo $javascript->link(array('lib/prototype'),false);
e($html->script('fancybox/jquery.fancybox-1.3.4.pack'));
e($html->script('fancybox/jquery.easing-1.3.pack'));
e($html->script('fancybox/jquery.mousewheel-3.0.4.pack',false));
echo $html->css('jquery.fancybox-1.3.4');
//echo $html->css('front_popup');
	//pr($product_details) ;
	if(empty($product_details['Product']['minimum_price_value']) ){
		$product_details['Product']['minimum_price_value'] = '0';
	}
	if(empty($product_details['Product']['minimum_price_seller']) ){
		$product_details['Product']['minimum_price_seller'] = '0';
	}
	if(empty($product_details['Product']['minimum_price_used']) ){
		$product_details['Product']['minimum_price_used'] = '0';
	}
	if(empty($product_details['Product']['minimum_price_used_seller']) ){
		$product_details['Product']['minimum_price_used_seller'] = '0';
	}
	$newLowestPriceSeller  = trim($product_details['Product']['minimum_price_seller']);
	$usedLowestPriceSeller = trim($product_details['Product']['minimum_price_used_seller']);
	$rrp_price 	       = trim($product_details['Product']['product_rrp']);
	$product_id	       = trim($product_details['Product']['id']);
	
	if(!empty($newLowestPriceSeller) ){  // IF seller exists for new condition 
			
		$lowest_price           = $product_details['Product']['minimum_price_value'];
		$lowest_price_seller_id = $product_details['Product']['minimum_price_seller'];
		$product_condition 	= $product_details['Product']['new_condition_id'];
		$stockInfo = $this->Common->getSellerProductStock($lowest_price_seller_id, $product_id, 'new' );
		
		if( !empty($lowest_price) ){
			$prod_price = $lowest_price;
		}else{
			$prod_price = $rrp_price;
		}
	
			
	 ######################## USED PRODUCT SELLER #####################################
	}else if(!empty($usedLowestPriceSeller) ){  // IF seller exists for used condition
		$lowest_price           = $product_details['Product']['minimum_price_used'];
		$lowest_price_seller_id = $product_details['Product']['minimum_price_used_seller'];
		$product_condition 	= $product_details['Product']['used_condition_id'];
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
	$this->set('product_id',$product_details['Product']['id']);
	$logg_user_id =0;
	$logg_user_id = $this->Session->read('User.id');
	$this->set('logg_user_id',$logg_user_id);
	if(!empty($logg_user_id)) {
		$fancy_width = 362;
		$fancy_height = 325;
		$fancy_report_width = 362;
		$fancy_report_height = 200;
		$offer_width  = 362;
		$offer_height = 300;
		$fancy_ansque_width = 362;
		$fancy_feedback_width = 355;
	} else{
		$fancy_width = 560;
		$fancy_height = 160;
		$fancy_report_width = 560;
		$fancy_report_height = 160;
		$offer_width = 560;
		$offer_height = 160;
		$fancy_ansque_width = 560;
		$fancy_feedback_width = 560;
		
		
	}

$logedin_seller_id = $this->Session->read('User.id');
$seller_products = $this->Common->getTotalProBySeller($logedin_seller_id);
?>
<script type="text/javascript">
  $.noConflict();
</script>
<style type="text/css" >
.blue-button-widget { padding-left: 0px !important; }
</style>
<script language="JavaScript">
	jQuery(document).ready(function()  { // for writing a review
		
		/*=====Added on Oct: 29====== Session deleted at bottom of page*/
		var from_review = '<?php echo $reviewInSession ?>';
		if(from_review == 'yes')
		{
			jQuery.fancybox({
			'titlePosition': 'inside',
			'transitionIn' : 'none',
			'transitionOut' : 'none',
			'width' : <?php echo $fancy_width; ?>,
			'height' : <?php echo $fancy_height; ?>,
			'padding':0,'overlayColor':'#000000',
			'overlayOpacity':0.5,
			'opacity':	true,
			'hideOnOverlayClick':false,
			'type' : 'iframe',
			'href': '<?php echo $link_popup ?>',
			'autoDimensions': false,
			'onClosed': function() {
			}
		});
		}
		
		/*============================*/
		
		jQuery("#write_review").fancybox({
			'titlePosition': 'inside',
			'centerOnScroll': true,
			'transitionIn' : 'none',
			'transitionOut' : 'none',
			'width' : <?php echo $fancy_width; ?>,
			//'height' : <?php echo $fancy_height; ?>,
			'padding':0,'overlayColor':'#000000',
			'overlayOpacity':0.5,
			'opacity':	true,
			'hideOnOverlayClick':false,
			'type' : 'iframe',
			'autoDimensions': false,
			'onClosed': function() {
			},
			'onComplete' : function() {
			jQuery('#fancybox-frame').load(function() { // wait for frame to load and then gets it's height
			  jQuery('#fancybox-content').height(jQuery(this).contents().find('body').height());
			});
			}
		});
		jQuery("#email_friend").fancybox({
			'autoScale' : true,
			'titlePosition': 'inside',
			'centerOnScroll': true,
			'transitionIn' : 'none',
			'transitionOut' : 'none',
			'width' : 410,
			'height' : 285,
			'padding':0,'overlayColor':'#000000',
			'overlayOpacity':0.5,
			'opacity':	true,
			'transitionIn' : 'fade',
			'transitionOut' : 'fade',
			'type' : 'iframe',
			'hideOnOverlayClick':false,
			'autoDimensions': false,
			'onClosed': function() {
			},
			'onComplete' : function() {
			jQuery('#fancybox-frame').load(function() { // wait for frame to load and then gets it's height
			  jQuery('#fancybox-content').height(jQuery(this).contents().find('body').height());
			});
			}
		});
		jQuery("a.make-me-offer-link").fancybox({
			'autoScale' : true,
			'titlePosition': 'inside',
			'transitionIn' : 'none',
			'centerOnScroll': true,
			'transitionOut' : 'none',
			'width' : <?php echo $offer_width; ?>,
			//'height' : 300,
			'padding':0,'overlayColor':'#000000',
			'overlayOpacity':0.5,
			'opacity':	true,
			'transitionIn' : 'fade',
			'transitionOut' : 'fade',
			'hideOnOverlayClick':false,
			'type' : 'iframe',
			'autoDimensions': false,
			'onClosed': function() {
			},
			'onComplete' : function() {
			jQuery('#fancybox-frame').load(function() { // wait for frame to load and then gets it's height
			  jQuery('#fancybox-content').height(jQuery(this).contents().find('body').height());
			});
			}
		});
		jQuery("a.thisreport").fancybox({
			'autoScale' : true,
			'titlePosition': 'inside',
			'centerOnScroll': true,
			'transitionIn' : 'none',
			'transitionOut' : 'none',
			'width' : <?php echo $fancy_report_width;?>,
			//'height' : <?php echo $fancy_report_height;?>,
			'padding':0,'overlayColor':'#000000',
			'overlayOpacity':0.5,
			'opacity':	true,
			'transitionIn' : 'fade',
			'transitionOut' : 'fade',
			'hideOnOverlayClick':false,
			'type' : 'iframe',
			'autoDimensions': false,
			'onComplete' : function() {
			jQuery('#fancybox-frame').load(function() { // wait for frame to load and then gets it's height
			  jQuery('#fancybox-content').height(jQuery(this).contents().find('body').height());
			});
			}
		});
		jQuery("a.ansque").fancybox({
			'autoScale' : true,
			'titlePosition': 'inside',
			'transitionIn' : 'none',
			'centerOnScroll': false,
			'transitionOut' : 'none',
			'width' : <?php echo $fancy_ansque_width;?>,
			
			'padding':0,'overlayColor':'#000000',
			'overlayOpacity':0.5,
			'opacity':	true,
			'transitionIn' : 'fade',
			'transitionOut' : 'fade',
			'autoSize': true,
			'hideOnOverlayClick':false,
			'type' : 'iframe',
			'autoDimensions': false,
			'onComplete' : function() {
			jQuery('#fancybox-frame').load(function() { // wait for frame to load and then gets it's height
				//alert(jQuery(this).contents().find('body').height());
			//jQuery('#fancybox-content').height(jQuery('#fancybox-frame').contents().find('html').height());
			jQuery('#fancybox-content').height(jQuery(this).contents().find('body').height()+30);

			});
			}
			
		});                                   
		jQuery("a.large-image").fancybox({
			'autoScale' : true,
			'centerOnScroll': true,
			'width' : 600,
			'height' : 700,
			'padding':0,'overlayColor':'#000000',
			'overlayOpacity':0.5,
			'opacity':	true,
			'transitionIn' : 'fade',
			'transitionOut' : 'fade',
			'hideOnOverlayClick':false,
			'type' : 'iframe',
			'autoDimensions': false,
		});
		jQuery("a.feedback-popup").fancybox({
			'autoScale' : true,
			'centerOnScroll': true,
			
			'width' : <?php echo $fancy_feedback_width;?>,
			'centerOnScroll': true,
			//'height' : 203,
			'padding':0,'overlayColor':'#000000',
			'overlayOpacity':0.5,
			'opacity':	true,
			'transitionIn' : 'fade',
			'transitionOut' : 'fade',
			'hideOnOverlayClick':false,
			'type' : 'iframe',
			'title':false,
			'autoDimensions': false,
			'onComplete' : function() {
			jQuery('#fancybox-frame').load(function() { // wait for frame to load and then gets it's height
			  jQuery('#fancybox-content').height(jQuery(this).contents().find('body').height());
			});
			}
		});
		jQuery("a.playvideo").fancybox({
			'autoScale' : true,
			'width' : 650,
			'centerOnScroll': true,
			'height' : 417,
			'padding':0,'overlayColor':'#000000',
			'overlayOpacity':0.5,
			'opacity':	true,
			'transitionIn' : 'fade',
			'transitionOut' : 'fade',
			'hideOnOverlayClick':false,
			'type' : 'iframe',
			'autoDimensions': false,
		});
		
		
		//Active/Deactive right tabs (Nov. 7, 2012)
		jQuery(".leftTopTab").live('click',function(){
			jQuery(".leftTopTab").removeClass("activeRightTab");
			jQuery(this).addClass("activeRightTab");
		});
		
	});
</script>
<!--Right Section Start-->
<div class="right-sec">
	<?php echo $html->link('',"#",array('id'=>'top','name'=>'top','escape'=>false,'class'=>''));?>
	<!--Right Top Buttons Start-->
	<div class="side-content right-top-btns">
		<?php
		if(!empty($newLowestPriceSeller) ){  // IF seller exists for new condition 
			$prodTitle = "(New)" ;	
		 ######################## USED PRODUCT SELLER #####################################
		}else if(!empty($usedLowestPriceSeller) ){  // IF seller exists for used condition
			$prodTitle = "(Used)" ;
		######################## NO  SELLER #####################################
		}else{  // NO seller exists for any condition
			$prodTitle = '';
		}
		if(is_array($all_pr_sellers) && count($all_pr_sellers) > 0 ){ // if sellers exists
			//product_id, qty,price,seller_id,conditiono
			$addToBasket = '';
			$addToBasket =  $product_details['Product']['id'].",'prod_quantity_id',";
			$addToBasket .= $prod_price.",". $lowest_price_seller_id.",";
			$addToBasket .= $product_condition;
			if( empty($stockInfo) ){
				echo $html->link('<span>Add Lowest Price to Basket</span>',"javascript:void(0)",array('escape'=>false,'class'=>'grn-btn display-bl grn-btn_disabled'));
				
			} else if($stockInfo['ProductSeller']['quantity'] <= 0 ||  empty($stockInfo['ProductSeller']['quantity'])  ){
				echo $html->link('<span>Add Lowest Price to Basket</span>',"javascript:void(0)",array('escape'=>false,'class'=>'grn-btn display-bl grn-btn_disabled'));
			} else{
				echo $html->link('<span>Add Lowest Price '.$prodTitle.' to Basket</span>',"javascript:void(0)",array( 'title'=>'Add lowest price '.$prodTitle.' to basket', 'escape'=>false,'class'=>'grn-btn display-bl', 'onclick'=>'addToBasket('.$addToBasket.');'));
			}
			$offerSerialize = array();
			$offerSerialize['p_id']  = $product_details['Product']['id'];
			$offerSerialize['s_id']  = $lowest_price_seller_id;
			$offerSerialize['c_id']  = $product_condition;
			$offerSerialize['type']  = 'M';
			$encodeOfferData = base64_encode(serialize($offerSerialize));
			echo $html->link(' <span>Make an Offer to all Sellers </span>', "/offers/add/".$encodeOfferData, array('escape'=>false,'class'=>'ornge-btn display-bl make-me-offer-link'));
		 }else{  // disabled links                 
			echo $html->link('<span>Add Lowest Price to Basket</span>',"javascript:void(0)",array('escape'=>false,'class'=>'grn-btn display-bl grn-btn_disabled'));
			echo $html->link(' <span>Make an Offer to all Sellers</span>',"javascript:void(0)",array('escape'=>false,'class'=>'ornge-btn display-bl ornge-btn_disabled'));
		
		 }  ?>
	</div>
	<!--Right Top Buttons Closed-->
	<!--Top iPod Sellers Start-->
	<div class="side-content">
		<h4 class="gray-bg-head black-color center"><span>Buying Choices</span></h4>
		<div class="gray-fade-bg-box">
			<p class="blue-links-new"> All
				<?php echo $ajax->link('New Only','', array('escape'=>false,'update' => 'abc', 'url' => '/categories/get_allsellers_product/'.$product_details['Product']['id'].'/1-4','class'=>'underline-link leftTopTab',"indicator"=>"plsLoaderID",'loading'=>"showloading()","complete"=>"hideloading()"), null,false);?>
				<?php echo $ajax->link('Used Only','', array('escape'=>false,'update' => 'abc', 'url' => '/categories/get_allsellers_product/'.$product_details['Product']['id'].'/2-3-5-6-7','class'=>'underline-link leftTopTab',"indicator"=>"plsLoaderID",'loading'=>"showloading()","complete"=>"hideloading()"), null,false);?>
				<?php echo $ajax->link('Lowest Price','', array('escape'=>false,'update' => 'abc', 'url' => '/categories/get_allsellers_product/'.$product_details['Product']['id'].'/1-2-3-4-5-6-7','class'=>'underline-link leftTopTab activeRightTab',"indicator"=>"plsLoaderID",'loading'=>"showloading()","complete"=>"hideloading()"), null,false);?>
			</p>
			<?php $this->set('product_id',$product_details['Product']['id']);?>
			<div id = "abc"><?php echo $this->element('product/buying_choices');?></div>
			<div style="text-align:right; padding:5px; font-weight:bold;">
			<a href="<?php echo SITE_URL ?>marketplaces/create_listing/<?php echo $product_details['Product']['id'] ?>" style="font-size:12px;">
			<font color='#2D327E'>Sell yours here</font> <font color='#FF7B29'>&raquo;</font>
			</a>
			</div>
		</div>
	</div>
	<!--Top iPod Sellers Closed-->
</div>
<!--Right Section Closed-->

<!--Right Widget Start-->
<div class="right-widget margn-left">
	<?php echo $this->element('navigations/right_add'); ?>
	<?php if(!empty($best_sellers_cat)) { ?>
	<!--Top iPod Sellers Start-->
	<div class="side-content">
		<h4 class="gray-bg-head black-color center"><span><?php echo 'Top '.$cat_name.' Sellers';//echo $best_sellers_cat_slogan;?></span></h4>
		<div class="gray-fade-bg-box">
			<ul class="best-sellers">
				<li>Updated hourly</li>
				<?php $best_selc_i = 1;
				
				$k = 0;
				foreach($best_sellers_cat as $best_sellers_cat_item) {
					foreach($best_sellers_cat_item->attribute as $attribute){
							if($attribute->name == 'secondid'){
								$best_sellers_cat_items[$k]['secondid'] = $attribute->value->_;
							}
							if($attribute->name == 'product_name'){
							      $best_sellers_cat_items[$k]['product_name'] = $attribute->value->_;
							}
						}
						$k++;
				}?>
					
				<?php 
				if(!empty($best_sellers_cat_items)) {
				$best_selc_i = 1;
					foreach($best_sellers_cat_items as $best_sellers_cat_items){
						if($best_selc_i<6){
						$pr_name_cat = $best_sellers_cat_items['product_name'];
						$pr_cat_id = $this->Common->getProductId_Qccode($best_sellers_cat_items['secondid']);
					?>
						<li>
							<div class="seller-left-numbering"><span class="numbering"><strong><?php echo $best_selc_i; ?>.</strong></span> </div>
							<div class="seller-right-ctnt"><?php echo $html->link($pr_name_cat,'/'.$this->Common->getProductUrl($pr_cat_id).'/categories/productdetail/'.$pr_cat_id,array('escape'=>false,'class'=>''));?></div>
						</li>
					<?php $best_selc_i++;
						}
					}
					
				}?>
			</ul>
		</div>
	</div>
	<!--Top iPod Sellers Closed-->
	<?php } ?>
	<?php if(!empty($best_sellers_dept)) { 
	
	for($best_dept_seller_count = 0;$best_dept_seller_count <= 9; $best_dept_seller_count++){
		if(!empty($best_sellers_dept[$best_dept_seller_count])) {
			$best_sellers_dept_sel[$best_dept_seller_count] = $best_sellers_dept[$best_dept_seller_count];
		}
	}
	$best_sellers_dept = $best_sellers_dept_sel;
	?>
	<!--Top Electronics Sellers Start-->
	<div class="side-content">
		<h4 class="gray-bg-head black-color center"><span><?php echo 'Top '.$dept_name.' Sellers';//echo $dept_theme_slogan;?></span></h4>
		<div class="gray-fade-bg-box">
			<ul class="best-sellers">
				<li>Updated hourly</li>
			<?php
				$k = 0;
				foreach($best_sellers_dept as $best_sellers_dept_item) {
					foreach($best_sellers_dept_item->attribute as $attribute){
							if($attribute->name == 'secondid'){
								$best_sellers[$k]['secondid'] = $attribute->value->_;
							}
							if($attribute->name == 'product_name'){
							      $best_sellers[$k]['product_name'] = $attribute->value->_;
							}
						}
						$k++;
				}?>
					
				<?php
				if(!empty($best_sellers)) {
				$best_sel_i = 1;
					foreach($best_sellers as $best_sellers){
						$pr_name = $best_sellers['product_name'];
						$pr_id = $this->Common->getProductId_Qccode($best_sellers['secondid']);
						?>
						<li>
							<div class="seller-left-numbering"><span class="numbering"><strong><?php echo $best_sel_i;?>.</strong></span> </div>
							<div class="seller-right-ctnt"><?php 
							echo $html->link($pr_name,'/'.$this->Common->getProductUrl($pr_id).'/categories/productdetail/'.$pr_id,array('escape'=>false,'class'=>''));?></div>
						</li>
					<?php $best_sel_i++; }
				}?>
			</ul>
		</div>
	</div>
	<!--Top Electronics Sellers Closed-->
	<?php }?>
</div>
<!--Right Widget Closed-->

 <!--mid Content Start-->
<div class="mid-content pro-mid-content" itemscope itemtype="http://schema.org/Product">
	
	<!--Product Preview Widget Start-->
	<div class="product-preview-widget">
		<?php 
		if ($session->check('Message.flash')){ ?>
			<div>
				<?php echo $session->flash();?>
			</div>
		<?php } ?>
		<!--Product Image Statt-->
		<div class="product-image">
			<div style="height:200px; width:200px;text-align:center; vertical-align:middle;">
				<?php
				if(!empty($product_details['Product']['product_image'])){
					$main_imagePath = WWW_ROOT.PATH_PRODUCT.'medium/img_200_'.$product_details['Product']['product_image'];
					if(file_exists($main_imagePath)){
						//echo $html->image('/'.PATH_PRODUCT."medium/img_200_".$product_details['Product']['product_image'], array('alt'=>$product_details["Product"]["product_name"],'title'=>$product_details["Product"]["product_name"]));
						$image_path = '/'.PATH_PRODUCT."medium/img_200_".$product_details['Product']['product_image'];
						echo $html->link($html->image($image_path,array('alt'=>$product_details["Product"]["product_name"],'title'=>$product_details["Product"]["product_name"])), "/categories/enlarge_mainimage/".$product_details['Product']['id'],array( 'escape'=>false,'class'=>'large-image'));
					}else{
						echo $html->link($html->image('/img/no_image_200.jpg', array('alt'=>$product_details["Product"]["product_name"],'title'=>$product_details["Product"]["product_name"])), "/categories/enlarge_mainimage/".$product_details['Product']['id'],array( 'escape'=>false,'class'=>'large-image'));
					}
					
				}else{
					echo $html->link($html->image('/img/no_image_200.jpg', array('alt'=>$product_details["Product"]["product_name"],'title'=>$product_details["Product"]["product_name"])), "/categories/enlarge_mainimage/".$product_details['Product']['id'],array( 'escape'=>false,'class'=>'large-image'));	
				}?>
			</div>
			<p align="center">
				<?php 
				$linkmain_str = '/categories/enlarge_mainimage/'.$product_details['Product']['id'];
				echo $html->link('<strong>View Larger Image</strong>',$linkmain_str,array('escape'=>false,'class'=>'view-larger large-image'));?>
			</p>
			<p align="center" class="thumb-imgs videos-imgs-sec" style="min-height:40px;  width: 200px;">
				<?php
				if(!empty($product_details['Productimage'])) {
					$imgCnt = 1; //Count thumbnails
					foreach($product_details['Productimage'] as $pro_image){
							$imagesPath = WWW_ROOT.PATH_PRODUCT.'small/img_50_'.$pro_image['image'];
							if(file_exists($imagesPath)){
								$image_url = $html->image('/'.PATH_PRODUCT.$pro_image['image']);
								$link_str = '/categories/enlarge_image/'.$pro_image['id'];
								echo $html->link($html->image('/'.PATH_PRODUCT."small/img_50_".$pro_image['image'], array('alt'=>"",'width'=>'30')),$link_str,array('escape'=>false,'class'=>'large-image','title'=>'Enlarge'),false,false);}
					$imgCnt = $imgCnt+1;
					}
				}
				if(!empty($product_details['Product']['product_video'])) { 
					$video_url_array = explode('/',$product_details['Product']['product_video']);
				}
				if(!empty($video_url_array[4])){
					echo $html->link($html->image('play-btn.png', array('alt'=>"",'class'=>'video_playicon')).$html->image('http://img.youtube.com/vi/'.$video_url_array[4].'/3.jpg', array('alt'=>"",'width'=>'30','height'=>'30')),'/products/play_video/'.$product_details['Product']['id'],array('escape'=>false,'class'=>'playvideo', 'style'=>'position:relative'),false,false);?><?php
				} ?>
			</p>
                </div>
		<!--Product Image Closed-->
		<!--Product details Section Start-->
		<div class="product-details-sec">
			<h1 itemprop="name"><?php
			//echo utf8_encode($product_details['Product']['product_name']);
				//$product_details['Product']['product_name'] = mb_convert_encoding($product_details['Product']['product_name'],'UTF-16');
			if(!empty($product_details['Product']['product_name'])) echo html_entity_decode($product_details['Product']['product_name']);?></h1>
			<?php
			######################## NEW PRODUCT SELLER #####################################
			if(!empty($newLowestPriceSeller) ){  // IF seller exists for new condition 
				$lowest_price = $product_details['Product']['minimum_price_value'];
				$lowest_price_seller_id = $product_details['Product']['minimum_price_seller'];
				$product_condition = $product_details['Product']['new_condition_id'];
				$deliveryCharges   = $common->getDeliveryCharges($product_details['Product']['id'],$lowest_price_seller_id, $product_condition);
				
				if( !empty($lowest_price) ){
					$prod_price = $lowest_price;
					if($rrp_price > 0){
						$saving = $rrp_price - $lowest_price;
						$saving_percentage = number_format(($saving/$rrp_price)* 100, 2);
					}else{
						$saving_percentage =0;
						$saving = 0;
					}
				}else{
					$prod_price = $rrp_price;
					$saving = 0;
					$saving_percentage = 0;
				}
			######################## USED PRODUCT SELLER #####################################
			} else if(!empty($usedLowestPriceSeller) ){  // IF seller exists for used condition
				
				$lowest_price           = $product_details['Product']['minimum_price_used'];
				$lowest_price_seller_id = $product_details['Product']['minimum_price_used_seller'];
				$product_condition 	= $product_details['Product']['used_condition_id'];
				$deliveryCharges   	= $common->getDeliveryCharges($product_details['Product']['id'],$lowest_price_seller_id, $product_condition);
				
				if( !empty($lowest_price) ){
					$prod_price = $lowest_price ;
					if($rrp_price > 0){
						$saving = $rrp_price - $lowest_price;
						$saving_percentage = number_format(($saving/$rrp_price)* 100, 2);
					}else{
						$saving_percentage =0;
						$saving = 0;
					}
				}else{
					$prod_price = $rrp_price;
					$saving = 0;
					$saving_percentage = 0;
				}
				
			######################## NO  SELLER #####################################
			} else{  // NO seller exists for any condition
				$lowest_price_seller_id = 0;
				$product_condition = 0;
				$deliveryCharges = 0;
				$stockInfo = array();
				$sellerDetails =  array();
				$prod_price = $rrp_price;
				$saving = 0;
				$saving_percentage = 0;
				
			}
			if(!empty($lowest_price_seller_id) ){
				$sellerDetails = $this->Common->getsellerInfo($lowest_price_seller_id);
				//pr($sellerDetails);
				if($sellerDetails['Seller']['free_delivery'] == '1'){
					if($prod_price >= $sellerDetails['Seller']['threshold_order_value'] ){
						$deliveryCharges = 0;	
					}
				}
			}
			
			
			?>
			<ul class="pro-details" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
				<li>
					<p>
						<span class="price lrgr-fnt" itemprop="price">
							<?php echo CURRENCY_SYMBOL,number_format($prod_price,2);?></span> <span class="gray">+ <?php if(!empty($deliveryCharges)){ echo $deliveryCharges;}else{ echo 'Free';} ?> delivery
						</span>
					</p>
					<?php if(!empty($saving) ){ ?>
					<p>RRP: <span class="rate"><strong><?php echo CURRENCY_SYMBOL,$rrp_price;?></strong></span>
					<?php if($prod_price <= $rrp_price) { ?>
					| You save: <span class="rate"><strong><?php echo CURRENCY_SYMBOL,$saving."($saving_percentage)%";?></strong></span></p>
					<?php  }
					} ?>
					<p class="rating-sec" itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">
					<?php echo $common->displayProductRatingYellow_detail($product_details['Product']['avg_rating'],$product_details['Product']['id']); ?>
					</p>
				</li>
				<li>
					<p><strong>Price choice </strong></p>
					<?php if(!empty($newLowestPriceSeller) ){  // IF seller exists for new condition  ?>
						<p>New from <span class="price padding-right"><strong><?php echo CURRENCY_SYMBOL,number_format($prod_price,2);?></strong></span>
						<?php if(!empty($usedLowestPriceSeller) && !empty($product_details['Product']['minimum_price_used'])  ){ ?>
							Used from <span class="price"><strong><?php echo CURRENCY_SYMBOL,$product_details['Product']['minimum_price_used'];?></strong></span>
						<?php } ?></p>
					<?php }else if(!empty($usedLowestPriceSeller) ){  // IF seller exists for used condition ?>
						<p>Used from <span class="price padding-right"><strong><?php echo CURRENCY_SYMBOL,$prod_price;?></strong></span>
					<?php  } ?>
				</li>
				<li>
					<strong>Qty</strong>
					<input onkeyup= "javascript: if(isNaN(this.value)){ this.clear(); }" id="prod_quantity_id" type="text" name="qty" class="textfield" value="1" maxlength="5" style="width:44px; vertical-align:middle;" />
					<?php
					if( empty($stockInfo) ){
						echo $html->image("add-to-cart-img-disabled.png",array('alt'=>"",'style'=>'vertical-align:middle;'  ));
						
					}else if($stockInfo['ProductSeller']['quantity'] <= 0 ||  empty($stockInfo['ProductSeller']['quantity'])  ){
						echo $html->image("add-to-cart-img-disabled.png",array('alt'=>"",'style'=>'vertical-align:middle;'  ));
					}else{
						$addToBasket =  $product_details['Product']['id'].",'prod_quantity_id',";
						$addToBasket .= $prod_price.",". $lowest_price_seller_id.",";
						$addToBasket .= $product_condition;
							
						echo $html->image("add-to-cart-img.png",array('alt'=>"",'style'=>'vertical-align:middle;cursor:pointer;','onclick'=>'addToBasket('.$addToBasket.');'  ));
					}
					?>
				</li>
				<li>
				<?php
				if( !empty($lowest_price_seller_id) ){
					
					$offerSerialize = array();
						$offerSerialize['p_id']  = $product_details['Product']['id'];
						$offerSerialize['s_id']  = $lowest_price_seller_id;
						$offerSerialize['c_id']  = $product_condition;
						$offerSerialize['type']  = 'S';
						$encodeOfferData = base64_encode(serialize($offerSerialize));
						 
					?> <!--// if sellers exists for this products-->
				
					<?php if( empty($stockInfo) ){?>
						<?php $makemeofferClass = $html->link('<span>Make me an Offer</span>',"javascript:void(0)",array('id'=>'make_me_an_offer_gray', 'escape'=>false,'class'=>'ornge-btn ornge-btn_disabled'));?>
						<p class="price lrgr-fnt"><strong>Sorry - temporarily out of stock</strong></p>
					<?php }else if($stockInfo['ProductSeller']['quantity'] <= 0 ||  empty($stockInfo['ProductSeller']['quantity'])  ){ ?>
						<?php $makemeofferClass = $html->link('<span>Make me an Offer</span>',"javascript:void(0)",array('id'=>'make_me_an_offer_gray', 'escape'=>false,'class'=>'ornge-btn ornge-btn_disabled'));?>
						<p class="price lrgr-fnt"><strong>Sorry - temporarily out of stock</strong></p>
					<?php }else{ ?>
						<?php $makemeofferClass =  $html->link('<span>Make me an Offer</span>',"/offers/add/".$encodeOfferData,array('id'=>'make_me_an_offer', 'escape'=>false,'class'=>'ornge-btn make-me-offer-link'));?>
						<p class="green-color larger-fnt margin-top"><strong><link itemprop="availability" href="http://schema.org/InStock" />In Stock</strong></p>
					<?php } ?>
					
					<p><strong>Seller</strong> <?php echo $sellerDetails['Seller']['business_display_name']; ?></p>
					<?php 
					if(!empty($prod_selectedSeller)){ ?>
					<p><p>
					<?php  //$common->sellerAvgrate($prod_selectedSeller['Seller']['avg_full_star'],$prod_selectedSeller['Seller']['avg_half_star'],$prod_selectedSeller['Seller']['avg_rating'],$prod_selectedSeller['Seller']['id'],$prod_selectedSeller['Seller']['product_id']);?>
					<?php $common->sellerAvgrateCount($prod_selectedSeller['Seller']['avg_full_star'],$prod_selectedSeller['Seller']['avg_half_star'],$prod_selectedSeller['Seller']['count_rating'],$prod_selectedSeller['Seller']['id'],$prod_selectedSeller['Seller']['product_id']);?>
					<?php $common->sellerPositivePercentage($prod_selectedSeller['Seller']['positive_percentage']);?></p></li></p>
					<?php }?><li>
					<p class="margin-top">
					<?php
						/*$offerSerialize = array();
						$offerSerialize['p_id']  = $product_details['Product']['id'];
						$offerSerialize['s_id']  = $lowest_price_seller_id;
						$offerSerialize['c_id']  = $product_condition;
						$offerSerialize['type']  = 'S';
						$encodeOfferData = base64_encode(serialize($offerSerialize));
						*///echo $html->link('<span>Make me an Offer</span>',"/offers/add/".$encodeOfferData,array('id'=>'make_me_an_offer', 'escape'=>false,'class'=>'ornge-btn make-me-offer-link'));
						echo $makemeofferClass;
						echo "&nbsp;";
						
						if(in_array($product_details['Product']['id'],$seller_products)){
							echo $html->link('<span>Sell yours here</span>',"javascript:void(0)",array('id'=>'make_me_an_offer_gray', 'escape'=>false,'class'=>'ornge-btn ornge-btn_disabled'));
						}else{
							$img_name = $html->image("sell_your_product.bmp",array('alt'=>"",'style'=>'vertical-align:middle;'));
							echo $html->link($img_name,"/marketplaces/create_listing/".$product_details['Product']['id'],array('escape'=>false));
						}
						
					?> </p>
					</li>
						
				<?php } else{ // no sellers exists ?>
						
					<p class="price lrgr-fnt"><strong>Temporarily out of stock - more expected soon</strong></p>
					<p><strong>Seller</strong><span style="color:#696969"> Not available</span> </p>
					<p class="margin-top">
					<?php echo $html->link('<span>Make me an Offer</span>',"javascript:void(0)",array('id'=>'make_me_an_offer_gray', 'escape'=>false,'class'=>'ornge-btn ornge-btn_disabled'));?>
					<?php
						if(in_array($product_details['Product']['id'],$seller_products)){
							echo $html->link('<span>Sell yours here</span>',"javascript:void(0)",array('id'=>'make_me_an_offer_gray', 'escape'=>false,'class'=>'ornge-btn ornge-btn_disabled'));
						}else{
							$img_name = $html->image("sell_your_product.bmp",array('alt'=>"",'style'=>'vertical-align:middle;'));
							echo $html->link($img_name,"/marketplaces/create_listing/".$product_details['Product']['id'],array('escape'=>false));
						}
					?>
					</p>
				
				<?php }	?>
				</li>
				<li>
					
					<!-- Start  Google Plus--><div class="gogl_plus">
					<g:plusone></g:plusone>
					<script type="text/javascript">
						(function() {
						var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
						po.src = 'https://apis.google.com/js/plusone.js';
						var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
						})();
						
							
					</script></div>
					<!--End of  Google Plus Button-->
					
					
					<!--Start of facebook like Button-->
					<div id="fb-root"></div>
						<script>(function(d, s, id) {
						var js, fjs = d.getElementsByTagName(s)[0];
						if (d.getElementById(id)) {return;}
						js = d.createElement(s); js.id = id;
						js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
						fjs.parentNode.insertBefore(js, fjs);
						}(document, 'script', 'facebook-jssdk'));</script>
					<div class="fb-like" data-send="false" data-width="450" data-show-faces="false"></div>
					<!-- End of facebook like button-->
				</li>
			</ul>
			
			
		</div>
		<!--Product details Section Closed-->	
	</div>
	<!--Product Preview Widget Closed-->
	<?php echo $this->element('product/frequently_bought_togather'); ?>
	<!--Product Description Start-->
	<div class="row no-pad-btm">
		<!--FBTogether Start-->
		<div class="fbtogether">
			<h4 class="mid-gr-head blue-color"><span>Product Description</span></h4>
			<!--Product Description Start-->
			<div class="product-des content-list"  itemprop="description">
				<?php
				if(!empty($product_details['ProductDetail']['description'])){
					
					$productDesc = html_entity_decode(preg_replace( '/\s+/', ' ',strip_tags($product_details['ProductDetail']['description'])));
					$productDesc = strip_tags($productDesc);
					$productDesc = preg_replace('/[^a-zA-Z0-9\@\.\,\&\$\!\+\?\-\(\)\{\}\[\]\'\%\*\<\>\£\"\:\;\+\s]/i', '', $productDesc);
					echo trim($productDesc);
					
				} ?>
				<?php
				if(!empty($product_details['ProductDetail']['product_features'])){ ?>
				<p style="padding-top:10px;"><strong>Key Features</strong></p>
				<?php //echo  html_entity_decode($product_details['ProductDetail']['product_features']); }
				echo  html_entity_decode($product_details['ProductDetail']['product_features'], ENT_NOQUOTES, 'UTF-8'); }
				?>
				<?php
				if(!empty( $product_details['ProductDetail']['publisher_review'])  &&  $product_details['Product']['department_id'] == 1 ){ // books
					echo '<p style="padding-top:10px;"><strong>Publisher Review </strong></p><p>'.html_entity_decode($product_details['ProductDetail']['publisher_review']).'</p>';
				}
				if(!empty( $product_details['ProductDetail']['track_list']) &&  $product_details['Product']['department_id'] == 2){// for music
					echo '<p style="padding-top:10px;"><strong>Track List: </strong></p>'.html_entity_decode($product_details['ProductDetail']['track_list']).'</p>';
				}
				?>
			</div>
			<!--Product Description Closed-->
		</div>
		<!--FBTogether Closed-->
	</div>
	<!--Product Description Closed-->
	<!--Customers Viewing This Page May Be Interested in These Sponsored Links Start-->
	<?php if(empty($lowest_price_seller_id)){
		echo $this->element('product/customers_viewing');
	?>
		<!--p><?php //echo $html->link('<strong>Email a friend about this product!</strong>','/products/email_friend/'.$product_details['Product']['id'].'/'.$product_details['Product']['product_name'],array('id'=>'email_friend','escape'=>false,'class'=>'diff-blue-color'));?></p>
		<p>Seen a mistake on this page? 
			<?php
			
			/*$pro_link_name = str_replace(array(' ','/','&quot;','&','andamp','and;'), array('-','','"','and','and','and'),$product_details['Product']['product_name']);
			
			if(!empty($logg_user_id))
				$link_tell_admin = '/products/tell_admin/'.$product_details['Product']['id'].'/'.$pro_link_name;
			else
				$link_tell_admin = '/users/sign_in/';
					
			echo $html->link('<strong>Tell us about it!</strong>',$link_tell_admin,array('id'=>'email_friend','escape'=>false,'class'=>'diff-blue-color thisreport'));*/?></p>
		<p><?php //echo $html->link('<strong>back to top</strong>',"#top",array('escape'=>false,'class'=>'diff-blue-color'));?></p-->
	<?php }?>
	
	<!--Customers Viewing This Page May Be Interested in These Sponsored Links Closed-->
	<?php echo $this->element('product/customer_ultimately_buy');?>
	<?php if( !empty($lowest_price_seller_id) ){ ?>
	<!--Delivery Information Start-->
	<div class="row no-pad-btm">
		<!--FBTogether Start-->
		<div class="fbtogether">
			<h4 class="mid-gr-head blue-color"><span>Delivery Information</span></h4>
			<!--Deliver Info Widget Start-->
			<div class="deliver-info">
				<div class="deliver-info-left">
					<p><?php echo $html->image("free-delivery-img.png",array('width'=>"140",'height'=>"54", 'alt'=>"" ));?></p>
					<p>Delivery in 3-5 working days</p>
					<p><?php echo $html->link('Click here for more details',array('controller'=>'pages','action'=>'view', 'estimated-delivery-dates'),array('escape'=>false,'class'=>'red-link'));?></p>
				</div>
				<!--Deliver Info Right Start-->
				<div class="deliver-info-right">
					<p><strong>Want guaranteed delivery by <?php //echo $format->estimatedDeliveryDayDate('E',$product_details['Product']['id']);
					echo ($format->estimatedDeliveryDayDate($product_details['Product']['id']));

					?>?</strong> Order it in the next <span class="purple-color"><strong><?php echo $format->remainingTime();?></strong></span>, and choose Express delivery at checkout.</p>
					<p class="no-pad-btm"><strong>Ships in original Packing:</strong> This item ships in its original manufacturers packaging. There will be shipping labels attached to the  outside of the package. Please mark this item as a gift during checkout (if available) if you do not wish to reveal the contents.</p>
				</div>
				<!--Deliver Info Right Closed-->
			</div>
			<!--Deliver Info Widget Closed-->
		</div>
		<!--FBTogether Closed-->
	</div>
		
	<!--Delivery Information Closed-->
	<?php }?>
	<?php echo $this->element('product/customer_also_bought'); ?>
	<!--Technical Details Start-->
	
	<div class="row no-pad-btm">
		<!--FBTogether Start-->
		<div class="fbtogether">
			<h4 class="mid-gr-head blue-color"><span>Technical Details</span></h4>
			<div class="tec-details">
				<?php
				$dem = '';
				if(!empty($product_details['ProductDetail']['product_height']))
					$dem = $product_details['ProductDetail']['product_height'];
				if(!empty($product_details['ProductDetail']['product_width'])){
					if(!empty($dem))
						$dem .= ' * '.$product_details['ProductDetail']['product_width'];
					else
						$dem = $product_details['ProductDetail']['product_width']; 
				}
				if(!empty($product_details['ProductDetail']['product_length'])){
					if(!empty($dem))
						$dem .= ' * '.$product_details['ProductDetail']['product_length'];
					else
						$dem = $product_details['ProductDetail']['product_length'];}
					$department_id = $product_details['Product']['department_id'];
					switch($department_id):
						case '1': // books
						if(!empty( $product_details['ProductDetail']['author_name'])){
							echo '<p><strong>Author Name: </strong>'.$product_details['ProductDetail']['author_name'].'</p>';
						}
						if(!empty( $product_details['ProductDetail']['publisher'])){
							echo '<p><strong>Publisher: </strong>'.$product_details['ProductDetail']['publisher'].'</p>';
						}
						if(!empty( $product_details['ProductDetail']['language'])){
							echo '<p><strong>Language: </strong>'.$product_details['ProductDetail']['language'].'</p>';
						}
						if(!empty( $product_details['ProductDetail']['product_isbn'])){
							echo '<p><strong>ISBN: </strong>'.$product_details['ProductDetail']['product_isbn'].'</p>';
						}
						if(!empty( $product_details['ProductDetail']['format'])){
							echo '<p><strong>Format: </strong>'.$product_details['ProductDetail']['format'].'</p>';
						}
						if(!empty( $product_details['ProductDetail']['pages'])){
							echo '<p><strong>Pages: </strong>'.$product_details['ProductDetail']['pages'].'</p>';
						}
						if(!empty( $product_details['ProductDetail']['year_published'])){
							echo '<p><strong>Year Published: </strong>'.$common->findPublishYear($product_details['ProductDetail']['product_id']).'</p>';
						}
						if(!empty($dem)){
							echo '<p><strong>Product Dimensions: </strong>'.$dem.' cm</p>';
						}
					break;
					case '2': // music
						if(!empty( $product_details['ProductDetail']['artist_name'])){
							echo '<p><strong>Artist Name: </strong>'.$product_details['ProductDetail']['artist_name'].'</p>';
						}
						if(!empty( $product_details['ProductDetail']['label'])){
							echo '<p><strong>Label: </strong>'.$product_details['ProductDetail']['label'].'</p>';
						}
						if(!empty( $product_details['ProductDetail']['format'])){
							echo '<p><strong>Format: </strong>'.$product_details['ProductDetail']['format'].'</p>';
						}
						if(!empty( $product_details['ProductDetail']['rated'])){
							echo '<p><strong>Rated: </strong>'.$product_details['ProductDetail']['rated'].'</p>';
						}
						if(!empty( $product_details['ProductDetail']['number_of_disk'])){
							echo '<p><strong>Number of Discs: </strong>'.$product_details['ProductDetail']['number_of_disk'].'</p>';
						}
						if(!empty( $product_details['ProductDetail']['release_date'])){
							echo '<p><strong>Release Date: </strong>'.date('d F Y', strtotime($product_details['ProductDetail']['release_date'])).'</p>';
						} 
						
						if(!empty($dem)){
							echo '<p><strong>Product Dimensions: </strong>'.$dem.' cm</p>';
						}
					break;
					case '3': // movie
						if(!empty( $product_details['ProductDetail']['star_name'])){
							echo '<p><strong>Starring: </strong>'.$product_details['ProductDetail']['star_name'].'</p>';
						}
						if(!empty( $product_details['ProductDetail']['directedby'])){
							echo '<p><strong>Directed By: </strong>'.$product_details['ProductDetail']['directedby'].'</p>';
						}
						if(!empty( $product_details['ProductDetail']['format'])){
							echo '<p><strong>Format: </strong>'.$product_details['ProductDetail']['format'].'</p>';
						}
						if(!empty( $product_details['ProductDetail']['number_of_disk'])){
							echo '<p><strong>Number of Discs: </strong>'.$product_details['ProductDetail']['number_of_disk'].'</p>';
						}
						if(!empty( $product_details['ProductDetail']['music_rated'])){
							echo '<p><strong>Rated: </strong>'.$product_details['ProductDetail']['music_rated'].'</p>';
						}
						if(!empty( $product_details['ProductDetail']['movie_language'])){
							echo '<p><strong>Language: </strong>'.$product_details['ProductDetail']['movie_language'].'</p>';
						}
						if(!empty( $product_details['ProductDetail']['studio'])){
							echo '<p><strong>Studio: </strong>'.$product_details['ProductDetail']['studio'].'</p>';
						}
						if(!empty( $product_details['ProductDetail']['release_date'])){
							echo '<p><strong>Release Date: </strong>'.date('d M Y', strtotime($product_details['ProductDetail']['release_date'])).'</p>';
						}
						if(!empty( $product_details['ProductDetail']['run_time'])){
							echo '<p><strong>Run Time: </strong>'.$product_details['ProductDetail']['run_time'].'</p>';
						}
					break;
					case '4': // games
						if(!empty( $product_details['ProductDetail']['plateform'])){
							echo '<p><strong>Platform: </strong>'.$product_details['ProductDetail']['plateform'].'</p>';
						}
						if(!empty( $product_details['ProductDetail']['rated'])){
							echo '<p><strong>Rated: </strong>'.$product_details['ProductDetail']['rated'].'</p>';
						}
						if(!empty( $product_details['ProductDetail']['release_date'])){
							echo '<p><strong>Release Date: </strong>'.date(' d F Y', strtotime($product_details['ProductDetail']['release_date'])).'</p>';
						}
						if(!empty( $product_details['ProductDetail']['region'])){
							echo '<p><strong>Region: </strong>'.$product_details['ProductDetail']['region'].'</p>';
						}
					break;
					case '5': // electronics
					case '6': // office and computing
					case '7': // mobile
					case '8': //  home and garden
					break;
					case '9': // Health & Beauty
						if(!empty( $product_details['ProductDetail']['suitable_for'])){
							echo '<p><strong>Suitable For: </strong>'.$product_details['ProductDetail']['suitable_for'].'</p>';
						}
						if(!empty( $product_details['ProductDetail']['how_to_use'])){
							echo '<p><strong>How To Use: </strong>'.$product_details['ProductDetail']['how_to_use'].'</p>';
						}
						if(!empty( $product_details['ProductDetail']['hazard_caution'])){
							echo '<p><strong>Hazards & Cautions: </strong>'.$product_details['ProductDetail']['hazard_caution'].'</p>';
						}
						
						if(!empty( $product_details['ProductDetail']['precautions'])){
							echo '<p><strong>Precautions: </strong>'.$product_details['ProductDetail']['precautions'].'</p>';
						}
						if(!empty( $product_details['ProductDetail']['ingredients'])){
							echo '<p><strong>Ingredients: </strong>'.$product_details['ProductDetail']['ingredients'].'</p>';
						}
					break;
					default:
					break;
				endswitch;
				?>
				<p><strong>Boxed-Product Weight:</strong> <?php if(!empty($product_details['ProductDetail']['product_weight'])) echo $product_details['ProductDetail']['product_weight'].'g'; else echo '-'; ?></p>
				<p><strong>Quick Code:</strong> <?php if(!empty($product_details['Product']['quick_code'])) echo $product_details['Product']['quick_code']; ?></p>
				<p><strong>Delivery Destinations:</strong> Visit the <?php echo $html->link('Delivery Destinations',array('controller'=>'pages','action'=>'view','delivery-destinations'),array('escape'=>false,'class'=>'smalr-fnt underline-link'));?> Help page to see where this item can be delivered.
				<span class="line-break-span">Find out more about our <?php echo $html->link('Delivery Rates and Returns Policy',array('controller'=>'pages','action'=>'view','pricing'),array('escape'=>false,'class'=>'smalr-fnt underline-link'));?></span></p>
				<p><strong>Item model number:</strong> <?php if(!empty($product_details['Product']['model_number'])) echo $product_details['Product']['model_number'];?></p>
			</div>
		</div>
		<!--FBTogether Closed-->
	</div>
	<!--Technical Details Closed-->
	<?php
	$this->set('productId',$product_details['Product']['id']);
	echo $this->element('product/search_tags'); ?>
	<!--Rate This Item Start-->
	<div class="row no-pad-btm">
		<!--FBTogether Start-->
		<div class="fbtogether">
			<a name="review-rating" > </a>
			<h4 class="mid-gr-head blue-color"><span>Rate This Item</span></h4>
			<div class="rate-this-item" id="avg_rate">
				<?php echo $this->element('product/save_rating'); ?>
			</div>
		</div>
		<!--FBTogether Closed-->
	</div>

	<!--Rate This Item Closed-->
	<?php $this->set('product_details',$product_details);
	echo $this->element('product/reviews');
	echo $this->element('product/question_answers');?>
	<!--More to Explore Start-->
	<?php echo $this->element('product/more_to_explore')?>
	<!--More to Explore Closed /*style="border-top: 20px solid #EEEEEE;overflow: hidden;margin-bottom:10px;" -->
	<div class="smalr-fnt margin-top" ></div>
	<!--Customers Viewing This Page May Be Interested in These Sponsored Links Start-->
	
	<?php if(!empty($lowest_price_seller_id)){
		echo $this->element('product/customers_viewing');
	?>
	<?php }?>
	<!---REF #1974-->
		<p><?php echo $html->link('<strong>Email a friend about this product!</strong>','/products/email_friend/'.$product_details['Product']['id'].'/'.$product_details['Product']['product_name'],array('id'=>'email_friend','escape'=>false,'class'=>'diff-blue-color'));?></p>
		<p>Seen a mistake on this page? 
			<?php
			$pro_link_name = str_replace(array(' ','/','&quot;','&','andamp','and;'), array('-','','"','and','and','and'),$product_details['Product']['product_name']);
			
			if(!empty($logg_user_id))
				$link_tell_admin = '/products/tell_admin/'.$product_details['Product']['id'].'/'.$pro_link_name;
			else
				$link_tell_admin = '/users/sign_in/';
					
			echo $html->link('<strong>Tell us about it!</strong>',$link_tell_admin,array('id'=>'email_friend','escape'=>false,'class'=>'diff-blue-color thisreport'));?></p>
		<p><?php echo $html->link('<strong>back to top</strong>',"#top",array('escape'=>false,'class'=>'diff-blue-color'));?></p>
</div>
	
	<!--Customers Viewing This Page May Be Interested in These Sponsored Links Closed
	<?php if(isset($product_breadcrumb_string) && !empty($product_breadcrumb_string)){?>
		<div class="footer-breadcrumb-widget pro">
		<?php echo $product_breadcrumb_string;?>
	</div>
		<?php } ?>-->
		
	<!--Recent History Widget Startrecent-history-widget-->
	<div class="">
		
		<!--Recent History Start-->
		<div class="recent-history">
			<h4><strong>Your Recent History</strong></h4>
			<ul class="ur_rec_his">
				<?php
				if(!empty($myRecentProducts)){
					$i=0;
					foreach ($myRecentProducts as $product){
						$product['product_name'] = utf8_encode($product['product_name']);
						if($product['product_image'] == 'no_image.gif' || $product['product_image'] == 'no_image.jpeg'){
							$image_path = 'no_image.jpeg';
						} else{
							$image_path = WWW_ROOT.PATH_PRODUCT.'small/img_50_'.$product['product_image'];
							if(!file_exists($image_path) ){
								$image_path = 'no_image_50.jpg';
							}else{
								$image_path = '/'.PATH_PRODUCT.'small/img_50_'.$product['product_image'];
							}
								
						}
						$i++;
						if($i > 5){ // ahow only 5 items
							continue;
						}
					?>
					<li>
						<span class="rec_his_img">
						<?php 
						//echo $html->image($image_path,array('width'=>"20",'height'=>"20", 'alt'=>""));
						echo $html->link($html->image($image_path,array('width'=>"20",'height'=>"20",'alt'=>$product['product_name'],'title'=>$product['product_name'] )), "/".$this->Common->getProductUrl($product['id'])."/categories/productdetail/".$product['id'],array( 'escape'=>false));?>
						</span>
						<span class="rec_his_des">
							<?php
								//echo $html->link($format->formatString($product['product_name'],25, '..'),"/".$this->Common->getProductUrl($product['id'])."/categories/productdetail/".$product['id'],array('escape'=>false,'class'=>''));
								echo $html->link($product['product_name'],"/".$this->Common->getProductUrl($product['id'])."/categories/productdetail/".$product['id'],array('escape'=>false,'class'=>''));
							?>
						</span>
					</li>
					<?php
					}
				} else{ ?>
				<li style="color:#666">No products viewed</li>
				<?php } ?>
			</ul>
		</div>
		
		<!--Recent History Closed-->
		<?php if(!empty($continue_shopping)) {
			$this->set('items_recomanded',$continue_shopping);
			echo $this->element('product/continue_shopping');
		} ?>
	</div>
	<!--Recent History Widget Closed-->
</div>
<!--mid Content Closed-->
<script type="text/javascript">
	function openwindow(linkurl) {
		window.open(linkurl,"mywindow","menubar=0,scrollbar=1,resizable=1,width=600,height=600");
	}
	function change_star(starid,text_flag){
		var id = starid;
	
		if(text_flag != 1){
			if(id == 1){
				jQuery('#ratetext').text('I hate it');
			} else if(id == 2){
				jQuery('#ratetext').text("I don't like it");
			} else if(id == 3){
				jQuery('#ratetext').text("It's ok");
			} else if(id == 4){
				jQuery('#ratetext').text("I like it");
			} else if(id == 5){
				jQuery('#ratetext').text("I love it");
			} else{
				jQuery('#ratetext').text("Unrated");
			}
		}
		for(var i=1; i <= id; i++){
			jQuery('#s_'+i).attr('src', SITE_URL+'/img/blue-star.png');
		}
	}

	function change_toblstar(starid,text_flag,saved_stars){
		var id = starid;
		if(text_flag != 1){
			jQuery('#ratetext').text("Rate it");
			for(var i=1; i <= id; i++){
				jQuery('#s_'+i).attr('src',  SITE_URL+'/img/bl-start.png');
			}
		} else{
			for(var i=1; i <= saved_stars; i++){
				jQuery('#s_'+i).attr('src',  SITE_URL+'/img/blue-star.png');
			}
			for(var j=i; j <= id; j++){
				jQuery('#s_'+j).attr('src', SITE_URL+'/img/bl-start.png');
			}
		}
	}
	function save_rating(stars){
		var p_id = <?php echo $product_details['Product']['id'];?>;
		var postUrl = SITE_URL+'products/save_rating/'+p_id+'/'+stars;
		jQuery.ajax({
			cache:false,
			async: false,
			type: "GET",
			url: postUrl,
			success: function(msg){
			/** Update the div**/
			jQuery('#avg_rate').html(msg);
		}
		});
	}
	
</script>

<!-- Session that was created after comming from email, is deleted: Oct. 29-->
<?php unset($_SESSION['FromEmailLink']); ?>