<?php echo $javascript->link(array('jquery')); ?>
<script>
jQuery(document).ready(function()  {
	//disable submit button after one click
	jQuery('#clickOnce').click(function(){
		if(jQuery("#ProductComments").val() != "")
		{
			jQuery('#frmFeedback').submit();
			jQuery("#clickOnce").attr("disabled", "true");
		}
	});                                                              
});

</script>

<?php 
echo $javascript->link(array('behaviour.js','textarea_maxlen'));
echo $javascript->link(array('jquery-1.3.2.min','lib/prototype'));
echo $form->create('Product',array('action'=>'ad_feedback/'.$quick_code,'method'=>'POST','name'=>'frmFeedback','id'=>'frmFeedback'));
?>
<style language="css/text">
.error-message {	margin-left:0px!important; }
.blue-button-widget { padding-left: 0px!important; }
</style>
<ul class="pop-con-list">
	<?php 
	if ($session->check('Message.flash')){ ?>
	<li>
		<div><?php echo $session->flash();?></div>
	</li>
	<?php } ?>
	<?php
	if(!empty($errors)){
		$error_meaasge="Please add some information in the mandatory fields highlighted red below.";
	?>
		<div class="error_msg_box"> 
			<?php echo $error_meaasge;?>
		</div>
	<?php }?>
	
	<?php if(empty($error)) {?>
	<li>
		<h4>Ad Feedback</h4>
	</li>
	<li class="red-color-text">
		Let us know what you think of our advertisement.
	</li>
	<li class="dif-blue-color">
		This will help us  show more relavent ads.
	</li>
	<li>
		<p><strong>Comments:</strong> <span class="gr-colr smlr-fnt">(Maximum 500 characters)</span></p>
		<p class="margin">
		<?php
			if(!empty($errors)){
				$error='textfield error_message_box';
			}else{
				$error='textfield';
			}
		?>
		<?php echo $form->input('Product.comments',array('size'=>'30','label'=>false,'class'=>$error,'rows'=>'5','cols'=>'45','div'=>false,'maxlength'=>500,'showremain'=>"limitOne",'style'=>'width:337px')); ?></p>
		<div style="padding-bottom:2px;">
			<span style="color:#7C7C7C; font-family:'arial'; font-size:10px;float:left;margin-right:5px">Remaining characters: <span id ="limitOne"><?php if(!empty($this->data)){
				if(!empty($this->data['Product']['comments'])) { 
					
					$remain = 500 - strlen($this->data['Product']['comments']);
					echo $remain;
				} else {
					echo '500'; 
				} 
			} else { 
				echo '500'; } ?></span></span><?php if(!($form->error('Product.comments')))
					echo '<br>'; else '<br>'; //echo $form->error('ProductQuestion.question');?>
		</div>
	</li>
	
	
	<li>
		<?php echo $form->hidden('Product.quick_code',array('label'=>false,'div'=>false, 'value'=>$quick_code)); ?>
		<div class="blue-button-widget">
		<?php echo $form->button('Submit Feedback',array('type'=>'submit','class'=>'blue-btn','div'=>false,'id'=>'clickOnce'));?>
		</div>
	</li>
	<?php }?>
</ul>
<?php
echo $form->end();
?>