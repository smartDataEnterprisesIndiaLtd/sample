<?php 
$page_is = $this->params['pass'][0];

//$titleArr = array('how-it-works'=>'How it works?','marketplace-pricing'=>'Pricing','international-sellers'=>'International Sellers','marketplace-user-agreement'=>'Seller User Agreement','faqs'=>'FAQs','choiceful-marketplace-sellers-guide'=>'Seller\'s Guide');

$titleArr = array('how-it-works'=>'How it works?','marketplace-pricing'=>'Selling Fees','international-sellers'=>'International Marketplace Stores','marketplace-user-agreement'=>'Marketplace User Agreement','faqs'=>'Marketplace FAQs','choiceful-marketplace-sellers-guide'=>'Marketplace Seller\'s Guide');

if(array_key_exists($page_is,$titleArr))
	$display_title = $titleArr[$page_is];
else
	
	$display_title = '';
?>
<!--mid Content Start-->
<div class="mid-content">
<!--	<div class="breadcrumb-widget"><?php //echo $html->link('Home',"/",array('escape'=>false,'class'=>'underline-link'));?> &gt; <?php //echo $html->link('Sell on Choiceful',array('controller'=>'marketplaces','action'=>'view','how-it-works'),array('escape'=>false,'class'=>'underline-link'));?> &gt; <span><?php //echo $display_title;?></span></div> -->

<div class="breadcrumb-widget" style="padding:4px 0px;"></div>

	<?php
	$class ='';
	if ($session->check('Message.flash')){ ?>
		<div class="messageBlock">
			<?php echo $session->flash();?>
		</div>
	<?php } ?>
	<?php if($page_is == 'how-it-works'){ ?>
		<h2 class="markt-heading margin-bottom"><span>Welcome to the Choiceful.com Marketplace where merchants like you sell their products to millions of customers all for free.</span></h2>
	<?php } elseif($page_is == 'faqs'){ ?>
			<h2 class="markt-heading margin-bottom dif-col-blu-code">Frequently Asked Questions</h2>
	<?php } else if($page_is == 'choiceful-marketplace-sellers-guide') {
		$class="sellers-guide";
		?> <!--margin-bottom border-bottom pad-btm --->
		<h2 class="margin-bottom border-bottom pad-btm"><span>Choiceful Marketplace Seller's Guide.</span></h2>
	<?php } else if($page_is == 'marketplace-user-agreement') { ?>
		<h2 class="margin-bottom border-bottom pad-btm"><span>Choiceful Marketplace User Agreement.</span></h2>
	<?php } else {?>
		<h2 class="markt-heading margin-bottom"><span><?php print $this->data['Page']['title'];?></span></h2>
	<?php }?>
	<div class="inner-content seller_guide">
		<?php if($page_is == 'how-it-works'){ ?>
		<!--Steps Start-->
		<div class="resi-steps margin-bottom">
			<ul>
				<li><?php echo $html->image("step1-img.jpg" ,array('width'=>"155",'height'=>"150" ,'alt'=>"" )); ?></li>
				<li class="arrow-widget"><?php echo $html->image("green-arrow.jpg" ,array('width'=>"29",'height'=>"24" ,'alt'=>"" )); ?></li>
				<li><?php echo $html->image("step2-img.jpg" ,array('width'=>"155",'height'=>"150" ,'alt'=>"" )); ?></li>
				<li class="arrow-widget"><?php echo $html->image("green-arrow.jpg" ,array('width'=>"29",'height'=>"24" ,'alt'=>"" )); ?></li>
				<li><?php echo $html->image("step3-img.jpg" ,array('width'=>"155",'height'=>"150" ,'alt'=>"" )); ?></li>
				<li class="arrow-widget"><?php echo $html->image("green-arrow.jpg" ,array('width'=>"29",'height'=>"24" ,'alt'=>"" )); ?></li>
				<li><?php echo $html->image("step4-img.jpg" ,array('width'=>"155",'height'=>"150" ,'alt'=>"" )); ?></li>
			</ul>           
		</div>
		<!--Steps Closed-->
		<p>
		<?php echo $html->link('<span><strong>Register Now to Become a Seller</strong></span>',array('controller'=>'sellers','action'=>'choiceful-marketplace-sign-up'),array('escape'=>false, 'class'=>'larger-green-btn'));?>
		<!--<a href="#" class="larger-green-btn"><span><strong>Register Now to Become a Seller</strong></span></a>--></p>
		<!--Why Sell on Choiceful.. Start-->
		<h2 class="lt-gray head-arrow-bg">Why Sell on Choiceful.com Marketplace?</h2>
		<ul class="market-place-list">
			<li>No listing fees. When an item is sold, sellers pay a <b>fixed percentage</b> of the product price per item sold.<!--<a href="#" class="underline-link">-->
			<?php echo $html->link('Find out more',array('controller'=>'pages','action'=>'view','selling-fees'),array('escape'=>false, 'class'=>'underline-link'));?>
			</li>
			<li>Gain access to tens of millions of buyers.</li>
			<li>List and manage your inventory easily with our automated selling tools.</li>
			<li>Partner with a proven and stable ecommerce veteran.</li>
			<li>Negotiate and sell more using Make Me an Offer<sup>TM</sup>    </li>
			<li>Advertise your business and brand throughout the purchasing process.</li>
			<li>Use our standard pricing and marketing tools to secure the lowest price and best deal to all customers.</li>
			<li>Access powerful seller reports any time to enhance your profitability and sales record.</li>
			<li>Upload new products and enhance sales. <?php echo $html->link('Learn more',array('controller'=>'pages','action'=>'view','add-your-products-to-choiceful'),array('escape'=>false, 'class'=>'underline-link'));?></li>
		</ul>
			<!--Why Sell on Choiceful.. Closed-->
		<h4 class="gr-bg-head"><span>How it works</span></h4>
		<ul class="steps-widget">
			<li>
				<div class="step-number">1</div>
				<div class="step-content">
					<p><strong>Step1</strong> <span class="choiceful"><strong>Upload your product inventory</strong></span></p>
					<p>It doesn't matter if you're a smaller seller, or larger, we have the seller tools to make listing your products really easy.</p>
				</div>
			</li>
			<li>
				<div class="step-number">2</div>
				<div class="step-content">
					<p><strong>Step2</strong> <span class="choiceful"><strong>Customers browse through and buy your products</strong></span></p>
					<p>Millions of customers visit the Choiceful.com website, view which products they looked at the most and bought using seller reports. </p>
				</div>
			</li>
			<li>
				<div class="step-number">3</div>
				<div class="step-content">
				<p><strong>Step3</strong> <span class="choiceful"><strong>You deliver products to customers</strong></span></p>
				<p>Once you've received an order deliver the ordered products within the estimated delivery time for positive customer feedback</p>
				</div>
			</li>
			<li>
				<div class="step-number">4</div>
				<div class="step-content">
				<p><strong>Step4</strong> <span class="choiceful"><strong>Receive payment</strong></span></p>
				<p>Payments are deposited into your bank account, check your payment history and download reports at anytime using your seller account.</p>
				</div>
			</li>
		</ul>
		<?php } else if($page_is == 'marketplace-pricing' || $page_is == 'international-sellers' || $page_is == 'marketplace-user-agreement'){ ?>
		<div class="inner-content">
			<?php if($page_is == 'marketplace-pricing' || $page_is == 'international-sellers') { ?>
			<h4 class="gr-bg-head"><span>
				<?php if($page_is == 'marketplace-pricing') { ?>
					Pricing 
				<?php }  else if($page_is == 'international-sellers') { ?>
					International Sellers 
				<?php } else { } ?></span></h4>
			<?php }?>
			<div class="margin-top">
				<?php if( !empty($this->data['Page']['description'])) echo $this->data['Page']['description']; ?>
			</div>
		</div>

		<?php } /* else if(){ ?>
		<div class="inner-content">
			<h4 class="gr-bg-head"><span>
				<?php if($page_is == 'marketplace-pricing') { ?>
					Pricing 
				<?php }  else if($page_is == 'international-sellers') { ?>
					International Sellers 
				<?php } else { } ?></span></h4>
			<div class="margin-top">
				<?php if( !empty($this->data['Page']['description'])) echo $this->data['Page']['description']; ?>
			</div>
		</div>

		<?php }*/ elseif($page_is == 'faqs'){ ?>
			<?php if(!empty($allfaqs)){?>
			<ul class="help-links">
				<?php foreach($allfaqs as $faq){
				$divid = "answer_".$faq['Faq']['id'];
				$question = $faq['Faq']['question'];
				?>
					<li><?php echo $html->link($question,"javascript:void(0);",array('onclick'=>"displayanswer('".$divid."')",'escape'=>false)); ?>
					<div style="display:none" id = "<?php echo 'answer_'.$faq['Faq']['id'];?>">
						<div class="ans">
						<div class="content-list faq_ans">
							<?php echo $faq['Faq']['answer']?></div>
						</div>
						<div class="x-closed"><?php echo $html->link('x close',"javascript:void(0);",array('onClick'=>'hideanswer("answer_'.$faq['Faq']['id'].'")'));?></div>
					</div>
					</li>
				<?php }?>
			</ul>
			<?php }?>
			<script type="text/javascript">
				function displayanswer(answerid){
					jQuery('#'+answerid).css('display','block');
				}
			
				function hideanswer(answerid){
					jQuery('#'+answerid).css('display','none');
				}
			</script>
		<?php } else {
			echo "<div class='{$class}'>";
			print $this->data['Page']['description'];
			echo "</div>";
		}?>
	</div>
	<!--Inner Content Closed-->
</div>
<!--mid Content Closed-->
