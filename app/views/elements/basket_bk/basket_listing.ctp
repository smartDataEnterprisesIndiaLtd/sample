<?php ?>
<script type="text/javascript">
// function to  show updated mini basket after completeing the action
function updateCartData(){
	showUpdatedCart();
	jQuery('#plsLoaderID').hide();
	
}
function showLoader(){
	jQuery('#plsLoaderID').show();
	jQuery('#fancybox-overlay-header').show();
}
</script>
        	
<!--Shopping Basket Start-->
<div class="shopping-basket-widget" id="basket_listing">
	
	<?php
	if ($session->check('Message.flash')){
		$divclass = "";
		?>
			<?php echo $session->flash();?>
	<?php }else{
		$divclass = "cart-row-content";
}?>

<!--Cart Row Top Start-->
<div class="cart-row">
	<ul>
	<li><h1 class="blk-color cart-head">Shopping Basket</h1></li>
       <?php if(is_array($cartData) && count($cartData) >0 ) {  // if basket have items ?>
       <li class="float-right pad-tp">
	  <?php  echo $html->link($html->image('pay-securety-now-btn.gif',array('width'=>138,'height'=>24,'alt'=>'')), '/checkouts/step1' , array('escape'=>false) ); ?>
	  </li>
       <?php } ?>
    </ul>
</div>
<!--Cart Row Top Closed-->

<!--Cart Row Bottom Start-->


<div class=<?php echo $divclass;?>>

	<!--Cart Details Start-->
	<div class="cart-details">
    
	<!--Title Start-->
	<div class="title-widget">
		<div class="title-widget-left" style="height:30px;">
		<ul>
		    <li class="item-col"><strong>Item</strong></li>
		    <li class="price-col-section">
			  <div class="price-column-sec">
				    <div class="pr-sec"><strong>Price</strong></div>
			  </div>
			  <div  class="quantity-column-sec"><strong>Quantity</strong></div>
		    </li>
		</ul>
	    </div>
	</div>
	<!--Title Closed-->
	
	<!--Gray Fade Box Start-->
	<div class="gray-fade-bg-box">
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
	$offer_product = $cart['Basket']['offer_id'];			    
	  $prodName 	= $cart['Product']['product_name'];
	  $prodQty 	=  $cart['Basket']['qty'];
	  $prodPrice 	= $cart['Basket']['price'];
	  $delivery_cost  = $cart['Basket']['delivery_cost'];
	  //REF #2904
	  //$condition 	  = $NewUsedcondArray[$cart['Basket']['condition_id']];
	  $condition 	  = $this->Common->getProductConName($cart['Basket']['condition_id']);
	  
	 
	 
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
	  
	// pr($SellerInfo);
		?>
		<?php
		echo $form->create('Basket',array('action'=>'view','method'=>'POST','name'=>'frmBasket','id'=>'frmBasket'));
		echo $form->hidden('Basket.id',array('value'=>$cartId,'label'=>false,'div'=>false));
		echo $form->hidden('Basket.available_stock',array('value'=>$totalQty,'label'=>false,'div'=>false));
		
		?>
		<!--Cart Details Row1 Start-->
		<div class="cart-detail-row">                        
		<ul>
			<li class="item-col" style="width:38%;">
			    <p><?php 
			       echo $html->link('<strong>'.$prodName.'</strong>', '/'.$this->Common->getProductUrl($prodId).'/categories/productdetail/'.$prodId, array('class'=>'underline-link light-blue', 'escape'=>false, 'div'=>false)  ); ?>
			    <span class="line-break smalr-fnt">Condition: <?php echo $condition; ?></span></p>
			     <p class="no-pad"><span class="line-break"><strong>In Stock</strong></span>
			    <span class="line-break smalr-fnt"><strong>Seller</strong>
			    <a href="<?php echo SITE_URL ?>sellers/<?php echo str_replace(array(' ','/','&quot;','&','andamp','and;'), array('-','','"','and','and','and'),$SellerInfo['Seller']['business_display_name']) ?>/summary/<?php echo $SellerInfo['User']['id'] ?>/<?php echo $prodId ?>">
			    <?php  echo $sellerName;?>
			    </a>
			    </span></p>
			    <p class="smalr-fnt gift-wrap no-pad-btm">
				    <?php  if($gift_service == 1) { ?>    
				    <?php echo $html->link('Gift-wrap item',array('controller'=>'pages','action'=>'view','gift-wrappind'),array('escape'=>false,'class'=>'underline-link'));?>			   
				    <?php  } ?>
			    
			    </p>
			    
			    <?php
			 //   if($free_delivery == 1 && $totalItemPrice >= $threshold_order_value){
			   if($free_delivery == 1 ){
				    ?>
				      <p class="smalr-fnt">Eligible for <span class="price"><strong>Free Delivery</strong></span> with this seller (<?php echo $html->link('Go to seller store','/sellers/choiceful.com-store/'.$sellerId,array('class'=>"underline-link",'escape'=>false));?><!--<a href="/sellers/summary/<?=$sellerId?>/<?=$prodId?>"  >Go to seller store</a>-->)<?php echo $html->image("free-del.png" ,array('width'=>"26",'height'=>"12", 'alt'=>"",'class'=>'v-align-middle', 'escape'=>false )); ?></p>
			    <?php   }?>
			  
			    <?php
			    if($express_delivery == 1){
				    ?>
				    <p class="sml-fnt"><span class="dif-col-blu-code"><strong>Expedited Shipping</strong></span> Available (during checkout) </p>
			    <?php   }?>
			</li>
			<li class="price-col-section">
				<div class="price-column-sec">
				    <div class="pr-sec"><span class="red-color larger-fnt"><strong><?php echo CURRENCY_SYMBOL, number_format($prodPrice, 2); ?></strong></span>
				    <span class="line-break smalr-fnt gray">
					<?php if(!empty($delivery_cost) ){
						echo "+ ".CURRENCY_SYMBOL. number_format($delivery_cost, 2);
					}else{
						echo '+ FREE SHIPPING';
					}
					?>
					</span></div>
			       </div>
			  <div  class="quantity-column-sec">
			  <p>
			  <?php  echo $form->input('Basket.qty'.$cartId,  array('value'=>$prodQty , 'id'=> 'qty_text_'.$cartId ,'onkeyup'=>'javascript: if( isNaN(this.value) ){ this.clear(); }', 'type'=>'text','maxlength'=>5, 'class'=>'form-textfield v-smal-width','div'=>false, 'label'=>false) ); ?></p>
			  <?php  if( !empty($accessQtyMessage) ) { echo '<p class="smalr-fnt gray">'.$accessQtyMessage.'</p>'; } ?>
			  <?php
			  
			  $options_update = array(
				"escape"=> false,
				"url"=>"/baskets/updateBasket",
				//"before"=>"",
				"update"=>"basket_listing",
				"indicator"=>"plsLoaderID",
				'loading'=>"showLoader()",
				//'loading'=>"Element.show('plsLoaderID')",
				//"complete"=>"Element.hide('plsLoaderID')",
				"complete"=>"showUpdatedCart()",
				"class" =>"orange-btn",
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
				'loading'=>"showLoader()",
				"complete"=>"showUpdatedCart()",
				"type"=>"Submit",
				"div"=>false,
				"label"=>false,
				"id"=> "delete_".$cartId,
				);
		
	  if($offer_product){
		echo "<p>";
	  $options_update =array('class'=>'ornge-btn ornge-btn_disabled','id'=>'make_me_an_offer_gray','escape'=>false);
	  echo $html->link('<span>Update</span>',"javascript:void('0');",$options_update);
	  }else{
		echo '<p class="button-widget inline-block">';
	  echo $ajax->submit('Update',$options_update);
	  	  }?> <p><?php echo $ajax->submit("remove-btn.gif",$options_delete);?></p></div>
			</li>
			
	      </ul>
		
	     </div>
		<?php
		if( $i < $cartCount ){
			echo '<p class="bottom-dashed-border"></p>';
		}else{
			
		}?>
		
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
	  
		<p class="red-color">The item has been removed from your basket.</p>
		<p>Your shopping basket is empty. Browse Choiceful.com and add items you would like to buy</p>
		<a href="<?php echo SITE_URL ?>" ><strong> Click here to continue shopping</strong></a>
	 
	  <?php  } ?>
	  
       </div>
       <!--Gray Fade Box Closed-->
       
		 </div>
     <!--Cart Details Closed-->
     
</div>
<!--Cart Row Bottom Closed-->


<!--Cart Row Bottom Start-->
<div class="cart-details">
	<ul>
	<li class="item-col">
		<p>
		<?php
		echo $html->image("master-cart-sml.gif" ,array('width'=>"31",'height'=>"19", 'alt'=>"", 'escape'=>false ));
		echo $html->image("visa-card-sml.gif" ,array('width'=>"28",'height'=>"19", 'alt'=>"", 'escape'=>false ));
		echo $html->image("switch-card-sml-purple.gif" ,array('width'=>"14",'height'=>"19", 'alt'=>"", 'escape'=>false ));
		echo $html->image("switch-card-sml-green.gif" ,array('width'=>"15",'height'=>"19", 'alt'=>"", 'escape'=>false ));
		echo $html->image("mastro-card-sml.gif" ,array('width'=>"29",'height'=>"19", 'alt'=>"", 'escape'=>false ));
		echo $html->image("visa-electron-card-sml.gif" ,array('width'=>"29",'height'=>"19", 'alt'=>"", 'escape'=>false ));
		echo $html->image("delta-card-sml.gif" ,array('width'=>"25",'height'=>"19", 'alt'=>"", 'escape'=>false ));
		echo $html->image("paypal-sml.gif" ,array('width'=>"37",'height'=>"19", 'alt'=>"", 'escape'=>false ));
		echo $html->image("google-logo.png" ,array('border'=> 0, 'alt'=>"", 'escape'=>false ));
		echo $html->image("footer-cart-icon.png" ,array('border'=> 0, 'alt'=>"", 'escape'=>false ));
		?>
		</p> 
		<p class="smalr-fnt gray">(Discount codes can be entered at checkout)</p>                           
	</li>
	 
	<li class="price-col-section">
	  <?php if(is_array($cartData) && count($cartData) >0 ) {  // if basket have items ?>
	  <div class="price-column-sec" style="text-align:left;">
		     <p><span class="larger-font low-line-height"><strong>Subtotal:</strong></span></p>
		    <p><span class="larger-font red-color"><strong><?php echo CURRENCY_SYMBOL, number_format($subTotal, 2);?></strong></span>
		    <span class="smalr-fnt gray">+
		    <?php if($shippingTotal != 0) { ?>
		    <?php echo CURRENCY_SYMBOL.number_format($shippingTotal, 2);?> shipping
		    <?php } else{?>
		    FREE SHIPPING
		    <?php } ?>
		    </span></p>
		</div>
		<div class="quantity-column-sec"><?php  echo $html->link($html->image('pay-securety-now-btn.gif',array('width'=>138,'height'=>24,'alt'=>'')), '/checkouts/step1' , array('escape'=>false) ); ?></div>
	    
	  <?php } ?>
	</li>
    </ul>
</div>
<!--Cart Row Bottom Closed-->

</div>
<!--Shopping Basket Closed-->

          