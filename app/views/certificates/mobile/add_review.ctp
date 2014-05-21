<?php 
//echo $javascript->link(array('behaviour.js','textarea_maxlen'));
echo $javascript->link(array('jquery-1.3.2.min','lib/prototype'));
echo $form->create('Certificate',array('action'=>'add_review','method'=>'POST','name'=>'frmReview','id'=>'frmReview'));
?>
 <ul>
 	<?php 
	if ($session->check('Message.flash')){ ?>
		<li><div class="messageBlock"><?php echo $session->flash();?></div></li>
		<script type="text/javascript">
			setTimeout(function () {
			location.reload(); 
			},3000); 					
		</script>
	<?php } ?>
	<li class="orange-col-head boldr">Review</li>
	
	
	<li class="vrallwrt"><b>Overall</b>
	<?php if($overall_reviews == 'Positive'){
			$class = 'green-color';
		} if($overall_reviews == 'Neutral'){
			$class = 'gr-colr';
		} if($overall_reviews == 'Negative'){
			$class = 'red-color-text';
		}?>
	<span class="<?php echo $class;?>">
		<img width="19" height="18" class="wrtpstv" alt="" src="
		<?php echo SITE_URL;?>img/mobile/<?php echo strtolower($overall_reviews);?>-icon.png" />
		<strong><?php echo $overall_reviews;?></strong>&nbsp;&nbsp;
	</span>
	<span class="font11 gray"><?php echo $html->link('Reviews : '.$total_count_selected,'#',array('escape'=>false,'class'=>'gr-colr text-decoration-none'));?></span></li>
	
	
	<li class="applprdct slctrviw"><b>Review:</b>
	<?php $options=array('2'=>'<label class="green-color boldr">Positive</label>','0'=>'<label class="drkred boldr">Negative</label>','1'=>'<label class="gray boldr">Neutral</label>');
		$attributes=array('legend'=>false,'class'=>'checkbox-wid','div'=>false);
		echo $form->radio('Certificate.review_type',$options,$attributes);
		echo $form->error('Certificate.review_type'); ?>
	      
	<li><b>Write your comments:</b> <span class="gray font11">(Maximum 3000 characters)</span>
	<?php echo $form->input('Certificate.comments',array('size'=>'30','label'=>false,'class'=>'qatxtarea','rows'=>'5','cols'=>'45','div'=>false,'maxlength'=>3000)); //echo $form->error('Certificate.comments'); ?>
	</li>
	<li class="font11"><b>Please note:</b> do not include any website link, if you wish to refer to another product on choiceful.com enter the Quick Code. All reviews are periodically checked and choiceful.com reserves the right to remove/edit any part of this content if it does not comply with our user agreement.</li> 
	<li>
		<?php $options=array(
			"url"=>"/certificates/add_review","before"=>"",
			"update"=>'tab3',
			'frequency' => 0.2,
			"indicator"=>"plsLoaderID",
			'loading'=>"Element.show('plsLoaderID')",
			"complete"=>"Element.hide('plsLoaderID')",
			"class" =>"bluggradbtn",
			"type"=>"Submit",
			"id"=>"addreview",
			"div"=>"false",
		);?>
		<?php echo $ajax->submit('Submit Review',$options);?>
	<?php //echo $form->button('Submit Review',array('type'=>'submit','class'=>'bluggradbtn','div'=>false));?>
	
	</div>
	<!--<input type="button" class="bluggradbtn" value="Submit Review" />--></li> 
</ul>
<?php
echo $form->end();
?>