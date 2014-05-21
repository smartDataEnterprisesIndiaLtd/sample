<?php
?>
<!--Questions &amp; Answers Start-->
<div class="row no-pad-btm">
	<!--FBTogether Start-->
	<div class="fbtogether">
		<h4 class="mid-gr-head blue-color"><span>Questions &amp; Answers</span></h4>
		<div class="tec-details">
			<?php
			if(!empty($logg_user_id))
						$ask_question_link = '/products/add_question/'.$product_details['Product']['id'].'/'.$product_details['Product']['quick_code'].'/'.$product_details['Product']['product_name'];
					else
						$ask_question_link = '/users/sign_in/';
			?>
			<p><?php echo $html->link('Ask a question',$ask_question_link,array('escape'=>false,'class'=>'underline-link ansque'));?></p>
			<?php if(!empty($product_details['ProductQuestion'])) { ?>
			<ul class="faq-sec">
				<?php foreach($product_details['ProductQuestion'] as $pro_que){?> 
				<li>
					<p><span class="red-color pad-rt larger-font"><strong>Q</strong></span><?php echo $this->Common->currencyEnter($pro_que['question']);?> 
					<?php
					if(!empty($logg_user_id))
							$ans_question_link = '/products/answer_question/'.$pro_que['id'];
						else
							$ans_question_link = '/users/sign_in/';
					?>
					<?php echo $html->link('Answer Question',$ans_question_link,array('escape'=>false,'class'=>'smalr-fnt underline-link ansque'));?></p>
					<?php if(!empty($pro_que['ProductAnswer'])){?>
					<?php foreach($pro_que['ProductAnswer'] as $answer) {
						$this->set('ans_id',$answer['id']); ?>
					<p><span class="red-color pad-rt larger-font"><strong>A</strong></span> <?php echo $this->Common->currencyEnter($answer['answer']);?> <?php echo $html->image("smiley.png",array('width'=>"10",'height'=>"9", 'alt'=>"" ,'class'=>'img')); ?></p>
					<p id = <?php echo "voteans_".$answer['id'];?>>
					<?php echo $this->element('/product/vote_ans');?></p>
					<?php }?>
					<?php }?>
				</li>
				<?php }?>
			</ul>
			<?php }?>
		</div>
	</div>
	<!--FBTogether Closed-->
</div>
<!--Questions &amp; Answers Closed-->