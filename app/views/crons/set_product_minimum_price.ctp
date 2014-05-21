<?php echo $javascript->link(array('jquery-1.3.2.min','lib/prototype'),false);?>

<script type="text/javascript" language="javascript">	
//jQuery(document).ready(function(){
//	
//});
</script>

 <!--Content Start-->
    <div id="checkout-content">
    	
        <!--Left Content Start-->
	  <?php echo $this->element('checkout/left'); // include left side bar ?>
        <!--Left Content Closed-->
        <div class="right-con"> </div>
         <!--Right Content Start-->
        
	<div class="checkout-right-content1">
		
         <?php
	if ($session->check('Message.flash')){ ?>
		<div class="messageBlock">
		<?php echo $session->flash();?>
		</div>
	<?php } ?>
	
         <!--Form Left Widget Start-->
		<div class="form-checkout-widget wider-width-510">
			<!--Form Widget Start-->
			<div class="form-widget">
		<?php echo $form->create("Checkout", array('action'=>'step2','default' => true,'name'=>'frmCheckout'));?>
                  
		  <h2 class="gray margin-bottom">Welcome to our Express Registration</h2>
		  <div class="form-widget">
                    <ul>
			
			<?php
			if(is_array($cData)  && count($cData) > 0){
			    foreach($cData as $cart){
				    
				$prodId = $cart['Basket']['product_id'];
				$cartId = $cart['Basket']['id'];
				$sellerInfo = $this->Common->getsellerInfo($cart['Basket']['seller_id']);
				
				$prodSellerInfo = $common->getProductSellerInfo($prodId,$cart['Basket']['seller_id'], $cart['Basket']['condition_id'] );
				$totalQty = $prodSellerInfo['ProductSeller']['quantity'];
				if($totalQty <= 0){
					continue;
				}
						
				if($sellerInfo['Seller']['gift_service'] == 1) { // if gift service provided
					
					$loopName = "Product$cartId";
					
					echo $form->hidden("$loopName.cartid", array('value'=>$cartId) );
					
					if($this->data[$loopName][$prodId] == 'yes' || strtolower($cart['Basket']['giftwrap']) == 'yes' ){
						$gschecked_y = "checked=checked";
						$gschecked_n = "";
					}else{
						$gschecked_y = '';
						$gschecked_n = "checked=checked";
					}
					
					#########
					if(strtolower($cart['Basket']['giftwrap']) == 'yes'){  
						//$gw_message_arr = array();
						$gw_message_arr[0] =''; $gw_message_arr[1] = ''; $gw_message_arr[2] = ''; $gw_message_arr[3] = '';
						$gw_message =  $cart['Basket']['giftwrap_message'];
						$gw_message_arr = explode("#--#",$gw_message ) ;
						//pr($gw_message_arr);
						if(empty($gw_message_arr[0]) ){ $gw_message_arr[0] = '';}
						if(empty($gw_message_arr[1]) ){ $gw_message_arr[1] = '';}
						if(empty($gw_message_arr[2]) ){ $gw_message_arr[2] = '';}
						if(empty($gw_message_arr[3]) ){ $gw_message_arr[3] = '';}
						
					}else{
						$gw_message_arr[0] = $gw_message_arr[1] = $gw_message_arr[2] = $gw_message_arr[3] = '';
					}
					
					##########
				?>
                        <li>
			
           	  		<div class="checkout-pro-widget">
                                <h5><?php echo $cart['Product']['product_name'] ;?></h5>
                                
                                <!--Checkout Product Left Start-->
                                <div class="checkout-pro-left">
					<ul>
                                    	<li>
                                        	<div class="checkbox-widget">
                                        	  <input <?php echo $gschecked_n; ?> type="radio" value="no" class="checkbox" name="data[<?=$loopName?>][giftwrap]" />
                                        	</div>
                                            <div class="checkout-pro-option">Don't gift-wrap this item.</div>
                                        </li>
                                        <li>
                                        	<div class="checkbox-widget">
                                        	  <input <?php echo $gschecked_y; ?> type="radio" value="yes" class="checkbox" name="data[<?=$loopName?>][giftwrap]" />
                                        	</div>
                                            <div class="checkout-pro-option">Gift-wrap this item. Please Note:Large or irregular-shaped items may be placed in a gift-bag - <?php echo CURRENCY_SYMBOL, $settings['Setting']['gift_wrap_charges']; ?></div>
                                        </li>
                                    </ul>
                                </div>
                                 <!--Checkout Product Left Start-->
                                
                        <!--Checkout Product Right Start-->
                                <div class="checkout-pro-right">
                                	<ul>
                                    	<li>Enter your free gift note for this item here:</li>
                                        <li>
                                          <p><?php echo $form->input("$loopName.message1",array('value'=>$gw_message_arr[0],'maxlength'=>'50','class'=>'form-textfield smallr-width','label'=>false,'div'=>false));?></p>
                                          <p><?php echo $form->input("$loopName.message2",array('value'=>$gw_message_arr[1],'maxlength'=>'50','class'=>'form-textfield smallr-width','label'=>false,'div'=>false));?></p>
                                          <p><?php echo $form->input("$loopName.message3",array('value'=>$gw_message_arr[2],'maxlength'=>'50','class'=>'form-textfield smallr-width','label'=>false,'div'=>false));?></p>
                                          <p><?php echo $form->input("$loopName.message4",array('value'=>$gw_message_arr[3],'maxlength'=>'50','class'=>'form-textfield smallr-width','label'=>false,'div'=>false));?></p>
                                          <p>Your message will be formatted and printed on a gift card. Prices for these gifts will not appear on the delivery note.</p>
                                        </li>
                                    </ul>
                                </div>
                                <!--Checkout Product Right Start-->
                                
                          </div>
				<?php } else{  // else show the service not available 	?>
				<div class="checkout-pro-widget">
					<p><strong><?php echo $cart['Product']['product_name'] ;?></strong>
					    <span class="red-color padding-left">
						<?php echo $html->image('checkout/gift-icon.gif',  array('width'=>13, 'height'=>13, 'alt'=>'', 'class'=>'v-align-middle' ) );?>
					   
					    <strong>Not availabe</strong>
					    </span></p>
					<p><span class="sml-fnt"><strong>Seller</strong></span> <?php echo $sellerInfo['Seller']['business_display_name'] ;?> does not offer a gift-wrapping service</p>
				 </div>
				<?php } ?>
				
                        </li>
				
			<?php  } } ?>	
				
                        
                        <li class="smalr-fnt">
                        	 <div style="border: medium none ;" class="checkout-pro-widget">
                                  <p><strong>Please note:</strong></p>
                                  <p>Items designated as gift that are shipped from Choiceful.com to a single address will not display prices on their packaging ships</p>
                             </div>
                        </li>
                       <li>
                      	  <div class="checkout-pro-widget">
                              <div class="float-left">
				<?php echo $html->link( $html->image('checkout/back-btn.gif', array('alt'=>'', 'border'=>'') ) , '/baskets/view' , array('div'=>false, 'label'=>false, 'escape'=>false)  );?>
				<!--<input type="image" value=" " name="button2" src="/img/checkout/back-btn.gif"/>--></div>
                              <div class="float-right pad-none">
				<!--<input type="image" value=" " name="button2" src="/img/checkout/continue-checkout.gif"/>-->
			      <?php  echo $form->submit('checkout/continue-checkout.gif',  array('type'=>'image', 'name'=>'button2') ); ?>
			      </div>
                          </div>
                      </li>
                  </ul>
         </div>
              <!--Form Widget Closed-->
               <?php echo $form->end(); ?>
              </div>
             <!--Form Left Widget Start-->
         	</div>
         </div>
         <!--Right Content Closed-->
    
    </div>
    <!--Content Closed-->
