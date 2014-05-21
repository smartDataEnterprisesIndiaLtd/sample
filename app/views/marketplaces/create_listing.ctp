<?php
echo $javascript->link(array('jquery-1.3.2.min','lib/prototype'),false);
echo $javascript->link(array('behaviour','textarea_maxlen'));
$user_signed = $this->Session->read('User');


?>
<style>
.float-left div{padding-top:0px}

</style>

<script type="text/javascript">

jQuery(document).ready(function(){
		validatePriceBoxes();
		reduceCharacter();
		jQuery('#ProductSellerNotes').keyup(function(){
				reduceCharacter();
		});
		jQuery('#min_price_desable_id').click(function(){
				validatePriceBoxes();
		});
		jQuery('#exp_del_price_checkbox').click(function(){
			
				validatePriceBoxes();
		});
});
// function to get reduced characters on keyup of the  textarea
function reduceCharacter(){
		var charlength = jQuery('#ProductSellerNotes').val().length;
		var restChars = 100 - charlength;
		var restCharStr = '['+restChars+' characters left]';
		jQuery('#show_remaining_chars').html(restCharStr);
}



// function to enable/ desable price boxes
function validatePriceBoxes(){
		var minPriceChkbox = jQuery(":checkbox[id='min_price_desable_id']").attr('checked');
		var expDelPriceChkbox = jQuery(":checkbox[id='exp_del_price_checkbox']").attr('checked');
		//////////////////
		if(minPriceChkbox == true){
		        jQuery('#min_price_textbox').val('');
			jQuery('#min_price_textbox').attr('disabled', true);
		}else{
			jQuery('#min_price_textbox').attr('disabled', false);	
		}
		/////////////////
		
		if(expDelPriceChkbox == 'checked'){
				jQuery('#exp_del_price_textbox').attr('disabled', false);
		}else{
			jQuery('#exp_del_price_textbox').val('');
		        jQuery('#exp_del_price_textbox').attr('disabled', true);	
		}
}
</script>

<div class="mid-content">
		
<?php // display session error message
if ($session->check('Message.flash')){ ?>
<div  class="messageBlock"><?php echo $session->flash();?></div>
<?php } ?>
            <!--Product Listing Start-->
            <div class="blue-head-bx">
            	<h5 class="bl-bg-head">Product Listing</h5>
                
                  <!--White box Start-->
              <div class="wt-bx-widget">
                 	<div class="pro-row">
                    	<div class="pro-img-sec">
				<?php
				if($product_details['Product']['product_image'] == 'no_image.gif' || $product_details['Product']['product_image'] == 'no_image.jpeg'){
					$image_path = '/img/no_image.jpeg';
				} else{
					$image_path = WWW_ROOT.PATH_PRODUCT.'small/img_100_'.$product_details['Product']['product_image'];
					if(!file_exists($image_path) ){
						$image_path = 'no_image_100.jpg';
					}else{
						$image_path = '/'.PATH_PRODUCT.'small/img_100_'.$product_details['Product']['product_image'];
					}
				}
				//echo $html->link($html->image($image_path, array('alt'=>"")),'/categories/productdetail/'.$product_details['Product']['id'],array('escape'=>false,'target'=>'_blank'));
				echo $html->image($image_path, array('alt'=>""));
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
              </div>
                 <!--White box Closed-->
                 
            </div>
            <!--Product Listing Closed-->
            <?php
	   
		if(!empty($errors)){
				if(!empty($errors['minimum_price']) && $errors['minimum_price'] == 'Please note that minimum price value should be lower than your price'){
						$error_meaasge=$errors['minimum_price'];
				}else{
						$error_meaasge="Please add some information in the mandatory fields highlighted red below.";
				}
				
			?>
			<div class="error_msg_box" style="overflow: hidden;"> 
				<?php echo $error_meaasge;?>
			</div>
		<?php }?>
            <!--Your Inventory Details Start-->
            <!--div class="blue-head-bx"-->
		<div>
            	<h5 class="bl-bg-head">Your Inventory Details</h5>
                
                <!--White box Start-->
              <div class="wt-bx-widget">
<?php
echo $form->create('Marketplace',array('action'=>'create_listing/'.$product_id,'method'=>'POST','name'=>'frmMarketplace','id'=>'frmMarketplace'));
echo $form->hidden('ProductSeller.product_id', array('value'=>$product_id));
//pr($product_details);
?>
                <!--Form Widget Start-->
                <div class="form-widget">             
						
				<ul>
                		<li><p>In order to sell this product you will have to enter all mandatory fields highlighted below in orange</p></li>
                		<li><h4 class="gray-heading org-txt">Condition</h4></li>
                        <li><p>Select the condition of your item.</p></li>
				<?php if(!empty($errors['condition_id'])){
					$errorCondition='select_big textfield-input error_message_box';
				}else{
					$errorCondition='select_big textfield-input';
				}
				?>
                        <?php echo $form->select('ProductSeller.condition_id', $product_condition_array, null,array('class'=>$errorCondition,'style'=>'float:none', 'type'=>'select','label'=>false,'error'=>false, 'div'=>false),'Select...'); 
			      //echo $form->error('ProductSeller.condition_id');
			    ?>
                        </li>
                        <li><h4 class="gray-heading larger-font">Comment <span class="gray smallr-width">[Optional]</span></h4></li>
                        <li>
			  <?php echo $form->input('ProductSeller.notes',array( 'maxlength'=>100, 'rows'=>'5','cols'=>'50',  'class'=>'textfield-input width-auto','label'=>false,'div'=>false));?>
                          <span class="instructions-line line-break gray" id="show_remaining_chars" >[100 characters left]</span>
                        </li>
                        <li>You may choose to provide short comments to highlight specific details.</li>
                        <li>Include details relating to the condition of your listing, such as 'good' or 'collectable'</li>
                        
			<?php if(!empty($errors['barcode'])){
					$errorBarcode='textfield-input error_message_box';
				}else{
					$errorBarcode='textfield-input';
				}
				?>
			<li><h4 class="gray-heading org-txt">Barcode</h4></li>
                         <li class="overflow-h">
                          	<div class="pound"></div>
                            <div class="float-left">
				<?php echo $form->input('ProductSeller.barcode',array( 'class'=>$errorBarcode, 'maxlength'=>'25', 'label'=>false,'div'=>false, 'error'=>false));?>
				</div>
                          </li>
                        <li>Enter the complete barcode number</li>
			<?php if(!empty($errors['price'])){
					$errorPrice='textfield-input small-width error_message_box';
				}else{
					$errorPrice='textfield-input small-width';
				}
				?>
                        <li>
                          <h4 class="gray-heading org-txt">Price</h4></li>
                        <li class="overflow-h">
                          	<div class="pound"></div>
                            <div class="float-left">
				<?php echo $form->input('ProductSeller.price',array('id'=>'product_seller_price_id', 'maxlength'=>'8', "onkeyup"=>"validateFloat('product_seller_price_id')", 'class'=>$errorPrice,'label'=>false,'div'=>false, 'error'=>false));?>
     		 </div>
                          </li>
                        <li class="gray smalr-fnt"><p>Lowest Marketplace (New Price):
				<?php if(!empty($product_details['Product']['minimum_price_value'])){
					echo CURRENCY_SYMBOL,$product_details['Product']['minimum_price_value'];
				}else{
				        echo CURRENCY_SYMBOL.''.$product_details['Product']['product_rrp'];
				}
				?>
			</p>
                          <p>Overall Lowest Marketplace Price (Including New and Used):
				<?php
				if(!empty($product_details['Product']['minimum_price_value']) || !empty($product_details['Product']['minimum_price_used'])){
					if($product_details['Product']['minimum_price_value'] < $product_details['Product']['minimum_price_used']){
						echo CURRENCY_SYMBOL.''. $product_details['Product']['minimum_price_value'];
					}else{
						echo CURRENCY_SYMBOL.''. $product_details['Product']['minimum_price_used'];
					}
				}else{
					 echo CURRENCY_SYMBOL.''.$product_details['Product']['product_rrp'];	
				}
				/*if(!empty($product_details['Product']['minimum_price_used'])){
						echo CURRENCY_SYMBOL,$product_details['Product']['minimum_price_used'];
						echo ' - '. $product_condition_array[$product_details['Product']['used_condition_id']];
				}else{
				        echo CURRENCY_SYMBOL.''.$product_details['Product']['product_rrp'];
				}*/
				?>
			  </p>
                          <p>RRP: <?php echo CURRENCY_SYMBOL;?><?php echo $product_details['Product']['product_rrp'];?></p>
                        </li>
                        
                      <li class="note"><span class="red-color">
               	      Please note:</span> Our automated price calculator varies your prices periodically to ensure you offer the most competitive price using the minimim price set, if there are more than 2 sellers for the product. <?php echo $html->link('Learn more',array('controller'=>'pages','action'=>'view','minimum-price-setting'),array('target'=>'_blank','escape'=>false, 'class'=>'underline-link'));?> about setting prices. </li>
                      <li>
		<?php
		//pr($this->data['ProductSeller']['minimum_price_disabled']);
		if(isset($this->data['ProductSeller']['minimum_price_disabled']) ){
				if($this->data['ProductSeller']['minimum_price_disabled'] == 0){
					$checked_mp = false;	
				}else{
					$checked_mp = true;
				}
		}else{
				
			$checked_mp = true;
		}
		echo $form->checkbox('ProductSeller.minimum_price_disabled',array('id'=>'min_price_desable_id', 'checked'=>$checked_mp,"class"=>"radio","label"=>false,"div"=>false)); ?>
                      Disable minimum price for this listing</li>
		      <?php if(!empty($errors['minimum_price'])){
					$errorMinPrice='textfield-input small-width error_message_box';
				}else{
					$errorMinPrice='textfield-input small-width';
				}
				?>
                      <li><strong>Minimum Price</strong></li>
                      <li class="overflow-h">
				<div class="pound"></div>
                            <div class="float-left"><?php echo $form->input('ProductSeller.minimum_price',array('id'=>'min_price_textbox', 'maxlength'=>'8', "onkeyup"=>"validateFloat('min_price_textbox')", 'class'=>$errorMinPrice,'label'=>false,'div'=>false, 'error'=>false));?></div>
                          </li>
                         <li><h4 class="gray-heading org-txt">Quantity</h4></li>
                         <li>All items included in a single listing must be in the same condition and be sold at the same price.</li>
                          <?php if(!empty($errors['quantity'])){
					$errorQuantity='textfield-input small-width error_message_box';
				}else{
					$errorQuantity='textfield-input small-width';
				}
				?>
			 <li class="overflow-h">
                          	<div class="pound"> </div>
                            <div class="float-left">
				
                              <?php echo $form->input('ProductSeller.quantity',array( 'id'=>'product_seller_quantity','maxlength'=>'9',"onkeyup"=>"validateFloat('product_seller_quantity')", 'class'=>$errorQuantity,'label'=>false,'div'=>false, 'error'=>false));?>
				</div>
                  </li>
                  
                  <li><h4 class="gray-heading">Your Reference Code <span class="gray smallr-width">[Optional]</span></h4></li>
                         <li>You may assign a reference code of your choice to this listing. If you have multiple listing this may help you manage your listings more easily.</li>
                         <li class="overflow-h">
                          	<div class="pound"> </div>
                            <div class="float-left">
				<?php echo $form->input('ProductSeller.reference_code',array('maxlength'=>15,'class'=>'textfield-input small-width','label'=>false,'div'=>false));?>
				<span class="instructions-line line-break">(Maximum length: 15 characters. Can contain number and letters.)</span>
		            </div>
                  </li>
                  
                  <li><h4 class="gray-heading org-txt">Dispatch Country</h4></li>
                        <li>Select the country you will be dispatching your item from if different from your default dispatch country.</li>
                        <li class="overflow-h"><div class="pound"> </div>
                            <div class="float-left">
                            <?php
			    if(!empty($errors['dispatch_country'])){
					$errorDispatchCountry ='textbox-m textfield-input error_message_box';
				}else{
					$errorDispatchCountry ='textbox-m textfield-input';
				}
			    
			    echo $form->select('ProductSeller.dispatch_country',$dispatchCountryArr,null,array('escape'=>false, 'type'=>'select','class'=>$errorDispatchCountry,'style'=>'float:none','label'=>false,'div'=>false,'size'=>1) ,'Select...' ); 
		            ?>
   		</div>
                        </li>
                        
                        <li>
                          <h4 class="gray-heading org-txt">Delivery Options</h4></li>
                        <li>Enter the standard delivery price. Please select the expedited service option if you can offer a faster dispatch and delivery option. <?php echo $html->link('Learn more',array('controller'=>'pages','action'=>'view','marketplace-delivery-times'),array('target'=>'_blank','escape'=>false, 'class'=>'underline-link'));?> about delivery services and timings before entering your prices.</li>
                        <li class="overflow-h"><div class="pound"> </div>
                            <div class="float-left"></div>
                        </li>
                        
                        <li><strong class="org-txt">Standard Delivery Price</strong></li>
                         <li class="overflow-h">
                            <div class="pound"></div>
                            <div class="float-left">
				<?php
				if(!empty($errors['standard_delivery_price'])){
					$errorStandardDeliveryPrice ='textfield-input small-width error_message_box';
				}else{
					$errorStandardDeliveryPrice ='textfield-input small-width';
				}
				
				echo $form->input('ProductSeller.standard_delivery_price',array('id'=>'product_standard_delivery_price', 'maxlength'=>'8', "onkeyup"=>"validateFloat('product_standard_delivery_price')",'class'=>$errorStandardDeliveryPrice,'label'=>false,'div'=>false,'error'=>false));?>
     		            </div>
                        </li>
                        
                        <li>
                      		<?php echo $form->checkbox('ProductSeller.express_delivery',array('id'=>'exp_del_price_checkbox', "class"=>"radio","label"=>false,"div"=>false)); ?>
                      Enable expedited delivery service option (Maximum 24 hour dispatch and delivery services)</li>
                      
                      <li><strong>Expedited Delivery Price</strong></li>
                         <li class="overflow-h">
                            <div class="pound"></div>
                            <div class="float-left">
				<?php echo $form->input('ProductSeller.express_delivery_price',array('id'=>'exp_del_price_textbox', 'maxlength'=>'8', "onkeyup"=>"validateFloat('exp_del_price_textbox')",'class'=>'textfield-input small-width','label'=>false,'div'=>false));?>
				 <div class="pound"></div>
			    </div>
                        </li>
			 
			 
                        <li><p style="margin-left:85px"><span class="orange-sml-btn orange-sml-btn-padd">
			<input type="button" alt="" class="orange-back" value="Back" onclick="history.back();"/></span>
				 <?php echo $form->button('',array('type'=>'submit','div'=>false,'class'=>'continue'));?></p>
			</li>
                  </ul>
              </div>
<?php  echo $form->end(); ?>
              <!--Form Widget Closed-->
              
              </div>
              <!--White box Start-->
              
          </div>
         <!--Blue Head Box Closed-->
            
      </div>
