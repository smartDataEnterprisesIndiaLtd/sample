<?php
if(!empty($logg_user_id)) {
		$fancy_report_width = 362;
	} else{
		$fancy_report_width = 560;
	}
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
<span class="gray smalr-fnt"><?php echo $yes_votes; ?> People found this page helpful. Did you? 
	<?php 
	if(empty($session_giftansID)){
	?>
	<?php echo $ajax->link('<strong>Yes</strong>','javascript::void(0)', array('update' => 'voteans_'.$ans_id, 'url' => '/certificates/save_ansvote/'.$ans_id.'/1',"indicator"=>"plsLoaderID",'loading'=>"Element.show('plsLoaderID')","complete"=>"Element.hide('plsLoaderID')",'escape'=>false), null,false);?> | 

	<?php echo $ajax->link('<strong>No</strong>','javascript::void(0)', array('update' => 'voteans_'.$ans_id, 'url' => '/certificates/save_ansvote/'.$ans_id.'/0',"indicator"=>"plsLoaderID",'loading'=>"Element.show('plsLoaderID')","complete"=>"Element.hide('plsLoaderID')",'escape'=>false), null,false);?> 
	<?php } else { echo 'Thank you.'; } ?>
	<?php
		if(!empty($logg_user_id))
			$link_ans = '/certificates/report_answer/'.$ans_id;
		else
			$link_ans = '/users/sign_in/';
	echo $html->link('Report This','javascript:void(0)',array('escape'=>false,'class'=>'margn-left underline-link','onClick'=>"display()"));?>
	
</span>
<script>
	function display()
	{
		jQuery.fancybox({
			'autoScale' : true,
			'titlePosition': 'inside',
			'centerOnScroll': true,
			'transitionIn' : 'none',
			'transitionOut' : 'none',
			'width' : <?php echo $fancy_report_width;?>,
			//'height' : 500,
			'padding':0,'overlayColor':'#000000',
			'overlayOpacity':0.5,
			'opacity':	true,
			'transitionIn' : 'fade',
			'transitionOut' : 'fade',
			'hideOnOverlayClick':false,
			'type' : 'iframe',
			'href': '<?php echo $link_ans; ?>',
			'autoDimensions': false,
			'onComplete' : function() {
			jQuery('#fancybox-frame').load(function() { // wait for frame to load and then gets it's height
			  jQuery('#fancybox-content').height(jQuery(this).contents().find('body').height());
			});
			}
		});
		
	}
	
</script>