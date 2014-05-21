<?php 
echo $javascript->link(array('jquery-1.3.2.min','lib/prototype', 'functions'));
echo $form->create('Offer',array('action'=>'edit/'.$offer_id,'method'=>'POST','name'=>'frmOffer','id'=>'frmOffer'));
//pr($offers_details);
$minimum_price_value = $format->money($offers_details['Product']['minimum_price_value'], 2);
?>
<script type="text/javascript">
jQuery(document).ready(function(){
		calculateOfferPrice();
		jQuery(':text').keyup(function(){
				calculateOfferPrice();
		});
});

/*
 functio to calculate the offer price for the entered price and quantity
*/
function calculateOfferPrice(){
	var price = jQuery('#offer_price_id').val();
	var qty   = jQuery('#offer_quantity_id').val();
	var offerPrice = (price * qty);
	if(offerPrice > 0){
		var num = new Number(offerPrice);
		var roundedofferPrice = num.toFixed(2);
				
		//var roundedofferPrice = roundNumber(offerPrice, 2);
		jQuery('#total_offer_price_id').html(roundedofferPrice);
	}
}
</script>
<!--Tabs Start-->
<?php echo $this->element('mobile/orders/tab');?>
<!--Tbs Closed-->
<!--Tbs Cnt start-->
<section class="tab-content padding0">
<!--My Offers Start-->
<section class="offers">                	
	<section class="gr_grd brd-tp0">
	<h4 class="bl-cl">My Offers</h4>
	<!--<div class="loader-img"><img src="images/loader.gif" width="22" height="22" alt="" /></div>-->
	</section>
	<!--Row1 Start-->
	<div class="row-sec">
	<?php
		if(!empty($errors)){
			$error_meaasge="Please add some information in the mandatory fields highlighted red below.";
		?>
		<div class="error_msg_box"> 
			<?php echo $error_meaasge;?>
		</div>
	<?php }?>
	<?php
		if ($session->check('Message.flash')){ ?>
			<div class="messageBlock"><?php echo $session->flash();?></div>
		<?php } ?>
	<h4 class="font14 choiceful">Edit My Offer</h4>
	
	<!--Products Start-->
	<div class="prod">
		

		<!--Order Products Widget Start-->
		<div class="order-products-widget">
		<div class="order-product-image">
			<?php 
			$product_id=$offers_details['Offer']['product_id'];
			$prodDetails = $this->Common->getProductMainDetails($product_id);
				if(!empty($prodDetails['Product']['product_image'])){
					$product_image = WWW_ROOT.PATH_PRODUCT.'small/img_75_'.$prodDetails['Product']['product_image'];
					
					if(file_exists($product_image)){
						echo $html->link($html->image('/'.PATH_PRODUCT.'small/img_75_'.$prodDetails['Product']['product_image'],array('alt'=>"")),'/'.$this->Common->getProductUrl($product_id).'/categories/productdetail/'.$product_id,array('escape'=>false));
					}else{
						echo $html->link($html->image('no_image_75.jpg',array('alt'=>"")),'/'.$this->Common->getProductUrl($product_id).'/categories/productdetail/'.$product_id,array('escape'=>false));
					}
				}else{
					echo $html->link($html->image('no_image_75.jpg',array('alt'=>"")),'/'.$this->Common->getProductUrl($product_id).'/categories/productdetail/'.$product_id,array('escape'=>false));
				}?>
		</div>                        
		<!--Order Product Content Start-->
		<div class="order-product-content">                           
			<!--Order Product Information Start-->
			<div class="order-pro-info">
			<p class="font11">Edit your offer before the seller responds.</p>
			<p class="toppadd">
				<b class="font14">Item: </b>
				<?php echo $offers_details['Product']['product_name'];?>
			</p>
			<p>
				<b class="font14">Seller: </b>
				<?php echo $offers_details['Seller']['business_display_name'];?>
				
			</p>
			</div>
			<!--Order Product Information Closed-->
		</div>
		<!--Order Product Content Closed-->                        
		<div class="clear"></div>
		
		<!--Seller Offer Start-->
		<div class="seller-offers">
			<ul>
			<li class="boldr">I want to pay: <?php echo CURRENCY_SYMBOL;?>
				<?php
						if(!empty($errors['offer_price'])){
							$erroroffer_price='edtoffrtxtbx error_message_box';
						}else{
							$erroroffer_price='edtoffrtxtbx';
						}
				?>
				<?php echo $form->input('Offer.offer_price', array('id'=>'offer_price_id',"onkeyup"=>"validateFloat('offer_price_id')",'maxlength'=>'9', 'type' =>'text','error' =>false, 'class'=>$erroroffer_price,'label'=>false,'div'=>false) ); ?>
				<!--<input type="text" value="&pound;19.99" class="edtoffrtxtbx" />-->
				
			</li>
			<li class="boldr margin-top">
				<span class="bl-clr" style="margin-top:3px;">Offers must be above 
				<?php echo CURRENCY_SYMBOL, $minimum_price_value ;?></span>
			</li>
			<li class="boldr margin-top">How many would you like to buy?:
				<?php
						if(!empty($errors['quantity'])){
							$errorQuantity='edtoffrtxtbx textfield sml-wdth error_message_box';
						}else{
							$errorQuantity='edtoffrtxtbx textfield sml-wdth';
						}
				?>
				<?php echo $form->input('Offer.quantity',array('id'=>'offer_quantity_id', "onkeyup"=>"validateNumber('offer_quantity_id')", 'type'=>'text','error' =>false, 'maxlength'=>5,'label'=>false,'class'=>$errorQuantity,'style="width:50px;"','div'=>false));?>
				
				<!--<input type="text" value="1" class="edtoffrtxtbx" />-->
			</li>
			
			<li class="boldr margin-top">
			Expires on: <span class="redcolor">
			
			<?php
				$current_date = $offers_details['Offer']['created'];// current date
				echo $expiry_date = date('d/m/Y', strtotime(date("Y-m-d", strtotime($current_date)) . " +2 day"));
			?>
			
			</span><span style="margin-left:15px;">Offer value: </span>
			<?php echo CURRENCY_SYMBOL;?><span id="total_offer_price_id"></span>
			
			</li>
				<li class="margin-top">
					<!--<input type="button" class="grenbtn margin-top" value="Edit Offer">-->
					<?php echo $form->hidden('Offer.id',array('value'=>$offer_id,'type'=>'text','label'=>false,'div'=>false));?>
					<?php echo $form->hidden('Offer.minimum_price_value',array('value'=>$minimum_price_value,'type'=>'text','label'=>false,'class'=>'textfield','div'=>false));?>
					
					<?php echo $form->submit('Edit Offer', array('class'=>'grenbtn margin-top','div'=>false));?>
					
					<?php //echo $form->button('Edit Offer',array('type'=>'button','class'=>'grenbtn margin-top','div'=>false));?>
				
				</li>

			</ul>
		</div>
		<!--Seller Offer Closed-->
		
		</div>
		<!--Order Products Widget Closed-->
		
	</div>
	<!--Products Closed-->
	
	</div>
</section>
<!--My Offers Closed-->

</section>
<!--Tbs Cnt closed-->
<!--My Offers Closed-->
<?php echo $form->end(); ?>
