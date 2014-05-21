<?php

//$controller_name = $this->params['controller'];
$action_name 	 = $this->params['action'];

//die('hel');

?>
<script type="text/javascript">
function showloading(){
	jQuery('#plsLoaderID').show();
	jQuery('#fancybox-overlay-header').show();
}
function hideloading(){
	jQuery('#plsLoaderID').hide();
	jQuery('#fancybox-overlay-header').hide();
}
</script>
<!--Header Start-->
<div id="plsLoaderID" class="dimmer" style="display:none">
	<?php echo $html->image("ajax-loader.gif" ,array('alt'=>"Loading"));?>
	Loading, please wait
</div>

<div id="plsLoaderID" style="display:none" class="dimmer"><?php echo $html->image("loading.gif" ,array('alt'=>"Loading" ));?></div>
<div id="checkout-header" class="page-holder">
	<!--Logo Start-->
	<div class="checkout-logo"><?php echo $html->link('choiceful.com',"/",null);?></div>
	<!--Logo Closed-->
	<!--Checkout Steps Start-->
	<div class="checkout-need-help margin-top47"><?php //echo $html->link("<strong>Need Help?</strong>",'#',array('escape'=>false,'class'=>"underline-link"));?>
	<!--<strong>-->
	<a href='#' style="color:#000000" ><strong><script  type="text/javascript" class="underline-link" src="<?php echo SITE_URL;?>app/webroot/phplive/js/phplive.js.php?d=0&base_url=%2F%2Fchoiceful.com%2Fapp%2Fwebroot%2Fphplive&text=Need Help?"></strong></script></a>
	<!--<script  type="text/javascript"  src="//choiceful.com/Beta/app/webroot/phplive/js/phplive.js.php?d=0&base_url=%2F%2Fchoiceful.com%2FBeta%2Fapp%2Fwebroot%2Fphplive&text=Need Help?"></script>--></strong>
	</div>
	<!--Checkout Steps Closed-->
	<!--Checkout Steps Start-->
	<div class="checkout-process-widget">
        	<div class="checkout-process">
		<p><?php echo $html->image("checkout/checkout-process-text.png" ,array('width'=>"189",'height'=>"28", 'alt'=>"" )); ?></p>
		
		<?php
		
		switch($action_name): 
		case "step1":
		case 'registration':
		?>
		<p><?php echo $html->image("checkout/checkout-process-steps.png" ,array('width'=>"692",'height'=>"48", 'alt'=>"" )); ?></p>
		<?php
		break;
		case 'step2':
		?>
		<p><?php echo $html->image("checkout/checkout-process-steps2.png" ,array('width'=>"692",'height'=>"48", 'alt'=>"" )); ?></p>
		
		<?php
		break;
		case 'step3':
		?>
		<p><?php echo $html->image("checkout/checkout-process-steps3.png" ,array('width'=>"692",'height'=>"48", 'alt'=>"" )); ?></p>
		
		
		<?php
		break;
		case 'step4':
		?>
		<p><?php echo $html->image("checkout/checkout-product-process-steps4.png" ,array('width'=>"692",'height'=>"48", 'alt'=>"" )); ?></p>
		
		<?php
		break;
		case 'order_complete':
		?>
		<p><?php echo $html->image("checkout/checkout-process-steps6.png" ,array('width'=>"692",'height'=>"48", 'alt'=>"" )); ?></p>
		
		<?php
		break;
	
		default:
		?>
		<p><?php echo $html->image("checkout/checkout-process-steps.png" ,array('width'=>"692",'height'=>"48", 'alt'=>"" )); ?></p>
		<?php
		endswitch;
		
		?>
		
		
		<p align="center"><?php echo $html->image("checkout/slogan.png" ,array('width'=>"382",'height'=>"25", 'alt'=>"" )); ?></p>
		</div>
	</div>
	<!--Checkout Steps Closed-->
</div>
<!--Header Closed-->

<div id="fancybox-overlay-header"></div>
<!--Navigation Closed-->
<script>
jQuery(document).ready(function() {
	height = jQuery(document).height();
	jQuery('#fancybox-overlay-header').css('height',height+'px');

});
</script>