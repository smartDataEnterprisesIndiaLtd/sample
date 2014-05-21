<?php ?>
<!--mid Content Start-->
<div class="mid-content">
	<?php
	if ($session->check('Message.flash')){ ?>
		<div class="messageBlock">
			<?php echo $session->flash();?>
		</div>
	<?php } ?>
	
	
	
	
	<!--Tabs Content Widget Start-->
	<div class="tbs-con-widget">
		<?php if( is_array($faqsArr)  && count($faqsArr) > 0 ){ ?>
			
			<p class="gray larger-font"><strong> FAQs </strong></p>
			<ul class="help-links">
				<?php
				foreach($faqsArr as $faq) { ?>
				<li><a href="#" onclick="showDiv('ans_<?php echo $faq['Faq']['id']; ?>')"> <?php echo $faq['Faq']['question']; ?></a>
				<div class="ans" id="ans_<?php echo $faq['Faq']['id']; ?>" style="display:none;">
					<?php echo $faq['Faq']['answer']; ?>
				</div>
				<div class="x-closed"><a href="#" onclick="hideDiv('ans_<?php echo $faq['Faq']['id']; ?>')">x close</a></div>
				</li>
				<?php  } ?>
			</ul>
			<?php } ?>
	</div>
	

</div>
<!--mid Content Closed-->
