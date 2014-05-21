<script defer="defer" type="text/javascript" src="/js/lib/prototype.js"></script>
<script defer="defer" type="text/javascript" src="/js/jquery-1.3.2.min.js"></script>
<script defer="defer" type="text/javascript" src="/js/textarea_maxlen.js"></script>
<script defer="defer" type="text/javascript" src="/js/behaviour.js"></script>
<?php 
//echo $javascript->link(array('behaviour.js','textarea_maxlen'));
//echo $javascript->link(array('jquery-1.3.2.min', 'lib/prototype'), true);
echo $form->create('Product',array('action'=>'answer_question','method'=>'POST','name'=>'frmProductAnswer','id'=>'frmProductAnswer'));
?>
<ul>
<li class="orange-col-head boldr">Q&amp;A</li>
<?php 
if ($session->check('Message.flash')){ ?>
<li >
	<div class="messageBlock"><?php echo $session->flash();?></div>
	<!-- For Auto redirect of the product page-->
		<script type="text/javascript">
			setTimeout(function () {
			location.reload(); 
			},3000); 					
		</script>
</li>
<?php }?>
<li class="applprdct"><span class="drkred boldr hwtstn">Q</span>
<?php echo $this->data['ProductAnswer']['question']; ?></li>

	<li><b>Answer this question:</b> <span class="gray font11">(Maximum 500 characters)</span>
	<?php echo $form->input('ProductAnswer.answer',array('size'=>'30','label'=>false,'class'=>'qatxtarea','rows'=>'5','cols'=>'45','maxlength'=>'500','div'=>false,'showremain'=>"limitOne",'error'=>false)); ?>
	</li>
	<li class="font11"><b>Please note:</b> do not include any website links, if you wish to refer to another product on choiceful.com enter the Quick Code. All Q&amp;A are periodically checked and choiceful.com reserves the right to remove/edit any part of this content if it does not comply with our <?php echo $html->link('user agreement','/pages/view/conditions-of-use',array('escape'=>false,));?>.</li>
	<li>
		<?php echo $form->hidden('ProductAnswer.product_question_id',array('size'=>'30','type'=>'text','maxlength'=>30,'label'=>false,'class'=>'textfield','div'=>false)); echo $form->hidden('ProductAnswer.product_name',array('size'=>'30','type'=>'text','maxlength'=>30,'label'=>false,'class'=>'textfield','div'=>false)); echo $form->hidden('ProductAnswer.question',array('size'=>'30','type'=>'text','maxlength'=>30,'label'=>false,'class'=>'textfield','div'=>false));?><div class="blue-button-widget">
		
		<?php echo $form->hidden("ProductAnswer.product_id",array('type'=>'text')); ?>
		
		<?php $options=array(
			"url"=>"/products/answer_question","before"=>"",
			"update"=>"tab4",
			"indicator"=>"plsLoaderID",
			'loading'=>"Element.show('plsLoaderID')",
			"complete"=>"Element.hide('plsLoaderID')",
			"class" =>"bluggradbtn",
			"type"=>"Submit",
			"id"=>"addans",
			"div"=>"false",
		);?>
		<a href="javascript void(0);"><?php echo $ajax->submit('Continue',$options);?></a>
		
		
		<?php //echo $form->button('Continue',array('type'=>'submit','class'=>'blue-btn','div'=>false));?>
	</li>
</ul>
<?php
echo $form->end();
?>