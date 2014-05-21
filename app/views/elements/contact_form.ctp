<?php
echo $javascript->link(array('behaviour.js','textarea_maxlen'));
?>
<!--Content Section Starts-->

	
<?php echo $form->create('Pages',array('action'=>'view/contact-us','method'=>'POST','name'=>'frmPages','id'=>'frmPages'));?>
	<section class="diffdprtmnt">
	<p>Please use the form below to send us an email. We will contact you by email to the registered address on your account.</p>
	<p class="drkred">For security reasons, do not use this form to submit any personal information</p>
	<ul class="cntctusfrm">		
		<li>
			<label>To</label>
			<div class="cntfields"><span id="UpdateTo">Customer Services</span>
			<p class="boldr applprdct">Need to select a different department?</p>
			<?php 
			if(($form->error('ContactusSubject.email_to'))){
				  	$errorClass='slctdprtmnt error_message_box';
				}else{
					$errorClass='slctdprtmnt';
				}
			//echo $form->select("ContactusSubject.email_to",$emil_send_to,1,array('class'=>$errorClass, 'div'=>false, 'error'=>false,'label'=>false,'empty'=>'Please Select','onchange'=>'subject(this.value)'));
			echo $form->input("ContactusSubject.email_to",array('type'=>'select','options'=>$emil_send_to,'class'=>$errorClass, 'div'=>false, 'error'=>false,'label'=>false,'empty'=>'Please Select','onchange'=>'subject(this.value)'));
			//echo $form->error('ContactusSubject.email_to');
			?>
			</div>
		</li>		
		<li>
			<label>From</label>
			<div class="cntfields"><span id="UpdateEmail" class="show"><?php echo ucfirst($user_name);?> ( <span id="showEmail"><?php echo $user_email;?></span> )
			<a id="ShowHide" class="font11"><strong>Change</strong></a>
			</span>
			<span id="emailbox" class="hide">
				<?php
				echo $form->hidden('User.id', array('value'=>$user_id,'div'=>false));?>
				<?php echo ucfirst($user_name);?>
				(<?php
				echo $form->input('User.email',array('value'=>$user_email,'div'=>false, 'label'=>false,));
				?><span id="error_message"></span>)
				<a id="UpdateDivId"><strong>Update</strong></a>
			</span>
		</p>
		</div>
		</li>
			<div id="ajaxLoader" style="display:none;padding-left:60px;"><img src="/Beta/img/loading.gif" alt="loading..."></div>
		<li id="UpdateDiv">
			<label>Subject</label>
			<div class="cntfields"><?php
				if(($form->error('ContactusSubject.subject'))){
				  	$errorClass='slctsbjct error_message_box';
				}else{
					$errorClass='slctsbjct';
				}
			 
			 //echo $form->select("ContactusSubject.subject",$subject,8,array('class'=>$errorClass,'empty'=>'Select a subject'));
			 echo $form->input("ContactusSubject.subject",array('class'=>$errorClass,'options'=>$subject,'type'=>'select','div'=>false, 'error'=>false,'label'=>false,'empty'=>'Select a Subject'));
			 ?>
			 </div>
		</li>
		<li>
			<label>Comment</label>
			<div class="cntfields"><?php 
				if(($form->error('ContactusSubject.comments'))){
				  	$errorClass='textfield error_message_box';
				}else{
					$errorClass='textfield';
				}	
				echo $form->input('ContactusSubject.comments',array('size'=>'30','label'=>false,'class'=>$errorClass,'rows'=>'5','cols'=>'45','maxlength'=>'5000','div'=>false,'showremain'=>"limitOne",'error'=>false));
			 ?>	
			
			<p class="lgtgray font11 chcrtrlmt">
			<span id ="limitOne">5000</span><span style="text-align:left;">&nbsp;characters left. NO HTML</span>
			<?php 
			if(!empty($this->data)){
				if(!empty($this->data['ContactusSubject']['comments'])) { 
					
					$remain = 5000 - strlen($this->data['ContactusSubject']['comments']);
					//echo $remain.'characters left. NO HTML';
				} else {
					//echo 'characters left. NO HTML'; 
				} 
			} ?>
					
		<div class="blue-button-widget float-right">
			<?php echo $form->button('Send Email',array('type'=>'submit','class'=>'blue-btn','div'=>false));?>
		</div>
		</p></div>
		
		</li>
	</ul>
<?php echo $form->end();?>
	
	<!--Content Section End-->