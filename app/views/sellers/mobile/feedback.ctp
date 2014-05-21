<?php ?>
<style>
.gray {
    color: #7C7C7C;
    float: left;
}
</style>
<!--Main Content Starts--->
<section class="maincont">
<!--Star Rating Starts-->
	<section class="starrtng">
	<ul>
	<li class="selrhdng"><?php echo $seller_info['Seller']['business_display_name'];?></li>
	<li>
		<?php $common->sellerPositivePercentage($positive_percentage);?>
	</li>
	<li class="starsfdbk">
		<span style="float:left; padding-right:5px;">
			<?php $common->sellerAvgrate($avg_full_star,$avg_half_star,$avg_rating);?>
		</span>
		<?php //echo '<span style="color:#0033AC">Browse</span> '.$html->link($seller_info['Seller']['business_display_name'].'\'s  ','/sellers/store/'.$seller_id,array('escape'=>false,'class'=>'underline-link'));?><span style="color:#FFF">store</span>
	</li>	
	</ul>
	
	<!---->
	<section class="rtngsnpsht">
	<h4>Rating Snapshot <span class="font11">(Total of <?php echo $count_rating;?> feedbacks)</span></h4>
	<ul class="actlrtng">
		<?php if(!empty($total_rating)) {
			$total_width = 157;
			foreach($total_rating as $rating_index=>$rating_ind_count) {
				if(empty($count_rating))
					$count_rating = 1;
				$orange_width = 0;
				$orang_width = ($total_width/$count_rating)*$rating_ind_count;
		?>
		<li>
			<label><?php echo $rating_index;?> stars</label>
			<li class="rate-bar rate-bar-background">
				<div class="rate-bar-orange" style="width:<?php echo $orang_width;?>px"></div>
			</li>
			
			<span><?php echo $rating_ind_count;?></li>
		</li>
		
		
		<?php } }?>
	</ul>
	</section>
	<!---->

	
	
	
	<?php if(!empty($feedbacks)) {?>
	<section class="recntfdbk">
	<?php echo $this->element('mobile/seller/paging');?>
	<?php foreach($feedbacks as $feedback) { ?>
	<!---->
		<ul class="fdbkbyr">
			
			<li class="fbbkbyrsstr">
				<span style="float:left; padding-right:5px;">
				<?php $common->displaySellerrating($feedback['Feedback']['rating']);?>
				</span>
			</li>
			<li>"
				<?php if(!empty($feedback['Feedback']['feedback'])) echo $feedback['Feedback']['feedback']; ?>
			"</li>
			<li class="font11 gray">Buyer: 
				<?php echo $feedback['User']['firstname'];?>&nbsp;| 
				<?php echo date(DATE_FORMAT,strtotime($feedback['Feedback']['created']));?>
			</li>
		</ul>
	<!---->
	<?php }?>
	<?php echo $this->element('mobile/seller/paging_footer');?>
	<!--<ul class="overflow-h">
		<li class="float-right"><?php //echo $paginator->next('See more>',array('class'=>"underline-link"));?></li>
		<li class="float-right"><?php //echo $paginator->prev('<See previous',array('class'=>"underline-link"));?></li>
	</ul>-->
	</section>
	<?php }?>
	</section>
<!--Star Rating End-->

	<!--Help Container Starts-->
	<section class="helpcntnr">
		<ul>
			<?php if(!empty($pro_seller_info['UserSummary']['SellerSummary'])){
					if(!empty($pro_seller_info['UserSummary']['SellerSummary']['free_delivery'])){?>
			<li class="margin-top"><span class="frydlvry drkred">FREE DELIVERY</span>&nbsp;<b class="font11">Spend over 
					<?php echo CURRENCY_SYMBOL. $format->money($pro_seller_info['UserSummary']['SellerSummary']['threshold_order_value'],2);?> 
					with this seller for free standard UK Delivery</b></li>
			<?php }}?>
			<li class="orange-col-head hlphdng"><b>Help</b></li> 
			<li>
				<?php echo $html->link('Contact this seller','/orders/contact_sellers',array('escape'=>false,'class'=>'underline-link'));?>
			</li>
			<li class="font11">(Must have a Choiceful.com account and have placed an order)</li>
			<li>&nbsp;</li>
			<li class="font11">Want to cancel an order, or return an item?</li>
			<li>
				<?php echo $html->link('Cancel orders','/orders/view_open_orders',array('escape'=>false,'class'=>'underline-link'));?>
			</li>
			<li>
				<?php echo $html->link('Return and refund orders','/orders/return_items',array('escape'=>false,'class'=>'underline-link'));?>
			</li>
		</ul>
	</section>
<!--Help Container Starts-->
</section>
<!--Main Content End--->
