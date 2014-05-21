<?php
		 foreach($offers_made as $offers){
			//10Days: 14 hours 37 minutes 21 seconds
			$offerCreatedTime = $format->offerStatusChangeTime($offers['Offer']['created']);
			$offer_status_time = $format->offerStatusChangeTime($offers['Offer']['offer_status_time']);
		
			if($offers['Product']['product_image'] == 'no_image.gif' || $offers['Product']['product_image'] == 'no_image.jpeg'){
				$image_path = '/img/no_image.jpeg';
			} else{
				$image_path = '/'.PATH_PRODUCT.'small/img_75_'.$offers['Product']['product_image'];
			}
		?>
                      <!--Offer Details Start-->
                      <div class="offer-details">
                      <!--Offer Info Left Start-->
         		<div class="offer-info-left padding-top-sec">
                        	<!--Order Products Widget Start-->
                        	<div class="offer-info-sec">
                            	  <div class="offer-info-image"><?php echo $html->link($html->image($image_path,array('alt'=>'')),"/".$this->Common->getProductUrl($offers['Offer']['product_id'])."/categories/productdetail/".$offers['Offer']['product_id'],array('escape'=>false, 'class'=>'underline-link'));?>
				  </div>
                                
                                <!--Order Product Content Start-->
                                <div class="offer-info-content">
                                	
                                    <!--Order Product Information Start-->
				     <div class="order-pro-info">
                                      <p><?php echo $html->link($offers['Product']['product_name'],"/".$this->Common->getProductUrl($offers['Offer']['product_id'])."/categories/productdetail/".$offers['Offer']['product_id'],array('escape'=>false, 'class'=>'underline-link'));?></p>
                                      <p class="smalr-fnt"><span class="gray"><strong>You sent this offer on</strong></span></p>
                                      <p class="smalr-fnt"><strong><?php echo $offerCreatedTime;?> </strong> </p>
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
                                   <div class="seller-col"><span class="gray">Seller</span></div>
                                    <div class="nor-rrp-col"><span class="gray">Normal RRP</span></div>
                                    <div class="quantity-col"><span class="gray">Quantity</span></div>
                                    <div class="offer-col offer-width30"><span class="gray">Offer</span></div>
                                </li>
				  <li>
                                    <div class="seller-col"><?php 
                                    $seller_name_url=str_replace(' ','-',html_entity_decode($offers['Seller']['business_display_name'], ENT_NOQUOTES, 'UTF-8'));
                                    echo $html->link($offers['Seller']['business_display_name'], "/".$seller_name_url."/sellers/summary/".$offers['Offer']['recipient_id'], array('escape'=>false, 'class'=>'underline-link'));?></div>
                                    <div class="nor-rrp-col"><span class="red-color"><strong><?php echo CURRENCY_SYMBOL,$offers['Product']['product_rrp'];?></strong></span></div>
                                    <div class="quantity-col"><?php echo $offers['Offer']['quantity'];?></div>
                                    <div class="offer-col offer-width30"><span class="green-color"><strong><?php echo CURRENCY_SYMBOL,$offers['Offer']['offer_price'];?></strong></span> </div>
				    <div class="button-col width-auto-sec"><?php echo $html->image("/img/negative-icon.png", array('alt'=>'') ) ;?></div>
                                </li>
				   <li>
                                    <div class="seller-col">
					<p class="smalr-fnt"><span class="gray"><strong>Seller rejected on </strong></span></p>
                                        <p class="smalr-fnt"><strong><?php echo $offer_status_time;?> </strong> </p>
				    </div>
                                  
                                </li>
                            </ul>
                            </div>
                        </div>
                        <!--Offer Info Right Closed-->
                        
                        </div>
                        <!--Offer Details Closed-->
                       <?php  } //end foreach
		    ?>