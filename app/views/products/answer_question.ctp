
<?php 
echo $javascript->link(array('behaviour','textarea_maxlen'));
echo $form->create('Product',array('action'=>'answer_question','method'=>'POST','name'=>'frmProductAnswer','id'=>'frmProductAnswer'));
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
	<li><span class="larger-font"><strong>Item:</strong></span> <?php echo $this->data['ProductAnswer']['product_name']; ?></li>
	<li><span class="red-color-text larger-font"><strong>Q </strong></span> <?php echo $this->Common->currencyEnter($this->data['ProductAnswer']['question']);?></li>
	<li><p><strong>Answer this question:</strong> <span class="gr-colr smlr-fnt">(Maximum 500 characters)</span></p>
		<p class="margin">
		<?php
			if(!empty($errors['answer'])){
				$errorAnswer='textfield error_message_box';
			}else{
				$errorAnswer='textfield';
			}
		?>
		<?php echo $form->input('ProductAnswer.answer',array('size'=>'30','label'=>false,'class'=>$errorAnswer,'rows'=>'5','cols'=>'45','maxlength'=>'500','div'=>false,'showremain'=>"limitOne",'error'=>false,'style'=>'width:346px')); ?></p>
		<div style="padding-bottom:2px;">
			<span style="color:#7C7C7C;font-size:10px;float:left;margin-right:5px">Remaining characters: <span id ="limitOne"><?php if(!empty($this->data)){
				if(!empty($this->data['ProductAnswer']['answer'])) { 
					
					$remain = 500 - strlen($this->data['ProductAnswer']['answer']);
					echo $remain;
				} else {
					echo '500'; 
				} 
			} else { 
				echo '500'; } ?></span></span><?php if(!($form->error('ProductAnswer.answer')))
					echo '<br>'; else  '<br>'; //echo $form->error('ProductAnswer.answer');?>

		</div>
		<div class="smlr-fnt"><strong>Please note:</strong> do not include any website links, if you wish to refer to another product on Choiceful.com enter its Quick Code. All  Q&amp;As are periodically checked and Choiceful.com reserves the right to remove/edit any part of this content if it does not comply with our  <?php echo $html->link('user agreement','javascript:void(0)',array('escape'=>false,'onClick'=>'golink(\'/pages/view/conditions-of-use\');'));?>.</div>
	</li>
	<li>
		<?php echo $form->hidden('ProductAnswer.product_question_id',array('size'=>'30','type'=>'text','maxlength'=>30,'label'=>false,'class'=>'textfield','div'=>false)); echo $form->hidden('ProductAnswer.product_name',array('size'=>'30','type'=>'text','maxlength'=>30,'label'=>false,'class'=>'textfield','div'=>false)); echo $form->hidden('ProductAnswer.question',array('size'=>'30','type'=>'text','maxlength'=>30,'label'=>false,'class'=>'textfield','div'=>false));?><div class="blue-button-widget">
		
		<?php echo $form->hidden("ProductAnswer.product_id",array('type'=>'text')); ?>
		<?php echo $form->button('Continue',array('type'=>'submit','class'=>'blue-btn','div'=>false));?>
	</li>
</ul>
<?php
echo $form->end();
?>