<?php ?>
<!--mid Content Start-->
<div class="mid-content">
	<?php
	if ($session->check('Message.flash')){ ?>
		<div class="messageBlock">
			<?php echo $session->flash();?>
		</div>
	<?php } ?>
	<h1 class="h1-head">Frequently Asked Questions</h1>
	<?php if(!empty($allfaqs)){?>
	<ul class="help-links">
		<?php
	
		foreach($allfaqs as $faq){
		$divid = "answer_".$faq['Faq']['id'];
		$question = $faq['Faq']['question'];
		?>
			<li><?php echo $html->link($question,"javascript:void(0);",array('onclick'=>"displayanswer('".$divid."')",'escape'=>false));
			?>
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
	
	<?php
	if(!empty($faqCategoryArr)){ ?>
		<h3 class="h3-head-pad">FAQs</h3>
		<ul class="help-links">
			<?php foreach($faqCategoryArr as $faq_cat_id =>$faq_cat){ ?>
				<li><?php echo $html->link($faq_cat,'/faqs/view/'.$faq_cat_id,array('escape'=>false));?></li>
			<?php }?>
		</ul>
	<?php } ?>
</div>
<!--mid Content Closed-->
<script type="text/javascript">
	function displayanswer(answerid){
		jQuery('#'+answerid).css('display','block');
	}

	function hideanswer(answerid){
		jQuery('#'+answerid).css('display','none');
	}
</script>