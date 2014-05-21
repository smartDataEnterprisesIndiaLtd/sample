<?php
$totalItems = $common->getBasketCount();
$lastAddedItems = $common->getBasketLastItem();

if( !empty($totalItems)  && count($totalItems) >0 ){  // show data in basket
?>
<span id="shopping_basket_id">
<ul class="headerrgt font11">
	<li>
		<!--<?php echo $html->link($html->image("/img/mobile/cart_icon.gif" ,array('alt'=>"Add To Cart",'title'=>'Items In Your Cart' , 'escape'=>false )) ,"/baskets/view",array('escape'=>false,'class'=>'','div'=>false));?>
		<label>Basket:</label> (<?php echo $totalItems;?> Items)-->
		
		<?php echo $html->link($html->image("/img/mobile/cart_icon.gif" ,array('alt'=>"Add To Cart",'title'=>'Items In Your Cart' , 'escape'=>false )).' <label style="color:#7c7c7c;">Basket:</label> <span style="color:#7c7c7c;">('.$totalItems.' Items)</span>'  ,"/baskets/view",array('escape'=>false,'class'=>'','div'=>false));?>
	</li>
</ul>
</span>
	
<?php  } else{   // show empty basket?>
<span id="shopping_basket_id">
	<ul class="headerrgt font11">
		<li>
		<?php echo $html->image("/img/mobile/cart_icon.gif" ,array('alt'=>"Items In Your Cart",'title'=>"Items In Your Cart", 'escape'=>false ))?>
			<label>Basket:</label> (0 Items)</li>
		</li>
	</ul>
</span>
<?php } ?>
