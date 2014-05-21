<?php ?>
<li class="toppadd">
	<?php 
		echo $html->image("checkout/d-arrow-icon.png" ,array('class'=>'rvwarrow', 'alt'=>'', 'escape'=>false ));
	?>
	<label>Items:</label><span>
	<?php echo CURRENCY_SYMBOL, number_format($basketPriceData['item_total_cost'], 2); ?></span>
</li>
<li>
	<?php 
		echo $html->image("checkout/d-arrow-icon.png" ,array('class'=>'rvwarrow', 'alt'=>'', 'escape'=>false ));
	?>
	<label>Delivery:</label><span>
	<?php echo CURRENCY_SYMBOL, number_format($basketPriceData['shipping_total_cost'], 2); ?></span>
</li>

<li>	<?php 
		echo $html->image("checkout/d-arrow-icon.png" ,array('class'=>'rvwarrow', 'alt'=>'', 'escape'=>false ));
	?>
	<label>Gift-wrap:</label><span>
	<?php echo CURRENCY_SYMBOL, number_format($basketPriceData['giftwrap_total_cost'], 2); ?></span>
</li>

<li>	<?php 
		echo $html->image("checkout/d-arrow-icon.png" ,array('class'=>'rvwarrow', 'alt'=>'', 'escape'=>false ));
	?>
	<label>Insurance:</label>
	<span><?php echo CURRENCY_SYMBOL, number_format($insurance_cost, 2); ?></span>
</li>
<li class="ornglist">
	<label>Gift Balance:</label><span>-
	<?php echo CURRENCY_SYMBOL, number_format($gift_balance_cost,2); ?></span>
</li>
<li class="ornglist"><label>Discount Coupon:</label><span>-
	<?php if(!empty($discount_coupon_amount) ){
		echo CURRENCY_SYMBOL, number_format($discount_coupon_amount, 2) ;
	}else{
		echo CURRENCY_SYMBOL,'0.00' ;
	}?></span>
</li>
<li class="undrlnfrttl"><span></span></li>
<li>	<?php 
		echo $html->image("checkout/d-arrow-icon.png" ,array('class'=>'rvwarrow', 'alt'=>'', 'escape'=>false ));
	?>
	<label>Total before tax:</label>
	<span><?php echo CURRENCY_SYMBOL, number_format($total_order_before_tax,2); ?></span>
</li>

<li>	<?php 
		echo $html->image("checkout/d-arrow-icon.png" ,array('class'=>'rvwarrow', 'alt'=>'', 'escape'=>false ));
	?>
	<label>Tax:</label><span><?php echo CURRENCY_SYMBOL, number_format($tax_total_cost,2); ?></span>
</li>
<li class="totalreviwttl">
	<?php 
		echo $html->image("checkout/d-arrow-icon.png" ,array('class'=>'rvwarrow', 'alt'=>'', 'escape'=>false ));
	?>
	<label>Total:</label>
	<span><?php echo CURRENCY_SYMBOL, number_format($total_order_cost,2); ?></span>
</li>