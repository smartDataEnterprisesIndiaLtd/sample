<?php 
$option_paging = array('url'=>array('action'=>'feedback','controller'=>'sellers',$seller_id,$product_id), 'indicator' => 'plsLoaderID');
$this->Paginator->options($option_paging);?>
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
		<!--Tabs Content Section Start-->
		<div class="tabs-content-sec">
			<ul class="overflow-h">
					<li class="float-left">
			<?php $common->sellerPositivePercentage($positive_percentage);
			//REF #2971F
			//$common->sellerAvgrate($avg_full_star,$avg_half_star,$avg_rating);
			$common->sellerAvgrateCount($avg_full_star,$avg_half_star,$count_rating);
			?>
			</li>
			</ul>
			<div class="pagingdef">
				<ul class="overflow-h">
					<?php echo $paginator->prev('Prev',array('escape'=>false,'tag' => 'li','class'=>'active'));?>
					<?php echo $this->Paginator->numbers(array('separator'=>'','tag' => 'li','class'=>'active')); ?>
					<?php echo $paginator->next('Next',array('escape'=>false,'tag' => 'li','class'=>'active'));?>
				</ul>
			</div>
		</div>
			<?php if(!empty($feedbacks)) {?>
				<h4 class="margin-tp-btm larger-fnt">All Feedback:</h4>
				<div class="feedback-sec">
					<ul class="all-feedback">
						<?php foreach($feedbacks as $feedback) { ?>
							<li>
								<div class="feedback-date">
								<span class="smalr-fnt gray"><?php echo date(DATE_FORMAT,strtotime($feedback['Feedback']['created']));?></span></div>
								<div class="feedback-rate">
								<p><?php $common->displaySellerrating($feedback['Feedback']['rating']);?></p>
								</div>
								<div class="feedback-con">
								<p>&quot;<?php if(!empty($feedback['Feedback']['feedback'])) echo $this->Common->currencyEnter($feedback['Feedback']['feedback']); ?>&quot; <span class="smalr-fnt gray line-break">Buyer: <?php echo $feedback['User']['firstname'];?></span></p>
								</div>
							</li>
						<?php } ?>
					</ul>
				</div>
			<?php }?>
			<div class="pagingdef">
			<ul class="overflow-h">
				<?php echo $paginator->prev('Prev',array('escape'=>false,'tag' => 'li','class'=>'active'));?>
				<?php echo $this->Paginator->numbers(array('separator'=>'','tag' => 'li','class'=>'active')); ?>
				<?php echo $paginator->next('Next',array('escape'=>false,'tag' => 'li','class'=>'active'));?>
				
				</ul>
			</div>
		
		</div>
		<!--Tabs Content Section Closed-->
	
	</div>
	<!--Tabs Widget Closed-->
</div>
<!--mid Content Closed-->