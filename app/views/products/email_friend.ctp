<?php  echo $form->create('Product',array('action'=>'email_friend','method'=>'POST','name'=>'frmProductmail','id' =>'frmProductmail'));

echo $javascript->link(array('behaviour.js','textarea_maxlen'));
?>
<style>
.ad-form-widget label {
width:100px;
}
</style>
<ul class="pop-con-list" style="margin-right:10px;">
	<?php 
	if ($session->check('Message.flash')){ ?>
	<div >
		<div class="messageBlock"><?php echo $session->flash();?></div>
	</div>
	<?php }
	?>
	<?php
	if(!empty($errors)){
		$error_meaasge="Please add some information in the mandatory fields highlighted red below.";
	?>
		<div class="error_msg_box"> 
			<?php echo $error_meaasge;?>
		</div>
	<?php }?>
	<li>
        	<h4 class="orange-color-text">Email this page to your friend</h4>
		<p class="gr-colr">Complete the form below to email details of this product to a friend.</p>
	</li>
	
	<li>
		<ul class="ad-form-widget" style="width:385px !important;">
			<li><label >Product: </label>
				<?php echo $this->data['Product']['product_name'];?>
				<?php echo $form->hidden('Product.id'); echo $form->hidden('Product.product_name');?>
			</li>
			<li>
				<label  class="red-color-text">Name of recipient</label>
				<?php
				if(!empty($errors['recipient_name'])){
					$errorRecipientName ='textfield small-width-input error_message_box';
				}else{
					$errorRecipientName ='textfield small-width-input';
				} ?>
				<?php echo $form->input('Product.recipient_name',array('error'=>false,'size'=>'30','type'=>'text','maxlength'=>30,'label'=>false,'class'=>$errorRecipientName,'div'=>false,'style'=>'float:left;margin-right:5px'));?>
			</li>
			<li><?php
				if(!empty($errors['recipient_email'])){
					$errorRecipientEmail ='textfield small-width-input error_message_box';
				}else{
					$errorRecipientEmail ='textfield small-width-input';
				} ?>
				<label class="red-color-text">E-mail of recipient</label>
				<?php echo $form->input('Product.recipient_email',array('error'=>false,'size'=>'30','type'=>'text','maxlength'=>30,'label'=>false,'class'=>$errorRecipientEmail,'div'=>false,'style'=>'float:left;margin-right:5px'));?>
			</li>
			<li>
				<?php
				if(!empty($errors['your_name'])){
					$errorYourName ='textfield small-width-input error_message_box';
				}else{
					$errorYourName ='textfield small-width-input';
				} ?>
				<label class="red-color-text">Your name</label>
				<?php echo $form->input('Product.your_name',array('error'=>false,'size'=>'30','type'=>'text','maxlength'=>30,'label'=>false,'class'=>$errorYourName,'div'=>false,'style'=>'float:left;margin-right:5px'));?>
			</li>
			<li><?php
				if(!empty($errors['your_email'])){
					$errorYourEmail ='textfield small-width-input error_message_box';
				}else{
					$errorYourEmail ='textfield small-width-input';
				} ?>
				<label class="red-color-text">Your e-mail address</label>
				<?php echo $form->input('Product.your_email',array('error'=>false,'size'=>'30','type'=>'text','maxlength'=>30,'label'=>false,'class'=>$errorYourEmail,'div'=>false,'style'=>'float:left;margin-right:5px'));?>
			</li>
			<li><label>Add a personal message
				<span class="gr-colr line-brk">(Maximum 500 characters)</span></label>
				<?php echo $form->input('Product.message',array('error'=>false,'size'=>'30','label'=>false,'class'=>'textfield small-width-input','rows'=>'5','cols'=>'70','style'=>'width:250px','div'=>false,'maxlength'=>500,'showremain'=>'limit')); ?></textarea><br><label>&nbsp;</label><span class="gr-colr line-brk" style="float:left;margin-right:5px">Ramaining characters: </span><span class="gr-colr line-brk" id="limit">500</span>
			</li>
			<li style="text-align:right;"><div class="blue-button-widget float-right"><?php echo $form->button('Sent email',array('type'=>'submit','class'=>'blue-btn','div'=>false));?></div></li>
		</ul>
	</li>
</ul>
<?php
echo $form->end();
?>