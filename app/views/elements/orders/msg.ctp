<?php echo $javascript->link(array('jquery'));
echo $javascript->link(array('behaviour','textarea_maxlen'));
?>

<?php
$seller_id = $this->Session->read('User.id');
$msg_flg = 0;
echo $form->create('Order',array('action'=>'add_msg','method'=>'POST','name'=>'frmAddMessage_'.$itemVal['id'],'id'=>'frmAddMessage_'.$itemVal['id'])); ?>
<style>
	.testbox{
		width:99%; height:90px; padding:0px;
	}
</style>
<div class="row-wid overflow-h">
	<!--Comment Widget Left Start-->
	<?php if ($session->check('Message.flash')){?>
	<li>
		<?php 	echo $session->flash();?>
	</li>
	<?php }	?>
	<div class="comment-widget-left">
		<ul>
			<li>Comments</li>
			<li>
				<?php 
				if(!empty($form_id)){
					$errorflash='textbox form-textfield error_message_box cartwidth';
				}else{
					$errorflash='textbox form-textfield cartwidth';
				}
				echo $form->input("Order.message",array("label"=>false,"div"=>false,'rows'=>5,'cols'=>45,'maxlength'=>400, 'class'=>$errorflash,'showremain'=>"limitOne".$itemVal['id']));
				?>
				<p class="pad-tp smalr-fnt">Max. 400 characters, no HTML
				<br />
					Remaining characters: <span id ="limitOne<?php echo $itemVal['id'];?>"><?php if(!empty($this->data)){
						if(!empty($this->data['Order']['message'])) { 
							$remain = 400 - strlen($this->data['Order']['message']);
							echo $remain;
						} else {
							echo '400'; 
						} 
					} else { 
						echo '400'; } ?>
				</span></p>
			</li>
		</ul>
	</div>
	<!--Comment Widget Right Closed-->

	<!--Comment Widget Right Start-->
	<div class="comment-widget-right">
		<ul>
		<li>
			<div class="comment-ins-height margin-top20">Choiceful.com uses filtering technology to project buyers and sellers and to identify possible fraud.</div>
		</li>
		<li>	
		<?php
		echo $form->hidden('Item.seller_id1',array('value'=>$itemVal['seller_id']));
		echo $form->hidden('Item.id',array('value'=>$itemVal['id']));
		?>

			<?php echo $form->hidden('Order.to_user_id',array('label'=>false,'div'=>false, 'value'=>$itemVal['seller_id']));?>
			<?php //$new_options = $options.'_'.$itemVal['id'];
				$options = array(
				"url"=>"/orders/add_msg","before"=>"",
				"update"=>"msg_".$itemVal['id'],
				"indicator"=>"plsLoaderID",
				'loading'=>"Element.show('plsLoaderID')",
				"complete"=>"Element.hide('plsLoaderID')",
				"class" =>"blk-bg-input-small",
				"type"=>"Submit",
				"id"=>"message".$itemVal['id'],
			);?>
			<?php //echo $ajax->submit('Change Name',$options);?>
			<?php //echo $ajax->submit('Submit',$options);?>
			
			<?php echo $form->submit('Submit',array('class'=>'blk-bg-input-small','div'=>false,'id'=>'','onclick'=>"this.disabled=true;this.value='Submit';this.form.submit();"));?>


		</li>
		</ul>
	</div>
	<!--Comment Widget Right Closed-->
</div>
<!--Row Closed-->
<!--Previous Message Start-->
<div class="previous-message-widget">
	<!--Message Start-->
	<h4 class="yellow-heading sml-fnt">Previous Messages</h4>
	<ul class="previous-message-sec">
		<?php 
		if(!empty($itemVal['Message'])){ 
		foreach($itemVal['Message'] AS $mKey=>$mVal){
			if($mVal['from_user_id'] == -1 && $mVal['to_user_id'] != $this->Session->read('User.id')){

			} else{
		?>
			<?php if($mVal['msg_from'] == 'B'){ // msg from buyer to seller ?>
			<li><strong>Your message to <?php echo $itemVal['seller_name']; ?> on <?php echo date("d F Y", strtotime($mVal['created'])); ?></strong></li>
			<?php }else if($mVal['msg_from'] == 'A') {?>
			<li><strong>Message from choiceful.com  on <?php echo date("d F Y", strtotime($mVal['created'])); ?></strong></li>
			<?php } else {?>
			<li><strong>Message from <?php echo $itemVal['seller_name']; ?> on <?php echo date("d F Y", strtotime($mVal['created'])); ?></strong></li>
			<?php }?>
			<li>Re: Order number <?php echo $itemVal['order_id'];?>, Item: <?php echo $itemVal['product_name'];?></li>
			<li class="message1">
				<p><?php echo $this->Common->currencyEnter(wordwrap($mVal['message'], 80, "\n")); ?></p>
			</li>
		<?php } }
		}else{ ?>
			<li style="color:#969696;"><strong>No previous message found</strong></li>
		<?php } ?>
	</ul>
	
</div>
<!--Previous Message Closed-->
<div class="clear"></div>
<?php echo $form->end(); ?>