<?php 
$session_ansID = $this->Session->read('sessionAnsId'.$ans_id);
App::import('Model','ProductanswerVote');
$this->ProductanswerVote = &new ProductanswerVote;

if(!empty($ans_id)){
	$yes_votes = $this->ProductanswerVote->find('count',array('conditions'=>array('ProductanswerVote.answer_id'=>$ans_id,'ProductanswerVote.user_vote'=>'1')));

	$no_votes = $this->ProductanswerVote->find('count',array('conditions'=>array('ProductanswerVote.answer_id'=>$ans_id,'ProductanswerVote.user_vote'=>'0')));
}

$total_votes = $yes_votes + $no_votes;

if(empty($total_votes))
	$total_votes = 1;

?>
<span class="gray smalr-fnt"><?php echo $yes_votes; ?> People found Q/A page helpful. Did you? 
	<?php 
	if(empty($session_ansID)){
	?>
	<?php echo $ajax->link('<strong>Yes</strong>','javascript::void(0)', array('update' => 'voteans_'.$ans_id, 'url' => '/products/save_ansvote/'.$ans_id.'/1',"indicator"=>"plsLoaderID",'loading'=>"Element.show('plsLoaderID')","complete"=>"Element.hide('plsLoaderID')",'escape'=>false), null,false);?> | 

	<?php echo $ajax->link('<strong>No</strong>','javascript::void(0)', array('update' => 'voteans_'.$ans_id, 'url' => '/products/save_ansvote/'.$ans_id.'/0',"indicator"=>"plsLoaderID",'loading'=>"Element.show('plsLoaderID')","complete"=>"Element.hide('plsLoaderID')",'escape'=>false), null,false);?> 
	<?php } else { echo 'Thank you.'; } ?>
</span>