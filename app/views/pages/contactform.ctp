<li>
	<label>Subject</label>
	<div class="cntfields">
		<?php echo $form->select("ContactusSubject.subject",$subject,1,array('class'=>'slctsbjct','empty'=>'Select a subject')); echo $form->error('ContactusSubject.email_to');?>
	</div>
</li>