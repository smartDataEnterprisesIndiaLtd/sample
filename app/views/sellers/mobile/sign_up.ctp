<?php
echo $javascript->link(array('jquery-1.3.2.min','lib/prototype'),false);
$user_signed = $this->Session->read('User');

?>
<!--Tabs Start-->
<?php echo $this->element('mobile/orders/tab');?>
<!--Tbs Closed-->
<!--Tbs Cnt start-->
<section class="tab-content padding0">
<!--Manage Listings Start-->
<section class="offers">                	
	
	<!--Row1 Start-->
	<div class="row-sec content">
	<p>Please register as a Choiceful.com Marketpalce seller.</p>
	<p><?php echo $html->link("Click here",SITE_URL.'?fullsite=go',array('escape'=>false));?> to visit our full site.</p>
	<p class="font11"><strong>By visiting the Choiceful.com site using your mobile device, you are accepting the practices described in the  Choiceful.com Privacy Notice.</strong></p>
	</div>
	<!--Row1 Closed-->
	
</section>
<!--Manage Listings Closed-->

</section>
<!--Tbs Cnt closed-->