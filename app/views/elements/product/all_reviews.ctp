	<?php if(!empty($all_reviews)){ 
			foreach($all_reviews as $review){
			?>
			<!--Row1 Start-->
			<div class="order-row">
				<ul class="reviews">
					<li style="padding-top:10px"><strong>Product Reviewed</strong></li>
					<li><?php echo $html->link($review['Product']['product_name'],'/categories/productdetail/'.$review['Product']['id'],array('escape'=>false,'class'=>"underline-link"));?></li>
					
					<?php if(!empty($review['Reviews'])){
						foreach($review['Reviews'] as $review_dis){
							//pr($review_dis); ?>

							<li style="padding-top:10px"><strong>Review Written:</strong> <?php echo date(FULL_DATE_FORMAT,strtotime($review_dis['created'])); ?></li>
							<?php
								if($review_dis['review_type'] == 2){
									$revie_image = 'positive-icon.png';
									$revie_text = 'Positive';
									$review_class = 'green-color';
								} else if($review_dis['review_type'] == 1){     
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
							<li id='search-tag<?php echo $review['Product']['id'];?>'>
						<?php $this->set('review_pro_id',$review['Product']['id']);
						$this->set('pro_id',$review['Product']['id']);
						echo $this->element('product/save_search_tags');?>
					</li>
              <li><strong>Your Review</strong></p>
							<li><?php echo $review_dis['comments'];?></li>
						<?php }
					}?>
                    
				</ul>
			</div>
			
			<!--Row1 Closed-->
			<?php }?>
			<?php } ?>
       