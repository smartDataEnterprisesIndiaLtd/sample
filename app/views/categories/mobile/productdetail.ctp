<script defer="defer" type="text/javascript" src="/js/lib/prototype.js"></script>
<?php 
//echo $javascript->link(array('lib/prototype'),true);
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
		$fancy_report_height = 250;
		$offer_width  = 362;
		$offer_height = 300;
	} else{
		$fancy_width = 560;
		$fancy_height = 160;
		$fancy_report_width = 560;
		$fancy_report_height = 160;
		$offer_width = 560;
		$offer_height = 160;
		
	}
?>
<!--Right Section Start-->
<script defer="defer" type="text/javascript">
jQuery( document ).ready(function() {
jQuery("#showSellers").click(function(){
		
jQuery("#tab1, #tab3, #tab4").hide();
jQuery("#tab2").show();
jQuery(".tabs li").removeClass("active");
jQuery("#sellerSection").addClass("active");

jQuery.ajax({
		url: "/categories/get_allsellers_product/<?php echo $product_id;?>/1-2-3-4-5-6-7",
		success: function(msg){
		jQuery('#tab2').html(msg);
  	}
	});
});


jQuery("#sellerSection").click(function(){
		jQuery.ajax({
		url: "/categories/get_allsellers_product/<?php echo $product_id;?>/1-2-3-4-5-6-7",
		success: function(msg){
		jQuery('#abc').html(msg);
  	}
	});
});

jQuery("#reviewqa").click(function(){
		jQuery.ajax({
				url: "/categories/reviewqa/<?php echo $product_id;?>",
				success: function(msg){
				jQuery('#tab4').html(msg);
				}
		});
});




});
//showSellers
</script>
<section class="maincont nopadd">
                <!--Product Detail Box Starts-->
                <?php 
		if ($session->check('Message.flash')){ ?>
			<div>
				<div class="messageBlock"><?php echo $session->flash();?></div>
			</div>
		<?php } ?>
		
                 <section class="prdctboxdetal">
                 <!--Product Preview Widget Start-->
                    <div class="product-preview-widget">
                     <h2>
                     	<?php if(!empty($product_details['Product']['product_name'])) 
                     		echo $product_details['Product']['product_name'];
                     	?>
                     </h2>
                    <!--Product Image Statt-->
                    <div class="product-image">
                    <section class="prdctimginner">
                     <span id="plsLoaderID" style="display:none; text-align:center; margin-left:50%" class="dimmer"><?php echo $html->image("loading.gif" ,array('alt'=>"Loading" ,  'style'=>'position:fixed;left:30%;top:40%;z-index:999;'));?>
                     </span>
			<?php  if(!empty($product_details['Product']['product_image'])){
				$linkmain_str = '/categories/enlarge_mainimage/'.$product_details['Product']['id'];
				$main_imagePath = WWW_ROOT.PATH_PRODUCT.'medium/img_150_'.$product_details['Product']['product_image'];
				if(file_exists($main_imagePath)){
					//$linkmain_str = '/categories/enlarge_mainimage/'.$product_details['Product']['id'];
				        echo $html->link($html->image('/'.PATH_PRODUCT."medium/img_150_".$product_details['Product']['product_image'], array('alt'=>"",  'height'=>"110")),$linkmain_str,array('escape'=>false,'class'=>'view-larger large-image', 'style'=>'color:#BBBBBB'));
				}else{
					echo $html->link($html->image('no_image_100.jpg', array('alt'=>"", 'height'=>"110")),$linkmain_str,array('escape'=>false,'class'=>'view-larger large-image', 'style'=>'color:#BBBBBB'));
				}
			}else{
				echo $html->link($html->image('no_image_100.jpg', array('alt'=>"", 'height'=>"110")),$linkmain_str,array('escape'=>false,'class'=>'view-larger large-image', 'style'=>'color:#BBBBBB'));
		        }?>
                    </section>
                        <p align="center" class="thumb-imgs">
                        <?php
				if(!empty($product_details['Productimage'])){
					foreach($product_details['Productimage'] as $pro_image){
						if(!empty($pro_image['image'])){
							$imagesPath = WWW_ROOT.PATH_PRODUCT.'small/img_50_'.$pro_image['image'];
							if(file_exists($imagesPath)){
								$image_url = $html->image('/'.PATH_PRODUCT.$pro_image['image']);
								$link_str = '/categories/enlarge_image/'.$pro_image['id'].'/'.$product_details['Product']['id'];
								echo $html->link($html->image('/'.PATH_PRODUCT."small/img_50_".$pro_image['image'], array('alt'=>"",'width'=>'30')),$link_str,array('escape'=>false,'class'=>'large-image','title'=>'Enlarge'),false,false);
							}
						}
					}
				}?>
                        </p>
                        <p class="enlrgclick" style="padding-top:3px;">
                        	<?php
				if(!empty($product_details['Product']['product_image'])){
						$linkmain_str = '/categories/enlarge_mainimage/'.$product_details['Product']['id'];
						$main_imagePath = WWW_ROOT.PATH_PRODUCT.'medium/img_150_'.$product_details['Product']['product_image'];
						if(file_exists($main_imagePath)){
								
								echo $html->link('Touch to enlarge',$linkmain_str,array('escape'=>false,'class'=>'view-larger large-image', 'style'=>'color:#BBBBBB'));
						}else{
							echo $html->link('Touch to enlarge',$linkmain_str,array('escape'=>false,'class'=>'view-larger large-image', 'style'=>'color:#BBBBBB'));
						}
				}else{
						echo $html->link('Touch to enlarge',$linkmain_str,array('escape'=>false,'class'=>'view-larger large-image', 'style'=>'color:#BBBBBB'));
				}
				?>
                        
                        <!--Click to enlarge-->
                        </p>
                    </div>
                    <!--Product Image Closed-->
                    
                     <!--Product details Section Start-->
                    <div class="product-details-sec">
                        <ul class="pro-details">
                            <li>
                            <p class="font11">
                            <?php if(!empty($product_details['Product']['quick_code'])) 
                     		echo $product_details['Product']['quick_code'];
                     		?>
                     	    </p>
                     	<?php  ######################## NEW PRODUCT SELLER #####################################
			if(!empty($newLowestPriceSeller)){  // IF seller exists for new condition 
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
					if($rrp_price > 0) {
						$saving = $rrp_price - $lowest_price;
						$saving_percentage = number_format(($saving/$rrp_price)* 100, 2);
					} else{
						$saving_percentage =0;
						$saving = 0;
					}
				} else {
					$prod_price = $rrp_price;
					$saving = 0;
					$saving_percentage = 0;
				}
			######################## NO  SELLER #####################################
			} else {  // NO seller exists for any condition
				$lowest_price_seller_id = 0;
				$product_condition = 0;
				$deliveryCharges = 0;
				$stockInfo = array();
				$sellerDetails =  array();
				$prod_price = $rrp_price;
				$saving = 0;
				$saving_percentage = 0;
				
			}
			if( !empty($lowest_price_seller_id) ){
				$sellerDetails = $this->Common->getsellerInfo($lowest_price_seller_id);
				if($sellerDetails['Seller']['free_delivery'] == '1'){
					if($prod_price >= $sellerDetails['Seller']['threshold_order_value'] ){
						$deliveryCharges = 0;	
					}
				}
			}		
			?>
						
                            <p>	<span class="price lrgr-fnt">
					<strong>
						<?php echo CURRENCY_SYMBOL,number_format($prod_price,2);?>
					</strong>
                            	</span>
                            	<span class="gray font11">
                            		+ <?php if(!empty($deliveryCharges)){ echo $deliveryCharges.' Shipping';}else{ echo 'Free delivery';} ?>
                            	</span>
                            </p>
                            <p class="margin-top"><strong>Average Customer Rating</strong></p>
                            <p class="rating-sec rating-col">
				<?php echo $common->displayProductRatingYellowMobile($product_details['Product']['avg_rating'],$product_details['Product']['id']); ?>
                            </p>
                            <?php if( empty($stockInfo) ) {?>
					<p class="lrgr-fnt redcolor"><strong>Sorry - temporarily out of stock</strong></p>
					<?php } else if($stockInfo['ProductSeller']['quantity'] <= 0 ||  empty($stockInfo['ProductSeller']['quantity'])  ){ ?>
						<p class="lrgr-fnt redcolor"><strong>Sorry - temporarily out of stock</strong></p>
					<?php } else{ ?>
						<p class="green-color larger-fnt margin-top" style="color:#00B050">
                           				 <strong>In Stock</strong>
                           			</p>
                           			<p><strong>Sold by:</strong> 
                           			<?php 
							$seller_name=str_replace(' ','-',html_entity_decode($sellerDetails['Seller']['business_display_name'], ENT_NOQUOTES, 'UTF-8'));
							echo $html->link($sellerDetails['Seller']['business_display_name'],'/sellers/'.$seller_name.'/summary/'.$sellerDetails['User']['id'].'/'.$product_details['Product']['id'],array('escape'=>false,'class'=>'bigger-font'));//pr($product_details); ?>
                           			</p>
					<?php } ?>
                            </li>
                            <li class="margin-top">
                            <?php if( !empty($newLowestPriceSeller) ) {  // IF seller exists for new condition  ?>
				<p class="orange-col-head font11">
					New from 
					<span class="nwfrm  padding-right">
						<?php echo CURRENCY_SYMBOL,number_format($prod_price,2);?>
					</span>  
				</p>
				<?php if(!empty($usedLowestPriceSeller) && !empty($product_details['Product']['minimum_price_used'])  ){ ?>
				<p class="orange-col-head font11">Used from 
				<span class="nwfrm  padding-right">
				<?php echo CURRENCY_SYMBOL,$product_details['Product']['minimum_price_used'];?>
				</span></p>
					<?php } ?>
				<?php }else if(!empty($usedLowestPriceSeller) ){  // IF seller exists for used condition ?>
						<p class="orange-col-head font11">Used from 
						<span class="nwfrm  padding-right">
							<?php echo CURRENCY_SYMBOL,$prod_price;?></span></p>
					<?php  }else{ // no seller available
						echo 'No Seller Available';
						
					}  ?>
			
                            </li>
                           
                            <p>
                            <?php
					if( empty($stockInfo) ) {
						echo $html->image("add-to-cart-img-disabled.png",array('alt'=>"",'style'=>'vertical-align:middle;'  ));
						
					} else if($stockInfo['ProductSeller']['quantity'] <= 0 ||  empty($stockInfo['ProductSeller']['quantity'])  ) {
						echo $html->image("add-to-cart-img-disabled.png",array('alt'=>"",'style'=>'vertical-align:middle;'  ));
					} else { ?>
						<!--input onkeyup= "javascript: if(isNaN(this.value)){ this.value = '' }" id="prod_quantity_id" type="text" name="qty" class="textfield" value="1" maxlength="5"  style="width:44px; vertical-align:middle;text-align: center;" /-->
						<input onfocus="if(this.value == '1') {this.value=''}" onblur="if(this.value == ''){this.value ='1'}" id="prod_quantity_id" type="text" name="qty" class="textfield" value="1" maxlength="5"  style="width:44px; vertical-align:middle;text-align: center;" />
						<?php $addToBasket =  $product_details['Product']['id'].",'prod_quantity_id',";
						$addToBasket .= $prod_price.",". $lowest_price_seller_id.",";
						$addToBasket .= $product_condition;
						echo '<p class="font11"> <a href="javascript:void(0);" id="showSellers"><span>View all sellers</span></a> </p>';
						echo $html->image("add-to-cart-img.png",array('alt'=>"",'style'=>'vertical-align:middle;cursor:pointer;margin-top:7px;','onclick'=>'addToBasket('.$addToBasket.');'  ));
					}
				?>
                            <!--
                             <p class="font11"> <a href="#"><span>View all sellers</span></a> </p>
                            <input class="addtocrtbtn" type="image" value="Submit" name="button2" src="<?php //echo SITE_URL;?>img/mobile/add-to-cart-img.png">-->
                            </p>
                        </ul>
                        
                    </div>
                    <!--Product details Section Closed-->	
                </div>
                 <!--Product Preview Widget Closed-->
                 <!--jQuery Tabz Starts-->
                    <section class="jqtabz">
                        <!--Product Description Starts-->
			<div di="tabs123">
				<ul class="tabs">
						<li><a href="#tab1">Description</a></li>
						<li id="sellerSection"><a href="#tab2">Sellers</a></li>
						<li><a href="#tab3">Delivery</a></li>
						<li id="reviewqa"><a href="#tab4">Reviews/Q&amp;A</a></li>
				</ul>
			</div>
                        <!---->
                         <div class="tab_container">
                            <div id="tab1" class="tab_content"> 
                              <!-- Start Content--> 
                                    <section class="productdescptn">
                                    
				<?php
					if(!empty($product_details['ProductDetail']['description'])){ ?>
					<section class="desc">
						<?php echo html_entity_decode($product_details['ProductDetail']['description']);?>
					</section>
					<?php } 
					
					if(!empty($product_details['ProductDetail']['product_features'])){ ?>
					<h4>Key Features</h4>
						<section class="desc">
								<?php echo  html_entity_decode($product_details['ProductDetail']['product_features']);?>
						</section>
					<?php  }?>
					<?php
					if(!empty( $product_details['ProductDetail']['publisher_review'])  &&  $product_details['Product']['department_id'] == 1 ){ // books
						echo '<p style="padding-top:10px;"><strong>Publisher Review: </strong></p><p>'.html_entity_decode($product_details['ProductDetail']['publisher_review']).'</p>';
					}
					if(!empty( $product_details['ProductDetail']['track_list']) &&  $product_details['Product']['department_id'] == 2){// for music
						echo '<p style="padding-top:10px;"><strong>Track List: </strong></p>'.html_entity_decode($product_details['ProductDetail']['track_list']).'</p>';
					}
				?>
				<!--Added on April 27 -->
				<ul>
					<li class="nobg margin-top nopadd"><label class="boldLabel">Boxed-Product Weight:</label> <?php echo $product_details['ProductDetail']['product_weight']; ?>g</li>
					<li class="nobg nopadd"><label class="boldLabel">Quick Code:</label> <?php echo $product_details['Product']['quick_code']; ?></li>
					<li class="nobg nopadd"><label class="boldLabel">Item model number:</label> <?php echo $product_details['Product']['model_number']; ?></li>
				</ul>
				<!--Ends here-->
					<!-- START Frequently Bought Together-->
					<section class="combopryc">
						<?php echo $this->element('mobile/product/frequently_bought_togather'); ?>
						
                                         </section>
                                         <!-- END Frequently Bought Together-->
                                       
                                    </section>
                                   <!-- END Content--> 
                               </div>
                               
                            <div id="tab2" class="tab_content"> 
                              <!--Content--> 
                              <span id="plsLoaderID1" style="display:none; position:fixed;left:30%;top:40%;z-index:999;" class="dimmer"><?php echo $html->image("loading.gif" ,array('alt'=>"Loading" ));?>
                                </span>
						
                                     
				<div id = "abc"><?php echo $this->element('mobile/product/buying_choices');?></div>
						
                               </div>
                            <div id="tab3" class="tab_content"> 
                              <!--Content--> 
                              <ul class="delvrycntnt">
                                <li>
                                	<strong>Want Guaranteed Delivery by <?php
					echo ($format->estimatedDeliveryDayDate($product_details['Product']['id']));
					?>?</strong> Order it in the next <span class="purple-color"><strong><?php echo $format->remainingTime();?></strong></span>, and choose Express delivery at checkout.</p>
					<p class="no-pad-btm" style="text-align: justify;"><strong>Ships in original packing:</strong> This item ships in its original manufacturers packaging. There will be shipping labels attached to the  outside of the package. Please mark this item as a in your cart if you do not wish to reveal the contents.
				</li>
                              </ul>
                             </div>
                            <div id="tab4" class="tab_content"> 
				
                             	<!--Content--> 
				<?php //echo $this->element('mobile/product/reviews');?>
				<!---->
				<!--Start Question/Answers--->
				<?php //echo $this->element('mobile/product/question_answers');?>
				<!--End  Question/Answers--->
				</div>
                            <!--TAb4 End--> 
                      </div>
		<!--Product Description End-->
		</section>
	<!--jQuery Tabz End-->
		</section>
	<!--Product Detail Box Starts-->
</section>