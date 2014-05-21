<style>
.blue-button-widget
{ padding-left:1px !important;}
</style>

<?php 
echo $javascript->link(array('behaviour.js','textarea_maxlen'));
echo $form->create('Certificate',array('action'=>'answer_question','method'=>'POST','name'=>'frmCertificateAnswer','id'=>'frmCertificateAnswer'));
?>
<?php	if(!empty($errors)){
		$error_meaasge="Please add some information in the mandatory fields highlighted red below.";
	?>
	<div class="error_msg_box"> 
		<?php echo $error_meaasge;?>
	</div>
<?php }?>
<ul class="pop-con-list">
	<li><h4 class="dif-blue-color">Answer</h4></li>
	<li><span class="larger-font"><strong>Item:</strong></span> Gift Certificate</li>
	<li><span class="red-color-text larger-font"><strong>Q </strong></span> <?php echo $this->data['CertificateAnswer']['question']; ?></li>
	<li><p><strong>What would you like to know?</strong> <span class="gr-colr smlr-fnt">(Maximum 500 characters)</span></p>
		<p class="margin">
		<?php
			if(!empty($errors['answer'])){
				$errorAnswer='textfield error_message_box';
			}else{
				$errorAnswer='textfield';
			}
		?>
		<?php echo $form->input('CertificateAnswer.answer',array('size'=>'30','label'=>false,'class'=>$errorAnswer,'rows'=>'5','cols'=>'45','maxlength'=>'500','div'=>false,'showremain'=>"limitOne",'error'=>false,'style'=>'width:346px')); //echo $form->error('CertificateAnswer.answer'); ?></textarea></p>
		<p>
			<div style="color:#7C7C7C;font-size:10px">Remaining characters : <span id ="limitOne"><?php if(!empty($this->data)){
				if(!empty($this->data['CertificateAnswer']['answer'])) { 
					
					$remain = 500 - strlen($this->data['CertificateAnswer']['answer']);
					echo $remain;
				} else {
					echo '500'; 
				} 
			} else { 
				echo '500'; } ?></span></div>

		</p>
		<p class="smlr-fnt"><strong>Please note:</strong> do not include any website links, if you wish to refer to another product on Choiceful.com enter its Quick Code. All  Q&amp;As are periodically checked and Choiceful.com reserves the right to remove/edit any part of this content if it does not comply with our <?php echo $html->link('user-agreement','#',array('escape'=>false,'onClick'=>'golink(\'/pages/view/user-agreement\');'));?>.</p>
	</li>
	<li>
		<?php echo $form->hidden('CertificateAnswer.certificate_question_id',array('size'=>'30','type'=>'text','maxlength'=>30,'label'=>false,'class'=>'textfield','div'=>false));?><?php echo $form->hidden('CertificateAnswer.question',array('size'=>'30','type'=>'text','maxlength'=>30,'label'=>false,'class'=>'textfield','div'=>false));?><div class="blue-button-widget">
		<?php echo $form->button('Continue',array('type'=>'submit','class'=>'blue-btn','div'=>false));?>
	</li>
</ul>
<?php
echo $form->end();
?>
<!--But i think this timing is much better than proposed. Because in evening there will fog as well as darkness, so its hard to go home, due to darkness.-->