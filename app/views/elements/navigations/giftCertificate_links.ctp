<?php ?>
<!--Browse Start-->
<div class="side-content">
	<h4 class="blue-head"><span>Browse</span></h4>
	<ul class="links">
		<li><?php //echo $html->link('Email a Gift Certificate',"/certificates/buy-choiceful-gift-certificates-the-gift-of-choice" ,array('escape'=>false));?>
		<?php echo $html->link('Email a Gift Certificate',"/certificates/buy-choiceful-gift-certificates-the-gift-of-choice" ,array('escape'=>false));?>
		</li>
		<li><?php echo $html->link('Apply to your Account',"/certificates/apply_gift" ,array('escape'=>false));?> </li>
		<li><?php echo $html->link('View Account Balance',"/certificates/gift_balance" ,array('escape'=>false));?> </li>
		<li><?php echo $html->link('Learn More',array('controller'=>'pages','action'=>'view','sending-a-gift-certificate') ,array('escape'=>false));?> </li>
		<li><?php echo $html->link('FAQs',"/faqs/view/7",array('escape'=>false));?> </li>
	</ul>
</div>

<!--Browse Closed-->