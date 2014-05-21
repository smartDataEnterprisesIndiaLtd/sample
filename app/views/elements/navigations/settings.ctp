<?php ?>
<!--Settings Start-->
<div class="side-content">
	<h4 class="inner-gray-bg-head"><span><?php echo $html->image("red-arrow-icon.png",array('width'=>"5",'height'=>"10",'alt'=>"")); ?> Settings</span></h4>
	<div class="gray-fade-bg-box padding white-bg-box">
		<ul class="inner-left-links">
			<li><?php echo $html->link("Change name, E-Mail Address or Password","/users/my_account",array('escape'=>false));?></li>
			<li><?php echo $html->link("Manage Address Book","/users/manage_addresses",array('escape'=>false));?></li>
			<li><?php echo $html->link("Add New Address","/users/add_address",array('escape'=>false));?></li>
			<li><?php echo $html->link("Manage E-Mail Preferences &amp; Alerts","/users/email_alerts",array('escape'=>false));?></li>
			<li><?php echo $html->link("Special Occasion Calendar","/users/events_calendar",array('escape'=>false));?></li>
		</ul>
	</div>
</div>
<!--Settings Closed-->