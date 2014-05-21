<?php  echo $form->create('Product',array('action'=>'add_question','method'=>'POST','name'=>'frmProductQuestions','id'=>'frmProductQuestions'));
?>
<ul class="pop-con-list">
	<li><h4 class="dif-blue-color">Ask a Question</h4></li>
	<li><span class="larger-font"><strong>Item:</strong></span> <?php echo $this->data['ProductQuestion']['product_name']; ?></li>
	<li><p><strong>What would you like to know?</strong> <span class="gr-colr smlr-fnt">(Maximum 500 characters)</span></p>
		<p class="margin"><?php echo $form->input('ProductQuestions.question',array('size'=>'30','label'=>false,'class'=>'textfield','rows'=>'5','cols'=>'45','div'=>false)); echo $form->error('Review.comments'); ?></p>
		<p class="smlr-fnt"><strong>Please note:</strong> do not include any website links, if you wish to refer to another project on Choiceful.com enter its Quick Code. All  Q&amp;As are periodically checked and Choiceful.com reserves the right to remove/edit any part of this content if it does not comply with our <a href="#">user agreement</a>.</p>
	</li>
	<li>
		<?php echo $form->hidden('ProductQuestions.product_id',array('size'=>'30','type'=>'text','maxlength'=>30,'label'=>false,'class'=>'textfield','div'=>false)); echo $form->hidden('ProductQuestions.product_code',array('size'=>'30','type'=>'text','maxlength'=>30,'label'=>false,'class'=>'textfield','div'=>false));?><div class="blue-button-widget">
		<?php echo $form->button('Continue',array('type'=>'submit','class'=>'blue-button-widget','div'=>false));?>
	</li>
</ul>
<?php
echo $form->end();
?>