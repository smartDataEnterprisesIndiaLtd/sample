<?php echo $javascript->link(array('jquery')); ?>
<script>
jQuery(document).ready(function()  {
	//disable submit button after one click
	jQuery('#clickOnce').click(function(){
		if(jQuery("#ProductReason").val() != "")
		{
			jQuery('#frmProduct').submit();
			jQuery("#clickOnce").attr("disabled", "true");
			
		}
	});
});

</script>

<?php  echo $javascript->link(array('behaviour.js','textarea_maxlen'));
echo $form->create('Product',array('action'=>'tell_admin','method'=>'POST','name'=>'frmProduct','id'=>'frmProduct'));
?>
<style>
.error-message{
margin-bottom:2px!important;
}
</style>
<ul class="pop-con-list">
	<?php 
	if ($session->check('Message.flash')){ ?>
	<div>
		<div class="messageBlock"><?php echo $session->flash();?></div>
	</div>
	<?php } ?>
	
	<?php if(!empty($errors)){
			$error_meaasge="Please add some information in the mandatory fields highlighted red below.";
	?>
		<div class="error_msg_box"> 
			<?php echo $error_meaasge;?>
		</div>
	<?php }?>
	
	<li>
		<?php echo $html->image("popup/flag.gif" ,array('width'=>"29",'height'=>"23", 'alt'=>"", 'class'=>"margin-top img",'align'=>"right" )); ?>
		<h4 class="red-color-text">Reporting a Violation</h4>
	</li>
	<li>
		<p><strong>Please provide a short reason for your report:</strong></p>
		<p class="margin"><?php
		
		if(!empty($errors['reason'])){
				$errorReason='textfield error_message_box';
			}else{
				$errorReason='textfield';
			}
		
		echo $form->input('Product.reason',array('size'=>'30','label'=>false,'class'=>$errorReason,'error'=>false,'rows'=>'5','cols'=>'45','maxlength'=>'1000','div'=>false,'showremain'=>"limitOne",'error'=>false,'style'=>'width:346px')); ?>
<?php echo $form->hidden('Product.id'); ?><br ><?php echo $form->hidden('Product.name');?></p>
		<p>
			<div style="color:#7C7C7C; font-family:'arial'; font-size:10px;float:left;margin-right:5px">Remaining characters: <span id ="limitOne"><?php if(!empty($this->data)){
				if(!empty($this->data['Product']['reason'])) { 
					
					$remain = 1000 - strlen($this->data['Product']['reason']);
					echo $remain;
				} else {
					echo '1000'; 
				} 
			} else { 
				echo '1000'; } ?></span></div>                        

		</p>
		<p><span class="gr-colr smlr-fnt">(Maximum 1000 characters)</span></p>
	</li>
	<li>
		<div class="blue-button-widget margin-top"><?php echo $form->submit('Submit Report',array('type'=>'submit','class'=>'blue-btn','div'=>false,'id'=>'clickOnce'));?></div>
	</li>
	
</ul>
<?php echo $form->end(); ?>            