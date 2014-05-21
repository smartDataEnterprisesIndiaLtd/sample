 <?php
		$offers = '';
		//pr($offers_recieved);
		 foreach($offers_recieved as $offers){
			//pr($offers);
			//10Days: 14 hours 37 minutes 21 seconds
			$offerDuration 		 = $format->offerIntervalTime(strtotime($offers['Offer']['created']));
			$lowestPriceSellerInfo   = $this->Common->getLowestPriceSellerInfo($offers['Offer']['product_id']);
			
			if($offers['Product']['product_image'] == 'no_image.gif' || $offers['Product']['product_image'] == 'no_image.jpeg'){
				$image_path = '/img/no_image.jpeg';
			} else{
				$image_path = '/'.PATH_PRODUCT.'small/img_75_'.$offers['Product']['product_image'];
			}
			
			//pr($lowestPriceSellerInfo);
		?>
                                     
                      
                      <!--Offer Details Start-->
                      <div class="offer-details">

                      <!--Offer Info Left Start-->
         		<div class="offer-info-left">
                        	
                            <h4 class="font-size13 green-color"><?php echo $offerDuration; ?></h4>                         
                        	<!--Order Products Widget Start-->
                        	<div class="offer-info-sec">
                            	  <div class="offer-info-image"><?php echo $html->link($html->image($image_path,array('alt'=>'')),"/".$this->Common->getProductUrl($offers['Offer']['product_id'])."/categories/productdetail/".$offers['Offer']['product_id'],array('escape'=>false, 'class'=>'underline-link'));?></div>
                                
                                <!--Order Product Content Start-->
                                <div class="offer-info-content">
                                	
                                    <!--Order Product Information Start-->
                                    <div class="order-pro-info">
                                      <p><?php echo $html->link($offers['Product']['product_name'],"/".$this->Common->getProductUrl($offers['Offer']['product_id'])."/categories/productdetail/".$offers['Offer']['product_id'],array('escape'=>false, 'class'=>'underline-link'));?></p>
                                      <p><span class="gray">Lowest Price Seller:</span> <?php echo $html->link($lowestPriceSellerInfo['Seller']['business_display_name'],"#",array('escape'=>false, 'class'=>'underline-link'));?></p>
                                      <p class="smalr-fnt"><span class="red-color">Limited Time Offer</span>
					<?php if(strtoupper($offers['Offer']['offer_type']) == 'M'){ ?>
                                        <span class="red-color line-break">Multiple Seller Offer</span></p>
				      <?php } ?>
                                      <p><span class="gray">User Nickname</span> <?php echo $offers['User']['firstname']; ?></p>
                                    </div>
                                    <!--Order Product Information Closed-->
                                    
                                </div>
                                <!--Order Product Content Closed-->
                                
                                <div class="clear"></div>
                            </div>
                            <!--Order Products Widget Closed-->
                        </div>
                        <!--Offer Info Left Closed-->
                        
                        <!--Offer Info Right Start-->
			<div class="offer-info-right">
                        	<div class="seller-offers">
					<ul>
					<li>
					    <div class="nor-rrp-col"><span class="gray">Normal RRP</span></div>
					    <div class="quantity-col"><span class="gray">Quantity</span></div>
					    <div class="offer-col1 width_85px"><span class="gray">Offer</span></div>
					    <div class="action-col last-offer"><span class="gray">Action</span></div>
					</li>
					<li>
					    <div class="nor-rrp-col"><span class="red-color"><strong><?php echo CURRENCY_SYMBOL,$offers['Product']['product_rrp'];?></strong></span></div>
					    <div class="quantity-col"><?php echo $offers['Offer']['quantity'];?></div>
					    <div class="offer-col1 width_85px"><span class="green-color"><strong><?php echo CURRENCY_SYMBOL,$offers['Offer']['offer_price'];?></strong></span></div>
					    <div class="action-col last-offer">
					    <?php echo $html->link("Accept Offer","/offers/update_offer_status/".$offers['Offer']['id']."/1",array('escape'=>false, 'class'=>'underline-link fancy_box_open_status'));?>&nbsp;/&nbsp;
					    <?php echo $html->link("Reject Offer","/offers/update_offer_status/".$offers['Offer']['id']."/2",array('escape'=>false, 'class'=>'underline-link fancy_box_open_status'));?></div>
					</li>
					</ul>
					
					 
                            </div>
                        </div>
                        <!--Offer Info Right Closed-->
                        
                        </div>
                        <!--Offer Details Closed-->
                     <?php  } //end foreach