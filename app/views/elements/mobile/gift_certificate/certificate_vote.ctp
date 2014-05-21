<?php
$productpageVote = 'giftpageVote';
$productpageVoteSession = $this->Session->read($productpageVote);

App::import('Model','CertificateVote');
$this->CertificateVote = &new CertificateVote;

$like_people = $this->CertificateVote->find('count',array('conditions'=>array('CertificateVote.user_vote'=>'1')));
?>
<span class="gray smalr-fnt"><?php echo $like_people;?> People found this page helpful. Did you? 
<?php 
if(empty($productpageVoteSession)){
?>
<?php echo $ajax->link('<strong>Yes</strong>','javascript::void(0)', array('update' => 'giftVoteId', 'url' => '/certificates/save_giftpageVote/1',"indicator"=>"plsLoaderID",'loading'=>"Element.show('plsLoaderID')","complete"=>"Element.hide('plsLoaderID')",'escape'=>false), null,false);?> | 

<?php echo $ajax->link('<strong>No</strong>','javascript::void(0)', array('update' => 'giftVoteId', 'url' => '/certificates/save_giftpageVote/0',"indicator"=>"plsLoaderID",'loading'=>"Element.show('plsLoaderID')","complete"=>"Element.hide('plsLoaderID')",'escape'=>false), null,false);?> 
<?php } else { echo 'Thankyou.'; } ?></span>