<?php 
//echo $javascript->link(array('jquery-1.3.2.min','lib/prototype', 'functions'));
$offerSerialize['p_id']  = $product_id;
$offerSerialize['s_id']  = $seller_id;
$offerSerialize['c_id']  = $condition_id;
$offerSerialize['type']  = $offer_type;
$encodeOfferData = base64_encode(serialize($offerSerialize));
echo $form->create('Offer',array('action'=>'add/'.$encodeOfferData,'method'=>'POST','name'=>'frmOffer','id'=>'frmOffer'));?>
<?php echo $form->hidden('Offer.product_id',array('value'=>$product_id, 'type'=>'text','label'=>false,'class'=>'textfield','div'=>false));?>
<?php echo $form->hidden('Offer.offer_type',array('value'=>$offer_type, 'type'=>'text','label'=>false,'class'=>'textfield','div'=>false));?>
<?php echo $form->hidden('Offer.recipient_id',array('value'=>$seller_id,'type'=>'text','label'=>false,'class'=>'textfield','div'=>false));?>
<?php 
echo $form->hidden('Offer.minimum_price_value',array('value'=>$product_detail['Product']['minimum_price_value'],'type'=>'text','label'=>false,'class'=>'textfield','div'=>false));?>
<?php echo $form->hidden('Offer.condition_id',array('value'=>$condition_id, 'type'=>'text','label'=>false,'class'=>'textfield','div'=>false));?>

<script type="text/javascript">
 
jQuery(document).ready(function(){
		calculateOfferPrice();
		jQuery(':text').keyup(function(){
				calculateOfferPrice();
		});
		//jQuery('#offer_quantity_id').keyup(function(){
		//		calculateOfferPrice();
		//});
		
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

<ul class="offerbox">
	<?php if ($session->check('Message.flash')){ ?>
	<li>
		<div class="messageBlock"><?php echo $session->flash();?></div>
	</li>
	<?php }	?>
	
	<?php
	if($condition_id == 1 || $condition_id == 4){ // for new 
		$minimum_price_value = $format->money($product_detail['Product']['minimum_price_value'], 2);	
	}else{
		$minimum_price_value = $format->money($product_detail['Product']['minimum_price_used'], 2);
	}
	?>
	
	<li class="orange-col-head mkmoffr">Make me an Offer<sup>TM</sup>
	
	<?php if(strtoupper($offer_type) == 'M'){ ?>
		<span>(Multiple Seller Offer)</span>
	<?php } ?>
	</li>
	<?php if(!empty($errors)){?>
         <li>	
		<div class="error_msg_box"> 
			Please complete the mandatory fields highlighted below.
		</div>
	</li>
	<?php }?>
	
	<li class="font11">Use Make me an Offer to buy at the prices you set.
		<span class="fylldetyl bluclr boldr">Fill in the details below and send your offer.</span></li>
	<li class="applprdct">
	<span class="font13 boldr">Seller:</span> 
		<?php
		if(strtoupper($offer_type) == 'M'){  // show all sellers name with comma separated
		if(is_array($sellerIds)){
			$sellerName = '';
			foreach($sellerIds as $sellerId){
				$sellerDetails = $this->Common->getsellerInfo($sellerId);
				if(!empty($sellerDetails['Seller']['business_display_name']) ){
						$sellerName .= $sellerDetails['Seller']['business_display_name'];
						$sellerName .= ",&nbsp;";
				}
				
			}
			echo rtrim($sellerName, ',&nbsp;');
		}
		}else{  //  show the only lowest  price seller name
		$sellerDetails = $this->Common->getsellerInfo($seller_id);
		echo $sellerDetails['Seller']['business_display_name'];
		}?>
	</li>
	<li class="boldr">I want to pay: 
		<span class="font16" style="position:absolute;"><?php echo CURRENCY_SYMBOL;?> </span>
		<span style="margin-left:12px;"><?php 
		if(($form->error('Offer.offer_price'))){
			$errorClass='textfield sml-wdth error_message_box';
		}else{
			$errorClass='textfield sml-wdth';
		}
		echo $form->input('Offer.offer_price', array('id'=>'offer_price_id','error'=>false, "onkeyup"=>"validateFloat('offer_price_id'),calculateOfferPrice()",'maxlength'=>'9', 'type' =>'text', 'class'=>$errorClass,'label'=>false,'div'=>false) ); ?></span>
		
		<!--<input type="text" value="19.99" />-->
	</li>
	<li class="bluclr boldr margin-top">Offers must not be above 
		<?php echo CURRENCY_SYMBOL, $minimum_price_value ;?>
	</li>
	<li class="boldr applprdct">How many would you like to  buy?:
		<span><?php 
		if(($form->error('Offer.offer_price'))){
			$errorClass='textfield sml-wdth error_message_box';
		}else{
			$errorClass='textfield sml-wdth';
		}
		echo $form->input('Offer.quantity',array('id'=>'offer_quantity_id', "onkeyup"=>"validateNumber('offer_quantity_id'),calculateOfferPrice()", 'type'=>'text','maxlength'=>5,'label'=>false,'class'=>$errorClass,'div'=>false,'error'=>false));?></span>
		<!--<input type="text" value="1" />-->
	</li>
	<li class="boldr">Expires on: 
		<span class="redcolor">
			<?php
				$current_date = date("Y-m-d"); // current date
				echo $expiry_date = date('d/m/Y', strtotime(date("Y-m-d", strtotime($current_date)) . " +2 day"));
		        ?>
		</span>  
		<span class="mrgn-lft">Offer value:
			<?php echo CURRENCY_SYMBOL;?><span id="total_offer_price_id"></span>
		</span>
	</li>
	 <li style="margin-top:12px;">
			<?php $options=array(
					"url"=>"/offers/add/".$encodeOfferData,"before"=>"",
					"update"=>"tab2",
					"indicator"=>"plsLoaderID",
					'loading'=>"Element.show('plsLoaderID')",
					"complete"=>"Element.hide('plsLoaderID')",
					"class" =>"ornggradbtn",
					"type"=>"Submit",
					"id"=>"custinfo",
					"div"=>false
				); echo $ajax->submit('Make me an offer',$options);?>
        </li>
	<!--<li style="margin-top:12px;"><input type="button" class="ornggradbtn" value="Make me an offer"></li>-->
</ul>

<?php echo $form->end(); ?>