<?php ?>
<!--Gift Certificates Start-->
<div class="side-content">
	<h4 class="inner-gray-bg-head"><span><?php echo $html->image("red-arrow-icon.png",array('width'=>"5",'height'=>"10",'alt'=>"")); ?> Gift Certificates</span></h4>
	<div class="gray-fade-bg-box padding white-bg-box">
		<ul class="inner-left-links">
			<li><?php echo $html->link("Purchase a Gift Certificate","/certificates/buy-choiceful-gift-certificates-the-gift-of-choice",array('escape'=>false));?></li>
			<li><?php echo $html->link("View Gift Certificate Balance","/certificates/gift_balance",array('escape'=>false));?></li>
			<li><?php echo $html->link("Apply a Gift Certificate","/certificates/apply_gift",array('escape'=>false));?></li>
		</ul>
	</div>
</div>
<!--Gift Certificates Closed-->