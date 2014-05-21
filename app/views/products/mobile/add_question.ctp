<script defer="defer" type="text/javascript" src="/js/lib/prototype.js"></script>
<script defer="defer" type="text/javascript" src="/js/jquery-1.3.2.min.js"></script>
<?php  
//echo $javascript->link(array('behaviour.js','textarea_maxlen'));
//echo $javascript->link(array('jquery-1.3.2.min', 'lib/prototype'), true);
echo $form->create('Product',array('action'=>'add_question','method'=>'POST','name'=>'frmProductQuestions','id'=>'frmProductQuestions'));
?>

<ul>
<li class="orange-col-head boldr">Q&amp;A</li>
<?php 
if ($session->check('Message.flash')){ ?>
<li >
	<div class="messageBlock"><?php echo $session->flash();?></div>
		<!-- For Auto redirect of the product page-->
		<script defer="defer" type="text/javascript">
			setTimeout(function () {
			location.reload(); 
			},3000); 					
		</script>

</li>
<?php }?>
<!--<li class="applprdct"><span class="drkred boldr hwtstn">Q</span>
<?php //echo $this->data['ProductQuestion']['product_name']; ?></li>-->

	<li class="applprdct"><b>What would you like to know?</b><span class="gray font11"> (Maximum 500 characters)</span></li>
	<li>
	<?php echo $form->input('ProductQuestion.question',array('size'=>'30','label'=>false,'class'=>'qatxtarea','rows'=>'5','cols'=>'45','maxlength'=>'500','div'=>false,'showremain'=>"limitOne",'error'=>false));  ?>
	</li>
	
	<li class="font11"><b>Please note:</b> do not include any website links, if you wish to refer to another product on choiceful.com enter the Quick Code. All Q&amp;A are periodically checked and choiceful.com reserves the right to remove/edit any part of this content if it does not comply with our <?php echo $html->link('user agreement','/pages/view/conditions-of-use',array('escape'=>false,));?>.</li> 
	
	<li>
		<?php echo $form->hidden('ProductQuestion.product_id',array('size'=>'30','type'=>'text','maxlength'=>30,'label'=>false,'class'=>'textfield','div'=>false));?><?php echo $form->hidden('ProductQuestion.product_name',array('size'=>'30','type'=>'text','maxlength'=>30,'label'=>false,'class'=>'textfield','div'=>false));?><?php echo $form->hidden('ProductQuestion.product_code',array('size'=>'30','type'=>'text','maxlength'=>30,'label'=>false,'class'=>'textfield','div'=>false));?><div class="blue-button-widget">
		
		<?php $options=array(
			"url"=>"/products/add_question/".$product_id,"before"=>"",
			"update"=>"tab4",
			"indicator"=>"plsLoaderID",
			'loading'=>"Element.show('plsLoaderID')",
			"complete"=>"Element.hide('plsLoaderID')",
			"class" =>"bluggradbtn",
			"type"=>"Submit",
			"id"=>"addquestion",
			"div"=>"false",
		);?>
		<a href="javascript void(0);"><?php echo $ajax->submit('Continue',$options);?></a>
		
		<?php //echo $form->button('Continue',array('type'=>'submit','class'=>'blue-btn','div'=>false));?>
	</li>
	
	
	<!--<li><input type="button" class="bluggradbtn" value="Continue"></li> -->
</ul>
<?php
echo $form->end();
?>