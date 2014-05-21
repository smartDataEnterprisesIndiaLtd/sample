<?php echo $javascript->link(array('jquery')); ?>
<script>
jQuery(document).ready(function()  {
	//disable submit button after one click
	jQuery('#clickOnce').click(function(){
		if((jQuery("#OrderReason").val() != "")&&(jQuery("#OrderComment").val() != ""))
		{
			jQuery('#frmVerify').submit();
			jQuery("#clickOnce").attr("disabled", "true");
			
		}
	});
});

function fancyboxclose(rurl){
	var site_url = '<?php echo SITE_URL;?>';
	parent.jQuery.fancybox.close();
	window.parent.location.href=site_url+rurl;
}
</script>


<?php ?>
<style>
.error-message {
	line-height:18px;
}
</style><?php echo $form->create('Order',array('action'=>'file_a_claim','method'=>'POST','name'=>'frmVerify','id'=>'frmVerify')); ?>
<ul class="pop-content-list">
	<?php if ($session->check('Message.flash')) { ?>
	<li><div  class="messageBlock"><?php echo $session->flash();?></div></li>
	<?php } ?>
	<li><h4 class="orange-color-text"><span class="grn-color">File a Claim</span></h4></li>
	<?php if(!empty($errors)){?>
	<li>
		<div class="error_msg_box"> 
			Please complete the mandatory fields highlighted below.
		</div>
	</li>
	<?php }?>                          
	<li>
		<p><span class="smlr-fnt orange-color-text">Contact Choiceful.com to file a claim against a seller.</span></p>
		<p><span class="bl-clr"><strong>
		<?php //echo $html->link('Click here to read our 100% Buyer Protection Guarantee.',array('controller'=>'pages','action'=>'view','buy-confidence-guarantee'),array('escape'=>false,'class'=>'bl-clr text-decoration-none'));?>
		<a href="javascritp:void(0);" onclick ="fancyboxclose('pages/view/buy-confidence-guarantee')">Click here to read our 100% Buyer Protection Guarantee.</a>
		</strong></span></p>
    <p><span class="larger-font"><strong>Item:</strong></span> <?php echo $prod_name; ?></p>
		<p class="margin"><span class="larger-font"><strong>Seller:</strong></span>
		<?php $seller_name_link = str_replace(array(' ','&'),array('-','and'),html_entity_decode($seller_name, ENT_NOQUOTES, 'UTF-8'));?>
		<a href="javascritp:void(0);" onclick ="fancyboxclose('sellers/<?php echo $seller_name_link;?>/summary/<?php echo $seller_id;?>/<?php echo $prod_id; ?>')"><?php echo $seller_name; ?></a></p>
		
	</li>
	<li><p><strong>Select a reason:</strong> </p>
		<p class="margin">		
		<?php 
			if(($form->error('Order.reason'))){
				$errorClass='textfield error_message_box';
			}else{
				$errorClass='textfield';
			}
		echo $form->select('Order.reason',$claim_reason,$selected_reason,array('class'=>$errorClass, 'type'=>'select','style'=>'margin-right:5px;'),'Choose a reason'); ?><?php if(!($form->error('Order.reason')))
			//echo '<br>'; else echo $form->error('Order.reason');?></p>
	</li>
		
	<li><p>Please provide as much detail as possible regarding your claim</p>
		<p><strong>Comments:</strong></p>
		<p class="margin"><?php 
		if(($form->error('Order.comment'))){
				$errorClass='textfield error_message_box';
			}else{
				$errorClass='textfield';
			}
		echo $form->input("Order.comment",array("label"=>false,"div"=>false,'rows'=>5,'maxlength'=>'', 'cols'=>45, 'class'=>$errorClass ,'error'=>false,'style'=>'width:415px')); ?></p>
		<p class="smlr-fnt"><strong>What happens next:</strong> we contact the seller on your behalf to resolve the issues raised. Please allow up to 7 days for us to respond to your claim. Read our helpful article on
		<a href="javascritp:void(0);" onclick ="fancyboxclose('pages/view/filing-a-claim-against-a-seller')">How to File a Claim</a> for more information.
		</p>
	</li>
	<li>
		<?php
			echo $form->hidden('Order.seller_id',array('class'=>'textbox','label'=>'', 'value'=>$seller_id, 'div'=>false));
			echo $form->hidden('Order.prod_id',array('class'=>'textbox','label'=>'', 'value'=>$prod_id, 'div'=>false));
			echo $form->hidden('Order.item_id',array('class'=>'textbox','label'=>'', 'value'=>$order_item_id, 'div'=>false));
			
			echo $form->hidden('Order.prod_name',array('class'=>'textbox','label'=>'', 'value'=>$prod_name, 'div'=>false));
			echo $form->hidden('Order.seller_name',array('class'=>'textbox','label'=>'', 'value'=>$seller_name, 'div'=>false));
		?>
		<div class="grn-button-widget"><?php echo $form->button('Submit',array('type'=>'submit','class'=>'grn-btn','div'=>false,'id'=>'clickOnce'));?></div>
	</li>
</ul>
<?php echo $form->end();?>