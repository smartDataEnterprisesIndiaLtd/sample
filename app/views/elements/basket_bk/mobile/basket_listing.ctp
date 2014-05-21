<?php ?>
<div id="basket_listing">
<script type="text/javascript">
// function to  show updated mini basket after completeing the action
function updateCartData(){
	showUpdatedCart();
	jQuery('#plsLoaderID').hide();
}
</script>
        	
<!--Shopping Basket Start-->
	<?php
	if ($session->check('Message.flash')){
		$divclass = "";
		?>
			<?php echo $session->flash();?>
	<?php }else{
		$divclass = "cart-row-content";
}?>

<style>
.spngbsktitem .ornggradbtn{
margin-bottom:8px;
}
.giftzotns a{
	color:#000;
}
</style>
 <span id="plsLoaderID" style="display:none; text-align:center; margin-left:50%" class="dimmer"><?php echo $html->image("loading.gif" ,array('alt'=>"Loading" ,  'style'=>'position:absolute;left:30%;top:40%;z-index:999;'));?>
</span>
<!-- Start Shopping list -->
<?php
	$NewUsedcondArray= $this->Common->get_new_used_conditions();
	//pr($cartData); 	//die();
	  $subTotal = 0;
	  $shippingTotal = 0;
	  
	  $cartCount = count($cartData);
	//$totalQty ,
	if(is_array($cartData) && $cartCount >0 ) {
	 // end($cartData);
	$prodQty = $std_del_price = $totalItemPrice = '';
	$totalQty = $prodId = $prodPrice = '';
	$i= 0;
	foreach($cartData as $cart){
		$i++;    
	  
	  $prodId 	= $cart['Basket']['product_id'];
	  $sellerId 	= $cart['Basket']['seller_id'];
	  $cartId 	= $cart['Basket']['id'];
				    
	  $prodName 	= $cart['Product']['product_name'];
	  $prodQty 	=  $cart['Basket']['qty'];
	  $prodPrice 	= $cart['Basket']['price'];
	  $delivery_cost  = $cart['Basket']['delivery_cost'];
	  $condition 	  = $NewUsedcondArray[$cart['Basket']['condition_id']];
	 
	 
	  ###  product seller info ###
	 
	  $prodSellerInfo = $common->getProductSellerInfo($prodId,$sellerId, $cart['Basket']['condition_id'] );
	  $totalQty 	  = $prodSellerInfo['ProductSeller']['quantity'];
	  $express_delivery = $prodSellerInfo['ProductSeller']['express_delivery'];
	    if( empty($totalQty) ){ //skip item if seller have 0  item to sale 
		 continue;
	    }
	  #--------------------------#
		
	  ### Seller information ########
	  $SellerInfo     = $common->getsellerInfo($sellerId );
	  $sellerName     = $SellerInfo['Seller']['business_display_name'];
	  $gift_service   = $SellerInfo['Seller']['gift_service'];
	  $free_delivery  = $SellerInfo['Seller']['free_delivery'];
	  $threshold_order_value  = $SellerInfo['Seller']['threshold_order_value'];
	 // pr($prodSellerInfo);
	 
	  
		
	   #--------------------------#
	   $accessQtyMessage = '';
	   if($prodQty >= $totalQty){
		$prodQty = $totalQty;
		$accessQtyMessage =  "only $totalQty available";
	   }
	   
	  $totalItemPrice = $prodQty * $prodPrice;
	 
	  
	  if($SellerInfo['Seller']['free_delivery'] == '1'){
			if($totalItemPrice >= $SellerInfo['Seller']['threshold_order_value'] ){
				$delivery_cost = 0;	
			}
	  }
?>

<?php
	  echo $form->create('Basket',array('action'=>'view','method'=>'POST','name'=>'frmBasket','id'=>'frmBasket'));
		echo $form->hidden('Basket.id',array('value'=>$cartId,'label'=>false,'div'=>false));
		echo $form->hidden('Basket.available_stock',array('value'=>$totalQty,'label'=>false,'div'=>false));
		
	  ?>
	<?php 
		if($i==($cartCount)){
			$classname='buying-choices shpngbsktbx nobrdr';
			}else{
			$classname='buying-choices shpngbsktbx';	
		}
	?>
	
<ul class="<?php echo $classname;?>" style="overflow:hidden">
	<li class="spngbsktitem">
				<?php
				if(!empty($cart['Product']['product_image'])){
					$main_imagePath = WWW_ROOT.PATH_PRODUCT.'small/img_50_'.$cart['Product']['product_image'];
						
					if(file_exists($main_imagePath)){
						echo $html->link($html->image('/'.PATH_PRODUCT."small/img_50_".$cart['Product']['product_image'], array('alt'=>"",'width'=>'30','height'=>'30')), '/'.$this->Common->getProductUrl($prodId).'/categories/productdetail/'.$prodId, array('class'=>'prdcthdnme', 'escape'=>false, 'div'=>false)  );
						//echo $html->image('/'.PATH_PRODUCT."small/img_50_".$cart['Product']['product_image'], array('alt'=>"",'width'=>'30','height'=>'30'));
						//echo $html->image('/'.PATH_PRODUCT."small/img_50_".$product_details['Product']['product_image'], array('alt'=>"" , 'widht' => '30' , 'height' => '30'));
					}else{
						echo $html->image('/img/no_image_50.jpg', array('alt'=>"" , 'widht' => '30' , 'height' => '30'));
					}
				}?>
				
	<!--<img width="30" height="30" src="<?php //echo  SITE_URL;?>img/mobile/product_detail_thumb3.gif" alt="">-->
	<p> 
		<?php  echo $form->input('Basket.qty'.$cartId,  array('value'=>$prodQty , 'id'=> 'qty_text_'.$cartId ,'type'=>'text','maxlength'=>5, 'class'=>'smalltxtbx','div'=>false, 'label'=>false) ); ?>
		
		<?php  if( !empty($accessQtyMessage) ) { echo '<p class="smalr-fnt gray">'.$accessQtyMessage.'</p>'; } ?>
			  <?php
			  
			  $options_update = array(
				"escape"=> false,
				"url"=>"/baskets/updateBasket",
				//"before"=>"",
				"update"=>"basket_listing",
				"indicator"=>"plsLoaderID",
				//'loading'=>"Element.show('plsLoaderID')",
				//"complete"=>"Element.hide('plsLoaderID'),showUpdatedCart()",
				"complete"=>"showUpdatedCart()",
				"class" =>"ornggradbtn",
				"type"=>"Submit",
				"div"=>false,
				"label"=>false,
				"name"=>"formAction",	
				"id"=> "save_".$cartId,
				);
			   $options_delete = array(
				"escape"=> false,
				"url"=>"/baskets/deleteBasketItem",
				//"before"=>"",
				"update"=>"basket_listing",
				"indicator"=>"plsLoaderID",
				'loading'=>"Element.show('plsLoaderID')",
				"complete"=>"showUpdatedCart()",
				"class" =>"remove-button",
				"type"=>"Submit",
				"div"=>false,
				"label"=>false,
				"id"=> "delete_".$cartId,
				);
			 ?>
		
	</p>
		<?php  echo $ajax->submit('Update',$options_update);?>
	<!--<input type="button" value="Update" class="ornggradbtn" />-->
	<p>
		<?php  echo $ajax->submit('Remove',$options_delete);?>
	<!--<a href="#" class="remove-button">Remove</a>-->
	
	</p>
	</li>
	<li style="display:table-cell">
	<p>
	<?php 
		echo $html->link($prodName, '/'.$this->Common->getProductUrl($prodId).'/categories/productdetail/'.$prodId, array('class'=>'prdcthdnme', 'escape'=>false, 'div'=>false)  );
	?>
	</p>
	<p class="margin-top">
		<span class="pricecolor">
			<strong>
				<?php echo CURRENCY_SYMBOL, number_format($prodPrice, 2); ?>
			</strong>
		</span> 
		<span class="gray"><?php if(!empty($delivery_cost) ){
						echo "+ ".CURRENCY_SYMBOL."". number_format($delivery_cost, 2);
					}else{
						echo '+ FREE SHIPPING';
					}
					?> Delivery
				</span>
		<br />
	<b class="font11">Condition: <?php echo $condition; ?></b></p>
	<p class="larger-font margin-top">
		<strong>Sold by:</strong>&nbsp;&nbsp;
		<a href="<?php echo SITE_URL ?>sellers/<?php echo str_replace(array(' ','/','&quot;','&','andamp','and;'), array('-','','"','and','and','and'),$SellerInfo['Seller']['business_display_name']) ?>/summary/<?php echo $SellerInfo['User']['id'] ?>/<?php echo $prodId ?>"><?php  echo $sellerName;?></a>
	</p>
	<p class="font11">
		Eligible for <span class="drkred"><b>Free Delivery</b></span> with this seller 
		<!--(<?php //echo $html->link('Go to seller store','/sellers/choiceful.com-store/'.$sellerId,array('class'=>"underline-link",'escape'=>false));?>)-->
		<?php echo $html->image(SITE_URL.'img/mobile/free-del.png', array('alt'=>"" , 'height' => '12' ,  'width' => '26' ));?>
	</p>
	
	<p class="giftzotns">
		<?php  if($gift_service == 1) {
				$image_path = SITE_URL.'img/mobile/gift-icon.gif';
				 echo $html->link($html->image($image_path, array('alt'=>"")).'Gift options available' ,array('controller'=>'pages','action'=>'view','gift-wrappind'),array('escape'=>false));?> 
		 <?php  } ?>
		
	<!--<img src="<?php //echo SITE_URL;?>img/mobile/gift-icon.gif" alt="" />Gifts options available-->
	
	</p>
	<p class="margin-tp font11"><b>Comments:</b> Brand new. Dispatch Sameday!</p>
	<p class="font11"><b>Shipped from:</b> United Kingdom</p>
	
	<p>
		<?php if($express_delivery == 1){?>
			<b>Expedited Shipping Available</b> 
		<?php }else{?>
			<b>Expedited Shipping</b> Not Available 
		<?php }?>
	</p>
	</li>
</ul>

<?php echo $form->end();?>
	     <!--Cart Details Row1 Closed-->
	   <?php
	   $subTotal      	+= $totalItemPrice;
	   $itemTotalDelPrice    = $prodQty * $delivery_cost;
	   $shippingTotal 	+= $itemTotalDelPrice;
		
	   unset($prodQty);
	   unset($std_del_price);
	   unset($totalItemPrice);
	   unset($totalQty);
	   unset($itemTotalDelPrice);
	   unset($prodId);
	   unset($prodPrice);
	   unset($delivery_cost);
	   unset($SellerInfo) ;
	   
	  }  // foreach ends here
	  
	  }else{ ?>
	  
	 <p style="text-align:center;" class="red-color">
				    Your Shopping Basket is empty.
				    Browse Choiceful.com and add items you would like to buy</p>
	 
	  <?php  } ?>

	<?php if(is_array($cartData) && count($cartData) >0 ) {  // if basket have items ?>
	<section class="sorting-widget sbtotal">
	  <b>Subtotal:</b> <span class="drkred boldr"><?php echo CURRENCY_SYMBOL, number_format($subTotal, 2);?></strong></span>
		    <span class="smalr-fnt gray"> + <?php echo CURRENCY_SYMBOL."".number_format($shippingTotal, 2);?> Shipping</span>
		    <span class="gray font11">
		    <?php  //echo $html->link($html->image('pay-securety-now-btn.gif',array('width'=>138,'height'=>24,'alt'=>'')), '/checkouts/step1' , array('escape'=>false) ); ?></span>
	<!--<b>Subtotal:</b> <span class="drkred boldr">&pound;9999.99</span> 
	<span class="gray font11">+ &pound;199.99 Shipping</span>-->
	</section>
	  <?php } ?>
	
	<p align="center" class="applprdct">
                        <?php  echo $html->link('<input type="button" value="Continue To Checkout" class="cntntochkot" />', '/checkouts/step1' , array('escape'=>false, 'style' => 'text-decerotion: none') ); ?>
                        <!--<input type="button" value="Continue To Checkout" class="cntntochkot" />-->
                        </p>
                     <!----->
                        <ul class="paymrntopsons">
                        	<li>
                        		<?php echo $html->image("mobile/mastercard_icon.gif" ,array('alt'=>"", 'escape'=>false ));?>
                        	</li>
                        	<li>
                        		<?php echo $html->image("mobile/visa_icon.gif" ,array('alt'=>"", 'escape'=>false ));?>
                        	</li>
                        	<li>
                        		<?php echo $html->image("mobile/payment_option_3.gif" ,array('alt'=>"", 'escape'=>false ));?>
                        	</li>
                        	<li>
                        		<?php echo $html->image("mobile/payment_option_4.gif" ,array('alt'=>"", 'escape'=>false ));?>
                        	</li>
                        	<li>
                        		<?php echo $html->image("mobile/payment_option_5.gif" ,array('alt'=>"", 'escape'=>false ));?>
                        	</li>
                        	<li>
                        		<?php echo $html->image("mobile/payment_option_6.gif" ,array('alt'=>"", 'escape'=>false ));?>
                        	</li>
                        	<li>
                        		<?php echo $html->image("mobile/payment_option_7.gif" ,array('alt'=>"", 'escape'=>false ));?>
                        	</li>
                        	<li>
                        		<?php echo $html->image("mobile/payment_option_8.gif" ,array('alt'=>"", 'escape'=>false ));?>
                        	</li>
                        	<li>
                        		<?php echo $html->image("mobile/payment_option_9.gif" ,array('alt'=>"", 'escape'=>false ));?>
                        	</li>
                        </ul>
                     <!----->
                        <p align="center" class="gray font11">(Discount codes can be entered at checkout)</p>
                     <!----->
                        <!--p class="boldr orange-col-head intrstd">You might be intrested in the following items</p-->
	
</div>
<!--End Shopping list-->