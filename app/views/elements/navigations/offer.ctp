<?php ?>
<!--Make me an Offer &trade; Start-->
<div class="side-content">
	<h4 class="inner-gray-bg-head"><span><?php echo $html->image("red-arrow-icon.png",array('width'=>"5",'height'=>"10",'alt'=>"")); ?> Make me an Offer &trade;</span></h4>
	<div class="gray-fade-bg-box padding white-bg-box">
		<ul class="inner-left-links">
			<li><?php echo $html->link("Manage My Offers","/offers/manage_offers",array('escape'=>false));?></li>
			<li><?php echo $html->link("View Accepted Offers","/offers/accepted_offers",array('escape'=>false));?></li>
			<li><?php echo $html->link("View Rejected Offers","/offers/rejected_offers",array('escape'=>false));?></li>
		</ul>
	</div>
</div>
<!--Make me an Offer &trade; Closed-->