<?php ?>
 <!--Tabs Start-->
<?php echo $this->element('mobile/orders/tab');?>
<!--Tbs Closed-->

<!--Tbs Cnt start-->
<section class="tab-content padding0">
<!--View Gift Certificate Balance Start-->
<section class="offers">
	<?php
		if ($session->check('Message.flash')){ ?>
		<li>
			<div  class="messageBlock">
				<?php echo $session->flash();?>
			</div>
		</li>
	<?php } ?>
	
	<section class="gr_grd brd-tp0">
	<h4 class="orng-clr">View Gift Certificate Balance</h4>
	<div class="loader-img">
		<?php echo $html->image('mobile/loader.gif',array('alt'=>'','width'=>'22','height'=>'22'));?>
		<!--<img src="images/loader.gif" width="22" height="22" alt="" />--></div>
	</section>
	<!--Row1 Start-->
	<div class="row-sec"><h4 class="font13">Current Balance</h4>
	<h1 class="rd_clr">&pound;<?php echo $format->money($gift_balance,2);?></h1>
	<p>You are able to use these funds on the pay page next time you place an order.</p>
	</div>
	<!--Row1 Closed-->
	
</section>
<!--View Gift Certificate Balance Closed-->


<!--Apply a Gift Certificate Start-->
<section class="offers">                	
		<section class="gr_grd">
	<h4 class="orng-clr">Apply a Gift Certificate</h4>
	<div class="loader-img">
		<?php echo $html->image('mobile/loader.gif', array('width'=>'22','height'=>'22','alt'=>''));?>
	</div>
	</section>
	<!--Row1 Start-->
	<?php echo $form->create('Certificate',array('action'=>'gift_balance','method'=>'POST','name'=>'frmCertificate','id'=>'frmCertificate'));?>
	<div class="row-sec">
	<h4 class="font13">Redeem a Gift Certificate</h4>
	<p>Enter the claim code in the box below. We'll add the amount of the Gift Certificate to your available funds.</p>
	<p class="padding10">
		<?php echo $form->input('Certificate.gift_code',array('class'=>'input','label'=>false,'div'=>false,'error'=>false));?>
		<?php echo $form->submit('Apply',array('type'=>'submit','class'=>'ornggradbtn','div'=>false));?>
		
		<?php echo $form->error('Certificate.gift_code'); ?>
		<!--<input type="submit" name="button" value="Apply" class="ornggradbtn" />-->
	</p>
	<p>Please note: promotional gift cetificates from Choiceful.com may only redeemed at the time that you place an order.</p>
	</div>
	<?php echo $form->end(); ?>
	<!--Row1 Closed-->
	
</section>
<!--Apply a Gift Certificate Closed-->

</section>
<!--Tbs Cnt closed-->