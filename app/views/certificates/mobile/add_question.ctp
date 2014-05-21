<?php //echo $javascript->link(array('behaviour.js','textarea_maxlen'));
echo $javascript->link(array('jquery-1.3.2.min','lib/prototype'));
echo $form->create('Certificate',array('action'=>'add_question','method'=>'POST','name'=>'frmCertificateQuestions','id' =>'frmCertificateQuestions'));

?>
<ul>
	<?php 
	if ($session->check('Message.flash')){ ?>
		<li><div class="messageBlock"><?php echo $session->flash();?></div></li>
		<script type="text/javascript">
			setTimeout(function () {
			location.reload(); 
			},3000); 					
		</script>
	<?php } ?>
	
	<li class="orange-col-head boldr">Q&amp;A</li>
	<li><b>Answer this question:</b> <span class="gray font11"> (Maximum 500 characters)</span></li>
	<li><?php echo $form->input('CertificateQuestion.question',array('size'=>'30','label'=>false,'class'=>'qatxtarea','rows'=>'5','cols'=>'45','maxlength'=>'500','div'=>false,'showremain'=>"limitOne"));?> </textarea>
	</li>
	<li class="font11"><b>Please note:</b> do not include any website link, if you wish to refer to another product on choiceful.com enter the Quick Code. All Q&amp;A are periodically checked and choiceful.com reserves the right to remove/edit any part of this content if it does not comply with our <?php echo $html->link('user agreement','javascript:void(0)',array('escape'=>false,'onClick'=>'golink(\'/pages/view/user-agreement\');'));?>.</li> 
	<li>
		<?php $options=array(
			"url"=>"/certificates/add_question","before"=>"",
			"update"=>'askqueid',
			'frequency' => 0.2,
			"indicator"=>"plsLoaderID",
			'loading'=>"Element.show('plsLoaderID')",
			"complete"=>"Element.hide('plsLoaderID')",
			"class" =>"bluggradbtn",
			"type"=>"Submit",
			"id"=>"addquestion",
			"div"=>"false",
		);?>
		<?php echo $ajax->submit('Continue',$options);?>
		<!--<input type="button" class="bluggradbtn" value="Continue">-->
	</li> 
</ul>
<?php
echo $form->end();
?>