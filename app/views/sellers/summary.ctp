<?php ?>
<style>
.rate-bar-background{ padding-right:0px }
img { vertical-align:middle; } 

</style>
<!--Left Content Start-->
<?php if(!empty($pro_info) ) {
	echo $this->element('seller/product_left');//echo $this->element('search');
} else{
	//echo $this->element('search_fullpage');
} ?>
<!--mid Content Start-->
<div class="mid-content pad-rt-none" style="position:relative;">
	
	<?php echo $this->element('seller/profile_image'); ?>
	<h2 class="choiceful margin-tp-btm mrgin-heading"><span class="sml-fnt black-color">Seller</span> <?php echo $seller_info['Seller']['business_display_name'];?></h2>
	<p class="margin-bottom margin-summary"><?php echo $html->link('Browse all '.$seller_info['Seller']['business_display_name'].'\'s  store','/sellers/store/'.$seller_id,array('escape'=>false,'class'=>'underline-link'));?></p>
	<?php echo $this->element('seller/tabs');?>
	<!--Tabs Widget Start-->
	<div class="tbs-content-widget overflow-h">
		<!--Rating & Feedback Start-->
		<div class="rating-feedback-widget">
			<!--Rating Widget Start-->
			<div class="rating-widget">
				<h4 class="blue-hd"><span>Rating Snapshot <b class="font-weight-normal smalr-fnt">(Total of <?php echo $count_rating;?> feedbacks)</b></span></h4>
				<div class="wht-bg-box">
					<ul class="rating-graph">
						<?php if(!empty($total_rating)) {
						$total_width = 157;
						foreach($total_rating as $rating_index=>$rating_ind_count) {
							if(empty($count_rating))
							$count_rating = 1;
							$orange_width = 0;
							$orang_width = ($total_width/$count_rating)*$rating_ind_count;
						?>
						<li>
							<div class="rate-value"><?php echo $rating_index;?> stars</div>
							<div class="rate-bar rate-bar-background">
								<div class="rate-bar-orange" style="width:<?php echo $orang_width;?>px">&nbsp;</div>
							</div>
							<div class="rate-points"><?php echo $rating_ind_count;?></div>
						</li>
						<?php } }?>
					</ul>
				</div>
				<?php
				//#H2950
				//$common->sellerAvgrate($avg_full_star,$avg_half_star,$avg_rating);
				$common->sellerAvgrateCount($avg_full_star,$avg_half_star,$count_rating_seller);
				$common->sellerPositivePercentage($positive_percentage);?>
				
			</div>
			<!--Rating Widget Closed-->
<?php //pr($recent_feedbacks);
			if(!empty($recent_feedbacks) ){?>
			<!--Feedback Widget Start-->
			<div class="feedback-widget">
				<p align="right"><?php echo $html->link('See all feedback','/sellers/feedback/'.$seller_id.'/'.$product_id.'/'.$condition_id,array('escape'=>false,'class'=>'underline-link smalr-fnt'));?></p>
				<!--Feedbacks Start-->
				<div class="feedbacks">
					<h5 class="gray-hd border-bottom">Recent Feedback</h5>
					<!--Row1 Start-->
					<?php foreach($recent_feedbacks as $recent_feedback) {?>
					<div class="feedback-row">
						<p><?php $common->displaySellerrating($recent_feedback['Feedback']['rating']);?></p>
						<p style="word-wrap:break-word;">"<?php if(!empty($recent_feedback['Feedback']['feedback'])) echo $this->Common->currencyEnter($recent_feedback['Feedback']['feedback']); ?>" <span class="smalr-fnt gray line-break">Buyer: <?php echo $recent_feedback['User']['firstname'];?> | <?php echo date(DATE_FORMAT,strtotime($recent_feedback['Feedback']['created']));?></span></p>
					</div>
					<?php }?>
					<!--Row1 Closed-->
				</div>
				<!--Feedbacks Closed-->
			</div>
			<!--Feedback Widget Closed-->
			<?php }?>
		</div>
		<!--Rating & Feedback Closed-->
		<!--Tabs Content Section Start-->
		<div class="tabs-content-sec">
			<!--Inner Content Start-->
			<div class="inner-content">
				<h4 class="choiceful pad-btm font-size13">Choiceful Buying Guarantee - Buy with 100% Confidence</h4>
				<p class="smalr-fnt contant-summary"><?php echo strip_tags($format->formatString($buy_gurantee_desc,1000,'...')); echo $html->link('Read more','/pages/view/buy-with-confidence-guarantee',array('escape'=>false,'class'=>'underline-link'));?></p>
				<h4 class="choiceful margin-tp-btm font-size13">Returns and Refunds Policy</h4>
				<p class="smalr-fnt contant-summary"><?php echo strip_tags($format->formatString($refundreturn_des,1000,'...')); echo $html->link('Read more','/pages/view/returns-policy',array('escape'=>false,'class'=>'underline-link'));?></p>
				<h4 class="choiceful margin-tp-btm font-size13">Shipping Rates</h4>
				<?php
				if(!empty($pro_seller_info['UserSummary']['SellerSummary'])){
					if(!empty($pro_seller_info['UserSummary']['SellerSummary']['free_delivery'])){?>
					<p class="pad-none contant-summary"><span class="red-color"><strong>FREE DELIVERY</strong></span>  <span class="smalr-fnt"><strong>Spend over <?php echo CURRENCY_SYMBOL. $format->money($pro_seller_info['UserSummary']['SellerSummary']['threshold_order_value'],2);?> with this seller for free starndard UK Delivery</strong></span></p>
				<?php } } ?>
				<p><?php echo $html->link('Browse all '.$seller_info['Seller']['business_display_name'].'\'s  products','/sellers/store/'.$seller_id,array('escape'=>false,'class'=>'underline-link'));?></p>
				<!--Standard Delivery within the UK Start-->
				<div class="ac-setting">
					<!--Gray Back heading Start-->
					<div class="gry-bg-hding">
						<ul>
							<li class="head"><strong>Standard Delivery within the UK</strong></li>
						</ul>
					</div>
					<!--Gray Back heading Closed-->
					<!--Account Setting Fields Start-->
					<div class="ac-setting-flds">
						<!--Account Setting Fields Rows Start-->
						<ul class="ac-setting-flds-rows">
							<li>
								<div class="ac-setting-flds-label larger-label-width">Estimated Delivery:</div>
								<div class="ac-setting-flds-field">3-5 working days</div>
							</li>
							<li>
								<div class="ac-setting-flds-label larger-label-width">Prices:</div>
								<div class="ac-setting-flds-field">Calculated <strong>per item delivery rates</strong></div>
							</li>
							<li>
								<div class="ac-setting-flds-label larger-label-width">Gift Options:</div>
								<div class="ac-setting-flds-field">
									<?php if($seller_info['Seller']['gift_service'] == 1){
										echo 'Available during checkout';
									}else{
										echo 'Not available for this item';
									}?>
								</div>
							</li>
						</ul>
						<!--Account Setting Fields Rows Closed-->
					</div>
					<!--Account Setting Fields Closed-->
				</div>
				<!--Standard Delivery within the UK Closed-->
				<!--Expedicted Delivery within the UK Start-->
				<div class="ac-setting">
					<!--Gray Back heading Start-->
					<div class="gry-bg-hding">
						<ul>
							<li class="head"><strong>Express Delivery within the UK</strong></li>
						</ul>
					</div>
					<!--Gray Back heading Closed-->
					<!--Account Setting Fields Start-->
					<div class="ac-setting-flds">
						<!--Account Setting Fields Rows Start-->
						<ul class="ac-setting-flds-rows">
							<li>
								<div class="ac-setting-flds-label larger-label-width">Estimated Delivery:</div>
								<div class="ac-setting-flds-field">3-5 working days</div>
							</li>
							<li>
								<div class="ac-setting-flds-label larger-label-width">Availability:</div>
								<div class="ac-setting-flds-field">Seller only offers this on selected items</div>
							</li>
						</ul>
						<!--Account Setting Fields Rows Closed-->
					</div>
					<!--Account Setting Fields Closed-->
				</div>
				<!--Expedicted Delivery within the UK Closed-->
				<h4 class="choiceful margin-tp-btm font-size13">About Approved Sellers</h4>
				<p class="smalr-fnt contant-summary">This approved marketplace seller is committed to our marketplace policy, and will provide each customer with highest level of customer service standards. All orders placed with the seller are protected by our <?php echo $html->link('buy-with-confidence guarantee','/pages/view/buy-with-confidence-guarantee',array('escape'=>false,'class'=>'underline-link'));?>.</p>
				<h4 class="choiceful margin-tp-btm font-size13">Help</h4>
				<p><?php echo $html->link('Contact this seller','/orders/contact_sellers/'.$seller_id,array('escape'=>false,'class'=>'underline-link'));?> <span class="line-break smalr-fnt">(Must have a Choiceful.com account and have placed an order)</span></p>
				<p class="pad-none">
					<span class="smalr-fnt line-break">Want to cancel an order, or return an item?</span>
					<?php echo $html->link('Cancelling orders','/orders/view_open_orders/seller_id:'.$seller_id,array('escape'=>false,'class'=>'underline-link'));?>
				</p>
				<p class="pad-none"><?php echo $html->link('Returns and refunds','/orders/return_items/seller_id:'.$seller_id,array('escape'=>false,'class'=>'underline-link'));?></p>
				<p class="smalr-fnt"> </p>
			</div>
			<!--Inner Content Closed-->
		</div>
		<!--Tabs Content Section Closed-->
	</div>
	<!--Tabs Widget Closed-->
</div>
<!--mid Content Closed-->