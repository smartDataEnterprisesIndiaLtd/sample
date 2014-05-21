<style type="text/css" >
.blue-button-widget { padding-left: 0px !important; }
</style>
<?php echo $javascript->link(array('jquery')); ?>
<script>
jQuery(document).ready(function()  {
	//disable submit button after one click
	jQuery('#clickOnce').click(function(){
		if(jQuery("#ReviewReason").val() != "")
		{
			jQuery('#frmReview').submit();
			jQuery("#clickOnce").attr("disabled", "true");
			
		}
	});
});

</script>

<?php echo $javascript->link(array('behaviour.js','textarea_maxlen'));
echo $form->create('Review',array('action'=>'report_review','method'=>'POST','name'=>'frmReview','id'=>'frmReview'));
?>
<ul class="pop-con-list">
	<?php 
	if ($session->check('Message.flash')){ ?>
	<div >
		<div class="messageBlock"><?php echo $session->flash();?></div>
	</div>
	<?php }
	?>
	<?php if(!empty($errors)){
			$error_meaasge="Please add some information in the mandatory fields highlighted red below.";
	?>
		<div class="error_msg_box"> 
			<?php echo $error_meaasge;?>
		</div>
	<?php }?>
	<li>
		<?php echo $html->image("popup/flag.gif" ,array('width'=>"29",'height'=>"23", 'alt'=>"", 'class'=>"margin-top img",'align'=>"right" )); ?>
		<h4 class="red-color-text">Reporting a Voilation</h4>
	</li>
	<li>
		<p><strong>Please provide a short reason for your report:</strong></p>
		<p class="margin">
		<?php
			if(!empty($errors['reason'])){
				$errorReason='textfield error_message_box';
			}else{
				$errorReason='textfield';
			}
		echo $form->input('Review.reason',array('size'=>'30','label'=>false,'class'=>$errorReason,'rows'=>'5','cols'=>'45','maxlength'=>'1000','div'=>false,'showremain'=>"limitOne",'error'=>false,'style'=>'width:346px')); ?></p>
		
		<div style="padding-bottom:2px;">
			<span style="color:#7C7C7C;font-size:10px;float:left;margin-right:5px">Remaining characters : <span id ="limitOne"><?php if(!empty($this->data)){
				if(!empty($this->data['Review']['reason'])) {
					$remain = 1000 - strlen($this->data['Review']['reason']);
					echo $remain;
				} else {
					echo '1000'; 
				} 
			} else { 
				echo '1000'; } ?></span></span><?php if(!($form->error('Review.reason')))
					//echo '<br>'; else echo $form->error('Review.reason');?>
		</div>

		</p>
		<p><span class="gr-colr smlr-fnt">(Maximum 1000 characters)</span></p>
	</li>
	<li>
		<?php echo $form->hidden('Review.review_id',array('size'=>'30','type'=>'text','maxlength'=>30,'label'=>false,'class'=>'textfield','div'=>false));
		echo $form->hidden('Review.review',array('size'=>'30','type'=>'text','maxlength'=>30,'label'=>false,'class'=>'textfield','div'=>false));
		echo $form->hidden('Review.review_type',array('size'=>'30','type'=>'text','maxlength'=>30,'label'=>false,'class'=>'textfield','div'=>false));
		echo $form->hidden('Review.user',array('size'=>'30','type'=>'text','maxlength'=>30,'label'=>false,'class'=>'textfield','div'=>false));
		echo $form->hidden('Review.product_name',array('size'=>'30','type'=>'text','maxlength'=>30,'label'=>false,'class'=>'textfield','div'=>false));
		echo $form->hidden('Review.product_id',array('size'=>'30','type'=>'text','maxlength'=>30,'label'=>false,'class'=>'textfield','div'=>false));?>
		<div class="blue-button-widget margin-top"><?php echo $form->button('Submit Report',array('type'=>'submit','class'=>'blue-btn','div'=>false,'id'=>'clickOnce'));?></div>
	</li>
	
</ul>
<?php
echo $form->end();
?>