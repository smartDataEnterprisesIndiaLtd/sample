<?php
echo $javascript->link(array('jquery-1.3.2.min','lib/prototype'),false);
echo $javascript->link(array('behaviour.js','textarea_maxlen'));
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
		var restChars = 1000 - charlength;
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
		if(expDelPriceChkbox == true){
				jQuery('#exp_del_price_textbox').attr('disabled', false);
		}else{
			jQuery('#exp_del_price_textbox').val('');
		        jQuery('#exp_del_price_textbox').attr('disabled', true);	
		}
}
</script>
<!--Tabs Start-->
<?php echo $this->element('mobile/orders/tab');?>
<!--Tbs Closed-->
<!--Tbs Cnt start-->
<section class="tab-content padding0">
<!--Manage Listings Start-->
<?php // display session error message
if ($session->check('Message.flash')){ ?>
<div  class="messageBlock"><?php echo $session->flash();?></div>
<?php } ?>
        
<section class="offers">                	
	<section class="gr_grd brd-tp0">
	<h4 class="orange-col-head">
		<?php if(empty($product_seller)){?>
				Enter Listing Details
		<?php }else{?>
				Edit Listing
		<?php }?>
	</h4>
	</section>
	<?php if(!empty($errors)){?>
		<div class="error_msg_box"> 
			Please add some information in the mandatory fields highlighted red below.
		</div>
	<?php }?>
	<!--mid Content Start-->
	<div class="mid-content">
	<!--Product Listings Widget Start-->
	<div class="products-listings-widget">
		<!--Row1 Start-->
		<div class="pro-listing-row">
		<div class="pro-img">
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
				echo $html->link($html->image($image_path, array('alt'=>"", 'height'=>'79', 'width'=>'69')),'/'.$this->Common->getProductUrl($product_details['Product']['id']).'/categories/productdetail/'.$product_details['Product']['id'],array('escape'=>false,));
				?>
		</div>
		<div class="product-details-widget">
			<h4 class="lstprdctname">
				<?php echo $html->link($product_details['Product']['product_name'],"/".$this->Common->getProductUrl($product_details['Product']['id'])."/categories/productdetail/".$product_details['Product']['id'],array('escape'=>false,'class'=>'underline-link'));?>
			</h4>
			<p class="lgtgray">
				<strong>
					Model # <?php echo $product_details['Product']['model_number'];?>
				</strong>
			</p>
			<p class="lgtgray">
				<strong>QuickCode: 
					<?php echo $product_details['Product']['quick_code'];?>
				</strong>
			</p>
			<p class="lgtgray">
				<strong>Number of Sellers: <?php echo $product_sellers_count; ?>
				</strong>
			</p>
		</div>
		<div class="clear"></div>
		</div>
		<!--Row1 Closed-->
	</div>
	<!--Product Listings Widget Closed-->
	
		<?php
		echo $form->create('Marketplace',array('action'=>'create_listing/'.$product_id,'method'=>'POST','name'=>'frmMarketplace','id'=>'frmMarketplace'));
		echo $form->hidden('ProductSeller.product_id', array('value'=>$product_id));
		//pr($product_details);
		?>
	<!--Form Widget Start-->
		
	<div class="form-widget row-sec">
		<ul>
		<li><p>
		<?php if(empty($product_seller)){?>
				In order to sell this product you will have to enter all mandatory fields
		<?php }else{?>
				Edit your listing details below and click save.
		<?php }?>
		</p></li>
		<li><h4 class="gray-heading">Condition <span class="star">*</span></h4></li>
		<li><p>Select the condition of your item.</p></li>
		<li>
		        <?php 
			if(($form->error('ProductSeller.condition_id'))){
				  	$errorClassCon='select full-width error_message_box';
				}else{
					$errorClassCon='select full-width';
				}
		         ?>
			<?php echo $form->select('ProductSeller.condition_id', $product_condition_array, $product_seller['ProductSeller']['condition_id'],array('class'=>$errorClassCon,'style'=>'float:none', 'type'=>'select','label'=>false,'div'=>false),'Select...');?>
		</li>
		<li><h4 class="gray-heading larger-font">Comment <span class="lgtgray font11">[Optional]</span></h4></li>
		<li>
			<p class="pad-rt2">
			<?php  echo $form->input('ProductSeller.notes',array( 'maxlength'=>1000, 'rows'=>'5','cols'=>'50', 'value'=>$product_seller['ProductSeller']['notes'], 'class'=>'ttextfield width-full','label'=>false,'div'=>false));?>
			<p class="font10 lgtgray margin-top" id="show_remaining_chars">[1000 characters left]</p>
     		</li>
		<li>You may choose to provide short comments to highlight specific details.</li>
		<li>Include details relating to the condition of your listing, such as 'good' or 'collectable'</li>
			<li><h4 class="gray-heading">Barcode <span class="star">*</span></h4></li>
			<li>
				<?php 
						if(($form->error('ProductSeller.barcode'))){
							$errorClassBar='input width150 error_message_box';
						}else{
							$errorClassBar='input width150';
						}
				?>
				<?php echo $form->input('ProductSeller.barcode',array('class'=>$errorClassBar,'label'=>false,'value'=>$product_seller['ProductSeller']['barcode'],'div'=>false,'error'=>false));?>
			</li>
			<li>Enter the complete barcode number</li>
			<li><h4 class="gray-heading">Price <span class="star">*</span></h4></li>
			<li class="overflow-h">
			<div class="pound"><span class="larger-fnt"><strong>&pound;</strong></span></div>
			<div class="float-left">
				<?php 
						if(($form->error('ProductSeller.price'))){
							$errorClassPri='input wdth100 error_message_box';
						}else{
							$errorClassPri='input wdth100';
						}
				?>
				<?php echo $form->input('ProductSeller.price',array('id'=>'product_seller_price_id','value'=>$product_seller['ProductSeller']['price'], "onkeyup"=>"validateFloat('product_seller_price_id')", 'class'=>$errorClassPri,'label'=>false,'div'=>false,'error'=>false));?>
				
			<!--<input type="text" name="textfield2" class="input wdth100" />-->
			</div>
			</li>
			<li class="lgtgray font11"><p>Lowest Marketplace Buy Now (New Price): 
				<?php if(!empty($product_details['Product']['minimum_price_value'])){
					echo CURRENCY_SYMBOL,$product_details['Product']['minimum_price_value'];
				}?></p>
				<p>Overall Lowest Marketplace Buy Now Price: 
					<?php if(!empty($product_details['Product']['minimum_price_used']) && $product_details['Product']['minimum_price_used'] > 0){
						echo CURRENCY_SYMBOL,$product_details['Product']['minimum_price_used'];
						echo ' - '. $product_condition_array[$product_details['Product']['used_condition_id']];
					}?>
				</p>
			<p>Used/Like New</p>
			
			<p>RRP:
				<?php echo CURRENCY_SYMBOL;?><?php echo $product_details['Product']['product_rrp'];?>
			</p>
			
			</li>
			<li class="note"><span class="redcolor">Please note:</span> Our automated price calculator varies your prices periodically to ensure you offer the most competitive price using the minimim price set, if there are more than 2 sellers for the product.</li>
			<li class="margin">
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
				echo $form->checkbox('ProductSeller.minimum_price_disabled',array('id'=>'min_price_desable_id', 'checked'=>$checked_mp, "class"=>'leftcheckbox',"label"=>false,"div"=>false)); ?>
				
			<!--<input type="checkbox" name="checkbox" class="radio" />--> Disable minimum price for this listing
			
			</li>
			<li><strong>Minimum Price</strong></li>
			<li class="overflow-h">
			<div class="pound"><span class="larger-fnt"><strong><?php echo CURRENCY_SYMBOL;?></strong></span></div>
			<div class="float-left">
				
			<?php echo $form->input('ProductSeller.minimum_price',array('id'=>'min_price_textbox', 'value'=>$product_seller['ProductSeller']['minimum_price'],"onkeyup"=>"validateFloat('min_price_textbox')", 'class'=>'input wdth100','label'=>false,'div'=>false));?>
			
			<!--<input type="text" name="textfield2" class="input wdth100" />-->
			</div>
			</li>
			
			<li><h4 class="gray-heading">Quantity <span class="star">*</span></h4></li>
			<li>All items included in a single listing must be in the same condition and be sold at the same price.</li>
			<li class="overflow-h">
				<?php 
						if(($form->error('ProductSeller.quantity'))){
							$errorClassQua ='input lwr-wdth error_message_box';
						}else{
							$errorClassQua ='input lwr-wdth';
						}
				?>
			 <?php echo $form->input('ProductSeller.quantity',array('id'=>'product_seller_quantity','value'=>$product_seller['ProductSeller']['quantity'], "onkeyup"=>"validateFloat('product_seller_quantity')", 'class'=>$errorClassQua,'label'=>false,'div'=>false,'error'=>false));?>
			<!--<input type="text" name="textfield2" class="input lwr-wdth" />-->
			</li>
			
			<li><h4 class="gray-heading">Your Reference Code <span class="lgtgray font11">[Optional]</span></h4></li>
			<li>You may assign a reference code of your choice to this listing. If you have multiple listing this may help you manage your listing more easily.</li>
			<li>
			<?php echo $form->input('ProductSeller.reference_code',array('maxlength'=>15,'class'=>'input width150','label'=>false,'div'=>false));?>
			<p class="font11 margin-top">(Maximum length: 15 characters. Can contain number and letters.)</p>
		</li>
		
		<li><h4 class="gray-heading">Dispatch Country <span class="star">*</span></h4></li>
		<li>Select the country you will be dispatching your item from if different from your default dispatch country.</li>
				<li>
				<?php 
						if(($form->error('ProductSeller.dispatch_country'))){
							$errorClassDC ='select full-width error_message_box';
						}else{
							$errorClassDC ='select full-width';
						}
				?>
				<?php echo $form->select('ProductSeller.dispatch_country',$dispatchCountryArr,$product_seller['ProductSeller']['dispatch_country'],array('escape'=>false, 'type'=>'select','class'=>$errorClassDC,'style'=>'float:none','label'=>false,'div'=>false,'error'=>false,'size'=>1) ,'Select...' ); 
				?>

			<!--<select name="select2" class="select full-width">
			<option>Select... </option>
			</select>-->
		</li>
			<li>
			<h4 class="gray-heading">Delivery Options <span class="star">*</span></h4></li>
			<li>Enter the standard delivery price. Please select the expedited service option if you can offer a faster dispatch and delivery option. </li>
			
		<li><strong>Standard Delivery Price</strong></li>
		<li class="overflow-h">
		<div class="pound"><span class="larger-fnt"><strong>
		<?php echo CURRENCY_SYMBOL;?></strong></span></div>
		<div class="float-left">
				<?php 
						if(($form->error('ProductSeller.standard_delivery_price'))){
							$errorClassDdp ='input wdth100 error_message_box';
						}else{
							$errorClassDdp ='input wdth100';
						}
				?>
			<?php echo $form->input('ProductSeller.standard_delivery_price',array('id'=>'product_standard_delivery_price','value'=>$product_seller['ProductSeller']['standard_delivery_price'], "onkeyup"=>"validateFloat('product_standard_delivery_price')",'class'=>$errorClassDdp,'label'=>false,'div'=>false,'error'=>false));?>
			</div>
		</li>
		
		<li><?php echo $form->checkbox('ProductSeller.express_delivery',array('id'=>'exp_del_price_checkbox', "class"=>"leftcheckbox","label"=>false,"div"=>false)); ?>
		Enable expedited delivery service option</li>
		<li>(Maximum 48 hour dispatch and delivery service)</li>
		
		<li><strong>Expedited Delivery Price</strong></li>
		<li class="overflow-h">
		<div class="pound"><span class="larger-fnt"><strong>
		<?php echo CURRENCY_SYMBOL;?></strong></span></div>
		<div class="float-left">
			<?php echo $form->input('ProductSeller.express_delivery_price',array('id'=>'exp_del_price_textbox','value'=>$product_seller['ProductSeller']['express_delivery_price'],"onkeyup"=>"validateFloat('exp_del_price_textbox')",'class'=>'input wdth100','label'=>false,'div'=>false));?>
			</div>
		</li>
		</ul>
	</div>
	<!--Form Widget Closed-->
	
	<!--For Going Back To Previous Page-->
	<section class="backbtnbox">
		<!--<input type="button" value="Continue" class="green-btn"/>-->
		<?php if(empty($product_seller)){
				echo $form->submit('Continue',array('type'=>'submit','div'=>false,'class'=>'grenbtn'));
		}else{
				echo $form->submit('Save',array('type'=>'submit','div'=>false,'class'=>'grenbtn'));
		}?>
		<!--<input type="button" value="Continue" class="green-btn"/>-->
	</section>
	<!--For Going Back To Previous End-->  
	<?php  echo $form->end(); ?>
</div>
<!--mid Content Closed-->
</section>
<!--Manage Listings Closed-->

</section>
<!--Tbs Cnt closed-->
