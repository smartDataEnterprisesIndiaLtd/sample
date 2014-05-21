<?php 
echo $form->create('Review',array('action'=>'add','method'=>'POST','name'=>'frmReview','id'=>'frmReview'));
?>
<style>
.messageBlock {
    color: red;
    font-family: Verdana,Arial,Helvetica,sans-serif;
    font-weight: bold;
    margin: 0;
    width: 99%;
}
</style>
<ul>
<li class="orange-col-head boldr">Reviews</li>

<?php 
if ($session->check('Message.flash')){ ?>
<li >
	<div class="messageBlock"><?php echo $session->flash();?></div>
		<!-- For Auto redirect of the product page-->
		<script type="text/javascript">
			setTimeout(function () {
			   location.reload(); // the redirect goes here
			},3000); 
		</script>
		
</li>
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


<?php if(empty($error)) {?>
<li>
<?php if($overall_reviews == 'Positive'){
			$class = 'green-color';
		} if($overall_reviews == 'Neutral'){
			$class = 'gr-colr';
		} if($overall_reviews == 'Negative'){
			$class = 'red-color-text';
		}?>
		<b>Overall</b>
		<span class="<?php echo $class?>">
			<?php echo $html->image("mobile/positive-icon.png" ,array('width'=>"19",'height'=>"18", 'alt'=>"" ,'style'=>"margin-bottom: -3px;")); ?>
			<strong>
				<?php echo $overall_reviews;?>
			</strong>&nbsp;&nbsp;
		</span>

		<span class="font11 gray">Reviews : <?php echo $total_count_selected;?></span></li>
    
		<li class="applprdct slctrviw"><b>Select review:</b>
		<?php
		$options=array('2'=>'<label class="green-color boldr">Positive</label>','0'=>'<label class="drkred boldr"> Negative</label>','1'=>'<label class="gray boldr">Neutral</label>');
		$attributes=array('legend'=>false,'class'=>'checkbox-wid','div'=>false,'error'=>false,'onClick'=>'setFocusto(this.value);');
		echo $form->radio('Review.review_type',$options,$attributes);
		?>
</li>

	<li><b>Write your comments:</b> <span class="gray font11">(Maximum 3000 characters)</span>
	<?php if(!empty($errors['comments'])){
				$errorComments='qatxtarea error_message_box';
			}else{
				$errorComments='qatxtarea';
			}
		?>
	<?php echo $form->input('Review.comments',array('size'=>'30','label'=>false,'class'=>$errorComments,'rows'=>'5','cols'=>'45','div'=>false,'error'=>false,'maxlength'=>3000));?>
	</li>
	<li class="font11"><b>Please note:</b> do not include any website links, if you wish to refer to another product on Choiceful.com enter the Quick Code. All reviews are periodically checked and Choiceful.com reserves the right to remove/edit any part of this content if it does not comply with our <?php echo $html->link('user agreement','/pages/view/conditions-of-use',array('escape'=>false,));?>.</li> 
	<li>
		<?php echo $form->hidden('Review.product_id',array('size'=>'30','type'=>'text','maxlength'=>30,'label'=>false,'class'=>'textfield','div'=>false));?><?php echo $form->hidden('Review.product_code',array('size'=>'30','type'=>'text','maxlength'=>30,'label'=>false,'class'=>'textfield','div'=>false));?><div class="blue-button-widget">
		
		<?php $options=array(
			"url"=>"/reviews/add","before"=>"",
			"update"=>"tab4",
			"indicator"=>"plsLoaderID",
			'loading'=>"Element.show('plsLoaderID')",
			"complete"=>"Element.hide('plsLoaderID')",
			"class" =>"bluggradbtn style='font-size:13px;'",
			"type"=>"Submit",
			"id"=>"addreview",
			"div"=>"false",
		);?>
		<?php echo $ajax->submit('Submit Review',$options);?>
	</li>
<?php }?>
</ul>
<?php
echo $form->end();
?>
<script type="text/javascript">
function setFocusto(value_field){
	if(value_field != ''){
		jQuery('#ReviewComments').focus();
	}
}
</script>