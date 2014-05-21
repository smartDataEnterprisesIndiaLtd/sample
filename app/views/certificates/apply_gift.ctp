<?php 	if(!empty($errors['gift_code'])){
					$erroroffer_price='form-textfield form-textfield-height float-left margin-rt error_message_box';
				}else{
					$erroroffer_price='form-textfield form-textfield-height float-left margin-rt';
				}
	?>			
			
<div class="mid-content">
	<!--- <?php //echo $this->element('gift_certificate/breadcrumb');?> --->
	<!--Setting Tabs Widget Start-->
	<div class="row breadcrumb-widget">
		<?php echo $this->element('gift_certificate/tabs');?>
		<!--Tabs Content Start-->
		<div class="tabs-content">
			<!--Row1 Start-->
			<div class="order-row">
				<ul class="reviews-section"><?php
					if ($session->check('Message.flash')){ ?>
					<li>
						
							<div  class="messageBlock">
								<?php echo $session->flash();?>
							</div>
					</li>
					<?php } ?>
					
					<?php if(!empty($errors)){
				$error_meaasge="Please add some information in the mandatory fields highlighted red below."; ?>
			<div class="error_msg_box"> 
				<?php echo $error_meaasge;?>
			</div>
	<?php } ?>
	
					<li>
						<p><strong>Redeem a Gift Certificate</strong></p>
						<p>Enter the claim code in the box below. We'll add the amount of the Gift Certificate to your available funds.</p>
					</li>
					
					<?php echo $form->create('Certificate',array('action'=>'apply_gift','method'=>'POST','name'=>'frmCertificate','id'=>'frmCertificate'));?>
					<li>
						<?php echo $form->input('Certificate.gift_code',array('class'=>$erroroffer_price,'label'=>false,'div'=>false,'error'=>false));?>
						<!--Button Start-->
						<div class="button-widget float-left" style="padding-right:5px"><?php echo $form->submit('Apply',array('type'=>'submit','class'=>'orange-btn btn-pad-lt-rt','div'=>false));?></div><?php //echo $form->error('Certificate.gift_code'); ?>
						<!--Button Closed-->
					</li>
					<?php echo $form->end(); ?>
					<li>
						<p>Please note: promotional gift certificates from Choiceful.com may only be redeemed at the time that you place an order.</p>
						<p>Please read our <?php echo $html->link('terms and conditions','/pages/view/gift-certificate-terms-and-conditions',array('escape'=>false,'class'=>'underline-link')); ?> for more information.</p>
					</li>
					<li>
						<p><strong>Related links</strong></p>
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
<!-- <div class="footer_line"></div> -->