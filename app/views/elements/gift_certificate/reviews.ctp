<?php echo $javascript->link(array('jquery-1.3.2.min','lib/prototype'),false); ?>
<style type="text/css">
.dimmer{
	position:absolute;
	left:45%;
	top:55%;
}
</style>
<!--Reviews Start-->
<div id="plsLoaderID" style="display:none" class="dimmer"><?php echo $html->image("loading.gif" ,array('alt'=>"Loading" ));?></div>
<div class="row no-pad-btm">
	<!--FBTogether Start-->
	<div class="fbtogether">
		<h4 class="mid-gr-head blue-color"><span>Reviews</span></h4>
		<div class="tec-details">
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
				<li>
					<?php if(!empty($neg_reviews) || !empty($pos_reviews) || !empty($latest_neu_review)) { ?>
						 <strong>Overall</strong> <span class="<?php echo $class;?>"><?php echo $html->image($ovelall_image,array('alt'=>"" ,'class'=>'img img-mrg'));?><strong><?php echo $over_all;?></strong></span>
						<?php $class_paddingLeft = 'padding-left';
					} else {
						$class_paddingLeft = ''; 
					}
					if(!empty($logg_user_id))
						$link_review_add = '/certificates/add_review/';
					else
						$link_review_add = '/users/sign_in/';
					?>
					<span class="<?php echo $class_paddingLeft;?>">
						<?php echo $html->link('Write a review',$link_review_add,array('id'=>'write_review','escape'=>false,'class'=>'')); ?>
					</span>
				</li>
				<?php
				if(!empty($show_reviews[0]) ) {
					if($show_reviews[0] == 'positive') {
						if(!empty($pos_reviews)) { ?>
						<li>
							<ul class = "review-status" >
								<li><span class="green-color min-width">
									<?php echo $html->image("positive-icon.png" ,array('width'=>"18",'height'=>"19", 'alt'=>"" ,'class'=>'img'));?> 
									<strong>Positive</strong></span>
								</li> 
								<li><span class="smalr-fnt gray">
									<?php $user_pos_email = '';
									if(!empty($pos_reviews[0]['User']['email'])) {
										$user_po_ex = explode('@',$pos_reviews[0]['User']['email']);
										$user_pos_email = $user_po_ex[0];
									} echo $user_pos_email; ?> | 
									<?php echo $format->date_format($pos_reviews[0]['CertificateReview']['created']); ?></span>
								</li>
							</ul>
							<?php foreach($pos_reviews as $pos_review) {
								if($pos_review['CertificateReview']['comments']) { ?>
								<p class="cl-widget">&quot;<?php echo $pos_review['CertificateReview']['comments']; ?>&quot;</p>
								<ul class="review-status" style="padding-bottom:5px;">
									<span id="vote_pos_<?php echo $pos_review['CertificateReview']['id'];?>">
										<?php
										$rev_gift_pos_id = $pos_review['CertificateReview']['id'];
										$this->set('rev_gift_pos_id',$rev_gift_pos_id);
										echo $this->element('/gift_certificate/vote_pos');?> 
									</span>
									<?php
										if(!empty($logg_user_id))
											$link_report = '/certificates/report_review/'.$rev_gift_pos_id;
										else
											$link_report = '/users/sign_in/';
									?>
									<li>
										<?php echo '&nbsp;'.$html->link($html->image("flag.png",array('width'=>"31",'height'=>"25", 'alt'=>"" ,'class'=>'img pad-rt')),$link_report,array('escape'=>false,'class'=>'underline-link thisreport'));?></li>
									<li>
									<?php
										echo $html->link('Report this',$link_report,array('escape'=>false,'class'=>'underline-link report-this thisreport'));?>
									</li>
								</ul>
								<?php }
							} ?>
						</li>
						<?php }
					} else if($show_reviews[0] == 'negative') {
						if( !empty($neg_reviews) ) { ?>
						<li>
							<ul class = "review-status">
								<li><span class="red-color min-width">
									<?php echo $html->image("negative-icon.png",array('width'=>"19",'height'=>"18", 'alt'=>"" ,'class'=>'img'));?> 
										<strong>Negetive</strong>
								</span></li>
								<li><span class="smalr-fnt gray">
									<?php $user_email = '';
									if( !empty($neg_reviews[0]['User']['email']) ){
										$user_ex = explode('@',$neg_reviews[0]['User']['email']);
										$user_email = $user_ex[0];
									} echo $user_email; ?> | 
									<?php echo $format->date_format($neg_reviews[0]['CertificateReview']['created']); ?>
								</span></li>
							</ul>
							<?php foreach($neg_reviews as $neg_review) {
								if( $neg_review['CertificateReview']['comments']) { ?>
								<p class="cl-widget">&quot;<?php echo $neg_review['CertificateReview']['comments']; ?>&quot;</p>
								<ul class="review-status">
									<span id="vote_<?php echo $neg_review['CertificateReview']['id']; ?>">
										<?php
										$rev_gift_neg_id = $neg_review['CertificateReview']['id'];
										$this->set('rev_gift_neg_id',$rev_gift_neg_id);
										echo $this->element('/gift_certificate/vote_neg');?>
									</span>
									<?php
										if(!empty($logg_user_id))
										$link_report = '/certificates/report_review/'.$rev_gift_pos_id;
										else
										$link_report = '/users/sign_in/';
									?>
									<li>
										<?php echo '&nbsp;'.$html->link($html->image("flag.png",array('width'=>"31",'height'=>"25", 'alt'=>"" ,'class'=>'img pad-rt')),$link_report,array('escape'=>false,'class'=>'underline-link thisreport'));?></li>
									<li>
										<?php echo $html->link('Report this',$link_report,array('escape'=>false,'class'=>'underline-link report-this thisreport'));?>
									</li>
								</ul>
								<?php }
							}?>
						</li>
						<?php }
					} else {
						if( !empty($neu_reviews) ) { ?>
						<li>
							
							<ul class = "review-status">
								<li><span class="gray min-width">
									<?php echo $html->image("neutral-icon.png",array('width'=>"17",'height'=>"17", 'alt'=>"" ,'class'=>'img pad-rt'));?> 
									<strong>Neutral</strong>
								</span> </li>
								<li><span class="smalr-fnt gray">
									<?php $user_neu_email = '';
									if(!empty($neu_reviews[0]['User']['email'])){
										$user_neu_ex = explode('@',$neu_reviews[0]['User']['email']);
										$user_neu_email = $user_neu_ex[0];
									} echo $user_neu_email; ?> | 
									<?php echo $format->date_format($neu_reviews[0]['CertificateReview']['created']); ?>
								</span></li>
							</ul>
							<?php
							foreach($neu_reviews as $neu_review) {
								if( !empty($neu_review['CertificateReview']['comments']) ) { ?>
								<p class="cl-widget">&quot;<?php echo $neu_review['CertificateReview']['comments']; ?>&quot;</p>
								<ul class="review-status">
									
									<span id="vote_neu_<?php echo $neu_review['CertificateReview']['id'];?>">
										<?php
										$rev_gift_neu_id = $neu_review['CertificateReview']['id'];
										$this->set('rev_gift_neu_id',$rev_gift_neu_id);
										echo $this->element('/gift_certificate/vote_neu');?>
									</span>
									<?php
										if(!empty($logg_user_id))
										$link_report = '/certificates/report_review/'.$rev_gift_pos_id;
										else
										$link_report = '/users/sign_in/';
									?>
									<li><?php echo '&nbsp;'.$html->link($html->image("flag.png",array('width'=>"31",'height'=>"25", 'alt'=>"" ,'class'=>'img pad-rt')),$link_report,array('escape'=>false,'class'=>'underline-link thisreport'));?></li>
									<li>
										<?php echo $html->link('Report this',$link_report,array('escape'=>false,'class'=>'underline-link report-this thisreport'));?>
									</li>
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
							<ul class = "review-status">
								<li><span class="green-color min-width">
									<?php echo $html->image("positive-icon.png" ,array('width'=>"18",'height'=>"19", 'alt'=>"" ,'class'=>'img'));?> 
									<strong>Positive</strong>
								</span></li>
								<li><span class="smalr-fnt gray">
									<?php $user_pos_email = '';
									if(!empty($pos_reviews[0]['User']['email'])){
										$user_po_ex = explode('@',$pos_reviews[0]['User']['email']);
										$user_pos_email = $user_po_ex[0];
									} echo $user_pos_email; ?> | 
									<?php echo $format->date_format($pos_reviews[0]['CertificateReview']['created']); ?>
								</span></li>
							</ul>
							<?php foreach($pos_reviews as $pos_review) {
								if($pos_review['CertificateReview']['comments']) {?>
								<p class="cl-widget">&quot;<?php echo $pos_review['CertificateReview']['comments']; ?>&quot;</p>
								<ul class="review-status">
									<span id="vote_pos_<?php echo $pos_review['CertificateReview']['id'];?>">
										<?php $rev_gift_pos_id = $pos_review['CertificateReview']['id'];
										$this->set('rev_gift_pos_id',$rev_gift_pos_id);?>
										<?php  echo $this->element('/gift_certificate/vote_pos');?> 
									</span>
									<?php
										if(!empty($logg_user_id))
										$link_report = '/certificates/report_review/'.$rev_gift_pos_id;
										else
										$link_report = '/users/sign_in/';
									?>
									<li>
										<?php echo '&nbsp;'.$html->link($html->image("flag.png",array('width'=>"31",'height'=>"25", 'alt'=>"" ,'class'=>'img pad-rt')),$link_report,array('escape'=>false,'class'=>'underline-link thisreport'));?></li>
									<li>
										<?php echo $html->link('Report this',$link_report,array('escape'=>false,'class'=>'underline-link report-this thisreport'));?>
									</li>
								</ul>
								<?php }
							}?>
						</li>
						<?php }
					} else if($show_reviews[1] == 'negative'){
						if(!empty($neg_reviews)) { ?>
						<li>
							<ul class = "review-status">
								<li><span class="red-color min-width">
									<?php echo $html->image("negative-icon.png",array('width'=>"19",'height'=>"18", 'alt'=>"" ,'class'=>'img'));?> 
								<strong>Negetive</strong>
								</span></li>
								<li><span class="smalr-fnt gray">
									<?php $user_email = '';
									if(!empty($neg_reviews[0]['User']['email'])){
										$user_ex = explode('@',$neg_reviews[0]['User']['email']);
										$user_email = $user_ex[0];
									} echo $user_email; ?> | 
									<?php echo $format->date_format($neg_reviews[0]['CertificateReview']['created']); ?>
								</span></li>
							</ul>
							<?php foreach($neg_reviews as $neg_review) {
								if( $neg_review['CertificateReview']['comments']) { ?>
								<p class="cl-widget">&quot;<?php echo $neg_review['CertificateReview']['comments']; ?>&quot;</p>
								<ul class="review-status">
									<span id="vote_<?php echo $neg_review['CertificateReview']['id']; ?>">
										<?php $rev_gift_neg_id = $neg_review['CertificateReview']['id'];
										$this->set('rev_gift_neg_id',$rev_gift_neg_id);
										echo $this->element('/gift_certificate/vote_neg');?> 
									</span>
									<li>
										<?php echo '&nbsp;&nbsp;'.$html->link($html->image("flag.png",array('width'=>"31",'height'=>"25", 'alt'=>"" ,'class'=>'img pad-rt')),"#",array('escape'=>false,'class'=>''));?></li>
									<li>
										<?php 
										if(!empty($logg_user_id))
											$link_report = '/certificates/report_review/'.$rev_gift_neg_id;
										else
											$link_report = '/users/sign_in/';
											echo $html->link('Report this',$link_report,array('escape'=>false,'class'=>'underline-link thisreport'));?></li>
								</ul>
								<?php }?>
							<?php }?>
						</li>
						<?php }
					} else{
						if(!empty($neu_reviews)) { ?>
						<li>
							<ul class = "review-status">
								<li><span class="gray min-width">
									<?php echo $html->image("neutral-icon.png",array('width'=>"17",'height'=>"17", 'alt'=>"" ,'class'=>'img pad-rt'));?> 
									<strong>Neutral</strong>
								</span></li>
								<li><span class="smalr-fnt gray">
									<?php $user_neu_email = '';
									if(!empty($neu_reviews[0]['User']['email'])){
										$user_neu_ex = explode('@',$neu_reviews[0]['User']['email']);
										$user_neu_email = $user_neu_ex[0];
									} echo $user_neu_email; ?> | 
									<?php echo $format->date_format($neu_reviews[0]['CertificateReview']['created']);
									
									?>
								</span></li>
							</ul>
							<?php
							foreach($neu_reviews as $neu_review) {
								if(!empty($neu_review['CertificateReview']['comments'])){ ?>
								<p class="cl-widget">&quot;<?php echo $neu_review['CertificateReview']['comments']; ?>&quot;</p>
								<ul class="review-status">
									<span id="vote_neu_<?php echo $neu_review['CertificateReview']['id'];?>">
										<?php $rev_gift_neu_id = $neu_review['CertificateReview']['id'];
										$this->set('rev_gift_neu_id',$rev_gift_neu_id);
										echo $this->element('/gift_certificate/vote_neu');?> 
									</span>
									<li>
										<?php echo '&nbsp'.$html->link($html->image("flag.png",array('width'=>"31",'height'=>"25", 'alt'=>"" ,'class'=>'img pad-rt')),"#",array('escape'=>false,'class'=>''));?></li>
									<li>
										<?php if(!empty($logg_user_id))
											$link_report = '/certificates/report_review/'.$rev_gift_neu_id;
										else
											$link_report = '/users/sign_in/';
										echo $html->link('Report this',$link_report,array('escape'=>false,'class'=>'underline-link report-this thisreport'));?></li>
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
							<ul class = "review-status">
								<li><span class="green-color min-width">
								<?php echo $html->image("positive-icon.png" ,array('width'=>"18",'height'=>"19", 'alt'=>"" ,'class'=>'img'));?> 
								<strong>Positive</strong>
								</span></li>
								<li><span class="smalr-fnt gray">
									<?php $user_pos_email = '';
									if(!empty($pos_reviews[0]['User']['email'])){
										$user_po_ex = explode('@',$pos_reviews[0]['User']['email']);
										$user_pos_email = $user_po_ex[0];
									} echo $user_pos_email; ?> | 
									<?php echo $format->date_format($pos_reviews[0]['CertificateReview']['created']); ?>
								</span></li>
							</ul>
							<?php foreach($pos_reviews as $pos_review) {
							if($pos_review['CertificateReview']['comments']) {?>
							<p class="cl-widget">&quot;<?php echo $pos_review['CertificateReview']['comments']; ?>&quot;</p>
							<ul class="review-status">
								<span id="vote_pos_<?php echo $pos_review['CertificateReview']['id'];?>">
								<?php
								$rev_gift_pos_id = $pos_review['CertificateReview']['id'];
								$this->set('rev_gift_pos_id',$rev_gift_pos_id);?>
								<?php echo $this->element('/gift_certificate/vote_pos');?> 
								</span>
								<li><?php echo '&nbsp;'.$html->link($html->image("flag.png",array('width'=>"31",'height'=>"25", 'alt'=>"" ,'class'=>'img pad-rt')),"#",array('escape'=>false,'class'=>''));?></li>
								<li><?php 
									if(!empty($logg_user_id))
										$link_report = '/certificates/report_review/'.$rev_gift_pos_id;
									else
										$link_report = '/users/sign_in/';
										echo $html->link('Report this',$link_report,array('escape'=>false,'class'=>'underline-link report-this thisreport'));?>
								</li>
							</ul>
							<?php }
							}?>
						</li>
					<?php }
					} else if($show_reviews[2] == 'negative'){
						if(!empty($neg_reviews)) { ?>
						<li>
							<ul class = "review-status">
								<li><span class="red-color min-width">
									<?php echo $html->image("negative-icon.png",array('width'=>"19",'height'=>"18", 'alt'=>"" ,'class'=>'img'));?> 
									<strong>Negetive</strong>
								</span></li>
								<li><span class="smalr-fnt gray">
									<?php $user_email = '';
									if(!empty($neg_reviews[0]['User']['email'])){
										$user_ex = explode('@',$neg_reviews[0]['User']['email']);
										$user_email = $user_ex[0];
									} echo $user_email; ?> | 
									<?php echo $format->date_format($neg_reviews[0]['CertificateReview']['created']); ?>
								</span></li>
							</ul>
							<?php foreach($neg_reviews as $neg_review) {
								if( $neg_review['CertificateReview']['comments']) { ?>
								<p class="cl-widget">&quot;<?php echo $neg_review['CertificateReview']['comments']; ?>&quot;</p>
								<ul class="review-status">
									<span id="vote_<?php echo $neg_review['CertificateReview']['id']; ?>">
									<?php $rev_gift_neg_id = $neg_review['CertificateReview']['id'];
										$this->set('rev_gift_neg_id',$rev_gift_neg_id);
										echo $this->element('/gift_certificate/vote_neg');?>
									</span>
									<li><?php echo '&nbsp;&nbsp;'.$html->link($html->image("flag.png",array('width'=>"31",'height'=>"25", 'alt'=>"" ,'class'=>'img pad-rt')),"#",array('escape'=>false,'class'=>''));?></li>
									<li><?php
										if(!empty($logg_user_id))
											$link_report = '/certificates/report_review/'.$rev_gift_neg_id;
										else
											$link_report = '/users/sign_in/';
									
										echo $html->link('Report this',$link_report,array('escape'=>false,'class'=>'underline-link report-this thisreport'));?></li>
										
								</ul>
								<?php }
							}?>
						</li>
						<?php }
					} else{
						if(!empty($neu_reviews)) { ?>
						<li>
							<ul class = "review-status">
								<li><span class="gray min-width">
									<?php echo $html->image("neutral-icon.png",array('width'=>"17",'height'=>"17", 'alt'=>"" ,'class'=>'img pad-rt'));?> 
									<strong>Neutral</strong>
								</span></li>
								<li><span class="smalr-fnt gray">
									<?php $user_neu_email = '';
									if(!empty($neu_reviews[0]['User']['email'])){
										$user_neu_ex = explode('@',$neu_reviews[0]['User']['email']);
										$user_neu_email = $user_neu_ex[0];
									} echo $user_neu_email; ?> | 
									<?php echo $format->date_format($neu_reviews[0]['CertificateReview']['created']); ?>
								</span></li>
							</ul>
							<?php
							foreach($neu_reviews as $neu_review) {
								if(!empty($neu_review['CertificateReview']['comments'])) { ?>
								<p class="cl-widget">&quot;<?php echo $neu_review['CertificateReview']['comments']; ?>&quot;</p>
								<ul class="review-status">
									<span id="vote_neu_<?php echo $neu_review['CertificateReview']['id'];?>">
									<?php $rev_gift_neu_id = $neu_review['CertificateReview']['id'];
									$this->set('rev_gift_neu_id',$rev_gift_neu_id);
									echo $this->element('/gift_certificate/vote_neu');?> 
									</span>
									<li><?php echo '&nbsp'.$html->link($html->image("flag.png",array('width'=>"31",'height'=>"25", 'alt'=>"" ,'class'=>'img pad-rt')),"#",array('escape'=>false,'class'=>''));?></li>
									<li><?php 
									if(!empty($logg_user_id))
										$link_report = '/certificates/report_review/'.$rev_gift_neu_id;
									else
										$link_report = '/users/sign_in/';
									echo $html->link('Report this',$link_report,array('escape'=>false,'class'=>'underline-link report-this thisreport'));?></li>
									</ul>
								<?php }
							}?>
						</li>
						<?php }
					}
				}?>
			</ul>
		</div>
	</div>
	<!--FBTogether Closed-->
</div>
<!--Reviews Closed-->