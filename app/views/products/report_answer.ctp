<style type="text/css" >
.blue-button-widget { padding-left: 0px !important; }
</style>
<?php echo $javascript->link(array('jquery')); ?>
<script>
jQuery(document).ready(function()  {
	//disable submit button after one click
	jQuery('#clickOnce').click(function(){
		if(jQuery("#ProductReason").val() != "")
		{
			jQuery('#frmProduct').submit();
			jQuery("#clickOnce").attr("disabled", "true");
			
		}
	});
});

</script>

<?php echo $javascript->link(array('behaviour.js','textarea_maxlen'));
echo $form->create('Product',array('action'=>'report_answer','method'=>'POST','name'=>'frmProduct','id'=>'frmProduct'));
?>
<ul class="pop-con-list">                    
	<?php 
	if ($session->check('Message.flash')){ ?>
	<div >
		<div class="messageBlock"><?php echo $session->flash();?></div>
	</div>
	<?php }
	?>
	 
	<li style="padding-bottom:10px;">
		<?php echo $html->image("popup/flag.gif" ,array('width'=>"29",'height'=>"23", 'alt'=>"", 'class'=>"img",'align'=>"right" )); ?>
		<h4 class="red-color-text">Reporting a Violation</h4>
	</li>
	<?php if(!empty($errors)){?>
         <li>	
		<div class="error_msg_box"> 
			Please provide a reson below.
		</div>
	</li>
	<?php }?>
	<li>
		<p><strong>Please provide a short reason for your report:</strong></p>
		<p class="margin"><?php 
		if(($form->error('Product.reason'))){
			$errorClass='textfield error_message_box';
		}else{
			$errorClass='textfield';
		}
		echo $form->input('Product.reason',array('size'=>'30','label'=>false,'class'=>$errorClass,'rows'=>'5','cols'=>'45','maxlength'=>'1000','div'=>false,'showremain'=>"limitOne",'error'=>false,'style'=>'width:346px')); ?></p>
		<p>
			<div style="color:#7C7C7C;font-size:10px">Remaining characters: <span id ="limitOne"><?php if(!empty($this->data)){
				if(!empty($this->data['Product']['reason'])) { 
					
					$remain = 1000 - strlen($this->data['Product']['reason']);
					echo $remain;
				} else {
					echo '1000'; 
				} 
			} else { 
				echo '1000'; } ?></span>
			
			<span class="gr-colr smlr-fnt">(Maximum 1000 characters)</span>
			</div>

		</p>
		
	</li>
	<li>
		<?php echo $form->hidden('Product.id',array('size'=>'30','type'=>'text','maxlength'=>30,'label'=>false,'class'=>'textfield','div'=>false));
		echo $form->hidden('Product.question',array('size'=>'30','type'=>'text','maxlength'=>30,'label'=>false,'class'=>'textfield','div'=>false));
		echo $form->hidden('Product.answer',array('size'=>'30','type'=>'text','maxlength'=>30,'label'=>false,'class'=>'textfield','div'=>false));
		echo $form->hidden('Product.product_name',array('size'=>'30','type'=>'text','maxlength'=>30,'label'=>false,'class'=>'textfield','div'=>false));?>
		<div class="blue-button-widget margin-top"><?php echo $form->button('Submit Report',array('type'=>'submit','class'=>'blue-btn','div'=>false,'id'=>'clickOnce'));?></div>
	</li>
	
</ul>
<?php
echo $form->end();
?>
