<script type="text/javascript">
setTimeout(function () {
   location.reload(); // the redirect goes here
 },5000); 
</script>
<!--Popup Widget Start-->
<ul class="offerbox">
	<?php 
	if($session->check('Message.flash')){ ?>
		<li><div class="messageBlock"><?php echo $session->flash();?></div></li>
	<?php } ?>
	<li class="orange-col-head boldr applprdct font13">Thank you for your offer.</li>
	<li class="boldr">Thank you for your offer. We have now sent it to the selected marketplace seller. If you change your mind, login to My Account where you can view and manage your offers. Please note* this is a limited time 48-hour offer. We will keep you notified of any updates via your registered email address.</li>
</ul>
<!--Popup Widget Closed-->
