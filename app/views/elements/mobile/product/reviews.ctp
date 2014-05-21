<?php //echo $javascript->link(array('jquery-1.3.2.min','lib/prototype'),false); ?>
<script defer="defer" type="text/javascript" src="/js/lib/prototype.js"></script>
<script defer="defer" type="text/javascript" src="/js/jquery-1.3.2.min.js"></script>

<style type="text/css">
	.dimmer{
		position:absolute;
		left:45%;
		top:55%;
	}
</style>
<?php

$logg_user_id =0;
$logg_user_id = $this->Session->read('User.id');
?>

<!--Reviews Start-->
<div id="plsLoaderID" style="display:none" class="dimmer"><?php echo $html->image("loading.gif" ,array('alt'=>"Loading" ));?></div>
				<?php
				$product_id = $product_details['Product']['id'];
				$total_reviews = 0;
				
				App::import('Model','Review');
				$this->Review = &new Review;
				
				$all_reviews = $this->Review->find('list',array('conditions'=>array('Review.product_id = '.$product_id.' AND Review.status = "1"'),'fields'=>array('Review.id','Review.review_value')));
				
				$total_reviews = count($all_reviews);
				$over_all_review_value = 0;
				if(!empty($all_reviews)){
					foreach($all_reviews as $review_value){
						$over_all_review_value = $over_all_review_value + $review_value;
					}
				}
				
				$this->Review->expects(array('User'));
				
				$latest_review = $this->Review->find('first',array('conditions'=>array('Review.status' => '1','Review.product_id' => $product_id),'fields'=>array('Review.created'),'order'=>array('Review.created DESC')));
				
				$latest_time = 0;
				if(!empty($latest_review)) {
					$latest_time = strtotime($latest_review['Review']['created']);
				}
				
				$pos_reviews = $this->Review->find('all',array('conditions'=>array('Review.review_type' => "2",'Review.status' => '1','Review.product_id' => $product_id),'fields'=>array('User.email','Review.id','Review.comments','Review.created'),'order'=>array('Review.created DESC')));
				
				$neg_reviews = $this->Review->find('all',array('conditions'=>array('Review.review_type' => "0",'Review.status' => '1','Review.product_id' => $product_id),'fields'=>array('User.email','Review.id','Review.comments','Review.created'),'order'=>array('Review.created DESC')));
				
				$neu_reviews = $this->Review->find('all',array('conditions'=>array('Review.review_type' => "1",'Review.status' => '1','Review.product_id' => $product_id),'fields'=>array('User.email','Review.id','Review.comments','Review.created'),'order'=>array('Review.id DESC')));
				
				$show_reviews ='';
				
				if(!empty($latest_time)){
					if($latest_time == strtotime(@$pos_reviews[0]['Review']['created'])){
						$show_reviews[0] = 'positive';
						if(!empty($neu_reviews) && !empty($neg_reviews)){
							if(strtotime($neu_reviews[0]['Review']['created']) >= strtotime($neg_reviews[0]['Review']['created'])){
								$show_reviews[1] = 'neutral';
								$show_reviews[2] = 'negative';
							} else {
								$show_reviews[1] = 'negative';
								$show_reviews[2] = 'neutral';
							}
						} else if(!empty($neu_reviews) && empty($neg_reviews)){
							$show_reviews[1] = 'neutral';
						} else if(empty($neu_reviews) && !empty($neg_reviews)){
							$show_reviews[1] = 'negative';
						}
					} else if($latest_time == strtotime(@$neg_reviews[0]['Review']['created'])){
						$show_reviews[0] = 'negative';
						if(!empty($neu_reviews) && !empty($pos_reviews)){
							if(strtotime($pos_reviews[0]['Review']['created']) >= strtotime($neu_reviews[0]['Review']['created'])){
								$show_reviews[1] = 'positive';
								$show_reviews[2] = 'neutral';
							} else {
								$show_reviews[1] = 'neutral';
								$show_reviews[2] = 'positive';
							}
						} else if(!empty($neu_reviews) && empty($pos_reviews)){
							$show_reviews[1] = 'neutral';
						} else if(empty($neu_reviews) && !empty($pos_reviews)){
							$show_reviews[1] = 'positive';
						}
					} else if($latest_time == strtotime(@$neu_reviews[0]['Review']['created'])){
						$show_reviews[0] = 'neutral';
						
						if(!empty($neg_reviews) && !empty($pos_reviews)){
							if(strtotime($pos_reviews[0]['Review']['created']) >= strtotime($neg_reviews[0]['Review']['created'])){
								$show_reviews[1] = 'positive';
								$show_reviews[2] = 'negative';
							} else {
								$show_reviews[1] = 'negative';
								$show_reviews[2] = 'positive';
							}
						} else if(!empty($neg_reviews) && empty($pos_reviews)){
							$show_reviews[1] = 'negative';
						} else if(empty($neg_reviews) && !empty($pos_reviews)){
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

				if($over_all_review_value > 0){
					$over_all = 'Positive';
					$class="green-color";
					$ovelall_image = 'positive-icon.png';
				} else if($over_all_review_value < 0){
					$over_all = 'Negative';
					$class="red-color";
					$ovelall_image = 'negative-icon.png';
				} else if($over_all_review_value == 0){
					$over_all = 'Neutral';
					$class="gray";
					$ovelall_image = 'neutral-icon.png';
				} ?>
				<div>
				<ul class="reviews-sec">
				<li class="revwhead orange-col-head boldr">
				Reviews
				<?php echo $html->link('Write a review','javascript:void(0)',array('id'=>'write_review','escape'=>false,'class'=>'' ,  'onclick'=>'add_review('.$product_details['Product']['id'].')')); ?></li>
				<li>
					<?php if(!empty($neg_reviews) || !empty($pos_reviews) || !empty($latest_neu_review)) { ?>

						 <strong>Overall</strong> <span class="<?php echo $class;?>"><?php echo $html->image($ovelall_image,array('alt'=>"" ,'class'=>'img img-mrg'));?><strong><?php echo $over_all;?></strong></span>

						<?php $class_paddingLeft = 'padding-left';
					} else {
						$class_paddingLeft = ''; 
					}?>
					
				</li>
				
				<?php
				if(!empty($show_reviews[0])){
					if($show_reviews[0] == 'positive'){
						if(!empty($pos_reviews)) { ?>
						<li>
							<ul class = "review-status" >
								<li><span class="green-color min-width">
									<?php echo $html->image("positive-icon.png" ,array('width'=>"18",'height'=>"19", 'alt'=>"" ,'class'=>'img'));?> 
									<strong>Positive</strong>
								</span>
								<span class="smalr-fnt gray">
									<?php $user_pos_email = '';
									if(!empty($pos_reviews[0]['User']['email'])){
										$user_po_ex = explode('@',$pos_reviews[0]['User']['email']);
										$user_pos_email = $user_po_ex[0];
									} echo $user_pos_email; ?> | 
									<?php echo $format->date_format($pos_reviews[0]['Review']['created']); ?></span>
								</li>
							</ul>
							<?php foreach($pos_reviews as $pos_review) {
								if($pos_review['Review']['comments']) { ?>
								<p class="cl-widget" style = "padding-top:10px;">
								&quot;
									<?php echo $pos_review['Review']['comments']; ?>
								&quot;
								</p>
								
								
								<ul class="review-status">
								<span id="vote_pos_<?php echo $pos_review['Review']['id'];?>">
								<?php
								$rev_pos_id = $pos_review['Review']['id'];
								$this->set('rev_pos_id',$rev_pos_id);
								echo $this->element('/mobile/product/vote_pos');?>
								</span>
								
								</ul>
								<?php }
							}?>
						</li>
						<?php }
					} else if($show_reviews[0] == 'negative'){
						if(!empty($neg_reviews)) { ?>
						<li>
							<ul class = "review-status" >
								<li>
									<span class="red-color min-width">
									<?php echo $html->image("negative-icon.png",array('width'=>"19",'height'=>"18", 'alt'=>"" ,'class'=>'img'));?> 
										<strong>Negative</strong>
								</span></li>
								<li><span class="smalr-fnt gray">
									<?php $user_email = '';
									if(!empty($neg_reviews[0]['User']['email'])){
										$user_ex = explode('@',$neg_reviews[0]['User']['email']);
										$user_email = $user_ex[0];
									} echo $user_email; ?> | 
									<?php echo $format->date_format($neg_reviews[0]['Review']['created']); ?>
								</span></li>
							</ul>
							<?php foreach($neg_reviews as $neg_review) {
								if( $neg_review['Review']['comments']) { ?>
								
								
								
								<p class="cl-widget" style = "padding-top:10px;">
								&quot;
									<?php echo $neg_review['Review']['comments']; ?>
								&quot;
								</p>
								<ul class="review-status">
								<span id="vote_<?php echo $neg_review['Review']['id'];?>">
								<?php
								$rev_neg_id = $neg_review['Review']['id'];
								$this->set('rev_neg_id',$rev_neg_id);
								echo $this->element('/mobile/product/vote_neg');?>
								</span>
								</ul>
								<?php }
							}?>
						</li>
						<?php }
					} else {
						if(!empty($neu_reviews)) { ?>
						<li>
							<ul class = "review-status" >
								<li>
									<span class="gray min-width">
									<?php echo $html->image("neutral-icon.png",array('width'=>"17",'height'=>"17", 'alt'=>"" ,'class'=>'img pad-rt'));?> 
									<strong>Neutral</strong>
								</span></li>
								<li><span class="smalr-fnt gray">
									<?php $user_neu_email = '';
									if(!empty($neu_reviews[0]['User']['email'])){
										$user_neu_ex = explode('@',$neu_reviews[0]['User']['email']);
										$user_neu_email = $user_neu_ex[0];
									} echo $user_neu_email; ?> | 
									<?php echo $format->date_format($neu_reviews[0]['Review']['created']); ?>
								</span></li>
							</ul>
							
							<?php
							foreach($neu_reviews as $neu_review) {
								if(!empty($neu_review['Review']['comments'])){ ?>
									
								<p class="cl-widget" style = "padding-top:10px;">
								&quot;
									<?php echo $neu_review['Review']['comments']; ?>
								&quot;
								</p>
								<ul class="review-status">
								<span id="vote_neu_<?php echo $neu_review['Review']['id'];?>">
								<?php
								$rev_neu_id = $neu_review['Review']['id'];
								$this->set('rev_neu_id',$rev_neu_id);
								echo $this->element('/mobile/product/vote_neu');?>
								</span>
								</ul>
								<?php } 
							}?>
						</li>
						<?php }
					}
				}	
				if(!empty($show_reviews[1])){
					if($show_reviews[1] == 'positive'){
						if(!empty($pos_reviews)) { ?>
						<li>
							<ul class = "review-status" >
								<li>
									<span class="green-color min-width">
									<?php echo $html->image("positive-icon.png" ,array('width'=>"18",'height'=>"19", 'alt'=>"" ,'class'=>'img'));?> 
									<strong>Positive</strong>
								</span></li>
								<li><span class="smalr-fnt gray">
									<?php $user_pos_email = '';
									if(!empty($pos_reviews[0]['User']['email'])){
										$user_po_ex = explode('@',$pos_reviews[0]['User']['email']);
										$user_pos_email = $user_po_ex[0];
									} echo $user_pos_email; ?> | 
									<?php echo $format->date_format($pos_reviews[0]['Review']['created']); ?>
								</span></li>
							</ul>
							<?php foreach($pos_reviews as $pos_review) {
								if($pos_review['Review']['comments']) {?>
								
								
								<p class="cl-widget" style = "padding-top:10px;">
								&quot;
									<?php echo $pos_review['Review']['comments']; ?>
								&quot;
								</p>
								
								
								<ul class="review-status">
								<span id="vote_pos_<?php echo $pos_review['Review']['id'];?>">
								<?php
								$rev_pos_id = $pos_review['Review']['id'];
								$this->set('rev_pos_id',$rev_pos_id);
								echo $this->element('/mobile/product/vote_pos');?>
								</span>
							
								</ul>
								
								<!--<ul class="review-status" style="padding-bottom:5px;">
									<span id="vote_pos_<?php //echo $pos_review['Review']['id'];?>">
										<?php //$rev_pos_id = $pos_review['Review']['id'];
										//$this->set('rev_pos_id',$rev_pos_id);?>
										<?php  //echo $this->element('mobile/product/vote_pos');?> 
									</span>-->
									
									<!--<li>
										<?php //echo '&nbsp;'.$html->link($html->image("flag.png",array('width'=>"31",'height'=>"25", 'alt'=>"" ,'class'=>'img pad-rt')),"#",array('escape'=>false,'class'=>''));?></li>
									<li>
										<?php /*if(!empty($logg_user_id))
											$link_report = '/reviews/report_review/'.$rev_pos_id;
										else
											$link_report = '/users/sign_in/';
										echo $html->link('Report this',$link_report,array('escape'=>false,'class'=>'underline-link report-this thisreport'));*/?>
									</li>
								</ul>-->
								<?php }
							}?>
						</li>
						<?php }
					} else if($show_reviews[1] == 'negative'){
						if(!empty($neg_reviews)) { ?>
						<li>
							<ul class = "review-status" >
								<li>
									<span class="red-color min-width">
									<?php echo $html->image("negative-icon.png",array('width'=>"19",'height'=>"18", 'alt'=>"" ,'class'=>'img'));?> 
								<strong>Negative</strong>
								</span></li>
								<li><span class="smalr-fnt gray">
									<?php $user_email = '';
									if(!empty($neg_reviews[0]['User']['email'])){
										$user_ex = explode('@',$neg_reviews[0]['User']['email']);
										$user_email = $user_ex[0];
									} echo $user_email; ?> |
									<?php echo $format->date_format($neg_reviews[0]['Review']['created']); ?>
								</span><li>
							</ul>
							
							<?php foreach($neg_reviews as $neg_review) {
								if( $neg_review['Review']['comments']) { ?>
								<p class="cl-widget" style = "padding-top:10px;">
								&quot;
									<?php echo $neg_review['Review']['comments']; ?>
								&quot;
								</p>
								
								
								<ul class="review-status">
								<span id="vote_neu_<?php echo $neg_review['Review']['id'];?>">
								<?php
								$rev_neg_id = $neg_review['Review']['id'];
								$this->set('rev_neu_id',$rev_neg_id);
								echo $this->element('/mobile/product/vote_neu');?>
								</span>
							
								</ul>
								
								<?php }?>
							<?php }?>
						</li>
						<?php }
					} else{
						if(!empty($neu_reviews)) { ?>
						<li>
							<ul class = "review-status" >
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
									<?php echo $format->date_format($neu_reviews[0]['Review']['created']);
									
									?>
								</span></li>
							</ul>
							<?php
							foreach($neu_reviews as $neu_review) {
								if(!empty($neu_review['Review']['comments'])){ ?>
								<p class="cl-widget" style = "padding-top:10px;">
								&quot;
									<?php echo $neu_review['Review']['comments']; ?>
								&quot;
								</p>
								
								
								<ul class="review-status">
								<span id="vote_neu_<?php echo $neu_review['Review']['id'];?>">
								<?php
								$rev_neu_id = $neu_review['Review']['id'];
								$this->set('rev_neu_id',$rev_neu_id);
								echo $this->element('/mobile/product/vote_neu');?>
								</span>
								</ul>
							<?php }
							}?>
						</li>
						<?php }
					}
				}?>
				<?php 
				if(!empty($show_reviews[2])){
					if($show_reviews[2] == 'positive'){
						if(!empty($pos_reviews)) { ?>
						<li>
							<ul class = "review-status" >
								<li>
									<span class="green-color min-width">
									<?php echo $html->image("positive-icon.png" ,array('width'=>"18",'height'=>"19", 'alt'=>"" ,'class'=>'img'));?> 
									<strong>Positive</strong>
								</span></li>
								<li><span class="smalr-fnt gray">
								<?php $user_pos_email = '';
								if(!empty($pos_reviews[0]['User']['email'])){
									$user_po_ex = explode('@',$pos_reviews[0]['User']['email']);
									$user_pos_email = $user_po_ex[0];
								} echo $user_pos_email; ?> | 
								<?php echo $format->date_format($pos_reviews[0]['Review']['created']); ?>
								</span></li>
							</ul>
						<?php foreach($pos_reviews as $pos_review) {
							if($pos_review['Review']['comments']) {?>
							<p class="cl-widget" style = "padding-top:10px;">
								&quot;
									<?php echo $pos_review['Review']['comments']; ?>
								&quot;
								</p>
								
								
								<ul class="review-status">
								<span id="vote_pos_<?php echo $pos_review['Review']['id'];?>">
								<?php
								$rev_pos_id = $pos_review['Review']['id'];
								$this->set('rev_pos_id',$rev_pos_id);
								echo $this->element('/mobile/product/vote_pos');?>
								</span>
							
								</ul>
							<?php }
						}?>
						</li>
					<?php }
					} else if($show_reviews[2] == 'negative'){
						if(!empty($neg_reviews)) { ?>
						<li>
							<ul class = "review-status" >
								<li>
									<span class="red-color min-width">
									<?php echo $html->image("negative-icon.png",array('width'=>"19",'height'=>"18", 'alt'=>"" ,'class'=>'img'));?> 
									<strong>Negative</strong>
								</span>
                <span class="smalr-fnt gray">
									<?php $user_email = '';
									if(!empty($neg_reviews[0]['User']['email'])){
										$user_ex = explode('@',$neg_reviews[0]['User']['email']);
										$user_email = $user_ex[0];
									} echo $user_email; ?> | 
									<?php echo $format->date_format($neg_reviews[0]['Review']['created']); ?>
								</span></li>
							</ul>
							<?php foreach($neg_reviews as $neg_review) {
								if( $neg_review['Review']['comments']) { ?>
								
								<p class="cl-widget" style = "padding-top:10px;">
								&quot;
									<?php echo $neu_review['Review']['comments']; ?>
								&quot;
								</p>
								
								
								<ul class="review-status">
								<span id="vote_neu_<?php echo $neu_review['Review']['id'];?>">
								<?php
								$rev_neu_id = $neu_review['Review']['id'];
								$this->set('rev_neu_id',$rev_neu_id);
								echo $this->element('/mobile/product/vote_neu');?>
								</span>
								</ul>
								
								<?php }
							}?>
						</li>
						<?php }
					} else{
						if(!empty($neu_reviews)) { ?>
						<li>
							<ul class = "review-status" >
								<li>
									<span class="gray min-width">
									<?php echo $html->image("neutral-icon.png",array('width'=>"17",'height'=>"17", 'alt'=>"" ,'class'=>'img pad-rt'));?> 
									<strong>Neutral</strong>
								</span></li>
								<li><span class="smalr-fnt gray">
									<?php $user_neu_email = '';
									if(!empty($neu_reviews[0]['User']['email'])){
										$user_neu_ex = explode('@',$neu_reviews[0]['User']['email']);
										$user_neu_email = $user_neu_ex[0];
									} echo $user_neu_email; ?> | 
									<?php echo $format->date_format($neu_reviews[0]['Review']['created']); ?>
								</span></li>
							</ul>
							<?php
							foreach($neu_reviews as $neu_review) {
								if(!empty($neu_review['Review']['comments'])) { ?>
									<p class="cl-widget" style = "padding-top:10px;">
								&quot;
									<?php echo $neu_review['Review']['comments']; ?>
								&quot;
								</p>
								
								
								<ul class="review-status">
								<span id="vote_neu_<?php echo $neu_review['Review']['id'];?>">
								<?php
								$rev_neu_id = $neu_review['Review']['id'];
								$this->set('rev_neu_id',$rev_neu_id);
								echo $this->element('/mobile/product/vote_neu');?>
								</span>
							
								</ul>
								<?php }
							}?>
						</li>
						<?php }
					}
				}?>
			</div>
				
<script defer="defer" type="text/javascript">
var SITE_URL = "<?php echo SITE_URL; ?>";
var Check_User = "<?php echo $logg_user_id;?>"
 // function to like to dislike in giftcertificate
function add_review(pro_id){
	if(Check_User){
	var postUrl = SITE_URL+'reviews/add/'+pro_id;
	}else{
	var postUrl = SITE_URL+'users/sign_in/tab4';
	}
	//alert(postUrl);
	jQuery('#plsLoaderID').show();
	jQuery.ajax({
		cache:false,
		async: false,
		type: "GET",
		url: postUrl,
		success: function(msg){
		/** Update the div**/
		jQuery('#tab4').html(msg);
		jQuery('#plsLoaderID').hide();
	}
	});
}

function likereview(rev_pos_id, att1, att2){
	var postUrl = SITE_URL+'reviews/savevote/'+rev_pos_id+'/'+att1+'/'+att2;
	//alert(postUrl);
	jQuery('#plsLoaderID').show();
	jQuery.ajax({
		cache:false,
		async: false,
		type: "GET",
		url: postUrl,
		success: function(msg){
		/** Update the div**/
		jQuery('#vote_pos_'+rev_pos_id).html(msg);
		jQuery('#plsLoaderID').hide();
	}
	});
}

function likereviewneg(rev_neg_id, att1, att2){
	var postUrl = SITE_URL+'reviews/savevote/'+rev_neg_id+'/'+att1+'/'+att2;
	jQuery('#plsLoaderID').show();
	jQuery.ajax({
		cache:false,
		async: false,
		type: "GET",
		url: postUrl,
		success: function(msg){
		/** Update the div**/
		jQuery('#vote_'+rev_neg_id).html(msg);
		jQuery('#plsLoaderID').hide();
	}
	});
}

function likereviewneu(rev_neu_id, att1, att2){
	
	var postUrl = SITE_URL+'reviews/savevote/'+rev_neu_id+'/'+att1+'/'+att2;
	//alert(postUrl);
	jQuery('#plsLoaderID').show();
	jQuery.ajax({
		cache:false,
		async: false,
		type: "GET",
		url: postUrl,
		success: function(msg){
		/** Update the div**/
		jQuery('#vote_neu_'+rev_neu_id).html(msg);
		jQuery('#plsLoaderID').hide();
	}
	});
}
</script>

