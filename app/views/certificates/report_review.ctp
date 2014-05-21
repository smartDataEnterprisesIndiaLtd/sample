<style>
.blue-button-widget
{ padding-left:1px !important;}
</style>

<?php  echo $javascript->link(array('behaviour.js','textarea_maxlen'));
echo $form->create('Certificate',array('action'=>'report_review','method'=>'POST','name'=>'frmCertificate','id'=>'frmCertificate'));
?>
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
			
		echo $form->input('Certificate.reason',array('size'=>'30','label'=>false,'class'=>$errorReason,'rows'=>'5','cols'=>'45','maxlength'=>'1000','div'=>false,'showremain'=>"limitOne",'error'=>false,'style'=>'width:346px')); ?></textarea></p>
		<p>
			<div style="color:#7C7C7C;font-size:10px">Remaining characters : <span id ="limitOne"><?php if(!empty($this->data)){
				if(!empty($this->data['Certificate']['reason'])) { 
					
					$remain = 1000 - strlen($this->data['Certificate']['reason']);
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
		<?php echo $form->hidden('Certificate.review_id',array('size'=>'30','type'=>'text','maxlength'=>30,'label'=>false,'class'=>'textfield','div'=>false));
		echo $form->hidden('Certificate.review',array('size'=>'30','type'=>'text','maxlength'=>30,'label'=>false,'class'=>'textfield','div'=>false));
		echo $form->hidden('Certificate.review_type',array('size'=>'30','type'=>'text','maxlength'=>30,'label'=>false,'class'=>'textfield','div'=>false));
		echo $form->hidden('Certificate.user',array('size'=>'30','type'=>'text','maxlength'=>30,'label'=>false,'class'=>'textfield','div'=>false)); ?>
		<div class="blue-button-widget margin-top"><?php echo $form->button('Submit Report',array('type'=>'submit','class'=>'blue-btn','div'=>false));?></div>
	</li>
	
</ul>
<?php echo $form->end(); ?>