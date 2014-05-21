
	   <?php /************************** multiple offers section starts here **********************/ ?>
	    <?php
			//pr($multiple_offers_made);
				unset($image_path);
			 foreach($multiple_offers_made as $multiple_offers){
				//10Days: 14 hours 37 minutes 21 seconds
				$offerDurationM  = $format->offerIntervalTime(strtotime($multiple_offers['Offer']['created']));
				
				
				if($multiple_offers['Product']['product_image'] == 'no_image.gif' || $multiple_offers['Product']['product_image'] == 'no_image.jpeg'){
					$image_path = 'no_image.jpeg';
				} else{
					$image_path = '/'.PATH_PRODUCT.'small/img_75_'.$multiple_offers['Product']['product_image'];
				}
				$user_id = $multiple_offers['Offer']['sender_id'];
				$product_id = $multiple_offers['Offer']['product_id'];
				// get offers made to mupltiple sellers
				$offers_multiple = $this->Common->get_multiple_offers($user_id,$product_id );
			?>
	    
	    
	     <!--Offer Details Start-->
                      <div class="offer-details">
                      <!--Offer Info Left Start-->
         		<div class="offer-info-left"
                            <h4 class="sml-fnt red-color"> <?php echo $offerDurationM; ?></h4>                         
                        	<!--Order Products Widget Start-->
                        	<div class="offer-info-sec">
                            	  <div class="offer-info-image"><?php echo $html->link($html->image($image_path,array('alt'=>'')),"/".$this->Common->getProductUrl($product_id)."/categories/productdetail/".$product_id,array('escape'=>false, 'class'=>'underline-link'));?>
				  </div>
                                
                                <!--Order Product Content Start-->
                                <div class="offer-info-content">
                                	
                                    <!--Order Product Information Start-->
                                    <div class="order-pro-info">
                                      <p>
					<?php echo $html->link($multiple_offers['Product']['product_name'],"/".$this->Common->getProductUrl($product_id)."/categories/productdetail/".$product_id,array('escape'=>false, 'class'=>'underline-link'));?>
					</p>
                                      <p>
						<span class="gray">Lowest Price Seller:</span>
						<?php //echo $html->link($multiple_offers['Seller']['business_display_name'],"#",array('escape'=>false, 'class'=>'underline-link'));?>
						<?php
							$seller_info = $this->Common->getLowestPriceSellerInfo($product_id);
							$seller_name = str_replace(array(' ','&'),array('-','and'),html_entity_decode($seller_info['Seller']['business_display_name'], ENT_NOQUOTES, 'UTF-8'));
							echo $html->link($seller_info['Seller']['business_display_name'],'/sellers/'.$seller_name.'/summary/'.$seller_info['User']['id'],array('escape'=>false,'class'=>'underline-link'));
						?>
					</p>
                                      <p class="smalr-fnt"><span class="red-color">Limited Time Offer</span>
                                        <span class="red-color line-break">Multiple Seller Offer</span></p>
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
					<table  align="left" width="100%" cellpadding="0" cellspacing="0" border="0">
					<tr>
					<td align="left" width="30%"><div class="seller-col"><span class="gray">Seller</span></div></td>
					<td align="left"><div class="nor-rrp-col_"><span class="gray">Normal RRP</span></div></td>
					<td align="left"><div class="quantity-col"><span class="gray">Quantity</span></div></td>
					<td align="left"><div class="offer-col"><span class="gray">Offer</span></div></td>
				        <td align="left"></td>
				       </tr>
				<?php
				if( is_array($offers_multiple) ){
					 foreach($offers_multiple as $offers){
						//pr($offers);
						// function to reject the offer automaticlly  if 2 days 
						$this->Common->reject_expired_offer($offers['Offer']['id'],$offers['Offer']['created']);
				?>
				
				<tr>
					<td align="left"><div class="seller-col"><?php echo $html->link($offers['Seller']['business_display_name'],"/sellers/summary/".$offers['Offer']['recipient_id'] ,array('escape'=>false, 'class'=>'underline-link'));?></div></td>
					<td align="left"><div class="nor-rrp-col"><span class="red-color"><strong><?php echo CURRENCY_SYMBOL,$offers['Product']['product_rrp'];?></strong></span></div></td>
					<td align="left"><div class="quantity-col"><?php echo $offers['Offer']['quantity'];?></div></td>
					<td align="left"><div class="offer-col"><span class="green-color"><strong><?php echo CURRENCY_SYMBOL,$offers['Offer']['offer_price'];?></strong></span>&nbsp;/&nbsp;<?php echo $html->link("Edit Offer","/offers/edit/".$offers['Offer']['id'],array('style'=>'margin-right:5px;', 'escape'=>false, 'class'=>'underline-link fancy_box_open'));?></div></td>
					<td align="right"><?php echo $html->link("Delete","/offers/delete_offer/".$offers['Offer']['id'],array('escape'=>false, 'class'=>'underline-link fancy_box_open_delete'));?></td>
					</tr>
				<?php }
				unset($offers);
				unset($offers_multiple); }   ?>
				</table>
                            </div>
                        </div>
                        <!--Offer Info Right Closed-->
                        </div>
                        <!--Offer Details Closed-->
		<?php }  ?>	
	   
           <?php /************************** multiple offers section ends here **********************/ ?>
	                       
			<?php
			 foreach($offers_made as $offers){
				//10Days: 14 hours 37 minutes 21 seconds
				//pr($offers);
				$offerDuration  = $format->offerIntervalTime(strtotime($offers['Offer']['created']));
				
				if($offers['Product']['product_image'] == 'no_image.gif' || $offers['Product']['product_image'] == 'no_image.jpeg'){
					$image_path = '/img/no_image.jpeg';
				} else{
					$image_path = '/'.PATH_PRODUCT.'small/img_75_'.$offers['Product']['product_image'];
				}
				
				// function to reject the offer automaticlly  if 2 days 
				$this->Common->reject_expired_offer($offers['Offer']['id'],$offers['Offer']['created']);
						
			?>
                      <!--Offer Details Start-->
                      <div class="offer-details">
                      <!--Offer Info Left Start-->
         		<div class="offer-info-left">
                            <h4 class="font-size13 red-color"> <?php echo $offerDuration; ?></h4>                         
                        	<!--Order Products Widget Start-->
                        	<div class="offer-info-sec">
                            	  <div class="offer-info-image"><?php echo $html->link($html->image($image_path,array('alt'=>'')),"/".$this->Common->getProductUrl($offers['Offer']['product_id'])."/categories/productdetail/".$offers['Offer']['product_id'],array('escape'=>false, 'class'=>'underline-link'));?>
				  </div>
                                
                                <!--Order Product Content Start-->
                                <div class="offer-info-content">
                                	
                                    <!--Order Product Information Start-->
                                    <div class="order-pro-info">
                                      <p>
					<?php echo $html->link($offers['Product']['product_name'],"/".$this->Common->getProductUrl($offers['Offer']['product_id'])."/categories/productdetail/".$offers['Offer']['product_id'],array('escape'=>false, 'class'=>'underline-link'));?>
					</p>
                                      <p>
						<span class="gray">Lowest Price Seller:</span>
						<?php //echo $html->link($offers['Seller']['business_display_name'],"#",array('escape'=>false, 'class'=>'underline-link'));?>
						<?php
							$seller_info = $this->Common->getLowestPriceSellerInfo($offers['Offer']['product_id']);
							$seller_name = str_replace(array(' ','&'),array('-','and'),html_entity_decode($seller_info['Seller']['business_display_name'], ENT_NOQUOTES, 'UTF-8'));
							echo $html->link($seller_info['Seller']['business_display_name'],'/sellers/'.$seller_name.'/summary/'.$seller_info['User']['id'],array('escape'=>false,'class'=>'underline-link'));
						?>
					</p>
                                      <p class="smalr-fnt"><span class="red-color">Limited Time Offer</span>
                                      
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
                                    <div class="offer-col last-offer"><span class="gray">Offer</span></div>
				    
                                </li>
				  <li>
                                    <div class="seller-col"><?php echo $html->link($offers['Seller']['business_display_name'],"/sellers/summary/".$offers['Offer']['recipient_id'],array('escape'=>false, 'class'=>'underline-link'));?></div>
                                    <div class="nor-rrp-col"><span class="red-color"><strong><?php echo CURRENCY_SYMBOL,$offers['Product']['product_rrp'];?></strong></span></div>
                                    <div class="quantity-col"><?php echo $offers['Offer']['quantity'];?></div>
                                    <div class="offer-col last-offer"><span class="green-color"><strong><?php echo CURRENCY_SYMBOL,$offers['Offer']['offer_price'];?></strong></span> /
				    <?php echo $html->link("Edit Offer","/offers/edit/".$offers['Offer']['id'],array('style'=>'margin-right:5px;', 'escape'=>false, 'class'=>'underline-link fancy_box_open'));?>
				    <?php echo $html->link("Delete","/offers/delete_offer/".$offers['Offer']['id'],array('escape'=>false, 'class'=>'underline-link fancy_box_open'));?></div>
                                </li>
                            </ul>
                            
                            </div>
                        </div>
                        <!--Offer Info Right Closed-->
			  
                        </div>
                        <!--Offer Details Closed-->
                         <?php  } //end foreach ?>