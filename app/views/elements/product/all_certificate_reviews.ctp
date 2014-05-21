<?php 	if(!empty($all_certificate_reviews)){ 
// 			foreach($all_certificate_reviews as $cert_review){

			?>
			<!--Row1 Start-->
			<div class="order-row">
				<ul class="reviews">
					<li style="padding-top:10px"><strong>Gift Certificate Reviewed</strong></li>
					<li><?php echo $html->link('Gift Certificate','/certificates/purchase_gift',array('escape'=>false,'class'=>"underline-link"));?></li>
					<li id='search-tag-certificate'>
						<?php echo $this->element('gift_certificate/save_search_tags');?>
					</li>
					<?php 
						foreach($all_certificate_reviews as $certi_review){

							 ?>
							<li style="padding-top:10px"><strong>Review Written:</strong> <?php echo date(FULL_DATE_FORMAT,strtotime($certi_review['CertificateReview']['created'])); ?></li>
							<?php
								if($certi_review['CertificateReview']['review_type'] == 2){
									$revie_image = 'positive-icon.png';
									$revie_text = 'Positive';
									$review_class = 'green-color';
								} else if($certi_review['CertificateReview']['review_type'] == 1){
									$revie_image = 'neutral-icon.png';
									$revie_text = 'Neutral';
									$review_class = 'gray';
								} else{
									$revie_image = 'negative-icon.png';
									$revie_text = 'Negative';
									$review_class = 'red-color';
								}
							?>
							<li><strong>Your Rating:</strong> <span class="<?php echo $review_class;?>"><?php echo $html->image($revie_image,array('alt'=>'','class'=>'v-align-middle'));?> <strong><?php echo $revie_text;?></strong></span></li>
							<li><strong>Your Review</strong></p>
							<li><?php echo $certi_review['CertificateReview']['comments'];?></li>
						<?php } ?>
					
				</ul>
			</div>
			
			<!--Row1 Closed-->
			
			<?php } ?>
  

	

