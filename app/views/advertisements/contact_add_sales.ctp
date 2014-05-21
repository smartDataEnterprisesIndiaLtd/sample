<?php 
echo $javascript->link(array('behaviour.js','textarea_maxlen'));
echo $javascript->link(array('jquery-1.3.2.min','lib/prototype'));
echo $javascript->link('fancybox/jquery.fancybox-1.3.1.pack.js');
echo $javascript->link('fancybox/jquery.easing-1.3.pack.js');
echo $javascript->link('fancybox/jquery.mousewheel-3.0.2.pack.js');
echo $html->css('jquery.fancybox-1.3.1.css');

echo $form->create('Review',array('action'=>'add','method'=>'POST','name'=>'frmReview','id'=>'frmReview'));
?>
<ul class="pop-con-list">
	<?php 
	if ($session->check('Message.flash')){ ?>
	<div >
		<div class="messageBlock"><?php echo $session->flash();?></div>
	</div>
	<?php } ?>

	<li>
		<h4 class="bl-color">Write a Review</h4>
	</li>
	<li>
		<span class="larger-font"><strong>Item:</strong></span> <?php echo $this->data['Review']['product_name'];?>
	</li>
	<li>
		<?php if($overall_reviews == 'Positive'){
			$class = 'grn-color';
		} if($overall_reviews == 'Neutral'){
			$class = 'gr-colr';
		} if($overall_reviews == 'Negative'){
			$class = 'red-color-text';
		}?>
		<strong>Overall</strong> <span class="<?php echo $class?>"><?php echo $html->image("popup/flag.gif" ,array('width'=>"19",'height'=>"18", 'alt'=>"" )); ?> <strong><?php echo $overall_reviews;?></strong></span> <span class="padng-lft smlr-fnt"><a href="#" class="gr-colr text-decoration-none">Review <?php echo $total_count_selected;?></a></span>
	</li>
	<li class="smlr-fnt">
		<a href="#" class="text-decoration-none">Click here</a> for tips on how to write great reviews.
	</li>
	<li>
		<strong>Select a review type:</strong>
		<span class="grn-color">
		<?php
		$options=array('2'=>'<strong>Positive</strong></span>','0'=>'<span class="red-color-text"><strong>Negative</strong></span>','1'=>'<span class="gr-colr"><strong>Neutral</strong></span>');
		$attributes=array('legend'=>false,'class'=>'checkbox-wid','div'=>false);
		echo $form->radio('Review.review_type',$options,$attributes);
		echo $form->error('Review.review_type'); ?>
	</li>
	<li>
		<p><strong>Write your comments:</strong> <span class="gr-colr smlr-fnt">(Maximum 3000 characters)</span></p>
		<p class="margin"><?php echo $form->input('Review.comments',array('size'=>'30','label'=>false,'class'=>'textfield','rows'=>'5','cols'=>'45','div'=>false,'maxlength'=>3000)); //echo $form->error('Review.comments'); ?></p>
		<p class="smlr-fnt"><strong>Please note:</strong> do not include any website links, if you wish to refer to another project on Choiceful.com enter its Quick Code. All  reviews are periodically checked and Choiceful.com reserves the right to remove/edit any part of this content if it does not comply with our <a href="#">user agreement</a>.</p>
	</li>
	<li>
		<?php echo $form->hidden('Review.product_id',array('size'=>'30','type'=>'text','maxlength'=>30,'label'=>false,'class'=>'textfield','div'=>false));?><?php echo $form->hidden('Review.product_code',array('size'=>'30','type'=>'text','maxlength'=>30,'label'=>false,'class'=>'textfield','div'=>false));?><div class="blue-button-widget">
		<?php echo $form->button('Submit Review',array('type'=>'submit','class'=>'blue-btn','div'=>false));?></div>
	</li>
</ul>
<?php
echo $form->end();
?>