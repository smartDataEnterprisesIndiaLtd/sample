<?php echo $javascript->link(array('jquery-1.3.2.min','lib/prototype'), false); 
?>
 <!--Tabs Start-->
<?php echo $this->element('mobile/orders/tab');?>
<!--Tbs Closed-->
<!--Tbs Cnt start-->
<section class="tab-content padding0">

<?php
if ($session->check('Message.flash')){ ?>
	<div class="messageBlock"><?php echo $session->flash();?></div>
<?php } ?>

<!--My Offers Start-->
<section class="offers">                	
	<section class="gr_grd brd-tp0">
	<h4 class="bl-cl">My Offers</h4>
	<div class="loader-img"><img src="<?php echo SITE_URL?>img/mobile/loader.gif" width="22" height="22" alt="" /></div>
	</section>
		<?php #pr($multiple_offers_made);
		
		if( (count($offers_made) > 0) || (count($offers_recieved) > 0) || (count($multiple_offers_made) > 0) ) {  //  if any of offers found to show 
		//if( (count($offers_made) > 0) || (count($offers_recieved) > 0) ) {  //  if any of offers found to show  ?>
			<!--Row1 Start-->
			 <div class="row-sec">
                      
                        <h4 class="font14 choiceful">Offers you have made</h4>
			
			
			
			<?php
			//pr($multiple_offers_made);
			unset($image_path);
			 foreach($multiple_offers_made as $multiple_offers){
				//10Days: 14 hours 37 minutes 21 seconds
				$offerDurationM  = $format->offerIntervalTime(strtotime($multiple_offers['Offer']['created']));
				$user_id = $multiple_offers['Offer']['sender_id'];
				$product_id = $multiple_offers['Offer']['product_id'];
				// get offers made to mupltiple sellers
				$offers_multiple = $this->Common->get_multiple_offers($user_id,$product_id );
			?>
			
			
			<!--div class="prod"-->
			<div class="row-sec">
                        <h2 class="font15 rd_clr pad-tp"><?php echo $offerDurationM; ?></h2>
                        <!--Order Products Widget Start-->
                        <div class="order-products-widget">
                                <div class="order-product-image">
					<?php 
						if(!empty($multiple_offers['Product']['product_image'])){
								$product_image = WWW_ROOT.PATH_PRODUCT.'small/img_75_'.$multiple_offers['Product']['product_image'];
							if(file_exists($product_image)){
								echo $html->link($html->image('/'.PATH_PRODUCT.'small/img_75_'.$multiple_offers['Product']['product_image'],array('alt'=>"")),'/'.$this->Common->getProductUrl($product_id).'/categories/productdetail/'.$product_id,array('escape'=>false));
							}else{
								echo $html->link($html->image('no_image_75.jpg',array('alt'=>"")),'/'.$this->Common->getProductUrl($product_id).'/categories/productdetail/'.$product_id,array('escape'=>false));
							}
							}else{
								echo $html->link($html->image('no_image_75.jpg',array('alt'=>"")),'/'.$this->Common->getProductUrl($product_id).'/categories/productdetail/'.$product_id,array('escape'=>false));
						}
					?>
					
					<?php //echo $html->link($html->image($image_path,array('alt'=>'')),"/".$this->Common->getProductUrl($product_id)."/categories/productdetail/".$product_id,array('escape'=>false, 'class'=>'underline-link'));?>
				</div>                        
                                <!--Order Product Content Start-->
                                <div class="order-product-content">                           
                                    <!--Order Product Information Start-->
                                    <div class="order-pro-info">
                                      <p>
					<?php echo $html->link($multiple_offers['Product']['product_name'],"/".$this->Common->getProductUrl($product_id)."/categories/productdetail/".$product_id,array('escape'=>false, 'class'=>'underline-link'));?>
                                      </p>
                                      <p><span class="gray">Lowest Price Seller:</span>
						<?php
							$seller_info = $this->Common->getLowestPriceSellerInfo($product_id);
							$seller_name = str_replace(array(' ','&'),array('-','and'),html_entity_decode($seller_info['Seller']['business_display_name'], ENT_NOQUOTES, 'UTF-8'));
							echo $html->link($seller_info['Seller']['business_display_name'],'/sellers/'.$seller_name.'/summary/'.$seller_info['User']['id'],array('escape'=>false,'class'=>'underline-link'));
						?>
                                      </p>
                                     	<p class="font11 redcolor">Limited time offer</p>
                                     	<?php //if($offers['Offer']['offer_type']=="M"){
                                     		echo '<p class="font11 redcolor">Multiple Seller Offer</p>';
                                     //	}
                                      ?>
                                      
                                    </div>
                                    <!--Order Product Information Closed-->
                                </div>
                                <!--Order Product Content Closed-->                        
                                <div class="clear"></div>
                                
                                <!--Seller Offer Start-->
                                <div class="seller-offers">
                                    <ul>
                                        <li>
                                            <div class="seller-col"><span class="gray">Seller</span></div>
                                            <div class="nor-rrp-col"><span class="gray">Normal RRP</span></div>
                                            <div class="quantity-col"><span class="gray">Quantity</span></div>
                                            <div class="offer-col"><span class="gray">Offer</span></div>
                                        </li>
					
				<?php
				//pr($offers_multiple);
				if( is_array($offers_multiple) ){
					 foreach($offers_multiple as $offers){
						//pr($offers);
						// function to reject the offer automaticlly  if 2 days 
						$this->Common->reject_expired_offer($offers['Offer']['id'],$offers['Offer']['created']);
				?>
                                        <li>
                                            <div class="seller-col">
						<?php echo $html->link($offers['Seller']['business_display_name'],"/sellers/summary/".$offers['Offer']['recipient_id'] ,array('escape'=>false, 'class'=>'underline-link'));?>
                                            </div>
                                            <div class="nor-rrp-col">
                                            	<span class="rd_clr">
                                            		<strong>
								<?php echo CURRENCY_SYMBOL,$offers['Product']['product_rrp'];?>
                                            		</strong>
                                            	</span>
                                            </div>
						
                                            <div class="quantity-col">
                                            	<?php echo $offers['Offer']['quantity'];?>
                                            </div>
                                            
                                            <div class="offer-col">
                                            	<span class="green-color">
							<strong>
								<?php echo CURRENCY_SYMBOL,$offers['Offer']['offer_price'];?>
							</strong>
                                            	</span>
                                            </div>
                                        </li>
						
                                         <li class="margin">
                                         	<?php echo $html->link('<input type="button" value="Delete" class="orangbtn" />',"/offers/delete_offer/".$offers['Offer']['id'],array('escape'=>false, 'class'=>'underline-link fancy_box_open'));?>
                                         	
                                         	<?php echo $html->link('<input type="button" value="Edit Offer" class="grenbtn" />',"/offers/edit/".$offers['Offer']['id'],array('style'=>'margin-right:5px;', 'escape'=>false, 'class'=>''));?>
                                         </li>
					 
					 <?php }
				unset($offers);
				unset($offers_multiple); }   ?>
                                         
                                    </ul>
                                </div>
                                <!--Seller Offer Closed-->
                           
                            </div>
                            <!--Order Products Widget Closed-->
                            
                      </div>
                      <!--Products Closed-->
                    
                  </div>
                    <!--Row1 Closed-->
		    
			
			
		<?php }?>
			
			<!-- End Multiple Seller-->
		<?php
		//if( (count($offers_made) > 0) || (count($offers_recieved) > 0) || (count($multiple_offers_made) > 0) ) {  //  if any of offers found to show 
		//if( (count($offers_made) > 0) || (count($offers_recieved) > 0) ) {  //  if any of offers found to show  ?>
		
			<!--Row1 Start-->
			
			
                        <?php
			 foreach($offers_made as $offers){
				//10Days: 14 hours 37 minutes 21 seconds
				//pr($offers);
				$offerDuration  = $format->offerIntervalTime(strtotime($offers['Offer']['created']));
				// function to reject the offer automaticlly  if 2 days 
				$this->Common->reject_expired_offer($offers['Offer']['id'],$offers['Offer']['created']);
						
			?>
                        <!--Products Start-->
                        <!--div class="prod"-->
			<div class="row-sec">
                        	 <h2 class="font15 rd_clr pad-tp"><?php echo $offerDuration; ?></h2>
                             <!--Order Products Widget Start-->
                          <div class="order-products-widget">
                                <div class="order-product-image">
					<?php 
						if(!empty($offers['Product']['product_image'])){
								$product_image = WWW_ROOT.PATH_PRODUCT.'small/img_75_'.$offers['Product']['product_image'];
							if(file_exists($product_image)){
								echo $html->link($html->image('/'.PATH_PRODUCT.'small/img_75_'.$offers['Product']['product_image'],array('alt'=>"")),'/'.$this->Common->getProductUrl($offers['Offer']['product_id']).'/categories/productdetail/'.$offers['Offer']['product_id'],array('escape'=>false));
							}else{
								echo $html->link($html->image('no_image_75.jpg',array('alt'=>"")),'/'.$this->Common->getProductUrl($offers['Offer']['product_id']).'/categories/productdetail/'.$offers['Offer']['product_id'],array('escape'=>false));
							}
							}else{
								echo $html->link($html->image('no_image_75.jpg',array('alt'=>"")),'/'.$this->Common->getProductUrl($offers['Offer']['product_id']).'/categories/productdetail/'.$offers['Offer']['product_id'],array('escape'=>false));
						}
					?>
				</div>                        
                                <!--Order Product Content Start-->
                                <div class="order-product-content">                           
                                    <!--Order Product Information Start-->
                                    <div class="order-pro-info">
                                      <p>
                                      	<?php echo $html->link($offers['Product']['product_name'],"/".$this->Common->getProductUrl($offers['Offer']['product_id'])."/categories/productdetail/".$offers['Offer']['product_id'],array('escape'=>false, 'class'=>'underline-link'));?>
                                      </p>
                                      <p><span class="gray">Lowest Price Seller:</span> 
                                      	<?php echo $html->link($offers['Seller']['business_display_name'],"/sellers/summary/".$offers['Offer']['recipient_id'],array('escape'=>false, 'class'=>'underline-link'));?>
                                      </p>
                                     	<p class="font11 redcolor">Limited time offer</p>
                                     	<?php if($offers['Offer']['offer_type']=="M"){
                                     		echo '<p class="font11 redcolor">Multiple Seller Offer</p>';
                                     	}
                                      ?>
                                      
                                    </div>
                                    <!--Order Product Information Closed-->
                                </div>
                                <!--Order Product Content Closed-->                        
                                <div class="clear"></div>
                                
                                <!--Seller Offer Start-->
                                <div class="seller-offers">
                                    <ul>
                                        <li>
                                            <div class="seller-col"><span class="gray">Seller</span></div>
                                            <div class="nor-rrp-col"><span class="gray">Normal RRP</span></div>
                                            <div class="quantity-col"><span class="gray">Quantity</span></div>
                                            <div class="offer-col"><span class="gray">Offer</span></div>
                                        </li>
						
                                        <li>
                                            <div class="seller-col">
                                            	<?php echo $html->link($offers['Seller']['business_display_name'],"/sellers/summary/".$offers['Offer']['recipient_id'],array('escape'=>false, 'class'=>'underline-link'));?>
                                            </div>
                                            <div class="nor-rrp-col">
                                            	<span class="rd_clr">
                                            		<strong>
                                            		<?php echo CURRENCY_SYMBOL,$offers['Product']['product_rrp'];?>
                                            		</strong>
                                            	</span>
                                            </div>
						
                                            <div class="quantity-col">
                                            	<?php echo $offers['Offer']['quantity'];?>
                                            </div>
                                            
                                            <div class="offer-col">
                                            	<span class="green-color">
							<strong>
								<?php echo CURRENCY_SYMBOL,$offers['Offer']['offer_price'];?>
							</strong>
                                            	</span>
                                            </div>
                                            
                                        </li>
                                         <li class="margin">
                                         	<?php echo $html->link('<input type="button" value="Delete" class="orangbtn" />',"/offers/delete_offer/".$offers['Offer']['id'],array('escape'=>false, 'class'=>'underline-link fancy_box_open'));?>
                                         	
                                         	<?php echo $html->link('<input type="button" value="Edit Offer" class="grenbtn" />',"/offers/edit/".$offers['Offer']['id'],array('style'=>'margin-right:5px;', 'escape'=>false, 'class'=>''));?>
                                         </li>
                                         
                                    </ul>
                                </div>
                                <!--Seller Offer Closed-->
                           
                            </div>
                            <!--Order Products Widget Closed-->
                            
                      </div>
                      <!--Products Closed-->
                    
                  </div>
                    <!--Row1 Closed-->
			
		
	
	<?php  }?>
	
	<!--Row2 Start-->
	<div class="row-sec border-top-dashed" style="margin-top:5px;">
	<?php }//end array check ?>
		
		
	
	<?php 	/************************** offers recieved ***********************************/
		//pr($offers_recieved);
	if(is_array($offers_recieved) && count($offers_recieved) > 0  ) { ?>
		<h4 class="font14 choiceful">Offers you have received</h4>
		
		<?php
		$offers = '';
		//pr($offers_recieved);
		 foreach($offers_recieved as $offers){
			//pr($offers);
			//10Days: 14 hours 37 minutes 21 seconds
			$offerDuration 		 = $format->offerIntervalTime(strtotime($offers['Offer']['created']));
			$lowestPriceSellerInfo   = $this->Common->getLowestPriceSellerInfo($offers['Offer']['product_id']);
			
			//pr($lowestPriceSellerInfo);
		?>
			<!--Products Start-->
			<div class="prod">
				<h2 class="font16 green-color pad-tp"><?php echo $offerDuration; ?></h2>
				<!--Order Products Widget Start-->
				<div class="order-products-widget">
				<div class="order-product-image">
				<?php 
				if(!empty($offers['Product']['product_image'])){
				$product_image = WWW_ROOT.PATH_PRODUCT.'small/img_75_'.$offers['Product']['product_image'];
				
				if(file_exists($product_image)){
						echo $html->link($html->image('/'.PATH_PRODUCT.'small/img_75_'.$offers['Product']['product_image'],array('alt'=>"")),'/'.$this->Common->getProductUrl($offers['Offer']['product_id']).'/categories/productdetail/'.$offers['Offer']['product_id'],array('escape'=>false));
					}else{
						echo $html->link($html->image('no_image_75.jpg',array('alt'=>"")),'/'.$this->Common->getProductUrl($offers['Offer']['product_id']).'/categories/productdetail/'.$offers['Offer']['product_id'],array('escape'=>false));
					}
				}else{
					echo $html->link($html->image('no_image_75.jpg',array('alt'=>"")),'/'.$this->Common->getProductUrl($offers['Offer']['product_id']).'/categories/productdetail/'.$offers['Offer']['product_id'],array('escape'=>false));
				}
				?>	
					
					<?php //echo $html->link($html->image($image_path,array('alt'=>'')),"/".$this->Common->getProductUrl($offers['Offer']['product_id'])."/categories/productdetail/".$offers['Offer']['product_id'],array('escape'=>false, 'class'=>'underline-link'));?>
				</div>                        
				<!--Order Product Content Start-->
				<div class="order-product-content">                           
					<!--Order Product Information Start-->
					<div class="order-pro-info">
					<p>	
						<?php echo $html->link($offers['Product']['product_name'],"/".$this->Common->getProductUrl($offers['Offer']['product_id'])."/categories/productdetail/".$offers['Offer']['product_id'],array('escape'=>false, 'class'=>'underline-link'));?>
					</p>
						
					<p><span class="gray">Lowest Price Seller:</span>
						<?php echo $html->link($lowestPriceSellerInfo['Seller']['business_display_name'],"/sellers/summary/".$offers['Offer']['recipient_id'],array('escape'=>false, 'class'=>'underline-link'));?>
					</p>
						
						
                                     	<p class="font11 redcolor">Limited time offer</p>
                                     	<?php if($offers['Offer']['offer_type']=="M"){
                                     		echo '<p class="font11 redcolor">Multiple Seller Offer</p>';
                                     	}
                                     	?>
					</div>
					<!--Order Product Information Closed-->
				</div>
				<!--Order Product Content Closed-->                        
				<div class="clear"></div>
				
				<!--Seller Offer Start-->
				<div class="seller-offers">
					<ul>
					<li>
						<div class="nor-rrp-col"><span class="gray">Normal RRP</span></div>
						<div class="quantity-col"><span class="gray">Quantity</span></div>
						<div class="offer-col"><span class="gray">Offer</span></div>
						<div class="name-col"><span class="gray">User Nickname</span></div>
					</li>
					
					<li>
					    <div class="nor-rrp-col">
					    	<span class="red-color">
					    		<strong>
					    			<?php echo CURRENCY_SYMBOL,$offers['Product']['product_rrp'];?></strong>
					    	</span>
					    </div>
					    
					    <div class="quantity-col">
					    	<?php echo $offers['Offer']['quantity'];?>
					    </div>
					    
					    <div class="offer-col1">
					    	<span class="green-color">
					    		<strong>
					    			<?php echo CURRENCY_SYMBOL,$offers['Offer']['offer_price'];?>
					    		</strong>
					    	</span>
					   <span class="name-col" style="margin-right:-4px;">
					   	
					   		<?php echo $offers['User']['firstname']; ?>
					   	
					   </span>
				</div>
					   
					   
					</li>
					<li class="margin">
						<?php echo $html->link('<input type="button" value="Reject Offer" class="orangbtn" />',"/offers/update_offer_status/".$offers['Offer']['id']."/2",array('escape'=>false, 'class'=>'underline-link fancy_box_open_status'));?>
						<?php echo $html->link('<input type="button" value="Accept Offer" class="grenbtn" />',"/offers/update_offer_status/".$offers['Offer']['id']."/1",array('escape'=>false, 'class'=>'underline-link fancy_box_open_status'));?>
					</li>
					</ul>
				</div>
				<!--Seller Offer Closed-->
				
				</div>
				<!--Order Products Widget Closed-->
				
			</div>
			<!--Products Closed-->
	
	<!--Offer Details Closed-->
                     <?php  } //end foreach
		    }   /************************** offers recieved ***********************************/     ?>
		
		
	</div>
	<!--Row2 Closed-->
</section>
<!--My Offers Closed-->







<!--Accepted Start-->
<section class="offers">                	
	<section class="gr_grd">
	<h4 class="bl-cl">Accepted Offers</h4>
	<div class="loader-img"><img src="<?php echo SITE_URL?>img/mobile/loader.gif" width="22" height="22" alt="" /></div>
	</section>
	<!--Row1 Start-->
	<?php if( (count($accepted_array) > 0)) {  //  if any of offers found to show  ?>
	<?php if(is_array($accepted_array['accepted_offers_made']) && count($accepted_array['accepted_offers_made']) > 0  ) { ?>
	<div class="row-sec">
	<h4 class="font14 choiceful">Offers you have made</h4>
	
	<!--Products Start-->
		<?php
		foreach($accepted_array['accepted_offers_made'] as $offers){
			
			//10Days: 14 hours 37 minutes 21 seconds
			$offerCreatedTime 	= $format->offerStatusChangeTime($offers['Offer']['created']);
			$offerAcceptedTime 	= $format->offerStatusChangeTime($offers['Offer']['offer_status_time']);
			
		?>
			<div class="prod">
				<!--Order Products Widget Start-->
				<div class="order-products-widget">
				<div class="order-product-image">
					<?php
					//pr($offers);
						if(!empty($offers['Product']['product_image'])){
								$product_image = WWW_ROOT.PATH_PRODUCT.'small/img_75_'.$offers['Product']['product_image'];
							if(file_exists($product_image)){
								echo $html->link($html->image('/'.PATH_PRODUCT.'small/img_75_'.$offers['Product']['product_image'],array('alt'=>"")),'/'.$this->Common->getProductUrl($product_id).'/categories/productdetail/'.$product_id,array('escape'=>false));
							}else{
								echo $html->link($html->image('no_image_75.jpg',array('alt'=>"")),'/'.$this->Common->getProductUrl($offers['Offer']['product_id']).'/categories/productdetail/'.$offers['Offer']['product_id'],array('escape'=>false));
							}
							}else{
								echo $html->link($html->image('no_image_75.jpg',array('alt'=>"")),'/'.$this->Common->getProductUrl($offers['Offer']['product_id']).'/categories/productdetail/'.$offers['Offer']['product_id'],array('escape'=>false));
						}
					?>
					<?php //echo $html->link($html->image($image_path,array('alt'=>'')),"/".$this->Common->getProductUrl($offers['Offer']['product_id'])."/categories/productdetail/".$offers['Offer']['product_id'],array('escape'=>false, 'class'=>'underline-link'));?>
				</div>
				<!--Order Product Content Start-->
				<div class="order-product-content">                           
					<!--Order Product Information Start-->
					<div class="order-pro-info">
					<p>
						<?php echo $html->link($offers['Product']['product_name'],"/".$this->Common->getProductUrl($offers['Offer']['product_id'])."/categories/productdetail/".$offers['Offer']['product_id'],array('escape'=>false, 'class'=>'underline-link'));?>
					</p>
					<p class="pad-tp"><span class="gray font11"><strong>You sent this offer on</strong></span></p>
					<p class="font11">
						<span>
							<strong>
								<?php echo $offerCreatedTime;?>
							</strong>
						</span> 
						<!--<span class="mrgn-lft"><strong>14:56pm</strong></span>-->
					</p>
					
					<p><span class="gray font11"><strong>Seller Confirmed</strong></span></p>
					<p class="font11">
						<span>
							<strong>
								<?php echo $offerAcceptedTime;?>
							</strong>
						</span> 
						<!--<span class="mrgn-lft"><strong>14:56pm</strong></span>-->
					</p>
					
					</div>
					<!--Order Product Information Closed-->
				</div>
				<!--Order Product Content Closed-->                        
				<div class="clear"></div>
				
				<!--Seller Offer Start-->
				<div class="seller-offers">
					<ul>
					<li>
						<div class="seller-col"><span class="gray">Seller</span></div>
						<div class="nor-rrp-col"><span class="gray">Normal RRP</span></div>
						<div class="quantity-col"><span class="gray">Quantity</span></div>
						<div class="offer-col"><span class="gray">Offer</span></div>
					</li>
					<li>
					
						<div class="seller-col">
							<?php 
								$seller_name_url=str_replace(' ','-',html_entity_decode($offers['Seller']['business_display_name'], ENT_NOQUOTES, 'UTF-8'));
								
								echo $html->link($offers['Seller']['business_display_name'], "/sellers/".$seller_name_url."/summary/".$offers['Offer']['recipient_id'] ,array('escape'=>false, 'class'=>'underline-link'));
							?>
						</div>
						
						<div class="nor-rrp-col">
							<span class="rd_clr">
								<strong>
									<?php echo CURRENCY_SYMBOL,$offers['Product']['product_rrp'];?>
								</strong>
							</span>
						</div>
						
						<div class="quantity-col">
							<?php echo $offers['Offer']['quantity'];?>
						</div>
						
						<div class="offer-col">
							<span class="green-color">
								<strong>
									<?php echo CURRENCY_SYMBOL,$offers['Offer']['offer_price'];?>
								</strong>
							</span>
						</div>
					</li>
					<li class="margin-top">
						<?php 
						$addToBasket =  $offers['Offer']['product_id'].",".$offers['Offer']['quantity'].",";
						$addToBasket .= $offers['Offer']['offer_price'].",".$offers['Offer']['recipient_id'].",";
						$addToBasket .= $offers['Offer']['condition_id'] ;
						?>
						<?php echo $html->link($html->image('mobile/add-to-cart-img.png',array('alt'=>'Add to Basket')),"javascript:void(0)",array('escape'=>false,'class'=>'grn-btn margin-none', 'onclick'=>"addToBasket($addToBasket);")); ?>
						
						<?php //echo $html->image('mobile/add-to-cart-img.png',array('alt'=>'Add to Basket'));?>
					</li>
					
					</ul>
				</div>
				<!--Seller Offer Closed-->
				
				</div>
				<!--Order Products Widget Closed-->
				
			</div>
			<?php } //end foreach?>
		<!--Products Closed-->
	<!--Row2 Start-->
	<div class="row-sec border-top-dashed">
	</div>
	<!--Row1 Closed-->
	<?php  } ?>
	
	
	
	<?php if(is_array($accepted_array['accepted_offers_recieved']) && count($accepted_array['accepted_offers_recieved']) > 0  ) { ?>
	<h4 class="font14 choiceful">Offers you have received</h4>
	
	<!--Products Start-->
	<?php $offers = '';
		 foreach($accepted_array['accepted_offers_recieved'] as $offers){
			//10Days: 14 hours 37 minutes 21 seconds
			$offerRecievedTime = $format->offerStatusChangeTime($offers['Offer']['created']);
			$offerAcceptedTime = $format->offerStatusChangeTimeMobileR($offers['Offer']['offer_status_time']);
			if($offers['Product']['product_image'] == 'no_image.gif' || $offers['Product']['product_image'] == 'no_image.jpeg'){
				$image_path = '/img/no_image.jpeg';
			} else{
				$image_path = '/'.PATH_PRODUCT.'small/img_75_'.$offers['Product']['product_image'];
			}
		?>
	<div class="prod">
		<!--Order Products Widget Start-->
		<div class="order-products-widget">
		<div class="order-product-image">
			<?php 
				if(!empty($offers['Product']['product_image'])){
						$product_image = WWW_ROOT.PATH_PRODUCT.'small/img_75_'.$offers['Product']['product_image'];
					if(file_exists($product_image)){
						echo $html->link($html->image('/'.PATH_PRODUCT.'small/img_75_'.$offers['Product']['product_image'],array('alt'=>"")),"/".$this->Common->getProductUrl($offers['Offer']['product_id'])."/categories/productdetail/".$offers['Offer']['product_id'],array('escape'=>false, 'class'=>'underline-link'));
					}else{
						echo $html->link($html->image('no_image_75.jpg',array('alt'=>"")),"/".$this->Common->getProductUrl($offers['Offer']['product_id'])."/categories/productdetail/".$offers['Offer']['product_id'],array('escape'=>false, 'class'=>'underline-link'));
					}
					}else{
						echo $html->link($html->image('no_image_75.jpg',array('alt'=>"")),"/".$this->Common->getProductUrl($offers['Offer']['product_id'])."/categories/productdetail/".$offers['Offer']['product_id'],array('escape'=>false, 'class'=>'underline-link'));
				}
			?>			
		</div>
		<!--Order Product Content Start-->
		<div class="order-product-content">                           
			<!--Order Product Information Start-->
			<div class="order-pro-info">
			<p>
				<?php echo $html->link($offers['Product']['product_name'],"/".$this->Common->getProductUrl($offers['Offer']['product_id'])."/categories/productdetail/".$offers['Offer']['product_id'],array('escape'=>false, 'class'=>'underline-link'));?>
			</p>
			<p class="pad-tp">
				<span class="gray">User Nickname:</span> 
				<?php echo $offers['User']['firstname']; ?>
			</p>
			
			<p><span class="gray font11"><strong>You sent this offer on</strong></span></p>
			<p class="font11">
				<span>
					<strong>
						<?php echo $offerRecievedTime; ?>
					</strong>
				</span>	
				<!--<span class="mrgn-lft"><strong>14:56pm</strong></span>-->
			</p>
			</div>
			<!--Order Product Information Closed-->
		</div>
		<!--Order Product Content Closed-->                        
		<div class="clear"></div>
		
		<!--Seller Offer Start-->
		<div class="seller-offers">
			<ul>
			<li>
				<div class="nor-rrp-col"><span class="gray">Normal RRP</span></div>
				<div class="quantity-col"><span class="gray">Quantity</span></div>
				<div class="offer-col"><span class="gray">Offer</span></div>
				<div class="name-col"><span class="gray">Accepted on:</span></div>
			</li>
			<li>
				<div class="nor-rrp-col">
					<span class="red-color">
						<strong>
							<?php echo CURRENCY_SYMBOL,$offers['Product']['product_rrp'];?>
						</strong>
					</span>
				</div>
				
				<div class="quantity-col">
					<?php echo $offers['Offer']['quantity'];?>
				</div>
				
				<div class="offer-col">
					<span class="green-color">
						<strong>
							<?php echo CURRENCY_SYMBOL,$offers['Offer']['offer_price'];?>
						</strong>
					</span>                                       
				</div>
				<div class="name-col"><?php echo $offerAcceptedTime;  ?></div>
			</li>
			</ul>
		</div>
		<!--Seller Offer Closed-->
		
		</div>
		<!--Order Products Widget Closed-->
		
	</div>
	<!--Products Closed-->
	<?php  } //end foreach
	 }?>
	
	<?php } // END if any of offers found to show?>
	
	</div>
	<!--Row2 Closed-->
</section>
<!--Accepted Offers Closed-->


<!--Rejected Offers Start-->
<section class="offers">
	<section class="gr_grd">
	<h4 class="bl-cl">Rejected Offers</h4>
	<div class="loader-img"><img src="<?php echo SITE_URL;?>img/mobile/loader.gif" width="22" height="22" alt="" /></div>
	</section>
	<?php if( (count($rejected_array) > 0)) {  //  if any of offers found to show  ?>
	
	<?php if(is_array($rejected_array['rejected_offers_made']) && count($rejected_array['rejected_offers_made']) > 0  ) { ?>
	<!--Row1 Start-->
	<div class="row-sec">
	
	<h4 class="font14 choiceful">Offers you have made</h4>
	<!--Products Start-->
		<?php
		foreach($rejected_array['rejected_offers_made'] as $offers){
		//10Days: 14 hours 37 minutes 21 seconds
		$offerCreatedTime = $format->offerStatusChangeTimeMobile($offers['Offer']['created']);
		$offer_status_time = $format->offerStatusChangeTimeMobile($offers['Offer']['offer_status_time']);
	
		if($offers['Product']['product_image'] == 'no_image.gif' || $offers['Product']['product_image'] == 'no_image.jpeg'){
			$image_path = '/img/no_image.jpeg';
		} else{
			$image_path = '/'.PATH_PRODUCT.'small/img_75_'.$offers['Product']['product_image'];
		}
		?>
			<div class="prod">
				<!--Order Products Widget Start-->
				<div class="order-products-widget">
				<div class="order-product-image">
					<?php 
						if(!empty($offers['Product']['product_image'])){
								$product_image = WWW_ROOT.PATH_PRODUCT.'small/img_75_'.$offers['Product']['product_image'];
							if(file_exists($product_image)){
								echo $html->link($html->image('/'.PATH_PRODUCT.'small/img_75_'.$offers['Product']['product_image'],array('alt'=>"")),"/".$this->Common->getProductUrl($offers['Offer']['product_id'])."/categories/productdetail/".$offers['Offer']['product_id'],array('escape'=>false, 'class'=>'underline-link'));
							}else{
								echo $html->link($html->image('no_image_75.jpg',array('alt'=>"")),"/".$this->Common->getProductUrl($offers['Offer']['product_id'])."/categories/productdetail/".$offers['Offer']['product_id'],array('escape'=>false, 'class'=>'underline-link'));
							}
							}else{
								echo $html->link($html->image('no_image_75.jpg',array('alt'=>"")),"/".$this->Common->getProductUrl($offers['Offer']['product_id'])."/categories/productdetail/".$offers['Offer']['product_id'],array('escape'=>false, 'class'=>'underline-link'));
						}
					?>
					<?php //echo $html->link($html->image($image_path,array('alt'=>'')),"/".$this->Common->getProductUrl($offers['Offer']['product_id'])."/categories/productdetail/".$offers['Offer']['product_id'],array('escape'=>false, 'class'=>'underline-link'));?>
				</div>
				<!--Order Product Content Start-->
				<div class="order-product-content">                           
					<!--Order Product Information Start-->
					<div class="order-pro-info">
					<p>
						<?php echo $html->link($offers['Product']['product_name'],"/".$this->Common->getProductUrl($offers['Offer']['product_id'])."/categories/productdetail/".$offers['Offer']['product_id'],array('escape'=>false, 'class'=>'underline-link'));?>
					</p>
					
					<p class="pad-tp">
						<span class="gray font11">
							<strong>You sent this offer on</strong>
						</span>
					</p>
					<p class="font11">
						<span>
							<strong>
								<?php echo $offerCreatedTime; ?>
							</strong>
						</span>
						<!--<span class="mrgn-lft"><strong>14:56pm</strong></span>-->
					</p>
					<p>
						<span class="gray font11">
							<strong>Seller rejected on</strong>
						</span>
					</p>
					<p class="font11">
						<span>
							<strong>
								<?php echo $offer_status_time;?>
							</strong>
						</span>
						<!--<span class="mrgn-lft"><strong>14:56pm</strong></span>-->
					</p>
					</div>
					<!--Order Product Information Closed-->
				</div>
				<!--Order Product Content Closed-->                        
				<div class="clear"></div>
				
				<!--Seller Offer Start-->
				<div class="seller-offers">
					<ul>
					<li>
						<div class="seller-col"><span class="gray">Seller</span></div>
						<div class="nor-rrp-col"><span class="gray">Normal RRP</span></div>
						<div class="quantity-col"><span class="gray">Quantity</span></div>
						<div class="offer-col"><span class="gray">Offer</span></div>
					</li>
					<li>
						<div class="seller-col">
							<?php 
							$seller_name_url=str_replace(' ','-',html_entity_decode($offers['Seller']['business_display_name'], ENT_NOQUOTES, 'UTF-8'));
							echo $html->link($offers['Seller']['business_display_name'], "/sellers/".$seller_name_url."/summary/".$offers['Offer']['recipient_id'], array('escape'=>false, 'class'=>'underline-link'));?>
						</div>
						<div class="nor-rrp-col">
							<span class="red-color">
								<strong>
									<?php echo CURRENCY_SYMBOL,$offers['Product']['product_rrp'];?>
								</strong>
							</span>
						</div>
						
						<div class="quantity-col">
							<?php echo $offers['Offer']['quantity'];?>
						</div>
						
						<div class="offer-col">
							<span class="green-color">
								<strong>
									<?php echo CURRENCY_SYMBOL,$offers['Offer']['offer_price'];?>
								</strong>
							</span>
						</div>
						<!--<div class="seller-col"><a class="underline-link" href="#">Phones 4U</a></div>
						<div class="nor-rrp-col"><span class="rd_clr"><strong>&pound;298.52</strong></span></div>
						<div class="quantity-col">20</div>
						<div class="offer-col"><span class="green-color"><strong>&pound;290.00</strong></span></div>-->
					</li>
					</ul>
				</div>
				<!--Seller Offer Closed-->
				
				</div>
				<!--Order Products Widget Closed-->
				
			</div>
			<!--Products Closed-->
	<?php } //End Fro each loop ?>
	<!--Row2 Start-->
	<div class="row-sec border-top-dashed">
	<?php }?>
	
	</div>
	<!--Row1 Closed-->
	
	
	
	
	
	<?php if(is_array($rejected_array['rejected_offers_recieved']) && count($rejected_array['rejected_offers_recieved']) > 0  ) { ?>
	<h4 class="font14 choiceful">Offers you have received</h4>
	
	<!--Products Start-->
	<?php
		$offers = '';
		 foreach($rejected_array['rejected_offers_recieved'] as $offers){
			//10Days: 14 hours 37 minutes 21 seconds
			$offerRecievedTime = $format->offerStatusChangeTime($offers['Offer']['created']);
			$offerRejectedTime1 = $format->offerStatusChangeTimeMobileR($offers['Offer']['offer_status_time']);
			if($offers['Product']['product_image'] == 'no_image.gif' || $offers['Product']['product_image'] == 'no_image.jpeg'){
				$image_path = '/img/no_image.jpeg';
			} else{
				$image_path = '/'.PATH_PRODUCT.'small/img_75_'.$offers['Product']['product_image'];
			}
		?>
			<div class="prod">
				<!--Order Products Widget Start-->
				<div class="order-products-widget">
				<div class="order-product-image">
					Offers you have received
					
					<?php 
						if(!empty($offers['Product']['product_image'])){
								$product_image = WWW_ROOT.PATH_PRODUCT.'small/img_75_'.$offers['Product']['product_image'];
							if(file_exists($product_image)){
								echo $html->link($html->image('/'.PATH_PRODUCT.'small/img_75_'.$offers['Product']['product_image'],array('alt'=>"")),"/".$this->Common->getProductUrl($offers['Offer']['product_id'])."/categories/productdetail/".$offers['Offer']['product_id'],array('escape'=>false, 'class'=>'underline-link'));
							}else{
								echo $html->link($html->image('no_image_75.jpg',array('alt'=>"")),"/".$this->Common->getProductUrl($offers['Offer']['product_id'])."/categories/productdetail/".$offers['Offer']['product_id'],array('escape'=>false, 'class'=>'underline-link'));
							}
							}else{
								echo $html->link($html->image('no_image_75.jpg',array('alt'=>"")),"/".$this->Common->getProductUrl($offers['Offer']['product_id'])."/categories/productdetail/".$offers['Offer']['product_id'],array('escape'=>false, 'class'=>'underline-link'));
						}
					?>
					
					<?php //echo $html->link($html->image($image_path,array('alt'=>'')),"/".$this->Common->getProductUrl($offers['Offer']['product_id'])."/categories/productdetail/".$offers['Offer']['product_id'],array('escape'=>false, 'class'=>'underline-link'));?>
				</div>
				<!--Order Product Content Start-->
				<div class="order-product-content">                           
					<!--Order Product Information Start-->
					<div class="order-pro-info">
						<p>
							<?php echo $html->link($offers['Product']['product_name'],"/".$this->Common->getProductUrl($offers['Offer']['product_id'])."/categories/productdetail/".$offers['Offer']['product_id'],array('escape'=>false, 'class'=>'underline-link'));?>
						</p>
						<p class="pad-tp">
							<span class="gray">User Nickname:</span>
							<?php echo $offers['User']['firstname']; ?>
						</p>
						<p><span class="gray font11"><strong>You sent this offer on</strong></span></p>
						<p class="font11">
							<span>
								<strong>
									<?php echo $offerRecievedTime; ?>
								</strong>
							</span>
							<!--<span class="mrgn-lft"><strong>14:56pm</strong></span>-->
						</p>
					</div>
					
					<!--Order Product Information Closed-->
				</div>
				<!--Order Product Content Closed-->                        
				<div class="clear"></div>
				
				<!--Seller Offer Start-->
				<div class="seller-offers">
					<ul>
					<li>
						<div class="nor-rrp-col"><span class="gray">Normal RRP</span></div>
						<div class="quantity-col"><span class="gray">Quantity</span></div>
						<div class="offer-col"><span class="gray">Offer</span></div>
						<div class="name-col"><span class="gray">Rejected on:</span></div>
					</li>
					<li>
						<div class="nor-rrp-col">
							<span class="red-color">
								<strong>
									<?php echo CURRENCY_SYMBOL,$offers['Product']['product_rrp'];?>
								</strong>
							</span>
						</div>
						<div class="quantity-col">
							<?php echo $offers['Offer']['quantity'];?>
						</div>
						<div class="offer-col">
							<span class="green-color">
								<strong>
									<?php echo CURRENCY_SYMBOL,$offers['Offer']['offer_price'];?>
								</strong>
							</span>
						</div>
						<div class="name-col">
							<?php echo $offerRejectedTime1;  ?>
						</div>
					</li>
					</ul>
				</div>
				<!--Seller Offer Closed-->
				
				</div>
				<!--Order Products Widget Closed-->
				
			</div>
			<!--Products Closed-->
		<?php }?>
	
	</div>
	<!--Row2 Closed-->
	
	<?php }
	 } //  END if any of offers found to show ?>
	
</section>
<!--Rejected Offers Closed-->

</section>
<!--Tbs Cnt closed-->

