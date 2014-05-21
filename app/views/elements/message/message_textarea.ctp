<style>
.flashError{
	margin-top:0px;
}
</style>

<script>
jQuery(document).ready(function()  {
	//disable submit button after one click
	jQuery('#clickOnce').click(function(){
		jQuery('#frmAddMessage').submit();
		jQuery("#clickOnce").attr("disabled", "true");
	});
});
</script>

<!--Comment Widget Start-->
<?php if ($session->check('Message.flash')){ ?>
	<?php echo $session->flash();?>
<?php } ?>

<?php if(!empty($this->data['Message']['to_user_id'])) {
	echo $form->create('Message',array('action'=>'add_message','method'=>'POST','name'=>'frmAddMessage','id'=>'frmAddMessage'));
	?>
	<div class="comment-widget">
		<!--Row Start-->
		<div class="row-wid">
			<!--Comment Widget Left Start-->
			<div class="comment-widget-text">
				<ul>
					<li>Type your message in the box below. We will forward it to the seller.</li>
				</ul>
			</div>
			<!--Comment Widget Right Closed-->
		</div>
		<!--Row Closed-->
		<!--Row Start-->
		<div class="row-wid overflow-h">
			<ul>
				<li>Comments</li>
				<li>
					<?php echo $form->textarea("Message.message",array('style'=>'width:99%; height:90px; padding:0px;', "label"=>false,"div"=>false,'rows'=>5, 'cols'=>45, 'showremain'=>"limitOne", 'class'=>'form-textfield')); echo $form->error('Message.message'); ?>
				</li>
				<li>
					<div class="messsage-alert-left">Choiceful.com uses filtering technology to protect buyers and sellers and to identify possible fraud. Messages that fail this filtering - even if they are not fraudlent - will not be transmitted.</div>
					<div style="padding-right: 2px;" class="float-right">
						
						<?php //if(empty($this->data['Message']['to_user_id'])) {
							//echo $html->image('grn-btn-bg_disable.gif',array('alt'=>''));
							//echo $form->button('Submit',array('type'=>'button','class'=>'gray-bg-input-small','div'=>false));
						//} else{
							//echo $form->button('Submit',array('type'=>'submit','class'=>'blk-bg-input-small','div'=>false));
							/*$options=array(
								"url"=>"/messages/add_message","before"=>"",
								"update"=>"msg_area",
								"indicator"=>"plsLoaderID",
								'loading'=>"Element.show('plsLoaderID')",
								"complete"=>"Element.hide('plsLoaderID')",
								"class" =>"blk-bg-input-small",
								"type"=>"Submit",
								"id"=>"myMessage",
							);*/?>
							<?php //echo $ajax->submit('Submit',$options);
							echo $form->button('Submit',array('type'=>'submit','class'=>'blk-bg-input-small','div'=>false,'id'=>'clickOnce'));
						//}?>
					</div>
				</li>
			</ul>
		</div>
		<!--Row Closed-->
		<?php echo $form->hidden('Message.to_user_id',array('type'=>'text'));
		echo $form->hidden('Message.from_user_id',array('type'=>'text'));
		echo $form->hidden('Message.order_item_id',array('type'=>'text'));
		echo $form->hidden('Message.msg_id',array('type'=>'text','value'=>@$msg_id));?>
	</div>
	<?php echo $form->end(); ?>
	<!--Comment Widget Closed-->
	<!--Previous Message Start-->
	<div class="previous-message-widget">
		<!--Message Start-->
		<h4 class="yellow-heading sml-fnt inc-left">Previous Messages</h4>
		<ul class="previous-message1-sec">
			<?php
			if(!empty($prev_msgs)){
				foreach($prev_msgs AS $pKey=>$pVal){
				$messge_disp = 1;
				if($pVal['Message']['msg_from'] == 'S'){ ?>
					<li><strong>Your message to <?php echo $pVal['UserSummary']['firstname'].' '.$pVal['UserSummary']['lastname']; ?> on <?php echo date("d F Y h:i:s", strtotime($pVal['Message']['created'])); ?></strong></li>
				<?php } else if($pVal['Message']['msg_from'] == 'A') { 
					if($pVal['Message']['to_user_id'] != $this->Session->read('User.id')){
						$messge_disp = 0;
					}
					if(!empty($messge_disp)){
					?>
					<li><strong>Message from choiceful.com  on <?php if(!empty($pVal['Message']['created'])) echo date("j F Y ", strtotime($pVal['Message']['created'])); else echo '-'; ?></strong></li> <?php }?>
				<?php } else { ?>
					<li><strong>Message From <?php echo $pVal['FromUserSummary']['firstname'].' '.$pVal['FromUserSummary']['lastname']; ?> on <?php echo date("d F Y h:i:s", strtotime($pVal['Message']['created'])); ?></strong></li>
				<?php } ?>
			<?php if(!empty($messge_disp)){ ?>
			<li>Re: Order number <?php echo $ordetails['Order']['order_number'];?>, Item: <?php echo $html->link($ordetails['OrderItem']['product_name'],'/'.$this->Common->getProductUrl($ordetails['OrderItem']['product_id']).'/categories/productdetail/'.$ordetails['OrderItem']['product_id'],array('escape'=>false));?></li>
			<li class="message1">
				<?php //echo $this->Common->currencyEnter(wordwrap($pVal['Message']['message'], 80, "\n"));?>
				<?php echo $this->Common->currencyEnter($pVal['Message']['message'], "\n");?>
			</li>
			<?php }?>
			<?php } 
			} else { ?>
			<li><strong>No previous message found</strong></li>
			<?php } ?>
		</ul>
	</div>
	<!--Previous Message Closed-->
<?php } else{ ?>
	<div class="comment-widget">
		<!--Row Start-->
		<div class="row-wid">
			<!--Comment Widget Left Start-->
			<div class="comment-widget-text">
				<ul>
					<li>Select a message or contact buyer.</li>
				</ul>
			</div>
			<!--Comment Widget Right Closed-->
		</div>
	</div>
<?php }?>

<script>

var order_item_id = '';
 var userId = '';
<?php if(!empty($order_item_id)) {?>
order_item_id = <?php echo $order_item_id;?>;
<?php }?>
<?php if(!empty($this->data['Message']['to_user_id'])) {?>
userId = <?php echo $this->data['Message']['to_user_id'];?>;
<?php }?>
jQuery(document).ready(function(){
	if(order_item_id != ''){
		var ajax_url= SITE_URL+'messages/item_msgs/'+order_item_id;
		jQuery.ajax({
			url: ajax_url,
			success: function(msg){
			jQuery('#msg_area').html(msg);
		}
		});
	}

	if(userId == ''){
	} else{
		jQuery('#MessageMessage').focus();
	}
});
</script>