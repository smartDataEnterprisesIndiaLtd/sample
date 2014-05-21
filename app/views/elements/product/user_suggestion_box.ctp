<style>
.form-error{
	float:none;
}
</style>
<?php if(!empty($errors)){
		$error_meaasge="Please add some information in the mandatory fields highlighted red below.";
	?>
	<div class="error_msg_box"> 
		<?php echo $error_meaasge;?>
	</div>
<?php }?>
<!--Suggestion Start-->
		<div class="suggestion-widget">
                    	<div class="suggestion-box-img"><?php echo $html->image('images/suggestion-box.gif',array('height'=>"44", 'width'=>"38"));?></div>
			<!--Suggestion Box Content Start-->
			<div class="suggestion-box-content">
				
				<h1>Suggestion Box</h1>
				<p>Still can't find what you're searching for? Provide us a brief description of the item that you're trying to find so that we can improve our search.</p>
				<p><strong>Please note:</strong> We are unable to reply directly to suggestions.</p>
				
				<?php 
                                    $ssW = 'Box_'.$searchWord;
                                    $suggestionMessages = $this->Session->read($ssW);
                                    if(!Empty($suggestionMessages) && $suggestionMessages == '1') {
					session_unset($ssW);
				?>
                                            <p class="confirmation-widget"><?php echo $html->image('green-check.png',array('alt'=>'','class'=>'')); ?>
					    <span class="font-size20 green-color">Thanks for your suggestion</span> <span class="thanks-note">Please note we will not reply to your comments directly, if you have any questions please contact us.</span></p>
                                    <?php } else{ ?>
						<?php echo $form->create('Totalajax',array('action'=>'suggestion_user','method'=>'POST','name'=>'frmEvent','id'=>'frmEvent'));?>
						<p class="margin-top">
							<?php
							if(!empty($errors['suggestion'])){
									$errorSuggestion ='form-textfield error_message_box';
								}else{
									$errorSuggestion ='form-textfield';
								}
								
							echo $form->input('UserSuggestion.suggestion',array('type'=>'textarea','maxlength'=>'500','style'=>"width: 95%;",'class'=>$errorSuggestion,'cols'=>'45','roew'=>'4','label'=>false,'error'=>false,'div'=>false));?>
							<?php echo $form->hidden('UserSuggestion.search_key',array('size'=>'30','value'=>$searchWord,'class'=>'form-textfield','maxlength'=>'30','label'=>false,'div'=>false));?>
							<?php echo $form->hidden('UserSuggestion.ip_address',array('size'=>'30','value'=>$_SERVER['REMOTE_ADDR'],'class'=>'form-textfield','maxlength'=>'30','label'=>false,'div'=>false));?>
						</p>
						<p class="margin-top">
						</p>
						<div class="red-button-widget">
							<?php $options=array(
							"url"=>"/totalajax/suggestion_user","before"=>"",
							"update"=>"sug_vote_box",
							"indicator"=>"plsLoaderID1",
							'loading'=>"showloading()",
							"complete"=>"hideloading()",
							"class" =>"button",
							"type"=>"Submit",
							"id"=>"myName",
							"name"=>"myName",
							);?>
							<?php echo $ajax->submit('Submit',$options);?>	
							
						</div>
					<?php echo $form->end();?>
				    <?php }?>
			</div>
			<!--Suggestion Box Content Closed-->
			
		</div>
		<!--Suggestion Closed-->