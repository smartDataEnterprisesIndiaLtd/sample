<?php 
echo $javascript->link(array('jquery-1.3.2.min','lib/prototype', 'functions'));
echo $javascript->link('fancybox/jquery.fancybox-1.3.1.pack.js');
echo $javascript->link('fancybox/jquery.easing-1.3.pack.js');
echo $javascript->link('fancybox/jquery.mousewheel-3.0.2.pack.js');
echo $html->css('jquery.fancybox-1.3.1.css');



?>
<!--Popup Widget Start-->
<div class="popup-widget popup-width3">
	<?php 
	if ($session->check('Message.flash')){ ?>
		<div class="messageBlock"><?php echo $session->flash();?></div>
	<?php } ?>
    <ul class="pop-content-list">
	<li><h4 class="orange-color-text">Thank you for your offer.</h4></li>
	 <li>&nbsp;</li>
    	<li><h5>Thank you for your offer. We have now sent it to the selected marketplace seller. If you change your mind, login to My Account where you can view and manage your offers. Please note* this is a limited time 48-hour offer. We will keep you notified of any updates via you registered email address.</h5></li>
        <li>&nbsp;</li>
      
    </ul>
</div>
<!--Popup Widget Closed-->
