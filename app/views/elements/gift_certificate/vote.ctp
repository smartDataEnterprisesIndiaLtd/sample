<?php echo $javascript->link(array('jquery-1.3.2.min','lib/prototype'),false);
$savedvote = $this->Session->read('votesaved');


App::import('Model','ReviewVote');
$this->ReviewVote = &new ReviewVote;
$like_votes =0;$dislike_votes =0;$like_percentege =0; $dislike_percentege=0;
if(!empty($rev_id)){
	$like_votes = $this->ReviewVote->find('count',array('conditions'=>array('ReviewVote.review_id'=>$rev_id,'ReviewVote.user_vote'=>'1')));

	$dislike_votes = $this->ReviewVote->find('count',array('conditions'=>array('ReviewVote.review_id'=>$rev_id,'ReviewVote.user_vote'=>'0')));
}
$total_votes = $like_votes+$dislike_votes;
if(empty($total_votes))
	$total_votes = 1;

$like_percentege = $format->percentage($like_votes,$total_votes,0);
$like_width = round(($like_percentege / 100) * 56);
$dislike_percentege = $format->percentage($dislike_votes,$total_votes,0);
$dislike_width = round(($dislike_percentege / 100) * 56);


?>
<li class="reviewsli reportthis"><?php echo $like_votes;?> People found this helpful. Did you?&nbsp;</li>
<?php 
if(empty($savedvote)){
?>
<li class="reviewsli">
	<?php echo $ajax->link($html->image("like-this-icon.png",array('width'=>"58",'height'=>"25", 'alt'=>"" ,'class'=>'img pad-rt')),'javascript::void(0)', array('update' => 'vote', 'url' => '/reviews/savevote/'.$rev_id.'/1',"indicator"=>"plsLoaderID",'loading'=>"Element.show('plsLoaderID')","complete"=>"Element.hide('plsLoaderID')",'escape'=>false), null,false);?>
</li>
<li class="reviewsli">
	<?php echo $ajax->link($html->image("dislike-this.png",array('width'=>"32",'height'=>"25", 'alt'=>"" ,'class'=>'img pad-rt')),'javascript::void(0)', array('update' => 'vote', 'url' => '/reviews/savevote/'.$rev_id.'/1',"indicator"=>"plsLoaderID",'loading'=>"Element.show('plsLoaderID')","complete"=>"Element.hide('plsLoaderID')",'escape'=>false), null,false);?>
</li>
<?php } else {?>
<li class="reviewsli reportthis">Thank you.</li>
<?php }
?>
<li class="reviewsli">
	<div class="pro-bar-bg"> <div class="pro-bar-total" style="width:<?php echo $like_width;?>px"> </div><div class="pro-red" style="width:<?php echo $dislike_width;?>px;"> </div> </div>
</li>