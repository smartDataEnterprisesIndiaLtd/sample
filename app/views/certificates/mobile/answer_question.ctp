<?php 
//echo $javascript->link(array('behaviour.js','textarea_maxlen'));
echo $javascript->link(array('jquery-1.3.2.min','lib/prototype'));
echo  $form->create('Certificate',array('action'=>'answer_question','method'=>'POST','name'=>'frmCertificateAnswer','id'=>'frmCertificateAnswer'));
?>
 <ul>
	<li class="orange-col-head boldr">Q&amp;A</li>
	<?php 
	if ($session->check('Message.flash')){ ?>
		<li><div class="messageBlock"><?php echo $session->flash();?></div></li>
		
		<script type="text/javascript">
			setTimeout(function () {
			location.reload(); 
			},3000); 					
		</script>
	<?php } ?>
	<li class="applprdct"><span class="drkred boldr hwtstn">Q</span><?php echo $this->data['CertificateAnswer']['question']; ?></li>
	
		<li><b>Answer this question:</b> <span class="gray font11"> (Maximum 500 characters)</span>
		<?php echo $form->input('CertificateAnswer.answer',array('size'=>'30','label'=>false,'class'=>'qatxtarea','rows'=>'5','cols'=>'45','maxlength'=>'500','div'=>false,'showremain'=>"limitOne")); //echo $form->error('CertificateAnswer.answer'); ?></textarea>
		<!--<textarea class="qatxtarea"></textarea>-->
		</li>
		<li class="font11"><b>Please note:</b> do not include any website link, if you wish to refer to another product on choiceful.com enter the Quick Code. All Q&amp;A are periodically checked and choiceful.com reserves the right to remove/edit any part of this content if it does not comply with our <?php echo $html->link('user-agreement','#',array('escape'=>false,'onClick'=>'golink(\'/pages/view/user-agreement\');'));?>.</li> 
		<li>
		<?php echo $form->hidden('CertificateAnswer.certificate_question_id',array('size'=>'30','type'=>'text','maxlength'=>30,'label'=>false,'class'=>'textfield','div'=>false));?><?php echo $form->hidden('CertificateAnswer.question',array('size'=>'30','type'=>'text','maxlength'=>30,'label'=>false,'class'=>'textfield','div'=>false));?><div class="blue-button-widget">
		<?php $options=array(
			"url"=>"/certificates/answer_question/".$question_id,"before"=>"",
			"update"=>'askqueid',
			'frequency' => 0.2,
			"indicator"=>"plsLoaderID",
			'loading'=>"Element.show('plsLoaderID')",
			"complete"=>"Element.hide('plsLoaderID')",
			"class" =>"bluggradbtn",
			"type"=>"Submit",
			"id"=>"getanswer",
			"div"=>"false",
		);?>
		<?php echo $ajax->submit('Continue',$options);?>
		<!--<input type="button" class="bluggradbtn" value="Continue">--></li> 
	</ul>
<?php
echo $form->end();
?>
<!--But i think this timing is much better than proposed. Because in evening there will fog as well as darkness, so its hard to go home, due to darkness.-->