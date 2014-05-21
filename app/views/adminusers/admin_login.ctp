<?php echo $form->create('Adminuser',array('action'=>'login/'.$referred_url,'method'=>'POST','name'=>'frmLogin') );
?>
<table align="center" width="100%" height="380" border="0" cellpadding="2" cellspacing="2" valign="top">
	<tr>
		<td height="60">&nbsp;</td>
	</tr>
	<tr>
	<td valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td align="center"><?php
				if ($session->check('Message.flash') || !empty($errorMsg)){?>
				<?php if($this->params['action'] == 'admin_login'){?>
				<div align="center" class="error-message" style="width:100%!important">
					<div class="error-message" id="flashMessage_" style="font-size:12px!important;width:100%!important">
				<?php } else{?>
					<div align="center" class="error-message">
					<div class="error-message" id="flashMessage_">
				<?php }?>
						<?php 
							if ($session->check('Message.flash'))
								$session->flash();
							
							if ( !empty($errorMsg)){
								 echo $errorMsg;
							}
						?>
					</div>
				</div>
				<?php }?>
			</td>
		</tr>
		<tr>
			<td>
				<div class="login-widget">
					<h4 class="login-gray-bg-head"><span><?php echo $html->image('admin/login-manager.png',array('class'=>'login-img','alt'=>''));?><strong> Login</strong></span></h4>
					<div class="login-gray-fade-bg-box">
						<ul class="login-form-widget">
							<li>
								<label>Username:</label>
								<div class="form-field-widget">
									<?php echo $form->input('Adminuser.username', array('size'=>'25','maxlength'=>'30','class'=>'login-form-textfield','label'=>false,'div'=>false)); ?>
								</div>
							</li>
							<li>
								<label>Password:</label>
								<div class="form-field-widget">
									<?php echo $form->password('Adminuser.password', array('size'=>'25','maxlength'=>'30','class'=>'login-form-textfield','label'=>false,'div'=>false))?>
								</div>
							</li>
							<li>
								<label>&nbsp;</label>
								<div class="form-field-widget">
									<div class="red-button-widget">
										<?php echo $form->submit('Login', array('class' =>'button','div'=>false)); ?>
									</div>
								</div>
							</li>
						</ul>
					</div>
				</div>
			
			
			</td>
		</tr>
	</table>
	</td>
	</tr>
</table>
<?php echo $form->end() ?>