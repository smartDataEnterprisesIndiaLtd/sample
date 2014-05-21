<?php ?>
<!--Footer Start-->

<div id="footer">
	<!--Footer Links widget Start-->
	<div class="footer-links-widget">

		<!--The Choiceful Company Start-->
		<div class="footer-links">
			<h4>The Choiceful Company</h4>
			<ul>
				<li><?php echo $html->link('About Choiceful',array('controller'=>'pages','action'=>'view','about-choiceful'),array('escape'=>false));?></li>
				<li><?php echo $html->link('Conditions of Use',array('controller'=>'pages','action'=>'view','conditions-of-use'),array('escape'=>false));?></li>
				<li><?php echo $html->link('Terms and Conditions',array('controller'=>'pages','action'=>'view','terms-and-conditions'),array('escape'=>false));?></li>
				<li><?php echo $html->link('Privacy Policy',array('controller'=>'pages','action'=>'view','privacy-policy'),array('escape'=>false));?></li>
				<li><?php echo $html->link('Online Security',array('controller'=>'pages','action'=>'view','online-security'),array('escape'=>false));?></li>
				<li><?php echo $html->link('Contact Us',array('controller'=>'pages','action'=>'view','contact-us'),array('escape'=>false));?></li>
				<li><?php echo $html->link('Our Global Stores',array('controller'=>'pages','action'=>'view','our-global-stores'),array('escape'=>false));?></li>
			</ul>
		</div>
		<!--The Choiceful Company Closed-->
		<!--The Choiceful Company Start-->
		<div class="footer-links">
			<h4>Earn Money</h4>
			<ul>
				<li><?php echo $html->link('What is Choiceful Marketplace?',array('controller'=>'pages','action'=>'view','choiceful-marketplace'),array('escape'=>false));?></li>
				<li><?php echo $html->link('User Agreement',array('controller'=>'pages','action'=>'view','user-agreement'),array('escape'=>false));?></li>
				<li><?php echo $html->link('Sign Up',array('controller'=>'pages','action'=>'view','sign-up'),array('escape'=>false));?></li>
				<li><?php echo $html->link('Marketplace Fees',array('controller'=>'pages','action'=>'view','marketplace-fees'),array('escape'=>false));?></li>
				<li><?php echo $html->link('Affiliate Program','/affiliates/view/1',array('escape'=>false));?></li>
			</ul>
		</div>
		<!--The Choiceful Company Closed-->
		<!--The Choiceful Company Start-->
		<div class="footer-links">
			<h4>Customer Help</h4>
			<ul>
				<li><?php echo $html->link('Help Topics',array('controller'=>'pages','action'=>'view','help-topics'),array('escape'=>false));?></li>
				<li><?php echo $html->link('About Our Website',array('controller'=>'pages','action'=>'view','about-website'),array('escape'=>false));?></li>
				<li><?php echo $html->link('Product Index',"/departments/a_z_index",array('escape'=>false));?></li>
				<li><?php echo $html->link('Delivery Rates',array('controller'=>'pages','action'=>'view','delivery-rates'),array('escape'=>false));?></li>
				<li><?php echo $html->link('Returns Policy',array('controller'=>'pages','action'=>'view','returns-policy'),array('escape'=>false));?></li>
				<li><?php echo $html->link('Frequently Asked Questions',"/faqs/view/1",array('escape'=>false));?></li>
			</ul>
		</div>
		<!--The Choiceful Company Closed-->
		<!--The Choiceful Company Start-->
		<div class="footer-links">
			<h4>Choiceful.com Gift Certificates</h4>
			<ul>
				<li><?php echo $html->link('Buy Gift Certificates',array('controller'=>'certificates','action'=>'purchase_gift'),array('escape'=>false));?></li>
				<li><?php echo $html->link('Gift Certificate Help',array('controller'=>'pages','action'=>'view','gift-certificate-help'),array('escape'=>false));?></li>
			</ul>
		</div>
		<!--The Choiceful Company Closed-->
	</div>
	<!--Footer Links widget Closed-->
	<!--Footer Start-->
	<div class="footer">
		<ul>
			<li style="vertical-align:baseline;">Copyright  &copy;  Choiceful.com <?php echo date("Y");?> &nbsp;&nbsp;</li>
			<li class="float-right"><?php echo $html->image("master-card-secure-code.png" ,array('width'=>"51" ,'height'=>"20", 'alt'=>"" ));echo $html->image("verified-by-visa.png",array('width'=>"46",'height'=>"20",'alt'=>"" )); ?>&nbsp;
			<?php echo $html->image("visa-logo.png" ,array('width'=>"33",'height'=>"23",'alt'=>"" )); ?><?php echo $html->image("mastercard-logo.png" ,array('width'=>"33",'height'=>"23",'alt'=>"" )); ?><?php echo $html->image("switch-card.png" ,array('width'=>"33",'height'=>"23",'alt'=>"" )); ?><?php echo $html->image("delta-card.png",array('width'=>"33",'height'=>"23",'alt'=>"" )); ?><?php echo $html->image("visa-electron-logo.png" ,array('width'=>"33",'height'=>"23",'alt'=>"" )); ?><?php echo $html->image("master-card-logo.png" ,array('width'=>"33",'height'=>"23", 'alt'=>"" )); ?><?php echo $html->image("paypal.png" ,array('width'=>"69",'height'=>"23", 'alt'=>"" )); ?><?php echo $html->image("google-logo.png" ,array('width'=>"50", 'height'=>"23" ,'alt'=>"" )); ?><?php echo $html->image("footer-cart-icon.png" ,array('width'=>"13" ,'height'=>"14", 'alt'=>"" )); ?></li>
		</ul>
	</div>
	<!--Footer Closed-->
</div>
<!--Footer Closed-->