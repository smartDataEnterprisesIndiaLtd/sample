<?php
$productpageVote = 'productpageVote_'.$product_id;
$productpageVoteSession = $this->Session->read($productpageVote);

App::import('Model','ProductVote');
$this->ProductVote = &new ProductVote;

$like_people = $this->ProductVote->find('count',array('conditions'=>array('ProductVote.product_id'=>$product_id,'ProductVote.user_vote'=>'1')));
?>
<span class="gray smalr-fnt"><?php echo $like_people;?> People found this page helpful. Did you? 
<?php 
if(empty($productpageVoteSession)){
?>
<?php echo $ajax->link('<strong>Yes</strong>','javascript::void(0)', array('update' => 'product_'.$product_id, 'url' => '/products/save_productpageVote/'.$product_id.'/1',"indicator"=>"plsLoaderID",'loading'=>"Element.show('plsLoaderID')","complete"=>"Element.hide('plsLoaderID')",'escape'=>false), null,false);?> | 

<?php echo $ajax->link('<strong>No</strong>','javascript::void(0)', array('update' => 'product_'.$product_id, 'url' => '/products/save_productpageVote/'.$product_id.'/0',"indicator"=>"plsLoaderID",'loading'=>"Element.show('plsLoaderID')","complete"=>"Element.hide('plsLoaderID')",'escape'=>false), null,false);?> 
<?php } else { echo 'Thank you.'; } ?></span>