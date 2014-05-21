<?php
$seller_id = $this->Session->read('User.id');
$msg_flg = 0;
echo $form->create('Order',array('action'=>'contact_sellers','method'=>'POST','name'=>'frmAddMessage_'.$itemVal['id'],'id'=>'frmAddMessage_'.$itemVal['id'])); ?>
<?php if ($session->check('Message.flash')){?>
	<li><?php echo $session->flash();?></li>
	<?php } ?>
<span id="plsLoaderID" style="display:none; text-align:center; margin-left:50%" class="dimmer"><?php echo $html->image("loading.gif" ,array('alt'=>"Loading" ,  'style'=>'position:fixed;left:30%;top:40%;z-index:999;'));?>
</span>
<li>
	<p>Type your message in the box below.</p>
	<p class="margin pad-rt2">
		<?php echo $form->input("Order.message",array('style'=>'width:100%; height:90px; padding:0px;', "label"=>false,"div"=>false,'rows'=>5,'maxlength'=>500, 'cols'=>30, 'class'=>'full-width textfield')); ?>
		<?php
		echo $form->hidden('Item.seller_id1',array('value'=>$itemVal['seller_id']));
		echo $form->hidden('Item.id',array('value'=>$itemVal['id']));
		?>
	</p>
</li>
<li class="overflow-h">
	<div class="lft-con"><p class="font11">Choiceful.com uses filtering technology to protect buyers and sellers and to Identify possible fraud. Messages that fail this filtering - even if they are not fraudulent - will not be transmitted.</p></div>
	<div class="floatr">
		<?php echo $form->hidden('Order.to_user_id',array('label'=>false,'div'=>false, 'value'=>$itemVal['seller_id']));?>
			<?php //$new_options = $options.'_'.$itemVal['id'];
				$options = array(
				"url"=>"/orders/add_msg","before"=>"",
				"update"=>"msg_".$itemVal['id'],
				"indicator"=>"plsLoaderID",
				'loading'=>"Element.show('plsLoaderID')",
				"complete"=>"Element.hide('plsLoaderID')",
				"class" =>"blkgradbtn",
				"type"=>"Submit",
				"id"=>"message".$itemVal['id'],
			);?>
			<?php echo $ajax->submit('Submit',$options);?>
			
		<!--<input type="button" class="blkgradbtn" value="Submit">-->
	</div>
</li>
<!--Previous Message Closed-->
<li>
<div class="clear"></div>
<!--Previous Message Start-->
<div class="previous-message-widget">
	<!--Message Start-->
	<h4 class="yellow-heading greentxt">Previous Messages</h4>
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
				<p><?php echo wordwrap($mVal['message'], 80, "\n"); ?></p>
			</li>
		<?php } }
		}else{ ?>
			<li><strong>No previous message found</strong></li>
		<?php } ?>
	</ul>
	
</div>
<!--Previous Message Closed-->
</li>
<?php echo $form->end(); ?>