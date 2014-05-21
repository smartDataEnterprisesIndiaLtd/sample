<?php 
echo $javascript->link(array('jquery-1.3.2.min','lib/prototype', 'functions'));
echo $javascript->link('fancybox/jquery.fancybox-1.3.1.pack.js');
echo $javascript->link('fancybox/jquery.easing-1.3.pack.js');
echo $javascript->link('fancybox/jquery.mousewheel-3.0.2.pack.js');
echo $html->css('jquery.fancybox-1.3.1.css');
?>
<div class="popup-widget popup-width1" >	
	<h4 class="orange-color-text">Guaranteed Proof of Delivery Service</h4><br />
	<p>If you would like to insure your order with a signature on delivery service we recommend you take additional insurance this will cover your ordered items against non-warranty defects and loss of order through transit-claims for up to <?php echo CURRENCY_SYMBOL;?>250 in value.</p><br />
	<p>Please note this does not affect your statutory rights.</p>

</div>