<?php 
echo $javascript->link(array('jquery-1.3.2.min','lib/prototype'));
echo $javascript->link('fancybox/jquery.fancybox-1.3.1.pack.js');
echo $javascript->link('fancybox/jquery.easing-1.3.pack.js');
echo $javascript->link('fancybox/jquery.mousewheel-3.0.2.pack.js');
echo $html->css('jquery.fancybox-1.3.1.css');

echo $form->create('Offer',array('action'=>'delete_offer/',$offer_id,'method'=>'POST','name'=>'frmOffer','id'=>'frmOffer'));


?>
<style>
  	.popup-widget {
    padding: 0px 5px!important;
    position: relative;
}
</style>
<!--Popup Widget Start-->
<div class="popup-widget popup-width2">
  <?php 
if ($session->check('Message.flash')){ ?>
<div >
	<div class="messageBlock"><?php echo $session->flash();?></div>
</div>
<?php }
?>

<?php if(is_array($offers_details)  &&  !empty($offer_id) ) { ?>
    <ul class="pop-content-list">
    	<li><h4 class="orange-color-text">Make me an Offer&trade;</h4></li>
        <li><span class="smlr-fnt"><strong></strong>Withdraw your offer before the seller responds.</span></li>
        <li>
        	<p><span class="larger-font"><strong>Item:</strong></span><?php echo $offers_details['Product']['product_name'];?></p>
            <p class="margin"><span class="larger-font"><strong>Seller:</strong></span> <?php echo $offers_details['Seller']['business_display_name'];?></p>
        </li>
        <li>
          <p><strong>I want to pay:</strong> <span class="dif-blue-color"><strong><?php echo CURRENCY_SYMBOL,$offers_details['Offer']['offer_price'];?></strong></span></p>
          <p><strong>How many would you like to buy?:</strong> <span class="dif-blue-color"><strong><?php echo $offers_details['Offer']['quantity'];?></strong></span></p>
       
	<p class="margin"><strong>Expires on:</strong>
		<span class="red-color-text"><strong>
		<?php
		$current_date = $offers_details['Offer']['created']; // current date
		echo $expiry_date = date('d/m/Y', strtotime(date("Y-m-d", strtotime($current_date)) . " +2 day"));
		
		$offer_value = ($offers_details['Offer']['offer_price'] *$offers_details['Offer']['quantity']);
		 
		?>
		</strong></span>  <span class="padng-lft"><strong>Offer value: <?php echo CURRENCY_SYMBOL,number_format($offer_value,2);?><span id="total_offer_price_id"></span></strong></span></p>
      
	
	  <!--<p><strong>Expires on:</strong> <span class="red-color-text"><strong>15/10/2020</strong></span>  <span class="padng-lft"><strong>Offer value: &pound;19.99</strong></span></p>-->
        </li>
        <li>
        	<div class="orange-button-widget">
		<?php echo $form->hidden('Offer.id',array('value'=>$offer_id,'type'=>'text','label'=>false,'class'=>'textfield','div'=>false));?>
		<?php echo $form->button('Delete my offer',array('type'=>'submit','class'=>'orange-btn-input','div'=>false));?>
		</div>
        </li>
    </ul>
    
    <?php } ?>
</div>
<!--Popup Widget Closed-->

<?php echo $form->end(); ?>