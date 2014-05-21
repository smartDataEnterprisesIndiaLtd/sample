<?php
echo $javascript->link(array('jquery-1.3.2.min','lib/prototype'),false);
//pr($data);
?>
<style>
.float-left div{padding-top:0px}
</style>
<div class="mid-content">
        	
		<?php // display session error message
		if ($session->check('Message.flash')){ ?>
		<div  class="messageBlock"><?php echo $session->flash();?></div>
		<?php } ?>

            <!--Product Listing Start-->
            <div class="blue-head-bx">
            	<h5 class="bl-bg-head">Review Listing</h5>
                
                  <!--White box Start-->
              <div class="wt-bx-widget">
              	 <p class="top-line">Please review your listing details; click 'Back' to return to the previous screens and make any changes. You will be able to update these details later if necessary.</p>
                
		
		<div class="pro-row">
                    	<div class="pro-img-sec">
				<?php
				if($product_details['Product']['product_image'] == 'no_image.gif' || $product_details['Product']['product_image'] == 'no_image.jpeg'){
					$image_path = 'no_image.jpeg';
				} else{
					$image_path = WWW_ROOT.PATH_PRODUCT.'small/img_100_'.$product_details['Product']['product_image'];
					if(!file_exists($image_path) ){
						$image_path = 'no_image_100.jpg';
					}else{
						$image_path = '/'.PATH_PRODUCT.'small/img_100_'.$product_details['Product']['product_image'];
					}
				}
				echo $html->link($html->image($image_path, array('alt'=>"")),'/categories/productdetail/'.$product_details['Product']['id'],array('escape'=>false,'target'=>'_blank'));
				?>
			</div>
                        <div class="pro-img-content">
                        	<p><?php //echo $html->link('<strong>'.$product_details['Product']['product_name'].'</strong>',"/categories/productdetail/".$product_details['Product']['id'],array('escape'=>false,'target'=>'_blank','class'=>'underline-link'));?>
				<?php echo '<strong style="color:#003399">'.$product_details['Product']['product_name'].'</strong>';?>
				</p>
                        	<p class="gray"><strong>Model # <?php echo $product_details['Product']['model_number'];?></strong></p>
                        	<p class="gray"><strong>QuickCode: <?php echo $product_details['Product']['quick_code'];?></strong></p>
                       	    <p class="gray"><strong>Number of Sellers: <?php echo $product_sellers_count; ?></strong></p>
                        </div>
                    </div>
		
<?php echo $form->create('Marketplace',array('action'=>'review_listing','method'=>'POST','name'=>'frmMarketplace','id'=>'frmMarketplace'));
      echo $form->hidden('FormData.confirm', array('value'=>'yes'));
?>		
                    <div class="form-widget">
				       <ul>
                		<li><h4 class="gray-heading sml-fnt">Listing Details</h4></li>
                        <li>
                        	<ul class="listing-left">
                            	<li class="pad-none">
                                    <div class="listing-row border-bottom">
                                    	<ul>
                                        	<li>
                                                <div class="listing-row-left choiceful"><strong>Condition</strong></div>
                                                <div class="listing-row-right"><strong><?php echo $product_condition_array[$data['ProductSeller']['condition_id']];?></strong></div>
                                            </li>
                                            
                                            <li>
                                                <div class="listing-row-left choiceful"><strong>Dispatched from country</strong></div>
                                                <div class="listing-row-right"><strong>
						<?php
						$country_array = $common->getcountries();
						echo $country_array[$data['ProductSeller']['dispatch_country']];?></strong></div>
                                            </li>
                                            
                                            <li>
                                                <div class="listing-row-left choiceful"><strong>Quantity</strong></div>
                                                <div class="listing-row-right"><strong><?php echo $data['ProductSeller']['quantity']; ?></strong></div>
                                            </li>
                                      </ul>
                                    </div>
                                    
                                    <div class="listing-row border-bottom">
                                    	<ul>
                                        	<li>
                                                <div class="listing-row-left choiceful"><strong>Offer Price</strong></div>
                                                <div class="listing-row-right"><?php echo CURRENCY_SYMBOL.''.$format->money($data['ProductSeller']['price'],2); ?> </div>
                                            </li>
                                            
                                            <li>
                                                <div class="listing-row-left choiceful"><strong>Standard Delivery Price</strong></div>
                                                <div class="listing-row-right"><?php echo CURRENCY_SYMBOL.''.$format->money($data['ProductSeller']['standard_delivery_price'],2); ?></div>
                                            </li>
                                      </ul>
                                    </div>
                                    
                                     
                                    <div class="listing-row">
                                    	<ul>
                                        	<li>
                                                <div class="listing-row-left choiceful"><strong>Expedited Delivery</strong></div>
                                                <div class="listing-row-right"><strong><?php echo($data['ProductSeller']['express_delivery'] == 1)?('Enabled'):('Disabled'); ?></strong></div>
                                            </li>
                                            
                                            <li>
                                                <div class="listing-row-left choiceful"><strong>Minimum Price</strong></div>
                                                <div class="listing-row-right"><strong><?php echo($data['ProductSeller']['minimum_price_disabled'] == 1)?('Disabled'):('Enabled'); ?></strong></div>
                                            </li>
                                            <li><?php echo $html->link('Learn more',array('controller'=>'pages','action'=>'view','minimum-price-setting'),array('target'=>'_blank','escape'=>false, 'class'=>'underline-link smalr-fnt'));?>
                                           </ul>
                                    </div>
                                    
                              </li>
                          </ul>
                        </li>
                        <li>
                        	<div class="gray-ins-widget"><strong>Clicking 'Confirm' to complete this process commits you to agree to the terms and conditions of our
				<?php echo $html->link('User Agreement', '/pages/view/marketplace-user-agreement', array('class'=>'diff-blue-color', 'target'=>'_blank' ));?></strong></div>
                    </li>
                        <li>
		<p style="text-align: center;">
				<span class="orange-sml-btn">
						<a href="<?php echo $_SERVER["HTTP_REFERER"];?>"><input type="button" alt="" class="orange-back" value="Back"/></a>
						<!--input type="button" alt="" class="orange-back" value="Back" onclick="history.back();"/-->
				</span>
		<!--<input type="image" alt=""  src="/img/confirm-btn.png" style="vertical-align:middle; border:0px;"  />-->
		<?php echo $form->submit('confirm-btn.png',array('type'=>'image','div'=>false,'class'=>'continue'));?>
               </p></li>
                  </ul>
              </div>
		<?php echo $form->end();
		 //echo $form->button('',array('type'=>'submit','div'=>false,'class'=>'continue'));?>
		 
              </div>
                 <!--White box Closed-->
                 
            </div>
            <!--Product Listing Closed-->
            
      </div>
