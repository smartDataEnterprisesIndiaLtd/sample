<?php
$action_name = $this->params['action'];
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

<div id="checkout-header" class="page-holder">
	<!--Logo Start-->
	<div class="checkout-logo-sec"><?php echo $html->link('choiceful.com',"/",null);?></div>
	<!--Logo Closed-->
	<!--Checkout Steps Start-->
	<div class="checkout-need-help margin-top47"><?php //echo $html->link('<strong>Need Help?</strong>','#',array('escape'=>false,'class'=>"underline-link")); ?>
	<!--<strong><script  type="text/javascript"  src="//choiceful.com/Beta/app/webroot/phplive/js/phplive.js.php?d=0&base_url=%2F%2Fchoiceful.com%2FBeta%2Fapp%2Fwebroot%2Fphplive&text=Need Help?"></strong></script>-->
	<a href='#' style="color:#000000" ><strong><script  type="text/javascript" class="underline-link" src="<?php echo SITE_URL;?>app/webroot/phplive/js/phplive.js.php?d=0&base_url=%2F%2Fchoiceful.com%2Fapp%2Fwebroot%2Fphplive&text=Need Help?"></strong></script></a>
	</div>
	<!--Checkout Steps Closed-->
	<!--Checkout Steps Start-->
	<div class="checkout-process1">
		<div class="checkout-center">
			<p><?php echo $html->image("checkout/checkout-process-text.png",array('width'=>"189",'height'=>"28",'alt'=>""));?></p>
			<p><?php
				if($this->params['action'] == 'step1' || $this->params['action'] == 'registration')
					echo $html->image("checkout/checkoutgift-process-steps1.png" ,array('alt'=>"" ));
				else if($this->params['action'] == 'giftcertificate_step2')
					echo $html->image("checkout/checkoutgift-process-steps2.png" ,array('alt'=>"" ));
				else if($this->params['action'] == 'giftcertificate_step4')
					echo $html->image("checkout/checkoutgift-process-steps4.png" ,array('alt'=>"" ));
	
			?></p>
			<p class="pad-left"><?php echo $html->image("checkout/slogan.png",array('width'=>"382",'height'=>"25",'alt'=>""));?></p>
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