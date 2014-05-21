<?php 
echo $javascript->link(array('jquery-1.3.2.min','lib/prototype', 'functions'));
echo $javascript->link('fancybox/jquery.fancybox-1.3.1.pack.js');
echo $javascript->link('fancybox/jquery.easing-1.3.pack.js');
echo $javascript->link('fancybox/jquery.mousewheel-3.0.2.pack.js');
echo $html->css('jquery.fancybox-1.3.1.css');

echo $form->create('Offer',array('action'=>'edit/'.$offer_id,'method'=>'POST','name'=>'frmOffer','id'=>'frmOffer'));
//pr($offers_details);
$minimum_price_value = $format->money($offers_details['Product']['minimum_price_value'], 2);

?>
<style>
       .textbox{
		float:left;margin-right:5px;
       }
            	.popup-widget {
    padding: 0px 5px!important;
    position: relative;
}
</style>
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

<!--Popup Widget Start-->
<div class="popup-widget popup-width3">
<?php 
if ($session->check('Message.flash')){ ?>
<div class="messageBlock"><?php echo $session->flash();?></div>
<?php } ?>

		<?php
		        if(!empty($errors)){
				$error_meaasge="Please add some information in the mandatory fields highlighted red below.";
			?>
			<div class="error_msg_box"> 
				<?php echo $error_meaasge;?>
			</div>
		<?php }?>
    <ul class="pop-content-list">
    	<li><h4 class="orange-color-text">Make me an Offer&trade;</h4></li>
        <li><span class="smlr-fnt"><strong></strong>Edit your offer before the seller responds.</span></li>
        <li>
        	<p><span class="larger-font"><strong>Item:</strong></span> <?php echo $offers_details['Product']['product_name'];?></p>
            <p class="margin"><span class="larger-font"><strong>Seller:</strong></span> <?php echo $offers_details['Seller']['business_display_name'];?></p>
        </li>
	
         <li>
          <span style="float:left; margin-top:-1px;"><strong>I want to pay:</strong> <strong class="largr-font"><?php echo CURRENCY_SYMBOL;?>&nbsp</strong></span>
          <span>
		<?php
				if(!empty($errors['offer_price'])){
					$erroroffer_price='textbox textfield sml-wdth error_message_box';
				}else{
					$erroroffer_price='textbox textfield sml-wdth';
				}
		?>
	  <?php echo $form->input('Offer.offer_price', array('id'=>'offer_price_id', "onkeyup"=>"validateFloat('offer_price_id')",'maxlength'=>'6', 'type' =>'text', 'class'=>$erroroffer_price, 'error'=>false,'label'=>false,'div'=>false) ); ?></span> &nbsp;
         </li>
	 
	 <li>
	 <span class="bl-clr"><strong>Do not offer  more than <?php echo CURRENCY_SYMBOL, $minimum_price_value ;?></strong></span></p>
         <span style="float:left; margin-top: -1px;"> <p class="margin"><strong>How many would you like to buy?:&nbsp</strong> </p></span>
         <span>
		<?php
				if(!empty($errors['quantity'])){
					$errorQuantity='textbox textfield sml-wdth error_message_box';
				}else{
					$errorQuantity='textbox textfield sml-wdth';
				}
		?>
	 
	 <?php echo $form->input('Offer.quantity',array('id'=>'offer_quantity_id', "onkeyup"=>"validateNumber('offer_quantity_id')", 'type'=>'text','maxlength'=>5,'label'=>false,'class'=>$errorQuantity, 'error'=>false, 'div'=>false));?> </span></p> 
         <p class="margin" style="float:left;"><strong>Expires on:</strong>
		<span class="red-color-text"><strong>
		<?php
		$current_date = $offers_details['Offer']['created'];// current date
		echo $expiry_date = date('d/m/Y', strtotime(date("Y-m-d", strtotime($current_date)) . " +2 day"));
		?>
		</strong></span>  <span class="padng-lft"><strong>Offer value: <?php echo CURRENCY_SYMBOL;?><span id="total_offer_price_id"></span></strong></span></p> <br>&nbsp;
        </li>
	      <br/>
        <li>
        	<div class="orange-button-widget">
		<?php echo $form->hidden('Offer.id',array('value'=>$offer_id,'type'=>'text','label'=>false,'div'=>false));?>
		<?php echo $form->hidden('Offer.minimum_price_value',array('value'=>$minimum_price_value,'type'=>'text','label'=>false,'class'=>'textfield','div'=>false));?>
		<?php echo $form->button('Edit my offer',array('type'=>'submit','class'=>'orange-btn-input','div'=>false));?>
		</div>
        </li>
    </ul>
</div>
<!--Popup Widget Closed-->
<?php echo $form->end(); ?>

<script>
var err_msg_alert = '<?php echo $errors ?>';
if((err_msg_alert != '') && (jQuery("#fancybox-content",parent.document).height() == 240))
{
	jQuery("#fancybox-content",parent.document).height(jQuery("#fancybox-content",parent.document).height()+50);
}
</script>
