<style>
	.popup-widget {
    padding: 0px 5px!important;
    position: relative;
}
.popup-width2 {
    width: 275px;
}
</style>
<?php 
echo $javascript->link(array('jquery-1.3.2.min','lib/prototype'));
echo $javascript->link('fancybox/jquery.fancybox-1.3.1.pack.js');
echo $javascript->link('fancybox/jquery.easing-1.3.pack.js');
echo $javascript->link('fancybox/jquery.mousewheel-3.0.2.pack.js');
echo $html->css('jquery.fancybox-1.3.1.css');

echo $form->create('Offer',array('action'=>'update_offer_status/'.$offer_id.'/'.$offer_status,'method'=>'POST','name'=>'frmOffer','id'=>'frmOffer'));

if($offer_status == 2){
    $button_text = "Reject Offer";
}else{
    $button_text = "Accept offer";
}

//pr($offers_details);
?>

<!-- Script for disable button once clicked -->
<script>
jQuery(document).ready(function()  {
	//disable submit button after one click
	jQuery('#clickOnce').click(function(){
		if(jQuery("#CancelOrderReason").val() != "")
		{
			jQuery('#frmOffer').submit();
			jQuery("#clickOnce").attr("disabled", "true");
		}
	});
});
</script>

<!--Popup Widget Start-->
<div class="popup-widget popup-width2">
<?php 
if ($session->check('Message.flash')){ ?>
	<div class="messageBlock"><?php echo $session->flash();?></div>
<?php }
?>
<?php if(is_array($offers_details)  &&  !empty($offer_id) ) { ?>
    <ul class="pop-content-list">
    	<li><h4 class="orange-color-text">Make me an Offer&trade;</h4></li>
        <li><span class="smlr-fnt">
	
	<?php  if($offer_status == 2) { ?>
	<strong>Reject an offer.</strong>
	<?php }else{ ?>
	<strong>Accept an offer.</strong> The buyer has up to 48 hours to purchase at the offer price.
	<?php } ?></span></li>
        <li><span class="larger-font"><strong>Item:</strong></span><?php echo $offers_details['Product']['product_name'];?></li>
        <li><p><strong>I'd like to pay:</strong> <span class="dif-blue-color"><strong><?php echo CURRENCY_SYMBOL,$offers_details['Offer']['offer_price'];?></strong></span></p>
          <p><strong>I will be buying:</strong> <span class="dif-blue-color"><strong><?php echo $offers_details['Offer']['quantity'];?></strong></span></p>
          <p>Thank you for considering my offer.</p>
        </li>
	<li>
	<p class="margin"><strong>Expires on:</strong>
		<span class="red-color-text"><strong>
		<?php
		$current_date = $offers_details['Offer']['created']; // current date
		echo $expiry_date = date('d/m/Y', strtotime(date("Y-m-d", strtotime($current_date)) . " +2 day"));
		
		$offer_value = ($offers_details['Offer']['offer_price'] *$offers_details['Offer']['quantity']);
		 
		?>
		</strong></span>  <span class="padng-lft"><strong>Offer value: <?php echo CURRENCY_SYMBOL,number_format($offer_value,2);?><span id="total_offer_price_id"></span></strong></span></p>
        </li>
	<?php  if($offer_status == 2) { ?>
	<li class="smlr-fnt"><strong>What happens next:</strong> we contact the buyer on your behalf to notify that you have rejected their offer price.</li>
	<?php }else{ ?>
	<li class="smlr-fnt"><strong>What happens next:</strong> We contact the buyer on your behalf to notify that they can purchase at the offer price. Please allow up to 48 hours for the purchase to be made.</li>
	<?php } ?>
        
        <li>
        	<div class="orange-button-widget">
		<?php
		echo $form->hidden('Offer.id',array('value'=>$offer_id,'type'=>'text','label'=>false,'div'=>false));
		echo $form->hidden('Offer.offer_status',array('value'=>$offer_status,'type'=>'text','label'=>false,'div'=>false));
		//echo $form->button($button_text,array('type'=>'submit','class'=>'orange-btn-input','div'=>false, 'escape'=>false));?>
		<input type="submit" value="<?=$button_text?>" class="orange-btn-input" id="clickOnce" name="button">
		</div>
	</li>
    </ul>
    <?php } ?>
</div>
<!--Popup Widget Closed-->
<?php echo $form->end(); ?>