<?php
$totalItems = $common->getBasketCount();
$lastAddedItems = $common->getBasketLastItem();

if( !empty($totalItems)  && count($totalItems) >0 ){  // show data in basket
?>

<!--<img src="/img/view-btn.png" alt="" class="view-btn" >-->

<ul class="view-cart-section">
	<li class="view-cart-content"><?php echo $html->image("cart.gif" ,array('width'=>"26",'height'=>"13", 'alt'=>"", 'escape'=>false )); ?>
	<span class="gray">Items</span> <strong><span class="blk-color">[<?php echo $totalItems;?>]</span> <span class="gray">Added:</span></strong>
	<span class="blk-color prod-name">
	<?php if(strlen($lastAddedItems) > 12){
			echo substr($lastAddedItems, 0, 10). "...";
		}else{
			echo $lastAddedItems;
		}?>
	</span></li>
	<li class="view-cart-btn"><?php echo $html->link( $html->image('/img/view-btn.png', array('alt'=>"") ) ,"/baskets/view",array('escape'=>false,'class'=>'','div'=>false));?> </li>
	
</ul>
	
<?php  } else{   // show empty basket?>
	<ul class="view-cart-section">
	<li class="view-cart-content" id="shopping_basket_id">
		<?php echo $html->image("cart.gif" ,array('width'=>"26",'height'=>"13", 'alt'=>"", 'escape'=>false )); ?>
		<strong>Basket:</strong> Currently empty, &pound;0.00</p>
		
		</li></ul>
<?php } ?>
