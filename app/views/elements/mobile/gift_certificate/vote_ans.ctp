<?php 
$session_giftansID = $this->Session->read('sessionGiftAnsId'.$ans_id);
App::import('Model','CertificateanswerVote');
$this->CertificateanswerVote = &new CertificateanswerVote;

if(!empty($ans_id)){
	$yes_votes = $this->CertificateanswerVote->find('count',array('conditions'=>array('CertificateanswerVote.answer_id'=>$ans_id,'CertificateanswerVote.user_vote'=>'1')));

	$no_votes = $this->CertificateanswerVote->find('count',array('conditions'=>array('CertificateanswerVote.answer_id'=>$ans_id,'CertificateanswerVote.user_vote'=>'0')));
}

$total_votes = $yes_votes + $no_votes;

if(empty($total_votes))
	$total_votes = 1;

?>
<!--
<p class="reviewer-count"><span class="gray">0 People found this helpful. Did you?</span><a href="#"><strong>Yes</strong></a> | <a href="#"><strong>No</strong></a> </p>-->

<p class="reviewer-count">
	<span class="gray"><?php echo $yes_votes; ?> People found Q/A page helpful. Did you?</span>
	
	<?php 
	if(empty($session_giftansID)){
	?>
	
	<?php 
		echo $html->link('<strong>Yes</strong>','javascript::void(0)', array('Onclick'=>'saveAnsVote('.$ans_id.',1)','escape'=>false), null,false);?> |
	<?php 
		echo $html->link('<strong>No</strong>','javascript::void(0)', array('Onclick'=>'saveAnsVote('.$ans_id.',0)','escape'=>false), null,false);?>
		
	<?php } else { echo 'Thank you.'; } ?>

 </p>
 

<script defer="defer" type="text/javascript">
var SITE_URL = "<?php echo SITE_URL; ?>";
 // function to like to dislike in giftcertificate
function saveAnsVote(ans_id, att1){
	var postUrl = SITE_URL+'certificates/save_ansvote/'+ans_id+'/'+att1;
	//alert(postUrl);
	jQuery('#plsLoaderID').show();
	jQuery.ajax({
		cache:false,
		async: false,
		type: "GET",
		url: postUrl,
		success: function(msg){
		/** Update the div**/
		jQuery('#voteans_'+ans_id).html(msg);
		jQuery('#plsLoaderID').hide();
	}
	});
}
</script>