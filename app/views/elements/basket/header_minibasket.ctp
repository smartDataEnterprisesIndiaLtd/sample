
<?php
$totalItems = $common->getBasketCount();
  $priceVal = $common->getBasketPrice();
$lastAddedItems = $common->getBasketLastItem();

if( !empty($totalItems)  && count($totalItems) >0 ){  // show data in basket
?>

<!--<img src="/img/view-btn.png" alt="" class="view-btn" >-


	<span class="gray"></span> <strong><span class="blk-color">[<?php echo $totalItems;?>]</span> <span class="gray">Added:</span></strong>
	<span class="blk-color prod-name">
	<?php if(strlen($lastAddedItems) > 12){
			echo substr($lastAddedItems, 0, 10). "...";
		}else{
			echo $lastAddedItems;
		}
		$item= "Item";
		if($totalItems>1){
			$item= "Items";
		}
		$priceVal = number_format($priceVal, 2, '.', '');
 
		?>
		
	</span></li>-->
	<?php echo $html->link("$totalItems $item - &pound;$priceVal","/baskets/view",array('escape'=>false,'class'=>'','div'=>false));?> </li>
	

	
<?php  } else{   // show empty basket?>
	
	<!--<style>
	.topright_links li.cart a:hover, .topright_links li.cart a.active{
		background: url("../img/new/images/cart-icon.png") no-repeat scroll left 9px transparent;
		padding-top:4px;
		border-top:2px;
		color:#FFF;
	}
</style> -->
		<a href="<?PHP echo SITE_URL;?>baskets/view"> <!--style="cursor: default;"--->0 item - &pound;0.00</a>
		<?php //echo $html->image("cart.gif" ,array('width'=>"26",'height'=>"13", 'alt'=>"", 'escape'=>false )); ?>
		<!--<strong>Basket:</strong> Currently empty, &pound;0.00</p>--->
		
		
<?php } ?>
