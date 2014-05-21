<?php //echo $javascript->link(array('lib/prototype'),false);?>
<script defer="defer" type="text/javascript" src="/js/lib/prototype.js"></script>
<div class="tec-details">
	<ul style="padding-top:10px;">
	<li class="revwhead orange-col-head boldr applprdct">Q&amp;A
		<?php
			//$ask_question_link = '/products/add_question/'.$product_details['Product']['id'].'/'.$product_details['Product']['quick_code'].'/'.$product_details['Product']['product_name'];
		?>
		<?php echo $html->link('Ask a Question','javascript:void(0)',array('onclick'=>'addQusetion('.$product_details['Product']['id'].')','escape'=>false,'class'=>'underline-link ansque'));?>
	</li>
	</ul>
	
	<?php if(!empty($product_details['ProductQuestion'])) { ?>
		<ul class="faq-sec">
		<?php foreach($product_details['ProductQuestion'] as $pro_que){?>
			<li><p><span class="drkred font13"><strong>Q</strong></span>
			<?php echo $pro_que['question'];?> 
				<?php
				//$ans_question_link = '/products/answer_question/'.$pro_que['id']; ?>
				<?php echo $html->link('Answer Question','javascript:void(0)',array('onclick'=>'giveAnswer('.$pro_que['id'].')','escape'=>false,'class'=>'font11 underline-link'));?>
					
			<!--<a href="#" class=" font11 underline-link">Answer Question</a>-->
			</p>
			<?php if(!empty($pro_que['ProductAnswer'])){?>
			<?php foreach($pro_que['ProductAnswer'] as $answer) {
				$this->set('ans_id',$answer['id']); ?>
				<p><span class="drkred pad-rt larger-font"><strong>A</strong></span>

				<?php echo $answer['answer']; ?> <?php echo $html->image("smiley.png",array('width'=>"10",'height'=>"9", 'alt'=>"" ,'class'=>'img')); ?>
					
					<img src="images/smiley.png" width="10" height="9" alt="" class="img" /></p>
				<p class="reviewer-count"><!--<span class="gray">0 People found this helpful. Did you?</span>-->
					<span id = <?php echo "voteans_".$answer['id'];?>>
						<?php echo $this->element('/mobile/product/vote_ans');?>
					</span>
				</p>
				<?php }?>
				<?php }?>
			</li>
		<?php }?>
		</ul>
	<?php }?>
</div>
<script defer="defer" type="text/javascript">
var SITE_URL = "<?php echo SITE_URL; ?>";
 // function to like add a question
function addQusetion(pro_id){
	var postUrl = SITE_URL+'products/add_question/'+pro_id;
	jQuery('#plsLoaderID').show();
	jQuery.ajax({
		cache:false,
		async: false,
		type: "GET",
		url: postUrl,
		success: function(msg){
		/** Update the div**/
		jQuery('#tab4').html(msg);
		jQuery('#plsLoaderID').hide();
	}
	});
}
//Function to give answer
function giveAnswer(pro_id){
	var postUrl = SITE_URL+'products/answer_question/'+pro_id;
	jQuery('#plsLoaderID').show();
	jQuery.ajax({
		cache:false,
		async: false,
		type: "GET",
		url: postUrl,
		success: function(msg){
		/** Update the div**/
		jQuery('#tab4').html(msg);
		jQuery('#plsLoaderID').hide();
	}
	});
}
</script>
