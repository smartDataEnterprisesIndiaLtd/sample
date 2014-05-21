      <!--<div id="coupon_code_error" class="error-message"></div>-->
	<li>
	<div class="d-arrow"><?php echo $html->image("checkout/d-arrow-icon.png" ,array('width'=>"7",'height'=>"7", 'alt'=>"", 'escape'=>false )); ?></div>
	<div class="summary-text"><strong>Items:</strong></div>
	<div class="summary-value"><?php echo CURRENCY_SYMBOL, number_format($basketPriceData['item_total_cost'], 2); ?></div>
	</li>
	<li>
	<div class="d-arrow"><?php echo $html->image("checkout/d-arrow-icon.png" ,array('width'=>"7",'height'=>"7", 'alt'=>"", 'escape'=>false )); ?></div>
	<div class="summary-text"><strong>Delivery:</strong></div>
	<div class="summary-value"><?php echo CURRENCY_SYMBOL, number_format($basketPriceData['shipping_total_cost'], 2); ?></div>
	</li>
	<li>
	<div class="d-arrow"><?php echo $html->image("checkout/d-arrow-icon.png" ,array('width'=>"7",'height'=>"7", 'alt'=>"", 'escape'=>false )); ?></div>
	<div class="summary-text"><strong>Gift-Wrap:</strong></div>
	<div class="summary-value"><?php echo CURRENCY_SYMBOL, number_format($basketPriceData['giftwrap_total_cost'], 2); ?></div>
	</li>
	<li>
	<div class="d-arrow"><?php echo $html->image("checkout/d-arrow-icon.png" ,array('width'=>"7",'height'=>"7", 'alt'=>"", 'escape'=>false )); ?></div>
	<div class="summary-text"><strong>Insurance:</strong></div>
	<div class="summary-value" ><?php echo CURRENCY_SYMBOL, number_format($insurance_cost, 2); ?></div>
	</li>
	<li class="choiceful">
	<div class="d-arrow"></div>
	<div class="summary-text"><strong>Gift Balance</strong></div>
	<div class="summary-value"><strong>-<?php echo CURRENCY_SYMBOL, number_format($gift_balance_cost,2); ?></strong></div>
	</li>
	<li class="choiceful">
	<div class="d-arrow"></div>
	<div class="summary-text"><strong>Discount Coupon</strong>:</div>
	<div class="summary-value br-btm pd-btm"><strong>-<?php
	if(!empty($discount_coupon_amount) ){
		echo CURRENCY_SYMBOL, number_format($discount_coupon_amount, 2) ;
	}else{
		echo CURRENCY_SYMBOL,'0.00' ;
	}
	?></strong></div>
	</li>
	
	<li>
	<div class="d-arrow"></div>
	<div class="summary-text"><strong>Total before VAT:</strong></div>
	<div class="summary-value"><?php echo CURRENCY_SYMBOL, number_format($total_order_before_tax,2); ?></div>
	</li>
	<li>
	<div class="d-arrow"></div>
	<div class="summary-text"><strong>VAT:</strong></div>
	<div class="summary-value"><?php echo CURRENCY_SYMBOL, number_format($tax_total_cost,2); ?></div>
	</li>
	<li class="total-widget">
	<div class="d-arrow"><?php echo $html->image("checkout/d-arrow-icon.png" ,array('width'=>"7",'height'=>"7", 'alt'=>"", 'escape'=>false )); ?></div>
	<div class="summary-text"><strong>Total:</strong></div>
	<div class="summary-value"><strong><?php echo CURRENCY_SYMBOL, number_format($total_order_cost,2); ?></strong></div>
	</li>
	
	