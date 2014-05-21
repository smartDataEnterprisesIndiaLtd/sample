<style>
.blue-button-widget
{ padding-left:1px !important;}
</style>

<?php 
echo $javascript->link(array('behaviour.js','textarea_maxlen'));
echo $javascript->link(array('jquery-1.3.2.min','lib/prototype'));
echo $javascript->link('fancybox/jquery.fancybox-1.3.1.pack.js');
echo $javascript->link('fancybox/jquery.easing-1.3.pack.js');
echo $javascript->link('fancybox/jquery.mousewheel-3.0.2.pack.js');
echo $html->css('jquery.fancybox-1.3.1.css');

echo $form->create('Certificate',array('action'=>'add_review','method'=>'POST','name'=>'frmReview','id'=>'frmReview'));
?>
<ul class="pop-con-list">
	<?php 
	if ($session->check('Message.flash')){ ?>
	<div >
		<div class="messageBlock"><?php echo $session->flash();?></div>
	</div>
	<?php } ?>
	
	<?php
		if(!empty($errors)){
			if(count($errors)==1 && !empty($errors['review_type'])){
				$error_meaasge=$errors['review_type'];
			}else{
				$error_meaasge="Please add some information in the mandatory fields highlighted red below.";
			}
			?>
			<div class="error_msg_box"> 
				<?php echo $error_meaasge;?>
			</div>
	<?php }?>

	<li>
		<h4 class="bl-color">Write a Review</h4>
	</li>
	<li>
		<span class="larger-font"><strong>Item:</strong></span> Gift certificate<?php //echo $this->data['Certificate']['product_name'];?>
	</li>
	<li>
		<?php if($overall_reviews == 'Positive'){
			$class = 'grn-color';
		} if($overall_reviews == 'Neutral'){
			$class = 'gr-colr';
		} if($overall_reviews == 'Negative'){
			$class = 'red-color-text';
		}?>
		<strong>Overall</strong> <span class="<?php echo $class?>"><?php echo $html->image("popup/flag.gif" ,array('width'=>"19",'height'=>"18", 'alt'=>"" )); ?> <strong><?php echo $overall_reviews;?></strong></span> <span class="padng-lft smlr-fnt"><?php echo $html->link('Review '.$total_count_selected,'#',array('escape'=>false,'class'=>'gr-colr text-decoration-none'/*,'onClick'=>'golink(\'/pages/view/user-agreement\');'*/));?></span>
	</li>
	<li class="smlr-fnt">
		<?php echo $html->link('Click here','#',array('escape'=>false,'class'=>'text-decoration-none'/*,'onClick'=>'golink(\'/pages/view/user-agreement\');'*/));?> for tips on how to write great reviews.
	</li>
	<li>
		<strong>Select a review type:</strong>
		<span class="grn-color">
		<?php
		$options=array('2'=>'<strong>Positive</strong></span>','0'=>'<span class="red-color-text"><strong>Negative</strong></span>','1'=>'<span class="gr-colr"><strong>Neutral</strong></span>');
		$attributes=array('legend'=>false,'class'=>'checkbox-wid','div'=>false);
		echo $form->radio('Certificate.review_type',$options,$attributes);
		//echo $form->error('Certificate.review_type'); ?>
	</li>
	<li>
		<p><strong>Write your comments:</strong> <span class="gr-colr smlr-fnt">(Maximum 3000 characters)</span></p>
		<p class="margin">
		<?php if(!empty($errors['comments'])){
				$errorComments='textfield error_message_box';
			}else{
				$errorComments='textfield';
			}
		?>
		<?php echo $form->input('Certificate.comments',array('size'=>'30','label'=>false,'class'=>$errorComments,'rows'=>'5','cols'=>'45','div'=>false,'maxlength'=>3000,'style'=>'width:346px','error'=>false)); //echo $form->error('Certificate.comments'); ?></p>
		<p class="smlr-fnt"><strong>Please note:</strong> do not include any website links, if you wish to refer to another project on Choiceful.com enter its Quick Code. All  reviews are periodically checked and Choiceful.com reserves the right to remove/edit any part of this content if it does not comply with our <?php echo $html->link('user agreement','#',array('escape'=>false,'onClick'=>'golink(\'/pages/view/user-agreement\');'));?>.</p>
	</li>
	<li>
		<div class="blue-button-widget">
		<?php echo $form->button('Submit Review',array('type'=>'submit','class'=>'blue-btn','div'=>false));?></div>
	</li>
</ul>
<?php
echo $form->end();
?>