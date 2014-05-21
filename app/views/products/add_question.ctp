<?php  echo $form->create('Product',array('action'=>'add_question','method'=>'POST','name'=>'frmProductQuestions','id'=>'frmProductQuestions'));

echo $javascript->link(array('behaviour.js','textarea_maxlen'));
?>
		<?php	if(!empty($errors)){
				$error_meaasge="Please add some information in the mandatory fields highlighted red below.";
			?>
			<div class="error_msg_box"> 
				<?php echo $error_meaasge;?>
			</div>
		<?php }?>
<ul class="pop-con-list">
	<li><h4 class="dif-blue-color">Ask a Question</h4></li>
	<li><span class="larger-font"><strong>Item:</strong></span> <?php echo $this->data['ProductQuestion']['product_name']; ?></li>
	<li><p><strong>What would you like to know?</strong> <span class="gr-colr smlr-fnt">(Maximum 500 characters)</span></p>
		<p class="margin">
		<?php
			if(!empty($errors['question'])){
				$errorQuestion='textfield error_message_box';
			}else{
				$errorQuestion='textfield';
			}
		?>
		<?php echo $form->input('ProductQuestion.question',array('size'=>'30','label'=>false,'class'=>$errorQuestion,'rows'=>'5','cols'=>'45','maxlength'=>'500','div'=>false,'showremain'=>"limitOne",'error'=>false,'style'=>'width:346px'));  ?></textarea></p>
		<div style="padding-bottom:2px;">
			<span style="color:#7C7C7C; font-family:'arial'; font-size:10px;float:left;margin-right:5px">Remaining characters: <span id ="limitOne"><?php if(!empty($this->data)){
				if(!empty($this->data['ProductQuestion']['question'])) { 
					
					$remain = 500 - strlen($this->data['ProductQuestion']['comments']);
					echo $remain;
				} else {
					echo '500'; 
				} 
			} else { 
				echo '500'; } ?></span></span><?php if(!($form->error('ProductQuestion.question')))
					echo '<br>'; else '<br>'; //echo $form->error('ProductQuestion.question');?>
		</div>
		<div class="smlr-fnt"><strong>Please note:</strong> do not include any website links, if you wish to refer to another product on Choiceful.com enter its Quick Code. All  Q&amp;As are periodically checked and Choiceful.com reserves the right to remove/edit any part of this content if it does not comply with our <?php echo $html->link('user agreement','javascript:void(0)',array('escape'=>false,'onClick'=>'golink(\'/pages/view/conditions-of-use\');'));?>.</div>
		
	</li>
	<li>
		<?php echo $form->hidden('ProductQuestion.product_id',array('size'=>'30','type'=>'text','maxlength'=>30,'label'=>false,'class'=>'textfield','div'=>false));?><?php echo $form->hidden('ProductQuestion.product_name',array('size'=>'30','type'=>'text','maxlength'=>30,'label'=>false,'class'=>'textfield','div'=>false));?><?php echo $form->hidden('ProductQuestion.product_code',array('size'=>'30','type'=>'text','maxlength'=>30,'label'=>false,'class'=>'textfield','div'=>false));?><div class="blue-button-widget">
		<?php echo $form->submit('Continue',array('type'=>'submit','class'=>'blue-btn','div'=>false));?>
	</li>
</ul>
<?php
echo $form->end();
?>