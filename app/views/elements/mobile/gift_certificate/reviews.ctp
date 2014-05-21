<?php echo $javascript->link(array('jquery-1.3.2.min','lib/prototype'),false); 
$logg_user_id =0;
$logg_user_id = $this->Session->read('User.id');
?>
<style type="text/css">
.dimmer{
	position:absolute;
	left:45%;
	top:55%;
}
.cl-widget {
    clear: both;
    margin-top: 10px;
}
</style>
<!--Reviews Start-->
<div id="plsLoaderID" style="display:none" class="dimmer"><?php echo $html->image("loading.gif" ,array('alt'=>"Loading" ));?></div>
<ul class="reviews-sec">

	<?php
	$total_reviews = 0;
	App::import('Model','CertificateReview');
	$this->CertificateReview = &new CertificateReview;
	$all_reviews = $this->CertificateReview->find('list',array('conditions'=>array('CertificateReview.status = "1"'),'fields'=>array('CertificateReview.id','CertificateReview.review_value')));
	$total_reviews = count($all_reviews);
	$over_all_review_value = 0;
	if(!empty($all_reviews)){
		foreach($all_reviews as $review_value){
			$over_all_review_value = $over_all_review_value + $review_value;
		}
	}
	$this->CertificateReview->expects(array('User'));
	$latest_review = $this->CertificateReview->find('first',array('conditions'=>array('CertificateReview.status' => '1'),'fields'=>array('CertificateReview.created'),'order'=>array('CertificateReview.created DESC')));
	$latest_time = 0;
	if(!empty($latest_review)) {
		$latest_time = strtotime($latest_review['CertificateReview']['created']);
	}
	$pos_reviews = $this->CertificateReview->find('all',array('conditions'=>array('CertificateReview.review_type' => "2",'CertificateReview.status' => '1'),'fields'=>array('User.email','CertificateReview.id','CertificateReview.comments','CertificateReview.created'),'order'=>array('CertificateReview.created DESC')));
	$neg_reviews = $this->CertificateReview->find('all',array('conditions'=>array('CertificateReview.review_type' => "0",'CertificateReview.status' => '1'),'fields'=>array('User.email','CertificateReview.id','CertificateReview.comments','CertificateReview.created'),'order'=>array('CertificateReview.created DESC')));
	$neu_reviews = $this->CertificateReview->find('all',array('conditions'=>array('CertificateReview.review_type' => "1",'CertificateReview.status' => '1'),'fields'=>array('User.email','CertificateReview.id','CertificateReview.comments','CertificateReview.created'),'order'=>array('CertificateReview.id DESC')));
	$show_reviews ='';
	if(!empty($latest_time)) {
		if($latest_time == strtotime(@$pos_reviews[0]['CertificateReview']['created'])) {
			$show_reviews[0] = 'positive';
			if(!empty($neu_reviews) && !empty($neg_reviews)) {
				if(strtotime($neu_reviews[0]['CertificateReview']['created']) >= strtotime($neg_reviews[0]['CertificateReview']['created'])){
					$show_reviews[1] = 'neutral';
					$show_reviews[2] = 'negative';
				} else {
					$show_reviews[1] = 'negative';
					$show_reviews[2] = 'neutral';
				}
			} else if(!empty($neu_reviews) && empty($neg_reviews)) {
				$show_reviews[1] = 'neutral';
			} else if(empty($neu_reviews) && !empty($neg_reviews)) {
				$show_reviews[1] = 'negative';
			}
		} else if($latest_time == strtotime(@$neg_reviews[0]['CertificateReview']['created'])) {
			$show_reviews[0] = 'negative';
			if(!empty($neu_reviews) && !empty($pos_reviews)) {
				if(strtotime($pos_reviews[0]['CertificateReview']['created']) >= strtotime($neu_reviews[0]['CertificateReview']['created'])){
					$show_reviews[1] = 'positive';
					$show_reviews[2] = 'neutral';
				} else {
					$show_reviews[1] = 'neutral';
					$show_reviews[2] = 'positive';
				}
			} else if(!empty($neu_reviews) && empty($pos_reviews)) {
				$show_reviews[1] = 'neutral';
			} else if(empty($neu_reviews) && !empty($pos_reviews)) {
				$show_reviews[1] = 'positive';
			}
		} else if($latest_time == strtotime(@$neu_reviews[0]['CertificateReview']['created'])) {
			$show_reviews[0] = 'neutral';
			if(!empty($neg_reviews) && !empty($pos_reviews)){
				if(strtotime($pos_reviews[0]['CertificateReview']['created']) >= strtotime($neg_reviews[0]['CertificateReview']['created'])){
					$show_reviews[1] = 'positive';
					$show_reviews[2] = 'negative';
				} else {
					$show_reviews[1] = 'negative';
					$show_reviews[2] = 'positive';
				}
			} else if(!empty($neg_reviews) && empty($pos_reviews)) {
				$show_reviews[1] = 'negative';
			} else if(empty($neg_reviews) && !empty($pos_reviews)) {
				$show_reviews[1] = 'positive';
			}
		}
	}
	$over_all = 'Neutral';
	$total_count_selected = 0;
	$class="green-color";
	$ovelall_image = 'neutral-icon.png';
	$positive_percentege = 0;
	$neutral_percentege = 0;
	$negative_percentege = 0;
	
	if($over_all_review_value > 0) {
		$over_all = 'Positive';
		$class="green-color";
		$ovelall_image = 'positive-icon.png';
	} else if($over_all_review_value < 0) {
		$over_all = 'Negative';
		$class="red-color";
		$ovelall_image = 'negative-icon.png';
	} else if($over_all_review_value == 0) {
		$over_all = 'Neutral';
		$class="gray";
		$ovelall_image = 'neutral-icon.png';
	} ?>

<li class="revwhead orange-col-head boldr">Reviews
		<?php 
		
		echo $html->link('Write a review','javascript:void(0);',array('id'=>'write_review','onclick'=>'addReveiw()','escape'=>false,'class'=>'')); ?>
</li>
<li>
	<?php if(!empty($neg_reviews) || !empty($pos_reviews) || !empty($latest_neu_review)) { ?>
	<strong>Overall</strong> 
		<span class="<?php echo $class;?>"><?php echo $html->image($ovelall_image,array('alt'=>"" ,'class'=>'neutrlicn', 'width'=>'17', 'height'=>'17'));?>
		<span class="boldr"><?php echo $over_all;?></span>
	</span>
		<?php $class_paddingLeft = 'padding-left';
	} else {
		$class_paddingLeft = ''; 
	}
	
	?>
</li>
</ul>

<?php 
if(!empty($show_reviews[0]) ) {
	if($show_reviews[0] == 'positive') {
		if(!empty($pos_reviews)) { ?>
			<ul class="reviews-sec">
				<li>
					<span class="green-color min-width">
						<?php echo $html->image("positive-icon.png" ,array('width'=>"18",'height'=>"19", 'alt'=>"" ,'class'=>'img'));?> 
					<strong>Positive</strong></span>
					<span class="font11 gray">
						<?php $user_pos_email = '';
						if(!empty($pos_reviews[0]['User']['email'])) {
							$user_po_ex = explode('@',$pos_reviews[0]['User']['email']);
							$user_pos_email = $user_po_ex[0];
						} echo $user_pos_email; ?> | 
						<?php echo $format->date_format($pos_reviews[0]['CertificateReview']['created']); ?>
					</span>
				</li>
				<li>
					<?php foreach($pos_reviews as $pos_review) {
						if($pos_review['CertificateReview']['comments']) { ?>
							<p class="cl-widget">&quot;<?php echo $pos_review['CertificateReview']['comments']; ?>&quot;</p>
	
							<ul class="review-status">
								<span id="vote_pos_<?php echo $pos_review['CertificateReview']['id'];?>">
								<?php
								$rev_gift_pos_id = $pos_review['CertificateReview']['id'];
								$this->set('rev_gift_pos_id',$rev_gift_pos_id);
								echo $this->element('/mobile/gift_certificate/vote_pos');?>
								</span>
							
							</ul>
					<?php   }
					
					}?>
				</li>
			</ul>
			
		<?php }} else if($show_reviews[0] == 'negative') {
			if( !empty($neg_reviews) ) { ?>
			<ul class="reviews-sec">
				<li>
					<span class="red-color min-width">
						<?php echo $html->image("negative-icon.png" ,array('width'=>"18",'height'=>"19", 'alt'=>"" ,'class'=>'img'));?> 
					<strong>Negative</strong></span>
					<span class="font11 gray">
						<?php $user_email = '';
						if( !empty($neg_reviews[0]['User']['email']) ){
							$user_ex = explode('@',$neg_reviews[0]['User']['email']);
							$user_email = $user_ex[0];
						} echo $user_email; ?> | 
						<?php echo $format->date_format($neg_reviews[0]['CertificateReview']['created']); ?>
					</span>
				</li>
				<li>
					<?php foreach($neg_reviews as $neg_review) {
						if($neg_review['CertificateReview']['comments']) { ?>
							<p class="cl-widget">&quot;<?php echo $neg_review['CertificateReview']['comments']; ?>&quot;</p>
	
							<ul class="review-status">
								<span id="vote_neg_<?php echo $neg_review['CertificateReview']['id'];?>">
								<?php
								$rev_gift_neg_id = $neg_review['CertificateReview']['id'];
								$this->set('rev_gift_neg_id',$rev_gift_neg_id);
								echo $this->element('/mobile/gift_certificate/vote_neg');?>
								</span>
							
							</ul>
					<?php   }
					
					}?>
				</li>
			</ul>
				
				
		<?php }
		} else {
			if( !empty($neu_reviews) ) { ?>
			<ul class="reviews-sec">
				<li>
					<span class="gray min-width">
						<?php echo $html->image("neutral-icon.png",array('width'=>"17",'height'=>"17", 'alt'=>"" ,'class'=>'img pad-rt'));?> 
						<strong>Neutral</strong>
					</span> 
					<span class="smalr-fnt gray">
						<?php $user_neu_email = '';
							if(!empty($neu_reviews[0]['User']['email'])){
								$user_neu_ex = explode('@',$neu_reviews[0]['User']['email']);
								$user_neu_email = $user_neu_ex[0];
							} echo $user_neu_email; ?> | 
							<?php echo $format->date_format($neu_reviews[0]['CertificateReview']['created']); ?>
					</span>
				</li>
				
				<li>
					<?php
					foreach($neu_reviews as $neu_review) {
						if( !empty($neu_review['CertificateReview']['comments']) ) { ?>
						 <p class="cl-widget">&quot;<?php echo $neu_review['CertificateReview']['comments']; ?>&quot;</p>
	
							<ul class="review-status">
								<span id="vote_neu_<?php echo $neu_review['CertificateReview']['id'];?>">
								<?php
								$rev_gift_neu_id = $neu_review['CertificateReview']['id'];
								$this->set('rev_gift_neu_id',$rev_gift_neu_id);
								echo $this->element('/mobile/gift_certificate/vote_neu');?>
								</span>
							
							</ul>
					<?php   }
					
					}?>
				</li>
			</ul>
			
			<?php }
		}
	}
	//Part 1 End
			
		
			if(!empty($show_reviews[1])){
			if($show_reviews[1] == 'positive'){
				if(!empty($pos_reviews)) { ?>
				
				<ul class="reviews-sec">
				<li>
					<span class="green-color min-width">
						<?php echo $html->image("positive-icon.png" ,array('width'=>"18",'height'=>"19", 'alt'=>"" ,'class'=>'img'));?> 
					<strong>Positive</strong></span>
					<span class="font11 gray">
						<?php $user_pos_email = '';
						if(!empty($pos_reviews[0]['User']['email'])) {
							$user_po_ex = explode('@',$pos_reviews[0]['User']['email']);
							$user_pos_email = $user_po_ex[0];
						} echo $user_pos_email; ?> | 
						<?php echo $format->date_format($pos_reviews[0]['CertificateReview']['created']); ?>
					</span>
				</li>
				<li>
					<?php foreach($pos_reviews as $pos_review) {
						if($pos_review['CertificateReview']['comments']) { ?>
							<p class="cl-widget">&quot;<?php echo $pos_review['CertificateReview']['comments']; ?>&quot;</p>
	
							<ul class="review-status">
								<span id="vote_pos_<?php echo $pos_review['CertificateReview']['id'];?>">
								<?php
								$rev_gift_pos_id = $pos_review['CertificateReview']['id'];
								$this->set('rev_gift_pos_id',$rev_gift_pos_id);
								echo $this->element('/mobile/gift_certificate/vote_pos');?>
								</span>
							
							</ul>
					<?php   }
					
					}?>
				</li>
				</ul>
			
			<?php }
		} else if($show_reviews[1] == 'negative'){
			if(!empty($neg_reviews)) { ?>
				<ul class="reviews-sec">
				<li>
					<span class="red-color min-width">
						<?php echo $html->image("negative-icon.png" ,array('width'=>"18",'height'=>"19", 'alt'=>"" ,'class'=>'img'));?> 
					<strong>Negative</strong></span>
					<span class="font11 gray">
						<?php $user_email = '';
						if( !empty($neg_reviews[0]['User']['email']) ){
							$user_ex = explode('@',$neg_reviews[0]['User']['email']);
							$user_email = $user_ex[0];
						} echo $user_email; ?> | 
						<?php echo $format->date_format($neg_reviews[0]['CertificateReview']['created']); ?>
					</span>
				</li>
				<li>
					<?php foreach($neg_reviews as $neg_review) {
						if($neg_review['CertificateReview']['comments']) { ?>
							<p class="cl-widget">&quot;<?php echo $neg_review['CertificateReview']['comments']; ?>&quot;</p>
	
							<ul class="review-status">
								<span id="vote_neg_<?php echo $neg_review['CertificateReview']['id'];?>">
								<?php
								$rev_gift_neg_id = $neg_review['CertificateReview']['id'];
								$this->set('rev_gift_neg_id',$rev_gift_neg_id);
								echo $this->element('/mobile/gift_certificate/vote_neg');?>
								</span>
							
							</ul>
					<?php   }
					
					}?>
				</li>
			</ul>
			<?php }
			} else{
				if(!empty($neu_reviews)) { ?>
				<ul class="reviews-sec">
					<li>
					<span class="gray min-width">
						<?php echo $html->image("neutral-icon.png",array('width'=>"17",'height'=>"17", 'alt'=>"" ,'class'=>'img pad-rt'));?> 
						<strong>Neutral</strong>
					</span>
					<span class="font11 gray">
						<?php $user_neu_email = '';
						if(!empty($neu_reviews[0]['User']['email'])){
							$user_neu_ex = explode('@',$neu_reviews[0]['User']['email']);
							$user_neu_email = $user_neu_ex[0];
						} echo $user_neu_email; ?> | 
						<?php echo $format->date_format($neu_reviews[0]['CertificateReview']['created']);
						
						?>
					</span>
					</li>
					
					<li>
					<?php
					foreach($neu_reviews as $neu_review) {
					if(!empty($neu_review['CertificateReview']['comments'])){ ?>
						<p class="cl-widget">&quot;<?php echo $neu_review['CertificateReview']['comments']; ?>&quot;</p>
						
							<ul class="review-status">
							
							<span id="vote_neu_<?php echo $neu_review['CertificateReview']['id'];?>">
								<?php $rev_gift_neu_id = $neu_review['CertificateReview']['id'];
								$this->set('rev_gift_neu_id',$rev_gift_neu_id);
								echo $this->element('/mobile/gift_certificate/vote_neu');?> 
							</span>
								
							</ul>
					<?php }
					}?>
						</li>
				<?php }
			}
		}
		//End of part part 2
		?>
				
				
				<?php 
				if(!empty($show_reviews[2])){
					if($show_reviews[2] == 'positive'){
						if(!empty($pos_reviews)) { ?>
						
						
				<ul class="reviews-sec">
				<li>
					<span class="green-color min-width">
						<?php echo $html->image("positive-icon.png" ,array('width'=>"18",'height'=>"19", 'alt'=>"" ,'class'=>'img'));?> 
					<strong>Positive</strong></span>
					<span class="font11 gray">
						<?php $user_pos_email = '';
						if(!empty($pos_reviews[0]['User']['email'])) {
							$user_po_ex = explode('@',$pos_reviews[0]['User']['email']);
							$user_pos_email = $user_po_ex[0];
						} echo $user_pos_email; ?> | 
						<?php echo $format->date_format($pos_reviews[0]['CertificateReview']['created']); ?>
					</span>
				</li>
				<li>
					<?php foreach($pos_reviews as $pos_review) {
						if($pos_review['CertificateReview']['comments']) { ?>
							<p class="cl-widget">&quot;<?php echo $pos_review['CertificateReview']['comments']; ?>&quot;</p>
	
							<ul class="review-status">
								<span id="vote_pos_<?php echo $pos_review['CertificateReview']['id'];?>">
								<?php
								$rev_gift_pos_id = $pos_review['CertificateReview']['id'];
								$this->set('rev_gift_pos_id',$rev_gift_pos_id);
								echo $this->element('/mobile/gift_certificate/vote_pos');?>
								</span>
							
							</ul>
					<?php   }
					
					}?>
				</li>
			</ul>
			
		<?php }
		} else if($show_reviews[2] == 'negative'){
			if(!empty($neg_reviews)) { ?>
			<ul class="reviews-sec">
				<li>
					<span class="drkred min-width">
						<?php echo $html->image("negative-icon.png",array('width'=>"19",'height'=>"18", 'alt'=>"" ,'class'=>'img'));?> 
						<strong>Negetive</strong>
					</span>
				</li>
				<li>
					<span class="smalr-fnt gray">
					<?php $user_email = '';
					if(!empty($neg_reviews[0]['User']['email'])){
						$user_ex = explode('@',$neg_reviews[0]['User']['email']);
						$user_email = $user_ex[0];
					} echo $user_email; ?> | 
					<?php echo $format->date_format($neg_reviews[0]['CertificateReview']['created']); ?>
				</span>
				<?php foreach($neg_reviews as $neg_review) {
					if( $neg_review['CertificateReview']['comments']) { ?>
					<p class="cl-widget">&quot;<?php echo $neg_review['CertificateReview']['comments']; ?>&quot;</p>
					
						<ul class="review-status">
						
							<span id="vote_<?php echo $neg_review['CertificateReview']['id']; ?>">
							
							<?php $rev_gift_neg_id = $neg_review['CertificateReview']['id'];
								$this->set('rev_gift_neg_id',$rev_gift_neg_id);
								echo $this->element('/mobile/gift_certificate/vote_neg');?>
							</span>
							
						</ul>	

					<?php }
				}?>
			</li>
			<?php }
		} else{
			if(!empty($neu_reviews)) { ?>
				<ul class="reviews-sec">
				<li>
					<span class="gray min-width">
						<?php echo $html->image("neutral-icon.png",array('width'=>"17",'height'=>"17", 'alt'=>"" ,'class'=>'img pad-rt'));?> 
						<strong>Neutral</strong>
					</span> 
					<span class="smalr-fnt gray">
						<?php $user_neu_email = '';
							if(!empty($neu_reviews[0]['User']['email'])){
								$user_neu_ex = explode('@',$neu_reviews[0]['User']['email']);
								$user_neu_email = $user_neu_ex[0];
							} echo $user_neu_email; ?> | 
							<?php echo $format->date_format($neu_reviews[0]['CertificateReview']['created']); ?>
					</span>
				</li>
				
				<li>
					<?php
					foreach($neu_reviews as $neu_review) {
						if( !empty($neu_review['CertificateReview']['comments']) ) { ?>
						 <p class="cl-widget">&quot;<?php echo $neu_review['CertificateReview']['comments']; ?>&quot;</p>
	
							<ul class="review-status">
								<span id="vote_neu_<?php echo $neu_review['CertificateReview']['id'];?>">
								<?php
								$rev_gift_neu_id = $neu_review['CertificateReview']['id'];
								$this->set('rev_gift_neu_id',$rev_gift_neu_id);
								echo $this->element('/mobile/gift_certificate/vote_neu');?>
								</span>
							
							</ul>
					<?php   }
					
					}?>
				</li>
			</ul>
						<?php }




		}
	}?>
<!---->
<!--Reviews Closed-->
<script defer="defer"  type="text/javascript">
var SITE_URL = "<?php echo SITE_URL; ?>";
var Check_User = "<?php echo $logg_user_id;?>"
 // function to like to dislike in giftcertificate
function addReveiw(){
	if(Check_User){
	var postUrl = SITE_URL+'/certificates/add_review';
	}else{
	var postUrl = SITE_URL+'users/sign_in/tab3';
	}
	jQuery('#plsLoaderID').show();
	jQuery.ajax({
		url: postUrl,
		success: function(msg){
		/** Update the div**/
		jQuery('#tab3').html(msg);
		jQuery('#plsLoaderID').hide();
	}
	});
}
</script>