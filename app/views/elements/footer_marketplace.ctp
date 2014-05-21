<?php
if(isset($this->params['pass'][0]) && !empty($this->params['pass'][0])){
	$page_is = $this->params['pass'][0];
	}
else {
	$page_is = '';
}


?>
<div id="footer-sml">

<!-- breadcrumbs add on 21st feb-2013-->

<?php if(($this->params['controller']=='marketplaces') && ($this->params['action']=='view')){?>
	<div class="footer-breadcrumb-widget marketp">
	 <?php
	        echo "<div class='crumb_text_break'><strong>You are here:</strong>";
		echo $html->link($html->image('/img/star_c.png', array("alt"=>"Choiceful.com",'class'=>'star_c')),'/',array('escape'=>false));
		echo " </div><div class='crumb_img_break'> > " ;
		
		
				if($page_is=='how-it-works'){
			$this->Html->addCrumb('Choiceful.com Marketplace', '');
			}
		
			else if($page_is=='marketplace-pricing'){
			$this->Html->addCrumb('Choiceful.com Marketplace', '/marketplaces/view/how-it-works');
			$this->Html->addCrumb('Selling Fees', '');
			}
			
			else if($page_is=='international-sellers'){
			$this->Html->addCrumb('Choiceful.com Marketplace', '/marketplaces/view/how-it-works');
			$this->Html->addCrumb('International Marketplace Stores', '');
			}
			
			else if($page_is=='marketplace-user-agreement'){
			$this->Html->addCrumb('Choiceful.com Marketplace', '/marketplaces/view/how-it-works');
			$this->Html->addCrumb('Marketplace User Agreement', '');
			}
			
			else if($page_is=='faqs'){
			$this->Html->addCrumb('Choiceful.com Marketplace', '/marketplaces/view/how-it-works');
			$this->Html->addCrumb('Marketplace FAQs', '');
			}
			
			else if($page_is=='choiceful-marketplace-sellers-guide'){
			$this->Html->addCrumb('Choiceful.com Marketplace', '/marketplaces/view/how-it-works');
			$this->Html->addCrumb("Marketplace Seller's Guide", '');
			}
			
		
		echo $this->Html->getCrumbs(' > ' , '');
		echo "</div>" ;
		?>
	</div>
	<?php } ?>


<!--ends-->

	<!--Footer Links widget Start-->
	<div class="footer-links-wdgt">
		<ul>
		<li><?php echo $html->link('About Choiceful',array('controller'=>'pages','action'=>'view','about-choiceful'),array('escape'=>false));?> |</li>
		<li><?php echo $html->link('Privacy Notice',array('controller'=>'pages','action'=>'view','privacy-policy'),array('escape'=>false));?> |</li>
		<li><?php echo $html->link('Conditions of Use',array('controller'=>'pages','action'=>'view','conditions-of-use'),array('escape'=>false));?> |</li>
		<li><?php echo $html->link('Calculating Fees',array('controller'=>'pages','action'=>'view','selling-fees'),array('escape'=>false));?> |</li>
		<li><?php echo $html->link('My Seller Account',array('controller'=>'sellers','action'=>'my_account'),array('escape'=>false));?> |</li>
		<li><?php echo $html->link('Payment',array('controller'=>'sellers', 'action'=>'payment_summary'),array('escape'=>false));?> |</li>
		<li><?php echo $html->link('Communication Center',array('controller'=>'messages','action'=>'sellers'),array('escape'=>false));?></li>
		</ul>
	</div>
	<!--Footer Links widget Closed-->
	<!--Footer Start-->
	<div class="footer">
		<p>
			<?php echo $html->image('fotter_icon_img.gif', array('alt'=>'') ); ?>
			<span class="choiceful">
		
		<strong>Choiceful Buying Guarantee</strong></span> <span class="blk-color"><strong>Sell with 100% Confidence</strong></span>
		<?php echo $html->link('Learn more',array('controller'=>'pages','action'=>'view','buy-confidence-guarantee'),array('escape'=>false,'class'=>'underline-link smalr-fnt'));?></p>
		<span class="gray">Copyright &copy; 1999 - <?php echo date("Y");?> Choiceful.com All Rights Reserved. Designated trademarks and brands are the property of their respective owners. Use of this website constitutes acceptance of the Choiceful.com <?php echo $html->link('user agreement',array('controller'=>'pages','action'=>'view','marketplace-user-agreement'),array('escape'=>false,'class'=>'underline-link'));?> and  <?php echo $html->link('privacy policy',array('controller'=>'pages','action'=>'view','privacy-policy'),array('escape'=>false,'class'=>'underline-link'));?> </span>
	</div>
	<!--Footer Closed-->

</div>
<!--Footer Closed-->

<?php echo $javascript->link("settxt_focus"); ?>
<script type="text/javascript">
f_setfocus();
</script>