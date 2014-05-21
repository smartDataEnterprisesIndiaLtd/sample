<?php 
?>
	<label class="margin-top">Subject</label>
	<?php
		if(($form->error('ContactusSubject.subject'))){
			$errorClass='slctsbjct float-right error_message_box';
		}else{
			$errorClass='slctsbjct float-right';
		}
		
		echo $form->select("ContactusSubject.subject",$subject,1,array('class'=>$errorClass,'style'=>'padding: 5px 0pt; height: auto;','empty'=>'Select a subject'));
	?>
