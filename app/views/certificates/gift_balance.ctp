<?php ?>
<div class="mid-content">
	<!--- <?php //echo $this->element('gift_certificate/breadcrumb');?> --->
	<!--Setting Tabs Widget Start-->
	<div class="row breadcrumb-widget">
		<?php echo $this->element('gift_certificate/tabs');?>
		 <!--Tabs Content Start-->
		<div class="tabs-content">
			<!--Row1 Start-->
			<div class="order-row">
				<ul class="reviews-section">
					<?php
					if ($session->check('Message.flash')){ ?>
					<li>
						<div  class="messageBlock">
							<?php echo $session->flash();?>
						</div>
					</li>
					<?php } ?>
					<li><p><strong>Current Balance</strong></p>
					<p class="red-color font-size24"><strong>&pound;<?php echo $format->money($gift_balance,2);?></strong></p>
					<p>You are able to use these funds on the pay page next time you place an order.</p></li>
					<li>Please read our <?php echo $html->link('terms and conditions','/pages/view/gift-certificate-terms-and-conditions',array('escape'=>false,'class'=>'underline-link')); ?> relating to Choiceful.com Gift Certificates</li>
					<li>
						<p><strong>Related links</strong></p>
						<p><?php echo $html->link('Apply a Gift Code to your Account','/certificates/apply_gift',array('escape'=>false,'class'=>'underline-link')); ?></p>
						<p><?php echo $html->link('Purchase Gift Certificates','/certificates/purchase_gift',array('escape'=>false,'class'=>'underline-link')); ?></p>
						<p><?php echo $html->link('Learn more',array('controller'=>'pages','action'=>'view','purchase-gift-certificate-terms-and-conditions'),array('escape'=>false,'class'=>'underline-link')); ?></p>
						<p><?php echo $html->link('Help',array('controller'=>'faqs','action'=>'view','7'),array('escape'=>false,'class'=>'underline-link')); ?></p>
					</li>
				</ul>
			</div>	
			<!--Row1 Closed-->
			<!--<p class="no-list">There are currently no orders on file.</p>-->
		</div>
		<!--Tabs Content Closed-->
	</div>
	<!--Setting Tabs Widget Closed-->
</div>
<!---<div class="footer_line"></div> -->