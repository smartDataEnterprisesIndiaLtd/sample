<?php echo $javascript->link(array('jquery-1.3.2.min','lib/prototype'),false);?>
<style type="text/css">
.error-message {
float:none;
}
</style>
<!--Content Start-->
<div id="checkout-content">
	<!--Left Content Start-->
	<?php echo $this->element('checkout/left'); // include left side bar ?>
	<!--Left Content Closed-->
	<!--Right Content Start-->
	<div class="checkout-right-content1">
		<!--Form Left Widget Start-->
		<div class="form-checkout-widget wider-width580">
			<?php
			if ($session->check('Message.flash')){ ?>
				<div class="messageBlock">
					<?php echo $session->flash();?>
				</div>
			<?php } ?>
			
			<?php
			if(!empty($errors)){	
				$error_meaasge="Please add some information in the mandatory fields highlighted red below.";
			?>
			<div class="error_msg_box"> 
				<?php echo $error_meaasge;?>
			</div>
			<?php }?>
			
			<?php echo $form->create("Checkout", array('action'=>'step1/'.$from_giftcertificate,'default' => true,'name'=>'frmCheckout'));?>
			<!--Form Widget Start-->
			<div class="form-widget bigger-label-form">
				<ul>
					<li>
						<label>Please enter your e-mail address:</label>
						<div class="form-field-widget">
								<!--<input type="text" name="textfield2" class="form-textfield" />
								<p><a href="#" class="underline-link">We are commited to your privacy</a></p>-->
							<?php
								if(!empty($errors['emailaddress'])){
									$errorEmail='form-textfield error_message_box';
								}else{
									$errorEmail='form-textfield';
								}
							?>
							<?php echo $form->input('User.emailaddress',array('size'=>'30','maxlength'=>'50','error'=>false,'class'=>$errorEmail,'label'=>false,'div'=>false));?>
							<p><?php echo $html->link("We are commited to your privacy",array('controller'=>'pages','action'=>'view','security-and-data-protection-policy'),array('escape'=>false));?></p>
						</div>
					</li>
					<li>
						<label>New customer?</label>
						<div class="form-field-widget">
							<p class="line-hight18">
							<?php
							$options=array('1'=>'<strong> Yes, I am a new customer<br></strong><span class="line-break">(You\'ll create a password here)</span></p><p>','0'=>'<strong> No, I am a returning customer.</strong><br><span class="line-break">and my password is:</span></p>');
							$attributes=array('legend'=>false,'label'=>false, 'class'=>'radio');
							echo $form->radio('User.customer',$options,$attributes);
							?>
							<?php echo $form->input('User.password1',array('size'=>'30','class'=>'form-textfield','type'=>'password','label'=>false,'div'=>false));?>
							<p><?php echo $html->link("Forgot your password?",array("controller"=>"users","action"=>"forgotpassword"),array('maxlength'=>'30','escape'=>false));?>
						
							<!--<p class="line-hight18">-->
							<!--<input type="radio" name="radio" class="radio" value="radio" />-->
							<!--<strong>Yes, I am a new customer</strong><br />-->
							<!--<span class="line-break">(You'll create a password here)</span></p>-->
							<!--<p><input type="radio" name="radio" class="radio" value="radio" /> -->
							<!--<strong>No, I am a returning customer.</strong>-->
							<!--<span class="line-break">and my password is:</span></p>-->
							<!--<input type="text" name="textfield2" class="form-textfield" />-->
							<!--<p><a href="#" class="underline-link">Forgot your password?</a>-->
						</div>
					</li>
					<li>
						<label>&nbsp;</label>
						<div class="form-field-widget">
						<!--<input type="image" src="/img/checkout/continue-checkout-btn.png" name="button2" value=" " />-->
						<?php  echo $form->submit('checkout/continue-checkout-btn.png',  array('type'=>'image') ); ?>
						</div>
					</li>
				</ul>
			</div>
			<?php echo $form->end();?>
			<!--Form Widget Closed-->
		</div>
		<!--Form Left Widget Start-->
	</div>
	<!--Right Content Closed-->
</div>
<!--Content Closed-->