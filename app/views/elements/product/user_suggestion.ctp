<?php ?>
       <?php
		$FeedbacksW = 'Feedback_'.$searchWord;
		$feedbackSuggestionMessages = $this->Session->read($FeedbacksW);
		if(!Empty($feedbackSuggestionMessages) && $feedbackSuggestionMessages=='1'){
		  session_unset($FeedbacksW);
	?>
           		 <span class="green-color">Thanks for your feedback.</span>
      		<?php }else{ ?>
			<span>
			<?php echo $ajax->link('<strong>Yes</strong>','', array('escape'=>false,'update' => 'sug_vote', 'url' => '/totalajax/suggestion_user/yes/'.$searchWord,'class'=>'','indicator'=>"plsLoaderID1",'loading'=>"showloading()",'complete'=>"hideloading()"), null,false);?> | 
			<?php echo $ajax->link('<strong>No</strong>','', array('escape'=>false,'update' => 'sug_vote', 'url' => '/totalajax/suggestion_user/no/'.$searchWord,'class'=>'','indicator'=>"plsLoaderID1",'loading'=>"showloading()",'complete'=>"hideloading()"), null,false);?>
			</span>
		<?php }?>