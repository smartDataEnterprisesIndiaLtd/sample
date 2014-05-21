<?php echo $javascript->link(array('jquery')); ?>

<script>
jQuery(document).ready(function()  {
	//disable submit button after one click
	jQuery('#clickOnce').click(function(){
		if(jQuery("#CancelOrderReason").val() != "")
		{
			jQuery('#frmOrder').submit();
			jQuery("#clickOnce").attr("disabled", "true");
			
		}
	});
	
	jQuery("#openNewLink").click(function(event){
		event.preventDefault();
		window.parent.location.href = '<?php echo SITE_URL ?>pages/view/cancel-order';
                parent.jQuery.fancybox.close(); 
	});
});


		


/*
var err_msg_alert = '<?php //echo $errors ?>';
if((err_msg_alert != '') && (jQuery("#fancybox-content",parent.document).height() == 280))
{
	jQuery("#fancybox-content",parent.document).height(jQuery("#fancybox-content",parent.document).height()+60);
}
*/
</script>

<style>
.error-message {
	line-height:18px;
}
.select{
	float:left;width:195px;margin-right:5px;
}
</style>
<?php  echo $form->create('Order',array('action'=>'cancel','method'=>'POST','name'=>'frmOrder','id'=>'frmOrder'));
echo $javascript->link(array('behaviour.js','textarea_maxlen'));
?>
<ul class="pop-con-list" id="contenu">
	<?php
		if ($session->check('Message.flash')){ ?>
	<li>
		<div class="messageBlock"><?php echo $session->flash();?></div>
	</li>
	<?php }
	?>
	
	<?php	 if(!empty($errors)){
				$error_meaasge="Please add some information in the mandatory fields highlighted red below.";
			?>
		<div class="error_msg_box"> 
			<?php echo $error_meaasge;?>
		</div>
	<?php }?>
	
	<li><h4>Remove Item from your Order</h4></li>
	<li>
		<p><span class="smlr-fnt red-color-text">Remove items from orders not yet dispatched.</span></p>
		<p><span class="bl-clr"><strong>Cancelled items are refunded in full.</strong></span>
		 <?php echo $html->link('Find out more',array('controller'=>'pages','action'=>'view','cancel-order'),array('escape'=>false,'class'=>'smlr-fnt text-decoration-none', 'id'=>'openNewLink'))?>
		</p>
	</li>
	<li>
		<p><span class="larger-font"><strong>Item:</strong></span> <?php echo $pro_name; ?></p>
	</li>
	<li>
		<p><strong>Select a reason:</strong> </p>
		<p class="margin">
			<?php
				if(!empty($errors['reason'])){
					$errorReason='select textfield error_message_box';
				}else{
					$errorReason='select textfield';
				}
			?>
			<div style="float:none;padding-bottom:5px;"><?php echo $form->select('CancelOrder.reason',$reasons,null,array('class'=>$errorReason, 'type'=>'select'),'Choose a reason'); ?><?php if(!($form->error('CancelOrder.reason')))
		echo '<br>'; else echo '<br>'; //echo $form->error('CancelOrder.reason');?></div></p>
	</li>
	<li><p><strong>Comments(optional):</strong> <span class="gr-colr smlr-fnt">(Maximum 500 characters)</span></p>
		<p class="margin">
		<?php                                 
		echo $form->input('CancelOrder.comment',array('size'=>'30','label'=>false,'class'=>'textfield','rows'=>'5','cols'=>'45','maxlength'=>'500','div'=>false,'showremain'=>"limitOne",'error'=>false));
		echo $form->hidden('CancelOrder.order_item_id',array('type'=>'text'));
		echo $form->hidden('CancelOrder.order_id',array('type'=>'text'));
		echo $form->hidden('CancelOrder.seller_id',array('type'=>'text'));
		echo $form->hidden('CancelOrder.product_id',array('type'=>'text'));?></textarea></p>
		<div style="padding-bottom:2px;">
			<span style="color:#7C7C7C;font-size:10px;float:left;margin-right:5px">Remaining characters: <span id ="limitOne"><?php if(!empty($this->data)){
				if(!empty($this->data['Order']['comment'])) { 
					
					$remain = 500 - strlen($this->data['Order']['comment']);
					echo $remain;
				} else {
					echo '500'; 
				} 
			} else { 
				echo '500'; } ?></span></span><?php if(!($form->error('CancelOrder.comment')))
					echo '<br>'; else echo $form->error('CancelOrder.comment');?>
		</div>
	</li>
	<li><?php echo $form->submit('',array('type'=>'image','src'=>SITE_URL.'/img/cancel-item-btn.png','class'=>'','div'=>false,'id'=>'clickOnce'));?></li>
</ul>
<?php
echo $form->end();
?>