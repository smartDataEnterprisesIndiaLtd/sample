<?php
$savedGiftVote_pos = $this->Session->read('giftVotesaved_pos'.$rev_gift_pos_id);

App::import('Model','CertificateReviewVote');
$this->CertificateReviewVote = &new CertificateReviewVote;

$like_gift_votes = 0; $dislike_gift_votes = 0; $like_gift_percentege = 0; $dislike_gift_percentege = 0;

if(!empty($rev_gift_pos_id)){
	$like_gift_votes = $this->CertificateReviewVote->find('count',array('conditions'=>array('CertificateReviewVote.review_id'=>$rev_gift_pos_id,'CertificateReviewVote.user_vote'=>'1')));

	$dislike_gift_votes = $this->CertificateReviewVote->find('count',array('conditions'=>array('CertificateReviewVote.review_id'=>$rev_gift_pos_id,'CertificateReviewVote.user_vote'=>'0')));
}

$total_gift_votes = $like_gift_votes + $dislike_gift_votes;

if(empty($total_gift_votes))
	$total_gift_votes = 1;

$like_gift_percentege = $format->percentage($like_gift_votes,$total_gift_votes,0);
$like_gift_width = round(($like_gift_percentege / 100) * 56);
$dislike_gift_percentege = $format->percentage($dislike_gift_votes,$total_gift_votes,0);
$dislike_gift_width = round(($dislike_gift_percentege / 100) * 56);


?>
<!--li class="reviewer-count"><span  class="smalr-fnt gray"><?php //echo $total_gift_votes;?> People found this helpful. Did you?&nbsp;</span></li-->
<?php 
if(empty($savedGiftVote_pos)){
?>

	<li>
	<div class="like-div-padding">
		<?php 
			echo $html->link($html->image("like-this-icon.png",array('width'=>"58",'height'=>"25", 'alt'=>"" ,'class'=>'img pad-rt')),'javascript::void(0)', array('Onclick'=>'likereview('.$rev_gift_pos_id.',1,2)','escape'=>false), null,false);
		?>
		<?php 
			echo $html->link($html->image("dislike-this.png",array('width'=>"32",'height'=>"25", 'alt'=>"" ,'class'=>'img pad-rt')),'javascript::void(0)', array('Onclick'=>'likereview('.$rev_gift_pos_id.',0,2)','escape'=>false), null,false);
		?>
	</div>
		<div class="pro-bar-bg"> <div class="pro-bar-total" style="width:<?php echo $like_gift_width;?>px"> </div><div class="pro-red" style="width:<?php echo $dislike_gift_width;?>px;"> </div> </div>
	</li>
<?php } else {?>
	<li>
		<div style="float:left;width:65px; padding-top:5px;">Thank you.</div>
		 
		 <div class="pro-bar-bg" style="padding-right:5px;"> 
		 	<div class="pro-bar-total" style="width:<?php echo $like_gift_width;?>px"> </div>
		 	<div class="pro-red" style="width:<?php echo $dislike_gift_width;?>px;"> </div> 
		 </div>
	</li>
<?php }?>
	

<script defer="defer" type="text/javascript">
var SITE_URL = "<?php echo SITE_URL; ?>";
 // function to like to dislike in giftcertificate
function likereview(rev_gift_pos_id, att1, att2){

	var postUrl = SITE_URL+'certificates/save_reviewvote/'+rev_gift_pos_id+'/'+att1+'/'+att2;
	//alert(postUrl);
	jQuery('#plsLoaderID').show();
	jQuery.ajax({
		cache:false,
		async: false,
		type: "GET",
		url: postUrl,
		success: function(msg){
		/** Update the div**/
		jQuery('#vote_pos_'+rev_gift_pos_id).html(msg);
		jQuery('#plsLoaderID').hide();
	}
	});
}


</script>
